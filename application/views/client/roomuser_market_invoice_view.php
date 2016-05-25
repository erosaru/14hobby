<?if($this->session->userdata("role_id") == 2 && $dafkomen[0]->status == "PLEASE SHIPMENT"):?>
	<script>
		function printDiv(divname){
			var oldstr = document.body.innerHTML;
			$("#print div[class='form-inline']").css("font-size", "30px");
			$("#print div label").css("width", "150px");
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
<div class="col-md-12">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="col-sm-12" style="padding:0;">
			<div class="col-md-6">
				<div class="form-inline">
					<label>Seller</label>
					: <?= $dafkomen[0]->name_merchant ? $dafkomen[0]->name_merchant : trim($dafkomen[0]->first_name.' '.$dafkomen[0]->last_name);?>
				</div>
				<div id="print">
					<div class="form-inline">
						<label>Buyer</label>
						: <?= $dafkomen[0]->send_to;?>
					</div>
					<div class="form-inline">
						<label>Alamat</label>
						: <?= $dafkomen[0]->address_destination;?>
					</div>
					<div class="form-inline">
						<label>Kota</label>
						: <?= $dafkomen[0]->shipping_to;?>
					</div>
					<div class="form-inline">
						<label>Telepon</label>
						: <?= $dafkomen[0]->phone;?>
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
				<div class="form-inline text-right">
					<?if(($this->session->userdata("role_id") == 2)):?>
						<?if($dafkomen[0]->status == "PLEASE SHIPMENT"):?>
							<a onclick="printDiv('print')" class="btn btn-primary btn-xs">Print Data Shipment</a>
						<?endif?>						
					<?endif?>
				</div>
				<div class="form-inline">
					<label>Status</label>
					: <?= $dafkomen[0]->status;?>			
				</div>				
				<div class="form-inline">
					<label>Shipment By</label>
					: <?= $dafkomen[0]->shipment_by;?>			
				</div>
				<?if(!empty($dafkomen[0]->number_shipment)):?>
					
					<div class="form-inline">
						<label>Number</label>
						: <?= $dafkomen[0]->number_shipment;?>			
					</div>
				<?endif?>
			</div>
		</div>		
		<?if(($this->session->userdata("role_id") == 2)):?>
			<?if($dafkomen[0]->status == "PLEASE SHIPMENT" && empty($dafkomen[0]->number_shipment)):?>
				<div class="col-sm-12" style="padding:10px;border: 1px solid black;">
					
					<div class="col-md-12">
						<div class="form-inline">
							<label class="text-primary">Bukti Pembayaran</label>
						</div>							
						<div class="form-inline">
							<label>Dari</label>
							: <?= $dafkomen[0]->buyer_account_bank;?>			
						</div>	
						<div class="form-inline">
							<label>Untuk</label>
							: <?= $dafkomen[0]->seller_account_bank;?>			
						</div>
						<div class="form-inline">
							<label>Tanggal</label>
							: <?= show_tanggal($dafkomen[0]->date_send_money);?>			
						</div>	
						<div class="form-inline">
							<label>Jumlah Uang</label>
							: Rp <?= number_format($dafkomen[0]->amount_money,0,',','.');?>			
						</div>	
					</div>	
				
				<form class="col-sm-12 form-inline" method="post" action="<?= base_url()."save-shipment"?>" style="padding:0">
					<div class="form-group  form-group-sm">
						<label class="sr-only">Number</label>
						<div class="col-sm-8" style="padding:0;">
							<input required="required" placeholder="Number Shipment" type="text" class="form-control" name="number_shipment" id="number_shipment"><br/>
						</div>
					</div>
					<div class="form-group  form-group-sm">
						<label class="col-sm-4 control-label" style="padding:0;"></label>
						<div class="col-sm-8" style="padding:0;">
							<input type="hidden" value="<?= $dafkomen[0]->invoice?>" name="invoice">
							<input required="required" class="btn btn-success btn-sm" type="submit" value="Save">
						</div>
					</div>
				</form>
				</div>	
			<?endif?>						
		<?endif?>
		<table class="table table-bordered">
			<label class="control-label text-primary">Invoice INV<?= $dafkomen[0]->invoice?> - <?= $dafkomen[0]->name_merchant;?>			</label>
			<thead>
				<tr>
					<th width="40%">Name</th>
					<th width="20%">Price (IDR)</th>
					<th width="10%">Qty</th>
					<th width="20%">Sub Total (IDR)</th>
				</tr>						
			</thead>
			<tbody>
				<?foreach($dafkomen_detail as $row){?>
					<tr>
						<td><?= $row->name?><?= $row->information == "none" || empty($row->information) ? "" : " - ".$row->information?></td>
						<td><?= number_format($row->price_actual,0,',','.')?></td>
						<td><?= $row->qty_actual?></td>
						<td class="text-right"><?= number_format($row->sub_total,0,',','.')?></td>
					</tr>
				<?}?>
				<tr>
					<td class="text-right" colspan="3">Total Sub</td>
					<td class="text-right"><?= number_format($dafkomen[0]->total_sub_total,0,',','.')?></td>
				</tr>
				<?if($dafkomen[0]->discount_percent > 0):?>
					<tr>
						<td class="text-right" colspan="3">Discount (-)</td>
						<td class="text-right"><?= number_format($dafkomen[0]->discount,0,',','.')?></td>
					</tr>
					<tr>
						<td class="text-right" colspan="3">Total after diskon</td>
						<td class="text-right"><?= number_format($dafkomen[0]->total_after_discount,0,',','.')?></td>
					</tr>
				<?endif?>
				<tr>
					<td class="text-right" colspan="3">Biaya kirim dari <?= $dafkomen[0]->shipping_from?> ke <?= $dafkomen[0]->shipping_to?> (+)</td>
					<td class="text-right"><?= ($dafkomen[0]->shipping_cost == 0) ? "FREE" : number_format($dafkomen[0]->shipping_cost,0,',','.')?></td>
				</tr>
				<tr>
					<td class="text-right" colspan="3">Total must pay</td>
					<td class="text-right"><?= number_format($dafkomen[0]->total,0,',','.')?></td>
				</tr>
			</tbody>
		</table>
	</div>			
	<div class="col-sm-1"></div>
</div>		
<div class="col-md-12" style="margin-bottom:40px;">
	<div class="col-sm-1"></div>
	<div class="col-sm-10 text-center">
		<?if($this->router->fetch_method() == "invoice_calculate"):?>
			<form action="<?= base_url()?>submit-invoice" method="post">
				<input type="hidden" name="invoice" value='<?= $dafkomen[0]->invoice?>'>
				<input type="submit" class="btn btn-success" value="Simpan">
				<a class="btn btn-danger" href="<?= base_url();?>invoice-form/<?= $dafkomen[0]->invoice?>">Hitung Kembali</a>
			</form>
		<?else:?>
			<?if($dafkomen[0]->status == "WAITING PAYMENT" && $this->session->userdata('role_id') == 3):?>
				<script>
					$(document).ready(function () {
						$('#dp1').datepicker();
					});
				</script>
				<form method="post" class="form-horizontal" action="<?= base_url()?>status-payment/<?= $dafkomen[0]->invoice?>" >
					<div class="form-group">
						<label class="col-sm-2 control-label">Dari:</label>
						<div class="col-sm-10">
							<div class="col-sm-6" style="padding:0px;">
								<?= form_dropdown('buyer_account_bank', $buyer_bank, "", "class='form-control' id='buyer_account_bank'");?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Untuk:</label>
						<div class="col-sm-10">
							<div class="col-sm-6" style="padding:0px;">
								<?= form_dropdown('seller_account_bank', $seller_bank, "", "class='form-control' id='seller_account_bank'");?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Jumlah Uang:</label>
						<div class="col-sm-10">
							<div class="col-sm-4" style="padding:0px;">
								<input type="text" required="required" value="<? if(isset($data)) echo $data['bank_account_number'];?>" class="form-control" name="amount_money" id="amount_money">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Tanggal Transfer:</label>
						<div class="col-sm-10">
							<div id="dp1" class="dp1 input-append date" data-date="" data-date-format="dd-mm-yyyy">
								<input type="text" id="date_send_money" name="date_send_money" class="form-control" readonly size="16" style="width:100px" value= "<?if(isset($data)) echo $data['bank_account_number']; else echo date('d-m-Y');?>">
								<span class="add-on">
									<i class="icon-th"></i>
								</span>				
							</div>
						</div>
					</div>
					<input type="submit" value="BAYAR" class="btn btn-success" onclick="return(confirm('Apakah anda sudah mentransfer uang sesuai dengan jumlah pada tagihan INV<?= $dafkomen[0]->invoice?>'))">&nbsp;<a class="btn btn-danger" href="<?= base_url();?>list-order">Kembali</a>
				</form>
			<?elseif($dafkomen[0]->status == "PLEASE SHIPMENT" && $this->session->userdata('role_id') == 2 && empty($dafkomen[0]->number_shipment)):?>
				<a class="btn btn-warning" href="<?= base_url()?>status-payment/<?= $dafkomen[0]->invoice?>" onclick="return(confirm('Apakah anda yakin kalau buyer untuk INV<?= $dafkomen[0]->invoice?> belum mentransfer uang?'))">BELUM BAYAR</a>&nbsp;<a class="btn btn-danger" href="<?= base_url();?>list-order">Kembali</a>
			<?else:?>
				<a class="btn btn-danger" href="<?= base_url();?>list-order">Kembali</a>
			<?endif?>
			
		<?endif?>
	</div>
	<div class="col-sm-1"></div>
</div>
<div class="clearfix"></div>