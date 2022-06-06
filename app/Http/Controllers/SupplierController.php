<?php

namespace App\Http\Controllers;

use DB;
use App\AppHelper;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder;

class SupplierController extends Controller
{

  public function index()
  {
    return view('pages.supplier.index');
  }
  public function get(Request $request)
  {
    try {
      if ($request->ajax()) {
        try {
          return response()->json(Supplier::find($request->get('id')));
        } catch (\Exception $e) {
          return response()->json(false, 500);
        }
      }
    } catch (\Throwable $th) {
      return response()->json(false, 500);
    }
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
    } catch (\Throwable $th) {
      return response()->json(false, 500);
    }
  }

  public function store(SupplierRequest $request)
  {
    try {
      \DB::beginTransaction();
      Supplier::create($request->only(['name', 'phone', 'email']));
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 5000);
    }
  }

  public function update(SupplierRequest $request)
  {
    try {
      \DB::beginTransaction();
      $supplier = Supplier::where('id', $request->get('id'))->firstOrFail();
      $supplier->update($request->only('name', 'phone', 'email'));
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
      $supplier = Supplier::where('id', $request->get('id'))->firstOrFail();
      $supplier->delete();
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }

  public function select(Request $request)
  {
    return AppHelper::_select2($request, Supplier::class);
  }
}
