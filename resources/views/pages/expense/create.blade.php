<x-modal.modal id="create_modal">
  <x-slot name="title">Gider Ekle</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-2">
        <x-form.select label="Gider Türü" name="expense_type_id" :asyncload="route('expense_type.select')" required parent="#create_modal" />
        <x-form.input name="date" label="Tarih" placeholder="Tarih" required :date="true" />
      </div>
      <div class="row row-cols-2">
        <x-form.input name="price" label="Fiyat" placeholder="Fiyat" money required />
        <x-form.select label="Kasa" name="safe_id" :asyncload="route('safe.select')" required parent="#create_modal" />
      </div>
      <x-form.textarea name="comment" label="Açıklama" />
      <x-form.button>Kaydet</x-form.button>
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
      'expense_type_id': {
        validators: {
          notEmpty: {
            message: "Gider tipi seçilmesi zorunludur"
          }
        }
      }
    }, (form) => {
      let data = $(form).serializeArray();
      $.ajax({
        url: "{{ route('expense.store') }}",
        type: "POST",
        data: data,
        success: function(data) {
          $("#create_modal").modal("hide");
          table.ajax.reload(null,false);
          toastr.success("Başarılı!");
        },
        error: function(err) {
          toastr.error("Bir sorun var daha sonra tekrar deneyin!");
        }
      });
    }, () => {
      console.log("invalidated")
    }, (form, validator) => {
      $(form).find('.safe_id_select').on('change', function() {
        validator.revalidateField('safe_id');
      });
      $(form).find('.expense_type_id_select').on('change', function() {
        validator.revalidateField('expense_type_id');
      });
    });
  </script>
@endpush
