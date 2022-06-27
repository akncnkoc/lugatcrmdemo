<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\StaffPaymentType
 *
 * @property int $id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\StaffPayment|null $staff_payments
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPaymentType newQuery()
 * @method static \Illuminate\Database\Query\Builder|StaffPaymentType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPaymentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPaymentType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPaymentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffPaymentType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|StaffPaymentType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StaffPaymentType withoutTrashed()
 * @mixin \Eloquent
 */
class StaffPaymentType extends Model
{
  use SoftDeletes;

  public $timestamps = false;
  protected $guarded = [];

  public function staff_payments()
  {
    return $this->belongsTo(StaffPayment::class);
  }
}
