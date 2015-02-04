<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->smarty->assign("title", "Home");
		$this->smarty->display("home.html");
	}
}