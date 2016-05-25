<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ensiklopedia extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("m_proses");
		$this->load->model("m_home");
		$this->load->model("m_item");		
		$this->m_proses->add_to_counter_browser();
	}
	
	public function index($divisi_id){
		$this->m_proses->add_to_counter();		
		$data['template'] = "ensiklopedia_index";
		$this->db->where("id", $divisi_id);
		$result = $this->db->get("tbl_divisi");
		$result = $result->result();
		$data['title'] = ucwords($result[0]->name_divisi)." Pedia";
		$data['divisi_id'] = $result[0]->id;
		$this->db->where("divisi_id", $divisi_id);
		$this->db->where("ensiklopedia", 1);
		$result = $this->db->get("tbl_kategori");
		$data['link'] = $result->result();
		$data['tipe'] = $this->m_home->get_kategori($divisi_id, 1);
		array_unshift($data['tipe'], array("" => "All"));
		$data['merk'] = $this->m_home->get_merk($divisi_id, 1);
		array_unshift($data['merk'], array("" => "All"));
		
		$this->db->where("divisi_id", $divisi_id);
		$this->db->where("ensiklopedia", 1);
		$this->db->order_by("id", "desc");
		$result = $this->db->get("tbl_barang", 10);
		$data['new_item'] = $result->result();
		$this->load->view('client/template',$data);
	}

	
	public function detail_ensiklopedia($id){
		$this->m_proses->add_to_counter();		
		$this->db->where("id", $id);
		$kategori = $this->db->get("tbl_kategori");
		$kategori = $kategori->result();
		$divisi_id = $kategori[0]->divisi_id;
		
		$data['template'] = "ensiklopedia_detail";		
		//untuk mendapatkan kategori lain
		$this->db->where_not_in("id", $id);
		$this->db->where("ensiklopedia", 1);
		$this->db->where("divisi_id", $divisi_id);
		
		$kategori_lainnya = $this->db->get("tbl_kategori");
		$data['kategori_lainnya'] = $kategori_lainnya->result();
		
		//mendapatkan kategori yang dipilih
		$this->db->where("tbl_kategori.id", $id);
		$this->db->where("ensiklopedia", 1);
		$this->db->join("tbl_divisi", "tbl_divisi.id = tbl_kategori.divisi_id");
		$result = $this->db->get("tbl_kategori");
		$result = $result->result();
		//$data['title'] = ucwords($result[0]->name_divisi)." Pedia - ".$result[0]->name_kategori;
		$data['link_back'] = create_title($result[0]->name_divisi)."-pedia";
		$kategori = $result[0]->name_kategori;
		$data['item'][$kategori] = array("name_kategori" => $kategori, "data" => array());
		
		$this->db->where("tbl_kategori.id", $id);
		$this->db->join("tbl_kategori", "tbl_kategori.id = tbl_barang.id_kategori");
		$this->db->join("tbl_merk", "tbl_barang.id_merk = tbl_merk.id");
		$result = $this->db->get("tbl_barang");
		$segment = 2;
		$pagingConfig   = $this->paginationlib->initPagination('/'.$this->uri->segment(1),$result->num_rows, 10, $segment);
		$page = empty($_GET['page']) ? 0 : $_GET['page'];
		$this->pagination->initialize($pagingConfig);
		$this->db->select("tbl_barang.name_barang, tbl_barang.type_produk, tbl_barang.id, tbl_merk.name_merk");
		$this->db->where("tbl_kategori.id", $id);
		$this->db->join("tbl_kategori", "tbl_kategori.id = tbl_barang.id_kategori");
		$this->db->join("tbl_merk", "tbl_barang.id_merk = tbl_merk.id");
		$this->db->order_by("tbl_barang.id_kategori, tbl_barang.name_barang");
		$result = $this->db->get("tbl_barang", $pagingConfig["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
		if($result->num_rows()>0)
			foreach($result->result() as $barang)
				$data["item"][$kategori]["data"][] = array("tipe_produk" => $barang->type_produk, "manufacture" => $barang->name_merk, "nama_barang" => $barang->name_barang, "id" => $barang->id);
		else
			$data["item"] = array();
			
		
		$this->load->view("client/template", $data);
	}
	
	public function ensiklopedia_search($divisi_id){
		$this->m_proses->add_to_counter();
		$data["link_back"] = $this->input->get("back_link");
		$data['template'] = "ensiklopedia_detail";
		$data['title'] = "hasil pencarian";
		
		$merk = $this->input->get("id_merk");
		if(!empty($merk))
			$this->db->where("tbl_barang.id_merk", $merk);
		$id_kategori = $this->input->get("id_kategori");
		if(!empty($id_kategori))
			$this->db->where("id_kategori", $id_kategori);
		$name_barang = $this->input->get("kata_kunci");
		if(!empty($name_barang)){
			//$this->db->where("(tbl_barang.name_barang like '%$name_barang%' or tbl_barang.type_produk like '%$name_barang%' or tbl_barang.seo_barang like '%$name_barang%')");
			$array = array('tbl_barang.name_barang' => $name_barang, 'tbl_barang.type_produk' => $name_barang, 'tbl_barang.seo_barang' => $name_barang);
			$this->db->or_like($array); 
		}
		$this->db->where("tbl_barang.divisi_id", $divisi_id);
		$this->db->where("tbl_barang.ensiklopedia", 1);
		$this->db->where("tbl_kategori.ensiklopedia", 1);
		$this->db->where("tbl_merk.ensiklopedia", 1);
		$this->db->join("tbl_kategori", "tbl_kategori.id = tbl_barang.id_kategori");
		$this->db->join("tbl_merk", "tbl_barang.id_merk = tbl_merk.id");
		$result = $this->db->get("tbl_barang");		
		$segment = 2;
		$pagingConfig   = $this->paginationlib->initPagination('/'.$this->uri->segment(1),$result->num_rows, 10);
		$page = empty($_GET['page']) ? 0 : $_GET['page'];
		$this->pagination->initialize($pagingConfig);		
		if(!empty($merk))
			$this->db->where("tbl_barang.id_merk", $merk);
		if(!empty($id_kategori))
			$this->db->where("id_kategori", $id_kategori);
		if(!empty($name_barang)){
			//$this->db->where("(tbl_barang.name_barang like '%$name_barang%' or tbl_barang.type_produk like '%$name_barang%' or tbl_barang.seo_barang like '%$name_barang%')");
			$array = array('tbl_barang.name_barang' => $name_barang, 'tbl_barang.type_produk' => $name_barang, 'tbl_barang.seo_barang' => $name_barang);
			$this->db->or_like($array); 
		}
		$this->db->where("tbl_barang.divisi_id", $divisi_id);
		$this->db->where("tbl_barang.ensiklopedia", 1);
		$this->db->where("tbl_kategori.ensiklopedia", 1);
		$this->db->where("tbl_merk.ensiklopedia", 1);
		$this->db->join("tbl_kategori", "tbl_kategori.id = tbl_barang.id_kategori");
		$this->db->join("tbl_merk", "tbl_barang.id_merk = tbl_merk.id");
		$this->db->join("tbl_divisi", "tbl_barang.divisi_id = tbl_divisi.id");
		$this->db->order_by("tbl_barang.id_kategori, tbl_barang.name_barang");
		$result = $this->db->get("tbl_barang", $pagingConfig["per_page"], $page);
		$result = $result->result();
		$data["links"] = $this->pagination->create_links();
		$data['item'] = array();
		if(count($result) > 0){
			foreach($result as $barang){
				if(empty($data['item'][$barang->name_kategori]))
					$data['item'][$barang->name_kategori] = array("name_kategori" => $barang->name_kategori, "data" => array());
				
				$data['item'][$barang->name_kategori]["data"][] = array("tipe_produk" => $barang->type_produk, "manufacture" => $barang->name_merk, "nama_barang" => $barang->name_barang, "id" => $barang->id);
			}
		}
		$this->db->where("ensiklopedia", 1);
		$kategori_lainnya = $this->db->get("tbl_kategori");
		$data['kategori_lainnya'] = $kategori_lainnya->result();
		/*		
		$this->db->where("ensiklopedia", 1);
		$kategori = $this->input->get("id_kategori");
		if(!empty($kategori)){
			$this->db->where("id", $kategori);
		}
		$query_kategori = $this->db->get("tbl_kategori");
		$query_kategori = $query_kategori->result();
		
		foreach($query_kategori as $kategori){
			$this->db->where("id_kategori", $kategori->id);
			$this->db->where("c.ensiklopedia", 1);
			$merk = $this->input->get("id_merk");
			if(!empty($merk)){
				$this->db->where("id_merk", $merk);
			}		
			
			$name_barang = $this->input->get("kata_kunci");
			if(!empty($name_barang)){
				$this->db->or_like('a.name_barang', $name_barang);
				$this->db->or_like('a.type_produk', $name_barang);
			}
			
			$this->db->join("tbl_merk c", "a.id_merk = c.id");
			$this->db->where("a.ensiklopedia", 1);
			$this->db->select("a.name_barang, a.type_produk, a.id, c.name_merk");		
			$query_barang = $this->db->get("tbl_barang a");
			if($query_barang->num_rows > 0){
				
				if(empty($item[$kategori->name_kategori]))
					$item[$kategori->name_kategori] = array("name_kategori" => $kategori->name_kategori, "data" => "");
				foreach($query_barang->result() as $barang){
					$item[$kategori->name_kategori]["data"][] = array("tipe_produk" => $barang->type_produk, "manufacture" => $barang->name_merk, "nama_barang" => $barang->name_barang, "id" => $barang->id);
				}					
			}
		}
		
		$data["item"]= !empty($item) ? $item : "";
		*/
		$this->load->view("client/template", $data);
	}
	
	public function show($id){
			$today = date('Y-m-d');
			$this->m_proses->add_to_counter();
			$data['template'] = "item_show";
			$data['gambar']= $this->m_proses->get_gambar($id);
			$this->db->select("tbl_barang.*, tbl_merk.`name_merk`, tbl_kategori.name_kategori");
			$this->db->join('tbl_merk', 'tbl_barang.id_merk = tbl_merk.id');
			$this->db->join('tbl_kategori', 'tbl_barang.id_kategori = tbl_kategori.id');
			$this->db->where("tbl_barang.id", $id);
			$query = $this->db->get("tbl_barang");
			$data['data']= $query->result(); 
			$data['title'] = $data['data'][0]->name_barang;
			$data['seo'] = $data['data'][0]->seo_barang;
			$data['deskripsi'] = $data['data'][0]->deskripsi;
			
			$this->db->where("a.id", $data['data'][0]->id);
			$this->db->where("b.stock > 0");
			$this->db->join("tbl_barang_detail b", "b.id_barang = a.id");
			$data['ready_stock'] = $this->db->get("tbl_barang a");;
			
			$this->db->where("id_barang", $data['data'][0]->id);
			$this->db->where("date_pre_order is not null");
			$this->db->where("date_pre_order >= '$today'");
			$this->db->join("tbl_barang b", "b.id = a.id_barang");
			$data['pre_order'] = $this->db->get("tbl_barang_dijual a");;
			
			$query = "SELECT tbl_kategori.* FROM tbl_barang, tbl_kategori WHERE tbl_kategori.id = tbl_barang.id_kategori AND tbl_kategori.ensiklopedia = 1 GROUP BY id";
			$query = $this->db->query($query);
			$data['kategori_style'] = $query->result();
			
			$this->db->where("a.id_kategori", $data['data'][0]->id_kategori);
			$this->db->where("a.id_merk", $data['data'][0]->id_merk);
			$this->db->where_not_in("a.name_barang", $data['data'][0]->name_barang);
			//$this->db->where("a.id_type_produk",$data['data'][0]->id_type_produk);
			$this->db->join("tbl_kategori b", "b.id = a.id_kategori and b.ensiklopedia = 1");
			$this->db->join("tbl_merk c", "c.id = a.id_merk");
			$this->db->order_by("a.id", "random"); 
			$this->db->limit(6); 
			$query = $this->db->get("tbl_barang a");
			$data["related_ensiklopedia"] = "";
			if($query->num_rows() > 0){
				$barang_sejenis = $query->result();
				$data["related_ensiklopedia"]['data'] = $barang_sejenis;
				$data["related_ensiklopedia"]['kategori'] = $barang_sejenis[0]->name_kategori;
			}
			
			$this->db->where("a.id_merk", $data['data'][0]->id_merk);
			$this->db->where("a.name_barang not in(\"".mysql_real_escape_string($data['data'][0]->name_barang)."\")");
			$this->db->join("tbl_kategori b", "b.id = a.id_kategori and b.ensiklopedia = 1");
			$this->db->join("tbl_merk c", "c.id = a.id_merk");
			$this->db->order_by("a.id", "random");
			$this->db->limit(6); 
			$query = $this->db->get("tbl_barang a");
			if($query->num_rows() > 0){
				$barang_semanufaktur = $query->result();
				$data["barang_semanufacture"]['data'] = $barang_semanufaktur;
				$data["barang_semanufacture"]['merk'] = $barang_semanufaktur[0]->name_merk;
			}
			
			$data["item_series"] = $this->m_item->get_same_series_in_stock($data['data'][0]->series, $data['data'][0]->id, $data['data'][0]->divisi_id);
			
			$this->db->select("tbl_market_item.*, tbl_market_user.name_merchant, tbl_market_user.first_name, tbl_market_user.last_name, tbl_market_user.city, tbl_market_user.province ");
			$this->db->where("link_id", $id);
			$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_item.merchant_id");
			$sell_item = $this->db->get("tbl_market_item");
			$data['sell_item'] = $sell_item->result();
			$this->load->view('client/template',$data);
	}	
}