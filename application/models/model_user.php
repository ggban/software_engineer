<?php
//!!!model to get the user's personal data ,dont include certification data
class Model_user extends CI_Model{

	function __construct()
	{
 		parent::__construct();
		$this->load->database();
	}
	//!!!verify the user can login or not,return boolean
	public function can_log_in(){
		
		$this->db->where('user_id',$this->input->post('id'));
		$this->db->where('password',md5($this->input->post('password')));
		$query=$this->db->get('users');
	
		if($query->num_rows()==1){
			return true;
		
		}else{return false;}
	
	}
	
	//!!!check the user is exist or not,return boolean
	public function user_exist($user){
		
		$this->db->where('user_id',$user);

		$query=$this->db->get('users');
	
		if($query->num_rows()==1){
			return true;
		
		}else{return false;}
	
	}

	public function get_users(){
		
	//	$this->db->where('id',$user);
		$this->db->trans_start();
		$query=$this->db->get('users');
	
		$this->db->trans_complete();
		if($query->num_rows()>0)
			return  $query;
		return null;

	
	}
	
	public function is_admin($id)
		{
			$this->db->select('*');
			$this->db->where('user_id',$id);
			$query=$this->db->get('is_admin');
	
		if($query->num_rows()==1){
			return true;
		
		}else{return false;}
	}
	
	public function get_admin_id($id)
		{
			$this->db->select('*');
			$this->db->where('id',$id);
			$query=$this->db->get('admin');
			foreach ($query->result() as $row)
				{
					$output=$row->index;
			
				}

		
		return $output;}
	
	
	//!!!get all the user personal data 
	public function id_info($id,$collumn){
		$this->db->select('*');
		$this->db->where('user_id',$id);
		$query=$this->db->get('users');
			foreach ($query->result() as $row)
			{
				$output=$row->$collumn;
			
			}
		return $output;
	}

	public function change_passwd($id,$new_passwd){
		$data = array('password' => $new_passwd);
		$this->db->where('user_id',$this->input->post('id'));
		$this->db->update("users",$data);
	}
	function get_user_row($index)
	{

		$this->db->trans_start();
		$this->db->from('users');
		$this->db->where('user_index', $index);

		//$this->db->order_by('newslatter_index desc'); 
		$query = $this->db->get();
		$this->db->trans_complete();
		if($query->num_rows()>0)
			return  $query;
		return null;

	}
	function insert_user($data)
	{

		$this->db->trans_start();
		//$this->db->set('modified_time', 'NOW()', FALSE);
		$this->db->insert('users', $data); 
		
		if ($this->db->affected_rows() == '1')
		{
			$this->db->trans_complete();
			return TRUE;
		}
		$this->db->trans_complete();
		return FALSE;

	}
	function update_user($index,$data)
	{

		$this->db->trans_start();
		$this->db->where('user_index', $index);
		$this->db->update('users', $data); 
		$this->db->trans_complete();
		return true;
	}

	function delete_user($index)
	{
		$this->db->trans_start();
		$this->db->delete('users', array('user_index' => $index)); 
		$this->db->trans_complete();
	}
	function get_group_notAdmin()
	{

		$this->db->trans_start();
		$this->db->from('group_table');
		$this->db->where_not_in('group_index', '1');

		//$this->db->order_by('newslatter_index desc'); 
		$query = $this->db->get();
		$this->db->trans_complete();
		if($query->num_rows()>0)
			return  $query;
		return null;

	}
	function get_group()
	{

		$this->db->trans_start();
		$this->db->from('group_table');
		$query = $this->db->get();
		$this->db->trans_complete();
		if($query->num_rows()>0)
			return  $query;
		return null;

	}
	function get_group_row($id)
	{

		$this->db->trans_start();
		$this->db->from('group_table');
		$this->db->where('group_index', $id);

		//$this->db->order_by('newslatter_index desc'); 
		$query = $this->db->get();
		$this->db->trans_complete();
		if($query->num_rows()>0)
			return  $query;
		return null;

	}

	public function get_group_indexBy_user($id)
	{
		$this->db->where('user_id',$id);
		$query=$this->db->get('users');
		if($query->num_rows()==1){
			foreach ($query->result() as $row ) {
				return $row->group_index;
			}
			
		}
		return false;

	}

	function insert_group($data)
	{

		$this->db->trans_start();
		$this->db->insert('group_table', $data); 
		
		if ($this->db->affected_rows() == '1')
		{
			$this->db->trans_complete();
			return TRUE;
		}
		$this->db->trans_complete();
		return FALSE;

	}
	function update_group($index,$data)
	{

		$this->db->trans_start();
		$this->db->where('group_index', $index);
		$this->db->update('group_table', $data); 
		$this->db->trans_complete();
		return true;
	}

	function delete_group($id)
	{
		
		$this->db->trans_start();
		$this->db->delete('group_table', array('group_index' => $id)); 
		$this->db->trans_complete();

	}
	//!!!below are the functions that are not used
	//=====================================================================================================================	
	
	/*public function add_temp_user($key){ 
	
		$data = array(
			'name'=>$this->input->post('name'),
			'email'=>$this->input->post('email'),
			'passwd'=>md5($this->input->post('password')),
			'id'=>$this->input->post('id')
		);
	
		$query = $this->db->insert('users',$data);
		if($query){return true;}
			else {return false;}
	
	
	}
		public function ad_can_log_in(){
		
		$this->db->where('id',$this->input->post('id'));
		$this->db->where('passwd',$this->input->post('password'));
		$query=$this->db->get('admin');
	
		if($query->num_rows()==1){
			return true;
		
		}else{return false;}
	}
		
		public function tcan_log_in(){
		
		$this->db->where('id',$this->input->post('id'));
		$this->db->where('passwd',$this->input->post('password'));
		$query=$this->db->get('teacher');
	
		if($query->num_rows()==1){
			return true;
		
		}else{return false;}
	}

	
	public function change_passwd($id,$new_passwd){
		$data = array('passwd' => $new_passwd);
		$this->db->where('id',$this->input->post('id'));
		$this->db->update("users",$data);
	
	
	} */
}



