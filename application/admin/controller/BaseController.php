<?php
/**
 * 基础控制器
 */
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Request;
use app\admin\controller\Auth;

class BaseController extends Controller
{
    /**
     * 初始化
     */
    public function _initialize()
    {
        // $auth = new Auth();
        // $request = Request::instance();

        // $controller = $request -> controller();
        // $action = $request -> action();
        // $name = $controller.'/'.$action;
        // $notCheck=array('Index/index','Admin/list','Login/logout', 'Login/login');
        // if (session('id') != 1 || session('id') != 4) { // 超级管理员
        //     if (!in_array($name, $notCheck)) {
        //         if (!$auth -> check($name, session('id'))) {
        //             $this -> error('没有权限', url('Index/index'));
        //         }
        //     }
        // }
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
    /**
     * 记录登录之前的URL
     */
    public function BeforeLoginUrl()
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; // http://192.168.33.10:8525/admin/index/index.html
        session('url', $url);
    }
    /**
     * 清除登录之前的url
     */
    public function clearUrl()
    {
        session('url', null);
    }
    /**
     * [unique 获取唯一值(大写)]
     */
    public static function unique()
    {
        $key = mt_rand(1,99999).uniqid('bluerose',true).time();
        return strtoupper(md5(md5($key)));
    }
    /**
     * 获取参数
     */
    public function getParameter($param)
    {
        $data = [];
        foreach($param as $key => $value){
            $getValue = input("$value");
            if(!empty($getValue)) {
                $data["$value"] = $getValue;
            }
        }
        return $data;
    }
    /**
     * 校验手机号码 -> lj [2018/04/18]
     */
    public function isMobile($mobile)
    {
        $result = preg_match('/^(13[0-9]|15[012356789]|17[01678]|18[0-9]|14[57])[0-9]{8}$/', $mobile);
        if (!$result) {
            return json(['status' => 10015, 'msg' => '手机号格式错误']);
        }
    }


}