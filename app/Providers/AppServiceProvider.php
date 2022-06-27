<?php

namespace App\Providers;

use App;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Session;

class AppServiceProvider extends ServiceProvider
{
  public function register()
  {
    //
  }

  public function boot()
  {
    if (Session::get("locale") !== null) {
      Carbon::setLocale(Session::get('locale'));
      App::setLocale(Session::get('locale'));
    } else {
      Carbon::setLocale(app()->getLocale());
    }
  }
}
