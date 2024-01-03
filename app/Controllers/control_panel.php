<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Control_panel extends Controller {

	public function __construct()
	{
					// $this->load->helper("langs");
			// $this->load->helper("IsLogedin","Paymust");
			helper(
				['langs', 'IsLogedin','timefunction','Mode','numkmcount','app_info','functions_zone']
		);
		$this->comman_model = new \App\Models\Comman_model();
		$this->account_model = new \App\Models\Account_model();
			Checkloginhome(base_url());

			LoadLang();
			//LoadLang();
			// Your own constructor code
	}



public function index(){
		///check login
$data['urlP'] = filter_var(htmlspecialchars($this->request->getGet('adb')),FILTER_SANITIZE_STRING);

		$mode=LoadMode();
		$data['page'] = "panel";
$data['title'] = "";
        $data["dircheckPath"]= base_url()."Asset/";
        $data["layoutmode"]  =   $mode;
		////////////////////////////////////////////////////

		if($_SESSION['user_email_status'] == "not verified"){
		header("location:../email_verification");
		}
		  $data['token'] = bin2hex(random_bytes(32));
			session()->set('csrf_token', $data['token']);
		// check if user is an admin or naot to access control_panel
		if ($_SESSION['account_type'] != 'admin') {
				header("location: ".base_url());
		}

        $sid =  $_SESSION['id'];

		echo view('control_panel/index',$data);
	}


	public function user(){
		///check login
		$data['page']="user";
$data['title']="";
$data['update_result'] ="";
		Checklogin(base_url());

		$url=base_url()."control_panel";
		$emailverif=base_url()."email_verification";
		if($_SESSION['user_email_status'] == "not verified"){
		header("location:$emailverif");}
		if ($_SESSION['account_type'] != 'admin') {
				header("location: ".base_url());
		}

		$urlP = filter_var(htmlspecialchars($this->request->getGet('adb')),FILTER_SANITIZE_STRING);
		// get var's
		$ed = trim(filter_var(htmlspecialchars($this->request->getGet('ed')),FILTER_SANITIZE_STRING));
		$data['ed'] = $ed;
		$db_username = trim(filter_var(htmlentities($this->request->getPost('username')),FILTER_SANITIZE_STRING));
		$db_email = trim(filter_var(htmlentities($this->request->getPost('email')),FILTER_SANITIZE_STRING));
		if($_SESSION['id'] == $ed){
			echo "you can't edit your profile.";
			return false;
		}
		// =========================== password hashinng ==================================
		$db_password_var = trim(filter_var(htmlentities($this->request->getPost('password')),FILTER_SANITIZE_STRING));
		$options = array(
			'cost' => 12,
		);
		$db_password = password_hash($db_password_var, PASSWORD_BCRYPT, $options);
		// ================================================================================
		$db_admin = trim(filter_var(htmlentities($this->request->getPost('admin')),FILTER_SANITIZE_STRING));
		switch ($db_admin) {
			case langs('yes'):
				$db_admin = "1";
				break;
			case langs('no'):
				$db_admin = "0";
				break;
		}
//==========================[profile]==========================
		if (NULL !== ($this->request->getPost('submit_uInfo'))) {
			if (empty($db_username) or empty($db_email)) {
				$data["update_result"] = "<p class='alertRed'>".langs('please_fill_required_fields')."</p>";
				$data["stop"] = "1";
			}
			if(strpos($db_username, ' ') !== false || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/', $db_username) || !preg_match('/[A-Za-z0-9]+/', $db_username)) {
				$data["update_result"] = "
					<ul class='alertRed' style='list-style:none;'>
						<li><b>".langs('username_not_allowed')." :</b></li>
						<li><span class='fa fa-times'></span> ".langs('signup_username_should_be_1').".</li>
						<li><span class='fa fa-times'></span> ".langs('signup_username_should_be_2').".</li>
						<li><span class='fa fa-times'></span> ".langs('signup_username_should_be_3').".</li>
						<li><span class='fa fa-times'></span> ".langs('signup_username_should_be_4').".</li>
						<li><span class='fa fa-times'></span> ".langs('signup_username_should_be_5').".</li>
					</ul>";
				$stop = "1";
			}

			$unExist = "SELECT username FROM signup WHERE username ='$db_username'";
			$FetchedData=$this->comman_model->get_all_data_by_query($unExist);
			$data["unExistCount"]=count($FetchedData);

			$emExist = "SELECT email FROM signup WHERE email ='$db_email'";
			$FetchedData=$this->comman_model->get_all_data_by_query($emExist);
			$data["emExistCount"]=count($FetchedData);

			if($emExistCount > 0){
				if ($uInfo_em != $db_email) {
				$data["update_result"] = "<p class='alertRed'>".langs('email_already_exist')."</p>";
				$data["stop"] = "1";
				$stop="1";
				}
			}

			if (!filter_var($db_email, FILTER_VALIDATE_EMAIL)) {
				$data["update_result"] = "<p class='alertRed'>".langs('invalid_email_address')."</p>";
				$data["stop"] = "1";
				$stop="1";
			}


			if ($stop != "1") {
				if (empty($db_password_var)) {
				$update = "UPDATE signup SET username = '$db_username',email = '$db_email',package = '$package',admin = '$db_admin' WHERE id = '$ed'";
				}else{
				$update = "UPDATE signup SET username = '$db_username',email = '$db_email',package = '$package',Password = '$db_password',admin = '$db_admin' WHERE id = '$ed' ";
				}
				$update=$this->comman_model->run_query($update);
				if ($update) {
					$data["update_result"] = "<p class='alertGreen'>".langs('changes_saved_seccessfully')."</p>";
				}else{
					$data["update_result"] = "<p class='alertRed'>".langs('errorSomthingWrong')."</p>";
				}
			}

		}

//===========================[activate email]=================================
		if (NULL !== ($this->request->getPost('active'))) {
			$uInfo = "SELECT user_email_status FROM signup WHERE id = '$ed'";
			$FetchedData=$this->comman_model->get_all_data_by_query($uInfo);
			// $uInfo->bindParam(':ed',$ed,PDO::PARAM_STR);
			// $uInfo->execute();
			$uInfo_count = count($FetchedData);// $uInfo->rowCount();
			if ($uInfo_count > 0) {
			foreach ($FetchedData as $uInfoRow)
			{
				$uInfo_sus= $uInfoRow['user_email_status'];
			}
			if($uInfo_sus == "not verified"){
			  $sus = "verified";
			}else{
			  $sus = "not verified";
			}

			$query ="UPDATE signup SET user_email_status = '$sus' WHERE id = '$ed' ";
			$update = $this->comman_model->run_query($query);
			// $update->bindParam(':db_username',$sus,PDO::PARAM_INT);
			// $update->bindParam(':ed',$ed,PDO::PARAM_STR);
			// $update->execute();
				if ($update) {
				}else{
					$data["update_result"] = "<p class='alertRed'>".langs('errorSomthingWrong')."</p>";
				}
			}
		}
//============================[delete account]==========================
		if (NULL !== ($this->request->getPost('delete_account'))) {
			delete_ac($ed,'delete_account');
		}

		if (NULL !== ($this->request->getPost('delete_database'))) {
			delete_ac($ed,'delete_database');
		}
//=============================[login to user]==========================
if(NULL !== ($this->request->getPost('login_acc'))){
		// Displaying the decrypted string
	$login_id = $this->request->getPost('login_id');
		setcookie("id", "", time() - (10 * 365 * 24 * 60 * 60), "/", false, true);
		session_destroy();
	$vpsql = "SELECT * FROM signup WHERE id= '$login_id'";
	$FetchedData=$this->comman_model->get_all_data_by_query($vpsql);
	foreach($FetchedData as $row_fetch){
		$fields = $this->account_model->getFieldData('signup');
		foreach ($fields as $postsfetchi)
		{
			${"var".$postsfetchi->name} = $row_fetch[$postsfetchi->name];
		}}

		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options   = 0;
		$encryption_iv = '1234567891011121';
		$encryption_key = $_SERVER['REMOTE_ADDR'];
		$encryption = openssl_encrypt($varid, $ciphering, $encryption_key, $options, $encryption_iv);

		setcookie('id', $encryption, time() + (10 * 365 * 24 * 60 * 60), "/", false, true);

		$uisql = "SELECT * FROM settings WHERE user_id= '$varid' AND access='user'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		foreach($udata as $rowx){
			$value_n = $rowx['value'];
			$type_n = $rowx['type'];
			$_SESSION[$type_n] = $value_n;
		}
		$fields = $this->account_model->getFieldData('signup');
		foreach ($fields as $postsfetchi)
		{
			$_SESSION[$postsfetchi->name] = ${"var".$postsfetchi->name};
		}
		$url = base_url()."Dashboard";
		header("location: $url");

}
//=============================[send message to user]============================
		if (NULL !== ($this->request->getPost('send_msg'))) {
			$msg = trim(filter_var(htmlspecialchars($this->request->getPost('msg')),FILTER_SANITIZE_STRING));
			$dataEnter = array(
				'message'      => $msg,
			);
			$this->comman_model->insert_entry("notifications",$dataEnter);
		}

		if(NULL !== ($this->request->getPost('pay_month'))){
			$next_pay = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " + 1 month"));
			$dataEnter = array(
				'user_id' => $data['ed'],
				'next_pay' => $next_pay,
			);
			$update=$this->comman_model->insert_entry("payment",$dataEnter);
			if ($update) {
				$update_result = "<p class='alertGreen'>".langs('changes_saved_seccessfully')."</p>";
			}else{
				$update_result = "<p class='alertRed'>".langs('errorSomthingWrong')."</p>";
				$data["update_result"]=$update_result;
			}
		}
//====================================[payment]=============================
		if(NULL !== ($this->request->getPost('pay_one'))){
			$next_pay = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " + 1 year"));
			$dataEnter = array(
				'user_id' => $data['ed'],
				'next_pay' => $next_pay,
			);
			$update=$this->comman_model->insert_entry("payment",$dataEnter);
			if ($update) {
				$update_result = "<p class='alertGreen'>".langs('changes_saved_seccessfully')."</p>";
			}else{
				$update_result = "<p class='alertRed'>".langs('errorSomthingWrong')."</p>";
			}
			$data["update_result"]=$update_result;
		}

		if(NULL !== ($this->request->getPost('pay_two'))){
			$next_pay = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " + 2 year"));
			$dataEnter = array(
				'user_id' => $data['ed'],
				'next_pay' => $next_pay,
			);
			$update=$this->comman_model->insert_entry("payment",$dataEnter);
			if ($update) {
				$update_result = "<p class='alertGreen'>".langs('changes_saved_seccessfully')."</p>";
			}else{
				$update_result = "<p class='alertRed'>".langs('errorSomthingWrong')."</p>";
			}
			$data["update_result"]=$update_result;
		}

		if(NULL !== ($this->request->getPost('pay_three'))){
			$next_pay = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " + 3 year"));
			$dataEnter = array(
				'user_id' => $data['ed'],
				'next_pay' => $next_pay,
			);
			$update=$this->comman_model->insert_entry("payment",$dataEnter);
			if ($update) {
				$update_result = "<p class='alertGreen'>".langs('changes_saved_seccessfully')."</p>";
			}else{
				$update_result = "<p class='alertRed'>".langs('errorSomthingWrong')."</p>";
			}
			$data["update_result"]=$update_result;
		}

		if (NULL !== ($this->request->getPost('pay'))) {
			$next_pay = trim(filter_var(htmlspecialchars($this->request->getPost('nex_pay')),FILTER_SANITIZE_STRING));
			$dataEnter = array(
				'user_id' => $data['ed'],
				'next_pay' => $next_pay,
			);
			$update=$this->comman_model->insert_entry("payment",$dataEnter);
			if ($update) {
				$update_result = "<p class='alertGreen'>".langs('changes_saved_seccessfully')."</p>";
			}else{
				$update_result = "<p class='alertRed'>".langs('errorSomthingWrong')."</p>";
			}
			$data["update_result"]=$update_result;
		}
//=================================[susbend the user]==================================
		if (NULL !== ($this->request->getPost('susbend'))) {
			$uInfo = "SELECT sus FROM signup WHERE id = '$ed'";
			$FetchedData=$this->comman_model->get_all_data_by_query($uInfo);
			$uInfo_count = count($FetchedData);
			if ($uInfo_count > 0) {
			foreach ($FetchedData as $uInfoRow)
			{
				$uInfo_sus= $uInfoRow['sus'];
			}
			if($uInfo_sus == "1"){
			  $sus = "0";
			}else{
			  $sus = "1";
			}

			$query ="UPDATE signup SET sus = '$sus' WHERE id = '$ed' ";
			$update = $this->comman_model->run_query($query);
				if ($update) {
				}else{
					$data["update_result"] = "<p class='alertRed'>".langs('errorSomthingWrong')."</p>";
				}
			}
		}

		$mode=LoadMode();
		$data["dircheckPath"]= base_url()."Asset/";
		$data["layoutmode"]  =   $mode;
//=============================[fetch user data]================================
$data['next_pay'] = "";
$data['next_date'] = "";
		$ed = trim(filter_var(htmlspecialchars($this->request->getGet('ed')),FILTER_SANITIZE_STRING));
		 $uInfo = "SELECT * FROM signup WHERE id =  '$ed'";
		$FetchedData=$this->comman_model->get_all_data_by_query($uInfo);
		$data["uinfo"]=$FetchedData;
		$data['found_user']=count($FetchedData);
		$un_not_found="";
		if ($data['found_user'] > 0) {
			foreach($FetchedData as $uInfoRow ) {
				$data['uInfo_id'] = $uInfoRow['id'];
				$data['uInfo_un'] = $uInfoRow['username'];
				$data['online'] = $uInfoRow['online'];
				$data['uInfo_em'] = $uInfoRow['email'];
				$data['uInfo_ph'] = $uInfoRow['phone'];
				$data['uInfo_type'] = $uInfoRow['account_type'];
				$data['status'] = $uInfoRow['sus'];
				$data['user_email_status'] = $uInfoRow['user_email_status'];

			}
			$uInfo = "SELECT * FROM payment WHERE user_id = '$ed'";
		 $data['FetchedPayment']=$this->comman_model->get_all_data_by_query($uInfo);
		}else{
				$un_not_found = "user not found";
		}
			// remove a user from all tables (forever from database)

		// remove a user from all tables (forever from database)
		if (NULL !== ($this->request->getPost('rAccBtn'))) {

			delete_ac($session_id,'delete_account');


			if ($remeveAccount)
			{
				//echo "Test";exit;
				echo $url=base_url()."control_panel/panel";
				header("location: $url");
				exit;
			}
			else
			{
				//echo "Test2";exit;
				$data["update_result"] = "<p class='alertRed'>".langs('errorSomthingWrong')."</p>";
			}
		}
		if ($un_not_found != "user not found")
		{
			$admin_int = "1";
			$chAdmin = "SELECT username FROM signup WHERE id = '$ed' AND account_type = 'admin' ";
			$FetchedData=$this->comman_model->get_all_data_by_query($chAdmin);
			$data["chAdminCount"]=count($FetchedData);
		}

		echo view('control_panel/user',$data);
	}

}
