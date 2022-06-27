<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\SupplierPayment;

class SupplierPaymentObserver
{
  public function created(SupplierPayment $supplierPayment)
  {
    if ($supplierPayment->payable) {
      $safe_log = $supplierPayment->safe_log()->create([
        'price'        => $supplierPayment->price,
        'content'      => sprintf("%s tedarikçisine %s %s para ödemesi oldu", $supplierPayment->supplier->name, $supplierPayment->price, $supplierPayment->safe->currency->code),
        'process_type' => AppHelper::OUTPUT,
        'date'         => $supplierPayment->date,
        'safe_id'      => $supplierPayment->safe->id
      ]);
      $supplierPayment->safe_log()->associate($safe_log)->saveQuietly();
    }
  }

  public function updated(SupplierPayment $supplierPayment)
  {
    if ($supplierPayment->safe_log()->exists()) {
      $supplierPayment->safe_log->delete();
      $supplierPayment->updateQuietly(['safe_log_id' => null]);
    }
    if ($supplierPayment->payable) {
      $safe_log = $supplierPayment->safe_log()->create([
        'price'        => $supplierPayment->price,
        'content'      => sprintf("%s tedarikçisine %s %s para ödemesi oldu", $supplierPayment->supplier->name, $supplierPayment->price, $supplierPayment->safe->currency->code),
        'process_type' => AppHelper::OUTPUT,
        'date'         => $supplierPayment->date,
        'safe_id'      => $supplierPayment->safe->id
      ]);
      $supplierPayment->safe_log()->associate($safe_log)->saveQuietly();
    }
    if ($supplierPayment->date && !$supplierPayment->payable) {
      $supplierPayment->updateQuietly(['date' => null]);
    }
  }

  public function deleted(SupplierPayment $supplierPayment)
  {
    if ($supplierPayment->safe_log()->exists()) {
      $supplierPayment->safe_log->delete();
    }
  }
}
