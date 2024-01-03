<!DOCTYPE html>
<html class="<?php echo view('includes/mode'); ?>">
<head>
	<?php echo view("includes/head_info"); ?>
</head>
<body class="<?php echo langs('html_dir'); ?> <?php echo view("includes/mode"); ?> sidebar-mini fixed theme-primary">

<div class="wrapper animate-bottom">
	<div id="loader"></div>
	<!-- navbar -->
	<?php echo view("includes/navbar_main.php"); ?>
	<!-- /navbar -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<div class="container-full">
			<!-- Main content -->
			<section class="content">
				<div class="box">
					<div class="box-header">
						<h3><?php echo langs('blog'); ?></h3>
					</div>
					<form action="<?php echo base_url();?>dashboard/add_blog" method="post" id="postingToDB" enctype="multipart/form-data" >
					<div class="box-body">
						<div class="form-group">
							<label><?php echo langs('title'); ?></label>
							<input type="text" name="title" id="title" value="<?php echo $title; ?>" autocomplete="off" placeholder="<?php echo langs('title'); ?>" class="form-control">
						</div>
						<div class="form-group">
							<label><?php echo langs('image'); ?></label>
							<input type="file" name="image" id="title" accept="image/*" class="form-control">
						</div>
						<div class="form-group">
												<textarea id="editor1" name="blog_text" placeholder="Place some text here" rows="10" cols="80">
																<?php echo $blog_text; ?>
												</textarea>
											</div>
									<div class="form-group">
										<label><?php echo langs('blog'); ?></label>
										<input type="text" name="blog" value="<?php echo $blog; ?>" id="blog" autocomplete="off" placeholder="<?php echo langs('blog'); ?>" class="form-control">
									</div>
									<div class="controls">
									<fieldset>
									<input name="see" value="auto" id="hidden" type="radio" <?php if($see != '1'){echo "checked";} ?>>
									<label for="hidden">Hidden</label>
									</fieldset>
									</div>
									<div class="controls">
									<fieldset>
									<input name="see" value="auto" id="visble" type="radio" <?php if($see == '1'){echo "checked";} ?>>
										<label for="visble">Visble</label>
									</fieldset>
									</div>
									<input type="hidden" name="id" value="<?php echo $pid; ?>"
						<div class="box-footer">
							<div class="loadingPosting"></div>
							<button type="submit" class="btn btn-rounded btn-primary btn-outline" name="post_now">
								<?php echo langs('add'); ?>
							</button>
						</div>
					</div>
					</div>
					</form>
						<div class="row" id="refresh">
							<div class="box">
								<div class="box-body">
							<div class="table-responsive">
								<table class="reports_1 table table-lg invoice-archive reports_1">
									<thead>
									<tr>
										<th>#</th>
										<th><?php echo langs('blog_name'); ?></th>
										<th><?php echo langs('blog'); ?></th>
										<th><?php echo langs('author'); ?></th>
										<th><span class="fa fa-cog"></span></th>
									</tr>
								</thead>
								<tbody>
					<?php
					$serial = 0;
					foreach ($udata as $postsfetch ) {
					$id = $postsfetch['id'];
					$title = $postsfetch['title'];
					$blog_img = $postsfetch['blog_img'];
					$blog = $postsfetch['blog'];
					$serial++;
?>
<tr id="tr_<?php echo $id; ?>">
<td><?php echo $serial; ?></td>
<td><a href="<?php echo base_url()."home/blog/".$id; ?>"><?php echo $title; ?></a></td>
<td><?php echo $blog; ?></td>
<td><?php echo $author; ?></td>
<td>
	<button class="btn btn-danger fa fa-trash" onclick="delete_transaction('blog','<?php echo $id; ?>')"></button>
	<a href="?pid=<?php echo $id; ?>"><button class="btn btn-info fa fa-pencil"></button></a>
</td>
</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
	</div>
	</div>
					</div>
			</section>

		</div>
	</div>
	<!-- /.content-wrapper -->

	<!-- footer -->
	<?php echo view("includes/footer"); ?>
	<!-- /footer -->
</div>

<!-- endJS -->
<?php echo view("includes/endJScodes"); ?>
<!-- /endJS -->
<script src="<?php echo base_url(); ?>Asset/js/pages/editor.js"></script>
<script src="<?php echo base_url(); ?>Asset/assets/vendor_components/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>Asset/assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script>
<script src="<?php echo base_url(); ?>Asset/assets/vendor_components/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>Asset/js/pages/editor.js"></script>
</body>
</html>
