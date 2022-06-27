<?php

namespace App\Models;

use App\Observers\ProductLogObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProductLog
 *
 * @property int $id
 * @property string $content
 * @property string|null $date
 * @property string $process_type
 * @property int $product_id
 * @property int $waybill_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereProcessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereWaybillId($value)
 * @method static \Illuminate\Database\Query\Builder|ProductLog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductLog withoutTrashed()
 * @mixin \Eloquent
 */
class ProductLog extends Model
{
  use SoftDeletes;

  public $timestamps = false;
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    ProductLog::observe(ProductLogObserver::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }
}
