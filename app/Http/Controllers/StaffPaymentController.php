<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Http\Requests\StaffPaymentRequest;
use App\Models\Staff;
use App\Models\StaffPayment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;

class StaffPaymentController extends Controller
{
  public function index($staff_id)
  {
    if (!$staff_id) {
      return redirect()->route('dashboard.index');
    }
    $staff = Staff::where('id', $staff_id)->firstOr(function () {
      redirect()->route('staff.index')->send();
    });
    return view('pages.staff.payment.index', compact('staff'));
  }

  public function get(Request $request, $id)
  {
    try {
      if ($request->ajax()) {
        try {
          return response()->json(StaffPayment::with(['staff', 'safe.currency', 'payment_type'])->find($request->get('id')));
        } catch (\Exception $e) {
          return response()->json(false, 500);
        }
      }
    } catch (\Throwable $th) {
      return response()->json(false, 500);
    }
  }

  public function store(StaffPaymentRequest $request, $id)
  {
    try {
      \DB::beginTransaction();
      $request->request->add(['staff_id' => $id]);
      $request->merge([
        'price' => AppHelper::currencyToDecimal($request->get('price')),
        'date' => AppHelper::convertDate($request->get('date'), 'Y-m-d H:i:s')
      ]);
      StaffPayment::create($request->only(['price', 'safe_id', 'date', 'staff_payment_type_id', 'description', 'staff_id']));
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  public function update(StaffPaymentRequest $request, $id)
  {
    try {
      \DB::beginTransaction();
      $staffPayment = StaffPayment::where('id', $id)->firstOr(fn() => redirect()->route('staff.index')->send());
      $request->merge([
        'price' => AppHelper::currencyToDecimal($request->get('price')),
        'date' => AppHelper::convertDate($request->get('date'), 'Y-m-d H:i:s')
      ]);
      $staffPayment->update($request->only(['price', 'safe_id', 'date', 'staff_payment_type_id', 'description']));
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }


  public function delete(Request $request)
  {
    try {
      \DB::beginTransaction();
      $staffPayment = StaffPayment::where('id', $request->get('id'))->firstOr(fn() => response()->json(false)->send());
      $staffPayment->delete();
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(false, 500);
    }

  }

  public function table(Request $request, $id)
  {
    $staffs = StaffPayment::with([
      'staff',
      'payment_type',
      'safe.currency'
    ])->where('staff_id', $id);
    return EloquentDataTable::create($staffs)
      ->addIndexColumn()
      ->editColumn('date', function ($row) {
        return AppHelper::convertDate($row->date, "d.m.Y");
      })
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
        if (!empty($request->get('staff_roles'))) {
          $query->whereHas('staff_role', function (Builder $row) use ($request) {
            $row->whereIn('id', $request->get('staff_roles'));
          });
        }
      })
      ->make();
  }
}
