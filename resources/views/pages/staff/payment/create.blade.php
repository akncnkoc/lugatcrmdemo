<x-modal.modal id="create_modal">
  <x-slot name="title">@lang('globals/words.payment_add')</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-2">
        <x-form.input name="price" :label="__('globals/words.price')" :placeholder="__('globals/words.price')" money required/>
        <x-form.select :label="__('globals/words.safe')" name="safe_id" :asyncload="route('safe.select')" required parent="#create_modal"/>
      </div>
      <div class="row row-cols-2">
        <x-form.select :label="__('globals/words.staff_payment_type')" name="staff_payment_type_id" :asyncload="route('staff-payment-type.select')" required
                       parent="#create_modal"/>
        <x-form.input name="date" :label="__('globals/words.date')" :placeholder="__('globals/words.date')" required :date="true"/>
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
    const StaffPaymentCreateTemplate = function () {
      let create_modal = $("#create_modal");
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
          url: "{{ route('staff-payment.store', $staff->id) }}",
          type: "POST",
          data: data,
          success: function (data) {
            create_modal.modal("hide");
            table.ajax.reload(null, false);
            submitButton.disabled = false;
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
        $(form).find('.expense_type_id_select').on('change', function () {
          validator.revalidateField('staff_payment_type_id');
        });
      };
      validateBasicForm("create_form", validations, formValidated, null, afterFormLoaded);
      return {};
    }();
  </script>
@endpush
