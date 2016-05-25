<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class History_comment extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->router->fetch_method() != "save_history_comment"){
			if(($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1))
				redirect('login');
		}
	}
	
	public function index(){
		$data['template'] = "history_comment_index";
		$this->db->select("id_comment_fb, link, date(created_date) tanggal, time(created_date) waktu, status");
		$this->db->order_by("created_date desc");
		$this->db->limit(50);
		$data["dafkomen"] = $this->db->get("tbl_history_comment");
		$this->load->view('client/template',$data);
	}	
	
	public function save_history_comment(){
		$today = date('Y-m-d H:i:s');
		$data = array(
			'id_comment_fb' => $this->input->post('id_comment_fb'),
			'link' => $this->input->post('link'),
			'created_date' => $today,
			'status' => $this->input->post('status')
		);
		$hasil =  $this->db->insert('tbl_history_comment',$data);
		echo $data['link'];
		
	}	
}

