<x-modal.modal id="edit_modal">
  <x-slot name="title">Gider Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="edit_form">
      <div class="row row-cols-2">
        <x-form.input name="price" label="Fiyat" placeholder="Fiyat" money required/>
        <x-form.select label="Kasa" name="safe_id" :asyncload="route('safe.select')" required parent="#edit_modal"
                       editing/>
      </div>
      <div class="row row-cols-2">
        <x-form.select label="Ödeme Türü" name="staff_payment_type_id" :asyncload="route('staff-payment-type.select')"
                       required parent="#edit_modal" editing/>
        <x-form.input name="date" label="Tarih" placeholder="Tarih" required :date="true"/>
      </div>
      <div class="row row-cols-1">
        <x-form.textarea name="description" label="Açıklama"/>
        <x-form.button>Kaydet</x-form.button>
      </div>
    </x-form.form>
  </x-slot>
</x-modal.modal>

@push('customscripts')
  <script>
    const StaffPaymentEditTemplate = function () {
      let id;
      let modal_target = document.querySelector("#edit_modal_target");
      let block_ui_modal_target = new KTBlockUI(modal_target);
      let edit_modal = $("#edit_modal");
      let validations = {
        price: {
          validators: {
            numeric: {
              thousandsSeparator: ".",
              message: "Fiyat gereklidir",
              decimalSeparator: ",",
            },
          }
        },
        date: {
          validators: {
            date: {
              format: 'DD-MM-YYYY',
              message: 'Geçerli bir tarih girin',
            },
            notEmpty: {
              message: 'Tarih boş geçilemez',
            },
          }
        },
        'safe_id': {
          validators: {
            notEmpty: {
              message: "Kasa seçilmesi zorunludur"
            }
          }
        },
        'staff_payment_type_id': {
          validators: {
            notEmpty: {
              message: "Gider tipi seçilmesi zorunludur"
            }
          }
        }
      };
      const formValidated = (form, submitButton) => {
        let data = $(form).serializeArray();
        $.ajax({
          url: `{{ route('staff-payment.update') }}/${id}`,
          type: "POST",
          data: data,
          success: function (data) {
            $("#edit_modal").modal("hide");
            table.ajax.reload(null, false);
            submitButton.disabled = false;
            toastr.success("Başarılı!");
          },
          error: function (err) {
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      };
      const showModalAction = function (e) {
        id = $(e.target).data('editId');
        $.ajax({
          url: `{{ route('staff-payment.get') }}/${id}`,
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
            let payment_type_option = new Option(data.payment_type.name, data.payment_type.id, false, true);
            $(form).find('select[name="staff_payment_type_id"]').html(payment_type_option);
            let safe_option = new Option(data.safe.name, data.safe.id, false, true);
            $(form).find('select[name="safe_id"]').html(safe_option);
            $(form).find('textarea[name="description"]').val(data.description);
            block_ui_modal_target.release();
          },
          error: function (){
            toastr.error("@lang('globals/error_messages.fetch_error', ['attr' => __('globals/words.expense')])")
            block_ui_modal_target.release();
            edit_modal.modal('hide');
          }
        });
      };
      const afterFormValidated = (form, validator) => {
        $(form).find('.safe_id_edit_select').on('change', function () {
          validator.revalidateField('safe_id');
        });
        $(form).find('.staff_payment_type_id_edit_select').on('change', function () {
          validator.revalidateField('staff_payment_type_id');
        });
      };
      const {form} = validateBasicForm("edit_form", validations, formValidated, null, afterFormValidated);

      return {edit_modal, showModalAction};
    }();

    StaffPaymentEditTemplate.edit_modal.on('shown.bs.modal', StaffPaymentEditTemplate.showModalAction);

  </script>
@endpush
