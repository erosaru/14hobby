<div class="span2"></div>
<div class="span8 text-center">
	<div class="span12" style="padding:0px;">
		<input type="text" placeholder="search" style="width:500px;height:30px;">
		<a class="btn" href="#" style="margin-top:-10px;"><i class="icon-search"></i></a>
	</div>
	<div class="span12">
			<div class="span6 pull-left text-left">
				<div class="btn-group">
					<a class="btn">Full Desk</a>
					<a class="btn">Single Card</a>
					<a class="btn">Rare Card</a>
					<a class="btn">Trade / Set</a>
				</div>
			</div>
			<div class="span6 pull-right text-right">
				<a class="btn"><i class="icon-picture"></i></a>
				<a alt="" class="btn"><i class="icon-align-justify"></i></a>
			</div>		
	</div>
		
	<div class="span12 text-center" >
		<div class="span12"></div>
		<?$max = 100;?>
		<?$z = 0;?>
		<? for($i=1;$i<=$max;$i++){?>
			<?if(($z*6)+1 == $i){?>
				<div class="span12">
				<?$z++?>
			<? }?>
			<div class="span2" style="background-color:#fffcc7;height:120px;margin-bottom:10px;">
				<div class="span12" style="height:90px;">
				
				</div>
				<div class="span12">
					<center><a href="#" class="btn btn-mini btn-success">View</a></center>
				</div>
				
			</div>
			<?if($i%6 == 0 || $i==$max){?>
				</div>
			<? }?>
		<? }?>				
		<div class="span12"></div>
	</div>
</div>
<div class="span2"></div>