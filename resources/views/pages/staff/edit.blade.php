<x-modal.modal id="edit_modal">
  <x-slot name="title">Gider Düzenle</x-slot>
  <x-slot name="body">
    <x-form.form id="edit_form">
      <div class="row row-cols-2">
        <x-form.input name="name" label="Ad (Ünvan)" placeholder="Ad (Ünvan)" required />
        <x-form.input name="surname" label="Soyad" placeholder="Soyad" />
      </div>
      <div class="row row-cols-2">
        <x-form.input name="email" label="Email" placeholder="Email" />
        <x-form.input name="phone" label="Telefon" placeholder="Telefon" />
      </div>
      <div class="row row-cols-2">
        <x-form.input name="salary" label="Maaş" placeholder="Maaş" money />
        <x-form.select name="salary_safe_id" :asyncload="route('safe.select')" editing label="Maaş Kasası" placeholder="Maaş Kasası" hint="Personel'e hangi kasadan ödeme yapılacak ise onu seçin." parent="#create_modal" />
      </div>
      <div class="row row-cols-2">
        <x-form.select name="staff_role_id" label="Rol" placeholder="Rol" editing :asyncload="route('staff_role.select')" parent="#edit_modal" required />
        <div class="d-flex align-items-center">
          <x-form.radio label="Cinsiyet" checked="1" name="gender" hint="Eğer personel bir firma yada tüzel kişiyşe diğeri seçin" :items="['Erkek' => 1, 'Kadın' => 2, 'Diğer' => 3]" />
        </div>
      </div>
      <x-form.textarea name="comment" label="Yorum" />
      <x-form.button>Kaydet</x-form.button>
    </x-form.form>
  </x-slot>
</x-modal.modal>

@push('customscripts')
  <script>
    var id;
    var blockUI = new KTBlockUI(document.querySelector("#edit_modal_target"));
    $("#edit_modal").on('shown.bs.modal', function(e) {
      id = $(e.target).data('editId');
      $.ajax({
        url: "{{ route('staff.get') }}",
        data: {
          id
        },
        type: "POST",
        beforeSend: () => {
          blockUI.block();
        },
        success: function(data) {
          $(editForm).find('input[name="name"]').val(data.name);
          $(editForm).find('input[name="surname"]').val(data.surname);
          $(editForm).find('input[name="email"]').val(data.email);
          $(editForm).find('input[name="phone"]').val(data.phone);
          $(editForm).find('input[name="salary"]').val(data.salary).maskMoney("mask");
          if (data.salary_safe) {
            let salary_safe_option = new Option(data.salary_safe.name, data.salary_safe.id, false, true);
            $(editForm).find('select[name="salary_safe_id"]').html(salary_safe_option);
          }
          if (data.staff_role) {
            let staff_role_option = new Option(data.staff_role.name, data.staff_role.id, false, true);
            $(editForm).find('select[name="staff_role_id"]').html(staff_role_option);
          }
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
            message: "Ad doldurulması zorunludur"
          },
          stringLength: {
            min: 3,
            message: "Ad en az 3 harf'den oluşmak zorundadır."
          }
        }
      },
      staff_role_id: {
        validators: {
          notEmpty: {
            message: "Rol seçilmesi zorunludur."
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
        url: "{{ route('staff.update') }}",
        type: "POST",
        data: data,
        success: function(data) {
          $("#edit_modal").modal("hide");
          table.ajax.reload(null, false);
          toastr.success("Başarılı!");
        },
        error: function(err) {
          toastr.error("Bir sorun var daha sonra tekrar deneyin!");
        }
      });
    }, null, (form, validator) => {
      $(form).find('.staff_role_id_edit_select').on('change', function() {
        validator.revalidateField('staff_role_id');
      });
    });
  </script>
@endpush
