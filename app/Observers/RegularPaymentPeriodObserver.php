<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\RegularPaymentPeriod;
use Illuminate\Support\Carbon;

class RegularPaymentPeriodObserver
{
  public function created(RegularPaymentPeriod $regularPaymentPeriod)
  {
    if ($regularPaymentPeriod->completed) {
      $safe_log = $regularPaymentPeriod->safe_log()->create([
        'input'      => AppHelper::PAYMENT_OUTPUT,
        'safe_id'    => $regularPaymentPeriod->safe->id,
        'content'    => sprintf("%s düzenli ödeme tipinde %s %s para çıkışı oldu", $regularPaymentPeriod->regular_payment->regular_payment_type->name, $regularPaymentPeriod->price, $regularPaymentPeriod->safe->currency->code),
        'price'      => $regularPaymentPeriod->price,
        'enter_date' => Carbon::now()
      ]);
      $regularPaymentPeriod->safe_log()->associate($safe_log)->saveQuietly();
    }
  }

  public function saved(RegularPaymentPeriod $regularPaymentPeriod)
  {
    if ($regularPaymentPeriod->safe_log()->exists()) {
      $regularPaymentPeriod->safe_log->delete();
      $regularPaymentPeriod->updateQuietly(['safe_log_id' => null]);
    }
    if ($regularPaymentPeriod->completed) {
      $safe_log = $regularPaymentPeriod->safe_log()->create([
        'input'      => AppHelper::PAYMENT_OUTPUT,
        'safe_id'    => $regularPaymentPeriod->safe->id,
        'content'    => sprintf("%s düzenli ödeme tipinde %s %s para çıkışı oldu", $regularPaymentPeriod->regular_payment->regular_payment_type->name, $regularPaymentPeriod->price, $regularPaymentPeriod->safe->currency->code),
        'price'      => $regularPaymentPeriod->price,
        'enter_date' => Carbon::now()
      ]);
      $regularPaymentPeriod->safe_log()->associate($safe_log)->saveQuietly();
    }
  }

  public function deleted(RegularPaymentPeriod $regularPaymentPeriod)
  {
    if ($regularPaymentPeriod->safe_log()->exists()) {
      $regularPaymentPeriod->safe_log->delete();
    }
  }
}
