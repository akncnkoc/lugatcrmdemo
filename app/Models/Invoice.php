<?php

namespace App\Models;

use App\Observers\InvoiceObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property string|null $description
 * @property int|null $customer_id
 * @property string|null $invoice_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Customer|null $customer
 * @property-read Collection|\App\Models\InvoiceExpense[] $invoice_expenses
 * @property-read int|null $invoice_expenses_count
 * @property-read Collection|\App\Models\InvoiceProduct[] $invoice_products
 * @property-read int|null $invoice_products_count
 * @property-read Collection|\App\Models\InvoiceStaffPayment[] $invoice_staff_payments
 * @property-read int|null $invoice_staff_payments_count
 * @property-read Collection|\App\Models\InvoiceStaff[] $invoice_staffs
 * @property-read int|null $invoice_staffs_count
 * @method static Builder|Invoice newModelQuery()
 * @method static Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Query\Builder|Invoice onlyTrashed()
 * @method static Builder|Invoice query()
 * @method static Builder|Invoice whereCreatedAt($value)
 * @method static Builder|Invoice whereCustomerId($value)
 * @method static Builder|Invoice whereDeletedAt($value)
 * @method static Builder|Invoice whereDescription($value)
 * @method static Builder|Invoice whereId($value)
 * @method static Builder|Invoice whereInvoiceDate($value)
 * @method static Builder|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Invoice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Invoice withoutTrashed()
 * @mixin Eloquent
 * @property string $invoice_contract_number
 * @method static Builder|Invoice whereInvoiceContractNumber($value)
 * @property-read \App\Models\Cargo $cargo
 * @property int $has_cargo
 * @method static Builder|Invoice whereHasCargo($value)
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
