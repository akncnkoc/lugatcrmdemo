<?php

namespace App\Models;

use App\Observers\CargoObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cargo
 *
 * @property int $id
 * @property int $cargo_company_id
 * @property string|null $tracking_number
 * @property float $amount
 * @property int $amount_type_id
 * @property string $description
 * @property float $price
 * @property int $safe_id
 * @property int $safe_log_id
 * @property int $paided
 * @property int|null $invoice_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereAmountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereCargoCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo wherePaided($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereSafeLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereTrackingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\Safe $safe
 * @property-read \App\Models\SafeLog $safe_log
 * @property int $cargo_type_id
 * @property string|null $date_of_paid
 * @property string|null $due_date
 * @property-read \App\Models\CargoCompany $cargo_company
 * @property-read \App\Models\CargoType $cargo_type
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereCargoTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereDateOfPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereDueDate($value)
 * @property-read \App\Models\AmountTypes $amount_type
 * @property string|null $future_shipping_date
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereFutureShippingDate($value)
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
