<style>
	.edit-fancy{
		margin-top:0px;
		height:20px;
		margin-left:0px;
		width:100%;
	}
	
	.fancy-tooltip-wrapper li{
		float: right;
	}
	
	p{
		font-family: "Osaka,Verdana,Arial,sans-serif";
	}
</style>
<div class="col-sm-9">
	<?if(!empty($dafkomen)):?>
		<h1>List Komunitas</h1>
		<? foreach($dafkomen as $row){?>
			<b><?= $row['kota']?></b>
			<? foreach($row['data'] as $rowx){?>
				<div class=" dashboard-wrapper">
				<div class="widget">
					<div class="widget-header">
						<span style="font-size:20px;font-weight:bold;"><?= $rowx['nama_komunitas']?></span><br/>
						<small>Tanggal Terdaftar: <?= date("d F Y", strtotime($rowx['create_date']))?></small>
					</div>
					<div class="widget-body">
						<div style="width:100%">
							<div>
							<?if(!empty($rowx['logo_komunitas'])):?>
								<img alt="<?= $rowx['nama_komunitas']?>" style="width:100%;" src="<?base_url()?>uploads/logo_komunitas/<?=$rowx['logo_komunitas']?>">
							<?endif?>
							</div>
							<div class="span8">								
								<span class="for-title">Contact Person </span>: <?= $rowx['nama_contact']?><br/>
								<span class="for-title">Telepon </span>: <?= $rowx['telepon_komunitas']?><br/>
							</div>
							<div class="span4">
								<?if(!empty($rowx['facebook']) || !empty($rowx['twitter'])):?>
									<ul class="fancy-tooltip-wrapper edit-fancy">
										<?if(!empty($rowx['twitter'])):?>
											<li><a target="_blank" class="tooltip-twitter" href="<?= $rowx['twitter'];?>"></a></li>
										<?endif?>
										<?if(!empty($rowx['facebook'])):?>
											<li><a target="_blank" class="tooltip-facebook" href="<?= $rowx['facebook'];?>"></a></li>
										<?endif?>										
									</ul>
								<?endif?>		
							</div>
							<div class="clearfix"></div>
						</div>
						
						<?if(!empty($rowx['email'])):?>
							<span class="for-title">Email </span>: <?= $rowx['email'];?><br/>
						<?endif?>
						<?if(!empty($rowx['website'])):?>
							<span class="for-title">Website </span>: <a href="<?= $rowx['website'];?>"><?= $rowx['website'];?></a><br/>
						<?endif?>
										
						<?if(!empty($rowx['line'])):?>
							<span class="for-title">Line </span>: <?= $rowx['line'];?><br/>
						<?endif?>
						<?if(!empty($rowx['whatsapp'])):?>
							<span class="for-title">whatsapp </span>: <?= $rowx['whatsapp'];?><br/>
						<?endif?>
						<span class="for-title">Kegiatan </span>: 
						<div style="padding-left:20px;">
							<?= $rowx['kegiatan'];?>
						</div>
						<span class="for-title">Cara Ikut Komunitas </span>: 
						<div style="padding-left:20px;">
							<?= $rowx['cara_ikut_komunitas'];?>
						</div>
					</div>
				</div>
				</div>
			<?}?>
		<?}?>
	<?else:?>
		<div class="span12" style="background-color:white;padding:10px;border-radius:10px;margin-bottom:5px;border:2px solid black;min-height:400px;">
			<h1>List Komunitas</h1>
			Belum ada data komunitas yang terdaftar<br/>
			<a href="<?= base_url()?>" class="btn btn-danger">Kembali</a>
		</div>
	<?endif?>
	
</div>
<div class="col-sm-3">	
	<!--
	<div class="span12 text-center box-informasi">
		Bagi teman-teman yang mempunyai komunitas hobi dibidang mainan, video game, sclupture, komik belum mendaftarkan di 14hobby, bisa mendaftarkan secara gratis<br/>
		<center>
			<a href="<?base_url()?>daftar-komunitas" class="btn btn-success btn-big">Daftarkan Komunitasmu</a>
		</center>
	</div>
	-->
	<?$this->load->view("client/sidebar")?>
</div>