<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\InvoiceExpense;

class InvoiceExpenseObserver
{
  public function created(InvoiceExpense $invoiceExpense)
  {
    $safe_log = $invoiceExpense->safe_log()->create([
      'price'      => $invoiceExpense->price,
      'content'    => sprintf("%s gider tipinde kasadan %s %s para çıkışı oldu", $invoiceExpense->expense_type->name, $invoiceExpense->price, $invoiceExpense->safe->currency->code),
      'safe_id'    => $invoiceExpense->safe->id,
      'input'      => AppHelper::EXPENSE_OUTPUT,
      'enter_date' => $invoiceExpense->invoice->invoice_date
    ]);
    $invoiceExpense->safe_log()->associate($safe_log)->saveQuietly();
  }

  public function updated(InvoiceExpense $invoiceExpense)
  {
    if ($invoiceExpense->safe_log()->exists()) {
      $invoiceExpense->safe_log->delete();
      $invoiceExpense->updateQuietly(['safe_log_id' => null]);
    }
    $safe_log = $invoiceExpense->safe_log()->create([
      'price'      => $invoiceExpense->price,
      'content'    => sprintf("%s gider tipinde kasadan %s %s para çıkışı oldu", $invoiceExpense->expense_type->name, $invoiceExpense->price, $invoiceExpense->safe->currency->code),
      'safe_id'    => $invoiceExpense->safe->id,
      'input'      => AppHelper::EXPENSE_OUTPUT,
      'enter_date' => $invoiceExpense->invoice->invoice_date
    ]);
    $invoiceExpense->safe_log()->associate($safe_log)->saveQuietly();
  }

  public function deleted(InvoiceExpense $invoiceExpense)
  {
    if ($invoiceExpense->safe_log()->exists()) {
      $invoiceExpense->safe_log->delete();
    }
  }
}
