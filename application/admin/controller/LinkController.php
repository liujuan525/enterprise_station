<?php
/**
 * 链接 控制器
 */
namespace app\admin\controller;
use app\admin\controller\BaseController;
use think\Validate;
use app\admin\model\Link;

class LinkController extends BaseController
{
	/**
	 * 前置操作
	 */
	protected $beforeActionList = [
		'isLogin'
	];
	// 链接模型
	protected $link;
	// 初始化
	public function _initialize()
	{
		$this -> link = new Link();
	}
	/**
	 * 添加链接
	 */
	public function add()
	{
		if (request() -> isPost()) {
			$data = input('post.');
			$this -> checkData('Link', 'add', $data);
			$this -> checkLink($data['link_title'], $data['link_url']);
			$result = $this -> link -> addLink($data);
			if ($result) {
                $this -> success('添加链接成功!',url('Link/list'));
            } else {
                $this -> error('添加链接失败!');
            }
		}
		return view();
	}
	/**
	 * 修改链接
	 */
	public function edit()
	{
		$id = input('id/d');
		$link = $this -> judgeLink($id);
		if (request() -> isPost()) {
			$data = input('post.');
			$this -> checkData('Link','edit',$data); // 验证数据
			$result = $this -> link -> updateLink($data);
			if ($result) {
                $this -> success('更新链接成功!',url('Link/list'));
            } else {
                $this -> error('更新链接失败!');
            }
		}
		$this -> assign('link', $link);
		return view();
	}
	/**
	 * 链接列表
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
				$result = $this -> link -> updateLink(['id' => $k, 'link_sort' => $v]);
				if ($result){
					$updateResult['successCount'] += 1;
					array_push($updateResult['successId'], $k);
				} else {
					$updateResult['failedCount'] += 1;
					array_push($updateResult['failedId'], $k);
				}
			}
			if ($updateResult['failedCount']){
				$this -> error('更新链接排序失败!');
			} else {
				$this -> success('更新链接排序成功!', url('Link/list'));
			}
		}
		$links = $this -> link -> getLinks();
		$this -> assign('links', $links);
		return view();
	}
	/**
	 * 删除链接
	 */
	public function delete()
	{
		$id = input('id/d');
		if (!$id || !is_numeric($id)) {
            $this -> error('数据格式错误!');
        }
		$link = $this -> judgeLink($id);
        $result = $this -> link -> deleteLink($id);
        if ($result) {
            $this -> success('删除链接成功!', url('Link/list'));
        } else {
            $this -> error('删除链接失败!');
        }
	}
	/**
	 * 查看链接名称/链接地址是否已存在
	 */
	private function checkLink($title, $url)
	{
		$link1 = $this -> link -> getLinkByField('link_title', $title);
		$link2 = $this -> link -> getLinkByField('link_url', $url);
		if ($link1 || $link2) {
			$this -> error('链接名称/链接地址已存在!');
		}
	}
	/**
	 * 根据id判断链接是否存在
	 */
	private function judgeLink($id)
	{
		$link = $this -> link -> getLinkById($id);
		if (!$link) {
			$this -> error('链接信息不存在!');
		} else {
			return $link;
		}
	}


}