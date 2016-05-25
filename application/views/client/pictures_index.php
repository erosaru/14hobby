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
<div class="col-sm-8">
	<div class="col-sm-12" style="background-color:white;padding:10px;border-radius:10px;margin-bottom:5px;border:2px solid black;min-height:400px;">
		<center>
			<h1><?= $dafkomen[0]->name_barang?></h1>
			<img style="width:100%;" alt="<?= create_title($dafkomen[0]->name_barang)."-".rand()?>" src="<?= base_url()."uploads/".$path;?>">
			
			<?if(isset($gambar_lain)):?>
				<div class="col-sm-12" style='margin-bottom:10px;margin-top:20px;'>
					<?foreach($gambar_lain as $row):?>
						<div class="col-sm-3">
							<? $link = base_url()."pictures-".$row->link_gambar;?>
							<a class='example-image-link' href='<?=$link?>' title='My caption'>
								<?=resize_image_home($row->link_gambar, create_title($dafkomen[0]->name_barang), 200)?>
							</a>
						</div>
					<?endforeach;?>
				</div>
				<div class="clearfix">
					<a class="btn btn-danger" href='<?= base_url()?><?= create_title($dafkomen[0]->name_barang);?>'>Kembali</a>
				</div>
				
			<?endif?>
			
		</center>
	</div>
</div>
<div class="col-sm-4">	
	<?$this->load->view("client/sidebar")?>
</div>