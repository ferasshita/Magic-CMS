<style type="text/css">
body{
background: #fff;
}
.error_page_btn{
background: whitesmoke;
padding: 8px;
border-radius: 3px;
color: #6b6b6b;
text-decoration: none;
box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.05);
transition: background 0.1s , color 0.1s;
}
.error_page_btn:hover, .error_page_btn:focus{
background: #4a708e;
color: #fff;
text-decoration: none;
}
.error_div{
padding: 15px;
max-width: 800px;
color: #383838;
box-shadow: none;
border: 1px solid rgba(217, 217, 217, 0.36);
}
</style>
<div align="center" style="margin-top: 150px;margin-bottom: 150px;">
<div class="post error_div" style="border-radius:10px;" align="center">
<h1 style="font-weight: bold;"><img src="<?php echo base_url(); ?>Asset/imgs/main_icons/1f915.png" style="width: 80px;height: 80px;" /> <?php echo lang('profilePageNotFound_str1'); ?></h1>
<h3><?php echo lang('profilePageNotFound_str2'); ?></h3><br>
<a href="javascript:history.back()" style="border-radius:4px;" class="error_page_btn"><?php echo lang('profilePageNotFound_str3'); ?></a>
</div></div>

