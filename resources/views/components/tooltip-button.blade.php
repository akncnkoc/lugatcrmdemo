<button class="btn btn-bg-light btn-sm btn-icon-info btn-text-info"
        data-bs-custom-class="tooltip-dark"
        data-bs-placement="top"
        data-bs-toggle="tooltip"
        @isset($attributes) {!!  $attributes !!} @endisset>
  {{$slot}}
</button>
