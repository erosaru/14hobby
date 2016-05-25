<?php
Class M_kartu extends CI_Model {
	public function get_id_sub_kategori($name){
		$this->db->where("name_sub_kategori like '%$name%'");
		$this->db->from("tbl_sub_kategori");
		$query = $this->db->get();
		$data = $query->result();
		return $data[0]->id;
	}
	
	function get_kartu($limit, $offset){
		if((empty($offset) or ($offset == 0))){
			$offset = 0;
		}else {
			$offset = ($offset - 1) * $limit;
		}
		$this->db->select("tbl_kartu.id, name_sub_kategori, name_card, booster_set");
		$this->db->join("tbl_sub_kategori", "tbl_sub_kategori.id = tbl_kartu.id_sub_kategori");
		$this->db->limit($limit, $offset);
		$this->db->order_by("tbl_kartu.id", "desc");
		$this->db->from("tbl_kartu");
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_booster_set_db($card_game_name){
		$this->db->where("id_sub_kategori", $card_game_name);
		$this->db->group_by("booster_set");
		$this->db->select("booster_set");		
		$this->db->order_by("booster_set", "asc");
		$this->db->from("tbl_kartu");
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row->booster_set;
			}
			return $data;
		}else 
			return "";	
	}
	
	function get_booster_set($card_game_name, $split){
		$get_booster_set = $this->get_booster_set_db($card_game_name);
		if(!empty($get_booster_set))
			if(!empty($split))
				return '"'.implode('","',$get_booster_set).'"';	
			else
				return implode(',',$get_booster_set);	
			
		else
			return "";		
	}
	
	function get_name_card_db($card_game_now){
		$this->db->where("id_sub_kategori", $card_game_now);
		$this->db->group_by("name_card");
		$this->db->select("name_card");		
		$this->db->order_by("name_card", "asc");
		$this->db->from("tbl_kartu");
		$query = $this->db->get();
	
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row->name_card;
			}
			return $data;
		}else 
			return "";	
	}
	
	function get_name_card($card_game_name, $split){
		$get_name_card = $this->get_name_card_db($card_game_name);				
		if(!empty($get_name_card))
			if(!empty($split))
				return '"'.implode('","',$get_name_card).'"';	
			else
				return implode(',',$get_name_card);	
		else
			return "";
	}
}
?>