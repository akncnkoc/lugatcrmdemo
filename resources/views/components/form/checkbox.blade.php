<div class="fv-row mb-5">
  <div class="form-check form-switch form-check-custom form-check-solid">
    <input class="form-check-input"
           type="checkbox"
           value=""
           id="{{$name}}_checkbox"
           name="{{$name}}"
           @if($checked) checked @endif />
    <label class="form-check-label"
           for="{{$name}}_checkbox">
      <span @class(['required' => $required])>{{$label}}</span>
      @if($hint)
        <i class="fas fa-exclamation-circle ms-2 fs-7"
           data-bs-toggle="tooltip"
           title="{{$hint}}"
           data-bs-original-title="{{$hint}}"
           aria-label="{{$hint}}"></i>
      @endisset
    </label>
  </div>
</div>
