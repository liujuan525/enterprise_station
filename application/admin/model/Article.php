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
	 * 模型初始化
	 */
	public function initialize()
	{
		parent::initialize();
	}
	/**
	 * 添加文章
	 */
	public function addArticle($data)
	{
		return $this -> addInfo($data);
	}
	/**
	 * 根据文章标题查询文章内容
	 */
	public function getArticleByTitle($title)
	{
		return $this -> getInfoByField('title', $title);
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
					 -> paginate(2);
		return $article;
	}
	/**
	 * 根据文章id获取文章详情
	 */
	public function getArticleById($id)
	{
		return $this -> getInfoByField('id', $id);
	}
	/**
	 * 更新文章
	 */
	public function updateArticle($data)
	{
		return $this -> updateInfo($data);
	}
	/**
	 * 删除文章
	 */
	public function deleteArticle($id)
	{
		return $this -> deleteInfo($id);
	}



}
