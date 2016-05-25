<script>
	function before_save(){
		if($("#title").val() == ""){
			$("#title").focus();
			alertify.alert("Masukkan judul dahulu");			
			return false;
		}
		
		if($("#kode").val() == ""){
			$("#kode").focus();
			alertify.alert("Masukkan kode dahulu");			
			return false;
		}		
		
		$("#form_event").submit();				
	}
	
	tinymce.init({
		selector: "textarea",
		plugins: ["code", "image"]
	});
	
	function clear_date(){
		$("#end_date").val("");
	}
	
	$(function () {
		$('#dp1').datepicker();
	});
</script>

<div class="span2"></div>
<div class="span8">
	<? if($this->session->flashdata('data')): ?>
		<?$data = $this->session->flashdata('data');?>
	<?endif;?>
	
	<?if($this->uri->segment(2) == "admin_edit"){?>
		<? $url = base_url()."event/admin_update/".$data[0]->id;?>
	<?}else{?>
		<? $url = base_url()."event/admin_save/";}?>
	<form id="form_event" class="form-horizontal" method="post" action="<?= $url;?>">
		<div class="form-group">
			<label class="col-sm-3 control-label">Nama Acara</label>
			<div class="col-sm-9">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<?php if(isset($data[0]->title)) echo $data[0]->title; else if(isset($data)) echo $data['title']?>" class="form-control" name="title" id="title">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Tanggal Release</label>
			<div class="col-sm-9" style="padding:0px;">
				<?$end_date = ""?>
				<? if(isset($data[0]->end_date)): ?>
					<? if($data[0]->end_date != "0000-00-00"):?>
						<? $end_date = show_tanggal($data[0]->end_date) ;?>
					<? endif?>
				<? elseif(isset($data)):?>
					<? $end_date =  show_tanggal($data['end_date']) ?>
				<? endif?>
				<div id="dp1" class="col-sm-2 dp1 input-append date" data-date="" data-date-format="dd-mm-yyyy" style="margin-right:10px;">
					<input type="text" id="end_date" name="end_date" class="form-control" readonly size="16" style="width:100px" value= "<?=$end_date?>">
					<span class="add-on">
						<i class="icon-th"></i>
					</span>				
				</div>
				<a href="" class="btn btn-danger btn-xs" onclick="clear_date();return false;">clear</a>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Deskripsi Acara</label>
			<div class="col-sm-9">
				<div class="wysiwyg-container">
					<textarea class="ckeditor" name="pesan"><?php if(isset($data[0]->pesan)) echo $data[0]->pesan ; else if(isset($data)) echo $data['pesan']?></textarea>
				</div>
			</div>
		</div>			
		<?if($this->uri->segment(2) != "admin_edit"){?>
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
				<a class="btn btn-success" href="" onclick="before_save();return false;">Simpan</a> <a class="btn btn-danger" href="<?= base_url();?>event/admin_index">Batal</a>
			</div>
		</div>
	</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>