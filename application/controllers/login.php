<?php

//!!!the controller for user login function,default controller
class login extends CI_Controller{

	function __construct()
	{
 		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('url');
		 $this->load->library('session');
		$this->load->model('model_user');
	}
	
	public function index(){
	
	
	$this->login();
	
	}
	
	//!!!Load login view
	public function login(){
		$this->load->view("header");
		$this->load->view("css");
		$this->load->view("login");
	}


	
	//!!!the function to verify login user
	public function login_validation(){
		
		//!!!two data from view to verify ,id and password
		//!!!use form_validation callback function to confirm the user is valid or not
		$this->form_validation->set_rules('id','Id','required|trim|xss_clean|callback_validate_credentials');
	
		//!!!passwd is encrypt with md5
		$this->form_validation->set_rules('password','Password','required|md5');
		
		if ($this->form_validation->run()){
			//!!!input user information into session
			$data = array(
				'id' => $this->input->post('id'),
				'is_logged' => 1, 
				'is_admin' =>$this->model_user->is_admin($this->input->post('id')),
				'group_index'=>$this->model_user->get_group_indexBy_user($this->input->post('id')),
				'display_name' =>$this->model_user->id_info($this->input->post('id'),"display_name"),
				);
		
				$this->session->set_userdata($data);		
	
			redirect('form');
			}
		else{	
			$this->load->view("header");
			$this->load->view("css");
			$this->load->view("login");
		}
		
		
		//echo $this->input->post('password');
		
	}

	

	//!!!to check the login is valid or not
	public function validate_credentials(){
		$this->load->model('model_user');
		
		if($this->model_user->can_log_in()){return true;}
		else {$this->form_validation->set_message('validate_credentials','Incorrect username/password.');}
	
		return false;
	}
	
	public function sso(){
		$this->load->view("header");
		$this->load->view("js/loginjs");
		echo "Loading...";
	}
	
	//!!!logout function 
	public function logout(){
		$this->session->sess_destroy();
		redirect('login');
	}
	
	

	//!!!below are the functions that not used
	//=====================================================================================================================	
	
/*	public function signup(){
	
	$this->webpage("signup");

	
	}
	
	public function signup_validation(){
		$this->form_validation->set_rules('name','Name','required|trim|xss_clean');
		$this->form_validation->set_rules('id','Id','required|trim|xss_clean');
		$this->form_validation->set_rules('password','Password','required|trim');
		$this->form_validation->set_rules('cpassword','Confirm Password','required|trim|matches[password]');
		$this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unque[users.email]');
		if ($this->form_validation->run()){
			$key = md5(uniqid());
			
			$this->load->library('email',array('mailtype'=>'html'));
			$this->load->model('model_user');
			
			$this->email->from('ggmagglo.ban@gmail.com',"ggban");
			//$this->email->to('s991272002.just.edu.tw');
			$this->email->to($this->input->post('email'));
			$this->email->subject("Confirm your account");
			
			$message = "<p>Thank you for sign up.";
			$message .= "<p><a href='".base_url()."forms/resgister_user/$key'>Click here</a></p>";
			
			$this->email->message($message);
			if(	$this->model_user->add_temp_user($key)){
				//if ($this->email->send()){echo "The email been sent!";}	else {echo "fail!!"};
				}
			else echo "Error to database.";
			}
		else{
		
			$this->webpage('signup');
			}
		
	
		//echo $this->input->post('password');
		
	}	
	
	public function members(){
	if($this->session->userdata('is_logged_in')){
		$this->load->view("members");
		}
		else {
		redirect('forms/restricted');
		}
	
	}
	public function restricted(){$this->webpage("restricted");}*/
	
}