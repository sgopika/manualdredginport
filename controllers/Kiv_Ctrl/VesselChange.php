<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VesselChange extends CI_Controller {

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
  $this->load->library('upload');
  //$this->load->library('curl');
  $this->data 		= 	array(
  'controller' 		=> 	$this->router->fetch_class(),
  'method' 			=> 	$this->router->fetch_method(),
  'session_userdata' 	=> 	isset($this->session->userdata) ? $this->session->userdata : '',
  'base_url' 			=> 	base_url(),
  'site_url'  		=> 	site_url(),
  /*	'user_sl' 			=> 	isset($this->session->userdata['user_sl']) ? $this->session->userdata['user_sl'] : 0,
  'user_type_id' 		=> 	isset($this->session->userdata['user_type_id']) ? $this->session->userdata['user_type_id'] : 0,*/
  'int_userid'       =>  isset($this->session->userdata['int_userid']) ? $this->session->userdata['int_userid'] : 0,
  'int_usertype'    =>  isset($this->session->userdata['int_usertype']) ? $this->session->userdata['int_usertype'] : 0,
  'customer_id' 		=> 	isset($this->session->userdata['customer_id']) ? $this->session->userdata['customer_id'] : 0,
  'survey_user_id' 	=> 	isset($this->session->userdata['survey_user_id']) ? $this->session->userdata['survey_user_id'] : 0,
  );
  $this->load->model('Kiv_models/Bookofregistration_model'); 
  $this->load->model('Kiv_models/Vessel_change_model'); 
}
	
	
/*_________________________________Registering authority home ________________________________*/

public function raHome()
{
  
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	  =	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

 if(!empty($sess_usr_id))
 {
    $data 			=	 array('title' => 'raHome', 'page' => 'raHome', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
 

    $initial_data			= 	$this->Bookofregistration_model->get_process_flow_ras($sess_usr_id);
	$data['initial_data']	=	$initial_data;
  //print_r($initial_data);




	if(!empty($initial_data))
	{
		$count	= count($initial_data);
		$data['count']=$count;
	}

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/ra',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
}
else
{
    redirect('Main_login/index');        
} 

}
   

/*__________________________________________________________________________*/

/*                                        Registration Module Start                                              */

/*__________________________________________form 12 List ________________________________*/

public function form12List()
{
   /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
   $customer_id   = $this->session->userdata('customer_id');
   $survey_user_id= $this->session->userdata('survey_user_id');

   /*$vessel_id     = $this->uri->segment(4);
   $processflow_sl= $this->uri->segment(5);
   $survey_id     = $this->uri->segment(6);*/

   if(!empty($sess_usr_id)&&($user_type_id==11))
   {
        $data       =  array('title' => 'form12_list', 'page' => 'form12_list', 'errorCls' => NULL, 'post' => $this->input->post());
        $data       =  $data + $this->data;
        $this->load->model('Kiv_models/Survey_model');

	    $initial_data          = $this->Survey_model->get_form12_process_flow($sess_usr_id);
	    $data['initial_data']  = $initial_data;//print_r($initial_data);
	    $count  			         = count($initial_data);
	    $data['count']		     = $count;
	      $this->load->view('Kiv_views/template/dash-header.php');
        $this->load->view('Kiv_views/template/nav-header.php');
        $this->load->view('Kiv_views/dash/form12_list',$data);
        $this->load->view('Kiv_views/template/dash-footer.php');

  }
  else
  {
          redirect('Main_login/index');        
  }

}

/*________________________________________________Form12 List Ends_______________________________________________*/

/*_______________________________________________Form12 Page Starts_______________________________________________*/

public function form12()
{

/* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
$customer_id	   =	$this->session->userdata('customer_id');
$survey_user_id  =	$this->session->userdata('survey_user_id');


$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$status_details_sl1 = $this->uri->segment(6);

$vessel_id          =   str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id     =   $this->encrypt->decode($vessel_id); 

$processflow_sl     =   str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl     =   $this->encrypt->decode($processflow_sl); 

$status_details_sl  =   str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
$status_details_sl  =   $this->encrypt->decode($status_details_sl); 




if(!empty($sess_usr_id)&&($user_type_id==11))
{
  $data 			=	 array('title' => 'form12', 'page' => 'form12', 'errorCls' => NULL, 'post' => $this->input->post());
  $data 			=	 $data + $this->data;
  $this->load->model('Kiv_models/Survey_model');
  $this->load->model('Kiv_models/Bookofregistration_model');

  $vesselDet			    	= $this->Bookofregistration_model->get_vesselDet($vessel_id);
  $data['vesselDet']		=	$vesselDet;
  if(!empty($vesselDet))
  {
     $vessel_type_id       = $vesselDet[0]['vessel_type_id'];
    $vessel_subtype_id    = $vesselDet[0]['vessel_subtype_id'];
  }
 


  $initial_data			    = $this->Survey_model->get_form12_frwd_process_flow($sess_usr_id,$vessel_id);
  $data['initial_data']	=	$initial_data;
  $status_change_date1  = $initial_data[0]['status_change_date'];
  //print_r($initial_data);

  $data['status_details_sl'] = $status_details_sl;
  $data['processflow_sl']    = $processflow_sl;

  $survey_id=1;

  $engine_details             =   $this->Survey_model->get_engine_details($vessel_id,$survey_id);
  $data['engine_details']     = $engine_details;

  $no_of_engineset	= count($engine_details);


		
	    //______________________________________________//
	    //Master Data Population

	    $registeringAuthority           = $this->Bookofregistration_model->get_registeringAuthority();
	    $data['registeringAuthority']   = $registeringAuthority;//print_r($registeringAuthority);

	    $insuranceCompany               = $this->Bookofregistration_model->get_insuranceCompany();
	    $data['insuranceCompany']       = $insuranceCompany;

	    $masClass                       = $this->Bookofregistration_model->get_masterClass();
	    $data['masClass']               = $masClass;

      $plyingPort                     = $this->Bookofregistration_model->get_portofregistry();
     	$data['plyingPort']             = $plyingPort;

     	$vesselMasterDetails            = $this->Bookofregistration_model->get_crew_details($vessel_id,1);
    	$data['vesselMasterDetails']    = $vesselMasterDetails;
    	$vesselMasterDetails_count      = count($vesselMasterDetails);

  //___________________________TARIFF DETAILS____________________________________________//

  $status_change_date 	=	date("Y-m-d", strtotime($status_change_date1));
  $now				 =	date("Y-m-d");
  $date1_ts    = strtotime($status_change_date);
  $date2_ts    = strtotime($now);
  $diff        = $date2_ts - $date1_ts;
  $numberofdays1 =  round($diff / 86400);
  $numberofdays  =  $numberofdays1-30;


$form_id=12;
$activity_id=5;

$tariff_details  =   $this->Bookofregistration_model->get_tariff_form12($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$numberofdays);
//print_r($tariff_details);

$data1['tariff_details'] 	= 	$tariff_details;
if (!empty($tariff_details)) 
{
  $tariff_amount1=$tariff_details[0]['tariff_amount'];
  $tariff_min_amount=$tariff_details[0]['tariff_min_amount'];
}
//print_r($tariff_details);


    $tonnage_details            =   $this->Bookofregistration_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']   =   $tonnage_details;
    

    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
    }
      $amount1=$vessel_total_tonnage*$tariff_amount1;

    if($amount1<250)
    {
       $data['tariff_amount']=$tariff_min_amount;
    }
    else
    {
      $data['tariff_amount']=$amount1;
    }
/* $this->load->view('Kiv_views/template/dash-dash-header.php');
$this->load->view('Kiv_views/template/nav-header.php');
$this->load->view('Kiv_views/dash/form12',$data);
$this->load->view('Kiv_views/template/dash-footer.php');*/

$this->load->view('Kiv_views/template/dash-header.php');
$this->load->view('Kiv_views/template/nav-header.php');
$this->load->view('Kiv_views/dash/form12', $data);
$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
	        redirect('Main_login/index');        
	}

}

public function payment_details_form12()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id     = $this->session->userdata('customer_id');
  $survey_user_id  = $this->session->userdata('survey_user_id');

  $vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$status_details_sl1 = $this->uri->segment(6);

$vessel_id          =   str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id     =   $this->encrypt->decode($vessel_id); 

$processflow_sl     =   str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl     =   $this->encrypt->decode($processflow_sl); 

$status_details_sl  =   str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
$status_details_sl  =   $this->encrypt->decode($status_details_sl); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'payment_details_form12', 'page' => 'payment_details_form12', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Bookofregistration_model');

     $this->load->model('Kiv_models/Survey_model');
  //$this->load->model('Kiv_models/Bookofregistration_model');

      $plyingPort                     = $this->Bookofregistration_model->get_portofregistry();
      $data['plyingPort']             = $plyingPort;

  $vesselDet            = $this->Bookofregistration_model->get_vesselDet($vessel_id);
  $data['vesselDet']    = $vesselDet;
  $vessel_type_id       = $vesselDet[0]['vessel_type_id'];
  $vessel_subtype_id    = $vesselDet[0]['vessel_subtype_id'];


  $initial_data         = $this->Survey_model->get_form12_frwd_process_flow($sess_usr_id,$vessel_id);
  $data['initial_data'] = $initial_data;
  $status_change_date1  = $initial_data[0]['status_change_date'];
  //print_r($initial_data);

  $data['status_details_sl'] = $status_details_sl;
  $data['processflow_sl']    = $processflow_sl;

  $survey_id=1;

  $engine_details             =   $this->Survey_model->get_engine_details($vessel_id,$survey_id);
  $data['engine_details']     = $engine_details;

  $no_of_engineset  = count($engine_details);

  $vesselMasterDetails            = $this->Bookofregistration_model->get_crew_details($vessel_id,1);
      $data['vesselMasterDetails']    = $vesselMasterDetails;
      $vesselMasterDetails_count      = count($vesselMasterDetails);

  //___________________________TARIFF DETAILS____________________________________________//

  $status_change_date   = date("Y-m-d", strtotime($status_change_date1));
  $now         =  date("Y-m-d");
  $date1_ts    = strtotime($status_change_date);
  $date2_ts    = strtotime($now);
  $diff        = $date2_ts - $date1_ts;
  $numberofdays1 =  round($diff / 86400);
  $numberofdays  =  $numberofdays1-10;


$form_id=12;
$activity_id=5;

$tariff_details  =   $this->Bookofregistration_model->get_tariff_form12($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$numberofdays);
$data1['tariff_details']  =   $tariff_details;
if (!empty($tariff_details)) 
{
  $tariff_amount1=$tariff_details[0]['tariff_amount'];
  $tariff_min_amount=$tariff_details[0]['tariff_min_amount'];
}
//print_r($tariff_details);


    $tonnage_details            =   $this->Bookofregistration_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']   =   $tonnage_details;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
    }
      $amount1=$vessel_total_tonnage*$tariff_amount1;

    if($amount1<250)
    {
      $data['tariff_amount']=$tariff_min_amount;
    }
    else
    {
      $data['tariff_amount']=$amount1;
    }


if($this->input->post())
{
  date_default_timezone_set("Asia/Kolkata");
  $date      =   date('Y-m-d h:i:s', time());
  $ip        = $_SERVER['REMOTE_ADDR'];
  $newDate   =   date("Y-m-d");

  $vessel_id                =  $this->security->xss_clean($this->input->post('vessel_sl'));
  $processflow_sl           =  $this->security->xss_clean($this->input->post('processflow_sl'));
  $status_details_sl        =  $this->security->xss_clean($this->input->post('status_details_sl'));
  $vessel_registry_port_id  =  $this->security->xss_clean($this->input->post('vessel_registry_port_id'));
  $registeringAuthorityId   =  $this->security->xss_clean($this->input->post('registeringAuthorityId'));
  $speedofEngine            =  $this->security->xss_clean($this->input->post('speedofEngine'));
  $insuranceCompanyId       =  $this->security->xss_clean($this->input->post('insuranceCompanyId'));
  $insuranceNumber          =  $this->security->xss_clean($this->input->post('insuranceNumber'));
  $insuranceDate            =  $this->security->xss_clean($this->input->post('insuranceDate'));
  $insuranceValidity        =  $this->security->xss_clean($this->input->post('insuranceValidity'));
  $yardName                 =  $this->security->xss_clean($this->input->post('yardName'));
  $plying_portofregistry    =  $this->security->xss_clean($this->input->post('plying_portofregistry'));
  $vesselPurchaseAmount     =  $this->security->xss_clean($this->input->post('vesselPurchaseAmount'));
  $vesselPurchaseDate       =  $this->security->xss_clean($this->input->post('vesselPurchaseDate'));
  $placeOfBussiness         =  $this->security->xss_clean($this->input->post('placeOfBussiness'));
 $statementofOwner          =  $_FILES["statementofOwner"]["name"];
$thirdpartyInsuranceCopy  =  $_FILES["thirdpartyInsuranceCopy"]["name"];
 $declarationOfOwnership  =  $_FILES["declarationOfOwnership"]["name"];
  $tariff_amount            =  $this->security->xss_clean($this->input->post('dd_amount'));
  /*_____________________________Upload Thirdpaty Insurance Copy start_____________________________*/

if($thirdpartyInsuranceCopy)
{ 
    $ins_path_parts = pathinfo($_FILES["thirdpartyInsuranceCopy"]["name"]);
    $ins_extension  = $ins_path_parts['extension'];

    $ins_file_name='INS'.'_REG_Form12_'.$vessel_id.'_'.$date.'.'.$ins_extension;
    $ins_upd=copy($_FILES["thirdpartyInsuranceCopy"]["tmp_name"], "./uploads/thirdPartyInsurance"."/".$ins_file_name); 
}
/*_____________________________Upload Thirdpaty Insurance Copy end_____________________________*/
/*_____________________________Upload Statement of Owner start_________________________________*/
if($statementofOwner)
{ 
    $smt_path_parts = pathinfo($_FILES["statementofOwner"]["name"]);
    $smt_extension  = $smt_path_parts['extension'];

    $smt_file_name='SO'.'_REG_Form12_'.$vessel_id.'_'.$date.'.'.$smt_extension;
    $smt_upd=copy($_FILES["statementofOwner"]["tmp_name"], "./uploads/OwnerStatement"."/".$smt_file_name);
}
/*_____________________________Upload Statement of Owner end________________________________*/

 /*_____________________________Upload Declaration form start_____________________________*/

if($declarationOfOwnership)
{ 
    $dln_path_parts = pathinfo($_FILES["declarationOfOwnership"]["name"]);
    if($dln_path_parts){
    $dln_extension  = $dln_path_parts['extension'];
    
       $dln_file_name='DLS'.'_REG_Form12_'.$vessel_id.'_'.$date.'.'.$dln_extension;
    $dln_upd=copy($_FILES["declarationOfOwnership"]["tmp_name"], "./uploads/declarationOfOwnership"."/".$dln_file_name); 
    }

   
}
/*_____________________________Upload Declaration form end_____________________________*/

/*_____________________________Update Registering Authority start_________________________________*/

$updateRA=array(
  'registering_authority'     =>  $registeringAuthorityId,
  'yardName'                  =>  $yardName,
  'plying_portofregistry'     =>  $plying_portofregistry,
  'vesselPurchaseAmount'      =>  $vesselPurchaseAmount,
  'vesselPurchaseDate'        =>  $vesselPurchaseDate,
  'placeOfBussiness'          =>  $placeOfBussiness,
  'vessel_modified_user_id'   =>  $sess_usr_id,
  'vessel_modified_timestamp' =>  $date,
  'vessel_modified_ipaddress' =>  $ip
  );
  $updateRA  = $this->security->xss_clean($updateRA);   
  $this->db->where('vessel_sl', $vessel_id);
  $updateRA_res=$this->db->update('tbl_kiv_vessel_details', $updateRA);
      
/*___________________Update Registering Authority end____________________________*/

/*___________________Insert Engine Details start____________________________________*/

for($i=1;$i<=$no_of_engineset;$i++)
{
$data_engine=array(
    'engine_speed'=>$speedofEngine,
    'engine_modified_user_id'=>$sess_usr_id,
    'engine_modified_timestamp'=>$date,
    'engine_modified_ipaddress'=>$ip
    );

   $update_engine_table   = $this->Bookofregistration_model->update_table_engine_byvessel('tbl_kiv_engine_details',$data_engine,$vessel_id);
}
      
/*___________________Insert Engine Details end____________________________________*/
/*___________________Insert Insurance Details of Vessel start_____________________*/
      
$insertInsuranceDet=array(
  'vessel_id'                      => $vessel_id,
  'vessel_insurance_company'       => $insuranceCompanyId,
  'vessel_insurance_number'        => $insuranceNumber,
  'vessel_insurance_date'          => $insuranceDate,
  'vessel_insurance_validity'      => $insuranceValidity,
 'vessel_thirdpartyInsuranceCopy' => $ins_file_name,
  'vessel_statementofOwner'        => $smt_file_name
  );

$insertInsuranceDet      = $this->security->xss_clean($insertInsuranceDet);         
$insertInsuranceDet_res  = $this->db->insert('tbl_vessel_insurance_details', $insertInsuranceDet);
/*___________________Insert Insurance Details of Vessel end_____________________*/
}
  /*$this->load->view('Kiv_views/template/dash-dash-header.php');
  $this->load->view('Kiv_views/template/nav-header.php');
  $this->load->view('Kiv_views/dash/payment_details_form12',$data);
  $this->load->view('Kiv_views/template/dash-footer.php');*/

$this->load->view('Kiv_views/template/dash-header.php');
$this->load->view('Kiv_views/template/nav-header.php');
$this->load->view('Kiv_views/dash/payment_details_form12', $data);
$this->load->view('Kiv_views/template/dash-footer.php');

 
  }
  else
  {
    redirect('Main_login/index'); 
  }
}

function pay_now_form12()
{

 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id     = $this->session->userdata('customer_id');
  $survey_user_id  = $this->session->userdata('survey_user_id');


  $vessel_id1    = $this->uri->segment(4);
  $processflow_sl1   = $this->uri->segment(5);
  $status_details_sl1    = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $status_details_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl=$this->encrypt->decode($status_details_sl); 

if(!empty($sess_usr_id))
{
  $data       =  array('title' => 'pay_now_form12', 'page' => 'pay_now_form12', 'errorCls' => NULL, 'post' => $this->input->post());
  $data       =  $data + $this->data;
  $this->load->model('Kiv_models/Survey_model');
  $this->load->model('Kiv_models/Bookofregistration_model');


  date_default_timezone_set("Asia/Kolkata");
  $date             = date('Y-m-d h:i:s', time());
  $ip               = $_SERVER['REMOTE_ADDR'];
  $newDate          = date("Y-m-d");
  $vessel_id        = $this->security->xss_clean($this->input->post('vessel_sl'));
  $processflow_sl   = $this->security->xss_clean($this->input->post('processflow_sl'));
  $status_details_sl= $this->security->xss_clean($this->input->post('status_details_sl'));

  
    $process_id     = $this->security->xss_clean($this->input->post('process_id')); 
    $current_status_id  = $this->security->xss_clean($this->input->post('current_status_id'));
     $current_position   = $this->security->xss_clean($this->input->post('current_position')); 
    $status_change_date = $date;
    $survey_id=0;
   
    $user_id      = $this->security->xss_clean($this->input->post('user_id'));
    $status       = 1;
    $paymenttype_id       =4;
    $dd_amount            =$this->security->xss_clean($this->input->post('dd_amount'));
    $portofregistry_sl =$this->security->xss_clean($this->input->post('portofregistry_sl'));
      
    $form_number_cs=  $this->Survey_model->get_form_number_cs($process_id);
  $data['form_number_cs']     =   $form_number_cs;
  if(!empty($form_number_cs))
  {
    $formnumber=$form_number_cs[0]['form_no'];
  }

 
    $data_payment=array(
      'vessel_id'=>$vessel_id,
      'survey_id'=>$survey_id,
      'form_number'=>$formnumber,
      'paymenttype_id'=>$paymenttype_id,
      'dd_amount'=>$dd_amount,
      'dd_date'=>$newDate,
      'portofregistry_id'=>$portofregistry_sl,
      'payment_created_user_id'=>$sess_usr_id,
      'payment_created_timestamp'=>$date,
      'payment_created_ipaddress'=>$ip
    );

    // print_r($data_payment);


    $result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment); 

    $task_pfid=$this->Survey_model->get_task_pfid($processflow_sl);
    $data['task_pfid']  = $task_pfid;
    @$task_sl=$task_pfid[0]['task_sl'];



$port_registry_user_id           =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
   $data['port_registry_user_id']  =   $port_registry_user_id;
   if(!empty($port_registry_user_id))
   {
    $pc_user_id=$port_registry_user_id[0]['user_sl'];
    $pc_usertype_id=$port_registry_user_id[0]['user_type_id'];
   }
    
    if($process_id==14)
    {
      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>2,
      'current_position'=>$pc_usertype_id,
      'user_id'=>$pc_user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date
      );


      $data_update = array('status'=>0);

      $data_survey_status=array(
        'survey_id'=>$survey_id,
      'current_status_id'=>2,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$pc_user_id);



      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      

      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      if($process_update && $process_insert && $status_update && $result_insert)
      {
        redirect("Kiv_Ctrl/Survey/SurveyHome");
      }
   }

  }
  else
  {
    redirect('Main_login/index'); 
  }
}

public function Verify_registration_form12()
{
	/* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
	$customer_id	=	$this->session->userdata('customer_id');
	$survey_user_id =	$this->session->userdata('survey_user_id');

	$vessel_id1    = $this->uri->segment(4);
	$processflow_sl1   = $this->uri->segment(5);
	$status_details_sl1    = $this->uri->segment(6);

	$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
	$vessel_id=$this->encrypt->decode($vessel_id); 

	$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
	$processflow_sl=$this->encrypt->decode($processflow_sl); 

	$status_details_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
	$status_details_sl=$this->encrypt->decode($status_details_sl); 
	$survey_id=0;

	if(!empty($sess_usr_id))
	{
		$data 	=	 array('title' => 'Verify_registration_form12', 'page' => 'Verify_registration_form12', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 	=	 $data + $this->data;
		$this->load->model('Kiv_models/Survey_model');

		$vessel_details       		=   $this->Survey_model->get_process_flow_payment($processflow_sl);
		$data['vessel_details']   	= 	$vessel_details;
		@$id            			= 	$vessel_details[0]['uid'];

		$customer_details      	 	= 	$this->Survey_model->get_customer_details($id);
		$data['customer_details'] 	= 	$customer_details;

		$current_status       		= 	$this->Survey_model->get_status();
		$data['current_status']   	= 	$current_status;

		$form_number        		= 	$this->Survey_model->get_form_number($vessel_id);
		$data['form_number']    	= 	$form_number;
		$form_id 					=	$form_number[0]['form_no'];

		$plyingPort                 = $this->Bookofregistration_model->get_portofregistry();
		$data['plyingPort']         = $plyingPort;

		//----------Vessel Details--------//

		$vessel_details_viewpage =  $this->Survey_model->get_vessel_details_viewpage($vessel_id);
		$data['vessel_details_viewpage']= $vessel_details_viewpage;

		//----------Payment Details--------//

		$payment_details =  $this->Survey_model->get_form3_tariff($vessel_id,$survey_id,$form_id);
		$data['payment_details']= $payment_details;
		//print_r($payment_details);

		if($this->input->post())
		{
			date_default_timezone_set("Asia/Kolkata");
			$date   			= 	date('Y-m-d h:i:s', time());
			$status_change_date =	$date;
			$remarks_date		=	date('Y-m-d');
			 $ip     =	$_SERVER['REMOTE_ADDR'];

			 $registration_inspection_date 	=	$this->security->xss_clean($this->input->post('registration_inspection_date'));
			
			/*$registration_inspection_date1 = str_replace('/', '-', $registration_inspection_date2);
    		$registration_inspection_date   = date("Y-m-d", strtotime($registration_inspection_date1));*/

			 $portofregistry_sl 	=	$this->security->xss_clean($this->input->post('portofregistry_sl'));
			 $registration_intimation_remark =$this->security->xss_clean($this->input->post('registration_intimation_remark'));

			/*$registration_inspection_report_upload  =  $_FILES["registration_inspection_report_upload"]["name"];
			


			if($registration_inspection_report_upload)
			{
				echo "uploaded";
				$ins_path_parts = pathinfo($_FILES["registration_inspection_report_upload"]["name"]);
    $ins_extension  = $ins_path_parts['extension'];

    $ins_file_name='INT'.'_REG_Form13_'.$vessel_id.'_'.$date.'.'.$ins_extension;
    $ins_upd=copy($_FILES["registration_inspection_report_upload"]["tmp_name"], "./uploads/RegistrationIntimation"."/".$ins_file_name); 
			}
			else
			{
				echo "not";
			}
			*/
   
    	/*
    	$registration_inspection 		= 	pathinfo($_FILES['registration_inspection_report_upload']['name']);

    	if($registration_inspection)
    	{
    		$extension  			= 	$registration_inspection['extension'];
    	}
    	else
    	{
    		$extension  ="";
    	}
*/
            /*  $pdf_name=$vessel_id.'_'.$intimation_sl.'_'.$survey_defects_sl.'_'.$random_number.'.'.$extension;
          copy($_FILES["defect_intimation"]["tmp_name"], "./uploads/defects/".$pdf_name);*/

			$vessel_id 			    =	  $this->security->xss_clean($this->input->post('vessel_id'));	
			$process_id 		    =	  $this->security->xss_clean($this->input->post('process_id')); 
		  $survey_id 			    =	  $this->security->xss_clean($this->input->post('survey_id'));
		 	$current_status_id 	=	  $this->security->xss_clean($this->input->post('current_status_id'));
		 	 
		 	$processflow_sl		   =	$this->security->xss_clean($this->input->post('processflow_sl'));
		 	$current_position 	 =	$this->security->xss_clean($this->input->post('current_position'));
		 	$user_id 			       =	$this->security->xss_clean($this->input->post('user_sl_ra'));
		 	$status 			       =	1;
		 	$status_details_sl 	 =	$this->security->xss_clean($this->input->post('status_details_sl'));
      $next_process_id=16;
      $survey_id=0;

    if($process_id==14)
    {
        $data_reg_intimation= array(
        'vessel_id'=>$vessel_id,
        'registration_intimation_type_id' => 1,
        'registration_intimation_place_id' => $portofregistry_sl, 
        'registration_intimation_remark' => $registration_intimation_remark,
        'registration_inspection_report_upload' => '',
        'registration_inspection_date' => $registration_inspection_date,
        'registration_inspection_status' => 1,
        'registration_inspection_created_user_id' => $user_id,
        'registration_inspection_created_timestamp'=>$date,
        'registration_inspection_created_ipaddress'=>$ip);
     $insert_intimation=$this->Survey_model->insert_doc('a5_tbl_registration_intimation', $data_reg_intimation);

      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$current_position,
      'user_id'=>$user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date
      );


      $data_update = array('status'=>0);

      $data_survey_status=array(
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$sess_usr_id);


      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

      $processflow_id_new     =   $this->db->insert_id();


      $data_insert1=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$next_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>2,
      'current_position'=>$current_position,
      'user_id'=>$user_id,
      'previous_module_id'=>$processflow_id_new,
      'status'=>$status,
      'status_change_date'=>$status_change_date
      );


      $data_update1 = array('status'=>0);

      $data_survey_status1=array(
      'process_id'=>$next_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>2,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$user_id);
      

      $status_update1=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status1,$status_details_sl);
      $process_update1=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update1, $processflow_id_new);
      $process_insert1=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert1);

      if($insert_intimation && $status_update && $process_update && $process_insert && $status_update1 && $process_update1 && $process_insert1)
      {
        redirect("Kiv_Ctrl/Bookofregistration/raHome");
      }
    }
}
		$this->load->view('Kiv_views/template/dash-header.php');
	    $this->load->view('Kiv_views/template/nav-header.php');
	    $this->load->view('Kiv_views/dash/Verify_registration_form12',$data);
	    $this->load->view('Kiv_views/template/dash-footer.php');

	}    
  else
  {
    redirect('Main_login/index'); 
  }
}


public function view_form13()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');

  $vessel_id1    = $this->uri->segment(4);
  $processflow_sl1   = $this->uri->segment(5);
  $status_details_sl1    = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $status_details_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl=$this->encrypt->decode($status_details_sl); 
  $survey_id=0;

  if(!empty($sess_usr_id) && ($user_type_id==14))
  {
    $data       =  array('title' => 'view_form13', 'page' => 'view_form13', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			= 	$this->Bookofregistration_model->get_process_flow($processflow_sl);
	$data['initial_data']	=	$initial_data;
	//print_r($initial_data);

    $intimation_type_id=1;

    $registration_intimation          = $this->Survey_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']  = $registration_intimation;

    $stern_material=$this->Bookofregistration_model->get_stern_material();
    $data['stern_material']  = $stern_material;

    $plyingPort                     = $this->Bookofregistration_model->get_portofregistry();
    $data['plyingPort']             = $plyingPort;

    	$this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/view_form13',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
    
  }
  else
  {
    redirect('Main_login/index');
  }
  
}


function registration_intimation_resend()
{
	/* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
	$customer_id	=	$this->session->userdata('customer_id');
	$survey_user_id	=	$this->session->userdata('survey_user_id');


	if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'registration_intimation_resend', 'page' => 'registration_intimation_resend', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
		$this->load->model('Kiv_models/Survey_model');


		date_default_timezone_set("Asia/Kolkata");
			$date   			= 	date('Y-m-d h:i:s', time());
			$status_change_date =	$date;
			$remarks_date		=	date('Y-m-d');
			 $ip     =	$_SERVER['REMOTE_ADDR'];

			 $registration_inspection_date 	=	$this->security->xss_clean($this->input->post('registration_inspection_date'));
			
			/*$registration_inspection_date1 = str_replace('/', '-', $registration_inspection_date2);
    		$registration_inspection_date   = date("Y-m-d", strtotime($registration_inspection_date1));*/

			 $portofregistry_sl 	=	$this->security->xss_clean($this->input->post('portofregistry_sl'));
			 $registration_intimation_remark =$this->security->xss_clean($this->input->post('registration_intimation_remark'));

		/*$registration_inspection_report_upload  =  $_FILES["registration_inspection_report_upload"]["name"];

		if($registration_inspection_report_upload)
		{
		echo "uploaded";
		$ins_path_parts = pathinfo($_FILES["registration_inspection_report_upload"]["name"]);
		$ins_extension  = $ins_path_parts['extension'];

		$ins_file_name='INT'.'_REG_Form13_'.$vessel_id.'_'.$date.'.'.$ins_extension;
		$ins_upd=copy($_FILES["registration_inspection_report_upload"]["tmp_name"], "./uploads/RegistrationIntimation"."/".$ins_file_name); 
		}
		else
		{
		echo "not";
		}
		$registration_inspection 		= 	pathinfo($_FILES['registration_inspection_report_upload']['name']);
		if($registration_inspection)
		{
		$extension  			= 	$registration_inspection['extension'];
		}
		else
		{
		$extension  ="";
		}
		*/
		/*  $pdf_name=$vessel_id.'_'.$intimation_sl.'_'.$survey_defects_sl.'_'.$random_number.'.'.$extension;
		copy($_FILES["defect_intimation"]["tmp_name"], "./uploads/defects/".$pdf_name);*/

		$vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
		$process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
		$survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
		$processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
		$status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));
		$current_position 	=	$this->security->xss_clean($this->input->post('current_position'));
		$user_id 			=	$this->security->xss_clean($this->input->post('user_sl_ra'));
		$registration_intimation_sl=	$this->security->xss_clean($this->input->post('registration_intimation_sl'));
		$user_id_owner 		=	$this->security->xss_clean($this->input->post('user_id_owner'));
		$user_type_id_owner =	$this->security->xss_clean($this->input->post('user_type_id_owner'));
		$current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
		$status 			=	1;

      $survey_id=0;

    if($process_id==16)
    {
        $data_reg_intimation= array(
        'vessel_id'=>$vessel_id,
        'registration_intimation_type_id' => 1,
        'registration_intimation_place_id' => $portofregistry_sl, 
        'registration_intimation_remark' => $registration_intimation_remark,
        'registration_inspection_report_upload' => '',
        'registration_inspection_date' => $registration_inspection_date,
        'registration_inspection_status' => 1,
        'registration_inspection_created_user_id' => $user_id,
        'registration_inspection_created_timestamp'=>$date,
        'registration_inspection_created_ipaddress'=>$ip);
     $insert_intimation=$this->Survey_model->insert_doc('a5_tbl_registration_intimation', $data_reg_intimation);

	$intimation_data = array('registration_inspection_status'=>0);


      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>2,
      'current_position'=>$current_position,
      'user_id'=>$sess_usr_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date
      );


      $data_update = array('status'=>0);

      $data_survey_status=array(
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>4,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$sess_usr_id);


      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      $intimation_update=$this->Survey_model->update_registration_intimation('a5_tbl_registration_intimation', $intimation_data,$registration_intimation_sl);

      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

if($insert_intimation && $status_update && $process_update && $process_insert && $intimation_update)
{
redirect("Kiv_Ctrl/Bookofregistration/raHome");
}
}


}
else
  {
    redirect('Main_login/index'); 
  }
}




function registration_certificate()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'registration_certificate', 'page' => 'registration_certificate', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_id      = $this->security->xss_clean($this->input->post('vessel_id'));  
    $process_id     = $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id      = $this->security->xss_clean($this->input->post('survey_id'));
    $processflow_sl   = $this->security->xss_clean($this->input->post('processflow_sl'));
    $status_details_sl  = $this->security->xss_clean($this->input->post('status_details_sl'));
    $current_position   = $this->security->xss_clean($this->input->post('current_position'));
    $user_id      = $this->security->xss_clean($this->input->post('user_sl_ra'));
    $registration_intimation_sl=  $this->security->xss_clean($this->input->post('registration_intimation_sl'));
    $user_id_owner    = $this->security->xss_clean($this->input->post('user_id_owner'));
    $user_type_id_owner = $this->security->xss_clean($this->input->post('user_type_id_owner'));
    $current_status_id  = $this->security->xss_clean($this->input->post('current_status_id'));
    $status       = 1;

      date_default_timezone_set("Asia/Kolkata");
      $date         =   date('Y-m-d h:i:s', time());
      $status_change_date = $date;
      $remarks_date   = date('Y-m-d');
       $ip     =  $_SERVER['REMOTE_ADDR'];

  $data_insert_approve=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>5,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>0,
        'status_change_date'=>$status_change_date
        );


      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$user_type_id_owner,
      'user_id'=>$user_id_owner,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date
      );

       $data_update = array('status'=>0);

      $data_survey_status=array(
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$user_id_owner);
      



      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);

      

      $process_insert_approve=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_approve);

      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

      if($status_update && $process_update && $process_insert)
      {
        redirect("Kiv_Ctrl/Bookofregistration/raHome");
      }



  }
  else
  {
    redirect('Main_login/index'); 
  }
}





/*_______________________________________________________________________________________________________________*/
/*                                      Registration Module Ends                                                */
/*_______________________________________________________________________________________________________________*/

public function reg_certificate_list()
{
    /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'reg_certificate_list', 'page' => 'reg_certificate_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $reg_vessel      =   $this->Bookofregistration_model->get_reg_vessel_list();
   $data['reg_vessel']  = $reg_vessel;



     $this->load->view('Kiv_views/template/dash-header.php');
        $this->load->view('Kiv_views/template/nav-header.php');
        $this->load->view('Kiv_views/dash/reg_certificate_list',$data);
        $this->load->view('Kiv_views/template/dash-footer.php');

}
else
  {
    redirect('Main_login/index'); 
  }
}
///////////////////////Vessel Name Change------Start---------//////////////////////////
public function nameChange_list()
{ 
   /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
   $customer_id                       = $this->session->userdata('customer_id');
   $survey_user_id                    = $this->session->userdata('survey_user_id');

   
   if(!empty($sess_usr_id)&&($user_type_id==11))
   {
      $data = array('title' => 'nameChange_list', 'page' => 'nameChange_list', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      $vessel_list                    = $this->Vessel_change_model->get_vesselchange_List($sess_usr_id);
      $data['vessel_list']            = $vessel_list;//print_r($vessel_list);
      $count                          = count($vessel_list);
      $data['count']                  = $count;
      $data                           = $data + $this->data;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/nameChange_list',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
   }
   else
   {
          redirect('Main_login/index');        
   }

}

public function namechange()
{ 
   	/* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
   	$customer_id   	                  = $this->session->userdata('customer_id');
   	$survey_user_id	                  = $this->session->userdata('survey_user_id');
	
	  $vessel_id1                       = $this->uri->segment(4);
    $processflow_sl1                  = $this->uri->segment(5);
    $status_details_sl1               = $this->uri->segment(6);

    $vessel_id                        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
    $vessel_id                        = $this->encrypt->decode($vessel_id); 

    $processflow_sl                   = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
    $processflow_sl                   = $this->encrypt->decode($processflow_sl); 

    $status_details_sl                = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
    $status_details_sl                = $this->encrypt->decode($status_details_sl); 

   
   if(!empty($sess_usr_id)&&($user_type_id==11))
   {
      $data = array('title' => 'namechange', 'page' => 'namechange', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      $vesselDet			    	          = $this->Vessel_change_model->get_vesselDet($vessel_id);
  	  $data['vesselDet']		          =	$vesselDet; //print_r($vesselDet);exit;
  	  if(!empty($vesselDet))
  	  {
    		$vessel_type_id               = $vesselDet[0]['vessel_type_id'];
    		$vessel_subtype_id            = $vesselDet[0]['vessel_subtype_id'];
  	  }
 


      $process_data			              = $this->Vessel_change_model->get_process_flow_sl($vessel_id);
      $data['process_data']	          =	$process_data;
      @$status_change_date1           = $process_data[0]['status_change_date'];
  //print_r($process_data);exit;

      $data['status_details_sl']      = $status_details_sl;
      $data['processflow_sl']         = $processflow_sl;

      $survey_id                      = 0;

      $engine_details                 = $this->Vessel_change_model->get_engine_details($vessel_id,$survey_id);
      $data['engine_details']         = $engine_details;

      $no_of_engineset                = count($engine_details);


    
      //______________________________________________//
      //Master Data Population

      $registeringAuthority           = $this->Bookofregistration_model->get_registeringAuthority();
      $data['registeringAuthority']   = $registeringAuthority;//print_r($registeringAuthority);

      $insuranceCompany               = $this->Bookofregistration_model->get_insuranceCompany();
      $data['insuranceCompany']       = $insuranceCompany;

      $masClass                       = $this->Bookofregistration_model->get_masterClass();
      $data['masClass']               = $masClass;

      $plyingPort                     = $this->Bookofregistration_model->get_portofregistry();
      $data['plyingPort']             = $plyingPort;

      $vesselMasterDetails            = $this->Bookofregistration_model->get_crew_details($vessel_id,1);
      $data['vesselMasterDetails']    = $vesselMasterDetails;
      $vesselMasterDetails_count      = count($vesselMasterDetails);

  //___________________________TARIFF DETAILS____________________________________________//

      $status_change_date             = date("Y-m-d", strtotime($status_change_date1));
      $now                            = date("Y-m-d");
      $date1_ts                       = strtotime($status_change_date);
      $date2_ts                       = strtotime($now);
      $diff                           = $date2_ts - $date1_ts;
      $numberofdays1                  = round($diff / 86400);
      

      $form_id                        = 11;
      $activity_id                    = 6;
      //echo $activity_id.'--'.$form_id.'--'.$vessel_type_id.'--'.$vessel_subtype_id;exit;
      $tariff_details                 = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);//print_r($tariff_details);exit;
      $data1['tariff_details']        = $tariff_details; 
      if (!empty($tariff_details)) 
      {
        $tariff_amount1               = $tariff_details[0]['tariff_amount'];
        $tariff_min_amount            = $tariff_details[0]['tariff_min_amount'];
      }
      
      $tonnage_details                = $this->Vessel_change_model->get_tonnage_details($vessel_id);
      $data1['tonnage_details']       = $tonnage_details;//print_r($tonnage_details);exit;
      if(!empty($tonnage_details))
      {
        @$vessel_total_tonnage        = $tonnage_details[0]['vessel_total_tonnage'];
      }
      $amount1                        = $vessel_total_tonnage*$tariff_amount1;

      if($amount1<100)
      {
        $data['tariff_amount']        = $tariff_min_amount;
      }
      else
      {
        $data['tariff_amount']        = $amount1;
      }
      
      $data = $data + $this->data;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/namechange',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
   }
   else
   {
          redirect('Main_login/index');        
   }

}

public function payment_details_form11()
{
/* $sess_usr_id     =   $this->session->userdata('user_sl');
  $user_type_id    = $this->session->userdata('user_type_id');*/
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                        = $this->session->userdata('customer_id');
  $survey_user_id                     = $this->session->userdata('survey_user_id');

  $vessel_id1                         = $this->uri->segment(4);
  $processflow_sl1                    = $this->uri->segment(5);
  $status_details_sl1                 = $this->uri->segment(6);

  $vessel_id                          = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                          = $this->encrypt->decode($vessel_id); 

  $processflow_sl                     = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                     = $this->encrypt->decode($processflow_sl); 

  $status_details_sl                  = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl                  = $this->encrypt->decode($status_details_sl); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'payment_details_form11', 'page' => 'payment_details_form11', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Bookofregistration_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $this->load->model('Kiv_models/Survey_model');

    $plyingPort                       = $this->Vessel_change_model->get_portofregistry();
    $data['plyingPort']               = $plyingPort;

    $vesselDet                        = $this->Vessel_change_model->get_vesselDet($vessel_id);
    $data['vesselDet']                = $vesselDet;
    $vessel_type_id                   = $vesselDet[0]['vessel_type_id'];
    $vessel_subtype_id                = $vesselDet[0]['vessel_subtype_id'];


    $initial_data                     = $this->Vessel_change_model->get_process_flow_sl($vessel_id);
    $data['initial_data']             = $initial_data;
    @$status_change_date1             = $initial_data[0]['status_change_date'];
    //print_r($initial_data);

    $data['status_details_sl']        = $status_details_sl;
    $data['processflow_sl']           = $processflow_sl;

    $survey_id                        = 0;

    $engine_details                   = $this->Vessel_change_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']           = $engine_details;

    $no_of_engineset                  = count($engine_details);

    $vesselMasterDetails              = $this->Vessel_change_model->get_crew_details($vessel_id,1);
    $data['vesselMasterDetails']      = $vesselMasterDetails;
    $vesselMasterDetails_count        = count($vesselMasterDetails);

    $bank                             = $this->Survey_model->get_bank_favoring();
    $data['bank']                     = $bank;


    $portofregistry                   = $this->Survey_model->get_portofregistry();
    $data['portofregistry']           = $portofregistry;

  //___________________________TARIFF DETAILS____________________________________________//

    $status_change_date               = date("Y-m-d", strtotime($status_change_date1));
    $now                              = date("Y-m-d");
    $date1_ts                         = strtotime($status_change_date);
    $date2_ts                         = strtotime($now);
    $diff                             = $date2_ts - $date1_ts;
    $numberofdays1                    = round($diff / 86400);
    $numberofdays                     = $numberofdays1-10;


    $form_id                          = 11;
    $activity_id                      = 6;

    $tariff_details                   = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data1['tariff_details']          = $tariff_details; 
    if (!empty($tariff_details)) 
    {
      $tariff_amount1                 = $tariff_details[0]['tariff_amount'];
      $tariff_min_amount              = $tariff_details[0]['tariff_min_amount'];
    }
      
    $tonnage_details                  = $this->Vessel_change_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']         = $tonnage_details;//print_r($tonnage_details);exit;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage          = $tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1                          = $vessel_total_tonnage*$tariff_amount1;

    if($amount1<100)
    {
      //$data['tariff_amount']          = $tariff_min_amount;
      $data['tariff_amount']          = 1;
    }
    else
    {
      //$data['tariff_amount']          = $amount1;
      $data['tariff_amount']          = 1;
    }

    //$this->form_validation->set_rules('newvesselname', 'New Vessel Name', 'required');

    /*if ($this->form_validation->run() == FALSE)
    {
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
        echo "val_errors--".validation_errors();//exit;
       
    }   
    else  
    {*/
     //print_r($_POST);exit;
      if($this->input->post())
      {
          date_default_timezone_set("Asia/Kolkata");
          $date                         = date('Y-m-d h:i:s', time());
          $ip                           = $_SERVER['REMOTE_ADDR'];
          $newDate                      = date("Y-m-d");

          $vessel_id                    = $this->security->xss_clean($this->input->post('vessel_sl'));
          $processflow_sl               = $this->security->xss_clean($this->input->post('processflow_sl'));
          $status_details_sl            = $this->security->xss_clean($this->input->post('status_details_sl'));
          $vessel_registry_port_id      = $this->security->xss_clean($this->input->post('vessel_registry_port_id'));
          $tariff_amount                = $this->security->xss_clean($this->input->post('dd_amount'));
          $newvesselname                = $this->security->xss_clean($this->input->post('newvesselname'));

          $vessel_main                  = $this->Vessel_change_model->get_vessel_main($vessel_id);
          $data['vessel_main']          = $vessel_main;
          if(!empty($vessel_main))
          {
            $vesselmain_sl              = $vessel_main[0]['vesselmain_sl'];
          }
          //////////////////////Reference Number For Name Change Process (Start)////////////////////////////
          $namechg_rws                  = $this->Vessel_change_model->get_namechg_rws();
          $cnt_rws                      = count($namechg_rws);
          if($cnt_rws==0){
            $value                      = "1";
          } elseif ($cnt_rws>0) {
            $namechg_last_refno         = $this->Vessel_change_model->get_namechange_ref_number();
            foreach ($namechg_last_refno as $ref_res) {
              $ref_no                   = $ref_res['ref_number'];
            }
            $ref_exp                    = explode('_', $ref_no);
            $ref_val                    = $ref_exp[1];
            $value                      = $ref_val + 1;
          }
          if($value<10){
            $value                      = "00".$value;
          } elseif ($value<100) {
            $value                      = "0".$value;
          } else {
            $value                      = $value;
          }
          $yr                           = date('Y');
          $ref_number                   = "NC"."_".$value."_".$vessel_id.$yr; 
          //////////////////////Reference Number For Name Change Process (End)////////////////////////////
          $namedet=array(
          'change_vessel_id'            => $vessel_id,
          'change_name'                 => $newvesselname,
          'ref_number'                  => $ref_number,
          'change_vessel_main_id'       => $vesselmain_sl,
          'change_req_date'             => $newDate,
          'payment_status'              => 0,
          'change_status'               => 1
          );//print_r($namedet); exit;

          $insertNameDet                = $this->security->xss_clean($namedet);         
          $insertNameDet_res            = $this->db->insert('tbl_namechange', $insertNameDet);
          if($insertNameDet_res){
          ///insert to tbl_kiv_reference_number
            $data_ref_number= array(
            'vessel_id' =>$vessel_id ,
            'process_id'=>6,///Kiv_survey_master=>namechange=6
            'ref_number'=>$ref_number,
            'ref_number_status'=>1,
            'ref_number_created_user_id'=>$sess_usr_id,
            'ref_number_created_timestamp'=>$date,
            'ref_number_created_ipaddress'=>$ip);
            $result_ref_number=$this->db->insert('tbl_kiv_reference_number', $data_ref_number);

          } 
            
      } 
      $data                             = $data + $this->data;

      /*$this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/payment_details_form11',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');*/

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/payment_details_form11', $data);
      $this->load->view('Kiv_views/template/dash-footer.php');

    //}

  } 
  else
  {
    redirect('Main_login/index');        
  }

} 

public function pay_now_form11()
{

 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                        = $this->session->userdata('customer_id');
  $survey_user_id                     = $this->session->userdata('survey_user_id');


  $vessel_id1                         = $this->uri->segment(4);
  $processflow_sl1                    = $this->uri->segment(5);
  $status_details_sl1                 = $this->uri->segment(6);

  $vessel_id                          = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                          = $this->encrypt->decode($vessel_id); 

  $processflow_sl                     = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                     = $this->encrypt->decode($processflow_sl); 

  $status_details_sl                  = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl                  = $this->encrypt->decode($status_details_sl); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'pay_now_form11', 'page' => 'pay_now_form11', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Bookofregistration_model');
    $this->load->model('Kiv_models/Vessel_change_model');

    date_default_timezone_set("Asia/Kolkata");
    $date                             = date('Y-m-d h:i:s', time());
    $ip                               = $_SERVER['REMOTE_ADDR'];
    $newDate                          = date("Y-m-d");
    $vessel_id                        = $this->security->xss_clean($this->input->post('vessel_sl'));
    $processflow_sl                   = $this->security->xss_clean($this->input->post('processflow_sl'));
    $status_details_sl                = $this->security->xss_clean($this->input->post('status_details_sl'));

    $process_id                       = $this->security->xss_clean($this->input->post('process_id')); 
    $current_status_id                = $this->security->xss_clean($this->input->post('current_status_id'));
    $current_position                 = $this->security->xss_clean($this->input->post('current_position')); 
    $status_change_date               = $date;
    $survey_id                        = 0;
     
    $user_id                          = $this->security->xss_clean($this->input->post('user_id'));
    $status                           = 1;
    
    /*$paymenttype_id                   = 4;
    $dd_amount                        = $this->security->xss_clean($this->input->post('dd_amount'));
    $portofregistry_sl                = $this->security->xss_clean($this->input->post('portofregistry_sl'));*/
        
    $form_number_cs                   = $this->Vessel_change_model->get_form_number_cs($process_id);
    $data['form_number_cs']           = $form_number_cs;
    if(!empty($form_number_cs))
    {
      $formnumber                     = $form_number_cs[0]['form_no'];
    }
    $vessel_main                      = $this->Vessel_change_model->get_vessel_main($vessel_id);
    $data['vessel_main']              = $vessel_main;
    if(!empty($vessel_main))
    {
      $vesselmain_sl                  = $vessel_main[0]['vesselmain_sl'];
    }
   
    /*$data_payment=array(
      'vessel_id'                 =>$vessel_id,
      'survey_id'                 =>$survey_id,
      'form_number'               =>$formnumber,
      'paymenttype_id'            =>$paymenttype_id,
      'dd_amount'                 =>$dd_amount,
      'dd_date'                   =>$newDate,
      'portofregistry_id'         =>$portofregistry_sl,
      'payment_created_user_id'   =>$sess_usr_id,
      'payment_created_timestamp' =>$date,
      'payment_created_ipaddress' =>$ip
    );

      //print_r($data_payment);exit;


    $result_insert    = $this->db->insert('tbl_kiv_payment_details', $data_payment); 
    $task_pfid        = $this->Survey_model->get_task_pfid($processflow_sl);
    $data['task_pfid']= $task_pfid;
    @$task_sl         = $task_pfid[0]['task_sl'];



    $port_registry_user_id           =   $this->Vessel_change_model->get_port_registry_user_id($portofregistry_sl);
    $data['port_registry_user_id']   =   $port_registry_user_id;
    if(!empty($port_registry_user_id))
    {
      $pc_user_id     = $port_registry_user_id[0]['user_sl'];
      $pc_usertype_id = $port_registry_user_id[0]['user_type_id'];
    }
      
    if($process_id==38)
    {
      /////process flow start indication---- tb_vessel_main processing_status to be changed as 1
      $data_mainupdate  = array('processing_status'=>1);
      ///tbl_name_change payment status
      $data_namechgupdate  = array(
        'payment_status'      => 1, 
        'change_payment_date' => $newDate
      );
      /////insert to processflow table showing curre
      $data_insert=array(
        'vessel_id'         => $vessel_id,
        'process_id'        => $process_id,
        'survey_id'         => $survey_id,
        'current_status_id' => 2,
        'current_position'  => $pc_usertype_id,
        'user_id'           => $pc_user_id,
        'previous_module_id'=> $processflow_sl,
        'status'            => $status,
        'status_change_date'=> $status_change_date
      ); 

      //////update current process status=0
      $data_update = array('status'=>0);
      //////update status details table
      $data_survey_status=array(
        'survey_id'        => $survey_id,
        'process_id'       => $process_id,
        'current_status_id'=> 2,
        'sending_user_id'  => $sess_usr_id,
        'receiving_user_id'=> $pc_user_id
      );//print_r($data_survey_status);exit;


        $vesselmain_update=$this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
        $namechg_update=$this->Vessel_change_model->update_namechg('tbl_namechange',$data_namechgupdate, $vessel_id);
        $process_update=$this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        

        $status_update=$this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        if($vesselmain_update && $namechg_update && $process_update && $process_insert && $status_update && $result_insert)
        {
          redirect("Kiv_Ctrl/Survey/SurveyHome");
        }
     }*/
    //____________________________________________________START ONLINE TRANSACTION__________________________________//

    /*_____________________Start Get vessel condition_______________ */   

    $vessel_condition                 = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition']         = $vessel_condition;
   
    if(!empty($vessel_condition))
    {
      $vessel_type_id                 = $vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id              = $vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1                 = $vessel_condition[0]['vessel_length'];
      $hullmaterial_id                = $vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id            = $vessel_condition[0]['engine_placement_id'];
    }  
    /*_____________________End Get vessel condition___________________*/

    /*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
    $form_id                          = 11;
    $activity_id                      = 6;

    $tariff_details                   = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data1['tariff_details']          = $tariff_details; 
    if (!empty($tariff_details)) 
    {
      $tariff_amount1                 = $tariff_details[0]['tariff_amount'];
      $tariff_min_amount              = $tariff_details[0]['tariff_min_amount'];
    }
      
    $tonnage_details                  = $this->Vessel_change_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']         = $tonnage_details;//print_r($tonnage_details);exit;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage          = $tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1                          = $vessel_total_tonnage*$tariff_amount1;

    if($amount1<100)
    {
      //$data['tariff_amount']          = $tariff_min_amount;
      $tariff_amount                  = 1;
    }
    else
    {
      //$data['tariff_amount']          = $amount1;
      $tariff_amount                  = 1;
    }
    /*_______________________________________________END Tariff____________________________ */   

    /*___________________________________________________________________________ */   
    if($this->input->post())
    { //print_r($_POST);
      //$dd_amount1           = $this->security->xss_clean($this->input->post('dd_amount'));
      $portofregistry_sl              = $this->security->xss_clean($this->input->post('portofregistry_sl'));
      $bank_sl                        = $this->security->xss_clean($this->input->post('bank_sl'));
      $vessel_sl                      = $this->security->xss_clean($this->input->post('vessel_sl'));
      $status                         = 1;

      $vessel_main                    = $this->Vessel_change_model->get_vessel_main($vessel_sl);
      $data['vessel_main']            = $vessel_main;
      if(!empty($vessel_main))
      {
        $vesselmain_sl                = $vessel_main[0]['vesselmain_sl'];
      }

      $vessel_condition               = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_id);
      $data['vessel_condition']       = $vessel_condition; 
     
      if(!empty($vessel_condition))
      {
        $vessel_type_id               = $vessel_condition[0]['vessel_type_id'];
        $vessel_subtype_id            = $vessel_condition[0]['vessel_subtype_id'];
        $vessel_length1               = $vessel_condition[0]['vessel_length'];
        $hullmaterial_id              = $vessel_condition[0]['hullmaterial_id'];
        $engine_placement_id          = $vessel_condition[0]['engine_placement_id'];
      }  
      /*_____________________End Get vessel condition___________________*/

      /*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
      $form_id                        = 11;
      $activity_id                    = 6;

      $tariff_details                 = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
      $data1['tariff_details']        = $tariff_details; 
      if (!empty($tariff_details)) 
      {
        $tariff_amount1               = $tariff_details[0]['tariff_amount'];
        $tariff_min_amount            = $tariff_details[0]['tariff_min_amount'];
      }
        
      $tonnage_details                = $this->Vessel_change_model->get_tonnage_details($vessel_id);
      $data1['tonnage_details']       = $tonnage_details;//print_r($tonnage_details);exit;
      if(!empty($tonnage_details))
      {
        @$vessel_total_tonnage        = $tonnage_details[0]['vessel_total_tonnage'];
      }
      $amount1                        = $vessel_total_tonnage*$tariff_amount1;

      if($amount1<100)
      {///for checking payment
        //$tariff_amount                  = $tariff_min_amount;
        $tariff_amount                = 1;
      }
      else
      {//for checking payment
        //$tariff_amount                  = $amount1;
        $tariff_amount                = 1;
      }

      $payment_user                   = $this->Vessel_change_model->get_payment_userdetails($sess_usr_id);
      $data['payment_user']           = $payment_user;
      //print_r($payment_user);exit;
      if(!empty($payment_user))
      {
        $owner_name                   = $payment_user[0]['user_name'];
        $user_mobile_number           = $payment_user[0]['user_mobile_number'];
        $user_email                   = $payment_user[0]['user_email'];
      }
      $formnumber                     = 11;
      $survey_id                      = 0;

      date_default_timezone_set("Asia/Kolkata");
      $ip                             = $_SERVER['REMOTE_ADDR'];
      $date                           = date('Y-m-d h:i:s', time());
      $newDate                        = date("Y-m-d");
      $status_change_date             = $date;


      $milliseconds                   = round(microtime(true) * 1000); //Generate unique bank number

      $bank_gen_number                = $this->Survey_model->get_bank_generated_last_number($bank_sl);
      $data['bank_gen_number']        = $bank_gen_number;

      if(!empty($bank_gen_number))
      {
        $bank_generated_number        = $bank_gen_number[0]['last_generated_no']+1;

        $transaction_id               = $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds.$bank_generated_number;
        $tocken_number                = $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds;

        $bank_data                    = array('last_generated_no'=>$bank_generated_number);//print_r($bank_data);exit;

        $data_payment_request=array(
          'transaction_id'            => $transaction_id,
          'bank_ref_no'               => 0,
          'token_no'                  => $tocken_number,
          'vessel_id'                 => $vessel_id,
          'survey_id'                 => $survey_id,
          'form_number'               => $formnumber,
          'customer_registration_id'  => $sess_usr_id,
          'customer_name'             => $owner_name,
          'mobile_no'                 => $user_mobile_number,
          'email_id'                  => $user_email,
          'transaction_amount'        => $tariff_amount,
          'remitted_amount'           => 0,
          'bank_id'                   => $bank_sl,
          'transaction_status'        => 0,
          'payment_status'            => 0,
          'transaction_timestamp'     => $date,
          'transaction_ipaddress'     => $ip,
          'port_id'                   => $portofregistry_sl
        ); //print_r($data_payment_request);exit;


        $result_insert=$this->db->insert('kiv_bank_transaction_request', $data_payment_request); 
        if($result_insert)
        {
          //echo "hii"; exit;
          $bank_transaction_id        = $this->db->insert_id();
          $update_bank                = $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);

        //-------get Working key-----------//
          $online_payment_data        = $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
          $data['online_payment_data']= $online_payment_data; //print_r($online_payment_data);exit;

        //------------------owner details-------------------//

          $payment_user1              = $this->Survey_model->get_payment_userdetails($sess_usr_id);
          $data['payment_user1']      = $payment_user1;



          $requested_transaction_details= $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
          $data['requested_transaction_details']  =   $requested_transaction_details;

          $data['amount_tobe_pay']    = $tariff_amount;
          $data                       = $data+ $this->data;
         //print_r($data);
         //exit;
          ///Actual Data --- Commented for testing(start)//////
          /*if(!empty($online_payment_data))
          { 
             
            $this->load->view('Kiv_views/Hdfc/hdfc_namechgonlinepayment_request',$data);
             
          }
          else
          {
              
              
            redirect('Kiv_Ctrl/Survey/SurveyHome');
          
          }*/
          ///Actual Data --- Commented for testing(end)//////
          if(!empty($online_payment_data))
          { 
             
            //$this->load->view('Kiv_views/Hdfc/hdfc_namechgonlinepayment_request',$data);
            date_default_timezone_set("Asia/Kolkata");
            $ip                   = $_SERVER['REMOTE_ADDR'];
            $date                 =   date('Y-m-d h:i:s', time());
            $newDate              =   date("Y-m-d");

            $vessel_main                    = $this->Vessel_change_model->get_vessel_main($vessel_id);
            $data['vessel_main']            = $vessel_main; 
            if(!empty($vessel_main))
            {
              $vesselmain_sl                = $vessel_main[0]['vesselmain_sl'];
            }

            $status_details             =   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
            $data['status_details']     =   $status_details;
            if(!empty($status_details))
            {
              $status_details_sl        =   $status_details[0]['status_details_sl'];
            }
            $processflow_vessel           =   $this->Survey_model->get_processflow_vessel($vessel_id);
            $data['processflow_vessel']   =   $processflow_vessel;
            if(!empty($processflow_vessel))
            {
              $processflow_sl           =   $processflow_vessel[0]['processflow_sl'];
              $process_id         =   $processflow_vessel[0]['process_id'];
            }

            /*$data_portofregistry=array(
            'vessel_registry_port_id'     => $portofregistry_sl
            );
            $update_portofregistry        = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);*/

            $port_registry_user_id          =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
            $data['port_registry_user_id']  =   $port_registry_user_id;
            if(!empty($port_registry_user_id))
            {
              $pc_user_id           = $port_registry_user_id[0]['user_master_id'];
              $pc_usertype_id         = $port_registry_user_id[0]['user_master_id_user_type'];
            }

            $data_payment=array(
            'vessel_id'         =>  $vessel_id,
            'survey_id'         =>  6,
            'form_number'         =>  $formnumber,
            'paymenttype_id'        =>  4,
            'dd_amount'         =>  $tariff_amount,
            'dd_date'           =>  $newDate,
            'portofregistry_id'     =>  $portofregistry_sl,
            'bank_id'           =>  $bank_sl,
            'payment_mode'        =>  'Credit Card',
            'transaction_id'        =>  $bank_transaction_id,
            'payment_created_user_id'   =>  $sess_usr_id,
            'payment_created_timestamp' =>  $date,
            'payment_created_ipaddress' =>  $ip);

            /*if($process_id==38)
            {*/
            /////process flow start indication---- tb_vessel_main processing_status to be changed as 1
            $data_mainupdate=array(
            'processing_status'     =>  1);
            ///tbl_name_change payment status
            $data_namechgupdate=array(
            'payment_status'          =>  1, 
            'change_payment_date'     =>  $newDate);
            /////insert to processflow table showing curre
            $data_insert=array(
            'vessel_id'             =>  $vessel_id,
            'process_id'            =>  38,
            'survey_id'             =>  $survey_id,
            'current_status_id'     =>  2,
            'current_position'      =>  $pc_usertype_id,
            'user_id'               =>  $pc_user_id,
            'previous_module_id'    =>  $processflow_sl,
            'status'                =>  1,
            'status_change_date'    =>  $date); 

              //////update current process status=0
            $data_update=array('status' =>  0);

            //////update status details table
            $data_survey_status=array(
            'survey_id'             =>  $survey_id,
            'process_id'            =>  38,
            'current_status_id'     =>  2,
            'sending_user_id'       =>  $sess_usr_id,
            'receiving_user_id'     =>  $pc_user_id); 

            if($tariff_amount>0 && $portofregistry_sl!=false)
            { 
              //echo "Amt".$amount."---Port".$portofregistry_sl."---Vesmain".$vesselmain_sl."---Vesid".$vessel_id."---Proce".$processflow_sl."---Stat".$status_details_sl;exit;
              $result_insert        = $this->db->insert('tbl_kiv_payment_details', $data_payment);
              $vesselmain_update      = $this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
              $namechg_update         = $this->Vessel_change_model->update_namechg('tbl_namechange',$data_namechgupdate, $vessel_id);
              $process_update       = $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
              $process_insert       = $this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
              $status_update        = $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
              //}
              if($vesselmain_update && $namechg_update && $process_update && $process_insert && $status_update && $result_insert)
              {
                ///get user mail////
                $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($pc_user_id);
                if(!empty($user_mail_id))
                {
                  foreach($user_mail_id as $mail_res)
                  {
                    $user_mail    = $mail_res['user_email'];
                    $user_name    = $mail_res['user_name'];
                    $user_mob     = $mail_res['user_mobile_number'];
                  }
                }
                $nam_refno       =   $this->Vessel_change_model->get_vesselnamechange_details_ra($vessel_id); //print_r($nam_refno);exit;
                if(!empty($nam_refno))
                {
                  foreach($nam_refno as $nam_res)
                  {
                    $refno        = $nam_res['ref_number'];
                    $main_id        = $nam_res['vesselmain_sl'];
                    $reg_no       = $nam_res['vesselmain_reg_number'];
                    $vessel       = $nam_res['vesselmain_vessel_name'];
                  } 
                }
                $portna       =   $this->Vessel_change_model->get_registry_port_id($portofregistry_sl);
                foreach($portna as $port_res){
                  $port_name  = $port_res['vchr_portoffice_name'];
                }

                $name_log     =  $this->Vessel_change_model->name_change_det($vessel_id,$main_id);
                foreach($name_log as $name_res){
                  $new_name  = $name_res['change_name'];
                } 
                /*------------code for send email starts---------------*/
                $config = Array(
                'protocol'        => 'smtp',
                'smtp_host'       => 'ssl://smtp.googlemail.com',
                'smtp_port'       => 465,
                'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
                'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
                'mailtype'        => 'html',
                'charset'         => 'iso-8859-1');//print_r($config);exit;

                $message = 'Dear '.$user_name.',<br/><br/>

                Payment of Rs. '.$tariff_amount.' for your vessel, '.$reg_no.' ( '.$vessel.' ) for Name Change has been received.  Name Change from <strong>'.$vessel.'</strong> to <strong>'.$new_name.'</strong> is in process. <br/><br/>

                Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

                Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

                For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

                Warm Regards<br/><br/>

                Kerala Maritime Board ';
                $smsmsg = 'Payment of Rs. '.$tariff_amount.' for '.$reg_no.' is received, and forwarded to'. $port_name.' Port Conservator. Reference Number:  '.$refno.'.';
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('kivportinfo@gmail.com'); // change it to yours
                //$this->email->to($user_mail);// change it to yours
                $this->email->to('deepthi.nh@gmail.com');

                $this->email->subject('Payment of Rs. '.$tariff_amount.' has been received for Name Change-reg.');
                $this->email->message($message);
                if($this->email->send())
                { 
                  redirect('Kiv_Ctrl/VesselChange/nameChange_list');
                  //echo "success";redirect("Bookofregistration/raHome");
                  // <!------------code for send SMS starts--------------->
                  $this->load->model('Kiv_models/Vessel_change_model');
                  $mobil="9809119144";
                  $stat = $this->Vessel_change_model->sendSms($smsmsg,$mobil);
                  //print_r($stat);exit;
                  //echo json_encode("success");
                  //redirect("Bookofregistration/raHome");
                  /*------------code for send SMS ends---------------*/
                }
                else
                {
                  show_error($this->email->print_debugger());
                } 
              }
            }
             
          }
          else
          {
              
              
            redirect('Kiv_Ctrl/Survey/SurveyHome');
          
          }

        
        }
        else
        {
        /* echo '<script language="javascript">';
            echo 'alert(Please try after some time!)'; 
            echo '</script>';*/
          redirect('Kiv_Ctrl/Survey/SurveyHome');
        }

      }
      else
      {
        redirect('Kiv_Ctrl/Survey/SurveyHome');
      }
    } 
//____________________________________________________END ONLINE TRANSACTION__________________________________//
  }
}
function showpayment($vessel_id)
{ 
    /*$vessel_sl                            = $this->session->userdata('vessel_id');
    if($vessel_sl=="")
    {
      $vessel_id                          = $this->security->xss_clean($this->input->post('vessel_id'));
    }
    else
    {
      $vessel_id                          = $vessel_sl;
    }
  echo $vessel_id;*/
    $vessel_condition                 = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition']         = $vessel_condition;
    //print_r($vessel_condition);
    if(!empty($vessel_condition))
    {
      $vessel_type_id                 = $vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id              = $vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1                 = $vessel_condition[0]['vessel_length'];
      $hullmaterial_id                = $vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id            = $vessel_condition[0]['engine_placement_id'];
    }

    $form_id                          = 11;
    $activity_id                      = 6;

    $tariff_details                   = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data1['tariff_details']          = $tariff_details; 
    if (!empty($tariff_details)) 
    {
      $tariff_amount1                 = $tariff_details[0]['tariff_amount'];
      $tariff_min_amount              = $tariff_details[0]['tariff_min_amount'];
    }
      
    $tonnage_details                  = $this->Vessel_change_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']         = $tonnage_details;//print_r($tonnage_details);exit;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage          = $tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1                          = $vessel_total_tonnage*$tariff_amount1;

    if($amount1<100)
    {
      //$data1['tariff_amount']              = $tariff_min_amount;
      $data1['tariff_amount']         = 1;
    }
    else
    {
      //$data1['tariff_amount']              = $amount1;
      $data1['tariff_amount']         = 1;
    }
 
    $this->load->view('Kiv_views/Ajax_payment_show.php',$data1);
}

function not_payment_details_form11()
{ //print_r($_POST);exit;
  $vessel_id                           =  $this->session->userdata('vessel_id');
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                         =  $this->session->userdata('customer_id');
  $survey_user_id                      =  $this->session->userdata('survey_user_id');


  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
$this->load->model('Kiv_models/Survey_model');
    date_default_timezone_set("Asia/Kolkata");
    $date                              =  date('Y-m-d h:i:s', time());

    $vessel_id                         =  $this->security->xss_clean($this->input->post('vessel_sl'));  
    $process_id                        =  $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id                         =  0;
    $current_status_id                 =  $this->security->xss_clean($this->input->post('current_status_id'));
    $current_position                  =  $this->security->xss_clean($this->input->post('current_position')); 
    $status_change_date                =  $date;
    $processflow_sl                    =  $this->security->xss_clean($this->input->post('processflow_sl'));
    $user_id                           =  $this->security->xss_clean($this->input->post('user_id'));
    $status                            =  1;
    $status_details_sl                 =  $this->security->xss_clean($this->input->post('status_details_sl'));
    $ip                                =  $_SERVER['REMOTE_ADDR'];
    
    $data_update=array(
      'status'=>0
    );
    $process_update                    =  $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);

    $data_process=array(
      'vessel_id'                      => $vessel_id,
      'process_id'                     => $process_id,
      'survey_id'                      => $survey_id,
      'current_status_id'              => 8,
      'current_position'               => $user_type_id,
      'user_id'                        => $sess_usr_id,
      'previous_module_id'             => $processflow_sl,
      'status'                         => $status,
      'status_change_date'             => $status_change_date
    ); //print_r($data_process);exit;

    $data_status=array(
      'vessel_id'                      => $vessel_id,
      'process_id'                     => $process_id,
      'survey_id'                      => $survey_id,
      'current_status_id'              => 8,
      'sending_user_id'                => $sess_usr_id,
      'receiving_user_id'              => $sess_usr_id,
    );//print_r($data_status);exit;

    $status_update                     =  $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_status,$status_details_sl);
    $insert_process                    =  $this->Vessel_change_model->insert_process_flow($data_process);
  
              
    if($insert_process && $status_update && $process_update)  
    {
      redirect('Kiv_Ctrl/Survey/SurveyHome');
    }       
            
  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function namechange_req_list()
{

  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                          = $this->session->userdata('customer_id');
  $survey_user_id                       = $this->session->userdata('survey_user_id');


  if(!empty($sess_usr_id) && (($user_type_id==14) || ($user_type_id==11) ))
  {
    $data       =  array('title' => 'namechange_req_list', 'page' => 'namechange_req_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Bookofregistration_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    if($user_type_id==14){
      $namechange_det                   = $this->Vessel_change_model->get_vesselnamechange_details_ra_vw($sess_usr_id);
    }else {
      $namechange_det                   = $this->Vessel_change_model->get_vesselnamechange_details($sess_usr_id);
    }
    $data['namechange_det']             = $namechange_det; //print_r($namechange_det);exit;
    
    $data                               = $data + $this->data;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/namechange_req_list',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');

  } 
  else
  {
    redirect('Main_login/index');        
  }

} 
public function Verify_payment_pc_form11()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                          = $this->session->userdata('customer_id');
  $survey_user_id                       = $this->session->userdata('survey_user_id');


  $vessel_id1                           = $this->uri->segment(4);
  $processflow_sl1                      = $this->uri->segment(5);
  $survey_id1                           = $this->uri->segment(6);

  $vessel_id                            = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                            = $this->encrypt->decode($vessel_id); 

  $processflow_sl                       = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                       = $this->encrypt->decode($processflow_sl); 

  $survey_id                            = str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
   $survey_id                            = $this->encrypt->decode($survey_id); 


  if(!empty($sess_usr_id) && ($user_type_id==3))
  {
    $data   =  array('title' => 'Verify_payment_pc_form11', 'page' => 'Verify_payment_pc_form11', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $vessel_details                     = $this->Vessel_change_model->get_process_flow($processflow_sl);
    $data['vessel_details']             = $vessel_details;
    @$id                                = $vessel_details[0]['user_id'];

    $customer_details                   = $this->Vessel_change_model->get_customer_details($id);
    $data['customer_details']           = $customer_details;

    $current_status                     = $this->Vessel_change_model->get_status();
    $data['current_status']             = $current_status;

    $form_number                        = $this->Vessel_change_model->get_form_number($vessel_id);
    $data['form_number']                = $form_number;
    $form_id                            = $form_number[0]['form_no'];


    //----------Vessel Details--------//

    $vessel_details_viewpage            = $this->Vessel_change_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']    = $vessel_details_viewpage;

    //----------Payment Details--------//

    $payment_details                    = $this->Vessel_change_model->get_form_payment_details($vessel_id,6,$form_id);
    $data['payment_details']            = $payment_details;
    //print_r($payment_details);
    if($this->input->post())
    { //print_r($_POST);exit;

      date_default_timezone_set("Asia/Kolkata");
      $date                             = date('Y-m-d h:i:s', time());
      $vessel_id                        = $this->security->xss_clean($this->input->post('vessel_id'));  
      $process_id                       = $this->security->xss_clean($this->input->post('process_id')); 
      $survey_id                        = $this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id                = $this->security->xss_clean($this->input->post('current_status_id'));;
      $current_position                 = $this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date               = $date;
      $processflow_sl                   = $this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id                          = $this->security->xss_clean($this->input->post('user_id'));
      $user_sl_cs_sr                    = $this->security->xss_clean($this->input->post('user_sl_cs'));
      $status                           = 1;

      $status_details_sl1               = $this->security->xss_clean($this->input->post('status_details_sl'));
      $payment_sl                       = $this->security->xss_clean($this->input->post('payment_sl'));
      $payment_approved_remarks         = $this->security->xss_clean($this->input->post('remarks'));

      $date                             = date('Y-m-d h:i:s', time());
      $ip                               = $_SERVER['REMOTE_ADDR'];
      $status_change_date               = $date;

      $usertype                         = $this->Survey_model->get_user_id_cs(14);
      $data['usertype']                 = $usertype;
      if(!empty($usertype))
      {
        $user_sl_ra                     = $usertype[0]['user_master_id'];
        $user_type_id_ra                = $usertype[0]['user_master_id_user_type'];
      }

      if($process_id==38)
      {

        $data_payment=array(
          'payment_approved_status'     => 1,
          'payment_approved_user_id'    => $sess_usr_id,
          'payment_approved_datetime'   => $status_change_date,
          'payment_approved_ipaddress'  => $ip,
          'payment_approved_remarks'    => $payment_approved_remarks
        ); 

        $data_namechange=array(
          'change_pc_verified_date'     => $status_change_date,
          'change_verify_id'            => $sess_usr_id
        ); 

        $data_insert=array(
        'vessel_id'                     => $vessel_id,
        'process_id'                    => $process_id,
        'survey_id'                     => $survey_id,
        'current_status_id'             => 2,
        'current_position'              => $user_type_id_ra,
        'user_id'                       => $user_sl_ra,
        'previous_module_id'            => $processflow_sl,
        'status'                        => $status,
        'status_change_date'            => $status_change_date
        );//print_r($data_insert);exit;

        $data_update=array(
          'status'                      => 0
        );

        $data_survey_status=array(
        'current_status_id'             => 2,
        'sending_user_id'               => $sess_usr_id,
        'receiving_user_id'             => $user_sl_ra
        );//echo $status_details_sl1;
        //print_r($data_survey_status);
        //exit;


        $payment_update    = $this->Vessel_change_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);
        $namechange_update = $this->Vessel_change_model->update_namechange('tbl_namechange',$data_namechange, $vessel_id);

        $process_update    = $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert    = $this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);

        $status_update     = $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl1);

        if($payment_update && $namechange_update && $process_update && $process_insert && $status_update)
        {
          //redirect("Kiv_Ctrl/Survey/pcHome");
          
         ///get user mail////
            $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($user_sl_ra);
            if(!empty($user_mail_id))
            {
              foreach($user_mail_id as $mail_res){
                $user_mail    = $mail_res['user_email'];
                $user_name    = $mail_res['user_name'];
                $user_mob     = $mail_res['user_mobile_number'];
              }
            }
            $user_owner_det          =   $this->Vessel_change_model->get_customer_details($user_id_owner); //print_r($user_owner_det);exit;
            if(!empty($user_owner_det))
            {
              foreach($user_owner_det as $own_res){
               // $user_mail    = $mail_res['user_email'];
                $own_name    = $own_res['user_master_fullname'];
                //$user_mob     = $mail_res['user_mobile_number'];
              }
            }
           
            $nam_refno       =   $this->Vessel_change_model->get_vesselnamechange_details_ra($vessel_id); //print_r($nam_refno);exit;
                if(!empty($nam_refno))
                {
                  foreach($nam_refno as $nam_res)
                  {
                    $refno        = $nam_res['ref_number'];
                    $main_id        = $nam_res['vesselmain_sl'];
                    $reg_no       = $nam_res['vesselmain_reg_number'];
                    $vessel       = $nam_res['vesselmain_vessel_name'];
                    $portofregistry_sl       = $nam_res['vesselmain_portofregistry_id'];
                  } 
                }
                $portna       =   $this->Vessel_change_model->get_registry_port_id($portofregistry_sl);
                foreach($portna as $port_res){
                  $port_name  = $port_res['vchr_portoffice_name'];
                }

                $name_log     =  $this->Vessel_change_model->name_change_details($vessel_id,$main_id);
                foreach($name_log as $name_res){
                  $new_name  = $name_res['change_name'];
                } 

                $payment     =  $this->Vessel_change_model->get_payment_details($payment_sl,$vessel_id);
                foreach($payment as $pay_res){
                  $amount  = $pay_res['dd_amount'];
                }
            
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
           $message = 'Dear '.$own_name.',<br/><br/>

                Payment of Rs. '.$amount.' for your vessel, '.$reg_no.' ( '.$vessel.' ) for Name Change has been verified by '.$port_name.' Port Conservator.  Name Change from <strong>'.$vessel.'</strong> to <strong>'.$new_name.'</strong> is processed by Registering Authority. <br/><br/>

                Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

                Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

                For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

                Warm Regards<br/><br/>

                Kerala Maritime Board ';
                $smsmsg = 'Payment of Rs. '.$amount.' for '.$reg_no.' is verified and forwarded to Registering Authority. Reference Number:  '.$refno;           
            
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('kivportinfo@gmail.com'); // change it to yours
            //$this->email->to($user_mail);// change it to yours
            $this->email->to('deepthi.nh@gmail.com');

            $this->email->subject('Payment of Rs. '.$amount.' has been verified by '.$port_name.' PC  for Name change-reg.');
            $this->email->message($message);
            if($this->email->send())
            { //echo "success";redirect("Kiv_Ctrl/Bookofregistration/raHome");
            // <!------------code for send SMS starts--------------->
              $this->load->model('Kiv_models/Vessel_change_model');
              //$mobil="9809119144";
              $mobil=$user_mob;
              //$stat = $this->Vessel_change_model->sendSms($smsmsg,$mobil);
              $moduleid        = 2;
              $modenc          = $this->encrypt->encode($moduleid); 
              $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
              redirect("Kiv_Ctrl/Survey/pcHome/".$modidenc);
              //print_r($stat);exit;
              //echo json_encode("success");
              //redirect("Kiv_Ctrl/Bookofregistration/raHome");
              
              /*------------code for send SMS ends---------------*/
            }
            else
            {
              show_error($this->email->print_debugger());
            } 

         
        }
      }
    }

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_payment_pc_form11',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
public function view_form11()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                          = $this->session->userdata('customer_id');
  $survey_user_id                       = $this->session->userdata('survey_user_id');

  $vessel_id1                           = $this->uri->segment(4);
  $processflow_sl1                      = $this->uri->segment(5);
  $status_details_sl1                   = $this->uri->segment(6);

  $vessel_id                            = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                            = $this->encrypt->decode($vessel_id); 

  $processflow_sl                       = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                       = $this->encrypt->decode($processflow_sl); 

  $status_details_sl                    = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl                    = $this->encrypt->decode($status_details_sl); 
  $survey_id                            = 0;


  if(!empty($sess_usr_id) && ($user_type_id==14))
  {
    $data       =  array('title' => 'view_form11', 'page' => 'view_form11', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $initial_data                       = $this->Vessel_change_model->get_process_flow($processflow_sl);
    $data['initial_data']               = $initial_data;
    //print_r($initial_data);

    $intimation_type_id=2;

    $registration_intimation            = $this->Vessel_change_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']    = $registration_intimation;
    $vessel_change_det                  = $this->Vessel_change_model->get_vesselnamechange_details_ra($vessel_id);
    $data['vessel_change_det']          = $vessel_change_det;
    $payment_det                        = $this->Vessel_change_model->get_vesselnamechange_payment_ra($vessel_id);
    $data['payment_det']                = $payment_det;


    $stern_material                     = $this->Bookofregistration_model->get_stern_material();
    $data['stern_material']             = $stern_material;

    $plyingPort                         = $this->Bookofregistration_model->get_portofregistry();
    $data['plyingPort']                 = $plyingPort;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/view_form11',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
    
  }
  else
  {
    redirect('Main_login/index');
  }
  
}
function namechange_intimation_send()
{ //print_r($_POST);exit;
 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                          = $this->session->userdata('customer_id');
  $survey_user_id                       = $this->session->userdata('survey_user_id');


  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'namechange_intimation_send', 'page' => 'namechange_intimation_send', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');


  $vessel_id1                           = $this->uri->segment(4);
  $processflow_sl1                      = $this->uri->segment(5);
  $status_details_sl1                   = $this->uri->segment(6);

  $vessel_id                            = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                            = $this->encrypt->decode($vessel_id); 

  $processflow_sl                       = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                       = $this->encrypt->decode($processflow_sl); 

  $status_details_sl                    = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl                    = $this->encrypt->decode($status_details_sl); 
  $survey_id=0;
  if($this->input->post())
  { //print_r($_POST); //print_r($_FILES);//exit;
    date_default_timezone_set("Asia/Kolkata");
    $date                               = date('Y-m-d h:i:s', time());
    $status_change_date                 = $date;
    $remarks_date                       = date('Y-m-d');
    $ip                                 = $_SERVER['REMOTE_ADDR'];
   //print_r($_FILES);

    $vessel_id                          = $this->security->xss_clean($this->input->post('vessel_id'));  
    $process_id                         = $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id                          = $this->security->xss_clean($this->input->post('survey_id'));
    $processflow_sl                     = $this->security->xss_clean($this->input->post('processflow_sl'));
    $status_details_sl                  = $this->security->xss_clean($this->input->post('status_details_sl'));
    $current_position                   = $this->security->xss_clean($this->input->post('current_position'));
    $user_id                            = $this->security->xss_clean($this->input->post('user_sl_ra'));
    $registration_intimation_sl         = $this->security->xss_clean($this->input->post('registration_intimation_sl'));
    $user_id_owner                      = $this->security->xss_clean($this->input->post('user_id_owner'));
    $user_type_id_owner                 = $this->security->xss_clean($this->input->post('user_type_id_owner'));
    $current_status_id                  = $this->security->xss_clean($this->input->post('current_status_id'));
    $status                             = 1;

    $change_inspection_date             = $this->security->xss_clean($this->input->post('change_inspection_date'));
    $portofregistry_sl                  = $this->security->xss_clean($this->input->post('portofregistry_sl'));
    $change_intimation_remark           = $this->security->xss_clean($this->input->post('change_intimation_remark'));
    $change_inspection_report_upload    = $this->security->xss_clean($_FILES["change_inspection_report_upload"]["name"]);
    if($change_inspection_report_upload)
    {
      echo "uploaded";
      $ins_path_parts                   = pathinfo($_FILES["change_inspection_report_upload"]["name"]);
      $ins_extension                    = $ins_path_parts['extension'];

      echo $ins_file_name               = 'NAMECHG'.'_INSPRPT_Form11_'.$vessel_id.'_'.$date.'.'.$ins_extension;
      $target                           = "./uploads/NameChange_Intimation/".$ins_file_name;
      $ins_upd                          = move_uploaded_file($_FILES["change_inspection_report_upload"]["tmp_name"], $target);
    }
    else
    {
      echo "not";
    }
    $change_inspection                  = pathinfo($_FILES['change_inspection_report_upload']['name']);
    if($change_inspection)
    {
      $extension                        = $change_inspection['extension'];
    }
    else
    {
      $extension                        = "";
    }
    
      /*$pdf_name=$vessel_id.'_'.$intimation_sl.'_'.$survey_defects_sl.'_'.$random_number.'.'.$extension;
    copy($_FILES["defect_intimation"]["tmp_name"], "./uploads/defects/".$pdf_name);*/


    if($process_id==38)
    {
      $data_reg_intimation= array(
        'vessel_id'                                => $vessel_id,
        'registration_intimation_type_id'          => 2,
        'registration_intimation_place_id'         => $portofregistry_sl, 
        'registration_intimation_remark'           => $change_intimation_remark,
        'registration_inspection_report_upload'    => $ins_file_name,
        'registration_inspection_date'             => $change_inspection_date,
        'registration_inspection_status'           => 1,
        'registration_inspection_created_user_id'  => $user_id,
        'registration_inspection_created_timestamp'=> $date,
        'registration_inspection_created_ipaddress'=> $ip
      ); //print_r($data_reg_intimation);
      $insert_intimation                = $this->Survey_model->insert_doc('a5_tbl_registration_intimation', $data_reg_intimation);

      $intimation_data=array(
        'registration_inspection_status'            => 0
      );

      $data_insert=array(
        'vessel_id'                                 => $vessel_id,
        'process_id'                                => $process_id,
        'survey_id'                                 => $survey_id,
        'current_status_id'                         => 7,
        'current_position'                          => $current_position,
        'user_id'                                   => $sess_usr_id,
        'previous_module_id'                        => $processflow_sl,
        'status'                                    => $status,
        'status_change_date'                        => $status_change_date
      );//print_r($data_insert);


      $data_update=array(
        'status'=>0
      );

      $data_survey_status=array(
        'process_id'                                => $process_id,
        'survey_id'                                 => $survey_id,
        'current_status_id'                         => 7,
        'sending_user_id'                           => $sess_usr_id,
        'receiving_user_id'                         => $sess_usr_id
      );//print_r($data_survey_status);exit;


      $status_update      = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      $intimation_update  = $this->Survey_model->update_registration_intimation('a5_tbl_registration_intimation', $intimation_data,$registration_intimation_sl);

      $process_update     = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert     = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

      if($insert_intimation && $status_update && $process_update && $process_insert && $intimation_update)
      {
        //redirect("Kiv_Ctrl/Bookofregistration/raHome");
        ///get user mail////
            $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($user_id_owner);
            if(!empty($user_mail_id))
            {
              foreach($user_mail_id as $mail_res){
                $user_mail    = $mail_res['user_email'];
                $user_name    = $mail_res['user_name'];
                $user_mob     = $mail_res['user_mobile_number'];
              }
            }
            $user_owner_det          =   $this->Vessel_change_model->get_customer_details($user_id_owner); //print_r($user_owner_det);exit;
            if(!empty($user_owner_det))
            {
              foreach($user_owner_det as $own_res){
               // $user_mail    = $mail_res['user_email'];
                $own_name    = $own_res['user_master_fullname'];
                //$user_mob     = $mail_res['user_mobile_number'];
              }
            }
            $nam_refno       =   $this->Vessel_change_model->get_vesselnamechange_details_ra($vessel_id); //print_r($nam_refno);exit;
                if(!empty($nam_refno))
                {
                  foreach($nam_refno as $nam_res)
                  {
                    $refno        = $nam_res['ref_number'];
                    $main_id        = $nam_res['vesselmain_sl'];
                    $reg_no       = $nam_res['vesselmain_reg_number'];
                    $vessel       = $nam_res['vesselmain_vessel_name'];
                    $portofreg       = $nam_res['vesselmain_portofregistry_id'];
                  } 
                }
                $place =   $this->Vessel_change_model->get_registry_port_id($portofregistry_sl);
                foreach($place as $place_res){
                  $placeofvisit  = $place_res['vchr_portoffice_name'];
                }
                $portna       =   $this->Vessel_change_model->get_registry_port_id($portofreg);
                foreach($portna as $port_res){
                  $port_name  = $port_res['vchr_portoffice_name'];
                }

                $name_log     =  $this->Vessel_change_model->name_change_details($vessel_id,$main_id);
                foreach($name_log as $name_res){
                  $new_name  = $name_res['change_name'];
                } 

                $payment     =  $this->Vessel_change_model->get_payment_details($payment_sl,$vessel_id);
                foreach($payment as $pay_res){
                  $amount  = $pay_res['dd_amount'];
                }
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
            $change_inspection_date_exp  = explode('-',$change_inspection_date);
            $change_inspection_date_fnl  = $change_inspection_date_exp[2].'-'.$change_inspection_date_exp[1].'-'.$change_inspection_date_exp[0];
            $message = 'Dear '.$own_name.',<br/><br/>
              With respect to Name Change, Registering Authority will verify your request on '.$change_inspection_date_fnl.' at '.$placeofvisit.'. You are hereby requested to be present for the same. Any change in schedule will be intimated through your registered mobile number and email id. <br/><br/>

            Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

            Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

            For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

            Warm Regards<br/><br/>

            Kerala Maritime Board ';
                $smsmsg = 'Registering Authority will visit on '.$change_inspection_date_fnl.' at '.$placeofvisit.' for Name Change of '.$reg_no.'. Reference Number:  '.$refno;           
            
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('kivportinfo@gmail.com'); // change it to yours
            //$this->email->to($user_mail);// change it to yours
            $this->email->to('deepthi.nh@gmail.com');

            $this->email->subject('Intimation of visit by Registering Authority on '.$change_inspection_date_fnl.' at '.$placeofvisit.' for Name Change-reg.');
            $this->email->message($message);
            if($this->email->send())
            { //echo "success";redirect("Kiv_Ctrl/Bookofregistration/raHome");
            // <!------------code for send SMS starts--------------->
              $this->load->model('Kiv_models/Vessel_change_model');
              //$mobil="9809119144";
              $mobil=$user_mob;
              //$stat = $this->Vessel_change_model->sendSms($smsmsg,$mobil);
              redirect("Kiv_Ctrl/Bookofregistration/raHome");
              //print_r($stat);exit;
              //echo json_encode("success");
              //redirect("Kiv_Ctrl/Bookofregistration/raHome");
              
              /*------------code for send SMS ends---------------*/
            }
            else
            {
              show_error($this->email->print_debugger());
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
public function form11_certificate()
{

  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id) && (($user_type_id==11) || ($user_type_id==12) || ($user_type_id==13) || ($user_type_id==14)))
  {
  
  $this->load->model('Kiv_models/Vessel_change_model');
  $vessel_id1    = $this->uri->segment(4);

  $vessel_id     = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id     = $this->encrypt->decode($vessel_id); 
  
  //$this->load->view('Kiv_views/dash/form11_certificate_view',$data);
  $this->load->library('Pdf.php');
  $pdf =  $this->pdf->load();
  $pdf->allow_charset_conversion=true;  // Set by default to TRUE
  $pdf->charset_in='UTF-8';
  $pdf->autoLangToFont = true;

  $pdf->showImageErrors = true;
  ini_set('memory_limit', '256M');

  $pdfFilePath = "form11_certificate_".$vessel_id.".pdf";   
  $html = $this->load->view('Kiv_views/dash/form11_certificate_view',$vessel_id,true);
  $output=$pdf->WriteHTML($html);
  $pdf->Output($output.$pdfFilePath, 'D');
  exit(); 
}
 else
  {
    redirect('Main_login/index');
  }
}
public function view_form11_intimation()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                          = $this->session->userdata('customer_id');
  $survey_user_id                       = $this->session->userdata('survey_user_id');

  $vessel_id1                           = $this->uri->segment(4);
  
  $vessel_id                            = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                            = $this->encrypt->decode($vessel_id); 

 
  $survey_id                            = 0;
  $process_id                           = 38;
  $status                               = 1;

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'view_form11_intimation', 'page' => 'view_form11_intimation', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $initimat_data                      = $this->Vessel_change_model->get_namechange_intimation_det($vessel_id,$survey_id,$process_id,$status);
    $data['initimat_data']              = $initimat_data;
  //print_r($initimat_data);exit;
    $vessel_change_det                  = $this->Vessel_change_model->get_vesselnamechange_details_ra($vessel_id);
    $data['vessel_change_det']          = $vessel_change_det;
    $payment_det                        = $this->Vessel_change_model->get_vesselnamechange_payment_ra($vessel_id);
    $data['payment_det']                = $payment_det;
    
      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/view_form11_intimation',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
    
  }
  else
  {
    redirect('Main_login/index');
  }
  
}
function form14_form15_insertion()
{ //echo "hii";exit;
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                          = $this->session->userdata('customer_id');
  $survey_user_id                       = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  { 
    $data     = array('title' => 'form14_form15_insertion', 'page' => 'form14_form15_insertion', 'errorCls' => NULL, 'post' => $this->input->post());
    $data     = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $ip                                 = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date                               = date('Y-m-d h:i:s', time()); 
    $reg_date                           = date('Y-m-d');
    $status_change_date                 = $date;

    $survey_id                          = 0;
    $process_id                         = 38;
    $status                             = 1;

    $vessel_id                          = $this->security->xss_clean($this->input->post('vessel_id'));
    $old_vessel_name                    = $this->security->xss_clean($this->input->post('vessel_name'));
    $new_vessel_name                    = $this->security->xss_clean($this->input->post('change_name'));
    $registered_date1                   = $this->security->xss_clean($this->input->post('registered_date'));
    $registered_date                    = date("Y-m-d", strtotime($registered_date1));

    $approve_status                     = $this->security->xss_clean($this->input->post('approve_status'));

    $process_id                         = $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id                          = $this->security->xss_clean($this->input->post('survey_id'));
    $processflow_sl                     = $this->security->xss_clean($this->input->post('processflow_sl'));
    $status_details_sl                  = $this->security->xss_clean($this->input->post('status_details_sl'));
    $current_position                   = $this->security->xss_clean($this->input->post('current_position'));
    $user_id                            = $this->security->xss_clean($this->input->post('user_sl_ra'));
    $registration_intimation_sl         =  $this->security->xss_clean($this->input->post('registration_intimation_sl'));
    $user_id_owner                      = $this->security->xss_clean($this->input->post('user_id_owner'));
    $user_type_id_owner                 = $this->security->xss_clean($this->input->post('user_type_id_owner'));
    $current_status_id                  = $this->security->xss_clean($this->input->post('current_status_id'));

    $vessel_main                        =   $this->Vessel_change_model->get_vessel_main($vessel_id);
    $data['vessel_main']                =   $vessel_main;
    if(!empty($vessel_main))
    {
      $vesselmain_sl                    =   $vessel_main[0]['vesselmain_sl'];
    }
    //print_r($_POST);exit;
    if(!empty($approve_status)){
      if($approve_status==5){
        /////process flow start indication---- tb_vessel_main processing_status to be changed as 1
        //$data_mainupdatee  = array('processing_status'=>0);
        //////namechange_log table 
        $data_namechg_log=array(
          'vessel_id'                   => $vessel_id,
          'old_vessel_name'             => $old_vessel_name,
          'new_vessel_name'             => $new_vessel_name,
          'registered_date'             => $registered_date,
          'approved_date'               => $reg_date,
          'status'                      => 1
        );//print_r($data_namechg_log);exit;
        ///////namechange table
        $data_namechg=array(
          'change_approve_date'         => $reg_date,
          'change_approve_id'           => $sess_usr_id
        );//print_r($data_namechg);exit;
        ///////vesseldetails table
        $data_vesseldet=array(
          'vessel_name'                 => $new_vessel_name,
          'vessel_modified_ipaddress'   => $ip
        );//print_r($data_vesseldet);exit;
        ///////vesselmain table
        $data_vesselmain=array(
          'vesselmain_vessel_name'      => $new_vessel_name,
          'vesselmain_name_req'         => 1,
          'processing_status'           => 0
        );//print_r($data_vesselmain);exit;
        ///////processflow table
        $data_insert=array(
          'vessel_id'                   => $vessel_id,
          'process_id'                  => $process_id,
          'survey_id'                   => $survey_id,
          'current_status_id'           => $approve_status,
          'current_position'            => $user_type_id_owner,
          'user_id'                     => $user_id_owner,
          'previous_module_id'          => $processflow_sl,
          'status'                      => $status,
          'status_change_date'          => $status_change_date
        );//print_r($data_insert);exit;
        /////////processfloe previous flow status update
        $data_update=array(
          'status'                      => 0
        );
        //////////status details table
        $data_survey_status=array(
          'process_id'                  => $process_id,
          'survey_id'                   => $survey_id,
          'current_status_id'           => $approve_status,
          'sending_user_id'             => $sess_usr_id,
          'receiving_user_id'           => $user_id_owner
        );//print_r($data_survey_status);exit;
        ///log table check
        $check_namechangelog              = $this->Vessel_change_model->check_vessel($vessel_id);
        if(!empty($check_namechangelog))
        {
          $approved_date                  = $check_namechangelog[0]['approved_date'];
        }
        $count_rws                        = count($check_namechangelog); 
        if($count_rws>0){
          $data_log=array(
            'status'=>0
          );
          $log_update_status              = $this->Vessel_change_model->update_namelog_status('tbl_namechange_log',$data_log, $vessel_id);
          if($log_update_status){
            $data_namechgupd_log=array(
              'vessel_id'                 => $vessel_id,
              'old_vessel_name'           => $old_vessel_name,
              'new_vessel_name'           => $new_vessel_name,
              'registered_date'           => $approved_date,
              'approved_date'             => $reg_date,
              'status'                    => 1
            );
            $insertnamelog                = $this->security->xss_clean($data_namechgupd_log);         
            $insertnamelog_res            = $this->db->insert('tbl_namechange_log', $insertnamelog);
          }
        } else {
          $insertnamelog                  = $this->security->xss_clean($data_namechg_log);         
          $insertnamelog_res              = $this->db->insert('tbl_namechange_log', $insertnamelog);
        }
        ///vesselmain
         //$vesselmain_update=$this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdatee, $vesselmain_sl);
        ///namechange 
        $namechange_upd       = $this->Vessel_change_model->update_vessel_namechg('tbl_namechange',$data_namechg, $vessel_id, $vesselmain_sl);
        ///vessel details
        $vesseldet_upd        = $this->Vessel_change_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vesseldet, $vessel_id);
        ///vesselmain
        $vesselmain_upd       = $this->Vessel_change_model->update_tbl_vessel_main('tb_vessel_main',$data_vesselmain, $vessel_id, $vesselmain_sl);

        $status_update        = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $process_update       = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert       = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        if($insertnamelog_res && $namechange_upd && $vesseldet_upd && $vesselmain_upd && $status_update && $process_update && $process_insert)
         {
          echo "1";
         }
         else
         {
          echo "0";
         }
      } else { //echo $approve_status;exit;
        $data_namechg=array(
          'change_status'                 => 2
        );
         $data_vesselmain=array(
          'processing_status'             => 0
        );
        $data_insert=array(
          'vessel_id'                     => $vessel_id,
          'process_id'                    => $process_id,
          'survey_id'                     => $survey_id,
          'current_status_id'             => $approve_status,
          'current_position'              => $user_type_id_owner,
          'user_id'                       => $user_id_owner,
          'previous_module_id'            => $processflow_sl,
          'status'                        => $status,
          'status_change_date'            => $status_change_date
        );//print_r($data_insert);exit;
        /////////processfloe previous flow status update
        $data_update=array(
          'status'                        => 0
        );
        //////////status details table
        $data_survey_status=array(
          'process_id'                    => $process_id,
          'survey_id'                     => $survey_id,
          'current_status_id'             => $approve_status,
          'sending_user_id'               => $sess_usr_id,
          'receiving_user_id'             => $user_id_owner
        );
        $namechange_upd       = $this->Vessel_change_model->update_vessel_namechg('tbl_namechange',$data_namechg, $vessel_id, $vesselmain_sl);
        $vesselmain_upd       = $this->Vessel_change_model->update_tbl_vessel_main('tb_vessel_main',$data_vesselmain, $vessel_id, $vesselmain_sl);
        $status_update        = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $process_update       = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert       = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        if($namechange_upd && $vesselmain_upd && $status_update && $process_update && $process_insert)
        {
          echo "1";
        }
        else
        {
          echo "0";
        }
      }
    }
  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function generate_certificate()
{
 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                            = $this->session->userdata('customer_id');
  $survey_user_id                         = $this->session->userdata('survey_user_id');

  $vessel_id                              = $this->uri->segment(4);
  /*$processflow_sl   = $this->uri->segment(5);
  $status_details_sl= $this->uri->segment(6);*/

  

  if(!empty($sess_usr_id) && (($user_type_id==14) || ($user_type_id==11)))
  { 
    $data = array('title' => 'generate_certificate', 'page' => 'generate_certificate', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    

    $vessel_details_viewpage              = $this->Vessel_change_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']      = $vessel_details_viewpage;

    @$id                                  = $vessel_details_viewpage[0]['user_id'];
    
   //-----------Get customer name and address--------------//
    $customer_details                     = $this->Vessel_change_model->get_customer_details($id);
    $data['customer_details']             = $customer_details;

    /*$initial_data             = $this->Vessel_change_model->get_process_flow($processflow_sl);
    $data['initial_data']     = $initial_data;

    $intimation_type_id=2;

    $registration_intimation          = $this->Vessel_change_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']  = $registration_intimation;

    $survey_id=1;
     //----------Hull Details--------//
   
    $hull_details            = $this->Vessel_change_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']    = $hull_details;

   
   //----------Engine Details--------//
   
   $engine_details           = $this->Survey_model->get_engine_details($vessel_id,$survey_id);
   $data['engine_details']   = $engine_details;*/




    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/generate_certificate_namechg',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');

  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function form14_certificate()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                          = $this->session->userdata('customer_id');
  $survey_user_id                       = $this->session->userdata('survey_user_id');
   
  $vessel_id                            = $this->uri->segment(4);

  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'form14_certificate', 'page' => 'form14_certificate', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $ip                                 = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date                               = date('Y-m-d h:i:s', time()); 


    $vessel_details_viewpage            = $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']    = $vessel_details_viewpage;

    @$id                                = $vessel_details_viewpage[0]['user_id'];

    
   //-----------Get customer name and address--------------//
    $customer_details                   = $this->Survey_model->get_customer_details($id);
    $data['customer_details']           = $customer_details;
   
    $survey_id                          = 1;
     //----------Hull Details--------//
   
    $hull_details                       = $this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']               = $hull_details;

   
   //----------Engine Details--------//
   
    $engine_details                     = $this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']             = $engine_details;

    $pdfFilePath = "form14_certificate_".$vessel_id.".pdf";
    $html=$this->load->view('Kiv_views/dash/form14_certificate',$data,TRUE);

    $this->load->library('Pdf.php');
    $pdf =  $this->pdf->load();
    $pdf->allow_charset_conversion=true;  // Set by default to TRUE
    $pdf->charset_in='UTF-8';
    $pdf->autoLangToFont = true;
    ini_set('memory_limit', '256M');

    $output=$pdf->WriteHTML($html);
    $pdf->Output($output.$pdfFilePath, 'D'); 
    exit();

  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function form15_certificate()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                          = $this->session->userdata('customer_id');
  $survey_user_id                       = $this->session->userdata('survey_user_id');
  $vessel_id                            = $this->uri->segment(4);

  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'form15_certificate', 'page' => 'form15_certificate', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $ip                                 = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date                               = date('Y-m-d h:i:s', time()); 


    $vessel_details_viewpage            = $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']    = $vessel_details_viewpage;

    @$id                                = $vessel_details_viewpage[0]['user_id'];


    //-----------Get customer name and address--------------//
    $customer_details                   = $this->Survey_model->get_customer_details($id);
    $data['customer_details']           = $customer_details;
   
    $survey_id                          = 1;
    //----------Hull Details--------//
   
    $hull_details                       = $this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']               = $hull_details;

   
    //----------Engine Details--------//
   
    $engine_details                     = $this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']             = $engine_details;

    $pdfFilePath = "form15_certificate_".$vessel_id.".pdf";
    $html=$this->load->view('Kiv_views/dash/form15_certificate',$data,TRUE);

    $this->load->library('Pdf.php');
    $pdf =  $this->pdf->load();
    $pdf->allow_charset_conversion=true;  // Set by default to TRUE
    $pdf->charset_in='UTF-8';
    $pdf->autoLangToFont = true;
    ini_set('memory_limit', '256M');

    $output=$pdf->WriteHTML($html);
    $pdf->Output($output.$pdfFilePath, 'D'); 
    exit();


  }
  else
  {
    redirect('Main_login/index'); 
  }
}
///////////////////////Vessel Name Change------End---------//////////////////////////
///////////////////////Vessel Ownership Change------Start---------//////////////////////////
public function ownershipChange_list()
{ 
   /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
   $customer_id                         = $this->session->userdata('customer_id');
   $survey_user_id                      = $this->session->userdata('survey_user_id');

   
   if(!empty($sess_usr_id)&&($user_type_id==11))
   {
      $data = array('title' => 'ownershipChange_list', 'page' => 'ownershipChange_list', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      $vessel_list                      = $this->Vessel_change_model->get_vesselownerchange_List($sess_usr_id);
      $data['vessel_list']              = $vessel_list;//print_r($vessel_list);
      $count                            = count($vessel_list);
      $data['count']                    = $count;
      $data                             = $data + $this->data;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/ownershipChange_list',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
   }
   else
   {
          redirect('Main_login/index');        
   }

}
public function ownershipchange()
{ 
    /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                        = $this->session->userdata('customer_id');
    $survey_user_id                     = $this->session->userdata('survey_user_id');
  
    $vessel_id1                         = $this->uri->segment(4);
    $processflow_sl1                    = $this->uri->segment(5);
    $status_details_sl1                 = $this->uri->segment(6);

    $vessel_id                          = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
    $vessel_id                          = $this->encrypt->decode($vessel_id); 

    $processflow_sl                     = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
    $processflow_sl                     = $this->encrypt->decode($processflow_sl); 

    $status_details_sl                  = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
    $status_details_sl                  = $this->encrypt->decode($status_details_sl); 

   
   if(!empty($sess_usr_id)&&($user_type_id==11))
   {
      $data = array('title' => 'namechange', 'page' => 'namechange', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      $vesselDet                        = $this->Vessel_change_model->get_vesselDet($vessel_id);
      $data['vesselDet']                = $vesselDet; //print_r($vesselDet);exit;
      if(!empty($vesselDet))
      {
        $vessel_type_id                 = $vesselDet[0]['vessel_type_id'];
        $vessel_subtype_id              = $vesselDet[0]['vessel_subtype_id'];
      }
 

      $process_data                     = $this->Vessel_change_model->get_process_flow_sl($vessel_id);
      $data['process_data']             = $process_data;
      if(!empty($process_data))
      {
        $status_change_date1            = $process_data[0]['status_change_date'];
      }
  //print_r($process_data);exit;

      $data['status_details_sl']        = $status_details_sl;
      $data['processflow_sl']           = $processflow_sl;

      $survey_id                        = 0;

      $engine_details                   = $this->Vessel_change_model->get_engine_details($vessel_id,$survey_id);
      $data['engine_details']           = $engine_details;

      $no_of_engineset                  = count($engine_details);


      //______________________________________________//
      //Master Data Population

      $registeringAuthority             = $this->Bookofregistration_model->get_registeringAuthority();
      $data['registeringAuthority']     = $registeringAuthority;//print_r($registeringAuthority);

      $insuranceCompany                 = $this->Bookofregistration_model->get_insuranceCompany();
      $data['insuranceCompany']         = $insuranceCompany;

      $masClass                         = $this->Bookofregistration_model->get_masterClass();
      $data['masClass']                 = $masClass;

      $plyingPort                       = $this->Bookofregistration_model->get_portofregistry();
      $data['plyingPort']               = $plyingPort;

      $vesselMasterDetails              = $this->Bookofregistration_model->get_crew_details($vessel_id,1);
      $data['vesselMasterDetails']      = $vesselMasterDetails;
      $vesselMasterDetails_count        = count($vesselMasterDetails);

  //___________________________TARIFF DETAILS____________________________________________//

      $status_change_date               = date("Y-m-d", strtotime($status_change_date1));
      $now                              = date("Y-m-d");
      $date1_ts                         = strtotime($status_change_date);
      $date2_ts                         = strtotime($now);
      $diff                             = $date2_ts - $date1_ts;
      $numberofdays1                    = round($diff / 86400);
      

      $form_id                          = 18;
      $activity_id                      = 7;
      
      $tariff_details                   = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
      $data1['tariff_details']          = $tariff_details; 
      if (!empty($tariff_details)) 
      {
        $tariff_amount1                 = $tariff_details[0]['tariff_amount'];
        $tariff_min_amount              = $tariff_details[0]['tariff_min_amount'];
      }
      
      $tonnage_details                  = $this->Vessel_change_model->get_tonnage_details($vessel_id);
      $data1['tonnage_details']         = $tonnage_details;//print_r($tonnage_details);exit;
      if(!empty($tonnage_details))
      {
        @$vessel_total_tonnage          = $tonnage_details[0]['vessel_total_tonnage'];
      }
      $amount1                          = $vessel_total_tonnage*$tariff_amount1;

      if($amount1<100)
      {
        $data['tariff_amount']          = $tariff_min_amount;
      }
      else
      {
        $data['tariff_amount']          = $amount1;
      }
      
      $data = $data + $this->data;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/ownershipchange',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
   }
   else
   {
          redirect('Main_login/index');        
   }

}
function Vessel_owner_check()
{ //echo "hiii";exit;
    /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                        = $this->session->userdata('customer_id');
    $survey_user_id                     = $this->session->userdata('survey_user_id');

    $ip                                 = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date                               =   date('Y-m-d h:i:s', time()); 

    //if(!empty($sess_usr_id)&&($sess_usr_id==4))    
    if(!empty($sess_usr_id))
    {
      $data = array('title' => 'form1', 'page' => 'form1', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Kiv_models/Vessel_change_model');

      $newowner_mob                     = $this->security->xss_clean($this->input->post('newowner_mob'));
      $newowner_mail                    = $this->security->xss_clean($this->input->post('newowner_mail')); 

      $ownerDet                         = $this->Vessel_change_model->get_owner_check($newowner_mob,$newowner_mail);
      $data['ownerDet']                 = $ownerDet; //print_r($ownerDet);
      $ownerDet_rws                     = count($ownerDet);
      $data['ownerDet_rws']             = $ownerDet_rws;
      $data                             = $data + $this->data;
     
      $this->load->view('Kiv_views/Ajax_ownership.php', $data);
    }
    else
  {
    redirect('Main_login/index'); 
  }

}
function showpayment18($vessel_id)
{ 
    
    $vessel_condition                    = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition']            = $vessel_condition;
    //print_r($vessel_condition);
    if(!empty($vessel_condition))
    {
      $vessel_type_id                    = $vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id                 = $vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1                    = $vessel_condition[0]['vessel_length'];
      $hullmaterial_id                   = $vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id               = $vessel_condition[0]['engine_placement_id'];
    }

    $form_id                             = 18;
    $activity_id                         = 7;

    $tariff_details                      = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data1['tariff_details']             = $tariff_details; 
    if (!empty($tariff_details)) 
    {
      $tariff_amount1                    = $tariff_details[0]['tariff_amount'];
      $tariff_min_amount                 = $tariff_details[0]['tariff_min_amount'];
    }
      
    $tonnage_details                     = $this->Vessel_change_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']            = $tonnage_details;//print_r($tonnage_details);exit;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage             = $tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1                             = $vessel_total_tonnage*$tariff_amount1;

    if($amount1<100)
    {
      //$data1['tariff_amount']              = $tariff_min_amount;
      $data1['tariff_amount']            = 1;
    }
    else
    {
      //$data1['tariff_amount']              = $amount1;
      $data1['tariff_amount']            = 1;
    }
 
    $this->load->view('Kiv_views/Ajax_payment_show.php',$data1);
}
function not_payment_details_form18()
{ //print_r($_POST);exit;
  $vessel_id                              = $this->session->userdata('vessel_id');
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                            = $this->session->userdata('customer_id');
  $survey_user_id                         = $this->session->userdata('survey_user_id');


  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
$this->load->model('Kiv_models/Survey_model');
    date_default_timezone_set("Asia/Kolkata");
    $date                                 = date('Y-m-d h:i:s', time());

    $vessel_id                            = $this->security->xss_clean($this->input->post('vessel_sl'));  
    $process_id                           = $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id                            = 0;
    $current_status_id                    = $this->security->xss_clean($this->input->post('current_status_id'));
    $current_position                     = $this->security->xss_clean($this->input->post('current_position')); 
    $status_change_date                   = $date;
    $processflow_sl                       = $this->security->xss_clean($this->input->post('processflow_sl'));
    $user_id                              = $this->security->xss_clean($this->input->post('user_id'));
    $status                               = 1;
    $status_details_sl                    = $this->security->xss_clean($this->input->post('status_details_sl'));
    $ip                                   = $_SERVER['REMOTE_ADDR'];
    
    $data_update=array(
      'status'=>0
    );
    $process_update                       = $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);

    $data_process=array(
      'vessel_id'                         => $vessel_id,
      'process_id'                        => $process_id,
      'survey_id'                         => $survey_id,
      'current_status_id'                 => 8,
      'current_position'                  => $user_type_id,
      'user_id'                           => $sess_usr_id,
      'previous_module_id'                => $processflow_sl,
      'status'                            => $status,
      'status_change_date'                => $status_change_date
    ); //print_r($data_process);exit;

    $data_status=array(
      'vessel_id'                         => $vessel_id,
      'process_id'                        => $process_id,
      'survey_id'                         => $survey_id,
      'current_status_id'                 => 8,
      'sending_user_id'                   => $sess_usr_id,
      'receiving_user_id'                 => $sess_usr_id,
    );//print_r($data_status);exit;

    $status_update                        = $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_status,$status_details_sl);
    $insert_process                       = $this->Vessel_change_model->insert_process_flow($data_process);
  
              
    if($insert_process && $status_update && $process_update)  
    {
      redirect('Kiv_Ctrl/Survey/SurveyHome');
    }       
            
  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function payment_details_form18()
{
 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                            = $this->session->userdata('customer_id');
  $survey_user_id                         = $this->session->userdata('survey_user_id');

  $vessel_id1                             = $this->uri->segment(4);
  $processflow_sl1                        = $this->uri->segment(5);
  $status_details_sl1                     = $this->uri->segment(6);

  $vessel_id                              = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                              = $this->encrypt->decode($vessel_id); 

  $processflow_sl                         = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                         = $this->encrypt->decode($processflow_sl); 

  $status_details_sl                      = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl                      = $this->encrypt->decode($status_details_sl); 

  if(!empty($sess_usr_id))
  {
    $data = array('title' => 'ownchange', 'page' => 'ownchange', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');

    $vesselDet                            = $this->Vessel_change_model->get_vesselDet($vessel_id);
    $data['vesselDet']                    = $vesselDet; //print_r($vesselDet);exit;
    if(!empty($vesselDet))
    {
      $vessel_type_id                     = $vesselDet[0]['vessel_type_id'];
      $vessel_subtype_id                  = $vesselDet[0]['vessel_subtype_id'];
    }
 
    $process_data                         = $this->Vessel_change_model->get_process_flow_sl($vessel_id);
    $data['process_data']                 = $process_data;
    $status_change_date1                  = $process_data[0]['status_change_date'];
    //print_r($process_data);exit;

    $data['status_details_sl']            = $status_details_sl;
    $data['processflow_sl']               = $processflow_sl;

    $survey_id                            = 0;

    $engine_details                       = $this->Vessel_change_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']               = $engine_details;

    $no_of_engineset                      = count($engine_details);

    $registeringAuthority                 = $this->Bookofregistration_model->get_registeringAuthority();
    $data['registeringAuthority']         = $registeringAuthority;//print_r($registeringAuthority);

    $insuranceCompany                     = $this->Bookofregistration_model->get_insuranceCompany();
    $data['insuranceCompany']             = $insuranceCompany;

    $masClass                             = $this->Bookofregistration_model->get_masterClass();
    $data['masClass']                     = $masClass;

    $plyingPort                           = $this->Bookofregistration_model->get_portofregistry();
    $data['plyingPort']                   = $plyingPort;

    $vesselMasterDetails                  = $this->Bookofregistration_model->get_crew_details($vessel_id,1);
    $data['vesselMasterDetails']          = $vesselMasterDetails;
    $vesselMasterDetails_count            =  count($vesselMasterDetails);

    $bank                                 = $this->Survey_model->get_bank_favoring();
    $data['bank']                         = $bank;


    $portofregistry                       = $this->Survey_model->get_portofregistry();
    $data['portofregistry']               = $portofregistry;

  //___________________________TARIFF DETAILS____________________________________________//

    $status_change_date                   = date("Y-m-d", strtotime($status_change_date1));
    $now                                  = date("Y-m-d");
    $date1_ts                             = strtotime($status_change_date);
    $date2_ts                             = strtotime($now);
    $diff                                 = $date2_ts - $date1_ts;
    $numberofdays1                        = round($diff / 86400);
      

    $form_id                              = 18;
    $activity_id                          = 7;
      
    $tariff_details                       = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data1['tariff_details']              = $tariff_details; 
    if (!empty($tariff_details)) 
    {
      $tariff_amount1                     = $tariff_details[0]['tariff_amount'];
      $tariff_min_amount                  = $tariff_details[0]['tariff_min_amount'];
    }
      
    $tonnage_details                      = $this->Vessel_change_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']             = $tonnage_details;//print_r($tonnage_details);exit;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage              = $tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1                              = $vessel_total_tonnage*$tariff_amount1;

    if($amount1<100)
    {
      //$data['tariff_amount']              =  $tariff_min_amount;
      $data['tariff_amount']              = 1;
    }
    else
    {
      //$data['tariff_amount']              =  $amount1;
      $data['tariff_amount']              = 1;
    }


    if($this->input->post())
    { 
      date_default_timezone_set("Asia/Kolkata");
      $date                               = date('Y-m-d h:i:s', time());
      $ip                                 = $_SERVER['REMOTE_ADDR'];
      $newDate                            = date("Y-m-d");

      $vessel_id                          = $this->security->xss_clean($this->input->post('vessel_sl'));
      $processflow_sl                     = $this->security->xss_clean($this->input->post('processflow_sl'));
      $status_details_sl                  = $this->security->xss_clean($this->input->post('status_details_sl'));
      $vessel_registry_port_id            = $this->security->xss_clean($this->input->post('vessel_registry_port_id'));
      $tariff_amount                      = $this->security->xss_clean($this->input->post('dd_amount'));

      $newowner_mob                       = $this->security->xss_clean($this->input->post('newowner_mob'));
      $newowner_mail                      = $this->security->xss_clean($this->input->post('newowner_mail'));

      $profile_status                     = $this->security->xss_clean($this->input->post('profile_status'));
      $buyer_id                           = $this->security->xss_clean($this->input->post('buyer_id'));
      ///---if user exists, status=2(profile created) and if it is a new buyer, status=1(no profile)---///
      if($profile_status>0){
        $changepending_status             = 2;
        $buyer_decl_upload                = $this->security->xss_clean($_FILES["buyer_decl_upload"]["name"]);
        $seller_decl_upload               = $this->security->xss_clean($_FILES["seller_decl_upload"]["name"]);
        $notary_upload                    = $this->security->xss_clean($_FILES["notary_upload"]["name"]);
      } else if($profile_status==0){
        $changepending_status             = 1;
        $buyer_name                       = $this->security->xss_clean($this->input->post('buyer_name'));
        $buyer_address                    = $this->security->xss_clean($this->input->post('buyer_address'));
        $idcard_upload                    = $this->security->xss_clean($_FILES["idcard_upload"]["name"]);
      }

      $vessel_main                        = $this->Vessel_change_model->get_vessel_main($vessel_id);
      $data['vessel_main']                = $vessel_main;
      if(!empty($vessel_main))
      {
        $vesselmain_sl                    = $vessel_main[0]['vesselmain_sl'];
      }
      if($profile_status>0){
        //----seller declaration(start)---///
          
        if($seller_decl_upload)
        {
          //echo "uploaded";
          $inssller_path_parts            = pathinfo($_FILES["seller_decl_upload"]["name"]);
          $inssller_extension             = $inssller_path_parts['extension'];

          $inssller_file_name             = 'OWNCHG'.'_SELRDECL_Form18_'.$vessel_id.'_'.$date.'.'.$inssller_extension; 
          $target                         = "./uploads/Ownership_Declaration/".$inssller_file_name;
          $ins_upd                        = move_uploaded_file($_FILES["seller_decl_upload"]["tmp_name"], $target);
        }
        else
        {
          $inssller_file_name             = '';
        }
        $seller_declaration               = pathinfo($_FILES['seller_decl_upload']['name']);
        if($seller_declaration)
        {
          $extension                      = $seller_declaration['extension'];
        }
        else
        {
          $extension                      = "";
        }
        //----seller declaration(end)---///

        //----buyer declaration(start)---///

        if($buyer_decl_upload)
        {
          //echo "uploaded";
          $insbuyer_path_parts            = pathinfo($_FILES["buyer_decl_upload"]["name"]);
          $insbuyer_extension             = $insbuyer_path_parts['extension'];

          $insbuyer_file_name             = 'OWNCHG'.'_BUYRDECL_Form18_'.$vessel_id.'_'.$date.'.'.$insbuyer_extension; 
          $target1                        = "./uploads/Ownership_Declaration/".$insbuyer_file_name;
          $ins_upd1                       = move_uploaded_file($_FILES["buyer_decl_upload"]["tmp_name"], $target1);
        }
        else
        {
          $insbuyer_file_name             = '';
        }
        $buyer_declaration                = pathinfo($_FILES['buyer_decl_upload']['name']);
        if($buyer_declaration)
        {
          $extension1                     = $buyer_declaration['extension'];
        }
        else
        {
          $extension1                     = "";
        }
        //----buyer declaration(end)---///

        //----Notary(start)---///
        if($notary_upload)
        {
          //echo "uploaded";
          $insnotary_path_parts           = pathinfo($_FILES["notary_upload"]["name"]);
          $insnotary_extension            = $insnotary_path_parts['extension'];

          $insnotary_file_name            = 'OWNCHG'.'_NOTARY_Form18_'.$vessel_id.'_'.$date.'.'.$insnotary_extension; 
          $target2                        = "./uploads/Ownership_Declaration/".$insnotary_file_name;
          $ins_upd2                       = move_uploaded_file($_FILES["notary_upload"]["tmp_name"], $target2);//exit;
        }
        else
        {
          $insnotary_file_name            = '';
        }
        $notary                           = pathinfo($_FILES['notary_upload']['name']);
        if($notary)
        {
          $extension2                     = $notary['extension'];
        }
        else
        {
          $extension2  ="";
        }
          //----Notary(end)---///
      } else  if($profile_status==0){
          //----ID Card(start)---///
        if($idcard_upload)
        {
          //echo "uploaded";
          $insidcard_path_parts           = pathinfo($_FILES["idcard_upload"]["name"]);
          $insidcard_extension            = $insidcard_path_parts['extension'];

          $insidcard_file_name            = 'OWNCHG'.'_ID_Form18_'.$vessel_id.'_'.$date.'.'.$insidcard_extension; 
          $target3                        = "./uploads/Ownership_Declaration/".$insidcard_file_name;
          $ins_upd3                       = move_uploaded_file($_FILES["idcard_upload"]["tmp_name"], $target3);//exit;
        }
        else
        {
          $insnotary_file_name            = '';
        }
        $idcard                           = pathinfo($_FILES['idcard_upload']['name']);
        if($idcard)
        {
          $extension3                     = $idcard['extension'];
        }
        else
        {
          $extension3                     = "";
        }
          //----Notary(end)---///
      }
      //////////////////////Reference Number For Ownership Change Process (Start)////////////////////////////
      $ownchg_rws                         = $this->Vessel_change_model->get_ownchg_rws();
      $cntown_rws                         = count($ownchg_rws);
      if($cntown_rws==0){
        $value                            = "1";
      } elseif ($cntown_rws>0) {
        $ownchg_last_refno                = $this->Vessel_change_model->get_ownchange_ref_number();
        foreach ($ownchg_last_refno as $ref_res) {
          $ref_no                         = $ref_res['ref_number'];
        }
        $ref_exp                          = explode('_', $ref_no);
        $ref_val                          = $ref_exp[1];
        $value                            = $ref_val + 1;
      }
      if($value<10){
        $value                            = "00".$value;
      } elseif ($value<100) {
        $value                            = "0".$value;
      } else {
        $value                            = $value;
      }
      $yr                                 = date('Y');
      $ref_number                         = "OC"."_".$value."_".$vessel_id.$yr; 
      //////////////////////Reference Number For Ownership Change Process (End)////////////////////////////
        
      $check_ownerchange                  = $this->Vessel_change_model->get_buyer_details($vessel_id);
      $count_rws                          = count($check_ownerchange); 
      if($count_rws>0){
        $data_own=array(
          'transfer_status'               => 0
        );
        $ownchg_update_status             = $this->Vessel_change_model->update_ownerchg_status('tbl_transfer_ownershipchange',$data_own, $vessel_id);
        if($ownchg_update_status){
          if($profile_status>0){
            $data_ownerchgupd=array(
              'transfer_changetype'           =>  2,
              'transfer_vessel_id'            =>  $vessel_id,
              'transfer_vessel_main_id'       =>  $vesselmain_sl,
              'ref_number'                    =>  $ref_number,
              'transfer_req_date'             =>  $newDate,
              'transfer_changepending_status' =>  $changepending_status,
              'transfer_seller_declaration'   =>  $inssller_file_name,
              'transfer_buyer_declaration'    =>  $insbuyer_file_name,
              'transfer_notary'               =>  $insnotary_file_name,
              'transfer_buyer_id'             =>  $buyer_id,
              'transfer_buyer_mobile'         =>  $newowner_mob,
              'transfer_buyer_email_id'       =>  $newowner_mail,
              'transfer_seller_id'            =>  $sess_usr_id,
              'transfer_status'               =>  1
            );//print_r($ownerdet); exit;

          } else {
            $data_ownerchgupd=array(
              'transfer_changetype'           =>  2,
              'transfer_vessel_id'            =>  $vessel_id,
              'transfer_vessel_main_id'       =>  $vesselmain_sl,
              'ref_number'                    =>  $ref_number,
              'transfer_req_date'             =>  $newDate,
              'transfer_changepending_status' =>  $changepending_status,
              'transfer_buyer_name'           =>  $buyer_name,
              'transfer_buyer_address'        =>  $buyer_address,
              'transfer_buyer_idcard'         =>  $insidcard_file_name,
              'transfer_buyer_mobile'         =>  $newowner_mob,
              'transfer_buyer_email_id'       =>  $newowner_mail,
              'transfer_seller_id'            =>  $sess_usr_id,
              'transfer_status'               =>  1
            );//print_r($ownerdet); exit;

          }
            
          $insertOwnerDet                 = $this->security->xss_clean($data_ownerchgupd);         
          $insertOwnerDet_res             = $this->db->insert('tbl_transfer_ownershipchange', $insertOwnerDet);
        }
      } else { 
       //$update_change
        if($profile_status>0){
          $ownerdet=array(
            'transfer_changetype'             =>  2,
            'transfer_vessel_id'              =>  $vessel_id,
            'transfer_vessel_main_id'         =>  $vesselmain_sl,
            'ref_number'                      =>  $ref_number,
            'transfer_req_date'               =>  $newDate,
            'transfer_changepending_status'   =>  $changepending_status,
            'transfer_seller_declaration'     =>  $inssller_file_name,
            'transfer_buyer_declaration'      =>  $insbuyer_file_name,
            'transfer_notary'                 =>  $insnotary_file_name,
            'transfer_buyer_id'               =>  $buyer_id,
            'transfer_buyer_mobile'           =>  $newowner_mob,
            'transfer_buyer_email_id'         =>  $newowner_mail,
            'transfer_seller_id'              =>  $sess_usr_id,
            'transfer_status'                 =>  1
          );//print_r($ownerdet); exit;

        } else {
          $ownerdet=array(
            'transfer_changetype'             =>  2,
            'transfer_vessel_id'              =>  $vessel_id,
            'transfer_vessel_main_id'         =>  $vesselmain_sl,
            'ref_number'                      =>  $ref_number,
            'transfer_req_date'               =>  $newDate,
            'transfer_changepending_status'   =>  $changepending_status,
            'transfer_buyer_name'             =>  $buyer_name,
            'transfer_buyer_address'          =>  $buyer_address,
            'transfer_buyer_idcard'           =>  $insidcard_file_name,
            'transfer_buyer_mobile'           =>  $newowner_mob,
            'transfer_buyer_email_id'         =>  $newowner_mail,
            'transfer_seller_id'              =>  $sess_usr_id,
            'transfer_status'                 =>  1
          );//print_r($ownerdet); exit;

        }
        $insertOwnerDet                   = $this->security->xss_clean($ownerdet);         
        $insertOwnerDet_res               = $this->db->insert('tbl_transfer_ownershipchange', $insertOwnerDet);
      } 
    } 
    $data = $data + $this->data;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/payment_details_form18',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');

  } 
  else
  {
    redirect('Main_login/index');        
  }

} 
public function pay_now_form18()
{ //print_r($_POST);exit;

  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                      = $this->session->userdata('customer_id');
  $survey_user_id                   = $this->session->userdata('survey_user_id');


  $vessel_id1                       = $this->uri->segment(4);
  $processflow_sl1                  = $this->uri->segment(5);
  $status_details_sl1               = $this->uri->segment(6);

  $vessel_id                        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                        = $this->encrypt->decode($vessel_id); 

  $processflow_sl                   = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                   = $this->encrypt->decode($processflow_sl); 

  $status_details_sl                = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl                = $this->encrypt->decode($status_details_sl); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'pay_now_form18', 'page' => 'pay_now_form18', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Bookofregistration_model');
    $this->load->model('Kiv_models/Vessel_change_model');

    date_default_timezone_set("Asia/Kolkata");
    $date                           = date('Y-m-d h:i:s', time());
    $ip                             = $_SERVER['REMOTE_ADDR'];
    $newDate                        = date("Y-m-d");
    $vessel_id                      = $this->security->xss_clean($this->input->post('vessel_sl'));
    $processflow_sl                 = $this->security->xss_clean($this->input->post('processflow_sl'));
    $status_details_sl              = $this->security->xss_clean($this->input->post('status_details_sl'));

    
    $process_id                     = $this->security->xss_clean($this->input->post('process_id')); 
    $current_status_id              = $this->security->xss_clean($this->input->post('current_status_id'));
    $current_position               = $this->security->xss_clean($this->input->post('current_position')); 
    $status_change_date             = $date;
    $survey_id                      = 0;
     
    $user_id                        = $this->security->xss_clean($this->input->post('user_id'));
    $status                         = 1;

    /*$paymenttype_id     = 4;
    $dd_amount          = $this->security->xss_clean($this->input->post('dd_amount'));
    $portofregistry_sl  = $this->security->xss_clean($this->input->post('portofregistry_sl'));*/
        
    $form_number_cs                 = $this->Vessel_change_model->get_form_number_cs($process_id);
    $data['form_number_cs']         = $form_number_cs;
    if(!empty($form_number_cs))
    {
      $formnumber=$form_number_cs[0]['form_no'];
    }
    $vessel_main                    = $this->Vessel_change_model->get_vessel_main($vessel_id);
    $data['vessel_main']            = $vessel_main;
    if(!empty($vessel_main))
    {
      $vesselmain_sl                = $vessel_main[0]['vesselmain_sl'];
    }
 
    /*$data_payment=array(
      'vessel_id'                 =>$vessel_id,
      'survey_id'                 =>$survey_id,
      'form_number'               =>$formnumber,
      'paymenttype_id'            =>$paymenttype_id,
      'dd_amount'                 =>$dd_amount,
      'dd_date'                   =>$newDate,
      'portofregistry_id'         =>$portofregistry_sl,
      'payment_created_user_id'   =>$sess_usr_id,
      'payment_created_timestamp' =>$date,
      'payment_created_ipaddress' =>$ip
    );

    //print_r($data_payment);


    $result_insert    = $this->db->insert('tbl_kiv_payment_details', $data_payment); 
    $task_pfid        = $this->Survey_model->get_task_pfid($processflow_sl);
    $data['task_pfid']= $task_pfid;
    @$task_sl         = $task_pfid[0]['task_sl'];



    $port_registry_user_id           =   $this->Vessel_change_model->get_port_registry_user_id($portofregistry_sl);
    $data['port_registry_user_id']   =   $port_registry_user_id;
    if(!empty($port_registry_user_id))
    {
      $pc_user_id     = $port_registry_user_id[0]['user_sl'];
      $pc_usertype_id = $port_registry_user_id[0]['user_type_id'];
    }
      
    if($process_id==39)
    {
      /////process flow start indication---- tb_vessel_main processing_status to be changed as 1
      $data_mainupdate  = array('processing_status'=>1);
      ///tbl_ownership_change payment status
      $data_ownerchgupdate  = array(
        'payment_status' =>  1, 
        'transfer_payment_date' => $newDate
      );
      /////insert to processflow table showing curre

      $data_insert=array(
        'vessel_id'         => $vessel_id,
        'process_id'        => $process_id,
        'survey_id'         => $survey_id,
        'current_status_id' => 2,
        'current_position'  => $pc_usertype_id,
        'user_id'           => $pc_user_id,
        'previous_module_id'=> $processflow_sl,
        'status'            => $status,
        'status_change_date'=> $status_change_date
      ); //rint_r($data_insert);exit;

      //////update current process status=0
      $data_update = array('status'=>0);
      //////update status details table
      $data_survey_status=array(
        'survey_id'        => $survey_id,
        'process_id'       => $process_id,
        'current_status_id'=> 2,
        'sending_user_id'  => $sess_usr_id,
        'receiving_user_id'=> $pc_user_id
      );//print_r($data_survey_status);exit;

        $ownerchg_update=$this->Vessel_change_model->update_ownerchg_status('tbl_transfer_ownershipchange',$data_ownerchgupdate, $vessel_id);
        $vesselmain_update=$this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
        $process_update=$this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        

        $status_update=$this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        if($ownerchg_update && $vesselmain_update && $process_update && $process_insert && $status_update && $result_insert)
        {
          redirect("Kiv_Ctrl/Survey/SurveyHome");
        }
     }*/
     //____________________________________________________START ONLINE TRANSACTION__________________________________//

    /*_____________________Start Get vessel condition_______________ */   

    $vessel_condition                 = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition']         = $vessel_condition;
   
    if(!empty($vessel_condition))
    {
      $vessel_type_id                 = $vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id              = $vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1                 = $vessel_condition[0]['vessel_length'];
      $hullmaterial_id                = $vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id            = $vessel_condition[0]['engine_placement_id'];
    }  
    /*_____________________End Get vessel condition___________________*/

    /*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
    $form_id                          = 18;
    $activity_id                      = 7;

    $tariff_details                   = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data1['tariff_details']          = $tariff_details; //print_r($tariff_details);exit;
    if (!empty($tariff_details)) 
    {
      $tariff_amount1                 = $tariff_details[0]['tariff_amount'];
      $tariff_min_amount              = $tariff_details[0]['tariff_min_amount'];
    }
      
    $tonnage_details                  = $this->Vessel_change_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']         = $tonnage_details;//print_r($tonnage_details);exit;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage          = $tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1                          = $vessel_total_tonnage*$tariff_amount1;

    if($amount1<100)
    {
      //$data['tariff_amount']          = $tariff_min_amount;
      $tariff_amount                  = 1;
    }
    else
    {
      //$data['tariff_amount']          = $amount1;
      $tariff_amount                  = 1;
    }
    /*_______________________________________________END Tariff____________________________ */   

    /*___________________________________________________________________________ */   
    if($this->input->post())
    { //print_r($_POST);
      //$dd_amount1           = $this->security->xss_clean($this->input->post('dd_amount'));
      $portofregistry_sl                = $this->security->xss_clean($this->input->post('portofregistry_sl'));
      $bank_sl                          = $this->security->xss_clean($this->input->post('bank_sl'));
      $vessel_sl                        = $this->security->xss_clean($this->input->post('vessel_sl'));
      $status                           = 1;

      $vessel_main                      = $this->Vessel_change_model->get_vessel_main($vessel_sl);
      $data['vessel_main']              = $vessel_main;
      if(!empty($vessel_main))
      {
        $vesselmain_sl                  = $vessel_main[0]['vesselmain_sl'];
      }

      $vessel_condition                 = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_id);
      $data['vessel_condition']         = $vessel_condition; 
     
      if(!empty($vessel_condition))
      {
        $vessel_type_id                 = $vessel_condition[0]['vessel_type_id'];
        $vessel_subtype_id              = $vessel_condition[0]['vessel_subtype_id'];
        $vessel_length1                 = $vessel_condition[0]['vessel_length'];
        $hullmaterial_id                = $vessel_condition[0]['hullmaterial_id'];
        $engine_placement_id            = $vessel_condition[0]['engine_placement_id'];
      }  
      /*_____________________End Get vessel condition___________________*/

      /*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
      $form_id                          = 18;
      $activity_id                      = 7;

      $tariff_details                   = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
      $data1['tariff_details']          = $tariff_details; 
      if (!empty($tariff_details)) 
      {
        $tariff_amount1                 = $tariff_details[0]['tariff_amount'];
        $tariff_min_amount              = $tariff_details[0]['tariff_min_amount'];
      }
        
      $tonnage_details                  = $this->Vessel_change_model->get_tonnage_details($vessel_id);
      $data1['tonnage_details']         = $tonnage_details;//print_r($tonnage_details);exit;
      if(!empty($tonnage_details))
      {
        @$vessel_total_tonnage          = $tonnage_details[0]['vessel_total_tonnage'];
      }
      $amount1                          = $vessel_total_tonnage*$tariff_amount1;

      if($amount1<100)
      {///for checking payment
        //$tariff_amount                  = $tariff_min_amount;
        $tariff_amount                  = 1;
      }
      else
      {//for checking payment
        //$tariff_amount                  = $amount1;
        $tariff_amount                  = 1;
      }

      $payment_user                     = $this->Vessel_change_model->get_payment_userdetails($sess_usr_id);
      $data['payment_user']             = $payment_user;
      //print_r($payment_user);exit;
      if(!empty($payment_user))
      {
        $owner_name                     = $payment_user[0]['user_name'];
        $user_mobile_number             = $payment_user[0]['user_mobile_number'];
        $user_email                     = $payment_user[0]['user_email'];
      }
      $formnumber                       = 18;
      $survey_id                        = 0;

      date_default_timezone_set("Asia/Kolkata");
      $ip                               = $_SERVER['REMOTE_ADDR'];
      $date                             = date('Y-m-d h:i:s', time());
      $newDate                          = date("Y-m-d");
      $status_change_date               = $date;


      $milliseconds                     = round(microtime(true) * 1000); //Generate unique bank number

      $bank_gen_number                  = $this->Survey_model->get_bank_generated_last_number($bank_sl);
      $data['bank_gen_number']          = $bank_gen_number;

      if(!empty($bank_gen_number))
      {
        $bank_generated_number          = $bank_gen_number[0]['last_generated_no']+1;

        $transaction_id                 = $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds.$bank_generated_number;
        $tocken_number                  = $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds;

        $bank_data                      = array('last_generated_no'=>$bank_generated_number);//print_r($bank_data);exit;

        $data_payment_request=array(
          'transaction_id'              => $transaction_id,
          'bank_ref_no'                 => 0,
          'token_no'                    => $tocken_number,
          'vessel_id'                   => $vessel_id,
          'survey_id'                   => $survey_id,
          'form_number'                 => $formnumber,
          'customer_registration_id'    => $sess_usr_id,
          'customer_name'               => $owner_name,
          'mobile_no'                   => $user_mobile_number,
          'email_id'                    => $user_email,
          'transaction_amount'          => $tariff_amount,
          'remitted_amount'             => 0,
          'bank_id'                     => $bank_sl,
          'transaction_status'          => 0,
          'payment_status'              => 0,
          'transaction_timestamp'       => $date,
          'transaction_ipaddress'       => $ip,
          'port_id'                     => $portofregistry_sl
        ); //print_r($data_payment_request);exit;


        $result_insert=$this->db->insert('kiv_bank_transaction_request', $data_payment_request); 
        if($result_insert)
        {
          //echo "hii"; exit;
          $bank_transaction_id          = $this->db->insert_id();
          $update_bank                  = $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);

        //-------get Working key-----------//
          $online_payment_data          = $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
          $data['online_payment_data']  = $online_payment_data; //print_r($online_payment_data);exit;

        //------------------owner details-------------------//

          $payment_user1                = $this->Survey_model->get_payment_userdetails($sess_usr_id);
          $data['payment_user1']        = $payment_user1;



          $requested_transaction_details= $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
          $data['requested_transaction_details']  =   $requested_transaction_details;

          $data['amount_tobe_pay']      = $tariff_amount;
          $data                         = $data+ $this->data;
         //print_r($data);
         //exit;
          ///Actual Data --- Commented for testing(start)//////
          /*if(!empty($online_payment_data))
          { 
              
            $this->load->view('Kiv_views/Hdfc/hdfc_ownchgonlinepayment_request',$data);
             
          }
          else
          {
              
            redirect('Kiv_Ctrl/Survey/SurveyHome');
          
          }*/
          ///Actual Data --- Commented for testing(end)//////

          if(!empty($online_payment_data))
          { 
              
            //$this->load->view('Kiv_views/Hdfc/hdfc_ownchgonlinepayment_request',$data);

            date_default_timezone_set("Asia/Kolkata");
            $ip                   = $_SERVER['REMOTE_ADDR'];
            $date                 =   date('Y-m-d h:i:s', time());
            $newDate              =   date("Y-m-d");

            $vessel_main                    = $this->Vessel_change_model->get_vessel_main($vessel_id);
            $data['vessel_main']            = $vessel_main; 
            if(!empty($vessel_main))
            {
              $vesselmain_sl                = $vessel_main[0]['vesselmain_sl'];
            }

            $status_details             =   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
            $data['status_details']     =   $status_details;
            if(!empty($status_details))
            {
              $status_details_sl        =   $status_details[0]['status_details_sl'];
            }

            $processflow_vessel           =   $this->Survey_model->get_processflow_vessel($vessel_id);
            $data['processflow_vessel']   =   $processflow_vessel;
            if(!empty($processflow_vessel))
            {
              $processflow_sl           =   $processflow_vessel[0]['processflow_sl'];
              $process_id         =   $processflow_vessel[0]['process_id'];
            }

            /*$data_portofregistry=array(
            'vessel_registry_port_id'     => $portofregistry_sl
            );
            $update_portofregistry        = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);*/

            $port_registry_user_id          =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
            $data['port_registry_user_id']  =   $port_registry_user_id;
            if(!empty($port_registry_user_id))
            {
              $pc_user_id           = $port_registry_user_id[0]['user_master_id'];
              $pc_usertype_id         = $port_registry_user_id[0]['user_master_id_user_type'];
            }

            $data_payment=array(
            'vessel_id'         =>  $vessel_id,
            //'survey_id'         =>  $survey_id,
            'survey_id'         =>  7,
            'form_number'         =>  $formnumber,
            'paymenttype_id'        =>  4,
            'dd_amount'         =>  $tariff_amount,
            'dd_date'           =>  $newDate,
            'portofregistry_id'     =>  $portofregistry_sl,
            'bank_id'           =>  $bank_sl,
            'payment_mode'        =>  'Credit Card',
            'transaction_id'        =>  $bank_transaction_id,
            'payment_created_user_id'   =>  $sess_usr_id,
            'payment_created_timestamp' =>  $date,
            'payment_created_ipaddress' =>  $ip); //print_r($data_payment);exit;

            /*if($process_id==38)
            {*/
            /////process flow start indication---- tb_vessel_main processing_status to be changed as 1
            $data_mainupdate=array(
            'processing_status'     =>  1);
            ///tbl_owner_change payment status
            $data_ownerchgupdate=array(
            'payment_status'          =>  1, 
            'transfer_payment_date'   =>  $newDate);
            /////insert to processflow table showing curre
            $data_insert=array(
            'vessel_id'             =>  $vessel_id,
            'process_id'            =>  39,
            'survey_id'             =>  $survey_id,
            'current_status_id'     =>  2,
            'current_position'      =>  $pc_usertype_id,
            'user_id'               =>  $pc_user_id,
            'previous_module_id'    =>  $processflow_sl,
            'status'                =>  1,
            'status_change_date'    =>  $date); //print_r($data_insert);exit;

            //////update current process status=0
            $data_update=array(
            'status'          =>  0);

            //////update status details table
            $data_survey_status=array(
            'survey_id'             =>  $survey_id,
            'process_id'            =>  39,
            'current_status_id'     =>  2,
            'sending_user_id'       =>  $sess_usr_id,
            'receiving_user_id'     =>  $pc_user_id); //print_r($data_survey_status);exit;

            if($tariff_amount>0 && $portofregistry_sl!=false)
            {
              //echo "Amt".$amount."---Port".$portofregistry_sl."---Vesmain".$vesselmain_sl."---Vesid".$vessel_id."---Proce".$processflow_sl."---Stat".$status_details_sl;exit;
              $result_insert        = $this->db->insert('tbl_kiv_payment_details', $data_payment);
              $vesselmain_update      = $this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
              $ownerchg_update      = $this->Vessel_change_model->update_ownerchg_status('tbl_transfer_ownershipchange',$data_ownerchgupdate, $vessel_id);
              $process_update       = $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
              $process_insert       = $this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
              $status_update        = $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
              //}
              if($vesselmain_update && $ownerchg_update && $process_update && $process_insert && $status_update && $result_insert)
              {
                ///get user mail////
                $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($pc_user_id);
                if(!empty($user_mail_id))
                {
                  foreach($user_mail_id as $mail_res)
                  {
                    $user_mail    = $mail_res['user_email'];
                    $user_name    = $mail_res['user_name'];
                    $user_mob     = $mail_res['user_mobile_number'];
                  }
                }
                $own_refno          =   $this->Vessel_change_model->get_buyer_details($vessel_id);
                if(!empty($own_refno))
                {
                  foreach($own_refno as $own_res)
                  {
                    $refno        = $own_res['ref_number'];
                    $main_id        = $own_res['vesselmain_sl'];
                    $reg_no       = $own_res['vesselmain_reg_number'];
                    $vessel       = $own_res['vesselmain_vessel_name'];
                    $buyer       = $own_res['transfer_buyer_id'];
                    if($buyer!=0){
                      $buyer_det    =   $this->Vessel_change_model->get_customer_details($buyer);
                      foreach($buyer_det as $buyer_det_res){
                        $buyer_name = $buyer_det_res['user_master_fullname'];
                      }
                    } else {
                      $buyer_name = "{Unregistered User}";
                    }
                    $seller       = $own_res['transfer_seller_id'];
                    $seller_det    =   $this->Vessel_change_model->get_customer_details($seller);
                    foreach($seller_det as $seller_det_res){
                      $seller_name = $seller_det_res['user_master_fullname'];
                    }
                   
                  }
                }
                
                $portna       =   $this->Vessel_change_model->get_registry_port_id($portofregistry_sl);
                foreach($portna as $port_res){
                  $port_name  = $port_res['vchr_portoffice_name'];
                }

                
                /*------------code for send email starts---------------*/
                $config = Array(
                'protocol'        => 'smtp',
                'smtp_host'       => 'ssl://smtp.googlemail.com',
                'smtp_port'       => 465,
                'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
                'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
                'mailtype'        => 'html',
                'charset'         => 'iso-8859-1');//print_r($config);exit;

                $message = 'Dear '.$user_name.',<br/><br/>

                Payment of Rs. '.$tariff_amount.' for your vessel, '.$reg_no.' ( '.$vessel.' ) for Ownership Change has been received.  Ownership Change from <strong>'.$seller_name.'</strong> to <strong>'.$buyer_name.'</strong> is in process. <br/><br/>

                Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

                Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

                For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

                Warm Regards<br/><br/>

                Kerala Maritime Board ';
                $smsmsg = 'Payment of Rs. '.$tariff_amount.' for '.$reg_no.' is received, and forwarded to'. $port_name.' Port Conservator. Reference Number:  '.$refno.'.';

                
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('kivportinfo@gmail.com'); // change it to yours
                //$this->email->to($user_mail);// change it to yours
                $this->email->to('deepthi.nh@gmail.com');

                $this->email->subject('Payment of Rs. '.$tariff_amount.' has been received for Ownership Change-reg.');
                $this->email->message($message);
                if($this->email->send())
                { //echo "success";redirect("Bookofregistration/raHome");
                redirect('Kiv_Ctrl/VesselChange/ownershipChange_list');
                // <!------------code for send SMS starts--------------->
                $this->load->model('Kiv_models/Vessel_change_model');
                $mobil="9809119144";
                $stat = $this->Vessel_change_model->sendSms($message,$mobil);

                //print_r($stat);exit;
                //echo json_encode("success");
                //redirect("Bookofregistration/raHome");

                /*------------code for send SMS ends---------------*/
                }
                else
                {
                  show_error($this->email->print_debugger());
                } 
              }
            }
             
          }
          else
          {
              
            redirect('Kiv_Ctrl/Survey/SurveyHome');
          
          }
        }
        else
        {
        /* echo '<script language="javascript">';
            echo 'alert(Please try after some time!)'; 
            echo '</script>';*/
          redirect('Kiv_Ctrl/Survey/SurveyHome');
        }

      }
      else
      {
        redirect('Kiv_Ctrl/Survey/SurveyHome');
      }
    } 
//____________________________________________________END ONLINE TRANSACTION__________________________________//
  }
}
public function Verify_payment_pc_form18()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id      = $this->session->userdata('customer_id');
  $survey_user_id   = $this->session->userdata('survey_user_id');


  $vessel_id1       = $this->uri->segment(4);
  $processflow_sl1  = $this->uri->segment(5);
  $survey_id1       = $this->uri->segment(6);

  $vessel_id        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id        = $this->encrypt->decode($vessel_id); 

  $processflow_sl   = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl   = $this->encrypt->decode($processflow_sl); 

  $survey_id        = str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id        = $this->encrypt->decode($survey_id); 


  if(!empty($sess_usr_id) && ($user_type_id==3))
  {
    $data   =  array('title' => 'Verify_payment_pc_form18', 'page' => 'Verify_payment_pc_form18', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $vessel_details           = $this->Vessel_change_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;
    @$id                      = $vessel_details[0]['user_id'];

    $customer_details         = $this->Vessel_change_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;

    $current_status           = $this->Vessel_change_model->get_status();
    $data['current_status']   = $current_status;

    $form_number              = $this->Vessel_change_model->get_form_number($vessel_id);
    $data['form_number']      = $form_number;
    $form_id=$form_number[0]['form_no'];

    $buyer_details            = $this->Vessel_change_model->get_buyer_details($vessel_id);
    $data['buyer_details']    = $buyer_details;

    //----------Vessel Details--------//

    $vessel_details_viewpage        =  $this->Vessel_change_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;

    //----------Payment Details--------//

    $payment_details        = $this->Vessel_change_model->get_form_payment_details($vessel_id,7,$form_id);
    $data['payment_details']= $payment_details;
    //print_r($payment_details);
    if($this->input->post())
    {//print_r($_POST);exit;

      date_default_timezone_set("Asia/Kolkata");
      $date               = date('Y-m-d h:i:s', time());
      $vessel_id          = $this->security->xss_clean($this->input->post('vessel_id'));  
      $process_id         = $this->security->xss_clean($this->input->post('process_id')); 
      $survey_id          = $this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id  = $this->security->xss_clean($this->input->post('current_status_id'));
      //$current_position   = $this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date = $date;
      $processflow_sl     = $this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id            = $this->security->xss_clean($this->input->post('user_id'));
      //$user_sl_cs_sr      = $this->security->xss_clean($this->input->post('user_sl_cs'));
      $status             = 1;

      $status_details_sl1 = $this->security->xss_clean($this->input->post('status_details_sl'));
      $payment_sl         = $this->security->xss_clean($this->input->post('payment_sl'));
      $payment_approved_remarks = $this->security->xss_clean($this->input->post('remarks'));



      $date               =   date('Y-m-d h:i:s', time());
      $ip                 = $_SERVER['REMOTE_ADDR'];
      $status_change_date = $date;

      $usertype           =   $this->Survey_model->get_user_id_cs(14);
      $data['usertype']   =   $usertype;
      if(!empty($usertype))
      {
        $user_sl_ra=   $usertype[0]['user_master_id'];
        $user_type_id_ra=   $usertype[0]['user_master_id_user_type'];
      }

      if($process_id==39)
      {

        $data_payment=array(
          'payment_approved_status'   => 1,
          'payment_approved_user_id'  => $sess_usr_id,
          'payment_approved_datetime' => $status_change_date,
          'payment_approved_ipaddress'=> $ip,
          'payment_approved_remarks'  => $payment_approved_remarks
        ); 

        $data_ownershipchange=array(
          'transfer_pc_verified_date' => $status_change_date,
          'transfer_verify_id'        => $sess_usr_id
        ); //print_r($data_ownershipchange);exit;

        $data_insert=array(
        'vessel_id'         => $vessel_id,
        'process_id'        => $process_id,
        'survey_id'         => $survey_id,
        'current_status_id' => 2,
        'current_position'  => $user_type_id_ra,
        'user_id'           => $user_sl_ra,
        'previous_module_id'=> $processflow_sl,
        'status'            => $status,
        'status_change_date'=> $status_change_date
        );//print_r($data_insert);exit;

        $data_update = array('status'=>0);

        $data_survey_status=array(
        'current_status_id'=>2,
        'sending_user_id'  =>$sess_usr_id,
        'receiving_user_id'=>$user_sl_ra
        );//echo $status_details_sl1;
      //print_r($data_survey_status);
      //exit;


      $payment_update    = $this->Vessel_change_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);
      $ownershipchange_update = $this->Vessel_change_model->update_ownershipchange('tbl_transfer_ownershipchange',$data_ownershipchange, $vessel_id);

      $process_update    = $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert    = $this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);

      $status_update=$this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl1);

    

      if($payment_update && $ownershipchange_update && $process_update && $process_insert && $status_update)
      {
        //redirect("Kiv_Ctrl/Survey/pcHome");
        ///get user mail////
            $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($user_sl_ra);
            if(!empty($user_mail_id))
            {
              foreach($user_mail_id as $mail_res){
                $user_mail    = $mail_res['user_email'];
                $user_name    = $mail_res['user_name'];
                $user_mob     = $mail_res['user_mobile_number'];
              }
            }

            $own_refno          =   $this->Vessel_change_model->get_buyer_details($vessel_id);
                if(!empty($own_refno))
                {
                  foreach($own_refno as $own_res)
                  {
                    $refno        = $own_res['ref_number'];
                    $main_id        = $own_res['vesselmain_sl'];
                    $reg_no       = $own_res['vesselmain_reg_number'];
                    $vessel       = $own_res['vesselmain_vessel_name'];
                    $buyer       = $own_res['transfer_buyer_id'];
                    $portofregistry_sl       = $nam_res['vesselmain_portofregistry_id'];
                    if($buyer!=0){
                      $buyer_det    =   $this->Vessel_change_model->get_customer_details($buyer);
                      foreach($buyer_det as $buyer_det_res){
                        $buyer_name = $buyer_det_res['user_master_fullname'];
                      }
                    } else {
                      $buyer_name = "{Unregistered User}";
                    }
                    $seller       = $own_res['transfer_seller_id'];
                    $seller_det    =   $this->Vessel_change_model->get_customer_details($seller);
                    foreach($seller_det as $seller_det_res){
                      $seller_name = $seller_det_res['user_master_fullname'];
                    }
                   
                  }
                }
                
                

                $payment     =  $this->Vessel_change_model->get_payment_details($payment_sl,$vessel_id);
                foreach($payment as $pay_res){
                  $amount  = $pay_res['dd_amount'];
                }
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

            $message = 'Dear '.$seller_name.',<br/><br/>

                Payment of Rs. '.$amount.' for your vessel, '.$reg_no.' ( '.$vessel.' ) for Ownership Change has been verified by '.$port_name.' Port Conservator.  Ownership Change from <strong>'.$seller_name.'</strong> to <strong>'.$buyer_name.'</strong> is processed by Registering Authority. <br/><br/>

                Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

                Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

                For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

                Warm Regards<br/><br/>

                Kerala Maritime Board ';
                $smsmsg = 'Payment of Rs. '.$amount.' for '.$reg_no.' is verified and forwarded to Registering Authority. Reference Number:  '.$refno;
                      
            
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('kivportinfo@gmail.com'); // change it to yours
            //$this->email->to($user_mail);// change it to yours
            $this->email->to('deepthi.nh@gmail.com');

            $this->email->subject('Payment of Rs. '.$amount.' has been received for Ownership Change-reg.');
            $this->email->message($message);
            if($this->email->send())
            { //echo "success";redirect("Kiv_Ctrl/Bookofregistration/raHome");
            // <!------------code for send SMS starts--------------->
              $this->load->model('Kiv_models/Vessel_change_model');
              //$mobil="9809119144";
              $mobil=$user_mob;
              $moduleid        = 2;
              $modenc          = $this->encrypt->encode($moduleid); 
              $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
              redirect("Kiv_Ctrl/Survey/pcHome/".$modidenc);
              
              //$stat = $this->Vessel_change_model->sendSms($message,$mobil);
              //redirect("Kiv_Ctrl/Survey/pcHome");
              //print_r($stat);exit;
              //echo json_encode("success");
              //redirect("Kiv_Ctrl/Bookofregistration/raHome");
              
              /*------------code for send SMS ends---------------*/
            }
            else
            {
              show_error($this->email->print_debugger());
            } 
      }
    }
   }

      $this->load->view('Kiv_views/template/dash-header.php');
        $this->load->view('Kiv_views/template/nav-header.php');
        $this->load->view('Kiv_views/dash/Verify_payment_pc_form18',$data);
        $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
      redirect('Main_login/index');        
  }
}
public function view_form18()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');

  $vessel_id1        = $this->uri->segment(4);
  $processflow_sl1   = $this->uri->segment(5);
  $status_details_sl1= $this->uri->segment(6);

  $vessel_id         = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id         = $this->encrypt->decode($vessel_id); 

  $processflow_sl    = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl    = $this->encrypt->decode($processflow_sl); 

  $status_details_sl = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl = $this->encrypt->decode($status_details_sl); 
  $survey_id=0;


  if(!empty($sess_usr_id) && ($user_type_id==14))
  {
    $data       =  array('title' => 'view_form18', 'page' => 'view_form18', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $initial_data         =   $this->Vessel_change_model->get_process_flow($processflow_sl);
    $data['initial_data'] = $initial_data;
  //print_r($initial_data);

    $intimation_type_id=3;

    $registration_intimation          = $this->Vessel_change_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']  = $registration_intimation;
    $vessel_change_det                = $this->Vessel_change_model->get_vesselownerchange_details_ra($vessel_id);
    $data['vessel_change_det']        = $vessel_change_det;
    $payment_det                      = $this->Vessel_change_model->get_vesselownerchange_payment_ra($vessel_id);
    $data['payment_det']              = $payment_det;
    $ownershipchange_det              = $this->Vessel_change_model->get_buyer_details($vessel_id);
    $data['ownershipchange_det']      = $ownershipchange_det;

    $stern_material                   = $this->Bookofregistration_model->get_stern_material();
    $data['stern_material']           = $stern_material;

    $plyingPort                       = $this->Bookofregistration_model->get_portofregistry();
    $data['plyingPort']               = $plyingPort; 

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/view_form18',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
    
  }
  else
  {
    redirect('Main_login/index');
  }
  
}
function ownerchange_intimation_send()
{ //print_r($_POST);exit;
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');


  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'ownerchange_intimation_send', 'page' => 'ownerchange_intimation_send', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');


  $vessel_id1        = $this->uri->segment(4);
  $processflow_sl1   = $this->uri->segment(5);
  $status_details_sl1= $this->uri->segment(6);

  $vessel_id         = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id         = $this->encrypt->decode($vessel_id); 

  $processflow_sl    = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl    = $this->encrypt->decode($processflow_sl); 

  $status_details_sl = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl = $this->encrypt->decode($status_details_sl); 
  $survey_id=0;
  if($this->input->post())
  { //print_r($_POST); print_r($_FILES);//exit;
    date_default_timezone_set("Asia/Kolkata");
    $date               = date('Y-m-d h:i:s', time());
    $status_change_date = $date;
    $remarks_date       = date('Y-m-d');
    $ip                 = $_SERVER['REMOTE_ADDR'];
   //print_r($_FILES);

    $vessel_id          = $this->security->xss_clean($this->input->post('vessel_id'));  
    $process_id         = $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id          = $this->security->xss_clean($this->input->post('survey_id'));
    $processflow_sl     = $this->security->xss_clean($this->input->post('processflow_sl'));
    $status_details_sl  = $this->security->xss_clean($this->input->post('status_details_sl'));
    $current_position   = $this->security->xss_clean($this->input->post('current_position'));
    $user_id            = $this->security->xss_clean($this->input->post('user_sl_ra'));
    $registration_intimation_sl=  $this->security->xss_clean($this->input->post('registration_intimation_sl'));
    $user_id_owner      = $this->security->xss_clean($this->input->post('user_id_owner'));
    $user_type_id_owner = $this->security->xss_clean($this->input->post('user_type_id_owner'));
    $current_status_id  = $this->security->xss_clean($this->input->post('current_status_id'));
    $status             = 1;

    $change_inspection_date           = $this->security->xss_clean($this->input->post('change_inspection_date'));
    $portofregistry_sl                = $this->security->xss_clean($this->input->post('portofregistry_sl'));
    $change_intimation_remark         = $this->security->xss_clean($this->input->post('change_intimation_remark'));
    $change_inspection_report_upload  =  $this->security->xss_clean($_FILES["change_inspection_report_upload"]["name"]);
    if($change_inspection_report_upload)
    {
      echo "uploaded";
      $ins_path_parts = pathinfo($_FILES["change_inspection_report_upload"]["name"]);
      $ins_extension  = $ins_path_parts['extension'];

      echo $ins_file_name = 'OWNRCHG'.'_INSPRPT_Form11_'.$vessel_id.'_'.$date.'.'.$ins_extension;
      $target             = "./uploads/OwnershipChange_Intimation/".$ins_file_name;
      $ins_upd            = move_uploaded_file($_FILES["change_inspection_report_upload"]["tmp_name"], $target);
    }
    else
    {
      echo "not";
    }
    $change_inspection    =   pathinfo($_FILES['change_inspection_report_upload']['name']);
    if($change_inspection)
    {
    $extension            =   $change_inspection['extension'];
    }
    else
    {
    $extension  ="";
    }
    
      /*$pdf_name=$vessel_id.'_'.$intimation_sl.'_'.$survey_defects_sl.'_'.$random_number.'.'.$extension;
    copy($_FILES["defect_intimation"]["tmp_name"], "./uploads/defects/".$pdf_name);*/


    if($process_id==39)
    {
            $data_reg_intimation= array(
            'vessel_id'                                =>$vessel_id,
            'registration_intimation_type_id'          => 3,
            'registration_intimation_place_id'         => $portofregistry_sl, 
            'registration_intimation_remark'           => $change_intimation_remark,
            'registration_inspection_report_upload'    => $ins_file_name,
            'registration_inspection_date'             => $change_inspection_date,
            'registration_inspection_status'           => 1,
            'registration_inspection_created_user_id'  => $user_id,
            'registration_inspection_created_timestamp'=>$date,
            'registration_inspection_created_ipaddress'=>$ip); //print_r($data_reg_intimation);
         $insert_intimation = $this->Survey_model->insert_doc('a5_tbl_registration_intimation', $data_reg_intimation);

         $intimation_data   = array('registration_inspection_status'=>0);


          $data_insert=array(
          'vessel_id'         => $vessel_id,
          'process_id'        => $process_id,
          'survey_id'         => $survey_id,
          'current_status_id' => 7,
          'current_position'  => $current_position,
          'user_id'           => $sess_usr_id,
          'previous_module_id'=> $processflow_sl,
          'status'            => $status,
          'status_change_date'=> $status_change_date
          );//print_r($data_insert);


          $data_update = array('status'=>0);

          $data_survey_status=array(
          'process_id'        => $process_id,
          'survey_id'         => $survey_id,
          'current_status_id' => 7,
          'sending_user_id'   => $sess_usr_id,
          'receiving_user_id' => $sess_usr_id);//print_r($data_survey_status);exit;


          $status_update      = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

          $intimation_update  = $this->Survey_model->update_registration_intimation('a5_tbl_registration_intimation', $intimation_data,$registration_intimation_sl);

          $process_update     = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
          $process_insert     = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

      if($insert_intimation && $status_update && $process_update && $process_insert && $intimation_update)
      {
        //redirect("Kiv_Ctrl/Bookofregistration/raHome");
        ///get user mail////
            $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($user_id_owner);
            if(!empty($user_mail_id))
            {
              foreach($user_mail_id as $mail_res){
                $user_mail    = $mail_res['user_email'];
                $user_name    = $mail_res['user_name'];
                $user_mob     = $mail_res['user_mobile_number'];
              }
            }
           

            $own_refno          =   $this->Vessel_change_model->get_buyer_details($vessel_id);
                if(!empty($own_refno))
                {
                  foreach($own_refno as $own_res)
                  {
                    $refno        = $own_res['ref_number'];
                    $main_id        = $own_res['vesselmain_sl'];
                    $reg_no       = $own_res['vesselmain_reg_number'];
                    $vessel       = $own_res['vesselmain_vessel_name'];
                    $buyer       = $own_res['transfer_buyer_id'];
                    $portofreg       = $own_res['vesselmain_portofregistry_id'];
                    if($buyer!=0){
                      $buyer_det    =   $this->Vessel_change_model->get_customer_details($buyer);
                      foreach($buyer_det as $buyer_det_res){
                        $buyer_name = $buyer_det_res['user_master_fullname'];
                      }
                    } else {
                      $buyer_name = "{Unregistered User}";
                    }
                    $seller       = $own_res['transfer_seller_id'];
                    $seller_det    =   $this->Vessel_change_model->get_customer_details($seller);
                    foreach($seller_det as $seller_det_res){
                      $seller_name = $seller_det_res['user_master_fullname'];
                    }
                   
                  }
                }
                $place =   $this->Vessel_change_model->get_registry_port_id($portofregistry_sl);
                foreach($place as $place_res){
                  $placeofvisit  = $place_res['vchr_portoffice_name'];
                }
                $portna       =   $this->Vessel_change_model->get_registry_port_id($portofreg); 
                foreach($portna as $port_res){
                  $port_name  = $port_res['vchr_portoffice_name'];
                }

                
                $payment     =  $this->Vessel_change_model->get_payment_details($payment_sl,$vessel_id);
                foreach($payment as $pay_res){
                  $amount  = $pay_res['dd_amount'];
                }
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
            
            $change_inspection_date_exp  = explode('-',$change_inspection_date);
            $change_inspection_date_fnl  = $change_inspection_date_exp[2].'-'.$change_inspection_date_exp[1].'-'.$change_inspection_date_exp[0];
            $message = 'Dear '.$seller_name.',<br/><br/>
              With respect to Ownership Change, Registering Authority will verify your request on '.$change_inspection_date_fnl.' at '.$placeofvisit.'. You are hereby requested to be present for the same. Any change in schedule will be intimated through your registered mobile number and email id. <br/><br/>

            Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

            Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

            For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

            Warm Regards<br/><br/>

            Kerala Maritime Board ';
                $smsmsg = 'Registering Authority will visit on '.$change_inspection_date_fnl.' at '.$placeofvisit.' for Name Change of '.$reg_no.'. Reference Number:  '.$refno;  

            //$message = 'The Ownership Change (Ref. No:'.$refno.') Intimation for the Vessel has been sent by the Registering Authority. Please Verify for further Processing.';
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('kivportinfo@gmail.com'); // change it to yours
            //$this->email->to($user_mail);// change it to yours
            $this->email->to('deepthi.nh@gmail.com');

            $this->email->subject('Intimation of visit by Registering Authority on '.$change_inspection_date_fnl.' at '.$placeofvisit.' for Ownership Change -reg.');
            $this->email->message($message);
            if($this->email->send())
            { //echo "success";redirect("Kiv_Ctrl/Bookofregistration/raHome");
            // <!------------code for send SMS starts--------------->
              $this->load->model('Kiv_models/Vessel_change_model');
              //$mobil="9809119144";
              $mobil=$user_mob;
              //$stat = $this->Vessel_change_model->sendSms($smsmsg,$mobil);
              redirect("Kiv_Ctrl/Bookofregistration/raHome");
              //print_r($stat);exit;
              //echo json_encode("success");
              //redirect("Kiv_Ctrl/Bookofregistration/raHome");
              
              /*------------code for send SMS ends---------------*/
            }
            else
            {
              show_error($this->email->print_debugger());
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
public function ownershipchange_req_list()
{

  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id        = $this->session->userdata('customer_id');
  $survey_user_id     = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id) && (($user_type_id==14) || ($user_type_id==11) ))
  //if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'ownershipchange_req_list', 'page' => 'ownershipchange_req_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Bookofregistration_model');
    $this->load->model('Kiv_models/Vessel_change_model');

    if($user_type_id==14){
      $ownerchange_det       =  $this->Vessel_change_model->get_vesselownerchange_details_ra_vw($sess_usr_id);
    } else {
    $ownerchange_det         =  $this->Vessel_change_model->get_vesselownerchange_details($sess_usr_id);
    }
    $data['ownerchange_det'] =  $ownerchange_det; //print_r($namechange_det);exit;
    
    $data = $data + $this->data;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/ownershipchange_req_list',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');

  } 
  else
  {
    redirect('Main_login/index');        
  }

} 
public function view_form18_intimation()
{
/* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');

  $vessel_id1     = $this->uri->segment(4);
  
  $vessel_id         = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id         = $this->encrypt->decode($vessel_id); 

 
  $survey_id =0;
  $process_id=39;
  $status    =1;

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'view_form18_intimation', 'page' => 'view_form18_intimation', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $initimat_data         =   $this->Vessel_change_model->get_ownerchange_intimation_det($vessel_id,$survey_id,$process_id,$status);
    $data['initimat_data'] = $initimat_data;
  //print_r($initimat_data);exit;
    $vessel_change_det                = $this->Vessel_change_model->get_vesselownerchange_details_ra($vessel_id);
    $data['vessel_change_det']        = $vessel_change_det;
    $payment_det                      = $this->Vessel_change_model->get_vesselownerchange_payment_ra($vessel_id);
    $data['payment_det']              = $payment_det;
    
      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/view_form18_intimation',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
    
  }
  else
  {
    redirect('Main_login/index');
  }
  
}
public function form18_certificate()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id) && (($user_type_id==11) || ($user_type_id==12) || ($user_type_id==13) || ($user_type_id==14)))
  {
  $this->load->model('Kiv_models/Vessel_change_model');
  $vessel_id1     = $this->uri->segment(4);

  $vessel_id      = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id      = $this->encrypt->decode($vessel_id); 
  
  //$this->load->view('Kiv_views/dash/form11_certificate_view',$data);
  $this->load->library('Pdf.php');
  $pdf =  $this->pdf->load();
  $pdf->allow_charset_conversion=true;  // Set by default to TRUE
  $pdf->charset_in='UTF-8';
  $pdf->autoLangToFont = true;

  $pdf->showImageErrors = true;
  ini_set('memory_limit', '256M');

  $pdfFilePath = "form18_certificate_".$vessel_id.".pdf";   
  $html = $this->load->view('Kiv_views/dash/form18_certificate_view',$vessel_id,true);
  $output=$pdf->WriteHTML($html);
  $pdf->Output($output.$pdfFilePath, 'D');
  exit(); 
   }
  else
  {
    redirect('Main_login/index');
  }
}
function form_ownership_insertion()
{ //print_r($_POST);exit;
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  { 
    $data     = array('title' => 'form_ownership_insertion', 'page' => 'form_ownership_insertion', 'errorCls' => NULL, 'post' => $this->input->post());
    $data     = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $ip       = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date     = date('Y-m-d h:i:s', time()); 
    $reg_date = date('Y-m-d');
    $status_change_date = $date;

    $survey_id =0;
    $process_id=39;
    $status    =1;

    $vessel_id               = $this->security->xss_clean($this->input->post('vessel_id'));
    $vessel_name             = $this->security->xss_clean($this->input->post('vessel_name'));
    $transfer_buyer_name     = $this->security->xss_clean($this->input->post('transfer_buyer_name'));
    $transfer_buyer_address  = $this->security->xss_clean($this->input->post('transfer_buyer_address'));
    $transfer_buyer_mobile   = $this->security->xss_clean($this->input->post('transfer_buyer_mobile'));
    $transfer_buyer_email_id = $this->security->xss_clean($this->input->post('transfer_buyer_email_id'));
    $transfer_buyer_id       = $this->security->xss_clean($this->input->post('transfer_buyer_id'));
    $transfer_buyer_usertyp  = $this->security->xss_clean($this->input->post('transfer_buyer_usertyp'));
    $registered_date1        = $this->security->xss_clean($this->input->post('registered_date'));
    $registered_date         = date("Y-m-d", strtotime($registered_date1));

    $approve_status          = $this->security->xss_clean($this->input->post('approve_status'));

    $process_id               = $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id                = $this->security->xss_clean($this->input->post('survey_id'));
    $processflow_sl           = $this->security->xss_clean($this->input->post('processflow_sl'));
    $status_details_sl        = $this->security->xss_clean($this->input->post('status_details_sl'));
    $current_position         = $this->security->xss_clean($this->input->post('current_position'));
    $user_id                  = $this->security->xss_clean($this->input->post('user_sl_ra'));
    $registration_intimation_sl=  $this->security->xss_clean($this->input->post('registration_intimation_sl'));
    $user_id_owner            = $this->security->xss_clean($this->input->post('user_id_owner'));
    $user_type_id_owner       = $this->security->xss_clean($this->input->post('user_type_id_owner'));
    $current_status_id        = $this->security->xss_clean($this->input->post('current_status_id'));

    $vessel_main              =   $this->Vessel_change_model->get_vessel_main($vessel_id);
    $data['vessel_main']      =   $vessel_main;
    if(!empty($vessel_main))
    {
      $vesselmain_sl          =   $vessel_main[0]['vesselmain_sl'];
    }
    //print_r($_POST);exit;
    if(!empty($approve_status)){
      if($approve_status==5){
        //$data_mainupdatee  = array('processing_status'=>0);
        //////namechange_log table 
        $data_ownerchg_log=array(
          'vessel_id'               => $vessel_id,
          'change_type'             => 2,
          'transfer_buyer_name'     => $transfer_buyer_name,
          'transfer_buyer_address'  => $transfer_buyer_address,
          'transfer_buyer_mobile'   => $transfer_buyer_mobile,
          'transfer_buyer_email_id' => $transfer_buyer_email_id,
          'transfer_buyer_id'       => $transfer_buyer_id,
          'transfer_seller_id'      => $user_id_owner,
          'registered_date'         => $registered_date,
          'approved_date'           => $reg_date,
          'status'                  => 1

        );//print_r($data_ownerchg_log);exit;
        ///////ownerchange table
        $data_ownerchg=array(
          'transfer_approve_date'       => $reg_date,
          'transfer_approve_id'         => $sess_usr_id,
          'transfer_changepending_status'=> 2,
          'transfer_approve_ipaddress'  => $ip
        );//print_r($data_ownerchg);exit;
        ///////vesseldetails table
        $data_vesseldet=array(
          'vessel_user_id'           => $transfer_buyer_id,
          'vessel_created_user_id'   => $transfer_buyer_id,
          'vessel_created_ipaddress' => $ip
        );//print_r($data_vesseldet);exit;
        ///////vesselmain table
        /////process flow start indication---- tb_vessel_main processing_status to be changed as 1
        $data_vesselmain=array(
          'vesselmain_owner_id'      => $transfer_buyer_id,
          'processing_status'        => 0,
          'vesselmain_owner_req'      => 1
        );//print_r($data_vesselmain);exit;
        ///kiv_uservessel
        $data_uservessel=array(
          'user_id'                => $transfer_buyer_id,
          'created_user_id'        => $transfer_buyer_id,
          'created_ipaddress'      => $ip
        );
        ///////processflow table
        $data_insert=array(
          'vessel_id'         => $vessel_id,
          'process_id'        => $process_id,
          'survey_id'         => $survey_id,
          'current_status_id' => $approve_status,
          'current_position'  => $transfer_buyer_usertyp,
          'user_id'           => $transfer_buyer_id,
          'previous_module_id'=> $processflow_sl,
          'status'            => $status,
          'status_change_date'=> $status_change_date
        );//print_r($data_insert);exit;
        /////////processflow previous flow status update
        $data_update = array('status'=>0);
        //////////status details table
        $data_survey_status=array(
          'process_id'        => $process_id,
          'survey_id'         => $survey_id,
          'current_status_id' => $approve_status,
          'sending_user_id'   => $sess_usr_id,
          'receiving_user_id' => $transfer_buyer_id
        );//print_r($data_survey_status);exit;
        ///log table check
        $check_ownerchangelog = $this->Vessel_change_model->checkowner_vessel($vessel_id);
        if(!empty($check_ownerchangelog))
        {
           $approved_date     = $check_ownerchangelog[0]['approved_date'];
        }
        $count_rws            = count($check_ownerchangelog); 
        if($count_rws>0){
          $data_log = array('status'=>0);
          $log_update_status  = $this->Vessel_change_model->update_namelog_status('tbl_transfer_ownershipchange_log',$data_log, $vessel_id);
          if($log_update_status){
            $data_ownerchgupd_log=array(
              'vessel_id'               => $vessel_id,
              'change_type'             => 2,
              'transfer_buyer_name'     => $transfer_buyer_name,
              'transfer_buyer_address'  => $transfer_buyer_address,
              'transfer_buyer_mobile'   => $transfer_buyer_mobile,
              'transfer_buyer_email_id' => $transfer_buyer_email_id,
              'transfer_buyer_id'       => $transfer_buyer_id,
              'transfer_seller_id'      => $user_id_owner,
              'registered_date'         => $registered_date,
              'approved_date'           => $reg_date,
              'status'                  => 1

            );
            $insertownerlog    = $this->security->xss_clean($data_ownerchgupd_log);         
            $insertownerlog_res= $this->db->insert('tbl_transfer_ownershipchange_log', $insertownerlog);
          }
        } else {
          $insertownerlog      = $this->security->xss_clean($data_ownerchg_log);         
          $insertownerlog_res  = $this->db->insert('tbl_transfer_ownershipchange_log', $insertownerlog);
        }
        ///vesselmain
         //$vesselmain_update=$this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdatee, $vesselmain_sl);
        ///ownerchange 
        $ownerchange_upd       = $this->Vessel_change_model->update_vessel_ownchg('tbl_transfer_ownershipchange',$data_ownerchg, $vessel_id, $vesselmain_sl);
        ///vessel details
        $vesseldet_upd        = $this->Vessel_change_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vesseldet, $vessel_id);
        ///vesselmain
        $vesselmain_upd       = $this->Vessel_change_model->update_tbl_vessel_main('tb_vessel_main',$data_vesselmain, $vessel_id, $vesselmain_sl);
        ///kiv_uservessel
        $uservessel_upd       = $this->Vessel_change_model->update_tbl_user_vessel('tbl_kiv_user_vessel',$data_uservessel, $vessel_id);

        $status_update      = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $process_update     = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert     = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        if($insertownerlog_res && $ownerchange_upd && $vesseldet_upd && $vesselmain_upd && $status_update && $process_update && $process_insert)
         {
          echo "1";
         }
         else
         {
          echo "0";
         }
        } else {
          $data_ownerchg=array(
            'transfer_status'=> 2
          );
           $data_vesselmain=array(
            'processing_status'        => 0
          );
          $data_insert=array(
            'vessel_id'         => $vessel_id,
            'process_id'        => $process_id,
            'survey_id'         => $survey_id,
            'current_status_id' => $approve_status,
            'current_position'  => $user_type_id_owner,
            'user_id'           => $user_id_owner,
            'previous_module_id'=> $processflow_sl,
            'status'            => $status,
            'status_change_date'=> $status_change_date
          );//print_r($data_insert);exit;
          /////////processfloe previous flow status update
          $data_update = array('status'=>0);
          //////////status details table
          $data_survey_status=array(
            'process_id'        => $process_id,
            'survey_id'         => $survey_id,
            'current_status_id' => $approve_status,
            'sending_user_id'   => $sess_usr_id,
            'receiving_user_id' => $user_id_owner
          );
          $ownerchange_upd       = $this->Vessel_change_model->update_vessel_ownchg('tbl_transfer_ownershipchange',$data_ownerchg, $vessel_id, $vesselmain_sl);
          $vesselmain_upd       = $this->Vessel_change_model->update_tbl_vessel_main('tb_vessel_main',$data_vesselmain, $vessel_id, $vesselmain_sl);
          $status_update      = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

          $process_update     = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
          $process_insert     = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
          if($ownerchange_upd && $vesselmain_upd && $status_update && $process_update && $process_insert)
           {
            echo "1";
           }
           else
           {
            echo "0";
           }
        }
    }
  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function generate_certificate_own()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id      = $this->session->userdata('customer_id');
  $survey_user_id   = $this->session->userdata('survey_user_id');

   $vessel_id        = $this->uri->segment(4);
  /*$processflow_sl   = $this->uri->segment(5);
  $status_details_sl= $this->uri->segment(6);*/

  

  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'generate_certificate_own', 'page' => 'generate_certificate_own', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    

    $vessel_details_viewpage         = $this->Vessel_change_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;

    @$id                      = $vessel_details_viewpage[0]['user_id'];
    
   //-----------Get customer name and address--------------//
    $customer_details         = $this->Vessel_change_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;

    /*$initial_data             = $this->Vessel_change_model->get_process_flow($processflow_sl);
    $data['initial_data']     = $initial_data;

    $intimation_type_id=2;

    $registration_intimation          = $this->Vessel_change_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']  = $registration_intimation;

    $survey_id=1;
     //----------Hull Details--------//
   
    $hull_details            = $this->Vessel_change_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']    = $hull_details;

   
   //----------Engine Details--------//
   
   $engine_details           = $this->Survey_model->get_engine_details($vessel_id,$survey_id);
   $data['engine_details']   = $engine_details;*/




    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/generate_certificate_ownchg',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');

  }
  else
  {
    redirect('Main_login/index'); 
  }
}
///////////////////////Vessel Ownership Change------End---------//////////////////////////
///////////////////////Transfer of Vessel----------Start--------/////////////////////////
public function transfervessel_list()
{ 
   /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
   $customer_id                       = $this->session->userdata('customer_id');
   $survey_user_id                    = $this->session->userdata('survey_user_id');

   
   if(!empty($sess_usr_id)&&($user_type_id==11))
   {
      $data = array('title' => 'transfervessel_list', 'page' => 'transfervessel_list', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      $vessel_list                    = $this->Vessel_change_model->get_vesselchange_List($sess_usr_id);
      $data['vessel_list']            = $vessel_list;//print_r($vessel_list);
      $count                          = count($vessel_list);
      $data['count']                  = $count;
      $data                           = $data + $this->data;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/transfervessel_list',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
   }
   else
   {
          redirect('Main_login/index');        
   }

}
public function transfervessel()
{ 
   /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                      = $this->session->userdata('customer_id');
    $survey_user_id                   = $this->session->userdata('survey_user_id');
  
    $vessel_id1                       = $this->uri->segment(4);
    $processflow_sl1                  = $this->uri->segment(5);
    $status_details_sl1               = $this->uri->segment(6);

    $vessel_id                        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
    $vessel_id                        = $this->encrypt->decode($vessel_id); 

    $processflow_sl                   = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
    $processflow_sl                   = $this->encrypt->decode($processflow_sl); 

    $status_details_sl                = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
    $status_details_sl                = $this->encrypt->decode($status_details_sl); 

   
   if(!empty($sess_usr_id)&&($user_type_id==11))
   {
      $data = array('title' => 'transfervessel', 'page' => 'transfervessel', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      $vesselDet                      = $this->Vessel_change_model->get_vesselDet($vessel_id);
      $data['vesselDet']              = $vesselDet; //print_r($vesselDet);exit;
      if(!empty($vesselDet))
      {
        $vessel_type_id               = $vesselDet[0]['vessel_type_id'];
        $vessel_subtype_id            = $vesselDet[0]['vessel_subtype_id'];
      }
 


      $process_data                   = $this->Vessel_change_model->get_process_flow_sl($vessel_id);
      $data['process_data']           = $process_data;
      if(!empty($process_data))
      {
        $status_change_date1          = $process_data[0]['status_change_date'];
      }
  //print_r($process_data);exit;

      $data['status_details_sl']      = $status_details_sl;
      $data['processflow_sl']         = $processflow_sl;

      $survey_id=0;

      $engine_details                 = $this->Vessel_change_model->get_engine_details($vessel_id,$survey_id);
      $data['engine_details']         = $engine_details;

      $no_of_engineset                = count($engine_details);


    
      //______________________________________________//
      //Master Data Population

      $registeringAuthority           = $this->Bookofregistration_model->get_registeringAuthority();
      $data['registeringAuthority']   = $registeringAuthority;//print_r($registeringAuthority);

      $insuranceCompany               = $this->Bookofregistration_model->get_insuranceCompany();
      $data['insuranceCompany']       = $insuranceCompany;

      $masClass                       = $this->Bookofregistration_model->get_masterClass();
      $data['masClass']               = $masClass;

      $plyingPort                     = $this->Bookofregistration_model->get_portofregistry();
      $data['plyingPort']             = $plyingPort;

      $states                         = $this->Vessel_change_model->get_all_states(); //print_r($states);
      $data['states']                 = $states;

      $vesselMasterDetails            = $this->Bookofregistration_model->get_crew_details($vessel_id,1);
      $data['vesselMasterDetails']    = $vesselMasterDetails;
      $vesselMasterDetails_count      = count($vesselMasterDetails);

  //___________________________TARIFF DETAILS____________________________________________//

      $status_change_date             = date("Y-m-d", strtotime($status_change_date1));
      $now                            = date("Y-m-d");
      $date1_ts                       = strtotime($status_change_date);
      $date2_ts                       = strtotime($now);
      $diff                           = $date2_ts - $date1_ts;
      $numberofdays1                  = round($diff / 86400);
      

      $form_id                        = 19;
      $activity_id                    = 8;
      //echo $activity_id.'==='.$form_id.'==='.$vessel_type_id.'==='.$vessel_subtype_id;
      $tariff_details                 = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
      $data1['tariff_details']        = $tariff_details; 
      if (!empty($tariff_details)) 
      {
        $tariff_amount1               = $tariff_details[0]['tariff_amount'];
        $tariff_min_amount            = $tariff_details[0]['tariff_min_amount'];
      }
      
      $tonnage_details                = $this->Vessel_change_model->get_tonnage_details($vessel_id);
      $data1['tonnage_details']       = $tonnage_details;//print_r($tonnage_details);exit;
      if(!empty($tonnage_details))
      {
        @$vessel_total_tonnage        = $tonnage_details[0]['vessel_total_tonnage'];
      }
      $amount1                        = $vessel_total_tonnage*$tariff_amount1;

      if($amount1<100)
      {
        $data['tariff_amount']        = $tariff_min_amount;
      }
      else
      {
        $data['tariff_amount']        = $amount1;
      }
      
      $data                           = $data + $this->data;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/transfervessel',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
   }
   else
   {
          redirect('Main_login/index');        
   }

}
function showpayment19($vessel_id)
{ 
    /*$vessel_sl                            = $this->session->userdata('vessel_id');
    if($vessel_sl=="")
    {
      $vessel_id                          = $this->security->xss_clean($this->input->post('vessel_id'));
    }
    else
    {
      $vessel_id                          = $vessel_sl;
    }
  echo $vessel_id;*/ 
    $transfer_type                          = $this->security->xss_clean($this->input->post('transfer_type'));
  //echo $transfer_type;exit;
    $vessel_condition                     = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition']             = $vessel_condition;//echo "Vsl--".$vessel_id;exit;
    //print_r($vessel_condition);
    if(!empty($vessel_condition))
    {
      $vessel_type_id                     = $vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id                  = $vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1                     = $vessel_condition[0]['vessel_length'];
      $hullmaterial_id                    = $vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id                = $vessel_condition[0]['engine_placement_id'];
    }

    $form_id                              = 19;
    if($transfer_type!=0){
      $activity_id                        = 8;
    } elseif ($transfer_type==0) {
      $activity_id                        = 12;
    }

    $tariff_details                       = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id); //print_r($tariff_details);exit;
    $data1['tariff_details']              = $tariff_details; 
    if (!empty($tariff_details)) 
    {
      $tariff_amount1                     = $tariff_details[0]['tariff_amount'];
      $tariff_min_amount                  = $tariff_details[0]['tariff_min_amount'];
    }
      
    $tonnage_details                      = $this->Vessel_change_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']             = $tonnage_details;//print_r($tonnage_details);exit;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage              = $tonnage_details[0]['vessel_total_tonnage'];
    }
     $amount1                              = $vessel_total_tonnage*$tariff_amount1; //exit;

    if($amount1<100)
    {
      //$data1['tariff_amount']              = $tariff_min_amount;
      $data1['tariff_amount']             = 1;
    }
    else
    {
      //$data1['tariff_amount']              = $amount1;
      $data1['tariff_amount']             = 1;
    }
 
    $this->load->view('Kiv_views/Ajax_payment_show.php',$data1);
}
function not_payment_details_form19()
{ //print_r($_POST);exit;
  $vessel_id                              =  $this->session->userdata('vessel_id');
 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                            =  $this->session->userdata('customer_id');
  $survey_user_id                         =  $this->session->userdata('survey_user_id');


  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
$this->load->model('Kiv_models/Survey_model');
    date_default_timezone_set("Asia/Kolkata");
    $date                                 =  date('Y-m-d h:i:s', time());

    $vessel_id                            =  $this->security->xss_clean($this->input->post('vessel_sl'));  
    $process_id                           =  $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id                            =  0;
    $current_status_id                    =  $this->security->xss_clean($this->input->post('current_status_id'));
    $current_position                     =  $this->security->xss_clean($this->input->post('current_position')); 
    $status_change_date                   =  $date;
    $processflow_sl                       =  $this->security->xss_clean($this->input->post('processflow_sl'));
    $user_id                              =  $this->security->xss_clean($this->input->post('user_id'));
    $status                               =  1;
    $status_details_sl                    =  $this->security->xss_clean($this->input->post('status_details_sl'));
    $ip                                   =  $_SERVER['REMOTE_ADDR'];
    
    $data_update=array(
      'status'=>0
    );
    $process_update                       =  $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);

    $data_process=array(
      'vessel_id'                         => $vessel_id,
      'process_id'                        => $process_id,
      'survey_id'                         => $survey_id,
      'current_status_id'                 => 8,
      'current_position'                  => $user_type_id,
      'user_id'                           => $sess_usr_id,
      'previous_module_id'                => $processflow_sl,
      'status'                            => $status,
      'status_change_date'                => $status_change_date 
    ); //print_r($data_process);exit;

    $data_status=array(
      'vessel_id'                         => $vessel_id,
      'process_id'                        => $process_id,
      'survey_id'                         => $survey_id,
      'current_status_id'                 => 8,
      'sending_user_id'                   => $sess_usr_id,
      'receiving_user_id'                 => $sess_usr_id,
    );//print_r($data_status);exit;

    $status_update                        =  $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_status,$status_details_sl);
    $insert_process                       =  $this->Vessel_change_model->insert_process_flow($data_process);
  
              
    if($insert_process && $status_update && $process_update)  
    {
      redirect('Kiv_Ctrl/Survey/SurveyHome');
    }       
            
  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function payment_details_form18_trans()
{
   /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                      = $this->session->userdata('customer_id');
    $survey_user_id                   = $this->session->userdata('survey_user_id');
  
    $vessel_id1                       = $this->uri->segment(4);
    $processflow_sl1                  = $this->uri->segment(5);
    $status_details_sl1               = $this->uri->segment(6);

    $vessel_id                        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
    $vessel_id                        = $this->encrypt->decode($vessel_id); 

    $processflow_sl                   = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
    $processflow_sl                   = $this->encrypt->decode($processflow_sl); 

    $status_details_sl                = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
    $status_details_sl                = $this->encrypt->decode($status_details_sl); 

   
   if(!empty($sess_usr_id)&&($user_type_id==11))
   {
      $data = array('title' => 'transfervessel', 'page' => 'transfervessel', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      $vesselDet                      = $this->Vessel_change_model->get_vesselDet($vessel_id);
      $data['vesselDet']              = $vesselDet; //print_r($vesselDet);exit;
      if(!empty($vesselDet))
      {
        $vessel_type_id               = $vesselDet[0]['vessel_type_id'];
        $vessel_subtype_id            = $vesselDet[0]['vessel_subtype_id'];
      }
 
      $process_data                   = $this->Vessel_change_model->get_process_flow_sl($vessel_id);
      $data['process_data']           = $process_data;
      if(!empty($process_data))
      {
        $status_change_date1          = $process_data[0]['status_change_date'];
      }
      //print_r($process_data);exit;
      $transfer_type         =   $this->Vessel_change_model->get_transfervessel_type($vessel_id); //print_r($transfer_type);
      $data['transfer_type'] = $transfer_type;
      if(!empty($transfer_type)){
        foreach ($transfer_type as $transtyp_res) {
          $trans_typ          = $transtyp_res['transfer_based_changetype'];
        }
      }  
      $data['status_details_sl']      = $status_details_sl;
      $data['processflow_sl']         = $processflow_sl;

      $survey_id=0;

      $engine_details                 = $this->Vessel_change_model->get_engine_details($vessel_id,$survey_id);
      $data['engine_details']         = $engine_details;

      $no_of_engineset                = count($engine_details);

      //______________________________________________//
      //Master Data Population

      $registeringAuthority           = $this->Bookofregistration_model->get_registeringAuthority();
      $data['registeringAuthority']   = $registeringAuthority;//print_r($registeringAuthority);

      $insuranceCompany               = $this->Bookofregistration_model->get_insuranceCompany();
      $data['insuranceCompany']       = $insuranceCompany;

      $masClass                       = $this->Bookofregistration_model->get_masterClass();
      $data['masClass']               = $masClass;

      $plyingPort                     = $this->Bookofregistration_model->get_portofregistry();
      $data['plyingPort']             = $plyingPort;

      $states                         = $this->Vessel_change_model->get_all_states(); //print_r($states);
      $data['states']                 = $states;

      $vesselMasterDetails            = $this->Bookofregistration_model->get_crew_details($vessel_id,1);
      $data['vesselMasterDetails']    = $vesselMasterDetails;
      $vesselMasterDetails_count      = count($vesselMasterDetails);

      $bank                           =  $this->Survey_model->get_bank_favoring();
      $data['bank']                   =  $bank;


      $portofregistry                 =  $this->Survey_model->get_portofregistry();
      $data['portofregistry']         =  $portofregistry;

  //___________________________TARIFF DETAILS____________________________________________//

      $status_change_date             = date("Y-m-d", strtotime($status_change_date1));
      $now                            = date("Y-m-d");
      $date1_ts                       = strtotime($status_change_date);
      $date2_ts                       = strtotime($now);
      $diff                           = $date2_ts - $date1_ts;
      $numberofdays1                  = round($diff / 86400);
      

      $form_id                        = 19;
      /*if($trans_typ!=0){
        $activity_id                  = 8;
      } elseif ($trans_typ==0) {
        $activity_id                  = 12;
      }*/
      $activity_id                    = 8;
      $tariff_details                 = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
      $data1['tariff_details']        = $tariff_details; 
      if (!empty($tariff_details)) 
      {
        $tariff_amount1               = $tariff_details[0]['tariff_amount'];
        $tariff_min_amount            = $tariff_details[0]['tariff_min_amount'];
      }
      
      $tonnage_details                = $this->Vessel_change_model->get_tonnage_details($vessel_id);
      $data1['tonnage_details']       = $tonnage_details;//print_r($tonnage_details);exit;
      if(!empty($tonnage_details))
      {
        @$vessel_total_tonnage        = $tonnage_details[0]['vessel_total_tonnage'];
      }
      $amount1                        = $vessel_total_tonnage*$tariff_amount1;

      if($amount1<100)
      {
        //$data['tariff_amount']        = $tariff_min_amount;
        $data['tariff_amount']        = 1;
      }
      else
      {
        //$data['tariff_amount']        = $amount1;
        $data['tariff_amount']        = 1;
      }


    if($this->input->post())
    { //print_r($_POST);print_r($_FILES);exit;
      date_default_timezone_set("Asia/Kolkata");
      $date                            = date('Y-m-d h:i:s', time());
      $ip                              = $_SERVER['REMOTE_ADDR'];
      $newDate                         = date("Y-m-d");

      $vessel_id                       = $this->security->xss_clean($this->input->post('vessel_sl'));
      $processflow_sl                  = $this->security->xss_clean($this->input->post('processflow_sl'));
      $status_details_sl               = $this->security->xss_clean($this->input->post('status_details_sl'));
      $vessel_registry_port_id         = $this->security->xss_clean($this->input->post('vessel_registry_port_id'));
      $tariff_amount                   = $this->security->xss_clean($this->input->post('dd_amount'));

      ///////
      $transfer_type                   = $this->security->xss_clean($this->input->post('transfer_type'));
      $data['transfer_type']           =  $transfer_type;
      //Within Kerala---->Start
      if($transfer_type==1){
        $owner_change                  = $this->security->xss_clean($this->input->post('owner_change'));
        //No Ownership Change
        if($owner_change==2){
          $portofregistry_slno         = $this->security->xss_clean($this->input->post('portofregistry_slno'));
          $changepending_status        = 2;
        } 
        //Ownership Change---->Start
        else {
          $newowner_mob                = $this->security->xss_clean($this->input->post('newowner_mob'));
          $newowner_mail               = $this->security->xss_clean($this->input->post('newowner_mail'));

          $profile_status              = $this->security->xss_clean($this->input->post('profile_status'));
          $buyer_id                    = $this->security->xss_clean($this->input->post('buyer_id'));
          ///---if user exists, status=2(profile created) and if it is a new buyer, status=1(no profile)---///
          if($profile_status>0){
            $changepending_status      = 2;
            $buyer_decl_upload         = $this->security->xss_clean($_FILES["buyer_decl_upload"]["name"]);
            $seller_decl_upload        = $this->security->xss_clean($_FILES["seller_decl_upload"]["name"]);
            $notary_upload             = $this->security->xss_clean($_FILES["notary_upload"]["name"]);
          } else if($profile_status==0){
            $changepending_status      = 1;
            $buyer_name                = $this->security->xss_clean($this->input->post('buyer_name'));
            $buyer_address             = $this->security->xss_clean($this->input->post('buyer_address'));
            $idcard_upload             = $this->security->xss_clean($_FILES["idcard_upload"]["name"]);
          }

          
          if($profile_status>0){
            //----seller declaration(start)---///
              
            if($seller_decl_upload)
            {
              //echo "uploaded";
              $inssller_path_parts     = pathinfo($_FILES["seller_decl_upload"]["name"]);
              $inssller_extension      = $inssller_path_parts['extension'];

              $inssller_file_name      = 'TNSFR'.'_SELRDECL_Form19_'.$vessel_id.'_'.$date.'.'.$inssller_extension; 
              $target                  = "./uploads/Transfer_Declaration/".$inssller_file_name;
              $ins_upd                 = move_uploaded_file($_FILES["seller_decl_upload"]["tmp_name"], $target);
            }
            else
            {
              $inssller_file_name      = '';
            }
            $seller_declaration        =   pathinfo($_FILES['seller_decl_upload']['name']);
            if($seller_declaration)
            {
              @$extension              =   $seller_declaration['extension'];
            }
            else
            {
              $extension               = "";
            }
            //----seller declaration(end)---///

            //----buyer declaration(start)---///

            if($buyer_decl_upload)
            {
              //echo "uploaded";
              $insbuyer_path_parts     = pathinfo($_FILES["buyer_decl_upload"]["name"]);
              $insbuyer_extension      = $insbuyer_path_parts['extension'];

              $insbuyer_file_name      = 'TNSFR'.'_BUYRDECL_Form19_'.$vessel_id.'_'.$date.'.'.$insbuyer_extension; 
              $target1                 = "./uploads/Transfer_Declaration/".$insbuyer_file_name;
              $ins_upd1                = move_uploaded_file($_FILES["buyer_decl_upload"]["tmp_name"], $target1);
            }
            else
            {
              $insbuyer_file_name      = '';
            }
            $buyer_declaration         = pathinfo($_FILES['buyer_decl_upload']['name']);
            if($buyer_declaration)
            {
              @$extension1             = $buyer_declaration['extension'];
            }
            else
            {
              $extension1              = "";
            }
            //----buyer declaration(end)---///

            //----Notary(start)---///
            if($notary_upload)
            {
              //echo "uploaded";
              $insnotary_path_parts    = pathinfo($_FILES["notary_upload"]["name"]);
              $insnotary_extension     = $insnotary_path_parts['extension'];

              $insnotary_file_name     = 'TNSFR'.'_NOTARY_Form19_'.$vessel_id.'_'.$date.'.'.$insnotary_extension; 
              $target2                 = "./uploads/Transfer_Declaration/".$insnotary_file_name;
              $ins_upd2                = move_uploaded_file($_FILES["notary_upload"]["tmp_name"], $target2);//exit;
            }
            else
            {
              $insnotary_file_name     = '';
            }
            $notary                    = pathinfo($_FILES['notary_upload']['name']);
            if($notary)
            {
              @$extension2             = $notary['extension'];
            }
            else
            {
              $extension2              = "";
            }
              //----Notary(end)---///
          } else  if($profile_status==0){
              //----ID Card(start)---///
            if($idcard_upload)
            {
              //echo "uploaded";
              $insidcard_path_parts    = pathinfo($_FILES["idcard_upload"]["name"]);
              $insidcard_extension     = $insidcard_path_parts['extension'];

              $insidcard_file_name     = 'TNSFR'.'_ID_Form19_'.$vessel_id.'_'.$date.'.'.$insidcard_extension; 
              $target3                 = "./uploads/Transfer_Declaration/".$insidcard_file_name;
              $ins_upd3                = move_uploaded_file($_FILES["idcard_upload"]["tmp_name"], $target3);//exit;
            }
            else
            {
              $insnotary_file_name     = '';
            }
            $idcard                    = pathinfo($_FILES['idcard_upload']['name']);
            if($idcard)
            {
              $extension3              = $idcard['extension'];
            }
            else
            {
              $extension3              = "";
            }
              //----ID Card(end)---///
          }
          $portofregistry_sl           = $this->security->xss_clean($this->input->post('portofregistry_sl'));
        }
        //Ownership Change---->End
      }
      //Within Kerala---->End
      //Outside Kerala---->Start 
      else { 
         
        $changepending_status          = 1;
        $state_sl                      = $this->security->xss_clean($this->input->post('state_sl'));
        $buyer_name_out                = $this->security->xss_clean($this->input->post('buyer_name_out'));
        $buyer_address_out             = $this->security->xss_clean($this->input->post('buyer_address_out'));
        $newowner_mob_out              = $this->security->xss_clean($this->input->post('newowner_mob_out'));
        $newowner_mail_out             = $this->security->xss_clean($this->input->post('newowner_mail_out'));
        $buyer_decl_upload_out         = $this->security->xss_clean($_FILES["buyer_decl_upload_out"]["name"]);
        $seller_decl_upload_out        = $this->security->xss_clean($_FILES["seller_decl_upload_out"]["name"]);
        $idcard_upload_out             = $this->security->xss_clean($_FILES["idcard_upload_out"]["name"]);

        //----seller declaration(start)---///
              
        if($seller_decl_upload_out)
        {
        
          $inssller_path_parts         = pathinfo($_FILES["seller_decl_upload_out"]["name"]);
          $inssller_extension          = $inssller_path_parts['extension'];

          $inssller_file_name          = 'TNSFROUT'.'_SELRDECL_Form19_'.$vessel_id.'_'.$date.'.'.$inssller_extension; 
          $target                      = "./uploads/Transfer_Declaration/".$inssller_file_name;
          $ins_upd                     = move_uploaded_file($_FILES["seller_decl_upload_out"]["tmp_name"], $target);
        }
        else
        {
          $inssller_file_name          = '';
        }
        $seller_declaration            = pathinfo($_FILES['seller_decl_upload_out']['name']);
        if($seller_declaration)
        {
          @$extension                  = $seller_declaration['extension'];
        }
        else
        {
          $extension                   = "";
        }
        //----seller declaration(end)---///
        //----buyer declaration(start)---///

        if($buyer_decl_upload_out)
        {
          //echo "uploaded";
          $insbuyer_path_parts         = pathinfo($_FILES["buyer_decl_upload_out"]["name"]);
          $insbuyer_extension          = $insbuyer_path_parts['extension'];

          $insbuyer_file_name          = 'TNSFROUT'.'_BUYRDECL_Form19_'.$vessel_id.'_'.$date.'.'.$insbuyer_extension; 
          $target1                     = "./uploads/Transfer_Declaration/".$insbuyer_file_name;
          $ins_upd1                    = move_uploaded_file($_FILES["buyer_decl_upload_out"]["tmp_name"], $target1);
        }
        else
        {
          $insbuyer_file_name          = '';
        }
          $buyer_declaration           = pathinfo($_FILES['buyer_decl_upload_out']['name']);
        if($buyer_declaration)
        {
          @$extension1                 = $buyer_declaration['extension'];
        }
        else
        {
          $extension1                  = "";
        }
        //----buyer declaration(end)---///
        //----ID Card(start)---///
        if($idcard_upload_out)
        {
          //echo "uploaded";
          $insidcard_path_parts        = pathinfo($_FILES["idcard_upload_out"]["name"]);
          $insidcard_extension         = $insidcard_path_parts['extension'];

          $insidcard_file_name         = 'TNSFROUT'.'_ID_Form19_'.$vessel_id.'_'.$date.'.'.$insidcard_extension; 
          $target3                     = "./uploads/Transfer_Declaration/".$insidcard_file_name;
          $ins_upd3                    = move_uploaded_file($_FILES["idcard_upload_out"]["tmp_name"], $target3);//exit;
        }
        else
        {
          $insnotary_file_name         = '';
        }
        $idcard                        = pathinfo($_FILES['idcard_upload_out']['name']);
        if($idcard)
        {
          $extension3                  = $idcard['extension'];
        }
        else
        {
          $extension3                  = "";
        }
        //----ID Card(end)---///
      }
      //Outside Kerala---->End
      //////
      //////////////////////Reference Number For Transfer Vessel Process (Start)////////////////////////////
        if($transfer_type==1){
          if($owner_change==2){
            $tsfr=1;
            $based=1;
            $code="TVK";
          } else {
            $tsfr=1;
            $based=3;
            $code="TOK";
          }
        } else{
          $tsfr=1;
          $based=0;
          $code="TVO";
        }         
        $tnsfrvsl_rws                  = $this->Vessel_change_model->get_tnsfrvsl_rws($tsfr,$based);
        $cnttnsfr_rws                  = count($tnsfrvsl_rws);
        if($cnttnsfr_rws==0){
          $value                       = "1";
        } elseif ($cnttnsfr_rws>0) {
          $tnsfrvsl_last_refno         = $this->Vessel_change_model->get_tnsfrvsl_ref_number($tsfr,$based);
          foreach ($tnsfrvsl_last_refno as $ref_res) {
            $ref_no                   = $ref_res['ref_number'];
          }
          $ref_exp                    = explode('_', $ref_no);
          $ref_val                    = $ref_exp[1];
          $value                      = $ref_val + 1;
        }
        if($value<10){
          $value                      = "00".$value;
        } elseif ($value<100) {
          $value                      = "0".$value;
        } else {
          $value                      = $value;
        }
        $yr                           = date('Y');
        $ref_number                   = $code."_".$value."_".$vessel_id.$yr; 
        //////////////////////Reference Number For Transfer Vessel Process (End)////////////////////////////
      $vessel_main                     = $this->Vessel_change_model->get_vessel_main($vessel_id);
      $data['vessel_main']             = $vessel_main;
      if(!empty($vessel_main))
      {
        $vesselmain_sl                 = $vessel_main[0]['vesselmain_sl'];
      }
      
      $check_transfervessel            = $this->Vessel_change_model->get_transfervessel_details($vessel_id);
      $count_rws                       = count($check_transfervessel); 

      if($count_rws>0){
        $data_own = array(
          'transfer_status'=>0
        );
        $transfervessel_update_status  = $this->Vessel_change_model->update_transfervessel_status('tbl_transfer_ownershipchange',$data_own, $vessel_id);
          if($transfervessel_update_status){
            if($transfer_type==1){
              if($owner_change==2){
                //echo $portofregistry_slno;exit;
                $data_transferupd=array(
                  'transfer_changetype'             =>  1,
                  'transfer_based_changetype'       =>  1,
                  'transfer_portofregistry_from'    =>  $vessel_registry_port_id,
                  'transfer_portofregistry_to'      =>  $portofregistry_slno,
                  'transfer_vessel_id'              =>  $vessel_id,
                  'transfer_vessel_main_id'         =>  $vesselmain_sl,
                  'ref_number'                      =>  $ref_number,
                  'transfer_req_date'               =>  $newDate,
                  'transfer_changepending_status'   =>  $changepending_status,
                  'transfer_status'                 =>  1
                );//echo "1";print_r($data_transferupd); exit;
              } else {
                if($profile_status>0){
                  $data_transferupd=array(
                    'transfer_changetype'           =>  1,
                    'transfer_based_changetype'     =>  3,
                    'transfer_portofregistry_from'  =>  $vessel_registry_port_id,
                    'transfer_portofregistry_to'    =>  $portofregistry_sl,
                    'transfer_vessel_id'            =>  $vessel_id,
                    'transfer_vessel_main_id'       =>  $vesselmain_sl,
                    'ref_number'                    =>  $ref_number,
                    'transfer_req_date'             =>  $newDate,
                    'transfer_changepending_status' =>  $changepending_status,
                    'transfer_seller_declaration'   =>  $inssller_file_name,
                    'transfer_buyer_declaration'    =>  $insbuyer_file_name,
                    'transfer_notary'               =>  $insnotary_file_name,
                    'transfer_buyer_id'             =>  $buyer_id,
                    'transfer_buyer_mobile'         =>  $newowner_mob,
                    'transfer_buyer_email_id'       =>  $newowner_mail,
                    'transfer_seller_id'            =>  $sess_usr_id,
                    'transfer_status'               =>  1
                  );//print_r($ownerdet); exit;

                } else {
                  $data_transferupd=array(
                    'transfer_changetype'           =>  1,
                    'transfer_based_changetype'     =>  3,
                    'transfer_portofregistry_from'  =>  $vessel_registry_port_id,
                    'transfer_portofregistry_to'    =>  $portofregistry_sl,
                    'transfer_vessel_id'            =>  $vessel_id,
                    'transfer_vessel_main_id'       =>  $vesselmain_sl,
                    'ref_number'                    =>  $ref_number,
                    'transfer_req_date'             =>  $newDate,
                    'transfer_changepending_status' =>  $changepending_status,
                    'transfer_buyer_name'           =>  $buyer_name,
                    'transfer_buyer_address'        =>  $buyer_address,
                    'transfer_buyer_idcard'         =>  $insidcard_file_name,
                    'transfer_buyer_mobile'         =>  $newowner_mob,
                    'transfer_buyer_email_id'       =>  $newowner_mail,
                    'transfer_seller_id'            =>  $sess_usr_id,
                    'transfer_status'               =>  1
                  );//print_r($ownerdet); exit;

                }
              }
            } else if($transfer_type==2){
              $data_transferupd=array(
                'transfer_changetype'               =>  1,
                'transfer_based_changetype'         =>  0,
                'transfer_portofregistry_from'      =>  $vessel_registry_port_id,
                'transfer_state_id'                 =>  $state_sl,
                'transfer_vessel_id'                =>  $vessel_id,
                'transfer_vessel_main_id'           =>  $vesselmain_sl,
                'ref_number'                        =>  $ref_number,
                'transfer_req_date'                 =>  $newDate,
                'transfer_changepending_status'     =>  $changepending_status,
                'transfer_buyer_name'               =>  $buyer_name_out,
                'transfer_buyer_address'            =>  $buyer_address_out,
                'transfer_buyer_mobile'             =>  $newowner_mob_out,
                'transfer_buyer_email_id'           =>  $newowner_mail_out,
                'transfer_seller_declaration'       =>  $inssller_file_name,
                'transfer_buyer_declaration'        =>  $insbuyer_file_name,
                'transfer_buyer_idcard'             =>  $insidcard_file_name,
                'transfer_seller_id'                =>  $sess_usr_id,
                'transfer_status'                   =>  1
              );

            }
            //print_r($data_transferupd);exit;
            $insertOwnerDet            = $this->security->xss_clean($data_transferupd);         
            $insertOwnerDet_res        = $this->db->insert('tbl_transfer_ownershipchange', $insertOwnerDet);
          }
         } else { 
       //$update_change
          if($transfer_type==1){
              if($owner_change==2){
                $data_transferupd=array(
                  'transfer_changetype'             =>  1,
                  'transfer_based_changetype'       =>  1,
                  'transfer_portofregistry_from'    =>  $vessel_registry_port_id,
                  'transfer_portofregistry_to'      =>  $portofregistry_slno,
                  'transfer_vessel_id'              =>  $vessel_id,
                  'transfer_vessel_main_id'         =>  $vesselmain_sl,
                  'ref_number'                      =>  $ref_number,
                  'transfer_req_date'               =>  $newDate,
                  'transfer_changepending_status'   =>  $changepending_status,
                  'transfer_status'                 =>  1
                );//echo "2";print_r($data_transferupd); exit;
              } else {
                if($profile_status>0){
                  $data_transferupd=array(
                    'transfer_changetype'           =>  1,
                    'transfer_based_changetype'     =>  3,
                    'transfer_portofregistry_from'  =>  $vessel_registry_port_id,
                    'transfer_portofregistry_to'    =>  $portofregistry_sl,
                    'transfer_vessel_id'            =>  $vessel_id,
                    'transfer_vessel_main_id'       =>  $vesselmain_sl,
                    'ref_number'                    =>  $ref_number,
                    'transfer_req_date'             =>  $newDate,
                    'transfer_changepending_status' =>  $changepending_status,
                    'transfer_seller_declaration'   =>  $inssller_file_name,
                    'transfer_buyer_declaration'    =>  $insbuyer_file_name,
                    'transfer_notary'               =>  $insnotary_file_name,
                    'transfer_buyer_id'             =>  $buyer_id,
                    'transfer_buyer_mobile'         =>  $newowner_mob,
                    'transfer_buyer_email_id'       =>  $newowner_mail,
                    'transfer_seller_id'            =>  $sess_usr_id,
                    'transfer_status'               =>  1
                  );//print_r($ownerdet); exit;

                } else {
                  $data_transferupd=array(
                    'transfer_changetype'           =>  1,
                    'transfer_based_changetype'     =>  3,
                    'transfer_portofregistry_from'  =>  $vessel_registry_port_id,
                    'transfer_portofregistry_to'    =>  $portofregistry_sl,
                    'transfer_vessel_id'            =>  $vessel_id,
                    'transfer_vessel_main_id'       =>  $vesselmain_sl,
                    'ref_number'                    =>  $ref_number,
                    'transfer_req_date'             =>  $newDate,
                    'transfer_changepending_status' =>  $changepending_status,
                    'transfer_buyer_name'           =>  $buyer_name,
                    'transfer_buyer_address'        =>  $buyer_address,
                    'transfer_buyer_idcard'         =>  $insidcard_file_name,
                    'transfer_buyer_mobile'         =>  $newowner_mob,
                    'transfer_buyer_email_id'       =>  $newowner_mail,
                    'transfer_seller_id'            =>  $sess_usr_id,
                    'transfer_status'               =>  1
                  );//print_r($ownerdet); exit;

                }
              }
            } else if($transfer_type==2){
              $data_transferupd=array(
                'transfer_changetype'           =>  1,
                'transfer_based_changetype'     =>  0,
                'transfer_state_id'             =>  $state_sl,
                'transfer_portofregistry_from'  =>  $vessel_registry_port_id,
                'transfer_vessel_id'            =>  $vessel_id,
                'transfer_vessel_main_id'       =>  $vesselmain_sl,
                'ref_number'                    =>  $ref_number,
                'transfer_req_date'             =>  $newDate,
                'transfer_changepending_status' =>  $changepending_status,
                'transfer_buyer_name'           =>  $buyer_name_out,
                'transfer_buyer_address'        =>  $buyer_address_out,
                'transfer_buyer_mobile'         =>  $newowner_mob_out,
                'transfer_buyer_email_id'       =>  $newowner_mail_out,
                'transfer_seller_declaration'   =>  $inssller_file_name,
                'transfer_buyer_declaration'    =>  $insbuyer_file_name,
                'transfer_buyer_idcard'         =>  $insidcard_file_name,
                'transfer_seller_id'            =>  $sess_usr_id,
                'transfer_status'               =>  1
              );//print_r($data_transferupd); exit;

            }
            //print_r($data_transferupd);exit;
          $inserttransferDet           = $this->security->xss_clean($data_transferupd);         
          $inserttransferDet_res       = $this->db->insert('tbl_transfer_ownershipchange', $inserttransferDet);
       } 
    } 
    $data = $data + $this->data;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/payment_details_form18_trans',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');

  } 
  else
  {
    redirect('Main_login/index');        
  }

} 

public function pay_now_form18_trans()
{
$sess_usr_id    = $this->session->userdata('int_userid');
$user_type_id   = $this->session->userdata('int_usertype');
$customer_id                       = $this->session->userdata('customer_id');
$survey_user_id                    = $this->session->userdata('survey_user_id');
$vessel_id1                        = $this->uri->segment(4);
$processflow_sl1                   = $this->uri->segment(5);
$status_details_sl1                = $this->uri->segment(6);

$vessel_id                         = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id                         = $this->encrypt->decode($vessel_id); 

$processflow_sl                    = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl                    = $this->encrypt->decode($processflow_sl); 

$status_details_sl                 = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
$status_details_sl                 = $this->encrypt->decode($status_details_sl); 

if(!empty($sess_usr_id))
{ //print_r($_POST);exit;
$data       =  array('title' => 'pay_now_form18_trans', 'page' => 'pay_now_form18_trans', 'errorCls' => NULL, 'post' => $this->input->post());
$data       =  $data + $this->data;
$this->load->model('Kiv_models/Survey_model');
$this->load->model('Kiv_models/Bookofregistration_model');
$this->load->model('Kiv_models/Vessel_change_model');

date_default_timezone_set("Asia/Kolkata");
$date                           = date('Y-m-d h:i:s', time());
$ip                             = $_SERVER['REMOTE_ADDR'];
$newDate                        = date("Y-m-d");

$vessel_id                      = $this->security->xss_clean($this->input->post('vessel_sl'));
$processflow_sl                 = $this->security->xss_clean($this->input->post('processflow_sl'));
$status_details_sl              = $this->security->xss_clean($this->input->post('status_details_sl'));
$transfer_type                  = $this->security->xss_clean($this->input->post('transfer_type'));

$process_id                     = $this->security->xss_clean($this->input->post('process_id')); 
$current_status_id              = $this->security->xss_clean($this->input->post('current_status_id'));
$current_position               = $this->security->xss_clean($this->input->post('current_position')); 
$status_change_date             = $date;
$survey_id                      = 0;

$user_id                        = $this->security->xss_clean($this->input->post('user_id'));
$status                         = 1;

/*$paymenttype_id                 = 4;
$dd_amount                      = $this->security->xss_clean($this->input->post('dd_amount'));
$portofregistry_sl              = $this->security->xss_clean($this->input->post('portofregistry_sl'));*/

$form_number_cs                 = $this->Vessel_change_model->get_form_number_cs($process_id);
$data['form_number_cs']         = $form_number_cs;
if(!empty($form_number_cs))
{
$formnumber                   = $form_number_cs[0]['form_no'];
}
$vessel_main                    =   $this->Vessel_change_model->get_vessel_main($vessel_id);
$data['vessel_main']            =   $vessel_main;
if(!empty($vessel_main))
{
$vesselmain_sl                =   $vessel_main[0]['vesselmain_sl'];
}

/*$data_payment=array(
'vessel_id'                   => $vessel_id,
'survey_id'                   => $survey_id,
'form_number'                 => $formnumber,
'paymenttype_id'              => $paymenttype_id,
'dd_amount'                   => $dd_amount,
'dd_date'                     => $newDate,
'portofregistry_id'           => $portofregistry_sl,
'payment_created_user_id'     => $sess_usr_id,
'payment_created_timestamp'   => $date,
'payment_created_ipaddress'   => $ip
);

//print_r($data_payment);

$result_insert                  = $this->db->insert('tbl_kiv_payment_details', $data_payment); 
$task_pfid                      = $this->Survey_model->get_task_pfid($processflow_sl);
$data['task_pfid']              = $task_pfid;
@$task_sl                       = $task_pfid[0]['task_sl'];

$port_registry_user_id          = $this->Vessel_change_model->get_port_registry_user_id($portofregistry_sl);
$data['port_registry_user_id']  = $port_registry_user_id;
if(!empty($port_registry_user_id))
{
$pc_user_id                   = $port_registry_user_id[0]['user_sl'];
$pc_usertype_id               = $port_registry_user_id[0]['user_type_id'];
}

if($process_id==40)
{
/////process flow start indication---- tb_vessel_main processing_status to be changed as 1
$data_mainupdate=array(
'processing_status'         => 1
);
///tbl_ownership_change payment status
$data_transupdate=array(
'payment_status'            => 1, 
'transfer_payment_date'     => $newDate
);
/////insert to processflow table showing curre
$data_insert=array(
'vessel_id'                 => $vessel_id,
'process_id'                => $process_id,
'survey_id'                 => $survey_id,
'current_status_id'         => 2,
'current_position'          => $pc_usertype_id,
'user_id'                   => $pc_user_id,
'previous_module_id'        => $processflow_sl,
'status'                    => $status,
'status_change_date'        => $status_change_date
); //print_r($data_insert);exit;

//////update current process status=0
$data_update=array(
'status'                    => 0
);
//////update status details table
$data_survey_status=array(
'survey_id'                 => $survey_id,
'process_id'                => $process_id,
'current_status_id'         => 2,
'sending_user_id'           => $sess_usr_id,
'receiving_user_id'         => $pc_user_id
);//print_r($data_survey_status);exit;

$transvsl_update              = $this->Vessel_change_model->update_transfervessel_status('tbl_transfer_ownershipchange',$data_transupdate, $vessel_id);
$vesselmain_update            = $this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
$process_update               = $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
$process_insert               = $this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
$status_update                = $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

if($transvsl_update && $vesselmain_update && $process_update && $process_insert && $status_update && $result_insert)
{
redirect("Kiv_Ctrl/Survey/SurveyHome");
}
}*/
//____________________________________________________START ONLINE TRANSACTION__________________________________//

/*_____________________Start Get vessel condition_______________ */   

$vessel_condition                 = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_id);
$data['vessel_condition']         = $vessel_condition;

if(!empty($vessel_condition))
{
$vessel_type_id                 = $vessel_condition[0]['vessel_type_id'];
$vessel_subtype_id              = $vessel_condition[0]['vessel_subtype_id'];
$vessel_length1                 = $vessel_condition[0]['vessel_length'];
$hullmaterial_id                = $vessel_condition[0]['hullmaterial_id'];
$engine_placement_id            = $vessel_condition[0]['engine_placement_id'];
}  
/*_____________________End Get vessel condition___________________*/

/*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
$form_id                          = 19;
if($transfer_type!=0){
$activity_id                    = 8;
} elseif ($transfer_type==0) {
$activity_id                    = 12;
}

$tariff_details                   = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
$data1['tariff_details']          = $tariff_details; //print_r($tariff_details);exit;
if (!empty($tariff_details)) 
{
$tariff_amount1                 = $tariff_details[0]['tariff_amount'];
$tariff_min_amount              = $tariff_details[0]['tariff_min_amount'];
}

$tonnage_details                  = $this->Vessel_change_model->get_tonnage_details($vessel_id);
$data1['tonnage_details']         = $tonnage_details;//print_r($tonnage_details);exit;
if(!empty($tonnage_details))
{
@$vessel_total_tonnage          = $tonnage_details[0]['vessel_total_tonnage'];
}
$amount1                          = $vessel_total_tonnage*$tariff_amount1;

if($amount1<100)
{
//$data['tariff_amount']          = $tariff_min_amount;
$tariff_amount                  = 1;
}
else
{
//$data['tariff_amount']          = $amount1;
$tariff_amount                  = 1;
}
/*_______________________________________________END Tariff____________________________ */   

/*___________________________________________________________________________ */   
if($this->input->post())
{ //print_r($_POST);
//$dd_amount1           = $this->security->xss_clean($this->input->post('dd_amount'));
$portofregistry_sl                = $this->security->xss_clean($this->input->post('portofregistry_sl'));
$bank_sl                          = $this->security->xss_clean($this->input->post('bank_sl'));
$vessel_sl                        = $this->security->xss_clean($this->input->post('vessel_sl'));
$transfer_type                    = $this->security->xss_clean($this->input->post('transfer_type'));
$status                           = 1;

$vessel_main                      = $this->Vessel_change_model->get_vessel_main($vessel_sl);
$data['vessel_main']              = $vessel_main;
if(!empty($vessel_main))
{
$vesselmain_sl                  = $vessel_main[0]['vesselmain_sl'];
}

$vessel_condition                 = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_sl);
$data['vessel_condition']         = $vessel_condition; 

if(!empty($vessel_condition))
{
$vessel_type_id                 = $vessel_condition[0]['vessel_type_id'];
$vessel_subtype_id              = $vessel_condition[0]['vessel_subtype_id'];
$vessel_length1                 = $vessel_condition[0]['vessel_length'];
$hullmaterial_id                = $vessel_condition[0]['hullmaterial_id'];
$engine_placement_id            = $vessel_condition[0]['engine_placement_id'];
}  
/*_____________________End Get vessel condition___________________*/

/*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
$form_id                          = 19;
if($transfer_type!=0){
$activity_id                    = 8;
} elseif ($transfer_type==0) {
$activity_id                    = 12;
}

$tariff_details                   = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
$data1['tariff_details']          = $tariff_details; 
if (!empty($tariff_details)) 
{
$tariff_amount1                 = $tariff_details[0]['tariff_amount'];
$tariff_min_amount              = $tariff_details[0]['tariff_min_amount'];
}

$tonnage_details                  = $this->Vessel_change_model->get_tonnage_details($vessel_sl);
$data1['tonnage_details']         = $tonnage_details;//print_r($tonnage_details);exit;
if(!empty($tonnage_details))
{
@$vessel_total_tonnage          = $tonnage_details[0]['vessel_total_tonnage'];
}
$amount1                          = $vessel_total_tonnage*$tariff_amount1;

if($amount1<100)
{///for checking payment
//$tariff_amount                  = $tariff_min_amount;
$tariff_amount                  = 1;
}
else
{//for checking payment
//$tariff_amount                  = $amount1;
$tariff_amount                  = 1;
}

$payment_user                     = $this->Vessel_change_model->get_payment_userdetails($sess_usr_id);
$data['payment_user']             = $payment_user;
//print_r($payment_user);exit;
if(!empty($payment_user))
{
$owner_name                     = $payment_user[0]['user_name'];
$user_mobile_number             = $payment_user[0]['user_mobile_number'];
$user_email                     = $payment_user[0]['user_email'];
}
$formnumber                       = 19;
$survey_id                        = 0;

date_default_timezone_set("Asia/Kolkata");
$ip                               = $_SERVER['REMOTE_ADDR'];
$date                             = date('Y-m-d h:i:s', time());
$newDate                          = date("Y-m-d");
$status_change_date               = $date;


$milliseconds                     = round(microtime(true) * 1000); //Generate unique bank number

$bank_gen_number                  = $this->Survey_model->get_bank_generated_last_number($bank_sl);
$data['bank_gen_number']          = $bank_gen_number;

if(!empty($bank_gen_number))
{
$bank_generated_number          = $bank_gen_number[0]['last_generated_no']+1;

$transaction_id                 = $user_type_id.$sess_usr_id.$vessel_sl.$bank_sl.$milliseconds.$bank_generated_number;
$tocken_number                  = $user_type_id.$sess_usr_id.$vessel_sl.$bank_sl.$milliseconds;

$bank_data                      = array('last_generated_no'=>$bank_generated_number);//print_r($bank_data);exit;

$data_payment_request=array(
'transaction_id'              => $transaction_id,
'bank_ref_no'                 => 0,
'token_no'                    => $tocken_number,
'vessel_id'                   => $vessel_sl,
'survey_id'                   => $survey_id,
'form_number'                 => $formnumber,
'customer_registration_id'    => $sess_usr_id,
'customer_name'               => $owner_name,
'mobile_no'                   => $user_mobile_number,
'email_id'                    => $user_email,
'transaction_amount'          => $tariff_amount,
'remitted_amount'             => 0,
'bank_id'                     => $bank_sl,
'transaction_status'          => 0,
'payment_status'              => 0,
'transaction_timestamp'       => $date,
'transaction_ipaddress'       => $ip,
'port_id'                     => $portofregistry_sl
); //print_r($data_payment_request);exit;


$result_insert=$this->db->insert('kiv_bank_transaction_request', $data_payment_request); 
if($result_insert)
{
//echo "hii"; exit;
$bank_transaction_id          = $this->db->insert_id();
$update_bank                  = $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);

//-------get Working key-----------//
$online_payment_data          = $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
$data['online_payment_data']  = $online_payment_data; //print_r($online_payment_data);exit;

//------------------owner details-------------------//

$payment_user1                = $this->Survey_model->get_payment_userdetails($sess_usr_id);
$data['payment_user1']        = $payment_user1;



$requested_transaction_details= $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
$data['requested_transaction_details']  =   $requested_transaction_details;

$data['amount_tobe_pay']      = $tariff_amount;
$data                         = $data+ $this->data;
//print_r($data);
//exit;

///Actual Data --- Commented for testing(start)//////
/*if(!empty($online_payment_data))
{ 
  
  $this->load->view('Kiv_views/Hdfc/hdfc_tnsfronlinepayment_request',$data);
   
}
else
{
  
  redirect('Kiv_Ctrl/Survey/SurveyHome');

}*/

///Actual Data --- Commented for testing(end)////// 

if(!empty($online_payment_data))
{ 
  
  //$this->load->view('Kiv_views/Hdfc/hdfc_tnsfronlinepayment_request',$data);

  date_default_timezone_set("Asia/Kolkata");
  $ip                   = $_SERVER['REMOTE_ADDR'];
  $date                 =   date('Y-m-d h:i:s', time());
  $newDate              =   date("Y-m-d");

  $vessel_main                    = $this->Vessel_change_model->get_vessel_main($vessel_sl);
  $data['vessel_main']            = $vessel_main;
  if(!empty($vessel_main))
  {
    $vesselmain_sl                = $vessel_main[0]['vesselmain_sl'];
  }

  $status_details             =   $this->Survey_model->get_status_details_vessel_sl($vessel_sl);
  $data['status_details']     =   $status_details;
  if(!empty($status_details))
  {
    $status_details_sl        =   $status_details[0]['status_details_sl'];
  }

  $processflow_vessel           =   $this->Survey_model->get_processflow_vessel($vessel_sl);
  $data['processflow_vessel']   =   $processflow_vessel;
  if(!empty($processflow_vessel))
  {
    $processflow_sl           =   $processflow_vessel[0]['processflow_sl'];
    $process_id         =   $processflow_vessel[0]['process_id'];
  }

  $transfer_type              =   $this->Vessel_change_model->get_transfervessel_type($vessel_sl); //print_r($transfer_type);
  $data['transfer_type']      = $transfer_type;
  foreach ($transfer_type as $transtyp_res) 
  {
    $trans_typ                = $transtyp_res['transfer_based_changetype'];
  }
  if($trans_typ!=0)
  {
    $activity_id                  = 8;
  } 
  elseif ($trans_typ==0) 
  {
    $activity_id                  = 12;
  }
  /*$data_portofregistry=array(
  'vessel_registry_port_id'     => $portofregistry_sl
  );
  $update_portofregistry        = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);*/

  $port_registry_user_id          =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
  $data['port_registry_user_id']  =   $port_registry_user_id;
  if(!empty($port_registry_user_id))
  {
    $pc_user_id           = $port_registry_user_id[0]['user_master_id'];
    $pc_usertype_id         = $port_registry_user_id[0]['user_master_id_user_type'];
  }

  $data_payment=array(
  'vessel_id'         =>  $vessel_sl,
  'survey_id'         =>  $activity_id,
  'form_number'         =>  $formnumber,
  'paymenttype_id'        =>  4,
  'dd_amount'         =>  $tariff_amount,
  'dd_date'           =>  $newDate,
  'portofregistry_id'     =>  $portofregistry_sl,
  'bank_id'           =>  $bank_sl,
  'payment_mode'        =>  'Credit Card',
  'transaction_id'        =>  $bank_transaction_id,
  'payment_created_user_id'   =>  $sess_usr_id,
  'payment_created_timestamp' =>  $date,
  'payment_created_ipaddress' =>  $ip); //print_r($data_payment);exit;

  /*if($process_id==38)
  {*/
  /////process flow start indication---- tb_vessel_main processing_status to be changed as 1
  $data_mainupdate=array(
  'processing_status'     =>  1);
  ///tbl_owner_change payment status
  $data_transupdate=array(
  'payment_status'          =>  1, 
  'transfer_payment_date'   =>  $newDate);

  /////insert to processflow table showing curre
  $data_insert=array(
  'vessel_id'             =>  $vessel_sl,
  'process_id'            =>  40,
  'survey_id'             =>  $survey_id,
  'current_status_id'     =>  2,
  'current_position'      =>  $pc_usertype_id,
  'user_id'               =>  $pc_user_id,
  'previous_module_id'    =>  $processflow_sl,
  'status'                =>  1,
  'status_change_date'    =>  $date); //print_r($data_insert);exit;

  //////update current process status=0
  $data_update=array(
  'status'          =>  0);

  //////update status details table
  $data_survey_status=array(
  'survey_id'             =>  $survey_id,
  'process_id'            =>  40,
  'current_status_id'     =>  2,
  'sending_user_id'       =>  $sess_usr_id,
  'receiving_user_id'     =>  $pc_user_id); 
  if($tariff_amount>0 && $portofregistry_sl!=false)
  {
    //echo "Amt".$amount."---Port".$portofregistry_sl."---Vesmain".$vesselmain_sl."---Vesid".$vessel_id."---Proce".$processflow_sl."---Stat".$status_details_sl;exit;
    $result_insert        = $this->db->insert('tbl_kiv_payment_details', $data_payment);
    $vesselmain_update      = $this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
    $transvsl_update            = $this->Vessel_change_model->update_transfervessel_status('tbl_transfer_ownershipchange',$data_transupdate, $vessel_id);
    $process_update       = $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
    $process_insert       = $this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
    $status_update        = $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
    //}
    if($vesselmain_update && $transvsl_update && $process_update && $process_insert && $status_update && $result_insert)
    {
      ///get user mail////
      $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($pc_user_id);
      if(!empty($user_mail_id))
      {
        foreach($user_mail_id as $mail_res)
        {
          $user_mail    = $mail_res['user_email'];
          $user_name    = $mail_res['user_name'];
          $user_mob     = $mail_res['user_mobile_number'];
        }
      }
      
      $tfr_refno          =   $this->Vessel_change_model->get_transfervessel_details($vessel_id);
      if(!empty($tfr_refno))
      {
        foreach($tfr_refno as $tfr_res)
        {
          $refno        = $tfr_res['ref_number'];
          $main_id        = $tfr_res['vesselmain_sl'];
          $reg_no       = $tfr_res['vesselmain_reg_number'];
          $vessel       = $tfr_res['vesselmain_vessel_name'];
          $buyer       = $tfr_res['transfer_buyer_id'];
          if($buyer!=0){
            $buyer_det    =   $this->Vessel_change_model->get_customer_details($buyer);
            foreach($buyer_det as $buyer_det_res){
              $buyer_name = $buyer_det_res['user_master_fullname'];
            }
          } else {
            $buyer_name = "{Unregistered User}";
          }
          $seller       = $tfr_res['transfer_seller_id'];
          $seller_det    =   $this->Vessel_change_model->get_customer_details($seller);
          foreach($seller_det as $seller_det_res){
            $seller_name = $seller_det_res['user_master_fullname'];
          }

          $portfm       = $tfr_res['transfer_portofregistry_from'];
          $portfmnam    =   $this->Vessel_change_model->get_registry_port_id($portfm);
          foreach($portfmnam as $portfmnam_res){
            $port_fmname= $portfmnam_res['vchr_portoffice_name'];
          }
          $portto       = $tfr_res['transfer_portofregistry_to'];
          $porttonam    =   $this->Vessel_change_model->get_registry_port_id($portto);
          foreach($porttonam as $porttonam_res){
            $port_toname= $porttonam_res['vchr_portoffice_name'];
          }
         
        }
      }
      
      $portna       =   $this->Vessel_change_model->get_registry_port_id($portofregistry_sl);
      foreach($portna as $port_res){
        $port_name  = $port_res['vchr_portoffice_name'];
      }
      /*------------code for send email starts---------------*/
      $config = Array(
      'protocol'        => 'smtp',
      'smtp_host'       => 'ssl://smtp.googlemail.com',
      'smtp_port'       => 465,
      'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
      'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
      'mailtype'        => 'html',
      'charset'         => 'iso-8859-1');//print_r($config);exit;

      $message = 'Dear '.$user_name.',<br/><br/>

      Payment of Rs. '.$tariff_amount.' for your vessel, '.$reg_no.' ( '.$vessel.' ) for Transfer of Vessel has been received.  Transfer of Vessel from <strong>'.$seller_name.'</strong> to <strong>'.$buyer_name.'</strong> is in process. <br/><br/>

      Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

      Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

      For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

      Warm Regards<br/><br/>

      Kerala Maritime Board ';
      $smsmsg = 'Payment of Rs. '.$tariff_amount.' for '.$reg_no.' is received, and forwarded to'. $port_name.' Port Conservator. Reference Number:  '.$refno.'.';

      //$message = 'The Transfer Request (Ref. No:'.$refno.') for the Vessel has been sent by the Vessel Owner. Please Verify for further Processing.';
      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('kivportinfo@gmail.com'); // change it to yours
      //$this->email->to($user_mail);// change it to yours
      $this->email->to('deepthi.nh@gmail.com');

      $this->email->subject('Payment of Rs. '.$tariff_amount.' has been received for Transfer of Vessel-reg.');
      $this->email->message($message);
      if($this->email->send())
      { 
        redirect('Kiv_Ctrl/VesselChange/transfervessel_list');
        //echo "success";redirect("Bookofregistration/raHome");
        // <!------------code for send SMS starts--------------->
        $this->load->model('Kiv_models/Vessel_change_model');
        $mobil="9809119144";
        $stat = $this->Vessel_change_model->sendSms($smsmsg,$mobil);
        //print_r($stat);exit;
        //echo json_encode("success");
        //redirect("Bookofregistration/raHome");
        /*------------code for send SMS ends---------------*/
      }
      else
      {
        show_error($this->email->print_debugger());
      } 
    }
  }
   
}
else
{
  
  redirect('Kiv_Ctrl/Survey/SurveyHome');

}  

}
else
{
/* echo '<script language="javascript">';
  echo 'alert(Please try after some time!)'; 
  echo '</script>';*/
redirect('Kiv_Ctrl/Survey/SurveyHome');
}

}
else
{
redirect('Kiv_Ctrl/Survey/SurveyHome');
}

} 
//____________________________________________________END ONLINE TRANSACTION__________________________________//

}
else
{
redirect('Main_login/index');      
}
}
public function Verify_payment_pc_form18_trans()
{
    /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                      = $this->session->userdata('customer_id');
    $survey_user_id                   = $this->session->userdata('survey_user_id');


    $vessel_id1                       = $this->uri->segment(4);
    $processflow_sl1                  = $this->uri->segment(5);
    $survey_id1                       = $this->uri->segment(6);

    $vessel_id                        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
    $vessel_id                        = $this->encrypt->decode($vessel_id); 

    $processflow_sl                   = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
    $processflow_sl                   = $this->encrypt->decode($processflow_sl); 

    $survey_id                        = str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
    $survey_id                        = $this->encrypt->decode($survey_id); 


    if(!empty($sess_usr_id) && ($user_type_id==3))
    {
      $data   =  array('title' => 'Verify_payment_pc_form18_trans', 'page' => 'Verify_payment_pc_form18_trans', 'errorCls' => NULL, 'post' => $this->input->post());
      $data   =  $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      $vessel_details                 = $this->Vessel_change_model->get_process_flow($processflow_sl);
      $data['vessel_details']         = $vessel_details;
      @$id                            = $vessel_details[0]['user_id'];

      $customer_details               = $this->Vessel_change_model->get_customer_details($id);
      $data['customer_details']       = $customer_details;

      $current_status                 = $this->Vessel_change_model->get_status();
      $data['current_status']         = $current_status;

      $form_number                    = $this->Vessel_change_model->get_form_number($vessel_id);
      $data['form_number']            = $form_number;
      $form_id                        = $form_number[0]['form_no'];

      $transfervsl_details            = $this->Vessel_change_model->get_transfervessel_details_pc($vessel_id);
      $data['transfervsl_details']    = $transfervsl_details;

      //----------Vessel Details--------//

      $vessel_details_viewpage        =  $this->Vessel_change_model->get_vessel_details_viewpage($vessel_id);
      $data['vessel_details_viewpage']= $vessel_details_viewpage;

      //----------Payment Details--------//
      $transfer_type              =   $this->Vessel_change_model->get_transfervessel_type($vessel_id); //print_r($transfer_type);
    $data['transfer_type']      = $transfer_type;
    foreach ($transfer_type as $transtyp_res) {
      $trans_typ                = $transtyp_res['transfer_based_changetype'];
    }
    if($trans_typ!=0){
        $activity_id                    = 8;
      } elseif ($trans_typ==0) {
        $activity_id                    = 12;
      }
//echo $vessel_id."==".$activity_id."==".$form_id;
      $payment_details                = $this->Vessel_change_model->get_form_payment_details($vessel_id,$activity_id,$form_id);
      $data['payment_details']        = $payment_details;
     // print_r($payment_details);
      if($this->input->post())
      { //print_r($_POST);exit;

        date_default_timezone_set("Asia/Kolkata");
        $date                         = date('Y-m-d h:i:s', time());
        $vessel_id                    = $this->security->xss_clean($this->input->post('vessel_id'));  
        $process_id                   = $this->security->xss_clean($this->input->post('process_id')); 
        $survey_id                    = $this->security->xss_clean($this->input->post('survey_id'));
        $current_status_id            = $this->security->xss_clean($this->input->post('current_status_id'));
        $status_change_date           = $date;
        $processflow_sl               = $this->security->xss_clean($this->input->post('processflow_sl'));
        $user_id                      = $this->security->xss_clean($this->input->post('user_id'));
        $status                       = 1;

        $status_details_sl1           = $this->security->xss_clean($this->input->post('status_details_sl'));
        $payment_sl                   = $this->security->xss_clean($this->input->post('payment_sl'));
        $payment_approved_remarks     = $this->security->xss_clean($this->input->post('remarks'));

        $date                         = date('Y-m-d h:i:s', time());
        $ip                           = $_SERVER['REMOTE_ADDR'];
        $status_change_date           = $date;

        $usertype                     = $this->Survey_model->get_user_id_cs(14);
        $data['usertype']             = $usertype;
        if(!empty($usertype))
        {
          $user_sl_ra                 = $usertype[0]['user_master_id'];
          $user_type_id_ra            = $usertype[0]['user_master_id_user_type'];
        }

        if($process_id==40)
        {

          $data_payment=array(
            'payment_approved_status'   => 1,
            'payment_approved_user_id'  => $sess_usr_id,
            'payment_approved_datetime' => $status_change_date,
            'payment_approved_ipaddress'=> $ip,
            'payment_approved_remarks'  => $payment_approved_remarks
          ); 

          $data_transvessl=array(
            'transfer_pc_verified_date' => $status_change_date,
            'transfer_verify_id'        => $sess_usr_id
          ); //print_r($data_ownershipchange);exit;

          $data_insert=array(
            'vessel_id'                 => $vessel_id,
            'process_id'                => $process_id,
            'survey_id'                 => $survey_id,
            'current_status_id'         => 2,
            'current_position'          => $user_type_id_ra,
            'user_id'                   => $user_sl_ra,
            'previous_module_id'        => $processflow_sl,
            'status'                    => $status,
            'status_change_date'        => $status_change_date
          );//print_r($data_insert);exit;

          $data_update=array(
            'status'                    => 0
          );

          $data_survey_status=array(
          'current_status_id'=>2,
          'sending_user_id'  =>$sess_usr_id,
          'receiving_user_id'=>$user_sl_ra
          );//echo $status_details_sl1;
      

          $payment_update             = $this->Vessel_change_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);
          $transvssl_update           = $this->Vessel_change_model->update_ownershipchange('tbl_transfer_ownershipchange',$data_transvessl, $vessel_id);
          $process_update             = $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
          $process_insert             = $this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
          $status_update=$this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl1);
          if($payment_update && $transvssl_update && $process_update && $process_insert && $status_update)
          {
            //redirect("Kiv_Ctrl/Survey/pcHome");
            ///get user mail////
            $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($user_sl_ra);
            if(!empty($user_mail_id))
            {
              foreach($user_mail_id as $mail_res){
                $user_mail    = $mail_res['user_email'];
                $user_name    = $mail_res['user_name'];
                $user_mob     = $mail_res['user_mobile_number'];
              }
            }
            
            $tfr_refno          =   $this->Vessel_change_model->get_transfervessel_details($vessel_id);
                if(!empty($tfr_refno))
                {
                  foreach($tfr_refno as $tfr_res)
                  {
                    $refno        = $tfr_res['ref_number'];
                    $main_id        = $tfr_res['vesselmain_sl'];
                    $reg_no       = $tfr_res['vesselmain_reg_number'];
                    $vessel       = $tfr_res['vesselmain_vessel_name'];
                    $buyer       = $tfr_res['transfer_buyer_id'];
                    if($buyer!=0){
                      $buyer_det    =   $this->Vessel_change_model->get_customer_details($buyer);
                      foreach($buyer_det as $buyer_det_res){
                        $buyer_name = $buyer_det_res['user_master_fullname'];
                      }
                    } else {
                      $buyer_name = "{Unregistered User}";
                    }
                    $seller       = $tfr_res['transfer_seller_id'];
                    $seller_det    =   $this->Vessel_change_model->get_customer_details($seller);
                    foreach($seller_det as $seller_det_res){
                      $seller_name = $seller_det_res['user_master_fullname'];
                    }

                    $portfm       = $tfr_res['transfer_portofregistry_from'];
                    $portfmnam    =   $this->Vessel_change_model->get_registry_port_id($portfm);
                    foreach($portfmnam as $portfmnam_res){
                      $port_fmname= $portfmnam_res['vchr_portoffice_name'];
                    }
                    $portto       = $tfr_res['transfer_portofregistry_to'];
                    $porttonam    =   $this->Vessel_change_model->get_registry_port_id($portto);
                    foreach($porttonam as $porttonam_res){
                      $port_toname= $porttonam_res['vchr_portoffice_name'];
                    }
                   
                  }
                }
                
                

                $payment     =  $this->Vessel_change_model->get_payment_details($payment_sl,$vessel_id);
                foreach($payment as $pay_res){
                  $amount  = $pay_res['dd_amount'];
                }
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

            $message = 'Dear '.$seller_name.',<br/><br/>

                Payment of Rs. '.$amount.' for your vessel, '.$reg_no.' ( '.$vessel.' ) for Ownership Change has been verified by '.$port_name.' Port Conservator.  Ownership Change from <strong>'.$seller_name.'</strong> to <strong>'.$buyer_name.'</strong> is processed by Registering Authority. <br/><br/>

                Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

                Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

                For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

                Warm Regards<br/><br/>

                Kerala Maritime Board ';
                $smsmsg = 'Payment of Rs. '.$amount.' for '.$reg_no.' is verified and forwarded to Registering Authority. Reference Number:  '.$refno;          
            //$message = 'The Transfer Request (Ref. No:'.$refno.') for the Vessel has been sent by the Port Conservator after verifying the payment. Please Verify for further Processing.';
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('kivportinfo@gmail.com'); // change it to yours
            //$this->email->to($user_mail);// change it to yours
            $this->email->to('deepthi.nh@gmail.com');

            $this->email->subject('Payment of Rs. '.$amount.' has been received for Transfer of Vessel-reg.');
            $this->email->message($message);
            if($this->email->send())
            { //echo "success";redirect("Kiv_Ctrl/Bookofregistration/raHome");

            // <!------------code for send SMS starts--------------->
              $this->load->model('Kiv_models/Vessel_change_model');
              //$mobil="9809119144";
              $mobil=$user_mob;
              $moduleid        = 2;
              $modenc          = $this->encrypt->encode($moduleid); 
              $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
              redirect("Kiv_Ctrl/Survey/pcHome/".$modidenc);
              //$stat = $this->Vessel_change_model->sendSms($smsmsg,$mobil);
              
              //redirect("Kiv_Ctrl/Survey/pcHome");
              //print_r($stat);exit;
              //echo json_encode("success");
              //redirect("Kiv_Ctrl/Bookofregistration/raHome");
              
              /*------------code for send SMS ends---------------*/
            }
            else
            {
              show_error($this->email->print_debugger());
            } 
          }
        }
      }

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/Verify_payment_pc_form18_trans',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
    }
    else
    {
        redirect('Main_login/index');        
    }
}
public function view_form18_trans()
{
   /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                      = $this->session->userdata('customer_id');
    $survey_user_id                   = $this->session->userdata('survey_user_id');

    $vessel_id1                       = $this->uri->segment(4);
    $processflow_sl1                  = $this->uri->segment(5);
    $status_details_sl1               = $this->uri->segment(6);

    $vessel_id                        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
    $vessel_id                        = $this->encrypt->decode($vessel_id); 

    $processflow_sl                   = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
    $processflow_sl                   = $this->encrypt->decode($processflow_sl); 

    $status_details_sl                = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
    $status_details_sl                = $this->encrypt->decode($status_details_sl); 
    $survey_id                        = 0;


  if(!empty($sess_usr_id) && ($user_type_id==14))
  {
    $data       =  array('title' => 'view_form18_trans', 'page' => 'view_form18_trans', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $initial_data                     = $this->Vessel_change_model->get_process_flow($processflow_sl);
    $data['initial_data']             = $initial_data;
  //print_r($initial_data);

    $intimation_type_id               = 4;

    $registration_intimation          = $this->Vessel_change_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']  = $registration_intimation;
    $vessel_change_det                = $this->Vessel_change_model->get_transfervessel_details_ra_vw($vessel_id);
    $data['vessel_change_det']        = $vessel_change_det;
    $payment_det                      = $this->Vessel_change_model->get_transfervessel_payment_ra($vessel_id);
    $data['payment_det']              = $payment_det;
    $transfervsl_details              = $this->Vessel_change_model->get_transfervessel_details_pc($vessel_id);
    $data['transfervsl_details']      = $transfervsl_details;

    $stern_material                   = $this->Bookofregistration_model->get_stern_material();
    $data['stern_material']           = $stern_material;

    $plyingPort                       = $this->Bookofregistration_model->get_portofregistry();
    $data['plyingPort']               = $plyingPort;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/view_form18_trans',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
    
  }
  else
  {
    redirect('Main_login/index');
  }
  
}
public function form19_certificate()
{
   $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id) && (($user_type_id==11) || ($user_type_id==12) || ($user_type_id==13) || ($user_type_id==14)))
  {
  $this->load->model('Kiv_models/Vessel_change_model');
  $vessel_id1                         = $this->uri->segment(4);

  $vessel_id                          = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                          = $this->encrypt->decode($vessel_id); 
  
  //$this->load->view('Kiv_views/dash/form11_certificate_view',$data);
  $this->load->library('Pdf.php');
  $pdf =  $this->pdf->load();
  $pdf->allow_charset_conversion=true;  // Set by default to TRUE
  $pdf->charset_in='UTF-8';
  $pdf->autoLangToFont = true;

  $pdf->showImageErrors = true;
  ini_set('memory_limit', '256M');

  $pdfFilePath                        = "form19_certificate_".$vessel_id.".pdf";   
  $html                               = $this->load->view('Kiv_views/dash/form19_certificate_view',$vessel_id,true);
  $output                             = $pdf->WriteHTML($html);
  $pdf->Output($output.$pdfFilePath, 'D');
  exit(); 
   }
  else
  {
    redirect('Main_login/index');
  }
}
function transfervessel_intimation_send()
{ //print_r($_POST);exit;
    /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                      = $this->session->userdata('customer_id');
    $survey_user_id                   = $this->session->userdata('survey_user_id');


    if(!empty($sess_usr_id))
    { 
      $data = array('title' => 'transfervessel_intimation_send', 'page' => 'transfervessel_intimation_send', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Vessel_change_model');


      $vessel_id1                     = $this->uri->segment(4);
      $processflow_sl1                = $this->uri->segment(5);
      $status_details_sl1             = $this->uri->segment(6);

      $vessel_id                      = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
      $vessel_id                      = $this->encrypt->decode($vessel_id); 

      $processflow_sl                 = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
      $processflow_sl                 = $this->encrypt->decode($processflow_sl); 

      $status_details_sl              = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
      $status_details_sl              = $this->encrypt->decode($status_details_sl); 
      $survey_id                      = 0;
      if($this->input->post())
      { //print_r($_POST); print_r($_FILES);exit;
        date_default_timezone_set("Asia/Kolkata");
        $date                         = date('Y-m-d h:i:s', time());
        $status_change_date           = $date;
        $remarks_date                 = date('Y-m-d');
        $ip                           = $_SERVER['REMOTE_ADDR'];
       //print_r($_FILES);

        $vessel_id                    = $this->security->xss_clean($this->input->post('vessel_id'));  
        $process_id                   = $this->security->xss_clean($this->input->post('process_id')); 
        $survey_id                    = $this->security->xss_clean($this->input->post('survey_id'));
        $processflow_sl               = $this->security->xss_clean($this->input->post('processflow_sl'));
        $status_details_sl            = $this->security->xss_clean($this->input->post('status_details_sl'));
        $current_position             = $this->security->xss_clean($this->input->post('current_position'));
        $user_id                      = $this->security->xss_clean($this->input->post('user_sl_ra'));
        $registration_intimation_sl   =  $this->security->xss_clean($this->input->post('registration_intimation_sl'));
        $user_id_owner                = $this->security->xss_clean($this->input->post('user_id_owner'));
        $user_type_id_owner           = $this->security->xss_clean($this->input->post('user_type_id_owner'));
        $current_status_id            = $this->security->xss_clean($this->input->post('current_status_id'));
        $status                       = 1;

        $change_inspection_date           = $this->security->xss_clean($this->input->post('change_inspection_date'));
        $portofregistry_sl                = $this->security->xss_clean($this->input->post('portofregistry_sl'));
        $change_intimation_remark         = $this->security->xss_clean($this->input->post('change_intimation_remark'));
        $change_inspection_report_upload  = $this->security->xss_clean($_FILES["change_inspection_report_upload"]["name"]);
        if($change_inspection_report_upload)
        {
          echo "uploaded";
          $ins_path_parts             = pathinfo($_FILES["change_inspection_report_upload"]["name"]);
          $ins_extension              = $ins_path_parts['extension'];

          echo $ins_file_name         = 'TNSFR'.'_INSPRPT_Form19_'.$vessel_id.'_'.$date.'.'.$ins_extension;
          $target                     = "./uploads/OwnershipChange_Intimation/".$ins_file_name;
          $ins_upd                    = move_uploaded_file($_FILES["change_inspection_report_upload"]["tmp_name"], $target);
        }
        else
        {
          echo "not";
        }
        $change_inspection            = pathinfo($_FILES['change_inspection_report_upload']['name']);
        if($change_inspection)
        {
        $extension                    = $change_inspection['extension'];
        }
        else
        {
        $extension                    = "";
        }
      
        if($process_id==40)
        {
          $data_reg_intimation= array(
            'vessel_id'                                => $vessel_id,
            'registration_intimation_type_id'          => 4,
            'registration_intimation_place_id'         => $portofregistry_sl, 
            'registration_intimation_remark'           => $change_intimation_remark,
            'registration_inspection_report_upload'    => $ins_file_name,
            'registration_inspection_date'             => $change_inspection_date,
            'registration_inspection_status'           => 1,
            'registration_inspection_created_user_id'  => $user_id,
            'registration_inspection_created_timestamp'=> $date,
            'registration_inspection_created_ipaddress'=> $ip
          ); //print_r($data_reg_intimation);
          $insert_intimation          = $this->Survey_model->insert_doc('a5_tbl_registration_intimation', $data_reg_intimation);

          $intimation_data=array(
            'registration_inspection_status'=>0
          );

          $data_insert=array(
            'vessel_id'         => $vessel_id,
            'process_id'        => $process_id,
            'survey_id'         => $survey_id,
            'current_status_id' => 7,
            'current_position'  => $current_position,
            'user_id'           => $sess_usr_id,
            'previous_module_id'=> $processflow_sl,
            'status'            => $status,
            'status_change_date'=> $status_change_date
          );//print_r($data_insert);

          $data_update=array(
            'status'=>0
          );

          $data_survey_status=array(
            'process_id'        => $process_id,
            'survey_id'         => $survey_id,
            'current_status_id' => 7,
            'sending_user_id'   => $sess_usr_id,
            'receiving_user_id' => $sess_usr_id
          );//print_r($data_survey_status);exit;


          $status_update               = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

          $intimation_update           = $this->Survey_model->update_registration_intimation('a5_tbl_registration_intimation', $intimation_data,$registration_intimation_sl);

          $process_update              = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
          $process_insert              = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

          if($insert_intimation && $status_update && $process_update && $process_insert && $intimation_update)
          {
            //redirect("Kiv_Ctrl/Bookofregistration/raHome");
            ///get user mail////
            $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($user_id);
            if(!empty($user_mail_id))
            {
              foreach($user_mail_id as $mail_res){
                $user_mail    = $mail_res['user_email'];
                $user_name    = $mail_res['user_name'];
                $user_mob     = $mail_res['user_mobile_number'];
              }
            }
            $tfr_refno          =   $this->Vessel_change_model->get_transfervessel_details($vessel_id);
                if(!empty($tfr_refno))
                {
                  foreach($tfr_refno as $tfr_res)
                  {
                    $refno        = $tfr_res['ref_number'];
                    $main_id        = $tfr_res['vesselmain_sl'];
                    $reg_no       = $tfr_res['vesselmain_reg_number'];
                    $vessel       = $tfr_res['vesselmain_vessel_name'];
                    $buyer       = $tfr_res['transfer_buyer_id'];
                    $portofreg       = $tfr_res['vesselmain_portofregistry_id'];
                    
                    $place =   $this->Vessel_change_model->get_registry_port_id($portofregistry_sl);
                    foreach($place as $place_res){
                      $placeofvisit  = $place_res['vchr_portoffice_name'];
                    }
                    if($buyer!=0){
                      $buyer_det    =   $this->Vessel_change_model->get_customer_details($buyer);
                      foreach($buyer_det as $buyer_det_res){
                        $buyer_name = $buyer_det_res['user_master_fullname'];
                      }
                    } else {
                      $buyer_name = "{Unregistered User}";
                    }
                    $seller       = $tfr_res['transfer_seller_id'];
                    $seller_det    =   $this->Vessel_change_model->get_customer_details($seller);
                    foreach($seller_det as $seller_det_res){
                      $seller_name = $seller_det_res['user_master_fullname'];
                    }

                    $portfm       = $tfr_res['transfer_portofregistry_from'];
                    $portfmnam    =   $this->Vessel_change_model->get_registry_port_id($portfm);
                    foreach($portfmnam as $portfmnam_res){
                      $port_fmname= $portfmnam_res['vchr_portoffice_name'];
                    }
                    $portto       = $tfr_res['transfer_portofregistry_to'];
                    $porttonam    =   $this->Vessel_change_model->get_registry_port_id($portto);
                    foreach($porttonam as $porttonam_res){
                      $port_toname= $porttonam_res['vchr_portoffice_name'];
                    }
                    $portna       =   $this->Vessel_change_model->get_registry_port_id($portofreg); 
                    foreach($portna as $port_res){
                      $port_name  = $port_res['vchr_portoffice_name'];
                    }
                   
                  }
                }
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
             $change_inspection_date_exp  = explode('-',$change_inspection_date);
            $change_inspection_date_fnl  = $change_inspection_date_exp[2].'-'.$change_inspection_date_exp[1].'-'.$change_inspection_date_exp[0];
            $message = 'Dear '.$seller_name.',<br/><br/>
              With respect to Transfer of Vessel, Registering Authority will verify your request on '.$change_inspection_date_fnl.' at '.$placeofvisit.'. You are hereby requested to be present for the same. Any change in schedule will be intimated through your registered mobile number and email id. <br/><br/>

            Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

            Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

            For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

            Warm Regards<br/><br/>

            Kerala Maritime Board ';
                $smsmsg = 'Registering Authority will visit on '.$change_inspection_date_fnl.' at '.$placeofvisit.' for Transfer of Vessel of '.$reg_no.'. Reference Number:  '.$refno;           
            //$message = 'The Transfer Request (Ref. No:'.$refno.') Intimation for the Vessel has been sent by the Registering Authority. Please Verify for further Processing.';
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('kivportinfo@gmail.com'); // change it to yours
           // $this->email->to($user_mail);// change it to yours
            $this->email->to('deepthi.nh@gmail.com');

            $this->email->subject('Intimation of visit by Registering Authority on '.$change_inspection_date_fnl.' at '.$placeofvisit.' for Transfer of Vessel -reg.');
            $this->email->message($message);
            if($this->email->send())
            { //echo "success";redirect("Kiv_Ctrl/Bookofregistration/raHome");
            // <!------------code for send SMS starts--------------->
              $this->load->model('Kiv_models/Vessel_change_model');
              //$mobil="9809119144";
              $mobil=$user_mob;
              //$stat = $this->Vessel_change_model->sendSms($smsmsg,$mobil);
              redirect("Kiv_Ctrl/Bookofregistration/raHome");
              //print_r($stat);exit;
              //echo json_encode("success");
              //redirect("Kiv_Ctrl/Bookofregistration/raHome");
              
              /*------------code for send SMS ends---------------*/
            }
            else
            {
              show_error($this->email->print_debugger());
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
public function transfervessel_req_list()
{

    /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                      = $this->session->userdata('customer_id');
    $survey_user_id                   = $this->session->userdata('survey_user_id');

    if(!empty($sess_usr_id) && (($user_type_id==14) || ($user_type_id==11) ))
    {
      $data       =  array('title' => 'transfervessel_req_list', 'page' => 'transfervessel_req_list', 'errorCls' => NULL, 'post' => $this->input->post());
      $data       =  $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Bookofregistration_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      if($user_type_id==14){
        $transfervesl_det              = $this->Vessel_change_model->get_transfervessel_details_ra_vw($sess_usr_id);
      } else {
        $transfervesl_det              = $this->Vessel_change_model->get_transfervesselstatus_details($sess_usr_id);
      }
      $data['transfervesl_det']        = $transfervesl_det; //print_r($namechange_det);exit;
      
      $data                            = $data + $this->data;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/transfervessel_req_list',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');

    } 
    else
    {
      redirect('Main_login/index');        
    }

}
public function view_form18_trans_intimation()
{
    /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                      = $this->session->userdata('customer_id');
    $survey_user_id                   = $this->session->userdata('survey_user_id');

    $vessel_id1                       = $this->uri->segment(4);
  
    $vessel_id                        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
    $vessel_id                        = $this->encrypt->decode($vessel_id); 

 
    $survey_id                        = 0;
    $process_id                       = 40;
    $status                           = 1;

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'view_form18_intimation', 'page' => 'view_form18_intimation', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $initimat_data                    = $this->Vessel_change_model->get_transfervessel_intimation_det($vessel_id,$survey_id,$process_id,$status);
    $data['initimat_data']            = $initimat_data;
  //print_r($initimat_data);exit;
    $vessel_change_det                = $this->Vessel_change_model->get_transfervessel_details_ra($vessel_id);
    $data['vessel_change_det']        = $vessel_change_det;
    $payment_det                      = $this->Vessel_change_model->get_transfervessel_payment_ra($vessel_id);
    $data['payment_det']              = $payment_det;
    
      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/view_form18_trans_intimation',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
    
  }
  else
  {
    redirect('Main_login/index');
  }
  
}
function form_transfervessel_insertion()
{ //print_r($_POST);exit;
    /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                      = $this->session->userdata('customer_id');
    $survey_user_id                   = $this->session->userdata('survey_user_id');
    if(!empty($sess_usr_id))
    { 
      $data     = array('title' => 'form_transfervessel_insertion', 'page' => 'form_transfervessel_insertion', 'errorCls' => NULL, 'post' => $this->input->post());
      $data     = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $ip                             = $_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date                           = date('Y-m-d h:i:s', time()); 
      $reg_date                       = date('Y-m-d');
      $status_change_date             = $date;

      $survey_id                      = 0;
      $process_id                     = 40;
      $status                         = 1;

      $vessel_id                      = $this->security->xss_clean($this->input->post('vessel_id'));
      $vessel_name                    = $this->security->xss_clean($this->input->post('vessel_name'));
      $transfer_based_changetype      = $this->security->xss_clean($this->input->post('transfer_based_changetype'));
      $transfer_buyer_name            = $this->security->xss_clean($this->input->post('transfer_buyer_name'));
      $transfer_buyer_address         = $this->security->xss_clean($this->input->post('transfer_buyer_address'));
      $transfer_buyer_mobile          = $this->security->xss_clean($this->input->post('transfer_buyer_mobile'));
      $transfer_buyer_email_id        = $this->security->xss_clean($this->input->post('transfer_buyer_email_id'));
      $transfer_buyer_id              = $this->security->xss_clean($this->input->post('transfer_buyer_id'));
      $transfer_buyer_usertyp         = $this->security->xss_clean($this->input->post('transfer_buyer_usertyp'));
      $transfer_portofregistry_from   = $this->security->xss_clean($this->input->post('transfer_portofregistry_from'));
      $transfer_portofregistry_to     = $this->security->xss_clean($this->input->post('transfer_portofregistry_to'));
      $state_nm                       = $this->security->xss_clean($this->input->post('state_nm'));
      
      $registered_date1               = $this->security->xss_clean($this->input->post('registered_date'));
      $registered_date                = date("Y-m-d", strtotime($registered_date1));

      $approve_status                 = $this->security->xss_clean($this->input->post('approve_status'));

      $process_id                     = $this->security->xss_clean($this->input->post('process_id')); 
      $survey_id                      = $this->security->xss_clean($this->input->post('survey_id'));
      $processflow_sl                 = $this->security->xss_clean($this->input->post('processflow_sl'));
      $status_details_sl              = $this->security->xss_clean($this->input->post('status_details_sl'));
      $current_position               = $this->security->xss_clean($this->input->post('current_position'));
      $user_id                        = $this->security->xss_clean($this->input->post('user_sl_ra'));
      $registration_intimation_sl     = $this->security->xss_clean($this->input->post('registration_intimation_sl'));
      $user_id_owner                  = $this->security->xss_clean($this->input->post('user_id_owner'));
      $user_type_id_owner             = $this->security->xss_clean($this->input->post('user_type_id_owner'));
      $current_status_id              = $this->security->xss_clean($this->input->post('current_status_id'));

      $vessel_main                    = $this->Vessel_change_model->get_vessel_main($vessel_id);
      $data['vessel_main']            = $vessel_main;
      if(!empty($vessel_main))
      {
        $vesselmain_sl                = $vessel_main[0]['vesselmain_sl'];

      }
      
      ////For Register Number
      $vessel_details_viewpage        = $this->Survey_model->get_vessel_details_viewpage($vessel_id);
      $data['vessel_details_viewpage']= $vessel_details_viewpage; //print_r($vessel_details_viewpage);//exit;
      if(!empty($vessel_details_viewpage))
      {
        foreach($vessel_details_viewpage as $vesseldet_res){
          $reg_number                 = $vesseldet_res['vessel_registration_number'];
          $reference_number           = $vesseldet_res['reference_number'];
          $vessel_registry_port_id    = $vesseldet_res['vessel_registry_port_id'];
          $vessel_type_id             = $vesseldet_res['vessel_type_id'];
          $reg_number_exp             = explode('/', $reg_number);
          if(!empty($reg_number_exp)){
            @$reg_number_vtypcd       = $reg_number_exp[2];
            @$reg_number_yr           = $reg_number_exp[4];
          }
        }

        /*$vessel_type                  = $this->Survey_model->get_vessel_typeid_length($vessel_type_id);
        $data['vessel_type']          = $vessel_type;
        foreach($vessel_type as $vesltyp_res){
          $vesseltype_code            = $vesltyp_res['vesseltype_code'];
        }*/
        if($transfer_based_changetype!=0){
          $registry_port_id             = $this->Survey_model->get_registry_port_id($transfer_portofregistry_to);
          $data['registry_port_id']     = $registry_port_id;//print_r($registry_port_id);//exit;
          if(!empty($registry_port_id))
          {
            foreach ($registry_port_id as $regport_res) {
              $registry_code            = $regport_res['vchr_officecode'];
            }
            $regcount_details           = $this->Survey_model->get_regcount($transfer_portofregistry_to,$vessel_type_id);
            $data['regcount_details']   = $regcount_details;//print_r($regcount_details);
            //$year                       = date('Y');
            if(!empty($regcount_details))
            {
              foreach ($regcount_details as $count_res) {
                $regcount_id            = $count_res['id'];
                $regcount1              = $count_res['regcount'];
                $regcount               = $regcount1+1;
                $new_registration_number= 'KIV/'.$registry_code.'/'.$reg_number_vtypcd.'/'.$regcount.'/'.$reg_number_yr;//exit;
                
              }
                
            }
          }
        } else { //echo $transfer_portofregistry_from;
          $registry_port_id             = $this->Survey_model->get_registry_port_id($transfer_portofregistry_from);
          $data['registry_port_id']     = $registry_port_id;//print_r($registry_port_id);exit;
          if(!empty($registry_port_id))
          {
            foreach ($registry_port_id as $regport_res) {
              $registry_code            = $regport_res['vchr_officecode'];
            }
            $regcount_details           = $this->Survey_model->get_regcount($transfer_portofregistry_from,$vessel_type_id);
            $data['regcount_details']   = $regcount_details;//print_r($regcount_details);exit;
            //$year                       = date('Y');
            if(!empty($regcount_details))
            {
              foreach ($regcount_details as $count_res) {
                $regcount_id            = $count_res['id'];
                $regcount1              = $count_res['regcount'];
                //$regcount               = $regcount1+1;
                //$new_registration_number= 'KIV/'.$registry_code.'/'.$reg_number_vtypcd.'/'.$regcount.'/'.$reg_number_yr;//exit;
                
              }
                
            }
          }
          $new_registration_number=0;
        }
      }  
     
    //print_r($_POST);exit;
    if(!empty($approve_status)){
      if($approve_status==5){
        //$data_mainupdatee  = array('processing_status'=>0);
        //////transfer_log table 
        $data_transfer_log=array(
          'vessel_id'                      => $vessel_id,
          'change_type'                    => 1,
          'transfer_based_changetype'      => $transfer_based_changetype,
          'transfer_portofregistry_from'   => $transfer_portofregistry_from,
          'transfer_portofregistry_to'     => $transfer_portofregistry_to,
          'transfer_regnumber_from'        => $reg_number,
          'transfer_regnumber_to'          => $new_registration_number,
          'transfer_state_id'              => $state_nm,
          'transfer_buyer_name'            => $transfer_buyer_name,
          'transfer_buyer_address'         => $transfer_buyer_address,
          'transfer_buyer_mobile'          => $transfer_buyer_mobile,
          'transfer_buyer_email_id'        => $transfer_buyer_email_id,
          'transfer_buyer_id'              => $transfer_buyer_id,
          'transfer_seller_id'             => $user_id_owner,
          'registered_date'                => $registered_date,
          'approved_date'                  => $reg_date,
          'status'                         => 1

        );//print_r($data_transfer_log);//exit;
        ///////transfer table
        $data_tsfrvsl=array(
          'transfer_approve_date'          => $reg_date,
          'transfer_approve_id'            => $sess_usr_id,
          'transfer_changepending_status'  => 2,
          'transfer_approve_ipaddress'     => $ip
        );//print_r($data_tsfrvsl);exit;

        ///////vesseldetails table
        if($transfer_based_changetype==1){ ///only port changes within kerala 
          $data_vesseldet=array(
            'vessel_registry_port_id'      => $transfer_portofregistry_to,
            'vessel_registration_number'   => $new_registration_number
          );//print_r($data_vesseldet); exit;
          $data_vesselmain=array(
            'vesselmain_portofregistry_id' => $transfer_portofregistry_to,
            'vesselmain_reg_number'        => $new_registration_number,
            'processing_status'            => 0,
            'vesselmain_transfer_req'      => 1
          );//print_r($data_vesselmain); exit;
          $data_regcount=array(
            'regcount'                     => $regcount
          );
          $data_uservessel=array(
            'modified_user_id'             => $user_id_owner,
            'modified_ipaddress'           => $ip
          );
          $data_insert=array(
            'vessel_id'                    => $vessel_id,
            'process_id'                   => $process_id,
            'survey_id'                    => $survey_id,
            'current_status_id'            => $approve_status,
            'current_position'             => 11,///vessel owner
            'user_id'                      => $user_id_owner,
            'previous_module_id'           => $processflow_sl,
            'status'                       => $status,
            'status_change_date'           => $status_change_date
          );//print_r($data_insert);exit;
          /////////processflow previous flow status update
          $data_update=array(
            'status'                       => 0
          );
          //////////status details table
          $data_survey_status=array(
            'process_id'                   => $process_id,
            'survey_id'                    => $survey_id,
            'current_status_id'            => $approve_status,
            'sending_user_id'              => $sess_usr_id,
            'receiving_user_id'            => $user_id_owner
          );//print_r($data_survey_status);exit;
        } 
        elseif ($transfer_based_changetype==3) {//echo "hiii2";exit;///port and user changes within kerala
          $data_vesseldet=array(
            'vessel_registry_port_id'      => $transfer_portofregistry_to,
            'vessel_registration_number'   => $new_registration_number,
            'vessel_user_id'               => $transfer_buyer_id,
            'vessel_created_user_id'       => $transfer_buyer_id,
            'vessel_created_ipaddress'     => $ip
          );//print_r($data_vesseldet);exit;
          ///////vesselmain table
          /////process flow start indication---- tb_vessel_main processing_status to be changed as 1
          $data_vesselmain=array(
            'vesselmain_portofregistry_id' => $transfer_portofregistry_to,
            'vesselmain_reg_number'        => $new_registration_number,
            'vesselmain_owner_id'          => $transfer_buyer_id,
            'processing_status'            => 0,
            'vesselmain_transfer_req'      => 1
          );//print_r($data_vesselmain);exit;
          $data_regcount=array(
            'regcount'                     => $regcount
          );
          ///kiv_uservessel
          $data_uservessel=array(
            'user_id'                      => $transfer_buyer_id,
            'created_user_id'              => $transfer_buyer_id,
            'created_ipaddress'            => $ip
          );//print_r($data_uservessel);exit;
          $data_insert=array(
            'vessel_id'                    => $vessel_id,
            'process_id'                   => $process_id,
            'survey_id'                    => $survey_id,
            'current_status_id'            => $approve_status,
            'current_position'             => $transfer_buyer_usertyp,
            'user_id'                      => $transfer_buyer_id,
            'previous_module_id'           => $processflow_sl,
            'status'                       => $status,
            'status_change_date'           => $status_change_date
          );//print_r($data_insert);exit;
          /////////processflow previous flow status update
          $data_update=array(
            'status'                       => 0
          );
          //////////status details table
          $data_survey_status=array(
            'process_id'                   => $process_id,
            'survey_id'                    => $survey_id,
            'current_status_id'            => $approve_status,
            'sending_user_id'              => $sess_usr_id,
            'receiving_user_id'            => $transfer_buyer_id
          );//print_r($data_survey_status);exit;
        } 
        elseif ($transfer_based_changetype==0) {/// outside kerala
          $data_vesseldet=array(
            'vessel_registry_port_id'      => 0,
            'vessel_registration_number'   => $new_registration_number
          );//print_r($data_vesseldet); exit;
          $data_vesselmain=array(
            'vesselmain_portofregistry_id' => 0,
            'vesselmain_reg_number'        => $new_registration_number,
            'vesselmain_owner_id'          => 0,
            'processing_status'            => 2,///outside kerala
            'vesselmain_transfer_req'      => 1
          );//print_r($data_vesselmain); exit;
          $data_regcount=array(
            'regcount'                     => $regcount1
          );//print_r($data_regcount); exit;
          $data_uservessel=array(
            'user_id'                      => 0,
            'modified_user_id'             => $user_id_owner,
            'modified_ipaddress'           => $ip
          );//print_r($data_uservessel); exit;
          $data_insert=array(
            'vessel_id'                    => $vessel_id,
            'process_id'                   => $process_id,
            'survey_id'                    => $survey_id,
            'current_status_id'            => $approve_status,
            'current_position'             => 0,///vessel owner
            'user_id'                      => 0,
            'previous_module_id'           => $processflow_sl,
            'status'                       => $status,
            'status_change_date'           => $status_change_date
          );//print_r($data_insert);exit;
          /////////processflow previous flow status update
          $data_update=array(
            'status'                       => 0
          );
          //////////status details table
          $data_survey_status=array(
            'process_id'                   => $process_id,
            'survey_id'                    => $survey_id,
            'current_status_id'            => $approve_status,
            'sending_user_id'              => 0,
            'receiving_user_id'            => 0
          );//print_r($data_survey_status);exit;
        }
        //print_r($data_vesseldet);exit;
        
        ///////processflow table
        //print_r($data_survey_status);exit;
        ///log table check
        $check_transfervessellog       = $this->Vessel_change_model->checktransfer_vessel($vessel_id); //print_r($check_transfervessellog);exit;
        if(!empty($check_transfervessellog))
        {
           $approved_date              = $check_transfervessellog[0]['approved_date'];
        }
        $count_rws                     = count($check_transfervessellog); 
        if($count_rws>0){
          $data_log=array(
            'status'                        => 0
          );
          $log_update_status           = $this->Vessel_change_model->update_namelog_status('tbl_transfer_ownershipchange_log',$data_log, $vessel_id);
          if($log_update_status){
            $data_transferupd_log=array(
              'vessel_id'                   => $vessel_id,
              'change_type'                 => 1,
              'transfer_based_changetype'   => $transfer_based_changetype,
              'transfer_portofregistry_from'=> $transfer_portofregistry_from,
              'transfer_portofregistry_to'  => $transfer_portofregistry_to,
              'transfer_regnumber_from'     => $reg_number,
              'transfer_regnumber_to'       => $new_registration_number,
              'transfer_state_id'           => $state_nm,
              'transfer_buyer_name'         => $transfer_buyer_name,
              'transfer_buyer_address'      => $transfer_buyer_address,
              'transfer_buyer_mobile'       => $transfer_buyer_mobile,
              'transfer_buyer_email_id'     => $transfer_buyer_email_id,
              'transfer_buyer_id'           => $transfer_buyer_id,
              'transfer_seller_id'          => $user_id_owner,
              'registered_date'             => $registered_date,
              'approved_date'               => $reg_date,
              'status'                      => 1
            ); //echo "1";print_r($data_transferupd_log); exit;
            $inserttransferlog          = $this->security->xss_clean($data_transferupd_log);         
            $inserttransferlog_res      = $this->db->insert('tbl_transfer_ownershipchange_log', $inserttransferlog);
          }
        } else { //echo "2";print_r($data_insert); exit;
          $inserttransferlog            = $this->security->xss_clean($data_transfer_log);         
          $inserttransferlog_res        = $this->db->insert('tbl_transfer_ownershipchange_log', $inserttransferlog);
        }
        ///vesselmain
         //$vesselmain_update=$this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdatee, $vesselmain_sl);
        ///ownerchange 
        $transfervsl_upd                = $this->Vessel_change_model->update_vessel_ownchg('tbl_transfer_ownershipchange',$data_tsfrvsl, $vessel_id, $vesselmain_sl);
        ///vessel details
        $vesseldet_upd                  = $this->Vessel_change_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vesseldet, $vessel_id);
        ///vesselmain
        $vesselmain_upd                 = $this->Vessel_change_model->update_tbl_vessel_main('tb_vessel_main',$data_vesselmain, $vessel_id, $vesselmain_sl); 
        ///kiv_uservessel
        $uservessel_upd                 = $this->Vessel_change_model->update_tbl_user_vessel('tbl_kiv_user_vessel',$data_uservessel, $vessel_id);
        $process_update_regcount        = $this->Survey_model->update_vessel_regcount('tb_regcount',$data_regcount, $regcount_id);
        $status_update                  = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $process_update                 = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert                 = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        if($inserttransferlog_res && $transfervsl_upd && $vesseldet_upd && $vesselmain_upd && $uservessel_upd && $process_update_regcount  && $status_update && $process_update && $process_insert)
         {
          echo "1";
         }
         else
         {
          echo "0";
         }
        } 
        ///////Reject
        else {
          $data_ownerchg=array(
            'transfer_status'=> 2
          );
           $data_vesselmain=array(
            'processing_status'        => 0
          );
          $data_insert=array(
            'vessel_id'         => $vessel_id,
            'process_id'        => $process_id,
            'survey_id'         => $survey_id,
            'current_status_id' => $approve_status,
            'current_position'  => $user_type_id_owner,
            'user_id'           => $user_id_owner,
            'previous_module_id'=> $processflow_sl,
            'status'            => $status,
            'status_change_date'=> $status_change_date
          );//print_r($data_insert);exit;
          /////////processfloe previous flow status update
          $data_update = array('status'=>0);
          //////////status details table
          $data_survey_status=array(
            'process_id'        => $process_id,
            'survey_id'         => $survey_id,
            'current_status_id' => $approve_status,
            'sending_user_id'   => $sess_usr_id,
            'receiving_user_id' => $user_id_owner
          );
          $ownerchange_upd       = $this->Vessel_change_model->update_vessel_ownchg('tbl_transfer_ownershipchange',$data_ownerchg, $vessel_id, $vesselmain_sl);
          $vesselmain_upd       = $this->Vessel_change_model->update_tbl_vessel_main('tb_vessel_main',$data_vesselmain, $vessel_id, $vesselmain_sl);
          $status_update      = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

          $process_update     = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
          $process_insert     = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
          if($ownerchange_upd && $vesselmain_upd && $status_update && $process_update && $process_insert)
           {
            echo "1";
           }
           else
           {
            echo "0";
           }
        }
    }
  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function generate_certificate_tran()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id      = $this->session->userdata('customer_id');
  $survey_user_id   = $this->session->userdata('survey_user_id');

   $vessel_id        = $this->uri->segment(4);
  /*$processflow_sl   = $this->uri->segment(5);
  $status_details_sl= $this->uri->segment(6);*/

  

  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'generate_certificate_own', 'page' => 'generate_certificate_own', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    

    $vessel_details_viewpage         = $this->Vessel_change_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;

    @$id                      = $vessel_details_viewpage[0]['user_id'];
    
   //-----------Get customer name and address--------------//
    $customer_details         = $this->Vessel_change_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;

    /*$initial_data             = $this->Vessel_change_model->get_process_flow($processflow_sl);
    $data['initial_data']     = $initial_data;

    $intimation_type_id=2;

    $registration_intimation          = $this->Vessel_change_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']  = $registration_intimation;

    $survey_id=1;
     //----------Hull Details--------//
   
    $hull_details            = $this->Vessel_change_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']    = $hull_details;

   
   //----------Engine Details--------//
   
   $engine_details           = $this->Survey_model->get_engine_details($vessel_id,$survey_id);
   $data['engine_details']   = $engine_details;*/




    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/generate_certificate_tran',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');

  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function transfervessel_out_list()
{

    /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                      = $this->session->userdata('customer_id');
    $survey_user_id                   = $this->session->userdata('survey_user_id');

    if(!empty($sess_usr_id) && ($user_type_id==11))
    {
      $data       =  array('title' => 'transfervessel_req_list', 'page' => 'transfervessel_req_list', 'errorCls' => NULL, 'post' => $this->input->post());
      $data       =  $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Bookofregistration_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      /*if($user_type_id==6){
        $transfervesl_det              = $this->Vessel_change_model->get_transfervessel_details_ra_vw($sess_usr_id);
      } else {*/
      $transfervesl_det                = $this->Vessel_change_model->get_transfervesseloutside_details($sess_usr_id);
      //}
      $data['transfervesl_det']        = $transfervesl_det; //print_r($namechange_det);exit;
      
      $data                            = $data + $this->data;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/transfervessel_out_list',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');

    } 
    else
    {
      redirect('Main_login/index');        
    }

}
///////////////////////Transfer of Vessel----------End--------/////////////////////////
///////////////////////Vessel Duplicate Certificate------Start---------//////////////////////////
public function duplicatecertificate_list()
{ 
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
   $customer_id                        = $this->session->userdata('customer_id');
   $survey_user_id                     = $this->session->userdata('survey_user_id');

   
   if(!empty($sess_usr_id)&&($user_type_id==11))
   {
      $data = array('title' => 'duplicatecertificate_list', 'page' => 'duplicatecertificate_list', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      $vessel_list                     = $this->Vessel_change_model->get_vesseldupcertificate_List($sess_usr_id);
      $data['vessel_list']             = $vessel_list;//print_r($vessel_list);
      $count                           = count($vessel_list);
      $data['count']                   = $count;
      $data                            = $data + $this->data;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/duplicatecertificate_list',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
   }
   else
   {
          redirect('Main_login/index');        
   }

}
public function duplicatecertificate()
{ 
    /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
    $customer_id                       = $this->session->userdata('customer_id');
    $survey_user_id                    = $this->session->userdata('survey_user_id');
  
    $vessel_id1                        = $this->uri->segment(4);
    $processflow_sl1                   = $this->uri->segment(5);
    $status_details_sl1                = $this->uri->segment(6);

    $vessel_id                         = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
    $vessel_id                         = $this->encrypt->decode($vessel_id); 

    $processflow_sl                    = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
    $processflow_sl                    = $this->encrypt->decode($processflow_sl); 

    $status_details_sl                 = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
    $status_details_sl                 = $this->encrypt->decode($status_details_sl); 

   
   if(!empty($sess_usr_id)&&($user_type_id==11))
   {
      $data = array('title' => 'dupcert', 'page' => 'dupcert', 'errorCls' => NULL, 'post' => $this->input->post());
      $data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');
      $this->load->model('Kiv_models/Vessel_change_model');

      $vesselDet                      = $this->Vessel_change_model->get_vesselDet($vessel_id);
      $data['vesselDet']              = $vesselDet; //print_r($vesselDet);exit;
      if(!empty($vesselDet))
      {
        $vessel_type_id               = $vesselDet[0]['vessel_type_id'];
        $vessel_subtype_id            = $vesselDet[0]['vessel_subtype_id'];
      }
 


      $process_data                   = $this->Vessel_change_model->get_process_flow_sl($vessel_id);
      $data['process_data']           = $process_data;
      if(!empty($process_data))
      {
        $status_change_date1          = $process_data[0]['status_change_date'];
      }
  //print_r($process_data);exit;

      $data['status_details_sl']      = $status_details_sl;
      $data['processflow_sl']         = $processflow_sl;

      $survey_id                      = 0;

      $engine_details                 = $this->Vessel_change_model->get_engine_details($vessel_id,$survey_id);
      $data['engine_details']         = $engine_details;

      $no_of_engineset                = count($engine_details);


    
      //______________________________________________//
      //Master Data Population

      $registeringAuthority           = $this->Bookofregistration_model->get_registeringAuthority();
      $data['registeringAuthority']   = $registeringAuthority;//print_r($registeringAuthority);

      $insuranceCompany               = $this->Bookofregistration_model->get_insuranceCompany();
      $data['insuranceCompany']       = $insuranceCompany;

      $masClass                       = $this->Bookofregistration_model->get_masterClass();
      $data['masClass']               = $masClass;

      $plyingPort                     = $this->Bookofregistration_model->get_portofregistry();
      $data['plyingPort']             = $plyingPort;

      $vesselMasterDetails            = $this->Bookofregistration_model->get_crew_details($vessel_id,1);
      $data['vesselMasterDetails']    = $vesselMasterDetails;
      $vesselMasterDetails_count      = count($vesselMasterDetails);

  //___________________________TARIFF DETAILS____________________________________________//

      $status_change_date             = date("Y-m-d", strtotime($status_change_date1));
      $now                            = date("Y-m-d");
      $date1_ts                       = strtotime($status_change_date);
      $date2_ts                       = strtotime($now);
      $diff                           = $date2_ts - $date1_ts;
      $numberofdays1                  = round($diff / 86400);
      

      $form_id                        = 20;
      $activity_id                    = 9;
      
      $tariff_details                 = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
      $data1['tariff_details']        = $tariff_details; 
      if (!empty($tariff_details)) 
      {
        $tariff_amount1               = $tariff_details[0]['tariff_amount'];
        $tariff_min_amount            = $tariff_details[0]['tariff_min_amount'];
      }
      
      $tonnage_details                = $this->Vessel_change_model->get_tonnage_details($vessel_id);
      $data1['tonnage_details']       = $tonnage_details;//print_r($tonnage_details);exit;
      if(!empty($tonnage_details))
      {
        @$vessel_total_tonnage        = $tonnage_details[0]['vessel_total_tonnage'];
      }
      $amount1                        = $vessel_total_tonnage*$tariff_amount1;

      if($amount1<100)
      {
        $data['tariff_amount']        = $tariff_min_amount;
      }
      else
      {
        $data['tariff_amount']        = $amount1;
      }
      
      $data = $data + $this->data;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/duplicatecertificate',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
   }
   else
   {
          redirect('Main_login/index');        
   }

}
function showpayment20($vessel_id)
{ 
    /*$vessel_sl                            = $this->session->userdata('vessel_id');
    if($vessel_sl=="")
    {
      $vessel_id                          = $this->security->xss_clean($this->input->post('vessel_id'));
    }
    else
    {
      $vessel_id                          = $vessel_sl;
    }
  echo $vessel_id;*/
    $vessel_condition                     = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition']             = $vessel_condition;
    //print_r($vessel_condition);
    if(!empty($vessel_condition))
    {
      $vessel_type_id                     = $vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id                  = $vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1                     = $vessel_condition[0]['vessel_length'];
      $hullmaterial_id                    = $vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id                = $vessel_condition[0]['engine_placement_id'];
    }

    $form_id                              = 20;
    $activity_id                          = 9;

    $tariff_details                       = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data1['tariff_details']              = $tariff_details; 
    if (!empty($tariff_details)) 
    {
      $tariff_amount1                     = $tariff_details[0]['tariff_amount'];
      $tariff_min_amount                  = $tariff_details[0]['tariff_min_amount'];
    }
      
    $tonnage_details                      = $this->Vessel_change_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']             = $tonnage_details;//print_r($tonnage_details);exit;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage              = $tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1                              = $vessel_total_tonnage*$tariff_amount1;

    if($amount1<100)
    {
      //$data1['tariff_amount']              = $tariff_min_amount;
      $data1['tariff_amount']             = 1;
    }
    else
    {
      //$data1['tariff_amount']              = $amount1;
      $data1['tariff_amount']             = 1;
    }
 
    $this->load->view('Kiv_views/Ajax_payment_show.php',$data1);
}
function not_payment_details_form20()
{ //print_r($_POST);exit;
  $vessel_id                              =  $this->session->userdata('vessel_id');
 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                            =  $this->session->userdata('customer_id');
  $survey_user_id                         =  $this->session->userdata('survey_user_id');


  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
$this->load->model('Kiv_models/Survey_model');
    date_default_timezone_set("Asia/Kolkata");
    $date                                 =  date('Y-m-d h:i:s', time());

    $vessel_id                            =  $this->security->xss_clean($this->input->post('vessel_sl'));  
    $process_id                           =  $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id                            =  0;
    $current_status_id                    =  $this->security->xss_clean($this->input->post('current_status_id'));
    $current_position                     =  $this->security->xss_clean($this->input->post('current_position')); 
    $status_change_date                   =  $date;
    $processflow_sl                       =  $this->security->xss_clean($this->input->post('processflow_sl'));
    $user_id                              =  $this->security->xss_clean($this->input->post('user_id'));
    $status                               =  1;
    $status_details_sl                    =  $this->security->xss_clean($this->input->post('status_details_sl'));
    $ip                                   =  $_SERVER['REMOTE_ADDR'];
    
    $data_update=array(
      'status'=>0
    );
    $process_update                       =  $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);

    $data_process=array(
      'vessel_id'                         => $vessel_id,
      'process_id'                        => $process_id,
      'survey_id'                         => $survey_id,
      'current_status_id'                 => 8,
      'current_position'                  => $user_type_id,
      'user_id'                           => $sess_usr_id,
      'previous_module_id'                => $processflow_sl,
      'status'                            => $status,
      'status_change_date'                => $status_change_date
    ); //print_r($data_process);exit;

    $data_status=array(
      'vessel_id'                         => $vessel_id,
      'process_id'                        => $process_id,
      'survey_id'                         => $survey_id,
      'current_status_id'                 => 8,
      'sending_user_id'                   => $sess_usr_id,
      'receiving_user_id'                 => $sess_usr_id,
    );//print_r($data_status);exit;

    $status_update                        =  $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_status,$status_details_sl);
    $insert_process                       =  $this->Vessel_change_model->insert_process_flow($data_process);
  
              
    if($insert_process && $status_update && $process_update)  
    {
      redirect('Kiv_Ctrl/Survey/SurveyHome');
    }       
            
  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function payment_details_form20()
{ //print_r($_POST); print_r($_FILES);exit;
 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                        = $this->session->userdata('customer_id');
  $survey_user_id                     = $this->session->userdata('survey_user_id');

  $vessel_id1                         = $this->uri->segment(4);
  $processflow_sl1                    = $this->uri->segment(5);
  $status_details_sl1                 = $this->uri->segment(6);

  $vessel_id                          = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                          = $this->encrypt->decode($vessel_id); 

  $processflow_sl                     = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                     = $this->encrypt->decode($processflow_sl); 

  $status_details_sl                  = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl                  = $this->encrypt->decode($status_details_sl); 

  if(!empty($sess_usr_id))
  {
    $data = array('title' => 'payment_details_form20', 'page' => 'payment_details_form20', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');

    $vesselDet                       = $this->Vessel_change_model->get_vesselDet($vessel_id);
    $data['vesselDet']               = $vesselDet; //print_r($vesselDet);exit;
    if(!empty($vesselDet))
    {
      $vessel_type_id                = $vesselDet[0]['vessel_type_id'];
      $vessel_subtype_id             = $vesselDet[0]['vessel_subtype_id'];
    }
 
    $process_data                    = $this->Vessel_change_model->get_process_flow_sl($vessel_id);
    $data['process_data']            = $process_data;
    $status_change_date1             = $process_data[0]['status_change_date'];
    //print_r($process_data);exit;

    $data['status_details_sl']       = $status_details_sl;
    $data['processflow_sl']          = $processflow_sl;

    $survey_id                       = 0;

    $engine_details                  = $this->Vessel_change_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']          = $engine_details;

    $no_of_engineset                 = count($engine_details);

    $registeringAuthority            = $this->Bookofregistration_model->get_registeringAuthority();
    $data['registeringAuthority']    = $registeringAuthority;//print_r($registeringAuthority);

    $insuranceCompany                = $this->Bookofregistration_model->get_insuranceCompany();
    $data['insuranceCompany']        = $insuranceCompany;

    $masClass                        = $this->Bookofregistration_model->get_masterClass();
    $data['masClass']                = $masClass;

    $plyingPort                      = $this->Bookofregistration_model->get_portofregistry();
    $data['plyingPort']              = $plyingPort;

    $vesselMasterDetails             = $this->Bookofregistration_model->get_crew_details($vessel_id,1);
    $data['vesselMasterDetails']     = $vesselMasterDetails;
    $vesselMasterDetails_count       = count($vesselMasterDetails);

    $bank                            =  $this->Survey_model->get_bank_favoring();
    $data['bank']                    =  $bank;


    $portofregistry                  =  $this->Survey_model->get_portofregistry();
    $data['portofregistry']          =  $portofregistry;

  //___________________________TARIFF DETAILS____________________________________________//

    $status_change_date              = date("Y-m-d", strtotime($status_change_date1));
    $now                             = date("Y-m-d");
    $date1_ts                        = strtotime($status_change_date);
    $date2_ts                        = strtotime($now);
    $diff                            = $date2_ts - $date1_ts;
    $numberofdays1                   = round($diff / 86400);
      

    $form_id                         = 20;
    $activity_id                     = 9;
      
    $tariff_details                  = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data1['tariff_details']         = $tariff_details; 
    if (!empty($tariff_details)) 
    {
      $tariff_amount1                = $tariff_details[0]['tariff_amount'];
      $tariff_min_amount             = $tariff_details[0]['tariff_min_amount'];
    }
      
    $tonnage_details                 = $this->Vessel_change_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']        = $tonnage_details;//print_r($tonnage_details);exit;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage         = $tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1                         = $vessel_total_tonnage*$tariff_amount1;

    if($amount1<100)
    {
      $data['tariff_amount']         = $tariff_min_amount;
    }
    else
    {
      $data['tariff_amount']         = $amount1;
    }

    //$this->form_validation->set_rules('justification', 'Justification', 'required');
    //$this->form_validation->set_rules('cetificate_type', 'Certificate Type', 'required');
    /*if ($this->form_validation->run() == FALSE)
    {
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
        echo "val_errors--".validation_errors();//exit;
       
    }   
    else  
    {*/

      if($this->input->post())
      { 
        date_default_timezone_set("Asia/Kolkata");
        $date                          = date('Y-m-d h:i:s', time());
        $ip                            = $_SERVER['REMOTE_ADDR'];
        $newDate                       = date("Y-m-d");

        $vessel_id                     = $this->security->xss_clean($this->input->post('vessel_sl'));
        $processflow_sl                = $this->security->xss_clean($this->input->post('processflow_sl'));
        $status_details_sl             = $this->security->xss_clean($this->input->post('status_details_sl'));
        $vessel_registry_port_id       = $this->security->xss_clean($this->input->post('vessel_registry_port_id'));
        $tariff_amount                 = $this->security->xss_clean($this->input->post('dd_amount'));

        $justification                 = $this->security->xss_clean($this->input->post('justification'));
        $fir_upload                    = $this->security->xss_clean($_FILES["fir_upload"]["name"]);
        $cetificate_type               = $this->security->xss_clean($this->input->post('cetificate_type'));
        $data['cetificate_type']       = $cetificate_type;
        

        $vessel_main                   = $this->Vessel_change_model->get_vessel_main($vessel_id);
        $data['vessel_main']           = $vessel_main;
        if(!empty($vessel_main))
        {
          $vesselmain_sl               = $vessel_main[0]['vesselmain_sl'];
        }
        
        //----FIR(start)---///
            
        if($fir_upload)
        {
            //echo "uploaded";
            $insfir_path_parts          = pathinfo($_FILES["fir_upload"]["name"]);
            $insfir_extension           = $insfir_path_parts['extension'];

            $insfir_file_name           = 'DUPL'.'_FIR_Form20_'.$vessel_id.'_'.$date.'.'.$insfir_extension; 
            $target                     = "./uploads/Duplicatecert_fir/".$insfir_file_name;
            $ins_upd                    = move_uploaded_file($_FILES["fir_upload"]["tmp_name"], $target);
        }
        else
        {
            $insfir_file_name           = '';
        }
        $fir_declaration                = pathinfo($_FILES['fir_upload']['name']);
        if($fir_declaration)
        {
            $extension                  = $fir_declaration['extension'];
        }
        else
        {
            $extension                  = "";
        }
        //----FIR(end)---///
        //////////////////////Reference Number For Duplicate Certificate Process (Start)////////////////////////////
          $dupcert_rws                  = $this->Vessel_change_model->get_dupcert_rws();
          $cntdup_rws                   = count($dupcert_rws);
          if($cntdup_rws==0){
            $value                      = "1";
          } elseif ($cntdup_rws>0) {
            $dupcert_last_refno         = $this->Vessel_change_model->get_dupcert_ref_number();
            foreach ($dupcert_last_refno as $ref_res) {
              $ref_no                   = $ref_res['ref_number'];
            }
            $ref_exp                    = explode('_', $ref_no);
            $ref_val                    = $ref_exp[1];
            $value                      = $ref_val + 1;
          }
          if($value<10){
            $value                      = "00".$value;
          } elseif ($value<100) {
            $value                      = "0".$value;
          } else {
            $value                      = $value;
          }
          $yr                           = date('Y');
          $ref_number                   = "DC"."_".$value."_".$vessel_id.$yr; 
          //////////////////////Reference Number For Duplicate Certificate Process (End)////////////////////////////
        
        $check_dupcert                  = $this->Vessel_change_model->get_dupcert_details($vessel_id); //print_r($check_dupcert);
        $count_rws                      = count($check_dupcert); //exit;
        if($count_rws>0){
          $data_dup = array('duplicate_cert_status'=>0);
          $dupcert_update_status        = $this->Vessel_change_model->update_dupcert_status('tbl_duplicate_certificate',$data_dup, $vessel_id);
            if($dupcert_update_status){
              $data_dupcertupd=array(
                'duplicate_cert_vessel_id'          =>  $vessel_id,
                'duplicate_cert_vessel_main_id'     =>  $vesselmain_sl,
                'ref_number'                        =>  $ref_number,
                'duplicate_cert_type'               =>  $cetificate_type,
                'duplicate_cert_req_date'           =>  $newDate,
                'duplicate_cert_justification'      =>  $justification,
                'duplicate_cert_fir_copy'           =>  $insfir_file_name,
                'duplicate_cert_decision_ipaddress' =>  $ip,
                'duplicate_cert_req_id'             =>  $sess_usr_id,
                'duplicate_cert_status'             =>  1
              );//print_r($data_dupcertupd); exit;

              $insertdupCert            = $this->security->xss_clean($data_dupcertupd);         
              $insertdupCert_res        = $this->db->insert('tbl_duplicate_certificate', $insertdupCert);
            }
          } else { 
            $dupCert=array(
              'duplicate_cert_vessel_id'            =>  $vessel_id,
              'duplicate_cert_vessel_main_id'       =>  $vesselmain_sl,
              'ref_number'                          =>  $ref_number,
              'duplicate_cert_type'                 =>  $cetificate_type,
              'duplicate_cert_req_date'             =>  $newDate,
              'duplicate_cert_justification'        =>  $justification,
              'duplicate_cert_fir_copy'             =>  $insfir_file_name,
              'duplicate_cert_decision_ipaddress'   =>  $ip,
              'duplicate_cert_req_id'               =>  $sess_usr_id,
              'duplicate_cert_status'               =>  1
            );//print_r($dupCert); exit;

            
            $insertdupCert            = $this->security->xss_clean($dupCert);         
            $insertdupCert_res        = $this->db->insert('tbl_duplicate_certificate', $insertdupCert);
         } 
      } 
      $data = $data + $this->data;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/payment_details_form20',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
    //}  
  } 
  else
  {
    redirect('Main_login/index');        
  }

} 
public function pay_now_form20()
{ //print_r($_POST);exit;

 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                      = $this->session->userdata('customer_id');
  $survey_user_id                   = $this->session->userdata('survey_user_id');


  $vessel_id1                       = $this->uri->segment(4);
  $processflow_sl1                  = $this->uri->segment(5);
  $status_details_sl1               = $this->uri->segment(6);

  $vessel_id                        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                        = $this->encrypt->decode($vessel_id); 

  $processflow_sl                   = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                   = $this->encrypt->decode($processflow_sl); 

  $status_details_sl                = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl                = $this->encrypt->decode($status_details_sl); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'pay_now_form20', 'page' => 'pay_now_form20', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Bookofregistration_model');
    $this->load->model('Kiv_models/Vessel_change_model');

    date_default_timezone_set("Asia/Kolkata");
    $date                          = date('Y-m-d h:i:s', time());
    $ip                            = $_SERVER['REMOTE_ADDR'];
    $newDate                       = date("Y-m-d");
    $vessel_id                     = $this->security->xss_clean($this->input->post('vessel_sl'));
    $processflow_sl                = $this->security->xss_clean($this->input->post('processflow_sl'));
    $status_details_sl             = $this->security->xss_clean($this->input->post('status_details_sl'));

  
    $process_id                    = $this->security->xss_clean($this->input->post('process_id')); 
    $current_status_id             = $this->security->xss_clean($this->input->post('current_status_id'));
    $current_position              = $this->security->xss_clean($this->input->post('current_position'));
    //$cetificate_type               = $this->security->xss_clean($this->input->post('cetificate_type')); 
    $status_change_date            = $date;
    $survey_id                     = 0;
   
    $user_id                       = $this->security->xss_clean($this->input->post('user_id'));
    $status                        = 1;
    $paymenttype_id                = 4;
    $dd_amount                     = $this->security->xss_clean($this->input->post('dd_amount'));
    $portofregistry_sl             = $this->security->xss_clean($this->input->post('portofregistry_sl'));
        
    $form_number_cs                = $this->Vessel_change_model->get_form_number_cs($process_id);
    $data['form_number_cs']        = $form_number_cs;
    if(!empty($form_number_cs))
    {
      $formnumber                  = $form_number_cs[0]['form_no'];
    }
    $vessel_main                   = $this->Vessel_change_model->get_vessel_main($vessel_id);
    $data['vessel_main']           = $vessel_main;
    if(!empty($vessel_main))
    {
      $vesselmain_sl               = $vessel_main[0]['vesselmain_sl'];
    }
   
    /*$data_payment=array(
      'vessel_id'                 => $vessel_id,
      'survey_id'                 => $survey_id,
      'form_number'               => $formnumber,
      'paymenttype_id'            => $paymenttype_id,
      'dd_amount'                 => $dd_amount,
      'dd_date'                   => $newDate,
      'portofregistry_id'         => $portofregistry_sl,
      'payment_created_user_id'   => $sess_usr_id,
      'payment_created_timestamp' => $date,
      'payment_created_ipaddress' => $ip
    );

  //print_r($data_payment);exit;


    $result_insert                 = $this->db->insert('tbl_kiv_payment_details', $data_payment); 
    $task_pfid                     = $this->Survey_model->get_task_pfid($processflow_sl);
    $data['task_pfid']             = $task_pfid;
    @$task_sl                      = $task_pfid[0]['task_sl'];



  $port_registry_user_id           = $this->Vessel_change_model->get_port_registry_user_id($portofregistry_sl);
  $data['port_registry_user_id']   = $port_registry_user_id;
  if(!empty($port_registry_user_id))
  {
    $pc_user_id                    = $port_registry_user_id[0]['user_sl'];
    $pc_usertype_id                = $port_registry_user_id[0]['user_type_id'];
  }
    
  if($process_id==41)
  {
    /////process flow start indication---- tb_vessel_main processing_status to be changed as 1
    $data_mainupdate  = array('processing_status'=>1); //print_r($data_mainupdate);exit;
    ///tbl_ownership_change payment status
    $data_dupcertupdate  = array(
      'duplicate_payment_status'    => 1, 
      'duplicate_cert_payment_date' => $newDate
    );//print_r($data_dupcertupdate);exit;
    /////insert to processflow table showing curre

    $data_insert=array(
      'vessel_id'                   => $vessel_id,
      'process_id'                  => $process_id,
      'survey_id'                   => $survey_id,
      'current_status_id'           => 2,
      'current_position'            => $pc_usertype_id,
      'user_id'                     => $pc_user_id,
      'previous_module_id'          => $processflow_sl,
      'status'                      => $status,
      'status_change_date'          => $status_change_date
    ); //print_r($data_insert);exit;

    //////update current process status=0
    $data_update=array(
      'status'                      => 0
    );
    //////update status details table
    $data_survey_status=array(
      'survey_id'                   => $survey_id,
      'process_id'                  => $process_id,
      'current_status_id'           => 2,
      'sending_user_id'             => $sess_usr_id,
      'receiving_user_id'           => $pc_user_id
    );//print_r($data_survey_status);exit;

      $dupcertf_update   = $this->Vessel_change_model->update_dupcert_status('tbl_duplicate_certificate',$data_dupcertupdate, $vessel_id);
      $vesselmain_update = $this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
      $process_update    = $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert    = $this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $status_update     = $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      if($dupcertf_update && $vesselmain_update && $process_update && $process_insert && $status_update && $result_insert)
      {
        redirect("Kiv_Ctrl/Survey/SurveyHome");
      }
   }*/

   //____________________________________________________START ONLINE TRANSACTION__________________________________//

    /*_____________________Start Get vessel condition_______________ */   

    $vessel_condition                 = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition']         = $vessel_condition;
   
    if(!empty($vessel_condition))
    {
      $vessel_type_id                 = $vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id              = $vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1                 = $vessel_condition[0]['vessel_length'];
      $hullmaterial_id                = $vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id            = $vessel_condition[0]['engine_placement_id'];
    }  
    /*_____________________End Get vessel condition___________________*/

    /*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
    $form_id                          = 20;
    $activity_id                      = 9;

    $tariff_details                   = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data1['tariff_details']          = $tariff_details; //print_r($tariff_details);exit;
    if (!empty($tariff_details)) 
    {
      $tariff_amount1                 = $tariff_details[0]['tariff_amount'];
      $tariff_min_amount              = $tariff_details[0]['tariff_min_amount'];
    }
      
    $tonnage_details                  = $this->Vessel_change_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']         = $tonnage_details;//print_r($tonnage_details);exit;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage          = $tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1                          = $vessel_total_tonnage*$tariff_amount1;

    if($amount1<100)
    {
      //$data['tariff_amount']          = $tariff_min_amount;
      $tariff_amount                  = 1;
    }
    else
    {
      //$data['tariff_amount']          = $amount1;
      $tariff_amount                  = 1;
    }
    /*_______________________________________________END Tariff____________________________ */   

    /*___________________________________________________________________________ */   
    if($this->input->post())
    { //print_r($_POST);
      //$dd_amount1           = $this->security->xss_clean($this->input->post('dd_amount'));
      $portofregistry_sl                = $this->security->xss_clean($this->input->post('portofregistry_sl'));
      $bank_sl                          = $this->security->xss_clean($this->input->post('bank_sl'));
      $vessel_sl                        = $this->security->xss_clean($this->input->post('vessel_sl'));
      $status                           = 1;

      $vessel_main                      = $this->Vessel_change_model->get_vessel_main($vessel_sl);
      $data['vessel_main']              = $vessel_main;
      if(!empty($vessel_main))
      {
        $vesselmain_sl                  = $vessel_main[0]['vesselmain_sl'];
      }

      $vessel_condition                 = $this->Vessel_change_model->get_vessel_details_dynamic($vessel_sl);
      $data['vessel_condition']         = $vessel_condition; 
     
      if(!empty($vessel_condition))
      {
        $vessel_type_id                 = $vessel_condition[0]['vessel_type_id'];
        $vessel_subtype_id              = $vessel_condition[0]['vessel_subtype_id'];
        $vessel_length1                 = $vessel_condition[0]['vessel_length'];
        $hullmaterial_id                = $vessel_condition[0]['hullmaterial_id'];
        $engine_placement_id            = $vessel_condition[0]['engine_placement_id'];
      }  
      /*_____________________End Get vessel condition___________________*/

      /*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
      $form_id                          = 20;
      $activity_id                      = 9;

      $tariff_details                   = $this->Vessel_change_model->get_tariff_form11($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
      $data1['tariff_details']          = $tariff_details; 
      if (!empty($tariff_details)) 
      {
        $tariff_amount1                 = $tariff_details[0]['tariff_amount'];
        $tariff_min_amount              = $tariff_details[0]['tariff_min_amount'];
      }
        
      $tonnage_details                  = $this->Vessel_change_model->get_tonnage_details($vessel_sl);
      $data1['tonnage_details']         = $tonnage_details;//print_r($tonnage_details);exit;
      if(!empty($tonnage_details))
      {
        @$vessel_total_tonnage          = $tonnage_details[0]['vessel_total_tonnage'];
      }
      $amount1                          = $vessel_total_tonnage*$tariff_amount1;

      if($amount1<100)
      {///for checking payment
        //$tariff_amount                  = $tariff_min_amount;
        $tariff_amount                  = 1;
      }
      else
      {//for checking payment
        //$tariff_amount                  = $amount1;
        $tariff_amount                  = 1;
      }

      $payment_user                     = $this->Vessel_change_model->get_payment_userdetails($sess_usr_id);
      $data['payment_user']             = $payment_user;
      //print_r($payment_user);exit;
      if(!empty($payment_user))
      {
        $owner_name                     = $payment_user[0]['user_name'];
        $user_mobile_number             = $payment_user[0]['user_mobile_number'];
        $user_email                     = $payment_user[0]['user_email'];
      }
      $formnumber                       = 20;
      $survey_id                        = 0;

      date_default_timezone_set("Asia/Kolkata");
      $ip                               = $_SERVER['REMOTE_ADDR'];
      $date                             = date('Y-m-d h:i:s', time());
      $newDate                          = date("Y-m-d");
      $status_change_date               = $date;


      $milliseconds                     = round(microtime(true) * 1000); //Generate unique bank number

      $bank_gen_number                  = $this->Survey_model->get_bank_generated_last_number($bank_sl);
      $data['bank_gen_number']          = $bank_gen_number;

      if(!empty($bank_gen_number))
      {
        $bank_generated_number          = $bank_gen_number[0]['last_generated_no']+1;

        $transaction_id                 = $user_type_id.$sess_usr_id.$vessel_sl.$bank_sl.$milliseconds.$bank_generated_number;
        $tocken_number                  = $user_type_id.$sess_usr_id.$vessel_sl.$bank_sl.$milliseconds;

        $bank_data                      = array('last_generated_no'=>$bank_generated_number);//print_r($bank_data);exit;

        $data_payment_request=array(
          'transaction_id'              => $transaction_id,
          'bank_ref_no'                 => 0,
          'token_no'                    => $tocken_number,
          'vessel_id'                   => $vessel_sl,
          'survey_id'                   => $survey_id,
          'form_number'                 => $formnumber,
          'customer_registration_id'    => $sess_usr_id,
          'customer_name'               => $owner_name,
          'mobile_no'                   => $user_mobile_number,
          'email_id'                    => $user_email,
          'transaction_amount'          => $tariff_amount,
          'remitted_amount'             => 0,
          'bank_id'                     => $bank_sl,
          'transaction_status'          => 0,
          'payment_status'              => 0,
          'transaction_timestamp'       => $date,
          'transaction_ipaddress'       => $ip,
          'port_id'                     => $portofregistry_sl
        ); //print_r($data_payment_request);exit;


        $result_insert=$this->db->insert('kiv_bank_transaction_request', $data_payment_request); 
        if($result_insert)
        {
          //echo "hii"; exit;
          $bank_transaction_id          = $this->db->insert_id();
          $update_bank                  = $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);

        //-------get Working key-----------//
          $online_payment_data          = $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
          $data['online_payment_data']  = $online_payment_data; //print_r($online_payment_data);exit;

        //------------------owner details-------------------//

          $payment_user1                = $this->Survey_model->get_payment_userdetails($sess_usr_id);
          $data['payment_user1']        = $payment_user1;



          $requested_transaction_details= $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
          $data['requested_transaction_details']  =   $requested_transaction_details;

          $data['amount_tobe_pay']      = $tariff_amount;
          $data                         = $data+ $this->data;
         //print_r($data);
         //exit;
           ///Actual Data --- Commented for testing(start)//////
          /*if(!empty($online_payment_data))
          { 
             
            $this->load->view('Kiv_views/Hdfc/hdfc_dupcertonlinepayment_request',$data);
             
          }
          else
          {
            
            redirect('Kiv_Ctrl/Survey/SurveyHome');
          
          }*/
           ///Actual Data --- Commented for testing(end)//////
          if(!empty($online_payment_data))
          { 
             
            //$this->load->view('Kiv_views/Hdfc/hdfc_dupcertonlinepayment_request',$data);
            date_default_timezone_set("Asia/Kolkata");
            $ip                   = $_SERVER['REMOTE_ADDR'];
            $date                 =   date('Y-m-d h:i:s', time());
            $newDate              =   date("Y-m-d");

            $vessel_main                    = $this->Vessel_change_model->get_vessel_main($vessel_sl);
            $data['vessel_main']            = $vessel_main; 
            if(!empty($vessel_main))
            {
              $vesselmain_sl                = $vessel_main[0]['vesselmain_sl'];
            }
            $status_details             =   $this->Survey_model->get_status_details_vessel_sl($vessel_sl);
            $data['status_details']     =   $status_details;
            if(!empty($status_details))
            {
              $status_details_sl        =   $status_details[0]['status_details_sl'];
            }
            $processflow_vessel           =   $this->Survey_model->get_processflow_vessel($vessel_sl);
            $data['processflow_vessel']   =   $processflow_vessel;
            if(!empty($processflow_vessel))
            {
              $processflow_sl           =   $processflow_vessel[0]['processflow_sl'];
              $process_id         =   $processflow_vessel[0]['process_id'];
            }
            /*$data_portofregistry=array(
            'vessel_registry_port_id'     => $portofregistry_sl
            );
            $update_portofregistry        = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);*/
            $port_registry_user_id        =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
            $data['port_registry_user_id']  =   $port_registry_user_id;
            if(!empty($port_registry_user_id))
            {
              $pc_user_id           = $port_registry_user_id[0]['user_master_id'];
              $pc_usertype_id         = $port_registry_user_id[0]['user_master_id_user_type'];
            }
            $data_payment=array(
            'vessel_id'         =>  $vessel_sl,
            'survey_id'         =>  9,
            'form_number'         =>  $formnumber,
            'paymenttype_id'        =>  4,
            'dd_amount'         =>  $tariff_amount,
            'dd_date'           =>  $newDate,
            'portofregistry_id'     =>  $portofregistry_sl,
            'bank_id'           =>  $bank_sl,
            'payment_mode'        =>  'Credit Card',
            'transaction_id'        =>  $bank_transaction_id,
            'payment_created_user_id'   =>  $sess_usr_id,
            'payment_created_timestamp' =>  $date,
            'payment_created_ipaddress' =>  $ip); //print_r($data_payment);exit;

            /*if($process_id==38)
            {*/
            /////process flow start indication---- tb_vessel_main processing_status to be changed as 1
            $data_mainupdate=array(
            'processing_status'     =>  1);
            ///tbl_owner_change payment status
            $data_dupcertupdate  = array(
            'duplicate_payment_status'    => 1, 
            'duplicate_cert_payment_date' => $newDate);//print_r($data_dupcertupdate);exit;

            /////insert to processflow table showing curre
            $data_insert=array(
            'vessel_id'             =>  $vessel_sl,
            'process_id'            =>  41,
            'survey_id'             =>  $survey_id,
            'current_status_id'     =>  2,
            'current_position'      =>  $pc_usertype_id,
            'user_id'               =>  $pc_user_id,
            'previous_module_id'    =>  $processflow_sl,
            'status'                =>  1,
            'status_change_date'    =>  $date); //print_r($data_insert);exit;

            //////update current process status=0
            $data_update=array(
            'status'          =>  0);

            //////update status details table
            $data_survey_status=array(
            'survey_id'             =>  $survey_id,
            'process_id'            =>  41,
            'current_status_id'     =>  2,
            'sending_user_id'       =>  $sess_usr_id,
            'receiving_user_id'     =>  $pc_user_id); print_r($data_survey_status);


            if($tariff_amount>0 && $portofregistry_sl!=false)
            {
              //echo "Amt".$amount."---Port".$portofregistry_sl."---Vesmain".$vesselmain_sl."---Vesid".$vessel_id."---Proce".$processflow_sl."---Stat".$status_details_sl;exit;
              $result_insert        = $this->db->insert('tbl_kiv_payment_details', $data_payment);
              $vesselmain_update      = $this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
              $dupcertf_update        = $this->Vessel_change_model->update_dupcert_status('tbl_duplicate_certificate',$data_dupcertupdate, $vessel_id);
              $process_update       = $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
              $process_insert       = $this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
              $status_update        = $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
              //}
              if($vesselmain_update && $dupcertf_update && $process_update && $process_insert && $status_update && $result_insert)
              {
                ///get user mail////
                $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($pc_user_id);
                if(!empty($user_mail_id))
                {
                  foreach($user_mail_id as $mail_res)
                  {
                    $user_mail    = $mail_res['user_email'];
                    $user_name    = $mail_res['user_name'];
                    $user_mob     = $mail_res['user_mobile_number'];
                  }
                }
                $dup_refno          =   $this->Vessel_change_model->getduplicatecert($vessel_id);
                if(!empty($dup_refno))
                {
                  foreach($dup_refno as $dup_res)
                  {
                    $refno        = $dup_res['ref_number'];
                    $main_id        = $dup_res['vesselmain_sl'];
                    $reg_no       = $dup_res['vesselmain_reg_number'];
                    $vessel       = $dup_res['vesselmain_vessel_name'];
                  }
                }
                
                $portna       =   $this->Vessel_change_model->get_registry_port_id($portofregistry_sl);
                foreach($portna as $port_res){
                  $port_name  = $port_res['vchr_portoffice_name'];
                }

                 
                /*------------code for send email starts---------------*/
                $config = Array(
                'protocol'        => 'smtp',
                'smtp_host'       => 'ssl://smtp.googlemail.com',
                'smtp_port'       => 465,
                'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
                'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
                'mailtype'        => 'html',
                'charset'         => 'iso-8859-1');//print_r($config);exit;

                $message = 'Dear '.$user_name.',<br/><br/>

                Payment of Rs. '.$tariff_amount.' for your vessel, '.$reg_no.' ( '.$vessel.' ) for Duplicate Certificate has been received.  Request for Duplicate certificate for the vessel '.$reg_no.' is in process.  <br/><br/>

                Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

                Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

                For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

                Warm Regards<br/><br/>

                Kerala Maritime Board ';
                $smsmsg = 'Payment of Rs. '.$tariff_amount.' for '.$reg_no.' is received, and forwarded to'. $port_name.' Port Conservator. Reference Number:  '.$refno.'.';
                //$message = 'The Duplicate Certificate Request (Ref. No:'.$refno.') for the Vessel has been sent by the Vessel Owner. Please Verify for further Processing.';
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('kivportinfo@gmail.com'); // change it to yours
                //$this->email->to($user_mail);// change it to yours
                $this->email->to('deepthi.nh@gmail.com');
                $this->email->subject('Payment of Rs. '.$tariff_amount.' has been received for Duplicate Certificate-reg.');
                $this->email->message($message);
                if($this->email->send())
                { 
                  redirect('Kiv_Ctrl/VesselChange/duplicatecertificate_list');
                  //echo "success";redirect("Bookofregistration/raHome");
                  // <!------------code for send SMS starts--------------->
                  $this->load->model('Kiv_models/Vessel_change_model');
                  $mobil="9809119144";
                  $stat = $this->Vessel_change_model->sendSms($message,$mobil);
                  //print_r($stat);exit;
                  //echo json_encode("success");
                  //redirect("Bookofregistration/raHome");

                  /*------------code for send SMS ends---------------*/
                }
                else
                {
                  show_error($this->email->print_debugger());
                } 
              }
            }
             
          }
          else
          {
            
            redirect('Kiv_Ctrl/Survey/SurveyHome');
          
          }
        
        }
        else
        {
        /* echo '<script language="javascript">';
            echo 'alert(Please try after some time!)'; 
            echo '</script>';*/
          redirect('Kiv_Ctrl/Survey/SurveyHome');
        }

      }
      else
      {
        redirect('Kiv_Ctrl/Survey/SurveyHome');
      }
    } 
//____________________________________________________END ONLINE TRANSACTION__________________________________//
  }
}
public function Verify_payment_pc_form20()
{
 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                    = $this->session->userdata('customer_id');
  $survey_user_id                 = $this->session->userdata('survey_user_id');


  $vessel_id1                     = $this->uri->segment(4);
  $processflow_sl1                = $this->uri->segment(5);
  $survey_id1                     = $this->uri->segment(6);

  $vessel_id                      = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                      = $this->encrypt->decode($vessel_id); 

  $processflow_sl                 = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                 = $this->encrypt->decode($processflow_sl); 

  $survey_id                      = str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id                      = $this->encrypt->decode($survey_id); 


  if(!empty($sess_usr_id) && ($user_type_id==3))
  {
    $data   =  array('title' => 'Verify_payment_pc_form20', 'page' => 'Verify_payment_pc_form20', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $vessel_details               = $this->Vessel_change_model->get_process_flow($processflow_sl);
    $data['vessel_details']       = $vessel_details;
    @$id                          = $vessel_details[0]['user_id'];

    $customer_details             = $this->Vessel_change_model->get_customer_details($id);
    $data['customer_details']     = $customer_details;

    $current_status               = $this->Vessel_change_model->get_status();
    $data['current_status']       = $current_status;

    $form_number                  = $this->Vessel_change_model->get_form_number($vessel_id);
    $data['form_number']          = $form_number;
    $form_id                      = $form_number[0]['form_no'];

    $buyer_details                = $this->Vessel_change_model->get_buyer_details($vessel_id);
    $data['buyer_details']        = $buyer_details;

    //----------Vessel Details--------//

    $vessel_details_viewpage        =  $this->Vessel_change_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;

    //----------Payment Details--------//

    $payment_details              = $this->Vessel_change_model->get_form_payment_details($vessel_id,9,$form_id);
    $data['payment_details']      = $payment_details;
    //print_r($payment_details);
    if($this->input->post())
    { //print_r($_POST);exit;

      date_default_timezone_set("Asia/Kolkata");
      $date                       = date('Y-m-d h:i:s', time());
      $vessel_id                  = $this->security->xss_clean($this->input->post('vessel_id'));  
      $process_id                 = $this->security->xss_clean($this->input->post('process_id')); 
      $survey_id                  = $this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id          = $this->security->xss_clean($this->input->post('current_status_id'));
      //$current_position   = $this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date         = $date;
      $processflow_sl             = $this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id                    = $this->security->xss_clean($this->input->post('user_id'));
      //$user_sl_cs_sr      = $this->security->xss_clean($this->input->post('user_sl_cs'));
      $status                     = 1;

      $status_details_sl1         = $this->security->xss_clean($this->input->post('status_details_sl'));
      $payment_sl                 = $this->security->xss_clean($this->input->post('payment_sl'));
      $payment_approved_remarks   = $this->security->xss_clean($this->input->post('remarks'));



      $date                       = date('Y-m-d h:i:s', time());
      $ip                         = $_SERVER['REMOTE_ADDR'];
      $status_change_date         = $date;

      $usertype                   = $this->Survey_model->get_user_id_cs(14);
      $data['usertype']           = $usertype;
      if(!empty($usertype))
      {
        $user_sl_ra               = $usertype[0]['user_master_id'];
        $user_type_id_ra          = $usertype[0]['user_master_id_user_type'];
      }

      if($process_id==41)
      {

        $data_payment=array(
          'payment_approved_status'         => 1,
          'payment_approved_user_id'        => $sess_usr_id,
          'payment_approved_datetime'       => $status_change_date,
          'payment_approved_ipaddress'      => $ip,
          'payment_approved_remarks'        => $payment_approved_remarks
        ); 

        $data_duplicert=array(
          'duplicate_cert_pc_verified_date' => $status_change_date,
          'duplicate_cert_verify_id'        => $sess_usr_id
        ); //print_r($data_ownershipchange);exit;

        $data_insert=array(
          'vessel_id'                       => $vessel_id,
          'process_id'                      => $process_id,
          'survey_id'                       => $survey_id,
          'current_status_id'               => 2,
          'current_position'                => $user_type_id_ra,
          'user_id'                         => $user_sl_ra,
          'previous_module_id'              => $processflow_sl,
          'status'                          => $status,
          'status_change_date'              => $status_change_date
        );//print_r($data_insert);exit;

        $data_update=array(
          'status'                          => 0
        );

        $data_survey_status=array(
          'current_status_id'               => 2,
          'sending_user_id'                 => $sess_usr_id,
          'receiving_user_id'               => $user_sl_ra
        );//echo $status_details_sl1;
      //print_r($data_survey_status);
      //exit;


      $payment_update    = $this->Vessel_change_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);
      $duplicert_update  = $this->Vessel_change_model->update_duplicatecert('tbl_duplicate_certificate',$data_duplicert, $vessel_id);

      $process_update    = $this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert    = $this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);

      $status_update     = $this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl1);

    

      if($payment_update && $duplicert_update && $process_update && $process_insert && $status_update)
      {
        //redirect("Kiv_Ctrl/Survey/pcHome");
        ///get user mail////
            $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($user_sl_ra);
            if(!empty($user_mail_id))
            {
              foreach($user_mail_id as $mail_res){
                $user_mail    = $mail_res['user_email'];
                $user_name    = $mail_res['user_name'];
                $user_mob     = $mail_res['user_mobile_number'];
              }
            }
             $dup_refno          =   $this->Vessel_change_model->getduplicatecert($vessel_id);
                if(!empty($dup_refno))
                {
                  foreach($dup_refno as $dup_res)
                  {
                    $refno        = $dup_res['ref_number'];
                    $main_id        = $dup_res['vesselmain_sl'];
                    $reg_no       = $dup_res['vesselmain_reg_number'];
                    $vessel       = $dup_res['vesselmain_vessel_name'];
                  }
                }
                
                $portna       =   $this->Vessel_change_model->get_registry_port_id($portofregistry_sl);
                foreach($portna as $port_res){
                  $port_name  = $port_res['vchr_portoffice_name'];
                }
                $payment     =  $this->Vessel_change_model->get_payment_details($payment_sl,$vessel_id);
                foreach($payment as $pay_res){
                  $amount  = $pay_res['dd_amount'];
                }
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
             $message = 'Dear '.$own_name.',<br/><br/>

                Payment of Rs. '.$amount.' for your vessel, '.$reg_no.' ( '.$vessel.' ) for Duplicate Certificate has been verified by '.$port_name.' Port Conservator.  Request for duplicate certificate for the vessel '.$reg_no.'  is processed by Registering Authority. <br/><br/>

                Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

                Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

                For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

                Warm Regards<br/><br/>

                Kerala Maritime Board ';
                $smsmsg = 'Payment of Rs. '.$amount.' for '.$reg_no.' is verified and forwarded to Registering Authority. Reference Number:  '.$refno;            
            //$message = 'The Duplicate Certificate Request (Ref. No:'.$refno.') for the Vessel has been sent by the Port Conservator after verifying the payment. Please Verify for further Processing.';
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('kivportinfo@gmail.com'); // change it to yours
            //$this->email->to($user_mail);// change it to yours
            $this->email->to('deepthi.nh@gmail.com');

            $this->email->subject('Payment of Rs. '.$amount.' has been verified by '.$port_name.' PC  for Duplicate Certificate-reg.');
            $this->email->message($message);
            if($this->email->send())
            { //echo "success";redirect("Kiv_Ctrl/Bookofregistration/raHome");
            // <!------------code for send SMS starts--------------->
              $this->load->model('Kiv_models/Vessel_change_model');
              //$mobil="9809119144";
              $mobil=$user_mob;

             $moduleid        = 2;
            $modenc          = $this->encrypt->encode($moduleid); 
            $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
              redirect("Kiv_Ctrl/Survey/pcHome/".$modidenc);
              //$stat = $this->Vessel_change_model->sendSms($message,$mobil);
             // redirect("Kiv_Ctrl/Survey/pcHome");
              //print_r($stat);exit;
              //echo json_encode("success");
              //redirect("Kiv_Ctrl/Bookofregistration/raHome");
              
              /*------------code for send SMS ends---------------*/
            }
            else
            {
              show_error($this->email->print_debugger());
            } 

      }
    }
   }

      $this->load->view('Kiv_views/template/dash-header.php');
        $this->load->view('Kiv_views/template/nav-header.php');
        $this->load->view('Kiv_views/dash/Verify_payment_pc_form20',$data);
        $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
      redirect('Main_login/index');        
  }
}
public function view_form20()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                    = $this->session->userdata('customer_id');
  $survey_user_id                 = $this->session->userdata('survey_user_id');

  $vessel_id1                     = $this->uri->segment(4);
  $processflow_sl1                = $this->uri->segment(5);
  $status_details_sl1             = $this->uri->segment(6);

  $vessel_id                      = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                      = $this->encrypt->decode($vessel_id); 

  $processflow_sl                 = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                 = $this->encrypt->decode($processflow_sl); 

  $status_details_sl              = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl              = $this->encrypt->decode($status_details_sl); 
  $survey_id                      = 0;


  if(!empty($sess_usr_id) && ($user_type_id==14))
  {
    $data       =  array('title' => 'view_form20', 'page' => 'view_form20', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $initial_data                 = $this->Vessel_change_model->get_process_flow($processflow_sl);
    $data['initial_data']         = $initial_data;
  //print_r($initial_data);

    $intimation_type_id           = 5;

    $registration_intimation          = $this->Vessel_change_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']  = $registration_intimation;
    $vessel_change_det                = $this->Vessel_change_model->get_vesselduplicert_details_ra($vessel_id);
    $data['vessel_change_det']        = $vessel_change_det;
    $payment_det                      = $this->Vessel_change_model->get_dupcert_payment_ra($vessel_id);
    $data['payment_det']              = $payment_det;
    $dupcert_det                      = $this->Vessel_change_model->get_dupcert_details($vessel_id);
    $data['dupcert_det']              = $dupcert_det;

    $stern_material                   = $this->Bookofregistration_model->get_stern_material();
    $data['stern_material']           = $stern_material;

    $plyingPort                       = $this->Bookofregistration_model->get_portofregistry();
    $data['plyingPort']               = $plyingPort;

      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/view_form20',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
    
  }
  else
  {
    redirect('Main_login/index');
  }
  
}
public function form20_certificate()
{
   $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id) && (($user_type_id==11) || ($user_type_id==12) || ($user_type_id==13) || ($user_type_id==14)))
  {
  $this->load->model('Kiv_models/Vessel_change_model');
  $vessel_id1                         = $this->uri->segment(4);

  $vessel_id                          = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                          = $this->encrypt->decode($vessel_id); 
  
  //$this->load->view('Kiv_views/dash/form11_certificate_view',$data);
  $this->load->library('Pdf.php');
  $pdf =  $this->pdf->load();
  $pdf->allow_charset_conversion=true;  // Set by default to TRUE
  $pdf->charset_in='UTF-8';
  $pdf->autoLangToFont = true;

  $pdf->showImageErrors = true;
  ini_set('memory_limit', '256M');

  $pdfFilePath  = "form20_certificate_".$vessel_id.".pdf";   
  $html         = $this->load->view('Kiv_views/dash/form20_certificate_view',$vessel_id,true);
  $output       = $pdf->WriteHTML($html);
  $pdf->Output($output.$pdfFilePath, 'D');
  exit(); 
   }
  else
  {
    redirect('Main_login/index');
  }
}
function duplicert_intimation_send()
{ //print_r($_POST);exit;
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                        = $this->session->userdata('customer_id');
  $survey_user_id                     = $this->session->userdata('survey_user_id');


  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'duplicert_intimation_send', 'page' => 'duplicert_intimation_send', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');


  $vessel_id1                         = $this->uri->segment(4);
  $processflow_sl1                    = $this->uri->segment(5);
  $status_details_sl1                 = $this->uri->segment(6);

  $vessel_id                          = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                          = $this->encrypt->decode($vessel_id); 

  $processflow_sl                     = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl                     = $this->encrypt->decode($processflow_sl); 

  $status_details_sl                  = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl                  = $this->encrypt->decode($status_details_sl); 
  $survey_id                          = 0;
  if($this->input->post())
  { //print_r($_POST); print_r($_FILES);exit;
    date_default_timezone_set("Asia/Kolkata");
    $date                             = date('Y-m-d h:i:s', time());
    $status_change_date               = $date;
    $remarks_date                     = date('Y-m-d');
    $ip                               = $_SERVER['REMOTE_ADDR'];
   //print_r($_FILES);

    $vessel_id                        = $this->security->xss_clean($this->input->post('vessel_id'));  
    $process_id                       = $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id                        = $this->security->xss_clean($this->input->post('survey_id'));
    $processflow_sl                   = $this->security->xss_clean($this->input->post('processflow_sl'));
    $status_details_sl                = $this->security->xss_clean($this->input->post('status_details_sl'));
    $current_position                 = $this->security->xss_clean($this->input->post('current_position'));
    $user_id                          = $this->security->xss_clean($this->input->post('user_sl_ra'));
    $registration_intimation_sl       = $this->security->xss_clean($this->input->post('registration_intimation_sl'));
    $user_id_owner                    = $this->security->xss_clean($this->input->post('user_id_owner'));
    $user_type_id_owner               = $this->security->xss_clean($this->input->post('user_type_id_owner'));
    $current_status_id                = $this->security->xss_clean($this->input->post('current_status_id'));
    $status                           = 1;

    $change_inspection_date           = $this->security->xss_clean($this->input->post('change_inspection_date'));
    $portofregistry_sl                = $this->security->xss_clean($this->input->post('portofregistry_sl'));
    $change_intimation_remark         = $this->security->xss_clean($this->input->post('change_intimation_remark'));
    $change_inspection_report_upload  = $this->security->xss_clean($_FILES["change_inspection_report_upload"]["name"]);
    if($change_inspection_report_upload)
    {
      echo "uploaded";
      $ins_path_parts                 = pathinfo($_FILES["change_inspection_report_upload"]["name"]);
      $ins_extension                  = $ins_path_parts['extension'];

      echo $ins_file_name             = 'DUPL'.'_INSPRPT_Form11_'.$vessel_id.'_'.$date.'.'.$ins_extension;
      $target                         = "./uploads/DuplicateCert_Intimation/".$ins_file_name;
      $ins_upd                        = move_uploaded_file($_FILES["change_inspection_report_upload"]["tmp_name"], $target);
    }
    else
    {
      echo "not";
    }
    $change_inspection                =   pathinfo($_FILES['change_inspection_report_upload']['name']);
    if($change_inspection)
    {
    $extension                        =   $change_inspection['extension'];
    }
    else
    {
    $extension  ="";
    }
    
      /*$pdf_name=$vessel_id.'_'.$intimation_sl.'_'.$survey_defects_sl.'_'.$random_number.'.'.$extension;
    copy($_FILES["defect_intimation"]["tmp_name"], "./uploads/defects/".$pdf_name);*/


    if($process_id==41)
    {
      $data_reg_intimation=array(
        'vessel_id'                                => $vessel_id,
        'registration_intimation_type_id'          => 5,
        'registration_intimation_place_id'         => $portofregistry_sl, 
        'registration_intimation_remark'           => $change_intimation_remark,
        'registration_inspection_report_upload'    => $ins_file_name,
        'registration_inspection_date'             => $change_inspection_date,
        'registration_inspection_status'           => 1,
        'registration_inspection_created_user_id'  => $user_id,
        'registration_inspection_created_timestamp'=> $date,
        'registration_inspection_created_ipaddress'=> $ip
      ); //print_r($data_reg_intimation);exit;
      $insert_intimation = $this->Survey_model->insert_doc('a5_tbl_registration_intimation', $data_reg_intimation);

      $intimation_data=array(
        'registration_inspection_status'=>0
      );


      $data_insert=array(
        'vessel_id'                                => $vessel_id,
        'process_id'                               => $process_id,
        'survey_id'                                => $survey_id,
        'current_status_id'                        => 7,
        'current_position'                         => $current_position,
        'user_id'                                  => $sess_usr_id,
        'previous_module_id'                       => $processflow_sl,
        'status'                                   => $status,
        'status_change_date'                       => $status_change_date
      );//print_r($data_insert);


      $data_update=array(
        'status'                                   => 0
      );

      $data_survey_status=array(
        'process_id'                               => $process_id,
        'survey_id'                                => $survey_id,
        'current_status_id'                        => 7,
        'sending_user_id'                          => $sess_usr_id,
        'receiving_user_id'                        => $sess_usr_id
      );//print_r($data_survey_status);exit;


      $status_update      = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      $intimation_update  = $this->Survey_model->update_registration_intimation('a5_tbl_registration_intimation', $intimation_data,$registration_intimation_sl);

      $process_update     = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert     = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

      if($insert_intimation && $status_update && $process_update && $process_insert && $intimation_update)
      { //echo "hiiii----".$user_id_owner;//exit;
        //redirect("Kiv_Ctrl/Bookofregistration/raHome");
        ///get user mail////
            $user_mail_id           =   $this->Vessel_change_model->get_user_mailid($user_id);
            if(!empty($user_mail_id))
            {
              foreach($user_mail_id as $mail_res){
                $user_mail    = $mail_res['user_email'];
                $user_name    = $mail_res['user_name'];
                $user_mob     = $mail_res['user_mobile_number'];
              }
            }
            $dup_refno          =   $this->Vessel_change_model->getduplicatecert($vessel_id);
                if(!empty($dup_refno))
                {
                  foreach($dup_refno as $dup_res)
                  {
                    $refno        = $dup_res['ref_number'];
                    $main_id        = $dup_res['vesselmain_sl'];
                    $reg_no       = $dup_res['vesselmain_reg_number'];
                    $vessel       = $dup_res['vesselmain_vessel_name'];
                    $portofreg       = $dup_res['vesselmain_portofregistry_id'];
                    
                  }
                }
            $place =   $this->Vessel_change_model->get_registry_port_id($portofregistry_sl);
                foreach($place as $place_res){
                  $placeofvisit  = $place_res['vchr_portoffice_name'];
                }
                $portna       =   $this->Vessel_change_model->get_registry_port_id($portofreg);
                foreach($portna as $port_res){
                  $port_name  = $port_res['vchr_portoffice_name'];
                }

                
                $payment     =  $this->Vessel_change_model->get_payment_details($payment_sl,$vessel_id);
                foreach($payment as $pay_res){
                  $amount  = $pay_res['dd_amount'];
                }
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
            $change_inspection_date_exp  = explode('-',$change_inspection_date);
            $change_inspection_date_fnl  = $change_inspection_date_exp[2].'-'.$change_inspection_date_exp[1].'-'.$change_inspection_date_exp[0];
            $message = 'Dear '.$own_name.',<br/><br/>
              With respect to Duplicate Certificate, Registering Authority will verify your request on '.$change_inspection_date_fnl.' at '.$placeofvisit.'. You are hereby requested to be present for the same. Any change in schedule will be intimated through your registered mobile number and email id. <br/><br/>

            Please note the reference number : <strong>'.$refno.'</strong> for future reference with respect to Initial survey. <br/><br/>

            Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel. <br/><br/>

            For any queries or compaints contact '.$port_name.' Port of Registry. <br/><br/>

            Warm Regards<br/><br/>

            Kerala Maritime Board ';
                $smsmsg = 'Registering Authority will visit on '.$change_inspection_date_fnl.' at '.$placeofvisit.' for Duplictae Certificate of '.$reg_no.'. Reference Number:  '.$refno;           
            //$message = 'The Duplicate Certificate Request (Ref. No:'.$refno.') Intimation for the Vessel has been sent by the Registering Authority. Please Verify for further Processing.';
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('kivportinfo@gmail.com'); // change it to yours
           // $this->email->to($user_mail);// change it to yours
            $this->email->to('deepthi.nh@gmail.com');

            $this->email->subject('Intimation of visit by Registering Authority on '.$change_inspection_date_fnl.' at '.$placeofvisit.' for Duplicate Certificate-reg.');
            $this->email->message($message);
            if($this->email->send())
            { //echo "success";redirect("Kiv_Ctrl/Bookofregistration/raHome");
            // <!------------code for send SMS starts--------------->
              $this->load->model('Kiv_models/Vessel_change_model');
              //$mobil="9809119144";
              $mobil=$user_mob;
              //$stat = $this->Vessel_change_model->sendSms($message,$mobil);
              redirect("Kiv_Ctrl/Bookofregistration/raHome");
              //print_r($stat);exit;
              //echo json_encode("success");
              //redirect("Kiv_Ctrl/Bookofregistration/raHome");
              
              /*------------code for send SMS ends---------------*/
            }
            else
            {
              show_error($this->email->print_debugger());
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
function dupcertificate_insertion()
{ //echo "hii";exit;
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                        = $this->session->userdata('customer_id');
  $survey_user_id                     = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  { 
    $data     = array('title' => 'form14_form15_insertion', 'page' => 'form14_form15_insertion', 'errorCls' => NULL, 'post' => $this->input->post());
    $data     = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $ip       = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date                             = date('Y-m-d h:i:s', time()); 
    $reg_date                         = date('Y-m-d');
    $status_change_date               = $date;

    $survey_id                        = 0;
    $process_id                       = 41;
    $status                           = 1;

    $vessel_id                        = $this->security->xss_clean($this->input->post('vessel_id'));
    $old_vessel_name                  = $this->security->xss_clean($this->input->post('vessel_name'));
    $new_vessel_name                  = $this->security->xss_clean($this->input->post('change_name'));
    $registered_date1                 = $this->security->xss_clean($this->input->post('registered_date'));
    $registered_date                  = date("Y-m-d", strtotime($registered_date1));

    $approve_status                   = $this->security->xss_clean($this->input->post('approve_status'));

    $process_id                       = $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id                        = $this->security->xss_clean($this->input->post('survey_id'));
    $processflow_sl                   = $this->security->xss_clean($this->input->post('processflow_sl'));
    $status_details_sl                = $this->security->xss_clean($this->input->post('status_details_sl'));
    $current_position                 = $this->security->xss_clean($this->input->post('current_position'));
    $user_id                          = $this->security->xss_clean($this->input->post('user_sl_ra'));
    $registration_intimation_sl       = $this->security->xss_clean($this->input->post('registration_intimation_sl'));
    $user_id_owner                    = $this->security->xss_clean($this->input->post('user_id_owner'));
    $user_type_id_owner               = $this->security->xss_clean($this->input->post('user_type_id_owner'));
    $current_status_id                = $this->security->xss_clean($this->input->post('current_status_id'));

    $vessel_main                      = $this->Vessel_change_model->get_vessel_main($vessel_id);
    $data['vessel_main']              = $vessel_main;
    if(!empty($vessel_main))
    {
      $vesselmain_sl                  = $vessel_main[0]['vesselmain_sl'];
    }
    //print_r($_POST);exit;
    if(!empty($approve_status)){
      if($approve_status==5){
      /////process flow start indication---- tb_vessel_main processing_status to be changed as 1
      //$data_mainupdatee  = array('processing_status'=>0);
        //////namechange_log table 
        /*$data_namechg_log=array(
          'vessel_id'      => $vessel_id,
          'old_vessel_name'=> $old_vessel_name,
          'new_vessel_name'=> $new_vessel_name,
          'registered_date'=> $registered_date,
          'approved_date'  => $reg_date,
          'status'         => 1

        );*///print_r($data_namechg_log);exit;
        ///////duplicatecertificate table
        $data_dupli=array(
          'duplicate_cert_decision'           => 1,
          'duplicate_cert_decision_date'      => $reg_date,
          'duplicate_cert_decisionmake_id'    => $sess_usr_id,
          'duplicate_cert_decision_ipaddress' => $ip,
          'duplicate_cert_issue_date'         => $reg_date
        );//print_r($data_dupli);exit;
        ///////vesseldetails table
        $data_vesseldet=array(
          'vessel_modified_ipaddress'         => $ip
        );//print_r($data_vesseldet);exit;
        ///////vesselmain table
        $data_vesselmain=array(
          'vesselmain_dupcert_req'            => 1,
          'processing_status'                 => 0
        );//print_r($data_vesselmain);exit;
        ///////processflow table
        $data_insert=array(
          'vessel_id'                         => $vessel_id,
          'process_id'                        => $process_id,
          'survey_id'                         => $survey_id,
          'current_status_id'                 => $approve_status,
          'current_position'                  => $user_type_id_owner,
          'user_id'                           => $user_id_owner,
          'previous_module_id'                => $processflow_sl,
          'status'                            => $status,
          'status_change_date'                => $status_change_date
        );//print_r($data_insert);exit;
        /////////processflow previous flow status update
        $data_update=array(
          'status'                            => 0
        );//print_r($data_update);exit;
        //////////status details table
        $data_survey_status=array(
          'process_id'                        => $process_id,
          'survey_id'                         => $survey_id,
          'current_status_id'                 => $approve_status,
          'sending_user_id'                   => $sess_usr_id,
          'receiving_user_id'                 => $user_id_owner
        );//print_r($data_survey_status);exit;
       ///log table check
       
      //echo "Vessid===".$vessel_id."---Vessmain===".$vesselmain_sl."---Process===".$processflow_sl."---Status===".$status_details_sl;exit;
      ///vesselmain
       //$vesselmain_update=$this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdatee, $vesselmain_sl);
      ///namechange 
      $duplicert_upd        = $this->Vessel_change_model->update_vessel_duplcert('tbl_duplicate_certificate',$data_dupli, $vessel_id, $vesselmain_sl);
      ///vessel details
      $vesseldet_upd        = $this->Vessel_change_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vesseldet, $vessel_id);
      ///vesselmain
      $vesselmain_upd       = $this->Vessel_change_model->update_tbl_vessel_main('tb_vessel_main',$data_vesselmain, $vessel_id, $vesselmain_sl);

      $status_update        = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      $process_update       = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert       = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      if($duplicert_upd && $vesseldet_upd && $vesselmain_upd && $status_update && $process_update && $process_insert)
       {
        echo "1";
       }
       else
       {
        echo "0";
       }
     } else { //echo $approve_status;exit;
      $data_dupcert=array(
        'duplicate_cert_status'               => 2
      );
       $data_vesselmain=array(
        'processing_status'                   => 0
      );
      $data_insert=array(
        'vessel_id'                           => $vessel_id,
        'process_id'                          => $process_id,
        'survey_id'                           => $survey_id,
        'current_status_id'                   => $approve_status,
        'current_position'                    => $user_type_id_owner,
        'user_id'                             => $user_id_owner,
        'previous_module_id'                  => $processflow_sl,
        'status'                              => $status,
        'status_change_date'                  => $status_change_date
      );//print_r($data_insert);exit;
      /////////processfloe previous flow status update
      $data_update=array(
        'status'                              => 0
      );
      //////////status details table
      $data_survey_status=array(
        'process_id'                          => $process_id,
        'survey_id'                           => $survey_id,
        'current_status_id'                   => $approve_status,
        'sending_user_id'                     => $sess_usr_id,
        'receiving_user_id'                   => $user_id_owner
      );
      $duplcert_upd         = $this->Vessel_change_model->update_vessel_duplcert('tbl_duplicate_certificate',$data_dupcert, $vessel_id, $vesselmain_sl);
      $vesselmain_upd       = $this->Vessel_change_model->update_tbl_vessel_main('tb_vessel_main',$data_vesselmain, $vessel_id, $vesselmain_sl);
      $status_update        = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      $process_update       = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert       = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      if($duplcert_upd && $vesselmain_upd && $status_update && $process_update && $process_insert)
       {
        echo "1";
       }
       else
       {
        echo "0";
       }
     }
    }
  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function generate_dupcertificate()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                        = $this->session->userdata('customer_id');
  $survey_user_id                     = $this->session->userdata('survey_user_id');

  $vessel_id                          = $this->uri->segment(4);
  /*$processflow_sl   = $this->uri->segment(5);
  $status_details_sl= $this->uri->segment(6);*/

  

  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'generate_dupcertificate', 'page' => 'generate_dupcertificate', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    

    $vessel_details_viewpage          = $this->Vessel_change_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']  = $vessel_details_viewpage;

    @$id                              = $vessel_details_viewpage[0]['user_id'];
    
   //-----------Get customer name and address--------------//
    $customer_details                 = $this->Vessel_change_model->get_customer_details($id);
    $data['customer_details']         = $customer_details;

    /*$initial_data             = $this->Vessel_change_model->get_process_flow($processflow_sl);
    $data['initial_data']     = $initial_data;

    $intimation_type_id=2;

    $registration_intimation          = $this->Vessel_change_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']  = $registration_intimation;

    $survey_id=1;
     //----------Hull Details--------//
   
    $hull_details            = $this->Vessel_change_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']    = $hull_details;

   
   //----------Engine Details--------//
   
   $engine_details           = $this->Survey_model->get_engine_details($vessel_id,$survey_id);
   $data['engine_details']   = $engine_details;*/




    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/generate_dupcertificate',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');

  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function form14_dupcertificate()
{
 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                        = $this->session->userdata('customer_id');
  $survey_user_id                     = $this->session->userdata('survey_user_id');
   
  $vessel_id                          = $this->uri->segment(4);

  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'form14_dupcertificate', 'page' => 'form14_dupcertificate', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $ip   = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date =   date('Y-m-d h:i:s', time()); 

  
    $vessel_details_viewpage          = $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']  = $vessel_details_viewpage;

    @$id                              = $vessel_details_viewpage[0]['user_id'];

    $vessel_duplicate_details         = $this->Vessel_change_model->get_dupcert_details($vessel_id);
    $data['vessel_duplicate_details'] = $vessel_duplicate_details;


    
   //-----------Get customer name and address--------------//
    $customer_details                 = $this->Survey_model->get_customer_details($id);
    $data['customer_details']         = $customer_details;
   
    $survey_id=1;
     //----------Hull Details--------//
   
    $hull_details                     = $this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']             = $hull_details;

   
   //----------Engine Details--------//
   
    $engine_details                   =   $this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']           = $engine_details;


  $html=$this->load->view('Kiv_views/dash/form14_dupcertificate',$data,TRUE);

  $this->load->library('Pdf.php');
  $pdf =  $this->pdf->load();
  $pdf->allow_charset_conversion=true;  // Set by default to TRUE
  $pdf->charset_in='UTF-8';
  $pdf->autoLangToFont = true;
  ini_set('memory_limit', '256M');

  $output=$pdf->WriteHTML($html);
  $pdf->Output($output, 'D'); 
  exit();

  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function form15_dupcertificate()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                        = $this->session->userdata('customer_id');
  $survey_user_id                     = $this->session->userdata('survey_user_id');
  $vessel_id                          = $this->uri->segment(4);

  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'form15_dupcertificate', 'page' => 'form15_dupcertificate', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $ip   = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date =   date('Y-m-d h:i:s', time()); 


    $vessel_details_viewpage         = $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;

    @$id=$vessel_details_viewpage[0]['user_id'];

    $vessel_duplicate_details         = $this->Vessel_change_model->get_dupcert_details($vessel_id);
    $data['vessel_duplicate_details'] = $vessel_duplicate_details;

    
   //-----------Get customer name and address--------------//
    $customer_details             = $this->Survey_model->get_customer_details($id);
    $data['customer_details']     = $customer_details;
   
    $survey_id=1;
     //----------Hull Details--------//
   
    $hull_details                 = $this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']         = $hull_details;

   
   //----------Engine Details--------//
   
    $engine_details               = $this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']       = $engine_details;


    $html=$this->load->view('Kiv_views/dash/form15_dupcertificate',$data,TRUE);

    $this->load->library('Pdf.php');
    $pdf =  $this->pdf->load();
    $pdf->allow_charset_conversion=true;  // Set by default to TRUE
    $pdf->charset_in='UTF-8';
    $pdf->autoLangToFont = true;
    ini_set('memory_limit', '256M');

    $output=$pdf->WriteHTML($html);
    $pdf->Output($output, 'D'); 
    exit();


  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function dupcertificate_req_list()
{

 /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                    = $this->session->userdata('customer_id');
  $survey_user_id                 = $this->session->userdata('survey_user_id');


  if(!empty($sess_usr_id) && ($user_type_id==11))
  {
    $data       =  array('title' => 'namechange_req_list', 'page' => 'namechange_req_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Bookofregistration_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    if($user_type_id==14){
      $dupcertificate_det         = $this->Vessel_change_model->get_duplicatecert_details_ra_vw($sess_usr_id);
    }else {
      $dupcertificate_det         = $this->Vessel_change_model->get_duplicatecert_details($sess_usr_id);
    }
    $data['dupcertificate_det']   = $dupcertificate_det; //print_r($namechange_det);exit;
    
    $data = $data + $this->data;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/dupcertificate_req_list',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');

  } 
  else
  {
    redirect('Main_login/index');        
  }

}
public function view_form20_intimation()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id                      = $this->session->userdata('customer_id');
  $survey_user_id                   = $this->session->userdata('survey_user_id');

  $vessel_id1                       = $this->uri->segment(4);
  
  $vessel_id                        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id                        = $this->encrypt->decode($vessel_id); 

 
  $survey_id                        = 0;
  $process_id                       = 41;
  $status                           = 1;

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'view_form11_intimation', 'page' => 'view_form11_intimation', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');
    $initimat_data                    = $this->Vessel_change_model->get_dupcert_intimation_det($vessel_id,$survey_id,$process_id,$status);
    $data['initimat_data']            = $initimat_data;
  //print_r($initimat_data);exit;
    $vessel_change_det                = $this->Vessel_change_model->get_vesselduplicert_details_ra($vessel_id);
    $data['vessel_change_det']        = $vessel_change_det;
    $payment_det                      = $this->Vessel_change_model->get_dupcert_payment_ra($vessel_id);
    $data['payment_det']              = $payment_det;
    
      $this->load->view('Kiv_views/template/dash-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/view_form20_intimation',$data);
      $this->load->view('Kiv_views/template/dash-footer.php');
    
  }
  else
  {
    redirect('Main_login/index');
  }
  
}
///////////////////////Vessel Duplicate Certificate------End---------//////////////////////////

///////end of model////////
}


