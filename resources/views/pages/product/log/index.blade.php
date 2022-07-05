@extends('layout.default')
@section('page-title')
  @lang('pages/product.product_logs', ["attr" => $product->name])
@endsection
@section('content')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">@lang('pages/product.product_list')</x-slot>
      <x-slot name="toolbar">
        <div class="d-flex space-x-2">
          @include('pages.product.export')
        </div>
      </x-slot>
    </x-slot>
    <x-slot name="body">
      <x-table.table id="table">
        <x-table.thead>
          <th>@lang('globals/words.number')</th>
          <th>@lang('globals/words.content')</th>
          <th>@lang('globals/words.process_type')</th>
          <th>@lang('globals/words.date')</th>
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
    const ProductLogIndexTemplate = function () {
      let table = $("#table");
      let datatableColumns = [
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
      ];
      const initData = (data = {}) => {
        table.initDatatable({
          datatableValues: {
            serverSide: true,
            processing: true,
            stateSave: true,
            ajax: {
              url: '{{ route('product_log.table', $product->id) }}',
              type: 'POST',
              data: data
            },
            columns: datatableColumns,
          }
        })
      }
      return {initData};
    }();

    ProductLogIndexTemplate.initData();

  </script>
@endpush
