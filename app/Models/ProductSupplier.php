<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductSupplier
 *
 * @property int $id
 * @property int $product_id
 * @property int $supplier_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductSupplier extends Model
{
  public $timestamps = false;

  protected $guarded = [];

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function supplier()
  {
    return $this->belongsTo(Supplier::class, 'supplier_id');
  }
}
