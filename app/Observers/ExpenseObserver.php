<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\Expense;

class ExpenseObserver
{
  public function created(Expense $expense)
  {
    $safe_log = $expense->safe_log()->create([
      'price'        => $expense->price,
      'content'      => sprintf("%s gider tipinde kasadan %s %s para çıkışı oldu", $expense->expense_type->name, $expense->price, $expense->safe->currency->code),
      'safe_id'      => $expense->safe->id,
      'process_type' => AppHelper::OUTPUT,
      'date'         => $expense->date
    ]);
    $expense->safe_log()->associate($safe_log)->saveQuietly();
  }

  public function updated(Expense $expense)
  {
    if ($expense->safe_log()->exists()) {
      $expense->safe_log->delete();
      $expense->saveQuietly(['safe_log_id', null]);
    }
    $safe_log = $expense->safe_log()->create([
      'price'        => $expense->price,
      'content'      => sprintf("%s gider tipinde kasadan %s %s para çıkışı oldu", $expense->expense_type->name, $expense->price, $expense->safe->currency->code),
      'safe_id'      => $expense->safe->id,
      'process_type' => AppHelper::OUTPUT,
      'date'         => $expense->date
    ]);
    $expense->safe_log()->associate($safe_log)->saveQuietly();
  }

  public function deleted(Expense $expense)
  {
    if ($expense->safe_log()->exists()) {
      $expense->safe_log->delete();
    }
  }
}
