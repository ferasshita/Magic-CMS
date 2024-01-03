<html translate="no" dir="<? echo langs('html_dir'); ?>">
<head>
<?php echo view('includes/head_info'); ?>
<meta http-equiv="refresh" content="10000">
</head>
<body style="background:#d3d3d3" class="hold-transition <?php echo langs('html_dir'); ?> theme-primary bg-gradient-primary">


<div class="container h-p100">
<div class="row align-items-center justify-content-md-center h-p100">

<div class="col-12">
<div class="row justify-content-center no-gutters">
<div class="col-lg-4 col-md-5 col-12">
<div style="background:#FFFFFF" class="bg-white-10 rounded5">

<div class="content-top-agile p-10 pb-0">
<h2 class="text-black"><?php echo langs('forgot_password'); ?> </h2>
</div>

<div class="p-30">

<div class="form-group">
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text bg-transparent text-black"><i class="ti-lock"></i></span>
</div>
<input type="password" name="pd" id="pd" class="login_signup_textfield form-control pl-15 bg-transparent text-black plc-white" placeholder="<?php echo langs('password'); ?>"/>
</div>
</div>

<div class="form-group">
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text bg-transparent text-black"><i class="ti-lock"></i></span>
</div>
<input type="password" name="cpd" id="cpd" class="login_signup_textfield form-control pl-15 bg-transparent text-black plc-white" placeholder="<?php echo langs('confirm_password'); ?>"/>
</div>
<input type="hidden" name="passco" id="passco" value="<?php echo"$story_id"; ?>">
</div>

<div class="row">
<!-- /.col -->
<div class="col-12 text-center">
<button type="button" id="loginFunCode" class="fix-login-button btn mdc-button btn-info btn-rounded mt-10" name="send_email" id="loginFunCode"><?php echo langs('send'); ?></button>
</div>
<!-- /.col -->
</div>
<p id="login_wait" style="margin: 0px;"></p>

</div>
</div>

</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function loginUser(){
var pd = document.getElementById("pd").value;
var cpd = document.getElementById("cpd").value;
var passco = document.getElementById("passco").value;
$.ajax({
type:'POST',
url:'<?php echo base_url()."account/doforgot_verifi";?>',
data:{'pd':pd,'cpd':cpd,'passco':passco},
beforeSend:function(){
$('.fix-login-button').hide();
$('#login_wait').html("<?php echo langs('loading'); ?>...");
},
success:function(data){
$('#login_wait').html(data);
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

<!--====================================[ enter password ]====================================-->
<script src="<?php echo base_url();?>Asset/js/vendors.min.js"></script>
</body>
</html>
