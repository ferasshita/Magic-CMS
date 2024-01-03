
<div class="row">
	<div class="col-12">
		<div class="box">
			<div class="box-body">
				<form class="form" id="postingToDB" action="<?php echo base_url();?>Setting/Savepassword/" method="post">
					<!-- new password input -->
					<div class="form-group"><label><?php echo langs('new_password'); ?></label>
						<input type="password" data-strength name="new_pass" placeholder="<?php echo langs('new_password'); ?>*" class="form-control" >

					</div>

					<!-- confirm new password input -->
					<div class="form-group"><label><?php echo langs('confirm_new_password'); ?></label>
						<input type="password"  name="rewrite_new_pass" placeholder="<?php echo langs('confirm_new_password'); ?>*" class="form-control" >

					</div>

					<div style="padding-top: 21px;">

						<!-- password input -->
						<div class="form-group"><label><?php echo langs('current_password'); ?></label>
							<input type="password"  name="general_current_pass" placeholder="<?php echo langs('current_password'); ?>" class="form-control">

						</div>

						<button name="general_save_changes" type="submit" class="btn btn-rounded btn-primary btn-outline">
							<?php echo langs('save_changes'); ?>
						</button>

					</div>
					<div class="loadingPosting"></div>
				</form>
			</div>
		</div>
	</div>

</div>
