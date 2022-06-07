<x-modal.modal id="create_modal" size="modal-fullscreen">
  <x-slot name="title">Gelen İrsaliye Ekle</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-2">
        <x-form.input name="date" label="İrsaliye Tarihi" placeholder="İrsaliye Tarihi" required date/>
        <x-form.select name="supplier_id" label="Tedarikçi" placeholder="Tedarikçi" :asyncload="route('supplier.select')"
                       parent="#create_modal" required/>
      </div>
      <x-form.repeater id="waybill_product" button-text="Ürün Ekle">
        <x-slot:body>
          <div class="row row-cols-2">
            <div style="width: 30%">
              <div class="row">
                <div class="col-md-8">
                  <x-form.normal-select name="product_id" label="Ürün" required/>
                </div>
                <div class="col-md-4">
                  <x-form.input name="quantity" label="Miktar" placeholder="Miktar" value="1" required/>
                </div>
              </div>
            </div>
            <div style="width: 70%">
              <div class="row row-cols-5 align-items-center">
                <x-form.input name="buy_price" label="Alış Fiyatı" placeholder="Alış Fiyatı" required money/>
                <x-form.normal-select name="buy_price_safe_id" label="Kasa" required/>
                <x-form.input name="sale_price" label="Satış Fiyatı" placeholder="Satış Fiyatı" required money/>
                <x-form.normal-select name="sale_price_safe_id" label="Kasa" required/>
                <a href="javascript:;" data-repeater-delete class="btn btn-light-danger">
                  <i class="la la-trash-o"></i>
                  Ürün Sil
                </a>
              </div>
            </div>
          </div>
        </x-slot:body>
      </x-form.repeater>
      <div class="row row-cols-1">
        <x-form.button>Kaydet</x-form.button>
      </div>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>

    let product_select2_options = {
      placeholder: "Ürün Ara",
      dropdownParent: $("#create_modal"),
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

    let createRowIndex = 0;
    let {
      form: createForm,
      validator: createValidator
    } = validateForm("create_form", {
      'supplier_id': {
        validators:{
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
    }, (form) => {
      let data = $(form).serializeArray();
      $.ajax({
        url: "{{ route('incoming-waybill.store') }}",
        type: "POST",
        data: data,
        success: function (data) {
          $("#create_modal").modal("hide");
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
      $('#create_modal').on('change', '.money_input', function (e){
        let name = $(e.target).attr('name');
        validator.revalidateField(name);
      });
      $('body').on('change', '.supplier_id_select', function (e){
        let name = $(e.target).attr('name');
        validator.revalidateField(name);
      });

      $('body').on('change', '.buy_price_safe_id_select', function (e){
        let name = $(e.target).attr('name');
        validator.revalidateField(name);
      });
      $('body').on('change', '.sale_price_safe_id_select', function (e){
        let name = $(e.target).attr('name');
        validator.revalidateField(name);
      })
      $('body').on('change', '.product_id_select', function (e){
        let name = $(e.target).attr('name');
        validator.revalidateField(name);
      })
    });
    $('#waybill_product').repeater({
      initEmpty: false,
      isFirstItemUndeletable: true,
      show: function () {
        $(this).show();
        $("select.product_id_select").select2(product_select2_options);
        $("select.buy_price_safe_id_select").select2(safe_select_options);
        $("select.sale_price_safe_id_select").select2(safe_select_options);
        $(".money_input").each(function (index, item) {
          $(item).maskMoney({thousands: ".", decimal: ",", allowZero: true, affixesStay: false, allowNegative: false});
          $(item).maskMoney("mask");
        });
      },
      hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
      },
      ready: function () {
        $('select.product_id_select').select2(product_select2_options);
        $('select.buy_price_safe_id_select').select2(safe_select_options);
        $('select.sale_price_safe_id_select').select2(safe_select_options);
      }
    });
    createValidator.addField('waybill_product[0][product_id]', product_id_validator);
    createValidator.addField('waybill_product[0][quantity]', product_id_validator);
    createValidator.addField('waybill_product[0][buy_price]', buy_price_validator);
    createValidator.addField('waybill_product[0][sale_price]', sale_price_validator);
    createValidator.addField('waybill_product[0][buy_price_safe_id]', buy_price_safe_id_validator);
    createValidator.addField('waybill_product[0][sale_price_safe_id]', sale_price_safe_id_validator);
    $("[data-repeater-create]").click(function () {
      createRowIndex++;
      createValidator.addField('waybill_product[' + createRowIndex + '][product_id]', product_id_validator);
      createValidator.addField('waybill_product[' + createRowIndex + '][quantity]', buy_price_validator);
      createValidator.addField('waybill_product[' + createRowIndex + '][buy_price]', buy_price_validator);
      createValidator.addField('waybill_product[' + createRowIndex + '][sale_price]', sale_price_validator);
      createValidator.addField('waybill_product[' + createRowIndex + '][buy_price_safe_id]', buy_price_safe_id_validator);
      createValidator.addField('waybill_product[' + createRowIndex + '][sale_price_safe_id]', sale_price_safe_id_validator);
    })

  </script>
@endpush
