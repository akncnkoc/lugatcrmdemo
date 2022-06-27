<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\Safe;

class SafeObserver
{
  public function created(Safe $safe)
  {
    $safe->safe_logs()->create([
      'content'      => sprintf("%s tarihinde %s %s tutarında kasa oluşturuldu", now()->format('d.m.Y H:i:s'), $safe->total, $safe->currency->code),
      'price'        => $safe->total,
      'safe_id'      => $safe->id,
      'date'         => now(),
      'process_type' => AppHelper::INPUT
    ]);
  }
}
