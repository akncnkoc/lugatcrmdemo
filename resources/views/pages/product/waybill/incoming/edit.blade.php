<x-modal.modal id="edit_modal" size="modal-fullscreen">
  <x-slot name="title">@lang('pages/waybill.incoming_waybill_edit')</x-slot>
  <x-slot name="body">
    <div class="edit_template" style="display: none">
      <div class="row row-cols-1">
        <input type="hidden" name="product_code"/>
        <div style="width: 30%">
          <div class="row">
            <div class="col-md-12">
              <x-form.normal-select name="product_id" :label="__('globals/words.product')" required editing/>
            </div>
          </div>
        </div>
        <div style="width: 70%">
          <div class="row row-cols-4 align-items-center">
            <x-form.input name="buy_price" :label="__('globals/words.buy_price')" :placeholder="__('globals/words.buy_price')" required money/>
            <x-form.normal-select name="buy_price_safe_id" :label="__('globals/words.safe')" required editing/>
            <x-form.input name="sale_price" :label="__('globals/words.sale_price')" :placeholder="__('globals/words.sale_price')" required money/>
            <x-form.normal-select name="sale_price_safe_id" :label="__('globals/words.safe')" required editing/>
          </div>
        </div>
      </div>
    </div>
    <x-form.form id="edit_form">
      <div class="row row-cols-2">
        <x-form.input name="date" :label="__('globals/words.date')" :placeholder="__('globals/words.date')" required date editing/>
        <x-form.select name="supplier_id" :label="__('globals/words.supplier')" :placeholder="__('globals/words.supplier')"
                       :asyncload="route('supplier.select')"
                       parent="#edit_modal" required editing/>
      </div>
      <div class="edit_template_content"></div>
      <div class="row row-cols-1">
        <x-form.button>@lang('globals/words.save')</x-form.button>
      </div>
    </x-form.form>
  </x-slot>
</x-modal.modal>

@push('customscripts')
  <script>
    const IncomingWaybillEditTemplate = function () {
      let id;
      let modal_target = document.querySelector("#edit_modal_target");
      let block_ui_modal_target = new KTBlockUI(modal_target);
      let edit_modal = $("#edit_modal");
      let edit_template_content = $(".edit_template_content");
      let editRowIndex = 0;
      let product_select2_edit_options = {
        placeholder: "Ürün Ara",
        dropdownParent: $("#edit_modal"),
        ajax: {
          url: "{{route('product.select')}}",
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
      let safe_select_edit_options = {
        placeholder: "Kasa Ara",
        dropdownParent: $("#edit_modal"),
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
      let product_id_edit_validator = {
        validators: {
          notEmpty: {
            message: "Ürün seçilmesi zorunludur"
          }
        }
      };
      let buy_price_edit_validator = {
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
      let sale_price_edit_validator = {
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
      let buy_price_safe_id_edit_validator = {
        validators: {
          notEmpty: {
            message: "Kasa seçilmesi zorunludur"
          }
        }
      };
      let sale_price_safe_id_edit_validator = {
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
      const formValidated = (form, submitButton) => {
        let data = $(form).serializeArray();
        data.push({name: 'id', value: id});
        $.ajax({
          url: "{{ route('incoming-waybill.update') }}",
          type: "POST",
          data: data,
          success: function (data) {
            edit_modal.modal("hide");
            IncomingWaybillIndexTemplate.initData();
            submitButton.disabled = false;
            toastr.success("Başarılı!");
          },
          error: function (err) {
            submitButton.disabled = false;
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      };
      const formAfterLoaded = (form, validator) => {
        $(form).on('change', '.money_input', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        });
        $(form).on('change', '.supplier_id_edit_select', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        });

        $(form).on('change', '.buy_price_safe_id_edit_select', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        });
        $(form).on('change', '.sale_price_safe_id_edit_select', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        })
        $(form).on('change', '.product_id_edit_select', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        })
      };
      const modalHideAction = () => {
        for (let i = 0; i < editRowIndex; i++) {
          validator.removeField('waybill_product_edit[' + (i + 1) + '][product_id]');
          validator.removeField('waybill_product_edit[' + (i + 1) + '][buy_price]');
          validator.removeField('waybill_product_edit[' + (i + 1) + '][sale_price]');
          validator.removeField('waybill_product_edit[' + (i + 1) + '][buy_price_safe_id]');
          validator.removeField('waybill_product_edit[' + (i + 1) + '][sale_price_safe_id]');
        }
        editRowIndex = 0;
      };
      const modalShowAction = (e) => {
        edit_template_content.empty();
        id = $(e.target).data('itemId');
        $.ajax({
          url: "{{ route('incoming-waybill.get') }}",
          data: {id},
          type: "POST",
          beforeSend: () => {
            block_ui_modal_target.block();
          },
          success: function (data) {
            let name_selector = 'input[name="name"]',
              date_selector = 'input[name="date"]',
              supplier_selector = 'select[name="supplier_id"]';
            let edit_repeater = document.getElementsByClassName("edit_template")[0];
            let edit_template_content = document.getElementsByClassName("edit_template_content")[0];
            $(form).find(name_selector).val(data.name);
            $(form).find(date_selector).val(data.waybill_date).flatpickr();
            let supplier_edit_option = new Option(data.supplier.name, data.supplier.id, false, true);
            $(form).find(supplier_selector).html(supplier_edit_option);
            //Waybill products initialize
            if (data.products && data.products.length > 0) {
              editRowIndex = data.products.length;
              data.products.map((item, index) => {
                let quantity_selector = 'input[name="quantity"]';
                const clone = edit_repeater.cloneNode(true);
                clone.style.display = 'block';
                $(clone).find(quantity_selector).parent().remove();
                edit_template_content.prepend(clone);
                let product_id_select_option = new Option(item.product.name, item.product.id, true, true);
                let buy_price_safe_id_select_option = new Option(item.buy_price_safe.name, item.buy_price_safe.id, false, true);
                let sale_price_safe_id_select_option = new Option(item.sale_price_safe.name, item.sale_price_safe.id, false, true);
                $(clone).find('input[name="product_code"]').attr('name', 'waybill_product_edit[' + (index + 1) + '][product_code]').val(item.product_code);

                let product_label_text = "";
                if (item.rebate) product_label_text = `<span class="badge badge-warning">Ürün iade edilmiş</span>`;
                else if (item.sold) product_label_text = `<span class="badge badge-info">Ürün satılmış</span>`;
                else product_label_text = `<span class="badge badge-success">Ürün satışa hazır</span>`
                $(clone)
                  .find('select[name="product_id"]')
                  .prev('label')
                  .html(product_label_text);

                $(clone)
                  .find('select[name="product_id"]')
                  .attr('disabled', true)
                  .attr('name', 'waybill_product_edit[' + (index + 1) + '][product_id]')
                  .html(product_id_select_option)
                $(clone).find('input[name="buy_price"]').attr('name', 'waybill_product_edit[' + (index + 1) + '][buy_price]').val(item.buy_price);
                $(clone).find('input[name="sale_price"]').attr('name', 'waybill_product_edit[' + (index + 1) + '][sale_price]').val(item.sale_price);
                $(clone)
                  .find('select[name="buy_price_safe_id"]')
                  .attr('name', 'waybill_product_edit[' + (index + 1) + '][buy_price_safe_id]')
                  .html(buy_price_safe_id_select_option)
                $(clone)
                  .find('select[name="sale_price_safe_id"]')
                  .attr('name', 'waybill_product_edit[' + (index + 1) + '][sale_price_safe_id]')
                  .html(sale_price_safe_id_select_option)

                validator.addField('waybill_product_edit[' + (index + 1) + '][product_id]', product_id_edit_validator);
                validator.addField('waybill_product_edit[' + (index + 1) + '][buy_price]', buy_price_edit_validator);
                validator.addField('waybill_product_edit[' + (index + 1) + '][sale_price]', sale_price_edit_validator);
                validator.addField('waybill_product_edit[' + (index + 1) + '][buy_price_safe_id]', buy_price_safe_id_edit_validator);
                validator.addField('waybill_product_edit[' + (index + 1) + '][sale_price_safe_id]', sale_price_safe_id_edit_validator);
              });

              $(edit_template_content).find('.buy_price_safe_id_edit_select').select2(safe_select_edit_options);
              $(edit_template_content).find('.sale_price_safe_id_edit_select').select2(safe_select_edit_options);
              $(".money_input").each(function (index, item) {
                $(item).maskMoney({
                  thousands: ".",
                  decimal: ",",
                  allowZero: true,
                  affixesStay: false,
                  allowNegative: false
                });
                $(item).maskMoney("mask");
              });

            }
            block_ui_modal_target.release();
          },
          error: function () {
            toastr.error("Yüklemede bir sorun oluştu, tekrar deneyin");
            block_ui_modal_target.release()
          }
        });
      }
      const {form, validator} = validateBasicForm("edit_form", validations, formValidated, null, formAfterLoaded);
      return {edit_modal, modalHideAction, modalShowAction};
    }();
    IncomingWaybillEditTemplate.edit_modal.on('hidden.bs.modal', IncomingWaybillEditTemplate.modalHideAction);
    IncomingWaybillEditTemplate.edit_modal.on('shown.bs.modal', IncomingWaybillEditTemplate.modalShowAction);
  </script>
@endpush
