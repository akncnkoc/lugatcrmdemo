<?php

namespace App\ApexChart;

class ApexChart
{
  use ApexChartChartValues;

  public string $id;
  public mixed $series;
  public mixed $legend;
  public mixed $dataLabels;
  public mixed $fill;
  public mixed $stroke;
  public mixed $xaxis;
  public mixed $yaxis;
  public mixed $states;
  public mixed $tooltip;
  public mixed $colors;
  public mixed $grid;
  public mixed $markers;
  public array $labels;

  public function __construct($id = "")
  {
    $this->id = $id;
    $this->series = [];
    return $this;
  }


  public function setChart(string $type, int $height = 100, bool $toolbarShown = false): static
  {
    $this->chart['id'] = $this->id;
    $this->chart['type'] = $type;
    $this->chart['height'] = $height;
    $this->chart['toolbar']['show'] = $toolbarShown;
    $this->chart['zoom']['enabled'] = false;
    return $this;
  }

  public function setLegendShown(bool $show = false): static
  {
    $this->legend['show'] = $show;
    return $this;
  }


  public function setDataLabelsEnabled(bool $enabled = false): static
  {
    $this->dataLabels['enabled'] = $enabled;
    return $this;
  }

  public function setLabels(mixed $labels): static
  {
    $this->labels = $labels;
    return $this;
  }

  public function setSeries(mixed $series): static
  {
    $this->series = $series;
    return $this;
  }

  public function setFill(string $type, int $opacity): static
  {
    $this->fill['type'] = $type;
    $this->fill['opacity'] = $opacity;
    return $this;
  }

  public function setStroke(string $curve = 'smooth', bool $show = true, int $width = 2, mixed $colors = []): static
  {
    $this->stroke['curve'] = $curve;
    $this->stroke['show'] = $show;
    $this->stroke['width'] = $width;
    $this->stroke['colors'] = $colors;
    return $this;
  }

  public function setXAxis(
    bool   $axisBorderShown,
    bool   $axisTickShown,
    bool   $labelsShown,
    string $crosshairsPosition,
    string $crosshairsStrokeColor,
    int    $crosshairsStrokeWidth,
    int    $crosshairsStrokeDashArray,
    int    $tooltipEnabled,
    int    $tooltipOffsetY,
    string $tooltipStyleFontSize,
  ): static
  {
    $this->xaxis['axisBorder']['show'] = $axisBorderShown;
    $this->xaxis['axisTicks']['show'] = $axisTickShown;
    $this->xaxis['labels']['show'] = $labelsShown;
    $this->xaxis['crosshairs']['position'] = $crosshairsPosition;
    $this->xaxis['crosshairs']['stroke']['color'] = $crosshairsStrokeColor;
    $this->xaxis['crosshairs']['stroke']['width'] = $crosshairsStrokeWidth;
    $this->xaxis['crosshairs']['stroke']['dashArray'] = $crosshairsStrokeDashArray;
    $this->xaxis['tooltip']['enabled'] = $tooltipEnabled;
    $this->xaxis['tooltip']['offsetY'] = $tooltipOffsetY;
    $this->xaxis['tooltip']['style']['fontSize'] = $tooltipStyleFontSize;
    return $this;
  }

  public function setYAxis(bool $labelsShown): static
  {
    $this->yaxis['labels']['show'] = $labelsShown;
    return $this;
  }

  public function setStates(
    string $normalFilterType,
    int    $normalFilterValue,
    string $hoverFilterType,
    int    $hoverFilterValue,
    string $activeFilterType,
    int    $activeFilterValue,
    bool   $activeMultipleDataPointSelection
  ): static
  {
    $this->states['normal']['filter']['type'] = $normalFilterType;
    $this->states['normal']['filter']['value'] = $normalFilterValue;
    $this->states['hover']['filter']['type'] = $hoverFilterType;
    $this->states['hover']['filter']['value'] = $hoverFilterValue;
    $this->states['active']['filter']['type'] = $activeFilterType;
    $this->states['active']['filter']['value'] = $activeFilterValue;
    $this->states['active']['allowMultipleDataPointsSelection'] = $activeMultipleDataPointSelection;
    return $this;
  }

  public function setTooltip(
    string $styleFontSize,
    string $xFormatter,
    string $yFormatter,
  ): static
  {
    $this->tooltip['style']['fontSize'] = $styleFontSize;
    $this->tooltip['x']['formatter'] = $xFormatter;
    $this->tooltip['y']['formatter'] = $yFormatter;
    return $this;
  }

  public function setColors(array $colors): static
  {
    $this->colors = $colors;
    return $this;
  }

  public function setGrid(
    int  $strokeDashArray,
    int  $paddingTop,
    int  $paddingRight,
    int  $paddingBottom,
    int  $paddingLeft,
    bool $yAxisLinesShown
  ): static
  {
    $this->grid['strokeDashArray'] = $strokeDashArray;
    $this->grid['padding']['top'] = $paddingTop;
    $this->grid['padding']['right'] = $paddingRight;
    $this->grid['padding']['bottom'] = $paddingBottom;
    $this->grid['padding']['left'] = $paddingLeft;
    $this->grid['yaxis']['lines']['show'] = $yAxisLinesShown;
    return $this;
  }

  public function setMarkers(string $strokeColor, int $strokeWidth): static
  {
    $this->markers['strokeColor'] = $strokeColor;
    $this->markers['strokeWidth'] = $strokeWidth;
    return $this;
  }

  /***
   * @param string $name
   * @param array $data
   * @return $this
   */
  public function addSeries(string $name, array $data): static
  {
    $this->series[] = [
      'name' => $name,
      'data' => $data
    ];
    return $this;
  }

  public function addLabels(array $labels): static
  {
    $this->labels = $labels;
    return $this;
  }

  public function toJson()
  {
    $options = [
      'series' => $this->series,
      'chart' => $this->chart,
      'legend' => $this->legend,
      'dataLabels' => $this->dataLabels,
      'fill' => $this->fill,
      'stroke' => $this->stroke,
      'xaxis' => $this->xaxis,
      'yaxis' => $this->yaxis,
      'states' => $this->states,
      'tooltip' => $this->tooltip,
      'colors' => $this->colors,
      'grid' => $this->grid,
      'markers' => $this->markers,
      'labels' => $this->labels
    ];

    return json_encode($options);
  }
}
