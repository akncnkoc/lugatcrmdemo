<?php

namespace App\Models;

use App\Observers\OutgoingWaybillProductObserver;
use App\Observers\SubProductObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingWaybillProduct extends Model
{

  protected $guarded = [];


  protected static function boot()
  {
    parent::boot();

    self::observe(OutgoingWaybillProductObserver::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function waybill()
  {
    return $this->belongsTo(OutgoingWaybill::class, 'waybill_id');
  }

  public function sale_price_safe()
  {
    return $this->belongsTo(Safe::class, 'sale_price_safe_id');
  }
}
