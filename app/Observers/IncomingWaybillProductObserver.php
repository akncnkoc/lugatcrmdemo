<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\IncomingWaybillProduct;
use App\Models\Product;

class IncomingWaybillProductObserver
{
  public function creating(IncomingWaybillProduct $waybillProduct)
  {
    $productLast = IncomingWaybillProduct::orderBy('id', 'desc')->first();
    if ($productLast != null) {
      $product_last_code_arr = array_filter(explode('-', $productLast->product_code));
      $length = strlen($product_last_code_arr[count($product_last_code_arr) - 1]);
      $product_last_code = sprintf("%0" . $length . "d", ++$product_last_code_arr[count($product_last_code_arr) - 1]);
      $waybillProduct->product_code = $waybillProduct->product->product_type->initial_code . "-" . $product_last_code;
    } else {
      $product = Product::find($waybillProduct->product_id);
      $waybillProduct->product_code = $product->product_type->initial_code . "-00001";
    }
  }

  public function created(IncomingWaybillProduct $waybillProduct)
  {
    $waybillProduct->product->productLog()->create([
      'content'      => sprintf("%s adındaki üründen %s tarihinde %s ürün kodlu ürün giriş yaptı.",
        $waybillProduct->product->name, AppHelper::convertDate($waybillProduct->waybill->waybill_date),
        $waybillProduct->product_code),
      'product_id'   => $waybillProduct->product->id,
      'waybill_id'   => $waybillProduct->waybill->id,
      'date'         => $waybillProduct->waybill->waybill_date,
      'process_type' => AppHelper::PRODUCT_IN
    ]);
  }

  public function updated(IncomingWaybillProduct $waybillProduct)
  {
    $waybillProduct->product->productLog()->create([
      'content'      => sprintf("%s adındaki üründen %s tarihinde %s ürün kodlu ürün düzenlendi.",
        $waybillProduct->product->name, AppHelper::convertDate($waybillProduct->waybill->waybill_date),
        $waybillProduct->product_code),
      'product_id'   => $waybillProduct->product->id,
      'waybill_id'   => $waybillProduct->waybill->id,
      'date'         => $waybillProduct->waybill->waybill_date,
      'process_type' => AppHelper::PRODUCT_IN
    ]);
  }
}
