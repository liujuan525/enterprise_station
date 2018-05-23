<?php
/**
 * 分类 控制器
 */
namespace app\admin\controller;
use app\admin\controller\BaseController;
use think\Validate;
use app\admin\model\Category;

class CategoryController extends BaseController
{
	protected $category;
	/**
	 * 控制器初始化
	 */
	public function _initialize()
	{
		$this -> category = new Category();
	}
	/**
	 * 添加分类
	 */
	public function add()
	{
		if (request() -> isPost()) {
			$data = input('post.');
			$this -> checkData('Category', 'add', $data);
			$result = $this -> category -> addCategory($data);
			if ($result) {
				$this -> success('添加栏目成功!', url('Category/list'));
			} else {
				$this -> error('添加栏目失败!');
			}
		}
		$list = $this -> getCategoryList();
		$this -> assign(['list' => $list]);
		return view();
	}
	/**
	 * 修改分类
	 */
	public function edit()
	{
		$id = input('id/d'); // 变量类型强制转换为整数类型
		$category = $this -> category -> getCategoryById($id);
		if (is_null($category)) {
			$this -> error('栏目信息不存在!');
		}
		
		$list = $this -> getCategoryList();
		$this -> assign(['list' => $list, 'cateinfo' => $category]);
		return view();
	}
	/**
	 * 分类列表
	 */
	public function list()
	{
		$list = $this -> getCategoryList();
		$this -> assign(['list' => $list]);
		return view();
	}
	/**
	 * 删除分类
	 */
	public function delete()
	{

	}
	/**
	 * 获取栏目列表
	 */
	private function getCategoryList()
	{
		$list = $this -> category -> getList();
		return $list;
	}


}