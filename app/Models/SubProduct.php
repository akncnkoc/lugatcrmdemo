<?php

namespace App\Models;

use App\Observers\SubProductObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubProduct
 *
 * @property int $id
 * @property int $product_id
 * @property int $bulk_waybill_id
 * @property string $product_code
 * @property string $buy_price
 * @property int $buy_price_safe_id
 * @property string $sale_price
 * @property int $sale_price_safe_id
 * @property int $rebate
 * @property string|null $rebate_date
 * @property string|null $rebate_note
 * @property int $sold
 * @property string|null $date_of_sale
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BulkWaybill $bulk_waybill
 * @property-read \App\Models\Safe $buy_price_safe
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Safe $sale_price_safe
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubProduct whereBulkWaybillId($value)
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
