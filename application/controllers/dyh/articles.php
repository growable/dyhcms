<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		
	}

	//写新文章
	public function post() {
		$this->smarty->assign("title", "New Articles | DYHCMS");
		$this->smarty->display(DYH_CPATH . "new_articles.html");
	}
}