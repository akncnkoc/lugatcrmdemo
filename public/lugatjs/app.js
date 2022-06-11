function validateForm(formid, validations, onValid = null, onInvalid = null, loadAfter = null) {
  const form = document.getElementById(formid);
  let validator = FormValidation.formValidation(form, {
    fields: {
      ...validations
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap: new FormValidation.plugins.Bootstrap5({
        rowSelector: '.fv-row',
        eleInvalidClass: '',
        eleValidClass: ''
      }),
    }
  });
  const submitButton = form.getElementsByClassName('submit')[0];
  submitButton.addEventListener('click', function (e) {
    submitButton.setAttribute('data-kt-indicator', 'on');
    e.preventDefault();
    if (validator) {
      validator.validate().then(function (status) {
        if (status == 'Valid') {
          onValid && onValid(form, submitButton);
          submitButton.disabled = true;
          submitButton.removeAttribute('data-kt-indicator');
        } else {
          submitButton.disabled = false;
          submitButton.removeAttribute('data-kt-indicator');
          onInvalid && onInvalid(form);
        }
      });
    }
  });
  loadAfter && loadAfter(form, validator);
  return {form, validator};
}

if ($.fn.dataTable) {

  $.extend($.fn.dataTable.defaults, {
    // "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
    language: {
      "sDecimal": ",",
      "sEmptyTable": "Tabloda herhangi bir veri mevcut değil",
      "sInfo": "",
      "sInfoEmpty": "Kayıt yok",
      "sInfoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
      "sInfoPostFix": "",
      "sInfoThousands": ".",
      "sLengthMenu": "_MENU_",
      "sLoadingRecords": "Yükleniyor...",
      "sProcessing": "Yükleniyor...",
      "sSearch": "Ara:",
      "sZeroRecords": "Eşleşen kayıt bulunamadı",
      "oPaginate": {
        "sFirst": "İlk",
        "sLast": "Son",
        "sNext": "Sonraki",
        "sPrevious": "Önceki"
      },
      "oAria": {
        "sSortAscending": ": artan sütun sıralamasını aktifleştir",
        "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
      },
      "select": {
        "rows": {
          "0": "",
          "1": "1 kayıt seçildi",
          "_": "%d kayıt seçildi"
        }
      }
    },
    lengthMenu: [5, 10, 25, 50, 100, 250, 500, 1000],
    pageLength: 5
  })
}
toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": true,
  "progressBar": true,
  "positionClass": "toastr-top-center",
  "preventDuplicates": true,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

moment.locale('tr');

var Defaults = $.fn.select2.amd.require('select2/defaults');

$.extend(Defaults.defaults, {
  searchInputPlaceholder: ''
});

var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');

var _renderSearchDropdown = SearchDropdown.prototype.render;

SearchDropdown.prototype.render = function (decorated) {

  // invoke parent method
  var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));

  this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));

  return $rendered;
};
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
    'token':  localStorage.getItem('_api_token')
  }
});
