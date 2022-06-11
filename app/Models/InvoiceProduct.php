<?php

namespace App\Models;

use App\Observers\InvoiceProductObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\InvoiceProduct
 *
 * @property int $id
 * @property int|null $invoice_id
 * @property string|null $product_code
 * @property string|null $price
 * @property int|null $cash_register_id
 * @property int|null $safe_id
 * @property int|null $safe_log_id
 * @property int|null $tax
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\CashRegister|null $cash_register
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @property-read \App\Models\SubProduct|null $sub_product
 * @method static Builder|InvoiceProduct newModelQuery()
 * @method static Builder|InvoiceProduct newQuery()
 * @method static \Illuminate\Database\Query\Builder|InvoiceProduct onlyTrashed()
 * @method static Builder|InvoiceProduct query()
 * @method static Builder|InvoiceProduct whereCashRegisterId($value)
 * @method static Builder|InvoiceProduct whereCreatedAt($value)
 * @method static Builder|InvoiceProduct whereDeletedAt($value)
 * @method static Builder|InvoiceProduct whereId($value)
 * @method static Builder|InvoiceProduct whereInvoiceId($value)
 * @method static Builder|InvoiceProduct wherePrice($value)
 * @method static Builder|InvoiceProduct whereProductCode($value)
 * @method static Builder|InvoiceProduct whereSafeId($value)
 * @method static Builder|InvoiceProduct whereSafeLogId($value)
 * @method static Builder|InvoiceProduct whereTax($value)
 * @method static Builder|InvoiceProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|InvoiceProduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InvoiceProduct withoutTrashed()
 * @mixin Eloquent
 * @property int|null $cargo_id
 * @method static Builder|InvoiceProduct whereCargoId($value)
 * @property int $product_id
 * @method static Builder|InvoiceProduct whereProductId($value)
 * @property-read \App\Models\IncomingWaybillProduct|null $incoming_waybill_product
 */
class InvoiceProduct extends Model
{
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    InvoiceProduct::observe(InvoiceProductObserver::class);
  }

  public function invoice()
  {
    return $this->belongsTo(Invoice::class, 'invoice_id');
  }

  public function incoming_waybill_product()
  {
    return $this->belongsTo(IncomingWaybillProduct::class, 'product_code', 'product_code');
  }

  public function safe()
  {
    return $this->belongsTo(Safe::class, 'safe_id');
  }

  public function safe_log()
  {
    return $this->belongsTo(SafeLog::class, 'safe_log_id');
  }

  public function cash_register()
  {
    return $this->belongsTo(CashRegister::class, 'cash_register_id');
  }
}
