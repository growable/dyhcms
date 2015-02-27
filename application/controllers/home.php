<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->smarty->assign("title", "Home");
		$this->smarty->display("home.html");
		// $this->smarty->fetch("home.html"); //获取输出内容，但是输出到浏览器
		// print_r($string);
	}
}