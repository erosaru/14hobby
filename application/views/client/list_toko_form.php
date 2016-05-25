<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>

<?$text = "";?>
<?if(isset($dafkomen[0]->tipe_toko)): ?>
	<? $text = $dafkomen[0]->tipe_toko ?>
<? elseif(isset($data)): ?>
	<? $text = $data["tipe_toko"] ?>
<?endif?>


		
<? $checked = 0; ?>
<? switch($text){
	case "Toko offline":
		$checked = 0; 
		break;
	case "Toko online":
		$checked = 1; 
		break;
	case "Toko online dan toko offline":
		$checked = 2; 
		break;
}?>

<script>
	function before_save(){
		if($("#nama_lengkap").val() == ""){
			$("#nama_lengkap").focus();
			alertify.alert("Masukkan nama contact person untuk toko anda dahulu");			
			return false;
		}
		
		if($("#nama_toko").val() == ""){
			$("#nama_toko").focus();
			alertify.alert("Masukkan nama toko hobi anda dahulu");			
			return false;
		}
		
		if($("#kota").val() == ""){
			$("#kota").focus();
			alertify.alert("Masukkan kota tempat toko hobi anda berada");			
			return false;
		}
		
		/*
		if($("#telepon_toko").val() == ""){
			$("#telepon_toko").focus();
			alertify.alert("Masukkan telepon anda dahulu");			
			return false;
		}
		*/
		if($("#email_toko").val() != ""){
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(!(re.test($("#email_toko").val()))){
				$("#email_toko").focus();
				alertify.alert("Masukkan email anda dengan format email yang benar");			
				return false;
			}
			
		}
		
		
		
		if($("[name*='type_toko']:checked").val() == "Toko offline"){
			if($("#alamat_toko").val() == ""){
				$("#alamat_toko").focus();
				alertify.alert("Masukkan alamat toko anda dahulu");			
				return false;
			}			
		}else if($("[name*='type_toko']:checked").val() == "Toko online"){
			var data = 0;
			$("#toko_online input").each(function(){			
				if($(this).val() != "")
					data++;
			});
			if(data == 0){
				alertify.alert("Masukkan salah satu link website atau contact yang bisa di hubungin untuk toko online hobi anda");return false;			
			}		
		}else if($("[name*='type_toko']:checked").val() == "Toko online dan toko offline"){
			if($("#alamat_toko").val() == ""){
				$("#alamat_toko").focus();
				alertify.alert("Masukkan alamat toko anda dahulu");			
				return false;
			}
			
			var data = 0;
			$("#toko_online input").each(function(){			
				if($(this).val() != "")
					data++;
			});
			if(data == 0){
				alertify.alert("Masukkan salah satu link website atau contact yang bisa di hubungin untuk toko online hobi anda");return false;			
			}	
		}
		
		if(tinyMCE.activeEditor.getContent() == ""){
			tinyMCE.get('deskripsi').focus();
			alertify.alert("Masukkan deskripsi toko anda dahulu");			
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
		console.log("<?=$this->router->method?>");
		<?if($this->router->method == "daftar_toko"):?>
			tinymce.init({
				selector: "textarea"
			});
		<?else:?>
			tinymce.init({
				selector: "textarea",
				plugins: ["code", "image"]
			});
		<?endif?>
		$("[name*='type_toko']").click(function(){
			if($(this).val() == "Toko offline"){
				$("#toko_offline").show();
				$("#toko_online").hide();
			}else if($(this).val() == "Toko online"){
				$("#toko_offline").hide();
				$("#toko_online").show();
			}else{
				$("#toko_offline").show();
				$("#toko_online").show();
			}
		});
		
		$("[name*='type_toko']")[<?=$checked?>].click();
	});
	
</script>


<?if($this->uri->segment(2) == "edit"):?>
	<? $url = base_url()."list_toko/update/".$dafkomen[0]->id;?>
<?else:?>
	<?if($this->uri->segment(1) == "list_toko"):?>
		<? $url = base_url()."list_toko/save/"; ?>
	<?else:?>
		<? $url = base_url()."list_toko/save_from_daftar_toko/";?>
	<?endif?>
<?endif?>
	

<form class="form" action="<?= $url?>" method="post">
	<div class="form-inline">
		<label>Contact Person</label>
		<input type="text" name="nama_lengkap" id="nama_lengkap" value="<?php if(isset($dafkomen[0]->nama_pemilik)) echo $dafkomen[0]->nama_pemilik; else if(isset($data)) echo $data['nama_pemilik']?>">
	</div>
	<div class="form-inline">
		<label>Nama Toko</label>
		<input type="text" name="nama_toko" id="nama_toko" value="<?php if(isset($dafkomen[0]->nama_toko)) echo $dafkomen[0]->nama_toko; else if(isset($data)) echo $data['nama_toko']?>">
	</div>	
	<div class="form-inline">
		<label>Kota</label>
		<input type="text" name="kota" id="kota" value="<?php if(isset($dafkomen[0]->kota)) echo $dafkomen[0]->kota; else if(isset($data)) echo $data['kota']?>">
	</div>
	<div class="form-inline">
			<label>Telepon Toko</label>
			<input type="text" name="telepon_toko" id="telepon_toko" value="<?php if(isset($dafkomen[0]->telepon_toko)) echo $dafkomen[0]->telepon_toko; else if(isset($data)) echo $data['telepon_toko']?>">
	</div>
	<div class="form-inline">
		<label>Email</label>
		<input class="span5" type="text" name="email_toko" id="email_toko" value="<?php if(isset($dafkomen[0]->email)) echo $dafkomen[0]->email; else if(isset($data)) echo $data['email']?>">
	</div>
	<div class="form-inline">
		<label>BBM</label>
		<input type="text" name="bbm" id="bbm" value="<?php if(isset($dafkomen[0]->bbm)) echo $dafkomen[0]->bbm; else if(isset($data)) echo $data['bbm']?>">
	</div>	
	<div class="form-inline">
		<label>Line</label>
		<input type="text" name="line_toko" id="line_toko" value="<?php if(isset($dafkomen[0]->line)) echo $dafkomen[0]->line; else if(isset($data)) echo $data['line']?>">
	</div>
	<div class="form-inline">
		<label>Whatsapp</label>
		<input type="text" name="whatsapp_toko" id="whatsapp_toko" value="<?php if(isset($dafkomen[0]->whatsapp)) echo $dafkomen[0]->whatsapp; else if(isset($data)) echo $data['whatsapp']?>">
	</div>
	<div class="form-inline">			
		<label>Tipe Toko</label>
		<label class="radio">
			<input type="radio" name="type_toko" value="Toko offline">Toko Offline
		</label>
		<label class="radio">
			<input type="radio" name="type_toko" value="Toko online">Toko Online
		</label>
		<label class="radio">
				<input type="radio" name="type_toko" value="Toko online dan toko offline">Toko Online dan toko offline
		</label>
	</div>
	<div id="toko_offline">
		<div class="form-inline">
			<label>Alamat Toko</label>
			<input class="span8" type="text" name="alamat_toko" id="alamat_toko" value="<?php if(isset($dafkomen[0]->alamat_toko)) echo $dafkomen[0]->alamat_toko; else if(isset($data)) echo $data['alamat_toko']?>">
		</div>
	</div>
	<div id="toko_online">
		<div class="form-inline">
			<label>Website</label>
			<input class="span8" type="text" name="website_toko" id="website_toko" value="<?php if(isset($dafkomen[0]->website)) echo $dafkomen[0]->website; else if(isset($data)) echo $data['website']?>">
		</div>		
		<div class="form-inline">
			<label>Facebook</label>
			<input class="span8" type="text" name="facebook_toko" id="facebook_toko" value="<?php if(isset($dafkomen[0]->facebook)) echo $dafkomen[0]->facebook; else if(isset($data)) echo $data['facebook']?>">
		</div>
		<div class="form-inline">
			<label>Twitter</label>
			<input class="span8" type="text" name="twitter_toko" id="twitter_toko" value="<?php if(isset($dafkomen[0]->twitter)) echo $dafkomen[0]->twitter; else if(isset($data)) echo $data['twitter']?>">
		</div>
		
	</div>
	<div class="form-inline">
		<label>Deskripsi Toko</label>
		
		<textarea class="ckeditor" name="deskripsi"><?php if(isset($dafkomen[0]->deskripsi)) echo $dafkomen[0]->deskripsi ; else if(isset($data)) echo $data['deskripsi'];?></textarea>
	</div>
	<?if($this->uri->segment(2) == "create"):?>
		<input type="hidden" name="link_to" id="link_to" value="list_toko">
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
		
		<a style="width:200px;height:25px;margin:0px;padding:0px;" class="btn btn-danger" href="<?if($this->uri->segment(1) == "list_toko") echo base_url()."list_toko"; else echo base_url();?>">Batal</a>
	</div>
</form>