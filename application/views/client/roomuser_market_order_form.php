<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<form id="form_account_bank" class="form-horizontal" method="post" action="<?= base_url()."send-order"?>">
		<div class="form-group">
			<label class="col-sm-2 control-label text-primary">Order Form</label>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Send To</label>
			<div class="col-sm-10">
				<div class="col-sm-10" style="padding:0px;">
					<input required="required" type="text" value="<? if(isset($data)) echo $data['send_to']; elseif(isset($user)) echo trim($user[0]->first_name.' '.$user[0]->last_name)?>" class="form-control" name="send_to" id="send_to">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Address</label>
			<div class="col-sm-10">
				<div class="col-sm-10" style="padding:0px;">
					<input required="required" type="text" value="<? if(isset($data)) echo $data['address_destination'];elseif(isset($user)) echo trim($user[0]->address)?>" class="form-control" name="address_destination" id="address_destination">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">City</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input required="required" type="text" value="<? if(isset($data)) echo $data['shipping_to'];elseif(isset($user)) echo trim($user[0]->city)?>" class="form-control" name="shipping_to" id="shipping_to">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Phone</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input required="required" type="text" value="<? if(isset($data)) echo $data['phone'];elseif(isset($user)) echo trim($user[0]->phone)?>" class="form-control" name="phone" id="phone">
				</div>
			</div>
		</div>		
		<div class="form-group">
			<label class="col-sm-2 control-label">Order</label>
			<div class="col-sm-10 ">
				<?if(count($this->session->userdata("buy_item")) > 0):?>
					<div class="col-sm-12 text-right" style="margin-bottom:10px;">
						<a class="btn btn-danger" href="<?= base_url();?>clear-order">Hapus Order</a>
					</div>
					<div class="col-sm-12 text-right">
						<?foreach($this->session->userdata("buy_item") as $row){?>
							<table class="table table-bordered" style="width:98%;">
								<tr>
									<td width="20%"><b>Merchant</b></td>
									<td colspan="4"><?= $row['name_merchant']?></td>
								</tr>
								<tr>
										<th>Name</th>
										<th>Price</th>
										<th>Qty</th>
										<th>Sub Total</th>
								</tr>
								<?$sum = 0?>
								<?foreach($row['item'] as $value){?>			
									<tr>
										<td width="40%"><?= $value['name']?></td>
										<td><?= number_format($value['price'],0,',','.')?></td>
										<td><?= $value['qty']?></td>
										<?$sum += $value['qty'] * $value['price']?>
										<td class="text-right"><?= number_format($value['qty'] * $value['price'],0,',','.')?></td>
									</tr>
								<?}?>
								<tr>
									<td class="text-right" colspan="3"><b>Total</b></td>
									<td class="text-right"><?= number_format($sum,0,',','.')?></td>
								</tr>
							</table>
							<label class="col-sm-12 control-label" style="text-align:left;padding:0">Note For <?= $row['name_merchant']?></label>
							<textarea style="resize: none;" rows="5" class="form-control" name="note[<?= create_title($row['name_merchant'])?>]" placeholder="Your Note"><? if(isset($data)) echo $data['note'][create_title(trim($row['name_merchant']))];?></textarea><br/>
							<!--
							<label class="col-sm-12 control-label" style="text-align:left;padding:0">Shipment <?= $row['name_merchant']?></label>
							<div class="col-sm-2" style="padding:0px;">
								<select name="shipment_by[<?= create_title($row['name_merchant'])?>]" id="shipment_by" class="form-control">
									<option value="JNE" <?= isset($data) ? $data['shipment_by'][create_title($row['name_merchant'])] == "JNE" ? "selected" : "" : ""?>>JNE</option>
									<option value="TIKI" <?= isset($data) ? $data['shipment_by'][create_title($row['name_merchant'])] == "TIKI" ? "selected" : "" : ""?>>TIKI</option>
									<option value="POS Indonesia" <?= isset($data) ? $data['shipment_by'][create_title($row['name_merchant'])] == "POS Indonesia" ? "selected" : "" : ""?>>POS Indonesia</option>
								</select><br/>
							
							</div>--><div class="clearfix"></div>
						<?}?>
					</div>
				<?else:?>
					<div class="col-sm-4" style="padding:0px;">
						<input type="text" value="You must add item to chart first." class="form-control" readonly>
					</div>
				<?endif?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-10">
				<?php echo $captcha['image']; ?><br/>&nbsp;<br/>
				<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-10">
				<input type="submit" class="btn btn-success" value="Kirim Order">
				<a class="btn btn-danger" href="<?= base_url();?>list-order">Batal</a>
			</div>
		</div>
	</form>
<div class="clearfix"></div>