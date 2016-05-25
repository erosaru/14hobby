<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th ><center>Nama Acara</center></th>
			<th ><center>Penyelengara</center></th>
			<th ><center>Acara Mulai</center></th>
			<th ><center>Acara Berakhir</center></th>
			<th ><center>Action</center></th>
		</tr>
	</thead>
	<tbody>

		<? if ((count($dafkomen) > 0)){ ?>
			<? foreach($dafkomen as $row){?>
			<tr>
				<td>[<?= $row->kota?>] <?= $row->title?></td>
				<td><?= $row->eo?></td>
				<td><center><?= show_tanggal($row->start_date)?></center></td>
				<td><center><?= show_tanggal($row->end_date)?></center></td>
				<td><center><a href="<?= base_url();?>event/admin_edit/<?= $row->id?>" class="btn btn-success btn-xs">Lihat</a></center></td>
			</tr>
			<?}?>
		<?}else{?>
			<tr>
				<td  colspan="5"><center>Belum ada event</center></td>
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

