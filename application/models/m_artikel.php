<?php
Class M_artikel extends CI_Model {
	function ambil($limit, $offset){
		if((empty($offset) or ($offset == 0))){
			$offset = 0;
		}else {
			$offset = ($offset - 1) * $limit;
		}
		
		
		$this->db->select("tbl_artikel.id, counter, title, pengarang, pesan, kategori, created_date, tbl_kategori_artikel.name_kategori, url_title");
		$this->db->join("tbl_kategori_artikel", "tbl_artikel.id_kategori_artikel = tbl_kategori_artikel.id");
		 
		$this->db->limit($limit, $offset);
		
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}		
	}
	
	function jumlah(){
		$id_kategori_artikel = $this->input->get("id_kategori_artikel");
		$pengarang = $this->input->get("nama_penulis");
		$judul_artikel = $this->input->get("nama_artikel");
		$kategori = $this->input->get("kategori");
		if(!empty($id_kategori_artikel))
			$this->db->where("id_kategori_artikel", $id_kategori_artikel);
		if(!empty($pengarang))
			$this->db->like("pengarang", $pengarang);
		if(!empty($judul_artikel))
			$this->db->like("title", $judul_artikel);
		if(!empty($kategori))
			$this->db->like("kategori", $kategori);
		$this->db->select("tbl_artikel.id, title, pengarang, pesan, kategori, created_date, tbl_kategori_artikel.name_kategori, url_title");
		$this->db->join("tbl_kategori_artikel", "tbl_artikel.id_kategori_artikel = tbl_kategori_artikel.id");
		 
		$this->db->order_by("tbl_artikel.id", "desc");
		$this->db->from("tbl_artikel");
		return $this->db->count_all_results();
	}
	
	function get_data_kategori_artikel($limit, $offset, $table){
		if((empty($offset) or ($offset == 0))){
			$offset = 0;
		}else {
			$offset = ($offset - 1) * $limit;
		}
		$this->db->select("tbl_artikel.id, title, pengarang, pesan, kategori, created_date, tbl_kategori_artikel.name_kategori");
		$this->db->join("tbl_kategori_artikel", "tbl_artikel.id_kategori_artikel = tbl_kategori_artikel.id");
		$this->db->from($table);
		$this->db->limit($limit, $offset);
		$this->db->order_by("tbl_artikel.id", "desc");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}		
	}
	
	function get_kategori(){
		$this->db->group_by("kategori");
		$query = $this->db->get("tbl_artikel");
	
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row->kategori;
			}
		}
		
		if(!empty($data))
			return '"'.implode('","',$data).'"';	
		else
			return "";
	}
}
?>