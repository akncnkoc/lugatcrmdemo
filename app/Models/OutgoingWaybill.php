<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OutgoingWaybill
 *
 * @property int $id
 * @property int $customer_id
 * @property string $waybill_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OutgoingWaybillProduct[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\OutgoingWaybillFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybill query()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybill whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingWaybill whereWaybillDate($value)
 * @mixin \Eloquent
 */
class OutgoingWaybill extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id');
  }


  public function products()
  {
    return $this->hasMany(OutgoingWaybillProduct::class, 'waybill_id');
  }
}
