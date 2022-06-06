<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
  public function get(Request $request)
  {
    if ($request->ajax()) {
      return ProductType::where('id', $request->get('id'))->firstOrFail();
    }
  }
  public function all(Request $request)
  {
    if ($request->ajax()) {
      return ProductType::all();
    }
  }
  public function select(Request $request)
  {
    return AppHelper::_select2($request, ProductType::class);
  }
  public function store(Request $request)
  {
    try {
      \DB::beginTransaction();
      ProductType::create($request->only(['name', 'initial_code']));
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }
  public function update(Request $request)
  {
    try {
      \DB::beginTransaction();
      $role = ProductType::where('id', $request->get('id'))->firstOrFail();
      $role->update($request->only(['name', 'initial_code']));
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
      $type = ProductType::where('id', $request->get('id'))->firstOrFail();
      $type->delete();
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }
}
