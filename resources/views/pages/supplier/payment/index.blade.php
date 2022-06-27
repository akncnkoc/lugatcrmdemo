@extends('layout.default')
@section('page-title')
  {{\App\AppHelper::possesiveSuffix($supplier->name)}} Ödemeleri
@endsection
@section('toolbar')
  <a class="btn btn-bg-light btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" data-bs-placement="top"
     data-bs-toggle="tooltip" title="Yeni Ödeme Ekle" data-create-button>
    <i class="las la-edit fs-3"></i>
    Ekle
  </a>
@endsection
@section('content')
  @include('pages.supplier.payment.create')
  @include('pages.supplier.payment.edit')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">{{\App\AppHelper::possesiveSuffix($supplier->name)}} Ödemeleri</x-slot>
      <x-slot name="toolbar">
        <div class="d-flex space-x-2">
          @include('pages.supplier.payment.filter')
          @include('pages.supplier.payment.export')
        </div>
      </x-slot>
    </x-slot>
    <x-slot name="body">
      <x-table.table id="table">
        <x-table.thead>
          <th class="w-10px pe-2">
            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
              <input class="form-check-input" type="checkbox" data-kt-check="true"
                     data-kt-check-target="#table .form-check-input" value="1"/>
            </div>
          </th>
          <th>No</th>
          <th>Tutar</th>
          <th>İşlem Tipi</th>
          <th>Tarih</th>
          <th class="text-center min-w-50px">İşlemler</th>
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
    var table = initSupplierPaymentsTable();

    function initSupplierPaymentsTable(data = {}) {
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
          url: '{{ route('supplier-payment.table', $supplier->id)}}',
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
            name: "price",
            render: function (data, type, row) {
              if (row.safe && row.safe.currency) {
                return row.price + " " + row.safe.currency.name;
              }
              return "Ödeme bilgisi bulunamadı"
            }
          },
          {
            data: "payable",
            name: "payable",
            render: function (data, type, row) {
              if (row.payable) {
                return `<span class="badge badge-success">Ödendi</span>`;
              }
              return `<span class="badge badge-danger">Ödenmemiş</span>`;
            }
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
          d.addEventListener('click', function (e) {
            e.preventDefault();
            const parent = e.target.closest('tr');
            const payment_price = parent.querySelectorAll('td')[2].innerText;
            const id = parent.querySelectorAll('td')[1].innerText;
            Swal.fire({
              text: payment_price + " değerindeki ödemeyi silmek istoyor musunuz ?",
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
                  url: "{{ route('supplier-payment.delete') }}",
                  type: "POST",
                  data: {
                    id: id
                  },
                  beforeSend: function () {
                    Swal.fire({
                      text: payment_price + " değerindeki ödeme siliniyor...",
                      icon: "info",
                      buttonsStyling: false,
                      showConfirmButton: false,
                    })
                  },
                  success: function (data) {
                    Swal.close();
                    Swal.fire({
                      text: "Ödeme silindi",
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
                      text: "Ödeme silinemedi tekrar deneyin!",
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
        $('[data-create-button]').click(function (event) {
          event.preventDefault();
          $("#create_modal").modal("show");
        });
        $('[data-edit-button]').click(function (event) {
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
