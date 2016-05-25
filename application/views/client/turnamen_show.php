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
	<div class="col-sm-12" style="background-color:white;padding:10px;border-radius:10px;margin-bottom:5px;border:2px solid black;min-height:400px;">
		<div class="tab-pane active" id="artikel">
			<?if(!empty($turneyrutin) || !empty($turneyspesial)):?>
				<p style="min-height:300px;">
					<table width="100%">
						<tbody class="tablex">
							<?if(!empty($turneyrutin)):?>
								<? foreach($turneyrutin as $row){?>
									<tr>
										<td>
											<a href="<?= base_url()?>turnamen-<?= create_title($row->title)?>"><b><?= $row->title?></b></a><br/>
											<small>Officer Tournament: <?= $row->officer_turnamen?></small>
										</td>
										<td><span class="pull-right"><?= date("d F Y", strtotime($row->created_date))?></span><br/></td>
									</tr>
								<?}?>
							<?endif?>
							<?if(!empty($turneyspesial)):?>
								<? foreach($turneyspesial as $row){?>
									<tr>
										<td>
											<a href="<?= base_url()?>turnamen-<?= create_title($row->title)?>"><b><?= $row->title?></b></a><br/>
											<small>Officer Tournament: <?= $row->officer_turnamen?>; Tanggal Turnamen: <?= date("d F Y", strtotime($row->end_date))?></small>
										</td>
									</tr>
								<?}?>
							<?endif?>
						</tbody>
					</table>
				</p>
			<?else:?>
				<p>
					<center>
						Tidak ada turnamen.<br/>
						
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
		Bagi teman-teman yang mempunyai turnamen di bidang mainan, video game, sclupture, animasi dan komik dan ingin mempublikasikannya di <a href="<?=base_url();?>">14hobby</a> ini bisa melihat caranya di bawah ini<br/>
		<center>
		<a href="<?base_url()?>cara-pasang-event-turnamen" class="btn btn-success btn-big">Cara Mempublikasikan Turnamen</a>
		</center>
	</div>
	-->
	<?$this->load->view("client/sidebar")?>
</div>