<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\StaffPaymentType;
use DB;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class StaffPaymentTypeController extends Controller
{
  public function select(Request $request)
  {
    return AppHelper::_select2($request, StaffPaymentType::class);
  }

  public function all()
  {
    return StaffPaymentType::all();
  }

  /**
   * @throws Throwable
   */
  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      StaffPaymentType::create($request->only(['name']));
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @throws Throwable
   */
  public function update(Request $request)
  {
    try {
      DB::beginTransaction();
      $type = StaffPaymentType::where('id', $request->get('id'))->firstOrFail();
      $type->update($request->only(['name']));
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  public function get(Request $request)
  {
    return StaffPaymentType::where('id', $request->get('id'))->firstOrFail();
  }

  /**
   * @throws Throwable
   */
  public function delete(Request $request)
  {
    try {
      DB::beginTransaction();
      $type = StaffPaymentType::where('id', $request->get('id'))->firstOrFail();
      $type->delete();
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }
}
