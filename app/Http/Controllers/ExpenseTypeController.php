<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
  public function get(Request $request)
  {
    if ($request->ajax()) {
      return ExpenseType::where('id', $request->get('id'))->firstOrFail();
    }
  }
  public function all(Request $request)
  {
    if ($request->ajax()) {
      return ExpenseType::all();
    }
  }
  public function select(Request $request)
  {
    return AppHelper::_select2($request, ExpenseType::class);
  }
  public function store(Request $request)
  {
    try {
      \DB::beginTransaction();
      ExpenseType::create($request->only(['name']));
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
      $role = ExpenseType::where('id', $request->get('id'))->firstOrFail();
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
      $type = ExpenseType::where('id', $request->get('id'))->firstOrFail();
      $type->delete();
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }
}
