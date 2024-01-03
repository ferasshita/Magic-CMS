<?php
$t=time();
time_ago($t);

$this->comman_model = new \App\Models\Comman_model();

$emExist = "SELECT account_type FROM signup";
$FetchData=$this->comman_model->get_all_data_by_query($emExist);
foreach ($FetchData as $postsfetch) {
$account_type = $postsfetch['account_type'];
${"count_" . $account_type} = 0;
${"count_" . $account_type} += 1;
}
$emExist = "SELECT id FROM signup";
$FetchData=$this->comman_model->get_all_data_by_query($emExist);
$count_all = count($FetchData);
?>
<!DOCTYPE html>
<html class="<?php echo view('includes/mode'); ?>" translate="no" lang="<?php echo langs('html_lang'); ?>">
<head>
  <?php echo view('includes/head_info'); ?>

    <style>
        .exchange-calculator  .select2-container {
            margin-top: 0px;
        }
        .input-group {

            width: 50%;
        }
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
<body  class="<?php echo lang('html_dir'); ?> <?php echo view("includes/mode"); ?> sidebar-mini fixed theme-primary">
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


                <!-- button of reports -->
                <div class="row">

                  <div class="col-xl-3 col-md-6 col-12 ">
                      <div class="box box-inverse box-success">
                        <div class="box-body">
                          <div class="flexbox">
                            <h5><?php echo langs('accountss'); ?></h5>
                            <div class="dropdown">
                              <span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ion-android-more-vertical rotate-90"></i></span>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="ion-android-refresh"></i> Refresh</a>
                              </div>
                            </div>
                          </div>

                          <div class="text-center my-2">
                            <div class="font-size-60"><?php if($count_all == "" ){echo "0";}else{echo thousandsCurrencyFormat($count_all);} ?></div>
                            <span><?php echo langs('accountss'); ?></span>
                          </div>
                        </div>
                      </div>
                  </div>
<?php
$emExist = "SELECT DISTINCT account_type FROM signup";
$FetchData=$this->comman_model->get_all_data_by_query($emExist);
foreach ($FetchData as $postsfetch) {
$account_type = $postsfetch['account_type']; ?>
<div class="col-xl-3 col-md-6 col-12 ">
    <div id="container_<?php echo $account_type; ?>" class="box box-inverse">
      <div class="box-body">
        <div class="flexbox">
          <h5><?php echo $account_type; ?></h5>
          <div class="dropdown">
            <span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ion-android-more-vertical rotate-90"></i></span>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#"><i class="ion-android-refresh"></i> Refresh</a>
            </div>
          </div>
        </div>

        <div class="text-center my-2">
          <div class="font-size-60"><?php if(${"count_" . $account_type} == "" ){echo "0";}else{echo thousandsCurrencyFormat(${"count_" . $account_type});} ?></div>
          <span><?php echo $account_type; ?></span>
        </div>
      </div>
    </div>
</div>
<script>
        function setup_<?php echo $account_type; ?>(){

            var container = document.getElementById("container_<?php echo $account_type; ?>");

            for (var i = 0; i < 1; i++) {
                var colors = random_bg_color();
                container.style.backgroundColor = colors;

            }
        }
setup_<?php echo $account_type; ?>()
</script>
<?php } ?>


                  <!-- /.col -->
              </div>
                <!--./ button of reports -->

                <!--Tabel deital-->
                <div class="row">



                            <div class="col-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h4 class="box-title"><?php echo langs('users'); ?></h4>
										<ul class="box-controls pull-right">
											<li><a class="box-btn-close" href="#"></a></li>
											<li><a class="box-btn-slide" href="#"></a></li>
											<li><a class="box-btn-fullscreen" href="#"></a></li>
										</ul>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">

                                            <table class="reports_1 table table-lg invoice-archive">
                                                <thead>
                                                <tr>
                                                  <th>#</th>
                                                    <th><?php echo langs('name'); ?></th>
                                                    <th><?php echo langs('phone'); ?></th>
                                                    <th><?php echo langs('email'); ?></th>
                                                    <th><?php echo langs('account_setup'); ?></th>
                                                    <th class="text-center"><span class="fa fa-cog"></span></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                  <?php
                                                  $serial =0;
                                                $cusers_q_sql = "SELECT * FROM signup";
                                            		$FetchedData=$this->comman_model->get_all_data_by_query($cusers_q_sql);
                                                  foreach($FetchedData as $rows) {
                                                    $serial += 1; ?>
                                                    <tr>
                                                      <td>
                                                          <a><p><?php echo $serial; ?>
                                                      </td>
                                                        <td>
                                                            <a><p><?php echo $rows['username']; ?><?php if( $rows['account_type'] == "admin"){echo" <span style='color:blue' class='fa fa-check-circle verifyUser'></span>";}if($rows['online'] == 1){echo" <span class='userActive' style='background:green'></span>";}if($rows['sus'] == "1"){echo" <span style='color:red' class='fa fa-warning'></span>";}echo"</p></a>";?>
                                                        </td>
                                                        <td>
                                                            <a href="tel:<?php echo $rows['phone']; ?>"><p><?php echo $rows['phone']; ?></p></a>
                                                        </td>
                                                        <td >
                                                            <a href="mailto:<?php echo $rows['email']; ?>"><p><?php echo $rows['email']; ?></p></a>
                                                        </td>
                                                        <td >
                                                            <a><p><?php echo $rows['account_setup']; ?></p></a>
                                                        </td>
                                                        <td><a href="control_panel/user?ed=<?php echo $rows['id']; ?>" class="btn"><?php echo langs('edit_delete_dashboard'); ?></a></td>
                                                    </tr><?php } ?>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>


                </div>
                <!-- /.Tabel deital-->

                <!--Add User-->
                <!--Add User-->
                <div class="row">



                            <div class="col-lg-6 col-12 fixed-width-form">
                                <div class="box">
									<div class="box-header with-border">
										<h4 class="box-title"> <strong><?php echo langs('create_account'); ?></strong></h4>
										<ul class="box-controls pull-right">
											<li><a class="box-btn-close" href="#"></a></li>
											<li><a class="box-btn-slide" href="#"></a></li>
											<li><a class="box-btn-fullscreen" href="#"></a></li>
										</ul>
									</div>
                                    <!-- /.box-header -->
                                        <div class="box-body">
                                            <h4 class="box-title text-info"><i class="ti-user mr-15"></i> <?php echo langs('create_account') ?></h4>
                                            <hr class="my-15">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo langs('username'); ?></label>
                                                        <input type="text" class="form-control login_signup_textfield" id="un" name="signup_username"  placeholder="<?php echo langs('username'); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="ph_dev">
                                                    <div class="form-group">
                                                        <label><?php echo langs('phone'); ?></label>
                                                        <input type="number" class="form-control login_signup_textfield" id="fn" name="signup_fullname"  placeholder="<?php echo langs('phone'); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6" id="em_dev">
                                                    <div class="form-group">
                                                        <label ><?php echo langs('email'); ?></label>
                                                        <input type="email" class="form-control login_signup_textfield" id="em" name="signup_email"  placeholder="<?php echo langs('email'); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label ><?php echo langs('account_type'); ?></label>
                                                        <select name="typt" class="form-control" id="typt">
                                                            <option value="user"><?php echo langs('user'); ?></option>
                                                            <option value="admin"><?php echo langs('admin'); ?></option>

                                                        </select>                                                    </div>
                                                </div>

                                                <div class="col-md-6"  id="pw_dev">
                                                    <div class="form-group">
                                                        <label ><?php echo langs('password'); ?></label>
                                                        <input type="password" data-strength class="form-control login_signup_textfield" name="signup_cpassword" id="pd"  placeholder="<?php echo langs('password'); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6"  id="cpw_dev">
                                                    <div class="form-group">
                                                        <label ><?php echo langs('confirm_password'); ?></label>
                                                        <input type="password" class="form-control login_signup_textfield"name="signup_username"  id="cpd"  placeholder="<?php echo langs('confirm_password'); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                            <div class="box-footer">
                                                <button id="signupFunCode" type="submit" class="login_signup_btn2 btn btn-rounded btn-primary btn-outline" >
                                                    <i class="ti-save-alt"></i> Save
                                                </button>
                                            </div>
                                        <p id="login_wait" style="margin: 0px;"></p>
                                        </div>
                                    <script type="text/javascript">
                                        function signupUser(){
                                            var fullname = document.getElementById("fn").value;
                                            var username = document.getElementById("un").value;
                                            var emailAdd = document.getElementById("em").value;
                                            var password = document.getElementById("pd").value;
                                            var cpassword = document.getElementById("cpd").value;
                                            var typt = document.getElementById("typt").value;
                                            $.ajax({
                                                type:'POST',
                                                url:'<?php echo base_url()."account/doregister";?>',
                                                data:{'req':'admin_sign','csrf_token':'<?php echo $token; ?>','fn':fullname,'un':username,'em':emailAdd,'pd':password,'cpd':cpassword,'gr':'sign','typ':typt},
                                                beforeSend:function(){
                                                    $('.login_signup_btn2').hide();
                                                    $('#login_wait').html("<b><?php echo langs('creating_your_account'); ?></b>");
                                                },
                                                success:function(data){
                                                    $('#login_wait').html(data);
                                                    if (data == 1) {
                                                        $('#login_wait').html("<p class='alertGreen'><?php echo langs('done'); ?>..</p>");
                                                    }else{
                                                        $('.login_signup_btn2').show();
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

                                        $(".login_signup_textfield").keypress( function (e) {
                                            if (e.keyCode == 13) {
                                                signupUser();
                                            }
                                        });
                                    </script>
                                </div>
                                <!-- /.box -->
                            </div>

                        </div>
				<div style="margin: 10px" class="text-center"><span class="text-bold font-size-16"><?php echo displayVersion(); ?></span></div>

                <!-- /.Add User-->

            </section>
            <!-- /.content -->

        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php //include "../includes/footer.php";
    echo view('includes/footer');
    ?>
    <!-- Control Sidebar -->

</div>

<!-- ./wrapper -->
<?php echo view('includes/endJScodes'); ?>
</body>
</html>
