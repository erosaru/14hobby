<div style="padding:20px;">
	<? if($this->session->userdata('role_id') == 2):?>
		<p class="text-right">
			
		</p>
	<?endif?>
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th ><center>Sent Report Date</center></th>
				<th ><center>Transfer To</center></th>
				<th colspan="2"><center>Total Transfer</center></th>
				
				<th colspan="2"><center>Total Invoice</center></th>
				<th ><center>Number Invoice</center></th>
				<th ><center>Status</center></th>
				<? if($this->session->userdata("role_id") == 1):?>
					<th ><center>Action</center></th>
				<?endif;?>
			</tr>
		</thead>
		<tbody>
			<? if (!empty($dafkomen)){ ?>
				<? foreach($dafkomen as $row){?>
				<tr>
					<td><center><?= date("d-m-Y H:i", strtotime($row["create_date"]))?></center></td>
					<td><center><?= $row["transfer_to"]?></center></td>
					<td style="border-right:none">Rp. </td>
					<td style="border-left:none;text-align:right"><?= number_format($row["total_transfer"],0,',','.')?></td>
					<td style="border-right:none">Rp. </td>
					<td style="border-left:none;text-align:right"><?= number_format($row["xtotal_invoice"],0,',','.')?></td>
					<td><?= $row['invoice']?></td>
					<td><center><?= $row['status']?></center></td>
					<? if($this->session->userdata("role_id") == 1):?>
						<td>
							<center>
								<?if($row['status'] != "HAS CHECKED"):?>
									<a class="btn btn-xs btn-primary" href="<?=base_url()?>view-payment/<?= $row['id']?>">view</a>
								<?endif?>
							</center>
						</td>
					<?endif;?>
				</tr>
				<?}?>
			<?}else{?>
				<tr>
					<td  colspan="9"><center>Tidak ada report payment yang harus diperiksa</center></td>
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
</div>