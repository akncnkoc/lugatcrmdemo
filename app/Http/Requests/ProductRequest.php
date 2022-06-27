<?php

namespace App\Http\Requests;

use App\Rules\PriceGreaterThenOne;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'name'               => 'required|min:3|max:100',
      'product_type_id'    => 'exists:product_types,id',
      'buy_price'          => [new PriceGreaterThenOne()],
      'sale_price'         => [new PriceGreaterThenOne()],
      'buy_price_safe_id'  => 'exists:safes,id',
      'sale_price_safe_id' => 'exists:safes,id',
    ];
  }
}
