
<div class="row">
	<div class="col-12">
		<div class="box">
			<div class="box-body">
				<form id="postingToDB" class="form" action="<?php echo base_url();?>Setting/download/" method="post">
					<!-- new password input -->
					<div style="padding-top: 21px;">

						<!-- password input -->
						<div class="form-group"><label><?php echo langs('current_password'); ?></label>
							<input type="password" name="general_current_pass" placeholder="<?php echo langs('current_password'); ?>" class="form-control">

						</div>

						<button name="general_save_changes" type="submit" class="btn btn-rounded btn-primary btn-outline">
							<?php echo langs('download'); ?>
						</button>

					</div>
					<div class="loadingPosting"></div>
				</form>
			</div>
		</div>
	</div>

</div>
