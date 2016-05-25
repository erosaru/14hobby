<html>
<head>
	<title>DuelMoniac.com</title>
	<meta content="DuelMoniac is the first card shop in indonesia." name="description">
	<meta content="toko kimia" name="keywords">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index, follow">
	<meta http-equiv="Copyright" content="PD Marcus">
	<meta name="author" content="Ferry Lugiman">
	<meta http-equiv="imagetoolbar" content="no">
	<meta name="language" content="Indonesia">
	<meta name="revisit-after" content="7">
	<meta name="webcrawlers" content="all">
	<meta name="rating" content="general">
	<meta name="spiders" content="all">	
	<link rel="shortcut icon" href="<?php echo base_url(); ?>/favicon.ico" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/bootstrap/css/bootstrap.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/bootstrap/css/bootstrap.min.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/bootstrap/css/bootstrap-responsive.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/bootstrap/css/bootstrap-responsive.min.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/doc.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/application.css" media="screen">
	<link href="<?php echo base_url() ?>asset/bootstrap/css/alertify.core.css" rel="stylesheet" id="toggleCSS">
	
	<script src="<?php echo base_url() ?>asset/jquery-1.9.1.js" type="text/javascript"></script>	
	<script src="<?php echo base_url() ?>asset/bootstrap/js/bootstrap.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>asset/bootstrap/js/jquery.scrollUp.js"></script>
	<script src="<?php echo base_url() ?>asset/bootstrap/js/alertify.min.js"></script>
    <script type="text/javascript">
		//ScrollUp
		$(document).ready(function () {
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
	</script>
</head>
<body>
	<?php $this->load->view("admin/template/menu") ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php 
				if(!isset($data))
					$this->load->view("admin/".$template);
				else
					$this->load->view("admin/".$template, $data);
			?>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php $this->load->view("admin/template/footer") ?>
</body>

