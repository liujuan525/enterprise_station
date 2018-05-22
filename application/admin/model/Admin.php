<?php
/**
 * 管理员 模型
 */
namespace app\admin\model;
use app\admin\model\BaseModel;

class Admin extends BaseModel
{
	/**
	 * 添加管理员
	 */
	public function addAdmin($data)
	{
		$data = $this -> addTime($data);
		$result = $this -> save($data);
		return $result;
	}
	/**
	 * 获取管理员列表
	 */
	public function adminList()
	{
		$result = $this -> where('isDel', 1) -> order('id', 'desc') -> paginate(2);
		return $result;
	}
	/**
	 * 根据id获取管理员信息
	 */
	public function getAdminById($id)
	{
		$result = $this -> find($id);
		return $result;
	}
	/**
	 * 更新管理员信息
	 */
	public function updateAdmin($data)
	{
		$data = $this -> updateTime($data);
		$result = $this -> update($data);
		return $result;
	}
	/**
	 * 删除管理员
	 */
	public function deleteAdmin($id,$data=[])
	{
		$data['isDel'] = 2;
		$data = $this -> updateTime($data);
		$result = $this -> where('id', $id) -> update($data);
		return $result;
	}
	/**
	 * 根据账号查询管理员信息
	 */
	public function getAdminByName($name)
	{
		$result = $this -> where(['name'=>$name, 'isDel'=>1]) -> find();
		return $result;
	}
	/**
	 * 根据id更新信息
	 */
	public function updateById($id,$data=[]){
		$data = $this -> updateTime($data);
		$result = $this -> where('id', $id) -> update($data);
		return $result;
	}


}