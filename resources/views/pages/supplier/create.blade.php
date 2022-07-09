<x-modal.modal id="create_modal">
  <x-slot name="title">Tedarikçi Ekle</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-1">
        <x-form.input name="name" label="Ad (Ünvan)" placeholder="Ad (Ünvan)" required/>
        <x-form.input name="email" label="Email" placeholder="Email"/>
        <x-form.input name="phone" label="Telefon" placeholder="Telefon"/>
      </div>
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    const SupplierCreateTemplate = function (){
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
          url: "{{ route('supplier.store') }}",
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
      };
      validateBasicForm("create_form", validations, formValidated);
      return {};
    }();

  </script>
@endpush
