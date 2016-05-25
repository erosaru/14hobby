<div class="col-sm-9">
	<h1>List Toko Hobi Indonesia</h1>
	<div class="bs-callout bs-callout-success">
		<p>Bagi kamu yang punya toko online atau offline yang berhubungan dengan mainan, game, komik dan animasi daftarkan segera untuk diiklankan di 14hobby.com</p>
		<p class="text-right"><a class="btn btn-primary" href="#">Daftar Sekarang!</a></p>
	</div>	<?if(!empty($dafkomen)):?>		
		<? foreach($dafkomen as $row){?>
			<b><?= $row['kota']?></b>
			<? foreach($row['data'] as $rowx){?>
				<div class="widget">
					<div class="widget-header">
						<span style="font-size:20px;font-weight:bold;"><?= $rowx['nama_toko']?></span><br/>
						<small>Tanggal Terdaftar: <?= date("d F Y", strtotime($rowx['create_date']))?>; <?= ucwords($rowx['tipe_toko'])?></small>
					</div>
					<div class="widget-body">						
						<?if(!empty($rowx['alamat_toko'])):?>
							<span class="for-title">Alamat Toko </span>: <?= $rowx['alamat_toko'];?><br/>
						<?endif?>
						<span class="for-title">Contact Person </span>: <?= $rowx['nama_pemilik']?><br/>
						<?if(!empty($rowx['telepon_toko'])):?>
							<span class="for-title">Telepon </span>: <?= $rowx['telepon_toko']?><br/>
						<?endif?>
						<?if(!empty($rowx['email'])):?>
							<span class="for-title">Email </span>: <?= $rowx['email'];?><br/>
						<?endif?>
						<?if(!empty($rowx['website'])):?>
							<span class="for-title">Website </span>: <a href="<?= $rowx['website'];?>"><?= $rowx['website'];?></a><br/>
						<?endif?>
						<?if(!empty($rowx['facebook'])):?>
							<span class="for-title">Facebook </span>: <a href="<?= $rowx['facebook'];?>"><?= $rowx['facebook'];?></a><br/>
						<?endif?>
						<?if(!empty($rowx['twitter'])):?>
							<span class="for-title">Twitter </span>: <a href="<?= $rowx['twitter'];?>"><?= $rowx['twitter'];?></a><br/>
						<?endif?>
						<?if(!empty($rowx['line'])):?>
							<span class="for-title">Line </span>: <?= $rowx['line'];?><br/>
						<?endif?>
						<?if(!empty($rowx['whatsapp'])):?>
							<span class="for-title">whatsapp </span>: <?= $rowx['whatsapp'];?><br/>
						<?endif?>
						<span class="for-title">deskripsi </span>: 
						<div style="padding-left:20px;">
							<?= $rowx['deskripsi'];?>
						</div>
					</div>
				</div>
			<?}?>
		<?}?>
	<?else:?>		
		<center>
			Belum ada data toko yang terdaftar<br/>
			<a href="<?= base_url()?>" class="btn btn-danger">Kembali</a>		
		</center>
	<?endif?>
	
</div>
<div class="col-sm-3">	
	<!--
	<div class="span12 text-center box-informasi">
		Bagi teman-teman yang mempunyai toko hobi baik online maupun offline dan belum mendaftarkan di 14hobby, bisa mendaftarkan secara gratis<br/>
		<center>
			<a href="<?base_url()?>daftar-toko" class="btn btn-success btn-big">Daftarkan Tokomu</a>
		</center>
	</div>
	-->
	<?$this->load->view("client/sidebar")?>
	
</div>