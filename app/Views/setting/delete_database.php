
<div class="row">
<div class="col-12">
<div class="box">
<div class="box-body">
<form id="postingToDB" action="<?php echo base_url();?>Setting/DeleteDatabase/" onsubmit="return fgfgdsg()" method="post">
<div >
<div style="background: rgba(247, 81, 81, 0.14); color: #f75151;margin:4px; padding: 15px; border: 1px solid #f75151; border-radius: 3px;"><?php echo langs('delete_db_note'); ?></div>
<p><input class="form-control" type="password" name="removexj_current_pass" placeholder="<?php echo langs('current_password'); ?>" required /></p>
<div class="box-body">
<p style="margin: 0;">
<button class="btn btn-rounded btn-danger btn-outline" id="remove_accountas" name="removexj_save_changes" type="submit"><?php echo langs('delete_database'); ?></button>
</p>
</div>
	<div class="loadingPosting"></div>

</form>
</div>
</div>
</div>
</div>
