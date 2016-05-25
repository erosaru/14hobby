<h1>Daftar Komunitas</h1>
<a class="btn btn-primary pull-right" href="<?= base_url();?>list_komunitas/create">Buat Baru</a><br/>&nbsp;
<table class="table table-striped table-bordered" align="center">
	<thead>
		<tr>
			<th width="40%"><center>Nama Komunitas</center></th>
			<th width="20%"><center>Contact Person</center></th>
			<th width="10%"><center>Kota</center></th>
			<th width="10%"><center>Status</center></th>
			<th width="20%"><center>Action</center></th>
		</tr>
	</thead>
	<tbody>
		<? if (!empty($dafkomen)){ ?>
			<? foreach($dafkomen as $row){?>
			<tr>
				<td><?= $row->nama_komunitas?></td>
				<td><?= $row->nama_contact?></td>
				<td><?= $row->kota?></td>
				<td><? if($row->aktif) echo "Aktif"; else echo "Non Aktif";?></td>
				<td><center><a href="<?= base_url()?>list_komunitas/edit/<?= $row->id?>" class="btn btn-primary btn-mini">Ubah</a> <!--<a href="<?= base_url()?>item/show/<?= $row->id?>" class="btn btn-success btn-mini">View</a> <a href="<?= base_url()?>item/delete/<?= $row->id?>" class="btn btn-danger btn-mini">Delete</a>--></center></td>
			</tr>
			<?}?>
		<?}else{?>
			<tr>
				<td  colspan="5"><center>Belum ada komunitas mendaftar</center></td>
			</tr>
		<?}?>
	</tbody>
</table>
<?php //echo $page;?>