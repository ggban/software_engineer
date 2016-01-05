<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReportController extends CI_Controller {

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
			$this->load->model('form');
			$this->load->model('answer');
			$this->load->model('fillList');
			$this->load->model('user');
			$this->load->model('group');
			//$this->load->model('user');
			//$this->load->library('session');

			
		}
	public function index()
	{

	}

	public function form_check($hash='')
	{
		if($hash=='')
			//$hash='3JTU7GD5W6';
			show_404();
		else 
			$this->auth_check('user');
		
		$data['results']=$this->answer->get_form_result($hash);	

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