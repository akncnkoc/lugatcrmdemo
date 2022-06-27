<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Http\Requests\SupplierRegularPaymentRequest;
use App\Models\Supplier;
use App\Models\SupplierRegularPayment;
use App\Models\SupplierRegularPaymentPeriod;
use DB;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\EloquentDataTable;

class SupplierRegularPaymentController extends Controller
{
  /**
   * @param $supplier_id
   * @return Application|Factory|View
   */
  public function index($supplier_id)
  {
    $supplier = Supplier::where('id', $supplier_id)
      ->firstOr(fn() => response()
        ->json(false)
        ->send());
    return view('pages.supplier.regularpayment.index', compact('supplier'));
  }

  /**
   * @param Request $request
   * @param $supplier_id
   * @return JsonResponse
   * @throws Exception
   */
  public function table(Request $request, $supplier_id)
  {
    $regular_payments = SupplierRegularPayment::with([
      'supplier',
      'periods'
    ])
      ->where('supplier_id', $supplier_id);
    return EloquentDataTable::create($regular_payments)
      ->addIndexColumn()
      ->filter(function ($query) use ($request) {
        if (!empty($request->get('name'))) {
          $query->where('name', 'LIKE', "%" . $request->get('name') . "%");
        }
      })
      ->make();
  }

  public function get(Request $request)
  {
    try {
      $supplier_regular_payment = SupplierRegularPayment::with([
        'supplier',
        'periods.safe'
      ])->where('id', $request->get('id'))
        ->firstOr(fn() => response()
          ->json(false)
          ->send());

      return response()->json($supplier_regular_payment);
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @param SupplierRegularPaymentRequest $request
   * @param $supplier_id
   * @return JsonResponse
   * @throws Throwable
   */
  public function store(SupplierRegularPaymentRequest $request, $supplier_id)
  {
    try {
      Supplier::where('id', $supplier_id)
        ->firstOr(fn() => response()
          ->json(false)
          ->send());

      $request->merge(['supplier_id' => $supplier_id]);
      DB::beginTransaction();
      $supplier_regular_payment = SupplierRegularPayment::create($request->only([
        'name',
        'comment',
        'supplier_id'
      ]));

      if ($request->has('regular_payment_period')) {
        foreach ($request->get('regular_payment_period') as $regular_payment_period) {
          $price = AppHelper::currencyToDecimal($regular_payment_period['price']);
          if ($price > 0) {
            SupplierRegularPaymentPeriod::create([
              'supplier_regular_payment_id' => $supplier_regular_payment->id,
              'date'                        => AppHelper::convertDate($regular_payment_period["date"], "Y-m-d H:i:s"),
              'price'                       => $price,
              'safe_id'                     => $regular_payment_period['safe_id'],
              'completed'                   => isset($regular_payment_period['completed'])
            ]);
          }
        }
      }
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getLine(), 500);
    }
  }

  /**
   * @throws Throwable
   */
  public function update(SupplierRegularPaymentRequest $request)
  {
    try {
      $supplier_regular_payment = SupplierRegularPayment::where('id', $request->get('id'))->firstOr(fn() => response()->json(false)->send());

      DB::beginTransaction();

      $supplier_regular_payment->update($request->only([
        'name',
        'comment'
      ]));

      if ($request->has('regular_payment_period_edit')) {
        foreach ($request->get('regular_payment_period_edit') as $regular_payment_period) {
          $price = AppHelper::currencyToDecimal($regular_payment_period['price']);
          if ($price > 0) {
            SupplierRegularPaymentPeriod::create([
              'supplier_regular_payment_id' => $supplier_regular_payment->id,
              'date'                        => AppHelper::convertDate($regular_payment_period["date"], "Y-m-d H:i:s"),
              'price'                       => $price,
              'safe_id'                     => $regular_payment_period['safe_id'],
              'completed'                   => isset($regular_payment_period['completed'])
            ]);
          }
        }
      }
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
      SupplierRegularPayment::where('id', $request->get('id'))->delete();
      return response()->json(true);
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }
}
