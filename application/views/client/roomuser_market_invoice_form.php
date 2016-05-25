<script>
	function validate_number_integer_only(evt) {
		  var theEvent = evt || window.event;
		  var key = theEvent.keyCode || theEvent.which;
		  key = String.fromCharCode( key );
		  var regex = /[0-9]|[\b]|\t/;
		  if (key.keyCode != 8)
			  if( !regex.test(key)) {
				theEvent.returnValue = false;
				if(theEvent.preventDefault) theEvent.preventDefault();
			  }
	}	
</script>

<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<form id="form_account_bank" class="form-horizontal" method="post" action="<?= base_url()."invoice-calculate"?>">
		<div class="form-group">
			<label class="col-sm-2 control-label text-primary">Invoice Form</label>
		</div>
		<div class="form-group">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
				<div>
					<div class="form-inline">
						<label>Order Number</label>
						: ORD<?= $dafkomen[0]->invoice;?>
					</div>
				</div>
				<div>
					<div class="form-inline">
						<label>Buyer</label>
						: <?= $dafkomen[0]->send_to;?>
					</div>
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="50%">Name</th>
							<th>Qty</th>
							<th>Price(Rp)</th>							
						</tr>						
					</thead>
					<tbody>
						<?foreach($dafkomen_detail as $row){?>
							<tr>
								<td><?= $row->name?><?= $row->information == "none" || empty($row->information) ? "" : " - ".$row->information?></td>
								<td width="15%"><?= $row->qty?><input type="hidden" name="qty[<?= $row->id?>]" value='<?= $row->qty?>'></td>
								<td width="15%"><input class="text-right form-control" required="required" type="text" name="price[<?= $row->id?>]" value='<?= $row->price?>' onkeypress="validate_number_integer_only(event)"></td>								
							</tr>
						<?}?>
						<tr>
							<td class="text-right" colspan="2">Discount(%)</td>
							<td><input class="form-control" style="text-align:right;" onkeypress="validate_number_integer_only(event)" required="required" type="text" name="discount_percent" value='<?= (isset($data)) ? $data['discount'] : "0" ?>'></td>
						</tr>						
						<tr>
							<td class="text-right" colspan="2">Dari</td>
							<td><?= $dafkomen[0]->city?></td>
						</tr>
						<tr>
							<td class="text-right" colspan="2">Tujuan</td>
							<td><?= $dafkomen[0]->shipping_to?></td>
						</tr>
						<tr>
							<td class="text-right" colspan="2">Jasa Kirim</td>
							<td><input class="form-control" style="text-align:left;" required="required" type="text" name="shipment_by" value="<?= $dafkomen[0]->shipment_by ?>"></td>
						</tr>
						<tr>
							<td class="text-right" colspan="2">Shipping Cost(Rp)</td>
							<td><input class="form-control" style="text-align:right;" onkeypress="validate_number_integer_only(event)" required="required" type="text" name="shipping_cost" value='<?= !empty($dafkomen[0]->shipping_cost) ? $dafkomen[0]->shipping_cost : "0" ?>'></td>
						</tr>
					</tbody>
				</table>
			</div>			
			<div class="col-sm-1"></div>
		</div>		
		<div class="form-group">
			<div class="col-sm-1"></div>
			<div class="col-sm-10 text-center">
				<input type="hidden" name="invoice" value='<?= $dafkomen[0]->invoice?>'>
				<input type="submit" class="btn btn-success" value="Hitung">
				<a class="btn btn-danger" href="<?= base_url();?>view-order/<?= $dafkomen[0]->invoice?>">Batal</a>
			</div>
			<div class="col-sm-1"></div>
		</div>
	</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>