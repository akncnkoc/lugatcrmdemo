<x-modal.modal id="create_modal">
  <x-slot name="title">@lang('pages/customer.customer_add')</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-2">
        <x-form.input name="name"
                      :label="__('globals/words.name')"
                      :placeholder="__('globals/words.name')"
                      required/>
        <x-form.input name="surname" :label="__('globals/words.surname')" :placeholder="__('globals/words.surname')"/>
      </div>
      <div class="row row-cols-2">
        <x-form.input name="email" :label="__('globals/words.email')" :placeholder="__('globals/words.email')"/>
        <x-form.input name="phone" :label="__('globals/words.phone')" :placeholder="__('globals/words.phone')"/>
      </div>
      <div class="row row-cols-2">
        <x-form.select name="customer_role_id"
                       :label="__('globals/words.role')"
                       :placeholder="__('globals/words.role')"
                       :asyncload="route('customer_role.select')"
                       parent="#create_modal"
                       required/>
        <div class="d-flex align-items-center">
          <x-form.radio :label="__('globals/words.gender')"
                        checked="1"
                        name="gender"
                        :hint="__('pages/customer.customer_gender_hint')"
                        :items="[__('globals/words.male') => 1, __('globals/words.female') => 2, __('globals/words.other') => 3]"/>
        </div>
      </div>
      <x-form.textarea name="address" :label="__('globals/words.address')"/>
      <x-form.textarea name="comment" :label="__('globals/words.comment')"/>
      <x-form.button>@lang('globals/words.save')</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    let createFormValidatorRules = {
      name: {
        validators: {
          notEmpty: {
            message: "@lang('globals/validation_messages.required', ['field_name' => __('globals/words.name')])"
          },
          stringLength: {
            min: 3, message: "@lang('globals/validation_messages.min', ['field_name' => __('globals/words.name'), 'min' => 3])"
          }
        }
      }, customer_role_id: {
        validators: {
          notEmpty: {
            message: "@lang('globals/validation_messages.required', ['field_name' => __('globals/words.role')])"
          }
        }
      }
    }
    let createFormValidated = (form) => {
      let data = $(form).serializeArray();
      $.ajax({
        url: "{{ route('customer.store') }}", type: "POST", data: data, success: function (data) {
          $("#create_modal").modal("hide");
          table.ajax.reload(null, false);
          toastr.success("@lang('globals/success_messages.success', ['attr' => __('globals/words.customer')])");
        }, error: function (err) {
          toastr.error("@lang('globals/error_messages.save_error', ['attr' => __('globals/words.customer')])");
        }
      });
    }
    let createFormInvalidated = null;
    let createFormAfterLoaded = (form, validator) => {
      $(form).find('.customer_role_id_select').on('change', function () {
        validator.revalidateField('customer_role_id');
      });
    }
    let {
      form: createForm, validator: createValidator
    } = validateBasicForm("create_form", createFormValidatorRules, createFormValidated, createFormInvalidated, createFormAfterLoaded);
  </script>
@endpush
