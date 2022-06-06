<?php

namespace App\Models;

use App\Observers\SupplierPaymentObserver;
use datetime;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\SupplierPayment
 *
 * @property int $id
 * @property int|null $supplier_id
 * @property string|null $price
 * @property int|null $safe_id
 * @property int|null $tobepaid
 * @property datetime|null $payment_date
 * @property string|null $description
 * @property int|null $regular_payment_id
 * @property int|null $safe_log_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @property-read \App\Models\Supplier|null $supplier
 * @method static Builder|SupplierPayment newModelQuery()
 * @method static Builder|SupplierPayment newQuery()
 * @method static \Illuminate\Database\Query\Builder|SupplierPayment onlyTrashed()
 * @method static Builder|SupplierPayment query()
 * @method static Builder|SupplierPayment whereCreatedAt($value)
 * @method static Builder|SupplierPayment whereDeletedAt($value)
 * @method static Builder|SupplierPayment whereDescription($value)
 * @method static Builder|SupplierPayment whereId($value)
 * @method static Builder|SupplierPayment wherePaymentDate($value)
 * @method static Builder|SupplierPayment wherePrice($value)
 * @method static Builder|SupplierPayment whereRegularPaymentId($value)
 * @method static Builder|SupplierPayment whereSafeId($value)
 * @method static Builder|SupplierPayment whereSafeLogId($value)
 * @method static Builder|SupplierPayment whereSupplierId($value)
 * @method static Builder|SupplierPayment whereTobepaid($value)
 * @method static Builder|SupplierPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SupplierPayment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SupplierPayment withoutTrashed()
 * @mixin Eloquent
 */
class SupplierPayment extends Model
{
  use SoftDeletes;

  protected static $logAttributes = [];
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();

    SupplierPayment::observe(SupplierPaymentObserver::class);
  }

  public function supplier()
  {
    return $this->belongsTo(Supplier::class, 'supplier_id')->withTrashed();
  }

  public function safe()
  {
    return $this->belongsTo(Safe::class, 'safe_id')->withTrashed();
  }

  public function safe_log()
  {
    return $this->belongsTo(SafeLog::class, 'safe_log_id');
  }
}
