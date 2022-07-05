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
    const ExpenseEditTemplate = function (){
      let id;
      let edit_modal = $("#edit_modal");
      let modal_target =document.querySelector("#edit_modal_target")
      let block_ui_modal_target = new KTBlockUI(modal_target);

      let validations = {
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
      };
      let formValidated = (form) => {
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
      };
      let formAfterLoaded =  (form, validator) => {
        $(form).find('.safe_id_edit_select').on('change', function () {
          validator.revalidateField('safe_id');
        });
        $(form).find('.expense_type_id_edit_select').on('change', function () {
          validator.revalidateField('expense_type_id');
        });
      };
      const {form} = validateBasicForm("edit_form", validations,formValidated ,null,formAfterLoaded);
      let showAction = (e) =>  {
        id = $(e.target).data('itemId');
        $.ajax({
          url: "{{ route('expense.get') }}",
          data: {
            id
          },
          type: "POST",
          beforeSend: () => {
            block_ui_modal_target.block();
          },
          success: function (data) {
            $(form).find('input[name="price"]').val(data.price).maskMoney("mask")
            $(form).find('input[name="date"]').val(data.date).flatpickr();
            let expense_type_option = new Option(data.expense_type.name, data.expense_type.id, false, true);
            $(form).find('select[name="expense_type_id"]').html(expense_type_option);
            let safe_option = new Option(data.safe.name, data.safe.id, false, true);
            $(form).find('select[name="safe_id"]').html(safe_option);
            $(form).find('textarea[name="comment"]').val(data.comment);
            block_ui_modal_target.release();
          },
          error: function () {
            toastr.error("@lang('globals/error_messages.fetch_error', ['attr' => __('globals/words.expense')])")
            block_ui_modal_target.release();
            edit_modal.modal('hide');
          }
        });
      };
      return {edit_modal, showAction};

    }();

    ExpenseEditTemplate.edit_modal.on('shown.bs.modal', ExpenseEditTemplate.showAction);

  </script>
@endpush
