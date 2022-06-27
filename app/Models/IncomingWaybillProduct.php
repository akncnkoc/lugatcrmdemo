<?php

namespace App\Models;

use App\Observers\IncomingWaybillProductObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IncomingWaybillProduct
 *
 * @property int $id
 * @property string $product_code
 * @property string $buy_price
 * @property string $sale_price
 * @property int $rebate
 * @property string|null $rebate_date
 * @property string|null $rebate_note
 * @property int $sold
 * @property string|null $date_of_sale
 * @property int $product_id
 * @property int $waybill_id
 * @property int $buy_price_safe_id
 * @property int $sale_price_safe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Safe|null $buy_price_safe
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Safe|null $sale_price_safe
 * @property-read \App\Models\IncomingWaybill|null $waybill
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereBuyPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereBuyPriceSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereDateOfSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereRebate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereRebateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereRebateNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereSalePriceSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereSold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybillProduct whereWaybillId($value)
 * @mixin \Eloquent
 */
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
