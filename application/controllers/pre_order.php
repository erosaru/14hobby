<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pre_order extends CI_Controller {
	public function __construct(){
		parent::__construct();
        
	}
	
	public function index(){
        if($this->session->userdata('login') == false || !(in_array($this->session->userdata('role_id'), array(0,1))))
            redirect('login');
		$data['template'] = "pre_order_index";
        $page = empty($_GET['page']) ? 0 : $_GET['page'];
        $kata_kunci = $this->input->get('kata_kunci');
        if(!empty($kata_kunci))
            $this->db->like("tbl_barang.name_barang", $kata_kunci);    
        $this->db->join("tbl_barang", "tbl_barang.id = tbl_pre_order.id_barang");
        $this->db->join("tbl_pre_order_order", "tbl_pre_order_order.id_pre_order = tbl_pre_order.id", "left");
        $this->db->group_by("tbl_barang.name_barang, tbl_pre_order.slot, tbl_pre_order.tgl_tiba, tbl_pre_order.harga, tbl_pre_order.tgl_rilis");
		$pre_order = $this->db->get("tbl_pre_order");
		$pagingConfig   = $this->paginationlib->initPagination("/pre_order",$pre_order->num_rows, 10);
		$this->pagination->initialize($pagingConfig);
		$this->db->select("tbl_barang.name_barang, tbl_pre_order.slot, tbl_pre_order.id, tbl_pre_order.tgl_tiba, tbl_pre_order.harga, tbl_pre_order.tgl_rilis, COUNT(tbl_pre_order_order.`id`) AS counter_order");
		$this->db->join("tbl_barang", "tbl_barang.id = tbl_pre_order.id_barang");
        $this->db->join("tbl_pre_order_order", "tbl_pre_order_order.id_pre_order = tbl_pre_order.id", "left");
        if(!empty($kata_kunci))
            $this->db->like("tbl_barang.name_barang", $kata_kunci);    
        $this->db->group_by("tbl_barang.name_barang, tbl_pre_order.slot, tbl_pre_order.tgl_tiba, tbl_pre_order.harga, tbl_pre_order.tgl_rilis");
		$this->db->order_by("tbl_pre_order.id", "desc");
		$item = $this->db->get("tbl_pre_order", $pagingConfig["per_page"], $page);
		$data['dafkomen'] = $item->result();
		$data["links"] = $this->pagination->create_links();
        $this->load->view("client/template", $data);	
	}
    
    public function create(){
        if($this->session->userdata('login') == false || !(in_array($this->session->userdata('role_id'), array(0,1))))
            redirect('login');
		$data['template'] = "pre_order_form";
        $this->load->view("client/template", $data);	
	}
    
    public function save(){
        if($this->session->userdata('login') == false || !(in_array($this->session->userdata('role_id'), array(0,1))))
            redirect('login');
        $link_ensiklopedia = $this->session->userdata("link_ensiklopedia");
        $today = date('Y-m-d');
		$this->data = array(
			'tgl_rilis' => save_tanggal($this->input->post('tgl_rilis')),
			'tgl_tiba' => save_tanggal($this->input->post('tgl_tiba')),
            'tgl_deadline' => $this->input->post('tgl_deadline') ? save_tanggal($this->input->post('tgl_deadline')) : null,
			'catatan' => $this->input->post('catatan'),
			'harga' => $this->input->post('harga'),
			'created_date' => $today,
			'slot' => $this->input->post('slot'),
			'id_barang' => (count($link_ensiklopedia) > 0) ? $link_ensiklopedia[0]["id"] : null,
            'dp' => $this->input->post('dp'),
            'dp_tipe' => $this->input->post('dp_tipe')
        );
		
		$warning = "";
		if(empty($this->data['harga']))
		  $warning = "Mohon masukkan harga barang yang akan dibuka order nya";
		else if(empty($this->data['slot']))
		  $warning = "Mohon masukkan jumlah slot untuk barang yang akan dibuka order nya";	
        else if(empty($this->data['id_barang']))
		  $warning = "Mohon masukkan barang yang akan di PO";
        else if(empty($this->data['dp']))
		  $warning = "Mohon masukkan jumlah dp yang harus dibayar untuk order barang ini";		
		
        if(!empty($warning)){
		  $this->session->set_userdata("link_ensiklopedia", $link_ensiklopedia);
		  $this->session->set_flashdata('warning', $warning);
		  $this->session->set_flashdata("data",$this->data);
		  redirect("pre_order/create");
		}
        
        $this->db->insert('tbl_pre_order',$this->data);
        $this->session->set_flashdata('success', 'PO item baru sudah dibuat');
        $this->session->set_userdata('link_ensiklopedia', array());
        redirect("pre_order");
    }
    
    function ensiklopedia_terkait(){
            if($this->session->userdata('login') == false || !(in_array($this->session->userdata('role_id'), array(0,1))))
                redirect('login');
			$this->data['template'] = "pre_order_barang_terkait";
			$search = $this->input->get('search');
			if(!empty($search))
				$this->db->like('name_barang', $search);
			$this->db->where("(set_gambar = 1 or  set_gambar IS NULL)");
			$this->db->join("tbl_gambar_barang", "tbl_gambar_barang.id_barang = tbl_barang.id", "left");
			$this->db->join("tbl_merk", "tbl_merk.id = tbl_barang.id_merk");
			$item = $this->db->get("tbl_barang");
			$pagingConfig   = $this->paginationlib->initPagination("/pre_order/ensiklopedia_terkait",$item->num_rows(), 15);
			$this->pagination->initialize($pagingConfig);
			$page = empty($_GET['page']) ? 0 : $_GET['page'];
			if(!empty($search))
				$this->db->like('name_barang', $search);
			$this->db->select("tbl_barang.*, tbl_gambar_barang.link_gambar, tbl_merk.name_merk");
			$this->db->where("(set_gambar = 1 or  set_gambar IS NULL)");
			$this->db->join("tbl_gambar_barang", "tbl_gambar_barang.id_barang = tbl_barang.id", "left");
			$this->db->join("tbl_merk", "tbl_merk.id = tbl_barang.id_merk");			
			$item = $this->db->get("tbl_barang", $pagingConfig["per_page"], $page);
			$this->data['item'] = $item->result();
			$this->data["links"] = $this->pagination->create_links();
			$this->load->view("client/template", $this->data);
    }
    
    function add_link_ensiklopedia($id){
        if($this->session->userdata('login') == false || !(in_array($this->session->userdata('role_id'), array(0,1))))
            redirect('login');
		$this->db->select("tbl_barang.*, tbl_gambar_barang.link_gambar, tbl_merk.name_merk");
		$this->db->where("tbl_barang.id", $id);
		$this->db->where("(set_gambar = 1 or  set_gambar IS NULL)");
		$this->db->join("tbl_gambar_barang", "tbl_gambar_barang.id_barang = tbl_barang.id", "left");
		$this->db->join("tbl_merk", "tbl_merk.id = tbl_barang.id_merk");
		$item = $this->db->get("tbl_barang");
		$item = $item->result();
		$data = array(0 => array(
               "id" => $id, 
	           "link_gambar" => empty($item[0]->link_gambar) ? "asset/image/profile.png" : "uploads/".$item[0]->link_gambar, 
			   "name_barang" => $item[0]->name_barang,
			   "name_merk" => $item[0]->name_merk
            )
		);
        $this->session->set_userdata('link_ensiklopedia', $data);
		$id = $this->input->get("id");
		if(empty($id))
            redirect("pre_order/create");
        else
		    redirect("pre_order/edit/$id");
    }
    
    function delete_link_ensiklopedia(){
        if($this->session->userdata('login') == false || !(in_array($this->session->userdata('role_id'), array(0,1))))
            redirect('login');
		$id = $this->input->get("id");
		if(empty($id)){
            $this->session->set_userdata('link_ensiklopedia', array());
			redirect("pre_order/create");
        }else{
		    $data = array(0 => array(
                "id" => null, 
			     "link_gambar" => null, 
			     "name_barang" => null,
			     "name_merk" => null
                )
            );
            $this->session->set_userdata('link_ensiklopedia', $data);
		    redirect("pre_order/edit/$id");
		}
    }
    
    //for buyer
    function show_pre_order(){
        $data['template'] = "pre_order_show_list";
        $page = empty($_GET['page']) ? 0 : $_GET['page'];
        $kata_kunci = $this->input->get('kata_kunci');
        if(!empty($kata_kunci))
            $this->db->like("tbl_barang.name_barang", $kata_kunci);
        $this->db->join("tbl_barang", "tbl_barang.id = tbl_pre_order.id_barang");
        $this->db->join("tbl_pre_order_order", "tbl_pre_order_order.id_pre_order = tbl_pre_order.id", "left");
        $this->db->join("tbl_gambar_barang", "tbl_pre_order.id_barang = tbl_gambar_barang.id_barang", "left");
        $this->db->where("tbl_gambar_barang.set_gambar = 1");
		$this->db->where("(tbl_pre_order.tgl_deadline = null or tbl_pre_order.tgl_deadline >= now() )");
        $this->db->group_by("tbl_gambar_barang.link_gambar, tbl_barang.name_barang, tbl_pre_order.slot, tbl_pre_order.tgl_tiba, tbl_pre_order.harga, tbl_pre_order.tgl_rilis, tbl_pre_order.tgl_deadline, tbl_pre_order.catatan");
		$pre_order = $this->db->get("tbl_pre_order");
		$pagingConfig   = $this->paginationlib->initPagination("/pre_order",$pre_order->num_rows, 10);
		$this->pagination->initialize($pagingConfig);
		
        $this->db->select("tbl_pre_order.id, tbl_pre_order.catatan, tbl_gambar_barang.link_gambar, tbl_pre_order.dp, tbl_pre_order.dp_tipe, tbl_barang.name_barang, tbl_pre_order.slot, tbl_pre_order.id, tbl_pre_order.tgl_tiba, tbl_pre_order.tgl_deadline, tbl_pre_order.harga, tbl_pre_order.tgl_rilis, sum(tbl_pre_order_order.jumlah) AS counter_order");
		$this->db->join("tbl_barang", "tbl_barang.id = tbl_pre_order.id_barang");
        $this->db->join("tbl_pre_order_order", "tbl_pre_order_order.id_pre_order = tbl_pre_order.id", "left");
        $this->db->join("tbl_gambar_barang", "tbl_pre_order.id_barang = tbl_gambar_barang.id_barang", "left");
        $this->db->where("tbl_gambar_barang.set_gambar = 1");
		$this->db->where("(tbl_pre_order.tgl_deadline is null or tbl_pre_order.tgl_deadline >= now() )");
        if(!empty($kata_kunci))
            $this->db->like("tbl_barang.name_barang", $kata_kunci);    
        $this->db->group_by("tbl_pre_order.dp, tbl_pre_order.dp_tipe, tbl_barang.name_barang, tbl_pre_order.slot, tbl_pre_order.tgl_tiba, tbl_pre_order.harga, tbl_pre_order.tgl_rilis, tbl_pre_order.tgl_deadline,tbl_pre_order.catatan");
		$this->db->order_by("tbl_pre_order.id", "desc");
		$item = $this->db->get("tbl_pre_order", $pagingConfig["per_page"], $page);
		$data['dafkomen'] = $item->result();
		$data["links"] = $this->pagination->create_links();
        $this->load->view("client/template", $data);
    }
	
	function detail_pre_order($id){
        $data['template'] = "pre_order_show";
		$this->db->join("tbl_gambar_barang", "tbl_pre_order.id_barang = tbl_gambar_barang.id_barang", "left");
		$this->db->join("tbl_barang", "tbl_pre_order.id_barang = tbl_barang.id");
		$this->db->where("set_gambar = 1");
		$this->db->where("tbl_pre_order.id", $id);
        $item = $this->db->get("tbl_pre_order");
		$item = $item->result();
		$data['item'] = $item[0];
		$data['title'] = "PO ".$item[0]->name_barang;
		$data['seo'] = create_title($item[0]->seo_barang);
		$data['deskripsi'] = create_title($item[0]->deskripsi);
		$this->db->where("id_pre_order", $id);
		$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_pre_order_order.buyer_id");
		$data['customer_po'] = $this->db->get("tbl_pre_order_order");
		
        $this->load->view("client/template", $data);
    }
}