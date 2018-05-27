<?php
/**
 * 用户组 校验
 */
namespace app\admin\validate;
use think\Validate;

class AuthGroup extends Validate
{
	/**
	 * 验证规则
	 */
	protected $rule = [
		'title' => 'require',
	];
	/**
	 * 错误信息
	 */
	protected $message = [
		'title.require' => '权限标题不能为空',
	];
	/**
	 * 验证场景
	 */
	protected $scene = [
		'add' => ['title'],
		'edit' => ['title'],
	];

}