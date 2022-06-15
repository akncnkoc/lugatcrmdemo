<x-modal.modal id="create_modal">
  <x-slot name="title">@lang('pages/expense.expense_add')</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-2">
        <x-form.select :label="__('globals/words.expense_type')"
                       name="expense_type_id"
                       :asyncload="route('expense_type.select')"
                       required
                       parent="#create_modal" />
        <x-form.input name="date"
                      :label="__('globals/words.date')"
                      :placeholder="__('globals/words.date')"
                      required
                      :date="true" />
      </div>
      <div class="row row-cols-2">
        <x-form.input name="price"
                      :label="__('globals/words.price')"
                      :placeholder="__('globals/words.price')"
                      money
                      required />
        <x-form.select :label="__('layout/aside/menu.safe')" name="safe_id" :asyncload="route('safe.select')" required
                       parent="#create_modal" />
      </div>
      <x-form.textarea name="comment" :label="__('globals/words.comment')" />
      <x-form.button>@lang('globals/words.save')</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    let {
      form: createForm,
      validator: createValidator
    } = validateForm("create_form", {
      price: {
        validators: {
          numeric: {
            thousandsSeparator: ".",
            message: "@lang('globals/validation_messages.required', ['field_name'  => __('globals/words.price')])",
            decimalSeparator: ",",
          },
          greaterThan: {
            min: 1,
            message: "@lang('globals/validation_messages.min', ['field_name'  => __('globals/words.price'), 'min' => 1])"
          }
        }
      },
      date: {
        validators: {
          date: {
            format: 'DD-MM-YYYY',
            message: '@lang('globals/validation_messages.correct_format', ['field_name' => __('globals/words.date'),'format' => '01-01-1990'])',
          },
          notEmpty: {
            message: '@lang('globals/validation_messages.required',['field_name'  => __('globals/words.date')])',
          },
        }
      },
      'safe_id': {
        validators: {
          notEmpty: {
            message: "@lang('globals/validation_messages.required', ['field_name' => __('layout/aside/menu.safe')])"
          }
        }
      },
      'expense_type_id': {
        validators: {
          notEmpty: {
            message: "@lang('globals/validation_messages.required', ['field_name' => __('globals/words.expense_type')])"
          }
        }
      }
    }, (form) => {
      let data = $(form).serializeArray();
      $.ajax({
        url: "{{ route('expense.store') }}",
        type: "POST",
        data: data,
        success: function (data) {
          $("#create_modal").modal("hide");
          table.ajax.reload(null, false);
          toastr.success("@lang('globals/success_messages.success', ['attr' => __('layout/aside/menu.expense')])");
        },
        error: function (err) {
          toastr.error("@lang('globals/error_messages.save_error', ['attr' => __('layout/aside/menu.expense')])");
        }
      });
    }, () => {
    }, (form, validator) => {
      $(form).find('.safe_id_select').on('change', function () {
        validator.revalidateField('safe_id');
      });
      $(form).find('.expense_type_id_select').on('change', function () {
        validator.revalidateField('expense_type_id');
      });
    });
  </script>
@endpush
