<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Articles extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("article_model");
		$this->load->driver('cache', array('adapter' => 'file'));
	}

	//所有文章页面
	public function index($page = 1) {
		$this->load->library("page_widget");
		$this->smarty->assign("title", "All Articles | DYHCMS");
		
		//获取第一页的所有文章;
		$articles = $this->article_model->getPageArticles($page, $num = 15);
		$this->smarty->assign("articles_list", $articles['data']); //文章数据
		
		$index_page = !empty($this->config->item('index_page')) ? "index.php/" : "";
		$paginations = $this->page_widget->page_1($page, round($articles['article_num'] / 15), $this->config->item("base_url") . $index_page . 'dyh/articles/index/');
	
		$this->smarty->assign("paginations", $paginations);
		
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
		
		if (is_numeric($aid) && $aid > 0) {
			//获取文章详情
			$article = $this->article_model->getArticleDetail($aid);
			
			//获取分类信息
			if ($category != $this->cache->get('all_category')) {
				$category = $this->category_model->getAllCategory();
				$this->cache->save('all_category', 3600 * 24, $category);
			}
			
			$this->smarty->display(DYH_CPATH . "detail_articles.html");
		} else {
			print_r("文章ID错误！");
		}
	}
}