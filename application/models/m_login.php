<?php
Class M_login extends CI_Model {
	
	function validasi($username, $password){
		$password = do_hash($password, 'md5');
		$sqlquery = "SELECT * FROM tbl_market_user a where email = '$username' and pass = '$password'";
		$ambil = $this->db->query($sqlquery);
		if($ambil->num_rows == 1){
			$blockir = $ambil->result_array();
			if($blockir[0]['role_id'] != 0 && $blockir[0]['approve'] != 1)
				if($blockir[0]['approve'] == 0)
					return 2;
				else
					return 3;
			if($blockir[0]['role_id'] != 0 && $blockir[0]['confirmation_email'] == null)
				return 4;
			
			if($blockir[0]['role_id'] != 0 && $blockir[0]['confirmation_email'] == 2)
				return 5;
			
			$max_item_create = 0;					
			$data = array('username' => $username, 'login' => true, 'nama' => $blockir[0]['first_name'], 'role_id' => $blockir[0]['role_id'], 'id' => $blockir[0]['id'], 'approved_date' => $blockir[0]['approved_date'], 'max_item_create' => $blockir[0]['max_item_create'], 'buy_item' => array(), 'link_ensiklopedia' => array());
			$this->session->set_userdata($data);
			return 1;
		}else
			return 0;
	}
	
	function get_name($password){
			
			$sqlquery = "SELECT blockir, id_level FROM tbl_admin a, tbl_lvl_admin b where nama = '$username' and pass = password('$password') and blockir = 0 AND a.id_level = b.id AND b.aktif =1";
			$ambil = $this->db->query($sqlquery);
			if($ambil->num_rows == 1){
				$blockir = $ambil->result_array();
				if ($blockir[0]['blockir'] == 0){
					$_SESSION['id_level']= $blockir[0]['id_level'];
					$_SESSION['username'] = $this->input->post('username');
					return 1;
				}
				else 
					return 2;
			}			
			else
				return 0;
	}
}
?>