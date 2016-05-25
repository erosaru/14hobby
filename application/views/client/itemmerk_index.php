<h1>Merk / Brand</h1>
<a class="btn btn-primary pull-right" href="<?= base_url();?><?= $this->router->fetch_class();?>/itemmerk_create">Buat Baru</a><br/>&nbsp;
<table class="table table-striped table-bordered" align="center">
	<thead>
		<tr>
			<th width="20%"><center>Merk</center></th>
			<th width="70%"><center>Divisi</center></th>
			<th width="10%"><center>Action</center></th>
		</tr>
	</thead>
	<tbody>
		<? if (($dafkomen > 0)){ ?>
			<? foreach($dafkomen as $row){?>
			<tr>
				<td><?= $row->name_merk?></td>
				<td><?= ucwords($row->name_divisi)?></td>
				<td><center><a href="<?= base_url()?><?= $this->router->fetch_class();?>/itemmerk_edit/<?= $row->id?>" class="btn btn-success btn-xs">Ubah</a> </center></td>
			</tr>
			<?}?>
		<?}else{?>
			<tr>
				<td  colspan="3"><center>Belum ada data sub kategori</center></td>
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