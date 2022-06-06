<x-modal.modal id="edit_modal">
  <x-slot name="title">Gider Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="edit_form">
      <div class="row row-cols-2">
        <x-form.select label="Gider Türü" name="expense_type_id" :asyncload="route('expense_type.select')" required
                       editing
                       parent="#edit_modal"/>
        <x-form.input name="date" label="Tarih" placeholder="Tarih" required :date="true"/>
      </div>
      <div class="row row-cols-2">
        <x-form.input name="price" label="Fiyat" placeholder="Fiyat" money required/>
        <x-form.select label="Kasa" name="safe_id" :asyncload="route('safe.select')" required parent="#edit_modal"
                       editing />
      </div>

      <x-form.textarea name="comment" label="Açıklama"/>
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
        url: "{{ route('expense.get') }}",
        data: {
          id
        },
        type: "POST",
        beforeSend: () => {
          blockUI.block();
        },
        success: function (data) {
          $(editForm).find('input[name="price"]').val(data.price).maskMoney("mask")
          $(editForm).find('input[name="date"]').val(data.date).flatpickr();
          let expense_type_option = new Option(data.expense_type.name, data.expense_type.id, false, true);
          $(editForm).find('select[name="expense_type_id"]').html(expense_type_option);
          let safe_option = new Option(data.safe.name, data.safe.id, false, true);
          $(editForm).find('select[name="safe_id"]').html(safe_option);
          $(editForm).find('textarea[name="comment"]').val(data.comment);
          blockUI.release();
        },
        error: {}
      });
    });
    let {
      form: editForm,
      validator: editValidator
    } = validateForm("edit_form", {
      price: {
        validators: {
          numeric: {
            thousandsSeparator: ".",
            message: "Fiyat gereklidir",
            decimalSeparator: ",",
          },
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
      data.push({
        name: "id",
        value: id
      });
      $.ajax({
        url: "{{ route('expense.update') }}",
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
      $(form).find('.safe_id_edit_select').on('change', function () {
        validator.revalidateField('safe_id');
      });
      $(form).find('.expense_type_id_edit_select').on('change', function () {
        validator.revalidateField('expense_type_id');
      });
    });
  </script>
@endpush
