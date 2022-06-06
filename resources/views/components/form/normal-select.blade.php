@php
  $className = !$editing ? $name."_select" : $name."_edit_select";
@endphp
<div class="mb-5 fv-row">
  <label class="form-label">
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
  <select name="{{$name}}" class="form-select form-select-solid {{$className}}">
  </select>
</div>
