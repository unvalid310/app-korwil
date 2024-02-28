<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AuthController extends Controller
{
    use HasRoles;

    public function auth() {
        return view('pages.auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $data = User::where('email', $request->email)->first();
            $role = Auth::user()->getRoleNames();
            $userData = [
                'userId' => $data['id'],
                'name' => $data['name'],
                'isLogin' => true,
                'role' => $role,
                'id_sekolah' => $data['id_sekolah'],
            ];

            $request->session()->regenerate();
            $request->session()->put($userData);

            return redirect()->intended('/');
        }

        return back()->with('loginError', '<strong>Login gagal,</strong> periksa kembali email dan password anda!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
