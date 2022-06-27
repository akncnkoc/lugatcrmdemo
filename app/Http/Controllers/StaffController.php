<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Http\Requests\StaffRequest;
use App\Models\Staff;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\EloquentDataTable;

class StaffController extends Controller
{
  public function index()
  {
    try {
      return view('pages.staff.index');
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @throws Exception
   */
  public function table(Request $request)
  {
    $staffs = Staff::with([
      'staff_role',
      'salary_safe'
    ]);
    return EloquentDataTable::create($staffs)
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
        if (!empty($request->get('staff_roles'))) {
          $query->whereHas('staff_role', function (Builder $row) use ($request) {
            $row->whereIn('id', $request->get('staff_roles'));
          });
        }
      })
      ->make();
  }

  public function get(Request $request)
  {
    try {
      return response()->json(Staff::with(['staff_role', 'salary_safe'])->find($request->get('id')));
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @throws Throwable
   */
  public function store(StaffRequest $request)
  {
    try {
      $request->merge([
        'salary' => AppHelper::currencyToDecimal($request->get('salary'))
      ]);
      DB::beginTransaction();
      Staff::create($request->only([
        'name',
        'surname',
        'phone',
        'email',
        'salary',
        'staff_role_id',
        'salary_safe_id',
        'comment'
      ]));
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
  public function update(StaffRequest $request)
  {
    try {
      $request->merge([
        'salary' => AppHelper::currencyToDecimal($request->get('salary'))
      ]);
      $staff = Staff::where('id', $request->get('id'))->firstOrFail();
      $staff->update($request->only([
        'name',
        'surname',
        'phone',
        'email',
        'salary',
        'staff_role_id',
        'salary_safe_id',
        'comment'
      ]));
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getLine(), 500);
    }
  }

  /**
   * @throws Throwable
   */
  public function delete(Request $request)
  {
    try {
      DB::beginTransaction();
      $staff = Staff::where('id', $request->get('id'))->firstOrFail();
      $staff->delete();
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }
}
