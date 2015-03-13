<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Login extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->model("login_models");
			$this->load->library("mylogin");
			$this->mylogin->validate_login();
		}

		public function index() {
			$base = $this->config->base_url();
			$this->smarty->assign("base", $base);

			$this->smarty->display(DYH_CPATH . "login_view.html");
		}

		// 验证登陆
		/*
		 *参数是用户名和密码
		*/
		public function validate() {
			$name = $this->input->post("name");
			$pwd  = $this->input->post("pwd");

			$this->load->library(array("strfilter", "session"));
			$name = $this->strfilter->login_filter($name);
			$pwd  = $this->strfilter->login_filter($pwd);

			if (!empty($name) && !empty($pwd)) {
				$login = $this->login_models->loginValidate($name, $pwd);
				if (COUNT($login->result()) > 0) {
					$user = $login->row_array();
					$this->session->set('user', $user['ID']);
					$data['code'] = 1;
				} else {
					$data['code'] = 0;
				}
			} else {
				$data['code'] = 0;
				$data['msg'] = "user name or user password can not be empty!";
			}

			echo json_encode($data);  //返回登陆结果
		}

	}