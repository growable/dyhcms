<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'file'));
		$this->load->model("category_model");
		$this->load->model("article_model");
		$this->load->library('page_widget');
	}

	public function index()
	{
		$this->smarty->assign("title", "Home");
		//获取所有分类
		if (! $category = $this->cache->get('all-category')) {
			$category = $this->category_model->getAllCategory();
			$this->cache->save('all-category', $category, 3600 * 24);
		}
		$this->smarty->assign("category", $category);
		$this->smarty->assign("cid", 0);

		//获取最新的6篇文章
		$articles = $this->page_widget->getPageArticle(1, 6, 0);
		$this->smarty->assign("articles", $articles);		

		$this->smarty->display("home.html");

		// $this->smarty->fetch("home.html"); //获取输出内容，但是输出到浏览器
		// print_r($string);
	}
}