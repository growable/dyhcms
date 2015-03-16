<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Articles extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("article_model");
		$this->load->library("mylogin");
		$this->mylogin->validate_login();
		$this->load->driver('cache', array('adapter' => 'file'));
	}

	//所有文章页面
	public function index($page = 1) {
		$this->load->library("page_widget");
		$this->smarty->assign("title", "All Articles | DYHCMS");
		
		//获取第一页的所有文章;
		$articles = $this->article_model->getPageArticles($page, $num = 15);
		$this->smarty->assign("articles_list", $articles['data']); //文章数据
		
		$index_page_tmp = $this->config->item('index_page');
		$index_page = !empty($index_page_tmp) ? "index.php/" : "";
		$paginations = $this->page_widget->page_1($page, ceil($articles['article_num'] / 15), $this->config->item("base_url") . $index_page . 'dyh/articles/index/');
	
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

			if (COUNT($article) > 0 && isset($article[0]['ID']) && $article[0]['ID'] > 0) {
				$this->smarty->assign("article", $article[0]);
				//获取分类信息
				if (! $category = $this->cache->get('all-category')) {
					$this->load->model("category_model");
					$category = $this->category_model->getAllCategory();
					$this->cache->save('all-category', $category, 3600 * 24);
				}
				$this->smarty->assign("category", $category);

				//获取文章tag				
				// if (! $tags = $this->cache->get('tags/'.$aid)) {
					$this->load->model("tag_model");
					$tags = $this->tag_model->getArticleTags($aid);
					// $this->cache->save("tags/".$aid, $tags, 3600 * 24);
				// }
				$this->smarty->assign("tags", $tags);
				
				$this->smarty->display(DYH_CPATH . "detail_articles.html");
			} else {
				print_r("文章数据获取错误！");
			}
		} else {
			print_r("文章ID错误！");
		}
	}

	/**
	 * 检查文章url是否存在
	 */
	
	public function checkUrlExist() {
		$R = Array('errorcode' => 1);

		$url = $this->input->post("url");
		if (!empty($url)) {
			$url = mysql_real_escape_string($url);
			$res = $this->article_model->checkUrlExist($url);
			if (COUNT($res) > 0) { //存在
				$R['errorcode'] = 0;
				$R['status'] = 1;
				$R['msg'] = 'Exist';
			} else {
				$R['errorcode'] = 0;
				$R['status'] = 0;
				$R['msg'] = 'Not Exist';
			}
		}

		echo json_encode($R);
	}

	/**
	 * [saveArticle 更新/新增文章]
	 * @return [type] [description]
	 */
	public function saveArticle() {
		$R = Array('errorcode' => 1);

		$aid     = $this->input->post("aid");
		$title   = $this->input->post("title");
		$url     = $this->input->post("url");
		$desc    = $this->input->post("desc");
		$cate    = $this->input->post("cate");
		$tags    = $this->input->post("tag");
		$content = $this->input->post("content");
		$type    = $this->input->post("type"); //操作类型，更新/发布/保存

		if (!empty($title) && !empty($url) && !empty($desc) && is_numeric($cate) && $cate > 0 && !empty($content)) {
			$title   = mysql_real_escape_string($title);
			$url     = mysql_real_escape_string(strtolower(trim($url)));
			$desc    = mysql_real_escape_string($desc);
			$content = mysql_real_escape_string($content);
			$cate    = mysql_real_escape_string($cate);

			if ($aid == 0 && $type == 1) { //发布
				$aid = $this->article_model->addArticle($title, $url, $desc, $content, $cate, 1);	
			} else if ($aid == 0 && $type == 0) { //保存
				$aid = $this->article_model->addArticle($title, $url, $desc, $content, $cate, 0);
			} else if ($aid != 0 && $type == 0) { //更新
				$this->article_model->updateArticle($aid, $title, $url, $desc, $content, $cate);
			}
			
			//文章标签
			$this->addArticleTag($tags, $aid);

			$R['msg'] = 'success';
			$R['errorcode'] = 0;
			$R['data'] = 'index.php/dyh/articles/detail/' . $aid; //跳转url
		} else {
			$R['msg'] = 'data error';
		}

		echo json_encode($R);
	}


	/**
	 * [addArticleTag 新增文章标签]
	 * @param [type] $tags [description]
	 */
	public function addArticleTag($tags, $aid) {
		if (!empty($tags) && is_numeric($aid)) {
			$tag_arr = explode(",", $tags);

			foreach ($tag_arr as $k => $v) {
				$tag = mysql_real_escape_string($v);
				//检查该标签是否已经存在
				$res = $this->tag_model->checkTagIsExist($tag);

				if (COUNT($res) > 0) { //已存在
					$tid = $res[0]['ID'];
					$nid = $this->tag_model->addTagsAssoc($tid, $aid);							
				} else { //不存在
					$tid = $this->tag_model->addTags($tag);
					$nid = $this->tag_model->addTagsAssoc($tid, $aid);							
				}		
			}
		}
	}
}