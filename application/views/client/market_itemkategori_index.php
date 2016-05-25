<a class="btn btn-primary pull-right" href="<?= base_url();?><?= $this->router->fetch_class();?>/itemkategori_create">Buat Baru</a><br/>&nbsp;
<table class="table table-striped table-bordered" align="center">
	<thead>
		<tr>
			<th width="70%"><center>Kategori</center></th>
			<th width="10%"><center>Action</center></th>
		</tr>
	</thead>
	<tbody>
		<? if (($dafkomen > 0)){ ?>
			<? foreach($dafkomen as $row){?>
			<tr>
				<td><?= $row->name_kategori?></td>
				<td><center><a href="<?= base_url()?><?= $this->router->fetch_class();?>/itemkategori_edit/<?= $row->id?>" class="btn btn-success btn-xs">Edit</a></center></td>
			</tr>
			<?}?>
		<?}else{?>
			<tr>
				<td  colspan="2"><center>Belum ada data kategori</center></td>
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