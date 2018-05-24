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
	 * 获取栏目列表 排序
	 */
	public function getList()
	{
		$cateres = $this -> where('isDel', 1) -> order('category_sort desc') -> select();
		return $this -> sort($cateres);
	}
	/**
	 * 对栏目列表进行排序
	 */
	private function sort($data, $pid=0, $level=0)
	{
		static $arr = [];
		foreach($data as $k => $v){
			if($v['category_pid'] == $pid){
				$v['level'] = $level;
				$arr[] = $v;
				$this -> sort($data, $v['id'], $level+1);
			}
		}
		return $arr;
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
	public function getChilrenId($cateid)
	{
		$cateres = $this -> where('isDel', 1) -> select();
		return $this -> _getChilrenId($cateres, $cateid);
	}
	/**
	 * 递归获取子栏目id
	 */
	private function _getChilrenId($cateres, $cateid)
	{
		static $childId = [];
		foreach($cateres as $k => $v){
			if($v['category_pid'] == $cateid){
				$childId[] = $v['id'];
				$this -> _getChilrenId($cateres, $v['id']);
			}
		}
		return $childId;
	}

	/**
	 * 修改栏目信息
	 */
	public function updateCategory($data)
	{
		$data = $this -> updateTime($data);
		$result = $this -> update($data);
		return $result;
	}
	/**
	 * 批量修改栏目信息
	 */
	public function updateCategoryList($cateid)
	{
		$time = date('Y-m-d H:i:s', time());
		$data = [
			'updateTime' => $time,
			'isDel' => 2
		];
		$result = $this -> where('id', $cateid) -> update($data);
		return $result;
	}
	/**
	 * 根据栏目名称获取信息
	 */
	public function getArticleByName($name)
	{
		$category = $this -> where(['isDel' => 1, 'category_name' => $name]) -> find();
		return $category;
	}



}