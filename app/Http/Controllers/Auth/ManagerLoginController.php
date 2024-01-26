<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerLoginController extends Controller
{
  use AuthenticatesUsers;

  protected $redirectTo = '/home';

  public function __construct()
  {
    $this->middleware('guest:manager')->except('logout');
  }
  protected function attemptLogin(Request $request)
  {
    return $this->guard('manager')->attempt(
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
    return view('auth.manager-login', ['pageConfigs' => $pageConfigs]);
  }

  protected function guard()
  {
    return Auth::guard('manager');
  }
}
