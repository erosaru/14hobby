<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1)
			redirect('login');
		$this->load->model("m_home");
		$this->load->model("m_kategori");
		$this->load->model("m_captcha");
		$this->load->model("m_proses");
	}

	public function index($nilai = 0){
		$data['template'] = "item_index";
		
		$data['tipe'] = $this->m_home->get_kategori();
		$data['merk'] = $this->m_home->get_merk();
		array_unshift($data['tipe'], array("" => "All"));
		array_unshift($data['merk'], array("" => "All"));
		$page = empty($_GET['page']) ? 0 : $_GET['page'];
		$id_kategori = $this->input->get("id_kategori");
		$name_barang = $this->input->get("kata_kunci");
		$id_merk = $this->input->get("id_merk");
		if(!empty($id_kategori))
			$this->db->where("b.id_kategori", $id_kategori);
		if(!empty($id_merk))
			$this->db->where("b.id_merk", $id_merk);
		if(!empty($name_barang)){
			$this->db->or_like('b.name_barang', $name_barang);
			$this->db->or_like('b.type_produk', $name_barang);
		}
		$this->db->join("tbl_divisi d", "d.id = b.divisi_id");
		$this->db->join("tbl_kategori a", "a.id = b.id_kategori");
		$this->db->join("tbl_merk c", "c.id = b.id_merk");
		$item = $this->db->get("tbl_barang b");
		$pagingConfig   = $this->paginationlib->initPagination("/item/index",$item->num_rows, 10);
		$this->pagination->initialize($pagingConfig);
		if(!empty($id_kategori))
			$this->db->where("b.id_kategori", $id_kategori);
		if(!empty($id_merk))
			$this->db->where("b.id_merk", $id_merk);
		if(!empty($name_barang)){
			$this->db->or_like('b.name_barang', $name_barang);
			$this->db->or_like('b.type_produk', $name_barang);
		}
		$this->db->select("b.id, b.name_barang, a.name_kategori, c.name_merk, b.type_produk, b.deskripsi, d.name_divisi");
		$this->db->join("tbl_divisi d", "d.id = b.divisi_id");
		$this->db->join("tbl_kategori a", "a.id = b.id_kategori");
		$this->db->join("tbl_merk c", "c.id = b.id_merk");
		$this->db->order_by("id", "desc");
		$item = $this->db->get("tbl_barang b", $pagingConfig["per_page"], $page);
		$data['dafkomen'] = $item->result();
		$data["links"] = $this->pagination->create_links();
		$jumlah = $this->m_kategori->jumlah_item();
		$data['card_game_name'] = $this->m_home->get_kategori();
		$this->load->view("client/template", $data);	
	}
	
	public function create(){
		$data['template'] = "item_form";
		$divisi_id = $this->input->get("divisi_id");
		if(!empty($divisi_id)){
			$this->db->where("id", $divisi_id);
			$result = $this->db->get("tbl_divisi");
			$divisi = $result->result();
			if($result->num_rows() == 0){
				$this->session->set_flashdata('warning', 'tidak ada divisi yang anda maksud');
			}
			$captcha = $this->m_captcha->GenerateCaptcha();
			$data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);		
			$data['tipe'] = $this->m_home->get_kategori($divisi_id );
			$data['merk'] = $this->m_home->get_merk($divisi_id);
			if(empty($data['tipe'])){
				$this->session->set_flashdata('warning', 'Mohon masukkan belum ada list kategori barang untuk divisi '.$divisi[0]->name_divisi);
				redirect('itemkategori');
			}
			if(empty($data['merk'])){
				$this->session->set_flashdata('warning', 'Mohon masukkan belum ada list merk barang untuk divisi '.$divisi[0]->name_divisi);
				redirect('itemmerk');
			}
			$data['type_produk'] = $this->m_home->get_type_produk();		
			//$data['tipe_produk'] = $this->m_home->get_list_tipe_item_by_kategori("trading card game");
			$data['data_ensiklopedia'][] = array(1 => "Ya");
			$data['data_ensiklopedia'][] = array(0 => "Tidak");
		}else{
			$this->db->order_by("name_divisi");
			$result = $this->db->get("tbl_divisi");
			if($result->num_rows() == 0){
				$this->session->set_flashdata('warning', 'Mohon input dahulu data divisi');
				redirect('divisi');
			}
			$data['divisi'] = $result->result();
		}
		
		$this->load->view('client/template',$data);	
	}
	
	public function save(){
		$today = date('Y-m-d');
		$data = array(
				'id_kategori' => $this->input->post('id_kategori'),
				'id_merk' => $this->input->post('id_merk'),
				'type_produk' => $this->input->post('type_produk'),
				'name_barang' => $this->input->post('name_barang'),
				'series' => $this->input->post('series'),
				'seo_barang' => $this->input->post('seo'),
				'berat' => $this->input->post('berat'),
				'panjang' => $this->input->post('panjang'),
				'lebar' => $this->input->post('lebar'),
				'tinggi' => $this->input->post('tinggi'),
				'deskripsi' => $this->input->post('pesan'),
				'release_date' => $this->input->post('release_date') ? save_tanggal($this->input->post('release_date')) : null, 
				'created_date' => $today,
				'ensiklopedia' => $this->input->post('ensiklopedia'),
				'divisi_id' => $this->input->post('divisi_id')
			);
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$hasil =  $this->db->insert('tbl_barang',$data);
			if($hasil){
				redirect('item');
			}else{
				redirect('item/create'.add_parameter());
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			redirect('item/create'.add_parameter());
		}
	}
	
	public function edit($id){
		$data['template'] = "item_form";		
		$data['type_produk'] = $this->m_home->get_type_produk();
		$data['info_stock'] = $this->m_home->detail_stock();
		$this->db->where("id",$id);		
		$query = $this->db->get("tbl_barang");
		$data['dafkomen'] = $query->result();
		$data['tipe'] = $this->m_home->get_kategori($data['dafkomen'][0]->divisi_id);
		$data['merk'] = $this->m_home->get_merk($data['dafkomen'][0]->divisi_id);
		$data['gambar']= $this->m_proses->get_gambar($id);
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		
		$this->db->where('id_barang', $id);
		$data['detail_stock'] = $this->db->get("tbl_barang_detail");
		$this->load->view('client/template',$data);
	}
	
	public function update($id){
		$gambar = $this->input->post('igambar');
		if(!empty($gambar)){
			$gambar = explode(",", $gambar);
			foreach($gambar as $x){
				if(!empty($x)){
					$data = array(
						"flag" => 1,
					);
					$hasil =  $this->m_proses->uupdate_data_one("tbl_gambar_barang",$data, "link_gambar", $x);
				}
			}
		}
		$data = array(
				'id_kategori' => $this->input->post('id_kategori'),
				'id_merk' => $this->input->post('id_merk'),
				'type_produk' => $this->input->post('type_produk'),
				'name_barang' => $this->input->post('name_barang'),
				'seo_barang' => $this->input->post('seo'),
				'berat' => $this->input->post('berat'),
				'deskripsi' => $this->input->post('pesan'),
				'release_date' => $this->input->post('release_date') ? save_tanggal($this->input->post('release_date')) : null, 
				'ensiklopedia' => $this->input->post('ensiklopedia'),
				'panjang' => $this->input->post('panjang'),
				'lebar' => $this->input->post('lebar'),
				'tinggi' => $this->input->post('tinggi'),
				'series' => $this->input->post('series')
			);
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_barang',$data);
		
		$pricenstock = array();
		$information = $this->input->post("information");
		$stock = $this->input->post("stock");
		$price = $this->input->post("price");
		for($i=0;$i<count($information);$i++){
			if(!empty($information[$i]) && !empty($information[$i]) && !empty($information[$i]))
				$pricenstock[] = array("information" => $information[$i], "stock" => $stock[$i], "price" => $price[$i]);
		}
		
		$this->db->where('id_barang', $id);
		$this->db->delete('tbl_barang_detail');	
		
		for($i=0;$i<count($pricenstock);$i++){
			$data = array(
				'id_barang' => $id,
				'stock' => $pricenstock[$i]['stock'],
				'price' => $pricenstock[$i]['price'],
				'information' => $pricenstock[$i]['information']
			);
			$this->db->insert("tbl_barang_detail", $data);
		}
		if($hasil){
			redirect('item');
		}else{
			redirect('item/edit/'.$id);
		}
	}
	
	public function show($id){
		$data['template'] = "item_show";
		$data['gambar']= $this->m_proses->get_gambar($id);
		$this->db->select("tbl_barang.*, tbl_merk.name_merk, tbl_kategori.name_kategori	");
		$this->db->join('tbl_merk', 'tbl_barang.id_merk = tbl_merk.id');
		$this->db->join('tbl_kategori', 'tbl_barang.id_kategori = tbl_kategori.id');
		$this->db->where("tbl_barang.id", $id);
		$query = $this->db->get("tbl_barang");
		$data['data']= $query->result(); 
		$data['title'] = $data['data'][0]->name_barang;
		$data['seo'] = $data['data'][0]->seo_barang;
		$data['deskripsi'] = $data['data'][0]->deskripsi;
		$today = date("Y-m-d");
		
		$this->db->where("id_barang", $data['data'][0]->id);
		$this->db->where("stok", 1);
		$this->db->join("tbl_barang b", "b.id = a.id_barang");
		$data['ready_stock'] = $this->db->get("tbl_barang_dijual a");
			
		$this->db->where("id_barang", $data['data'][0]->id);
		$this->db->where("date_pre_order is not null");
		$this->db->where("date_pre_order >= '$today'");
		$this->db->join("tbl_barang b", "b.id = a.id_barang");
		$data['pre_order'] = $this->db->get("tbl_barang_dijual a");
		
		$this->load->view('client/template',$data);
	}
	
	/*item kategori*/
	public function itemkategori($nilai=0){
		$data['template'] = "itemkategori_index";
		$link = base_url()."item/itemkategori";
		$data['jumlah'] = $this->db->count_all('tbl_kategori');
		$batas = 20;
		$this->db->limit($batas, $nilai);
		$this->db->select("tbl_kategori.*, tbl_divisi.name_divisi");
		$this->db->join("tbl_divisi", "tbl_kategori.divisi_id = tbl_divisi.id", "left");
		$result = $this->db->get('tbl_kategori');
		$data['dafkomen'] = $result->result();
		$data['page'] = $this->m_home->link_paging($batas, $nilai, $link, $data['jumlah']);
		$this->load->view('client/template',$data);
	}
	
	public function itemkategori_create(){
		$data['template'] = "itemkategori_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		$this->session->set_userdata('captcha_session', $captcha['word']);			
		$data['data_divisi'] = $this->m_kategori->get_data_divisi();
		$this->load->view('client/template',$data);
	}
	
	public function itemkategori_save(){
		$data = array(
				'name_kategori' => $this->input->post('kategori'),
				'ensiklopedia' => $this->input->post('ensiklopedia'),
				'divisi_id' => $this->input->post('divisi_id')
		);
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){			
			$hasil =  $this->db->insert('tbl_kategori',$data);
			if($hasil){
				redirect('item/itemkategori');
			}else{
				redirect('item/itemkategori_create');
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			redirect('item/itemkategori_create');
		}			
	}
	
	public function itemkategori_edit($id){
		$data['template'] = "itemkategori_form";
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		$this->db->where("id",$id);		
		$this->db->from("tbl_kategori");		
		$query = $this->db->get();
		$data['data'] = $query->result();
		$data['data_divisi'] = $this->m_kategori->get_data_divisi();
		$this->load->view('client/template',$data);
	}
	
	public function itemkategori_update($id){
		$data = array(
			'name_kategori' => $this->input->post('kategori'),
			'ensiklopedia' => $this->input->post('ensiklopedia'),
			'divisi_id' => $this->input->post('divisi_id')
		);
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_kategori',$data);
		if($hasil){
			redirect('item/itemkategori');
		}else{
			redirect('item/itemkategori_edit/'.$id);
		}
	}
	
	/*Item Merk*/
	public function itemmerk($nilai=0){
		$data['template'] = "itemmerk_index";
		$link = base_url()."item/itemmerk";
		$data['jumlah'] = $this->db->count_all('tbl_merk');
		$this->db->select("tbl_merk.*, tbl_divisi.name_divisi");
		$this->db->join("tbl_divisi", "tbl_merk.divisi_id = tbl_divisi.id", "left");
		$result = $this->db->get('tbl_merk');
		$segment = 3;
		$pagingConfig   = $this->paginationlib->initPagination("/item/itemmerk",$result->num_rows, 10, $segment);
		$this->pagination->initialize($pagingConfig);
		$page = empty($_GET['page']) ? 0 : $_GET['page'];
		$this->db->select("tbl_merk.*, tbl_divisi.name_divisi");
		$this->db->join("tbl_divisi", "tbl_merk.divisi_id = tbl_divisi.id", "left");
		$result = $this->db->get("tbl_merk", $pagingConfig["per_page"], $page);
		$data['dafkomen'] = $result->result();
		$data["links"] = $this->pagination->create_links();
		$this->load->view('client/template',$data);
	}	
	
	public function itemmerk_create(){
		$data['template'] = "itemmerk_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);			
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		$data['data_divisi'] = $this->m_kategori->get_data_divisi();
		$this->load->view('client/template',$data);
	}
	
	public function itemmerk_save(){
		$data = array(
						'name_merk' => $this->input->post('name_merk'),
						'ensiklopedia' => $this->input->post('ensiklopedia'),
						'divisi_id' => $this->input->post('divisi_id')
			);
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$hasil =  $this->db->insert('tbl_merk',$data);
			if($hasil){
				redirect('item/itemmerk');
			}else{
				sredirect('item/itemmerk_create');
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			redirect('item/itemmerk_create');
		}			
	}
	
	public function itemmerk_edit($id){
		$data['template'] = "itemmerk_form";
		$this->db->where("id",$id);		
		$this->db->from("tbl_merk");		
		$query = $this->db->get();
		$data['data'] = $query->result();		
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		$data['data_divisi'] = $this->m_kategori->get_data_divisi();
		$this->load->view('client/template',$data);
	}
	
	public function itemmerk_update($id){
		$data = array(
			'name_merk' => $this->input->post('name_merk'),
			'ensiklopedia' => $this->input->post('ensiklopedia'),
			'divisi_id' => $this->input->post('divisi_id')
			
		);
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_merk',$data);
		if($hasil){
			redirect('item/itemmerk');
		}else{
			sredirect('item/itemmerk_edit/'.$id);
		}		
	}
	
	/*function untuk set gambar*/
	function psetgambar(){
		$data_aktif= array(
			"set_gambar" => 1
		);
		
		$data_zero= array(
			"set_gambar" => 0
		);
		$id_gambar = $this->input->post('id_gambar');
		$id_barang = $this->input->post('id_barang');
		$this->load->model('m_proses');
		$this->m_proses->uupdate_data_one("tbl_gambar_barang",$data_zero, "id_barang", $id_barang);
		$this->m_proses->uupdate_data_one("tbl_gambar_barang",$data_aktif, "id", $id_gambar);
		
		redirect("item/edit/$id_barang");
	}
	
	/*hapus gambar*/
	function phapusgambar(){
		$id_gambar = $this->input->post('id_gambar');
		$id_barang = $this->input->post('id_barang');
		$sama = $this->input->post('x');
		$this->load->model('m_proses');
		$nama = $this->m_proses->delete_file($id_gambar);
		if($sama){
			$data_aktif= array(
				"set_gambar" => 1
			);
			$gid_baru = $this->m_proses->uget_data_one("id", "tbl_gambar_barang", "flag = 1 and id_barang = ".$id_barang, "id_barang", "asc");
			$set_baru = $gid_baru[0]['id'];
			$this->m_proses->uupdate_data_one("tbl_gambar_barang",$data_aktif, "id", $set_baru);
		}
		
		redirect("item/edit/$id_barang");
	}
	
	//item di jual
	public function itemdijual($nilai = 0){
		$data['template'] = "item_dijual_index";
		$link = base_url()."item/itemdijual";
		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		if(count($uri_parts) > 1)
			$uri_parts = "?".$uri_parts[1];
		else
			$uri_parts = "";
		$data['tipe'] = $this->m_home->get_kategori();
		$data['merk'] = $this->m_home->get_merk();
		array_unshift($data['tipe'], array("" => "All"));
		array_unshift($data['merk'], array("" => "All"));		
		$batas = 20;
		$data['dafkomen'] = $this->m_kategori->ambil_index_itemdijual($batas, $nilai);
		$jumlah = $this->m_kategori->jumlah_itemdijual();
		$data['page'] = $this->m_home->link_paging($batas, $nilai, $link, $jumlah, $uri_parts);
		$data['card_game_name'] = $this->m_home->get_kategori();
		$this->load->view("client/template", $data);		
	}
	
	public function createitemdijual(){
		$data['template'] = "item_dijual_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);
		
		$data['tipe'] = $this->m_home->get_kategori();
		$data['merk'] = $this->m_home->get_merk();
		$data['kurs'] = $this->m_home->get_kurs();		
		//$data['tipe_produk'] = $this->m_home->get_list_tipe_item_by_kategori("trading card game");
		$this->load->view('client/template',$data);	
	}
	
	public function saveitemdijual(){
		$data = array(
				'id_kategori' => $this->input->post('id_kategori'),
				'id_merk' => $this->input->post('id_merk'),
				'name_barang' => $this->input->post('name_barang'),
				'harga' => $this->input->post('harga'),
				'diskon' => $this->input->post('diskon'),
				'stok' => $this->input->post('stok'),
				'date_pre_order' => $this->input->post('date_pre_order'),
				'id_barang' => $this->input->post('id_barang'),
				'keterangan_pre_order' => $this->input->post('keterangan_pre_order'),
				'keterangan_barang' => $this->input->post('keterangan_barang'),
				'bonus' => $this->input->post('bonus'),
				'kurs' => $this->input->post('kurs'),
				'slot' => $this->input->post('slot')
			);
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$today = date('Y-m-d');
			$data = array(
				'id_barang' => $this->input->post('id_barang'),
				'harga' => $this->input->post('harga'),
				'diskon' => $this->input->post('diskon'),
				'stok' => $this->input->post('stok'),
				'created_date' => $today,
				'date_pre_order' => $this->input->post('date_pre_order') ? save_tanggal($this->input->post('date_pre_order')) : null,
				'keterangan_pre_order' => $this->input->post('keterangan_pre_order')? $this->input->post('keterangan_pre_order') : null,
				'keterangan_barang' => $this->input->post('keterangan_barang')? $this->input->post('keterangan_barang') : null,
				'bonus' => $this->input->post('bonus')? $this->input->post('bonus') : null,
				'kurs' => $this->input->post('kurs')
			);
			$hasil =  $this->db->insert('tbl_barang_dijual',$data);
			if($hasil){
				redirect('item/itemdijual');
			}else{
				redirect('item/createitemdijual');
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			redirect('item/createitemdijual');
		}
	}
	
	public function edititemdijual($id){
		$data['template'] = "item_dijual_form";
		$this->db->select("b.*, a.id_kategori, a.id_merk, a.name_barang");
		$this->db->join("tbl_barang a", "a.id = b.id_barang");
		$this->db->where("b.id",$id);		
		$query = $this->db->get("tbl_barang_dijual b");
		$data['dafkomen'] = $query->result();
		$this->db->where("barang_dijual_id", $data['dafkomen'][0]->id);
		$result = $this->db->get("tbl_barang_dijual_detail");
		$data['barang_dijual_detail'] = $result->result();
		$data['tipe'] = $this->m_home->get_kategori();
		$data['merk'] = $this->m_home->get_merk();
		$data['kurs'] = $this->m_home->get_kurs();		
		$this->load->view('client/template',$data);
	}
	
	public function updateitemdijual($id){	
		$data = array(
				'harga' => $this->input->post('harga'),
				'diskon' => $this->input->post('diskon'),
				'stok' => $this->input->post('stok'),
				'date_pre_order' => $this->input->post('date_pre_order') ? save_tanggal($this->input->post('date_pre_order')) : null,
				'id_barang' => $this->input->post('id_barang'),
				'keterangan_pre_order' => $this->input->post('keterangan_pre_order')? $this->input->post('keterangan_pre_order') : null,
				'keterangan_barang' => $this->input->post('keterangan_barang')? $this->input->post('keterangan_barang') : null,
				'bonus' => $this->input->post('bonus')? $this->input->post('bonus') : null,
				'kurs' => $this->input->post('kurs'),
				'slot' => $this->input->post('slot'),
			);
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_barang_dijual',$data);
		if($hasil){
			redirect('item/itemdijual');
		}else{
			redirect('item/edititemdijual/'.$id);
		}
	}
	
	public function get_nama_barang(){
		$this->db->where("id_kategori", $this->input->post("id_kategori"));
		$this->db->where("id_merk", $this->input->post("id_merk"));
		$query = $this->db->get("tbl_barang");
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row->name_barang;
			}
		}
		if(!empty($data))
			echo implode(',',$data);	
		else
			echo "";
	}
	
	public function get_id_barang(){
		$this->db->where("name_barang", $this->input->post("name_barang"));
		$query = $this->db->get("tbl_barang");
		if($query->num_rows() > 0){
			$query = $query->result();
			echo $query[0]->id;
		}else
			echo "";
	}
	
	public function deleteitemdijual($id){
		$this->db->where("id", $id);
		$this->db->delete('tbl_barang_dijual');
		redirect('item/itemdijual');			
	}
	
	public function showitemdijual($id){
		$data['template'] = "item_dijual_show";
		
		$this->db->select("a.id id_utama, b.name_barang, b.deskripsi, b.seo_barang, a.harga, a.diskon, e.name_sub_kategori, b.berat, a.id_barang");
		$this->db->join('tbl_barang b', 'b.id = a.id_barang');
		$this->db->join('tbl_kategori c', 'c.id = b.id_kategori');
		$this->db->join('tbl_type_produk d', 'd.id = b.id_type_produk');
		$this->db->join('tbl_sub_kategori e', 'b.id_sub_kategori = e.id');
		$this->db->where("a.id", $id);
		$query = $this->db->get("tbl_barang_dijual a");
		$data['data']= $query->result(); 
		$data['gambar']= $this->m_proses->get_gambar($data['data'][0]->id_barang);
		$data['title'] = $data['data'][0]->name_barang;
		$data['seo'] = $data['data'][0]->seo_barang;
		$data['deskripsi'] = $data['data'][0]->deskripsi;
		$this->load->view('client/template',$data);
	}
	
	function add_order_po(){
		$data = array(
			"nama_lengkap" => $this->input->post("nama_lengkap"),
			"telp" => $this->input->post("telp"),
			"dp" => $this->input->post("dp"),
			"slot" => $this->input->post("slot"),
			"barang_dijual_id" => $this->input->post("barang_dijual_id")
		);
		$this->db->insert("tbl_barang_dijual_detail", $data);
		$this->session->set_flashdata('success', 'Orderan PO sudah dimasukkan');
		redirect("item/edititemdijual/".$this->input->post("barang_dijual_id"));
	}
	
	function delete_order_po($id_barang, $id){
		$this->db->where("id", $id);
		$this->db->delete("tbl_barang_dijual_detail");
		$this->session->set_flashdata('success', 'Orderan PO sudah dihapus');
		redirect("item/edititemdijual/".$id_barang);
	}
	
	//all about divisi
	function divisi(){
		$data['template'] = "divisi_index";
		$result = $this->db->get("tbl_divisi");
		$data['dafkomen'] = $result->result();
		$this->load->view('client/template',$data);
	}
	
	function divisi_create(){
		$data['template'] = "divisi_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);
		$this->load->view('client/template',$data);
	}
	
	function divisi_save(){
		$data = array(
			"name_divisi" => $this->input->post("name_divisi")
		);
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$this->db->insert("tbl_divisi", $data);
			$this->session->set_flashdata('success', 'Divisi baru sudah terdaftar');
			redirect("item/divisi");
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			redirect('item/divisi_create');
		}
	}
	
	function divisi_edit($id){
		$this->db->where("id", $id);
		$result = $this->db->get("tbl_divisi");
		$data['dafkomen'] = $result->result();
		$data['template'] = "divisi_form";
		$this->load->view('client/template',$data);
	}
	
	function divisi_update($id){
		$data = array(
			"name_divisi" => $this->input->post("name_divisi")
		);
		$this->db->where("id", $id);
		$this->db->update("tbl_divisi", $data);
		$this->session->set_flashdata('success', 'Divisi baru sudah terdaftar');
		redirect("item/divisi");
	}
	
	function item_check_for_publish($id){
		$pesan = $this->input->get('pesan');
		$status = $this->input->get('status');
		
		if($status == "decline"){
			if(empty($pesan)){
				$this->session->set_flashdata('warning', 'Alasan untuk menolak item ini harus diisi dahulu dahulu');
				redirect("roomuser/item_show/$id");
			}
			$this->db->set("active", 2);
			$this->db->set("alasan_penolakan", $this->input->get('pesan') ? $this->input->get('pesan') : null);
			$this->db->where("id", $id);
			$this->db->update("tbl_market_item");
			$this->session->set_flashdata('success', 'Barang sudah ditolak');
		}else{
			$this->db->set("active", 1);
			$this->db->where("id", $id);
			$this->db->update("tbl_market_item");
			$this->session->set_flashdata('success', 'Barang sudah di-approve');		
		}
		redirect("roomuser/item_need_approve");		
	}
}