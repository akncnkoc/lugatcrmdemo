<x-form.form id="filter_form">
  <a class="btn btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="left-start">
    <i class="las la-filter fs-2"></i>
    Filtrele
  </a>
  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-500px py-5 px-8" data-kt-menu="true">
    <div class="row row-cols-2">
      <x-form.input name="filter_min_price" label="Min. Tutar <span class='fs-8'>(Birim)</span>" placeholder="Min. Tutar(Birim)" money />
      <x-form.input name="filter_max_price" label="Maks. Tutar <span class='fs-8'>(Birim)</span>" placeholder="Maks. Tutar" money />
    </div>
    <div class="row row-cols-2">
      <x-form.select label="Kasa" name="filter_safe_id" :asyncload="route('safe.select')" parent="#filter_form" />
      <x-form.select label="İşlem Tipi" name="filter_payable" parent="#filter_form">
        <x-slot:options>
          <option value="1">Ödenmiş</option>
          <option value="0">Ödenmemiş</option>
        </x-slot:options>
      </x-form.select>
    </div>
    <div class="row row-cols-2">
      <x-form.input name="filter_min_date" label="Başlangıç Tarihi" placeholder="Başlangıç Tarihi" :date="true" />
      <x-form.input name="filter_max_date" label="Bitiş Tarihi" placeholder="Bitiş Tarihi" :date="true" />
    </div>
    <div class="d-flex justify-content-end">
      <button class="btn btn-bg-light btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" type="button" data-bs-placement="top" data-bs-toggle="tooltip" title="Filtreyi temizle"
        data-filter-clear-button>
        <i class="la la-trash-o fs-3"></i>
        Temizle
      </button>
      <button class="btn btn-info ms-4" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Filtrele" data-kt-menu-dismiss="true" type="submit"
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
    let min_date = $('input[name="filter_min_date"]'),
      max_date = $('input[name="filter_max_date"]'),
      min_price = $('input[name="filter_min_price"]'),
      max_price = $('input[name="filter_max_price"]'),
      safe = $(".filter_safe_id_select"),
      payable = $(".filter_payable_select");
    $("[data-filter-clear-button]").click(function() {
      min_date.val("");
      max_date.val("");
      min_price.val("");
      max_price.val("");
      safe.val(null).trigger('change');
      payable.val(null).trigger('change');
      initSupplierPaymentsTable({});
    });
    $("[data-filter-button]").click(function() {
      let min_date_val = min_date.val(),
        max_date_val = max_date.val(),
        min_price_val = min_price.val(),
        max_price_val = max_price.val(),
        safe_val = safe.val(),
        payable_val = payable.val();
      initSupplierPaymentsTable({
        min_date: min_date_val,
        max_date: max_date_val,
        safe: safe_val,
        payable: payable_val,
        min_price: min_price_val,
        max_price: max_price_val
      });
    });
    $("[data-export-excel]").click(function() {
      console.log("çıkar")
    });
  </script>
@endpush
