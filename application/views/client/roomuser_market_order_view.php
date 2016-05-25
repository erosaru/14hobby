<div>
	<div class="col-md-12 text-right">
			<?if(($this->session->userdata("role_id") == 2)):?>
				<?if(($dafkomen[0]->status == "WAITING INVOICE")):?>
					<a href="<?= base_url()?>invoice-form/<?= $dafkomen[0]->invoice?>" class="btn btn-primary">Buat Tagihan</a>
				<?endif?>				
			<?endif?>
			<?if(($this->session->userdata("role_id") == 1) && ($dafkomen[0]->status == "PAYMENT SENT")):?>
				<a href="" class="btn btn-primary">Report Get Money</a>
			<?endif?>
	</div>
	<div class="col-md-6">
		<div>
			<div class="form-inline">
				<label>Order Number</label>
				: ORD<?= $dafkomen[0]->invoice;?>
			</div>
		</div>
		<?if($this->session->userdata("role_id") == 2):?>
			<div>
				<div class="form-inline">
					<label>Buyer</label>
					: <?= $dafkomen[0]->send_to;?>
				</div>
				<div class="form-inline">
					<label>Alamat</label>
					: <?= $dafkomen[0]->address_destination;?>
				</div>
				<div class="form-inline">
					<label>Telepon</label>
					: <?= $dafkomen[0]->phone;?>
				</div>
			</div>
		<?endif;?>
		<div>
			<div class="form-inline">
				<label>Shipment By</label>
				: <?= $dafkomen[0]->shipment_by;?>
			</div>
		</div>
		<div>
			<div class="form-inline">
				<label>Note</label>
				: 
				<?if(!empty($dafkomen[0]->note)):?>
					<p>
						<?= $dafkomen[0]->note;?>
					</p>
				<?endif?>
			</div>
		</div>
		
	</div>
	<div class="col-md-6">
		<div class="form-inline">
			<label>Seller</label>
			: <?= !empty($dafkomen[0]->name_merchant) ? $dafkomen[0]->name_merchant : trim($dafkomen[0]->merchant_first_name." ".$dafkomen[0]->merchant_last_name);?>			
		</div>
		<!--
		<div>
			<div class="form-inline">
				<label>Buyer</label>
				: <?= $dafkomen[0]->buyer_first_name;?> <?= $dafkomen[0]->buyer_last_name;?>
			</div>
		</div>
		-->
		<div class="form-inline">
			<label>Status</label>
			: <?= $dafkomen[0]->status;?>			
		</div>
	</div>
</div>
<div>
	<div class="col-md-12">
		<div class="form-inline">
			<label>Order</label>
			: 
			<p>
				<table class="table table-bordered">
					<tr>
						<td>Name</td>
						<td>QTY</td>
						<td colspan="2">Price</td>
					</tr>
					<?foreach($dafkomen_detail as $row){?>
						<tr>
						<td><?= $row->name?><?= $row->information == "none" || empty($row->information) ? "" : " - ".$row->information?></td>
						<td><?= $row->qty?></td>
						<td style="border-right:none;">Rp </td>
						<td class="text-right" style="border-left:none;"><?= number_format($row->price,0,',','.')?></td>
						</tr>
					<?}?>
				</table>
			</p>
			<p class="text-center">
				<a class="btn btn-danger" href="<?=base_url()?>list-order">Kembali</a>
			</p>
		</div>
	</div>
	<!--
	<div class="col-md-12">
		<div class="form-inline">
			<label>Comment<span style="font-weight:0">:</span></label>
		</div>
		<form action="<?= base_url()?>save_comment" method="post">
			<div class="form-group">
				<div class="col-sm-12" style="padding:0px;">
					<textarea required="required" style="resize: none;" rows="5" class="form-control" name="comment" id="comment" placeholder="Your Comment"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12" style="padding-left:0px;padding-right:0px;">
					<center>
					<br/>&nbsp; <?php echo $captcha['image']; ?><br/>&nbsp;<br/>&nbsp; <input required="required" class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8"><input type="hidden" value="<?= $dafkomen[0]->id?>" name="order_id"><br/>&nbsp;<br/>&nbsp;<input type="submit" class="btn btn-success" value="Add Comment"><br/>&nbsp;
					</center>
				</div>
			</div>
			
		</form>
	</div>
	-->
</div>
<div class="clearfix"></div>