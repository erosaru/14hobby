<script>
	tinymce.init({
		selector: "textarea",
		plugins: ["image"]
	});
	
	function clear_start_date(){
		$("#start_date").val("");
	}
	
	function clear_end_date(){
		$("#end_date").val("");
	}
	
	$(function () {
		$('#dp1').datepicker({
			startDate:new Date('<?= date("Y-m-d")?>')
		});
		$('#dp2').datepicker({
			startDate:new Date('<?= date("Y-m-d")?>')
		});
	});
</script>
<div class="row box-roomuser box-register" style>
	<? if($this->session->flashdata('data')): ?>
		<?$data = $this->session->flashdata('data');?>
	<?endif;?>
	<form id="form_event" class="form-horizontal" method="post" action="<?= base_url();?>save-daftar-event">
		<div class="form-group">
			<label class="col-sm-3 control-label text-primary">Formulir Pendaftaran Iklan Event</label>
			<div class="col-sm-9">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Email</label>
			<div class="col-sm-9">
				<div class="col-sm-3" style="padding:0px;">
					<input type="text" value="<?php if(isset($data[0]->email)) echo $data[0]->email; else if(isset($data)) echo $data['email']?>" class="form-control" name="email" id="email">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Penyelengara / EO</label>
			<div class="col-sm-9">
				<div class="col-sm-12" style="padding:0px;">
					<input type="text" value="<?php if(isset($data[0]->eo)) echo $data[0]->eo; else if(isset($data)) echo $data['eo']?>" class="form-control" name="eo" id="eo">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Nama Acara</label>
			<div class="col-sm-9">
				<div class="col-sm-12" style="padding:0px;">
					<input type="text" value="<?php if(isset($data[0]->title)) echo $data[0]->title; else if(isset($data)) echo $data['title']?>" class="form-control" name="title" id="title">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Kota</label>
			<div class="col-sm-9">
				<div class="col-sm-3" style="padding:0px;">
					<input type="text" value="<?php if(isset($data[0]->kota)) echo $data[0]->kota; else if(isset($data)) echo $data['kota']?>" class="form-control" name="kota" id="kota">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Tanggal</label>
			<div class="col-sm-9" style="padding:0px;">
				<?$start_date = ""?>
				<? if(isset($data[0]->start_date)): ?>
					<? if($data[0]->start_date != "0000-00-00"):?>
						<? $start_date = show_tanggal($data[0]->start_date) ;?>
					<? endif?>
				<? elseif(isset($data)):?>
					<? $start_date =  show_tanggal($data['start_date']) ?>
				<? endif?>
				<div id="dp1" class="col-sm-2 dp1 input-append date" data-date="" data-date-format="dd-mm-yyyy" style="margin-right:10px;">
					<input type="text" id="start_date" name="start_date" class="form-control" readonly size="16" style="width:100px" value= "<?=$start_date?>" caption="awal">
					<span class="add-on">
						<i class="icon-th"></i>
					</span>				
				</div>
				<div class="col-sm-1" style="margin-right:10px;">
					sampai
				</div>
				<?$end_date = ""?>
				<? if(isset($data[0]->end_date)): ?>
					<? if($data[0]->end_date != "0000-00-00"):?>
						<? $end_date = show_tanggal($data[0]->end_date) ;?>
					<? endif?>
				<? elseif(isset($data)):?>
					<? $end_date =  show_tanggal($data['end_date']) ?>
				<? endif?>
				<div id="dp2" class="col-sm-5 dp2 input-append date" data-date="" data-date-format="dd-mm-yyyy" style="margin-right:10px;">
					<input type="text" id="end_date" name="end_date" class="form-control" readonly size="16" style="width:100px" value= "<?=$end_date?>" caption="akhir">
					<span class="add-on">
						<i class="icon-th"></i>
					</span>				
					<a href="" class="btn btn-danger btn-xs" onclick="clear_end_date();return false;">clear</a> (Kosongkan apabila acara hanya 1hari)
				</div>
				
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
			<div class="col-sm-9">* Apabila ada poster bisa kirim email ke afey13@gmail.com berisi poster. Tim <a href="<?=base_url()?>hubungi-kami">14hobby.com</a> akan membantu menampilkan posternya<br/> * Kami juga memberikan bantuan memasangkan iklan event anda dengan mengirimkan data sesuai form beserta foto poster langsung ke email afey13@gmail.com</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<input type="submit" class="btn btn-success" value="Simpan"> <a class="btn btn-danger" href="<?= base_url();?>event">Batal</a>
			</div>
		</div>
	</form>
</div>
