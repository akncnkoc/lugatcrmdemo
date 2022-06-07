<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Models\Product;
use App\Models\ProductLog;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;

class ProductLogController extends Controller
{
  public function index(Request $request, $product_id)
  {
    if (!$product_id) redirect()->route('product.index')->send();
    $product = Product::where('id', $product_id)->firstOr(fn() => redirect()->route('product.index'));

    return view('pages.product.log.index', compact('product'));
  }

  public function table(Request $request, $product_id)
  {
    try {
      $product_logs = ProductLog::where('product_id', $product_id);
      return EloquentDataTable::create($product_logs)
        ->addIndexColumn()
        ->editColumn('date', function ($row) {
          return AppHelper::convertDate($row->date);
        })
        ->editColumn('process_type', function ($row){
          if ($row->process_type == AppHelper::PRODUCT_IN) return "Giriş";
          if ($row->process_type == AppHelper::PRODUCT_OUT) return "Çıkış";
          if ($row->process_type == AppHelper::PRODUCT_REBATE) return "İade";
          if ($row->process_type == AppHelper::PRODUCT_SOLD) return "Satılmış";
        })
//        ->filter(function (Builder $query) use ($request) {
//          if (!empty($request->get('name'))) {
//            $query->where('name', 'LIKE', "%" . $request->get('name') . "%");
//          }
//          if (!empty($request->get('model_code'))) {
//            $query->where('model_code', 'LIKE', "%" . $request->get('model_code') . "%");
//          }
//          if (!empty($request->get('product_type'))) {
//            $query->whereHas('product_type', function (Builder $row) use ($request) {
//              $row->where('id', $request->get('product_type'));
//            });
//          }
//          if (!empty($request->get('suppliers'))) {
//            foreach ($request->get('suppliers') as $supplier) {
//              $query->whereHas('suppliers', function (Builder $productSupplier) use ($request, $supplier) {
//                $productSupplier->where('supplier_id', $supplier);
//              });
//            }
//          }
//          if (!empty($request->get('buy_price_min') && AppHelper::currencyToDecimal($request->get('buy_price_min')))) {
//            $query->where('buy_price', '>=', AppHelper::currencyToDecimal($request->get('buy_price_min')));
//          }
//          if (!empty($request->get('buy_price_min_safe'))) {
//            $query->where('buy_price_safe_id', '=', $request->get('buy_price_min_safe'));
//          }
//          if (!empty($request->get('buy_price_max') && AppHelper::currencyToDecimal($request->get('buy_price_max')))) {
//            $query->where('buy_price', '<=', AppHelper::currencyToDecimal($request->get('buy_price_max')));
//          }
//          if (!empty($request->get('buy_price_max_safe'))) {
//            $query->where('buy_price_safe_id', '=', $request->get('buy_price_max_safe'));
//          }
//
//          if (!empty($request->get('sale_price_min') && AppHelper::currencyToDecimal($request->get('sale_price_min')))) {
//            $query->where('sale_price', '>=', AppHelper::currencyToDecimal($request->get('sale_price_min')));
//          }
//          if (!empty($request->get('sale_price_min_safe'))) {
//            $query->where('sale_price_safe_id', '=', $request->get('sale_price_min_safe'));
//          }
//          if (!empty($request->get('sale_price_max') && AppHelper::currencyToDecimal($request->get('sale_price_max')))) {
//            $query->where('sale_price', '<=', AppHelper::currencyToDecimal($request->get('sale_price_max')));
//          }
//          if (!empty($request->get('sale_price_max_safe'))) {
//            $query->where('sale_price_safe_id', '=', $request->get('sale_price_max_safe'));
//          }
//
//          if (!empty($request->get('min_stock'))) {
//            $query->where('real_stock', '>=', $request->get('min_stock'));
//          }
//          if (!empty($request->get('max_stock'))) {
//            $query->where('real_stock', '<=', $request->get('max_stock'));
//          }
//        })
        ->make();
    } catch (\Throwable $th) {
      return response()->json(false, 500);
    }
  }
}
