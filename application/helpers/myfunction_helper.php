<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('show_tanggal')){
		function show_tanggal($tanggal){
			if(empty($tanggal) || $tanggal == "0000-00-00"){
				return "";
			}else{
				$lahir = explode("-", $tanggal, 3);
				$tanggal = $lahir[2];
				$bulan = $lahir[1];
				$tahun = $lahir[0];
				return "$tanggal-$bulan-$tahun";
			}				
		}
	}
	
	if ( ! function_exists('showtime')){
		function showtime($tanggal){
			$datetime = explode(" ", $tanggal, 2);
			$date = explode("-", $datetime[0], 3);
			$tanggal = $date[2];
			$bulan = $date[1];
			$tahun = $date[0];
			return "$tanggal-$bulan-$tahun ".$datetime[1];			
		}
	}
	if ( ! function_exists('save_tanggal')){
		function save_tanggal($tanggal){
			if(!empty($tanggal)){
				$lahir = explode("-", $tanggal, 3);
				$tanggal = $lahir[0];
				$bulan = $lahir[1];
				$tahun = $lahir[2];
				return "$tahun-$bulan-$tanggal";
			}else
				return "";
		}
	}
	if ( ! function_exists('create_title')){
		function create_title($string){
			$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
			$string = str_replace($d, '', $string);
			$string = str_replace(' ', '-', $string);
			$string = str_replace('--', '-', $string);
			return strtolower($string);
		}
	}
	if ( ! function_exists('create_title_top')){
		function create_title_top($string){
			$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
			$string = str_replace($d, '', $string);
			$string = str_replace(' ', ' ', $string);
			return strtolower($string);
		}
	}
	
	if ( ! function_exists('filtering_for_description')){
		function filtering_for_description($string){
			$d = array ('&nbsp;', "<br/>", "<p>", "</p>");
			$string = str_replace($d, '', $string);
			return $string;
		}
	}
	if ( ! function_exists('resize_image')){
		function resize_image($gambar, $nama_barang) {
			if(isset($gambar)){
				list($width, $height) = getimagesize(FCPATH."uploads/".$gambar);
				$dst_width2 = 200;
				$dst_height2 = ($dst_width2/$width)*$height;
				$user_agent = $_SERVER['HTTP_USER_AGENT'];
				if (preg_match('/Firefox/i', $user_agent)) {
					if($dst_height2 < 290)
						$h = 300+10;
					else
						$h = $dst_height2+10;
				}else if (preg_match('/Chrome/i', $user_agent)) {
					$h = 300+10;
				}
				$gambar_utama = "<img id='fuu2' alt='".create_title($nama_barang)."' width='$dst_width2' height='$dst_height2' src='".base_url()."uploads/".$gambar."'  />";
				return $gambar_utama;
			}else{
				return "<img id='fuu2' width='100px' src='".base_url()."asset/image/kategori/no_picture.png'  />";
			}		
		}
	}

	if ( ! function_exists('resize_image_home')){
		function resize_image_home($gambar, $nama_barang, $xwidth = 100) {
			if(isset($gambar)){
				list($width, $height) = getimagesize(FCPATH."uploads/".$gambar);
				$dst_width2 = $xwidth;
				$dst_height2 = ($dst_width2/$width)*$height;
				while($dst_height2 > 100){
					$dst_width2 -= 10;
					$dst_height2 = ($dst_width2/$width)*$height;
				}
				if($xwidth == 100)
					$gambar_utama = "<img class='fuu2' alt='".create_title($nama_barang)."' style='width:".$dst_width2."px;height:".$dst_height2."px;' src='".base_url()."uploads/".$gambar."'  />";
				else
					$gambar_utama = "<a href='".base_url()."pictures-".$gambar."' title='My caption'><img class='fuu2' alt='".create_title($nama_barang)."' style='width:".$dst_width2."px;height:".$dst_height2."px;' src='".base_url()."uploads/".$gambar."'  /></a>";
				return $gambar_utama;
			}else{
				return "<img class='fuu2' style='width:70px;height:98.591549295775px;' src='".base_url()."asset/image/kategori/no_picture.png'  />";
			}		
		}
	}
	
	if ( ! function_exists('generateRandomString')){
		function generateRandomString($length = 8) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
	}	
	if ( ! function_exists('split_words')){
		 function split_words($content){
			$word_limit = 30;
			$content = preg_replace("/&#?[a-z0-9]+;/i","",$content);
			$words = explode(" ",strip_tags($content));
			return implode(" ",array_splice($words,0,$word_limit));
		}
	}	
	if ( ! function_exists('truncate')){
		function truncate($mytext,$title) {
			//Number of characters to show
			$word_limit = 40;
			$mytext = preg_replace("/&#?[a-z0-9]+;/i","",$mytext);
			$words = explode(" ",strip_tags($mytext));
			$mytext = implode(" ",array_splice($words,0,$word_limit));
			$mytext = $mytext."...<br/> <label class='text-right'><a class='btn btn-mini' href='".base_url()."artikel-$title'>read more...</a></label>";
			return $mytext;
		}
	}
	
	if ( ! function_exists('another_menu')){
		function another_menu($login, $menu = "") {
			$print_menu = "";
			$list_menu = "";
			$list_menu .= "<li><a href='".base_url()."'>Home</a></li>";
			//$list_menu .= "<li><a href='".base_url()."suarateman'>Testimonial</a></li>";
			if($login == true){
				$list_menu .= "<li><b>Store</b><ul>";
				$list_menu .= "<li><a href='".base_url()."ready-stock-all-toy'>Toy Ready Stock</a></li>";
				$list_menu .= "<li><a href='".base_url()."preorder-all-toy'>Toy Pre Order</a></li>";
				$list_menu .= "<li><a href='".base_url()."ready-stock-all-card-game'>Card Game Ready Stock</a></li>";
				$list_menu .= "<li><a href='".base_url()."preorder-all-card-game'>Card Game Pre Order</a></li>";
				$list_menu .= "</ul></li>";
			}
			$list_menu .= "<li><a href='".base_url()."artikel'>Article</a></li>";
            $list_menu .= "<li><b>Market</b><ul>";
			$list_menu .= "<li><a href='".base_url()."market'>Marketplace</a></li>";
            $list_menu .= "<li><a href='".base_url()."pre-order'>Pre Order</a></li>";
            $list_menu .= "</ul></li>";
			$list_menu .= "<li><a href='".base_url()."event'>Event</a></li>";
			$list_menu .= "<li><a href='".base_url()."list-komunitas'>Community</a></li>";
			$list_menu .= "<li><a href='".base_url()."turnamen'>Tournament</a></li>";			
			$list_menu .= "<li><b>Encyclopedia</b><ul>";
			$list_menu .= "<li><a href='".base_url()."toy-pedia'>Toy-Pedia</a></li>";
			//$list_menu .= "<li><a href='".base_url()."card-game-pedia'>Card-Game-Pedia</a></li>";
			//$list_menu .= "<li><a href='".base_url()."ensiklopedia'>Cardspedia</a></li>";
			$list_menu .= "</ul></li>";
			$print_menu = "<ul>".$list_menu."</ul>";
			$print_menu = "<div class='col-sm-12 another-size menu-side' style='border-radius:10px;min-height:100px;margin-bottom:10px;padding:1px;padding-top:6px;background-color:black;'><center><b style='font-size:20px;color:white;'>Menu</b><br/></center><div style='padding:3px;min-height:100px;background-color:white;margin-top:6px;border-radius:0px 0px 10px 10px;'>$print_menu</div></div>";
			return $print_menu;  
		}
	}
	
	//artikel
	if ( ! function_exists('list_artikel_terbaru')){
		function list_artikel_terbaru($data) {
			$print_menu = "";
			if(!empty($data)){
				$list_menu = "";
				foreach($data as $row){
					$list_menu .= "<li><a href='".base_url()."artikel-".create_title($row->title)."'>".$row->title."</a></li>";
				}
				$print_menu = "<ul>".$list_menu."</ul>";
				$print_menu = '<div class="col-sm-12"><h2 class="title-bar c1" style="text-align:center;color:white;font-size:24px;">New Artikel</h2>'.$print_menu.'</div>';
			}
			return $print_menu;
		}
	}	
	if ( ! function_exists('kategori_artikel_lainnya')){
		function kategori_artikel_lainnya($data) {
			$print_menu = "";
			if(!empty($data)){
				$list_menu = "";
				foreach($data as $row){
					$list_menu .= "<li><a href='".base_url()."artikel?id_kategori_artikel=".$row->id."'>".$row->name_kategori." (".$row->jumlah.")</a></li>";
				}
				$print_menu = "<ul>".$list_menu."</ul>";
				$print_menu = "<div class='col-sm-12 another-size' style='border-radius:10px;margin-bottom:10px;padding:1px;padding-top:6px;background-color:black;'><center><b style='font-size:20px;color:white'>Kategori Artikel</b><br/></center><div style='padding:3px;background-color:white;margin-top:10px;border-radius:0px 0px 10px 10px;'>$print_menu</div></div>";
			}
			return $print_menu;
		}
	}	
	if ( ! function_exists('artikel_sejenis')){
		function artikel_sejenis($data) {
			$print_menu = "";
			if(!empty($data)){
				$list_menu = "";
				foreach($data as $row){
					$list_menu .= "<li><a href='".base_url()."artikel-".create_title($row->title)."'>".$row->title."</a></li>";
				}
				$print_menu = "<ul>".$list_menu."</ul>";
				$print_menu = '<div class="col-sm-12"><h2 class="title-bar c2" style="text-align:center;color:white;font-size:24px;">Artikel Terkait</h2>'.$print_menu.'</div>';
			}
			return $print_menu;
		}
	}
	
	//barang
	if ( ! function_exists('list_same_kategori_and_merk')){
		function list_same_kategori_and_merk($data) {
			$print_menu = "";
			if(!empty($data)){
				$list_menu = "";
				foreach($data['data'] as $row){
					$list_menu .= "<li><a href='".base_url().create_title($row->name_barang)."'>".$row->name_barang."</a></li>";
				} 
				$print_menu = "<ul>".$list_menu."</ul>";
				$print_menu = "<div class='col-sm-12 another-size' style='border-radius:10px;min-height:10px;margin-bottom:10px;padding:1px;padding-top:6px;background-color:black;'><center><b style='font-size:20px;;color:white'>".strtoupper($data['kategori'])."</b><br/></center><div style='padding:3px;min-height:10px;background-color:white;margin-top:10px;border-radius:0px 0px 10px 10px;'>$print_menu</div></div>";
			}
			return $print_menu; 
		}
	}	

	if ( ! function_exists('list_same_kategori_ready_stock')){
		function list_same_kategori_ready_stock($data, $menu = "") {
			$print_menu = "";
			if(!empty($data)){
				$list_menu = "";
				foreach($data as $row){
					if($menu != 1)
						$list_menu .= "<li><a href='".base_url().create_title($row->name_kategori)."'>".$row->name_kategori."</a></li>";
					else
						$list_menu .= "<li><a href='".base_url()."pre-order-".create_title($row->name_kategori)."'>".$row->name_kategori."</a></li>";
				}
				if($menu != 1)
					$title = "Ready Stock";
				else
					$title = "Pre Order";
				$print_menu = "<ul>".$list_menu."</ul>";
				$print_menu = "<div class='col-sm-12 another-size' style='border-radius:10px;min-height:10px;margin-bottom:10px;padding:1px;padding-top:6px;background-color:black;'><center><b style='font-size:20px;color:white'>$title</b><br/></center><div style='padding:3px;min-height:10px;background-color:white;margin-top:10px;border-radius:0px 0px 10px 10px;'>$print_menu</div></div>";
			}
			return $print_menu;
		}
	}
	
	if ( ! function_exists('barang_semanufacture')){
		function barang_semanufacture($data) {
			$print_menu = "";
			if(!empty($data)){
				$list_menu = "";
				foreach($data['data'] as $row){
					$list_menu .= "<li><a href='".base_url().create_title($row->name_barang)."'>".$row->name_barang."</a></li>";
				}
				$print_menu = "<ul>".$list_menu."</ul>";
				$print_menu = "<div class='col-sm-12 another-size' style='border-radius:10px;min-height:10px;margin-bottom:10px;padding:1px;padding-top:6px;background-color:black;'><center><b style='font-size:20px;color:white'>".strtoupper($data['merk'])."</b><br/></center><div style='padding:3px;min-height:10px;background-color:white;margin-top:10px;border-radius:0px 0px 10px 10px;'>$print_menu</div></div>";
			}
			return $print_menu;
		}
	}
	
	if ( ! function_exists('barang_series')){
		function barang_series($data) {
			$print_menu = "";
			$series = "";
			if(!empty($data)){
				$list_menu = "";
				foreach($data as $row){
					$series = $row->series;
					$list_menu .= "<li><a href='".base_url().create_title($row->name_barang)."'>".$row->name_barang."</a></li>";
				}
				$print_menu = "<ul>".$list_menu."</ul>";
				$print_menu = "<div class='col-sm-12'><h2 class='title-bar c2' style='padding-left:20px;text-align:left;color:white;font-size:24px;'>Series ".ucwords($series)."</h2>".$print_menu."</div>";
			}
			return $print_menu;
		}
	}
	if ( ! function_exists('ensiklopedia_kategori_lainnya')){
		function ensiklopedia_kategori_lainnya($data) {
			$print_menu = "";
			if(!empty($data)){
				$list_menu = "";
				foreach($data as $row){
					$list_menu .= "<li><a href='".base_url()."ensiklopedia-".create_title($row->name_kategori)."'>".$row->name_kategori."</a></li>";
				}
				$print_menu = "<ul>".$list_menu."</ul>";
				$print_menu = "<div class='col-sm-12 another-size' style='border-radius:10px;min-height:10px;margin-bottom:10px;padding:1px;padding-top:6px;background-color:black;'><center><b style='font-size:20px;color:white'>KATEGORI</b><br/></center><div style='padding:3px;min-height:10px;background-color:white;margin-top:10px;border-radius:0px 0px 10px 10px;'>$print_menu</div></div>";
			}
			return $print_menu;
		}
	}
	
	//lainnya
	if ( ! function_exists('hubungi_kami')){
		function hubungi_kami() {
			$print_menu = "<label style='text-align:justify;display: inline-block;'>Teman-teman ingin bertanya, berminat dengan barang kami, ingin mempublikasikan event atau turnamen, bisa hubungi kami:</label><br/>Contact Person: Ferry Lugiman<br/>BBM: 762DFF2A<br/>SMS/ Whatsapp/ Line: 085320066604<br/>Email: 14hobby@gmail.com";
			$print_menu = "<div class='col-sm-12 another-size menu-side' style='border-radius:10px;min-height:10px;margin-bottom:10px;padding:10px;background-color:#cccccc;'><center><b style='font-size:20px;'>Hubungi Kami</b><br/></center><div style='padding:5px;min-height:10px;background-color:white;margin-top:10px;border-radius:0px 0px 10px 10px;'>$print_menu</div></div>";
			return $print_menu;  
		}
	}
	
	if ( ! function_exists('pasang_iklan_toko_hobi')){
		function pasang_iklan_toko_hobi() {
			$print_menu = "<label style='text-align:justify;display: inline-block;'>Bagi teman-teman yang ingin memasangkan toko hobi kalian agar bisa ditampilkan di 14Hobby bisa menghubungi kami<br/><center><a href='".base_url()."hubungi-kami' class='btn btn-primary'>Hubungi Kami</a></center>";
			$print_menu = "<div class='col-sm-12 another-size menu-side' style='border-radius:10px;min-height:10px;margin-bottom:10px;padding:10px;background-color:#cccccc;'><center><b style='font-size:20px;'>Daftarkan Tokomu</b><br/></center><div style='padding:5px;min-height:10px;background-color:white;margin-top:10px;border-radius:0px 0px 10px 10px;'>$print_menu</div></div>";
			return $print_menu;  
		}
	}
	if ( ! function_exists('comment_fb')){
		function comment_fb($url = "") {
			//https://graph.facebook.com/comments/?ids=http://localhost/duelmoniac/tomica-reguler--audi-a1
			if(empty($url)){
				$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
				$link = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];
			}else{
				$link= $url;
			}
			echo "<script src='http://connect.facebook.net/en_US/all.js'></script>";
			echo "<div class='text-right' style='margin-bottom:10px;'>";
			echo "<div class='fb-like' data-href='$link;' data-layout='button' data-action='like' data-show-faces='false' data-share='true'></div>";
			echo "</div>";
            /*
			echo "<script>";
			echo "window.fbAsyncInit = function(){";
			echo "FB.Event.subscribe('comment.create', comment_callback);";
			echo "FB.Event.subscribe('comment.remove', delete_comment_callback);";
			echo "};";
			echo "</script>";
			echo "<div class='fb-comments' data-href='$link;' data-numposts='5' data-width='100%' data-colorscheme='dark' style='margin-top:10px;width:100%;'></div>";
		    */
        }
	}
	
	if ( ! function_exists('add_parameter')){
		function add_parameter() {
			$data = array();
			foreach(array_keys($_GET) as $key) {
				if($_GET[$key] && $key != "per_page")
					$data[] = "$key=".$_GET[$key];
			}
			if(count($data)>0)
				return "?".implode("&", $data);
			else
				return "";
		}
	}
	
	if ( ! function_exists('resize_image_local_server')){
		function resize_image_local_server($link, $name_item, $dst_width2 = 200, $max = 150) {
			if(isset($link)){
				list($width, $height) = getimagesize($link);				
				$dst_height2 = ($dst_width2/$width)*$height;
				while($dst_height2 > $max){
					$dst_width2 -= 10;
					$dst_height2 = ($dst_width2/$width)*$height;
				}
				return "<img alt='".create_title($name_item)."' width='$dst_width2' height='$dst_height2' src='".base_url().$link."'  />";				
			}else
				return "";
		}
	}	
	
	if ( ! function_exists('create_title_foto')){
		function create_title_foto($string){
			$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
			$string = str_replace($d, '', $string);
			$string = str_replace(' ', '_', $string);
			return strtolower($string);
		}
	}
	if ( ! function_exists('show_name_seller')){
		function show_name_seller($data){
			return !empty($data->name_merchant) ? create_title($data->name_merchant) : create_title(trim($data->first_name.' '.$data->last_name));			
		}
	}