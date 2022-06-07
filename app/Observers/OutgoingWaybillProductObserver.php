<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\OutgoingWaybillProduct;

class OutgoingWaybillProductObserver
{
  public function creating(OutgoingWaybillProduct $waybillProduct)
  {
  }

  public function created(OutgoingWaybillProduct $waybillProduct)
  {
    $waybillProduct->product->productLog()->create([
      'content' => sprintf("%s adındaki üründen %s tarihinde %s ürün kodlu ürün çıkış yaptı yaptı.", $waybillProduct->product->name, AppHelper::convertDate($waybillProduct->waybill->waybill_date), $waybillProduct->product_code),
      'product_id' => $waybillProduct->product->id,
      'waybill_id' => $waybillProduct->waybill->id,
      'date' => $waybillProduct->waybill->waybill_date,
      'process_type' => AppHelper::PRODUCT_OUT
    ]);
  }

  public function updated(OutgoingWaybillProduct $waybillProduct)
  {
    $waybillProduct->product->productLog()->create([
      'content' => sprintf("%s adındaki üründen %s tarihinde %s ürün kodlu ürün düzenlendi.", $waybillProduct->product->name, AppHelper::convertDate($waybillProduct->waybill->waybill_date), $waybillProduct->product_code),
      'product_id' => $waybillProduct->product->id,
      'waybill_id' => $waybillProduct->waybill->id,
      'date' => $waybillProduct->waybill->waybill_date,
      'process_type' => AppHelper::PRODUCT_OUT
    ]);
  }
}
