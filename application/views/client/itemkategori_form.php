<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<script>
	function before_save(){
		if($("#kategori").val() == ""){
			$("#kategori").focus();
			alertify.alert("Masukkan kategori dahulu");			
			return false;
		}
		<?if($this->uri->segment(2) != "itemkategori_edit"){?>
			if($("#kode").val() == ""){
				$("#kode").focus();
				alertify.alert("Masukkan kode dahulu");			
				return false;
			}	
		<?}?>		
		
		$("#form_kategori").submit();				
	}
	var xyz = 0;
	<?if($this->uri->segment(2) == "itemkategori_edit"):?>
		$(function(){
			var btnUpload=$('#upload');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: '<?= base_url()?>uploadfile/upload_kategori_page/<?= $data[0]->id?>',
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
						$("#change_picture").attr("src",x[1]+"?"+xyz);
						xyz++;
						alertify.alert('Gambar Sudah Diupload');
					}else{
						console.log(response);
						//alert('Gagal Upload File');
					}					
				}
			});
			
		});
	<?endif?>
	
</script>

<div class="span2"></div>
<div class="span8">
	<?if($this->uri->segment(2) == "itemkategori_edit"){?>
		<? $url = base_url().$this->router->fetch_class()."/itemkategori_update/".$data[0]->id;?>
	<?}else{?>
		<? $url = base_url().$this->router->fetch_class()."/itemkategori_save/";}?>
	
	<form id="form_kategori" class="form-horizontal" method="post" action="<?= $url ?>">
		<div class="form-group">
			<label class="col-sm-3 control-label">Kategori</label>
			<div class="col-sm-9">
				<div class="col-sm-6" style="padding:0px;">
					<input type="text" value="<?php if(isset($data[0]->name_kategori)) echo $data[0]->name_kategori;else if(isset($data['name_kategori'])) echo $data["name_kategori"]?>" class="form-control" name="kategori" id="kategori">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Divisi</label>
			<div class="col-sm-9">
				<div class="col-sm-3" style="padding:0px;">
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
			<label class="col-sm-3 control-label">Masuk Ensiklopedia</label>
			<div class="col-sm-9">
				<div class="col-sm-3" style="padding:0px;">
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
		<?if($this->uri->segment(2) == "itemkategori_edit"):?>
			<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
					<div id="upload" class="btn btn-success" style="margin-bottom:10px;"><span>Upload File<span></div><span id="status" ></span><br/>
					<?if(!empty($data[0]->link_gambar)):?>
						<img id="change_picture" src="<?= base_url();?>asset/image/kategori/<?=$data[0]->link_gambar;?>">
					<?else:?>
						<img id="change_picture" src="<?= base_url();?>asset/image/kategori/no_picture.png">
					<?endif?>
				</div>
			</div>
		<?endif?>
		<?if($this->uri->segment(2) != "itemkategori_edit"){?>
			<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
					<?php echo $captcha['image']; ?><br/>
					(masukkan 8 kode di atas)<br/>
					huruf besar dan kecil pengaruh<br/>	
					<div class="col-sm-2" style="padding:0px;">									
						<input class="form-control" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>
					</div>
				</div>
			</div>
		<?}?>
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<a class="btn btn-success" href="" onclick="before_save();return false;">Simpan</a> <a class="btn btn-danger" href="<?= base_url();?><?= $this->router->fetch_class();?>/itemkategori">Batal</a>
			</div>
		</div>
	</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>