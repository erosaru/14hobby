<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<script>
	var gambar=new Array();
	
	function clear_date(){
		$("#date_pre_order").val("");
	}
	
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

	var do_get_nama_barang = <?= !empty($dafkomen) ? "1" : "0"?>;
	function get_nama_barang(){
		$.post("<?php echo base_url(); ?>item/get_nama_barang/", {id_merk : $("#id_merk").val(), id_kategori : $("#id_kategori").val()}, function(hasil){
			if(hasil == "")
				alertify.alert("Tidak ada barang untuk merk "+$("#id_merk option:selected").text()+" dengan kategori "+$("#id_kategori option:selected").text());
			var get_nama_barang = hasil.split(',');
			var x = $("#name_barang").typeahead();
			x.data('typeahead').source = get_nama_barang;
			
			if(do_get_nama_barang == 1){
				do_get_nama_barang = 0
				return false;
			}
			
			$("#name_barang").val("");
			$("#id_barang").val("");
		});				
	}
	
	function get_id_barang(){
		$.post("<?php echo base_url(); ?>item/get_id_barang/", {name_barang : $("#name_barang").val()}, function(hasil){
			$("#id_barang").val(hasil);
		});
		
	}
	
	
	function before_save(){
		if($("#name_barang").val() == ""){
			$("#name_barang").focus();
			alertify.alert("Masukkan nama barang dahulu");			
			return false;
		}
		
		if($("#id_barang").val() == ""){
			alertify.alert("Barang yang anda masukkan tidak ada");			
			return false;
		}
		
		/*
		if($("#harga").val() == "" || $("#harga").val() <= 0){
			$("#harga").val("0");
			$("#harga").focus();
			alertify.alert("Masukkan harga dahulu diatas 0");			
			return false;
		}
		*/
		
		if($("#diskon").val() == "" || $("#diskon").val() < 0){
			$("#diskon").val("0");
			$("#diskon").focus();
			alertify.alert("Masukkan diskon dahulu");			
			return false;
		}
		
		if($("#stok").val() == "1"){
			$("#date_pre_order").val("");	
			$("#keterangan_pre_order").val("");	
			
		}
		
		if($("#stok").val() == "1" && $("#keterangan_barang").val() == ""){
			$("#keterangan_barang").focus();
			alertify.alert("Keterangan barang harus ada apabila stok dalam keadaan ready stock");			
			return false;
		}
		
		<?if($this->uri->segment(2) != "edititemdijual"){?>
			if($("#kode").val() == ""){
				$("#kode").focus();
				alertify.alert("Masukkan kode dahulu");			
				return false;
			}	
		<?}?>		
		
		$("#form_barang_dijual").submit();				
	}
	
	$(document).ready(function () {
		get_nama_barang();
		if($("#name_barang").val()!=""){
			get_id_barang();
		}
		$('#dp1').datepicker();
    });	
</script>

<div class="span1"></div>
<div class="span10">
	<?if($this->uri->segment(2) == "edititemdijual"){?>
		<? $url = base_url()."item/updateitemdijual/".$dafkomen[0]->id;?>
	<?}else{?>
		<? $url = base_url()."item/saveitemdijual/";}?>
	<form id="form_barang_dijual" class="form" method="post" action="<?= $url ?>">
		<div class="form-inline">
			<label>Merk</label>
			<?if(isset($dafkomen[0]->id_merk)):?>
				<?$id_merk = $dafkomen[0]->id_merk;?>
			<?elseif(!empty($data)):?>
				<?$id_merk = $data['id_merk'];?>
			<?else:?>
				<? $id_merk = "";?>
			<?endif;?>
			<?= form_dropdown('id_merk', $merk, $id_merk, "id='id_merk' onchange='get_nama_barang()'");?>
		</div>
		
		<div class="form-inline">
			<label>Kategori</label>
			<?if(isset($dafkomen[0]->id_kategori)):?>
				<?$id_kategori = $dafkomen[0]->id_kategori;?>
			<?elseif(!empty($data)):?>
				<?$id_kategori = $data['id_kategori'];?>
			<?else:?>
				<? $id_kategori = "";?>
			<?endif;?>
			<?= form_dropdown('id_kategori', $tipe, $id_kategori, "id='id_kategori' onchange='get_nama_barang()'");?>	
		</div>
		<div class="form-inline">
			<label>Nama Barang</label>
			<input type="text" value="<?php if(isset($dafkomen[0]->name_barang)) echo $dafkomen[0]->name_barang; elseif(isset($data)) echo $data['name_barang']?>" class="input-xxlarge" name="name_barang" id="name_barang" data-provide="typeahead" data-source='[]' onblur="get_id_barang();">
			<input type='hidden' name="id_barang" id="id_barang" value="<?php if(isset($dafkomen[0]->id_barang)) echo $dafkomen[0]->id_barang; elseif(isset($data)) echo $data['id_barang'];?>">
		</div>
		<div class="form-inline">
			<label>Harga</label>
			<?if(!empty($dafkomen[0]->kurs)):?>
				<?$set_kurs = $dafkomen[0]->kurs?>
			<?elseif(!empty($data['kurs'])):?>
				<?$set_kurs = $data['kurs']?>
			<?else:?>
				<?$set_kurs = ""?>
			<?endif?>
			<?= form_dropdown('kurs', $kurs, $set_kurs, "id='kurs' style='width:60px;'");?>			
			<input class="span3" type="text" value="<?php if(isset($dafkomen[0]->harga)) echo $dafkomen[0]->harga; else if(isset($data)) echo $data['harga']; else echo "0";?>" class="input-xxlarge" name="harga" id="harga" onkeypress="validate_number_integer_only(event)">
		</div>
		<div class="form-inline">
			<label>Slot</label>
			<input class="span3" type="text" value="<?php if(isset($dafkomen[0]->slot)) echo $dafkomen[0]->slot; else if(isset($data)) echo $data['slot']; else echo "0";?>" class="input-xxlarge" name="slot" id="slot" onkeypress="validate_number_integer_only(event)">
		</div>	
		<!--
		<div class="form-inline">
			<label>Diskon (%)</label>
			<input class="span3" type="text" value="<?php if(isset($dafkomen[0]->diskon)) echo $dafkomen[0]->diskon; else if(isset($data)) echo $data['diskon']; else echo "0";?>" class="input-xxlarge" name="diskon" id="diskon" onkeypress="validate_number_integer_only(event)">
		</div>		
		<div class="form-inline">
			<label>Stok Barang</label>
			<?if(isset($dafkomen[0]->stok)):?>
				<?$stok = $dafkomen[0]->stok;?>
			<?elseif(!empty($data)):?>
				<?$stok = $data['stok'];?>
			<?else:?>
				<? $stok = "";?>
			<?endif;?>					
			<?= form_dropdown('stok', array(array(1 => "Ada"),array(2 =>"Kosong")), $stok, "id='stok'");?>
		</div>
		-->
		<div class="form-inline">
			<label>Tanggal Akhir Preorder</label>
			<?$date_pre_order = ""?>
			<? if(isset($dafkomen[0]->date_pre_order)): ?>
				<? if($dafkomen[0]->date_pre_order != "0000-00-00"):?>
					<? $date_pre_order = show_tanggal($dafkomen[0]->date_pre_order) ;?>
				<? endif?>
			<? elseif(isset($data['date_pre_order'])):?>
				<? $date_pre_order =  $data['date_pre_order'] ?>
			<? endif?>
			<div id="dp1" class="dp1 input-append date" data-date="" data-date-format="dd-mm-yyyy">
				<input type="text" id="date_pre_order" name="date_pre_order" class="span3" readonly size="16" style="width:100px" value= "<?=$date_pre_order?>">
				<span class="add-on">
					<i class="icon-th"></i>
				</span>				
			</div>
			<a href="" class="btn btn-danger btn-mini" onclick="clear_date();return false;">clear</a> 
			<input type="text" name="keterangan_pre_order" id="keterangan_pre_order" class="span5" value="<?php if(isset($dafkomen[0]->keterangan_pre_order)) echo $dafkomen[0]->keterangan_pre_order; else if(isset($data['keterangan_pre_order'])) echo $data['keterangan_pre_order']?>">
		</div>
		<div class="form-inline">
			<label>Keterangan Barang</label>
			<input type="text" value="<?php if(isset($dafkomen[0]->keterangan_barang)) echo $dafkomen[0]->keterangan_barang; else if(isset($data['keterangan_barang'])) echo $data['keterangan_barang']?>" class="input-xxlarge" name="keterangan_barang" id="keterangan_barang">
		</div>
		<div class="form-inline">
			<label>Bonus</label>
			<input type="text" value="<?php if(isset($dafkomen[0]->bonus)) echo $dafkomen[0]->bonus; else if(isset($data['bonus'])) echo $data['bonus']?>" class="input-xxlarge" name="bonus" id="bonus">
		</div>
		<?if($this->uri->segment(2) != "edititemdijual"):?>
			<div>
				<?php echo $captcha['image']; ?><br/>
				(masukkan 8 kode di atas)<br/>
				huruf besar dan kecil pengaruh<br/>				
				<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>
			</div>
		<? endif ?>		
		<div class="form-inline">
			<a class="btn btn-success" href="" onclick="before_save();return false;">Simpan</a> <a class="btn btn-danger" href="<?= base_url();?>item/itemdijual">Batal</a>
		</div>
	</form>
	
</div>
<div class="span1"></div>
<?if($this->router->fetch_method() == "edititemdijual"):?>
	<div class="span12">
		<table class="table table-bordered">
			<tr>
				<th>Nama</th>
				<th>Telp</th>
				<th>DP</th>
				<th>Slot</th>
				<th>Action</th>
			</tr>
			<?if(count($barang_dijual_detail)>0):?>
				<?foreach($barang_dijual_detail as $row):?>
					<tr>
						<td><?= $row->nama_lengkap?></td>
						<td><?= $row->telp?></td>
						<td><?= number_format($row->dp,0,',','.')?></td>
						<td><?= $row->slot?></td>
						<td><a onclick="return(confirm('Anda yakin akan menghapus orderan PO <?= $row->nama_lengkap?> yang berjumlah <?= $row->slot?>'))" href="<?=base_url()?>item/delete_order_po/<?= $dafkomen[0]->id?>/<?= $row->id?>" class="btn btn-danger btn-mini">hapus</a></td>
					</tr>
				<?endforeach?>
			<?else:?>
				<tr>
					<td colspan="5"><center>Belum ada yang memesan PO item ini</center></td>
				</tr>
			<?endif?>
		</table>	
		<form action="<?=base_url()?>item/add_order_po" method="post" class="form-inline">
			<table class="">
				<tr>
				<td><input type="text" name="nama_lengkap" placeholder="nama lengkap" required="required"></td>
				<td><input type="text" name="telp" placeholder="telepon" required="required"></td>
				<td><input type="text" name="dp" placeholder="DP" required="required" onkeypress="validate_number_integer_only(event)"></td>
				<td><input type="text" name="slot" placeholder="slot" required="required" onkeypress="validate_number_integer_only(event)"></td>
				<td>
					<input type="hidden" name="barang_dijual_id" value="<?= $dafkomen[0]->id?>">
					<input type="submit" class="btn btn-success btn-small" value="tambahkan" placeholder="nama lengkap" required="required">
				</td>
				</tr>
			</table>
		</form>
	</div>
<?endif?>	