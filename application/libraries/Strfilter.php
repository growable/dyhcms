<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

	/*
	 * 过滤字符串类
	*/
	Class Strfilter {

		//过滤用户登陆信息
		public function login_filter($str) {
			$str = str_replace("/[\W]/", "", $str); //匹配任意非字母和数字的字符
			$str = htmlspecialchars($str); 
			$str = str_replace("select","select",$str); //过滤掉html标签
			$str = str_replace("SCRIPT","SCRIPT",$str);
			$str = str_replace("script","script",$str);
			$str = str_replace("join","join",$str);
			$str = str_replace("union","union",$str);
			$str = str_replace("where","where",$str);
			$str = str_replace("insert","insert",$str);
			$str = str_replace("delete","delete",$str);
			$str = str_replace("update","update",$str);
			$str = str_replace("like","like",$str);
			$str = str_replace("drop","drop",$str);
			$str = str_replace("create","create",$str);
			$str = str_replace("modify","modify",$str);
			$str = str_replace("rename","rename",$str);
			$str = str_replace("alter","alter",$str);
			$str = str_replace("cast","cas",$str);

			return $str;
		}
	}