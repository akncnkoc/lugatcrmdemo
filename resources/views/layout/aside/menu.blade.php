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
         href="{{route('safe.index')}}"
         title="Şirket içi giderlerini ekleyebileceğin, seçtiğin zaman aralığına göre giderlerinin raporunu görebileciğin bir modül"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">Kasa</span>
      </a>
    </div>
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
      <span class="menu-link">
        <span class="menu-title">Ürün</span>
        <span class="menu-arrow"></span>
      </span>
      <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
          <a class="menu-link" href="{{route('product.index')}}"
             title="Şirket içi giderlerini ekleyebileceğin, seçtiğin zaman aralığına göre giderlerinin raporunu görebileciğin bir modül"
             data-bs-toggle="tooltip"
             data-bs-trigger="hover"
             data-bs-custom-class="tooltip-dark"
             data-bs-dismiss="click"
             data-bs-placement="right">
            <span class="menu-bullet">
              <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Ürünler</span>
          </a>
        </div>
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
          <span class="menu-link">
            <span class="menu-bullet">
              <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">İrsaliye</span>
            <span class="menu-arrow"></span>
          </span>
          <div class="menu-sub menu-sub-accordion">
            <div class="menu-item">
              <a class="menu-link" href="{{route('incoming-waybill.index')}}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Gelen İrsaliye</span>
              </a>
            </div>
            <div class="menu-item">
              <a class="menu-link" href="{{route('outgoing-waybill.index')}}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Giden İrsaliye</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('supplier.index')}}"
         title="update******"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">Tedarikçi</span>
      </a>
    </div>
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('staff.index')}}"
         title="update******"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">Müşteri</span>
      </a>
    </div>
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('staff.index')}}"
         title="update******"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">Personel</span>
      </a>
    </div>
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('expense.index')}}"
         title="Şirket içi giderlerini ekleyebileceğin, seçtiğin zaman aralığına göre giderlerinin raporunu görebileciğin bir modül"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">Gider</span>
      </a>
    </div>
    <div class="menu-item">
      <a class="menu-link"
         href="{{route('roleandtype.index')}}"
         title="Şirket içi giderlerini ekleyebileceğin, seçtiğin zaman aralığına göre giderlerinin raporunu görebileciğin bir modül"
         data-bs-toggle="tooltip"
         data-bs-trigger="hover"
         data-bs-custom-class="tooltip-dark"
         data-bs-dismiss="click"
         data-bs-placement="right">
        <span class="menu-title">Tip & Rol</span>
      </a>
    </div>
  </div>
</div>
