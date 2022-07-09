<x-modal.modal id="customer_role_create_modal">
  <x-slot name="title">@lang('pages/customer.customer_role_add')</x-slot>
  <x-slot name="body">
    <x-form.form id="customer_role_create_form">
      <div class="row row-cols-1">
        <x-form.input name="name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')" required/>
      </div>
      <x-form.button>@lang('globals/words.save')</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    const CustomerRoleCreateTemplate = function () {
      let validations = {
        name: {
          validators: {
            notEmpty: {
              message: "@lang('globals/validation_messages.required', ['field_name'  => __('globals/words.name')])"
            },
            stringLength: {
              min: 3,
              message: "@lang('globals/validation_messages.min', ['field_name' => __('globals/words.name'), 'min' => 3])"
            }
          }
        }
      };
      let create_modal = $("#customer_role_create_modal");
      let formValidated = (form) => {
        let data = $(form).serializeArray();
        $.ajax({
          url: "{{ route('customer_role.store') }}",
          type: "POST",
          data: data,
          success: function () {
            create_modal.modal("hide");
            CustomerRoleIndexTemplate.initData();
            toastr.success("@lang('globals/success_messages.success', ['attr' => __('globals/words.customer_role')])");
          },
          error: function () {
            toastr.error("@lang('globals/error_messages.save_error', ['attr' => __('globals/words.customer_role')])");
          }
        });
      };
      validateBasicForm("customer_role_create_form", validations, formValidated);
      return {}
    }();
  </script>
@endpush
