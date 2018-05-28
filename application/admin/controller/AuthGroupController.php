<?php
namespace app\admin\controller;
use app\admin\controller\BaseController;
use app\admin\model\AuthGroup;
use think\Validate;

class AuthGroupController extends BaseController
{
	/**
     * 前置方法
     */
    protected $beforeActionList = [
        'isLogin' // 判断用户是否登录
    ];
	// 管理员信息模型
    protected $authGroup;
    /**
     * 初始化
     */
    public function _initialize()
    {
        $this -> authGroup = new AuthGroup();
    }
	/**
	 * 添加用户组
	 */
	public function add()
	{
		if (request() -> isPost()) {
			$data = input('post.');
			$this -> checkData('AuthGroup', 'add', $data);
			if ($data['rules']) {
				$data['rules'] = implode(',', $data['rules']);
			}
			if (!isset($data['status'])){
				$data['status'] = 0;
			}
			$this -> checkAuthGroup('title', $data['title']);
			$result = $this -> authGroup -> addAuthGroup($data);
			if ($result) {
				$this -> success('添加用户组成功!', url('AuthGroup/list'));
			} else {
				$this -> error('添加用户组失败!');
			}
		}
		$authRuleRes = model('AuthRule') -> getAuthRuleList();
		$this -> assign('authRuleRes', $authRuleRes);
		return view();
	}
	/**
	 * 编辑用户组
	 */
	public function edit()
	{
		$id = input('id/d');
		$groupRes = $this -> checkGroupById($id);
		if (request() -> isPost()) {
			$data = input('post.');
			$this -> checkData('AuthGroup', 'edit', $data);
			if ($data['title'] != $groupRes['title']) {
				$this -> checkAuthGroup('title', $data['title']);
			}
			$result = $this -> authGroup -> updateAuthGroup($data);
			if ($result) {
                $this -> success('更新用户组成功!', url('AuthGroup/list'));
			} else {
				$this -> error('更新用户组失败!');
			}
		}
		$authRuleRes = model('AuthRule') -> getAuthRuleList();
		$this -> assign(['authRuleRes' => $authRuleRes, 'groupRes' => $groupRes]);
		return view();
	}
	/**
	 * 用户组列表
	 */
	public function list()
	{
		$authGroupRes = $this -> authGroup -> getAuthGroupList();
		$this -> assign('authGroupRes', $authGroupRes);
		return view();
	}
	/**
	 * 删除用户组
	 */
	public function delete()
	{
		$id = input('id/d');
		$groupRes = $this -> checkGroupById($id);
		$result = $this -> authGroup -> deleteAuthGroup($id);
		if ($result !== false){
			$this -> success('删除用户组成功!', url('AuthGroup/list'));
		} else {
			$this -> error('删除用户组失败!');
		}
	}
	/**
	 * 查看用户组信息是否存在
	 */
	private function checkAuthGroup($field,$value)
	{
		$res = $this -> authGroup -> getGroupByField($field, $value);
		if ($res) {
			$this -> error('用户组已存在!');
		}
	}
	/**
	 * 校验信息是否存在
	 */
	private function checkGroupById($id){
		$groupRes = $this -> authGroup -> getGroupByField('id', $id);
		if (is_null($groupRes)) {
			$this -> error('用户组信息不存在!');
		}else{
			return $groupRes;
		}
	}
}