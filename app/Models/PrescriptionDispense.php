<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory; use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PrescriptionDispense extends Model {
 use HasFactory;
 protected $fillable=['prescription_id','prescription_item_id','medicine_id','medicine_batch_id','quantity','patient_id','dispensed_by','dispensed_at'];
 protected $casts=['quantity'=>'integer','dispensed_at'=>'datetime'];
 public function prescription(): BelongsTo{return $this->belongsTo(Prescription::class);} public function item(): BelongsTo{return $this->belongsTo(PrescriptionItem::class,'prescription_item_id');} public function batch(): BelongsTo{return $this->belongsTo(MedicineBatch::class,'medicine_batch_id');}
}
