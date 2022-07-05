@extends('layout.default')
@section('page-title')
  @lang('globals/words.safes')
@endsection
@section('toolbar')
  <x-tooltip-button :title="__('globals/words.add')" data-create-button>
    @include('components.icons.create')
    @lang('globals/words.add')
  </x-tooltip-button>
@endsection
@section('content')
  @include('pages.safe.create')
  @include('pages.safe.edit')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">@lang('globals/words.safes')</x-slot>
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
          <th>@lang('globals/words.number')</th>
          <th>@lang('globals/words.name')</th>
          <th>@lang('globals/words.currency')</th>
          <th>@lang('globals/words.total')</th>
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
    let SafeIndexTemplate = function () {
      let table = $("#table");
      let initButtons = () => {
        $(document).on('click', '[data-create-button]', function (event) {
          event.preventDefault();
          $("#create_modal").modal("show");
        });
        $(document).on('click', '[data-edit-button]', function (event) {
          event.preventDefault();
          $("#edit_modal").data("editId", $(this).data('editButton')).modal("show");
        });

      }

      let initTable = (data = {}) => {
        table.initDatatable({
          datatableValues: {
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
            ]
          },
          deleteAjaxUrl: "{{ route('safe.delete') }}",
          deleteRowText: "@lang('globals/check_messages.want_to_delete', ['attr' => __('globals/words.safe')])",
          loadingText: "@lang('globals/infos.loading')",
          deleteSuccessText: "@lang('globals/success_messages.deleted', ['attr' => __('globals/words.safe')])",
          deleteErrorText: "@lang('globals/error_messages.delete_error', ['attr'  => __('globals/words.safe')])"
        })
      }

      return {initButtons, initTable};
    }();

    SafeIndexTemplate.initButtons();
    SafeIndexTemplate.initTable();

  </script>
@endpush
