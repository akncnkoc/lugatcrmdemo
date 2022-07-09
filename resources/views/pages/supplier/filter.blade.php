<x-form.form id="filter_form">
  <a class="btn btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="left-start">
    <i class="las la-filter fs-2"></i>
    Filtrele
  </a>
  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-400px py-5 px-8" data-kt-menu="true">
    <div class="row row-cols-1">
      <x-form.input name="filter_name" label="Ad (Ünvan)" placeholder="Ad (Ünvan)" required/>
      <x-form.input name="filter_email" label="Email" placeholder="Email"/>
      <x-form.input name="filter_phone" label="Telefon" placeholder="Telefon"/>
    </div>
    <div class="d-flex justify-content-end my-4 gap-2">
      <x-tooltip-button :title="__('globals/words.filter_clear')" data-filter-clear-button>
        @include('components.icons.close')
        @lang('globals/words.clear')
      </x-tooltip-button>
      <x-tooltip-button :title="__('globals/words.filter')" data-filter-button>
        @include('components.icons.filter')
        @lang('globals/words.filter')
      </x-tooltip-button>
    </div>
  </div>
</x-form.form>
@push('customscripts')
  <script type="text/javascript">
    const SupplierFilterTemplate = function (){
      let name = $('input[name="filter_name"]'),
        email = $('input[name="filter_email"]'),
        phone = $('input[name="filter_phone"]');
      const init = () => {
        $("#filter_form").filterForm({
          onClear: function (e) {
            name.val("");
            email.val("");
            phone.val("");
            initTable({});
            SupplierIndexTemplate.initData({});
          },
          onFilter: function (e) {
            e.preventDefault();
            let name_val = name.val(),
              email_val = email.val(),
              phone_val = phone.val();
            SupplierIndexTemplate.initData({
              name: name_val,
              email: email_val,
              phone: phone_val,
            });
          }
        });
      }
      return {init};
    }();
    SupplierFilterTemplate.init();
    $("[data-export-excel]").click(function () {
      console.log("çıkar")
    });
  </script>
@endpush
