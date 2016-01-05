<?php
//!!!the model is for certification data's CRUD-create,read,update,delete
class FillList extends CI_Model{

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

	function check_duplicate_fill($form_id,$email)
	{
		$this->db->trans_start();

		$this->db->from('fillin_timestamp');
		$this->db->where('form_id',$form_id);
		$this->db->where('user_email',$email);
		$query = $this->db->get();
		$this->db->trans_complete();
		if($query->num_rows()>0)
		{
			return true;
		}
		return false;

	}

	function insert_user_hash($form_id)
	{
		// insert timestseramp and user_hash
		$user_hash=$this->ramdom_hash();
		while($this->user_hash_exist($user_hash))
			{
				$user_hash=$this->ramdom_hash();
			}

		$data = array(
			   'form_id' => $form_id ,
			   'user_hash' => $user_hash ,
			  // 'user_email' =>$email,
			);
		$this->db->trans_start();
		$this->db->insert('fillin_timestamp', $data); 
		$this->db->trans_complete();
		return $user_hash;

	}



	function user_hash_to_timestamp($user_hash)
	{

		$this->db->trans_start();
		$query = $this->db->get_where('fillin_timestamp', array('user_hash' => $user_hash));
		$this->db->trans_complete();

		if($query->num_rows()>0)
		{
			foreach ($query->result() as $row)
			{
					$result=$row->fillin_time_stamp;
			}
			return $result;
		}	
		return null;
	}


	function user_hash_exist($data)
	{
		$this->db->trans_start();
		$query=$this->select_from_where('user_hash','fillin_timestamp',$data);
		$this->db->trans_complete();
		print_r($query);
		if($query==false)return false;
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
