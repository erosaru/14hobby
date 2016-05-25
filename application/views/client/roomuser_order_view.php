<div>
	<div class="span12 text-right">
			<?if(($this->session->userdata("role_id") == 1)):?>
				<?if(($dafkomen[0]->status == "WAITING INVOICE")):?>
					<a href="<?= base_url()?>invoice-form/<?= $dafkomen[0]->invoice?>" class="btn btn-primary">Create Invoice</a>
				<?endif?>				
			<?endif?>
	</div>
	<div class="span6">
		<div class="form-inline">
			<label>Untuk</label>
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
	<div class="span6">
		<div>
			<div class="form-inline">
				<label>Customer</label>
				: <?= $dafkomen[0]->nama_lengkap;?> 
			</div>
		</div>
		<div>
			<div class="form-inline">
				<label>No Order</label>
				: ORD<?= $dafkomen[0]->invoice;?>
			</div>
		</div>
		<div class="form-inline">
			<label>Status</label>
			: <?= $dafkomen[0]->status;?>			
		</div>
	</div>
</div>
<div>
	<div class="span12">
		<div class="form-inline">
			<label>Order</label>
			: 
			<p>
				<table class="table table-bordered">
					<tr>
						<th style="width:40%">Name</th>
						<th style="width:20%">Detail</th>
						<th style="width:10%">QTY</th>
						<th>Price</th>
					</tr>
					<?foreach($dafkomen_detail as $row){?>
						<tr>
							<td><?= $row->name?></td>
							<td><?= $row->information?></td>
							<td><?= $row->qty?></td>
							<td style="text-align:right;"><?= number_format($row->price,0,',','.')?></td>
						</tr>
					<?}?>
				</table>
			</p>
			<p class="text-center">
				<a class="btn btn-danger" href="<?=base_url()?>order-list">Back</a>
			</p>
		</div>
	</div>	
</div>
<div class="clearfix"></div>