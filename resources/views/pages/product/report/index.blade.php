@extends('layout.default')
@section('page-title')
  @lang('pages/product.product_report', ["attr" => $product->name])
@endsection
@section('content')
  <div class="row g-5 g-xl-10">
    <div class="col-md-4 col-xl-4 mb-xxl-10">
      <div class="card mb-5 mb-xl-10" id="yearly-price-report-card-container">
        <div class="card-body d-flex justify-content-between flex-column px-0 pb-16">
          <div class="mb-4 px-9">
            <div class="d-flex align-items-center mb-2">
              <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1" id="data-yearly-price-total">0
              </span>
              <span class="badge fs-base">
                <span id="data-price-exchange-ratio"
                      title="@lang('pages/product.price_compared_to_last_year')"
                      data-bs-toggle="tooltip"
                      data-bs-trigger="hover"
                      data-bs-custom-class="tooltip-dark"
                      data-bs-dismiss="click"
                      data-bs-placement="right"
                >2.2%
                </span>
              </span>
            </div>
            <span class="fs-6 fw-bold text-gray-400">@lang('pages/dashboard.this_year_total_price')</span>
          </div>
          <div id="yearlyPriceReport" class="min-h-auto" style="height: 150px"></div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-xl-4 mb-xxl-10">
      <div class="card mb-5 mb-xl-10" id="yearly-sale-report-card-container">
        <div class="card-body d-flex justify-content-between flex-column px-0 pb-16">
          <div class="mb-4 px-9">
            <div class="d-flex align-items-center mb-2">
              <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1" id="data-yearly-sale-total">0
              </span>
              <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1">Adet</span>
              <span class="badge badge-success fs-base">
                <span id="data-sale-exchange-ratio"
                      title="@lang('pages/product.saled_compared_to_last_year')"
                      data-bs-toggle="tooltip"
                      data-bs-trigger="hover"
                      data-bs-custom-class="tooltip-dark"
                      data-bs-dismiss="click"
                      data-bs-placement="right"
                >0%
                </span>
              </span>
            </div>
            <span class="fs-6 fw-bold text-gray-400">@lang('pages/product.this_year_total_saled')</span>
          </div>
          <div id="yearlySaleReport" class="min-h-auto" style="height: 150px"></div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('customscripts')
  <script>
    const ProductReportTemplate = function () {
      let blockUIYearlyPriceReportCardContainer = new KTBlockUI(document.querySelector
      ("#yearly-price-report-card-container"), {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Yükleniyor...</div>',
      });
      let blockUIYearlySaleReportCardContainer = new KTBlockUI(document.querySelector
      ("#yearly-sale-report-card-container"), {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Yükleniyor...</div>',
      });
      let price_exchange_ratio_container = $("#data-price-exchange-ratio");
      let sale_exchange_ratio_container = $("#data-sale-exchange-ratio");
      const init = () => {
        $.ajax({
          type: "POST",
          url: "{{route('product-report.yearly-price-report')}}",
          data: {
            id: "{{$product->id}}"
          },
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
                price_exchange_ratio_container
                  .parent()
                  .addClass('badge-success')
                  .prepend(` @include("components.icons.arrowup") `)
              } else if (data['yearly_price_exchange_ratio'] < 0) {
                price_exchange_ratio_container
                  .parent()
                  .addClass('badge-danger')
                  .prepend(` @include("components.icons.arrowdown") `)
              } else {
                price_exchange_ratio_container
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
            toastr.error('Rapor yüklenirken bir sorun oluştu, daha sonra tekrar deneyin!')
          }
        });
        $.ajax({
          type: "POST",
          url: "{{route('product-report.yearly-sale-report')}}",
          data: {
            id: "{{$product->id}}"
          },
          beforeSend: function () {
            blockUIYearlySaleReportCardContainer.block();
          },
          success: function (data) {
            if (data) {
              new ApexCharts(document.getElementById("yearlySaleReport"),
                data['yearly_sale_chart']).render();
              new countUp.CountUp("data-yearly-sale-total", data['yearly_sale_total']).start();
              if (data['yearly_sale_exchange_ratio'] > 0) {
                sale_exchange_ratio_container
                  .parent()
                  .addClass('badge-success')
                  .prepend(` @include("components.icons.arrowup") `)
              } else if (data['yearly_sale_exchange_ratio'] < 0) {
                sale_exchange_ratio_container
                  .parent()
                  .addClass('badge-danger')
                  .prepend(` @include("components.icons.arrowdown") `)
              } else {
                sale_exchange_ratio_container
                  .parent()
                  .addClass('badge-warning')
                  .prepend(` @include("components.icons.minus") `)
              }
              document.getElementById("data-sale-exchange-ratio").innerText = data['yearly_sale_exchange_ratio'] + "%"
            }
            blockUIYearlySaleReportCardContainer.release();
          },
          error: function (err) {
            blockUIYearlySaleReportCardContainer.release();
            toastr.error('Rapor yüklenirken bir sorun oluştu, daha sonra tekrar deneyin!')
          }
        });
      }
      return {init}
    }();
    ProductReportTemplate.init();
  </script>
@endpush
