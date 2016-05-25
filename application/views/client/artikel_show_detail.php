<div class="col-sm-8">
	<div class="span12">
		<div>
			<div>
				<h1 style="font-size:26px;line-height:26px;"><?= $artikel[0]->title?></h1>
				<small>By: <?= $artikel[0]->pengarang?>; <!--Tentang: <?= $artikel[0]->kategori?>; -->Dibuat: <?= show_tanggal($artikel[0]->created_date)?> </small>
			</div>
			<div style="margin-bottom:10px;text-align:right;">
				<div class="fb-share-button" data-href="" data-layout="button"></div>
			</div>
			<div>
				<?= $artikel[0]->pesan?>
			</div>
		</div>	
	</div>	
	<div class="span12">
		<div class="span12">
			<?= artikel_sejenis($artikel_sejenis) ?>
		</div>
		<div class="span12">
			<?= list_artikel_terbaru($artikel_terbaru) ?>
		</div>		
	</div>
</div>
<div class="col-sm-4">	
	<?$this->load->view("client/sidebar")?>
	
</div>