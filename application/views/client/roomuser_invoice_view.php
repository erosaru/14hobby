<?if($this->session->userdata("role_id") == 1 && $dafkomen[0]->status == "PROCCESS SHIPMENT"):?>
	<script>
		function printDiv(divname){
			var oldstr = document.body.innerHTML;
			$("#print div[class='form-inline']").css("font-size", "30px");
			$("#print div label").css("width", "200px");
			$("#print div label").css("display", "inline-block");
			var headstr = "<html><head><title>Booking Details</title></head><body>";
			var footstr = "</body>";
			var newstr = document.getElementById(divname).innerHTML;
			
			document.body.innerHTML = headstr+newstr+footstr;		
			window.print();
			document.body.innerHTML = oldstr;
			return false;
		}
	</script>
<?endif;?>
<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<div class="span12">
	<div class="span6">
		<div id="print">
			<div class="form-inline">
				<label>Untuk</label>
				: <?= $dafkomen[0]->send_to;?>
			</div>
			<div class="form-inline">
				<label>Alamat</label>
				: <?= $dafkomen[0]->address_destination;?>
			</div>
			<div class="form-inline">
				<label>Kota / Provinsi</label>
				: <?= $dafkomen[0]->shipping_to;?>
			</div>
			<div class="form-inline">
				<label>Phone</label>
				: <?= $dafkomen[0]->phone;?>
			</div>
		</div>				
		<div>
			<div class="form-inline">
				<label>Shipment By</label>
				: <?= $dafkomen[0]->shipment_by;?>			
			</div>
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
	<div class="span6">
		<div class="form-inline text-right">
			<?if(($this->session->userdata("role_id") == 1)):?>
				<?if($dafkomen[0]->status == "PROCCESS SHIPMENT"):?>
					<a onclick="printDiv('print')" class="btn btn-primary btn-small">Print Data Shipment</a>
				<?endif?>						
			<?endif?>
		</div>
		<div class="form-inline">
			<label>Customer</label>
			: <?= $dafkomen[0]->nama_lengkap;?>			
		</div>
		<div class="form-inline">
			<label>No Invoice</label>
			: INV<?= $dafkomen[0]->invoice?>
		</div>
		<div class="form-inline">
			<label>Status</label>
			: <?= $dafkomen[0]->status;?>			
		</div>
		<?if(!empty($dafkomen[0]->transfer_to)):?>			
			<div class="form-inline">
				<label>Transfer ke</label>
				: <?= $dafkomen[0]->transfer_to;?>			
			</div>
		<?endif?>
		
		<?if(!empty($dafkomen[0]->number_shipment)):?>			
			<div class="form-inline">
				<label>Number</label>
				: <?= $dafkomen[0]->number_shipment;?>			
			</div>
		<?endif?>
	</div>
</div>
<div class="span12" style="padding:0;">
	<?if(($this->session->userdata("role_id") == 1)):?>
		<?if($dafkomen[0]->status == "PROCCESS SHIPMENT" && empty($dafkomen[0]->number_shipment)):?>
			<form class="col-sm-12 form-inline" method="post" action="<?= base_url()."save-shipment"?>" style="padding:0">
				<div class="form-inline  form-group-sm">
					<label>Number</label>
					<input required="required" placeholder="Number Shipment" type="text" class="form-control" name="number_shipment" id="number_shipment">
					<input type="hidden" value="<?= $dafkomen[0]->invoice?>" name="invoice">
					<input required="required" class="btn btn-success btn-small" type="submit" value="Save">
				</div>
			</form>
		<?endif?>						
	<?endif?>
	<table class="table table-bordered">
		<thead>
			<tr>					
				<th width="30%">Name</th>
				<th width="30%">Detail</th>
				<th width="20%">Price (IDR)</th>
				<th width="10%">Qty</th>
				<th width="20%">Sub Total (IDR)</th>
			</tr>						
		</thead>
		<tbody>
			<?foreach($dafkomen_detail as $row){?>
				<tr>
					<td><?= $row->name?></td>
					<td><?= $row->information?></td>
					<td><?= number_format($row->price_actual,0,',','.')?></td>
					<td><?= $row->qty_actual?></td>
					<td style="text-align:right;"><?= number_format($row->sub_total,0,',','.')?></td>
				</tr>
			<?}?>
			<tr>
				<td style="text-align:right;" colspan="4">Total Sub</td>
				<td style="text-align:right;"><?= number_format($dafkomen[0]->total_sub_total,0,',','.')?></td>
			</tr>
			<?if($dafkomen[0]->discount_percent > 0):?>
				<tr>
					<td style="text-align:right;" colspan="4">Diskon (-)</td>
					<td style="text-align:right;"><?= number_format($dafkomen[0]->discount,0,',','.')?></td>
				</tr>
				<tr>
					<td style="text-align:right;" colspan="4">Total sesudah diskon</td>
					<td style="text-align:right;"><?= number_format($dafkomen[0]->total_after_discount,0,',','.')?></td>
				</tr>
			<?endif?>
			<tr>
				<td style="text-align:right;" colspan="4">Biaya kirim dari <?= $dafkomen[0]->shipping_from?> ke <?= $dafkomen[0]->shipping_to?> (+)</td>
				<td style="text-align:right;"><?= ($dafkomen[0]->shipping_cost == 0) ? "FREE" : number_format($dafkomen[0]->shipping_cost,0,',','.')?></td>
			</tr>
			<tr>
				<td style="text-align:right;" colspan="4">Total yang dibayar</td>
				<td style="text-align:right;"><?= number_format($dafkomen[0]->total,0,',','.')?></td>
			</tr>
		</tbody>
	</table>
</div>			
<div class="span12" style="margin-bottom:40px;">
	<div class="col-sm-1"></div>
	<div class="col-sm-10 text-center">
		<?if($this->router->fetch_method() == "invoice_calculate"):?>
			<form action="<?= base_url()?>submit-invoice" method="post">
				<input type="hidden" name="invoice" value='<?= $dafkomen[0]->invoice?>'>
				<input type="submit" class="btn btn-success" value="Submit">
				<a class="btn btn-danger" href="<?= base_url();?>invoice-form/<?= $dafkomen[0]->invoice?>">Recalculate</a>
			</form>
		<?else:?>
			<?if($this->session->userdata("role_id") == 1):?>
				<a class="btn btn-primary" href="<?= base_url();?>invoice-form/<?= $dafkomen[0]->invoice?>">Ubah</a>
			<?endif?>
			<a class="btn btn-danger" href="<?= base_url();?>order-list">Kembali</a>
		<?endif?>
	</div>
	<div class="col-sm-1"></div>
</div>
<div class="clearfix"></div>