<?php
	class Bursa extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model("m_proses");		
			$this->m_proses->add_to_counter();
			$this->m_proses->add_to_counter_browser();
		}
	
		public function index(){
			$data['title'] = "Bursa Ready Stock 14Hobby.com";
			$data['template'] = "bursa_index";
			$query = "select * from tbl_barang a inner join tbl_barang_dijual b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori where stok = 1 group by c.name_kategori";
			$query = $this->db->query($query);
			$data['link'] = $query->result();
			$this->load->view('client/template',$data);
		}
		
		public function detail($id, $divisi_id){
			$data['template'] = "bursa_detail";
			$this->db->where("id", $divisi_id);
			$result = $this->db->get("tbl_divisi");
			$result = $result->result();
			$data['divisi_name'] = create_title($result[0]->name_divisi);
			$this->db->where("tbl_barang.id_kategori", $id);
			$this->db->join("tbl_kategori","tbl_kategori.id = tbl_barang.id_kategori");
			$this->db->join("tbl_merk","tbl_merk.id = tbl_barang.id_merk");
			$this->db->join("tbl_gambar_barang","tbl_gambar_barang.id_barang = tbl_barang.id and tbl_gambar_barang.set_gambar = 1", "left");
			$this->db->join("tbl_barang_detail","tbl_barang_detail.id_barang = tbl_barang.id");
			$this->db->having("sum(tbl_barang_detail.stock) > 0");
			$this->db->group_by("tbl_barang.id");
			$this->db->select("tbl_barang.id_kategori, tbl_gambar_barang.link_gambar, tbl_kategori.name_kategori,tbl_barang.name_barang, tbl_merk.name_merk, tbl_barang.berat, max(tbl_barang_detail.price) as max_price, , min(tbl_barang_detail.price) as min_price");
			$this->db->order_by("tbl_barang.id", "desc");
			$query = $this->db->get("tbl_barang");
			$data['link'] = $query->result();
			
			$query = "select *, sum(b.stock) from tbl_barang a inner join tbl_barang_detail b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori and c.id <> ".$id." and a.divisi_id = $divisi_id group by c.name_kategori having sum(b.stock) > 0";
			$query = $this->db->query($query);
			$data['kategori_ready_stock'] = $query->result();
			
			$query = "select * from tbl_barang a inner join tbl_barang_dijual b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori where date_pre_order is not null and date_pre_order >= date(now()) and a.divisi_id = $divisi_id group by c.name_kategori";
			$query = $this->db->query($query);
			$data['kategori_pre_order'] = $query->result();
			
			$query = "select * from tbl_artikel where tipsandtrick = true";
			$query = $this->db->query($query);
			$data['tipsandtrick'] = $query->result();
			
			$this->load->view('client/template',$data);
		}
		
		public function bursa_all($divisi_id, $page = 1){
			$data['template'] = "bursa_detail";
			$this->db->where("tbl_barang.divisi_id", $divisi_id);
			$this->db->select("*, sum(tbl_barang_detail.stock)");
			$this->db->having("sum(tbl_barang_detail.stock) > 0");
			$this->db->group_by("tbl_barang.id");
			$this->db->join("tbl_kategori","tbl_kategori.id = tbl_barang.id_kategori");
			$this->db->join("tbl_merk","tbl_merk.id = tbl_barang.id_merk");
			$this->db->join("tbl_gambar_barang","tbl_gambar_barang.id_barang = tbl_barang.id and tbl_gambar_barang.set_gambar = 1", "left");
			$this->db->join("tbl_barang_detail","tbl_barang_detail.id_barang = tbl_barang.id");
			$result = $this->db->get("tbl_barang");
			$pagingConfig   = $this->paginationlib->initPagination("/ready-stock-all",$result->num_rows);
			$this->pagination->initialize($pagingConfig);
			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$this->db->where("tbl_barang.divisi_id", $divisi_id);
			$this->db->join("tbl_kategori","tbl_kategori.id = tbl_barang.id_kategori");
			$this->db->join("tbl_merk","tbl_merk.id = tbl_barang.id_merk");
			$this->db->join("tbl_gambar_barang","tbl_gambar_barang.id_barang = tbl_barang.id and tbl_gambar_barang.set_gambar = 1", "left");
			$this->db->join("tbl_barang_detail","tbl_barang_detail.id_barang = tbl_barang.id");
			$this->db->having("sum(tbl_barang_detail.stock) > 0");
			$this->db->group_by("tbl_barang.id");
			$this->db->select("tbl_barang.id_kategori, tbl_gambar_barang.link_gambar, tbl_kategori.name_kategori,tbl_barang.name_barang, tbl_merk.name_merk, tbl_barang.berat, max(tbl_barang_detail.price) as max_price, , min(tbl_barang_detail.price) as min_price");
			$this->db->order_by("tbl_barang.id", "desc");
			$result = $this->db->get("tbl_barang", $pagingConfig["per_page"], $page);
			$data["links"] = $this->pagination->create_links();
			$data['link'] = $result->result();
			
			$query = "select *, sum(b.stock) from tbl_barang a inner join tbl_barang_detail b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori and a.divisi_id = $divisi_id group by c.name_kategori having sum(b.stock) > 0";
			$query = $this->db->query($query);
			$data['kategori_ready_stock'] = $query->result();
			
			$query = "select * from tbl_barang a inner join tbl_barang_dijual b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori where date_pre_order is not null and date_pre_order >= date(now()) and a.divisi_id = $divisi_id group by c.name_kategori";
			$query = $this->db->query($query);
			$data['kategori_pre_order'] = $query->result();
			
			$query = "select * from tbl_artikel where tipsandtrick = true";
			$query = $this->db->query($query);
			$data['tipsandtrick'] = $query->result();
			
			$this->load->view('client/template',$data);
		}
		
		//untuk pre order
		public function index_pre_order(){
			$today = date('Y-m-d');
			$data['title'] = "Bursa Pre Order 14Hobby.com";
			$data['template'] = "bursa_index";
			$query = "select * from tbl_barang a inner join tbl_barang_dijual b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori where date_pre_order is not null and date_pre_order >= '".$today."' group by c.name_kategori";
			$query = $this->db->query($query);
			$data['link'] = $query->result();
			$this->load->view('client/template',$data);
		}
		
		public function preorder_all($divisi_id, $page = 1){
			$data['template'] = "bursa_detail";
			$today = date('Y-m-d');
			$data['title'] = "List Pre Order 14Hobby";
			$data["show"] = $this->input->get("show");
			if(empty($data["show"]))
				$this->db->where("tbl_barang_dijual.date_pre_order >= '".$today."'");			
			$this->db->where("tbl_barang.divisi_id", $divisi_id);	
			$this->db->where("tbl_barang_dijual.date_pre_order is not null");			
			$this->db->join("tbl_kategori","tbl_kategori.id = tbl_barang.id_kategori");
			$this->db->join("tbl_merk","tbl_merk.id = tbl_barang.id_merk");
			$this->db->join("tbl_gambar_barang","tbl_gambar_barang.id_barang = tbl_barang.id and tbl_gambar_barang.set_gambar = 1", "left");
			$this->db->join("tbl_barang_dijual","tbl_barang_dijual.id_barang = tbl_barang.id", "left");
			$this->db->select("tbl_barang_dijual.kurs, tbl_barang.id_kategori, tbl_gambar_barang.link_gambar, tbl_kategori.name_kategori,tbl_barang.name_barang, tbl_merk.name_merk, tbl_barang.berat, tbl_barang_dijual.harga, tbl_barang_dijual.diskon, tbl_barang_dijual.date_pre_order, tbl_barang_dijual.keterangan_pre_order, tbl_barang_dijual.keterangan_barang, tbl_barang_dijual.bonus");
			$result = $this->db->get("tbl_barang");
			$pagingConfig   = $this->paginationlib->initPagination($this->uri->segment(1),$result->num_rows);
			$this->pagination->initialize($pagingConfig);
			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			if(empty($data["show"]))
				$this->db->where("tbl_barang_dijual.date_pre_order >= '".$today."'");
			$this->db->where("tbl_barang.divisi_id", $divisi_id);
			$this->db->where("tbl_barang_dijual.date_pre_order is not null");
			$this->db->join("tbl_kategori","tbl_kategori.id = tbl_barang.id_kategori");
			$this->db->join("tbl_merk","tbl_merk.id = tbl_barang.id_merk");
			$this->db->join("tbl_gambar_barang","tbl_gambar_barang.id_barang = tbl_barang.id and tbl_gambar_barang.set_gambar = 1", "left");
			$this->db->join("tbl_barang_dijual","tbl_barang_dijual.id_barang = tbl_barang.id", "left");
			$this->db->select("tbl_barang_dijual.kurs, tbl_barang.id_kategori, tbl_gambar_barang.link_gambar, tbl_kategori.name_kategori,tbl_barang.name_barang, tbl_merk.name_merk, tbl_barang.berat, tbl_barang_dijual.harga, tbl_barang_dijual.diskon, tbl_barang_dijual.date_pre_order, tbl_barang_dijual.keterangan_pre_order, tbl_barang_dijual.keterangan_barang, tbl_barang_dijual.bonus, tbl_barang_dijual.id");
			$this->db->order_by("tbl_barang_dijual.id", "desc");
			$query = $this->db->get("tbl_barang", $pagingConfig["per_page"], $page);
			$data['link'] = $query->result();
			$data["links"] = $this->pagination->create_links();
			$query = "select *, sum(b.stock) from tbl_barang a inner join tbl_barang_detail b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori and a.divisi_id = $divisi_id group by c.name_kategori having sum(b.stock) > 0";
			$query = $this->db->query($query);
			$data['kategori_ready_stock'] = $query->result();
			
			$query = "select * from tbl_barang a inner join tbl_barang_dijual b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori and c.ensiklopedia = 1 and a.divisi_id = $divisi_id where date_pre_order is not null and date_pre_order >= date(now()) group by c.name_kategori";
			$query = $this->db->query($query);
			$data['kategori_pre_order'] = $query->result();
			
			$query = "select * from tbl_artikel where tipsandtrick = true";
			$query = $this->db->query($query);
			$data['tipsandtrick'] = $query->result();
			$this->load->view('client/template',$data);
		}
		
		public function detail_pre_order($id = 0, $divisi_id){
			$today = date('Y-m-d');
			$data['template'] = "bursa_detail";
			$this->db->where("id", $divisi_id);
			$result = $this->db->get("tbl_divisi");
			$result = $result->result();
			$data['divisi_name'] = create_title($result[0]->name_divisi);
			$this->db->where("tbl_barang.id_kategori", $id);
			$this->db->where("tbl_barang_dijual.date_pre_order is not null");
			$this->db->where("tbl_barang_dijual.date_pre_order >= '".$today."'");
			$this->db->join("tbl_kategori","tbl_kategori.id = tbl_barang.id_kategori");
			$this->db->join("tbl_merk","tbl_merk.id = tbl_barang.id_merk");
			$this->db->join("tbl_gambar_barang","tbl_gambar_barang.id_barang = tbl_barang.id and tbl_gambar_barang.set_gambar = 1", "left");
			$this->db->join("tbl_barang_dijual","tbl_barang_dijual.id_barang = tbl_barang.id", "left");
			$this->db->select("tbl_barang_dijual.kurs, tbl_barang.id_kategori, tbl_gambar_barang.link_gambar, tbl_kategori.name_kategori,tbl_barang.name_barang, tbl_merk.name_merk, tbl_barang.berat, tbl_barang_dijual.harga, tbl_barang_dijual.diskon, tbl_barang_dijual.date_pre_order, tbl_barang_dijual.keterangan_pre_order, tbl_barang_dijual.keterangan_barang, tbl_barang_dijual.bonus");
			$query = $this->db->get("tbl_barang");
			$data['link'] = $query->result();
			
			
			$query = "select * from tbl_barang a inner join tbl_barang_dijual b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori and c.ensiklopedia = 1 where date_pre_order is not null and a.divisi_id = $divisi_id and date_pre_order >= '".$today."' and c.id <> ".(empty($data['link'][0]->id_kategori) ? "0" : $data['link'][0]->id_kategori)." group by c.name_kategori";
			$query = $this->db->query($query);
			$data['kategori_pre_order'] = $query->result();
			
			$query = "select *, sum(b.stock) from tbl_barang a inner join tbl_barang_detail b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori where a.divisi_id = $divisi_id group by c.name_kategori having sum(b.stock) > 0";
			$query = $this->db->query($query);
			$data['kategori_ready_stock'] = $query->result();
			
			$query = "select * from tbl_artikel where tipsandtrick = true";
			$query = $this->db->query($query);
			$data['tipsandtrick'] = $query->result();
			
			$this->load->view('client/template',$data);
		}
		
		public function show_status_po($id){
			$this->db->where("tbl_barang_dijual.id", $id);
			$this->db->join("tbl_barang", "tbl_barang.id = tbl_barang_dijual.id_barang");
			$this->db->join("tbl_gambar_barang","tbl_gambar_barang.id_barang = tbl_barang.id and tbl_gambar_barang.set_gambar = 1", "left");
			$result = $this->db->get("tbl_barang_dijual");
			$data["dafkomen"] = $result->result();
			$this->db->where("barang_dijual_id", $id);
			$result = $this->db->get("tbl_barang_dijual_detail");
			if($result->num_rows == 0)
				redirect("");
			$data["dafkomen_detail"] = $result->result();
			
			$today = date("Y-m-d");
			$query = "select * from tbl_barang a inner join tbl_barang_dijual b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori where a.divisi_id = ".$data["dafkomen"][0]->divisi_id." and date_pre_order is not null and date_pre_order >= '".$today."' and c.id <> ".(empty($data['link'][0]->id_kategori) ? "0" : $data['link'][0]->id_kategori)." group by c.name_kategori";
			$query = $this->db->query($query);
			$data['kategori_pre_order'] = $query->result();
			
			$query = "select *, sum(b.stock) from tbl_barang a inner join tbl_barang_detail b on b.id_barang = a.id inner join tbl_kategori c on c.id = a.id_kategori where a.divisi_id = ".$data["dafkomen"][0]->divisi_id." group by c.name_kategori having sum(b.stock) > 0";
			$query = $this->db->query($query);
			$data['kategori_ready_stock'] = $query->result();
			$data['template'] = "bursa_detail_po";			
			$this->load->view('client/template',$data);
		}
	}
?>