<?php if(!defined('BASEPATH'))exit('No direct script access allowed');	
	Class Mylogin {
		protected $CI;

		public function __construct() {
			$this->CI = & get_instance();
			$this->CI->load->library("session");
		}

		public function validate_login() {
			$base = $this->CI->config->base_url();
			if (is_numeric($this->CI->session->get("user"))) {
				header("Location:" . $base . 'dyh/dyh');
			} else {
				if ($this->CI->uri->segment(2) != "login") { //获取当前页面的控制器名称
					header("Location:" . $base . 'dyh/login');
				}
			}
		}
	}