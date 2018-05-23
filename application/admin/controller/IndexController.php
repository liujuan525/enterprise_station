<?php
namespace app\admin\controller;
use app\admin\controller\BaseController;

class IndexController extends BaseController
{
	protected $beforeActionList = [
        // 'isLogin'
    ];
	/**
	 * 后台首页
	 */
    public function index()
    {
        return view();
    }

}