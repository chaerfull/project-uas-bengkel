<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        return view('customer.login');
    }

    public function showRegister()
    {
        return view('customer.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:customers,email'],
            'phone' => ['required','string','max:20'],
            'password' => ['required','confirmed', Rules\Password::defaults()],
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);

        Auth::guard('customer')->login($customer);

        $request->session()->regenerate();

        return redirect()->route('customer.dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('customer')->attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        return view('customer.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }
}