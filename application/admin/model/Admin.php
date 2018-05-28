<?php
/**
 * 管理员 模型
 */
namespace app\admin\model;
use app\admin\model\BaseModel;

class Admin extends BaseModel
{
	/**
	 * 模型初始化
	 */
	public function initialize()
	{
		parent::initialize();
	}
	/**
	 * 添加管理员
	 */
	public function addAdmin($data)
	{
		$data = $this -> addTime($data);
		$info = $this -> save($data);
		$id = $this -> getLastInsID();
		return $id;
		// return $this -> addInfo($data);
	}
	/**
	 * 获取管理员列表
	 */
	public function adminList()
	{
		$result = $this -> order('id', 'desc') -> paginate(2);
		return $result;
	}
	/**
	 * 根据id获取管理员信息
	 */
	public function getAdminById($id)
	{
		return $this -> getInfoByField('id', $id);
	}
	/**
	 * 更新管理员信息
	 */
	public function updateAdmin($data)
	{
		return $this -> updateInfo($data);
	}
	/**
	 * 删除管理员
	 */
	public function deleteAdmin($id,$data=[])
	{
		return $this -> deleteInfo($id);
	}
	/**
	 * 根据账号查询管理员信息
	 */
	public function getAdminByName($name)
	{
		return $this -> getInfoByField('name', $name);
	}


}