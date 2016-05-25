<?if($this->router->fetch_method() == "index_pre_order"):?>
	<?$x = "pre-order-"?>
<?else:?>
	<?$x = ""?>
<?endif?>
<div class="span8 dashboard-wrapper" style="background-color:white;padding:10px;border-radius:10px;margin-bottom:5px;border:2px solid black;" id="bursa_index">
	<center>
	<h2><?=$title?></h2>
		<?if(!empty($link)):?>
			<? foreach($link as $row){?>
				<a href="<?=base_url().$x.create_title($row->name_kategori);?>">
					<img style="margin-right:20px;width:106px;height:53px;margin-bottom:20px;" src="<?=base_url()?>/asset/image/kategori/<?=$row->link_gambar?>">
				</a>
			<?}?>
		<?else:?>
			<p>
				<center>Maaf untuk saat ini belum ada barang <?= $this->router->fetch_method() == "index_pre_order" ? "pre order" : "ready stok"?>.<br/><a href="<?= base_url()?>" class="btn btn-danger">Kembali</a></center>
			</p>
		<?endif?>
	</center>
</div>
<div class="span4">
	<?= another_menu() ?></div>