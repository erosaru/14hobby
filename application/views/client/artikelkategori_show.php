<div class="span8 dashboard-wrapper">
	<?if($turneyrutin->num_rows > 0){?>
		<h2>Turnamen Rutin (<?= $turneyrutin->num_rows?>)</h2>	
		<? foreach($turneyrutin->result() as $row){?>
			<div class="widget">
				<div class="widget-header" id="detail-<?= create_title($row->title)?>">
					<b><?= $row->title?></b>
					<span class="pull-right"><?= date("d F Y", strtotime($row->created_date))?></span>
				</div>
				<div class="widget-body">
					<?= $row->pesan?>
				</div>
			</div>
		<?}?>
	<?}?>
	<?if($turneyspesial->num_rows > 0){?>
		<h2>Turnamen Spesial (<?= $turneyspesial->num_rows?>)</h2>
		<? foreach($turneyspesial->result() as $row){?>
			<div class="widget">
				<div class="widget-header" id="detail-<?= create_title($row->title)?>">
					<b><?= $row->title?></b>
					<span class="pull-right"><?= date("d F Y", strtotime($row->created_date))?></span>
				</div>
				<div class="widget-body">
					<?= $row->pesan?>
				</div>
			</div>
		<?}?>
	<?}?>
	
</div>
<div class="span1"></div>