<x-modal.modal id="edit_modal">
  <x-slot name="title">Gider Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="edit_form">
      <div class="row row-cols-2">
        <x-form.select :label="__('globals/words.expense_type')"
                       name="expense_type_id"
                       :asyncload="route('expense_type.select')"
                       required
                       editing
                       parent="#edit_modal"/>
        <x-form.input name="date"
                      :label="__('globals/words.date')"
                      :placeholder="__('globals/words.date')"
                      required
                      :date="true"/>
      </div>
      <div class="row row-cols-2">
        <x-form.input name="price"
                      :label="__('globals/words.price')"
                      :placeholder="__('globals/words.price')"
                      money
                      required/>
        <x-form.select :label="__('layout/aside/menu.safe')"
                       name="safe_id"
                       :asyncload="route('safe.select')"
                       required
                       parent="#edit_modal"
                       editing/>
      </div>

      <x-form.textarea name="comment" :label="__('globals/words.comment')"/>
      <x-form.button>@lang('globals/words.save')</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>

@push('customscripts')
  <script>
    var id;
    var blockUI = new KTBlockUI(document.querySelector("#edit_modal_target"));
    $("#edit_modal").on('shown.bs.modal', function (e) {
      id = $(e.target).data('editId');
      $.ajax({
        url: "{{ route('expense.get') }}",
        data: {
          id
        },
        type: "POST",
        beforeSend: () => {
          blockUI.block();
        },
        success: function (data) {
          $(editForm).find('input[name="price"]').val(data.price).maskMoney("mask")
          $(editForm).find('input[name="date"]').val(data.date).flatpickr();
          let expense_type_option = new Option(data.expense_type.name, data.expense_type.id, false, true);
          $(editForm).find('select[name="expense_type_id"]').html(expense_type_option);
          let safe_option = new Option(data.safe.name, data.safe.id, false, true);
          $(editForm).find('select[name="safe_id"]').html(safe_option);
          $(editForm).find('textarea[name="comment"]').val(data.comment);
          blockUI.release();
        },
        error: function () {
          blockUI.release();
        }
      });
    });
    let {
      form: editForm,
      validator: editValidator
    } = validateBasicForm("edit_form", {
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
      data.push({
        name: "id",
        value: id
      });
      $.ajax({
        url: "{{ route('expense.update') }}",
        type: "POST",
        data: data,
        success: function (data) {
          $("#edit_modal").modal("hide");
          table.ajax.reload(null, false);
          toastr.success("@lang('globals/success_messages.success', ['attr' => __('layout/aside/menu.expense')])");
        },
        error: function (err) {
          toastr.error("@lang('globals/error_messages.edit_error', ['attr' => __('layout/aside/menu.expense')])");
        }
      });
    }, () => {
    }, (form, validator) => {
      $(form).find('.safe_id_edit_select').on('change', function () {
        validator.revalidateField('safe_id');
      });
      $(form).find('.expense_type_id_edit_select').on('change', function () {
        validator.revalidateField('expense_type_id');
      });
    });
  </script>
@endpush
