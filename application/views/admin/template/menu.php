<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
				</button>
				<div class="nav-collapse collapse">
					<ul class="nav" role="navigation">
						<li class="active"><a class="brand" href="<?= base_url();?>">ECollection.com</a></li>
						
					</ul>
					<?if($this->session->userdata('login') == true){?>
					<ul class="nav pull-right" role="navigation">
						<li><a href="<?= base_url() ?>loginadmin/logout_process"><i class="icon-share icon-white"></i></a></li>
					</ul>
					<?}?>					
					 
				</div><!--/.nav-collapse -->
			</div>
      </div>
</div>
<div class="clearfix"></div>
