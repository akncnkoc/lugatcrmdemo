<x-card.card cardscroll="300" target="product_type_card_target">
  <x-slot name="header">
    <x-slot name="title">Ürün Tipleri</x-slot>
    <x-slot name="toolbar">
      <div class="d-flex space-x-2">
        <button class="btn btn-bg-light btn-sm btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip"
          title="Yeni Gider Tipi Ekle" data-product-type-create-button>
          <i class="las la-edit fs-3"></i>
          Ekle
        </button>
      </div>
    </x-slot>
  </x-slot>
  <x-slot name="body">
    <div class="d-flex flex-column space-y-2 product-type-zone"></div>
  </x-slot>
</x-card.card>
@push('customscripts')
  <script>
    $(document).on('click', '[data-product-type-create-button]', function(event) {
      event.preventDefault();
      $("#product_type_create_modal").modal("show");
    });
    $(document).on('click', '[data-product-type-edit-button]', function(event) {
      event.preventDefault();
      $("#product_type_edit_modal").data("editId", $(this).data('productTypeEditButton')).modal("show");
    });
    $(document).on('click', '[data-product-type-delete-button]', function(event) {
      event.preventDefault();
      let id = $(event.currentTarget).data('productTypeDeleteButton');
      Swal.fire({
        text: "Ürün tipini silmek istiyor musunuz ?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Evet, Sil!",
        cancelButtonText: "İptal Et",
        customClass: {
          confirmButton: "btn fw-bold btn-danger",
          cancelButton: "btn fw-bold btn-active-light-primary"
        }
      }).then(function(result) {
        if (result.value) {
          $.ajax({
            url: "{{ route('product_type.delete') }}",
            type: "POST",
            data: {
              id: id
            },
            beforeSend: function() {
              Swal.fire({
                text: "Ürün tipi ve Ürün'nün tipleri siliniyor",
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
              })
            },
            success: function(data) {
              Swal.close();
              Swal.fire({
                text: "Ürün tipi silindi",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Tamam",
                customClass: {
                  confirmButton: "btn fw-bold btn-primary",
                }
              })
              initproductTypeData();
            },
            error: function(err) {
              Swal.close();
              Swal.fire({
                text: "Ürün tipi tekrar deneyin!",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Tamam",
                customClass: {
                  confirmButton: "btn fw-bold btn-primary",
                }
              });
            }
          });
        }
      });
    });
  </script>
  <script>
    var blockUIproductType = new KTBlockUI(document.querySelector("#product_type_card_target"), {
      message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Yükleniyor...</div>',
    });
    var initproductTypeData = () => {
      $.ajax({
        type: "POST",
        url: "{{ route('product_type.all') }}",
        beforeSend: function() {
          blockUIproductType.block();
        },
        success: function(data) {
          let html = ``;
          if (data && data.length > 0) {
            data.map((item, index) => {
              html += `
                  <div class="d-flex justify-content-between align-items-center border py-2 px-4 rounded">
                    <div>${item.name} - ( ${item.initial_code} )</div>
                    <div>
                      <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-2" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Düzenle" data-product-type-edit-button="${item.id}">
                        @include('components.icons.edit')
                      </button>
                      <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Sil" data-product-type-delete-button="${item.id}">
                        @include('components.icons.delete')
                      </button>
                    </div>
                  </div>
              `;
            })
          }
          $(".product-type-zone").html(html);
          blockUIproductType.release();
          $("[data-bs-toggle]").tooltip();
        },
        error: function(err) {

        }
      });
    }
    initproductTypeData();
  </script>
@endpush

@include('pages.product.type.create')
@include('pages.product.type.edit')
