<h1>Artikel</h1>
<a class="btn btn-primary pull-right" href="<?= base_url();?>artikel/admin_create">Buat Baru</a><br/>&nbsp;
<ul class="nav nav-tabs" id="myTab">
	<li class="active"><a href="#artikel" data-toggle="tab" >Artikel</a></li>
	<li><a href="#cari">Cari Artikel</a></li>
	
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="artikel">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th style="width:30%;"><center>Judul</center></th>
					<th ><center>Pengarang</center></th>
					<th style="width:20%;"><center>Kategori</center></th>
					
					<!--<th ><center>Tanggal Buat</center></th>-->
					<th ><center>Count</center></th>
					<th ><center>Action</center></th>
				</tr>
			</thead>
			<tbody>
				<? if (($dafkomen > 0)){ ?>
					<? foreach($dafkomen as $row){?>
					<tr>
						<td><?= $row->title?></td>
						<td><?= $row->pengarang?></td>
						
						<td><?= $row->name_kategori?></td>
						<!--<td><center><?= show_tanggal($row->created_date)?></center></td>-->
						<td><center><?= $row->counter ?></center></td>
						<td><center><a href="<?= base_url();?>artikel/admin_edit/<?= $row->id?>" class="btn btn-success btn-xs">Ubah</a> <a href="<?= base_url();?>artikel/admin_delete/<?= $row->id?>" onclick="return(confirm('Anda yakin akan menghapus artikel ini?'))" class="btn btn-danger btn-xs">Hapus</a></center></td>
					</tr>
					<?}?>
				<?}else{?>
					<tr>
						<td  colspan="6"><center>Belum ada data artikel</center></td>
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
	</div>
	<div class="tab-pane" id="cari" style="padding-top:20px;">
		<form id="form_kategori" class="form-horizontal" method="get" action="<?= base_url() ?>artikel/admin_index">
			<div class="form-group">
				<label class="col-sm-3 control-label">Kategori Artikel</label>
				<div class="col-sm-9">
					<div class="col-sm-3" style="padding:0px">
						<?= form_dropdown('id_kategori_artikel', $card_game_name, $this->input->get('id_kategori_artikel'), "class='form-control' id='id_kategori_artikel' onchange='ganti_merk($(this));''");?>			
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Judul Artikel</label>
				<div class="col-sm-9">
					<div class="col-sm-3" style="padding:0px">
						<input type="text" name="nama_artikel" id="nama_artikel" class="form-control">	
					</div>
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label">Nama Penulis</label>
				<div class="col-sm-9">
					<div class="col-sm-3" style="padding:0px">
						<input type="text" name="nama_penulis" id="nama_penulis" class="form-control">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Kategori</label>
				<div class="col-sm-9">
					<div class="col-sm-3" style="padding:0px">
						<input type="text" name="kategori" id="kategori" class="form-control">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
					<input type="hidden" name="cari" value="cari">
					<a href="javascript:void(0)" onclick="$('form').submit()" class="btn btn-success">Cari</a>
					<a href="javascript:void(0)" onclick="$('#myTab li:first a').click();" class="btn btn-danger">Batal</a>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	$(function () {
		$('#myTab a').click(function (e) {
		  e.preventDefault();
		  $(this).tab('show');
		});
	})	
</script>