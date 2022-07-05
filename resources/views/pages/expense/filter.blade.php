<x-form.form id="filter_form">
  <a class="btn btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="left-start">
    <i class="las la-filter fs-2"></i>
    @lang('globals/words.filter')
  </a>
  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary
  fw-bold w-400px py-5 px-8"
       data-kt-menu="true">
    <div class="row row-cols-1">
      <x-form.select :label="__('globals/words.expense_type')"
                     name="filter_expense_type_id"
                     :asyncload="route('expense_type.select')"/>
    </div>
    <div class="row row-cols-2">
      <x-form.input name="filter_min_price"
                    :label="__('globals/words.min_price')"
                    :placeholder="__('globals/words.min_price')"
                    money/>
      <x-form.input name="filter_max_price"
                    :label="__('globals/words.max_price')"
                    :placeholder="__('globals/words.min_price')"
                    money/>
    </div>
    <div class="row row-cols-2">
      <x-form.input name="filter_min_date"
                    :label="__('globals/words.min_date')"
                    :placeholder="__('globals/words.min_date')"
                    :date="true"/>
      <x-form.input name="filter_max_date"
                    :label="__('globals/words.max_date')"
                    :placeholder="__('globals/words.max_date')"
                    :date="true"/>
    </div>
    <div class="d-flex justify-content-end my-4 gap-2">
      <x-tooltip-button :title="__('globals/words.filter_clear')" data-filter-clear-button>
        @include('components.icons.close')
        @lang('globals/words.clear')
      </x-tooltip-button>
      <x-tooltip-button :title="__('globals/words.filter')" data-filter-button>
        @include('components.icons.filter')
        @lang('globals/words.filter')
      </x-tooltip-button>
    </div>
  </div>
</x-form.form>
@push('customscripts')
  <script type="text/javascript">
    const ExpenseFilterTemplate = function (){
      let min_date = $('input[name="filter_min_date"]'),
        max_date = $('input[name="filter_max_date"]'),
        min_price = $('input[name="filter_min_price"]'),
        max_price = $('input[name="filter_max_price"]'),
        expense_type = $(".filter_expense_type_id_select");
      const init = () => {
        $("#filter_form").filterForm({
          onClear: function (e) {
            min_date.val("");
            max_date.val("");
            min_price.val("");
            max_price.val("");
            expense_type.val(null).trigger('change');
            ExpenseIndexTemplate.initData({});
          },
          onFilter: function (e) {
            e.preventDefault();
            let min_date_val = min_date.val(),
              max_date_val = max_date.val(),
              min_price_val = min_price.val(),
              max_price_val = max_price.val(),
              expense_type_id = expense_type.val();
            ExpenseIndexTemplate.initData({
              min_date: min_date_val,
              max_date: max_date_val,
              expense_type: expense_type_id,
              min_price: min_price_val,
              max_price: max_price_val
            });
          }
        });
      }
      return {init};
    }();

    ExpenseFilterTemplate.init();

    $("[data-export-excel]").click(function () {
    });
  </script>
@endpush
