<!DOCTYPE html>
<html translate="no" lang="ar" dir="<?php echo langs('html_dir'); ?>">
<head>
  <?php echo view('includes/head_info'); ?>

  <meta http-equiv="refresh" content="10000">

      <script async src="https://www.google.com/recaptcha/api.js?render=<?php echo $_ENV['GOOGLE_CAPTCHA_PUBLIC_KEY']; ?>"></script>


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
												<span class="input-group-text bg-transparent text-black"><i class="ti-email"></i></span>
											</div>
                      <input placeholder="<?php echo langs('email'); ?>" type="email" id="em" class="form-control pl-15 bg-transparent text-black plc-white" name="login_email"/>										</div>
									</div>
									  <div class="row">
										<!-- /.col -->

										<!-- /.col -->
										<div class="col-12 text-center">
										  <button type="button" id="loginFunCode" name="send_email" class="fix-login-button btn mdc-button btn-info btn-rounded mt-10"><?php echo langs('send'); ?></button>
										</div>
										<!-- /.col -->
									  </div>

                    <p id="login_wait" style="margin: 0px;"></p>
                    <?php 	if($_ENV['REGISTER_PAGE'] == "TRUE"){?>
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
      &copy; <?php echo date('Y'); ?> <?php echo langs('All_Rights_Reserved'); ?> <a href="<?php echo base_url(); ?>Dashboard"><?php echo author(); ?></a>.
  </footer>
<!--====================================[ enter email ]====================================-->
<script type="text/javascript">
  function loginUser(){
      var email = document.getElementById("em").value;
      $.ajax({
          type:'POST',
          url:'<?php echo base_url()."account/doforgotpass";?>',
          data:{'email':email},
          beforeSend:function(){
              $('.fix-login-button').hide();
              $('#login_wait').html("<?php echo langs('loading'); ?>...");
          },
          success:function(data){
              $('#login_wait').html(data);
              if (data == 1) {
                  $('#login_wait').html("<p class='alertGreen'>The email has been sent</p>");
              }else{
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
<!--====================================[  ]====================================-->
<!-- initialise material components js -->
<script src="/cryptum/demo/assets/js/material-components-web.min.js"></script>
<script>mdc.autoInit()</script>
<script>
grecaptcha.ready(function () {
    grecaptcha.execute('<?php echo $_ENV['GOOGLE_CAPTCHA_PUBLIC_KEY']; ?>').then(function (token) {
        var recaptchaResponse = document.getElementById('recaptchaResponse');
        recaptchaResponse.value = token;
});
});
</script>
<!-- page specific JS -->

<script src="<?php echo base_url();?>asset/assets/js/pages/forgot-password.js"></script>
	<script src="<?php echo base_url();?>asset/js/vendors.min.js"></script>

</body>
</html>
