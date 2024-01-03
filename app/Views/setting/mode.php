
	<div class="row">
	<div class="col-12">
	<div class="box">
	<div class="box-body">
	<form action="<?php echo base_url();?>Setting/Savemode/" id="postingToDB" method="post">
	<div>

	<div class="controls">
	<fieldset>
	<input name="mode"
	value="auto"
	id="checkbox_1"

	type="radio"
	<?php  if($_SESSION['mode'] == "auto"){echo"checked";} ?>>
	<label for="checkbox_1"><?php echo langs('auto'); ?></label>
	</fieldset>
	</div>
	<div class="controls">
	<fieldset>
	<input name="mode"
	value="night"
	id="checkbox_2"

	type="radio"
	<?php  if($_SESSION['mode'] == "night"){echo"checked";} ?>>
	<label for="checkbox_2"><?php echo langs('night'); ?></label>
	</fieldset>
	</div>
	<div class="controls">
	<fieldset>
	<input name="mode"
	value="light"
	id="checkbox_3"

	type="radio"
	<?php  if($_SESSION['mode'] == "light"){echo"checked";} ?>>
	<label for="checkbox_3"><?php echo langs('light'); ?></label>
	</fieldset>
	</div>



	</div>
	<div style="padding-top: 21px;">
	<!-- password input -->
	<button name="mode_save_changes" type="submit" class="btn btn-rounded btn-primary btn-outline">
	<?php echo langs('save_changes'); ?>
	</button>

	</div>
		<div class="loadingPosting"></div>
	</form>
	</div>
	</div>
	</div>
	</div>
