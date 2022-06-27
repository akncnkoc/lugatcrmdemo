<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\EloquentDataTable;

class ExpenseController extends Controller
{
  public function index()
  {
    return view('pages.expense.index');
  }

  /**
   * @throws Throwable
   */
  public function store(ExpenseRequest $request)
  {
    try {
      $request->merge([
        'date'  => AppHelper::convertDate($request->get('date'), 'Y-m-d H:i:s'),
        'price' => AppHelper::currencyToDecimal($request->get('price'))
      ]);
      DB::beginTransaction();
      Expense::create($request->only(['expense_type_id', 'price', 'safe_id', 'comment', 'date']));
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  public function get(Request $request)
  {
    try {
      return response()->json(Expense::with('expense_type', 'safe.currency')->find($request->get('id')));
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @throws Throwable
   */
  public function update(ExpenseRequest $request)
  {
    try {
      $request->merge([
        'date'  => AppHelper::convertDate($request->get('date'), 'Y-m-d H:i:s'),
        'price' => AppHelper::currencyToDecimal($request->get('price'))
      ]);
      DB::beginTransaction();
      $expense = Expense::where('id', $request->get('id'))->firstOrFail();
      $expense->update($request->only(['expense_type_id', 'price', 'safe_id', 'comment', 'date']));
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  public function delete(Request $request)
  {
    try {
      Expense::where('id', $request->get('id'))->delete();
      return response()->json(true);
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @throws Exception
   */
  public function table(Request $request)
  {
    $expenses = Expense::with([
      'expense_type',
      'safe_log',
      'safe.currency'
    ]);
    return EloquentDataTable::create($expenses)
      ->addIndexColumn()
      ->editColumn('date', function ($row) {
        return AppHelper::convertDate($row->date, "d.m.Y");
      })
      ->filter(function ($query) use ($request) {
        if (!empty($request->get('min_date'))) {
          $query->where('date', '>=', AppHelper::convertDate($request->get('min_date'), 'Y-m-d'));
          if (!empty($request->get('max_date'))) {
            $query->where('date', '<=', AppHelper::convertDate($request->get('max_date'), 'Y-m-d'));
          }
        }
        if (!empty($request->get('expense_type'))) {
          $query->whereHas('expense_type', function (Builder $row) use ($request) {
            $row->where('id', $request->get('expense_type'));
          });
        }
        if (!empty($request->get('safe'))) {
          $query->whereHas('safe', function (Builder $row) use ($request) {
            $row->where('id', $request->get('safe'));
          });
        }
        if (!empty($request->get('min_price')) && AppHelper::currencyToDecimal($request->get('min_price'))) {
          $query->where('price', '>=', AppHelper::currencyToDecimal($request->get('min_price')));
        }
        if (!empty($request->get('max_price')) && AppHelper::currencyToDecimal($request->get('max_price'))) {
          $query->where('price', '<=', AppHelper::currencyToDecimal($request->get('max_price')));
        }
      })
      ->make();
  }
}
