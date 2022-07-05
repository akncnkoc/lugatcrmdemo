<x-card.card cardscroll="300" target="expense_type_card_target">
  <x-slot name="header">
    <x-slot name="title">@lang('pages/expense.expense_types')</x-slot>
    <x-slot name="toolbar">
      <div class="d-flex space-x-2">
        <x-tooltip-button :title="__('pages/expense.create_new_expense_type_hint')" data-expense-type-create-button>
          @include('components.icons.create')
          @lang('globals/words.add')
        </x-tooltip-button>
      </div>
    </x-slot>
  </x-slot>
  <x-slot name="body">
    <div class="d-flex flex-column space-y-2 expense-type-zone"></div>
  </x-slot>
</x-card.card>
@push('customscripts')
  <script>

    const ExpenseTypeIndexTemplate = function () {
      let create_button_selector = "[data-expense-type-create-button]",
        create_modal = $("#expense_type_create_modal"),
        edit_button_selector = "[data-expense-type-edit-button]",
        edit_modal = $("#expense_type_edit_modal"),
        delete_button_selector = "[data-expense-type-delete-button]",
        block_ui_target = document.querySelector("#expense_type_card_target");

      let block_ui_expense_type_target = new KTBlockUI(block_ui_target, {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang('globals/infos.loading')... </div>',
      });

      let deleteResultAction = (result, id) => {
        if (result.value) {
          $.ajax({
            url: "{{ route('expense_type.delete') }}",
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
                text: "@lang('globals/success_messages.deleted', ['attr' => __('globals/words.expense_type')])",
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
                text: "@lang('globals/error_messages.delete_error', ['attr' => __('globals/words.expense_type')])",
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
          edit_modal.data("editId", $(this).parent().data('expenseTypeId')).modal("show");
        });
        $(document).on('click', delete_button_selector, function (event) {
          event.preventDefault();
          let id = $(event.currentTarget).data('expenseTypeDeleteButton');
          Swal.fire({
            text: "@lang('globals/check_messages.want_to_delete', ['attr'  => __('globals/words.expense_type')])",
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
          url: "{{ route('expense_type.all') }}",
          beforeSend: function () {
            block_ui_expense_type_target.block();
          },
          success: function (data) {
            let html = ``;
            if (data && data.length > 0) {
              data.map((item, index) => {
                html += `
                  <div class="d-flex justify-content-between align-items-center border py-2 px-4 rounded">
                    <div>${item.name}</div>
                    <div data-expense-type-id="${item.id}">
                      @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.edit')."' data-expense-type-edit-button"])
                        @include('components.icons.edit')
                      @endcomponent
                      @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.delete')."' data-expense-type-delete-button"])
                        @include('components.icons.delete')
                      @endcomponent
                    </div>
                  </div>`;
              })
            }
            $(".expense-type-zone").html(html);
            block_ui_expense_type_target.release();
            $("[data-bs-toggle]").tooltip();
          },
          error: function (err) {
            toastr.error("@lang('globals/error_messages.fetch_error', ['attr'  => __('globals/words.expense_type')])")
          }
        });
      }
      return {initButtons, initData};
    }();
    ExpenseTypeIndexTemplate.initButtons();
    ExpenseTypeIndexTemplate.initData();

  </script>
@endpush

@include('pages.expense.type.create')
@include('pages.expense.type.edit')
