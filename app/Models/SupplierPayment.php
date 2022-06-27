<?php

namespace App\Models;

use App\Observers\SupplierPaymentObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SupplierPayment
 *
 * @property int $id
 * @property string $price
 * @property int $payable
 * @property string|null $date
 * @property string|null $description
 * @property int $supplier_id
 * @property int $safe_id
 * @property int|null $safe_log_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment newQuery()
 * @method static \Illuminate\Database\Query\Builder|SupplierPayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment wherePayable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment whereSafeLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SupplierPayment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SupplierPayment withoutTrashed()
 * @mixin \Eloquent
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
