<?php
/**
 * 分类 模型
 */
namespace app\admin\model;
use app\admin\model\BaseModel;

class Category extends BaseModel
{
	/**
	 * 模型初始化
	 */
	public function initialize()
	{
		parent::initialize();
	}
	/**
	 * 添加栏目
	 */
	public function addCategory($data)
	{
		return $this -> addInfo($data);
	}
	/**
	 * 获取栏目列表 排序
	 */
	public function getList()
	{
		$cateres = $this -> order('category_sort desc') -> select();
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
		return $this -> getInfoByField('id', $id);
	}

	/**
	 * 递归获取栏目信息
	 */
	public function getChilrenId($cateid)
	{
		$cateres = $this -> select();
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
		return $this -> updateInfo($data);
	}
	/**
	 * 删除栏目信息
	 */
	public function updateCategoryList($cateid)
	{
		return $this -> deleteInfo($cateid);
	}
	/**
	 * 根据栏目名称获取信息
	 */
	public function getArticleByName($name)
	{
		return $this -> getInfoByField('category_name', $name);
	}



}