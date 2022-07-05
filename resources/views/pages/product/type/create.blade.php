<x-modal.modal id="product_type_create_modal">
  <x-slot name="title">@lang('globals/words.product_type')</x-slot>
  <x-slot name="body">
    <x-form.form id="product_type_create_form">
      <div class="row row-cols-1">
        <x-form.input name="name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')" required/>
        <x-form.input name="initial_code" :label="__('globals/words.initial_code')" :placeholder="__('globals/words.initial_code')" required/>
      </div>
      <x-form.button>@lang('globals/words.save')</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>
@push('customscripts')
  <script>
    const ProductTypeCreateTemplate = function () {

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
        },
        initial_code: {
          validators: {
            notEmpty: {
              message: "Başlangıç kodu doldurulması zorunludur"
            }
          }
        }
      };
      const formValidated = (form) => {
        let data = $(form).serializeArray();
        $.ajax({
          url: "{{ route('product_type.store') }}",
          type: "POST",
          data: data,
          success: function (data) {
            $("#product_type_create_modal").modal("hide");
            ProductTypeIndexTemplate.initData();
            toastr.success("Başarılı!");
          },
          error: function (err) {
            toastr.error("Bir sorun var daha sonra tekrar deneyin!");
          }
        });
      }
      const init = () => {
        validateBasicForm("product_type_create_form", validations, formValidated);
      }
      return {init};
    }();
    ProductTypeCreateTemplate.init();
  </script>
@endpush
