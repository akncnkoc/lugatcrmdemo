@extends('layout.default')
@section('page-title')
  Ürünler
@endsection
@section('toolbar')
  <button class="btn btn-bg-light btn-sm btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark"
          data-bs-placement="top" data-bs-toggle="tooltip" title="Yeni Ürün Ekle" data-create-button>
    <i class="las la-edit fs-3"></i>
    Ekle
  </button>
@endsection
@section('content')
  @include('pages.product.edit')
  @include('pages.product.create')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">Ürün Listesi</x-slot>
      <x-slot name="toolbar">
        <div class="d-flex space-x-2">
          @include('pages.product.filter')
          @include('pages.product.export')
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
          <th>Ürün Adı</th>
          <th>Model Kodu</th>
          <th>Ürün Tipi</th>
          <th>Stok</th>
          <th>Alış Fiyatı</th>
          <th>Satış Fiyatı</th>
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
        stateSave: true,
        select: {
          style: 'multi',
          selector: 'td:first-child input[type="checkbox"]',
          className: 'row-selected'
        },
        ajax: {
          url: '{{ route('product.table') }}',
          type: 'POST',
          data: data
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
            name: "name"
          },
          {
            data: "model_code",
            name: "model_code"
          },
          {
            data: "product_type.name",
            name: "product_type.name"
          },
          {
            data: 'real_stock'
          },
          {
            data: 'buy_price',
            orderable: false,
            render: function (data, meta, row, type) {
              return row.buy_price + " " + row.buy_price_safe.currency.code;
            }
          },
          {
            data: 'sale_price',
            orderable: false,
            render: function (data, meta, full, type) {
              return full.sale_price + " " + full.sale_price_safe.currency.code;
            }
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
              <a href="{{url('/product')}}/${row.id}/log" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Kayıtlar">
                @include('components.icons.log')
              </a>
              <a href="{{url('/product')}}/${row.id}/report" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Ürün Raporu">
                @include('components.icons.report')
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
            const product_name = parent.querySelectorAll('td')[2].innerText;
            const id = parent.querySelectorAll('td')[1].innerText;
            Swal.fire({
              text: product_name + " adındaki ürünü silmek istiyor musunuz?",
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
                  url: "{{ route('product.delete') }}",
                  type: "POST",
                  data: {
                    id: id
                  },
                  beforeSend: function () {
                    Swal.fire({
                      text: product_name +
                        " adındaki ürün siliniyor...",
                      icon: "info",
                      buttonsStyling: false,
                      showConfirmButton: false,
                    })
                  },
                  success: function (data) {
                    Swal.close();
                    Swal.fire({
                      text: "Ürün silindi",
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
                      text: "Ürün silinemedi tekrar deneyin!",
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
