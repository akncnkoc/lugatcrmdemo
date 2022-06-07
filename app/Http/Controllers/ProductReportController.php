<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Charts\ProductYearlySaleChart;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductReportController extends Controller
{
  public function index(Request $request, $product_id)
  {
    $product = Product::where('id', $product_id)->firstOr(fn() => redirect()->route('product.index')->send());
    return view('pages.product.report.index', compact('product'));
  }

  public function report(Request $request, ProductYearlySaleChart $productYearlySaleChart)
  {
    $build = $productYearlySaleChart->build($request->get('id'));
    $build->id = "yearlySaleReport";
    return str_replace(["<script>","</script>"],["", ""],$build->script());
  }
}
