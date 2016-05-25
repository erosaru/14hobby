<?php
Class M_kategori extends CI_Model {
	function get_kategori(){		$this->db->order_by("name_kategori");		$this->db->from("tbl_kategori");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach($query->result() as $row){				$data[] = array($row->id => $row->name_kategori);			}			return $data;		}	
	}
	
	function ambil_sub_kategori($limit, $offset){		if((empty($offset) or ($offset == 0))){			$offset = 0;		}else {			$offset = ($offset - 1) * $limit;		}		$this->db->limit($limit, $offset);		$this->db->order_by("name_merk");		$query = $this->db->get("tbl_merk");		if($query->num_rows() > 0){			foreach($query->result() as $row){				$data[] = $row;			}			return $data;		}			}
	
	function ambil_type_produk($limit, $offset){
		if((empty($offset) or ($offset == 0))){
			$offset = 0;
		}else {
			$offset = ($offset - 1) * $limit;
		}
		$this->db->select("b.id, b.name_type_produk, a.name_kategori, c.name_sub_kategori");
		$this->db->from("tbl_type_produk b");
		$this->db->join("tbl_kategori a", "a.id = b.id_kategori");
		$this->db->join("tbl_sub_kategori c", "c.id = b.id_sub_kategori");
		$this->db->limit($limit, $offset);
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}		
	}
	
	function ambil_index_item($limit, $offset){		if((empty($offset) or ($offset == 0))){			$offset = 0;		}else {			$offset = ($offset - 1) * $limit;		}
								if($query->num_rows() > 0){			foreach($query->result() as $row){				$data[] = $row;			}			return $data;		}			}
	
	function jumlah_item(){		$id_kategori = $this->input->get("id_kategori");		if(!empty($id_kategori)){			$this->db->where("b.id_kategori", $id_kategori);		}				$id_merk = $this->input->get("id_merk");		if(!empty($id_merk)){			$this->db->where("b.id_merk", $id_merk);		}		$name_barang = $this->input->get("kata_kunci");		if(!empty($name_barang)){			$this->db->or_like('b.name_barang', $name_barang);			$this->db->or_like('b.type_produk', $name_barang);		}		$this->db->select("b.id, b.name_barang, a.name_kategori, c.name_sub_kategori, d.name_type_produk");
		$this->db->from("tbl_barang b");
		$this->db->join("tbl_kategori a", "a.id = b.id_kategori");
		$this->db->join("tbl_merk c", "c.id = b.id_merk");
		return $this->db->count_all_results();
	}
	
	function ambil_index_itemdijual($limit, $offset){		if((empty($offset) or ($offset == 0))){			$offset = 0;		}else {			$offset = ($offset - 1) * $limit;		}				$id_kategori = $this->input->get("id_kategori");		if(!empty($id_kategori)){			$this->db->where("tbl_barang.id_kategori", $id_kategori);		}				$id_merk = $this->input->get("id_merk");		if(!empty($id_merk)){			$this->db->where("tbl_barang.id_merk", $id_merk);		}		$name_barang = $this->input->get("kata_kunci");		if(!empty($name_barang)){			$this->db->or_like('tbl_barang.name_barang', $name_barang);			$this->db->or_like('tbl_barang.type_produk', $name_barang);		}		$this->db->select(array("tbl_barang_dijual.id", "tbl_barang.name_barang", "tbl_kategori.name_kategori", "tbl_merk.name_merk", "type_produk", "tbl_barang_dijual.stok", "tbl_barang_dijual.date_pre_order", "IFNULL(tbl_barang_dijual.slot, 0) as slot", "IFNULL(sum(tbl_barang_dijual_detail.slot), 0) AS use_slot"));		$this->db->group_by("tbl_barang_dijual.id");		$this->db->join("tbl_barang", "tbl_barang.id = tbl_barang_dijual.id_barang");		$this->db->join("tbl_kategori", "tbl_kategori.id = tbl_barang.id_kategori");				$this->db->join("tbl_merk", "tbl_merk.id = tbl_barang.id_merk");		$this->db->join("tbl_barang_dijual_detail", "tbl_barang_dijual_detail.barang_dijual_id = tbl_barang_dijual.id", "left");		$this->db->limit($limit, $offset);		$this->db->order_by("tbl_barang_dijual.id", "desc");		$query = $this->db->get("tbl_barang_dijual");		if($query->num_rows() > 0){			foreach($query->result() as $row){				$data[] = $row;			}			return $data;		}			}
	
	function jumlah_itemdijual(){
		$this->db->select("tbl_barang_dijual.id, tbl_barang.name_barang, tbl_kategori.name_kategori, tbl_merk.namemerk, type_produk, tbl_barang_dijual.stok, tbl_barang_dijual.date_pre_order");
		$id_kategori = $this->input->get("id_kategori");		if(!empty($id_kategori)){			$this->db->where("tbl_barang.id_kategori", $id_kategori);		}		
		$id_merk = $this->input->get("id_merk");		if(!empty($id_merk)){			$this->db->where("tbl_barang.id_merk", $id_merk);		}
		$name_barang = $this->input->get("kata_kunci");		if(!empty($name_barang)){			$this->db->or_like('tbl_barang.name_barang', $name_barang);			$this->db->or_like('tbl_barang.type_produk', $name_barang);		}				$this->db->from("tbl_barang_dijual");		$this->db->join("tbl_barang", "tbl_barang.id = tbl_barang_dijual.id_barang");		$this->db->join("tbl_kategori", "tbl_kategori.id = tbl_barang.id_kategori");				$this->db->join("tbl_merk", "tbl_merk.id = tbl_barang.id_merk");		$this->db->order_by("tbl_barang_dijual.id", "desc");		return $this->db->count_all_results();	}		function get_data_divisi(){		$this->db->order_by("name_divisi");		$result = $this->db->get("tbl_divisi");		foreach($result->result() as $row)			$data[] = array($row->id => $row->name_divisi);		return $data;	}
}
?>