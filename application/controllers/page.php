<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("m_captcha");		
		$this->load->model("m_proses");		
		$this->m_proses->add_to_counter_browser();
	}

	public function index(){
		$today = date("Y-m-d");
		$this->m_proses->add_to_counter();
		$data['template'] = "home";
		/*ambil data pemberitahuan*/
		$pengumuman = $this->db->get("tbl_system");
		if($pengumuman->num_rows() > 0){
			$pengumuman = $pengumuman->result();
			if(!empty($pengumuman[0]->pengumuman))
				$data['pengumuman'] = $pengumuman[0]->pengumuman;
		}
		
		/*ambil data turnamen yang tidak rutin*/
		$query = "SELECT *, DATEDIFF('$today',created_date) AS lama FROM tbl_turnamen WHERE date('$today') <= end_date  AND end_date != '0000-00-00' order by id limit 5";
		$data['turnamen_baru'] = $this->db->query($query);
		
		$query = "SELECT  *, tbl_artikel.id AS id_artikel, DATEDIFF('$today',created_date) AS lama FROM tbl_artikel INNER JOIN tbl_kategori_artikel ON tbl_artikel.id_kategori_artikel = tbl_kategori_artikel.id order by tbl_artikel.id desc limit 5";
		$data['artikel_baru'] = $this->db->query($query);

		$query = "SELECT COUNT(DATEDIFF('$today',created_date)) AS jumlah FROM tbl_barang a INNER JOIN tbl_kategori b ON a.id_kategori = b.id WHERE b.ensiklopedia = 1 and DATEDIFF('$today',created_date) <= 14 and b.divisi_id = 1";
		$data['ensiklopedia_baru'] = $this->db->query($query);
		$data['ensiklopedia_baru'] = $data['ensiklopedia_baru']->result_array();
		
		$query = "SELECT *, DATEDIFF('$today',created_date) AS lama FROM tbl_event WHERE date('$today') <= end_date  AND end_date != '0000-00-00' order by id limit 5";
		$data['event_baru'] = $this->db->query($query);
		
		$this->db->limit(4);
		$query = $this->db->get("tbl_kategori");
		$data['link'] = $query->result_array();
		shuffle($data['link']);
		
		$this->db->where("tipe_banner",1);
		$query =$this->db->get("tbl_banner");
		$data["banner_home"] = $query->result();
		
		$this->db->select("tbl_market_user.first_name, tbl_market_user.last_name, tbl_market_user.name_merchant, tbl_market_item.id, tbl_market_item.picture, tbl_market_item.name, tbl_market_item.stock, tbl_market_user.city, tbl_market_item.price");
		$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_item.merchant_id");
		$this->db->where("delete is null");
		$this->db->where("active = 1");
		$this->db->order_by("tbl_market_item.id", "desc");
		$item = $this->db->get("tbl_market_item", 10);

		if($item->num_rows()>0){
			$data['item'] = $item->result();
		}
		
		//$data['kurs'] = $this->m_proses->get_kurs();		
		$this->load->view("client/template", $data);
	}
	
	public function tentangkami(){
		$data['template'] = "tentangkami";
		$this->load->view("client/template", $data);
	}
	
	public function how_to_buy(){
		$data['template'] = "howtobuy";
		$this->load->view("client/template", $data);
	}
	
	public function faq(){
		$data['template'] = "faq";
		$this->load->view("client/template", $data);
	}
	
	/*
	public function produk(){
		$data['template'] = "produk";
		$this->load->view("client/template", $data);
	}
	*/
	
	public function perubahan_web(){
		$data['template'] = "perubahan_web";
		$this->load->view("client/template", $data);
	}
	
	/*
	public function daftar_toko(){
		$this->m_proses->add_to_counter();
		$data['template'] = "daftar_toko";
		
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);		
		
		$this->load->view("client/template", $data);
	}
	*/
	
	public function list_toko(){
		$today = date("Y-m-d");
		$this->m_proses->add_to_counter();
		$data['title'] = "kumpulan toko hobi";
		$data['deskripsi'] = "List-list toko hobi mainan, game, animasi dan komik yang ada di indonesia";
		$data['seo'] = "toko, hobby, hobi, action figure, sclupture, video game, mainan, list toko hobi indonesia";
		$data['template'] = "list_toko";
		$this->db->select("kota");
		$this->db->group_by("kota");
		$this->db->order_by("kota");
		$result = $this->db->get("tbl_list_toko");
		$kota = $result->result_array();
		
		$data["dafkomen"] = "";		
		if($result->num_rows() > 0)
			foreach($kota as $row){			
				$this->db->where("kota", $row['kota']);
				$this->db->where("aktif", 1);
				$this->db->where("end_date >= '".$today."'");		
				$result = $this->db->get("tbl_list_toko");
				$toko = $result->result_array();
				if($result->num_rows() > 0)
					$data['dafkomen'][$row['kota']]['kota'] = $row['kota'];
					foreach($toko as $rowx){
						$data['dafkomen'][$row['kota']]['data'][] = $rowx;						
					}
			}
		$this->load->view("client/template", $data);
	}
	
	/*
	public function daftar_komunitas(){
		$this->m_proses->add_to_counter();
		$data['template'] = "daftar_komunitas";
		
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);		
		
		$this->load->view("client/template", $data);
	}
	*/
	
	public function list_komunitas(){
		$this->m_proses->add_to_counter();
		$data['title'] = "kumpulan komunitas hobi";
		$data['deskripsi'] = "14Hobby menyediakan list-list komunitas hobi yang ada di indonesia";
		$data['seo'] = "komunitas, hobby, hobi, action figure, sclupture, video game, mainan";
		$data['template'] = "list_komunitas";
		$this->db->select("kota");
		$this->db->group_by("kota");
		$this->db->order_by("kota");
		$result = $this->db->get("tbl_list_komunitas");
		$kota = $result->result_array();
		
		$data["dafkomen"] = "";		
		if($result->num_rows() > 0)
			foreach($kota as $row){			
				$this->db->where("kota", $row['kota']);
				$this->db->where("aktif", 1);
				$result = $this->db->get("tbl_list_komunitas");
				$toko = $result->result_array();
				if($result->num_rows() > 0)
					$data['dafkomen'][$row['kota']]['kota'] = $row['kota'];
					foreach($toko as $rowx){
						$data['dafkomen'][$row['kota']]['data'][] = $rowx;						
					}
			}
		$this->load->view("client/template", $data);
	}
	
	public function cara_pasang_event_turnamen(){
		$data['template'] = "cara_pasang_event_turnamen";
		$this->load->view("client/template", $data);
	}
	
	public function hubungi_kami(){
		$data['template'] = "hubungi_kami";
		$captcha = $this->m_captcha->GenerateCaptcha();
		$data['captcha'] = $captcha;
		$this->session->set_userdata('captcha_session', $captcha['word']);
		$this->load->view("client/template", $data);
	}
	
	public function error_404(){
		$data['template'] = "error_404";
		$this->load->view("client/template", $data);
	}
	
	function confirmation_email($key_user){		
		
		$this->db->set('confirmation_email', 1);
		$this->db->where("key", $key_user);
		$this->db->update('tbl_admin');
		$this->session->set_flashdata('success', "Email anda sudah terkonfirmasi. Anda bisa segera login dan menikmati fitur-fitur dari 14Hobby.com");
		redirect("login");
	}
	
	function coba2(){
		$this->load->model("m_item");
		$data = $this->m_item->get_same_series_tipe("Figuart Zero One Piece");
		if(count($data)> 0)
			foreach($data as $row)
				echo create_title($row->name_barang)."<br/>";
		
	}
	
	function send_email_to_us(){
		$this->load->helper('email');
		$title = $this->input->post("title");
		$from = $this->input->post("from");
		$email = $this->input->post("email");
		$message = $this->input->post("message");
		$warning = "";
		if(empty($from))
			$warning = "Mohon isi dahulu nama pengirim email";
		elseif(empty($email))
			$warning = "Mohon isi dahulu alamat email";
		elseif(!valid_email($email))
			$warning = "Mohon isi alamat email anda yang benar";
		elseif(empty($title))
			$warning = "Mohon isi judul email anda";
		elseif(empty($message))
			$warning = "Mohon isi dahulu pesan yang akan anda kirim kepada kami";
		
		if(!empty($warning)){
			$this->session->set_flashdata('warning', $warning);
			$this->session->set_flashdata("data",array("title"=>$title, "from"=>$from, "email"=>$email, "message"=>$message));
			redirect("hubungi-kami");
		}
		if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
			$this->load->model("m_email");
			$this->m_email->send_email_to_us($title, $from, $email, $message);
			redirect("hubungi-kami");
		}else{
			$this->session->set_flashdata('warning', "Maaf kode verifikasi anda tidak sama pada gambar. Mohon isi sesuai isi gambar");
			$this->session->set_flashdata("data",array("title"=>$title, "from"=>$from, "email"=>$email, "message"=>$message));
			redirect("hubungi-kami");
		}		
	}
}

