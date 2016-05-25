<h1>Kategori Artikel</h1>
<a class="btn btn-primary pull-right" href="<?= base_url();?>artikel/admin_create_kategori">Buat Baru</a><br/>&nbsp;
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
				<td><center><a href="<?= base_url()?>artikel/admin_edit_kategori/<?= $row->id?>" class="btn btn-success btn-xs">Ubah</a></center></td>
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