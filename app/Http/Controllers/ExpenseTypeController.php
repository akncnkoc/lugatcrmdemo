<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\ExpenseType;
use DB;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class ExpenseTypeController extends Controller
{
  public function all()
  {
    return ExpenseType::all();
  }

  public function select(Request $request)
  {
    return AppHelper::_select2($request, ExpenseType::class);
  }

  /**
   * @throws Throwable
   */
  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      ExpenseType::create($request->only(['name']));
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
      $role = ExpenseType::where('id', $request->get('id'))->firstOrFail();
      $role->update($request->only(['name']));
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  public function get(Request $request)
  {
    return ExpenseType::where('id', $request->get('id'))->firstOrFail();
  }

  /**
   * @throws Throwable
   */
  public function delete(Request $request)
  {
    try {
      DB::beginTransaction();
      $type = ExpenseType::where('id', $request->get('id'))->firstOrFail();
      $type->delete();
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }
}
