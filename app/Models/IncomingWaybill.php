<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IncomingWaybill
 *
 * @property int $id
 * @property int $supplier_id
 * @property string $waybill_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IncomingWaybillProduct[] $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Database\Factories\IncomingWaybillFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybill query()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybill whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingWaybill whereWaybillDate($value)
 * @mixin \Eloquent
 */
class IncomingWaybill extends Model
{
  use HasFactory;
  protected $guarded = [];
  public function supplier()
  {
    return $this->belongsTo(Supplier::class, 'supplier_id');
  }

  public function products()
  {
    return $this->hasMany(IncomingWaybillProduct::class, 'waybill_id');
  }
}
