<?php
/**
 * 页 控制器
 */
namespace app\index\controller;
use app\index\controller\BaseController;

class Page extends BaseController
{
	public function page()
	{
		return view();
	}
}