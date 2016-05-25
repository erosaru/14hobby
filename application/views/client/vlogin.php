<script language="javascript">
	function clear_text(){
		$('#username').val("");
		$('#password').val("");
		$('#username').focus();				
	}
	$('#username').focus();
</script>
<div class="col-md-2">&nbsp;</div>
<div class="col-md-8">
	<div class="sign-in-container">
		<form class="login-wrapper" method="post" name="login" action="<?php echo base_url(); ?>login/login_process">
			<div class="header">
                <div class="row">
                    <div class="col-md-12">
						<h3 style="color:#337ab7">Login<!--<img src="img/logo1.png" alt="Logo" class="pull-right">--></h3>
                    </div>
                </div>
            </div>
			<div class="content">
				<div class="row" style="margin-bottom:10px;">
                    <div class="col-sm-12">
						<input name="username" required="required" class="form-control input email" placeholder="Username" id="username" class="text-type" type="text">
                    </div>
                </div>
                <div class="row" style="margin-bottom:10px;">
					<div class="col-sm-12">
						<input name="password" required="required" class="form-control input password" id="password" class="text-type" type="password" placeholder="Password">
                    </div>
                </div>
				<div class="actions" style="text-align:right;">
                    <a href="<?=base_url()?>signup" style="color:#85c226;" >Belum punya ID ?</a>
					<a href="<?=base_url()?>forget-password" style="color:#d43f3a;" >Lupa password ?</a>
					<input class="btn btn-success btn-sm" name="Login" type="submit" value="submit" style="float:none;">
					
                    <div class="clearfix"></div>
                </div>

				<p class="error-password"></p>
			</div>
		</form>
	</div>
</div>
<div class="col-md-2">&nbsp;</div>
<div class="clearfix"></div>