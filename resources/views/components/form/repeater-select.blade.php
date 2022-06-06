@php
  $className = !$editing ? $name."_select" : $name."_edit_select";
@endphp
<div class="mb-5 fv-row">
  <label for="{{$className}}"
         class="form-label">
    <span @class(['required' => $required])>{{$label}}</span>
    @if($hint)
      <i class="fas fa-exclamation-circle ms-2 fs-7"
         data-bs-toggle="tooltip"
         data-bs-custom-class="tooltip-dark"
         title=""
         data-bs-original-title="{{$hint}}"
         aria-label="{{$hint}}"></i>
    @endisset
  </label>
  <select class="form-select form-select-solid {{$className}}"
          @if(!$multiple) name="{{$name}}"
          @else name="{{$name}}[]"
          @endif
          @if($multiple) multiple="multiple" @endif
          id="{{$className}}"
          @if($disabled) disabled @endif
          data-dropdown-parent="{{$parent}}"
          data-language="tr"
          data-allowClear="true"
          data-ajax--url="{{$asyncload}}"
          data-ajax--dataType="json"
          data-repeater="select2"
          data-select2-id="{{$name.rand(1,1000000)}}"
          data-ajax--method="post"
          data-ajax--delay="250"
          data-ajax--data='var query = {search: params.term, page: params.page || 1, _token: "{{csrf_token()}}"}; return query;'
          data-ajax--process-results='params.page = params.page || 1;return {results: data.results, pagination: {more: (params.page * 10) < data.total}};'
  >
    @if(!$multiple)
      <option value="">Seç</option>
    @endif
  </select>
</div>
