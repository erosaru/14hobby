<?php
Class M_subkategori extends CI_Model {
	function get_sub_kategori_db(){	
		$this->db->from("tbl_sub_kategori");
		$query = $this->db->get();
	
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row->name_sub_kategori;
			}
			return $data;
		}else 
			return "";	
	}
	
	function get_sub_kategori(){
		$get_sub_kategori = $this->get_sub_kategori_db();				
		if(!empty($get_sub_kategori))
			return '"'.implode('","',$get_sub_kategori).'"';	
		else
			return "";
	}
}
?>