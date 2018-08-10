<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //用户注册页面
    public function create()
    {
        return view('users.create');
    }

    //用户个人信息
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    //创建用户
    public function store(Request $request)
    {
        /*验证表单提交数据*/
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        /*保存用户数据*/
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
//        dd($user);
        if($user === [$user]){
            echo "相同";
        }
        return redirect()->route('users.show',$user);
    }

}
