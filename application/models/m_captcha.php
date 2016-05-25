<?php
Class M_captcha extends CI_Model {

	function GenerateCaptcha(){
		$captcha = array(
		'word'		=> '',
		'img_path'	 	=> realpath('captcha').'/',
		'img_url'	 	=> base_url().'captcha/',
		'font_path'	 	=> FCPATH.'system/fonts/comic.ttf',
		'img_width'		=> 150,
		'img_height' 	=> 50,
		'expiration' 	=> 3600
		 );
		return create_captcha($captcha);
	}
}
?>