<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Setting extends Controller {

public function __construct(){

	helper(
			['langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info']);

			$this->comman_model = new \App\Models\Comman_model();
		LoadLang();

}

public function index(){
	///check login
	Checklogin(base_url());
	CheckMailVerification();
	$data["dircheckPath"]= base_url()."Asset/";
	$mode=LoadMode();
	$data["tc"] = 'edit_profile';
	$data["layoutmode"]  =   $mode;
	$s_id = $_SESSION['id'];
	$s_username = $_SESSION['username'];

$data['title'] = "";
	$data['pid'] = $this->request->getGet('pid');

	$sid = sessionCI('id');
	$cusers_q_sql = "SELECT * FROM devices where user_id='$sid'";
	$data['fetchdivice']=$this->comman_model->get_all_data_by_query($cusers_q_sql);

	if( $this->request->getGet('pid') == NULL){
		$data['page'] = "Settings";
	}else{
		$data['page'] = $this->request->getGet('pid');
	}


	echo view('setting/index',$data);

}
public function Savebugs()
{
	$sid=$_SESSION['id'];
	$title = filter_var(htmlentities($this->request->getPost('title')),FILTER_SANITIZE_STRING);
	$description = filter_var(htmlentities($this->request->getPost('description')),FILTER_SANITIZE_STRING);
	$data = array(
		'user_id'   => $sid,
		'title'      => $title,
		'description'	=>	$description
	);
	$this->comman_model->insert_entry("bugs",$data);
	echo"<span class='success_msg'>".langs('changes_saved_seccessfully')."</span>";
}
public function Saveprofile(){
	LoadLang();

	$app_url = filter_var(htmlentities($this->request->getPost('app_url')),FILTER_SANITIZE_STRING);
	$app_name = filter_var(htmlentities($this->request->getPost('app_name')),FILTER_SANITIZE_STRING);
	$app_description = filter_var(htmlentities($this->request->getPost('app_description')),FILTER_SANITIZE_STRING);
	$app_author = filter_var(htmlentities($this->request->getPost('app_author')),FILTER_SANITIZE_STRING);

	$EditProfile_current_pass_var = filter_var(htmlentities($this->request->getPost('EditProfile_current_pass')),FILTER_SANITIZE_STRING);
	// =============================[ Save Edit profile settings ]==============================
	if (NULL !==($EditProfile_current_pass_var)) {
	if (!password_verify($EditProfile_current_pass_var,sessionCI('Password'))) {
	echo "<p id='error_msg'>".langs('current_password_is_incorrect')."</p>";

	}else{
		if(!empty($_FILES['logo'])) {
		$image = addslashes(file_get_contents($_FILES['logo']['tmp_name']));
		$image_name = addslashes($_FILES['logo']['name']);
		$image_size = getimagesize($_FILES['logo']['tmp_name']);

		$post_fileName = $_FILES['logo']["name"];
		$post_fileTmpLoc = $_FILES['logo']["tmp_name"];
		$post_fileType = $_FILES['logo']["type"];
		$post_fileSize = $_FILES['logo']["size"];
		$post_fileErrorMsg = $_FILES['logo']["error"];
		$post_kaboom = explode(".", $post_fileName);
		$post_fileExt = end($post_kaboom);
		$post_fileName = "logo.".$post_fileExt;

		if (!$post_fileTmpLoc) {
			echo  '<p class="error_msg">'.langs('errorPost_n2').'</p>';
		}else{

				//================[ if image format not supported ]================

					//================[ if an error was found ]================
					if ($post_fileErrorMsg == 1) {
						echo '<p class="error_msg">'.langs('errorPost_n5').'</p>';
					}else{

						move_uploaded_file($_FILES['logo']["tmp_name"], "Asset/imgs/" .$post_fileName);
						//echo  "imgs/" .$post_fileName;
					//	$img = resize_img($location, 200, 200);
				}}
							}else{
			$blog_img="";
		}
		$filePath = '../.env';

		// Read the content of the file
		$fileContent = file_get_contents($filePath);

		// Perform the replacement
		$fileContent = preg_replace(
				'/(app\.baseURL\s*=\s*)(.*)/',
				'app.baseURL = ' . $app_url,
				$fileContent
		);

		$fileContent = preg_replace(
				'/(PROJECT_NAME\s*=\s*)(.*)/',
				'PROJECT_NAME = "' . $app_name .'"',
				$fileContent
		);

		$fileContent = preg_replace(
			'/(PROJECT_AUTHOR\s*=\s*)(.*)/',
			'PROJECT_AUTHOR = "' . $app_author .'"',
				$fileContent
		);

		$fileContent = preg_replace(
			'/(PROJECT_DESCRIPTION\s*=\s*)(.*)/',
			'PROJECT_DESCRIPTION = "' . $app_description .'"',
				$fileContent
		);

		// Write the modified content back to the file
		$update_info = file_put_contents($filePath, $fileContent);

	if ($update_info) {
		echo"<span class='success_msg'>".langs('changes_saved_seccessfully')."</span>";
	} else {
		echo"<span class='error_msg'>".langs('errorSomthingWrong')."</span>";
	}

	}
}else{
	echo "Password please.";
}
}
public function Savepassword(){
	$sid=$_SESSION['id'];
	$new_password_var_field = filter_var(htmlentities($this->request->getPost('new_pass')),FILTER_SANITIZE_STRING);
	$options = array(
		'cost' => 12,
	);
	$new_password_var = password_hash($new_password_var_field, PASSWORD_BCRYPT, $options);
	// ================================================================================
	$rewrite_new_password_var = filter_var(htmlentities($this->request->getPost('rewrite_new_pass')),FILTER_SANITIZE_STRING);
	$general_current_pass_var = filter_var(htmlentities($this->request->getPost('general_current_pass')),FILTER_SANITIZE_STRING);
	if (empty($new_password_var_field) AND empty($rewrite_new_password_var)) {
		$new_password_var = $_SESSION['Password'];
	}elseif ($new_password_var_field != $rewrite_new_password_var) {
		echo "<p class='error_msg'>".langs('new_password_doesnt_match_the_confirm_field')."</p>";
return false;
	}
	$id = $_SESSION['id'];
$update_info = 1;
		if($new_password_var_field != ""){
			$data = array(
				'Password'   => $new_password_var,
			);
			$where=array('id' => $id);
			$update_info=$this->comman_model->update_entry("signup",$data,$where);
			$_SESSION['Password'] = $new_password_var;
		}
		if (NULL !==($update_info)) {
			echo"<span class='success_msg'>".langs('changes_saved_seccessfully')."</span>";
		} else {
			echo"<span class='error_msg'>".langs('errorSomthingWrong')."</span>";
		}


}

public function download(){
	$sid=$_SESSION['id'];
	$general_current_pass_var = filter_var(htmlentities($this->request->getPost('general_current_pass')),FILTER_SANITIZE_STRING);
	// =============================[ Save Edit profile settings ]==============================

	if (!password_verify($general_current_pass_var,sessionCI('Password'))) {
		echo "<p class='error_msg'>".langs('current_password_is_incorrect')."</p>";
	}else {
//============================[download data]=================================

	}
}
public function Savegeneral(){
 LoadLang();
 $sid=$_SESSION['id'];
	$fullname_var = filter_var(htmlentities($this->request->getPost('edit_fullname')),FILTER_SANITIZE_STRING);
 $username_var = filter_var(htmlentities($this->request->getPost('edit_username')),FILTER_SANITIZE_STRING);
 $email_var = filter_var(htmlentities($this->request->getPost('edit_email')),FILTER_SANITIZE_STRING);
 // =========================== password hashinng ==================================

 $general_current_pass_var = filter_var(htmlentities($this->request->getPost('general_current_pass')),FILTER_SANITIZE_STRING);
 // =============================[ Save Edit profile settings ]==============================
 if (!password_verify($general_current_pass_var,sessionCI('Password'))) {
echo "<p class='error_msg'>".langs('current_password_is_incorrect')."</p>";
 }else{
 if (empty($fullname_var) or empty($username_var) or empty($email_var)) {
echo "<p class='error_msg'>".langs('please_fill_required_fields')."</p>";
 } else {

 if(strpos($username_var, ' ') !== false || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/', $username_var) || !preg_match('/[A-Za-z0-9]+/', $username_var)) {
echo  "
 <ul class='error_msg' style='list-style:none;'>
 <li><b>".langs('username_not_allowed')." :</b></li>
 <li><span class='fa fa-times'></span> ".langs('signup_username_should_be_1').".</li>
 <li><span class='fa fa-times'></span> ".langs('signup_username_should_be_2').".</li>
 <li><span class='fa fa-times'></span> ".langs('signup_username_should_be_3').".</li>
 <li><span class='fa fa-times'></span> ".langs('signup_username_should_be_4').".</li>
 <li><span class='fa fa-times'></span> ".langs('signup_username_should_be_5').".</li>
 </ul>";
return false;
 }
 $unExist = "SELECT username FROM signup WHERE username = '$username_var' ";
 $udata=$this->comman_model->get_all_data_by_query($unExist);
 $unExistCount = count($udata);
 if ($unExistCount > 0) {
 if ($username_var != $_SESSION['username']) {
echo"<p class='error_msg'>".langs('user_already_exist')."</p>";
	 return false;
 }
 }

 $unExist = "SELECT email FROM signup WHERE email = '$email_var' ";
 $udata=$this->comman_model->get_all_data_by_query($unExist);

 $emExistCount = count($udata);
 if ($emExistCount > 0) {
 if ($email_var != $_SESSION['email']) {
echo "<p class='error_msg'>".langs('email_already_exist')."</p>";
	 return false;
 }
 }
 if (!filter_var($email_var, FILTER_VALIDATE_EMAIL)) {
echo "<p class='error_msg'>".langs('invalid_email_address')."</p>";
	 return false;
 }
 $data = array(
 'phone'   => $fullname_var,
 'username'   => $username_var,
 'email'   => $email_var,
 );
 $session_un = $_SESSION['username'];
 $where=array('id' => $sid);
 $update_info=$this->comman_model->update_entry("signup",$data,$where);

 if (NULL !==($update_info)) {
 $_SESSION['phone'] = $fullname_var;
 $_SESSION['username'] = $username_var;
 $_SESSION['email'] = $email_var;
	 echo"<span class='success_msg'>".langs('changes_saved_seccessfully')."</span>";
 } else {
	 echo"<span class='error_msg'>".langs('errorSomthingWrong')."</span>";
 }
 }
 }
}

public function Savelanguage(){
	LoadLang();
	$sid=$_SESSION['id'];
	$language_var = filter_var(htmlspecialchars($this->request->getPost('edit_language')),FILTER_SANITIZE_STRING);

	// =============================[ Save Edit profile settings ]==============================
	$data = array(
	'language'   => $language_var
	);
	$where=array('id' => $sid);
	$update_info=$this->comman_model->update_entry("signup",$data,$where);

	if (NULL !==($update_info)) {
		$_SESSION['language'] = $language_var;
		echo"<span class='success_msg'>".langs('changes_saved_seccessfully')."</span>";
	} else {
		echo"<span class='error_msg'>".langs('errorSomthingWrong')."</span>";
	}
}

public function DeleteDatabase(){
	$sid = $_SESSION['id'];
	if (NULL !==($this->request->getPost('removexj_save_changes'))) {
	$remevexj_current_pass_var = filter_var(htmlentities($this->request->getPost('removexj_current_pass')),FILTER_SANITIZE_STRING);
	if (!password_verify($remevexj_current_pass_var,sessionCI('Password'))) {
	echo "<p class='error_msg'>".langs('current_password_is_incorrect')."</p>";

	}else{
		delete_ac($sid,'delete_database');
	echo "<p class='success_msg'>".langs('changes_saved_seccessfully')."</p>";
	}
	}
}

public function DeleteAccount(){
	$sid = $_SESSION['id'];
	$remeveA_current_pass_var = filter_var(htmlentities($this->request->getPost('removeA_current_pass')),FILTER_SANITIZE_STRING);

	if (!password_verify($remeveA_current_pass_var,sessionCI('Password'))) {
	echo"<p class='error_msg'>".langs('current_password_is_incorrect')."</p>";
	}else{
delete_ac($sid,'delete_account');

	header("location: ".base_url()."Account/login");
	}

}

public function block_ip(){
	$sid = $_SESSION['id'];
	$ip_id = filter_var(htmlentities($this->request->getPost('id')),FILTER_SANITIZE_STRING);
$status = "1";
	$emExist = "SELECT status FROM devices WHERE user_id = '$sid' AND id='$ip_id'";
	$FetchData=$this->comman_model->get_all_data_by_query($emExist);
	foreach ($FetchData as $postsfetch ) {
		$status = $postsfetch['status'];
	}
	if($status == '1'){
		$status_val = '0';
	}else{
		$status_val = '1';
	}
	$data = array(
		'status'   => $status_val,
	);
	$where=array('id' => $ip_id);
	$update_info=$this->comman_model->update_entry("devices",$data,$where);
	echo"done";
}

public function savemode(){
	$sid = $_SESSION['id'];
	$mode = filter_var(htmlentities($this->request->getPost('mode')),FILTER_SANITIZE_STRING);
	$mode_save_changes = filter_var(htmlentities($this->request->getPost('mode_save_changes')),FILTER_SANITIZE_STRING);

	$update_info_sql = "UPDATE signup SET mode= '$mode' WHERE username= '$sid'";
	$update_info=$this->comman_model->run_query($update_info_sql);
	if ($update_info)
	{
	$_SESSION['mode'] = $mode;

	if($mode=="night"){

	$data["layoutmode"]="dark-skin";
	}else{
	$data["layoutmode"]="light-skin";
	}
		echo"<span class='success_msg'>".langs('changes_saved_seccessfully')."</span>";
	} else {
		echo"<span class='error_msg'>".langs('errorSomthingWrong')."</span>";
	}

}
}
