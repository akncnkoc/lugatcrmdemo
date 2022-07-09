<!DOCTYPE html>
<html lang="en">
<head>
  <title>Lügat CRM</title>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta property="og:locale" content="tr_TR"/>
  <meta property="og:type" content="article"/>
  <meta property="og:title" content="Lügat CRM"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
  <link href="{{asset('plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
  <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css"/>

</head>
<body id="kt_body" class="bg-dark">
<div class="d-flex flex-column flex-root">
  <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat
      bgi-size-contain bgi-attachment-fixed" style="background-image: url({{asset('media/backgrounds/dark.png')}})">
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
      <a href="{{route('auth.login')}}" class="mb-12">
        <img alt="Logo" src="{{asset('media/logos/logo.png')}}" class="h-40px"/>
      </a>
      <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
        <form class="form w-100" novalidate="novalidate" id="login_form" action="#">
          <div class="text-center mb-10">
            <h1 class="text-dark mb-3">@lang('globals/words.login')</h1>
          </div>
          <div class="text-center mb-10 d-flex align-items-center flex-column justify-content-start">
                <span>@lang('globals/words.demo') @lang('globals/words.email') :
                  <b>demo@mail.com</b>
                </span>
            <span>@lang('globals/words.demo') @lang('globals/words.password') :
                  <b>demo</b>
                </span>
          </div>
          <div class="fv-row mb-10">
            <label class="form-label fs-6 fw-bolder text-dark">@lang('globals/words.email')</label>
            <input class="form-control form-control-lg form-control-solid"
                   type="text"
                   name="email"
                   autocomplete="off"/>
          </div>
          <div class="fv-row mb-10">
            <div class="d-flex flex-stack mb-2">
              <label class="form-label fw-bolder text-dark fs-6 mb-0">@lang('globals/words.password')</label>
            </div>
            <input class="form-control form-control-lg form-control-solid"
                   type="password"
                   name="password"
                   autocomplete="off"/>
          </div>
          <div class="text-center">
            <button type="submit" id="sing_in_submit_button" class="btn btn-lg btn-primary w-100 mb-5 submit">
              <span class="indicator-label">@lang('globals/words.login')</span>
              <span class="indicator-progress">@lang('globals/infos.loading')...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                  </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="{{asset('plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('js/scripts.bundle.js')}}"></script>
<script src="{{asset('lugatjs/app.js')}}"></script>
<script>
  const LoginTemplate = function (){
    let validations = {
      'email': {
        validators: {
          notEmpty: {
            message: '@lang('globals/validation_messages.required', ['field_name' => __('globals/words.email')])'
          },
          emailAddress: {
            message: '@lang('globals/validation_messages.email_provide_required_compatibility_message')'
          }
        }
      },
      'password': {
        validators: {
          notEmpty: {
            message: '@lang('globals/validation_messages.required', ['field_name' => __('globals/words.password')])'
          }
        }
      }
    }
    let formValidated = (form, submitButton) => {
      submitButton.setAttribute('data-kt-indicator', 'on');
      $.ajax({
        type: "POST",
        url: "{{route('auth.authenticate')}}",
        data: {
          email: $("input[name='email']").val(),
          password: $("input[name='password']").val(),
          "_token": "{{csrf_token()}}"
        },
        success: function (data) {
          localStorage.setItem("_api_token", data.token);
          setTimeout(() => {
            window.location.href = "{{route('dashboard.index')}}"
          },750)
          toastr.success("Giriş yapıldı")
        },
        error: function (err) {
          if (err.status === 500) {
            toastr.error("@lang('globals/error_messages.server_error')")
          } else {
            toastr.error("@lang('globals/error_messages.login_error')")
          }
        },
        complete: function () {
          submitButton.setAttribute('data-kt-indicator', 'off');
          submitButton.disabled = false;
        }
      });
    }
    validateBasicForm("login_form", validations, formValidated)
    return {};
  }();


</script>
</body>
</html>
