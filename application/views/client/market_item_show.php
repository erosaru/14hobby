<div class="col-md-4 text-center">
	<?if(!empty($dafkomen[0]->picture)):?>
		<center><?=resize_image_local_server("uploads/market_item/".$dafkomen[0]->picture, $dafkomen[0]->name, 200, 200)?></center>
	<?else:?>
		<?= resize_image_local_server("asset/image/profile.png", "blank_picture", 250, 200)?>
	<?endif?>
	<br/>&nbsp;
	<?if($this->router->fetch_method() == "item_show" && $this->router->fetch_class() == "roomuser"):?>
		<?if($this->session->userdata('role_id') == 2 && $dafkomen[0]->active > 0):?>
			<a href="<?=base_url()?>edit-item/<?= $dafkomen[0]->id?>" class="btn btn-block btn-primary">Edit</a>
		<?endif?>
		<?if($this->session->userdata('role_id') == 2):?>
			<a href="<?=base_url()?>list-item" class="btn btn-block btn-danger">Kembali</a>
		<?else:?>
			<a href="<?=base_url()?>roomuser/item_need_approve" class="btn btn-block btn-danger">Kembali</a>
		<?endif?>		
	<?endif?>
	<?if($this->session->userdata('role_id') == 3 && $this->router->fetch_method() == "show" && $this->router->fetch_class() == "detail_merchant" && $dafkomen[0]->stock > 0 && $dafkomen[0]->active == 1 && $this->session->userdata("login") == true):?>
		<form action="<?= base_url()?>add-to-cart" method="post">
			<div class="col-sm-12">
				<div class="col-sm-4"></div>
					<div class="col-sm-4" style="padding:0px;">
						<center>
							<input type="text" name="qty" value="1" required="required" class="form-control">
							<input type="hidden" value="<?= $dafkomen[0]->id?>" name="id">
						</center>
					</div>
				<div class="col-sm-4"></div>
			</div><br/>&nbsp;
			<input type="submit" class="btn btn-block btn-success" value="Masukkan ke keranjang">
			<a class="btn btn-block btn-danger" href="<?=base_url()?>detail-merchant/<?= !empty($dafkomen[0]->name_merchant) ? create_title($dafkomen[0]->name_merchant) : create_title(trim($dafkomen[0]->first_name." ".$dafkomen[0]->last_name))?>">Kembali</a>
		</form>
		<!--<a class="btn btn-block btn-danger" href="<?=base_url()?>ecatalog/kategori/<?= create_title($dafkomen[0]->name_kategori)?>">Kembali</a>-->
	<?elseif($this->router->fetch_class() == "detail_merchant"):?>
		<a class="btn btn-block btn-danger" href="<?=base_url()?>detail-merchant/<?= !empty($dafkomen[0]->name_merchant) ? create_title($dafkomen[0]->name_merchant) : create_title(trim($dafkomen[0]->first_name." ".$dafkomen[0]->last_name))?>"><b>Kembali</b></a>
	<?endif?>
	
	
</div>
<div class="col-md-8 ">
	<?if($this->router->fetch_method() == "item_show" && $this->router->fetch_class() == "roomuser" && $this->session->userdata('role_id') != 1):?>
		<div class="form-inline text-right">
			<div class="fb-share-button" data-href="http://<?= $_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL']?>" data-layout="button"></div>
		</div>
	<?endif?>
	<div class="form-inline">
		<label>Merchant</label>
		: <?= !empty($dafkomen[0]->name_merchant) ? $dafkomen[0]->name_merchant : trim($dafkomen[0]->first_name." ".$dafkomen[0]->last_name)?>
	</div>
	<div class="form-inline">
		<label>Dikirim Dari</label>
		: <?= $dafkomen[0]->city;?>, <?= $dafkomen[0]->province;?>
	</div>
	<div class="form-inline">
		<label>Kategori</label>
		: <?= $dafkomen[0]->name_kategori;?>
	</div>	
	<div class="form-inline">
		<label>Nama Barang</label>
		: <?= $dafkomen[0]->name;?>
	</div>		
	<div class="form-inline">
		<label>Merk</label>
		: <?= $dafkomen[0]->merk;?>
	</div>
	<div class="form-inline">
		<label>Harga</label>
		: Rp. <?= number_format($dafkomen[0]->price,0,',','.')?>
	</div>
	<div class="form-inline">
		<label>Stok</label>
		: <?= $dafkomen[0]->stock;?>
	</div>
	<div class="form-inline">
		<label>Deskripsi Barang</label>
		: <p><?= $dafkomen[0]->deskripsi;?></p>
	</div>
	<?if($this->session->userdata('role_id') == 1 && $dafkomen[0]->active == 0):?>
		<div class="form-inline">
			<label>Link Barang</label>
			: <p><a target="_blank" href="<?=base_url()?><?= create_title($item_link[0]->name_barang)?>"><?= $item_link[0]->name_merk;?> - <?= $item_link[0]->name_barang;?></a><br/>
			<?if(empty($item_link[0]->link_gambar)):?>
				<?= resize_image_local_server("asset/image/profile.png", "blank_picture")?>
			<?else:?>
				<?=resize_image_local_server("uploads/".$item_link[0]->link_gambar, $item_link[0]->name_barang)?><br/>
			<?endif?>
		</div>
		<form action="<?=base_url()?>item/item_check_for_publish/<?= $dafkomen[0]->id;?>" class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label">Alasan</label>
				<div class="col-sm-9">
					<textarea placeholder="alasan ketika item ditolak" name="pesan" class="form-control"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-9">
						<input type="submit" value="approve" name="status" class="btn btn-success" onclick="return(confirm('Anda yakin akan appvore item ini?'))">
						<input type="submit" value="decline" name="status" class="btn btn-danger" onclick="return(confirm('Anda yakin akan menolak item ini?'))">
				</div>
			</div>
			
			<!--
			<a onclick="return(confirm('Anda yakin akan appvore item ini?'))" class="btn btn-success" href="<?= base_url()?>item/item_approve/<?= $dafkomen[0]->id;?>">Approve</a>
			<a onclick="return(confirm('Anda yakin akan menolak item ini?'))" class="btn btn-danger" href="<?= base_url()?>item/item_decline/<?= $dafkomen[0]->id;?>">Decline</a>
			-->
		</form>
	<?endif?>
</div>
<div class="clearfix"></div>