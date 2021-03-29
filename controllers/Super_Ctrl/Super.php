<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Super extends CI_Controller {

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
	$this->load->library('upload');
	//$this->load->helper('Specifictable_helper');
	$this->load->library('encrypt');
	$this->data 		= 	array(
		'controller' 			=> 	$this->router->fetch_class(),
		'method' 				=> 	$this->router->fetch_method(),
		'session_userdata' 		=> 	isset($this->session->userdata) ? $this->session->userdata : '',
		'base_url' 				=> 	base_url(),
		'site_url'  			=> 	site_url(),
		 'int_userid'       =>  isset($this->session->userdata['int_userid']) ? $this->session->userdata['int_userid'] : 0,
          'int_usertype'    =>  isset($this->session->userdata['int_usertype']) ? $this->session->userdata['int_usertype'] : 0,
		'customer_id' 			=> 	isset($this->session->userdata['customer_id']) ? $this->session->userdata['customer_id'] : 0,
		'survey_user_id' 		=> 	isset($this->session->userdata['survey_user_id']) ? $this->session->userdata['survey_user_id'] : 0,
	);
    $this->load->model('Super_models/Super_model');
	$this->load->model('Kiv_models/Master_model');
	$this->load->model('Kiv_models/Survey_model');
}

public function SuperHome()
{
	$sess_usr_id 	  	= $this->session->userdata('int_userid');
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{

		$data 			=	 array('title' => 'MasterHome', 'page' => 'MasterHome', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			=	 $data + $this->data;
		/* ======Added for dynamic menu listing (start) on 26.11.2019========   */ 
		$menu			= 	$this->Super_model->get_supermenu($int_usertype); //print_r($menu);
		$data['menu']	=	$menu;
		$data 			= 	$data + $this->data;
		      
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/SuperHome.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');        
	} 
		
}

/*=========================================== LOGO (Start) ======================================================*/
public function logo()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'logo_list', 'page' => 'logo_list', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		$logo_list			= 	$this->Super_model->get_logo_list();
		$data['logo_list']	=	$logo_list;
		$data 				= 	$data + $this->data;

		$location			= 	$this->Super_model->get_location();
		$data['location']	=	$location;
		$data 				= 	$data + $this->data;
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/logo_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function add_logo()
{ //echo "hiii";exit;
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'logo', 'page' => 'logo', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
			//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('location', 'Location', 'required');

		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
	        $valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
        } 
        else {  //print_r($_POST); print_r($_FILES); //exit;
            	$logo_upload  			= 	$this->security->xss_clean($_FILES["logo_upload"]["name"]);
				$location 				= 	$this->security->xss_clean($this->input->post('location'));
				$datetime=time();

				$ins_path_parts                 = pathinfo($_FILES["logo_upload"]["name"]);
		      	$ins_extension                  = $ins_path_parts['extension'];
		      

				if($logo_upload && ($ins_extension=='jpeg' || $ins_extension=='jpg' ||$ins_extension=='png'||$ins_extension=='JPEG'||$ins_extension=='JPG'||$ins_extension=='PNG') )
		    	{
		      //echo "uploaded";
		    	 $ins_file_namenw             = 'Logo'.$location.'_'.$datetime;

		    	$config1['upload_path']   = './uploads/Logo/'; 
      			$config1['allowed_types'] = 'jpeg|jpg|png|PNG|JPG|JPEG'; 
      			$config1['max_size']      = 1024000;
      			$config1['file_name']	  = $ins_file_namenw;
      	
      			$this->load->library('upload', $config1);
        		$this->upload->initialize($config1);
      	
     

      			if(!$this->upload->do_upload('logo_upload'))
      			{
      				$data['error'] = $this->upload->display_errors();
      				//print_r($data);exit();
      				//$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Maximum allowed  file size of user photo is 500Kb</div>'); 
         			//redirect("Kiv_Ctrl/Registration/NewUser_Registration");
         			echo "not";
      			}
      			else
      			{
      		 		$data = $this->upload->data();
         			//echo "Upload Successful-------uph";
         			//exit;
      			 

      			$ins_path_parts                 = pathinfo($_FILES["logo_upload"]["name"]);
		      $ins_extension                  = $ins_path_parts['extension'];


		     $ins_file_name             = 'Logo'.$location.'_'.$datetime.'.'.$ins_extension;

			$chkduplication         =	$this->Super_model->check_duplication_logo_insert($location); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0)
			{
				$error_msg = "An Active Logo under same location already exists. Please mark the existing logo as Inactive to add new logo!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} 
			else
			 {
				$data 				= 	array(
					'bodycontent_identifier_sl'		=>	1,
					'bodycontent_image' 			=>	$ins_file_name,  
					'bodycontent_location_sl' 		=> 	$location,
					'bodycontent_engtitle'			=>  uniqid(),
					'bodycontent_maltitle'			=>  uniqid(),
					'bodycontent_status_sl' 		=> 	1,
					'bodycontent_created_by'		=> 	$sess_usr_id,
					'bodycontent_created_timestamp'	=>	$date,
					'bodycontent_created_ipaddress'	=>	$ip
				); //print_r($data);
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$logo_res	=	$this->db->insert('tb_bodycontent', $data);
				if($logo_res)
				{
					$success_msg = "Logo Uploaded!!!";
					echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
					//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');

				}
			} //else of cntrows

			}//else of do upload	


		     // $ins_path_parts                 = pathinfo($_FILES["logo_upload"]["name"]);
		      //$ins_extension                  = $ins_path_parts['extension'];


		     // $ins_file_name             = 'Logo'.$location.'_'.$date.'.'.$ins_extension;
		     // $target                         = "./uploads/Logo/".$ins_file_name;
		     // $ins_upd                        = move_uploaded_file($_FILES["logo_upload"]["tmp_name"], $target);





		    }
		    else
		    {
		      echo "not";
		    }
			


				
		}
	}
	else
	{
		redirect('Main_login/index');        
    }  
}

public function status_logo()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'status_logo', 'page' => 'status_logo', 'errorCls' => NULL, 'post' => $this->input->post());
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
		$updstatus_res		=	$this->Super_model->update_logo_status($data,$id);
		if($updstatus_res){
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}	

public function edit_logo12092020()
{
	$ip				=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 			= 	date('Y-m-d h:i:s', time());		
	
	$sess_usr_id 	= $this->session->userdata('int_userid');//exit;
	$int_usertype	=	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'edit_logo', 'page' => 'edit_logo', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
		/*$this->form_validation->set_rules('edit_searchlight_size', 'Search Light Size Name', 'required|callback_alphaonly_check');
		$this->form_validation->set_rules('edit_searchlight_size_code', 'Search Light Size Code', 'required|callback_alphaonly_check');
		if ($this->form_validation->run() == FALSE)
        {
                 $valErrors			= 	validation_errors();
				 echo json_encode(array("val_errors" => $valErrors));
        } else {*/
			//print_r($_FILES);exit;	
		$id 			= 	$this->input->post('id');
		$id             =	$this->security->xss_clean($id);
		$logo_upload  	= 	$this->security->xss_clean($_FILES["logo_upload"]["name"]);
		$location 		= 	$this->security->xss_clean($this->input->post('location'));
				
		
		if($logo_upload)
		{
		      //echo "uploaded";
		      $ins_path_parts                 = pathinfo($_FILES["logo_upload"]["name"]);
		      $ins_extension                  = $ins_path_parts['extension'];

		      if($ins_extension=="jpg" || $ins_extension=="jpeg" || $ins_extension=="png")
		      {
		      $ins_file_name             = 'Logo'.$location.'_'.$date.'.'.$ins_extension;
		      $target                         = "./uploads/Logo/".$ins_file_name;
		      $ins_upd                        = move_uploaded_file($_FILES["logo_upload"]["tmp_name"], $target);
		      }


		}
		else
		{
		    echo "notee";
		}

		$chkduplication         =	$this->Super_model->check_duplication_logo_insert($location); 
		$cntrows				=	count($chkduplication);
		if($cntrows>0){
			$error_msg = "An Active Logo already exists. Please mark the existing logo as Inactive to add new logo!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
		} else {
			$data 				= 	array(
				'bodycontent_identifier_sl'		=>	1,
				'bodycontent_image' 			=>	$ins_file_name,  
				'bodycontent_location_sl' 		=> 	$location,
				'bodycontent_engtitle'			=>  uniqid(),
				'bodycontent_maltitle'			=>  uniqid(),
				'bodycontent_status_sl' 		=> 	1,
				'bodycontent_created_by'		=> 	$sess_usr_id,
				'bodycontent_created_timestamp'	=>	$date,
				'bodycontent_created_ipaddress'	=>	$ip
			); //print_r($data);
			$data = $this->security->xss_clean($data);
			//insert the form data into database
			$edit_logo		=	$this->Super_model->edit_logo($id,$data);
			if($edit_logo_res){
				$success_msg = "Logo Uploaded!!!";
				echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
					//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');

			}
		}	
			//}
	}
	else
	{
		redirect('Main_login/index');        
  	}
	
}	


public function delete_logo()
{ 
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				= 	array('title' => 'delete_logo', 'page' => 'delete_logo', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		
	
		$data 				= 	array(
			'bodycontent_ctype' => $updstat
		);
		$delete_result		=	$this->Super_model->edit_logo($id,$data);
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

/*=========================================== LOGO (End) ======================================================*/

/*=========================================== Title (Start) ======================================================*/

public function title()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'title_list', 'page' => 'title_list', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		$title_list			= 	$this->Super_model->get_title_list();
		$data['title_list']	=	$title_list;
		$data 				= 	$data + $this->data;

		$location			= 	$this->Super_model->get_location();
		$data['location']	=	$location;
		$data 				= 	$data + $this->data;
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/title_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function add_title()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'title', 'page' => 'title', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
			//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('title_eng', 'Title in English', 'required');
		$this->form_validation->set_rules('title_mal', 'Title in Malayalam', 'required');
		$this->form_validation->set_rules('location', 'Location', 'required');

		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
	        $valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
        } 
        else { 
            $title_eng 				= 	$this->security->xss_clean($this->input->post('title_eng'));
            $title_mal 				= 	$this->security->xss_clean($this->input->post('title_mal'));
            $tagline_eng 			= 	$this->security->xss_clean($this->input->post('tagline_eng'));
            $tagline_mal 			= 	$this->security->xss_clean($this->input->post('tagline_mal'));
			$location 				= 	$this->security->xss_clean($this->input->post('location'));

			
			$chkduplication         =	$this->Super_model->check_duplication_title_insert($title_eng,$title_mal,$tagline_eng,$tagline_mal,$location); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Title under same location already exists. Please mark the existing title as Inactive to add new title!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				$data 				= 	array(
					'bodycontent_identifier_sl'		=>	2,
					'bodycontent_engtitle' 			=>	$title_eng,
					'bodycontent_maltitle' 			=>	$title_mal,
					'bodycontent_engcontent' 		=>	$tagline_eng,
					'bodycontent_malcontent' 		=>	$tagline_mal,
					'bodycontent_location_sl' 		=> 	$location,
					'bodycontent_status_sl' 		=> 	1,
					'bodycontent_created_by'		=> 	$sess_usr_id,
					'bodycontent_created_timestamp'	=>	$date,
					'bodycontent_created_ipaddress'	=>	$ip
				); //print_r($data);exit;
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$title_res	=	$this->db->insert('tb_bodycontent', $data);
				if($title_res){
					$success_msg = "Title Added Successfully!!!";
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

public function status_title()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'status_title', 'page' => 'status_title', 'errorCls' => NULL, 'post' => $this->input->post());
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
		$updstatus_res		=	$this->Super_model->update_title_status($data,$id);
		if($updstatus_res){
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

public function delete_title()
{ 
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				= 	array('title' => 'delete_title', 'page' => 'delete_title', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		
	
		$data 				= 	array(
			'bodycontent_ctype' => $updstat
		);
		$delete_result		=	$this->Super_model->edit_title($id,$data);
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

function edit_title()
{ //echo "hiii";exit;

    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    
    $ip             = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date           =   date('Y-m-d h:i:s', time()); 

   if(!empty($sess_usr_id) && ($int_usertype==16))
    { 
      $data = array('title' => 'edit', 'page' => 'edit', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Super_models/Super_model');

      $location				= 	$this->Super_model->get_location();
	  $data['location']	    =	$location;
	  $data 				= 	$data + $this->data;

      $edit_id              = 	$this->security->xss_clean($this->input->post('id'));
      $editDet              = 	$this->Super_model->get_title_det($edit_id);
      $data['editDet']      = 	$editDet; //print_r($editDet);exit;
      $data                 = 	$data + $this->data;
     
      $this->load->view('Super_views/Super/edit_title_ajax.php', $data);
    }

}

public function save_title()
{ //print_r($_POST);exit;
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'edit_title', 'page' => 'edit_title', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
			//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('edit_title_eng', 'Title in English', 'required');
		$this->form_validation->set_rules('edit_title_mal', 'Title in Malayalam', 'required');
		$this->form_validation->set_rules('edit_location', 'Location', 'required');

		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
	        $valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
        } 
        else { 
        	$edit_id 				= 	$this->security->xss_clean($this->input->post('id'));
            $title_eng 				= 	$this->security->xss_clean($this->input->post('edit_title_eng'));
            $title_mal 				= 	$this->security->xss_clean($this->input->post('edit_title_mal'));
            $tagline_eng 			= 	$this->security->xss_clean($this->input->post('edit_tagline_eng'));
            $tagline_mal 			= 	$this->security->xss_clean($this->input->post('edit_tagline_mal'));
			$location 				= 	$this->security->xss_clean($this->input->post('edit_location'));

			
			$chkduplication         =	$this->Super_model->check_duplication_title_insert($title_eng,$title_mal,$tagline_eng,$tagline_mal,$location); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Title under same location already exists. Please mark the existing title as Inactive to add new title!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				$data 				= 	array(
					'bodycontent_identifier_sl'		=>	2,
					'bodycontent_engtitle' 			=>	$title_eng,
					'bodycontent_maltitle' 			=>	$title_mal,
					'bodycontent_engcontent' 		=>	$tagline_eng,
					'bodycontent_malcontent' 		=>	$tagline_mal,
					'bodycontent_location_sl' 		=> 	$location,
					'bodycontent_status_sl' 		=> 	1,
					'bodycontent_created_by'		=> 	$sess_usr_id,
					'bodycontent_created_timestamp'	=>	$date,
					'bodycontent_created_ipaddress'	=>	$ip
				); //print_r($data);exit;
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$title_updres	=	$this->Super_model->update_title($data,$edit_id);
				if($title_updres){
					$success_msg = "Title Updated Successfully!!!";
					echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
					//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
					 redirect("Super_Ctrl/Super/title");

				}
			}	
				
		}
	}
	else
	{
		redirect('Main_login/index');        
    }  
}

/*=========================================== Title (End) ======================================================*/

/*=========================================== Banner Menu (Start) ======================================================*/

public function banner()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'banner_list', 'page' => 'banner_list', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		$banner_list		= 	$this->Super_model->get_banner_list();
		$data['banner_list']=	$banner_list;
		$data 				= 	$data + $this->data;

		$location			= 	$this->Super_model->get_location();
		$data['location']	=	$location;
		$data 				= 	$data + $this->data;
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/banner_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function add_banner()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'banner', 'page' => 'banner', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
			//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('banner_eng', 'Title in English', 'required');
		$this->form_validation->set_rules('banner_mal', 'Title in Malayalam', 'required');
		$this->form_validation->set_rules('location', 'Location', 'required');

		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
	        $valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
        } 
        else { 
            $banner_eng 			= 	$this->security->xss_clean($this->input->post('banner_eng'));
            $banner_mal				= 	$this->security->xss_clean($this->input->post('banner_mal'));
            $banner_link 			= 	$this->security->xss_clean($this->input->post('banner_link'));
            $button_class 			= 	$this->security->xss_clean($this->input->post('button_class'));
            $banner_icon 			= 	$this->security->xss_clean($this->input->post('banner_icon'));
            $banner_order 			= 	$this->security->xss_clean($this->input->post('banner_order')); 
			$location 				= 	$this->security->xss_clean($this->input->post('location'));

			
			$chkduplication         =	$this->Super_model->check_duplication_banner_insert($banner_eng,$banner_mal,$location); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Banner under same location already exists. Please mark the existing banner as Inactive to add new banner!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				$chk_max			=	$this->Super_model->check_max_count($location); 
				$cnt_chk_max		=	count($chk_max);
				if($cnt_chk_max>=5){
					$error_msg = "The limit for the banner under same location exceeds!!!";
					echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
				} else {
					$chkorder         =	$this->Super_model->check_order_exist($banner_order,$location);
					$cntorder	      =	count($chkorder); 

					if($cntorder>0){
						$error_msg = "An Active Banner with same order and location already exists. Please mark the existing banner as Inactive to add new banner!!!";
						echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
					} else {
						$data 				= 	array(
							'bodycontent_identifier_sl'		=>	3,
							'bodycontent_engtitle' 			=>	$banner_eng,
							'bodycontent_maltitle' 			=>	$banner_mal,
							'bodycontent_link' 				=>	$banner_link,
							'bodycontent_buttonclass' 		=>	$button_class,
							'bodycontent_icon' 				=>	$banner_icon,
							'bodycontent_order' 			=>	$banner_order, 
							'bodycontent_location_sl' 		=> 	$location,
							'bodycontent_status_sl' 		=> 	1,
							'bodycontent_created_by'		=> 	$sess_usr_id,
							'bodycontent_created_timestamp'	=>	$date,
							'bodycontent_created_ipaddress'	=>	$ip
						); //print_r($data);exit;
						$data = $this->security->xss_clean($data);
						//insert the form data into database
						$title_res	=	$this->db->insert('tb_bodycontent', $data);
						if($title_res){
							$success_msg = "Banner Added Successfully!!!";
							echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
							//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');

						}
					}	
				}
			}	
				
		}
	}
	else
	{
		redirect('Main_login/index');        
    }  
}

public function status_banner()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'status_title', 'page' => 'status_title', 'errorCls' => NULL, 'post' => $this->input->post());
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
		$updstatus_res		=	$this->Super_model->update_banner_status($data,$id);
		if($updstatus_res){
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

public function delete_banner()
{ 
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				= 	array('title' => 'delete_banner', 'page' => 'delete_banner', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		
	
		$data 				= 	array(
			'bodycontent_ctype' => $updstat
		);
		$delete_result		=	$this->Super_model->edit_banner($id,$data);
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

function edit_banner()
{ //echo "hiii";exit;

    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    
    $ip             = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date           =   date('Y-m-d h:i:s', time()); 

   if(!empty($sess_usr_id) && ($int_usertype==16))
    { 
      $data = array('title' => 'edit', 'page' => 'edit', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Super_models/Super_model');

      $location				= 	$this->Super_model->get_location();
	  $data['location']	    =	$location;
	  $data 				= 	$data + $this->data;

      $edit_id              = 	$this->security->xss_clean($this->input->post('id'));
      $editDet              = 	$this->Super_model->get_banner_det($edit_id);
      $data['editDet']      = 	$editDet; //print_r($editDet);exit;
      $data                 = 	$data + $this->data;
     
      $this->load->view('Super_views/Super/edit_banner_ajax.php', $data);
    }

}	

public function save_banner()
{ //print_r($_POST);exit;
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'edit_title', 'page' => 'edit_title', 'errorCls' => NULL, 'post' => $this->input->post());
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
            $banner_eng 			= 	$this->security->xss_clean($this->input->post('edit_banner_eng'));
            $banner_mal 			= 	$this->security->xss_clean($this->input->post('edit_banner_mal'));
            $link 		 			= 	$this->security->xss_clean($this->input->post('edit_banner_link'));
            $button_class 			= 	$this->security->xss_clean($this->input->post('edit_button_class')); 
            $icon 		 			= 	$this->security->xss_clean($this->input->post('edit_banner_icon'));
            $order 					= 	$this->security->xss_clean($this->input->post('edit_banner_order'));
			$location 				= 	$this->security->xss_clean($this->input->post('edit_location'));

			
			$chkduplication         =	$this->Super_model->check_duplication_banner_edit($banner_eng,$banner_mal,$location,$edit_id); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Title under same location already exists. Please mark the existing title as Inactive to add new title!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				/*$chk_max			=	$this->Super_model->check_max_count($location); 
				$cnt_chk_max		=	count($chk_max);
				if($cnt_chk_max>=5){
					$error_msg = "The limit for the banner under same location exceeds!!!";
					echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
				} else {*/
					$chkorder         =	$this->Super_model->check_order_exist_edit($order,$location,$edit_id);
					$cntorder	      =	count($chkorder); 

					if($cntorder>0){
						$error_msg = "An Active Banner with same order and location already exists. Please mark the existing banner as Inactive to add new banner!!!";
						echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
					} else {
						$data 				= 	array(
							'bodycontent_identifier_sl'		=>	3,
							'bodycontent_engtitle' 			=>	$banner_eng,
							'bodycontent_maltitle' 			=>	$banner_mal,
							'bodycontent_link' 				=>	$link,
							'bodycontent_buttonclass' 		=>	$button_class,
							'bodycontent_icon' 				=>	$icon,
							'bodycontent_order' 			=>	$order, 
							'bodycontent_location_sl' 		=> 	$location,
							'bodycontent_status_sl' 		=> 	1,
							'bodycontent_created_by'		=> 	$sess_usr_id,
							'bodycontent_created_timestamp'	=>	$date,
							'bodycontent_created_ipaddress'	=>	$ip
						); //print_r($data);exit;
						$data = $this->security->xss_clean($data);
						//insert the form data into database
						$banner_updres	=	$this->Super_model->update_banner($data,$edit_id);
						if($banner_updres){
							$success_msg = "Banner Updated Successfully!!!";
							echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
							//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
							 redirect("Super_Ctrl/Super/banner");

						}
					}	
				//}
			}	
				
		//}
	}
	else
	{
		redirect('Main_login/index');        
    }  
}

/*=========================================== Banner Menu (End) ======================================================*/

/*====================================== Registration Menu (Start) ======================================================*/

public function registration()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'registration_list', 'page' => 'registration_list', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		$registration_list		  = 	$this->Super_model->get_registration_list();
		$data['registration_list']=	    $registration_list;
		$data 					  = 	$data + $this->data;

		$location			= 	$this->Super_model->get_location();
		$data['location']	=	$location;
		$data 				= 	$data + $this->data;
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/registration_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function add_registration()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'regn', 'page' => 'regn', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
			//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('registration_eng', 'Title in English', 'required');
		$this->form_validation->set_rules('registration_mal', 'Title in Malayalam', 'required');
		

		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
	        $valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
        } 
        else { 
            $registration_eng 		= 	$this->security->xss_clean($this->input->post('registration_eng'));
            $registration_mal		= 	$this->security->xss_clean($this->input->post('registration_mal'));
            $registration_desc_eng	= 	$this->security->xss_clean($this->input->post('registration_desc_eng'));
            $registration_desc_mal	= 	$this->security->xss_clean($this->input->post('registration_desc_mal'));
            $location 				= 	4;//Registration Menu

			
			$chkduplication         =	$this->Super_model->check_duplication_regn_insert($location); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "Only one active registration menu content can be added!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				
				$data 				= 	array(
					'bodycontent_identifier_sl'		=>	4,
					'bodycontent_engtitle' 			=>	$registration_eng,
					'bodycontent_maltitle' 			=>	$registration_mal,
					'bodycontent_engcontent' 		=>	$registration_desc_eng,
					'bodycontent_malcontent' 		=>	$registration_desc_mal,
					'bodycontent_location_sl' 		=> 	$location,
					'bodycontent_status_sl' 		=> 	1,
					'bodycontent_created_by'		=> 	$sess_usr_id,
					'bodycontent_created_timestamp'	=>	$date,
					'bodycontent_created_ipaddress'	=>	$ip
				); //print_r($data);exit;
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$title_res	=	$this->db->insert('tb_bodycontent', $data);
				if($title_res){
					$success_msg = "Registration Menu Added Successfully!!!";
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

public function status_registration()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'status_regn', 'page' => 'status_regn', 'errorCls' => NULL, 'post' => $this->input->post());
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
		$updstatus_res		=	$this->Super_model->update_regn_status($data,$id);
		if($updstatus_res){
			echo json_encode(array("status" => TRUE));
		}
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

public function delete_registration()
{ 
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				= 	array('title' => 'delete_regn', 'page' => 'delete_regn', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		
	
		$data 				= 	array(
			'bodycontent_ctype' => $updstat
		);
		$delete_result		=	$this->Super_model->edit_regn($id,$data);
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

function edit_registration()
{ //echo "hiii";exit;

    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    
    $ip             = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date           =   date('Y-m-d h:i:s', time()); 

   if(!empty($sess_usr_id) && ($int_usertype==16))
    { 
      $data = array('title' => 'edit', 'page' => 'edit', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Super_models/Super_model');

      $location				= 	$this->Super_model->get_location();
	  $data['location']	    =	$location;
	  $data 				= 	$data + $this->data;

      $edit_id              = 	$this->security->xss_clean($this->input->post('id'));
      $editDet              = 	$this->Super_model->get_regn_det($edit_id);
      $data['editDet']      = 	$editDet; //print_r($editDet);exit;
      $data                 = 	$data + $this->data;
     
      $this->load->view('Super_views/Super/edit_regn_ajax.php', $data);
    }

}	

public function save_registration()
{ //print_r($_POST);exit;
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'save_regn', 'page' => 'save_regn', 'errorCls' => NULL, 'post' => $this->input->post());
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
            $registration_eng 		= 	$this->security->xss_clean($this->input->post('edit_registration_eng'));
            $registration_mal 		= 	$this->security->xss_clean($this->input->post('edit_registration_mal'));
            $registration_desc_eng  = 	$this->security->xss_clean($this->input->post('edit_registration_desc_eng'));
            $registration_desc_mal 	= 	$this->security->xss_clean($this->input->post('edit_registration_desc_mal')); 
            
			$location 				= 	$this->security->xss_clean($this->input->post('edit_location'));

			
						
			$data 				= 	array(
				'bodycontent_identifier_sl'		=>	4,
				'bodycontent_engtitle' 			=>	$registration_eng,
				'bodycontent_maltitle' 			=>	$registration_mal,
				'bodycontent_engcontent' 		=>	$registration_desc_eng,
				'bodycontent_malcontent' 		=>	$registration_desc_mal,
				'bodycontent_location_sl' 		=> 	$location,
				'bodycontent_status_sl' 		=> 	1,
				'bodycontent_created_by'		=> 	$sess_usr_id,
				'bodycontent_created_timestamp'	=>	$date,
				'bodycontent_created_ipaddress'	=>	$ip
			); //print_r($data);exit;
			$data = $this->security->xss_clean($data);
			//insert the form data into database
			$regn_updres	=	$this->Super_model->update_registration($data,$edit_id);
			if($regn_updres){
				$success_msg = "Banner Updated Successfully!!!";
				echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
				//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
				 redirect("Super_Ctrl/Super/registration");

			}
					
			//}	
				
		//}
	}
	else
	{
		redirect('Main_login/index');        
    }  
}

/*======================================= Registration Menu (End) ====================================================*/

/*==================================== Registration Menu Item (Start) ==================================================*/

public function registration_item()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'registration_item_list', 'page' => 'registration_item_list', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		$registration_item_list		    = 	$this->Super_model->get_registration_item_list();
		$data['registration_item_list'] =	$registration_item_list;
		$data 					  		= 	$data + $this->data;

		$location			= 	$this->Super_model->get_location();
		$data['location']	=	$location;
		$data 				= 	$data + $this->data;
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/registration_item_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function add_registration_item()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'regn_item', 'page' => 'regn_item', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
			//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('registration_item_eng', 'Title in English', 'required');
		$this->form_validation->set_rules('registration_item_mal', 'Title in Malayalam', 'required');
		

		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
	        $valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
        } 
        else { 
            $registration_item_eng 	= 	$this->security->xss_clean($this->input->post('registration_item_eng'));
            $registration_item_mal	= 	$this->security->xss_clean($this->input->post('registration_item_mal'));
            $registration_item_icon	= 	$this->security->xss_clean($this->input->post('registration_item_icon'));
            $registration_item_link	= 	$this->security->xss_clean($this->input->post('registration_item_link'));
            $registration_item_order= 	$this->security->xss_clean($this->input->post('registration_item_order'));
            $location 				= 	5;//Registration Menu Item

			
			$chkduplication         =	$this->Super_model->check_duplication_regnitem_insert($registration_item_eng,$registration_item_mal,$registration_item_icon,$registration_item_link,$registration_item_order,$location); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Menu Item with same name under same location already exists. Please mark the existing title as Inactive to add new Menu !!!!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {

				$chkrows         	=	$this->Super_model->check_maxrow_insert($location);
				$cnt_rows			=	count($chkrows);
				if($cnt_rows>=5){
					$error_msg = "Only 5 Registration Menu Items can be added.!!!!!!";
					echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
				} else {
					if($registration_item_order>5){
						$error_msg = "The Order must be between 1 and 5 !!!!!!";
						echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
					} else {
						$chkorder         =	$this->Super_model->check_regn_order_exist($registration_item_order,$location);
						$cntorder	      =	count($chkorder); 

						if($cntorder>0){
							$error_msg = "An Active Menu Item with same order and location already exists!!!";
							echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
						} else {
					
							$data 				= 	array(
								'bodycontent_identifier_sl'		=>	5,
								'bodycontent_engtitle' 			=>	$registration_item_eng,
								'bodycontent_maltitle' 			=>	$registration_item_mal,
								'bodycontent_icon' 				=>	$registration_item_icon,
								'bodycontent_link' 				=>	$registration_item_link,
								'bodycontent_order' 			=>	$registration_item_order,
								'bodycontent_location_sl' 		=> 	$location,
								'bodycontent_status_sl' 		=> 	1,
								'bodycontent_created_by'		=> 	$sess_usr_id,
								'bodycontent_created_timestamp'	=>	$date,
								'bodycontent_created_ipaddress'	=>	$ip
							); //print_r($data);exit;
							$data = $this->security->xss_clean($data);
							//insert the form data into database
							$title_res	=	$this->db->insert('tb_bodycontent', $data);
							if($title_res){
								$success_msg = "Registration Menu Added Successfully!!!";
								echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
								//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');

							}
						}
					}		
				}	
			}	
				
		}
	}
	else
	{
		redirect('Main_login/index');        
    }  
}

public function status_registration_item()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'status_regn_item', 'page' => 'status_regn_item', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		$loc 	 			= 	$this->input->post('loc');
		if($status==1)
		{
			$updstat 		= 	0;
			$data =	array('bodycontent_status_sl' => $updstat);
			$updstatus_res		=	$this->Super_model->update_regn_item_status($data,$id);
			if($updstatus_res){
				echo json_encode(array("status" => TRUE));
			}
		}
		else
		{
			$chkrows         	=	$this->Super_model->check_maxrow_insert($loc);
			$cnt_rows			=	count($chkrows);
			if($cnt_rows>=5){
				$error_msg = "Only 5 Registration Menu Items can added.!!!!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				$updstat 		= 	1;
				$data =	array('bodycontent_status_sl' => $updstat);
				$updstatus_res		=	$this->Super_model->update_regn_item_status($data,$id);
				if($updstatus_res){
					echo json_encode(array("status" => TRUE));
				}
			}	
		}
		
		
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

public function delete_registration_item()
{ 
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				= 	array('title' => 'delete_regn_item', 'page' => 'delete_item', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		
	
		$data 				= 	array(
			'bodycontent_ctype' => $updstat
		);
		$delete_result		=	$this->Super_model->edit_regn_item($id,$data);
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

function edit_registration_item()
{ //echo "hiii";exit;

    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    
    $ip             = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date           =   date('Y-m-d h:i:s', time()); 

   if(!empty($sess_usr_id) && ($int_usertype==16))
    { 
      $data = array('title' => 'edit', 'page' => 'edit', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Super_models/Super_model');

      $location				= 	$this->Super_model->get_location();
	  $data['location']	    =	$location;
	  $data 				= 	$data + $this->data;

      $edit_id              = 	$this->security->xss_clean($this->input->post('id'));
      $editDet              = 	$this->Super_model->get_regn_item_det($edit_id);
      $data['editDet']      = 	$editDet; //print_r($editDet);exit;
      $data                 = 	$data + $this->data;
     
      $this->load->view('Super_views/Super/edit_regn_item_ajax.php', $data);
    }

}

public function save_registration_item()
{ //print_r($_POST);exit;
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit
		$data =	array('title' => 'save_regn', 'page' => 'save_regn', 'errorCls' => NULL, 'post' => $this->input->post());
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
            $registration_item_eng	= 	$this->security->xss_clean($this->input->post('edit_registration_item_eng'));
            $registration_item_mal	= 	$this->security->xss_clean($this->input->post('edit_registration_item_mal'));
            $registration_item_icon = 	$this->security->xss_clean($this->input->post('edit_registration_item_icon'));
            $registration_item_link	= 	$this->security->xss_clean($this->input->post('edit_registration_item_link')); 
            $registration_item_order= 	$this->security->xss_clean($this->input->post('edit_registration_item_order'));
			$location 				= 	$this->security->xss_clean($this->input->post('edit_location'));

			$chkduplication         =	$this->Super_model->check_duplication_regnitem_edit($registration_item_eng,$registration_item_mal,$registration_item_icon,$registration_item_link,$registration_item_order,$location,$edit_id); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Registration Item under same location already exists. Please mark the existing Item as Inactive to add new Item!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {

				$chkrows         	=	$this->Super_model->check_maxrow_insert($location);
				$cnt_rows			=	count($chkrows);
				if($cnt_rows>5){
					$error_msg = "Only 5 Registration Menu Items can be added.!!!!!!";
					echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
				} else {

					$chkorder         =	$this->Super_model->check_regnitem_order_exist_edit($order,$location,$edit_id);
					$cntorder	      =	count($chkorder); 

					if($cntorder>0){
						$error_msg = "An Active Registration Item with same order and location already exists. Please mark the existing Item as Inactive to add new Item!!!";
						echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
					} else {
								
						$data 				= 	array(
							'bodycontent_identifier_sl'		=>	5,
							'bodycontent_engtitle' 			=>	$registration_item_eng,
							'bodycontent_maltitle' 			=>	$registration_item_mal,
							'bodycontent_icon' 				=>	$registration_item_icon,
							'bodycontent_link' 				=>	$registration_item_link,
							'bodycontent_order' 			=>	$registration_item_order,
							'bodycontent_location_sl' 		=> 	$location,
							'bodycontent_status_sl' 		=> 	1,
							'bodycontent_created_by'		=> 	$sess_usr_id,
							'bodycontent_created_timestamp'	=>	$date,
							'bodycontent_created_ipaddress'	=>	$ip
						); //print_r($data);exit;
						$data = $this->security->xss_clean($data);
						//insert the form data into database
						$regn_updres	=	$this->Super_model->update_registration_item($data,$edit_id);
						if($regn_updres){
							$success_msg = "Registration Item Updated Successfully!!!";
							echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
							//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
							 redirect("Super_Ctrl/Super/registration_item");

						}
							
					}
				}		
				
		    }
	}
	else
	{
		redirect('Main_login/index');        
    }  
}	

/*==================================== Registration Menu Item (End) ==================================================*/


/*==================================== Footer Menu (Start) ==================================================*/

public function footer()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'footer', 'page' => 'footer', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		$footer_list		= 	$this->Super_model->get_footer_list();
		$data['footer_list']=	$footer_list;
		$data 				= 	$data + $this->data;

		$location			= 	$this->Super_model->get_location();
		$data['location']	=	$location;
		$data 				= 	$data + $this->data;
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/footer_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function add_footer()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'footer_add', 'page' => 'footer_add', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
			//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('footer_eng', 'Footer in English', 'required');
		$this->form_validation->set_rules('footer_mal', 'Footer in Malayalam', 'required');
		

		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
	        $valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
        } 
        else { 
            $footer_eng 		= 	$this->security->xss_clean($this->input->post('footer_eng'));
            $footer_mal			= 	$this->security->xss_clean($this->input->post('footer_mal'));
            $footer_order 		= 	$this->security->xss_clean($this->input->post('footer_order'));
            $location 			= 	6;//Footer Menu

			
			$chkduplication         =	$this->Super_model->check_duplication_footer_insert($footer_eng,$footer_mal,$footer_order,$location); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Footer with same name under same location already exists. Please mark the existing footer menu as Inactive to add new Menu !!!!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				$chk_footer_order	=	$this->Super_model->check_footerorder_exist($footer_order,$location);
				$cnt_footrws		=	count($chk_footer_order); 
				if($cnt_footrws>0){
					$error_msg = "An Active Footer with same order under same location already exists. Please mark the existing footer menu as Inactive to add new Menu !!!!!!";
					echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
				} else {
					if($footer_order>3){
						$error_msg = "The Order must be between 1 and 3 !!!!!!";
						echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
					} else {
						$chk_max_rws		=	$this->Super_model->check_maxfooter_insert($location); 
						$cnt_maxrows			=	count($chk_max_rws);
						if($cnt_maxrows>=3){
							$error_msg = "Only 3 Footer Menus can be added.!!!!!!";
							echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
						} else {
							
							$data 				= 	array(
								'bodycontent_identifier_sl'		=>	6,
								'bodycontent_engtitle' 			=>	$footer_eng,
								'bodycontent_maltitle' 			=>	$footer_mal,
								'bodycontent_order' 			=>	$footer_order,
								'bodycontent_location_sl' 		=> 	$location,
								'bodycontent_status_sl' 		=> 	1,
								'bodycontent_created_by'		=> 	$sess_usr_id,
								'bodycontent_created_timestamp'	=>	$date,
								'bodycontent_created_ipaddress'	=>	$ip
							); //print_r($data);exit;
							$data = $this->security->xss_clean($data);
							//insert the form data into database
							$title_res	=	$this->db->insert('tb_bodycontent', $data);
							if($title_res){
								$success_msg = "Footer Menu Added Successfully!!!";
								echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
								//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');

							}
						}
					}		
				}	
					
			}	
				
		}
	}
	else
	{
		redirect('Main_login/index');        
    }  
}

public function status_footer()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'status_footer', 'page' => 'status_footer', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		$loc 	 			= 	$this->input->post('loc');
		if($status==1)
		{
			$updstat 		= 	0;
			$data =	array('bodycontent_status_sl' => $updstat);
			$updstatus_res		=	$this->Super_model->update_footer_status($data,$id);
			if($updstatus_res){
				echo json_encode(array("status" => TRUE));
			}
		}
		else
		{
			$chkrows         	=	$this->Super_model->check_maxfooter_insert($loc);
			$cnt_rows			=	count($chkrows);
			if($cnt_rows>=3){
				$error_msg = "Only 3 Footer can added.!!!!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				$updstat 		= 	1;
				$data =	array('bodycontent_status_sl' => $updstat);
				$updstatus_res		=	$this->Super_model->update_footer_status($data,$id);
				if($updstatus_res){
					echo json_encode(array("status" => TRUE));
				}
			}	
		}
		
		
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

public function delete_footer()
{ 
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				= 	array('title' => 'delete_footer', 'page' => 'delete_footer', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		
	
		$data 				= 	array(
			'bodycontent_ctype' => $updstat
		);
		$delete_result		=	$this->Super_model->edit_footer($id,$data);
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

function edit_footer()
{ //echo "hiii";exit;

    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    
    $ip             = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date           =   date('Y-m-d h:i:s', time()); 

   if(!empty($sess_usr_id) && ($int_usertype==16))
    { 
      $data = array('title' => 'edit_footer', 'page' => 'edit_footer', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Super_models/Super_model');

      $location				= 	$this->Super_model->get_location();
	  $data['location']	    =	$location;
	  $data 				= 	$data + $this->data;

      $edit_id              = 	$this->security->xss_clean($this->input->post('id'));
      $editDet              = 	$this->Super_model->get_footer_det($edit_id);
      $data['editDet']      = 	$editDet; //print_r($editDet);exit;
      $data                 = 	$data + $this->data;
     
      $this->load->view('Super_views/Super/edit_footer_ajax.php', $data);
    }

}

public function save_footer()
{ //print_r($_POST);exit;
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'save_footer', 'page' => 'save_footer', 'errorCls' => NULL, 'post' => $this->input->post());
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
            $footer_eng 			= 	$this->security->xss_clean($this->input->post('edit_footer_eng'));
            $footer_mal   			= 	$this->security->xss_clean($this->input->post('edit_footer_mal'));
            $footer_order 			= 	$this->security->xss_clean($this->input->post('edit_footer_order'));
			$location 				= 	$this->security->xss_clean($this->input->post('edit_location'));

			$chkduplication         =	$this->Super_model->check_duplication_footer_edit($footer_eng,$footer_mal,$footer_order,$location,$edit_id); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Footer Menu with same name and same location already exists. Please mark the existing Footer as Inactive to add new Footer!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {

				$chkrows         	=	$this->Super_model->check_maxfooter_edit($location,$edit_id);
				$cnt_rows			=	count($chkrows);
				if($cnt_rows>3){
					$error_msg = "Only 3 Footer Menu can be added.!!!!!!";
					echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
				} else {

					$chkorder         =	$this->Super_model->check_footer_order_exist_edit($footer_order,$location,$edit_id);
					$cntorder	      =	count($chkorder); 

					if($cntorder>0){
						$error_msg = "An Active Footer with same order and location already exists. Please mark the existing Footer as Inactive to add new Footer!!!";
						echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
					} else {
								
						$data 				= 	array(
							'bodycontent_identifier_sl'		=>	6,
							'bodycontent_engtitle' 			=>	$footer_eng,
							'bodycontent_maltitle' 			=>	$footer_mal,
							'bodycontent_order' 			=>	$footer_order,
							'bodycontent_location_sl' 		=> 	$location,
							'bodycontent_status_sl' 		=> 	1,
							'bodycontent_created_by'		=> 	$sess_usr_id,
							'bodycontent_created_timestamp'	=>	$date,
							'bodycontent_created_ipaddress'	=>	$ip
						); //print_r($data);exit;
						$data = $this->security->xss_clean($data);
						//insert the form data into database
						$regn_updres	=	$this->Super_model->update_footer($data,$edit_id);
						if($regn_updres){
							$success_msg = "Footer Updated Successfully!!!";
							echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
							//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
							 redirect("Super_Ctrl/Super/footer");

						}
							
					}
				}		
				
		    }
	}
	else
	{
		redirect('Main_login/index');        
    }  
}
/*==================================== Footer Menu (End) ==================================================*/

/*==================================== Footer Menu Item (Start) ==================================================*/

public function footer_item()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'footer_item', 'page' => 'footer_item', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		$footer_item_list		= 	$this->Super_model->get_footer_item_list();
		$data['footer_item_list']=	$footer_item_list;

		$footer_list		= 	$this->Super_model->get_footer_list_item();
		$data['footer_list']=	$footer_list;

		$data 				= 	$data + $this->data;

		$location			= 	$this->Super_model->get_location();
		$data['location']	=	$location;
		$data 				= 	$data + $this->data;
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/footer_item_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function add_footer_item()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'footer_item_add', 'page' => 'footer_item_add', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
			//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('footer_item_eng', 'Footer Item in English', 'required');
		$this->form_validation->set_rules('footer_item_mal', 'Footer Item in Malayalam', 'required');
		

		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
	        $valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
        } 
        else { //print_r($_POST);exit;
            $footer_item_eng		= 	$this->security->xss_clean($this->input->post('footer_item_eng'));
            $footer_item_mal		= 	$this->security->xss_clean($this->input->post('footer_item_mal'));
            $footer_item_tagline_eng= 	$this->security->xss_clean($this->input->post('footer_item_tagline_eng'));
            $footer_item_tagline_mal= 	$this->security->xss_clean($this->input->post('footer_item_tagline_mal'));
            $footer_item_order 		= 	$this->security->xss_clean($this->input->post('footer_item_order'));
            $footer_item_link 		= 	$this->security->xss_clean($this->input->post('footer_item_link'));
            $location 				= 	$this->security->xss_clean($this->input->post('location'));

			
			$chkduplication         =	$this->Super_model->check_duplication_footer_item_insert($footer_item_eng,$footer_item_mal,$footer_item_tagline_eng,$footer_item_tagline_mal,$footer_item_order,$location); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Footer Item with same name and details under same location already exists. Please mark the existing footer Item as Inactive to add new Item !!!!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				$chk_footer_order	=	$this->Super_model->check_footeritemorder_exist($footer_item_order,$location);
				$cnt_footrws		=	count($chk_footer_order); 
				if($cnt_footrws>0){
					$error_msg = "An Active Footer Item with same order under same location already exists. Please mark the existing footer Item as Inactive to add new Item !!!!!!";
					echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
				} else {
					if($footer_item_order>10){
						$error_msg = "The Order must be between 1 and 10 !!!!!!";
						echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
					} else {	
						$chk_max_rws		=	$this->Super_model->check_maxfooteritem_insert($location); 
						$cnt_maxrows			=	count($chk_max_rws);
						if($cnt_maxrows>=10){
							$error_msg = "Only 10 Footer Items can be added under same location!!!!!!";
							echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
						} else {
							
							$data 				= 	array(
								'bodycontent_identifier_sl'		=>	7,
								'bodycontent_engtitle' 			=>	$footer_item_eng,
								'bodycontent_maltitle' 			=>	$footer_item_mal,
								'bodycontent_engcontent' 		=>	$footer_item_tagline_eng,
								'bodycontent_malcontent' 		=>	$footer_item_tagline_mal,
								'bodycontent_order' 			=>	$footer_item_order,
								'bodycontent_link' 				=> 	$footer_item_link,
								'bodycontent_location_sl' 		=> 	$location,
								'bodycontent_status_sl' 		=> 	1,
								'bodycontent_created_by'		=> 	$sess_usr_id,
								'bodycontent_created_timestamp'	=>	$date,
								'bodycontent_created_ipaddress'	=>	$ip
							); print_r($data);exit;
							$data = $this->security->xss_clean($data);
							//insert the form data into database
							$title_res	=	$this->db->insert('tb_bodycontent', $data);
							if($title_res){
								$success_msg = "Footer Menu Item Added Successfully!!!";
								echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
								//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');

							}
						}
					}		
				}	
					
			}	
				
		}
	}
	else
	{
		redirect('Main_login/index');        
    }  
}

public function status_footer_item()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{
		$data =	array('title' => 'status_footer_item', 'page' => 'status_footer_item', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		$loc 	 			= 	$this->input->post('loc');
		if($status==1)
		{
			$updstat 		= 	0;
			$data =	array('bodycontent_status_sl' => $updstat);
			$updstatus_res		=	$this->Super_model->update_footer_item_status($data,$id,$loc);
			if($updstatus_res){
				echo json_encode(array("status" => TRUE));
			}
		}
		else
		{
			$chkrows         	=	$this->Super_model->check_maxfooteritem_insert($loc);
			$cnt_rows			=	count($chkrows);
			if($cnt_rows>=10){
				$error_msg = "Only 10 Footer Items can be be added.!!!!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				$updstat 		= 	1;
				$data =	array('bodycontent_status_sl' => $updstat);
				$updstatus_res		=	$this->Super_model->update_footer_item_status($data,$id,$loc);
				if($updstatus_res){
					echo json_encode(array("status" => TRUE));
				}
			}	
		}
		
		
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

public function delete_footer_item()
{ 
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				= 	array('title' => 'delete_footer_item', 'page' => 'delete_footer_item', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		
	
		$data 				= 	array(
			'bodycontent_ctype' => $updstat
		);
		$delete_result		=	$this->Super_model->edit_footer_item($id,$data);
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

function edit_footer_item()
{ //echo "hiii";exit;

    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    
    $ip             = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date           =   date('Y-m-d h:i:s', time()); 

   if(!empty($sess_usr_id) && ($int_usertype==16))
    { 
      $data = array('title' => 'edit_footer_item', 'page' => 'edit_footer_item', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Super_models/Super_model');

      $location				= 	$this->Super_model->get_location();
	  $data['location']	    =	$location;

	  $footer_list		    = 	$this->Super_model->get_footer_list_item();
	  $data['footer_list']  =	$footer_list;

	  $data 				= 	$data + $this->data;

      $edit_id              = 	$this->security->xss_clean($this->input->post('id'));
      $loc                  = 	$this->security->xss_clean($this->input->post('loc'));
      $editDet              = 	$this->Super_model->get_footer_item_det($edit_id,$loc);
      $data['editDet']      = 	$editDet; //print_r($editDet);exit;
      $data                 = 	$data + $this->data;
     
      $this->load->view('Super_views/Super/edit_footer_item_ajax.php', $data);
    }

}

public function save_footer_item()
{ //print_r($_POST);exit;
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'save_footer_item', 'page' => 'save_footer_item', 'errorCls' => NULL, 'post' => $this->input->post());
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
            $footer_item_eng 		= 	$this->security->xss_clean($this->input->post('edit_footer_item_eng'));
            $footer_item_mal   		= 	$this->security->xss_clean($this->input->post('edit_footer_item_mal'));
            $footer_item_tagline_eng= 	$this->security->xss_clean($this->input->post('edit_footer_item_tagline_eng'));
            $footer_item_tagline_mal= 	$this->security->xss_clean($this->input->post('edit_footer_item_tagline_mal'));
            $footer_item_order		= 	$this->security->xss_clean($this->input->post('edit_footer_item_order'));
            $footer_item_link		= 	$this->security->xss_clean($this->input->post('edit_footer_item_link'));
			$location 				= 	$this->security->xss_clean($this->input->post('edit_location'));

			$chkduplication         =	$this->Super_model->check_duplication_footer_item_edit($footer_item_eng,$footer_item_mal,$footer_item_tagline_eng,$footer_item_tagline_mal,$footer_item_order,$location,$edit_id); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Footer Item with same name and same location already exists. Please mark the existing Footer Item as Inactive to add new Item!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {

				$chkrows         	=	$this->Super_model->check_maxfooteritem_edit($location,$edit_id);
				$cnt_rows			=	count($chkrows);
				if($cnt_rows>10){
					$error_msg = "Only 10 Footer Items can be added.!!!!!!";
					echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
				} else {

					$chkorder         =	$this->Super_model->check_footer_itemorder_exist_edit($footer_item_order,$location,$edit_id);
					$cntorder	      =	count($chkorder); 

					if($cntorder>0){
						$error_msg = "An Active Footer Item with same order and location already exists. Please mark the existing Item as Inactive to add new Item!!!";
						echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
					} else {
								
						$data 				= 	array(
							'bodycontent_identifier_sl'		=>	7,
							'bodycontent_engtitle' 			=>	$footer_item_eng,
							'bodycontent_maltitle' 			=>	$footer_item_mal,
							'bodycontent_engcontent' 		=>	$footer_item_tagline_eng,
							'bodycontent_malcontent' 		=>	$footer_item_tagline_mal,
							'bodycontent_order' 			=>	$footer_item_order,
							'bodycontent_link' 				=> 	$footer_item_link,
							'bodycontent_location_sl' 		=> 	$location,
							'bodycontent_status_sl' 		=> 	1,
							'bodycontent_created_by'		=> 	$sess_usr_id,
							'bodycontent_created_timestamp'	=>	$date,
							'bodycontent_created_ipaddress'	=>	$ip
						); //print_r($data);exit;
						$data = $this->security->xss_clean($data);
						//insert the form data into database
						$regn_updres	=	$this->Super_model->update_footer_item($data,$edit_id);
						if($regn_updres){
							$success_msg = "Footer Item Updated Successfully!!!";
							echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
							//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
							 redirect("Super_Ctrl/Super/footer_item");

						}
							
					}
				}		
				
		    }
	}
	else
	{
		redirect('Main_login/index');        
    }  
}
/*==================================== Footer Menu Item (End) ==================================================*/

/*================================================ Ports (Start) ==================================================*/

public function ports()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'ports', 'page' => 'ports', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		$ports_list		= 	$this->Super_model->get_ports_list();
		$data['ports_list']=	$ports_list;
		$data 				= 	$data + $this->data;

		$location			= 	$this->Super_model->get_location();
		$data['location']	=	$location;
		$data 				= 	$data + $this->data;
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/ports_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function add_ports()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'add_ports', 'page' => 'add_ports', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
			//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('ports_eng', 'Port Name in English', 'required');
		$this->form_validation->set_rules('ports_eng', 'Port Name in Malayalam', 'required');
		

		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
	        $valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
        } 
        else { //print_r($_POST);exit;
            $ports_eng		= 	$this->security->xss_clean($this->input->post('ports_eng'));
            $ports_mal		= 	$this->security->xss_clean($this->input->post('ports_mal'));
            $address_eng 	= 	$this->security->xss_clean($this->input->post('address_eng'));
            $address_mal 	= 	$this->security->xss_clean($this->input->post('address_mal'));
            $ports_phone	= 	$this->security->xss_clean($this->input->post('ports_phone'));
            $ports_mail 	= 	$this->security->xss_clean($this->input->post('ports_mail'));
            $ports_map 	    = 	$this->security->xss_clean($this->input->post('ports_map'));

			
			$chkduplication         =	$this->Super_model->check_duplication_ports_insert($ports_eng,$ports_mal,$address_eng,$address_mal,$ports_phone,$ports_mail); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Port with same name and details already exists. Please mark the existing port as Inactive to add new port !!!!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
					
				/*$data 				= 	array(
					'portoffice_engtitle'			=>	$ports_eng,
					'portoffice_maltitle' 			=>	$ports_mal,
					'portoffice_engaddress' 		=>	$address_eng,
					'portoffice_maladdress' 		=>	$address_mal,
					'portoffice_phone' 				=>	$ports_phone,
					'portoffice_email' 				=>	$ports_mail,
					'portoffice_map' 				=> 	$ports_map,
					'portoffice_status_sl' 			=> 	1,
					'portoffice_created_by'			=> 	$sess_usr_id,
					'portoffice_timestamp'			=>	$date,
					'portoffice_created_ipaddress'	=>	$ip
				);*/ //print_r($data);exit;
				$data 				= 	array(
					'vchr_portoffice_name'			=>	$ports_eng,
					'portofregistry_mal_name' 		=>	$ports_mal,
					'vchr_portoffice_address' 		=>	$address_eng,
					'vchr_portoffice_maladdress' 	=>	$address_mal,
					'vchr_portoffice_phone' 		=>	$ports_phone,
					'vchr_portoffice_email' 		=>	$ports_mail,
					'portoffice_map' 				=> 	$ports_map,
					'int_status' 					=> 	1
				);
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$title_res	=	$this->db->insert('tbl_portoffice_master', $data);
				if($title_res){
					$success_msg = "Port Office Added Successfully!!!";
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

public function status_ports()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'status_ports', 'page' => 'status_ports', 'errorCls' => NULL, 'post' => $this->input->post());
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
		$data =	array('int_status' => $updstat);
		$updstatus_res		=	$this->Super_model->update_port_status($data,$id);
		if($updstatus_res){
			echo json_encode(array("status" => TRUE));
		}
		
		
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

function edit_ports()
{ //echo "hiii";exit;

    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    
    $ip             = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date           =   date('Y-m-d h:i:s', time()); 

   if(!empty($sess_usr_id) && ($int_usertype==16))
    { 
      $data = array('title' => 'edit_ports', 'page' => 'edit_ports', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Super_models/Super_model');

      $location				= 	$this->Super_model->get_location();
	  $data['location']	    =	$location;
	  $data 				= 	$data + $this->data;

      $edit_id              = 	$this->security->xss_clean($this->input->post('id'));
     
      $editDet              = 	$this->Super_model->get_port_det($edit_id);
      $data['editDet']      = 	$editDet; //print_r($editDet);exit;
      $data                 = 	$data + $this->data;
     
      $this->load->view('Super_views/Super/edit_port_ajax.php', $data);
    }

}

public function save_ports()
{ //print_r($_POST);exit;
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'save_port', 'page' => 'save_port', 'errorCls' => NULL, 'post' => $this->input->post());
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
        	$edit_id 		= 	$this->security->xss_clean($this->input->post('id'));
            $ports_eng 		= 	$this->security->xss_clean($this->input->post('edit_ports_eng'));
            $ports_mal   	= 	$this->security->xss_clean($this->input->post('edit_ports_mal'));
            $address_eng 	= 	$this->security->xss_clean($this->input->post('edit_address_eng'));
            $address_mal 	= 	$this->security->xss_clean($this->input->post('edit_address_mal'));
            $ports_phone	= 	$this->security->xss_clean($this->input->post('edit_ports_phone'));
			$ports_mail 	= 	$this->security->xss_clean($this->input->post('edit_ports_mail'));
			$ports_map 		= 	$this->security->xss_clean($this->input->post('edit_ports_map'));

			$chkduplication         =	$this->Super_model->check_duplication_ports_edit($ports_eng,$ports_mal,$address_eng,$address_mal,$ports_phone,$ports_mail,$edit_id); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Port with same name and detail already exists. Please mark the existing Port as Inactive to add new Port!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				
				/*$data 				= 	array(
					'portoffice_engtitle' 			=>	$ports_eng,
					'portoffice_maltitle' 			=>	$ports_mal,
					'portoffice_engaddress' 		=>	$address_eng,
					'portoffice_maladdress' 		=>	$address_mal,
					'portoffice_phone' 				=>	$ports_phone,
					'portoffice_email' 				=> 	$ports_mail,
					'portoffice_map' 				=> 	$ports_map,
					'portoffice_status_sl' 			=> 	1,
					'portoffice_created_by'			=> 	$sess_usr_id,
					'portoffice_timestamp'			=>	$date,
					'portoffice_created_ipaddress'	=>	$ip
				);*/ //print_r($data);exit;
				$data 				= 	array(
					'vchr_portoffice_name' 			=>	$ports_eng,
					'portofregistry_mal_name' 		=>	$ports_mal,
					'vchr_portoffice_address' 		=>	$address_eng,
					'vchr_portoffice_maladdress' 	=>	$address_mal,
					'vchr_portoffice_phone' 		=>	$ports_phone,
					'vchr_portoffice_email' 		=> 	$ports_mail,
					'portoffice_map' 				=> 	$ports_map,
					'int_status' 					=> 	1
				);
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$regn_updres	=	$this->Super_model->update_port($data,$edit_id);
				if($regn_updres){
					$success_msg = "Port details Updated Successfully!!!";
					echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
					//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
					 redirect("Super_Ctrl/Super/ports");

				}
							
				
				
		    }
	}
	else
	{
		redirect('Main_login/index');        
    }  
}
/*=============================================== Ports (End) =======================================================*/

/*================================================ Services (Start) ==================================================*/

public function services()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'services', 'page' => 'services', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		$services_list		= 	$this->Super_model->get_services_list();
		$data['services_list']=	$services_list;
		$data 				= 	$data + $this->data;

		$location			= 	$this->Super_model->get_location();
		$data['location']	=	$location;
		$data 				= 	$data + $this->data;
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/services_list.php',$data);
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
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'add_services', 'page' => 'add_services', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
			//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('services_eng', 'Service Name in English', 'required');
		$this->form_validation->set_rules('services_mal', 'Service Name in Malayalam', 'required');
		

		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
	        $valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
        } 
        else { //print_r($_POST);exit;
            $services_eng		= 	$this->security->xss_clean($this->input->post('services_eng'));
            $services_mal		= 	$this->security->xss_clean($this->input->post('services_mal'));
           			
			$chkduplication         =	$this->Super_model->check_duplication_services_insert($services_eng,$services_mal); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Service with same name already exists. Please mark the existing service as Inactive to add new service !!!!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
					
				$data 				= 	array(
					'services_engtitle'				=>	$services_eng,
					'services_maltitle' 			=>	$services_mal,
					'services_status' 				=> 	1,
					'services_created_by'			=> 	$sess_usr_id,
					'services_timestamp'			=>	$date,
					'services_created_ipaddress'	=>	$ip
				); //print_r($data);exit;
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$title_res	=	$this->db->insert('tb_services', $data);
				if($title_res){
					$success_msg = "Service Details Added Successfully!!!";
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
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
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
		$data =	array('services_status' => $updstat);
		$updstatus_res		=	$this->Super_model->update_service_status($data,$id);
		if($updstatus_res){
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
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				= 	array('title' => 'delete_services', 'page' => 'delete_services', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		
	
		$data 				= 	array(
			'services_ctype' => $updstat
		);
		$delete_result		=	$this->Super_model->edit_services($id,$data);
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

public function edit_services()
{
	$ip						=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 						= 	date('Y-m-d h:i:s', time());		

	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
		$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'edit_services', 'page' => 'edit_services', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		
		$this->form_validation->set_rules('edit_services_eng', 'Service Name in English', 'required|callback_alphanum_check');
		$this->form_validation->set_rules('edit_services_mal', 'Service Name in Malayalam', 'required');
		if ($this->form_validation->run() == FALSE)
        {
             $valErrors			= 	validation_errors();
			 echo json_encode(array("val_errors" => $valErrors));
        } else {
			
			$id 				= 	$this->input->post('id');
			$id           		=	$this->security->xss_clean($id);
			$edit_services_eng 	= 	$this->input->post('edit_services_eng');
			$edit_services_mal 	= 	$this->input->post('edit_services_mal');
			
			$chkduplication	=$this->Super_model->check_duplication_services_edit($edit_services_eng,$edit_services_mal,$id);

			$cntrows		=	count($chkduplication);
			if($cntrows==0){
			
				$data 		= 	array(
						'services_engtitle' 		 	=>	$edit_services_eng,  
						'services_maltitle' 	 		=> 	$edit_services_mal,
						'services_status' 				=> 	1,
						'services_created_by'			=> 	$sess_usr_id,
						'services_timestamp'			=>	$date,
						'services_created_ipaddress'	=>	$ip
					); //print_r($data);exit;
			
				
			$data		 	= 	$this->security->xss_clean($data);
			$edit_check		=	$this->Super_model->edit_services($id,$data);
			if($edit_check){
				$success_msg = "Service Updated Successfully!!!";
				echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
            	
				//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Service Updated Successfully!!!</div>');
			}
			}
	       else 
		   {	$error_msg = "Service with same name Already Exists!!!";
			echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
					//echo json_encode(array("val_errors" => "Service with same name Already Exists!!!"));
				
			}
		} 
	}
	else
   	{
		redirect('Main_login/index');        
		}

}


/*================================================ Services (End) ==================================================*/

/*================================== Services at Port Mapping (Start) ===============================================*/	

public function services_port()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'services_port', 'page' => 'services_port', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		$services_port_list	= 	$this->Super_model->get_services_port_list();
		$data['services_port_list']=	$services_port_list;
		$data 				= 	$data + $this->data;

		$ports				= 	$this->Super_model->get_ports_list();
		$data['ports']		=	$ports;
		$data 				= 	$data + $this->data;

		$services			= 	$this->Super_model->get_services_list();
		$data['services']	=	$services;
		$data 				= 	$data + $this->data;
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/services_port_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function add_services_port()
{ 
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'add_services_port', 'page' => 'add_services_port', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
			
			//set validation rules
		//$this->form_validation->set_rules('logo_upload', 'Logo Upload', 'required');
		$this->form_validation->set_rules('port', 'Port', 'required');
		$this->form_validation->set_rules('services[]', 'Services', 'required');
		

		if ($this->form_validation->run() == FALSE)
        {
             //fail validation
	        $valErrors				= 	validation_errors();
			echo json_encode(array("val_errors" => $valErrors));
			exit;
        } 
        else { //print_r($_POST);
            $port 			= 	$this->security->xss_clean($this->input->post('port'));
            $services		= 	$this->security->xss_clean($this->input->post('services'));
            $services      =   implode(", ",$services);
           			
			$chkduplication         =	$this->Super_model->check_duplication_portservices_insert($port); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Port already exists. Please mark the existing port as Inactive to add new port mapping !!!!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
					
				$data 				= 	array(
					'portservices_port_sl'			=>	$port,
					'portservices_services_sl' 		=>	$services,
					'portservices_status' 			=> 	1,
					'portservices_created_by'		=> 	$sess_usr_id,
					'portservices_timestamp'		=>	$date,
					'portservices_created_ipaddress'=>	$ip
				); //print_r($data);exit;
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$title_res	=	$this->db->insert('tb_portservices', $data);
				if($title_res){
					$success_msg = "Port Service Details Mapped Successfully!!!";
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

public function status_services_port()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'status_services_port', 'page' => 'status_services_port', 'errorCls' => NULL, 'post' => $this->input->post());
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
		$data =	array('portservices_status' => $updstat);
		$updstatus_res		=	$this->Super_model->update_portservices_status($data,$id);
		if($updstatus_res){
			echo json_encode(array("status" => TRUE));
		}
		
		
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

public function delete_services_port()
{ 
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				= 	array('title' => 'delete_services_port', 'page' => 'delete_services_port', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;
		$id 				= 	$this->input->post('id');
		$status 			= 	$this->input->post('stat');
		if($status==1)
		{
			$updstat 		= 	2;
		}
		
	
		$data 				= 	array(
			'portservices_ctype' => $updstat
		);
		$delete_result		=	$this->Super_model->edit_portservices($id,$data);
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

public function edit_services_port()
{
	$sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    
    $ip             = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date           =   date('Y-m-d h:i:s', time()); 

   if(!empty($sess_usr_id) && ($int_usertype==16))
    { 
      $data = array('title' => 'edit_services_port', 'page' => 'edit_services_port', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Super_models/Super_model');

      $ports				= 	$this->Super_model->get_ports_list();
	  $data['ports']		=	$ports;
      $data 				= 	$data + $this->data;

	  $services				= 	$this->Super_model->get_services_list();
	  $data['services']		=	$services;
	  $data 				= 	$data + $this->data;

      $edit_id              = 	$this->security->xss_clean($this->input->post('id'));
     
      $editDet              = 	$this->Super_model->get_services_port_det($edit_id);
      $data['editDet']      = 	$editDet; //print_r($editDet);exit;
      $data                 = 	$data + $this->data;
     
      $this->load->view('Super_views/Super/edit_services_port_ajax.php', $data);
    }

}

public function save_portservice()
{ //print_r($_POST);exit;
	$ip					=	$_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Kolkata");
	$date 				= 	date('Y-m-d h:i:s', time());
		
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	//echo "hiii";exit;
		$data =	array('title' => 'save_portservice', 'page' => 'save_portservice', 'errorCls' => NULL, 'post' => $this->input->post());
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
        	$edit_id 		= 	$this->security->xss_clean($this->input->post('id'));
            $portid 		= 	$this->security->xss_clean($this->input->post('edit_port'));
            $services   	= 	$this->security->xss_clean($this->input->post('edit_services'));
            $services       =   implode(", ",$services);

			$chkduplication         =	$this->Super_model->check_duplication_portservices_edit($portid,$edit_id); 
			$cntrows				=	count($chkduplication);
			if($cntrows>0){
				$error_msg = "An Active Port Service with same name and detail already exists. Please mark the existing Port as Inactive to add new Port!!!";
				echo json_encode(array("val_errors" => $error_msg , "status" => "false"));
			} else {
				
				$data 				= 	array(
					'portservices_port_sl'			=>	$portid,
					'portservices_services_sl' 		=>	$services,
					'portservices_status' 			=> 	1,
					'portservices_created_by'		=> 	$sess_usr_id,
					'portservices_timestamp'		=>	$date,
					'portservices_created_ipaddress'=>	$ip
				); //print_r($data);exit;
				$data = $this->security->xss_clean($data);
				//insert the form data into database
				$regn_updres	=	$this->Super_model->update_portservice($data,$edit_id);
				if($regn_updres){
					$success_msg = "Port Service Mapping Updated Successfully!!!";
					echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
					//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Logo Uploaded!!!</div>');
					 redirect("Super_Ctrl/Super/services_port");

				}
							
				
				
		    }
	}
	else
	{
		redirect('Main_login/index');        
    }  
}

/*===================================== Services at Port Mapping (End) ================================================*/

/*=================================================== Inbox (Start) ==================================================*/	

public function inbox()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'inbox', 'page' => 'inbox', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		
		$mail_list			= 	$this->Super_model->get_mailbox_list();
		$data['mail_list']	=	$mail_list;
		$data 				= 	$data + $this->data;
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/mailbox_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function status_inbox()
{
	
	$sess_usr_id 	  = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  =	$this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'status_inbox', 'page' => 'status_inbox', 'errorCls' => NULL, 'post' => $this->input->post());
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
		$data =	array('mailbox_status' => $updstat);
		$updstatus_res		=	$this->Super_model->update_inbox_status($data,$id);
		if($updstatus_res){
			echo json_encode(array("status" => TRUE));
		}
		
		
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

public function fwd_mail()
{
	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
	$date               =   date('Y-m-d h:i:s', time()); 
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'fwd_mail', 'page' => 'fwd_mail', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			= 	$data + $this->data;
		$id 			= 	$this->input->post('id');
		$serv 			= 	$this->input->post('serv');
		$service_det  = $this->Super_model->get_service_det($serv);
        foreach($service_det as $serv_res){
            $serv_name =  $serv_res['services_engtitle']." Admin";
        }
		
		$data =	array('mailbox_to' => $serv_name, 'mailbox_forwarded'=> $date);
		$updstatus_res		=	$this->Super_model->update_inbox_status($data,$id);
		if($updstatus_res){
			echo json_encode(array("status" => TRUE));
		}
		
		
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

/*=================================================== Inbox (End) ==================================================*/

/*============================================= Edit Profile (Start) ==================================================*/	

public function profile()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data 				=	array('title' => 'profile', 'page' => 'profile', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

				              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
		$this->load->view('Super_views/Super/profile_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
                       
	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function search_profile()
{ 
	
	$sess_usr_id 	  	= $this->session->userdata('int_userid');//exit;
  	$int_usertype	  	= $this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'search_profile', 'page' => 'search_profile', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			= 	$data + $this->data;

		$search_id 		= 	$this->security->xss_clean($this->input->post('search_id'));

		$data['search_id'] = $search_id;

		if($search_id=='1'){

			$search_mob = 	$this->security->xss_clean($this->input->post('search_mob'));

			$search_det	= 	$this->Super_model->get_user_details($search_id,$search_mob);   

		} 
		if($search_id=='2'){ 

			$search_mail= 	$this->security->xss_clean($this->input->post('search_mail'));

			$search_det	= 	$this->Super_model->get_user_details($search_id,$search_mail);

		} else if($search_id=='3'){

			$search_kiv = 	$this->security->xss_clean($this->input->post('search_kiv'));

			$search_det	= 	$this->Super_model->get_user_details_kiv($search_kiv);

		}

		$data['search_det'] = $search_det;

		$data 			    = $data + $this->data;
        
		
		$this->load->view('Super_views/Super/search_det_ajax.php',$data);
		
		
		
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

public function save_profile()
{ 
	
	$sess_usr_id 	  	 = $this->session->userdata('int_userid');//exit;
  	$int_usertype	  	 = $this->session->userdata('int_usertype');
  	$date 				 = date('Y-m-d H:i:s');
  	$ip				     = $_SERVER['REMOTE_ADDR'];
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'save_profile', 'page' => 'save_profile', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			 = 	$data + $this->data;

		$id 			 = 	$this->security->xss_clean($this->input->post('id'));
		$edit_address 	 = 	$this->security->xss_clean($this->input->post('edit_address'));
		$edit_ph 		 = 	$this->security->xss_clean($this->input->post('edit_ph'));
		$edit_email		 = 	$this->security->xss_clean($this->input->post('edit_email'));

		$check_duplicate = 	$this->Super_model->check_dup_user_det($edit_ph,$edit_email,$id);
		$count_rws 		 = 	count($check_duplicate);

		if($count_rws>0){
			$duplicate_msg = "An user with same Phone number or Email ID already exists!!!";
			echo json_encode(array("val_errors" => $duplicate_msg, "status" => "false"));
		} else {
			$check_duplicate_address = 	$this->Super_model->check_dup_useraddress_det($edit_address,$id);
			$countaddress_rws 		 = 	count($check_duplicate_address);

			if($countaddress_rws>0){
				$duplicate_msg = "An user with same address already exists!!!";
				echo json_encode(array("val_errors" => $duplicate_msg, "status" => "false"));
			}

			else {
				$prev_details     = 	$this->Super_model->get_prev_user_details($id);
				foreach($prev_details as $prev_details_res){
					$useraddr_old = $prev_details_res['user_address'];
					$userph_old   = $prev_details_res['user_master_ph'];
					$usermail_old = $prev_details_res['user_master_email'];
				}

				$data_log = array(
					'user_id'				=>	$id,
					'user_master_ph_old'	=> 	$userph_old,
					'user_master_ph_new'	=> 	$edit_ph,
					'user_master_email_old' => 	$usermail_old,  
					'user_master_email_new' => 	$edit_email, 
					'user_address_old'		=> 	$useraddr_old,
					'user_address_new'		=> 	$edit_address,
					'modified_user_id'  	=>  $sess_usr_id,
					'modified_ipaddress'	=>  $ip,
					'modified_timestamp'	=>  $date
				);
				$data = $this->security->xss_clean($data_log);
				//insert the form data into database
				$logo_res	=	$this->db->insert('user_master_log', $data);
				if($logo_res){

					$data_upd_ph_mail  = array(
						'user_master_ph'    => 	$edit_ph, 
						'user_master_email' => 	$edit_email
						//'user_address'		=> 	$edit_address
					);

					$upduser_res		=	$this->Super_model->update_user_ph_mail($data_upd_ph_mail,$id);
					if($upduser_res){
						
							$upduseraddr_res		=	$this->Super_model->update_user_address($edit_address,$edit_ph,$edit_email,$id);
							if($upduser_res){
								$upd_msg = "User Details has been updated successfully!!!";
								echo json_encode(array("val_errors" => $upd_msg, "status" => "true"));
							}
						
					}
				}	

			}
		}

	}	

}
/*============================================= Edit Profile (End) ==================================================*/

/*============================================= Reset password (Start) ==================================================*/

public function reset_pwd()

{	
	$sess_usr_id 	  	= 	$this->session->userdata('int_userid');//exit;
  	$int_usertype	  	=	$this->session->userdata('int_usertype');
		
	if(!empty($sess_usr_id) && (($int_usertype==16) || ($int_usertype=3) ))
	{	
		$data 				=	array('title' => 'reset_pwd', 'page' => 'reset_pwd', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data; 

		
		              
        $this->load->view('Kiv_views/template/all-header.php');
        $this->load->view('Kiv_views/template/master-header.php');
        // $this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Super_views/Super/reset_pwd_list.php',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');

	}
	else
	{
		redirect('Main_login/index');        
  	}  
    
}

public function search_resetpwd_list()
{ 
	
	$sess_usr_id 	  	= $this->session->userdata('int_userid');//exit;
  	$int_usertype	  	= $this->session->userdata('int_usertype');
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'search_resetpwd_list', 'page' => 'search_resetpwd_list', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			= 	$data + $this->data;

		$search_id 		= 	$this->security->xss_clean($this->input->post('search_id'));

		$data['search_id'] = $search_id;

		if($search_id=='1'){

			$search_mob = 	$this->security->xss_clean($this->input->post('search_mob'));

			$search_det	= 	$this->Super_model->get_user_details($search_id,$search_mob);   

		} 
		if($search_id=='2'){ 

			$search_mail= 	$this->security->xss_clean($this->input->post('search_mail'));

			$search_det	= 	$this->Super_model->get_user_details($search_id,$search_mail);

		} else if($search_id=='3'){

			$search_kiv = 	$this->security->xss_clean($this->input->post('search_kiv'));

			$search_det	= 	$this->Super_model->get_user_details_kiv($search_kiv);

		}

		$data['search_det'] = $search_det;

		$data 			    = $data + $this->data;
        
		
		$this->load->view('Super_views/Super/search_rest_pwd_ajax.php',$data);
		
		
		
	}
	else
	{
		redirect('Main_login/index');        
  	}	
}

public function reset_password()
{ 
	
	$sess_usr_id 	  	= $this->session->userdata('int_userid');//exit;
  	$int_usertype	  	= $this->session->userdata('int_usertype');
  	$year				= date('Y');
  	$date 				= date('Y-m-d H:i:s');
  	$ip				    = $_SERVER['REMOTE_ADDR'];
	
	if(!empty($sess_usr_id) && ($int_usertype==16))
	{	
		$data =	array('title' => 'search_resetpwd_list', 'page' => 'search_resetpwd_list', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			= 	$data + $this->data;

		$user_id 		= 	$this->security->xss_clean($this->input->post('user_id'));

		$data['user_id'] = $user_id;

		$user_det      =    $this->Super_model->get_prev_user_details($user_id);

		foreach($user_det as $user_det_res){

			$user_pwd_old = $user_det_res['user_master_password'];
			
			$user_ph      = $user_det_res['user_master_ph'];

			$user_mail 	= $user_det_res['user_master_email'];

		}

		$random_pass=substr(number_format(time() * rand() * $user_id,0,'',''),0,5);

		$passwordnew=$year.$random_pass;//----------set on 21/05/18

		$password=$this->phpass->hash($passwordnew);

		$data_log = array(
			'user_id' 				=> $user_id,
			'user_password_old' 	=> $user_pwd_old,
			'user_password_new' 	=> $password,
			'modified_user_id' 		=> $sess_usr_id,
			'modified_ipaddress' 	=> $ip,
			'modified_timestamp' 	=> $date 
		); 

		$data = $this->security->xss_clean($data_log);
		//insert the form data into database
		$logo_res	=	$this->db->insert('user_master_log', $data);
		if($logo_res){

			$data_upd_pwd  = array(
				'user_master_password'  => 	$password,
				'user_decrypt_pwd'		=> 	$passwordnew
				
			);//print_r($data_log);exit;

			$upduser_res		=	$this->Super_model->update_user_ph_mail($data_upd_pwd,$user_id);
			if($upduser_res){

				/*------------code for send email starts---------------*/
	            $config = Array(
	              'protocol'        => 'smtp',
	              'smtp_host'       => 'ssl://smtp.googlemail.com',
	              'smtp_port'       => 465,
	              'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
	              'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
	              'mailtype'        => 'html',
	              'charset'         => 'iso-8859-1'
	            );//print_r($config);exit;
	                      
	            $message = 'Your Password is reset to '.$passwordnew.'.';
	            $this->load->library('email', $config);
	            $this->email->set_newline("\r\n");
	            $this->email->from('kivportinfo@gmail.com'); // change it to yours
	            //$this->email->to($user_mail);// change it to yours
	            $this->email->to('deepthi.nh@gmail.com');

	            $this->email->subject('Password Reset');
	            $this->email->message($message);
	            if($this->email->send())
	            { //echo "success";redirect("Kiv_Ctrl/Bookofregistration/raHome");
	            // <!------------code for send SMS starts--------------->
	              
	              /*$mobil="9809119144";
	              //$mobil=$user_ph;
	              $stat = $this->Vessel_change_model->sendSms($message,$mobil);
	              if($stat){
	              	$success_msg = "Your Password is Reset. Details has been sent to your mail and mobile.";
					echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
	              } else {*/
	              	$success_msg1 = "Your Password is Reset. Details has been sent to your mail .";
					echo json_encode(array("val_errors" => $success_msg1, "status" => "true"));

	              /*}*/

	              /*------------code for send SMS ends---------------*/
	            }
	            else
	            {
	              show_error($this->email->print_debugger());
	            } 

			} else {
				$error_msg = "An error occured in Password Reset!!!";
				echo json_encode(array("val_errors" => $error_msg, "status" => "false"));
			}	

		}





	}
	
}		

/*============================================= Reset Password (End) ==================================================*/	

/*============================================ VALIDATION(START) ===================================================*/

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

/*============================================ VALIDATION(END) ===================================================*/

}
?>