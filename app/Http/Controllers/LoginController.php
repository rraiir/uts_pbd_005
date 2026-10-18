<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Controller login/logout. Logika lengkap di tahap 2.
class LoginController extends Controller
{
    // Tampilkan form login
    public function index()
    {
        // Kalau sudah login, redirect ke dashboard sesuai role
        if (session()->has('iduser')) {
            return $this->redirectByRole(session('role'));
        }
        return view('auth.login');
    }

    // Proses autentikasi login dengan SHA2(?, 256)
    public function proses(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (!$username || !$password) {
            return back()->with('error', 'Username dan password wajib diisi.')->withInput();
        }

        // Cari user dengan raw SQL dan binding ?
        $users = DB::select(
            'SELECT u.iduser, u.username, r.nama_role 
             FROM user u 
             JOIN role r ON u.idrole = r.idrole 
             WHERE u.username = ? AND u.password = SHA2(?, 256) 
             LIMIT 1',
            [$username, $password]
        );

        if (count($users) === 0) {
            return back()->with('error', 'Username atau password salah.')->withInput();
        }

        $user = $users[0];

        // Layar Kasir dan Supervisor belum dibuat (sesuai aturan)
        if (in_array($user->nama_role, ['Kasir', 'Supervisor'])) {
            return back()->with('error', 'Layar untuk role ' . $user->nama_role . ' belum tersedia.')->withInput();
        }

        // Simpan iduser, username, dan role ke session
        $request->session()->put('iduser', $user->iduser);
        $request->session()->put('username', $user->username);
        $request->session()->put('role', $user->nama_role);

        return $this->redirectByRole($user->nama_role);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }

    // Redirect ke dashboard sesuai role
    private function redirectByRole($role)
    {
        return match ($role) {
            'Admin'   => redirect('/admin/dashboard'),
            'Manager' => redirect('/manager/dashboard'),
            'Gudang'  => redirect('/gudang/dashboard'),
            default   => redirect('/login'),
        };
    }
}
