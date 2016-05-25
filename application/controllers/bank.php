<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1)
			redirect('login');
		$this->load->model("m_home");
		$this->load->model("m_kategori");
		$this->load->model("m_captcha");
		$this->load->model("m_proses");
	}	
	/*item kategori*/
	public function index($nilai=0){
		$data['template'] = "bank_index";
		$link = base_url()."bank";
		$data['jumlah'] = $this->db->count_all('tbl_bank');
		$batas = 20;
		$this->db->limit($batas, $nilai);		
		$result = $this->db->get('tbl_bank');
		$data['dafkomen'] = $result->result();
		$data['page'] = $this->m_home->link_paging($batas, $nilai, $link, $data['jumlah']);
		$this->load->view('client/template',$data);
	}
	
	public function create(){
		$data['template'] = "bank_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);			
		$this->load->view('client/template',$data);
	}
	
	public function save(){
		$data = array(
				'bank_name' => $this->input->post('bank_name'),
		);
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){			
			$hasil =  $this->db->insert('tbl_bank',$data);
			if($hasil){
				redirect('bank');
			}else{
				redirect('bank/create');
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			redirect('bank/create');
		}			
	}
	
	public function edit($id){
		$data['template'] = "bank_form";
		$this->db->where("id",$id);		
		$this->db->from("tbl_bank");		
		$query = $this->db->get();
		$data['data'] = $query->result();
		$this->load->view('client/template',$data);
	}
	
	public function update($id){
		$data = array(
			'bank_name' => $this->input->post('bank_name'),
			
		);
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_bank',$data);
		if($hasil){
			redirect('bank');
		}else{
			redirect('bank/edit/'.$id);
		}
	}	
}