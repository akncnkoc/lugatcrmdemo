<x-modal.modal id="edit_modal" size="modal-lg">
  <x-slot name="title">Ödeme Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="edit_form">
      <div class="row row-cols-2">
        <x-form.input name="price" label="Fiyat" placeholder="Fiyat" money required />
        <x-form.select label="Kasa" name="safe_id" :asyncload="route('safe.select')" required parent="#edit_moda" editing />
      </div>
      <div class="row row-cols-2 align-items-center">
        <x-form.input name="date" label="Tarih" placeholder="Tarih" required date />
        <x-form.checkbox name="payable" label="Ödeme Tamamlandı mı?" hint="Ödeme sadece bu seçenek açık ise kasadan düşme işlemi olacaktır."  />
      </div>
      <div class="row row-cols-1">
        <x-form.textarea name="description" label="Açıklama" />
        <x-form.button>Kaydet</x-form.button>
      </div>
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
        url: `{{ route('supplier-payment.get') }}/${id}`,
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
          $(editForm).find('input[name="payable"]').prop('checked', data.payable);
          let safe_option = new Option(data.safe.name, data.safe.id, false, true);
          $(editForm).find('select[name="safe_id"]').html(safe_option);
          $(editForm).find('textarea[name="description"]').val(data.description);
          blockUI.release();
        },
        error: function(){
          blockUI.release();
        }
      });
    });
    let {
      form: editForm,
      validator: editValidator
    } = validateForm("edit_form", {
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
    }, (form, submitButton) => {
      let data = $(form).serializeArray();
      $.ajax({
        url: `{{ route('supplier-payment.update') }}/${id}`,
        type: "POST",
        data: data,
        success: function (data) {
          $("#edit_modal").modal("hide");
          table.ajax.reload(null, false);
          submitButton.disabled = false;
          toastr.success("Başarılı!");
        },
        error: function (err) {
          submitButton.disabled = false;
          toastr.error("Bir sorun var daha sonra tekrar deneyin!");
        }
      });
    }, () => {
      console.log("invalidated")
    }, (form, validator) => {
      $(form).find('.safe_id_edit_select').on('change', function () {
        validator.revalidateField('safe_id');
      });
      $(form).find('.staff_payment_type_id_edit_select').on('change', function () {
        validator.revalidateField('staff_payment_type_id');
      });
    });
  </script>
@endpush
