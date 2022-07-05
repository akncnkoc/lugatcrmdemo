<x-card.card cardscroll="300" target="staff_payment_type_card_target">
  <x-slot name="header">
    <x-slot name="title">Personel Ödeme Tipleri</x-slot>
    <x-slot name="toolbar">
      <div class="d-flex space-x-2">
        <x-tooltip-button data-staff-payment-type-create-button>
          @include('components.icons.create')
          @lang('globals/words.add')
        </x-tooltip-button>
      </div>
    </x-slot>
  </x-slot>
  <x-slot name="body">
    <div class="d-flex flex-column space-y-2 staff-payment-type-zone"></div>
  </x-slot>
</x-card.card>
@push('customscripts')
  <script>
    const StaffPaymentTypeIndexTemplate = function () {
      let create_button_selector = "[data-staff-payment-type-create-button]",
        create_modal = $("#staff_payment_type_create_modal"),
        edit_button_selector = "[data-staff-payment-type-edit-button]",
        edit_modal = $("#staff_payment_type_edit_modal"),
        delete_button_selector = "[data-staff-payment-type-delete-button]",
        block_ui_target = document.querySelector("#staff_payment_type_card_target");

      let block_ui_modal_target = new KTBlockUI(block_ui_target, {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang('globals/infos.loading')... </div>',
      });

      let deleteResultAction = (result, id) => {
        if (result.value) {
          $.ajax({
            url: "{{ route('staff-payment-type.delete') }}",
            type: "POST",
            data: {
              id: id
            },
            beforeSend: () => {
              Swal.close();
            },
            success: function (data) {
              Swal.close();
              Swal.fire({
                text: "@lang('globals/success_messages.deleted', ['attr' => __('globals/words.staff_payment_type')])",
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
              Swal.fire({
                text: "@lang('globals/error_messages.delete_error', ['attr' => __('globals/words.staff_payment_type')])",
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
      const initButtons = () => {
        $(document).on('click', create_button_selector, function (event) {
          event.preventDefault();
          create_modal.modal("show");
        });
        $(document).on('click', edit_button_selector, function (event) {
          event.preventDefault();
          edit_modal.data("itemId", $(this).parent().data('itemId')).modal("show");
        });
        $(document).on('click', delete_button_selector, function (event) {
          event.preventDefault();
          let id = $(event.currentTarget).parent().data('itemId');
          Swal.fire({
            text: "@lang('globals/check_messages.want_to_delete', ['attr'  => __('globals/words.staff_payment_type')])",
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
          url: "{{ route('staff-payment-type.all') }}",
          beforeSend: function () {
            block_ui_modal_target.block();
          },
          success: function (data) {
            let html = ``;
            if (data && data.length > 0) {
              data.map((item, index) => {
                html += `
                  <div class="d-flex justify-content-between align-items-center border py-2 px-4 rounded">
                    <div>${item.name}</div>
                    <div data-item-id="${item.id}">
                      @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.edit')."' data-staff-payment-type-edit-button"])
                      @include('components.icons.edit')
                      @endcomponent
                      @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.delete')."' data-staff-payment-type-delete-button"])
                      @include('components.icons.delete')
                      @endcomponent
                </div>
              </div>`;
              })
            }
            $(".staff-payment-type-zone").html(html);
            block_ui_modal_target.release();
            $("[data-bs-toggle]").tooltip();
          },
          error: function (err) {
            toastr.error("@lang('globals/error_messages.fetch_error', ['attr'  => __('globals/words.staff_payment_type')])")
          }
        });
      }
      return {initButtons, initData};
    }();
    StaffPaymentTypeIndexTemplate.initButtons();
    StaffPaymentTypeIndexTemplate.initData();
  </script>
@endpush
@include('pages.staff.payment.type.create')
@include('pages.staff.payment.type.edit')
