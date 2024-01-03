<?php
function sessionCI($id){
  return \Config\Services::session()->get($id);
}
function delete_ac($id,$type){
  ob_start();
  session_start();

$comman_model = new \App\Models\Comman_model();

if($type == "delete_account"){
	$remeveAccount_sql = "DELETE FROM signup WHERE id= $id";
	$IDeleted=$comman_model->run_query($remeveAccount_sql);
}


	$remeveAccount_sql = "DELETE FROM settings WHERE id= $id";
	$IsRun=$comman_model->run_query($remeveAccount_sql);

  $remeveAccount_sql = "DELETE FROM transaction WHERE user_id= $id";
	$IsRun=$comman_model->run_query($remeveAccount_sql);

  return ob_get_clean();
}
?>
<?php
function resize_image($url, $new_width) {

	// Get the image file contents from the URL
	$image_data = file_get_contents($url);

	// Create an image resource from the file contents
	$image = imagecreatefromstring($image_data);

	// Get the original width and height of the image
	$orig_width = imagesx($image);
	$orig_height = imagesy($image);

	// Calculate the new height based on the new width
	$new_height = ($new_width / $orig_width) * $orig_height;

	// Create a new image resource with the new dimensions
	$new_image = imagecreatetruecolor($new_width, $new_height);

	// Copy the original image to the new image with the new dimensions
	imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);

	// Output the resized image to the browser
	header('Content-Type: image/jpeg');
	imagejpeg($new_image);

	// Clean up the image resources
	imagedestroy($image);
	imagedestroy($new_image);
}
?>
<?php
function displayVersion() {
return $_ENV['PROJECT_VERSION'];
}
?>
<?php
function file_upload($path,$name,$accept,$size){
	LoadLang();
	$image = addslashes(file_get_contents($_FILES[$name]['tmp_name']));
	$image_name = addslashes($_FILES[$name]['name']);
	$image_size = getimagesize($_FILES[$name]['tmp_name']);

	$post_fileName = $_FILES[$name]["name"];
	$post_fileTmpLoc = $_FILES[$name]["tmp_name"];
	$post_fileType = $_FILES[$name]["type"];
	$post_fileSize = $_FILES[$name]["size"];
	$post_fileErrorMsg = $_FILES[$name]["error"];
	$post_fileName = preg_replace('#[^a-z.0-9]#i', '', $post_fileName);
	$post_kaboom = explode(".", $post_fileName);
	$post_fileExt = end($post_kaboom);
	$post_fileName = time().rand().".".$post_fileExt;

	if (!$post_fileTmpLoc) {
		$location = '<p class="error_msg">'.langs('errorPost_n2').'</p>';
	}else{
		//================[ if image size more than 8Mb ]================
		if($size != NULL && $post_fileSize > $size) {
			$location = '<p class="error_msg">'.langs('errorPost_n3').'</p>';
			unlink($post_fileTmpLoc);
		} else {
			//================[ if image format not supported ]================
			if ($accept != NULL && !preg_match("/.($accept)$/i", $post_fileName) ) {
				$location = '<p class="error_msg">'.langs('errorPost_n4').'</p>';
				unlink($post_fileTmpLoc);
			} else {
				//================[ if an error was found ]================
				if ($post_fileErrorMsg == 1) {
					$location = '<p class="error_msg">'.langs('errorPost_n5').'</p>';
				}else{

					move_uploaded_file($_FILES[$name]["tmp_name"], "Asset/upload/$path/" .$post_fileName);
					$location = "Asset/upload/$path/" .$post_fileName;
					$img = resize_img($location, 200, 200);
				}}}}
	return $location;
}
function resizeimage($file, $newWidth, $newHeight, $destination) {
// Get the original image size and create a new image with the given dimensions
	list($width, $height) = getimagesize($file);
	$image = imagecreatetruecolor($newWidth, $newHeight);

// Load the original image and resize it
	$original = imagecreatefromstring(file_get_contents($file));
	imagecopyresampled($image, $original, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

// Save the resized image to the destination path
	return imagepng($image, $destination);
}
?>
<?php
function browsing($table_name,$column,$id){
	ob_start();
	session_start();

$comman_model = new \App\Models\Comman_model();

	if($id != NULL){
		$id = "user_id = '".$_SESSION['id']."'";
	}
	echo "<datalist id='br_$column'>";

	$browsing = "SELECT DISTINCT $column FROM $table_name WHERE 1 $id";
	$FetchData=$comman_model->get_all_data_by_query($browsing);
	foreach ($FetchData as $postsfetch ) {
		$value = $postsfetch[$column];
		echo "<option value='$value'>";
	}
	echo "</datalist>";
	return ob_get_clean();
}
?>
<?php
function count_table($table_name,$column,$value,$sid){
	ob_start();
	session_start();

$comman_model = new \App\Models\Comman_model();

	helper(
			array('numkmcount')
	);

	if($sid != NULL){
		$where = " AND user_id = '$sid'";
	}
	if($value != NULL){
		$where_to = "AND $column = '$value'";
	}
	$count = 0;
	$emExist = "SELECT $column FROM $table_name WHERE 1 $where";
	$FetchData=$comman_model->get_all_data_by_query($emExist);
	foreach ($FetchData as $postsfetch) {
		$count =+ 1;
	}
	$emExist = "SELECT DISTINCT $column FROM $table_name WHERE 1 $where $where_to";
	$FetchData=$comman_model->get_all_data_by_query($emExist);
	foreach ($FetchData as $postsfetch) {
		$value = $postsfetch[$column]; ?>
		<div class="col-xl-3 col-md-6 col-12 ">
			<div id="container_<?php echo $value; ?>" class="box box-inverse">
				<div class="box-body">
					<div class="flexbox">
						<h5><?php echo $value; ?></h5>
						<div class="dropdown">
							<span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ion-android-more-vertical rotate-90"></i></span>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#"><i class="ion-android-refresh"></i> Refresh</a>
							</div>
						</div>
					</div>

					<div class="text-center my-2">
						<div class="font-size-60"><?php if($count == "" ){echo "0";}else{echo thousandsCurrencyFormat($count);} ?></div>
						<span><?php echo $value; ?></span>
					</div>
				</div>
			</div>
		</div>
		<script>
			function setup_<?php echo $value; ?>(){

				var container = document.getElementById("container_<?php echo $value; ?>");

				for (var i = 0; i < 1; i++) {
					var colors = random_bg_color();
					container.style.backgroundColor = colors;

				}
			}
			setup_<?php echo $value; ?>()
		</script>
	<?php } ?>
	<?php
	return ob_get_clean();
}
?>
<?php
function settings_output($type,$id){
	session_start();

$comman_model = new \App\Models\Comman_model();


	$uisql = "SELECT * FROM settings WHERE user_id= '$id' AND type='$type'";
	$udata=$comman_model->get_all_data_by_query($uisql);
	$count_val = count($udata);
	foreach ($udata as $postsfetch ) {
		$value = $postsfetch['value'];
	}
	if($type == "profile_img" && $count_val < 1){
		$value = "Asset/imgs/user-male.png";
	}
	if($type == "profile_back" && $count_val < 1){
		$value = "Asset/imgs/1.jpg";
	}
	return $value;
}
?>
<?php
function settings($type,$access,$value){
	ob_start();
	session_start();

$comman_model = new \App\Models\Comman_model();

	$sid = $_SESSION['id'];

		$access_id = $sid;

	if($_SESSION[$type] != $value) {
		$uisql = "SELECT * FROM settings WHERE user_id= '$sid' AND type='$type'";
		$udata = $comman_model->get_all_data_by_query($uisql);
		$count_set = count($udata);
		if ($count_set > 0) {
			$data = array(
					'value' => $value,
			);
			$where = array('user_id' => $access_id, 'type' => $type);
			$update_info = $comman_model->update_entry("settings", $data, $where);
		} else {
			$iptdbsqli = "INSERT INTO settings
  (user_id,type,value,access)
  VALUES
  ($access_id, '$type', '$value', '$access')
  ";
			$insert_post_toDBi = $comman_model->run_query($iptdbsqli);
		}
		$_SESSION[$type] = $value;
	}
	return ob_get_clean();
}
?>
<?php
function table_view($table_name,$column,$filter){
	ob_start();
	session_start();
$CI = \Config\Services::request();
$comman_model = new \App\Models\Comman_model();
	?>
	<div class="table-responsive">
		<table class="reports_1 table table-lg invoice-archive reports_1">
			<thead>
			<tr>
				<th>#</th>
				<th><?php echo langs('Username'); ?></th>
				<?php
				if($column != NULL){
					foreach($column as $column_name => $value){ ?>
						<th><?php echo lang($value); ?></th>
					<?php }
				}else{
					$fields = $comman_model->getFieldData($table_name);
					foreach ($fields as $postsfetchi)
					{
						if($postsfetchi->name == "user_id" || $postsfetchi->name == "id"){}else{
							echo "<th>".lang($postsfetchi->name)."</th>";
						}
					}
				}
				?>
				<th><span class="fa fa-cog"></span></th>
			</tr>
			</thead>
			<tbody>
			<?php
			$q = filter_var(htmlentities($CI->getGet('q')),FILTER_SANITIZE_STRING);
			$val = filter_var(htmlentities($CI->getGet('val')),FILTER_SANITIZE_STRING);
			if($q != NULL && $val != NULL){
				$filter = "AND $q='$val'";
			}
			$vpsql = "SELECT * FROM $table_name WHERE 1 $filter ORDER BY id DESC";
			$result=$comman_model->get_all_data_by_query($vpsql);
			foreach ($result as $postsfetch)
			{
				$post_id = $postsfetch['id'];
				$user_id = $postsfetch['user_id'];
				if($column != NULL){
					foreach($column as $column_name => $value){
						${"var".$value} = $postsfetch[$column_name];
					}
				}else{
					$fields = $comman_model->getFieldData($table_name);
					foreach ($fields as $postsfetchi)
					{
						if($postsfetchi->name == "user_id" || $postsfetchi->name == "id"){}else{
							${"var".$postsfetchi->name} = $postsfetch[$postsfetchi->name];
						}
					}
				}
				$vpsql = "SELECT * FROM signup WHERE id='$user_id'";
				$result=$comman_model->get_all_data_by_query($vpsql);
				foreach ($result as $postsfetchi)
				{
					$username = $postsfetchi['username'];
				}
				$acc_colum += 1;
				echo"<tr id='tr_$post_id'>
  <td> $acc_colum</td>
  <td> $username</td>
";
				if($column != NULL){
					foreach($column as $column_name => $value){
						echo "<td><a href='?q=$column_name&val=".${"var".$value}."'> ".${"var".$value}."</a></td>";
					}
				}else{
					$fields = $comman_model->getFieldData($table_name);
					foreach ($fields as $postsfetchi)
					{
						if($postsfetchi->name == "user_id" || $postsfetchi->name == "id"){}else{
							echo "<td>".${"var".$postsfetchi->name}."</td>";
						}
					}
				}
				echo"
  <td class='text-center'>
  <div class='list-icons d-inline-flex'>
  <div class='list-icons-item dropdown'>
  <a href='#' class='list-icons-item dropdown-toggle' data-toggle='dropdown'><i class='fa fa-file-text'></i></a>
  <div class='dropdown-menu dropdown-menu-right'>
  <a href='#' onclick=\"print_co('$post_id')\" class='dropdown-item'><i class='fa fa-print'></i> ".langs('print')."</a>
  <div class='dropdown-divider'></div>
  <a href='#' onclick=\"delete_transaction('$table_name','$post_id')\" style='color:#d71717' class='dropdown-item'><i class='fa fa-remove'></i> ".langs('delete')."</a>
  </div>
  </div>
  </div>
  </td>
  </tr>";
			}
			?></tbody>
		</table>

	</div>

	<?php
	return ob_get_clean();
}
?>
<?php
function form_back($table,$form_array){
	ob_start();
	session_start();

	$sid = $_SESSION['id'];
	// You may need to load the model if it hasn't been pre-loaded
$comman_model = new \App\Models\Comman_model();
	$pid = filter_var(htmlentities($_GET['pid']),FILTER_SANITIZE_STRING);
	if($pid == $table) {
		$table_data = array(
				'id' => $sid,
				'user_id' => $sid,
		);
		foreach ($form_array as $name => $settings) {
			${'var_' . $name} = filter_var(htmlspecialchars($_POST[$name]), FILTER_SANITIZE_STRING);
			$table_data = array($name => ${'var_' . $name},);
		}

		$inserted = $comman_model->insert_entry($table, $table_data);

		if (isset($inserted)) {
			echo "<span class='success_msg'>" . langs('changes_saved_seccessfully') . "</span>";
		} else {
			echo "<span class='error_msg'>" . langs('errorSomthingWrong') . "</span>";
		}
	}
	return ob_get_clean();
}
?>
<?php
function form_view($form_array){
	ob_start();
	session_start();

$comman_model = new \App\Models\Comman_model();?>
	<div class="box">
		<div class="box-header">
			<h4><?php echo langs('add_image'); ?></h4>
		</div>
		<div class="box-body">
			<form action="<?php echo base_url(); ?>item/add_item" id="postingToDB" method="post" enctype="multipart/form-data">
				<?php foreach ($form_array as $name => $settings){ ?>
					<div class="form-group">
						<label><?php echo lang($name); ?></label>
						<input type="text" name="<?php echo $name; ?>" title="" id="<?php echo $name; ?>" value="" autocomplete="off" placeholder="<?php echo lang($name); ?>" class="form-control font-size-20">
					</div>
				<?php } ?>
				<div class="box-footer">
					<div class="loadingPosting"></div>
					<button type="submit" value="<?php echo langs('save_changes'); ?>"class="btn btn-rounded btn-primary btn-outline" >
						<i class="ti-save-alt"></i> <?php echo langs('save'); ?>
					</button>
				</div>

			</form>
		</div>
	</div>
	<?php return ob_get_clean();
}
?>
