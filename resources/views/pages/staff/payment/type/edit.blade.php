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
    const StaffPaymentTypeEditTemplate = function () {
      let id;
      let edit_modal = $("#staff_payment_type_edit_modal");
      let modal_target = document.querySelector("#staff_payment_type_edit_modal_target");
      let block_ui_modal_target = new KTBlockUI(modal_target);
      let validations = {
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
      };
      const formValidated = (form) => {
        let data = $(form).serializeArray();
        data.push({name: "id", value: id});
        $.ajax({
          url: "{{ route('staff-payment-type.update') }}",
          type: "POST",
          data: data,
          success: function (data) {
            edit_modal.modal("hide");
            StaffPaymentTypeIndexTemplate.initData();
            toastr.success("Başarılı!");
          },
          error: function (err) {
            edit_modal.modal("hide");
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      }
      const modalShowAction = (e) => {
        $(form).find('input[name="name"]').focus();
        id = $(e.target).data('itemId');
        $.ajax({
          url: "{{ route('staff-payment-type.get') }}",
          data: {
            id
          },
          type: "POST",
          beforeSend: () => {
            block_ui_modal_target.block();
          },
          success: function (data) {
            $(form).find('input[name="name"]').val(data.name);
            block_ui_modal_target.release();
          },
          error: () => {
            edit_modal.modal("hide");
            toastr.error("@lang('globals/error_messages.fetch_error', ['attr' => __('globals/words.staff_payment_type')])");
          }
        });
      };
      const {form} = validateBasicForm("staff_payment_type_edit_form", validations, formValidated);
      return {edit_modal, modalShowAction};
    }();


    StaffPaymentTypeEditTemplate.edit_modal.on('shown.bs.modal', StaffPaymentTypeEditTemplate.modalShowAction);

  </script>
@endpush
