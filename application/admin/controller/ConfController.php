<?php
/**
 * 配置 控制器
 */
namespace app\admin\controller;
use app\admin\controller\BaseController;
use think\Validate;
use app\admin\model\Conf;

class ConfController extends BaseController
{
	/**
	 * 前置操作
	 */
	protected $beforeActionList = [
		'isLogin'
	];
	// 文章模型
	protected $conf;
	/**
	 * 初始化
	 */
	public function _initialize()
	{
		$this -> conf = new Conf();
	}
	/**
	 * 添加配置信息
	 */
	public function add()
	{
		if (request() -> isPost()) {
			$data = input('post.');
			$this -> checkData('Conf','add',$data); // 验证数据
			$cInfo = $this -> conf -> queryCname($data['conf_cname']);
			$eInfo = $this -> conf -> queryEname($data['conf_ename']);
			if ($cInfo || $eInfo) {
				$this -> error('配置中文名/英文名已存在!');
			}
			$result = $this -> conf -> addConf($data); // 添加成功返回1
			if ($result) {
                $this -> success('添加配置成功!',url('Conf/list'));
            } else {
                $this -> error('添加配置失败!');
            }
		}
		return view();
	}
	/**
	 * 更新配置信息
	 */
	public function edit()
	{
		$id = input('id/d');
		$conf = $this -> judgeConf($id);
		if (request() -> isPost()) {
			$data = input('post.');
			$this -> checkData('Conf','edit',$data); // 验证数据
			if ($data['conf_cname'] != $conf['conf_cname']) {
				$cInfo = $this -> conf -> queryCname($data['conf_cname']);
				if ($cInfo) {
					$this -> error('配置中文名已存在!');
				}
			}
			if ($data['conf_ename'] != $conf['conf_ename']) {
				$eInfo = $this -> conf -> queryEname($data['conf_ename']);
				if ($eInfo) {
					$this -> error('配置英文名已存在!');
				}
			}
			$result = $this -> conf -> updateConf($data);
			if ($result) {
                $this -> success('更新配置项成功!',url('Conf/list'));
            } else {
                $this -> error('更新配置项失败!');
            }
		}
		$this -> assign('conf', $conf);
		return view();
	}
	/**
	 * 获取配置列表
	 */
	public function list()
	{
		if (request() -> isPost()) {
			// 更新排序数值
			$data = input('post.');
			$updateResult = [
				'successCount' => 0,
				'failedCount' => 0,
				'failedId' => [],
				'successId' => []
			];
			foreach($data as $k => $v){
				$result = $this -> conf -> updateConf(['id' => $k, 'conf_sort' => $v]);
				if ($result){
					$updateResult['successCount'] += 1;
					array_push($updateResult['successId'], $k);
				} else {
					$updateResult['failedCount'] += 1;
					array_push($updateResult['failedId'], $k);
				}
			}
			if ($updateResult['failedCount']){
				$this -> error('更新配置项排序失败!');
			} else {
				$this -> success('更新配置项排序成功!', url('Conf/list'));
			}
		}
		$confs = $this -> conf -> getConfList();
		$this -> assign('confs', $confs);
		return view();
	}
	/**
	 * 删除配置信息
	 */
	public function delete()
	{
		$id = input('id/d');
		if (!$id || !is_numeric($id)) {
            $this -> error('数据格式错误!');
        }
		$this -> judgeConf($id);
        $result = $this -> conf -> deleteConf($id);
        if ($result) {
            $this -> success('删除配置项成功!', url('Conf/list'));
        } else {
            $this -> error('删除配置项失败!');
        }
	}
	/**
	 * 配置项
	 */
	public function conf()
	{
		$confs = $this -> conf -> getList();
		if (request() -> isPost()) {
			$data = input('post.');
			$updateResult = [
				'successCount' => 0,
				'failedCount' => 0,
				'failedId' => [],
				'successId' => []
			];
			foreach ($data as $k => $v) {
				$result = $this -> conf -> updateConfByName($k, ['conf_value' => $v]);
				if ($result){
					$updateResult['successCount'] += 1;
					array_push($updateResult['successId'], $k);
				} else {
					$updateResult['failedCount'] += 1;
					array_push($updateResult['failedId'], $k);
				}
			}
			if ($updateResult['failedCount']){
				$this -> error('更新配置项失败!');
			} else {
				$this -> success('更新配置项成功!');
			}
		}
		$this -> assign('confs', $confs);
		return view();
	}
	/**
	 * 根据id判断配置是否存在
	 */
	private function judgeConf($id)
	{
		$conf = $this -> conf -> getConfById($id);
		if (!$conf) {
			$this -> error('配置信息不存在!');
		} else {
			return $conf;
		}
	}

}