<?php
namespace App\Models;

use CodeIgniter\Model;

	class Account_model extends Model{

        public $title;
        public $content;
        public $date;



        public function get_data_where($table,$where,$whereval)
        {
                $this->db->where($where,$whereval);
                $query=$this->db->get($table);
                //$query = $this->db->get('entries', 10);
 							return $query->getResultArray();
        }
				public function get_account_by_username($username)
		{
		    $query = $this->db->query("SELECT * FROM signup WHERE (username = '$username' OR email = '$username')");

		    // Return the result as an array of objects
		    return $query->getResultArray();
		}


        public function check_login($username,$password)
        {

                $q="SELECT * FROM signup WHERE (username= '".$username."' OR Email= '".$username."' ) AND Password= '".$password."' ";

                $query = $this->db->query($q);
                return $query;
        }

        public function check_google($google_id)
        {

                $q="SELECT * FROM signup WHERE id='".$google_id."'";

                $query = $this->db->query($q);
                return $query;
        }

        public function get_user_package($sid)
        {

                $q="SELECT package,username,tree,local_transfar FROM signup WHERE id= $sid";
                $query = $this->db->query($q);
 							return $query->getResultArray();
        }
public function getFieldData($table)
{
	return $this->db->getFieldData($table);

}
				public function insert_entry($table, $array)
		{
			return $this->db->table($table)->insert($array);

		}

        public function insert_multiple_entries($table,$array)
        {
               return  $this->db->insert_batch($table, $array);
                //return $insert_id = $this->db->insert_id();

        }

        }
?>
