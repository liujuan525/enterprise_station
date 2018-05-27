<?php
/**
 * 权限规则 模型
 */
namespace app\admin\model;
use app\admin\model\BaseModel;

class AuthRule extends BaseModel
{
	/**
	 * 模型初始化
	 */
	public function initialize()
	{
		parent::initialize();
	}
	/**
	 * 获取权限列表
	 */
	public function getAuthRuleList()
	{
		$ruleResult = $this -> order('sort desc') -> select();
		return $this -> sort($ruleResult);
	}
	// 排序
	private function sort($data, $pid=0)
	{
		static $arr = [];
		foreach($data as $k => $v){
			if ($v['pid'] == $pid){
            	$v['dataid']=$this->getparentid($v['id']);
				$arr[] = $v;
				$this -> sort($data, $v['id']);
			}
		}
		return $arr;
	}
	// 获取父类id
	private function getparentid($authRuleId)
	{
        $authRuleRes=$this->select();
        return $this->_getparentid($authRuleRes,$authRuleId,True);
	}
    private function _getparentid($authRuleRes,$authRuleId,$clear=False)
    {
    	static $arr = [];
    	if ($clear) {
    		$arr = []; // 是否清空数据
    	}
    	foreach ($authRuleRes as $k => $v) {
    		if ($v['id'] == $authRuleId) {
    			$arr[] = $v['id'];
                $this->_getparentid($authRuleRes,$v['pid'],False);
    		}
    	}
    	asort($arr);
    	$arrStr = implode('-', $arr);
    	return $arrStr;
    }
	/**
	 * 根据权限名称或者权限标题查询权限
	 */
	public function getRuleByField($field, $value)
	{
		$res = $this -> where(['isDel'=>1,$field=>$value]) -> find();
		return $res;
	}
	/**
	 * 添加权限规则
	 */
	public function addAuthRule($data)
	{
		return $this -> addInfo($data);
	}
	/**
	 * 更新权限排序
	 */
	public function updateAuthRule($data)
	{
		return $this -> updateInfo($data);
	}
	/**
	 * 根据id获取权限信息
	 */
	public function getAuthRuleById($id)
	{
		return $this -> getInfoByField('id', $id);
	}
	/**
	 * 删除权限信息
	 */
	public function updateAuthRuleList($id)
	{
		return $this -> deleteInfo($id);
	}
	/**
	 * 根据ID获取其子元素的Id
	 */
	public function getChilrenId($authRuleId)
	{
		$ruleResult = $this -> select();
		return $this -> _getchilrenid($ruleResult, $authRuleId);
	}
	private function _getchilrenid($data, $id)
	{
		static $arr = [];
		foreach ($data as $k => $v) {
			if ($v['pid'] == $id) {
				$arr[] = $v['id'];
				$this -> _getchilrenid($data, $v['id']);
			}
		}
		return $arr;
	}



}