<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\StaffPayment;

class StaffPaymentObserver
{
  public function created(StaffPayment $staffPayment)
  {
    $safe_log = $staffPayment->safe_log()->create([
      'price'        => $staffPayment->price,
      'process_type' => AppHelper::STAFF_PAYMENT_OUTPUT,
      'safe_id'      => $staffPayment->safe->id,
      'date'         => $staffPayment->date,
      'content'      => sprintf("%s adlı personele %s  türünden %s %s hakediş södendi.", $staffPayment->staff->getFullName(), $staffPayment->payment_type->name, $staffPayment->price, $staffPayment->safe->currency->code)
    ]);
    $staffPayment->safe_log()->associate($safe_log)->saveQuietly();
  }

  public function updated(StaffPayment $staffPayment)
  {
    if ($staffPayment->safe_log()->exists()) {
      $staffPayment->safe_log->delete();
      $staffPayment->updateQuietly(['safe_log_id' => null, 'date' => null]);
    }

    $safe_log = $staffPayment->safe_log()->create([
      'price'        => $staffPayment->price,
      'process_type' => AppHelper::STAFF_PAYMENT_OUTPUT,
      'safe_id'      => $staffPayment->safe->id,
      'date'         => $staffPayment->date,
      'content'      => sprintf("%s adlı personele %s  türünden %s %s hakediş södendi.", $staffPayment->staff->getFullName(), $staffPayment->payment_type->name, $staffPayment->price, $staffPayment->safe->currency->code)
    ]);
    $staffPayment->safe_log()->associate($safe_log)->saveQuietly();
  }

  public function deleted(StaffPayment $staffPayment)
  {
    if ($staffPayment->safe_log()->exists()) {
      $staffPayment->safe_log->delete();
    }
  }
}
