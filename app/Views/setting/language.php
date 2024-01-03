
	<div class="row">
	<div class="col-12">
	<div class="box">
	<div class="box-body">
	<form id="postingToDB" action="<?php echo base_url();?>Setting/Savelanguage" method="post">
	<div class="form-group"><label><?php echo langs('language'); ?></label>
	<select class="form-control"  name="edit_language" >
	<option <?php if($_SESSION['language'] == "English"){ echo "selected";} ?> >English</option>
	<option <?php if($_SESSION['language'] == "العربية"){ echo "selected";} ?> >العربية</option>
	</select>
	</div>
	<div style="padding-top: 21px;">

	<!-- password input -->


	<button name="lang_save_changes" type="submit" class="btn btn-rounded btn-primary btn-outline">
	<?php echo langs('save_changes'); ?>
	</button>

	</div>
		<div class="loadingPosting"></div>
	</form>
	<!-- =======================================language select ==========================================-->
	</div>
	</div>
	</div>
	</div>
