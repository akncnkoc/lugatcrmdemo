<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductType
 *
 * @property int $id
 * @property string $name
 * @property string $initial_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereInitialCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereName($value)
 * @mixin \Eloquent
 */
class ProductType extends Model
{

  public $timestamps = false;
  public $guarded = [];

  public function products()
  {
    return $this->hasMany(Product::class, 'product_type_id');
  }
}
