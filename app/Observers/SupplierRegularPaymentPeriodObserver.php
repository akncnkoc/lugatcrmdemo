<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\SupplierRegularPaymentPeriod;

class SupplierRegularPaymentPeriodObserver
{
  public function created(SupplierRegularPaymentPeriod $regularPaymentPeriod)
  {
    if ($regularPaymentPeriod->completed) {
      $safeLog = $regularPaymentPeriod->safe_log()->create([
        'process_type' => AppHelper::OUTPUT,
        'safe_id'      => $regularPaymentPeriod->safe->id,
        'content'      => $regularPaymentPeriod->supplier_regular_payment->supplier->name . " adlı tedarikçiye " . $regularPaymentPeriod->price . " " . $regularPaymentPeriod->safe->currency->code . " ödeme yapıldı.",
        'price'        => $regularPaymentPeriod->price,
        'date'         => $regularPaymentPeriod->date
      ]);
      $regularPaymentPeriod->update(['safe_log_id' => $safeLog->id]);
    }
  }

  public function forceDeleted(SupplierRegularPaymentPeriod $regularPaymentPeriod)
  {
    if ($regularPaymentPeriod->safe_log()->exists()) {
      $regularPaymentPeriod->safe_log->delete();
    }
  }
}
