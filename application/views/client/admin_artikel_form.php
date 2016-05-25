<script>	
	//var sub_kategori = [<?= $kategori?>];
	function get_session(){
		$.post("<?php echo base_url(); ?>artikel/get_session", {}, function(hasil){
			alertify.alert(hasil);
		});
	}
	
	function before_save(){
		if($("#title").val() == ""){
			$("#title").focus();
			alertify.alert("Masukkan judul dahulu");			
			return false;
		}
		
		if($("#pengarang").val() == ""){
			$("#pengarang").focus();
			alertify.alert("Masukkan nama pengarang dahulu");			
			return false;
		}
		
		if($("#kategori").val() == ""){
			$("#kategori").focus();
			alertify.alert("Masukkan kategori dahulu");			
			return false;
		}
		
		/*
		if(sub_kategori.indexOf($("#sub_kategori").val()) == -1){
			$("#sub_kategori").val("");
			$("#sub_kategori").focus();
			alertify.alert("Data Kategori tidak ada di database mohon isi dengan data yang sudah ada");			
			return false;
		}
		*/
		
		if($("#kode").val() == ""){
			$("#kode").focus();
			alertify.alert("Masukkan kode dahulu");			
			return false;
		}		
		
		$("#form_artikel").submit();				
	}
	
	tinymce.init({
		selector: "textarea",
		plugins: ["code", "image"]
	});
</script>

<div class="col-sm-1"></div>
<div class="col-sm-10">
	<? if($this->session->flashdata('data')): ?>
		<?$data = $this->session->flashdata('data');?>
	<?endif;?>

	<?if($this->uri->segment(2) == "admin_edit"){?>
		<? $url = base_url()."artikel/admin_update/".$data[0]->id_artikel;?>
	<?}else{?>
		<? $url = base_url()."artikel/admin_save/";}?>
	<form id="form_artikel" class="form-horizontal" method="post" action="<?= $url;?>">
		<div class="form-group">
			<label class="col-sm-3 control-label">Judul</label>
			<div class="col-sm-9">
				<div class="col-sm-12" style="padding:0px">
					<input type="text" value="<?if(isset($data[0]->title)) echo $data[0]->title; else if(isset($data)) echo $data['title']?>" class="form-control" name="title" id="title">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">SEO Artikel</label>
			<div class="col-sm-9">
				<div class="col-sm-12" style="padding:0px">
					<input type="text" value="<?if(isset($data[0]->seo_artikel)) echo $data[0]->seo_artikel; else if(isset($data['seo_artikel'])) echo $data['seo_artikel'];?>" class="form-control" name="seo_artikel" id="seo_artikel">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Pengarang</label>
			<div class="col-sm-9">
				<div class="col-sm-4" style="padding:0px">
					<input type="text" value="<?if(isset($data[0]->pengarang)) echo $data[0]->pengarang; else if(isset($data)) echo $data['pengarang'];?>" class="form-control" name="pengarang" id="pengarang">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Kategori</label>
			<div class="col-sm-9">
				<div class="col-sm-12" style="padding:0px">
					<input type="text" value="<?php if(isset($data[0]->kategori)) echo $data[0]->kategori; else if(isset($data)) echo $data["kategori"];?>" class="form-control" data-provide="typeahead" data-source='[<?= $kategori?>]' name="kategori" id="kategori">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Kategori Artikel</label>
			<div class="col-sm-9">
				<div class="col-sm-3" style="padding:0px">
					<?if(isset($data[0]->id_kategori_artikel)):?>
						<?$id_kategori_artikel = $data[0]->id_kategori_artikel;?>
					<?elseif(!empty($data['id_kategori_artikel'])):?>
						<?$id_kategori_artikel = $data['id_kategori_artikel'];?>
					<?else:	?>
						<?$id_kategori_artikel = "";?>
					<?endif;?>
					<?= form_dropdown('id_kategori_artikel', $kategori_artikel, $id_kategori_artikel, "class='form-control' id='id_kategori_artikel' onchange='get_booster_set_and_name_card();'");?>			
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Isi Berita</label>
			<div class="col-sm-9">
				<div class="wysiwyg-container">
					<textarea id="wysiwyg" name="pesan" id="pesan" class="input-block-level" placeholder="Enter text ..." style="height: 200px"><?if(isset($data[0]->pesan)) echo $data[0]->pesan; else if(isset($data)) echo $data['pesan'];?></textarea>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<label>
					<input type="checkbox" name="tipsandtrick" id="tipsandtrick" value="1"> Tips dan Trick Untuk Bursa
				</label>
			</div>
		</div>
		<script>
			$(function(){
				<?if(isset($data[0]->tipsandtrick)):?>
					<?if($data[0]->tipsandtrick == "1"):?>
						$("#tipsandtrick").prop("checked", true);
					<?else:?>
						$("#tipsandtrick").prop("checked", false);
					<?endif?>
				<?elseif(isset($data["tipsandtrick"])):?>
					<?if($data["tipsandtrick"] == "1"):?>
						$("#tipsandtrick").prop("checked", true);
					<?else:?>
						$("#tipsandtrick").prop("checked", false);
					<?endif?>
				<?endif?>
			});			
		</script>
		<?if($this->uri->segment(2) != "admin_edit"){?>
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
				<a class="btn btn-success" href="" onclick="before_save();return false;">Simpan</a> 
				<a class="btn btn-danger" href="<?= base_url();?>artikel/admin_index">Batal</a>
			</div>
		</div>
	</form>
</div>
<div class="col-sm-1"></div>
<div class="clearfix"></div>