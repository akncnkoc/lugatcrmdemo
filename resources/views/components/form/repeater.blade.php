<div id="{{$id}}" class="mb-5">
  <div data-repeater-list="{{$id}}">
    @isset($body)
      <div data-repeater-item style="@if($template) display:none @endif" class="{{$id}}_repeater">
        {!! $body !!}
      </div>
    @endisset
  </div>
  @if(!$template)
    <div class="form-group">
      <a href="javascript:;" data-repeater-create class="btn btn-info fs-5">
        <i class="la la-plus"></i>
        {{$buttonText}}
      </a>
    </div>
  @endif
</div>
