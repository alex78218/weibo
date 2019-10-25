<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);

        if(Auth::attempt($credentials)) {
            //数据库匹配正确
            session()->flash('success', '欢迎回来=.=');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            //数据库匹配失败
            session()->flash('danger', '密码和邮箱不匹配');
            return redirect()->route('login')->withInput();
        }
        return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '成功退出');
        return redirect()->route('login');
    }
}
