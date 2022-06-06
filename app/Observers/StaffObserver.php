<?php

namespace App\Observers;

use App\Models\Staff;

class StaffObserver
{
  public function deleted(Staff $staff)
  {
    $staff->payments->map->delete();
  }
}
