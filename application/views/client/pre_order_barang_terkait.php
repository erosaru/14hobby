<?$id = $this->input->get("id")?>
<form action="<?=base_url()?>pre_order/ensiklopedia_terkait" method="get" class="form">
		<div class="input-group">      
			<input type="text" class="form-control input-sm" style="height:34px" name="search" value="<?= $this->input->get("search")?>" placeholder="Masukkan Kata Kunci">
			<span class="input-group-btn">
				<input type="submit" class="btn btn-default btn-success" value="Cari">
			</span>
		</div><!-- /input-group -->
	</form>
<?foreach($item as $row):?>
	<div class="col-sm-4" style="border:1px solid black; margin-bottom:10px;min-height:200px;">
		<div class="col-sm-12 text-center" style="min-height:200px;padding:10px;">
			<?if(empty($row->link_gambar)):?>
				<?= resize_image_local_server("asset/image/profile.png", "blank_picture")?>
			<?else:?>
				<?=resize_image_local_server("uploads/".$row->link_gambar, $row->name_barang)?><br/>
			<?endif?>
		</div>
		<div class="col-sm-12 text-center" style="min-height:50px;">
			<?=$row->name_merk?> - <?=$row->name_barang?>
		</div>
		<div class="col-sm-12 text-center" style="margin-bottom:10px;">
			<a  target="_blank" class="btn btn-primary" href="<?=base_url()?><?=create_title($row->name_barang)?>">Deskripsi</a>
			<?if(empty($id)):?>
				<a href="<?=base_url()?>pre_order/add_link_ensiklopedia/<?= $row->id?>" class="btn btn-success">Link</a>
			<?else:?>
				<a href="<?=base_url()?>pre_order/add_link_ensiklopedia/<?= $row->id?><?if(!empty($id)) echo "?id=$id";?>" class="btn btn-success">Link</a>
			<?endif?>
			
		</div>	
	</div>
<?endforeach?>
<?if(isset($links)):?>
	<div class="col-sm-12">
		<center>
			<nav>
				<ul class="pagination">
					<?= $links ?>
				</ul>
			</nav>
		</center>
	</div>
<?endif?>
<div class="col-sm-12 text-center" style="margin-bottom:10px;">
	<?if(empty($id)):?>
		<a href="<?= base_url()?>item-form" class="btn btn-danger">Kembali</a>
	<?else:?>
		<a href="<?= base_url()?>edit-item/<?=$id?>" class="btn btn-danger">Kembali</a>
	<?endif?>
</div>
<div class="clearfix"></div>