<?php

namespace App\Rules;

use App\AppHelper;
use Illuminate\Contracts\Validation\Rule;

class PriceGreaterThenOne implements Rule
{
  public function passes($attribute, $value)
  {
    return AppHelper::currencyToDecimal($value) >= 1;
  }

  public function message()
  {
    return ':attribute must be greater or equal to 1';
  }
}
