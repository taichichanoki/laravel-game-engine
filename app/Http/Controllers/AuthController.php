<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\hash;

class AuthController extends Controller
{
    public function showTitle()
    {
        $savedSlots = [];
        if(Auth::check()){
            $savedSlots = Save::where('user_id', Auth::id())->get()->keyBy('slot');
        }
        return view('title', compact('savedSlots'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/')->with('status', 'プレイヤー登録が完了しました！');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if(Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))){
            $request->session()->regenerate();

            return redirect('/')->with('status', 'ログインしました。');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'ログアウトしました。');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        if($user->role === 'admin'){
            return redirect('/')->with('status', '管理者のデータはこの画面では削除できません。');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/')->with('status', 'プレイヤーデータを完全に削除しました。');
    }
}
