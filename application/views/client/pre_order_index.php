<a class="btn btn-primary pull-right" href="<?= base_url();?><?=$this->router->fetch_class();?>/create">Buat Baru</a><br/>&nbsp;
<ul class="nav nav-tabs" id="myTab">	
	<li class="active"><a href="#item" data-toggle="tab" >PRE ORDER</a></li>	
	<li><a href="#cari">Cari PO</a></li>
</ul>
<div class="tab-content" style="padding-top:10px;">	
	<div class="tab-pane active" id="item">		
		<table class="table table-striped table-bordered" align="center">			
			<thead>
				<tr>					
					<th width="50%"><center>Nama Item</center></th>					
					<th width="10%"><center>Rilis</center></th>					
					<th width="10%"><center>Tiba</center></th>					
					<th width="10%"><center>Harga</center></th>
                    <th width="10%"><center>Order</center></th>
					<th width="15%"><center>Action</center></th>				
				</tr>
			</thead>			
			<tbody>				
				<? if ((count($dafkomen) > 0)){ ?>
					<? foreach($dafkomen as $row){?>	
						<tr>							
							<td><?= $row->name_barang?></td>							
							<td style="text-align:center;"><?= date("M Y", strtotime($row->tgl_rilis))?></td>
                            <td style="text-align:center;"><?= date("M Y", strtotime($row->tgl_tiba))?></td>
                            <td style="text-align:center;"><?= number_format($row->harga,0,',','.')?></td>
							<td style="text-align:center;"><?= $row->counter_order?> / <?= $row->slot?></td>
							<td>
								<center>
									<a href="<?= base_url()?><?= $this->router->fetch_class();?>/edit/<?= $row->id?>" class="btn btn-primary btn-xs">Ubah</a> <a href="<?= base_url()?><?= create_title($row->name_barang)?>" class="btn btn-success btn-xs">View</a> <!--<a href="<?= base_url()?>item/delete/<?= $row->id?>" class="btn btn-danger btn-xs">Delete</a>-->
								</center>
							</td>
						</tr>
					<?}?>				
				<?}else{?>					
					<tr>
						
						<td  colspan="7"><center>Tidak ada barang PO ditemukan</center></td>					
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
		<form id="form_kategori" class="form-horizontal" method="get" action="<?= base_url()?><?= $this->router->fetch_class();?>">
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