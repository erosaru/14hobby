<?php
	class Artikel extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model("m_home");
			$this->load->model("m_captcha");
			$this->load->model("m_subkategori");			
			$this->load->model("m_artikel");
			$this->load->model("m_kategori_artikel");
			$this->load->model("m_proses");		
			if($this->router->fetch_method() != "index" && $this->router->fetch_method() != "show"){
				if(($this->session->userdata('login') == false || $this->session->userdata('role_id') > 1))
					redirect('login');
			}
		}
	
		/*admin untuk artikel*/
		public function admin_index($nilai=0){
			$data['template'] = "admin_artikel_index";
			$id_kategori_artikel = $this->input->get("id_kategori_artikel");
			$nama_artikel = $this->input->get("nama_artikel");
			$nama_penulis = $this->input->get("nama_penulis");
			$kategori = $this->input->get("kategori");
			if(!empty($id_kategori_artikel))
				$this->db->where("tbl_artikel.id_kategori_artikel", $id_kategori_artikel);
			if(!empty($nama_artikel))
				$this->db->like("tbl_artikel.title", $nama_artikel);
			if(!empty($nama_penulis))
				$this->db->like("tbl_artikel.pengarang", $nama_penulis);
			if(!empty($kategori))
				$this->db->like("tbl_artikel.kategori", $kategori);
			$this->db->join("tbl_kategori_artikel", "tbl_artikel.id_kategori_artikel = tbl_kategori_artikel.id");
			$result = $this->db->get("tbl_artikel");
			$pagingConfig   = $this->paginationlib->initPagination("/artikel/admin_index",$result->num_rows(), 10);
			$this->pagination->initialize($pagingConfig);
			$page = empty($_GET['page']) ? 0 : $_GET['page'];
			if(!empty($id_kategori_artikel))
				$this->db->where("tbl_artikel.id_kategori_artikel", $id_kategori_artikel);
			if(!empty($nama_artikel))
				$this->db->like("tbl_artikel.title", $nama_artikel);
			if(!empty($nama_penulis))
				$this->db->like("tbl_artikel.pengarang", $nama_penulis);
			if(!empty($kategori))
				$this->db->like("tbl_artikel.kategori", $kategori);
			$this->db->select("tbl_artikel.*, tbl_kategori_artikel.name_kategori");
			$this->db->join("tbl_kategori_artikel", "tbl_artikel.id_kategori_artikel = tbl_kategori_artikel.id");
			$this->db->order_by('tbl_artikel.id', "desc");
			$artikel = $this->db->get("tbl_artikel", $pagingConfig["per_page"], $page);
			$data['dafkomen'] = $artikel->result();
			$data["links"] = $this->pagination->create_links();
			$data['card_game_name'] = $this->m_kategori_artikel->get_list_kategori_artikel(1);
			
			$this->load->view('client/template',$data);
		}	

		public function admin_create(){
			$data['template'] = "admin_artikel_form";
			$captcha = $this->m_captcha->GenerateCaptcha();
			$data['captcha'] = $captcha;
			$data['kategori'] = $this->m_artikel->get_kategori();
			$data['kategori_artikel'] = $this->m_kategori_artikel->get_list_kategori_artikel();			
			$this->session->set_userdata('captcha_session', $captcha['word']);			
			$this->load->view('client/template',$data);
		}			
		
		public function admin_save(){
			$today = date('Y-m-d');
			$data = array(
				'title' => $this->input->post('title'),
				'pesan' => $this->input->post('pesan'),
				'pengarang' => $this->input->post('pengarang'),
				'kategori' => $this->input->post('kategori'),
				'seo_artikel' => $this->input->post('seo_artikel'),
				'created_date' => $today,
				'id_kategori_artikel' => $this->input->post('id_kategori_artikel'),
				'url_title' => create_title($this->input->post('title')),
				'tipsandtrick' => $this->input->post('tipsandtrick') ? $this->input->post('tipsandtrick') : null
			);
			
			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
				$hasil =  $this->db->insert('tbl_artikel',$data);
				if($hasil){
					redirect('artikel/admin_index');
				}else{
					$this->session->set_flashdata('warning', "Masih ada data yang salah input mohon periksa kembali");
					redirect("artikel/admin_create");
				}
			}else{
				$this->session->set_flashdata('warning', 'Kode masih salah, mohon masukan kode dengan benar');
				$this->session->set_flashdata("data",$data);
				redirect("artikel/admin_create");
			}			
		}
		
		public function admin_edit($id){
			$data['template'] = "admin_artikel_form";
			$this->db->select('*, tbl_artikel.id as id_artikel');
			$this->db->where("tbl_artikel.id",$id);		
			$this->db->from("tbl_artikel");		
			$query = $this->db->get();
			$data['data'] = $query->result();
			$data['kategori'] = $this->m_artikel->get_kategori();
			$data['kategori_artikel'] = $this->m_kategori_artikel->get_list_kategori_artikel();	

			$this->load->view('client/template',$data);
		}
		
		public function admin_update($id){
			$data = array(
					'title' => $this->input->post('title'),
					'pesan' => $this->input->post('pesan'),
					'pengarang' => $this->input->post('pengarang'),
					'kategori' => $this->input->post('kategori'),
					'seo_artikel' => $this->input->post('seo_artikel'),
					'id_kategori_artikel' => $this->input->post('id_kategori_artikel'),
					'url_title' => create_title($this->input->post('title')),
					'tipsandtrick' => $this->input->post('tipsandtrick') ? $this->input->post('tipsandtrick') : null
				);
			
			$this->db->where('id', $id);
			$hasil =  $this->db->update('tbl_artikel',$data);
			if($hasil){
				redirect('artikel/admin_index');
			}else{
				redirect('artikel/admin_edit/'.$id);
			}			
		}
		
		public function admin_delete($id){
			$this->db->where("id", $id);
			$this->db->delete('tbl_artikel');
			redirect('artikel/admin_index');			
		}
		
		/*admin untuk kategori artikel*/
		function admin_index_kategori($nilai=0){
			$data['template'] = "artikelkategori_index";
			
			$result = $this->db->get("tbl_kategori_artikel");
			$pagingConfig   = $this->paginationlib->initPagination("/artikel/admin_index_kategori",$result->num_rows(), 10);
			$this->pagination->initialize($pagingConfig);
			$page = empty($_GET['page']) ? 0 : $_GET['page'];
			$event = $this->db->get("tbl_kategori_artikel", $pagingConfig["per_page"], $page);
			$data['dafkomen'] = $event->result();
			$data["links"] = $this->pagination->create_links();			
			$this->load->view('client/template',$data);
		}
		
		function admin_create_kategori($nilai=0){
			$data['template'] = "artikelkategori_form";
			$captcha = $this->m_captcha->GenerateCaptcha();
			$data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);			
		
			$this->load->view('client/template',$data);
		}
		
		function admin_save_kategori(){
			$data = array(
				'name_kategori' => $this->input->post('kategori'),
			);
			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
				
				$hasil =  $this->db->insert('tbl_kategori_artikel',$data);
				if($hasil){
					redirect('artikel/admin_index_kategori');
				}else{
					redirect('artikel/admin_create_kategori');
				}
			}else{
				$this->session->set_flashdata('warning', 'Kode masih salah, mohon masukan kode dengan benar');
				$this->session->set_flashdata("data",$data);
				redirect('artikel/admin_create_kategori');
			}
		}
		
		public function admin_edit_kategori($id){
			$data['template'] = "artikelkategori_form";
			$this->db->where("id",$id);		
			$this->db->from("tbl_kategori_artikel");		
			$query = $this->db->get();
			$data['data'] = $query->result();		
			
			$this->load->view('client/template',$data);
		}
		
		public function admin_update_kategori($id){
			$data = array(
				'name_kategori' => $this->input->post('kategori'),
			);
			$this->db->where('id', $id);
			$hasil =  $this->db->update('tbl_kategori_artikel',$data);
			if($hasil){
				redirect('artikel/admin_index_kategori');
			}else{
				redirect('artikel/admin_edit_kategori/'.$id);
			}		
		}
		
		/*artikel*/		
		public function index($nilai=0){
			$this->m_proses->add_to_counter();
			$data['template'] = "artikel_show";
			$id_kategori_artikel = $this->input->get("id_kategori_artikel");
			$pengarang = $this->input->get("nama_penulis");
			$judul_artikel = $this->input->get("nama_artikel");
			$kategori = $this->input->get("kategori");
			if(!empty($id_kategori_artikel))
				$this->db->where("id_kategori_artikel", $id_kategori_artikel);
			if(!empty($pengarang))
				$this->db->like("pengarang", $pengarang);
			if(!empty($judul_artikel))
				$this->db->like("title", $judul_artikel);
			if(!empty($kategori))
				$this->db->like("kategori", $kategori);
			$artikel = $this->db->get("tbl_artikel");
			$pagingConfig   = $this->paginationlib->initPagination("/artikel/index",$artikel->num_rows(), 6);
			$this->pagination->initialize($pagingConfig);
			if(!empty($id_kategori_artikel))
				$this->db->where("id_kategori_artikel", $id_kategori_artikel);
			if(!empty($pengarang))
				$this->db->like("pengarang", $pengarang);
			if(!empty($judul_artikel))
				$this->db->like("title", $judul_artikel);
			if(!empty($kategori))
				$this->db->like("kategori", $kategori);
			$this->db->order_by("tbl_artikel.id", "desc");
			$page = empty($_GET['page']) ? 0 : $_GET['page'];
			$item = $this->db->get("tbl_artikel", $pagingConfig["per_page"], $page);
			$data['dafkomen'] = $item->result();
			$data["links"] = $this->pagination->create_links();
			$data['card_game_name'] = $this->m_kategori_artikel->get_list_kategori_artikel(1);
			$this->load->view('client/template',$data);
		}	
		
		public function show($title=""){
			$this->m_proses->add_to_counter();
			$data['template'] = "artikel_show_detail";
			$this->db->where("url_title",$title);
			$this->db->join("tbl_kategori_artikel","tbl_kategori_artikel.id = tbl_artikel.id_kategori_artikel");
			$get = $this->db->get('tbl_artikel');
			$data['artikel'] = $get->result();
			$data['title'] = $data['artikel'][0]->title;
			$data['seo'] = $data['artikel'][0]->seo_artikel;
			$data['deskripsi'] = split_words($data['artikel'][0]->pesan);	
			
			$counter = $data['artikel'][0]->counter + 1; 
			$datax = array(
					'counter' => $counter
				);
			$this->db->where("url_title",$title);
			$hasil =  $this->db->update('tbl_artikel',$datax);
			
			$query = "select a.*, b.name_kategori from tbl_artikel a inner join tbl_kategori_artikel b on a.id_kategori_artikel = b.id order by id desc limit 10";
			$query = $this->db->query($query);
			$data['artikel_terbaru'] = $query->result();
			
			$query = "select b.id, b.name_kategori, count(*) as jumlah from tbl_artikel a inner join tbl_kategori_artikel b on a.id_kategori_artikel = b.id group by b.id, b.name_kategori order by name_kategori, rand() limit 10";
			$query = $this->db->query($query);
			$data['kategori_artikel_lain'] = $query->result();
			
			$query = "select a.title from tbl_artikel a inner join tbl_kategori_artikel b on a.id_kategori_artikel = b.id where a.kategori = '".$data['artikel'][0]->kategori."' and a.title != '".$data['artikel'][0]->title."' order by a.title, rand() limit 10";
			$query = $this->db->query($query);
			$data['artikel_sejenis'] = $query->result();
			
			
			$this->load->view('client/template',$data);			
		}
		
		function get_session(){
			echo $this->session->userdata("captcha_session");
		}
	} 
?>