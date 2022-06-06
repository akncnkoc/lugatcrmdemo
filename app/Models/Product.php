<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $model_code
 * @property string|null $buying_price
 * @property int $buy_price_safe_id
 * @property string|null $sale_price
 * @property int $sale_price_safe_id
 * @property int $real_stock
 * @property int $critical_stock_alert
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Safe $buy_price_safe
 * @property-read Collection|\App\Models\InvoiceProduct[] $invoice_products
 * @property-read int|null $invoice_products_count
 * @property-read \App\Models\ProductType $product_type
 * @property-read \App\Models\Safe $sale_price_safe
 * @property-read Collection|\App\Models\SubProduct[] $sub_products
 * @property-read int|null $sub_products_count
 * @property-read Collection|\App\Models\ProductSupplier[] $suppliers
 * @property-read int|null $suppliers_count
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static Builder|Product query()
 * @method static Builder|Product whereBuyPriceSafeId($value)
 * @method static Builder|Product whereBuyingPrice($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereCriticalStockAlert($value)
 * @method static Builder|Product whereDeletedAt($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereModelCode($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereRealStock($value)
 * @method static Builder|Product whereSalePrice($value)
 * @method static Builder|Product whereSalePriceSafeId($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin Eloquent
 * @property int $product_type_id
 * @method static Builder|Product whereProductTypeId($value)
 * @property string|null $photo_path
 * @method static Builder|Product wherePhotoPath($value)
 * @property-read \App\Models\ProductLog $productLog
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
