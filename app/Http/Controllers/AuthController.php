<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use function auth;

class AuthController extends Controller
{
  public function login()
  {
    return view('pages.auth.login');
  }

  public function authenticate(Request $request)
  {
    try {
      User::where('email', $request->get('email'))->firstOr(fn() => response()->json(['Mail not found'])->send());

      if (!auth()->attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
        return response()->json(['error' => 'Email or password incorrect'], 500);
      }

      $token = auth()->user()->createToken($request->get('email'));
      return response()->json(['token' => $token->plainTextToken, 'user' => auth()->user()]);
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  public function logout()
  {
    try {
      auth()->logout();
      return response()->json(true);
    } catch (Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }
}
