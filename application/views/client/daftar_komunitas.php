<div class="span8" style="background-color:white;padding:10px;border-radius:10px;margin-bottom:5px;border:2px solid black;">
	<h1>Daftarkan Komunitas Hobi Anda</h1>
	<?php $this->load->view("client/list_komunitas_form") ?>
</div>
<div class="span4">
	<div class="span12 text-center box-informasi">
		Banyak teman-teman yang daftar secara gratis di <a href="<?=base_url();?>">14Hobby</a>. Bisa teman-teman liat sendiri<br/>
		<a href="<?base_url()?>list-komunitas" class="btn btn-success btn-big">Lihat List Komunitas</a>
	</div>
	<?= another_menu("event") ?>
</div>