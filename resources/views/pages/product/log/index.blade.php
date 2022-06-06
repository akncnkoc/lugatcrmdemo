@extends('layout.default')
@section('page-title')
  {{$product->name}} adlı ürünün kayıtları
@endsection
@section('content')
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
          <th>No</th>
          <th>İçerik</th>
          <th>İşlem Tipi</th>
          <th>Kayıt Tarihi</th>
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
        ajax: {
          url: '{{ route('product_log.table', $product->id) }}',
          type: 'POST',
          data: data
        },
        columns: [
          {
            data: "id",
            name: "id"
          },
          {
            data: "content",
            name: "content"
          },
          {
            data: "process_type",
          },
          {
            data: "date"
          }
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
