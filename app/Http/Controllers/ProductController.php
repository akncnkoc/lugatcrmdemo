<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Http\Requests\ProductRequest;
use App\Models\IncomingWaybillProduct;
use App\Models\Product;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\EloquentDataTable;

class ProductController extends Controller
{
  public function index()
  {
    return view('pages.product.index');
  }

  public function table(Request $request)
  {
    try {
      $products = Product::with([
        'buy_price_safe.currency',
        'sale_price_safe.currency',
        'product_type',
        'suppliers'
      ]);
      return EloquentDataTable::create($products)
        ->addIndexColumn()
        ->filter(function (Builder $query) use ($request) {
          if (!empty($request->get('name'))) {
            $query->where('name', 'LIKE', "%" . $request->get('name') . "%");
          }
          if (!empty($request->get('model_code'))) {
            $query->where('model_code', 'LIKE', "%" . $request->get('model_code') . "%");
          }
          if (!empty($request->get('product_type'))) {
            $query->whereHas('product_type', function (Builder $row) use ($request) {
              $row->where('id', $request->get('product_type'));
            });
          }
          if (!empty($request->get('suppliers'))) {
            foreach ($request->get('suppliers') as $supplier) {
              $query->whereHas('suppliers', function (Builder $productSupplier) use ($request, $supplier) {
                $productSupplier->where('supplier_id', $supplier);
              });
            }
          }
          if (!empty($request->get('buy_price_min') && AppHelper::currencyToDecimal($request->get('buy_price_min')))) {
            $query->where('buy_price', '>=', AppHelper::currencyToDecimal($request->get('buy_price_min')));
          }
          if (!empty($request->get('buy_price_min_safe'))) {
            $query->where('buy_price_safe_id', '=', $request->get('buy_price_min_safe'));
          }
          if (!empty($request->get('buy_price_max') && AppHelper::currencyToDecimal($request->get('buy_price_max')))) {
            $query->where('buy_price', '<=', AppHelper::currencyToDecimal($request->get('buy_price_max')));
          }
          if (!empty($request->get('buy_price_max_safe'))) {
            $query->where('buy_price_safe_id', '=', $request->get('buy_price_max_safe'));
          }

          if (!empty($request->get('sale_price_min') && AppHelper::currencyToDecimal($request->get('sale_price_min')))) {
            $query->where('sale_price', '>=', AppHelper::currencyToDecimal($request->get('sale_price_min')));
          }
          if (!empty($request->get('sale_price_min_safe'))) {
            $query->where('sale_price_safe_id', '=', $request->get('sale_price_min_safe'));
          }
          if (!empty($request->get('sale_price_max') && AppHelper::currencyToDecimal($request->get('sale_price_max')))) {
            $query->where('sale_price', '<=', AppHelper::currencyToDecimal($request->get('sale_price_max')));
          }
          if (!empty($request->get('sale_price_max_safe'))) {
            $query->where('sale_price_safe_id', '=', $request->get('sale_price_max_safe'));
          }

          if (!empty($request->get('min_stock'))) {
            $query->where('real_stock', '>=', $request->get('min_stock'));
          }
          if (!empty($request->get('max_stock'))) {
            $query->where('real_stock', '<=', $request->get('max_stock'));
          }
        })
        ->make();
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  public function get(Request $request)
  {
    try {
      return response()->json(Product::with('buy_price_safe', 'sale_price_safe', 'product_type', 'suppliers.supplier')->find($request->get('id')));
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @throws Throwable
   */
  public function store(ProductRequest $request)
  {
    try {
      $request->merge([
        'buy_price'            => AppHelper::currencyToDecimal($request->get('buy_price')),
        'sale_price'           => AppHelper::currencyToDecimal($request->get('sale_price')),
        'critical_stock_alert' => $request->has('critical_stock_alert')
      ]);
      $product = Product::create($request->only(
        [
          'name',
          'model_code',
          'product_type_id',
          'buy_price',
          'sale_price',
          'buy_price_safe_id',
          'sale_price_safe_id',
          'critical_stock_alert',
        ]
      ));
      if ($request->has('suppliers')) {
        foreach ($request->get('suppliers') as $supplier) {
          $product->suppliers()->create([
            'product_id'  => $product->id,
            'supplier_id' => $supplier
          ]);
        }
      }
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * @throws Throwable
   */
  public function update(ProductRequest $request)
  {
    try {
      DB::beginTransaction();
      $request->merge([
        'buy_price'            => AppHelper::currencyToDecimal($request->get('buy_price')),
        'sale_price'           => AppHelper::currencyToDecimal($request->get('sale_price')),
        'critical_stock_alert' => $request->has('critical_stock_alert')
      ]);
      $product = Product::where('id', $request->get('id'))->firstOrFail();
      $product->update($request->only(
        [
          'name',
          'model_code',
          'buy_price',
          'sale_price',
          'critical_stock_alert',
          'buy_price_safe_id',
          'sale_price_safe_id',
          'product_type_id'
        ]
      ));
      $product->suppliers->each->delete();
      if ($request->has('suppliers')) {
        foreach ($request->get('suppliers') as $supplier) {
          $product->suppliers()->create([
            'product_id'  => $product->id,
            'supplier_id' => $supplier
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
      $product = Product::where('id', $request->get('id'))->firstOrFail();
      if ($product->suppliers()->count() > 0) {
        $product->suppliers->each->delete();
      }
      if ($product->incoming_waybill_products()->count() > 0) {
        $product->incoming_waybill_products->each(fn (IncomingWaybillProduct $incomingWaybillProduct) => $incomingWaybillProduct->delete());
      }
      $product->delete();
      DB::commit();
      return response()->json(true);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 500);
    }
  }

  public function select(Request $request)
  {
    return AppHelper::_select2($request, Product::class);
  }
}
