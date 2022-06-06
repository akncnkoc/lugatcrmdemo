<?php

namespace App\Models;

use App\Observers\InvoiceStaffPaymentObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InvoiceStaffPayment
 *
 * @property int $id
 * @property int|null $invoice_id
 * @property int|null $staff_id
 * @property float|null $staff_share
 * @property int $share_safe_id
 * @property string $share_price
 * @property string $product_code
 * @property int $paided
 * @property string|null $date_of_paid
 * @property int|null $safe_log_id
 * @property-read \App\Models\Safe $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @property-read \App\Models\Staff|null $staff
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment whereDateOfPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment wherePaided($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment whereSafeLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment whereSharePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment whereShareSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStaffPayment whereStaffShare($value)
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
