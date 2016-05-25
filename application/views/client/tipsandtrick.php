<div style="padding:0 10px;min-height:400px;">
	<h1>Tips dan Trik</h1>
	<?if(empty($tipsandtrick)):?>
		Belum ada tips dan trik pembelian untuk saat ini.
		<div class="clearfix"></div>
	<?else:?>
		<?foreach($tipsandtrick as $row){?>
			<a href="<?=base_url()?>artikel-<?= create_title($row->title)?>?kembali=true"><?= $row->title?></a><br/>
		<?}?>
	<?endif?>
</div>