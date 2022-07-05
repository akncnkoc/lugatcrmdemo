<x-card.card cardscroll="300" target="product_type_card_target">
  <x-slot name="header">
    <x-slot name="title">@lang('globals/words.product_type')</x-slot>
    <x-slot name="toolbar">
      <div class="d-flex space-x-2">
        <x-tooltip-button :title="__('pages/product.create_new_product_type_hint')" data-product-type-create-button>
          @include('components.icons.create')
          @lang('globals/words.add')
        </x-tooltip-button>
      </div>
    </x-slot>
  </x-slot>
  <x-slot name="body">
    <div class="d-flex flex-column space-y-2 product-type-zone"></div>
  </x-slot>
</x-card.card>
@push('customscripts')
  <script>
    const ProductTypeIndexTemplate = function () {
      let product_type_create_modal = $("#product_type_create_modal");
      let product_type_edit_modal = $("#product_type_edit_modal");
      let product_type_card_target = document.querySelector("#product_type_card_target");
      let block_ui_product_type_card_container = new KTBlockUI(product_type_card_target, {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Yükleniyor...</div>',
      });

      const deleteResultAction = (result, id) => {
        if (result.value) {
          $.ajax({
            url: "{{ route('product_type.delete') }}",
            type: "POST",
            data: {
              id: id
            },
            beforeSend: function () {
              Swal.fire({
                text: "Ürün tipi ve Ürün'nün tipleri siliniyor",
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
              })
            },
            success: function (data) {
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
            error: function (err) {
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
      }
      const initButtons = () => {
        $(document).on('click', '[data-product-type-create-button]', function (event) {
          event.preventDefault();
          product_type_create_modal.modal("show");
        });
        $(document).on('click', '[data-product-type-edit-button]', function (event) {
          event.preventDefault();
          product_type_edit_modal.data("itemId", $(this).parent().data('itemId')).modal("show");
        });
        $(document).on('click', '[data-product-type-delete-button]', function (event) {
          event.preventDefault();
          let id = $(event.currentTarget).data('productTypeDeleteButton');
          Swal.fire({
            text: "@lang('globals/check_messages.want_to_delete', ['attr' => __('globals/words.expense_type')])",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "@lang('globals/words.yes')",
            cancelButtonText: "@lang('globals/words.cancel')",
            customClass: {
              confirmButton: "btn fw-bold btn-danger",
              cancelButton: "btn fw-bold btn-active-light-primary"
            }
          }).then((res) => deleteResultAction(res, id));
        });
      }
      const initData = () => {
        $.ajax({
          type: "POST",
          url: "{{ route('product_type.all') }}",
          beforeSend: function () {
            block_ui_product_type_card_container.block();
          },
          success: function (data) {
            let html = ``;
            if (data && data.length > 0) {
              data.map((item, index) => {
                html += `
                  <div class="d-flex justify-content-between align-items-center border py-2 px-4 rounded">
                    <div>${item.name} - ( ${item.initial_code} )</div>
                    <div data-item-id="${item.id}">
                      @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.edit')."' data-product-type-edit-button"])
                @include('components.icons.edit')
                @endcomponent
                @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.delete')."' data-product-type-delete-button"])
                @include('components.icons.delete')
                @endcomponent
                </div>
              </div>
`;
              })
            }
            $(".product-type-zone").html(html);
            block_ui_product_type_card_container.release();
            $("[data-bs-toggle]").tooltip();
          },
          error: function (err) {
            block_ui_product_type_card_container.release();
            toastr.error("@lang('globals/error_messages.fetch_error', ['attr' => __('globals/words.expense_type')])")
          }
        });
      }

      return {initButtons,initData};
    }();
    ProductTypeIndexTemplate.initButtons();
    ProductTypeIndexTemplate.initData();
  </script>
@endpush

@include('pages.product.type.create')
@include('pages.product.type.edit')
