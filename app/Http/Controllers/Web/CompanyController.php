<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View { $this->authorize('viewAny', Company::class); return view('companies.index', ['companies' => Company::withCount(['staff','patients'])->with('subscriptions')->orderBy('name')->paginate(20)]); }
    public function create(): View { $this->authorize('create', Company::class); return view('companies.create'); }
    public function store(Request $request): RedirectResponse { $this->authorize('create', Company::class); $company = Company::create($this->attributes($request)); return redirect()->route('web.companies.show',$company)->with('status','Company created successfully.'); }
    public function show(Company $company): View { $this->authorize('view',$company); $company->load(['subscriptions'=>fn($q)=>$q->latest('created_on')])->loadCount(['staff','patients','users']); return view('companies.show',compact('company')); }
    public function edit(Company $company): View { $this->authorize('update',$company); return view('companies.edit',compact('company')); }
    public function update(Request $request, Company $company): RedirectResponse { $this->authorize('update',$company); $company->update($this->attributes($request,$company)); return redirect()->route('web.companies.show',$company)->with('status','Company updated successfully.'); }
    public function storeSubscription(Request $request, Company $company): RedirectResponse { $this->authorize('update',$company); $data=$request->validate(['plan'=>['required',Rule::in(['Essential Care','Professional Growth','Enterprise Suite'])],'billing_cycle'=>['required',Rule::in(['Monthly','Quarterly','Annually'])],'payment_mode'=>['nullable','string','max:30'],'amount'=>['required','numeric','min:0'],'currency'=>['required','string','size:3'],'created_on'=>['required','date'],'expiring_on'=>['required','date','after:created_on'],'status'=>['required',Rule::in(['Active','Pending','Expired','Cancelled'])]]); $company->subscriptions()->create($data+['code'=>'SUB-'.strtoupper(substr((string)str()->uuid(),0,8))]); return back()->with('status','Subscription created successfully.'); }
    public function updateSubscription(Request $request, Company $company, Subscription $subscription): RedirectResponse { $this->authorize('update',$company); abort_unless($subscription->company_id===$company->id,404); $data=$request->validate(['status'=>['required',Rule::in(['Active','Pending','Expired','Cancelled'])]]); $subscription->update($data); return back()->with('status','Subscription status updated.'); }
    private function attributes(Request $request, ?Company $company=null): array { return $request->validate(['code'=>['required','string','max:20',Rule::unique('companies')->ignore($company?->id)],'name'=>['required','string','max:255'],'email'=>['required','email',Rule::unique('companies')->ignore($company?->id)],'url'=>['nullable','string','max:255'],'plan'=>['required',Rule::in(['Essential Care','Professional Growth','Enterprise Suite'])],'contact_person'=>['required','string','max:255'],'phone'=>['required','string','max:30'],'country'=>['required','string','max:50'],'city'=>['required','string','max:100'],'address'=>['nullable','string','max:1000'],'beds_count'=>['required','integer','min:0'],'status'=>['required',Rule::in(['Active','Trial','Pending','Suspended'])],'notes'=>['nullable','string','max:2000']]); }
}
