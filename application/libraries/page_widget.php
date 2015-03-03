<?php if(!defined('BASEPATH'))exit('No direct script access allowed');
    /**
     *分页类 
     */
    Class Page_Widget {
        protected $CI;
        
        public function __construct() {
            $this->CI = &get_instance();//获取ci实例
        }
        
        /**
         * 第一种分页
         * 显示上一页，下一页，中间5个连续页码
         * 如：
         * <<  1  2  3  4  5  >>
         */
        public function page_1($curr_page, $totel_page, $url) {
            $R = "";

            if($curr_page > 0 && $totel_page >= $curr_page) { //合法的参数
                if ($curr_page == 1) {//当前是第1页
                    $pages = $totel_page >= 5 ? 5 : $totel_page;
                    $R = '<ul class="pagination">'
    						.'<li class="disabled"><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
    				for ($i = 1; $i <= $pages; $i++) {
    					$R .= '<li';
    					if ($i == 1) {
    					    $R .= ' class="active"';
    					}
    					$R .= '><a href="'. $url . $i . '">'. $i .'</a></li>';
    				}
    				$R .='<li title="末页"><a href="'.$url.$totel_page.'"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li></ul>';
                } else if ($curr_page == $totel_page) { //当前是最后一页
                    $R = '<ul class="pagination">'
    						.'<li title="首页"><a href="'.$url.'1"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
                    
                    $start_page = 1;
                    if ($totel_page >= 5) { //设置起始页
                        $start_page = $totel_page - 4;
                    }
                    
    				for ($i = $start_page; $i <= $totel_page; $i++) {
    					$R .= '<li';
    					if ($i == $curr_page) {
    					    $R .= ' class="active"';
    					}
    					$R .= '><a href="'. $url . $i . '">'. $i .'</a></li>';
    				}
    				$R .='<li class="disabled"><a href="'.$url . $totel_page.'"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li></ul>';
                    
                } else { //其他页
                    $R = '<ul class="pagination">'
    						.'<li title="首页"><a href="'. $url .'1"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
    				
    				$start_page = $curr_page > 2 ? $curr_page - 2 : 1; //开始页
    				$end_page   = $curr_page + 2 < $totel_page ? $curr_page : $totel_page; //结束页
    				
    				for ($i = $start_page; $i <= $end_page; $i++) {
    					$R .= '<li';
    					if ($i == $curr_page) {
    					    $R .= ' class="active"';
    					}
    					$R .= '><a href="'. $url . $i . '">'. $i .'</a></li>';
    				}
                    $R .='<li class="disabled"><a href="'.$url . $totel_page.'"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li></ul>';
                }
            } else { //不合法的参数
                
            }
            
            return $R;
        }
    }