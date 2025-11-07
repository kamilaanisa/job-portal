<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendWelcomeEmailJob;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        dd('Method register dipanggil!', $request->all());
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Siapkan data user untuk email
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username ?? '-',
            'phone' => $user->phone ?? '-',
        ];

        // Kirim email menggunakan queue
        dispatch(new SendWelcomeEmailJob($userData));

        // Login otomatis setelah registrasi (opsional)
        // auth()->login($user);

        // Redirect dengan pesan sukses
        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk informasi akun.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}