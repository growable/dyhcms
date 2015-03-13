<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//系统基础的数据处理,包括文章，分类，标签，登陆，用户的数据处理
	class Login_Models extends CI_Model {
			
		public function loginValidate($name, $pwd)
		{
			$sql = "SELECT `ID`, `login_name` FROM ds_user WHERE `login_name` = '{$name}' AND `pwd` = '" . md5($pwd) . "'";

			return $this->db->query($sql);
		}

		//插入新用户数据
		public function BS_insert_user($name, $role) {
			$pwd = md5("123456");
			$time = date("Y-m-d H:i:s");
			$sql = "INSERT INTO ds_user(`login_name`, `pwd`, `role`, `nickname`,`reg_time`) VALUES ('{$name}', '{$pwd}','{$role}', '{$name}','{$time}')";

			$query = $this->db->query($sql);

			return mysql_insert_id();
		}

		//检查用户名是否存在
		public function BS_validate_user_exist($name) {
			$sql = "SELECT ID FROM ds_user WHERE `login_name` = '{$name}'";
			$query = $this->db->query($sql);
			return $query;
		}

		//获取10位用户, $num 页数
		public function BS_get_ten_users($num = 0) {
			$start = $num * 10;
			$sql = "SELECT * FROM ds_user WHERE `isdelete` = 0 ORDER BY `reg_time` ASC LIMIT {$start}, 10";

			return $this->db->query($sql);
		}

		//获取单个用户的信息
		public function BS_single_user_info($id) {
			$id = (int) $id;
			if (is_numeric($id)) {
				$sql = "SELECT * FROM ds_user WHERE `ID` = {$id}";
				return $this->db->query($sql);
			} else {
				return false;
			}
		}

		//更新用户信息
		public function BS_update_user_info($id, $name, $nick, $pwd,$email, $status, $role) {
			$fields = array(
					"`login_name` = '{$name}'",
					"`role` = {$role}",
					"`pwd` = '{$pwd}'",
					"`email` = '{$email}'",
					"`nickname` = '{$nick}'",
					"`status` = {$status}"
				);
			$fields_str = implode(",", $fields);
			$sql = "UPDATE ds_user SET {$fields_str} WHERE `ID` = {$id}";

			return $this->db->query($sql) ? true : false;
		}

		//设置用户状态
		public function BS_update_user_status($id, $status) {
			$sql = "UPDATE ds_user SET `status` = {$status} WHERE `ID` = {$id}";
			return $this->db->query($sql) ? true : false;
		}


		//删除用户
		public function BS_delete_user($user_id) {
			$sql = "UPDATE ds_user SET `isdelete` = 1 WHERE `ID` = {$user_id}";
			return $this->db->query($sql) ? true : false;
		}

		//添加分类
		public function BS_add_category($name, $parent, $alis, $url) {
			$sql = "INSERT INTO 17ds_category (`name`, `parent`,`name_alis`, `name_url`) VALUES ('{$name}', {$parent}, '{$alis}', '{$url}')";
			return $this->db->query($sql) ? true : false;
		}

		//判断分类是否存在
		public function BS_category_isexist($name, $parent) {
			$sql = "SELECT ID FROM 17ds_category WHERE name = '{$name}' AND parent = {$parent}";
			return $this->db->query($sql);
		}

		//获取所有分类
		public function BS_category() {
			$sql = "SELECT dc.ID as id, dc.name, dcc.ID as cid, dcc.name as cname FROM 17ds_category dc
					LEFT JOIN 17ds_category dcc ON dcc.parent = dc.ID
					WHERE dc.parent = 0
					ORDER BY dc.ID ASC, dcc.ID ASC";
			return $this->db->query($sql);
		}

		//判断标签是否存在
		public function BS_tags_exist($name) {
			$sql = "SELECT ID FROM 17ds_tags WHERE name = '{$name}'";
			return $this->db->query($sql);
		}


		//添加tags
		public function BS_add_tags($name) {
			$sql = "INSERT INTO 17ds_tags (`name`) VALUES ('{$name}')";

			return $this->db->query($sql) ? mysql_insert_id() : false;
		}

		//文章关联tag  $target:文章id， $assoc:tag id
		public function BS_article_tag_assoc($target, $assoc) {
			$sql = "INSERT INTO 17ds_assoc (`assoc`, `target`, `type`) VALUES({$assoc}, {$target}, 1)";

			$this->db->query($sql);
		}

		//获取所有的tags
		public function BS_tags($page) {
			$page = ($page - 1) * 10;
			$sql = "SELECT * FROM 17ds_tags ORDER BY ID DESC LIMIT {$page}, 10";
			return $this->db->query($sql);
		}

		//获取tag的总页数
		public function BS_tags_pages() {
			$sql = "SELECT COUNT(ID) as num FROM 17ds_tags";
			$page_num = $this->db->query($sql);
			$pages = $page_num->result();
			return ceil($pages[0]->num / 10 );
		}

		//删除tag
		public function BS_delete_tag($assoc_id) {
			$sql = "DELETE FROM 17ds_assoc WHERE ID = {$assoc_id} AND type = 1";
			return $this->db->query($sql);
		}

		//删除tag表中的tag
		public function BS_delete_tag_source($id) {
			$sql = "DELETE FORM 17ds_tags 
					WHERE ID = {$id}";
			return $this->db->query($sql);
		}

		//删除tag关联的文章
		public function BS_delete_tag_assoc($id) {
			$sql = "DELETE FROM 17ds_assoc
					WHERE assoc = {$id} AND type = 1";
			return $this->db->query($sql);
		}

		//通过tag id，获取tag name
		public function BS_article_tags($id) {
			$sql = "SELECT dt.ID as ID, dt.name as name, da.ID as aid FROM 17ds_tags dt 
					LEFT JOIN 17ds_assoc da ON da.assoc = dt.ID 
					WHERE da.target = {$id}";
			return $this->db->query($sql);
		}


		//添加文章
		public function BS_insert_article($title, $url, $descri, $content, $category, $time, $tags) {
			$keys   = array("`title`","`url_title`", "`description`", "`content`", "`category`", "`post_time`, `from_keywords`");
			$values = array("'{$title}'", "'{$url}'", "'{$descri}'", "'{$content}'", "{$category}", "'{$time}', '{$tags}'");
			$keys_str   = implode(", ", $keys);
			$values_str = implode(", ", $values);
			$sql = "INSERT INTO 17ds_articles({$keys_str}) VALUES ({$values_str})";
			$this->db->query($sql);

			return mysql_insert_id();
		}


		//获取文章信息
		public function BS_article_info($id) {
			$sql = "SELECT * FROM 17ds_articles WHERE ID = {$id}";

			return $this->db->query($sql);
		}

		//获取分页的文章信息
		public function BS_page_articles($page) {
			$page = ($page - 1) * 10;
			$sql = "SELECT da.ID as ID, da.title, da.url_title, da.post_time, dc.ID as cid, dc.name as category
					FROM 17ds_articles da 
					LEFT JOIN 17ds_category dc ON dc.ID = da.category
					ORDER BY da.ID DESC
					LIMIT {$page}, 10";
			return $this->db->query($sql);
		}

		//快速更新文章信息
		public function BS_update_article($id, $title, $url_title, $description, $category) {
			$time = date("Y-m-d H:i:s");
			$values = Array(
				"`title`  = '{$title}'", 
				"`url_title` = '{$url_title}'", 
				"`description` = '{$description}'", 
				"`category` = '{$category}'", 
				"`update_time` = '{$time}'");

			$values_str = implode(",", $values);
			$sql = "UPDATE 17ds_articles SET {$values_str} WHERE ID = {$id}";
			return $this->db->query($sql);
		}

		//更新文章信息
		public function BS_update_article_full($id, $title, $url_title, $description, $category, $content) {
			$time = date("Y-m-d H:i:s");
			$values = Array(
				"`title`  = '{$title}'", 
				"`url_title` = '{$url_title}'", 
				"`description` = '{$description}'", 
				"`category` = '{$category}'", 
				"`update_time` = '{$time}'",
				"`content` = '{$content}'");

			$values_str = implode(",", $values);
			$sql = "UPDATE 17ds_articles SET {$values_str} WHERE ID = {$id}";
			return $this->db->query($sql);
		}

		//删除文章
		public function BS_del_article($aid) {
			$sql = "DELETE FROM 17ds_articles
					WHERE ID = {$aid}";
			return $this->db->query($sql);
		}

		//删除文章标签
		public function BS_del_article_tags($aid) {
			$sql = "DELETE FROM 17ds_assoc
				 WHERE target = {$aid}";
			return $this->db->query($sql);
		}

		//验证url
		public function BS_verify_url($url) {
			$sql = "SELECT * FROM 17ds_articles WHERE url_title = '{$url}'";
			return $this->db->query($sql)->result_array();
		}

		//更新tag
		public function BS_update_tag($id, $name) {
			$sql = "UPDATE 17ds_tags 
					SET name = '{$name}'
					WHERE ID = {$id}";
			return $this->db->query($sql);
		}

	}