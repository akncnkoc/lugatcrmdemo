<x-modal.modal id="create_modal">
  <x-slot name="title">Müşteri Ekle</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-2">
        <x-form.input name="name" label="Ad (Ünvan)" placeholder="Ad (Ünvan)" required />
        <x-form.input name="surname" label="Soyad" placeholder="Soyad" />
      </div>
      <div class="row row-cols-2">
        <x-form.input name="email" label="Email" placeholder="Email" />
        <x-form.input name="phone" label="Telefon" placeholder="Telefon" />
      </div>
      <div class="row row-cols-2">
        <x-form.select name="customer_role_id" label="Rol" placeholder="Rol" :asyncload="route('customer_role.select')" parent="#create_modal" required />
        <div class="d-flex align-items-center">
          <x-form.radio label="Cinsiyet" checked="1" name="gender" hint="Eğer müşteri bir firma yada tüzel kişiyşe diğeri seçin" :items="['Erkek' => 1, 'Kadın' => 2, 'Diğer' => 3]" />
        </div>
      </div>
      <x-form.textarea name="address" label="Açık Adres" />
      <x-form.textarea name="comment" label="Yorum" />
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    let {
      form: createForm,
      validator: createValidator
    } = validateForm("create_form", {
      name: {
        validators: {
          notEmpty: {
            message: "Ad doldurulması zorunludur"
          },
          stringLength:{
            min: 3,
            message: "Ad en az 3 harf'den oluşmak zorundadır."
          }
        }
      },
      customer_role_id: {
        validators:{
          notEmpty:{
            message: "Rol seçilmesi zorunludur."
          }
        }
      }
    }, (form) => {
      let data = $(form).serializeArray();
      $.ajax({
        url: "{{ route('customer.store') }}",
        type: "POST",
        data: data,
        success: function(data) {
          $("#create_modal").modal("hide");
          table.ajax.reload(null,false);
          toastr.success("Başarılı!");
        },
        error: function(err) {
          toastr.error("Bir sorun var daha sonra tekrar deneyin!");
        }
      });
    }, () => {
      console.log("invalidated")
    }, (form, validator) => {
      $(form).find('.customer_role_id_select').on('change', function() {
        validator.revalidateField('customer_role_id');
      });
    });
  </script>
@endpush
