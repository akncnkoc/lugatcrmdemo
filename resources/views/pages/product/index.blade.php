@extends('layout.default')
@section('page-title')
  @lang('layout/aside/menu.product')
@endsection
@section('toolbar')
  <x-tooltip-button :title="__('pages/product.product_add')" data-create-button>
    @include('components.icons.create')
    @lang('globals/words.add')
  </x-tooltip-button>
@endsection
@section('content')
  @include('pages.product.edit')
  @include('pages.product.create')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">@lang('pages/product.product_list')</x-slot>
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
          <th>@lang('globals/words.number')</th>
          <th>@lang('globals/words.name')</th>
          <th>@lang('globals/words.model_code')</th>
          <th>@lang('globals/words.product_type')</th>
          <th>@lang('globals/words.stock')</th>
          <th>@lang('globals/words.buy_price')</th>
          <th>@lang('globals/words.sale_price')</th>
          <th class="text-center min-w-100px">@lang('globals/words.actions')</th>
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
    const ProductIndexTemplate = function () {
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
              url: "{{ route('product.table') }}",
              type: 'POST',
              data: data
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
                  <div data-item-id="${row.id}">
                    @component('components.tooltip-icon-button', ["attributes" => "title='".__('globals/words.edit')."' data-edit-button"])
                  @include('components.icons.edit')
                  @endcomponent
                  <a href="{{url('/product')}}/${row.id}/log" class="btn btn-icon btn-sm btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Kayıtlar">
                    @include('components.icons.log')
                  </a>
                  <a href="{{url('/product')}}/${row.id}/report" class="btn btn-icon btn-sm btn-icon-info btn-text-info" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-toggle="tooltip" title="Ürün Raporu">
                    @include('components.icons.report')
                  </a>
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
          deleteAjaxUrl: "{{ route('product.delete') }}",
          deleteRowText: "@lang('globals/check_messages.want_to_delete', ['attr' => __('layout/aside/menu.product')])",
          loadingText: "@lang('globals/infos.loading')",
          deleteSuccessText: "@lang('globals/success_messages.deleted', ['attr' => __('layout/aside/menu.product')])",
          deleteErrorText: "@lang('globals/error_messages.delete_error', ['attr'  => __('layout/aside/menu.product')])"
        })
      }
      return {table, initData};
    }();

    ProductIndexTemplate.initData();
  </script>
@endpush
