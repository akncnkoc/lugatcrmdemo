<x-card.card cardscroll="300" target="staff_role_card_target">
  <x-slot name="header">
    <x-slot name="title">Personel Rolleri</x-slot>
    <x-slot name="toolbar">
      <div class="d-flex space-x-2">
        <button class="btn btn-bg-light btn-sm btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip"
                title="Yeni Personel Rolü Ekle"
                data-staff-role-create-button>
          <i class="las la-edit fs-3"></i>
          Ekle
        </button>
      </div>
    </x-slot>
  </x-slot>
  <x-slot name="body">
    <div class="d-flex flex-column space-y-2 staff-role-zone"></div>
  </x-slot>
</x-card.card>
@push('customscripts')
  <script>
    $(document).on('click', '[data-staff-role-create-button]', function (event) {
      event.preventDefault();
      $("#staff_role_create_modal").modal("show");
    });
    $(document).on('click', '[data-staff-role-edit-button]', function (event) {
      event.preventDefault();
      $("#staff_role_edit_modal").data("editId", $(this).data('staffRoleEditButton')).modal("show");
    });
    $(document).on('click', '[data-staff-role-delete-button]', function (event) {
      event.preventDefault();
      let id = $(event.currentTarget).data('staffRoleDeleteButton');
      Swal.fire({
        text: "Personel rolünü silmek istiyor musunuz ?",
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
            url: "{{ route('staff_role.delete') }}",
            type: "POST",
            data: {
              id: id
            },
            beforeSend: function () {
              Swal.fire({
                text: "Personel rolü ve Personel'nin rolleri siliniyor",
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
              })
            },
            success: function (data) {
              Swal.close();
              Swal.fire({
                text: "Personel rolü silindi",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Tamam",
                customClass: {
                  confirmButton: "btn fw-bold btn-primary",
                }
              })
              initStaffRoleData();
            },
            error: function (err) {
              Swal.close();
              Swal.fire({
                text: "Personel rolü tekrar deneyin!",
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
    var blockUIStaffRole = new KTBlockUI(document.querySelector("#staff_role_card_target"), {
      message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Yükleniyor...</div>',
    });
    var initStaffRoleData = () => {
      $.ajax({
        type: "POST",
        url: "{{ route('staff_role.all') }}",
        beforeSend: function () {
          blockUIStaffRole.block();
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
                      <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-2" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Düzenle" data-staff-role-edit-button="${item.id}">
                        @include('components.icons.edit')
              </button>
              <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Sil" data-staff-role-delete-button="${item.id}">
                        @include('components.icons.delete')
              </button>
            </div>
          </div>
        </div>
`;
            })
          }
          $(".staff-role-zone").html(html);
          $("[data-bs-toggle]").tooltip();
          blockUIStaffRole.release();
        },
        error: function (err) {

        }
      });
    }


    initStaffRoleData();
  </script>
@endpush

@include('pages.staff.role.create')
@include('pages.staff.role.edit')
