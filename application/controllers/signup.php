<?php
	class Signup extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			$this->load->model("m_captcha");
			//if(($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1))
			//	redirect('login');
		}
		
		function index($warning = ""){
			$id = $this->input->get("lp");
			if(!empty($id)){
				$this->db->set('count_register', '`count_register`+ 1', FALSE);
				$this->db->where('id', $id);
				$this->db->update('tbl_landing_page');
			}
			if($this->session->userdata('login') == true)
				redirect('dashboard');
			$this->data['template'] = "signup_index";
			if(!empty($warning))
				$this->data["warning"] = $warning;
			$captcha = $this->m_captcha->GenerateCaptcha();
			$this->data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);	
			$this->load->view('client/template',$this->data);
		}
		
		function create(){
			$this->load->helper('email');
			$this->data = array(
				'email' => $this->input->post('email'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'province' => $this->input->post('province'),
				'phone' => $this->input->post('phone'),
				'role_id' => 3,
				'pin_password' => trim($this->input->post('pin_password'))
			);
			
			$warning = "";
			if(empty($this->data['email']))
				$warning = "Mohon isi email anda";
			elseif(!valid_email($this->data['email']))
				$warning = "Mohon isi alamat email anda yang benar";
			else if(empty($this->data['first_name']))
				$warning = "Mohon isi nama depan anda";			
			else if(empty($this->data['address']))
				$warning = "Mohon isi alamat anda";
			else if(empty($this->data['city']))
				$warning = "Mohon isi kota tempat tinggal anda";
			else if(empty($this->data['phone']))
				$warning = "Mohon masukan no contact yang bisa dihubungi";
			echo $warning; 
				
			if(!empty($warning)){
				$this->session->set_flashdata('warning', $warning);
				$this->session->set_flashdata("data",$this->data);
				redirect("signup");
			}			
			
			if($this->db->count_all('tbl_market_user') == 0){
				$this->data["role_id"] = 0;
				$this->data["pass"] = do_hash("climax1304", 'md5');
			}
				

			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
				$this->db->where("email",$this->data["email"]);
				$this->db->from("tbl_market_user");
				$query = $this->db->get();
				if($query->num_rows == 0){
					$hasil =  $this->db->insert('tbl_market_user',$this->data);
					$admin_id = $this->db->insert_id();
					$this->db->set("key_user", do_hash(date('Y-m-d')."-$admin_id", 'md5'));
					$this->db->where("id", $admin_id);
					$this->db->update("tbl_market_user");
					
					$this->db->where("id", $admin_id);
					$result = $this->db->get("tbl_market_user");
					$result = $result->result();
					$this->load->model("m_email");
					if($this->data["role_id"] != 0)
						$this->m_email->confimation_email($result[0]->email, $result[0]->key_user);
					if($hasil){						
						redirect('');
					}else{
						redirect('signup');
					}
				}else{
					$this->session->set_flashdata('warning', "Maaf email anda sudah digunakan, mohon gunakan email lainnya");
					$this->session->set_flashdata("data",$this->data);
					redirect("signup");
				}
			}else{
				$this->session->set_flashdata('warning', "Kode yang anda masukan tidak sama.");
				$this->session->set_flashdata("data",$this->data);
				redirect("signup");
			}
		}
		
		function confirmation_email($key_user){		
			$this->data = array(
					'confirmation_email' => 1
				);
			$this->db->where("key_user", $key_user);
			$this->db->update('tbl_market_user',$this->data);
			$this->session->set_flashdata('success', "Email anda sudah terkonfirmasi, mohon tunggu untuk proses pengesahan account anda oleh tim kami");
			redirect("login");
		}
		
		function forget_password(){		
			if($this->session->userdata('login') == true)
				redirect('dashboard');
			$this->data['template'] = "forget_password_form";
			if(!empty($warning))
				$this->data["warning"] = $warning;
			$captcha = $this->m_captcha->GenerateCaptcha();
			$this->data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);			
			$this->load->view('client/template',$this->data);
		}
		
		function process_reset_password(){
			if($this->session->userdata('login') == true)
				redirect('dashboard');

			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
				$this->db->where("email",$this->input->post('email'));
				$this->db->where("approve",1);
				$result = $this->db->get("tbl_market_user");
				if($result->num_rows > 0){
					$result = $result->result();
					$today = date('Y-m-d');
					$this->data = array(
						'confirmation_reset_password' => 1,
						'date_reset_password' => $today
					);
					$this->db->where("id",$result[0]->id);
					$this->db->update("tbl_market_user",$this->data);
					$this->load->model("m_email");
					$this->m_email->email_confirmation_reset_password($result);
					
					redirect("login");
				}else{
					$this->session->set_flashdata('warning', "Your email or PIN is wrong");
					redirect("forget-password");			
				}
			}else{
				$this->session->set_flashdata('warning', "Your code not same, please insert the code correctly");
				redirect("forget-password");			
			}			
		}
		
		function confirmation_reset_password($key_user){
			if(in_array($this->session->userdata('role_id'), array(0,1))){
				$password = generateRandomString();
				$this->data = array(
					'pass' =>  do_hash($password, 'md5')				
				);
				$this->db->where("key_user",$key_user);
				$result = $this->db->get("tbl_market_user");
				$result = $result->result();
				$this->db->where("key_user",$key_user);
				$hasil =  $this->db->update('tbl_market_user',$this->data);
				$this->load->model("m_email");
				$this->m_email->email_send_password_reset($result, $password);					
				redirect("user");
			}else{
				$this->db->select(array('*', 'DATEDIFF(NOW(),date_reset_password) as lama'));
				$this->db->where("key_user",$key_user);
				$this->db->where("confirmation_reset_password","1");
				$result = $this->db->get("tbl_market_user");
				if($result->num_rows > 0){
					$result = $result->result();
					if($result[0]->lama > 3){
						$this->session->set_flashdata('warning', 'Email konfirmasi untuk reset password anda sudah kadaluarsa. Mohon anda mengirim ulang permintaan reset password anda <a href="'.base_url().'forget-password">here</a>');
						redirect("login");
					}else{
						$password = generateRandomString();
						$this->data = array(
								'pass' =>  do_hash($password, 'md5'),
								'confirmation_reset_password' => 0,
								'date_reset_password' => null
							);
						$this->db->where("key_user",$key_user);
						$hasil =  $this->db->update('tbl_market_user',$this->data);
						$this->load->model("m_email");
						$this->m_email->email_send_password_reset($result, $password);		
						$this->session->set_flashdata('success', 'Kami sudah mereset password dan password baru anda sudah kami kirim lewat email anda, harap langsung merubah password yang mudah anda ingat');
						redirect("login");
					}
				}else
					redirect("login");
			}			
		}
		
		/*Signup seller*/
		function signup_seller($warning = ""){
			if($this->session->userdata('login') == true)
				redirect('dashboard');
			$this->data['template'] = "signup_seller";
			$captcha = $this->m_captcha->GenerateCaptcha();
			$this->data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);			
			$this->load->view('client/template',$this->data);
		}
		
		function create_seller(){
			$this->load->helper('email');
			$this->data = array(
				'email' => $this->input->post('email'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'province' => $this->input->post('province'),
				'phone' => $this->input->post('phone'),
				'name_merchant' => $this->input->post('name_merchant') ? $this->input->post('name_merchant') : null,
				'deskripsi' => $this->input->post('name_merchant') ? $this->input->post('deskripsi') : null,				
				'role_id' => 2,
				'pin_password' => trim($this->input->post('pin_password'))
			);
			
			$warning = "";
			if(empty($this->data['email']))
				$warning = "Mohon isi email anda";
			elseif(!valid_email($this->data['email']))
				$warning = "Mohon isi alamat email anda yang benar";
			else if(empty($this->data['first_name']))
				$warning = "Mohon isi nama depan anda";			
			else if(empty($this->data['address']))
				$warning = "Mohon isi alamat anda";
			else if(empty($this->data['city']))
				$warning = "Mohon isi kota tempat tinggal anda";
			else if(empty($this->data['phone']))
				$warning = "Mohon masukan no contact yang bisa dihubungi";
			else if(empty($this->data['deskripsi']))
				$warning = "Mohon isi dahulu penjelasan toko anda";
			echo $warning; 
				
			if(!empty($warning)){
				$this->session->set_flashdata('warning', $warning);
				$this->session->set_flashdata("data",$this->data);
				redirect("signup-seller");
			}		

			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
				$this->db->where("email",$this->data["email"]);
				$query = $this->db->get("tbl_market_user");
				if($query->num_rows == 0){
					$hasil =  $this->db->insert('tbl_market_user',$this->data);
					$admin_id = $this->db->insert_id();
					$this->db->set("key_user", do_hash(date('Y-m-d')."-$admin_id", 'md5'));
					$this->db->where("id", $admin_id);
					$this->db->update("tbl_market_user");
					
					$this->db->where("id", $admin_id);
					$result = $this->db->get("tbl_market_user");
					$result = $result->result();
					$this->load->model("m_email");
					$this->m_email->confimation_email_seller($result[0]->email, $result[0]->key_user);						
					if($hasil){						
						redirect('');
					}else{
						redirect('signup-seller');
					}
				}else{
					$this->session->set_flashdata('warning', "Maaf email anda sudah digunakan, mohon gunakan email lainnya");
					$this->session->set_flashdata("data",$this->data);
					redirect("signup-seller");
				}
			}else{
				$this->session->set_flashdata('warning', "Kode yang anda masukan tidak sama.");
				$this->session->set_flashdata("data",$this->data);
				redirect("signup-seller");
			}
		}
	} 
?>