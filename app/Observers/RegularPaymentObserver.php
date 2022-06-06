<?php

namespace App\Observers;

use App\Models\RegularPayment;
use App\Models\RegularPaymentPeriod;
use App\Models\Safe;

class RegularPaymentObserver
{
  public function saving(RegularPayment $regularPayment){
    $regularPayment->periods->each->delete();
  }
  public function deleting(RegularPayment $regularPayment){
    $regularPayment->periods->each->delete();
  }
}
