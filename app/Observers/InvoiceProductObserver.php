<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\InvoiceProduct;

class InvoiceProductObserver
{
  public function created(InvoiceProduct $invoiceProduct)
  {
    $commision = $invoiceProduct->cash_register->percentage;
    $commisionPrice = ($invoiceProduct->price / 100) * $commision;
    $kdv_price = ($invoiceProduct->price / 100) * $invoiceProduct->tax;
    $safe_log = $invoiceProduct->safe_log()->create([
      'content' => sprintf(
        "%s %s değerinde %%%s komisyonlu (%d %s) ve %%%s KDV'li (%d %s) %s adlı ürün satıldı",
        $invoiceProduct->price,
        $invoiceProduct->safe->currency->code,
        $commision,
        $commisionPrice,
        $invoiceProduct->safe->currency->code,
        $invoiceProduct->tax,
        $kdv_price,
        $invoiceProduct->safe->currency->code,
        $invoiceProduct->sub_product->product->name
      ),
      'price' => ($invoiceProduct->price - ((float)$commisionPrice + $kdv_price)),
      'normal_price' => $invoiceProduct->price,
      'safe_id' => $invoiceProduct->safe_id,
      'enter_date' => $invoiceProduct->invoice->invoice_date,
      'input' => AppHelper::CASH_REGISTER,
      'cash_register_id' => $invoiceProduct->cash_register_id,
    ]);
    $subProduct = $invoiceProduct->sub_product;
    $subProduct->product->productLog()->create([
      'content' => sprintf(
        "%s %s  %%%s komisyonlu (%d %s) ve %%%s KDV'li (%d %s) %s değerinde bu ürün satıldı",
        $invoiceProduct->price,
        $invoiceProduct->safe->currency->code,
        $commision,
        $commisionPrice,
        $invoiceProduct->safe->currency->code,
        $invoiceProduct->tax,
        $kdv_price,
        $invoiceProduct->safe->currency->code,
        $invoiceProduct->sub_product->product->name
      ),
      'product_id' => $subProduct->product->id,
      'waybill_id' => $subProduct->waybill->id,
      'enter_date' => $subProduct->waybill->waybill_date
    ]);
    $invoiceProduct->sub_product->updateQuietly(['sold' => true, 'date_of_sale' => $invoiceProduct->invoice->invoice_date]);
    $invoiceProduct->safe_log()->associate($safe_log)->save();
  }

  public function deleted(InvoiceProduct $invoiceProduct)
  {
    $subProduct = $invoiceProduct->sub_product;
    $subProduct->updateQuietly(['sold' => false,'rebate' => false, 'date_of_sale' => null]);
    if ($subProduct->product->productLog()->exists()){
      $subProduct->product->productLog->delete();
    }
    if ($invoiceProduct->safe_log()->exists())
      $invoiceProduct->safe_log->delete();
  }
}
