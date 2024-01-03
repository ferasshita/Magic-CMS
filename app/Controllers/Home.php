<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		helper(
			['langs', 'Islogedin', 'functions_zone','numkmcount','app_info']
	);
$this->comman_model = new \App\Models\Comman_model();
			LoadLang();

	}
	public function page($param = null)
	{
		if($_ENV['LANDING_PAGE'] == "FALSE"){
		return redirect()->to(base_url()."Account/login");
		}
		if($param == ""){
			$param = "index";
		}
		$data['page'] = $param;
		$data['title'] = "";
		LoadLang();

		$user_id = \Config\Services::session()->get('id');
	 	echo view("includes_site/head_info", $data);
				include('src/'.$param.'.html');
			echo view("includes_site/endJScodes", $data);
	}
	public function index()
	{
		if($_ENV['LANDING_PAGE'] == "FALSE"){
	  return redirect()->to(base_url()."Account/login");
		}
	//	loginRedirect(base_url()."Account/login");

		$data['page'] = "Home";
		$data['title'] = "";
		LoadLang();
		$user_id = \Config\Services::session()->get('id');
		echo view("includes_site/head_info", $data);
		if (file_exists('src/index.html')) {
			include('src/index.html');
		}else{
				foreach (scandir('src') as $file) {
					$fileExt = strtolower(pathinfo($file, PATHINFO_EXTENSION));
					if($fileExt === 'html'){
					include('src/'.$file);
					break;
				}
				}
		}
		echo view("includes_site/endJScodes", $data);
	}
	public function pay()
	{
		if($_ENV['PAYMENT'] == "TRUE"){
		$data['page'] = "Payment";
		$data['title'] = "";
		LoadLang();

		echo view('home/pay', $data);
	}
	}
public function blog($pid)
	{
		LoadLang();
		$vpsql = "SELECT * FROM blog WHERE id= '$pid'";
		$FetchedData=$this->comman_model->get_all_data_by_query($vpsql);
		foreach($FetchedData as $row_fetch){
			$user_id = $row_fetch['user_id'];
			$data['blog_text'] = $row_fetch['blog_text'];
			$data['blog_img'] = $row_fetch['blog_img'];
			$data['title'] = $row_fetch['title'];
			$data['description'] = $row_fetch['description'];
			$see = $row_fetch['see'];

			$vpsql = "SELECT username FROM signup WHERE id= '$user_id'";
			$FetchedDatai=$this->comman_model->get_all_data_by_query($vpsql);
			foreach($FetchedDatai as $row_fetchi){
				$data['author'] = $row_fetchi['username'];
			}
		}

		$data['page'] = $data['title'];
		if($see == '0' && session()->get('id') == NULL){
		echo view('errors/404');
		}else{
		echo view('home/page',$data);
	}
	}
	}
