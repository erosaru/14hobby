<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Market extends CI_Controller {
	protected $data = array();
	public function __construct(){
		parent::__construct();
		$this->load->model("m_captcha");		
		$this->load->model("m_proses");		
		$this->data['item_kategori'] = $this->item_kategori();
	}
	
	function item_kategori(){
		$this->db->order_by("name_kategori");
		$item_kategori = $this->db->get("tbl_market_kategori");
		if($item_kategori->num_rows()>0){
			$data = array();
			foreach($item_kategori->result() as $row){
				$kategori = explode(" - ", $row->name_kategori, 3);
				if(count($kategori) != 1)
					if(!isset($data[$kategori[0]]))
						$data[$kategori[0]] = array('kategori' => $kategori[0], 'sub_kategori' => array($row->id => array("id" => $row->id, "name" => $kategori[1])));
					else
						$data[$kategori[0]]['sub_kategori'][$row->id] = array("id" => $row->id, "name" => $kategori[1]);
				else
					if(!isset($data[$kategori[0]]))
						$data[$kategori[0]] = array('kategori' => $kategori[0]);
			}
			return $data;
		}else
			return null;
	}
	
	public function index(){
		$this->data['template'] = "market_template";
		$this->data['content'] = "market_home";
		//mengambil data barang terbaru yang dimasukan merchant
		$this->db->select("tbl_market_user.first_name, tbl_market_user.last_name, tbl_market_user.name_merchant, tbl_market_item.id, tbl_market_item.picture, tbl_market_item.name, tbl_market_item.stock, tbl_market_user.city, tbl_market_item.price");
		$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_item.merchant_id");
		$this->db->where("delete is null");
		$this->db->where("active = 1");
		$this->db->order_by("tbl_market_item.id", "desc");
		$item = $this->db->get("tbl_market_item", 30);
		
		if($item->num_rows()>0){
			$this->data['item'] = $item->result();
		}
		$this->load->view("client/template", $this->data);
	}

	public function help(){
		$this->data['template'] = "market_template";
		$this->data['content'] = "market_page_bantuan";
		$this->load->view("client/template", $this->data);
	}
	
	public function how_to_buy(){
		$this->data['template'] = "market_template";
		$this->data['content'] = "market_how_to_buy";
		$this->load->view("client/template", $this->data);
	}
	
	public function how_to_sell(){
		$this->data['template'] = "market_template";
		$this->data['content'] = "market_how_to_sell";
		$this->load->view("client/template", $this->data);
	}
	
	public function rule_for_buyer(){
		$this->data['template'] = "market_template";
		$this->data['content'] = "market_rule_for_buyer";
		$this->load->view("client/template", $this->data);
	}
	
	public function how_to_be_seller(){
		$this->data['template'] = "market_template";
		$this->data['content'] = "market_how_to_be_seller";
		$this->load->view("client/template", $this->data);
	}
	
	public function list_seller(){
		$this->data['title'] = "14hobby seller";
		$this->data['template'] = "market_template";
		$this->data['content'] = "market_list_seller";
		
		$this->db->where("role_id", 2);
		$this->db->where("approve", 1);
		$province = $this->input->get("search");
		if(!empty($province))
			$this->db->where("province", $province);
		$merchant = $this->db->get('tbl_market_user');
		$pagingConfig   = $this->paginationlib->initPagination("/list-seller",$merchant->num_rows, 6);
		$this->pagination->initialize($pagingConfig);
		$page = empty($_GET['page']) ? 0 : $_GET['page'];
		
		$this->db->where("role_id", 2);
		$this->db->where("approve", 1);
		$province = $this->input->get("search");
		if(!empty($province))
			$this->db->where("province", $province);
		$this->data['merchant'] = $this->db->get('tbl_market_user', $pagingConfig["per_page"], $page);
		$this->data["links"] = $this->pagination->create_links();
		
		$this->load->view("client/template", $this->data);
	}
	
	public function search(){
		$this->data['title'] = "home";
		$this->data['template'] = "market_template";
		$this->data['content'] = "market_search_item";
		
		$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_item.merchant_id");
		$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
		$this->db->where("delete is null");
		$this->db->where("active = 1");
		$search = $this->input->get("search");
		if(!empty($search))
			$this->db->like("tbl_market_item.name", $search);
		$kategori = $this->input->get("kategori");
		if(!empty($kategori))
			$this->db->where("tbl_market_kategori.name_kategori", $kategori);
		$item = $this->db->get("tbl_market_item");
		$pagingConfig   = $this->paginationlib->initPagination("/search",$item->num_rows, 6);
		$this->pagination->initialize($pagingConfig);
		$page = empty($_GET['page']) ? 0 : $_GET['page'];	
		
		$this->db->select("tbl_market_user.first_name, tbl_market_user.last_name, tbl_market_user.name_merchant, tbl_market_item.id, tbl_market_item.picture, tbl_market_item.name, tbl_market_item.stock, tbl_market_user.city, tbl_market_item.price");
		$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_item.merchant_id");
		$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
		$this->db->where("delete is null");
		$this->db->where("active = 1");
		if(!empty($search))
			$this->db->like("tbl_market_item.name", $search);		
		if(!empty($kategori))
			$this->db->where("tbl_market_kategori.name_kategori", $kategori);
		$this->db->order_by("tbl_market_item.id", "desc");
		$item = $this->db->get("tbl_market_item", $pagingConfig["per_page"], $page);
		$this->data["links"] = $this->pagination->create_links();
		if($item->num_rows()>0){
			$this->data['item'] = $item->result();
		}
		$this->load->view("client/template", $this->data);		
	}
}

