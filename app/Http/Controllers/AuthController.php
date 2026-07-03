<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * SHOW LOGIN PAGE
     */
    public function login()
    {
        // kalau sudah login langsung dashboard
        if (session('isLogin')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * PROCESS LOGIN
     */
    public function processLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:4',
        ]);

        $user = DB::table('users')
            ->where('username', $request->username)
            ->first();

        // user tidak ditemukan
        if (!$user) {
            return back()
                ->withInput()
                ->with('error', 'Username atau password salah.');
        }

        // cek status akun
        if ($user->status !== 'aktif') {
            return back()
                ->withInput()
                ->with('error', 'Akun tidak aktif.');
        }

        // cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withInput()
                ->with('error', 'Username atau password salah.');
        }

        // regenerate session (security)
        $request->session()->regenerate();

        // set session login
        session([
            'isLogin' => true,
            'loginUserId' => $user->id,
            'loginRoleId' => $user->role_id,
            'loginOperatorId' => $user->operator_id,
            'loginName' => $user->name,
            'loginUsername' => $user->username,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Login berhasil.');
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        Session::flush();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}