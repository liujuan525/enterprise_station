<?php
/**
 * 分类 模型
 */
namespace app\admin\model;
use app\admin\model\BaseModel;

class Category extends BaseModel
{
	/**
	 * 添加栏目
	 */
	public function addCategory($data)
	{
		$data = $this -> addTime($data);
		$category = $this -> save($data);
		return $category;
	}
	/**
	 * 获取栏目列表
	 */
	public function getList()
	{
		$category = $this -> where('isDel', 1) -> select();
		return $category;
	}
	/**
	 * 根据id获取栏目信息
	 */
	public function getCategoryById($id)
	{
		$category = $this -> where('id', $id) -> find();
		return $category;
	}
	/**
	 * 递归获取栏目信息
	 */
	public function getCategory($id)
	{
		$category = $this -> getCategoryById($id);
		$pid = $category['category_pid'];
	}
	public function getP($pid)
	{
		$info = $this -> where('category_pid', $pid);
	}


}