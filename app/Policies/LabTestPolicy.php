<?php
namespace App\Policies;
use App\Models\LabTest; use App\Models\User;
class LabTestPolicy {
 public function viewAny(User $u): bool { return $u->hasRole(['admin','super_admin','doctor','nurse','lab_technician']); }
 public function view(User $u,LabTest $r): bool { return $this->viewAny($u)&&($u->isSuperAdmin()||$r->company_id===null||$r->company_id===$u->company_id); }
 public function create(User $u): bool { return $u->hasRole(['admin','super_admin','lab_technician']); }
 public function update(User $u,LabTest $r): bool { return $this->create($u)&&($u->isSuperAdmin()||$r->company_id===$u->company_id); }
 public function delete(User $u,LabTest $r): bool { return $this->update($u,$r); }
}
