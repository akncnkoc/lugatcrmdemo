<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\SafeLog;

class SafeLogObserver
{
  public function creating(SafeLog $safeLog)
  {
    if ($safeLog->process_type == AppHelper::INPUT || $safeLog->process_type == AppHelper::CASH_REGISTER) {
      $safeLog->safe->update([
        'total' => ($safeLog->safe->total) + $safeLog->price
      ]);
    }
    if ($safeLog->process_type == AppHelper::OUTPUT) {
      $safeLog->safe->update([
        'total' => ($safeLog->safe->total) - $safeLog->price
      ]);
    }
  }

  public function deleting(SafeLog $safeLog)
  {
    if ($safeLog->process_type == AppHelper::INPUT || $safeLog->process_type == AppHelper::CASH_REGISTER) {
      $safeLog->safe->update([
        'total' => ($safeLog->safe->total) - $safeLog->price
      ]);
    }
    if ($safeLog->process_type == AppHelper::OUTPUT) {
      $safeLog->safe->update([
        'total' => ($safeLog->safe->total) + $safeLog->price
      ]);
    }
  }
}
