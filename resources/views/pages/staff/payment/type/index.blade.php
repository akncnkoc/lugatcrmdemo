<x-card.card cardscroll="300" target="staff_payment_type_card_target">
  <x-slot name="header">
    <x-slot name="title">Personel Ödeme Tipleri</x-slot>
    <x-slot name="toolbar">
      <div class="d-flex space-x-2">
        <button class="btn btn-bg-light btn-sm btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark"
                data-bs-placement="top" data-bs-toggle="tooltip" title="Yeni Gider Tipi Ekle"
                data-staff-payment-type-create-button>
          <i class="las la-edit fs-3"></i>
          Ekle
        </button>
      </div>
    </x-slot>
  </x-slot>
  <x-slot name="body">
    <div class="d-flex flex-column space-y-2 staff-payment-type-zone"></div>
  </x-slot>
</x-card.card>
@push('customscripts')
  <script>
    $(document).on('click', '[data-staff-payment-type-create-button]', function (event) {
      event.preventDefault();
      $("#staff_payment_type_create_modal").modal("show");
    });
    $(document).on('click', '[data-staff-payment-type-edit-button]', function (event) {
      event.preventDefault();
      $("#staff_payment_type_edit_modal").data("editId", $(this).data('staffPaymentTypeEditButton')).modal("show");
    });
    $(document).on('click', '[data-staff-payment-type-delete-button]', function (event) {
      event.preventDefault();
      let id = $(event.currentTarget).data('staffPaymentTypeDeleteButton');
      Swal.fire({
        text: "Personel ödeme tipini silmek istiyor musunuz ?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Evet, Sil!",
        cancelButtonText: "İptal Et",
        customClass: {
          confirmButton: "btn fw-bold btn-danger",
          cancelButton: "btn fw-bold btn-active-light-primary"
        }
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: "{{ route('staff-payment-type.delete') }}",
            type: "POST",
            data: {
              id: id
            },
            beforeSend: function () {
              Swal.fire({
                text: "Personel ödeme tipini ve ödemeleri siliniyor",
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
              })
            },
            success: function (data) {
              Swal.close();
              Swal.fire({
                text: "Personel ödeme tipi silindi",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Tamam",
                customClass: {
                  confirmButton: "btn fw-bold btn-primary",
                }
              })
              initStaffPaymentTypeData();
            },
            error: function (err) {
              Swal.close();
              Swal.fire({
                text: "Personel ödeme tipi tekrar deneyin!",
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
    var blockUIStaffPaymentType = new KTBlockUI(document.querySelector("#staff_payment_type_card_target"), {
      message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Yükleniyor...</div>',
    });
    var initStaffPaymentTypeData = () => {
      $.ajax({
        type: "POST",
        url: "{{ route('staff-payment-type.all') }}",
        beforeSend: function () {
          blockUIStaffPaymentType.block();
        },
        success: function (data) {
          let html = ``;
          if (data && data.length > 0) {
            data.map((item, index) => {
              html += `
                  <div class="d-flex justify-content-between align-items-center border py-2 px-4 rounded">
                    <div>${item.name}</div>
                    <div>
                      <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-2" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Düzenle" data-staff-payment-type-edit-button="${item.id}">
                        @include('components.icons.edit')
              </button>
              <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Sil" data-staff-payment-type-delete-button="${item.id}">
                        @include('components.icons.delete')
              </button>
            </div>
          </div>
`;
            })
          }
          $(".staff-payment-type-zone").html(html);
          blockUIStaffPaymentType.release();
          $("[data-bs-toggle]").tooltip();
        },
        error: function (err) {

        }
      });
    }
    initStaffPaymentTypeData();
  </script>
@endpush

@include('pages.staff.payment.type.create')
@include('pages.staff.payment.type.edit')
