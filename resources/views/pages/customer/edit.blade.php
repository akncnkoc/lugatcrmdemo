<x-modal.modal id="edit_modal">
  <x-slot name="title">@lang('pages/customer.customer_edit')</x-slot>
  <x-slot name="body">
    <x-form.form id="edit_form">
      <div class="row row-cols-2">
        <x-form.input name="name"
                      :label="__('globals/words.name')"
                      :placeholder="__('globals/words.name')"
                      required />
        <x-form.input name="surname"
                      :label="__('globals/words.surname')"
                      :placeholder="__('globals/words.surname')" />
      </div>
      <div class="row row-cols-2">
        <x-form.input name="email" :label="__('globals/words.email')" :placeholder="__('globals/words.email')" />
        <x-form.input name="phone" :label="__('globals/words.phone')" :placeholder="__('globals/words.phone')" />
      </div>
      <div class="row row-cols-2">
        <x-form.select name="customer_role_id"
                       :label="__('globals/words.role')"
                       :placeholder="__('globals/words.role')"
                       editing
                       :asyncload="route('customer_role.select')"
                       parent="#edit_modal"
                       required />
        <div class="d-flex align-items-center">
          <x-form.radio :label="__('globals/words.gender')"
                        name="gender"
                        hint="@lang('pages/customer.customer_gender_hint')"
                        :items="[__('globals/words.male') => 1, __('globals/words.female') => 2, __('globals/words.other')=> 3]" />
        </div>
      </div>
      <x-form.textarea name="address" :label="__('globals/words.address')" />
      <x-form.textarea name="comment" :label="__('globals/words.comment')" />
      <x-form.button>@lang('globals/words.save')</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>

@push('customscripts')
  <script>
    var id;
    var blockUI = new KTBlockUI(document.querySelector("#edit_modal_target"));
    $("#edit_modal").on('shown.bs.modal', function (e) {
      id = $(e.target).data('editId');
      $.ajax({
        url: "{{ route('customer.get') }}",
        data: {
          id
        },
        type: "POST",
        beforeSend: () => {
          blockUI.block();
        },
        success: function (data) {
          $(editForm).find('input[name="name"]').val(data.name);
          $(editForm).find('input[name="surname"]').val(data.surname);
          $(editForm).find('input[name="email"]').val(data.email);
          $(editForm).find('input[name="phone"]').val(data.phone);
          $(editForm).find('input[name="date"]').val(data.date).flatpickr();
          let customer_role_option = new Option(data.customer_role.name, data.customer_role.id, false, true);
          $(editForm).find('select[name="customer_role_id"]').html(customer_role_option);
          $(editForm).find('textarea[name="address"]').val(data.address);
          $(editForm).find('textarea[name="comment"]').val(data.comment);
          $(editForm).find(`input[name="gender"]`).filter(`[value="${data.gender}"]`).prop('checked', true);
          blockUI.release();
        },
        error: {}
      });
    });
    let {
      form: editForm,
      validator: editValidator
    } = validateForm("edit_form", {
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
    }, (form) => {
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
    }, () => {
    }, (form, validator) => {
      $(form).find('.customer_role_id_edit_select').on('change', function () {
        validator.revalidateField('customer_role_id');
      });
    });
  </script>
@endpush
