<style>
	.upload_style{
		margin:30px 0px 30px 100px; padding:15px;
		font-weight:bold; font-size:1.3em;
		font-family:Arial, Helvetica, sans-serif;
		align: left;
		text-align:center;
		background:#f2f2f2;
		color:#3366cc;
		border:1px solid #ccc;
		width:150px;
		cursor:pointer !important;
		-moz-border-radius:5px; -webkit-border-radius:5px;
	}
</style>

<script>
	tinymce.init({
		selector: "textarea",
		plugins: ["code", "image"]
	});
	
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
	
	function before_save(){
		if($("#card_name").val() == ""){
			$("#card_name").focus();
			alertify.alert("Masukkan Nama Kartu dahulu");			
			return false;
		}
		
		if($("#booster_set").val() == ""){
			$("#booster_set").focus();
			alertify.alert("Masukkan Booster Set dahulu");			
			return false;
		}
		
		<?if($this->uri->segment(2) != "edit"){?>
			if($("#kode").val() == ""){
				$("#kode").focus();
				alertify.alert("Masukkan kode dahulu");			
				return false;
			}		
		<?}?>
		
		$("#form_dbkartu").submit();				
	}
	
	$(function(){
		<?if($this->router->method == "edit"):?>
			var btnUpload=$('#upload');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: '<?php echo base_url()."uploadfile/do_upload_gambar_kartu/".$data[0]->id?>',
				name: 'xfile',
				onSubmit: function(file, ext){
					 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
						// extension is not allowed 
						status.text('Only JPG, PNG or GIF files are allowed');
						return false;
					}
					status.text('Uploading...');
				},
				onComplete: function(file, response){
					//On completion clear the status
					status.text('');
					//Add uploaded file to list
					//alert(response);
					if(response.search("Success")>-1){
						x= response.split(";");
						xnama_gambar = x[1];
						alert('Perubahan File Berhasil');
						window.location.reload();
					}else{
						alert(response);
						alert('Gagal Upload File');
					}
					
				}
			});
		<?endif?>		
	});
</script>

<div class="span2"></div>
<div class="span8">
	<? if($this->session->flashdata('data')): ?>
		<?$data = $this->session->flashdata('data');?>
	<?endif;?>
	
	<?if($this->uri->segment(2) == "edit"){?>
		<? $url = base_url()."trading_card/update/".$data[0]->id;?>
	<?}else{?>
		<? $url = base_url()."trading_card/save/";}?>
	
	<form id="form_dbkartu" class="form" method="post" action="<?= $url ?>" enctype="multipart/form-data" accept-charset="utf-8">
		<div class="form-inline">
			<label>Card Game Name</label>
			<?if(isset($data[0]->id_merk)):?>
				<?$id_merk = $data[0]->id_merk;?>
			<?elseif(!empty($data)):?>
				<?$id_merk = $data['id_merk'];?>
			<?else:?>
				<? $id_merk = "";?>
			<?endif;?>
			<?= form_dropdown('id_merk', $merk, $id_merk, "id='id_merk'");?>	
		</div>
		<div class="form-inline">
			<label>Booster Set</label>
			<input type="text" value="<?php if(isset($data[0]->booster_set)) echo $data[0]->booster_set; else if(isset($data)) echo $data['booster_set']?>" class="input-xxlarge" name="booster_set" id="booster_set" data-provide="typeahead" data-source='[<?= $booster_set?>]'>
		</div>
		<div class="form-inline">
			<label>Name Card</label>
			<input type="text" value="<?php if(isset($data[0]->name_barang)) echo $data[0]->name_barang; else if(isset($data)) echo $data['name_barang']?>" class="input-xxlarge" name="name_barang" id="name_barang">
		</div>	
		<div class="form-inline">
			<label>Clan Type</label>
			<input type="text" value="<?php if(isset($data[0]->clan_type)) echo $data[0]->clan_type; else if(isset($data)) echo $data['clan_type']?>" class="input-large" name="clan_type" id="clan_type" data-provide="typeahead" data-source='[<?= $clan_type?>]'>
		</div>
		<div class="form-inline">
			<label>Card Type</label>
			<input type="text" value="<?php if(isset($data[0]->card_type)) echo $data[0]->card_type; else if(isset($data)) echo $data['card_type']?>" class="input-large" name="card_type" id="card_type" data-provide="typeahead" data-source='[<?= $card_type?>]'>
		</div>
		<div class="form-inline">
			<label>Attack Value</label>
			<input type="text" value="<?php if(isset($data[0]->attack_value)) echo $data[0]->attack_value; else if(isset($data)) echo $data['attack_value']?>" class="input-large" name="attack_value" id="attack_value" onkeypress="validate_number_integer_only(event)">
		</div>
		<div class="form-inline">
			<label>Defend Value</label>
			<input type="text" value="<?php if(isset($data[0]->defend_value)) echo $data[0]->defend_value; else if(isset($data)) echo $data['defend_value']?>" class="input-large" name="defend_value" id="defend_value" onkeypress="validate_number_integer_only(event)">
		</div>
		<div class="form-inline">
			<label>Effect</label>
			<input type="checkbox" name="effect" id="effect" <? if(isset($data[0]->effect) && $data[0]->effect == 1) echo "checked"; else if(isset($data['effect']) && $data['effect'] == '1') echo "checked"?>>
		</div>
		<div class="form-inline">
			<label>Deskripsi</label>
			<div class="wysiwyg-container">
				<textarea class="ckeditor" name="pesan"><?php if(isset($data[0]->deskripsi)) echo $data[0]->deskripsi ; else if(isset($data)) echo $data['deskripsi']?></textarea>
			</div>
		</div>
		<div class="form-inline">
			<label>SEO</label>
			<input type="text" value="<?php if(isset($data[0]->seo_barang)) echo $data[0]->seo_barang; else if(isset($data)) echo $data['seo_barang']?>" class="input-xxlarge" name="seo" id="seo">
		</div>
		<?if($this->router->method == "edit"):?>
			<div class="form-inline">
				<div id="upload" class="upload_style" ><span>Upload File<span></div><span id="status" ></span>
			</div>
		<?endif?>
		<?if($this->router->method == "edit" && !empty($data[0]->gambar)){?>
			<div class="form-inline">
				<center><img src="<?= base_url();?>uploads/trading_card/<?= $data[0]->gambar?>" style="width:150px;"></center>
			</div>
		<?}?>
		<?if($this->uri->segment(2) != "edit"){?>
			<div>
					<?php echo $captcha['image']; ?><br/>
					(masukkan 8 kode di atas)<br/>
					huruf besar dan kecil pengaruh<br/>				
					<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>
			</div>		
		<?}?>
		<div class="form-inline">
			<a class="btn btn-success" href="" onclick="before_save();return false;">Simpan</a> <a href="javascript:void(0)" class="btn btn-danger" onclick="window.history.back()">Batal</a>
		</div>	
	</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>