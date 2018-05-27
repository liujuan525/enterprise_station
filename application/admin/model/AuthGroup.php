<?php
/**
 * 权限规则 模型
 */
namespace app\admin\model;
use app\admin\model\BaseModel;

class AuthGroup extends BaseModel
{
	/**
	 * 模型初始化
	 */
	public function initialize()
	{
		parent::initialize();
	}
	/**
	 * 添加用户组
	 */
	public function addAuthGroup($data)
	{
		return $this -> addInfo($data);
	}
	/**
	 * 查询用户组信息
	 */
	public function getGroupByField($field, $value)
	{
		$res = $this -> where(['isDel'=>1,$field=>$value]) -> find();
		return $res;
	}
	/**
	 * 获取用户组列表
	 */
	public function getAuthGroupList()
	{
		return $this -> getListInfo(2);
	}
	/**
	 * 更新用户组
	 */
	public function updateAuthGroup($data)
	{
		return $this -> updateInfo($data);
	}




}