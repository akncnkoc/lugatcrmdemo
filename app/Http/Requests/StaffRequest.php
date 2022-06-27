<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'name'          => 'required|min:3|max:50',
      'staff_role_id' => 'exists:staff_roles,id',
      'safe_id'       => 'sometimes|exists:safes,id'
    ];
  }
}
