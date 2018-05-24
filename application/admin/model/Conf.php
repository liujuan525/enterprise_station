<?php
/**
 * 文章 模型
 */
namespace app\admin\model;
use app\admin\model\BaseModel;
use think\Db;

class Conf extends BaseModel
{
	/**
	 * 模型初始化
	 */
	public function initialize()
	{
		parent::initialize();
	}
	/**
	 * 根据配置中文名或者英文名查询配置信息
	 */
	public function getConf($field, $value)
	{
		return $this -> getInfoByField($field, $value);
	}
	/**
	 * 查询中文名
	 */
	public function queryCname($cname)
	{
		$info = $this -> where(['isDel' => 1, 'conf_cname' => $cname]) -> find();
		return $info;
	}
	/**
	 * 查询英文名
	 */
	public function queryEname($ename)
	{
		$info = $this -> where(['isDel' => 1, 'conf_ename' => $ename]) -> find();
		return $info;
	}
	/**
	 * 添加配置信息
	 */
	public function addConf($data)
	{
		return $this -> addInfo($data);
	}
	/**
	 * 删除配置项
	 */
	public function deleteConf($id)
	{
		return $this -> deleteInfo($id);
	}
	/**
	 * 更新配置项
	 */
	public function updateConf($data)
	{
		return $this -> updateInfo($data);
	}
	/**
	 * 获取配置列表
	 */
	public function getConfList()
	{
		$confs = $this -> order('conf_sort desc') -> paginate(2);
		return $confs;
	}
	/**
	 * 根据id获取配置信息
	 */
	public function getConfById($id)
	{
		return $this -> getInfoByField('id', $id);
	}




}