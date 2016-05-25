<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pasarkartu extends CI_Controller {
	public function __construct(){
			parent::__construct();
			
			if($this->session->userdata('login') == false)
				redirect('login');
	}

	public function index(){
		$data['template'] = "tradecard_index";
		$this->load->view("client/template", $data);
	}	
}

