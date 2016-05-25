<h1>Tipe Produk</h1>
<a class="btn btn-primary pull-right" href="<?= base_url();?>item/itemtype_create">Buat Baru</a><br/>&nbsp;
<table class="table table-striped table-bordered" align="center">
	<thead>
		<tr>
			<th width="20%"><center>Tipe Produk</center></th>
			<th width="20%"><center>Kategori</center></th>
			<th width="20%"><center>Merk</center></th>
			<th width="10%"><center>Action</center></th>
		</tr>
	</thead>
	<tbody>
		<? if (($dafkomen > 0)){ ?>
			<? foreach($dafkomen as $row){?>
			<tr>
				<td><?= $row->name_type_produk?></td>
				<td><?= $row->name_kategori?></td>
				<td><?= $row->name_sub_kategori?></td>
				<td><center><a href="<?= base_url()?>item/itemtype_edit/<?= $row->id?>" class="btn btn-success btn-mini">Ubah</a> </center></td>
			</tr>
			<?}?>
		<?}else{?>
			<tr>
				<td  colspan="4"><center>Belum ada data tipe produk</center></td>
			</tr>
		<?}?>
	</tbody>
</table>
<?php echo $page;?>