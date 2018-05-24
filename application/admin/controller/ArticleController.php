<?php
/**
 * 文章 控制器
 */
namespace app\admin\controller;
use app\admin\controller\BaseController;
use think\Validate;
use app\admin\model\Article;

class ArticleController extends BaseController
{
	/**
	 * 前置操作
	 */
	protected $beforeActionList = [
		'isLogin'
	];
	// 文章模型
	protected $article;
	/**
	 * 初始化
	 */
	public function _initialize()
	{
		$this -> article = new Article();
	}
	/**
	 * 添加文章
	 */
	public function add()
	{
		if (request() -> isPost()) {
			$data = input('post.');
			$this -> checkData('Article','add',$data); // 验证数据
			$this -> checkArticleTitle($data['title']);
			$data['thumb_img'] = '/uploads'. '/'. $this -> uploadImg();
			$result = $this -> article -> addArticle($data); // 添加成功返回1
			if ($result) {
                $this -> success('添加文章成功!',url('Article/list'));
            } else {
                $this -> error('添加文章失败!');
            }
		}
		$cateres = model('Category') -> getList();
		$this -> assign('cateres', $cateres);
		return view();
	}
	/**
	 * 编辑文章
	 */
	public function edit()
	{
		$id = input('id/d');
		$article = $this -> judgeArticle($id);
		if (request() -> isPost()) {
			$data = input('post.');
			$this -> checkData('Article','edit',$data); // 验证数据
			$url = $this -> uploadImg();
			if (is_null($url)) {
				$data['thumb_img'] = $article['thumb_img'];
			} else {
				$data['thumb_img'] = '/uploads'. '/'. $url;
			}
			$result = $this -> article -> updateArticle($data);
			if ($result) {
                $this -> success('更新文章成功!',url('Article/list'));
            } else {
                $this -> error('更新文章失败!');
            }
		}

		$cateres = model('Category') -> getList();
		$this -> assign([
			'cateres' => $cateres,
			'article' => $article
		]);
		return view();
	}
	/**
	 * 文章列表
	 */
	public function list()
	{
		$artres = $this -> article -> getArticleList();
		$this -> assign('artres', $artres);
		return view();
	}
	/**
	 * 删除文章
	 */
	public function delete()
	{
		$id = input('id/d');
		if (!$id || !is_numeric($id)) {
            $this -> error('数据格式错误!');
        }
		$article = $this -> judgeArticle($id);
		// $this -> deleteArticleImg($article['thumb_img']);
        $result = $this -> article -> deleteArticle($id);
        if ($result) {
            $this -> success('删除文章成功!', url('Article/list'));
        } else {
            $this -> error('删除文章失败!');
        }
	}
	/**
	 * 上传图片
	 */
	private function uploadImg()
	{
		$file = request() -> file('thumb_img');
		if ($file) {
			$movePath = ROOT_PATH.'public'.DS.'uploads';
			$info = $file -> validate(['ext'=>'jpg,png,gif,jpeg']) -> move($movePath);
			if ($info) {
				return $info -> getSaveName();
			} else {
				$this -> error($file -> getError());
			}
		}
	}
	/**
	 * 根据id判断文章是否存在
	 */
	private function judgeArticle($id)
	{
		$article = $this -> article -> getArticleById($id);
		if (!$article) {
			$this -> error('文章信息不存在!');
		} else {
			return $article;
		}
	}
	/**
	 * 校验文章标题是否重复
	 */
	private function checkArticleTitle($title)
	{
		$article = $this -> article -> getArticleByTitle($title);
		if ($article) {
			$this -> error('文章标题已存在');
		}
	}
	/**
	 * 删除文章的同时删除图片链接
	 */
	private function deleteArticleImg($img)
	{
		$thumbPath = $_SERVER['DOCUMENT_ROOT'] . $img;
		if (file_exists($thumbPath)) {
			@unlink($thumbPath);
		}
	}

}