<div class="col-sm-12" style="min-height:250px;padding-bottom:10px;">
	<div class="col-sm-12">
		<form id="form_search" action="<?=base_url()?>detail-merchant/<?=create_title($name_merchant['title'])?>" method="get" class="form-inline">
			<div class="input-group col-sm-8 box-margin-mobile">   
				<input type="text" class="form-control input-sm" style="height:34px" name="search" placeholder="Masukkan kata kunci untuk mencari barang di seller <?= $name_merchant['title']?>" style="width:100%;">
				
				<span class="input-group-btn">
					<input type="submit" class="btn btn-default btn-success" value="Cari">
				</span>
			</div>
			<?if(isset($kategori)):?>
				<div class="form-group">
					<select class="form-control" name="kategori" onchange="$('#form_search').submit();">
						<option value="" <?if($this->input->get('kategori') == "") echo "selected";?>>All</option>
						<?foreach($kategori as $row):?>
							<option value="<?=$row->name_kategori?>" <?if($this->input->get('kategori') == $row->name_kategori) echo "selected";?>><?=$row->name_kategori?></option>
						<?endforeach?>						
					</select>
				</div>
			<?endif?>
		</form>		
	</div>
	<?if(count($item)>0):?>
		<?for($i=0;$i<1;$i++):?>
		<?foreach($item as $row){?>
			<?//for($i=1;$i<20;$i++){?>
			<div class="col-sm-6">
				<div class="col-sm-12 text-center" style="margin-bottom:5px;min-height:170px;">
					<?if(empty($row->picture)):?>
						<?= resize_image_local_server("asset/image/profile.png", "blank_picture")?>
					<?else:?>
						<?=resize_image_local_server("uploads/market_item/".$row->picture, $row->name)?><br/>
					<?endif?><br/>
					
				</div>
				<div class="col-sm-12 text-center" style="margin-bottom:5px;min-height:80px;">
					<a href="<?=base_url();?>detail-merchant/<?= $name_merchant['title']?>/detail-item/<?= $row->id?>/<?= create_title($row->name)?>"><span class="text-success"><b><?= $row->name?></b></span><br/></a>
					<span class="text-success"><b><span style="font-size:10px;">Rp.</span> <?= number_format($row->price,0,',','.')?></b></span>
				</div>
				<div class="col-sm-12" style="margin-bottom:10px;">
					<?if($row->stock > 0):?>
						<a class="btn btn-success btn-block" href="<?=base_url();?>detail-merchant/<?= $name_merchant['title']?>/detail-item/<?= $row->id?>/<?= create_title($row->name)?>"><b><?=$this->session->userdata('role_id') == 3 ? "Beli": "Lihat"?></b></a>
					<?else:?>
						<a class="btn btn-danger btn-block" href="<?=base_url();?>detail-merchant/<?= $name_merchant['title']?>/detail-item/<?= $row->id?>/<?= create_title($row->name)?>"><b>Lihat</b></a>
					<?endif?>
				</div>				
			</div>
			<?//}?>
		<?}?>
		<?endfor?>
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
	<?else:?>
		<div class="col-sm-12 text-center">
			All item's sold out
		</div>
	<?endif?>
</div>