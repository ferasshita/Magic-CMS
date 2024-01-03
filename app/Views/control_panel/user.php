
  <!DOCTYPE html>
  <html class="<?php echo view('includes/mode'); ?>" translate="no">
  <head>
    <?php echo view('includes/head_info'); ?>

  <style>
  @media (min-width: 768px){
  .fixed-flex-report {
  flex: 0 0 100%;
  max-width: 100%;
  }
  }@media (min-width: 992px){
  .fixed-width-form {
  flex: 0 0 100%;
  max-width: 100%;
  }
  }
  </style>

  </head>
  <body class="<?php echo lang('html_dir'); ?> <?php echo view("includes/mode"); ?> sidebar-mini fixed theme-primary">
  <!-- Site wrapper -->
  <div class="wrapper">
	  <div id="loader"></div>
  <!-- Left side column. contains the logo and sidebar -->
  <?php
  echo view('includes/navbar_main');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <div class="container-full">
  <!-- Content Header (Page header) -->
  <div class="content-header">
  <div class="d-flex align-items-center">
  <div class="mr-auto">
  <h3 class="page-title"><strong><?php echo langs('control_panel'); ?></strong></h3>
  <div class="d-inline-block align-items-center">
  <nav>
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="mdi mdi-home-outline"></i></a></li>
  <li class="breadcrumb-item active" aria-current="page"><?php echo langs('control_panel'); ?></li>
  </ol>
  </nav>
  </div>
  </div>
  </div>
  </div>

  <!-- Main content -->
  <section class="content">

  <!--Add User-->
  <div class="row">

  <div class="col-md-6 col-12 fixed-flex-report">

  <?php

 if ($found_user > 0) {
  if ($uInfo_type != "admin")
  {
  ?>
  <div class="box">
  <div class="box-header with-border">
  <h4 class="box-title"> <strong><?php echo $uInfo_un ?></strong><?php if($online == 1){echo" <span class='userActive' style='background:green'></span>";} ?></h4>
  <ul class="box-controls pull-right">
  <li><a class="box-btn-close" href="#"></a></li>
  <li><a class="box-btn-slide" href="#"></a></li>
  <li><a class="box-btn-fullscreen" href="#"></a></li>
  </ul>
  </div>

  <div class="col-lg-6 col-12 fixed-width-form">
  <div class="box">
  <?php echo $update_result; ?>
  <!-- /.box-header -->
  <form class="form" action="" method="post">
  <div class="box-body">
  <h4 class="box-title text-info"><i class="ti-user mr-15"></i> <?php echo langs('edit_profile'); ?></h4>
  <hr class="my-15">
  <div class="row">
  <div class="col-md-6">
  <div class="form-group">
  <label><?php echo langs('username'); ?></label>
  <input type="text" class="form-control" dir="auto" name="username" value="<?php echo $uInfo_un ?>"   placeholder="<?php echo langs('username'); ?>" >
  </div>
  </div>
  <div class="col-md-6">
  <div class="form-group">
  <label><?php echo langs('email'); ?></label>
  <input type="text" dir="auto" class="form-control" name="email" value="<?php echo $uInfo_em ?>"   placeholder="<?php echo langs('email'); ?>">
  </div>
  </div>
  </div>
  <div class="row">
  <div class="col-md-6">
  <div class="form-group">
  <label ><?php echo langs('phone'); ?></label>
  <input type="text" dir="auto" class="form-control" name="phone" value="<?php echo $uInfo_ph ?>"   placeholder="<?php echo langs('phone'); ?>">
  </div>
  </div>

  <div class="col-md-6">
  <div class="form-group">
  <label><?php echo langs('password'); ?></label>
  <input type="password" dir="auto" class="form-control" data-strength name="password" placeholder="<?php echo langs('password'); ?>">
  </div>
  </div>
  <div class="col-md-6">
  <div class="form-group">
  <label ><?php echo langs('admin'); ?></label>
  <select name="admin" class="form-control" >
  <option <?php if($uInfo_type == "admin"){echo "selected";} ?>><?php echo langs('yes'); ?></option>
  <option <?php if($uInfo_type == "user"){echo "selected";} ?>><?php echo langs('no'); ?></option>
  </select>
  </div>
  </div>
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
  <button type="submit" value="<?php echo langs('save_changes'); ?>" name="submit_uInfo" class="btn btn-rounded btn-primary btn-outline" >
  <i class="ti-save-alt"></i> <?php echo langs('save'); ?>
  </button>
  </div>
  </div>
  </form>
  </div>
  <!-- /.box -->
  </div>
  </div>


  <div class="col-lg-6 col-12 fixed-width-form">
  <div class="box">

  <!-- /.box-header -->
  <form class="form" action="" method="post">
  <div class="box-body">
    <h4 class="box-title text-info"> <?php echo langs('activate'); ?></h4>
    <hr class="my-15">
  <!-- /.box-body -->
  <p style="margin: 8px 0px;"><button class="btn btn-rounded btn-primary btn-outline" name="active" type="submit"><?php if($user_email_status == "not verified"){echo"Activate";}else{echo"De-activate";} ?></button></p>

  </div>
  </form>
  </div>
  <!-- /.box -->
  </div>

	<div class="col-lg-6 col-12 fixed-width-form">
	<div class="box">
	<!-- /.box-header -->
	<form class="form" action="" method="post">
	<div class="box-body">
	<h4 class="box-title text-primary"> <?php echo langs('messages'); ?></h4>
	<hr class="my-15">
	<!-- /.box-body -->
		<div dir="ltr" class="form-group">
			<div class="d-md-flex d-block justify-content-between align-items-center p-5 rounded10 b-1 overflow-hidden">
				<textarea class="form-control b-0 py-10" style="resize: none" name="msg" type="text" placeholder="<?php echo langs('write_a_message'); ?>..."></textarea>
				<div class="d-flex justify-content-between align-items-center mt-md-0 mt-30">
					<button type="submit" name="send_msg" class="waves-effect waves-circle btn btn-circle btn-primary">
						<i class="mdi mdi-send"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
	</form>

	</div>
	</div>
	  <div class="row">
		  <div class="col-lg-6 col-12 fixed-width-form">
			  <div class="box">
				  <div class="box-header with-border">
					  <h4 class="box-title"> <strong><?php echo langs('login'); ?></strong></h4>
					  <ul class="box-controls pull-right">
						  <li><a class="box-btn-close" href="#"></a></li>
						  <li><a class="box-btn-slide" href="#"></a></li>
						  <li><a class="box-btn-fullscreen" href="#"></a></li>
					  </ul>
				  </div>
				  <div class="box-body">
					  <form class="form" action="" method="post">
						  <input type="hidden" name="login_id" value="<?php echo $uInfo_id; ?>">
						  <p style="margin: 8px 0px;"><button class="btn btn-rounded btn-primary btn-outline" name="login_acc" type="submit"><?php echo langs('login'); ?></button></p>
					  </form>
				  </div>
			  </div>
			  <!-- /.box -->
		  </div>
	  </div>
	  <?php if($_ENV['PAYMENT'] == "TRUE"){ ?>
	<div class="box">

	<div class="col-lg-6 col-12 fixed-width-form">
	<div class="box">

	<!-- /.box-header -->
		<div class="box-body">
			 <h4 class="box-title text-primary"> <?php echo langs('pay'); ?></h4>
			<hr class="my-15">
		<form class="form" action="" method="post" id="postingToDBpayne">

				<input type="text" class="form-control" id="date2" dir="ltr" autocomplete="off" placeholder="<?php echo langs('date_to'); ?>" name='nex_pay' value='<?php echo"$next_date"; ?>'>
			<p style="margin: 8px 0px;"><button class="btn btn-rounded btn-primary btn-outline" name="pay" type="submit">costume</button>
		</form>
		<form style="display: inline-block" action="" method="post">
			<button class="btn btn-rounded btn-primary btn-outline" name="pay_month" type="submit">one month</button>
		</form>
		<form style="display: inline-block" action="" method="post">
			<button class="btn btn-rounded btn-primary btn-outline" name="pay_one" type="submit">one year</button>
		</form>
		<form style="display: inline-block" action="" method="post">
			<button class="btn btn-rounded btn-primary btn-outline" name="pay_two" type="submit">two years</button>
		</form>
		<form style="display: inline-block" action="" method="post">
			<button class="btn btn-rounded btn-primary btn-outline" name="pay_three" type="submit">three years</button>
		</form></p>

	</div>
	</div>
	</div>
	</div>

  <div class="box">

  <div class="col-lg-6 col-12 fixed-width-form">
  <div class="box">

  <!-- /.box-header -->
    <div class="box-body">
       <h4 class="box-title text-primary"> <?php echo langs('pay'); ?></h4>
      <hr class="my-15">
      <div class="table-responsive">

          <table class="reports_1 table table-lg invoice-archive">
              <thead>
              <tr>
                <th>#</th>
                  <th><?php echo langs('next_payment'); ?></th>
                  <th><?php echo langs('payment_date'); ?></th>
                  <th class="text-center"><span class="fa fa-cog"></span></th>
              </tr>
              </thead>
              <tbody>
  <?php
  $series = 0;
  foreach($FetchedPayment as $uInfoRowi) {
    $id = $uInfoRowi['id'];
   $next_pay = $uInfoRowi['next_pay'];
   $next_date = $uInfoRowi['date'];
   $series++;
?>
  <tr>
    <td><?php echo $series; ?></td>
    <td><?php echo $next_pay; ?></td>
    <td><?php echo $next_date; ?></td>
    <td><button class="btn btn-primary" onclick="delete_transaction('payment','<?php echo $id; ?>')"><span class="fa fa-trash"></span></button></td>
  </tr>
  <?php
}
 ?>
</tbody>
</table>

</div>
</div>
</div>
</div>


</div>
<?php } ?>

  <div class="col-lg-6 col-12 fixed-width-form">
  <div class="box">

  <!-- /.box-header -->
  <form class="form" action="" method="post">
  <div class="box-body">
    <h4 class="box-title text-danger"> <?php echo langs('sus'); ?></h4>
    <hr class="my-15">
  <!-- /.box-body -->
  <button type="submit" value="<?php echo langs('sus'); ?>" name="susbend" class="btn btn-rounded btn-danger btn-outline" >
  <i class="ti-danger"></i> <?php if($status == "0"){echo"Susbend";}else{echo"De-susbend";} ?>
  </button>
  </div>
  </form>

  </div>
  </div>
	<div class="col-lg-6 col-12 fixed-width-form">
	<div class="box">
	<!-- /.box-header -->
	<form class="form" action="" method="post">
	<div class="box-body">
	<h4 class="box-title text-danger"> <?php echo langs('remove_account'); ?></h4>
	<hr class="my-15">
	<!-- /.box-body -->
	<button type="submit" value="<?php echo langs('remove_account'); ?>" name="delete_account" class="btn btn-rounded btn-danger btn-outline" >
	<i class="ti-danger"></i> <?php echo langs('remove_account'); ?>
	</button>
	</div>
	</form>
	</div>
	</div>


	<div class="col-lg-6 col-12 fixed-width-form">
	<div class="box">
	<!-- /.box-header -->
	<form class="form" action="" method="post">
	<div class="box-body">
	<h4 class="box-title text-danger"> <?php echo langs('delete_database'); ?></h4>
	<hr class="my-15">
	<!-- /.box-body -->
	<button type="submit" value="<?php echo langs('delete_database'); ?>" name="susbend" class="btn btn-rounded btn-danger btn-outline" >
	<i class="ti-danger"></i> <?php echo langs('delete_database'); ?>
	</button>
	</div>
	</form>

	</div>
	</div>
  <!-- /.box -->
  </div>
  </div>

  <?php }else{
  if ($ed == $_SESSION['id']) {
  echo "<p class='alertRed'>".langs('uCan_access_your_data_from_settings')."</p>";
  }else{
  echo "<p class='alertRed'>".langs('uCannot_access_admin_data')."</p>";
  }
  }

  }else{
  echo "<p class='alertRed'>".langs('username_not_exists')."</p>";
  } ?>
  </div>

  </div>
  <!-- /.Add User-->
	  <div style="margin: 10px" class="text-center"><span class="text-bold font-size-16"><?php echo displayVersion(); ?></span></div>

  </section>
  <!-- /.content -->

  </div>
  </div>
  <!-- /.content-wrapper -->

  <?php
  echo view('includes/footer');
  ?>
  <!-- Control Sidebar -->

  </div>
  <!-- ./wrapper -->
  <?php echo view('includes/endJScodes'); ?>
</body>
</html>
