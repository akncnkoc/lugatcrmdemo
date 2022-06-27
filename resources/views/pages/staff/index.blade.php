@extends('layout.default')
@section('page-title')
  Personeller
@endsection
@section('toolbar')
  <a class="btn btn-bg-light btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Yeni Personel Ekle"
     data-create-button>
    <i class="las la-edit fs-3"></i>
    Ekle
  </a>
@endsection
@section('content')
  @include('pages.staff.create')
  @include('pages.staff.edit')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">Personel Listesi</x-slot>
      <x-slot name="toolbar">
        <div class="d-flex space-x-2">
          @include('pages.staff.filter')
          @include('pages.staff.export')
        </div>
      </x-slot>
    </x-slot>
    <x-slot name="body">
      <x-table.table id="table">
        <x-table.thead>
          <th class="w-10px pe-2">
            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
              <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#table .form-check-input" value="1"/>
            </div>
          </th>
          <th>No</th>
          <th>Adı Soyadı <span class="fs-8">(Ünvan)</span></th>
          <th>Telefon</th>
          <th>Email</th>
          <th>Maaş</th>
          <th>Rol</th>
          <th class="text-center min-w-100px">İşlemler</th>
        </x-table.thead>
        <x-table.tbody></x-table.tbody>
      </x-table.table>
    </x-slot>
  </x-card.card>
@endsection
@section('scripts')
  <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endsection
@push('customscripts')
  <script type="text/javascript">
    var table = initStaffTable();
    $(document).on('click', '[data-create-button]', function (event) {
      event.preventDefault();
      $("#create_modal").modal("show");
    });
    $(document).on('click', '[data-edit-button]', function (event) {
      event.preventDefault();
      $("#edit_modal").data("editId", $(this).data('editButton')).modal("show");
    });

    function initStaffTable(data = {}) {
      if (table) table.destroy();
      table = $("#table").DataTable({
        serverSide: true,
        processing: true,
        stateSave: true,
        select: {
          style: 'multi',
          selector: 'td:first-child input[type="checkbox"]',
          className: 'row-selected'
        },
        ajax: {
          url: '{{ route('staff.table') }}',
          type: 'POST',
          data: function (d) {
            for (const [key, value] of Object.entries(data)) {
              d[key] = value;
            }
          }
        },
        columns: [{
          data: 'DT_RowIndex',
          name: "id"
        },
          {
            data: "id",
            name: "id"
          },
          {
            data: "name",
            name: "name",
            render: function (data, type, row) {
              let fullname = "";
              fullname += row.name ?? "";
              fullname += " ";
              fullname += row.surname ?? "";
              return fullname;
            }
          },
          {
            data: "phone",
            name: "phone"
          },
          {
            data: "email",
            name: "email"
          },
          {
            name: "salary",
            data: "salary",
            render: function (data, type, row) {
              if (!row.salary_safe || parseInt(row.salary_safe) <= 0) return "Maaş bilgisi bulunamadı.";
              let salary_safe = row.salary_safe.name;
              return row.salary + " " + salary_safe;
            }
          },
          {
            data: 'staff_role.name',
            name: "staff_role.name"
          },
          {
            data: null
          }
        ],
        columnDefs: [{
          targets: 0,
          orderable: false,
          render: function (data) {
            return `
              <div class="form-check form-check-sm form-check-custom form-check-solid">
                  <input class="form-check-input" type="checkbox" value="${data}" />
              </div>`;
          }
        },
          {
            targets: -1,
            data: null,
            orderable: false,
            className: 'text-center',
            render: function (data, type, row) {
              return `
              <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-edit-button="${row.id}" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Düzenle">
                @include('components.icons.edit')
              </button>
              <a href="{{url('/staff')}}/${row.id}/payment" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Ödemeler">
                @include('components.icons.finance')
              </a>
              <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-delete-button="${row.id}" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Sil">
                @include('components.icons.delete')
              </button>
            `;
            },
          }
        ],
        order: [
          [1, 'desc']
        ],
      })
      let handleDeleteRows = () => {
        const deleteButtons = document.querySelectorAll('[data-delete-button]');
        deleteButtons.forEach(d => {
          d.addEventListener('click', function (e) {
            e.preventDefault();
            const parent = e.target.closest('tr');
            const staff_name = parent.querySelectorAll('td')[2].innerText;
            const id = parent.querySelectorAll('td')[1].innerText;
            Swal.fire({
              text: staff_name + " adlı personeli silmek istiyor musunuz ?",
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
                  url: "{{ route('staff.delete') }}",
                  type: "POST",
                  data: {
                    id: id
                  },
                  beforeSend: function () {
                    Swal.fire({
                      text: staff_name + " adlı personel siliniyor...",
                      icon: "info",
                      buttonsStyling: false,
                      showConfirmButton: false,
                    })
                  },
                  success: function (data) {
                    Swal.close();
                    Swal.fire({
                      text: "Personel silindi",
                      icon: "success",
                      buttonsStyling: false,
                      confirmButtonText: "Tamam",
                      customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                      }
                    })
                    table.ajax.reload();
                  },
                  error: function (err) {
                    Swal.close();
                    Swal.fire({
                      text: "Personel silinemedi tekrar deneyin!",
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
          })
        });
      }
      table.on('draw', () => {
        $('[data-bs-toggle="tooltip"]').tooltip();
        handleDeleteRows();
      });
      return table;

    }
  </script>
@endpush
