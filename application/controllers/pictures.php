<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pictures extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index($path){
		$data['template'] = "pictures_index";
		$data['path'] = $path;
		$this->db->join("tbl_barang b", "a.id_barang = b.id");
		$this->db->where("link_gambar", $path);
		$datax = $this->db->get("tbl_gambar_barang a");
		$data["dafkomen"] = $datax->result();
		
		$this->db->where_not_in("link_gambar", array($path));
		$this->db->where("flag", 1);
		$this->db->where("id_barang", $data["dafkomen"][0]->id);
		$datax = $this->db->get("tbl_gambar_barang");
		$data["gambar_lain"] = $datax->result();
		$this->load->view("client/template", $data);
	}
}