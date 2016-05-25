<?php
Class M_item extends CI_Model {
	
	function get_same_series_in_stock($series, $id_barang, $divisi_id){
		if(!empty($series)){
			$data = array();
			$this->db->select(array("tbl_barang.*", "ifnull(sum(tbl_barang_detail.stock), 0)"));
			$this->db->join("tbl_barang_detail", "tbl_barang_detail.id_barang = tbl_barang.id", "left");
			$this->db->having("sum(tbl_barang_detail.stock) > 0");
			$this->db->group_by("tbl_barang.id");
			$this->db->where("series", $series);
			$this->db->where("tbl_barang.id <>", $id_barang);
			$this->db->where("divisi_id", $divisi_id);
			$this->db->order_by("id", "random");
			$this->db->limit(5);
			$result = $this->db->get("tbl_barang");
			if($result->num_rows() > 0)
				foreach($result->result() as $row)
					$data[] = $row;
			if(count($data)>0)
				$this->db->where_not_in("id", array_map(function($item) {return $item->id;}, $data));
			$this->db->where("series", $series);
			$this->db->where("tbl_barang.id <>", $id_barang);
			$this->db->where("divisi_id", $divisi_id);			
			$this->db->order_by("id", "random");
			$this->db->limit(15 - count($data));
			$result = $this->db->get("tbl_barang");
			if($result->num_rows() > 0)
				foreach($result->result() as $row)
					$data[] = $row;
			if(count($data) > 0)
				return $data;
			else
				return null;
		}else
			return null;
	}
	
	function get_same_series_tipe($tipe){
		if(!empty($tipe)){
			$tipe = explode(",",$tipe);
			foreach($tipe as $row)
				$this->db->or_like("tbl_barang.type_produk", $row);			
			$result = $this->db->get("tbl_barang");
			if($result->num_rows()>0)
				return $result->result();
			else
				return null;				
		}else
			return null;
	}
}
?>