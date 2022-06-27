<?php

namespace App\Http\Requests;

use App\Rules\PriceGreaterThenOne;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRegularPaymentRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'id'                               => 'sometimes|exists:supplier_regular_payments,id',
      'name'                             => 'required|string|max:50',
      'regular_payment_period.*.safe_id' => 'exists:safes,id',
      'regular_payment_period.*.price'   => [new PriceGreaterThenOne()],
      'regular_payment_period.*.date'    => 'date_format:d-m-Y',
      'comment'                          => 'present|max:150'
    ];
  }
}
