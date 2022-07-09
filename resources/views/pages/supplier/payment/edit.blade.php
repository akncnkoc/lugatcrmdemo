<x-modal.modal id="edit_modal" size="modal-lg">
  <x-slot name="title">Ödeme Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="edit_form">
      <div class="row row-cols-2">
        <x-form.input name="price" label="Fiyat" placeholder="Fiyat" money required/>
        <x-form.select label="Kasa" name="safe_id" :asyncload="route('safe.select')" required parent="#edit_moda" editing/>
      </div>
      <div class="row row-cols-2 align-items-center">
        <x-form.input name="date" label="Tarih" placeholder="Tarih" required date/>
        <x-form.checkbox name="payable" label="Ödeme Tamamlandı mı?" hint="Ödeme sadece bu seçenek açık ise kasadan düşme işlemi olacaktır."/>
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
    const SupplierPaymentEditTemplate = function () {
      let id;
      let modal_target = document.querySelector("#edit_modal_target");
      let edit_modal = $("#edit_modal");
      let block_ui_modal_target = new KTBlockUI(modal_target);
      let validations = {
        price: {
          validators: {
            numeric: {
              thousandsSeparator: ".",
              message: "Fiyat gereklidir",
              decimalSeparator: ",",
            },
            greaterThan: {
              min: 1,
              message: "Fiyat 0'dan büyük olmalıdır"
            }
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
      };
      const formValidated = (form, submitButton) => {
        let data = $(form).serializeArray();
        $.ajax({
          url: `{{ route('supplier-payment.update') }}/${id}`,
          type: "POST",
          data: data,
          success: function (data) {
            edit_modal.modal("hide");
            SupplierPaymentIndexTemplate.initData();
            toastr.success("Başarılı!");
          },
          error: function (err) {
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      };
      const afterFormLoaded = (form, validator) => {
        $(form).find('.safe_id_edit_select').on('change', function () {
          validator.revalidateField('safe_id');
        });
        $(form).find('.staff_payment_type_id_edit_select').on('change', function () {
          validator.revalidateField('staff_payment_type_id');
        });
      };
      let {form} = validateBasicForm("edit_form", validations, formValidated, null, afterFormLoaded);
      const showModalAction = (e) => {
        id = $(e.target).data('itemId');
        $.ajax({
          url: `{{ route('supplier-payment.get') }}/${id}`,
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
            $(form).find('input[name="payable"]').prop('checked', data.payable);
            let safe_option = new Option(data.safe.name, data.safe.id, false, true);
            $(form).find('select[name="safe_id"]').html(safe_option);
            $(form).find('textarea[name="description"]').val(data.description);
            block_ui_modal_target.release();
          },
          error: function () {
            edit_modal.modal('hide');
            toastr.error("@lang('globals/error_messages.fetch_error', ['attr' => __('layout/aside/menu.product')])")
          }
        });
      };
      return {edit_modal, showModalAction};
    }();
    SupplierPaymentEditTemplate.edit_modal.on('shown.bs.modal', SupplierPaymentEditTemplate.showModalAction);
  </script>
@endpush
