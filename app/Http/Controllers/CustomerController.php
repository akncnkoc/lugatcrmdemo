<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder;

class CustomerController extends Controller
{
  public function index(Request $request)
  {
    try {
      return view('pages.customer.index');
    } catch (\Throwable $th) {
      return response()->json(false, 500);
    }
  }
  public function get(Request $request)
  {
    try {
      if ($request->ajax()) {
        try {
          return response()->json(Customer::with('customer_role')->find($request->get('id')));
        } catch (\Exception $e) {
          return response()->json(false, 500);
        }
      }
    } catch (\Throwable $th) {
      return response()->json(false, 500);
    }
  }

  public function select(Request $request){
    return AppHelper::_select2($request, Customer::class);
  }
  public function table(Request $request)
  {
    $customers = Customer::with([
      'customer_role'
    ]);
    return EloquentDataTable::create($customers)
      ->addIndexColumn()
      ->filter(function ($query) use ($request) {
        if (!empty($request->get('name'))) {
          $query->where('name', 'LIKE', "%" . $request->get('name') . "%");
        }
        if (!empty($request->get('surname'))) {
          $query->where('surname', 'LIKE', "%" . $request->get('surname') . "%");
        }
        if (!empty($request->get('email'))) {
          $query->where('email', 'LIKE', "%" . $request->get('email') . "%");
        }
        if (!empty($request->get('phone'))) {
          $query->where('phone', 'LIKE', "%" . $request->get('phone') . "%");
        }
        if (!empty($request->get('gender')) && $request->get('gender') != "-1") {
          $query->where('gender', $request->get('gender'));
        }
        if (!empty($request->get('customer_role'))) {
          $query->whereHas('customer_role', function (Builder $row) use ($request) {
            $row->where('id', $request->get('customer_role'));
          });
        }
      })
      ->make();
  }
  public function store(CustomerRequest $request)
  {
    try {
      \DB::beginTransaction();
      Customer::create($request->only('name', 'surname', 'email', 'phone', 'comment', 'customer_role_id', 'gender', 'address'));
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }

  public function update(CustomerRequest $request)
  {
    try {
      $customer = Customer::where('id', $request->get('id'))->firstOrFail();
      $customer->update($request->only('name', 'surname', 'email', 'phone', 'comment', 'customer_role_id', 'gender', 'address'));
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json($e->getLine(), 500);
    }
  }
  public function delete(Request $request)
  {
    try {
      \DB::beginTransaction();
      $customer = Customer::where('id', $request->get('id'))->firstOrFail();
      $customer->delete();
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }
  }
}
