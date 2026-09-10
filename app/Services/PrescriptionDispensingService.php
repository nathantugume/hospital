<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\MedicineTransaction;
use App\Models\Prescription;
use App\Models\PrescriptionDispense;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PrescriptionDispensingService
{
    public function dispense(Prescription $prescription, User $user, array $entries): Prescription
    {
        return DB::transaction(function () use ($prescription, $user, $entries): Prescription {
            $locked = Prescription::query()->lockForUpdate()->findOrFail($prescription->id);

            abort_unless($locked->status === 'Active', 409, 'Only active prescriptions can be dispensed.');

            $items = $locked->items()->get();
            if ($items->isEmpty() || $items->contains(fn ($item): bool => $item->medicine_id === null)) {
                throw ValidationException::withMessages([
                    'dispense' => 'Every prescription item must reference a catalogue medicine before dispensing.',
                ]);
            }

            foreach ($items as $item) {
                $entry = $entries[$item->id] ?? null;
                if (! $entry) {
                    throw ValidationException::withMessages([
                        "dispense.{$item->id}" => 'Batch and quantity are required for every medication.',
                    ]);
                }

                abort_if(
                    PrescriptionDispense::where('prescription_item_id', $item->id)->exists(),
                    409,
                    'This prescription item has already been dispensed.'
                );

                $batch = MedicineBatch::query()->lockForUpdate()->findOrFail($entry['batch_id']);
                if ($batch->medicine_id !== $item->medicine_id
                    || $batch->status !== 'Active'
                    || $batch->expiry_date->isBefore(today())) {
                    throw ValidationException::withMessages([
                        "dispense.{$item->id}.batch_id" => 'Select an active, unexpired batch for this medicine.',
                    ]);
                }

                if ($batch->quantity < $entry['quantity']) {
                    throw ValidationException::withMessages([
                        "dispense.{$item->id}.quantity" => 'The selected batch does not have enough stock.',
                    ]);
                }

                $medicine = Medicine::query()->lockForUpdate()->findOrFail($item->medicine_id);
                if ($medicine->stock < $entry['quantity']) {
                    throw ValidationException::withMessages([
                        "dispense.{$item->id}.quantity" => 'Medicine stock is insufficient.',
                    ]);
                }

                $batch->decrement('quantity', $entry['quantity']);
                $medicine->decrement('stock', $entry['quantity']);

                PrescriptionDispense::create([
                    'prescription_id' => $locked->id,
                    'prescription_item_id' => $item->id,
                    'medicine_id' => $medicine->id,
                    'medicine_batch_id' => $batch->id,
                    'quantity' => $entry['quantity'],
                    'patient_id' => $locked->patient_id,
                    'dispensed_by' => $user->id,
                    'dispensed_at' => now(),
                ]);

                MedicineTransaction::create([
                    'medicine_id' => $medicine->id,
                    'medicine_batch_id' => $batch->id,
                    'date' => today(),
                    'type' => 'Dispensed',
                    'quantity' => $entry['quantity'],
                    'reference' => $locked->code.'-'.$item->id,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'patient_id' => $locked->patient_id,
                    'notes' => 'Prescription dispensing',
                ]);
            }

            $locked->update(['status' => 'Dispensed']);

            return $locked->fresh(['items', 'dispenses']);
        });
    }
}
