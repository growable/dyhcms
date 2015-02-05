<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index($aid)
	{
		$this->smarty->assign("title", "Article");
		$this->smarty->display("article.html");
	}
}