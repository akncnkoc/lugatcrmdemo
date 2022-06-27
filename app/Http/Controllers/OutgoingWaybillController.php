<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\OutgoingWaybill;
use App\Models\OutgoingWaybillProduct;
use App\Models\Product;
use App\Models\ProductLog;
use DB;
use Exception;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\EloquentDataTable;

class OutgoingWaybillController extends Controller
{
  public function index()
  {
    return view('pages.product.waybill.outgoing.index');
  }

  /**
   * @throws Exception
   */
  public function table(Request $request)
  {
    $incomingWaybills = OutgoingWaybill::with([
      'customer',
      'products'
    ]);
    return EloquentDataTable::create($incomingWaybills)
      ->addIndexColumn()
      ->editColumn('date', function ($row) {
        return AppHelper::convertDate($row->waybill_date, "d.m.Y");
      })
      ->addColumn('totaled_entered_product', function (OutgoingWaybill $incomingWaybill) {
        return $incomingWaybill->products()
          ->count();
      })
      ->addColumn('waybill_totaled_prices', function (OutgoingWaybill $incomingWaybill) {
        $totaledSalePrices = [];
        $incomingWaybill->products->each(function (OutgoingWaybillProduct $incomingWaybillProduct) use (&$totaledSalePrices) {
          $searchedSale = in_array($incomingWaybillProduct->sale_price_safe->currency->id, array_column($totaledSalePrices, 'currency_id'));
          $searchedSaleIndex = array_search($incomingWaybillProduct->sale_price_safe->currency->id, array_column($totaledSalePrices, 'currency_id'));

          if (!$searchedSale) {
            $totaledSalePrices[] = [
              'currency_id'   => $incomingWaybillProduct->sale_price_safe->currency->id,
              'currency_code' => $incomingWaybillProduct->sale_price_safe->currency->code,
              'total'         => (float)$incomingWaybillProduct->sale_price
            ];
          } else {
            $totaledSalePrices[$searchedSaleIndex]['total'] += (float)$incomingWaybillProduct->sale_price;
          }
        });

        $html = "<div class='d-flex align-items-center'>";
        $html .= "<div>";
        for ($i = 0; $i < count($totaledSalePrices); $i++) {
          $html .= sprintf("(%s %s)", $totaledSalePrices[$i]['total'], $totaledSalePrices[$i]['currency_code']);
          $html .= "<br/>";
        }
        $html .= "</div>";
        return $html . "</div>";
      })
      ->rawColumns(['waybill_totaled_prices'])
      ->filter(function ($query) use ($request) {
        if (!empty($request->get('customers'))) {
          $query->whereIn('customer_id', $request->get('customers'));
        }
        if (!empty($request->get('min_date'))) {
          $query->where('waybill_date', '>=', AppHelper::convertDate($request->get('min_date'), 'Y-m-d'));
          if (!empty($request->get('max_date'))) {
            $query->where('waybill_date', '<=', AppHelper::convertDate($request->get('max_date'), 'Y-m-d'));
          }
        }

        if (!empty($request->get('min_product'))) {
          $query->has('products', '>=', $request->get('min_product'));
        }
        if (!empty($request->get('max_product'))) {
          $query->has('products', '<=', $request->get('max_product'));
        }
      })
      ->make();
  }

  public function get(Request $request)
  {
    try {
      return response()->json(OutgoingWaybill::with('products.sale_price_safe', 'products.product', 'customer')->find($request->get('id')));
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @throws Throwable
   */
  public function store(Request $request)
  {
    try {
      $request->merge([
        'date' => AppHelper::convertDate($request->get('date'), 'Y-m-d H:i:s')
      ]);
      DB::beginTransaction();
      $incomingWaybill = OutgoingWaybill::create([
        'waybill_date' => $request->get('date'),
        'customer_id'  => $request->get('customer_id')
      ]);
      if ($request->has('waybill_product')) {
        foreach ($request->get('waybill_product') as $waybill_product) {
          for ($i = 0; $i < (int)$waybill_product['quantity']; $i++) {
            $product = Product::findOrFail($waybill_product['product_id']);
            $incomingWaybill->products()->create([
              'sale_price'         => AppHelper::currencyToDecimal($waybill_product['sale_price']),
              'sale_price_safe_id' => $waybill_product['sale_price_safe_id'],
              'product_id'         => $product->id,
              'waybill_id'         => $incomingWaybill->id
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

  /**
   * @throws Throwable
   */
  public function update(Request $request)
  {
    try {
      $request->merge([
        'waybill_date' => AppHelper::convertDate($request->get('waybill_date'), 'Y-m-d H:i:s')
      ]);
      DB::beginTransaction();
      $incomingWaybill = OutgoingWaybill::where('id', $request->get('id'))->firstOr(fn() => response()->json(false)->send());
      $incomingWaybill->update([
        'waybill_date' => $request->get('waybill_date'),
        'customer_id'  => $request->get('customer_id')
      ]);
      if ($request->has('waybill_product_edit')) {
        foreach ($request->get('waybill_product_edit') as $waybillProductSendItem) {
          $waybillProductItem = OutgoingWaybillProduct::where('id', $waybillProductSendItem['id']);
          $waybillProductItem->update([
            'sale_price'         => AppHelper::currencyToDecimal($waybillProductSendItem['sale_price']),
            'sale_price_safe_id' => $waybillProductSendItem['sale_price_safe_id'],
          ]);
        }
      }
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
      $incomingWaybill = OutgoingWaybill::where('id', $request->get('id'))->firstOr(fn() => response()->json(false)->send());
      $incomingWaybill->products->each(function (OutgoingWaybillProduct $item) use ($incomingWaybill) {
        ProductLog::where('product_id', $item->product_id)->where('waybill_id', $incomingWaybill->id)->get()->each(fn(ProductLog $productLog) => $productLog->forceDelete());
      });
      $incomingWaybill->delete();

      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }
}
