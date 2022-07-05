<x-card.card cardscroll="300" target="customer_role_card_container">
  <x-slot name="header">
    <x-slot name="title">@lang('globals/words.customer_role')</x-slot>
    <x-slot name="toolbar">
      <div class="d-flex space-x-2">
        <x-tooltip-button :title="__('pages/customer.create_new_customer_role_hint')" data-customer-role-create-button>
          @include('components.icons.create')
          @lang('globals/words.add')
        </x-tooltip-button>
      </div>
    </x-slot>
  </x-slot>
  <x-slot name="body">
    <div class="d-flex flex-column space-y-2 customer-role-zone"></div>
  </x-slot>
</x-card.card>
@push('customscripts')
  <script>

    const CustomerRoleIndexTemplate = function () {
      const create_modal = $("#customer_role_create_modal");
      const edit_modal = $("#customer_role_edit_modal");
      const create_button_selector = "[data-customer-role-create-button]";
      const edit_button_selector = "[data-customer-role-edit-button]";
      const delete_button_selector = "[data-customer-role-delete-button]";
      const block_ui_customer_role_card_container = new KTBlockUI(document.querySelector("#customer_role_card_container"), {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang('globals/infos.loading') </div>',
      });
      let deleteResultAction =  (result, id) => {
        if (result.value) {
          $.ajax({
            url: "{{ route('customer_role.delete') }}",
            type: "POST",
            data: {
              id: id
            },
            beforeSend: function (){
              Swal.close();
            },
            success: function (data) {
              Swal.fire({
                text: "@lang('globals/success_messages.deleted', ['attr'  => __('globals/words.customer_role')])",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "@lang('globals/words.okey')",
                customClass: {
                  confirmButton: "btn fw-bold btn-primary",
                }
              })
              initData();
            },
            error: function (err) {
              Swal.close();
              Swal.fire({
                text: "@lang('globals/error_messages.delete_error', ['attr'  => __('globals/words.customer_role')])",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "@lang('globals/words.okey')",
                customClass: {
                  confirmButton: "btn fw-bold btn-primary",
                }
              });
            }
          });
        }
      }
      const initButtons = function () {
        $(document).on('click', create_button_selector, function (event) {
          event.preventDefault();
          create_modal.modal("show");
        });
        $(document).on('click', edit_button_selector, function (event) {
          event.preventDefault();
          edit_modal.data("editId", $(this).parent().data('customerRoleId')).modal("show");
        });
        $(document).on('click', delete_button_selector, function (event) {
          event.preventDefault();
          let id = $(event.currentTarget).data('customerRoleDeleteButton');
          Swal.fire({
            text: "@lang('globals/check_messages.want_to_delete', ['attr' => __('globals/words.customer_role')])",
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
          url: "{{ route('customer_role.all') }}",
          beforeSend: function () {
            block_ui_customer_role_card_container.block();
          },
          success: function (data) {
            let html = ``;
            if (data && data.length > 0) {
              data.map((item, index) => {
                html += `
                <div class="col">
                  <div class="d-flex justify-content-between align-items-center border py-2 px-4 rounded">
                    <div>${item.name}</div>
                    <div data-customer-role-id="${item.id}">
                      @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.edit')."' data-customer-role-edit-button"])
                        @include('components.icons.edit')
                      @endcomponent
                      @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.delete')."' data-customer-role-delete-button"])
                        @include('components.icons.delete')
                      @endcomponent
                    </div>
                  </div>
                </div>`;
              })
            }
            $(".customer-role-zone").html(html);
            $("[data-bs-toggle]").tooltip();
            block_ui_customer_role_card_container.release();
          },
          error: function (err) {
            block_ui_customer_role_card_container.release();
            toastr.error("@lang('globals/error_messages.fetch_error', ['attr' => __('globals/words.customer_role')])")
          }
        });
      }
      return {initButtons, initData}
    }();

    CustomerRoleIndexTemplate.initButtons();
    CustomerRoleIndexTemplate.initData();


  </script>
@endpush

@include('pages.customer.role.create')
@include('pages.customer.role.edit')
