@extends('layout.default')
@section('page-title')
  Tedarikçiler
@endsection
@section('toolbar')
  <x-tooltip-button data-create-button>
    @include('components.icons.create')
    @lang('globals/words.add')
  </x-tooltip-button>
@endsection
@section('content')
  @include('pages.supplier.create')
  @include('pages.supplier.edit')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">Tedarikçi Listesi</x-slot>
      <x-slot name="toolbar">
        <div class="d-flex space-x-2">
          @include('pages.supplier.filter')
          @include('pages.supplier.export')
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
          <th>Ad <span class="fs-8">(Ünvan)</span></th>
          <th>Email</th>
          <th>Telefon</th>
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
    const SupplierIndexTemplate = function () {
      let table = $("#table");
      const initData = (data = {}) => {
        table.initDatatable({
          datatableValues: {
            serverSide: true,
            processing: true,
            stateSave: true,
            select: {
              style: 'multi',
              selector: 'td:first-child input[type="checkbox"]',
              className: 'row-selected'
            },
            ajax: {
              url: '{{ route('supplier.table') }}',
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
              },
              {
                data: "email",
                name: "email"
              },
              {
                data: "phone",
                name: "phone"
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
                  <div data-item-id="${row.id}">
                  @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.edit')."' data-edit-button"])
                  @include('components.icons.edit')
                  @endcomponent
                  <a href="{{url('/supplier')}}/${row.id}/payment" class="btn btn-icon btn-sm btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Ödemeler">
                @include('components.icons.finance')
                  </a>
                  <a href="{{url('/supplier')}}/${row.id}/regularpayment" class="btn btn-icon btn-sm btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip"
              title="Düzenli Ödemeler">
                @include('components.icons.finance_2')
                  </a>
                  @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.delete')."' data-delete-button"])
                  @include('components.icons.delete')
                  @endcomponent
                  </div>
`;
                },
              }
            ],
            order: [
              [1, 'desc']
            ],
          },
          deleteAjaxUrl: "{{ route('supplier.delete') }}",
          deleteRowText: "@lang('globals/check_messages.want_to_delete', ['attr' => __('globals/words.supplier')])",
          loadingText: "@lang('globals/infos.loading')",
          deleteSuccessText: "@lang('globals/success_messages.deleted', ['attr' => __('globals/words.supplier')])",
          deleteErrorText: "@lang('globals/error_messages.delete_error', ['attr'  => __('globals/words.supplier')])",
        })
      }

      return {table, initData};
    }();

    SupplierIndexTemplate.initData();
  </script>
@endpush
