<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_toko extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->uri->segment(2) != "save_from_daftar_toko"){
			if($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1)
				redirect('login');
			$this->load->model("m_captcha");
		}		
	}
	
	public function index(){
		$data['template'] = "list_toko_index";
		$result = $this->db->get("tbl_list_toko");
		$data['dafkomen'] = $result->result();
		$this->load->view("client/template", $data);
	}
	
	public function create(){
		$data['template'] = "list_toko_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);		
		$this->load->view('client/template',$data);
	}
	
	public function save(){
		$today = date('Y-m-d');
		$data = array(
				'nama_pemilik' => $this->input->post('nama_lengkap'),
				'nama_toko' => $this->input->post('nama_toko'),
				'alamat_toko' => $this->input->post('alamat_toko'),
				'tipe_toko' => $this->input->post('type_toko'),
				'telepon_toko' => $this->input->post('telepon_toko'),
				'website' => $this->input->post('website_toko'),
				'email' => $this->input->post('email_toko'),
				'facebook' => $this->input->post('facebook_toko'),
				'twitter' => $this->input->post('twitter_toko'),
				'line' => $this->input->post('line_toko'),
				'whatsapp' => $this->input->post('whatsapp_toko'),
				'deskripsi' => $this->input->post('deskripsi'),
				'kota' => $this->input->post('kota'),
				'create_date' => $today,
				'start_date' => $today,
				'end_date' => date('Y-m-d', strtotime($today. ' + 380 days')),
				'bbm' => $this->input->post('bbm')
			);
		$link = $this->input->post('link_to');
		
		if($data['tipe_toko'] == "Toko offline"){		
			$data['website'] = null;
			$data['facebook'] = null;
			$data['twitter'] = null;
		}else if($data['tipe_toko'] == "Toko online"){
			$data['alamat_toko'] = null;
		}
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$hasil =  $this->db->insert('tbl_list_toko',$data);
			if($hasil){
				if(!empty($link))
					redirect('list_toko');
				else
					redirect('list-toko');
			}else{
				redirect('page/daftar_toko');
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			if(!empty($link))
					redirect('list_toko/create');
				else
					redirect('daftar-toko');
		}
	}
	
	public function save_from_daftar_toko(){
		$this->save();
	}
	
	public function edit($id){
		$data['template'] = "list_toko_form";		
		$this->db->where("id",$id);		
		$query = $this->db->get("tbl_list_toko");
		$data['dafkomen'] = $query->result();
		$this->load->view('client/template',$data);
	}
	
	public function update($id){
		$data = array(
				'nama_pemilik' => $this->input->post('nama_lengkap'),
				'nama_toko' => $this->input->post('nama_toko'),
				'alamat_toko' => $this->input->post('alamat_toko'),
				'tipe_toko' => $this->input->post('type_toko'),
				'telepon_toko' => $this->input->post('telepon_toko'),
				'website' => $this->input->post('website_toko'),
				'email' => $this->input->post('email_toko'),
				'facebook' => $this->input->post('facebook_toko'),
				'twitter' => $this->input->post('twitter_toko'),
				'line' => $this->input->post('line_toko'),
				'whatsapp' => $this->input->post('whatsapp_toko'),
				'deskripsi' => $this->input->post('deskripsi'),
				'kota' => $this->input->post('kota'),
				'bbm' => $this->input->post('bbm'),
				'aktif' => $this->input->post('aktif')
			);
		
		if($data['tipe_toko'] == "Toko offline"){		
			$data['website'] = "";
			$data['facebook'] = "";
			$data['twitter'] = "";
		}else if($data['tipe_toko'] == "Toko online"){
			$data['alamat_toko'] = "";
		}
		
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_list_toko',$data);
		if($hasil){
			redirect('list_toko');
		}else{
			redirect('list_toko/edit/'.$id);
		}
	}

	function renew_date($id){
		$today = date('Y-m-d');
		$this->db->where("id", $id);
		$result = $this->db->get("tbl_list_toko");
		$result = $result->result();
		$this->db->set("start_date", $today);
		$this->db->set("end_date", date('Y-m-d', strtotime($today. ' + 380 days')));
		$this->db->where("id", $id);
		$this->db->update("tbl_list_toko");
		$this->session->set_flashdata('success', 'Tanggal pengiklanan untuk toko'.$result[0]->name_toko." dirubah menjadi tanggal: ".show_tanggal(date('Y-m-d', strtotime($today. ' + 380 days'))));
		redirect("list_toko");
	}
}

