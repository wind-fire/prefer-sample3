<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /* 用户通用头像 gravatar
     *
     * */
    public function gravatar($size = 140)
    {
        /*使用$this->attributes['email'] 或者 $this->email 没有本质上的区别，
        $this->email 在框架底层还是会调用 $this->attributes['email]
        当使用 $user->email时, 因为 User.php 和它所继承的类(父类或者 trait) 中都没有email这个属性,这时候会调用 Model类 的 __get() 这个魔术方法。
        */
        $hash = md5(strtolower($this->attributes['email']));
//        $hash = md5(strtolower($this->email));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }


}
