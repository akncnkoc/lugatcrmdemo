<x-modal.modal id="create_modal">
  <x-slot name="title">Ürün Ekle</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-1">
        <x-form.input name="name" label="Ürün Adı" placeholder="Ürün Adı" required/>
      </div>
      <div class="row row-cols-2">
        <x-form.input name="model_code" label="Model Kodu" placeholder="Model Kodu"/>
        <x-form.select label="Ürün Tipi" name="product_type_id" :asyncload="route('product_type.select')" required
                       hint="Ürün tipi ürünün genel modelini belirtir ve ürün raporunun kategorilenebilmesi için gereklidir."
                       parent="#create_modal"/>
      </div>
      <div class="row row-cols-2">
        <x-form.input name="buy_price" label="Alış Fiyatı" placeholder="Alış Fiyatı" money required/>
        <x-form.select label="Kasa" name="buy_price_safe_id" :asyncload="route('safe.select')" required parent="#create_modal"/>
      </div>
      <div class="row row-cols-2">
        <x-form.input name="sale_price" label="Satış Fiyatı" placeholder="Satış Fiyatı" money required/>
        <x-form.select label="Kasa" name="sale_price_safe_id" :asyncload="route('safe.select')" required parent="#create_modal"/>
      </div>
      <x-form.select label="Tedarikçiler" name="suppliers" :asyncload="route('supplier.select')" required multiple parent="#create_modal"/>
      <x-form.checkbox label="Kritik Stok Uyarısı" name="critical_stock_alert"
                       hint="Ürün'de kritik stok kaldığı zaman bilgilendirilmek için kullanılır."/>
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>

@push('customscripts')
  <script>
    const ProductCreateTemplate = function () {
      let create_modal = $("#create_modal");
      let validations = {
        name: {
          validators: {
            notEmpty: {
              message: "Ürün adı zorunludur"
            }
          }
        },
        'product_type_id': {
          validators: {
            notEmpty: {
              message: "Ürün tipi seçilmesi zorunludur"
            }
          }
        },
        'buy_price': {
          validators: {
            numeric: {
              thousandsSeparator: ".",
              message: "Alış fiyatı gereklidir",
              decimalSeparator: ",",
            },
            greaterThan: {
              min: 1,
              message: "Alış fiyatı 0'dan büyük olmalıdır"
            }
          }
        },
        'sale_price': {
          validators: {
            numeric: {
              thousandsSeparator: ".",
              message: "Satış fiyatı gereklidir",
              decimalSeparator: ",",
            },
            greaterThan: {
              min: 1,
              message: "Satış fiyatı 0'dan büyük olmalıdır"
            }
          }
        },
        'buy_price_safe_id': {
          validators: {
            notEmpty: {
              message: "Kasa seçilmesi zorunludur"
            }
          }
        },
        'sale_price_safe_id': {
          validators: {
            notEmpty: {
              message: "Kasa seçilmesi zorunludur"
            }
          }
        },

      };
      let formValidated = (form) => {
        let data = $(form).serializeArray();
        $.ajax({
          url: "{{ route('product.store') }}",
          type: "POST",
          data: data,
          success: function (data) {
            create_modal.modal("hide");
            table.ajax.reload(null, false);
            toastr.success("Başarılı!");
          },
          error: function (err) {
            toastr.error("@lang('globals/error_messages.save_error', ['attr' => __('layout/aside/menu.product')])");
          }
        });
      };
      let formAfterLoaded = (form, validator) => {
        $(form).find('.buy_price_safe_id_select').on('change', function () {
          validator.revalidateField('buy_price_safe_id');
        });
        $(form).find('.sale_price_safe_id_select').on('change', function () {
          validator.revalidateField('sale_price_safe_id');
        });
        $(form).find('.product_type_id_select').on('change', function () {
          validator.revalidateField('product_type_id');
        });
      }
      validateBasicForm("create_form", validations, formValidated, null, formAfterLoaded);
      return {};
    }();

  </script>
@endpush
