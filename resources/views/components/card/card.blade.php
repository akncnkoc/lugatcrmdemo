<div class="card shadow-sm" id="@if($target){{ $target }}@endif">
  @isset($header)
    <div class="card-header">
      @if (isset($title))
        <h3 class="card-title">{{ $title }}</h3>
      @endif
      @isset($toolbar)
        <div class="card-toolbar">
          {!! $toolbar !!}
        </div>
      @endisset
    </div>
  @endisset
  @isset($body)
    <div class="card-body @if ($cardscroll) card-scroll h-{{ $cardscroll }}px @endif">
      {!! $body !!}
    </div>
  @endisset
</div>
