<?php LoadLang();
?>
<!DOCTYPE html>
<html translate="no" lang="ar" dir="<?php echo langs('html_dir'); ?>">
<head>
<?php echo view('includes/head_info'); ?>
<meta http-equiv="refresh" content="10000">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<meta name="google-signin-client_id" content="<?php echo $_ENV['GOOGLE_SIGNUP_PUBLIC_KEY']; ?>.apps.googleusercontent.com">

</head>
<body style="background:#d3d3d3" class="hold-transition <?php echo langs('html_dir'); ?> theme-primary bg-gradient-primary">

<div class="container h-p100">
<div class="row align-items-center justify-content-md-center h-p100">

<div class="col-12">
<div class="row justify-content-center no-gutters">
<div class="col-lg-4 col-md-5 col-12">
<div style="background:#FFFFFF" class="bg-white-10 rounded5">

<div class="content-top-agile p-10 pb-0">
<h2 class="text-black"><?php echo langs('login'); ?> </h2>
</div>

<div class="p-30">

<div class="form-group">
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text bg-transparent text-black"><i class="ti-user"></i></span>
</div>
<input type="text" name="login_username" id="un" placeholder="<?php echo langs('email_or_username'); ?>"  aria-label="<?php echo langs('email_or_username'); ?>" class="form-control pl-15 bg-transparent text-black plc-white">
</div>
</div>

<div class="form-group">
<div class="input-group mb-3" >

<div class="input-group" id="show_hide_password">
<div class="input-group-prepend">
<span class="input-group-text bg-transparent text-black"><i class="ti-lock" aria-hidden="true"></i></span>
</div>
<input placeholder="<?php echo langs('password'); ?>"
type="password"
id="pd"
name="signup_password" aria-label="<?php echo langs('password'); ?>" aria-controls="pw-validation-msg"
autocomplete="current-password" style="border-<?php echo langs('left_invers'); ?>:none" class="form-control pl-15 bg-transparent text-black plc-white">
<div class="input-group-addon" style="background:transparent;border-<?php echo langs('homeLinks'); ?>:none">
<a aria-label="password toggle" href="javascript:void(0)"><i id="eye" class="fa fa-eye-slash" aria-hidden="true"></i></a>
</div>
</div>

</div>
</div>

<div class="row">
<div class="col-6">
<div class="fog-pwd text-right">
<a href="forgot_password" class="text-black hover-warning"><i class="ion ion-locked"></i> <?php echo langs('forgot_password'); ?></a><br>
</div>
</div>
<div class="col-12 text-center">
<button type="submit" aria-label="<?php echo langs('login'); ?>" id="loginFunCode" class="fix-login-button btn mdc-button btn-info btn-rounded mt-10"><?php echo langs('login'); ?></button>
</div>

</div>
	<p id="login_wait" style="margin: 0px;"></p>

	<?php if($google_client_id != NULL){ ?>
		<div class="col-12 text-center">
			<div class="g-signin2 " data-onsuccess="onSignIn"></div>
		</div>
	<?php } ?>
<?php if($_ENV['REGISTER_PAGE'] == "TRUE"){ ?>
<div class="text-center">
<p class="mdc-typography--body2 mdc-theme--on-surface fix-phone-p" style="color: #0080ff;"> <?php echo langs('dont_have_an_account'); ?> <a href="register" style="color:#ff3f3f;"> <?php echo langs('signup'); ?></a></p>
</div>
<?php } ?>

</div>
</div>
</div>
</div>
</div>
</div>
</div>

<footer class="main-footer" style="margin-right:0;margin-left:0">
<div class="pull-right d-none d-sm-inline-block">
<ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
<li class="nav-item">
<a class="nav-link" accesskey="e" href="?lang=English">English</a> &bull; <a class="nav-link" accesskey="a" href="?lang=العربية">العربية</a>
</li>
</ul>
</div>
&copy; <?php echo date('Y'); ?> <?php echo langs('All_Rights_Reserved'); ?> <a href="<?php echo base_url(); ?>Dashboard"><?php echo project_name(); ?></a>.
</footer>

<script type="text/javascript">
function loginUser(){
var username = document.getElementById("un").value;
var password = document.getElementById("pd").value;
$.ajax({
type:'POST',
url:'<?php echo base_url()."account/dologin";?>',
data:{'req':'login_code','un':username,'pd':password,'csrf_token':'<?php echo $token; ?>',},
beforeSend:function(){
$('.fix-login-button').hide();
$('#login_wait').html("<?php echo langs('loading'); ?>...");
},
success:function(data){
if (data == 1) {
$('#login_wait').html("<p class='alertGreen'><?php echo langs('welcome'); ?>..</p>");
setTimeout(' window.location.href = "<?php echo base_url()."Dashboard";?>"; ',2000);
}else{
$('#login_wait').html(data);
$('.fix-login-button').show();
}
},
error:function(err){
alert(err);
}
});
}
$('#loginFunCode').click(function(){
loginUser();
});
$(".form-control").keypress( function (e) {
if (e.keyCode == 13) {
loginUser();
}
});
</script>
<script>
	function onSignIn(googleUser) {
		// Get the user's ID token
		var id_token = googleUser.getAuthResponse().id_token;
		// Send the ID token to your server using AJAX
		$.ajax({
			type: 'POST',
			url: 'account/dogoogle',
			data: {id_token: id_token},
			success: function(data) {
				// Handle the response from the server
				if (data == 1) {
					setTimeout(' window.location.href = "<?php echo base_url()."Dashboard";?>"; ',2000);
				}
			}
		});
	}

</script>
<script>
$(document).ready(function() {
$("#show_hide_password a").on('click', function(event) {
event.preventDefault();
if($('#show_hide_password input').attr("type") == "text"){
$('#show_hide_password input').attr('type', 'password');
$('#show_hide_password #eye').addClass( "fa-eye-slash" );
$('#show_hide_password #eye').removeClass( "fa-eye" );
}else if($('#show_hide_password input').attr("type") == "password"){
$('#show_hide_password input').attr('type', 'text');
$('#show_hide_password #eye').removeClass( "fa-eye-slash" );
$('#show_hide_password #eye').addClass( "fa-eye" );
}
});
});
</script>

<!-- Vendor JS -->
<script src="<?php echo base_url();?>Asset/js/vendors.min.js"></script>

</body>
</html>
