<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use App\Models\User;

class AuthController extends Controller
{
  public function login()
  {
    return view('pages.auth.login');
  }

  public function authenticate(AuthenticateRequest $request)
  {
    try {
      User::where('email', $request->get('email'))->firstOr(fn() => response()->json(['Mail not found'], 422));
      $user = User::where('email', $request->get('email'))->where('password', \Hash::make($request->get('password'),
      ), 422)
        ->firstOr(fn() => response()->json(['User not found']));

      if (!auth()->attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
        return;
      }

      $token = \auth()->user()->createToken($request->get('email'));
      return response()->json(['token' => $token->plainTextToken]);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  public function logout()
  {
    try {
      auth()->logout();
      return response()->json(true);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }
}
