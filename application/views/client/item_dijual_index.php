<h1>PreOrder Item</h1>
<a class="btn btn-primary pull-right" href="<?= base_url();?>item/createitemdijual">Buat Baru</a><br/>&nbsp;
<ul class="nav nav-tabs" id="myTab">
	<li class="active"><a href="#item" data-toggle="tab" >Item</a></li>
	<li><a href="#cari">Cari Barang</a></li>	
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="item">
		<table class="table table-striped table-bordered" align="center">
			<thead>
				<tr>
					<th width="20%" style="vertical-align:middle;"><center>Nama Item</center></th>
					<th width="10%" style="vertical-align:middle;"><center>Kategori</center></th>
					<th width="10%" style="vertical-align:middle;"><center>Merk</center></th>
					<th width="10%" style="vertical-align:middle;"><center>Tipe</center></th>
					<th width="10%" style="vertical-align:middle;"><center>Date End<br/>Pre Order</center></th>
					<th width="10%" style="vertical-align:middle;"><center>Slot</center></th>
					<th width="10%" style="vertical-align:middle;"><center>Use</center></th>
					<th width="15%" style="vertical-align:middle;"><center>Action</center></th>
				</tr>
			</thead>
			<tbody>
				<? if (($dafkomen > 0)){ ?>
					<? foreach($dafkomen as $row){?>
						<? $date1 = new DateTime(date("Y-m-d")); ?>
						<? $date2 = new DateTime($row->date_pre_order); ?>
						<?if($date2 > $date1):?>
							<?$color = "style='color:green;'"?>
						<?else:?>
							<?$color = "style='color:red;'"?>
						<?endif?>
						<tr>
							<td <?=$color?>><?= $row->name_barang?></td>
							<td <?=$color?>><?= $row->name_kategori?></td>
							<td <?=$color?>><?= $row->name_merk?></td>
							<td <?=$color?>><?= $row->type_produk?></td>
							<td <?=$color?>><?= $row->date_pre_order ? show_tanggal($row->date_pre_order) : "&nbsp;"?></td>
							<td <?=$color?>><?= $row->slot?></td>
							<td <?=$color?>><?= $row->use_slot?></td>
							<td ><center><a href="<?= base_url()?>item/edititemdijual/<?= $row->id?>" class="btn btn-primary btn-xs">Ubah</a> <a href="<?= base_url()?>item/showitemdijual/<?= $row->id?>" class="btn btn-success btn-xs">View</a> <a onclick="return(confirm('yakin mau dihapus?'))" href="<?= base_url()?>item/deleteitemdijual/<?= $row->id?>" class="btn btn-danger btn-xs">Delete</a></center></td>
						</tr>
					<?}?>
				<?}else{?>
					<tr>
						<td  colspan="6"><center>Belum ada barang dijual</center></td>
					</tr>
				<?}?>
			</tbody>
		</table>
		<?php echo $page;?>
	</div>	
	<div class="tab-pane" id="cari">
		<form style="padding:2px 10px;border:1px solid grey;border-radius:10px;" id="form_kategori" class="form" method="get" action="<?= base_url()?>item/itemdijual">
			<h2>Pencarian Barang</h2>
			<div class="form-inline">
				<label>Merk</label>
				<?= form_dropdown('id_merk', $merk, "", "id='id_merk'");?>	
			</div>
			<div class="form-inline">
				<label>Kategori</label>
				<?= form_dropdown('id_kategori', $tipe, "", "id='id_kategori'");?>
			</div>
			<div class="form-inline">
				<label>Kata Kunci</label>
				<input type="text" value="" class="input-large" name="kata_kunci" id="kata_kunci">
			</div>
			<div class="form-inline">
				<a class="btn btn-success" onclick="$('#form_kategori').submit();" href="javascript:void(0)">Cari</a>
			</div>
		</form>
	</div>
<script>
	$(function () {
		$('#myTab a').click(function (e) {
		  e.preventDefault();
		  $(this).tab('show');
		});
		ganti_merk($("#id_kategori"));	
	})
	
	function ganti_merk(obj){
		$("#id_sub_kategori").prop("readonly",true);
		$.post("<?php echo base_url(); ?>item/ganti_merk/", {id : obj.val()}, function(hasil){
			//console.log(hasil);
			$("#id_sub_kategori").replaceWith(hasil);			
			ganti_tipe($('#id_sub_kategori'));
		});				
	}
	
	function ganti_tipe(obj){
		$("#id_type_produk").prop("readonly",true);
		$.post("<?php echo base_url(); ?>item/ganti_tipe/", {id_sub_kategori : obj.val(), id_kategori : $("#id_kategori").val()}, function(hasil){
			$("#id_type_produk").replaceWith(hasil);
		});				
	}
</script>
