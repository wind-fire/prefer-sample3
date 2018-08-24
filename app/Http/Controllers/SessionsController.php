<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    //登录界面
    public function create()
    {
        return view('sessions.create');

    }
    //创建会话 （登录）
    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email'=>'required|email|max:255',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials,$request->has('remember'))){
            session()->flash('success','欢迎回来');
            return redirect()->route('users.show',[Auth::user()]);
        } else {
            session()->flash('danger','很抱歉，你的邮箱和密码不匹配');
            return redirect()->back();
        }
    }
    //销毁回话 （退出登录）
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已安全退出');
        return redirect('login');
    }

}