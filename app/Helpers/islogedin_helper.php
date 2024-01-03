
<?php
//=======================[redirect to login]===============================
function Checkloginhome($baseurl){
if ($_ENV['PAYMENT'] == "TRUE") {


  // You may need to load the model if it hasn't been pre-loaded
$comman_model = new \App\Models\Comman_model();

	if (\Config\Services::session()->get('account_type') != 'admin') {
	//include "config/connect.php";
	$sid =  \Config\Services::session()->get('id');

	//$uInfo = $conn->prepare("SELECT sus,nex_pay FROM signup WHERE id = :ed");
	$uInfo = "SELECT next_pay FROM payment WHERE user_id = '$sid'";
	$resultCount=$comman_model->get_all_dataCounts_by_query($uInfo);
	$result=$comman_model->get_all_data_by_query($uInfo);
	$uInfo_count = $resultCount;
	foreach($result as $uInfoRow ) {
	$nex_pay = $uInfoRow['next_pay'];

	$date_now = time();
	$date2 = strtotime($nex_pay);
	if($_SESSION['sus'] == "0"){
	if($date2 <= $date_now){
	loginRedirect(base_url()."Home/pay");
	}
	}else{

	loginRedirect(base_url()."Home/pay");
	}
	}
	}
	}


	if(!isset($_SESSION['id']) || !isset($_COOKIE['id'])){
if(\Config\Services::request()->getCookie('id') == NULL){
    header("location: ".$baseurl."Account/login");
    exit;
}
}}

function Checklogin($baseurl){

if(!isset($_SESSION['id'])){
    header("location: ".$baseurl."dashboard");
    exit;
}}
//=========================[redirect to home]======================================
function loginRedirect($baseurl){

if(isset($_SESSION['id']) || isset($_COOKIE['id'])){
if($_COOKIE['id'] != NULL){
  header("location: ".$baseurl);
  exit;
}
}
}

function logoutredirect($baseurl){
  header("location: ".$baseurl."Account/logout");
exit;
}
//=======================[check email verification]============================
function CheckMailVerification(){
     if($_SESSION['user_email_status'] == "not verified"){
        header("location:email_verification");
        exit;
     }
}


?>
