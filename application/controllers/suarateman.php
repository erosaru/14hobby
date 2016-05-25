<?php
	class Suarateman extends CI_Controller {
		public function __construct(){
			parent::__construct();
			$this->load->model('m_captcha');
			$this->load->model('m_home');
			$this->load->library('pagination');
			$this->load->library('session');
		}
		
		public function index($nilai=0){
			$data['template'] = "suarateman_index";
			$captcha = $this->m_captcha->GenerateCaptcha();
			$data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);
			
			$link = base_url()."suarateman/index";
			$data['jumlah'] = $this->db->count_all('tbl_suarateman');
			$batas = 10;
			$data['dafkomen'] = $this->m_home->ambil($batas, $nilai, 'tbl_suarateman');
			$data['page'] = $this->m_home->link_paging($batas, $nilai, $link, $data['jumlah']);
			$this->load->view("client/template", $data);
		}		
		
		/*proses ajax untuk save suara teman*/
		function create(){
			$today = date('Y-m-d');
			$data = array(
				'nama' => $this->input->post('nama'),
				'pesan' => $this->input->post('pesan'),
				'email' => $this->input->post('email'),
				'date_create' => $today
			);
			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
				$hasil =  $this->db->insert('tbl_suarateman',$data);
				if($hasil){
					$this->session->set_flashdata('success', 'Terima Kasih sudah percaya dengan 14hobby dan memberikan kami testimoni');
					redirect('suarateman');
				}else{
					echo "Data gagal disave";
				}
			}else{
				$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
				$this->session->set_flashdata("data",$data);
				redirect('suarateman');
			}
		}
	}
?>