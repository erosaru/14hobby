<h1>Daftar Toko</h1>
<a class="btn btn-primary pull-right" href="<?= base_url();?>list_toko/create">Buat Baru</a><br/>&nbsp;
<table class="table table-striped table-bordered" align="center">
	<thead>
		<tr>
			<th width="20%"><center>Nama Toko</center></th>
			<th width="15%"><center>Contact Person</center></th>
			<th width="10%"><center>Kota</center></th>
			<th width="20%"><center>Tipe Toko</center></th>
			<th width="10%"><center>Status</center></th>
			<th width="10%"><center>End Date</center></th>
			<th width="20%"><center>Action</center></th>
		</tr>
	</thead>
	<tbody>
		<? if (!empty($dafkomen)){ ?>
			<? foreach($dafkomen as $row){?>
			<tr>
				<td><?= $row->nama_toko?></td>
				<td><?= $row->nama_pemilik?></td>
				<td><?= $row->kota?></td>
				<td><?= $row->tipe_toko?></td>
				<td><? if($row->aktif) echo "Aktif"; else echo "Non Aktif";?></td>
				<td><?= show_tanggal($row->end_date)?></td>
				<td><center><a href="<?= base_url()?>list_toko/edit/<?= $row->id?>" class="btn btn-primary btn-mini">Ubah</a> <a onclick="return(confirm('anda yakin akan renew tanggal iklan untuk toko <?= $row->nama_toko?>'))" href="<?= base_url()?>list_toko/renew_date/<?= $row->id?>" class="btn btn-warning btn-mini">Renew</a><!--<a href="<?= base_url()?>item/show/<?= $row->id?>" class="btn btn-success btn-mini">View</a> <a href="<?= base_url()?>item/delete/<?= $row->id?>" class="btn btn-danger btn-mini">Delete</a>--></center></td>
			</tr>
			<?}?>
		<?}else{?>
			<tr>
				<td  colspan="7"><center>Belum ada toko mendaftar</center></td>
			</tr>
		<?}?>
	</tbody>
</table>
<?php //echo $page;?>