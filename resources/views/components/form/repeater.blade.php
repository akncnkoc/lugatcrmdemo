<div id="{{$id}}" class="mb-5">
  <div data-repeater-list="{{$id}}">
    @isset($body)
      <div data-repeater-item style="@if($template) display:none @endif" class="{{$id}}_repeater">
        {!! $body !!}
      </div>
    @endisset
    @isset($items)
      {!! $items !!}
    @endisset
  </div>
  @if(!$template)
    <div class="form-group">
      <a href="javascript:" data-repeater-create class="btn btn-sm btn-info">
        @include('components.icons.create')
        {{$buttonText}}
      </a>
    </div>
  @endif
</div>
