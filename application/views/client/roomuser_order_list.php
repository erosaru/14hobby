	<div class="span12" style="padding:0px;">
		<div style="padding:0px;width:50%;float:left">
			<p class="btn-group" role="group">
				<a href="<?= base_url()?>order-list" class="btn btn-default" style="width:100px;">On Progress</a>
				<a href="<?= base_url()?>order-list?status=all" class="btn btn-default" style="width:100px;">All Order</a>
			</p>
		</div>
		<div style="padding:0px;width:50%;float:left">
			<? if($this->session->userdata('role_id') == 2):?>
				<p class="text-right">
					<a class="btn btn-primary" href="<?= base_url();?>report-your-payment">Kirim Report Payment</a>&nbsp;
					<a class="btn btn-primary" href="<?= base_url();?>order-form">Kirim Order</a>&nbsp;
				</p>
			<?endif?>			
		</div>
	</div>
	<div class="clearfix"></div>
	
	
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th ><center>Number Voice</center></th>
				<?if($this->session->userdata("role_id") == 1):?>
					<th ><center>Customer</center></th>
				<?endif?>
				<th ><center>Order Date</center></th>
				<th ><center>Status</center></th>
				<th ><center>Action</center></th>
			</tr>
		</thead>
		<tbody>
			<? if (count($dafkomen) > 0){ ?>
				<? foreach($dafkomen as $row){?>
				<tr class="row-<?= create_title(strtolower($row->status))?>">
					<td><center>ORD<?= $row->invoice?></center></td>
					<?if($this->session->userdata("role_id") == 1):?>
						<td><center><?= $row->nama_lengkap?></center></td>
					<?endif?>
					<td><center><?= showtime($row->created_date)?></center></td>
					<td class="status"><center><?= $row->status=="PROCCESS SHIPMENT" && !empty($row->number_shipment) ? $row->shipment_by." - ".$row->number_shipment : $row->status?></center></td>
					<td>
						<center>
							<?if(empty($row->invoice_create_date)):?>
								<a href="<?= base_url();?>view-order/<?= $row->invoice?>" class="btn btn-warning btn-small">View</a>
							<?else:?>
								<a href="<?= base_url();?>view-invoice/<?= $row->invoice?>" class="btn btn-primary btn-small">Invoice</a>
							<?endif;?>
							<?if(!empty($row->number_shipment) && $row->status == "PROCCESS SHIPMENT" && $this->session->userdata("role_id") == "2"):?>
								<form action="<?= base_url();?>get-item" style="display:inline-block;padding:0px;margin:0px;" method="post">
									<input type='hidden' name="invoice" value="<?= $row->invoice?>">
									<input type='submit' onclick="return(confirm('Anda yakin sudah mendapatkan semua barang yang diorder?'))" class="btn btn-success btn-small" value="Get Item">
								</form>
							<?endif;?>
						</center>
					</td>
				</tr>
				<?}?>
			<?}else{?>
				<tr>
					<td  colspan="<?= $this->session->userdata("role_id") == 1 ? "6" : "5"?>"><center>Anda tidak memiliki order</center></td>
				</tr>
			<?}?>
		</tbody>
	</table>
	<?if(isset($links)):?>
		<nav>
			<ul class="pagination">
				<?= $links ?>
			</ul>
		</nav>
	<?endif?>
