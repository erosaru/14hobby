<?php
	class Sitemap extends CI_Controller {
		public function __construct(){
			parent::__construct();
		}
		
		public function index(){
			$data['item'] = $this->db->get("tbl_barang");
			$data['artikel'] = $this->db->get("tbl_artikel");
			header("Content-Type: text/xml;charset=iso-8859-1");
			$this->load->view("client/sitemap", $data);
		}		
	}
?>
