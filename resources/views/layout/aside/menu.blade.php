<div class="hover-scroll-overlay-y my-5 my-lg-5"
     id="kt_aside_menu_wrapper"
     data-kt-scroll="true"
     data-kt-scroll-activate="{default: false, lg: true}"
     data-kt-scroll-height="auto"
     data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
     data-kt-scroll-wrappers="#kt_aside_menu"
     data-kt-scroll-offset="0">
  <div
    class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
    id="#kt_aside_menu"
    data-kt-menu="true"
    data-kt-menu-expand="false">
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('dashboard.index')}}"
         title="@lang('layout/aside/menu.homepage_hint_title')"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">@lang('layout/aside/menu.homepage')</span>
      </a>
    </div>
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('safe.index')}}"
         title="@lang('layout/aside/menu.safe_hint_title')"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">@lang('layout/aside/menu.safe')</span>
      </a>
    </div>
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
      <span class="menu-link">
        <span class="menu-title">@lang('layout/aside/menu.product')</span>
        <span class="menu-arrow"></span>
      </span>
      <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
          <a class="menu-link" href="{{route('product.index')}}"
             title="@lang('layout/aside/menu.product_hint_title')"
             data-bs-toggle="tooltip"
             data-bs-trigger="hover"
             data-bs-custom-class="tooltip-dark"
             data-bs-dismiss="click"
             data-bs-placement="right">
            <span class="menu-bullet">
              <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">@lang('layout/aside/menu.products')</span>
          </a>
        </div>
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
          <span class="menu-link">
            <span class="menu-bullet">
              <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">@lang('layout/aside/menu.waybill')</span>
            <span class="menu-arrow"></span>
          </span>
          <div class="menu-sub menu-sub-accordion">
            <div class="menu-item">
              <a class="menu-link" href="{{route('incoming-waybill.index')}}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">@lang('layout/aside/menu.incoming_waybill')</span>
              </a>
            </div>
            <div class="menu-item">
              <a class="menu-link" href="{{route('outgoing-waybill.index')}}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">@lang('layout/aside/menu.outgoing_waybill')</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('supplier.index')}}"
         title="@lang('layout/aside/menu.supplier_hint_title')"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">@lang('layout/aside/menu.supplier')</span>
      </a>
    </div>
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('customer.index')}}"
         title="@lang('layout/aside/menu.customer_hint_title')"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">@lang('layout/aside/menu.customer')</span>
      </a>
    </div>
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('staff.index')}}"
         title="@lang('layout/aside/menu.staff_hint_title')"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">@lang('layout/aside/menu.staff')</span>
      </a>
    </div>
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('expense.index')}}"
         title="@lang('layout/aside/menu.expense_hint_title')"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">@lang('layout/aside/menu.expense')</span>
      </a>
    </div>
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('roleandtype.index')}}"
         title="@lang('layout/aside/menu.type_and_role_hint_title')"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">@lang('layout/aside/menu.type_and_role')</span>
      </a>
    </div>
  </div>
</div>
