<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
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
 * @see https://codeigniter.com/user_guide/general/urls.html
 */

public function __construct()
{
	parent::__construct();
	$this->load->library('session');
	$this->load->library('Phpass',array(8, FALSE));
	$this->load->helper('form');
	$this->load->helper('url');
	$this->load->database();
	$this->load->library('form_validation');
	$this->load->helper('date');
	//$this->load->helper('Specifictable_helper');
	$this->load->library('encrypt');
	$this->data 		= 	array(
	'controller' 			=> 	$this->router->fetch_class(),
	'method' 				=> 	$this->router->fetch_method(),
	'session_userdata' 		=> 	isset($this->session->userdata) ? $this->session->userdata : '',
	'base_url' 				=> 	base_url(),
	'site_url'  			=> 	site_url(),
	'user_sl' 				=> 	isset($this->session->userdata['int_userid']) ? $this->session->userdata['int_userid'] : 0,
	'user_type_id' 			=> 	isset($this->session->userdata['int_usertype']) ? $this->session->userdata['int_usertype'] : 0,
	'customer_id' 			=> 	isset($this->session->userdata['customer_id']) ? $this->session->userdata['customer_id'] : 0,
	'survey_user_id' 	=> 	isset($this->session->userdata['survey_user_id']) ? $this->session->userdata['survey_user_id'] : 0,
	);
	$this->load->model('Kiv_models/Master_model');
}
public function Logout()
{ 

	$this->load->model('Kiv_models/Master_model');
	$sess_usr_id 			=  $this->session->userdata('int_userid');
	$login_time 			=  $this->session->userdata('login_time');
	
	//date_default_timezone_set("Asia/Kolkata");
	$timestamp = time();
	$date_time = date("Y-m-d  H:i:s", $timestamp);
	$logout_time = $date_time;
	/*session_destroy();
	$this->cache->clean();
	$this->db->cache_delete_all();*/
	$this->session->sess_destroy();
	if(isset($sess_usr_id))
	{
		$this->Master_model->update_userlog($sess_usr_id,$login_time,$logout_time);
	}
	redirect('Main_login/index');
}
	
/*---------------------------- checking of session set or not ----------------------------*/
public function MasterHome()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');
	$int_usertype	  =	$this->session->userdata('int_usertype');
	//if(!empty($sess_usr_id)&&($int_usertype==10))//
	if(!empty($sess_usr_id) && ($int_usertype==10))
	{
		$data 			=	 array('title' => 'MasterHome', 'page' => 'MasterHome', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			=	 $data + $this->data;
		$this->load->model('Kiv_models/Master_model');
		/* ======Added for dynamic menu listing (start) on 02.11.2019========   */ 
		$menu			= 	$this->Master_model->get_menu($int_usertype); //print_r($menu);
		$data['menu']	=	$menu;
		$data 			= 	$data + $this->data;
		/* ======Added for dynamic menu listing (end) on 02.11.2019========   */ 
		$master_table		= 	$this->Master_model->get_mastertable(); //print_r($master_table);exit;
		$data['master_table']	=	$master_table;
		$data 			= 	$data + $this->data;//print_r($data);exit;

		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/MasterHome',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	} 
}

///////////////////Vessel Category Start//////////////////////////
public function vesselcategory()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 					= 	array('title' => 'vesselcategory', 'page' => 'vesselcategory', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$vesselcategory			= 	$this->Master_model->get_vesselcategory();
		$data['vesselcategory']	=	$vesselcategory;
		$data 					= 	$data + $this->data;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/vesselcategory',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}
	
///////////////////Add Vessel Category Start//////////////////////////
public function add_vesselcategory()
{
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data = 	array('title' => 'vesselcategory', 'page' => 'vesselcategory', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 	= 	$data + $this->data;

		//set validation rules
		$this->form_validation->set_rules('vesselcategory_name', 'Vessel Category Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('vesselcategory_code', 'Vessel Category Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{
			$vesselcategory_ins 			= 	$this->input->post('vesselcategory_ins');
			$vesselcategory_name			= 	$this->input->post('vesselcategory_name');
			$vesselcategory_mal_name 		= 	$this->input->post('vesselcategory_mal_name');
			$vesselcategory_code 			= 	$this->input->post('vesselcategory_code');
			//$chkduplication	=$this->Master_model->check_duplication_vesselcategory($vesselcategory_name);
			/*check duplication in insert 22-06-2018*/
			$chkduplication	=$this->Master_model->check_duplication_vesselcategory_insert($vesselcategory_name,$vesselcategory_code);
			$cntrows	=count($chkduplication);
			if($cntrows==0)
			{
				if($vesselcategory_ins=="Save Vessel Category")
				{
					$data 			= 	array(
					'vesselcategory_name' 				=>	$vesselcategory_name,  
					'vesselcategory_mal_name' 			=> 	$vesselcategory_mal_name,
					'vesselcategory_code' 				=> 	$vesselcategory_code,
					'vesselcategory_status'				=>	'1',
					'vesselcategory_created_user_id'	=> 	$sess_usr_id,
					'vesselcategory_created_timestamp'	=>	$date,
					'vesselcategory_created_ipaddress'	=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res		=	$this->db->insert('kiv_vesselcategory_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Vessel Category successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
			echo json_encode(array("val_errors" => "Vessel Category Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}
///////////////////Add Vessel Category End//////////////////////////

	
///////////////////Status Vessel Category Start//////////////////////////
public function status_vesselcategory()
{
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 			= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 				= 	array('title' => 'vesselcategory', 'page' => 'vesselcategory', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array(
		'vesselcategory_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_vesselcategory_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}	
///////////////////Status Vessel Category End//////////////////////////	
	
	
///////////////////Delete Vessel Category Start//////////////////////////
public function delete_vesselcategory()
{
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 			= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 				= 	array('title' => 'vesselcategory', 'page' => 'vesselcategory', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_vesselcategory($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}	
///////////////////Delete Vessel Category End//////////////////////////
	
	
///////////////////Edit Vessel Category Start//////////////////////////
public function edit_vesselcategory()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 					= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data = 	array('title' => 'vesselcategory', 'page' => 'vesselcategory', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 	= 	$data + $this->data;
		$this->form_validation->set_rules('edit_vesselcategory', 'Vessel Category Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_vesselcategory_code', 'Vessel Category Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 				= 	$this->input->post('id');
			$id           			=	$this->security->xss_clean($id);
			$edit_vesselcategory 		= 	$this->input->post('edit_vesselcategory');
			$edit_vesselcategory_mal 	= 	$this->input->post('edit_vesselcategory_mal');
			$edit_vesselcategory_code 	= 	$this->input->post('edit_vesselcategory_code');
			$edit_vesselcategory    	= 	$this->security->xss_clean($edit_vesselcategory);

			/*Edited on 14-06-2018  Start*/	//$chkduplication	=	$this->Master_model->check_duplication_vesselcategory($edit_vesselcategory);
			$chkduplication	=$this->Master_model->check_duplication_vesselcategory_edit($edit_vesselcategory,$edit_vesselcategory_code,$id);
			/*End*/
			$cntrows			=	count($chkduplication);
			if($cntrows==0)
			{
				$data 			= 	array(
				'vesselcategory_name' 				=>	$edit_vesselcategory,  
				'vesselcategory_mal_name' 			=> 	$edit_vesselcategory_mal,
				'vesselcategory_code' 				=> 	$edit_vesselcategory_code,
				'vesselcategory_modified_user_id'	=>	$sess_usr_id,
				'vesselcategory_modified_ipaddress'	=>	$ip);
				$data 		= $this->security->xss_clean($data);
				$edit_check	= $this->Master_model->edit_vesselcategory($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Vessel Category Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Vessel Category Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	
///////////////////Edit Vessel Category End//////////////////////////	
//----------/////////////////Vessel Category End ////////////////////////-----------//
	
//-----//////////////////Vessel Sub Category Start/////////////////////////---------//
public function vessel_subcategory()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 					= 	array('title' => 'vessel_subcategory', 'page' => 'vessel_subcategory', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$vessel_subcategory			= 	$this->Master_model->get_vessel_subcategory();
		$data['vessel_subcategory']             =	$vessel_subcategory;
		$data 					= 	$data + $this->data;
		$vessel_category			=$this->Master_model->get_vessel_category();
		$data['vessel_category']	=	 $vessel_category;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/vessel_subcategory',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	}  
}
    
///////////////////Add Vessel Sub Category Start//////////////////////////
public function add_vessel_subcategory()
{
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 	= 	array('title' => 'vessel_subcategory', 'page' => 'vessel_subcategory', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 	= 	$data + $this->data;

		//set validation rules

		//$this->form_validation->set_rules('vessel_subcategory_category_id', 'Vessel Category Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('vessel_subcategory_name', 'Vessel Sub Category Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('vessel_subcategory_code', 'Vessel Sub Category Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{
			$vessel_subcategory_ins 	= 	$this->input->post('vessel_subcategory_ins');
			$vessel_subcategory_category_id        =       $this->input->post('vessel_subcategory_category_id');
			$vessel_subcategory_name                = 	$this->input->post('vessel_subcategory_name');
			$vessel_subcategory_mal_name                    = 	$this->input->post('vessel_subcategory_mal_name');
			$vessel_subcategory_code 			= 	$this->input->post('vessel_subcategory_code');

			$chkduplication	=$this->Master_model->check_duplication_vessel_subcategory_insert($vessel_subcategory_category_id,$vessel_subcategory_name,$vessel_subcategory_code);
			$cntrows						=	count($chkduplication);
			if($cntrows==0)
			{
				if($vessel_subcategory_ins=="Save Vessel Sub Category")
				{
					$data 	= 	array(
					'vessel_subcategory_category_id'            =>	$vessel_subcategory_category_id,
					'vessel_subcategory_name' 		=>	$vessel_subcategory_name,  
					'vessel_subcategory_mal_name'           => 	$vessel_subcategory_mal_name,
					'vessel_subcategory_code' 		=> 	$vessel_subcategory_code,
					'vessel_subcategory_status'		=>	'1',
					'vessel_subcategory_created_user_id'	=> 	$sess_usr_id,
					'vessel_subcategory_created_timestamp'	=>	$date,
					'vessel_subcategory_created_ipaddress'	=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res		=	$this->db->insert('kiv_vessel_subcategory_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Vessel Sub Category successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
			echo json_encode(array("val_errors" => "Vessel Sub Category Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}
///////////////////Add Vessel Sub Category End//////////////////////////  
       
///////////////////Status Vessel Sub Category Start//////////////////////////
public function status_vessel_subcategory()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 				= 	array('title' => 'vessel_subcategory', 'page' => 'vessel_subcategory', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('vessel_subcategory_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_vessel_subcategory_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}	
///////////////////Status Vessel Category End//////////////////////////	  
    
    
///////////////////Delete Vessel Sub Category Start//////////////////////////
public function delete_vessel_subcategory()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 				= 	array('title' => 'vessel_subcategory', 'page' => 'vessel_subcategory', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_vessel_subcategory($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}	
///////////////////Delete Vessel Sub Category End//////////////////////////
    
    
///////////////////Edit Vessel SubCategory Start//////////////////////////
public function edit_vessel_subcategory()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 					= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 					= 	array('title' => 'vessel_subcategory', 'page' => 'vessel_subcategory', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;
		$this->form_validation->set_rules('edit_vessel_subcategory', 'Vessel Sub Category Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_vessel_subcategory_code', 'Vessel Sub Category Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 				= 	$this->input->post('id');
			$id                             =	$this->security->xss_clean($id);
			$edit_vessel_subcategory_category_id=$this->input->post('edit_vessel_subcategory_category_id');
			$edit_vessel_subcategory	= 	$this->input->post('edit_vessel_subcategory');
			$edit_vessel_subcategory_mal 	= 	$this->input->post('edit_vessel_subcategory_mal');
			$edit_vessel_subcategory_code 	= 	$this->input->post('edit_vessel_subcategory_code');

			$edit_vessel_subcategory    = 	$this->security->xss_clean($edit_vessel_subcategory);
			//$chkduplication		=	$this->Master_model->check_duplication_vessel_subcategoryname($edit_vessel_subcategory);
			$chkduplication	=$this->Master_model->check_duplication_vessel_subcategory_edit($edit_vessel_subcategory_category_id,$edit_vessel_subcategory,$edit_vessel_subcategory_code,$id);
			$cntrows			=	count($chkduplication);
			if($cntrows==0)
			{
				$data = array('vessel_subcategory_category_id'  =>      $edit_vessel_subcategory_category_id,
				'vessel_subcategory_name' 		=>	$edit_vessel_subcategory,  
				'vessel_subcategory_mal_name'           => 	$edit_vessel_subcategory_mal,
				'vessel_subcategory_code' 		=> 	$edit_vessel_subcategory_code,
				'vessel_subcategory_modified_user_id'	=>	$sess_usr_id,
				'vessel_subcategory_modified_ipaddress'	=>	$ip);

				$data 		= $this->security->xss_clean($data);
				$edit_check	= $this->Master_model->edit_vessel_subcategory($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Vessel Sub Category Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Vessel Sub Category Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	
///////////////////Edit Vessel Sub Category End//////////////////////////	
   
    
//-----//////////////////Vessel Sub Category End/////////////////////////---------//	
/*____________________________________________________________________________________________*/	

//                           VESSEL TYPE

//____________________________________________________________________________________________________________________________________________	

// List Vessel Type  starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function vesselType()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 			= 	array('title' => 'vessel_type', 'page' => 'vessel_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			= 	$data + $this->data;     
		$vesseltype		= 	$this->Master_model->get_vesselType();
		$data['vesseltype']	=	$vesseltype;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
			
		$this->load->model('Kiv_models/Master_model');
        $this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/vessel_type',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
  	}  
}

// List Vessel Type end
/*____________________________________________________________________________________________________________________________________________*/	

//____________________________________________________________________________________________________________________________________________	

// Add Vessel Type  starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_vesseltype()
{
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
		$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'vesseltype', 'page' => 'vesseltype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;
		
		//set validation rules
		$this->form_validation->set_rules('vesseltype_name', 'vessel Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('vesseltype_code', 'Vessel Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
             $valErrors				= 	validation_errors();
			 echo json_encode(array("val_errors" => $valErrors));
			 exit;
        } 
        else 
        { 
			$vesseltype_insert 			= 	$this->input->post('vesseltype_insert');
			$vesseltype_name			= 	$this->input->post('vesseltype_name');
			$vesseltype_mal_name 			= 	$this->input->post('vesseltype_mal_name');
			$vesseltype_code 			= 	$this->input->post('vesseltype_code');
			
			$chkduplication	=$this->Master_model->check_duplication_vesseltype_insert($vesseltype_name,$vesseltype_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($vesseltype_insert=="Save Vessel Type")
				{
					$data 	= 	array(
					'vesseltype_name' 				=>	$vesseltype_name,  
					'vesseltype_mal_name' 				=> 	$vesseltype_mal_name,
					'vesseltype_code' 				=> 	$vesseltype_code,
					'vesseltype_status'				=>	'1',
					'vesseltype_created_user_id'	=> 	$sess_usr_id,
					'vesseltype_created_timestamp'	=>	$date,
					'vesseltype_created_ipaddress'	=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res		=	$this->db->insert('kiv_vesseltype_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Vessel Type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Vessel Type Already Exists!!!"));
				
			}
		}
	}
   	else
   	{
		redirect('Main_login/index');        
	}  
}	

//Add vessel type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Vessel Type  starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function status_vesseltype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 				= 	array('title' => 'vesseltype', 'page' => 'vesseltype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('vesseltype_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_vesseltype_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
   	{
		redirect('Main_login/index');        
	}	
}		
	
//Status vessel type ends.	
/*____________________________________________________________________________________________________________________________________________*/	

//____________________________________________________________________________________________________________________________________________	

// Delete Vessel Type  starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function delete_vesseltype()
{
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
		$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 				= 	array('title' => 'vesseltype', 'page' => 'vesseltype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
			$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_vesseltype($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
   	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Vessel Type  starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_vesseltype()
{		
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
		$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'vessel_type', 'page' => 'vessel_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		
		$this->form_validation->set_rules('edit_vesseltype', 'Vessel Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_vesseltype_code', 'Vessel Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
        {
             $valErrors			= 	validation_errors();
			 echo json_encode(array("val_errors" => $valErrors));
        } 
        else 
        {
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_vesseltype 	= 	$this->input->post('edit_vesseltype');
			$edit_vesseltype_mal 	= 	$this->input->post('edit_vesseltype_mal');
			$edit_vesseltype_code	= 	$this->input->post('edit_vesseltype_code');
			
			$edit_vesseltype	= 	$this->security->xss_clean($edit_vesseltype);
						
			/*Edited on 14-06-2018  Start*/	//$chkduplication	=	$this->Master_model->check_duplication_vesseltype($edit_vesseltype);
			$chkduplication	=$this->Master_model->check_duplication_vesseltype_edit($edit_vesseltype,$edit_vesseltype_code,$id);
			/*End*/
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'vesseltype_name' 		=>	$edit_vesseltype,  
				'vesseltype_mal_name' 		=> 	$edit_vesseltype_mal,
				'vesseltype_code' 		=> 	$edit_vesseltype_code,
				'vesseltype_modified_user_id'	=>	$sess_usr_id,
				'vesseltype_modified_ipaddress'	=>	$ip);
				$data		 = $this->security->xss_clean($data);
				$edit_check	 = $this->Master_model->edit_vesseltype($id,$data);
				if($edit_check)
				{
	            	echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Vessel Type Updated Successfully!!!</div>');
				}
			}
	        else 
		    {
				echo json_encode(array("val_errors" => "Vessel Type Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
   	{
		redirect('Main_login/index');        
	}

}	

//Edit vessel type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                                PORT OF REGISTRY

//____________________________________________________________________________________________________________________________________________	

// List Port of registry  starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function portofRegistry()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 			= 	array('title' => 'portofregistry', 'page' => 'portofregistry', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			= 	$data + $this->data;     
		$portofregistry	= 	$this->Master_model->get_portofregistry();
		$data['portofregistry']	=	$portofregistry;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
			
		$this->load->model('Kiv_models/Master_model');
        $this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/portofregistry',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
   }
   else
   {
		redirect('Main_login/index');        
	}  
}

// List port of registry end
/*____________________________________________________________________________________________________________________________________________*/	

//____________________________________________________________________________________________________________________________________________	

// Add Port of registry  starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_portofRegistry()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= 	array('title' => 'portofregistry', 'page' => 'portofregistry', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 						= 	$data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('portofregistry_name', 'Port of Registry', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('portofregistry_code', 'Port of Registry Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{
			$portofregistry_ins 		= 	$this->input->post('portofregistry_ins');
			$portofregistry_name		= 	$this->input->post('portofregistry_name');
			$portofregistry_mal_name 	= 	$this->input->post('portofregistry_mal_name');
			$portofregistry_code 		= 	$this->input->post('portofregistry_code');
			$chkduplication			=	$this->Master_model->check_duplication_portofregistry_insert($portofregistry_name,$portofregistry_code);
			$cntrows			=	count($chkduplication);
			if($cntrows==0)
			{
				if($portofregistry_ins=="Save Port of Registry")
				{
					$data 			= 	array(
					'portofregistry_name' 			=>	$portofregistry_name,  
					'portofregistry_mal_name' 		=> 	$portofregistry_mal_name,
					'portofregistry_code' 			=> 	$portofregistry_code,
					'portofregistry_status'			=>	'1',
					'portofregistry_created_user_id'	=> 	$sess_usr_id,
					'portofregistry_created_timestamp'	=>	$date,
					'portofregistry_created_ipaddress'	=>	$ip	);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res		=	$this->db->insert('kiv_portofregistry_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Port of Registry successfully Added!!!</div>');
					}
				}
			}
			else 
			{
			echo json_encode(array("val_errors" => "Port of Registry Name Or Port of Registry Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add port of registry ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status port of registry  starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_portofRegistry()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 	= 	array('title' => 'portofregistry', 'page' => 'portofregistry', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('portofregistry_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_portofregistry_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		

	
//Status port of registry ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete port of registry  starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_portofRegistry()
{
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 				= 	array('title' => 'portofregistry', 'page' => 'portofregistry', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_portofregistry($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		

// delete portof registry end
//____________________________________________________________________________________________________________________________________________	


//____________________________________________________________________________________________________________________________________________	

// Edit port of registry  starting...  (07-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_portofregistry()
{	
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'portofregistry', 'page' => 'portofregistry', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;

		$this->form_validation->set_rules('edit_portofregistry', 'Port of registry Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_portofregistry_code', 'Port of registry Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 				= 	$this->input->post('id');
			$id           			=	$this->security->xss_clean($id);
			$edit_portofregistry 		= 	$this->input->post('edit_portofregistry');
			$edit_portofregistry_mal 	= 	$this->input->post('edit_portofregistry_mal');
			$edit_portofregistry_code 	= 	$this->input->post('edit_portofregistry_code');

			$edit_portofregistry    = 	$this->security->xss_clean($edit_portofregistry);

			/*Edited on 14-06-2018  Start*/	//$chkduplication	=	$this->Master_model->check_duplication_portofregistry($edit_portofregistry);
			$chkduplication	=$this->Master_model->check_duplication_portofregistry_edit($edit_portofregistry,$edit_portofregistry_code,$id);
			/*End*/
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'portofregistry_name' 			=>	$edit_portofregistry,  
				'portofregistry_mal_name' 		=> 	$edit_portofregistry_mal,
				'portofregistry_code' 			=> 	$edit_portofregistry_code,
				'portofregistry_modified_user_id'	=>	$sess_usr_id,
				'portofregistry_modified_ipaddress'	=>	$ip);
				$data		 = $this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_portofregistry($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Port of registry Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Port of Registry Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}
// Edit Portof registry end			
//____________________________________________________________________________________________________________________________________________	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                VESSEL SUB TYPE

//____________________________________________________________________________________________________________________________________________	

// List Vessel Sub Type  starting...  (07-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function vessel_subtype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'vessel_subtype', 'page' => 'vessel_subtype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;     
		$vessel_subtype			= 	$this->Master_model->get_vessel_subtype();
		$data['vessel_subtype']     	=	$vessel_subtype;
		$data 				= 	$data + $this->data;
		$vessel_type			=	$this->Master_model->get_vessel_type();
		$data['vessel_type']		=	$vessel_type;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/vessel_subtype',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}
//    List Vessel sub type ends
//____________________________________________________________________________________________________________________________________________	

	
//____________________________________________________________________________________________________________________________________________	

// Add Vessel Sub Type  starting...  (07-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_vessel_subtype()
{
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 						= 	array('title' => 'vessel_subcategory', 'page' => 'vessel_subcategory', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 						= 	$data + $this->data;
		//set validation rules
		//$this->form_validation->set_rules('vessel_subtype_category_id', 'Vessel Category Name', 'required');
		$this->form_validation->set_rules('vessel_subtype_name', 'Vessel Sub Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('vessel_subtype_code', 'Vessel Sub Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		}
		else 
		{
			$vessel_subtype_ins 		= 	$this->input->post('vessel_subtype_ins');
			$vessel_subtype_vesseltype_id 	=       $this->input->post('vessel_subtype_vesseltype_id');
			$vessel_subtype_name       	= 	$this->input->post('vessel_subtype_name');
			$vessel_subtype_mal_name        = 	$this->input->post('vessel_subtype_mal_name');
			$vessel_subtype_code 		= 	$this->input->post('vessel_subtype_code');

			$chkduplication			=	$this->Master_model->check_duplication_vessel_subtype_insert($vessel_subtype_vesseltype_id,$vessel_subtype_name,$vessel_subtype_code);
			$cntrows						=	count($chkduplication);
			if($cntrows==0)
			{
				if($vessel_subtype_ins=="Save Vessel Sub Type")
				{
					$data 			= 	array(
					'vessel_subtype_vesseltype_id'    =>	$vessel_subtype_vesseltype_id,
					'vessel_subtype_name' 		  =>	$vessel_subtype_name,  
					'vessel_subtype_mal_name'         => 	$vessel_subtype_mal_name,
					'vessel_subtype_code' 		  => 	$vessel_subtype_code,
					'vessel_subtype_status'		  =>	'1',
					'vessel_subtype_created_user_id'  => 	$sess_usr_id,
					'vessel_subtype_created_timestamp'=>	$date,
					'vessel_subtype_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res		=	$this->db->insert('kiv_vessel_subtype_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Vessel Sub Type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Vessel Sub Type Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}
//    Add Vessel sub type ends
//____________________________________________________________________________________________________________________________________________	

	
//____________________________________________________________________________________________________________________________________________	

// Status Vessel Sub Type  starting...  (07-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function status_vessel_subtype()
{
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
		$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 				= 	array('title' => 'vessel_subtype', 'page' => 'vessel_subtype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
	
		$data 				= 	array('vessel_subtype_status' => $updstat);
		$updstatus_res			=	$this->Master_model->update_vessel_subtype_status($data,$id);
		
		if($updstatus_res){
			echo json_encode(array("status" => TRUE));
		}
	}
	else
   	{
		redirect('Main_login/index');        
		}	
}	

//    Status Vessel type ends
//____________________________________________________________________________________________________________________________________________	

	
//____________________________________________________________________________________________________________________________________________	

// Delete Vessel Sub Type  starting...  (07-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function delete_vessel_subtype()
{
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
		$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 				= 	array('title' => 'vessel_subtype', 'page' => 'vessel_subtype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
	
		$data 				= 	array('delete_status' => $updstat);
		$delete_result			=	$this->Master_model->delete_vessel_subtype($data,$id);
		if($delete_result){
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
   	{
		redirect('Main_login/index');        
	}	
}	

//    Delete Vessel Sub type ends
//____________________________________________________________________________________________________________________________________________	

	
//____________________________________________________________________________________________________________________________________________	

// Edit Vessel Sub Type  starting...  (07-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function edit_vessel_subtype()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'vessel_subtype', 'page' => 'vessel_subtype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = 	$data + $this->data;
		$this->form_validation->set_rules('edit_vessel_subtype', 'Vessel Sub Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_vessel_subtype_code', 'Vessel Sub Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 				= 	$this->input->post('id');
			$id                 =	$this->security->xss_clean($id);
			$edit_vessel_subtype_vesseltype_id=$this->input->post('edit_vessel_subtype_vesseltype_id');
			$edit_vessel_subtype		= 	$this->input->post('edit_vessel_subtype');
			$edit_vessel_subtype_mal 	= 	$this->input->post('edit_vessel_subtype_mal');
			$edit_vessel_subtype_code 	= 	$this->input->post('edit_vessel_subtype_code');

			$edit_vessel_subtype    = 	$this->security->xss_clean($edit_vessel_subtype);
			//$chkduplication	=	$this->Master_model->check_duplication_vessel_subtypename($edit_vessel_subtype);
			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_vessel_subtype_edit($edit_vessel_subtype_vesseltype_id,$edit_vessel_subtype,$edit_vessel_subtype_code,$id);
			/*End*/
			$cntrows			=	count($chkduplication);
			if($cntrows==0)
			{
				$data = 	array('vessel_subtype_vesseltype_id'      =>  $edit_vessel_subtype_vesseltype_id,
				'vessel_subtype_name' 		    =>	$edit_vessel_subtype,  
				'vessel_subtype_mal_name'           => 	$edit_vessel_subtype_mal,
				'vessel_subtype_code' 		    => 	$edit_vessel_subtype_code,
				'vessel_subtype_modified_user_id'   =>	$sess_usr_id,
				'vessel_subtype_modified_ipaddress' =>	$ip);
				$data		 = $this->security->xss_clean($data);
				$edit_check	 = $this->Master_model->edit_vessel_subtype($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Vessel Sub Type Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Vessel Sub Type Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	
//    Edit Vessel Sub type ends
//____________________________________________________________________________________________________________________________________________	

	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                                HULL MATERIAL

//____________________________________________________________________________________________________________________________________________	

// List Hull material starting...  (07-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function hullmaterial()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'hull_material', 'page' => 'hull_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$hullmaterial		= 	$this->Master_model->get_hullmaterial();
		$data['hullmaterial']	=	$hullmaterial;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
			
		$this->load->model('Kiv_models/Master_model');
        $this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/hull_material',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
  	}  
}

// List Hull material end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add hull_material starting...  (07-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_hullmaterial()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'hull_material', 'page' => 'hull_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = 	$data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('hullmaterial_name', 'Hull Material Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('hullmaterial_code', 'Hull Material Code', 'required|callback_minalpha_check');

		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$hullmaterial_ins 			= 	$this->input->post('hullmaterial_ins');
			$hullmaterial_name			= 	$this->input->post('hullmaterial_name');
			$hullmaterial_mal_name 			= 	$this->input->post('hullmaterial_mal_name');
			$hullmaterial_code 			= 	$this->input->post('hullmaterial_code');
			$chkduplication				=	$this->Master_model->check_duplication_hullmaterial_insert($hullmaterial_name,$hullmaterial_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($hullmaterial_ins=="Save Hull Material")
				{
					$data 			= 	array(
					'hullmaterial_name' 		=>	$hullmaterial_name,  
					'hullmaterial_mal_name' 	=> 	$hullmaterial_mal_name,
					'hullmaterial_code' 		=> 	$hullmaterial_code,
					'hullmaterial_status'		=>	'1',
					'hullmaterial_created_user_id'	=> 	$sess_usr_id,
					'hullmaterial_created_timestamp'=>	$date,
					'hullmaterial_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_hullmaterial_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Hull Material successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Hull Material Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Hull material ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Hull material starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_hullmaterial()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'hull_material', 'page' => 'hull_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data =	array('hullmaterial_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_hullmaterial_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status hullmaterial ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete hullmaterial  starting...  (07-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_hullmaterial()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'hull_material', 'page' => 'hull_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_hullmaterial($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Hull Material starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_hullmaterial()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'hull_material', 'page' => 'hull_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_hullmaterial', 'Hull Material Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_hullmaterial_code', 'Hull Material Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_hullmaterial 	= 	$this->input->post('edit_hullmaterial');
			$edit_hullmaterial_mal 	= 	$this->input->post('edit_hullmaterial_mal');
			$edit_hullmaterial_code	= 	$this->input->post('edit_hullmaterial_code');

			$edit_hullmaterial	= 	$this->security->xss_clean($edit_hullmaterial);
			//$chkduplication		=	$this->Master_model->check_duplication_hullmaterial($edit_hullmaterial);

			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_hullmaterial_edit($edit_hullmaterial,$edit_hullmaterial_code,$id);
			/*End*/					$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'hullmaterial_name' 		 =>	$edit_hullmaterial,  
				'hullmaterial_mal_name' 	 => 	$edit_hullmaterial_mal,
				'hullmaterial_code' 		 => 	$edit_hullmaterial_code,
				'hullmaterial_modified_user_id'	 =>	$sess_usr_id,
				'hullmaterial_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_hullmaterial($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Hull Material Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Hull Material Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit hull material ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                ENGINE TYPE

//____________________________________________________________________________________________________________________________________________	

// List Engine Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function enginetype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'engine_type', 'page' => 'engine_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$enginetype		= 	$this->Master_model->get_enginetype();
		$data['enginetype']	=	$enginetype;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;

		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/engine_type',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Engine Type end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add engine_type starting...  (07-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_enginetype()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'engine_type', 'page' => 'engine_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('enginetype_name', 'Engine Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('enginetype_code', 'Engine Type Code', 'required|callback_minalpha_check');

		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$enginetype_ins 			= 	$this->input->post('enginetype_ins');
			$enginetype_name			= 	$this->input->post('enginetype_name');
			$enginetype_mal_name 		= 	$this->input->post('enginetype_mal_name');
			$enginetype_code 			= 	$this->input->post('enginetype_code');
			$chkduplication				=	$this->Master_model->check_duplication_enginetype_insert($enginetype_name,$enginetype_code); 
			$cntrows					=	count($chkduplication);
			if($cntrows==0)
			{
				if($enginetype_ins=="Save Engine Type")
				{
					$data 			= 	array(
					'enginetype_name' 		=>	$enginetype_name,  
					'enginetype_mal_name' 	=> 	$enginetype_mal_name,
					'enginetype_code' 		=> 	$enginetype_code,
					'enginetype_status'		=>	'1',
					'enginetype_created_user_id'	=> 	$sess_usr_id,
					'enginetype_created_timestamp'=>	$date,
					'enginetype_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_enginetype_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Engine Type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Engine Type Name or Engine Type Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Engine Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Engine Type starting...  (06-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_enginetype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'engine_type', 'page' => 'engine_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('enginetype_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_enginetype_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status enginetype ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete enginetype  starting...  (07-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_enginetype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'engine_type', 'page' => 'engine_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_enginetype($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Gear Type  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_enginetype()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'engine_type', 'page' => 'engine_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_enginetype', 'Engine Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_enginetype_code', 'Engine Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_enginetype 	= 	$this->input->post('edit_enginetype');
			$edit_enginetype_mal 	= 	$this->input->post('edit_enginetype_mal');
			$edit_enginetype_code	= 	$this->input->post('edit_enginetype_code');
			$edit_enginetype	= 	$this->security->xss_clean($edit_enginetype);

			/*Edited on 14-06-2018  Start*/	//$chkduplication		=	$this->Master_model->check_duplication_enginetype($edit_enginetype);
			$chkduplication	=$this->Master_model->check_duplication_enginetype_edit($edit_enginetype,$edit_enginetype_code,$id);
			/*End*/					
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'enginetype_name' 		 =>	$edit_enginetype,  
				'enginetype_mal_name' 		 => 	$edit_enginetype_mal,
				'enginetype_code' 		 => 	$edit_enginetype_code,
				'enginetype_modified_user_id'	 =>	$sess_usr_id,
				'enginetype_modified_ipaddress'	 =>	$ip);


				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_enginetype($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Engine Type Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Engine Type Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
	redirect('Main_login/index');        
	}
}	

//Edit Engine Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                GEAR TYPE

//____________________________________________________________________________________________________________________________________________	

// List Gear Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function geartype()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'gear_type', 'page' => 'gear_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$geartype		= 	$this->Master_model->get_geartype();
		$data['geartype']	=	$geartype;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
			
		$this->load->model('Kiv_models/Master_model');

        $this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/gear_type',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
                        
	}
	else
	{
		redirect('Main_login/index');        
  	}  

    
}

// List gear Type end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add gear_type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_geartype()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'gear_type', 'page' => 'gear_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;


		//set validation rules
		$this->form_validation->set_rules('geartype_name', 'Gear Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('geartype_code', 'Gear Type Code', 'required|callback_minalpha_check');

		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$geartype_ins 			= 	$this->input->post('geartype_ins');
			$geartype_name			= 	$this->input->post('geartype_name');
			$geartype_mal_name 		= 	$this->input->post('geartype_mal_name');
			$geartype_code 			= 	$this->input->post('geartype_code');
			$chkduplication	=$this->Master_model->check_duplication_geartype_insert($geartype_name,$geartype_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($geartype_ins=="Save Gear Type")
				{
					$data 			= 	array(
					'geartype_name' 		=>	$geartype_name,  
					'geartype_mal_name' 		=> 	$geartype_mal_name,
					'geartype_code' 		=> 	$geartype_code,
					'geartype_status'		=>	'1',
					'geartype_created_user_id'	=> 	$sess_usr_id,
					'geartype_created_timestamp'=>	$date,
					'geartype_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_geartype_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Gear Type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
			echo json_encode(array("val_errors" => "Gear Type Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add gear Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status gear Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_geartype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'gear_type', 'page' => 'gear_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('geartype_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_geartype_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		

	
//Status geartype ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete geartype  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_geartype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'gear_type', 'page' => 'gear_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_geartype($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Gear Type  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_geartype()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'gear_type', 'page' => 'gear_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_geartype', 'Gear Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_geartype_code', 'Gear Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_geartype 	= 	$this->input->post('edit_geartype');
			$edit_geartype_mal 	= 	$this->input->post('edit_geartype_mal');
			$edit_geartype_code	= 	$this->input->post('edit_geartype_code');

			$edit_geartype	= 	$this->security->xss_clean($edit_geartype);
			//$chkduplication		=	$this->Master_model->check_duplication_geartype($edit_geartype);


			/*Edited on 14-06-2018  Start*/	//$chkduplication	=	$this->Master_model->check_duplication_vessel_subtypename($edit_vessel_subtype);
			$chkduplication	=$this->Master_model->check_duplication_geartype_edit($edit_geartype,$edit_geartype_code,$id);
			/*End*/				$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'geartype_name' 		 =>	$edit_geartype,  
				'geartype_mal_name' 	 	 => 	$edit_geartype_mal,
				'geartype_code' 		 => 	$edit_geartype_code,
				'geartype_modified_user_id'	 =>	$sess_usr_id,
				'geartype_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_geartype($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Gear Type Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Gear Type Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
	redirect('Main_login/index');        
	}
}	

//Edit gear Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                                CHAIN PORT TYPE

//____________________________________________________________________________________________________________________________________________	

// List Chain Port Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function chainporttype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'chainport_type', 'page' => 'chainport_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$chainporttype		= 	$this->Master_model->get_chainporttype();
		$data['chainporttype']	=	$chainporttype;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/chainport_type',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');        
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Chain Port Type end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add chainport_type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_chainporttype()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'chainport_type', 'page' => 'chainport_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		//set validation rules
		$this->form_validation->set_rules('chainporttype_name', 'Chain Port Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('chainporttype_code', 'Chain Port Type Code', 'required|callback_minalpha_check');

		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$chainporttype_ins 			= 	$this->input->post('chainporttype_ins');
			$chainporttype_name			= 	$this->input->post('chainporttype_name');
			$chainporttype_mal_name 			= 	$this->input->post('chainporttype_mal_name');
			$chainporttype_code 			= 	$this->input->post('chainporttype_code');
			$chkduplication				=	$this->Master_model->check_duplication_chainporttype_insert($chainporttype_name,$chainporttype_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($chainporttype_ins=="Save Chain Port Type")
				{
					$data 			= 	array(
					'chainporttype_name' 		=>	$chainporttype_name,  
					'chainporttype_mal_name' 	=> 	$chainporttype_mal_name,
					'chainporttype_code' 		=> 	$chainporttype_code,
					'chainporttype_status'		=>	'1',
					'chainporttype_created_user_id'	=> 	$sess_usr_id,
					'chainporttype_created_timestamp'=>	$date,
					'chainporttype_created_ipaddress'=>	$ip	);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_chainporttype_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Chain Port Type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
			echo json_encode(array("val_errors" => "Chain Port Type Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Chain Port Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Chain Port Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_chainporttype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'chainport_type', 'page' => 'chainport_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('chainporttype_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_chainporttype_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status chainporttype ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete chainporttype  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_chainporttype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'chainport_type', 'page' => 'chainport_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_chainporttype($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Chain Port Type  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_chainporttype()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'chainport_type', 'page' => 'chainport_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_chainporttype', 'Chain Port Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_chainporttype_code', 'Chain Port Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_chainporttype 	= 	$this->input->post('edit_chainporttype');
			$edit_chainporttype_mal 	= 	$this->input->post('edit_chainporttype_mal');
			$edit_chainporttype_code	= 	$this->input->post('edit_chainporttype_code');

			$edit_chainporttype	= 	$this->security->xss_clean($edit_chainporttype);
			//$chkduplication		=	$this->Master_model->check_duplication_chainporttype($edit_chainporttype);

			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_chainporttype_edit($edit_chainporttype,$edit_chainporttype_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'chainporttype_name' 		 =>	$edit_chainporttype,  
				'chainporttype_mal_name' 	 => 	$edit_chainporttype_mal,
				'chainporttype_code' 		 => 	$edit_chainporttype_code,
				'chainporttype_modified_user_id'	 =>	$sess_usr_id,
				'chainporttype_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_chainporttype($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Chain Port Type Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Chain Port Type Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Chain Port Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                                ROPE MATERIAL

//____________________________________________________________________________________________________________________________________________	

// List Rope Material starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function ropematerial()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'rope_material', 'page' => 'rope_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$ropematerial		= 	$this->Master_model->get_ropematerial();
		$data['ropematerial']	=	$ropematerial;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/rope_material',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');                      
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Rope Material end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Rope Material starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_ropematerial()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'rope_material', 'page' => 'rope_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('ropematerial_name', 'Rope Material Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('ropematerial_code', 'Rope Material Code', 'required|callback_minalpha_check');

		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$ropematerial_ins 			= 	$this->input->post('ropematerial_ins');
			$ropematerial_name			= 	$this->input->post('ropematerial_name');
			$ropematerial_mal_name 			= 	$this->input->post('ropematerial_mal_name');
			$ropematerial_code 			= 	$this->input->post('ropematerial_code');
			$chkduplication				=	$this->Master_model->check_duplication_ropematerial_insert($ropematerial_name,$ropematerial_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($ropematerial_ins=="Save Rope Material")
				{
					$data 			= 	array(
					'ropematerial_name' 		=>	$ropematerial_name,  
					'ropematerial_mal_name' 	=> 	$ropematerial_mal_name,
					'ropematerial_code' 		=> 	$ropematerial_code,
					'ropematerial_status'		=>	'1',
					'ropematerial_created_user_id'	=> 	$sess_usr_id,
					'ropematerial_created_timestamp'=>	$date,
					'ropematerial_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_ropematerial_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Rope Material successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Rope Material Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Rope Material ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Rope Material starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_ropematerial()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'rope_material', 'page' => 'rope_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('ropematerial_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_ropematerial_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status ropematerial ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete ropematerial  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_ropematerial()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'rope_material', 'page' => 'rope_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_ropematerial($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Rope Material  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_ropematerial()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'rope_material', 'page' => 'rope_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_ropematerial', 'Rope Material Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_ropematerial_code', 'Rope Material Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_ropematerial 	= 	$this->input->post('edit_ropematerial');
			$edit_ropematerial_mal 	= 	$this->input->post('edit_ropematerial_mal');
			$edit_ropematerial_code	= 	$this->input->post('edit_ropematerial_code');
			$edit_ropematerial	= 	$this->security->xss_clean($edit_ropematerial);
			/*Edited on 14-06-2018  Start*/	//$chkduplication	=	$this->Master_model->check_duplication_ropematerial($edit_ropematerial);
			$chkduplication	=$this->Master_model->check_duplication_ropematerial_edit($edit_ropematerial,$edit_ropematerial_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'ropematerial_name' 		 =>	$edit_ropematerial,  
				'ropematerial_mal_name' 	 => 	$edit_ropematerial_mal,
				'ropematerial_code' 		 => 	$edit_ropematerial_code,
				'ropematerial_modified_user_id'	 =>	$sess_usr_id,
				'ropematerial_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_ropematerial($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Rope Material Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Rope Material Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Rope Material ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                NOZZLE TYPE

//____________________________________________________________________________________________________________________________________________	

// List Nozzle Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function nozzletype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'nozzle_type', 'page' => 'nozzle_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$nozzletype		= 	$this->Master_model->get_nozzletype();
		$data['nozzletype']	=	$nozzletype;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/nozzle_type.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');               
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Nozzle Type end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Nozzle Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_nozzletype()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'nozzle_type', 'page' => 'nozzle_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		//set validation rules
		$this->form_validation->set_rules('nozzletype_name', 'Nozzle Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('nozzletype_code', 'Nozzle Type Code', 'required|callback_minalpha_check');

		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$nozzletype_ins 			= 	$this->input->post('nozzletype_ins');
			$nozzletype_name			= 	$this->input->post('nozzletype_name');
			$nozzletype_mal_name 			= 	$this->input->post('nozzletype_mal_name');
			$nozzletype_code 			= 	$this->input->post('nozzletype_code');
			$chkduplication				=	$this->Master_model->check_duplication_nozzletype_insert($nozzletype_name,$nozzletype_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($nozzletype_ins=="Save Nozzle Type")
				{
					$data 			= 	array(
					'nozzletype_name' 		=>	$nozzletype_name,  
					'nozzletype_mal_name' 		=> 	$nozzletype_mal_name,
					'nozzletype_code' 		=> 	$nozzletype_code,
					'nozzletype_status'		=>	'1',
					'nozzletype_created_user_id'	=> 	$sess_usr_id,
					'nozzletype_created_timestamp'	=>	$date,
					'nozzletype_created_ipaddress'	=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_nozzletype_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Nozzle Type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Nozzle Type Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Nozzle Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Nozzle Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function status_nozzletype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'nozzle_type', 'page' => 'nozzle_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data =	array('nozzletype_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_nozzletype_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		

	
//Status nozzletype ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete nozzletype  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_nozzletype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'nozzle_type', 'page' => 'nozzle_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_nozzletype($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Nozzle Type  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_nozzletype()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'nozzle_type', 'page' => 'nozzle_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_nozzletype', 'Nozzle Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_nozzletype_code', 'Nozzle Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_nozzletype 	= 	$this->input->post('edit_nozzletype');
			$edit_nozzletype_mal 	= 	$this->input->post('edit_nozzletype_mal');
			$edit_nozzletype_code	= 	$this->input->post('edit_nozzletype_code');
			$edit_nozzletype	= 	$this->security->xss_clean($edit_nozzletype);


			/*Edited on 14-06-2018  Start*/	//$chkduplication	=	$this->Master_model->check_duplication_nozzletype($edit_nozzletype);
			$chkduplication	=$this->Master_model->check_duplication_nozzletype_edit($edit_nozzletype,$edit_nozzletype_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'nozzletype_name' 		 =>	$edit_nozzletype,  
				'nozzletype_mal_name' 	 	 => 	$edit_nozzletype_mal,
				'nozzletype_code' 		 => 	$edit_nozzletype_code,
				'nozzletype_modified_user_id'	 =>	$sess_usr_id,
				'nozzletype_modified_ipaddress'	 =>	$ip	);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_nozzletype($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Nozzle Type Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Nozzle Type Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Nozzle Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                FIRE EXTINGUISHER TYPE

//____________________________________________________________________________________________________________________________________________	

// List Fire Extinguisher Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function fireextinguisher_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireextinguisher_type', 'page' => 'fireextinguisher_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$fireextinguisher_type		= 	$this->Master_model->get_fireextinguisher_type();
		$data['fireextinguisher_type']	=	$fireextinguisher_type;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/fireextinguisher_type',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');              
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Fire Extinguisher Type end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Fire Extinguisher Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_fireextinguisher_type()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireextinguisher_type', 'page' => 'fireextinguisher_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('fireextinguisher_type_name', 'Fire Extinguisher Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('fireextinguisher_type_code', 'Fire Extinguisher Type Code', 'required|callback_minalpha_check');

		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$fireextinguisher_type_ins 			= 	$this->input->post('fireextinguisher_type_ins');
			$fireextinguisher_type_name			= 	$this->input->post('fireextinguisher_type_name');
			$fireextinguisher_type_mal_name 		= 	$this->input->post('fireextinguisher_type_mal_name');
			$fireextinguisher_type_code 			= 	$this->input->post('fireextinguisher_type_code');
			$chkduplication	=$this->Master_model->check_duplication_fireextinguisher_type_insert($fireextinguisher_type_name,$fireextinguisher_type_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($fireextinguisher_type_ins=="Save Fire Extinguisher Type")
				{
					$data 			= 	array(
					'fireextinguisher_type_name' 		=>	$fireextinguisher_type_name,  
					'fireextinguisher_type_mal_name' 	=> 	$fireextinguisher_type_mal_name,
					'fireextinguisher_type_code' 		=> 	$fireextinguisher_type_code,
					'fireextinguisher_type_status'		=>	'1',
					'fireextinguisher_type_created_user_id'	=> 	$sess_usr_id,
					'fireextinguisher_type_created_timestamp'=>	$date,
					'fireextinguisher_type_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_fireextinguisher_type_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Fire Extinguisher Type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Fire Extinguisher Type Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Fire Extinguisher Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Fire Extinguisher Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_fireextinguisher_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireextinguisher_type', 'page' => 'fireextinguisher_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('fireextinguisher_type_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_fireextinguisher_type_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		


//Status fireextinguisher_type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete fireextinguisher_type  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_fireextinguisher_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'fireextinguisher_type', 'page' => 'fireextinguisher_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_fireextinguisher_type($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Fire Extinguisher Type  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_fireextinguisher_type()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireextinguisher_type', 'page' => 'fireextinguisher_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_fireextinguisher_type', 'Fire Extinguisher Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_fireextinguisher_type_code', 'Fire Extinguisher Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_fireextinguisher_type 	= 	$this->input->post('edit_fireextinguisher_type');
			$edit_fireextinguisher_type_mal 	= 	$this->input->post('edit_fireextinguisher_type_mal');
			$edit_fireextinguisher_type_code	= 	$this->input->post('edit_fireextinguisher_type_code');
			$edit_fireextinguisher_type	= 	$this->security->xss_clean($edit_fireextinguisher_type);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_fireextinguisher_type($edit_fireextinguisher_type);
			$chkduplication	=$this->Master_model->check_duplication_fireextinguisher_type_edit($edit_fireextinguisher_type,$edit_fireextinguisher_type_code,$id);
			/*End*/				
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'fireextinguisher_type_name' 		 =>	$edit_fireextinguisher_type,  
				'fireextinguisher_type_mal_name' 	 => 	$edit_fireextinguisher_type_mal,
				'fireextinguisher_type_code' 		 => 	$edit_fireextinguisher_type_code,
				'fireextinguisher_type_modified_user_id'	 =>	$sess_usr_id,
				'fireextinguisher_type_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_fireextinguisher_type($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Fire Extinguisher Type Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Fire Extinguisher Type Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Fire Extinguisher Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                COMMUNICATION EQUIPMENT

//____________________________________________________________________________________________________________________________________________	

// List Communication Equipment Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function commnequipment()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'commnequipment', 'page' => 'commnequipment', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$commnequipment		= 	$this->Master_model->get_commnequipment();
		$data['commnequipment']	=	$commnequipment;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;

		$this->load->model('Kiv_models/Master_model');

		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/commnequipment',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');      
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Communication Equipment Type end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Communication Equipment Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_commnequipment()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'commnequipment', 'page' => 'commnequipment', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		//set validation rules
		$this->form_validation->set_rules('commnequipment_name', 'Communication Equipment Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('commnequipment_code', 'Communication Equipment Type Code', 'required|callback_minalpha_check');

		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$commnequipment_ins 			= 	$this->input->post('commnequipment_ins');
			$commnequipment_name			= 	$this->input->post('commnequipment_name');
			$commnequipment_mal_name 		= 	$this->input->post('commnequipment_mal_name');
			$commnequipment_code 			= 	$this->input->post('commnequipment_code');
			$chkduplication				=	$this->Master_model->check_duplication_commnequipment_insert($commnequipment_name,$commnequipment_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($commnequipment_ins=="Save Communication Equipment")
				{
					$data 			= 	array(
					'commnequipment_name' 		=>	$commnequipment_name,  
					'commnequipment_mal_name' 	=> 	$commnequipment_mal_name,
					'commnequipment_code' 		=> 	$commnequipment_code,
					'commnequipment_status'		=>	'1',
					'commnequipment_created_user_id'	=> 	$sess_usr_id,
					'commnequipment_created_timestamp'=>	$date,
					'commnequipment_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_commnequipment_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Communication Equipment Type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Communication Equipment Type Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Communication Equipment Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Communication Equipment Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_commnequipment()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'commnequipment', 'page' => 'commnequipment', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('commnequipment_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_commnequipment_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status commnequipment ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete commnequipment  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_commnequipment()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'commnequipment', 'page' => 'commnequipment', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
	
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_commnequipment($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
   	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Communication Equipment Type  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_commnequipment()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'commnequipment', 'page' => 'commnequipment', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_commnequipment', 'Communication Equipment Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_commnequipment_code', 'Communication Equipment Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_commnequipment 	= 	$this->input->post('edit_commnequipment');
			$edit_commnequipment_mal 	= 	$this->input->post('edit_commnequipment_mal');
			$edit_commnequipment_code	= 	$this->input->post('edit_commnequipment_code');
			$edit_commnequipment	= 	$this->security->xss_clean($edit_commnequipment);

			/*Edited on 14-06-2018  Start*/	
			//$chkduplication=$this->Master_model->check_duplication_commnequipment($edit_commnequipment);
			$chkduplication	=$this->Master_model->check_duplication_commnequipment_edit($edit_commnequipment,$edit_commnequipment_code,$id);
			/*End*/				
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'commnequipment_name' 		 =>	$edit_commnequipment,  
				'commnequipment_mal_name' 	 => 	$edit_commnequipment_mal,
				'commnequipment_code' 		 => 	$edit_commnequipment_code,
				'commnequipment_modified_user_id'	 =>	$sess_usr_id,
				'commnequipment_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_commnequipment($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Communication Equipment Type Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Communication Equipment Type Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Communication Equipment Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                NAVIGATION EQUIPMENT

//____________________________________________________________________________________________________________________________________________	

// List Navigation Equipment Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function navgnequipments()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'navgnequipments', 'page' => 'navgnequipments', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$navgnequipments		= 	$this->Master_model->get_navgnequipments();
		$data['navgnequipments']	=	$navgnequipments;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/navgnequipments',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');         
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Navigation Equipment Type end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Navigation Equipment Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_navgnequipments()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'navgnequipments', 'page' => 'navgnequipments', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		//set validation rules
		$this->form_validation->set_rules('navgnequipments_name', 'Navigation Equipment Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('navgnequipments_code', 'Navigation Equipment Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$navgnequipments_ins 			= 	$this->input->post('navgnequipments_ins');
			$navgnequipments_name			= 	$this->input->post('navgnequipments_name');
			$navgnequipments_mal_name 		= 	$this->input->post('navgnequipments_mal_name');
			$navgnequipments_code 			= 	$this->input->post('navgnequipments_code');
			$chkduplication				=	$this->Master_model->check_duplication_navgnequipments_insert($navgnequipments_name,$navgnequipments_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($navgnequipments_ins=="Save Navigation Equipment")
				{
					$data 			= 	array(
					'navgnequipments_name' 		=>	$navgnequipments_name,  
					'navgnequipments_mal_name' 	=> 	$navgnequipments_mal_name,
					'navgnequipments_code' 		=> 	$navgnequipments_code,
					'navgnequipments_status'		=>	'1',
					'navgnequipments_created_user_id'	=> 	$sess_usr_id,
					'navgnequipments_created_timestamp'=>	$date,
					'navgnequipments_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_navgnequipments_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Navigation Equipment Type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Navigation Equipment Type Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Navigation Equipment Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Navigation Equipment Type starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_navgnequipments()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'navgnequipments', 'page' => 'navgnequipments', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('navgnequipments_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_navgnequipments_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status navgnequipments ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete navgnequipments  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_navgnequipments()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'navgnequipments', 'page' => 'navgnequipments', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_navgnequipments($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Navigation Equipment Type  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_navgnequipments()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'navgnequipments', 'page' => 'navgnequipments', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_navgnequipments', 'Navigation Equipment Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_navgnequipments_code', 'Navigation Equipment Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_navgnequipments 	= 	$this->input->post('edit_navgnequipments');
			$edit_navgnequipments_mal 	= 	$this->input->post('edit_navgnequipments_mal');
			$edit_navgnequipments_code	= 	$this->input->post('edit_navgnequipments_code');
			$edit_navgnequipments	= 	$this->security->xss_clean($edit_navgnequipments);
			/*Edited on 14-06-2018  Start*/
			//$chkduplication		=	$this->Master_model->check_duplication_navgnequipments($edit_navgnequipments);
			$chkduplication	=$this->Master_model->check_duplication_navgnequipments_edit($edit_navgnequipments,$edit_navgnequipments_code,$id);
			/*End*/				
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'navgnequipments_name' 		 =>	$edit_navgnequipments,  
				'navgnequipments_mal_name' 	 => 	$edit_navgnequipments_mal,
				'navgnequipments_code' 		 => 	$edit_navgnequipments_code,
				'navgnequipments_modified_user_id'	 =>	$sess_usr_id,
				'navgnequipments_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_navgnequipments($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Navigation Equipment Type Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Navigation Equipment Type Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Navigation Equipment Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                SOURCE OF WATER

//____________________________________________________________________________________________________________________________________________	

// List Source of water starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function sourceofwater()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'sourceofwater', 'page' => 'sourceofwater', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$sourceofwater		= 	$this->Master_model->get_sourceofwater();
		$data['sourceofwater']	=	$sourceofwater;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;

		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/sourceofwater',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');   
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Source Of water end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Source Of water starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_sourceofwater()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'sourceofwater', 'page' => 'sourceofwater', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('sourceofwater_name', 'Source Of water Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('sourceofwater_code', 'Source Of water Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$sourceofwater_ins 			= 	$this->input->post('sourceofwater_ins');
			$sourceofwater_name			= 	$this->input->post('sourceofwater_name');
			$sourceofwater_mal_name 		= 	$this->input->post('sourceofwater_mal_name');
			$sourceofwater_code 			= 	$this->input->post('sourceofwater_code');
			$chkduplication				=	$this->Master_model->check_duplication_sourceofwater_insert($sourceofwater_name,$sourceofwater_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($sourceofwater_ins=="Save Source Of water")
				{
					$data 			= 	array(
					'sourceofwater_name' 		=>	$sourceofwater_name,  
					'sourceofwater_mal_name' 	=> 	$sourceofwater_mal_name,
					'sourceofwater_code' 		=> 	$sourceofwater_code,
					'sourceofwater_status'		=>	'1',
					'sourceofwater_created_user_id'	=> 	$sess_usr_id,
					'sourceofwater_created_timestamp'=>	$date,
					'sourceofwater_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_sourceofwater_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Source Of water successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Source Of water Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Source Of water ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Source Of water starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_sourceofwater()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'sourceofwater', 'page' => 'sourceofwater', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data =	array('sourceofwater_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_sourceofwater_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status sourceofwater ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete sourceofwater  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_sourceofwater()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'sourceofwater', 'page' => 'sourceofwater', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_sourceofwater($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Source Of water  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_sourceofwater()
{		
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'sourceofwater', 'page' => 'sourceofwater', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_sourceofwater', 'Source Of water Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_sourceofwater_code', 'Source Of water Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_sourceofwater 	= 	$this->input->post('edit_sourceofwater');
			$edit_sourceofwater_mal 	= 	$this->input->post('edit_sourceofwater_mal');
			$edit_sourceofwater_code	= 	$this->input->post('edit_sourceofwater_code');

			$edit_sourceofwater	= 	$this->security->xss_clean($edit_sourceofwater);

			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_sourceofwater($edit_sourceofwater);
			$chkduplication	=$this->Master_model->check_duplication_sourceofwater_edit($edit_sourceofwater,$edit_sourceofwater_code,$id);
			/*End*/	

			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'sourceofwater_name' 		 =>	$edit_sourceofwater,  
				'sourceofwater_mal_name' 	 => 	$edit_sourceofwater_mal,
				'sourceofwater_code' 		 => 	$edit_sourceofwater_code,
				'sourceofwater_modified_user_id'	 =>	$sess_usr_id,
				'sourceofwater_modified_ipaddress'=>	$ip	);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_sourceofwater($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Source Of water Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Source Of water Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Source Of water ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                MEANS OF PROPULSION

//____________________________________________________________________________________________________________________________________________	

// List Means of Propulsion starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function meansofpropulsion()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'meansofpropulsion', 'page' => 'meansofpropulsion', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$meansofpropulsion		= 	$this->Master_model->get_meansofpropulsion();
		$data['meansofpropulsion']	=	$meansofpropulsion;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/meansofpropulsion',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');     
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Means of Propulsion end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Means of Propulsion starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_meansofpropulsion()
{		
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'meansofpropulsion', 'page' => 'meansofpropulsion', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		//set validation rules
		$this->form_validation->set_rules('meansofpropulsion_name', 'Means of Propulsion Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('meansofpropulsion_code', 'Means of Propulsion Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$meansofpropulsion_ins 			= 	$this->input->post('meansofpropulsion_ins');
			$meansofpropulsion_name			= 	$this->input->post('meansofpropulsion_name');
			$meansofpropulsion_mal_name 		= 	$this->input->post('meansofpropulsion_mal_name');
			$meansofpropulsion_code 		= 	$this->input->post('meansofpropulsion_code');
			$chkduplication	=$this->Master_model->check_duplication_meansofpropulsion_insert($meansofpropulsion_name,$meansofpropulsion_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($meansofpropulsion_ins=="Save Means of Propulsion")
				{
					$data 			= 	array(
					'meansofpropulsion_name' 		=>	$meansofpropulsion_name,  
					'meansofpropulsion_mal_name' 	=> 	$meansofpropulsion_mal_name,
					'meansofpropulsion_code' 		=> 	$meansofpropulsion_code,
					'meansofpropulsion_status'		=>	'1',
					'meansofpropulsion_created_user_id'	=> 	$sess_usr_id,
					'meansofpropulsion_created_timestamp'=>	$date,
					'meansofpropulsion_created_ipaddress'=>	$ip	);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_meansofpropulsion_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Means of Propulsion successfully Added!!!</div>');
					}
				}
			} 
			else
			{
				echo json_encode(array("val_errors" => "Means of Propulsion Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Means of Propulsion ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Means of Propulsion starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_meansofpropulsion()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'meansofpropulsion', 'page' => 'meansofpropulsion', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('meansofpropulsion_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_meansofpropulsion_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status meansofpropulsion ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete meansofpropulsion  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_meansofpropulsion()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'meansofpropulsion', 'page' => 'meansofpropulsion', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_meansofpropulsion($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Means of Propulsion  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_meansofpropulsion()
{
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'meansofpropulsion', 'page' => 'meansofpropulsion', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_meansofpropulsion', 'Means of Propulsion Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_meansofpropulsion_code', 'Means of Propulsion Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		}
		else
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_meansofpropulsion 	= 	$this->input->post('edit_meansofpropulsion');
			$edit_meansofpropulsion_mal 	= 	$this->input->post('edit_meansofpropulsion_mal');
			$edit_meansofpropulsion_code	= 	$this->input->post('edit_meansofpropulsion_code');
			$edit_meansofpropulsion	= 	$this->security->xss_clean($edit_meansofpropulsion);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication=$this->Master_model->check_duplication_meansofpropulsion($edit_meansofpropulsion);
			$chkduplication	=$this->Master_model->check_duplication_meansofpropulsion_edit($edit_meansofpropulsion,$edit_meansofpropulsion_code,$id);
			/*End*/				$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'meansofpropulsion_name' 		 =>	$edit_meansofpropulsion,  
				'meansofpropulsion_mal_name' 		 => 	$edit_meansofpropulsion_mal,
				'meansofpropulsion_code' 		 => 	$edit_meansofpropulsion_code,
				'meansofpropulsion_modified_user_id'	 =>	$sess_usr_id,
				'meansofpropulsion_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_meansofpropulsion($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Means of Propulsion Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Means of Propulsion Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Means of Propulsion ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                Model Number

//____________________________________________________________________________________________________________________________________________	

// List Model Number starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function modelnumber()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'modelnumber', 'page' => 'modelnumber', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$modelnumber		= 	$this->Master_model->get_modelnumber();
		$data['modelnumber']	=	$modelnumber;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/modelnumber',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');        
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Model Number end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Model Number starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_modelnumber()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'modelnumber', 'page' => 'modelnumber', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('modelnumber_name', 'Model Number Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('modelnumber_code', 'Model Number Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$modelnumber_ins 			= 	$this->input->post('modelnumber_ins');
			$modelnumber_name			= 	$this->input->post('modelnumber_name');
			$modelnumber_mal_name 			= 	$this->input->post('modelnumber_mal_name');
			$modelnumber_code 			= 	$this->input->post('modelnumber_code');
			$chkduplication=$this->Master_model->check_duplication_modelnumber_insert($modelnumber_name,$modelnumber_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($modelnumber_ins=="Save Model Number")
				{
					$data 			= 	array(
					'modelnumber_name' 		=>	$modelnumber_name,  
					'modelnumber_mal_name' 		=> 	$modelnumber_mal_name,
					'modelnumber_code' 		=> 	$modelnumber_code,
					'modelnumber_status'		=>	'1',
					'modelnumber_created_user_id'	=> 	$sess_usr_id,
					'modelnumber_created_timestamp'=>	$date,
					'modelnumber_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_modelnumber_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Model Number successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Model Number Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Model Number ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Model Number starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_modelnumber()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'modelnumber', 'page' => 'modelnumber', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data =	array('modelnumber_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_modelnumber_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status modelnumber ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete modelnumber  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_modelnumber()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'modelnumber', 'page' => 'modelnumber', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_modelnumber($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Model Number  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_modelnumber()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'modelnumber', 'page' => 'modelnumber', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_modelnumber', 'Model Number Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_modelnumber_code', 'Model Number Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_modelnumber 	= 	$this->input->post('edit_modelnumber');
			$edit_modelnumber_mal 	= 	$this->input->post('edit_modelnumber_mal');
			$edit_modelnumber_code	= 	$this->input->post('edit_modelnumber_code');
			$edit_modelnumber	= 	$this->security->xss_clean($edit_modelnumber);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_modelnumber($edit_modelnumber);
			$chkduplication	=$this->Master_model->check_duplication_modelnumber_edit($edit_modelnumber,$edit_modelnumber_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'modelnumber_name' 		 =>	$edit_modelnumber,  
				'modelnumber_mal_name' 	 	 => 	$edit_modelnumber_mal,
				'modelnumber_code' 		 => 	$edit_modelnumber_code,
				'modelnumber_modified_user_id'	 =>	$sess_usr_id,
				'modelnumber_modified_ipaddress' =>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_modelnumber($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Model Number Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Model Number Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Model Number ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//*____________________________________________________________________________________________________________________________________________*/	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                      Electrical Generator

//____________________________________________________________________________________________________________________________________________	

// List Electrical Generator starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function electricalgenerator()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'electricalgenerator', 'page' => 'electricalgenerator', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$electricalgenerator		= 	$this->Master_model->get_electricalgenerator();
		$data['electricalgenerator']	=	$electricalgenerator;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;

		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/electricalgenerator',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');        
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Electrical Generator end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Electrical Generator starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_electricalgenerator()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
	$data =	array('title' => 'electricalgenerator', 'page' => 'electricalgenerator', 'errorCls' => NULL, 'post' => $this->input->post());
	$data = $data + $this->data;
	//set validation rules
	$this->form_validation->set_rules('electricalgenerator_name', 'Electrical Generator Name', 'required|callback_alphaonly_check');
	$this->form_validation->set_rules('electricalgenerator_code', 'Electrical Generator Code', 'required|callback_minalpha_check');
	if ($this->form_validation->run() == FALSE)
	{
		//fail validation
		$valErrors				= 	validation_errors();
		echo json_encode(array("val_errors" => $valErrors));
		exit;
	} 
	else 
	{ 
		$electricalgenerator_ins 			= 	$this->input->post('electricalgenerator_ins');
		$electricalgenerator_name			= 	$this->input->post('electricalgenerator_name');
		$electricalgenerator_mal_name 			= 	$this->input->post('electricalgenerator_mal_name');
		$electricalgenerator_code 			= 	$this->input->post('electricalgenerator_code');
		$chkduplication=$this->Master_model->check_duplication_electricalgenerator_insert($electricalgenerator_name,$electricalgenerator_code); 
		$cntrows				=	count($chkduplication);
		if($cntrows==0)
		{
			if($electricalgenerator_ins=="Save Electrical Generator")
			{
				$data 			= 	array(
				'electricalgenerator_name' 		=>	$electricalgenerator_name,  
				'electricalgenerator_mal_name' 	=> 	$electricalgenerator_mal_name,
				'electricalgenerator_code' 		=> 	$electricalgenerator_code,
				'electricalgenerator_status'		=>	'1',
				'electricalgenerator_created_user_id'	=> 	$sess_usr_id,
				'electricalgenerator_created_timestamp'=>	$date,
				'electricalgenerator_created_ipaddress'=>	$ip);
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$usr_res	=	$this->db->insert('kiv_electricalgenerator_master', $data);
				if($usr_res)
				{
					echo json_encode(array("val_errors" => ""));
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Electrical Generator successfully Added!!!</div>');
				}
			}
		} 
		else 
		{
			echo json_encode(array("val_errors" => "Electrical Generator Already Exists!!!"));
		}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Electrical Generator ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Electrical Generator starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_electricalgenerator()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'electricalgenerator', 'page' => 'electricalgenerator', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('electricalgenerator_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_electricalgenerator_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		

	
//Status electricalgenerator ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete electricalgenerator  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_electricalgenerator()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'electricalgenerator', 'page' => 'electricalgenerator', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_electricalgenerator($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Electrical Generator  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_electricalgenerator()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'electricalgenerator', 'page' => 'electricalgenerator', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_electricalgenerator', 'Electrical Generator Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_electricalgenerator_code', 'Electrical Generator Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_electricalgenerator 	= 	$this->input->post('edit_electricalgenerator');
			$edit_electricalgenerator_mal 	= 	$this->input->post('edit_electricalgenerator_mal');
			$edit_electricalgenerator_code	= 	$this->input->post('edit_electricalgenerator_code');
			$edit_electricalgenerator	= 	$this->security->xss_clean($edit_electricalgenerator);

			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_electricalgenerator($edit_electricalgenerator);
			$chkduplication	=$this->Master_model->check_duplication_electricalgenerator_edit($edit_electricalgenerator,$edit_electricalgenerator_code,$id);
			/*End*/	

			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'electricalgenerator_name' 		 =>	$edit_electricalgenerator,  
				'electricalgenerator_mal_name' 	 => 	$edit_electricalgenerator_mal,
				'electricalgenerator_code' 		 => 	$edit_electricalgenerator_code,
				'electricalgenerator_modified_user_id'	 =>	$sess_usr_id,
				'electricalgenerator_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_electricalgenerator($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Electrical Generator Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Electrical Generator Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Electrical Generator ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                LOCATION OF ELECTRICAL GENERATOR

//____________________________________________________________________________________________________________________________________________	

// List Location of Electrical Generator starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function locationof_electricalgenerator()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'locationof_electricalgenerator', 'page' => 'locationof_electricalgenerator', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$locationof_electricalgenerator		= 	$this->Master_model->get_locationof_electricalgenerator();
		$data['locationof_electricalgenerator']	=	$locationof_electricalgenerator;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/locationof_electricalgenerator',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');        
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Location of Electrical Generator end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Location of Electrical Generator starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_locationof_electricalgenerator()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'locationof_electricalgenerator', 'page' => 'locationof_electricalgenerator', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		//set validation rules
		$this->form_validation->set_rules('locationof_electricalgenerator_name', 'Locationof  Electrical Generator ', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('locationof_electricalgenerator_code', 'Location of Electrical Generator Code', 'required|callback_minalpha_check');

		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$locationof_electricalgenerator_ins 			= 	$this->input->post('locationof_electricalgenerator_ins');
			$locationof_electricalgenerator_name			= 	$this->input->post('locationof_electricalgenerator_name');
			$locationof_electricalgenerator_mal_name 		= 	$this->input->post('locationof_electricalgenerator_mal_name');
			$locationof_electricalgenerator_code 			= 	$this->input->post('locationof_electricalgenerator_code');
			$chkduplication=$this->Master_model->check_duplication_locationof_electricalgenerator_insert($locationof_electricalgenerator_name,$locationof_electricalgenerator_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($locationof_electricalgenerator_ins=="Save Location of electrical generator")
				{
					$data 			= 	array('locationof_electricalgenerator_name' =>	$locationof_electricalgenerator_name,  
					'locationof_electricalgenerator_mal_name' 	=> 	$locationof_electricalgenerator_mal_name,
					'locationof_electricalgenerator_code' 		=> 	$locationof_electricalgenerator_code,
					'locationof_electricalgenerator_status'		=>	'1',
					'locationof_electricalgenerator_created_user_id'  => 	$sess_usr_id,
					'locationof_electricalgenerator_created_timestamp'=>	$date,
					'locationof_electricalgenerator_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_locationof_electricalgenerator_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Electrical Generator successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Electrical Generator Already Exists!!!"));
			}	
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Location of Electrical Generator ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Location of Electrical Generator starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_locationof_electricalgenerator()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'locationof_electricalgenerator', 'page' => 'locationof_electricalgenerator', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('locationof_electricalgenerator_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_locationof_electricalgenerator_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status locationof_electricalgenerator ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete locationof_electricalgenerator  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_locationof_electricalgenerator()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'locationof_electricalgenerator', 'page' => 'locationof_electricalgenerator', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_locationof_electricalgenerator($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Location of Electrical Generator  starting...  (08-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_locationof_electricalgenerator()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'locationof_electricalgenerator', 'page' => 'locationof_electricalgenerator', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_locationof_electricalgenerator', 'Electrical Generator Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_locationof_electricalgenerator_code', 'Electrical Generator Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_locationof_electricalgenerator 	= 	$this->input->post('edit_locationof_electricalgenerator');
			$edit_locationof_electricalgenerator_mal 	= 	$this->input->post('edit_locationof_electricalgenerator_mal');
			$edit_locationof_electricalgenerator_code	= 	$this->input->post('edit_locationof_electricalgenerator_code');

			$edit_locationof_electricalgenerator	= 	$this->security->xss_clean($edit_locationof_electricalgenerator);

			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_locationof_electricalgenerator($edit_locationof_electricalgenerator);

			$chkduplication	= $this->Master_model->check_duplication_locationof_electricalgenerator_edit($edit_locationof_electricalgenerator,$edit_locationof_electricalgenerator_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array('locationof_electricalgenerator_name' =>	$edit_locationof_electricalgenerator,  
				'locationof_electricalgenerator_mal_name' 	 => 	$edit_locationof_electricalgenerator_mal,
				'locationof_electricalgenerator_code' 	 => 	$edit_locationof_electricalgenerator_code,
				'locationof_electricalgenerator_modified_user_id'	 =>	$sess_usr_id,
				'locationof_electricalgenerator_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_locationof_electricalgenerator($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Electrical Generator Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Electrical Generator Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Location of Electrical Generator ends.	
/*____________________________________________________________________________________________________________________________________________*/	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                                FUEL USED

//____________________________________________________________________________________________________________________________________________	

// List Fuel starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function fuel()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fuel', 'page' => 'fuel', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$fuel		= 	$this->Master_model->get_fuel();
		$data['fuel']	=	$fuel;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/fuel',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List fuel end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Fuel starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_fuel()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fuel', 'page' => 'fuel', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('fuel_name', 'FuelType Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('fuel_code', 'FuelType Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$fuel_ins 			= 	$this->input->post('fuel_ins');
			$fuel_name			= 	$this->input->post('fuel_name');
			$fuel_mal_name 			= 	$this->input->post('fuel_mal_name');
			$fuel_code 			= 	$this->input->post('fuel_code');
			$chkduplication=$this->Master_model->check_duplication_fuel($fuel_name,$fuel_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($fuel_ins=="Save Fuel")
				{
					$data 			= 	array(
					'fuel_name' 		=>	$fuel_name,  
					'fuel_mal_name' 	=> 	$fuel_mal_name,
					'fuel_code' 		=> 	$fuel_code,
					'fuel_status'		=>	'1',
					'fuel_created_user_id'	=> 	$sess_usr_id,
					'fuel_created_timestamp'=>	$date,
					'fuel_created_ipaddress'=>	$ip						);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_fuel_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Fuel successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Fuel Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Fuel ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Fuel starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_fuel()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fuel', 'page' => 'fuel', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('fuel_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_fuel_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status fuel ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete fuel  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_fuel()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'fuel', 'page' => 'fuel', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_fuel($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Fuel  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_fuel()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data=array('title' => 'fuel', 'page' => 'fuel', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_fuel', 'Fuel Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_fuel_code', 'Fuel Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_fuel 	= 	$this->input->post('edit_fuel');
			$edit_fuel_mal 	= 	$this->input->post('edit_fuel_mal');
			$edit_fuel_code	= 	$this->input->post('edit_fuel_code');
			$edit_fuel	= 	$this->security->xss_clean($edit_fuel);
			/*Edited on 14-06-2018  Start*/	//$chkduplication	=	$this->Master_model->check_duplication_fuel($edit_fuel);
			$chkduplication=$this->Master_model->check_duplication_fuel_edit($edit_fuel,$edit_fuel_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'fuel_name' 		 =>	$edit_fuel,  
				'fuel_mal_name' 	 => 	$edit_fuel_mal,
				'fuel_code' 		 => 	$edit_fuel_code,
				'fuel_modified_user_id'	 =>	$sess_usr_id,
				'fuel_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_fuel($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Fuel Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Fuel Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Fuel ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Area of operation (Place of Survey)

//____________________________________________________________________________________________________________________________________________	

// List place of survey starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function placeofsurvey()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'placeofsurvey', 'page' => 'placeofsurvey', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$placeofsurvey		= 	$this->Master_model->get_placeofsurvey();
		$data['placeofsurvey']	=	$placeofsurvey;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/placeofsurvey',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List place of survey end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add place of survey starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_placeofsurvey()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'placeofsurvey', 'page' => 'placeofsurvey', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('placeofsurvey_name', 'Place of survey Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('placeofsurvey_code', 'place of survey Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$placeofsurvey_ins 			= 	$this->input->post('placeofsurvey_ins');
			$placeofsurvey_name			= 	$this->input->post('placeofsurvey_name');
			$placeofsurvey_mal_name 		= 	$this->input->post('placeofsurvey_mal_name');
			$placeofsurvey_code 			= 	$this->input->post('placeofsurvey_code');
			$chkduplication				=	$this->Master_model->check_duplication_placeofsurvey_insert($placeofsurvey_name,$placeofsurvey_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($placeofsurvey_ins=="Save Place of survey")
				{
					$data 			= 	array(
					'placeofsurvey_name' 		=>	$placeofsurvey_name,  
					'placeofsurvey_mal_name' 	=> 	$placeofsurvey_mal_name,
					'placeofsurvey_code' 		=> 	$placeofsurvey_code,
					'placeofsurvey_status'		=>	'1',
					'placeofsurvey_created_user_id'	=> 	$sess_usr_id,
					'placeofsurvey_created_timestamp'=>	$date,
					'placeofsurvey_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_placeofsurvey_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">placeofsurvey successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "placeofsurvey Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add placeofsurvey ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status place of survey starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_placeofsurvey()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'placeofsurvey', 'page' => 'placeofsurvey', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data =	array('placeofsurvey_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_placeofsurvey_status($data,$id);
		if($updstatus_res){
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status place of survey ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete place of survey  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_placeofsurvey()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'placeofsurvey', 'page' => 'placeofsurvey', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_placeofsurvey($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit place of survey  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_placeofsurvey()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'placeofsurvey', 'page' => 'placeofsurvey', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_placeofsurvey', 'Place of survey Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_placeofsurvey_code', 'Place of survey Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_placeofsurvey 	= 	$this->input->post('edit_placeofsurvey');
			$edit_placeofsurvey_mal 	= 	$this->input->post('edit_placeofsurvey_mal');
			$edit_placeofsurvey_code	= 	$this->input->post('edit_placeofsurvey_code');

			$edit_placeofsurvey	= 	$this->security->xss_clean($edit_placeofsurvey);

			/*Edited on 14-06-2018  Start*/	//$chkduplication	=	$this->Master_model->check_duplication_placeofsurvey($edit_placeofsurvey);
			$chkduplication	=$this->Master_model->check_duplication_placeofsurvey_edit($edit_placeofsurvey,$edit_placeofsurvey_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'placeofsurvey_name' 		 =>	$edit_placeofsurvey,  
				'placeofsurvey_mal_name' 	 => 	$edit_placeofsurvey_mal,
				'placeofsurvey_code' 		 => 	$edit_placeofsurvey_code,
				'placeofsurvey_modified_user_id'	 =>	$sess_usr_id,
				'placeofsurvey_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_placeofsurvey($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">placeofsurvey Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Place of survey Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit place of survey ends.	
/*____________________________________________________________________________________________________________________________________________*/	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Nature of Operation

//____________________________________________________________________________________________________________________________________________	

// List Nature of Operation starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function natureofoperation()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'natureofoperation', 'page' => 'natureofoperation', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$natureofoperation		= 	$this->Master_model->get_natureofoperation();
		$data['natureofoperation']	=	$natureofoperation;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/natureofoperation',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Nature of Operation end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Nature of Operation starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_natureofoperation()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'natureofoperation', 'page' => 'natureofoperation', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('natureofoperation_name', 'Nature of operation Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('natureofoperation_code', 'Nature of operation Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$natureofoperation_ins 			= 	$this->input->post('natureofoperation_ins');
			$natureofoperation_name			= 	$this->input->post('natureofoperation_name');
			$natureofoperation_mal_name 		= 	$this->input->post('natureofoperation_mal_name');
			$natureofoperation_code 		= 	$this->input->post('natureofoperation_code');
			$chkduplication	=$this->Master_model->check_duplication_natureofoperation_insert($natureofoperation_name,$natureofoperation_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($natureofoperation_ins=="Save Nature of Operation")
				{
					$data 			= 	array(
					'natureofoperation_name' 		=>	$natureofoperation_name,  
					'natureofoperation_mal_name' 	=> 	$natureofoperation_mal_name,
					'natureofoperation_code' 		=> 	$natureofoperation_code,
					'natureofoperation_status'		=>	'1',
					'natureofoperation_created_user_id'	=> 	$sess_usr_id,
					'natureofoperation_created_timestamp'=>	$date,
					'natureofoperation_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_natureofoperation_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">natureofoperation successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "natureofoperation Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add natureofoperation ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Nature of Operation starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_natureofoperation()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'natureofoperation', 'page' => 'natureofoperation', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('natureofoperation_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_natureofoperation_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Nature of Operation ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Nature of Operation  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_natureofoperation()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'natureofoperation', 'page' => 'natureofoperation', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_natureofoperation($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Nature of Operation  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_natureofoperation()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'natureofoperation', 'page' => 'natureofoperation', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_natureofoperation', 'Nature of Operation Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_natureofoperation_code', 'Nature of Operation Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_natureofoperation 	= 	$this->input->post('edit_natureofoperation');
			$edit_natureofoperation_mal 	= 	$this->input->post('edit_natureofoperation_mal');
			$edit_natureofoperation_code	= 	$this->input->post('edit_natureofoperation_code');
			$edit_natureofoperation	= 	$this->security->xss_clean($edit_natureofoperation);

			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_natureofoperation($edit_natureofoperation);
			$chkduplication	=$this->Master_model->check_duplication_natureofoperation_edit($edit_natureofoperation,$edit_natureofoperation_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array('natureofoperation_name' 		 =>	$edit_natureofoperation,  
				'natureofoperation_mal_name' 	 => 	$edit_natureofoperation_mal,
				'natureofoperation_code' 		 => 	$edit_natureofoperation_code,
				'natureofoperation_modified_user_id'	 =>	$sess_usr_id,
				'natureofoperation_modified_ipaddress'=>	$ip	);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_natureofoperation($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">natureofoperation Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Nature of Operation Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Nature of Operation ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Fire Pump Type

//____________________________________________________________________________________________________________________________________________	

// List Fire Pump Type starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function firepumptype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'firepumptype', 'page' => 'firepumptype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$firepumptype		= 	$this->Master_model->get_firepumptype();
		$data['firepumptype']	=	$firepumptype;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/firepumptype',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');         
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Fire Pump Type end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Fire Pump Type starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_firepumptype()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'firepumptype', 'page' => 'firepumptype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('firepumptype_name', 'Fire pump type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('firepumptype_code', 'fire pump type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$firepumptype_ins 			= 	$this->input->post('firepumptype_ins');
			$firepumptype_name			= 	$this->input->post('firepumptype_name');
			$firepumptype_mal_name 			= 	$this->input->post('firepumptype_mal_name');
			$firepumptype_code 			= 	$this->input->post('firepumptype_code');
			$chkduplication	=$this->Master_model->check_duplication_firepumptype_insert($firepumptype_name,$firepumptype_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($firepumptype_ins=="Save Fire Pump Type")
				{
					$data 			= 	array(
					'firepumptype_name' 		=>	$firepumptype_name,  
					'firepumptype_mal_name' 	=> 	$firepumptype_mal_name,
					'firepumptype_code' 		=> 	$firepumptype_code,
					'firepumptype_status'		=>	'1',
					'firepumptype_created_user_id'	=> 	$sess_usr_id,
					'firepumptype_created_timestamp'=>	$date,
					'firepumptype_created_ipaddress'=>	$ip	);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_firepumptype_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">firepumptype successfully Added!!!</div>');
					}
				}
			} 
			else
			{
				echo json_encode(array("val_errors" => "Firepump type Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add firepumptype ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Fire Pump Type starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_firepumptype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'firepumptype', 'page' => 'firepumptype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('firepumptype_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_firepumptype_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Fire Pump Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Fire Pump Type  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_firepumptype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'firepumptype', 'page' => 'firepumptype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_firepumptype($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
	redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Fire Pump Type  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_firepumptype()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'firepumptype', 'page' => 'firepumptype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_firepumptype', 'Fire Pump Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_firepumptype_code', 'Fire Pump Type Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_firepumptype 	= 	$this->input->post('edit_firepumptype');
			$edit_firepumptype_mal 	= 	$this->input->post('edit_firepumptype_mal');
			$edit_firepumptype_code	= 	$this->input->post('edit_firepumptype_code');
			$edit_firepumptype	= 	$this->security->xss_clean($edit_firepumptype);

			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_firepumptype($edit_firepumptype);
			$chkduplication	=$this->Master_model->check_duplication_firepumptype_edit($edit_firepumptype,$edit_firepumptype_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array('firepumptype_name' 		 =>	$edit_firepumptype,  
				'firepumptype_mal_name' 	 => 	$edit_firepumptype_mal,
				'firepumptype_code' 		 => 	$edit_firepumptype_code,
				'firepumptype_modified_user_id'	 =>	$sess_usr_id,
				'firepumptype_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_firepumptype($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Fire pump type Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Fire Pump Type Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Fire Pump Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//                                                             Form Type Location

//____________________________________________________________________________________________________________________________________________	

// List Form Type Location starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function formtype_location()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'formtype_location', 'page' => 'formtype_location', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$formtype_location		= 	$this->Master_model->get_formtype_location();
		$data['formtype_location']	=	$formtype_location;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/formtype_location',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');         
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Form Type Location end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Form Type Location starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_formtype_location()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'formtype_location', 'page' => 'formtype_location', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('formtype_location_name', 'Form type location Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('formtype_location_code', 'Form type location Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$formtype_location_ins 			= 	$this->input->post('formtype_location_ins');
			$formtype_location_name			= 	$this->input->post('formtype_location_name');
			$formtype_location_mal_name 		= 	$this->input->post('formtype_location_mal_name');
			$formtype_location_code 		= 	$this->input->post('formtype_location_code');
			$chkduplication	=$this->Master_model->check_duplication_formtype_location_insert($formtype_location_name,$formtype_location_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($formtype_location_ins=="Save Form Type Location")
				{
					$data 			= 	array(
					'formtype_location_name' 		=>	$formtype_location_name,  
					'formtype_location_mal_name' 		=> 	$formtype_location_mal_name,
					'formtype_location_code' 		=> 	$formtype_location_code,
					'formtype_location_status'		=>	'1',
					'formtype_location_created_user_id'	=> 	$sess_usr_id,
					'formtype_location_created_timestamp'   =>	$date,
					'formtype_location_created_ipaddress'	=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_formtype_location_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">formtype_location successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "formtype_location Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add formtype_location ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Form Type Location starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_formtype_location()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'formtype_location', 'page' => 'formtype_location', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('formtype_location_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_formtype_location_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Form Type Location ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Form Type Location  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_formtype_location()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'formtype_location', 'page' => 'formtype_location', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_formtype_location($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Form Type Location  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_formtype_location()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'formtype_location', 'page' => 'formtype_location', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_formtype_location', 'Form Type Location Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_formtype_location_code', 'Form Type Location Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_formtype_location 	= 	$this->input->post('edit_formtype_location');
			$edit_formtype_location_mal 	= 	$this->input->post('edit_formtype_location_mal');
			$edit_formtype_location_code	= 	$this->input->post('edit_formtype_location_code');
			$edit_formtype_location	= 	$this->security->xss_clean($edit_formtype_location);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_formtype_location($edit_formtype_location);
			$chkduplication	=$this->Master_model->check_duplication_formtype_location_edit($edit_formtype_location,$edit_formtype_location_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'formtype_location_name' 		 =>	$edit_formtype_location,  
				'formtype_location_mal_name' 	 => 	$edit_formtype_location_mal,
				'formtype_location_code' 		 => 	$edit_formtype_location_code,
				'formtype_location_modified_user_id'	 =>	$sess_usr_id,
				'formtype_location_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_formtype_location($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Form Type Location Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Form Type Location Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Form Type Location ends.	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Stern

//____________________________________________________________________________________________________________________________________________	

// List Stern starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function stern()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'stern', 'page' => 'stern', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$stern		= 	$this->Master_model->get_stern();
		$data['stern']	=	$stern;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/stern',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');               
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Stern end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Stern starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_stern()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'stern', 'page' => 'stern', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('stern_name', 'Stern Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('stern_code', 'Stern Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$stern_ins 			= 	$this->input->post('stern_ins');
			$stern_name			= 	$this->input->post('stern_name');
			$stern_mal_name 		= 	$this->input->post('stern_mal_name');
			$stern_code 			= 	$this->input->post('stern_code');
			$chkduplication	=$this->Master_model->check_duplication_stern_insert($stern_name,$stern_code);
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($stern_ins=="Save Stern")
				{
					$data 			= 	array(
					'stern_name' 		=>	$stern_name,  
					'stern_mal_name' 	=> 	$stern_mal_name,
					'stern_code' 		=> 	$stern_code,
					'stern_status'		=>	'1',
					'stern_created_user_id'	=> 	$sess_usr_id,
					'stern_created_timestamp'=>	$date,
					'stern_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_stern_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Stern Successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Stern Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add stern ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Stern starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_stern()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'stern', 'page' => 'stern', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
		$updstat 		= 	0;
		}
		else
		{
		$updstat 		= 	1;
		}

		$data =	array('stern_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_stern_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Stern ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Stern  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_stern()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'stern', 'page' => 'stern', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_stern($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Stern  starting...  (10-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_stern()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'stern', 'page' => 'stern', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_stern', 'Stern Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_stern_code', 'Stern Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_stern 		= 	$this->input->post('edit_stern');
			$edit_stern_mal 	= 	$this->input->post('edit_stern_mal');
			$edit_stern_code	= 	$this->input->post('edit_stern_code');

			$edit_stern		= 	$this->security->xss_clean($edit_stern);

			/*Edited on 14-06-2018  Start*/	
			//$chkduplication=$this->Master_model->check_duplication_stern($edit_stern);
			$chkduplication	=$this->Master_model->check_duplication_stern_edit($edit_stern,$edit_stern_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'stern_name' 		  =>	$edit_stern,  
				'stern_mal_name' 	  => 	$edit_stern_mal,
				'stern_code' 		  => 	$edit_stern_code,
				'stern_modified_user_id'  =>	$sess_usr_id,
				'stern_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_stern($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Stern Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Stern Name/Malayalam Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Stern ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             BANK

//____________________________________________________________________________________________________________________________________________	

// List Bank starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function bank()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'bank', 'page' => 'bank', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$bank		= 	$this->Master_model->get_bank();
		$data['bank']	=	$bank;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/bank',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');               
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List bank end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add bank starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_bank()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))		
	{	
		$data =	array('title' => 'bank', 'page' => 'bank', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('bank_code', 'Bank Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$bank_ins 			= 	$this->input->post('bank_ins');
			$bank_name			= 	$this->input->post('bank_name');
			$bank_mal_name 			= 	$this->input->post('bank_mal_name');
			$bank_code 			= 	$this->input->post('bank_code');
			$chkduplication	=$this->Master_model->check_duplication_bank_insert($bank_name,$bank_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($bank_ins=="Save bank")
				{
					$data 			= 	array(
					'bank_name' 		=>	$bank_name,  
					'bank_mal_name' 	=> 	$bank_mal_name,
					'bank_code' 		=> 	$bank_code,
					'bank_status'		=>	'1',
					'bank_created_user_id'	=> 	$sess_usr_id,
					'bank_created_timestamp'=>	$date,
					'bank_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_bank_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Bank successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Bank Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add bank ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status bank starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_bank()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'bank', 'page' => 'bank', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('bank_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_bank_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status bank ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete bank  starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_bank()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{
		$data	= array('title' => 'bank', 'page' => 'bank', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_bank($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit bank  starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_bank()
{		
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'bank', 'page' => 'bank', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		$this->form_validation->set_rules('edit_bank', 'Bank Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_bank_code', 'Bank Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_bank 	= 	$this->input->post('edit_bank');
			$edit_bank_mal 	= 	$this->input->post('edit_bank_mal');
			$edit_bank_code	= 	$this->input->post('edit_bank_code');
			$edit_bank	= 	$this->security->xss_clean($edit_bank);
			//$chkduplication	=	$this->Master_model->check_duplication_bank($edit_bank);
			$chkduplication	=	$this->Master_model->check_duplication_bank_edit($edit_bank,$edit_bank_code,$id);
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'bank_name' 		 =>	$edit_bank,  
				'bank_mal_name' 	 => 	$edit_bank_mal,
				'bank_code' 		 => 	$edit_bank_code,
				'bank_modified_user_id'	 =>	$sess_usr_id,
				'bank_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_bank($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Bank Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Bank Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit bank ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             OCCUPATION

//____________________________________________________________________________________________________________________________________________	

// List Occupation starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function occupation()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'occupation', 'page' => 'occupation', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$occupation		= 	$this->Master_model->get_occupation();
		$data['occupation']	=	$occupation;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/occupation',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');                
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List occupation end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add occupation starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_occupation()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'occupation', 'page' => 'occupation', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('occupation_name', 'Occupation Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('occupation_code', 'Occupation Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$occupation_ins 			= 	$this->input->post('occupation_ins');
			$occupation_name			= 	$this->input->post('occupation_name');
			$occupation_mal_name 			= 	$this->input->post('occupation_mal_name');
			$occupation_code 			= 	$this->input->post('occupation_code');
			$chkduplication				=	$this->Master_model->check_duplication_occupation_insert($occupation_name,$occupation_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($occupation_ins=="Save occupation")
				{
					$data 			= 	array(
					'occupation_name' 		=>	$occupation_name,  
					'occupation_mal_name' 	=> 	$occupation_mal_name,
					'occupation_code' 		=> 	$occupation_code,
					'occupation_status'		=>	'1',
					'occupation_created_user_id'	=> 	$sess_usr_id,
					'occupation_created_timestamp'=>	$date,
					'occupation_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_occupation_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Occupation successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Occupation Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add occupation ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status occupation starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_occupation()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'occupation', 'page' => 'occupation', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data =	array('occupation_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_occupation_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status occupation ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete occupation  starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_occupation()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'occupation', 'page' => 'occupation', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_occupation($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit occupation  starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_occupation()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'occupation', 'page' => 'occupation', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_occupation', 'Occupation Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_occupation_code', 'Occupation Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_occupation 	= 	$this->input->post('edit_occupation');
			$edit_occupation_mal 	= 	$this->input->post('edit_occupation_mal');
			$edit_occupation_code	= 	$this->input->post('edit_occupation_code');
			$edit_occupation	= 	$this->security->xss_clean($edit_occupation);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_occupation($edit_occupation);
			$chkduplication	=$this->Master_model->check_duplication_occupation_edit($edit_occupation,$edit_occupation_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'occupation_name' 		 =>	$edit_occupation,  
				'occupation_mal_name' 	 => 	$edit_occupation_mal,
				'occupation_code' 		 => 	$edit_occupation_code,
				'occupation_modified_user_id'	 =>	$sess_usr_id,
				'occupation_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_occupation($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Occupation Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Occupation Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit occupation ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Survey Activity

//____________________________________________________________________________________________________________________________________________	

// List Survey Activity starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function surveyactivity()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'surveyactivity', 'page' => 'surveyactivity', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$surveyactivity		= 	$this->Master_model->get_surveyactivity();
		$data['surveyactivity']	=	$surveyactivity;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/surveyactivity',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');               
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Survey Activity end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Survey Activity starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_surveyactivity()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'surveyactivity', 'page' => 'surveyactivity', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('surveyactivity_name', 'Survey activity Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('surveyactivity_code', 'Survey activity Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$surveyactivity_ins 			= 	$this->input->post('surveyactivity_ins');
			$surveyactivity_name			= 	$this->input->post('surveyactivity_name');
			$surveyactivity_mal_name 		= 	$this->input->post('surveyactivity_mal_name');
			$surveyactivity_code 			= 	$this->input->post('surveyactivity_code');
			$chkduplication	=$this->Master_model->check_duplication_surveyactivity_insert($surveyactivity_name,$surveyactivity_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($surveyactivity_ins=="Save Survey Activity")
				{
					$data 			= 	array(
					'surveyactivity_name' 		=>	$surveyactivity_name,  
					'surveyactivity_mal_name' 	=> 	$surveyactivity_mal_name,
					'surveyactivity_code' 		=> 	$surveyactivity_code,
					'surveyactivity_status'		=>	'1',
					'surveyactivity_created_user_id'	=> 	$sess_usr_id,
					'surveyactivity_created_timestamp'=>	$date,
					'surveyactivity_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_surveyactivity_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Survey activity successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Suvey Activity Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Survey Activity ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Survey Activity starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_surveyactivity()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'surveyactivity', 'page' => 'surveyactivity', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data =	array('surveyactivity_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_surveyactivity_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Survey Activity ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Survey Activity  starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_surveyactivity()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'surveyactivity', 'page' => 'surveyactivity', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_surveyactivity($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit surveyactivity  starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_surveyactivity()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'surveyactivity', 'page' => 'surveyactivity', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_surveyactivity', 'Survey activity Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_surveyactivity_code', 'Survey activity Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_surveyactivity 	= 	$this->input->post('edit_surveyactivity');
			$edit_surveyactivity_mal 	= 	$this->input->post('edit_surveyactivity_mal');
			$edit_surveyactivity_code	= 	$this->input->post('edit_surveyactivity_code');
			$edit_surveyactivity	= 	$this->security->xss_clean($edit_surveyactivity);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_surveyactivity($edit_surveyactivity);
			$chkduplication	=$this->Master_model->check_duplication_surveyactivity_edit($edit_surveyactivity,$edit_surveyactivity_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'surveyactivity_name' 		 =>	$edit_surveyactivity,  
				'surveyactivity_mal_name' 	 => 	$edit_surveyactivity_mal,
				'surveyactivity_code' 		 => 	$edit_surveyactivity_code,
				'surveyactivity_modified_user_id'	 =>	$sess_usr_id,
				'surveyactivity_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_surveyactivity($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Survey activity Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Suvey Activity Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit surveyactivity ends.	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Upload document type

//____________________________________________________________________________________________________________________________________________	

// List Upload document type starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function document_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'document_type', 'page' => 'document_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$document_type		= 	$this->Master_model->get_document_type();
		$data['document_type']	=	$document_type;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/document_type',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Upload document type end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Upload document type starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_document_type()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'document_type', 'page' => 'document_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('document_type_name', 'Document type Name', 'required|callback_alphanum_check');
		$this->form_validation->set_rules('document_type_code', 'Document type Code', 'required|callback_minalphanum_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$document_type_ins 			= 	$this->input->post('document_type_ins');
			$document_type_name			= 	$this->input->post('document_type_name');
			$document_type_mal_name 		= 	$this->input->post('document_type_mal_name');
			$document_type_code 			= 	$this->input->post('document_type_code');
			$chkduplication	=$this->Master_model->check_duplication_document_type_insert($document_type_name,$document_type_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($document_type_ins=="Save Document Type")
				{
					$data 			= 	array(
					'document_type_name' 		=>	$document_type_name,  
					'document_type_mal_name' 	=> 	$document_type_mal_name,
					'document_type_code' 		=> 	$document_type_code,
					'document_type_status'		=>	'1',
					'document_type_created_user_id'	=> 	$sess_usr_id,
					'document_type_created_timestamp'=>	$date,
					'document_type_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_document_type_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Document Type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Document type Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Upload document type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Upload document typestarting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_document_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'document_type', 'page' => 'document_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('document_type_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_document_type_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		

	
//Status Upload document type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Upload document type  starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_document_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'document_type', 'page' => 'document_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_document_type($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Upload document type  starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_document_type()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'document_type', 'page' => 'document_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_document_type', 'Document Type Name', 'required|callback_alphanum_check');
		$this->form_validation->set_rules('edit_document_type_code', 'Document Type Code', 'required|callback_minalphanum_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_document_type 	= 	$this->input->post('edit_document_type');
			$edit_document_type_mal 	= 	$this->input->post('edit_document_type_mal');
			$edit_document_type_code	= 	$this->input->post('edit_document_type_code');
			$edit_document_type	= 	$this->security->xss_clean($edit_document_type);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_document_type($edit_document_type);
			$chkduplication	=$this->Master_model->check_duplication_document_type_edit($edit_document_type,$edit_document_type_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'document_type_name' 		 =>	$edit_document_type,  
				'document_type_mal_name' 	 => 	$edit_document_type_mal,
				'document_type_code' 		 => 	$edit_document_type_code,
				'document_type_modified_user_id'	 =>	$sess_usr_id,
				'document_type_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_document_type($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Document Type Updated Successfully!!!</div>');
				}
			}
			else 
			{
			echo json_encode(array("val_errors" => "Document Type Name/Code Already Exists!!!"));
			}
		} 
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Upload document type ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             File Document

//____________________________________________________________________________________________________________________________________________	

// List File Document starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function document()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'document', 'page' => 'document', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 	= 	$data + $this->data;     
		$document		= 	$this->Master_model->get_document();
		$data['document']       =	$document;
		$data 			= 	$data + $this->data;
		$document_type		=	$this->Master_model->get_document_type();
		$data['document_type']	=	$document_type;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/document',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');                                 
	}
	else
	{
		redirect('Main_login/index');        
	}  
}
// List File Document end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add File Document starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function add_document()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 		= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'document', 'page' => 'document', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 	= 	$data + $this->data;
		//set validation rules
		//$this->form_validation->set_rules('document_type_id', 'Document Type Name', 'required');
		$this->form_validation->set_rules('document_name', 'Document Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('document_code', 'Document Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors	= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else
		{
			$document_ins 	   = 	$this->input->post('document_ins');
			$document_type_id  =       $this->input->post('document_type_id');
			$document_name     = 	$this->input->post('document_name');
			$document_mal_name = 	$this->input->post('document_mal_name');
			$document_code 	   = 	$this->input->post('document_code');
			$chkduplication	   =	$this->Master_model->check_duplication_document_insert($document_type_id,$document_name);
			$cntrows	   =	count($chkduplication);
			if($cntrows==0)
			{
				if($document_ins=="Save Document")
				{
					$data 			= 	array(
					'document_type_id'              =>	$document_type_id,
					'document_name' 		=>	$document_name,  
					'document_mal_name'          	=> 	$document_mal_name,
					'document_code' 		=> 	$document_code,
					'document_status'		=>	'1',
					'document_created_user_id'	=> 	$sess_usr_id,
					'document_created_timestamp'	=>	$date,
					'document_created_ipaddress'	=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res		=	$this->db->insert('kiv_document_master', $data);
					// print($usr_res);
					//exit;
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Document successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Document Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}


//Add File Document ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status File Document starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_document()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data   =	array('title' => 'document', 'page' => 'document', 'errorCls' => NULL, 'post' => $this->input->post());
		$data   = 	$data + $this->data;
		$id     = 	$this->input->post('id');
		$status	= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('document_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_document_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
//Status File Document ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete File Document starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function delete_document()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 	= 	array('title' => 'document', 'page' => 'document', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 	= 	$data + $this->data;
		$id 	= 	$this->input->post('id');
		$status = 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data	= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_document($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit File Document starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_document()
{
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	=  array('title' => 'document', 'page' => 'document', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 	=  $data + $this->data;
		//$this->form_validation->set_rules('document_type_id', 'Document Type Name', 'required');			
		$this->form_validation->set_rules('edit_document', 'Document Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_document_code', 'Document Code', 'required|callback_minalpha_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 		        = 	$this->input->post('id');
			$id                     =	$this->security->xss_clean($id);
			$edit_document_type_id  = 	$this->input->post('edit_document_type_id');
			$edit_document		= 	$this->input->post('edit_document');
			$edit_document_mal 	= 	$this->input->post('edit_document_mal');
			$edit_document_code 	= 	$this->input->post('edit_document_code');
			$edit_document   	= 	$this->security->xss_clean($edit_document);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_documentname($edit_document);
			$chkduplication	=$this->Master_model->check_duplication_document_edit($edit_document_type_id,$edit_document,$edit_document_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 			= 	array('document_type_id' => $edit_document_type_id,
				'document_name' 		=>	$edit_document,  
				'document_mal_name'             => 	$edit_document_mal,
				'document_code' 		=> 	$edit_document_code,
				'document_modified_user_id'	=>	$sess_usr_id,
				'document_modified_ipaddress'	=>	$ip	);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_document($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Document Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Document Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit File Document ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Pollution Control Device

//____________________________________________________________________________________________________________________________________________	

// List Pollution Control Device starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function pollution_controldevice()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'pollution_controldevice', 'page' => 'pollution_controldevice', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$pollution_controldevice		= 	$this->Master_model->get_pollution_controldevice();
		$data['pollution_controldevice']	=	$pollution_controldevice;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/pollution_controldevice',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');               
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Pollution Control Device end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Pollution Control Device starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_pollution_controldevice()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'pollution_controldevice', 'page' => 'pollution_controldevice', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('pollution_controldevice_name', 'Pollution control device Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('pollution_controldevice_code', 'Pollution control device Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$pollution_controldevice_ins 			= 	$this->input->post('pollution_controldevice_ins');
			$pollution_controldevice_name			= 	$this->input->post('pollution_controldevice_name');
			$pollution_controldevice_mal_name 		= 	$this->input->post('pollution_controldevice_mal_name');
			$pollution_controldevice_code 			= 	$this->input->post('pollution_controldevice_code');
			$chkduplication	=$this->Master_model->check_duplication_pollution_controldevice_insert($pollution_controldevice_name,$pollution_controldevice_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($pollution_controldevice_ins=="Save Pollution Control Device")
				{
					$data 			= 	array(
					'pollution_controldevice_name' 		=>	$pollution_controldevice_name,  
					'pollution_controldevice_mal_name' 	=> 	$pollution_controldevice_mal_name,
					'pollution_controldevice_code' 		=> 	$pollution_controldevice_code,
					'pollution_controldevice_status'		=>	'1',
					'pollution_controldevice_created_user_id'	=> 	$sess_usr_id,
					'pollution_controldevice_created_timestamp'=>	$date,
					'pollution_controldevice_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_pollution_controldevice_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Pollution Control Device successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Pollution Control Device Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Pollution Control Device ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Pollution Control Device starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_pollution_controldevice()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'pollution_controldevice', 'page' => 'pollution_controldevice', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('pollution_controldevice_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_pollution_controldevice_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		

	
//Status Pollution Control Device ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Pollution Control Device starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_pollution_controldevice()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'pollution_controldevice', 'page' => 'pollution_controldevice', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_pollution_controldevice($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Pollution Control Device starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_pollution_controldevice()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'pollution_controldevice', 'page' => 'pollution_controldevice', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_pollution_controldevice', 'Pollution Control Device Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_pollution_controldevice_code', 'Pollution Control Device Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_pollution_controldevice 	= 	$this->input->post('edit_pollution_controldevice');
			$edit_pollution_controldevice_mal 	= 	$this->input->post('edit_pollution_controldevice_mal');
			$edit_pollution_controldevice_code	= 	$this->input->post('edit_pollution_controldevice_code');
			$edit_pollution_controldevice	= 	$this->security->xss_clean($edit_pollution_controldevice);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_pollution_controldevice($edit_pollution_controldevice);
			$chkduplication	=$this->Master_model->check_duplication_pollution_controldevice_edit($edit_pollution_controldevice,$edit_pollution_controldevice_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array('pollution_controldevice_name' =>	$edit_pollution_controldevice,  
				'pollution_controldevice_mal_name' 	 => 	$edit_pollution_controldevice_mal,
				'pollution_controldevice_code' 		 => 	$edit_pollution_controldevice_code,
				'pollution_controldevice_modified_user_id'	 =>	$sess_usr_id,
				'pollution_controldevice_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_pollution_controldevice($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Pollution Control Device Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Pollution Control Device Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Pollution Control Device ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Plying State

//____________________________________________________________________________________________________________________________________________	

// List Plying State starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function plyingstate()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'plyingstate', 'page' => 'plyingstate', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$plyingstate		= 	$this->Master_model->get_plyingstate();
		$data['plyingstate']	=	$plyingstate;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/plyingstate',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Plying State end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Plying State starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_plyingstate()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'plyingstate', 'page' => 'plyingstate', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('plyingstate_name', 'Plying state Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('plyingstate_code', 'Plying state Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$plyingstate_ins 			= 	$this->input->post('plyingstate_ins');
			$plyingstate_name			= 	$this->input->post('plyingstate_name');
			$plyingstate_mal_name 		= 	$this->input->post('plyingstate_mal_name');
			$plyingstate_code 			= 	$this->input->post('plyingstate_code');
			$chkduplication	=$this->Master_model->check_duplication_plyingstate_insert($plyingstate_name,$plyingstate_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($plyingstate_ins=="Save Plying State")
				{
					$data 			= 	array(
					'plyingstate_name' 		=>	$plyingstate_name,  
					'plyingstate_mal_name' 		=> 	$plyingstate_mal_name,
					'plyingstate_code' 		=> 	$plyingstate_code,
					'plyingstate_status'		=>	'1',
					'plyingstate_created_user_id'	=> 	$sess_usr_id,
					'plyingstate_created_timestamp'=>	$date,
					'plyingstate_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_plyingstate_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Plying State successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Plying State Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Plying State ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Plying State starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_plyingstate()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'plyingstate', 'page' => 'plyingstate', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('plyingstate_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_plyingstate_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Plying State ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Plying State starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_plyingstate()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{
		$data	= array('title' => 'plyingstate', 'page' => 'plyingstate', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_plyingstate($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Plying State starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_plyingstate()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'plyingstate', 'page' => 'plyingstate', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_plyingstate', 'Plying State Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_plyingstate_code', 'Plying State Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_plyingstate 	= 	$this->input->post('edit_plyingstate');
			$edit_plyingstate_mal 	= 	$this->input->post('edit_plyingstate_mal');
			$edit_plyingstate_code	= 	$this->input->post('edit_plyingstate_code');
			$edit_plyingstate	= 	$this->security->xss_clean($edit_plyingstate);
			/*Edited on 14-06-2018  Start*/
			//$chkduplication		=	$this->Master_model->check_duplication_plyingstate($edit_plyingstate);
			$chkduplication	=$this->Master_model->check_duplication_plyingstate_edit($edit_plyingstate,$edit_plyingstate_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array('plyingstate_name' =>	$edit_plyingstate,  
				'plyingstate_mal_name' 	 	 => 	$edit_plyingstate_mal,
				'plyingstate_code' 		 => 	$edit_plyingstate_code,
				'plyingstate_modified_user_id'	 =>	$sess_usr_id,
				'plyingstate_modified_ipaddress' =>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_plyingstate($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Plying State Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Plying State Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Plying State ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Towing

//____________________________________________________________________________________________________________________________________________	

// List Towing starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function towing()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'towing', 'page' => 'towing', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$towing		= 	$this->Master_model->get_towing();
		$data['towing']	=	$towing;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/towing',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');               
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Towing end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Towing starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_towing()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'towing', 'page' => 'towing', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('towing_name', 'Towing Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('towing_code', 'Towing Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$towing_ins 			= 	$this->input->post('towing_ins');
			$towing_name			= 	$this->input->post('towing_name');
			$towing_mal_name 		= 	$this->input->post('towing_mal_name');
			$towing_code 			= 	$this->input->post('towing_code');
			$chkduplication	=$this->Master_model->check_duplication_towing_insert($towing_name,$towing_code); 
			$cntrows			=	count($chkduplication);
			if($cntrows==0)
			{
				if($towing_ins=="Save Towing")
				{
					$data 			= 	array('towing_name' 		=>	$towing_name,  
					'towing_mal_name' 	=> 	$towing_mal_name,
					'towing_code' 		=> 	$towing_code,
					'towing_status'		=>	'1',
					'towing_created_user_id'	=> 	$sess_usr_id,
					'towing_created_timestamp'=>	$date,
					'towing_created_ipaddress'=>	$ip	);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_towing_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Towing successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Towing Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Towing ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Towing starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_towing()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'towing', 'page' => 'towing', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('towing_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_towing_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Towing ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Towing starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_towing()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'towing', 'page' => 'towing', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_towing($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Towing starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_towing()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'towing', 'page' => 'towing', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_towing', 'Towing Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_towing_code', 'Towing Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_towing 	= 	$this->input->post('edit_towing');
			$edit_towing_mal 	= 	$this->input->post('edit_towing_mal');
			$edit_towing_code	= 	$this->input->post('edit_towing_code');
			$edit_towing	= 	$this->security->xss_clean($edit_towing);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_towing($edit_towing);
			$chkduplication	=$this->Master_model->check_duplication_towing_edit($edit_towing,$edit_towing_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'towing_name' 		 =>	$edit_towing,  
				'towing_mal_name' 	 => 	$edit_towing_mal,
				'towing_code' 		 => 	$edit_towing_code,
				'towing_modified_user_id'	 =>	$sess_usr_id,
				'towing_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_towing($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Towing Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Towing Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Towing ends.	
/*____________________________________________________________________________________________________________________________________________*/	


/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Fire extinguisher sub type

//____________________________________________________________________________________________________________________________________________	

// List Fire extinguisher sub type starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function fireextinguisher_subtype()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireextinguisher_subtype', 'page' => 'fireextinguisher_subtype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$fireextinguisher_subtype		= 	$this->Master_model->get_fireextinguisher_subtype();
		$data['fireextinguisher_subtype']	=	$fireextinguisher_subtype;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/fireextinguisher_subtype',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');                
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Fire extinguisher sub type end
/*____________________________________________________________________________________________________________________________________________*/	

//____________________________________________________________________________________________________________________________________________	

// Add Fire extinguisher sub type starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_fireextinguisher_subtype()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireextinguisher_subtype', 'page' => 'fireextinguisher_subtype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('fireextinguisher_subtype_name', 'Fire extinguisher sub type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('fireextinguisher_subtype_code', 'Fire extinguisher sub type Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$fireextinguisher_subtype_ins 			= 	$this->input->post('fireextinguisher_subtype_ins');
			$fireextinguisher_subtype_name			= 	$this->input->post('fireextinguisher_subtype_name');
			$fireextinguisher_subtype_mal_name 		= 	$this->input->post('fireextinguisher_subtype_mal_name');
			$fireextinguisher_subtype_code 			= 	$this->input->post('fireextinguisher_subtype_code');
			$chkduplication	=$this->Master_model->check_duplication_fireextinguisher_subtype_insert($fireextinguisher_subtype_name,$fireextinguisher_subtype_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($fireextinguisher_subtype_ins=="Save Fire Extinguisher Sub Type")
				{
					$data 			= 	array(
					'fireextinguisher_subtype_name' 		=>	$fireextinguisher_subtype_name,  
					'fireextinguisher_subtype_mal_name' 	=> 	$fireextinguisher_subtype_mal_name,
					'fireextinguisher_subtype_code' 		=> 	$fireextinguisher_subtype_code,
					'fireextinguisher_subtype_status'		=>	'1',
					'fireextinguisher_subtype_created_user_id'	=> 	$sess_usr_id,
					'fireextinguisher_subtype_created_timestamp'=>	$date,
					'fireextinguisher_subtype_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_fireextinguisher_subtype_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Fire extinguisher sub type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Fire extinguisher sub type Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	
//Add Fire extinguisher sub type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Fire extinguisher sub type starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_fireextinguisher_subtype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireextinguisher_subtype', 'page' => 'fireextinguisher_subtype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('fireextinguisher_subtype_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_fireextinguisher_subtype_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Fire extinguisher sub type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Fire extinguisher sub type starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_fireextinguisher_subtype()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'fireextinguisher_subtype', 'page' => 'fireextinguisher_subtype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_fireextinguisher_subtype($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Fire extinguisher sub type starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_fireextinguisher_subtype()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireextinguisher_subtype', 'page' => 'fireextinguisher_subtype', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_fireextinguisher_subtype', 'Fire extinguisher sub type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_fireextinguisher_subtype_code', 'Fire extinguisher sub type Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_fireextinguisher_subtype 	= 	$this->input->post('edit_fireextinguisher_subtype');
			$edit_fireextinguisher_subtype_mal 	= 	$this->input->post('edit_fireextinguisher_subtype_mal');
			$edit_fireextinguisher_subtype_code	= 	$this->input->post('edit_fireextinguisher_subtype_code');
			$edit_fireextinguisher_subtype	= 	$this->security->xss_clean($edit_fireextinguisher_subtype);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_fireextinguisher_subtype($edit_fireextinguisher_subtype);
			$chkduplication	=$this->Master_model->check_duplication_fireextinguisher_subtype_edit($edit_fireextinguisher_subtype,$edit_fireextinguisher_subtype_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array('fireextinguisher_subtype_name' =>$edit_fireextinguisher_subtype,  
				'fireextinguisher_subtype_mal_name' 	 	 => 	$edit_fireextinguisher_subtype_mal,
				'fireextinguisher_subtype_code' 		 => 	$edit_fireextinguisher_subtype_code,
				'fireextinguisher_subtype_modified_user_id'	 =>	$sess_usr_id,
				'fireextinguisher_subtype_modified_ipaddress'    =>	$ip	);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_fireextinguisher_subtype($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Fire extinguisher sub type Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Fire extinguisher sub type Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Fire extinguisher sub type ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	
//                                                             Equipment
//___________________________________________________________________________________________________________________________________________	

// List Equipment starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function equipment()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment', 'page' => 'equipment', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$equipment		= 	$this->Master_model->get_equipment();
		$data['equipment']	=	$equipment;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$equipment_type		= 	$this->Master_model->get_equipment_type();
		$data['equipment_type']	=	$equipment_type;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$equipment_measurement	= 	$this->Master_model->get_equipment_measurement();
		$data['equipment_measurement']	=	$equipment_measurement;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/equipment',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');                
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Equipment end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Equipment starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_equipment()
{
	$ip	=$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date = date('Y-m-d h:i:s', time());	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment', 'page' => 'equipment', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('equipment_name', 'Equipment Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('equipment_code', 'Equipment Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$equipment_ins 			= 	$this->input->post('equipment_ins');
			$equipment_type_id		= 	$this->input->post('equipment_type_id');
			$equipment_name			= 	$this->input->post('equipment_name');
			$equipment_mal_name 	= 	$this->input->post('equipment_mal_name');
			$equipment_code 		= 	$this->input->post('equipment_code');
			$equipment_measurement 	= 	$this->input->post('equipment_measurement');

			/*$mater_table_name=$this->Master_model->get_equipment_masterTableName($equipment_type_id);
			$data['mater_table_name']	=	$mater_table_name;print_r($mater_table_name);exit;
			$table_name=$mater_table_name['equipment_mastertablename'];*/

			$chkduplication	=$this->Master_model->check_duplication_equipment($equipment_name); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($equipment_ins=="Save Equipment")
				{
					$data 			= 	array(
					'equipment_name' 		=>	$equipment_name,  
					'equipment_type_id' 		=> 	$equipment_type_id,  
					'equipment_mal_name' 		=> 	$equipment_mal_name,
					'equipment_code' 		=> 	$equipment_code,
					'equipment_measurement' 	=> 	$equipment_measurement,
					'equipment_status'		=>	'1',
					'equipment_created_user_id'	=> 	$sess_usr_id,
					'equipment_created_timestamp'=>	$date,
					'equipment_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_equipment_master', $data);
					//$insert_id  =   $this->db->insert_id();
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Equipment successfully Added!!!</div>');
					}	
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Equipment Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Equipment ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Equipment starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_equipment()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment', 'page' => 'equipment', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('equipment_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_equipment_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		

	
//Status Equipment ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
//____________________________________________________________________________________________________________________________________________	

// Delete Equipment starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_equipment()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'equipment', 'page' => 'equipment', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_equipment($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Equipment starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_equipment()
{
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment', 'page' => 'equipment', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_equipment', 'Equipment Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_equipment_code', 'Equipment Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_equipment 	= 	$this->input->post('edit_equipment');
			$edit_equipment_type_id = 	$this->input->post('edit_equipment_type_id');
			$edit_equipment_mal 	= 	$this->input->post('edit_equipment_mal');
			$edit_equipment_code	= 	$this->input->post('edit_equipment_code');
			$edit_equipment_measurement= 	$this->input->post('edit_equipment_measurement');
			$edit_equipment	= 	$this->security->xss_clean($edit_equipment);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_equipment($edit_equipment);
			$chkduplication	=$this->Master_model->check_duplication_equipment_edit($edit_equipment,$edit_equipment_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'equipment_name' 		 =>	$edit_equipment,
				'equipment_type_id' 	         => 	$edit_equipment_type_id,  
				'equipment_mal_name' 	 	 => 	$edit_equipment_mal,
				'equipment_code' 		 => 	$edit_equipment_code,
				'equipment_measurement' 	 => 	$edit_equipment_measurement,
				'equipment_modified_user_id'	 =>	$sess_usr_id,
				'equipment_modified_timestamp'=>	$date,
				'equipment_modified_ipaddress'   =>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_equipment($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Equipment Updated Successfully!!!</div>');
				}
			}
			else 
			{
			echo json_encode(array("val_errors" => "Equipment Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Equipment ends.	
/*____________________________________________________________________________________________________________________________________________*/	


//                                                             Fire Appliance

//____________________________________________________________________________________________________________________________________________	

// List Fire Appliance starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function fireappliance()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireappliance', 'page' => 'fireappliance', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$fireappliance		= 	$this->Master_model->get_fireappliance();
		$data['fireappliance']	=	$fireappliance;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/fireappliance',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');              
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Fire Appliance end
/*____________________________________________________________________________________________________________________________________________*/	

//____________________________________________________________________________________________________________________________________________	

// Add Fire Appliance starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function add_fireappliance()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	/*$int_usertype	=	$this->session->userdata('user_type_id');
	$sess_usr_id 	= 	$this->session->userdata('user_sl');*/
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireappliance', 'page' => 'fireappliance', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('fireappliance_name', 'Fire appliance Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('fireappliance_code', 'Fire appliance Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$fireappliance_ins 			= 	$this->input->post('fireappliance_ins');
			$fireappliance_name			= 	$this->input->post('fireappliance_name');
			$fireappliance_mal_name 		= 	$this->input->post('fireappliance_mal_name');
			$fireappliance_code 			= 	$this->input->post('fireappliance_code');
			$chkduplication	=$this->Master_model->check_duplication_fireappliance_insert($fireappliance_name,$fireappliance_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($fireappliance_ins=="Save Fire Appliance")
				{
					$data 			= 	array(
					'fireappliance_name' 		=>	$fireappliance_name,  
					'fireappliance_mal_name' 	=> 	$fireappliance_mal_name,
					'fireappliance_code' 		=> 	$fireappliance_code,
					'fireappliance_status'		=>	'1',
					'fireappliance_created_user_id'	=> 	$sess_usr_id,
					'fireappliance_created_timestamp'=>	$date,
					'fireappliance_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_fireappliance_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Fire Appliance successfully Added!!!</div>');
					}
				}	
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Fire Appliance Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Fire Appliance ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Fire Appliance starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_fireappliance()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireappliance', 'page' => 'fireappliance', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('fireappliance_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_fireappliance_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Fire Appliance ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Fire Appliance starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_fireappliance()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'fireappliance', 'page' => 'fireappliance', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_fireappliance($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Fire Appliance starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_fireappliance()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'fireappliance', 'page' => 'fireappliance', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_fireappliance', 'Fire appliance Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_fireappliance_code', 'Fire appliance Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_fireappliance 	= 	$this->input->post('edit_fireappliance');
			$edit_fireappliance_mal 	= 	$this->input->post('edit_fireappliance_mal');
			$edit_fireappliance_code	= 	$this->input->post('edit_fireappliance_code');
			$edit_fireappliance	= 	$this->security->xss_clean($edit_fireappliance);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_fireappliance($edit_fireappliance);
			$chkduplication	=$this->Master_model->check_duplication_fireappliance_edit($edit_fireappliance,$edit_fireappliance_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'fireappliance_name' 		 =>	$edit_fireappliance,  
				'fireappliance_mal_name' 	 => 	$edit_fireappliance_mal,
				'fireappliance_code' 		 => 	$edit_fireappliance_code,
				'fireappliance_modified_user_id' =>	$sess_usr_id,
				'fireappliance_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_fireappliance($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Fire Appliance Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Fire Appliance Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Fire Appliance ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//                                                             Vessel Class

//____________________________________________________________________________________________________________________________________________	

// List Vessel Class starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________


public function vessel_class()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'vessel_class', 'page' => 'vessel_class', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$vessel_class		= 	$this->Master_model->get_vessel_class();
		$data['vessel_class']	=	$vessel_class;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/vessel_class',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Vessel Class end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Vessel Class starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_vessel_class()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'vessel_class', 'page' => 'vessel_class', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('vessel_class_name', 'Vessel class Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('vessel_class_code', 'Vessel class Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$vessel_class_ins 			= 	$this->input->post('vessel_class_ins');
			$vessel_class_name			= 	$this->input->post('vessel_class_name');
			$vessel_class_mal_name 			= 	$this->input->post('vessel_class_mal_name');
			$vessel_class_code 			= 	$this->input->post('vessel_class_code');
			$chkduplication	=$this->Master_model->check_duplication_vessel_class($vessel_class_name,$vessel_class_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($vessel_class_ins=="Save Vessel Class")
				{
					$data 			= 	array(
					'vessel_class_name' 		=>	$vessel_class_name,  
					'vessel_class_mal_name' 	=> 	$vessel_class_mal_name,
					'vessel_class_code' 		=> 	$vessel_class_code,
					'vessel_class_status'		=>	'1',
					'vessel_class_created_user_id'	=> 	$sess_usr_id,
					'vessel_class_created_timestamp'=>	$date,
					'vessel_class_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_vessel_class_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Vessel Class successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Vessel Class Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Vessel Class ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Vessel Class starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_vessel_class()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'vessel_class', 'page' => 'vessel_class', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('vessel_class_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_vessel_class_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		

	
//Status Vessel Class ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
//____________________________________________________________________________________________________________________________________________	

// Delete Vessel Class starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_vessel_class()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'vessel_class', 'page' => 'vessel_class', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_vessel_class($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Vessel Class starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_vessel_class()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'vessel_class', 'page' => 'vessel_class', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_vessel_class', 'Vessel class Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_vessel_class_code', 'Vessel class Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_vessel_class 	= 	$this->input->post('edit_vessel_class');
			$edit_vessel_class_mal 	= 	$this->input->post('edit_vessel_class_mal');
			$edit_vessel_class_code	= 	$this->input->post('edit_vessel_class_code');
			$edit_vessel_class	= 	$this->security->xss_clean($edit_vessel_class);
			/*Edited on 14-06-2018  Start*/	//$chkduplication		=	$this->Master_model->check_duplication_vessel_class($edit_vessel_class);
			$chkduplication	=$this->Master_model->check_duplication_vessel_class_edit($edit_vessel_class,$edit_vessel_class_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'vessel_class_name' 		 =>	$edit_vessel_class,  
				'vessel_class_mal_name' 	 => 	$edit_vessel_class_mal,
				'vessel_class_code' 		 => 	$edit_vessel_class_code,
				'vessel_class_modified_user_id'	 =>	$sess_usr_id,
				'vessel_class_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_vessel_class($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Vessel Class Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Vessel Class Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Vessel Class ends.	
/*____________________________________________________________________________________________________________________________________________*/	


/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Location

//____________________________________________________________________________________________________________________________________________	

// List Location starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function location()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'location', 'page' => 'location', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$location		= 	$this->Master_model->get_location();
		$data['location']	=	$location;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/location',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Location end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Location starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_location()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'location', 'page' => 'location', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('location_name', 'Location Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('location_code', 'Location Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$location_ins 			= 	$this->input->post('location_ins');
			$location_name			= 	$this->input->post('location_name');
			$location_mal_name 		= 	$this->input->post('location_mal_name');
			$location_code 			= 	$this->input->post('location_code');
			$chkduplication=$this->Master_model->check_duplication_location_insert($location_name,$location_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($location_ins=="Save Location")
				{
					$data 			= 	array(
					'location_name' 		=>	$location_name,  
					'location_mal_name' 	=> 	$location_mal_name,
					'location_code' 		=> 	$location_code,
					'location_status'		=>	'1',
					'location_created_user_id'	=> 	$sess_usr_id,
					'location_created_timestamp'=>	$date,
					'location_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_location_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Location successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Location Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Location ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Location starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_location()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'location', 'page' => 'location', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
		$updstat 		= 	0;
		}
		else
		{
		$updstat 		= 	1;
		}
		$data =	array('location_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_location_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		

	
//Status Location ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

//____________________________________________________________________________________________________________________________________________	

// Delete Location starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_location()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'location', 'page' => 'location', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_location($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Location starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_location()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'location', 'page' => 'location', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_location', 'Location Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_location_code', 'Location Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_location 	= 	$this->input->post('edit_location');
			$edit_location_mal 	= 	$this->input->post('edit_location_mal');
			$edit_location_code	= 	$this->input->post('edit_location_code');
			$edit_location	= 	$this->security->xss_clean($edit_location);
			/*Edited on 14-06-2018  Start*/	
			//$chkduplication		=	$this->Master_model->check_duplication_location($edit_location);
			$chkduplication	=$this->Master_model->check_duplication_location_edit($edit_location,$edit_location_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'location_name' 		 =>	$edit_location,  
				'location_mal_name' 	 	 => 	$edit_location_mal,
				'location_code' 		 => 	$edit_location_code,
				'location_modified_user_id'	 =>	$sess_usr_id,
				'location_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_location($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Location Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Location Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Location ends.	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Metric

//____________________________________________________________________________________________________________________________________________	

// List Metric starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function metric()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'metric', 'page' => 'metric', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$metric		= 	$this->Master_model->get_metric();
		$data['metric']	=	$metric;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/metric',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');              
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Metric end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Metric starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_metric()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'metric', 'page' => 'metric', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('metric_name', 'Metric Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('metric_code', 'Metric Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$metric_ins 			= 	$this->input->post('metric_ins');
			$metric_name			= 	$this->input->post('metric_name');
			$metric_mal_name 		= 	$this->input->post('metric_mal_name');
			$metric_code 			= 	$this->input->post('metric_code');
			$chkduplication	=$this->Master_model->check_duplication_metric_insert($metric_name,$metric_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($metric_ins=="Save Metric")
				{
					$data 			= 	array(
					'metric_name' 		=>	$metric_name,  
					'metric_mal_name' 	=> 	$metric_mal_name,
					'metric_code' 		=> 	$metric_code,
					'metric_status'		=>	'1',
					'metric_created_user_id'	=> 	$sess_usr_id,
					'metric_created_timestamp'=>	$date,
					'metric_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_metric_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Metric successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Metric Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	
//Add Metric ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Metric starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_metric()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'metric', 'page' => 'metric', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('metric_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_metric_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
//Status Metric ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
//____________________________________________________________________________________________________________________________________________	

// Delete Metric starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_metric()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'metric', 'page' => 'metric', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_metric($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Metric starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_metric()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'metric', 'page' => 'metric', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_metric', 'Metric Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_metric_code', 'Metric Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_metric 	= 	$this->input->post('edit_metric');
			$edit_metric_mal 	= 	$this->input->post('edit_metric_mal');
			$edit_metric_code	= 	$this->input->post('edit_metric_code');
			$edit_metric		= 	$this->security->xss_clean($edit_metric);
			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_metric_edit($edit_metric,$edit_metric_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'metric_name' 		 =>	$edit_metric,  
				'metric_mal_name' 	 => 	$edit_metric_mal,
				'metric_code' 		 => 	$edit_metric_code,
				'metric_modified_user_id' =>	$sess_usr_id,
				'metric_modified_ipaddress'=>	$ip	);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_metric($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Metric Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Metric Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}		

//Edit Metric ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Rule

//____________________________________________________________________________________________________________________________________________	

// List Rule starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function rule()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'rule', 'page' => 'rule', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$rule		= 	$this->Master_model->get_rule();
		$data['rule']	=	$rule;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/rule',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');   
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Rule end
/*____________________________________________________________________________________________________________________________________________*/	

//____________________________________________________________________________________________________________________________________________	

// Add Rule starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_rule()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'rule', 'page' => 'rule', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('rule_name', 'Rule Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('rule_code', 'Rule Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$rule_ins 			= 	$this->input->post('rule_ins');
			$rule_name			= 	$this->input->post('rule_name');
			$rule_mal_name 			= 	$this->input->post('rule_mal_name');
			$rule_code 			= 	$this->input->post('rule_code');
			$chkduplication=$this->Master_model->check_duplication_rule_insert($rule_name,$rule_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($rule_ins=="Save Rule")
				{
					$data 			= 	array(
					'rule_name' 		=>	$rule_name,  
					'rule_mal_name' 	=> 	$rule_mal_name,
					'rule_code' 		=> 	$rule_code,
					'rule_status'		=>	'1',
					'rule_created_user_id'	=> 	$sess_usr_id,
					'rule_created_timestamp'=>	$date,
					'rule_created_ipaddress'=>	$ip	);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_rule_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Rule successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Rule Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Rule ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Rule starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function status_rule()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'rule', 'page' => 'rule', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('rule_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_rule_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
//Status Rule ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
//____________________________________________________________________________________________________________________________________________	

// Delete Rule starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function delete_rule()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'rule', 'page' => 'rule', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_rule($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}

//____________________________________________________________________________________________________________________________________________	

// Edit Rule starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_rule()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'rule', 'page' => 'rule', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_rule', 'Rule Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_rule_code', 'Rule Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_rule 	= 	$this->input->post('edit_rule');
			$edit_rule_mal 	= 	$this->input->post('edit_rule_mal');
			$edit_rule_code	= 	$this->input->post('edit_rule_code');
			$edit_rule	= 	$this->security->xss_clean($edit_rule);
			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_rule_edit($edit_rule,$edit_rule_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'rule_name' 		 =>	$edit_rule,  
				'rule_mal_name' 	 => 	$edit_rule_mal,
				'rule_code' 		 => 	$edit_rule_code,
				'rule_modified_user_id'	 =>	$sess_usr_id,
				'rule_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_rule($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Rule Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Rule Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Rule ends.	
/*____________________________________________________________________________________________________________________________________________*/	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Inspection
//____________________________________________________________________________________________________________________________________________	

// List Inspection starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function inspection()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'inspection', 'page' => 'inspection', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$inspection		= 	$this->Master_model->get_inspection();
		$data['inspection']	=	$inspection;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/inspection',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Inspection end
/*____________________________________________________________________________________________________________________________________________*/	

//____________________________________________________________________________________________________________________________________________	

// Add Inspection starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_inspection()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'inspection', 'page' => 'inspection', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('inspection_name', 'Inspection Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('inspection_code', 'Inspection Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
		$inspection_ins 			= 	$this->input->post('inspection_ins');
		$inspection_name			= 	$this->input->post('inspection_name');
		$inspection_mal_name 			= 	$this->input->post('inspection_mal_name');
		$inspection_code 			= 	$this->input->post('inspection_code');
		$chkduplication	=$this->Master_model->check_duplication_inspection_insert($inspection_name,$inspection_code); 
		$cntrows				=	count($chkduplication);
		if($cntrows==0)
		{
			if($inspection_ins=="Save Inspection")
			{
				$data 			= 	array(
				'inspection_name' 		=>	$inspection_name,  
				'inspection_mal_name' 	=> 	$inspection_mal_name,
				'inspection_code' 		=> 	$inspection_code,
				'inspection_status'		=>	'1',
				'inspection_created_user_id'	=> 	$sess_usr_id,
				'inspection_created_timestamp'=>	$date,
				'inspection_created_ipaddress'=>	$ip);
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$usr_res	=	$this->db->insert('kiv_inspection_master', $data);
				if($usr_res)
				{
					echo json_encode(array("val_errors" => ""));
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Inspection successfully Added!!!</div>');
				}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Inspection Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Inspection ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//____________________________________________________________________________________________________________________________________________	

// Status Inspection starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_inspection()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'inspection', 'page' => 'inspection', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('inspection_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_inspection_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Inspection ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//____________________________________________________________________________________________________________________________________________	

// Delete Inspection starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_inspection()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'inspection', 'page' => 'inspection', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}

		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_inspection($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Inspection starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_inspection()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'inspection', 'page' => 'inspection', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_inspection', 'Inspection Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_inspection_code', 'Inspection Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_inspection 	= 	$this->input->post('edit_inspection');
			$edit_inspection_mal 	= 	$this->input->post('edit_inspection_mal');
			$edit_inspection_code	= 	$this->input->post('edit_inspection_code');

			$edit_inspection	= 	$this->security->xss_clean($edit_inspection);

			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_inspection_edit($edit_inspection,$edit_inspection_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'inspection_name' 		 =>	$edit_inspection,  
				'inspection_mal_name' 	 => 	$edit_inspection_mal,
				'inspection_code' 		 => 	$edit_inspection_code,
				'inspection_modified_user_id'	 =>	$sess_usr_id,
				'inspection_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_inspection($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Inspection Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Inspection Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Inspection ends.	
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Engine Class
//____________________________________________________________________________________________________________________________________________	

// List Engine Class starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function engine_class()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'engine_class', 'page' => 'engine_class', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$engine_class		= 	$this->Master_model->get_engine_class();
		$data['engine_class']	=	$engine_class;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/engine_class',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');             
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Engine Class end
/*____________________________________________________________________________________________________________________________________________*/	

//____________________________________________________________________________________________________________________________________________	

// Add Engine Class starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function add_engine_class()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'engine_class', 'page' => 'engine_class', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('engine_class_name', 'Engine Class Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('engine_class_code', 'Engine Class Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$engine_class_ins 			= 	$this->input->post('engine_class_ins');
			$engine_class_name			= 	$this->input->post('engine_class_name');
			$engine_class_mal_name 			= 	$this->input->post('engine_class_mal_name');
			$engine_class_code 			= 	$this->input->post('engine_class_code');
			$chkduplication=$this->Master_model->check_duplication_engine_class_insert($engine_class_name,$engine_class_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($engine_class_ins=="Save Engine Class")
				{
					$data 			= 	array(
					'engine_class_name' 		=>	$engine_class_name,  
					'engine_class_mal_name' 	=> 	$engine_class_mal_name,
					'engine_class_code' 		=> 	$engine_class_code,
					'engine_class_status'		=>	'1',
					'engine_class_created_user_id'	=> 	$sess_usr_id,
					'engine_class_created_timestamp'=>	$date,
					'engine_class_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_engine_class_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Engine Class successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Engine Class Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Engine Class ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//____________________________________________________________________________________________________________________________________________	

// Status Engine Class starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_engine_class()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'engine_class', 'page' => 'engine_class', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('engine_class_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_engine_class_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
		
//Status Engine Class ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
//____________________________________________________________________________________________________________________________________________	

// Delete Engine Class starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_engine_class()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'engine_class', 'page' => 'engine_class', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_engine_class($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Engine Class starting...  (11-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_engine_class()
{
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'engine_class', 'page' => 'engine_class', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_engine_class', 'Engine class Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_engine_class_code', 'Engine class Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_engine_class 	= 	$this->input->post('edit_engine_class');
			$edit_engine_class_mal 	= 	$this->input->post('edit_engine_class_mal');
			$edit_engine_class_code	= 	$this->input->post('edit_engine_class_code');
			$edit_engine_class	= 	$this->security->xss_clean($edit_engine_class);
			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_engine_class_edit($edit_engine_class,$edit_engine_class_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'engine_class_name' 		 =>	$edit_engine_class,  
				'engine_class_mal_name' 	 => 	$edit_engine_class_mal,
				'engine_class_code' 		 => 	$edit_engine_class_code,
				'engine_class_modified_user_id'	 =>	$sess_usr_id,
				'engine_class_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_engine_class($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Engine Class Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Engine Class Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Engine Class ends.	
/*____________________________________________________________________________________________________________________________________________*/	


//                                                             User

//____________________________________________________________________________________________________________________________________________	

// List User starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function user()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'user', 'page' => 'user', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$user		= 	$this->Master_model->get_user();
		$data['user']	=	$user;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/user',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List User end
/*____________________________________________________________________________________________________________________________________________*/	

//____________________________________________________________________________________________________________________________________________	

// Add User starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
/*
public function add_user()
{
$sess_usr_id 	= 	1;
$ip		=	$_SERVER['REMOTE_ADDR'];
date_default_timezone_set("Asia/Kolkata");
$date 			= 	date('Y-m-d h:i:s', time());
if(!empty($sess_usr_id))
{	
$data =	array('title' => 'user', 'page' => 'user', 'errorCls' => NULL, 'post' => $this->input->post());
$data = $data + $this->data;

//set validation rules
$this->form_validation->set_rules('user_name', 'User Name', 'required|callback_alphaonly_check');
$this->form_validation->set_rules('user_password', 'User Password', 'required|callback_alphaonly_check');

if ($this->form_validation->run() == FALSE)
{
//fail validation
$valErrors				= 	validation_errors();
echo json_encode(array("val_errors" => $valErrors));
exit;
} 
else 
{ 
$user_ins 			= 	$this->input->post('user_ins');
$user_name			= 	$this->input->post('user_name');
$user_mal_name 			= 	$this->input->post('user_mal_name');
$user_password 			= 	$this->input->post('user_password');
$chkduplication				=	$this->Master_model->check_duplication_user($user_name); 
$cntrows				=	count($chkduplication);
if($cntrows==0)
{
if($user_ins=="Save User")
{
$data 			= 	array(
'user_name' 		=>	$user_name,  
'user_mal_name' 	=> 	$user_mal_name,
'user_password' 		=> 	$user_password,
'user_status'		=>	'0',
'user_created_user_id'	=> 	$sess_usr_id,
'user_created_timestamp'=>	$date,
'user_created_ipaddress'=>	$ip);
$data = $this->security->xss_clean($data);
//insert the form data into database
$usr_res	=	$this->db->insert('kiv_user_master', $data);
if($usr_res)
{
echo json_encode(array("val_errors" => ""));
$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User successfully Added!!!</div>');
}
}
} 
else 
{
echo json_encode(array("val_errors" => "User Already Exists!!!"));
}
}
}
else
{
redirect('Main_login/index');        
}  
}	

*/

//Add User ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status User starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_user()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'user', 'page' => 'user', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('user_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_user_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
//Status User ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//____________________________________________________________________________________________________________________________________________	

// Delete User starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function delete_user()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'user', 'page' => 'user', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_user($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit User starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_user()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'user', 'page' => 'user', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_user', 'User Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_user_password', 'User Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_user 		= 	$this->input->post('edit_user');
			$edit_user_password	= 	$this->input->post('edit_user_password');
			$edit_user		= 	$this->security->xss_clean($edit_user);
			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_user_edit($edit_user,$edit_user_password,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'user_name' 		 =>	$edit_user,
				'user_password' 	 => 	$edit_user_password,
				'user_modified_user_id'	 =>	$sess_usr_id,
				'user_modified_ipaddress'=>	$ip	);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_user($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "User Name/Password  Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit User ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//                                                             User Type

//____________________________________________________________________________________________________________________________________________	

// List User Type starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function user_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'user_type', 'page' => 'user_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$user_type		= 	$this->Master_model->get_user_type();
		$data['user_type']	=	$user_type;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/user_type',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');        
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List User Type end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add User Type starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_user_type()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'user_type', 'page' => 'user_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('user_type_name', 'User Type Name', 'required|callback_alphaonly_check');
		//$this->form_validation->set_rules('user_type_code', 'User Type Code', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$user_type_ins 			= 	$this->input->post('user_type_ins');
			$user_type_name			= 	$this->input->post('user_type_name');
			//$user_type_mal_name 		= 	$this->input->post('user_type_mal_name');
			//$user_type_code 		= 	$this->input->post('user_type_code');
			$chkduplication			=	$this->Master_model->check_duplication_user_type($user_type_name); 
			$cntrows			=	count($chkduplication);
			if($cntrows==0)
			{
				if($user_type_ins=="Save User Type")
				{
					$data 			= 	array(
					'user_type_type_name' 		=>	$user_type_name,
					'user_type_status'		=>	'1',
					'user_type_user_id'	=> 	$sess_usr_id,
					'user_type_timestamp'=>	$date
					//'user_type_created_ipaddress'=>	$ip
					);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('user_type', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User Type successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "User Type Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add User Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status User Type starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_user_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'user_type', 'page' => 'user_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('user_type_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_user_type_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status User Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
//____________________________________________________________________________________________________________________________________________	

// Delete User Type starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_user_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'user_type', 'page' => 'user_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_user_type($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit User Type starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_user_type()
{
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'user_type', 'page' => 'user_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_user_type', 'User Type Name', 'required|callback_alphaonly_check');
		//$this->form_validation->set_rules('edit_user_type_code', 'user_type Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_user_type 	= 	$this->input->post('edit_user_type');
			//$edit_user_type_mal 	= 	$this->input->post('edit_user_type_mal');
			//$edit_user_type_code	= 	$this->input->post('edit_user_type_code');
			$edit_user_type	= 	$this->security->xss_clean($edit_user_type);
			$chkduplication		=	$this->Master_model->check_duplication_user_type($edit_user_type);
			/*Edited on 14-06-2018  Start*/	//$chkduplication	=	$this->Master_model->check_duplication_vessel_subtypename($edit_vessel_subtype);
			//$chkduplication	=$this->Master_model->check_duplication_portofregistry_edit($edit_vessel_subtype,$edit_vessel_subtype_code,$edit_vessel_subtype_mal,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array('user_type_type_name' =>	$edit_user_type	);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_user_type($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User Type Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "User Type Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit User Type ends.	
/*____________________________________________________________________________________________________________________________________________*/	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Navigation Light Master

//____________________________________________________________________________________________________________________________________________	

// List Navigation Light Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function navgn_light()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'navgn_light', 'page' => 'navgn_light', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$navgn_light		= 	$this->Master_model->get_navgn_light();
		$data['navgn_light']	=	$navgn_light;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/navgn_light',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Navigation Light Master end
/*____________________________________________________________________________________________________________________________________________*/	
//____________________________________________________________________________________________________________________________________________	

// Add Navigation Light Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_navgn_light()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'navgn_light', 'page' => 'navgn_light', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('navgn_light_name', 'Navigation Light Master Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('navgn_light_code', 'Navigation Light Master Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$navgn_light_ins 			= 	$this->input->post('navgn_light_ins');
			$navgn_light_name			= 	$this->input->post('navgn_light_name');
			$navgn_light_mal_name 			= 	$this->input->post('navgn_light_mal_name');
			$navgn_light_code 			= 	$this->input->post('navgn_light_code');
			$chkduplication				=	$this->Master_model->check_duplication_navgn_light_insert($navgn_light_name,$navgn_light_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($navgn_light_ins=="Save Navigation Light")
				{
					$data 			= 	array(
					'navgn_light_name' 		=>	$navgn_light_name,  
					'navgn_light_mal_name' 	=> 	$navgn_light_mal_name,
					'navgn_light_code' 		=> 	$navgn_light_code,
					'navgn_light_status'		=>	'1',
					'navgn_light_created_user_id'	=> 	$sess_usr_id,
					'navgn_light_created_timestamp'=>	$date,
					'navgn_light_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_navgn_light_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Navigation Light Master successfully Added!!!</div>');
					}
				}
			} 
			else
			{
				echo json_encode(array("val_errors" => "Navigation Light Master Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Navigation Light Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Navigation Light Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function status_navgn_light()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'navgn_light', 'page' => 'navgn_light', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('navgn_light_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_navgn_light_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
		
//Status Navigation Light Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
//____________________________________________________________________________________________________________________________________________	

// Delete Navigation Light Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_navgn_light()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'navgn_light', 'page' => 'navgn_light', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_navgn_light($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Navigation Light Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_navgn_light()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'navgn_light', 'page' => 'navgn_light', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_navgn_light', 'Navigation light Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_navgn_light_code', 'Navigation light Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_navgn_light 	= 	$this->input->post('edit_navgn_light');
			$edit_navgn_light_mal 	= 	$this->input->post('edit_navgn_light_mal');
			$edit_navgn_light_code	= 	$this->input->post('edit_navgn_light_code');
			$edit_navgn_light	= 	$this->security->xss_clean($edit_navgn_light);
			//$chkduplication		=	$this->Master_model->check_duplication_navgn_light($edit_navgn_light);
			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_navgn_light_edit($edit_navgn_light,$edit_navgn_light_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'navgn_light_name' 		 =>	$edit_navgn_light,  
				'navgn_light_mal_name' 	 => 	$edit_navgn_light_mal,
				'navgn_light_code' 		 => 	$edit_navgn_light_code,
				'navgn_light_modified_user_id'	 =>	$sess_usr_id,
				'navgn_light_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_navgn_light($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Navigation Light Master Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Navigation Light Master Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Navigation Light Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//                                                             Sound Signal Master

//____________________________________________________________________________________________________________________________________________	

// List Sound Signal Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function sound_signal()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'sound_signal', 'page' => 'sound_signal', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$sound_signal		= 	$this->Master_model->get_sound_signal();
		$data['sound_signal']	=	$sound_signal;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/sound_signal',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Sound Signal Master end
/*____________________________________________________________________________________________________________________________________________*/	

// Add Sound Signal Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_sound_signal()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'sound_signal', 'page' => 'sound_signal', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('sound_signal_name', 'Sound Signal Master Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('sound_signal_code', 'Sound Signal Master Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$sound_signal_ins 			= 	$this->input->post('sound_signal_ins');
			$sound_signal_name			= 	$this->input->post('sound_signal_name');
			$sound_signal_mal_name 			= 	$this->input->post('sound_signal_mal_name');
			$sound_signal_code 			= 	$this->input->post('sound_signal_code');
			$chkduplication				=	$this->Master_model->check_duplication_sound_signal_insert($sound_signal_name,$sound_signal_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($sound_signal_ins=="Save Sound Signal")
				{
					$data 			= 	array(
					'sound_signal_name' 		=>	$sound_signal_name,  
					'sound_signal_mal_name' 	=> 	$sound_signal_mal_name,
					'sound_signal_code' 		=> 	$sound_signal_code,
					'sound_signal_status'		=>	'1',
					'sound_signal_created_user_id'	=> 	$sess_usr_id,
					'sound_signal_created_timestamp'=>	$date,
					'sound_signal_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_sound_signal_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Sound Signal Master successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Sound Signal Master Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Sound Signal Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Sound Signal Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_sound_signal()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'sound_signal', 'page' => 'sound_signal', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('sound_signal_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_sound_signal_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
//Status Sound Signal Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
// Delete Sound Signal Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_sound_signal()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'sound_signal', 'page' => 'sound_signal', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_sound_signal($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Sound Signal Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_sound_signal()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'sound_signal', 'page' => 'sound_signal', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_sound_signal', 'Sound signal Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_sound_signal_code', 'Sound signal Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_sound_signal 	= 	$this->input->post('edit_sound_signal');
			$edit_sound_signal_mal 	= 	$this->input->post('edit_sound_signal_mal');
			$edit_sound_signal_code	= 	$this->input->post('edit_sound_signal_code');
			$edit_sound_signal	= 	$this->security->xss_clean($edit_sound_signal);
			/*Edited on 14-06-2018  Start*/
			$chkduplication	=$this->Master_model->check_duplication_sound_signal_edit($edit_sound_signal,$edit_sound_signal_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'sound_signal_name' 		 =>	$edit_sound_signal,  
				'sound_signal_mal_name' 	 => 	$edit_sound_signal_mal,
				'sound_signal_code' 		 => 	$edit_sound_signal_code,
				'sound_signal_modified_user_id'	 =>	$sess_usr_id,
				'sound_signal_modified_ipaddress'=>	$ip	);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_sound_signal($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Sound Signal Master Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Sound Signal Master Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Sound Signal Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Insurance Type Master

//____________________________________________________________________________________________________________________________________________	

// List Insurance Type Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function insurance_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'insurance_type', 'page' => 'insurance_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$insurance_type		= 	$this->Master_model->get_insurance_type();
		$data['insurance_type']	=	$insurance_type;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/insurance_type',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');        
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Insurance Type Master end
/*____________________________________________________________________________________________________________________________________________*/	

//____________________________________________________________________________________________________________________________________________	

// Add Insurance Type Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_insurance_type()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'insurance_type', 'page' => 'insurance_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('insurance_type_name', 'Insurance Type Master Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('insurance_type_code', 'Insurance Type Master Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$insurance_type_ins 			= 	$this->input->post('insurance_type_ins');
			$insurance_type_name			= 	$this->input->post('insurance_type_name');
			$insurance_type_mal_name 		= 	$this->input->post('insurance_type_mal_name');
			$insurance_type_code 			= 	$this->input->post('insurance_type_code');
			$chkduplication				=	$this->Master_model->check_duplication_insurance_type_insert($insurance_type_name,$insurance_type_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($insurance_type_ins=="Save Insurance Type")
				{
					$data 			= 	array(
					'insurance_type_name' 		=>	$insurance_type_name,  
					'insurance_type_mal_name' 	=> 	$insurance_type_mal_name,
					'insurance_type_code' 		=> 	$insurance_type_code,
					'insurance_type_status'		=>	'1',
					'insurance_type_created_user_id'	=> 	$sess_usr_id,
					'insurance_type_created_timestamp'=>	$date,
					'insurance_type_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_insurance_type_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Insurance Type Master successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Insurance Type Name/Code Master Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Insurance Type Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Insurance Type Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_insurance_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'insurance_type', 'page' => 'insurance_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('insurance_type_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_insurance_type_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Insurance Type Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//____________________________________________________________________________________________________________________________________________	

// Delete Insurance Type Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_insurance_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'insurance_type', 'page' => 'insurance_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_insurance_type($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Insurance Type Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_insurance_type()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'insurance_type', 'page' => 'insurance_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_insurance_type', 'Insurance type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_insurance_type_code', 'Insurance type Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{ 
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_insurance_type 	= 	$this->input->post('edit_insurance_type');
			$edit_insurance_type_mal 	= 	$this->input->post('edit_insurance_type_mal');
			$edit_insurance_type_code	= 	$this->input->post('edit_insurance_type_code');
			$edit_insurance_type	= 	$this->security->xss_clean($edit_insurance_type);
			/*Edited on 14-06-2018  Start*/
			$chkduplication	=$this->Master_model->check_duplication_insurance_type_edit($edit_insurance_type,$edit_insurance_type_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'insurance_type_name' 		 =>	$edit_insurance_type,  
				'insurance_type_mal_name' 	 => 	$edit_insurance_type_mal,
				'insurance_type_code' 		 => 	$edit_insurance_type_code,
				'insurance_type_modified_user_id'	 =>	$sess_usr_id,
				'insurance_type_modified_ipaddress'=>	$ip	);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_insurance_type($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Insurance Type Master Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Insurance Type Master Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Insurance Type Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//                                                             Hull Plating Material Master

//____________________________________________________________________________________________________________________________________________	

// List Hull Plating Material Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function hullplating_material()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'hullplating_material', 'page' => 'hullplating_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$hullplating_material		= 	$this->Master_model->get_hullplating_material();
		$data['hullplating_material']	=	$hullplating_material;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/hullplating_material',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');         
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Hull Plating Material Master end
/*____________________________________________________________________________________________________________________________________________*/	


// Add Hull Plating Material Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_hullplating_material()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'hullplating_material', 'page' => 'hullplating_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('hullplating_material_name', 'Hull Plating Material Master Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('hullplating_material_code', 'Hull Plating Material Master Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$hullplating_material_ins 			= 	$this->input->post('hullplating_material_ins');
			$hullplating_material_name			= 	$this->input->post('hullplating_material_name');
			$hullplating_material_mal_name 			= 	$this->input->post('hullplating_material_mal_name');
			$hullplating_material_code 			= 	$this->input->post('hullplating_material_code');
			$chkduplication=$this->Master_model->check_duplication_hullplating_material_insert($hullplating_material_name,$hullplating_material_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($hullplating_material_ins=="Save Hull Plating Material")
				{
					$data 			= 	array(
					'hullplating_material_name' 		=>	$hullplating_material_name,  
					'hullplating_material_mal_name' 	=> 	$hullplating_material_mal_name,
					'hullplating_material_code' 		=> 	$hullplating_material_code,
					'hullplating_material_status'		=>	'1',
					'hullplating_material_created_user_id'	=> 	$sess_usr_id,
					'hullplating_material_created_timestamp'=>	$date,
					'hullplating_material_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_hullplating_material_master', $data);
					if($usr_res)
						{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Hull Plating Material Master successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Hull Plating Material Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Hull Plating Material Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Hull Plating Material Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_hullplating_material()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'hullplating_material', 'page' => 'hullplating_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('hullplating_material_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_hullplating_material_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Hull Plating Material Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
// Delete Hull Plating Material Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_hullplating_material()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'hullplating_material', 'page' => 'hullplating_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_hullplating_material($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Hull Plating Material Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_hullplating_material()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'hullplating_material', 'page' => 'hullplating_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_hullplating_material', 'Hull plating material Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_hullplating_material_code', 'Hull plating material Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_hullplating_material 	= 	$this->input->post('edit_hullplating_material');
			$edit_hullplating_material_mal 	= 	$this->input->post('edit_hullplating_material_mal');
			$edit_hullplating_material_code	= 	$this->input->post('edit_hullplating_material_code');
			$edit_hullplating_material	= 	$this->security->xss_clean($edit_hullplating_material);

			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_hullplating_material_edit($edit_hullplating_material,$edit_hullplating_material_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'hullplating_material_name' 		 =>	$edit_hullplating_material,  
				'hullplating_material_mal_name' 	 => 	$edit_hullplating_material_mal,
				'hullplating_material_code' 		 => 	$edit_hullplating_material_code,
				'hullplating_material_modified_user_id'	 =>	$sess_usr_id,
				'hullplating_material_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_hullplating_material($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Hull Plating Material Master Updated Successfully!!!</div>');
				}
			}
			else 
			{ 
				echo json_encode(array("val_errors" => "Hull Plating Material Master Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Hull Plating Material Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Equipment Type Master

//____________________________________________________________________________________________________________________________________________	

// List Equipment Type Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function equipment_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment_type', 'page' => 'equipment_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$equipment_type		= 	$this->Master_model->get_equipment_type();
		$data['equipment_type']	=	$equipment_type;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/equipment_type',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Equipment Type Master end
/*____________________________________________________________________________________________________________________________________________*/	

// Add Equipment Type Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_equipment_type()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment_type', 'page' => 'equipment_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('equipment_type_name', 'Equipment Type Master Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('equipment_type_code', 'Equipment Type Master Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$equipment_type_ins 			= 	$this->input->post('equipment_type_ins');
			$equipment_type_name			= 	$this->input->post('equipment_type_name');
			$equipment_type_mal_name 			= 	$this->input->post('equipment_type_mal_name');
			$equipment_type_code 			= 	$this->input->post('equipment_type_code');
			$chkduplication				=	$this->Master_model->check_duplication_equipment_type_insert($equipment_type_name,$equipment_type_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($equipment_type_ins=="Save Equipment Type")
				{
					$data 			= 	array(
					'equipment_type_name' 		=>	$equipment_type_name,  
					'equipment_type_mal_name' 	=> 	$equipment_type_mal_name,
					'equipment_type_code' 		=> 	$equipment_type_code,
					'equipment_type_status'		=>	'1',
					'equipment_type_created_user_id'	=> 	$sess_usr_id,
					'equipment_type_created_timestamp'=>	$date,
					'equipment_type_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_equipment_type_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Equipment Type Master successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Equipment Type Master Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	



//Add Equipment Type Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Equipment Type Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_equipment_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment_type', 'page' => 'equipment_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('equipment_type_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_equipment_type_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Equipment Type Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
// Delete Equipment Type Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_equipment_type()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'equipment_type', 'page' => 'equipment_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_equipment_type($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Equipment Type Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_equipment_type()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment_type', 'page' => 'equipment_type', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_equipment_type', 'Equipment Type Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_equipment_type_code', 'Equipment Type Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_equipment_type 	= 	$this->input->post('edit_equipment_type');
			$edit_equipment_type_mal 	= 	$this->input->post('edit_equipment_type_mal');
			$edit_equipment_type_code	= 	$this->input->post('edit_equipment_type_code');
			$edit_equipment_type	= 	$this->security->xss_clean($edit_equipment_type);
			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_equipment_type_edit($edit_equipment_type,$edit_equipment_type_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'equipment_type_name' 		 =>	$edit_equipment_type,  
				'equipment_type_mal_name' 	 => 	$edit_equipment_type_mal,
				'equipment_type_code' 		 => 	$edit_equipment_type_code,
				'equipment_type_modified_user_id'	 =>	$sess_usr_id,
				'equipment_type_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_equipment_type($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Equipment Type Master Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Equipment Type Master Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Equipment Type Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	


//                                                             Equipment Material Master

//____________________________________________________________________________________________________________________________________________	

// List Equipment Material Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function equipment_material()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment_material', 'page' => 'equipment_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$equipment_material		= 	$this->Master_model->get_equipment_material();
		$data['equipment_material']	=	$equipment_material;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/equipment_material',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');        
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Equipment Material Master end
/*____________________________________________________________________________________________________________________________________________*/	


// Add Equipment Material Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_equipment_material()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment_material', 'page' => 'equipment_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('equipment_material_name', 'Equipment Material Master Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('equipment_material_code', 'Equipment Material Master Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$equipment_material_ins 			= 	$this->input->post('equipment_material_ins');
			$equipment_material_name			= 	$this->input->post('equipment_material_name');
			$equipment_material_mal_name 			= 	$this->input->post('equipment_material_mal_name');
			$equipment_material_code 			= 	$this->input->post('equipment_material_code');
			$chkduplication	=$this->Master_model->check_duplication_equipment_material_insert($equipment_material_name,$equipment_material_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($equipment_material_ins=="Save Equipment Material")
				{
					$data 			= 	array(
					'equipment_material_name' 		=>	$equipment_material_name,  
					'equipment_material_mal_name' 	=> 	$equipment_material_mal_name,
					'equipment_material_code' 		=> 	$equipment_material_code,
					'equipment_material_status'		=>	'1',
					'equipment_material_created_user_id'	=> 	$sess_usr_id,
					'equipment_material_created_timestamp'=>	$date,
					'equipment_material_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_equipment_material_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Equipment Material Master successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
					echo json_encode(array("val_errors" => "Equipment Material Master Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Equipment Material Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Equipment Material Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_equipment_material()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment_material', 'page' => 'equipment_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('equipment_material_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_equipment_material_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Equipment Material Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
// Delete Equipment Material Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_equipment_material()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'equipment_material', 'page' => 'equipment_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_equipment_material($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Equipment Material Master starting...  (12-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_equipment_material()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'equipment_material', 'page' => 'equipment_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_equipment_material', 'Equipment material Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_equipment_material_code', 'Equipment material Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_equipment_material 	= 	$this->input->post('edit_equipment_material');
			$edit_equipment_material_mal 	= 	$this->input->post('edit_equipment_material_mal');
			$edit_equipment_material_code	= 	$this->input->post('edit_equipment_material_code');
			$edit_equipment_material	= 	$this->security->xss_clean($edit_equipment_material);

			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_equipment_material_edit($edit_equipment_material,$edit_equipment_material_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'equipment_material_name' 		 =>	$edit_equipment_material,  
				'equipment_material_mal_name' 	 	 => 	$edit_equipment_material_mal,
				'equipment_material_code' 		 => 	$edit_equipment_material_code,
				'equipment_material_modified_user_id'	 =>	$sess_usr_id,
				'equipment_material_modified_ipaddress'	 =>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_equipment_material($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Equipment Material Master Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Equipment Material Master Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Equipment Material Master ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//                                                             Propulsion Shaft Material

//____________________________________________________________________________________________________________________________________________	

// List Propulsion Shaft Material starting...  (13-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function propulsionshaft_material()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'propulsionshaft_material', 'page' => 'propulsionshaft_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$propulsionshaft_material		= 	$this->Master_model->get_propulsionshaft_material();
		$data['propulsionshaft_material']	=	$propulsionshaft_material;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/propulsionshaft_material',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Propulsion Shaft Material end
/*____________________________________________________________________________________________________________________________________________*/	

// Add Propulsion Shaft Material starting...  (13-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_propulsionshaft_material()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'propulsionshaft_material', 'page' => 'propulsionshaft_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('propulsionshaft_material_name', 'Propulsion Shaft Material Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('propulsionshaft_material_code', 'Propulsion Shaft Material Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$propulsionshaft_material_ins 			= 	$this->input->post('propulsionshaft_material_ins');
			$propulsionshaft_material_name			= 	$this->input->post('propulsionshaft_material_name');
			$propulsionshaft_material_mal_name 		= 	$this->input->post('propulsionshaft_material_mal_name');
			$propulsionshaft_material_code 			= 	$this->input->post('propulsionshaft_material_code');
			$chkduplication=$this->Master_model->check_duplication_propulsionshaft_material_insert($propulsionshaft_material_name,$propulsionshaft_material_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($propulsionshaft_material_ins=="Save Propulsion Shaft Material")
				{
					$data 			= 	array(
					'propulsionshaft_material_name' 		=>	$propulsionshaft_material_name,  
					'propulsionshaft_material_mal_name' 	=> 	$propulsionshaft_material_mal_name,
					'propulsionshaft_material_code' 		=> 	$propulsionshaft_material_code,
					'propulsionshaft_material_status'		=>	'1',
					'propulsionshaft_material_created_user_id'	=> 	$sess_usr_id,
					'propulsionshaft_material_created_timestamp'=>	$date,
					'propulsionshaft_material_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_propulsionshaft_material_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Propulsion Shaft Material successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Propulsion Shaft Material Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Propulsion Shaft Material ends.	
/*____________________________________________________________________________________________________________________________________________*/	

// Status Propulsion Shaft Material starting...  (13-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_propulsionshaft_material()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'propulsionshaft_material', 'page' => 'propulsionshaft_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('propulsionshaft_material_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_propulsionshaft_material_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Propulsion Shaft Material ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

// Delete Propulsion Shaft Material  starting...  (13-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_propulsionshaft_material()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'propulsionshaft_material', 'page' => 'propulsionshaft_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_propulsionshaft_material($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Propulsion Shaft Material  starting...  (13-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_propulsionshaft_material()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'propulsionshaft_material', 'page' => 'propulsionshaft_material', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_propulsionshaft_material', 'Propulsion shaft material Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_propulsionshaft_material_code', 'Propulsion shaft material Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_propulsionshaft_material 	= 	$this->input->post('edit_propulsionshaft_material');
			$edit_propulsionshaft_material_mal 	= 	$this->input->post('edit_propulsionshaft_material_mal');
			$edit_propulsionshaft_material_code	= 	$this->input->post('edit_propulsionshaft_material_code');
			$edit_propulsionshaft_material	= 	$this->security->xss_clean($edit_propulsionshaft_material);
			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_propulsionshaft_material_edit($edit_propulsionshaft_material,$edit_propulsionshaft_material_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'propulsionshaft_material_name' 	 =>	$edit_propulsionshaft_material,  
				'propulsionshaft_material_mal_name' 	 => 	$edit_propulsionshaft_material_mal,
				'propulsionshaft_material_code' 	 => 	$edit_propulsionshaft_material_code,
				'propulsionshaft_material_modified_user_id' =>	$sess_usr_id,
				'propulsionshaft_material_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_propulsionshaft_material($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Propulsion Shaft Material Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Propulsion Shaft Material Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Propulsion Shaft Material ends.	
/*____________________________________________________________________________________________________________________________________________*/	
//                                                             Garbage

//____________________________________________________________________________________________________________________________________________	

// List Garbage starting...  (14-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function garbage()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'garbage', 'page' => 'garbage', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$garbage		= 	$this->Master_model->get_garbage();
		$data['garbage']	=	$garbage;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/garbage',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Garbage end
/*____________________________________________________________________________________________________________________________________________*/	


//____________________________________________________________________________________________________________________________________________	

// Add Garbage starting...  (14-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_garbage()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'garbage', 'page' => 'garbage', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('garbage_name', 'Garbage Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('garbage_code', 'Garbage Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$garbage_ins 			= 	$this->input->post('garbage_ins');
			$garbage_name			= 	$this->input->post('garbage_name');
			$garbage_mal_name 		= 	$this->input->post('garbage_mal_name');
			$garbage_code 			= 	$this->input->post('garbage_code');
			$chkduplication=$this->Master_model->check_duplication_garbage_insert($garbage_name,$garbage_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($garbage_ins=="Save Garbage")
				{
					$data 			= 	array(
					'garbage_name' 		=>	$garbage_name,  
					'garbage_mal_name' 	=> 	$garbage_mal_name,
					'garbage_code' 		=> 	$garbage_code,
					'garbage_status'		=>	'1',
					'garbage_created_user_id'	=> 	$sess_usr_id,
					'garbage_created_timestamp'=>	$date,
					'garbage_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_garbage_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Garbage successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Garbage Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Garbage ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
//____________________________________________________________________________________________________________________________________________	

// Status Garbage starting...  (14-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_garbage()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'garbage', 'page' => 'garbage', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
		$updstat 		= 	0;
		}
		else
		{
		$updstat 		= 	1;
		}
		$data =	array('garbage_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_garbage_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Garbage ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

// Delete Garbage  starting...  (14-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function delete_garbage()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'garbage', 'page' => 'garbage', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_garbage($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Garbage  starting...  (14-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_garbage()
{
	$ip			    =	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'garbage', 'page' => 'garbage', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_garbage', 'Garbage Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_garbage_code', 'Garbage Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_garbage 		= 	$this->input->post('edit_garbage');
			$edit_garbage_mal 	= 	$this->input->post('edit_garbage_mal');
			$edit_garbage_code	= 	$this->input->post('edit_garbage_code');
			$edit_garbage	= 	$this->security->xss_clean($edit_garbage);
			/*Edited on 14-06-2018  Start*/	
			$chkduplication	=$this->Master_model->check_duplication_garbage_edit($edit_garbage,$edit_garbage_code,$id);
			/*End*/	
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'garbage_name' 		 =>	$edit_garbage,  
				'garbage_mal_name' 	 => 	$edit_garbage_mal,
				'garbage_code' 		 => 	$edit_garbage_code,
				'garbage_modified_user_id'	 =>	$sess_usr_id,
				'garbage_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_garbage($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Garbage Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Garbage Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Garbage ends.	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Bulk Head Placement

//____________________________________________________________________________________________________________________________________________	

// List Bulk Head Placement starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function bulkhead_placement()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'bulkhead_placement', 'page' => 'bulkhead_placement', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$bulkhead_placement		= 	$this->Master_model->get_bulkhead_placement();
		$data['bulkhead_placement']	=	$bulkhead_placement;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/bulkhead_placement',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');        
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List bulkhead_placement end
/*____________________________________________________________________________________________________________________________________________*/	


// Add bulk head placement starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_bulkhead_placement()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'bulkhead_placement', 'page' => 'bulkhead_placement', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('bulkhead_placement_name', 'Bulk Head Placement Name', 'required|callback_alphanum_check');
		$this->form_validation->set_rules('bulkhead_placement_code', 'Bulk Head Placement Code', 'required|callback_minalphanum_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$bulkhead_placement_ins 			= 	$this->input->post('bulkhead_placement_ins');
			$bulkhead_placement_name			= 	$this->input->post('bulkhead_placement_name');
			$bulkhead_placement_mal_name 			= 	$this->input->post('bulkhead_placement_mal_name');
			$bulkhead_placement_code 			= 	$this->input->post('bulkhead_placement_code');
			$chkduplication=$this->Master_model->check_duplication_bulkhead_placement_insert($bulkhead_placement_name,$bulkhead_placement_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($bulkhead_placement_ins=="Save Bulk Head Placement")
				{
					$data 			= 	array(
					'bulkhead_placement_name' 		=>	$bulkhead_placement_name,  
					'bulkhead_placement_mal_name' 	=> 	$bulkhead_placement_mal_name,
					'bulkhead_placement_code' 		=> 	$bulkhead_placement_code,
					'bulkhead_placement_status'		=>	'1',
					'bulkhead_placement_created_user_id'	=> 	$sess_usr_id,
					'bulkhead_placement_created_timestamp'=>	$date,
					'bulkhead_placement_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_bulkhead_placement_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Bulk Head Placement successfully Added!!!</div>');
					}
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Bulk Head Placement Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Bulk Head Placement ends.	
/*____________________________________________________________________________________________________________________________________________*/	
		
// Status Bulk Head Placement starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_bulkhead_placement()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'bulkhead_placement', 'page' => 'bulkhead_placement', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('bulkhead_placement_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_bulkhead_placement_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		

	
//Status Bulk Head Placement ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
// Delete Bulk Head Placement  starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_bulkhead_placement()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'bulkhead_placement', 'page' => 'bulkhead_placement', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_bulkhead_placement($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Bulk Head Placement  starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_bulkhead_placement()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'bulkhead_placement', 'page' => 'bulkhead_placement', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_bulkhead_placement', 'Bulk Head Placement Name', 'required|callback_alphanum_check');
		$this->form_validation->set_rules('edit_bulkhead_placement_code', 'Bulk Head Placement Code', 'required|callback_minalphanum_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_bulkhead_placement 	= 	$this->input->post('edit_bulkhead_placement');
			$edit_bulkhead_placement_mal 	= 	$this->input->post('edit_bulkhead_placement_mal');
			$edit_bulkhead_placement_code	= 	$this->input->post('edit_bulkhead_placement_code');
			$edit_bulkhead_placement	= 	$this->security->xss_clean($edit_bulkhead_placement);
			$chkduplication	=$this->Master_model->check_duplication_bulkhead_placement_edit($edit_bulkhead_placement,$edit_bulkhead_placement_code,$id);
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'bulkhead_placement_name' 		 =>	$edit_bulkhead_placement,  
				'bulkhead_placement_mal_name' 	 => 	$edit_bulkhead_placement_mal,
				'bulkhead_placement_code' 		 => 	$edit_bulkhead_placement_code,
				'bulkhead_placement_modified_user_id'	 =>	$sess_usr_id,
				'bulkhead_placement_modified_ipaddress'=>	$ip						);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_bulkhead_placement($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Bulk Head Placement Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Bulk Head Placement Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Bulk Head Placement ends.	
/*____________________________________________________________________________________________________________________________________________*/	

//                                                             Search Light Size

//____________________________________________________________________________________________________________________________________________	

// List Search Light Size starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function searchlight_size()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'searchlight_size', 'page' => 'searchlight_size', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$searchlight_size		= 	$this->Master_model->get_searchlight_size();
		$data['searchlight_size']	=	$searchlight_size;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/searchlight_size',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List searchlight_size end
/*____________________________________________________________________________________________________________________________________________*/	


// Add Save Search Light Size starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_searchlight_size()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'searchlight_size', 'page' => 'searchlight_size', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('searchlight_size_name', 'Search Light Size Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('searchlight_size_code', 'Search Light Size Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$searchlight_size_ins 			= 	$this->input->post('searchlight_size_ins');
			$searchlight_size_name			= 	$this->input->post('searchlight_size_name');
			$searchlight_size_mal_name 		= 	$this->input->post('searchlight_size_mal_name');
			$searchlight_size_code 			= 	$this->input->post('searchlight_size_code');
			$chkduplication=$this->Master_model->check_duplication_searchlight_size_insert($searchlight_size_name,$searchlight_size_code); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($searchlight_size_ins=="Save Search Light Size")
				{
					$data = 	array('searchlight_size_name' 		=>	$searchlight_size_name,  
						'searchlight_size_mal_name' 	=> 	$searchlight_size_mal_name,
						'searchlight_size_code' 		=> 	$searchlight_size_code,
						'searchlight_size_status'		=>	'1',
						'searchlight_size_created_user_id'	=> 	$sess_usr_id,
						'searchlight_size_created_timestamp'=>	$date,
						'searchlight_size_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_searchlight_size_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Search Light Size successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Search Light Size Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	
//Add Search Light Size ends.	
/*____________________________________________________________________________________________________________________________________________*/	

// Status Search Light Size starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_searchlight_size()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'searchlight_size', 'page' => 'searchlight_size', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('searchlight_size_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_searchlight_size_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Search Light Size ends.	
/*____________________________________________________________________________________________________________________________________________*/	
// Delete Search Light Size  starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_searchlight_size()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');

	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'searchlight_size', 'page' => 'searchlight_size', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_searchlight_size($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Search Light Size  starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_searchlight_size()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'searchlight_size', 'page' => 'searchlight_size', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_searchlight_size', 'Search Light Size Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_searchlight_size_code', 'Search Light Size Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_searchlight_size 		= 	$this->input->post('edit_searchlight_size');
			$edit_searchlight_size_mal 	= 	$this->input->post('edit_searchlight_size_mal');
			$edit_searchlight_size_code	= 	$this->input->post('edit_searchlight_size_code');
			$edit_searchlight_size	= 	$this->security->xss_clean($edit_searchlight_size);
			$chkduplication	=$this->Master_model->check_duplication_searchlight_size_edit($edit_searchlight_size,$edit_searchlight_size_code,$id);
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array('searchlight_size_name' 		 =>	$edit_searchlight_size,  
				'searchlight_size_mal_name' 	 => 	$edit_searchlight_size_mal,
				'searchlight_size_code' 		 => 	$edit_searchlight_size_code,
				'searchlight_size_modified_user_id'	 =>	$sess_usr_id,
				'searchlight_size_modified_ipaddress'=>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_searchlight_size($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Search Light Size Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Search Light Size Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Search Light Size ends.	
/*____________________________________________________________________________________________________________________________________________*/	

//               Portable Fire Extinguisher


// List Portable Fire Extinguisher starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
public function portable_fire_extinguisher()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'portable_fire_extinguisher', 'page' => 'portable_fire_extinguisher', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$portable_fire_extinguisher		= 	$this->Master_model->get_portable_fire_extinguisher();
		$data['portable_fire_extinguisher']	=	$portable_fire_extinguisher;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/portable_fire_extinguisher',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List portable_fire_extinguisher end
/*____________________________________________________________________________________________________________________________________________*/	

// Add Portable Fire Extinguisher starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_portable_fire_extinguisher()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'portable_fire_extinguisher', 'page' => 'portable_fire_extinguisher', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('portable_fire_extinguisher_name', 'Portable Fire Extinguisher Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('portable_fire_extinguisher_code', 'Portable Fire Extinguisher Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$portable_fire_extinguisher_ins 	= 	$this->input->post('portable_fire_extinguisher_ins');
			$portable_fire_extinguisher_name	= 	$this->input->post('portable_fire_extinguisher_name');
			$portable_fire_extinguisher_mal_name 	= 	$this->input->post('portable_fire_extinguisher_mal_name');
			$portable_fire_extinguisher_code 	= 	$this->input->post('portable_fire_extinguisher_code');
			$chkduplication=$this->Master_model->check_duplication_portable_fire_extinguisher_insert($portable_fire_extinguisher_name,$portable_fire_extinguisher_code); 
			$cntrows	=	count($chkduplication);
			if($cntrows==0)
			{
				if($portable_fire_extinguisher_ins=="Save Portable Fire Extinguisher")
				{
					$data 			= 	array(
					'portable_fire_extinguisher_name' 		=>	$portable_fire_extinguisher_name,  
					'portable_fire_extinguisher_mal_name' 	=> 	$portable_fire_extinguisher_mal_name,
					'portable_fire_extinguisher_code' 		=> 	$portable_fire_extinguisher_code,
					'portable_fire_extinguisher_status'		=>	'1',
					'portable_fire_extinguisher_created_user_id'	=> 	$sess_usr_id,
					'portable_fire_extinguisher_created_timestamp'=>	$date,
					'portable_fire_extinguisher_created_ipaddress'=>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('kiv_portable_fire_extinguisher_master', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Portable Fire Extinguisher successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Portable Fire Extinguisher Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Portable Fire Extinguisher ends.	
/*____________________________________________________________________________________________________________________________________________*/	
// Status Portable Fire Extinguisher starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_portable_fire_extinguisher()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'portable_fire_extinguisher', 'page' => 'portable_fire_extinguisher', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('portable_fire_extinguisher_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_portable_fire_extinguisher_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Portable Fire Extinguisher ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

// Delete Portable Fire Extinguisher  starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	

public function delete_portable_fire_extinguisher()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'portable_fire_extinguisher', 'page' => 'portable_fire_extinguisher', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_portable_fire_extinguisher($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Portable Fire Extinguisher  starting...  (16-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_portable_fire_extinguisher()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'portable_fire_extinguisher', 'page' => 'portable_fire_extinguisher', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_portable_fire_extinguisher', 'Portable Fire Extinguisher Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_portable_fire_extinguisher_code', 'Portable Fire Extinguisher Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_portable_fire_extinguisher 		= 	$this->input->post('edit_portable_fire_extinguisher');
			$edit_portable_fire_extinguisher_mal 	= 	$this->input->post('edit_portable_fire_extinguisher_mal');
			$edit_portable_fire_extinguisher_code	= 	$this->input->post('edit_portable_fire_extinguisher_code');

			$edit_portable_fire_extinguisher	= 	$this->security->xss_clean($edit_portable_fire_extinguisher);
			$chkduplication	=$this->Master_model->check_duplication_portable_fire_extinguisher_edit($edit_portable_fire_extinguisher,$edit_portable_fire_extinguisher_code,$id);
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'portable_fire_extinguisher_name' 		 =>	$edit_portable_fire_extinguisher,  
				'portable_fire_extinguisher_mal_name' 	 	 => 	$edit_portable_fire_extinguisher_mal,
				'portable_fire_extinguisher_code' 		 => 	$edit_portable_fire_extinguisher_code,
				'portable_fire_extinguisher_modified_user_id'	 =>	$sess_usr_id,
				'portable_fire_extinguisher_modified_ipaddress'  =>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check = $this->Master_model->edit_portable_fire_extinguisher($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Portable Fire Extinguisher Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Portable Fire Extinguisher Name/Code Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Portable Fire Extinguisher ends.	
/*____________________________________________________________________________________________________________________________________________*/	

//      Master Tables

//____________________________________________________________________________________________________________________________________________	

// List Master Tables starting...  (18-06-2018) 
//_____________________________________________________________________________________________________________________________________________

public function mastertable()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'mastertable', 'page' => 'mastertable', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;     
		$mastertable		= 	$this->Master_model->get_mastertable();
		$data['mastertable']	=	$mastertable;
		$data 			= 	$data + $this->data;//print_r($vesseltype);exit;
		$show_table		  = 	$this->Master_model->show_table();
		$data['show_table'] 	  =	$show_table;			
		$data 			  = 	$data + $this->data;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/mastertable',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Master Tables end
/*____________________________________________________________________________________________________________________________________________*/	


// Add Master Tables starting...  (18-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_mastertable()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'mastertable', 'page' => 'mastertable', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		$this->form_validation->set_rules('mastertable_name', 'Master Table Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('mastertable_records', 'Number of Records', 'required|callback_num_check');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$mastertable_ins 			= 	$this->input->post('mastertable_ins');
			$mastertable_name			= 	$this->input->post('mastertable_name');
			$mastertable_mal_name 		= 	$this->input->post('mastertable_mal_name');
			$mastertable_records 		= 	$this->input->post('mastertable_records');
			$chkduplication				=	$this->Master_model->check_duplication_mastertable_insert($mastertable_name,$mastertable_mal_name); 
			$cntrows				=	count($chkduplication);
			if($cntrows==0)
			{
				if($mastertable_ins=="Save Master Table")
				{
					$data 			= 	array('mastertable_name' 		=>	$mastertable_name,  
					'mastertable_mal_name' 		=> 	$mastertable_mal_name,
					'mastertable_records' 		=> 	$mastertable_records,
					'mastertable_status'		=>	'1',
					'mastertable_created_user_id'	=> 	$sess_usr_id,
					'mastertable_created_timestamp' =>	$date,
					'mastertable_created_ipaddress' =>	$ip);
					$data = $this->security->xss_clean($data);
					//insert the form data into database
					$usr_res	=	$this->db->insert('master_tables', $data);
					if($usr_res)
					{
						echo json_encode(array("val_errors" => ""));
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">
						Master Tables successfully Added!!!</div>');
					}
				}
			} 
			else 
			{
				echo json_encode(array("val_errors" => "Master Table/Table Name Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Master Tables ends.	
/*____________________________________________________________________________________________________________________________________________*/

// Status Master Tables starting...  (19-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_mastertable()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($sess_usr_id==11))
	{	
		$data =	array('title' => 'mastertable', 'page' => 'mastertable', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('mastertable_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_mastertable_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
	
	
//Status Master Tables ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	

// Delete Master Tables  starting...  (19-06-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_mastertable()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data	= array('title' => 'mastertable', 'page' => 'mastertable', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		$delete_result		=	$this->Master_model->delete_mastertable($data,$id);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Master Tables  starting...  (19-06-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_mastertable()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'mastertable', 'page' => 'mastertable', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->form_validation->set_rules('edit_mastertable', 'Master Tables Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_mastertable_records', 'Number of Records', 'required|callback_num_check');
		if ($this->form_validation->run() == FALSE)
		{
			$valErrors			= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
		} 
		else 
		{
			$id 			  = 	$this->input->post('id');
			$id           		  =	$this->security->xss_clean($id);
			$edit_mastertable 	  = 	$this->input->post('edit_mastertable');
			$edit_mastertable_mal 	  = 	$this->input->post('edit_mastertable_mal');
			$edit_mastertable_records = 	$this->input->post('edit_mastertable_records');
			$edit_mastertable	  =	$this->security->xss_clean($edit_mastertable);
			$chkduplication	=$this->Master_model->check_duplication_mastertable_edit($edit_mastertable,$edit_mastertable_mal,$id);
			$cntrows		=	count($chkduplication);
			if($cntrows==0)
			{
				$data 		= 	array(
				'mastertable_name' 		 =>	$edit_mastertable,  
				'mastertable_mal_name' 	 	 => 	$edit_mastertable_mal,
				'mastertable_records' 		 => 	$edit_mastertable_records,
				'mastertable_modified_user_id'	 =>	$sess_usr_id,
				'mastertable_modified_ipaddress' =>	$ip);
				$data		 	= 	$this->security->xss_clean($data);
				$edit_check		=	$this->Master_model->edit_mastertable($id,$data);
				if($edit_check)
				{
					echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Master Table Updated Successfully!!!</div>');
				}
			}
			else 
			{
				echo json_encode(array("val_errors" => "Master Table Name Already Exists!!!"));
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}
}	

//Edit Master Tables ends.	
/*____________________________________________________________________________________________________________________________________________*/
//____________________________________________________________________________________________________________________________________________	

// Print Master Tables starting...  (18-06-2018) 
//_____________________________________________________________________________________________________________________________________________

function  mastertable_print()
{
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{
		$data = array('title' => 'mastertable_print', 'page' => 'mastertable_print', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->load->model('Kiv_models/Master_model');
		$mastertable		  = 	$this->Master_model->get_mastertable();
		$numberof_tables	  =	count($mastertable);
		$data['numberof_tables']  =	$numberof_tables;
		$data['mastertable']	  =	$mastertable;
		$data 			  = 	$data + $this->data;//print_r($mastertable);exit;
		$data			  =	$data+$data['mastertable'];	
		$html = $this->load->view('Kiv_views/Master/mastertable_print',$data,TRUE);
		$html = iconv("UTF-8","UTF-8//IGNORE",$html); 

		//$html = iconv("UTF-8","ISO-8859-1//IGNORE",$html);
		include_once APPPATH.'/third_party/mpdf/mpdf.php';
		//$pdfFilePath = $tableid.".pdf";
		$mastertablesname="Master_Tables";
		$pdfFilePath = $mastertablesname.".pdf";
		// $pdf=new mPDF('utf-8', 'A4');
		$pdf = new mPDF('ml', 'A4');
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, "D"); 
	}
	else
	{
		redirect('Main_login/index');        
	} 
}

//Print Master Tables ends. 
//____________________________________________________________________________________________________________________________________________	
//                                                                DYNAMIC FORM

//____________________________________________________________________________________________________________________________________________	

// List Dynamic Form starting...  (06-07-2018) 
//_____________________________________________________________________________________________________________________________________________


public function dynamic_form()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'dynamic_form_list', 'page' => 'dynamic_form_list', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$dynamic_form			= 	$this->Master_model->get_dynamic_form();
		$data['dynamic_form']	=	$dynamic_form;
		$data 					= 	$data + $this->data;//print_r($dynamic_form);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/mastertable',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List Dynamic Form end
/*____________________________________________________________________________________________________________________________________________*/	


/*____________________________________________________________________________________________________________________________________________*/

// List Dynamic Form based on Vesseltype,Vessel subtype,hull,inboard/outboard, length over the deck,date starting...  (22-06-2019) 
//_____________________________________________________________________________________________________________________________________________

public function dynamicform_byvessel()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'dynamic_form_list_byvessel', 'page' => 'dynamic_form_list_byvessel', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$dynamic_form			= 	$this->Master_model->get_view_dynamicForm_list_byvessel();
		$data['dynamic_form']	=	$dynamic_form;
		$data 					= 	$data + $this->data; //print_r($dynamic_form);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/dynamic_form_list_byvessel.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

//  List Dynamic Form based on Vesseltype,Vessel subtype,hull,inboard/outboard, length over the deck,date end
/*____________________________________________________________________________________________________________________________________________*/


/*____________________________________________________________________________________________________________________________________________*/
/*Detailed List -Dynamic Form based on Vesseltype,Vessel subtype,hull,inboard/outboard, length over the deck,date starts (22-06-2019)*/

public function detListViewDynamicform_byvessel()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'dynamic_form_detViewlist_byform', 'page' => 'dynamic_form_detViewlist_byform', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$vesseltype_id   		=	$this->uri->segment(4);
		$vess_sub_id 			=	$this->uri->segment(5);
		$length_over_deck   	=	$this->uri->segment(6);
		$hullmaterial_id   		=	$this->uri->segment(7);
		$engine_inboard_outboard=	$this->uri->segment(8);
		//$form_id   				=	$this->uri->segment(9);
		$start_date   			=	$this->uri->segment(9);
		$end_date   			=	$this->uri->segment(10);
		$data 					= 	$data + $this->data;     
		$dynamic_form			= 	$this->Master_model->get_view_dynamicForm_detList_byvessel($vesseltype_id,$vess_sub_id,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$start_date,$end_date);
		$data['dynamic_form']	=	$dynamic_form;
		$data 					= 	$data + $this->data;//print_r($dynamic_form);//exit;	
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/dynamic_form_detViewlist_byform.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// Detailed List -Dynamic Form based on Vesseltype,Vessel subtype,hull,inboard/outboard, length over the deck,date end
/*____________________________________________________________________________________________________________________________________________*/

/*____________________________________________________________________________________________________________________________________________*/
/*Detailed List -Dynamic Form based on Vesseltype,Vessel subtype,hull,inboard/outboard, length over the deck,form and date starts (26-06-2019)*/

public function detListViewDynamicform_byvesselform()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'dynamic_form_detViewlist_byheading', 'page' => 'dynamic_form_detViewlist_byheading', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$vesseltype_id   		=	$this->uri->segment(4);
		$vess_sub_id 			=	$this->uri->segment(5);
		$length_over_deck   	=	$this->uri->segment(6);
		$hullmaterial_id   		=	$this->uri->segment(7);
		$engine_inboard_outboard=	$this->uri->segment(8);
		$form_id   				=	$this->uri->segment(9);
		$start_date   			=	$this->uri->segment(10);
		$end_date   			=	$this->uri->segment(11);
		$data 					= 	$data + $this->data;     
		$dynamic_form			= 	$this->Master_model->get_view_dynamicForm_detList_byvesselform($vesseltype_id,$vess_sub_id,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$start_date,$end_date);
		$data['dynamic_form']	=	$dynamic_form;
		$data 					= 	$data + $this->data;//print_r($dynamic_form);//exit;	
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/dynamic_form_detViewlist_byheading.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');              
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// Detailed List -Dynamic Form based on Vesseltype,Vessel subtype,hull,inboard/outboard, length over the deck,form and date end(26-06-2019)
/*____________________________________________________________________________________________________________________________________________*/


// Add Dynamic Form  starting...  (06-07-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function add_dynamic_form()
{		
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'dynamic_form', 'page' => 'dynamic_form', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;
		$data 					= 	$data + $this->data;     
		$vessel_type			= 	$this->Master_model->get_vesseltype_dynamic();
		$data['vessel_type']	=	$vessel_type;
		$data 					= 	$data + $this->data;//print_r($vessel_type);exit;
		$data 					= 	$data + $this->data;     
		$formname				= 	$this->Master_model->get_formname_dynamic();
		$data['formname']		=	$formname;
		$data 					= 	$data + $this->data;//print_r($formname);exit;
		$data 					= 	$data + $this->data;     
		$hullmaterial			= 	$this->Master_model->get_hullmaterial_dynamic();
		$data['hullmaterial']	=	$hullmaterial;
		$data 					= 	$data + $this->data;//print_r($hullmaterial);exit;
		$data 					= 	$data + $this->data;     
		$boardtype				= 	$this->Master_model->get_inboard_outboard_dynamic();
		$data['boardtype']		=	$boardtype;
		$data 					= 	$data + $this->data;//print_r($boardtype);exit;

		$this->load->model('Kiv_models/Master_model');
		if (isset($_REQUEST['dynamic_ins'])=="Save Details") 
		{ 
			//set validation rules
			$this->form_validation->set_rules('vesseltype_name_hidden', 'Vessel Type Name', 'required');
			$this->form_validation->set_rules('hullmaterial_name_hidden', 'Hull Material Name', 'required');
			$this->form_validation->set_rules('length_over_deck_hidden', 'Length Over the Deck', 'required|callback_num_check');
			$this->form_validation->set_rules('engine_inboard_outboard_hidden', 'Engine Inboard or Outboard', 'required');
			$this->form_validation->set_rules('document_type_name_hidden', 'Form Name', 'required');
			$this->form_validation->set_rules('heading_name', 'Heading Name', 'required');
			//$this->form_validation->set_rules('start_date', 'Start Date', 'required');commented on(06-07-2019)
			$this->form_validation->set_rules('start_date_hidden', 'Start Date', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
				redirect('Kiv_Ctrl/Master/add_dynamic_form');
			}
			else 
			{	
				$vesseltype_name			= 	$this->input->post('vesseltype_name_hidden');
				$vessel_subtype_name 		= 	$this->input->post('vessel_subtype_name_hidden');
				$length_over_deck 			= 	$this->input->post('length_over_deck_hidden');
				$hullmaterial_id 			= 	$this->input->post('hullmaterial_name_hidden');
				$engine_inboard_outboard 	= 	$this->input->post('engine_inboard_outboard_hidden');
				$form_id 					= 	$this->input->post('document_type_name_hidden');
				$heading_sl 				= 	$this->input->post('heading_name');
				$start_date 				= 	$this->input->post('start_date_hidden');
				$end_date 					= 	$this->input->post('end_date_hidden');
				$label_id 					= 	$this->input->post('lab');
				$chkduplication	=$this->Master_model->check_duplicationIns_dynamicPage($vesseltype_name,$vessel_subtype_name,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_sl);
				$cntrows		=count($chkduplication);
				if($cntrows>0)
				{
					$db_end_date=$chkduplication[0]['end_date'];
					$db_start_date=$chkduplication[0]['start_date'];
				}
				//if($cntrows>0)
				if(($cntrows>0)&&($db_end_date!='0000-00-00')&&($db_end_date>=$start_date))
				{ 
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Dynamic Form With The Given Details Already Exists, New Start date should be greater than current End date!!!</div>');		
					redirect('Kiv_Ctrl/Master/dynamic_form');
				}
				else if(($cntrows>0)&&($db_end_date=='0000-00-00'))
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Dynamic Form With The Given Details Already Exists, End date not Specified.</div>');		
					redirect('Kiv_Ctrl/Master/dynamic_form');
				}
				else if((($cntrows>0)&&($start_date > $db_end_date)&&($start_date > $db_start_date))||($cntrows==0))
				{
					/*Get all labels from db*/
					$labelss					= 	$this->Master_model->get_label_dynamic($form_id,$heading_sl);
					$data['labelss']			=	$labelss;//print_r($labelss);echo "<br>";
					foreach ($labelss as $value) 
					{          				
						$all_label=$value['label_sl']; 
						$all_label=(int)$all_label;

						if(in_array($all_label, $label_id))
						{
							$id=trim($all_label);
							$labvalues=$_REQUEST['lab_values_'.$id];/*For input type=text*/

							if(!empty($labvalues))
							{
								$label_value_status=2;
							}
							if(empty($labvalues))
							{
								$label_value_status=1;
							}

							/*For select box*/	
							if(is_array($labvalues))
							{ 
								$labvalues_ins='';
								foreach ($labvalues as $value) 
								{
									$labvalues_ins .=$value.",";
								}
							}
							/*For input type=text*/
							else
							{
								$labvalues_ins=$_REQUEST['lab_values_'.$id];
							}	
						}
						else
						{							
							$labvalues_ins='';
							$label_value_status=0;
						} 
						$insertData = array();

						//hull material is ALL
						if($hullmaterial_id=='9999' && $engine_inboard_outboard!='9999')
						{
							if(!empty($hullmaterial))
							{
								foreach ($hullmaterial as $key ) 
								{
									$hullmaterial_sl=$key['hullmaterial_sl'];
									$tempArray = array('vesseltype_id' 	=>	$vesseltype_name,  
									'vessel_subtype_id' 				=> 	$vessel_subtype_name,
									'length_over_deck'					=>  $length_over_deck,
									'hullmaterial_id'					=>  $hullmaterial_sl,
									'engine_inboard_outboard'			=>  $engine_inboard_outboard,
									'form_id' 							=> 	$form_id,
									'heading_id'						=>	$heading_sl,
									'label_id'							=>	$all_label,
									'value_id'							=>	$labvalues_ins,
									'label_value_status'				=>  $label_value_status,
									'status'							=>  '1',				
									'dynamic_field_created_user_id'		=> 	$sess_usr_id,
									'dynamic_field_created_timestamp'	=>	$date,
									'dynamic_field_created_ipaddress'	=>	$ip,
									'start_date'						=>	$start_date,
									'end_date'							=>	$end_date);
									array_push($insertData, $tempArray);
								}
								$insertData  = $this->security->xss_clean($insertData);
								$usr_res	 = $this->db->insert_batch('kiv_dynamic_field_master', $insertData);
							}
						}
						elseif($hullmaterial_id!='9999' && $engine_inboard_outboard=='9999')
						{
							if(!empty($boardtype))
							{
								foreach ($boardtype as $key1) 
								{
									$inboard_outboard_sl=$key1['inboard_outboard_sl'];
									$tempArray = array('vesseltype_id' 	=>	$vesseltype_name,  
									'vessel_subtype_id' 				=> 	$vessel_subtype_name,
									'length_over_deck'					=>  $length_over_deck,
									'hullmaterial_id'					=>  $hullmaterial_id,
									'engine_inboard_outboard'			=>  $inboard_outboard_sl,
									'form_id' 							=> 	$form_id,
									'heading_id'						=>	$heading_sl,
									'label_id'							=>	$all_label,
									'value_id'							=>	$labvalues_ins,
									'label_value_status'				=>  $label_value_status,
									'status'							=>  '1',				
									'dynamic_field_created_user_id'		=> 	$sess_usr_id,
									'dynamic_field_created_timestamp'	=>	$date,
									'dynamic_field_created_ipaddress'	=>	$ip,
									'start_date'						=>	$start_date,
									'end_date'							=>	$end_date);
									array_push($insertData, $tempArray);
								}
								$insertData  = $this->security->xss_clean($insertData);
								$usr_res	 = $this->db->insert_batch('kiv_dynamic_field_master', $insertData);
							}
						}
						elseif($hullmaterial_id=='9999' && $engine_inboard_outboard=='9999')
						{
							if(!empty($hullmaterial))
							{
								foreach ($hullmaterial as $key) 
								{
									$hullmaterial_sl=$key['hullmaterial_sl'];
									foreach ($boardtype as $key1) 
									{
										$inboard_outboard_sl=$key1['inboard_outboard_sl'];
										$tempArray = array('vesseltype_id' 	=>	$vesseltype_name,  
										'vessel_subtype_id' 				=> 	$vessel_subtype_name,
										'length_over_deck'					=>  $length_over_deck,
										'hullmaterial_id'					=>  $hullmaterial_sl,
										'engine_inboard_outboard'			=>  $inboard_outboard_sl,
										'form_id' 							=> 	$form_id,
										'heading_id'						=>	$heading_sl,
										'label_id'							=>	$all_label,
										'value_id'							=>	$labvalues_ins,
										'label_value_status'				=>  $label_value_status,
										'status'							=>  '1',				
										'dynamic_field_created_user_id'		=> 	$sess_usr_id,
										'dynamic_field_created_timestamp'	=>	$date,
										'dynamic_field_created_ipaddress'	=>	$ip,
										'start_date'						=>	$start_date,
										'end_date'							=>	$end_date);
										array_push($insertData, $tempArray);
									}
									$insertData  = $this->security->xss_clean($insertData);
									$usr_res	 = $this->db->insert_batch('kiv_dynamic_field_master', $insertData);
								}
							}
						}
						else
						{
							$tempArray = array('vesseltype_id' 	=>	$vesseltype_name,  
							'vessel_subtype_id' 				=> 	$vessel_subtype_name,
							'length_over_deck'					=>  $length_over_deck,
							'hullmaterial_id'					=>  $hullmaterial_id,
							'engine_inboard_outboard'			=>  $engine_inboard_outboard,
							'form_id' 							=> 	$form_id,
							'heading_id'						=>	$heading_sl,
							'label_id'							=>	$all_label,
							'value_id'							=>	$labvalues_ins,
							'label_value_status'				=>  $label_value_status,
							'status'							=>  '1',				
							'dynamic_field_created_user_id'		=> 	$sess_usr_id,
							'dynamic_field_created_timestamp'	=>	$date,
							'dynamic_field_created_ipaddress'	=>	$ip,
							'start_date'						=>	$start_date,
							'end_date'							=>	$end_date);
							array_push($insertData, $tempArray);
							$insertData  = $this->security->xss_clean($insertData);
							$usr_res	 = $this->db->insert_batch('kiv_dynamic_field_master', $insertData);
						}
					}
					if($usr_res)
					{
						$vesName            = 	$this->Master_model->get_vessel_typename($vesseltype_name);
						$data['vesName']    =	$vesName;
						$vesName 			=   $vesName[0]['vesseltype_name'];//print_r($vesName);

						if(($vessel_subtype_name!='')||($vessel_subtype_name!=0))
						{
							$vesSubName         = 	$this->Master_model->get_vesselsubtype_dynamic($vessel_subtype_name);
							$data['vesSubName'] =	$vesSubName;
							$vesSubName 		=   $vesSubName[0]['vessel_subtype_name'];//print_r($vesSubName);
						}
						$hullName         	= 	$this->Master_model->get_hullmaterial_name($hullmaterial_id);
						$data['hullName'] 	=	$hullName;
						$hullName 			=   $hullName[0]['hullmaterial_name'];//print_r($hullName);
						$engName         	= 	$this->Master_model->get_engineinout_name($engine_inboard_outboard);
						$data['engName'] 	=	$engName;
						$engName 			=   $engName[0]['inboard_outboard_name'];//print_r($engName);

						$arrRet = array(
						'vesseltype_id' 					=>	$vesseltype_name, 
						'vesseltype_name' 					=>	$vesName, 
						'vessel_subtype_id' 				=> 	$vessel_subtype_name,
						'vessel_subtype_name' 				=> 	$vesSubName,
						'length_over_deck'					=>  $length_over_deck,
						'hullmaterial_id'					=>  $hullmaterial_id,
						'engine_inboard_outboard'			=>  $engine_inboard_outboard,
						'hullmaterial_name' 				=> 	$hullName,
						'inboard_outboard_name'				=>	$engName,
						'start_date'						=>	$start_date,
						'end_date'							=>	$end_date);
						$this->session->set_flashdata('val', $arrRet);	//print_r($arrRet);//exit;
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Dynamic Form Set Successfully !!!</div>');
						redirect('Kiv_Ctrl/Master/add_dynamic_form');
					}
				}
			}
		}		
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/dynamic_form',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');   
	}
	else
	{
		redirect('Main_login/index');        
	}  
}	

//Add Dynamic Form ends.	
/*____________________________________________________________________________________________________________________________________________*/

//____________________________________________________________________________________________________________________________________________	

// List Dynamic Form starting...  (06-07-2018) 
//_____________________________________________________________________________________________________________________________________________

function duplicationCheck_ajx()
{ 
	$vesseltype_name			= 	$_REQUEST['vesseltype_name'];
	$vessel_subtype_name 		= 	$_REQUEST['vessel_subtype_name'];
	$length_over_deck 			= 	$_REQUEST['length_over_deck'];
	$hullmaterial_id 			= 	$_REQUEST['hullmaterial_name'];
	$engine_inboard_outboard 	= 	$_REQUEST['engine_inboard_outboard'];
	$form_id 					= 	$_REQUEST['document_type_name'];
	$heading_sl 				= 	$_REQUEST['heading_name'];
	$start_date 				= 	$_REQUEST['start_date'];
	$end_date 					= 	$_REQUEST['end_date'];
	$start_date = explode('/', $start_date);
	$start_date = $start_date[2]."-".$start_date[1]."-".$start_date[0];
	if($end_date !='')
	{
		$end_date 	= explode('/', $end_date);
		$end_date 	= $end_date[2]."-".$end_date[1]."-".$end_date[0];
	}
	$chkduplication	=$this->Master_model->check_duplicationIns_dynamicPage($vesseltype_name,$vessel_subtype_name,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_sl); 
	$cntrows		=count($chkduplication);//print_r($chkduplication);//exit();
	if($cntrows>0)
	{
		//echo json_encode(array("val_errors" => "Dynamic Form Already Exists!!!"));
		//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Dynamic Form With The Given Details Already Exists!!!</div>');		
		//redirect('Kiv_Ctrl/Master/dynamic_form');
		//$db_start_date=$chkduplication['start_date'];
		$db_end_date=$chkduplication[0]['end_date'];
		if($db_end_date!='')
		{
			if($start_date > $db_end_date)
			{
				echo "insertionpossible";
			}
			else
			{
				echo "dataexisting";
			}
		}
		if($db_end_date=='')
		{
			echo "enddatenull";
		}
	}
	if($cntrows==0)
	{
		echo "noduplication";
	}
}

function dynamic_vesselsubtype_ajax()
{ 	   
	$vesseltype_id=$_REQUEST['vesseltype_id'];
	$this->load->model('Kiv_models/Master_model');
	$vesselsub_type			= 	$this->Master_model->get_vesselsubtype_dynamic($vesseltype_id);
	$data['vesselsub_type']	=	$vesselsub_type;
	$data 					= 	$data + $this->data;
	//echo $cnt=count($vesselsub_type);
	echo '<option value="">Select Vessel Sub Type</option>';
	foreach ($vesselsub_type as $vesselsub_type_vals) 
	{
		$vessel_subtype_sl=$vesselsub_type_vals['vessel_subtype_sl'];
		$vessel_subtype_name=$vesselsub_type_vals['vessel_subtype_name'];
		echo '<option value="'.$vessel_subtype_sl.'">'.$vessel_subtype_name.'</option>';
	}
}

function dynamic_formname_ajax()
{ 	   
	$form_id=$_REQUEST['form_id'];
	$this->load->model('Kiv_models/Master_model');
	$heading_name			= 	$this->Master_model->get_heading_dynamic($form_id);
	$data['heading_name']	=	$heading_name;
	$data 					= 	$data + $this->data;//print_r($heading_name);
	echo '<option value="">Select Heading</option>';
	foreach ($heading_name as $head_name) 
	{
		$heading_sl=$head_name['heading_sl'];
		$heading_name=$head_name['heading_name'];
		echo '<option value=" '.$heading_sl.' ">'.$heading_name.'</option>';
	}
}
function dynamic_labels_date()
{
	$form_id    			=$_REQUEST['form_id'];
	$heading_id 			=$_REQUEST['heading_id'];
	$engine_inboard_outboard=$_REQUEST['engine_inboard_outboard'];
	$hullmaterial_name      =$_REQUEST['hullmaterial_name'];
	$vesseltype_name     	=$_REQUEST['vesseltype_name'];
	$vessel_subtype_name_opt=$_REQUEST['vessel_subtype_name'];
	$length_over_deck		=$_REQUEST['length_over_deck'];
	if(!empty($vessel_subtype_name_opt))
	{
	 	$vessel_subtype_id=$vessel_subtype_name_opt;
	}
	else
	{
	  $vessel_subtype_id=0;
	}
	$this->load->model('Kiv_models/Master_model');
	
	$dynamic_form_details1= 	$this->Master_model->get_dynamicForm_date($vesseltype_name,$vessel_subtype_id,$length_over_deck,$hullmaterial_name,$engine_inboard_outboard,$form_id,$heading_id);
	$data['dynamic_form_details1']	=	$dynamic_form_details1;
	if(!empty($dynamic_form_details1))
	{
		$start_date1=$dynamic_form_details1[0]['start_date'];
		$end_date1=$dynamic_form_details1[0]['end_date'];
		echo json_encode(array($start_date1,$end_date1));
	}
}

function dynamic_labels_ajax()
{ 	   
	$form_id    			=$_REQUEST['form_id'];
	$heading_id 			=$_REQUEST['heading_id'];
	$engine_inboard_outboard=$_REQUEST['engine_inboard_outboard'];
	$hullmaterial_name      =$_REQUEST['hullmaterial_name'];
	$vesseltype_name     	=$_REQUEST['vesseltype_name'];
	$vessel_subtype_name_opt=$_REQUEST['vessel_subtype_name'];
	$length_over_deck		=$_REQUEST['length_over_deck'];
	$start_date				=$_REQUEST['start_date'];  //01-01-2021
	$end_date				=$_REQUEST['end_date']; 
	$date1					=$_REQUEST['date1']; //01-01-2020
	$date2					=$_REQUEST['date2']; //01-01-2021
	if($end_date=='')
	{
		$end_date='0000-00-00';
	}

	if($start_date>$date2)
	{
		echo "1";
	}
	elseif($date2>$start_date)
	{
		echo "1";
	}


	/*if(!empty($vessel_subtype_name_opt))
	{
	 	$vessel_subtype_id=$vessel_subtype_name_opt;
	}
	else
	{
	 	$vessel_subtype_id=0;
	}
	if($end_date=='')
	{
		$end_date='0000-00-00';
	}
	$this->load->model('Kiv_models/Master_model');
	$dynamic_form_details= 	$this->Master_model->get_dynamicForm_details($vesseltype_name,$vessel_subtype_name_opt,$length_over_deck,$hullmaterial_name,$engine_inboard_outboard,$form_id,$heading_id,$start_date,$end_date,$date1,$date2);
	$data['dynamic_form_details']	=	$dynamic_form_details;
	if(!empty($dynamic_form_details))
	{
		echo "1";
	}*/
	else
	{
		$heading_name			= 	$this->Master_model->get_heading_dynamic($form_id);
		$data['heading_name']	=	$heading_name;
		$countAllHeading 		=	count($heading_name);
		$data 					= 	$data + $this->data;
		$headingList				= 	$this->Master_model->get_dynamicForm_headingList($vesseltype_name,$vessel_subtype_id,$length_over_deck,$hullmaterial_name,$engine_inboard_outboard,$form_id,$start_date,$end_date);
		$data['headingList']		=	$headingList; //print_r($headingList);exit;
		$countExtHeading 		=	count($headingList);
		$data 					= 	$data + $this->data;
		$labels					= 	$this->Master_model->get_label_dynamic($form_id,$heading_id);
		$data['labels']			=	$labels;
		$data 					= 	$data + $this->data;
		$i=0;
		$label_sl_ls 			=	'';      
		echo '<table class="table table-bordered table-striped"><tr><td colspan="4">';
		echo '<div class="pull-right"><button type="button" name="addedBtn" id="addedBtn" class="btn btn-block btn-default btn-sm"><i class="fa fa-hourglass-3"></i> Added Headings '.$countExtHeading.'/'.$countAllHeading.' </button> </div>';
		echo '<div class="alert alert-primary" role="alert" style="color: blue; bold;">LIST OF ALREADY EXISTING HEADINGS</div>';
		$i=1;
		foreach ($headingList as $headingValue) 
		{          	
			$color = array("success", "info", "warning","success", "info", "warning","success", "info", "warning");
			$clr=$color[$i-1];
			echo '<div class="alert alert-'.$clr.'" role="alert">'.$headingValue['heading_name'].'</div>'; 
			$i++;
		}
		echo '</td></tr><table>';		   
		/*If the selected heading already existing, not need to display the labels under that heading*/
		foreach ($headingList as $value) 
		{
			$extHeadId=$value['heading_id'];
			if($value['heading_id']==trim($heading_id))
			{	           		
				echo '<div class="alert alert-danger text-center">The Heading '.$value['heading_name'].' Already Existing.</div>';
				echo '<input type="hidden" name="headingStatus" id="headingStatus" value="existing" >';exit;
			}
		}
		/*If the selected heading already existing, not need to display the labels under that heading*/		 
		foreach ($labels as $label) 
		{
			$label_sl	=$label['label_sl'];
			$label_name =$label['label_name'];
			$table_name =$label['table_name'];
			echo '<table class="table table-bordered table-striped">';
			if($table_name=='')
			{
				if($label_sl==1)
				{
					echo '<tr><td><input type="checkbox" checked disabled name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " onclick="checkedVal('.$label_sl.')"></td><td>'.$label_name.'</td><td>Value</td><td><input type="text" readonly name="lab_values_'.$label_sl.'" id="lab_values_'.$label_sl.'" onclick="checkboxVal('.$label_sl.')" maxlength="50" class="form-control div350" placeholder=" Enter Values" autocomplete="off">';
					echo '<input type="hidden" name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " >';
					echo '<input type="hidden" name="lab_values_'.$label_sl.'[]" id="lab_values_'.$label_sl.'[]" value="">';
				}
				else
				{
					echo '<tr><td><input type="checkbox" name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " onclick="checkedVal('.$label_sl.')"></td><td>'.$label_name.'</td><td>Value</td><td><input type="text" name="lab_values_'.$label_sl.'" id="lab_values_'.$label_sl.'" onclick="checkboxVal('.$label_sl.')"   onchange="checkboxVal_change('.$label_sl.')"  maxlength="50" class="form-control div350" placeholder=" Enter Values" autocomplete="off">';
					echo '<div id="valid_err_msg_'.$label_sl.'"></div>';
				}
			}
			if($table_name!='')
			{									
				$table_vals			= 	$this->Master_model->get_tablename_label_dynamic($table_name);
				$data['table_vals']	=	$table_vals;
				$tab_det			= explode('_',$table_name);
				$tab_det_val		= $tab_det[1];
				$tab_det_val2		= $tab_det[2];
				if((isset($tab_det[3]))&&($tab_det[3] != "master"))
				{
					$tab_det_val3	= $tab_det[3];						
					$tab_det_val    = $tab_det[1]."_".$tab_det[2]."_".$tab_det_val3;						
				}
				else if((isset($tab_det[3]))&&($tab_det[3] == "master"))
				{												
					$tab_det_val    = $tab_det[1]."_".$tab_det[2];						
				}
				else
				{
					$tab_det_val    = $tab_det[1];
				}
				$tab_sl=$tab_det_val."_sl";
				$tab_name=$tab_det_val."_name";
				if($label_sl==25)
				{ 
					echo '<tr><td><input type="checkbox" checked disabled name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " onclick="checkedVal('.$label_sl.')"></td><td>'.$label_name.'</td><td>Value</td><td><select  class="form-control select2 div350" disabled name="lab_values_'.$label_sl.'[]" id="lab_values_'.$label_sl.'[]" onclick="checkboxVal('.$label_sl.')" >';
					foreach ($table_vals as $list) 
					{
						if($engine_inboard_outboard==9999){$list[$tab_sl]=9999;$list[$tab_name]="All";}
						if($list[$tab_sl]==$engine_inboard_outboard)
						{			            		
							echo '<option value="'.$list[$tab_sl].'" selected="selected" >'. $list[$tab_name].'</option>';
						}
					}
					echo '<select>';
					echo '<input type="hidden" name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " >';
					echo '<input type="hidden" name="lab_values_'.$label_sl.'[]" id="lab_values_'.$label_sl.'[]" value=" '.$engine_inboard_outboard.' ">';	
				}
				else if($label_sl==13)
				{ 
					echo '<tr><td><input type="checkbox" checked disabled name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " onclick="checkedVal('.$label_sl.')"></td><td>'.$label_name.'</td><td>Value</td><td><select  class="form-control select2 div350" disabled name="lab_values_'.$label_sl.'[]" id="lab_values_'.$label_sl.'[]" onclick="checkboxVal('.$label_sl.')"  >';
					foreach ($table_vals as $list) 
					{
						if($hullmaterial_name==9999){$list[$tab_sl]=9999;$list[$tab_name]="All";}
						if($list[$tab_sl]==$hullmaterial_name)
						{			            		
							echo '<option value="'.$list[$tab_sl].'" selected="selected" >'. $list[$tab_name].'</option>';
						}
					}
					echo '<select>';
					echo '<input type="hidden" name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " >';
					echo '<input type="hidden" name="lab_values_'.$label_sl.'[]" id="lab_values_'.$label_sl.'[]" value=" '.$hullmaterial_name.' ">';	
				}
				else if($label_sl==5)
				{ 
					//Type of vessel
					echo '<tr><td><input type="checkbox" checked disabled name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " onclick="checkedVal('.$label_sl.')"></td><td>'.$label_name.'</td><td>Value</td><td><select  class="form-control select2 div350" disabled name="lab_values_'.$label_sl.'[]" id="lab_values_'.$label_sl.'[]" onclick="checkboxVal('.$label_sl.')"  >';
					foreach ($table_vals as $list) 
					{
						if($list[$tab_sl]==$vesseltype_name)
						{			            		
							echo '<option value="'.$list[$tab_sl].'" selected="selected" >'. $list[$tab_name].'</option>';
						}
					}
					echo '<select>';
					echo '<input type="hidden" name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " >';
					echo '<input type="hidden" name="lab_values_'.$label_sl.'[]" id="lab_values_'.$label_sl.'[]" value=" '.$vesseltype_name.' ">';	
				}
				else if($label_sl==6)
				{ 	
					//Sub type of vessel
					if($vessel_subtype_name_opt!=''){$checked="checked";}else{$checked='';}					
					echo '<tr><td><input type="checkbox" '.$checked.' disabled name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " onclick="checkedVal('.$label_sl.')"></td><td>'.$label_name.'</td><td>Value</td><td><select  class="form-control select2 div350" disabled name="lab_values_'.$label_sl.'[]" id="lab_values_'.$label_sl.'[]" onclick="checkboxVal('.$label_sl.')"  >';
					foreach ($table_vals as $value) 
					{
						if((int)$value[$tab_sl]==$vessel_subtype_name_opt)
						{
							echo '<option value="'.$value[$tab_sl].'" selected="selected" >'. $value[$tab_name].'</option>';
						}
					}
					echo '<select>';
					echo '<input type="hidden" name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " >';
					echo '<input type="hidden" name="lab_values_'.$label_sl.'[]" id="lab_values_'.$label_sl.'[]" value=" '.$vessel_subtype_name_opt.' ">';	
				}		
				else
				{
					echo '<tr><td><input type="checkbox" name="lab[]" id="lab_'.$label_sl.'" value="'.$label_sl.' " onclick="checkedVal('.$label_sl.')"></td><td>'.$label_name.'</td><td>Value</td><td><select class="form-control select2 div350" multiple="multiple" data-placeholder="Select the list" name="lab_values_'.$label_sl.'[]" id="lab_values_'.$label_sl.'" onclick="checkboxVal('.$label_sl.')"  onchange="checkboxVal_change('.$label_sl.')">';
					foreach ($table_vals as $list) 
					{         
						echo '<option value="'. $list[$tab_sl].'">'. $list[$tab_name].'</option>';
					}	
					echo '<select>';
				}
			}		
			echo '</td></tr><table>';
			$i++;
		}
	}
}

// List Dynamic Form end
/*____________________________________________________________________________________________________________________________________________*/	

	
//____________________________________________________________________________________________________________________________________________	

// Status Dynamic Form  starting...  (06-07-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function status_dynamic_form()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data 				= 	array('title' => 'dynamic_form_list', 'page' => 'dynamic_form_list', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_dynamic_form_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//Status Dynamic Form ends.	
/*____________________________________________________________________________________________________________________________________________*/	
	
//____________________________________________________________________________________________________________________________________________	

// Delete Dynamic Form  starting...  (06-07-2018) 
//_____________________________________________________________________________________________________________________________________________
	
public function delete_dynamic_form()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data = 	array('title' => 'dynamic_form_list', 'page' => 'dynamic_form_list', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = 	$data + $this->data;
		//print_r($_REQUEST);
		$id 						= 	$this->input->post('id');
		$form_id 					= 	$this->input->post('form_id');
		$vesseltype_id 				= 	$this->input->post('vesseltype_id');
		$vess_sub_id 				= 	$this->input->post('vess_sub_id');
		$length_over_deck 			= 	$this->input->post('length_over_deck');
		$hullmaterial_id 			= 	$this->input->post('hullmaterial_id');
		$engine_inboard_outboard 	= 	$this->input->post('engine_inboard_outboard');
		$start_date 				= 	$this->input->post('start_date');
		$end_date 					=	$this->input->post('end_date');
		$status 					= 	$this->input->post('stat'); 
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data 				= 	array('delete_status' => $updstat);
		//$delete_result		=	$this->Master_model->delete_dynamic_form($data,$id,$form_id,$vesseltype_id,$start_date,$end_date);
		$delete_result		=	$this->Master_model->delete_dynamic_form($data,$id,$form_id,$vesseltype_id,$vess_sub_id,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$start_date,$end_date);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}		
//____________________________________________________________________________________________________________________________________________	

// Edit Dynamic Form  starting...  (06-07-2018) 
//_____________________________________________________________________________________________________________________________________________
		
public function edit_dynamic_form()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 					= 	date('Y-m-d h:i:s', time());
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'dynamic_form', 'page' => 'dynamic_form', 'errorCls' => NULL, 'post' => $this->input->post());
		$data =	$data + $this->data;
		$data 					= 	$data + $this->data;     
		$vessel_type			= 	$this->Master_model->get_vesseltype_dynamic();
		$data['vessel_type']	=	$vessel_type;
		$data 					= 	$data + $this->data;//print_r($vessel_type);exit;
		$data 					= 	$data + $this->data;     
		$formname				= 	$this->Master_model->get_formname_dynamic();
		$data['formname']		=	$formname;
		$data 					= 	$data + $this->data;//print_r($formname);exit;
		$data 					= 	$data + $this->data;     
		$hullmaterial			= 	$this->Master_model->get_hullmaterial_dynamic();
		$data['hullmaterial']	=	$hullmaterial;
		$data 					= 	$data + $this->data;//print_r($hullmaterial);exit;
		$data 					= 	$data + $this->data;     
		$boardtype				= 	$this->Master_model->get_inboard_outboard_dynamic();
		$data['boardtype']		=	$boardtype;
		$data 					= 	$data + $this->data;//print_r($boardtype);exit;		
		$edit_id   				=	$this->uri->segment(4);
		$vesseltype_id   		=	$this->uri->segment(5);
		$vess_sub_id 			=	$this->uri->segment(6);
		$length_over_deck   	=	$this->uri->segment(7);
		$hullmaterial_id   		=	$this->uri->segment(8);
		$engine_inboard_outboard=	$this->uri->segment(9);
		$form_id   				=	$this->uri->segment(10);
		$start_date   			=	$this->uri->segment(11);
		$end_date   			=	$this->uri->segment(12);
		$data 					= 	$data + $this->data;     
		$editres				= 	$this->Master_model->get_edit_dynamic_form($edit_id,$vesseltype_id,$vess_sub_id,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$start_date,$end_date);
		$data['editres']		=	$editres;
		$data 					= 	$data + $this->data;//print_r($editres);//exit;	
		foreach ($editres as $value) 
		{
			$table_name=$value['table_name'];
			//echo $table_name 			=	$editres[2]['table_name'];
			if($table_name!='')
			{
				$data 					= 	$data + $this->data;     
				$table_vals				= 	$this->Master_model->get_tablename_label_dynamic($table_name);
				$data['table_vals']		=	$table_vals;
				$data 					= 	$data + $this->data;//print_r($table_vals);//exit;
			}
		}
		$this->load->model('Kiv_models/Master_model');
		if (isset($_REQUEST['dynamic_ins'])=="Save Details") 
		{ 
			//set validation rules
			$this->form_validation->set_rules('vesseltype_name', 'Vessel Type Name', 'required');
			$this->form_validation->set_rules('document_type_name', 'Form Name', 'required');
			$this->form_validation->set_rules('heading_name', 'Heading Name', 'required');
			$this->form_validation->set_rules('length_over_deck', 'Length Over the Deck', 'required|callback_num_check');
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
				redirect('Kiv_Ctrl/Master/add_dynamic_form');
			}
			else
			{
				$vesseltype_name			= 	$this->input->post('vesseltype_name');
				$vessel_subtype_name 		= 	$this->input->post('vessel_subtype_name');
				$length_over_deck 			= 	$this->input->post('length_over_deck');
				$hullmaterial_id			= 	$this->input->post('hullmaterial_name');
				$engine_inboard_outboard 	= 	$this->input->post('engine_inboard_outboard');
				$form_id 					= 	$this->input->post('document_type_name');
				$heading_sl 				= 	$this->input->post('heading_name');
				$label_id 					= 	$this->input->post('lab');//print_r($label_id);
				$page_edit_id 				=	$this->input->post('page_edit_id');
				$start_date 				=	$this->input->post('start_date');
				$end_date 					=	$this->input->post('end_date');
				$start_date = explode('/', $start_date);
				$start_date = $start_date[2]."-".$start_date[1]."-".$start_date[0];
				$end_date = explode('/', $end_date);
				$end_date = $end_date[2]."-".$end_date[1]."-".$end_date[0];
				/*Edited on 14-06-2018  Start*/	//$chkduplication	=	$this->Master_model->check_duplication_dynamic_form($edit_dynamic_form);
				//$chkduplication	=$this->Master_model->check_duplication_dynamic_form_edit($edit_dynamic_form,$edit_dynamic_form_code,$id);
				/*End*/
				//$cntrows		=	count($chkduplication);
				/*__________________________________________*/
				/*Get all labels from db*/
				$labelss					= 	$this->Master_model->get_label_dynamic_edit($form_id,$heading_sl);
				$data['labelss']			=	$labelss;//print_r($labelss);exit;
				foreach ($labelss as $value) 
				{          				
					$all_label=$value['label_id']; 
					$all_label=(int)$all_label;
					if(in_array($all_label, $label_id))
					{
						$id=trim($all_label);//echo "-";
						$labvalues=$_REQUEST['lab_values_'.$id];//echo "<br>";//exit;
						if(!empty($labvalues))
						{
							$label_value_status=2;
						}
						if(empty($labvalues))
						{
							$label_value_status=1;
						}
						/*For select box*/	
						if(is_array($labvalues))
						{ 
							$labvalues_ins='';
							foreach ($labvalues as $value) 
							{
								$labvalues_ins .=$value.",";
							}
						}
						/*For input type=text*/
						else
						{
							$labvalues_ins=$_REQUEST['lab_values_'.$id];
						}			
					}
					else
					{							
						$labvalues_ins='';
						$label_value_status=0;
					} 
					$updateData = array(
					'label_id'							=>	$all_label,
					'value_id'							=>	$labvalues_ins,
					'label_value_status'				=>  $label_value_status,
					'end_date' 							=>  $end_date,
					'dynamic_field_modified_user_id'	=> 	$sess_usr_id,
					'dynamic_field_modified_timestamp'	=>	$date,
					'dynamic_field_modified_ipaddress'	=>	$ip);
					$updateData  = $this->security->xss_clean($updateData);		
					$this->db->where('vesseltype_id', $vesseltype_name);
					$this->db->where('vessel_subtype_id', $vessel_subtype_name);
					$this->db->where('label_id', $all_label);
					$this->db->where('heading_id', $heading_sl);
					$this->db->where('form_id', $form_id);
					$this->db->where('start_date', $start_date);
					$usr_res=$this->db->update('kiv_dynamic_field_master', $updateData);
				}	
				/*__________________________________________*/			
				if($usr_res)
				{
					//echo json_encode(array("val_errors" => ""));	
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Dynamic Form Updated Successfully!!!</div>');
					redirect('Kiv_Ctrl/Master/detListViewDynamicform_byvesselform/'.$vesseltype_name.'/'.$vessel_subtype_name.'/'.$length_over_deck.'/'.$hullmaterial_id.'/'.$engine_inboard_outboard.'/'.$form_id.'/'.$start_date.'/'.$end_date);
				}
			}
		}
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/dynamic_form.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}
}	
//Edit Dynamic Form ends.	
/*____________________________________________________________________________________________________________________________________________*/	

// Copy Dynamic Form starting...  (19-09-2018) 
//_____________________________________________________________________________________________________________________________________________

public function copyDynamicform()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'copy_dynamic_form', 'page' => 'copy_dynamic_form', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$dynamic_form			= 	$this->Master_model->get_dynamic_form();
		$data['dynamic_form']	=	$dynamic_form;
		$data 					= 	$data + $this->data;//print_r($dynamic_form);exit;
		$form					= 	$this->Master_model->get_formname_dynamic();
		$data['form']			=	$form;
		$data 					= 	$data + $this->data;//print_r($form);exit;			
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/copy_dynamic_form',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// Copy Dynamic Form end
/*____________________________________________________________________________________________________________________________________________*/

function dynamic_form_Datalist_ajax()
{ 	   
	$form_id=$_REQUEST['formName'];
	$this->load->model('Kiv_models/Master_model');
	$dataList			= 	$this->Master_model->get_copyData_form_dynamic($form_id);
	$data['dataList']	=	$dataList;
	$data 				= 	$data + $this->data;//print_r($dataList);			
	$this->load->view('Kiv_views/Master/copyForm_Ajax.php', $data);
}
/*List table based on the particular selected form */
/*____________________________________________________________________________________________________________________________________________*/
function copyFormData_ajax()
{ 	  
	$vesselId 				= $this->uri->segment(4);
	$subvesselId 			= $this->uri->segment(5);
	$hullId 				= $this->uri->segment(6);
	$lengthOverDeck 		= $this->uri->segment(7);
	$engineInboardOutboard 	= $this->uri->segment(8);
	$formId 				= $this->uri->segment(9);
	$startDate 				= $this->uri->segment(10);
	$endDate 				= $this->uri->segment(11);
	$vesselName 			= $this->uri->segment(12);
	$subvesselName 			= $this->uri->segment(13);
	$hullName 				= $this->uri->segment(14);
	$boardName 				= $this->uri->segment(15);
	$hidformName 			= $this->uri->segment(16);
	$data['vesselName']		=	$vesselName;
	$data['subvesselName']	=	$subvesselName;
	$data['hullName']		=	$hullName;
	$data['boardName']		=	$boardName;
	$data['lengthOverDeck']	=	$lengthOverDeck;
	$data['hidformName']	=	$hidformName;//exit;
	$data['startDate']		=	$startDate;
	$data['endDate']		=	$endDate;
	$data['hidformId']		=	$formId;/*Edited for duplication checking 01-07-2019*/
	$data 					= 	$data + $this->data;
	$this->load->model('Kiv_models/Master_model');
	$copiedData				= 	$this->Master_model->get_copyData_selectedForm($vesselId,$subvesselId,$hullId,$lengthOverDeck,$engineInboardOutboard,$formId,$startDate,$endDate);    
	$data['copiedData']		=	$copiedData;
	$data 					= 	$data + $this->data;//print_r($copiedData);
	$data 					= 	$data + $this->data;     
	$vessel_type			= 	$this->Master_model->get_vesseltype_dynamic();
	$data['vessel_type']	=	$vessel_type;
	$data 					= 	$data + $this->data;//print_r($vessel_type);exit;
	$data 					= 	$data + $this->data;     
	$formname				= 	$this->Master_model->get_formname_dynamic();
	$data['formname']		=	$formname;
	$data 					= 	$data + $this->data;//print_r($formname);exit;
	$data 					= 	$data + $this->data;     
	$hullmaterial			= 	$this->Master_model->get_hullmaterial_dynamic();
	$data['hullmaterial']	=	$hullmaterial;
	$data 					= 	$data + $this->data;//print_r($hullmaterial);exit;
	$data 					= 	$data + $this->data;     
	$boardtype				= 	$this->Master_model->get_inboard_outboard_dynamic();
	$data['boardtype']		=	$boardtype;
	$data 					= 	$data + $this->data;//print_r($boardtype);exit;			
	$this->load->view('Kiv_views/Master/addCopiedForm_Ajax.php', $data);
	$sess_usr_id 	= 	$this->session->userdata('int_userid');
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	if (isset($_REQUEST['dynamicCopy_ins'])=="Copy Details") 
	{ 
		$this->form_validation->set_rules('vesseltype_name', 'Vessel Type Name', 'required');
		$this->form_validation->set_rules('hullmaterial_name', 'Hull Material Name', 'required');
		$this->form_validation->set_rules('length_over_deck', 'Length Over the Deck', 'required|callback_num_check');
		$this->form_validation->set_rules('engine_inboard_outboard', 'Engine Inboard or Outboard', 'required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'required');
		if ($this->form_validation->run() == FALSE)
		{         
			$this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
			redirect('Kiv_Ctrl/Master/copyDynamicform');			
		}
		else 
		{					
			$vesseltype_name			= 	$this->input->post('vesseltype_name');
			$vessel_subtype_name 		= 	$this->input->post('vessel_subtype_name');
			$length_over_deck 			= 	$this->input->post('length_over_deck');
			$hullmaterial_id 			= 	$this->input->post('hullmaterial_name');
			$engine_inboard_outboard 	= 	$this->input->post('engine_inboard_outboard');
			$start_date 				= 	$this->input->post('start_date');
			$end_date 					= 	$this->input->post('end_date');
			$hidformId 					= 	$this->input->post('hidformId');/*Edited for duplication checking 01-07-2019*/
			$copiedPrimaryValue 		= 	$this->input->post('copiedPrimaryValue_hidden');
			$start_date = explode('/', $start_date);
			$start_date = $start_date[2]."-".$start_date[1]."-".$start_date[0];
			if($end_date!='')
			{
				$end_date 	= explode('/', $end_date);
				$end_date 	= $end_date[2]."-".$end_date[1]."-".$end_date[0];
			}
			/*Edited for checking duplication (28-06-2019) starts*/
			$checkDupliList 		=	$this->Master_model->checkDuplication_copiedData($vesseltype_name,$vessel_subtype_name,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$hidformId);
			$cntrows				= 	count($checkDupliList);//print_r($checkDupliList);echo $cntrows;
			$data['checkDupliList']	=	$checkDupliList;
			$data 					= 	$data + $this->data;//exit();
			//--------------------------
			/*$chkduplication	=$this->Master_model->check_duplicationIns_dynamicPage($vesseltype_name,$vessel_subtype_name,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_sl); //,$start_date
			$cntrows		=count($chkduplication);*///print_r($chkduplication);echo $cntrows;exit();
			if($cntrows>0)
			{
				$db_end_date 		=	$checkDupliList[0]['end_date'];
				$db_start_date 		=	$checkDupliList[0]['start_date'];
			}
			if(($cntrows>0)&&($db_end_date!='0000-00-00')&&($db_end_date>=$start_date))
			{ 
				//echo "1-";echo $db_end_date;echo "cntrows>0";exit;
				//$db_end_date=$chkduplication[0]['end_date'];
				//if(($db_end_date!='0000-00-00')&&($db_end_date>=$start_date))
				//{//echo $db_end_date;echo "$db_end_date>=$start_date";exit;
				//echo "dataexisting";
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"> Dynamic Form With The Given Details Already Exists, New Start date should be greater than current End date!!!</div>');		
				redirect('Kiv_Ctrl/Master/copyDynamicform');
			}
			else if(($cntrows>0)&&($db_end_date=='0000-00-00'))
			{
				//echo "2-";echo "$db_end_date=='0000-00-00'";exit;
				//echo "enddatenull";
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"> Dynamic Form With The Given Details Already Exists, End date not Specified.</div>');		
				redirect('Kiv_Ctrl/Master/copyDynamicform');
			}
			else if((($cntrows>0)&&($start_date > $db_end_date)&&($start_date > $db_start_date))||($cntrows==0))
			{ 
				/*Edited for checking duplication (28-06-2019) ends*/
				$copiedPrimaryVal=explode(',', $copiedPrimaryValue);//print_r($copiedPrimaryVal);//exit;
				$this->load->model('Kiv_models/Master_model');
				foreach ($copiedPrimaryVal as  $copiedPrimaryId) 
				{
					$copiedPrimaryId;
					$copiedList				= 	$this->Master_model->get_copyData_selectedFormList($copiedPrimaryId);
					$data['copiedList']		=	$copiedList;
					$data 					= 	$data + $this->data;
					//print_r($copiedList);
					foreach ($copiedList as $key => $copiedList_val) 
					{					
						$form_id=$copiedList_val['form_id'];
						$heading_sl=$copiedList_val['heading_id'];
						$label_id=$copiedList_val['label_id'];
						$labvalues=$copiedList_val['value_id'];
						$label_value_status=$copiedList_val['label_value_status'];
						$status=$copiedList_val['status'];
						$delete_status=$copiedList_val['delete_status'];
						$insertData = array();
						$tempArray = array(					                      		
						'vesseltype_id' 					=>	$vesseltype_name,  
						'vessel_subtype_id' 				=> 	$vessel_subtype_name,
						'length_over_deck'					=>  $length_over_deck,
						'hullmaterial_id'					=>  $hullmaterial_id,
						'engine_inboard_outboard'			=>  $engine_inboard_outboard,
						'form_id' 							=> 	$form_id,
						'heading_id'						=>	$heading_sl,
						'label_id'							=>	$label_id,
						'value_id'							=>	$labvalues,
						'label_value_status'				=>  $label_value_status,
						'status'							=>  $status,
						'delete_status'						=>  $delete_status,
						'dynamic_field_created_user_id'		=> 	$sess_usr_id,
						'dynamic_field_created_timestamp'	=>	$date,
						'dynamic_field_created_ipaddress'	=>	$ip,
						'start_date'						=>	$start_date,
						'end_date'							=>	$end_date);
						array_push($insertData, $tempArray);//print_r($insertData);
						$insertData  = $this->security->xss_clean($insertData);
						$usr_res	 = $this->db->insert_batch('kiv_dynamic_field_master', $insertData);	
					}
				}
			}
			/*Edited for checking duplication (29-06-2019)*/
			if (isset($usr_res)) 
			{
				//echo "Inserted";
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Dynamic Form Copied And Added Successfully !!!</div>');		
				redirect('Kiv_ctrl/Master/copyDynamicform');
			}
		}
	}
}
/*Copy data based on the particular selected form */
/*____________________________________________________________________________________________________________________________________________*/

function dynamic_formHeading_Datalist_ajax()
{ 	   
   	$form_id=$_REQUEST['form_id'];
   	$heading_name=$_REQUEST['heading_name'];
    $this->load->model('Kiv_models/Master_model');
    $dataList			= 	$this->Master_model->get_copyData_formHead_dynamic($form_id,$heading_name);
    $data['dataList']	=	$dataList;
    $data 				= 	$data + $this->data;//print_r($dataList);			
    $this->load->view('Kiv_views/Master/copyFormHeading_Ajax.php', $data);
}
/*List table based on the selected form and heading*/
/*____________________________________________________________________________________________________________________________________________*/

function copyFormHeadingData_ajax()
{ 	  
	$vesselId 				= $this->uri->segment(4);
	$subvesselId 			= $this->uri->segment(5);
	$hullId 				= $this->uri->segment(6);
	$lengthOverDeck 		= $this->uri->segment(7);
	$engineInboardOutboard 	= $this->uri->segment(8);
	$formId 				= $this->uri->segment(9);
	$headingId 				= $this->uri->segment(10);
	$startDate 				= $this->uri->segment(11);
	$endDate 				= $this->uri->segment(12);
	$vesselName 			= $this->uri->segment(13);
	$subvesselName 			= $this->uri->segment(14);
	$hullName 				= $this->uri->segment(15);
	$boardName 				= $this->uri->segment(16);
	$hidformName 			= $this->uri->segment(17);
	$headingName 			= $this->uri->segment(18);
	$data['vesselName']		=	$vesselName;
	$data['subvesselName']	=	$subvesselName;
	$data['hullName']		=	$hullName;
	$data['boardName']		=	$boardName;
	$data['lengthOverDeck']	=	$lengthOverDeck;
	$data['hidformName']	=	$hidformName;
	$data['headingName']	=	$headingName;
	$data['startDate']		=	$startDate;
	$data['endDate']		=	$endDate;
	$data['hidformId']		=	$formId;/*Edited for duplication checking 01-07-2019*/
	$data['hidheadingId']	=	$headingId;/*Edited for duplication checking 01-07-2019*/
	$data 					= 	$data + $this->data;//exit;
	$this->load->model('Kiv_models/Master_model');
	$copiedData				= 	$this->Master_model->get_copyData_selectedFormHeading($vesselId,$subvesselId,$hullId,$lengthOverDeck,$engineInboardOutboard,$formId,$headingId,$startDate,$endDate);    
	$data['copiedData']		=	$copiedData;
	$data 					= 	$data + $this->data;//print_r($copiedData);
	$data 					= 	$data + $this->data;     
	$vessel_type			= 	$this->Master_model->get_vesseltype_dynamic();
	$data['vessel_type']	=	$vessel_type;
	$data 					= 	$data + $this->data;//print_r($vessel_type);exit;
	$data 					= 	$data + $this->data;     
	$formname				= 	$this->Master_model->get_formname_dynamic();
	$data['formname']		=	$formname;
	$data 					= 	$data + $this->data;//print_r($formname);exit;
	$data 					= 	$data + $this->data;     
	$hullmaterial			= 	$this->Master_model->get_hullmaterial_dynamic();
	$data['hullmaterial']	=	$hullmaterial;
	$data 					= 	$data + $this->data;//print_r($hullmaterial);exit;
	$data 					= 	$data + $this->data;     
	$boardtype				= 	$this->Master_model->get_inboard_outboard_dynamic();
	$data['boardtype']		=	$boardtype;
	$data 					= 	$data + $this->data;//print_r($boardtype);exit;			
	$this->load->view('Kiv_views/Master/addCopiedFormHeading_Ajax.php', $data);
	$sess_usr_id 	= 	$this->session->userdata('int_userid');
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());
	if (isset($_REQUEST['dynamicCopy_ins'])=="Copy Details") 
	{  
		$this->form_validation->set_rules('vesseltype_name', 'Vessel Type Name', 'required');
		$this->form_validation->set_rules('hullmaterial_name', 'Hull Material Name', 'required');
		$this->form_validation->set_rules('length_over_deck', 'Length Over the Deck', 'required|callback_num_check');
		$this->form_validation->set_rules('engine_inboard_outboard', 'Engine Inboard or Outboard', 'required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'required');
		if ($this->form_validation->run() == FALSE)
		{         
			$this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
			redirect('Kiv_Ctrl/Master/copyDynamicform');			
		}
		else 
		{					
			$vesseltype_name			= 	$this->input->post('vesseltype_name');
			$vessel_subtype_name 		= 	$this->input->post('vessel_subtype_name');
			$length_over_deck 			= 	$this->input->post('length_over_deck');
			$hullmaterial_id 			= 	$this->input->post('hullmaterial_name');
			$engine_inboard_outboard 	= 	$this->input->post('engine_inboard_outboard');
			$start_date 				= 	$this->input->post('start_date');
			$end_date 					= 	$this->input->post('end_date');
			$hidformId 					= 	$this->input->post('hidformId');/*Edited for duplication checking 01-07-2019*/
			$hidheadingId 				= 	$this->input->post('hidheadingId');/*Edited for duplication checking 01-07-2019*/
			$copiedPrimaryValue 		= 	$this->input->post('copiedPrimaryValue_hidden');
			$start_date = explode('/', $start_date);
			$start_date = $start_date[2]."-".$start_date[1]."-".$start_date[0];
			if($end_date!='')
			{
				$end_date 	= explode('/', $end_date);
				$end_date 	= $end_date[2]."-".$end_date[1]."-".$end_date[0];
			}
			$copiedPrimaryVal=explode(',', $copiedPrimaryValue);//print_r($copiedPrimaryVal);exit;
			/*Edited for checking duplication (28-06-2019) starts*/
			$checkDupliList 		=	$this->Master_model->checkDuplication_copiedHeadingData($vesseltype_name,$vessel_subtype_name,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$hidformId,$hidheadingId);
			$cntrows				= 	count($checkDupliList);//print_r($checkDupliList);echo $cntrows;exit();
			$data['checkDupliList']	=	$checkDupliList;
			$data 					= 	$data + $this->data;
			if($cntrows>0)
			{
				$db_end_date 		=	$checkDupliList[0]['end_date'];
				$db_start_date 		=	$checkDupliList[0]['start_date'];
			}
			if(($cntrows>0)&&($db_end_date!='0000-00-00')&&($db_end_date>=$start_date))
			{ 
				//echo "1-";echo $db_end_date;echo "cntrows>0";exit;
				//$db_end_date=$chkduplication[0]['end_date'];
				//if(($db_end_date!='0000-00-00')&&($db_end_date>=$start_date))
				//{//echo $db_end_date;echo "$db_end_date>=$start_date";exit;
				//echo "dataexisting";
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"> Dynamic Form With The Given Details Already Exists, New Start date should be greater than current End date!!!</div>');
				redirect('Kiv_Ctrl/Master/copyDynamicform');
			}
			else if(($cntrows>0)&&($db_end_date=='0000-00-00'))
			{
				//echo "2-";echo "$db_end_date=='0000-00-00'";exit;
				//echo "enddatenull";
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"> Dynamic Form With The Given Details Already Exists, End date not Specified.</div>');		
				redirect('Kiv_Ctrl/Master/copyDynamicform');
			}
			else if((($cntrows>0)&&($start_date > $db_end_date)&&($start_date > $db_start_date))||($cntrows==0))
			{
				/*Edited for checking duplication (28-06-2019) ends*/
				$this->load->model('Kiv_models/Master_model');
				foreach ($copiedPrimaryVal as  $copiedPrimaryId) 
				{
					$copiedPrimaryId;
					$copiedList				= 	$this->Master_model->get_copyData_selectedFormHeadingList($copiedPrimaryId);
					$data['copiedList']		=	$copiedList;
					$data 					= 	$data + $this->data;
					//print_r($copiedList);exit;
					foreach ($copiedList as $key => $copiedList_val) 
					{					
						$form_id=$copiedList_val['form_id'];
						$heading_sl=$copiedList_val['heading_id'];
						$label_id=$copiedList_val['label_id'];
						$labvalues=$copiedList_val['value_id'];
						$label_value_status=$copiedList_val['label_value_status'];
						$status=$copiedList_val['status'];
						$delete_status=$copiedList_val['delete_status'];
						$insertData = array();
						$tempArray = array(					                      		
						'vesseltype_id' 					=>	$vesseltype_name,  
						'vessel_subtype_id' 				=> 	$vessel_subtype_name,
						'length_over_deck'					=>  $length_over_deck,
						'hullmaterial_id'					=>  $hullmaterial_id,
						'engine_inboard_outboard'			=>  $engine_inboard_outboard,
						'form_id' 							=> 	$form_id,
						'heading_id'						=>	$heading_sl,
						'label_id'							=>	$label_id,
						'value_id'							=>	$labvalues,
						'label_value_status'				=>  $label_value_status,
						'status'							=>  $status,
						'delete_status'						=>  $delete_status,
						'dynamic_field_created_user_id'		=> 	$sess_usr_id,
						'dynamic_field_created_timestamp'	=>	$date,
						'dynamic_field_created_ipaddress'	=>	$ip,
						'start_date'						=>	$start_date,
						'end_date'							=>	$end_date);
						array_push($insertData, $tempArray);//print_r($insertData);
						$insertData  = $this->security->xss_clean($insertData);
						$usr_res	 = $this->db->insert_batch('kiv_dynamic_field_master', $insertData);	
					}
				}
			}
			/*Edited for checking duplication (29-06-2019)*/
			if (isset($usr_res)) 
			{
				//echo "Inserted";
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Dynamic Form Copied And Added Successfully !!!</div>');		
				redirect('Kiv_Ctrl/Master/copyDynamicform');
			}
		}
	}
}
/*Copy data based on the particular selected Form and Heading */
/*____________________________________________________________________________________________________________________________________________*/

// View Copy Dynamic Form starting...  (28-09-2018) 
//_____________________________________________________________________________________________________________________________________________

public function viewCopyDynamicform()
{	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'copy_dynamic_form_viewlist', 'page' => 'copy_dynamic_form_viewlist', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$dynamic_form			= 	$this->Master_model->get_view_copyDynamicForm_list();
		$data['dynamic_form']	=	$dynamic_form;
		$data 					= 	$data + $this->data;//print_r($dynamic_form);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/copy_dynamic_form_viewlist.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');                
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// List -View Copy Dynamic Form end
/*____________________________________________________________________________________________________________________________________________*/
/*Detailed List -View Copy Dynamic Form starts*/

public function detListViewCopyDynamicform()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'copy_dynamic_form_detViewlist', 'page' => 'copy_dynamic_form_detViewlist', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$vesseltype_id   		=	$this->uri->segment(4);
		$vess_sub_id 			=	$this->uri->segment(5);
		$length_over_deck   	=	$this->uri->segment(6);
		$hullmaterial_id   		=	$this->uri->segment(7);
		$engine_inboard_outboard=	$this->uri->segment(8);
		$form_id   				=	$this->uri->segment(9);
		$start_date   			=	$this->uri->segment(10);
		$end_date   			=	$this->uri->segment(11);
		$data 					= 	$data + $this->data;     
		$dynamic_form			= 	$this->Master_model->get_view_copyDynamicForm_detList($vesseltype_id,$vess_sub_id,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$start_date,$end_date);
		$data['dynamic_form']	=	$dynamic_form;
		$data 					= 	$data + $this->data;//print_r($dynamic_form);//exit;	
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/copy_dynamic_form_detViewlist.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');                
	}
	else
	{
		redirect('Main_login/index');        
	}  
}


// Detailed List -View Copy Dynamic Form end
/*____________________________________________________________________________________________________________________________________________*/

/*                                                           Dynamic Page Ends                                                                */     
/*____________________________________________________________________________________________________________________________________________*/

/*____________________________________________________________________________________________________________________________________________*/	

//                                                                TARIFF
//____________________________________________________________________________________________________________________________________________	

// Tariff starting...  (01-10-2018) 
//_____________________________________________________________________________________________________________________________________________
/*Tariff Entry Page, to add the tariff details*/

public function addTariff()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'tariff_add', 'page' => 'tariff_add', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$surveyType			= 	$this->Master_model->get_survey_type();
		$data['surveyType']	=	$surveyType;
		$data 				= 	$data + $this->data;//print_r($surveyType);exit;
		$formName			= 	$this->Master_model->get_formname_dynamic();
		$data['formName']	=	$formName;
		$data 				= 	$data + $this->data;//print_r($formName);exit;
		$vesselType			= 	$this->Master_model->get_vesseltype_dynamic();
		$data['vesselType']	=	$vesselType;
		$data 				= 	$data + $this->data;//print_r($vesselType);exit;
		$tonnage			= 	$this->Master_model->get_tonnage_type();
		$data['tonnage']	=	$tonnage;
		$data 				= 	$data + $this->data;//print_r($tonnage);exit;
		$tariffDay			= 	$this->Master_model->get_tariffDay_type();
		$data['tariffDay']	=	$tariffDay;
		$data 				= 	$data + $this->data;//print_r($tariffDay);exit;
		$tariffList			= 	$this->Master_model->get_tariffList();
		$data['tariffList']	=	$tariffList;
		$data 				= 	$data + $this->data;//print_r($tariffList);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/tariff_add',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');  
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

// Add Tariff View End.
/*____________________________________________________________________________________________________________________________________________*/	

function tariff_vesselsubtype_ajax()
 { 	   
	$vesseltype_id=$_REQUEST['vesseltype_id'];
	$this->load->model('Kiv_models/Master_model');
	$vesselsub_type			= 	$this->Master_model->get_vesselsubtype_dynamic($vesseltype_id);
	$data['vesselsub_type']	=	$vesselsub_type;
	$data 					= 	$data + $this->data;
	$cnt=count($vesselsub_type);
	if($cnt!=0)
	{
		echo '<option value="">Select Vessel Sub Type</option>';           	
		echo '<option value="9999">All</option>';
		foreach ($vesselsub_type as $vesselsub_type_vals) 
		{
			$vessel_subtype_sl=$vesselsub_type_vals['vessel_subtype_sl'];
			$vessel_subtype_name=$vesselsub_type_vals['vessel_subtype_name'];
			echo '<option value="'.$vessel_subtype_sl.'">'.$vessel_subtype_name.'</option>';
		}
	}
}
// Add Vessel Subtype for Tariff.
/*____________________________________________________________________________________________________________________________________________*/	

/*____________________________________________List Tariff Details, On click Add Tariff Button__________________________________________________*/
/*START*/

function viewTariff_Ajax()
{ 
	$surveyName 		= $this->uri->segment(4);
	$formtypeName 		= $this->uri->segment(5);
	$vesseltype_name 	= $this->uri->segment(6);
	$vessel_subtype_name= $this->uri->segment(7);
	$startDate 			= $this->uri->segment(8);
	$endDate 			= $this->uri->segment(9);
	if($vesseltype_name==9999)/*For All Vessels*/
	{
		$tariffTable			= 	$this->Master_model->get_tariffTable_Novessel($surveyName,$formtypeName,$startDate,$endDate);
		$data['tariffTable']	=	$tariffTable;
		$data 					= 	$data + $this->data; //print_r($tariffTable);
	}
	else if($vessel_subtype_name==9999)/*For particular Vessel, and for all sub vessels under the particular vessel type*/
	{
		$tariffTable			= 	$this->Master_model->get_tariffTable_Nosubvessel($surveyName,$formtypeName,$vesseltype_name,$startDate,$endDate);
		$data['tariffTable']	=	$tariffTable;
		$data 					= 	$data + $this->data; //print_r($tariffTable);		
	}
	else/*All conditions, that has been selected*/
	{
		$tariffTable			= 	$this->Master_model->get_tariffTable($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate);
		$data['tariffTable']	=	$tariffTable;
		$data 					= 	$data + $this->data; //print_r($tariffTable);
	}
	$this->load->view('Kiv_views/Master/tariffListAjax.php', $data);
}

/*___________________________________________To Insert Tariff Details, On click ADD button__________________________________________*/
/*START*/

function addTariff_Ajax()
{	
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 	= 	date('Y-m-d h:i:s', time());	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	$surveyName 		= $this->uri->segment(4);//$surveyName=validate_segment('3', 'required');
	$formtypeName 		= $this->uri->segment(5);
	$vesseltype_name 	= $this->uri->segment(6);
	$vessel_subtype_name= $this->uri->segment(7);
	$startDate 			= $this->uri->segment(8);
	$endDate 			= $this->uri->segment(9);
	$tonnage_type 		= $this->uri->segment(10);
	$from_ton 			= $this->uri->segment(11);
	$to_ton 			= $this->uri->segment(12);
	//$per_ton 			= $this->uri->segment(13);
	$day_type 			= $this->uri->segment(13);
	$from_day 			= $this->uri->segment(14);
	$to_day 			= $this->uri->segment(15);
	$amount 			= $this->uri->segment(16);
	$min_amount 		= $this->uri->segment(17);
	$fine_amount 		= $this->uri->segment(18);
	if($vesseltype_name==9999)/*All vessels selected*/
	{
		$tariffDupliList			= 	$this->Master_model->check_tariffMaster_duplication_noves($surveyName,$formtypeName,$startDate,$endDate,$tonnage_type,$from_ton,$to_ton,$day_type,$from_day,$to_day,$amount);
		$data['tariffDupliList']	=	$tariffDupliList;
		$data 					= 	$data + $this->data; //echo "1st";print_r($tariffDupliList);//echo count($tariffDupliList);exit;
		/*To get the tonnage type,day type.... to block, adding different tonnage types and day type (26-10-2018) */
		$tonnageTypeId			= 	$this->Master_model->get_tonnageTypeId_noves($surveyName,$formtypeName,$startDate,$endDate);
		$data['tonnageTypeId']	=	$tonnageTypeId;//print_r($tonnageTypeId);
	}
	else if($vessel_subtype_name==9999)/*Single vessel and all sub vessel under that particular vessel*/
	{
		$tariffDupliList			= 	$this->Master_model->check_tariffMaster_duplication_nosubves($surveyName,$formtypeName,$vesseltype_name,$startDate,$endDate,$tonnage_type,$from_ton,$to_ton,$day_type,$from_day,$to_day,$amount);
		$data['tariffDupliList']	=	$tariffDupliList;
		$data 					= 	$data + $this->data; //echo "2nd";//print_r($tariffDupliList);echo count($tariffDupliList);exit;
		/*To get the tonnage type,day type.... to block, adding different tonnage types and day type (26-10-2018) */
		$tonnageTypeId			= 	$this->Master_model->get_tonnageTypeId_nosubves($surveyName,$formtypeName,$vesseltype_name,$startDate,$endDate);
		$data['tonnageTypeId']	=	$tonnageTypeId;//print_r($tonnageTypeId);		
	}
	else/*Single vessel and sub vessel*/
	{
		$tariffDupliList			= 	$this->Master_model->check_tariffMaster_duplication($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate,$tonnage_type,$from_ton,$to_ton,$day_type,$from_day,$to_day,$amount);
		$data['tariffDupliList']	=	$tariffDupliList;
		$data 					= 	$data + $this->data;//echo "3rd";//print_r($tariffDupliList);echo count($tariffDupliList);exit;
		/*To get the tonnage type,day type.... to block, adding different tonnage types and day type (26-10-2018) */
		$tonnageTypeId			= 	$this->Master_model->get_tonnageTypeId($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate);
		$data['tonnageTypeId']	=	$tonnageTypeId;//print_r($tonnageTypeId);
	}
	/*To get the tonnage type,day type.... to block, adding different tonnage types and day type (26-10-2018)*/	
	if(count($tonnageTypeId)!=0)
	{
		$tonnageTypeId_db		=	$tonnageTypeId[0]['tariff_tonnagetype_id'];
		$dayTypeId_db			=	$tonnageTypeId[0]['tariff_day_type'];//exit;
	}
	if(count($tonnageTypeId)==0)
	{
		$tonnageTypeId_db=$tonnage_type;
		$dayTypeId_db=$day_type;
	}
	/*To get the tonnage type,day type.... to block, adding different tonnage types and day type (26-10-2018)*/	
	if(($tonnageTypeId_db==$tonnage_type)&&($dayTypeId_db==$day_type))
	{
		if(count($tariffDupliList)==0)
		{
			if($vesseltype_name==9999)
			{
				$vesselType			= 	$this->Master_model->get_vesseltypeId_tariff();
				$data['vesselType']	=	$vesselType; //print_r($vesselType);exit;
				foreach ($vesselType as $value) 
				{	
					$vesseltype_name=$value['vesseltype_sl'];
					$vessel_subtype_name=$value['vessel_subtype_sl'];	
					if($vessel_subtype_name=='')
					{
						$vessel_subtype_name=0;
					}
					$insertData = array();
					$tempArray =  array(
					'tariff_activity_id' 	  =>	$surveyName,  
					'tariff_form_id' 		  => 	$formtypeName,
					'tariff_vessel_type_id'   => 	$vesseltype_name,
					'tariff_vessel_subtype_id'=>	$vessel_subtype_name,
					'tariff_tonnagetype_id'   =>    $tonnage_type,
					'tariff_from_ton'   	  => 	$from_ton,
					'tariff_to_ton'           =>	$to_ton,
					//'tariff_per_ton' 		  => 	$per_ton,
					'tariff_day_type'         =>    $day_type,
					'tariff_from_day'  		  =>    $from_day,
					'tariff_to_day'   	      => 	$to_day,
					'tariff_amount'           =>	$amount,
					'tariff_min_amount'       =>    $min_amount,
					'tariff_fine_amount'  	  => 	$fine_amount,
					'tariff_created_user_id'  => 	$sess_usr_id,
					'tariff_created_timestamp'=>	$date,
					'tariff_created_ipaddress'=>	$ip,
					'start_date' 			  =>	$startDate,
					'end_date' 				  =>	$endDate);
					array_push($insertData, $tempArray);
					$insertData  = $this->security->xss_clean($insertData);
					$usr_res	 = $this->db->insert_batch('kiv_tariff_master', $insertData);	
				}
			}
			else if(($vesseltype_name!=9999)&&($vessel_subtype_name==9999))
			{
				$vesselsubType		    = 	$this->Master_model->get_vesselsubtypeId_tariff($vesseltype_name);
				$data['vesselsubType']	=	$vesselsubType; //print_r($vesselsubType);exit;
				foreach ($vesselsubType as $value) 
				{			
					$vessel_subtype_name=$value['vessel_subtype_sl'];
					$insertData = array();
					$tempArray =  array(
					'tariff_activity_id' 	  =>	$surveyName,  
					'tariff_form_id' 		  => 	$formtypeName,
					'tariff_vessel_type_id'   => 	$vesseltype_name,
					'tariff_vessel_subtype_id'=>	$vessel_subtype_name,
					'tariff_tonnagetype_id'   =>    $tonnage_type,
					'tariff_from_ton'   	  => 	$from_ton,
					'tariff_to_ton'           =>	$to_ton,
					//'tariff_per_ton' 		  => 	$per_ton,
					'tariff_day_type'         =>    $day_type,
					'tariff_from_day'  		  =>    $from_day,
					'tariff_to_day'   	      => 	$to_day,
					'tariff_amount'           =>	$amount,
					'tariff_min_amount'       =>    $min_amount,
					'tariff_fine_amount'  	  => 	$fine_amount,
					'tariff_created_user_id'  => 	$sess_usr_id,
					'tariff_created_timestamp'=>	$date,
					'tariff_created_ipaddress'=>	$ip,
					'start_date' 			  =>	$startDate,
					'end_date' 				  =>	$endDate);
					array_push($insertData, $tempArray);
					$insertData  = $this->security->xss_clean($insertData);
					$usr_res	 = $this->db->insert_batch('kiv_tariff_master', $insertData);	
				}
			}
			else
			{
				$data = array(
				'tariff_activity_id' 	  =>	$surveyName,  
				'tariff_form_id' 		  => 	$formtypeName,
				'tariff_vessel_type_id'   => 	$vesseltype_name,
				'tariff_vessel_subtype_id'=>	$vessel_subtype_name,
				'tariff_tonnagetype_id'   =>    $tonnage_type,
				'tariff_from_ton'   	  => 	$from_ton,
				'tariff_to_ton'           =>	$to_ton,
				//'tariff_per_ton' 		  => 	$per_ton,
				'tariff_day_type'         =>    $day_type,
				'tariff_from_day'  		  =>    $from_day,
				'tariff_to_day'   	      => 	$to_day,
				'tariff_amount'           =>	$amount,
				'tariff_min_amount'       =>    $min_amount,
				'tariff_fine_amount'  	  => 	$fine_amount,
				'tariff_created_user_id'  => 	$sess_usr_id,
				'tariff_created_timestamp'=>	$date,
				'tariff_created_ipaddress'=>	$ip,
				'start_date' 			  =>	$startDate,
				'end_date' 				  =>	$endDate);
				$data   = $this->security->xss_clean($data);
				$usr_res= $this->db->insert('kiv_tariff_master', $data);
			}
			$tariffTable			= 	$this->Master_model->get_tariffTable($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate);
			$data['tariffTable']	=	$tariffTable;
			$data 					= 	$data + $this->data;//echo count($tariffTable);print_r($tariffTable);//exit;
			if($usr_res)
			{
				$this->load->view('Kiv_views/Master/tariffListAjax.php', $data);
			}	
		}
		else
		{
			echo '<div class="alert alert-danger text-center">Sorry, Given Tariff Details Already Exists!!!</div>';
		}
	}
	else
	{
		echo '<div class="alert alert-danger text-center">Please Select the same Tonnage type and Day type, that you have already entered for the above selected data.!!!</div>';
	}
}

/*END*/
/*______________________________________________________________To Insert Tariff Details__________________________________________________*/

/*____________________________________________________________Edit Tariff Details_________________________________________________________*/
/*START*/
function editTariff_ajax()
{	
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 	= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	/*get data from page, */
	/*edited data from page -to update on db*/
	$id 				= $this->uri->segment(4);
	$tariff_from_ton 	= $this->uri->segment(5);
	$tariff_to_ton 		= $this->uri->segment(6);
	//$tariff_per_ton 	= $this->uri->segment(7);
	$tariff_from_day 	= $this->uri->segment(7);
	$tariff_to_day 		= $this->uri->segment(8);
	$tariff_amount 		= $this->uri->segment(9);
	$tariff_min_amount 	= $this->uri->segment(10);
	$tariff_fine_amount = $this->uri->segment(11);
	/*edited data from page -to update on db*/
	/*data selected from page*/
	$surveyName 		= $this->uri->segment(12);
	$formtypeName 		= $this->uri->segment(13);
	$vesseltype_name 	= $this->uri->segment(14);
	$vessel_subtype_name= $this->uri->segment(15);
	$startDate 			= $this->uri->segment(16);
	$endDate 			= $this->uri->segment(17);
	/*data selected from page*/
	/*data fetched from db*/
	$tonnage_type 		= $this->uri->segment(18);
	$day_type 			= $this->uri->segment(19);
	$hidden_from_ton 	= $this->uri->segment(20);
	$hidden_to_ton 		= $this->uri->segment(21);
	//$hidden_per_ton 	= $this->uri->segment(23);	
	$hidden_from_day 	= $this->uri->segment(22);
	$hidden_to_day 		= $this->uri->segment(23);
	$hidden_amount 		= $this->uri->segment(24);	
	$hidden_min_amount 	= $this->uri->segment(25);
	$hidden_fine_amount = $this->uri->segment(26);
	/*data fetched from db*/
	/*get data from page, */

	if($vesseltype_name==9999)
	{
		//$tariff_Updt_data=$this->Master_model->get_tariffMaster_noVesl_Upd_data($surveyName,$formtypeName,$startDate,$endDate,$tonnage_type,$hidden_from_ton,$hidden_to_ton,$day_type,$hidden_from_day,$hidden_to_day,$hidden_amount,$hidden_min_amount,$hidden_fine_amount);
		/*To check new values already exists in db*/
		$tariff_Updt_data=$this->Master_model->get_tariffMaster_noVesl_Upd_data($surveyName,$formtypeName,$startDate,$endDate,$tonnage_type,$tariff_from_ton,$tariff_to_ton,$day_type,$tariff_from_day,$tariff_to_day,$tariff_amount,$tariff_min_amount,$tariff_fine_amount);
		$data['tariff_Updt_data']	=	$tariff_Updt_data;
		$data 					= 	$data + $this->data;//echo "1st";print_r($tariff_Updt_data);echo count($tariff_Updt_data);//exit;
		/*To get the existing data(in db) of the current entry*/
		/*$tariff_db_data=$this->Master_model->get_tariffMaster_noVesl_Upd_data1($surveyName,$formtypeName,$startDate,$endDate,$tonnage_type,$hidden_from_ton,$hidden_to_ton,$day_type,$hidden_from_day,$hidden_to_day,$hidden_amount,$hidden_min_amount,$hidden_fine_amount);
		$data['tariff_db_data']	=	$tariff_db_data;
		$data 					= 	$data + $this->data;*///echo "2st";print_r($tariff_db_data);echo count($tariff_db_data);//exit;
	}
	else if($vessel_subtype_name==9999)
	{
		//$tariff_Updt_data=$this->Master_model->get_tariffMaster_noSubvesl_Upd_data($surveyName,$formtypeName,$vesseltype_name,$startDate,$endDate,$tonnage_type,$hidden_from_ton,$hidden_to_ton,$day_type,$hidden_from_day,$hidden_to_day,$hidden_amount,$hidden_min_amount,$hidden_fine_amount);
		$tariff_Updt_data=$this->Master_model->get_tariffMaster_noSubvesl_Upd_data($surveyName,$formtypeName,$vesseltype_name,$startDate,$endDate,$tonnage_type,$tariff_from_ton,$tariff_to_ton,$day_type,$tariff_from_day,$tariff_to_day,$tariff_amount,$tariff_min_amount,$tariff_fine_amount);
		$data['tariff_Updt_data']	=	$tariff_Updt_data;
		$data 					= 	$data + $this->data;//echo "2nd";print_r($tariff_Updt_data);echo count($tariff_Updt_data);exit;	
	}
	else
	{
		//$tariff_Updt_data=$this->Master_model->get_tariffMaster_Upd_data($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate,$tonnage_type,$hidden_from_ton,$hidden_to_ton,$day_type,$hidden_from_day,$hidden_to_day,$hidden_amount,$hidden_min_amount,$hidden_fine_amount);
		$tariff_Updt_data=$this->Master_model->get_tariffMaster_Upd_data($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate,$tonnage_type,$tariff_from_ton,$tariff_to_ton,$day_type,$tariff_from_day,$tariff_to_day,$tariff_amount,$tariff_min_amount,$tariff_fine_amount);
		$data['tariff_Updt_data']	=	$tariff_Updt_data;
		$data 					= 	$data + $this->data;//echo "3rd";//echo count($tariff_Updt_data);print_r($tariff_Updt_data);exit;
	}
	/*foreach ($labelss as $value) 
	{          				
	$all_label=$value['label_id']; 
	$all_label=(int)$all_label;

	if(in_array($all_label, $label_id))
	{
	$id=trim($all_label);//echo "-";
	$labvalues=$_REQUEST['lab_values_'.$id];//echo "<br>";//exit;
	}
	}
	*/
	/*To load the existing data from db*/
	/*$existsData			= 	$this->Master_model->get_tariffMaster_list($id);
	$data['existsData']	=	$existsData;
	$data 				= 	$data + $this->data;
	//print_r($existsData);
	$tariff_activity_id=$existsData[0]['tariff_activity_id'];
	$tariff_form_id=$existsData[0]['tariff_form_id'];
	$tariff_vessel_type_id=$existsData[0]['tariff_vessel_type_id'];
	$tariff_vessel_subtype_id=$existsData[0]['tariff_vessel_subtype_id'];
	$start_date=$existsData[0]['start_date'];
	$end_date=$existsData[0]['end_date'];
	$tariff_tonnagetype_id=$existsData[0]['tariff_tonnagetype_id'];
	$tariff_day_type=$existsData[0]['tariff_day_type'];
	$tariff_from_ton_db=$existsData[0]['tariff_from_ton'];
	$tariff_to_ton_db=$existsData[0]['tariff_to_ton'];
	$tariff_per_ton_db=$existsData[0]['tariff_per_ton'];
	$tariff_from_day_db=$existsData[0]['tariff_from_day'];
	$tariff_to_day_db=$existsData[0]['tariff_to_day'];
	$tariff_amount_db=$existsData[0]['tariff_amount'];
	$tariff_min_amount_db=$existsData[0]['tariff_min_amount'];
	$tariff_fine_amount_db=$existsData[0]['tariff_fine_amount'];*/
	/*To load the existing data from db*/
	/*$tariffDupliUpdt=$this->Master_model->check_tariffMaster_Upd_duplication($tariff_activity_id,$tariff_form_id,$tariff_vessel_type_id,$tariff_vessel_subtype_id,$start_date,$end_date,$tariff_tonnagetype_id,$tariff_from_ton,$tariff_to_ton,$tariff_per_ton,$tariff_day_type,$tariff_from_day,$tariff_to_day,$id);
	$data['tariffDupliUpdt']	=	$tariffDupliUpdt;
	$data 					= 	$data + $this->data;//print_r($tariffDupliUpdt);echo count($tariffDupliUpdt);exit;*/
	/*$c=var_dump($tariff_Updt_data===$tariff_db_data); print_r($c);
	if($tariff_Updt_data===$tariff_db_data){echo "same";}else{echo "diff";}exit;*/
	if(count($tariff_Updt_data)==0)
	{
		if($vesseltype_name==9999)
		{
			$vesselType			= 	$this->Master_model->get_vesseltypeId_tariff();
			$data['vesselType']	=	$vesselType; //print_r($vesselType);exit;
			foreach ($vesselType as $value) 
			{	
				$vesseltype_name=$value['vesseltype_sl'];
				$vessel_subtype_name=$value['vessel_subtype_sl'];	
				if($vessel_subtype_name=='')
				{
					$vessel_subtype_name=0;
				}
				$data = array(
				'tariff_from_ton'			=>	$tariff_from_ton,
				'tariff_to_ton'				=>	$tariff_to_ton,
				//'tariff_per_ton'			=>  $tariff_per_ton,
				'tariff_from_day' 			=>  $tariff_from_day,
				'tariff_to_day'				=> 	$tariff_to_day,
				'tariff_amount'				=>	$tariff_amount,
				'tariff_min_amount'			=>	$tariff_min_amount,
				'tariff_fine_amount'		=>	$tariff_fine_amount,
				'tariff_modified_user_id'  	=> 	$sess_usr_id,
				'tariff_modified_timestamp'	=>	$date,
				'tariff_modified_ipaddress'	=>	$ip);
				$data  = $this->security->xss_clean($data);
				/*if(($tonnage_type==3)||($day_type==2))
				{
				//$where=	"(((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') AND ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton')) AND ((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') AND ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day')))";
				$this->db->where('tariff_from_ton',$tariff_from_ton);
				$this->db->where('tariff_to_ton',$tariff_to_ton);
				}
				if(($tonnage_type==1)||($tonnage_type==2))
				{
				$where=	"((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') AND ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day'))";
				}
				if($day_type==1)
				{
				$where=	"((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') AND ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton'))";
				}*/
				//$this->db->where('tariff_sl', $id);
				$this->db->where('tariff_activity_id',$surveyName);
				$this->db->where('tariff_form_id',$formtypeName);
				$this->db->where('start_date',$startDate);
				$this->db->where('end_date',$endDate);
				$this->db->where('tariff_tonnagetype_id',$tonnage_type);
				$this->db->where('tariff_from_ton',$hidden_from_ton);
				$this->db->where('tariff_to_ton',$hidden_to_ton);
				$this->db->where('tariff_day_type',$day_type);
				$this->db->where('tariff_from_day',$hidden_from_day);
				$this->db->where('tariff_to_day', $hidden_to_day);
				$this->db->where('tariff_amount',$hidden_amount);
				$this->db->where('tariff_min_amount',$hidden_min_amount);
				$this->db->where('tariff_fine_amount', $hidden_fine_amount);
				//$this->db->where($where);
				$usr_res=$this->db->update('kiv_tariff_master', $data);
			}
		}
		else if(($vesseltype_name!=9999)&&($vessel_subtype_name==9999))
		{
			$vesselsubType		    = 	$this->Master_model->get_vesselsubtypeId_tariff($vesseltype_name);
			$data['vesselsubType']	=	$vesselsubType; //print_r($vesselsubType);exit;
			foreach ($vesselsubType as $value) 
			{			
				$vessel_subtype_name=$value['vessel_subtype_sl'];
				$data = array(
				'tariff_from_ton'			=>	$tariff_from_ton,
				'tariff_to_ton'				=>	$tariff_to_ton,
				//'tariff_per_ton'			=>  $tariff_per_ton,
				'tariff_from_day' 			=>  $tariff_from_day,
				'tariff_to_day'				=> 	$tariff_to_day,
				'tariff_amount'				=>	$tariff_amount,
				'tariff_min_amount'			=>	$tariff_min_amount,
				'tariff_fine_amount'		=>	$tariff_fine_amount,
				'tariff_modified_user_id'  	=> 	$sess_usr_id,
				'tariff_modified_timestamp'	=>	$date,
				'tariff_modified_ipaddress'	=>	$ip);
				$data  = $this->security->xss_clean($data);		
				//$this->db->where('tariff_sl', $id);
				/*if(($tonnage_type==3)||($day_type==2))
				{
				$where=	"(((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') AND ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton')) AND ((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') AND ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day')))";
				}
				if(($tonnage_type==1)||($tonnage_type==2))
				{
				$where=	"((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') AND ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day'))";
				}
				if($day_type==1)
				{
				$where=	"((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') AND ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton'))";
				}
				$this->db->where($where);*/
				$this->db->where('tariff_activity_id',$surveyName);
				$this->db->where('tariff_form_id',$formtypeName);
				$this->db->where('start_date',$startDate);
				$this->db->where('end_date',$endDate);
				$this->db->where('tariff_tonnagetype_id',$tonnage_type);
				$this->db->where('tariff_from_ton',$hidden_from_ton);
				$this->db->where('tariff_to_ton',$hidden_to_ton);
				$this->db->where('tariff_day_type',$day_type);
				$this->db->where('tariff_from_day',$hidden_from_day);
				$this->db->where('tariff_to_day', $hidden_to_day);
				$this->db->where('tariff_amount',$hidden_amount);
				$this->db->where('tariff_min_amount',$hidden_min_amount);
				$this->db->where('tariff_fine_amount', $hidden_fine_amount);
				$usr_res=$this->db->update('kiv_tariff_master', $data);	
			}
		}
		else
		{
			$data = array(
			'tariff_from_ton'			=>	$tariff_from_ton,
			'tariff_to_ton'				=>	$tariff_to_ton,
			//'tariff_per_ton'			=>  $tariff_per_ton,
			'tariff_from_day' 			=>  $tariff_from_day,
			'tariff_to_day'				=> 	$tariff_to_day,
			'tariff_amount'				=>	$tariff_amount,
			'tariff_min_amount'			=>	$tariff_min_amount,
			'tariff_fine_amount'		=>	$tariff_fine_amount,
			'tariff_modified_user_id'  	=> 	$sess_usr_id,
			'tariff_modified_timestamp'	=>	$date,
			'tariff_modified_ipaddress'	=>	$ip);
			$data  = $this->security->xss_clean($data);		
			$this->db->where('tariff_sl', $id);
			$usr_res=$this->db->update('kiv_tariff_master', $data);
		}
		/*To load/refresh the div to view the updated data */
		$tariffTable			= 	$this->Master_model->get_tariffTable($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate);
		$data['tariffTable']	=	$tariffTable;
		$data 					= 	$data + $this->data;//echo count($tariffTable);print_r($tariffTable);//exit;
		/*To load/refresh the div to view the updated data */
		if($usr_res)
		{
			echo '<div class="alert alert-success text-center">Tariff Details Updated!!!</div>';
			//echo "updated";	
			$this->load->view('Kiv_views/Master/tariffListAjax.php', $data);
		}
		else
		{
			echo "Some Errors !!!";
		}
	}
	else
	{
		echo '<div class="alert alert-danger text-center">Sorry. Cannot Update Tariff, Details You Entered Already Exists!!!</div>';
		//echo "existing";
	}				
}
/*END*/
/*____________________________________________________________Edit Tariff Details_________________________________________________________*/

/*____________________________________________________________Delete Tariff Details________________________________________________________*/
/*Start*/
function deleteTariff_ajax()
{	
	$ip		=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 	= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	$surveyName 		= $this->uri->segment(4);
	$formtypeName 		= $this->uri->segment(5);
	$vesseltype_name 	= $this->uri->segment(6);
	$vessel_subtype_name= $this->uri->segment(7);
	$startDate 			= $this->uri->segment(8);
	$endDate 			= $this->uri->segment(9);
	$id 				= $this->uri->segment(10);
	$data = array('delete_status'	=>	1);
	$data  = $this->security->xss_clean($data);		
	$this->db->where('tariff_sl', $id);
	$usr_res=$this->db->update('kiv_tariff_master', $data);
	/*To load/refresh the div to view the updated data */
	$tariffTable			= 	$this->Master_model->get_tariffTable($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate);
	$data['tariffTable']	=	$tariffTable;
	$data 					= 	$data + $this->data;//echo count($tariffTable);print_r($tariffTable);//exit;
	/*To load/refresh the div to view the updated data */
	if($usr_res)
	{
		echo '<div class="alert alert-danger text-center">Tariff Details Deleted!!!</div>';
		$this->load->view('Kiv_views/Master/tariffListAjax.php', $data);
	}
	else
	{
		echo "Some Errors !!!";
	}
}
/*End*/
/*____________________________________________________________________________________________________________________________________________*/

/*																VIEW TARIFF 																  */
/*____________________________________________________________________________________________________________________________________________*/
/*Starts, view tariff (15-10-2018)*/

public function viewTariff()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{
		$data =	array('title' => 'tariff_view', 'page' => 'tariff_view', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$tariff_list			= 	$this->Master_model->get_view_tariffList();
		$data['tariff_list']	=	$tariff_list;
		$data 					= 	$data + $this->data;//print_r($tariff_list);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/tariff_view.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');   
	}
	else
	{
		redirect('Main_login/index');        
	} 
}

/*Ends view tariff(15-10-2018)*/

/*____________________________________________________________________________________________________________________________________________*/
/*Detailed View - of Tariff starts (15-10-2018)*/

public function detViewTariff()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id)&&($int_usertype==10))
	{	
		$data =	array('title' => 'tariff_det_view', 'page' => 'tariff_det_view', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$activity_id   		=	$this->uri->segment(4);
		$form_id 			=	$this->uri->segment(5);
		$vessel_type_id   	=	$this->uri->segment(6);
		$vessel_subtype_id  =	$this->uri->segment(7);
		$start_date   		=	$this->uri->segment(8);
		$end_date   		=	$this->uri->segment(9);
		/*$data 					= 	$data + $this->data;     
		$detView_Tariff			= 	$this->Master_model->get_tariffDetView($tariff_id);
		$data['detView_Tariff']	=	$detView_Tariff;
		$data 					= 	$data + $this->data;//print_r($detView_Tariff);//exit;*/
		$detTariffTable			= 	$this->Master_model->get_det_tariffTable($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$start_date,$end_date);
		$data['detTariffTable']	=	$detTariffTable;
		$data 					= 	$data + $this->data; //print_r($detTariffTable);
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/tariff_det_view.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
	}
	else
	{
		redirect('Main_login/index');        
	}  
}
/*Detailed View - of Tariff ends. (15-10-2018)*/

/*____________________________________________________________________________________________________________________________________________*/


/*=========================================Web Notification(Start)======================================================*/
public function web_notfn()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{
		$data =	array('title' => 'web_notfn', 'page' => 'web_notfn', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 					= 	$data + $this->data;     
		$web_notfn_list			= 	$this->Master_model->get_web_notfn_list();
		$data['web_notfn_list']	=	$web_notfn_list;
		$data 					= 	$data + $this->data;//print_r($tariff_list);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/web_notfn_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	} 
}

public function add_web_notfn()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
	$int_usertype	  	=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'add_web_notfn', 'page' => 'add_web_notfn', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('web_notfn_eng', 'Title in English', 'required');
		$this->form_validation->set_rules('web_notfn_mal', 'Title in Malayalam', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else
		{ 
			$title_eng 				= 	$this->security->xss_clean($this->input->post('web_notfn_eng'));
			$title_mal 				= 	$this->security->xss_clean($this->input->post('web_notfn_mal'));
			$content_eng 			= 	$this->security->xss_clean($this->input->post('content_eng'));
			$content_mal 			= 	$this->security->xss_clean($this->input->post('content_mal'));
			$chkduplication   =	$this->Master_model->check_duplication_notfn_insert($title_eng,$title_mal); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0)
			{
				$error_msg = "An Active Notification with same name already exists. Please mark the existing Notification as Inactive to add new Notification!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} 
			else 
			{
				$data = 	array('webnotification_engtitle' =>	$title_eng,
				'webnotification_maltitle' 			=>	$title_mal,
				'webnotification_engcontent' 		=>	$content_eng,
				'webnotification_malcontent' 		=>	$content_mal,
				'webnotification_status' 			=> 	1,
				'webnotification_user_sl'			=> 	$sess_usr_id,
				'webnotification_timestamp'			=>	$date,
				'webnotification_module'			=>	2); //print_r($data);exit;
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$title_res	=	$this->db->insert('tb_webnotification', $data);
				if($title_res)
				{
					$success_msg = "Notification Added Successfully!!!";
					echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
					//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
				}
			}	
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

public function status_web_notfn()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'status_web_notfn', 'page' => 'status_web_notfn', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('webnotification_status' => $updstat);
		$updstatus_res		=	$this->Master_model->update_webnotfn_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}

public function delete_web_notfn()
{ 
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data 				= 	array('title' => 'delete_web_notfn', 'page' => 'delete_web_notfn', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		$data 				= 	array('webnotification_ctype' => $updstat);
		$delete_result		=	$this->Master_model->edit_notfn($id,$data);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}

public function edit_web_notfn()
{
	$sess_usr_id    = $this->session->userdata('int_userid');
	$user_type_id   = $this->session->userdata('int_usertype');
	$ip             = $_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date           =   date('Y-m-d h:i:s', time()); 
	if(!empty($sess_usr_id))
	{ 
		$data = array('title' => 'edit_web_notfn', 'page' => 'edit_web_notfn', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->load->model('Kiv_models/Master_model');
		$edit_id              = 	$this->security->xss_clean($this->input->post('id'));
		$editDet              = 	$this->Master_model->get_notfn_det($edit_id);
		$data['editDet']      = 	$editDet; //print_r($editDet);exit;
		$data                 = 	$data + $this->data;
		$this->load->view('Kiv_views/Master/edit_web_notfn_ajax.php', $data);
	}
	else
	{
		redirect('Main_login/index'); 
	}
}

public function save_web_notfn()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
	$int_usertype	  	=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'save_web_notfn', 'page' => 'save_web_notfn', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		/*$this->form_validation->set_rules('edit_title_eng', 'Title in English', 'required');
		$this->form_validation->set_rules('edit_title_mal', 'Title in Malayalam', 'required');
		$this->form_validation->set_rules('edit_location', 'Location', 'required');
		if ($this->form_validation->run() == FALSE)
		{
		//fail validation
		$valErrors				= 	validation_errors();
		echo json_encode(array("val_errors" => $valErrors));
		exit;
		} 
		else { */
		$edit_id 				= 	$this->security->xss_clean($this->input->post('id'));
		$web_notfn_eng 			= 	$this->security->xss_clean($this->input->post('edit_web_notfn_eng'));
		$web_notfn_mal   		= 	$this->security->xss_clean($this->input->post('edit_web_notfn_mal'));
		$web_notfn_content_eng 	= 	$this->security->xss_clean($this->input->post('edit_web_notfn_content_eng'));
		$web_notfn_content_mal	= 	$this->security->xss_clean($this->input->post('edit_web_notfn_content_mal'));
		$chkduplication         =	$this->Master_model->check_duplication_web_notfn_edit($web_notfn_eng,$web_notfn_mal,$edit_id); 
		$cntrows				=	count($chkduplication);
		if($cntrows>0)
		{
			$error_msg = "An Active Notification with same name and details already exists. Please mark the existing Notification as Inactive to add new Notification!!!";
			echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
		} 
		else 
		{
			$data 				= 	array(
			'webnotification_engtitle'		=>	$web_notfn_eng,
			'webnotification_maltitle' 		=>	$web_notfn_mal,
			'webnotification_module' 		=>	2,
			'webnotification_status' 		=> 	1,
			'webnotification_user_sl'		=> 	$sess_usr_id,
			'webnotification_timestamp'		=>	$date); //print_r($data);exit;
			$data = $this->security->xss_clean($data);
			//insert the form data into database
			$regn_updres	=	$this->Master_model->update_web_notfn($data,$edit_id);
			if($regn_updres)
			{
				$success_msg = "Notification Updated Successfully!!!";
				echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
				//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
				redirect("Kiv_Ctrl/Master/web_notfn");
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

/*=========================================Web Notification(End)======================================================*/

/*=========================================Terms & Conditions(Start)===================================================*/

public function terms_condns()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{
		$data =	array('title' => 'terms_condns', 'page' => 'terms_condns', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 						= 	$data + $this->data;  
		$location					= 	$this->Master_model->get_fixed_location();
		$data['location']			=	$location;
		$data 						= 	$data + $this->data;
		$terms_condns_list			= 	$this->Master_model->get_terms_condns_list();
		$data['terms_condns_list']	=	$terms_condns_list;
		$data 						= 	$data + $this->data;//print_r($tariff_list);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/terms_condns_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	} 
}

public function add_terms_condns()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
	$int_usertype	  	=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'add_terms_condns', 'page' => 'add_terms_condns', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('terms_condns_eng', 'Title in English', 'required');
		$this->form_validation->set_rules('terms_condns_mal', 'Title in Malayalam', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$title_eng 				= 	$this->security->xss_clean($this->input->post('terms_condns_eng'));
			$title_mal 				= 	$this->security->xss_clean($this->input->post('terms_condns_mal'));
			$content_eng 			= 	$this->security->xss_clean($this->input->post('content_eng'));
			$content_mal 			= 	$this->security->xss_clean($this->input->post('content_mal'));
			$location 				= 	$this->security->xss_clean($this->input->post('location'));
			$moduleid 				=	2;
			$chkduplication         =	$this->Master_model->check_duplication_termscondn_insert($title_eng,$title_mal,$location); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0)
			{
				$error_msg = "An Active Terms & Condition with same name under same location already exists. Please mark the existing Term as Inactive to add new Term!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} 
			else 
			{
				$data 				= 	array(
				'bodycontent_identifier_sl'		=>	8,
				'bodycontent_engtitle' 			=>	$title_eng,
				'bodycontent_maltitle' 			=>	$title_mal,
				'bodycontent_engcontent' 		=>	$content_eng,
				'bodycontent_malcontent' 		=>	$content_mal,
				'bodycontent_location_sl' 		=>	$location,
				'bodycontent_status_sl' 		=> 	1,
				'bodycontent_created_by'		=> 	$sess_usr_id,
				'bodycontent_created_timestamp'	=>	$date,
				'bodycontent_created_ipaddress'	=>	$ip,
				'bodycontent_module_sl'			=>	$moduleid); //print_r($data);exit;
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$title_res	=	$this->db->insert('tb_bodycontent', $data);
				if($title_res)
				{
					$success_msg = "Term & Condition Added Successfully!!!";
					echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
					//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
				}
			}	
		}
	}
	else
	{
	redirect('Main_login/index');        
	}  
}

public function status_terms_condns()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'status_terms_condns', 'page' => 'status_terms_condns', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('bodycontent_status_sl' => $updstat);
		$updstatus_res		=	$this->Master_model->update_tems_condn_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}

public function delete_terms_condns()
{ 
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data 				= 	array('title' => 'delete_terms_condns', 'page' => 'delete_terms_condns', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		$data 				= 	array('bodycontent_ctype' => $updstat);
		$delete_result		=	$this->Master_model->edit_terms_condn($id,$data);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}

public function edit_terms_condns()
{
	$sess_usr_id    = $this->session->userdata('int_userid');
	$user_type_id   = $this->session->userdata('int_usertype');
	$ip             = $_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date           =   date('Y-m-d h:i:s', time()); 
	if(!empty($sess_usr_id))
	{ 
		$data = array('title' => 'edit_terms_condns', 'page' => 'edit_terms_condns', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->load->model('Kiv_models/Master_model');
		$location				= 	$this->Master_model->get_fixed_location();
		$data['location']		=	$location;
		$data 				= 	$data + $this->data;
		$edit_id              = 	$this->security->xss_clean($this->input->post('id'));
		$editDet              = 	$this->Master_model->get_terms_condns_det($edit_id);
		$data['editDet']      = 	$editDet; //print_r($editDet);exit;
		$data                 = 	$data + $this->data;
		$this->load->view('Kiv_views/Master/edit_terms_condns_ajax.php', $data);
	}
	else
	{
		redirect('Main_login/index'); 
	}
}

public function save_terms_condns()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
	$int_usertype	  	=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'save_terms_condns', 'page' => 'save_terms_condns', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		/*$this->form_validation->set_rules('edit_title_eng', 'Title in English', 'required');
		$this->form_validation->set_rules('edit_title_mal', 'Title in Malayalam', 'required');
		$this->form_validation->set_rules('edit_location', 'Location', 'required');
		if ($this->form_validation->run() == FALSE)
		{
		//fail validation
		$valErrors				= 	validation_errors();
		echo json_encode(array("val_errors" => $valErrors));
		exit;
		} 
		else { */
		$edit_id 				= 	$this->security->xss_clean($this->input->post('id'));
		$terms_condns_eng 		= 	$this->security->xss_clean($this->input->post('edit_terms_condns_eng'));
		$terms_condns_mal   	= 	$this->security->xss_clean($this->input->post('edit_terms_condns_mal'));
		$content_eng 			= 	$this->security->xss_clean($this->input->post('edit_content_eng'));
		$content_mal			= 	$this->security->xss_clean($this->input->post('edit_content_mal'));
		$location				= 	$this->security->xss_clean($this->input->post('edit_location'));
		$moduleid 				=	2;
		$chkduplication         =	$this->Master_model->check_duplication_terms_condn_edit($terms_condns_eng,$terms_condns_mal,$location,$edit_id); 
		$cntrows				=	count($chkduplication);
		if($cntrows>0)
		{
			$error_msg = "An Active Terms & Condition with same name under same location already exists. Please mark the existing Term as Inactive to add new Term!!!";
			echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
		} 
		else 
		{
			$data 	= 	array('bodycontent_identifier_sl'		=>	8,
			'bodycontent_engtitle' 			=>	$terms_condns_eng,
			'bodycontent_maltitle' 			=>	$terms_condns_mal,
			'bodycontent_engcontent' 		=>	$content_eng,
			'bodycontent_malcontent' 		=>	$content_mal,
			'bodycontent_location_sl' 		=>	$location,
			'bodycontent_status_sl' 		=> 	1,
			'bodycontent_created_by'		=> 	$sess_usr_id,
			'bodycontent_created_timestamp'	=>	$date,
			'bodycontent_created_ipaddress'	=>	$ip,
			'bodycontent_module_sl'			=>	$moduleid); //print_r($data);exit;
			$data = $this->security->xss_clean($data);
			//insert the form data into database
			$regn_updres	=	$this->Master_model->update_term_condn($data,$edit_id);
			if($regn_updres)
			{
				$success_msg = "Terms & Conditions Updated Successfully!!!";
				echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
				//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
				redirect("Kiv_Ctrl/Master/terms_condns");
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

/*=========================================Terms & Conditions(End)===================================================*/

/*=================================================Services(Start)===================================================*/

public function services()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{
		$data =	array('title' => 'services', 'page' => 'services', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 						= 	$data + $this->data;  
		$services_list			= 	$this->Master_model->get_services_list();
		$data['services_list']	=	$services_list;
		$data 					= 	$data + $this->data;//print_r($tariff_list);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/services_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	} 
}

public function add_services()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
	$int_usertype	  	=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'add_services', 'page' => 'add_services', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('services_eng', 'Title in English', 'required');
		$this->form_validation->set_rules('services_mal', 'Title in Malayalam', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			//fail validation
			$valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
		} 
		else 
		{ 
			$title_eng 				= 	$this->security->xss_clean($this->input->post('services_eng'));
			$title_mal 				= 	$this->security->xss_clean($this->input->post('services_mal'));
			$content_eng 			= 	$this->security->xss_clean($this->input->post('content_eng'));
			$content_mal 			= 	$this->security->xss_clean($this->input->post('content_mal'));
			$moduleid 				=	2;
			$chkduplication         =	$this->Master_model->check_duplication_services_insert($title_eng,$title_mal); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0)
			{
				$error_msg = "An Active Service with same name and details already exists. Please mark the existing Service as Inactive to add new Service!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			}
			else 
			{
				$data = 	array('bodycontent_identifier_sl'		=>	9,
				'bodycontent_engtitle' 			=>	$title_eng,
				'bodycontent_maltitle' 			=>	$title_mal,
				'bodycontent_engcontent' 		=>	$content_eng,
				'bodycontent_malcontent' 		=>	$content_mal,
				'bodycontent_status_sl' 		=> 	1,
				'bodycontent_created_by'		=> 	$sess_usr_id,
				'bodycontent_created_timestamp'	=>	$date,
				'bodycontent_created_ipaddress'	=>	$ip,
				'bodycontent_module_sl'			=>	$moduleid); //print_r($data);exit;
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$title_res	=	$this->db->insert('tb_bodycontent', $data);
				if($title_res)
				{
					$success_msg = "Services Added Successfully!!!";
					echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
					//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
				}
			}	
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

public function status_services()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'status_services', 'page' => 'status_services', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	0;
		}
		else
		{
			$updstat 		= 	1;
		}
		$data =	array('bodycontent_status_sl' => $updstat);
		$updstatus_res		=	$this->Master_model->update_service_status($data,$id);
		if($updstatus_res)
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}

public function delete_services()
{ 
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data 				= 	array('title' => 'delete_services', 'page' => 'delete_services', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		$data 				= 	array('bodycontent_ctype' => $updstat);
		$delete_result		=	$this->Master_model->edit_services($id,$data);
		if($delete_result)
		{
			//echo json_encode(array("status" => TRUE));
			echo json_encode(array("result" => 1));
		}
	}
	else
	{
		redirect('Main_login/index');        
	}	
}

public function edit_services()
{
	$sess_usr_id    = $this->session->userdata('int_userid');
	$user_type_id   = $this->session->userdata('int_usertype');
	$ip             = $_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date           =   date('Y-m-d h:i:s', time()); 
	if(!empty($sess_usr_id))
	{ 
		$data = array('title' => 'edit_services', 'page' => 'edit_services', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->load->model('Kiv_models/Master_model');
		$edit_id              = 	$this->security->xss_clean($this->input->post('id'));
		$editDet              = 	$this->Master_model->get_services_det($edit_id);
		$data['editDet']      = 	$editDet; //print_r($editDet);exit;
		$data                 = 	$data + $this->data;
		$this->load->view('Kiv_views/Master/edit_service_ajax.php', $data);
	}
	else
	{
		redirect('Main_login/index'); 
	}
}

public function save_services()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
	$int_usertype	  	=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'save_services', 'page' => 'save_services', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;

		//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		/*$this->form_validation->set_rules('edit_title_eng', 'Title in English', 'required');
		$this->form_validation->set_rules('edit_title_mal', 'Title in Malayalam', 'required');
		$this->form_validation->set_rules('edit_location', 'Location', 'required');
		if ($this->form_validation->run() == FALSE)
		{
		//fail validation
		$valErrors				= 	validation_errors();
		echo json_encode(array("val_errors" => $valErrors));
		exit;
		} 
		else { */
		$edit_id 				= 	$this->security->xss_clean($this->input->post('id'));
		$services_eng 			= 	$this->security->xss_clean($this->input->post('edit_services_eng'));
		$services_mal   		= 	$this->security->xss_clean($this->input->post('edit_services_mal'));
		$content_eng 			= 	$this->security->xss_clean($this->input->post('edit_content_eng'));
		$content_mal			= 	$this->security->xss_clean($this->input->post('edit_content_mal'));
		$moduleid 				=	2;
		$chkduplication         =	$this->Master_model->check_duplication_services_edit($terms_condns_eng,$terms_condns_mal,$edit_id); 
		$cntrows				=	count($chkduplication);
		if($cntrows>0)
		{
			$error_msg = "An Active Service with same name and details already exists. Please mark the existing Service as Inactive to add new Service!!!";
			echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
		} 
		else 
		{
			$data = 	array('bodycontent_identifier_sl'=>	9,
			'bodycontent_engtitle' 			=>	$services_eng,
			'bodycontent_maltitle' 			=>	$services_mal,
			'bodycontent_engcontent' 		=>	$content_eng,
			'bodycontent_malcontent' 		=>	$content_mal,
			'bodycontent_status_sl' 		=> 	1,
			'bodycontent_created_by'		=> 	$sess_usr_id,
			'bodycontent_created_timestamp'	=>	$date,
			'bodycontent_created_ipaddress'	=>	$ip,
			'bodycontent_module_sl'			=>	$moduleid); //print_r($data);exit;
			$data = $this->security->xss_clean($data);
			//insert the form data into database
			$regn_updres	=	$this->Master_model->update_service($data,$edit_id);
			if($regn_updres)
			{
				$success_msg = "Services Updated Successfully!!!";
				echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
				//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
				redirect("Kiv_Ctrl/Master/services");
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}
/*=================================================Services(End)===================================================*/

/*=================================================Inbox(Start)===================================================*/

public function inbox()
{
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{
		$data =	array('title' => 'services', 'page' => 'services', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 						= 	$data + $this->data;  
		$mailbox_list			= 	$this->Master_model->get_mailbox_list();
		$data['mailbox_list']	=	$mailbox_list;
		$data 					= 	$data + $this->data;//print_r($tariff_list);exit;
		$this->load->model('Kiv_models/Master_model');
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Kiv_views/Master/inbox_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	} 
}

/*=================================================Inbox(End)===================================================*/
//____________________________________________________________________________________________________________________________________________
//						VALIDATION (21-06-2018)
//_____________________________________________________________________________________________________________________________________________
function alphanum_check($str)
{
	if($str!='')
	{
		if (!preg_match("/^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-_]+$/i", $str))
		{
			$this->form_validation->set_message('alphanum_check', 'The %s field must contain only alphabets, numbers and characters like .-_');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	else
	{
		return TRUE;
	}
}
//_____________________________________________________________________________________________________________________________________________
function alphaonly_check($str)
{
	if($str!='')
	{
		if (!preg_match("/^[a-zA-Z]{1,}[a-zA-Z\s._-]+$/i", $str))
		{
			$this->form_validation->set_message('alphaonly_check', 'The %s field must contain only alphabets and characters like .-_');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	else
	{
		return TRUE;
	}
}
//____________________________________________________________________________________________________________________________________________
function minalphanum_check($str)
{
	if($str!='')
	{
		if (!preg_match("/^[a-zA-Z0-9]{1,}[a-zA-Z0-9]+$/i", $str))
		{
			$this->form_validation->set_message('minalphanum_check', 'The %s field must contain only alphabets and numbers.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	else
	{
		return TRUE;
	}
}
//_____________________________________________________________________________________________________________________________________________
function minalpha_check($str)
{
	if($str!='')
	{
		if (!preg_match("/^[a-zA-Z]{1,}[a-zA-Z]+$/i", $str))
		{
			$this->form_validation->set_message('minalpha_check', 'The %s field must contain only alphabets.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	else
	{
		return TRUE;
	}
}

//_____________________________________________________________________________________________________________________________________________
function num_check($str)
{
	if($str!='')
	{
		if (!preg_match("/^[0-9]+$/i", $str))
		{
			$this->form_validation->set_message('num_check', 'The %s field must contain only numbers.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	else
	{
		return TRUE;
	}
}
//_______________________________________________________________________________________________//
function testpassword()
{
	if($this->input->post())
	{	
		$pwd=html_escape($this->input->post('pwd'));
		echo $newp= $this->phpass->hash($pwd);exit;
	}
}

/*_______END OF CONTROLLER__________*/
}
