<?php

namespace App\Models;

use App\Observers\InvoiceObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property string|null $description
 * @property int|null $customer_id
 * @property string|null $invoice_date
 * @property string|null $invoice_contract_number
 * @property int $has_cargo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Cargo|null $cargo
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceExpense[] $invoice_expenses
 * @property-read int|null $invoice_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceProduct[] $invoice_products
 * @property-read int|null $invoice_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceStaffPayment[] $invoice_staff_payments
 * @property-read int|null $invoice_staff_payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceStaff[] $invoice_staffs
 * @property-read int|null $invoice_staffs_count
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Query\Builder|Invoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereHasCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceContractNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Invoice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Invoice withoutTrashed()
 * @mixin \Eloquent
 */
class Invoice extends Model
{
  use SoftDeletes;

  protected static $logAttributes = [];
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    Invoice::observe(InvoiceObserver::class);
  }


  public function invoice_products()
  {
    return $this->hasMany(InvoiceProduct::class, 'invoice_id');
  }

  public function invoice_staffs()
  {
    return $this->hasMany(InvoiceStaff::class, 'invoice_id');
  }

  public function invoice_expenses()
  {
    return $this->hasMany(InvoiceExpense::class, 'invoice_id');
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id');
  }

  public function invoice_staff_payments()
  {
    return $this->hasMany(InvoiceStaffPayment::class, 'invoice_id');
  }

  public function cargo()
  {
    return $this->belongsTo(Cargo::class, 'id', 'invoice_id');
  }
}
