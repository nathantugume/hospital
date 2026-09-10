<?php

namespace Tests\Feature\Web;

use App\Models\Company;
use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Staff;
use App\Models\User;
use Tests\TestCase;

class PrescriptionLifecycleTest extends TestCase
{
    public function test_doctor_creates_edits_renews_and_discontinues_without_reducing_stock(): void
    {
        $company=$this->company('RX-A');
        $doctor=Staff::create(['company_id'=>$company->id,'code'=>'ST-RX-DOC','first_name'=>'Rx','last_name'=>'Doctor','email'=>'rx.doctor@example.test','phone'=>'+256701000001','role'=>'Doctor','specialization'=>'General','status'=>'Active']);
        $user=User::factory()->create(['company_id'=>$company->id,'staff_id'=>$doctor->id,'role'=>'doctor']);
        $patient=Patient::factory()->create(['company_id'=>$company->id]);
        $medicine=Medicine::create(['code'=>'MED-RX','name'=>'Amoxicillin','stock'=>100,'status'=>'In Stock']);
        $response=$this->actingAs($user)->post(route('web.prescriptions.store'),['patient_id'=>$patient->id,'date'=>today()->toDateString(),'refills'=>2,'notes'=>'Initial','items'=>[['medicine_id'=>$medicine->id,'medication'=>'Amoxicillin','dosage'=>'500mg','frequency'=>'Twice daily','route'=>'Oral','duration'=>7,'duration_unit'=>'Days']]]);
        $rx=Prescription::where('patient_id',$patient->id)->latest('id')->firstOrFail();
        $response->assertRedirect(route('web.prescriptions.show',$rx));
        $this->assertSame(100,$medicine->fresh()->stock);
        $this->actingAs($user)->put(route('web.prescriptions.update',$rx),['date'=>today()->toDateString(),'refills'=>2,'notes'=>'Updated','items'=>[['medicine_id'=>$medicine->id,'medication'=>'Amoxicillin','dosage'=>'250mg','frequency'=>'Three times daily','route'=>'Oral','duration'=>5,'duration_unit'=>'Days']]])->assertRedirect(route('web.prescriptions.show',$rx));
        $this->assertSame('250mg',$rx->fresh()->items()->first()->dosage);
        $this->actingAs($user)->post(route('web.prescriptions.renew',$rx))->assertRedirect();
        $this->assertSame(1,$rx->fresh()->refills);
        $renewed=Prescription::where('patient_id',$patient->id)->whereKeyNot($rx->id)->latest('id')->firstOrFail();
        $this->assertSame(1,$renewed->refills);
        $this->assertSame(1,$renewed->items()->count());
        $this->actingAs($user)->patch(route('web.prescriptions.discontinue',$renewed))->assertRedirect();
        $this->assertSame('Discontinued',$renewed->fresh()->status);
    }

    public function test_patient_sees_only_their_own_prescriptions(): void
    {
        $company=$this->company('RX-B'); $patient=Patient::factory()->create(['company_id'=>$company->id]); $other=Patient::factory()->create(['company_id'=>$company->id]);
        $user=User::factory()->create(['company_id'=>$company->id,'patient_id'=>$patient->id,'role'=>'patient']);
        $own=Prescription::create(['code'=>'RX-OWN','patient_id'=>$patient->id,'date'=>today(),'status'=>'Active']);
        $foreign=Prescription::create(['code'=>'RX-OTHER','patient_id'=>$other->id,'date'=>today(),'status'=>'Active']);
        $this->actingAs($user)->get(route('web.prescriptions.index'))->assertOk()->assertSee('RX-OWN')->assertDontSee('RX-OTHER');
        $this->actingAs($user)->get(route('web.prescriptions.show',$foreign))->assertForbidden();
        $this->actingAs($user)->get(route('web.prescriptions.show',$own))->assertOk();
    }

    public function test_pharmacist_dispenses_an_active_prescription_and_records_stock_movement(): void
    {
        [$user, $patient, $prescription, $medicine, $batch] = $this->dispensingFixture('RX-C');
        $item = $prescription->items()->firstOrFail();

        $this->actingAs($user)->post(route('web.prescriptions.dispense', $prescription), [
            'dispense' => [$item->id => ['batch_id' => $batch->id, 'quantity' => 3]],
        ])->assertRedirect();

        $this->assertSame('Dispensed', $prescription->fresh()->status);
        $this->assertSame(7, $medicine->fresh()->stock);
        $this->assertSame(7, $batch->fresh()->quantity);
        $this->assertDatabaseHas('prescription_dispenses', [
            'prescription_id' => $prescription->id,
            'prescription_item_id' => $item->id,
            'medicine_batch_id' => $batch->id,
            'quantity' => 3,
            'patient_id' => $patient->id,
            'dispensed_by' => $user->id,
        ]);
        $this->assertDatabaseHas('medicine_transactions', [
            'medicine_id' => $medicine->id,
            'medicine_batch_id' => $batch->id,
            'type' => 'Dispensed',
            'quantity' => 3,
            'patient_id' => $patient->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)->post(route('web.prescriptions.dispense', $prescription), [
            'dispense' => [$item->id => ['batch_id' => $batch->id, 'quantity' => 1]],
        ])->assertConflict();
        $this->assertSame(7, $medicine->fresh()->stock);
        $this->assertSame(1, $prescription->dispenses()->count());
    }

    public function test_dispensing_rejects_expired_or_insufficient_batches_without_partial_stock_changes(): void
    {
        [$user, , $prescription, $medicine, $batch] = $this->dispensingFixture('RX-D');
        $item = $prescription->items()->firstOrFail();
        $batch->update(['expiry_date' => today()->subDay()]);

        $this->actingAs($user)->post(route('web.prescriptions.dispense', $prescription), [
            'dispense' => [$item->id => ['batch_id' => $batch->id, 'quantity' => 2]],
        ])->assertSessionHasErrors("dispense.{$item->id}.batch_id");
        $this->assertSame(10, $medicine->fresh()->stock);
        $this->assertSame(10, $batch->fresh()->quantity);
        $this->assertDatabaseCount('prescription_dispenses', 0);

        $batch->update(['expiry_date' => today()->addMonth(), 'quantity' => 1]);
        $this->actingAs($user)->post(route('web.prescriptions.dispense', $prescription), [
            'dispense' => [$item->id => ['batch_id' => $batch->id, 'quantity' => 2]],
        ])->assertSessionHasErrors("dispense.{$item->id}.quantity");
        $this->assertSame(10, $medicine->fresh()->stock);
        $this->assertSame(1, $batch->fresh()->quantity);
        $this->assertSame('Active', $prescription->fresh()->status);
    }

    private function dispensingFixture(string $code): array
    {
        $company = $this->company($code);
        $user = User::factory()->create(['company_id' => $company->id, 'role' => 'pharmacist']);
        $patient = Patient::factory()->create(['company_id' => $company->id]);
        $medicine = Medicine::create(['code' => 'MED-'.$code, 'name' => 'Ceftriaxone', 'stock' => 10, 'status' => 'In Stock']);
        $batch = MedicineBatch::create(['medicine_id' => $medicine->id, 'batch_number' => 'B-'.$code, 'expiry_date' => today()->addMonth(), 'quantity' => 10, 'status' => 'Active']);
        $prescription = Prescription::create(['code' => $code, 'patient_id' => $patient->id, 'date' => today(), 'status' => 'Active']);
        $prescription->items()->create(['medicine_id' => $medicine->id, 'medication' => $medicine->name, 'dosage' => '1 vial', 'frequency' => 'Once daily', 'route' => 'IV']);

        return [$user, $patient, $prescription, $medicine, $batch];
    }

    private function company(string $code): Company { return Company::create(['code'=>$code,'name'=>$code,'email'=>strtolower($code).'@example.test','contact_person'=>'Admin','phone'=>'+256701000000','city'=>'Kampala']); }
}
