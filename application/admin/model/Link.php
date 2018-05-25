<?php
/**
 * 链接 模型
 */
namespace app\admin\model;
use app\admin\model\BaseModel;

class Link extends BaseModel
{
	/**
	 * 模型初始化
	 */
	public function initialize()
	{
		parent::initialize();
	}
	/**
	 * 根据链接标题或者链接地址查询链接
	 */
	public function getLinkByField($field, $value)
	{
		$link = $this -> where(['isDel'=>1,$field=>$value]) -> find();
		return $link;
	}
	/**
	 * 添加链接
	 */
	public function addLink($data)
	{
		return $this -> addInfo($data);
	}
	/**
	 * 获取链接列表
	 */
	public function getLinks()
	{
		$info = $this -> order('link_sort desc') -> paginate(2);
		return $info;
	}
	/**
	 * 根据id获取链接信息
	 */
	public function getLinkById($id)
	{
		return $this -> getInfoByField('id', $id);
	}
	/**
	 * 更新链接
	 */
	public function updateLink($data)
	{
		return $this -> updateInfo($data);
	}
	/**
	 * 删除文章
	 */
	public function deleteLink($id)
	{
		return $this -> deleteInfo($id);
	}


}