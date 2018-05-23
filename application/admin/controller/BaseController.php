<?php
/**
 * 基础控制器
 */
namespace app\admin\controller;
use think\Controller;
use think\Session;

class BaseController extends Controller
{
    /**
     * 初始化
     */
    public function _initialize()
    {
    }
    /**
     * 判断是否登录
     */
    public function isLogin()
    {
        if(!session('id') || !session('name')){
           $this->error('您尚未登录',url('Login/login'));
        }
    }
	/**
	 * 字符串加密
	 */
	public function encryptString($string)
	{
        return strtoupper(md5(sha1(md5($string.config('encrypt_salt'))).$string));
	}
	/**
     * 数据校验
     */
    public function checkData($model,$scene,$data)
    {
        $validate = validate($model);
        if (!$validate -> scene($scene) -> check($data)) {
            $this -> error($validate -> getError());
        }
    }
    /**
     * 清除session
     */
    public function clearSession()
    {
        session(null);
    }

}