<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\SubProduct;

class ProductObserver
{

  public function deleting(Product $product)
  {
    $product->load('sub_products');
    $product->sub_products->each->map(function (SubProduct $subProduct){
      if (!$subProduct->rebate && !$subProduct->sold) {
        $subProduct->delete();
      }else{
        $subProduct->update(['rebate' => true]);
      }
    });
  }
}
