<x-modal.modal id="edit_modal">
  <x-slot name="title">Kasa Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="edit_form">
      <div class="row row-cols-1">
        <x-form.input name="name" label="Ad" placeholder="Ad" required/>
        <x-form.input name="total" label="Şunki Total" placeholder="Şuanki Total" money disabled/>
        <x-form.select :asyncload="route('currency.select')" name="currency_id" label="Para Birimi" required
                       disabled
                       parent="#edit_modal"
                       editing
                       hint="Para birimi kasanın hangi kuru kullancagını belirtir."
        />
        <x-form.button>Kaydet</x-form.button>
      </div>
    </x-form.form>
  </x-slot>
</x-modal.modal>

@push('customscripts')
  <script>
    const SafeEditTemplate = function (){
      let id;
      let block_ui_edit_modal_target = new KTBlockUI(document.querySelector("#edit_modal_target"));
      let modal_show_action = function (e) {
        id = $(e.target).data('editId');
        $.ajax({
          url: "{{ route('safe.get') }}",
          data: {
            id
          },
          type: "POST",
          beforeSend: () => {
            block_ui_edit_modal_target.block();
          },
          success: function (data) {
            if(data && editForm){
              $(editForm).find('input[name="name"]').val(data.name);
              $(editForm).find('input[name="total"]').val(data.total)
                .maskMoney({thousands: ".", decimal: ",", allowZero: true, affixesStay: false, allowNegative: true})
                .maskMoney('mask');
              if (data.currency) {
                let currency_option = new Option(data.currency.name, data.currency.id, false, true);
                $(editForm).find('select[name="currency_id"]').html(currency_option);
              }
            }

            block_ui_edit_modal_target.release();
          },
          error: {}
        });
      }
      let validations = {
        name: {
          validators: {
            notEmpty: {
              message: "Ad doldurulması zorunludur"
            },
            stringLength: {
              min: 3,
              message: "Ad en az 3 harf'den oluşmak zorundadır."
            }
          }
        }
      };
      let valid_form_action = (form) => {
        let data = $(form).serializeArray();
        let customizedData = [];
        customizedData.push({
          name: "id",
          value: id
        });
        customizedData.push({
          name: "name",
          value: data[0].value
        });
        $.ajax({
          url: "{{ route('safe.update') }}",
          type: "POST",
          data: customizedData,
          success: function (data) {
            $("#edit_modal").modal("hide");
            table.ajax.reload(null, false);
            toastr.success("Başarılı!");
          },
          error: function (err) {
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      };
      let after_load_action = (form, validator) => {
        $(".currency_id_edit_select").on('change', function () {
          validator.revalidateField('currency_id');
        });
      };

      let {form: editForm} = validateBasicForm("edit_form", validations, valid_form_action, null, after_load_action);

      return {
        modal_show_action,
      }

    }();

    $("#edit_modal").on('shown.bs.modal', SafeEditTemplate.modal_show_action);

  </script>
@endpush
