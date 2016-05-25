<?php
Class M_roomuser extends CI_Model {
	function upload_picture_profile(){
		if(!empty($_FILES['profile_picture']['name'])){
			$type_file = strrchr(basename($_FILES['profile_picture']['name']),'.');
			$config["file_name"] = 'profile_'.$this->session->userdata('id').$type_file;
			$config["allowed_types"] = 'gif|jpg|png';
			$config["upload_path"] = "./uploads/profile";
			$config['max_size']  = '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '2000';
			$config['min_height']  = '768';
			$config['overwrite']  = true;
			$this->load->library('upload', $config);
			if ( !$this->upload->do_upload('profile_picture')){
				$this->session->set_flashdata('warning', $this->upload->display_errors());
				return false;
			}else
				return true;
		}else
			return true;
	}
	
	function get_name_photo_profile(){
		$type_file = strrchr(basename($_FILES['profile_picture']['name']),'.');
		$name = 'profile_'.$this->session->userdata('id').$type_file;
		$this->db->where('id', $this->session->userdata('id'));
		$profile = $this->db->get('tbl_market_user');
		$profile = $profile->result();
		if(!empty($profile[0]->foto))
			if($name == $profile[0]->foto || empty($_FILES['profile_picture']['name']))
				return $profile[0]->foto;
			else
				return $name;
		elseif(!empty($_FILES['profile_picture']['name']))
			return $name;
		else
			return null;
	}
	
	function upload_picture_item($id_item, $data){
		if(!empty($_FILES['picture']['name'])){
			$type_file = strrchr(basename($_FILES['picture']['name']),'.');
			$config["file_name"] = $this->session->userdata('id').'_'.create_title_foto($data['name']).'_'.$id_item.$type_file;
			$config["allowed_types"] = 'gif|jpg|png';
			$config["upload_path"] = "./uploads/market_item";
			$config['max_size']  = '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '2000';
			$config['min_height']  = '768';
			$config['overwrite']  = true;
			$this->load->library('upload', $config);
			if ( !$this->upload->do_upload('picture')){
				$this->session->set_flashdata('warning', $this->upload->display_errors());
				return false;
			}else
				return true;
		}else
			return true;
	}
	
	function get_name_photo_item($id){
		$type_file = strrchr(basename($_FILES['picture']['name']),'.');
		
		$this->db->where('id', $id);
		$item = $this->db->get('tbl_market_item');
		$item = $item->result();
		$name = $item[0]->merchant_id.'_'.create_title_foto($item[0]->name).'_'.$id.$type_file;
		if(!empty($item[0]->picture))
			if($name == $item[0]->picture || empty($_FILES['picture']['name']))
				return $item[0]->picture;
			else
				return $name;
		elseif(!empty($_FILES['picture']['name']))
			return $name;
		else
			return null;
	}
}
?>