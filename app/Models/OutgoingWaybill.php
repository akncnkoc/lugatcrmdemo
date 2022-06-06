<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingWaybill extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id');
  }


  public function products()
  {
    return $this->hasMany(OutgoingWaybillProduct::class, 'waybill_id');
  }
}
