<div class="mb-5 fv-row">
  <label for="{{$name}}"
    @class([
    'form-label',
    'fw-bold',
    'fs-6',
    'mb-2',
    'required' => $required,
    ])
  >{!! $label !!}</label>
  <input type="{{$type}}"
         name="{{$name}}"
         @class([
          'form-control',
          'form-control-solid',
          'mb-3',
          'mb-lg-0',
          'money_input' => $money,
          "datetime-picker" => $date
          ])
         placeholder="{{$placeholder}}"
         @if($value) value="{{$value}}" @endif
         @if($disabled) disabled @endif
    @isset($attributes) {!! $attributes !!} @endisset
  />
</div>

@once
  @section('scripts')
    @parent
    <script src="https://npmcdn.com/flatpickr/dist/l10n/tr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script>
      $(function () {
        flatpickr.setDefaults({
          dateFormat: "d-m-Y",
          "locale": "tr",
          allowInput: true,
          altInput: true,
        })

        $(".datetime-picker").each(function (index, item) {
          $(item).flatpickr();
        });
        $(".money_input").each(function (index, item) {
          $(item).maskMoney({thousands: ".", decimal: ",", allowZero: true, affixesStay: false, allowNegative: false});
          $(item).maskMoney("mask");
        });
      });
    </script>
  @endsection
@endonce
