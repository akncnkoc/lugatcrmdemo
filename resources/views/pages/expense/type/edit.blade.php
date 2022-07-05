<x-modal.modal id="expense_type_edit_modal">
  <x-slot name="title">@lang('pages/expense.expense_type_edit')</x-slot>
  <x-slot name="body">
    <x-form.form id="expense_type_edit_form">
      <div class="row row-cols-1">
        <x-form.input name="name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')" required/>
      </div>
      <x-form.button>@lang('globals/words.save')</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    const ExpenseTypeEditTemplate = function () {
      let id;
      let edit_modal = $("#expense_type_edit_modal");
      let modal_target = document.querySelector("#expense_type_edit_modal_target");
      let block_ui_modal_target = new KTBlockUI(modal_target);
      let validations = {
        name: {
          validators: {
            notEmpty: {
              message: "@lang('globals/validation_messages.required', ['field_name' => __('globals/words.name')])"
            },
            stringLength: {
              min: 3,
              message: "@lang('globals/validation_messages.min', ['field_name' => __('globals/words.name'), 'min' => 3])"
            }
          }
        }
      };
      const formValidated = (form) => {
        let data = $(form).serializeArray();
        data.push({
          name: "id",
          value: id
        });
        $.ajax({
          url: "{{ route('expense_type.update') }}",
          type: "POST",
          data: data,
          success: function (data) {
            edit_modal.modal("hide");
            ExpenseTypeIndexTemplate.initData();
            toastr.success("@lang('globals/success_messages.success', ['attr' => __('globals/words.expense_type')])");
          },
          error: function () {
            edit_modal.modal("hide");
            toastr.error("@lang('globals/error_messages.edit_error', ['attr' => __('globals/words.expense_type')])");
          }
        });
      }
      const modalShowAction = (e) => {
        id = $(e.target).data('editId');
        $.ajax({
          url: "{{ route('expense_type.get') }}",
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
      };
      const {form} = validateBasicForm("expense_type_edit_form", validations, formValidated);
      return {edit_modal, modalShowAction};
    }();
    ExpenseTypeEditTemplate.edit_modal.on('shown.bs.modal', ExpenseTypeEditTemplate.modalShowAction);
  </script>
@endpush
