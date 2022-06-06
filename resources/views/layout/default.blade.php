<!doctype html>
<html lang="tr">
<head>
  @include('includes.head')
  @yield('styles')
</head>
<body id="kt_body"
      class=" page-loading-enabled page-loading header-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed "
      style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
@include('layout.partials.loader')
@include('layout.master')
@include('includes.footer')
</body>
</html>
