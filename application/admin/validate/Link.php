<?php
/**
 * 链接 验证器
 */
namespace app\admin\validate;
use think\Validate;

class Link extends Validate
{
	/**
	 * 验证规则
	 */
	protected $rule = [
		'link_title' => 'require|max:25',
		'link_url' => 'require|url',
		'link_desc' => 'require',
	];
	/**
	 * 错误信息
	 */
	protected $message = [
		'link_title.require' => '链接标题不能为空',
		'link_title.max' => '链接标题最多不能超过25个字节',
		'link_url.require' => '链接地址不能为空',
		'link_url.url' => '链接地址格式错误',
		'link_desc.require' => '链接描述不能为空',
	];
	/**
	 * 验证场景
	 */
	protected $scene = [
		'add' => ['link_title','link_url','link_desc'],
		'edit' => ['link_title','link_url','link_desc'],
	];

}