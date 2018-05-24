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
	/**
     * 前置方法
     */
    protected $beforeActionList = [
        'isLogin' // 判断用户是否登录
    ];
	// 栏目分类数据表模型
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
			$this -> checkCategoryName($data['category_name']);
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
	 * 更新栏目分类
	 */
	public function edit()
	{
		$id = input('id/d'); // 变量类型强制转换为整数类型
		$category = $this -> category -> getCategoryById($id);
		if (is_null($category)) {
			$this -> error('栏目信息不存在!');
		}
		if (request() -> isPost()) {
			$data = input('post.');
			$this -> checkData('Category', 'edit', $data);
			if ($data['category_name'] != $category['category_name']) {
				$this -> checkCategoryName($data['category_name']);
			}
			$result = $this -> category -> updateCategory($data);
			if ($result) {
                $this -> success('更新栏目信息成功!', url('Category/list'));
			} else {
				$this -> error('更新栏目信息失败!');
			}
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
				$result = $this -> category -> updateCategory(['id' => $k, 'category_sort' => $v]);
				if ($result){
					$updateResult['successCount'] += 1;
					array_push($updateResult['successId'], $k);
				} else {
					$updateResult['failedCount'] += 1;
					array_push($updateResult['failedId'], $k);
				}
			}
			if ($updateResult['failedCount']){
				$this -> error('更新栏目排序失败!');
			} else {
				$this -> success('更新栏目排序成功!', url('Category/list'));
			}
		}
		$list = $this -> getCategoryList(); // 获取栏目列表
		$this -> assign(['list' => $list]);
		return view();
	}
	/**
	 * 删除栏目及其子栏目
	 */
	public function delete()
	{
		$cateid = input('id/d'); // 变量类型强制转换为整数类型
		$ids = $this -> category -> getChilrenId($cateid);
		$ids[] = $cateid;
		$updateResult = [
			'successCount' => 0,
			'failedCount' => 0,
			'failedId' => [],
			'successId' => []
		];
		foreach($ids as $k => $cateid){
			$result = $this -> category -> updateCategoryList($cateid);
			if ($result){
				$updateResult['successCount'] += 1;
				array_push($updateResult['successId'], $cateid);
			} else {
				$updateResult['failedCount'] += 1;
				array_push($updateResult['failedId'], $cateid);
			}
		}
		if ($updateResult['failedCount']){
			$this -> error('删除栏目及其子栏目失败!');
		} else {
			$this -> success('删除栏目及其子栏目成功!', url('Category/list'));
		}
	}
	/**
	 * 获取栏目列表
	 */
	private function getCategoryList()
	{
		$list = $this -> category -> getList();
		return $list;
	}
	/**
	 * 校验栏目名称是否重复
	 */
	public function checkCategoryName($name)
	{
		$category = $this -> category -> getArticleByName($name);
		if ($category) {
			$this -> error('栏目名称已存在!');
		}
	}


}