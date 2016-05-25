<script>
	$(function () {
		$('#myTab a').click(function (e) {
		  e.preventDefault();
		  $(this).tab('show');
		});
	})
</script>
<style>
	tbody tr:hover{
		background-color: white;
	}
	
	tbody.tablex tr td{
		border-bottom:1px solid black;
		padding:6px 0px;
	}
</style>

<div class="col-sm-9">
	<h1>List Event Indonesia</h1>
	<div class="bs-callout bs-callout-success">
		<p>Punya event yang berhubungan dengan mainan, game, komik dan animasi? iklanin aja di 14hobby.com<b> GRATIS!!!</b></p>
		<p class="text-right"><a class="btn btn-primary" href="<?=base_url()?>daftar-event">Iklankan Sekarang!</a></p>
	</div>
	<div class="col-sm-12">
		<div class="tab-pane active" id="artikel">
			<?if(!empty($turneyrutin) || !empty($turneyspesial)):?>
				<p style="min-height:300px;">
					<table width="100%">
						<tbody class="tablex">
							<?if(!empty($turneyrutin)):?>
								<?= "abc"?>
								<? foreach($turneyrutin as $row){?>
									<tr>
										<td>
											<a href="<?= base_url()?>event-<?= create_title($row->title)?>"><b><?= $row->title?></b></a><br/>
											<small>By: <?= $row->end_date?></small>
										</td>
										<td><span class="pull-right"><?= date("d F Y", strtotime($row->created_date))?></span><br/></td>
									</tr>
								<?}?>
							<?endif?>
							<?if(!empty($turneyspesial)):?>
								<? foreach($turneyspesial as $row){?>
									<tr>
										<td>
											<?$now = date("Y M d")?>
											<?if($now < date("Y M d", strtotime($row->start_date))):?>
												<?$color = ""?>
											<?elseif(($now == date("Y M d", strtotime($row->start_date)) && empty($row->end_date)) || ($now >= date("Y M d", strtotime($row->start_date)) && $now <= date("Y M d", strtotime($row->end_date)))):?>
												<?$color = "success"?>
											<?elseif($now > strtotime($row->end_date)):?>
												<?$color = "danger"?>
											<?endif?>
											<a class="text-<?= $color;?>" href="<?= base_url()?>event-<?= create_title($row->title)?>">
												<b>[<?= $row->kota?>] <?= $row->title?></b>
											</a><br/>
											<small>
												Tanggal: <?= date("d F Y", strtotime($row->start_date))?> 
												<?if(!empty($row->end_date)) echo " - ".date("d F Y", strtotime($row->end_date));?><br/>
												EO: <?= $row->eo?>
											</small>
										</td>
									</tr>
								<?}?>
							<?endif?>
						</tbody>
					</table>
				</p>
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
			<?else:?>
				<p>
					<center>
						Tidak ada event.<br/>
						
						<?if($this->input->get('cari') == 'cari'):?>
							<a href="<?= base_url()?>artikel" class="btn btn-danger">Refresh</a>
						<?else:?>
							<a href="<?= base_url()?>" class="btn btn-danger">Kembali</a>
						<?endif?>
					</center>
				</p>
			<?endif?>						
		</div>
	</div>
</div>
<div class="col-sm-3">	
	<!--
	<div class="span12 text-center box-informasi">
		Bagi teman-teman yang mempunyai event seperti gathering komunitas, pameran dan sale/diskon di toko nya di bidang mainan, video game, sclupture, animasi dan komik dan ingin mempublikasikannya di <a href="<?=base_url();?>">14hobby</a> ini bisa melihat caranya di bawah ini<br/>
		<center><a href="<?=base_url()?>cara-pasang-event-turnamen" class="btn btn-success btn-big">Cara Mempublikasikan Event</a></center>
	</div>
	-->
	<?$this->load->view("client/sidebar")?>
</div>