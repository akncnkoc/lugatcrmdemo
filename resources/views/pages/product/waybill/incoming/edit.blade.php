<x-modal.modal id="edit_modal" size="modal-fullscreen">
  <x-slot name="title">Gelen İrsaliye Düzenle</x-slot>
  <x-slot name="body">
    <div class="edit_template" style="display: none">
      <div class="row row-cols-1">
        <input type="hidden" name="product_code"/>
        <div style="width: 30%">
          <div class="row">
            <div class="col-md-12">
              <x-form.normal-select name="product_id" label="Ürün" required editing/>
            </div>
          </div>
        </div>
        <div style="width: 70%">
          <div class="row row-cols-4 align-items-center">
            <x-form.input name="buy_price" label="Alış Fiyatı" placeholder="Alış Fiyatı" required money/>
            <x-form.normal-select name="buy_price_safe_id" label="Kasa" required editing/>
            <x-form.input name="sale_price" label="Satış Fiyatı" placeholder="Satış Fiyatı" required money/>
            <x-form.normal-select name="sale_price_safe_id" label="Kasa" required editing/>
          </div>
        </div>
      </div>
    </div>
    <x-form.form id="edit_form">
      <div class="row row-cols-2">
        <x-form.input name="date" label="İrsaliye Tarihi" placeholder="İrsaliye Tarihi" required date editing/>
        <x-form.select name="supplier_id" label="Tedarikçi" placeholder="Tedarikçi"
                       :asyncload="route('supplier.select')"
                       parent="#edit_modal" required editing/>
      </div>
      <div class="edit_template_content"></div>
      <div class="row row-cols-1">
        <x-form.button>Kaydet</x-form.button>
      </div>
    </x-form.form>
  </x-slot>
</x-modal.modal>

@push('customscripts')
  <script>
    var id;
    var blockUI = new KTBlockUI(document.querySelector("#edit_modal_target"));
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


    var {
      form: editForm,
      validator: editValidator
    } = validateBasicForm("edit_form", {
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
    }, (form, submitButton) => {
      let data = $(form).serializeArray();
      data.push({
        name: 'id',
        value: id
      });
      $.ajax({
        url: "{{ route('incoming-waybill.update') }}",
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
    });
    editValidator.on('core.field.added', function (event) {
    })
    $("#edit_modal").on('hidden.bs.modal', function (e) {
      for (let i = 0; i < editRowIndex; i++) {
        editValidator.removeField('waybill_product_edit[' + (i + 1) + '][product_id]');
        editValidator.removeField('waybill_product_edit[' + (i + 1) + '][buy_price]');
        editValidator.removeField('waybill_product_edit[' + (i + 1) + '][sale_price]');
        editValidator.removeField('waybill_product_edit[' + (i + 1) + '][buy_price_safe_id]');
        editValidator.removeField('waybill_product_edit[' + (i + 1) + '][sale_price_safe_id]');
      }
      editRowIndex = 0;
    });
    $("#edit_modal").on('shown.bs.modal', function (e) {
      $(".edit_template_content").empty();
      id = $(e.target).data('editId');
      $.ajax({
        url: "{{ route('incoming-waybill.get') }}",
        data: {
          id
        },
        type: "POST",
        beforeSend: () => {
          blockUI.block();
        },
        success: function (data) {
          $(editForm).find('input[name="name"]').val(data.name);
          $(editForm).find('input[name="date"]').val(data.waybill_date).flatpickr();
          let supplier_edit_option = new Option(data.supplier.name, data.supplier.id, false, true);
          $(editForm).find('select[name="supplier_id"]').html(supplier_edit_option);
          if (data.products && data.products.length > 0) {
            editRowIndex = data.products.length;
            let edit_repeater = document.getElementsByClassName("edit_template")[0];
            let edit_template_content = document.getElementsByClassName("edit_template_content")[0];
            data.products.map((item, index) => {
              const clone = edit_repeater.cloneNode(true);
              clone.style.display = 'block';
              $(clone).find('input[name="quantity"]').parent().remove();
              edit_template_content.prepend(clone);
              let product_id_select_option = new Option(item.product.name, item.product.id, true, true);
              let buy_price_safe_id_select_option = new Option(item.buy_price_safe.name, item.buy_price_safe.id, false, true);
              let sale_price_safe_id_select_option = new Option(item.sale_price_safe.name, item.sale_price_safe.id, false, true);
              $(clone).find('input[name="product_code"]').attr('name', 'waybill_product_edit[' + (index + 1) + '][product_code]').val(item.product_code);

              let product_label_text = "";
              if (item.rebate) product_label_text = "Ürün iade edilmiş";
              else if (item.sold) product_label_text = "Ürün satılmış";
              else product_label_text = "Ürün hazır"
              $(clone)
                .find('select[name="product_id"]')
                .prev('label')
                .text(product_label_text);

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

              editValidator.addField('waybill_product_edit[' + (index + 1) + '][product_id]', product_id_edit_validator);
              editValidator.addField('waybill_product_edit[' + (index + 1) + '][buy_price]', buy_price_edit_validator);
              editValidator.addField('waybill_product_edit[' + (index + 1) + '][sale_price]', sale_price_edit_validator);
              editValidator.addField('waybill_product_edit[' + (index + 1) + '][buy_price_safe_id]', buy_price_safe_id_edit_validator);
              editValidator.addField('waybill_product_edit[' + (index + 1) + '][sale_price_safe_id]', sale_price_safe_id_edit_validator);
            });

            $(edit_template_content).find('.product_id_edit_select').select2(product_select2_edit_options);
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
          blockUI.release();
        },
        error: function () {
          toastr.error("Yüklemede bir sorun oluştu, tekrar deneyin");
          blockUI.release()
        }
      });
    });
  </script>
@endpush
