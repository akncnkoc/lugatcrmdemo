<x-modal.modal id="create_modal" size="modal-lg">
  <x-slot name="title">Ödeme Ekle</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-2">
        <x-form.input name="price" label="Fiyat" placeholder="Fiyat" money required/>
        <x-form.select label="Kasa" name="safe_id" :asyncload="route('safe.select')" required parent="#create_modal"/>
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
    const SupplierPaymentCreateTemplate = function () {
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
          url: "{{ route('supplier-payment.store', $supplier->id) }}",
          type: "POST",
          data: data,
          success: function (data) {
            $("#create_modal").modal("hide");
            SupplierPaymentIndex.initData();
            toastr.success("Başarılı!");
          },
          error: function (err) {
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      };
      const afterFormLoaded = (form, validator) => {
        $(form).find('.safe_id_select').on('change', function () {
          validator.revalidateField('safe_id');
        });
      };
      validateBasicForm("create_form", validations, formValidated, null, afterFormLoaded);
      return {};
    }();
  </script>
@endpush
