<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller {

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
			$this->load->model('get_db');
			$this->load->model('model_user');
			//$this->load->library('session');

			
		}
	public function index()
	{
		$this->auth_check('user');
 		//print_r($this->session->all_userdata());	
		$data['results']=$this->get_db->get_all_form();
		$data['title']="首頁";
		$data['content']="歡迎來到CFFS系統";
		$this->load->view('admin_temp',$data);
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

	public function form_menu()
	{
		$this->auth_check('user');
 		//print_r($this->session->all_userdata());	
		$data['results']=$this->get_db->get_all_form();
		$data['title']="表單列表";
		$data['content']=$this->load->view('form_menu',$data,true);
		$this->load->view('admin_temp',$data);

	}

	public function fill_form_menu()
	{

		$data['results']=$this->get_db->get_fillable_form();
		$this->load->view('fill_form_menu',$data);

	}

	public function create_form()
	{
		$this->auth_check('user');
		$this->load->view('create_form');
	}

	public function delete_form()
	{
		$this->auth_check('user');
		$deleted = $_POST["hash"];
		echo $deleted;
		$this->get_db->delete_form($deleted);
	}

	public function edit_view_form()
	{
		$this->auth_check('user');
		$type=$_POST["ev_type"];
		$target = $_POST["hash"];
		$data["form_data"]=$this->get_db->get_form_data($target);
		$data["hash"]=$target;
		$data["submit_able"]=false;
		switch($type)
		{
			case "edit":
				$this->load->view('edit_form',$data);
				break;
			case "view":

				$this->load->view('view_form',$data);
				break;	

		}
		
		//$this->get_db->delete_form($deleted);
	}

	public function form_submit()
	{
		$this->auth_check('user');
		$title=$_POST['title'];
		$rand=$this->get_db->ramdom_hash();
		while($this->get_db->hash_exist($rand))
			{
				$rand=$this->get_db->ramdom_hash();
			}
		
		$form_data = array(	
				'group_index' =>$this->session->userdata('group_index'),
				'form_title' => $_POST['title'],
				'form_data' => json_encode($_POST),	
				'form_hash'	=> 	$rand,
							);
		//echo $title;
		$this->get_db->insert_new_form($form_data);
		
	}
	
	public function form_update()
	{
		$this->auth_check('user');
		$title=$_POST['title'];
		$rand=$_POST['hash'];
		$form_data=$_POST;
		
		$form_dat=array_splice($form_data,0,count($form_data)-1);
		//print_r($form_dat);
		$form_data = array(	
				'form_title' => $_POST['title'],
				'form_data' => json_encode($form_dat),	
							);
		
		$this->get_db->update_form($form_data,$rand);
		
	}

	public function form_date_update()
	{
		$this->auth_check('user');
		
		print_r($_POST);
		$form_data = array(	
			'start_date' => $_POST['start'],
			'expired_date' => $_POST['expired'],	
							);
		
		$this->get_db->update_form($form_data,$_POST['hash']);
		
	}



	public function form_fill($hash="")
	{
		//$this->auth_check('admin');
		
		$this->load->library('form_validation');

		$this->form_validation->set_rules('da', 'da','required');

		$form_data = $this->get_db->get_form_data($hash);
		//print_r($form_data);
		if($form_data==null||$this->get_db->check_form_expired($hash)) show_404();
		
		$data["form_data"]=$form_data;
		$data["hash"]=$hash;
		$data["submit_able"]=true;
		

		if ($this->form_validation->run() == FALSE)
		{	
			
			$this->load->view('view_form',$data);
		}

		else
		{
			
			$form_id=$this->get_db->hash_to_form_id($_POST['da']['hash']);
			//echo $form_id;
			//echo $_POST['da']['email'];
			//subscribe check 
			// if($this->get_db->check_duplicate_fill($form_id,$_POST['da']['email']))
			// 	{
			// 		echo "您已填寫過此表格";
			// 		return ;
			// 	}
				
			// if($_POST['da']['sub']=="true")
			// 	$this->get_db->insert_subsribe(array('email' => $_POST['da']['email']));
			
			//insert timestamp

			$user_hash=$this->get_db->insert_user_hash($form_id);
			
			if($user_hash!=null)
			{
				foreach ($_POST['da'] as $key =>$value) 
				{
					//print_r($value);
					if(is_array($value))
					{
						
						$data = array(
						   'form_id' => $form_id ,
						   'question_num' => $key,
						   'user_hash' => $user_hash ,
						   'ans_value' => $value['ans'],
						);
						//print_r($data);
						$this->get_db->fill_form($data);
					}
					
				}
			}
			echo "感謝你把問卷填好，資料已上傳了";

			return ;
			//print_r($form_id);
			//$this->load->view('form_menu');
			//redirect('/form/fill_form_menu');
			
		}
		


	}


	public function form_check($hash='')
	{
		if($hash=='')
			$hash='3JTU7GD5W6';
		else 
			$this->auth_check('user');
		
		$data['results']=$this->get_db->get_form_result($hash);	
		if($data['results']!=null)
			$this->load->view('view_result',$data);
		else show_404();
	}

	


	private function auth_check($allow_lvl){
		
		switch ($allow_lvl)
		{
			case 'user':
				if(!$this->session->userdata('is_logged'))
					redirect('/login');
				break;
			case 'admin':
				if(!$this->session->userdata('is_admin'))
					redirect('/login');

				break	;


		}
		



	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */