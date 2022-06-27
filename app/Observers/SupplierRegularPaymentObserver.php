<?php

namespace App\Observers;

use App\Models\SupplierRegularPayment;

class SupplierRegularPaymentObserver
{
  public function saving(SupplierRegularPayment $regularPayment)
  {
    $regularPayment->periods->each->forceDelete();
  }

  public function deleting(SupplierRegularPayment $regularPayment)
  {
    $regularPayment->periods->each->forceDelete();
  }
}
