<?php

namespace App\Observers;

use App\Models\Invoice;

class InvoiceObserver
{
  public function saved(Invoice $invoice)
  {
    $invoice->invoice_products->map->delete();
    if($invoice->cargo()->exists())
      $invoice->cargo->delete();
  }
  public function deleting(Invoice $invoice)
  {
    $invoice->invoice_products->map->delete();
    if($invoice->cargo()->exists())
      $invoice->cargo->delete();
  }
}
