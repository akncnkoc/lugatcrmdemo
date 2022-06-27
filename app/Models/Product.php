<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string|null $uuid
 * @property string $name
 * @property string|null $model_code
 * @property string $buy_price
 * @property string $sale_price
 * @property int $real_stock
 * @property int $critical_stock_alert
 * @property int|null $buy_price_safe_id
 * @property int|null $sale_price_safe_id
 * @property int $product_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Safe|null $buy_price_safe
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IncomingWaybillProduct[] $incoming_waybill_products
 * @property-read int|null $incoming_waybill_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceProduct[] $invoice_products
 * @property-read int|null $invoice_products_count
 * @property-read \App\Models\ProductLog|null $productLog
 * @property-read \App\Models\ProductType|null $product_type
 * @property-read \App\Models\Safe|null $sale_price_safe
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductSupplier[] $suppliers
 * @property-read int|null $suppliers_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBuyPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBuyPriceSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCriticalStockAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereModelCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRealStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSalePriceSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin \Eloquent
 */
class Product extends Model
{
  use SoftDeletes;

  protected static $logAttributes = [];
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
  }

  public function invoice_products()
  {
    return $this->hasMany(InvoiceProduct::class, 'product_id');
  }

  public function suppliers()
  {
    return $this->hasMany(ProductSupplier::class, 'product_id');
  }

  public function incoming_waybill_products()
  {
    return $this->hasMany(IncomingWaybillProduct::class, 'product_id');
  }

  public function buy_price_safe()
  {
    return $this->belongsTo(Safe::class, 'buy_price_safe_id');
  }

  public function sale_price_safe()
  {
    return $this->belongsTo(Safe::class, 'sale_price_safe_id');
  }

  public function product_type()
  {
    return $this->belongsTo(ProductType::class, 'product_type_id');
  }

  public function productLog()
  {
    return $this->belongsTo(ProductLog::class, 'id', 'product_id');
  }
}
