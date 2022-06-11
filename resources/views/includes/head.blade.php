<meta charset="utf-8">
<meta name="description" content="Lügat App for Content Management System">
<meta name="Lügat CMS" content="CMS">
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="csrf-token" content="{{csrf_token()}}" />
<title>Lügat CRM</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
@stack('customstyles')
<link rel="stylesheet" href="{{asset('plugins/global/plugins.bundle.css')}}" />
<link rel="stylesheet" href="{{asset('css/style.css')}}" />
<style>
  .space-x-2 > * + * {
    margin-left: 8px;
  }
  .space-y-2 > * + * {
    margin-top: 8px;
  }
  .dataTables_empty{
    text-align: center!important;
  }
  div.dataTables_wrapper div.dataTables_processing {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 200px;
    margin-left: -100px;
    margin-top: -26px;
    text-align: center;
    padding: 1em 0;
  }
</style>
