@extends('layout.default')
@section('page-title')
  Anasayfa
@endsection
@section('content')
  <x-card.card>
    <x-slot name="header">
      <x-slot name="title">Anasayfa</x-slot>
    </x-slot>
    <x-slot name="body">
      <x-form.form id="validation_form">
        <x-form.input label="ad" name="name" />
        <x-form.button>Gönder</x-form.button>
      </x-form.form>
    </x-slot>
  </x-card.card>
@endsection

@section('scripts')
  <script type="text/javascript">
    validateForm("validation_form", {
      'name': {
        validators: {
          notEmpty: {
            message: "Ad gereklidir"
          }
        }
      }
    }, () => {
      console.log("validated")
    }, () => {
      console.log("invalidated")
    });
  </script>
@endsection
