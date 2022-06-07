@extends('layout.default')
@section('content')
  <div class="container-xxl">
    <div class="row g-5 g-xl-10">
      <div class="col-md-6 col-xl-6 mb-xxl-10">
        <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
          <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
            <div class="mb-4 px-9">
              <div class="d-flex align-items-center mb-2">
                <span class="fs-4 fw-bold text-gray-400 align-self-start me-1&gt;">$</span>
                <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1">69,700</span>
                <span class="badge badge-success fs-base"><span class="svg-icon svg-icon-5 svg-icon-white ms-n1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                       fill="none">
																		<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
                                          transform="rotate(90 13 6)" fill="currentColor"/>
																		<path
                                      d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                                      fill="currentColor"/>
																	</svg>
																</span>2.2%</span>
              </div>
              <span class="fs-6 fw-bold text-gray-400">Total Online Sales</span>
            </div>
            <div id="yearlySaleReport" class="min-h-auto" style="height: 500px"></div>
          </div>
        </div>
        <div class="card card-flush h-md-50 mb-xl-10">
          <div class="card-header pt-5">
            <!--begin::Title-->
            <div class="card-title d-flex flex-column">
              <!--begin::Info-->
              <div class="d-flex align-items-center">
                <!--begin::Amount-->
                <span class="fs-2hx fw-bolder text-dark me-2 lh-1 ls-n2">1,836</span>
                <!--end::Amount-->
                <!--begin::Badge-->
                <span class="badge badge-danger fs-base">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
																<span class="svg-icon svg-icon-5 svg-icon-white ms-n1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                       fill="none">
																		<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1"
                                          transform="rotate(-90 11 18)" fill="currentColor"/>
																		<path
                                      d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z"
                                      fill="currentColor"/>
																	</svg>
																</span>
                  <!--end::Svg Icon-->2.2%</span>
                <!--end::Badge-->
              </div>
              <!--end::Info-->
              <!--begin::Subtitle-->
              <span class="text-gray-400 pt-1 fw-bold fs-6">Total Sales</span>
              <!--end::Subtitle-->
            </div>
            <!--end::Title-->
          </div>
          <div class="card-body d-flex align-items-end pt-0">
            <div class="d-flex align-items-center flex-column mt-3 w-100">
              <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                <span class="fw-boldest fs-6 text-dark">1,048 to Goal</span>
                <span class="fw-bolder fs-6 text-gray-400">62%</span>
              </div>
              <div class="h-8px mx-3 w-100 bg-light-success rounded">
                <div class="bg-success rounded h-8px" role="progressbar" style="width: 62%;" aria-valuenow="50"
                     aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('customscripts')
  <script>
    function calculateSaledProducts(saled_products) {
      let labels = "";
      let groupByDate = saled_products.reduce((group, product) => {
        const {invoice_date} = product.invoice;
        const getDate = moment(invoice_date).format('MMMM');
        group[getDate] = group[getDate] ?? [];
        if (group[getDate].length === 0) {
          labels += getDate + ",";
        }
        group[getDate].push(product);
        return group;
      }, {});
      let totaled_prices = [];
      labels = labels.substring(0, labels.length - 1).split(",");
      Object.keys(groupByDate).map((item, index) => {
        if (groupByDate[item] && groupByDate[item].length > 0) {
          let total = 0;
          groupByDate[item].map((product_item, product_index) => {
            total += Number(product_item.price);
          })
          totaled_prices.push(total)
        }
      });
      yearlySaleReport.init(totaled_prices, labels);
    }

    $.ajax({
      type: "POST",
      url: "{{route('product-report.report')}}",
      data: {
        id: "{{$product->id}}"
      },
      success: function (data) {
        if (data) {
          eval(data);
        }
      },
      error: function (err) {
        toastr.error('Rapor yüklenirken bir sorun oluştu, daha sonra tekrar deneyin!')
      }
    });

  </script>
@endpush
