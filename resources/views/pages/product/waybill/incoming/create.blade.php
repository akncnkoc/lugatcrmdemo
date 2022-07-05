<x-modal.modal id="create_modal" size="modal-fullscreen">
  <x-slot name="title">@lang('pages/waybill.incoming_waybill_add')</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-2">
        <x-form.input name="date" :label="__('globals/words.date')" :placeholder="__('globals/words.date')" required date/>
        <x-form.select name="supplier_id" :label="__('globals/words.supplier')" :placeholder="__('globals/words.supplier')"
                       :asyncload="route('supplier.select')"
                       parent="#create_modal" required/>
      </div>
      <x-form.repeater id="waybill_product" :button-text="__('globals/words.add')">
        <x-slot:body>
          <div class="row row-cols-2">
            <div style="width: 30%">
              <div class="row">
                <div class="col-md-8">
                  <x-form.normal-select name="product_id" :label="__('globals/words.product')" required/>
                </div>
                <div class="col-md-4">
                  <x-form.input name="quantity" :label="__('globals/words.amount')" :placeholder="__('globals/words.amount')" value="1" required/>
                </div>
              </div>
            </div>
            <div style="width: 70%">
              <div class="row row-cols-5 align-items-center">
                <x-form.input name="buy_price" :label="__('globals/words.buy_price')" :placeholder="__('globals/words.buy_price')" required money/>
                <x-form.normal-select name="buy_price_safe_id" :label="__('globals/words.safe')" required/>
                <x-form.input name="sale_price" :label="__('globals/words.sale_price')" :placeholder="__('globals/words.sale_price')" required money/>
                <x-form.normal-select name="sale_price_safe_id" :label="__('globals/words.safe')" required/>
                <x-tooltip-button data-repeater-delete type="button">
                  @include('components.icons.delete')
                  @lang('globals/words.delete')
                </x-tooltip-button>
              </div>
            </div>
          </div>
        </x-slot:body>
      </x-form.repeater>
      <div class="d-flex justify-content-end">
        <x-form.button>
          @include('components.icons.create')
          @lang('globals/words.save')
        </x-form.button>
      </div>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    const IncomingWaybillCreateTemplate = function () {
      let waybill_product_repeater = $("#waybill_product");
      let create_modal = $('#create_modal');
      let product_id_selector = "select.product_id_select";
      let buy_price_safe_selector = "select.buy_price_safe_id_select";
      let sale_price_safe_selector = "select.sale_price_safe_id_select";
      let money_input_selector = ".money_input";
      let product_select2_options = {
        placeholder: "Ürün Ara",
        dropdownParent: create_modal,
        ajax: {
          url: "{{route('product.select')}}",
          dataType: 'json',
          method: 'post',
          delay: 250,
          data: function (params) {
            return {
              search: params.term || null,
              page: params.page || 1,
              _token: "{{csrf_token()}}",
            };
          },
          processResults: function (data, params) {
            params.page = params.page || 1;
            return {
              results: data.results,
              pagination: {
                more: (params.page * 10) < data.total
              }
            };
          }
        },
        language: "tr",
        allowClear: true
      }
      let safe_select_options = {
        placeholder: "Kasa Ara",
        dropdownParent: $("#create_modal"),
        ajax: {
          url: "{{route('safe.select')}}",
          dataType: 'json',
          method: 'post',
          delay: 250,
          data: function (params) {
            var query = {
              search: params.term,
              page: params.page || 1,
              _token: "{{csrf_token()}}",
            }
            return query;
          },
          processResults: function (data, params) {
            params.page = params.page || 1;
            return {
              results: data.results,
              pagination: {
                more: (params.page * 10) < data.total
              }
            };
          }
        },
        language: "tr",
        allowClear: true
      }
      let product_id_validator = {
        validators: {
          notEmpty: {
            message: "Ürün seçilmesi zorunludur"
          }
        }
      };
      let buy_price_validator = {
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
      };
      let sale_price_validator = {
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
      };
      let buy_price_safe_id_validator = {
        validators: {
          notEmpty: {
            message: "Kasa seçilmesi zorunludur"
          }
        }
      };
      let sale_price_safe_id_validator = {
        validators: {
          notEmpty: {
            message: "Kasa seçilmesi zorunludur"
          }
        }
      };
      let validations = {
        'supplier_id': {
          validators: {
            notEmpty: {
              message: "Tedarikçi seçilmesi zorunludur."
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
      };
      let rowIndex = 0;
      const formValidated = (form) => {
        let data = $(form).serializeArray();
        $.ajax({
          url: "{{ route('incoming-waybill.store') }}",
          type: "POST",
          data: data,
          success: function (data) {
            create_modal.modal("hide");
            IncomingWaybillIndexTemplate.initData();
            toastr.success("@lang('globals/success_messages.success', ['attr' => __('pages/waybill.incoming_waybill')])");
          },
          error: function (err) {
            toastr.error("@lang('globals/error_messages.save_error', ['attr' => __('pages/waybill.incoming_waybill')])");
          }
        });
      };
      const afterFormLoaded = (form, validator) => {
        create_modal.on('change', '.money_input', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        });
        create_modal.on('change', '.supplier_id_select', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        });

        create_modal.on('change', '.buy_price_safe_id_select', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        });
        create_modal.on('change', '.sale_price_safe_id_select', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        })
        create_modal.on('change', '.product_id_select', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        })
      };
      const validatorFieldNames = {
        "product_id": product_id_validator,
        "buy_price": buy_price_validator,
        "sale_price": sale_price_validator,
        "buy_price_safe_id": buy_price_safe_id_validator,
        "sale_price_safe_id": sale_price_safe_id_validator
      };
      let {validator} = validateBasicForm("create_form", validations, formValidated, null, afterFormLoaded);
      const repeaterShowAction = function () {
        $(this).slideDown();
        $(this).find(product_id_selector).select2(product_select2_options);
        $(this).find(buy_price_safe_selector).select2(safe_select_options);
        $(this).find(sale_price_safe_selector).select2(safe_select_options);
        $(this).find(money_input_selector).each(function (index, item) {
          $(item).maskMoney({thousands: ".", decimal: ",", allowZero: true, affixesStay: false, allowNegative: false});
          $(item).maskMoney("mask", 0);
        });
        rowIndex++;
        Object.entries(validatorFieldNames).map((item) => addNewValidatorField("waybill_product[" + rowIndex + "][" + item[0] + "]", item[1]));
      }
      const  repeaterHideAction = function (deleteElement)  {
        $(this).slideUp(deleteElement);
        Object.entries(validatorFieldNames).map((item) => removeValidatorField("waybill_product[" + rowIndex + "][" + item[0] + "]"));
        rowIndex--;
      }
      const repeaterReadyAction = () => {
        $(product_id_selector).select2(product_select2_options);
        $(buy_price_safe_selector).select2(safe_select_options);
        $(sale_price_safe_selector).select2(safe_select_options);
        Object.entries(validatorFieldNames).map((item) => addNewValidatorField("waybill_product[" + rowIndex + "][" + item[0] + "]", item[1]));
      }
      let addNewValidatorField = (name, validatorFn) => validator.addField(name, validatorFn);
      let removeValidatorField = (name) => validator.removeField(name);
      const init = () => {
        waybill_product_repeater.repeater({
          initEmpty: false,
          isFirstItemUndeletable: true,
          show: repeaterShowAction,
          hide: repeaterHideAction,
          ready: repeaterReadyAction
        });
      }
      return {init};
    }();
    IncomingWaybillCreateTemplate.init();
  </script>
@endpush
