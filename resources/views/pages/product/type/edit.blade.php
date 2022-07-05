<x-modal.modal id="product_type_edit_modal">
  <x-slot name="title">Ürün Tipi Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="product_type_edit_form">
      <div class="row row-cols-1">
        <x-form.input name="name" label="Ad (Ünvan)" placeholder="Ad (Ünvan)" required/>
        <x-form.input name="initial_code" label="Başlangıç Kodu" placeholder="Başlangıç Kodu" required/>
      </div>
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    const ProductTypeEditTemplate = function (){
      let id;
      let modal = $("#product_type_edit_modal");
      let modal_target = document.querySelector("#product_type_edit_modal_target");
      let block_ui_modal_target = new KTBlockUI(modal_target);
      let validations ={
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
        },
        initial_code: {
          validators: {
            notEmpty: {
              message: "Başlangıç kodu doldurulması zorunludur"
            }
          }
        }
      };
      const showAction =  (e) => {
        id = $(e.target).data('itemId');
        $.ajax({
          url: "{{ route('product_type.get') }}",
          data: {
            id
          },
          type: "POST",
          beforeSend: () => {
            block_ui_modal_target.block();
          },
          success: function (data) {
            $(form).find('input[name="name"]').val(data.name);
            $(form).find('input[name="initial_code"]').val(data.initial_code);
            block_ui_modal_target.release();
          },
          error: function (err){
            $(e.target).modal('hide');
            toastr.error("@lang('globals/error_messages.fetch_error', ['attr' => __('globals/words.product_type')])")
          }
        });
      }
      let formValidated = (form) => {
        let data = $(form).serializeArray();
        data.push({
          name: "id",
          value: id
        });
        $.ajax({
          url: "{{ route('product_type.update') }}",
          type: "POST",
          data: data,
          success: function (data) {
            modal.modal("hide");
            ProductTypeIndexTemplate.initData();
            toastr.success("Başarılı!");
          },
          error: function (err) {
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      };
      const {form} = validateBasicForm("product_type_edit_form", validations, formValidated);
      return {modal, showAction};
    }();
    ProductTypeEditTemplate.modal.on('shown.bs.modal', ProductTypeEditTemplate.showAction);
  </script>
@endpush
