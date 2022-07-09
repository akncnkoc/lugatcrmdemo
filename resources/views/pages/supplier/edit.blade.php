<x-modal.modal id="edit_modal" size="modal-lg">
  <x-slot name="title">Tedarikçi Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="edit_form">
      <div class="row row-cols-1">
        <x-form.input name="name" label="Ad (Ünvan)" placeholder="Ad (Ünvan)" required/>
        <x-form.input name="email" label="Email" placeholder="Email"/>
        <x-form.input name="phone" label="Telefon" placeholder="Telefon"/>
      </div>
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>

@push('customscripts')
  <script>
    const SupplierEditTemplate = function () {
      let id;
      let edit_modal = $("#edit_modal");
      let modal_target = document.querySelector("#edit_modal_target");
      let block_ui_modal_target = new KTBlockUI(modal_target);
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
      const formValidated = (form) => {
        let data = $(form).serializeArray();
        data.push({
          name: "id",
          value: id
        });
        $.ajax({
          url: "{{ route('supplier.update') }}",
          type: "POST",
          data: data,
          success: function (data) {
            edit_modal.modal("hide");
            SupplierIndexTemplate.initData();
            toastr.success("Başarılı!");
          },
          error: function (err) {
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      };
      const showModalAction = function (e) {
        id = $(e.target).data('itemId');
        $.ajax({
          url: "{{ route('supplier.get') }}",
          data: {
            id
          },
          type: "POST",
          beforeSend: () => {
            block_ui_modal_target.block();
          },
          success: function (data) {
            $(form).find('input[name="name"]').val(data.name);
            $(form).find('input[name="email"]').val(data.email);
            $(form).find('input[name="phone"]').val(data.phone);
            block_ui_modal_target.release();
          },
          error: function (){
            edit_modal.modal('hide');
            toastr.error('Hata var tekrar deneyin')
          }
        });
      }
      let {form} = validateBasicForm("edit_form", validations, formValidated);
      return {edit_modal, showModalAction};
    }();
    SupplierEditTemplate.edit_modal.on('shown.bs.modal', SupplierEditTemplate.showModalAction);
  </script>
@endpush
