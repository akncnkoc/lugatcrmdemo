<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BulkWaybill
 *
 * @property int $id
 * @property int $supplier_id
 * @property string $bulk_waybill_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SubProduct[] $sub_products
 * @property-read int|null $sub_products_count
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|BulkWaybill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BulkWaybill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BulkWaybill query()
 * @method static \Illuminate\Database\Eloquent\Builder|BulkWaybill whereBulkWaybillDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BulkWaybill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BulkWaybill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BulkWaybill whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BulkWaybill whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BulkWaybill extends Model
{
  protected $guarded = [];

  public function supplier()
  {
    return $this->belongsTo(Supplier::class, 'supplier_id');
  }

  public function sub_products()
  {
    return $this->hasMany(SubProduct::class, 'waybill_id');
  }
}
