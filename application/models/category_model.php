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
                        $category[$v['ID']]['Url']  = $v['url'];
                    } else {
                        $category[$v['parent']]['Child'][$v['ID']]['ID']   = $v['ID'];
                        $category[$v['parent']]['Child'][$v['ID']]['Name'] = $v['name'];
                        $category[$v['parent']]['Child'][$v['ID']]['Url'] = $v['url'];
                    }
                }
            }
            
            return $category;
        }

        /**
         * [getOneDetail 获取单个分类详情]
         * @param  [type] $cid [description]
         * @return [type]      [description]
         */
        public function getOneDetail($cid) {
            $sql = "SELECT dc.name as cname, dc.ID as cid, dcp.ID as pid, dc.url as URL FROM ds_category dc
                    LEFT JOIN ds_category dcp ON dcp.ID = dc.parent 
                    WHERE dc.ID = {$cid}";
            $query = $this->db->query($sql)->result_array();

            $category = Array();
            if (COUNT($query) > 0) {
                $category['Name'] = $query[0]['cname'];
                $category['ID']   = $query[0]['cid'];
                $category['PID']  = $query[0]['pid'];
                $category['URL']  = $query[0]['URL'];
            }

            return $category;
        }

        /**
         * [alterCategory 修改单个分类信息]
         * @param  [type] $cid  [description]
         * @param  [type] $cid  [description]
         * @param  [type] $curl [description]
         * @param  [type] $cpid [description]
         * @return [type]       [description]
         */
        public function alterCategory($cid, $cname, $curl, $cpid) {
            //, `parent` = {$cpid}
            $sql = "UPDATE `ds_category` SET `name` = '{$cname}', `url` = '{$curl}' WHERE `ID` = {$cid}";
            return $this->db->query($sql);
        }
        
    }