<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminLoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }
    public function login(Request $request){
      $username = $request->username;
      $password = $request->password;
      if (Auth::guard('admin')->attempt(['name' => $username, 'password' => $password])) {
          return redirect('/admin65790');
      }else{
        return back()->withInput();
      }
    }
}
