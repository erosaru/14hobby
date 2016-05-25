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

<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>

<script>
	function before_save(){
		if($("#nama_komunitas").val() == ""){
			$("#nama_komunitas").focus();
			alertify.alert("Masukkan nama komunitas hobi anda dahulu");			
			return false;
		}
		
		if($("#kota").val() == ""){
			$("#kota").focus();
			alertify.alert("Masukkan kota tempat komunitas hobi anda berada");			
			return false;
		}
		
		if($("#nama_contact").val() == ""){
			$("#nama_contact").focus();
			alertify.alert("Masukkan nama contact person untuk komunitas anda dahulu");			
			return false;
		}	
		
		
		if($("#email_komunitas").val() != ""){
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(!(re.test($("#email_komunitas").val()))){
				$("#email_komunitas").focus();
				alertify.alert("Masukkan email anda dengan format email yang benar");			
				return false;
			}
			
		}
		
		if(tinyMCE.get('kegiatan').getContent() == ""){
			tinyMCE.get('kegiatan').focus();
			alertify.alert("Masukkan kegiatan komunitas anda dahulu");			
			return false;
		}
		
		if(tinyMCE.get('cara_ikut_komunitas').getContent() == ""){
			tinyMCE.get('cara_ikut_komunitas').focus();
			alertify.alert("Masukkan cara ikut komunitas anda dahulu");			
			return false;
		}
		
		<?if($this->uri->segment(2) != "edit"){?>
			if($("#kode").val() == ""){
				$("#kode").focus();
				alertify.alert("Masukkan kode dahulu");			
				return false;
			}
		<?}?>	
	}
	
	$(function(){
		<?if($this->router->method == "edit"):?>
			var btnUpload=$('#upload');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: '<?php echo base_url()."uploadfile/do_upload_logo_komunitas/".$dafkomen[0]->id?>',
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
		
		<?if($this->router->method == "daftar_komunitas"):?>
			tinymce.init({
				selector: "textarea"
			});
		<?else:?>
			tinymce.init({
				selector: "textarea",
				plugins: ["code", "image"]
			});
		<?endif?>		
	});
	
</script>

<?if($this->uri->segment(2) == "edit"):?>
	<? $url = base_url()."list_komunitas/update/".$dafkomen[0]->id;?>
<?else:?>
	<?if($this->uri->segment(1) == "list_komunitas"):?>
		<? $url = base_url()."list_komunitas/save/"; ?>
	<?else:?>
		<? $url = base_url()."list_komunitas/save_from_daftar_komunitas/";?>
	<?endif?>
<?endif?>
	

<form class="form" action="<?= $url?>" method="post">
	<div class="form-inline">
		<label>Nama Komunitas</label>
		<input type="text" name="nama_komunitas" id="nama_komunitas" value="<?php if(isset($dafkomen[0]->nama_komunitas)) echo $dafkomen[0]->nama_komunitas; else if(isset($data)) echo $data['nama_komunitas']?>">
	</div>
	<div class="form-inline">
		<label>Kota</label>
		<input type="text" name="kota" id="kota" value="<?php if(isset($dafkomen[0]->kota)) echo $dafkomen[0]->kota; else if(isset($data)) echo $data['kota']?>">
	</div>
	<div class="form-inline">
		<label>Contact Person</label>
		<input type="text" name="nama_contact" id="nama_contact" value="<?php if(isset($dafkomen[0]->nama_contact)) echo $dafkomen[0]->nama_contact; else if(isset($data)) echo $data['nama_contact']?>">
	</div>		
	<div class="form-inline">
			<label>Telepon Komunitas</label>
			<input type="text" name="telepon_komunitas" id="telepon_komunitas" value="<?php if(isset($dafkomen[0]->telepon_komunitas)) echo $dafkomen[0]->telepon_komunitas; else if(isset($data)) echo $data['telepon_komunitas']?>">
	</div>
	<div class="form-inline">
		<label>Email</label>
		<input class="span5" type="text" name="email_komunitas" id="email_komunitas" value="<?php if(isset($dafkomen[0]->email)) echo $dafkomen[0]->email; else if(isset($data)) echo $data['email']?>">
	</div>
	<div class="form-inline">
		<label>BBM</label>
		<input type="text" name="bbm" id="bbm" value="<?php if(isset($dafkomen[0]->bbm)) echo $dafkomen[0]->bbm; else if(isset($data)) echo $data['bbm']?>">
	</div>	
	<div class="form-inline">
		<label>Line</label>
		<input type="text" name="line_komunitas" id="line_komunitas" value="<?php if(isset($dafkomen[0]->line)) echo $dafkomen[0]->line; else if(isset($data)) echo $data['line']?>">
	</div>
	<div class="form-inline">
		<label>Whatsapp</label>
		<input type="text" name="whatsapp_komunitas" id="whatsapp_komunitas" value="<?php if(isset($dafkomen[0]->whatsapp)) echo $dafkomen[0]->whatsapp; else if(isset($data)) echo $data['whatsapp']?>">
	</div>
	<div class="form-inline">
		<label>Website</label>
		<input class="span8" type="text" name="website_komunitas" id="website_komunitas" value="<?php if(isset($dafkomen[0]->website)) echo $dafkomen[0]->website; else if(isset($data)) echo $data['website']?>">
	</div>		
	<div class="form-inline">
		<label>Facebook</label>
		<input class="span8" type="text" name="facebook_komunitas" id="facebook_komunitas" value="<?php if(isset($dafkomen[0]->facebook)) echo $dafkomen[0]->facebook; else if(isset($data)) echo $data['facebook']?>">
	</div>
	<div class="form-inline">
		<label>Twitter</label>
		<input class="span8" type="text" name="twitter_komunitas" id="twitter_komunitas" value="<?php if(isset($dafkomen[0]->twitter)) echo $dafkomen[0]->twitter; else if(isset($data)) echo $data['twitter']?>">
	</div>		
	<div class="form-inline">
		<label>Kegiatan</label>
		<textarea class="ckeditor" name="kegiatan"><?php if(isset($dafkomen[0]->kegiatan)) echo $dafkomen[0]->kegiatan ; else if(isset($data)) echo $data['kegiatan'];?></textarea>
	</div>
	<div class="form-inline">
		<label>Cara Mengikuti Komunitas</label>		
		<textarea class="ckeditor" name="cara_ikut_komunitas"><?php if(isset($dafkomen[0]->cara_ikut_komunitas)) echo $dafkomen[0]->cara_ikut_komunitas ; else if(isset($data)) echo $data['cara_ikut_komunitas'];?></textarea>
	</div>
	<?if($this->uri->segment(2) == "create"):?>
		<input type="hidden" name="link_to" id="link_to" value="list_komunitas">
	<?endif?>
	
	<?if($this->router->method == "edit"):?>
		<div id="upload" class="upload_style" ><span>Upload File<span></div><span id="status" ></span>
	<?endif?>
	
	<?if($this->uri->segment(2) == "edit"):?>
		<div class="form-inline">
			<label>Aktif</label>
			<select name="aktif">
				<option value="1" <?if($dafkomen[0]->aktif == true) echo "selected";?>>Aktif</option>
				<option value="0" <?if($dafkomen[0]->aktif == false) echo "selected";?>>Non Aktifkan</option>
			</select>
		</div>
	<?endif?>
	
	<?if($this->uri->segment(2) != "edit"):?>
		<div class="text-center">
			<?php echo $captcha['image']; ?><br/>
			(masukkan 8 kode di atas)<br/>
			huruf besar dan kecil pengaruh<br/>				
			<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>
		</div>
	<?endif?>
	
	<div class="text-center">
		<input style="width:200px;height:25px;margin:0px;padding:0px;" type="submit" class="btn btn-success" value="Simpan" onclick="return(before_save())">
		
		<a style="width:200px;height:25px;margin:0px;padding:0px;" class="btn btn-danger" href="<?if($this->uri->segment(1) == "list_komunitas") echo base_url()."list_komunitas"; else echo base_url();?>">Batal</a>
	</div>
	
	<?if(!empty($dafkomen[0]->logo_komunitas)):?>
		<center><img src="<?php echo base_url()."uploads/logo_komunitas/".$dafkomen[0]->logo_komunitas;?>"></center>
	<?endif?>
</form>