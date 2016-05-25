<?php
Class M_proses extends CI_Model {
	function add_to_counter() {
		if($this->session->userdata('role_id') != 1){
			$today = date('Y-m-d');
			switch($this->router->fetch_method()){
				case "list_komunitas":
				case "daftar_komunitas":			
					$name_controller = "list_komunitas";
					break;
				case "daftar_toko":
				case "list_toko":			
					$name_controller = "list_toko";
					break;
				case "index":
					if($this->router->fetch_class() == "page")
						$name_controller = "home";
					else
						$name_controller = $this->router->fetch_class();
					break;
				default:
					$name_controller = $this->router->fetch_class();
					break;
			}
			
			$data = array(
					'controller_name' => $name_controller,
					'created_date' => $today
				);
			$this->db->insert('tbl_counter',$data);
		}
	}
	
	function get_kurs(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://www.adisurya.net/kurs-bca/get');
		$kurs_bca = curl_exec($ch);
		curl_close($ch);
		$kurs_bca = json_decode($kurs_bca, true);
		$find_kurs = array("USD", "JPY");
		for($i=0;$i<count($find_kurs);$i++){
			$x = new StdClass;
			$x->kurs = $find_kurs[$i];
			$x->jual = $kurs_bca['Data'][$find_kurs[$i]]['Jual'];
			$x->beli = $kurs_bca['Data'][$find_kurs[$i]]['Beli'];
			$kurs[] = $x;
		}		
		return($kurs);
	}
	
	function uget_data_one($field, $from, $where, $order_id, $order_type){
		$this->db->select($field);
		$this->db->from($from);
		$this->db->where($where);
		if(!empty($order_id) and !empty($$order_type))
			$this->db->order_by($order_id, $order_type);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$hdata = $query->result_array();
			return $hdata;
		}	
	}
		
	function uupdate_data_one($table, $data, $f_where, $v_where){
		//return $this->db->update_string($table, $data, $where);
		if($v_where == "")
			$this->db->where($f_where);
		else	
			$this->db->where($f_where, $v_where);
		return $this->db->update($table, $data);
	}
	
	function get_url_title($title){
		//echo "$title<br/>";
		$x = strtolower(str_replace(":", "",$title));
		//echo "$x<br/>";
		$z = str_replace( " ", "-", $x);
		$z .= ".html";
		//echo "$z<br/>";
		return $z;
	}
	
	function delete_file($id_gambar){
		$this->load->helper('file');
		$sql = "select link_gambar from tbl_gambar_barang where id = $id_gambar";
		$x = $this->db->query($sql);
		$hdata = $x->result_array();
		$nama = $hdata[0]['link_gambar'];
		$file = "./uploads/".$nama;
		if (file_exists($file)){
			unlink($file);
			$sql = "delete from tbl_gambar_barang where id = $id_gambar";
			$x = $this->db->query($sql);
			return $file;
		}
		else 
			return "Tidak ada file nya";
	}
	
	function get_gambar($id){
		$this->db->select('id_barang, id, link_gambar, set_gambar');
		$this->db->from('tbl_gambar_barang');
		$this->db->where('id_barang', $id);
		$this->db->where('flag', 1);
		$this->db->order_by("set_gambar", "desc");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}else return ;
	}
	
	function get_gambar_kartu($id){
		$this->db->select('id_barang, id, link_gambar, set_gambar');
		$this->db->from('tbl_gambar_kartu');
		$this->db->where('id_barang', $id);
		$this->db->where('flag', 1);
		$this->db->order_by("set_gambar", "desc");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}else return ;
	}
	
	function add_to_counter_browser(){            
		$today = date('Y-m-d H:i:s');
		if($this->session->userdata('role_id') == null || ($this->session->userdata('role_id') != 0 && $this->session->userdata('role_id') != 1)){
			$data = array(
				'browser' => $_SERVER['HTTP_USER_AGENT'],
				'waktu_akses' => $today
			);		
			$this->db->insert('tbl_counter_browser',$data);            
		}		
	}
}
?>