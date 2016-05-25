<h1>
<?if($this->router->fetch_class() == "trading_card"):?>
	<?$title = "Trading Card";?>
<?else:?>
	<?$title = "Item";?>
<?endif?>
	<?= $title;?>
</h1>
<a class="btn btn-primary pull-right" href="<?= base_url();?><?=$this->router->fetch_class();?>/create">Buat Baru</a><br/>&nbsp;
<ul class="nav nav-tabs" id="myTab">	
	<li class="active"><a href="#item" data-toggle="tab" ><?= $title;?></a></li>	
	<li><a href="#cari">Cari <?= $title;?></a></li>
</ul>
<div class="tab-content">	
	<div class="tab-pane active" id="item">		
		<table class="table table-striped table-bordered" align="center">			
			<thead>
				<tr>					
					<th width="30%"><center>Nama Item</center></th>					
					<th width="10%"><center>Kategori</center></th>					
					<th width="10%"><center>Merk</center></th>					
					<th width="20%"><center>Tipe</center></th>
					<th width="10%"><center>Divisi</center></th>
					<th width="5%"><center>Deskripsi</center></th>
					<th width="15%"><center>Action</center></th>				
				</tr>
			</thead>			
			<tbody>				
				<? if ((count($dafkomen) > 0)){ ?>
					<? foreach($dafkomen as $row){?>						
						<tr>							
							<td><?= $row->name_barang?></td>							
							<td><?= $row->name_kategori?></td>							
							<td><?= $row->name_merk?></td>							
							<td><?= $row->type_produk?></td>
							<td><?= $row->name_divisi?></td>
							<td><?if(empty($row->deskripsi)) echo "kosong"; else echo "ada";?></td>	
							<td>
								<center>
									<a href="<?= base_url()?><?= $this->router->fetch_class();?>/edit/<?= $row->id?>" class="btn btn-primary btn-xs">Ubah</a> <a href="<?= base_url()?><?= create_title($row->name_barang)?>" class="btn btn-success btn-xs">View</a> <!--<a href="<?= base_url()?>item/delete/<?= $row->id?>" class="btn btn-danger btn-xs">Delete</a>-->
								</center>
							</td>
						</tr>
					<?}?>				
				<?}else{?>					
					<tr>
						
						<td  colspan="7"><center>Tidak ada barang ditemukan</center></td>					
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
	<div class="tab-pane" id="cari">
		<form style="padding:2px 10px;border:1px solid grey;border-radius:10px;" id="form_kategori" class="form-horizontal" method="get" action="<?= base_url()?><?= $this->router->fetch_class();?>">
			<h2>Pencarian <?= $title;?></h2>
			<div class="form-group">
				<label class="col-sm-3 control-label">Merk</label>
				<div class="col-sm-9">
					<div class="col-sm-3" style="padding:0px;">
						<?= form_dropdown('id_merk', $merk, "", "class='form-control' id='id_merk'");?>	
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Kategori</label>
				<div class="col-sm-9">
					<div class="col-sm-3" style="padding:0px;">
						<?= form_dropdown('id_kategori', $tipe, "", "id='id_kategori' class='form-control'");?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Kata Kunci</label>
				<div class="col-sm-9">
					<div class="col-sm-3" style="padding:0px;">
						<input type="text" value="" class="form-control" name="kata_kunci" id="kata_kunci">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
					<a class="btn btn-success" onclick="$('#form_kategori').submit();" href="javascript:void(0)">Cari</a>
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