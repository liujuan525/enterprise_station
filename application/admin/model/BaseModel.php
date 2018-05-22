<?php
/**
 * 公共信息模型
 */
namespace app\admin\model;
use think\Model;

class BaseModel extends Model
{
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
}