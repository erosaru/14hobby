<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_komunitas extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->uri->segment(2) != "save_from_daftar_komunitas"){
			if($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1)
				redirect('login');
			$this->load->model("m_captcha");
		}		
	}
	
	public function index(){
		$data['template'] = "list_komunitas_index";
		$result = $this->db->get("tbl_list_komunitas");
		$data['dafkomen'] = $result->result();
		$this->load->view("client/template", $data);
	}
	
	public function create(){
		$data['template'] = "list_komunitas_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);		
		$this->load->view('client/template',$data);
	}
	
	public function save(){
		$today = date('Y-m-d');
		$data = array(
				'nama_contact' => $this->input->post('nama_contact'),
				'nama_komunitas' => $this->input->post('nama_komunitas'),
				'telepon_komunitas' => $this->input->post('telepon_komunitas'),
				'website' => $this->input->post('website_komunitas') ? $this->input->post('website_komunitas') : null,
				'email' => $this->input->post('email_komunitas') ? $this->input->post('email_komunitas') : null,
				'facebook' => $this->input->post('facebook_komunitas') ? $this->input->post('facebook_komunitas') : null,
				'twitter' => $this->input->post('twitter_komunitas') ? $this->input->post('twitter_komunitas') : null,
				'line' => $this->input->post('line_komunitas') ? $this->input->post('line_komunitas') : null,
				'whatsapp' => $this->input->post('whatsapp_komunitas') ? $this->input->post('whatsapp_komunitas') : null,
				'kegiatan' => $this->input->post('kegiatan'),
				'cara_ikut_komunitas' => $this->input->post('cara_ikut_komunitas'),
				'kota' => $this->input->post('kota'),
				'create_date' => $today,
				'bbm' => $this->input->post('bbm')
			);
		$link = $this->input->post('link_to');		
		
		
		
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$hasil =  $this->db->insert('tbl_list_komunitas',$data);
			if($hasil){
				if(!empty($link))
					redirect('list_komunitas');
				else
					redirect('list-komunitas');
			}else{
				redirect('daftar-komunitas');
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			if(!empty($link))
					redirect('list_komunitas/create');
				else
					redirect('daftar-komunitas');
		}
	}
	
	public function save_from_daftar_komunitas(){
		$this->save();
	}
	
	public function edit($id){
		$data['template'] = "list_komunitas_form";		
		$this->db->where("id",$id);		
		$query = $this->db->get("tbl_list_komunitas");
		$data['dafkomen'] = $query->result();
		$this->load->view('client/template',$data);
	}
	
	public function update($id){
		$data = array(
				'nama_contact' => $this->input->post('nama_contact'),
				'nama_komunitas' => $this->input->post('nama_komunitas'),
				'telepon_komunitas' => $this->input->post('telepon_komunitas'),
				'website' => $this->input->post('website_komunitas') ? $this->input->post('website_komunitas') : null,
				'email' => $this->input->post('email_komunitas') ? $this->input->post('email_komunitas') : null,
				'facebook' => $this->input->post('facebook_komunitas') ? $this->input->post('facebook_komunitas') : null,
				'twitter' => $this->input->post('twitter_komunitas') ? $this->input->post('twitter_komunitas') : null,
				'line' => $this->input->post('line_komunitas') ? $this->input->post('line_komunitas') : null,
				'whatsapp' => $this->input->post('whatsapp_komunitas') ? $this->input->post('whatsapp_komunitas') : null,
				'kegiatan' => $this->input->post('kegiatan'),
				'cara_ikut_komunitas' => $this->input->post('cara_ikut_komunitas'),
				'kota' => $this->input->post('kota'),
				'bbm' => $this->input->post('bbm'),
				'aktif' => $this->input->post('aktif')
			);
		
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_list_komunitas',$data);
		if($hasil){
			redirect('list_komunitas');
		}else{
			redirect('list_komunitas/edit/'.$id);
		}
	}	
}

