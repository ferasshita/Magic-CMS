<?php
namespace App\Models;

use CodeIgniter\Model;

	class Comman_model extends Model{

                public $title;
                public $content;
                public $date;

                public function get_last_ten_entries()
                {
                        $query = $this->db->get('entries', 10);
 											return $query->getResultArray();
                }

                public function get_data_where($table,$where,$whereval)
                {
                        $this->db->where($where,$whereval);
                        $query=$this->db->get($table);
                        //$query = $this->db->get('entries', 10);
                        return $query->getNumRows();
                }

                public function get_dataCount_where($table,$where,$whereval)
                {
                      $query= $this->db->table($table)->where($where,$whereval);
                        return $query->countAllResults();
                }
                public function insert_entry($table,$array)
                {
                        return $this->db->table($table)->insert($array);;

                }
								public function getFieldData($table)
								{
									return $this->db->getFieldData($table);

								}

                public function update_entry($table,$array,$where)
                {

									return $this->db
								->table($table)
								->where($where)
								->set($array)
								->update();
                }

                public function get_all_data_by_query($CustomQuery)
                {
                        $query = $this->db->query($CustomQuery);
 											return $query->getResultArray();
                }

                public function get_all_dataCounts_by_query($CustomQuery)
                {
                        $query = $this->db->query($CustomQuery);
                        return $query->getNumRows();
                }

                public function run_query($query){

                        return $this->db->query($query);
                }
        }
?>
