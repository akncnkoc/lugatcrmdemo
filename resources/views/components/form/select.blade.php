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
  >
    @if(!$multiple)
      <option value="">Seç</option>
    @endif
    @if($options)
      {!! $options !!}
    @endif
  </select>
</div>
@push('customscripts')
  <script type="text/javascript">
    @if($options)
    $(".{{$className}}").select2({
      searchInputPlaceholder: '{{$label}} Arayın',
      @if($parent) dropdownParent: $("{{$parent}}"), @endif
      language: "tr",
      placeholder: "{{$label}}",
      allowClear: true,
      minimumResultsForSearch: 1,
    });
    @else
    $(".{{$className}}").select2({
      searchInputPlaceholder: '{{$label}} Arayın',
      @if($parent) dropdownParent: $("{{$parent}}"), @endif
      @if($multiple) tags: true, @endif
      language: "tr",
      placeholder: "{{$label}}",
      allowClear: true,
      minimumResultsForSearch: 1,
      ajax: {
        url: '{{$asyncload}}',
        dataType: 'json',
        method: 'post',
        delay: 250,
        data: function (params) {
          return {
            search: params.term,
            page: params.page || 1,
            _token: "{{csrf_token()}}",
          };
        },
        processResults: function (data, params) {
          params.page = params.page || 1;
          return {
            results: data.results,
            pagination: {
              more: (params.page * 10) < data.total
            }
          };
        }
      }
    });
    @endif

  </script>
@endpush
