<h1>Bank</h1>
<a class="btn btn-primary pull-right" href="<?= base_url();?><?= $this->router->fetch_class();?>/create">Buat Baru</a><br/>&nbsp;
<table class="table table-striped table-bordered" align="center">
	<thead>
		<tr>
			<th width="70%"><center>Bank</center></th>
			<th width="10%"><center>Action</center></th>
		</tr>
	</thead>
	<tbody>
		<? if (count($dafkomen) > 0){ ?>
			<? foreach($dafkomen as $row){?>
			<tr>
				<td><?= $row->bank_name?></td>
				<td><center><a href="<?= base_url()?><?= $this->router->fetch_class();?>/edit/<?= $row->id?>" class="btn btn-success btn-xs">Ubah</a></center></td>
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