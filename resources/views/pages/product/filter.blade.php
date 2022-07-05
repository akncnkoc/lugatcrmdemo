<x-form.form id="filter_form">
  <a class="btn btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="left-start">
    <i class="las la-filter fs-2"></i>
    @lang('globals/words.filter')
  </a>
  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-1000px py-5 px-8" data-kt-menu="true">
    <div class="fs-3 mb-4">@lang('layout/aside/menu.supplier')</div>
    <div class="row row-cols-3">
      <x-form.input name="filter_name" :label="__('globals/words.name')" :placeholder="__('globals/words.name')"/>
      <x-form.input name="filter_model_code" :label="__('globals/words.model_code')" :placeholder="__('globals/words.model_code')"/>
      <x-form.select :label="__('globals/words.product_type')" name="filter_product_type_id" :asyncload="route('product_type.select')"/>
    </div>
    <div class="fs-3 mb-4">@lang('globals/words.stock') & @lang('layout/aside/menu.supplier')</div>
    <div class="row row-cols-3">
      <x-form.input name="filter_min_stock" :label="__('globals/words.min_stock')" :placeholder="__('globals/words.min_stock')"/>
      <x-form.input name="filter_max_stock" :label="__('globals/words.max_stock')" :placeholder="__('globals/words.max_stock')"/>
      <x-form.select :label="__('layout/aside/menu.supplier')" name="filter_suppliers" :asyncload="route('supplier.select')" multiple parent="#filter_form"/>
    </div>
    <div class="fs-3 mb-4">@lang('globals/words.pricing')</div>
    <div class="row row-cols-4">
      <x-form.input name="filter_min_buy_price" :label="__('globals/words.min_buy_price')" :placeholder="__('globals/words.min_buy_price')" money/>
      <x-form.select :label="__('globals/words.min_buy_price_safe')" name="filter_min_buy_price_safe_id" :asyncload="route('safe.select')"/>
      <x-form.input name="filter_max_buy_price" :label="__('globals/words.max_buy_price')" :placeholder="__('globals/words.max_buy_price')" money/>
      <x-form.select :label="__('globals/words.max_buy_price_safe')" name="filter_max_buy_price_safe_id" :asyncload="route('safe.select')"/>
    </div>
    <div class="row row-cols-4">
      <x-form.input name="filter_min_sale_price" :label="__('globals/words.min_sale_price')" :placeholder="__('globals/words.min_sale_price')" money/>
      <x-form.select :label="__('globals/words.min_sale_price_safe')" name="filter_min_sale_price_safe_id" :asyncload="route('safe.select')"/>
      <x-form.input name="filter_max_sale_price" :label="__('globals/words.max_sale_price')" :placeholder="__('globals/words.max_sale_price')" money/>
      <x-form.select :label="__('globals/words.max_sale_price_safe')" name="filter_max_sale_price_safe_id" :asyncload="route('safe.select')"/>
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
    const ProductFilterTemplate = function (){
      let name = $('input[name="filter_name"]'),
        model_code = $('input[name="filter_model_code"]'),
        min_stock = $('input[name="filter_min_stock"]'),
        max_stock = $('input[name="filter_max_stock"]'),
        filter_min_buy_price = $('input[name="filter_min_buy_price"]'),
        filter_min_buy_price_safe = $(".filter_min_buy_price_safe_id_select"),
        filter_max_buy_price = $('input[name="filter_max_buy_price"]'),
        filter_max_buy_price_safe = $(".filter_max_buy_price_safe_id_select"),
        filter_min_sale_price = $('input[name="filter_min_sale_price"]'),
        filter_min_sale_price_safe = $(".filter_min_sale_price_safe_id_select"),
        filter_max_sale_price = $('input[name="filter_max_sale_price"]'),
        filter_max_sale_price_safe = $(".filter_max_sale_price_safe_id_select"),
        filter_suppliers = $(".filter_suppliers_select"),
        product_type = $(".filter_product_type_id_select");
      const init = () => {
        $("#filter_form").filterForm({
          onClear: function () {
            name.val("");
            model_code.val("");
            min_stock.val("");
            max_stock.val("");
            filter_min_buy_price.val("");
            filter_min_buy_price_safe.val(null).trigger('change');
            filter_max_buy_price.val("");
            filter_max_buy_price_safe.val(null).trigger('change');
            filter_min_sale_price.val("");
            filter_min_sale_price_safe.val(null).trigger('change');
            filter_max_sale_price.val("");
            filter_max_sale_price_safe.val(null).trigger('change');
            filter_suppliers.val(null).trigger('change');
            product_type.val(null).trigger('change');
            ProductIndexTemplate.initData({});
          },
          onFilter: function () {
            let name_val = name.val(),
              model_code_val = model_code.val(),
              min_stock_val = min_stock.val(),
              max_stock_val = max_stock.val(),
              min_buy_price_val = filter_min_buy_price.val(),
              min_buy_price_safe_val = filter_min_buy_price_safe.val(),
              max_buy_price_val = filter_max_buy_price.val(),
              max_buy_price_safe_val = filter_max_buy_price_safe.val(),
              min_sale_price_val = filter_min_sale_price.val(),
              min_sale_price_safe_val = filter_min_sale_price_safe.val(),
              max_sale_price_val = filter_max_sale_price.val(),
              max_sale_price_safe_val = filter_max_sale_price_safe.val(),
              suppliers_val = filter_suppliers.val(),
              product_type_id = product_type.val();
            ProductIndexTemplate.initData({
              name: name_val,
              model_code: model_code_val,
              product_type: product_type_id,

              buy_price_min: min_buy_price_val,
              buy_price_min_safe: min_buy_price_safe_val,
              buy_price_max: max_buy_price_val,
              buy_price_max_safe: max_buy_price_safe_val,

              sale_price_min: min_sale_price_val,
              sale_price_min_safe: min_sale_price_safe_val,
              sale_price_max: max_sale_price_val,
              sale_price_max_safe: max_sale_price_safe_val,

              min_stock: min_stock_val,
              max_stock: max_stock_val,
              suppliers: suppliers_val
            });
          }
        });
      }
      return {init};
    }();

    ProductFilterTemplate.init();
  </script>
@endpush
