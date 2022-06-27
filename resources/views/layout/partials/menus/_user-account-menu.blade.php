<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
  <div class="menu-item px-5">
    <a href="#" class="menu-link px-5" id="logout-btn">@lang('globals/words.logout')</a>
  </div>
</div>

@push('customscripts')
  <script>
    $("#logout-btn").click(function () {
      $.ajax({
        type: "POST",
        url: "{{route('auth.logout')}}",
        success: function () {
          localStorage.removeItem("_api_token");
          window.location.href = '{{route('auth.login')}}'
        },
        error: function (err) {
          toastr.error('@lang('globals/errors.logout_error')');
        }
      });
    });
  </script>
@endpush
