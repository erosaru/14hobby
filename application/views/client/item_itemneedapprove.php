<div class="tab-pane active" id="item">		
	<table class="table table-striped table-bordered" align="center">			
			<thead>
				<tr>					
					<th width="20%"><center>Nama Item</center></th>					
					<th width="20%"><center>Kategori</center></th>					
					<th width="10%"><center>Merk</center></th>					
					<th width="20%"><center>Action</center></th>				
				</tr>
			</thead>			
			<tbody>				
				<? if ((count($dafkomen) > 0)){ ?>
					<? foreach($dafkomen as $row){?>						
						<tr>
							<td><?= $row->name?></td>							
							<td><?= $row->name_kategori?></td>							
							<td><?= $row->merk?></td>							
							<td>
								<center>
									<a href="<?= base_url()?>roomuser/item_show/<?= $row->id?>" class="btn btn-success btn-xs">View</a> <!--<a href="<?= base_url()?>item/delete/<?= $row->id?>" class="btn btn-danger btn-mini">Delete</a>-->
								</center>
							</td>
						</tr>
					<?}?>				
				<?}else{?>					
					<tr>						
						<td  colspan="4"><center>There are no data item</center></td>					
					</tr>				
				<?}?>			
			</tbody>		
		</table>
		<?if(isset($links)):?>
			<nav>
				<ul class="pagination">
					<?= $links ?>
				</ul>
			<nav>
		<?endif?>
	</div>	
	
