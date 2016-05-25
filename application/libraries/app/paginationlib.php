<?php  
	class Paginationlib {
		//put your code here
		function __construct() {
			
		}
		
		public function initPagination($uri,$total_rows,$per_page=10,$segment=3){
			$config = array();
			$config["base_url"] = base_url() . $uri;
			$config["total_rows"] = $total_rows;
			$config["per_page"] = $per_page;
			$config["uri_segment"] = $segment;			
			$config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
			$config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';         
			$config['cur_tag_open'] = "<li class='active'><span><b>";
			$config['cur_tag_close'] = "</b></span></li>";
			$config['first_link'] = "&lsaquo;&lsaquo;";
			$config['last_link'] = "&rsaquo;&rsaquo;";
			return $config;    
		}		
	}
?>