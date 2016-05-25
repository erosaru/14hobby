<?php
Class M_home extends CI_Model {	
	function ambil($limit, $offset, $table){
		if((empty($offset) or ($offset == 0))){
			$offset = 0;
		}else {
			$offset = ($offset - 1) * $limit;
		}
		
		$this->db->from($table);
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
	
	function link_paging($batas, $halaman, $link, $jumdata, $parameter = ""){
		$x = "<div class='pagination pagination-centered'><ul>";
		if(empty($halaman)){
			$posisi = 0;
			$halaman =1;
		}else {
			$posisi = ($halaman - 1) * $batas;
		}
		$jumhal = ceil($jumdata / $batas);
		
		if($halaman > 1){
			$prev = $halaman - 1;
			$x .= "<li><a href=\"$link/$prev".$parameter."\">&laquo; Prev</a></li>";
		}else
			$x .= "<li class=\"disabled\"><a >&laquo; Prev</a></li>";
		
		for($i = 1;$i<=$jumhal;$i++){
			if($i != $halaman){
				$x .= "<li><a href=\"$link/$i".$parameter."\">$i</a</li>";
			}else
				$x .= "<li class='active'><a >$i</a></li>";
		}
		
		if($halaman < $jumhal){
			$next = $halaman+1;
			$x .= " <li class=\"prevnext\"><a href=\"$link/$next".$parameter."\">Next &#187;</a></li>";
		}else 
			$x .= "<li class=\"disabled\"><a >Next &#187;</a></li>";
			
		$x .= "</ul>";
		return $x."</div>";
	}
	
	public function get_list_sub_kategori_by_kategori($kategori){
		$this->db->where("name_kategori like '%$kategori%'");
		$this->db->from("tbl_kategori");
		$query = $this->db->get();
		$x = $query->result();
		$id =  $x[0]->id;
		
		$this->db->where("id_kategori", $id);
		$this->db->from("tbl_sub_kategori");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = array($row->id => $row->name_sub_kategori);
			}
			return $data;
		}		
	}
	
	public function get_list_tipe_item_by_kategori($kategori){
		$this->db->where("name_kategori like '%$kategori%'");
		$this->db->from("tbl_kategori");
		$query = $this->db->get();
		$x = $query->result();
		$id =  $x[0]->id;
		
		$this->db->where("id_kategori", $id);
		$this->db->from("tbl_type_produk");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = array($row->id => $row->name_type_produk);
			}
			return $data;
		}		
	}
	
	public function get_kategori($divisi_id = null, $option = 0){
		if($divisi_id != null)
			$this->db->where("divisi_id", $divisi_id);
		if($option == 1)
			$this->db->where("ensiklopedia", 1);
		$query = $this->db->get("tbl_kategori");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = array($row->id => $row->name_kategori);
			}
			return $data;
		}		
	}
	
	public function get_merk($divisi_id = null, $option = 0){
		if($divisi_id != null)
		$this->db->where("divisi_id", $divisi_id);
		if($option == 1)
			$this->db->where("ensiklopedia", 1);
		$this->db->order_by("name_merk");
		$query = $this->db->get("tbl_merk");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = array($row->id => $row->name_merk);
			}
			return $data;
		}		
	}
	
	public function get_kurs(){
		$data[] = array("IDR" => "Rp");
		$data[] = array("USD" => "$");
		$data[] = array("JPY" => "&yen;");
		return $data;
	}
	
	function get_type_produk(){
		$this->db->select("DISTINCT(type_produk)");
		$query = $this->db->get("tbl_barang");
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row->type_produk;
			}
		}else 
			$data = null;

		if(!empty($data))
			/*
			if(!empty($split))
				return '"'.implode('","',$data).'"';	
			else
				return implode(',',$data);				
			*/
			return '"'.implode('","',$data).'"';				
		else
			return "";		
	}
	
	function detail_stock(){
		$this->db->select("DISTINCT(information)");
		$query = $this->db->get("tbl_barang_detail");
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row->information;
			}
		}else 
			$data = null;
		
		if(!empty($data))
			return '"'.implode('","',$data).'"';				
		else
			return "";		
	}
}
?>