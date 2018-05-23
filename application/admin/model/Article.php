<?php
/**
 * 文章 模型
 */
namespace app\admin\model;
use app\admin\model\BaseModel;
use think\Db;

class Article extends BaseModel
{
	/**
	 * 添加文章
	 */
	public function addArticle($data)
	{
		$data = $this -> addTime($data);
		$article = $this -> save($data);
		return $article;
	}
	/**
	 * 根据文章标题查询文章内容
	 */
	public function getArticleByTitle($title)
	{
		$article = $this -> where(['isDel' => 1,'title' => $title]) -> select();
		return $article;
	}
	/**
	 * 获取文章列表
	 */
	public function getArticleList()
	{
		// $article = $this
		$article = Db::table('es_article')
					 -> alias('a')
					 -> where(['a.isDel'=>1, 'e.isDel'=>1])
					 -> field('a.*,e.category_name')
					 -> join('es_category e', 'a.category_id=e.id')
					 -> select();
		// $sql = $this -> getLastSql();
		// dump($sql);die();
		return $article;
	}
	/**
	 * 根据文章id获取文章详情
	 */
	public function getArticleById($id)
	{
		$article = $this -> where(['id' => $id, 'isDel' => 1]) -> find();
		return $article;
	}
	/**
	 * 更新文章
	 */
	public function updateArticle($data)
	{
		$data = $this -> updateTime($data);
		$result = $this -> update($data);
		return $result;
	}
	/**
	 * 删除文章
	 */
	public function deleteArticle($id)
	{
		$data['isDel'] = 2;
		$data = $this -> updateTime($data);
		$result = $this -> where('id', $id) -> update($data);
		return $result;
	}



}
