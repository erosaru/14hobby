<div class="col-sm-8">
	<div class="col-sm-12">
		<p>				
			Bagi teman-teman yang ingin menghubungi <a href="<?= base_url()?>">14hobby.com</a> bisa menghubungi dengan kontak di bawah:<br/>
			<table style="font-family:tahoma;font-size:12px;">
				<tr><td>Contact Person</td><td>: Ferry Lugiman</td></tr>
				<tr><td>Email</td><td>: afey13@gmail.com</td></tr>
				<!--
				<tr><td>Telepon & SMS</td><td>: (+62)85320066604</td></tr>
				<tr><td>Whatsapp</td><td>: 085320066604</td></tr>
				-->
				<tr><td>Whatsapp, SMS, Line</td><td>: 085320066604</td></tr>
				<tr><td>BBM</td><td>: 762DFF2A</td></tr>
				<tr><td>Alamat</td><td>: Jln Gandawijaya no 14. Cimahi, Jawa Barat (Toko 14)</td></tr>
			</table>
		</p>
		<p>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d990.2848694022855!2d107.5413358291562!3d-6.873886668224401!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e443816e8baf%3A0xdc15a6b126ba1c84!2sToko+14!5e0!3m2!1sen!2sid!4v1463653955798" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
		</p>
		<p>
			<ul class="fancy-tooltip-wrapper">
				<li><a target="_blank" class="tooltip-facebook" href="https://www.facebook.com/14hobby"></a></li>
			</ul>
		</p>
	</div>
	<? if($this->session->flashdata('data')): ?>
		<?$data = $this->session->flashdata('data');?>
	<?endif;?>
	<div class="col-sm-12">
		Kirim pertanyaan anda dari sini:
		<form class="form-horizontal" method="post" action="<?=base_url()?>kirim-pesan">
			<div class="form-group">
				<label class="col-sm-2 control-label">Nama</label>
				<div class="col-sm-10">
					<div class="col-sm-4" style="padding:0px;">
						<input required="required" type="text" value="<? if(isset($data)) echo $data['from'];?>" name="from" id="from" class="form-control">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<div class="col-sm-4" style="padding:0px;">
						<input required="required" type="text" value="<? if(isset($data)) echo $data['email'];?>" name="email" id="email" class="form-control">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Title</label>
				<div class="col-sm-10">
					<div class="col-sm-8" style="padding:0px;">
						<input required="required" type="text" value="<? if(isset($data)) echo $data['title'];?>" name="title" id="title" class="form-control">						
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Pesan</label>
				<div class="col-sm-10">
					<div class="col-sm-12" style="padding:0px;">
						<textarea style="width:70%;resize: none;" rows="10" required="required" name="message" id="message" class="form-control"><? if(isset($data)) echo $data['message'];?></textarea>						
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-10">
					<div class="col-sm-2" style="padding:0px;">
						<?php echo $captcha['image']; ?><br/><br/>	
						<input class="form-control" type="text" id="kode" name="kode" size="8" maxlength="8">						
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-10">
					<input type="submit" value="Kirim Pesan" class="btn btn-success">
				</div>
			</div>
		</form>
	</div>
</div>
<div class="col-sm-4">
	<?$this->load->view("client/sidebar")?>
</div>