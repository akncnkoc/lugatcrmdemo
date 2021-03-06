<x-modal.modal id="expense_type_create_modal">
  <x-slot name="title">@lang('pages/expense.expense_type_add')</x-slot>
  <x-slot name="body">
    <x-form.form id="expense_type_create_form">
      <div class="row row-cols-1">
        <x-form.input name="name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')" required/>
      </div>
      <x-form.button>@lang('globals/words.save')</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    const ExpenseTypeCreateTemplate = function (){
      let create_form = "expense_type_create_form";
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
        $.ajax({
          url: "{{ route('expense_type.store') }}",
          type: "POST",
          data: data,
          success: function (data) {
            $("#expense_type_create_modal").modal("hide");
            ExpenseTypeIndexTemplate.initData();
            toastr.success("@lang('globals/success_messages.success', ['attr' => __('globals/words.expense_type')])");
          },
          error: function (err) {
            toastr.error("@lang('globals/error_messages.save_error', ['attr' => __('globals/words.expense_type')])");
          }
        });
      }
      const init = () => {
        validateBasicForm(create_form, validations, formValidated);
      }
      return {init};
    }();
    ExpenseTypeCreateTemplate.init();
  </script>
@endpush

