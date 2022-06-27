<x-modal.modal id="edit_modal">
  <x-slot name="title">Ürün Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="edit_form">
      <div class="row row-cols-1">
        <x-form.input name="name" label="Ürün Adı" placeholder="Ürün Adı" required/>
      </div>
      <div class="row row-cols-2">
        <x-form.input name="model_code" label="Model Kodu" placeholder="Model Kodu"/>
        <x-form.select label="Ürün Tipi" name="product_type_id" :asyncload="route('product_type.select')" required editing
                       hint="Ürün tipi ürünün genel modelini belirtir ve ürün raporunun kategorilenebilmesi için gereklidir."
                       parent="#edit_modal"/>
      </div>
      <div class="row row-cols-2">
        <x-form.input name="buy_price" label="Alış Fiyatı" placeholder="Alış Fiyatı" money required/>
        <x-form.select label="Kasa" name="buy_price_safe_id" editing :asyncload="route('safe.select')" required parent="#edit_modal"/>
      </div>
      <div class="row row-cols-2">
        <x-form.input name="sale_price" label="Satış Fiyatı" placeholder="Satış Fiyatı" money required/>
        <x-form.select label="Kasa" name="sale_price_safe_id" editing :asyncload="route('safe.select')" required parent="#edit_modal"/>
      </div>
      <x-form.select label="Tedarikçiler" name="suppliers" editing :asyncload="route('supplier.select')" required multiple
                     parent="#edit_modal"/>
      <x-form.checkbox label="Kritik Stok Uyarısı" name="critical_stock_alert"
                       hint="Ürün'de kritik stok kaldığı zaman bilgilendirilmek için kullanılır."/>
      <x-form.button>Kaydet</x-form.button>
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
        url: "{{ route('product.get') }}",
        data: {
          id
        },
        type: "POST",
        beforeSend: () => {
          blockUI.block();
        },
        success: function (data) {
          $(editForm).find('input[name="name"]').val(data.name);
          $(editForm).find('input[name="model_code"]').val(data.model_code);
          $(editForm).find('input[name="buy_price"]').val(data.buy_price).maskMoney("mask")
          $(editForm).find('input[name="sale_price"]').val(data.sale_price).maskMoney("mask")
          let product_type_option = new Option(data.product_type.name, data.product_type.id, false, true);
          $(editForm).find('select[name="product_type_id"]').html(product_type_option);

          let buy_price_safe_option = new Option(data.buy_price_safe.name, data.buy_price_safe.id, false, true);
          $(editForm).find('select[name="buy_price_safe_id"]').html(buy_price_safe_option);
          let sale_price_safe_option = new Option(data.sale_price_safe.name, data.sale_price_safe.id, false,
            true);
          $(editForm).find('select[name="sale_price_safe_id"]').html(sale_price_safe_option);
          let suppliers = [];
          if (data.suppliers && data.suppliers.length) {
            data.suppliers.map((item, index) => suppliers[index] = new Option(item.supplier.name, item.supplier
              .id, true, true))
          }
          $(editForm).find('select[name="suppliers[]"]').html(suppliers);
          $(editForm).find('input[name="critical_stock_alert"]').prop('checked', data.critical_stock_alert);
          blockUI.release();
        },
        error: function () {
          toastr.error("Yüklemede bir sorun oluştu, tekrar deneyin");
          blockUI.release()
        }
      });
    });
    var {
      form: editForm,
      validator: editValidator
    } = validateBasicForm("edit_form", {
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
    }, (form) => {
      let data = $(form).serializeArray();
      data.push({
        name: 'id',
        value: id
      });
      $.ajax({
        url: "{{ route('product.update') }}",
        type: "POST",
        data: data,
        success: function (data) {
          $("#edit_modal").modal("hide");
          table.ajax.reload(null, false);
          toastr.success("Başarılı!");
        },
        error: function (err) {
          toastr.error("Bir sorun var daha sonra tekrar deneyin!");
        }
      });
    }, () => {
      console.log("invalidated")
    }, (form, validator) => {
      $(form).find('.buy_price_safe_id_edit_select').on('change', function () {
        validator.revalidateField('buy_price_safe_id');
      });
      $(form).find('.sale_price_safe_id_edit_select').on('change', function () {
        validator.revalidateField('sale_price_safe_id');
      });
      $(form).find('.product_type_id_edit_select').on('change', function () {
        validator.revalidateField('product_type_id');
      });
    });
  </script>
@endpush
