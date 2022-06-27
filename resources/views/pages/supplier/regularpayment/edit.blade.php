<x-modal.modal id="edit_modal" size="modal-fullscreen">
  <x-slot name="title">Düzenli Ödeme Şeklini Düzenle</x-slot>
  <x-slot name="body">
    <div class="edit_template" style="display: none">
      <div class="row row-cols-5 d-flex align-items-center" data-repeater-item>
        <x-form.input name="date" label="Ödenecek Tarih" placeholder="Ödenecek Tarih" date/>
        <x-form.normal-select name="safe_id" label="Kasa" required editing/>
        <x-form.input name="price" label="Tutar" placeholder="Tutar" required money/>
        <x-form.checkbox label="Ödeme Tamamlandı mı ?" name="completed" hint="Eğer açık olarak kaydedilirse
            seçilmiş olan kasadan girilin tutar kadar düşülecektir"/>
        <a href="javascript:" data-repeater-delete class="btn btn-light-danger">
          <i class="la la-trash-o"></i>
          Düzenli Ödemeyi Sil
        </a>
      </div>
    </div>
    <div class="edit_template" id="create_template" style="display:none!important;">
      <div class="row row-cols-5 d-flex align-items-center">
        <x-form.input name="date" label="Ödenecek Tarih" placeholder="Ödenecek Tarih" date/>
        <x-form.normal-select name="safe_id" label="Kasa" required editing/>
        <x-form.input name="price" label="Tutar" placeholder="Tutar" required money/>
        <x-form.checkbox label="Ödeme Tamamlandı mı ?" name="completed" hint="Eğer açık olarak kaydedilirse
            seçilmiş olan kasadan girilin tutar kadar düşülecektir"/>
        <a href="javascript:" data-repeater-delete class="btn btn-light-danger">
          <i class="la la-trash-o"></i>
          Düzenli Ödemeyi Sil
        </a>
      </div>
    </div>
    <x-form.form id="edit_form">
      <div class="row row-cols-2">
        <x-form.input name="name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')" required/>
        <x-form.textarea name="comment" :label="__('globals/words.comment')"/>
      </div>
      <x-form.repeater id="regular_payment_period_edit" button-text="Ödeme Düzeni Ekle">
        <x-slot:items>
          <div class="edit_template_content">

          </div>
        </x-slot:items>
      </x-form.repeater>
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

    let safe_edit_select_options = {
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
    let price_edit_validator = {
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
    let safe_edit_validator = {
      validators: {
        notEmpty: {
          message: '@lang('globals/validation_messages.required', ['field_name'  => __('layout/aside/menu.safe')])',
        },
      }
    };
    let date_edit_validator = {
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

    var {
      form: editForm,
      validator: editValidator
    } = validateBasicForm("edit_form", {
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
    }, (form, submitButton) => {
      let data = $(form).serializeArray();
      console.log(data);
      data.push({
        name: 'id',
        value: id
      });
      $.ajax({
        url: "{{ route('supplier-regular-payment.update') }}",
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
      // invalidated
    }, (form, validator) => {
      $(form).on('change', '.money_input', function (e) {
        let name = $(e.target).attr('name');
        validator.revalidateField(name);
      });
      $(form).on('change', '.safe_id_edit_select', function (e) {
        let name = $(e.target).attr('name');
        validator.revalidateField(name);
      });
    });
    $("#edit_modal").on('hidden.bs.modal', function (e) {
      for (let i = 0; i < editRowIndex; i++) {
        editValidator.removeField('regular_payment_period_edit[' + (i + 1) + '][date]');
        editValidator.removeField('regular_payment_period_edit[' + (i + 1) + '][price]');
        editValidator.removeField('regular_payment_period_edit[' + (i + 1) + '][safe_id]');
      }
      editRowIndex = 0;
    });
    $("#edit_modal").on('shown.bs.modal', function (e) {
      $(".edit_template_content").contents().filter(function () {
        return !$(this).is('#create_template');
      }).remove();
      id = $(e.target).data('editId');
      $.ajax({
        url: "{{ route('supplier-regular-payment.get') }}",
        data: {
          id
        },
        type: "POST",
        beforeSend: () => {
          blockUI.block();
        },
        success: function (data) {
          editRowIndex = 0;
          $(editForm).find('input[name="name"]').val(data.name);
          $(editForm).find('input[name="comment"]').val(data.comment);
          let edit_repeater = document.getElementsByClassName("edit_template")[0];
          let edit_template_content = document.getElementsByClassName("edit_template_content")[0];
          if (data.periods && data.periods.length > 0) {
            editRowIndex = data.periods.length;
            edit_template_content.innerHTML = "";
            let create_template_clone = document.getElementById("create_template").cloneNode(true);
            create_template_clone.style.display = 'block';
            $(create_template_clone).find('.flatpickr-input').remove();
            $(create_template_clone).find('.datetime-picker').attr('name', 'regular_payment_period_edit[' + (editRowIndex) + '][date]');
            $(create_template_clone).find('input[name="price"]').attr('name', 'regular_payment_period_edit[' + (editRowIndex) + '][price]');
            $(create_template_clone).find('input[name="completed"]').attr('name', 'regular_payment_period_edit[' + (editRowIndex) + '][completed]');
            $(create_template_clone).find('select[name="safe_id"]').attr('name', 'regular_payment_period_edit[' + (editRowIndex) + '][safe_id]');

            data.periods.map((item, index) => {
              const clone = edit_repeater.cloneNode(true);
              clone.style.display = 'block';
              edit_template_content.prepend(clone);
              let safe_id_select_option = new Option(item.safe.name, item.safe.id, false, true);
              $(clone).find('.flatpickr-input').remove();
              $(clone).find('.datetime-picker').attr('name', 'regular_payment_period_edit[' + (index) + '][date]').val(moment(item.date).format('DD-MM-YYYY'));
              $(clone).find('input[name="price"]').attr('name', 'regular_payment_period_edit[' + (index) + '][price]').val(item.price);
              $(clone).find('input[name="completed"]').attr('name', 'regular_payment_period_edit[' + (index) + '][completed]').prop("checked", item.completed);
              $(clone)
                .find('select[name="safe_id"]')
                .attr('name', 'regular_payment_period_edit[' + (index) + '][safe_id]')
                .html(safe_id_select_option)

              editValidator.addField('regular_payment_period_edit[' + (index) + '][date]', date_edit_validator);
              editValidator.addField('regular_payment_period_edit[' + (index) + '][price]', price_edit_validator);
              editValidator.addField('regular_payment_period_edit[' + (index) + '][safe_id]', safe_edit_validator);
            });
            edit_template_content.append(create_template_clone);
            editValidator.addField('regular_payment_period_edit[' + (editRowIndex) + '][date]', date_edit_validator);
            editValidator.addField('regular_payment_period_edit[' + (editRowIndex) + '][price]', price_edit_validator);
            editValidator.addField('regular_payment_period_edit[' + (editRowIndex) + '][safe_id]', safe_edit_validator);
            $('#regular_payment_period_edit').repeater({
              initEmpty: false,
              isFirstItemUndeletable: true,
              show: function () {
                editRowIndex++;
                $(this).show();
                console.log($(this).find('.safe_id_edit_select'));
                $(this).find('.safe_id_edit_select').attr('name', 'regular_payment_period_edit[' + editRowIndex +
                  '][safe_id]').select2(safe_edit_select_options);
                $(this).find('.flatpickr-input').remove();
                $(this).find('#completed_checkbox').prop("checked", false);
                $(this).find('.datetime-picker').each(function (index, item) {
                  $(item).flatpickr();
                  $(item).attr('name', 'regular_payment_period_edit[' + editRowIndex + '][date]');
                })
                $(this).find(".money_input").each(function (index, item) {
                  $(item).maskMoney({
                    thousands: ".",
                    decimal: ",",
                    allowZero: true,
                    affixesStay: false,
                    allowNegative: false
                  });
                  $(item).maskMoney("mask");
                  $(item).attr('name', 'regular_payment_period_edit[' + editRowIndex + '][price]');
                });
                editValidator.addField('regular_payment_period_edit[' + editRowIndex + '][date]', date_validator);
                editValidator.addField('regular_payment_period_edit[' + editRowIndex + '][price]', price_validator);
                editValidator.addField('regular_payment_period_edit[' + editRowIndex + '][safe_id]', safe_validator);
              },
              hide: function (deleteElement) {
                $(document.querySelectorAll(".edit_template:last-child")).slideUp();
                editValidator.removeField('regular_payment_period_edit[' + editRowIndex + '][date]');
                editValidator.removeField('regular_payment_period_edit[' + editRowIndex + '][price]');
                editValidator.removeField('regular_payment_period_edit[' + editRowIndex + '][safe_id]');
                editRowIndex--;
              },
              ready: function () {
                $(edit_template_content).find('.safe_id_edit_select').each(function (index, item) {
                  $(item).select2(safe_edit_select_options);
                });
                $(edit_template_content).find('.flatpickr-input').remove();
                $(edit_template_content).find('.datetime-picker').each(function (index, item) {
                  $(item).flatpickr();
                })
                $(edit_template_content).find(".money_input").each(function (index, item) {
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
