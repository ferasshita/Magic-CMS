<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller {

	public function __construct()
	{

			helper(
				['langs', 'sendmail', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info']
		);
$this->comman_model = new \App\Models\Comman_model();
			echo Checkloginhome(base_url());

	if(isset($_COOKIE['id']) && !isset($_SESSION['username'])){
//===========================[cookie function]===============================
	$encryption = $_COOKIE['id'];
	$options   = 0;
	$decryption_iv = '1234567891011121';
	$ciphering = "AES-128-CTR";
	$decryption_key = $_SERVER['REMOTE_ADDR'];
	$decryption = openssl_decrypt($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

//========================[fetch data]==============================
$req = "still";
$varid = "";
	$vpsql = "SELECT * FROM signup WHERE id= '$decryption'";
	$FetchedData=$this->comman_model->get_all_data_by_query($vpsql);
	foreach($FetchedData as $row_fetch){
		$fields = $this->comman_model->getFieldData('signup');
	  foreach ($fields as $postsfetchi)
	  {
		  ${"var".$postsfetchi->name} = $row_fetch[$postsfetchi->name];
	}
	}
//=========================[settings]=======================================
	$uisql = "SELECT * FROM settings WHERE user_id= '$varid'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	foreach($udata as $rowx){
	$value_n = $rowx['value'];
	$type_n = $rowx['type'];
	session()->set($type_n, $value_n);
	}
//========================[create sessions]=================================
$fields = $this->comman_model->getFieldData('signup');
foreach ($fields as $postsfetchi)
{
	session()->set($postsfetchi->name, ${"var" . $postsfetchi->name});
}
	}
			LoadLang();
	}
	public function index()
	{
		 if(sessionCI('user_email_status') == "not verified"){
			header("location:".base_url()."Account/email_verification");
		}

		$data['page'] = "home";
		$data['title'] = "";

		$user_id = sessionCI('id');
		echo view('dashboard/home', $data);
	}
	public function blog()
	{
		$data['page'] = "Blog";
		$data['title'] = "";
		$data['pid']=$this->request->getGet('pid');

		$data['title'] = "";
		$data['blog'] = "";
		$data['description'] = "";
		$data['blog_text'] = "";
		$data['see'] = "";

		$uisql = "SELECT * FROM blog WHERE id= '".$data['pid']."'";
		$FetchedData=$this->comman_model->get_all_data_by_query($uisql);
		foreach($FetchedData as $row_fetch){
			$data['title'] = $row_fetch['title'];
			$data['blog'] = $row_fetch['blog'];
			$data['description'] = $row_fetch['description'];
			$data['blog_text'] = $row_fetch['blog_text'];
			$data['see'] = $row_fetch['see'];
		}
		$uisql = "SELECT * FROM blog";
		$data['udata']=$this->comman_model->get_all_data_by_query($uisql);
		foreach($data['udata'] as $row_fetch){
			$user_id = $row_fetch['user_id'];
			$vpsql = "SELECT username FROM signup WHERE id= '$user_id'";
			$FetchedDatai=$this->comman_model->get_all_data_by_query($vpsql);
			foreach($FetchedDatai as $row_fetchi){
				$data['author'] = $row_fetchi['username'];
			}
		}
		echo view('dashboard/blog', $data);
	}

	public function add_blog()
	{
		$title = filter_var(htmlentities($this->request->getPost('title')),FILTER_SANITIZE_STRING);
		$see = filter_var(htmlentities($this->request->getPost('see')),FILTER_SANITIZE_STRING);
		$blog = filter_var(htmlentities($this->request->getPost('blog')),FILTER_SANITIZE_STRING);
		$id = filter_var(htmlentities($this->request->getPost('id')),FILTER_SANITIZE_STRING);
		if(!empty($this->request->getPost('blog_text'))){
			$blog_text = $_POST['blog_text'];
		}else{
			$blog_text = "";
		}
		$user_id = $_SESSION['id'];
		if(!empty($_FILES['image'])) {
			$blog_img = file_upload('blog', 'image', '', '');
		}else{
			$blog_img="";
		}
		if($id != NULL){
			$update = array(
				'title'      => $title,
				'blog_text'      => $blog_text,
				'blog'      => $blog,
				'see'      => $see,
			);
			$where=array('id' => $id);
			$update_info=$this->comman_model->update_entry("blog",$update,$where);
		}else{
		$insert = array(
			'user_id'      => $user_id,
			'title'      => $title,
			'blog_text'      => $blog_text,
			'blog_img'      => $blog_img,
			'blog'      => $blog,
			'see'      => $see,

		);
		$update = $this->comman_model->insert_entry("blog", $insert);
}
		if ($update) {
			echo "<p class='alertGreen'>".lang('changes_saved_seccessfully')."</p>";
		}else{
			echo "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
		}
	}
	public function add_about()
	{
		$about_text = $this->request->getPost('about_text');

	$query ="UPDATE about SET about = '$about_text'";
	$update = $this->comman_model->run_query($query);

		if ($update) {
			echo "<p class='alertGreen'>".lang('changes_saved_seccessfully')."</p>";
		}else{
			echo "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
		}
	}
	public function add_contact()
	{
		$address = $this->request->getPost('address');
		$long = $this->request->getPost('long');
		$lat = $this->request->getPost('lat');
		$phone = $this->request->getPost('phone');
		$email = $this->request->getPost('email');
		$count_address = 0;
		foreach($address as $address_val){
			++$count_address;
			$address_update = settings('address'.$count_address,'user', $address_val);
		}
		$count_address = 0;
		foreach($phone as $phone_val){
			++$count_address;
			$address_update = settings('phone'.$count_address,'user', $phone_val);
		}
		$count_address = 0;
		foreach($email as $email_val){
			++$count_address;
			$address_update = settings('email'.$count_address,'user', $email_val);
		}

			$lat_update = settings('lat','user', $lat);


			$long_update = settings('long','user', $long);

		echo "<p class='alertGreen'>".lang('changes_saved_seccessfully')."</p>";

	}
	public function add_team()
	{
		$name = filter_var(htmlentities($this->request->getPost('name')),FILTER_SANITIZE_STRING);
		$description = filter_var(htmlentities($this->request->getPost('description')),FILTER_SANITIZE_STRING);
		$user_id = $_SESSION['id'];
		$team_img = file_upload('team','team_img','','');
		$data = array(
			'user_id'      => $user_id,
			'name'      => $name,
			'description'      => $description,
			'team_img'      => $team_img,
		);
		$update = $this->comman_model->insert_entry("team");
		if ($update) {
			echo "<p class='alertGreen'>".lang('changes_saved_seccessfully')."</p>";
		}else{
			echo "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
		}
	}
	public function add_gallery()
	{

		$item_file = $_FILES['gallery_img'];
		if(isset($_FILES['gallery_img'])){
			foreach($item_file['tmp_name'] as $key => $tmpName){
				$item_file['name'][$key];

				$post_fileName = $item_file["name"][$key];
				$post_fileTmpLoc = $item_file["tmp_name"][$key];
				$post_fileSize = $item_file["size"][$key];
				$post_fileErrorMsg = $item_file["error"][$key];
				$post_fileName = preg_replace('#[^a-z.0-9]#i', '', $post_fileName);
				$post_kaboom = explode(".", $post_fileName);
				$post_fileExt = end($post_kaboom);
				$post_fileName = time().rand().".".$post_fileExt;

				if (!$post_fileTmpLoc) {
					echo '<p class="error_msg">'.lang('errorPost_n2').'</p>';
				}else{
					//================[ if image format not supported ]================

						//================[ if an error was found ]================
						if ($post_fileErrorMsg == 1) {
							echo '<p class="error_msg">'.lang('errorPost_n5').'</p>';
						}else{

							move_uploaded_file($item_file["tmp_name"][$key], "Asset/upload/gallery/" .$post_fileName);
							$img = "Asset/upload/gallery/" .$post_fileName;
						}
					}}


		}

		if ($img) {
			echo "<p class='alertGreen'>".lang('changes_saved_seccessfully')."</p>";
		}else{
			echo "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
		}
	}

}
