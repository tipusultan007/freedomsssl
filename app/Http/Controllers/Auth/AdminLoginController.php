<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
  use AuthenticatesUsers;

  protected $redirectTo = '/admin';

  public function __construct()
  {
    $this->middleware('guest:admin')->except('logout');
  }
  protected function attemptLogin(Request $request)
  {
    return $this->guard('admin')->attempt(
      $this->credentials($request), $request->filled('remember')
    );
  }

  public function username()
  {
    return 'phone';
  }
  public function showLoginForm()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('auth.admin-login', ['pageConfigs' => $pageConfigs]);
  }

  protected function guard()
  {
    return Auth::guard('admin');
  }
}
