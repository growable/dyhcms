<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * 获取文章信息数据库类
     */
    Class Category_Model extends CI_Model {
        
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * 获取所有文章分类
         */
         
        public function getAllCategory() {
            $sql = "SELECT * FROM `ds_category` ORDER BY ID ASC";
            $cate = $this->db->query($sql)->result_array();
            
            $category = Array();
            if (COUNT($cate) > 0) {
                foreach ($cate as $c => $v) {
                    if ($v['parent'] == 0) {
                        $category[$v['ID']]['ID']   = $v['ID'];
                        $category[$v['ID']]['Name'] = $v['name'];
                    } else {
                        $category[$v['parent']]['Child'][$v['ID']]['ID']   = $v['ID'];
                        $category[$v['parent']]['Child'][$v['ID']]['Name'] = $v['name'];
                    }
                }
            }
            
            return $category;
        }
        
    }