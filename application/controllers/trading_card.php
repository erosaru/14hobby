<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trading_card extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1)
			redirect('login');
		$this->load->model("m_trading_card");
		$this->load->model("m_kategori_kartu");
		$this->load->model("m_captcha");
		$this->load->model("m_proses");
	}

	public function index($nilai = 0){
		$data['template'] = "dbkartu_index";
		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		if(count($uri_parts) > 1)
			$uri_parts = "?".$uri_parts[1];
		else
			$uri_parts = "";
		$link = base_url()."item/index";
		$data['tipe'] = $this->m_trading_card->get_kategori();
		$data['merk'] = $this->m_trading_card->get_merk();
		array_unshift($data['tipe'], array("" => "All"));
		array_unshift($data['merk'], array("" => "All"));
		$batas = 20;
		$data['dafkomen'] = $this->m_kategori_kartu->ambil_index_item($batas, $nilai);
		$jumlah = $this->m_kategori_kartu->jumlah_item();
		$data['page'] = $this->m_trading_card->link_paging($batas, $nilai, $link, $jumlah, $uri_parts);
		$data['card_game_name'] = $this->m_trading_card->get_kategori();
		$this->load->view("client/template", $data);		
	}
	
	public function create(){
		$data['template'] = "dbkartu_form";
		//$data['template'] = "item_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);		
		$data['card_type'] = $this->m_trading_card->get_card_type();
		$data['clan_type'] = $this->m_trading_card->get_clan_type();
		$data['booster_set'] = $this->m_trading_card->get_booster_set();
		$data['merk'] = $this->m_trading_card->get_merk();
		//$data['type_produk'] = $this->m_trading_card->get_type_produk();
		
		
		
		//$data['tipe_produk'] = $this->m_home->get_list_tipe_item_by_kategori("trading card game");
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		$this->load->view('client/template',$data);	
	}
	
	public function save(){
		$today = date('Y-m-d');
		$data = array(
				'name_barang' => $this->input->post('name_barang'),
				'id_merk' => $this->input->post('id_merk'),
				'card_type' => $this->input->post('card_type'),
				'clan_type' => $this->input->post('clan_type'),
				'booster_set' => $this->input->post('booster_set'),
				'seo_barang' => $this->input->post('seo'),
				'deskripsi' => $this->input->post('pesan'),
				'created_date' => $today,
				'ensiklopedia' => $this->input->post('ensiklopedia'),
				'attack_value' => $this->input->post('attack_value'),
				'defend_value' => $this->input->post('defend_value'),
				'effect' => $this->input->post('effect') ? 1 : null
			);
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$hasil =  $this->db->insert('tbl_kartu',$data);
			if($hasil){
				redirect('trading_card');
			}else{
				redirect('trading_card/create');
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			redirect('trading_card/create');
		}
	}
	
	public function edit($id){
		$data['template'] = "dbkartu_form";
		$data['merk'] = $this->m_trading_card->get_merk();
		$data['card_type'] = $this->m_trading_card->get_card_type();
		$data['clan_type'] = $this->m_trading_card->get_clan_type();
		$data['booster_set'] = $this->m_trading_card->get_booster_set();
		$data['merk'] = $this->m_trading_card->get_merk();
		
		$this->db->where("id",$id);		
		$query = $this->db->get("tbl_kartu");
		$data['data'] = $query->result();
		$data['gambar']= $this->m_proses->get_gambar_kartu($id);
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
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
					$hasil =  $this->m_proses->uupdate_data_one("tbl_gambar_kartu",$data, "link_gambar", $x);
				}
			}
		}
		$data = array(
				'name_barang' => $this->input->post('name_barang'),
				'id_merk' => $this->input->post('id_merk'),
				'card_type' => $this->input->post('card_type'),
				'clan_type' => $this->input->post('clan_type'),
				'booster_set' => $this->input->post('booster_set'),
				'seo_barang' => $this->input->post('seo'),
				'deskripsi' => $this->input->post('pesan'),
				'created_date' => $today,
				'ensiklopedia' => $this->input->post('ensiklopedia'),
				'attack_value' => $this->input->post('attack_value'),
				'defend_value' => $this->input->post('defend_value'),
				'effect' => $this->input->post('effect') ? 1 : null
			);
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_kartu',$data);
		if($hasil){
			redirect('trading_card');
		}else{
			redirect('trading_card/edit/'.$id);
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
		$link = base_url()."trading_card/itemkategori";
		$data['jumlah'] = $this->db->count_all('tbl_kategori_kartu');
		$batas = 20;
		$data['dafkomen'] = $this->m_trading_card->ambil($batas, $nilai, 'tbl_kategori_kartu');
		$data['page'] = $this->m_trading_card->link_paging($batas, $nilai, $link, $data['jumlah']);
		$this->load->view('client/template',$data);
	}
	
	public function itemkategori_create(){
		$data['template'] = "itemkategori_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		$this->session->set_userdata('captcha_session', $captcha['word']);			
		
		$this->load->view('client/template',$data);
	}
	
	public function itemkategori_save(){			
		$data = array(
				'name_kategori' => $this->input->post('kategori'),
				'ensiklopedia' => $this->input->post('ensiklopedia')			);
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){			
			$hasil =  $this->db->insert('tbl_kategori_kartu',$data);
			if($hasil){
				redirect('trading_card/itemkategori');
			}else{
				redirect('trading_card/itemkategori_create');
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			redirect('trading_card/itemkategori_create');
		}			
	}
	
	public function itemkategori_edit($id){
		$data['template'] = "itemkategori_form";
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		$this->db->where("id",$id);		
		$this->db->from("tbl_kategori_kartu");		
		$query = $this->db->get();
		$data['data'] = $query->result();
		
		$this->load->view('client/template',$data);
	}
	
	public function itemkategori_update($id){
		$data = array(
			'name_kategori' => $this->input->post('kategori'),
			'ensiklopedia' => $this->input->post('ensiklopedia')
		);
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_kategori_kartu',$data);
		if($hasil){
			redirect('trading_card/itemkategori');
		}else{
			redirect('trading_card/itemkategori_edit/'.$id);
		}
	}
	
	/*Item Sub Kategori*/
	public function itemmerk($nilai=0){
		$data['template'] = "itemmerk_index";
		$link = base_url()."trading_card/itemmerk";
		$data['jumlah'] = $this->db->count_all('tbl_merk_kartu');
		$batas = 20;
		$data['dafkomen'] = $this->m_kategori_kartu->ambil_sub_kategori($batas, $nilai, 'tbl_merk_kartu');
		$data['page'] = $this->m_trading_card->link_paging($batas, $nilai, $link, $data['jumlah']);
		$this->load->view('client/template',$data);
	}	
	
	public function itemmerk_create(){
		$data['template'] = "itemmerk_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);			
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		$this->load->view('client/template',$data);
	}
	
	public function itemmerk_save(){	
		$data = array(
						'name_merk' => $this->input->post('name_merk'),
						'ensiklopedia' => $this->input->post('ensiklopedia')
			);
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$hasil =  $this->db->insert('tbl_merk_kartu',$data);
			if($hasil){
				redirect('trading_card/itemmerk');
			}else{
				sredirect('trading_card/itemmerk_create');
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			redirect('trading_card/itemmerk_create');
		}			
	}
	
	public function itemmerk_edit($id){
		$data['template'] = "itemmerk_form";
		$this->db->where("id",$id);		
		$this->db->from("tbl_merk_kartu");		
		$query = $this->db->get();
		$data['data'] = $query->result();		
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		$this->load->view('client/template',$data);
	}
	
	public function itemmerk_update($id){
		$data = array(
			'name_merk' => $this->input->post('name_merk'),
			'ensiklopedia' => $this->input->post('ensiklopedia')
			
		);
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_merk_kartu',$data);
		if($hasil){
			redirect('trading_card/itemmerk');
		}else{
			sredirect('trading_card/itemmerk_edit/'.$id);
		}		
	}
	
	/*Item Type*/
	public function itemtype($nilai=0){
		$data['template'] = "itemtype_index";
		$link = base_url()."item/itemtype";
		$data['jumlah'] = $this->db->count_all('tbl_type_produk');
		$batas = 20;
		$data['dafkomen'] = $this->m_kategori_kartu->ambil_type_produk($batas, $nilai, 'tbl_sub_kategori');
		$data['page'] = $this->m_trading_card->link_paging($batas, $nilai, $link, $data['jumlah']);
		$this->load->view('client/template',$data);
	}

	public function itemtype_create(){
		$data['template'] = "itemtype_form";
		$data['tipe'] = $this->m_trading_card->get_kategori();
		$data['merk'] = $this->m_trading_card->get_merk();
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		$this->session->set_userdata('captcha_session', $captcha['word']);			
		
		$this->load->view('client/template',$data);
	}	
	
	public function itemtype_save(){
		$data = array(
			'name_type_produk' => $this->input->post('typeproduk'),
			'id_kategori' => $this->input->post('id_kategori'),
			'ensiklopedia' => $this->input->post('ensiklopedia')
		);		
		
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$hasil =  $this->db->insert('tbl_type_produk',$data);	
			if($hasil){
				redirect('item/itemtype');
			}else{
				redirect('item/itemtype_create');
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang ada masukan tidak sesuai, mohon ulangi lagi');
			$this->session->set_flashdata("data",$data);
			redirect('item/itemtype_create');
		}	
	}

	public function itemtype_edit($id){
		$data['template'] = "itemtype_form";
		$data['options_kategori'] = $this->m_kategori_kartu->get_kategori();
		$data['data_ensiklopedia'][] = array(1 => "Ya");
		$data['data_ensiklopedia'][] = array(0 => "Tidak");
		$this->db->where("id",$id);		
		$this->db->from("tbl_type_produk");		
		$query = $this->db->get();
		$data['data'] = $query->result();		
		
		$this->load->view('client/template',$data);
	}	
	
	public function itemtype_update($id){
		$data = array(
			'name_type_produk' => $this->input->post('typeproduk'),
			'id_kategori' => $this->input->post('id_kategori'),
			'ensiklopedia' => $this->input->post('ensiklopedia')
		);
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_type_produk',$data);
		if($hasil){
			redirect('item/itemtype');
		}else{
			redirect('item/itemtype_edit/'.$id);
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
		$data['tipe'] = $this->m_trading_card->get_kategori();
		$data['merk'] = $this->m_trading_card->get_merk();
		array_unshift($data['tipe'], array("" => "All"));
		array_unshift($data['merk'], array("" => "All"));
		
		$batas = 20;
		$data['dafkomen'] = $this->m_kategori_kartu->ambil_index_itemdijual($batas, $nilai);
		$jumlah = $this->m_kategori_kartu->jumlah_itemdijual();
		$data['page'] = $this->m_trading_card->link_paging($batas, $nilai, $link, $jumlah, $uri_parts);
		$data['card_game_name'] = $this->m_trading_card->get_kategori();
		$this->load->view("client/template", $data);		
	}
	
	public function createitemdijual(){
		$data['template'] = "item_dijual_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);		
		
		$data['tipe'] = $this->m_trading_card->get_kategori();
		$data['merk'] = $this->m_trading_card->get_merk();
		$data['kurs'] = $this->m_trading_card->get_kurs();		
		//$data['tipe_produk'] = $this->m_trading_card->get_list_tipe_item_by_kategori("trading card game");
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
				'kurs' => $this->input->post('kurs')
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
		$data['data'] = $query->result();
		$data['tipe'] = $this->m_trading_card->get_kategori();
		$data['merk'] = $this->m_trading_card->get_merk();
		$data['kurs'] = $this->m_trading_card->get_kurs();		
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
				'kurs' => $this->input->post('kurs')
			);
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_barang_dijual',$data);
		if($hasil){
			redirect('item/itemdijual');
		}else{
			redirect('item/edititemdijual/'.$id);
		}
	}
	
	public function deleteitemdijual($id){
		$this->db->where("id", $id);
		$this->db->delete('tbl_barang_dijual');
		redirect('item/itemdijual');			
	}
	
	public function showitemdijual($id){
		$data['template'] = "item_dijual_show";
		
		$this->db->select("a.id id_utama, b.name_barang, b.deskripsi, b.seo_barang, a.harga, a.diskon, e.name_sub_kategori, b.berat, a.id_barang");
		$this->db->join('tbl_kartu b', 'b.id = a.id_barang');
		$this->db->join('tbl_kategori_kartu c', 'c.id = b.id_kategori');
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
}