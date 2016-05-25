<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">			
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="active"><a class="brand" href="<?= base_url() ?>"><img src="<?=base_url();?>asset/image/logo-14hoby-mini.gif"></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu>Company<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?= base_url();?>page/tentangkami">About Us</a></li>
						<li><a href="<?= base_url();?>hubungi-kami">Contact Us</a></li>
					</ul>
				</li>
				<?if($this->session->userdata("special_id")==true):?>
					<li class="dropdown">
						<a id="drop1" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" data-original-title="">
							Store
							<b class="caret"> </b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?= base_url();?>ready-stock-all-toy">Toy Ready Stock</a></li>
							<li><a href="<?= base_url();?>preorder-all-toy">Toy Pre Order</a></li>
							<li><a href="<?= base_url();?>ready-stock-all-card-game">Card Game Ready Stock</a></li>
							<li><a href="<?= base_url();?>preorder-all-card-game">Card Game Pre Order</a></li>
						</ul>
					</li>
				<?endif?>
				<li><a href="<?= base_url();?>artikel">Article</a></li>
                <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu>Market<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?= base_url();?>market">Marketplace</a></li>
						<li><a href="<?= base_url();?>pre-order">Pre Order</a></li>
					</ul>
				</li>
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu>Community<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?= base_url();?>list-komunitas">List Community</a></li>
						<li><a href="<?= base_url();?>list-toko">List Store</a></li>
						<li><a href="<?= base_url();?>event">Event</a></li>							
						<li><a href="<?= base_url();?>turnamen">Tournament</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu>Encyclopedia<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?= base_url();?>toy-pedia">toy-pedia</a></li>
						<!--<li><a href="<?= base_url();?>card-game-pedia">card-game-pedia</a></li>-->
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?if($this->session->userdata('login') == true):?>
					<?if($this->session->userdata('role_id') == 0):?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu>ADMINISTRATOR<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu tabindex="0">Item</a>
									<ul class="dropdown-menu">
										<li><a href="<?= base_url();?>item/divisi" tabindex="0">Divisi</a></li>
										<li><a href="<?= base_url();?>item/itemmerk" tabindex="0">Merk</a></li>
										<li><a href="<?= base_url();?>item/itemkategori" tabindex="0">Kategori</a></li>
										<!--<li><a href="<?= base_url();?>item/itemtype" tabindex="-1">Tipe Produk</a></li>-->
										<li><a href="<?= base_url();?>item" tabindex="0">Data Item</a></li>
										<li><a href="<?= base_url();?>item/itemdijual" tabindex="0">PreOder Item</a></li>
										<!--<li><a href="<?= base_url();?>dbkartu">Database kartu</a></li>-->								
									</ul>
								</li>
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu tabindex="0">Banner</a>
									<ul class="dropdown-menu">
										<li><a href="<?= base_url();?>banner/pagehome" tabindex="-1">Page Home</a></li>
										<li><a href="<?= base_url();?>banner/sidebanner" tabindex="-1">Side Banner</a></li>								
									</ul>
								</li>
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu tabindex="0">Berita dan Artikel</a>
									<ul class="dropdown-menu">
										<li><a href="<?= base_url();?>artikel/admin_index_kategori" tabindex="-1">Kategori</a></li>
										<li><a href="<?= base_url();?>artikel/admin_index" tabindex="-1">Artikel</a></li>							
									</ul>
								</li>
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu tabindex="0">Market</a>
									<ul class="dropdown-menu">
										<li><a href="<?= base_url();?>market_item/itemkategori" tabindex="0">Kategori</a></li>
										<li><a href="<?= base_url();?>market_item" tabindex="0">Item</a></li>
									</ul>
								</li>
								<li><a href="<?= base_url();?>bank">Bank</a></li>
								<li><a href="<?= base_url();?>user">User</a></li>
								<li><a href="<?= base_url();?>turnamen/admin_index">Turnamen</a></li>
								<li><a href="<?= base_url();?>event/admin_index">Event</a></li>
								<li><a href="<?= base_url();?>list_komunitas">List Komunitas</a></li>
								<li><a href="<?= base_url();?>admin/pemberitahuan">Pengumuman</a></li>
							</ul>							
						</li>
						
					<?endif?>
				
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu>
							<?if($this->session->userdata('login') == false):?>
								<b>Your Room</b>
							<?else:?>
								<b>Hi, <?= $this->session->userdata('nama')?></b>
							<?endif?>
						<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?= base_url();?>dashboard">DASHBOARD</a></li>
							<li><a href="<?= base_url();?>profile">PROFILE</a></li>
                            <?if($this->session->userdata('role_id') <= 1 ):?>
								<li><a href="<?= base_url();?>pre_order">PRE ORDER</a></li>
							<?endif?>
							<?if($this->session->userdata('role_id') == 2):?>
								<li><a href="<?= base_url();?>list-item">ITEM</a></li>
								<li><a href="<?= base_url();?>list-order">ORDER</a></li>
							<?endif?>
							<?if($this->session->userdata('role_id') == 3):?>
								<?$count_item=0?>
								<?$buy_item = $this->session->userdata('buy_item')?>
								<?foreach($buy_item as $row):?>
									<?foreach($row['item'] as $item):?>
										<?$count_item++?>
									<?endforeach?>
								<?endforeach?>
								<li><a href="<?= base_url();?>list-order">ORDER</a></li>
								<li><a href="<?= base_url();?>order-form">ORDER FORM(<?= $count_item?>)</a></li>
							<?endif?>
							<li><a onclick="return(confirm('Anda yakin akan keluar?'))" href="<?= base_url();?>login/logout_process">LOGOUT</a></li>
						</ul>
					</li>
				<?else:?>
					<li><a href="<?= base_url() ?>login">Login</a></li>
					
				<?endif?>
				<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
			</ul>
		</div>
</nav>