<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'file'));
		$this->load->model("category_model");
		$this->load->model("article_model");
		$this->load->library('page_widget');
	}

	public function index($aid)
	{
		$this->smarty->assign("title", "Article");

		if (! is_numeric($aid)) { //参数是字符串
			//获取文章id
			$url_str = str_replace("-", " ", $aid);
			$articles_info = $this->article_model->checkUrlExist($url_str);

			$aid = $articles_info[0]['ID'];
		}

		if ($aid > 0) {
			//获取所有分类
			if (! $category = $this->cache->get('all-category')) {
				$category = $this->category_model->getAllCategory();
				$this->cache->save('all-category', $category, 3600 * 24);
			}

			$this->smarty->assign("category", $category);

			//获取文章信息
			if (! $article = $this->cache->get('article/detail-' . $aid)) {
				if (isset($articles_info)) {
					$article = $articles_info; //传递的url是字符串时，获取的文章数据是否存在
				} else {
					$article = $this->article_model->getArticleDetail($aid);
				}
				$this->cache->save("article/detail-" . $aid, $article, 3600 * 24);
			}

			if (COUNT($article) > 0 && isset($article[0]['ID']) && $article[0]['ID'] > 0) {
				$this->smarty->assign("article", $article[0]);
				//获取当前分类
				$curr_category = 0;
				foreach ($category as $k => $v) {
					if ($v['ID'] == $article[0]['category']) {
						$this->smarty->assign("curr_category_name", $v['Name']);
						$this->smarty->assign("curr_category_url", $v['Url']);
						$this->smarty->assign("curr_category_id", $v['ID']);
						$curr_category = $v['ID'];
					}
				}

				//获取文章tag				
				// if (! $tags = $this->cache->get('tags/'.$aid)) {
					$this->load->model("tag_model");
					$tags = $this->tag_model->getArticleTags($aid);
					// $this->cache->save("tags/".$aid, $tags, 3600 * 24);
				// }
				$this->smarty->assign("tags", $tags);

				//获取最新的6篇文章		
				$latest_articles = $this->page_widget->getPageArticle(1, 5, 0);
				$this->smarty->assign("latest_articles", $latest_articles['data']);

				//获取当前分类最新的6篇文章
				$curr_latest_articles = $this->page_widget->getPageArticle(1, 5, $curr_category);
				$this->smarty->assign("curr_latest_articles", $curr_latest_articles['data']);	

				$this->smarty->display("article.html");
			}
		} else {
			show_error("对不起, 找不到该文章", 404, "请检查输入的url是否正确.");
		}
	}

	/**
	 * [loadArticleList 获取文章列表 异步加载]
	 * @return [type] [description]
	 */
	public function loadArticleList() {
		$page     = $this->input->post("page");
		$category = $this->input->post("category");

		$return = Array();
		$return['errorcode'] = 1;
		if (is_numeric($page) && $page > 0 && is_numeric($category)) {
			$category_info = $this->article_model->getPageArticles($page, 6, $category);

			$res = "";
			if ($category_info['errorcode'] == 0 && COUNT($category_info['data']) > 0) {
				
				foreach ($category_info['data'] as $k => $v) {
					$url_str = $this->page_widget->strToUrl($v['url']);
					$res .= '<div class="col-xs-12 cell">';
					$res .= '	<div class="col-xs-12 cell-post">';
					$res .= '		<h2 class="cell-top"><a href="'. $this->config->item('base_url') . $this->config->item('index_page') .'/'. $url_str . '.html">'.$v['title'].'</a></h2>';
					$res .= '		<div class="cell-center"><p>'. $v['description'] .'</p></div>';
					$res .= '	</div>';
					$res .= '	<div class="col-xs-12 cell-bottom">';
					$res .= '		<span class="post-time" title="发布时间">'. date("Y-m-d", strtotime($v['post_time'])) .'</span>';
					$res .= '		<span class="post-tags" title="文章标签">'. $v['tags'] .'</span>';
					$res .= '	</div>';
					$res .= '</div>';
				}
				$return['data'] = $res;
				$return['errorcode'] = 0;
			} else if (COUNT($category_info['data']) == 0){
				$return['errorcode'] = 2; //没有数据
			}
		}

		echo json_encode($return);
	}

	/**
	 * [articlePreNext 获取文章上一页和下一页]
	 * @return [type] [description]
	 */
	public function articlePreNext() {
		$aid = $this->input->post("aid");
		$return = Array('errorcode' => 1);
		if ($aid > 0) {
			//上一页
			$pre_article = $this->article_model->getPreNextArticle($aid, 'pre');
			if (isset($pre_article[0])) {
				$return['data']['pre'] = '<a href="'.$this->config->item('base_url') . $this->config->item('index_page') .'/'.$this->page_widget->strToUrl($pre_article[0]['url_title']).'.html" title="'.$pre_article[0]['title'].'">上一篇</a>';
			} else {
				$return['data']['pre'] = Array();
			}

			$next_article = $this->article_model->getPreNextArticle($aid, 'next');
			if (isset($next_article[0])) {
				$return['data']['next'] = '<a href="'.$this->config->item('base_url') . $this->config->item('index_page') .'/'.$this->page_widget->strToUrl($next_article[0]['url_title']).'.html" title="'.$next_article[0]['title'].'">上一篇</a>';
			} else {
				$return['data']['next'] = Array();
			}

			$return['errorcode'] = 0;
		}

		echo json_encode($return);
	}
}