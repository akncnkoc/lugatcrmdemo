<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Http\Requests\SupplierRegularPaymentRequest;
use App\Models\Supplier;
use App\Models\SupplierRegularPayment;
use App\Models\SupplierRegularPaymentPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;

class SupplierRegularPaymentController extends Controller
{


  /**
   * @param $supplier_id
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
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
      $supplier_regular_payment = SupplierRegularPayment::with(['supplier', 'periods.safe'])->where('id', $request->get('id'))
        ->firstOr(fn() => response()
          ->json(false)
          ->send());

      return response()->json($supplier_regular_payment);

    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @param SupplierRegularPaymentRequest $request
   * @param $supplier_id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(SupplierRegularPaymentRequest $request, $supplier_id)
  {
    try {
      Supplier::where('id', $supplier_id)
        ->firstOr(fn() => response()
          ->json(false)
          ->send());

      $request->merge(['supplier_id' => $supplier_id]);
      \DB::beginTransaction();
      $supplier_regular_payment = SupplierRegularPayment::create($request->only([
        'name',
        'comment',
        'supplier_id'
      ]));

      if ($request->has('regular_payment_period')) {
        foreach ($request->get('regular_payment_period') as $regular_payment_period) {
          SupplierRegularPaymentPeriod::create([
            'supplier_regular_payment_id' => $supplier_regular_payment->id,
            'date'                        => AppHelper::convertDate($regular_payment_period["date"], "Y-m-d H:i:s"),
            'price'                       => AppHelper::currencyToDecimal($regular_payment_period['price']),
            'safe_id'                     => $regular_payment_period['safe_id'],
            'completed'                   => isset($regular_payment_period['completed'])
          ]);
        }
      }
      \DB::commit();
      return response()->json(true);
    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  public function update(SupplierRegularPaymentRequest $request, $regular_payment_id)
  {
	try{	
		$supplier_regular_payment = SupplierRegularPayment::where('id')->firstOr(fn () => response()->json(false)->send());
	}catch(\Exception $e){
		return response()->json($e->getMessage(),500);
	}
  }
}
