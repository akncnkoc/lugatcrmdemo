<?php

namespace App\Charts;

use App\AppHelper;
use App\Models\InvoiceProduct;
use App\Models\Product;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Database\Eloquent\Builder;

class ProductYearlySaleChart
{
  protected $chart;

  public function __construct(LarapexChart $chart)
  {
    $this->chart = $chart;
  }

  public function build($product_id): \ArielMejiaDev\LarapexCharts\AreaChart
  {
    $product = Product::where('id', $product_id)->firstOr(fn() => response()->json(false)->send());
    $invoice_products = InvoiceProduct::with('safe.currency', 'invoice')
      ->where('product_id', $product->id)
      ->whereHas('invoice', function (Builder $builder) {
        $builder->whereBetween('invoice_date', AppHelper::searchedDates('year'));
      })
      ->get();



    return $this->chart->areaChart()
      ->addData('Physical sales', [40, 93, 35, 42, 18, 82])
      ->setHeight(300)
      ->setToolbar(false)
      ->setColors(["orange"])
      ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
  }
}
