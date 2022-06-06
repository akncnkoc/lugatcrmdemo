<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\StaffRole;
use Illuminate\Http\Request;

class StaffRoleController extends Controller
{

  public function get(Request $request)
  {
    if ($request->ajax()) {
      return StaffRole::where('id', $request->get('id'))->firstOrFail();
    }
  }
  public function all(Request $request)
  {
    if ($request->ajax()) {
      return StaffRole::all();
    }
  }
  public function select(Request $request)
  {
    return AppHelper::_select2($request, StaffRole::class);
  }
  public function store(Request $request)
  {
    try {
      \DB::beginTransaction();
      StaffRole::create($request->only(['name']));
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
      $role = StaffRole::where('id', $request->get('id'))->firstOrFail();
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
      $role = StaffRole::where('id', $request->get('id'))->firstOrFail();
      $role->delete();
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }
}
