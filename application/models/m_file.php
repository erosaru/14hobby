<?php
Class M_file extends CI_Model {
	
	function get_nama_gambar_barang($id_barang){
		$sql = "SELECT MAX(id) as id FROM tbl_gambar_barang WHERE id_barang = $id_barang";
		$x = $this->db->query($sql);
		$data = $x->result();
		$id = $data[0]->id;
		if(empty($id))
			$id = 1;
		else
			$id++;	
		
		return $id_barang."_".$id."_".date('m-d-Y');
	}

	function input_update_banner($id_banner){
			$sql = "SELECT * FROM tbl_banner_home WHERE id_gambar_banner = $id_banner";
			$x = $this->db->query($sql);
			$jumlah = $query->num_rows();
			if($jumlah > 0){
				$sql = "update  FROM tbl_banner_home WHERE id_gambar_banner = $id_banner";
			}
	}
	
	function insert_gambar_barang($data){
			return $this->db->insert('tbl_gambar_barang',$data);
	}	
	
	function set_set_gambar($id_barang){
			$this->db->where("id_barang", $id_barang);
			$this->db->where("flag", 1);
			$this->db->limit(1);
			$this->db->order_by("id_gambar", "asc");
			$data = array(
						"set_gambar" => 1,
					);
			return $this->db->update('tbl_gambar_barang', $data);
	}	
	
	
}
?>