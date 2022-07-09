@extends('layout.default')
@section('page-title')
  {{\App\AppHelper::possesiveSuffix($supplier->name)}} Ödemeleri
@endsection
@section('toolbar')
  <x-tooltip-button data-create-button>
    @include('components.icons.create')
    @lang('globals/words.add')
  </x-tooltip-button>
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

    const SupplierPaymentIndexTemplate = function (){
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
                  <div data-item-id="${row.id}">
                  @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.edit')."' data-edit-button"])
                  @include('components.icons.edit')
                  @endcomponent
                  @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.delete')."' data-delete-button"])
                  @include('components.icons.delete')
                  @endcomponent
                  </div>`;
                },
              }
            ],
            order: [
              [1, 'desc']
            ],
          },
          deleteAjaxUrl: "{{ route('supplier-payment.delete') }}",
          deleteRowText: "@lang('globals/check_messages.want_to_delete', ['attr' => __('globals/words.staff_payment')])",
          loadingText: "@lang('globals/infos.loading')",
          deleteSuccessText: "@lang('globals/success_messages.deleted', ['attr' => __('globals/words.staff_payment')])",
          deleteErrorText: "@lang('globals/error_messages.delete_error', ['attr'  => __('globals/words.staff_payment')])",
        })
      }
      return {table,initData};
    }();
    SupplierPaymentIndexTemplate.initData();
  </script>
@endpush
