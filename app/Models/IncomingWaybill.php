<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingWaybill extends Model
{
  use HasFactory;
  protected $guarded = [];
  public function supplier()
  {
    return $this->belongsTo(Supplier::class, 'supplier_id');
  }

  public function products()
  {
    return $this->hasMany(IncomingWaybillProduct::class, 'waybill_id');
  }
}
