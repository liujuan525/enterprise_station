<?php
/**
 * 管理员 校验
 */
namespace app\admin\validate;
use think\Validate;

class Admin extends Validate
{
	/**
	 * 验证规则
	 */
	protected $rule = [
		'name' => 'require|max:25',
		'password' => 'require|min:6',
		'id' => 'require|number',
		'repassword' => 'require|min:6|confirm:password'
	];
	/**
	 * 错误信息
	 */
	protected $message = [
		'name.require' => '账号必须',
		'name.max' => '账号最多不能超过25个字符',
		'password.require' => '密码必须',
		'password.min' => '密码最少不能小于6个字符',
		'id.require' => 'id必须',
		'id.number' => 'id必须为数字',
		'repassword.require' => '密码必须',
		'repassword.min' => '密码最少不能小于6个字符',
		'repassword.confirm' => '两次输入的密码一致'
	];
	/**
	 * 验证场景
	 */
	protected $scene = [
		'add' => ['name', 'password'],
		'delete' => ['id'],
		'edit' => ['name', 'password', 'id'],
		'update' => ['password', 'repassword']
	];

}