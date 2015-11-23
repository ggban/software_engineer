<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 function __construct(){
			parent::__construct();
			$this->load->helper(array('url','date','form'));
			$this->load->library('session');
			$this->load->library('form_validation');
			$this->load->model('get_db');
			$this->load->model('model_user');
			//$this->load->library('session');

			
		}
	public function index()
	{
		//$this->load->helper('form');
		$this->users_table();
	}

	public function change_passwd(){
		
		$this->load->library('form_validation');	
		$data['id']=$this->session->userdata('id');
		$this->form_validation->set_rules('password','Old_Password','required|md5|callback_check_passwd');
		$this->form_validation->set_rules('new_password','New Password','required|matches[confirm_password]|md5');
		$this->form_validation->set_rules('confirm_password','Confrim Password','required|md5');
		if ($this->form_validation->run()){
			$passwd =$this->input->post('new_password');
			$this->model_user->change_passwd($data['id'],$passwd);
			echo "Password has been change!!";
			}
		else
		{
		
		$data['title']="修改密碼";
			$data['content']=$this->load->view("change_password",$data,true);
			$this->load->view('admin_temp',$data);
		}
	 
	 }

	public function check_passwd(){
	 	if($this->model_user->can_log_in()){return true;}
		else {$this->form_validation->set_message('check_passwd','Incorrect old password.');}
		return false;
	 
	 }

	public function group_table()
	{

		$this->auth_check('admin');

		$item['results']=$this->model_user->get_group();
		$data['content']=$this->load->view('group_table',$item,true);
		$data['title']="群組列表";
		$this->load->view('admin_temp',$data);


	}

	public function create_group()
	{
		$this->auth_check('admin');
		$this->form_validation->set_rules('group_name', 'Group name', 'required');
		$this->form_validation->set_rules('group_detial', 'Group detial', 'required');		
		$this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');
		
		if (!$this->form_validation->run()) // validation hasn't been passed
		{	
			
			$data['content']=$this->load->view('group_create','',true);
			$data['title']="新增群組";
			$this->load->view('admin_temp',$data);
		}
		else // passed validation proceed to post success logic
		{		
	 			//!!!pass all data into data to DB	
				
			
				$form_data = array(
								'group_name' => set_value('group_name'),
								'group_detial' => set_value('group_detial'),
						);			
				
				if ($this->model_user->insert_group($form_data) == TRUE) // the information has therefore been successfully saved in the db
				{
						redirect('user/group_table');
				}
				else //!!!if failed to update DB 
				{
						echo 'An error occurred saving your information. Please try again later';print_r($form_data);
				}  
			
		}
	}

	public function edit_group()
	{
		$this->auth_check('admin');
		$index=$_POST["id"];
		$this->form_validation->set_rules('group_name', 'Group name', 'required');
		$this->form_validation->set_rules('group_detial', 'Group detial', 'required');	
		$data['group_row']=$this->model_user->get_group_row($index);
		if (!$this->form_validation->run()) // validation hasn't been passed
			{
				
				$data['content']=$this->load->view('group_edit',$data,true);
				$data['title']="消息編輯";
				$this->load->view('admin_temp',$data);

			}
		else // passed validation proceed to post success logic
			{ 

				$form_data = array(
								'group_name' => set_value('group_name'),
								'group_detial' => set_value('group_detial'),
						);							
				if ($this->model_user->update_group($index,$form_data)) // the information has therefore been successfully saved in the db
					{		//print_r($file_data);
						redirect('user/group_table');	
					}
				else //!!!if failed to update DB 
					{
						echo 'An error occurred saving your information. Please try again later';print_r($form_data);
					}
					
			// run insert model to write data to db
		
			
		}
		

	}

	public function delete_group()
	{
		$this->auth_check('admin');
		$id = $_POST["id"];
		$this->model_user->delete_group($id);
	}

	public function users_table()
	{
		$this->auth_check('admin');

		$item['results']=$this->model_user->get_users();
		$data['content']=$this->load->view('users_table',$item,true);
		$data['title']="使用者列表";
		$this->load->view('admin_temp',$data);


	}

	public function create_user()
{
		$this->auth_check('admin');
		$this->form_validation->set_rules('user_id', 'User Id', 'required');
		$this->form_validation->set_rules('display_name', 'Display _name', 'required');		
		$this->form_validation->set_rules('group_id', 'Group name');

		$this->form_validation->set_rules('password', 'Password','required|md5');

		$this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');
		//$data['year']=$this->student_info("year");
		if (!$this->form_validation->run()) // validation hasn't been passed
		{	
			
			$row['group_data']=$this->model_user->get_group();
			$data['content']=$this->load->view('user_create',$row,true);
			$data['title']="新增使用者";
			$this->load->view('admin_temp',$data);
		}
		else // passed validation proceed to post success logic
		{		
	 			//!!!pass all data into data to DB	
			//	$body=str_replace(array("\r","\n"),"",$_POST['event_content']);
				$form_data = array(
								'user_id' => set_value('user_id'),
								'display_name' => set_value('display_name'),
								'group_index' => set_value('group_id'),
								'password' =>  set_value('password'),
						);	
				if($this->model_user->user_exist(set_value('user_id')))
				{
					header("Content-Type:text/html; charset=utf-8");
					echo "帳號已被使用";
					return ;
				}		
						
				if ($this->model_user->insert_user($form_data) == TRUE) // the information has therefore been successfully saved in the db
				{
						redirect('user/users_table');
				}
				else //!!!if failed to update DB 
				{
						echo 'An error occurred saving your information. Please try again later';print_r($form_data);
				}  
			
		}
	}
	
	public function edit_user()
	{
		$index=$_POST["id"];
		$this->auth_check('admin');
		$this->form_validation->set_rules('user_id', 'User Id', 'required');
		$this->form_validation->set_rules('display_name', 'Display _name', 'required');		
		$this->form_validation->set_rules('group_id', 'Group name');
		$this->form_validation->set_rules('password', 'Password','md5');

		$this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');
		//$data['year']=$this->student_info("year");
		$row['user_row']=$this->model_user->get_user_row($index);
		if (!$this->form_validation->run()) // validation hasn't been passed
		{	
			
			$row['group_data']=$this->model_user->get_group();
			$data['content']=$this->load->view('user_edit',$row,true);
			$data['title']="編輯使用者";
			$this->load->view('admin_temp',$data);
		}
		else // passed validation proceed to post success logic
		{		
	 			//!!!pass all data into data to DB	
				
				if( set_value('password')==null) 
				{
					foreach($row['user_row']->result() as $user)
					{
						$password=$user->password;			
					}
				}
					
				else 
				{
					
					$password=set_value('password');
				}
					
				
				$form_data = array(
								'user_id' => set_value('user_id'),
								'display_name' => set_value('display_name'),
								'group_index' => set_value('group_id'),
								'password' =>  $password,
						);	
						
						
				if ($this->model_user->update_user($index,$form_data) == TRUE) // the information has therefore been successfully saved in the db
				{
						redirect('user/users_table');
				}
				else //!!!if failed to update DB 
				{
						echo 'An error occurred saving your information. Please try again later';print_r($form_data);
				}  
			
		}
	}
	public function delete_user()
	{
		$this->auth_check('admin');
		$deleted = $_POST["id"];
		$this->model_user->delete_user($deleted);
	}

	private function auth_check($allow_lvl){
		
		switch ($allow_lvl)
		{
			case 'user':
				if(!$this->session->userdata('is_logged'))
					redirect('/form/restricted');
				break;
			case 'admin':
				if(!$this->session->userdata('is_admin'))
					redirect('/form/restricted');

				break	;


		}
		



	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */