<?php

namespace App\Observers;

use App\AppHelper;
use App\Models\Cargo;

class CargoObserver
{
  public function created(Cargo $cargo)
  {
    if ($cargo->paided) {
      $safe_log = $cargo->safe_log()->create([
        'price' => $cargo->price,
        'content' => sprintf("%s kargo firmasına %s takip kodlu kargo için %s %s ödendi", $cargo->cargo_company->name, $cargo->tracking_number, $cargo->price, $cargo->safe->currency->code),
        'cash_register_id' => 1,
        'commission' => 0,
        'safe_id' => $cargo->safe_id,
        'input' => AppHelper::OUTPUT,
        'enter_date' => $cargo->date_of_paid,
      ]);
      $cargo->updateQuietly(['safe_log_id' => $safe_log->id]);
    }
  }
  public function updated(Cargo $cargo)
  {
    if ($cargo->safe_log()->exists() && !$cargo->paided){
      $cargo->updateQuietly(['date_of_paid' => null]);
    }
    if ($cargo->safe_log()->exists()){
      $cargo->safe_log->delete();
      $cargo->updateQuietly(['safe_log_id' => null]);
    }
    if ($cargo->paided) {
      $safe_log = $cargo->safe_log()->create([
        'price' => $cargo->price,
        'content' => sprintf("%s kargo firmasına %s takip kodlu kargo için %s %s ödendi", $cargo->cargo_company->name, $cargo->tracking_number, $cargo->price, $cargo->safe->currency->code),
        'cash_register_id' => 1,
        'commission' => 0,
        'safe_id' => $cargo->safe_id,
        'input' => AppHelper::OUTPUT,
        'enter_date' => $cargo->date_of_paid,
      ]);
      $cargo->safe_log()->associate($safe_log)->saveQuietly();
    }
  }

  public function deleted(Cargo $cargo)
  {
    if ($cargo->safe_log()->exists())
      $cargo->safe_log->delete();
  }
}
