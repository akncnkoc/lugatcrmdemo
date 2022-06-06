<?php

namespace App\Observers;

use App\Models\SupplierRegularPayment;
use App\Models\SupplierRegularPaymentPeriod;

class SupplierRegularPaymentObserver
{

  public function saving(SupplierRegularPayment $regularPayment)
  {
    $regularPayment->load('periods');
    $regularPayment->periods->map(function (SupplierRegularPaymentPeriod $supplierRegularPaymentPeriod){
      $supplierRegularPaymentPeriod->forceDelete();
    });
  }

  public function deleting(SupplierRegularPayment $regularPayment)
  {
    $regularPayment->load('periods');
    $regularPayment->periods->map(function (SupplierRegularPaymentPeriod $supplierRegularPaymentPeriod){
      $supplierRegularPaymentPeriod->forceDelete();
    });
  }
}
