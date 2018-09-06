<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{

    /*中间件，只让未登录用户访问登录页面：*/
    public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create'],
        ]);
    }

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
            if(Auth::user()->activated) {
                session()->flash('success', '欢迎回来');
                /*redirect() 实例提供了一个 intended 方法，该方法可将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，
                当上一次请求记录为空时，跳转到默认地址上。*/
                return redirect()->intended(route('users.show', [Auth::user()]));
            }else{
                Auth::logout();
                session()->flash('warning', '您的账户未激活，请检查注册邮件进行激活');
                redirect('/');
            }
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
