<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detail_merchant extends CI_Controller {
	public function __construct(){
		parent::__construct();
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
	
	private function get_name_merchant($id){
		$this->db->where('id', $id);
		$user = $this->db->get('tbl_market_user');
		$user = $user->result();
		$x['header'] = !empty($user[0]->name_merchant) ? $user[0]->name_merchant : $user[0]->first_name.' '.$user[0]->last_name;
		$x['title'] = !empty($user[0]->name_merchant) ? create_title($user[0]->name_merchant) : create_title(trim($user[0]->first_name.' '.$user[0]->last_name));
		$x['img'] = $user[0]->foto;
		if($user[0]->approve != 1)
			redirect('');
		return $x;
	}

	public function index($id){
		$this->data['template'] = "market_template";
		$this->data['content'] = "detail_merchant_index";
		$this->data['content2'] = "detail_merchant_item";	
		$this->data['name_merchant'] = $this->get_name_merchant($id);	
		$kategori = $this->input->get("kategori");
		$name_barang = $this->input->get("search");
		if(!empty($kategori))
			$this->db->where("name_kategori", $kategori);
		if(!empty($name_barang))
			$this->db->like("name", $name_barang);
		$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
		$this->db->where("merchant_id", $id);
		$this->db->where("delete is null");
		$this->db->where("active", 1);
		$item = $this->db->get("tbl_market_item");		
		$pagingConfig   = $this->paginationlib->initPagination("/detail-merchant/".create_title($this->data['name_merchant']['title']),$item->num_rows, 6);
		$this->pagination->initialize($pagingConfig);
		$page = empty($_GET['page']) ? 0 : $_GET['page'];
		
		if(!empty($kategori))
			$this->db->where("name_kategori", $kategori);
		if(!empty($name_barang))
			$this->db->like("name", $name_barang);
		$this->db->select("tbl_market_item.*");	
		$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
		$this->db->where("merchant_id", $id);
		$this->db->where("delete is null");
		$this->db->where("active", 1);
		$this->db->order_by("tbl_market_item.id", 'desc');
		$item = $this->db->get("tbl_market_item", $pagingConfig["per_page"], $page);
		$this->data['item'] = $item->result();
		$this->data["links"] = $this->pagination->create_links();
		
		$this->db->select("distinct(name_kategori)");
		$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
		$this->db->where("merchant_id", $id);
		$this->db->where("delete", null);
		$kategori = $this->db->get("tbl_market_item");
		if($kategori->num_rows() > 0)
			$this->data['kategori'] = $kategori->result();
		$this->load->view("client/template", $this->data);
	}
	
	public function show($id){
		$this->db->select('tbl_market_item.*, tbl_market_user.name_merchant, tbl_market_user.city, tbl_market_user.province, tbl_market_kategori.name_kategori, tbl_market_user.first_name, tbl_market_user.last_name, tbl_market_user.city');
		$this->db->where('tbl_market_item.id', $id);
		$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_item.merchant_id");
		$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
		$result = $this->db->get("tbl_market_item");
		$result = $result->result();
		$this->data['title'] = $result[0]->name;
		$this->data['deskripsi'] = $result[0]->deskripsi;
		$this->data['seo'] = $result[0]->seo_barang;
		$this->data['dafkomen'] = $result;
		$this->data['name_merchant'] = $this->get_name_merchant($this->data['dafkomen'][0]->merchant_id);	
		$this->data['template'] = "market_template";
		$this->data['content'] = "detail_merchant_index";
		$this->data['content2'] = "market_item_show";	
		$this->load->view('client/template',$this->data);
	}
	
	public function profile($id){
		$this->data['template'] = "market_template";
		$this->data['content'] = "detail_merchant_index";
		$this->data['content2'] = "detail_merchant_profile";	
		$this->data['name_merchant'] = $this->get_name_merchant($id);	
		$this->db->where("id", $id);
		$user = $this->db->get("tbl_market_user");
		$this->data['data'] = $user->result();		
		
		$this->db->where("merchant_id", $id);
		$this->data['all_order'] = $this->db->count_all_results("tbl_market_order");
		$this->db->where("merchant_id", $id);
		$this->db->where("status", "SUCCESS");
		$this->data['success_order'] = $this->db->count_all_results("tbl_market_order");
		$this->db->where("user_id", $id);
		$this->db->join("tbl_bank", "tbl_bank.id = tbl_market_user_bank.bank_id");
		$bank = $this->db->get("tbl_market_user_bank");
		$this->data['payment_bank'] = $bank->result();
		$this->load->view("client/template", $this->data);
	}
	
	public function testimoni($id){
		$this->load->model('m_captcha');
		$this->data['template'] = "market_template";
		$this->data['content'] = "detail_merchant_index";
		$this->data['content2'] = "detail_merchant_testimoni";	
		$this->data['name_merchant'] = $this->get_name_merchant($id);
		
		$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_testimoni.buyer_id");
		$this->db->where("merchant_id", $id);
		$testimoni = $this->db->get("tbl_market_testimoni");
		$pagingConfig   = $this->paginationlib->initPagination("/detail-merchant/".create_title($this->data['name_merchant']['title'])."/testimoni",$testimoni->num_rows, 6);
		$this->pagination->initialize($pagingConfig);
		$page = empty($_GET['page']) ? 0 : $_GET['page'];
		
		$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_testimoni.buyer_id");
		$this->db->where("merchant_id", $id);
		$testimoni = $this->db->get("tbl_market_testimoni", $pagingConfig["per_page"], $page);
		if($testimoni->num_rows() > 0){
			$this->data['testimoni'] = $testimoni->result();
			$this->data["links"] = $this->pagination->create_links();
		}
		if($this->session->userdata("login") == true){
			$this->db->where("merchant_id", $id);
			$this->db->where("buyer_id", $this->session->userdata("id"));
			$check_testimoni = $this->db->get("tbl_market_testimoni");
			if($check_testimoni->num_rows() > 0)
				$this->data['have_input'] = true;
		}
		
		$this->data['merchant_id'] = $id;
		$captcha = $this->m_captcha->GenerateCaptcha();
		$this->data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);
		$this->load->view("client/template", $this->data);
	}
	
	public function save_testimoni(){
		$datetime = date('Y-m-d H:i');
		$this->data = array(
			"merchant_id" => $this->input->post("merchant_id"),
			"buyer_id" => $this->input->post("buyer_id"),
			"testimoni" => $this->input->post("testimoni"),
			"create_date" => $datetime
		);
		$merchant = $this->get_name_merchant($this->data["merchant_id"]);
		if(empty($this->data['testimoni']))
			$warning = "Mohon masukkan dahulu pesan testimoni anda untuk seller ini";
		if(!empty($warning)){
			$this->session->set_flashdata('warning', $warning);
			$this->session->set_flashdata("data",$this->data);
			redirect("detail-merchant/".$merchant['title']."/testimoni");
		}
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$this->db->insert("tbl_market_testimoni",$this->data);
			$this->session->set_flashdata('success', "Terima kasih sudah memberikan testimoni untuk seller ini");
			redirect("detail-merchant/".$merchant['title']."/testimoni");
		}else{
			$this->session->set_flashdata("data",$this->data);
			$this->session->set_flashdata('warning', "Kode yang anda masukkan tidak sama dengan gambar yang diberikan");
			redirect("detail-merchant/".$merchant['title']."/testimoni");
		}
	}
}
