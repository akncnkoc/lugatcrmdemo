<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BulkWaybill
 *
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|BulkWaybill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BulkWaybill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BulkWaybill query()
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
