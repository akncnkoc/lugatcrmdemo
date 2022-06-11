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
        $invoiceProduct->incoming_waybill_product->product->name
      ),
      'price' => ($invoiceProduct->price - ((float)$commisionPrice + $kdv_price)),
      'normal_price' => $invoiceProduct->price,
      'safe_id' => $invoiceProduct->safe_id,
      'date' => $invoiceProduct->invoice->invoice_date,
      'process_type' => AppHelper::INPUT,
      'cash_register_id' => $invoiceProduct->cash_register_id,
    ]);
    $incoming_waybill_product = $invoiceProduct->incoming_waybill_product;
    $incoming_waybill_product->product->productLog()->create([
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
        $invoiceProduct->incoming_waybill_product->product->name
      ),
      'product_id' => $incoming_waybill_product->product->id,
      'waybill_id' => $incoming_waybill_product->waybill->id,
      'date' => $incoming_waybill_product->waybill->date
    ]);
    $invoiceProduct->incoming_waybill_product->updateQuietly(['sold' => true, 'date_of_sale' => $invoiceProduct->invoice->invoice_date]);
    $invoiceProduct->safe_log()->associate($safe_log)->save();
  }

  public function deleted(InvoiceProduct $invoiceProduct)
  {
    $incoming_waybill_product = $invoiceProduct->incoming_waybill_product;
    $incoming_waybill_product->updateQuietly(['sold' => false,'rebate' => false, 'date_of_sale' => null]);
    if ($incoming_waybill_product->product->productLog()->exists()){
      $incoming_waybill_product->product->productLog->delete();
    }
    if ($invoiceProduct->safe_log()->exists())
      $invoiceProduct->safe_log->delete();
  }
}
