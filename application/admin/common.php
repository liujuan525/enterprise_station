<?php
/**
 * 公共方法类
 */

	/**
	 * 根据类型值获取栏目名称
	 */
	function getCategoryType($type)
	{
		switch ($type) {
			case '1':
				return '文章列表';
				break;
			case '2':
				return '单页';
				break;
			case '3':
				return '图片列表';
				break;
			default:
				return '未知类型';
				break;
		}
	}
	/**
	 * 根据配置类型值获取配置类型
	 */
	function getConfType($type)
	{
		switch ($type) {
			case '1':
				return '单行文本';
				break;
			case '2':
				return '多行文本';
				break;
			case '3':
				return '单选按钮';
				break;
			case '4':
				return '复选框';
				break;
			case '5':
				return '下拉菜单';
				break;
			default:
				return '未知类型';
				break;
		}
	}

	function stringToArray($string)
	{
		if ($string) {
			$arr = explode('，', $string);
		}
		return $arr;
	}








