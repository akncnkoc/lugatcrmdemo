<?php

namespace App\Models;

use App\Observers\CargoObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cargo
 *
 * @property int $id
 * @property string|null $tracking_number
 * @property float $amount
 * @property string|null $description
 * @property string $price
 * @property int $paided
 * @property string|null $date_of_paid
 * @property string|null $due_date
 * @property string|null $future_shipping_date
 * @property int|null $invoice_id
 * @property int $cargo_company_id
 * @property int $cargo_type_id
 * @property int $safe_id
 * @property int|null $safe_log_id
 * @property int $amount_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\AmountTypes|null $amount_type
 * @property-read \App\Models\CargoCompany|null $cargo_company
 * @property-read \App\Models\CargoType|null $cargo_type
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereAmountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereCargoCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereCargoTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereDateOfPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereFutureShippingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo wherePaided($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereSafeLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereTrackingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cargo extends Model
{
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    Cargo::observe(CargoObserver::class);
  }

  public function safe()
  {
    return $this->belongsTo(Safe::class, 'safe_id');
  }

  public function safe_log()
  {
    return $this->belongsTo(SafeLog::class, 'safe_log_id');
  }

  public function invoice()
  {
    return $this->belongsTo(Invoice::class, 'invoice_id');
  }

  public function cargo_company()
  {
    return $this->belongsTo(CargoCompany::class, 'cargo_company_id');
  }

  public function cargo_type()
  {
    return $this->belongsTo(CargoType::class, 'cargo_type_id');
  }

  public function amount_type()
  {
    return $this->belongsTo(AmountTypes::class, 'amount_type_id');
  }
}
