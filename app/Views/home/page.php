<!DOCTYPE html>
<html class="<?php echo view('includes/mode'); ?>">
<head>
	<?php echo view("includes_site/head_info"); ?>
</head>
<body>

<div class="wrapper animate-bottom">
	<div id="loader"></div>
	<!-- navbar -->

	<!-- /navbar -->

	<!-- Content Wrapper. Contains page content -->
<style>
.blog-block{
	margin-left: 300px;
	margin-right: 300px;
	min-height: 800px;
}
@media (max-width: 575px) {
	.blog-block{
		margin-left: 10px;
		margin-right: 10px;
		min-height: 800px;
	}
}
.blog-header{
	background: #ffffff;
	padding: 5px;
	height: 73.2px;
}
.blog-footer{
	background: #ffffff;
	padding: 5px;
	height: 45px;
}
img{
	width: 100%;
	height: 500px;
	margin-bottom:25px;
	margin-top:25px;
}
</style>
<header class="blog-header">
    <h1 class="logo" style="display: inline-block"><?php echo project_name(); ?></h1>
</header>
			<section class="content">
				<div class="blog-block">
				<h1><strong><?php echo $title; ?></strong></h2>
					<p><?php echo $description; ?></p>
				<div>
					<?php if($blog_img != NULL){ ?>
						<img src="<?php echo $blog_img; ?>" alt="<?php echo $title; ?>">
				<?php	} ?>
					<?php echo $blog_text; ?>
				</div>
				<br>
			</div>
			</section>
			<footer class="blog-footer">
				<div style="margin:8px">
				&copy; <?php echo date('Y'); ?> <?php echo langs('All_Rights_Reserved'); ?> <a href="<?php echo base_url(); ?>Dashboard"><?php echo project_name(); ?></a>.
</div>
			</footer>

	<!-- /.content-wrapper -->
</div>

<!-- endJS -->
<?php echo view("includes_site/endJScodes"); ?>
<!-- /endJS -->
</body>
</html>
