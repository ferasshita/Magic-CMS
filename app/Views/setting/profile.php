
  <div class="row">
  <div class="col-12">
  <div class="box">
  <div class="box-body">
  <form class="form" id="postingToDB" action="<?php echo base_url();?>Setting/Saveprofile" method="post" enctype="multipart/form-data">

  <!-- name input -->
  <div class="form-group"><label><?php echo langs('logo'); ?></label>
  <input type="file" name="logo" class="form-control" accept="image/ico">
  </div>

  <div class="form-group"><label><?php echo langs('app_url'); ?></label>
  <input type="text" name="app_url" value="<?php echo base_url(); ?>" placeholder="<?php echo langs('app_url'); ?>" class="form-control">
  </div>
  <div class="form-group"><label><?php echo langs('app_name'); ?></label>
  <input type="text" name="app_name" value="<?php echo $_ENV['PROJECT_NAME']; ?>" placeholder="<?php echo langs('app_name'); ?>" class="form-control">
  </div>
  <div class="form-group"><label><?php echo langs('app_description'); ?></label>
  <input type="text" name="app_description" value="<?php echo $_ENV['PROJECT_DESCRIPTION']; ?>" placeholder="<?php echo langs('app_description'); ?>" class="form-control">
  </div>
  <div class="form-group"><label><?php echo langs('author'); ?></label>
  <input type="text" name="app_author" value="<?php echo $_ENV['PROJECT_AUTHOR']; ?>" placeholder="<?php echo langs('author'); ?>" class="form-control">
  </div>

  <div style="padding-top: 21px;">

  <!-- password input -->
  <div class="form-group"><label><?php echo langs('current_password'); ?></label>
  <input type="password"  name="EditProfile_current_pass" placeholder="<?php echo langs('current_password'); ?>" class="form-control">
  </div>
  <div class="loadingPosting"></div>

  <button name="EditProfile_save_changes" type="submit" class="btn btn-rounded btn-primary btn-outline">
  <?php echo langs('save_changes'); ?>
  </button>

  </form>
  </div>
  </div>
  </div>
  </div>
  </div>
