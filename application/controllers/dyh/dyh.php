<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DYH extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library("mylogin");
		$this->mylogin->validate_login();
	}

	public function index()
	{
		$this->smarty->assign("title", "Home Page");
		$this->smarty->display(DYH_CPATH . "index.html");
	}
}