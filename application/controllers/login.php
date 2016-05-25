<?php
	class Login extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model("m_login");
		}
		function index(){
			if($this->session->userdata('login') == true)
				redirect('roomuser');
			else{
				$data['template'] = "vlogin";
				$this->load->view('client/template',$data);
			}			
		}
		function login_process(){
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$login = $this->m_login->validasi($username, $password);
			if ($login==1){
				redirect("dashboard");
			}else{
				if ($login==0)
					$this->session->set_flashdata('warning', "Maaf, username atau password anda ada yang salah");
				else if ($login==2)
					$this->session->set_flashdata('warning', "Maaf, username masih menunggu persetujuaan pembuatan keanggotaan anda oleh administrator");
				else if ($login==3)
					$this->session->set_flashdata('warning', "Maaf, pembuatan username anda ditolak oleh administrator");
				else if ($login==4)
					$this->session->set_flashdata('warning', "Maaf, username anda harus melakukan konfirmasi email anda terdulu dari email yang sudah kami kirim ke email anda");
				else if ($login==5)
					$this->session->set_flashdata('warning', "Maaf, username anda sedang diblockir oleh administrator untuk mengetahui sebab username anda diblockir mohon hubungan administrator");
				else
					$this->session->set_flashdata('warning', "your username cannot use please contact administrator");
				redirect("login");
			}
		}
		function logout_process(){
			$this->session->sess_destroy();
			redirect("login");
		}
	} 
?>		