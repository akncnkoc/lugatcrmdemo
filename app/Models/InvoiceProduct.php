<?php

namespace App\Models;

use App\Observers\InvoiceProductObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InvoiceProduct
 *
 * @property int $id
 * @property int|null $invoice_id
 * @property int $product_id
 * @property string|null $product_code
 * @property string|null $price
 * @property int|null $cash_register_id
 * @property int|null $safe_id
 * @property int|null $safe_log_id
 * @property int|null $tax
 * @property int|null $cargo_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CashRegister|null $cash_register
 * @property-read \App\Models\IncomingWaybillProduct|null $incoming_waybill_product
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereCargoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereCashRegisterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereSafeLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProduct whereUpdatedAt($value)
 * @mixin \Eloquent
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
