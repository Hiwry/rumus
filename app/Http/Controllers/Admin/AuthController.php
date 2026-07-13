<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'O e-mail é obrigatório.',
            'email.email'       => 'Informe um e-mail válido.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'E-mail ou senha incorretos.'])->withInput();
        }

        $request->session()->put('admin_logged_in', true);
        $request->session()->put('admin_user_id', $user->id);
        $request->session()->put('admin_user_name', $user->name);
        $request->session()->put('admin_user_email', $user->email);

        return redirect()->route('admin.dashboard')->with('success', 'Bem-vindo de volta, ' . $user->name . '!');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_logged_in', 'admin_user_id', 'admin_user_name', 'admin_user_email']);
        return redirect()->route('admin.login')->with('success', 'Você saiu do painel com segurança.');
    }

    public function showChangePassword()
    {
        return view('admin.auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'A senha atual é obrigatória.',
            'new_password.required'     => 'A nova senha é obrigatória.',
            'new_password.min'          => 'A nova senha deve ter pelo menos 6 caracteres.',
            'new_password.confirmed'    => 'A confirmação da nova senha não confere.',
        ]);

        $user = User::find(session('admin_user_id'));

        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Senha alterada com sucesso!');
    }
}
