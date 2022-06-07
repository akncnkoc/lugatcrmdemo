<?php

namespace App\Models;

use App\Observers\SupplierRegularPaymentPeriodObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\SupplierRegularPaymentPeriod
 *
 * @property int $id
 * @property int|null $supplier_regular_payment_id
 * @property string $repeat_date
 * @property string $price
 * @property int $safe_id
 * @property int $completed
 * @property int|null $safe_log_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Safe $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @property-read \App\Models\SupplierRegularPayment|null $supplier_regular_payment
 * @method static Builder|SupplierRegularPaymentPeriod newModelQuery()
 * @method static Builder|SupplierRegularPaymentPeriod newQuery()
 * @method static \Illuminate\Database\Query\Builder|SupplierRegularPaymentPeriod onlyTrashed()
 * @method static Builder|SupplierRegularPaymentPeriod query()
 * @method static Builder|SupplierRegularPaymentPeriod whereCompleted($value)
 * @method static Builder|SupplierRegularPaymentPeriod whereCreatedAt($value)
 * @method static Builder|SupplierRegularPaymentPeriod whereDeletedAt($value)
 * @method static Builder|SupplierRegularPaymentPeriod whereId($value)
 * @method static Builder|SupplierRegularPaymentPeriod wherePrice($value)
 * @method static Builder|SupplierRegularPaymentPeriod whereRepeatDate($value)
 * @method static Builder|SupplierRegularPaymentPeriod whereSafeId($value)
 * @method static Builder|SupplierRegularPaymentPeriod whereSafeLogId($value)
 * @method static Builder|SupplierRegularPaymentPeriod whereSupplierRegularPaymentId($value)
 * @method static Builder|SupplierRegularPaymentPeriod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SupplierRegularPaymentPeriod withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SupplierRegularPaymentPeriod withoutTrashed()
 * @mixin Eloquent
 * @property string $date
 * @method static Builder|SupplierRegularPaymentPeriod whereDate($value)
 */
class SupplierRegularPaymentPeriod extends Model
{
  use SoftDeletes;

  protected static $logAttributes = [];
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    SupplierRegularPaymentPeriod::observe(SupplierRegularPaymentPeriodObserver::class);
    static::addGlobalScope('order', function (Builder $builder) {
      $builder->orderBy('id', 'desc');
    });
    static::saving(function (Model $model) {
      static::$logAttributes = array_keys($model->getDirty());
    });
    static::updating(function (Model $model) {
      static::$logAttributes = array_keys($model->getDirty());
    });
    static::deleting(function (Model $model) {
      static::$logAttributes = array_keys($model->getDirty());
    });
  }

  public function safe_log()
  {
    return $this->belongsTo(SafeLog::class, 'safe_log_id');
  }

  public function safe()
  {
    return $this->belongsTo(Safe::class, 'safe_id')->withTrashed();
  }

  public function supplier_regular_payment()
  {
    return $this->belongsTo(SupplierRegularPayment::class, 'supplier_regular_payment_id')->with('supplier')->withTrashed();
  }
}
