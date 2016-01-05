<?php
//!!!the model is for certification data's CRUD-create,read,update,delete
class Form extends CI_Model{

	function __construct()
	{
 		parent::__construct();
		$this->load->database();
	}

	function select_from_where($co,$tb,$comd){
		$this->db->trans_start();
		$this->db->select($co,false);
		$this->db->from($tb);
		$this->db->where($co,$comd);
		$query = $this->db->get();
		
		$this->db->trans_complete();
		foreach ($query->result() as $row)
				{
					$result=$row->$co;
				}
		if($query->num_rows()>0)return  $result;
		else return false;
	}

	function get_all_form()
	{	
		$this->db->trans_start();
		if($this->session->userdata('group_index')!=1)
			$this->db->where('group_index', $this->session->userdata('group_index')); 
		$query =$this->db->get('form_table');
		$this->db->trans_complete();
		if($query->num_rows()>0)return  $query;
		else return false;

	}

	function get_fillable_form()
	{	
		$this->db->trans_start();
		$this->db->from('form_tabl');
		$this->db->where('start_date <', now());  
		$this->db->where('expired_date >', now());  
		$query = $this->db->query('SELECT * FROM (`form_table`) WHERE `start_date` < now() AND `expired_date` > now()');
		$this->db->trans_complete();
		if($query->num_rows()>0)return  $query;
		else return false;

	}

	function check_form_expired($hash)
	{
		$this->db->trans_start();
		$query = $this->db->query("SELECT * FROM (`form_table`) WHERE `start_date` < now() AND `expired_date` > now() AND `form_hash` = '$hash' ");
		$this->db->trans_complete();
		//print_r($query);
		if($query->num_rows()==0)
			return true;
		return false;

	}

	function insert_new_form($data)
	{
		$this->db->trans_start();
		$this->db->insert('form_table', $data); 
		$this->db->trans_complete();
	}

	function update_form($data,$hash)
	{
		$this->db->trans_start();
		$this->db->where('form_hash', $hash);
		$this->db->update('form_table', $data); 
		$this->db->trans_complete();
	}

	function delete_form($hash)
	{
		$this->db->trans_start();
		$this->db->delete('form_table', array('form_hash' => $hash)); 
		$this->db->trans_complete();
	}

	function get_form_data($hash)
	{
		$this->db->trans_start();
		$query = $this->db->get_where('form_table', array('form_hash' => $hash));
		$this->db->trans_complete();
		if($query->num_rows()==0)
		
			return null;
			
		else 
		{
			foreach ($query->result() as $row) {
				$result=$row->form_data;
			}
			
			return $result;
		}

	}

	function hash_to_form_id($hash)
	{

		$this->db->trans_start();

		$this->db->from('form_table');
		$this->db->where('form_hash',$hash);
		$query = $this->db->get();
		$this->db->trans_complete();
		if($query->num_rows()>0)
		{
			foreach ($query->result() as $row)
					{
						$result=$row->form_id;
					}
			$this->db->trans_complete();
		
			return $result;

		}
		
			return null;
		
	}



	function hash_exist($data)
	{
		$this->db->trans_start();
		$query=$this->select_from_where('form_hash','form_table',$data);
		$this->db->trans_complete();
		if($query==null)return false;
		 return true;
	}


	function ramdom_hash()
	{
		$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                 .'0123456789'); // and any other characters
				shuffle($seed); // probably optional since array_is randomized; this may be redundant
		$rand = '';
		foreach (array_rand($seed, 10) as $k) $rand .= $seed[$k];
		return $rand;
	}
}	
