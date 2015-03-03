<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * 获取文章信息数据库类
     */
    Class Article_Model extends CI_Model {
        
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * 获取所有文章页面的一页的文章数据
         * @page: 当前页数
         * @num: 当前页面文章数
         */
        public function getPageArticles($page = 1, $num = 15) {
            $R = Array();
            $R['article_num'] = 0;
            
            //获取文章总数
            $sql = "SELECT COUNT(*) as num FROM `ds_articles` WHERE `status` = 1";
            $query = $this->db->query($sql);
            if ($query->num_rows > 0) {
                $R['article_num'] = $query->row()->num;
                $from = ($page - 1) * $num;
                
                //获取当前页面文章
                $csql = "SELECT da.ID as aid, da.title as title, da.post_time as post_time, da.update_time as update_time,dc.name as cname,dc.ID as cid FROM `ds_articles` da
                        LEFT JOIN ds_category dc ON dc.id = da.category
                        WHERE `status` = 1
                        ORDER BY `post_time` DESC
                        LIMIT {$from}, {$num}";
                $R['data'] = $this->db->query($csql)->result_array();
            }
            
            if (isset($R['data']) && COUNT($R['data']) > 0) {
                $R['errorcode'] = 0;
            } else {
                $R['errorcode'] = 1;
            }
            
            return $R;
        }
        
        /**
         * 获取文章详情
         * @aid： 文章id
         */
        public function getArticleDetail($aid) {
            if (is_numeric($aid)) {
                $sql = "SELECT * FROM ds_articles WHERE ID = {$aid}";
                return $this->db->query($sql)->result_array();
            }
            return ;
        }
        
        
    }