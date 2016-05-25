<?php
	class User extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model("m_home");
			$this->load->model("m_captcha");
			$this->load->model("m_proses");		
			if(($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1))
				redirect('login');
		}
		
		/*client event*/
		public function index(){
			$data['template'] = "user_index";
			$this->db->select("tbl_market_user.id, tbl_market_user.email, tbl_market_user.first_name, tbl_market_user.last_name, tbl_role.role_name, , tbl_market_user.confirmation_email");
			$this->db->order_by("id", "desc");
			$this->db->where("role_id > 1");
			$email = $this->input->get("search_email");
			if(!empty($email))
				$this->db->like("email", $email);
			$this->db->where("email is not null");
			$this->db->where("pass is not null");
			$this->db->join("tbl_role", "tbl_market_user.role_id = tbl_role.id");
			$user = $this->db->get("tbl_market_user");
			$data['dafkomen'] = $user->result();				
			$this->load->view('client/template',$data);
		}		
		
		public function reset_password($id){
			$datax = array(
					'pass' =>  do_hash("12345678", 'md5')
				);
			$this->db->where("id",$id);
			$hasil =  $this->db->update('tbl_admin',$datax);		
			redirect('user');
		}
		
		public function edit($id){
			$data['template'] = "user_edit";
			$this->db->where("id", $id);
			$user = $this->db->get("tbl_market_user");
			$data['user'] = $user->result();				
			$data['user'] = $data['user'][0];
			
			if($this->session->userdata('role_id') == 1)
				$this->db->where("id >= 2");
			else
				$this->db->where("id >= 1");
			$query = $this->db->get("tbl_role");
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$data['role'][] = array($row->id => $row->role_name);
				}
			}
			$this->load->view('client/template',$data);
		}
		
		public function update($id){
			$data = array(
				'role_id' => $this->input->post('role_id')
			);
			$this->db->where("id", $id);
			$this->db->update("tbl_market_user", $data);
			redirect("user");
		}
		
		public function block($id){
			$data = array(
				'confirmation_email' => 2
			);
			$this->db->where("id", $id);
			$this->db->update("tbl_market_user", $data);
			redirect("user");
		}
		
		public function unblock($id){
			$data = array(
				'confirmation_email' => 1
			);
			$this->db->where("id", $id);
			$this->db->update("tbl_market_user", $data);
			redirect("user");
		}
		
		function confirmation_reset_password($key_user){
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
		}
		
		//code for approve user
		public function needapprove(){
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "market_user_needapprove";
			$this->db->order_by("tbl_market_user.id", "desc");
			$this->db->where("approve is null");
			$this->db->where("confirmation_email = 1");
			$this->db->join("tbl_role", "tbl_role.id = tbl_market_user.role_id");
			$this->db->select("tbl_market_user.*, tbl_role.role_name");
			$user = $this->db->get("tbl_market_user");
			$this->data['dafkomen'] = $user->result();				
			$this->load->view('client/template',$this->data);
		}
		
		public function showapprove($id){
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "market_user_show_approve";			
			$this->db->order_by("id", "desc");
			$this->db->where("tbl_market_user.id", $id);
			$this->db->join("tbl_role", "tbl_role.id = tbl_market_user.role_id");
			$this->db->select("tbl_market_user.*, tbl_role.role_name");
			$user = $this->db->get("tbl_market_user");
			$this->data['dafkomen'] = $user->result();				
			$this->load->view('client/template',$this->data);
		}
		
		public function declined($id){
			$this->db->where("id", $id);
			$agent = $this->db->get("tbl_market_user");
			$agent = $agent->result();
			if($agent[0]->approve == 0){
				$today = date('Y-m-d');
				$this->data = array(
					'approve' => 2,
					//'approved_date' => $today
				);
				$this->db->where('id', $id);
				$hasil =  $this->db->update('tbl_market_user',$this->data);
				$this->load->model("m_email");
				$this->m_email->email_declined($agent , 1);
				redirect('user/needapprove');
			}else{
				if($agent[0]['approve'] == 1)
					$this->session->set_flashdata('warning', 'User ini sudah diterima sebelumnya');
				else if($agent[0]['approve'] == 2)
					$this->session->set_flashdata('warning', 'User ini sudah ditolak sebelumny');
				redirect('user/needapprove');
			}
		}
		
		public function approved($id){
			$menu = $this->input->get("menu");
			$this->db->where("id", $id);
			$agent = $this->db->get("tbl_market_user");
			$agent = $agent->result_array();
			if($agent[0]['approve'] == 0){				
				$this->db->where('id', $id);
				$today = date('Y-m-d');
				$password = generateRandomString();
				$this->data = array(
					'approve' => 1,
					'pass' => do_hash($password, 'md5'),
					'approve_date' => $today				);
				$this->db->where('id', $id);
				$hasil =  $this->db->update('tbl_market_user',$this->data);
				$this->resend_email_approved($id, $password, 1);
				if(empty($menu))
					redirect('user/needapprove');
				else
					redirect('user/rneedapprove');
			}else{
				if($agent[0]['approve'] == 1)
					$this->session->set_flashdata('warning', 'User ini sudah di approve sebelumnya');
				else if($agent[0]['approve'] == 2)
					$this->session->set_flashdata('warning', 'User ini sudah di tolak sebelumnya');
				if(empty($menu))
					redirect('user/needapprove');
				else
					redirect('user/rneedapprove');
			}	
		}
		
		public function resend_email_approved($id, $params = ""){
			$this->db->where('id', $id);
			$user = $this->db->get("tbl_market_user");
			$user = $user->result();
			$this->load->model("m_email");
			$this->m_email->email_approved($user, $params);
		}
	} 
?>