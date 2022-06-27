<?php

namespace App\Http\Controllers;

use App\ApexChart\ApexChart;
use App\AppHelper;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductReportController extends Controller
{
  public function index( $product_id)
  {
    $product = Product::where('id', $product_id)->firstOr(fn() => redirect()->route('product.index')->send());
    return view('pages.product.report.index', compact('product'));
  }

  public function yearlyPriceReport(Request $request)
  {
    $product = Product::where('id', $request->get('id'))->firstOr(fn() => response()->json(false)->send());
    $current_year_invoice_products = InvoiceProduct::with(['safe.currency', 'invoice'])
      ->where('product_id', $product->id)
      ->whereHas('invoice', function (Builder $builder) {
        $builder->whereBetween('invoice_date', AppHelper::searchedDates('year'));
      })
      ->get()
      ->sortBy(function (InvoiceProduct $q) {
        return $q->invoice->invoice_date;
      });
    $year_ago_invoice_products = InvoiceProduct::with(['safe.currency', 'invoice'])
      ->where('product_id', $product->id)
      ->whereHas('invoice', function (Builder $builder) {
        $builder->whereBetween('invoice_date', AppHelper::searchedDates('last_year'));
      })
      ->get()
      ->sortBy(function (InvoiceProduct $q) {
        return $q->invoice->invoice_date;
      });
    $labels = [];
    $totaled_prices = [];
    $groupedByDate = $current_year_invoice_products->reduce(function ($group, InvoiceProduct $product) use (&$labels) {
      $invoiceDate = Carbon::parse($product->invoice->invoice_date)->getTranslatedMonthName();
      $group[$invoiceDate] = $group[$invoiceDate] ?? [];
      if (count($group[$invoiceDate]) == 0) {
        $labels[] = $invoiceDate;
      }
      $group[$invoiceDate][] = $product;
      return $group;
    }, []);
    $primaryCurrency = AppHelper::getPrimaryCurrency();
    $globalTotal = 0;
    $beforeYearTotal = 0;
    $year_ago_invoice_products->map(function (InvoiceProduct $invoiceProduct) use (&$beforeYearTotal, $primaryCurrency) {
      $beforeYearTotal += AppHelper::convertedPrice($invoiceProduct, $primaryCurrency);
    });
    foreach ($groupedByDate as $value) {
      if ($value && count($value) > 0) {
        $total = 0;
        foreach ($value as $item) {
          $convertedPrice = AppHelper::convertedPrice($item, $primaryCurrency);
          $total += $convertedPrice;
          $globalTotal += $convertedPrice;
        }
        $totaled_prices[] = round($total, 2);
      }
    }
    $beforeYearTotalPercentage = sprintf("%1.2f", (($globalTotal - $beforeYearTotal) / $globalTotal));
    $chart = new ApexChart("yearlyPriceReport");
    $chart->setChart("area", 150)
      ->setLegendShown()
      ->setDataLabelsEnabled()
      ->setFill("solid", 0)
      ->setStroke("smooth", true, 2, ["#3F4254"])
      ->setXAxis(false, false, false, "front", "#3F4254", 1, 3, true, 0, "12px")
      ->setYAxis(false)
      ->setStates('none', 0, 'none', 0, 'none', 0, false)
      ->setTooltip("12px", "", "")
      ->setColors(["#50CD89"])
      ->setGrid(4, 0, 0, 0, 0, true)
      ->setMarkers("#3F4254", 2)
      ->addSeries('Toplam Fiyat ' . $primaryCurrency->code . " ", $totaled_prices)
      ->addLabels(array_keys($groupedByDate));

    return response()->json([
      'yearly_price_chart'          => $chart,
      'yearly_price_total'          => $globalTotal,
      'yearly_price_exchange_ratio' => $beforeYearTotalPercentage
    ]);
  }

  public function yearlySaleReport(Request $request)
  {
    $product = Product::where('id', $request->get('id'))->firstOr(fn() => response()->json(false)->send());
    $current_year_invoice_products = InvoiceProduct::with(['safe.currency', 'invoice'])
      ->where('product_id', $product->id)
      ->whereHas('invoice', function (Builder $builder) {
        $builder->whereBetween('invoice_date', AppHelper::searchedDates('year'));
      })
      ->get()
      ->sortBy(function (InvoiceProduct $q) {
        return $q->invoice->invoice_date;
      });
    $year_ago_invoice_products = InvoiceProduct::with(['safe.currency', 'invoice'])
      ->where('product_id', $product->id)
      ->whereHas('invoice', function (Builder $builder) {
        $builder->whereBetween('invoice_date', AppHelper::searchedDates('last_year'));
      })
      ->get()
      ->sortBy(function (InvoiceProduct $q) {
        return $q->invoice->invoice_date;
      });
    $labels = [];
    $totaled_sale = [];
    $grouped_by_date = $current_year_invoice_products->reduce(function ($group, InvoiceProduct $product) use (&$labels) {
      $invoiceDate = Carbon::parse($product->invoice->invoice_date)->getTranslatedMonthName();
      $group[$invoiceDate] = $group[$invoiceDate] ?? [];
      if (count($group[$invoiceDate]) == 0) {
        $labels[] = $invoiceDate;
      }
      $group[$invoiceDate][] = $product;
      return $group;
    }, []);
    $global_total = $current_year_invoice_products->count();
    $year_ago_total = $year_ago_invoice_products->count();
    foreach ($grouped_by_date as $value) {
      if ($value && count($value) > 0) {
        $totaled_sale[] = count($value);
      }
    }
    $year_ago_product_count_percantage = sprintf("%1.2f", (($global_total - $year_ago_total) / $global_total));


    $chart = new ApexChart("yearlySaleReport");
    $chart->setChart("area", 150)
      ->setLegendShown()
      ->setDataLabelsEnabled()
      ->setFill("solid", 0)
      ->setStroke("smooth", true, 2, ["#3F4254"])
      ->setXAxis(false, false, false, "front", "#3F4254", 1, 3, true, 0, "12px")
      ->setYAxis(false)
      ->setStates('none', 0, 'none', 0, 'none', 0, false)
      ->setTooltip("12px", "", "")
      ->setColors(["#50CD89"])
      ->setGrid(4, 0, 0, 0, 0, true)
      ->setMarkers("#3F4254", 2)
      ->addSeries('Toplam Adet ', $totaled_sale)
      ->addLabels(array_keys($grouped_by_date));
    return response()->json([
      'yearly_sale_chart'          => $chart,
      'yearly_sale_total'          => $global_total,
      'yearly_sale_exchange_ratio' => $year_ago_product_count_percantage
    ]);
  }
}
