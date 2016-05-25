<div class="col-sm-9 dashboard-wrapper">
	<div class="widget">
		<div class="widget-header" id="detail-<?= create_title($dafkomen[0]->title)?>">
			<b><?= $dafkomen[0]->title?></b><br><small>Officer Turname: <?=$dafkomen[0]->officer_turnamen?></small>
			<span class="pull-right"><?= date("d F Y", strtotime($dafkomen[0]->end_date))?></span>
		</div>
		<div class="widget-body">
			<?= $dafkomen[0]->pesan?>
			<center><a href="<?= base_url();?>turnamen" class="btn btn-danger">Kembali</a></center>
		</div>
	</div>
</div>
<div class="col-sm-3">
	<!--
	<div class="span12 text-center box-informasi">
		Bagi teman-teman yang mempunyai turnamen di bidang mainan, video game, sclupture, animasi dan komik dan ingin mempublikasikannya di <a href="<?=base_url();?>">14hobby</a> ini bisa melihat caranya di bawah ini<br/>
		<center>
		<a href="<?base_url()?>cara-pasang-event-turnamen" class="btn btn-success btn-big">Cara Mempublikasikan Turnamen</a>
		</center>
	</div>
	-->
	<?= another_menu($this->session->userdata('login')) ?>
</div>