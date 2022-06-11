<?php

namespace App\ApexChart;

trait ApexChartChartValues
{
  public mixed $chart = [];


  public function setType(string $type = "line" | "area" | "bar" | "radar" | "histogram" | "pie" | "donut" | "radialBar" | "scatter" | "bubble" | "heatmap" | "candlestick"): static
  {
    $this->chart['type'] = $type;
    return $this;
  }

  public function setWidth(string|int $width = 400): static
  {
    $this->chart['width'] = $width;
    return $this;
  }

  public function setToolbar(bool $show = true, mixed $tools = []): static
  {
    $this->chart['toolbar']['show'] = $show;
    $this->chart['toolbar']['tools'] = $tools;
    return $this;
  }
  public function setZoom(bool $enabled = true): static
  {
    $this->chart['zoom']['enabled'] = $enabled;
    return $this;
  }

  /**
   * @param string $backgroundColor
   * @return $this
   */
  public function setChartBackground(string $backgroundColor = "#fff"): static
  {
    $this->chart['background'] = $backgroundColor;
    return $this;
  }

  public function setDefaultLocale(string $defaultLocale = "en"): static
  {
    $this->chart['defaultLocale'] = $defaultLocale;
    return $this;
  }

  public function setFontFamily(string $fontFamily = "Helvetica, Arial, sans-serif"): static
  {
    $this->chart['fontFamily'] = $fontFamily;
    return $this;
  }

  public function setForeColor(string $foreColor = "#373d3f"): static
  {
    $this->chart['foreColor'] = $foreColor;
    return $this;
  }

  public function setHeight(string $height = "auto"): static
  {
    $this->chart['height'] = $height;
    return $this;
  }

  public function setID(string $id = null): static
  {
    $this->chart['id'] = $id;
    return $this;
  }

  public function setNewLocale(mixed $locale = []): static
  {
    $this->chart['locales'][] = $locale;
    return $this;
  }

  public function setEvent(string $eventName = "animationEnd" | "beforeMount" | "mounted" | "updated" | "mouseMove" | "mouseLeave" | "click" | "legendClick" | "markerClick" | "selection" | "dataPointSelection" | "dataPointMouseEnter" | "dataPointMouseLeave" | "beforeZoom" | "beforeResetZoom" | "zoomed" | "scrolled", string $function): static
  {
    $this->chart['events'][$eventName] = $function;
    return $this;
  }

  public function setAnimationEnabled(bool $animationEnabled = true): static
  {
    $this->chart['animations']['enabled'] = $animationEnabled;
    return $this;
  }

  public function setAnimationEasing(string $animationEasing = "easeinout" | "linear" | "easein" | "easeout"): static
  {
    $this->chart['animations']['easing'] = $animationEasing;
    return $this;
  }

  public function setAnimationSpeed(int $animationSpeed = 800): static
  {
    $this->chart['animations']['speed'] = 800;
    return $this;
  }

  public function setParentHeightOffset(int $parentHeightOffset = 15): static
  {
    $this->chart['parentHeightOffset'] = $parentHeightOffset;
    return $this;
  }

  public function setReDrawOnParentResize(bool $redrawOnParentResize = true): static
  {
    $this->chart['redrawOnParentResize'] = $redrawOnParentResize;
    return $this;
  }

  public function setOffsetX(int $offsetX = 0): static
  {
    $this->chart['offsetX'] = $offsetX;
    return $this;
  }

  public function setOffsetY(int $offsetY = 0): static
  {
    $this->chart['offsetY'] = $offsetY;
    return $this;
  }


}
