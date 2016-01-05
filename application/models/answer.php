<?php
//!!!the model is for certification data's CRUD-create,read,update,delete
class Answer extends CI_Model{

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



	function fill_form($data)
	{

		// insert user_ans 
		$this->db->trans_start();
		$this->db->insert('form_ans', $data); 
		$this->db->trans_complete();
	}

	function get_form_question_num($id)
	{

		$this->db->trans_start();
		$sql="SELECT max(question_num) FROM `form_ans` WHERE form_id ='$id'";
		$query=$this->db->query($sql);

		$this->db->trans_complete();
		$string="max(question_num)";
		if($query->num_rows()>0)
		{
			foreach ($query->result() as $row)
				{
					$result=$row->$string;
				}
			return $result;
		}
		
		return null;
		
	}


	function get_form_result($hash)
	{
		$form_data=json_decode($this->form->get_form_data($hash));

		//print_r($form_data);
		$question_ary=[];
		foreach ($form_data as $key => $value) 
		{
			
			if(is_numeric($key))
			{	
				array_push($question_ary,$value->question);
			}
			if($key=='title')
				$form_title=$value;
		}
		//print_r($question_ary);
		
		$form_id=$this->form->hash_to_form_id($hash);
		//echo $hash;
		if($form_id!=null)
		{
			//get number of question
			$qnum=$this->get_form_question_num($form_id);
			//print($qnum);
			
			//get all ans
			$this->db->trans_start();
			$this->db->order_by('ans_index , question_num asc'); 
			$query = $this->db->get_where('form_ans', array('form_id' => $form_id));

			$this->db->trans_complete();

			$ans_ary=[];
			foreach ($query->result() as $key=>$row)
					{
						
						array_push($ans_ary,$row->ans_value);
						if($key%($qnum+1)==$qnum)
						{
							//array
							array_push($ans_ary,$row->user_hash);
						}
					}

			
			$ans_ary=array_chunk($ans_ary, $qnum+2);
			
			//convert user_hash to time_stamp
 			foreach ($ans_ary as $key => $value) {

					$ans_ary[$key][$qnum+1]=$this->fillList->user_hash_to_timestamp($value[$qnum+1]);
	
			}

			//print_r($ans_ary);

			$result['question']=$question_ary;
			$result['ans']=$ans_ary;
			$result['title']=$form_title;

			return $result;
			/*
			//get user timestamp
			$this->db->trans_start();
			$query = $this->db->get_where('fillin_timestamp', array('user_hash' => $hash));
			$this->db->trans_complete();
			*/
		}
			return null;
	
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
