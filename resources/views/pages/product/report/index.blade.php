@extends('layout.default')
@section('page-title')
  {{$product->name}} ürünü'nün raporu
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
                <span id="data-price-exchange-ration"
                      title="Geçen yıla oranla kazanılan para durumu"
                      data-bs-toggle="tooltip"
                      data-bs-trigger="hover"
                      data-bs-custom-class="tooltip-dark"
                      data-bs-dismiss="click"
                      data-bs-placement="right"
                >2.2%
                </span>
              </span>
            </div>
            <span class="fs-6 fw-bold text-gray-400">Bu Yıl Toplam Satış</span>
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
                <span id="data-sale-exchange-ration"
                      title="Geçen yıla oranla satılan adet durumu"
                      data-bs-toggle="tooltip"
                      data-bs-trigger="hover"
                      data-bs-custom-class="tooltip-dark"
                      data-bs-dismiss="click"
                      data-bs-placement="right"
                >0%
                </span>
              </span>
            </div>
            <span class="fs-6 fw-bold text-gray-400">Bu Yıl Toplam Adet Satış</span>
          </div>
          <div id="yearlySaleReport" class="min-h-auto" style="height: 150px"></div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('customscripts')
  <script>
    var blockUIYearlyPriceReportCardContainer = new KTBlockUI(document.querySelector
    ("#yearly-price-report-card-container"), {
      message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Yükleniyor...</div>',
    });
    var blockUIYearlySaleReportCardContainer = new KTBlockUI(document.querySelector
    ("#yearly-sale-report-card-container"), {
      message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Yükleniyor...</div>',
    });
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
            $("#data-price-exchange-ration")
              .parent()
              .addClass('badge-success')
              .prepend(` @include("components.icons.arrowup") `)
          } else if (data['yearly_price_exchange_ratio'] < 0) {
            $("#data-price-exchange-ration")
              .parent()
              .addClass('badge-danger')
              .prepend(` @include("components.icons.arrowdown") `)
          } else {
            $("#data-price-exchange-ration")
              .parent()
              .addClass('badge-warning')
              .prepend(` @include("components.icons.minus") `)
          }
          document.getElementById("data-price-exchange-ration").innerText = data['yearly_price_exchange_ratio'] + "%"
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
            $("#data-sale-exchange-ration")
              .parent()
              .addClass('badge-success')
              .prepend(` @include("components.icons.arrowup") `)
          } else if (data['yearly_sale_exchange_ratio'] < 0) {
            $("#data-sale-exchange-ration")
              .parent()
              .addClass('badge-danger')
              .prepend(` @include("components.icons.arrowdown") `)
          } else {
            $("#data-sale-exchange-ration")
              .parent()
              .addClass('badge-warning')
              .prepend(` @include("components.icons.minus") `)
          }
          document.getElementById("data-sale-exchange-ration").innerText = data['yearly_sale_exchange_ratio'] + "%"
        }
        blockUIYearlySaleReportCardContainer.release();
      },
      error: function (err) {
        blockUIYearlySaleReportCardContainer.release();
        toastr.error('Rapor yüklenirken bir sorun oluştu, daha sonra tekrar deneyin!')
      }
    });
  </script>
@endpush
