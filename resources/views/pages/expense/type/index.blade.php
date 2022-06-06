<x-card.card cardscroll="300" target="expense_type_card_target">
  <x-slot name="header">
    <x-slot name="title">Gider Tipleri</x-slot>
    <x-slot name="toolbar">
      <div class="d-flex space-x-2">
        <button class="btn btn-bg-light btn-sm btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Yeni Gider Tipi Ekle"
          data-expense-type-create-button>
          <i class="las la-edit fs-3"></i>
          Ekle
        </button>
      </div>
    </x-slot>
  </x-slot>
  <x-slot name="body">
    <div class="d-flex flex-column space-y-2 expense-type-zone"></div>
  </x-slot>
</x-card.card>
@push('customscripts')
  <script>
    $(document).on('click', '[data-expense-type-create-button]', function(event) {
      event.preventDefault();
      $("#expense_type_create_modal").modal("show");
    });
    $(document).on('click', '[data-expense-type-edit-button]', function(event) {
      event.preventDefault();
      $("#expense_type_edit_modal").data("editId", $(this).data('expenseTypeEditButton')).modal("show");
    });
    $(document).on('click', '[data-expense-type-delete-button]', function(event) {
      event.preventDefault();
      let id = $(event.currentTarget).data('expenseTypeDeleteButton');
      Swal.fire({
        text: "Gider tipini silmek istiyor musunuz ?",
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
            url: "{{ route('expense_type.delete') }}",
            type: "POST",
            data: {
              id: id
            },
            beforeSend: function() {
              Swal.fire({
                text: "Gider tipi ve Gider'nin tipleri siliniyor",
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
              })
            },
            success: function(data) {
              Swal.close();
              Swal.fire({
                text: "Gider tipi silindi",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Tamam",
                customClass: {
                  confirmButton: "btn fw-bold btn-primary",
                }
              })
              initExpenseTypeData();
            },
            error: function(err) {
              Swal.close();
              Swal.fire({
                text: "Gider tipi tekrar deneyin!",
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
    var blockUIExpenseType = new KTBlockUI(document.querySelector("#expense_type_card_target"),{
      message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Yükleniyor...</div>',
    });
    var initExpenseTypeData = () => {
      $.ajax({
        type: "POST",
        url: "{{ route('expense_type.all') }}",
        beforeSend: function() {
          blockUIExpenseType.block();
        },
        success: function(data) {
          let html = ``;
          if (data && data.length > 0) {
            data.map((item, index) => {
              html += `
                  <div class="d-flex justify-content-between align-items-center border py-2 px-4 rounded">
                    <div>${item.name}</div>
                    <div>
                      <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-2" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Düzenle" data-expense-type-edit-button="${item.id}">
                        @include('components.icons.edit')
                      </button>
                      <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Sil" data-expense-type-delete-button="${item.id}">
                        @include('components.icons.delete')
                      </button>
                    </div>
                  </div>
              `;
            })
          }
          $(".expense-type-zone").html(html);
          blockUIExpenseType.release();
          $("[data-bs-toggle]").tooltip();
        },
        error: function(err) {

        }
      });
    }
    initExpenseTypeData();
  </script>
@endpush

@include('pages.expense.type.create')
@include('pages.expense.type.edit')
