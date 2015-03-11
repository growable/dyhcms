<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'file'));
		$this->load->model("category_model");
	}

	public function index()
	{
		$this->smarty->assign("title", "Categorys");
		//获取所有的分类
		if (! $category = $this->cache->get('all-category')) {
			$category = $this->category_model->getAllCategory();
			$this->cache->save('all-category', $category, 3600 * 24);
		}
		$this->smarty->assign("category", $category);

		$this->smarty->display(DYH_CPATH . "categroy.html");
	}

	//获取单个分类信息
	public function getOne() {
		$category = Array('errorcode' => 1);
		if (isset($_POST['cid'])) {
			$cid = $this->input->post("cid");

			if (is_numeric($cid)) {
				$R = $this->category_model->getOneDetail($cid);
				if (COUNT($category) > 0) {
					$category['errorcode'] = 0;
					$category['detail']    = $R;
				}
			}
		}
		echo json_encode($category);
	}

	//修改分类信息
	public function alterCategory() {
		$category = Array('errorcode' => 1);
		if (isset($_POST['cid'])) {
			$cid   = $this->input->post("cid");
			$curl  = $this->input->post("curl");
			$cname = $this->input->post("cname");
			$cpid  = $this->input->post("cpid");

			if (is_numeric($cid) && $cid > 0 && !empty($cname)) {
				$cname = mysql_real_escape_string($cname);
				$curl  = mysql_real_escape_string($curl);
				$cpid  = intval($cpid);

				$R = $this->category_model->alterCategory($cid, $cname, $curl, $cpid);

				if ($R) {
					$category['errorcode']      = 0;
					$category['detail']['ID']   = $cid;
					$category['detail']['Name'] = $cname;
					$category['detail']['PID']  = $cpid;
					$this->cache->delete('all-category');
				}
			}
		}
		echo json_encode($category);
	}
}