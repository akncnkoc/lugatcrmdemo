<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\EloquentDataTable;

class SupplierPaymentController extends Controller
{
  public function index($supplier_id)
  {
    if (!$supplier_id) {
      redirect()->route('supplier.index')->send();
    }
    $supplier = Supplier::where('id', $supplier_id)->firstOr(fn() => redirect()->route('supplier.index')->send());
    return view('pages.supplier.payment.index', compact('supplier'));
  }

  /**
   * @throws Exception
   */
  public function table(Request $request, $supplier_id)
  {
    $payments = SupplierPayment::with([
      'supplier',
      'safe.currency'
    ])->where('supplier_id', $supplier_id);
    return EloquentDataTable::create($payments)
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
        if (!empty($request->get('safe'))) {
          $query->whereHas('safe', function (Builder $row) use ($request) {
            $row->where('id', $request->get('safe'));
          });
        }
        if (!empty($request->get('payable')) || $request->get('payable') == "0") {
          $query->where('payable', '=', $request->get('payable'));
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

  public function get(Request $request)
  {
    try {
      return response()->json(SupplierPayment::with(['supplier', 'safe.currency'])->find($request->get('id')));
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @throws Throwable
   */
  public function store(Request $request, $supplier_id)
  {
    try {
      $request->merge([
        'price'   => AppHelper::currencyToDecimal($request->get('price')),
        'date'    => AppHelper::convertDate($request->get('date'), 'Y-m-d H:i:s'),
        'payable' => $request->has('payable')
      ]);
      Supplier::findOr($supplier_id, fn() => response()->json(false)->send());
      $request->request->add(['supplier_id' => $supplier_id]);
      DB::beginTransaction();
      SupplierPayment::create($request->only(['supplier_id', 'price', 'safe_id', 'description', 'date', 'payable']));
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
  public function update(Request $request, $payment_id)
  {
    try {
      $request->merge([
        'price'   => AppHelper::currencyToDecimal($request->get('price')),
        'date'    => AppHelper::convertDate($request->get('date'), 'Y-m-d H:i:s'),
        'payable' => $request->has('payable')
      ]);
      $payment = SupplierPayment::where('id', $payment_id)->firstOr(fn() => response()->json(false)->send());
      DB::beginTransaction();
      $payment->update($request->only(['price', 'safe_id', 'description', 'date', 'payable']));
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
      $payment = SupplierPayment::where('id', $request->get('id'))->firstOr(fn() => response()->json(false)->send());
      $payment->delete();
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }
}
