<?php
/* 
 * File Name: settings.php
 	Created by shibu 
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller
{
    public function __construct()
    {
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->database();
			$this->load->library('form_validation');
			$this->load->helper('date');
			$this->load->library('encrypt');
			$this->load->helper('captcha');
			$this->data = array(
			'template' => 'common/template',
			'controller' => $this->router->fetch_class(),
			'method' => $this->router->fetch_method(),
			'session_userdata' => isset($this->session->userdata) ? $this->session->userdata : '',
			'base_url' => base_url(),
			'site_url'  => site_url()
	);
        //load the base model
      // $this->load->model('settings_model');
		
    }

	/*------------------------------------------index function-----------------------------------------*/
    function index()
    {
     	
		$data 		=	 array('title' => 'Login', 'page' => 'login', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 		=	 $data + $this->data; //constructor data+function data
	
		if(isset($data['post']['login']))
			{
				$vchr_uname			=	$data['post']['vchr_uname'];
				$vchr_pass			=	md5($data['post']['vchr_pass']);
				$options			=	array('vch_user_uname'=>$vchr_uname,'vch_user_password'=>$vchr_pass,'int_user_status'  =>'1');
				$this->load->model('base_model');
				//$count 				=	$this->base_model->loginCheck($options);
				$count=1;
			  if($count>0)
			   {    
			    
			   		$int_userid		=	$this->session->userdata('int_userid');
			   		$cur_date		= 	date('Y-m-d H:i:s');
			     //   $ip 			   = 	$_SERVER['REMOTE_ADDR'];
				   if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else {
    $ip = $_SERVER["REMOTE_ADDR"];
}
			   		/*$userlogoptions=	array(
											'intUserID'	   =>	$int_userid,
			   								'vchrLoginIP'	=>	$ip,
										   'dtmLoginDate'	=>	$cur_date);
										   
				     $User_log_id 		=	$this->base_model->Userlog_add($userlogoptions);
					 $this->session->set_userdata('User_log_id',$User_log_id);*/
					 $successmsg	=	"Logged in successfully";
					 $this->session->set_flashdata('logflag',$successmsg);
					 redirect('Master/dashboard');
				}
				else
				{

					 $this->session->set_flashdata('msg_valid', '<div align="right"  ><font color="#CC0000">Invalid Username and Password!!!</font></div>'); 	
					redirect('Master/index');
				}
			
		  }
		
    }
  
	
	
}
?>