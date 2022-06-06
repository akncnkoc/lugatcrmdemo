<?php

namespace App\Observers;

use App\Models\Invoice;

class InvoiceObserver
{
  public function saved(Invoice $invoice)
  {
    $invoice->invoice_staff_payments->map->delete();
    $invoice->invoice_products->map->delete();
    $invoice->invoice_staffs->map->delete();
    $invoice->invoice_expenses->map->delete();
    if($invoice->cargo()->exists())
      $invoice->cargo->delete();
  }
  public function deleting(Invoice $invoice)
  {
    $invoice->invoice_staff_payments->map->delete();
    $invoice->invoice_products->map->delete();
    $invoice->invoice_staffs->map->delete();
    $invoice->invoice_expenses->map->delete();
    if($invoice->cargo()->exists())
      $invoice->cargo->delete();
  }
}
