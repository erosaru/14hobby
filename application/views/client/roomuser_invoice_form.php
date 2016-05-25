<style>
	.form-inline{
		margin-bottom:10px;
	}
	
	.title{
		font-weight:bold;
	}
</style>

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
	<div class="form-inline">
		<label class="title">Invoice Form</label>
	</div>
	<div class="form-inline">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th style="width:40%">Name</th>
					<th style="width:20%">Detail</th>
					<th style="width:10%">QTY</th>
					<th>Price(Rp)</th>
				</tr>						
			</thead>
			<tbody>
				<?foreach($dafkomen_detail as $row){?>
					<tr>
						<td><?= $row->name?></td>
						<td><?= $row->information?></td>
						<td><?= $row->qty?><input type="hidden" name="qty[<?= $row->id?>]" value='<?= $row->qty?>'></td>
						<td><input class="text-right" required="required" type="text" name="price[<?= $row->id?>]" value='<?= $row->price?>' onkeypress="validate_number_integer_only(event)"></td>								
					</tr>
				<?}?>
				<tr>
					<td class="text-right" colspan="3">Discount(%)</td>
					<td><input onkeypress="validate_number_integer_only(event)" required="required" type="text" name="discount_percent" value='<?= (isset($data)) ? $data['discount'] : $dafkomen[0]->discount_percent ?>'></td>
				</tr>						
				<tr>
					<td class="text-right" colspan="3">Shipping From</td>
					<td><?= $dafkomen[0]->shipping_from?></td>
				</tr>
				<tr>
					<td class="text-right" colspan="3">Shipping To</td>
					<td><?= $dafkomen[0]->shipping_to?></td>
				</tr>
				<tr>
					<td class="text-right" colspan="3">Shipping By</td>
					<td><?= $dafkomen[0]->shipment_by?></td>
				</tr>
				<tr>
					<td class="text-right" colspan="3">Shipping Cost(Rp)</td>
					<td><input onkeypress="validate_number_integer_only(event)" required="required" type="text" name="shipping_cost" value='<?= (isset($data)) ? $data['shipping_cost'] : $dafkomen[0]->shipping_cost?>'></td>
				</tr>
			</tbody>
		</table>
	</div>			
		<div class="form-group">
			<div class="span1"></div>
			<div class="span10">
				<input type="hidden" name="invoice" value='<?= $dafkomen[0]->invoice?>'>
				<input type="submit" class="btn btn-success" value="Calculate">
				<a class="btn btn-danger" href="<?= base_url();?>view-order/<?= $dafkomen[0]->invoice?>">Cancel</a>
			</div>
			<div class="span1"></div>
		</div>
</form>
<div class="span2"></div>
<div class="clearfix"></div>