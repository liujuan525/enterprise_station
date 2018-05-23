<?php
/**
 * 分类 验证器
 */
namespace app\admin\validate;
use think\Validate;

class Category extends Validate
{
	/**
	* 验证规则
	*/
	protected $rule = [
		'category_name' => 'require|max:20',
	];
	/**
	* 错误信息
	*/
	protected $message = [
		'category_name.require' => '栏目名称不得为空!',
		'category_name.max' => '栏目名称最多不能超过20个字节',
	];
	/**
	* 验证场景
	*/
	protected $scene = [
		'add' => ['category_name'],
		'edit' => ['category_name'],
	];
}

