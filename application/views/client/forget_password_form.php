<div class="col-md-2">&nbsp;</div>
<div class="col-md-8">
	<div class="sign-in-container">
		<form class="login-wrapper" name="login" method="post" action="<?=base_url()?>send-reset-password">
			<div class="header">
                <div class="row">
                    <div class="col-md-12">
						<h3 style="color:#337ab7">Forget Password</h3>
                    </div>
                </div>
            </div>
			<div class="content">
				<div class="row" style="margin-bottom:10px;">
                    <div class="col-sm-12">
						<input required="required" class="form-control input email" placeholder="Email" id="email" name="email" class="text-type" type="text">
                    </div>
                </div>
				<!--
                <div class="row" style="margin-bottom:10px;">
					<div class="col-sm-3">
						<input required="required" class="form-control input password" id="pin_password" name="pin_password" class="text-type" type="password" placeholder="PIN" maxlength="8">
                    </div>
                </div>
				-->
				<div class="row" style="margin-bottom:10px;">
					<div class="col-sm-12">
						<?php echo $captcha['image']; ?><br/>&nbsp;<br/>
						<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>
					</div>
                </div>
				<div class="actions" style="text-align:right;">
					<input class="btn btn-success btn-sm" name="Login" type="submit" value="reset password" style="float:none;">
                    <div class="clearfix"></div>
                </div>
			</div>
		</form>
	</div>
</div>
<div class="col-md-2">&nbsp;</div>
<div class="clearfix"></div>