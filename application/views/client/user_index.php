<style>
	.tab-pane{
		padding-top:20px;
	}
</style>
<h1>User</h1>
<ul class="nav nav-tabs" id="myTab">	
	<li class="active"><a href="#user" data-toggle="tab" >User</a></li>	
	<li><a href="#cari">Cari User</a></li>
</ul>
<div class="tab-content">	
	<div class="tab-pane active" id="user">	
		<table class="table table-striped table-bordered" align="center">
			<thead>
				<tr>
					<th width="30%"><center>Nama Lengkap</center></th>
					<th width="30%"><center>Email</center></th>
					<th width="10%"><center>Role</center></th>
					<th width="30%"><center>Action</center></th>
				</tr>
			</thead>
			<tbody>
				<? if ((count($dafkomen) > 0)){ ?>
					<? foreach($dafkomen as $row){?>
					<tr>
						<td><?= trim($row->first_name." ".$row->last_name)?></td>
						<td><?= $row->email?></td>
						<td><?= $row->role_name?></td>
						<td>
							<center>
								<a href="<?= base_url()?>user/edit/<?= $row->id?>" class="btn btn-success btn-xs">Ubah</a>
								<a href="<?= base_url()?>user/reset_password/<?= $row->id?>" onclick="return(confirm('Yakin Reset Password?'))" class="btn btn-warning btn-xs">Reset</a>
								<?if($row->confirmation_email == 1):?>
									<a href="<?= base_url()?>user/block/<?= $row->id?>" onclick="return(confirm('Yakin akan memblockir account <?= trim($row->first_name." ".$row->last_name)?>?'))" class="btn btn-danger btn-xs">Block</a>
								<?else:?>
									<a href="<?= base_url()?>user/unblock/<?= $row->id?>" onclick="return(confirm('Yakin akan membuka blockir account <?= trim($row->first_name." ".$row->last_name)?>?'))" class="btn btn-danger btn-xs">Unblock</a>
								<?endif?>
							</center>
						</td>
					</tr>
					<?}?>
				<?}else{?>
					<tr>
						<td  colspan="4"><center>Belum ada data user</center></td>
					</tr>
				<?}?>
			</tbody>
		</table>
	</div>
	<div class="tab-pane" id="cari">
		<form class="form-horizontal" method="get" action="<?= base_url()?>user">
			<h2>Pencarian User</h2>
			<div class="form-group">
				<label class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<div class="col-sm-3" style="padding:0px;">
						<input type="text" value="" class="form-control" name="search_email">
					</div>
				</div>
			</div>
			<!--
			<div class="form-group">
				<label class="col-sm-2 control-label">Nama Lengkap</label>
				<div class="col-sm-10">
					<div class="col-sm-3" style="padding:0px;">
						<input type="text" value="" class="form-control" name="search_nama_lengkap">
					</div>
				</div>
			</div>
			-->
			<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
					<input type="submit" value="Cari" class="btn btn-success">
				</div>
			</div>
		</form>
	</div>
</div>
<script>	
	$(function () {		
		$('#myTab a').click(function (e) {		  
			e.preventDefault();		  
			$(this).tab('show');		
		});		
	})
</script>