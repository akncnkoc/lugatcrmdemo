<x-form.form>
  <a class="btn btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="left-start">
    <i class="las la-filter fs-2"></i>
    Filtrele
  </a>
  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-1000px pb-5" data-kt-menu="true">
    <div class="row row-cols-5 p-8">
      <x-form.select label="Gider Tipi" name="filter_expense_type_id" :asyncload="route('expense_type.select')"/>
      <x-form.input name="filter_min_price" label="Min. Tutar <span class='fs-8'>(Birim)</span>" placeholder="Min. Tutar(Birim)" money/>
      <x-form.input name="filter_max_price" label="Maks. Tutar <span class='fs-8'>(Birim)</span>" placeholder="Maks. Tutar" money/>
      <x-form.input name="filter_min_date" label="Başlangıç Tarihi" placeholder="Başlangıç Tarihi" :date="true"/>
      <x-form.input name="filter_max_date" label="Bitiş Tarihi" placeholder="Bitiş Tarihi" :date="true"/>
    </div>
    <div class="d-flex justify-content-end px-8">
      <button class="btn btn-bg-light btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" type="button" data-bs-placement="top" data-bs-toggle="tooltip"
              title="Filtreyi temizle"
              data-filter-clear-button>
        <i class="la la-trash-o fs-3"></i>
        Temizle
      </button>
      <button class="btn btn-info ms-4" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Filtrele" data-kt-menu-dismiss="true"
              type="submit"
              data-filter-button>
        <i class="las la-filter fs-3"></i>
        Filtrele
      </button>
    </div>
  </div>
</x-form.form>
@push('customscripts')
  <script>
    const StaffPaymentFilterTemplate = function (){
      let min_date = $('input[name="filter_min_date"]'),
        max_date = $('input[name="filter_max_date"]'),
        min_price = $('input[name="filter_min_price"]'),
        max_price = $('input[name="filter_max_price"]'),
        expense_type = $(".filter_expense_type_id_select");
      const init = () => {
        $("#filter_form").filterForm({
          onClear: function (e) {
            min_date.val("");
            max_date.val("");
            min_price.val("");
            max_price.val("");
            expense_type.val(null).trigger('change');
            ExpenseIndexTemplate.initData({});
          },
          onFilter: function (e) {
            e.preventDefault();
            let min_date_val = min_date.val(),
              max_date_val = max_date.val(),
              min_price_val = min_price.val(),
              max_price_val = max_price.val(),
              expense_type_id = expense_type.val();
            ExpenseIndexTemplate.initData({
              min_date: min_date_val,
              max_date: max_date_val,
              expense_type: expense_type_id,
              min_price: min_price_val,
              max_price: max_price_val
            });
          }
        });
      }
      return {init};
    }();

    ExpenseFilterTemplate.init();
    $("[data-export-excel]").click(function () {
      console.log("çıkar")
    });
  </script>
@endpush
