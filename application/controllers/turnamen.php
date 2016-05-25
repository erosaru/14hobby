<?php
	class Turnamen extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model("m_home");
			$this->load->model("m_captcha");
			$this->load->model("m_proses");		
			if($this->router->fetch_method() != "index" && $this->router->fetch_method() != "detail"){
				if(($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1))
					redirect('login');
			}			
		}
		
		/*admin index*/
		public function admin_index($nilai=0){
			$data['template'] = "turnamen_index";
			
			$link = base_url()."turnamen/admin_index";
			$data['jumlah'] = $this->db->count_all('tbl_turnamen');
			$batas = 20;
			$data['dafkomen'] = $this->m_home->ambil($batas, $nilai, 'tbl_turnamen');
			$data['page'] = $this->m_home->link_paging($batas, $nilai, $link, $data['jumlah']);
			$this->load->view('client/template',$data);
		}	

		public function admin_create(){
			$data['template'] = "turnamen_form";
			$captcha = $this->m_captcha->GenerateCaptcha();
			$data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);			
			
			$this->load->view('client/template',$data);
		}			
		
		public function admin_save(){			
			$today = date('Y-m-d');
			$data = array(
					'title' => $this->input->post('title'),
					'pesan' => $this->input->post('pesan'),
					'created_date' => $today,
					'end_date' => save_tanggal($this->input->post('end_date')), 
					'officer_turnamen' => $this->input->post('officer_turnamen'),
			);
			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){				
				$hasil =  $this->db->insert('tbl_turnamen',$data);
				if($hasil){
					redirect('turnamen/admin_index');
				}else{
					redirect('turnamen/admin_create');
				}
			}else{
				$this->session->set_flashdata('warning', 'Kode yang ada masukan tidak sesuai, mohon ulangi lagi');
				$this->session->set_flashdata("data",$data);
				redirect('turnamen/admin_create');
			}			
		}
		
		public function admin_edit($id){
			$data['template'] = "turnamen_form";
			$this->db->where("id",$id);		
			$this->db->from("tbl_turnamen");		
			$query = $this->db->get();
			$data['data'] = $query->result();		
		
			$this->load->view('client/template',$data);
		}
		
		public function admin_update($id){
			$data = array(
				'title' => $this->input->post('title'),
				'pesan' => $this->input->post('pesan'),
				'end_date' => save_tanggal($this->input->post('end_date')),
				'officer_turnamen' => $this->input->post('officer_turnamen')
			);
			$this->db->where('id', $id);
			$hasil =  $this->db->update('tbl_turnamen',$data);
			if($hasil){
				redirect('turnamen/admin_index');
			}else{
				redirect('turnamen/admin_edit/'.$id);
			}		
		}
		
		public function admin_delete($id){
			$this->db->where("id", $id);
			$this->db->delete('tbl_turnamen');
			redirect('turnamen/admin_index');			
		}
		
		
		/*client turnamen*/
		public function index(){
			$this->m_proses->add_to_counter();
			$data['template'] = "turnamen_show";
			$query = "SELECT *, DATEDIFF(NOW(),created_date) AS lama FROM tbl_turnamen WHERE end_date = '0000-00-00' order by id desc";
			$data['turneyrutin'] = $this->db->query($query);
			$data['turneyrutin'] = $data['turneyrutin']->result();
			
			$query = "SELECT *, DATEDIFF(NOW(),created_date) AS lama FROM tbl_turnamen WHERE date(now()) <= end_date AND end_date != '0000-00-00' order by end_date";
			$data['turneyspesial'] = $this->db->query($query);
			$data['turneyspesial'] = $data['turneyspesial']->result();
				
			$this->load->view('client/template',$data);
		}
		
		public function detail($id){
			$this->m_proses->add_to_counter();
			$data['template'] = "turnamen_show_detail";
			
			
			
			$this->db->where("id", $id);
			$result = $this->db->get("tbl_turnamen");
			$data['dafkomen'] = $result->result();
			
			$counter = $data['dafkomen'][0]->counter + 1; 
			$datax = array(
					'counter' => $counter
				);
			$this->db->where("id",$id);
			$hasil =  $this->db->update('tbl_turnamen',$datax);
			
			$data['title'] = $data['dafkomen'][0]->title;
			$this->load->view('client/template',$data);
		}
	} 
?>