<?php
/**
 * 登录 控制器
 */
namespace app\admin\controller;
use app\admin\controller\BaseController;

class LoginController extends BaseController
{
	protected $beforeActionList = [
		'isLogin' => ['except' => 'login'],
		// 'clearUrl' => ['only' => 'login'],
	];
	/**
	 * 管理员登录
	 */
	public function login()
	{
		if (request() -> isPost()) {
			// 验证验证码
			$data = input('post.');
			$result = model('Admin') -> getAdminByName($data['name']);
			if ($result) {
				if ($result['password'] != $this -> encryptString($data['password'])) {
					$this -> error('密码错误!');
				}else{
					session('id', $result['id']);
					session('name', $result['name']);
					// if (session('url')){
					// 	$this -> redirect(session('url'));
					// }
					$this -> success('登录成功!', url('Index/index'));
				}
			}else{
				$this -> error('用户信息错误!');
			}
		}
		return view();
	}
	/**
	 * 退出登录
	 */
	public function logout()
	{
		$this -> clearSession();
		$this -> success('退出登录成功!', 'Login/login');
	}
	/**
	 * 更改密码
	 */
	public function changePass(int $id)
	{
		if (request() -> isPost()) {
			$result = model('Admin') -> getAdminById($id);
			if (is_null($result)) { // 查询数据没有的话就是null 不会是false
				$this -> error('管理员信息不存在!');
			}
			$data = input('post.');
			$this -> checkData('Admin', 'update', $data); // 验证数据
			if ($result['password'] != $this -> encryptString($data['password'])){
				$this -> error('账号密码错误!');
			}
			$repass = $this -> encryptString($data['repassword']);
			if ($repass == $result['password']) {
				$this -> error('两次输入的密码一致!');
			}
			$updateData['password'] = $this -> encryptString($data['repassword']);
			$updateResult = model('Admin') -> updateById($id,$updateData); // 更新成功返回1，也就是影响行数,失败返回false
			if ($updateResult !== false) {
				$this -> success('修改密码成功!', 'Index/index');
			} else {
				$this -> error('修改密码失败!');
			}
		}
		return view();
	}

}