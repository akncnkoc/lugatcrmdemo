<?php

namespace App\Http\Requests;

use App\Rules\PriceGreaterThenOne;
use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }


  public function rules()
  {
    return [
      'price'           => [new PriceGreaterThenOne()],
      'date'            => 'date_format:d-m-Y',
      'expense_type_id' => 'exists:expense_types,id',
      "safe_id"         => 'exists:safes,id'
    ];
  }
}
