<x-modal.modal id="product_type_create_modal">
  <x-slot name="title">Ürün Tipi Ekle</x-slot>
  <x-slot name="body">
    <x-form.form id="product_type_create_form">
      <div class="row row-cols-1">
        <x-form.input name="name" label="Ad" placeholder="Ad" required />
        <x-form.input name="initial_code" label="Başlangıç Kodu" placeholder="Başlangıç Kodu" required />
      </div>
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    validateForm("product_type_create_form", {
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
      },
      initial_code: {
        validators: {
          notEmpty: {
            message: "Başlangıç kodu doldurulması zorunludur"
          }
        }
      }
    }, (form) => {
      let data = $(form).serializeArray();
      $.ajax({
        url: "{{ route('product_type.store') }}",
        type: "POST",
        data: data,
        success: function(data) {
          $("#product_type_create_modal").modal("hide");
          initproductTypeData();
          toastr.success("Başarılı!");
        },
        error: function(err) {
          toastr.error("Bir sorun var daha sonra tekrar deneyin!");
        }
      });
    });
  </script>
@endpush
