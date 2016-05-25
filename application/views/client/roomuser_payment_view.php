<form id="form_account_bank" method="post" action="<?= base_url()."confirm-report-payment"?>">
	<div class="span12">
		<div class="span6">
			<div class="form-inline">
				<label class="title">Payment View</label>
			</div>
			<div class="form-inline">
				<label class="control-label">Customer</label>
				<label class="control-label none-bold" style="text-align:left;">: <?= $dafkomen[0]->nama_lengkap?></label>
			</div>
			<div class="form-inline">
				<label class="control-label">Tanggal Transfer</label>
				<label class="control-label none-bold" style="text-align:left;">: <?= $dafkomen[0]->date_tranfer?></label>
			</div>
			<div class="form-inline">
				<label class="control-label">Transfer ke Bank</label>
				<label class="control-label none-bold" style="text-align:left;">: <?= $dafkomen[0]->our_bank_account_number?></label>
			</div>
			<div class="form-inline">
				<label class="col-sm-4 control-label">Account Bank Anda</label>
				<label class="col-sm-8 control-label none-bold" style="text-align:left;">: <?= $dafkomen[0]->customer_bank_account_name?></label>
			</div>
			<div class="form-inline">
				<label class="col-sm-4 control-label">No Account Bank Anda</label>
				<label class="col-sm-8 control-label none-bold" style="text-align:left;">: <?= $dafkomen[0]->customer_bank_account_number?></label>
			</div>
			<div class="form-inline">
				<label class="col-sm-4 control-label">Total yang anda Transfer</label>
				<label class="col-sm-8 control-label none-bold" style="text-align:left;">: Rp. <?= number_format($dafkomen[0]->total_transfer,0,',','.')?></label>
			</div>
		</div>
		<div class="span6">
			<div class="form-inline">
				<label class="col-sm-4 control-label" style="text-align:left;">Your Invoice</label>
				
			</div>
			<div class="form-inline">
				<label class="col-sm-4 control-label" style="text-align:left;" id="total_invoice">Total</label>				
				<label class="col-sm-8 control-label none-bold" style="text-align:left;">: Rp. <?= number_format($dafkomen[0]->xtotal_invoice,0,',','.')?></label>
			</div>
			<div class="form-inline">
				<div class="span12" style="padding-left:50px;">
					<?if(count($invoice_list) > 0):?>
						<table class="table table-bordered">
						<thead>
							<tr>
								<th>Invoice Number</th>
								<th>Invoice Date</th>
								<th>Total</th>
							</tr>
						<?foreach($invoice_list as $row):?>
							<tr>
								<td><a target="_blank" href="<?= base_url();?>view-invoice/<?= $row->invoice?>">INV<?=$row->invoice?></a></td>
								<td><?= date("d-m-Y ", strtotime($row->invoice_create_date))?></td>
								<td><?= number_format($row->total,0,',','.')?></td>
							</tr>
						<?endforeach?>
						</thead>
						<tbody>
						</tbody>
						</table>
					<?else:?>
						You don't have invoice
					<?endif?>
				</div>				
			</div>
		</div>
		<div class="span12">
			<div class="form-inline">
				<div class="span12 text-center">
					<input type="hidden" name="id" value="<?= $dafkomen[0]->id?>">
					<input onclick="return(confirm('are you sure have check this report payment and change status please shipment to all invoice in this report payment?'))" type="submit" class="btn btn-success" value="Checked">
					<a class="btn btn-danger" href="<?= base_url();?>payment-list">Cancel</a>
				</div>
			</div>
		</div>
	</div>
	
</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>