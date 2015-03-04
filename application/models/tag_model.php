<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * 获取标签信息
     */
    Class Tag_Model extends CI_Model {
        
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * 获取文章tag
         * @aid: 文章id
         */
         
        public function getArticleTags($aid) {
            $sql = "SELECT da.ID as tid, dt.name as tname 
                    FROM `ds_tags` dt
                    LEFT JOIN `ds_assoc` da ON da.assoc = dt.ID
                    WHERE da.target = {$aid}
                    AND da.type = 1";

            return $this->db->query($sql)->result_array();
        }

        /**
         * 删除文章和标签之间的关联信息
         * @tid:标签id
         */
        public function deleteTagsAssoc($tid) {
            $sql = "DELETE FROM `ds_assoc` WHERE `ID` = {$tid}";
            return $this->db->simple_query($sql);
        }

        /**
         * 添加文章和标签之间的关联
         * @tid:标签id
         * @aid:文章id
         */
        
        public function addTagsAssoc($tid, $aid) {
            $sql = "INSERT INTO `ds_assoc` (`assoc`, `target`, `type`) VALUES({$tid}, {$aid}, 1)";
            $this->db->query($sql);
            return $this->db->insert_id();
        }

        /**
         * 检查标签是否存在
         * @tag: 需要检查的标签
         */
        public function checkTagIsExist($tag) {
            $sql = "SELECT * FROM `ds_tags` WHERE name = '{$tag}' LIMIT 1";

            return $this->db->query($sql)->result_array();
        }

        /**
         * 添加新标签
         * @tag: 标签内容
         */
        
        public function addTags($tag) {
            $sql = "INSERT INTO `ds_tags` (`name`) VALUES('{$tag}')";
            $this->db->simple_query($sql);

            return $this->db->insert_id();
        }
        
    }