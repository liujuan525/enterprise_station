<?php
/**
 * 权限 校验
 */
namespace app\admin\validate;
use think\Validate;

class AuthRule extends Validate
{
	/**
	 * 验证规则
	 */
	protected $rule = [
		'name' => 'require',
		'title' => 'require|max:20',
	];
	/**
	 * 错误信息
	 */
	protected $message = [
		'name.require' => '权限名不能为空',
		'title.require' => '权限标题不能为空',
		'title.max' => '权限标题最多不能超过20个字符',
	];
	/**
	 * 验证场景
	 */
	protected $scene = [
		'add' => ['name', 'title'],
		'edit' => ['name', 'title'],
	];

}