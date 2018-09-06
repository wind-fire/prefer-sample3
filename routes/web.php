<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/


use Illuminate\Support\Facades\Route;

Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');


//Route::get('/login','UsersController@login')->name('login');
Route::get('/signup','UsersController@create')->name('signup');


/* Laravel 遵循 RESTful 设计原则，将数据看做资源，由 URI 来指定获取。对资源进行获取、创建、修改、删除。分别对应 HTTP 协议
    GET、POST、PATCH、DELETE 方法
 * */
Route::resource('users','UsersController');

/*
 *
 * 上面代码等于以下代码
Route::get('/users', 'UsersController@index')->name('users.index');  //显示所有用户列表页面
Route::get('/users/{user}', 'UsersController@show')->name('users.show'); //显示用户个人信息页面
Route::get('/users/create', 'UsersController@create')->name('users.create'); //创建个人用户账户界面
Route::post('/users', 'UsersController@store')->name('users.store'); //创建个人用户
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit'); //编辑个人用户信息
Route::patch('/users/{user}', 'UsersController@update')->name('users.update'); //更新用户
Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy'); //删除个人用户

*/
Route::get('/login','SessionsController@create')->name('login'); //显示登录界面
Route::post('/login','SessionsController@store')->name('login'); //创建新会话（登录）
Route::delete('/logout','SessionsController@destroy')->name('logout'); //销毁会话（退出登录）

/* 用户激活 */

Route::get('/signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');

