<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\IncomingWaybill;
use App\Models\IncomingWaybillProduct;
use App\Models\Product;
use App\Models\ProductLog;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\EloquentDataTable;

class IncomingWaybillController extends Controller
{
  public function index()
  {
    return view('pages.product.waybill.incoming.index');
  }

  /**
   * @throws Exception
   */
  public function table(Request $request)
  {
    $incomingWaybills = IncomingWaybill::with([
      'supplier',
      'products'
    ]);
    return EloquentDataTable::create($incomingWaybills)
      ->addIndexColumn()
      ->editColumn('date', function ($row) {
        return AppHelper::convertDate($row->waybill_date, "d.m.Y");
      })
      ->addColumn('totaled_entered_product', function (IncomingWaybill $incomingWaybill) {
        return $incomingWaybill->products()
          ->count();
      })
      ->addColumn('waybill_totaled_prices', function (IncomingWaybill $incomingWaybill) {
        $totaledSalePrices = [];
        $totaledBuyPrices = [];
        $incomingWaybill->products->each(function (IncomingWaybillProduct $incomingWaybillProduct) use (&$totaledSalePrices, &$totaledBuyPrices) {
          $searchedBuy = in_array($incomingWaybillProduct->buy_price_safe->currency->id, array_column($totaledBuyPrices, 'currency_id'));
          $searchedBuyIndex = array_search($incomingWaybillProduct->buy_price_safe->currency->id, array_column($totaledBuyPrices, 'currency_id'));

          if (!$searchedBuy) {
            $totaledBuyPrices[] = [
              'currency_id'   => $incomingWaybillProduct->buy_price_safe->currency->id,
              'currency_code' => $incomingWaybillProduct->buy_price_safe->currency->code,
              'total'         => (float)$incomingWaybillProduct->buy_price
            ];
          } else {
            $totaledBuyPrices[$searchedBuyIndex]['total'] += (float)$incomingWaybillProduct->buy_price;
          }

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
        for ($i = 0; $i < count($totaledBuyPrices); $i++) {
          $html .= sprintf("(%s %s) &nbsp;&nbsp;/&nbsp;&nbsp;", $totaledBuyPrices[$i]['total'], $totaledBuyPrices[$i]['currency_code']);
          $html .= "<br/>";
        }
        $html .= "</div>";
        $html .= "<div>";
        for ($i = 0; $i < count($totaledSalePrices); $i++) {
          $html .= sprintf("(%s %s)", $totaledSalePrices[$i]['total'], $totaledSalePrices[$i]['currency_code']);
          $html .= "<br/>";
        }
        $html .= "</div>";
        return $html . "</div>";
      })
      ->rawColumns(['waybill_totaled_prices'])
      ->filter(function (Builder $query) use ($request) {
        if (!empty($request->get('suppliers'))) {
          $query->whereIn('supplier_id', $request->get('suppliers'));
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
      return response()->json(IncomingWaybill::with('products.sale_price_safe', 'products.buy_price_safe', 'products.product', 'supplier')->find($request->get('id')));
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
      $incomingWaybill = IncomingWaybill::create([
        'waybill_date' => $request->get('date'),
        'supplier_id'  => $request->get('supplier_id')
      ]);
      if ($request->has('waybill_product')) {
        foreach ($request->get('waybill_product') as $waybill_product) {
          for ($i = 0; $i < (int)$waybill_product['quantity']; $i++) {
            $product = Product::findOrFail($waybill_product['product_id']);
            $product->incoming_waybill_products()->create([
              'buy_price'          => AppHelper::currencyToDecimal($waybill_product['buy_price']),
              'buy_price_safe_id'  => $waybill_product['buy_price_safe_id'],
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
      $incomingWaybill = IncomingWaybill::where('id', $request->get('id'))->firstOr(fn() => response()->json(false)->send());
      $incomingWaybill->update([
        'waybill_date' => $request->get('waybill_date'),
        'supplier_id'  => $request->get('supplier_id')
      ]);
      if ($request->has('waybill_product_edit')) {
        foreach ($request->get('waybill_product_edit') as $waybillProductSendItem) {
          $waybillProductItem = IncomingWaybillProduct::where('product_code', $waybillProductSendItem['product_code']);
          $waybillProductItem->update([
            'buy_price'          => AppHelper::currencyToDecimal($waybillProductSendItem['buy_price']),
            'buy_price_safe_id'  => $waybillProductSendItem['buy_price_safe_id'],
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
      $incomingWaybill = IncomingWaybill::where('id', $request->get('id'))->firstOr(fn() => response()->json(false)->send());
      $incomingWaybill->products->each(function (IncomingWaybillProduct $item) use ($incomingWaybill) {
        ProductLog::where('product_id', $item->product_id)->where('waybill_id', $incomingWaybill->id)->get()->each(fn(ProductLog $productLog) => $productLog->forceDelete());
        $item->forceDelete();
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
