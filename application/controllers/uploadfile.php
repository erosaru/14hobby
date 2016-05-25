<?php
class Uploadfile extends CI_Controller {
	function __construct(){
		parent::__construct();
		//$this->load->helper(array('form', 'url'));
	}
	
    function do_upload($id_barang){
		$this->load->model('m_file');
		$name = $this->m_file->get_nama_gambar_barang($id_barang);
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '10000000';
		$config['max_width']  = '5000';
		$config['max_height']  = '5000';
		$config['file_name']  = $name;
		
		
		$this->load->library('upload', $config);
		if ( !$this->upload->do_upload('xfile')){
			//$error = array('error' => $this->upload->display_errors());
			//$this->load->view('upload_form', $error);
			echo $this->upload->display_errors();
			//echo basename($_FILES['xfile']['name']);
		}
		else{
			//$data = array('upload_data' => $this->upload->data());
			//$this->load->view('upload_success', $data);
			$type_file = strrchr(basename($_FILES['xfile']['name']),'.');
			$data = array(
							"link_gambar" => $name.$type_file,
							"id_barang" => $id_barang,
							"set_gambar" =>0
						);
			
			$hasil = $this->m_file->insert_gambar_barang($data);
			
			echo "Success;$name$type_file";
		}
	}
	
	function do_upload_banner(){
		$config['upload_path'] = './uploads/banner/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '10000000';
		$config['max_width']  = '5000';
		$config['max_height']  = '5000';
		
		
		
		$this->load->library('upload', $config);
		if ( !$this->upload->do_upload('xfile')){
			echo $this->upload->display_errors();			
		}
		else{
			$type_file = strrchr(basename($_FILES['xfile']['name']),'.');
			echo "Success;".$_FILES['xfile']['name'];
		}
	}
	
	function upload_kategori_page($id){
		if(!empty($_FILES['xfile']['name'])){
			$name = strtolower($id);
			$type_file = strrchr(basename($_FILES['xfile']['name']),'.');
			
			$config['upload_path'] = './asset/image/kategori/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '
			';
			$config['max_width']  = '200';
			$config['max_height']  = '100';
			$config['file_name']  = $name;
			$config['overwrite']  = true;
			
			
			$this->load->library('upload', $config);
			if ( !$this->upload->do_upload('xfile')){
				return $this->upload->display_errors();
			}else{						
				$data = array(
					'link_gambar' => $name.$type_file
				);
				$this->db->where('id', $id);
				$hasil =  $this->db->update('tbl_kategori',$data);
				$data = $this->upload->data();
				echo "Success;".base_url()."asset/image/kategori/".$name.$type_file;
			}
		}else{
			return null;
		}
		
	}
	
	function upload_for_bank($id){
		if(!empty($_FILES['xfile']['name'])){
			$this->db->where("id", $id);
			$bank = $this->db->get("tbl_bank");
			$bank = $bank->result();
			$name = $bank[0]->bank_name;
			$type_file = strrchr(basename($_FILES['xfile']['name']),'.');
			
			$config['upload_path'] = './uploads/bank/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '100';
			$config['max_width']  = '200';
			$config['max_height']  = '100';
			$config['file_name']  = $name;
			$config['overwrite']  = true;
			
			
			$this->load->library('upload', $config);
			if ( !$this->upload->do_upload('xfile')){
				return $this->upload->display_errors();
			}else{						
				$data = array(
					'picture' => $name.$type_file
				);
				$this->db->where('id', $id);
				$hasil =  $this->db->update('tbl_bank',$data);
				$data = $this->upload->data();
				echo "Success;".base_url()."uploads/bank/".$name.$type_file;
			}
		}else{
			return null;
		}
		
	}
	
	function do_upload_logo_komunitas($id){
		$type_file = strrchr(basename($_FILES['xfile']['name']),'.');
		$name = "logo_$id$type_file";
		$config['upload_path'] = './uploads/logo_komunitas/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '10000000';
		$config['overwrite']  = true;
		$config['file_name']  = $name;
		
		$this->load->library('upload', $config);
		if ( !$this->upload->do_upload('xfile')){
			echo $this->upload->display_errors();			
		}
		else{			
			$data= array(
				"logo_komunitas" => $name
			);
			$this->db->where("id", $id);
			$this->db->update("tbl_list_komunitas", $data);
			echo "Success;".$_FILES['xfile']['name'];
		}
	}
	
	function do_upload_gambar_kartu($id){
		$type_file = strrchr(basename($_FILES['xfile']['name']),'.');
		$name = "kartu_$id$type_file";
		$config['upload_path'] = './uploads/trading_card/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '10000000';
		$config['overwrite']  = true;
		$config['file_name']  = $name;
		
		$this->load->library('upload', $config);
		if ( !$this->upload->do_upload('xfile')){
			echo $this->upload->display_errors();			
		}
		else{			
			$data= array(
				"gambar" => $name
			);
			$this->db->where("id", $id);
			$this->db->update("tbl_kartu", $data);
			echo "Success;".$_FILES['xfile']['name'];
		}
	}
	
	function do_upload_gambar_merk_kartu($id){
		$type_file = strrchr(basename($_FILES['xfile']['name']),'.');
		$name = "merk_kartu_$id$type_file";
		$config['upload_path'] = './uploads/trading_card/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '10000000';
		$config['overwrite']  = true;
		$config['file_name']  = $name;
		
		$this->load->library('upload', $config);
		if ( !$this->upload->do_upload('xfile')){
			echo $this->upload->display_errors();			
		}
		else{			
			$data= array(
				"gambar_merk" => $name
			);
			$this->db->where("id", $id);
			$this->db->update("tbl_merk_kartu", $data);
			echo "Success;".$_FILES['xfile']['name'];
		}
	}
}
?>