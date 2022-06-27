<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductSupplier
 *
 * @property int $id
 * @property int $product_id
 * @property int $supplier_id
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereSupplierId($value)
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
