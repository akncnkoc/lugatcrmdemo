<x-modal.modal id="staff_payment_type_create_modal">
  <x-slot name="title">Personel Ödeme Tipi Ekle</x-slot>
  <x-slot name="body">
    <x-form.form id="staff_payment_type_create_form">
      <div class="row row-cols-1">
        <x-form.input name="name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')" required/>
      </div>
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    const StaffPaymentTypeCreateTemplate = function (){
      let create_modal = $("#staff_payment_type_create_modal");
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
      let formValidated = (form) => {
        let data = $(form).serializeArray();
        $.ajax({
          url: "{{ route('staff-payment-type.store') }}",
          type: "POST",
          data: data,
          success: function (data) {
            $("#staff_payment_type_create_modal").modal("hide");
            initStaffPaymentTypeData();
            toastr.success("Başarılı!");
          },
          error: function (err) {
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      };
      validateBasicForm("staff_payment_type_create_form", validations, formValidated);
      return {create_modal};
    }();

    StaffPaymentTypeCreateTemplate.create_modal.on('shown.bs.modal', () => $("input[name='name']").focus())
  </script>
@endpush
