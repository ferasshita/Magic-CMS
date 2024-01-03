
<div class="row">
<div class="col-12">
<div class="box">
<div class="box-body">
<form id="postingToDB" action="<?php echo base_url();?>Setting/DeleteAccount/" method="post" onsubmit="return delvgj()">

<div>
<div style="background: rgba(247, 81, 81, 0.14); color: #f75151;margin:4px; padding: 15px; border: 1px solid #f75151; border-radius: 3px;"><?php echo langs('remove_account_note'); ?></div>
<input class="form-control" type="password" name="removeA_current_pass" placeholder="<?php echo langs('current_password'); ?>" required />
<div class="box-body">
<p style="margin: 0;"><button class="btn btn-rounded btn-danger btn-outline" name="removeA_save_changes" type="submit"><?php echo langs('remove_account'); ?></button></p>
</div>
</div>
	<div class="loadingPosting"></div>
</form>
</div>
</div>
</div>
</div>
