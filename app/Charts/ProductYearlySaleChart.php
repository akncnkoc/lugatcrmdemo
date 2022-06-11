<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class ProductYearlySaleChart
{
  protected $chart;

  public function __construct(LarapexChart $chart)
  {
    $this->chart = $chart;
  }

  public function build($product_id): \ArielMejiaDev\LarapexCharts\AreaChart
  {


    return $this->chart->areaChart()
      ->addData('Physical sales', [40, 93, 35, 42, 18, 82])
      ->setHeight(120)
      ->setToolbar(false)
      ->setColors(["orange"])
      ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
  }
}
