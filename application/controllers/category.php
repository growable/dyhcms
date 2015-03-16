<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'file'));
		$this->load->model("category_model");
		$this->load->library('page_widget');
	}

	public function index($urlname)
	{
		$this->smarty->assign("title", "Category");
		//所有分类
		//获取所有分类
		if (! $category = $this->cache->get('all-category')) {
			$category = $this->category_model->getAllCategory();
			$this->cache->save('all-category', $category, 3600 * 24);
		}
		
		$this->smarty->assign("category", $category);

		//获取当前分类信息
		$cid = 0;
		foreach ($category as $k => $v) {
			if ($v['Url'] == $urlname) {
				$cid   = $v['ID'];
				$cname = $v['Name'];
			} else {
				if (isset($v['Child'])) {
					foreach ($v['Child'] as $c => $cv) {
						if ($cv['Url'] == $urlname) {
							$cid   = $cv['ID'];
							$cname = $cv['Name'];
						}
					}
				}
			}
		}

		if ($cid > 0) {
			$this->smarty->assign("cid", $cid);
			$this->smarty->assign("cname", $cname);
			//获取该分类的文章
			$articles = $this->page_widget->getPageArticle(1, 6, $cid);
			$this->smarty->assign("articles", $articles);
			
			$this->smarty->display("home.html");	
		} else {
			show_error("对不起, 找不到该分类", 404, "请检查输入的url是否正确.");
		}		
	}
}