<?php
	class Banner extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model('uploadfile');
			$this->load->model("m_captcha");
			if($this->router->fetch_method() != "index"){
				if(($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1))
					redirect('login');
			}			
		}
		
		/*admin index*/
		public function pagehome(){
			$data['template'] = "banner_pagehome";	
			$captcha = $this->m_captcha->GenerateCaptcha();
			$data['captcha'] = $captcha;	
			$this->session->set_userdata('captcha_session', $captcha['word']);			
			$this->db->where("tipe_banner",1);
			$query = $this->db->get('tbl_banner');
			$get_data[] =  array("" => "New Banner");
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$get_data[] = array($row->id => "Gambar ID".$row->id);
				}
			}			
			$data['picture'] = $query->result();
			$data['data_gambar'] = $get_data;		
			$this->load->view('client/template',$data);
		}	

		public function save_pagehome(){
			$data = array(
				'img_alt' => $this->input->post('img_alt'), 
				'id' => $this->input->post('id'),
				'deskripsi' => $this->input->post('deskripsi')				
			);
			
			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
				$data = array(
					'img_alt' => $this->input->post('img_alt'),
					'deskripsi' => $this->input->post('deskripsi'),
					'tipe_banner' => 1
				);
				$get_id = $this->input->post('id');
				if(empty($get_id)){
					$this->db->insert('tbl_banner',$data);
					$id = $this->db->insert_id();
					$name = $this->uploadfile->upload_banner($id, 1);
					$this->db->where('id',$id);
					$data = array(
						'link_picture' => $name
					);
					$this->db->update('tbl_banner',$data);
				}else{
					if(!empty($_FILES['picture']['name']))
						$this->uploadfile->upload_banner($get_id, 1);
					$this->db->where('id',$get_id);
					$hasil =  $this->db->update('tbl_banner',$data);
				}	
				$this->session->set_flashdata('success', 'Data Sudah Disave');
				redirect('banner/pagehome');
				
				
			}else{
				$this->session->set_flashdata('warning', 'Kode masih salah, mohon masukan kode dengan benar');
				$this->session->set_flashdata("data",$data);
				redirect('banner/pagehome');
			}
		}	
		
		public function delete_pagehome($id){
			$this->db->where('id', $id);
			$result= $this->db->get('tbl_banner');
			if($result->num_rows > 0){
				$result = $result->result_array();
				$file = "./asset/image/banner/".$result[0]['link_picture'];
				if (file_exists($file)){
					if(unlink($file)){
						$sql = "delete from tbl_banner where id = $id";
						$x = $this->db->query($sql);
						$this->session->set_flashdata('success', 'Delete banner berhasil');
						redirect('banner/pagehome');
					}					
				}
			}else{
				$this->session->set_flashdata('warning', 'Data banner yang anda akan hapus tidak ada pada sistem');
				redirect('banner/pagehome');
			}
		}

		public function sidebanner(){
			$data['template'] = "banner_sidebanner";	
			$captcha = $this->m_captcha->GenerateCaptcha();
			$data['captcha'] = $captcha;	
			$this->session->set_userdata('captcha_session', $captcha['word']);			
			$this->db->where("tipe_banner",2);
			$query = $this->db->get('tbl_banner');
			$get_data[] =  array("" => "New Banner");
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$get_data[] = array($row->id => "Gambar ID".$row->id);
				}
			}			
			$data['picture'] = $query->result();
			$data['data_gambar'] = $get_data;		
			$this->load->view('client/template',$data);
		}	

		public function save_sidebanner(){
			$data = array(
				'img_alt' => $this->input->post('img_alt'), 
				'id' => $this->input->post('id'),
				'deskripsi' => $this->input->post('deskripsi')				
			);
			
			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
				$data = array(
					'img_alt' => $this->input->post('img_alt'),
					'deskripsi' => $this->input->post('deskripsi'),
					'tipe_banner' => 2
				);
				$get_id = $this->input->post('id');
				if(empty($get_id)){
					$this->db->insert('tbl_banner',$data);
					$id = $this->db->insert_id();
					$name = $this->uploadfile->upload_banner($id, 2);
					$this->db->where('id',$id);
					$data = array(
						'link_picture' => $name
					);
					$this->db->update('tbl_banner',$data);
				}else{
					if(!empty($_FILES['picture']['name']))
						$this->uploadfile->upload_banner($get_id, 2);
					$this->db->where('id',$get_id);
					$hasil =  $this->db->update('tbl_banner',$data);
				}	
				$this->session->set_flashdata('success', 'Data Sudah Disave');
				redirect('banner/sidebanner');
				
				
			}else{
				$this->session->set_flashdata('warning', 'Kode masih salah, mohon masukan kode dengan benar');
				$this->session->set_flashdata("data",$data);
				redirect('banner/sidebanner');
			}
		}
	} 
?>