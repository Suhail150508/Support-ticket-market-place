<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        return view('index');
    }
    
    public function createLogin(Request $request)
    {
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:4|max:22',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['login_error' => 'Invalid credentials or inactive account.'])
                ->withInput($request->except('password'));
        }

        auth()->login($user);

        // Fixed: use auth()->user() with parentheses
        if(auth()->user()->role == 'admin'){
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('tickets.index');
    }

    public function createRegister(Request $request)
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
          'password' => 'required|string|min:4|max:32|confirmed',
          'role' => 'nullable|string|in:user,admin',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role ?? 'user',
        ]);

        auth()->login($user);
        return redirect()->route('tickets.index');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}
