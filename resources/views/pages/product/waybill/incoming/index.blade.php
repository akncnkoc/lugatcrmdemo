@extends('layout.default')
@section('page-title')
  @lang('pages/waybill.incoming_waybill')
@endsection
@section('toolbar')
  <x-tooltip-button :title="__('pages/waybill.incoming_waybill_add_hint')" data-create-button>
    @include('components.icons.create')
    @lang('globals/words.add')
  </x-tooltip-button>
@endsection
@section('content')
  @include('pages.product.waybill.incoming.create')
  @include('pages.product.waybill.incoming.edit')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">@lang('pages/waybill.incoming_waybill_list')</x-slot>
      <x-slot name="toolbar">
        <div class="d-flex space-x-2">
          @include('pages.product.waybill.incoming.filter')
          @include('pages.product.waybill.incoming.export')
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
          <th>@lang('globals/words.number')</th>
          <th>@lang('layout/aside/menu.supplier')</th>
          <th>@lang('pages/waybill.waybill_sale_total')</th>
          <th>@lang('pages/waybill.product_count')</th>
          <th>@lang('globals/words.date')</th>
          <th class="text-center min-w-100px">@lang('globals/words.actions')</th>
        </x-table.thead>
        <x-table.tbody></x-table.tbody>
      </x-table.table>
    </x-slot>
  </x-card.card>
@endsection
@section('scripts')
  <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
  <script src="{{asset('plugins/custom/formrepeater/formrepeater.bundle.js')}}"></script>
@endsection
@push('customscripts')
  <script type="text/javascript">
    const IncomingWaybillIndexTemplate = function () {
      const table = $("table");
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
              url: '{{ route('incoming-waybill.table') }}',
              type: 'POST',
              data: function (d) {
                for (const [key, value] of Object.entries(data)) {
                  d[key] = value;
                }
              }
            },
            columns: [
              {
                data: 'DT_RowIndex',
                name: "id"
              },
              {
                data: "id",
                name: "id"
              },
              {
                data: "supplier.name",
                name: "supplier.name",
              },
              {
                data: "waybill_totaled_prices",
                name: "waybill_totaled_prices"
              },
              {
                data: "totaled_entered_product",
                name: "totaled_entered_product"
              },
              {
                data: 'date',
                name: "date"
              },
              {
                data: null
              }
            ],
            columnDefs: [
              {
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
                    </div>
                  `;
                },
              }
            ],
            order: [
              [1, 'desc']
            ],
          },
          deleteAjaxUrl: "{{ route('incoming-waybill.delete') }}",
          deleteRowText: "@lang('globals/check_messages.want_to_delete', ['attr' => __('pages/waybill.incoming_waybill')])",
          loadingText: "@lang('globals/infos.loading')",
          deleteSuccessText: "@lang('globals/success_messages.deleted', ['attr' => __('pages/waybill.incoming_waybill')])",
          deleteErrorText: "@lang('globals/error_messages.delete_error', ['attr'  => __('pages/waybill.incoming_waybill')])"
        })
      }
      return {table,initData};
    }();

    IncomingWaybillIndexTemplate.initData();

  </script>
@endpush
