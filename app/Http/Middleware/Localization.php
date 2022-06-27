<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;
use Session;

class Localization
{
  public function handle(Request $request, Closure $next)
  {
    if (Session::has('locale')) {
      App::setLocale(Session::get('locale'));
    }
    return $next($request);
  }
}
