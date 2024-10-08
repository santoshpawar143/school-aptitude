<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
   public function showLoginForm()
   {
      return view('auth.login');
   }

   public function login(Request $request)
   {
      $credentials = $request->validate([
         'email' => 'required|email',
         'password' => 'required'
      ]);

      if (Auth::attempt($credentials)) {
         $user = Auth::user();
         if ($user) {
            return redirect()->intended('/home');
         } else {
            Auth::logout();
            return back()->withErrors(['email' => 'Unauthorized access']);
         }
      }
      return back()->withErrors(['email' => 'Invalid credentials']);
   }

   public function logout(Request $request)
   {
      Auth::logout();

      $request->session()->invalidate();

      $request->session()->regenerateToken();

      return redirect('/');
   }
}
