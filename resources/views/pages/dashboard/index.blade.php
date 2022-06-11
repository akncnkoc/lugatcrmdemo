@extends('layout.default')
@section('page-title')
  @lang('globals/words.homepage')
@endsection
@section('content')
  <div class="row g-5 g-xl-10">
    <div class="col-md-4 col-xl-4 mb-xxl-10">
      <div class="card mb-5 mb-xl-10" id="yearly-price-report-card-container">
        <div class="card-body d-flex justify-content-between flex-column px-0 pb-16">
          <div class="mb-4 px-9">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div>
                <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1" id="data-yearly-price-total">0
                </span>
                <span class="badge fs-base"
                      title="@lang('pages/dashboard.price_exchange_ratio_hint')"
                      data-bs-toggle="tooltip"
                      data-bs-trigger="hover"
                      data-bs-custom-class="tooltip-dark"
                      data-bs-dismiss="click"
                      data-bs-placement="right">
                  <span id="data-price-exchange-ratio"

                  >2.2%
                  </span>
                </span>
              </div>
            </div>
            <span class="fs-6 fw-bold text-gray-400">@lang('pages/dashboard.this_year_total_price')</span>
          </div>
          <div id="yearlyPriceReport" class="min-h-auto" style="height: 150px"></div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-xl-4 mb-xxl-10">
      <div class="card mb-5 mb-xl-10" id="yearly-price-report-card-container">
        <div class="card-body d-flex justify-content-between flex-column px-0 pb-16">
          <div class="mb-4 px-9">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div>
                <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1" id="data-yearly-product-total">0
                </span>
              </div>
            </div>
            <span class="fs-6 fw-bold text-gray-400">@lang('pages/dashboard.this_year_saled_five_total_product')</span>
          </div>
          <div id="yearlyProductReport" class="min-h-auto" style="height: 150px"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-5 g-xl-10">
    <div class="col-xxl-6 mb-xl-10">
      <div class="card card-flush">
        <div class="card-header pt-9">
          <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder text-dark">@lang('pages/dashboard.safe_staticstics')</span>
            <span class="text-gray-400 pt-2 fw-bold fs-6">@lang('pages/dashboard.this_year_safe_inputs')</span>
          </h3>
        </div>
        <div class="card-body pt-5">
          <div id="data-yearly-safe-report-container" class="w-100 h-400px"></div>
        </div>
      </div>
    </div>
    <div class="col-xxl-6 mb-xl-10">
      <div class="card card-flush">
        <div class="card-header pt-9">
          <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder text-dark">@lang('pages/dashboard.expense_staticstics')</span>
            <span class="text-gray-400 pt-2 fw-bold fs-6">@lang('pages/dashboard.this_year_expense_total')</span>
          </h3>
        </div>
        <div class="card-body pt-5">
          <div id="data-yearly-expense-report-container" class="w-100 h-400px"></div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
@endsection


@push('customscripts')
  <script type="text/javascript">
    let blockUIYearlyPriceReportCardContainer = new KTBlockUI(document.querySelector
    ("#yearly-price-report-card-container"), {
      message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang('globals/infos.loading')...</div>',
    });
    $.ajax({
      type: "POST",
      url: "{{route('dashboard-report.yearly-price-report')}}",
      beforeSend: function () {
        blockUIYearlyPriceReportCardContainer.block();
      },
      success: function (data) {
        if (data) {
          new ApexCharts(document.getElementById("yearlyPriceReport"),
            data['yearly_price_chart']).render();
          new countUp.CountUp("data-yearly-price-total", data['yearly_price_total'], {
            decimalPlaces: 2,
            prefix: "{{\App\AppHelper::getPrimaryCurrency()->code}} "
          }).start();
          if (data['yearly_price_exchange_ratio'] > 0) {
            $("#data-price-exchange-ratio")
              .parent()
              .addClass('badge-success')
              .prepend(` @include("components.icons.arrowup") `)
          } else if (data['yearly_price_exchange_ratio'] < 0) {
            $("#data-price-exchange-ratio")
              .parent()
              .addClass('badge-danger')
              .prepend(` @include("components.icons.arrowdown") `)
          } else {
            $("#data-price-exchange-ratio")
              .parent()
              .addClass('badge-warning')
              .prepend(` @include("components.icons.minus") `)
          }
          document.getElementById("data-price-exchange-ratio").innerText = data['yearly_price_exchange_ratio'] + "%"
        }
        blockUIYearlyPriceReportCardContainer.release();
      },
      error: function (err) {
        blockUIYearlyPriceReportCardContainer.release();
        toastr.error('@lang('globals/error_messages.report_fetching_error', ['attr'  => __('pages/dashboard.this_year_total_price')])')
      }
    });
    $.ajax({
      type: "POST",
      url: "{{route('dashboard-report.yearly-safe-report')}}",
      success: function (data) {
        var element = document.getElementById("data-yearly-safe-report-container");
        am5.ready(function () {
          var root = am5.Root.new(element);
          root.setThemes([am5themes_Animated.new(root)]);
          var chart = root.container.children.push(
            am5xy.XYChart.new(root, {
              panX: true,
              panY: true,
              wheelX: "panX",
              wheelY: "zoomX",
            })
          );
          var cursor = chart.set(
            "cursor",
            am5xy.XYCursor.new(root, {
              behavior: "none"
            })
          );
          cursor.lineY.set("visible", false);
          var xAxis = chart.xAxes.push(
            am5xy.CategoryAxis.new(root, {
              categoryField: "month",
              startLocation: 0.5,
              endLocation: 0.5,
              renderer: am5xy.AxisRendererX.new(root, {}),
              tooltip: am5.Tooltip.new(root, {}),
            })
          );

          xAxis.get("renderer").grid.template.setAll({
            disabled: true,
            strokeOpacity: 0
          });

          xAxis.get("renderer").labels.template.setAll({
            fontWeight: "400",
            fontSize: 13,
            fill: am5.color(KTUtil.getCssVariableValue('--bs-gray-500'))
          });

          xAxis.data.setAll(data);

          var yAxis = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
              renderer: am5xy.AxisRendererY.new(root, {}),
            })
          );

          yAxis.get("renderer").grid.template.setAll({
            stroke: am5.color(KTUtil.getCssVariableValue('--bs-gray-300')),
            strokeWidth: 1,
            strokeOpacity: 1,
            strokeDasharray: [3]
          });

          yAxis.get("renderer").labels.template.setAll({
            fontWeight: "400",
            fontSize: 13,
            fill: am5.color(KTUtil.getCssVariableValue('--bs-gray-500'))
          });

          function createSeries(name, field) {
            var series = chart.series.push(
              am5xy.LineSeries.new(root, {
                name: name,
                xAxis: xAxis,
                yAxis: yAxis,
                stacked: true,
                valueYField: field,
                categoryXField: "month",
                tooltip: am5.Tooltip.new(root, {
                  pointerOrientation: "horizontal",
                  labelText: "[bold]{name}[/]\n{categoryX}: {valueY}",
                }),
              })
            );


            series.fills.template.setAll({
              fillOpacity: 0.5,
              visible: true,
            });

            series.data.setAll(data);
            series.appear(1000);
          }

          Object.getOwnPropertyNames(data[0]).forEach(
            function (val, idx, array) {
              if (val !== "month")
                createSeries(val, val);
            }
          );

          chart.appear(1000, 100);

          setTimeout(() => {
            $("#data-yearly-safe-report-container > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > canvas:nth-child(2)").remove();
            $("#data-yearly-expense-report-container > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > " +
              "canvas:nth-child(2)").remove();
          }, 1000)
        });

      },
      error: function (err) {
        toastr.error("@lang('globals/error_messages.report_fetching_error',['attr' => __('pages/dashboard.safe_staticstics')])");
      }
    });
    $.ajax({
      type: "POST",
      url: "{{route('dashboard-report.yearly-expense-report')}}",
      success: function (data) {
        var element = document.getElementById("data-yearly-expense-report-container");
        am5.ready(function () {
          var root = am5.Root.new(element);
          root.setThemes([am5themes_Animated.new(root)]);
          var chart = root.container.children.push(
            am5xy.XYChart.new(root, {
              panX: true,
              panY: true,
              wheelX: "panX",
              wheelY: "zoomX",
            })
          );
          var cursor = chart.set(
            "cursor",
            am5xy.XYCursor.new(root, {
              behavior: "none"
            })
          );
          cursor.lineY.set("visible", false);
          var xAxis = chart.xAxes.push(
            am5xy.CategoryAxis.new(root, {
              categoryField: "month",
              startLocation: 0.5,
              endLocation: 0.5,
              renderer: am5xy.AxisRendererX.new(root, {}),
              tooltip: am5.Tooltip.new(root, {}),
            })
          );

          xAxis.get("renderer").grid.template.setAll({
            disabled: true,
            strokeOpacity: 0
          });

          xAxis.get("renderer").labels.template.setAll({
            fontWeight: "400",
            fontSize: 13,
            fill: am5.color(KTUtil.getCssVariableValue('--bs-gray-500'))
          });

          xAxis.data.setAll(data);

          var yAxis = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
              renderer: am5xy.AxisRendererY.new(root, {}),
            })
          );

          yAxis.get("renderer").grid.template.setAll({
            stroke: am5.color(KTUtil.getCssVariableValue('--bs-gray-300')),
            strokeWidth: 1,
            strokeOpacity: 1,
            strokeDasharray: [3]
          });

          yAxis.get("renderer").labels.template.setAll({
            fontWeight: "400",
            fontSize: 13,
            fill: am5.color(KTUtil.getCssVariableValue('--bs-gray-500'))
          });

          function createSeries(name, field) {
            var series = chart.series.push(
              am5xy.LineSeries.new(root, {
                name: name,
                xAxis: xAxis,
                yAxis: yAxis,
                stacked: true,
                valueYField: field,
                categoryXField: "month",
                tooltip: am5.Tooltip.new(root, {
                  pointerOrientation: "horizontal",
                  labelText: "[bold]{name}[/]\n{categoryX}: {valueY}",
                }),
              })
            );


            series.fills.template.setAll({
              fillOpacity: 0.5,
              visible: true,
            });

            series.data.setAll(data);
            series.appear(1000);
          }

          Object.getOwnPropertyNames(data[0]).forEach(
            function (val, idx, array) {
              if (val != "month")
                createSeries(val, val);
            }
          );

          chart.appear(1000, 100);
        });
      },
      error: function (err) {
        toastr.error("@lang('globals/error_messages.report_fetching_error', ['attr' => __('pages/dashboard.expense_staticstics')])");
      }
    });
    $.ajax({
      type: "POST",
      url: "{{route('dashboard-report.yearly-product-report')}}",
      success: function (data) {
        new ApexCharts(document.getElementById("yearlyProductReport"), data['yearly_product_chart']).render();
        new countUp.CountUp("data-yearly-product-total", parseInt(data['yearly_product_total']), {
          suffix: " @lang('globals/words.piece')"
        }).start();
      },
      error: function (err) {
        toastr.error("@lang('globals/error_messages.report_fetching_error',['attr' => __('pages/dashboard.this_year_saled_five_total_product')])");
      }
    });

  </script>
@endpush
