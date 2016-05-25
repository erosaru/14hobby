<?php
class Uploadfile extends CI_Model {
	function replace_name($string){
		$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
		$string = str_replace($d, '', $string);
		$string = str_replace(' ', '_', $string);
		return $string;
	}
	
    function do_upload_card($name_card="", $name_booster=""){
		if(!empty($_FILES['picture']['name'])){
			$name = strtolower($this->input->post('name_card'))."_".strtolower($this->replace_name($this->input->post('boosterset')));
			echo $name;
			$type_file = strrchr(basename($_FILES['picture']['name']),'.');			
			
			$config['upload_path'] = './asset/image/dbcard_image/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '
			';
			$config['max_width']  = '5000';
			$config['max_height']  = '5000';
			$config['file_name']  = $name;
			$config['overwrite']  = true;
			
			
			$this->load->library('upload', $config);
			if ( !$this->upload->do_upload('picture'))
				return $this->upload->display_errors();
			else{						
				$data = $this->upload->data();
				return $name.$type_file;
			}
		}else{
			return null;
		}
		
	}
	
	function upload_banner($id, $tipe){
		if(!empty($_FILES['picture']['name'])){
			$name = "gambar_banner_$id";
			$type_file = strrchr(basename($_FILES['picture']['name']),'.');			
			
			$config['upload_path'] = './asset/image/banner/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '
			';
			if($tipe == 1){
				$config['max_width']  = '1400';
				$config['max_height']  = '800';
			}else{
				$config['max_width']  = '1400';
				$config['max_height']  = '800';
			}
			
			$config['file_name']  = $name;
			$config['overwrite']  = true;
			
			
			$this->load->library('upload', $config);
			if ( !$this->upload->do_upload('picture'))
				return $this->upload->display_errors();
			else{						
				$data = $this->upload->data();
				return $name.$type_file;
			}
		}else{
			return null;
		}
		
	}
	
	 function upload_kategori_page(){
		if(!empty($_FILES['picture']['name'])){
			$name = strtolower($this->input->post('name_card'))."_".strtolower($this->replace_name($this->input->post('boosterset')));
			echo $name;
			$type_file = strrchr(basename($_FILES['picture']['name']),'.');			
			
			$config['upload_path'] = './asset/image/dbcard_image/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '
			';
			$config['max_width']  = '166';
			$config['max_height']  = '200';
			$config['file_name']  = $name;
			$config['overwrite']  = true;
			
			
			$this->load->library('upload', $config);
			if ( !$this->upload->do_upload('picture'))
				return $this->upload->display_errors();
			else{						
				$data = $this->upload->data();
				return $name.$type_file;
			}
		}else{
			return null;
		}
		
	}
}
?>