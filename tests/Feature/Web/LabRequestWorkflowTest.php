<?php

namespace Tests\Feature\Web;

use App\Models\Company;
use App\Models\LabTest;
use App\Models\Patient;
use App\Models\TestRequest;
use App\Models\LabResult;
use App\Models\Staff;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Tests\TestCase;

class LabRequestWorkflowTest extends TestCase
{
    public function test_authorized_staff_create_a_request_with_selected_tests(): void
    {
        $company = Company::create(['code' => 'LAB-A', 'name' => 'Laboratory Hospital', 'email' => 'lab@example.test', 'contact_person' => 'Admin', 'phone' => '+256700770000', 'city' => 'Kampala']);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $patient = Patient::factory()->create(['company_id' => $company->id]);
        $cbc = LabTest::create(['code' => 'CBC-WEB', 'name' => 'Complete Blood Count', 'sample_type' => 'Blood', 'status' => 'Active']);
        $glucose = LabTest::create(['code' => 'GLU-WEB', 'name' => 'Blood Glucose', 'sample_type' => 'Blood', 'status' => 'Active']);

        $response = $this->actingAs($admin)->post(route('web.laboratory.requests.store'), [
            'patient_id' => $patient->id, 'lab_test_ids' => [$cbc->id, $glucose->id],
            'priority' => 'Urgent', 'requested_date' => today()->toDateString(), 'notes' => 'Fasting sample',
        ]);
        $record = TestRequest::where('patient_id', $patient->id)->firstOrFail();
        $response->assertRedirect(route('web.laboratory.requests.show', $record));
        $this->assertSame('Pending', $record->status);
        $this->assertEqualsCanonicalizing([$cbc->id, $glucose->id], $record->labTests()->pluck('lab_tests.id')->all());
        $this->actingAs($admin)->get(route('web.laboratory.requests.show', $record))->assertOk()->assertSee('Complete Blood Count')->assertSee('Blood Glucose');
        $this->actingAs($admin)->get('/test-requests.html')->assertRedirect(route('web.laboratory.requests'));
    }

    public function test_request_creation_rejects_another_company_patient(): void
    {
        $company = Company::create(['code' => 'LAB-B', 'name' => 'Hospital B', 'email' => 'labb@example.test', 'contact_person' => 'Admin', 'phone' => '+256700770010', 'city' => 'Kampala']);
        $other = Company::create(['code' => 'LAB-C', 'name' => 'Hospital C', 'email' => 'labc@example.test', 'contact_person' => 'Admin', 'phone' => '+256700770011', 'city' => 'Jinja']);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $patient = Patient::factory()->create(['company_id' => $other->id]);
        $test = LabTest::create(['code' => 'TENANT-LAB', 'name' => 'Tenant Test', 'status' => 'Active']);

        $this->actingAs($admin)->post(route('web.laboratory.requests.store'), ['patient_id' => $patient->id, 'lab_test_ids' => [$test->id], 'priority' => 'Routine', 'requested_date' => today()->toDateString()])->assertForbidden();
        $this->assertDatabaseMissing('test_requests', ['patient_id' => $patient->id]);
    }

    public function test_sample_collection_creates_results_once_and_advances_request(): void
    {
        $company = Company::create(['code' => 'LAB-D', 'name' => 'Collection Hospital', 'email' => 'labd@example.test', 'contact_person' => 'Admin', 'phone' => '+256700770020', 'city' => 'Kampala']);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $patient = Patient::factory()->create(['company_id' => $company->id]);
        $test = LabTest::create(['code' => 'COLLECT-LAB', 'name' => 'Collection Test', 'sample_type' => 'Blood', 'status' => 'Active']);
        $record = TestRequest::create(['code' => 'TR-COLLECT', 'patient_id' => $patient->id, 'priority' => 'Routine', 'status' => 'Pending', 'requested_date' => today()]);
        $record->labTests()->attach($test);

        $this->actingAs($admin)->post(route('web.laboratory.requests.collect', $record), ['sample_id' => 'SAMPLE-100', 'collection_date' => today()->toDateString()])->assertRedirect();
        $this->assertSame('Sample Collected', $record->fresh()->status);
        $this->assertDatabaseHas('lab_results', ['test_request_id' => $record->id, 'lab_test_id' => $test->id, 'sample_id' => 'SAMPLE-100-1', 'status' => 'Pending']);
        $this->actingAs($admin)->post(route('web.laboratory.requests.collect', $record), ['sample_id' => 'SAMPLE-100', 'collection_date' => today()->toDateString()])->assertStatus(409);
        $this->assertSame(1, \App\Models\LabResult::where('test_request_id', $record->id)->count());
    }

    public function test_result_entry_and_verification_follow_the_required_sequence(): void
    {
        $company = Company::create(['code' => 'LAB-E', 'name' => 'Result Hospital', 'email' => 'labe@example.test', 'contact_person' => 'Admin', 'phone' => '+256700770030', 'city' => 'Kampala']);
        $verifier = Staff::create(['company_id'=>$company->id,'code'=>'ST-LAB-VERIFY','first_name'=>'Lab','last_name'=>'Verifier','email'=>'verifier@example.test','phone'=>'+256700770031','role'=>'Lab Technician','status'=>'Active']);
        $admin = User::factory()->admin()->create(['company_id' => $company->id, 'staff_id' => $verifier->id]);
        $patient = Patient::factory()->create(['company_id' => $company->id]);
        $test = LabTest::create(['code' => 'RESULT-LAB', 'name' => 'Result Test', 'sample_type' => 'Blood', 'status' => 'Active']);
        $record = TestRequest::create(['code'=>'TR-RESULT','patient_id'=>$patient->id,'priority'=>'Routine','status'=>'Sample Collected','requested_date'=>today()]);
        $result = LabResult::create(['code'=>'LR-RESULT','sample_id'=>'S-RESULT','patient_id'=>$patient->id,'test_request_id'=>$record->id,'lab_test_id'=>$test->id,'test_name'=>$test->name,'result_date'=>today(),'collection_date'=>today(),'status'=>'Pending','flag'=>'Normal']);

        $this->actingAs($admin)->patch(route('web.laboratory.results.verify',$result))->assertStatus(409);
        $this->actingAs($admin)->put(route('web.laboratory.results.update',$result),['result_value'=>'220','normal_range'=>'70-140','unit'=>'mg/dL','flag'=>'High','notes'=>'Repeat fasting'])->assertRedirect(route('web.laboratory.results'));
        $this->assertSame('Completed',$result->fresh()->status);
        $this->assertSame('High',$result->fresh()->flag);
        $this->assertSame('Completed',$record->fresh()->status);
        $this->actingAs($admin)->patch(route('web.laboratory.results.verify',$result))->assertRedirect();
        $this->assertSame('Verified',$result->fresh()->status);
        $this->assertSame($verifier->id,$result->fresh()->verified_by);
        $this->assertNotNull($result->fresh()->verified_date);
        $this->actingAs($admin)->put(route('web.laboratory.results.update',$result),['result_value'=>'100','flag'=>'Normal'])->assertStatus(409);
    }

    public function test_private_attachment_and_revocable_expiring_share_link(): void
    {
        Storage::fake('local');
        $company = Company::create(['code'=>'LAB-F','name'=>'Sharing Hospital','email'=>'labf@example.test','contact_person'=>'Admin','phone'=>'+256700770040','city'=>'Kampala']);
        $staff = Staff::create(['company_id'=>$company->id,'code'=>'ST-LAB-SHARE','first_name'=>'Share','last_name'=>'Verifier','email'=>'share.verifier@example.test','phone'=>'+256700770041','role'=>'Lab Technician','status'=>'Active']);
        $admin = User::factory()->admin()->create(['company_id'=>$company->id,'staff_id'=>$staff->id]);
        $patient = Patient::factory()->create(['company_id'=>$company->id]);
        $result = LabResult::create(['code'=>'LR-SHARE','sample_id'=>'S-SHARE','patient_id'=>$patient->id,'test_name'=>'Verified Test','result_value'=>'Normal','result_date'=>today(),'status'=>'Verified','flag'=>'Normal','verified_by'=>$staff->id,'verified_date'=>now()]);

        $this->actingAs($admin)->post(route('web.laboratory.results.attachment.store',$result),['attachment'=>UploadedFile::fake()->create('report.pdf',100,'application/pdf')])->assertRedirect();
        $result->refresh();
        Storage::disk('local')->assertExists($result->attachment_url);
        $this->actingAs($admin)->get(route('web.laboratory.results.attachment.download',$result))->assertOk();

        $response=$this->actingAs($admin)->post(route('web.laboratory.results.share',$result));
        $response->assertRedirect();
        $shareUrl=session('share_url');
        $this->assertNotEmpty($shareUrl);
        $this->get($shareUrl)->assertOk()->assertSee('Verified Test')->assertSee($patient->full_name);
        $this->actingAs($admin)->delete(route('web.laboratory.results.share.revoke',$result))->assertRedirect();
        $this->get($shareUrl)->assertNotFound();
    }
}
