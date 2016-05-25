<div style="padding:20px;">
	<!--<a href="<?= base_url()."download-list-item"?>" class="btn btn-success" style="color: white;">Download</a>-->
	<a class="btn btn-primary pull-right" href="<?= base_url();?>item-form">Buat Baru</a><br/>&nbsp;
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th ><center>Nama Barang</center></th>				
				<th ><center>Kategori</center></th>
				<th ><center>Harga</center></th>
				<th ><center>Stock</center></th>				
				<th ><center>Action</center></th>
			</tr>
		</thead>
		<tbody>
			<? if (count($dafkomen) > 0){ ?>
				<? foreach($dafkomen as $row){?>
				<tr <? if($row->active == 0) echo  "style='color:green;'"; elseif($row->active == 2) echo "style='color:red;'";?>>
					<td><center><?= $row->name?></center></td>		
					<td><center><?= $row->name_kategori?></center></td>	
					<td>
						<center>
							Rp <?= number_format($row->price,0,',','.')?>
						</center>
					</td>					
					<td><center><?= ($row->stock > 0) ? $row->stock : "EMPTY" ?></center></td>
					<td>
						<center>
							<?if($row->active > 0):?>
								<a href="<?= base_url();?>edit-item/<?= $row->id?>" class="btn btn-primary btn-xs">Edit</a>
							<?endif?>
							<a href="<?= base_url();?>show-item/<?= $row->id?>" class="btn btn-success btn-xs">Show</a>
							<form action="<?=base_url()?>roomuser/delete_item/<?= $row->id?>" method="post" style="display:inline-block;margin:0px;">
								<input type="submit" onclick="return(confirm('Are you sure want to delete <?= $row->name?>'))" value="Delete" class="btn btn-danger btn-xs">
							</form>
						</center>
					</td>
				</tr>
				<?}?>
			<?}else{?>
				<tr>
					<td  colspan="6"><center>No Data Item</center></td>
				</tr>
			<?}?>
		</tbody>
	</table>
	<?if(isset($links)):?>
		<nav>
			<ul class="pagination">
				<?= $links ?>
			</ul>
		</nav>
	<?endif?>
</div>