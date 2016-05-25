<div class="col-sm-9">
	<div style="border-bottom: 1px solid #efefef;padding-bottom:5px;">
	<h1 style="margin-bottom:0px;" class="text-primary"><?= $dafkomen[0]->title?></h1>
	<small>
		Tanggal: <?= date("d F Y", strtotime($dafkomen[0]->start_date))?> 
		<?if(!empty($row->end_date)) echo " - ".date("d F Y", strtotime($dafkomen[0]->end_date));?><br/>
		EO: <?= $dafkomen[0]->eo?>
	</small>
	</div>
	<?= $dafkomen[0]->pesan?>			
	<center><a href="<?= base_url();?>event" class="btn btn-danger">Kembali</a></center>
</div>
<div class="col-sm-3">
	<!--
	<div class="span12 text-center box-informasi">
		Bagi teman-teman yang mempunyai event seperti gathering komunitas, pameran dan sale/diskon di toko nya di bidang mainan, video game, sclupture, animasi dan komik dan ingin mempublikasikannya di <a href="<?=base_url();?>">14hobby</a> ini bisa melihat caranya di bawah ini<br/>
		<center><a href="<?base_url()?>cara-pasang-event-turnamen" class="btn btn-success btn-big">Cara Mempublikasikan Event</a></center>
	</div>
	-->
	<?$this->load->view("client/sidebar")?>
</div>