<div class="mb-5 fv-row">
  <label for="{{$name}}" class="form-label">{{$label}}</label>
  <textarea class="form-control form-control form-control-solid" data-kt-autosize="true" id="{{$name}}"
            name="{{$name}}" placeholder="@isset($placeholder) {{$placeholder}} @else {{$label}} @endif"></textarea>
</div>
