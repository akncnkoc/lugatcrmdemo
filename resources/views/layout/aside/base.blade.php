<div id="kt_aside"
     class="aside aside-dark"
     data-kt-drawer="true"
     data-kt-drawer-name="aside"
     data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-overlay="true"
     data-kt-drawer-width="{default:'200px', '300px': '250px'}"
     data-kt-drawer-direction="start"
     data-kt-drawer-toggle="#kt_aside_mobile_toggle">
  <div class="aside-logo flex-column-auto" id="kt_aside_logo">
    <a href="?page=index">
      <img alt="Logo" src="{{asset('media/logos/logo.png')}}" class="h-25px logo" />
    </a>
  </div>
  <div class="aside-menu flex-column-fluid">
    @include('layout.aside.menu')
  </div>
</div>

