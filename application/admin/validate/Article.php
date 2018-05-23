<?php
/**
 * 文章 验证器
 */
namespace app\admin\validate;
use think\Validate;

class Article extends Validate
{
	/**
	 * 验证规则
	 */
	protected $rule = [
		'title' => 'require',
		'author' => 'require',
		'content' => 'require',
		'category_id' => 'require|number',
	];
	/**
	 * 错误信息
	 */
	protected $message = [
		'title.require' => '文章标题不能为空',
		'author.require' => '文章作者不能为空',
		'content.require' => '文章内容不能为空',
		'category_id.require' => '文章所属栏目不能为空',
		'category_id.number' => '栏目类型错误',
	];
	/**
	 * 验证场景
	 */
	protected $scene = [
		'add' => ['title','category_id','content','author'],
		'edit' => ['title','category_id','content','author'],
	];
}