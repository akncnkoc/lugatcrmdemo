<div class="form-group fv-row">
  <label class="form-label">
    <span @class(['required' => $required])>{{ $label }}</span>
    @if ($hint)
      <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
        data-bs-original-title="{{ $hint }}" aria-label="{{ $hint }}"></i>
    @endisset
</label>
<div class="d-flex space-x-2 align-items-center">
  @foreach ($items as $key => $value)
    <div class="form-check form-check-custom form-check-solid me-2">
      <input class="form-check-input" type="radio" value="{{ $value }}" id="{{ $name }}_radio"
        name="{{ $name }}" @if (strval($value) === strval($checked)) checked @endif />
      <label class="form-check-label" for="{{ $name }}">
        {{ $key }}
      </label>
    </div>
  @endforeach
</div>
</div>
