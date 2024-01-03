<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Includes extends Controller {

   public function __construct()
 	{

 			helper(
 				['langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info']
 		);
    $this->comman_model = new \App\Models\Comman_model();
 			LoadLang();
 			// Your own constructor code


 	}
	public function fetch_posts_home()
	{
		$sid = $_SESSION['id'];
		$plimit = filter_var(htmlspecialchars($this->request->getPost('plimit')), FILTER_SANITIZE_NUMBER_INT);
		$fPosts_sql_sql = "SELECT * FROM transaction ORDER BY date DESC LIMIT $plimit,10";
		$FetchData=$this->comman_model->get_all_data_by_query($fPosts_sql_sql);
		$view_postsNum = count($FetchData);

		if ($view_postsNum > 0) {
//code
			echo"$view_postsNum hi";
		} else {
			echo "0";
		}

	}
  public function fetch_table()
	{
    $table = htmlentities($this->request->getPost('table'), ENT_QUOTES);
    $column = htmlentities($this->request->getPost('column'), ENT_QUOTES);
    $filter = htmlentities($this->request->getPost('filter'), ENT_QUOTES);
    echo "<!-- dont_write -->";
    echo table_view($table,$column,$filter);
        echo "<!-- /dont_write -->";
	}
  public function count_table()
  {
    $table = htmlentities($this->request->getPost('table'), ENT_QUOTES);
    $column = htmlentities($this->request->getPost('column'), ENT_QUOTES);
    $value = htmlentities($this->request->getPost('value'), ENT_QUOTES);
    $sid = htmlentities($this->request->getPost('sid'), ENT_QUOTES);
    echo "<!-- dont_write -->";
    echo count_table($table,$column,$value,$sid);
    echo "<!-- /dont_write -->";
  }
  public function browsing()
  {
    $table_name = htmlentities($this->request->getPost('table_name'), ENT_QUOTES);
    $column = htmlentities($this->request->getPost('column'), ENT_QUOTES);
    $id = htmlentities($this->request->getPost('id'), ENT_QUOTES);
    echo "<!-- dont_write -->";
    echo browsing($table_name,$column,$id);
        echo "<!-- /dont_write -->";
  }
  public function blog()
  {
    $blog = htmlentities($this->request->getPost('blog'), ENT_QUOTES);
    echo "<!-- dont_write -->";
    if($blog != ""){
      $blog_sql = " WHERE blog='$blog'";
    }else{
      $blog_sql = "";
    }
     $uisql = "SELECT * FROM blog $blog_sql";
    					$udata=$this->comman_model->get_all_data_by_query($uisql);
    					foreach ($udata as $postsfetch ) {
    					$id = $postsfetch['id'];
    					$title = $postsfetch['title'];
    					$blog_img = $postsfetch['blog_img'];
    ?>

    						<div class="col-md-6 col-12">
    							<div class="box">
    								<a href="<?php echo base_url()."home/blog/".$id; ?>"><div class="box-body" style="background: url('<?php echo base_url().$blog_img; ?>') center center / cover no-repeat;">
    									</div></a>
    								<div class="box-header">
    <h3><a href="<?php echo base_url()."home/blog/".$id; ?>"><?php echo $title; ?></a> </h3>
    								</div>
    							</div>
    						</div>

    					<?php }
                echo "<!-- /dont_write -->";
  }
	public function delete_transaction()
	{
		$c_id = htmlentities($this->request->getPost('cid'), ENT_QUOTES);
		$table = htmlentities($this->request->getPost('table'), ENT_QUOTES);

		$delete_comm_sql = "DELETE FROM $table WHERE id = $c_id";
		$IsUpdate=$this->comman_model->run_query($delete_comm_sql);
		echo "done";
	}
	public function mode()
	{
    $id = $_SESSION['id'];
    $dhsh = date("H");

if($_SESSION['mode'] == "light" || ($_SESSION['mode'] == "auto" && $dhsh>=4&&$dhsh<=18)){
$mode = "night";
}else{
$mode = "light";
}
     $update_info_sql = "UPDATE signup SET mode= '$mode' WHERE id= '$id'";
     $update_info=$this->comman_model->run_query($update_info_sql);

         $_SESSION['mode'] = $mode;

echo"yes";
	}
}
