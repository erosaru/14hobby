<?php
	class Dbkartu extends CI_Controller {
		public function __construct(){
			parent::__construct();
			if($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1)
				redirect('page');
			$this->load->model('uploadfile');
			$this->load->model('m_captcha');
			$this->load->model('m_home');
			$this->load->model('m_kartu');
			
			$this->load->library('pagination');
			$this->load->library('session');
			$this->load->helper('file');
		}
		
		public function index($nilai=0){
			$data['template'] = "dbkartu_index";
			$link = base_url()."dbkartu/index";
		
			$data['jumlah'] = $this->db->count_all('tbl_kartu');
			$batas = 20;
			$data['dafkomen'] = $this->m_kartu->get_kartu($batas, $nilai);
			$data['page'] = $this->m_home->link_paging($batas, $nilai, $link, $data['jumlah']);
			$this->load->view("client/template", $data);
		}
		
		public function create(){
			$data['template'] = "dbkartu_form";
			$data['card_game_name'] = $this->m_home->get_list_sub_kategori_by_kategori("trading card game");
			$captcha = $this->m_captcha->GenerateCaptcha();
			$data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);		
			$this->load->view("client/template", $data);
		}

		function get_name_card($card_game_name, $split = ""){
			echo $this->m_kartu->get_name_card($card_game_name, $split);
		}
		
		function get_booster_set($card_game_name, $split = ""){
			echo $this->m_kartu->get_booster_set($card_game_name, $split);
		}
		
		public function save(){
			$name = $this->uploadfile->do_upload_card();
			if(!empty($name))
				$name = 'asset/image/dbcard_image/'.$name;
			$data = array(
				'name_card' => $this->input->post('name_card'),
				'booster_set' => $this->input->post('boosterset'),
				'id_sub_kategori' => $this->input->post('id_sub_kategori'),
				'picture' => $name
			);
			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
				$hasil =  $this->db->insert('tbl_kartu',$data);
				if($hasil){
					redirect('dbkartu');
				}else{
					redirect('dbkartu/create');
				}
			}else{
				$this->session->set_flashdata('warning', 'Kode masih salah, mohon masukan kode dengan benar');
				$this->session->set_flashdata("data",$data);
				redirect('dbkartu/create');
			}
		}
		
		public function show($id){
			$data['template'] = "dbkartu_show";
			$this->db->select("tbl_kartu.id, tbl_kartu.name_card, tbl_sub_kategori.name_sub_kategori, tbl_kartu.booster_set, tbl_kartu.picture");		
			$this->db->join("tbl_sub_kategori","tbl_kartu.id_sub_kategori = tbl_sub_kategori.id");		
			$this->db->where("tbl_kartu.id",$id);		
			$this->db->from("tbl_kartu");		
			$query = $this->db->get();
			$data['data'] = $query->result();		
			
			$this->load->view('client/template',$data);
		}
		
		public function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('tbl_kartu'); 			
			redirect("dbkartu");
		}
	}
?>