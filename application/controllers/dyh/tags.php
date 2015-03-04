<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model("tag_model");
	}

	public function index()
	{
		$this->smarty->assign("title", "Tags");
		$this->smarty->display(DYH_CPATH . "tags.html");
	}

	//删除文章标签, 关联信息
	public function delete() {
		$R = Array('errorcode' => 1);
		$tid = $this->input->post('tid');
		if (!empty($tid) && is_numeric($tid)) {
			$status = $this->tag_model->deleteTagsAssoc($tid);

			if ($status) {
				$R['errorcode'] = 0;
				$R['msg'] = "Success";
			} else {
				$R['msg'] = "Success";
			}
		}

		echo json_encode($R);
	}

	//添加标签
	public function add() {
		$R = Array('errorcode' => 1);
		$val = $this->input->post('val');
		$aid = $this->input->post('aid');

		if (!empty($val) && is_numeric($aid)) {
			$tag_arr = explode(",", $val);
			$aid = mysql_real_escape_string($aid);

			$str = "";
			foreach ($tag_arr as $k => $v) {
				$tag = mysql_real_escape_string($v);
				//检查该标签是否已经存在
				$res = $this->tag_model->checkTagIsExist($tag);

				if (COUNT($res) > 0) { //已存在
					$tid = $res[0]['ID'];
					$nid = $this->tag_model->addTagsAssoc($tid, $aid);
					$str .= '<span class="label label-primary tag-label" title="点击删除" data-tid="'. $nid .'">'. $tag .'</span>';
				} else { //不存在
					$tid = $this->tag_model->addTags($tag);
					$nid = $this->tag_model->addTagsAssoc($tid, $aid);
					$str .= '<span class="label label-primary tag-label" title="点击删除" data-tid="'. $nid .'">'. $tag .'</span>';
				}				
			}

			$R['errorcode'] = 0;
			$R['msg']  = 'Success';
			$R['data'] = $str;
		}

		echo json_encode($R);
	}
}