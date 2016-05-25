<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<div id="text" class="pull-left" style="margin-top:14px;margin-left:25px;">
				<span><b>Marketplace 14hobby.com</b></span>
			</div>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#market-menu">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="market-menu">
			<ul class="nav navbar-nav">
				<li><a href="<?= base_url() ?>list-seller">SELLER</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu>ITEM<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?=base_url()?>market/search">All</a></li>
						<?foreach($item_kategori as $row):?>
							<?if(!empty($row['sub_kategori'])):?>
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-submenu tabindex="0"><?= $row['kategori']?></a>
									<ul class="dropdown-menu">
										<?foreach($row['sub_kategori'] as $sub_row):?>
											<li><a href="<?=base_url()?>market/search?kategori=<?= str_replace(' ', '+', $row['kategori'].' - '.$sub_row['name'])?>" tabindex="0"><?= $sub_row['name']?></a></li>
										<?endforeach?>
									</ul>
								</li>
							<?else:?>
								<li><a href="<?=base_url()?>market/search?kategori=<?= str_replace(' ', '+', $row['kategori'])?>"><?= $row['kategori']?></a></li>
							<?endif?>				
						<?endforeach?>
					</ul>
				</li>	
				<li><a href="<?= base_url() ?>market-help">HELP</a></li>		
			</ul>     
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>

