<x-form.form id="filter_form">
  <a class="btn btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="left-start">
    <i class="las la-filter fs-2"></i>
    @lang('globals/words.filter')
  </a>
  <div
    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-500px py-5 px-8"
    data-kt-menu="true">
    <div class="fs-3 mb-4">@lang('globals/words.general')</div>
    <div class="row row-cols-1">
      <x-form.input name="filter_name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')"/>
    </div>
    <div class="d-flex justify-content-end">
      <button class="btn btn-bg-light btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" type="button"
              data-bs-placement="top" data-bs-toggle="tooltip" title="Filtreyi temizle"
              data-filter-clear-button>
        <i class="la la-trash-o fs-3"></i>
        @lang('globals/words.clear')
      </button>
      <button class="btn btn-info ms-4" data-bs-custom-class="tooltip-dark" data-bs-placement="top"
              data-bs-toggle="tooltip" title="Filtrele" type="submit" data-kt-menu-dismiss="true"
              data-filter-button>
        <i class="las la-filter fs-3"></i>
        @lang('globals/words.filter')
      </button>
    </div>
  </div>
</x-form.form>
@push('customscripts')
  <script type="text/javascript">
    $("#filter_form").submit(function (e) {
      event.preventDefault();
    });
    let filter_name = $('input[name="filter_name"]');
    $("[data-filter-clear-button]").click(function () {
      filter_name.val("");
      initSupplierRegularPayments({});
    });
    $("button[data-filter-button]").click(function (e) {
      e.preventDefault();
      let name_val = filter_name.val();
      initSupplierRegularPayments({
        name: name_val
      });
    });
    $("[data-export-excel]").click(function () {
      console.log("çıkar")
    });
  </script>
@endpush
