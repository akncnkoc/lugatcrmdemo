function validateBasicForm(formid, validations, onValid = null, onInvalid = null, loadAfter = null) {
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
        if (status === 'Valid') {
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
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    'token': localStorage.getItem('_api_token')
  }
});


$.fn.filterForm = function (options) {
  let defaults = {
    onClear: null,
    clearButtonSelector: "[data-filter-clear-button]",
    onFilter: null,
    filterButtonSelector: "[data-filter-button]",
  }
  let settings = $.extend({}, defaults, options);

  this.submit((e) => e.preventDefault());
  this.find(settings.clearButtonSelector).click((e) => (settings.onClear && typeof settings.onClear === "function") && settings.onClear(e))
  this.find(settings.filterButtonSelector).click((e) => (settings.onFilter && typeof settings.onFilter === "function") && settings.onFilter(e))
  return this;
}

$.fn.initDatatable = function (options) {
  let defaults = {
    filterValues: {},
    datatableValues: {},
    createButtonSelector: "[data-create-button]",
    createModalSelector: "#create_modal",
    editButtonSelector: "[data-edit-button]",
    editModalSelector: "#edit_modal",
    editDataSelector: "editButton",
    deleteDataSelector: "[data-delete-button]",
    deleteAjaxUrl: "",
    deleteRowText: "Delete",
    loadingText: "Loading",
    deleteSuccessText: "Deleted",
    deleteErrorText: "Error Deleted",
  }
  let settings = $.extend({}, defaults, options);

  $(document).on('click', settings.createButtonSelector, function (event) {
    event.preventDefault();
    $(settings.createModalSelector).modal("show");
  })
  $(document).on('click', settings.editButtonSelector, function (event) {
    event.preventDefault();
    $(settings.editModalSelector).data("editId", $(this).data(settings.editDataSelector)).modal("show");
  });
  let tableExists = $.fn.DataTable.isDataTable("#" + this.attr('id'));
  if (tableExists) {
    this.DataTable().destroy();
  }
  var table = this.DataTable(settings.datatableValues);
  table.on('draw', () => {
    //Init non dom elements
    $('[data-bs-toggle="tooltip"]').tooltip();
    //TODO: make localization for this method
    //TODO: make this javascript to jquery methods
    //Delete action for row
    const deleteButtons = document.querySelectorAll(settings.deleteDataSelector);
    deleteButtons.forEach(d => {
      d.addEventListener('click', function (e) {
        e.preventDefault();
        const parent = e.target.closest('tr');
        const id = parent.querySelectorAll('td')[1].innerText;
        Swal.fire({
          text: settings.deleteRowText,
          icon: "warning",
          showCancelButton: true,
          buttonsStyling: false,
          //??
          confirmButtonText: "Evet",
          //??
          cancelButtonText: "Hayır",
          customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
          }
        }).then(function (result) {
          if (result.value) {
            $.ajax({
              url: settings.deleteAjaxUrl,
              type: "POST",
              data: {
                id: id
              },
              beforeSend: function () {
                Swal.fire({
                  text: settings.loadingText,
                  icon: "info",
                  buttonsStyling: false,
                  showConfirmButton: false,
                })
              },
              success: function (data) {
                Swal.close();
                Swal.fire({
                  text: settings.deleteSuccessText,
                  icon: "success",
                  buttonsStyling: false,
                  //??
                  confirmButtonText: "Tamam",
                  customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                  }
                })
                table.ajax.reload();
              },
              error: function (err) {
                Swal.close();
                Swal.fire({
                  text: settings.deleteErrorText,
                  icon: "error",
                  buttonsStyling: false,
                  //??
                  confirmButtonText: "Tamam",
                  customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                  }
                });
              }
            });
          }
        });
      })
    });
  });

  return table;
}

