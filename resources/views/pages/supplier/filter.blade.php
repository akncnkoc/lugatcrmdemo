<x-form.form id="filter_form">
  <a class="btn btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="left-start">
    <i class="las la-filter fs-2"></i>
    Filtrele
  </a>
  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-400px py-5 px-8" data-kt-menu="true">
    <div class="row row-cols-1">
      <x-form.input name="filter_name" label="Ad (Ünvan)" placeholder="Ad (Ünvan)" required />
      <x-form.input name="filter_email" label="Email" placeholder="Email" />
      <x-form.input name="filter_phone" label="Telefon" placeholder="Telefon" />
    </div>
    <div class="d-flex justify-content-end my-4">
      <button class="btn btn-bg-light btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" type="reset" data-bs-placement="top" data-bs-toggle="tooltip" title="Filtreyi temizle"
        data-filter-clear-button>
        <i class="la la-trash-o fs-3"></i>
        Temizle
      </button>
      <button type="submit" class="btn btn-info ms-4" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Filtrele" data-kt-menu-dismiss="true"
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
      e.preventDefault();
      e.stopPropagination();
    });
    let name = $('input[name="filter_name"]'),
      email = $('input[name="filter_email"]'),
      phone = $('input[name="filter_phone"]');
    $("[data-filter-clear-button]").click(function() {
      name.val("");
      email.val("");
      phone.val("");
      initTable({});
    });
    $("[data-filter-button]").click(function(e) {
      e.preventDefault();
      let name_val = name.val(),
        email_val = email.val(),
        phone_val = phone.val();
      initTable({
        name: name_val,
        email: email_val,
        phone: phone_val,
      });
    });
    $("[data-export-excel]").click(function() {
      console.log("çıkar")
    });
  </script>
@endpush
