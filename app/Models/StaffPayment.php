<?php

namespace App\Models;

use App\Observers\StaffPaymentObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StaffPayment
 *
 * @property int $id
 * @property string $price
 * @property int $safe_id
 * @property int $staff_id
 * @property int $staff_payment_type_id
 * @property int|null $safe_log_id
 * @property string $payment_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\StaffPaymentType $payment_type
 * @property-read \App\Models\Safe $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @property-read \App\Models\Staff $staff
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment whereSafeLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment whereStaffPaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $date
 * @property string|null $description
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPayment whereDescription($value)
 */
class StaffPayment extends Model
{

  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    StaffPayment::observe(StaffPaymentObserver::class);
  }

  public function staff()
  {
    return $this->belongsTo(Staff::class);
  }

  public function payment_type()
  {
    return $this->belongsTo(StaffPaymentType::class, 'staff_payment_type_id');
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
