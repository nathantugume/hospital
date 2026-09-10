<?php

namespace Tests\Feature\Web;

use App\Models\Company;
use App\Models\LabEquipment;
use App\Models\LabResult;
use App\Models\LabTest;
use App\Models\Notification;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\User;
use Tests\TestCase;

class PhaseFourCompletionTest extends TestCase
{
    public function test_tenant_admin_manages_own_catalogue_and_equipment_only(): void
    {
        $company=$this->company('LAB-CAT-A'); $other=$this->company('LAB-CAT-B');
        $admin=User::factory()->admin()->create(['company_id'=>$company->id]);
        $this->actingAs($admin)->post(route('web.laboratory.catalogue.store'),['code'=>'CAT-A','name'=>'Tenant CBC','sample_type'=>'Blood','price'=>25000,'currency'=>'UGX','status'=>'Active'])->assertRedirect(route('web.laboratory.catalogue'));
        $test=LabTest::where('code','CAT-A')->firstOrFail(); $this->assertSame($company->id,$test->company_id);
        $this->actingAs($admin)->post(route('web.laboratory.equipment.store'),['code'=>'EQ-A','name'=>'Analyzer','serial_number'=>'SN-1','status'=>'Operational'])->assertRedirect(route('web.laboratory.equipment'));
        $equipment=LabEquipment::where('code','EQ-A')->firstOrFail(); $this->assertSame($company->id,$equipment->company_id);
        $foreign=LabTest::create(['company_id'=>$other->id,'code'=>'CAT-B','name'=>'Foreign Test','price'=>0,'status'=>'Active']);
        $this->actingAs($admin)->get(route('web.laboratory.catalogue.edit',$foreign))->assertForbidden();
        $this->actingAs($admin)->get(route('web.laboratory.catalogue'))->assertOk()->assertSee('Tenant CBC')->assertDontSee('Foreign Test');
    }

    public function test_abnormal_notifications_are_created_only_after_verification(): void
    {
        $company=$this->company('LAB-NOTIFY');
        $doctor=Staff::create(['company_id'=>$company->id,'code'=>'ST-LAB-DOC','first_name'=>'Ordering','last_name'=>'Doctor','email'=>'ordering@example.test','phone'=>null,'role'=>'Doctor','status'=>'Active']);
        $verifier=Staff::create(['company_id'=>$company->id,'code'=>'ST-LAB-VER','first_name'=>'Lab','last_name'=>'Verifier','email'=>'lab-verifier@example.test','phone'=>null,'role'=>'Lab Technician','status'=>'Active']);
        $doctorUser=User::factory()->create(['company_id'=>$company->id,'staff_id'=>$doctor->id,'role'=>'doctor']);
        $verifierUser=User::factory()->create(['company_id'=>$company->id,'staff_id'=>$verifier->id,'role'=>'lab_technician']);
        $patient=Patient::factory()->create(['company_id'=>$company->id]);
        $patientUser=User::factory()->create(['company_id'=>$company->id,'patient_id'=>$patient->id,'role'=>'patient']);
        $result=LabResult::create(['code'=>'LR-NOTIFY','patient_id'=>$patient->id,'test_name'=>'Potassium','result_value'=>'7.1','normal_range'=>'3.5-5.0','unit'=>'mmol/L','result_date'=>today(),'status'=>'Completed','flag'=>'Critical','ordered_by'=>$doctor->id]);
        $this->assertSame(0,Notification::whereIn('user_id',[$doctorUser->id,$patientUser->id])->count());
        $this->actingAs($verifierUser)->patch(route('web.laboratory.results.verify',$result))->assertRedirect();
        $this->assertDatabaseHas('notifications',['user_id'=>$doctorUser->id,'type'=>'abnormal_lab_result']);
        $this->assertDatabaseHas('notifications',['user_id'=>$patientUser->id,'type'=>'abnormal_lab_result']);
        $this->assertSame('Verified',$result->fresh()->status);
    }

    private function company(string $code): Company { return Company::create(['code'=>$code,'name'=>$code,'email'=>strtolower($code).'@example.test','contact_person'=>'Admin','phone'=>'+256700990000','city'=>'Kampala']); }
}
