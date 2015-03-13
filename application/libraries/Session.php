<?php
//2012-2-14
class Session {

	private $CI;

	//构造方法
	function __construct(){
		if(!session_id()) session_start();
    //$this->CI =	& get_instance();

	}

	//设置 Session
	public function set($name, $value){
		if(!isset($name) || !isset($value)) exit('必须键入session名和session值');
		$_SESSION[$name] = $value;
	}

	//读取 Session
	public function get($key){
		if(empty($key)) exit('必须提供key');
		if(!array_key_exists($key, $_SESSION)) return false; //键是否存在
		return $_SESSION[$key];
	}

	//销毁 Session
	public function destory() {
		if(!isset($_SESSION)) return null;
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-1, '/');
		}
		session_unset();   //把内存中的session 内容清空
		session_destroy(); //把服务器端的session 文件清空掉
	}

	//删除单个 Session
	public function delete($sess_name) {
		if(! isset($sess_name)) exit("使用此方法时候必须带有参数,destory()方法不需要参数");
		if(array_key_exists($sess_name, $_SESSION)){
      unset($_SESSION[$sess_name]);
    }else{
      exit('需要注销的 Session 变量不存在！');
		}
	}

	//过滤字符串(去除空格)
	private function fliterString($str){
		return addslashes(trim($str));
	}
     function all_userdata()
	{
		return $_SESSION;
	}
}
