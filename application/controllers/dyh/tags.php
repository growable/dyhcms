<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->smarty->assign("title", "Tags");
		$this->smarty->display(DYH_CPATH . "tags.html");
	}
}