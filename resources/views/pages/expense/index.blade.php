@extends('layout.default')
@section('page-title')
  Giderler
@endsection
@section('toolbar')
  <x-tooltip-button :title="__('pages/expense.expense_add')" data-create-button>
    @include('components.icons.create')
    @lang('pages/expense.expense_add')
  </x-tooltip-button>
@endsection
@section('content')
  @include('pages.expense.create')
  @include('pages.expense.edit')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">@lang('pages/expense.expense_list')</x-slot>
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
                     data-kt-check-target="#table .form-check-input" value="1"/>
            </div>
          </th>
          <th>@lang('globals/words.number')</th>
          <th>@lang('globals/words.expense_type')</th>
          <th>@lang('layout/aside/menu.safe')</th>
          <th>@lang('globals/words.price')</th>
          <th>@lang('globals/words.date')</th>
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
    const ExpenseIndexTemplate = function () {
      let table = $("#table");
      const initData = (data = {}) => {
        const datatableColumns = [
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
            data: 'customer_role.name',
            name: "customer_role.name"
          },
          {
            data: null
          }
        ];
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
              url: "{{ route('customer.table') }}",
              type: 'POST',
              data: function (d) {
                for (const [key, value] of Object.entries(data)) {
                  d[key] = value;
                }
              }
            },
            columns: datatableColumns,
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
                  </div>`;
                },
              }
            ],
            order: [
              [1, 'desc']
            ],
          },
          deleteAjaxUrl: "{{ route('expense.delete') }}",
          deleteRowText: "@lang('globals/check_messages.want_to_delete', ['attr' => __('globals/words.expense')])",
          loadingText: "@lang('globals/infos.loading')",
          deleteSuccessText: "@lang('globals/success_messages.deleted', ['attr' => __('globals/words.expense')])",
          deleteErrorText: "@lang('globals/error_messages.delete_error', ['attr'  => __('globals/words.expense')])",
        });
      }
      return {table, initData};
    }();
    ExpenseIndexTemplate.initData();
  </script>
@endpush
