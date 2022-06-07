<script>var hostUrl = "{{asset('')}}"</script>
<script src="{{asset("plugins/global/plugins.bundle.js")}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/tr.js"></script>
<script src="{{asset("js/scripts.bundle.js")}}"></script>
@yield('scripts')
<script src="{{asset("lugatjs/app.js")}}"></script>
@stack('customscripts')
