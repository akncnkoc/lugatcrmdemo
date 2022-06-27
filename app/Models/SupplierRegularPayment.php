<?php

namespace App\Models;

use App\Observers\SupplierRegularPaymentObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SupplierRegularPayment
 *
 * @property int $id
 * @property string $name
 * @property string|null $comment
 * @property int $supplier_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SupplierRegularPaymentPeriod[] $periods
 * @property-read int|null $periods_count
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPayment newQuery()
 * @method static \Illuminate\Database\Query\Builder|SupplierRegularPayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPayment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPayment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPayment whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierRegularPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SupplierRegularPayment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SupplierRegularPayment withoutTrashed()
 * @mixin \Eloquent
 */
class SupplierRegularPayment extends Model
{
  use SoftDeletes;

  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    SupplierRegularPayment::observe(SupplierRegularPaymentObserver::class);
  }

  public function supplier()
  {
    return $this->belongsTo(Supplier::class, 'supplier_id');
  }

  public function periods()
  {
    return $this->hasMany(SupplierRegularPaymentPeriod::class, 'supplier_regular_payment_id');
  }
}
