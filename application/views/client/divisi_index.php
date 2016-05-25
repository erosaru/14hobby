<h1>Divisi</h1>
<a class="btn btn-primary pull-right" href="<?= base_url();?><?= $this->router->fetch_class();?>/divisi_create">Buat Baru</a><br/>&nbsp;
<table class="table table-striped table-bordered" align="center">
	<thead>
		<tr>
			<th width="70%"><center>Divisi</center></th>
			<th width="10%"><center>Action</center></th>
		</tr>
	</thead>
	<tbody>
		<? if ((count($dafkomen) > 0)){ ?>
			<? foreach($dafkomen as $row){?>
			<tr>
				<td><?= ucwords($row->name_divisi)?></td>
				<td><center><a href="<?= base_url()?><?= $this->router->fetch_class();?>/divisi_edit/<?= $row->id?>" class="btn btn-success btn-xs">Ubah</a></center></td>
			</tr>
			<?}?>
		<?}else{?>
			<tr>
				<td  colspan="2"><center>Belum ada data divisi</center></td>
			</tr>
		<?}?>
	</tbody>
</table>