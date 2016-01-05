<?php
//!!!model to get the user's personal data ,dont include certification data
class Group extends CI_Model{

	function __construct()
	{
 		parent::__construct();
		$this->load->database();
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



