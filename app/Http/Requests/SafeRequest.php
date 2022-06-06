<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SafeRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'name' => 'required|min:3|max:50',
      'total' => 'required',
      'currency_id' => 'required|exists:currencies,id'
    ];
  }
}
