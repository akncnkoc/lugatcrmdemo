<x-modal.modal id="customer_role_edit_modal">
  <x-slot name="title">@lang('pages/customer.customer_role_edit')</x-slot>
  <x-slot name="body">
    <x-form.form id="customer_role_edit_form">
      <div class="row row-cols-1">
        <x-form.input name="name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')"
                      required/>
      </div>
      <x-form.button>@lang('globals/words.save')</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    var id;
    var blockUI = new KTBlockUI(document.querySelector("#customer_role_edit_modal_target"));
    $("#customer_role_edit_modal").on('shown.bs.modal', function (e) {
      id = $(e.target).data('editId');
      $.ajax({
        url: "{{ route('customer_role.get') }}",
        data: {
          id
        },
        type: "POST",
        beforeSend: () => {
          blockUI.block();
        },
        success: function (data) {
          $(customerRoleEditForm).find('input[name="name"]').val(data.name);
          blockUI.release();
        },
        error: {}
      });
    });
    let {
      form: customerRoleEditForm
    } = validateBasicForm("customer_role_edit_form", {
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
    }, (form) => {
      let data = $(form).serializeArray();
      data.push({
        name: "id",
        value: id
      });
      $.ajax({
        url: "{{ route('customer_role.update') }}",
        type: "POST",
        data: data,
        success: function (data) {
          $("#customer_role_edit_modal").modal("hide");
          initCustomerRoleData();
          toastr.success("@lang('globals/success_messages.success', ['attr' => __('globals/words.customer_role')])");
        },
        error: function (err) {
          toastr.error("@lang('globals/error_messages.edit_error', ['attr' => __('globals/words.customer_role')])");
        }
      });
    });
  </script>
@endpush
