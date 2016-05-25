<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<script>
	<?if($this->router->fetch_class() == "trading_card" && $this->router->fetch_method() == "itemmerk_edit"):?>
		$(function(){
			var btnUpload=$('#upload');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: '<?php echo base_url()."uploadfile/do_upload_gambar_merk_kartu/".$data[0]->id?>',
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
		});
	<?endif?>
	
	function before_save(){
		if($("#name_merk").val() == ""){
			$("#name_merk").focus();
			alertify.alert("Masukkan merk dahulu");			
			return false;
		}
		
		<?if($this->uri->segment(2) != "itemmerk_edit"){?>
			if($("#kode").val() == ""){
				$("#kode").focus();
				alertify.alert("Masukkan kode dahulu");			
				return false;
			}		
		<?}?>
		
		$("#form_merk").submit();				
	}
	
</script>

<div class="col-sm-12">
	<?if($this->uri->segment(2) == "itemmerk_edit"){?>
		<? $url = base_url().$this->router->fetch_class()."/itemmerk_update/".$data[0]->id;?>
	<?}else{?>
		<? $url = base_url().$this->router->fetch_class()."/itemmerk_save/";}?>
	
	<form id="form_merk" method="post" action="<?= $url ?>" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label">Merk</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<?php if(isset($data[0]->name_merk)) echo $data[0]->name_merk;else if(isset($data['name_merk'])) echo $data["name_merk"]?>" class="form-control" name="name_merk" id="name_merk">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Divisi</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<?if(isset($data[0]->divisi_id)):?>
						<?$divisi_id = $data[0]->divisi_id;?>
					<?elseif(!empty($data['divisi_id'])):?>
						<?$divisi_id = $data['divisi_id'];?>
					<?else:?>
						<? $divisi_id = "1";?>
					<?endif;?>	
					<?= form_dropdown('divisi_id', $data_divisi, $divisi_id, "class='form-control' id='divisi_id'");?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Masuk Ensiklopedia</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<?if(isset($data[0]->ensiklopedia)):?>
						<?$ensiklopedia = $data[0]->ensiklopedia;?>
					<?elseif(!empty($data['ensiklopedia'])):?>
						<?$ensiklopedia = $data['ensiklopedia'];?>
					<?else:?>
						<? $ensiklopedia = "1";?>
					<?endif;?>	
					<?= form_dropdown('ensiklopedia', $data_ensiklopedia, $ensiklopedia, "class='form-control' id='ensiklopedia'");?>	
				</div>
			</div>
		</div>
		<?if($this->uri->segment(2) != "itemmerk_edit"){?>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-10">
					<?php echo $captcha['image']; ?><br/>&nbsp;<br/>&nbsp;
					<div class="col-sm-4" style="padding:0px;">
						<input class="form-control" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>
						(masukkan 8 kode di atas)<br/>
						huruf besar dan kecil pengaruh<br/>		
					</div>
				</div>
			</div>
		<?}?>
		<?if($this->router->fetch_class() == "trading_card" && $this->router->fetch_method() == "itemmerk_edit"){?>
			<div style="margin-bottom:10px;">
				<div id="upload" class="btn btn-success" ><span>Upload File<span></div><span id="status" ></span><br/>
			</div>	
			<?if(!empty($data[0]->gambar_merk)){?>
				<div class="form-inline">
					<center><img alt="14hobby <?=$data[0]->name_merk;?>" src="<?= base_url();?>uploads/trading_card/<?= $data[0]->gambar_merk?>" style="width:150px;"></center>
				</div>
			<?}?>
		<?}?>
		<div class="form-group">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<a class="btn btn-success" href="" onclick="before_save();return false;">Simpan</a> <a class="btn btn-danger" href="<?= base_url();?><?= $this->router->fetch_class();?>/itemmerk">Batal</a>
			</div>
		</div>		
	</form>
</div>