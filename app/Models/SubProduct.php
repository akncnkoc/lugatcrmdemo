<?php

namespace App\Models;

use App\Observers\SubProductObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubProduct
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
 * @property-read \App\Models\Waybill|null $waybill
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereBuyPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereBuyPriceSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereDateOfSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereRebate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereRebateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereRebateNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereSalePriceSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereSold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereWaybillId($value)
 * @mixin \Eloquent
 */
class SubProduct extends Model
{
  protected $guarded = [];


  protected static function boot()
  {
    parent::boot();

    SubProduct::observe(SubProductObserver::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function waybill()
  {
    return $this->belongsTo(Waybill::class, 'waybill_id');
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
