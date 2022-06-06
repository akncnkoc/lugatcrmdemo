<?php

namespace App\Models;

use App\Observers\ProductLogObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\ProductLog
 *
 * @property int $id
 * @property string $content
 * @property int $product_id
 * @property int|null $bulk_waybill_id
 * @property string $enter_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog newQuery()
 * @method static Builder|ProductLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereBulkWaybillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereEnterDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLog whereUpdatedAt($value)
 * @method static Builder|ProductLog withTrashed()
 * @method static Builder|ProductLog withoutTrashed()
 * @mixin Eloquent
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
