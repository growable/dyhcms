<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->smarty->assign("title", "Categorys");
		$this->smarty->display(DYH_CPATH . "categroy.html");
	}
}