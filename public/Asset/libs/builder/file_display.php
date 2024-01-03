<?php
$file = "../".htmlentities($_POST['file'], ENT_QUOTES);
$file_read = fopen($file,"r");
$display = fread($file_read,500000000);
fclose($file_read);

echo $display;
?>
