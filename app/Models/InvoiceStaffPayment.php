<?php

namespace App\Models;

use App\Observers\InvoiceStaffPaymentObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InvoiceStaffPayment
 *
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @property-read \App\Models\Staff|null $staff
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment query()
 * @mixin \Eloquent
 */
class InvoiceStaffPayment extends Model
{
  public $timestamps = false;
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    InvoiceStaffPayment::observe(InvoiceStaffPaymentObserver::class);
  }


  public function staff()
  {
    return $this->belongsTo(Staff::class, 'staff_id');
  }

  public function safe()
  {
    return $this->belongsTo(Safe::class, 'share_safe_id');
  }

  public function safe_log()
  {
    return $this->belongsTo(SafeLog::class, 'safe_log_id');
  }
}
