<x-form.form id="filter_form">
  <a class="btn btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="left-start">
    <i class="las la-filter fs-2"></i>
    Filtrele
  </a>
  <div
    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-700px py-5 px-8"
    data-kt-menu="true">
    <div class="row row-cols-2 ">
      <x-form.input name="filter_name" label="Ad" placeholder="Ad" required/>
      <x-form.input name="filter_surname" label="Soyad" placeholder="Soyad"/>
    </div>
    <div class="row row-cols-2">
      <x-form.input name="filter_email" label="Email" placeholder="Email"/>
      <x-form.input name="filter_phone" label="Telefon" placeholder="Telefon"/>
    </div>
    <div class="row row-cols-2">
      <x-form.select name="filter_staff_roles" multiple label="Rol" placeholder="Rol"
                     :asyncload="route('staff_role.select')" required parent="#filter_form"/>
      <div class="d-flex align-items-center">
        <x-form.radio label="Cinsiyet" checked="-1" name="filter_gender"
                      hint="Eğer personel bir firma yada tüzel kişiyşe diğeri seçin"
                      :items="['Hepsi' => '-1', 'Erkek' => 1, 'Kadın' => 2, 'Diğer' => 3]"/>
      </div>
    </div>
    <div class="d-flex justify-content-end my-4">
      <button class="btn btn-bg-light btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" type="button"
              data-bs-placement="top" data-bs-toggle="tooltip" title="Filtreyi temizle"
              data-filter-clear-button>
        <i class="la la-trash-o fs-3"></i>
        Temizle
      </button>
      <button type="submit" class="btn btn-info ms-4" data-bs-custom-class="tooltip-dark" data-bs-placement="top"
              data-bs-toggle="tooltip" title="Filtrele" data-kt-menu-dismiss="true"
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
      e.preventDefault();
    });
    let name = $('input[name="filter_name"]'),
      surname = $('input[name="filter_surname"]'),
      email = $('input[name="filter_email"]'),
      phone = $('input[name="filter_phone"]'),
      staff_roles = $(".filter_staff_roles_select"),
      gender = $(`input[name="filter_gender"]`);
    $("[data-filter-clear-button]").click(function () {
      name.val("");
      surname.val("");
      email.val("");
      phone.val("");
      gender.filter(`[value="-1"]`).prop('checked', true);
      staff_roles.val(null).trigger('change');
      initStaffTable({});
    });
    $("[data-filter-button]").click(function (e) {
      let name_val = name.val(),
        surname_val = surname.val(),
        email_val = email.val(),
        phone_val = phone.val(),
        gender_val = gender.filter(`:checked`).val(),
        staff_roles_val = staff_roles.val();
      initStaffTable({
        name: name_val,
        surname: surname_val,
        email: email_val,
        phone: phone_val,
        staff_roles: staff_roles_val,
        gender: gender_val
      });
    });
    $("[data-export-excel]").click(function () {
      console.log("çıkar")
    });
  </script>
@endpush
