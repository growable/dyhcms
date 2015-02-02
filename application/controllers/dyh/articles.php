<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Articles extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	//所有文章页面
	public function index()
	{
		$this->smarty->assign("title", "All Articles | DYHCMS");
		
		$this->smarty->display(DYH_CPATH . "all_articles.html");
	}
	//写新文章
	public function post() {
		$this->smarty->assign("title", "New Articles | DYHCMS");
		
		$this->smarty->display(DYH_CPATH . "new_articles.html");
	}

	//文章详情
	public function detail($aid) {
		$this->smarty->assign("title", "Update Articles | DYHCMS");

		$this->smarty->display(DYH_CPATH . "detail_articles.html");
	}
}