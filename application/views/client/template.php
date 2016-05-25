<?$repair = false;?>
<?if(($repair && $this->session->userdata('role_id') != 1) && ($this->router->fetch_class() != "login")):?>
	<div style="width:60%;padding:20px;margin:0 auto;border:2px solid black;border-radius:10px;">
		<p>
		Maaf kenyamanan anda terganggu karena<a href="<?= base_url()?>">14hobby.com</a> sedang dalam perbaikan cobalah beberapa saat kembali.<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;
		</p>
		<p style="text-align:right;">
		Terima Kasih <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;
			
		14hobby
		</p>
	</div>
<?else:?>
	<? $user_agent = $_SERVER['HTTP_USER_AGENT'];?>
	<?// if (preg_match('/BlackBerry/i', $user_agent)) :?>
	<? $xxx = 1;?>
	<? if ($xxx == 0) :?>
		<div style="width:60%;padding:20px;margin:0 auto;border:2px solid black;border-radius:10px;">
			<p>
			Maaf anda tidak bisa mengakses website ini apabila anda menggunakan browser Black Berry.
			Disarankan untuk mengakses website <a href="<?= base_url()?>">14hobby.com</a> gunakan browser Mozzila Firefox, Google Chrome atau minimal menggunakan browser Opera untuk  kenyamanan mendapatkan informasi dari website ini.<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;
			</p>
			<p style="text-align:right;">
			Terima Kasih <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;
			
			14hobby
			</p>
		</div>
	<?else:?>
		<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
		<head>
			<title><? if(!empty($title)):?>14hobby.com - <?=trim(create_title_top($title))?><?else:?>14Hobby | Indonesia | Komunitas dan Toko Hobi Online mainan, komik, video game, animasi<?endif?></title>
			<?if(empty($deskripsi)):?><meta content="14hobby.com adalah komunitas dan toko online dibidang mainan, game, video game, komik dan animasi dikota bandung jawa barat indonesia" name="description"><?else:?><meta content="<?= strip_tags(filtering_for_description($deskripsi))?>" name="description"><?endif?>		
			<?if(empty($seo)):?><meta content="toko mainan online, toko komik online, toko hobi online di indonesia, hobby, hobi, indonesia, video game, trading card, action figure, diecast, toy, collection, koleksi, sculpture, model kit, figure, reseller, whosale, media online, mainan, turnamen, gathering, sale, diskon, expo, fair" name="keywords"><?else:?><meta content="<?= $seo?>" name="keywords"><?endif;?>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="robots" content="index, follow">
			<meta http-equiv="Copyright" content="14Hobby">
			<meta name="author" content="Ferry Lugiman">
			<meta http-equiv="imagetoolbar" content="no">
			<meta name="language" content="Indonesia">
			<meta name="revisit-after" content="7">
			<meta name="webcrawlers" content="all">
			<meta name="rating" content="general">
			<meta name="spiders" content="all">	
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="shortcut icon" href="<?php echo base_url(); ?>asset/favicon.ico" />
			
			<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/bootstrap/css/bootstrap.css" media="screen">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/bootstrap/css/bootstrap.min.css" media="screen">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/doc.css" media="screen">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/application.css" media="screen">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/bootstrap/css/datepicker.css" media="screen">
			<link href="<?php echo base_url() ?>asset/bootstrap/css/alertify.core.css" rel="stylesheet" id="toggleCSS">	
			<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/bootstrap/css/bootstrap-submenu.min.css" media="screen">
			<link rel="stylesheet" href="<?= base_url()?>asset/lightbox/css/lightbox.css" type="text/css" />
			
				
			<script src="<?php echo base_url() ?>asset/jquery-1.9.1.js" type="text/javascript"></script>	
			<script src="<?php echo base_url() ?>asset/bootstrap/js/bootstrap.js" type="text/javascript"></script>
			<script src="<?php echo base_url() ?>asset/bootstrap/js/jquery.scrollUp.js"></script>
			<script src="<?php echo base_url() ?>asset/bootstrap/js/alertify.min.js"></script>
			<script src="<?php echo base_url() ?>asset/bootstrap/js/accounting.js"></script>			
			<script type="text/javascript" src="<?php echo base_url() ?>asset/bootstrap/js/bootstrap-datepicker.js"></script>
			<script type="text/javascript" src="<?php echo base_url() ?>asset/bootstrap/js/bootstrap-submenu.min.js"></script>
			<script type="text/javascript" src="<?= base_url();?>asset/tinymce/js/tinymce/tinymce.min.js"></script>
			<script type="text/javascript" src="<?= base_url();?>asset/ajaxupload.3.5.js"></script>	
			<script src="<?= base_url()?>asset/lightbox/js/lightbox-2.6.min.js" type="text/javascript"></script>			
			<script type="text/javascript">
				//ScrollUp
				$(document).ready(function () {
					$('[data-submenu]').submenupicker();
					$.scrollUp({
					  scrollName: 'scrollUp', // Element ID
					  topDistance: '300', // Distance from top before showing element (px)
					  topSpeed: 300, // Speed back to top (ms)
					  animation: 'fade', // Fade, slide, none
					  animationInSpeed: 400, // Animation in speed (ms)
					  animationOutSpeed: 400, // Animation out speed (ms)
					  scrollText: 'Scroll to top', // Text for element
					  activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
					});
				});
				
				(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5&appId=581010348679554";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
		</head>
		<body style="background: -moz-linear-gradient(center bottom, #787878 0%, #000000 51%) repeat-x scroll 0 0 transparant;">
			<div class="container-fluid">
				<?php $this->load->view("client/template/menu") ?>
				<div id="fb-root"></div>							
				<div class="row" style="margin-top:20px;">					
					<div class="col-sm-1"></div>
					<div class="col-sm-10 screen-fit" style="margin-top:-10px;background-color:white;padding:10px;min-height:85vh;">
						<?$this->load->view("client/alert_template")?>
						<?php $this->load->view("client/".$template) ?>
					</div>
					<div class="col-sm-1"></div>
				</div>	
				<div class="clearfix"></div>
				<?php $this->load->view("client/template/footer") ?>
			</div>
			<!--Start of Tawk.to Script-->
			<script type="text/javascript">
			var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
			(function(){
			var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
			s1.async=true;
			s1.src='https://embed.tawk.to/5663d0b989e114a858c6b756/default';
			s1.charset='UTF-8';
			s1.setAttribute('crossorigin','*');
			s0.parentNode.insertBefore(s1,s0);
			})();
			</script>
			<!--End of Tawk.to Script-->	
		</body>
		</html>
	<?endif?>
<?endif?>