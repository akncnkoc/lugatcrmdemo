<?php

namespace App\Http\Controllers;

use App;
use App\ApexChart\ApexChart;
use App\AppHelper;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\Safe;
use App\Models\SafeLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
  public function index()
  {
    return view('pages.dashboard.index');
  }

  public function yearlyPriceReport()
  {
    $current_year_invoice_products = InvoiceProduct::with(['safe.currency', 'invoice'])
      ->whereHas('invoice', function (Builder $builder) {
        $builder->whereBetween('invoice_date', AppHelper::searchedDates('year'));
      })
      ->get()
      ->sortBy(function (InvoiceProduct $q) {
        return $q->invoice->invoice_date;
      });
    $year_ago_invoice_products = InvoiceProduct::with(['safe.currency', 'invoice'])
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
      $invoiceDate = Carbon::parse($product->invoice->invoice_date)
        ->getTranslatedMonthName();
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
    $chart->setType("area")
      ->setHeight(150)
      ->setToolbar()
      ->addLocale(AppHelper::getApexChartLocaleConfiguration())
      ->setDefaultLocale(App::getLocale())
      ->setZoom()
      ->setDataLabelsEnabled(false)
      ->setFill("solid", 0)
      ->setStroke("smooth", true, 2, ["#3F4254"])
      ->setXAxis(false, false, false, "front", "#3F4254", 1, 3, true, 0, "12px")
      ->setYAxis(false)
      ->setStates('none', 0, 'none', 0, 'none', 0, false)
      ->setTooltip("12px", "", "")
      ->setColors(["#50CD89"])
      ->setGrid(4, 0, 0, 0, 0, true)
      ->setMarkers("#3F4254", 2)
      ->addSeries('Toplam Kazanılan Miktar ' . $primaryCurrency->code . " ", $totaled_prices)
      ->addLabels(array_keys($groupedByDate));

    return response()->json([
      'yearly_price_chart'          => $chart,
      'yearly_price_total'          => $globalTotal,
      'yearly_price_exchange_ratio' => $beforeYearTotalPercentage
    ]);
  }

  public function yearlyExpenseReport()
  {
    $current_year_expenses = Expense::with(['safe.currency', 'expense_type'])->whereBetween('date', AppHelper::searchedDates('year'))->get();

    $labels = AppHelper::getAllMonths();
    $totaled_prices = [];
    $primaryCurrency = AppHelper::getPrimaryCurrency();
    foreach ($labels as $month) {
      foreach (ExpenseType::all() as $expense_type) {
        $totaled_prices[$month]["month"] = $month;
        $totaled_prices[$month][$expense_type->name . " " . $primaryCurrency->code] = 0;
      }
    }
    $current_year_expenses->each(function (Expense $expense) use (&$totaled_prices, $primaryCurrency) {
      $month = Carbon::parse($expense->date)->monthName;
      $totaled_prices[$month][$expense->expense_type->name . " " . $primaryCurrency->code] += AppHelper::convertedPrice($expense, $primaryCurrency);
    });


    return response()->json(array_values($totaled_prices));
  }

  public function yearlySafeReport()
  {
    $current_year_safes = SafeLog::with(['safe.currency'])
      ->where('process_type', AppHelper::INPUT)
      ->whereBetween('date', AppHelper::searchedDates('year'))
      ->get();


    $labels = AppHelper::getAllMonths();
    $totaled_prices = [];
    $primaryCurrency = AppHelper::getPrimaryCurrency();
    foreach ($labels as $month) {
      foreach (Safe::all() as $safe) {
        $totaled_prices[$month]["month"] = $month;
        $totaled_prices[$month][sprintf("%s (%s)", $safe->name, $safe->currency->code)] = 0;
      }
    }
    $current_year_safes->map(function (SafeLog $safeLog) use (&$totaled_prices, $primaryCurrency) {
      $month = Carbon::parse($safeLog->date)->monthName;
        $totaled_prices[$month][$safeLog->safe->name . " (" . $safeLog->safe->currency->code . ")"] +=
        AppHelper::convertedPrice($safeLog, $primaryCurrency);
    });
    return response()->json(array_values($totaled_prices));
  }

  public function yearlyProductReport()
  {
    $query = InvoiceProduct::all()
      ->flatten()
      ->mapTogroups(function ($pivot) {
        return [$pivot->product_id => $pivot->count];
      });

    $bestProductIds = $query
      ->map
      ->sum()
      ->sortDesc()
      ->take(5)
      ->keys()
      ->toArray();

    $counts = [];
    $query->sortDesc()
      ->take(5)
      ->map(function ($row) use (&$counts) {
        $counts[] = count($row);
      });

    if (count($bestProductIds) > 0) {
      $chart = new ApexChart("yearlyProductReport");
      $chart
        ->setChart("donut", 150)
        ->addLocale(AppHelper::getApexChartLocaleConfiguration())
        ->setDefaultLocale(App::getLocale())
        ->setToolbar()
        ->setZoom()
        ->setDataLabelsEnabled(false)
        ->setLabels(Product::whereIn('id', $bestProductIds)
          ->get()
          ->pluck('name')
          ->toArray())
        ->setSeries($counts);

      return ['yearly_product_chart' => $chart, 'yearly_product_total' => array_sum($counts)];
    } else {
      return response()->json(['status' => 'warning', 'message' => 'notfound']);
    }
  }
}
