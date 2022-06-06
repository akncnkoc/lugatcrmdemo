<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\StaffPaymentType;
use Illuminate\Http\Request;

class StaffPaymentTypeController extends Controller
{
  public function get(Request $request)
  {
    if ($request->ajax()) {
      return StaffPaymentType::where('id', $request->get('id'))->firstOrFail();
    }
  }
  public function select(Request $request)
  {
    return AppHelper::_select2($request, StaffPaymentType::class);
  }
  public function all(Request $request)
  {
    if ($request->ajax()) {
      return StaffPaymentType::all();
    }
  }
  public function store(Request $request)
  {
    try {
      \DB::beginTransaction();
      StaffPaymentType::create($request->only(['name']));
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
      $type = StaffPaymentType::where('id', $request->get('id'))->firstOrFail();
      $type->update($request->only(['name']));
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
      $type = StaffPaymentType::where('id', $request->get('id'))->firstOrFail();
      $type->delete();
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }
}
