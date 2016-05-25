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
	
	function calculate_total(){
		var total = 0;
		$("input[type='checkbox']").each(function() {
			if($(this).is(':checked'))
				total+= parseInt($(this).attr("total"))
		});
		$("#total_invoice").html("Total : Rp "+accounting.formatMoney(total, "", 0, ".", ","));
		$("#xtotal_invoice").val(total);
		
	}
		
	$(document).ready(function () {
		calculate_total();
		$('#datepicker').datepicker({format:"dd-mm-yyyy", clearBtn:true,autoclose:true}).on('changeDate',function(ev){calculate_room_price();calculate()});
	});
</script>
<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<form id="form_account_bank" method="post" action="<?= base_url()."send-report-payment"?>">
	<div class="span12">
		<div class="form-inline">
			<label class="title">Payment Form</label>
		</div>
		<div class="form-inline">
			<label class="control-label">Transfer ke Bank</label>
			<select name="our_bank_account_number" id="our_bank_account_number" class="span4">
				<option value="BCA - Ferry Lugiman - 139.228.642.4" <?= isset($data) ? $data['our_bank_account_number'] == "BCA - 1234121234" ? "selected" : "" : ""?>>BCA - Ferry Lugiman - 139.228.642.4</option>
			</select>
		</div>
	</div>
	<div class="span12">
		<div class="span6">
			<div class="form-inline">
				<label class="control-label">Tanggal Transfer</label>
				<input required="required" type="text" value="<?= isset($data) ? $data['date_tranfer'] : ""?>" name="date_tranfer" id="date_tranfer">
			</div>
			<div class="form-inline">
				<label class="control-label">Account Bank Anda</label>
				<input required="required" type="text" value="<?= isset($data) ? $data['customer_bank_account_name'] : ""?>" name="customer_bank_account_name" id="customer_bank_account_name">
			</div>
			<div class="form-inline">
				<label class="control-label">No Account Bank Anda</label>
				<input required="required" type="text" value="<?= isset($data) ? $data['customer_bank_account_number'] : ""?>" class="form-control" name="customer_bank_account_number" id="customer_bank_account_number">
			</div>
			<div class="form-inline">
				<label class="control-label">Total yang anda Transfer</label>
				<input required="required" type="text" value="<?= isset($data) ? $data['total_transfer'] : ""?>" class="form-control" name="total_transfer" id="total_transfer" onkeypress="validate_number_integer_only(event)">
			</div>
		</div>
		<div class="span6">
			<div class="form-group">
				<label class="col-sm-4 control-label" style="text-align:left;">Your Invoice</label>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" style="text-align:left;" id="total_invoice">Total</label>				
				<input type="hidden" name="xtotal_invoice" id="xtotal_invoice">
			</div>
			<div class="form-group">
				<div class="col-sm-12" style="padding-left:50px;">
					<?if(count($invoice_list) > 0):?>
						<table class="table table-bordered">
						<thead>
							<tr>
								<th>&nbsp;</th>
								<th>Invoice Number</th>
								<th>Invoice Date</th>
								<th>Total</th>
							</tr>
						<?foreach($invoice_list as $row):?>
							<tr>
								<td><input <?= isset($data) ? !empty($data['invoice'][$row->invoice]) ? "checked" : "" : "" ?> onclick="calculate_total()" type="checkbox" name="invoice[<?= $row->invoice?>]" total="<?= $row->total?>" value="<?=$row->invoice?>"></td>
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
			<div class="form-group">
				<label class="span2 control-label">&nbsp;</label>
				<div class="span10">
					<?php echo $captcha['image']; ?><br/>&nbsp;<br/>
					<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>
				</div>
			</div>
			<div class="form-group">
				<div class="span12 text-center">
					<input type="submit" class="btn btn-success" value="Kirim Payment">
					<a class="btn btn-danger" href="<?= base_url();?>order-list">Batal</a>
				</div>
			</div>
		</div>
	</div>
	
</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>