<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

require_once (APPPATH.'libraries/Smarty/Smarty.class.php');

class CI_Smarty extends Smarty{
    protected $ci;
    function __construct(){
        
        parent::__construct();
        
        $this->ci = &get_instance();//获取ci实例
        
        $this->template_dir =  APPPATH."views"; //模板存放目录
        $this->compile_dir = APPPATH."cache/templates"; //编译目录
        $this->cache_dir = APPPATH."cache";//缓存目录。
        $this->caching = 0;
        //$this->cache_lifetime = 120; //缓存更新时间
        $this->debugging = FALSE;
        $this->compile_check = TRUE; //检查当前的模板是否自上次编译后被更改；如果被更改了，它将重新编译该模板。
        //$this->force_compile = true; //强制重新编译模板
        //$this->allow_php_templates= true; //开启PHP模板
        $this->left_delimiter = "<{"; //左定界符
        $this->right_delimiter = "}>"; //右定界符
        $this->smarty->assign('base_url', $this->ci->config->item('base_url')); //静态页面的css以及js路径
        
        //判断是否去掉index.php
        $index_page = !empty($this->ci->config->item('index_page')) ? "index.php/" : "";
        $this->smarty->assign("index_page", $index_page);
        
        $this->smarty->assign("vpath", DYH_VPATH); //视图路径
        $this->smarty->assign("spath", "static/".DYH_SPATH); //静态文件路径
     }
}