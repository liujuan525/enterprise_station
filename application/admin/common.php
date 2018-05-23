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
			# code...
			break;
	}
}