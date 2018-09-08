<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class UsersController extends Controller
{

  /*Laravel 中间件 (Middleware) 为我们提供了一种非常棒的过滤机制来过滤进入应用的 HTTP 请求，
  例如，当我们使用 Auth 中间件来验证用户的身份时，如果用户未通过身份验证，则 Auth 中间件会把用户重定向到登录页面。
  如果用户通过了身份验证，则 Auth 中间件会通过此请求并接着往下执行。Laravel 框架默认为我们内置了一些中间件，例如身份验证、CSRF 保护等。
  所有的中间件文件都被放在项目的 app/Http/Middleware 文件夹中。*/
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['show','create','store','index','confirmEmail'],
        ]);

        $this->middleware('guest',[
            'only' => ['create'],
        ]);
    }

    public function index()
    {
//        $users = User::all();
        $users = User::paginate(10);
        return view('users.index',compact('users'));

    }


    //用户注册页面
    public function create()
    {
        return view('users.create');
    }

    //用户个人信息
    public function show(User $user)
    {
        $statuses = $user->status()
                    ->orderBy('created_at','desc')
                    ->paginate(30);
        return view('users.show', compact('user','statuses'));
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
       /* if($user === [$user]){
            echo "相同";
        }*/


//        Auth::login($user);
        $this->sendConfirmEmail($user);
        session()->flash('success','欢迎，您将开启一段新的旅程');
        return redirect()->route('users.show',$user);
    }

    //编辑用户信息页面
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));

    }

    /*更新用户信息 */
    public  function update(User $user,Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        /*$user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);*/
        $this->authorize('update',$user);
        $data = [];
        $data['name'] = $request->name;
        if ($request->password){
            $data['password'] = $request->password;
        }
        $user->update($data);

        session()->flash('success','个人资料更新成功！');
        return redirect()->route('users.show',$user->id);
    }

    /*删除用户*/
    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','用户删除成功');
        return back();
    }

    /*发送激活邮件*/
    protected function sendConfirmEmail($user)
    {
       /* $view = 'emails.confirm';
        $from = 'fire199010@gmail.com';
        $name = 'PreferMa';
        $data = compact('user');
        $to = $user->email;
        $subject = '感谢注册 Sample 应用 ，请确认您的邮箱';

        Mail::send($view,$data,function($message) use($from,$name,$to,$subject) {
            $message->from($from,$name)->to($to)->subject($subject);

        });*/

        /*现在我们已经在环境配置文件完善了邮件的发送配置，因此不再需要使用 from 方法：*/

        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }



    /*用户激活*/
    public function confirmEmail($token)
    {
        $user = User::where('activation_token',$token)->firstOrfail();

        $user->activated = true;
        $user->activation_token = null;

        $user->save();

        Auth::login($user);
        session()->flash('success','恭喜您激活成功');
        return redirect()->route('users.show',[$user]);
    }




}
