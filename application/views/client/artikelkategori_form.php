<script>
	function before_save(){
		if($("#kategori").val() == ""){
			$("#kategori").focus();
			alertify.alert("Masukkan kategori dahulu");			
			return false;
		}
		<?if($this->uri->segment(2) != "admin_edit_kategori"){?>
			if($("#kode").val() == ""){
				$("#kode").focus();
				alertify.alert("Masukkan kode dahulu");			
				return false;
			}	
		<?}?>		
		
		$("#form_kategori").submit();				
	}
	
</script>

<div class="col-sm-2"></div>
<div class="col-sm-8">
	<?if($this->uri->segment(2) == "admin_edit_kategori"){?>
		<? $url = base_url()."artikel/admin_update_kategori/".$data[0]->id;?>
	<?}else{?>
		<? $url = base_url()."artikel/admin_save_kategori/";}?>
	
	<form id="form_kategori" class="form-horizontal" method="post" action="<?= $url ?>">
		<div class="form-group">
			<label class="col-sm-3 control-label">Kategori</label>
			<div class="col-sm-9">
				<div class="col-sm-4" style="padding:0px">
					<input type="text" value="<?php if(isset($data[0]->name_kategori)) echo $data[0]->name_kategori;?>" class="form-control" name="kategori" id="kategori">
				</div>
			</div>
		</div>
		<?if($this->uri->segment(2) != "admin_edit_kategori"){?>
			<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
					<?php echo $captcha['image']; ?><br/>
					(masukkan 8 kode di atas)<br/>
					huruf besar dan kecil pengaruh<br/>				
					<div class="col-sm-2" style="padding:0px">
						<input class="form-control" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>
					</div>
				</div>
			</div>	
		<?}?>
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<a class="btn btn-success" href="" onclick="before_save();return false;">Simpan</a> <a class="btn btn-danger" href="<?= base_url();?>artikel/admin_index_kategori">Batal</a>
			</div>
		</div>
	</form>
</div>
<div class="col-sm-2"></div>
<div class="clearfix"></div>