<?php
$user_id = session('id', null);
$page_name = $page;
$title = $title;
?>
<script>// dont_write</script>
<title><?php echo project_name(); ?> - <?php if($page_name){echo $page_name;}else{echo $title;} ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="description" content="<?php echo descrition(); ?>">
<meta name="keywords" content="<?php echo project_name(); ?>, <?php echo $page_name; ?>, <?php echo author(); ?>">
<meta name="author" content="<?php echo author(); ?>">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="canonical" href="<?php echo base_url(); ?>" />

<meta property="og:url" content="<?php echo base_url(); ?>" />
<meta property="og:type" content="Currency exchange mangement software" />
<meta property="og:title" content="<?php if($page_name){echo $page_name;}else{echo $title;} ?>" />
<meta property="og:description" content="" />

<link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url(); ?>Asset/imgs/logo.ico' />
<link rel="stylesheet" href="<?php echo base_url(); ?>Asset/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>Asset/css/font-awesome-4.5.0/css/font-awesome.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>Asset/css/vendors_css.css">


<script src="<?php echo base_url(); ?>Asset/js_back/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>Asset/js_back/jquery.form.min.js"></script>
<script src="<?php echo base_url(); ?>Asset/js_back/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>Asset/js_back/code.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>Asset/js_back/jquery.maxlength.js"></script>

<link rel="manifest" href="<?php echo base_url(); ?>Asset/manifest.json">

<script>

function random_bg_color(){
    var x = Math.floor(Math.random() * 256);
    var y = Math.floor(Math.random() * 256);
    var z = Math.floor(Math.random() * 256);
    var bgColor = "rgb(" + x + "," + y + "," + z + ")";
    return bgColor;
}
</script>
<script>
$(function(){$('div[onload]').trigger('onload');})
</script>
<script>// /dont_write</script>
