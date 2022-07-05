<x-modal.modal id="create_modal">
  <x-slot name="title">Kasa Ekle</x-slot>
  <x-slot name="body">
    <x-form.form id="create_form">
      <div class="row row-cols-1">
        <x-form.input name="name" label="Ad" placeholder="Ad" required/>
        <x-form.input name="total" label="Başlangıç Totali" placeholder="Başlangıç Totali" required money/>
        <x-form.select :asyncload="route('currency.select')" name="currency_id" label="Para Birimi" required
                       parent="#create_modal"
                       hint="Para birimi kasanın hangi kuru kullancagını belirtir."
        />
      </div>
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    const SafeCreateTemplate = function (){
      let formValidated =  (form) => {
        let data = $(form).serializeArray();
        $.ajax({
          url: "{{ route('safe.store') }}",
          type: "POST",
          data: data,
          success: function (data) {
            $("#create_modal").modal("hide");
            table.ajax.reload(null, false);
            toastr.success("Başarılı!");
          },
          error: function (err) {
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      };
      let formAfterLoaded =  (form, validator) => {
        $(".currency_id_select").on('change', function () {
          validator.revalidateField('currency_id');
        });
      };
      validateBasicForm("create_form", form_validations_container.safe_validation, formValidated, null,formAfterLoaded);
      return {};
    }();

  </script>
@endpush
