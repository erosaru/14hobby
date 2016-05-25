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
		<?if($this->uri->segment(2) != "edit"){?>
			if($("#kode").val() == ""){
				$("#kode").focus();
				alertify.alert("Masukkan kode dahulu");			
				return false;
			}	
		<?}?>		
		
		$("#form_kategori").submit();				
	}
	var xyz = 0;
	<?if($this->uri->segment(2) == "edit"):?>
		$(function(){
			var btnUpload=$('#upload');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: '<?= base_url()?>uploadfile/upload_for_bank/<?= $data[0]->id?>',
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
	<?if($this->uri->segment(2) == "edit"){?>
		<? $url = base_url().$this->router->fetch_class()."/update/".$data[0]->id;?>
	<?}else{?>
		<? $url = base_url().$this->router->fetch_class()."/save/";}?>
	
	<form id="form_kategori" class="form-horizontal" method="post" action="<?= $url ?>">
		<div class="form-group">
			<label class="col-sm-3 control-label">Bank</label>
			<div class="col-sm-9">
				<div class="col-sm-6" style="padding:0px;">
					<input type="text" value="<?php if(isset($data[0]->bank_name)) echo $data[0]->bank_name;else if(isset($data['bank_name'])) echo $data["bank_name"]?>" class="form-control" name="bank_name" id="bank_name">
				</div>
			</div>
		</div>				
		<?if($this->uri->segment(2) == "edit"):?>
			<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
					<div id="upload" class="btn btn-success" style="margin-bottom:10px;"><span>Upload File<span></div><span id="status" ></span><br/>
					<?if(!empty($data[0]->picture)):?>
						<img id="change_picture" src="<?= base_url();?>uploads/bank/<?=$data[0]->picture;?>">
					<?else:?>
						<img id="change_picture" src="<?= base_url();?>asset/image/kategori/no_picture.png">
					<?endif?>
				</div>
			</div>
		<?endif?>
		<?if($this->uri->segment(2) != "edit"){?>
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
				<a class="btn btn-success" href="" onclick="before_save();return false;">Simpan</a> <a class="btn btn-danger" href="<?= base_url();?><?= $this->router->fetch_class();?>">Batal</a>
			</div>
		</div>
	</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>