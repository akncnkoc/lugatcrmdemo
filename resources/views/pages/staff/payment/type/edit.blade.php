<x-modal.modal id="staff_payment_type_edit_modal">
  <x-slot name="title">Personel Ödeme Tipi Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="staff_payment_type_edit_form">
      <div class="row row-cols-1">
        <x-form.input name="name" label="Ad" placeholder="Ad" required/>
      </div>
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    var id;
    var blockUI = new KTBlockUI(document.querySelector("#staff_payment_type_edit_modal_target"));
    $("#staff_payment_type_edit_modal").on('shown.bs.modal', function (e) {
      id = $(e.target).data('editId');
      $.ajax({
        url: "{{ route('staff-payment-type.get') }}",
        data: {
          id
        },
        type: "POST",
        beforeSend: () => {
          blockUI.block();
        },
        success: function (data) {
          $(staffPaymentTypeEditForm).find('input[name="name"]').val(data.name);
          blockUI.release();
        },
        error: {}
      });
    });
    let {
      form: staffPaymentTypeEditForm
    } = validateBasicForm("staff_payment_type_edit_form", {
      name: {
        validators: {
          notEmpty: {
            message: "Ad doldurulması zorunludur"
          },
          stringLength: {
            min: 3,
            message: "Ad en az 3 harf'den oluşmak zorundadır."
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
        url: "{{ route('staff-payment-type.update') }}",
        type: "POST",
        data: data,
        success: function (data) {
          $("#staff_payment_type_edit_modal").modal("hide");
          initStaffPaymentTypeData();
          toastr.success("Başarılı!");
        },
        error: function (err) {
          toastr.error("Bir sorun var daha sonra tekrar deneyin!");
        }
      });
    });
  </script>
@endpush
