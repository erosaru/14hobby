<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('login') == false)
			redirect('login');
	}
	
	public function index(){
        $today = date('Y-m-d');
		$data['template'] = "roomuser_index";
		if($this->session->userdata('role_id') == 0){
			$data['content'] = "dashboard_super_admin";
			$query = "select controller_name, count(*) jumlah from tbl_counter group by controller_name order by count(*) desc";
			$query = $this->db->query($query);
			$data['counting_board'] = $query->result();
		
			$query = "select controller_name, count(*) jumlah from tbl_counter where created_date = '".$today."' group by controller_name order by count(*) desc";
			$query = $this->db->query($query);
			$data['counting_board_today'] = $query->result();		
			$query = "select controller_name, count(*) jumlah from tbl_counter where created_date = DATE(DATE_SUB('".$today."',INTERVAL 1 DAY)) group by controller_name order by count(*) desc";
			$query = $this->db->query($query);
			$data['counting_board_yesterday'] = $query->result();
			
			$query = "SELECT browser, COUNT(*) jumlah FROM tbl_counter_browser GROUP BY browser order by  count(*) desc LIMIT 10";
			$query = $this->db->query($query);
			$data['browser_log_count'] = $query->result();
            
            
            $this->db->limit(100);
            $counter_browser = $this->db->get('tbl_counter_browser');
            $pagingConfig   = $this->paginationlib->initPagination("/dashboard",$counter_browser->num_rows, 10);
            $this->pagination->initialize($pagingConfig);
            $page = empty($_GET['page']) ? 0 : $_GET['page'];
            $this->db->select('browser, DATE(waktu_akses) tanggal, TIME(waktu_akses) waktu');
            $this->db->order_by("waktu_akses desc");
            $data['browser_log'] = $this->db->get('tbl_counter_browser', $pagingConfig["per_page"], $page);
            $data["links"] = $this->pagination->create_links();
			
			//$query = "SELECT  FROM tbl_counter_browser ORDER BY  DESC LIMIT 10";
			//$query = $this->db->query($query);
			//$data['browser_log'] = $query->result();
		}elseif($this->session->userdata('role_id') == 1){
			$data['content'] = "dashboard_admin";
			$this->db->where("(role_id = 3 or role_id = 2)");
			$this->db->where("approve is null");
			$this->db->where("confirmation_email = 1");
			$query = $this->db->get("tbl_market_user");
			$data['count_need_approve'] = $query->num_rows();
		}elseif($this->session->userdata('role_id') == 2){
			$data['content'] = "dashboard_seller";
		}elseif($this->session->userdata('role_id') == 3){
			$data['content'] = "dashboard_buyer";
		}
		
		$this->load->view("client/template", $data);
	}
}

	