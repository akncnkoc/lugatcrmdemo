<?php

namespace App\Models;

use App\Observers\OutgoingWaybillProductObserver;
use App\Observers\SubProductObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OutgoingWaybillProduct
 *
 * @property int $id
 * @property string $sale_price
 * @property int $rebate
 * @property string|null $rebate_date
 * @property string|null $rebate_note
 * @property int $product_id
 * @property int $waybill_id
 * @property int $sale_price_safe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Safe|null $sale_price_safe
 * @property-read \App\Models\OutgoingWaybill|null $waybill
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct whereRebate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct whereRebateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct whereRebateNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct whereSalePriceSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybillProduct whereWaybillId($value)
 * @mixin \Eloquent
 */
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
