<?php
/**
 * 公共信息模型
 */
namespace app\admin\model;
use think\Model;

class BaseModel extends Model
{
	/**
	 * 模型初始化
	 */
	public function initialize()
	{
		$this -> where('isDel', 1);
	}
	/**
	 * 添加时间
	 */
	public function addTime($data=[])
	{
		$time = date('Y-m-d H:i:s', time());
        $data['addTime'] = $data['updateTime'] = $time;
		return $data;
	}
	/**
	 * 修改时间
	 */
	public function updateTime($data=[])
	{
		$time = date('Y-m-d H:i:s', time());
        $data['updateTime'] = $time;
		return $data;
	}
	/**
	 * 添加数据
	 */
	public function addInfo($data)
	{
		$data = $this -> addTime($data);
		$info = $this -> save($data);
		return $info;
	}
	/**
	 * 更新数据
	 */
	public function updateInfo($data)
	{
		$data = $this -> updateTime($data);
		$result = $this -> update($data);
		return $result;
	}
	/**
	 * 删除数据
	 */
	public function deleteInfo($id)
	{
		$data['isDel'] = 2;
		$data = $this -> updateTime($data);
		$result = $this -> where('id', $id) -> update($data);
		return $result;
	}
	/**
	 * 获取数据列表
	 */
	public function getListInfo($page=10)
	{
		$list = $this -> paginate($page);
		return $list;
	}
	/**
	 * 根据字段获取数据
	 */
	public function getInfoByField($field, $value)
	{
		$info = $this -> where($field, $value) -> find();
		return $info;
	}


}