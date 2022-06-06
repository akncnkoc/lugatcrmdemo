<?php

namespace App\Models;

use App\Observers\IncomingWaybillProductObserver;
use Illuminate\Database\Eloquent\Model;

class IncomingWaybillProduct extends Model
{

  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();

    self::observe(IncomingWaybillProductObserver::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function waybill()
  {
    return $this->belongsTo(IncomingWaybill::class, 'waybill_id');
  }

  public function buy_price_safe()
  {
    return $this->belongsTo(Safe::class, 'buy_price_safe_id');
  }

  public function sale_price_safe()
  {
    return $this->belongsTo(Safe::class, 'sale_price_safe_id');
  }
}
