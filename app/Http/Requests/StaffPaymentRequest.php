<?php

namespace App\Http\Requests;

use App\Rules\PriceGreaterThenOne;
use Illuminate\Foundation\Http\FormRequest;

class StaffPaymentRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      'price' => [new PriceGreaterThenOne()],
      'safe_id' => 'exists:safes,id',
      'staff_payment_type_id' => 'exists:staff_payment_types,id',
    ];
  }
}
