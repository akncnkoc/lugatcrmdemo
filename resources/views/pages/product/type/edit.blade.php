<x-modal.modal id="product_type_edit_modal">
  <x-slot name="title">Ürün Tipi Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="product_type_edit_form">
      <div class="row row-cols-1">
        <x-form.input name="name" label="Ad (Ünvan)" placeholder="Ad (Ünvan)" required />
        <x-form.input name="initial_code" label="Başlangıç Kodu" placeholder="Başlangıç Kodu" required />
      </div>
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    var id;
    var blockUI = new KTBlockUI(document.querySelector("#product_type_edit_modal_target"));
    $("#product_type_edit_modal").on('shown.bs.modal', function(e) {
      id = $(e.target).data('editId');
      $.ajax({
        url: "{{ route('product_type.get') }}",
        data: {
          id
        },
        type: "POST",
        beforeSend: () => {
          blockUI.block();
        },
        success: function(data) {
          $(productTypeEditForm).find('input[name="name"]').val(data.name);
          $(productTypeEditForm).find('input[name="initial_code"]').val(data.initial_code);
          blockUI.release();
        },
        error: {}
      });
    });
    let {
      form: productTypeEditForm
    } = validateForm("product_type_edit_form", {
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
      data.push({
        name: "id",
        value: id
      });
      $.ajax({
        url: "{{ route('product_type.update') }}",
        type: "POST",
        data: data,
        success: function(data) {
          $("#product_type_edit_modal").modal("hide");
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
