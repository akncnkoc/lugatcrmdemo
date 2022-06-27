<x-modal.modal id="staff_role_create_modal">
  <x-slot name="title">Personel Rolü Ekle</x-slot>
  <x-slot name="body">
    <x-form.form id="staff_role_create_form">
      <div class="row row-cols-1">
        <x-form.input name="name" label="Ad" placeholder="Ad" required/>
      </div>
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    validateBasicForm("staff_role_create_form", {
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
      $.ajax({
        url: "{{ route('staff_role.store') }}",
        type: "POST",
        data: data,
        success: function (data) {
          $("#staff_role_create_modal").modal("hide");
          initStaffRoleData();
          toastr.success("Başarılı!");
        },
        error: function (err) {
          toastr.error("Bir sorun var daha sonra tekrar deneyin!");
        }
      });
    });
  </script>
@endpush

