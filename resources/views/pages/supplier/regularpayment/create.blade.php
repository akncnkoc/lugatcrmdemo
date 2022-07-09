<x-modal.modal id="create_modal" size="modal-fullscreen">
  <x-slot name="title">Düzenli Ödeme Ekle</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-2">
        <x-form.input name="name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')" required/>
        <x-form.textarea name="comment" :label="__('globals/words.comment')"/>
      </div>
      <x-form.repeater id="regular_payment_period" button-text="Ödeme Düzeni Ekle">
        <x-slot:body>
          <div class="row row-cols-5 d-flex align-items-center">
            <x-form.input name="date" label="Ödenecek Tarih" placeholder="Ödenecek Tarih" date/>
            <x-form.normal-select name="safe_id" label="Kasa" required/>
            <x-form.input name="price" label="Tutar" placeholder="Tutar" required money/>
            <x-form.checkbox label="Ödeme Tamamlandı mı ?" name="completed" hint="Eğer açık olarak kaydedilirse
            seçilmiş olan kasadan girilin tutar kadar düşülecektir"/>
            <a href="javascript:" data-repeater-delete class="btn btn-light-danger">
              <i class="la la-trash-o"></i>
              Düzenli Ödemeyi Sil
            </a>
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
    const SupplierRegularPaymentCreateTemplate = function (){
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
      let price_validator = {
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
      let safe_validator = {
        validators: {
          notEmpty: {
            message: "Kasa seçilmesi zorunludur"
          }
        }
      };
      let date_validator = {
        validators: {
          date: {
            format: 'DD-MM-YYYY',
            message: '@lang('globals/validation_messages.correct_format', ['field_name' => __('globals/words.date'),'format' => '01-01-1990'])',
          },
          notEmpty: {
            message: '@lang('globals/validation_messages.required', ['field_name'  => __('globals/words.date')])',
          },
        }
      }
      let createRowIndex = 0;
      let validations ={
        name: {
          validators: {
            notEmpty: {
              message: "@lang('globals/validation_messages.required', ['field_name' => __('globals/words.name')])"
            },
            stringLength: {
              min: 3,
              max: 50,
              trim: true,
              message: "Ad kısmı en az 3 en fazla 50 karakterden oluşabilir"
            }
          },
        }
      };
      let create_modal = $("#create_modal");
      const formValidated =  (form) => {
        let data = $(form).serializeArray();
        $.ajax({
          url: "{{ route('supplier-regular-payment.store', ['supplier_id' => $supplier->id]) }}",
          type: "POST",
          data: data,
          success: function (data) {
            create_modal.modal("hide");
            SupplierRegularPaymentIndexTemplate.initData();
            toastr.success("@lang('globals/success_messages.success', ['attr' => 'Düzenli Ödeme'])");
            reloadFormRepeater()
          },
          error: function (err) {
            toastr.error("@lang('globals/error_messages.save_error', ['attr' => 'Düzenli Ödeme'])");
          },
        });
      };
      const afterFormLoaded = (form, validator) => {
        create_modal.on('change', '.money_input', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        });
        create_modal.on('change', '.safe_id_select', function (e) {
          let name = $(e.target).attr('name');
          validator.revalidateField(name);
        });
      };
      const showModalAction = (e) => {
        $('#regular_payment_period').repeater({
          initEmpty: false,
          isFirstItemUndeletable: true,
          show: function () {
            createRowIndex++;
            $(this).show();
            $("select.safe_id_select").select2(safe_select_options);
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
            $(this).find('input[type="checkbox"]').prop('checked', false);
            $(this).find('.flatpickr-input').remove();
            $(this).find('.datetime-picker').flatpickr();
            $(this).find('.flatpickr-input').attr('name', 'regular_payment_period[' + createRowIndex + '][date]');

            validator.addField('regular_payment_period[' + createRowIndex + '][date]', date_validator);
            validator.addField('regular_payment_period[' + createRowIndex + '][price]', price_validator);
            validator.addField('regular_payment_period[' + createRowIndex + '][safe_id]', safe_validator);
          },
          hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
            validator.removeField('regular_payment_period[' + createRowIndex + '][date]');
            validator.removeField('regular_payment_period[' + createRowIndex + '][price]');
            validator.removeField('regular_payment_period[' + createRowIndex + '][safe_id]');
            createRowIndex--;
          },
          ready: function () {
            $('select.safe_id_select').select2(safe_select_options);
          }
        });
        validator.addField('regular_payment_period[0][date]', date_validator);
        validator.addField('regular_payment_period[0][price]', price_validator);
        validator.addField('regular_payment_period[0][safe_id]', safe_validator);
      };
      let {validator} = validateBasicForm("create_form",validations,formValidated, null, afterFormLoaded);

      const reloadFormRepeater = () => {
        $("#regular_payment_period").find('[data-repeater-item]:not(:first-child)').each((index, item) => {
          $(item).remove();
        })
        $("#regular_payment_period").find('[data-repeater-item]:first-child .datetime-picker').val("")
        $("#regular_payment_period").find('[data-repeater-item]:first-child .safe_id_select').select2(safe_select_options).val(null).trigger('change');
        $("#regular_payment_period").find('[data-repeater-item]:first-child .money_input').maskMoney('mask', 0)
        createRowIndex = 0;
      }

      return {create_modal, showModalAction};
    }();
    SupplierRegularPaymentCreateTemplate.create_modal.on('shown.bs.modal', SupplierRegularPaymentCreateTemplate.showModalAction);

  </script>
@endpush
