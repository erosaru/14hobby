<style>
	img.resize{
		max-width:100%; 
		max-height:100%;
		margin:auto;
		display:block;
	}
	
	#fuu {
		background-color: #FFFFFF;
		border: 1px solid #0066B3;
		border-radius: 4px 4px 4px 4px;
		float: left;
		margin: 3px 5px 3px 0;
		padding: 2px;
	}
	
	#fuu2{
		background-color: #FFFFFF;
		border: 1px solid #0066B3;
		border-radius: 4px 4px 4px 4px;
		margin: auto auto;
		padding: 2px;
	}

	#content-detail #kananx table{
		font: 15px/160% 'Adobe Garamond Pro';
		margin:0px;
		font-weight:bold;

	}
	
	#content-detail #kirix table{
		font: 15px/160% 'Adobe Garamond Pro';
		margin:0px;
	}
	
	#content-detail .kirix{
		height: <?php echo $h;?>;
		background-color: transparant;
		padding:0px;
	}
	
	#content-detail #kananx{
		width:70%;
		height: auto;
		float:left;
		background-color: transparant;
	}
	
	#content-detail #kananx #dalam{
		width:95%;
		height: auto;
		margin: 5px auto;
		margin-top: 20px;
		background-color: transparant;
		font-size:20px;
	}
	
	#content-detail #bawahx{
		width:100%;
		height: auto;
		float:left;
		background-color: transparant;
	}
</style>

<div class="span8 dashboard-wrapper">
	<div class="span12" style="margin-bottom:10px;">
		<label style="margin-bottom:7px;font-size:24px;font-weight:bold;"><?= $dafkomen[0]->name_barang?></label>
	</div>
	<div class='span12' style="margin-bottom:10px;">		
		<?= comment_fb();?>
	</div>
	<div class="span12">
		<div class="span3" style="margin-bottom:10px;">
			<center><?= resize_image($dafkomen[0]->link_gambar, $dafkomen[0]->name_barang)?></center>
		</div>
		<div class="span9" style="padding: 0 10px;">
			<div class="form-inline">
				<label style="min-width:70px;">Akhir PO</label>:
				<?= show_tanggal($dafkomen[0]->date_pre_order)?>
			</div>
			<div class="form-inline">
				<label style="min-width:70px;">Harga</label>:
				<?if($dafkomen[0]->kurs == "IDR") echo "Rp."; elseif($dafkomen[0]->kurs == "JPY") echo "&yen;"; else echo "$"?> <?= number_format($dafkomen[0]->harga,0,',','.')?>
			</div>			
			<div class="form-inline">
				<label style="min-width:70px;">Status</label>:
				<?$date = new datetime($dafkomen[0]->date_pre_order)?>
				<?$date2 = new datetime(date("Y-m-d"))?>
				<?=($date >= $date2) ? "On Going" : "Close"?>
			</div>
			<div class="form-inline">
				<label style="min-width:70px;">Slot</label>:
				<?= $dafkomen[0]->slot?>
			</div>
		</div>
	</div>
	<div class="span12">
		<table class="table table-bordered">
			<tr>
				<th>Nama</th>
				<th>DP</th>
				<th>Slot</th>
			</tr>
			<?if(count($dafkomen_detail)>0):?>
				<?foreach($dafkomen_detail as $row):?>
					<tr>
						<td><?= $row->nama_lengkap?></td>
						<td>Rp. <?= number_format($row->dp,0,',','.')?></td>
						<td><?= $row->slot?></td>
					</tr>
				<?endforeach?>
			<?else:?>
				<tr>
					<td colspan="3"><center>Belum ada yang memesan PO barang ini</center></td>
				</tr>
			<?endif?>
		</table>		
	</div>
	<?if($date >= $date2):?>
		<div class="span12">
			<center><a href="<?= base_url()?>how-to-buy#preorder" class="btn btn-success">Order</a></center>
		</div>
	<?endif?>
</div>
<div class="span4">
	<?= another_menu() ?>
	<?= list_same_kategori_ready_stock($kategori_ready_stock, 0)?>
	<?= list_same_kategori_ready_stock($kategori_pre_order, 1)?>
</div>