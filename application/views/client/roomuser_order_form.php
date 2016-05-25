<style>
	.form-inline{
		margin-bottom:10px;
	}
	
	.title{
		font-weight:bold;
	}
</style>
<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<form id="form_account_bank" method="post" action="<?= base_url()."send-order"?>">
		<div class="form-inline">
			<label class="title">Order Form</label>
		</div>
		<div class="form-inline">
			<label class="control-label">Untuk</label>
			<input required="required" type="text" value="<? if(isset($data)) echo $data['send_to'];?>" class="span6" name="send_to" id="send_to">
		</div>
		<div class="form-inline">
			<label class="control-label">Alamat</label>
			<input required="required" type="text" value="<? if(isset($data)) echo $data['address_destination'];?>" class="span6" name="address_destination" id="address_destination">
		</div>
		<div class="form-inline">
			<label class="control-label">Kota / Provinsi</label>
			<input required="required" type="text" value="<? if(isset($data)) echo $data['shipping_to'];?>" class="span3" name="shipping_to" id="shipping_to">
		</div>
		<div class="form-inline">
			<label class="col-sm-2 control-label">Telepon</label>
			<input required="required" type="text" value="<? if(isset($data)) echo $data['phone'];?>" class="span3" name="phone" id="phone">
		</div>
		<?$buy_item = $this->session->userdata("buy_item")?>
		<?if(!empty($buy_item)):?>
			<div class="form-group">
				<label class="col-sm-2 control-label">Order</label>
				<div class="col-sm-10">
					<div class="col-sm-12 text-right" style="margin-bottom:10px;">
						<a class="btn btn-danger" href="<?= base_url();?>clear-order">Clear Order</a>
					</div>
					<div class="col-sm-12 text-right">
						<table class="table table-bordered">
							<tr>
								<th style="width:10%">Action</th>
								<th style="width:30%">Name</th>
								<th style="width:20%">Detail</th>
								<th>Price</th>
								<th>Qty</th>
								<th>Sub Total</th>
							</tr>
							<?$sum = 0?>
							<?foreach($buy_item as $row){?>									
									<?foreach($row['detail'] as $value){?>
										<tr>
											<td style="vertical-align:middle;text-align:center;">
													<a onclick="return(confirm('Anda yakin akan menghapus item <?=$row['name_barang']?> - <?=$value['information']?>'))" href="<?=base_url()?>delete-one-item?id_barang=<?=$row['id']?>&information=<?=$value['information']?>" class="btn btn-danger btn-small">Delete</a>
											</td>
											<td><a href="<?=base_url()?><?= create_title($row['name_barang'])?>"><?= $row['name_barang']?></a></td>
											<td><?= $value['information']?></td>
											<td style="text-align:right;"><?= number_format($value['price'],0,',','.')?></td>
											<td><?= $value['qty']?></td>
											<?$sum += $value['qty'] * $value['price']?>
											<td style="text-align:right;"><?= number_format($value['qty'] * $value['price'],0,',','.')?></td>
										</tr>
									<?}?>
								<?}?>
								<tr>
									<td style="text-align:right;" colspan="5"><b>Total</b></td>
									<td style="text-align:right;"><?= number_format($sum,0,',','.')?></td>
								</tr>
							
							</table>
							<!--
							<label class="col-sm-12 control-label" style="text-align:left;padding:0">Note For <?= $row['name_merchant']?></label>
							<textarea style="resize: none;" rows="5" class="form-control" name="note[<?= $row['name_merchant']?>]" placeholder="Your Note"><? if(isset($data)) echo $data['note'][$row['name_merchant']];?></textarea><br/>
							-->
							
					</div>					
				</div>
			</div>
		<?else:?>
			<div class="form-inline">
				<label class="control-label">Order</label>
				<input type="text" value="You must add item to chart first." class="span3" readonly>
			</div>
		<?endif?>
		<div class="form-inline">
			<label class="col-sm-2 control-label">Shipment By</label>
			<select name="shipment_by" id="shipment_by" class="form-control">
				<option value="JNE" <?= isset($data) ? $data['shipment_by'] == "JNE" ? "selected" : "" : ""?>>JNE</option>
				<option value="TIKI" <?= isset($data) ? $data['shipment_by'] == "TIKI" ? "selected" : "" : ""?>>TIKI</option>
				<option value="POS Indonesia" <?= isset($data) ? $data['shipment_by'] == "POS Indonesia" ? "selected" : "" : ""?>>POS Indonesia</option>
			</select>
		</div>
		<div class="form-inline" style="padding-left:155px;">
			<?php echo $captcha['image']; ?><br/>&nbsp;<br/>
			<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>
		</div>
		<div class="form-inline">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<input type="submit" class="btn btn-success" value="Kirim Order">
			<a class="btn btn-danger" href="<?= base_url();?>order-list">Batal</a>
		</div>
		<div class="form-group">
			
			<div class="col-sm-10">
				
			</div>
		</div>
	</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>