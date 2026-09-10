<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LabEquipment;
use App\Models\LabTest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LabCatalogueController extends Controller
{
    public function tests(Request $request): View { $this->authorize('viewAny',LabTest::class); return view('laboratory.catalogue',['tests'=>LabTest::forCompany($request->user())->orderBy('name')->paginate(20)]); }
    public function createTest(): View { $this->authorize('create',LabTest::class); return view('laboratory.test-form'); }
    public function storeTest(Request $request): RedirectResponse { $this->authorize('create',LabTest::class); LabTest::create($this->testData($request)+['company_id'=>$request->user()->company_id]); return redirect()->route('web.laboratory.catalogue')->with('status','Lab test created.'); }
    public function editTest(LabTest $labTest): View { $this->authorize('update',$labTest); return view('laboratory.test-form',compact('labTest')); }
    public function updateTest(Request $request,LabTest $labTest): RedirectResponse { $this->authorize('update',$labTest); $labTest->update($this->testData($request,$labTest)); return redirect()->route('web.laboratory.catalogue')->with('status','Lab test updated.'); }
    public function destroyTest(LabTest $labTest): RedirectResponse { $this->authorize('delete',$labTest); $labTest->update(['status'=>'Inactive']); return back()->with('status','Lab test deactivated.'); }
    public function equipment(Request $request): View { $this->authorize('viewAny',LabEquipment::class); return view('laboratory.equipment',['equipment'=>LabEquipment::forCompany($request->user())->orderBy('name')->paginate(20)]); }
    public function createEquipment(): View { $this->authorize('create',LabEquipment::class); return view('laboratory.equipment-form'); }
    public function storeEquipment(Request $request): RedirectResponse { $this->authorize('create',LabEquipment::class); LabEquipment::create($this->equipmentData($request)+['company_id'=>$request->user()->company_id]); return redirect()->route('web.laboratory.equipment')->with('status','Equipment created.'); }
    public function editEquipment(LabEquipment $labEquipment): View { $this->authorize('update',$labEquipment); return view('laboratory.equipment-form',compact('labEquipment')); }
    public function updateEquipment(Request $request,LabEquipment $labEquipment): RedirectResponse { $this->authorize('update',$labEquipment); $labEquipment->update($this->equipmentData($request,$labEquipment)); return redirect()->route('web.laboratory.equipment')->with('status','Equipment updated.'); }
    public function destroyEquipment(LabEquipment $labEquipment): RedirectResponse { $this->authorize('delete',$labEquipment); $labEquipment->update(['status'=>'Decommissioned']); return back()->with('status','Equipment decommissioned.'); }
    private function testData(Request $r,?LabTest $m=null): array { return $r->validate(['code'=>['required','string','max:50',Rule::unique('lab_tests')->ignore($m?->id)],'name'=>['required','string','max:255'],'department'=>['nullable','string','max:100'],'sample_type'=>['nullable','string','max:50'],'price'=>['required','numeric','min:0'],'currency'=>['required','string','size:3'],'target_turnaround_hours'=>['nullable','numeric','min:0'],'status'=>['required',Rule::in(['Active','Inactive'])]]); }
    private function equipmentData(Request $r,?LabEquipment $m=null): array { return $r->validate(['code'=>['required','string','max:20',Rule::unique('lab_equipment')->ignore($m?->id)],'name'=>['required','string','max:255'],'department'=>['nullable','string','max:100'],'serial_number'=>['nullable','string','max:100'],'last_maintenance'=>['nullable','date'],'next_maintenance'=>['nullable','date','after_or_equal:last_maintenance'],'status'=>['required',Rule::in(['Operational','Maintenance','Repair','Decommissioned'])],'location'=>['nullable','string','max:100'],'manufacturer'=>['nullable','string','max:255'],'notes'=>['nullable','string','max:2000']]); }
}
