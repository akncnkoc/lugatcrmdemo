<div class="modal fade"
     tabindex="-1"
     id="{{$id}}" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-scrollable {{$size}}">
    <div class="modal-content" id="{{$id}}_target">
      <div class="modal-header">
        <h5 class="modal-title">{!! $title !!}</h5>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
             data-bs-dismiss="modal"
             aria-label="Close">
          <span class="svg-icon svg-icon-2x">
            @include('components.icons.close')
          </span>
        </div>
      </div>
      @isset($body)
        <div class="modal-body ">
          {!! $body !!}
        </div>
      @endisset
      @isset($footer)
        <div class="modal-footer">
          <button type="button"
                  class="btn btn-light"
                  data-bs-dismiss="modal">Kapat
          </button>

          {!! $footer !!}
        </div>
      @endisset
    </div>
  </div>
</div>
