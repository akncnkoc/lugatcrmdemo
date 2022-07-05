@extends('layout.default')
@section('page-title')
  @lang('pages/customer.customers')
@endsection
@section('toolbar')
  <x-tooltip-button :title="__('pages/customer.customer_add')" data-create-button>
    @include('components.icons.create')
    @lang('globals/words.add')
  </x-tooltip-button>
@endsection
@section('content')
  @include('pages.customer.create')
  @include('pages.customer.edit')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">@lang('pages/customer.customer_list')</x-slot>
      <x-slot name="toolbar">
        <div class="d-flex space-x-2">
          @include('pages.customer.filter')
          @include('pages.customer.export')
        </div>
      </x-slot>
    </x-slot>
    <x-slot name="body">
      <x-table.table id="table">
        <x-table.thead>
          <th class="w-10px pe-2">
            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
              <input class="form-check-input"
                     type="checkbox"
                     data-kt-check="true"
                     data-kt-check-target="#table .form-check-input"
                     value="1"/>
            </div>
          </th>
          <th>@lang('globals/words.number')</th>
          <th>@lang('globals/words.name') @lang('globals/words.surname')
            <span class="fs-8">(@lang('globals/words.title_0'))</span>
          </th>
          <th>@lang('globals/words.phone')</th>
          <th>@lang('globals/words.email')</th>
          <th>@lang('globals/words.role')</th>
          <th class="text-center min-w-100px">Actions</th>
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
    const CustomerIndexTemplate = function (){
      let table = $("#table");
      let initData = (data = {}) => {
        $(table).initDatatable({
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
              url: '{{ route('customer.table') }}',
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
          deleteAjaxUrl: "{{ route('customer.delete') }}",
          deleteRowText: "@lang('globals/check_messages.want_to_delete', ['attr' => __('globals/words.customer')])",
          loadingText: "@lang('globals/infos.loading')",
          deleteSuccessText: "@lang('globals/success_messages.deleted', ['attr' => __('globals/words.customer')])",
          deleteErrorText: "@lang('globals/error_messages.delete_error', ['attr'  => __('globals/words.customer')])"
        });
      }
      return {initData};
    }();

    CustomerIndexTemplate.initData();
  </script>
@endpush
