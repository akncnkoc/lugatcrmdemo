<x-modal.modal id="customer_role_edit_modal">
  <x-slot name="title">@lang('pages/customer.customer_role_edit')</x-slot>
  <x-slot name="body">
    <x-form.form id="customer_role_edit_form">
      <div class="row row-cols-1">
        <x-form.input name="name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')" required/>
      </div>
      <x-form.button>@lang('globals/words.save')</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    const CustomerRoleEditTemplate = function () {
      let id,
        edit_modal = $("#customer_role_edit_modal"),
        modal_target = document.querySelector("#customer_role_edit_modal_target"),
        block_ui_modal_target = new KTBlockUI(modal_target),
        validations = {
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
      const showModalAction = (e) => {
        id = $(e.target).data('itemId');
        $.ajax({
          url: "{{ route('customer_role.get') }}",
          data: {
            id
          },
          type: "POST",
          beforeSend: () => {
            block_ui_modal_target.block();
          },
          success: function (data) {
            $(form).find('input[name="name"]').val(data.name);
            block_ui_modal_target.release();
          },
          error: {}
        });
      }
      const formValidated = (form) => {
        let data = $(form).serializeArray();
        data.push({
          name: "id",
          value: id
        });
        $.ajax({
          url: "{{ route('customer_role.update') }}",
          type: "POST",
          data: data,
          success: function () {
            edit_modal.modal("hide");
            CustomerRoleIndexTemplate.initData();
            toastr.success("@lang('globals/success_messages.success', ['attr' => __('globals/words.customer_role')])");
          },
          error: function () {
            toastr.error("@lang('globals/error_messages.edit_error', ['attr' => __('globals/words.customer_role')])");
          }
        });
      };
      let {form} = validateBasicForm("customer_role_edit_form", validations, formValidated);
      edit_modal.on('shown.bs.modal', showModalAction);
      return {};
    }();

  </script>
@endpush
