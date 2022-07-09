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
    const ProductEditTemplate = function () {
      let id;
      let edit_modal = $("#edit_modal");
      let modal_target = document.querySelector("#edit_modal_target");
      let block_ui_modal_target = new KTBlockUI(modal_target);
      let name_selector = 'input[name="name"]',
        model_code_selector = 'input[name="model_code"]',
        buy_price_selector = 'input[name="buy_price"]',
        sale_price_selector = 'input[name="sale_price"]',
        product_type_selector = 'select[name="product_type_id"]',
        buy_price_safe_selector = 'select[name="buy_price_safe_id"]',
        sale_price_safe_selector = 'select[name="sale_price_safe_id"]',
        supplier_selector = 'select[name="suppliers[]"]',
        critical_alert_selector = 'input[name="critical_stock_alert"]';
      const showModalAction = (e) => {
        id = $(e.target).data('itemId');
        $.ajax({
          url: "{{ route('product.get') }}",
          data: {
            id
          },
          type: "POST",
          beforeSend: () => {
            block_ui_modal_target.block();
          },
          /**
           * @param {Object} data -> Product
           * @param {string} data.name -> Name
           * @param {string} data.model_code -> Model Code
           * @param {string} data.buy_price -> Buy Price
           * @param {string} data.sale_price -> Sale Price
           * @param {Object} data.product_type
           * @param {Object} data.buy_price_safe
           * @param {Object} data.sale_price_safe
           * @param {Object[]} data.suppliers
           * @param {boolean} data.critical_stock_alert
           */
          success: function (data) {
            $(form).find(name_selector).val(data.name);
            $(form).find(model_code_selector).val(data.model_code);
            $(form).find(buy_price_selector).val(data.buy_price).maskMoney("mask")
            $(form).find(sale_price_selector).val(data.sale_price).maskMoney("mask")
            let product_type_option = new Option(data.product_type.name, data.product_type.id, false, true);
            $(form).find(product_type_selector).html(product_type_option);

            let buy_price_safe_option = new Option(data.buy_price_safe.name, data.buy_price_safe.id, false, true);
            $(form).find(buy_price_safe_selector).html(buy_price_safe_option);
            let sale_price_safe_option = new Option(data.sale_price_safe.name, data.sale_price_safe.id, false,
              true);
            $(form).find(sale_price_safe_selector).html(sale_price_safe_option);
            let suppliers = [];
            if (data.suppliers && data.suppliers.length) {
              /**
               * @param {Object[]} item -> Suppliers
               * @param {Object} item.supplier -> Supplier
               */
              data.suppliers.map((item, index) => suppliers[index] = new Option(item.supplier.name, item.supplier.id, true, true))
            }
            $(form).find(supplier_selector).html(suppliers);
            $(form).find(critical_alert_selector).prop('checked', data.critical_stock_alert);
            block_ui_modal_target.release();
          },
          error: function () {
            edit_modal.modal('hide');
            toastr.error("@lang('globals/error_messages.fetch_error', ['attr' => __('layout/aside/menu.product')])")
          }
        });
      };
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
        data.push({
          name: 'id',
          value: id
        });
        $.ajax({
          url: "{{ route('product.update') }}",
          type: "POST",
          data: data,
          success: function (data) {
            edit_modal.modal("hide");
            ProductIndexTemplate.table.ajax.reload(null, false);
            toastr.success("Başarılı!");
          },
          error: function (err) {
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      };
      let formAfterLoaded = (form, validator) => {
        let buy_price_safe_edit_selector = ".buy_price_safe_id_edit_select",
          sale_price_safe_edit_selector = ".sale_price_safe_id_edit_select",
          product_type_edit_selector = ".product_type_id_edit_select";
        $(form).find(buy_price_safe_edit_selector).on('change', () => validator.revalidateField('buy_price_safe_id'));
        $(form).find(sale_price_safe_edit_selector).on('change', () => validator.revalidateField('sale_price_safe_id'));
        $(form).find(product_type_edit_selector).on('change', () => validator.revalidateField('product_type_id'));
      };
      const {form} = validateBasicForm("edit_form", validations, formValidated, null, formAfterLoaded);
      return {edit_modal, showModalAction};
    }();

    ProductEditTemplate.edit_modal.on('shown.bs.modal', ProductEditTemplate.showModalAction);

  </script>
@endpush
