<?php

namespace App\Models;

use App\Observers\RegularPaymentPeriodObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RegularPaymentPeriod
 *
 * @property int $id
 * @property int|null $regular_payment_id
 * @property string $repeat_date
 * @property string $price
 * @property int $safe_id
 * @property int $completed
 * @property int|null $safe_log_id
 * @property-read \App\Models\RegularPayment|null $regular_payment
 * @property-read \App\Models\Safe $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentPeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentPeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentPeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentPeriod whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentPeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentPeriod wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentPeriod whereRegularPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentPeriod whereRepeatDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentPeriod whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentPeriod whereSafeLogId($value)
 * @mixin \Eloquent
 */
class RegularPaymentPeriod extends Model
{
  public $timestamps = false;
  protected $guarded = [];


  protected static function boot()
  {
    parent::boot();
    RegularPaymentPeriod::observe(RegularPaymentPeriodObserver::class);
  }

  public function regular_payment()
  {
    return $this->belongsTo(RegularPayment::class, 'regular_payment_id');
  }

  public function safe()
  {
    return $this->belongsTo(Safe::class, 'safe_id');
  }

  public function safe_log()
  {
    return $this->belongsTo(SafeLog::class, 'safe_log_id');
  }
}
