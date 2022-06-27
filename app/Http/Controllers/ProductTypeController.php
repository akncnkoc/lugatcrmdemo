<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\ProductType;
use DB;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class ProductTypeController extends Controller
{
  public function all()
  {
    return ProductType::all();
  }

  public function select(Request $request)
  {
    return AppHelper::_select2($request, ProductType::class);
  }

  /**
   * @throws Throwable
   */
  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      ProductType::create($request->only(['name', 'initial_code']));
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
      $role = ProductType::where('id', $request->get('id'))->firstOrFail();
      $role->update($request->only(['name', 'initial_code']));
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  public function get(Request $request)
  {
    return ProductType::where('id', $request->get('id'))->firstOrFail();
  }

  /**
   * @throws Throwable
   */
  public function delete(Request $request)
  {
    try {
      DB::beginTransaction();
      $type = ProductType::where('id', $request->get('id'))->firstOrFail();
      $type->delete();
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }
}
