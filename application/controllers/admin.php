<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('login') == false)
			redirect('login');
		$this->load->model("m_captcha");
	}
	
	/*item kategori*/
	public function pemberitahuan($page=""){
		$data['template'] = "pemberitahuan_form";
		$this->db->where("id", 1);
		$result = $this->db->get("tbl_system");
		if($result->num_rows > 0){
			$result = $result->result();
			$data['pengumuman'] = $result[0]->pengumuman;
		}
		$this->load->view('client/template',$data);
	}
	
	public function save_pemberitahuan(){			
		$today = date('Y-m-d H:i:s');
		$data = array(
				'pengumuman' => $this->input->post('pengumuman') ? $this->input->post('pengumuman') : null,
				'change_date' => $today
				);
		$this->db->where("id", 1);
		$result = $this->db->get("tbl_system");
		if($result->num_rows > 0){
			$this->db->where("id", 1);
			$hasil = $this->db->update('tbl_system',$data);
		}else
			$hasil= $this->db->insert('tbl_system',$data);
		if($hasil)
			$this->session->set_flashdata('success', 'Data pemberitahuan berhasil diperbaharui');
		else
			$this->session->set_flashdata('warning', 'Data pemberitahuan gagal diperbaharui');
		
		redirect('admin/pemberitahuan');
	}
}