@extends('layout.default')
@section('page-title')
  Giderler
@endsection
@section('toolbar')
  <a class="btn btn-bg-light btn-icon-info btn-text-info" id="createbutton" data-bs-custom-class="tooltip-dark" data-bs-placement="top"
    data-bs-toggle="tooltip" title="Yeni Gider Ekle" data-create-button>
    <i class="las la-edit fs-3"></i>
    Ekle
  </a>
@endsection
@section('content')
  @include('pages.expense.create')
  @include('pages.expense.edit')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">Gider Listesi</x-slot>
      <x-slot name="toolbar">
        <div class="d-flex space-x-2">
          @include('pages.expense.filter')
          @include('pages.expense.export')
        </div>
      </x-slot>
    </x-slot>
    <x-slot name="body">
      <x-table.table id="table">
        <x-table.thead>
          <th class="w-10px pe-2">
            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
              <input class="form-check-input" type="checkbox" data-kt-check="true"
                data-kt-check-target="#table .form-check-input" value="1" />
            </div>
          </th>
          <th>No</th>
          <th>Gider Tipi</th>
          <th>Kasa</th>
          <th>Tutar</th>
          <th>Fiş Tarihi</th>
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
    var table = initTable();

    function initTable(data = {}) {
      if (table) table.destroy();
      table = $("#table").DataTable({
        serverSide: true,
        processing: true,
        stateSave:true,
        select: {
          style: 'multi',
          selector: 'td:first-child input[type="checkbox"]',
          className: 'row-selected'
        },
        ajax: {
          url: '{{ route('expense.table') }}',
          type: 'POST',
          data: function(d) {
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
            data: "expense_type.name",
            name: "expense_type.name"
          },
          {
            data: "safe.name",
            name: "safe.name"
          },
          {
            data: 'price'
          },
          {
            data: 'date'
          },
          {
            data: null
          }
        ],
        columnDefs: [{
            targets: 0,
            orderable: false,
            render: function(data) {
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
            render: function(data, type, row) {
              return `
                <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-edit-button="${row.id}">
                @include('components.icons.edit')
                </button>
                <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-delete-button="${row.id}">
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
          d.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = e.target.closest('tr');
            const expense_type_name = parent.querySelectorAll('td')[2].innerText;
            const id = parent.querySelectorAll('td')[1].innerText;
            Swal.fire({
              text: expense_type_name + " türündeki gideri silmek istoyor musunuz ?",
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
                  url: "{{ route('expense.delete') }}",
                  type: "POST",
                  data: {
                    id: id
                  },
                  beforeSend: function() {
                    Swal.fire({
                      text: expense_type_name + " türündeki gider siliniyor...",
                      icon: "info",
                      buttonsStyling: false,
                      showConfirmButton: false,
                    })
                  },
                  success: function(data) {
                    Swal.close();
                    Swal.fire({
                      text: "Gider silindi",
                      icon: "success",
                      buttonsStyling: false,
                      confirmButtonText: "Tamam",
                      customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                      }
                    })
                    table.ajax.reload();
                  },
                  error: function(err) {
                    Swal.close();
                    Swal.fire({
                      text: "Gider silinemedi tekrar deneyin!",
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
        $('[data-create-button]').click(function(event) {
          event.preventDefault();
          $("#create_modal").modal("show");
        });
        $('[data-edit-button]').click(function(event) {
          event.preventDefault();
          $("#edit_modal").data("editId", $(this).data('editButton')).modal("show");
        });
        KTMenu.createInstances();
        handleDeleteRows();
      });
      return table;
    }
  </script>
@endpush
