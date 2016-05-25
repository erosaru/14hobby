<div class="col-md-12">
	<?if($this->router->fetch_class() == "merchant"):?>
		<h1>Merchant</h1>
	<?elseif($this->session->userdata("role_id") == 0):?>
		<h1>Administrator</h1>
	<?elseif($this->router->fetch_method() == "needapprove" || $this->router->fetch_method() == "rneedapprove"):?>
		<h1>User untuk di cek</h1>
	<?elseif($this->session->userdata("role_id") == 1):?>
		<h1>Buyer</h1>
	<?endif?>
	<?if($this->session->userdata('role_id') == 0):?>
		<a class="btn btn-primary pull-right" href="<?= base_url();?>user/create">Buat Baru</a><br/>&nbsp;
	<?endif?>
	<table class="table table-striped table-bordered" align="center">
		<thead>
			<tr>
				<th width="30%"><center>Nama Lengkap</center></th>
				<th width="30%"><center>Email</center></th>
				<th width="30%"><center>Role</center></th>
				<th width="30%"><center>Action</center></th>
			</tr>
		</thead>
		<tbody>
			<? if (!empty($dafkomen)){ ?>
				<? foreach($dafkomen as $row){?>
				<tr>
					<td><?= $row->first_name?> <?= $row->last_name?></td>
					<td><?= $row->email?></td>
					<td><?= $row->role_name?></td>
					<td>
						<center>
							<?if($this->router->fetch_method() == "index"):?>
								<a href="<?= base_url()?>user/show/<?= $row->id?>" class="btn btn-success btn-xs">Show</a>
								<a href="<?= base_url()?>confirmation-forget-password/<?= $row->key_user?>" onclick="return(confirm('Anda yakin akan mereset password user ini?'))" class="btn btn-warning btn-xs">Reset Password</a>
								<!--<a href="<?= base_url()?>user/reset_password/<?= $row->id?>" onclick="return(confirm('Yakin Reset Password?'))" class="btn btn-danger btn-sm">Reset</a>-->
							<?elseif($this->router->fetch_method() == "needapprove" || $this->router->fetch_method() == "rneedapprove"):?>
								<?if($this->router->fetch_method() == "rneedapprove"):?>
									<a href="<?= base_url()?>user/rshowapprove/<?= $row->id?>" class="btn btn-warning btn-xs">Approve</a>
								<?else:?>
									<a href="<?= base_url()?>user/showapprove/<?= $row->id?>" class="btn btn-warning btn-xs">Approve</a>
								<?endif?>
							<?endif?>
							
						</center>
					</td>
				</tr>
				<?}?>
			<?}else{?>
				<tr>
					<?if($this->router->fetch_method() == "index"):?>
						<td  colspan="4"><center>Tidak ada data user</center></td>
					<?elseif($this->router->fetch_method() == "needapprove" || $this->router->fetch_method() == "rneedapprove"):?>
						<td  colspan="4"><center>Tidak ada user baru untuk dicek</center></td>
					<?endif?>
					
				</tr>
			<?}?>
		</tbody>
	</table>
</div>