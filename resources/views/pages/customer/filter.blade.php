<x-form.form id="filter_form">
  <a class="btn btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="left-start">
    <i class="las la-filter fs-2"></i>
    @lang('globals/words.filter')
  </a>
  <div
    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-700px py-5 px-8"
    data-kt-menu="true">
    <div class="row row-cols-2 ">
      <x-form.input name="filter_name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')"/>
      <x-form.input name="filter_surname"
                    :label="__('globals/words.surname')"
                    :placeholder="__('globals/words.surname')"/>
    </div>
    <div class="row row-cols-2">
      <x-form.input name="filter_email" :label="__('globals/words.email')" :placeholder="__('globals/words.email')"/>
      <x-form.input name="filter_phone" :label="__('globals/words.phone')" :placeholder="__('globals/words.phone')"/>
    </div>
    <div class="row row-cols-2">
      <x-form.select name="filter_customer_role_id"
                     :label="__('globals/words.role')"
                     :placeholder="__('globals/words.role')"
                     :asyncload="route('customer_role.select')"
                     required/>
      <div class="d-flex align-items-center">
        <x-form.radio :label="__('globals/words.gender')"
                      checked="-1"
                      name="filter_gender"
                      :hint="__('pages/customer.customer_gender_hint')"
                      :items="[__('globals/words.male') => 0, __('globals/words.female') => 1, __('globals/words.other')=> 2]"/>
      </div>
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
    const CustomerFilterTemplate = function (){
      let name = $('input[name="filter_name"]'),
        surname = $('input[name="filter_surname"]'),
        email = $('input[name="filter_email"]'),
        phone = $('input[name="filter_phone"]'),
        customer_role = $(".filter_customer_role_id_select"),
        gender = $(`input[name="filter_gender"]`);

      const init = () => {
        $("#filter_form").filterForm({
          onClear: function () {
            name.val("");
            surname.val("");
            email.val("");
            phone.val("");
            gender.filter(`[value="-1"]`).prop('checked', true);
            customer_role.val(null).trigger('change');
            CustomerIndexTemplate.initData({});
          },
          onFilter: function () {
            let name_val = name.val(),
              surname_val = surname.val(),
              email_val = email.val(),
              phone_val = phone.val(),
              gender_val = gender.filter(`:checked`).val(),
              customer_role_val = customer_role.val();
            CustomerIndexTemplate.initData({
              name: name_val,
              surname: surname_val,
              email: email_val,
              phone: phone_val,
              customer_role: customer_role_val,
              gender: gender_val
            });
          }
        });
      }
      return {init};
    }();
    CustomerFilterTemplate.init();
  </script>
@endpush
