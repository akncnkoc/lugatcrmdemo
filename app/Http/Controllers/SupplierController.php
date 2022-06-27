<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\EloquentDataTable;

class SupplierController extends Controller
{
  public function index()
  {
    return view('pages.supplier.index');
  }

  public function table(Request $request)
  {
    try {
      $suppliers = Supplier::query();
      return EloquentDataTable::create($suppliers)
        ->addIndexColumn()
        ->filter(function (Builder $query) use ($request) {
          if (!empty($request->get('name'))) {
            $query->where('name', 'LIKE', "%" . $request->get('name') . "%");
          }
          if (!empty($request->get('email'))) {
            $query->where('email', 'LIKE', "%" . $request->get('email') . "%");
          }
          if (!empty($request->get('phone'))) {
            $query->where('phone', 'LIKE', "%" . $request->get('phone') . "%");
          }
        })
        ->make();
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  public function get(Request $request)
  {
    try {
      return response()->json(Supplier::find($request->get('id')));
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @throws Throwable
   */
  public function store(SupplierRequest $request)
  {
    try {
      DB::beginTransaction();
      Supplier::create($request->only(['name', 'phone', 'email']));
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 5000);
    }
  }

  /**
   * @throws Throwable
   */
  public function update(SupplierRequest $request)
  {
    try {
      DB::beginTransaction();
      $supplier = Supplier::where('id', $request->get('id'))->firstOrFail();
      $supplier->update($request->only('name', 'phone', 'email'));
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
  public function delete(Request $request)
  {
    try {
      DB::beginTransaction();
      $supplier = Supplier::where('id', $request->get('id'))->firstOrFail();
      $supplier->delete();
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  public function select(Request $request)
  {
    return AppHelper::_select2($request, Supplier::class);
  }
}
