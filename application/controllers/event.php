<?php
	class Event extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model("m_home");
			$this->load->model("m_captcha");
			$this->load->model("m_proses");		
			if($this->router->fetch_method() != "index" && $this->router->fetch_method() != "detail" && $this->router->fetch_method() != "daftar_event" && $this->router->fetch_method() != "save_daftar_event"){
				if(($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1))
					redirect('login');
			}
		}
		
		/*admin index*/
		public function admin_index($nilai=0){
			$data['template'] = "event_index";			
			$pagingConfig   = $this->paginationlib->initPagination("/event/admin_index",$this->db->count_all('tbl_event'), 10);
			$this->pagination->initialize($pagingConfig);
			$page = empty($_GET['page']) ? 0 : $_GET['page'];
			$event = $this->db->get("tbl_event", $pagingConfig["per_page"], $page);
			$data['dafkomen'] = $event->result();
			$data["links"] = $this->pagination->create_links();
			$this->load->view('client/template',$data);
		}	

		public function admin_create(){
			$data['template'] = "event_form";
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
					'end_date' => save_tanggal($this->input->post('end_date'))
			);
			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){				
				$hasil =  $this->db->insert('tbl_event',$data);
				if($hasil){
					redirect('event/admin_index');
				}else{
					redirect('event/admin_create');
				}
			}else{
				$this->session->set_flashdata('warning', 'Kode yang ada masukan tidak sesuai, mohon ulangi lagi');
				$this->session->set_flashdata("data",$data);
				redirect('event/admin_create');
			}			
		}
		
		public function admin_edit($id){
			$data['template'] = "event_form";
			$this->db->where("id",$id);		
			$this->db->from("tbl_event");		
			$query = $this->db->get();
			$data['data'] = $query->result();		
		
			$this->load->view('client/template',$data);
		}
		
		public function admin_update($id){
			$data = array(
				'title' => $this->input->post('title'),
				'pesan' => $this->input->post('pesan'),
				'end_date' => save_tanggal($this->input->post('end_date'))				
			);
			$this->db->where('id', $id);
			$hasil =  $this->db->update('tbl_event',$data);
			if($hasil){
				redirect('event/admin_index');
			}else{
				redirect('event/admin_edit/'.$id);
			}		
		}
		
		public function admin_delete($id){
			$this->db->where("id", $id);
			$this->db->delete('tbl_event');
			redirect('event/admin_index');			
		}
		
		
		/*client event*/
		public function index($page=null){
			$today = date('Y-m-d');
			$this->m_proses->add_to_counter();
			$data['template'] = "event_show";
			$query = "SELECT *, DATEDIFF(NOW(),created_date) AS lama FROM tbl_event WHERE end_date = '0000-00-00' order by id desc";
			$data['turneyrutin'] = $this->db->query($query);
			$data['turneyrutin'] = $data['turneyrutin']->result();
			
			//$query = "SELECT *, DATEDIFF(NOW(),created_date) AS lama FROM tbl_event WHERE '".$today."' <= end_date AND end_date != '0000-00-00' order by end_date";
			$this->db->where('validation', '1');
			$result = $this->db->get("tbl_event");			
			$pagingConfig   = $this->paginationlib->initPagination("/list-event",$result->num_rows(), 10);
			$this->pagination->initialize($pagingConfig);
			$page = empty($_GET['page']) ? 0 : $_GET['page'];			
			$this->db->select(array("*", "DATEDIFF(NOW(),created_date) AS lama"));
			$this->db->where('validation', '1');
			$event = $this->db->get("tbl_event", $pagingConfig["per_page"], $page);			
			$data['turneyspesial'] = $event->result();
			$data["links"] = $this->pagination->create_links();			
				
			$this->load->view('client/template',$data);
		}
		
		public function detail($id){
			$this->m_proses->add_to_counter();
			$data['template'] = "event_show_detail";
			
			$this->db->where("id", $id);
			$result = $this->db->get("tbl_event");
			$data['dafkomen'] = $result->result();
			
			$counter = $data['dafkomen'][0]->counter + 1; 
			$datax = array(
					'counter' => $counter
				);
			$this->db->where("id",$id);
			$hasil =  $this->db->update('tbl_event',$datax);
			
			$data['title'] = $data['dafkomen'][0]->title;
			$this->load->view('client/template',$data);
		}
		
		public function daftar_event(){
			$data['template'] = "event_form_user";
			$captcha = $this->m_captcha->GenerateCaptcha();
			$data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);	
			$this->load->view('client/template',$data);
		}
		
		public function save_daftar_event(){
			$this->load->helper('email');
			$today = date('Y-m-d');
			$data = array(
					'title' => $this->input->post('title'),
					'pesan' => $this->input->post('pesan'),
					'eo' => $this->input->post('eo'),
					'created_date' => $today,
					'end_date' => $this->input->post('end_date') ? save_tanggal($this->input->post('end_date')) : null,
					'start_date' => $this->input->post('start_date') ? save_tanggal($this->input->post('start_date')) : null,
					'email' => $this->input->post('email'),
					'kota' => $this->input->post('kota')
			);
			
			$warning = "";
			if(empty($data['email']))
				$warning = "Mohon masukkan email anda";
			elseif(!valid_email($data['email']))
				$warning = "Mohon masukkan email anda yang benar";
			else if(empty($data['title']))
				$warning = "Mohon masukkan nama acara anda";
			else if(empty($data['kota']))
				$warning = "Mohon masukkan kota dimana acara anda berlangsung";
			else if(empty($data['eo']))
				$warning = "Mohon masukkan nama penyelenggara / event organizer(EO) acara anda";
			else if(empty($data['start_date']))
				$warning = "Mohon masukkan tanggal dimulainya acara";				
			else if(!empty($data['end_date'])){
				if(strtotime($data['start_date']) >= strtotime($data['end_date'])){
					$warning = "Mohon masukkan tanggal berakhirnya acara melebihi tanggal acara dimulai, apabila acara hanya satu hari mohon kosongkan tanggal berakhirnya acara";
				}
			}
			if(empty($data['pesan']))
				$warning = "Mohon ceritakan acara yang akan anda adakan";
				
			if(!empty($warning)){
				$this->session->set_flashdata('warning', $warning);
				$this->session->set_flashdata("data",$data);
				redirect("daftar-event");
			}
			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){	
				$hasil =  $this->db->insert('tbl_event',$data);
				$this->session->set_flashdata('success', 'Acara anda sudah dikirim ke tim 14hobby.com, tim akan memeriksa dahulu isi acara anda dahulu sebelum ditampilkan ke website 14hobby.com');
				redirect('event');
			}else{
				$this->session->set_flashdata('warning', 'Kode yang ada masukan tidak sesuai, mohon ulangi lagi');
				$this->session->set_flashdata("data",$data);
				redirect('daftar-event');
			}
		}
	} 
?>