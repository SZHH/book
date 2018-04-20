<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\User;
use think\Request;
use think\Session;

class UserController extends Controller
{
	public function index()
	{
		return $this->fetch();
	}
	public function jump(Request $request)
	{
		$data = User::where('username',$request->post('username'))
		->where('password',$request->post('password'))
		->find();
		if($data){
			Session::set('id',$data->id);
			Session::set('username',$data->username);
			Session::set('authority',$data->authority);
			return $this->fetch();
		}else{
			echo '用户名或密码错误！<br>';
			echo '<a href="/user">重新登录</a>';
			echo '&nbsp;&nbsp;<a href="/user/register">注册</a>';
		}
	}
	public function register()
	{
		return $this->fetch();
	}
	public function doregister(Request $request)
	{
		if($request->post('password') == $request->post('confirmed')){
			$user = new User;
			$user->username = $request->post('username');
			$user->password = $request->post('password');
			$user->authority = 2;
			if ($user->save()) {
				echo '用户[ ' . $user->username . ' ]注册成功<br>';
				echo '<a href="/user">点此登录</a>';
			} else {
				return $user->getError();
			}
		}else{
			echo '两次输入的密码不一致！<br>';
			echo '<a href="/user/register">重新输入</a>&nbsp;&nbsp;';
			echo '<a href="/index">返回主页</a>';
		}
	}
	public function logout()
	{
		Session::delete('id');
		Session::delete('username');
		Session::delete('authority');
		return $this->fetch();
	}
}
