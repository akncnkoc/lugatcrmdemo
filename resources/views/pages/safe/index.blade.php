@extends('layout.default')
@section('page-title')
  Kasalar
@endsection
@section('toolbar')
  <a class="btn btn-bg-light btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" data-bs-placement="top"
     data-bs-toggle="tooltip" title="Yeni Kasa Ekle" data-create-button>
    <i class="las la-edit fs-3"></i>
    Ekle
  </a>
@endsection
@section('content')
  @include('pages.safe.create')
  @include('pages.safe.edit')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">Kasa Listesi</x-slot>
      <x-slot name="toolbar">
        <div class="d-flex space-x-2">
          @include('pages.safe.filter')
          @include('pages.safe.export')
        </div>
      </x-slot>
    </x-slot>
    <x-slot name="body">
      <x-table.table id="table">
        <x-table.thead>
          <th>No</th>
          <th>Ad</th>
          <th>Para Birimi</th>
          <th>Total</th>
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
    var table = initSafeTable();
    $(document).on('click', '[data-create-button]', function (event) {
      event.preventDefault();
      $("#create_modal").modal("show");
    });
    $(document).on('click', '[data-edit-button]', function (event) {
      event.preventDefault();
      $("#edit_modal").data("editId", $(this).data('editButton')).modal("show");
    });

    function initSafeTable(data = {}) {
      if (table) table.destroy();
      table = $("#table").DataTable({
        serverSide: true,
        processing: true,
        stateSave: true,
        ajax: {
          url: '{{ route('safe.table') }}',
          type: 'POST',
          data: function (d) {
            for (const [key, value] of Object.entries(data)) {
              d[key] = value;
            }
          }
        },
        columns: [
          {
            data: "id",
            name: "id"
          },
          {
            data: "name",
            name: "name",
          },
          {
            data: "currency.name",
            name: "currency"
          },
          {
            data: "total",
            name: "total"
          },
          {
            data: null
          }
        ],
        columnDefs: [
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
              <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-delete-button="${row.id}" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Sil">
                @include('components.icons.delete')
              </button>
            `;
            },
          }
        ],
        order: [
          [0, 'desc']
        ],
      })
      let handleDeleteRows = () => {
        const deleteButtons = document.querySelectorAll('[data-delete-button]');
        deleteButtons.forEach(d => {
          d.addEventListener('click', function (e) {
            e.preventDefault();
            const parent = e.target.closest('tr');
            const safe_name = parent.querySelectorAll('td')[1].innerText;
            const id = parent.querySelectorAll('td')[0].innerText;
            Swal.fire({
              text: safe_name + " adlı kasayı silmek istiyor musunuz ?",
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
                  url: "{{ route('safe.delete') }}",
                  type: "POST",
                  data: {
                    id: id
                  },
                  beforeSend: function () {
                    Swal.fire({
                      text: safe_name + " adlı kasa , faturaları, giderleri ve ödemeye dayalı işlemler siliniyor...",
                      icon: "info",
                      buttonsStyling: false,
                      showConfirmButton: false,
                    })
                  },
                  success: function (data) {
                    Swal.close();
                    Swal.fire({
                      text: "Kasa silindi",
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
                      text: "Kasa silinemedi tekrar deneyin!",
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
