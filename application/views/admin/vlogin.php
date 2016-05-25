<script language="javascript">
	function validasi(){
		if ($("#username").val() == ""){
			alert("Anda belum mengisikan Username.");
			$("#username").focus();
			return false;
		}
			 
		if ($("#password").val() == ""){
			alert("Anda belum mengisikan Password.");
			$("#password").focus();
			return false;
		}
				
		$.post("<?php echo base_url(); ?>loginadmin/login_process", {username:$('#username').val(), password:$('#password').val()}, function(hasil){
			if(hasil.search("Username")>-1){
				alert(hasil);
				$("#username").focus();
			}	
			else
				window.location=('<?=base_url()?>'+hasil);
		});
		return false;
	}
			
	function clear_text(){
		$('#username').val("");
		$('#password').val("");
		$('#username').focus();				
	}
	$('#username').focus();
</script>
<div class="span3">&nbsp;</div>
<div class="span6">
	<div class="sign-in-container">
		<form class="login-wrapper" name="login">
			<div class="header">
                <div class="row-fluid">
                    <div class="span12">
						<h3>Login<!--<img src="img/logo1.png" alt="Logo" class="pull-right">--></h3>
                        <p>Fill out the form below to login.</p>
                    </div>
                </div>
            </div>
			<div class="content">
				<div class="row-fluid">
                    <div class="span12">
						<input required="required" class="input span12 email" placeholder="username" id="username" class="text-type" type="text">
                    </div>
                </div>
                <div class="row-fluid">
					<div class="span12">
						<input required="required" class="input span12 password" id="password" class="text-type" type="password" placeholder="Password">
                    </div>
                </div>
				<div class="actions">
					<input onclick="return(validasi());" class="btn btn-danger" name="Login" type="submit" value="Login" >
                    <div class="clearfix"></div>
                </div>

				<p class="error-password"></p>
			</div>
		</form>
	</div>
</div>
<div class="span3">&nbsp;</div>
<div class="clearfix"></div>