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
  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-1000px py-5 px-8" data-kt-menu="true">
    <div class="fs-3 mb-4">Genel</div>
    <div class="row row-cols-3">
      <x-form.input name="filter_name" label="Ürün Adı" placeholder="Ürün Adı" />
      <x-form.input name="filter_model_code" label="Model Kodu" placeholder="Model Kodu" />
      <x-form.select label="Ürün Tipi" name="filter_product_type_id" :asyncload="route('product_type.select')" />
    </div>
    <div class="fs-3 mb-4">Stok & Tedarikçi</div>
    <div class="row row-cols-3">
      <x-form.input name="filter_min_stock" label="Min. Stok" placeholder="Min. Stok" />
      <x-form.input name="filter_max_stock" label="Maks. Stok" placeholder="Maks. Stok" />
      <x-form.select label="Tedarikçiler" name="filter_suppliers" :asyncload="route('supplier.select')" multiple parent="#filter_form" />
    </div>
    <div class="fs-3 mb-4">Fiyatlandırma</div>
    <div class="row row-cols-4">
      <x-form.input name="filter_min_buy_price" label="Min. Alış Tutar" placeholder="Min. Alış Tutar" money />
      <x-form.select label="Min. Alış Kasası" name="filter_min_buy_price_safe_id" :asyncload="route('safe.select')" />
      <x-form.input name="filter_max_buy_price" label="Maks. Alış Tutar" placeholder="Maks. Alış Tutar" money />
      <x-form.select label="Maks. Alış Kasası" name="filter_max_buy_price_safe_id" :asyncload="route('safe.select')" />
    </div>
    <div class="row row-cols-4">
      <x-form.input name="filter_min_sale_price" label="Min. Satış Tutar" placeholder="Min. Satış Tutar" money />
      <x-form.select label="Min. Satış Kasası" name="filter_min_sale_price_safe_id" :asyncload="route('safe.select')" />
      <x-form.input name="filter_max_sale_price" label="Maks. Satış Tutar" placeholder="Maks. Satış Tutar" money />
      <x-form.select label="Maks. Satış Kasası" name="filter_max_sale_price_safe_id" :asyncload="route('safe.select')" />
    </div>
    <div class="d-flex justify-content-end">
      <button class="btn btn-bg-light btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" type="button" data-bs-placement="top" data-bs-toggle="tooltip" title="Filtreyi temizle"
        data-filter-clear-button>
        <i class="la la-trash-o fs-3"></i>
        Temizle
      </button>
      <button class="btn btn-info ms-4" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Filtrele" type="submit" data-kt-menu-dismiss="true"
        data-filter-button>
        <i class="las la-filter fs-3"></i>
        Filtrele
      </button>
    </div>
  </div>
</x-form.form>
@push('customscripts')
  <script type="text/javascript">
    $("#filter_form").submit(function(e) {
      event.preventDefault();
    });
    let name = $('input[name="filter_name"]'),
      model_code = $('input[name="filter_model_code"]'),
      min_stock = $('input[name="filter_min_stock"]'),
      max_stock = $('input[name="filter_max_stock"]'),
      filter_min_buy_price = $('input[name="filter_min_buy_price"]'),
      filter_min_buy_price_safe = $(".filter_min_buy_price_safe_id_select"),
      filter_max_buy_price = $('input[name="filter_max_buy_price"]'),
      filter_max_buy_price_safe = $(".filter_max_buy_price_safe_id_select"),
      filter_min_sale_price = $('input[name="filter_min_sale_price"]'),
      filter_min_sale_price_safe = $(".filter_min_sale_price_safe_id_select"),
      filter_max_sale_price = $('input[name="filter_max_sale_price"]'),
      filter_max_sale_price_safe = $(".filter_max_sale_price_safe_id_select"),
      filter_suppliers = $(".filter_suppliers_select"),
      product_type = $(".filter_product_type_id_select");
    $("[data-filter-clear-button]").click(function() {
      name.val("");
      model_code.val("");
      min_stock.val("");
      max_stock.val("");
      filter_min_buy_price.val("");
      filter_min_buy_price_safe.val(null).trigger('change');
      filter_max_buy_price.val("");
      filter_max_buy_price_safe.val(null).trigger('change');
      filter_min_sale_price.val("");
      filter_min_sale_price_safe.val(null).trigger('change');
      filter_max_sale_price.val("");
      filter_max_sale_price_safe.val(null).trigger('change');
      filter_suppliers.val(null).trigger('change');
      product_type.val(null).trigger('change');
      initTable({});
    });
    $("button[data-filter-button]").click(function(e) {
      e.preventDefault();
      let name_val = name.val(),
        model_code_val = model_code.val(),
        min_stock_val = min_stock.val(),
        max_stock_val = max_stock.val(),
        min_buy_price_val = filter_min_buy_price.val(),
        min_buy_price_safe_val = filter_min_buy_price_safe.val(),
        max_buy_price_val = filter_max_buy_price.val(),
        max_buy_price_safe_val = filter_max_buy_price_safe.val(),
        min_sale_price_val = filter_min_sale_price.val(),
        min_sale_price_safe_val = filter_min_sale_price_safe.val(),
        max_sale_price_val = filter_max_sale_price.val(),
        max_sale_price_safe_val = filter_max_sale_price_safe.val(),
        suppliers_val = filter_suppliers.val(),
        product_type_id = product_type.val();
      initTable({
        name: name_val,
        model_code: model_code_val,
        product_type: product_type_id,

        buy_price_min: min_buy_price_val,
        buy_price_min_safe: min_buy_price_safe_val,
        buy_price_max: max_buy_price_val,
        buy_price_max_safe: max_buy_price_safe_val,

        sale_price_min: min_sale_price_val,
        sale_price_min_safe: min_sale_price_safe_val,
        sale_price_max: max_sale_price_val,
        sale_price_max_safe: max_sale_price_safe_val,

        min_stock: min_stock_val,
        max_stock: max_stock_val,
        suppliers: suppliers_val
      });
    });
    $("[data-export-excel]").click(function() {
      console.log("çıkar")
    });
  </script>
@endpush
