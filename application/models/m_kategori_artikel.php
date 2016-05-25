<?php
Class M_kategori_artikel extends CI_Model {
	function get_sub_kategori_artikel_db(){	
		$this->db->from("tbl_kategori_artikel");
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
		$get_sub_kategori = $this->get_sub_kategori_artikel_db();				
		if(!empty($get_sub_kategori))
			return '"'.implode('","',$get_sub_kategori).'"';	
		else
			return "";
	}
	
	public function get_list_kategori_artikel($nilai = 0){
		$query = $this->db->get('tbl_kategori_artikel');
		if($nilai == 1)
			$data[] = array("" => "");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = array($row->id => $row->name_kategori);
			}
			
		}else
			$data[] = array("" => "");
		return $data;
	}
}
?>