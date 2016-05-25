<form action="<?=base_url()?>market/search" method="get" class="form">
	<div class="input-group">      
		<input type="text" class="form-control input-sm" style="height:34px" name="search" value="<?= $this->input->get("search")?>" placeholder="Masukkan Kata Kunci">
		<?if(!empty($kategori)):?>
			<input type='hidden' name="kategori" value="<?=$this->input->get('kategori')?>">
		<?endif?>
		<span class="input-group-btn">
			<input type="submit" class="btn btn-default btn-success" value="Cari">
		</span>
	</div><!-- /input-group -->
</form>
<?if(isset($item)):?>
	<h2 class="cblack title-bar"><span style="font-size:20px;padding-right:20px;color:white;">Barang Terbaru</span></h2>
	<div class="col-sm-12">
		
		<?$x = 1;?>
		<? foreach($item as $row){?>
			<div class="col-sm-5 item-box">
				<div class="col-sm-12" style="min-height:150px;">
					<center>
							<?if(!empty($row->picture)):?>
								<?= resize_image_local_server("uploads/market_item/".$row->picture, $row->name)?>
							<?else:?>
								<?= resize_image_local_server("asset/image/profile.png".$row->picture, $row->name)?>
							<?endif?>
					</center>
				</div>
				<div class="col-sm-12">
					<center>
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
					</center>
				</div>						
			</div>
			<?if($x % 2 != 0):?>
				<div class="col-sm-1"></div><div class="col-sm-1"></div>
			<?endif?>
			<?$x++?>
		<?}?>
	</div>		
<?endif;?>