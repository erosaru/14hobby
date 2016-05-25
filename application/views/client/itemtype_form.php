<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>

<script>
	function ganti_merk(obj){
		$.post("<?php echo base_url(); ?>item/ganti_merk/", {id : obj.val()}, function(hasil){
			//console.log(hasil);
			$("#id_sub_kategori").replaceWith(hasil);
			<?if(isset($data[0]->id_sub_kategori)):?>
				<?$id_sub_kategori = $data[0]->id_sub_kategori;?>
			<?elseif(!empty($data)):?>
				<?$id_sub_kategori = $data['id_sub_kategori'];?>
			<?else:?>
				<? $id_sub_kategori = "";?>
			<?endif;?>		
		
			<?if(!empty($id_sub_kategori)):?>
				$("#id_sub_kategori").val("<?= $id_sub_kategori?>");
			<?endif?>
		});				
	}
	
	
	
	function before_save(){
		if($("#typeproduk").val() == ""){
			$("#typeproduk").focus();
			alertify.alert("Masukkan Tipe Produk dahulu");			
			return false;
		}
		
		<?if($this->uri->segment(2) != "itemtype_edit"){?>
			if($("#kode").val() == ""){
				$("#kode").focus();
				alertify.alert("Masukkan kode dahulu");			
				return false;
			}		
		<?}?>
		
		$("#form_subkategori").submit();				
	}
	
	$(document).ready(function () {
		//ganti_merk($('#id_kategori'));		
    });	
</script>

<div class="span2"></div>
<div class="span8">
	<?if($this->uri->segment(2) == "itemtype_edit"){?>
		<? $url = base_url()."item/itemtype_update/".$data[0]->id;?>
	<?}else{?>
		<? $url = base_url()."item/itemtype_save/";}?>
	
	<form id="form_subkategori" class="form" method="post" action="<?= $url ?>">
		<div class="form-inline">
			<label>Merk</label>
			<?= form_dropdown('id_sub_kategori', $merk, "", "id='id_sub_kategori'"); ?>
		</div>	
		<div class="form-inline">
			<label>Kategori</label>
			<?if(isset($data[0]->id_kategori)):?>
				<?$id_kategori = $data[0]->id_kategori;?>
			<?elseif(!empty($data)):?>
				<?$id_kategori = $data['id_kategori'];?>
			<?else:?>
				<? $id_kategori = "";?>
			<?endif;?>					
			<?= form_dropdown('id_kategori', $tipe, $id_kategori, "id='id_kategori' onchange='ganti_merk($(this));'"); ?>
		</div>		
		<div class="form-inline">
			<label>Tipe Produk</label>
			<input type="text" value="<?php if(isset($data[0]->name_type_produk)) echo $data[0]->name_type_produk; else if(isset($data)) echo $data['name_type_produk']?>" class="input-xxlarge" name="typeproduk" id="typeproduk">
		</div>	
		<div class="form-inline">
			<label>Masuk Ensiklopedia</label>
			<?if(isset($data[0]->ensiklopedia)):?>
				<?$ensiklopedia = $data[0]->ensiklopedia;?>
			<?elseif(isset($data['ensiklopedia'])):?>
				<?$ensiklopedia = $data['ensiklopedia'];?>
			<?else:?>
				<? $ensiklopedia = "1";?>
			<?endif;?>	
			<?= form_dropdown('ensiklopedia', $data_ensiklopedia, $ensiklopedia, "id='ensiklopedia'");?>	
		</div>	
		<?if($this->uri->segment(2) != "itemtype_edit"){?>
			<div>
					<?php echo $captcha['image']; ?><br/>
					(masukkan 8 kode di atas)<br/>
					huruf besar dan kecil pengaruh<br/>				
					<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>
			</div>		
		<?}?>
		<div class="form-inline">
			<a class="btn btn-success" href="" onclick="before_save();return false;">Simpan</a> <a class="btn btn-danger" href="<?= base_url();?>item/itemtype">Batal</a>
		</div>
		
	</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>