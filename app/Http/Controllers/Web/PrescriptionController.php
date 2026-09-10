<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Services\PrescriptionDispensingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class PrescriptionController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Prescription::class);
        $query = Prescription::forCompany($request->user())->with(['patient','doctor','items']);
        if ($request->user()->isPatient()) { $query->where('patient_id',$request->user()->patient_id); }
        $prescriptions=$query->when($request->string('status')->trim()->value(),fn($q,$status)=>$q->where('status',$status))->latest('date')->paginate(20)->withQueryString();
        return view('prescriptions.index',compact('prescriptions'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Prescription::class);

        $patients = Patient::forCompany($request->user())->orderBy('first_name')->orderBy('last_name')->get(['id', 'code', 'first_name', 'last_name']);
        $medicines = Medicine::orderBy('name')->get(['id', 'name', 'generic_name', 'code']);

        $selectedPatientId = $request->integer('patient_id') ?: null;
        $recentPrescriptions = collect();

        if ($selectedPatientId) {
            $recentPrescriptions = Prescription::forCompany($request->user())->where('patient_id', $selectedPatientId)
                ->latest('date')
                ->limit(5)
                ->get();
        }

        return view('prescriptions.create', compact('patients', 'medicines', 'selectedPatientId', 'recentPrescriptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Prescription::class);
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'date' => ['required', 'date'],
            'refills' => ['nullable', 'integer', 'min:0', 'max:12'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.medicine_id' => ['nullable', 'exists:medicines,id'],
            'items.*.medication' => ['required', 'string', 'max:255'],
            'items.*.dosage' => ['required', 'string', 'max:50'],
            'items.*.frequency' => ['required', 'string', 'max:100'],
            'items.*.route' => ['required', 'string', 'max:30'],
            'items.*.duration' => ['nullable', 'integer', 'min:1'],
            'items.*.duration_unit' => ['nullable', 'string', 'max:10'],
            'items.*.instructions' => ['nullable', 'string', 'max:500'],
        ]);

        abort_unless(Patient::forCompany($request->user())->whereKey($validated['patient_id'])->exists(), 422);

        $doctorId = $request->user()->staff?->id;

        $prescription = DB::transaction(function () use ($validated,$doctorId): Prescription {
            $prescription = Prescription::create(['code'=>'RX-'.strtoupper(substr((string)str()->uuid(),0,8)),'patient_id'=>$validated['patient_id'],'doctor_id'=>$doctorId,'date'=>$validated['date'],'status'=>'Active','refills'=>$validated['refills']??0,'notes'=>$validated['notes']??null]);
            foreach ($validated['items'] as $item) { $prescription->items()->create([
                'medication' => $item['medication'],
                'medicine_id' => $item['medicine_id'] ?? null,
                'dosage' => $item['dosage'],
                'frequency' => $item['frequency'],
                'route' => $item['route'],
                'duration' => $item['duration'] ?? null,
                'duration_unit' => $item['duration_unit'] ?? 'Days',
                'instructions' => $item['instructions'] ?? null,
            ]); }
            return $prescription;
        });

        return redirect()
            ->route('web.prescriptions.show',$prescription)
            ->with('status', "Prescription {$prescription->code} created successfully.");
    }

    public function show(Prescription $prescription): View { $this->authorize('view',$prescription); $prescription->load(['patient','doctor','dispenses','items.medicine.batches'=>fn($q)=>$q->where('status','Active')->where('quantity','>',0)->whereDate('expiry_date','>=',today())->orderBy('expiry_date')]); return view('prescriptions.show',compact('prescription')); }
    public function edit(Request $request,Prescription $prescription): View { $this->authorize('update',$prescription); abort_unless($prescription->status==='Active',409); $prescription->load('items'); return view('prescriptions.edit',['prescription'=>$prescription,'medicines'=>Medicine::orderBy('name')->get()]); }
    public function update(Request $request,Prescription $prescription): RedirectResponse
    {
        $this->authorize('update',$prescription); abort_unless($prescription->status==='Active',409);
        $data=$request->validate(['date'=>['required','date'],'refills'=>['required','integer','min:0','max:12'],'notes'=>['nullable','string','max:2000'],'items'=>['required','array','min:1'],'items.*.medicine_id'=>['nullable','exists:medicines,id'],'items.*.medication'=>['required','string','max:255'],'items.*.dosage'=>['required','string','max:50'],'items.*.frequency'=>['required','string','max:100'],'items.*.route'=>['required','string','max:30'],'items.*.duration'=>['nullable','integer','min:1'],'items.*.duration_unit'=>['nullable','string','max:10'],'items.*.instructions'=>['nullable','string','max:500']]);
        DB::transaction(function()use($prescription,$data){$prescription->update(['date'=>$data['date'],'refills'=>$data['refills'],'notes'=>$data['notes']??null]);$prescription->items()->delete();foreach($data['items'] as $item){$prescription->items()->create($item);}});
        return redirect()->route('web.prescriptions.show',$prescription)->with('status','Prescription updated.');
    }
    public function discontinue(Prescription $prescription): RedirectResponse { $this->authorize('update',$prescription); abort_unless($prescription->status==='Active',409); $prescription->update(['status'=>'Discontinued']); return back()->with('status','Prescription discontinued.'); }
    public function renew(Request $request,Prescription $prescription): RedirectResponse
    {
        $this->authorize('update',$prescription); abort_unless($prescription->refills>0 && in_array($prescription->status,['Active','Completed','Dispensed'],true),409);
        $new=DB::transaction(function()use($prescription,$request){$prescription->decrement('refills');$prescription->refresh();$copy=Prescription::create(['code'=>'RX-'.strtoupper(substr((string)str()->uuid(),0,8)),'patient_id'=>$prescription->patient_id,'doctor_id'=>$request->user()->staff_id??$prescription->doctor_id,'date'=>today(),'status'=>'Active','refills'=>$prescription->refills,'notes'=>$prescription->notes]);foreach($prescription->items as $item){$copy->items()->create($item->only(['medication','medicine_id','dosage','frequency','route','duration','duration_unit','instructions','refills_allowed','start_date','end_date']));}return $copy;});
        return redirect()->route('web.prescriptions.show',$new)->with('status','Prescription renewed.');
    }

    public function dispense(Request $request, Prescription $prescription, PrescriptionDispensingService $dispensing): RedirectResponse
    {
        $this->authorize('update',$prescription);
        abort_unless($request->user()->hasRole(['admin','super_admin','pharmacist']),403);
        $data=$request->validate(['dispense'=>['required','array'],'dispense.*.batch_id'=>['required','integer','exists:medicine_batches,id'],'dispense.*.quantity'=>['required','integer','min:1']]);
        $dispensing->dispense($prescription, $request->user(), $data['dispense']);
        return back()->with('status','Prescription dispensed successfully.');
    }
}
