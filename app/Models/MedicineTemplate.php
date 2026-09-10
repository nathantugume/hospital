<?php
namespace App\Models;use Illuminate\Database\Eloquent\Model;use Illuminate\Database\Eloquent\Relations\BelongsTo;
class MedicineTemplate extends Model{protected $fillable=['company_id','name','category','description','medications','created_by','usage_count','last_used_at'];protected $casts=['medications'=>'array','usage_count'=>'integer','last_used_at'=>'datetime'];public function creator():BelongsTo{return $this->belongsTo(User::class,'created_by');}}
