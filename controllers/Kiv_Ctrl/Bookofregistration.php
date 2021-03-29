<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookofregistration extends CI_Controller {
 
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
  $this->data 		= 	array(
  'controller' 		=> 	$this->router->fetch_class(),
  'method' 			=> 	$this->router->fetch_method(),
  'session_userdata' 	=> 	isset($this->session->userdata) ? $this->session->userdata : '',
  'base_url' 			=> 	base_url(),
  'site_url'  		=> 	site_url(),
  /*'user_sl' 			=> 	isset($this->session->userdata['user_sl']) ? $this->session->userdata['user_sl'] : 0,
  'user_type_id' 		=> 	isset($this->session->userdata['user_type_id']) ? $this->session->userdata['user_type_id'] : 0,*/
  'u_id'       =>  isset($this->session->userdata['u_id']) ? $this->session->userdata['int_userid'] : 0,
  'utyp_id'    =>  isset($this->session->userdata['utyp_id']) ? $this->session->userdata['int_usertype'] : 0,
  'customer_id'=> isset($this->session->userdata['customer_id']) ? $this->session->userdata['customer_id'] : 0,
  'survey_user_id' => isset($this->session->userdata['survey_user_id']) ? $this->session->userdata['survey_user_id'] : 0,
  );
  $this->load->model('Kiv_models/Bookofregistration_model'); 
  $this->load->model('Kiv_models/Vessel_change_model');
  $this->load->model('Kiv_models/Survey_model');
  $this->load->model('Kiv_models/DataEntry_model'); 
}
	
/*_________________________________Registering authority home page________________________________*/
public function raHome()
{
  $sess_usr_id   =   $this->session->userdata('int_userid');
  $user_type_id  = $this->session->userdata('int_usertype');
  $customer_id	  =	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'raHome', 'page' => 'raHome', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Master_model');
    $this->load->model('Kiv_models/Vessel_change_model');

    $initial_data			    = $this->Bookofregistration_model->get_process_flow_ras($sess_usr_id);
    $data['initial_data']	=	$initial_data;
    //print_r($initial_data);
    if(!empty($initial_data))
    {
      $count	= count($initial_data);
      $data['count']=$count;
    }
    $reg_vessel  =   $this->Bookofregistration_model->get_reg_vessel_list();
    $data['reg_vessel']  = $reg_vessel;
    if(!empty($reg_vessel)) 
    {
      $count_reg_vessel=count($reg_vessel);
      $data['count_reg_vessel']=$count_reg_vessel;
    }
    $namechange_det         =  $this->Vessel_change_model->get_vesselnamechange_details_ra_vw($sess_usr_id);
    $data['namechange_det'] =  $namechange_det;
    if(!empty($namechange_det)) 
    {
      $count_namechange_det=count($namechange_det);
      $data['count_namechange_det']=$count_namechange_det;
    }
    $ownerchange_det=  $this->Vessel_change_model->get_vesselownerchange_details_ra_vw($sess_usr_id);
    $data['ownerchange_det'] = $ownerchange_det; //print_r($ownerchange_det);
    if(!empty($ownerchange_det))
    {
      $ownerchange_count = count($ownerchange_det);
      $data['ownerchange_count']=$ownerchange_count;
    }
    $transfervessel_det=  $this->Vessel_change_model->get_transfervessel_details_ra_vw($sess_usr_id);
    $data['transfervessel_det'] = $transfervessel_det; //print_r($ownerchange_det);
    if(!empty($transfervessel_det))
    {
      $transfervsl_count = count($transfervessel_det);
      $data['transfervsl_count']=$transfervsl_count;
    }

    /* ======Added for dynamic menu listing (start) on 02.11.2019========   */ 
    $menu     =   $this->Master_model->get_menu($user_type_id); //print_r($menu);
    $data['menu'] = $menu;
    $data       =   $data + $this->data;
    /* ======Added for dynamic menu listing (end) on 02.11.2019========   */
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

public function ra_inbox()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'ra_inbox', 'page' => 'ra_inbox', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;

    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Vessel_change_model');

    $initial_data         = $this->Bookofregistration_model->get_process_flow_ras($sess_usr_id);
    $data['initial_data'] = $initial_data;
    //print_r($initial_data);
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/ra_inbox',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  } 
}

/*____________________________________________________________________________________*/

/* Registration Module Start   */
/*__________________________________________form 12 List ________________________________*/
public function form12List()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');

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

/*________________________________Form12 List Ends___________________________*/

/*____________________________________Form12 Page Starts_____________________*/

public function form12()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
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
    if(!empty($initial_data))
    {
      $status_change_date1  = $initial_data[0]['status_change_date'];
    }
    else
    {
    //redirect('Kiv_Ctrl/Bookofregistration/form12List');
    // exit;
    }

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


    $insurance_type                     = $this->Bookofregistration_model->get_insurance_type();
    $data['insurance_type']             = $insurance_type;

    //___________________________TARIFF DETAILS____________________________________________//

    $status_change_date 	=	date("Y-m-d", strtotime($status_change_date1));
    $now				 =	date("Y-m-d");
    $date1_ts    = strtotime($status_change_date);
    $date2_ts    = strtotime($now);
    $diff        = $date2_ts - $date1_ts;
    $numberofdays1 =  round($diff / 86400);
    $numberofdays  =  $numberofdays1-100;

    if($numberofdays!=0)
    {
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
      else
      {
        $tariff_amount1=0;
        $tariff_min_amount=0;
      }
      $tonnage_details            =   $this->Bookofregistration_model->get_tonnage_details($vessel_id);
      $data1['tonnage_details']   =   $tonnage_details;
      if(!empty($tonnage_details))
      {
        @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
      }
      $amount1=$vessel_total_tonnage*$tariff_amount1;

      /* if($amount1<250)
      {
      $data['tariff_amount']=$tariff_min_amount;
      }
      else
      {
      $data['tariff_amount']=$amount1;
      }*/
      if($vessel_type_id==1)
      {
        $data['tariff_amount']=$tariff_min_amount;
      }
      else
      {
        if($amount1<280)
        {
        $data['tariff_amount']=$tariff_min_amount;
        }
        else
        {
        $data['tariff_amount']=$amount1;
        }
      }
    }
    else
    {
      redirect('Kiv_Ctrl/Bookofregistration/form12List');
    }
  $this->load->view('Kiv_views/template/form-header.php');
  $this->load->view('Kiv_views/template/nav-header.php');
  $this->load->view('Kiv_views/dash/form12', $data);
  $this->load->view('Kiv_views/template/form-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function payment_details_form12()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id     = $this->session->userdata('customer_id');
  $survey_user_id  = $this->session->userdata('survey_user_id');

  $vessel_id1       = $this->uri->segment(4);
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
    $plyingPort                     = $this->Bookofregistration_model->get_portofregistry();
    $data['plyingPort']             = $plyingPort;

    $bank                     =   $this->Survey_model->get_bank_favoring();
    $data['bank']             =   $bank;

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
    if($numberofdays1==0)
    {
      $numberofdays  =1;
    }
    else
    {   
      $numberofdays  =  $numberofdays1;
    }

    $form_id=12;
    $activity_id=5;

    $tariff_details  =   $this->Bookofregistration_model->get_tariff_form12($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$numberofdays);
    $data1['tariff_details']  =   $tariff_details;

    if (!empty($tariff_details)) 
    {
      $tariff_amount1=$tariff_details[0]['tariff_amount'];
      $tariff_min_amount=$tariff_details[0]['tariff_min_amount'];
    }

    $tonnage_details            =   $this->Bookofregistration_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']   =   $tonnage_details;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1=$vessel_total_tonnage*$tariff_amount1;

    /* if($amount1<250)
    {
    $data['tariff_amount']=$tariff_min_amount;
    }
    else
    {
    $data['tariff_amount']=$amount1;
    }*/
    if($vessel_type_id==1)
    {
      $data['tariff_amount']=$tariff_min_amount;
    }
    else
    {
      if($amount1<280)
      {
        $data['tariff_amount']=$tariff_min_amount;
      }
      else
      {
        $data['tariff_amount']=$amount1;
      }
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

      $vessel_insurance_type     =  $this->security->xss_clean($this->input->post('vessel_insurance_type'));
      $vessel_insurance_premium =  $this->security->xss_clean($this->input->post('vessel_insurance_premium'));
      $pcb_reg_date      =  $this->security->xss_clean($this->input->post('pcb_reg_date'));
      $pcb_expiry_date   =  $this->security->xss_clean($this->input->post('pcb_expiry_date'));
      $pcb_number        =  $this->security->xss_clean($this->input->post('pcb_number'));

      if(($_FILES["pcb_certificate"]["name"])!="")
      { 
        $ins_path_parts_pln = pathinfo($_FILES["pcb_certificate"]["name"]);
        $ins_extension_pln  = $ins_path_parts_pln['extension'];

        $ins_file_name_pln='pln_'.$vessel_id.'_'.$date.'.'.$ins_extension_pln;
        $ins_upd_pln=copy($_FILES["pcb_certificate"]["tmp_name"], "./uploads/pollution_certificate"."/".$ins_file_name_pln); 
      }
      else
      {
        $ins_file_name_pln="";
      }
      /* $statementofOwner          =  $_FILES["statementofOwner"]["name"];
      $thirdpartyInsuranceCopy  =  $_FILES["thirdpartyInsuranceCopy"]["name"];
      $declarationOfOwnership  =  $_FILES["declarationOfOwnership"]["name"];*/
      $statementofOwner         =  $this->security->xss_clean($this->input->post('statementofOwner'));
      $thirdpartyInsuranceCopy         =  $this->security->xss_clean($this->input->post('thirdpartyInsuranceCopy'));
      $declarationOfOwnership         =  $this->security->xss_clean($this->input->post('declarationOfOwnership'));

      $tariff_amount            =  $this->security->xss_clean($this->input->post('dd_amount'));
      /*_____________________________Upload Thirdpaty Insurance Copy start_____________________________*/

      if(($_FILES["thirdpartyInsuranceCopy"]["name"])!="")
      { 
        $ins_path_parts = pathinfo($_FILES["thirdpartyInsuranceCopy"]["name"]);
        $ins_extension  = $ins_path_parts['extension'];
        $ins_file_name='INS'.'_REG_Form12_'.$vessel_id.'_'.$date.'.'.$ins_extension;
        $ins_upd=copy($_FILES["thirdpartyInsuranceCopy"]["tmp_name"], "./uploads/thirdPartyInsurance"."/".$ins_file_name); 
      }
      else
      {
        $ins_file_name="";
      }
      /*_____________________________Upload Thirdpaty Insurance Copy end_____________________________*/
      /*_____________________________Upload Statement of Owner start_________________________________*/
      if(($_FILES["statementofOwner"]["name"])!="")
      { 
        $smt_path_parts = pathinfo($_FILES["statementofOwner"]["name"]);
        $smt_extension  = $smt_path_parts['extension'];
        $smt_file_name='SO'.'_REG_Form12_'.$vessel_id.'_'.$date.'.'.$smt_extension;
        $smt_upd=copy($_FILES["statementofOwner"]["tmp_name"], "./uploads/OwnerStatement"."/".$smt_file_name);
      }
      /*_____________________________Upload Statement of Owner end________________________________*/

      /*_____________________________Upload Declaration form start_____________________________*/
      if(($_FILES["declarationOfOwnership"]["name"])!="")
      { 
        $dln_path_parts = pathinfo($_FILES["declarationOfOwnership"]["name"]);
        if($dln_path_parts)
        {
          $dln_extension  = $dln_path_parts['extension'];

          $dln_file_name='DLS'.'_REG_Form12_'.$vessel_id.'_'.$date.'.'.$dln_extension;
          $dln_upd=copy($_FILES["declarationOfOwnership"]["tmp_name"], "./uploads/declarationOfOwnership"."/".$dln_file_name); 
        }
      }
      /*_____________________________Upload Declaration form end_____________________________*/
      /*_____________________________Update Registering Authority start_________________________________*/
      $updateRA=array(
      'validity_of_insurance'     =>  $insuranceValidity,
      'registering_authority'     =>  $registeringAuthorityId,
      'yardName'                  =>  $yardName,
      'plying_portofregistry'     =>  $plying_portofregistry,
      'vesselPurchaseAmount'      =>  $vesselPurchaseAmount,
      'vesselPurchaseDate'        =>  $vesselPurchaseDate,
      'placeOfBussiness'          =>  $placeOfBussiness,
      'vessel_modified_user_id'   =>  $sess_usr_id,
      'vessel_modified_timestamp' =>  $date,
      'vessel_modified_ipaddress' =>  $ip);
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
        'engine_modified_ipaddress'=>$ip );
        $update_engine_table   = $this->Bookofregistration_model->update_table_engine_byvessel('tbl_kiv_engine_details',$data_engine,$vessel_id);
      }
      /*___________________Insert Engine Details end____________________________________*/
      /*___________________Insert Insurance Details of Vessel start_____________________*/
      $insertInsuranceDet=array(
      'vessel_id'                      => $vessel_id,
      'vessel_insurance_company'       => $insuranceCompanyId,
      'vessel_insurance_type'         =>$vessel_insurance_type,
      'vessel_insurance_date'          => $insuranceDate,
      'vessel_insurance_premium'=>$vessel_insurance_premium,
      'vessel_insurance_validity'      => $insuranceValidity,
      'vessel_thirdpartyInsuranceCopy' => $ins_file_name,
      'vessel_statementofOwner'        => $smt_file_name,
      'vessel_insurance_status'        => 1,
      'vessel_insurance_number'        => $insuranceNumber,
      'insurance_created_user_id'   =>$sess_usr_id,
      'insurance_created_timestamp'=>$date,
      'insurance_created_ipaddress'=>$ip);

      $insertInsuranceDet      = $this->security->xss_clean($insertInsuranceDet);         
      $insertInsuranceDet_res  = $this->db->insert('tbl_vessel_insurance_details', $insertInsuranceDet);
      $vessel_insurance_sl_new     =    $this->db->insert_id();

      /*___________________Insert Pollution Details of Vessel end_____________________*/
      $data_pollution=array(
      'vessel_id'=>$vessel_id,
      'pcb_reg_date'=>$pcb_reg_date,
      'pcb_expiry_date'=>$pcb_expiry_date,
      'pcb_number'=>$pcb_number,
      'pcb_certificate'=>$ins_file_name_pln,
      'pollution_created_user_id'=>$sess_usr_id,
      'pollution_created_timestamp'=>$date,
      'pollution_created_ipaddress'=>$ip);   

      $res_pollution  = $this->db->insert('tbl_pollution_details', $data_pollution);       
      /*___________________Insert Insurance Details of Vessel end_____________________*/
      $data_main=array(
      'vesselmain_insurance_id'=>$vessel_insurance_sl_new,
      'vesselmain_insurance_date'=>$newDate,
      'vesselmain_insurance_status'=>1);   
      $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);
    }
    $this->load->view('Kiv_views/template/form-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/payment_details_form12', $data);
    $this->load->view('Kiv_views/template/form-footer.php');
  }
  else
  {
    redirect('Main_login/index'); 
  }
}

function pay_now_form12()
{
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

    $vessel_id        = $this->security->xss_clean($this->input->post('vessel_sl'));
    $processflow_sl   = $this->security->xss_clean($this->input->post('processflow_sl'));
    $status_details_sl= $this->security->xss_clean($this->input->post('status_details_sl'));
    $process_id     = $this->security->xss_clean($this->input->post('process_id')); 

    //_____________Tariff amount___________________//
    $vesselDet            = $this->Bookofregistration_model->get_vesselDet($vessel_id);
    $data['vesselDet']    = $vesselDet;
    if(!empty($vesselDet))
    {
      $vessel_type_id       = $vesselDet[0]['vessel_type_id'];
      $vessel_subtype_id    = $vesselDet[0]['vessel_subtype_id'];
    }

    $initial_data         = $this->Survey_model->get_form12_frwd_process_flow($sess_usr_id,$vessel_id);
    $data['initial_data'] = $initial_data;
    $status_change_date1  = $initial_data[0]['status_change_date'];
    //___________________________TARIFF DETAILS____________________________________________//
    $status_change_date   = date("Y-m-d", strtotime($status_change_date1));
    $now         =  date("Y-m-d");
    $date1_ts    = strtotime($status_change_date);
    $date2_ts    = strtotime($now);
    $diff        = $date2_ts - $date1_ts;
    $numberofdays1 =  round($diff / 86400);
    $numberofdays  =  $numberofdays1;

    $form_id=12;
    $activity_id=5;

    $tariff_details  =   $this->Bookofregistration_model->get_tariff_form12($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$numberofdays);
    $data1['tariff_details']  =   $tariff_details;
    if (!empty($tariff_details)) 
    {
      $tariff_amount1=$tariff_details[0]['tariff_amount'];
      $tariff_min_amount=$tariff_details[0]['tariff_min_amount'];
    }
    else
    {
      $tariff_amount1=1;
      $tariff_min_amount=1;
    }
    $tonnage_details            =   $this->Bookofregistration_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']   =   $tonnage_details;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1=$vessel_total_tonnage*$tariff_amount1;
    /*
    if($amount1<250)
    {
    $tariff_amount=$tariff_min_amount;
    }
    else
    {
    $tariff_amount=$amount1;
    }*/
    if($vessel_type_id==1)
    {
      $tariff_amount=$tariff_min_amount;
    }
    else
    {
      if($amount1<280)
      {
        $tariff_amount=$tariff_min_amount;
      }
      else
      {
        $tariff_amount=$amount1;
      }
    }



    $portofregistry_sl = $this->security->xss_clean($this->input->post('portofregistry_sl'));  
    $bank_sl = $this->security->xss_clean($this->input->post('bank_sl'));
    date_default_timezone_set("Asia/Kolkata");
    $date             = date('Y-m-d h:i:s', time());
    $ip               = $_SERVER['REMOTE_ADDR'];
    $newDate          = date("Y-m-d");   
    $form_number_cs=  $this->Survey_model->get_form_number_cs($process_id);
    $data['form_number_cs']     =   $form_number_cs;
    if(!empty($form_number_cs))
    {
      $formnumber=$form_number_cs[0]['form_no'];
    }
    $survey_id=0;
    $status = 1;

    $port_registry_user_id           =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
    $data['port_registry_user_id']  =   $port_registry_user_id;

    if(!empty($port_registry_user_id))
    {
      $pc_user_id=$port_registry_user_id[0]['user_master_id'];
      $pc_usertype_id=$port_registry_user_id[0]['user_master_id_user_type'];
    }
    $payment_user=  $this->Survey_model->get_payment_userdetails($sess_usr_id);
    $data['payment_user']     =   $payment_user;
    //print_r($payment_user);exit;
    if(!empty($payment_user))
    {
      $owner_name=$payment_user[0]['user_name'];
      $user_mobile_number=$payment_user[0]['user_mobile_number'];
      $user_email=$payment_user[0]['user_email'];
    }

    $milliseconds = round(microtime(true) * 1000); //Generate unique bank number
    $bank_gen_number         =   $this->Survey_model->get_bank_generated_last_number($bank_sl);
    $data['bank_gen_number']   = $bank_gen_number;
    if(!empty($bank_gen_number))
    {
    $bank_generated_number =  $bank_gen_number[0]['last_generated_no']+1;
    $transaction_id        =  $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds.$bank_generated_number;
    $tocken_number         =  $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds;
    $bank_data             =  array('last_generated_no'=>$bank_generated_number);

      /*_______________________________GET Vessel ref number-start_____________________*/
      $process_id=5;
      $vessel_ref_number          =   $this->Survey_model->get_vessel_ref_number($process_id);
      $data['vessel_ref_number']  =   $vessel_ref_number;
      $cnt_rws                      = count($vessel_ref_number);
      if($cnt_rws==0)
      {
        $value                      = "1";
      } 
      elseif ($cnt_rws>0) 
      {
        $last_refno         = $this->Survey_model->get_last_ref_number($process_id);
        foreach ($last_refno as $ref_res) 
        {
          $ref_no                   = $ref_res['ref_number'];
        }
        $ref_exp                    = explode('_', $ref_no);
        $ref_val                    = $ref_exp[1];
        $value                      = $ref_val + 1;
      }

      if($value<10)
      {
        $value                      = "00".$value;
      } 
      elseif ($value<100) 
      {
        $value                      = "0".$value;
      } 
      else 
      {
        $value                      = $value;
      }

      $yr                           = date('Y');
      $ref_number                   = "REG"."_".$value."_".$vessel_id.$yr;

      $data_ref_number= array('vessel_id' =>$vessel_id ,
      'process_id'=>$process_id,
      'ref_number'=>$ref_number,
      'ref_number_status'=>1,
      'ref_number_created_user_id'=>$sess_usr_id,
      'ref_number_created_timestamp'=>$date,
      'ref_number_created_ipaddress'=>$ip);
      $result_ref_number=$this->db->insert('tbl_kiv_reference_number', $data_ref_number); 
      /*_______________________________GET Vessel ref number-end_____________________*/

      $data_payment_request = array('transaction_id' => $transaction_id,
      'bank_ref_no'   =>0 ,
      'token_no'      => $tocken_number,
      'vessel_id'     =>$vessel_id,
      'survey_id'     => $survey_id,
      'form_number'   => $formnumber,
      'customer_registration_id' => $sess_usr_id,
      'customer_name'         => $owner_name,
      'mobile_no'             => $user_mobile_number,
      'email_id'              => $user_email,
      'transaction_amount'    => $tariff_amount,
      'remitted_amount'       => 0,
      'bank_id'               => $bank_sl,
      'transaction_status'    => 0,
      'payment_status'        => 0,
      'transaction_timestamp' => $date,
      'transaction_ipaddress' => $ip,
      'port_id'               => $portofregistry_sl);
      $result_insert=$this->db->insert('kiv_bank_transaction_request', $data_payment_request); 
      if($result_insert)
      {
        $bank_transaction_id   =    $this->db->insert_id();
        $update_bank           =    $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);


        $online_payment_data         =   $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
        $data['online_payment_data']= $online_payment_data;

        $payment_user1              =  $this->Survey_model->get_payment_userdetails($sess_usr_id);
        $data['payment_user1']     =  $payment_user1;

        $requested_transaction_details=  $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
        $data['requested_transaction_details']  =   $requested_transaction_details;

        $data['amount_tobe_pay']=$tariff_amount;//remove comment before uploaded to server
        //$data['amount_tobe_pay']=1;

        $data      =  $data+ $this->data;

        /*___________Actual data for server-start_________________*/
        if(!empty($online_payment_data))
        { 
          $this->load->view('Kiv_views/Hdfc/hdfc_registration_request',$data);
        }
        else
        {
          redirect('Kiv_Ctrl/Survey/SurveyHome');
        }
        /*___________Actual data for server-end_________________*/

      



      }
      else
      {
        redirect('Kiv_Ctrl/Survey/SurveyHome');
      }
    }
    else
    {
      redirect('Kiv_Ctrl/Survey/SurveyHome');
    }  //__________________________________________________//
  }
  else
  {
    redirect('Main_login/index'); 
  }
}

public function Verify_registration_form12()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
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
    $owner_name         = $customer_details[0]['user_name'];
    $user_mobile_number = $customer_details[0]['user_mobile_number'];
    $user_email         = $customer_details[0]['user_email'];


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
    $vessel_name              = $vessel_details_viewpage[0]['vessel_name'];

    //----------Payment Details--------//
    $payment_details =  $this->Survey_model->get_form3_tariff($vessel_id,5,$form_id);
    $data['payment_details']= $payment_details;

    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date   			= 	date('Y-m-d h:i:s', time());
      $status_change_date =	$date;
      $remarks_date		=	date('Y-m-d');
      $ip     =	$_SERVER['REMOTE_ADDR'];

      $registration_inspection_date 	=	$this->security->xss_clean($this->input->post('registration_inspection_date'));
      $registration_inspection_date1=date("d-m-Y", strtotime($registration_inspection_date));
      /*$registration_inspection_date1 = str_replace('/', '-', $registration_inspection_date2);
      $registration_inspection_date   = date("Y-m-d", strtotime($registration_inspection_date1));*/

      $portofregistry_sl 	=	$this->security->xss_clean($this->input->post('portofregistry_sl'));
      $registration_intimation_remark =$this->security->xss_clean($this->input->post('registration_intimation_remark'));
      $registry_port_id         =   $this->Survey_model->get_registry_port_id($portofregistry_sl);
      $data['registry_port_id'] =   $registry_port_id;
      if(!empty($registry_port_id))
      {
        $port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
      }
      else
      {
        $port_of_registry_name="";
      }
      /*________________GET reference number start-registration___________________*/
      date_default_timezone_set("Asia/Kolkata");
      $date         =   date('Y-m-d h:i:s', time());
      $ref_process_id=5;
      $ref_number_details     =   $this->Survey_model->get_ref_number_details($vessel_id,$ref_process_id);
      $data['ref_number_details'] =   $ref_number_details;

      if(!empty($ref_number_details))
      {
        $ref_number       = $ref_number_details[0]['ref_number'];
      }
      else
      {
        $ref_number =   "";
      }
      /*________________GET reference number end-registration___________________*/
      //_____________________________Email sending start_____________________________//
     $email_subject="Registration of ".$vessel_name.". Appointment date for inspection is scheduled on ".$registration_inspection_date1.", 10.00 at ".$port_of_registry_name." Port of Registry";
      $email_message="<div><h4>Dear ". $owner_name.",</h4><p>Registration of <b>".$vessel_name."</b>. Appointment date for inspection is scheduled on <b>".$registration_inspection_date1.", 10.00 at ".$port_of_registry_name."</b> Port of Registry.  <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Registration. This reference number will be until Registration Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.<br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
     /* $saji_email="kivportinfo@gmail.com";
      $this->emailSendFunction($saji_email,$email_subject,$email_message);*/
      $this->emailSendFunction($user_email,$email_subject,$email_message);
      //___________________Email sending start___________________________________________//
      //____________________SMS sending start____________________________________________//
      $sms_message="Registration of ".$vessel_name.". Appointment date for inspection is scheduled on ".$registration_inspection_date1.", 10.00 at ".$port_of_registry_name." Port of Registry";
      $this->load->model('Kiv_models/Survey_model');
     /* $saji_mob="9847903241";
      $stat = $this->Survey_model->sendSms($sms_message,$saji_mob);*/
      $stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
      //____________________SMS sending end________________________________________________//

 

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
        'status_change_date'=>$status_change_date);

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
        'status_change_date'=>$status_change_date);

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
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'view_form13', 'page' => 'view_form13', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			= 	$this->Bookofregistration_model->get_process_flow($processflow_sl);
    $data['initial_data']	=	$initial_data;
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
  $sess_usr_id     = $this->session->userdata('int_userid');
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
      'status_change_date'=>$status_change_date);

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

public function generate_certificate()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  $vessel_id    = $this->uri->segment(4);
  $processflow_sl   = $this->uri->segment(5);
  $status_details_sl   = $this->uri->segment(6);

  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'generate_certificate', 'page' => 'generate_certificate', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;

    @$id=$vessel_details_viewpage[0]['user_id'];

    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $initial_data			= 	$this->Bookofregistration_model->get_process_flow($processflow_sl);
    $data['initial_data']	=	$initial_data;

    $intimation_type_id=1;

    $registration_intimation          = $this->Survey_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']  = $registration_intimation;

    $survey_id=1;
    //----------Hull Details--------//
    $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']    = $hull_details;

    //----------Engine Details--------//
    $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']  = $engine_details;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/generate_certificate',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index'); 
  }
}

function registration_certificate()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
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
    $registration_intimation_sl= $this->security->xss_clean($this->input->post('registration_intimation_sl'));
    $user_id_owner    = $this->security->xss_clean($this->input->post('user_id_owner'));
    $user_type_id_owner = $this->security->xss_clean($this->input->post('user_type_id_owner'));
    $current_status_id  = $this->security->xss_clean($this->input->post('current_status_id'));
    $status       = 1;
     //----------Vessel Details--------//
    $vessel_details_viewpage =  $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;
    $vessel_name              = $vessel_details_viewpage[0]['vessel_name'];
    $vessel_registry_port_id  = $vessel_details_viewpage[0]['vessel_registry_port_id'];
    

    $customer_details         =   $this->Survey_model->get_customer_details($user_id_owner);
    $data['customer_details']   =   $customer_details;
    $owner_name         = $customer_details[0]['user_name'];
    $user_mobile_number = $customer_details[0]['user_mobile_number'];
    $user_email         = $customer_details[0]['user_email'];

    /*________________GET reference number start-registration___________________*/
    date_default_timezone_set("Asia/Kolkata");
    $date         =   date('Y-m-d h:i:s', time());
    $ref_process_id=5;
    $ref_number_details     =   $this->Survey_model->get_ref_number_details_forms($vessel_id,$ref_process_id);
    $data['ref_number_details'] =   $ref_number_details;

    if(!empty($ref_number_details))
    {
      $ref_number       = $ref_number_details[0]['ref_number'];
    }
    else
    {
      $ref_number =   "";
    }
    /*________________GET reference number end-registration___________________*/
    $vessel_main     =   $this->Bookofregistration_model->get_vessellist_owner($vessel_id);
    $data['vessel_main'] =   $vessel_main;
    if(!empty($vessel_main))
    {
      $vesselmain_reg_number=$vessel_main[0]['vesselmain_reg_number'];
      $vesselmain_reg_date=date('d-m-Y', strtotime($vessel_main[0]['vesselmain_reg_date']));
      $next_reg_renewal_date=date('d-m-Y', strtotime($vessel_main[0]['next_reg_renewal_date']));
      $vesselmain_portofregistry_id=$vessel_main[0]['vesselmain_portofregistry_id'];
    } 
    $pollution_details     =   $this->Survey_model->get_vessel_pollution($vessel_id);
    $data['pollution_details'] =   $pollution_details;
    if(!empty($pollution_details))
    {
      $pcb_expiry_date=date('d-m-Y', strtotime($pollution_details[0]['pcb_expiry_date']));
    }
    else
    {
      $pcb_expiry_date="";
    }
    $insurance_details     =   $this->Survey_model->get_insurance_details($vessel_id);
    $data['insurance_details'] =   $insurance_details;
    if(!empty($insurance_details))
    {
      $vessel_insurance_validity=date('d-m-Y', strtotime($insurance_details[0]['vessel_insurance_validity']));
    }
    else
    {
      $vessel_insurance_validity="";
    }



    $registry_port_id         =   $this->Survey_model->get_registry_port_id($vesselmain_portofregistry_id);
    $data['registry_port_id'] =   $registry_port_id;
    if(!empty($registry_port_id))
    {
      $port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
    }
    else
    {
      $port_of_registry_name="";
    }
    

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
    'status_change_date'=>$status_change_date);

    $data_insert=array(
    'vessel_id'=>$vessel_id,
    'process_id'=>$process_id,
    'survey_id'=>$survey_id,
    'current_status_id'=>5,
    'current_position'=>$user_type_id_owner,
    'user_id'=>$user_id_owner,
    'previous_module_id'=>$processflow_sl,
    'status'=>$status,
    'status_change_date'=>$status_change_date);

    $data_update = array('status'=>0);

    $data_survey_status=array(
    'process_id'=>$process_id,
    'survey_id'=>$survey_id,
    'current_status_id'=>5,
    'sending_user_id'=>$sess_usr_id,
    'receiving_user_id'=>$user_id_owner);
    $data_main=array('processing_status'=>0);   
    $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);

    $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

    $process_update   = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
    $process_insert_approve=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_approve);
    $process_insert   = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
    //_____________________________Email sending start_____________________________//
    $email_subject="Registration Certificate and Book of Registration for ".$vessel_name." vessel is generated.";
    $email_message="<div><h4>Dear ".$owner_name .",</h4><p>Registration Certificate and Book of Registration for <b>".$vessel_name."</b> vessel is generated. Login to portinfo.kerala.gov.in to download Registration Certificate and Book of Registration under the menu Book of Registration.</br>   </br>   Registration number is : <b>".$vesselmain_reg_number."</b></br></br>
      Registration date is : <b>".$vesselmain_reg_date."</b></br></br>
      Registration renewal : <b>".$next_reg_renewal_date."</b></br></br>
      Pollution expiry date : <b>".$pcb_expiry_date."</b></br></br>Insurance expiry date : <b>".$vessel_insurance_validity."</b></br>  <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Registration. This reference number will be until Registration Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br><br>Registering Authority <br><br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
      
    /*$saji_email="kivportinfo@gmail.com";
    $this->emailSendFunction($saji_email,$email_subject,$email_message);*/
    $this->emailSendFunction($user_email,$email_subject,$email_message);
    //___________________Email sending start___________________________________________//
    //____________________SMS sending start____________________________________________//
    $sms_message="Registration Certificate and Book of Registration for ".$vessel_name." vessel is generated. Login to portinfo.kerala.gov.in to download.";
    $this->load->model('Kiv_models/Survey_model');
    /*$saji_mob="9847903241";
    $stat = $this->Survey_model->sendSms($sms_message,$saji_mob);*/
    $stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
    //____________________SMS sending end________________________________________________//

    if($status_update && $process_update && $process_insert)
    {
      redirect("Kiv_Ctrl/Bookofregistration/raHome");
    }
    else
    {
      redirect("Kiv_Ctrl/Bookofregistration/raHome");
    }
  }
  else
  {
    redirect('Main_login/index'); 
  }
}

function form14_form15_insertion()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form14_form15_insertion', 'page' => 'form14_form15_insertion', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $ip     = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date   =   date('Y-m-d h:i:s', time()); 
    $reg_date=date('Y-m-d');

    $adding_five_year       = date('d-m-Y', strtotime($reg_date . "5 year") );
    $registration_validity_period=date('Y-m-d', strtotime($adding_five_year));

    $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));
    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;

    if(!empty($vessel_details_viewpage))
    {
      $reference_number       =   $vessel_details_viewpage[0]['reference_number'];
      $vessel_registry_port_id=   $vessel_details_viewpage[0]['vessel_registry_port_id'];
      $vessel_type_id         =   $vessel_details_viewpage[0]['vessel_type_id'];
      $registering_authority  =   $vessel_details_viewpage[0]['registering_authority'];
      $user_id_owner          =   $vessel_details_viewpage[0]['user_id'];

      $vessel_type       =   $this->Survey_model->get_vessel_typeid_length($vessel_type_id);
      $data['vessel_type']   =   $vessel_type;
      $vesseltype_code= $vessel_type[0]['vesseltype_code'];

      $registry_port_id            =   $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
      $data['registry_port_id']    =   $registry_port_id;
      /*   
      if(!empty($registry_port_id))
      {
      $registry_code=$registry_port_id[0]['vchr_officecode'];
      $registration_number='KIV/'.$registry_code.'/'.$vesseltype_code.'/'.$reference_number;
      }
      */
      $survey_id=0;$form_number=12;
      $tariff           =   $this->Survey_model->get_form3_tariff($vessel_id,$survey_id,$form_number);
      $data['tariff']   =   $tariff;
      if(!empty($tariff))
      {
        $registration_payment_date=$tariff[0]['dd_date'];
      }
      else
      {
        $registration_payment_date="NULL";
      }

      $registration_intimation           =   $this->Survey_model->registration_intimation($vessel_id);
      $data['registration_intimation']   =   $registration_intimation;
      if(!empty($registration_intimation))
      {
        $registration_intimation_sl=$registration_intimation[0]['registration_intimation_sl'];
      }
      else
      {
        $registration_intimation_sl=0;
      }
      if(!empty($registry_port_id))
      {
        $registry_code=$registry_port_id[0]['vchr_officecode'];
        $regcount_details            =   $this->Survey_model->get_regcount($vessel_registry_port_id,$vessel_type_id);
        $data['regcount_details']    =   $regcount_details;

        $year=date('Y');
        if(!empty($regcount_details))
        {
          $regcount_id=$regcount_details[0]['id'];
          $regcount1=$regcount_details[0]['regcount'];
          $regcount=$regcount1+1;
          $registration_number='KIV/'.$registry_code.'/'.$vesseltype_code.'/'.$regcount.'/'.$year;
        }
        else
        {
          $registration_number='KIV/'.$registry_code.'/'.$vesseltype_code.'/'.'0/'.$year;
        }
      }
    }
    $propulsion_shaft_number =	$this->security->xss_clean($this->input->post('propulsion_shaft_number'));
    $cylinder_number =	$this->security->xss_clean($this->input->post('cylinder_number'));
    $rpm 			=	$this->security->xss_clean($this->input->post('rpm'));

    $stern 			=	$this->security->xss_clean($this->input->post('stern'));
    $stern_material_sl =	$this->security->xss_clean($this->input->post('stern_material_sl'));

    $data_vessel=array(
    'vessel_registration_number'=>$registration_number,
    'no_of_shaft'=>$propulsion_shaft_number,
    'stern'=>$stern,
    'stern_id'=>$stern_material_sl,
    'vessel_modified_user_id'   =>  $sess_usr_id,
    'vessel_modified_timestamp' =>  $date,
    'vessel_modified_ipaddress' =>  $ip);

    $engine_data=array(
    //'propulsion_shaft_number'=>$propulsion_shaft_number,
    'cylinder_number'=>$cylinder_number,
    'rpm'=>$rpm,
    'engine_modified_user_id'    =>  $sess_usr_id,
    'engine_modified_timestamp'  =>  $date,
    'engine_modified_ipaddress'  =>  $ip);

    $data_vessel_timeline= array('registration_number' => $registration_number,
    'timeline_modified_user_id'=>$sess_usr_id,
    'timeline_modified_timestamp'=>$date,
    'timeline_modified_ipaddress'=>$ip);

    $data_main=array('vesselmain_reg_number' => $registration_number,
    'vesselmain_reg_date' => $reg_date,
    'next_reg_renewal_date'=>$registration_validity_period);  

    if(!empty($regcount))
    {
      $data_regcount=array('regcount' => $regcount);
    }
    if(!empty($regcount_id))
    {
      $process_update_regcount=$this->Survey_model->update_vessel_regcount('tb_regcount',$data_regcount, $regcount_id);
    }
    /*else {  $process_update_regcount="";}*/
    $data_reg_history=array(
    'registration_vessel_id'=>$vessel_id,
    'registration_date'=>$reg_date,
    'registration_number'=>$registration_number,
    'registration_validity_period'=>$registration_validity_period,
    'registering_authority'=>$registering_authority,
    'registration_payment_date'=>$registration_payment_date,
    'registration_verify_id'=>$sess_usr_id,
    'registration_verified_date'=>$reg_date,
    'registering_user'=>$user_id_owner,
    'registration_type'=>1,
    'registration_status'=>1,
    'registration_intimation_id'=>$registration_intimation_sl,
    'registration_declaration_date'=>$reg_date);

    $result_reg_historyt=$this->db->insert('tbl_registration_history', $data_reg_history);

    /*________________update reference number start-registration___________________*/
    $ref_process_id=5;
    $ref_number_details     =   $this->Survey_model->get_ref_number_details($vessel_id,$ref_process_id);
    $data['ref_number_details'] =   $ref_number_details;

    $last_ref_number_details      =   $this->Survey_model->get_last_ref_number_details($vessel_id);
    $data['last_ref_number_details']  =   $last_ref_number_details;
    if(!empty($last_ref_number_details))
    {
      $previous_ref_id =  $last_ref_number_details[0]['ref_id'];
    }
    else
    {
      $previous_ref_id =  0;
    }
    if(!empty($ref_number_details))
    {
      $ref_id      = $ref_number_details[0]['ref_id'];
      $data_ref_number = array(
      'ref_number_status' => 0, 
      'previous_ref_id'=>$previous_ref_id,
      'ref_number_modified_user_id'=>$sess_usr_id,
      'ref_number_modified_timestamp'=>$date,
      'ref_number_modified_ipaddress'=>$ip);  
      $update_ref_number    =  $this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);
    }
    /*________________update reference number end-registration___________________*/
    $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);
    $process_update_timeline=$this->Survey_model->update_vessel_timeline('tbl_kiv_vessel_timeline',$data_vessel_timeline, $vessel_id);
    $update_enginedetails=$this->Survey_model->update_table_engine_byvessel('tbl_kiv_engine_details',$engine_data,$vessel_id);
    $update_vessel_table		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vessel_id);
    if($update_enginedetails && $update_vessel_table  && $process_update_main && $process_update_timeline)
    {
      echo "1";
    }
    else
    {
      echo "0";
    }
  }
  else
  {
    redirect('Main_login/index'); 
  }
}
public function form14_certificate()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');
  $vessel_id	=	$this->uri->segment(4);

  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form14_certificate', 'page' => 'form14_certificate', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $ip     = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date   =   date('Y-m-d h:i:s', time()); 

    /*$vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
    $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
    $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
    $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
    $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
    $current_position 	=	$this->security->xss_clean($this->input->post('current_position'));
    $user_id 			=	$this->security->xss_clean($this->input->post('user_sl_ra'));
    $status 			=	1;
    $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));
    $user_id_owner 		=	$this->security->xss_clean($this->input->post('user_id_owner'));
    $user_type_id_owner =	$this->security->xss_clean($this->input->post('user_type_id_owner'));
    $registration_intimation_sl =	$this->security->xss_clean($this->input->post('registration_intimation_sl'));
    $remarks 			=	$this->security->xss_clean($this->input->post('remarks'));*/

    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;
   // print_r($vessel_details_viewpage);

     @$id=$vessel_details_viewpage[0]['user_id'];

    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    

    $survey_id=1;
    //----------Hull Details--------//
    $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']    = $hull_details;
    

    //----------Engine Details--------//
    $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']  = $engine_details;
    

    $html=$this->load->view('Kiv_views/dash/form14_certificate',$data,TRUE);
    //echo($html);

   $this->load->library('Pdf.php');
    $pdf = 	$this->pdf->load();
    $pdf->allow_charset_conversion=true;  // Set by default to TRUE
    $pdf->charset_in='UTF-8';
    $pdf->autoLangToFont = true;
    ini_set('memory_limit', '256M');
   

    $output=$pdf->WriteHTML($html);
    $pdf->Output($output, 'I'); 
    exit();


    //$this->load->view('Kiv_views/dash/form14_certificate',$data);
  }
  else
  {
    redirect('Main_login/index'); 
  }
}

/*________________________________________________________________________________*/
/*            Registration Module Ends                    */
/*_______________________________________________________________________________*/

public function reg_certificate_list()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'reg_certificate_list', 'page' => 'reg_certificate_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $sdate=date('Y-m-d', strtotime('-30 days'));
    $edate=date('Y-m-d');

    if($this->input->post())
    {
      $day="";
      $data['day']=$day;
      $from_date       = $this->security->xss_clean($this->input->post('from_date'));
      $to_date         = $this->security->xss_clean($this->input->post('to_date'));
      $reg_vessel      =   $this->Bookofregistration_model->get_reg_vessel_list_date($from_date,$to_date);
      $data['reg_vessel']  = $reg_vessel;
    }
    else
    {
      $day="30";
      $data['day']=$day;
      $reg_vessel      =   $this->Bookofregistration_model->get_reg_vessel_list_ndate($sdate,$edate);
      $data['reg_vessel']  = $reg_vessel;
    }
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
public function bookofregistration_list()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'bookofregistration_list', 'page' => 'bookofregistration_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    if($user_type_id==11)
    {
      $reg_vessel      =   $this->Bookofregistration_model->get_bookofregistration_list_owner($sess_usr_id);
      $data['reg_vessel']  = $reg_vessel;
    }
    elseif($user_type_id==3)
    {
      $customer_details       = $this->Bookofregistration_model->get_user_master($sess_usr_id);
      $data['customer_details'] = $customer_details;
      if(!empty($customer_details)) 
      {
        $user_master_port_id=$customer_details[0]['user_master_port_id'];
      }
      else
      {
        $user_master_port_id="";
      }

      $reg_vessel  =   $this->Bookofregistration_model->get_bookofregistration_list_pc($user_master_port_id);
      $data['reg_vessel']  = $reg_vessel;
    }
    else
    {
      $reg_vessel      =   $this->Bookofregistration_model->get_reg_vessel_list();
      $data['reg_vessel']  = $reg_vessel;
    }
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/bookofregistration_list',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index'); 
  }
}

public function form15_certificate()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  $vessel_id = $this->uri->segment(4);

  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'form15_certificate', 'page' => 'form15_certificate', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $ip     = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date   =   date('Y-m-d h:i:s', time()); 
    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;

    @$id=$vessel_details_viewpage[0]['user_id'];

    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $survey_id=1;
    //----------Hull Details--------//
    $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']    = $hull_details;

    //----------Engine Details--------//
    $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']  = $engine_details;

    $html=$this->load->view('Kiv_views/dash/form15_certificate',$data,TRUE);
    $this->load->library('Pdf.php');
    $pdf =  $this->pdf->load();
    $pdf->allow_charset_conversion=true;  // Set by default to TRUE
    $pdf->charset_in='UTF-8';
    $pdf->autoLangToFont = true;
    ini_set('memory_limit', '256M');
    $output=$pdf->WriteHTML($html);
    $pdf->Output($output, 'I'); 
    exit();
    //$this->load->view('Kiv_views/dash/form14_certificate',$data);
  }
  else
  {
    redirect('Main_login/index'); 
  }
}

public function renewal_certificate_list()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'renewal_certificate_list', 'page' => 'renewal_certificate_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $vessel_list          = $this->Bookofregistration_model->get_bookofregistration_list_owner($sess_usr_id);
    $data['vessel_list']  = $vessel_list;//print_r($vessel_list);
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/renewal_certificate_list',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index'); 
  }
}

public function send_renewal_application()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');

  $vessel_id1    = $this->uri->segment(4);
  $processflow_sl1   = $this->uri->segment(5);
  $status_details_sl1    = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $status_details_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl=$this->encrypt->decode($status_details_sl); 

  if(!empty($sess_usr_id)&&($user_type_id==11))
  {
    $data = array('title' => 'send_renewal_application', 'page' => 'send_renewal_application', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    //-------Payment ---------------//
    $paymenttype              =   $this->Survey_model->get_paymenttype();
    $data['paymenttype']      =   $paymenttype;

    $bank                     =   $this->Survey_model->get_bank_favoring();
    $data['bank']             =   $bank;

    $portofregistry           =   $this->Survey_model->get_portofregistry();
    $data['portofregistry']   =   $portofregistry;


    $vessel_list              = $this->Bookofregistration_model->get_vessellist_owner($vessel_id);
    $data['vessel_list']      = $vessel_list; //print_r($vessel_list);

    $vesselDet            = $this->Bookofregistration_model->get_vesselDet($vessel_id);
    $data['vesselDet']    = $vesselDet;

    $insurance_details=  $this->Survey_model->get_insurance_details($vessel_id);
    $data['insurance_details']     =   $insurance_details;

    if(!empty($vesselDet))
    {
      $vessel_type_id       = $vesselDet[0]['vessel_type_id'];
      $vessel_subtype_id    = $vesselDet[0]['vessel_subtype_id'];
    }

    $vesselMasterDetails            = $this->Bookofregistration_model->get_crew_details($vessel_id,1);
    $data['vesselMasterDetails']    = $vesselMasterDetails;

    $insuranceCompany               = $this->Bookofregistration_model->get_insuranceCompany();
    $data['insuranceCompany']       = $insuranceCompany;

    $insurance_type                     = $this->Bookofregistration_model->get_insurance_type();
    $data['insurance_type']             = $insurance_type;

    $form_id=0;
    $activity_id=10;

    $tariff_details  =   $this->Bookofregistration_model->get_tariff_form12_renewal($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    //print_r($tariff_details);

    $data['tariff_details']  =   $tariff_details;
    if (!empty($tariff_details)) 
    {
      $tariff_amount1=$tariff_details[0]['tariff_amount'];
      $tariff_min_amount=$tariff_details[0]['tariff_min_amount'];
    }
    else
    {
      $tariff_amount1=1;
      $tariff_min_amount=1;
    }
    $tonnage_details            =   $this->Bookofregistration_model->get_tonnage_details($vessel_id);
    $data['tonnage_details']   =   $tonnage_details;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1=$vessel_total_tonnage*$tariff_amount1;

    /*  if($amount1<250)
    {
    $data['tariff_amount']=$tariff_min_amount;
    }
    else
    {
    $data['tariff_amount']=$amount1;
    }*/
    if($vessel_type_id==1)
    {
      $tariff_amount=$tariff_min_amount;
      $data['tariff_amount']=$tariff_min_amount;
    }
    else
    {
      if($amount1<280)
      {
        $tariff_amount=$tariff_min_amount;
        $data['tariff_amount']=$tariff_min_amount;
      }
      else
      {
        $tariff_amount=$amount1;
        $data['tariff_amount']=$amount1;
      }
    }
    $data                 = $data + $this->data;
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/send_renewal_application',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

function renewalofregistration()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id)&&($user_type_id==11))
  {
    $data = array('title' => 'renewalofregistration', 'page' => 'renewalofregistration', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_id = $this->security->xss_clean($this->input->post('vessel_id')); 
    /*__________________Insurance details data fetch start___________________________*/
    $insuranceCompanyId       =  $this->security->xss_clean($this->input->post('insuranceCompanyId'));
    $insuranceNumber          =  $this->security->xss_clean($this->input->post('insuranceNumber'));
    $insuranceDate            = date('Y-m-d',strtotime($this->security->xss_clean($this->input->post('insuranceDate'))));
    $insuranceValidity        =  date('Y-m-d',strtotime($this->security->xss_clean($this->input->post('insuranceValidity'))));
    $vessel_insurance_type    =  $this->security->xss_clean($this->input->post('vessel_insurance_type'));
    $vessel_insurance_premium =  $this->security->xss_clean($this->input->post('vessel_insurance_premium'));
    /* $statementofOwner         =  $_FILES["statementofOwner"]["name"];
    $thirdpartyInsuranceCopy  =  $_FILES["thirdpartyInsuranceCopy"]["name"];*/
    //$statementofOwner =  $this->security->xss_clean($this->input->post('statementofOwner'));
   // $thirdpartyInsuranceCopy =  $this->security->xss_clean($this->input->post('thirdpartyInsuranceCopy'));

    /*
    $thirdparty_InsuranceCopy_img  =  $this->security->xss_clean($this->input->post('thirdparty_InsuranceCopy'));
    $statementof_Owner_img         =  $this->security->xss_clean($this->input->post('statementof_Owner'));
    */

    //$declarationOfOwnership   =  $_FILES["declarationOfOwnership"]["name"];
    $vessel_insurance_sl      =   $this->security->xss_clean($this->input->post('vessel_insurance_sl'));
    /*__________________Insurance details data fetch end___________________________*/

    //if($thirdpartyInsuranceCopy)
    if(($_FILES["thirdpartyInsuranceCopy"]["name"])!="")
    { 
      $ins_path_parts = pathinfo($_FILES["thirdpartyInsuranceCopy"]["name"]);
      $ins_extension  = $ins_path_parts['extension'];
      $ins_file_name='INS'.'_REG_Form12_'.$vessel_id.'_'.$date.'.'.$ins_extension;
      $ins_upd=copy($_FILES["thirdpartyInsuranceCopy"]["tmp_name"], "./uploads/thirdPartyInsurance"."/".$ins_file_name); 
    }
    else
    {
      $ins_file_name="";
    }
    /*_____________________________Upload Thirdpaty Insurance Copy end_____________________________*/
    /*_____________________________Upload Statement of Owner start_________________________________*/
    //if($statementofOwner)
    if(($_FILES["statementofOwner"]["name"])!="")
    { 
      $smt_path_parts = pathinfo($_FILES["statementofOwner"]["name"]);
      $smt_extension  = $smt_path_parts['extension'];
      $smt_file_name='SO'.'_REG_Form12_'.$vessel_id.'_'.$date.'.'.$smt_extension;
      $smt_upd=copy($_FILES["statementofOwner"]["tmp_name"], "./uploads/OwnerStatement"."/".$smt_file_name);
    }
    else
    {
      $smt_file_name="";
    }
    /*if($declarationOfOwnership)
    { 
    $dln_path_parts = pathinfo($_FILES["declarationOfOwnership"]["name"]);
    if($dln_path_parts){
    $dln_extension  = $dln_path_parts['extension'];

    $dln_file_name='DLS'.'_REG_Form12_'.$vessel_id.'_'.$date.'.'.$dln_extension;
    $dln_upd=copy($_FILES["declarationOfOwnership"]["tmp_name"], "./uploads/declarationOfOwnership"."/".$dln_file_name); 
    }

    }*/
    /*if(!empty($thirdparty_InsuranceCopy_img))
    {
    $ins_file_name1=$thirdparty_InsuranceCopy_img;
    }
    else
    {
    $ins_file_name1=$ins_file_name;
    }

    if(!empty($statementof_Owner_img))
    {
    $smt_file_name1=$statementof_Owner_img;
    }
    else
    {
    $smt_file_name1=$smt_file_name;
    }
    */
    /*_____________________________Upload Statement of Owner end_________________________________*/
    $vessel_main= $this->Bookofregistration_model->get_vessellist_owner($vessel_id);
    $data['vessel_main']    = $vessel_main;
    if(!empty($vessel_main))
    {
      $vesselmain_sl=$vessel_main[0]['vesselmain_sl'];
      $vesselmain_vessel_name=$vessel_main[0]['vesselmain_vessel_name'];
    }
    else
    {
      $vesselmain_sl=0;
      $vesselmain_vessel_name="";
    }
    //_____________Tariff amount___________________//
    $vesselDet            = $this->Bookofregistration_model->get_vesselDet($vessel_id);
    $data['vesselDet']    = $vesselDet;
    if(!empty($vesselDet))
    {
      $vessel_type_id       = $vesselDet[0]['vessel_type_id'];
      $vessel_subtype_id    = $vesselDet[0]['vessel_subtype_id'];
    }

    $form_id=12;
    $activity_id=10;

    $tariff_details  =   $this->Bookofregistration_model->get_tariff_form12_renewal($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);

    $data['tariff_details']  =   $tariff_details;
    if (!empty($tariff_details)) 
    {
      $tariff_amount1=$tariff_details[0]['tariff_amount'];
      $tariff_min_amount=$tariff_details[0]['tariff_min_amount'];
    }
    else
    {
      $tariff_amount1=1;
      $tariff_min_amount=1;
    }
    $tonnage_details            =   $this->Bookofregistration_model->get_tonnage_details($vessel_id);
    $data['tonnage_details']   =   $tonnage_details;

    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
    }
    $amount1=$vessel_total_tonnage*$tariff_amount1;

    /* if($amount1<250)
    {
    $tariff_amount=$tariff_min_amount;
    }
    else
    {
    $tariff_amount=$amount1;
    }*/
    if($vessel_type_id==1)
    {
      $tariff_amount=$tariff_min_amount;
    }
    else
    {
      if($amount1<280)
      {
        $tariff_amount=$tariff_min_amount;
      }
      else
      {
        $tariff_amount=$amount1;
      }
    }
    //__________________________________________________//

    $portofregistry_sl = $this->security->xss_clean($this->input->post('portofregistry_sl'));
    $bank_sl = $this->security->xss_clean($this->input->post('bank_sl'));
    $new_process_id=42; 
    $survey_id=0;
    $status       = 1;
    $paymenttype_id=4;

    $port_registry_user_id           =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
    $data['port_registry_user_id']  =   $port_registry_user_id;

    if(!empty($port_registry_user_id))
    {
      $pc_user_id=$port_registry_user_id[0]['user_master_id'];
      $pc_usertype_id=$port_registry_user_id[0]['user_master_id_user_type'];
    }
    $form_number_cs=  $this->Survey_model->get_form_number_cs($new_process_id);
    $data['form_number_cs']     =   $form_number_cs;

    if(!empty($form_number_cs))
    {
      $formnumber=$form_number_cs[0]['form_no'];
    }
    else
    {
      $formnumber=0;
    }
    date_default_timezone_set("Asia/Kolkata");
    $ip         = $_SERVER['REMOTE_ADDR'];
    $date       =   date('Y-m-d h:i:s', time());
    $newDate    =   date("Y-m-d");
    $status_change_date=$date;

    //////////////////////Reference Number For Renewal of registration Process (Start)////////////////////////////

    /* $ownchg_rws                   = $this->Bookofregistration_model->get_reg_renewal_rws();
    $cntown_rws                   = count($ownchg_rws);
    if($cntown_rws==0){
    $value                      = "1";
    } elseif ($cntown_rws>0) {
    $ownchg_last_refno          = $this->Bookofregistration_model->get_reg_renewal_ref_number();
    foreach ($ownchg_last_refno as $ref_res) {
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
    $ref_number                   = "RR"."_".$value."_".$vessel_id.$yr; */

    //////////////////////Reference Number For Renewal of registration Process (End)////////////////////////////

    /*_______________________________GET Vessel ref number-start_____________________*/
    $ref_process_id=10;
    $vessel_ref_number          =   $this->Survey_model->get_vessel_ref_number($ref_process_id);
    $data['vessel_ref_number']  =   $vessel_ref_number;
    $cnt_rws                      = count($vessel_ref_number);
    if($cnt_rws==0)
    {
      $value                      = "1";
    } 
    elseif ($cnt_rws>0) 
    {
      $last_refno         = $this->Survey_model->get_last_ref_number($ref_process_id);
      foreach ($last_refno as $ref_res) 
      {
        $ref_no                   = $ref_res['ref_number'];
      }
      $ref_exp                    = explode('_', $ref_no);
      $ref_val                    = $ref_exp[1];
      $value                      = $ref_val + 1;
    }

    if($value<10)
    {
      $value                      = "00".$value;
    } 
    elseif ($value<100) 
    {
      $value                      = "0".$value;
    } 
    else 
    {
      $value                      = $value;
    }

    $yr                           = date('Y');
    $ref_number                   = "REWREG"."_".$value."_".$vessel_id.$yr;

    $data_ref_number= array('vessel_id' =>$vessel_id ,
    'process_id'=>$ref_process_id,
    'ref_number'=>$ref_number,
    'ref_number_status'=>1,
    'ref_number_created_user_id'=>$sess_usr_id,
    'ref_number_created_timestamp'=>$date,
    'ref_number_created_ipaddress'=>$ip);
    $result_ref_number=$this->db->insert('tbl_kiv_reference_number', $data_ref_number); 
    /*_______________________________GET Vessel ref number-end_____________________*/

    $data_vessel= array('validity_of_insurance'=>$insuranceValidity,
    'vessel_modified_user_id'=> $sess_usr_id,
    'vessel_modified_timestamp'=>$date,
    'vessel_modified_ipaddress'=>$ip);
    $update_vessel_table   = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel, $vessel_id);

    $update_insurance_data= array('vessel_insurance_status'=>0,
    'insurance_modified_user_id'=> $sess_usr_id,
    'insurance_modified_datetime'=>$date,
    'insurance_modified_ipaddress'=>$ip);

    $insertInsuranceDet=array(
    'vessel_id'                      => $vessel_id,
    'vessel_insurance_company'       => $insuranceCompanyId,
    'vessel_insurance_type'          => $vessel_insurance_type,
    'vessel_insurance_date'          => $insuranceDate,
    'vessel_insurance_premium'       => $vessel_insurance_premium,
    'vessel_insurance_validity'      => $insuranceValidity,
    'vessel_thirdpartyInsuranceCopy' => $ins_file_name,
    'vessel_statementofOwner'        => $smt_file_name,
    'vessel_insurance_status'        => 1,
    'vessel_insurance_number'        => $insuranceNumber,
    'insurance_created_user_id'      => $sess_usr_id,
    'insurance_created_timestamp'    => $date,
    'insurance_created_ipaddress'    => $ip );

    $data_registration_renewal=array('registration_renewal_vessel_id'=>$vessel_id,
    'registration_renewal_name'=> $vesselmain_vessel_name,
    'ref_number'=>$ref_number,
    'registration_renewal_vessel_main_id'=>$vesselmain_sl,
    'registration_renewal_req_date'=>$newDate,
    'payment_status'=>0,
    'registration_renewal_status'=>0);
    $result_registration_renewal  = $this->db->insert('tbl_registration_renewal', $data_registration_renewal);

    $insertInsuranceDet      = $this->security->xss_clean($insertInsuranceDet);         
    $insertInsuranceDet_res  = $this->db->insert('tbl_vessel_insurance_details', $insertInsuranceDet);
    $vessel_insurance_sl_new     =    $this->db->insert_id();


    if(!empty($vessel_insurance_sl))
    {
      $updateInsuranceDet_res   =    $this->Bookofregistration_model->update_insurance_table('tbl_vessel_insurance_details',$update_insurance_data, $vessel_insurance_sl);
    }

    $payment_user=  $this->Survey_model->get_payment_userdetails($sess_usr_id);
    $data['payment_user']     =   $payment_user;
    //print_r($payment_user);exit;
    if(!empty($payment_user))
    {
      $owner_name=$payment_user[0]['user_name'];
      $user_mobile_number=$payment_user[0]['user_mobile_number'];
      $user_email=$payment_user[0]['user_email'];
    }

    $milliseconds = round(microtime(true) * 1000); //Generate unique bank number

    $bank_gen_number         =   $this->Survey_model->get_bank_generated_last_number($bank_sl);
    $data['bank_gen_number']   = $bank_gen_number;

    if(!empty($bank_gen_number))
    {
      $bank_generated_number =  $bank_gen_number[0]['last_generated_no']+1;
      $transaction_id        =  $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds.$bank_generated_number;
      $tocken_number         =  $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds;
      $bank_data             =  array('last_generated_no'=>$bank_generated_number);
      $data_payment_request = array('transaction_id' => $transaction_id,
      'bank_ref_no'   =>0 ,
      'token_no'      => $tocken_number,
      'vessel_id'     =>$vessel_id,
      'survey_id'     => $survey_id,
      'form_number'   => $formnumber,
      'customer_registration_id' => $sess_usr_id,
      'customer_name'         => $owner_name,
      'mobile_no'             => $user_mobile_number,
      'email_id'              => $user_email,
      'transaction_amount'    => $tariff_amount,
      'remitted_amount'       => 0,
      'bank_id'               => $bank_sl,
      'transaction_status'    => 0,
      'payment_status'        => 0,
      'transaction_timestamp' => $date,
      'transaction_ipaddress' => $ip,
      'port_id'               => $portofregistry_sl);

      $result_insert=$this->db->insert('kiv_bank_transaction_request', $data_payment_request); 
      if($result_insert)
      {
        $bank_transaction_id     =    $this->db->insert_id();
        $update_bank             =    $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);
        $online_payment_data      =   $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
        $data['online_payment_data']= $online_payment_data;
        $payment_user1              =  $this->Survey_model->get_payment_userdetails($sess_usr_id);
        $data['payment_user1']     =  $payment_user1;
        $requested_transaction_details=  $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
        $data['requested_transaction_details']  =   $requested_transaction_details;
        $data['amount_tobe_pay']=$tariff_amount;//remove comment before uploaded to server
        //$data['amount_tobe_pay']=1;
        $data      =  $data+ $this->data;
        /*___________Actual data for server-start_________________*/
        if(!empty($online_payment_data))
        { 
          $this->load->view('Kiv_views/Hdfc/hdfc_renewalcertificate_request',$data);
        }
        else
        {
          redirect('Kiv_Ctrl/Survey/SurveyHome');
        }
        /*___________Actual data for server-end_________________*/



      }
      else
      {
        redirect('Kiv_Ctrl/Survey/SurveyHome');
      }
    }
    else
    {
      redirect('Kiv_Ctrl/Survey/SurveyHome');
    }
  }
  else
  {
    redirect('Main_login/index'); 
  }
}


public function Verify_payment_pc_renewal_reg()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');
  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

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
    $data   =  array('title' => 'Verify_payment_pc_renewal_reg', 'page' => 'Verify_payment_pc_renewal_reg', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details       =   $this->Survey_model->get_process_flow_payment($processflow_sl);
    $data['vessel_details']   = $vessel_details;

    @$id            = $vessel_details[0]['uid'];
    $survey_id            = $vessel_details[0]['survey_id'];

    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;

    $current_status       = $this->Survey_model->get_status();
    $data['current_status']   = $current_status;

    $form_number        = $this->Survey_model->get_form_number($vessel_id);
    $data['form_number']    = $form_number;
    $form_id=$form_number[0]['form_no'];

    //----------Vessel Details--------//
    $vessel_details_viewpage =  $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;

    //----------Payment Details--------//
    $payment_details =  $this->Survey_model->get_form_payment_details($vessel_id,10,$form_id);
    $data['payment_details']= $payment_details;

    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date                   =   date('Y-m-d h:i:s', time());
      $vessel_id      = $this->security->xss_clean($this->input->post('vessel_id'));  
      $process_id     = $this->security->xss_clean($this->input->post('process_id')); 
      $survey_id      = $this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id  = $this->security->xss_clean($this->input->post('current_status_id'));;
      $current_position   = $this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date = $date;
      $processflow_sl   = $this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id      = $this->security->xss_clean($this->input->post('user_id'));
      $user_sl_ra     = $this->security->xss_clean($this->input->post('user_sl_ra'));
      $status       = 1;

      $status_details_sl= $this->security->xss_clean($this->input->post('status_details_sl'));
      $payment_sl   = $this->security->xss_clean($this->input->post('payment_sl'));
      $payment_approved_remarks = $this->security->xss_clean($this->input->post('remarks'));

      $date               =   date('Y-m-d h:i:s', time());
      $ip             = $_SERVER['REMOTE_ADDR'];
      $status_change_date = $date;
      $newDate    =   date("Y-m-d");

      if($process_id==42)
      {
        $data_payment=array(
        'payment_approved_status' =>1,
        'payment_approved_user_id' =>$sess_usr_id,
        'payment_approved_datetime' =>$status_change_date,
        'payment_approved_ipaddress' =>$ip,
        'payment_approved_remarks' =>$payment_approved_remarks);

        $new_process_id=42;
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>2,
        'current_position'=>$current_position,
        'user_id'=>$user_sl_ra,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);

        $data_survey_status=array(
        'current_status_id'=>2,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_sl_ra);
        /*______________________update tbl_registration_renewal start______________________*/
        $data_renewal=array('registration_renewal_pc_verified_date'=>$newDate);
        $registration_renewal           =   $this->Survey_model->get_registration_renewal($vessel_id);
        $data['registration_renewal']  =   $registration_renewal;
        if(!empty($registration_renewal))
        {
          $registration_renewal_sl=$registration_renewal[0]['registration_renewal_sl'];
          $update_reg_renewal   = $this->Survey_model->update_tables('tbl_registration_renewal',$data_renewal,'registration_renewal_sl',$registration_renewal_sl);
        }
        /*______________________update end______________________*/
        $payment_update=$this->Survey_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        if($payment_update && $process_update && $process_insert && $status_update)
        {
          redirect("Kiv_Ctrl/Survey/pcHome"."/".$modidenc);
        }
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_payment_pc_renewal_reg',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
 
public function view_renewal_request()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

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
    $data   =  array('title' => 'view_renewal_request', 'page' => 'view_renewal_request', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $survey_id=0;

    $vessel_details           =   $this->Survey_model->get_process_flow_payment($processflow_sl);
    $data['vessel_details']     =   $vessel_details;
    @$id                  =   $vessel_details[0]['uid'];

    $customer_details         =   $this->Survey_model->get_customer_details($id);
    $data['customer_details']   =   $customer_details;

    $current_status           =   $this->Survey_model->get_status();
    $data['current_status']     =   $current_status;

    $form_number            =   $this->Survey_model->get_form_number($vessel_id);
    $data['form_number']      =   $form_number;
    $form_id          = $form_number[0]['form_no'];

    $plyingPort                 = $this->Bookofregistration_model->get_portofregistry();
    $data['plyingPort']         = $plyingPort;

    //----------Vessel Details--------//
    $vessel_details_viewpage =  $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;

    //----------Payment Details--------//
    $payment_details =  $this->Survey_model->get_form3_tariff($vessel_id,10,$form_id);
    $data['payment_details']= $payment_details;

    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date         =   date('Y-m-d h:i:s', time());
      $status_change_date = $date;
      $remarks_date   = date('Y-m-d');
      $ip     = $_SERVER['REMOTE_ADDR'];

      $vessel_id          =   $this->security->xss_clean($this->input->post('vessel_id'));  
      $process_id         =   $this->security->xss_clean($this->input->post('process_id')); 
      $survey_id          =   $this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id  =   $this->security->xss_clean($this->input->post('current_status_id'));

      $processflow_sl     =   $this->security->xss_clean($this->input->post('processflow_sl'));
      //$current_position   =   $this->security->xss_clean($this->input->post('current_position'));
      $user_id_owner      =   $this->security->xss_clean($this->input->post('user_id')); 
      $user_type_id_owner =   $this->security->xss_clean($this->input->post('user_type_id'));
      $status             =   1;
      $status_details_sl  =   $this->security->xss_clean($this->input->post('status_details_sl'));

      $vessel_main=$this->Bookofregistration_model->get_vessellist_owner($vessel_id);
      $data['vessel_main']= $vessel_main;
      if(!empty($vessel_main))
      {
        $next_reg_renewal_date=$vessel_main[0]['next_reg_renewal_date'];
        $adding_five_year      = date('d-m-Y', strtotime($next_reg_renewal_date . "5 year") );
        $new_renewdate       = date('Y-m-d', strtotime($adding_five_year)); 
        $vesselmain_reg_number =$vessel_main[0]['vesselmain_reg_number'];
      }
      $registration_history=$this->Bookofregistration_model->get_registration_history($vessel_id);
      $data['registration_history']= $registration_history;
      if(!empty($registration_history))
      {
        $registration_sl=$registration_history[0]['registration_sl'];
      }
      else
      {
        $registration_sl=0;
      }

      /*______________________update tbl_registration_renewal start______________________*/
      $data_renewal=array(' registration_renewal_approve_date'=>$remarks_date,'registration_renewal_approve_id'=>$sess_usr_id,'registration_renewal_status'=>1);
      $registration_renewal           =   $this->Survey_model->get_registration_renewal($vessel_id);
      $data['registration_renewal']  =   $registration_renewal;
      if(!empty($registration_renewal))
      {
        $registration_renewal_sl=$registration_renewal[0]['registration_renewal_sl'];
        $update_reg_renewal   = $this->Survey_model->update_tables('tbl_registration_renewal',$data_renewal,'registration_renewal_sl',$registration_renewal_sl);
      }
      /*______________________update end______________________*/

      /*________________update reference number start-registration___________________*/
      $ref_process_id=10;
      $ref_number_details     =   $this->Survey_model->get_ref_number_details($vessel_id,$ref_process_id);
      $data['ref_number_details'] =   $ref_number_details;

      $last_ref_number_details      =   $this->Survey_model->get_last_ref_number_details($vessel_id);
      $data['last_ref_number_details']  =   $last_ref_number_details;
      if(!empty($last_ref_number_details))
      {
        $previous_ref_id =  $last_ref_number_details[0]['ref_id'];
      }
      else
      {
        $previous_ref_id =  0;
      }

      if(!empty($ref_number_details))
      {
        $ref_id      = $ref_number_details[0]['ref_id'];
        $data_ref_number = array(
        'ref_number_status' => 0, 
        'previous_ref_id'=>$previous_ref_id,
        'ref_number_modified_user_id'=>$sess_usr_id,
        'ref_number_modified_timestamp'=>$date,
        'ref_number_modified_ipaddress'=>$ip);  
        $update_ref_number    =  $this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);
      }
      /*________________update reference number end-registration___________________*/
      $survey_id=0;

      $data_insert_approve=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$user_type_id,
      'user_id'=>$sess_usr_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>0,
      'status_change_date'=>$status_change_date);

      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$user_type_id_owner,
      'user_id'=>$user_id_owner,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);

      $data_survey_status=array(
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$user_id_owner);

      $data_main=array('processing_status'=>0,
      'vesselmain_reg_date'=>$remarks_date,
      'next_reg_renewal_date'=>$new_renewdate,
      'vesselmain_renewal_status'=>1,
      'vesselmain_renewal_date'=>$new_renewdate,
      'vesselmain_renewal_id'=>'1');  

      $data_reg_history=array(
      'registration_vessel_id'=>$vessel_id,
      'registration_date'=>$remarks_date,
      'registration_number'=>$vesselmain_reg_number,
      'registration_validity_period'=>$new_renewdate,
      'registering_authority'=>$sess_usr_id,
      //'registration_payment_date'=>$registration_payment_date,
      'registration_verify_id'=>$sess_usr_id,
      'registration_verified_date'=>$remarks_date,
      'registering_user'=>$user_id_owner,
      'registration_type'=>2,
      'registration_status'=>1,
      // 'registration_intimation_id'=>$registration_intimation_id,
      'registration_declaration_date'=>$remarks_date);

      if($registration_sl!=0)
      {
        $data_reg_history_update=array('registration_status'=>0);
        $result_reg_history_update=$this->Survey_model->update_registration_history('tbl_registration_history',$data_reg_history_update, $registration_sl);
      }
      $result_reg_historyt=$this->db->insert('tbl_registration_history', $data_reg_history);
      $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);
      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      $process_update   = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert_approve=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_approve);
      $process_insert   = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      if($process_update_main && $status_update && $process_update && $process_insert_approve && $process_insert)
      {
        redirect('Kiv_Ctrl/Bookofregistration/raHome');
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/view_renewal_request',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function renewal_insurance_list()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
    { 
    $data = array('title' => 'renewal_insurance_list', 'page' => 'renewal_insurance_list', 'errorCls' => NULL, 'post' => $this->input->post());

    $vessel_list          = $this->Bookofregistration_model->get_insurance_list_owner($sess_usr_id);
    $data['vessel_list']  = $vessel_list;//print_r($vessel_list);
    $data = $data + $this->data;

    $this->load->model('Kiv_models/Survey_model');
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/renewal_insurance_list',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}


public function send_insurance_application()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  $vessel_id1         = $this->uri->segment(4);
  $processflow_sl1    = $this->uri->segment(5);
  $status_details_sl1    =   $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $status_details_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl=$this->encrypt->decode($status_details_sl); 

  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'send_insurance_application', 'page' => 'send_insurance_application', 'errorCls' => NULL, 'post' => $this->input->post());
    $this->load->model('Kiv_models/Survey_model');
    $vessel_list              = $this->Bookofregistration_model->get_vessellist_owner($vessel_id);
    $data['vessel_list']      = $vessel_list; //print_r($vessel_list);

    $vesselDet            = $this->Bookofregistration_model->get_vesselDet($vessel_id);
    $data['vesselDet']    = $vesselDet;

    $insurance_details=  $this->Survey_model->get_insurance_details($vessel_id);
    $data['insurance_details']     =   $insurance_details;

    $insuranceCompany               = $this->Bookofregistration_model->get_insuranceCompany();
    $data['insuranceCompany']       = $insuranceCompany;

    $insurance_type                     = $this->Bookofregistration_model->get_insurance_type();
    $data['insurance_type']             = $insurance_type;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/send_insurance_application',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index'); 
  }
}

function renewalofinsurance()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data = array('title' => 'renewalofinsurance', 'page' => 'renewalofinsurance', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    date_default_timezone_set("Asia/Kolkata");
    $date      =   date('Y-m-d h:i:s', time());
    $ip        = $_SERVER['REMOTE_ADDR'];
    $newDate   =   date("Y-m-d");
    $vessel_id = $this->security->xss_clean($this->input->post('vessel_id')); 
    /*__________________Insurance details data fetch start___________________________*/
    $insuranceCompanyId =  $this->security->xss_clean($this->input->post('insuranceCompanyId'));
    $insuranceNumber =  $this->security->xss_clean($this->input->post('insuranceNumber'));
    $insuranceDate = date('Y-m-d',strtotime($this->security->xss_clean($this->input->post('insuranceDate'))));
    $insuranceValidity=  date('Y-m-d',strtotime($this->security->xss_clean($this->input->post('insuranceValidity'))));
    $vessel_insurance_type    =  $this->security->xss_clean($this->input->post('vessel_insurance_type'));
    $vessel_insurance_premium =  $this->security->xss_clean($this->input->post('vessel_insurance_premium'));
   // $statementofOwner =  $this->security->xss_clean($this->input->post('statementofOwner'));
    //$thirdpartyInsuranceCopy =  $this->security->xss_clean($this->input->post('thirdpartyInsuranceCopy'));
    $vessel_insurance_sl      =   $this->security->xss_clean($this->input->post('vessel_insurance_sl'));

    /*__________________Insurance details data fetch end___________________________*/
   // if($thirdpartyInsuranceCopy)
    if(($_FILES["thirdpartyInsuranceCopy"]["name"])!="")
    { 
      $ins_path_parts = pathinfo($_FILES["thirdpartyInsuranceCopy"]["name"]);
      $ins_extension  = $ins_path_parts['extension'];
      $ins_file_name='INS'.'_REG_Form12_'.$vessel_id.'_'.$date.'.'.$ins_extension;
      $ins_upd=copy($_FILES["thirdpartyInsuranceCopy"]["tmp_name"], "./uploads/thirdPartyInsurance"."/".$ins_file_name); 
    }
    else
    {
      $ins_file_name="";
    }
    /*_____________________________Upload Thirdpaty Insurance Copy end_____________________________*/
    /*_____________________________Upload Statement of Owner start_________________________________*/
    //if($statementofOwner)
    if(($_FILES["statementofOwner"]["name"])!="")
    { 
      $smt_path_parts = pathinfo($_FILES["statementofOwner"]["name"]);
      $smt_extension  = $smt_path_parts['extension'];
      $smt_file_name='SO'.'_REG_Form12_'.$vessel_id.'_'.$date.'.'.$smt_extension;
      $smt_upd=copy($_FILES["statementofOwner"]["tmp_name"], "./uploads/OwnerStatement"."/".$smt_file_name);
    }
    else
    {
      $smt_file_name="";
    }

    $data_vessel= array('validity_of_insurance'=>$insuranceValidity,
    'vessel_modified_user_id'=> $sess_usr_id,
    'vessel_modified_timestamp'=>$date,
    'vessel_modified_ipaddress'=>$ip);
    
    $update_vessel_table   = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vessel_id);

    $update_insurance_data= array('vessel_insurance_status'=>0,
    'insurance_modified_user_id'=> $sess_usr_id,
    'insurance_modified_datetime'=>$date,
    'insurance_modified_ipaddress'=>$ip);
    if(!empty($vessel_insurance_sl))
    {
      $updateInsuranceDet_res   =    $this->Bookofregistration_model->update_insurance_table('tbl_vessel_insurance_details',$update_insurance_data, $vessel_insurance_sl);
    }
    $insertInsuranceDet=array(
    'vessel_id'                      => $vessel_id,
    'vessel_insurance_company'       => $insuranceCompanyId,
    'vessel_insurance_type'          => $vessel_insurance_type,
    'vessel_insurance_date'          => $insuranceDate,
    'vessel_insurance_premium'       => $vessel_insurance_premium,
    'vessel_insurance_validity'      => $insuranceValidity,
    'vessel_thirdpartyInsuranceCopy' => $ins_file_name,
    'vessel_statementofOwner'        => $smt_file_name,
    'vessel_insurance_status'        => 1,
    'vessel_insurance_number'        => $insuranceNumber,
    'insurance_created_user_id'      => $sess_usr_id,
    'insurance_created_timestamp'    => $date,
    'insurance_created_ipaddress'    => $ip );
    $insertInsuranceDet      = $this->security->xss_clean($insertInsuranceDet);         
    $insertInsuranceDet_res  = $this->db->insert('tbl_vessel_insurance_details', $insertInsuranceDet);
    $vessel_insurance_sl_new     =    $this->db->insert_id();
    $data_main=array(
    'vesselmain_insurance_id'=>$vessel_insurance_sl_new,
    'vesselmain_insurance_date'=>$newDate,
    'vesselmain_insurance_status'=>1);   
    $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);
    if($update_vessel_table && $insertInsuranceDet_res && $process_update_main )
    {
      redirect('Kiv_Ctrl/Survey/ren_ins_pol');
    }
  }
  else
  {
    redirect('Main_login/index'); 
  }
} 


public function renewal_pollution()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  $vessel_id1         = $this->uri->segment(4);
  $processflow_sl1    = $this->uri->segment(5);
  $status_details_sl1    =   $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $status_details_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
  $status_details_sl=$this->encrypt->decode($status_details_sl); 

  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'renewal_pollution', 'page' => 'renewal_pollution', 'errorCls' => NULL, 'post' => $this->input->post());
    $this->load->model('Kiv_models/Survey_model');
    $vessel_list              = $this->Bookofregistration_model->get_vessellist_owner($vessel_id);
    $data['vessel_list']      = $vessel_list; //print_r($vessel_list);

    $vesselDet            = $this->Bookofregistration_model->get_vesselDet($vessel_id);
    $data['vesselDet']    = $vesselDet;

    $pollution_details=$this->Survey_model->get_vessel_pollution($vessel_id);
    $data['pollution_details']  = $pollution_details;
   
    
    $insuranceCompany               = $this->Bookofregistration_model->get_insuranceCompany();
    $data['insuranceCompany']       = $insuranceCompany;

    $insurance_type                     = $this->Bookofregistration_model->get_insurance_type();
    $data['insurance_type']             = $insurance_type;
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/renewal_pollution',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index'); 
  }
}

function renewalofpollution()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data = array('title' => 'renewalofpollution', 'page' => 'renewalofpollution', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    date_default_timezone_set("Asia/Kolkata");
    $date      =   date('Y-m-d h:i:s', time());
    $ip        = $_SERVER['REMOTE_ADDR'];
    $newDate   =   date("Y-m-d");
    $vessel_id = $this->security->xss_clean($this->input->post('vessel_id')); 
    $pollution_sl      =  $this->security->xss_clean($this->input->post('pollution_sl'));
    $pcb_reg_date      =  $this->security->xss_clean($this->input->post('pcb_reg_date'));
    $pcb_expiry_date   =  $this->security->xss_clean($this->input->post('pcb_expiry_date'));
    $pcb_number        =  $this->security->xss_clean($this->input->post('pcb_number'));

    if(($_FILES["pcb_certificate"]["name"])!="")
    { 
      $ins_path_parts_pln = pathinfo($_FILES["pcb_certificate"]["name"]);
      $ins_extension_pln  = $ins_path_parts_pln['extension'];

      $ins_file_name_pln='pln_'.$vessel_id.'_'.$date.'.'.$ins_extension_pln;
      $ins_upd_pln=copy($_FILES["pcb_certificate"]["tmp_name"], "./uploads/pollution_certificate"."/".$ins_file_name_pln); 
    }
    else
    {
      $ins_file_name_pln="";
    }
    /*___________________Insert Pollution Details of Vessel end_____________________*/
    $data_pollution=array(
    'vessel_id'=>$vessel_id,
    'pcb_reg_date'=>$pcb_reg_date,
    'pcb_expiry_date'=>$pcb_expiry_date,
    'pcb_number'=>$pcb_number,
    'pcb_certificate'=>$ins_file_name_pln,
    'pollution_created_user_id'=>$sess_usr_id,
    'pollution_created_timestamp'=>$date,
    'pollution_created_ipaddress'=>$ip);   

    $res_pollution  = $this->db->insert('tbl_pollution_details', $data_pollution);       
    /*___________________Insert Insurance Details of Vessel end_____________________*/
    //_________________________ updation of tbl_pollution_details ______________________________// 
    $data_pollution_details= array(
    'pollution_status'=>0,
    'pollution_modified_user_id'=>$sess_usr_id,
    'pollution_modified_datetime'=>$date,
    'pollution_modified_ipaddress'=>$ip);
    if(!empty($pollution_sl))
    {
      $result_pollution_details   =    $this->Bookofregistration_model->update_pollution_table('tbl_pollution_details',$data_pollution_details, $pollution_sl);
    }
    if($res_pollution)
    {
      redirect('Kiv_Ctrl/Survey/ren_ins_pol');
    }
  }
  else
  {
    redirect('Main_login/index'); 
  }
}


public function dataentry_reports()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id       =  $this->session->userdata('customer_id');
  $survey_user_id    =  $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'dataentry_reports', 'page' => 'dataentry_reports', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;

    $dataentry_details=$this->Bookofregistration_model->get_dataentry_details();
    $data['dataentry_details']     =  $dataentry_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/dataentry_reports',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
public function verified_forms()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    =  $this->session->userdata('customer_id');
  $survey_user_id =  $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'verified_forms', 'page' => 'verified_forms', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $sdate=date('Y-m-d', strtotime('-30 days'));
     $edate=date('Y-m-d');
    if($this->input->post())
    {
      $day="";
      $data['day']=$day;
      $from_date       = $this->security->xss_clean($this->input->post('from_date'));
      $to_date         = $this->security->xss_clean($this->input->post('to_date'));
      $dataentry_details=$this->Bookofregistration_model->get_verified_dataentry_details_date($from_date,$to_date);
      $data['dataentry_details']     =  $dataentry_details;
    }
    else
    {
      $day="30";
      $data['day']=$day;
      $dataentry_details=$this->Bookofregistration_model->get_verified_dataentry_details_date($sdate,$edate);
      $data['dataentry_details']     =  $dataentry_details;
      
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/verified_forms',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function dataentry_reports_pc()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id       =  $this->session->userdata('customer_id');
  $survey_user_id    =  $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'dataentry_reports_pc', 'page' => 'dataentry_reports_pc', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;

    $user_type_id=$this->Bookofregistration_model->get_user_type_id($sess_usr_id);
    $data['user_type_id']     =  $user_type_id;
    if(!empty($user_type_id))
    {
      $user_master_port_id=$user_type_id[0]['user_master_port_id'];
    }
    else
    {
      $user_master_port_id=0;
    }
    $dataentry_details=$this->Bookofregistration_model->get_dataentry_details_pc($user_master_port_id);
    $data['dataentry_details']     =  $dataentry_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/dataentry_reports_pc',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function verified_forms_pc()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    =  $this->session->userdata('customer_id');
  $survey_user_id =  $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'verified_forms_pc', 'page' => 'verified_forms_pc', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $user_type_id=$this->Bookofregistration_model->get_user_type_id($sess_usr_id);
    $data['user_type_id']     =  $user_type_id;
    if(!empty($user_type_id))
    {
      $user_master_port_id=$user_type_id[0]['user_master_port_id'];
    }
    else
    {
      $user_master_port_id=0;
    }
    $dataentry_details=$this->Bookofregistration_model->get_verified_dataentry_details_pc($user_master_port_id);
    $data['dataentry_details']=  $dataentry_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/verified_forms_pc',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
public function emailSendFunction($to,$sub,$msg)
{
  $config = Array(
  'protocol'        => 'smtp',
  'smtp_host'       => 'ssl://smtp.googlemail.com',
  'smtp_port'       => 465,
  'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
  'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
  'mailtype'        => 'html',
  'charset'         => 'iso-8859-1');
  $this->load->library('email', $config);
  $this->email->set_newline("\r\n");
  $this->email->from('kivportinfo@gmail.com');// change it to yours
  //$this->email->to($to); 
  $this->email->to('kivportinfo@gmail.com');
  $this->email->subject($sub);
  $this->email->message($msg); 
  $result = $this->email->send();
  $res=$this->email->print_debugger();
  return $result;
}
////___________________end of controller___________________////
}

/*
Pollution control - 
Insurance - 
*/