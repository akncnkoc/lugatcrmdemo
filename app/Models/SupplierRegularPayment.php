<?php

namespace App\Models;

use App\Observers\SupplierRegularPaymentObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\SupplierRegularPayment
 *
 * @property int $id
 * @property string $name
 * @property string|null $comment
 * @property int|null $supplier_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SupplierRegularPaymentPeriod[] $periods
 * @property-read int|null $periods_count
 * @property-read \App\Models\Supplier|null $supplier
 * @method static Builder|SupplierRegularPayment newModelQuery()
 * @method static Builder|SupplierRegularPayment newQuery()
 * @method static \Illuminate\Database\Query\Builder|SupplierRegularPayment onlyTrashed()
 * @method static Builder|SupplierRegularPayment query()
 * @method static Builder|SupplierRegularPayment whereComment($value)
 * @method static Builder|SupplierRegularPayment whereCreatedAt($value)
 * @method static Builder|SupplierRegularPayment whereDeletedAt($value)
 * @method static Builder|SupplierRegularPayment whereId($value)
 * @method static Builder|SupplierRegularPayment whereName($value)
 * @method static Builder|SupplierRegularPayment whereSupplierId($value)
 * @method static Builder|SupplierRegularPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SupplierRegularPayment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SupplierRegularPayment withoutTrashed()
 * @mixin Eloquent
 */
class SupplierRegularPayment extends Model
{
  use SoftDeletes;

  protected static $logAttributes = [];
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    SupplierRegularPayment::observe(SupplierRegularPaymentObserver::class);
    static::addGlobalScope('order', function (Builder $builder) {
      $builder->orderBy('id', 'desc');
    });
    static::saving(function (Model $model) {
      static::$logAttributes = array_keys($model->getDirty());
    });
    static::updating(function (Model $model) {
      static::$logAttributes = array_keys($model->getDirty());
    });
    static::deleting(function (SupplierRegularPayment $model) {
      static::$logAttributes = array_keys($model->getDirty());
      $model->periods->each->delete();
    });
  }

  public function supplier()
  {
    return $this->belongsTo(Supplier::class, 'supplier_id')->withTrashed();
  }

  public function periods()
  {
    return $this->hasMany(SupplierRegularPaymentPeriod::class, 'supplier_regular_payment_id')->withTrashed();
  }


}
