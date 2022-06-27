<?php

namespace App\Models;

use App\Observers\SupplierRegularPaymentPeriodObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SupplierRegularPaymentPeriod
 *
 * @property int $id
 * @property string $date
 * @property string $price
 * @property int $completed
 * @property int $supplier_regular_payment_id
 * @property int $safe_id
 * @property int|null $safe_log_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @property-read \App\Models\SupplierRegularPayment|null $supplier_regular_payment
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod whereSafeLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod whereSupplierRegularPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPaymentPeriod whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SupplierRegularPaymentPeriod extends Model
{
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    SupplierRegularPaymentPeriod::observe(SupplierRegularPaymentPeriodObserver::class);
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
