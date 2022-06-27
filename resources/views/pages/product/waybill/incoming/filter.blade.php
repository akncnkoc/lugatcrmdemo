@push('customstyles')
  <style>
    .select2-selection__choice__remove {
      display: none !important;
    }

    .select2-selection__choice__display {
      margin-left: 0 !important;
    }

  </style>
@endpush
<x-form.form id="filter_form">
  <a class="btn btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="left-start">
    <i class="las la-filter fs-2"></i>
    Filtrele
  </a>
  <div
    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-500px py-5 px-8"
    data-kt-menu="true">

    <div class="fs-3 mb-4">Genel</div>
    <div class="row row-cols-1">
      <x-form.select name="filter_suppliers" label="Tedarikçiler" placeholder="Tedarikçiler" multiple
                     :asyncload="route('supplier.select')" parent="#filter_form"/>
    </div>
    <div class="fs-3 mb-4">Ürün Sayısı</div>
    <div class="row row-cols-2">
      <x-form.input name="filter_min_product" label="Min. Ürün Sayısı" placeholder="Min. Ürün Sayısı" value="1"/>
      <x-form.input name="filter_max_product" label="Maks. Ürün Sayısı" placeholder="Maks. Ürün Sayısı"/>
    </div>
    <div class="fs-3 mb-4">Giriş Tarihi</div>
    <div class="row row-cols-2">
      <x-form.input name="filter_min_date" label="Min. Tarih" placeholder="Min. Tarih" date/>
      <x-form.input name="filter_max_date" label="Maks. Tarih" placeholder="Maks. Tarih" date/>
    </div>
    <div class="d-flex justify-content-end">
      <button class="btn btn-bg-light btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" type="button"
              data-bs-placement="top" data-bs-toggle="tooltip" title="Filtreyi temizle"
              data-filter-clear-button>
        <i class="la la-trash-o fs-3"></i>
        Temizle
      </button>
      <button class="btn btn-info ms-4" data-bs-custom-class="tooltip-dark" data-bs-placement="top"
              data-bs-toggle="tooltip" title="Filtrele" type="submit" data-kt-menu-dismiss="true"
              data-filter-button>
        <i class="las la-filter fs-3"></i>
        Filtrele
      </button>
    </div>
  </div>
</x-form.form>
@push('customscripts')
  <script type="text/javascript">
    $("#filter_form").submit(function (e) {
      event.preventDefault();
    });
    let min_product = $('input[name="filter_min_product"]'),
      max_product = $('input[name="filter_max_product"]'),
      min_date = $('input[name="filter_min_date"]'),
      max_date = $('input[name="filter_max_date"]'),
      filter_suppliers = $(".filter_suppliers_select");
    $("[data-filter-clear-button]").click(function () {
      min_product.val("");
      max_product.val("");
      min_date.val("");
      max_date.val("");
      filter_suppliers.val(null).trigger('change');
      initIncomingWaybillTable({});
    });
    $("button[data-filter-button]").click(function (e) {
      e.preventDefault();
      let min_product_val = min_product.val(),
        max_product_val = max_product.val(),
        min_date_val = min_date.val(),
        max_date_val = max_date.val(),
        suppliers_val = filter_suppliers.val();
      initIncomingWaybillTable({
        min_product: min_product_val,
        max_product: max_product_val,
        min_date: min_date_val,
        max_date: max_date_val,
        suppliers: suppliers_val
      });
    });
    $("[data-export-excel]").click(function () {
      console.log("çıkar")
    });
  </script>
@endpush
