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


        /**
         * [checkUrlExist description]
         * @param  [type] $url [description]
         * @return [type]      [description]
         */
        public function checkUrlExist($url) {
            $sql = "SELECT * FROM `ds_articles` WHERE `url_title` = '{$url}' LIMIT 1";
            return $this->db->query($sql)->result_array();
        }

        /**
         * [addArticle 新增文章]
         * @param [type] $title   [description]
         * @param [type] $url     [description]
         * @param [type] $desc    [description]
         * @param [type] $content [description]
         * @param [type] $cate    [description]
         */
        public function addArticle($title, $url, $desc, $content, $cate, $type){
            $time = date("Y-m-d H:i:s");
            $sql = "INSERT INTO `ds_articles` (`title`, `url_title`, `description`, `content`, `category`, `post_time`, `update_time`, `status`)
                                VALUES ('{$title}', '{$url}', '{$desc}', '{$content}', $cate, '{$time}', '{$time}', {$type})";
            $this->db->query($sql);
            return $this->db->insert_id();
        }

        /**
         * [updateArticle更新文章信息]
         * @param  [type] $aid     [description]
         * @param  [type] $title   [description]
         * @param  [type] $url     [description]
         * @param  [type] $desc    [description]
         * @param  [type] $content [description]
         * @param  [type] $cate    [description]
         */
        public function updateArticle($aid, $title, $url, $desc, $content, $cate) {
            $time = date("Y-m-d H:i:s");
            $sql = "UPDATE `ds_articles` SET `title` = '{$title}', `url_title` = '{$title}', `description` = '{$desc}',
                                `content` = '{$content}', `category` = {$cate}, `update_time` = '{$time}'
                    WHERE `ID` = {$aid}";
            $this->db->simple_query($sql);
        }
        
        
    }