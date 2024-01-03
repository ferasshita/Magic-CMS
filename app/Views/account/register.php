<!DOCTYPE html>
<html translate="no" lang="en">
<head>
<?php echo view('includes/head_info'); ?>
<meta http-equiv="refresh" content="10000">
<script async src="https://www.google.com/recaptcha/api.js?render=6LdW8-wcAAAAAJPf-MhF-XyZNhhxKsJZnkxyMoiE"></script>
</head>

<body style="background:#d3d3d3" class="hold-transition <?php echo langs('html_dir'); ?> theme-primary bg-gradient-primary">

<div class="container h-p100">
<div class="row align-items-center justify-content-md-center h-p100">

<div class="col-12">
<div class="row justify-content-center no-gutters">
<div class="col-lg-4 col-md-5 col-12">
<div style="background:#FFFFFF" class="bg-white-10 rounded5">

<div class="content-top-agile p-10 pb-0">
<h2 class="text-black"><?php echo langs('create_account'); ?><s></s> <samp class="fixed-font"><strong>مجاني</strong></samp> </h2>
</div>

<div class="p-30">

<div class="form-group">
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text bg-transparent text-black"><i class="ti-user"></i></span>
</div>
<input  type="text" id="un" title="name" name="signup_username" placeholder="<?php echo langs('username'); ?>" class="form-control pl-15 bg-transparent text-black plc-white">
</div>
</div>

<div class="form-group">
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text bg-transparent text-black"><i class="ti-email"></i></span>
</div>
<input type="email" title="example@email.com" name="signup_email"  id="em" placeholder="<?php echo langs('email'); ?>" class="form-control pl-15 bg-transparent text-black plc-white">
</div>
</div>

<div class="col-12">
<div class="checkbox text-black">
<p><?php echo langs('dont_have_email'); ?> <a style=" color: #0080ff;" target="_blank" href="https://accounts.google.com/SignUp"><?php echo langs('create_one'); ?></a>.</p>
</div>
</div>

<div class="form-group">
<div class="input-group">
<div class="input-group-prepend" style="width:28%">
<select class="form-control bg-transparent" name="phone_code" id="phone_code">
<option value="218" title="218">Libya(+218)</option>
<?php foreach($phones as $key => $value) { ?>
<option value="<?= htmlspecialchars($key) ?>" title="<?= $key ?>"><?= $value ?></option>
<?php } ?>
</select>
</div>

<input type="number" title="9xxxxxxxx" id="fn" name="signup_fullname" maxlength="16" placeholder="<?php echo langs('phone'); ?> 9xxxxxxxx" class="form-control pl-15 bg-transparent text-black plc-white">
</div>
</div>

<div class="form-group">
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text bg-transparent text-black"><i class="ti-lock"></i></span>
</div>
<input  placeholder="<?php echo langs('password'); ?>" type="password" id="pd" name="signup_password" aria-controls="pw-validation-msg" autocomplete="current-password" data-strength class="form-control pl-15 bg-transparent text-black plc-white" >
</div>
</div>

<input type="hidden" name="recaptcha_response" id="recaptchaResponse">

<div class="form-group">
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text bg-transparent text-black"><i class="ti-lock"></i></span>
</div>
<input style="text-align: start;"placeholder="<?php echo langs('confirm_password'); ?>"type="password"id="cpd"name="signup_password" autocomplete="current-password" class="form-control pl-15 bg-transparent text-black plc-white" >
</div>
</div>

<div class="row">
<div class="col-12">
<div class="checkbox text-black">
<p><?php echo langs('by_clicking_signup_str'); ?> <a style=" color: #0080ff;" href="terms"><?php echo langs('terms'); ?></a>, <a style=" color: #0080ff;" href="terms"><?php echo langs('privacyPolicy'); ?></a> <?php echo langs('and'); ?> <a style=" color: #0080ff;" href="terms"><?php echo langs('cookie_use'); ?></a>.</p>
</div>
</div>
<!-- /.col -->
<div class="col-12 text-center">
<button type="submit" id="signupFunCode" class="btn btn-info btn-rounded margin-top-10"><?php echo langs('create_account'); ?></button>
</div>
<!-- /.col -->
</div>

<input type="hidden" name="gender" value="sign" id="gr">

<p id="login_wait" style="margin: 0px;"></p>

<div class="text-center">
<p class=" mdc-typography--body2 mdc-theme--on-surface fix-login-in-register " style="color:#0080ff;"><?php echo langs('already_have_an_account'); ?> <a href="login" style="color:#ff3f3f;"><?php echo langs('login'); ?></a></p>
</div>

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
&copy; <?php echo date('Y'); ?> <?php echo langs('All_Rights_Reserved'); ?> <a href="<?php echo base_url(); ?>Dashboard"><?php echo author(); ?></a>.
</footer>

<script type="text/javascript">
function signupUser(){
var fullname = document.getElementById("fn").value;
var phone_code = document.getElementById("phone_code").value;
var username = document.getElementById("un").value;
var emailAdd = document.getElementById("em").value;
var password = document.getElementById("pd").value;
var cpassword = document.getElementById("cpd").value;
var recaptchaResponses = document.getElementById("recaptchaResponse").value;

$.ajax({
type:'POST',
url:'<?php echo base_url()."account/doregister";?>',
data:{'req':'sign','csrf_token':'<?php echo $token; ?>','fn':fullname,'un':username,'em':emailAdd,'pd':password,'cpd':cpassword,'recaptchaResponses':recaptchaResponses,'phone_code':phone_code},
beforeSend:function(){
$('.btn-rounded').hide();
$('#login_wait').html("<b><?php echo langs('creating_your_account'); ?></b>");
},
success:function(data){
console.log(data);
if (data == 1) {
$('#login_wait').html("<p class='alertGreen'><?php echo langs('done'); ?>..</p>");
setTimeout(' window.location.href = "<?php echo base_url();?>Email_verification"; ',2000);
}else{
$('#login_wait').html(data);
$('.btn-rounded').show();
recapx();
}
},
error:function(err){
alert(err);
}
});
}

$('#signupFunCode').click(function(){
signupUser();
});

$(".form-control").keypress( function (e) {
if (e.keyCode == 13) {
signupUser();
}
});
</script>

<script>
$(function() {

function passwordCheck(password) {
if (password.length >= 8)
strength += 1;

if (password.match(/(?=.*[0-9])/))
strength += 1;

if (password.match(/(?=.*[!,%,&,@,#,$,^,*,?,_,~,<,>,])/))
strength += 1;

if (password.match(/(?=.*[a-z])/))
strength += 1;

if (password.match(/(?=.*[A-Z])/))
strength += 1;

displayBar(strength);
}

function displayBar(strength) {
switch (strength) {
case 1:
$("#password-strength span").css({
"width": "20%",
"background": "#de1616"
});
break;

case 2:
$("#password-strength span").css({
"width": "40%",
"background": "#de1616"
});
break;

case 3:
$("#password-strength span").css({
"width": "60%",
"background": "#de1616"
});
break;

case 4:
$("#password-strength span").css({
"width": "80%",
"background": "#FFA200"
});
break;

case 5:
$("#password-strength span").css({
"width": "100%",
"background": "#06bf06"
});
break;

default:
$("#password-strength span").css({
"width": "0",
"background": "#de1616"
});
}
}

$("[data-strength]").after("<div id=\"password-strength\" class=\"strength\"><span class=\"pst\"></span></div>")

$("[data-strength]").focus(function() {
$("#password-strength").css({
"height": "7px"
});
}).blur(function() {
$("#password-strength").css({
"height": "0px"
});
});

$("[data-strength]").keyup(function() {
strength = 0;
var password = $(this).val();
passwordCheck(password);
});

});
</script>

<!-- Vendor JS -->
<script src="js/vendors.min.js"></script>

<script>
grecaptcha.ready(function () {
grecaptcha.execute('<?php echo $captcha['public_key']; ?>').then(function (token) {
var recaptchaResponse = document.getElementById('recaptchaResponse');
recaptchaResponse.value = token;
});
});
</script>
<script>
function recapx(){
grecaptcha.ready(function () {
grecaptcha.execute('<?php echo $captcha['public_key']; ?>').then(function (token) {
var recaptchaResponse = document.getElementById('recaptchaResponse');
recaptchaResponse.value = token;
});
});
}
</script>
</body>
</html>
