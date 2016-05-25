<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Market_item extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('login') == false || !(in_array($this->session->userdata('role_id'), array(0,1,2))))
			redirect('login');
		$this->load->model("m_home");
		$this->load->model("m_kategori");
		$this->load->model("m_proses");
	}

	public function index($nilai = 0){
		if(!in_array($this->session->userdata('role_id'), array(0,1)))
			redirect('login');
		$this->data['template'] = "market_item_index";
		$this->data['content'] = "market_item_index_show";
		
		$link = base_url()."item/index";
		$this->db->select("tbl_market_item.*, tbl_market_kategori.name_kategori");
		$this->db->where("delete is null");
		$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
		$result = $this->db->get("tbl_market_item");
		$this->data['dafkomen'] = $result->result();		
		$this->load->view("client/template", $this->data);
	}
	
	public function item_need_approve($nilai = 0){
		if(!in_array($this->session->userdata('role_id'), array(0,1)))
			redirect('login');
		$this->data['template'] = "roomuser_index";
		$this->data['content'] = "item_itemneedapprove";
		
		$link = base_url()."item/index";
		$this->db->select("tbl_market_item.*, tbl_market_kategori.name_kategori");
		$this->db->where("active = 0");
		$this->db->where("delete is null");
		$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
		$result = $this->db->get("tbl_market_item");
		$this->data['dafkomen'] = $result->result();		
		$this->load->view("client/template", $this->data);
	}
	
	/*
	public function create(){
		$this->data['template'] = "item_index";
		$this->data['content'] = "item_form";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$this->data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);		
		$this->data['tipe'] = $this->m_home->get_kategori();
		$this->load->view('client/template',$this->data);	
	}
	*/
	
	public function save(){
		if($this->session->userdata("role_id") != 2)
			redirect("dashboard");
		
		$today = date('Y-m-d');
		$this->data = array(
				'id_kategori' => $this->input->post('kategori'),
				'merk' => $this->input->post('merk'),
				'name' => $this->input->post('name'),
				'seo_barang' => $this->input->post('seo_barang'),
				'price' => $this->input->post('price'),
				'deskripsi' => $this->input->post('pesan'),
				'created_date' => $today,
				'merchant_id' => $this->session->userdata('id'),
				'stock' => $this->input->post('stock')
			);		
		
		$warning = "";
		if(empty($this->data['merk']))
			$warning = "Mohon masukkan brand barang yang anda input";
		else if(empty($this->data['name']))
			$warning = "Mohon masukkan nama barang yang anda input";				
		else if(empty($this->data['price']))
			$warning = "Mohon masukkan harga barang anda input";
		else if(empty($this->data['stock']))
			$warning = "Mohon masukkan stok barang anda input";
		elseif(empty($_FILES['picture']['name']))
			$warning = "Mohon masukkan foto dahulu";
		
		if(!empty($warning)){
			$this->session->set_flashdata('warning', $warning);
			$this->session->set_flashdata("data",$this->data);
			redirect("item-form");
		}
		
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$this->load->model("m_roomuser");
			$hasil =  $this->db->insert('tbl_market_item',$this->data);				
			$id_item = $this->db->insert_id();
			if($this->m_roomuser->upload_picture_item($id_item, $this->data)){
				$type_file = strrchr(basename($_FILES['picture']['name']),'.');
				$this->db->where("id", $id_item);
				$this->db->set("picture", $this->session->userdata('id').'_'.create_title_foto($this->data['name']).'_'.$id_item.$type_file);
				$this->db->update("tbl_market_item");
				$this->session->set_flashdata('success', 'Item anda sudah disave. Mohon menunggu approve tim market 14hobby agar item anda ditampilkan');
				redirect("list-item");
			}else{
				$this->db->where("id", $id_item);
				$this->db->delete("tbl_market_item");
				$this->session->set_flashdata("data",$this->data);
				redirect('item-form');
			}
		}else{
			$this->session->set_flashdata('warning', 'Kode yang anda masukkan tidak sama dengan kode pada gambar.');
			$this->session->set_flashdata("data",$this->data);
			redirect("item-form");
		}	
	}
	
	public function delete($id){
		$this->db->set("delete", 1);
		$this->db->where("id", $id);
		$this->db->update("tbl_market_item");
		$this->session->set_flashdata('success', 'Barang anda sudah dihapus dari list');
		redirect("list-item");
	}
	
	public function item_approve($id){
		$this->db->set("active", 1);
		$this->db->where("id", $id);
		$this->db->update("tbl_market_item");
		$this->session->set_flashdata('success', 'Barang sudah di-approve');
		redirect("item/item_need_approve");
	}
	
	public function item_decline($id){
		$this->db->set("active", 2);
		$this->db->where("id", $id);
		$this->db->update("tbl_market_item");
		$this->session->set_flashdata('success', 'Barang sudah ditolak');
		redirect("item/item_need_approve");
	}
	
	public function edit($id){
		if(!in_array($this->session->userdata('role_id'), array(0,1)))
			redirect('dashboard');
		$this->data['content'] = "item_form";
		$this->data['information_stock'][] = array("none" => "none");
		$this->data['information_stock'][] = array("XL" => "XL");
		$this->data['information_stock'][] = array("L" => "L");
		$this->data['information_stock'][] = array("M" => "M");
		$this->data['information_stock'][] = array("S" => "S");		
		$this->data['tipe_active'][] = array("1" => "Yes");
		$this->data['tipe_active'][] = array("0" => "No");
		$this->data['tipe'] = $this->m_home->get_kategori();			
		if($this->session->userdata("role_id") == 1){
			$this->data['template'] = "item_index";			
			$this->db->where("tbl_item.id",$id)->join("tbl_merchant", "tbl_merchant.id = tbl_item.merchant_id");
			$this->db->select("tbl_item.*, tbl_merchant.name_merchant");
		}else{
			$this->data['template'] = "roomuser_index";
			$this->db->where("barcode",$id);					
		}
		
		
		$query = $this->db->get("tbl_item");
		$this->data['dafkomen'] = $query->result();
		if($this->session->userdata("role_id") == 3 && $this->data['dafkomen'][0]->merchant_id != $this->session->userdata("merchant_id"))
			redirect("list-item");		
		$this->db->where('barcode', $id);
		$this->data['detail_stock'] = $this->db->get("tbl_item_detail");
		$this->load->view('client/template',$this->data);
	}
	
	public function update($id){
		if($this->session->userdata("role_id") == 2){
			$this->db->where('id', $id);
			$item = $this->db->get('tbl_market_item');
			$item = $item->result_array();
			if($item[0]['merchant_id'] != $this->session->userdata('id'))
				redirect("dashboard");				
			
			$stock = $this->input->post("stock");
			$price = $this->input->post("price");
			$warning = "";
			if(empty($stock))
				$warning = "Stock tidak boleh kosong, apabila stok sudah habis harap isi angka 0";
			elseif(empty($price))
				$warning = "Harga tidak boleh kosong";
			
			if(!empty($warning)){
				$this->session->set_flashdata('warning', $warning);
				redirect("edit-item/$id");
			}
			
			$this->data = array(
				'price' => $this->input->post('price'),
				'stock' => $this->input->post('stock')
			);
			
			$this->db->where("id", $id);
			$this->db->update("tbl_market_item", $this->data);
			$this->session->set_flashdata('success', 'Data stok dan harga berhasil diupdate');
			/*
			$this->load->model('m_roomuser');
			if($this->m_roomuser->upload_picture_item($id, $item[0])){
				$type_file = strrchr(basename($_FILES['picture']['name']),'.');
				$this->db->set("picture", $this->m_roomuser->get_name_photo_item($id));
				$this->db->where("id", $id);
				$this->db->update("tbl_market_item");
				$this->session->set_flashdata('success', 'Harga, stok dan foto barang sudah dirubah');
			}
			//echo $this->m_roomuser->get_name_photo_item($id);
			*/
			redirect("show-item/$id");
		}else
			redirect('dashboard');
	}
	
	public function show($id){
		$this->db->select('tbl_market_item.*, tbl_market_user.name_merchant, tbl_market_user.city, tbl_market_user.province, tbl_market_kategori.name_kategori, tbl_market_user.first_name, tbl_market_user.last_name');
		$this->db->where('tbl_market_item.id', $id);
		$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_item.merchant_id");
		$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
		$result = $this->db->get("tbl_market_item");
		$result = $result->result();
		$this->data['dafkomen'] = $result;
		$this->data['content'] = "item_show";
		$this->data['template'] = "roomuser_index";
		$this->load->view('client/template',$this->data);
	}
	
	public function extract_data_item(){
		$this->db->select("id_item, name, tbl_item_detail.information, tbl_item_detail.stock, tbl_item_detail.price");
		$this->db->where("merchant_id", $this->session->userdata("merchant_id"));
		$this->db->join("tbl_item_detail", "tbl_item_detail.barcode = tbl_item.barcode", "left");
		$query = $this->db->get("tbl_item");
		
		if(!$query)
			return false;
	
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Field names in the first row
		$fields = $query->list_fields();
		$col = 0;
		foreach ($fields as $field)
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
			$col++;
		}

		// Fetching the table data
		$row = 2;
		foreach($query->result() as $this->data)
		{
			$col = 0;
			foreach ($fields as $field)
			{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $this->data->$field);
				$col++;
			}

			$row++;
		}

		$objPHPExcel->setActiveSheetIndex(0);

		$objWriter   = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		// Sending headers to force the user to download the file
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="item-'.create_title($this->session->userdata("merchant_name"))."-".date('dmYHi').'.xls"');
		header('Cache-Control: max-age=0');

		$objWriter->save('php://output');		
	}
	
	/*item kategori*/
	public function itemkategori($nilai=0){
		$this->data['template'] = "market_item_index";
		$this->data['content'] = "market_itemkategori_index";
		$link = base_url()."item/itemkategori";
		$this->data['jumlah'] = $this->db->count_all('tbl_market_kategori');
		$batas = 20;
		$this->data['dafkomen'] = $this->m_home->ambil($batas, $nilai, 'tbl_market_kategori');
		$this->data['page'] = $this->m_home->link_paging($batas, $nilai, $link, $this->data['jumlah']);
		$this->load->view('client/template',$this->data);
	}
	
	public function itemkategori_create(){
		$this->data['template'] = "market_item_index";
		$this->data['content'] = "market_itemkategori_form";
		$this->load->view('client/template',$this->data);
	}
	
	public function itemkategori_save(){			
		$this->data = array(
				'name_kategori' => $this->input->post('kategori'),
				'link_gambar' => $this->input->post('link_gambar')
				);
		$hasil =  $this->db->insert('tbl_market_kategori',$this->data);
		if($hasil)
			redirect('market_item/itemkategori');
		else
			redirect('market_item/itemkategori_create');
			
		
	}
	
	public function itemkategori_edit($id){
		$this->data['template'] = "market_item_index";
		$this->data['content'] = "market_itemkategori_form";
		$this->db->where("id",$id);		
		$this->db->from("tbl_market_kategori");		
		$query = $this->db->get();
		$this->data['data'] = $query->result();
		
		$this->load->view('client/template',$this->data);
	}
	
	public function itemkategori_update($id){
		$this->data = array(
			'name_kategori' => $this->input->post('kategori'),
			'link_gambar' => $this->input->post('link_gambar')
		);
		$this->db->where('id', $id);
		$hasil =  $this->db->update('tbl_market_kategori',$this->data);
		if($hasil){
			redirect('market_item/itemkategori');
		}else{
			redirect('market_item/itemkategori_edit/'.$id);
		}
	}	
}