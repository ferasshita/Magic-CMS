
<div class="row">
	<div class="col-12">
		<div class="box">
			<div class="box-body">
				<form id="postingToDB" class="form" action="<?php echo base_url(); ?>setting/savebugs" method="post">

					<!-- username input -->
					<div class="form-group">Title</label>
						<input type="text" name="title" placeholder="title" class="requ form-control" >
					</div>
					<div class="form-group"><label>description</label>
						<textarea type="text"  name="description" placeholder="Descripe the problem.." class="regu form-control" ></textarea>
					</div>
						<button name="general_save_changes" type="submit" class="btn btn-rounded btn-primary btn-outline">
							<?php echo langs('send'); ?>
						</button>

					</div>
<div class="loadingPosting"></div>
			</form>
			</div>
		</div>
	</div>

</div>
