<?php

namespace App\Observers;

use App\Models\ProductLog;

class ProductLogObserver
{
  public function creating(ProductLog $productLog){
    $productLog->product->update([
      'real_stock' => $productLog->product->real_stock + 1
    ]);
  }

  public function deleting(ProductLog $productLog){
    $productLog->product->update([
      'real_stock' => $productLog->product->real_stock - 1
    ]);
  }
}
