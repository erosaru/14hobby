<?php
	class Roomuser extends CI_Controller{
		public function __construct(){
			parent::__construct();
			
			if($this->session->userdata('login') == false)
				redirect('login');
		}
		//all about user data
		function index(){
			$data['template'] = "roomuser_index";
			$data['content'] = "roomuser_market_profile";
			$this->db->where('id', $this->session->userdata('id'));
			$this->db->from('tbl_market_user');
			$query = $this->db->get();
			$data['data'] = $query->result();		
			$this->load->view('client/template',$data);
		}
		
		function change_password(){
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "roomuser_edit_password";
			$this->load->view('client/template',$this->data);
		}
		
		function process_change_password(){
			$new_password = $this->input->post('new_password');
			$confirm_new_password = $this->input->post('confirm_new_password');
			$old_password = $this->input->post('old_password');
			if(!empty($new_password) || !empty($confirm_new_password)){
				if($new_password == $confirm_new_password){
					$this->db->where("id", $this->session->userdata('id'));
					$result = $this->db->get("tbl_market_user");
					$result = $result->result();
					$old_password = do_hash($old_password, 'md5');
					if($old_password == $result[0]->pass){
						$this->data = array(
							'pass' => do_hash($new_password, 'md5')
						);
						$this->db->where('id', $this->session->userdata('id'));
						$this->db->update('tbl_market_user',$this->data);
						$this->session->set_flashdata('success', 'Password anda sudah berubah');
						redirect("profile");
					}else{
						$this->session->set_flashdata('warning', 'Apabila anda ingin mengganti password anda harap isi password lama anda dahulu');
						redirect("change_password");
					}
				}else{
					$this->session->set_flashdata('warning', 'Mohon masukkan confirm password anda sama dengan password baru anda yang akan anda ganti');
					redirect("change_password");
				}
			}else{
				$this->session->set_flashdata('warning', 'Password baru anda tidak boleh kosong');
				redirect("change_password");
			}			
		}
		
		function change_profile(){
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "roomuser_profile_edit";
			$this->db->where("id",$this->session->userdata('id'));
			$result = $this->db->get("tbl_market_user");
			$this->data['data'] = $result->result_array();
			$this->data['data'] = $this->data['data'][0];		
			$this->load->view('client/template',$this->data);
		}
		
		function process_change_profile(){
			$this->load->model("m_roomuser");
			if($this->session->userdata('role_id') == 2){				
				$this->db->where("name_merchant",$this->input->post('name_merchant'));
				$this->db->where("id <>",$this->session->userdata('id'));
				$name_merchant = $this->db->get("tbl_market_user");
				if($name_merchant->num_rows() > 0){
					$this->session->set_flashdata('warning', 'Nama merchant sudah ada yang menggunakan, gunakan nama merchant lainnya');
					redirect('change_profile');
				}					
				
				if($this->m_roomuser->upload_picture_profile()){					
					$this->data = array(
						'name_merchant' => $this->input->post('name_merchant') ? $this->input->post('name_merchant') : null,
						'foto' => $this->m_roomuser->get_name_photo_profile(),
						'deskripsi' => $this->input->post('deskripsi')
					);	
					$this->db->where("id",$this->session->userdata('id'));
					$this->db->update("tbl_market_user", $this->data);
					$this->session->set_flashdata('success', "Keterangan tentang toko anda sudah dirubah");
					redirect("profile");
				}else
					redirect('change_profile');
			}elseif($this->session->userdata('role_id') == 3){
				if($this->m_roomuser->upload_picture_profile()){				
					$this->data = array(
						'foto' => $this->m_roomuser->get_name_photo_profile(),
						//'deskripsi' => $this->input->post('deskripsi')
					);	
					$this->db->where("id",$this->session->userdata('id'));
					$this->db->update("tbl_market_user", $this->data);
					$this->session->set_flashdata('success', "Foto profile sudah di update");
					redirect("profile");
				}else
					redirect('change_profile');
			}			
		}
		
		function account_bank_form(){
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "roomuser_market_user_bank";
			$this->db->select('tbl_market_user_bank.*, tbl_bank.bank_name');
			$this->db->where('tbl_market_user_bank.user_id', $this->session->userdata('id'));
			$this->db->join('tbl_bank', 'tbl_market_user_bank.bank_id = tbl_bank.id');
			$query = $this->db->get('tbl_market_user_bank');
			$this->data['rekening'] = $query->result();		
			
			$bank = $this->db->get('tbl_bank');
			foreach($bank->result() as $row)
				$this->data['bank'][] = array($row->id => $row->bank_name);
			$this->load->view('client/template',$this->data);
		}
		
		function new_account_bank(){
			$this->data = array(
				'bank_id' => $this->input->post('bank_id'),
				'user_id' => $this->session->userdata("id"),
				'bank_account' => $this->input->post('bank_account'),
				'bank_account_number' => $this->input->post('bank_account_number')
			);
			
			$this->db->insert('tbl_market_user_bank', $this->data);
			$this->session->set_flashdata('success', "Anda berhasil memasukan no rekening bank baru");
			redirect("profile");
		}
		
		function delete_no_rekening($id){
			$this->db->where("id", $id);			
			$this->db->delete('tbl_market_user_bank');
			$this->session->set_flashdata('success', "No rekening anda sudah berhasil dihapus");
			redirect("profile");
		}
		/*
		function update_room_user(){
			$x = array(
						'deskripsi' => $this->input->post('deskripsi')
					);
			$this->db->where('id', $this->session->userdata('id'));
			$hasil =  $this->db->update('tbl_admin',$x);
			if($hasil)
				$success = "Save Deskripsi berhasil<br/>";
			$this->db->where('id', $this->session->userdata('id'));
			$this->db->from('tbl_admin');
			$query = $this->db->get();
			$data = $query->result();		
			if($this->input->post('passlama')){
				if(do_hash($this->input->post('passlama'), 'md5') == $data[0]->pass){
					$data = array(
						'pass' => do_hash($this->input->post('passbaru'), 'md5')
					);					
					$this->db->where('id', $this->session->userdata('id'));
					$hasil =  $this->db->update('tbl_admin',$data);
					$success .= "Password anda sudah diganti dengan password baru<br/>";
					$this->session->set_flashdata('success', $success);
					redirect('roomuser');
				}else{
					$this->session->set_flashdata('success', $success);
					$this->session->set_flashdata('warning', 'Anda salah memasukan password lama mohon isi dengan password lama yang benar untuk mengganti password anda');
					redirect('roomuser');
				}			
			}else{
				$this->session->set_flashdata('success', $success);
				redirect('roomuser');
			}
		}
		*/
		/*all about order*/
		function order_list(){
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "roomuser_market_order_list";
			if($this->session->userdata("role_id") == 2)
				$this->db->where("merchant_id", $this->session->userdata("id"));
			elseif($this->session->userdata("role_id") == 3)
				$this->db->where("buyer_id", $this->session->userdata("id"));
			$status = $this->input->get("status");
			if(empty($status))
				$this->db->where("status <> 'SUCCESS'");
			else{
				$this->db->order_by("tbl_market_order.id", "desc");
			}
			$this->db->join("tbl_market_user", "tbl_market_order.merchant_id = tbl_market_user.id");
			$result = $this->db->get("tbl_market_order");
			$this->data['dafkomen'] = $result->result();
			$this->load->view('client/template',$this->data);
		}	
		
		function order_form(){
			if($this->session->userdata('role_id') != 3)
				redirect('list-order');
			$this->load->model("m_captcha");			
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "roomuser_market_order_form";
			$captcha = $this->m_captcha->GenerateCaptcha();
			$this->data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);			
			$this->db->where('id', $this->session->userdata('id'));
			$user = $this->db->get('tbl_market_user');
			$this->data['user'] = $user->result();
			$this->load->view('client/template',$this->data);
		}
		
		function save_comment_order(){
			$datetime = date('Y-m-d H:i');
			$data = array(
				'create_date' => $datetime,
				'order_id' => "",
				'comment' => $this->input->post("comment")
			);
		}
		
		function save_order(){
			if($this->session->userdata('role_id') != 3)
				redirect('list-order');
			$datetime = date('Y-m-d H:i');
			$note = $this->input->post("note");
			//$shipmet_by = $this->input->post("shipment_by");
			$this->data = array(
				"send_to" => $this->input->post("send_to"),
				"address_destination" => $this->input->post("address_destination"),
				"phone" => $this->input->post("phone"),
				"buyer_id" => $this->session->userdata("id"),
				"created_date" => $datetime,
				"shipping_to" => $this->input->post("shipping_to")
			);
			
			$warning = "";
			if(empty($this->data['send_to']))
				$warning = "Mohon untuk mengisi nama penerima barang";				
			else if(empty($this->data['address_destination']))
				$warning = "Mohon untuk mengisi alamat penerima barang";
			else if(empty($this->data['phone']))
				$warning = "Mohon untuk mengisi no telepon penerima barang";
			else if(empty($this->data['shipping_to']))
				$warning = "Mohon untuk mengisi kota tempat penerima barang tinggal";
			else if(count($this->session->userdata("buy_item")) == 0)
				$warning = "Mohon memilih dahulu barang yang anda akan beli";
			else{
				$buy_item = $this->session->userdata("buy_item");
				foreach($buy_item as $row){
					foreach($row['item'] as $value){						
						$this->db->select("tbl_market_item.name, tbl_market_item.stock, tbl_market_user.name_merchant, tbl_market_user.first_name, tbl_market_user.last_name");
						$this->db->where("tbl_market_item.id", $value['id']);
						$this->db->join('tbl_market_user', "tbl_market_user.id = tbl_market_item.merchant_id");
						$result = $this->db->get("tbl_market_item");
						$result = $result->result();
						$name_merchant = !empty($result[0]->name_merchant) ? $result[0]->name_merchant : trim($result[0]->first_name.' '.$result[0]->last_name);
						if($result[0]->stock <= 0){
							unset($buy_item[$name_merchant]["item"][$value['id']]);
							$warning .= "Item ".$result[0]->name." habis terjual. kami akan menghapus order barang ini<br/>";
						}elseif($value['qty'] > $result[0]->stock){
							$buy_item[$name_merchant]["item"][$value['id']]["qty"] = $result[0]->stock;
							$warning .= "Barang yang tersisa untuk barang ".$result[0]->name.' adalah '.$result[0]->stock." pcs. Jadi kami menset jumlah sebanyak barang yang tersisa <br/>";							
						}
						if(count($buy_item[$name_merchant]["item"][$value['id']]) == 0)
							unset($buy_item[$name_merchant]["item"][$value['id']]);
					}
					if(count($buy_item[$name_merchant]["item"]) == 0)
						unset($buy_item[$name_merchant]);
				}
				if(!empty($warning))
					$this->session->set_userdata('buy_item', $buy_item);
			}
			
			if(!empty($warning)){
				$this->session->set_flashdata('warning', $warning);
				$this->data['note'] = $note;
				//$this->data['shipment_by'] = $shipmet_by;
				$this->session->set_flashdata("data",$this->data);
				redirect("order-form");
			}			
			
			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
				foreach($this->session->userdata("buy_item") as $row){
					$today = date('Y-m-d');
					$this->db->where("date(created_date) = '$today'");
					$result = $this->db->get("tbl_market_order");
					$jumlah = $result->num_rows();
					$jumlah++;
					$invoice = date('Ymd').$this->session->userdata("id").sprintf("%08s", $jumlah);					
					$this->data['invoice'] = $invoice;
					$this->data['merchant_id'] = $row['id_merchant'];
					$this->data['note'] = $note[create_title($row['name_merchant'])];
					$this->data['shipment_by'] = $shipment_by[create_title($row['name_merchant'])];
					$this->db->insert("tbl_market_order", $this->data);
					$id_order = $this->db->insert_id();
					foreach($row['item'] as $value){
						$this->db->where("id", $value['id']);
						$result = $this->db->get("tbl_market_item");
						$result = $result->result();
						$diffence = $result[0]->stock - $value['qty'];
						$this->db->set("stock", $diffence);
						$this->db->where("id", $value['id']);
						$this->db->update("tbl_market_item");
						$this->data_detail = array(
							"item_id" => $value['id'],
							"qty" => $value['qty'],
							"name" => $value['name'],
							"price" => $value['price'],
							"order_id" => $id_order
						);
						$this->db->insert("tbl_market_order_detail", $this->data_detail);
					}
				}
				$this->session->set_userdata('buy_item', array());
				$this->session->set_flashdata('success', 'Order anda sudah dikirim, mohon untuk menunggu jumlah tagihan yang harus anda bayar');
				redirect("list-order");
			}else{
				$this->session->set_flashdata('warning', 'Kode yang anda masukan tidak sama dengan gambar');
				$this->data['note'] = $note;
				//$this->data['shipment_by'] = $shipmet_by;
				$this->session->set_flashdata("data",$this->data);
				redirect("order-form");
			}
		}
		
		function view_order($invoice){
			$this->load->model("m_captcha");			
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "roomuser_market_order_view";
			$this->db->join("tbl_market_user b", "b.id = a.merchant_id");
			$this->db->join("tbl_market_user c", "c.id = a.buyer_id");
			$this->db->select("a.*, b.name_merchant, b.first_name merchant_first_name, b.last_name merchant_last_name, c.first_name buyer_first_name, c.last_name buyer_last_name");
			$this->db->where("invoice", $invoice);
			$result = $this->db->get("tbl_market_order a");
			$result = $result->result();
			
			if($this->session->userdata("role_id") == 2){
				if($this->session->userdata("id") != $result[0]->merchant_id)
					redirect("list-order");
			}elseif($this->session->userdata("role_id") == 3){
				if($this->session->userdata("id") != $result[0]->buyer_id)
					redirect("list-order");
			}
			
			$captcha = $this->m_captcha->GenerateCaptcha();
			$this->data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);
			$this->data["dafkomen"] = $result;
			
			$this->db->where("order_id", $result[0]->id);
			$result = $this->db->get("tbl_market_order_detail");
			$result = $result->result();
			$this->data["dafkomen_detail"] = $result;
			
			$this->load->view('client/template',$this->data);
		}
		
		function delete_one_item(){
			$buy_item = $this->session->userdata("buy_item");
			$id_barang = $this->input->get("id_barang");
			$information = $this->input->get("information");
			$name_barang = $buy_item[$id_barang]['name_barang'];
			unset($buy_item[$id_barang]["detail"][$information]);
			if(count($buy_item[$id_barang]["detail"])==0)
				unset($buy_item[$id_barang]);
			$this->session->set_userdata('buy_item', $buy_item);
			$this->session->set_flashdata('success', "Item $name_barang - $information sudah dihapus dari keranjang belanja anda");		
			redirect("order-form");
		}
		
		function clear_order(){
			$this->session->set_userdata('buy_item', array());
			redirect("order-form");
		}
		
		function add_to_cart(){
			if($this->session->userdata('role_id') != 3)
				redirect('dashboard');
			$information = $this->input->post("information");
			$this->data = $this->session->userdata("buy_item");			
			$this->db->select("tbl_market_item.*, tbl_market_user.name_merchant, tbl_market_user.id id_merchant, tbl_market_user.first_name, tbl_market_user.last_name, tbl_market_kategori.name_kategori");
			$this->db->where("tbl_market_item.id", $this->input->post("id"));
			$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
			$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_item.merchant_id");
			$result = $this->db->get("tbl_market_item");	
			if($result->num_rows() > 0){				
				$result = $result->result();
				$name_merchant = !empty($result[0]->name_merchant) ? $result[0]->name_merchant : trim($result[0]->first_name.' '.$result[0]->last_name);
				$qty = intval($this->input->post("qty"));
				if($qty == 0){
					$this->session->set_flashdata('warning', 'Mohon masukkan angka untuk jumlah barang yang ingin anda beli.');
					redirect("detail-merchant/".(!empty($result[0]->name_merchant) ? create_title($result[0]->name_merchant) : create_title(trim($result[0]->first_name.' '.$result[0]->last_name)))."/detail-item/".$result[0]->id."/".create_title($result[0]->name));
				}
					
				if($this->input->post("qty") > $result[0]->stock){
					$this->session->set_flashdata('warning', 'Seller ini hanya memiliki barang ini sebanyak '.$result[0]->stock.' pcs untuk barang '.$result[0]->name);
					redirect("detail-merchant/".(!empty($result[0]->name_merchant) ? create_title($result[0]->name_merchant) : create_title(trim($result[0]->first_name.' '.$result[0]->last_name)))."/detail-item/".$result[0]->id."/".create_title($result[0]->name));
				}
				
				if(!isset($this->data[$name_merchant]))
					$this->data[$name_merchant] = array("name_merchant" => $name_merchant, "id_merchant" => $result[0]->id_merchant,"item" => array($result[0]->id => array("name" => $result[0]->name, "id" => $result[0]->id, "qty" => $this->input->post("qty"), "price" => $result[0]->price)));
				else
					$this->data[$name_merchant]['item'][$result[0]->id] = array("name" => $result[0]->name, "id" => $result[0]->id, "qty" => $this->input->post("qty"), "price" => $result[0]->price);
				$this->session->set_userdata('buy_item', $this->data);
				$this->session->set_flashdata('success', 'item yang anda pilih sudah masuk keranjang belanja jika anda sudah selesai memilih barang  dan akan mengirim order anda bisa click <a href="'.base_url().'order-form">formulir order</a>');
				redirect("detail-merchant/".(!empty($result[0]->name_merchant) ? create_title($result[0]->name_merchant) : create_title(trim($result[0]->first_name.' '.$result[0]->last_name))));
				//print_r($this->data);
			}else
				redirect("detail-merchant/".(!empty($result[0]->name_merchant) ? create_title($result[0]->name_merchant) : create_title(trim($result[0]->first_name.' '.$result[0]->last_name)))."/detail-item/".$result[0]->id."/".create_title($result[0]->name));
		}
		
		function invoice_form($invoice){
			if($this->session->userdata('role_id') != 2)
				redirect('dashboard');			
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "roomuser_market_invoice_form";
			$this->db->select("tbl_market_order.*, tbl_market_user.city");
			$this->db->where("invoice", $invoice);
			$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_order.merchant_id");
			$result = $this->db->get("tbl_market_order");
			if($result->num_rows() > 0){
				$result = $result->result();
				if($result[0]->merchant_id != $this->session->userdata("id"))
					redirect("list-order");
				$this->data['dafkomen'] = $result;
				$this->db->where("order_id", $result[0]->id);
				$result = $this->db->get("tbl_market_order_detail");
				$this->data['dafkomen_detail'] = $result->result();
				$this->load->view("client/template",$this->data);
			}else
				redirect("dashboard");
		}
		
		function invoice_calculate(){
			if($this->session->userdata('role_id') != 2)
				redirect('dashboard');				
			$qty = $this->input->post("qty");
			$price = $this->input->post("price");
			$shipment_by = $this->input->post("shipment_by");
			$invoice = $this->input->post("invoice");
			$this->db->select("tbl_market_order.*, tbl_market_user.city");
			$this->db->where("invoice", $invoice);
			$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_order.merchant_id");
			$result = $this->db->get("tbl_market_order");
			if($result->num_rows() > 0){
				$order = $result->result();
				if($order[0]->merchant_id != $this->session->userdata("id"))
					redirect("list-order");
				//process order detail
				$this->db->where("order_id", $order[0]->id);
				$result = $this->db->get("tbl_market_order_detail");
				$order_detail = $result->result();
				$total_sub_total = 0;
				$total_qty = 0;
				foreach($order_detail as $row){
					$sub_total = doubleval($qty[$row->id]) * doubleval($price[$row->id]);
					$total_sub_total += $sub_total;
					$total_qty += $qty[$row->id];
					$this->data = array(
						"qty_actual" => $qty[$row->id],
						"price_actual" => $price[$row->id],
						"sub_total" => $sub_total
					);
					$this->db->where("id", $row->id);
					$this->db->update("tbl_market_order_detail", $this->data);
				}
				//process order
				$discount_percent = $this->input->post("discount_percent");
				$shipping_cost = $this->input->post("shipping_cost");
				$discount = $total_sub_total * ($discount_percent / 100);
				$total_after_discount = $total_sub_total - $discount;
				$total = $total_after_discount + $shipping_cost;
				$this->data = array(
						"total_qty" => $total_qty,
						"total_sub_total" => $total_sub_total,
						"discount_percent" => $discount_percent,
						"discount" => $discount,
						"total_after_discount" => $total_after_discount,
						"shipping_cost" => $shipping_cost,
						"total" => $total,
						"shipping_from" => $order[0]->city,
						"shipment_by" => $shipment_by
					);
				$this->db->where("invoice", $invoice);
				$this->db->update("tbl_market_order", $this->data);
				
				$this->data['template'] = "roomuser_index";
				$this->data['content'] = "roomuser_market_invoice_view";
				
				$this->db->select("tbl_market_order.*, tbl_market_user.name_merchant, tbl_market_user.first_name, tbl_market_user.last_name");
				$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_order.merchant_id");
				$this->db->where("invoice", $invoice);
				$result = $this->db->get("tbl_market_order");
				$order = $result->result();
				
				$this->db->where("order_id", $order[0]->id);
				$result = $this->db->get("tbl_market_order_detail");
				$order_detail = $result->result();				
				
				$this->data['dafkomen'] = $order;
				$this->data['dafkomen_detail'] = $order_detail;
				$this->load->view("client/template",$this->data);
			}else
				redirect("dashboard");
		}
		
		function invoice_submit(){
			if($this->session->userdata('role_id') != 2)
				redirect('dashboard');				
			$invoice = $this->input->post("invoice");			
			
			$this->db->where("invoice", $invoice);
			$result = $this->db->get("tbl_market_order");
			if($result->num_rows() > 0){
				$order = $result->result();
				if(empty($order[0]->invoice_create_date) && ($order[0]->status == "WAITING INVOICE") && ($order[0]->merchant_id == $this->session->userdata("id"))){
					$datetime = date('Y-m-d H:i');
					$this->data = array(
						"invoice_create_date" => $datetime,
						"status" => "WAITING PAYMENT",
					);
					$this->db->where("invoice", $invoice);
					$this->db->update("tbl_market_order", $this->data);
					$this->session->set_flashdata('success', "Tagihan untuk order ORD$invoice untuk customer anda sudah dibuat mohon untuk menunggu konfirmasi pembayaran dari buyer anda");
					redirect("list-order");
				}else
					redirect("list-order");
			}else
				redirect("dashboard");
		}
		
		function invoice_view($invoice){	
			$this->db->where("invoice", $invoice);
			$this->db->select("tbl_market_order.*, tbl_market_user.name_merchant, tbl_market_user.first_name, tbl_market_user.last_name");
			$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_order.merchant_id");
			$result = $this->db->get("tbl_market_order");
			$order = $result->result();
			if(empty($order[0]->invoice_create_date))
				redirect("list-order");
				
			if($this->session->userdata("role_id") == 2)
				if($this->session->userdata("id") != $order[0]->merchant_id)
					redirect("list-order");
			
			if($this->session->userdata("role_id") == 3){
				if($this->session->userdata("id") != $order[0]->buyer_id)
					redirect("list-order");
				$this->db->join("tbl_bank", "tbl_bank.id = tbl_market_user_bank.bank_id");
				$this->db->where("user_id", $order[0]->merchant_id);
				$seller_bank = $this->db->get("tbl_market_user_bank");
				if($seller_bank->num_rows > 0){
					foreach($seller_bank->result() as $row)
						$this->data['seller_bank'][] = array($row->bank_name." - ".$row->bank_account_number." - ".$row->bank_account => $row->bank_name." - ".$row->bank_account_number." - ".$row->bank_account);
				}
				$this->db->join("tbl_bank", "tbl_bank.id = tbl_market_user_bank.bank_id");
				$this->db->where("user_id", $order[0]->buyer_id);
				$buyer_bank = $this->db->get("tbl_market_user_bank");
                
				if($buyer_bank->num_rows > 0){
					foreach($buyer_bank->result() as $row)
						$this->data['buyer_bank'][] = array($row->bank_name." - ".$row->bank_account_number." - ".$row->bank_account => $row->bank_name." - ".$row->bank_account_number." - ".$row->bank_account);
				}
                $this->data['buyer_bank'][] = array("CDM" => "CDM");
			}
			$this->db->where("order_id", $order[0]->id);
			$result = $this->db->get("tbl_market_order_detail");
			$order_detail = $result->result();				
			
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "roomuser_market_invoice_view";
			$this->data['dafkomen'] = $order;
			$this->data['dafkomen_detail'] = $order_detail;
			$this->load->view("client/template",$this->data);
		}
		
		/*payment report*/
		function payment_list(){
			if($this->session->userdata("role_id") != 1)
				redirect('dashboard');
			if($this->session->userdata("role_id") == 1)
				$this->db->where("status != 'HAS CHECKED'");
			$this->db->order_by("create_date");
			$result = $this->db->get("tbl_report_payment");
			foreach($result->result() as $row){
				$link = array();
				$this->db->where("report_payment_id", $row->id);
				$result_detail = $this->db->get("tbl_report_payment_detail");
				foreach($result_detail->result() as $row_detail){
					$this->db->where("invoice", $row_detail->invoice);
					$x = $this->db->get("tbl_order");
					$x = $x->result();
					$link[] = "<li><a target='_blank' href='".base_url()."view-invoice/".$x[0]->invoice."'>INV".$x[0]->invoice."</a></li>";
				}
				$data["dafkomen"][] = array("id" => $row->id, "transfer_to" => $row->our_bank_account_number,"create_date" => $row->create_date, "status" => $row->status, "total_transfer" => $row->total_transfer, "xtotal_invoice" => $row->xtotal_invoice, "invoice" => "<ul>".implode("", $link)."</ul>");
			}
			$data['template'] = "roomuser_index";
			$data['content'] = "roomuser_payment_list";
			$this->load->view('client/template',$data);
		}
		
		function payment_view($id){
			if($this->session->userdata('role_id') != 1)
				redirect('dashboard');
			$this->db->select("tbl_report_payment.*, tbl_admin.nama_lengkap");
			$this->db->join("tbl_admin", "tbl_admin.id = tbl_report_payment.customer_id");
			$this->db->where("tbl_report_payment.id", $id);
			$result = $this->db->get("tbl_report_payment");
			$data["dafkomen"] = $result->result();
			
			if($data["dafkomen"][0]->status == "HAS CHECKED")
				redirect('list-payment');
				
			$data["invoice_list"] = array();
			foreach($result->result() as $row){
				$this->db->where("report_payment_id", $row->id);
				$result_detail = $this->db->get("tbl_report_payment_detail");
				foreach($result_detail->result() as $row_detail){
					$this->db->where("invoice", $row_detail->invoice);
					$x = $this->db->get("tbl_order");
					$x = $x->result();
					$data["invoice_list"][] = $x[0];
				}
			}
			$data['template'] = "roomuser_index";
			$data['content'] = "roomuser_payment_view";
			$this->load->view('client/template',$data);
		}
		
		
		function create_payment_report(){
			if($this->session->userdata('role_id') != 2)
				redirect('dashboard');
			$this->db->select("tbl_order.*");
			$this->db->where("customer_id", $this->session->userdata("id"));
			$this->db->where("invoice_create_date is not null");
			$this->db->where("tbl_report_payment_detail.invoice is null");
			$this->db->where("tbl_order.status", "WAITING PAYMENT");
			$this->db->join("tbl_report_payment_detail", "tbl_report_payment_detail.invoice = tbl_order.invoice","left");
			$this->db->order_by("invoice_create_date");
			$result = $this->db->get("tbl_order");
			$data["invoice_list"] = $result->result();
			$data['template'] = "roomuser_index";
			$data['content'] = "roomuser_payment_form";
			$this->load->model("m_captcha");	
			$captcha = $this->m_captcha->GenerateCaptcha();
			$data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);
			$this->load->view('client/template',$data);
		}
		
		function save_payment_report(){
			if($this->session->userdata('role_id') != 2)
				redirect('dashboard');
			
			$data = array(
				"our_bank_account_number" => $this->input->post("our_bank_account_number"),
				"date_tranfer" => $this->input->post("date_tranfer"),
				"customer_bank_account_name" => $this->input->post("customer_bank_account_name"),
				"customer_bank_account_number" => $this->input->post("customer_bank_account_number"),
				"total_transfer" => $this->input->post("total_transfer"),
				"xtotal_invoice" => $this->input->post("xtotal_invoice"),
				"invoice" => $this->input->post("invoice")
			);
			$warning = "";
			if(empty($data['date_tranfer']))
				$warning = "Tolong isi tanggal transfer anda";
			elseif(empty($data['customer_bank_account_name']))
				$warning = "Tolong isi atas nama direkening";
			elseif(empty($data['customer_bank_account_number']))
				$warning = "Tolong isi no rekening anda";
			elseif(empty($data['total_transfer']))
				$warning = "Tolong isi jumlah uang yang anda transfer ke rekening kami";
			elseif(empty($data['invoice']))
				$warning = "Tolong pilih invoice-invoice yang akan anda bayar";
			elseif($data['total_transfer'] < $data['xtotal_invoice'])
				$warning = "Jumlah uang yang anda transfer tidak mencukupi untuk membayar invoice-invoice yang anda pilih";
				
				
			if(!empty($warning)){
				$this->session->set_flashdata('warning', $warning);
				$this->session->set_flashdata("data",$data);
				redirect("report-your-payment");
			}
			if(strtolower($this->session->userdata('captcha_session')) == strtolower($this->input->post('kode'))){
				$invoice_detail = $this->input->post("invoice");
				$data = array(
					"our_bank_account_number" => $this->input->post("our_bank_account_number"),
					"date_tranfer" => $this->input->post("date_tranfer"),
					"customer_bank_account_name" => $this->input->post("customer_bank_account_name"),
					"customer_bank_account_number" => $this->input->post("customer_bank_account_number"),
					"total_transfer" => $this->input->post("total_transfer"),
					"xtotal_invoice" => $this->input->post("xtotal_invoice"),
					"customer_id" => $this->session->userdata("id"),
					"create_date" => date("Y-m-d H:i"),
					"status" => "WAIT FOR CHECK"
				);
				$data["date_tranfer"] = save_tanggal($data["date_tranfer"]);
				$this->db->insert("tbl_report_payment", $data);
				$report_payment_id = $this->db->insert_id();
				foreach($invoice_detail as $row){
					$this->db->where("invoice", $row);
					$result = $this->db->get("tbl_order");
					if($result->num_rows() == 1){
						$data_detail = array(
							"report_payment_id" => $report_payment_id,
							"invoice" => $row
						);
						$this->db->insert("tbl_report_payment_detail", $data_detail);
						
						$this->db->set('transfer_to', $this->input->post("our_bank_account_number"));
						$this->db->set('status', "WAITING CHECK PAYMENT");
						$this->db->where("invoice", $row);
						$this->db->update("tbl_order");
					}
				}
				$this->session->set_flashdata('success', 'Laporan pembayaran yang anda kirim sudah diterima kami, mohon untuk menunggu untuk kami periksa apabila uang sudah kami terima akan langsung kami kirim barang nya. Terima Kasih');
				redirect("order-list");
			}else{
				$this->session->set_flashdata('warning', 'Kode konfirmasi salah, harap isi sesuai dengan yang ada digambar');
				$this->session->set_flashdata("data",$data);
				redirect("report-your-payment");
			}
		}
		
		function confirm_report_payment(){
			if($this->session->userdata('role_id') != 1)
				redirect('');	
			
			$id = $this->input->post("id");
			
			$this->db->where("id", $id);
			$result = $this->db->get("tbl_report_payment");
			$result = $result->result();
			if($result[0]->status == "HAS CHECKED")
				redirect('payment-list');
			
			$data = array(
				"status" => "HAS CHECKED",
				"checked_date" => date("Y-m-d")
			);
			$this->db->where("id", $id);
			$this->db->update("tbl_report_payment", $data);
			
			$this->db->where("report_payment_id", $id);
			$result = $this->db->get("tbl_report_payment_detail");
			$result = $result->result();
			foreach($result as $row){
				$this->db->set("status", "PROCCESS SHIPMENT");
				$this->db->where("status", "WAITING CHECK PAYMENT");
				$this->db->where("invoice", $row->invoice);
				$this->db->update("tbl_order");
			}
			
			$this->session->set_flashdata('success', 'Semua invoice dalam report payment ini sudah diganti status menjadi PROCCESS SHIPMENT');
			redirect("payment-list");
		}
		
		/*all about shipment*/
		function save_shipment(){
			if($this->session->userdata('role_id') != 2)
				redirect('dashboard');
			$invoice = $this->input->post("invoice");			
			$number_shipment = $this->input->post("number_shipment");
			$warning = "";
			if(empty($number_shipment))
				$warning = "Please fill number shipment first";
			
			if(!empty($warning)){
				$this->session->set_flashdata('warning', $warning);
				$this->session->set_flashdata("data",$data);
				redirect("view-invoice/$invoice");
			}
			
			$this->db->where("invoice", $invoice);
			$this->db->where("number_shipment is null");
			$result = $this->db->get("tbl_market_order");
			$x = $result->result();
			if($result->num_rows == 1 && $x[0]->merchant_id == $this->session->userdata("id")){				
				$this->db->set("number_shipment", $number_shipment);
				$this->db->set("shipment_date", date("Y-m-d H:i"));
				$this->db->where("invoice", $invoice);
				$this->db->update("tbl_market_order");
				$this->session->set_flashdata('success', "Resi pengiriman untuk order ini sudah tersimpan");
				redirect("view-invoice/$invoice");
			}else{
				redirect("dashboard");
			}
		}
		
		function get_item(){	
			if($this->session->userdata('role_id') != 3)
				redirect('dashboard');
			
			$invoice = $this->input->post("invoice");
			$this->db->where("invoice", $invoice);
			$result = $this->db->get("tbl_market_order");
			if($result->num_rows() == 1){
				$result = $result->result();
				if($result[0]->buyer_id == $this->session->userdata('id')/* && $result[0]->status == "PROCCESS SHIPMENT"*/){
					$this->db->set("status", "SUCCESS");
					$this->db->where("invoice", $invoice);
					$this->db->update("tbl_market_order");
					$this->session->set_flashdata('success', "Kami sudah menerima laporan barang yang anda order sudah diterima. Terima Kasih sudah membeli barang di salah satu seller 14Hobby. Kami menunggu anda berkunjung kembali ke 14Hobby");
					redirect("order-list");
				}else
					redirect("dashboard");
			}else
				redirect("dashboard");			
		}
		
		//fungsi untuk administator
		public function item_need_approve(){
			if(!in_array($this->session->userdata('role_id'), array(0,1)))
				redirect('login');
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "item_itemneedapprove";
			
			$this->db->select("tbl_market_item.*, tbl_market_kategori.name_kategori");
			$this->db->where("active = 0");
			$this->db->where("delete is null");
			$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
			$result = $this->db->get("tbl_market_item");
			$this->data['dafkomen'] = $result->result();		
			$this->load->view("client/template", $this->data);
		}
		
		//fungsi untuk seller
		function item_list(){
			if($this->session->userdata("role_id") != 2)
				redirect("dashboard");
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "roomuser_item_list";
			$this->db->select('tbl_market_kategori.name_kategori, tbl_market_item.*');
			$this->db->where("delete is null")->where("merchant_id", $this->session->userdata("id"))->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
			$this->db->order_by("tbl_market_item.id", "desc");			
			$result = $this->db->get("tbl_market_item");
			$detail_dafkomen = array();
			if($result->num_rows()>0){				
				foreach($result->result() as $row){					
					$parent = new stdClass;
					$parent->active = $row->active;
					$parent->name = $row->name;
					$parent->name_kategori = $row->name_kategori;
					$parent->price = $row->price;
					$parent->stock = $row->stock;
					$parent->id = $row->id;
					/*
					$this->db->select("min(price) as min_price, max(price) as max_price, sum(stock) as stock");
					$this->db->where("barcode", $row->barcode);
					$dresult = $this->db->get("tbl_item_detail");
					$dresult = $dresult->result();
					$parent->min_price = $dresult[0]->min_price;
					$parent->max_price = $dresult[0]->max_price;
					$parent->stock = $dresult[0]->stock;
					*/
					$detail_dafkomen[] = $parent;
				}				
			}
			$this->data['dafkomen'] = $detail_dafkomen;
			$this->load->view('client/template',$this->data);
		}
		
		function edit_item_form($id){
			if($this->session->userdata('role_id') != 2)
				redirect('dashboard');	
			$this->data['template'] = "roomuser_index";
			
			$kategori = $this->db->get('tbl_market_kategori');
			$this->data['kategori'] = array();
			if($kategori->num_rows() > 0){
				foreach($kategori->result() as $row){
					$this->data['kategori'][] = array($row->id => $row->name_kategori);
				}
			}
			$this->db->where('id', $id);
			$item = $this->db->get('tbl_market_item');
			$this->data['dafkomen'] = $item->result();
			if(($this->data['dafkomen'][0]->merchant_id != $this->session->userdata("id")) || $this->data['dafkomen'][0]->delete == 1)
				redirect("list-item");
				
			if($this->data['dafkomen'][0]->active == 2){
				$link_ensiklopedia = $this->session->userdata("link_ensiklopedia");
				if(!empty($this->data['dafkomen'][0]->link_id) && count($link_ensiklopedia) == 0){
					$this->db->select("tbl_barang.*, tbl_gambar_barang.link_gambar, tbl_merk.name_merk");
					$this->db->where("tbl_barang.id", $this->data['dafkomen'][0]->link_id);
					$this->db->where("(set_gambar = 1 or  set_gambar IS NULL)");
					$this->db->join("tbl_gambar_barang", "tbl_gambar_barang.id_barang = tbl_barang.id", "left");
					$this->db->join("tbl_merk", "tbl_merk.id = tbl_barang.id_merk");
					$item_link = $this->db->get("tbl_barang");
					$item_link = $item_link->result();
					$item_link = array(0 => array(
							"id" => $item_link[0]->id, 
							"link_gambar" => empty($item_link[0]->link_gambar) ? "asset/image/profile.png" : "uploads/".$item_link[0]->link_gambar, 
							"name_barang" => $item_link[0]->name_barang,
							"name_merk" => $item_link[0]->name_merk
						)
					);
					$this->session->set_userdata('link_ensiklopedia', $item_link);
				}
				$this->data['content'] = "market_item_form";
			}else{
				$this->data['content'] = "roomuser_item_form_edit";
				$this->db->order_by("name_kategori");
				$kategori = $this->db->get('tbl_market_kategori');
			}
			$this->load->view('client/template',$this->data);
		}
		
		function item_form(){
			if($this->session->userdata('role_id') != 2)
				redirect('dashboard');
			$this->db->where("merchant_id", $this->session->userdata("merchant_id"));	
			$this->db->where("delete is null");
			$result = $this->db->get("tbl_market_item");
			
			if($result->num_rows() >= $this->session->userdata("max_item_create")){
				$this->session->set_flashdata('warning', 'You cannot create new item because you can only create '.$this->session->userdata("max_item_create").' item now, if you want create more than '.$this->session->userdata("max_item_create").' item please talk to administrator.');
				redirect('list-item');
			}
			$this->load->model("m_captcha");			
			$this->data['template'] = "roomuser_index";
			$this->data['content'] = "market_item_form";
			$captcha = $this->m_captcha->GenerateCaptcha();
			$this->data['captcha'] = $captcha;
			$this->session->set_userdata('captcha_session', $captcha['word']);	
			$this->db->order_by("name_kategori");
			$kategori = $this->db->get('tbl_market_kategori');
			$this->data['kategori'] = array();
			if($kategori->num_rows() > 0){
				foreach($kategori->result() as $row){
					$this->data['kategori'][] = array($row->id => $row->name_kategori);
				}
			}
			$this->load->view('client/template',$this->data);
		}
		
		public function item_show($id){
			$this->db->select('tbl_market_item.*, tbl_market_user.name_merchant, tbl_market_user.city, tbl_market_user.province, tbl_market_kategori.name_kategori, tbl_market_user.first_name, tbl_market_user.last_name');
			$this->db->where('tbl_market_item.id', $id);
			$this->db->join("tbl_market_user", "tbl_market_user.id = tbl_market_item.merchant_id");
			$this->db->join("tbl_market_kategori", "tbl_market_kategori.id = tbl_market_item.id_kategori");
			$result = $this->db->get("tbl_market_item");
			$result = $result->result();
			$this->data['dafkomen'] = $result;
			$this->data['content'] = "market_item_show";
			$this->data['template'] = "roomuser_index";
			if($this->session->userdata("role_id") == 1){
				$this->db->select("tbl_barang.*, tbl_gambar_barang.link_gambar, tbl_merk.name_merk");
				$this->db->where("tbl_barang.id", $result[0]->link_id);
				$this->db->where("(set_gambar = 1 or  set_gambar IS NULL)");
				$this->db->join("tbl_gambar_barang", "tbl_gambar_barang.id_barang = tbl_barang.id", "left");
				$this->db->join("tbl_merk", "tbl_merk.id = tbl_barang.id_merk");
				$item_link = $this->db->get("tbl_barang");
				$this->data['item_link'] = $item_link->result();
			}			
			$this->load->view('client/template',$this->data);
		}
		
		public function delete_item($id){
			$this->db->set("delete", 1);
			$this->db->where("id", $id);
			$this->db->update("tbl_market_item");
			$this->session->set_flashdata('success', 'Barang anda sudah dihapus dari list');
			redirect("list-item");
		}
		
		public function save_item(){
			if($this->session->userdata("role_id") != 2)
				redirect("dashboard");
			$link_ensiklopedia = $this->session->userdata("link_ensiklopedia");
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
				'stock' => $this->input->post('stock'),
				'link_id' => (count($link_ensiklopedia) > 0) ? $link_ensiklopedia[0]["id"] : null
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
				$this->session->set_userdata("link_ensiklopedia", $link_ensiklopedia);
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
					$this->session->set_userdata('link_ensiklopedia', array());
					redirect("list-item");
				}else{
					$this->session->set_userdata("link_ensiklopedia", $link_ensiklopedia);
					$this->db->where("id", $id_item);
					$this->db->delete("tbl_market_item");
					$this->session->set_flashdata("data",$this->data);
					redirect('item-form');
				}
			}else{
				$this->session->set_userdata("link_ensiklopedia", $link_ensiklopedia);
				$this->session->set_flashdata('warning', 'Kode yang anda masukkan tidak sama dengan kode pada gambar.');
				$this->session->set_flashdata("data",$this->data);
				redirect("item-form");
			}
		}
		
		function update_item($id){
			$this->load->model("m_roomuser");
			if($this->session->userdata("role_id") != 2)
				redirect("dashboard");
			$this->db->where("id", $id);
			$item = $this->db->get("tbl_market_item");
			$item = $item->result();
			if($item[0]->merchant_id != $this->session->userdata('id'))
				redirect("list-item");
			$link_ensiklopedia = $this->session->userdata("link_ensiklopedia");
			if($item[0]->active == 2){
				$this->data = array(
					'id_kategori' => $this->input->post('kategori'),
					'merk' => $this->input->post('merk'),
					'name' => $this->input->post('name'),
					'seo_barang' => $this->input->post('seo_barang'),
					'price' => $this->input->post('price'),
					'deskripsi' => $this->input->post('pesan'),				
					'stock' => $this->input->post('stock'),
					'link_id' => (!empty($link_ensiklopedia[0]['id'])) ? $link_ensiklopedia[0]["id"] : null
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
					
				if(!empty($warning)){
					$this->session->set_flashdata('warning', $warning);
					$this->session->set_flashdata("data",$this->data);
					redirect("edit-item/$id");
				}
				
				if($this->m_roomuser->upload_picture_item($id, $this->data)){
					$this->data = array(
						'id_kategori' => $this->input->post('kategori'),
						'merk' => $this->input->post('merk'),
						'name' => $this->input->post('name'),
						'seo_barang' => $this->input->post('seo_barang'),
						'price' => $this->input->post('price'),
						'deskripsi' => $this->input->post('pesan'),
						'picture' => $this->m_roomuser->get_name_photo_item($id),
						'stock' => $this->input->post('stock'),
						'active' => 0,
						'link_id' => (!empty($link_ensiklopedia[0]['id'])) ? $link_ensiklopedia[0]["id"] : null
					);
					$this->db->where("id",$id);
					$this->db->update("tbl_market_item", $this->data);
					$this->data = array(					
						'picture' => $this->m_roomuser->get_name_photo_item($id)					
					);
					$this->db->where("id",$id);
					$this->db->update("tbl_market_item", $this->data);
					$this->session->set_flashdata('success', "Perbaikan informasi barang anda sudah tersimpan, mohon untuk menunggu persetujuan admin kami agar barang anda ditampilkan");
					redirect("list-item");
				}else
					redirect("edit_item_form/$id");
			}elseif($item[0]->active == 1){
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
				redirect("show-item/$id");				
			}			
		}

		function status_payment($invoice){
			$this->db->where("invoice", $invoice);
			$result = $this->db->get("tbl_market_order");
			if($result->num_rows() == 1){
				$result = $result->result();
				if($this->session->userdata('role_id') == 2){
					if($result[0]->merchant_id == $this->session->userdata('id') && $result[0]->status == "PLEASE SHIPMENT"){
						$this->db->set("status", "WAITING PAYMENT");
						$this->db->where("invoice", $invoice);
						$this->db->update("tbl_market_order");
						$this->session->set_flashdata('success', "Sistem sudah merubah status invoice ini menjadi 'WAITING PAYMENT'");
						redirect("list-order");
					}else
						redirect("dashboard");
				}elseif($this->session->userdata('role_id') == 3){
					if($result[0]->buyer_id == $this->session->userdata('id') && $result[0]->status == "WAITING PAYMENT"){
						$amount_money = $this->input->post("amount_money");
						$data = array(
								"amount_money" => $this->input->post("amount_money"),
								"buyer_account_bank" => $this->input->post("buyer_account_bank"),
								"seller_account_bank" => $this->input->post("seller_account_bank"),
								"date_send_money" => save_tanggal($this->input->post("date_send_money")),
								"status" => "PLEASE SHIPMENT",
							);
							
						if($result[0]->total > $data['amount_money']){						
							$warning = "Maaf jumlah uang yang anda kirim kurang dari jumlah invoice yang sudah dikirim ke anda. Mohon transfer kembali sisa uang yang belum anda bayarkan sebanyak Rp ".number_format($result[0]->total - $data['amount_money'],0,',','.');
						}
				
						if(!empty($warning)){
							$data['date_send_money'] = $this->input->post('date_send_money');
							$this->session->set_flashdata('warning', $warning);
							redirect("view-invoice/".$invoice);
						}
						$this->db->where("invoice", $invoice);
						$this->db->update("tbl_market_order", $data);
						$this->session->set_flashdata('success', "Sistem sudah merubah status invoice ini menjadi 'PLEASE SHIPMENT', mohon untuk menunggu pengecekan dari seller apabila uang sudah masuk ke rekening seller barang akan dikirim ke tempat anda dan akan ada no resi pengiriman barang");
						redirect("list-order");
					}else
						redirect("dashboard");
				}else
					redirect("dashboard");
			}else
				redirect("dashboard");				
		}
		
		function ensiklopedia_terkait(){
			if($this->session->userdata("role_id") != 2)
				redirect("dashboard");
			$this->data['content'] = "roomuser_market_barang_terkait";
			$this->data['template'] = "roomuser_index";
			$search = $this->input->get('search');
			if(!empty($search))
				$this->db->like('name_barang', $search);
			$this->db->where("(set_gambar = 1 or  set_gambar IS NULL)");
			$this->db->join("tbl_gambar_barang", "tbl_gambar_barang.id_barang = tbl_barang.id", "left");
			$this->db->join("tbl_merk", "tbl_merk.id = tbl_barang.id_merk");
			$item = $this->db->get("tbl_barang");
			$pagingConfig   = $this->paginationlib->initPagination("/ensiklopedia-terkait",$item->num_rows(), 15);
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
			if($this->session->userdata("role_id") != 2)
				redirect("dashboard");
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
				redirect("item-form");
			else
				redirect("edit-item/$id");
		}
		
		function delete_link_ensiklopedia(){
			if($this->session->userdata("role_id") != 2)
				redirect("dashboard");
			
			$id = $this->input->get("id");
			if(empty($id)){
				$this->session->set_userdata('link_ensiklopedia', array());
				redirect("item-form");
			}else{
				$data = array(0 => array(
						"id" => null, 
						"link_gambar" => null, 
						"name_barang" => null,
						"name_merk" => null
					)
				);
				$this->session->set_userdata('link_ensiklopedia', $data);
				redirect("edit-item/$id");
			}
		}
		
		public function show_event_validation(){
			if(($this->session->userdata('login') == false || $this->session->userdata('role_id') != 1))
					redirect('login');
			$this->db->where("validation", null);
			$this->db->order_by("id");
			$event = $this->db->get('tbl_event');
			$this->data['dafkomen'] = $event->result();
			$this->data['content'] = "event_index_validation";
			$this->data['template'] = "roomuser_index";
			$this->load->view('client/template',$this->data);
		}
	}
	
	
?>