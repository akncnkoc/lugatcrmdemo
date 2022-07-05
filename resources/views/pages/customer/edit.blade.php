<x-modal.modal id="edit_modal">
  <x-slot name="title">@lang('pages/customer.customer_edit')</x-slot>
  <x-slot name="body">
    <x-form.form id="edit_form">
      <div class="row row-cols-2">
        <x-form.input name="name"
                      :label="__('globals/words.name')"
                      :placeholder="__('globals/words.name')"
                      required/>
        <x-form.input name="surname"
                      :label="__('globals/words.surname')"
                      :placeholder="__('globals/words.surname')"/>
      </div>
      <div class="row row-cols-2">
        <x-form.input name="email" :label="__('globals/words.email')" :placeholder="__('globals/words.email')"/>
        <x-form.input name="phone" :label="__('globals/words.phone')" :placeholder="__('globals/words.phone')"/>
      </div>
      <div class="row row-cols-2">
        <x-form.select name="customer_role_id"
                       :label="__('globals/words.role')"
                       :placeholder="__('globals/words.role')"
                       editing
                       :asyncload="route('customer_role.select')"
                       parent="#edit_modal"
                       required/>
        <div class="d-flex align-items-center">
          <x-form.radio :label="__('globals/words.gender')"
                        name="gender"
                        hint="@lang('pages/customer.customer_gender_hint')"
                        :items="[__('globals/words.male') => 0, __('globals/words.female') => 1, __('globals/words.other')=> 2]"/>
        </div>
      </div>
      <x-form.textarea name="address" :label="__('globals/words.address')"/>
      <x-form.textarea name="comment" :label="__('globals/words.comment')"/>
      <x-form.button>@lang('globals/words.save')</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>

@push('customscripts')
  <script>
    const EditCustomerTemplate = function () {
      let edit_modal = $("#edit_modal");
      let id;
      let edit_modal_target = document.querySelector("#edit_modal_target");
      let block_ui_model_target = new KTBlockUI(edit_modal_target);

      let validation_rules = {
        name: {
          validators: {
            notEmpty: {
              message: "@lang('globals/validation_messages.required', ['field_name' => __('globals/words.name')])"
            },
            stringLength: {
              min: 3,
              message: "@lang('globals/validation_messages.required', ['field_name' => __('globals/words.name')])"
            }
          }
        },
        customer_role_id: {
          validators: {
            notEmpty: {
              message: "@lang('globals/validation_messages.required', ['field_name' => __('globals/words.role')])"
            }
          }
        }
      };
      let formValidated = (form) => {
        let data = $(form).serializeArray();
        data.push({
          name: "id",
          value: id
        });
        $.ajax({
          url: "{{ route('customer.update') }}",
          type: "POST",
          data: data,
          success: function (data) {
            $("#edit_modal").modal("hide");
            table.ajax.reload(null, false);
            toastr.success("@lang('globals/success_messages.success', ['attr' => __('globals/words.customer')])");
          },
          error: function (err) {
            toastr.error("@lang('globals/error_messages.save_error', ['attr' => __('globals/words.customer')])");
          }
        });
      };
      let formAfterLoaded = (form, validator) => {
        $(form).find('.customer_role_id_edit_select').on('change', function () {
          validator.revalidateField('customer_role_id');
        });
      }
      const showAction = (e) => {
        id = $(e.target).data('itemId');
        $.ajax({
          url: "{{ route('customer.get') }}",
          data: {
            id
          },
          type: "POST",
          beforeSend: () => {
            block_ui_model_target.block();
          },
          success: function (data) {
            if (data) {
              $(form).find('input[name="name"]').val(data.name);
              $(form).find('input[name="surname"]').val(data.surname);
              $(form).find('input[name="email"]').val(data.email);
              $(form).find('input[name="phone"]').val(data.phone);
              $(form).find('input[name="date"]').val(data.date).flatpickr();
              let customer_role_option = new Option(data.customer_role.name, data.customer_role.id, false, true);
              $(form).find('select[name="customer_role_id"]').html(customer_role_option);
              $(form).find('textarea[name="address"]').val(data.address);
              $(form).find('textarea[name="comment"]').val(data.comment);
              console.log(data.gender)
              $(form).find(`input[name="gender"]`).filter(`[value="${data.gender}"]`).prop('checked', true);
            } else {
              $(e.target).modal('hide');
            }
            block_ui_model_target.release();
          },
          error: function (err) {
            $(e.target).modal('hide');
            toastr.error("@lang('globals/error_messages.fetch_error', ['attr' => __('globals/words.customer')])")
          }
        });
      }
      let {form} = validateBasicForm("edit_form", validation_rules, formValidated, null, formAfterLoaded);
      return {edit_modal, showAction};
    }();
    $(EditCustomerTemplate.edit_modal).on('shown.bs.modal', EditCustomerTemplate.showAction);
  </script>
@endpush
