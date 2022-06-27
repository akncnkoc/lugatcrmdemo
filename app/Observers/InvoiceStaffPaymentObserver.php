<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\InvoiceStaffPayment;
use Carbon\Carbon;

class InvoiceStaffPaymentObserver
{
  public function saved(InvoiceStaffPayment $invoiceStaffPayment)
  {
    if ($invoiceStaffPayment->safe_log()->exists()) {
      $invoiceStaffPayment->safe_log->delete();
      $invoiceStaffPayment->updateQuietly(['safe_log_id' => null, 'date_of_paid' => null]);
    }
    if ($invoiceStaffPayment->paided) {
      $safe_log = $invoiceStaffPayment->safe_log()->create([
        'price'            => $invoiceStaffPayment->share_price,
        'content'          => sprintf("%s adlı personel'e %s %s fatura payı ödendi", $invoiceStaffPayment->staff->getFullName(), $invoiceStaffPayment->share_price, $invoiceStaffPayment->safe->currency->code),
        'enter_date'       => Carbon::now(),
        'input'            => AppHelper::OUTPUT,
        'safe_id'          => $invoiceStaffPayment->safe->id,
        'commission'       => 0,
        'cash_register_id' => 1
      ]);
      $invoiceStaffPayment->safe_log()->associate($safe_log)->saveQuietly();
    }
  }

  public function deleted(InvoiceStaffPayment $invoiceStaffPayment)
  {
    if ($invoiceStaffPayment->safe_log()->exists()) {
      $invoiceStaffPayment->safe_log->delete();
    }
  }
}
