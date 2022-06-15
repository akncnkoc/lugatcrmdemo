<x-card.card cardscroll="300" target="customer_role_card_target">
  <x-slot name="header">
    <x-slot name="title">@lang('globals/words.customer_role')</x-slot>
    <x-slot name="toolbar">
      <div class="d-flex space-x-2">
        <button class="btn btn-bg-light btn-sm btn-icon-info btn-text-info"
                data-bs-custom-class="tooltip-dark"
                data-bs-placement="top"
                data-bs-toggle="tooltip"
                title="@lang('pages/customer.create_new_customer_role_hint')"
                data-customer-role-create-button>
          <i class="las la-edit fs-3"></i>
          @lang('globals/words.add')
        </button>
      </div>
    </x-slot>
  </x-slot>
  <x-slot name="body">
    <div class="d-flex flex-column space-y-2 customer-role-zone"></div>
  </x-slot>
</x-card.card>
@push('customscripts')
  <script>
    $(document).on('click', '[data-customer-role-create-button]', function (event) {
      event.preventDefault();
      $("#customer_role_create_modal").modal("show");
    });
    $(document).on('click', '[data-customer-role-edit-button]', function (event) {
      event.preventDefault();
      $("#customer_role_edit_modal").data("editId", $(this).data('customerRoleEditButton')).modal("show");
    });
    $(document).on('click', '[data-customer-role-delete-button]', function (event) {
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
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: "{{ route('customer_role.delete') }}",
            type: "POST",
            data: {
              id: id
            },
            success: function (data) {
              Swal.close();
              Swal.fire({
                text: "@lang('globals/success_messages.deleted', ['attr'  => __('globals/words.customer_role')])",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "@lang('globals/words.okey')",
                customClass: {
                  confirmButton: "btn fw-bold btn-primary",
                }
              })
              initCustomerRoleData();
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
      });
    });
  </script>
  <script>
    var blockUICustomerRole = new KTBlockUI(document.querySelector("#customer_role_card_target"), {
      message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang('globals/infos.loading') </div>',
    });
    var initCustomerRoleData = () => {
      $.ajax({
        type: "POST",
        url: "{{ route('customer_role.all') }}",
        beforeSend: function () {
          blockUICustomerRole.block();
        },
        success: function (data) {
          let html = ``;
          if (data && data.length > 0) {
            data.map((item, index) => {
              html += `
                <div class="col">
                  <div class="d-flex justify-content-between align-items-center border py-2 px-4 rounded">
                    <div>${item.name}</div>
                    <div>
                      <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-2"
                      data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip"
                      title="@lang('globals/words.edit')" data-customer-role-edit-button="${item.id}">
                        @include('components.icons.edit')
              </button>
              <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-custom-class="tooltip-dark"
               data-bs-placement="top" data-bs-toggle="tooltip" title="@lang('globals/words.delete')"
               data-customer-role-delete-button="${item.id}">
                        @include('components.icons.delete')
              </button>
            </div>
          </div>
        </div>
`;
            })
          }
          $(".customer-role-zone").html(html);
          $("[data-bs-toggle]").tooltip();
          blockUICustomerRole.release();
        },
        error: function (err) {
          blockUICustomerRole.release();
          toastr.error("@lang('globals/error_messages.fetch_error', ['attr' => __('globals/words.customer_role')])")
        }
      });
    }
    initCustomerRoleData();
  </script>
@endpush

@include('pages.customer.role.create')
@include('pages.customer.role.edit')
