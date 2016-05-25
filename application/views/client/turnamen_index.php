<h1>Turnamen</h1>
<a class="btn btn-primary pull-right" href="<?= base_url();?>turnamen/admin_create">Buat Baru</a><br/>&nbsp;
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th ><center>Judul</center></th>
			<th ><center>Tanggal Buat</center></th>
			<th ><center>Tanggal Turnamen</center></th>
			<th ><center>Counter</center></th>
			<th ><center>Action</center></th>
		</tr>
	</thead>
	<tbody>

		<? if (($dafkomen > 0)){ ?>
			<? foreach($dafkomen as $row){?>
			<tr>
				<td><?= $row->title?></td>
				<td><center><?= show_tanggal($row->created_date)?></center></td>
				<td><center><?= show_tanggal($row->end_date)?></center></td>
				<td><center><?= $row->counter?></center></td>
				<td><center><a href="<?= base_url();?>turnamen/admin_edit/<?= $row->id?>" class="btn btn-success btn-xs">Ubah</a> | <a href="<?= base_url();?>turnamen/admin_delete/<?= $row->id?>" onclick="return(confirm('Anda yakin akan menghapus turnamen ini?'))" class="btn btn-danger btn-xs">Hapus</a></center></td>
			</tr>
			<?}?>
		<?}else{?>
			<tr>
				<td  colspan="5"><center>Belum ada data turnamen</center></td>
			</tr>
		<?}?>
	</tbody>
</table>
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

