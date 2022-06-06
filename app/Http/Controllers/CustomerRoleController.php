<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\CustomerRole;
use Illuminate\Http\Request;

class CustomerRoleController extends Controller
{

  public function get(Request $request)
  {
    if ($request->ajax()) {
      return CustomerRole::where('id', $request->get('id'))->firstOrFail();
    }
  }
  public function all(Request $request)
  {
    if ($request->ajax()) {
      return CustomerRole::all();
    }
  }
  public function select(Request $request)
  {
    return AppHelper::_select2($request, CustomerRole::class);
  }
  public function store(Request $request)
  {
    try {
      \DB::beginTransaction();
      CustomerRole::create($request->only(['name']));
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }
  public function update(Request $request)
  {
    try {
      \DB::beginTransaction();
      $role = CustomerRole::where('id', $request->get('id'))->firstOrFail();
      $role->update($request->only(['name']));
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }

  public function delete(Request $request)
  {
    try {
      \DB::beginTransaction();
      $role = CustomerRole::where('id', $request->get('id'))->firstOrFail();
      $role->delete();
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }
}
