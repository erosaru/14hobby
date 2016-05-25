<?$counter = 0;?>
<style>
	.carousel-indicators .active {
		background-color:black;
	}
	
	.carousel-indicators li{
		background-color:grey;
	}
</style>
<script>
	$(function() {
		$('#myCarousel').carousel({
			interval: 5000
		});
	});
</script>
<div class="col-sm-12">
	<div class="col-sm-9">
		<div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-bottom:20px;">
			 <!-- Indicators -->
			<ol class="carousel-indicators" style="bottom:-32px;">
				<?if(empty($banner_home)):?>
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<?else:?>
					<?$counter = 0;?>
					<? foreach($banner_home as $row):?>
						<li data-target="#myCarousel" data-slide-to="<?= $counter?>" <?if($counter == 0) echo "class='active'";?>></li>
						<?$counter++;?>
					<?endforeach?>
				<?endif?>
			</ol>
			<!-- Carousel items -->
			<div class="carousel-inner" role="listbox">
				<?if(empty($banner_home)):?>
					<div class="active item">
						<img alt="Slideshow Image 1" src="<?= base_url() ?>asset/image/banner/default_banner.jpg">
					</div>
				<?else:?>
					<?$counter = 0;?>
					<? foreach($banner_home as $row):?>
						<div class="<?if($counter == 0) echo "active";?> item text-center">
							<img alt="<?= $row->img_alt;?>" src="<?= base_url() ?>asset/image/banner/<?= $row->link_picture; ?>" style="height:318px;">
							<?if(!empty($row->deskripsi)):?>
								<div class="carousel-caption">
									<?=$row->deskripsi?>
								</div>
							<?endif?>
						</div>
						<?$counter++;?>
					<?endforeach?>
				<?endif?>				
			</div>
			<!-- Carousel nav -->
			<?if($counter > 1000):?>
				<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>				
			<?endif?>
		</div>			
		<!--untuk pemberitahuan-->
		<?if(isset($pengumuman)):?>
			<div class="col-sm-12">
				<h2 class="c1" style="background-color:grey;color:white"><center>PENGUMUMAN</center></h2>
				<?= $pengumuman?>		
			</div>
		<?endif?>
		<div class="col-sm-12">
			<h2 class="title-bar c1"><a href="<?=base_url()?>artikel">Article >></a></h2>
			<ul>
				<? if (($artikel_baru->num_rows() > 0)){ ?>
					<? foreach($artikel_baru->result() as $row){?>
						<li>
							<? $image = "<br/>"; ?>
							<? if($row->lama <= 14): ?>
								<? $image = "<img style='line-height:0px;' src='".base_url()."asset/image/new.gif' style='margin-bottom:5px;'><br/>";?>
							<?endif?>
							<a class="title" href="<?= base_url()?>artikel-<?= $row->url_title?>"><!--[<?= $row->name_kategori?>]--><?= $row->title?></a> <?= $image?>
						</li>
					<?}?>
				<?}else{?>
						<li>Tidak ada data artikel terbaru</li>
				<?}?>
			</ul>					
		</div>

		<div class="col-sm-12">
			<h2 class="title-bar c2"><a href="<?=base_url()?>event">Event >></a></h2>
			<ul>
				<? if (($event_baru->num_rows() > 0)): ?>
					<? foreach($event_baru->result() as $row):?>
						<li>
							<? $image = "<br/>"; ?>
							<? if($row->lama <= 14): ?>
								<? $image = "<img style='line-height:0px;' src='".base_url()."asset/image/new.gif' style='margin-bottom:5px;'><br/>";?>
							<?endif?>
							<a class="title" href="<?= base_url()?>event-<?= create_title($row->title)?>"><?= $row->title?></a> <?= $image?>
						</li>
					<?endforeach?>
					<?else:?>
						<li>Tidak ada event terbaru diluar event rutin </li>
				<?endif?>
			</ul>
		</div>
				
		<div class="col-sm-12">
			<h2 class="title-bar c4"><a href="<?=base_url()?>turnamen">Tournament >></a></h2>
			<ul>
				<? if (($turnamen_baru->num_rows() > 0)){ ?>
					<? foreach($turnamen_baru->result() as $row){?>
						<li>
							<? $image = "<br/>"; ?>
							<? if($row->lama <= 14): ?>
								<? $image = "<img style='line-height:0px;' src='".base_url()."asset/image/new.gif' style='margin-bottom:5px;'><br/>";?>
							<?endif?>
							<a class="title" href="<?= base_url()?>turnamen-<?= create_title($row->title)?>"><?= $row->title?></a> <?= $image?>
						</li>
					<?}?>
					<?}else{?>
						<li>Tidak ada tournament terbaru diluar tournament rutin </li>
					<?}?>					
			</ul>
		</div>
		<div class="col-sm-12">
			<h2 class="title-bar cblack"><a href="<?=base_url()?>market">Market >></a></h2>
			<? if((count($item) > 0)): ?>
				<? foreach($item as $row):?>
					<div class="col-sm-12" style="border-bottom:1px solid #efefef;margin-bottom:10px;">
						<div class="col-sm-4" style="margin-bottom:10px;">
							<center>
								<?if(!empty($row->picture)):?>
									<?= resize_image_local_server("uploads/market_item/".$row->picture, $row->name)?>
								<?else:?>
									<?= resize_image_local_server("asset/image/profile.png".$row->picture, $row->name)?>
								<?endif?>
							</center>
						</div>
						<div class="col-sm-8 mobile-text-center" style="padding: 0 10px;">
							<div style="min-height:20px;">
									<?= $row->name?><br/>
									Rp <?= number_format($row->price,0,',','.')?><br/>
									Seller:  <a href="<?=base_url()?>detail-merchant/<?= empty($row->name_merchant) ? create_title(trim($row->first_name.' '.$row->last_name)) : create_title($row->name_merchant)?>"><?= empty($row->name_merchant) ? trim($row->first_name.' '.$row->last_name) : $row->name_merchant?></a><br/>
									Kota: <?= $row->city?><br/>
								</div>
								<?if($row->stock > 0):?>
									<a style="width:100px;" class="btn btn-success" href="<?=base_url()?>detail-merchant/<?=!empty($row->name_merchant) ? create_title($row->name_merchant) : create_title(trim($row->first_name.' '.$row->last_name))?>/detail-item/<?= $row->id?>/<?=create_title($row->name);?>"><?=$this->session->userdata('role_id') == 3 ? "Beli": "Lihat"?></a>
								<?else:?>
									<a style="width:100px;" class="btn btn-danger" href="<?=base_url()?>detail-merchant/<?=!empty($row->name_merchant) ? create_title($row->name_merchant) : create_title(trim($row->first_name.' '.$row->last_name))?>/detail-item/<?= $row->id?>/<?=create_title($row->name);?>">Lihat</a>
								<?endif?>
						</div>
					</div>
				<?endforeach?>
			<?else:?>
					Tidak ada barang baru yang dijual dimarketplace</li>
			<?endif?>					
			</ul>
		</div>
	</div>
	<div class="col-sm-3">
		<?$this->load->view("client/sidebar")?>	
	</div>

<!--
<div class="span12 bottom-menu" style="margin-bottom:10px;">
	<div style="width:80%;margin:0 auto;">
	<?if(!empty($link)):?>
		<? foreach($link as $row){?>
			<a href="<?=base_url().create_title($row['name_kategori']);?>">
				<div class="text-center" style="float:left;margin-right:20px;width:200px;height:100px;background-image:url('<?=base_url()?>/asset/image/kategori/<?=$row['link_gambar']?>')">
				</div>			
			</a>
		<?}?>
	<?endif?>
	<div class="clearfix"></div>
	</div>
	
	
	<div style="margin:0 auto;color:black;font-size:20px;border:2px black solid;padding:6px;">
			<center>
				Fun and Play with us.<br/>
				<small>14Hobby</small>
			</center>
	</div>
	
</div>
-->

