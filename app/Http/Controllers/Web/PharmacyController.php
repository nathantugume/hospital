<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\MedicineTransaction;
use App\Models\MedicineTemplate;
use App\Models\MedicationAdministration;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PharmacyController extends Controller
{
    public function index(Request $request): View
    {
        $medicines = Medicine::query()
            ->when($request->string('search')->trim()->value(), function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('generic_name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($request->string('stock')->trim()->value() === 'low', fn ($query) => $query->whereColumn('stock', '<=', 'reorder_level'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'catalogue' => Medicine::count(),
            'low_stock' => Medicine::whereColumn('stock', '<=', 'reorder_level')->count(),
            'out_of_stock' => Medicine::where('stock', '<=', 0)->count(),
            'expiring' => Medicine::whereNotNull('expiry')->whereBetween('expiry', [today(), today()->addDays(90)])->count(),
        ];
        $recentPrescriptions = Prescription::forCompany($request->user())->with(['patient', 'doctor'])->latest('date')->limit(6)->get();

        return view('pharmacy.index', compact('medicines', 'stats', 'recentPrescriptions'));
    }

    public function alerts(Request $request): View
    {
        $type = $request->string('type')->trim()->value() ?: 'all';

        $stats = [
            'low_stock' => Medicine::whereColumn('stock', '<=', 'reorder_level')->where('stock', '>', 0)->count(),
            'out_of_stock' => Medicine::where('stock', '<=', 0)->count(),
            'expiring' => Medicine::whereNotNull('expiry')->whereBetween('expiry', [today(), today()->addDays(30)])->count(),
            'catalogue' => Medicine::count(),
        ];

        $alerts = Medicine::query()
            ->where(function ($query): void {
                $query->whereColumn('stock', '<=', 'reorder_level')
                    ->orWhereBetween('expiry', [today(), today()->addDays(30)]);
            })
            ->when($type === 'low', fn ($query) => $query->whereColumn('stock', '<=', 'reorder_level')->where('stock', '>', 0))
            ->when($type === 'out', fn ($query) => $query->where('stock', '<=', 0))
            ->when($type === 'expiring', fn ($query) => $query->whereNotNull('expiry')->whereBetween('expiry', [today(), today()->addDays(30)]))
            ->orderBy('stock')
            ->paginate(20)
            ->withQueryString();

        return view('pharmacy.alerts', compact('alerts', 'stats', 'type'));
    }

    public function create(): View { $this->authorize('create', Medicine::class); return view('pharmacy.form', ['medicine'=>new Medicine]); }
    public function store(Request $request): RedirectResponse { $this->authorize('create',Medicine::class); $medicine=Medicine::create($this->validatedMedicine($request)); return redirect()->route('web.pharmacy.show',$medicine)->with('status','Medicine added.'); }
    public function show(Medicine $medicine): View { $this->authorize('view',$medicine); $medicine->load(['batches'=>fn($q)=>$q->orderBy('expiry_date'),'transactions'=>fn($q)=>$q->latest('date')->limit(30)]); return view('pharmacy.show',compact('medicine')); }
    public function edit(Medicine $medicine): View { $this->authorize('update',$medicine); return view('pharmacy.form',compact('medicine')); }
    public function update(Request $request,Medicine $medicine): RedirectResponse { $this->authorize('update',$medicine); $medicine->update($this->validatedMedicine($request,$medicine)); return redirect()->route('web.pharmacy.show',$medicine)->with('status','Medicine updated.'); }
    public function destroy(Medicine $medicine): RedirectResponse { $this->authorize('delete',$medicine); abort_if($medicine->transactions()->exists()||$medicine->prescriptionItems()->exists(),409,'Medicine with history cannot be deleted.'); $medicine->delete(); return redirect()->route('web.pharmacy.index')->with('status','Medicine deleted.'); }
    public function receiveBatch(Request $request,Medicine $medicine): RedirectResponse
    {
        $this->authorize('update',$medicine); $data=$request->validate(['batch_number'=>['required','string','max:100'],'mfg_date'=>['nullable','date'],'expiry_date'=>['required','date','after:today'],'quantity'=>['required','integer','min:1'],'reference'=>['nullable','string','max:100']]);
        DB::transaction(function()use($medicine,$request,$data){$locked=Medicine::lockForUpdate()->findOrFail($medicine->id);$batch=$locked->batches()->create($data+['status'=>'Active']);$locked->increment('stock',$data['quantity']);$locked->update(['expiry'=>$locked->batches()->where('status','Active')->min('expiry_date'),'status'=>'In Stock']);MedicineTransaction::create(['medicine_id'=>$locked->id,'medicine_batch_id'=>$batch->id,'date'=>today(),'type'=>'Received','quantity'=>$data['quantity'],'reference'=>$data['reference']??$batch->batch_number,'user_id'=>$request->user()->id,'user_name'=>$request->user()->name,'notes'=>'Batch received']);});
        return back()->with('status','Batch received and stock updated.');
    }
    public function administrations(Request $request): View { abort_unless($request->user()->hasRole(['super_admin','admin','doctor','nurse','pharmacist']),403); $administrations=MedicationAdministration::whereHas('patient',fn($q)=>$q->when(!$request->user()->isSuperAdmin(),fn($q)=>$q->where('company_id',$request->user()->company_id)))->with(['patient','medicine','administeredBy'])->latest()->paginate(20);$patients=Patient::forCompany($request->user())->orderBy('first_name')->get();$medicines=Medicine::orderBy('name')->get();return view('pharmacy.administrations',compact('administrations','patients','medicines')); }
    public function storeAdministration(Request $request): RedirectResponse { abort_unless($request->user()->hasRole(['super_admin','admin','doctor','nurse']),403);$data=$request->validate(['patient_id'=>['required','exists:patients,id'],'medicine_id'=>['nullable','exists:medicines,id'],'medication'=>['required','string','max:255'],'dosage'=>['required','string','max:50'],'scheduled_time'=>['required','date_format:H:i']]);abort_unless(Patient::forCompany($request->user())->whereKey($data['patient_id'])->exists(),422);MedicationAdministration::create($data+['status'=>'Pending']);return back()->with('status','Administration scheduled.'); }
    public function administer(Request $request,MedicationAdministration $administration): RedirectResponse { abort_unless($request->user()->hasRole(['super_admin','admin','doctor','nurse']),403);abort_unless($administration->patient?->company_id===$request->user()->company_id||$request->user()->isSuperAdmin(),403);abort_unless($administration->status==='Pending',409);$administration->update(['status'=>'Administered','administered_at'=>now(),'administered_by'=>$request->user()->staff_id]);return back()->with('status','Medication administration recorded.'); }
    public function templates(Request $request): View { abort_unless($request->user()->hasRole(['super_admin','admin','doctor','pharmacist']),403);$templates=MedicineTemplate::where(fn($q)=>$q->where('company_id',$request->user()->company_id)->orWhereNull('company_id'))->with('creator')->when($request->string('search')->value(),fn($q,$s)=>$q->where('name','like',"%{$s}%"))->latest()->paginate(20);return view('pharmacy.templates',compact('templates')); }
    public function storeTemplate(Request $request): RedirectResponse { abort_unless($request->user()->hasRole(['super_admin','admin','doctor','pharmacist']),403);$data=$request->validate(['name'=>['required','string','max:255'],'category'=>['nullable','string','max:100'],'description'=>['nullable','string','max:1000'],'medications'=>['required','array','min:1'],'medications.*.name'=>['required','string','max:255'],'medications.*.dosage'=>['required','string','max:50'],'medications.*.route'=>['required','string','max:30'],'medications.*.frequency'=>['required','string','max:100'],'medications.*.instructions'=>['nullable','string','max:500']]);MedicineTemplate::create($data+['company_id'=>$request->user()->company_id,'created_by'=>$request->user()->id]);return back()->with('status','Medicine template created.'); }
    public function destroyTemplate(Request $request,MedicineTemplate $medicineTemplate): RedirectResponse { abort_unless($request->user()->hasRole(['super_admin','admin','doctor','pharmacist']),403);abort_unless($request->user()->isSuperAdmin()||$medicineTemplate->company_id===$request->user()->company_id,403);$medicineTemplate->delete();return back()->with('status','Medicine template deleted.'); }

    private function validatedMedicine(Request $request,?Medicine $medicine=null): array { return $request->validate(['code'=>['required','string','max:20','unique:medicines,code,'.($medicine?->id??'NULL')],'name'=>['required','string','max:255'],'generic_name'=>['nullable','string','max:255'],'category'=>['nullable','string','max:100'],'type'=>['required','in:prescription,otc,controlled'],'manufacturer'=>['nullable','string','max:255'],'selling_price'=>['required','numeric','min:0'],'currency'=>['required','string','size:3'],'reorder_level'=>['required','integer','min:0'],'barcode'=>['nullable','string','max:100']]); }
}
