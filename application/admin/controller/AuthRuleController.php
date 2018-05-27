<?php
namespace app\admin\controller;
use app\admin\controller\BaseController;
use app\admin\model\AuthRule;
use think\Validate;

class AuthRuleController extends BaseController
{
	// 管理员信息模型
    protected $authRule;
    /**
     * 初始化
     */
    public function _initialize()
    {
        $this -> authRule = new AuthRule();
    }
	/**
	 * 添加权限
	 */
	public function add()
	{
		$authRuleRes = $this -> authRule -> getAuthRuleList();
		if (request() -> isPost()){
			$data = input('post.');
			$this -> checkData('AuthRule', 'add', $data);
			$this -> checkAuthRule($data['name'], $data['title']);
			$ruleRes = $this -> authRule -> getRuleByField('id', $data['pid']);
			if ($ruleRes) {
				$data['level'] = $ruleRes['level'] + 1;
			} else {
				$data['level'] = 0;
			}
			$result = $this -> authRule -> addAuthRule($data);
			if ($result) {
				$this -> success('添加权限规则成功!', url('AuthRule/list'));
			} else {
				$this -> error('添加权限规则失败!');
			}
		}
		$this -> assign('authRuleRes', $authRuleRes);
		return view();
	}
	/**
	 * 更新权限
	 */
	public function edit()
	{
		$id = input('id/d');
		$this -> checkRuleById($id);
		if (request() -> isPost()) {
			$data = input('post.');
			$this -> checkData('AuthRule', 'edit', $data);
			if ($data['name'] != $ruleRes['name']) {
				$this -> checkAuthRule($data['name'], 'name');
			}
			if ($data['title'] != $ruleRes['title']) {
				$this -> checkAuthRule($data['title'], 'title');
			}
			$result = $this -> authRule -> updateAuthRule($data);
			if ($result) {
                $this -> success('更新权限成功!', url('AuthRule/list'));
			} else {
				$this -> error('更新权限失败!');
			}
		}
		$authRuleRes = $this -> authRule -> getAuthRuleList();
		$this -> assign(['authRuleRes' => $authRuleRes, 'ruleRes' => $ruleRes]);
		return view();
	}
	/**
	 * 权限列表
	 */
	public function list()
	{
		if (request() -> isPost()){
			$data = input('post.');
			$updateResult = [
				'successCount' => 0,
				'failedCount' => 0,
				'failedId' => [],
				'successId' => []
			];
			foreach($data as $k => $v){
				$result = $this -> authRule -> updateAuthRule(['id' => $k, 'sort' => $v]);
				if ($result){
					$updateResult['successCount'] += 1;
					array_push($updateResult['successId'], $k);
				} else {
					$updateResult['failedCount'] += 1;
					array_push($updateResult['failedId'], $k);
				}
			}
			if ($updateResult['failedCount']){
				$this -> error('更新权限排序失败!');
			} else {
				$this -> success('更新权限排序成功!', url('AuthRule/list'));
			}
		}
		$authRuleRes = $this -> authRule -> getAuthRuleList();
		$this -> assign('authRuleRes', $authRuleRes);
		return view();
	}
	/**
	 * 删除权限
	 */
	public function delete()
	{
		$id = input('id/d');
		$this -> checkRuleById($id);
		$ids = $this -> authRule -> getChilrenId($id);
		$ids[] = $id;
		$updateResult = [
			'successCount' => 0,
			'failedCount' => 0,
			'failedId' => [],
			'successId' => []
		];
		foreach($ids as $k => $id){
			$result = $this -> authRule -> updateAuthRuleList($id);
			if ($result){
				$updateResult['successCount'] += 1;
				array_push($updateResult['successId'], $id);
			} else {
				$updateResult['failedCount'] += 1;
				array_push($updateResult['failedId'], $id);
			}
		}
		if ($updateResult['failedCount']){
			$this -> error('删除权限及其子权限失败!');
		} else {
			$this -> success('删除权限及其子权限成功!', url('AuthRule/list'));
		}
	}
	/**
	 * 查看权限名称/权限标题是否已存在
	 */
	private function checkAuthRule($name,$field)
	{
		$res = $this -> authRule -> getRuleByField($field, $name);
		if ($res) {
			$this -> error('权限名称/权限标题已存在!');
		}
	}
	/**
	 * 校验信息是否存在
	 */
	private function checkRuleById($id){
		$ruleRes = $this -> authRule -> getAuthRuleById($id);
		if (is_null($ruleRes)) {
			$this -> error('权限信息不存在!');
		}
	}

}