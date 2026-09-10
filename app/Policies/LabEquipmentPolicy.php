<?php
namespace App\Policies;
use App\Models\LabEquipment; use App\Models\User;
class LabEquipmentPolicy {
 public function viewAny(User $u): bool { return $u->hasRole(['admin','super_admin','doctor','nurse','lab_technician']); }
 public function view(User $u,LabEquipment $r): bool { return $this->viewAny($u)&&($u->isSuperAdmin()||$r->company_id===null||$r->company_id===$u->company_id); }
 public function create(User $u): bool { return $u->hasRole(['admin','super_admin','lab_technician']); }
 public function update(User $u,LabEquipment $r): bool { return $this->create($u)&&($u->isSuperAdmin()||$r->company_id===$u->company_id); }
 public function delete(User $u,LabEquipment $r): bool { return $this->update($u,$r); }
}
