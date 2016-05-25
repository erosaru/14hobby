<?//print_r($this->session->userdata("buy_item"))?>
<style>
	img.resize{
		max-width:100%; 
		max-height:100%;
		margin:auto;
		display:block;
	}
	#fuu {		background-color: #FFFFFF;		border: 1px solid #0066B3;		border-radius: 4px 4px 4px 4px;		float: left;		margin: 3px 5px 3px 0;		padding: 2px;	}
	#fuu2{		background-color: #FFFFFF;		border: 1px solid #0066B3;		border-radius: 4px 4px 4px 4px;		margin: auto auto;		padding: 2px;	}
	#content-detail #kananx table{		font: 15px/160% 'Adobe Garamond Pro';		margin:0px;		font-weight:bold;	}
	#content-detail #kirix table{		font: 15px/160% 'Adobe Garamond Pro';		margin:0px;	}
	#content-detail .kirix{		background-color: transparant;		padding:0px;	}
	#content-detail #kananx{		width:70%;		height: auto;		float:left;		background-color: transparant;	}
	#content-detail #kananx #dalam{		width:95%;		height: auto;		margin: 5px auto;		margin-top: 20px;		background-color: transparant;		font-size:20px;	}
	
	#content-detail #bawahx{		width:100%;		height: auto;		float:left;		background-color: transparant;	}
	table tr li{		margin-left:20px;	}</style>

<div class='col-sm-9'>
	<div class="col-sm-12" style="margin-bottom:10px;">
		<label style="margin-bottom:7px;font-size:24px;font-weight:bold;"><?= $data[0]->name_barang?></label><br/>
		<span style="color:c1c1c1;font-size:14px;font-style: italic;">By</span>
		<span style="color:c1c1c1;font-size:14px;font-style: italic;"><?= $data[0]->name_merk?></span>
	</div>
	
	<div class='col-sm-12' style="margin-bottom:10px;text-align:right;">		
		<div class="fb-share-button" data-href="" data-layout="button"></div>
	</div>
	
	<div class='col-sm-12' style="margin-bottom:10px;">		
		<?if(!empty($data[0]->series)):?>
			<h5>Series</h5>
			<div style="padding-left:15px;">			
				<?= $data[0]->series?>
			</div>
		<?endif?>
		<h5>Deskripsi Produk</h5>
		<div style="padding-left:15px;">			
			<?= $data[0]->deskripsi?>
		</div>
		<?if($data[0]->divisi_id != 2):?>
			<h5>Package Size/Weight</h5>
			<div style="padding-left:15px;">			
				<?= empty($data[0]->panjang) ? "0" : $data[0]->panjang?> x <?= empty($data[0]->lebar) ? "0" : $data[0]->lebar?> x <?= empty($data[0]->tinggi) ? "0" : $data[0]->tinggi?> cm / <?= $data[0]->berat?>g
			</div>
		<?endif?>
	</div>
	
	
	<?if(isset($gambar)):?>
		<div class='col-sm-12' style="border-top:2px solid #e1e1e1;padding-top:20px;border-bottom:2px solid #e1e1e1">
			<?foreach($gambar as $row):?>
				<div class="col-sm-4 text-center" style="margin-bottom:10px;min-height:150px;">
					<?=resize_image_home($row->link_gambar, $data[0]->name_barang, 200)?>
				</div>
			<?endforeach?>
		</div>
	<?endif?>	
	
	<?if($this->session->userdata('special_merchant') == true && array_sum(array_map(function($item) {return $item['stock'];}, $ready_stock->result_array())) > 0):?>
		<div class='col-sm-12'>
			<h5>Harga dan Stok di 14Hobby</h5>
			<div style="padding-left:15px;">
				<?if(array_sum(array_map(function($item) {return $item['stock'];}, $ready_stock->result_array())) > 0):?>
					<div>
						<table class="table table-bordered">
							<caption style="font-size:12px;text-align:left;font-family:tahoma;">Ready Stock</caption>
							<tr>
								<th style="width:50%;">Detail</th>
								<th>Stock</th>
								<th>Price</th>
							</tr>
							<?foreach($ready_stock->result() as $row):?>
								<tr>
									<td><?= $row->information?></td>
									<td><?= $row->stock?></td>
									<td>Rp. <?= number_format($row->price,0,',','.')?></td>
								</tr>
							<?endforeach?>
						</table>
					</div>
					<div>
						<center>
							<?if($this->session->userdata('login') == true && $this->session->userdata('role_id') > 1):?>
								<form class="form-inline" method="post" action="<?=base_url()?>add-to-cart">
									<input type="hidden" value="<?= $data[0]->id?>" name="id_barang">
									<select name="information" class="span6">
										<?foreach($ready_stock->result() as $row):?>
											<?if($row->stock > 0):?>
												<option value="<?= $row->information?>"><?= $row->information?></option>
											<?endif?>
										<?endforeach?>
									</select>
									<input type="text" value="1" name="qty" class="span3">
									<input type="submit" value="add to cart" class="btn btn-success btn-small span3">
								</form>
							<?else:?>
								<a href="<?=base_url()?>how-to-buy#ready_stock" style="width:75px;" class="btn btn-success">Beli</a>
							<?endif?>
						</center>
					</div>
				<?endif?>
			</div>
		</div>	
	<?endif?>
	<?if($pre_order->num_rows() > 0):?>
		<div class='col-sm-12'>
			<h5>PO di 14Hobby</h5>
			<div style="padding-left:15px;">
				<?if($pre_order->num_rows() > 0):?>
					<div>
						<table class="table table-bordered">
							<caption style="font-size:12px;text-align:left;font-family:tahoma;">Pre Order</caption>
							<tr>
								<th style="width:15%">Deadline</th>
								<th style="width:25%">Price</th>
								<th>Keterangan</th>
								<th style="width:10%">Slot</th>
							</tr>
							<?foreach($pre_order->result() as $row):?>
								<tr>
									<td><?= show_tanggal($row->date_pre_order)?></td>
									<td><?if($row->kurs == "IDR") echo "Rp."; elseif($row->kurs == "JPY") echo "&yen;"; else echo "$"?> <?= number_format($row->harga,0,',','.')?></td>
									<td><?= !empty($row->keterangan_barang) ? $row->keterangan_barang." - " : ""?><?= $row->keterangan_pre_order?></td>								
									<td><?= $row->slot?></td>
								</tr>	
							<?endforeach?>
						</table>
					</div>
					<div>
						<center>
							<a href="<?=base_url()?>how-to-buy#preorder" style="width:75px;" class="btn btn-success">Order</a>
						</center>
					</div>
				<?endif?>
			</div>
		</div>	
	<?endif?>
	<div class="col-sm-12" style="margin-top:10px;">
		<?= barang_series($item_series)?>
	</div>
	<?if(!empty($sell_item)):?>
		<div class='col-sm-12 another-size' style='border-radius:10px;min-height:10px;background-color:black;margin-bottom:10px;'>
			<center>
				<b style='font-size:30px;color:white'>
					ITEM SELL IN MARKETPLACE
				</b><br/>
			</center>			
		</div>
		<div>
			<?foreach($sell_item as $row):?>
				<div class="col-sm-12" style="border-bottom:1px solid #dae2ed; padding-bottom:10px;">
					<div class="col-sm-3 text-center">
						<?if(empty($row->picture)):?>
							<?= resize_image_local_server("asset/image/profile.png", "blank_picture")?>
						<?else:?>
							<?=resize_image_local_server("uploads/market_item/".$row->picture, $row->name, 150)?><br/>
						<?endif?>
					</div>
					<div class="col-sm-9">
						<div class="form-inline">
							<a href="<?=base_url()?>detail-merchant/<?= show_name_seller($row)?>/detail-item/<?=$row->id?>/<?= create_title($row->name)?>"><?= $row->name?></a>
						</div>
						<div class="form-inline">
							<label style="min-width:72px;">Seller</label>
							: <a href="<?=base_url()?>detail-merchant/<?= show_name_seller($row)?>/profile"><?= show_name_seller($row)?></a>
						</div>	
						<div class="form-inline">
							<label style="min-width:72px;">Lokasi</label>
							: <?= $row->city?>, <?= $row->province?>
						</div>
						<div class="form-inline">
							<label style="min-width:72px;">Harga</label>
							:  Rp. <?= number_format( $row->price,0,',','.')?>
						</div>
					</div>
					
				</div>
			<?endforeach?>
		</div>
	<?endif?>
</div>
<div class="col-sm-3">
	<?$this->load->view("client/sidebar")?></div>	

<script>
	$(function () {
		$('#myTab a').click(function (e) {
		  e.preventDefault();
		  $(this).tab('show');
		});
	})
</script>