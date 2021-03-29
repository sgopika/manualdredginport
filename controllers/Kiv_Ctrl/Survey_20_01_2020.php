<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller { //69239478

public function __construct() 
{
  parent::__construct();
  $this->load->library('session');
  $this->load->helper('form');
  $this->load->helper('url');
  $this->load->database();
  $this->load->library('form_validation');
  $this->load->library('Phpass',array(8, FALSE));
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
  'int_userid'       =>  isset($this->session->userdata['int_userid']) ? $this->session->userdata['int_userid'] : 0,
  'int_usertype'    =>  isset($this->session->userdata['int_usertype']) ? $this->session->userdata['int_usertype'] : 0,
  'customer_id' 		=> 	isset($this->session->userdata['customer_id']) ? $this->session->userdata['customer_id'] : 0,
  'survey_user_id' 	=> 	isset($this->session->userdata['survey_user_id']) ? $this->session->userdata['survey_user_id'] : 0,
  	);
  $this->load->model('Kiv_models/Survey_model'); 
  $this->load->model('Kiv_models/Vessel_change_model'); 
  $this->load->model('Kiv_models/DataEntry_model'); 
}
 	
 /* 67 18 16 27 58 3 -arunima nath uu
 sbin0010789    sbin0070254*/
/*_________________________________Vessel owner home page ________________________________*/
public function SurveyHome()
{
  $sess_usr_id 	  = $this->session->userdata('int_userid');
  $user_type_id	  =	$this->session->userdata('int_usertype');
  $customer_id	  =	$this->session->userdata('customer_id');
  $survey_user_id =	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'SurveyHome', 'page' => 'SurveyHome', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Master_model');
    $vessel_details			= 	$this->Survey_model->get_vessel_details($sess_usr_id);
    $data['vessel_details']	=	$vessel_details;
    //print_r($vessel_details);
    if(!empty($vessel_details))
    {
      $count	= count($vessel_details);
      $data['count']=$count;
    }
    else
    {
      $data['count']=0;
    }

    $incomplete_form1= 	$this->Survey_model->get_incomplete_form1($sess_usr_id);
    $data['incomplete_form1']	=	$incomplete_form1;
    if(!empty($incomplete_form1))
    {
     $incomplete_count	= count($incomplete_form1);
      $data['incomplete_count']=$incomplete_count;
    }
    ////namechange count
    $namechange_det=  $this->Vessel_change_model->get_vesselnamechange_details($sess_usr_id);
    $data['namechange_det'] = $namechange_det;
    if(!empty($namechange_det))
    {
      $namechange_count = count($namechange_det);
      $data['namechange_count']=$namechange_count;
    }
    ////ownershipchange count
    $ownerchange_det=  $this->Vessel_change_model->get_vesselownerchange_details($sess_usr_id);
    $data['ownerchange_det'] = $ownerchange_det; //print_r($ownerchange_det);
    if(!empty($ownerchange_det))
    {
      $ownerchange_count = count($ownerchange_det);
      $data['ownerchange_count']=$ownerchange_count;
    }
    ////transfervessel count
    $transfervesl_det=  $this->Vessel_change_model->get_transfervesselstatus_details($sess_usr_id);
    $data['transfervesl_det'] = $transfervesl_det; //print_r($ownerchange_det);
    if(!empty($transfervesl_det))
    {
      $transfervesl_count = count($transfervesl_det);
      $data['transfervesl_count']=$transfervesl_count;
    }
    ////transfervessel count
    $transfervesl_out=  $this->Vessel_change_model->get_transfervesseloutside_details($sess_usr_id);
    $data['transfervesl_out'] = $transfervesl_out; //print_r($ownerchange_det);
    if(!empty($transfervesl_out))
    {
      $transfervesl_out_count = count($transfervesl_out);
      $data['transfervesl_out_count']=$transfervesl_out_count;
    }
    ////duplicatecertificate count
    $duplicert_det=  $this->Vessel_change_model->get_duplicatecert_details($sess_usr_id);
    $data['duplicert_det'] = $duplicert_det;
    if(!empty($duplicert_det))
    {
      $dupcert_count = count($duplicert_det);
      $data['dupcert_count']=$dupcert_count;
    }
    //_________________________GET SURVEY COUNT START________________________________//
    $process_id=1;
    $initial_survey_id=1;
    $annual_survey_id=2;
    $drydock_survey_id=3;
    $special_survey_id=4;

    $initial_survey_done=$this->Survey_model->get_survey_count_owner($process_id,$initial_survey_id,$sess_usr_id);
    $data['initial_survey_done']  = $initial_survey_done;
    if(!empty($initial_survey_done))
    {
      $count_initial_survey = count($initial_survey_done);
      $data['count_initial_survey']=$count_initial_survey;
    }
    else
    {
      $count_initial_survey=0;
    }


    $annual_survey_done=$this->Survey_model->get_survey_count_owner($process_id,$annual_survey_id,$sess_usr_id);
    $data['annual_survey_done']  = $annual_survey_done;
    if(!empty($annual_survey_done))
    {
      $count_annual_survey  = count($annual_survey_done);
      $data['count_annual_survey']=$count_annual_survey;
    }
    else
    {
      $count_annual_survey=0;
    }
    $drydock_survey_done=$this->Survey_model->get_survey_count_owner($process_id,$drydock_survey_id,$sess_usr_id);
    $data['drydock_survey_done']  = $drydock_survey_done;
    if(!empty($drydock_survey_done))
    {
      $count_drydock_survey = count($drydock_survey_done);
      $data['count_drydock_survey']=$count_drydock_survey;
    }
    else
    {
      $count_drydock_survey=0;
    }

    $special_survey_done=$this->Survey_model->get_specialsurvey_done_owner_ndate($process_id,$sess_usr_id);
    $data['special_survey_done']  = $special_survey_done;
    if(!empty($special_survey_done))
    {
      $count_special_survey = count($special_survey_done);
      $data['count_special_survey']=$count_special_survey;
    }
    else
    {
      $count_special_survey=0;
    }
    //_________________________GET SURVEY COUNT END_______________________________________//
    /* ======Added for dynamic menu listing (start) on 02.11.2019========   */ 
    $menu     =   $this->Master_model->get_menu($user_type_id); //print_r($menu);
    $data['menu'] = $menu;
    $data       =   $data + $this->data;
    /* ======Added for dynamic menu listing (end)  on 02.11.2019========   */ 
    //print_r($incomplete_form1);
    /****===To change font color of INSURANCE/POLLUTION Renewal(Start) ==***/
    $date_chk     =   date('d-m-Y');
    $var=0;
    $vessel_det   =   $this->Survey_model->get_vessel_main_renew($sess_usr_id);
    foreach($vessel_det as $vessel_det_res){
      $vessel_id                = $vessel_det_res['vesselmain_vessel_id'];
      $vessel_name              = $vessel_det_res['vesselmain_vessel_name'];
      $vesselmain_reg_number    = $vessel_det_res['vesselmain_reg_number'];
      $vesselmain_reg_date      = date("d-m-Y", strtotime($vessel_det_res['vesselmain_reg_date']));
      $next_reg_renewal_date    = date("d-m-Y", strtotime($vessel_det_res['next_reg_renewal_date']));
      $vesselmain_annual_date   = date("d-m-Y", strtotime($vessel_det_res['vesselmain_annual_date']));
      $vesselmain_drydock_date  = date("d-m-Y", strtotime($vessel_det_res['vesselmain_drydock_date']));
        //_____________________get next annual survey date_____________________________//
      $process_id1    = 1;
      $subprocess_id2 = 2;
      $next_annual_details        = $this->Survey_model->get_vessel_timeline_nextdate($vessel_id,$process_id1,$subprocess_id2);
      $data['next_annual_details']= $next_annual_details;
      if(!empty($next_annual_details))
      {
        $next_annual_date         = date("d-m-Y", strtotime($next_annual_details[0]['scheduled_date']));
      }
      else
      {
        $next_annual_date   = "";
      }
     //_____________________get next drydock survey date_____________________________//
      $process_id1    = 1;
      $subprocess_id3 = 3;
      $next_drydock_details           = $this->Survey_model->get_vessel_timeline_nextdate($vessel_id,$process_id1,$subprocess_id3);
      $data['next_drydock_details']   = $next_drydock_details;
      if(!empty($next_drydock_details))
      {
        $next_drydock_date            = date("d-m-Y", strtotime($next_drydock_details[0]['scheduled_date']));
      }
      else
      {
        $next_drydock_date  = "";
      }
      //_____________________get pcb date_____________________________//
      $pollution_details              = $this->Survey_model->get_vessel_pollution($vessel_id);
      $data['pollution_details']      = $pollution_details;
      if(!empty($pollution_details))
      {
        $pcb_reg_date                 = date("d-m-Y", strtotime($pollution_details[0]['pcb_reg_date']));
        $validity_of_pcb              = date("d-m-Y", strtotime($pollution_details[0]['pcb_expiry_date']));
      }
      else
      {
        $pcb_reg_date       = "";
        $validity_of_pcb    = "";
      }
          
  //_____________________get insurance date_____________________________//
      $insurance_details=$this->Survey_model->get_insurance_details($vessel_id);
      $data['insurance_details']  = $insurance_details;
      if(!empty($insurance_details))
      {
        $vessel_insurance_date=date("d-m-Y", strtotime($insurance_details[0]['vessel_insurance_date']));
        $vessel_insurance_validity=date("d-m-Y", strtotime($insurance_details[0]['vessel_insurance_validity']));
      }
      else
      {
        $vessel_insurance_date="";
        $vessel_insurance_validity="";
      }
      
      if(strtotime($date_chk)>strtotime($next_reg_renewal_date)){
        $var  = $var+1;

      } 
      if(strtotime($date_chk)>strtotime($next_annual_date)){
        $var  = $var+1;
      }
      if(strtotime($date_chk)>strtotime($next_drydock_date)){
        $var  = $var+1;
      }
      if(strtotime($date_chk)>strtotime($validity_of_pcb)){
        $var  = $var+1;
      }
      if(strtotime($date_chk)>strtotime($vessel_insurance_validity)){
        $var  = $var+1;
      }
      
    } 
    //echo $var;exit;
    $data['var']  = $var;
    $data         = $data + $this->data;
    /****===To change font color of INSURANCE/POLLUTION Renewal(End) ==***/
    

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/owner',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  } 
}

public function Owner_Inbox()
{
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'Owner_Inbox', 'page' => 'Owner_Inbox', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Master_model');
    $vessel_details     =   $this->Survey_model->get_vessel_details($sess_usr_id);
    $data['vessel_details'] = $vessel_details;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Owner_Inbox',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  } 
}

public function incomplete_reg_list()
{
  /*$sess_usr_id 	  = $this->session->userdata('user_sl');
  $user_type_id	  =	$this->session->userdata('user_type_id');*/
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	  =	$this->session->userdata('customer_id');
  $survey_user_id =	$this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'incomplete_reg_list', 'page' => 'incomplete_reg_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $incomplete_form1= 	$this->Survey_model->get_incomplete_form1($sess_usr_id);
    $data['incomplete_form1']	=	$incomplete_form1;
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/incomplete_reg_list',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  } 
}

//_________________________________Form 1 Add new vessel _______________________________//

public function add_form1()
{
  /*$sess_usr_id 		   = 	$this->session->userdata('user_sl');
  $user_type_id		   =	$this->session->userdata('user_type_id');*/
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		   =	$this->session->userdata('customer_id');
  $survey_user_id	   =	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'add_form1', 'page' => 'add_form1', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    //----------Owner Details--------------//
    $user			        = 	$this->Survey_model->get_user($customer_id);
    $data['user']       	=	$user;

     $agent			       = 	$this->Survey_model->get_agent($customer_id);
    $data['agent']	       =	$agent;

    //-------Vessel Details---------------//
    $vesselcategory         =  $this->Survey_model->get_vesselcategory();
    $data['vesselcategory'] =	  $vesselcategory;

    $vesseltype             = 	$this->Survey_model->get_vesseltype();
    $data['vesseltype']     =	  $vesseltype;

    $month                  = 	$this->Survey_model->get_month();
    $data['month']		      =	  $month;

    //-------Particulars Hull Details---------------//

    $hullmaterial           = 	$this->Survey_model->get_hullmaterial();
    $data['hullmaterial']   =	  $hullmaterial;

    $inboard_outboard			= 	$this->Survey_model->get_inboard_outboard();
    $data['inboard_outboard']	=	$inboard_outboard;
           
    //-------Particulars Equipment Details---------------//
           
    $equipment_details            = 	$this->Survey_model->get_equipment_details();
    $data['equipment_details']    =	$equipment_details; 

    $equipment_material           = 	$this->Survey_model->get_equipment_material();
    $data['equipment_material']   =	$equipment_material; 

    $equipment_type	            = 	$this->Survey_model->get_equipment_type();
    $data['equipment_type']	    =	 $equipment_type;

    $chainport_type	            = 	$this->Survey_model->get_chainport_type();
    $data['chainport_type']	    =	 $chainport_type;

    $searchlight_size	            = 	$this->Survey_model->get_searchlight_size();
    $data['searchlight_size']     =	  $searchlight_size;


    $navigation_light	            = 	$this->Survey_model->get_navigation_light();
    $data['navigation_light']     =	  $navigation_light;

    $sound_signals	            = 	$this->Survey_model->get_sound_signals();
    $data['sound_signals']        =	  $sound_signals;

    $rope_material	            = 	$this->Survey_model->get_rope_material();
    $data['rope_material']        =	  $rope_material;

    //-------Particulars of Fire Appliance---------------//

    $firepumptype	                = 	$this->Survey_model->get_firepumptype();
    $data['firepumptype']	        =	  $firepumptype;

    $bilgepumptype	              = 	$this->Survey_model->get_bilgepumptype();
    $data['bilgepumptype']        =	  $bilgepumptype;

    $firepumpsize		              = 	$this->Survey_model->get_firepumpsize();
    $data['firepumpsize']         =	  $firepumpsize;

    $nozzletype	                  = 	$this->Survey_model->get_nozzletype();
    $data['nozzletype']	          =	  $nozzletype;

    $portable_fire_ext	          = 	$this->Survey_model->get_portable_fire_ext();
    $data['portable_fire_ext']	  =	  $portable_fire_ext;
    //-------Particulars of other Equipments---------------//
    $commnequipment				       = 	$this->Survey_model->get_commnequipment();
    $data['commnequipment']      =	$commnequipment;

    $navgnequipments			       = 	$this->Survey_model->get_navgnequipments();
    $data['navgnequipments']	   =	$navgnequipments;

    $pollution_controldevice			    = 	$this->Survey_model->get_pollution_controldevice();
    $data['pollution_controldevice']	=	  $pollution_controldevice;
    $sourceofwater				      = 	$this->Survey_model->get_sourceofwater();
    $data['sourceofwater']		  =	  $sourceofwater;

    //------------------Documents----------------//
    $list_document			     = 	$this->Survey_model->get_list_document();
    $data['list_document']	 =	$list_document;

    //-------Payment ---------------//
    $paymenttype				      = 	$this->Survey_model->get_paymenttype();
    $data['paymenttype']		  =	  $paymenttype;

    $bank                     = 	$this->Survey_model->get_bank_favoring();
    $data['bank']			        =	  $bank;

    $portofregistry			      = 	$this->Survey_model->get_portofregistry();
    $data['portofregistry'] 	=	  $portofregistry;
           
    $this->load->view('Kiv_views/template/form-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/Survey/add_form1', $data);
    $this->load->view('Kiv_views/template/form-footer.php');
  }
  else
  {
    redirect('Main_login/index');          
  } 
}
    
function hull_details_form2($vessel_id)
{

  $this->load->model('Kiv_models/Survey_model');
  $data['vessel_id'] = $vessel_id; 
  $hullplating_material           =   $this->Survey_model->get_hullplating_material();
  $data['hullplating_material']   =   $hullplating_material;
  $bulk_head_placement            =   $this->Survey_model->get_bulk_head_placement();
  $data['bulk_head_placement']    =   $bulk_head_placement; 
  $vessel_condition               =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
  $data['vessel_condition']       =   $vessel_condition;
  //print_r($vessel_condition);
  if(!empty($vessel_condition))
  {
    $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
    $vessel_length1=$vessel_condition[0]['vessel_length'];
    $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
    $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
    $form_id=1;
    $heading_id=2;
   
    $this->session->set_userdata(array(
    'vessel_id'     => $vessel_id,
    'vessel_type_id'  =>$vessel_type_id,
    'vessel_subtype_id' =>$vessel_subtype_id,
    'vessel_length'=>$vessel_length1,
    'engine_placement_id'=>$engine_placement_id,
    'hullmaterial_id'=>$hullmaterial_id)); 
    $label_control_details      =   $this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length1,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id);
    $data['label_control_details'] = $label_control_details;
  }
  $data           =   $data + $this->data;    
  $this->load->view('Kiv_views/Ajax_hull_show.php', $data);
}

function engine_details_form3($vessel_id)
{
  $this->load->model('Kiv_models/Survey_model');
  $data['vessel_id'] = $vessel_id; 
  $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
  $data['vessel_condition'] = $vessel_condition;
  //print_r($vessel_condition);
  if(!empty($vessel_condition))
  {
    $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
    $vessel_length1=$vessel_condition[0]['vessel_length'];
    $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
    $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
    // load ajax page      
    $form_id=1;
    $heading_id=3;
    $label_id=23;

    $this->session->set_userdata(array(
    'vessel_id'     => $vessel_id,
    'vessel_type_id'  =>$vessel_type_id,
    'vessel_subtype_id' =>$vessel_subtype_id,
    'vessel_length'=>$vessel_length1,
    'engine_placement_id'=>$engine_placement_id,
    'hullmaterial_id'=>$hullmaterial_id)); 
    $field_all_engine = $this->Survey_model->get_label_details($vessel_type_id, $vessel_subtype_id, $vessel_length1, $hullmaterial_id, $engine_placement_id, $form_id, $heading_id, $label_id);

    $data['field_all_engine']  =  $field_all_engine;
    if(!empty($field_all_engine))
    {
      $label_id   = $field_all_engine[0]['label_id'];
      $value_id   = $field_all_engine[0]['value_id'];
      if($label_id==23)
      {
        $no_of_engineset=$value_id;
      }
      else   
      {
        $no_of_engineset="";
      }    
    }      
    else 
    {
      $no_of_engineset="";
    }
    $data['no_of_engineset']=$no_of_engineset;
    $this->load->view("Kiv_views/ajax_post_view_engine",$data);
  }
}


function equipment_details_form4($vessel_id)
{
  $this->load->model('Kiv_models/Survey_model');
  $data['vessel_id'] = $vessel_id; 
  $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
  $data['vessel_condition'] = $vessel_condition;
  //print_r($vessel_condition);
  if(!empty($vessel_condition))
  {
    $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
    $vessel_length1=$vessel_condition[0]['vessel_length'];
    $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
    $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
    // load ajax page      
    $form_id=1;
    $heading_id=4;

    $this->session->set_userdata(array(
    'vessel_id'     => $vessel_id,
    'vessel_type_id'  =>$vessel_type_id,
    'vessel_subtype_id' =>$vessel_subtype_id,
    'vessel_length'=>$vessel_length1,
    'engine_placement_id'=>$engine_placement_id,
    'hullmaterial_id'=>$hullmaterial_id)); 
    $label_control_details      =   $this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length1,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id);
    $data['label_control_details'] = $label_control_details;
    $this->load->view("Kiv_views/Ajax_equipment_show",$data);
  }
}

function fireappliance_details_form5($vessel_id)
{
  $this->load->model('Kiv_models/Survey_model');
  $data['vessel_id'] = $vessel_id; 
  $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
  $data['vessel_condition'] = $vessel_condition;
  //print_r($vessel_condition);
  if(!empty($vessel_condition))
  {
    $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
    $vessel_length1=$vessel_condition[0]['vessel_length'];
    $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
    $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
    // load ajax page      
    $form_id=1;
    $heading_id=5;
    $this->session->set_userdata(array(
    'vessel_id'     => $vessel_id,
    'vessel_type_id'  =>$vessel_type_id,
    'vessel_subtype_id' =>$vessel_subtype_id,
    'vessel_length'=>$vessel_length1,
    'engine_placement_id'=>$engine_placement_id,
    'hullmaterial_id'=>$hullmaterial_id)); 
    $label_control_details      =   $this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length1,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id);
    $data['label_control_details'] = $label_control_details;
    $this->load->view("Kiv_views/Ajax_fireappliance_show",$data);
  }
}

function otherequipment_details_form6($vessel_id)
{
  $this->load->model('Kiv_models/Survey_model');
  $data['vessel_id'] = $vessel_id; 
  $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
  $data['vessel_condition'] = $vessel_condition;
  //print_r($vessel_condition);
  if(!empty($vessel_condition))
  {
    $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
    $vessel_length1=$vessel_condition[0]['vessel_length'];
    $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
    $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
    // load ajax page      
    $form_id=1;
    $heading_id=6;
    $this->session->set_userdata(array(
    'vessel_id'     => $vessel_id,
    'vessel_type_id'  =>$vessel_type_id,
    'vessel_subtype_id' =>$vessel_subtype_id,
    'vessel_length'=>$vessel_length1,
    'engine_placement_id'=>$engine_placement_id,
    'hullmaterial_id'=>$hullmaterial_id)); 
    $label_control_details      =   $this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length1,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id);
    $data['label_control_details'] = $label_control_details;
    $this->load->view("Kiv_views/Ajax_otherequipment_show",$data);
  }
}
function document_details_form7($vessel_id)
{
  $this->load->model('Kiv_models/Survey_model');
  $data['vessel_id'] = $vessel_id; 
  $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
  $data['vessel_condition'] = $vessel_condition;
  //print_r($vessel_condition);
  if(!empty($vessel_condition))
  {
    $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
    $vessel_length1=$vessel_condition[0]['vessel_length'];
    $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
    $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
    // load ajax page      
    $form_id=1;
    $heading_id=7;

    $this->session->set_userdata(array(
    'vessel_id'     => $vessel_id,
    'vessel_type_id'  =>$vessel_type_id,
    'vessel_subtype_id' =>$vessel_subtype_id,
    'vessel_length'=>$vessel_length1,
    'engine_placement_id'=>$engine_placement_id,
    'hullmaterial_id'=>$hullmaterial_id)); 
    $label_control_details      =   $this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length1,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id);
    $data['label_control_details'] = $label_control_details;
    $this->load->view("Kiv_views/Ajax_documents_show",$data);
  }
}
   
public function InitialSurvey()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'InitialSurvey', 'page' => 'InitialSurvey', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $vessel_details			= 	$this->Survey_model->get_vessel_details($sess_usr_id);
    $data['vessel_details']	=	$vessel_details;
    $this->load->view('Kiv_views/template/header.php');
    $this->load->view('Kiv_views/template/header_script_all.php');
    $this->load->view('Kiv_views/template/header_include.php');
    $this->load->view('Kiv_views/Survey/InitialSurvey',$data);
    $this->load->view('Kiv_views/template/copyright.php');
    $this->load->view('Kiv_views/Kiv_views/template/footer_script_all.php');
    $this->load->view('Kiv_views/template/footer_include_all.php');
    $this->load->view('Kiv_views/template/footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  } 
}
/*_________________________________Form 1 Add new vessel ________________________________*/	
public function add_newVessel()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		   =	$this->session->userdata('customer_id');
  $survey_user_id	   =	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'add_newVessel', 'page' => 'add_newVessel', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    //----------- Login Details-----//
    //----------Owner Details--------------//
    $user			        = 	$this->Survey_model->get_user($customer_id);
    $data['user']       	=	$user;

    $agent			       = 	$this->Survey_model->get_agent($customer_id);
    $data['agent']	       =	$agent;

    //-------Vessel Details---------------//
    $vesselcategory         =  $this->Survey_model->get_vesselcategory();
    $data['vesselcategory'] =	  $vesselcategory;

    $vesseltype             = 	$this->Survey_model->get_vesseltype();
    $data['vesseltype']     =	  $vesseltype;

    $month                  = 	$this->Survey_model->get_month();
    $data['month']		      =	  $month;

    //-------Particulars Hull Details---------------//
    $hullmaterial           = 	$this->Survey_model->get_hullmaterial();
    $data['hullmaterial']   =	  $hullmaterial;

    $inboard_outboard			= 	$this->Survey_model->get_inboard_outboard();
    $data['inboard_outboard']	=	$inboard_outboard;

    //-------Particulars Equipment Details---------------//
    $equipment_details            = 	$this->Survey_model->get_equipment_details();
    $data['equipment_details']    =	$equipment_details; 

    $equipment_material           = 	$this->Survey_model->get_equipment_material();
    $data['equipment_material']   =	$equipment_material; 

    $equipment_type	            = 	$this->Survey_model->get_equipment_type();
    $data['equipment_type']	    =	 $equipment_type;

    $chainport_type	            = 	$this->Survey_model->get_chainport_type();
    $data['chainport_type']	    =	 $chainport_type;

    $searchlight_size	            = 	$this->Survey_model->get_searchlight_size();
    $data['searchlight_size']     =	  $searchlight_size;

    $navigation_light	            = 	$this->Survey_model->get_navigation_light();
    $data['navigation_light']     =	  $navigation_light;

    $sound_signals	            = 	$this->Survey_model->get_sound_signals();
    $data['sound_signals']        =	  $sound_signals;

    $rope_material	            = 	$this->Survey_model->get_rope_material();
    $data['rope_material']        =	  $rope_material;

    //-------Particulars of Fire Appliance---------------//
    $firepumptype	                = 	$this->Survey_model->get_firepumptype();
    $data['firepumptype']	        =	  $firepumptype;

    $bilgepumptype	              = 	$this->Survey_model->get_bilgepumptype();
    $data['bilgepumptype']        =	  $bilgepumptype;

    $firepumpsize		              = 	$this->Survey_model->get_firepumpsize();
    $data['firepumpsize']         =	  $firepumpsize;

    $nozzletype	                  = 	$this->Survey_model->get_nozzletype();
    $data['nozzletype']	          =	  $nozzletype;

    $portable_fire_ext	          = 	$this->Survey_model->get_portable_fire_ext();
    $data['portable_fire_ext']	  =	  $portable_fire_ext;

    //-------Particulars of other Equipments---------------//
    $commnequipment				       = 	$this->Survey_model->get_commnequipment();
    $data['commnequipment']      =	$commnequipment;

    $navgnequipments			       = 	$this->Survey_model->get_navgnequipments();
    $data['navgnequipments']	   =	$navgnequipments;

    $pollution_controldevice			    = 	$this->Survey_model->get_pollution_controldevice();
    $data['pollution_controldevice']	=	  $pollution_controldevice;

    $sourceofwater				      = 	$this->Survey_model->get_sourceofwater();
    $data['sourceofwater']		  =	  $sourceofwater;

    //------------------Documents----------------//
    $list_document			     = 	$this->Survey_model->get_list_document();
    $data['list_document']	 =	$list_document;

    //-------Payment ---------------//
    $paymenttype				      = 	$this->Survey_model->get_paymenttype();
    $data['paymenttype']		  =	  $paymenttype;

    $bank                     = 	$this->Survey_model->get_bank_favoring();
    $data['bank']			        =	  $bank;

    $portofregistry			      = 	$this->Survey_model->get_portofregistry();
    $data['portofregistry'] 	=	  $portofregistry;

    $this->load->view('Kiv_views/template/form-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/Survey/add_newVessel', $data);
    $this->load->view('Kiv_views/template/form-footer.php');
  }
  else
  {
    redirect('Kiv_Ctrl/Survey/SurveyHome');        
  } 
}
        
function vessel_subcategory($vessel_category_id)
{
  $this->load->model('Kiv_models/Survey_model');
  $data['vessel_subcategory']	 =	$vessel_category_id; 
  $vessel_subcategory			     = 	$this->Survey_model->get_vessel_subcategory($vessel_category_id);
  $data['vessel_subcategory']	 =	$vessel_subcategory;
  $data 						             = 	$data + $this->data;		
  $this->load->view('Kiv_views/Ajax_vessel_subcategory.php', $data);
}

function vessel_subtype($vessel_type_id)
{
  $this->load->model('Kiv_models/Survey_model');
  $data['vessel_subtype']		=	$vessel_type_id; 
  $vessel_subtype				= 	$this->Survey_model->get_vessel_subtype($vessel_type_id);
  $data['vessel_subtype']     =	$vessel_subtype;
  $data 						= 	$data + $this->data;		
  $this->load->view('Kiv_views/Ajax_vessel_subtype.php', $data);
}
function vessel_subtype_id($vessel_subtype_id)
{
  $this->load->model('Kiv_models/Survey_model');
  $data['vessel_subtype']	=	$vessel_subtype_id; 
  $vessel_subtype			= 	$this->Survey_model->get_vessel_subtypeid_length($vessel_subtype_id);
  $data['vessel_subtype'] =	$vessel_subtype;
  $data 					= 	$data + $this->data;		
  $this->load->view('Kiv_views/Ajax_vessel_subtype_id.php', $data);
}

function vessel_type_id($vessel_type_id)
{
  $this->load->model('Kiv_models/Survey_model');
  $data['vessel_type']	=	$vessel_type_id; 
  $vessel_type			= 	$this->Survey_model->get_vessel_typeid_length($vessel_type_id);
  $data['vessel_type'] =	$vessel_type;
  $data 					= 	$data + $this->data;		
  $this->load->view('Kiv_views/Ajax_vessel_type_id.php', $data);
}

function placeofsurvey_code($placeofsurvey_sl)
{
  $this->load->model('Kiv_models/Survey_model');
  $data['vessel_placeofsurvey_sl']   =  $placeofsurvey_sl; 
  $vessel_placeofsurvey_sl           =  $this->Survey_model->get_placeofsurvey_code($placeofsurvey_sl);
  $data['vessel_placeofsurvey_sl']   =  $vessel_placeofsurvey_sl;
  $data                               =  $data + $this->data;    
  $this->load->view('Kiv_views/Ajax_placeofsurvey_code.php', $data);
}

      
function add_vessel_details()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form1', 'page' => 'form1', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $this->form_validation->set_rules('vessel_name', 'Vessel Name', 'required');
    $this->form_validation->set_rules('vessel_expected_completion', 'Vessel Expected completion', 'required');
    $this->form_validation->set_rules('vessel_category_id', 'Vessel Category', 'required');
    //$this->form_validation->set_rules('vessel_subcategory_id', 'Vessel Sub Category', 'required');
    if ($this->form_validation->run() == FALSE)
    {
      $valErrors	= 	validation_errors();
      echo json_encode(array("val_errors" => $valErrors));
      exit;
    }   
    else  
    {   
    }
    //Reterence number//
    $current_year= date("Y");
    $reference_number_details          =  $this->Survey_model->get_reference_number_details($current_year);
    $data['reference_number_details']   =  $reference_number_details;
    if(!empty($reference_number_details))
    {
      $tb_reference_number=$reference_number_details[0]['reference_number'];
      $splittedString = explode('/', $tb_reference_number);
      $number=$splittedString[0];
      $newref_number=$number+1;
      $year=$splittedString[1];
      $reference_number=$newref_number.'/'.$year;
    }
    else
    {
     $reference_number='1/'.$current_year;
    }
    //End//
    $vessel_name			=	$this->security->xss_clean($this->input->post('vessel_name'));
    $vessel_expected_completion	=	$this->security->xss_clean($this->input->post('vessel_expected_completion'));
    $vessel_category_id        	=	$this->security->xss_clean($this->input->post('vessel_category_id'));
    $vessel_subcategory_id1			=	$this->security->xss_clean($this->input->post('vessel_subcategory_id'));

    if($vessel_subcategory_id1=='')
    {
    	$vessel_subcategory_id=0;
    }
    else
    {
    	$vessel_subcategory_id=$vessel_subcategory_id1;
    }
    $vessel_type_id				      =	$this->security->xss_clean($this->input->post('vessel_type_id'));
    $vessel_subtype_id1				  =	$this->input->post('vessel_subtype_id');
    if($vessel_subtype_id1=='')
    {
    	$vessel_subtype_id=0;
    }
    else
    {
    	$vessel_subtype_id=$vessel_subtype_id1;
    }
    $vessel_length_overall      =	$this->security->xss_clean($this->input->post('vessel_length_overall'));
    $vessel_length					    =	$this->security->xss_clean($this->input->post('vessel_length'));
    $vessel_breadth				      =	$this->security->xss_clean($this->input->post('vessel_breadth'));
    $vessel_depth					      =	$this->security->xss_clean($this->input->post('vessel_depth'));
    $month_id                   = $this->security->xss_clean($this->input->post('month_id'));
   // $vessel_tonnage				 =	round(($vessel_length*$vessel_breadth*$vessel_depth)/2.83);
    $vessel_tonnage				 =	round(($vessel_length_overall*$vessel_breadth*$vessel_depth)/2.83);
    $vessel_upperdeck_length    =	$this->security->xss_clean($this->input->post('vessel_upperdeck_length'));
    $vessel_upperdeck_breadth		=	$this->security->xss_clean($this->input->post('vessel_upperdeck_breadth'));
    $vessel_upperdeck_depth     =	$this->security->xss_clean($this->input->post('vessel_upperdeck_depth'));
    $vessel_no_of_deck          = $this->security->xss_clean($this->input->post('vessel_no_of_deck'));
    $vessel_upperdeck_tonnage		=	round(($vessel_upperdeck_length*$vessel_upperdeck_breadth*$vessel_upperdeck_depth)/2.83);
   // $vessel_upperdeck_tonnage		=	round(($vessel_length_overall*$vessel_upperdeck_breadth*$vessel_upperdeck_depth)/2.83);
    $vessel_total_tonnage 			=   $vessel_tonnage+$vessel_upperdeck_tonnage;   
    $hullmaterial_id= $this->security->xss_clean($this->input->post('hullmaterial_id'));
    $engine_placement_id= $this->security->xss_clean($this->input->post('engine_placement_id'));
    $ip     =	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date 	= 	date('Y-m-d h:i:s', time());
    if($vessel_category_id)
    {
      $vessel_category_id6       =   $this->Survey_model->get_vessel_category_id($vessel_category_id);
      $data['vessel_category_id6']   = $vessel_category_id6;
      $vessel_category_name     = $vessel_category_id6[0]['vesselcategory_name'];
    }
    else
    {
      $vessel_category_name='-';
    }
    if($vessel_subcategory_id1!='')
    {
      $vessel_subcategory_id6      =   $this->Survey_model->get_vessel_subcategory_id($vessel_subcategory_id1);
      $data['vessel_subcategory_id6']  = $vessel_subcategory_id6;
      @$vessel_subcategory_name   = $vessel_subcategory_id6[0]['vessel_subcategory_name'];
    }
    else
    {
      $vessel_subcategory_name='-';
    }
  
    if($vessel_type_id)
    {
      $vessel_type_id6       =   $this->Survey_model->get_vessel_type_id($vessel_type_id);
      $data['vessel_type_id6']   = $vessel_type_id6;
      $vesseltype_name      = $vessel_type_id6[0]['vesseltype_name'];
    }
    else
    {
      $vesseltype_name='-';
    }
    
    if($vessel_subtype_id1!='')
    {
      $vessel_subtype_id6      =   $this->Survey_model->get_vessel_subtype_id($vessel_subtype_id1);
      $data['vessel_subtype_id6']  = $vessel_subtype_id6;
      $vessel_subtype_name    = $vessel_subtype_id6[0]['vessel_subtype_name'];
    }
    else
    {
      $vessel_subtype_name='-';
    }
    $data_vessel_details = array(
    'vessel_user_id'          	=>  $sess_usr_id,
    'vessel_name' 				=>	$vessel_name, 
    'vessel_category_id' 		=> 	$vessel_category_id,
    'vessel_subcategory_id'		=>	$vessel_subcategory_id,
    'vessel_type_id'			=>	$vessel_type_id,
    'vessel_subtype_id'         =>	$vessel_subtype_id,
    'vessel_length_overall'     =>  $vessel_length_overall,
    'vessel_no_of_deck'         =>  $vessel_no_of_deck,
    'vessel_length'             =>	$vessel_length,
    'vessel_breadth'			=>	$vessel_breadth,
    'vessel_depth'				=>	$vessel_depth,
    'month_id'                  =>	$month_id,
    'vessel_expected_completion'=> 	$vessel_expected_completion,
    'vessel_expected_tonnage'   =>	$vessel_tonnage,
    'vessel_upperdeck_length'   =>  $vessel_upperdeck_length,
    'vessel_upperdeck_breadth'  =>  $vessel_upperdeck_breadth,
    'vessel_upperdeck_depth'    =>  $vessel_upperdeck_depth,
    'vessel_upperdeck_tonnage'  =>  $vessel_upperdeck_tonnage,
    'vessel_total_tonnage'      =>  $vessel_total_tonnage,
    'grt'						=>	$vessel_total_tonnage,
    'nrt'           			=>  $vessel_total_tonnage,
    'reference_number'			=>	$reference_number,
   	'vessel_created_user_id'    =>  $sess_usr_id,
    'vessel_created_timestamp'  =>	$date,
    'vessel_created_ipaddress'  =>	$ip );
    //}
    //print_r($data_vessel_details);exit;
    $form_id=1;
    $heading_id=2;
    $hullplating_material   		= 	$this->Survey_model->get_hullplating_material();
    $data1['hullplating_material']	=	$hullplating_material;

    $bulk_head_placement 			= 	$this->Survey_model->get_bulk_head_placement();
    $data1['bulk_head_placement']	=	$bulk_head_placement; 

    $length_overthedeck			= 	$this->Survey_model->get_length_overthedeck($vessel_type_id,$vessel_subtype_id,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id);
    $data1['length_overthedeck']	=	$length_overthedeck;
    //  print_r($length_overthedeck);
    if(!empty($length_overthedeck))
    {
      $vessel_length1="";
      foreach ($length_overthedeck as $key ) 
      {
        $length_over_deck1=$key['length_over_deck']; 

        if($vessel_length<=$length_over_deck1)
        {
          $vessel_length1=$length_over_deck1;
        break;
        }
        else
        {
          $vessel_length1=$length_over_deck1;
        }
      }
    }
    else
    {
    	$vessel_length1=0;
    }
    $label_control_details			= 	$this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length1,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id);
    $data1['label_control_details']	=	$label_control_details;
    if(!empty($label_control_details))
    {
      $vessel_res 	=	$this->db->insert('tbl_kiv_vessel_details', $data_vessel_details);
      $vessel_id 		= 	$this->db->insert_id();
      $data_vessel_main = array('vesselmain_vessel_id'=>$vessel_id,
      'vesselmain_vessel_name'=>$vessel_name,
      'vesselmain_vessel_type'=>$vesseltype_name,
      'vesselmain_vessel_subtype'=>$vessel_subtype_name,
      'vesselmain_vessel_category'=>$vessel_category_name,
      'vesselmain_ref_number'=>$reference_number,
      'vesselmain_owner_id'=>$sess_usr_id,
      'processing_status'=>1);

      $main_result=	$this->db->insert('tb_vessel_main', $data_vessel_main);
      $this->session->set_userdata(array(
      'vessel_id'     => $vessel_id,
      'vessel_type_id'  =>$vessel_type_id,
      'vessel_subtype_id' =>$vessel_subtype_id,
      'vessel_length'=>$vessel_length1,
      'engine_placement_id'=>$engine_placement_id,
      'hullmaterial_id'=>$hullmaterial_id)); 

      $vessel_condition=array(
      'vessel_id'     => $vessel_id,
      'vessel_type_id'  =>$vessel_type_id,
      'vessel_subtype_id' =>$vessel_subtype_id,
      'vessel_length'=>$vessel_length1,
      'engine_placement_id'=>$engine_placement_id,
      'hullmaterial_id'=>$hullmaterial_id); 

      $var_stage=array(
      'vessel_id' 	=>	$vessel_id,  
      'form'      	=> 	1,
      'stage'     	=>  1,
      'stage_count'	=>  1 );

      $user_vessel=array(
      'user_id'     => $sess_usr_id,
      'vessel_id'  =>$vessel_id,
      'status' =>1,
      'created_user_id'=>$sess_usr_id,
      'created_ipaddress'=>$ip,
      'created_datetime'=>$date); 

      $user_vessel_result	=	$this->db->insert('tbl_kiv_user_vessel', $user_vessel); 
      $stage_res	=	$this->db->insert('tbl_kiv_form_stage', $var_stage); 
      $vessel_cdtn_result 	=	$this->db->insert('tbl_kiv_vessel_condition', $vessel_condition);
      $this->load->view('Kiv_views/Ajax_hull_show.php',$data1);
    }
    else
    {
      //echo "no data";
	echo "1";
      //exit;
    }
  }            
}
  
/*_________________________________Form 1 hull details ________________________________*/	
function add_hull_details()
{
  $vessel_id       	=	$this->session->userdata('vessel_id');
  $sess_usr_id      = $this->session->userdata('int_userid');
  $user_type_id     = $this->session->userdata('int_usertype');
  $customer_id	   	=	$this->session->userdata('customer_id');
  $survey_user_id	 	=	$this->session->userdata('survey_user_id');

  $vessel_type_id           = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vessel_subtype_id        = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $vessel_length            = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hullmaterial_id          = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));
  $engine_inboard_outboard  = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard'));// load ajax page      
  $form_id=1;
  $heading_id=3;
  $label_id=23;

  $field_all_engine =	$this->Survey_model->get_label_details($vessel_type_id, $vessel_subtype_id, $vessel_length, $hullmaterial_id, $engine_inboard_outboard, $form_id, $heading_id, $label_id);
  $data['field_all_engine']	 =	$field_all_engine;

  if(!empty($field_all_engine))
  {
    $label_id 	= $field_all_engine[0]['label_id'];
    $value_id 	= $field_all_engine[0]['value_id'];
    if($label_id==23)
    {
      $no_of_engineset=$value_id;
    }
    else   
    {
      $no_of_engineset="";
    }    
  }      
  else 
  {
    $no_of_engineset="";
  }
  /*$data['no_of_engineset']=$no_of_engineset;
  $this->load->view("Kiv_views/ajax_post_view_engine.php",$data);*/
  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');          
    $form_stage_sl		= 	$this->Survey_model->get_form_stage_sl($vessel_id);
    $data['form_stage_sl']	=	$form_stage_sl;

    if(!empty($form_stage_sl))
    {
      $stage_sl=$form_stage_sl[0]['stage_sl'];
    }
    //print_r($form_stage_sl);
             
    $freeboard_status_id 	=	$this->security->xss_clean($this->input->post('freeboard_status_id'));
    $hull_name			=	$this->security->xss_clean($this->input->post('hull_name'));
    $hull_address		=	$this->security->xss_clean($this->input->post('hull_address'));
    $hull_thickness		=	$this->security->xss_clean($this->input->post('hull_thickness'));
    //$hullmaterial_id          = $this->security->xss_clean($this->input->post('hullmaterial_id'));
    $hullmaterial_id    =	$this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));
    $bulk_heads		=	$this->security->xss_clean($this->input->post('bulk_heads'));
    $bulk_head_placement  =	$this->security->xss_clean($this->input->post('bulk_head_placement'));
    $bulk_head_thickness =	$this->security->xss_clean($this->input->post('bulk_head_thickness'));
    $hullplating_material_id1 =	$this->security->xss_clean($this->input->post('hullplating_material_id'));
    $hull_plating_material_thickness =	$this->security->xss_clean($this->input->post('hull_thickness'));
    $yard_accreditation_number =	$this->security->xss_clean($this->input->post('yard_accreditation_number'));
    $yard_accreditation_expiry_date_input =	$this->security->xss_clean($this->input->post('yard_accreditation_expiry_date'));

    $yard_accreditation_expiry_date = date("Y-m-d", strtotime($yard_accreditation_expiry_date_input));
    $height_of_freeboard =  $this->security->xss_clean($this->input->post('height_of_freeboard'));

    $ip=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date 			= 	date('Y-m-d h:i:s', time());

    if($hullmaterial_id==2)
    {
      $hullplating_material_id=0;
    }
    else 
    {
     $hullplating_material_id=$hullplating_material_id1;
    }
    if($bulk_heads>0)
    {
      //Bulk Head Placement		
      $data_bulkhead = array();

      for($i=0;$i<$bulk_heads;$i++)
      {
        $data_bulkhead []	= 	array(
        'vessel_id' 					=>	$vessel_id,  
        'bulk_head_placement' 			=> 	$bulk_head_placement[$i],
        'bulk_head_thickness' 			=> 	$bulk_head_thickness[$i],
        'bulk_head_created_user_id'		=>	$sess_usr_id,
        'bulk_head_created_timestamp'	=>	$date,
        'bulk_head_created_ipaddress'	=>	$ip);
      }
      $data = $this->security->xss_clean($data);
      $res_bulkhead		=	$this->db->insert_batch('tbl_kiv_hull_bulkhead_details', $data_bulkhead);
    }
    $data_hull = array(
    'vessel_id'							=>  $vessel_id,
    'hull_name' 						=>  $hull_name,  
    'hull_address'             			=>  $hull_address,
    'hull_thickness' 					=>  $hull_thickness,
    'hullmaterial_id'					=>  $hullmaterial_id,
    'freeboard_status_id'       		=>  $freeboard_status_id,
    'bulk_heads'         				=>  $bulk_heads,
    'yard_accreditation_number'			=>  $yard_accreditation_number,
    'yard_accreditation_expiry_date' 	=>	$yard_accreditation_expiry_date,
    'hullplating_material_id'			=>  $hullplating_material_id,
    'hull_plating_material_thickness' =>  $hull_plating_material_thickness,
    'height_of_freeboard'	      =>	$height_of_freeboard,
    'hull_created_user_id'     			=>  $sess_usr_id,
    'hull_created_timestamp'    		=>  $date,
    'hull_created_ipaddress'    		=>  $ip );
    //$hull_res=$this->db->insert('tbl_kiv_hulldetails', $data_hull);	
    if($hull_name!="" || $hull_address!="")
    {	
      $hull_res=	$this->Survey_model->insert_hull($data_hull);
      $data_stage = 	array(
      'stage' => 2,
      'stage_count'=>2);
      $updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
      if($hull_res && $updstatus_res)
      {
        $data['no_of_engineset']=$no_of_engineset;
        $this->load->view("Kiv_views/ajax_post_view_engine",$data);
      }
      else
      {
        $this->load->view("Kiv_views/Survey/add_newVessel");
      }
    }    
    else
    {
      $this->load->view("Kiv_views/Survey/add_newVessel");
    }          
  }
}
function no_of_engineset($number)
{            
  $this->load->model('Kiv_models/Survey_model');
  $vessel_type_id           =	$this->session->userdata('vessel_type_id');
  $vessel_subtype_id        =	$this->session->userdata('vessel_subtype_id');
  $vessel_length            = $this->session->userdata('vessel_length');
  $hullmaterial_id          = $this->session->userdata('hullmaterial_id');
  $engine_inboard_outboard  = $this->session->userdata('engine_placement_id');
  $form_id=1;
  $heading_id=3;
  $label_control_details      =   $this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_id);
  $data['label_control_details'] = $label_control_details;
  //print_r($label_control_details);
   $data['number']=$number;
  $this->load->view('Kiv_views/Ajax_no_of_engineset',$data);            
}
/*_________________________________Form 1 engine details ____________________________*/	

function add_engine_details()
{
  $vessel_id		=	$this->session->userdata('vessel_id');
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');
  $engine_inboard_outboard  = $this->session->userdata('engine_placement_id');
  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form3', 'page' => 'form3', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $form_stage_sl		= 	$this->Survey_model->get_form_stage_sl($vessel_id);
    $data['form_stage_sl']	=	$form_stage_sl;
    if(!empty($form_stage_sl))
    {
      $stage_sl=$form_stage_sl[0]['stage_sl'];
    }
    $no_of_engineset      =	$this->security->xss_clean($this->input->post('no_of_engineset'));
    $engine_number        =	$this->security->xss_clean($this->input->post('engine_number'));
    // $engine_placement_id  =	$this->input->post('engine_placement_id');
    $engine_placement_id =	$engine_inboard_outboard;
    $bhp                  =	$this->security->xss_clean($this->input->post('bhp'));
    $manufacturer_name    =	$this->security->xss_clean($this->input->post('manufacturer_name'));
    $manufacturer_brand   =	$this->security->xss_clean($this->input->post('manufacturer_name'));
    $engine_model_id      =	$this->security->xss_clean($this->input->post('engine_model_id'));
    $engine_type_id       =	$this->security->xss_clean($this->input->post('engine_type_id'));
    $propulsion_diameter  =	$this->security->xss_clean($this->input->post('propulsion_diameter'));
    $propulsion_material_id  =	$this->security->xss_clean($this->input->post('propulsion_material_id'));
    $gear_type_id         =	$this->security->xss_clean($this->input->post('gear_type_id'));
    $gear_number          =	$this->security->xss_clean($this->input->post('gear_number'));
    $model_number         = $this->security->xss_clean($this->input->post('model_number'));
    $bhp_kw=	$this->security->xss_clean($this->input->post('bhp_kw'));
    $ip=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date 			= 	date('Y-m-d h:i:s', time());
    $data=array();
    for($i=0;$i<$no_of_engineset;$i++)
    {
      $data[]= 	array(
      'vessel_id' =>$vessel_id,
      'engine_number'=>$engine_number[$i],
      'engine_placement_id' 	=> $engine_placement_id,  
      'bhp'                   => $bhp[$i],
      'bhp_kw'                => $bhp_kw[$i],            
      'manufacturer_name' 	=> $manufacturer_name[$i],
      'manufacturer_brand'	=> $manufacturer_brand[$i],
      'engine_model_id'	=>$engine_model_id[$i],
      'model_number'      =>$model_number[$i],
      'engine_type_id'	=>	$engine_type_id[$i],
      'propulsion_diameter'=>	$propulsion_diameter[$i],
      'propulsion_material_id'=>	$propulsion_material_id[$i],
      'gear_type_id'		=>	$gear_type_id[$i],
      'gear_number'	=>	$gear_number[$i],
      'engine_created_user_id'=>$sess_usr_id,
      'engine_created_timestamp'=>	$date,
      'engine_created_ipaddress'=>	$ip);
    }
    // print_r($data);
    $result_engine		=	$this->db->insert_batch('tbl_kiv_engine_details', $data);
    $data_stage = 	array(
    'stage' => 3,
    'stage_count'=>3);
    $updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
  }
  $vessel_type_id           =$this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vessel_subtype_id        =$this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $vessel_length            =$this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hullmaterial_id          =$this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));
  $engine_inboard_outboard  =$this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $form_id=1;
  $heading_id=4;
  if($result_engine && $updstatus_res)     
  {
  $label_control_details			= 	$this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_id);
  $data1['label_control_details']	=	$label_control_details;
  $this->load->view('Kiv_views/Ajax_equipment_show.php',$data1);
  }
  else
  {
    $this->load->view("Kiv_views/Survey/add_newVessel");
  }
}
        
/*_________________________________Form 1 equipment details ____________________________*/		
	
function add_equipment_details()
{
  $vessel_id		=	$this->session->userdata('vessel_id');
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form4', 'page' => 'form4', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $form_stage_sl		= 	$this->Survey_model->get_form_stage_sl($vessel_id);
    $data['form_stage_sl']	=	$form_stage_sl;
    //$stage_sl=$form_stage_sl[0]['stage_sl'];
    if(!empty($form_stage_sl))
    {
      $stage_sl=$form_stage_sl[0]['stage_sl'];
    }
    $ip=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date 			= 	date('Y-m-d h:i:s', time());
    for($i=1;$i<=9;$i++)
    {
      $equipment_id                   =   $i;
      $equipment_type_id              =	1;
      $material_id                    =	$this->input->post('material_id'.$i);
      $chainport_type_id              = $this->input->post('chainport_type_id'.$i);
      $size                           =	$this->input->post('size'.$i);
      $number                         =	$this->input->post('number'.$i);
      $length                         =	$this->input->post('length'.$i);
      $power                          =	$this->input->post('power'.$i);
      $capacity                       =	$this->input->post('capacity'.$i);
      $weight                         =	$this->input->post('weight'.$i);
      $equipment_created_user_id      =	$sess_usr_id;
      $equipment_created_timestamp    =	$date;
      $equipment_created_ipaddress    =	$ip;

      $data_insert = array(
      'vessel_id' 	=>	$vessel_id,  
      'equipment_id'      =>      $equipment_id,
      'equipment_type_id'	=> 	$equipment_type_id,
      'chainport_type_id' =>      $chainport_type_id,
      'material_id' 	=> 	$material_id,
      'size'		=>	$size,
      'number'		=>	$number,
      'length'        	=>	$length,
      'power'             =>	$power,
      'capacity'		=>	$capacity,
      'weight'		=>	$weight,
      'equipment_created_user_id'    =>   $sess_usr_id,
      'equipment_created_timestamp'  =>	$date,
      'equipment_created_ipaddress'  =>	$ip);
      // print_r($data_insert);
      $result_insert1=$this->db->insert('tbl_kiv_equipment_details', $data_insert);	 
    }

    $nav_equipment_id=$this->security->xss_clean($this->input->post('nav_equipment_id'));
    $sound_equipment_id=$this->security->xss_clean($this->input->post('sound_equipment_id'));
    foreach($nav_equipment_id as $result1)
    {
      $nav1=array(
      'vessel_id'                     =>	$vessel_id, 
      'equipment_id'                  =>   $result1,
      'equipment_type_id'             =>   2,
      'equipment_created_user_id'     =>  $sess_usr_id,
      'equipment_created_timestamp'   =>	$date,
      'equipment_created_ipaddress'   =>	$ip);
       //print_r($nav1);
      $result_insert2=$this->db->insert('tbl_kiv_equipment_details', $nav1);	
    }
    //if($sound_equipment_id==true){
    foreach($sound_equipment_id as $result2)
    {
      $sound=array(
      'vessel_id' 		=>	$vessel_id, 
      'equipment_id'=>$result2,
      'equipment_type_id'=>3,
      'equipment_created_user_id'    =>      $sess_usr_id,
      'equipment_created_timestamp'  =>	$date,
      'equipment_created_ipaddress'  =>	$ip);
      // print_r($sound);
      $result_insert3=$this->db->insert('tbl_kiv_equipment_details', $sound);	
    }
    //  }
       	
    $data_stage = 	array(
    'stage' => 4,
    'stage_count'=>4);
    $updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);     
  }
  $vessel_type_id           =$this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vessel_subtype_id        =$this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $vessel_length            =$this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hullmaterial_id          =$this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));
  $engine_inboard_outboard  =$this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $form_id=1;
  $heading_id=5;
  if($updstatus_res)  
  {
    $label_control_details     =   $this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_id);
    $data1['label_control_details'] = $label_control_details;
    $this->load->view('Kiv_views/Ajax_fireappliance_show.php',$data1);
  }
  else
  {
    $this->load->view("Kiv_views/Survey/add_newVessel");
  }
}
/*_________________________________Form 1 fire appliance details __________________*/		
function add_fire_appliance()
{
  $vessel_id		=	$this->session->userdata('vessel_id');
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form5', 'page' => 'form5', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');             
    $form_stage_sl		= 	$this->Survey_model->get_form_stage_sl($vessel_id);
    $data['form_stage_sl']	=	$form_stage_sl;
    //$stage_sl=$form_stage_sl[0]['stage_sl'];
    if(!empty($form_stage_sl))
    {
      $stage_sl=$form_stage_sl[0]['stage_sl'];
    }
    $fire_ext_count   =$this->security->xss_clean($this->input->post('fireext_count'));
    $firepump_count=$this->security->xss_clean($this->input->post('firepump_count'));
    $bilgepump_count=$this->security->xss_clean($this->input->post('bilgepump_count'));

    $fire_extinguisher_type_id	=$this->security->xss_clean($this->input->post('fire_extinguisher_type_id'));
    $fire_extinguisher_number 	=$this->security->xss_clean($this->input->post('fire_extinguisher_number'));
    $fire_extinguisher_capacity=$this->security->xss_clean($this->input->post('fire_extinguisher_capacity'));
    $nozzle_type 		             =$this->security->xss_clean($this->input->post('nozzle_type'));
    $ip	=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date 	= 	date('Y-m-d h:i:s', time());
    //Nozzle Type      
    if($nozzle_type==TRUE)
    {
      foreach($nozzle_type as $result_nozzle)
      {
        $nozzle_insert=array(
        'vessel_id' 		=>	$vessel_id, 
        'equipment_id'=>$result_nozzle,
        'equipment_type_id'=>8,
        'equipment_created_user_id'    =>      $sess_usr_id,
        'equipment_created_timestamp'  =>	$date,
        'equipment_created_ipaddress'  =>	$ip  );
        $result_insert=$this->db->insert('tbl_kiv_equipment_details', $nozzle_insert);	
      }  
    }
    //Portable Fire Extinguisher		
    //$data_port_ext = array();
    for($i=0;$i<$fire_ext_count;$i++)
    {
      $data_port_ext 	= 	array(
      'vessel_id' 				=>	$vessel_id,  
      'fire_extinguisher_type_id' 		=> 	$fire_extinguisher_type_id[$i],
      'fire_extinguisher_number' 		=> 	$fire_extinguisher_number[$i],
      'fire_extinguisher_capacity' 		=> 	$fire_extinguisher_capacity[$i],
      'fire_extinguisher_created_user_id'	=>	$sess_usr_id,
      'fire_extinguisher_created_timestamp'	=>	$date,
      'fire_extinguisher_created_ipaddress'	=>	$ip);
      $data = $this->security->xss_clean($data);
      $usr_res=$this->Survey_model->insert_table3('tbl_kiv_fire_extinguisher_details', $data_port_ext); 
    }
    ////Fire Pumps//
    $firepumptype_sl1       =   $this->security->xss_clean($this->input->post('firepumptype_sl1'));  
    $number1 		=   $this->security->xss_clean($this->input->post('number1'));
    $capacity1 		=   $this->security->xss_clean($this->input->post('capacity1'));
    $firepumpsize_id1       =   $this->security->xss_clean($this->input->post('firepumpsize_id1'));
    $equipment_type_id      =   4;
    $equipment_id           =   13;
    //$data_firepump = array();
    for($i=0;$i<$firepump_count;$i++)
    {
      $data_firepump    = 	array(
      'vessel_id'         =>	$vessel_id,
      'equipment_id'      =>  $equipment_id,
      'equipment_type_id' =>  $equipment_type_id,
      'firepumptype_id'   =>  $firepumptype_sl1[$i],
      'number'            => 	$number1[$i],
      'capacity'          => 	$capacity1[$i],
      'firepumpsize_id'   => 	$firepumpsize_id1[$i],
      'firepumps_details_created_user_id'	=>	$sess_usr_id,
      'firepumps_details_created_timestamp'	=>	$date,
      'firepumps_details_created_ipaddress'	=>	$ip );
      //  print_r($data_firepump);
      $data = $this->security->xss_clean($data);
      $firepump_res=$this->Survey_model->insert_table1('tbl_kiv_firepumps_details', $data_firepump);
    }
    //Bilge Pumps           
    $bilgepumptype_sl       =   $this->security->xss_clean($this->input->post('bilgepumptype_sl'));
    $number_bilge           =   $this->security->xss_clean($this->input->post('number_bilge'));
    $capacity_bilge         =   $this->security->xss_clean($this->input->post('capacity_bilge'));
    $firepumpsize_id_bilge  =   $this->security->xss_clean($this->input->post('firepumpsize_id_bilge'));
    $equipment_type_id_bilge      =   4;
    $equipment_id_bilge           =   53;
    // $data_firepump = array();
    for($i=0;$i<$bilgepump_count;$i++)
    {
      $data_bilgepump   = 	array(
      'vessel_id'         =>	$vessel_id,
      'equipment_id'      =>  $equipment_id_bilge,
      'equipment_type_id' =>  $equipment_type_id_bilge,
      'bilgepumptype_id'  =>  $bilgepumptype_sl[$i],
      'number'            => 	$number_bilge[$i],
      'capacity'          => 	$capacity_bilge[$i],
      'firepumpsize_id'   => 	$firepumpsize_id_bilge[$i],
      'bilgepump_details_created_user_id'	=>	$sess_usr_id,
      'bilgepump_details_created_timestamp'	=>	$date,
      'bilgepump_details_created_ipaddress'	=>	$ip);
      $data = $this->security->xss_clean($data);
      $bilgepump_res=$this->Survey_model->insert_table2('tbl_kiv_bilgepump_details', $data_bilgepump);       
    }
    //$bilgepump_res		=	$this->db->insert_batch('tbl_kiv_bilgepump_details', $data_bilgepump);
    /*	
    $number1 		=	$this->input->post('number1');
    $capacity1 		=	$this->input->post('capacity1');
    $size1                  =	$this->input->post('size1');
    $equipment_type_id=4;
    $equipment_id=13;
    $fire_ins=array(
    'vessel_id'                    =>	$vessel_id, 
    'equipment_id'                 =>   $equipment_id,
    'equipment_type_id'            =>   $equipment_type_id,
    'number'                       =>   $number1,
    'capacity'                     =>   $capacity1,
    'size'                         =>   $size1,
    'equipment_created_user_id'    =>   $customer_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip);
    $result_insert=$this->db->insert('tbl_kiv_equipment_details', $fire_ins); */
    ////Fire Mains//
    $material_id1 		=	$this->security->xss_clean($this->input->post('material_id1'));
    $diameter1 		=	$this->security->xss_clean($this->input->post('diameter1'));
    $equipment_type_id=4;
    $equipment_id=14;
    $firemain_ins=array(
    'vessel_id'                    =>	$vessel_id, 
    'equipment_id'                 =>   $equipment_id,
    'equipment_type_id'            =>   $equipment_type_id,
    'material_id'                  =>   $material_id1,
    'diameter'                     =>   $diameter1,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip);
   //print_r($firemain_ins);

    if(!empty($firemain_ins))
    {
      $result_insert=$this->db->insert('tbl_kiv_equipment_details', $firemain_ins);
    }
    //$result_insert=$this->Survey_model->insert_equipment('tbl_kiv_equipment_details', $firemain_ins);                  
    ////Hydrants//
    $number2 		=	$this->security->xss_clean($this->input->post('number2'));
    $equipment_type_id=4;
    $equipment_id=15;
    $hydrants_ins=array(
    'vessel_id'                    =>	$vessel_id, 
    'equipment_id'                 =>   $equipment_id,
    'equipment_type_id'            =>   $equipment_type_id,
    'number'                 	   =>   $number2,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip);
    $result_insert=$this->db->insert('tbl_kiv_equipment_details', $hydrants_ins);             
    ////Hose//

    $number3 		=	$this->security->xss_clean($this->input->post('number3'));
    $equipment_type_id=4;
    $equipment_id=16;
    $hose_ins=array(
    'vessel_id'                    =>	$vessel_id, 
    'equipment_id'                 =>   $equipment_id,
    'equipment_type_id'            =>   $equipment_type_id,
    'number'                  =>   $number3,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip );
    $result_insert=$this->db->insert('tbl_kiv_equipment_details', $hose_ins);              
    $data_stage = 	array(
    'stage' => 5,
    'stage_count'=>5);
    $updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);	
  }
  $vessel_type_id           = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vessel_subtype_id        = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $vessel_length            = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hullmaterial_id          = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));         
  $engine_inboard_outboard  = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard'));
  $form_id=1;
  $heading_id=6;
  if($updstatus_res)    
  {
    $label_control_details     =   $this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_id);
    $data1['label_control_details'] = $label_control_details;
    $this->load->view('Kiv_views/Ajax_otherequipment_show.php',$data1);                 
  }                 
  else
  {
    $this->load->view("Kiv_views/Survey/add_newVessel");
  }     
}

/*_________________________________Form 1 other equipment___________________________*/		
function add_other_equipments()
{
  $vessel_id		=	$this->session->userdata('vessel_id');
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form6', 'page' => 'form6', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');                
    $form_stage_sl		= 	$this->Survey_model->get_form_stage_sl($vessel_id);
    $data['form_stage_sl']	=	$form_stage_sl;
    //$stage_sl=$form_stage_sl[0]['stage_sl'];
    if(!empty($form_stage_sl))
    {
      $stage_sl=$form_stage_sl[0]['stage_sl'];
    }
    $ip	=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date 	= 	date('Y-m-d h:i:s', time());

    $sewage_treatment   =   $this->security->xss_clean($this->input->post('sewage_treatment'));
    $solid_waste        =   $this->security->xss_clean($this->input->post('solid_waste'));
    $sound_pollution    =   $this->security->xss_clean($this->input->post('sound_pollution'));
    $water_consumption  =   $this->security->xss_clean($this->input->post('water_consumption'));
    $source_of_water    =   $this->security->xss_clean($this->input->post('source_of_water'));

    $fire_alarm         =   $this->security->xss_clean($this->input->post('fire_alarm'));
    $engine_room        =   $this->security->xss_clean($this->input->post('engine_room'));
    $flashback_arrestor =   $this->security->xss_clean($this->input->post('flashback_arrestor'));
    $cylinder           =   $this->security->xss_clean($this->input->post('cylinder'));
    $gally              =   $this->security->xss_clean($this->input->post('gally'));
    $hand_rail          =   $this->security->xss_clean($this->input->post('hand_rail')); 
            
    $data_update_vessel = 	array(
    'sewage_treatment'      => $sewage_treatment,
    'solid_waste'           =>$solid_waste,
    'sound_pollution'       =>$sound_pollution,
    'water_consumption'     =>$water_consumption,
    'source_of_water'       =>$source_of_water,
    'fire_alarm'            =>$fire_alarm,
    'engine_room'           =>$engine_room,
    'flashback_arrestor'    =>$flashback_arrestor,
    'cylinder'              =>$cylinder,
    'gally'                 =>$gally,
    'hand_rail'             =>$hand_rail);
    $updstatus_res		=	$this->Survey_model->update_vessel_other_equipment($data_update_vessel,$vessel_id);	
    $list1=$this->security->xss_clean($this->input->post('list1')); //commn euipment
    $list2=$this->security->xss_clean($this->input->post('list2')); //navn equipment
    $list3=$this->security->xss_clean($this->input->post('list3')); //Pollution control equipment  
                   
    foreach($list1 as $result1)
    {
      $list1_insert=array(
      'vessel_id' 		                =>	$vessel_id, 
      'equipment_id'                 =>$result1,
      'equipment_type_id'            =>5,
      'equipment_created_user_id'    => $sess_usr_id,
      'equipment_created_timestamp'  =>	$date,
      'equipment_created_ipaddress'  =>	$ip);
      $result_insert=$this->db->insert('tbl_kiv_equipment_details', $list1_insert);	
    } 


    foreach($list2 as $result2)
    {
      $list2_insert=array(
      'vessel_id' 		              =>	$vessel_id, 
      'equipment_id'                =>  $result2,
      'equipment_type_id'           =>  6,
      'equipment_created_user_id'    =>   $sess_usr_id,
      'equipment_created_timestamp'  =>	  $date,
      'equipment_created_ipaddress'  =>	  $ip );
      $result_insert=$this->db->insert('tbl_kiv_equipment_details', $list2_insert);	
    } 

    foreach($list3 as $result3)
    {
      $list3_insert=array(
      'vessel_id' 		=>	$vessel_id, 
      'equipment_id'=>$result3,
      'equipment_type_id'=>7,
      'equipment_created_user_id'    =>   $sess_usr_id,
      'equipment_created_timestamp'  =>	$date,
      'equipment_created_ipaddress'  =>	$ip);
      $result_insert=$this->db->insert('tbl_kiv_equipment_details', $list3_insert);	
    } 

    $data_stage = 	array(
    'stage' => 6,
    'stage_count'=>6);
    $updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);	
    $vessel_type_id           = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
    $vessel_subtype_id        = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
    $vessel_length            = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
    $hullmaterial_id          = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));         
    $engine_inboard_outboard  = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard'));
    $form_id=1;
    $heading_id=7;
    if($updstatus_res)   
    {
      $label_control_details  =   $this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_id);
      $data1['label_control_details'] = $label_control_details;
      $this->load->view('Kiv_views/Ajax_documents_show.php',$data1);   
    }
    else
    {
      $this->load->view("Kiv_views/Survey/add_newVessel");
    }              
  }

}
/*_________________________________Form 1 documents details ____________________________*/		
function add_vessel_documents()
{
  $vessel_id		=	$this->session->userdata('vessel_id');
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {	
    $data 			=	array('title' => 'form7', 'page' => 'form7', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  
      
    $form_stage_sl			= 	$this->Survey_model->get_form_stage_sl($vessel_id);
    $data['form_stage_sl']	=	$form_stage_sl;
    if(!empty($form_stage_sl))
    {
      $stage_sl=$form_stage_sl[0]['stage_sl'];
    }
    //$stage_sl 				=	$form_stage_sl[0]['stage_sl'];
    $document_type_id		=	1;
    $document_id 			=	$this->security->xss_clean($this->input->post('document_id'));
    $cntcount 			=	$this->security->xss_clean($this->input->post('cntcount'));
    $ip	=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date 	= 	date('Y-m-d h:i:s', time());
    //$random_number=rand('1,2,3,4,5,6,7,8,9,0');
    $random_number=rand(1,9);
    for($j=1; $j<=9 ;$j++)     
    {
      //if(($_FILES['myFile'.$j]['name'][0])==true)
      if(($_FILES['myFile'.$j]['name'])==true)
      {
        $form_id='1';
        $document_id=$j;
        $path_parts = pathinfo($_FILES['myFile'.$j]['name']);
        $extension  = $path_parts['extension'];
        //vessel_id/form_id/document_id/randomnumber.pdf
        if($j==true)
        {
          $document_name=$vessel_id.'_'.$document_id.'_'.$form_id.'_'.$random_number.'.'.$extension;
          copy($_FILES["myFile".$j]["tmp_name"][0], "./uploads/survey/".$document_id."/".$document_name);
          $data_document =	array(
          'vessel_id'						=>	$vessel_id,
          'document_id'					=>	$j,
          'document_type_id'				=>	1,
          'document_name'					=>	$document_name,
          'document_status_id'			=>	1,
          'fileupload_created_user_id'	=>	$sess_usr_id,
          'fileupload_created_timestamp'	=>	$date,
          'fileupload_created_ipaddress'	=>	$ip);
          $res_doc=$this->Survey_model->insert_doc('tbl_kiv_fileupload_details', $data_document);
        }
      }
    }
    /*$vessel_pref_inspection_date2=$this->security->xss_clean($this->input->post('vessel_pref_inspection_date'));
    $vessel_pref_inspection_date1 = str_replace('/', '-', $vessel_pref_inspection_date2);
    $newDate = date("Y-m-d", strtotime($vessel_pref_inspection_date1));
    $data_update=array('vessel_pref_inspection_date'=>$newDate);
    $update_vessel=	$this->Survey_model->update_vessel_pref_inspection_date($data_update,$vessel_id);*/
    $data_stage = 	array(
    'stage' => 7,
    'stage_count'=>7);
    $updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
  }
}

function showpayment()
{
  $vessel_sl		=	$this->session->userdata('vessel_id');
  if($vessel_sl=="")
  {
    $vessel_id     = $this->security->xss_clean($this->input->post('vessel_id'));
  }
  else
  {
    $vessel_id     =$vessel_sl;
  }

  // echo $vessel_id;
  /* $vessel_type_id           = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vessel_subtype_id        = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));*/

  $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
  $data['vessel_condition'] = $vessel_condition;
  //print_r($vessel_condition);
  if(!empty($vessel_condition))
  {
    $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
    $vessel_length1=$vessel_condition[0]['vessel_length'];
    $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
    $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
  }
  $form_id=1;
  $activity_id=1;
  $tariff_details     		  =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
  $data1['tariff_details'] 	= 	$tariff_details;
  $tonnage_details         =   $this->Survey_model->get_tonnage_details($vessel_id);
  $data1['tonnage_details']  =   $tonnage_details;
  if(!empty($tonnage_details))
  {
    @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
  }
  if(!empty($tariff_details))
  {
    foreach ($tariff_details as $key ) 
    {
      $tariff_tonnagetype_id  = $key['tariff_tonnagetype_id'];
      if($tariff_tonnagetype_id==1)
      {
        $tariff_amount=$key['tariff_amount'];
      }
      elseif($tariff_tonnagetype_id==2)
      {
        $tariff_details_typeid2           =   $this->Survey_model->get_tariff_details_typeid2($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
        $data1['tariff_details_typeid2']  =   $tariff_details_typeid2;
        if(!empty($tariff_details_typeid2))
        {
          @$tariff_amount   = (($tariff_details_typeid2[0]['tariff_amount'])*$vessel_total_tonnage);
        }
      }
      elseif($tariff_tonnagetype_id==3)
      {
        $tariff_details_typeid3           =   $this->Survey_model->get_tariff_details_typeid3($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
        $data1['tariff_details_typeid3']  =   $tariff_details_typeid3;
        if(!empty($tariff_details_typeid2))
        {
          @$tariff_amount                   = $tariff_details_typeid3[0]['tariff_amount'];
        }
        //@$tariff_amount                   = $tariff_details_typeid3[0]['tariff_amount'];
      }
      else
      {
        @$tariff_amount= 0;
      }
    }
  }
  if($tariff_amount!=0)
  {
    $data1['tariff_amount']=$tariff_amount;
  }
  else
  {
    $data1['tariff_amount']=0;
  }
  $this->load->view('Kiv_views/Ajax_payment_show.php',$data1);
}
/*_________________________________Form 1 payment details ____________________________*/	  
function add_payment_details()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   =	$this->session->userdata('customer_id');
  $survey_user_id	   =	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form8', 'page' => 'form8', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $vessel_sl    = $this->session->userdata('vessel_id');
    if($vessel_sl=="")
    {
      $vessel_id     = $this->security->xss_clean($this->input->post('vessel_id'));
    }
    else
    {
      $vessel_id     =$vessel_sl;
    }
    //$vessel_id     = $this->security->xss_clean($this->input->post('vessel_id'));
    $form_stage_sl		    = 	$this->Survey_model->get_form_stage_sl($vessel_id);
    $data['form_stage_sl']	=	$form_stage_sl;
    //$stage_sl               = 	$form_stage_sl[0]['stage_sl'];
    if(!empty($form_stage_sl))
    {
      $stage_sl               = 	$form_stage_sl[0]['stage_sl'];
    }
    $survey_id=1;
    //_______________________________START ONLINE TRANSACTION__________________________________//
    /*_____________________Start Get vessel condition_______________ */   
    $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition'] = $vessel_condition;
    if(!empty($vessel_condition))
    {
      $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1=$vessel_condition[0]['vessel_length'];
      $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
    }  
    /*_____________________End Get vessel condition___________________*/
    /*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
    $form_id=1;
    $activity_id=1;
    $tariff_details  =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data1['tariff_details'] =   $tariff_details;
    $tonnage_details         =   $this->Survey_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']  =   $tonnage_details;

    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
    }

    if(!empty($tariff_details))
    {
      foreach ($tariff_details as $key ) 
      {
        $tariff_tonnagetype_id  = $key['tariff_tonnagetype_id'];
        if($tariff_tonnagetype_id==1)
        {
          $tariff_amount=$key['tariff_amount'];
        }
        elseif($tariff_tonnagetype_id==2)
        {
          $tariff_details_typeid2           =   $this->Survey_model->get_tariff_details_typeid2($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
          $data1['tariff_details_typeid2']  =   $tariff_details_typeid2;
          if(!empty($tariff_details_typeid2))
          {
            @$tariff_amount      = (($tariff_details_typeid2[0]['tariff_amount'])*$vessel_total_tonnage);
          }
        }
        elseif($tariff_tonnagetype_id==3)
        {
          $tariff_details_typeid3           =   $this->Survey_model->get_tariff_details_typeid3($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
          $data1['tariff_details_typeid3']  =   $tariff_details_typeid3;
          if(!empty($tariff_details_typeid2))
          {
            @$tariff_amount                   = $tariff_details_typeid3[0]['tariff_amount'];
          }
        }
        else
        {
          @$tariff_amount= 0;
        }
      }
    }
    /*_______________________________________________END Tariff____________________________ */   
    /*___________________________________________________________________________ */   

    //$dd_amount1           = $this->security->xss_clean($this->input->post('dd_amount'));
    $portofregistry_sl    = $this->security->xss_clean($this->input->post('portofregistry_sl'));
    $bank_sl              = $this->security->xss_clean($this->input->post('bank_sl'));
    $status=1;
    $payment_user=  $this->Survey_model->get_payment_userdetails($sess_usr_id);
    $data['payment_user']     =   $payment_user;
    //print_r($payment_user);exit;
    if(!empty($payment_user))
    {
      $owner_name=$payment_user[0]['user_name'];
      $user_mobile_number=$payment_user[0]['user_mobile_number'];
      $user_email=$payment_user[0]['user_email'];
    }
    $formnumber=1;
    $survey_id=1;
    date_default_timezone_set("Asia/Kolkata");
    $ip         = $_SERVER['REMOTE_ADDR'];
    $date       =   date('Y-m-d h:i:s', time());
    $newDate    =   date("Y-m-d");
    $status_change_date=$date;
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
      $process_id=1;
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
      $ref_number                   = "INS"."_".$value."_".$vessel_id.$yr;
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
        //echo "hii"; exit;
        $bank_transaction_id   =    $this->db->insert_id();
        $update_bank       =    $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);
        $online_payment_data  =   $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
        $data['online_payment_data']= $online_payment_data;
        $payment_user1          =  $this->Survey_model->get_payment_userdetails($sess_usr_id);
        $data['payment_user1']     =  $payment_user1;
        $requested_transaction_details=  $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
        $data['requested_transaction_details']  =   $requested_transaction_details;
        //$data['amount_tobe_pay']=$tariff_amount; //remove comment before uploaded to server
        $data['amount_tobe_pay']=1;
        $data      =  $data+ $this->data;
        if(!empty($online_payment_data))
        { //print_r($online_payment_data);exit;
          $this->load->view('Kiv_views/Hdfc/hdfc_onlinepayment_request',$data);
          //echo "1";
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
      redirect('Kiv_Ctrl/Survey/SurveyHome');
    }
    //______________________________________END ONLINE TRANSACTION__________________________________//
  }
}
     
/*_________________________________Form 1 pay later ____________________________*/	
function not_payment_details()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   =	$this->session->userdata('customer_id');
  $survey_user_id	 =	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form8', 'page' => 'form8', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $vessel_id     = $this->security->xss_clean($this->input->post('vessel_id'));

    $form_stage_sl		    = 	$this->Survey_model->get_form_stage_sl($vessel_id);
    $data['form_stage_sl']	=	$form_stage_sl;
    if(!empty($form_stage_sl))
    {
      $stage_sl               = 	$form_stage_sl[0]['stage_sl'];
    }
    $survey_id=1;
    $date               = 	date('Y-m-d h:i:s', time());
    $ip	      			=	$_SERVER['REMOTE_ADDR'];
    $status_change_date =	$date;
    $data_stage = 	array(
    'stage' => 9,
    'stage_count'=>9);
    $data_process=array(
    'vessel_id' => $vessel_id, 
    'process_id'=>1,
    'survey_id'=>1,
    'current_status_id'=>8,
    'current_position'=>$user_type_id,
    'user_id'=>$sess_usr_id,
    'status'=>1,
    'status_change_date'=>$date);
    $data_status = array('vessel_id' => $vessel_id,
    'process_id' => 1,
    'survey_id' => 1,
    'current_status_id' => 8,
    'sending_user_id' => $sess_usr_id,
    'receiving_user_id' => $sess_usr_id);
    $updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
    $insert_process   		=	$this->Survey_model->insert_process_flow($data_process);
    $insert_data_status   	=	$this->Survey_model->insert_status_details('tbl_kiv_status_details',$data_status);
    if($result_insert && $updstatus_res && $insert_process && $insert_data_status && $update_portofregistry)
    {
      $this->SurveyHome();
    }       
  }
}
/*_________________________________Form 1 payment details ____________________________*/	
public function form1_payment()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id  = $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);
  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'form1_payment', 'page' => 'form1_payment', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $form_stage_sl       =   $this->Survey_model->get_form_stage_sl($vessel_id);
    $data['form_stage_sl']  = $form_stage_sl;

    if(!empty($form_stage_sl))
    {
      $stage_sl               = 	$form_stage_sl[0]['stage_sl'];
    }
    $portofregistry             =   $this->Survey_model->get_portofregistry();
    $data['portofregistry']     = $portofregistry;
    $bank                     =   $this->Survey_model->get_bank_favoring();
    $data['bank']             =   $bank;

    $vessel_details1             =   $this->Survey_model->get_vessel_details_edit($vessel_id);
    $data['vessel_details1']     = $vessel_details1;

    if(!empty($vessel_details1))
    {
      $vessel_type_id           = $vessel_details1[0]['vessel_type_id'];
      $vessel_subtype_id        = $vessel_details1[0]['vessel_subtype_id'];
    }
    $form_id=1;
    $activity_id=1;

    $tariff_details           =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data['tariff_details']  =   $tariff_details;
    //print_r($tariff_details);
    $tonnage_details         =   $this->Survey_model->get_tonnage_details($vessel_id);
    $data['tonnage_details']  =   $tonnage_details;
    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
    }

    if(!empty($tariff_details))
    {
      foreach ($tariff_details as $key ) 
      {
        $tariff_tonnagetype_id  = $key['tariff_tonnagetype_id'];
        if($tariff_tonnagetype_id==1)
        {
          $tariff_amount=$key['tariff_amount'];
        }
        elseif($tariff_tonnagetype_id==2)
        {
          $tariff_details_typeid2           =   $this->Survey_model->get_tariff_details_typeid2($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
          $data1['tariff_details_typeid2']  =   $tariff_details_typeid2;
          if(!empty($tariff_details_typeid2))
          {
           @$tariff_amount      = (($tariff_details_typeid2[0]['tariff_amount'])*$vessel_total_tonnage);
          }
        }
        elseif($tariff_tonnagetype_id==3)
        {
          $tariff_details_typeid3           =   $this->Survey_model->get_tariff_details_typeid3($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
          $data1['tariff_details_typeid3']  =   $tariff_details_typeid3;
            //@$tariff_amount                   = $tariff_details_typeid3[0]['tariff_amount'];
          if(!empty($tariff_details_typeid3))
          {
            @$tariff_amount                   = $tariff_details_typeid3[0]['tariff_amount'];
          }
        }
        else
        {
         @$tariff_amount= 0;
        }
      }
    }
    $data['tariff_amount']=$tariff_amount;        
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form1_payment',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}

function pending_payment()
  {
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id  = $this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'pending_payment', 'page' => 'pending_payment', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    //updation
    if($this->input->post())
    {
      $vessel_id            =$this->security->xss_clean($this->input->post('vessel_id'));
      $survey_id    =$this->security->xss_clean($this->input->post('survey_id'));
      $processflow_sl    =$this->security->xss_clean($this->input->post('processflow_sl'));

      $form_stage_sl       =   $this->Survey_model->get_form_stage_sl($vessel_id);
      $data['form_stage_sl']  = $form_stage_sl;
      //$stage_sl               =   $form_stage_sl[0]['stage_sl'];
      if(!empty($form_stage_sl))
      {
        $stage_sl               =   $form_stage_sl[0]['stage_sl'];
      }
      //__________________________________________START ONLINE TRANSACTION__________________________________//

      /*_____________________Start Get vessel condition_______________ */   

      $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
      $data['vessel_condition'] = $vessel_condition;

      if(!empty($vessel_condition))
      {
        $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
        $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
        $vessel_length1=$vessel_condition[0]['vessel_length'];
        $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
        $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
      }  
      /*_____________________End Get vessel condition___________________*/
      /*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
      $form_id=1;
      $activity_id=1;
      $tariff_details  =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
      $data1['tariff_details'] =   $tariff_details;

      $tonnage_details         =   $this->Survey_model->get_tonnage_details($vessel_id);
      $data1['tonnage_details']  =   $tonnage_details;

      if(!empty($tonnage_details))
      {
        @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
      }

      if(!empty($tariff_details))
      {
        foreach ($tariff_details as $key ) 
        {
          $tariff_tonnagetype_id  = $key['tariff_tonnagetype_id'];
          if($tariff_tonnagetype_id==1)
          {
            $tariff_amount=$key['tariff_amount'];
          }
          elseif($tariff_tonnagetype_id==2)
          {
            $tariff_details_typeid2           =   $this->Survey_model->get_tariff_details_typeid2($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
            $data1['tariff_details_typeid2']  =   $tariff_details_typeid2;
            if(!empty($tariff_details_typeid2))
            {
              @$tariff_amount   = (($tariff_details_typeid2[0]['tariff_amount'])*$vessel_total_tonnage);
            }
          }
          elseif($tariff_tonnagetype_id==3)
          {
            $tariff_details_typeid3           =   $this->Survey_model->get_tariff_details_typeid3($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
            $data1['tariff_details_typeid3']  =   $tariff_details_typeid3;
            if(!empty($tariff_details_typeid2))
            {
              @$tariff_amount                   = $tariff_details_typeid3[0]['tariff_amount'];
            }
          }
          else
          {
            @$tariff_amount= 0;
          }
        }
      }
      /*_______________________________________________END Tariff____________________________ */   
      /*___________________________________________________________________________ */   
      //$dd_amount1           = $this->security->xss_clean($this->input->post('dd_amount'));
      $portofregistry_sl    = $this->security->xss_clean($this->input->post('portofregistry_sl'));
      $bank_sl              = $this->security->xss_clean($this->input->post('bank_sl'));
      $status=1;

      $payment_user=  $this->Survey_model->get_payment_userdetails($sess_usr_id);
      $data['payment_user']     =   $payment_user;
      //print_r($payment_user);exit;
      if(!empty($payment_user))
      {
        $owner_name=$payment_user[0]['user_name'];
        $user_mobile_number=$payment_user[0]['user_mobile_number'];
        $user_email=$payment_user[0]['user_email'];
      }
      $formnumber=1;
      $survey_id=1;
      date_default_timezone_set("Asia/Kolkata");
      $ip         = $_SERVER['REMOTE_ADDR'];
      $date       =   date('Y-m-d h:i:s', time());
      $newDate    =   date("Y-m-d");
      $status_change_date=$date;
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
          //echo "hii"; exit;
          $bank_transaction_id     =    $this->db->insert_id();
          $update_bank             =    $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);
          $online_payment_data         =   $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
          $data['online_payment_data']= $online_payment_data;
          $payment_user1              =  $this->Survey_model->get_payment_userdetails($sess_usr_id);
          $data['payment_user1']     =  $payment_user1;
          $requested_transaction_details=  $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
          $data['requested_transaction_details']  =   $requested_transaction_details;
          //$data['amount_tobe_pay']=$tariff_amount;//remove comment before uploaded to server
          $data['amount_tobe_pay']=1;
          $data      =  $data+ $this->data;
          if(!empty($online_payment_data))
          {
            $this->load->view('Kiv_views/Hdfc/hdfc_pending_form1_request',$data);
            //echo "1";
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
        redirect('Kiv_Ctrl/Survey/SurveyHome');
      }
      //____________________________________END ONLINE TRANSACTION__________________________________//
    }
  }
}

public function form3_payment()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id  = $this->session->userdata('survey_user_id');
  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'form3_payment', 'page' => 'form3_payment', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $bank                     =   $this->Survey_model->get_bank_favoring();
    $data['bank']             =   $bank;

    $vessel_details1             =   $this->Survey_model->get_vessel_details_edit($vessel_id);
    $data['vessel_details1']     = $vessel_details1;

    if(!empty($vessel_details1))
    {
      $vessel_type_id           = $vessel_details1[0]['vessel_type_id'];
      $vessel_subtype_id        = $vessel_details1[0]['vessel_subtype_id'];
    }
    $activity_id=1;
    $form_id=3;

    $vessel_details_dynamic=$this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_details_dynamic']	=	$vessel_details_dynamic;
    //print_r($vessel_details_dynamic);

    $vessel_details       		=   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   	= 	$vessel_details;
    //print_r($vessel_details);
    if(!empty($vessel_details))
    {
      $vessel_total_tonnage 		=	$vessel_details[0]['vessel_total_tonnage'];
      $survey_id 					=	$vessel_details[0]['survey_id'];
      $status_change_date1		=	$vessel_details[0]['status_change_date'];
    }

    $status_change_date 		=	date("Y-m-d", strtotime($status_change_date1));
    $now						=	date("Y-m-d");
    $date1_ts    = strtotime($status_change_date);
    $date2_ts    = strtotime($now);
    $diff        = $date2_ts - $date1_ts;
    $numberofdays= round($diff / 86400);
    //$numberofdays=366;

    $tariff_dtls =  $this->Survey_model->get_tariff_dtls($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data['tariff_dtls'] = $tariff_dtls;
    //print_r($tariff_dtls);
    if(!empty($tariff_dtls))
    {
      foreach ($tariff_dtls as $key ) 
      {
        $tariff_tonnagetype_id  = $key['tariff_tonnagetype_id'];
        if($tariff_tonnagetype_id==1)
        {
          @$tariff_amount=$key['tariff_amount'];
        }
        elseif($tariff_tonnagetype_id==2)
        {
        //Code here
        }
        elseif($tariff_tonnagetype_id==3)
        {
          if($numberofdays<365)
          {
            $tariff_form3 =   $this->Survey_model->get_tariff_form3($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage,$numberofdays);
            $data['tariff_form3'] = $tariff_form3;
            @$tariff_amount=$tariff_form3[0]['tariff_amount'];
          }
          else
          {
            $tariff_form3 =   $this->Survey_model->get_tariff_form3_366($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
            $data['tariff_form3'] = $tariff_form3;
            @$tariff_amount=$tariff_form3[0]['tariff_amount'];
          }
        }
        else
        {
          @$tariff_amount= 1;
        }
      }
    }
      /*
      if(!empty($tariff_dtls))
      {
      $tariff_tonnagetype_id=$tariff_dtls[0]['tariff_tonnagetype_id'];
      if($tariff_tonnagetype_id==3)
      {
      if($numberofdays<365)
      {
      $tariff_form3 =   $this->Survey_model->get_tariff_form3($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage,$numberofdays);
      $data['tariff_form3'] = $tariff_form3;
      //print_r($tariff_form3);
      }
      else
      {
      $tariff_form3 =   $this->Survey_model->get_tariff_form3_366($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
      $data['tariff_form3'] = $tariff_form3;
      //print_r($tariff_form3);
      }

      }
      }*/
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form3_payment',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}

function pending_payment_form3()
{

  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id  = $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'pending_payment_form3', 'page' => 'pending_payment_form3', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_id 			    =	$this->security->xss_clean($this->input->post('vessel_id'));	
    $process_id1         = $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id1          = $this->security->xss_clean($this->input->post('survey_id'));
    $processflow_sl     = $this->security->xss_clean($this->input->post('processflow_sl'));

    //__________________________________________START ONLINE TRANSACTION__________________________________//
    /*_____________________Start Get vessel condition_______________ */   

    $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition'] = $vessel_condition;

    if(!empty($vessel_condition))
    {
      $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1=$vessel_condition[0]['vessel_length'];
      $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
    }  
    /*_____________________End Get vessel condition___________________*/

    /*_____________________Start Get Tariff amount form 3 from kiv_tariff)_master table_______________ */ 

    $activity_id=1;
    $form_id=3;
    $vessel_details_dynamic=$this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_details_dynamic'] = $vessel_details_dynamic;
    //print_r($vessel_details_dynamic);
    $vessel_details           =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']     =   $vessel_details;
    //print_r($vessel_details);
    if(!empty($vessel_details))
    {
      $vessel_total_tonnage     = $vessel_details[0]['vessel_total_tonnage'];
      $survey_id                = $vessel_details[0]['survey_id'];
      $status_change_date1      = $vessel_details[0]['status_change_date'];
      $process_id               = $vessel_details[0]['process_id'];
    }
    $status_change_date     = date("Y-m-d", strtotime($status_change_date1));
    $now            = date("Y-m-d");
    $date1_ts    = strtotime($status_change_date);
    $date2_ts    = strtotime($now);
    $diff        = $date2_ts - $date1_ts;
    $numberofdays= round($diff / 86400);
    //$numberofdays=366;
    $tariff_dtls =   $this->Survey_model->get_tariff_dtls($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data['tariff_dtls'] = $tariff_dtls;
    if(!empty($tariff_dtls))
    {
      foreach ($tariff_dtls as $key ) 
      {
        $tariff_tonnagetype_id  = $key['tariff_tonnagetype_id'];
        if($tariff_tonnagetype_id==1)
        {
          @$tariff_amount=$key['tariff_amount'];
        }
        elseif($tariff_tonnagetype_id==2)
        {
          //Code here
        }
        elseif($tariff_tonnagetype_id==3)
        {
          if($numberofdays<365)
          {
            $tariff_form3 =   $this->Survey_model->get_tariff_form3($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage,$numberofdays);
            $data['tariff_form3'] = $tariff_form3;
            @$tariff_amount=$tariff_form3[0]['tariff_amount'];
          }
          else
          {
            $tariff_form3 =   $this->Survey_model->get_tariff_form3_366($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
            $data['tariff_form3'] = $tariff_form3;
            @$tariff_amount=$tariff_form3[0]['tariff_amount'];
          }
        }
        else
        {
          @$tariff_amount= 1;
        }
      }
    }

    if(!empty($tariff_amount))
    {
      $tariff_amount=$tariff_amount;
    }
    else
    {
      $tariff_amount=1;
    }
    /*_______________________________________________END Tariff____________________________ */  

    /*___________________________________________________________________________ */   
    $portofregistry_sl    = $this->security->xss_clean($this->input->post('portofregistry_sl'));
    $bank_sl              = $this->security->xss_clean($this->input->post('bank_sl'));
    $status=1;
    $payment_user=  $this->Survey_model->get_payment_userdetails($sess_usr_id);
    $data['payment_user']     =   $payment_user;
    //rint_r($payment_user);exit;
    if(!empty($payment_user))
    {
      $owner_name=$payment_user[0]['user_name'];
      $user_mobile_number=$payment_user[0]['user_mobile_number'];
      $user_email=$payment_user[0]['user_email'];
    }
    $form_number_cs=  $this->Survey_model->get_form_number_cs($process_id);
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
    $milliseconds = round(microtime(true) * 1000); //Generate unique bank number
    $bank_gen_number         =   $this->Survey_model->get_bank_generated_last_number($bank_sl);
    $data['bank_gen_number']   = $bank_gen_number;

    if(!empty($bank_gen_number))
    {
      $bank_generated_number =  $bank_gen_number[0]['last_generated_no']+1;
      $transaction_id    =  $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds.$bank_generated_number;
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
        //$data['amount_tobe_pay']=$tariff_amount;//remove comment before uploaded to server
        $data['amount_tobe_pay']=1;
        $data      =  $data+ $this->data;
        if(!empty($online_payment_data))
        { 
          $this->load->view('Kiv_views/Hdfc/hdfc_initialsurvey_form3_request',$data);
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
      redirect('Kiv_Ctrl/Survey/SurveyHome');
    }

    /*if(!empty($tariff_dtls))
    {
    $tariff_tonnagetype_id=$tariff_dtls[0]['tariff_tonnagetype_id'];
    if($tariff_tonnagetype_id==3)
    {
    if($numberofdays<365)
    {
    $tariff_form3 =   $this->Survey_model->get_tariff_form3($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage,$numberofdays);
    $data['tariff_form3'] = $tariff_form3;
    }
    else
    {
    $tariff_form3 =   $this->Survey_model->get_tariff_form3_366($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
    $data['tariff_form3'] = $tariff_form3;
    }
    }
    }*/
  }
}

/*_________________________________view vessel__________________________________*/	

public function View_Vessel()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'View_Vessel', 'page' => 'View_Vessel', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');
    $survey_id=1;

    //----------Vessel Details--------//
    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;

    //----------Hull Details--------//
    $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']    = $hull_details;

    //----------Engine Details--------//
    $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']  = $engine_details;

    //----------Equipment Details--------//
    $equipment_details     =   $this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details'] = $equipment_details;

    //--------------Documents-----------------//
    $list_document_vessel        =   $this->Survey_model->get_list_document_vessel($vessel_id,$survey_id);
    $data['list_document_vessel']    = $list_document_vessel;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/View_Vessel',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');	 
  }
}
	
function add_crew($number,$vessel_id)
{            
  $this->load->model('Kiv_models/Survey_model');
  $crew_type=$this->Survey_model->get_crewType();
  $data['crew_type'] =	$crew_type;
  $crew_class=$this->Survey_model->get_crewClass();
  $data['crew_class'] =	$crew_class;
  $data['number']=$number;
  $data['vessel_id']=$vessel_id;
  $this->load->view('Kiv_views/Ajax_crew_addmore',$data);            
}

function add_crew_form5($number,$vessel_id)
{            
  $this->load->model('Kiv_models/Survey_model');
  $crew_type=$this->Survey_model->get_crewType();
  $data['crew_type'] =	$crew_type;
  $crew_class=$this->Survey_model->get_crewClass();
  $data['crew_class'] =	$crew_class;
  $data['number']=$number;
  $data['vessel_id']=$vessel_id;
  $this->load->view('Kiv_views/Ajax_crew_addmore_form5',$data);            
}

function no_of_bulkhead($number)
{            
  $this->load->model('Kiv_models/Survey_model');
  $bulk_head_placement			= 	$this->Survey_model->get_bulk_head_placement();
  $data['bulk_head_placement']		=	$bulk_head_placement; 
  $data['number']=$number;
  $this->load->view('Kiv_views/Ajax_no_of_bulkhead',$data);            
}

function bulk_heads_add()
{            
  $this->load->model('Kiv_models/Survey_model');
  $bulk_head_placement			= 	$this->Survey_model->get_bulk_head_placement();
  $data['bulk_head_placement']		=	$bulk_head_placement; 
  $this->load->view('Kiv_views/Ajax_add_bulkhead',$data);            
}   

function inboard_outboard_add()
{
  $this->load->model('Kiv_models/Survey_model');
  $inboard_outboard		= 	$this->Survey_model->get_inboard_outboard();
  $data['inboard_outboard']	=	$inboard_outboard;
  $this->load->view('Kiv_views/jax_add_inboard_outboard',$data);
}

function model_number_add()
{
  $this->load->model('Kiv_models/Survey_model');
  $model_number		= 	$this->Survey_model->get_model_number();
  $data['model_number']	=	$model_number;
  $this->load->view('Kiv_views/Ajax_add_model_number',$data);
}

function engine_type_add()
{
  $this->load->model('Kiv_models/Survey_model');
  $engine_type		= 	$this->Survey_model->get_engine_type();
  $data['engine_type']	=	$engine_type;
  $this->load->view('Kiv_views/Ajax_add_engine_type',$data);
}
function gear_type_add()
{
  $this->load->model('Kiv_models/Survey_model');
  $gear_type		= 	$this->Survey_model->get_gear_type();
  $data['gear_type']	=	$gear_type;
  $this->load->view('Kiv_views/Ajax_add_gear_type',$data);
}

function propulsionshaft_material_add()
{
  $this->load->model('Kiv_models/Survey_model');
  $propulsionshaft_material		= 	$this->Survey_model->get_propulsionshaft_material();
  $data['propulsionshaft_material']	=	$propulsionshaft_material;
  $this->load->view('Kiv_views/Ajax_add_propulsionshaft_material',$data);
}

public function Edit_Vessel()
{
         /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
         $customer_id	=	$this->session->userdata('customer_id');
         $survey_user_id=	$this->session->userdata('survey_user_id');
         
         $vessel_id=$this->uri->segment(4);
         $stage_count=$this->uri->segment(5);
        
         if(!empty($sess_usr_id))
         {
            $data 			=	 array('title' => 'Edit_Vessel', 'page' => 'Edit_Vessel', 'errorCls' => NULL, 'post' => $this->input->post());
            $data 			=	 $data + $this->data;
            $this->load->model('Kiv_models/Survey_model');
            

            //-------Vessel Details---------------//
            $vessel_details=$this->Survey_model->get_vessel_details_edit($vessel_id);
            $data['vessel_details']=	$vessel_details;
			if(!empty($vessel_details))
			{

			$vessel_category_id=$vessel_details[0]['vessel_category_id'];
			$vessel_type_id=$vessel_details[0]['vessel_type_id'];

			}



            $vesselcategory	   = 	$this->Survey_model->get_vesselcategory();
            $data['vesselcategory']=	$vesselcategory;
           

             $vessel_subcategory	   = 	$this->Survey_model->get_vessel_subcategory($vessel_category_id);
            $data['vessel_subcategory']=	$vessel_subcategory;
           

            $vesseltype		= 	$this->Survey_model->get_vesseltype();
            $data['vesseltype']	=	$vesseltype;

            $vessel_subtype			= 	$this->Survey_model->get_vessel_subtype($vessel_type_id);
			$data['vessel_subtype']	=	$vessel_subtype;

			 $month 				= 	$this->Survey_model->get_month();
    		$data['month']			=	$month;

            //-------Hull Details---------------//
            
			$hull_details=$this->Survey_model->get_hull_details_edit($vessel_id,$survey_id);
                        $data['hull_details']=	$hull_details;

			$hullmaterial		= 	$this->Survey_model->get_hullmaterial();
			$data['hullmaterial']	=	$hullmaterial;
			
			$hullplating_material			= 	$this->Survey_model->get_hullplating_material();
			$data['hullplating_material']		=	$hullplating_material;

			$hull_bulkhead_details			= 	$this->Survey_model->get_hull_bulkhead_details_edit($vessel_id,$survey_id);
			$data['hull_bulkhead_details']		=	$hull_bulkhead_details;
			
  //-------Engine Details---------------//
        $engine_details			= 	$this->Survey_model->get_engine_details_edit($vessel_id,$survey_id);
	$data['engine_details']		=	$engine_details;  
        $engine_details_count			= 	$this->Survey_model->get_engine_details_edit_count($vessel_id,$survey_id);
	$data['engine_details_count']		=	$engine_details_count; 
        
        $inboard_outboard		= 	$this->Survey_model->get_inboard_outboard();
            $data['inboard_outboard']	=	$inboard_outboard;
            
            $model_number		= 	$this->Survey_model->get_model_number();
            $data['model_number']	=	$model_number;
            
            $engine_type		= 	$this->Survey_model->get_engine_type();
            $data['engine_type']	=	$engine_type;
            
            
             $gear_type		= 	$this->Survey_model->get_gear_type();
            $data['gear_type']	=	$gear_type;
            
             $propulsionshaft_material		= 	$this->Survey_model->get_propulsionshaft_material();
            $data['propulsionshaft_material']	=	$propulsionshaft_material;
            
    //-------Equipment Details Details---------------//


    $equipment_material			= 	$this->Survey_model->get_equipment_material();
    $data['equipment_material']		=	$equipment_material; 

    $anchorport_equipment		= 	$this->Survey_model->get_equipment_details_edit($vessel_id,1,$survey_id);
    $data['anchorport_equipment']	=	$anchorport_equipment;

    $anchorstarboard_equipment		= 	$this->Survey_model->get_equipment_details_edit($vessel_id,2,$survey_id);
    $data['anchorstarboard_equipment']	=	$anchorstarboard_equipment;

    $anchorspare_equipment		= 	$this->Survey_model->get_equipment_details_edit($vessel_id,3,$survey_id);
    $data['anchorspare_equipment']	=	$anchorspare_equipment;

    $chainport_equipment		= 	$this->Survey_model->get_equipment_details_edit($vessel_id,4,$survey_id);
    $data['chainport_equipment']	=	$chainport_equipment;

    $chainstarboard_equipment		= 	$this->Survey_model->get_equipment_details_edit($vessel_id,5,$survey_id);
    $data['chainstarboard_equipment']	=	$chainstarboard_equipment;

    $rope_equipment		= 	$this->Survey_model->get_equipment_details_edit($vessel_id,6,$survey_id);
    $data['rope_equipment']	=	$rope_equipment;

    $searchlight_equipment		= 	$this->Survey_model->get_equipment_details_edit($vessel_id,7,$survey_id);
    $data['searchlight_equipment']	=	$searchlight_equipment;

    $lifebuoys_equipment		= 	$this->Survey_model->get_equipment_details_edit($vessel_id,8,$survey_id);
    $data['lifebuoys_equipment']	=	$lifebuoys_equipment; 

    $lifebuoysbuoyant_equipment		= 	$this->Survey_model->get_equipment_details_edit($vessel_id,9,$survey_id);
    $data['lifebuoysbuoyant_equipment']	=	$lifebuoysbuoyant_equipment;


    $navlightparticulars_equipment		= 	$this->Survey_model->get_type_equipment_details_edit($vessel_id,2,$survey_id);
    $data['navlightparticulars_equipment']	=	$navlightparticulars_equipment;

    $soundsignals_equipment		= 	$this->Survey_model->get_type_equipment_details_edit($vessel_id,3,$survey_id);
    $data['soundsignals_equipment']	=	$soundsignals_equipment;


    $chainport_type			= 	$this->Survey_model->get_chainport_type();
    $data['chainport_type']		=	$chainport_type;

    $rope_material			= 	$this->Survey_model->get_rope_material();
    $data['rope_material']		=	$rope_material;

    $searchlight_size			= 	$this->Survey_model->get_searchlight_size();
    $data['searchlight_size']		=	$searchlight_size;

    $navigation_light			= 	$this->Survey_model->get_navigation_light();
    $data['navigation_light']		=	$navigation_light;

    $sound_signals			= 	$this->Survey_model->get_sound_signals();
    $data['sound_signals']		=	$sound_signals;

           
                //-------Fire Appliance Details---------------//
           
           
           
            $firepumptype		= 	$this->Survey_model->get_firepumptype();
            $data['firepumptype']	=	$firepumptype;
            
            $bilgepumptype			= 	$this->Survey_model->get_bilgepumptype();
            $data['bilgepumptype']	=	$bilgepumptype;
            
            

            $firepumpsize		= 	$this->Survey_model->get_firepumpsize();
            $data['firepumpsize']       =	$firepumpsize;

            $nozzletype                 = 	$this->Survey_model->get_nozzletype();
            $data['nozzletype']		=	$nozzletype;

            $portable_fire_ext		= 	$this->Survey_model->get_portable_fire_ext();
            $data['portable_fire_ext']	=	$portable_fire_ext;
                         
            $nozzletype_equipment		= 	$this->Survey_model->get_type_equipment_details_edit($vessel_id,8,$survey_id);
            $data['nozzletype_equipment']	=	$nozzletype_equipment;
            
            $firemains_equipment		= 	$this->Survey_model->get_equipment_details_edit($vessel_id,14,$survey_id);
            $data['firemains_equipment']	=	$firemains_equipment;
            
            $hydrants_equipment         = 	$this->Survey_model->get_equipment_details_edit($vessel_id,15,$survey_id);
            $data['hydrants_equipment']	=	$hydrants_equipment;
            
            $hose_equipment		= 	$this->Survey_model->get_equipment_details_edit($vessel_id,16,$survey_id);
            $data['hose_equipment']	=	$hose_equipment;
                         
            $portable_fire_devices		= 	$this->Survey_model->get_fire_extinguisher_details_edit($vessel_id,$survey_id);
            $data['portable_fire_devices']	=	$portable_fire_devices; 
            
            $firepump_details		= 	$this->Survey_model->get_firepump_details_edit($vessel_id,$survey_id);
            $data['firepump_details']	=	$firepump_details; 
            
            
            
            //-------Other Equipment Details---------------//
            $commnequipment		= 	$this->Survey_model->get_commnequipment();
            $data['commnequipment']     =	$commnequipment;

            $navgnequipments		= 	$this->Survey_model->get_navgnequipments();
            $data['navgnequipments']	=	$navgnequipments;

            $pollution_controldevice	= 	$this->Survey_model->get_pollution_controldevice();
            $data['pollution_controldevice']=	$pollution_controldevice;

            $sourceofwater		= 	$this->Survey_model->get_sourceofwater();
            $data['sourceofwater']	=	$sourceofwater;
            
            
             $get_commnequipment_equipment= 	$this->Survey_model->get_otherequipment_edit($vessel_id,5,$survey_id);
            $data['get_commnequipment_equipment']	=	$get_commnequipment_equipment;
            
            $get_navgnequipments_equipment= 	$this->Survey_model->get_otherequipment_edit($vessel_id,6,$survey_id);
            $data['get_navgnequipments_equipment']	=	$get_navgnequipments_equipment;
             
         $get_pollncntrl_equipment= 	$this->Survey_model->get_otherequipment_edit($vessel_id,7,$survey_id);
            $data['get_pollncntrl_equipment']	=	$get_pollncntrl_equipment;
             
         //------------Document Details--------------------------------//
      

    $list_document_vessel		= 	$this->Survey_model->get_list_document_vessel_edit($vessel_id);
    $data['list_document_vessel']		=	$list_document_vessel;
    
    
     //-------Payment  Details---------------//
    
    $payment_details		= 	$this->Survey_model->get_payment_details_edit($vessel_id,$survey_id);
    $data['payment_details']	=	$payment_details;
			 
    $paymenttype		= 	$this->Survey_model->get_paymenttype();
    $data['paymenttype']	=	$paymenttype;


    $bank                       = 	$this->Survey_model->get_bank_favoring();
    $data['bank']		=	$bank;


    $portofregistry             = 	$this->Survey_model->get_portofregistry();
    $data['portofregistry']     =	$portofregistry;
                         
                         
        
            $this->load->view('Kiv_views/template/header.php');
            $this->load->view('Kiv_views/template/header_script_all.php');
            $this->load->view('Kiv_views/template/header_include.php');

            $this->load->view('Kiv_views/Survey/Edit_Vessel',$data);

            $this->load->view('Kiv_views/template/copyright.php');
            $this->load->view('Kiv_views/template/footer_script_all.php');
            $this->load->view('Kiv_views/template/footer_include_all.php');
            $this->load->view('Kiv_views/template/footer.php');

         }
}
	
 function Edit_vessel_details()
        {
            
       /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
		$customer_id	=	$this->session->userdata('customer_id');
		$survey_user_id	=	$this->session->userdata('survey_user_id');
           if(!empty($sess_usr_id))
		{	
			$data =	array('title' => 'form1', 'page' => 'form1', 'errorCls' => NULL, 'post' => $this->input->post());
			$data = $data + $this->data;
          $this->load->model('Kiv_models/Survey_model');             
$vessel_sl                    =	$this->security->xss_clean($this->input->post('vessel_sl'));
// $stage_cont                =	$this->security->xss_clean($this->input->post('vessel_sl'));
$stage_count                  = $this->security->xss_clean($this->input->post('stage_count'));
$vessel_name                  =	$this->security->xss_clean($this->input->post('vessel_name'));
$vessel_expected_completion		=	$this->security->xss_clean($this->input->post('vessel_expected_completion'));
$vessel_category_id        		=	$this->security->xss_clean($this->input->post('vessel_category_id'));
$vessel_subcategory_id			  =	$this->security->xss_clean($this->input->post('vessel_subcategory_id'));
$vessel_type_id					      =	$this->security->xss_clean($this->input->post('vessel_type_id'));
$vessel_subtype_id				    =	$this->security->xss_clean($this->input->post('vessel_subtype_id'));
$vessel_length_overall        =	$this->security->xss_clean($this->input->post('vessel_length_overall'));
$vessel_length                =	$this->security->xss_clean($this->input->post('vessel_length'));
$vessel_breadth					      =	$this->security->xss_clean($this->input->post('vessel_breadth'));
$vessel_depth					        =	$this->security->xss_clean($this->input->post('vessel_depth'));
$month_id					            =	$this->security->xss_clean($this->input->post('month_id'));
$vessel_tonnage					      =	round(($vessel_length*$vessel_breadth*$vessel_depth)/2.83);
                 
                 
                
                $ip=	$_SERVER['REMOTE_ADDR'];
        date_default_timezone_set("Asia/Kolkata");
        $date 			= 	date('Y-m-d h:i:s', time());

	$data_vessel_details = array(
    'vessel_name' 				=>	$vessel_name,  
    //'vessel_user_id'          =>      $customer_id,
    'vessel_user_id'            =>  $sess_usr_id,
    'vessel_expected_completion'=> 	$vessel_expected_completion,
    'vessel_category_id' 		=> 	$vessel_category_id,
    'vessel_subcategory_id'		=>	$vessel_subcategory_id,
    'vessel_length_overall'     =>  $vessel_length_overall,
    'vessel_type_id'			=>	$vessel_type_id,
    'vessel_subtype_id'         =>	$vessel_subtype_id,
    'vessel_length'             =>	$vessel_length,
    'vessel_breadth'			=>	$vessel_breadth,
    'vessel_depth'				=>	$vessel_depth,
    'month_id'					=>	$month_id,
    'vessel_expected_tonnage'   =>	$vessel_tonnage,
    'vessel_modified_user_id'    => $sess_usr_id,
    'vessel_modified_timestamp'  =>	$date,
    'vessel_modified_ipaddress'  =>	$ip
      );

//print_r($data_vessel_details);
//exit;
	$update_table		=	$this->Survey_model->update_initial_survey_vessel_table('tbl_kiv_vessel_details',$data_vessel_details,$vessel_sl);

        }

}
  
function Edit_hull_details()
{
	  
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
	$customer_id	=	$this->session->userdata('customer_id');
	$survey_user_id	=	$this->session->userdata('survey_user_id');
		
			
          if(!empty($sess_usr_id))
		{	
		$data =	array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');             
        $vessel_id      		=   $this->security->xss_clean($this->input->post('vessel_id'));
        $form_stage_sl			= 	$this->Survey_model->get_form_stage_sl($vessel_id);
        $data['form_stage_sl']	=	$form_stage_sl;
		//$stage_sl 				= 	$form_stage_sl[0]['stage_sl'];
		if(!empty($form_stage_sl))
     {
          $stage_sl=$form_stage_sl[0]['stage_sl'];
     }
        
        
        $stage_count                    = $this->security->xss_clean($this->input->post('stage_count'));
        $hull_sl                        = $this->security->xss_clean($this->input->post('hull_sl'));     
        $freeboard_status_id            = $this->security->xss_clean($this->input->post('freeboard_status_id'));
        $hull_name                      =	$this->security->xss_clean($this->input->post('hull_name'));
        $hull_address                   =	$this->security->xss_clean($this->input->post('hull_address'));
        $hull_thickness                 =	$this->security->xss_clean($this->input->post('hull_thickness'));
        $hullmaterial_id                =	$this->security->xss_clean($this->input->post('hullmaterial_id'));
        $bulk_heads						          =	$this->security->xss_clean($this->input->post('bulk_heads'));
        $bulk_head_placement            =	$this->security->xss_clean($this->input->post('bulk_head_placement'));
        $bulk_head_thickness            =	$this->security->xss_clean($this->input->post('bulk_head_thickness'));
        $hullplating_material_id        =	$this->security->xss_clean($this->input->post('hullplating_material_id'));
        $hull_plating_material_thickness=	$this->security->xss_clean($this->input->post('hull_plating_material_thickness'));
        $yard_accreditation_number      =	$this->security->xss_clean($this->input->post('yard_accreditation_number'));
        $yard_accreditation_expiry_date_input=	$this->security->xss_clean($this->input->post('yard_accreditation_expiry_date'));
        $hull_bulkhead_details_sl       =	$this->security->xss_clean($this->input->post('hull_bulkhead_details_sl'));
        $delete_status                  =	$this->security->xss_clean($this->input->post('delete_status'));
              
	$yard_accreditation_expiry_date = date("Y-m-d", strtotime($yard_accreditation_expiry_date_input));
        $ip=	$_SERVER['REMOTE_ADDR'];
        date_default_timezone_set("Asia/Kolkata");
        $date 			= 	date('Y-m-d h:i:s', time());
		
        
       
        	//Bulk Head Placement	
   
        
	
        for($i=0;$i<$bulk_heads;$i++)
        {
            if($delete_status[$i]==1) // For Delete
            {
                $data_bulkhead_delete 	= 	array(
			
            'bulk_head_modified_user_id'	=>	$sess_usr_id,
			'bulk_head_modified_timestamp'	=>	$date,
			'bulk_head_modified_ipaddress'	=>	$ip,
            'delete_status'                 =>  $delete_status[$i]
			);
              
             $edit_id=$hull_bulkhead_details_sl[$i];
             $data = $this->security->xss_clean($data);
             
             $res_bulkhead_delete=$this->Survey_model->update_bulkhead_delete('tbl_kiv_hull_bulkhead_details', $data_bulkhead_delete,$edit_id);
         
            }
             
            elseif($delete_status[$i]==0) //For Update
            {
             $data_bulkhead_update 	= 	array(
			
			'bulk_head_placement' 			=> 	$bulk_head_placement[$i],
			'bulk_head_thickness' 			=> 	$bulk_head_thickness[$i],
            'bulk_head_modified_user_id'	=>	$sess_usr_id,
			'bulk_head_modified_timestamp'	=>	$date,
			'bulk_head_modified_ipaddress'	=>	$ip,
            'delete_status'                 =>      $delete_status[$i]
			);
              $edit_id=$hull_bulkhead_details_sl[$i];
             $data = $this->security->xss_clean($data);
                         
             $res_bulkhead_update=$this->Survey_model->update_bulkhead_update('tbl_kiv_hull_bulkhead_details', $data_bulkhead_update,$edit_id);
           

                
            }
            elseif($delete_status[$i]==2) //For Insert
            {
                $data_bulkhead_insert 	= 	array(
			'vessel_id'                 => 	$vessel_id,
			'bulk_head_placement' 		=> 	$bulk_head_placement[$i],
			'bulk_head_thickness' 		=> 	$bulk_head_thickness[$i],
			'bulk_head_created_user_id'	=>	$sess_usr_id,
			'bulk_head_created_timestamp'	=>	$date,
			'bulk_head_created_ipaddress'	=>	$ip
			);
                $data = $this->security->xss_clean($data);
               
                $res_bulkhead_insert=$this->Survey_model->insert_bulkhead('tbl_kiv_hull_bulkhead_details', $data_bulkhead_insert);
        
                
                
            }
			
                       
        }
		
						
	
						

$data_hull = array(

    'hull_name'                			=>  $hull_name,  
    'hull_address'              		=>  $hull_address,
    'hull_thickness' 					=> 	$hull_thickness,
    'hullmaterial_id'					=> 	$hullmaterial_id,
    'freeboard_status_id'       		=>  $freeboard_status_id,
    'bulk_heads'         				=>	$bulk_heads,
    'yard_accreditation_number'			=>	$yard_accreditation_number,
    'yard_accreditation_expiry_date'    =>	$yard_accreditation_expiry_date,
    'hullplating_material_id'           =>	$hullplating_material_id,
    'hull_plating_material_thickness'	=>	$hull_plating_material_thickness,
     'hull_modified_user_id'            =>  $sess_usr_id,
    'hull_modified_timestamp'           =>	$date,
    'hull_modified_ipaddress'           =>	$ip 
     );
			
	
	       
        $update_table		=	$this->Survey_model->update_initial_survey_hull_table('tbl_kiv_hulldetails',$data_hull,$hull_sl);
      
        /*      
	if($stage_count<8)		
        {
	$data_stage = 	array(
			'stage' => 2,
			'stage_count'=>2
			);
	$updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
           
        }
        
        
         */
      
    }
      
}
  	
function Edit_engine_details()
{
   /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
	$customer_id	=	$this->session->userdata('customer_id');
	$survey_user_id	=	$this->session->userdata('survey_user_id');

if(!empty($sess_usr_id))
	{	

		$data =	array('title' => 'form3', 'page' => 'form3', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');             
        $vessel_id     			=   $this->security->xss_clean($this->input->post('vessel_id'));
        $form_stage_sl			= 	$this->Survey_model->get_form_stage_sl($vessel_id);
        $data['form_stage_sl']	=	$form_stage_sl;
		//$stage_sl 				=	$form_stage_sl[0]['stage_sl'];
		if(!empty($form_stage_sl))
     {
          $stage_sl=$form_stage_sl[0]['stage_sl'];
     }
        
             $no_of_engineset       =	$this->security->xss_clean($this->input->post('no_of_engineset'));
             $engineset_no       	  =	$this->security->xss_clean($this->input->post('engineset_no'));
             $engine_number         =	$this->security->xss_clean($this->input->post('engine_number'));
                         
             $engine_placement_id   =	$this->security->xss_clean($this->input->post('engine_placement_id'));
             $bhp                   =	$this->security->xss_clean($this->input->post('bhp'));
             $manufacturer_name     =	$this->security->xss_clean($this->input->post('manufacturer_name'));
             $manufacturer_brand    =	$this->security->xss_clean($this->input->post('manufacturer_brand'));
             $engine_model_id       =	$this->security->xss_clean($this->input->post('engine_model_id'));
             $engine_type_id        =	$this->security->xss_clean($this->input->post('engine_type_id'));
             $propulsion_diameter   =	$this->security->xss_clean($this->input->post('propulsion_diameter'));
             $propulsion_material_id=	$this->security->xss_clean($this->input->post('propulsion_material_id'));
             $gear_type_id          =	$this->security->xss_clean($this->input->post('gear_type_id'));
             $gear_number           =	$this->security->xss_clean($this->input->post('gear_number'));
             $delete_status_engine  =	$this->security->xss_clean($this->input->post('delete_status_engine'));
             $engine_sl             =	$this->security->xss_clean($this->input->post('engine_sl'));
             
             //print_r($delete_status_engine);
             $bhp_kw                =	$this->security->xss_clean($this->input->post('bhp_kw'));
             $ip                    =	$_SERVER['REMOTE_ADDR'];
            date_default_timezone_set("Asia/Kolkata");
            $date                   = 	date('Y-m-d h:i:s', time());
           
          
         for($i=0;$i<$engineset_no;$i++)
        {
            if($delete_status_engine[$i]==1) // For Delete
            {
                $data_engine_delete	= 	array(
            'engine_modified_user_id'	=>	$sess_usr_id,
			'engine_modified_timestamp'	=>	$date,
			'engine_modified_ipaddress'	=>	$ip,
            'delete_status'             =>  $delete_status_engine[$i]
			);
              
             $edit_id=$engine_sl[$i];
             $data = $this->security->xss_clean($data);
            
             $res_engine_delete =$this->Survey_model->update_engine_delete('tbl_kiv_engine_details', $data_engine_delete,$edit_id);
         
            }
           
         
            elseif($delete_status_engine[$i]==0) //For Update
            {
             $data_engine_update 	= 	array(
                'engine_number'			=>$engine_number[$i],
                'engine_placement_id' 	=> $engine_placement_id[$i],  
                'bhp'                   => $bhp[$i],
                'bhp_kw'                => $bhp_kw[$i],            
                'manufacturer_name' 	=> $manufacturer_name[$i],
                'manufacturer_brand'	=> $manufacturer_brand[$i],
                'engine_model_id'		=>$engine_model_id[$i],
                'engine_type_id'		=>	$engine_type_id[$i],
                'propulsion_diameter'	=>	$propulsion_diameter[$i],
                'propulsion_material_id'=>	$propulsion_material_id[$i],
                'gear_type_id'			=>	$gear_type_id[$i],
                'gear_number'			=>	$gear_number[$i],
                 'engine_modified_user_id'	=>	$sess_usr_id,
                'engine_modified_timestamp'	=>	$date,
                'engine_modified_ipaddress'	=>	$ip,
                'delete_status'            	=>  $delete_status_engine[$i]

                                   );
              $edit_id=$engine_sl[$i];
             $data = $this->security->xss_clean($data);
                         
             $res_engine_update=$this->Survey_model->update_engine_update('tbl_kiv_engine_details', $data_engine_update,$edit_id);
            
            }
            
            
             elseif($delete_status_engine[$i]==2) //For Insert
            {
                $data_engine_insert 	= 	array(
                'vessel_id' 			=>	$vessel_id,
                'engine_number'			=>	$engine_number[$i],
                'engine_placement_id' 	=> 	$engine_placement_id[$i],  
                'bhp'                   => 	$bhp[$i],
                'bhp_kw'                => 	$bhp_kw[$i],            
                'manufacturer_name' 	=> 	$manufacturer_name[$i],
                'manufacturer_brand'	=> 	$manufacturer_brand[$i],
                'engine_model_id'		=>	$engine_model_id[$i],
                'engine_type_id'		=>	$engine_type_id[$i],
                'propulsion_diameter'	=>	$propulsion_diameter[$i],
                'propulsion_material_id'=>	$propulsion_material_id[$i],
                'gear_type_id'			=>	$gear_type_id[$i],
                'gear_number'			=>	$gear_number[$i],
                 'engine_created_user_id'	=>	$sess_usr_id,
                'engine_created_timestamp'	=>	$date,
                'engine_created_ipaddress'	=>	$ip
                );
                $data = $this->security->xss_clean($data);
               
                $res_engine_insert=$this->Survey_model->insert_engineset('tbl_kiv_engine_details', $data_engine_insert);
                
            }
                
        }
    }
		
}		



    


function Edit_equipment_details()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
	$customer_id	=	$this->session->userdata('customer_id');
	$survey_user_id	=	$this->session->userdata('survey_user_id');
		
			
        if(!empty($sess_usr_id))
		{	
		$data =	array('title' => 'form4', 'page' => 'form4', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');             
        $vessel_id              =   $this->security->xss_clean($this->input->post('vessel_id'));
        $form_stage_sl			= 	$this->Survey_model->get_form_stage_sl($vessel_id);
        $data['form_stage_sl']	=	$form_stage_sl;
		//$stage_sl 				=	$form_stage_sl[0]['stage_sl'];
		if(!empty($form_stage_sl))
     {
          $stage_sl=$form_stage_sl[0]['stage_sl'];
     }
        
        date_default_timezone_set("Asia/Kolkata");
        $ip              =	$_SERVER['REMOTE_ADDR'];
        $date            = 	date('Y-m-d h:i:s', time());
        
        $weight1         =	$this->security->xss_clean($this->input->post('weight1'));
        $material_id1    =	$this->security->xss_clean($this->input->post('material_id1'));
        $id1             =	$this->security->xss_clean($this->input->post('id1'));
        
        $weight2         =	$this->security->xss_clean($this->input->post('weight2'));
        $material_id2    =	$this->security->xss_clean($this->input->post('material_id2'));
        $id2             =	$this->security->xss_clean($this->input->post('id2'));
        
        $weight3         =	$this->security->xss_clean($this->input->post('weight3'));
        $material_id3    =	$this->security->xss_clean($this->input->post('material_id3'));
        $id3             =	$this->security->xss_clean($this->input->post('id3'));
               
       
        $length4             =	$this->security->xss_clean($this->input->post('length4'));
        $size4               =	$this->security->xss_clean($this->input->post('size4'));
        $chainport_type_id4  =	$this->security->xss_clean($this->input->post('chainport_type_id4'));
        $id4                 =	$this->security->xss_clean($this->input->post('id4'));
        
        
        $length5             =	$this->security->xss_clean($this->input->post('length5'));
        $size5               =	$this->security->xss_clean($this->input->post('size5'));
        $chainport_type_id5  =	$this->security->xss_clean($this->input->post('chainport_type_id5'));
        $id5                 =	$this->security->xss_clean($this->input->post('id5'));
        
        $size6              =	$this->security->xss_clean($this->input->post('size6'));
        $number6            =	$this->security->xss_clean($this->input->post('number6'));
        $material_id6       =	$this->security->xss_clean($this->input->post('material_id6'));
        $id6                =	$this->security->xss_clean($this->input->post('id6'));
        
        $number7            =	$this->security->xss_clean($this->input->post('number7'));
        $power7             =	$this->security->xss_clean($this->input->post('power7'));
        $size7              =	$this->security->xss_clean($this->input->post('size7'));
        $id7                =	$this->security->xss_clean($this->input->post('id7'));
        
        $number8            =	$this->security->xss_clean($this->input->post('number8'));
        $id8                =	$this->security->xss_clean($this->input->post('id8'));
        $number9            =	$this->security->xss_clean($this->input->post('number9'));
        $id9                =	$this->security->xss_clean($this->input->post('id9'));
       
    $data_equipment1 = 	array(
	'weight' 						=> $weight1,
	'material_id'					=>$material_id1,
	'equipment_modified_user_id'	=>$sess_usr_id,
    'equipment_modified_timestamp'	=>$date,
    'equipment_modified_ipaddress'	=>$ip
     );
    $edit_id1=$id1;
	$res_update_equipment1=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment1,$edit_id1);
  

    $data_equipment2 = 	array(
	'weight' 						=> $weight2,
	'material_id'					=>$material_id2,
	'equipment_modified_user_id'	=>$sess_usr_id,
    'equipment_modified_timestamp'	=>$date,
    'equipment_modified_ipaddress'	=>$ip
     );
    $edit_id2=$id2;
	$res_update_equipment2=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment2,$edit_id2);
        
        
       
        
    $data_equipment3 = 	array(
	'weight' 						=>$weight3,
	'material_id'					=>$material_id3,
	'equipment_modified_user_id'	=>$sess_usr_id,
    'equipment_modified_timestamp'	=>$date,
    'equipment_modified_ipaddress'	=>$ip
    );
    $edit_id3=$id3;
	$res_update_equipment3=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment3,$edit_id3);
        
       
    $data_equipment4 = 	array(
	'length' 						=>$length4,
	'size'							=>$size4,
    'chainport_type_id' 			=>$chainport_type_id4,
	'equipment_modified_user_id'	=>$sess_usr_id,
    'equipment_modified_timestamp'	=>$date,
    'equipment_modified_ipaddress'	=>$ip
     );
    $edit_id4=$id4;
	$res_update_equipment4=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment4,$edit_id4);
        
	$data_equipment5 = 	array(
	'length' 						=>$length5,
	'size'							=>$size5,
	'chainport_type_id'				=>$chainport_type_id5,
	'equipment_modified_user_id'	=>$sess_usr_id,
	'equipment_modified_timestamp'	=>$date,
	'equipment_modified_ipaddress'	=>$ip
	);
	$edit_id5=$id5;
	$res_update_equipment5=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment5,$edit_id5);
    

	$data_equipment6 = 	array(
	'size'							=>$size6,
	'number' 						=>$number6,    
	'material_id'					=>$material_id6,
	'equipment_modified_user_id' 	=>$sess_usr_id,
	'equipment_modified_timestamp'	=>$date,
	'equipment_modified_ipaddress'	=>$ip
	);
	$edit_id6=$id6;
	$res_update_equipment6=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment6,$edit_id6);
    


	$data_equipment7 = 	array(
	'number' 						=>$number7,    
	'power'							=>$power7,
	'size'							=>$size7,
	'equipment_modified_user_id'	=>$sess_usr_id,
	'equipment_modified_timestamp'	=>$date,
	'equipment_modified_ipaddress'	=>$ip
	);
	$edit_id7=$id7;
	$res_update_equipment7=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment7,$edit_id7);
	 


	$data_equipment8 = 	array(
	'number' 						=>$number8,    
	'equipment_modified_user_id'	=>$sess_usr_id,
	'equipment_modified_timestamp'	=>$date,
	'equipment_modified_ipaddress'	=>$ip
	);
	$edit_id8=$id8;
	$res_update_equipment8=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment8,$edit_id8);
	        
        
	$data_equipment9 = 	array(
	'number' 						=>$number9,    
	'equipment_modified_user_id'	=>$sess_usr_id,
	'equipment_modified_timestamp'	=>$date,
	'equipment_modified_ipaddress'	=>$ip
	);
	$edit_id9=$id9;
	$res_update_equipment9=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment9,$edit_id9);
        
 }
                
}


function Edit_fire_appliance()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
	$customer_id	=	$this->session->userdata('customer_id');
	$survey_user_id	=	$this->session->userdata('survey_user_id');
		
			
        if(!empty($sess_usr_id))
		{	
		$data =	array('title' => 'form5', 'page' => 'form5', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');               
            $vessel_id                        =      $this->security->xss_clean($this->input->post('vessel_id'));
        
        $form_stage_sl		= 	$this->Survey_model->get_form_stage_sl($vessel_id);
        $data['form_stage_sl']	=	$form_stage_sl;
	//$stage_sl=$form_stage_sl[0]['stage_sl'];
	if(!empty($form_stage_sl))
     {
          $stage_sl=$form_stage_sl[0]['stage_sl'];
     }
        
        $ip                    =	$_SERVER['REMOTE_ADDR'];
        date_default_timezone_set("Asia/Kolkata");
        $date                   = 	date('Y-m-d h:i:s', time());
        
        $firepumptype_sl1       =	$this->security->xss_clean($this->input->post('firepumptype_sl1'));
        $number1                =	$this->security->xss_clean($this->input->post('number1'));
        $capacity1              =	$this->security->xss_clean($this->input->post('capacity1'));
        $firepumpsize_id1       =	$this->security->xss_clean($this->input->post('firepumpsize_id1'));
        
        $material_id1   =$this->security->xss_clean($this->input->post('material_id1'));
        $diameter1      =$this->security->xss_clean($this->input->post('diameter1'));
        $id1_fire       =$this->security->xss_clean($this->input->post('id1_fire'));
        
        $number2        =$this->security->xss_clean($this->input->post('number2'));
        $id2_fire       =$this->security->xss_clean($this->input->post('id2_fire'));
        $number3        =$this->security->xss_clean($this->input->post('number3'));
        $id3_fire       =$this->security->xss_clean($this->input->post('id3_fire'));
        
        
        $fire_extinguisher_sl=$this->security->xss_clean($this->input->post('fire_extinguisher_sl'));
        $fire_extinguisher_number =$this->security->xss_clean($this->input->post('fire_extinguisher_number'));
        $fire_extinguisher_capacity=$this->security->xss_clean($this->input->post('fire_extinguisher_capacity'));
       
        
	$data_equipment1 = 	array(
	'material_id' 					=>$material_id1,
	'diameter'						=>$diameter1,
	'equipment_modified_user_id'	=>$sess_usr_id,
	'equipment_modified_timestamp'	=>$date,
	'equipment_modified_ipaddress'	=>$ip
	);
	$edit_id1=$id1_fire;
	$res_update_equipment1=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment1,$edit_id1);



	$data_equipment2 = 	array(
	'number' 						=>$number2,
	'equipment_modified_user_id'	=>$sess_usr_id,
	'equipment_modified_timestamp'	=>$date,
	'equipment_modified_ipaddress'	=>$ip
	);
	$edit_id2=$id2_fire;
	$res_update_equipment2=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment2,$edit_id2);


	$data_equipment3 = 	array(
	'number' 						=>$number3,
	'equipment_modified_user_id'	=>$sess_usr_id,
	'equipment_modified_timestamp'	=>$date,
	'equipment_modified_ipaddress'	=>$ip
	);
	$edit_id3=$id3_fire;
	$res_update_equipment3=$this->Survey_model->update_equipment('tbl_kiv_equipment_details',$data_equipment3,$edit_id3);
        
        
        
		for($i=0;$i<2;$i++)
		{
		    
			$data_firepump_update	= 	array(
		    'number'            				  =>$number1[$i],
		    'capacity'          				  =>$capacity1[$i],
		    'firepumpsize_id'   				  =>$firepumpsize_id1[$i],
		     'firepumps_details_modified_user_id' =>$sess_usr_id,
		    'firepumps_details_modified_timestamp'=>$date,
		    'firepumps_details_modified_ipaddress'=>$ip
		    );
		      
		     $edit_id=$firepumptype_sl1[$i];
		     $data = $this->security->xss_clean($data);
		    
		     $res_firepump_update =$this->Survey_model->update_firepump('tbl_kiv_firepumps_details', $data_firepump_update,$edit_id);
		 
		}
            
		for($j=0;$j<3;$j++)
		{

		$data_portablefire_update	= 	array(
		'fire_extinguisher_number'    			=>	$fire_extinguisher_number[$j],
		'fire_extinguisher_capacity'  			=>	$fire_extinguisher_capacity[$j],
		'fire_extinguisher_modified_user_id'    =>	$sess_usr_id,
		'fire_extinguisher_modified_timestamp'	=>	$date,
		'fire_extinguisher_modified_ipaddress'	=>	$ip
		);


		$edit_id_fireext=$fire_extinguisher_sl[$j];
		$data 			= $this->security->xss_clean($data);

		$res_portablefire_update =$this->Survey_model->update_portablefire('tbl_kiv_fire_extinguisher_details', $data_portablefire_update, $edit_id_fireext);

		}
  }
}


function Edit_other_equipments()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
	$customer_id	=	$this->session->userdata('customer_id');
	$survey_user_id	=	$this->session->userdata('survey_user_id');
	
		
    if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'form6', 'page' => 'form6', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
        $vessel_id              =       $this->security->xss_clean($this->input->post('vessel_id'));
	    
	    /*
	    $form_stage_sl		= 	$this->Survey_model->get_form_stage_sl($vessel_id);
	    $data['form_stage_sl']	=	$form_stage_sl;
		$stage_sl=$form_stage_sl[0]['stage_sl'];
	    */
    
    	$ip            =	$_SERVER['REMOTE_ADDR'];
    	date_default_timezone_set("Asia/Kolkata");
    	$date          = 	date('Y-m-d h:i:s', time());
    
      $sewage_treatment		=$this->security->xss_clean($this->input->post('sewage_treatment'));
      $solid_waste			  =$this->security->xss_clean($this->input->post('solid_waste'));
      $sound_pollution		=$this->security->xss_clean($this->input->post('sound_pollution'));
      $water_consumption	=$this->security->xss_clean($this->input->post('water_consumption'));
      $source_of_water		=$this->security->xss_clean($this->input->post('source_of_water'));
    
		$data_update_vessel=array(
		'sewage_treatment'			=>$sewage_treatment,
		'solid_waste'				=>$solid_waste,
		'sound_pollution'			=>$sound_pollution,
		'water_consumption'			=>$water_consumption,
		'source_of_water'			=>$source_of_water,
		'vessel_modified_user_id'	=>$user_type_id,
		'vessel_modified_timestamp'	=>$date,
		'vessel_modified_ipaddress'	=>$ip  

		);
		$update_table		=	$this->Survey_model->update_initial_survey_vessel_table('tbl_kiv_vessel_details',$data_update_vessel,$vessel_id);
    
    }
}

function Edit_vessel_documents()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
	$customer_id	=	$this->session->userdata('customer_id');
	$survey_user_id	=	$this->session->userdata('survey_user_id');
		
			
    if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'form7', 'page' => 'form7', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
      $this->load->model('Kiv_models/Survey_model');             
        $vessel_id          	=   $this->security->xss_clean($this->input->post('vessel_id'));
        $form_stage_sl			= 	$this->Survey_model->get_form_stage_sl($vessel_id);
        $data['form_stage_sl']	=	$form_stage_sl;
		//$stage_sl 				=	$form_stage_sl[0]['stage_sl'];
		if(!empty($form_stage_sl))
     {
          $stage_sl=$form_stage_sl[0]['stage_sl'];
     }
        
        date_default_timezone_set("Asia/Kolkata");
        $ip                    	=	$_SERVER['REMOTE_ADDR'];
        $date                   = 	date('Y-m-d h:i:s', time());
        
        $doc_details			= 	$this->Survey_model->get_upload_filename($vessel_id);
        $data['doc_details']	=	$doc_details;

		if(!empty($doc_details))
		{
		$filename 				=	$doc_details[0]['document_name'];
		}
				
        
       
        
        $document_id=$this->security->xss_clean($this->input->post('document_id'));
        
        
	    $str 		= substr($filename, strpos($filename, ".") + -1);    
	    $rand 		= rtrim($str, ".pdf"); 
	     if($rand>0)
	     {
	         $random_number=$rand;
	     }
	     else
	     { 
	         $random_number=rand(1,9); 
	     }
       
        
        
        
        for($j=1; $j<=9;$j++)          
        {
            
          	$form_id='1';
          	$document_id=$j;
          
           	$documents			= 	$this->Survey_model->get_document_id($vessel_id,$j,$survey_id);
        	$data['documents']	=	$documents;

				if(!empty($documents))
				{
				$cnt 				=	$documents[0]['cnt'];
				}


			
         	//vessel_id/form_id/document_id/randomnumber.pdf
         	$document_name 		=	$vessel_id.'_'.$document_id.'_'.$form_id.'_'.$random_number.'.pdf';
         
         
       		//if(($_FILES['myFile'.$j]['name'][0]) && ($cnt==0) )
		 	if($cnt==0 )
		    {
		    $data_document =	array(
		      'vessel_id'						=>$vessel_id,
		      'document_id'						=>$j,
		      'document_type_id'				=>1,
		      'document_name' 					=>$document_name,
		      'document_status_id' 				=>1,
		       'fileupload_created_user_id' 	=>$sess_usr_id,
		      'fileupload_created_timestamp' 	=>$date,
		      'fileupload_created_ipaddress' 	=>$ip
			);
				$res_doc=$this->Survey_model->insert_doc('tbl_kiv_fileupload_details', $data_document);
				copy($_FILES["myFile".$j]["tmp_name"][0], "./uploads/survey/".$j."/".$document_name);
			}
       
        
	       else
	       {
	              
		 	$data_document_update =	array(
		 	'fileupload_modified_user_id'	=>$sess_usr_id,
	        'fileupload_modified_timestamp'	=>$date,
	        'fileupload_modified_ipaddress'	=>$ip
			);
	      
	        $fileupload_details_sl 		=$this->security->xss_clean($this->input->post('fileupload_details_sl'.$j));
	        $edit_id_file 				=$fileupload_details_sl;
	        $res_doc_update	 			=$this->Survey_model->update_doc('tbl_kiv_fileupload_details', $data_document_update, $edit_id_file);
	         copy($_FILES["myFile".$j]["tmp_name"][0], "./uploads/survey/".$j."/".$document_name);


	         
	       }
         
         
    	}
             
        $vessel_pref_inspection_date1=$this->security->xss_clean($this->input->post('vessel_pref_inspection_date'));
        $vessel_pref_inspection_date = date("Y-m-d", strtotime($vessel_pref_inspection_date1));

        $data_update_vessel=array(
        'vessel_pref_inspection_date'	=>$vessel_pref_inspection_date,
        'vessel_modified_user_id'		=>$sess_usr_id,
        'vessel_modified_timestamp'		=>$date,
        'vessel_modified_ipaddress'		=>$ip  
        );
       $update_table=$this->Survey_model->update_initial_survey_vessel_table('tbl_kiv_vessel_details',$data_update_vessel,$vessel_id);
        
       
    }
}


function Edit_payment_details()
{
  /* $sess_usr_id     =   $this->session->userdata('user_sl');
    $user_type_id    = $this->session->userdata('user_type_id');*/
    $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');
	$customer_id	=	$this->session->userdata('customer_id');
	$survey_user_id	=	$this->session->userdata('survey_user_id');
		
		
    if(!empty($sess_usr_id))
	{	
		$data =	array('title' => 'form8', 'page' => 'form8', 'errorCls' => NULL, 'post' => $this->input->post());
		$data = $data + $this->data;
	     $this->load->model('Kiv_models/Survey_model');          
	    $vessel_id          	=   $this->security->xss_clean($this->input->post('vessel_id'));
	    $form_stage_sl			= 	$this->Survey_model->get_form_stage_sl($vessel_id);
	    $data['form_stage_sl']	=	$form_stage_sl;
		//$stage_sl 				=	$form_stage_sl[0]['stage_sl'];
		if(!empty($form_stage_sl))
		     {
		          $stage_sl=$form_stage_sl[0]['stage_sl'];
		     }
     

		date_default_timezone_set("Asia/Kolkata");
	    $ip                    	=	$_SERVER['REMOTE_ADDR'];
	    $date                  	= 	date('Y-m-d h:i:s', time());
	    
	        $payment_sl             =$this->security->xss_clean($this->input->post('payment_sl'));
	        $paymenttype_id         =$this->security->xss_clean($this->input->post('paymenttype_id'));              
	        $dd_amount              =$this->security->xss_clean($this->input->post('dd_amount'));
	        $dd_number              =$this->security->xss_clean($this->input->post('dd_number'));
	        $dd_date1               =$this->security->xss_clean($this->input->post('dd_date'));
	        $dd_date 				        = date("Y-m-d", strtotime($dd_date1));
	        $portofregistry_id      =$this->security->xss_clean($this->input->post('portofregistry_id'));
	        $bank_id                =$this->security->xss_clean($this->input->post('bank_id'));
	        $branch_name            =$this->security->xss_clean($this->input->post('branch_name'));
	        
			$data_payment=array(
		    'paymenttype_id'				=>$paymenttype_id,
		    'dd_amount'						=>$dd_amount,
		    'dd_number'						=>$dd_number,
		    'dd_date'						=>$dd_date,
		    'portofregistry_id'				=>$portofregistry_id,
		    'bank_id'						=>$bank_id,
		    'branch_name'					=>$branch_name,
		    'payment_modified_user_id'		=>$sess_usr_id,
		    'payment_modified_timestamp'	=>$date,
		    'payment_modified_ipaddress'	=>$ip
		     );
	        $res_payment_update =$this->Survey_model->update_payment_details(' tbl_kiv_payment_details', $data_payment,$payment_sl);
	        if($res_payment_update)  
	        {
	        	//$this->InitialSurvey();
	        	redirect("Kiv_Ctrl/Survey/InitialSurvey");
	        }         

    }
}

//_____________________________ Chief Surveyor Login________________________________//

public function csHome()
{
  $sess_usr_id   =   $this->session->userdata('int_userid');
  $user_type_id  = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  $this->load->model('Kiv_models/Master_model');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'csHome', 'page' => 'csHome', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_process_flow_cs($sess_usr_id);
    $data['initial_data']		=	$initial_data;
    //print_r($initial_data);

    $count	= count($initial_data);
    $data['count']=$count;
    
    @$id=$initial_data[0]['user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    //Count Task for cs
    $data_task=$this->Survey_model->get_task($sess_usr_id);
    $data['data_task']		=	$data_task;
    $count_task	= count($data_task);
    $data['count_task']=$count_task;

    //count form4
    $data_form4_cs=$this->Survey_model->get_form4_cs($sess_usr_id);
    $data['data_form4_cs']		=	$data_form4_cs;
    $count_form4	= count($data_form4_cs);
    $data['count_form4']=$count_form4;


    //count form5+form6 
    $data_form56_cs=$this->Survey_model->get_form56_cs($sess_usr_id);
    $data['data_form56_cs']		=	$data_form56_cs;
    $count_form56	= count($data_form56_cs);
    $data['count_form56']=$count_form56;

    //count form7
    $data_form7_cs=$this->Survey_model->get_form7_cs($sess_usr_id);
    $data['data_form7_cs']		=	$data_form7_cs;
    $count_form7	= count($data_form7_cs);
    $data['count_form7']=$count_form7;

    //payment checking
    $data_payment=$this->Survey_model->get_pending_payment();
    $data['data_payment']		=	$data_payment;
    $count_payment	= count($data_payment);
    $data['count_payment']=$count_payment;

    //Special survey
    $data_special=$this->Survey_model->get_process_flow_cs_special($sess_usr_id);
    $data['data_special']   = $data_special;
    $count_special  = count($data_special);
    $data['count_special']=$count_special;
    @$id1=$initial_data[0]['user_id'];

    $customer_details1=$this->Survey_model->get_customer_details($id1);
    $data['customer_details1']=$customer_details1;

    //_________________________GET SURVEY COUNT START________________________________//

    $process_id=1;
    $initial_survey_id=1;
    $annual_survey_id=2;
    $drydock_survey_id=3;
    $special_survey_id=4;

    $initial_survey_done=$this->Survey_model->get_survey_count($process_id,$initial_survey_id);
    $data['initial_survey_done']  = $initial_survey_done;
    if(!empty($initial_survey_done))
    {
      $count_initial_survey	= count($initial_survey_done);
      $data['count_initial_survey']=$count_initial_survey;
    }
    else
    {
      $count_initial_survey=0;
    }

    $annual_survey_done=$this->Survey_model->get_survey_count($process_id,$annual_survey_id);
    $data['annual_survey_done']  = $annual_survey_done;
    if(!empty($annual_survey_done))
    {
      $count_annual_survey	= count($annual_survey_done);
      $data['count_annual_survey']=$count_annual_survey;
    }
    else
    {
      $count_annual_survey=0;
    }

    $drydock_survey_done=$this->Survey_model->get_survey_count($process_id,$drydock_survey_id);
    $data['drydock_survey_done']  = $drydock_survey_done;
    if(!empty($drydock_survey_done))
    {
      $count_drydock_survey	= count($drydock_survey_done);
      $data['count_drydock_survey']=$count_drydock_survey;
    }
    else
    {
      $count_drydock_survey=0;
    }

    $special_survey_done=$this->Survey_model->get_specialsurvey_done_ndate($process_id);
    $data['special_survey_done']  = $special_survey_done;
    if(!empty($special_survey_done))
    {
      $count_special_survey	= count($special_survey_done);
      $data['count_special_survey']=$count_special_survey;
    }
    else
    {
      $count_special_survey=0;
    }
    //_________________________GET SURVEY COUNT END_______________________________________//
    //____________________________________SURVEY FORMS START______________________________________//
    /*______________form1________________*/	
    $survey_id1=1;
    $process_id1=1;

    $form1=$this->Survey_model->get_forms_count($process_id1,$survey_id1,$sess_usr_id);
    $data['form1']  = $form1;
    $form1_count  = count($form1);
    $data['form1_count']=$form1_count;

    /*______________keel________________*/	
    $process_id2=2;

    $keel=$this->Survey_model->get_forms_count($process_id2,$survey_id1,$sess_usr_id);
    $data['keel']  = $keel;
    $keel_count  = count($keel);
    $data['keel_count']=$keel_count;

    /*______________hull________________*/	
    $process_id3=3;

    $hull=$this->Survey_model->get_forms_count($process_id3,$survey_id1,$sess_usr_id);
    $data['hull']  = $hull;
    $hull_count  = count($hull);
    $data['hull_count']=$hull_count;
    /*______________final________________*/	
    $process_id4=4;

    $final=$this->Survey_model->get_forms_count($process_id4,$survey_id1,$sess_usr_id);
    $data['final']  = $final;
    $final_count  = count($final);
    $data['final_count']=$final_count;
    /*______________form3________________*/	
    $process_id5=5;

    $form3=$this->Survey_model->get_forms_count($process_id5,$survey_id1,$sess_usr_id);
    $data['form3']  = $form3;
    $form3_count  = count($form3);
    $data['form3_count']=$form3_count;

    /*______________form4________________*/	
    $process_id6=6;

    $form4=$this->Survey_model->get_forms_count($process_id6,$survey_id1,$sess_usr_id);
    $data['form4']  = $form4;
    $form4_count  = count($form4);
    $data['form4_count']=$form4_count;

    /*______________Defect________________*/	
    $process_id7=7;

    $defect=$this->Survey_model->get_forms_count($process_id7,$survey_id1,$sess_usr_id);
    $data['defect']  = $defect;
    $defect_count  = count($defect);
    $data['defect_count']=$defect_count;
    /*______________form5________________*/	
    $process_id8=8;

    $form5=$this->Survey_model->get_forms_count($process_id8,$survey_id1,$sess_usr_id);
    $data['form5']  = $form5;
    $form5_count  = count($form5);
    $data['form5_count']=$form5_count;

    /*______________form6________________*/	
    $process_id9=9;

    $form6=$this->Survey_model->get_forms_count($process_id9,$survey_id1,$sess_usr_id);
    $data['form6']  = $form6;
    $form6_count  = count($form6);
    $data['form6_count']=$form6_count;

    /*______________form7________________*/	
    $process_id10=10;

    $form7=$this->Survey_model->get_forms_count($process_id10,$survey_id1,$sess_usr_id);
    $data['form7']  = $form7;
    $form7_count  = count($form7);
    $data['form7_count']=$form7_count;
    /*______________form8________________*/	
    $process_id11=11;

    $form8=$this->Survey_model->get_forms_count($process_id11,$survey_id1,$sess_usr_id);
    $data['form8']  = $form8;
    $form8_count  = count($form8);
    $data['form8_count']=$form8_count;

    /*______________form9________________*/	
    $process_id12=12;

    $form9=$this->Survey_model->get_forms_count($process_id12,$survey_id1,$sess_usr_id);
    $data['form9']  = $form9;
    $form9_count  = count($form9);
    $data['form9_count']=$form9_count;

    /*______________form10________________*/	
    $process_id13=13;

    $form10=$this->Survey_model->get_forms_count($process_id13,$survey_id1,$sess_usr_id);
    $data['form10']  = $form10;
    $form10_count  = count($form10);
    $data['form10_count']=$form10_count;
    /*______________form2________________*/	
    $process_id15=15;
    $survey_id2=2;

    $form2=$this->Survey_model->get_forms_count($process_id15,$survey_id2,$sess_usr_id);
    $data['form2']  = $form2;
    $form2_count  = count($form2);
    $data['form2_count']=$form2_count;


    /*______________count of annual survey request________________*/	
    $annualsurvey=$this->Survey_model->get_annualsurvey_count($sess_usr_id);
    $data['annualsurvey']  = $annualsurvey;
    $annualsurvey_count  = count($annualsurvey);
    $data['annualsurvey_count']=$annualsurvey_count;

    /*______________ count of drydock survey request________________*/	
    $process_id26=26;
    $survey_id3=3;

    $drydocksurvey=$this->Survey_model->get_forms_count($process_id26,$survey_id3,$sess_usr_id);
    $data['drydocksurvey']  = $drydocksurvey;
    $drydocksurvey_count  = count($drydocksurvey);
    $data['drydocksurvey_count']=$drydocksurvey_count;
    //____________________________________SURVEY FORMS END______________________________________//

    //____________________________________Initial survey request______________________________________//

    $initialsurvey=$this->Survey_model->get_initialsurvey_request($sess_usr_id);
    $data['initialsurvey']  = $initialsurvey;
    $initialsurvey_request_count  = count($initialsurvey);
    $data['initialsurvey_request_count']=$initialsurvey_request_count;
    //___________________________Registered vessel and book of registration_______________________//
    $reg_vessel      =   $this->Survey_model->get_reg_vessel_list();
    $data['reg_vessel']  = $reg_vessel;
    if(!empty($reg_vessel)) 
    {
      $count_reg_vessel=count($reg_vessel);
      $data['count_reg_vessel']=$count_reg_vessel;
    }
    /* ======Added for dynamic menu listing (start) on 02.11.2019========   */ 
    $menu     =   $this->Master_model->get_menu($user_type_id); //print_r($menu);
    $data['menu'] = $menu;
    $data       =   $data + $this->data;
    /* ======Added for dynamic menu listing (end) on 02.11.2019========   */ 
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/cs',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function cs_inbox()
{
  $sess_usr_id   =   $this->session->userdata('int_userid');
  $user_type_id  = $this->session->userdata('int_usertype');
  $customer_id = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'cs_inbox', 'page' => 'cs_inbox', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data          =   $this->Survey_model->get_process_flow_cs($sess_usr_id);

    $data['initial_data']   = $initial_data;
    //print_r($initial_data);
    $count  = count($initial_data);
    $data['count']=$count;
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/cs_inbox',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function initialsurvey_request()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'initialsurvey_request', 'page' => 'initialsurvey_request', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initialsurvey=$this->Survey_model->get_initialsurvey_request_view($sess_usr_id);
    $data['initialsurvey']  = $initialsurvey;

    $initialsurvey_request_count  = count($initialsurvey);
    $data['initialsurvey_request_count']=$initialsurvey_request_count;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/initialsurvey_request',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}
public function annualsurvey_request()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'annualsurvey_request', 'page' => 'annualsurvey_request', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $annualsurvey=$this->Survey_model->get_annualsurvey_view($sess_usr_id);
    $data['annualsurvey']  = $annualsurvey;
    $annualsurvey_count  = count($annualsurvey);
    $data['annualsurvey_count']=$annualsurvey_count;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/annualsurvey_request',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}
public function drydocksurvey_request()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'drydocksurvey_request', 'page' => 'drydocksurvey_request', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    //$process_id26=26;
    $survey_id3=3;

    $drydocksurvey=$this->Survey_model->get_drydocksurvey_view($survey_id3,$sess_usr_id);
    $data['drydocksurvey']  = $drydocksurvey;
    $drydocksurvey_count  = count($drydocksurvey);
    $data['drydocksurvey_count']=$drydocksurvey_count;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/drydocksurvey_request',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}

public function specialsurvey_request()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'specialsurvey_request', 'page' => 'specialsurvey_request', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    //$process_id26=26;
    $survey_id4=4;
    $specialsurvey=$this->Survey_model->get_specialsurvey_view($survey_id4,$sess_usr_id);
    $data['specialsurvey']  = $specialsurvey;
    $specialsurvey_count  = count($specialsurvey);
    $data['specialsurvey_count']=$specialsurvey_count;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/specialsurvey_request',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}
public function survey_forms_view()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $id_show1      = $this->uri->segment(4);
  $id_show=str_replace(array('-', '_', '~'), array('+', '/', '='), $id_show1);
  $id_show=$this->encrypt->decode($id_show); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'survey_forms_view', 'page' => 'survey_forms_view', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $survey_id1=1;
  	//______________form1________________//	
  	if($id_show==1)
  	{
  		$process_id1=1;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
  	//______________keel________________//	
  	if($id_show==2)
  	{
  		$process_id1=2;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
  	//______________Hull________________//	
  	if($id_show==3)
  	{
  		$process_id1=3;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
  	//______________Final________________//	
  	if($id_show==4)
  	{
  		$process_id1=4;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
  	//______________Form 3________________//	
  	if($id_show==5)
  	{
  		$process_id1=5;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
  	//______________Form 4________________//	
  	if($id_show==6)
  	{
  		$process_id1=6;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
  	//______________Defect________________//	
  	if($id_show==7)
  	{
  		$process_id1=7;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
  	//______________Form 5________________//	
  	if($id_show==8)
  	{
  		$process_id1=8;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
  	//______________Form 6________________//	
  	if($id_show==9)
  	{
  		$process_id1=9;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
  	//______________Form 7________________//	
  	if($id_show==10)
  	{
  		$process_id1=10;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}

  	
  	//______________Form 9________________//	
  	if($id_show==12)
  	{
  		$process_id1=12;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}

  	
  	//______________Form 10________________//	
  	if($id_show==13)
  	{
  		$process_id1=13;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id1,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}

  	//______________Form 2________________//	
  	if($id_show==15)
  	{
  		$process_id1=15;
  		$survey_id2=2;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id2,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
  	//______________Annual survey________________//	
  	if($id_show==17)
  	{
  		
  		$survey_forms=$this->Survey_model->get_annualsurvey_view($sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
  	//______________Drydock survey________________//	
  	if($id_show==26)
  	{
  		$process_id1=26;
  		$survey_id3=3;
  		$survey_forms=$this->Survey_model->get_survey_forms_view($process_id1,$survey_id3,$sess_usr_id);
  		$data['survey_forms']  = $survey_forms;
  	}
	  $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/survey_forms_view',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');
  }
}
//___________________________________ Surveyor Login________________________________//
public function SurveyorHome()
{
  $sess_usr_id   =   $this->session->userdata('int_userid');
  $user_type_id  = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'SurveyorHome', 'page' => 'SurveyorHome', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Master_model');
    $initial_data			    = 	$this->Survey_model->get_process_flow_sr($sess_usr_id);
    $data['initial_data']		=	$initial_data;
    //print_r($initial_data);
    $count	= count($initial_data);
    $data['count']=$count;
    @$id=$initial_data[0]['user_id'];
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $data_task=$this->Survey_model->get_task($sess_usr_id);
    $data['data_task']		=	$data_task;
    $count_task	= count($data_task);
    $data['count_task']=$count_task;

    //count form4
    $data_form4_cs=$this->Survey_model->get_form4_cs($sess_usr_id);
    $data['data_form4_cs']		=	$data_form4_cs;
    $count_form4	= count($data_form4_cs);
    $data['count_form4']=$count_form4;

    //count form5+form6 
    $data_form56_cs=$this->Survey_model->get_form56_cs($sess_usr_id);
    $data['data_form56_cs']		=	$data_form56_cs;
    $count_form56	= count($data_form56_cs);
    $data['count_form56']=$count_form56;

    //count form7
    $data_form7_cs=$this->Survey_model->get_form7_cs($sess_usr_id);
    $data['data_form7_cs']		=	$data_form7_cs;
    $count_form7	= count($data_form7_cs);
    $data['count_form7']=$count_form7;
    @$id1=$initial_data[0]['user_id'];

    $customer_details1=$this->Survey_model->get_customer_details($id1);
    $data['customer_details1']=$customer_details1;

    //_________________________GET SURVEY COUNT START________________________________//

    $process_id=1;
    $initial_survey_id=1;
    $annual_survey_id=2;
    $drydock_survey_id=3;
    $special_survey_id=4;

    $initial_survey_done=$this->Survey_model->get_survey_count($process_id,$initial_survey_id);
    $data['initial_survey_done']  = $initial_survey_done;
    if(!empty($initial_survey_done))
    {
      $count_initial_survey	= count($initial_survey_done);
      $data['count_initial_survey']=$count_initial_survey;
    }
    else
    {
      $count_initial_survey=0;
    }

    $annual_survey_done=$this->Survey_model->get_survey_count($process_id,$annual_survey_id);
    $data['annual_survey_done']  = $annual_survey_done;
    if(!empty($annual_survey_done))
    {
      $count_annual_survey	= count($annual_survey_done);
      $data['count_annual_survey']=$count_annual_survey;
    }
    else
    {
      $count_annual_survey=0;
    }

    $drydock_survey_done=$this->Survey_model->get_survey_count($process_id,$drydock_survey_id);
    $data['drydock_survey_done']  = $drydock_survey_done;
    if(!empty($drydock_survey_done))
    {
      $count_drydock_survey	= count($drydock_survey_done);
      $data['count_drydock_survey']=$count_drydock_survey;
    }
    else
    {
      $count_drydock_survey=0;
    }

    $special_survey_done=$this->Survey_model->get_survey_count($process_id,$special_survey_id);
    $data['special_survey_done']  = $special_survey_done;
    if(!empty($special_survey_done))
    {
      $count_special_survey	= count($special_survey_done);
      $data['count_special_survey']=$count_special_survey;
    }
    else
    {
      $count_special_survey=0;
    }
    //_________________________GET SURVEY COUNT END_______________________________________//

    //____________________________________SURVEY FORMS START______________________________________//

    /*______________form1________________*/	
    $survey_id1=1;
    $process_id1=1;

    $form1=$this->Survey_model->get_forms_count($process_id1,$survey_id1,$sess_usr_id);
    $data['form1']  = $form1;
    $form1_count  = count($form1);
    $data['form1_count']=$form1_count;

    /*______________keel________________*/	
    $process_id2=2;

    $keel=$this->Survey_model->get_forms_count($process_id2,$survey_id1,$sess_usr_id);
    $data['keel']  = $keel;
    $keel_count  = count($keel);
    $data['keel_count']=$keel_count;

    /*______________hull________________*/	
    $process_id3=3;

    $hull=$this->Survey_model->get_forms_count($process_id3,$survey_id1,$sess_usr_id);
    $data['hull']  = $hull;
    $hull_count  = count($hull);
    $data['hull_count']=$hull_count;
    /*______________final________________*/	
    $process_id4=4;

    $final=$this->Survey_model->get_forms_count($process_id4,$survey_id1,$sess_usr_id);
    $data['final']  = $final;
    $final_count  = count($final);
    $data['final_count']=$final_count;
    /*______________form3________________*/	
    $process_id5=5;

    $form3=$this->Survey_model->get_forms_count($process_id5,$survey_id1,$sess_usr_id);
    $data['form3']  = $form3;
    $form3_count  = count($form3);
    $data['form3_count']=$form3_count;

    /*______________form4________________*/	
    $process_id6=6;

    $form4=$this->Survey_model->get_forms_count($process_id6,$survey_id1,$sess_usr_id);
    $data['form4']  = $form4;
    $form4_count  = count($form4);
    $data['form4_count']=$form4_count;

    /*______________Defect________________*/	
    $process_id7=7;

    $defect=$this->Survey_model->get_forms_count($process_id7,$survey_id1,$sess_usr_id);
    $data['defect']  = $defect;
    $defect_count  = count($defect);
    $data['defect_count']=$defect_count;
    /*______________form5________________*/	
    $process_id8=8;

    $form5=$this->Survey_model->get_forms_count($process_id8,$survey_id1,$sess_usr_id);
    $data['form5']  = $form5;
    $form5_count  = count($form5);
    $data['form5_count']=$form5_count;

    /*______________form6________________*/	
    $process_id9=9;

    $form6=$this->Survey_model->get_forms_count($process_id9,$survey_id1,$sess_usr_id);
    $data['form6']  = $form6;
    $form6_count  = count($form6);
    $data['form6_count']=$form6_count;

    /*______________form7________________*/	
    $process_id10=10;

    $form7=$this->Survey_model->get_forms_count($process_id10,$survey_id1,$sess_usr_id);
    $data['form7']  = $form7;
    $form7_count  = count($form7);
    $data['form7_count']=$form7_count;
    /*______________form8________________*/	
    $process_id11=11;

    $form8=$this->Survey_model->get_forms_count($process_id11,$survey_id1,$sess_usr_id);
    $data['form8']  = $form8;
    $form8_count  = count($form8);
    $data['form8_count']=$form8_count;

    /*______________form9________________*/	
    $process_id12=12;

    $form9=$this->Survey_model->get_forms_count($process_id12,$survey_id1,$sess_usr_id);
    $data['form9']  = $form9;
    $form9_count  = count($form9);
    $data['form9_count']=$form9_count;

    /*______________form10________________*/	
    $process_id13=13;

    $form10=$this->Survey_model->get_forms_count($process_id13,$survey_id1,$sess_usr_id);
    $data['form10']  = $form10;
    $form10_count  = count($form10);
    $data['form10_count']=$form10_count;

    /*______________form2________________*/	
    $process_id15=15;
    $survey_id2=2;

    $form2=$this->Survey_model->get_forms_count($process_id15,$survey_id2,$sess_usr_id);
    $data['form2']  = $form2;
    $form2_count  = count($form2);
    $data['form2_count']=$form2_count;

    /*______________count of annual survey request________________*/	
    $annualsurvey=$this->Survey_model->get_annualsurvey_count($sess_usr_id);
    $data['annualsurvey']  = $annualsurvey;
    $annualsurvey_count  = count($annualsurvey);
    $data['annualsurvey_count']=$annualsurvey_count;

    /*______________ count of drydock survey request________________*/	
    $process_id26=26;
    $survey_id3=3;

    $drydocksurvey=$this->Survey_model->get_forms_count($process_id26,$survey_id3,$sess_usr_id);
    $data['drydocksurvey']  = $drydocksurvey;
    $drydocksurvey_count  = count($drydocksurvey);
    $data['drydocksurvey_count']=$drydocksurvey_count;
    //____________________________________SURVEY FORMS END______________________________________//
    //____________________________________Initial survey request______________________________________//

    $initialsurvey=$this->Survey_model->get_initialsurvey_request($sess_usr_id);
    $data['initialsurvey']  = $initialsurvey;
    $initialsurvey_request_count  = count($initialsurvey);
    $data['initialsurvey_request_count']=$initialsurvey_request_count;

    /* ======Added for dynamic menu listing (start) on 02.11.2019========   */ 
    $menu     =   $this->Master_model->get_menu($user_type_id); //print_r($menu);
    $data['menu'] = $menu;
    //print_r($menu);
    $data       =   $data + $this->data;
    /* ======Added for dynamic menu listing (end) on 02.11.2019========   */ 
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/sr',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function sr_inbox()
{
  $sess_usr_id   =   $this->session->userdata('int_userid');
  $user_type_id  = $this->session->userdata('int_usertype');
  $customer_id = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'sr_inbox', 'page' => 'sr_inbox', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Master_model');

    $initial_data         =   $this->Survey_model->get_process_flow_sr($sess_usr_id);
    $data['initial_data']   = $initial_data;
    //print_r($initial_data);
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/sr_inbox',$data);
  $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

/*___________________Form 1 forward to Chief surveyor/Surveyor______________*/	

public function Forward_Vessel()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');


  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'Forward_Vessel', 'page' => 'Forward_Vessel', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  

    $vessel_details			= 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']	=	$vessel_details;
    if($this->input->post())
    {

      date_default_timezone_set("Asia/Kolkata");
      $date                  	= 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
      $current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $status 			=	1;

      $status_details_sl=	$this->security->xss_clean($this->input->post('status_details_sl'));

      $task_pfid=$this->Survey_model->get_task_pfid($processflow_sl);
      $data['task_pfid']	=	$task_pfid;
      @$task_sl=$task_pfid[0]['task_sl'];

      //Form 1 Verification Reverted to CS
      if($process_id==1)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$current_position,
        'user_id'=>$user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);

        $data_survey_status=array(
        'current_status_id'=>$current_status_id,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_id);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        if($process_update && $process_insert && $status_update)
        {
          redirect("Kiv_Ctrl/Survey/SurveyHome");
        }
      }
      //Form 1 Keel,Hull,Final Reverted to CS
      if($process_id==2 || $process_id==3 || $process_id==4 )
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$current_position,
        'user_id'=>$user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);
        $data_survey_status=array(
        'current_status_id'=>$current_status_id,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_id);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();
        $data_task = array('process_flow_id'=>$processflow_id);

        $process_task=$this->Survey_model->update_task('tbl_kiv_task',$data_task, $task_sl);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        if($process_update && $process_insert && $status_update && $process_task)
        {
          redirect("Kiv_Ctrl/Survey/SurveyHome");
        }
      }
    }
  $this->load->model('Kiv_models/Survey_model');
  $this->load->view('Kiv_views/template/dash-header.php');
  $this->load->view('Kiv_views/template/nav-header.php');
  $this->load->view('Kiv_views/dash/Forward_Vessel',$data);
  $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function cs_InitialSurvey()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'cs_InitialSurvey', 'page' => 'cs_InitialSurvey', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_process_flow_cs($sess_usr_id);
    $data['initial_data']		=	$initial_data;
    @$id=$initial_data[0]['vessel_created_user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('template/header.php');
    $this->load->view('template/header_script_all.php');
    $this->load->view('template/header_include.php');
    $this->load->view('Kiv_views/Survey/cs_InitialSurvey',$data);
    $this->load->view('template/copyright.php');
    $this->load->view('template/footer_script_all.php');
    $this->load->view('template/footer_include_all.php');
    $this->load->view('template/footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
/*_____________________Form 1 verified by Chief surveyor/Surveyor__________________*/	
public function Verify_Vessel()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'Verify_Vessel', 'page' => 'Verify_Vessel', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    $vessel_details				= 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']		=	$vessel_details;

    @$id 						=	$vessel_details[0]['vessel_created_user_id'];
    $customer_details 			=	$this->Survey_model->get_customer_details($id);
    $data['customer_details']	=	$customer_details;
   
    $current_status 			=	$this->Survey_model->get_status();
    $data['current_status']		=	$current_status;

    //----------Vessel Details--------//
    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;
    /*$vessel_name        = $vessel_details_viewpage[0]['vessel_name'];
    $portofregistry_sl  = $vessel_details_viewpage[0]['vessel_registry_port_id'];
    $registry_port_id   =   $this->Survey_model->get_registry_port_id($portofregistry_sl);
    $data['registry_port_id'] =   $registry_port_id;
    if(!empty($registry_port_id))
    {
      $port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
    }
    else
    {
      $port_of_registry_name="";
    }*/
    //----------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']		=	$hull_details;

      //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']	=	$engine_details;

    //---------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details']	=	$equipment_details;

    //--------------Documents-----------------//
    $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel($vessel_id,$survey_id);
    $data['list_document_vessel']		=	$list_document_vessel;

    //-------------------Survey Activity-----------------//
    $survey_activity_process	= 	$this->Survey_model->get_survey_activity_keel_count($vessel_id,$survey_id);
    $data['survey_activity_process']	=	$survey_activity_process;
    @$keel_count							=	$survey_activity_process[0]['keel_count'];

    //No keeling 
    if(@$keel_count==0)
    {
      $survey_activity        		=   $this->Survey_model->get_survey_activity();
      $data['survey_activity']    	= $survey_activity;
    
    }
    else    //check keeling approve
    {
      $survey_activity_process1				= 	$this->Survey_model->get_survey_activity_approve($vessel_id,2,5,$survey_id);
      $data['survey_activity_process1']		=	$survey_activity_process1;
      @$keel_approve_count					=	$survey_activity_process1[0]['approve_count']; 

      if(@$keel_approve_count==0)  //not approved
      {
        $survey_activity        			=   $this->Survey_model->get_survey_activity1(2);
        $data['survey_activity']    = 	$survey_activity;
      }
      else //if keel approve check hull count
      {
        $survey_activity_process= 	$this->Survey_model->get_survey_activity_hull_count($vessel_id,$survey_id);
        $data['survey_activity_process']	=	$survey_activity_process;
        @$hull_count 						=	$survey_activity_process[0]['hull_count'];

        if(@$hull_count==0) //no hull inspection
        {
          $survey_activity        	=   $this->Survey_model->get_survey_activity2();
          $data['survey_activity']    	= 	$survey_activity;
        }
        else  //
        {
          $survey_activity_process1=$this->Survey_model->get_survey_activity_approve($vessel_id,3,5,$survey_id);
          $data['survey_activity_process1']		=	$survey_activity_process1;
          @$hull_approve_count					=	$survey_activity_process1[0]['approve_count']; 
        }
        if(@$hull_approve_count==0)
        {
          $survey_activity        			=   $this->Survey_model->get_survey_activity1(3);
          $data['survey_activity']    		= 	$survey_activity;
        }
        else
        {
          $survey_activity        			=   $this->Survey_model->get_survey_activity1(4);
          $data['survey_activity']    		= 	$survey_activity;
        }
      }
    }
    //-------------Survey Activity End----------------------//
    $surveyor_details					= 	$this->Survey_model->get_surveyor_details();
    $data['surveyor_details']			=	$surveyor_details;


    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date                  	= 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $user_type_id1 		=	$this->security->xss_clean($this->input->post('user_type_id')); 
      $status 			=	1;
      $remarks 			=	$this->security->xss_clean($this->input->post('remarks'));
      $remarks_date		=	date('Y-m-d');
      $surveyactivity_id	=	$this->security->xss_clean($this->input->post('surveyactivity_id')); 
      $forward_to	=	$this->security->xss_clean($this->input->post('forward_to')); 
      $inspection_date1 	=	$this->security->xss_clean($this->input->post('inspection_date'));
      $inspection_date2 = str_replace('/', '-', $inspection_date1);
      $inspection_date = date("Y-m-d", strtotime($inspection_date2));
      $inspection_date3 = date("d-m-Y", strtotime($inspection_date2));
      
      $status_details_sl=	$this->security->xss_clean($this->input->post('status_details_sl'));

      /*__________________________________email/sms data collection start___________________________*/
      $customer_details       = $this->Survey_model->get_customer_details($user_id);
      $data['customer_details'] = $customer_details;
      $owner_name         = $customer_details[0]['user_name'];
      $user_mobile_number = $customer_details[0]['user_mobile_number'];
      $user_email         = $customer_details[0]['user_email'];

      $vessel_details_viewpage      =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
      $data['vessel_details_viewpage']  = $vessel_details_viewpage;
      $vessel_name        = $vessel_details_viewpage[0]['vessel_name'];
      $portofregistry_sl  = $vessel_details_viewpage[0]['vessel_registry_port_id'];
      $registry_port_id   =   $this->Survey_model->get_registry_port_id($portofregistry_sl);
      $data['registry_port_id'] =   $registry_port_id;
      if(!empty($registry_port_id))
      {
        $port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
      }
      else
      {
        $port_of_registry_name="";
      }
    
      $ref_process_id=1;
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
      $surveyactivity=$this->Survey_model->get_survey_activity1($surveyactivity_id);
      $data['surveyactivity']        =   $surveyactivity;
      if(!empty($surveyactivity))
      {
        $surveyactivity_name=$surveyactivity[0]['surveyactivity_name'];
      }
      else
      {
        $surveyactivity_name="";
      }
     
      /*__________________________________email/sms data collection end___________________________*/
      //Revert to Vessel Owner
      if($current_status_id==4)
      {
        $data_insert=array(
        'vessel_id' 		=>	$vessel_id,
        'process_id' 		=>	$process_id,
        'survey_id'			=>	$survey_id,
        'current_status_id'	=>	$current_status_id,
        'current_position'	=>	$user_type_id1,
        'user_id'			=>	$user_id,
        'previous_module_id'=>	$processflow_sl,
        'status'			=>	$status,
        'status_change_date'=>	$status_change_date);
        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();
        $data_remarks = array(
        'sending_user_id' 	=> 	$processflow_sl,
        'receiving_user_id'	=> 	$processflow_id,
        'process_id'		=>	$process_id,
        'remarks_date'		=> 	$remarks_date,
        'remarks'			=>	$remarks,
        'entry_timestamp'	=>	$date);

        $data_survey_status=array(
        'current_status_id'	=>	$current_status_id,
        'sending_user_id'	=>	$sess_usr_id,
        'receiving_user_id'	=>	$user_id);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);
        if($process_update && $process_insert && $remarks_insert && $status_update)
        {
          redirect("Kiv_Ctrl/Survey/csHome");
        }
      }
      //-----------------------------End--------------------------------------//
      //Approve and assign Survey Activity for Chief Surveyor
      if($current_status_id==5)
      {
        //echo $current_status_id;
       //exit;
        //Approve Form 1
        $data_insert=array(
        'vessel_id'			=>	$vessel_id,
        'process_id'    =>  $process_id,
        //'process_id'    =>  $surveyactivity_id,
        'survey_id'			=>	$survey_id,
        'current_status_id'	=>	$current_status_id,
        'current_position'	=>	$user_type_id,
        'user_id'			=>	$sess_usr_id,
        'previous_module_id'=>	$processflow_sl,
        'status'			=>	0,
        'status_change_date'=>	$status_change_date);
        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();
        $data_remarks = array(
        'sending_user_id' 	=> 	$processflow_sl,
        'receiving_user_id'	=> 	$processflow_id,
        'process_id'		=>	$process_id,
        //'process_id'    	=>  $surveyactivity_id,
        'remarks_date'		=> 	$remarks_date,
        'remarks'			=>	$remarks,
        'entry_timestamp'	=>	$date);
        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);
        //-----Forward Survey Activity start-------//
        $data_insert_surveyactivity=array(
        'vessel_id'			=>	$vessel_id,
        'process_id'		=>	$surveyactivity_id,
        'survey_id'			=>	$survey_id,
        'current_status_id'	=>	2,
        /*'current_position'	=>	$user_type_id,
        'user_id'			=>	$sess_usr_id,*/
        'current_position'	=>	$user_type_id1,
        'user_id'			=>	$user_id,
        'previous_module_id'=>	$processflow_sl,
        'status'			=>	$status,
        'status_change_date'=>	$status_change_date);

        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);
        $processflow_id_surveyactivity 		= 	$this->db->insert_id();
        $data_remarks_surveyactivity = array(
        'sending_user_id' 		=> 	$processflow_sl,
        'receiving_user_id'		=> 	$processflow_id_surveyactivity,
        //'process_id'			=>	$surveyactivity_id,
        'process_id'			=>	$process_id,
        'remarks_date'			=> 	$remarks_date,
        'remarks'				=>	$remarks,
        'entry_timestamp'		=>	$date);

        $data_survey_status=array(
        'process_id'		=>	$surveyactivity_id,
        'current_status_id'	=>	2,
        'sending_user_id'	=>	$sess_usr_id,
        //'receiving_user_id'	=>	$sess_usr_id
        'receiving_user_id'	=>	$user_id);

        $data_task=array(
        'process_flow_id'	=>	$processflow_id_surveyactivity,
        'assign_date'		=>	$inspection_date,
        'status'			=>	1);

        $data_dte=array(
        'vessel_id'		=>	$vessel_id,
        'process_id'	=>	$surveyactivity_id,
        //'process_id'	=>	$process_id,
        'survey_id'		=>	$survey_id,
        'activity_date'	=>	$inspection_date,
        'remarks'		=>	$remarks,
        'status'		=>	1);
        //_____________________________Email sending start_____________________________//
        $email_subject=$surveyactivity_name. " of ".$vessel_name." is scheduled on ".$inspection_date3."";
        $email_message="<div><h4>Dear ". $owner_name.",</h4><p>".$surveyactivity_name." of <b>".$vessel_name."</b> is scheduled on <b>".$inspection_date3."</b>. Ensure your availability for the same on the mentioned date. <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
        
        $saji_email="bssajitha@gmail.com";
        $this->emailSendFunction($saji_email,$email_subject,$email_message);
        //$this->emailSendFunction($user_email,$email_subject,$email_message);
        //___________________Email sending start___________________________________________//
        //____________________SMS sending start____________________________________________//
        $sms_message=$surveyactivity_name. "of ".$vessel_name." is scheduled on ".$inspection_date3.". Kindly confirm via portinfo.kerala.gov.in";
        $this->load->model('Kiv_models/Survey_model');
        $saji_mob="9847903241";
        //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
        //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
        //____________________SMS sending end________________________________________________//

        $data_insert=$this->Survey_model->insert_date('tbl_kiv_processactivity_date', $data_dte);
        $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);
        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        $remarks_insert_surveyactivity=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks_surveyactivity);

        if($process_update && $process_insert && $remarks_insert && $process_insert_surveyactivity && $remarks_insert_surveyactivity && $status_update)
        {
        //redirect("Kiv_Ctrl/Survey/cs_InitialSurvey");
          redirect("Kiv_Ctrl/Survey/csHome");
        }
      }
      //--End---//
      //Reject Application
      if($current_status_id==3)
      {
        $data_insert=array(
        'vessel_id'			=>	$vessel_id,
        'process_id'		=>	$process_id,
        'survey_id'			=>	$survey_id,
        'current_status_id'	=>	$current_status_id,
        'current_position'	=>	$user_type_id,
        'user_id'			=>	$user_id,
        'previous_module_id'=>	$processflow_sl,
        'status'			=>	0,
        'reject_status'		=>	1,
        'status_change_date'=>	$status_change_date);

        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();
        $data_remarks = array(
        'sending_user_id' 	=> 	$processflow_sl,
        'receiving_user_id'	=> 	$processflow_id,
        'process_id'		=>	$process_id,
        'remarks_date'		=> 	$remarks_date,
        'remarks'			=>	$remarks,
        'entry_timestamp'	=>	$date);


        $data_survey_status=array(
        'current_status_id'	=>	$current_status_id,
        'sending_user_id'	=>	$sess_usr_id,
        'receiving_user_id'	=>	$user_id);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);
        if($process_update && $process_insert && $remarks_insert && $status_update)
        {
          redirect("Kiv_Ctrl/Survey/csHome");
        }
      }
      //Approve and forward to Surveyor
      if($current_status_id==6)
      {
        //Approve Form 1
        $data_insert=array(
        'vessel_id'			=>	$vessel_id,
        'process_id'		=>	$process_id,
        'survey_id'			=>	$survey_id,
        'current_status_id'	=>	5,
        'current_position'	=>	$user_type_id,
        'user_id'			=>	$sess_usr_id,
        'previous_module_id'=>	$processflow_sl,
        'status'			=>	0,
        'status_change_date'=>	$status_change_date);

        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();
        $data_remarks = array(
        'sending_user_id' 		=> 	$processflow_sl,
        'receiving_user_id'		=> 	$processflow_id,
        'process_id'			=>	$process_id,
        'remarks_date'			=> 	$remarks_date,
        'remarks'				=>	$remarks,
        'entry_timestamp'		=>	$date);

        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);
        //Forward Survey Activity
        $data_insert_surveyactivity=array(
        'vessel_id'			=>	$vessel_id,
        'process_id'		=>	$surveyactivity_id,
        'survey_id'			=>	$survey_id,
        'current_status_id'	=>	2,
        'current_position'	=>	13,
        'user_id'			=>	$forward_to,
        'previous_module_id'=>	$processflow_sl,
        'status'			=>	$status,
        'status_change_date'=>	$status_change_date);

        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);
        $processflow_id_surveyactivity 		= 	$this->db->insert_id();

        $data_remarks_surveyactivity = array(
        'sending_user_id' 	=> 	$processflow_sl,
        'receiving_user_id'	=> 	$processflow_id_surveyactivity,
        'process_id'		=>	$surveyactivity_id,
        'remarks_date'		=> 	$remarks_date,
        'remarks'			=>	$remarks,
        'entry_timestamp'	=>	$date);

         $data_survey_status=array(
        'process_id'		     =>	$surveyactivity_id,	
        'current_status_id'	 =>	$current_status_id,
        'sending_user_id'	   =>	$sess_usr_id,
        'receiving_user_id'	 =>	$forward_to);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        $remarks_insert_surveyactivity=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks_surveyactivity);
        if($process_update && $process_insert && $remarks_insert && $process_insert_surveyactivity && $remarks_insert_surveyactivity)
        {
          redirect("Kiv_Ctrl/Survey/csHome");
        }
      }
    }
  $this->load->view('Kiv_views/template/dash-header.php');
  $this->load->view('Kiv_views/template/nav-header.php');
  $this->load->view('Kiv_views/dash/Verify_Vessel',$data);
  $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
  redirect('Main_login/index');        
  }
}
/*___________________ Chief surveyor activities__________________________________*/	

public function csActivities()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'csActivities', 'page' => 'csActivities', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $initial_data			    = 	$this->Survey_model->get_process_flow_cs($sess_usr_id);
    $data['initial_data']		=	$initial_data;
    $count	= count($initial_data);
    $data['count']=$count;

    @$id=$initial_data[0]['vessel_created_user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $data_task=$this->Survey_model->get_task($sess_usr_id);
    $data['data_task']		=	$data_task;

    $count_task	= count($data_task);
    $data['count_task']=$count_task;
    @$id1=$data_task[0]['vessel_created_user_id'];
    $customer_details1=$this->Survey_model->get_customer_details($id1);
    $data['customer_details1']=$customer_details1;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/csActivities',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
/*____________________________________ surveyor activities___________________________*/	
public function srActivities()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'srActivities', 'page' => 'srActivities', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_process_flow_sr($sess_usr_id);
    $data['initial_data']		=	$initial_data;
    $count	= count($initial_data);
    $data['count']=$count;

    @$id=$initial_data[0]['vessel_created_user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $data_task=$this->Survey_model->get_task($sess_usr_id);
    $data['data_task']		=	$data_task;

    $count_task	= count($data_task);
    $data['count_task']=$count_task;

    @$id1=$data_task[0]['vessel_created_user_id'];

    $customer_details1=$this->Survey_model->get_customer_details($id1);
    $data['customer_details1']=$customer_details1;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/srActivities',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

//-------------Verification by Surveyor------------------------------//
public function Verify_Vessel_surveyor()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'Verify_Vessel_surveyor', 'page' => 'Verify_Vessel_surveyor', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    $vessel_details				= 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']		=	$vessel_details;

    @$id 						=	$vessel_details[0]['vessel_created_user_id'];
    @$process_id 						=	$vessel_details[0]['process_id'];
    @$survey_id 						=	$vessel_details[0]['survey_id'];

    $customer_details 			=	$this->Survey_model->get_customer_details($id);
    $data['customer_details']	=	$customer_details;

    if($process_id==4)
    {
      $current_status 			=	$this->Survey_model->get_status_sr1();
      $data['current_status']		=	$current_status;
    }
    else
    {
      $current_status 			=	$this->Survey_model->get_status_sr();
      $data['current_status']		=	$current_status;
    }

    $processactivity_date 				=	$this->Survey_model->get_processactivity_date($vessel_id,$survey_id);
    $data['processactivity_date']		=	$processactivity_date;

    //----------Vessel Details--------//
    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;

    //----------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']		=	$hull_details;

    //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']	=	$engine_details;

    //----------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details']	=	$equipment_details;

    //--------------Documents-----------------//
    $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']		=	$list_document_vessel;

    //----------Survey Activity Start------------------//

    //-------------------Survey Activity-----------------//

    $survey_activity_process	= 	$this->Survey_model->get_survey_activity_keel_count($vessel_id,$survey_id);
    $data['survey_activity_process']		=	$survey_activity_process;
    @$keel_count							=	$survey_activity_process[0]['keel_count'];

    //No keeling 
    if(@$keel_count==0)
    {
      $survey_activity        		=   $this->Survey_model->get_survey_activity();
      $data['survey_activity']    	= $survey_activity;
    }
    else    //check keeling approve
    {
      $survey_activity_process1= 	$this->Survey_model->get_survey_activity_approve($vessel_id,2,5,$survey_id);
      $data['survey_activity_process1']		=	$survey_activity_process1;
      @$keel_approve_count					=	$survey_activity_process1[0]['approve_count']; 

      if(@$keel_approve_count==0)  //not approved
      {
        $survey_activity        			=   $this->Survey_model->get_survey_activity1(3);
        $data['survey_activity']    		= 	$survey_activity;
      }
      else //if keel approve check hull count
      {
        $survey_activity_process= 	$this->Survey_model->get_survey_activity_hull_count($vessel_id,$survey_id);
        $data['survey_activity_process']	=	$survey_activity_process;
        @$hull_count 						=	$survey_activity_process[0]['hull_count'];

        if(@$hull_count==0) //no hull inspection
        {
          $survey_activity        		=   $this->Survey_model->get_survey_activity2();
          $data['survey_activity']    	= 	$survey_activity;
          // print_r($survey_activity);
        }
        else  //
        {
          $survey_activity_process1	=$this->Survey_model->get_survey_activity_approve($vessel_id,3,5,$survey_id);
          $data['survey_activity_process1']		=	$survey_activity_process1;
          @$hull_approve_count					=	$survey_activity_process1[0]['approve_count']; 
        }
        if(@$hull_approve_count==0)
        {
        	$survey_activity        			=   $this->Survey_model->get_survey_activity1(3);
          $data['survey_activity']    		= 	$survey_activity;
        }
        else
        {
        	$survey_activity        			=   $this->Survey_model->get_survey_activity1(4);
          $data['survey_activity']    		= 	$survey_activity;
        }
      }
    }
    //------------Survey Activity End-------------------------//
    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date                  	= 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $user_type_id1 		=	$this->security->xss_clean($this->input->post('user_type_id')); 
      $status 			=	1;
      $remarks 			=	$this->security->xss_clean($this->input->post('remarks'));
      $remarks_date		=	date('Y-m-d');

      $surveyactivity_id	=	$this->security->xss_clean($this->input->post('surveyactivity_id')); 
      $forward_to	=	$this->security->xss_clean($this->input->post('forward_to')); 
      $inspection_date1 	=	$this->security->xss_clean($this->input->post('inspection_date'));
      $inspection_date2 = str_replace('/', '-', $inspection_date1);
      $inspection_date = date("Y-m-d", strtotime($inspection_date2));
      $status_details_sl=	$this->security->xss_clean($this->input->post('status_details_sl'));

     
      

      //Revert to Vessel Owner
      if($current_status_id==4)
      {
        $data_insert=array(
        'vessel_id' 		=>	$vessel_id,
        'process_id' 		=>	$process_id,
        'survey_id'			=>	$survey_id,
        'current_status_id'	=>	$current_status_id,
        'current_position'	=>	$user_type_id1,
        'user_id'			=>	$user_id,
        'previous_module_id'=>	$processflow_sl,
        'status'			=>	$status,
        'status_change_date'=>	$status_change_date);
        $data_update = array('status'=>0);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();
        $data_remarks = array(
        'sending_user_id' 	=> 	$processflow_sl,
        'receiving_user_id'	=> 	$processflow_id,
        'process_id'		=>	$process_id,
        'remarks_date'		=> 	$remarks_date,
        'remarks'			=>	$remarks,
        'entry_timestamp'	=>	$date);

        $data_survey_status=array(
        'current_status_id'	=>	$current_status_id,
        'sending_user_id'	=>	$sess_usr_id,
        'receiving_user_id'	=>	$user_id);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

        $data_task=array(
        'process_flow_id'	=>	$processflow_id,
        'assign_date'		=>	$inspection_date,
        'status'			=>	1 );

        $data_dte=array(
        'vessel_id'		=>	$vessel_id,
        'process_id'	=>	$process_id,
        'survey_id'		=>	$survey_id,
        'activity_date'	=>	$inspection_date,
        'remarks'		=>	$remarks,
        'status'		=>	1);
        $data_insert=$this->Survey_model->insert_date('tbl_kiv_processactivity_date', $data_dte);
        $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);
        if($process_update && $process_insert && $remarks_insert && $status_update && $data_insert && $task_insert)
        {
          redirect("Kiv_Ctrl/Survey/SurveyorHome");
        }
      }
      //Approve and assign Survey Activity for Chief Surveyor

      if($current_status_id==5)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>0,
        'status_change_date'=>$status_change_date);

        $data_insert_surveyactivity=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$surveyactivity_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>2,
        /*'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,*/
        'current_position'	=>	$user_type_id1,
        'user_id'			=>	$user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_survey_status=array(
        'process_id'		=>$surveyactivity_id,
        'current_status_id'	=>2,
        'sending_user_id'	=>$sess_usr_id,
        'receiving_user_id'	=>$user_id);

        $data_update = array('status'=>0);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();

        $data_remarks = array(
        'sending_user_id' => $processflow_sl,
        'receiving_user_id'=> $processflow_id,
        'process_id'=>$process_id,
        'remarks_date'=> $remarks_date,
        'remarks'=>$remarks,
        'entry_timestamp'=>$date);

        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);
        $processflow_id_surveyactivity 		= 	$this->db->insert_id();

        $data_remarks_surveyactivity = array(
        'sending_user_id' 		=> $processflow_sl,
        'receiving_user_id'		=> $processflow_id_surveyactivity,
        'process_id'			=>$surveyactivity_id,
        'remarks_date'			=> $remarks_date,
        'remarks'				=>$remarks,
        'entry_timestamp'		=>$date);

        $data_task=array(
        'process_flow_id'		=>$processflow_id_surveyactivity,
        'assign_date'	=>$inspection_date,
        'status'	=>1);

        $data_dte=array(
        'vessel_id'		=>$vessel_id,
        'process_id'	=>$surveyactivity_id,
        //'process_id'	=>$process_id,
        'survey_id'		=>$survey_id,
        'activity_date'	=>$inspection_date,
        'remarks'		=>$remarks,
        'status'	=>1);
       
        $data_insert=$this->Survey_model->insert_date('tbl_kiv_processactivity_date', $data_dte);
        $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        $remarks_insert_surveyactivity=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks_surveyactivity);
        if($process_update && $process_insert && $remarks_insert && $process_insert_surveyactivity && $remarks_insert_surveyactivity && $status_update)
        {
          redirect("Kiv_Ctrl/Survey/SurveyorHome");
        }

      }
      //----------------------End--------------------------------------------//
    }	
  $this->load->view('Kiv_views/template/dash-header.php');
  $this->load->view('Kiv_views/template/nav-header.php');
  $this->load->view('Kiv_views/dash/Verify_Vessel_surveyor',$data);
  $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

//------------------------End-----------------------------------------//
public function rejectedApplication()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'rejectedApplication', 'page' => 'rejectedApplication', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_process_flow_application(3);
    $data['initial_data']		=	$initial_data;

    @$id=$initial_data[0]['vessel_created_user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('Kiv_views/template/header.php');
    $this->load->view('Kiv_views/template/header_script_all.php');
    $this->load->view('Kiv_views/template/header_include.php');
    $this->load->view('Kiv_views/Survey/rejectedApplication',$data);
    $this->load->view('Kiv_views/template/copyright.php');
    $this->load->view('Kiv_views/template/footer_script_all.php');
    $this->load->view('Kiv_views/template/footer_include_all.php');
    $this->load->view('Kiv_views/template/footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function ApprovedApplication()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'ApprovedApplication', 'page' => 'ApprovedApplication', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_process_flow_application(5);
    $data['initial_data']		=	$initial_data;

    @$id=$initial_data[0]['vessel_created_user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('Kiv_views/emplate/header.php');
    $this->load->view('Kiv_views/template/header_script_all.php');
    $this->load->view('Kiv_views/template/header_include.php');
    $this->load->view('Kiv_views/Survey/ApprovedApplication',$data);
    $this->load->view('Kiv_views/template/copyright.php');
    $this->load->view('Kiv_views/template/footer_script_all.php');
    $this->load->view('Kiv_views/template/footer_include_all.php');
    $this->load->view('Kiv_views/template/footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
/*_______________________________Chief surveyor task___________________________*/	
public function csTask()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id		=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 


  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'csTask', 'page' => 'csTask', 'errorCls' => NULL, 'post' => $this->input->post());
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    $vessel_details				= 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']		=	$vessel_details;

    @$id 						=	$vessel_details[0]['vessel_created_user_id'];
    $vessel_id 					=	$vessel_details[0]['vessel_sl'];
    $process_id 				=	$vessel_details[0]['process_id'];


    $customer_details 			=	$this->Survey_model->get_customer_details($id);
    $data['customer_details']	=	$customer_details;
    $owner_name         = $customer_details[0]['user_name'];
    $user_mobile_number = $customer_details[0]['user_mobile_number'];
    $user_email         = $customer_details[0]['user_email'];
    if($process_id==4)
    {
      $current_status 			=	$this->Survey_model->get_status_cs_sr1();
      $data['current_status']	=	$current_status;
    }
    else
    {
      $current_status 			=	$this->Survey_model->get_status_cs_sr();
      $data['current_status']		=	$current_status;
    }

    //----------Vessel Details--------//
    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;
    $vessel_name        = $vessel_details_viewpage[0]['vessel_name'];
    $portofregistry_sl  = $vessel_details_viewpage[0]['vessel_registry_port_id'];
    $registry_port_id   =   $this->Survey_model->get_registry_port_id($portofregistry_sl);
    $data['registry_port_id'] =   $registry_port_id;
    if(!empty($registry_port_id))
    {
      $port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
    }
    else
    {
      $port_of_registry_name="";
    }

    //----------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']		=	$hull_details;

    //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']	=	$engine_details;

    //----------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details']	=	$equipment_details;

    //--------------Documents-----------------//
    $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']		=	$list_document_vessel;

    //-------------------Survey Activity-----------------//
    $survey_activity_process				= 	$this->Survey_model->get_survey_activity_keel_count($vessel_id,$survey_id);
    $data['survey_activity_process']		=	$survey_activity_process;
    @$keel_count							=	$survey_activity_process[0]['keel_count'];

    //No keeling 
    if(@$keel_count==0)
    {
      $survey_activity        		=   $this->Survey_model->get_survey_activity();
      $data['survey_activity']    	= 	$survey_activity;
    }
    else    //check keeling approve
    {
      $survey_activity_process1				= 	$this->Survey_model->get_survey_activity_approve($vessel_id,5,2,$survey_id);
      $data['survey_activity_process1']		=	$survey_activity_process1;
      @$keel_approve_count					=	$survey_activity_process1[0]['approve_count']; 
      if(@$keel_approve_count==0)  //not approved
      {
        $survey_activity        			=   $this->Survey_model->get_survey_activity2();
        $data['survey_activity']    		= 	$survey_activity;
      }
      else //if keel approve check hull count
      {
        $survey_activity_process=$this->Survey_model->get_survey_activity_hull_count($vessel_id,$survey_id);
        $data['survey_activity_process']	=	$survey_activity_process;
        @$hull_count 						=	$survey_activity_process[0]['hull_count'];
        if(@$hull_count==0) //no hull inspection
        {
          $survey_activity        		=   $this->Survey_model->get_survey_activity2();
          $data['survey_activity']    	= 	$survey_activity;
          //print_r($survey_activity);
        }
        else  //
        {
          $survey_activity_process1= 	$this->Survey_model->get_survey_activity_approve($vessel_id,5,3,$survey_id);
          $data['survey_activity_process1']		=	$survey_activity_process1;
          @$hull_approve_count					=	$survey_activity_process1[0]['approve_count']; 
        }
        if(@$hull_approve_count==0)
        {
          //$survey_activity        			=   $this->Survey_model->get_survey_activity1(3);
          $survey_activity        		=   $this->Survey_model->get_survey_activity2();
          $data['survey_activity']    		= 	$survey_activity;
        }
        else
        {
          $survey_activity        			=   $this->Survey_model->get_survey_activity1(4);
          $data['survey_activity']    		= 	$survey_activity;
        }
      }
    }
    $surveyor_details					= 	$this->Survey_model->get_surveyor_details();
    $data['surveyor_details']			=	$surveyor_details;
    $processactivity_date 				=	$this->Survey_model->get_processactivity_date($vessel_id,$survey_id);
    $data['processactivity_date']		=	$processactivity_date;
    $data 			=	 $data + $this->data;
    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date               = 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
      $current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $user_type_id1 		=	$this->security->xss_clean($this->input->post('user_type_id'));
      $status 			=	1;
      $remarks 			=	$this->security->xss_clean($this->input->post('remarks'));

      $status_details_sl 		=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $surveyactivity_id 		=	$this->security->xss_clean($this->input->post('surveyactivity_id'));

      $inspection_date1 		=	$this->security->xss_clean($this->input->post('inspection_date'));
      $inspection_date2 		= 	str_replace('/', '-', $inspection_date1);
      $inspection_date 		= 	date("Y-m-d", strtotime($inspection_date2));
      $inspection_date3    =   date("d-m-Y", strtotime($inspection_date2));
      $remarks_date   = date('Y-m-d');
      $forward_to = $this->security->xss_clean($this->input->post('forward_to'));

      /*__________________________________email/sms data collection start___________________________*/
          
      $ref_process_id=1;
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
      $surveyactivity=$this->Survey_model->get_survey_activity1(4);
      $data['surveyactivity']        =   $surveyactivity;
      if(!empty($surveyactivity))
      {
        $surveyactivity_name=$surveyactivity[0]['surveyactivity_name'];
      }
      else
      {
        $surveyactivity_name="";
      }
      /*__________________________________email/sms data collection end___________________________*/

      // Approve
      if($current_status_id==5)
      {
        //Approve Final Inspection
        if($process_id==4)	
        {	
          $data_insert=array(
          'vessel_id'=>$vessel_id,
          'process_id'=>$process_id,
          'survey_id'=>$survey_id,
          'current_status_id'=>$current_status_id,
          'current_position'=>$user_type_id,
          'user_id'=>$sess_usr_id,
          'previous_module_id'=>$processflow_sl,
          'status'=>0,
          'status_change_date'=>$status_change_date);

          $data_update = array('status'=>0);
          $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
          $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
          $processflow_id 		= 	$this->db->insert_id();
          $new_process_id=5;

          $data_insert_surveyactivity=array(
          'vessel_id'=>$vessel_id,
          'process_id'=>$new_process_id,
          'survey_id'=>$survey_id,
          'current_status_id'=>1,
          'current_position'=>$user_type_id1,
          'user_id'=>$user_id,
          'previous_module_id'=>$processflow_sl,
          'status'=>$status,
          'status_change_date'=>$status_change_date);

          $data_remarks = array(
          'sending_user_id' => $processflow_sl,
          'receiving_user_id'=> $processflow_id,
          'process_id'=>$process_id,
          'remarks_date'=> $remarks_date,
          'remarks'=>$remarks,
          'entry_timestamp'=>$date);

          $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);

          $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

          $data_survey_status=array(
          'process_id'		=>$new_process_id,
          'current_status_id'	=>1,
          'sending_user_id'	=>$user_type_id1,
          'receiving_user_id'	=>$user_id);
          $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
          //_____________________________Email sending start_____________________________//
          $email_subject=$surveyactivity_name." of ".$vessel_name." is approved";
          $email_message="<div><h4>Dear ". $owner_name.",</h4><p>".$surveyactivity_name." of ".$vessel_name." is approved. Kindly submit Form 3 for further processing by logging into portinfo.kerala.gov.in.  <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
          $saji_email="bssajitha@gmail.com";
          $this->emailSendFunction($saji_email,$email_subject,$email_message);
          //$this->emailSendFunction($user_email,$email_subject,$email_message);
          //___________________Email sending start___________________________________________//
          //____________________SMS sending start____________________________________________//
          $sms_message=$surveyactivity_name. " of ".$vessel_name."  is approved. Submit Form 3 via portinfo.kerala.gov.in";
          $this->load->model('Kiv_models/Survey_model');
          $saji_mob="9847903241";
          //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
          //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
          //____________________SMS sending end________________________________________________//
          if($process_update && $process_insert && $remarks_insert  &&  $status_update)
          {
            redirect("Kiv_Ctrl/Survey/csHome");
          }
        }
        //Revert to owner
        else
        {
          $data_insert=array(
          'vessel_id'=>$vessel_id,
          'process_id'=>$process_id,
          'survey_id'=>$survey_id,
          'current_status_id'=>$current_status_id,
          'current_position'=>$user_type_id,
          'user_id'=>$sess_usr_id,
          'previous_module_id'=>$processflow_sl,
          'status'=>0,
          'status_change_date'=>$status_change_date);

          $data_insert_surveyactivity=array(
          'vessel_id'=>$vessel_id,
          'process_id'=>$surveyactivity_id,
          'survey_id'=>$survey_id,
          'current_status_id'=>2,
          /*'current_position'=>$user_type_id,
          'user_id'=>$sess_usr_id,*/
          'current_position'=>$user_type_id1,
          'user_id'=>$user_id,
          'previous_module_id'=>$processflow_sl,
          'status'=>$status,
          'status_change_date'=>$status_change_date);
          $data_survey_status=array(
          'process_id'		=>$surveyactivity_id,
          'current_status_id'	=>2,
          'sending_user_id'	=>$sess_usr_id,
          //'receiving_user_id'	=>$sess_usr_id
          'receiving_user_id'	=>$user_id);

          $data_update = array('status'=>0);

          $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
          $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

          $processflow_id 		= 	$this->db->insert_id();
          $data_remarks = array(
          'sending_user_id' => $processflow_sl,
          'receiving_user_id'=> $processflow_id,
          'process_id'=>$process_id,
          'remarks_date'=> $remarks_date,
          'remarks'=>$remarks,
          'entry_timestamp'=>$date);

          $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

          $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);

          $processflow_id_surveyactivity 		= 	$this->db->insert_id();

          $data_remarks_surveyactivity = array(
          'sending_user_id' 		=> $processflow_sl,
          'receiving_user_id'		=> $processflow_id_surveyactivity,
          'process_id'			=>$surveyactivity_id,
          'remarks_date'			=> $remarks_date,
          'remarks'				=>$remarks,
          'entry_timestamp'		=>$date);

          $data_task=array(
          'process_flow_id'		=>$processflow_id_surveyactivity,
          'assign_date'	=>$inspection_date,
          'status'	=>1);

          $data_dte=array(
          'vessel_id'		=>$vessel_id,
          'process_id'	=>$surveyactivity_id,
          //'process_id'	=>$process_id,
          'survey_id'		=>$survey_id,
          'activity_date'	=>$inspection_date,
          'remarks'		=>$remarks,
          'status'	=>1);

          $remarks1="Approved";

          $data_dte1=array(
          'vessel_id'		=>$vessel_id,
          'process_id'	=>$process_id,
          //'process_id'	=>$process_id,
          'survey_id'		=>$survey_id,
          'approved_date'	=>$inspection_date,
          'remarks'		=>$remarks1,
          'status'	=>1);

          $data_insert1=$this->Survey_model->insert_date('tbl_kiv_processactivity_date', $data_dte1);
          $data_insert=$this->Survey_model->insert_date('tbl_kiv_processactivity_date', $data_dte);

          $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);

          $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

          $remarks_insert_surveyactivity=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks_surveyactivity);
          //_____________________________Email sending start_____________________________//
          $email_subject=$surveyactivity_name. " of ".$vessel_name." is scheduled on ".$inspection_date3."";
          $email_message="<div><h4>Dear ". $owner_name.",</h4><p>".$surveyactivity_name." of <b>".$vessel_name."</b> is scheduled on <b>".$inspection_date3."</b>. Ensure your availability for the same on the mentioned date. <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
          $saji_email="bssajitha@gmail.com";
          $this->emailSendFunction($saji_email,$email_subject,$email_message);
          //$this->emailSendFunction($user_email,$email_subject,$email_message);
          //___________________Email sending start___________________________________________//
          //____________________SMS sending start____________________________________________//
          $sms_message=$surveyactivity_name. "of ".$vessel_name." is scheduled on ".$inspection_date3.". Kindly confirm via portinfo.kerala.gov.in";
          $this->load->model('Kiv_models/Survey_model');
          $saji_mob="9847903241";
          //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
          //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
          //____________________SMS sending end________________________________________________//

          if($process_update && $process_insert && $remarks_insert && $process_insert_surveyactivity && $remarks_insert_surveyactivity && $status_update)
          {
            redirect("Kiv_Ctrl/Survey/csHome");
          }
        } 
      }
        //-- Approve End---//
        //Revert Keel Laying, Hull Inspection, Final Inspection
      if($current_status_id==4)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$user_type_id1,
        'user_id'=>$user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);
        $data_update = array('status'=>0);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();
        $data_remarks = array(
        'sending_user_id' => $processflow_sl,
        'receiving_user_id'=> $processflow_id,
        'process_id'=>$process_id,
        'remarks_date'=> $remarks_date,
        'remarks'=>$remarks,
        'entry_timestamp'=>$date);
        $data_survey_status=array(
        'current_status_id'=>$current_status_id,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_id);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

        $data_task=array(
        'process_flow_id'=>$processflow_id,
        'assign_date'=>$inspection_date,
        'status'	=>1);
        $data_dte=array(
        'vessel_id'		=>$vessel_id,
        'process_id'	=>$process_id,
        'survey_id'		=>$survey_id,
        'activity_date'	=>$inspection_date,
        'remarks'		=>$remarks,
        'status'	=>1);

        $data_insert=$this->Survey_model->insert_date('tbl_kiv_processactivity_date', $data_dte);
        $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);

        if($process_update && $process_insert && $remarks_insert && $status_update && $data_insert && $task_insert)
        {
          redirect("Kiv_Ctrl/Survey/csHome");
        }
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/csTask',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
/*_______________________________surveyor task___________________________*/	

public function srTask()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		   =	$this->session->userdata('customer_id');
  $survey_user_id		 =	$this->session->userdata('survey_user_id');
  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'srTask', 'page' => 'srTask', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  
    $this->load->model('Kiv_models/Function_model');

    $vessel_details				    = 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']		=	$vessel_details;

    @$id 						    =	$vessel_details[0]['vessel_created_user_id'];
    $vessel_id 					=	$vessel_details[0]['vessel_sl'];
    $process_id 				=	$vessel_details[0]['process_id'];
    $customer_details 			  =	$this->Survey_model->get_customer_details($id);
    $data['customer_details']	=	$customer_details;
    if($process_id==2 || $process_id==3)
    {
      $current_status 			    =	$this->Survey_model->get_status_cs_sr1();
      $data['current_status']	  =	$current_status;
    }
    else
    {
      $current_status 			=	$this->Survey_model->get_status_cs_sr2();
      $data['current_status']		=	$current_status;
    }
    //----------Vessel Details--------//
    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;

    //----------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']		=	$hull_details;

    //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']	=	$engine_details;

    //----------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details']	=	$equipment_details;

    //--------------Documents-----------------//
    $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']		=	$list_document_vessel;

    //-------------------Survey Activity-----------------//
    $survey_activity_process				= 	$this->Survey_model->get_survey_activity_keel_count($vessel_id,$survey_id);
    $data['survey_activity_process']		=	$survey_activity_process;
    @$keel_count							=	$survey_activity_process[0]['keel_count'];

    //No keeling 
    if(@$keel_count==0)
    {
      $survey_activity        		=   $this->Survey_model->get_survey_activity();
      $data['survey_activity']    	= 	$survey_activity;
    }
    else    //check keeling approve
    {
      $survey_activity_process1	= $this->Survey_model->get_survey_activity_approve($vessel_id,5,2,$survey_id);
      $data['survey_activity_process1']		=	$survey_activity_process1;
      @$keel_approve_count					=	$survey_activity_process1[0]['approve_count']; 
      if(@$keel_approve_count==0)  //not approved
      {
        $survey_activity        			=   $this->Survey_model->get_survey_activity2();
        $data['survey_activity']    		= 	$survey_activity;
      }
      else //if keel approve check hull count
      {
        $survey_activity_process= 	$this->Survey_model->get_survey_activity_hull_count($vessel_id,$survey_id);
        $data['survey_activity_process']	=	$survey_activity_process;
        @$hull_count 						=	$survey_activity_process[0]['hull_count'];
        if(@$hull_count==0) //no hull inspection
        {
          $survey_activity        		=   $this->Survey_model->get_survey_activity2();
          $data['survey_activity']    	= 	$survey_activity;
        }
        else  //
        {
          $survey_activity_process1= $this->Survey_model->get_survey_activity_approve($vessel_id,5,3,$survey_id);
          $data['survey_activity_process1']		=	$survey_activity_process1;
          @$hull_approve_count					=	$survey_activity_process1[0]['approve_count']; 
        }
        if(@$hull_approve_count==0)
        {
          $survey_activity        			=   $this->Survey_model->get_survey_activity1(4);
          $data['survey_activity']    		= 	$survey_activity;
        }
        else
        {
          $survey_activity        			=   $this->Survey_model->get_survey_activity1(3,4);
          $data['survey_activity']    		= 	$survey_activity;
        }
      }
    }
    $surveyor_details					= 	$this->Survey_model->get_surveyor_details();
    $data['surveyor_details']			=	$surveyor_details;

    $processactivity_date 				=	$this->Survey_model->get_processactivity_date($vessel_id,$survey_id);
    $data['processactivity_date']		=	$processactivity_date;

    $user_type_id_vessel_owner=11;
    $user_id_vessel_owner=$id;

    $user_type_id_cs=12;

    $user_id_cs   = $this->Survey_model->get_user_id_cs(12);
    $data['user_id_cs']    = $user_id_cs;
    if(!empty($user_id_cs)) 
    {
      $cs_user_id=$user_id_cs[0]['user_master_id'];
    }
    $data 			=	 $data + $this->data;
    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date               = 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
      $current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $user_type_id1 		=	$this->security->xss_clean($this->input->post('user_type_id'));
      $status 			=	1;
      $remarks 			=	$this->security->xss_clean($this->input->post('remarks'));
      $status_details_sl 		=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $surveyactivity_id 		=	$this->security->xss_clean($this->input->post('surveyactivity_id'));
      $inspection_date1 		=	$this->security->xss_clean($this->input->post('inspection_date'));
      $inspection_date2 		= 	str_replace('/', '-', $inspection_date1);
      $inspection_date 		= 	date("Y-m-d", strtotime($inspection_date2));
      $inspection_date3    =   date("d-m-Y", strtotime($inspection_date2));
      
      $remarks_date   = date('Y-m-d');
      // Approve
      if($current_status_id==5)
      {
       //Approve Final Inspection
        if($process_id==3)	
        {	
          //vessel owner
          $data_insert=array(
          'vessel_id'=>$vessel_id,
          'process_id'=>$process_id,
          'survey_id'=>$survey_id,
          'current_status_id'=>$current_status_id,
          'current_position'=>$user_type_id,
          'user_id'=>$sess_usr_id,
          'previous_module_id'=>$processflow_sl,
          'status'=>0,
          'status_change_date'=>$status_change_date);
          $data_update = array('status'=>0);
          $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
          $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
          $processflow_id 		= 	$this->db->insert_id();
          $new_process_id=4;

          $data_insert_surveyactivity=array(
          'vessel_id'=>$vessel_id,
          'process_id'=>$new_process_id,
          'survey_id'=>$survey_id,
          'current_status_id'=>2,
          'current_position'=>$user_type_id_cs,
          'user_id'=>$cs_user_id,
          'previous_module_id'=>$processflow_sl,
          'status'=>$status,
          'status_change_date'=>$status_change_date);

          $data_remarks = array(
          'sending_user_id' => $processflow_sl,
          'receiving_user_id'=> $processflow_id,
          'process_id'=>$process_id,
          'remarks_date'=> $remarks_date,
          'remarks'=>$remarks,
          'entry_timestamp'=>$date);

          $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);
          $processflow_id1     =   $this->db->insert_id();

          $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

          $data_survey_status=array(
          'process_id'		=>$new_process_id,
          'current_status_id'	=>2,
          'sending_user_id'	=>$sess_usr_id,
          'receiving_user_id'	=>$cs_user_id);
          $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

          $data_task=array(
          'process_flow_id'=>$processflow_id1,
          'assign_date'=>$inspection_date,
          'status'  =>1);

          $data_dte=array(
          'vessel_id'   =>$vessel_id,
          'process_id'  =>$process_id,
          'survey_id'   =>$survey_id,
          'activity_date' =>$inspection_date,
          'remarks'   =>$remarks,
          'status'  =>1);
          $data_insert=$this->Survey_model->insert_date('tbl_kiv_processactivity_date', $data_dte);
          $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);

          if($process_update && $process_insert && $remarks_insert  &&  $status_update)
          {
            redirect("Kiv_Ctrl/Survey/csHome");
          }
        }
        else
        { 
          $data_insert=array(
          'vessel_id'=>$vessel_id,
          'process_id'=>$process_id,
          'survey_id'=>$survey_id,
          'current_status_id'=>$current_status_id,
          'current_position'=>$user_type_id,
          'user_id'=>$sess_usr_id,
          'previous_module_id'=>$processflow_sl,
          'status'=>0,
          'status_change_date'=>$status_change_date);

          $data_insert_surveyactivity=array(
          'vessel_id'=>$vessel_id,
          'process_id'=>$surveyactivity_id,
          'survey_id'=>$survey_id,
          'current_status_id'=>2,
          /*'current_position'=>$user_type_id,
          'user_id'=>$sess_usr_id,*/
          'current_position'	=>	$user_type_id1,
          'user_id'			=>	$user_id,
          'previous_module_id'=>$processflow_sl,
          'status'=>$status,
          'status_change_date'=>$status_change_date);

          $data_survey_status=array(
          'process_id'		=>$surveyactivity_id,
          'current_status_id'	=>2,
          'sending_user_id'	=>$sess_usr_id,
          'receiving_user_id'	=>$user_id);

          $data_update = array('status'=>0);
          $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
          $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
          $processflow_id 		= 	$this->db->insert_id();

          $data_remarks = array(
          'sending_user_id' => $processflow_sl,
          'receiving_user_id'=> $processflow_id,
          'process_id'=>$process_id,
          'remarks_date'=> $remarks_date,
          'remarks'=>$remarks,
          'entry_timestamp'=>$date);

          $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

          $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);
          $processflow_id_surveyactivity 		= 	$this->db->insert_id();

          $data_remarks_surveyactivity = array(
          'sending_user_id' 		=> $processflow_sl,
          'receiving_user_id'		=> $processflow_id_surveyactivity,
          'process_id'			=>$surveyactivity_id,
          'remarks_date'			=> $remarks_date,
          'remarks'				=>$remarks,
          'entry_timestamp'		=>$date);
          $data_task=array(
          'process_flow_id'		=>$processflow_id_surveyactivity,
          'assign_date'	=>$inspection_date,
          'status'	=>1);

          $data_dte=array(
          'vessel_id'		=>$vessel_id,
          'process_id'	=>$surveyactivity_id,
          //'process_id'	=>$process_id,
          'survey_id'		=>$survey_id,
          'activity_date'	=>$inspection_date,
          'remarks'		=>$remarks,
          'status'	=>1);

          $data_insert=$this->Survey_model->insert_date('tbl_kiv_processactivity_date', $data_dte);
          $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);

          $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

          $remarks_insert_surveyactivity=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks_surveyactivity);

          if($process_update && $process_insert && $remarks_insert && $process_insert_surveyactivity && $remarks_insert_surveyactivity && $status_update)
          {
            redirect("Kiv_Ctrl/Survey/SurveyorHome");
          }
          } 
        } //-- Approve End---//
        //Revert Keel Laying, Hull Inspection, Final Inspection
      if($current_status_id==4)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$user_type_id1,
        'user_id'=>$user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);
        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();

        $data_remarks = array(
        'sending_user_id' => $processflow_sl,
        'receiving_user_id'=> $processflow_id,
        'process_id'=>$process_id,
        'remarks_date'=> $remarks_date,
        'remarks'=>$remarks,
        'entry_timestamp'=>$date);

        $data_survey_status=array(
        'current_status_id'=>$current_status_id,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_id);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

        $data_task=array(
        'process_flow_id'=>$processflow_id,
        'assign_date'=>$inspection_date,
        'status'	=>1);

        $data_dte=array(
        'vessel_id'		=>$vessel_id,
        'process_id'	=>$process_id,
        'survey_id'		=>$survey_id,
        'activity_date'	=>$inspection_date,
        'remarks'		=>$remarks,
        'status'	=>1);

        $data_insert=$this->Survey_model->insert_date('tbl_kiv_processactivity_date', $data_dte);
        $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);
        if($process_update && $process_insert && $remarks_insert && $status_update && $data_insert && $task_insert)
        {
          redirect("Kiv_Ctrl/Survey/SurveyorHome");
        }
      }    //-- Revert End---//
    }
  $this->load->view('Kiv_views/template/dash-header.php');
  $this->load->view('Kiv_views/template/nav-header.php');
  $this->load->view('Kiv_views/dash/srTask',$data);
  $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
/*_______________________________Form 3 load for owner___________________________*/	

public function Add_Form3()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id		=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'Add_Form3', 'page' => 'Add_Form3', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');
    $form_id=3;

    $vessel_details_dynamic=$this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_details_dynamic']	=	$vessel_details_dynamic;

    $bank         =   $this->Survey_model->get_bank_favoring();
    $data['bank']   = $bank;
    //print_r($vessel_details_dynamic);

    $vessel_type_id         =  $vessel_details_dynamic[0]['vessel_type_id'];
    $vessel_subtype_id      = $vessel_details_dynamic[0]['vessel_subtype_id'];
    $vessel_length          = $vessel_details_dynamic[0]['vessel_length'];
    $hullmaterial_id        = $vessel_details_dynamic[0]['hullmaterial_id'];
    $engine_placement_id    = $vessel_details_dynamic[0]['engine_placement_id'];

    $vessel_details       		=   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   	= 	$vessel_details;

    $vessel_total_tonnage 		=	$vessel_details[0]['vessel_total_tonnage'];
    $survey_id 					      =	$vessel_details[0]['survey_id'];

    $status_change_date1		=	$vessel_details[0]['status_change_date'];
    $status_change_date 		=	date("Y-m-d", strtotime($status_change_date1));
    $now						=	date("Y-m-d");

    $date1_ts    = strtotime($status_change_date);
    $date2_ts    = strtotime($now);
    $diff        = $date2_ts - $date1_ts;
    $numberofdays= round($diff / 86400);

    $tariff_dtls =  $this->Survey_model->get_tariff_dtls($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data['tariff_dtls'] = $tariff_dtls;

    if(!empty($tariff_dtls))
    {
      $tariff_tonnagetype_id=$tariff_dtls[0]['tariff_tonnagetype_id'];
      if($tariff_tonnagetype_id==3)
      {
        if($numberofdays<365)
        {
          $tariff_form3 =   $this->Survey_model->get_tariff_form3($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage,$numberofdays);
          $data['tariff_form3'] = $tariff_form3;
        }
        else
        {
          $tariff_form3 =   $this->Survey_model->get_tariff_form3_366($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
          $data['tariff_form3'] = $tariff_form3;
        }
      }
    }

    $this->session->set_userdata(array(
    'vessel_id'     => $vessel_id,
    'vessel_type_id'  =>$vessel_type_id,
    'vessel_subtype_id' =>$vessel_subtype_id,
    'vessel_length'=>$vessel_length,
    'engine_placement_id'=>$engine_placement_id,
    'hullmaterial_id'=>$hullmaterial_id)); 

    $heading_id2=18;
    $heading_id3=19;
    $heading_id4=20;

    $label_control_details_head2			= 	$this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id2);
    $data['label_control_details_head2']	=	$label_control_details_head2;
    //print_r($label_control_details_head2);

    $label_control_details_head3			= 	$this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id3);
    $data['label_control_details_head3']	=	$label_control_details_head3;

    $label_control_details_head4			= 	$this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id4);
    $data['label_control_details_head4']	=	$label_control_details_head4;
    //print_r($label_control_details_head4);
    $this->load->view('Kiv_views/template/form-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Add_Form3', $data);
    $this->load->view('Kiv_views/template/form-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

/*_______________________________form 3 basic details by owner_______________________*/	
function Form3_details_entry()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form1', 'page' => 'form1', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  

    $ip         =	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date      = 	date('Y-m-d h:i:s', time());
    $hdnvessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));
    $no_of_engineset 	=	$this->security->xss_clean($this->input->post('no_of_engineset'));
    $hdnsurvey_id      = $this->security->xss_clean($this->input->post('survey_id'));
    //Hull
    $hull_year_of_built =	$this->security->xss_clean($this->input->post('hull_year_of_built'));
    $hull_details=$this->Survey_model->get_hull_details_dynamic($hdnvessel_id,$hdnsurvey_id);
    $data['hull_details']	=	$hull_details;
    if (!empty($hull_details)) 
    {
      echo $hull_sl=$hull_details[0]['hull_sl'];
    }
    else
    {
      $hull_sl=0;
    }
    $random_number=rand(1,9);
    //--------------- Hull ------------//
    if(($_FILES['builder_certificate_document']['name'])!="")
    {
      $label_id=84;
      $cname="BC";
      $builder_certificate_document_name=$hdnvessel_id.'_'.$label_id.'_'.$random_number.'_'.$cname.'.pdf';
      copy($_FILES['builder_certificate_document']['tmp_name'], "./uploads/BuilderCertificate/".$builder_certificate_document_name);
    }
    else
    {
      $builder_certificate_document_name="";
    }
    if($hull_sl!=0)
    {
      $hull_data= array('hull_year_of_built' => $hull_year_of_built,
      'builder_certificate_document' => $builder_certificate_document_name,
      'hull_modified_user_id'=>$sess_usr_id,
      'hull_modified_timestamp'=>$date,
      'hull_modified_ipaddress'=>$ip);
      $update_hulldetails =$this->Survey_model->update_table_hull('tbl_kiv_hulldetails',$hull_data,$hull_sl);
    }
    //---------------Engine Start-----------------------//
    $engine_details=$this->Survey_model->get_engine_details_dynamic($hdnvessel_id,$hdnsurvey_id);
    $data['engine_details']	=	$engine_details;
    //print_r($engine_details);
    $hdn_engine_sl 	=	$this->security->xss_clean($this->input->post('hdn_engine_sl'));
    $make_year 		=	$this->security->xss_clean($this->input->post('make_year'));
    for($i=0;$i<$no_of_engineset;$i++)
    {
      $label_id=86;
      $cname="TC";
      $engine_sl=$hdn_engine_sl[$i];
      $make_year1=$make_year[$i];
      $test_certificate_upload[$i]=$hdnvessel_id.'_'.$label_id.'_'.$random_number.'_'.$cname. '_'.$engine_sl.'.pdf';
      $pdf_name=$test_certificate_upload[$i];
      if($pdf_name==true) 
      {
        $pdf_name=$pdf_name;
        copy($_FILES['test_certificate_upload'.$i]['tmp_name'], "./uploads/Test_Certificate/".$pdf_name);
      }
      else
      {
        $pdf_name="";
      }
      $engine_data= 	array(
      'make_year'=>$make_year1,
      'test_certificate_upload' 	=> $pdf_name,  
      'engine_modified_user_id' 	=>$sess_usr_id,
      'engine_modified_timestamp'	=>	$date,
      'engine_modified_ipaddress'	=>	$ip);
      // print_r($engine_data);
      $update_enginedetails=$this->Survey_model->update_table_engine('tbl_kiv_engine_details',$engine_data,$engine_sl);
    }
    //-----------Engine End---------------//
    //------Chain Port / Chain Startboard-----------------//
    $equipment_id_chainport=4;
    $equipment_id_chainstarboard=5;
    $chain_port					= 	$this->Survey_model->get_chain_ids($hdnvessel_id, $equipment_id_chainport,$hdnsurvey_id);
    $data['chain_port']			=	$chain_port;
    @$equipment_sl_chainport 	=	$chain_port[0]['equipment_details_sl'];

    $chain_starboard			= 	$this->Survey_model->get_chain_ids($hdnvessel_id, $equipment_id_chainstarboard,$hdnsurvey_id);
    $data['chain_starboard']	=	$chain_starboard;
    @$equipment_sl_starboard 	=	$chain_starboard[0]['equipment_details_sl'];

    if(($_FILES['chainport_test_certificate']['name'])!="")
    {
      $label_id=38;
      $cname="CPTC";
      $chainport_test_certificate_name=$hdnvessel_id.'_'.$label_id.'_'.$random_number.'_'.$cname.'.pdf';
      copy($_FILES['chainport_test_certificate']['tmp_name'], "./uploads/Chain_Port_Certificate/".$chainport_test_certificate_name);
    }
    else
    {
      $chainport_test_certificate_name="";
    }
    $equipment_data= array(
    'chainport_test_certificate' => $chainport_test_certificate_name,
    'equipment_modified_user_id'=>$sess_usr_id,
    'equipment_modified_timestamp'=>$date,
    'equipment_modified_ipaddress'=>$ip);
    $update_equipdetails=$this->Survey_model->update_table_equipment('tbl_kiv_equipment_details',$equipment_data, $equipment_sl_chainport);
    if(($_FILES['chainstarboard_test_certificate']['name'])!="")
    {
      $label_id=39;
      $cname="CSTC";
      $chainstarboard_test_certificate_name=$hdnvessel_id.'_'.$label_id.'_'.$random_number.'_'.$cname.'.pdf';
      copy($_FILES['chainstarboard_test_certificate']['tmp_name'], "./uploads/Chain_Starboard_Certificate/".$chainstarboard_test_certificate_name);
    }
    else
    {
      $chainstarboard_test_certificate_name="";
    }

    $equipment_data= array(
    'chainstarboard_test_certificate' => $chainstarboard_test_certificate_name,
    'equipment_modified_user_id'=>$sess_usr_id,
    'equipment_modified_timestamp'=>$date,
    'equipment_modified_ipaddress'=>$ip );
    $update_equipdetails=$this->Survey_model->update_table_equipment('tbl_kiv_equipment_details',$equipment_data, $equipment_sl_starboard);
        /*
    $update_hulldetails 
    $update_enginedetails
    $update_equipdetails
    */
  }
}
/*_______________________________form 3 payment details___________________________*/	

function add_payment_details_form3()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   	 = $this->session->userdata('customer_id');
  $survey_user_id  = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $vessel_sl   = $this->session->userdata('vessel_id');
    $process_id     = $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id      = $this->security->xss_clean($this->input->post('survey_id'));
    /*$current_status_id  = $this->security->xss_clean($this->input->post('current_status_id'));
    $current_position   = $this->security->xss_clean($this->input->post('current_position')); 
    $status_change_date = $date;
    $processflow_sl   = $this->security->xss_clean($this->input->post('processflow_sl'));
    $user_id      = $this->security->xss_clean($this->input->post('user_id'));
    $status       = 1;
    $status_details_sl= $this->security->xss_clean($this->input->post('status_details_sl'));*/
    if($vessel_sl=="")
    {
      $vessel_id     = $this->security->xss_clean($this->input->post('vessel_id'));
    }
    else
    {
      $vessel_id     =$vessel_sl;
    }
    //__________________________________START ONLINE TRANSACTION__________________________________//

    /*_____________________Start Get vessel condition_______________ */   

    $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition'] = $vessel_condition;
    if(!empty($vessel_condition))
    {
      $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1=$vessel_condition[0]['vessel_length'];
      $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
    }  
    /*_____________________End Get vessel condition___________________*/

    /*_____________________Start Get Tariff amount form 3 from kiv_tariff_master table_______________ */   
    $form_id=3;
    $activity_id=1;

    $tariff_details           =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data1['tariff_details']  =   $tariff_details;
    //print_r($tariff_details);

    $tonnage_details         =   $this->Survey_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']  =   $tonnage_details;

    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
    }
    if(!empty($tariff_details))
    {
      foreach ($tariff_details as $key ) 
      {
        $tariff_tonnagetype_id  = $key['tariff_tonnagetype_id'];

        if($tariff_tonnagetype_id==1)
        {
        $tariff_amount=$key['tariff_amount'];
        }
        elseif($tariff_tonnagetype_id==2)
        {
          $tariff_details_typeid2           =   $this->Survey_model->get_tariff_details_typeid2($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
          $data1['tariff_details_typeid2']  =   $tariff_details_typeid2;

          if(!empty($tariff_details_typeid2))
          {
            @$tariff_amount = (($tariff_details_typeid2[0]['tariff_amount'])*$vessel_total_tonnage);
          }
        }
        elseif($tariff_tonnagetype_id==3)
        {
          $tariff_details_typeid3        =   $this->Survey_model->get_tariff_details_typeid3($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
          $data1['tariff_details_typeid3']  =   $tariff_details_typeid3;
          if(!empty($tariff_details_typeid2))
          {
          @$tariff_amount        = $tariff_details_typeid3[0]['tariff_amount'];
          }
        }
        else
        {
        @$tariff_amount= 1;
        }
      }
    }
    @$tariff_amount1= 1;
    /*_______________________________________________END Tariff____________________________ */   
    /*___________________________________________________________________________ */   
    $portofregistry_sl    = $this->security->xss_clean($this->input->post('portofregistry_sl'));
    $bank_sl              = $this->security->xss_clean($this->input->post('bank_sl'));
    $status=1;

    $payment_user=  $this->Survey_model->get_payment_userdetails($sess_usr_id);
    $data['payment_user']     =   $payment_user;
    //rint_r($payment_user);exit;
    if(!empty($payment_user))
    {
      $owner_name=$payment_user[0]['user_name'];
      $user_mobile_number=$payment_user[0]['user_mobile_number'];
      $user_email=$payment_user[0]['user_email'];
    }
    $form_number_cs=  $this->Survey_model->get_form_number_cs($process_id);
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

    $milliseconds = round(microtime(true) * 1000); //Generate unique bank number

    $bank_gen_number         =   $this->Survey_model->get_bank_generated_last_number($bank_sl);
    $data['bank_gen_number']   = $bank_gen_number;

    if(!empty($bank_gen_number))
    {
      $bank_generated_number =  $bank_gen_number[0]['last_generated_no']+1;
      $transaction_id  =  $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds.$bank_generated_number;
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
      'transaction_amount'    => $tariff_amount1,
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
        $update_bank        =    $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);
        $online_payment_data         =   $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
        $data['online_payment_data']= $online_payment_data;
        $payment_user1              =  $this->Survey_model->get_payment_userdetails($sess_usr_id);
        $data['payment_user1']     =  $payment_user1;
        $requested_transaction_details=  $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
        $data['requested_transaction_details']  =   $requested_transaction_details;
        // $data['amount_tobe_pay']=$tariff_amount;//remove comment before uploaded to server
        $data['amount_tobe_pay']=1;
        $data      =  $data+ $this->data;
        if(!empty($online_payment_data))
        { 
          $this->load->view('Kiv_views/Hdfc/hdfc_initialsurvey_form3_request',$data);
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
      redirect('Kiv_Ctrl/Survey/SurveyHome');
    } //__________________END ONLINE TRANSACTION_________________________//
  }
}

function not_payment_details_form3()
{
  $vessel_id		   =	$this->session->userdata('vessel_id');
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   =	$this->session->userdata('customer_id');
  $survey_user_id	 =	$this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {	
    $data =	array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    date_default_timezone_set("Asia/Kolkata");
    $date               = 	date('Y-m-d h:i:s', time());

    $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
    $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
    $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
    $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
    $current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
    $status_change_date =	$date;
    $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
    $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
    $status 			=	1;
    $status_details_sl=	$this->security->xss_clean($this->input->post('status_details_sl'));

    $date               = 	date('Y-m-d h:i:s', time());
    $ip	      			=	$_SERVER['REMOTE_ADDR'];
    $status_change_date =	$date;

    $data_update = array('status'=>0);
    $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);

    $data_process=array(
    'vessel_id'=>$vessel_id,
    'process_id'=>5,
    'survey_id'=>$survey_id,
    'current_status_id'=>8,
    'current_position'=>$user_type_id,
    'user_id'=>$sess_usr_id,
    'previous_module_id'=>$processflow_sl,
    'status'=>$status,
    'status_change_date'=>$status_change_date);

    $data_status = array('vessel_id' => $vessel_id,
    'process_id' => 5,
    'survey_id' => $survey_id,
    'current_status_id' => 8,
    'sending_user_id' => $sess_usr_id,
    'receiving_user_id' => $sess_usr_id);

    $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_status,$status_details_sl);
    $insert_process   		=	$this->Survey_model->insert_process_flow($data_process);
    if($insert_process && $status_update && $process_update)  
    {
      $this->SurveyHome();
    }       
  }
}
/*___________________form 3 verification by chief surveyor/surveyor_______________*/
public function Verify_Vessel_form3()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id  = $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'Verify_Vessel_form3', 'page' => 'Verify_Vessel_form3', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;

    @$id            = $vessel_details[0]['vessel_created_user_id'];
    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;

    @$relation_sl=$customer_details[0]['relation_sl'];
    if(!empty($relation_sl))
    {
      $agent_details       = $this->Survey_model->get_agent($relation_sl);
      $data['agent_details'] = $agent_details;
      $minor_details       = $this->Survey_model->get_minor($relation_sl);
      $data['minor_details'] = $minor_details;
    }

    $current_status 			=	$this->Survey_model->get_status_form3();
    $data['current_status']		=	$current_status;

    $surveyor_details         =   $this->Survey_model->get_surveyor_details();
    $data['surveyor_details']      = $surveyor_details;

    //----------Vessel Details--------//
    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;

    //----------Hull Details--------//
    $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']    = $hull_details;

    //----------Engine Details--------//
    $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']  = $engine_details;

    //----------Equipment Details--------//
    $equipment_details     =   $this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details'] = $equipment_details;

    //--------------Documents-----------------//
    $list_document_vessel        =   $this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']    = $list_document_vessel;

    //--------------Payments-----------------//
    $payment_details        =   $this->Survey_model->get_payment_details_edit($vessel_id,$survey_id);
    $data['payment_details']    = $payment_details;

    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date       		= 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $remarks 			=	$this->security->xss_clean($this->input->post('remarks')); 
      $remarks_date 		=	date('Y-m-d');
      $forward_to 		=	$this->security->xss_clean($this->input->post('forward_to'));
      $current_status_id	=	$this->security->xss_clean($this->input->post('current_status_id'));
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $status 			=	1;
      $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));


      //Approve form 3 application
      if($current_status_id==5)	
      {	
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>0,
        'status_change_date'=>$status_change_date );

        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();
        $new_process_id=6;
        $data_insert_surveyactivity=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$new_process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>2,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_remarks = array(
        'sending_user_id' => $processflow_sl,
        'receiving_user_id'=> $processflow_id,
        'process_id'=>$process_id,
        'remarks_date'=> $remarks_date,
        'remarks'=>$remarks,
        'entry_timestamp'=>$date);

        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);

        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);
        $data_survey_status=array(
        'process_id'		=>$new_process_id,
        'current_status_id'	=>2,
        'sending_user_id'	=>$sess_usr_id,
        'receiving_user_id'	=>$sess_usr_id);
        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        if($process_update && $process_insert && $remarks_insert  &&  $status_update)
        {
          redirect("Kiv_Ctrl/Survey/csHome");
        }
      }
      //Form 3 Approve and Forward to surveyor start
      if($current_status_id==6)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>0,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();
        $new_process_id=6;

        $data_insert_surveyactivity=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$new_process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>2,
        'current_position'=>13,
        'user_id'=>$forward_to,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_remarks = array(
        'sending_user_id' => $processflow_sl,
        'receiving_user_id'=> $processflow_id,
        'process_id'=>$process_id,
        'remarks_date'=> $remarks_date,
        'remarks'=>$remarks,
        'entry_timestamp'=>$date);

        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);

        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

        $data_survey_status=array(
        'process_id'		=>$new_process_id,
        'current_status_id'	=>2,
        'sending_user_id'	=>$sess_usr_id,
        'receiving_user_id'	=>$forward_to);
        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        if($process_update && $process_insert && $remarks_insert  &&  $status_update)
        {
          redirect("Kiv_Ctrl/Survey/csHome");
        }
      }
      //Form 3 Approve and Forward to surveyor end
    }
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_Vessel_form3',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

/*__________________________form 4 load_______________________________________*/
public function csform4()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'csform4', 'page' => 'csform4', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_form4_process_flow_cs($sess_usr_id);
    $data['initial_data']		=	$initial_data;
    $count	= count($initial_data);
    $data['count']=$count;
    @$id=$initial_data[0]['vessel_created_user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/csform4',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
/*__________________________form 4 task_______________________________________*/
public function csform4Task()
{
	$sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
	$customer_id	=	$this->session->userdata('customer_id');
	$survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'csform4Task', 'page' => 'csform4Task', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;
     
    @$id            = $vessel_details[0]['user_id'];
    $vessel_id          = $vessel_details[0]['vessel_sl'];
    $process_id         = $vessel_details[0]['process_id'];

    $vessel_details_viewpage         =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] =   $vessel_details_viewpage;
    $placeof_survey=$this->Survey_model->get_placeof_survey();
    $data['placeof_survey']=$placeof_survey;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/csform4Task',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}
/*__________________________form 4 task by cs/sr_________________________________*/
function form4Task()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');


  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'form4Task', 'page' => 'form4Task', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    if($this->input->post())
    {
      $ip   = $_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date =  date('Y-m-d h:i:s', time());

      $placeofsurvey_sl = $this->security->xss_clean($this->input->post('placeofsurvey_sl'));
      $date_of_survey2  = $this->security->xss_clean($this->input->post('date_of_survey'));


      $date_of_survey1 = str_replace('/', '-', $date_of_survey2);
      $date_of_survey   = date("Y-m-d", strtotime($date_of_survey1));
      $date_of_survey3   = date("d-m-Y", strtotime($date_of_survey1));
      

      $time_of_survey   = $this->security->xss_clean($this->input->post('time_of_survey'));
      $survey_number    = $this->security->xss_clean($this->input->post('survey_number'));
      $remarks          = $this->security->xss_clean($this->input->post('remarks')); 
      $process_id       = $this->security->xss_clean($this->input->post('process_id')); 
      $survey_id        = $this->security->xss_clean($this->input->post('survey_id'));
      $processflow_sl   = $this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id_owner    = $this->security->xss_clean($this->input->post('user_id'));
      $user_type_id1    = $this->security->xss_clean($this->input->post('user_type_id'));
      $status_details_sl= $this->security->xss_clean($this->input->post('status_details_sl'));  
      $form_id=4;
      $status_change_date = $date;
      $status=1;

      $ref_process_id=1;
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

      $placeofsurvey          =   $this->Survey_model->get_placeofsurvey_code($placeofsurvey_sl);
      $data['placeofsurvey']  =   $placeofsurvey;

      if(!empty($placeofsurvey))
      {
        $placeofsurvey_name=$placeofsurvey[0]['placeofsurvey_name'];
      }
      else
      {
        $placeofsurvey_name="";
      }
      $customer_details       = $this->Survey_model->get_customer_details($user_id_owner);
      $data['customer_details'] = $customer_details;
      $owner_name         = $customer_details[0]['user_name'];
      $user_mobile_number = $customer_details[0]['user_mobile_number'];
      $user_email         = $customer_details[0]['user_email'];

       //----------Vessel Details--------//
      $vessel_details_viewpage        = $this->Survey_model->get_vessel_details_viewpage($vessel_id);
      $data['vessel_details_viewpage']= $vessel_details_viewpage;
      $vessel_name              = $vessel_details_viewpage[0]['vessel_name'];
      $portofregistry_sl        = $vessel_details_viewpage[0]['vessel_registry_port_id'];
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
      

      $data_intimation = array(
      'vessel_id'                   => $vessel_id,
      'survey_number'               => $survey_number,
      'survey_id'                   => $survey_id,
      'form_id'                     => $form_id,
      'placeofsurvey_id'            => $placeofsurvey_sl,
      'date_of_survey'              => $date_of_survey,
      'time_of_survey'              => $time_of_survey,
      'status'                      => $status,
      'remarks'                     => $remarks,
      'intimation_created_user_id'  => $sess_usr_id,
      'intimation_created_timestamp'=> $date,
      'intimation_created_ipaddress'=> $ip);
       $vessel_details=array('vessel_survey_number'=>$survey_number);
      $vessel_update=$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$vessel_details, $vessel_id);

      $insert_survey_intimation=$this->Survey_model->insert_table1('tbl_kiv_survey_intimation', $data_intimation);
      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>7,
      'current_position'=>$user_type_id1,
      'user_id'=>$user_id_owner,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);
      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

      $data_survey_status=array(
      'process_id'    =>$process_id,
      'current_status_id' =>7,
      'sending_user_id' =>$sess_usr_id,
      'receiving_user_id' =>$user_id_owner);
      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      //_____________________________Email sending start_____________________________//
      $email_subject="Survey of ".$vessel_name." is scheduled on ".$date_of_survey3.", ".$time_of_survey." at ".$placeofsurvey_name."";
      $email_message="<div><h4>Dear ". $owner_name.",</h4>
      <p>".$vessel_name." is scheduled on <b>".$date_of_survey3.", ".$time_of_survey." </b> at <b>".$placeofsurvey_name."</b>.  Survey number of your vessel is  <b>".$survey_number."</b>.
       <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>
      Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.<br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
      $saji_email="bssajitha@gmail.com";
      $this->emailSendFunction($saji_email,$email_subject,$email_message);
      //$this->emailSendFunction($user_email,$email_subject,$email_message);
      //___________________Email sending start___________________________________________//
      //____________________SMS sending start____________________________________________//
      $sms_message="Survey of ".$vessel_name." is scheduled on ".$date_of_survey3.", ".$time_of_survey." at ".$placeofsurvey_name.". Login to portinfo.kerala.gov.in for more details. ";
      $this->load->model('Kiv_models/Survey_model');
      $saji_mob="9847903241";
      //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
      //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
      //____________________SMS sending end________________________________________________//


      if($process_update && $process_insert && $status_update && $insert_survey_intimation &&  $vessel_update && $user_type_id==12)
      {
        redirect('Kiv_Ctrl/Survey/csHome');
      }
      elseif($process_update && $process_insert && $status_update && $insert_survey_intimation  &&  $vessel_update && $user_type_id==13)
      {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');
      }
      else
      {
        redirect('Main_login/index');
      }
    }
  }
}
/*__________________________survey intimation send by cs/sr_______________________*/
public function surveyIntimation()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');

  $vessel_id1    = $this->uri->segment(4);
  $processflow_sl1   = $this->uri->segment(5);
  $survey_id1    = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'surveyIntimation', 'page' => 'surveyIntimation', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $survey_intimation          = $this->Survey_model->get_survey_intimation($vessel_id,$survey_id);
    $data['survey_intimation']  = $survey_intimation;
   
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/surveyIntimation',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}
function form4_confirmation()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
    if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'form4_confirmation', 'page' => 'form4_confirmation', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
     $ip     =  $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date               =   date('Y-m-d h:i:s', time());
    $vessel_id          = $this->security->xss_clean($this->input->post('vessel_id'));  
    $process_id         = $this->security->xss_clean($this->input->post('process_id')); 
    $survey_id          = $this->security->xss_clean($this->input->post('survey_id'));
    $processflow_sl     = $this->security->xss_clean($this->input->post('processflow_sl'));
    $cs_user_id         = $this->security->xss_clean($this->input->post('user_id_cs'));
    $cs_user_type_id    =  $this->security->xss_clean($this->input->post('user_type_id_cs'));
    $status_details_sl  = $this->security->xss_clean($this->input->post('status_details_sl'));
    $status_change_date = $date;
    $status             = 1;

    $data_insert=array(
    'vessel_id'=>$vessel_id,
    'process_id'=>$process_id,
    'survey_id'=>$survey_id,
    'current_status_id'=>7,
    'current_position'=>$cs_user_type_id,
    'user_id'=>$cs_user_id,
    'previous_module_id'=>$processflow_sl,
    'status'=>$status,
    'status_change_date'=>$status_change_date);

    $data_update = array('status'=>0);
    $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
    $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

    $processflow_id     =   $this->db->insert_id();

    $data_survey_status=array(
    'process_id'    =>$process_id,
    'current_status_id' =>7,
    'sending_user_id' =>$sess_usr_id,
    'receiving_user_id' =>$cs_user_type_id);
    $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

    $data_task=array(
    'process_flow_id' =>  $processflow_id,
    'assign_date'   =>  $date_of_survey,
    'status'      =>  1);
    $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);
    if($process_update && $process_insert && $status_update &&  $task_insert)
    {
      redirect('Kiv_Ctrl/Survey/Owner_Inbox');
    }
    else
    {
      redirect('Kiv_Ctrl/Survey/SurveyHome');
    }
  }
}
/*__________________________form 4 defect by cs/sr_______________________*/
public function form4defect()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id 	= $this->session->userdata('customer_id');
  $survey_user_id	= $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'form4defect', 'page' => 'form4defect', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $survey_intimation          = $this->Survey_model->get_survey_intimation($vessel_id,$survey_id);
    $data['survey_intimation']  = $survey_intimation;

    $vessel_details       		=   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   	= 	$vessel_details;

    @$survey_defects_id=$survey_intimation[0]['survey_defects_id'];

    $placeof_survey 			=	$this->Survey_model->get_placeof_survey();
    $data['placeof_survey'] 	=	$placeof_survey;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form4defect',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}
/*__________________________form 4 defect by cs/sr_______________________*/
public function form4defect_detection()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id 	= $this->session->userdata('customer_id');
  $survey_user_id	= $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'form4defect_detection', 'page' => 'form4defect_detection', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $survey_intimation          = $this->Survey_model->get_survey_intimation($vessel_id,$survey_id);
    $data['survey_intimation']  = $survey_intimation;
    $intimation_sl=$survey_intimation[0]['intimation_sl'];
    @$survey_defects_id=$survey_intimation[0]['survey_defects_id'];
    @$survey_defects_id1=$survey_intimation[0]['survey_defects_id'];
    /*$prev_date_of_survey=date("d-m-Y", strtotime($survey_intimation[0]['date_of_survey'])); 
    $prev_time_of_survey=$survey_intimation[0]['time_of_survey'];
    $prev_placeofsurvey_id=$survey_intimation[0]['placeofsurvey_id'];

    $prev_placeofsurvey          =   $this->Survey_model->get_placeofsurvey_code($prev_placeofsurvey_id);
    $data['prev_placeofsurvey']  =   $prev_placeofsurvey;
    if(!empty($prev_placeofsurvey))
    {
      $prev_placeofsurvey_name=$prev_placeofsurvey[0]['placeofsurvey_name'];
    }
    else
    {
      $prev_placeofsurvey_name="";
    }*/

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;

    if($this->input->post())
    {
      $ip     =	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date               = 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      //$current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
      //$current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $owner_user_id 		=	$this->security->xss_clean($this->input->post('user_id'));
      $owner_user_type_id=	$this->security->xss_clean($this->input->post('user_type_id'));
      $status 			=	1;
      $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $defect_status		=	$this->security->xss_clean($this->input->post('defect_status'));
      $category 			=	$this->security->xss_clean($this->input->post('category'));
      $defects_noticed_by 	=	$user_type_id;
      $time_period			=	$this->security->xss_clean($this->input->post('time_period'));
      $direction_to_rectify 	=	$this->security->xss_clean($this->input->post('direction_to_rectify'));
      $defect_details 		=	$this->security->xss_clean($this->input->post('defect_details'));
      $placeofsurvey_sl = $this->security->xss_clean($this->input->post('placeofsurvey_sl'));
      $date_of_survey2  = $this->security->xss_clean($this->input->post('date_of_survey'));
      $date_of_survey1 = str_replace('/', '-', $date_of_survey2);
      $date_of_survey   = date("Y-m-d", strtotime($date_of_survey1));
      $date_of_survey3   = date("d-m-Y", strtotime($date_of_survey1));

      $time_of_survey      = $this->security->xss_clean($this->input->post('time_of_survey'));
      $remarks          = $this->security->xss_clean($this->input->post('remarks')); 
      $defect_intimation 		= 	pathinfo($_FILES['defect_intimation']['name']);
      if($defect_intimation)
      {
        $extension  			= 	$defect_intimation['extension'];
      }
      else
      {
        $extension  ="";
      }
      $random_number 			=	rand(1,9);
      //defect_status=1 No defect ; 2 Defect found
      if($defect_status==1 && $category==1)
      {
        $process_id_new=8;  //category A - form5
      }
      if($defect_status==1 && $category==2)
      {
        $process_id_new=9; //category B - form6
      }
      //_____________________________email/sms data collection start___________________________________//
      $ref_process_id=1;
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

      $placeofsurvey          =   $this->Survey_model->get_placeofsurvey_code($placeofsurvey_sl);
      $data['placeofsurvey']  =   $placeofsurvey;
      if(!empty($placeofsurvey))
      {
        $placeofsurvey_name=$placeofsurvey[0]['placeofsurvey_name'];
      }
      else
      {
        $placeofsurvey_name="";
      }
      $customer_details       = $this->Survey_model->get_customer_details($owner_user_id);
      $data['customer_details'] = $customer_details;

      $owner_name         = $customer_details[0]['user_name'];
      $user_mobile_number = $customer_details[0]['user_mobile_number'];
      $user_email         = $customer_details[0]['user_email'];

       //----------Vessel Details--------//
      $vessel_details_viewpage        = $this->Survey_model->get_vessel_details_viewpage($vessel_id);
      $data['vessel_details_viewpage']= $vessel_details_viewpage;

      $vessel_name              = $vessel_details_viewpage[0]['vessel_name'];
      $portofregistry_sl        = $vessel_details_viewpage[0]['vessel_registry_port_id'];
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
      $formnumber=3;
      $defect_count           =   $this->Survey_model->get_defect_count($vessel_id,$survey_id);
      $data['defect_count']   =   $defect_count;
      if(!empty($defect_count))
      {
        $count = count($defect_count);
        $data['count']=$count;
        $tariff           =   $this->Survey_model->get_form3_tariff($vessel_id,$survey_id,$formnumber);
        $data['tariff']   =   $tariff;
        //print_r($tariff);
        if(!empty($tariff))
        {
          $amount_tobe_pay=$tariff[0]['dd_amount']*2;
        }
        else
        {
          $amount_tobe_pay=0;
        }
      }
      else
      {
        $count=0;
      }
      $survey_intimation          = $this->Survey_model->get_survey_intimation($vessel_id,$survey_id);
      $data['survey_intimation']  = $survey_intimation;
      $prev_date_of_survey=date("d-m-Y", strtotime($survey_intimation[0]['date_of_survey'])); 
      $prev_time_of_survey=$survey_intimation[0]['time_of_survey'];
      $prev_placeofsurvey_id=$survey_intimation[0]['placeofsurvey_id'];

      $prev_placeofsurvey          =   $this->Survey_model->get_placeofsurvey_code($prev_placeofsurvey_id);
      $data['prev_placeofsurvey']  =   $prev_placeofsurvey;
      if(!empty($prev_placeofsurvey))
      {
        $prev_placeofsurvey_name=$prev_placeofsurvey[0]['placeofsurvey_name'];
      }
      else
      {
        $prev_placeofsurvey_name="";
      }
      $survey_intimation_defects =   $this->Survey_model->get_survey_intimation_defects_owner($status_details_sl);
      $data['survey_intimation_defects']  =   $survey_intimation_defects;
      $prev2_date_of_survey= date('d-m-Y', strtotime($survey_intimation_defects[0]['date_of_survey']));
      $prev2_time_of_survey=$survey_intimation_defects[0]['time_of_survey'];
      $prev2_placeofsurvey_id=$survey_intimation_defects[0]['placeofsurvey_id'];
      $prev2_placeofsurvey          =   $this->Survey_model->get_placeofsurvey_code($prev2_placeofsurvey_id);
      $data['prev2_placeofsurvey']  =   $prev2_placeofsurvey;
      if(!empty($prev2_placeofsurvey))
      {
        $prev2_placeofsurvey_name=$prev2_placeofsurvey[0]['placeofsurvey_name'];
      }
      else
      {
        $prev2_placeofsurvey_name="";
      }
     
      
      //___________________________email/sms data collection end__________________________________//

      //____________________________No defect found________________________//
      if($defect_status==1)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>5,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>0,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id     =   $this->db->insert_id();

        $data_survey_status=array(
        'process_id'=>$process_id_new,
        'current_status_id'=>1,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$sess_usr_id);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $data_insert_surveyactivity=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id_new,
        'survey_id'=>$survey_id,
        'current_status_id'=>1,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);
        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);

        $data_category=array('category'=>$category,
        'vessel_modified_user_id'=>$sess_usr_id,
        'vessel_modified_timestamp'=>$date,
        'vessel_modified_ipaddress'=>$ip);

        $vessel_update=$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_category, $vessel_id);

        $update_defectstatus_data=array('status'=>1);

        if($survey_defects_id!=0)
        {
          $update_defectstatus_details=$this->Survey_model->update_defect_table('tbl_kiv_survey_defects', $update_defectstatus_data, $survey_defects_id);
        }
        if($survey_defects_id1==0)
        {
          $update_intimation_data=array('status'=>2);
        }
        if($survey_defects_id1!=0)
        {
          $update_intimation_data=array('status'=>2,
          'defect_status'=>2);
        }
        $update_intimation_details=$this->Survey_model->update_intimation_table('tbl_kiv_survey_intimation',$update_intimation_data,$intimation_sl);


        if($process_update && $process_insert && $status_update && $process_insert_surveyactivity && $vessel_update && $user_type_id==12)
        {
          redirect('Kiv_Ctrl/Survey/csActivities');
        }
        elseif($process_update && $process_insert && $status_update && $process_insert_surveyactivity && $vessel_update && $user_type_id==13)
        {
          redirect('Kiv_Ctrl/Survey/srActivities');
        }
        else
        {   
          redirect('Main_login/index');
        }
      }
     /*___________________________end_____________________________________________ */
      $formnumber=3;
      $defect_count           =   $this->Survey_model->get_defect_count($vessel_id,$survey_id);
      $data['defect_count']   =   $defect_count;
      if(!empty($defect_count))
      {
        $count = count($defect_count);
        $data['count']=$count;
      }
      else
      {
        $count=0;
      }
      //if Defect found
      if($defect_status==2)
      {
        $data_defect_details=array('intimation_id'=>$intimation_sl,
        'defects_noticed_by'=>$sess_usr_id,
        'time_period'=>$time_period,
        'direction_to_rectify'=>$direction_to_rectify,
        'defect_details'=>$defect_details,
        'placeofsurvey_id'=>$placeofsurvey_sl,
        'date_of_survey'=>$date_of_survey,
        'time_of_survey'=>$time_of_survey,
        'remarks'=>$remarks,
        'status'=>0,
        'defect_created_timestamp'=>$date,
        'defect_created_ipaddress'=>$ip);

        $insert_table=$this->Survey_model->insert_table('tbl_kiv_survey_defects', $data_defect_details);
        $survey_defects_sl 		= 	$this->db->insert_id();
        if($insert_table)
        {
          $pdf_name=$vessel_id.'_'.$intimation_sl.'_'.$survey_defects_sl.'_'.$random_number.'.'.$extension;
          copy($_FILES["defect_intimation"]["tmp_name"], "./uploads/defects/".$pdf_name);
          $update_defect_data=array('defect_intimation'=>$pdf_name);
          $update_defect_details=$this->Survey_model->update_defect_table('tbl_kiv_survey_defects', $update_defect_data,$survey_defects_sl);
          $update_defectstatus_data=array('status'=>1);

          if($survey_defects_id!=0)
          {
            $update_defectstatus_details=$this->Survey_model->update_defect_table('tbl_kiv_survey_defects', $update_defectstatus_data,$survey_defects_id);
          }
          $update_intimation_data=array('defect_status'=>1,
          'survey_defects_id'=>$survey_defects_sl);
          $update_intimation_details=$this->Survey_model->update_intimation_table('tbl_kiv_survey_intimation',$update_intimation_data,$intimation_sl);  
       }
      } //------------------process flow start----------------------//
      //if($count>1)
      if($count==1)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>7,
        'survey_id'=>$survey_id,
        'current_status_id'=>2,
        'current_position'=>$owner_user_type_id,
        'user_id'=>$owner_user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);
        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id     =   $this->db->insert_id();

        $data_survey_status=array(
        'process_id'=>7,
        'current_status_id'=>2,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$owner_user_id);
       //_____________________________Email sending start_____________________________//
        $email_subject="Defect memo: Next survey scheduled on scheduled on ".$date_of_survey3.", ".$time_of_survey." at ".$placeofsurvey_name."";
        $email_message="<div><h4>Dear ". $owner_name.",</h4><p>The survey conducted on ".$prev_date_of_survey.", ".$prev_time_of_survey." at ".$prev_placeofsurvey_name." has found some defects for your vessel ".$vessel_name.". The next survery is scheduled on <b> ".$date_of_survey3.", ".$time_of_survey." at ".$placeofsurvey_name."</b>. Kindly make payment of Rs. <b>".$amount_tobe_pay."</b> by login to portinfo.kerala.gov.in. <br>  Survey number of your vessel is  <b>".$survey_number."</b>.<br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br> Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.<br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
          $saji_email="bssajitha@gmail.com";
          $this->emailSendFunction($saji_email,$email_subject,$email_message);
          //$this->emailSendFunction($user_email,$email_subject,$email_message);
          //___________________Email sending start___________________________________________//
          //____________________SMS sending start____________________________________________//
          $sms_message="Defects were found in previous survey. Next survey is scheduled on ".$date_of_survey3.", ".$time_of_survey." at ".$placeofsurvey_name.". Login to portinfo.kerala.gov.in and make payment of Rs. ".$amount_tobe_pay.". ";
          $this->load->model('Kiv_models/Survey_model');
          $saji_mob="9847903241";
          //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
          //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
          //____________________SMS sending end________________________________________________//
          $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        if($process_update && $process_insert && $status_update && $user_type_id==12)
        {
          redirect('Kiv_Ctrl/Survey/csActivities');
        }
        elseif($process_update && $process_insert && $status_update &&  $user_type_id==13)
        {
          redirect('Kiv_Ctrl/Survey/srActivities');
        }
        else
        {
          redirect('Main_login/index');
        }
      }
      else
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>7,
        'survey_id'=>$survey_id,
        //'current_status_id'=>2,
        'current_status_id'=>7,
        /*'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,*/
        'current_position'=>$owner_user_type_id,
        'user_id'=>$owner_user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>0,
        'status_change_date'=>$status_change_date);
   
        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id     =   $this->db->insert_id();

        $data_survey_status=array(
        'process_id'=>7,
        //'current_status_id'=>2,
        'current_status_id'=>7,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$owner_user_id);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $data_insert_surveyactivity=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>7,
        'survey_id'=>$survey_id,
        'current_status_id'=>7,
        /*'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,*/
        'current_position'=>$owner_user_type_id,
        'user_id'=>$owner_user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);
        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);
       //_____________________________Email sending start_____________________________//
        $email_subject="Defect memo: Next survey scheduled on scheduled on ".$date_of_survey3.", ".$time_of_survey." at ".$placeofsurvey_name."";
        $email_message="<div><h4>Dear ". $owner_name.",</h4><p>The survey conducted on ".$prev2_date_of_survey.", ".$prev2_time_of_survey." at ".$prev2_placeofsurvey_name." has found some defects for your vessel ".$vessel_name.". The next survery is scheduled on <b> ".$date_of_survey3.", ".$time_of_survey." at ".$placeofsurvey_name."</b>. Kindly make payment of Rs. <b>".$amount_tobe_pay."</b> by login to portinfo.kerala.gov.in. <br>  Survey number of your vessel is  <b>".$survey_number."</b>.<br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br> Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.<br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
        $saji_email="bssajitha@gmail.com";
        $this->emailSendFunction($saji_email,$email_subject,$email_message);
        //$this->emailSendFunction($user_email,$email_subject,$email_message);
        //___________________Email sending start___________________________________________//
        //____________________SMS sending start____________________________________________//
        $sms_message="Defects were found in previous survey. Next survey is scheduled on ".$date_of_survey3.", ".$time_of_survey." at ".$placeofsurvey_name.". Login to portinfo.kerala.gov.in and make payment of Rs. ".$amount_tobe_pay.". ";
        $this->load->model('Kiv_models/Survey_model');
        $saji_mob="9847903241";
        //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
        //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
        //____________________SMS sending end________________________________________________//

        if($process_update && $process_insert && $status_update && $process_insert_surveyactivity && $user_type_id==12)
        {
          redirect('Kiv_Ctrl/Survey/csActivities');
        }
        elseif($process_update && $process_insert && $status_update && $process_insert_surveyactivity && $user_type_id==13)
        {
          redirect('Kiv_Ctrl/Survey/srActivities');
        }
        else
        {
          redirect('Main_login/index');
        }
      } //------------------process flow end----------------------//
    }
  }
}

/*__________________________form 5/6 load for cs/sr_________________________*/
public function form56_view()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form56_view', 'page' => 'form56_view', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_form56_process_flow_cs($sess_usr_id);
    $data['initial_data']		=	$initial_data;
    $count	= count($initial_data);
    $data['count']=$count;
    @$id=$initial_data[0]['user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form56_view',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
/*__________________________Defect Details_______________________*/

public function DefectDetails()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $survey_defects_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);
  $processflow_id1 			= 	$this->uri->segment(7);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_id1);
  $processflow_id=$this->encrypt->decode($processflow_id); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $survey_defects_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_defects_sl1);
  $survey_defects_sl=$this->encrypt->decode($survey_defects_sl); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'DefectDetails', 'page' => 'DefectDetails', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $survey_defect_details      =   $this->Survey_model->get_survey_defect_details($survey_defects_sl,$vessel_id,$survey_id);
    $data['survey_defect_details']  = $survey_defect_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/DefectDetails',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
  redirect('Main_login/index');        
  }
}
public function defect_payment()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id  = $this->session->userdata('survey_user_id');

  $vessel_id1     = $this->uri->segment(4);
  $processflow_sl1   = $this->uri->segment(5);
  $survey_id1    = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'defect_payment', 'page' => 'defect_payment', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $bank         =   $this->Survey_model->get_bank_favoring();
    $data['bank']   = $bank;

    $portofregistry         =   $this->Survey_model->get_portofregistry();
    $data['portofregistry']   = $portofregistry;

    $vessel_details           =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']     =   $vessel_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/defect_payment',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}

public function defect_payment_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   = $this->session->userdata('customer_id');
  $survey_user_id  = $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'defect_payment_annual', 'page' => 'defect_payment_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $portofregistry			    = 	$this->Survey_model->get_portofregistry();
    $data['portofregistry'] 	=	$portofregistry;

    $bank         =   $this->Survey_model->get_bank_favoring();
    $data['bank']   = $bank;
    //print_r($bank);
    $vessel_details       		=   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   	= 	$vessel_details;
    //print_r($vessel_details);
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/defect_payment_annual',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}

function form4_defect_payment()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id   		= 	$this->session->userdata('customer_id');
  $survey_user_id  	= 	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'form4_defect_payment', 'page' => 'form4_defect_payment', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    if($this->input->post())
    {
      $vessel_id           = $this->security->xss_clean($this->input->post('vessel_id'));
      $process_id           = $this->security->xss_clean($this->input->post('process_id'));
      $survey_id            = $this->security->xss_clean($this->input->post('survey_id'));
      //_________________________START ONLINE TRANSACTION__________________________________//
      /*_____________________Start Get vessel condition_______________ */   

      $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
      $data['vessel_condition'] = $vessel_condition;
      if(!empty($vessel_condition))
      {
        $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
        $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
        $vessel_length1=$vessel_condition[0]['vessel_length'];
        $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
        $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
      }  
      /*_____________________End Get vessel condition___________________*/
      /*_____________________Start Get Tariff amount from kiv_tariff)_master table_______________ */   
      $formnumber=4;
      $defect_count           =   $this->Survey_model->get_defect_count($vessel_id,$survey_id);
      $data['defect_count']   =   $defect_count;
      if(!empty($defect_count))
      {
        $count = count($defect_count);
        $data['count']=$count;

        $tariff           =   $this->Survey_model->get_form3_tariff($vessel_id,$survey_id,$formnumber);
        $data['tariff']   =   $tariff;
        if(!empty($tariff))
        {
        //$tariff_amount=$tariff[0]['dd_amount']*2;
        $tariff_amount=1;
        }
        else
        {
        $tariff_amount=1;
        }
      }
      else
      {
        $count=0;
      } /*____________________________END Tariff___________________ */   
      //$dd_amount1           = $this->security->xss_clean($this->input->post('dd_amount'));
      $portofregistry_sl    = $this->security->xss_clean($this->input->post('portofregistry_sl'));
      $bank_sl              = $this->security->xss_clean($this->input->post('bank_sl'));
      $status=1;
      $payment_user=  $this->Survey_model->get_payment_userdetails($sess_usr_id);
      $data['payment_user']     =   $payment_user;
      //print_r($payment_user);exit;
      if(!empty($payment_user))
      {
        $owner_name=$payment_user[0]['user_name'];
        $user_mobile_number=$payment_user[0]['user_mobile_number'];
        $user_email=$payment_user[0]['user_email'];
      }
      date_default_timezone_set("Asia/Kolkata");
      $ip         = $_SERVER['REMOTE_ADDR'];
      $date       =   date('Y-m-d h:i:s', time());
      $newDate    =   date("Y-m-d");
      $status_change_date=$date;

      $milliseconds = round(microtime(true) * 1000); //Generate unique bank number
      $bank_gen_number         =   $this->Survey_model->get_bank_generated_last_number($bank_sl);
      $data['bank_gen_number']   = $bank_gen_number;
      if(!empty($bank_gen_number))
      {
        $bank_generated_number =  $bank_gen_number[0]['last_generated_no']+1;
        $transaction_id =  $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds.$bank_generated_number;
        $tocken_number   =  $user_type_id.$sess_usr_id.$vessel_id.$bank_sl.$milliseconds;

        $bank_data      =  array('last_generated_no'=>$bank_generated_number);

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
          $update_bank      =    $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);

          $online_payment_data  =   $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
          $data['online_payment_data']= $online_payment_data;

          $payment_user1      =  $this->Survey_model->get_payment_userdetails($sess_usr_id);
          $data['payment_user1']     =  $payment_user1;

          $requested_transaction_details=  $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
          $data['requested_transaction_details']  =   $requested_transaction_details;
          //$data['amount_tobe_pay']=$tariff_amount;//remove comment before uploaded to server
          $data['amount_tobe_pay']=1;

          $data      =  $data+ $this->data;
          if(!empty($online_payment_data))
          { 
            $this->load->view('Kiv_views/Hdfc/hdfc_onlinepayment_form4_request',$data);
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
        redirect('Kiv_Ctrl/Survey/SurveyHome');
      }//___________________________END ONLINE TRANSACTION________________________//
    }
  }
}

/*__________________________form 7 entry view_______________________*/
public function form7_entryview()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form7_entryview', 'page' => 'form7_entryview', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $initial_data			    = 	$this->Survey_model->get_form7_process_flow_cs($sess_usr_id);
    $data['initial_data']		=	$initial_data;

    $count	= count($initial_data);
    $data['count']=$count;

    @$id=$initial_data[0]['user_id'];
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form7_entryview',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

/*_______________________________form 7 entry ________________________________*/
public function form7_entry()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form7_entry', 'page' => 'form7_entry', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_form7_process_flow_csde($sess_usr_id,$vessel_id);
    $data['initial_data']		=	$initial_data;

    $count	= count($initial_data);
    $data['count']=$count;
    @$id=$initial_data[0]['vessel_created_user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;
    $owner_name         = $customer_details[0]['user_name'];
    $user_mobile_number = $customer_details[0]['user_mobile_number'];
    $user_email         = $customer_details[0]['user_email'];
    $vessel_details_viewpage        = $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;

    $vessel_name              = $vessel_details_viewpage[0]['vessel_name'];
    $portofregistry_sl        = $vessel_details_viewpage[0]['vessel_registry_port_id'];
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
    $ref_process_id=1;
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

    if($this->input->post())
    {
      $ip     =	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date               = 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      //$current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
      //$current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 

      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));

      $owner_user_id 		=	$id;
      $owner_user_type_id=	2;
      $status 			=	1;
      $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));

      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$owner_user_type_id,
      'user_id'=>$owner_user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date	);

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id     =   $this->db->insert_id();

      $data_survey_status=array(
      'process_id'=>$process_id,
      'current_status_id'=>5,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$owner_user_id);

      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      //_____________________________Email sending start_____________________________//
      $email_subject="Certificate of survey for  ".$vessel_name." is ready for delivery";
      $email_message="<div><h4>Dear ". $owner_name.",</h4><p>Certifictate of Survey for <b>".$vessel_name."</b> is ready for delivery. Kindly submit Form 8, by login to portinfo.kerala.gov.in.  <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.<br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Chief Surveyor<br><br>Kerala Maritime Board <br></p><hr></div>";
      $saji_email="bssajitha@gmail.com";
      $this->emailSendFunction($saji_email,$email_subject,$email_message);
      //$this->emailSendFunction($user_email,$email_subject,$email_message);
      //___________________Email sending start___________________________________________//
      //____________________SMS sending start____________________________________________//
      $sms_message="Certificate of survey for <b>".$vessel_name."</b> is ready for delivery. Submit Form 8 via portinfo.kerala.gov.in";
      $this->load->model('Kiv_models/Survey_model');
      $saji_mob="9847903241";
      //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
      //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
      //____________________SMS sending end________________________________________________//
      if($process_update && $process_insert && $status_update)
      {
        redirect('Kiv_Ctrl/Survey/form7_entryview');
      }
      else
      {
        redirect('Main_login/index');        
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form7_entry',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

/*_______________________________form 7 view ________________________________*/
public function form7_view()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form7_view', 'page' => 'form7_view', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_form7_process_flow($sess_usr_id);
    $data['initial_data']		=	$initial_data;
    $activity_id=1;
    $form_id=	7;
    $vessel_type_id=	$initial_data[0]['vessel_type_id'];
    $vessel_subtype_id=	$initial_data[0]['vessel_subtype_id'];

    $count	= count($initial_data);
    $data['count']=$count;
    @$id=$initial_data[0]['vessel_created_user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $tariff_details     		  =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data['tariff_details'] 	= 	$tariff_details;
    //print_r($tariff_details);

    $process_data			    = 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['process_data']		=	$process_data;
    if(!empty($process_data))
    {
      $previous_module_id=$process_data[0]['previous_module_id'];
      $process_data_cssr			    = 	$this->Survey_model->get_user_type_user_id($previous_module_id);
      $data['process_data_cssr']		=	$process_data_cssr;
      $user_id_cs_sr=$process_data_cssr[0]['user_id'];
      $user_type_id_cs_sr=$process_data_cssr[0]['current_position'];
    }
    if($this->input->post())
    {
      $ip     			=	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date               = 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id'));
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $processflow_sl 	=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $owner_user_id 		=	$this->security->xss_clean($this->input->post('user_id'));
      $owner_user_type_id =	$this->security->xss_clean($this->input->post('user_type_id'));
      $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $status_change_date =	$date;
      $owner_user_type_id =	2;
      $status 			=	1;

      $new_process_id=11;
      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$new_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>2,
      //'current_position'=>4,
      //'user_id'=>4,
      'current_position'=>$user_type_id_cs_sr,
      'user_id'=>$user_id_cs_sr,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id     =   $this->db->insert_id();

      $data_survey_status=array(
      'process_id'=>$new_process_id,
      'current_status_id'=>2,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$user_id_cs_sr);

      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      if($process_update && $process_insert && $status_update)
      {
        redirect('Kiv_Ctrl/Survey/SurveyHome');
      }
      else
      {
        redirect('Main_login/index');        
      }
    }
  $this->load->view('Kiv_views/template/dash-header.php');;
  $this->load->view('Kiv_views/template/nav-header.php');
  $this->load->view('Kiv_views/dash/form7_view',$data);
  $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

/*_______________________________form 8 view ________________________________*/
public function form8_view()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form8_view', 'page' => 'form8_view', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_form8_process_flow($sess_usr_id,$vessel_id);
    $data['initial_data']		=	$initial_data;
    //print_r($initial_data);

    @$id=$initial_data[0]['vessel_created_user_id'];
    @$category=$initial_data[0]['category'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;
    if($this->input->post())
    {
      $ip     			=	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date               = 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id'));
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $processflow_sl 	=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $owner_user_id 		=	$this->security->xss_clean($this->input->post('user_id'));
      $owner_user_type_id =	$this->security->xss_clean($this->input->post('user_type_id'));
      $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $status_change_date =	$date;

      $status 			=	1;
      if($category==1)
      {
        $new_process_id=12;
      }
      if($category==2)
      {
        $new_process_id=13;
      }
      /*$new_process_id_form9=12;
      $new_process_id_form10=13;*/
      //-------------- new modification -------------//

      $data_insert_approve_form8=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$user_type_id,
      'user_id'=>$sess_usr_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>0,
      'status_change_date'=>$status_change_date);

      $process_insert_form8=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_approve_form8);
      //-------------- new modification end-------------//

      $usertype_id_cs=12;
      $user_id_cs   = $this->Survey_model->get_user_id_cs(12);
      $data['user_id_cs']    = $user_id_cs;
      if(!empty($user_id_cs)) 
      {
        $cs_user_id=$user_id_cs[0]['user_master_id'];
      }
      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$new_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>1,
      'current_position'=>$usertype_id_cs,
      'user_id'=>$cs_user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);

      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id     =   $this->db->insert_id();

      $data_survey_status=array(
      'process_id'=>$new_process_id,
      'current_status_id'=>1,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$cs_user_id);

      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      if($process_update && $process_insert && $status_update)
      {
        redirect('Kiv_Ctrl/Survey/csHome');
      }
      else
      {
        redirect('Main_login/index');        
      }
    }
  $this->load->view('Kiv_views/template/dash-header.php');;
  $this->load->view('Kiv_views/template/nav-header.php');
  $this->load->view('Kiv_views/dash/form8_view',$data);
  $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
/*_______________________________form 9 view ________________________________*/

public function form9_view()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $survey_id1 		=	$this->uri->segment(5);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form9_view', 'page' => 'form9_view', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    //--------------processflow------//
    $initial_data			    = 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['initial_data']		=	$initial_data;

    @$id=$initial_data[0]['user_id'];
    @$category=$initial_data[0]['category'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    //----------Vessel Details--------//
    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;
    @$id=$vessel_details_viewpage[0]['user_id'];


    //----------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']		=	$hull_details;

    //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']	=	$engine_details;

    //----------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details']	=	$equipment_details;

    //--------------Documents-----------------//
     $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']		=	$list_document_vessel;

    $portable_fire_ext	          = 	$this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id);
    $data['portable_fire_ext']	  =	  $portable_fire_ext;

    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    //-----------Get Passenger--------------//
    $passenger_details=$this->Survey_model->get_passenger_details($vessel_id,$survey_id);
    $data['passenger_details']=$passenger_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form9_view',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}
/*_______________________________form 10 view ________________________________*/

public function form10_view()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $survey_id1 		=	$this->uri->segment(5);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form10_view', 'page' => 'form10_view', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    //----------Vessel Details--------//
    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;

    //----------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']		=	$hull_details;

    //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']	=	$engine_details;

    //----------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details']	=	$equipment_details;

    //----------Get portable fire extinguisher---------------//
    $portable_fire_ext	      = 	$this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id);
    $data['portable_fire_ext']	  =	  $portable_fire_ext;

    //--------------Documents-----------------//
    $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']		=	$list_document_vessel;

    @$id=$vessel_details_viewpage[0]['user_id'];

    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form10_view',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}

/*_______________________________form 6 entry ________________________________*/
public function form6_entry()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id	    =	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form6_entry', 'page' => 'form6_entry', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    //----------- Login Details-----//
    $vessel_details       		=   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   	= 	$vessel_details;
    
    //----------Owner Details--------------//
    $user			 = 	$this->Survey_model->get_user($customer_id);
    $data['user']    =	$user;

    $agent			 = 	$this->Survey_model->get_agent($customer_id);
    $data['agent']	 =	$agent;

    //-------Vessel Details---------------//
    $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessDetails']  =  $vessDetails; 

    $vesselType     = $vessDetails[0]['vessel_type_id'];
    $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
    $lengthOverDeck = $vessDetails[0]['vessel_length'];
    $engine_id      = $vessDetails[0]['engine_placement_id'];
    $hull_id        = $vessDetails[0]['hullmaterial_id'];
    $form_id=6;
    $heading_id=22;

    $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck, $hull_id, $engine_id, $form_id, $heading_id);
    $data['fieldstoShow']    =  $fieldstoShow;

    //print_r($fieldstoShow);
    if(!empty($fieldstoShow))
    {
      $conditionofItem         = 	$this->Survey_model->get_condition();
      $data['conditionofItem'] =	$conditionofItem;

      $cargo_nature         = 	$this->Survey_model->get_cargo_nature();
      $data['cargo_nature'] =	$cargo_nature;

      $this->load->view('Kiv_views/template/form-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/form6_entry', $data);
      $this->load->view('Kiv_views/template/form-footer.php');
    }
    else
    {
      $this->load->view('Kiv_views/Ajax_error.php');
    }
  }
  else
  {
    redirect('Main_login/index');        
  } 
}

/*_______________________________form 6 - vessel and hull details___________________*/

function saveform6_Tab1()
{

  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   	=	$this->session->userdata('customer_id');
  $survey_user_id	 	=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $vesselType         = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype      = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck     = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          	= $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));           
  $engine_id 			= $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $vesselId       = $this->security->xss_clean($this->input->post('hdn_vesselId')); 
  $surveyId  			= $this->security->xss_clean($this->input->post('hdn_surveyId')); 

  if((!empty($sess_usr_id)) && (($user_type_id==12) || ($user_type_id==13)))
  {	
    $data =	array('title' => 'form1', 'page' => 'form1', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $hull_condition_status_id 	=	$this->security->xss_clean($this->input->post('hull_condition_status_id'));
    $stability_test_time=	$this->security->xss_clean($this->input->post('stability_test_time'));
    $stability_test_duration=	$this->security->xss_clean($this->input->post('stability_test_duration'));
    $stability_test_particulars=$this->security->xss_clean($this->input->post('stability_test_particulars'));
    $clear_area_status    	=	$this->security->xss_clean($this->input->post('clear_area_status'));
    $cargo_nature    	=	$this->security->xss_clean($this->input->post('cargo_nature'));
    $area_of_operation    	=	$this->security->xss_clean($this->input->post('area_of_operation'));

    $ip=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date = 	date('Y-m-d h:i:s', time());

    $hulldetails         =  $this->Survey_model->get_hull_details_dynamic($vesselId,$surveyId);
    $data['hulldetails'] =  $hulldetails;

    if(!empty($hulldetails))
    {
      $hull_sl=$hulldetails[0]['hull_sl'];
    }

    $data_vessel=array(
    'stability_test_time'		=>$stability_test_time,
    'stability_test_duration'	=>$stability_test_duration,
    'stability_test_particulars'=>$stability_test_particulars,
    'clear_area_status'			=>$clear_area_status,
    'cargo_nature'				=>$cargo_nature,
    'area_of_operation'			=>$area_of_operation,
    'vessel_modified_user_id'	=>$sess_usr_id,
    'vessel_modified_timestamp'	=>$date,
    'vessel_modified_ipaddress'	=>$ip);

    $data_hull=array(
    'hull_condition_status_id'	=>$hull_condition_status_id,
    'hull_modified_user_id'		=>$sess_usr_id,
    'hull_modified_timestamp'	=>$date,
    'hull_modified_ipaddress'	=>$ip);

    $update_vessel_table		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vesselId);

    $update_hull_table		=	$this->Survey_model->update_initial_survey_hull_table('tbl_kiv_hulldetails',$data_hull,$hull_sl);

    if($update_vessel_table &&  $update_hull_table) 
    {
      // load ajax page      
      $form_id=6;
      $heading_id=23;

      $label_control_details = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck, $hull_id, $engine_id, $form_id, $heading_id);
      $data1['label_control_details']    =  $label_control_details;

      if(!empty($label_control_details))
      {
        $this->load->view('Kiv_views/Ajax_form6_engine.php',$data1);
      }
      else
      {
        $this->load->view('Kiv_views/Ajax_error.php');
      }
    }
  }
}
/*_______________________________form 6 - engine details___________________*/
function saveform6_Tab2()
  {
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   	=	$this->session->userdata('customer_id');
  $survey_user_id	 	=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $vesselType           = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype        = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck            = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));           
  $engine_id  = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId')); 

  $hulldetails         = 	$this->Survey_model->get_hull_details_dynamic($vessel_id,$survey_id);
  $data['hulldetails'] =	$hulldetails;
  if(!empty($hulldetails))
  {
    $hull_sl=$hulldetails[0]['hull_sl'];
  }

  if((!empty($sess_usr_id)) && (($user_type_id==12) || ($user_type_id==13)))
  {	
    $data =	array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $fuel_used_id 	=	$this->security->xss_clean($this->input->post('fuel_used_id'));
    $fuel_tank_material_condition_id=	$this->security->xss_clean($this->input->post('fuel_tank_material_condition_id'));
    $engine_room_overheat_id=	$this->security->xss_clean($this->input->post('engine_room_overheat_id'));
    $engine_description=	$this->security->xss_clean($this->input->post('engine_description'));

    $ip=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date = 	date('Y-m-d h:i:s', time());

    $data_vessel=array(

    'engine_room_overheat_id'	=>$engine_room_overheat_id,
    'vessel_modified_user_id'	=>$sess_usr_id,
    'vessel_modified_timestamp'	=>$date,
    'vessel_modified_ipaddress'	=>$ip);

    $data_engine=array(
    'fuel_used_id'		=>$fuel_used_id,
    'fuel_tank_material_condition_id'	=>$fuel_tank_material_condition_id,
    'engine_description'		=>$engine_description,
    'engine_modified_user_id'		=>$sess_usr_id,
    'engine_modified_timestamp'	=>$date,
    'engine_modified_ipaddress'	=>$ip);


    $update_vessel_table		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vesselId);

    $update_engine_table		=	$this->Survey_model->update_table_engine_form6('tbl_kiv_engine_details',$data_engine,$vesselId);

    if($update_vessel_table &&  $update_engine_table) 
    {
    // load ajax page      
      $form_id=6;
      $heading_id=24;
      $label_control_details = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck, $hull_id, $engine_id, $form_id, $heading_id);
      $data1['label_control_details']    =  $label_control_details;
      if(!empty($label_control_details))
      {
        $this->load->view('Kiv_views/Ajax_form6_machine.php',$data1);
      }
      else
      {
        $this->load->view('Kiv_views/Ajax_error.php');
      }
    }
  }
}
/*_______________________________form 6 - condition of vessel_____________________*/
function saveform6_Tab3()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   	=	$this->session->userdata('customer_id');
  $survey_user_id	 	=	$this->session->userdata('survey_user_id');

  $vesselType           = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype        = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck      = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));           
  $engine_id  = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId'));

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if((!empty($sess_usr_id)) && (($user_type_id==12) || ($user_type_id==13)))
  {	
    $data =	array('title' => 'form3', 'page' => 'form3', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $passenger_capacity 	=	$this->security->xss_clean($this->input->post('passenger_capacity'));
    $capacity_visible 		=	$this->security->xss_clean($this->input->post('capacity_visible'));
    $railing_status_id 		=	$this->security->xss_clean($this->input->post('railing_status_id'));
    $sand_box 				=	$this->security->xss_clean($this->input->post('sand_box'));
    $life_jacket 			=	$this->security->xss_clean($this->input->post('life_jacket'));
    $cabin_height 			=	$this->security->xss_clean($this->input->post('cabin_height'));
    $freeboard_height 		=	$this->security->xss_clean($this->input->post('freeboard_height'));
    $light_status_id 		=	$this->security->xss_clean($this->input->post('light_status_id'));
    $boat_accomodation_condition_status_id=	$this->security->xss_clean($this->input->post('boat_accomodation_condition_status_id'));

    $ip=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date = 	date('Y-m-d h:i:s', time());
    $data_vessel=array(
    'passenger_capacity'=>$passenger_capacity,
    'capacity_visible'	=>$capacity_visible,
    'railing_status_id'	=>$railing_status_id,
    /*'sand_box'			=>$sand_box,
    'life_jacket'		=>$life_jacket,*/
    'cabin_height'		=>$cabin_height,
    'freeboard_height'	=>$freeboard_height,
    'light_status_id'	=>$light_status_id,
    'boat_accomodation_condition_status_id'	=>$boat_accomodation_condition_status_id,
    'vessel_modified_user_id'	=>$sess_usr_id,
    'vessel_modified_timestamp'	=>$date,
    'vessel_modified_ipaddress'	=>$ip);


    $data_insert_sandbox = array(
    'vessel_id' 	=>	$vesselId,  
    'equipment_id'      =>  12,
    'equipment_type_id'	=> 	4,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip);

    $data_insert_lifejacket = array(
    'vessel_id' 	=>	$vesselId,  
    'equipment_id'      =>  17,
    'equipment_type_id'	=> 	11,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip);

    $result_insert_lifejacket=$this->db->insert('tbl_kiv_equipment_details', $data_insert_lifejacket);	
    $result_insert_sandbox=$this->db->insert('tbl_kiv_equipment_details', $data_insert_sandbox);	
    $update_vessel_table		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vesselId);
    if($result_insert_lifejacket &&  $update_vessel_table) 
    {
      // load ajax page      
      $form_id=6;
      $heading_id=25;
      $label_control_details = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck, $hull_id, $engine_id, $form_id, $heading_id);
      $data1['label_control_details']    =  $label_control_details;
      $data1['vesselId']=$vesselId;
      if(!empty($label_control_details))
      {
        $this->load->view('Kiv_views/Ajax_form6_crew.php',$data1);
      }
      else
      {
        $this->load->view('Kiv_views/Ajax_error.php');
      }
    }
  }
}
/*_______________________________form 6 - crew details_____________________*/

function saveform6_Tab4()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   	=	$this->session->userdata('customer_id');
  $survey_user_id	 	=	$this->session->userdata('survey_user_id');


  $vesselType           = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype        = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck            = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));           
  $engine_id  = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 

  $vessel_id 		= $this->security->xss_clean($this->input->post('hdn_vesselId'));
  $survey_id 		= $this->security->xss_clean($this->input->post('hdn_surveyId'));
  $processflow_sl 	=	$this->uri->segment(4);
  //$survey_id 		=	$this->uri->segment(5);
  if((!empty($sess_usr_id)) && (($user_type_id==12) || ($user_type_id==13)))
  {	
    $data =	array('title' => 'form4', 'page' => 'form4', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');


    $crew_type_sl  =	$this->security->xss_clean($this->input->post('crew_type_sl'));
    $name_of_type  =	$this->security->xss_clean($this->input->post('name_of_type'));
    if(!empty($name_of_type))
    {
      $name_of_type=$name_of_type ;
    }
    else
    {
      $name_of_type ="";
    }
    $crew_class_sl   =	$this->security->xss_clean($this->input->post('crew_class_sl'));
    $license_number_of_type  = 	$this->security->xss_clean($this->input->post('license_number_of_type'));
     
    $number=    $this->security->xss_clean($this->input->post('rowcount'));    

    $ip=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date 			= 	date('Y-m-d h:i:s', time());
    $data_crew=array();

    if(!empty($number))
    {
     for($i=0;$i<$number;$i++)
     {
        if(!empty($name_of_type))
        {
          $name_of_type12=$name_of_type[$i];
          if(!empty($name_of_type12))
          {
            $name_of_type_c=$name_of_type12;
          }
          else
          {
            $name_of_type_c="nil";
          }
        }
        else
        {
          $name_of_type_c="nil";
        }
      $data_crew[]= 	array(
      'vessel_id' =>$vessel_id,
      'survey_id' =>$survey_id,
      'crew_type_id'=>$crew_type_sl[$i],
      'name_of_type'  => $name_of_type_c,  
      //'name_of_type' 	=> $name_of_type[$i],  
      //'crew_class_id'            => $crew_class_sl[$i],
      'license_number_of_type'   => $license_number_of_type[$i],            
      'crew_created_user_id'=>$sess_usr_id,
      'crew_created_timestamp'=>	$date,
      'crew_created_ipaddress'=>	$ip);
     }
     $insert_data		=	$this->db->insert_batch('tbl_kiv_crew_details', $data_crew);
    }
    else
    {
      $insert_data="";
    }
    if($insert_data ) 
    {
      // load ajax page      
      $form_id=6;
      $heading_id=26;

      $label_control_details = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck, $hull_id, $engine_id, $form_id, $heading_id);
      $data1['label_control_details']    =  $label_control_details;
      if(!empty($label_control_details))
      {
        $this->load->view('Kiv_views/Ajax_form6_declaration.php',$data1);
      }
      else
      {
      $this->load->view('Kiv_views/Ajax_error.php');
      }
    }
  }
}

/*_______________________________form 6 - declaration details_____________________*/
function saveform6_Tab5()
  {
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   	=	$this->session->userdata('customer_id');
  $survey_user_id	 	=	$this->session->userdata('survey_user_id');

  $vesselType    = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype   = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck= $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id     = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));           
  $engine_id = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard'));
  $vessel_id 	= $this->security->xss_clean($this->input->post('hdn_vesselId'));
  $survey_id 		= $this->security->xss_clean($this->input->post('hdn_surveyId'));

  $processflow_sl = $this->security->xss_clean($this->input->post('processflow_sl'));
  $process_id =	$this->security->xss_clean($this->input->post('process_id')); 

  $user_id =	$this->security->xss_clean($this->input->post('user_id'));
  $user_type_id=	$this->security->xss_clean($this->input->post('user_type_id'));
  $status =	1;
  $status_details_sl =	$this->security->xss_clean($this->input->post('status_details_sl'));

  if((!empty($sess_usr_id)) && (($user_type_id==12) || ($user_type_id==13)))
    {	
    $data =	array('title' => 'form5', 'page' => 'form5', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');


    $form6_remarks  =	$this->security->xss_clean($this->input->post('form6_remarks'));
    $repair_details  =	$this->security->xss_clean($this->input->post('repair_details'));
    $declaration_issue_date1  =	$this->security->xss_clean($this->input->post('declaration_issue_date'));
    $declaration_issue_date 	= date("Y-m-d", strtotime($declaration_issue_date1));

    $ip=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date = 	date('Y-m-d h:i:s', time());
    $status_change_date =	$date;


    $data_vessel=array(
    'repair_details'=>$repair_details,
    'form6_remarks'		=>$form6_remarks,
    'declaration_issue_date'	=>$declaration_issue_date,
    'vessel_modified_user_id'	=>$sess_usr_id,
    'vessel_modified_timestamp'	=>$date,
    'vessel_modified_ipaddress'	=>$ip);

    $update_vessel_table		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vessel_id);

    //--process flow---//
    $data_insert=array(
    'vessel_id'=>$vessel_id,
    'process_id'=>$process_id,
    'survey_id'=>$survey_id,
    'current_status_id'=>5,
    'current_position'=>$user_type_id,
    'user_id'=>$sess_usr_id,
    'previous_module_id'=>$processflow_sl,
    'status'=>0,
    'status_change_date'=>$status_change_date);

    $data_update = array('status'=>0);
    $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
    $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
    $processflow_id     =   $this->db->insert_id();

    $new_process_id=10;
    //Assign form7
    $data_insert_form7=array(
    'vessel_id'=>$vessel_id,
    'process_id'=>$new_process_id,
    'survey_id'=>$survey_id,
    'current_status_id'=>1,
    'current_position'=>$user_type_id,
    'user_id'=>$sess_usr_id,
    'previous_module_id'=>$processflow_sl,
    'status'=>$status,
    'status_change_date'=>$status_change_date);

    $process_insert_form7=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_form7);

    $data_survey_status=array(
    'process_id'=>$new_process_id,
    'current_status_id'=>1,
    'sending_user_id'=>$sess_usr_id,
    'receiving_user_id'=>$sess_usr_id);
    $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
  }
}

/*_______________________________form 6 view_______________________________________*/

public function form6_view()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1		=	$this->uri->segment(4);
  $survey_id1		=	$this->uri->segment(5);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form6_view', 'page' => 'form6_view', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    //----------Vessel Details--------//
    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;

    //----------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']		=	$hull_details;

    //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']	=	$engine_details;
   

    //----------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details']	=	$equipment_details;
    

    //----------Get portable fire extinguisher---------------//
    $portable_fire_ext	= 	$this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id);
    $data['portable_fire_ext']	  =	  $portable_fire_ext;

    //--------------Documents-----------------//
    $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']		=	$list_document_vessel;
    @$id=$vessel_details_viewpage[0]['user_id'];


    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form6_view',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');
  }
}
/*_______________________________form 10 entry__________________________________*/

public function form10_entry()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id	    =	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id) && ($user_type_id==12))
  {
    $data 			=	 array('title' => 'form10_entry', 'page' => 'form10_entry', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details       		=   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   	= 	$vessel_details;

    //----------Owner Details--------------//
    $user			 = 	$this->Survey_model->get_user($customer_id);
    $data['user']    =	$user;

    $agent			 = 	$this->Survey_model->get_agent($customer_id);
    $data['agent']	 =	$agent;

    $formtype_location			 = 	$this->Survey_model->get_formtype_location();
    $data['formtype_location']	 =	$formtype_location;   


    $sandbox_location			 = 	$this->Survey_model->get_sandbox_location();
    $data['sandbox_location']	 =	$sandbox_location;   

    $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessDetails']  =  $vessDetails; 

    $vesselType     = $vessDetails[0]['vessel_type_id'];
    $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
    $lengthOverDeck = $vessDetails[0]['vessel_length'];
    $engine_id      = $vessDetails[0]['engine_placement_id'];
    $hull_id        = $vessDetails[0]['hullmaterial_id'];
    $form_id=10;
    $heading_id=27;

    $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck, $hull_id, $engine_id, $form_id, $heading_id);
    $data['fieldstoShow']    =  $fieldstoShow;

    if(!empty($fieldstoShow))
    {
      $conditionofItem         =   $this->Survey_model->get_condition();
      $data['conditionofItem'] =  $conditionofItem;
      $this->load->view('Kiv_views/template/form-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/form10_entry', $data);
      $this->load->view('Kiv_views/template/form-footer.php');
    }
    else
    {
      redirect('Kiv_Ctrl/Survey/csHome'); 
    }
  }
  else
  {
    redirect('Main_login/index');        
  } 
}

/*__________________form 10 - fire fighting equipment details_____________________*/
function saveform10_Tab1()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   	=	$this->session->userdata('customer_id');
  $survey_user_id	 	=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $vesselType         = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype      = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck     = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          	= $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));           
  $engine_id  		    = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 

  if(!empty($sess_usr_id) && ($user_type_id==12))
  {	
    $data =	array('title' => 'form1', 'page' => 'form1', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vesselId 					      =	$this->security->xss_clean($this->input->post('hdn_vesselId'));
    $hdn_equipment_id11 		  =	$this->security->xss_clean($this->input->post('hdn_equipment_id11'));
    $hdn_equipment_type_id4 	=	$this->security->xss_clean($this->input->post('hdn_equipment_type_id4'));
    $number11 					      =	$this->security->xss_clean($this->input->post('number11'));

    $hdn_equipment_id20 		  =	$this->security->xss_clean($this->input->post('hdn_equipment_id20'));
    $hdn_equipment_type_id10 	=	$this->security->xss_clean($this->input->post('hdn_equipment_type_id10'));
    $number20 				 	      =	$this->security->xss_clean($this->input->post('number20'));
    $location20 			 	      =	$this->security->xss_clean($this->input->post('location20'));

    $hdn_equipment_id21 	 	  =	$this->security->xss_clean($this->input->post('hdn_equipment_id21'));
    $number21 				 	      =	$this->security->xss_clean($this->input->post('number21'));
    $capacity21 			 	      =	$this->security->xss_clean($this->input->post('capacity21'));

    $heaving_line_count       = $this->security->xss_clean($this->input->post('heaving_line_count'));
    $oars                     = $this->security->xss_clean($this->input->post('oars'));
    $fire_axe                 = $this->security->xss_clean($this->input->post('fire_axe'));
    $lifebouys_moblight       = $this->security->xss_clean($this->input->post('lifebouys_moblight'));

    $vessel_length_overall      = $this->security->xss_clean($this->input->post('vessel_length_overall'));
    $vessel_breadth             = $this->security->xss_clean($this->input->post('vessel_breadth'));
    $vessel_depth               = $this->security->xss_clean($this->input->post('vessel_depth'));
    $vessel_upperdeck_length    = $this->security->xss_clean($this->input->post('vessel_upperdeck_length'));
    $vessel_upperdeck_breadth   = $this->security->xss_clean($this->input->post('vessel_upperdeck_breadth'));
    $vessel_upperdeck_depth     = $this->security->xss_clean($this->input->post('vessel_upperdeck_depth'));
    $additional_amount          = $this->security->xss_clean($this->input->post('additional_amount'));
    $remarks                    = $this->security->xss_clean($this->input->post('remarks'));
    $owner_user_id              = $this->security->xss_clean($this->input->post('owner_user_id'));

    $vessel_tonnage        =  round(($vessel_length_overall*$vessel_breadth*$vessel_depth)/2.83);
    $vessel_upperdeck_tonnage   = round(($vessel_upperdeck_length*$vessel_upperdeck_breadth*$vessel_upperdeck_depth)/2.83);
    $vessel_total_tonnage       =   $vessel_tonnage+$vessel_upperdeck_tonnage;   

    $ip=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date = 	date('Y-m-d h:i:s', time());

    if(!empty($additional_amount))
    {
      $data_additional_payment=array(
      'vessel_id'=>$vesselId,
      'vessel_owner_id'=>$owner_user_id,
      'additional_payment_amount'=>$additional_amount,
      'additional_payment_remarks'=>$remarks,
      'additional_payment_status'=>1,
      'additional_payment_created_user_id'=>$sess_usr_id,
      'additional_payment_created_timestamp'=>$date,
      'additional_payment_created_ipaddress'=>$ip);
      $result_additional_payment = $this->db->insert('tbl_kiv_additional_payment', $data_additional_payment);
    }  
    //------------insert fire bucket------------//
    $data_insert_firebucket = array(
    'vessel_id' 		=>	$vesselId,  
    'equipment_id'      =>  $hdn_equipment_id11,
    'equipment_type_id'	=> 	$hdn_equipment_type_id4,
    'number' 					   =>$number11,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip);
    $result_insert_firebucket = $this->db->insert('tbl_kiv_equipment_details', $data_insert_firebucket);
    //------insert fixed fire exstinguisher foam------//
    $data_insert_foam = array(
    'vessel_id' 			=>	$vesselId,  
    'equipment_id'      	=>  $hdn_equipment_id20,
    'equipment_type_id'		=> 	$hdn_equipment_type_id10,
    'number' 				=>	$number20,
    'location_id' 				=> 	$location20,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip);
    $result_insert_foam     = $this->db->insert('tbl_kiv_equipment_details', $data_insert_foam); 
    //------insert fixed fire exstinguisher CO2------//
    $data_insert_co2 = array(
    'vessel_id' 			=>	$vesselId,  
    'equipment_id'      	=>  $hdn_equipment_id21,
    'equipment_type_id'		=> 	$hdn_equipment_type_id10,
    'number' 				=>	$number21,
    'capacity' 				=> 	$capacity21,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip);
    $result_insert_co2    = $this->db->insert('tbl_kiv_equipment_details', $data_insert_co2); 
    /*______________Insertion of heaving line_____________________*/
    $data_insert_heaving_line= array(
    'vessel_id'     =>  $vesselId,  
    'equipment_id'      =>  '55',
    'equipment_type_id' =>  '1',
    'number'             =>$heaving_line_count,
    'equipment_created_user_id'    =>  $sess_usr_id,
    'equipment_created_timestamp'  => $date,
    'equipment_created_ipaddress'  => $ip);
    $result_insert_heaving_line= $this->db->insert('tbl_kiv_equipment_details', $data_insert_heaving_line);

    /*______________Insertion of oars_____________________*/
    $data_insert_oars= array(
    'vessel_id'     =>  $vesselId,  
    'equipment_id'      =>  '56',
    'equipment_type_id' =>  '4',
    'number'             =>$oars,
    'equipment_created_user_id'    =>  $sess_usr_id,
    'equipment_created_timestamp'  => $date,
    'equipment_created_ipaddress'  => $ip);
    $result_insert_oars= $this->db->insert('tbl_kiv_equipment_details', $data_insert_oars); 

    /*______________Insertion of fire axe_____________________*/
    $data_insert_fire_axe= array(
    'vessel_id'     =>  $vesselId,  
    'equipment_id'      =>  '57',
    'equipment_type_id' =>  '11',
    'number'             =>$fire_axe,
    'equipment_created_user_id'    =>  $sess_usr_id,
    'equipment_created_timestamp'  => $date,
    'equipment_created_ipaddress'  => $ip);
    $result_insert_fire_axe= $this->db->insert('tbl_kiv_equipment_details', $data_insert_fire_axe); 

    $data_vessel=array(
    'vessel_length_overall'=>$vessel_length_overall,
    'vessel_breadth'=>$vessel_breadth,
    'vessel_depth'=>$vessel_depth,
    'vessel_upperdeck_length'=>$vessel_upperdeck_length,
    'vessel_upperdeck_breadth'=>$vessel_upperdeck_breadth,
    'vessel_upperdeck_depth'=>$vessel_upperdeck_depth,
    'vessel_expected_tonnage'=>$vessel_tonnage,
    'vessel_total_tonnage'=>$vessel_total_tonnage,
    'lifebouys_moblight'=>$lifebouys_moblight,
    'vessel_modified_user_id' =>$sess_usr_id,
    'vessel_modified_timestamp' =>$date,
    'vessel_modified_ipaddress' =>$ip);
    $update_vessel_table    = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vesselId);

    if($result_insert_firebucket && $result_insert_foam  && $result_insert_co2)
    {
      $form_id=10;
      $heading_id=28;

      $label_control_details = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck, $hull_id, $engine_id, $form_id, $heading_id);
      $data1['label_control_details']    =  $label_control_details;
      if(!empty($label_control_details))
      {
        $this->load->view('Kiv_views/Ajax_form10_lifesave.php',$data1);
      }
      else
      {
        $this->load->view('Kiv_views/Ajax_error.php');
      }
    }
  }
}
/*__________________form 10 - life saving & pollution control devices________________*/

function saveform10_Tab2()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   	=	$this->session->userdata('customer_id');
  $survey_user_id	 	=	$this->session->userdata('survey_user_id');
  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $vesselType         = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype      = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck     = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          	= $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));           
  $engine_id  		= $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  //$vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId')); 
 
  if(!empty($sess_usr_id) && ($user_type_id==12))
  {	
    $data =	array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vesselId 					=	$this->security->xss_clean($this->input->post('hdn_vesselId'));
    $survey_id 					=	$this->security->xss_clean($this->input->post('hdn_surveyId'));
    $hdn_equipment_id17 		=	$this->security->xss_clean($this->input->post('hdn_equipment_id17'));
    $number17_adult 			=	$this->security->xss_clean($this->input->post('number17_adult'));
    $number17_children 			=	$this->security->xss_clean($this->input->post('number17_children'));

    $hdn_equipment_id18 		=	$this->security->xss_clean($this->input->post('hdn_equipment_id18'));
    $number18 					=	$this->security->xss_clean($this->input->post('number18'));
    $capacity18 				=	$this->security->xss_clean($this->input->post('capacity18'));

    $hdn_equipment_id19 		=	$this->security->xss_clean($this->input->post('hdn_equipment_id19'));
    $number19 	 				=	$this->security->xss_clean($this->input->post('number19'));
    $capacity19 				=	$this->security->xss_clean($this->input->post('capacity19'));

    $hdn_equipment_type_id11 	=	$this->security->xss_clean($this->input->post('hdn_equipment_type_id11'));
    $first_aid_box 				=	$this->security->xss_clean($this->input->post('first_aid_box'));
    $condition_of_equipment 	=	$this->security->xss_clean($this->input->post('condition_of_equipment'));
    $repair_details_nature		=	$this->security->xss_clean($this->input->post('repair_details'));

    $cntcount 					=	$this->security->xss_clean($this->input->post('cntcount'));
    $garbage_details=$this->Survey_model->get_garbage_details();
    $data['garbage_details'] =	$garbage_details;
    $cntcount=count($garbage_details);
    $ip=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date = 	date('Y-m-d h:i:s', time());

    //------------insert life jacket------------//
    $data_insert_lifejacket = array(
    'vessel_id' 		=>	$vesselId,  
    'equipment_id'      =>  $hdn_equipment_id17,
    'equipment_type_id'	=> 	$hdn_equipment_type_id11,
    'number_adult' 		=>	$number17_adult,
    'number_children' 	=>	$number17_children,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip );

    //------insert life boat------//
    $data_insert_lifeboat = array(
    'vessel_id' 			=>	$vesselId,  
    'equipment_id'      	=>  $hdn_equipment_id18,
    'equipment_type_id'		=> 	$hdn_equipment_type_id11,
    'number' 				=>	$number18,
    'capacity' 				=> 	$capacity18,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip );

    //------insert life raft------//
    $data_insert_liferaft = array(
    'vessel_id' 			=>	$vesselId,  
    'equipment_id'      	=>  $hdn_equipment_id19,
    'equipment_type_id'		=> 	$hdn_equipment_type_id11,
    'number' 				=>	$number19,
    'capacity' 				=> 	$capacity19,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  =>	$date,
    'equipment_created_ipaddress'  =>	$ip);

    //--------Update vessel details table-----------------//
    $data_vessel=array(
    'first_aid_box'=>$first_aid_box,
    'condition_of_equipment'		=>$condition_of_equipment,
    'repair_details_nature'	=>$repair_details_nature,
    'vessel_modified_user_id'	=>$sess_usr_id,
    'vessel_modified_timestamp'	=>$date,
    'vessel_modified_ipaddress'	=>$ip);

    //------insert garbage bucket provider------//
    for($i=1;$i<=$cntcount;$i++)
    {
      $garbage_id=$this->security->xss_clean($this->input->post('garbage'.$i));
      if($garbage_id!=0)
      {
        $data_garbage 	= 	array(
        'vessel_id' 				=> 	$vesselId,
        'survey_id' 				=> 	$survey_id,
        'garbage_id' 				=>	$garbage_id,
        'garbage_created_user_id'	=>	$sess_usr_id,
        'garbage_created_timestamp'	=>	$date,
        'garbage_created_ipaddress'	=>	$ip
        );
        $usr_res=$this->Survey_model->insert_table3('tbl_kiv_garbage_bucket_provider_details', $data_garbage); 
      }
    }

    $update_vessel_table		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vesselId);

    $result_insert_lifejacket	=	$this->db->insert('tbl_kiv_equipment_details', $data_insert_lifejacket);	
    $result_insert_lifeboat 	=	$this->db->insert('tbl_kiv_equipment_details', $data_insert_lifeboat);	
    $result_insert_liferaft		=	$this->db->insert('tbl_kiv_equipment_details', $data_insert_liferaft);	
    if($result_insert_lifejacket && $result_insert_lifeboat  && $result_insert_liferaft  && $update_vessel_table)
    {
      $form_id=10;
      $heading_id=29;
      $label_control_details = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck, $hull_id, $engine_id, $form_id, $heading_id);
      $data1['label_control_details']    =  $label_control_details;

      if(!empty($label_control_details))
      {
        $this->load->view('Kiv_views/Ajax_form10_controlvalidity.php',$data1);
      }
      else
      {
        $this->load->view('Kiv_views/Ajax_error.php');
      }
    }
  }
}
/*_____________________________form 10 - capacity and validity____________________*/

function saveform10_Tab3()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id      = $this->session->userdata('customer_id');
  $survey_user_id   = $this->session->userdata('survey_user_id');

  $vessel_id1     = $this->uri->segment(4);
  $processflow_sl1  = $this->uri->segment(5);
  $survey_id1     = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id) && ($user_type_id==12))
  { 
    $data = array('title' => 'form3', 'page' => 'form3', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $upper_deck_passenger        =  $this->security->xss_clean($this->input->post('upper_deck_passenger'));
    $lower_deck_passenger        =  $this->security->xss_clean($this->input->post('lower_deck_passenger'));
    $four_cruise_passenger       =  $this->security->xss_clean($this->input->post('four_cruise_passenger'));
    $validity_fire_extinguisher2 = $this->security->xss_clean($this->input->post('validity_fire_extinguisher'));
    $validity_of_insurance2     = $this->security->xss_clean($this->input->post('validity_of_insurance'));
    $next_drydock_date2         = $this->security->xss_clean($this->input->post('next_drydock_date'));
    $validity_of_certificate2   = $this->security->xss_clean($this->input->post('validity_of_certificate'));
    $form10_remarks             = $this->security->xss_clean($this->input->post('form10_remarks'));
    $vesselId                   = $this->security->xss_clean($this->input->post('hdn_vesselId'));

    $validity_fire_extinguisher1    = str_replace('/', '-', $validity_fire_extinguisher2);
    $validity_of_insurance1         = str_replace('/', '-', $validity_of_insurance2);
    $next_drydock_date1             = str_replace('/', '-', $next_drydock_date2);
    $validity_of_certificate1       = str_replace('/', '-', $validity_of_certificate2);
        
    $validity_fire_extinguisher     = date("Y-m-d", strtotime($validity_fire_extinguisher1));
    $validity_of_insurance          = date("Y-m-d", strtotime($validity_of_insurance1));
    $next_drydock_date              = date("Y-m-d", strtotime($next_drydock_date1));
    $validity_of_certificate        = date("Y-m-d", strtotime($validity_of_certificate1));

    $vessel_survey_number       = $this->security->xss_clean($this->input->post('vessel_survey_number'));
    $vessel_registration_number = $this->security->xss_clean($this->input->post('vessel_registration_number'));

    $survey_id                   =  $this->security->xss_clean($this->input->post('hdn_surveyId'));
    $processflow_sl              =  $this->security->xss_clean($this->input->post('processflow_sl'));
    $process_id                  =  $this->security->xss_clean($this->input->post('process_id')); 
    $user_id                     =  $this->security->xss_clean($this->input->post('user_id'));
    $user_type_id                =  $this->security->xss_clean($this->input->post('user_type_id'));
    $status                      =  1;
    $status_details_sl           =  $this->security->xss_clean($this->input->post('status_details_sl'));
    $owner_user_type_id          =  $this->security->xss_clean($this->input->post('owner_user_type_id'));
    $owner_user_id               =  $this->security->xss_clean($this->input->post('owner_user_id'));
    //_____________________________email/sms data collection start___________________________________//
    $ref_process_id=1;
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

    $ref_process_id=1;
    $ref_number_details_forms     =   $this->Survey_model->get_ref_number_details_forms($vessel_id,$ref_process_id);
    $data['ref_number_details_forms'] =   $ref_number_details_forms;

    if(!empty($ref_number_details_forms))
    {
      $ref_number_forms       = $ref_number_details_forms[0]['ref_number'];
    }
    else
    {
      $ref_number_forms =   "";
    }

    $customer_details       = $this->Survey_model->get_customer_details($owner_user_id);
    $data['customer_details'] = $customer_details;

    $owner_name         = $customer_details[0]['user_name'];
    $user_mobile_number = $customer_details[0]['user_mobile_number'];
    $user_email         = $customer_details[0]['user_email'];

     //----------Vessel Details--------//
    $vessel_details_viewpage        = $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;

    $vessel_name              = $vessel_details_viewpage[0]['vessel_name'];
    $portofregistry_sl        = $vessel_details_viewpage[0]['vessel_registry_port_id'];
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
    //___________________________email/sms data collection end__________________________________//


    //____________________Get survey intimation :  tbl_kiv_survey_intimation ____________________//

    $survey_intimation          = $this->Survey_model->get_survey_intimation_details($vesselId,$survey_id);
    $data['survey_intimation']  = $survey_intimation;
    if(!empty($survey_intimation))
    {
      foreach ($survey_intimation as $key ) 
      {
        $defect_status      = $key['defect_status'];
        $survey_defects_id  = $key['survey_defects_id'];
        if($defect_status==0)
        {
          $date_of_survey       = $survey_intimation[0]['date_of_survey'];
          $adding_one_year      = date('d-m-Y', strtotime($date_of_survey . "1 year") );
          $adding_five_year     = date('d-m-Y', strtotime($date_of_survey . "5 year") );
          $annual_survey_date   = date("Y-m-d", strtotime($adding_one_year));
          $drydock_survey_date  = date("Y-m-d", strtotime($adding_five_year));
          $date_of_survey3= date("d-m-Y", strtotime($date_of_survey));


        }
        else
        {
          $survey_intimation_defects= $this->Survey_model->get_survey_intimation_defects($survey_defects_id);
          $data['survey_intimation_defects'] =  $survey_intimation_defects;
          $date_of_survey       = $survey_intimation_defects[0]['date_of_survey'];
          $adding_one_year      = date('d-m-Y', strtotime($date_of_survey . "1 year") );
          $adding_five_year     = date('d-m-Y', strtotime($date_of_survey . "5 year") );
          $annual_survey_date   = date("Y-m-d", strtotime($adding_one_year));
          $drydock_survey_date  = date("Y-m-d", strtotime($adding_five_year));
          $date_of_survey3        = date("d-m-Y", strtotime($date_of_survey));
        }
      }
    }
    $ip=  $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date =   date('Y-m-d h:i:s', time());
    $status_change_date   = $date;
    //________________________Update vessel details table__________________________//
    $additional_payment_details=$this->Survey_model->get_additional_payment_details($vesselId);
    $data['additional_payment_details'] =  $additional_payment_details;

    if(!empty($additional_payment_details))
    {
      $additional_payment=$additional_payment_details[0]['additional_payment_amount'];
      $additional_payment_remarks=$additional_payment_details[0]['additional_payment_remarks'];

      $data_vessel=array(
      'lower_deck_passenger'    =>$lower_deck_passenger,
      'upper_deck_passenger'    =>$upper_deck_passenger,
      'four_cruise_passenger'   =>$four_cruise_passenger,
      'vessel_modified_user_id' =>$sess_usr_id,
      'vessel_modified_timestamp' =>$date,
      'vessel_modified_ipaddress' =>$ip);

      $update_vessel_table  = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vesselId);
      //_________________________________process flow start___________________________________//

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $new_process_id=31;
      $data_insert_form7=array(
      'vessel_id'=>$vesselId,
      'process_id'=>$new_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>1,
      'current_position'=>$owner_user_type_id,
      'user_id'=>$owner_user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);
      $process_insert_form7=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_form7);
      $data_survey_status=array(
      'process_id'=>$new_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>1,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$owner_user_id);
      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      //_____________________________Email sending start_____________________________//
      $email_subject="Additional Amount for Survey Certificate of ".$vessel_name."";
      $email_message="<div><h4>Dear ". $owner_name.",</h4><p>An additional amount of Rs.".$additional_payment." shall be remitted for generating Survey Certificate. Reason for additional amount :<b>".$additional_payment_remarks."</b>. <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
      $saji_email="bssajitha@gmail.com";
      $this->emailSendFunction($saji_email,$email_subject,$email_message);
      //$this->emailSendFunction($user_email,$email_subject,$email_message);
      //___________________Email sending start___________________________________________//
      //____________________SMS sending start____________________________________________//
      $sms_message="For generating Certificate of Survey for ".$vessel_name.", kindly remit amount of Rs. ".$additional_payment." through portinfo.kerala.gov.in ";
      $this->load->model('Kiv_models/Survey_model');
      $saji_mob="9847903241";
      //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
      //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
      //____________________SMS sending end________________________________________________//


     /* if($process_update && $process_insert_form7 && $status_update)
      {
        $this->load->view('Kiv_views/csHome');
      }*/
      /*_________________________________process flow end___________________________________*/
    }
    else
    {
      $data_vessel=array(
      'lower_deck_passenger'    =>$lower_deck_passenger,
      'upper_deck_passenger'    =>$upper_deck_passenger,
      'four_cruise_passenger'   =>$four_cruise_passenger,
      'validity_fire_extinguisher'=>$validity_fire_extinguisher,
      'validity_of_insurance'   =>$validity_of_insurance,
      'validity_of_certificate' =>$validity_of_certificate,
      'form10_remarks'         =>$form10_remarks,
      'vessel_modified_user_id' =>$sess_usr_id,
      'vessel_modified_timestamp' =>$date,
      'vessel_modified_ipaddress' =>$ip);

      $update_vessel_table  = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vesselId);
      //____________________survey-initial survey date insertion__________________________//
      $timeline_data_initial = array('vessel_id' =>$vesselId ,
      'survey_number' => $vessel_survey_number,
      'process_id' => 1,
      'subprocess_id' => 1,
      'scheduled_date' => $date_of_survey,
      'actual_date' => $date_of_survey,
      'status' => 1,
      'link_id' => '-1',
      'timeline_created_user_id' => $sess_usr_id,
      'timeline_created_timestamp' =>$date,
      'timeline_created_ipaddress' => $ip);

      $insert_timeline_initial=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_initial);               
     //_______________________________survey-annual survey date insertion______________________//

      $timeline_data_annual = array('vessel_id' =>$vesselId ,
      'survey_number' => $vessel_survey_number,
      'process_id' => 1,
      'subprocess_id' => 2,
      'scheduled_date' => $annual_survey_date,
      'status' => 0,
      //'link_id' => 0,
      'link_id' => '-1',
      'timeline_created_user_id' => $sess_usr_id,
      'timeline_created_timestamp' =>$date,
      'timeline_created_ipaddress' => $ip);
      $insert_timeline_annual=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_annual);               
      //__________________________survey-drydock survey date insertion_____________________//

      $timeline_data_drydock = array('vessel_id' =>$vesselId ,
      'survey_number' => $vessel_survey_number,
      'process_id' => 1,
      'subprocess_id' => 3,
      'scheduled_date' => $drydock_survey_date,
      'status' => 0,
      //'link_id' => 0,
      'link_id' => '-1',
      'timeline_created_user_id' => $sess_usr_id,
      'timeline_created_timestamp' =>$date,
      'timeline_created_ipaddress' => $ip);
      $insert_timeline_drydock=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_drydock);

      //_________________________________process flow start___________________________________//
     $data_insert=array(
      'vessel_id'=>$vesselId,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$user_type_id,
      'user_id'=>$user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>0,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id   =   $this->db->insert_id();
      $new_process_id=14;
      $data_insert_form7=array(
      'vessel_id'=>$vesselId,
      'process_id'=>$new_process_id,
      //'survey_id'=>$survey_id,
      'survey_id'=>0,
      'current_status_id'=>1,
      'current_position'=>$owner_user_type_id,
      'user_id'=>$owner_user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);
      $process_insert_form7=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_form7);
      $data_survey_status=array(
      'process_id'=>$new_process_id,
      'survey_id'=>0,
      'current_status_id'=>1,
      'sending_user_id'=>$user_id,
      'receiving_user_id'=>$owner_user_id);
      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      $data_main=array('processing_status'=>0);   
      $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vesselId);
      /*_________________________________process flow end___________________________________*/
      //_____________________________Email sending start_____________________________//
      $email_subject="Certificate of survey for ".$vessel_name." is ready for delivery";
      $email_message="<div><h4>Dear ". $owner_name.",</h4><p>Certifictate of Survey is generated for <b>".$vessel_name."</b>. Certificate of survey can be downloaded by login to portinfo.kerala.gov.in under the menu Survey Certificate.<br>
      Survey number for <b>".$vessel_name."</b> vessel is : <b>".$vessel_survey_number."</b> <br>
      Survey date : <b>".$date_of_survey3."</b><br>
      Next annual survey date is on : <b> ".$adding_one_year."</b><br>  
      Next drydock date is on : <b> ".$adding_five_year."</b><br>
      <br>Please note the reference number : <b>".$ref_number_forms."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
      $saji_email="bssajitha@gmail.com";
      $this->emailSendFunction($saji_email,$email_subject,$email_message);
      //$this->emailSendFunction($user_email,$email_subject,$email_message);
      //___________________Email sending start___________________________________________//
      //____________________SMS sending start____________________________________________//
      $sms_message="Certificate of survey is generated for ".$vessel_name.". Certificate of survey can be downloaded from portinfo.kerala.gov.in. Now you can proceed for registration of vessel.";
      $this->load->model('Kiv_models/Survey_model');
      $saji_mob="9847903241";
      //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
      //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
      //____________________SMS sending end________________________________________________//


      /*___________________________update reference number start____________________________*/
      $process_id=1;
      $ref_number_details     =   $this->Survey_model->get_ref_number_details($vessel_id,$process_id);
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
      }   /*____________________________update reference number end_______________________*/
    }
 }
}

//____________________________________Form 5________________________________//

public function form5_entry()
{ 
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id	    =	$this->session->userdata('survey_user_id');

  $vesselId1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vesselId=str_replace(array('-', '_', '~'), array('+', '/', '='), $vesselId1);
  $vesselId=$this->encrypt->decode($vesselId); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id) && (($user_type_id==12) || ($user_type_id==13)))
  {
    $data 			=	 array('title' => 'form5_entry', 'page' => 'form5_entry', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    //----------- Login Details-----//
    $vessel_details       		=   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   	= 	$vessel_details;
    //----------Owner Details--------------//
    $user			 = 	$this->Survey_model->get_user($customer_id);
    $data['user']    =	$user;

    $agent			 = 	$this->Survey_model->get_agent($customer_id);
    $data['agent']	 =	$agent;
    //-------Vessel Details---------------//

    $form_id=5;
    $heading=10;
    $data['vesselId']  =  $vesselId;
    $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vesselId);
    $data['vessDetails']  =  $vessDetails;//print_r($vessDetails);//exit; 
    $vesselType     = $vessDetails[0]['vessel_type_id'];
    $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
    $lengthOverDeck = $vessDetails[0]['vessel_length'];
    $engine_id      = $vessDetails[0]['engine_placement_id'];
    $hull_id        = $vessDetails[0]['hullmaterial_id'];

    $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
    $data['fieldstoShow']    =  $fieldstoShow;//print_r($fieldstoShow);exit;//get_labels();

    if(!empty($fieldstoShow))
    {
      $conditionofItem         = 	$this->Survey_model->get_condition();
      $data['conditionofItem'] =	$conditionofItem;
      $this->load->view('Kiv_views/template/form-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/form5_entry', $data);
      $this->load->view('Kiv_views/template/form-footer.php');
      }
    else
    {
      $this->load->view('Kiv_views/Ajax_error.php');
    }
  }
  else
  {
    redirect('Main_login/index');        
  } 
}

/*__________________________Form 5 - vessel details_________________________*/

function form5_saveTab1()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id        =   $this->session->userdata('customer_id');
  $survey_user_id     =   $this->session->userdata('survey_user_id');

  $ip     = $_SERVER['REMOTE_ADDR'];
  date_default_timezone_set("Asia/Kolkata");
  $date   =   date('Y-m-d h:i:s', time()); 
  if(!empty($sess_usr_id) && (($user_type_id==12) || ($user_type_id==13)))
    {
    $data = array('title' => 'form1', 'page' => 'form1', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $this->form_validation->set_rules('grt', 'Gross Registered Tonnage', 'required|callback_float_check');
    $this->form_validation->set_rules('nrt', 'Net Registered Tonnage', 'required|callback_float_check');
    $this->form_validation->set_rules('placeofBuild', 'Place of build', 'required|callback_alphanum_check');
    $this->form_validation->set_rules('dateofBuild', 'Date of build', 'required|callback_date_check');
    /*  if ($this->form_validation->run() == FALSE)
    {
    $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
    echo "val_errors";

    }   
    else  
    {*/ 
    /*get data from first tab*/
    $vesselType           = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
    $vesselSubtype        = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
    $lengthOverDeck       = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
    $hull_id          	  = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));           
    $engine_id  		 = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
    $vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId')); 
    $grt  = $this->security->xss_clean($this->input->post('grt')); 
    $nrt  = $this->security->xss_clean($this->input->post('nrt')); 
    //$cargo_nature  = $this->security->xss_clean($this->input->post('cargo_nature')); 
    $placeofBuild  = $this->security->xss_clean($this->input->post('placeofBuild')); 
    $dateofBuild2  = $this->security->xss_clean($this->input->post('dateofBuild')); 
    $area_of_operation  = $this->security->xss_clean($this->input->post('area_of_operation')); 

    $dateofBuild1 = str_replace('/', '-', $dateofBuild2);
    $dateofBuild = date("Y-m-d", strtotime($dateofBuild1));   
    /*get data from first tab*/

    $data_vessel = array(
      'grt'                        =>  $grt,  
      'nrt'                        =>  $nrt,
      'build_place'                =>  $placeofBuild,
      'build_date'                 =>  $dateofBuild,
     'area_of_operation'           =>  $area_of_operation,
      'vessel_modified_user_id'    =>  $sess_usr_id,
      'vessel_modified_timestamp'  =>  $date,
      'vessel_modified_ipaddress'  =>  $ip);


    $update_vessel_table		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vesselId);
    if($update_vessel_table)
    {
      $form_id=5;
      $heading=11;
      $data['vesselId']=$vesselId;

      $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
      $data['fieldstoShow']    =  $fieldstoShow;//print_r($allFields);//exit;get_labels();

      $conditionofItem         =  $this->Survey_model->get_condition();
      $data['conditionofItem'] =  $conditionofItem;
      $cargo_nature         = 	$this->Survey_model->get_cargo_nature();
      $data['cargo_nature'] =	$cargo_nature;
      if(!empty($conditionofItem))
      {
        $this->load->view('Kiv_views/Ajax_form5_hullDetails.php',$data);
      }
    }
  }
  else
  {
    redirect('Main_login/index');      
  }
}
/*__________________________Form 5 - hull details_________________________*/

function form5_saveTab2()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id        =   $this->session->userdata('customer_id');
  $survey_user_id     =   $this->session->userdata('survey_user_id');
  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $vesselType          = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype       = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck      = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          	= $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));          
  $engine_id  		= $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId')); 

  $ip     = $_SERVER['REMOTE_ADDR'];
  date_default_timezone_set("Asia/Kolkata");
  $date   =   date('Y-m-d h:i:s', time()); 

  if(!empty($sess_usr_id) && (($user_type_id==12) || ($user_type_id==13)))
  {
    $data = array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 
    $this->load->model('Kiv_models/Survey_model');

    $this->form_validation->set_rules('lengthIdentification', 'Identification Length', 'required|callback_float_check');
    $this->form_validation->set_rules('conditionofHull', 'Condition of Hull', 'required');

    /* if ($this->form_validation->run() == FALSE)
    {
    $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
    echo "val_errors";
    }   
    else  
    {*/
    $lengthIdentification = $this->security->xss_clean($this->input->post('lengthIdentification'));
    $conditionofHull      = $this->security->xss_clean($this->input->post('conditionofHull'));
    $cargo_nature  = $this->security->xss_clean($this->input->post('cargo_nature')); 

    $hulldetails         = 	$this->Survey_model->get_hull_details_dynamic($vesselId,$survey_id);
    $data['hulldetails'] =	$hulldetails;
    if(!empty($hulldetails))
    {
      $hull_sl=$hulldetails[0]['hull_sl'];
    }
    else
    {
      $hull_sl=0;
    }
    $data_hull = array(
    'identification_length'    =>  $lengthIdentification,  
    'hull_condition_status_id' =>  $conditionofHull,
    'hull_modified_user_id'    =>  $sess_usr_id,
    'hull_modified_timestamp'  =>  $date,
    'hull_modified_ipaddress'  =>  $ip);

    $data_vessel = array('cargo_nature' =>  $cargo_nature,
    'vessel_modified_user_id'    =>  $sess_usr_id,
    'vessel_modified_timestamp'  =>  $date,
    'vessel_modified_ipaddress'  =>  $ip);

    $update_vessel_table		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vesselId);

    $update_table		=	$this->Survey_model->update_initial_survey_hull_table('tbl_kiv_hulldetails',$data_hull,$hull_sl);
    //if($update_table) {
    /*Load the next tab, particulars of engine*/

    $form_id=5;
    $heading=12;
    $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
    $data['fieldstoShow']    =  $fieldstoShow;//print_r($allFields);//exit;get_labels();

    $conditionofItem         =  $this->Survey_model->get_condition();
    $data['conditionofItem'] =  $conditionofItem;

    $meansofPropulsionShaft         =  $this->Survey_model->get_meansofpropulsionShaft();
    $data['meansofPropulsionShaft'] =  $meansofPropulsionShaft; 

    $engineType         =  $this->Survey_model->get_enginetype();
    $data['engineType'] =  $engineType; 
    $this->load->view('Kiv_views/Ajax_form5_particularsofEngine.php',$data);
  }
  else
  {
    redirect('Main_login/index');      
  }
}
/*__________________________Form 5 - engine details_________________________*/

function form5_saveTab3()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id        =   $this->session->userdata('customer_id');
  $survey_user_id     =   $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $vesselType          = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype       = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck      = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          	= $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));          
  $engine_id  		= $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId')); 

  $ip     = $_SERVER['REMOTE_ADDR'];
  date_default_timezone_set("Asia/Kolkata");
  $date   =   date('Y-m-d h:i:s', time()); 

  if(!empty($sess_usr_id) && (($user_type_id==12) || ($user_type_id==13)))
    {
    $data = array('title' => 'form3', 'page' => 'form3', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 
    $this->load->model('Kiv_models/Survey_model');

    /*$this->form_validation->set_rules('meansofpropulsion_shaft', 'Means of propulsion shaft', 'required');
    $this->form_validation->set_rules('propeller_shaft_drawn_date', 'Propeller shaft last drawn', 'required');
    $this->form_validation->set_rules('horsepowerofEngine', 'Total horse power of main engine', 'required');
    $this->form_validation->set_rules('conditionofMachinery', 'Condition of machinery', 'required');
    $this->form_validation->set_rules('engine_description', 'Description of engine', 'required');
    $this->form_validation->set_rules('dateofConstruction', 'Date of Construction', 'required');
    //$this->form_validation->set_rules('modelNumber', 'Model Number', 'required');

    if ($this->form_validation->run() == FALSE)
    {
    $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
    echo "val_errors";
    }   
    else  
    {*/
    /*get data from first tab*/  
    //print_R($_POST);      
    $meansofpropulsion_shaft    = $this->security->xss_clean($this->input->post('meansofpropulsion_shaft'));
    $propeller_shaft_drawn_date2 = $this->security->xss_clean($this->input->post('propeller_shaft_drawn_date'));        
    $horsepowerofEngine         = $this->security->xss_clean($this->input->post('horsepowerofEngine'));
    $conditionofMachinery       = $this->security->xss_clean($this->input->post('conditionofMachinery'));       
    $engine_description         = $this->security->xss_clean($this->input->post('engine_description'));
    $dateofConstruction2        = $this->security->xss_clean($this->input->post('dateofConstruction'));       
    $modelNumber                = $this->security->xss_clean($this->input->post('modelNumber'));
    //$engine_description=	$this->security->xss_clean($this->input->post('engine_description'));

    $dateofConstruction1 = str_replace('/', '-', $dateofConstruction2);
    $dateofConstruction = date("Y-m-d", strtotime($dateofConstruction1)); 

    $propeller_shaft_drawn_date1 = str_replace('/', '-', $propeller_shaft_drawn_date2);
    $propeller_shaft_drawn_date = date("Y-m-d", strtotime($propeller_shaft_drawn_date1)); 


    $engine_data = array(
    'propulsion_means_id'        =>  $meansofpropulsion_shaft,  
    'propeller_shaft_drawn'      =>  $propeller_shaft_drawn_date,  
    'horsepowerofEngine'         =>  $horsepowerofEngine,
    'engine_condition_id'        =>  $conditionofMachinery,
    'engine_description'         =>  $engine_description,
    'dateofConstruction'         =>  $dateofConstruction,
    'model_number'               =>  $modelNumber, 
    'engine_modified_user_id'    =>  $sess_usr_id,
    'engine_modified_timestamp'  =>  $date,
    'engine_modified_ipaddress'  =>  $ip);

    $update_enginedetails=$this->Survey_model->update_table_engine_byvessel('tbl_kiv_engine_details',$engine_data,$vesselId);
    if($update_enginedetails)    
    {
      $form_id=5;
      $heading=13;

      $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
      $data['fieldstoShow']    =  $fieldstoShow;

      $conditionofItem         =  $this->Survey_model->get_condition();
      $data['conditionofItem'] =  $conditionofItem;

      $locationDet         =  $this->Survey_model->get_location();
      $data['locationDet'] =  $locationDet;
      $this->load->view('Kiv_views/Ajax_form5_machine.php',$data);
    }  
    else
    {

    }   
  }
  else
  {
    redirect('Main_login/index');        
  } 
}
/*__________________________Form 5 - machine details_________________________*/

function form5_saveTab4()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id        =   $this->session->userdata('customer_id');
  $survey_user_id     =   $this->session->userdata('survey_user_id'); 

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $vesselType          = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype       = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck      = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          	= $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));          
  $engine_id  		= $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId')); 

  $ip     = $_SERVER['REMOTE_ADDR'];
  date_default_timezone_set("Asia/Kolkata");
  $date   =   date('Y-m-d h:i:s', time()); 

  if(!empty($sess_usr_id) && (($user_type_id==12) || ($user_type_id==13)))
  {
    $data = array('title' => 'form4', 'page' => 'form4', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 
    $this->load->model('Kiv_models/Survey_model');

    $this->form_validation->set_rules('numberofBoats', 'Number of boats', 'required|callback_num_check');

    $this->form_validation->set_rules('lifeBuoys_desc', 'Description of Life buoys', 'required|callback_alphanum_check');

    $this->form_validation->set_rules('buoyancyApparatus_desc', 'Description of Buoyancy apparatus', 'required|callback_alphanum_check');
    $this->form_validation->set_rules('navigationLight_desc', 'Description of Navigation light', 'required|callback_alphanum_check');
    $this->form_validation->set_rules('anchor_total_num', ' Anchor Total Number', 'required|callback_num_check');


    $this->form_validation->set_rules('fireBucketsNumber', 'Number of Fire Buckets', 'required|callback_num_check');
    $this->form_validation->set_rules('location', 'Location', 'required');
    $this->form_validation->set_rules('conditionofEquipment', 'Condition of equipment', 'required');

    /* if ($this->form_validation->run() == FALSE)
    {
    $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
    echo "val_errors";
    }   
    else  
    {*/
    /*get data from first tab*/        

    $numberofBoats = $this->security->xss_clean($this->input->post('numberofBoats'));

    $lifeBuoys_desc = $this->security->xss_clean($this->input->post('lifeBuoys_desc'));
    $buoyancyApparatus_desc = $this->security->xss_clean($this->input->post('buoyancyApparatus_desc'));
    $navigationLight_desc    = $this->security->xss_clean($this->input->post('navigationLight_desc'));
    $anchor_total_num    = $this->security->xss_clean($this->input->post('anchor_total_num'));


    $fireBucketsNumber             = $this->security->xss_clean($this->input->post('fireBucketsNumber'));       
    $location                      = $this->security->xss_clean($this->input->post('location'));       
    $conditionofEquipment          = $this->security->xss_clean($this->input->post('conditionofEquipment'));

    /*get data from first tab*/

    for ($i = 1; $i <= $numberofBoats; $i++)
    {
      $lengthbt = $this->security->xss_clean($this->input->post('lengthbt'.$i));
      $breadthbt= $this->security->xss_clean($this->input->post('breadthbt'.$i));
      $depthbt= $this->security->xss_clean($this->input->post('depthbt'.$i));
      $boatData = array(
      'vessel_id'                 =>  $vesselId,
      'length'                    =>  $lengthbt,  
      'breadth'                   =>  $breadthbt,  
      'depth'                     =>  $depthbt,
      'boat_created_user_id'      =>  $sess_usr_id,
      'boat_created_timestamp'    =>  $date,
      'boat_created_ipaddress'    =>  $ip,
      'delete_status'             =>  '0');            
      $boatData_insert = $this->db->insert('tbl_kiv_boat_details', $boatData);
    }
    //------------insert fire bucket------------//
    $data_insert_firebucket = array(
    'vessel_id'     =>  $vesselId,  
    'equipment_id'      =>  '11',
    'equipment_type_id' =>  '4',
    'number'             =>$fireBucketsNumber,
    'equipment_created_user_id'    =>   $sess_usr_id,
    'equipment_created_timestamp'  => $date,
    'equipment_created_ipaddress'  => $ip);
    $result_insert_firebucket = $this->db->insert('tbl_kiv_equipment_details', $data_insert_firebucket);  
    //condition_of_equipment--tbl_kiv_vessel_details
    /*$data = array(
    'propulsion_means_id'        =>  $meansofpropulsion_shaft,  
    'propeller_shaft_drawn'      =>  $propeller_shaft_drawn_date,  
    'horsepowerofEngine'         =>  $horsepowerofEngine,
    'engine_condition_id'        =>  $conditionofMachinery,
    'engine_description'         =>  $engine_description,
    'dateofConstruction'         =>  $dateofConstruction,
    'model_number'               =>  $modelNumber, 
    'engine_modified_user_id'    =>  $sess_usr_id,
    'engine_modified_timestamp'  =>  $date,
    'engine_modified_ipaddress'  =>  $ip);
    $data  = $this->security->xss_clean($data);     
    $this->db->where('vessel_id', $vessel_sl);
    $usr_res=$this->db->update('tbl_kiv_engine_details', $data);*/

    /*Load the next tab, Crew details*/
    $form_id=5;
    $heading=14;

    $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
    $data['fieldstoShow']    =  $fieldstoShow; //exit;get_labels();
    $crewType         =  $this->Survey_model->get_crewType();
    $data['crewType'] =  $crewType;

      /* $crewClass         =  $this->Survey_model->get_crewClass();
      $data['crewClass'] =  $crewClass;*/
    $data['vesselId']=$vesselId;
    if(!empty($fieldstoShow))
    {
      $this->load->view('Kiv_views/Ajax_form5_crewDetails.php',$data);
    }
  }
  else
  {
    redirect('Main_login/index');        
  } 
}
/*_________________________________Form 5 - crew details ____________________________*/
function form5_saveTab5()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	   	=	$this->session->userdata('customer_id');
  $survey_user_id	 	=	$this->session->userdata('survey_user_id');

  $vesselType       = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype    = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck   = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));           
  $engine_id  = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId')); 
  $surveyId  = $this->security->xss_clean($this->input->post('hdn_surveyId')); 

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if((!empty($sess_usr_id)) && (($user_type_id==12) || ($user_type_id==13)))
  {	
    $data =	array('title' => 'form4', 'page' => 'form4', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $crew_type_sl  =	$this->security->xss_clean($this->input->post('crew_type_sl'));
    $name_of_type  =	$this->security->xss_clean($this->input->post('name_of_type'));
    if(!empty($name_of_type))
    {
      $name_of_type=$name_of_type ;
    }
    else
    {
      $name_of_type ="";
    }
    $crew_class_sl   =	$this->security->xss_clean($this->input->post('crew_class_sl'));
    $license_number_of_type  = 	$this->security->xss_clean($this->input->post('license_number_of_type'));

    $number=    $this->security->xss_clean($this->input->post('rowcount'));    

    $ip=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date 			= 	date('Y-m-d h:i:s', time());
    $data_crew=array();
    if(!empty($number))
    {
      for($i=0;$i<$number;$i++)
      {
        if(!empty($name_of_type))
        {
          $name_of_type12=$name_of_type[$i];
          if(!empty($name_of_type12))
          {
            $name_of_type_c=$name_of_type12;
          }
          else
          {
            $name_of_type_c="nil";
          }
        }
        else
        {
          $name_of_type_c="nil";
        }
        $data_crew[]= 	array(
        'vessel_id' =>$vesselId,
        'survey_id' =>$surveyId,
        'crew_type_id'=>$crew_type_sl[$i],
        'name_of_type'  => $name_of_type_c,  
        //	'name_of_type' 	=> $name_of_type[$i],  
        //'crew_class_id'            => $crew_class_sl[$i],
        'license_number_of_type'   => $license_number_of_type[$i],            
        'crew_created_user_id'=>$sess_usr_id,
        'crew_created_timestamp'=>	$date,
        'crew_created_ipaddress'=>	$ip);
      }
      $insert_data   = $this->db->insert_batch('tbl_kiv_crew_details', $data_crew);
    }
    else
    {
      $insert_data="";
    }
    if($insert_data) 
    {
      // load ajax page      
      $form_id=5;
      $heading=15;
      $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
      $data['fieldstoShow']    =  $fieldstoShow;//print_r($fieldstoShow);//exit;get_labels();
      $choice         =  $this->Survey_model->get_choice();
      $data['choice'] =  $choice;
      if(!empty($fieldstoShow))
      {
        $this->load->view('Kiv_views/Ajax_form5_passengerDetails.php',$data);
      }
      else
      {
        $this->load->view('Kiv_views/Ajax_error.php');
      }
    }
  }
}
/*_______________________________Form 5 - passenger details _______________________*/
function form5_saveTab6()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id        =   $this->session->userdata('customer_id');
  $survey_user_id     =   $this->session->userdata('survey_user_id');

  $vesselType       = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype    = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck   = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));           
  $engine_id  = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId')); 

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $ip     = $_SERVER['REMOTE_ADDR'];
  date_default_timezone_set("Asia/Kolkata");
  $date   =   date('Y-m-d h:i:s', time()); 

  if(!empty($sess_usr_id) && (($user_type_id==12) || ($user_type_id==13)))
  {
    $data = array('title' => 'form6', 'page' => 'form6', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 
    $this->load->model('Kiv_models/Survey_model');
    $this->form_validation->set_rules('uprDeckbynight', 'Upper deck-plying  by night', 'required|callback_num_check');
    $this->form_validation->set_rules('uprDeckbydaynight', 'Upper deck-plying by day or in canals by night and day', 'required|callback_num_check');
    $this->form_validation->set_rules('uprDeckbydayvoyages', 'Upper deck-plying by day on voyages', 'required|callback_num_check');
    $this->form_validation->set_rules('inbwDeckbynight', 'In between Deck-plying  by night', 'required|callback_num_check');
    $this->form_validation->set_rules('inbwbydaynight', 'In between Deck-plying by day or in canals by night and day', 'required|callback_num_check');
    $this->form_validation->set_rules('inbwbydayvoyages', 'In between Deck-plying by day on voyages', 'required|callback_num_check');
    $this->form_validation->set_rules('mainDeckbynight', 'Main deck-plying  by night', 'required|callback_num_check');
    $this->form_validation->set_rules('mainDeckbydaynight', 'Main deck-plying by day or in canals by night and day', 'required|callback_num_check');
    $this->form_validation->set_rules('mainDeckbydayvoyages', 'Main deck-plying by day on voyages', 'required|callback_num_check');

    $this->form_validation->set_rules('secCabinBynight', 'Second Cabin-plying  by night', 'required|callback_num_check');
    $this->form_validation->set_rules('secCabinBydaynight', 'Second Cabin-plying by day or in canals by night and day', 'required|callback_num_check');
    $this->form_validation->set_rules('secCabinBydayVoyages', 'Second Cabin-plying by day on voyages', 'required|callback_num_check');

    $this->form_validation->set_rules('saloonBynight', 'Saloon Passengers-plying  by night', 'required|callback_num_check');
    $this->form_validation->set_rules('saloonBydaynight', 'Saloon Passengers-plying by day or in canals by night and day', 'required|callback_num_check');
    $this->form_validation->set_rules('saloonBydayVoyages', 'Saloon Passengers-plying by day on voyages', 'required|callback_num_check');
    /* if ($this->form_validation->run() == FALSE)
    {
    $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
    echo "val_errors";
    }   
    else  
    {*/
    /*get data from fifth tab*/        
    $vessel_sl                  = $this->security->xss_clean($this->input->post('hdn_vesselId'));
    $plying_night_upperdeck     = $this->security->xss_clean($this->input->post('uprDeckbynight'));        
    $plying_daynight_upperdeck  = $this->security->xss_clean($this->input->post('uprDeckbydaynight'));
    $plying_halfday_upperdeck   = $this->security->xss_clean($this->input->post('uprDeckbydayvoyages'));

    $plying_night_inbwdeck      = $this->security->xss_clean($this->input->post('inbwDeckbynight'));        
    $plying_daynight_inbwdeck   = $this->security->xss_clean($this->input->post('inbwbydaynight'));
    $plying_halfday_inbwdeck    = $this->security->xss_clean($this->input->post('inbwbydayvoyages'));

    $plying_night_maindeck      = $this->security->xss_clean($this->input->post('mainDeckbynight'));        
    $plying_daynight_maindeck   = $this->security->xss_clean($this->input->post('mainDeckbydaynight'));
    $plying_halfday_maindeck    = $this->security->xss_clean($this->input->post('mainDeckbydayvoyages'));

    $plying_night_secondcabin   = $this->security->xss_clean($this->input->post('secCabinBynight'));        
    $plying_daynight_secondcabin= $this->security->xss_clean($this->input->post('secCabinBydaynight'));
    $plying_halfday_secondcabin = $this->security->xss_clean($this->input->post('secCabinBydayVoyages'));

    $plying_night_saloon        = $this->security->xss_clean($this->input->post('saloonBynight'));        
    $plying_daynight_saloon     = $this->security->xss_clean($this->input->post('saloonBydaynight'));
    $plying_halfday_saloon      = $this->security->xss_clean($this->input->post('saloonBydayVoyages'));

    /*get data from fifth tab*/
    $data = array(
    'vessel_id'                            =>  $vessel_sl,  
    'plying_night_upperdeck'               =>  $plying_night_upperdeck,  
    'plying_daynight_upperdeck'            =>  $plying_daynight_upperdeck,
    'plying_halfday_upperdeck'             =>  $plying_halfday_upperdeck,
    'plying_night_inbwdeck'                =>  $plying_night_inbwdeck,  
    'plying_daynight_inbwdeck'             =>  $plying_daynight_inbwdeck,
    'plying_halfday_inbwdeck'              =>  $plying_halfday_inbwdeck,
    'plying_night_maindeck'                =>  $plying_night_maindeck,  
    'plying_daynight_maindeck'             =>  $plying_daynight_maindeck,
    'plying_halfday_maindeck'              =>  $plying_halfday_maindeck,
    'plying_night_secondcabin'             =>  $plying_night_secondcabin,  
    'plying_daynight_secondcabin'          =>  $plying_daynight_secondcabin,
    'plying_halfday_secondcabin'           =>  $plying_halfday_secondcabin,
    'plying_night_saloon'                  =>  $plying_night_saloon,  
    'plying_daynight_saloon'               =>  $plying_daynight_saloon,
    'plying_halfday_saloon'                =>  $plying_halfday_saloon,
    'passenger_details_created_user_id'    =>  $sess_usr_id,
    'passenger_details_created_timestamp'  =>  $date,
    'passenger_details_created_ipaddress'  =>  $ip,
    'delete_status'                        =>  '0');
    $usr_res=$this->db->insert('tbl_kiv_passengerdetails', $data);
    if($usr_res)
    {
      /*Load the next tab, Condition of service*/
      $form_id=5;/*On fifth form*/
      $heading=16;/*Under 16th heading*/

      $data['vesselId']=$vessel_sl;

      $fieldstoShow_condn = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
      $data['fieldstoShow_condn']    =  $fieldstoShow_condn;
      //print_r($fieldstoShow_condn);

      $narutrofCargo         =  $this->Survey_model->get_condition();
      $data['narutrofCargo'] =  $narutrofCargo;

      $plyingState           =  $this->Survey_model->get_plyingState();
      $data['plyingState']   =  $plyingState;

      $towing                =  $this->Survey_model->get_towing();
      $data['towing']        =  $towing;

      if(!empty($fieldstoShow_condn))
      {
        $this->load->view('Kiv_views/Ajax_form5_conditionofService.php',$data);
      }
      else
      {
       //$this->load->view('Kiv_views/Ajax_error.php');
      }
    }
  }
  else
  {
  redirect('Main_login/index');        
  } 
}
/*____________________________Form 5 - condition of service __________________________*/
function form5_saveTab7()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id        =   $this->session->userdata('customer_id');
  $survey_user_id     =   $this->session->userdata('survey_user_id');

  $vesselType       = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype    = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck   = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));           
  $engine_id  = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId')); 

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $ip     = $_SERVER['REMOTE_ADDR'];
  date_default_timezone_set("Asia/Kolkata");
  $date   =   date('Y-m-d h:i:s', time()); 

  if(!empty($sess_usr_id) && (($user_type_id==12) || ($user_type_id==13)))
  {
    $data = array('title' => 'form7', 'page' => 'form7', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 
    $this->load->model('Kiv_models/Survey_model');
    $this->form_validation->set_rules('natureofCargo', 'Nature of cargo', 'required');
    $this->form_validation->set_rules('qntmofCargo', 'Quantum of cargo', 'required');
    $this->form_validation->set_rules('plying_state', 'Plying State', 'required');
    $this->form_validation->set_rules('towing_state', 'Towing State', 'required');
    $this->form_validation->set_rules('sufficientTimeofService', 'Towing State', 'required');
    /*if ($this->form_validation->run() == FALSE)
    {
    $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
    echo "val_errors";
    }   
    else  
    {*/
    /*get data from fifth tab*/        
    $natureofCargo           = $this->security->xss_clean($this->input->post('natureofCargo'));
    $qntmofCargo             = $this->security->xss_clean($this->input->post('qntmofCargo'));        
    $plying_state            = $this->security->xss_clean($this->input->post('plying_state'));
    $towing_state            = $this->security->xss_clean($this->input->post('towing_state'));
    $sufficientTimeofService = $this->security->xss_clean($this->input->post('sufficientTimeofService'));
    $vessel_sl         = $this->security->xss_clean($this->input->post('hdn_vesselId')); 

    $sufficientTimeofService = explode('/', $sufficientTimeofService);
    $sufficientTimeofService = $sufficientTimeofService[2]."-".$sufficientTimeofService[1]."-".$sufficientTimeofService[0];

    /*get data from fifth tab*/

    $data_vessel = array(
    'cargo_nature'              =>  $natureofCargo,  
    'cargo_quantity'            =>  $qntmofCargo,  
    'plying_state'              =>  $plying_state,
    'towing_status_id'          =>  $towing_state,
    'service_time'              =>  $sufficientTimeofService,
    'vessel_modified_user_id'   =>  $sess_usr_id,
    'vessel_modified_timestamp' =>  $date,
    'vessel_modified_ipaddress' =>  $ip);

    $update_vessel_table		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vessel_sl);
    if($update_vessel_table)
    {
      /*Load the next tab, Machine*/
      $form_id=5;
      $heading=17;
      $data['vesselId']=$vessel_sl;

      $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
      $data['fieldstoShow']    =  $fieldstoShow;
      $this->load->view('Kiv_views/Ajax_form5_declaration.php',$data);
    }
    else
    {
      $this->load->view('Kiv_views/Ajax_error.php');
    }
    /*Load the next tab, Machine*/
    //}
  }
  else
  {
    redirect('Main_login/index');        
  } 
}

/*_________________________________Form 5 - declaration ________________________________*/
function form5_saveTab8()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id        =   $this->session->userdata('customer_id');
  $survey_user_id     =   $this->session->userdata('survey_user_id');

  $vesselType       = $this->security->xss_clean($this->input->post('hdn_vessel_type'));
  $vesselSubtype    = $this->security->xss_clean($this->input->post('hdn_vessel_subtype'));
  $lengthOverDeck   = $this->security->xss_clean($this->input->post('hdn_vessel_length'));
  $hull_id          = $this->security->xss_clean($this->input->post('hdn_hullmaterial_id'));          
  $engine_id  = $this->security->xss_clean($this->input->post('hdn_engine_inboard_outboard')); 
  $vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId')); 

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $ip     = $_SERVER['REMOTE_ADDR'];
  date_default_timezone_set("Asia/Kolkata");
  $date   =   date('Y-m-d h:i:s', time()); 
  $status_change_date =	$date;
  if(!empty($sess_usr_id) && (($user_type_id==12) || ($user_type_id==13)))
  {
    $data = array('title' => 'form8', 'page' => 'form8', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 

    $this->form_validation->set_rules('dateofInspection', 'Date of Inspection', 'required|callback_date_check');
    $this->form_validation->set_rules('machineryValDate', 'Validity of the machinery', 'required|callback_date_check');
    $this->form_validation->set_rules('hullValDate', 'Validity of the hull', 'required|callback_date_check');
    $this->form_validation->set_rules('declarationDate', 'Declaration date', 'required|callback_date_check');

    /* if ($this->form_validation->run() == FALSE)
    {
    $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
    echo "val_errors";
    }   
    else  
    {*/
    /*get data from eight tab*/        
    $dateofInspection   = $this->security->xss_clean($this->input->post('dateofInspection'));
    $machineryValDate 	= $this->security->xss_clean($this->input->post('machineryValDate'));        
    $hullValDate     	= $this->security->xss_clean($this->input->post('hullValDate'));
    $declarationDate 	= $this->security->xss_clean($this->input->post('declarationDate'));
    $vessel_sl          = $this->security->xss_clean($this->input->post('hdn_vesselId'));
    $surveyId          = $this->security->xss_clean($this->input->post('hdn_surveyId'));

    $dateofInspection = explode('/', $dateofInspection);
    $dateofInspection = $dateofInspection[2]."-".$dateofInspection[1]."-".$dateofInspection[0];

    $machineryValDate   = explode('/', $machineryValDate);
    $machineryValDate   = $machineryValDate[2]."-".$machineryValDate[1]."-".$machineryValDate[0];

    $hullValDate = explode('/', $hullValDate);
    $hullValDate = $hullValDate[2]."-".$hullValDate[1]."-".$hullValDate[0];

    $declarationDate   = explode('/', $declarationDate);
    $declarationDate   = $declarationDate[2]."-".$declarationDate[1]."-".$declarationDate[0];
    $processflow_sl = $this->security->xss_clean($this->input->post('processflow_sl'));
    $process_id =	$this->security->xss_clean($this->input->post('process_id')); 

    $user_id =	$this->security->xss_clean($this->input->post('user_id'));
    $user_type_id=	$this->security->xss_clean($this->input->post('user_type_id'));
    $status =	1;
    $status_details_sl =$this->security->xss_clean($this->input->post('status_details_sl'));

    /*get data from eight tab*/

    $data_vessel = array(
    'dateofInspection'         =>  $dateofInspection,  
    'machineryValDate'         =>  $machineryValDate,  
    'hullValDate'              =>  $hullValDate,
    'declarationDate'          =>  $declarationDate,
    'vessel_modified_user_id'  =>  $sess_usr_id,
    'vessel_modified_timestamp'=>  $date,
    'vessel_modified_ipaddress'=>  $ip);

    $update_vessel_table		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vessel_sl);
    if($update_vessel_table)
    {
      //-------------------processflow-------------------//
      $data_insert=array(
      'vessel_id'=>$vessel_sl,
      'process_id'=>$process_id,
      'survey_id'=>$surveyId,
      'current_status_id'=>5,
      'current_position'=>$user_type_id,
      'user_id'=>$sess_usr_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>0,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id     =   $this->db->insert_id();

      $new_process_id=10;
      //Assign form7
      $data_insert_form7=array(
      'vessel_id'=>$vessel_sl,
      'process_id'=>$new_process_id,
      'survey_id'=>$surveyId,
      'current_status_id'=>1,
      'current_position'=>$user_type_id,
      'user_id'=>$sess_usr_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);

      $process_insert_form7=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_form7);

      $data_survey_status=array(
      'process_id'=>$new_process_id,
      'current_status_id'=>1,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$sess_usr_id);
      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
    }
  }
  else
  {
  redirect('Main_login/index');        
  } 
}
/*________________________________Additional payment_______________________________*/
public function additional_payment()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');

  $vessel_id1         = $this->uri->segment(4);
  $processflow_sl1    = $this->uri->segment(5);
  $survey_id1         = $this->uri->segment(6);

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);


  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'additional_payment', 'page' => 'additional_payment', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;
   // print_r($vessel_details);
    
    @$id            = $vessel_details[0]['vessel_created_user_id'];

    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;

    $current_status       = $this->Survey_model->get_status();
    $data['current_status']   = $current_status;

    $form_number        = $this->Survey_model->get_form_number($vessel_id);
    $data['form_number']    = $form_number;
    $form_id=$form_number[0]['form_no'];

    $bank         =   $this->Survey_model->get_bank_favoring();
    $data['bank']   = $bank;

    $portofregistry            =   $this->Survey_model->get_portofregistry();
    $data['portofregistry']   =   $portofregistry;

    //----------Vessel Details--------//

    $vessel_details_viewpage =  $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;

    if($this->input->post())
    {
     // print_r($_POST);
      //exit;
     
      $portofregistry_sl    = $this->security->xss_clean($this->input->post('portofregistry_sl'));
      $bank_sl              = $this->security->xss_clean($this->input->post('bank_sl'));
      $vessel_id            = $this->security->xss_clean($this->input->post('vessel_id'));
      $process_id           = $this->security->xss_clean($this->input->post('process_id'));
      $owner_user_id        = $this->security->xss_clean($this->input->post('user_id'));
      $owner_user_type_id   = $this->security->xss_clean($this->input->post('user_type_id'));
      $status_details_sl    = $this->security->xss_clean($this->input->post('status_details_sl'));
      $additional_payment_details=$this->Survey_model->get_additional_payment_details($vessel_id);
      $data['additional_payment_details'] =  $additional_payment_details;
      if(!empty($additional_payment_details))
      {
        $additional_payment=$additional_payment_details[0]['additional_payment_amount'];
        $additional_remarks=$additional_payment_details[0]['additional_payment_remarks'];
      }
      else
      {
        $additional_payment="";
        $additional_remarks="";
      }
      $payment_user         =  $this->Survey_model->get_payment_userdetails($sess_usr_id);
      $data['payment_user'] =  $payment_user;
      //print_r($payment_user);exit;
      if(!empty($payment_user))
      {
        $owner_name         = $payment_user[0]['user_name'];
        $user_mobile_number = $payment_user[0]['user_mobile_number'];
        $user_email         = $payment_user[0]['user_email'];
      }
      date_default_timezone_set("Asia/Kolkata");
      $ip         = $_SERVER['REMOTE_ADDR'];
      $date       =   date('Y-m-d h:i:s', time());
      $newDate    =   date("Y-m-d");
      $status_change_date=$date;
      $formnumber=10;
      $survey_id=1;
      $milliseconds = round(microtime(true) * 1000); //Generate unique bank number

      $bank_gen_number         =   $this->Survey_model->get_bank_generated_last_number($bank_sl);
      $data['bank_gen_number'] = $bank_gen_number;
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
        'transaction_amount'    => $additional_payment,
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
          //echo "hii"; exit;
          $bank_transaction_id =    $this->db->insert_id();
          $update_bank   =    $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);
          $online_payment_data =   $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
          $data['online_payment_data']= $online_payment_data;
          $payment_user1 =  $this->Survey_model->get_payment_userdetails($sess_usr_id);
          $data['payment_user1']=  $payment_user1;
          $requested_transaction_details=  $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
          $data['requested_transaction_details']  =   $requested_transaction_details;
         //$data['amount_tobe_pay']=$additional_payment; //remove comment before uploaded to server
          $data['amount_tobe_pay']=1;
          $data      =  $data+ $this->data;
          if(!empty($online_payment_data))
          { 
            $this->load->view('Kiv_views/Hdfc/hdfc_additional_payment_request',$data);
          }
          else
          {
            redirect('Kiv_Ctrl/Survey/SurveyHome');
          }
        } 
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/additional_payment',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}
/*_______________________________form 5 view_______________________________________*/
public function form5_view()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  //$processflow_sl1 	=	$this->uri->segment(4);
  $survey_id1 		=	$this->uri->segment(5);
  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  /*$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 
  */
  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form5_view', 'page' => 'form5_view', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    //----------Vessel Details--------//
    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;

    //----------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']		=	$hull_details;

    //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']	=	$engine_details;
    
    //----------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details']	=	$equipment_details;
    
    //----------Get portable fire extinguisher---------------//
    $portable_fire_ext	          = 	$this->Survey_model->get_portablefire_extinguisher($vessel_id);
    $data['portable_fire_ext']	  =	  $portable_fire_ext;
           
    //--------------Documents-----------------//
    $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']		=	$list_document_vessel;

    @$id=$vessel_details_viewpage[0]['user_id'];

    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form5_view',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');
  }
}

/*_______________________________form 9 entry__________________________________*/

public function form9_entry()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id) && ($user_type_id==12))
    {
    $data       =  array('title' => 'form9_entry', 'page' => 'form9_entry', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $vessel_details           =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']     =   $vessel_details;
    
    //----------Owner Details--------------//
    $user      =  $this->Survey_model->get_user($customer_id);
    $data['user']    =  $user;

    $agent       =  $this->Survey_model->get_agent($customer_id);
    $data['agent']   =  $agent;

    $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessDetails']  =  $vessDetails; 

    $vesselType     = $vessDetails[0]['vessel_type_id'];
    $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
    $lengthOverDeck = $vessDetails[0]['vessel_length'];
    $engine_id      = $vessDetails[0]['engine_placement_id'];
    $hull_id        = $vessDetails[0]['hullmaterial_id'];
    $form_id=9;
    $heading_id=30;

    $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck, $hull_id, $engine_id, $form_id, $heading_id);
    $data['fieldstoShow']    =  $fieldstoShow;
    // print_r($fieldstoShow);
    if(!empty($fieldstoShow))
    {
      $this->load->view('Kiv_views/template/form-header.php');
      $this->load->view('Kiv_views/template/nav-header.php');
      $this->load->view('Kiv_views/dash/form9_entry', $data);
      $this->load->view('Kiv_views/template/form-footer.php');
    }
    else
    {
    redirect('Kiv_Ctrl/Survey/csHome'); 
    }
  }
  else
  {
    redirect('Main_login/index');        
  } 
}
/*_____________________________________________Form 9 Entry processflow_________________________________*/

function saveform9_Tab1()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id      = $this->session->userdata('customer_id');
  $survey_user_id   = $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $ip=  $_SERVER['REMOTE_ADDR'];
  date_default_timezone_set("Asia/Kolkata");
  $date =   date('Y-m-d h:i:s', time());
  $status_change_date   = $date;

  if(!empty($sess_usr_id) && ($user_type_id==12))
  { 
    $data = array('title' => 'form3', 'page' => 'form3', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $capacity21       = $this->security->xss_clean($this->input->post('capacity21'));
    $boats_aggregate_capacity= $this->security->xss_clean($this->input->post('boats_aggregate_capacity'));
    $lifebuoys_plyingA= $this->security->xss_clean($this->input->post('lifebuoys_plyingA'));
    $lifebuoys_plyingB  = $this->security->xss_clean($this->input->post('lifebuoys_plyingB'));
    $lifebuoys_plyingC     = $this->security->xss_clean($this->input->post('lifebuoys_plyingC'));

    $buoyancy_apparatus_plyingA= $this->security->xss_clean($this->input->post('buoyancy_apparatus_plyingA'));
    $buoyancy_apparatus_plyingB= $this->security->xss_clean($this->input->post('buoyancy_apparatus_plyingB'));
    $buoyancy_apparatus_plyingC= $this->security->xss_clean($this->input->post('buoyancy_apparatus_plyingC'));

    $hdn_equipment_id12       = $this->security->xss_clean($this->input->post('hdn_equipment_id12'));
    $hdn_equipment_type_id4       = $this->security->xss_clean($this->input->post('hdn_equipment_type_id4'));

    $vesselId  = $this->security->xss_clean($this->input->post('hdn_vesselId'));
    $vessel_survey_number  = $this->security->xss_clean($this->input->post('vessel_survey_number'));
    $vessel_registration_number = $this->security->xss_clean($this->input->post('vessel_registration_number'));

    $survey_id    =   $this->security->xss_clean($this->input->post('hdn_surveyId'));
    $processflow_sl =  $this->security->xss_clean($this->input->post('processflow_sl'));
    $process_id    = $this->security->xss_clean($this->input->post('process_id')); 

    $user_id     = $this->security->xss_clean($this->input->post('user_id'));
    $user_type_id       = $this->security->xss_clean($this->input->post('user_type_id'));
    $status         = 1;
    $status_details_sl    = $this->security->xss_clean($this->input->post('status_details_sl'));


    $owner_user_type_id=  $this->security->xss_clean($this->input->post('owner_user_type_id'));
    $owner_user_id= $this->security->xss_clean($this->input->post('owner_user_id'));

    $equipment_data=array(
    'vessel_id'     =>  $vesselId, 
    'survey_id'     =>  $survey_id, 
    'equipment_id'=>$hdn_equipment_id12,
    'equipment_type_id'=>$hdn_equipment_type_id4,
    'capacity'=>$capacity21,
    'equipment_created_user_id'    =>      $sess_usr_id,
    'equipment_created_timestamp'  => $date,
    'equipment_created_ipaddress'  => $ip );
    $result_insert3=$this->db->insert('tbl_kiv_equipment_details', $equipment_data); 

    $plying_data= array( 
    'vessel_id'     =>  $vesselId, 
    'survey_id'     =>  $survey_id, 
    'lifebuoys_plyingA'=>$lifebuoys_plyingA,
    'lifebuoys_plyingB'=>$lifebuoys_plyingB,
    'lifebuoys_plyingC'=>$lifebuoys_plyingC,
    'buoyancy_apparatus_plyingA'=>$buoyancy_apparatus_plyingA,
    'buoyancy_apparatus_plyingB'=>$buoyancy_apparatus_plyingB,
    'buoyancy_apparatus_plyingC'=>$buoyancy_apparatus_plyingC,
    'plyingstate_created_user_id'    =>  $sess_usr_id,
    'plyingstate_created_timestamp'  => $date,
    'plyingstate_created_ipaddress'  => $ip );

    $result_plying_data=$this->db->insert('tbl_kiv_plyingstate', $plying_data); 
    $array_vessel=array('boats_aggregate_capacity'=>$boats_aggregate_capacity,
    'vessel_modified_user_id'=>$sess_usr_id,
    'vessel_modified_timestamp'=>$date,
    'vessel_modified_ipaddress'=>$ip );

    $vessel_update=$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$array_vessel, $vesselId);
    //-----------Get survey intimation :  tbl_kiv_survey_intimation --------------//

    $survey_intimation          = $this->Survey_model->get_survey_intimation_details($vesselId,$survey_id);
    $data['survey_intimation']  = $survey_intimation;
    //print_r($survey_intimation);
    if(!empty($survey_intimation))
    {
      foreach ($survey_intimation as $key ) 
      {
        $defect_status=$key['defect_status'];
        $survey_defects_id=$key['survey_defects_id'];
        if($defect_status==0)
        {
          $date_of_survey         = $survey_intimation[0]['date_of_survey'];
          $adding_one_year      = date('d-m-Y', strtotime($date_of_survey . "1 year") );
          $adding_five_year       = date('d-m-Y', strtotime($date_of_survey . "5 year") );
          $annual_survey_date         = date("Y-m-d", strtotime($adding_one_year));
          $drydock_survey_date        = date("Y-m-d", strtotime($adding_five_year));
        }
        else
        {
          $survey_intimation_defects   =   $this->Survey_model->get_survey_intimation_defects($survey_defects_id);
          $data['survey_intimation_defects']  =   $survey_intimation_defects;

          $date_of_survey         = $survey_intimation_defects[0]['date_of_survey'];
          $adding_one_year      = date('d-m-Y', strtotime($date_of_survey . "1 year") );
          $adding_five_year       = date('d-m-Y', strtotime($date_of_survey . "5 year") );
          $annual_survey_date         = date("Y-m-d", strtotime($adding_one_year));
          $drydock_survey_date        = date("Y-m-d", strtotime($adding_five_year));
        }
      }
    }

    //-------------survey-initial survey date insertion-------------//
    $timeline_data_initial = array('vessel_id' =>$vesselId ,
    'survey_number' => $vessel_survey_number,
    'registration_number' => $vessel_registration_number,
    'process_id' => 1,
    'subprocess_id' => 1,
    'scheduled_date' => $date_of_survey,
    'actual_date' => $date_of_survey,
    'status' => 1,
    'link_id' => '-1',
    'timeline_created_user_id' => $sess_usr_id,
    'timeline_created_timestamp' =>$date,
    'timeline_created_ipaddress' => $ip);
    $insert_timeline_initial=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_initial);               

    //-------------survey-annual survey date insertion-------------//
    $timeline_data_annual = array('vessel_id' =>$vesselId ,
    'survey_number' => $vessel_survey_number,
    'registration_number' => $vessel_registration_number,
    'process_id' => 1,
    'subprocess_id' => 2,
    'scheduled_date' => $annual_survey_date,
    'status' => 0,
    'link_id' => 0,
    'timeline_created_user_id' => $sess_usr_id,
    'timeline_created_timestamp' =>$date,
    'timeline_created_ipaddress' => $ip);

    $insert_timeline_annual=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_annual);               
    //-------------survey-drydock survey date insertion-------------//
    $timeline_data_drydock = array('vessel_id' =>$vesselId ,
    'survey_number' => $vessel_survey_number,
    // 'registration_number' => $vessel_registration_number,
    'process_id' => 1,
    'subprocess_id' => 3,
    'scheduled_date' => $drydock_survey_date,
    'status' => 0,
    'link_id' => 0,
    'timeline_created_user_id' => $sess_usr_id,
    'timeline_created_timestamp' =>$date,
    'timeline_created_ipaddress' => $ip);

    $insert_timeline_drydock=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_drydock);

    //--process flow---//
    $data_insert=array(
    'vessel_id'=>$vesselId,
    'process_id'=>$process_id,
    'survey_id'=>$survey_id,
    'current_status_id'=>5,
    'current_position'=>$user_type_id,
    'user_id'=>$user_id,
    'previous_module_id'=>$processflow_sl,
    'status'=>0,
    'status_change_date'=>$status_change_date);

    $data_update = array('status'=>0);
    $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
    $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
    $processflow_id     =   $this->db->insert_id();

    $new_process_id=14;
    $data_insert_form7=array(
    'vessel_id'=>$vesselId,
    'process_id'=>$new_process_id,
    //'survey_id'=>$survey_id,
    'survey_id'=>0,
    'current_status_id'=>1,
    'current_position'=>$owner_user_type_id,
    'user_id'=>$owner_user_id,
    'previous_module_id'=>$processflow_sl,
    'status'=>$status,
    'status_change_date'=>$status_change_date);

    $process_insert_form7=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_form7);

    $data_survey_status=array(
    'process_id'=>$new_process_id,
    'survey_id'=>0,
    'current_status_id'=>1,
    'sending_user_id'=>$user_id,
    'receiving_user_id'=>$owner_user_id);

    $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

    $data_main=array('processing_status'=>0);   
    $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vesselId);
  }
}

//___________________________PC Home__________________________________//
public function pcHome()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $mod_id_enc  = $this->uri->segment(4);
  $this->load->model('Kiv_models/Master_model');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'pcHome', 'page' => 'pcHome', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    
    $mod_enc=str_replace(array('-', '_', '~'), array('+', '/', '='), $mod_id_enc);
    $mod_id=$this->encrypt->decode($mod_enc);
    $data['mod_id']  = $mod_id;

    $initial_data			    = 	$this->Survey_model->get_process_flow_pc($sess_usr_id);
    $data['initial_data']		=	$initial_data;
    //print_r($initial_data);
    $count			= 	count($initial_data);
    $data['count'] 	=	$count;
    @$id 			=	$initial_data[0]['user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    //Approved checking
    $data_payment            =  $this->Survey_model->get_approved_payment($sess_usr_id);
    $data['data_payment']		 =	$data_payment;
    $count_payment	         =  count($data_payment);
    $data['count_payment']   =  $count_payment;

    /* ======Added for dynamic menu listing (start) on 02.11.2019========   */ 
    $menu     =   $this->Master_model->get_menu_pc($user_type_id,$mod_id); //print_r($menu);
    $data['menu'] = $menu;
    $data       =   $data + $this->data;
    /* ======Added for dynamic menu listing (end)  on 02.11.2019========   */ 

    /*=========Show count of Reprint Request (start) on 17.01.2019=====*/

    $user_port    =  $this->Survey_model->get_user_port_id($sess_usr_id);

    foreach($user_port as $user_port_res){
        $port     =   $user_port_res['user_master_port_id'];
    }

    $reprint_req_pc =   $this->Survey_model->get_reprint_req_list_pc($port);
    $cnt_req        =   count($reprint_req_pc); 
    $data['cnt_req']=   $cnt_req;
    $data           =   $data + $this->data;
    /*========Show count of Reprint Request (end) on 17.01.2019=====*/
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/kiv_pc',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function pc_inbox()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');

  $this->load->model('Kiv_models/Master_model');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'pc_inbox', 'page' => 'pc_inbox', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data         =   $this->Survey_model->get_process_flow_pc($sess_usr_id);
    $data['initial_data']   = $initial_data;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/pc_inbox',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}


public function Verify_payment_pc()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data   =  array('title' => 'Verify_payment_pc', 'page' => 'Verify_payment_pc', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;
    @$id            = $vessel_details[0]['vessel_created_user_id'];

    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;
    $owner_name         = $customer_details[0]['user_name'];
    $user_mobile_number = $customer_details[0]['user_mobile_number'];
    $user_email         = $customer_details[0]['user_email'];

    $current_status       = $this->Survey_model->get_status();
    $data['current_status']   = $current_status;

    $form_number        = $this->Survey_model->get_form_number($vessel_id);
    $data['form_number']    = $form_number;
    $form_id=$form_number[0]['form_no'];

    //----------Vessel Details--------//
    $vessel_details_viewpage =  $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;
    $vessel_name            = $vessel_details_viewpage[0]['vessel_name'];

    //---------Payment Details--------//
    $payment_details =  $this->Survey_model->get_form_payment_details($vessel_id,$survey_id,$form_id);
    $data['payment_details']= $payment_details;
    $portofregistry_sl= $payment_details[0]['portofregistry_id'];
    $dd_amount        = $payment_details[0]['dd_amount'];
    //get port of registry name
    $registry_port_id             =   $this->Survey_model->get_registry_port_id($portofregistry_sl);
    $data['registry_port_id']     =   $registry_port_id;

    if(!empty($registry_port_id))
    {
      $port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
    }
    else
    {
      $port_of_registry_name="";
    }

    /* $ref_process_id=1;
    $ref_number_details     =   $this->Survey_model->get_ref_number_details($vessel_id,$ref_process_id);
    $data['ref_number_details'] =   $ref_number_details;
    */
    /*________________GET reference number start-initial survey___________________*/
    date_default_timezone_set("Asia/Kolkata");
    $date         =   date('Y-m-d h:i:s', time());
    $ref_process_id=1;
    $ref_number_details     =   $this->Survey_model->get_ref_number_details($vessel_id,$ref_process_id);
    $data['ref_number_details'] =   $ref_number_details;
    
    if(!empty($ref_number_details))
    {
      $ref_number       = $ref_number_details[0]['ref_number'];
      $ref_id         = $ref_number_details[0]['ref_id'];
      $data_ref_number    = array('payment_status' => $payment_status, 'payment_date'=>$date);
    }
    else
    {
      $ref_number =   "";
    }
    $update_ref_number    =   $this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);
    /*________________GET reference number end-initial survey___________________*/

    
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
      $user_sl_cs     = $this->security->xss_clean($this->input->post('user_sl_cs'));
      $status       = 1;

      $status_details_sl= $this->security->xss_clean($this->input->post('status_details_sl'));
      $payment_sl   = $this->security->xss_clean($this->input->post('payment_sl'));
      $payment_approved_remarks = $this->security->xss_clean($this->input->post('remarks'));
      //Form 1 Verification Reverted to CS

      $date               =   date('Y-m-d h:i:s', time());
      $ip             = $_SERVER['REMOTE_ADDR'];
      $status_change_date = $date;
      $data_payment=array(
      'payment_approved_status' =>1,
      'payment_approved_user_id' =>$sess_usr_id,
      'payment_approved_datetime' =>$status_change_date,
      'payment_approved_ipaddress' =>$ip,
      'payment_approved_remarks' =>$payment_approved_remarks);

      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>7,
      'current_position'=>$current_position,
      'user_id'=>$user_sl_cs,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);

      $data_survey_status=array(
      'current_status_id'=>7,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$user_sl_cs);
      
      $payment_update=$this->Survey_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      //_____________________________Email sending start_____________________________//
      $email_subject="Payment for form 1 of ".$vessel_name." is verified";
      $email_message="<div><h4>Dear ". $owner_name.",</h4><p>Your payment of Rs. <b>".$dd_amount."</b> towards Form 1 submission of <b>".$vessel_name."</b> has been verified. Form 1 is forwarded to Chief Surveyor.  <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>
      Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.<br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
      $saji_email="bssajitha@gmail.com";
      $this->emailSendFunction($saji_email,$email_subject,$email_message);
      //$this->emailSendFunction($user_email,$email_subject,$email_message);
      //___________________Email sending start___________________________________________//
      //____________________SMS sending start____________________________________________//
      $sms_message="Payment for ".$vessel_name." is verified, and forwarded to Chief Surveyor";
      $this->load->model('Kiv_models/Survey_model');
      $saji_mob="9847903241";
      //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
      //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
      //____________________SMS sending end________________________________________________//



      if($payment_update && $process_update && $process_insert && $status_update)
      {
        redirect("Kiv_Ctrl/Survey/pcHome"."/".$modidenc);
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_payment_pc',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function Verify_payment_pc_form3()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data 	=	 array('title' => 'Verify_payment_pc_form3', 'page' => 'Verify_payment_pc_form3', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 	=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details				= 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']		=	$vessel_details;
    @$id 						=	$vessel_details[0]['vessel_created_user_id'];

    $customer_details 			=	$this->Survey_model->get_customer_details($id);
    $data['customer_details']	=	$customer_details;
    $owner_name         = $customer_details[0]['user_name'];
    $user_mobile_number = $customer_details[0]['user_mobile_number'];
    $user_email         = $customer_details[0]['user_email'];


    $current_status 			=	$this->Survey_model->get_status();
    $data['current_status']		=	$current_status;

    $form_number 				=	$this->Survey_model->get_form_number($vessel_id);
    $data['form_number']		=	$form_number;
    $form_id=$form_number[0]['form_no'];


    //----------Vessel Details--------//
    $vessel_details_viewpage = 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']=	$vessel_details_viewpage;
    $vessel_name            = $vessel_details_viewpage[0]['vessel_name'];
    //----------Payment Details--------//
    $payment_details = 	$this->Survey_model->get_form_payment_details($vessel_id,$survey_id,$form_id);
    $data['payment_details']=	$payment_details;
    $portofregistry_sl= $payment_details[0]['portofregistry_id'];
    $dd_amount        = $payment_details[0]['dd_amount'];
    /*________________GET reference number start-initial survey___________________*/
    date_default_timezone_set("Asia/Kolkata");
    $date         =   date('Y-m-d h:i:s', time());
    $ref_process_id=1;
    $ref_number_details     =   $this->Survey_model->get_ref_number_details($vessel_id,$ref_process_id);
    $data['ref_number_details'] =   $ref_number_details;
    
    if(!empty($ref_number_details))
    {
      $ref_number       = $ref_number_details[0]['ref_number'];
      $ref_id         = $ref_number_details[0]['ref_id'];
      $data_ref_number    = array('payment_status' => $payment_status, 'payment_date'=>$date);
    }
    else
    {
      $ref_number =   "";
    }
    $update_ref_number    =   $this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);
    /*________________GET reference number end-initial survey___________________*/
    //print_r($payment_details);
    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date                  	= 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));;
      $current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $user_sl_cs 		=	$this->security->xss_clean($this->input->post('user_sl_cs'));
      $status 			=	1;

      $status_details_sl=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $payment_sl 	=	$this->security->xss_clean($this->input->post('payment_sl'));
      $payment_approved_remarks =	$this->security->xss_clean($this->input->post('remarks'));

      $form1_final_cs= $this->Survey_model->get_form1_final($vessel_id,4,$survey_id,5);
      $data['form1_final_cs']= $form1_final_cs;

      $form1_final_sr= $this->Survey_model->get_form1_final($vessel_id,4,$survey_id,6);
      $data['form1_final_sr']= $form1_final_sr;

      if(!empty($form1_final_cs))
      {
        $current_position_form3=$form1_final_cs[0]['current_position'];
        $user_id_form3=$form1_final_cs[0]['user_id'];
      }
      else
      {
        $current_position_form3=$form1_final_sr[0]['current_position'];
        $user_id_form3=$form1_final_sr[0]['user_id'];
      }
      $date               = 	date('Y-m-d h:i:s', time());
      $ip	      			=	$_SERVER['REMOTE_ADDR'];
      $status_change_date =	$date;
      if($process_id==5)
      {
        $data_payment=array(
        'payment_approved_status' =>1,
        'payment_approved_user_id' =>$sess_usr_id,
        'payment_approved_datetime' =>$status_change_date,
        'payment_approved_ipaddress' =>$ip,
        'payment_approved_remarks' =>$payment_approved_remarks);

        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$current_position_form3,
        'user_id'=>$user_id_form3,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);
        $data_survey_status=array(
        'current_status_id'=>$current_status_id,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_id_form3);
        //_____________________________Email sending start_____________________________//
        $email_subject="Payment for form 3 of ".$vessel_name." is verified";
        $email_message="<div><h4>Dear ". $owner_name.",</h4><p>Your payment of Rs. <b>".$dd_amount."</b> towards Form 3 submission of <b>".$vessel_name."</b> has been verified. Form 3 is forwarded to Chief Surveyor.  <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>
        Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.<br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
        $saji_email="bssajitha@gmail.com";
        $this->emailSendFunction($saji_email,$email_subject,$email_message);
        //$this->emailSendFunction($user_email,$email_subject,$email_message);
        //___________________Email sending start___________________________________________//
        //____________________SMS sending start____________________________________________//
        $sms_message="Payment for ".$vessel_name." is verified, and forwarded to Chief Surveyor";
        $this->load->model('Kiv_models/Survey_model');
        $saji_mob="9847903241";
        //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
        //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
        //____________________SMS sending end________________________________________________//
        //print_r($data_survey_status);
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
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_payment_pc_form3',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function Verify_payment_pc_form4()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data 	=	 array('title' => 'Verify_payment_pc_form4', 'page' => 'Verify_payment_pc_form4', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 	=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details				= 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']		=	$vessel_details;

    @$id 						=	$vessel_details[0]['user_id'];
    $process_id            = $vessel_details[0]['process_id'];


    $customer_details 			=	$this->Survey_model->get_customer_details($id);
    $data['customer_details']	=	$customer_details;
    $owner_name         = $customer_details[0]['user_name'];
    $user_mobile_number = $customer_details[0]['user_mobile_number'];
    $user_email         = $customer_details[0]['user_email'];

    $current_status 			=	$this->Survey_model->get_status();
    $data['current_status']		=	$current_status;

    $form_number 				=	$this->Survey_model->get_form_number($vessel_id);
    $data['form_number']		=	$form_number;

    if(!empty($form_number))
    {
      $form_id=$form_number[0]['form_no'];
    }

    //----------Vessel Details--------//
    $vessel_details_viewpage = 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']=	$vessel_details_viewpage;
    $vessel_name            = $vessel_details_viewpage[0]['vessel_name'];

    //----------Payment Details--------//
    $payment_details = 	$this->Survey_model->get_form_payment_details($vessel_id,$survey_id,$form_id);
    $data['payment_details']=	$payment_details;
    //print_r($payment_details);
    $portofregistry_sl= $payment_details[0]['portofregistry_id'];
    $dd_amount        = $payment_details[0]['dd_amount'];

    /*________________GET reference number start-initial survey___________________*/
    date_default_timezone_set("Asia/Kolkata");
    $date         =   date('Y-m-d h:i:s', time());
    $ref_process_id=1;
    $ref_number_details     =   $this->Survey_model->get_ref_number_details($vessel_id,$ref_process_id);
    $data['ref_number_details'] =   $ref_number_details;
    
    if(!empty($ref_number_details))
    {
      $ref_number       = $ref_number_details[0]['ref_number'];
      $ref_id         = $ref_number_details[0]['ref_id'];
      $data_ref_number    = array('payment_status' => $payment_status, 'payment_date'=>$date);
    }
    else
    {
      $ref_number =   "";
    }
    $update_ref_number    =   $this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);
    /*________________GET reference number end-initial survey___________________*/
    if($this->input->post())
      {
      date_default_timezone_set("Asia/Kolkata");
      $date                  	= 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));;
      $current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $user_sl_cs 		=	$this->security->xss_clean($this->input->post('user_sl_cs'));
      $status 			=	1;

      $status_details_sl=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $payment_sl 	=	$this->security->xss_clean($this->input->post('payment_sl'));
      $payment_approved_remarks =	$this->security->xss_clean($this->input->post('remarks'));

      $date               = 	date('Y-m-d h:i:s', time());
      $ip	      			=	$_SERVER['REMOTE_ADDR'];
      $status_change_date =	$date;

      if($process_id==7)
      {
        $data_payment=array(
        'payment_approved_status' =>1,
        'payment_approved_user_id' =>$sess_usr_id,
        'payment_approved_datetime' =>$status_change_date,
        'payment_approved_ipaddress' =>$ip,
        'payment_approved_remarks' =>$payment_approved_remarks);

        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>7,
        'current_position'=>$current_position,
        'user_id'=>$user_sl_cs,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);

        $data_survey_status=array(
        'current_status_id'=>7,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_sl_cs);

        $payment_update=$this->Survey_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id_surveyactivity 		= 	$this->db->insert_id();
        $data_task=array(
        'process_flow_id' =>  $processflow_id_surveyactivity,
        'assign_date'   =>  $date_of_survey,
        'status'      =>  1);
        $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        //_____________________________Email sending start_____________________________//
        $email_subject="Payment for form 4 of ".$vessel_name." is verified";
        $email_message="<div><h4>Dear ". $owner_name.",</h4><p>Your payment of Rs. <b>".$dd_amount."</b> towards Form 4 defect <b>".$vessel_name."</b> has been verified. Form 4 is forwarded to Chief Surveyor.  <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>
        Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.<br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
        $saji_email="bssajitha@gmail.com";
        $this->emailSendFunction($saji_email,$email_subject,$email_message);
        //$this->emailSendFunction($user_email,$email_subject,$email_message);
        //___________________Email sending start___________________________________________//
        //____________________SMS sending start____________________________________________//
        $sms_message="Payment for ".$vessel_name." is verified, and forwarded to Chief Surveyor";
        $this->load->model('Kiv_models/Survey_model');
        $saji_mob="9847903241";
        //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
        //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
        //____________________SMS sending end________________________________________________//
        if($payment_update && $process_update && $process_insert && $status_update && $task_insert)
        {
          redirect("Kiv_Ctrl/Survey/pcHome"."/".$modidenc);
        }
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_payment_pc_form4',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}



public function listpending_payment()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data   =  array('title' => 'listpending_payment', 'page' => 'listpending_payment', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    //payment checking
    $data_payment=$this->Survey_model->get_pending_payment();
    $data['data_payment']   = $data_payment;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/listpending_payment',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}

public function listapproved_payment()
{
	$sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data 	=	 array('title' => 'listapproved_payment', 'page' => 'listapproved_payment', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 	=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
     $sdate=date('Y-m-d', strtotime('-30 days'));
    $edate=date('Y-m-d');
    if($this->input->post())
    {
      $day="";
      $data['day']=$day;
      $from_date       = $this->security->xss_clean($this->input->post('from_date'));
      $to_date         = $this->security->xss_clean($this->input->post('to_date'));
      $data_payment=$this->Survey_model->get_approved_payment_date($sess_usr_id,$from_date,$to_date);
      $data['data_payment']   = $data_payment;
    }
    else
    {
      $day="30";
      $data['day']=$day;
      $data_payment=$this->Survey_model->get_approved_payment_date($sess_usr_id,$sdate,$edate);
      $data['data_payment']   = $data_payment;
    }
   

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/listapproved_payment',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}
/*_______________________ANNUAL SURVEY START_______________________________*/
public function annual_survey()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id2 		=	$this->uri->segment(6);

  $survey_id11      =   1;

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id2);
  $survey_id=$this->encrypt->decode($survey_id); 

  $survey_id1=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id11);
  $survey_id1=$this->encrypt->decode($survey_id1); 

  if(!empty($sess_usr_id))
  {
    $data 	=	 array('title' => 'annual_survey', 'page' => 'annual_survey', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 	=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;

    @$id            = $vessel_details[0]['user_id'];

    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;
    //print_r($customer_details);
    @$relation_sl=$customer_details[0]['relation_sl'];
    if(@$relation_sl)
    {
      $agent_details       = $this->Survey_model->get_agent($relation_sl);
      $data['agent_details'] = $agent_details;
      $minor_details       = $this->Survey_model->get_minor($relation_sl);
      $data['minor_details'] = $minor_details;
    }

    //----------Vessel Details--------//
    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;
    $vessel_type_id=$vessel_details_viewpage[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_details_viewpage[0]['vessel_subtype_id'];
    $vessel_total_tonnage=$vessel_details_viewpage[0]['vessel_total_tonnage'];

    //----------Hull Details--------//
    $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id1);
    $data['hull_details']    = $hull_details;

    //----------Engine Details--------//
    $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id1);
    $data['engine_details']  = $engine_details;

    //----------Equipment Details--------//
    $equipment_details     =   $this->Survey_model->get_equipment_details_view($vessel_id,$survey_id1);
    $data['equipment_details'] = $equipment_details;

    $portofregistry            =   $this->Survey_model->get_portofregistry();
    $data['portofregistry']   =   $portofregistry;

    $bank                     =  $this->Survey_model->get_bank_favoring();
    $data['bank']             =   $bank;

    //--------------Documents-----------------//
    $document_vessel        =   $this->Survey_model->document_vessel($vessel_id,$survey_id,2);
    $data['document_vessel']    = $document_vessel;

    $list_document_vessel        =   $this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']    = $list_document_vessel;

    /*_____________________Start Get Tariff amount form 3 from kiv_tariff)_master table_____________ */   

    $activity_id=2;
    $form_id=2;
    $tariff_dtls =   $this->Survey_model->get_tariff_dtls($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data['tariff_dtls'] = $tariff_dtls;
    $tonnage_details         =   $this->Survey_model->get_tonnage_details($vessel_id);
    $data1['tonnage_details']  =   $tonnage_details;

    if(!empty($tonnage_details))
    {
      @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
    }
    if(!empty($tariff_dtls))
    {
      $tariff_tonnagetype_id=$tariff_dtls[0]['tariff_tonnagetype_id'];
      if($tariff_tonnagetype_id==1)
      {
        $tariff_amount=$key['tariff_amount'];
      }
      elseif($tariff_tonnagetype_id==3)
      {
        $tariff_form2=   $this->Survey_model->get_tariff_form2($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
        $data['tariff_form2'] = $tariff_form2;
        if(!empty($tariff_form2))
        {
          $data['tariff_amount']   = $tariff_form2[0]['tariff_amount'];
        }
        else
        {
          $data['tariff_amount']  = 1;
        }
      }
      elseif($tariff_tonnagetype_id==2)
      {
        $tariff_details_typeid2           =   $this->Survey_model->get_tariff_details_typeid2($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
        $data['tariff_details_typeid2']  =   $tariff_details_typeid2;

        if(!empty($tariff_details_typeid2))
        {
          $data['tariff_amount']  = (($tariff_details_typeid2[0]['tariff_amount'])*$vessel_total_tonnage);
        }
      }
      else
      {
      $data['tariff_amount'] = 1;
      }
    }
    /*_______________________________________________END Tariff____________________________ */   
    $this->load->view('Kiv_views/template/form-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/annual_survey', $data);
    $this->load->view('Kiv_views/template/form-footer.php');
  }
}

function annual_survey_entry()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id		=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'annual_survey_entry', 'page' => 'annual_survey_entry', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  
    if($this->input->post())
    {
      $ip         =	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date      = 	date('Y-m-d h:i:s', time());

      $vessel_id 	=	$this->security->xss_clean($this->input->post('hdn_vessel_id'));
      $cntcount 	=	$this->security->xss_clean($this->input->post('cntcount'));
      $hdn_survey_id 	=	$this->security->xss_clean($this->input->post('hdn_survey_id'));
      $random_number=rand(1,9);
      $form_id='2';

      if(($_FILES["form2_myFile11"]["name"])==true)
      {
        $form_id='2';
        $document_id=11;
        $path_parts = pathinfo($_FILES["form2_myFile11"]["name"]);
        $extension  = $path_parts['extension'];
        if($document_id==true)
        {
          $document_name=$vessel_id.'_'.$document_id.'_'.$form_id.'_'.$random_number.'.'.$extension;
          copy($_FILES["form2_myFile11"]["tmp_name"], "./uploads/annualsurvey/".$document_id."/".$document_name);
          $data_document =	array(
          'vessel_id'			=>	$vessel_id,
          'survey_id'         =>  $hdn_survey_id,
          'document_id'		=>	$document_id,
          'document_type_id'	=>	2,
          'document_name'		=>	$document_name,
          'document_status_id'=>	1,
          'fileupload_created_user_id'  =>	$sess_usr_id,
          'fileupload_created_timestamp'=>	$date,
          'fileupload_created_ipaddress'=>	$ip);
          $res_doc=$this->Survey_model->insert_doc('tbl_kiv_fileupload_details', $data_document);
        }
      }
      if(($_FILES["form2_myFile12"]["name"])==true)
      {
        $form_id='2';
        $document_id=12;
        $path_parts = pathinfo($_FILES["form2_myFile12"]["name"]);
        $extension  = $path_parts['extension'];
        if($document_id==true)
        {
          $document_name=$vessel_id.'_'.$document_id.'_'.$form_id.'_'.$random_number.'.'.$extension;
          copy($_FILES["form2_myFile12"]["tmp_name"], "./uploads/annualsurvey/".$document_id."/".$document_name);
          $data_document =	array(
          'vessel_id'			=>	$vessel_id,
          'survey_id'         =>  $hdn_survey_id,
          'document_id'		=>	$document_id,
          'document_type_id'	=>	2,
          'document_name'		=>	$document_name,
          'document_status_id'=>	1,
          'fileupload_created_user_id'  =>	$sess_usr_id,
          'fileupload_created_timestamp'=>	$date,
          'fileupload_created_ipaddress'=>	$ip);
          $res_doc=$this->Survey_model->insert_doc('tbl_kiv_fileupload_details', $data_document);
        }
      }
    }
  }
}

function form2_annual_survey()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'form2_annual_survey', 'page' => 'form2_annual_survey', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  
    echo "1";
  }
}

function annual_survey_payment()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'annual_survey_payment', 'page' => 'annual_survey_payment', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  
    if($this->input->post())
    {
      $vessel_sl   = $this->session->userdata('vessel_id');
      $processflow_sl     = $this->security->xss_clean($this->input->post('processflow_sl')); 
      $survey_id      = $this->security->xss_clean($this->input->post('survey_id'));
      $status_details_sl= $this->security->xss_clean($this->input->post('status_details_sl'));
      if($vessel_sl=="")
      {
        $vessel_id     = $this->security->xss_clean($this->input->post('hdn_vessel_id'));
      }
      else
      {
        $vessel_id     =$vessel_sl;
      }
      //________________START ONLINE TRANSACTION__________________________________//
      /*_____________________Start Get vessel condition_______________ */   
      $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
      $data['vessel_condition'] = $vessel_condition;
      if(!empty($vessel_condition))
      {
        $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
        $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
        $vessel_length1=$vessel_condition[0]['vessel_length'];
        $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
        $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
      }   /*_____________________End Get vessel condition___________________*/
     /*______________Start Get Tariff amount form 3 from kiv_tariff)_master table_______________ */   
      $activity_id=2;
      $form_id=2;
      $tariff_dtls =   $this->Survey_model->get_tariff_dtls($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id);
      $data['tariff_dtls'] = $tariff_dtls;
      $tonnage_details         =   $this->Survey_model->get_tonnage_details($vessel_id);
      $data1['tonnage_details']  =   $tonnage_details;
      if(!empty($tonnage_details))
      {
        @$vessel_total_tonnage=$tonnage_details[0]['vessel_total_tonnage'];
      }
      if(!empty($tariff_dtls))
      {
        $tariff_tonnagetype_id=$tariff_dtls[0]['tariff_tonnagetype_id'];
        if($tariff_tonnagetype_id==1)
        {
          $tariff_amount=$key['tariff_amount'];
        }
        elseif($tariff_tonnagetype_id==3)
        {
          $tariff_form2=   $this->Survey_model->get_tariff_form2($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
          $data['tariff_form2'] = $tariff_form2;
          if(!empty($tariff_form2))
          {
            $tariff_amount   = $tariff_form2[0]['tariff_amount'];
          }
          else
          {
            $tariff_amount   = 1;
          }
        }
        elseif($tariff_tonnagetype_id==2)
        {
          $tariff_details_typeid2           =   $this->Survey_model->get_tariff_details_typeid2($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage);
          $data['tariff_details_typeid2']  =   $tariff_details_typeid2;
          if(!empty($tariff_details_typeid2))
          {
            @$tariff_amount   = (($tariff_details_typeid2[0]['tariff_amount'])*$vessel_total_tonnage);
          }
        }
        else
        {
          @$tariff_amount= 1;
        }
      }     /*_________________________END Tariff____________________________ */   
      $portofregistry_sl    = $this->security->xss_clean($this->input->post('portofregistry_sl'));
      $bank_sl              = $this->security->xss_clean($this->input->post('bank_sl'));
      $status=1;

      $payment_user=  $this->Survey_model->get_payment_userdetails($sess_usr_id);
      $data['payment_user']     =   $payment_user;
      //rint_r($payment_user);exit;
      if(!empty($payment_user))
      {
        $owner_name=$payment_user[0]['user_name'];
        $user_mobile_number=$payment_user[0]['user_mobile_number'];
        $user_email=$payment_user[0]['user_email'];
      }

      $formnumber=2;
      date_default_timezone_set("Asia/Kolkata");
      $ip         = $_SERVER['REMOTE_ADDR'];
      $date       =   date('Y-m-d h:i:s', time());
      $newDate    =   date("Y-m-d");
      $status_change_date=$date;

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
        $process_id=2;
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
        $ref_number                   = "ASY"."_".$value."_".$vessel_id.$yr;

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
          $bank_transaction_id     =    $this->db->insert_id();
          $update_bank       =    $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);
          $online_payment_data  =  $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
          $data['online_payment_data']= $online_payment_data;
          $payment_user1              =  $this->Survey_model->get_payment_userdetails($sess_usr_id);
          $data['payment_user1']     =  $payment_user1;
          $requested_transaction_details=  $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
          $data['requested_transaction_details']  =   $requested_transaction_details;
          // $data['amount_tobe_pay']=$tariff_amount;//remove comment before uploaded to server
          $data['amount_tobe_pay']=1;
          $data      =  $data+ $this->data;
          if(!empty($online_payment_data))
          { 
            $this->load->view('Kiv_views/Hdfc/hdfc_annualsurvey_request',$data);
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
        redirect('Kiv_Ctrl/Survey/SurveyHome');
      }
    }
  }
}

public function Verify_payment_pc_form2()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 	=	 array('title' => 'Verify_payment_pc_form2', 'page' => 'Verify_payment_pc_form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 	=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details				= 	$this->Survey_model->get_process_flow_payment($processflow_sl);
    $data['vessel_details']		=	$vessel_details;

    @$id 						=	$vessel_details[0]['uid'];

    $customer_details 			=	$this->Survey_model->get_customer_details($id);
    $data['customer_details']	=	$customer_details;

    $current_status 			=	$this->Survey_model->get_status();
    $data['current_status']		=	$current_status;

    $form_number 				=	$this->Survey_model->get_form_number($vessel_id);
    $data['form_number']		=	$form_number;
    $form_id=$form_number[0]['form_no'];


    //----------Vessel Details--------//
    $vessel_details_viewpage = 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']=	$vessel_details_viewpage;

    //----------Payment Details--------//
    $payment_details = 	$this->Survey_model->get_form_payment_details($vessel_id,$survey_id,$form_id);
    $data['payment_details']=	$payment_details;
    //print_r($payment_details);

    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date                  	= 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));;
      $current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $user_sl_cs 		=	$this->security->xss_clean($this->input->post('user_sl_cs'));
      $status 			=	1;

      $status_details_sl=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $payment_sl 	=	$this->security->xss_clean($this->input->post('payment_sl'));
      $payment_approved_remarks =	$this->security->xss_clean($this->input->post('remarks'));

      $date               = 	date('Y-m-d h:i:s', time());
      $ip	      			=	$_SERVER['REMOTE_ADDR'];
      $status_change_date =	$date;

      if($process_id==15)
      {
        $data_payment=array(
        'payment_approved_status' =>1,
        'payment_approved_user_id' =>$sess_usr_id,
        'payment_approved_datetime' =>$status_change_date,
        'payment_approved_ipaddress' =>$ip,
        'payment_approved_remarks' =>$payment_approved_remarks);

        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>7,
        'current_position'=>$current_position,
        'user_id'=>$user_sl_cs,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);

        $data_survey_status=array(
        'current_status_id'=>7,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_sl_cs);

        $payment_update=$this->Survey_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id_surveyactivity 		= 	$this->db->insert_id();

        $data_task=array(
        'process_flow_id' =>  $processflow_id_surveyactivity,
        'assign_date'   =>  $date_of_survey,
        'status'      =>  1);
        $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        if($payment_update && $process_update && $process_insert && $status_update && $task_insert)
        {
          redirect("Kiv_Ctrl/Survey/pcHome"."/".$modidenc);
        }
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_payment_pc_form2',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function annualsurvey_form2()
  {
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id2 		=	$this->uri->segment(6);

  $survey_id11      =   1;

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id2);
  $survey_id=$this->encrypt->decode($survey_id); 

  $survey_id1=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id11);
  $survey_id1=$this->encrypt->decode($survey_id1); 

  if(!empty($sess_usr_id))
  {
    $data 	=	 array('title' => 'annualsurvey_form2', 'page' => 'annualsurvey_form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 	=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;
    //print_r($vessel_details);

    @$id            = $vessel_details[0]['uid'];
    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;
    //  print_r($customer_details);
    @$relation_sl=$customer_details[0]['relation_sl'];
    if(@$relation_sl)
    {
      $agent_details       = $this->Survey_model->get_agent($relation_sl);
      $data['agent_details'] = $agent_details;
      $minor_details       = $this->Survey_model->get_minor($relation_sl);
      $data['minor_details'] = $minor_details;
    }

    //----------Vessel Details--------//
    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;
    $vessel_type_id=$vessel_details_viewpage[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_details_viewpage[0]['vessel_subtype_id'];
    $vessel_total_tonnage=$vessel_details_viewpage[0]['vessel_total_tonnage'];

    //----------Hull Details--------//
    $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id1);
    $data['hull_details']    = $hull_details;

    //----------Engine Details--------//
    $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id1);
    $data['engine_details']  = $engine_details;
    //print_r($engine_details);

    //----------Equipment Details--------//
    $equipment_details     =   $this->Survey_model->get_equipment_details_view($vessel_id,$survey_id1);
    $data['equipment_details'] = $equipment_details;

    $portofregistry            =   $this->Survey_model->get_portofregistry();
    $data['portofregistry']   =   $portofregistry;

    //--------------Documents-----------------//
    $document_vessel        =   $this->Survey_model->document_vessel($vessel_id,$survey_id,2);
    $data['document_vessel']    = $document_vessel;
    //print_r($document_vessel);

    $list_document_vessel        =   $this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']    = $list_document_vessel;

    $surveyor_details          =   $this->Survey_model->get_surveyor_details();
    $data['surveyor_details']      = $surveyor_details;

    $current_status 			=	$this->Survey_model->get_status_form2();
    $data['current_status']		=	$current_status;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/annualsurvey_form2',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

function form2_action()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data 	=	 array('title' => 'form2_action', 'page' => 'form2_action', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 	=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    //4 - revert,5 - approved form 4 intimation send,6 - forward to surveyor
    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date   			= 	date('Y-m-d h:i:s', time());
      $status_change_date =	$date;
      $remarks_date		=	date('Y-m-d');

      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $owner_user_id 		=	$this->security->xss_clean($this->input->post('owner_user_id')); 
      $owner_user_type_id =	$this->security->xss_clean($this->input->post('owner_user_type_id')); 
      $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id')); 
      $forward_to 		=	$this->security->xss_clean($this->input->post('forward_to'));  //surveyor user id
      $remarks 			=	$this->security->xss_clean($this->input->post('remarks')); 
      $vessel_id 			=	$this->security->xss_clean($this->input->post('hdn_vessel_id')); 
      $processflow_sl 	=	$this->security->xss_clean($this->input->post('hdn_processflow_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('hdn_survey_id')); 
      $next_process_id 	=	$this->security->xss_clean($this->input->post('next_process_id')); 
      $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl')); 
      $status=1;
      //_____________________________Revert to Vessel Owner________________________//
      if($current_status_id==4)
      {
        $data_insert=array(
        'vessel_id' 		=>	$vessel_id,
        'process_id' 		=>	$process_id,
        'survey_id'			=>	$survey_id,
        'current_status_id'	=>	$current_status_id,
        'current_position'	=>	$owner_user_type_id,
        'user_id'			=>	$owner_user_id,
        'previous_module_id'=>	$processflow_sl,
        'status'			=>	$status,
        'status_change_date'=>	$status_change_date);
        $data_update = array('status'=>0);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();

        $data_remarks = array(
        'sending_user_id' 	=> 	$processflow_sl,
        'receiving_user_id'	=> 	$processflow_id,
        'process_id'		=>	$process_id,
        'remarks_date'		=> 	$remarks_date,
        'remarks'			=>	$remarks,
        'entry_timestamp'	=>	$date);

        $data_survey_status=array(
        'current_status_id'	=>	$current_status_id,
        'sending_user_id'	=>	$sess_usr_id,
        'receiving_user_id'	=>	$owner_user_id);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);
        if($process_update && $process_insert && $remarks_insert && $status_update)
        {
          redirect("Kiv_Ctrl/Survey/csHome");
        }
      } //___________________________________________________________________________//

        //___________________Approve and forward to Surveyor______________________________//
      if($current_status_id==6)
      {
        //Approve Form 2
        $data_insert=array(
        'vessel_id'			=>	$vessel_id,
        'process_id'		=>	$process_id,
        'survey_id'			=>	$survey_id,
        'current_status_id'	=>	5,
        'current_position'	=>	$user_type_id,
        'user_id'			=>	$sess_usr_id,
        'previous_module_id'=>	$processflow_sl,
        'status'			=>	0,
        'status_change_date'=>	$status_change_date);

        $data_update = array('status'=>0);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

        $processflow_id 		= 	$this->db->insert_id();

        $data_remarks = array(
        'sending_user_id' 		=> 	$processflow_sl,
        'receiving_user_id'		=> 	$processflow_id,
        'process_id'			=>	$process_id,
        'remarks_date'			=> 	$remarks_date,
        'remarks'				=>	$remarks,
        'entry_timestamp'		=>	$date);
        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

        //Forward Survey Activity
        $data_insert_surveyactivity=array(
        'vessel_id'			=>	$vessel_id,
        'process_id'		=>	$next_process_id,
        'survey_id'			=>	$survey_id,
        'current_status_id'	=>	2,
        'current_position'	=>	13,
        'user_id'			=>	$forward_to,
        'previous_module_id'=>	$processflow_sl,
        'status'			=>	$status,
        'status_change_date'=>	$status_change_date);

        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);

        $processflow_id_surveyactivity 		= 	$this->db->insert_id();

        $data_remarks_surveyactivity = array(
        'sending_user_id' 	=> 	$processflow_sl,
        'receiving_user_id'	=> 	$processflow_id_surveyactivity,
        'process_id'		=>	$next_process_id,
        'remarks_date'		=> 	$remarks_date,
        'remarks'			=>	$remarks,
        'entry_timestamp'	=>	$date);

        $data_survey_status=array(
        'process_id'		 =>	$next_process_id,	
        'current_status_id'	 =>	$current_status_id,
        'sending_user_id'	 =>	$sess_usr_id,
        'receiving_user_id'	 =>	$forward_to);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        $remarks_insert_surveyactivity=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks_surveyactivity);
        if($process_update && $process_insert && $remarks_insert && $process_insert_surveyactivity && $remarks_insert_surveyactivity)
        {
          redirect("Kiv_Ctrl/Survey/csHome");
        }
      }   //________________________________________________//

        //____________________Approve form 2 and send form 4 intimation______________________________//
      if($current_status_id==5)	
      {	
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>0,
        'status_change_date'=>$status_change_date);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id 		= 	$this->db->insert_id();

        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);

        $data_insert_surveyactivity=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$next_process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>2,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);


        $data_remarks = array(
        'sending_user_id' => $processflow_sl,
        'receiving_user_id'=> $processflow_id,
        'process_id'=>$process_id,
        'remarks_date'=> $remarks_date,
        'remarks'=>$remarks,
        'entry_timestamp'=>$date);

        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);

        $processflow_id_surveyactivity 		= 	$this->db->insert_id();

        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

        $data_survey_status=array(
        'process_id'		=>$next_process_id,
        'current_status_id'	=>2,
        'sending_user_id'	=>$sess_usr_id,
        'receiving_user_id'	=>$sess_usr_id);
        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        if($process_update && $process_insert && $remarks_insert  &&  $status_update)
        {
          redirect("Kiv_Ctrl/Survey/csform4/".$vessel_id."/".$processflow_id_surveyactivity."/".$survey_id);
        }
        else
        {
          redirect('Main_login/index');
        }
      } //_________________________________________________//
    }
  }
}


public function Verify_payment_pc_registration()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

  $vessel_id1    = $this->uri->segment(4);
  $processflow_sl1   = $this->uri->segment(5);
  $survey_id1    = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data   =  array('title' => 'Verify_payment_pc_registration', 'page' => 'Verify_payment_pc_registration', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details       =   $this->Survey_model->get_process_flow_payment($processflow_sl);
    $data['vessel_details']   = $vessel_details;

    @$id            = $vessel_details[0]['uid'];

    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;

    $current_status       = $this->Survey_model->get_status();
    $data['current_status']   = $current_status;

    $form_number        = $this->Survey_model->get_form_number($vessel_id);
    $data['form_number']    = $form_number;
    //print_r($form_number);
    if(!empty($form_number))
    {
      $form_id=$form_number[0]['form_no'];
    }
    else
    {
      $form_id=0;
    }

    //----------Vessel Details--------//

    $vessel_details_viewpage =  $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;

    //----------Payment Details--------// 4 0 12
    $payment_details =  $this->Survey_model->get_form_payment_details($vessel_id,$survey_id,$form_id);
    $data['payment_details']= $payment_details;
    //print_r($payment_details);

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

      if($process_id==14)
      {
        $data_payment=array(
        'payment_approved_status' =>1,
        'payment_approved_user_id' =>$sess_usr_id,
        'payment_approved_datetime' =>$status_change_date,
        'payment_approved_ipaddress' =>$ip,
        'payment_approved_remarks' =>$payment_approved_remarks);

        $new_process_id=16;
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>7,
        'current_position'=>$current_position,
        'user_id'=>$user_sl_ra,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);

        $data_survey_status=array(
        'current_status_id'=>7,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_sl_ra);

        $payment_update=$this->Survey_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id_surveyactivity    =   $this->db->insert_id();

        $data_task=array(
        'process_flow_id' =>  $processflow_id_surveyactivity,
        'assign_date'   =>  $date_of_survey,
        'status'      =>  1);
        $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);
        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        if($payment_update && $process_update && $process_insert && $status_update && $task_insert)
        {
          redirect("Kiv_Ctrl/Survey/pcHome"."/".$modidenc);
        }
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_payment_pc_registration',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
/*___________________Form 1 forward to Chief surveyor/Surveyor______________*/	

public function Forward_Vessel_form2()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'Forward_Vessel_form2', 'page' => 'Forward_Vessel_form2', 'errorCls' => NULL, 'post' => $this->input->post());

    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details			= 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']	=	$vessel_details;
    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date   			       = 	date('Y-m-d h:i:s', time());
      $status_change_date  =	$date;
      $remarks_date		     =	date('Y-m-d');
      $vessel_id 			     =	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		     =	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			     =	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	 =	$this->security->xss_clean($this->input->post('current_status_id'));
      $current_position 	 =	$this->security->xss_clean($this->input->post('current_position')); 
      $processflow_sl		   =	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			       =	$this->security->xss_clean($this->input->post('user_id'));
      $status 			       =	1;
      $status_details_sl   =	$this->security->xss_clean($this->input->post('status_details_sl'));
      /* 	$task_pfid=$this->Survey_model->get_task_pfid($processflow_sl);
      $data['task_pfid']	=	$task_pfid;
      @$task_sl=$task_pfid[0]['task_sl'];*/

      if($process_id==15)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$current_position,
        'user_id'=>$user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $process_insert    =$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id_surveyactivity 		= 	$this->db->insert_id();
        $data_update = array('status'=>0);

        $data_survey_status=array(
        'current_status_id'=>$current_status_id,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_id);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $data_task=array(
        'process_flow_id'=>$processflow_id_surveyactivity,
        'assign_date'	=>$remarks_date,
        'status'	=>1);
        $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);
        if($process_update && $process_insert && $task_insert && $status_update)
        {
          redirect("Kiv_Ctrl/Survey/SurveyHome");
        }
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Forward_Vessel_form2',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
  redirect('Main_login/index');        
  }
}

/*__________________________form 4 defect by cs/sr_______________________*/

public function form4defect_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id 	= $this->session->userdata('customer_id');
  $survey_user_id	= $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'form4defect_annual', 'page' => 'form4defect_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $survey_intimation          = $this->Survey_model->get_survey_intimation($vessel_id,$survey_id);
    $data['survey_intimation']  = $survey_intimation;

    $vessel_details       		=   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   	= 	$vessel_details;

    @$survey_defects_id=$survey_intimation[0]['survey_defects_id'];

    $placeof_survey 			=	$this->Survey_model->get_placeof_survey();
    $data['placeof_survey'] 	=	$placeof_survey;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form4defect_annual',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}

/*__________________________form 4 defect by cs/sr_______________________*/
public function form4defect_detection_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id 	= $this->session->userdata('customer_id');
  $survey_user_id	= $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'form4defect_detection_annual', 'page' => 'form4defect_detection_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $survey_intimation          = $this->Survey_model->get_survey_intimation($vessel_id,$survey_id);
    $data['survey_intimation']  = $survey_intimation;

    $intimation_sl=$survey_intimation[0]['intimation_sl'];

    @$survey_defects_id=$survey_intimation[0]['survey_defects_id'];
    @$survey_defects_id1=$survey_intimation[0]['survey_defects_id'];
    //print_r($survey_intimation);

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;
    //print_r($vessel_details);

    if($this->input->post())
    {
      $ip     =	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date               = 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      //$current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
      //$current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $owner_user_id 		=	$this->security->xss_clean($this->input->post('user_id'));
      $owner_user_type_id=	$this->security->xss_clean($this->input->post('user_type_id'));
      $status 			=	1;
      $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $defect_status		=	$this->security->xss_clean($this->input->post('defect_status'));
      $category 			=	$this->security->xss_clean($this->input->post('category'));

      $defects_noticed_by 	=	$user_type_id;
      $time_period			=	$this->security->xss_clean($this->input->post('time_period'));
      $direction_to_rectify 	=	$this->security->xss_clean($this->input->post('direction_to_rectify'));
      $defect_details 		=	$this->security->xss_clean($this->input->post('defect_details'));

      $placeofsurvey_sl = $this->security->xss_clean($this->input->post('placeofsurvey_sl'));
      $date_of_survey2  = $this->security->xss_clean($this->input->post('date_of_survey'));
      $date_of_survey1 = str_replace('/', '-', $date_of_survey2);
      $date_of_survey   = date("Y-m-d", strtotime($date_of_survey1));

      $time_of_survey      = $this->security->xss_clean($this->input->post('time_of_survey'));
      $remarks          = $this->security->xss_clean($this->input->post('remarks')); 

      $defect_intimation 		= 	pathinfo($_FILES['defect_intimation']['name']);

      if($defect_intimation)
      {
        $extension  			= 	$defect_intimation['extension'];
      }
      else
      {
        $extension  ="";
      }

      $random_number 			=	rand(1,9);

      //defect_status=1 No defect ; 2 Defect found
      if($defect_status==1 && $category==1)
      {
        $process_id_new=19;  //category A - form5
      }
      if($defect_status==1 && $category==2)
      {
        $process_id_new=20; //category B - form6
      }

      //No defect found
      if($defect_status==1)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>5,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>0,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id     =   $this->db->insert_id();

        $data_survey_status=array(
        'process_id'=>$process_id_new,
        'current_status_id'=>1,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$sess_usr_id);


        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $data_insert_surveyactivity=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id_new,
        'survey_id'=>$survey_id,
        'current_status_id'=>1,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);

        $data_category=array('category'=>$category,
        'vessel_modified_user_id'=>$sess_usr_id,
        'vessel_modified_timestamp'=>$date,
        'vessel_modified_ipaddress'=>$ip);

        $vessel_update=$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_category, $vessel_id);

        $update_defectstatus_data=array('status'=>1);

        if($survey_defects_id!=0)
        {
          $update_defectstatus_details=$this->Survey_model->update_defect_table('tbl_kiv_survey_defects', $update_defectstatus_data, $survey_defects_id);
        }

        if($survey_defects_id1==0)
        {
          $update_intimation_data=array('status'=>2);
        }
        if($survey_defects_id1!=0)
        {
          $update_intimation_data=array('status'=>2,
          'defect_status'=>2);
        }

        $update_intimation_details=$this->Survey_model->update_intimation_table('tbl_kiv_survey_intimation',$update_intimation_data,$intimation_sl);

        if($process_update && $process_insert && $status_update && $process_insert_surveyactivity && $vessel_update && $user_type_id==12)
        {
          redirect('Kiv_Ctrl/Survey/csActivities');
        }
        elseif($process_update && $process_insert && $status_update && $process_insert_surveyactivity && $vessel_update && $user_type_id==13)
        {
        redirect('Kiv_Ctrl/Survey/srActivities');
        }
        else
        {
        redirect('Main_login/index');
        }
      }
        /*___________________________end_____________________________________________ */
      $formnumber=2;
      $defect_count           =   $this->Survey_model->get_defect_count($vessel_id,$survey_id);
      $data['defect_count']   =   $defect_count;
      if(!empty($defect_count))
      {
        $count = count($defect_count);
        $data['count']=$count;
      }
      else
      {
        $count=0;
      }
      //if Defect found
      if($defect_status==2)
      {
        $data_defect_details=array('intimation_id'=>$intimation_sl,
        'defects_noticed_by'=>$sess_usr_id,
        'time_period'=>$time_period,
        'direction_to_rectify'=>$direction_to_rectify,
        'defect_details'=>$defect_details,
        'placeofsurvey_id'=>$placeofsurvey_sl,
        'date_of_survey'=>$date_of_survey,
        'time_of_survey'=>$time_of_survey,
        'remarks'=>$remarks,
        'status'=>0,
        'defect_created_timestamp'=>$date,
        'defect_created_ipaddress'=>$ip	);

        $insert_table=$this->Survey_model->insert_table('tbl_kiv_survey_defects', $data_defect_details);
        $survey_defects_sl 		= 	$this->db->insert_id();
        if($insert_table)
        {
          $pdf_name=$vessel_id.'_'.$intimation_sl.'_'.$survey_defects_sl.'_'.$random_number.'.'.$extension;
          copy($_FILES["defect_intimation"]["tmp_name"], "./uploads/defects/".$pdf_name);

          $update_defect_data=array('defect_intimation'=>$pdf_name);

          $update_defect_details=$this->Survey_model->update_defect_table('tbl_kiv_survey_defects', $update_defect_data,$survey_defects_sl);

          $update_defectstatus_data=array('status'=>1);

          if($survey_defects_id!=0)
          {
          $update_defectstatus_details=$this->Survey_model->update_defect_table('tbl_kiv_survey_defects', $update_defectstatus_data,$survey_defects_id);
          }

          $update_intimation_data=array('defect_status'=>1,
          'survey_defects_id'=>$survey_defects_sl);

          $update_intimation_details=$this->Survey_model->update_intimation_table('tbl_kiv_survey_intimation',$update_intimation_data,$intimation_sl);
        }
      }
        //------------------process flow start----------------------//
      if($count>1)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>18,
        'survey_id'=>$survey_id,
        'current_status_id'=>2,
        'current_position'=>$owner_user_type_id,
        'user_id'=>$owner_user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id     =   $this->db->insert_id();

        $data_survey_status=array(
        'process_id'=>18,
        'current_status_id'=>2,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$owner_user_id);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        if($process_update && $process_insert && $status_update && $user_type_id==12)
        {
          redirect('Kiv_Ctrl/Survey/csActivities');
        }
        elseif($process_update && $process_insert && $status_update &&  $user_type_id==13)
        {
          redirect('Kiv_Ctrl/Survey/srActivities');
        }
        else
        {
          redirect('Main_login/index');
        }
      }
      else
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>18,
        'survey_id'=>$survey_id,
        //'current_status_id'=>2,
        'current_status_id'=>7,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>0,
        'status_change_date'=>$status_change_date	);

        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id     =   $this->db->insert_id();

        $data_survey_status=array(
        'process_id'=>18,
        //'current_status_id'=>2,
        'current_status_id'=>7,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$sess_usr_id);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        $data_insert_surveyactivity=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>18,
        'survey_id'=>$survey_id,
        //'current_status_id'=>2,
        'current_status_id'=>7,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);
        $processflow_id_surveyactivity 		= 	$this->db->insert_id();

        $data_task=array(
        'process_flow_id' =>  $processflow_id_surveyactivity,
        'assign_date'   =>  $date_of_survey,
        'status'      =>  1);
        $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);

        if($process_update && $process_insert && $status_update && $process_insert_surveyactivity && $user_type_id==12 && $task_insert)
        {
          redirect('Kiv_Ctrl/Survey/csActivities');
        }
        elseif($process_update && $process_insert && $status_update && $process_insert_surveyactivity && $user_type_id==13 && $task_insert)
        {
          redirect('Kiv_Ctrl/Survey/srActivities');
        }
        else
        {
          redirect('Main_login/index');
        }
      } //------------------process flow end----------------------//
    }
  }
}

public function DefectDetails_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $survey_defects_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);
  $processflow_id1 			= 	$this->uri->segment(7);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_id1);
  $processflow_id=$this->encrypt->decode($processflow_id); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $survey_defects_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_defects_sl1);
  $survey_defects_sl=$this->encrypt->decode($survey_defects_sl); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'DefectDetails_annual', 'page' => 'DefectDetails_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $survey_defect_details      =   $this->Survey_model->get_survey_defect_details($survey_defects_sl,$vessel_id,$survey_id);
    $data['survey_defect_details']  = $survey_defect_details;
    //  print_r($survey_defect_details);

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/DefectDetails_annual',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function Verify_payment_pc_form4_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data 	=	 array('title' => 'Verify_payment_pc_form4_annual', 'page' => 'Verify_payment_pc_form4_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 	=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details				= 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']		=	$vessel_details;
    //print_r($vessel_details);

    @$id 						=	$vessel_details[0]['user_id'];

    $customer_details 			=	$this->Survey_model->get_customer_details($id);
    $data['customer_details']	=	$customer_details;

    $current_status 			=	$this->Survey_model->get_status();
    $data['current_status']		=	$current_status;

    $form_number 				=	$this->Survey_model->get_form_number($vessel_id);
    $data['form_number']		=	$form_number;
    $form_id=$form_number[0]['form_no'];

    //----------Vessel Details--------//
    $vessel_details_viewpage = 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']=	$vessel_details_viewpage;

    //----------Payment Details--------//
    $payment_details = 	$this->Survey_model->get_form_payment_details($vessel_id,$survey_id,$form_id);
    $data['payment_details']=	$payment_details;
    //print_r($payment_details);

    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date                  	= 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));;
      $current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $user_sl_cs_sr 		=	$this->security->xss_clean($this->input->post('user_sl_cs'));
      $status 			=	1;

      $status_details_sl=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $payment_sl 	=	$this->security->xss_clean($this->input->post('payment_sl'));
      $payment_approved_remarks =	$this->security->xss_clean($this->input->post('remarks'));

      $date               = 	date('Y-m-d h:i:s', time());
      $ip	      			=	$_SERVER['REMOTE_ADDR'];
      $status_change_date =	$date;

      if($process_id==18)
      {
        $data_payment=array(
        'payment_approved_status' =>1,
        'payment_approved_user_id' =>$sess_usr_id,
        'payment_approved_datetime' =>$status_change_date,
        'payment_approved_ipaddress' =>$ip,
        'payment_approved_remarks' =>$payment_approved_remarks);


        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>7,
        'current_position'=>$current_position,
        'user_id'=>$user_sl_cs_sr,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);

        $data_survey_status=array(
        'current_status_id'=>7,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_sl_cs_sr);
        //print_r($data_survey_status);
        
        $payment_update=$this->Survey_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

        $processflow_id_surveyactivity 		= 	$this->db->insert_id();

        $data_task=array(
        'process_flow_id' =>  $processflow_id_surveyactivity,
        'assign_date'   =>  $date_of_survey,
        'status'      =>  1);
        $task_insert=$this->Survey_model->insert_task('tbl_kiv_task', $data_task);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        if($payment_update && $process_update && $process_insert && $status_update && $task_insert)
        {
          redirect("Kiv_Ctrl/Survey/pcHome"."/".$modidenc);
        }
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_payment_pc_form4_annual',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

/*_______________________________form 6 view annual_______________________________________*/

public function form6_view_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form6_view_annual', 'page' => 'form6_view_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    $survey_id1 		=1;
    //----------Vessel Details--------//
    $vessel_details       		=   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   	= 	$vessel_details;
    //print_r($vessel_details);

    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;

    //----------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id1);
    $data['hull_details']		=	$hull_details;

    //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id1);
    $data['engine_details']	=	$engine_details;

    //----------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id1);
    $data['equipment_details']	=	$equipment_details;

    //----------Get portable fire extinguisher---------------//
    $portable_fire_ext	          = 	$this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id1);
    $data['portable_fire_ext']	  =	  $portable_fire_ext;
         
    //--------------Documents-----------------//
    $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']		=	$list_document_vessel;

    @$id=$vessel_details_viewpage[0]['user_id'];

    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form6_view_annual',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');
  }
}


function form6_entry_annaul()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form6_entry_annaul', 'page' => 'form6_entry_annaul', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    if($this->input->post())
    {
      $vessel_id 	= $this->security->xss_clean($this->input->post('hdn_vesselId'));
      $survey_id 	= $this->security->xss_clean($this->input->post('hdn_surveyId'));

      $processflow_sl = $this->security->xss_clean($this->input->post('processflow_sl'));
      $process_id 	=	$this->security->xss_clean($this->input->post('process_id')); 

      $user_id 		=	$this->security->xss_clean($this->input->post('user_id'));
      $user_type_id1 	=	$this->security->xss_clean($this->input->post('user_type_id'));
      $status 		=	1;
      $status_details_sl =	$this->security->xss_clean($this->input->post('status_details_sl'));

      $ip=	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date = 	date('Y-m-d h:i:s', time());
      $status_change_date =	$date;

      //--process flow---//
      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$user_type_id,
      'user_id'=>$user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>0,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id     =   $this->db->insert_id();

      $new_process_id=21;
      //Assign form7
      $data_insert_form7=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$new_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>1,
      'current_position'=>$user_type_id,
      'user_id'=>$sess_usr_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);

      $process_insert_form7=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_form7);

      $data_survey_status=array(
      'process_id'=>$new_process_id,
      'current_status_id'=>1,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$sess_usr_id);


      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      if($process_update && $process_insert && $process_insert_form7 && $status_update && $user_type_id==12)
      {
        redirect('Kiv_Ctrl/Survey/csHome');
      }
      elseif($process_update && $process_insert && $process_insert_form7 && $status_update && $user_type_id==13)
      {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');
      }
      else
      {
        redirect('Main_login/index');
      }
    }
  }
}

/*_______________________________form 7 entry annual________________________________*/

public function form7_entry_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form7_entry_annual', 'page' => 'form7_entry_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_form7_process_flow_csde($sess_usr_id,$vessel_id);
    $data['initial_data']		=	$initial_data;

    $count	= count($initial_data);
    $data['count']=$count;
    @$id=$initial_data[0]['vessel_created_user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    if($this->input->post())
    {
      $ip     =	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date               = 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      //$current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
      //$current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));

      $owner_user_id 		=	$id;
      $owner_user_type_id=	2;
      $status 			=	1;
      $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));

      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$owner_user_type_id,
      'user_id'=>$owner_user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id     =   $this->db->insert_id();

      $data_survey_status=array(
      'process_id'=>$process_id,
      'current_status_id'=>5,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$owner_user_id);

      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      if($process_update && $process_insert && $status_update)
      {
        redirect('Kiv_Ctrl/Survey/form7_entryview');
      }
      else
      {
        redirect('Kiv_Ctrl/Kiv_Ctrl/Main_login/index');        
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form7_entry_annual',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }

}
/*_______________________________form 7 view annual ________________________________*/

public function form7_view_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id		=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form7_view_annual', 'page' => 'form7_view_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_form7_process_flow($sess_usr_id);
    $data['initial_data']		=	$initial_data;
    $activity_id=1;
    $form_id=	7;
    $vessel_type_id=	$initial_data[0]['vessel_type_id'];
    $vessel_subtype_id=	$initial_data[0]['vessel_subtype_id'];

    $count	= count($initial_data);
    $data['count']=$count;
    @$id=$initial_data[0]['vessel_created_user_id'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $tariff_details     		  =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data['tariff_details'] 	= 	$tariff_details;

    $process_data			    = 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['process_data']		=	$process_data;
    if(!empty($process_data))
    {

    $previous_module_id=$process_data[0]['previous_module_id'];
    $process_data_cssr			    = 	$this->Survey_model->get_user_type_user_id($previous_module_id);
    $data['process_data_cssr']		=	$process_data_cssr;
    $user_id_cs_sr=$process_data_cssr[0]['user_id'];
    $user_type_id_cs_sr=$process_data_cssr[0]['current_position'];
    }

    if($this->input->post())
    {
      $ip     			=	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date               = 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id'));
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $processflow_sl 	=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $owner_user_id 		=	$this->security->xss_clean($this->input->post('user_id'));
      $owner_user_type_id =	$this->security->xss_clean($this->input->post('user_type_id'));
      $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $status_change_date =	$date;
      $owner_user_type_id =	2;
      $status 			=	1;

      $new_process_id=22;
      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$new_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>2,
      //'current_position'=>4,
      //'user_id'=>4,
      'current_position'=>$user_type_id_cs_sr,
      'user_id'=>$user_id_cs_sr,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id     =   $this->db->insert_id();

      $data_survey_status=array(
      'process_id'=>$new_process_id,
      'current_status_id'=>2,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$user_id_cs_sr);


      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      if($process_update && $process_insert && $status_update)
      {
        redirect('Kiv_Ctrl/Survey/SurveyHome');
      }
      else
      {
        redirect('Main_login/index');        
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form7_view_annual',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

/*_______________________________form 8 view ________________________________*/

public function form8_view_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form8_view_annual', 'page' => 'form8_view_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $initial_data			    = 	$this->Survey_model->get_form8_process_flow($sess_usr_id,$vessel_id);
    $data['initial_data']		=	$initial_data;
    //print_r($initial_data);

    @$id=$initial_data[0]['vessel_created_user_id'];
    @$category=$initial_data[0]['category'];

    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    if($this->input->post())
    {
      $ip     			=	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date               = 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id'));
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $processflow_sl 	=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $owner_user_id 		=	$this->security->xss_clean($this->input->post('user_id'));
      $owner_user_type_id =	$this->security->xss_clean($this->input->post('user_type_id'));
      $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $status_change_date =	$date;
      $status 			=	1;
      if($category==1)
      {
        $new_process_id=23;
      }
      if($category==2)
      {
        $new_process_id=24;
      }
      /*$new_process_id_form9=12;
      $new_process_id_form10=13;*/
      //-------------- new modification -------------//
      $data_insert_approve_form8=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$user_type_id,
      'user_id'=>$sess_usr_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>0,
      'status_change_date'=>$status_change_date);

      $process_insert_form8=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_approve_form8);
      //-------------- new modification end-------------//

      $usertype_id_cs=12;
      $user_id_cs   = $this->Survey_model->get_user_id_cs(12);
      $data['user_id_cs']    = $user_id_cs;
      if(!empty($user_id_cs)) 
      {
        $cs_user_id=$user_id_cs[0]['user_master_id'];
      }

      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$new_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>1,
      'current_position'=>$user_type_id,
      'user_id'=>$sess_usr_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);

      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);

      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id     =   $this->db->insert_id();

      $data_survey_status=array(
      'process_id'=>$new_process_id,
      'current_status_id'=>1,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$sess_usr_id);

      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      if($process_update && $process_insert && $status_update && $user_type_id==12)
      {
      redirect('Kiv_Ctrl/Survey/csHome');
      }
      elseif($process_update && $process_insert && $status_update && $user_type_id==13)
      {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');
      }
      else
      {
        redirect('Main_login/index');        
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form8_view_annual',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
/*_______________________________form 10 view  annual________________________________*/

public function form10_view_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $survey_id 		=	1;
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form10_view_annual', 'page' => 'form10_view_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $this->load->model('Kiv_models/Function_model');

    //----------Vessel Details--------//
    $vessel_details           =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']     =   $vessel_details;


    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;

    //---------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']		=	$hull_details;

    //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']	=	$engine_details;

    //----------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details']	=	$equipment_details;
    //print_r($equipment_details);

    //----------Get portable fire extinguisher---------------//
    $portable_fire_ext	          = 	$this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id);
    $data['portable_fire_ext']	  =	  $portable_fire_ext;

    //--------------Documents-----------------//
    $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']		=	$list_document_vessel;

    @$id=$vessel_details_viewpage[0]['user_id'];

    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $annual_survey=$this->Survey_model->get_annual_survey($vessel_id);
    $data['annual_survey']  =$annual_survey;

    $annual_survey_done=$this->Survey_model->get_annual_survey_done($vessel_id);
    $data['annual_survey_done']  = $annual_survey_done;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form10_view_annual',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

function form10_annual_entry()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  //$survey_id 		=	1;
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form10_view_annual', 'page' => 'form10_view_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    if($this->input->post())
    {
      $process_id 			=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 				=	$this->security->xss_clean($this->input->post('survey_id'));
      $processflow_sl 		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 				=	$this->security->xss_clean($this->input->post('user_id'));
      $user_type_id 			=	$this->security->xss_clean($this->input->post('user_type_id'));
      $status_details_sl 		=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $owner_user_type_id 	=	$this->security->xss_clean($this->input->post('owner_user_type_id'));
      $owner_user_id 			=	$this->security->xss_clean($this->input->post('owner_user_id'));
      $timeline_sl 			=	$this->security->xss_clean($this->input->post('timeline_sl'));
      $vessel_registration_number =	$this->security->xss_clean($this->input->post('vessel_registration_number'));
      $vessel_survey_number =	$this->security->xss_clean($this->input->post('vessel_survey_number'));
      $vesselId =	$this->security->xss_clean($this->input->post('hdn_vesselId'));
      $status 			=	1;

      $ip=	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date = 	date('Y-m-d h:i:s', time());
      $status_change_date 	=	$date;
      $date_of_survey      		=date('Y-m-d');
      $adding_one_year 			= date('d-m-Y', strtotime($date_of_survey . "1 year") );
      //$adding_five_year 			= date('d-m-Y', strtotime($date_of_survey . "5 year") );
      $annual_survey_date        	= date("Y-m-d", strtotime($adding_one_year));
      //$drydock_survey_date        = date("Y-m-d", strtotime($adding_five_year));

      $timeline_data_annual = array('vessel_id' =>$vesselId ,
      'survey_number' => $vessel_survey_number,
      'registration_number' => $vessel_registration_number,
      'process_id' => 1,
      'subprocess_id' => 2,
      'scheduled_date' => $annual_survey_date,
      'status' => 0,
      'link_id' => $timeline_sl,
      'timeline_created_user_id' => $sess_usr_id,
      'timeline_created_timestamp' =>$date,
      'timeline_created_ipaddress' => $ip);

      $insert_timeline_annual=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_annual);

      $timeline_date_update=array('actual_date' =>$date_of_survey,
      'status' => 1,
      'timeline_modified_user_id' => $sess_usr_id,
      'timeline_modified_timestamp' =>$date,
      'timeline_modified_ipaddress' => $ip);

      $update_timeline		=	$this->Survey_model->update_tbl_kiv_vessel_timeline('tbl_kiv_vessel_timeline',$timeline_date_update,$timeline_sl);

      //--process flow---//
      $data_insert=array(
      'vessel_id'=>$vesselId,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$user_type_id,
      'user_id'=>$user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>0,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id     =   $this->db->insert_id();
      $new_process_id=25;

      $data_insert_form=array(
      'vessel_id'=>$vesselId,
      'process_id'=>$new_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$owner_user_type_id,
      'user_id'=>$owner_user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);

      $process_insert_form=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_form);

      $data_survey_status=array(
      'process_id'=>$new_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'sending_user_id'=>$user_id,
      'receiving_user_id'=>$owner_user_id);

      $data_main=array('processing_status'=>0,
      'vesselmain_annual_id'=>1,
      'vesselmain_annual_date'=>$date_of_survey,
      ' vesselmain_annual_status'=>'1');  

      $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);
      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      if($insert_timeline_annual && $update_timeline && $process_update && $process_insert && $process_insert_form && $status_update)
      {
        redirect('Kiv_Ctrl/Survey/csHome');
      }
      else
      {
        redirect('Main_login/index');
      }
    }
  }
}

/*_______________________________form 5 view annual_______________________________________*/

public function form5_view_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form5_view_annual', 'page' => 'form5_view_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $this->load->model('Kiv_models/Function_model');

    $survey_id1 		=1;
    //----------Vessel Details--------//

    $vessel_details       		=   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   	= 	$vessel_details;

    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;

    //----------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id1);
    $data['hull_details']		=	$hull_details;

    //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id1);
    $data['engine_details']	=	$engine_details;

    //----------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id1);
    $data['equipment_details']	=	$equipment_details;


    //----------Get portable fire extinguisher---------------//
    $portable_fire_ext	          = 	$this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id1);
    $data['portable_fire_ext']	  =	  $portable_fire_ext;
               

    //--------------Documents-----------------//
            $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']		=	$list_document_vessel;

    @$id=$vessel_details_viewpage[0]['user_id'];

    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form5_view_annual',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');
  }
}


function form5_entry_annaul()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form5_entry_annaul', 'page' => 'form5_entry_annaul', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    if($this->input->post())
    {
      $vessel_id 	= $this->security->xss_clean($this->input->post('hdn_vesselId'));
      $survey_id 	= $this->security->xss_clean($this->input->post('hdn_surveyId'));

      $processflow_sl = $this->security->xss_clean($this->input->post('processflow_sl'));
      $process_id 	=	$this->security->xss_clean($this->input->post('process_id')); 

      $user_id 		=	$this->security->xss_clean($this->input->post('user_id'));
      $user_type_id1 	=	$this->security->xss_clean($this->input->post('user_type_id'));
      $status 		=	1;
      $status_details_sl =	$this->security->xss_clean($this->input->post('status_details_sl'));

      $ip=	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date = 	date('Y-m-d h:i:s', time());
      $status_change_date =	$date;

      //--process flow---//
      $data_insert=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$user_type_id,
      'user_id'=>$user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>0,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id     =   $this->db->insert_id();

      $new_process_id=21;
      //Assign form7
      $data_insert_form7=array(
      'vessel_id'=>$vessel_id,
      'process_id'=>$new_process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>1,
      'current_position'=>$user_type_id,
      'user_id'=>$sess_usr_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);

      $process_insert_form7=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_form7);

      $data_survey_status=array(
      'process_id'=>$new_process_id,
      'current_status_id'=>1,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$sess_usr_id);

      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      if($process_update && $process_insert && $process_insert_form7 && $status_update && $user_type_id==12)
      {
      redirect('Kiv_Ctrl/Survey/csHome');
      }
      elseif($process_update && $process_insert && $process_insert_form7 && $status_update && $user_type_id==13)
      {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');
      }
      else
      {
        redirect('Main_login/index');
      }
    }
  }
}
/*_______________________________form 9 view  annual________________________________*/
public function form9_view_annual()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id1=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id1=$this->encrypt->decode($survey_id1); 

  $survey_id100=1;

  $survey_id2 = $this->encrypt->encode($survey_id100); 
  $survey_id=str_replace(array('+', '/', '='), array('-', '_', '~'), $survey_id2);

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'form9_view_annual', 'page' => 'form9_view_annual', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $this->load->model('Kiv_models/Function_model');

    //----------Vessel Details--------//
    $vessel_details_viewpage 			= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']	=	$vessel_details_viewpage;

    //----------Hull Details--------//
    $hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']		=	$hull_details;

    //----------Engine Details--------//
    $engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']	=	$engine_details;

    //----------Equipment Details--------//
    $equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details']	=	$equipment_details;

    //----------Get portable fire extinguisher---------------//
    $portable_fire_ext	          = 	$this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id);
    $data['portable_fire_ext']	  =	  $portable_fire_ext;

    //--------------Documents-----------------//
    $list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']		=	$list_document_vessel;

    @$id=$vessel_details_viewpage[0]['user_id'];

    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form9_view_annual',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}
//_______________________ANNUAL SURVEY END___________________________________//
//_______________________DRYDOCK SURVEY START________________________________//

public function drydock_survey()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $survey_id1=1;

  if(!empty($sess_usr_id))
  {
    $data   =  array('title' => 'drydock_survey', 'page' => 'drydock_survey', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;
    @$id            = $vessel_details[0]['user_id'];

    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;
    //print_r($customer_details);

    @$relation_sl=$customer_details[0]['relation_sl'];
    if(@$relation_sl)
    {
      $agent_details       = $this->Survey_model->get_agent($relation_sl);
      $data['agent_details'] = $agent_details;
      $minor_details       = $this->Survey_model->get_minor($relation_sl);
      $data['minor_details'] = $minor_details;
    }
    //----------Vessel Details--------//
    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;
    $vessel_type_id=$vessel_details_viewpage[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_details_viewpage[0]['vessel_subtype_id'];
    $vessel_total_tonnage=$vessel_details_viewpage[0]['vessel_total_tonnage'];

    //----------Hull Details--------//
    $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id1);
    $data['hull_details']    = $hull_details;

    //----------Engine Details--------//
    $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id1);
    $data['engine_details']  = $engine_details;

    //----------Equipment Details--------//
    $equipment_details     =   $this->Survey_model->get_equipment_details_view($vessel_id,$survey_id1);
    $data['equipment_details'] = $equipment_details;

    $portofregistry            =   $this->Survey_model->get_portofregistry();
    $data['portofregistry']   =   $portofregistry;

    $bank                     =   $this->Survey_model->get_bank_favoring();
    $data['bank']             =   $bank;

    $form_id=0;
    $activity_id=3;

    $tariff_details   =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data['tariff_details'] = 	$tariff_details;

    $drydock_survey=$this->Survey_model->get_drydock_survey($vessel_id);
    $data['drydock_survey']  = $drydock_survey;

    $drydock_survey_done=$this->Survey_model->get_drydock_survey_done($vessel_id);
    $data['drydock_survey_done']  = $drydock_survey_done;

    $this->load->view('Kiv_views/template/form-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/drydock_survey', $data);
    $this->load->view('Kiv_views/template/form-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

function drydock_survey_entry()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'drydock_survey_entry', 'page' => 'drydock_survey_entry', 'errorCls' => NULL, 'post' => $this->input->post());
    $this->load->model('Kiv_models/Survey_model');
    $data       =  $data + $this->data;
    echo "1";
  }
}

function drydock_survey_payment()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data       =  array('title' => 'drydock_survey_payment', 'page' => 'drydock_survey_payment', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  

    if($this->input->post())
    {
      $vessel_id        = $this->security->xss_clean($this->input->post('hdn_vessel_id'));
      $processflow_sl   = $this->security->xss_clean($this->input->post('processflow_sl'));
      $status_details_sl= $this->security->xss_clean($this->input->post('status_details_sl'));

      $form_id=0;
      $activity_id=3;

      //_____________Tariff amount start___________________//
      $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
      $data['vessel_condition'] = $vessel_condition;
      if(!empty($vessel_condition))
      {
        $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
        $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
        $vessel_length1=$vessel_condition[0]['vessel_length'];
        $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
        $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
      }  
      $tariff_details   =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
      $data['tariff_details'] =   $tariff_details;

      if(!empty($tariff_details))
      {
        $tariff_tonnagetype_id=$tariff_details[0]['tariff_tonnagetype_id'];
        if($tariff_tonnagetype_id==1)
        {
          $tariff_amount=$tariff_details[0]['tariff_amount'];
        }
      }
      else
      {
        $tariff_amount=1;
      }
      //_____________Tariff amount end___________________//

      $portofregistry_sl    = $this->security->xss_clean($this->input->post('portofregistry_sl'));
      $bank_sl              = $this->security->xss_clean($this->input->post('bank_sl'));
      $status=1;

      $payment_user=  $this->Survey_model->get_payment_userdetails($sess_usr_id);
      $data['payment_user']     =   $payment_user;
      //print_r($payment_user);exit;
      if(!empty($payment_user))
      {
        $owner_name=$payment_user[0]['user_name'];
        $user_mobile_number=$payment_user[0]['user_mobile_number'];
        $user_email=$payment_user[0]['user_email'];
      }
      $formnumber=0;
      $survey_id        = 3;

      date_default_timezone_set("Asia/Kolkata");
      $ip         = $_SERVER['REMOTE_ADDR'];
      $date       =   date('Y-m-d h:i:s', time());
      $newDate    =   date("Y-m-d");
      $status_change_date=$date;

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
        $process_id=3;
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
        $ref_number                   = "DDS"."_".$value."_".$vessel_id.$yr;

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
          $bank_transaction_id     =    $this->db->insert_id();
          $update_bank             =    $this->Survey_model->update_bank('kiv_bank_master',$bank_data, $bank_sl);

          $online_payment_data         =   $this->Survey_model->get_online_payment_data($portofregistry_sl,$bank_sl);
          $data['online_payment_data']= $online_payment_data;

          $payment_user1              =  $this->Survey_model->get_payment_userdetails($sess_usr_id);
          $data['payment_user1']     =  $payment_user1;

          $requested_transaction_details=  $this->Survey_model->get_bank_transaction_request($bank_transaction_id);
          $data['requested_transaction_details']  =   $requested_transaction_details;
          //$data['amount_tobe_pay']=$tariff_amount;//remove comment before uploaded to server
          $data['amount_tobe_pay']=1;

          $data      =  $data+ $this->data;

          if(!empty($online_payment_data))
          { 
            $this->load->view('Kiv_views/Hdfc/hdfc_drydocksurvey_request',$data);
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
        redirect('Kiv_Ctrl/Survey/SurveyHome');
      }
    }
  }
}

public function Verify_payment_pc_drydock()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id = $this->session->userdata('customer_id');
  $survey_user_id= $this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data   =  array('title' => 'Verify_payment_pc_drydock', 'page' => 'Verify_payment_pc_drydock', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;

    @$id            = $vessel_details[0]['user_id'];

    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;
    $owner_name         = $customer_details[0]['user_name'];
    $user_mobile_number = $customer_details[0]['user_mobile_number'];
    $user_email         = $customer_details[0]['user_email'];


    $current_status       = $this->Survey_model->get_status();
    $data['current_status']   = $current_status;

    $form_number        = $this->Survey_model->get_form_number($vessel_id);
    $data['form_number']    = $form_number;
    if(!empty($form_number))
    {
      $form_id=$form_number[0]['form_no'];
    }
    else
    {
      $form_id=0;
    }

    //----------Vessel Details--------//
    $vessel_details_viewpage =  $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;
    $vessel_name            = $vessel_details_viewpage[0]['vessel_name'];

    //----------Payment Details--------//
    $payment_details =  $this->Survey_model->get_form_payment_details($vessel_id,$survey_id,$form_id);
    $data['payment_details']= $payment_details;
    $portofregistry_sl= $payment_details[0]['portofregistry_id'];
    $dd_amount        = $payment_details[0]['dd_amount'];
    //get port of registry name
    $registry_port_id             =   $this->Survey_model->get_registry_port_id($portofregistry_sl);
    $data['registry_port_id']     =   $registry_port_id;

    if(!empty($registry_port_id))
    {
      $port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
    }
    else
    {
      $port_of_registry_name="";
    }
    /*________________GET reference number start-initial survey___________________*/
    $ref_process_id=3;
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
    /*________________GET reference number end-initial survey___________________*/

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
      $user_sl_cs_sr    = $this->security->xss_clean($this->input->post('user_sl_cs'));
      $status       = 1;

      $status_details_sl= $this->security->xss_clean($this->input->post('status_details_sl'));
      $payment_sl   = $this->security->xss_clean($this->input->post('payment_sl'));
      $payment_approved_remarks = $this->security->xss_clean($this->input->post('remarks'));

      $date               =   date('Y-m-d h:i:s', time());
      $ip             = $_SERVER['REMOTE_ADDR'];
      $status_change_date = $date;

      if($process_id==26)
      {
        $data_payment=array(
        'payment_approved_status' =>1,
        'payment_approved_user_id' =>$sess_usr_id,
        'payment_approved_datetime' =>$status_change_date,
        'payment_approved_ipaddress' =>$ip,
        'payment_approved_remarks' =>$payment_approved_remarks);


        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>2,
        'current_position'=>$current_position,
        'user_id'=>$user_sl_cs_sr,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);

        $data_survey_status=array(
        'current_status_id'=>2,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_sl_cs_sr);

        $payment_update=$this->Survey_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

        $processflow_id_surveyactivity    =   $this->db->insert_id();

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        //_____________________________Email sending start_____________________________//
        $email_subject="Payment for drydock survey of ".$vessel_name." is verified";
        $email_message="<div><h4>Dear ". $owner_name.",</h4><p>Your payment of Rs. <b>".$dd_amount."</b> towards drydock survey submission of <b>".$vessel_name."</b> has been verified. Form  is forwarded to Chief Surveyor.  <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Drydock Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.<br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
        $saji_email="bssajitha@gmail.com";
        $this->emailSendFunction($saji_email,$email_subject,$email_message);
        //$this->emailSendFunction($user_email,$email_subject,$email_message);
        //___________________Email sending start___________________________________________//
        //____________________SMS sending start____________________________________________//
        $sms_message="Payment for drydock survey of ".$vessel_name." is verified, and forwarded to Chief Surveyor";
        $this->load->model('Kiv_models/Survey_model');
        $saji_mob="9847903241";
        //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
        //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
        //____________________SMS sending end________________________________________________//
        if($payment_update && $process_update && $process_insert && $status_update)
        {
          redirect("Kiv_Ctrl/Survey/pcHome"."/".$modidenc);
        }
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_payment_pc_drydock',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}


public function drydock_application()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $survey_id1=1;
  if(!empty($sess_usr_id))
  {
    $data   =  array('title' => 'drydock_application', 'page' => 'drydock_application', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;
    @$id            = $vessel_details[0]['user_id'];
    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;

    @$relation_sl=$customer_details[0]['relation_sl'];
    if(@$relation_sl)
    {
      $agent_details       = $this->Survey_model->get_agent($relation_sl);
      $data['agent_details'] = $agent_details;
      $minor_details       = $this->Survey_model->get_minor($relation_sl);
      $data['minor_details'] = $minor_details;
    }
    //----------Vessel Details--------//
    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;
    $vessel_type_id=$vessel_details_viewpage[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_details_viewpage[0]['vessel_subtype_id'];
    $vessel_total_tonnage=$vessel_details_viewpage[0]['vessel_total_tonnage'];

    //----------Hull Details--------//
    $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id1);
    $data['hull_details']    = $hull_details;

    //----------Engine Details--------//
    $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id1);
    $data['engine_details']  = $engine_details;

    //----------Equipment Details--------//
    $equipment_details     =   $this->Survey_model->get_equipment_details_view($vessel_id,$survey_id1);
    $data['equipment_details'] = $equipment_details;

    $portofregistry            =   $this->Survey_model->get_portofregistry();
    $data['portofregistry']   =   $portofregistry;

    $form_id=0;
    $activity_id=3;

    $tariff_details   =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data['tariff_details'] =   $tariff_details;

    $surveyor_details          =   $this->Survey_model->get_surveyor_details();
    $data['surveyor_details']      = $surveyor_details;

    $drydock_survey=$this->Survey_model->get_drydock_survey($vessel_id);
    $data['drydock_survey']  = $drydock_survey;

    $drydock_survey_done=$this->Survey_model->get_drydock_survey_done($vessel_id);
    $data['drydock_survey_done']  = $drydock_survey_done;

    $this->load->view('Kiv_views/template/form-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/drydock_application', $data);
    $this->load->view('Kiv_views/template/form-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

function drydock_forward_sr()
  {
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data   =  array('title' => 'drydock_forward_sr', 'page' => 'drydock_forward_sr', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    //4 - revert,5 - approved form 4 intimation send,6 - forward to surveyor
    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date         =   date('Y-m-d h:i:s', time());
      $status_change_date = $date;
      $remarks_date   = date('Y-m-d');

      $process_id     = $this->security->xss_clean($this->input->post('process_id')); 
      $owner_user_id    = $this->security->xss_clean($this->input->post('owner_user_id')); 
      $owner_user_type_id = $this->security->xss_clean($this->input->post('owner_user_type_id')); 
      $current_status_id  = 6; 
      $forward_to     = $this->security->xss_clean($this->input->post('forward_to'));  //surveyor user id
      $remarks      = $this->security->xss_clean($this->input->post('remarks')); 
      $vessel_id      = $this->security->xss_clean($this->input->post('hdn_vessel_id')); 
      $processflow_sl   = $this->security->xss_clean($this->input->post('hdn_processflow_id')); 
      $survey_id      = $this->security->xss_clean($this->input->post('hdn_survey_id')); 
      $status_details_sl  = $this->security->xss_clean($this->input->post('status_details_sl')); 
      $status=1;

      //___________________Approve and forward to Surveyor______________________________//
      if($current_status_id==6)
      {
        //Approve Form 2
        /*  $data_insert=array(
        'vessel_id'     =>  $vessel_id,
        'process_id'    =>  $process_id,
        'survey_id'     =>  $survey_id,
        'current_status_id' =>  5,
        'current_position'  =>  $user_type_id,
        'user_id'     =>  $sess_usr_id,
        'previous_module_id'=>  $processflow_sl,
        'status'      =>  0,
        'status_change_date'=>  $status_change_date
        );
        */
        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        // $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

        $processflow_id     =   $this->db->insert_id();

        $data_remarks = array(
        'sending_user_id'     =>  $processflow_sl,
        'receiving_user_id'   =>  $processflow_id,
        'process_id'      =>  $process_id,
        'remarks_date'      =>  $remarks_date,
        'remarks'       =>  $remarks,
        'entry_timestamp'   =>  $date);
        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

        //Forward Survey Activity
        $data_insert_surveyactivity=array(
        'vessel_id'     =>  $vessel_id,
        'process_id'    =>  $process_id,
        'survey_id'     =>  $survey_id,
        'current_status_id' =>  2,
        'current_position'  =>  13,
        'user_id'     =>  $forward_to,
        'previous_module_id'=>  $processflow_sl,
        'status'      =>  $status,
        'status_change_date'=>  $status_change_date);

        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);

        $processflow_id_surveyactivity    =   $this->db->insert_id();

        $data_remarks_surveyactivity = array(
        'sending_user_id'   =>  $processflow_sl,
        'receiving_user_id' =>  $processflow_id_surveyactivity,
        'process_id'    =>  $process_id,
        'remarks_date'    =>  $remarks_date,
        'remarks'     =>  $remarks,
        'entry_timestamp' =>  $date);

        $data_survey_status=array(
        'process_id'     => $process_id, 
        'current_status_id'  => $current_status_id,
        'sending_user_id'  => $sess_usr_id,
        'receiving_user_id'  => $forward_to);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        $remarks_insert_surveyactivity=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks_surveyactivity);
        if($process_update && $remarks_insert && $process_insert_surveyactivity && $remarks_insert_surveyactivity)
        {
          redirect("Kiv_Ctrl/Survey/csHome");
        }
      } 
    }
  }
}
public function drydock_survey_sr()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  $survey_id1=1;

  if(!empty($sess_usr_id))
  {
    $data   =  array('title' => 'drydock_survey_sr', 'page' => 'drydock_survey_sr', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;
    @$id            = $vessel_details[0]['user_id'];
    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;

    @$relation_sl=$customer_details[0]['relation_sl'];
    if(@$relation_sl)
    {
      $agent_details       = $this->Survey_model->get_agent($relation_sl);
      $data['agent_details'] = $agent_details;
      $minor_details       = $this->Survey_model->get_minor($relation_sl);
      $data['minor_details'] = $minor_details;
    }
    //---------Vessel Details--------//
    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;
    $vessel_type_id=$vessel_details_viewpage[0]['vessel_type_id'];
    $vessel_subtype_id=$vessel_details_viewpage[0]['vessel_subtype_id'];
    $vessel_total_tonnage=$vessel_details_viewpage[0]['vessel_total_tonnage'];

    //----------Hull Details--------//
    $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id1);
    $data['hull_details']    = $hull_details;

    //----------Engine Details--------//
    $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id1);
    $data['engine_details']  = $engine_details;

    //----------Equipment Details--------//
    $equipment_details     =   $this->Survey_model->get_equipment_details_view($vessel_id,$survey_id1);
    $data['equipment_details'] = $equipment_details;

    $portofregistry            =   $this->Survey_model->get_portofregistry();
    $data['portofregistry']   =   $portofregistry;

    $form_id=0;
    $activity_id=3;

    $tariff_details   =   $this->Survey_model->get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id);
    $data['tariff_details'] =   $tariff_details;

    $drydock_survey=$this->Survey_model->get_drydock_survey($vessel_id);
    $data['drydock_survey']  = $drydock_survey;

    $drydock_survey_done=$this->Survey_model->get_drydock_survey_done($vessel_id);
    $data['drydock_survey_done']  = $drydock_survey_done;

    $this->load->view('Kiv_views/template/form-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/drydock_survey_sr', $data);
    $this->load->view('Kiv_views/template/form-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

function drydock_forward_owner()
{   
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data   =  array('title' => 'drydock_forward_sr', 'page' => 'drydock_forward_sr', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    //4 - revert,5 - approved form 4 intimation send,6 - forward to surveyor
    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date         =   date('Y-m-d h:i:s', time());
      $status_change_date = $date;
      $remarks_date   = date('Y-m-d');

      $process_id     = $this->security->xss_clean($this->input->post('process_id')); 
      $owner_user_id    = $this->security->xss_clean($this->input->post('owner_user_id')); 
      $owner_user_type_id = $this->security->xss_clean($this->input->post('owner_user_type_id')); 
      $current_status_id  = 5; 
      $forward_to     = $this->security->xss_clean($this->input->post('forward_to'));  //surveyor user id
      $remarks      = $this->security->xss_clean($this->input->post('remarks')); 
      $vessel_id      = $this->security->xss_clean($this->input->post('hdn_vessel_id')); 
      $processflow_sl   = $this->security->xss_clean($this->input->post('hdn_processflow_id')); 
      $survey_id      = $this->security->xss_clean($this->input->post('hdn_survey_id')); 
      $status_details_sl  = $this->security->xss_clean($this->input->post('status_details_sl')); 
      $status=1;
      //____________________Approve form 2 and send form 4 intimation______________________________//
      if($current_status_id==5) 
      { 
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$user_type_id,
        'user_id'=>$sess_usr_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>0,
        'status_change_date'=>$status_change_date);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $processflow_id     =   $this->db->insert_id();

        $data_update = array('status'=>0);
        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $data_insert_surveyactivity=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>2,
        'current_position'=>$owner_user_type_id,
        'user_id'=>$owner_user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_remarks = array(
        'sending_user_id' => $processflow_sl,
        'receiving_user_id'=> $processflow_id,
        'process_id'=>$process_id,
        'remarks_date'=> $remarks_date,
        'remarks'=>$remarks,
        'entry_timestamp'=>$date);

        $process_insert_surveyactivity=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_surveyactivity);

        $processflow_id_surveyactivity    =   $this->db->insert_id();

        $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

        $data_survey_status=array(
        'process_id'    =>$process_id,
        'current_status_id' =>2,
        'sending_user_id' =>$sess_usr_id,
        'receiving_user_id' =>$owner_user_id);
        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        if($process_update && $process_insert && $remarks_insert  &&  $status_update)
        {
          redirect("Kiv_Ctrl/Survey/csform4/".$vessel_id."/".$processflow_id_surveyactivity."/".$survey_id);
        }
        else
        {
          redirect('Main_login/index');
        }
      }  //___________________________________________________//
    }
  }
}

public function drydock_confirmation()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'drydock_confirmation', 'page' => 'drydock_confirmation', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  

    $vessel_details			= 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']	=	$vessel_details;
    $data 			=	 $data + $this->data;

    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date                  	= 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	=	$this->security->xss_clean($this->input->post('current_status_id'));
      $current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $status_change_date =	$date;
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $status 			=	1;
      $status_details_sl=	$this->security->xss_clean($this->input->post('status_details_sl'));

      if($process_id==26)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$current_position,
        'user_id'=>$user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);

        $data_survey_status=array(
        'current_status_id'=>$current_status_id,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_id);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

        if($process_update && $process_insert && $status_update)
        {
          redirect("Kiv_Ctrl/Survey/SurveyHome");
        }
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/drydock_confirmation',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function drydock_approval_sr()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);
  $processflow_sl1 	=	$this->uri->segment(5);
  $survey_id1 		=	$this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'drydock_approval_sr', 'page' => 'drydock_approval_sr', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  

    $vessel_details			= 	$this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']	=	$vessel_details;

    $drydock_survey=$this->Survey_model->get_drydock_survey($vessel_id);
    $data['drydock_survey']  = $drydock_survey;

    $drydock_survey_done=$this->Survey_model->get_drydock_survey_done($vessel_id);
    $data['drydock_survey_done']  = $drydock_survey_done;
       
    if($this->input->post())
    {
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $current_status_id 	=	5;
      $current_position 	=	$this->security->xss_clean($this->input->post('current_position')); 
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $status 			=	1;
      $status_details_sl=	$this->security->xss_clean($this->input->post('status_details_sl'));
      $status 			=	1;
      $recommendation= $this->security->xss_clean($this->input->post('drydock_recommendation'));

      $timeline_sl 			=	$this->security->xss_clean($this->input->post('timeline_sl'));
      $vessel_registration_number=$this->security->xss_clean($this->input->post('vessel_registration_number'));
      $vessel_survey_number =	$this->security->xss_clean($this->input->post('vessel_survey_number'));
      //----------Vessel Details--------//
      $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
      $data['vessel_details_viewpage'] = $vessel_details_viewpage;
      $vessel_name              = $vessel_details_viewpage[0]['vessel_name'];
      $portofregistry_sl        = $vessel_details_viewpage[0]['vessel_registry_port_id'];
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
      @$id=$vessel_details_viewpage[0]['user_id'];
      //-----------Get customer name and address--------------//
      $customer_details=$this->Survey_model->get_customer_details($id);
      $data['customer_details']=$customer_details;
      $owner_name         = $customer_details[0]['user_name'];
      $user_mobile_number = $customer_details[0]['user_mobile_number'];
      $user_email         = $customer_details[0]['user_email'];
         
      $ip=	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date                  	= 	date('Y-m-d h:i:s', time());
      $status_change_date 	=	$date;

      /*___________________________update reference number start____________________________*/
      $nprocess_id=3;
      $ref_number_details     =   $this->Survey_model->get_ref_number_details($vessel_id,$nprocess_id);
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
      $ref_process_id=3;
      
      $ref_number_details_forms     =   $this->Survey_model->get_ref_number_details_forms($vessel_id,$ref_process_id);
      $data['ref_number_details_forms'] =   $ref_number_details_forms;

      if(!empty($ref_number_details_forms))
      {
        $ref_number_forms       = $ref_number_details_forms[0]['ref_number'];
      }
      else
      {
        $ref_number_forms =   "";
      }


      $date_of_survey      		=date('Y-m-d');
      $adding_one_year 			= date('d-m-Y', strtotime($date_of_survey . "1 year") );
      $adding_five_year 			= date('d-m-Y', strtotime($date_of_survey . "5 year") );
      //$annual_survey_date        	= date("Y-m-d", strtotime($adding_one_year));
      $drydock_survey_date        = date("Y-m-d", strtotime($adding_five_year));
      $date_of_survey3        =date('d-m-Y');

      $timeline_data_annual = array('vessel_id' =>$vessel_id ,
      'survey_number' => $vessel_survey_number,
      'registration_number' => $vessel_registration_number,
      'process_id' => 1,
      'subprocess_id' => 3,
      'scheduled_date' => $drydock_survey_date,
      'status' => 0,
      'link_id' => $timeline_sl,
      'timeline_created_user_id' => $sess_usr_id,
      'timeline_created_timestamp' =>$date,
      'timeline_created_ipaddress' => $ip);

      $insert_timeline_annual=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_annual);
      $new_timeline_id= $this->db->insert_id();

      $data_vessel =  array(
      'drydock_recommendation' => $recommendation);
      $update_vessel    = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vessel_id);

      $timeline_date_update=array('actual_date' =>$date_of_survey,
      'status' => 1,
      'timeline_modified_user_id' => $sess_usr_id,
      'timeline_modified_timestamp' =>$date,
      'timeline_modified_ipaddress' => $ip);

      $data_main=array('processing_status'=>0,
      'vesselmain_drydock_id'=>1,
      'vesselmain_drydock_date'=>$date_of_survey,
      'vesselmain_drydock_status'=>'1'); 

      $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);
      $update_timeline		=	$this->Survey_model->update_tbl_kiv_vessel_timeline('tbl_kiv_vessel_timeline',$timeline_date_update,$timeline_sl);
      $arr_link= array('link_id' => $timeline_sl);
      $update_link    = $this->Survey_model->update_tbl_kiv_vessel_timeline('tbl_kiv_vessel_timeline',$arr_link,$new_timeline_id);

      $next_process_id=27;
      if($process_id==26)
      {
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$next_process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$current_position,
        'user_id'=>$user_id,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);

        $data_survey_status=array(
        'process_id'=>$next_process_id,
        'current_status_id'=>$current_status_id,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_id);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        //_____________________________Email sending start_____________________________//
        $email_subject="Drydock Certificate for ".$vessel_name." is ready for delivery";
        $email_message="<div><h4>Dear ". $owner_name.",</h4><p>Drydock Certifictate is generated for <b>".$vessel_name."</b>. Drydock Certifictate can be downloaded by login to portinfo.kerala.gov.in under the menu Survey Certificate.<br>
        Survey number for <b>".$vessel_name."</b> vessel is : <b>".$vessel_survey_number."</b> <br>
        Drydock date : <b>".$date_of_survey3."</b><br>
        Next drydock date is on : <b>".$adding_five_year."</b><br>
        <br>Please note the reference number : <b>".$ref_number_forms."</b> for future reference with respect to Initial survey. This reference number will be until Drydock Certifictate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Surveyor<br><br>Kerala Maritime Board <br></p><hr></div>";
        $saji_email="bssajitha@gmail.com";
        $this->emailSendFunction($saji_email,$email_subject,$email_message);
        //$this->emailSendFunction($user_email,$email_subject,$email_message);
        //___________________Email sending start___________________________________________//
        //____________________SMS sending start____________________________________________//
        $sms_message="Drydock Certifictate is generated for ".$vessel_name.". Drydock Certifictate can be downloaded from portinfo.kerala.gov.in.";
        $this->load->model('Kiv_models/Survey_model');
        $saji_mob="9847903241";
        //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
        //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
        //____________________SMS sending end________________________________________________//


        if($process_update && $process_insert && $status_update)
        {
          redirect("Kiv_Ctrl/Survey/SurveyorHome");
        }
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/drydock_approval_sr',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');
  }
}

//_______________________DRYDOCK SURVEY END________________________________//

public function initialsurvey_done()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'initialsurvey_done', 'page' => 'initialsurvey_done', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  
    $process_id=1;
    $initial_survey_id=1;
    /*$annual_survey_id=2;
    $drydock_survey_id=3;*/

    $sdate=date('Y-m-d', strtotime('-30 days'));
    $edate=date('Y-m-d');

    if($this->input->post())
    {
      $day="";
      $data['day']=$day;
      $from_date       = $this->security->xss_clean($this->input->post('from_date'));
      $to_date         = $this->security->xss_clean($this->input->post('to_date'));

    if($user_type_id=='11')
    {
      $initial_survey_done=$this->Survey_model->get_survey_done_owner($process_id,$initial_survey_id,$sess_usr_id,$from_date,$to_date);
      $data['initial_survey_done']  = $initial_survey_done;
    }
    else
    {
      $initial_survey_done=$this->Survey_model->get_survey_done($process_id,$initial_survey_id,$from_date,$to_date);
      $data['initial_survey_done']  = $initial_survey_done;
    }

    }

   else
    {
      $day="30";
      $data['day']=$day;
      if($user_type_id=='11')
      {
        //$initial_survey_done=$this->Survey_model->get_survey_done_owner_ndate($process_id,$initial_survey_id,$sess_usr_id);
        $initial_survey_done=$this->Survey_model->get_survey_done_owner($process_id,$initial_survey_id,$sess_usr_id,$sdate,$edate);
        $data['initial_survey_done']  = $initial_survey_done;
      }
      else
      {
        //$initial_survey_done=$this->Survey_model->get_survey_done_ndate($process_id,$initial_survey_id);
         $initial_survey_done=$this->Survey_model->get_survey_done($process_id,$initial_survey_id,$sdate,$edate);
        $data['initial_survey_done']  = $initial_survey_done;
      }
    }
   
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/initialsurvey_done',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}	

public function annualsurvey_done()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'annualsurvey_done', 'page' => 'annualsurvey_done', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');  
    $process_id=1;
    $annual_survey_id=2;
    $sdate=date('Y-m-d', strtotime('-30 days'));
    $edate=date('Y-m-d');
    if($this->input->post())
    {
      $day="";
      $data['day']=$day;
      $from_date       = $this->security->xss_clean($this->input->post('from_date'));
      $to_date         = $this->security->xss_clean($this->input->post('to_date'));

    if($user_type_id=='11')
    {
      $annual_survey_done=$this->Survey_model->get_survey_done_owner($process_id,$annual_survey_id,$sess_usr_id,$from_date,$to_date);
      $data['annual_survey_done']  = $annual_survey_done;
    }
    else
    {
      $annual_survey_done=$this->Survey_model->get_survey_done($process_id,$annual_survey_id,$from_date,$to_date);
      $data['annual_survey_done']  = $annual_survey_done;
    }
  }
  else
  {
    $day="30";
    $data['day']=$day;
    if($user_type_id=='11')
    {
      $annual_survey_done=$this->Survey_model->get_survey_done_owner($process_id,$annual_survey_id,$sess_usr_id,$sdate,$edate);
      $data['annual_survey_done']  = $annual_survey_done;
    }
    else
    {
      $annual_survey_done=$this->Survey_model->get_survey_done($process_id,$annual_survey_id,$sdate,$edate);
      $data['annual_survey_done']  = $annual_survey_done;
    }
  }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/annualsurvey_done',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}	

public function drydocksurvey_done()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'drydocksurvey_done', 'page' => 'drydocksurvey_done', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $process_id=1;
    $drydock_survey_id=3;
    $sdate=date('Y-m-d', strtotime('-30 days'));
    $edate=date('Y-m-d');
    if($this->input->post())
    {
      $day="";
      $data['day']=$day;
      $from_date       = $this->security->xss_clean($this->input->post('from_date'));
      $to_date         = $this->security->xss_clean($this->input->post('to_date'));
    if($user_type_id=='11')
    {
      $drydock_survey_done=$this->Survey_model->get_survey_done_owner($process_id,$drydock_survey_id,$sess_usr_id,$from_date,$to_date);
      $data['drydock_survey_done']  = $drydock_survey_done;
    }
    else
    {
      $drydock_survey_done=$this->Survey_model->get_survey_done($process_id,$drydock_survey_id,$from_date,$to_date);
      $data['drydock_survey_done']  = $drydock_survey_done;
    }
  }
  else
  {
    $day="30";
    $data['day']=$day;
    if($user_type_id=='11')
    {
      $drydock_survey_done=$this->Survey_model->get_survey_done_owner($process_id,$drydock_survey_id,$sess_usr_id,$sdate,$edate);
      $data['drydock_survey_done']  = $drydock_survey_done;
    }
    else
    {
      $drydock_survey_done=$this->Survey_model->get_survey_done($process_id,$drydock_survey_id,$sdate,$edate);
      $data['drydock_survey_done']  = $drydock_survey_done;
    }
  }


    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/drydocksurvey_done',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}	

public function specialsurvey_done()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');
  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'specialsurvey_done', 'page' => 'specialsurvey_done', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $process_id=1;
    //	$special_survey_id=4;
    if($this->input->post())
    {
      $from_date       = $this->security->xss_clean($this->input->post('from_date'));
      $to_date         = $this->security->xss_clean($this->input->post('to_date'));
      if($user_type_id=='11')
      {
        $special_survey_done=$this->Survey_model->get_specialsurvey_done_owner($process_id,$sess_usr_id,$from_date,$to_date);
        $data['special_survey_done']  = $special_survey_done;
      }
      else
      {
        $special_survey_done=$this->Survey_model->get_specialsurvey_done($process_id,$from_date,$to_date);
        $data['special_survey_done']  = $special_survey_done;
      }
    } 
    else
    {
       if($user_type_id=='11')
      {
        $special_survey_done=$this->Survey_model->get_specialsurvey_done_owner_ndate($process_id,$sess_usr_id);
        $data['special_survey_done']  = $special_survey_done;
      }
      else
      {
        $special_survey_done=$this->Survey_model->get_specialsurvey_done_ndate($process_id);
        $data['special_survey_done']  = $special_survey_done;
      }
    }

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/specialsurvey_done',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');
  }
}	

public function form9_certificate()
{
  $vessel_id1 		=	$this->uri->segment(4);
  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $this->load->library('Pdf.php');
  $pdf 		= 	$this->pdf->load();
  $pdf->allow_charset_conversion=true;  // Set by default to TRUE
  $pdf->charset_in='UTF-8';
  $pdf->autoLangToFont = true;

  $pdf->showImageErrors = true;
  ini_set('memory_limit', '256M');
  $pdfFilePath = "form9_certificate_".$vessel_id.".pdf";   
  $html = $this->load->view('Kiv_views/dash/form9_certificate_view',$vessel_id,true);
  $output=$pdf->WriteHTML($html);
  $pdf->Output($output.$pdfFilePath, 'I');
  exit(); 
}

public function form10_certificate()
{
  $vessel_id1 		=	$this->uri->segment(4);
  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 
  $this->load->library('Pdf.php');
  $pdf = 	$this->pdf->load();
  $pdf->allow_charset_conversion=true;  
  $pdf->charset_in='UTF-8';
  $pdf->autoLangToFont = true;
  $pdf->showImageErrors = true;
  ini_set('memory_limit', '256M');
  $pdfFilePath = "form10_certificate_".$vessel_id.".pdf";   
  $html = $this->load->view('Kiv_views/dash/form10_certificate_view',$vessel_id,true);
  //echo $html;
  //exit;
  $output=$pdf->WriteHTML($html);
  $pdf->Output($output.$pdfFilePath, 'I');
  exit(); 



}

public function drydocksurvey_certificate()
{
  $vessel_id1 		=	$this->uri->segment(4);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $this->load->library('Pdf.php');
  $pdf = 	$this->pdf->load();
  $pdf->allow_charset_conversion=true;  // Set by default to TRUE
  $pdf->charset_in='UTF-8';
  $pdf->autoLangToFont = true;

  $pdf->showImageErrors = true;
  ini_set('memory_limit', '256M');

  $pdfFilePath = "drydocksurvey_certificate".$vessel_id.".pdf";   
  $html = $this->load->view('Kiv_views/dash/drydocksurvey_certificate',$vessel_id,true);
  $output=$pdf->WriteHTML($html);
  $pdf->Output($output.$pdfFilePath, 'I');
  exit(); 
}

public function vessels_view()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  $vessel_id1     = $this->uri->segment(4);
  $processflow_sl1   = $this->uri->segment(5);
  $survey_id1    = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'vessels_view', 'page' => 'vessels_view', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details_viewpage          =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']  =  $vessel_details_viewpage;
    //print_r($vessel_details_viewpage);

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/vessels_view',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');
  }
}


public function vessels_view_owner()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'vessels_view_owner', 'page' => 'vessels_view_owner', 'errorCls' => NULL, 'post' => $this->input->post());

    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details			= 	$this->Survey_model->get_vessel_details_owner($sess_usr_id);
    $data['vessel_details']	=	$vessel_details;

    /* $vessel_details      =   $this->Survey_model->get_vessel_details_owner_id($sess_usr_id);
    $data['vessel_details'] = $vessel_details;*/
    /* $vessel_details          = $this->Survey_model->get_bookofregistration_list_owner($sess_usr_id);
    $data['vessel_details']  = $vessel_details;*/
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/vessels_view_owner',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');
  }
}

function show_vessel($regnum1)
{
  $regnum2=str_replace(array('~'), array('='), $regnum1);
  $regnum=base64_decode($regnum2);
  $this->load->model('Kiv_models/Survey_model');
  $data['regnum']	=	$regnum; 
  $vessel_details			= 	$this->Survey_model->get_vessel_details_regnum($regnum);
  $data['vessel_details'] =	$vessel_details;
  /*$vessel_sl=$vessel_details[0]['vessel_sl'];
  $data['vessel_id']  = $vessel_sl; */
  $data 					= 	$data + $this->data;		
  $this->load->view('Kiv_views/Ajax_show_vessel.php', $data);
}
function show_track_vessel($regnum1)
{
  $regnum2=str_replace(array('~'), array('='), $regnum1);
  $regnum=base64_decode($regnum2);
  $this->load->model('Kiv_models/Survey_model');
  $data['regnum'] = $regnum; 
  $vessel_details     =   $this->Survey_model->get_vessel_details_regnum($regnum);
  $data['vessel_details'] = $vessel_details;
  /*$vessel_sl=$vessel_details[0]['vessel_sl'];
  $data['vessel_id']  = $vessel_sl; */
  $data           =   $data + $this->data;    
  $this->load->view('Kiv_views/Ajax_show_track_vessel.php', $data);
}
function show_track_ref_number($ref_number)
{
  $this->load->model('Kiv_models/Survey_model');
  $data['ref_number'] = $ref_number; 
  $refnumber_details     =   $this->Survey_model->get_vessel_details_refnumer($ref_number);
  $data['refnumber_details'] = $refnumber_details;
  $data           =   $data + $this->data;    
  $this->load->view('Kiv_views/Ajax_show_track_refnumber.php', $data);
}

function request_specialsurvey()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  $vessel_id1 		=	$this->uri->segment(4);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'request_specialsurvey', 'page' => 'request_specialsurvey', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    //if($this->input->post())
    //{
    $ip 					=	$_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date                  	= 	date('Y-m-d h:i:s', time());
    $status_change_date 	=	$date;

    $status_details			= 	$this->Survey_model->get_status_details_vessel_sl($vessel_id);
    $data['status_details'] =	$status_details;

    if(!empty($status_details))
    {
      $status_details_sl 	= 	$status_details[0]['status_details_sl'];
      $process_id 		= 	$status_details[0]['process_id'];
      $survey_id 			= 	$status_details[0]['survey_id'];
      $current_status_id 	=	$status_details[0]['current_status_id'];
    }
    $processflow			= 	$this->Survey_model->get_processflow_vessel($vessel_id);
    $data['processflow'] 	=	$processflow;

    if(!empty($processflow))
    {
      $processflow_sl 	= 	$processflow[0]['processflow_sl'];
    }
    $status 				=	1;
    $usertype_master			= 	$this->Survey_model->get_user_id_cs(12);
    $data['usertype_master'] 	=	$usertype_master;
    if(!empty($usertype_master))
    {
      $user_id_cs=$usertype_master[0]['user_master_id'];
      $user_type_id_cs=$usertype_master[0]['user_master_id_user_type'];
    }
    $process_id_new=28;
    $survey_id4=4;

    $data_insert=array(
    'vessel_id'			=>	$vessel_id,
    'process_id'		=>	$process_id_new,
    'survey_id'			=>	$survey_id4,
    'current_status_id'	=>	1,
    'current_position'	=>	$user_type_id_cs,
    'user_id'			=>	$user_id_cs,
    'previous_module_id'=>	$processflow_sl,
    'status'			=>	1,
    'status_change_date'=>	$status_change_date);

    $data_update = array('status'=>0);

    $data_survey_status = array(
    'process_id' => $process_id_new,
    'survey_id'     =>  $survey_id4,
    'current_status_id' => 1,
    'sending_user_id' => $sess_usr_id,
    'receiving_user_id' => $user_id_cs);

    $data_main=array('processing_status'=>1);   
    $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);
    $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

    $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
    $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
    if($process_update && $process_insert && $status_update && $process_update_main)
    {
      redirect("Kiv_Ctrl/Survey/SurveyHome");
    }
  }
}



function initiate_specialsurvey()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id	=	$this->session->userdata('customer_id');
  $survey_user_id	=	$this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  {
    $data 			=	 array('title' => 'initiate_specialsurvey', 'page' => 'initiate_specialsurvey', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    if($this->input->post())
    {
      date_default_timezone_set("Asia/Kolkata");
      $date               = 	date('Y-m-d h:i:s', time());
      $vessel_id 			=	$this->security->xss_clean($this->input->post('vessel_id'));	
      $process_id 		=	$this->security->xss_clean($this->input->post('process_id')); 
      $survey_id 			=	$this->security->xss_clean($this->input->post('survey_id'));
      $processflow_sl		=	$this->security->xss_clean($this->input->post('processflow_sl'));
      $user_id 			=	$this->security->xss_clean($this->input->post('user_id'));
      $user_type_id 		=	$this->security->xss_clean($this->input->post('user_type_id'));
      $status 			=	1;
      $remarks 			=	$this->security->xss_clean($this->input->post('remarks'));
      $status_details_sl 	=	$this->security->xss_clean($this->input->post('status_details_sl'));


      $survey_id_assign 	=	$this->security->xss_clean($this->input->post('survey_id_assign'));
      if($survey_id_assign==2)
      {
        $new_process_id=29;
      }
      if($survey_id_assign==3)
      {
        $new_process_id=30;
      }


      $ip 	=	$_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date   = 	date('Y-m-d h:i:s', time());
      $status_change_date 	=	$date;
      $remarks_date		=	date('Y-m-d');


      $vessel=$this->Survey_model->get_vessel($vessel_id);
      $data['vessel']  = $vessel;
      if(!empty($vessel))
      {
        $vessel_survey_number=$vessel[0]['vessel_survey_number'];
        $vessel_registration_number=$vessel[0]['vessel_registration_number'];
      }


      $survey=$this->Survey_model->get_next_survey_process($vessel_id,$survey_id_assign);
      $data['survey']  = $survey;
      if(!empty($survey))
      {
        $timeline_sl=$survey[0]['timeline_sl'];
      }

      $arr_link= array('link_id' => $timeline_sl);

      $data_update_timeline=array(
      'timeline_modified_user_id'=>$sess_usr_id,
      'timeline_modified_timestamp'=>$date,
      'timeline_modified_ipaddress'=>$ip,
      'delete_status'=>1);

      $timeline_data_annual = array('vessel_id' =>$vessel_id ,
      'survey_number' => $vessel_survey_number,
      'registration_number' => $vessel_registration_number,
      'process_id' => 1,
      'subprocess_id' => $survey_id_assign,
      'special_survey_status'=>1,
      'scheduled_date' => $status_change_date,
      'status' => 0,
      'link_id' => $timeline_sl,
      'timeline_created_user_id' => $sess_usr_id,
      'timeline_created_timestamp' =>$date,
      'timeline_created_ipaddress' => $ip);

      $insert_timeline_annual=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_annual);
      //$new_timeline_id= $this->db->insert_id();

      $update_timeline		=	$this->Survey_model->update_tbl_kiv_vessel_timeline('tbl_kiv_vessel_timeline',$data_update_timeline,$timeline_sl);
      /*
      $update_link    = $this->Survey_model->update_tbl_kiv_vessel_timeline('tbl_kiv_vessel_timeline',$arr_link,$new_timeline_id);
      */
      $data_insert=array(
      'vessel_id'			=>	$vessel_id,
      'process_id'		=>	$new_process_id,
      'survey_id'			=>	$survey_id_assign,
      'current_status_id'	=>	1,
      'current_position'	=>	$user_type_id,
      'user_id'			=>	$user_id,
      'previous_module_id'=>	$processflow_sl,
      'status'			=>	1,
      'status_change_date'=>	$status_change_date);

      $data_update = array('status'=>0);

      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id 		= 	$this->db->insert_id();

      $data_remarks = array(
      'sending_user_id' 		=> 	$processflow_sl,
      'receiving_user_id'		=> 	$processflow_id,
      'process_id'			=>	$new_process_id,
      'remarks_date'			=> 	$remarks_date,
      'remarks'				=>	$remarks,
      'entry_timestamp'		=>	$date);

      $data_survey_status = array(
      'process_id' => $new_process_id,
      'survey_id'     =>  $survey_id_assign,
      'current_status_id' => 1,
      'sending_user_id' => $sess_usr_id,
      'receiving_user_id' => $user_id);

      $data_main=array('processing_status'=>1);   
      $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);

      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);

      $remarks_insert=$this->Survey_model->insert_processflow_remarks('tbl_kiv_processflow_remarks', $data_remarks);

      if($process_update && $process_insert && $remarks_insert && $status_update && $insert_timeline_annual && $update_timeline)
      {
        redirect("Kiv_Ctrl/Survey/csHome");
      }
    }
  }
}



public function View_registration_intimation()
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
    $data       =  array('title' => 'View_registration_intimation', 'page' => 'View_registration_intimation', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $intimation_type_id=1;
    $registration_intimation          = $this->Survey_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']  = $registration_intimation;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/View_registration_intimation',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');
  }
}


public function resend_registration_intimation()
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
    $data       =  array('title' => 'resend_registration_intimation', 'page' => 'resend_registration_intimation', 'errorCls' => NULL, 'post' => $this->input->post());
    $data       =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $intimation_type_id=1;

    $registration_intimation          = $this->Survey_model->get_registration_intimation($vessel_id,$intimation_type_id);
    $data['registration_intimation']  = $registration_intimation;

    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/View_registration_intimation',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');
  }
}


/*_________________________________________Timeline__________________________________________________*/

public function timeline()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'timeline', 'page' => 'timeline', 'errorCls' => NULL, 'post' => $this->input->post());
    $this->load->model('Kiv_models/Survey_model');
    $data = $data + $this->data;
    if($user_type_id==11)
    {
      $vessel_details         =   $this->Survey_model->get_vessel_details_timeline($sess_usr_id);
      $data['vessel_details'] =   $vessel_details;
    }
    else
    {
      $vessel_details         =   $this->Survey_model->get_vessel_details_timeline_other();
      $data['vessel_details'] =   $vessel_details;
    }
    if($this->input->post())
    {
      /*$sms_message="Test sms";
      $this->load->model('Kiv_models/Survey_model');
      $mobil="9847903241";
      $stat = $this->Survey_model->sendSms($sms_message,$mobil);*/
    
      $vessel_id                = $this->security->xss_clean($this->input->post('vessel_id'));
      $slt_processflow          = $this->Survey_model->get_processflow_timeline($vessel_id);
      $data['slt_processflow']  = $slt_processflow;
    }
    $this->load->view('Kiv_views/template/timeline-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/timeline',$data);
    $this->load->view('Kiv_views/template/form-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function track_vessel()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');
  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'track_vessel', 'page' => 'track_vessel', 'errorCls' => NULL, 'post' => $this->input->post());
    $this->load->model('Kiv_models/Survey_model');
    $data = $data + $this->data;
    if($user_type_id==11)
    {
      $vessel_details         =   $this->Survey_model->get_vessel_details_timeline($sess_usr_id);
      $data['vessel_details'] =   $vessel_details;
    }
    else
    {
      $vessel_details         =   $this->Survey_model->get_vessel_details_timeline_other();
      $data['vessel_details'] =   $vessel_details;
    }
    if($this->input->post())
    {
      $vessel_id                = $this->security->xss_clean($this->input->post('vessel_id'));
      $slt_processflow          = $this->Survey_model->get_processflow_timeline($vessel_id);
      $data['slt_processflow']  = $slt_processflow;
    }
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/track_vessel',$data);
   $this->load->view('Kiv_views/template/form-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function Verify_dataentry_vessel()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id    = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');

  $vessel_id1     = $this->uri->segment(4);
  $data_id1       = $this->uri->segment(5);

  $vessel_id      = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id      = $this->encrypt->decode($vessel_id); 

  $data_id        = str_replace(array('-', '_', '~'), array('+', '/', '='), $data_id1);
  $data_id        = $this->encrypt->decode($data_id); 
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'Verify_dataentry_vessel', 'page' => 'Verify_dataentry_vessel', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;
    $this->load->model('Kiv_models/DataEntry_model'); 
    $registeringAuthority           =   $this->DataEntry_model->get_registeringAuthority();
    $data['registeringAuthority']   =   $registeringAuthority;

    $vesseltype                     =   $this->DataEntry_model->get_vesseltype();
    $data['vesseltype']             =   $vesseltype;

    $portofregistry                 =   $this->DataEntry_model->get_portofregistry();
    $data['portofregistry']         =   $portofregistry;

    $inboard_outboard               =   $this->DataEntry_model->get_inboard_outboard();
    $data['inboard_outboard']       =   $inboard_outboard;

    $hullmaterial                   =   $this->DataEntry_model->get_hullmaterial();
    $data['hullmaterial']           =   $hullmaterial;

    $ra_list                        =   $this->DataEntry_model->get_ralist();
    $data['ra_list']                =   $ra_list;

    $stern_material                 =   $this->DataEntry_model->get_stern_material();
    $data['stern_material']         =   $stern_material;

    $cargo_nature_list              =   $this->DataEntry_model->get_cargo_nature();
    $data['cargo_nature_list']      =   $cargo_nature_list;

    $fuel                           =   $this->DataEntry_model->get_fuel_details();
    $data['fuel']                   =   $fuel;

    $portable_fire_ext              =   $this->DataEntry_model->get_portable_fire_ext();
    $data['portable_fire_ext']      =   $portable_fire_ext;

    $placeof_survey                 =   $this->DataEntry_model->get_placeof_survey();
    $data['placeof_survey']         =   $placeof_survey;

    $vessel_subtype                 =   $this->DataEntry_model->get_vessel_subtype_all();
    $data['vessel_subtype']         =   $vessel_subtype;

    $life_save_equipment            =   $this->DataEntry_model->get_equipment_details_id(11);
    $data['life_save_equipment']    =   $life_save_equipment;

    $pollution_control              =   $this->DataEntry_model->get_equipment_details(7);
    $data['pollution_control']      =   $pollution_control; //Pollution control devices details

    $get_pollncntrl_equipment        =   $this->DataEntry_model->get_pollution_ctrl_edit($vessel_id,7);
    $data['get_pollncntrl_equipment'] =   $get_pollncntrl_equipment;
    /*_____________________________________________________________________*/

    $data_vessel=$this->DataEntry_model->get_dataentry_table('tbl_kiv_vessel_details','vessel_sl',$vessel_id);
    $data['data_vessel']  =   $data_vessel; //declare

    $data_fire= $this->DataEntry_model->get_dataentry_table('tbl_kiv_fire_extinguisher_details','vessel_id',$vessel_id);
    $data['data_fire']  =   $data_fire; //declare

    $fire_fighting_details          =   $this->DataEntry_model->fire_fighting_equipment_details($vessel_id);
    $data['fire_fighting_details']  =   $fire_fighting_details; //declare


    $data_hull=   $this->DataEntry_model->get_dataentry_table('tbl_kiv_hulldetails','vessel_id',$vessel_id);
    $data['data_hull']  =   $data_hull; //declare

    $data_engine=   $this->DataEntry_model->get_dataentry_table('tbl_kiv_engine_details','vessel_id',$vessel_id);
    $data['data_engine']  =   $data_engine; //declare


    $data_vessel_main=   $this->DataEntry_model->get_dataentry_table('tb_vessel_main','vesselmain_vessel_id',$vessel_id);
    $data['data_vessel_main']  =   $data_vessel_main; //declare

    $data_survey_intimation=   $this->DataEntry_model->get_dataentry_table('tbl_kiv_survey_intimation','vessel_id',$vessel_id);
    $data['data_survey_intimation']  =   $data_survey_intimation; //declare

    $data_registration_history=   $this->DataEntry_model->get_dataentry_table('tbl_registration_history','registration_vessel_id',$vessel_id);
    $data['data_registration_history']  =   $data_registration_history; //declare


    $data_insurance_details=   $this->DataEntry_model->get_dataentry_table('tbl_vessel_insurance_details','vessel_id',$vessel_id);
    $data['data_insurance_details']  =   $data_insurance_details;  //declare

    $data_pollution=$this->DataEntry_model->get_dataentry_table('tbl_pollution_details','vessel_id',$vessel_id);
    $data['data_pollution']  =   $data_pollution;  //declare

    //Number of life bouys
    $data_equp_type18= $this->DataEntry_model->get_equipment_table('tbl_kiv_equipment_details','vessel_id',$vessel_id,1,8);
    $data['data_equp_type18']  =   $data_equp_type18;

    //Number of heaving line
    $data_equp_heaving= $this->DataEntry_model->get_equipment_table('tbl_kiv_equipment_details','vessel_id',$vessel_id,1,55);
    $data['data_equp_heaving']  =   $data_equp_heaving;

    //Number of bilge pump
    $data_equp_bilgepump= $this->DataEntry_model->get_equipment_table('tbl_kiv_equipment_details','vessel_id',$vessel_id,4,53);
    $data['data_equp_bilgepump']  =   $data_equp_bilgepump;

    //Number of fire pump
    $data_equp_firepumps= $this->DataEntry_model->get_equipment_table('tbl_kiv_equipment_details','vessel_id',$vessel_id,4,13);
    $data['data_equp_firepumps']  =   $data_equp_firepumps;

    //Number of fire bucket
    $data_equp_firebucket= $this->DataEntry_model->get_equipment_table('tbl_kiv_equipment_details','vessel_id',$vessel_id,4,11);
    $data['data_equp_firebucket']  =   $data_equp_firebucket;

    //Number of sandbox
    $data_equp_sandbox= $this->DataEntry_model->get_equipment_table('tbl_kiv_equipment_details','vessel_id',$vessel_id,4,12);
    $data['data_equp_sandbox']  =   $data_equp_sandbox;

    //Number of oars
    $data_equp_oars= $this->DataEntry_model->get_equipment_table('tbl_kiv_equipment_details','vessel_id',$vessel_id,4,56);
    $data['data_equp_oars']  =   $data_equp_oars;

    //Number of foam
    $data_equp_foam= $this->DataEntry_model->get_equipment_table('tbl_kiv_equipment_details','vessel_id',$vessel_id,10,20);
    $data['data_equp_foam']  =   $data_equp_foam;


    //Number of fixed sandbox
    $data_equp_fixed_sandbox= $this->DataEntry_model->get_equipment_table('tbl_kiv_equipment_details','vessel_id',$vessel_id,10,21);
    $data['data_equp_fixed_sandbox']  =   $data_equp_fixed_sandbox;

    //Number of fire axe
    $data_equp_fireaxe= $this->DataEntry_model->get_equipment_table('tbl_kiv_equipment_details','vessel_id',$vessel_id,11,57);
    $data['data_equp_fireaxe']  =   $data_equp_fireaxe;

    $data_crew_master= $this->DataEntry_model->get_dataentry_table_crew('tbl_kiv_crew_details','vessel_id',$vessel_id,1);
    $data['data_crew_master']  =   $data_crew_master; 


    $data_crew_serang= $this->DataEntry_model->get_dataentry_table_crew('tbl_kiv_crew_details','vessel_id',$vessel_id,2);
    $data['data_crew_serang']  =   $data_crew_serang; 

    $data_crew_lascar= $this->DataEntry_model->get_dataentry_table_crew('tbl_kiv_crew_details','vessel_id',$vessel_id,3);
    $data['data_crew_lascar']  =   $data_crew_lascar; 

    $data_crew_driver= $this->DataEntry_model->get_dataentry_table_crew('tbl_kiv_crew_details','vessel_id',$vessel_id,4);
    $data['data_crew_driver']  =   $data_crew_driver; 

    if($this->input->post())
    {
      //print_r($_POST);
      //exit;
      $ip     = $_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date   =   date('Y-m-d h:i:s', time());
      $dataentry_date=date('Y-m-d');
      //_____________________________owner details__________________________________//
      $user_name              =$this->security->xss_clean($this->input->post('user_name'));
      $user_address           =$this->security->xss_clean($this->input->post('user_address'));
      $user_mobile_number     =$this->security->xss_clean($this->input->post('user_mobile_number'));
      $user_email             =$this->security->xss_clean($this->input->post('user_email'));
      //_____________________________vessel details__________________________________//
      $vessel_name             =$this->security->xss_clean($this->input->post('vessel_name'));
      $vessel_type_id          =$this->security->xss_clean($this->input->post('vessel_type_id'));
      $vessel_subtype_id       =$this->security->xss_clean($this->input->post('vessel_subtype_id'));
      $vessel_length_overall   =$this->security->xss_clean($this->input->post('vessel_length_overall'));
      $vessel_no_of_deck       =$this->security->xss_clean($this->input->post('vessel_no_of_deck'));
      $vessel_length           =$this->security->xss_clean($this->input->post('vessel_length'));
      $vessel_breadth          =$this->security->xss_clean($this->input->post('vessel_breadth'));
      $vessel_depth            =$this->security->xss_clean($this->input->post('vessel_depth'));
      $portofregistry_sl       =$this->security->xss_clean($this->input->post('portofregistry_sl'));
      $vessel_registration_number=$this->security->xss_clean($this->input->post('vessel_registration_number'));
      $build_place                    =$this->security->xss_clean($this->input->post('build_place'));
      $grt                            =$this->security->xss_clean($this->input->post('grt'));
      $nrt                            =$this->security->xss_clean($this->input->post('nrt'));
      $cargo_nature                   =$this->security->xss_clean($this->input->post('cargo_nature'));
      $stability_test_status_id       =$this->security->xss_clean($this->input->post('stability_test_status_id'));
      $passenger_capacity         =$this->security->xss_clean($this->input->post('passenger_capacity'));
      $area_of_operation          =$this->security->xss_clean($this->input->post('area_of_operation'));
      $lower_deck_passenger       =$this->security->xss_clean($this->input->post('lower_deck_passenger'));
      $upper_deck_passenger       =$this->security->xss_clean($this->input->post('upper_deck_passenger'));
      $four_cruise_passenger      =$this->security->xss_clean($this->input->post('four_cruise_passenger'));
      $condition_of_equipment     =$this->security->xss_clean($this->input->post('condition_of_equipment'));
      $validity_of_certificate    =$this->security->xss_clean($this->input->post('validity_of_certificate'));
      $stern_material_sl          =$this->security->xss_clean($this->input->post('stern_material_sl'));
      $registering_authority_sl  =$this->security->xss_clean($this->input->post('registering_authority_sl'));
      $first_aid_box             =$this->security->xss_clean($this->input->post('first_aid_box'));
      $vessel_tonnage            =round(($vessel_length_overall*$vessel_breadth*$vessel_depth)/2.83);
      $upperdeck                 =$this->security->xss_clean($this->input->post('upperdeck'));
      $number_of_bedrooms        =$this->security->xss_clean($this->input->post('number_of_bedrooms'));
      //_____________________________hull details__________________________________//
      $hull_name                    =$this->security->xss_clean($this->input->post('hull_name'));
      $hullmaterial_id              =$this->security->xss_clean($this->input->post('hullmaterial_id'));
      $bulk_heads                   =$this->security->xss_clean($this->input->post('bulk_heads'));
      $hull_condition_status_id     =$this->security->xss_clean($this->input->post('hull_condition_status_id'));
      $hull_year_of_built           =$this->security->xss_clean($this->input->post('hull_year_of_built'));
      //_____________________________engine details__________________________________//
      $engine_number                =$this->security->xss_clean($this->input->post('engine_number'));
      $engine_placement_id          =$this->security->xss_clean($this->input->post('engine_placement_id'));
      $manufacturer_name            =$this->security->xss_clean($this->input->post('manufacturer_name'));
      $make_year                    =$this->security->xss_clean($this->input->post('make_year'));
      $engine_speed                 =$this->security->xss_clean($this->input->post('engine_speed'));
      $propulsion_shaft_number      =$this->security->xss_clean($this->input->post('propulsion_shaft_number'));
      $bhp                          =$this->security->xss_clean($this->input->post('bhp'));
      $bhp_kw                       =(0.745699872)*$bhp;
      $fuel_sl                      =$this->security->xss_clean($this->input->post('fuel_sl'));
      //_____________________________tb_vessel_main__________________________________//
      $vesselmain_reg_date          =$this->security->xss_clean($this->input->post('vesselmain_reg_date'));
      $next_reg_renewal_date        =$this->security->xss_clean($this->input->post('next_reg_renewal_date'));
      $next_drydock_date            =$this->security->xss_clean($this->input->post('next_drydock_date'));
      //_____________________________tbl_kiv_survey_intimation__________________________________//
      $placeofsurvey_sl             =$this->security->xss_clean($this->input->post('placeofsurvey_sl'));
      $date_of_survey               =$this->security->xss_clean($this->input->post('date_of_survey'));
      //$remarks                    =$this->security->xss_clean($this->input->post('remarks'));
      //_____________________________tbl_registration_history__________________________________//
      $registration_validity_period=$this->security->xss_clean($this->input->post('registration_validity_period'));
      $user_sl  =$this->security->xss_clean($this->input->post('user_sl'));
      //_____________________________tbl_vessel_insurance_details__________________________________//
      $insurance_expiry_date  =$this->security->xss_clean($this->input->post('insurance_expiry_date'));
      //_____________________________tbl_pollution_details__________________________________//
      $pcb_certificate_number =$this->security->xss_clean($this->input->post('pcb_certificate_number'));
      $pcb_expiry_date        =$this->security->xss_clean($this->input->post('pcb_expiry_date'));
      //_____________________________primary key values__________________________________//

      $vessel_sl                =$this->security->xss_clean($this->input->post('vessel_sl'));
      $hull_sl                  =$this->security->xss_clean($this->input->post('hull_sl'));
      $engine_sl                =$this->security->xss_clean($this->input->post('engine_sl'));
      $vesselmain_sl            =$this->security->xss_clean($this->input->post('vesselmain_sl'));
      $intimation_sl            =$this->security->xss_clean($this->input->post('intimation_sl')); 
      $registration_sl          =$this->security->xss_clean($this->input->post('registration_sl'));
      $vessel_insurance_sl      =$this->security->xss_clean($this->input->post('vessel_insurance_sl'));
      $pollution_sl             =$this->security->xss_clean($this->input->post('pollution_sl'));

      $equipment_details_sl18   =$this->security->xss_clean($this->input->post('equipment_details_sl18'));
      $equipment_details_sl453  =$this->security->xss_clean($this->input->post('equipment_details_sl453'));
      $equipment_details_sl413  =$this->security->xss_clean($this->input->post('equipment_details_sl413'));
      $equipment_details_sl411  =$this->security->xss_clean($this->input->post('equipment_details_sl411'));
      $equipment_details_sl412  =$this->security->xss_clean($this->input->post('equipment_details_sl412'));
      $equipment_details_sl155  =$this->security->xss_clean($this->input->post('equipment_details_sl155'));
      $equipment_details_sl456  =$this->security->xss_clean($this->input->post('equipment_details_sl456'));
      $equipment_details_sl1157 =$this->security->xss_clean($this->input->post('equipment_details_sl1157'));
      $equipment_details_sl1020 =$this->security->xss_clean($this->input->post('equipment_details_sl1020'));
      $equipment_details_sl1021 =$this->security->xss_clean($this->input->post('equipment_details_sl1021'));

      $data_id                  =$this->security->xss_clean($this->input->post('data_id'));

      $number_of_lifebouys    =$this->security->xss_clean($this->input->post('number_of_lifebouys'));
      $number_of_bilgepump    =$this->security->xss_clean($this->input->post('number_of_bilgepump'));
      $equipment_id53         =$this->security->xss_clean($this->input->post('equipment_id53'));

      $equipment_type_id4     =$this->security->xss_clean($this->input->post('equipment_type_id4'));
      $number_of_firepumps    =$this->security->xss_clean($this->input->post('number_of_firepumps'));
      $equipment_id13         =$this->security->xss_clean($this->input->post('equipment_id13'));
      $number_of_firebucket   =$this->security->xss_clean($this->input->post('number_of_firebucket'));
      $equipment_id11         =$this->security->xss_clean($this->input->post('equipment_id11'));
      $number_of_sandbox      =$this->security->xss_clean($this->input->post('number_of_sandbox'));
      $equipment_id12         =$this->security->xss_clean($this->input->post('equipment_id12'));

      $equipment_type_id10    =$this->security->xss_clean($this->input->post('equipment_type_id10'));
      $number_of_foam         =$this->security->xss_clean($this->input->post('number_of_foam'));
      $equipment_id20         =$this->security->xss_clean($this->input->post('equipment_id20'));
      $number_of_fixed_sandbox=$this->security->xss_clean($this->input->post('number_of_fixed_sandbox'));
      $equipment_id21         =$this->security->xss_clean($this->input->post('equipment_id21'));

      $heaving_line_count     =$this->security->xss_clean($this->input->post('heaving_line_count'));
      $oars                   =$this->security->xss_clean($this->input->post('oars'));
      $fire_axe               =$this->security->xss_clean($this->input->post('fire_axe'));

      //_________________________ updation of tbl_kiv_user, user_master ______________________________// 

      $username=$user_email;
      $user_password=$user_email;
      $newp= $this->phpass->hash($user_email);
      $data_kiv_user = array('user_name' =>$user_name,
      'user_address'=>$user_address,
      'user_mobile_number'=>$user_mobile_number,
      'user_email'=>$user_email,
      'user_state_id'=>'32',
      'user_ownership_id'   => '1',
      'user_created_user_id'=>$sess_usr_id,
      'user_created_timestamp'=>$date,
      'user_created_ipaddress'=>$ip,
      'dataentry_status'=>'1');

      $usr_res          = $this->db->insert('tbl_kiv_user', $data_kiv_user);
      $id1              =   $this->db->insert_id();

      $change_relation  =   array('relation_sl' => $id1);
      $this->db->where('user_sl',$id1);
      $cp_result      =$this->db->update('tbl_kiv_user', $change_relation);

      $data_user=array('user_master_name'=>$user_email,
      'user_master_password'=>$newp,
      'user_master_fullname'=>$user_name,
      'user_master_id_user_type'=>'11',
      'customer_id'=>$id1,
      'survey_user_id'=>'1',
      'user_master_port_id'=>$portofregistry_sl,
      'user_master_timestamp'=>$date,
      'user_master_status'=>'1',
      'user_master_ph'=>$user_mobile_number,
      'user_master_email'=>$user_email,
      'user_decrypt_pwd'=>$user_email,
      'dataentry_status'=>'1');
      $result_user    = $this->db->insert('user_master', $data_user);
      //$created_user_id =   $this->db->insert_id(); //remove comment before production
      $created_user_id =100;
      /*______________Insertion Life buoys_____________________*/
      if(!empty($equipment_details_sl18))
      {
        $data_update_lifebouys= array(
        'number'             =>$number_of_lifebouys,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_lifebouys = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_lifebouys,'equipment_details_sl',$equipment_details_sl18);
      }
      else
      {
        $data_insert_lifebouys= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  '8',
        'equipment_type_id' =>  '1',
        'number'             =>$number_of_lifebouys,
        'equipment_created_user_id'    => $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_lifebouys = $this->db->insert('tbl_kiv_equipment_details', $data_insert_lifebouys);
      }
      /*______________Insertion bilge pump_____________________*/
      if(!empty($equipment_details_sl453))
      {
        $data_update_bilgepump= array(
        'number'             =>$number_of_bilgepump,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_bilgepump = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_bilgepump,'equipment_details_sl',$equipment_details_sl453);
      }
      else
      {
        $data_insert_bilgepump= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id53,
        'equipment_type_id' =>  $equipment_type_id4,
        'number'             =>$number_of_bilgepump,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_bilgepump = $this->db->insert('tbl_kiv_equipment_details', $data_insert_bilgepump);
      }
     /*______________Insertion of fire applains_____________________*/  
      if(!empty($equipment_details_sl413))
      {
        $data_update_firepumps= array(
        'number'             =>$number_of_firepumps,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_firepumps = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_firepumps,'equipment_details_sl',$equipment_details_sl413);
      }
      else
      {
        $data_insert_firepumps= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id13,
        'equipment_type_id' =>  $equipment_type_id4,
        'number'             =>$number_of_firepumps,
        'equipment_created_user_id'    => $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_firepumps = $this->db->insert('tbl_kiv_equipment_details', $data_insert_firepumps); 
      }
      /*______________Insertion of firebucket_____________________*/
      if(!empty($equipment_details_sl411))
      {
        $data_update_firebucket= array(
        'number'             =>$number_of_firebucket,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_firebucket = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_firebucket,'equipment_details_sl',$equipment_details_sl411);
      }
      else
      {
        $data_insert_firebucket= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id11,
        'equipment_type_id' =>  $equipment_type_id4,
        'number'             =>$number_of_firebucket,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_firebucket = $this->db->insert('tbl_kiv_equipment_details', $data_insert_firebucket);
      }
     /*______________Insertion of sandbox_____________________*/
      if(!empty($equipment_details_sl412))
      {
        $data_update_sandbox= array(
        'number'             =>$number_of_sandbox,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_sandbox = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_sandbox,'equipment_details_sl',$equipment_details_sl412);
      }
      else
      {
        $data_insert_sandbox= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id12,
        'equipment_type_id' =>  $equipment_type_id4,
        'number'             =>$number_of_sandbox,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_sandbox = $this->db->insert('tbl_kiv_equipment_details', $data_insert_sandbox);
      }
      /*______________Insertion of heaving line_____________________*/
      if(!empty($equipment_details_sl155))
      {
        $data_update_heaving_line= array(
        'number'             =>$heaving_line_count,
        'equipment_created_user_id'    => $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_heaving_line = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_heaving_line,'equipment_details_sl',$equipment_details_sl155);
      }
      else
      {
        $data_insert_heaving_line= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  '55',
        'equipment_type_id' =>  '1',
        'number'             =>$heaving_line_count,
        'equipment_created_user_id'    => $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_heaving_line= $this->db->insert('tbl_kiv_equipment_details', $data_insert_heaving_line);
      }
      /*______________Insertion of oars_____________________*/
      if(!empty($equipment_details_sl456))
      {
        $data_update_oars= array(
        'number'             =>$oars,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_oars = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_oars,'equipment_details_sl',$equipment_details_sl456);
      }
      else
      {
        $data_insert_oars= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  '56',
        'equipment_type_id' =>  '4',
        'number'             =>$oars,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_oars= $this->db->insert('tbl_kiv_equipment_details', $data_insert_oars);
      }
      /*______________Insertion of fire axe_____________________*/
      if(!empty($equipment_details_sl1157))
      {
        $data_update_fire_axe= array(
        'number'             =>$fire_axe,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_fireaxe = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_fire_axe,'equipment_details_sl',$equipment_details_sl1157);
      }
      else
      {
        $data_insert_fire_axe= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  '57',
        'equipment_type_id' =>  '11',
        'number'             =>$fire_axe,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_fire_axe= $this->db->insert('tbl_kiv_equipment_details', $data_insert_fire_axe);
      }
      /*______________Insertion of fixed fire extinguisher-foam_____________________*/
      if(!empty($equipment_details_sl1020))
      {
        $data_update_fixed_foam= array(
        'number'             =>$number_of_foam,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_fixed_foam = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_fixed_foam,'equipment_details_sl',$equipment_details_sl1020);
      }
      else
      {
        $data_insert_fixed_foam= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id20,
        'equipment_type_id' =>  $equipment_type_id10,
        'number'             =>$number_of_foam,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_fixed_foam = $this->db->insert('tbl_kiv_equipment_details', $data_insert_fixed_foam);
      }
      /*______________Insertion of fixed fire extinguisher-sandbox_____________________*/
      if(!empty($equipment_details_sl1021))
      {
        $data_update_fixed_sandbox= array(
        'number'             =>$number_of_fixed_sandbox,
        'equipment_created_user_id'    =>   $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_fixed_sandbox = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_fixed_sandbox,'equipment_details_sl',$equipment_details_sl1021);
      }
      else
      {
        $data_insert_fixed_sandbox= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id21,
        'equipment_type_id' =>  $equipment_type_id10,
        'number'             =>$number_of_fixed_sandbox,
        'equipment_created_user_id'    =>   $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_fixed_sandbox = $this->db->insert('tbl_kiv_equipment_details', $data_insert_fixed_sandbox);
      }
      if($vessel_type_id)
      {
        $vessel_type_id6       =   $this->DataEntry_model->get_vessel_type_id($vessel_type_id);
        $data['vessel_type_id6']   = $vessel_type_id6;
        $vesseltype_name      = $vessel_type_id6[0]['vesseltype_name'];
      }
      else
      {
        $vesseltype_name='-';
      }
      if($vessel_subtype_id!='')
      {
        $vessel_subtype_id6      =   $this->DataEntry_model->get_vessel_subtype_id($vessel_subtype_id1);
        $data['vessel_subtype_id6']  = $vessel_subtype_id6;
        $vessel_subtype_name    = $vessel_subtype_id6[0]['vessel_subtype_name'];
      }
      else
      {
        $vessel_subtype_name='-';
      }
      $portoffice_details      =   $this->DataEntry_model->get_portoffice_id($sess_usr_id);
      $data['portoffice_details']  = $portoffice_details;
      if(!empty($portoffice_details))
      {
        $dataentry_portoffice_id=$portoffice_details[0]['user_master_port_id'];
      }
      else
      {
        $dataentry_portoffice_id=$portofregistry_sl;
      }
      //_____________________________________fire extinguisher____________________________________//

      $fire_extinguisher_sl       =$this->security->xss_clean($this->input->post('fire_extinguisher_sl'));
      $fire_extinguisher_type_id  =$this->security->xss_clean($this->input->post('fire_extinguisher_type_id'));
      $firenumber                 =$this->security->xss_clean($this->input->post('firenumber'));
      $capacity                   =$this->security->xss_clean($this->input->post('capacity'));
      $fireext_count              =$this->security->xss_clean($this->input->post('fireext_count'));

      if(!empty($fireext_count))
      {
        for($i=0;$i<$fireext_count;$i++)
        {
          $data_port_ext  =   array(
          'fire_extinguisher_number'    =>  $firenumber[$i],
          'fire_extinguisher_capacity'    =>  $capacity[$i],
          'fire_extinguisher_created_user_id' =>  $created_user_id,
          'fire_extinguisher_created_timestamp' =>  $date,
          'fire_extinguisher_created_ipaddress' =>  $ip);

          $data_port_ext_insert =   array(
          'vessel_id'         =>  $vessel_id,  
          'fire_extinguisher_type_id'     =>  $fire_extinguisher_type_id[$i],
          'fire_extinguisher_number'    =>  $firenumber[$i],
          'fire_extinguisher_capacity'    =>  $capacity[$i],
          'fire_extinguisher_created_user_id' =>  $created_user_id,
          'fire_extinguisher_created_timestamp' =>  $date,
          'fire_extinguisher_created_ipaddress' =>  $ip,
          'dataentry_status'=>'1');

          $edit_id_fireext=$fire_extinguisher_sl[$i];
          $data       = $this->security->xss_clean($data);
          if($edit_id_fireext!=0)
          {
          $update_fire_ext   = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_fire_extinguisher_details',$data_port_ext,'fire_extinguisher_sl',$edit_id_fireext);
          }
          else
          {
              $data = $this->security->xss_clean($data);
          $result_fire_ext=$this->DataEntry_model->insert_tabledata('tbl_kiv_fire_extinguisher_details', $data_port_ext_insert);
          }
        }
      }
      //_____________________________________Crew details master____________________________________//
      $master_cnt              =$this->security->xss_clean($this->input->post('master_cnt'));
      $name_of_type_mr         =$this->security->xss_clean($this->input->post('name_of_type_mr'));
      $license_number_of_type_mr=$this->security->xss_clean($this->input->post('license_number_of_type_mr'));
      $crew_sl_master         =$this->security->xss_clean($this->input->post('crew_sl_master'));
      if(!empty($master_cnt))
      {
        for($i=0;$i<$master_cnt;$i++)
        {
          $data_crew_mr=  array(
          'name_of_type'  => $name_of_type_mr[$i],  
          'license_number_of_type'   => $license_number_of_type_mr[$i],            
          'crew_created_user_id'=>$created_user_id,
          'crew_created_timestamp'=>  $date,
          'crew_created_ipaddress'=>  $ip);

          $data_crew_mr_insert=  array(
          'vessel_id' =>$vessel_id,
          'survey_id' =>0,
          'crew_type_id'=>1,
          'name_of_type'  => $name_of_type_mr[$i],  
          'license_number_of_type'   => $license_number_of_type_mr[$i],            
          'crew_created_user_id'=>$created_user_id,
          'crew_created_timestamp'=>  $date,
          'crew_created_ipaddress'=>  $ip,
          'dataentry_status'=>'1');

          @$edit_id=$crew_sl_master[$i];
          $data       = $this->security->xss_clean($data);
          if($edit_id!=0)
          {
            $update_crew_mr = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_crew_details',$data_crew_mr,'crew_sl',$edit_id);
          }
          else
          {
            $data = $this->security->xss_clean($data);
            $insert_data_master=$this->DataEntry_model->insert_tabledata('tbl_kiv_crew_details', $data_crew_mr_insert);
          }
        }
      }
      //_____________________________________Crew details serang____________________________________//
      $serang_cnt                 =$this->security->xss_clean($this->input->post('serang_cnt'));
      $name_of_type_sg            =$this->security->xss_clean($this->input->post('name_of_type_sg'));
      $license_number_of_type_sg  =$this->security->xss_clean($this->input->post('license_number_of_type_sg'));
      $crew_sl_serang             =$this->security->xss_clean($this->input->post('crew_sl_serang'));
      if(!empty($serang_cnt))
      {
        for($i=0;$i<$serang_cnt;$i++)
        {
          $data_crew_sg=  array(
          'name_of_type'  => $name_of_type_sg[$i],  
          'license_number_of_type'   => $license_number_of_type_sg[$i],            
          'crew_created_user_id'=>$created_user_id,
          'crew_created_timestamp'=>  $date,
          'crew_created_ipaddress'=>  $ip,
          'dataentry_status'=>'1');

          $data_crew_sg_insert=  array(
          'vessel_id' =>$vessel_id,
          'survey_id' =>0,
          'crew_type_id'=>2,
          'name_of_type'  => $name_of_type_sg[$i],  
          'license_number_of_type'   => $license_number_of_type_sg[$i],            
          'crew_created_user_id'=>$created_user_id,
          'crew_created_timestamp'=>  $date,
          'crew_created_ipaddress'=>  $ip,
          'dataentry_status'=>'1');
        
          @$edit_id=$crew_sl_serang[$i];
          $data       = $this->security->xss_clean($data);
          if($edit_id!=0)
          {
            $update_crew_sg = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_crew_details',$data_crew_sg,'crew_sl',$edit_id);
          }
          else
          {
            $data = $this->security->xss_clean($data);
            $insert_data_serang=$this->DataEntry_model->insert_tabledata('tbl_kiv_crew_details', $data_crew_sg_insert);
          }
        }
      }
      //_____________________________________Crew details lascar____________________________________//
      $lascar_cnt                 =$this->security->xss_clean($this->input->post('lascar_cnt'));
      $name_of_type_lr            =$this->security->xss_clean($this->input->post('name_of_type_lr'));
      $license_number_of_type_lr  =$this->security->xss_clean($this->input->post('license_number_of_type_lr'));
      $crew_sl_lascar             =$this->security->xss_clean($this->input->post('crew_sl_lascar'));
      if(!empty($lascar_cnt))
      {
        for($i=0;$i<$lascar_cnt;$i++)
        {
          $data_crew_lr=  array(
          'name_of_type'  => $name_of_type_lr[$i],  
          'license_number_of_type'   => $license_number_of_type_lr[$i],            
          'crew_created_user_id'=>$created_user_id,
          'crew_created_timestamp'=>  $date,
          'crew_created_ipaddress'=>  $ip,
          'dataentry_status'=>'1');

          $data_crew_lr_insert=  array(
          'vessel_id' =>$vessel_id,
          'survey_id' =>0,
          'crew_type_id'=>3,
          'name_of_type'  => $name_of_type_lr[$i],  
          'license_number_of_type'   => $license_number_of_type_lr[$i],            
          'crew_created_user_id'=>$created_user_id,
          'crew_created_timestamp'=>  $date,
          'crew_created_ipaddress'=>  $ip,
          'dataentry_status'=>'1');

          @$edit_id=$crew_sl_lascar[$i];
          $data       = $this->security->xss_clean($data);
          if($edit_id!=0)
          {
            $update_crew_lr = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_crew_details',$data_crew_lr,'crew_sl',$edit_id);
          }
          else
          {
            $data = $this->security->xss_clean($data);
            $insert_data_lascar=$this->DataEntry_model->insert_tabledata('tbl_kiv_crew_details', $data_crew_lr_insert);
          }
        }
      }
      //_____________________________________Crew details driver____________________________________//
      $driver_cnt               =$this->security->xss_clean($this->input->post('driver_cnt'));
      $name_of_type_dr          =$this->security->xss_clean($this->input->post('name_of_type_dr'));
      $license_number_of_type_dr=$this->security->xss_clean($this->input->post('license_number_of_type_dr'));
      $crew_sl_driver           =$this->security->xss_clean($this->input->post('crew_sl_driver'));
      if(!empty($driver_cnt))
      {
        for($i=0;$i<$driver_cnt;$i++)
        {
          $data_crew_dr=  array(
          'name_of_type'  => $name_of_type_dr[$i],  
          'license_number_of_type'   => $license_number_of_type_dr[$i],            
          'crew_created_user_id'=>$created_user_id,
          'crew_created_timestamp'=>  $date,
          'crew_created_ipaddress'=>  $ip,
          'dataentry_status'=>'1');

          $data_crew_dr_insert=  array(
          'vessel_id' =>$vessel_id,
          'survey_id' =>0,
          'crew_type_id'=>4,
          'name_of_type'  => $name_of_type_dr[$i],  
          'license_number_of_type'   => $license_number_of_type_dr[$i],            
          'crew_created_user_id'=>$created_user_id,
          'crew_created_timestamp'=>  $date,
          'crew_created_ipaddress'=>  $ip,
          'dataentry_status'=>'1');

          @$edit_id=$crew_sl_driver[$i];
          $data       = $this->security->xss_clean($data);
          if($edit_id!=0)
          {
            $update_crew_dr = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_crew_details',$data_crew_dr,'crew_sl',$edit_id);
          }
          else
          {
            $data = $this->security->xss_clean($data);
            $insert_data_driver=$this->DataEntry_model->insert_tabledata('tbl_kiv_crew_details', $data_crew_dr_insert);
          }
        }
      }
      //_________________________Life Saving equipment details______________________________// 
      $equipment_details_sl1    =$this->security->xss_clean($this->input->post('equipment_details_sl1'));
      $equipment_sl1            =$this->security->xss_clean($this->input->post('equipment_sl1'));
      $number_adult1            =$this->security->xss_clean($this->input->post('number_adult1')); 
      $number_children1    =$this->security->xss_clean($this->input->post('number_children1')); //life jacket
      //------------insert/update life jacket------------//
      if(!empty($equipment_details_sl1))
      {
        $data_update_lifejacket = array(
        'number_adult'      =>$number_adult1,
        'number_children'=>$number_children1,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_lifejacket = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_lifejacket,'equipment_details_sl',$equipment_details_sl1);
      }
      else
      {
        $data_insert_lifejacket = array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_sl1,
        'equipment_type_id' =>  '11',
        'number_adult'      =>$number_adult1,
        'number_children'=>$number_children1,
        'equipment_created_user_id'    =>  $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_lifejacket = $this->db->insert('tbl_kiv_equipment_details', $data_insert_lifejacket); 
      }
      $equipment_details_sl2 =$this->security->xss_clean($this->input->post('equipment_details_sl2'));
      $equipment_sl2         =$this->security->xss_clean($this->input->post('equipment_sl2'));
      $number_adult2         =$this->security->xss_clean($this->input->post('number_adult2')); 
      $number_children2      =$this->security->xss_clean($this->input->post('number_children2')); //life boat
      //------------insert/update life boat------------//
      if(!empty($equipment_details_sl2))
      {
        $data_update_lifeboat = array(
        'number_adult'      =>$number_adult2,
        'number_children'=>$number_children2,
        'equipment_created_user_id'    => $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
         $update_lifeboat = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_lifeboat,'equipment_details_sl',$equipment_details_sl2);
      }
      else
      {
        $data_insert_lifeboat = array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_sl2,
        'equipment_type_id' =>  '11',
        'number_adult'      =>$number_adult2,
        'number_children'=>$number_children2,
        'equipment_created_user_id'    => $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_lifeboat = $this->db->insert('tbl_kiv_equipment_details', $data_insert_lifeboat);  
      }
      $equipment_details_sl3     =$this->security->xss_clean($this->input->post('equipment_details_sl3'));
      $equipment_sl3             =$this->security->xss_clean($this->input->post('equipment_sl3'));
      $number_adult3             =$this->security->xss_clean($this->input->post('number_adult3')); 
      $number_children3    =$this->security->xss_clean($this->input->post('number_children3')); //life raft
      //------------insert/update life raft------------//
      if(!empty($equipment_details_sl2))
      {
        $data_update_liferaft= array(
        'number_adult'      =>$number_adult3,
        'number_children'=>$number_children3,
        'equipment_created_user_id'    => $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip);
        $update_lifebraft = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_liferaft,'equipment_details_sl',$equipment_details_sl3);
      }
      else
      {
        $data_insert_liferaft= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_sl3,
        'equipment_type_id' =>  '11',
        'number_adult'      =>$number_adult3,
        'number_children'=>$number_children3,
        'equipment_created_user_id'    => $created_user_id,
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_liferaft = $this->db->insert('tbl_kiv_equipment_details', $data_insert_liferaft);  
      }
      //_________________________ Pollution control equipment ______________________________// 

      /*$list3=$this->security->xss_clean($this->input->post('list3'));
                                    
      foreach($list3 as $result1)
      {
        $list1_insert=array(
        'vessel_id'                  =>$vessel_id, 
        'survey_id'                  =>'0', 
        'equipment_id'                 =>$result1,
        'equipment_type_id'            =>7,
        'equipment_created_user_id'    => '0',
        'equipment_created_timestamp'  => $date,
        'equipment_created_ipaddress'  => $ip );
        $result_insert=$this->db->insert('tbl_kiv_equipment_details', $list1_insert); 
      } */

      //_________________________ updation of tbl_kiv_vessel_details ______________________________// 
      $data_vessel_details = array(
      'vessel_user_id' => $created_user_id,
      'vessel_name'     =>$vessel_name,
      'vessel_type_id'    =>$vessel_type_id,
      'vessel_subtype_id'   =>$vessel_subtype_id,
      'vessel_length_overall' =>$vessel_length_overall,
      'vessel_no_of_deck'   =>$vessel_no_of_deck,
      'vessel_length'     =>$vessel_length,
      'vessel_breadth'    =>$vessel_breadth,
      'vessel_depth'      =>$vessel_depth,
      'vessel_expected_tonnage'=>'0',
      'vessel_total_tonnage'  =>$vessel_tonnage,
      'vessel_registry_port_id'=>$portofregistry_sl,
      'vessel_registration_number'=>$vessel_registration_number,
      'build_place'     =>$build_place,
      'grt'         =>$grt,
      'nrt'         =>$nrt,
      'cargo_nature'      =>$cargo_nature,
      'stability_test_status_id'=>$stability_test_status_id,
      'passenger_capacity'  =>$passenger_capacity,
      'area_of_operation'   =>$area_of_operation,
      'lower_deck_passenger'  =>$lower_deck_passenger,
      'upper_deck_passenger'  =>$upper_deck_passenger,
      'four_cruise_passenger' =>$four_cruise_passenger,
      'first_aid_box'=>$first_aid_box,
      'condition_of_equipment'=>$condition_of_equipment,
      'validity_of_certificate'=>$validity_of_certificate,
      'stern_id'        =>$stern_material_sl,
      'registering_authority'=>$registering_authority_sl,
      'upperdeck'=>$upperdeck,
      'number_of_bedrooms'=>$number_of_bedrooms,
      'vessel_created_user_id'=>$created_user_id,
      'vessel_created_timestamp'=>$date,
      'vessel_created_ipaddress'=>$ip,
      'dataentry_status'=>'1');    //print_r($data_vessel_details);  exit;
      $update_vessel_details   = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_vessel_details',$data_vessel_details,'vessel_sl',$vessel_sl);
      //_________________________ updation of tbl_kiv_hulldetails ______________________________// 
      $data_hull_details= array(
      'vessel_id' => $vessel_id,
      'survey_id' =>'0',
      'hull_name'     =>$hull_name,
      'hullmaterial_id' =>$hullmaterial_id,
      'bulk_heads'    =>$bulk_heads,
      'hull_condition_status_id'=>$hull_condition_status_id,
      'hull_year_of_built'=>$hull_year_of_built,
      'hull_created_timestamp'=>$date,
      'hull_created_ipaddress'=>$ip,
      'hull_modified_user_id' =>$created_user_id,
      'dataentry_status'=>'1'); //print_r($data_hull_details);  exit;
      $update_hull_details   = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_hulldetails',$data_hull_details,'hull_sl',$hull_sl);
      //_________________________ updation of tbl_kiv_engine_details ______________________________// 
      $data_engine_details= array(
      'vessel_id' => $vessel_id,
      'survey_id' =>'0',
      'engine_number'   =>$engine_number,
      'engine_placement_id'=>$engine_placement_id,
      'manufacturer_name' =>$manufacturer_name,
      'make_year' =>$make_year,
      'engine_speed'    =>$engine_speed,
      'propulsion_shaft_number'=>$propulsion_shaft_number,
      'bhp'       =>$bhp,
      'bhp_kw'      =>$bhp_kw,
      'fuel_used_id'    =>$fuel_sl,
      'engine_created_user_id'=>$created_user_id,
      'engine_created_timestamp'=>$date,
      'engine_created_ipaddress'=>$ip,
      'dataentry_status'=>'1'); 

     $update_engine_details   = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_engine_details',$data_engine_details,'engine_sl',$engine_sl);
     //_________________________ updation of tb_vessel_main ______________________________// 
     $data_vessel_main= array(
      'vesselmain_vessel_id' => $vessel_id,
      'vesselmain_vessel_name'=>$vessel_name,
      'vesselmain_vessel_type'=>$vesseltype_name,
      'vesselmain_vessel_subtype'=>$vessel_subtype_name,
      'vesselmain_owner_id'=>$created_user_id,
      'vesselmain_portofregistry_id'=>$portofregistry_sl,
      'processing_status'=>0,
      'vesselmain_reg_number'=>$vessel_registration_number,
      'vesselmain_reg_date'=>$vesselmain_reg_date,
      'next_reg_renewal_date'=>$next_reg_renewal_date,
      'next_drydock_date'=>$next_drydock_date,
      'dataentry_status'=>'1');  //tb_vessel_main

      $update_vessel_main   = $this->DataEntry_model->update_dataentry_tables('tb_vessel_main',$data_vessel_main,'vesselmain_sl',$vesselmain_sl);
      //_________________________ updation of tbl_kiv_survey_intimation ______________________________// 

      $data_survey_intimation =array(
      'vessel_id' => $vessel_id,
      'survey_id' =>'1',
      'form_id'   =>'4',
      'placeofsurvey_id'=>$placeofsurvey_sl,
      'date_of_survey'=>$date_of_survey,
      'status'=>'2',
      'defect_status'=>'0',
      'intimation_created_user_id'=>'0',
      'intimation_created_timestamp'=>$date,
      'intimation_created_ipaddress'=>$ip,
      'dataentry_status'=>'1');
      $update_survey_intimation   = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_survey_intimation',$data_survey_intimation,'intimation_sl',$intimation_sl);
      //_________________________ updation of tbl_registration_history ______________________________// 
      $data_registration_history= array(
      'registration_vessel_id' => $vessel_id,
      'registration_date'=>$vesselmain_reg_date,
      'registration_number'=>$vessel_registration_number,
      'registration_validity_period'=>$registration_validity_period,
      'registering_authority'=>$registering_authority_sl,
      'registration_verify_id'=>$user_sl,
      'registering_user'=>$created_user_id,
      'registration_type'=>'1',
      'registration_status'=>'1',
      'dataentry_status'=>'1');
      $update_registration_history   = $this->DataEntry_model->update_dataentry_tables('tbl_registration_history',$data_registration_history,'registration_sl',$registration_sl);
      //_________________________ updation of tbl_vessel_insurance_details ______________________________// 
      $insertInsuranceDet=array(
      'vessel_id'                  => $vessel_id,
      'vessel_insurance_validity'  => $insurance_expiry_date,
      'insurance_created_user_id'  =>$created_user_id,
      'insurance_created_timestamp'=>$date,
      'insurance_created_ipaddress'=>$ip,
      'dataentry_status'=>'1');
      $update_insurance   = $this->DataEntry_model->update_dataentry_tables('tbl_vessel_insurance_details',$insertInsuranceDet,'vessel_insurance_sl',$vessel_insurance_sl);
      //_________________________ updation of tbl_pollution_details ______________________________// 
      $data_pollution_details= array(
      'vessel_id' => $vessel_id,
      'pcb_expiry_date'=>$pcb_expiry_date,
      'pcb_number'=>$pcb_certificate_number,
      'dataentry_status'=>'1',
      'pollution_created_user_id'=>$created_user_id,
      'pollution_created_timestamp'=>$date,
      'pollution_created_ipaddress'=>$ip);
      $result_pollution_details  = $this->DataEntry_model->update_dataentry_tables('tbl_pollution_details',$data_pollution_details,'pollution_sl',$pollution_sl);

      //_________________________ updation of tb_vessel_dataentry ______________________________// 
      $data_dataentry= array(
      'dataentry_approved_status' =>'1',
      'dataentry_approved_id'=>$sess_usr_id,
       'dataentry_approved_datetime'=>$date,
      'dataentry_approved_ip'=>$ip);
      //$result_dataentry  = $this->DataEntry_model->update_dataentry_tables('tb_vessel_dataentry',$data_dataentry,'id',$data_id);
      /*_________________________________________________________________________________________________*/
      /*______________code for send email starts_________________*/
      $config = Array(
      'protocol'        => 'smtp',
      'smtp_host'       => 'ssl://smtp.googlemail.com',
      'smtp_port'       => 465,
      'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
      'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
      'mailtype'        => 'html',
      'charset'         => 'iso-8859-1');
      $message = '<div>
      <h4>Registration Successful!</h4>
      <p>Your application for registering as a vessel owner at Department of Ports, Governmet of Kerala has been completed. Your login credential has been sent to your mobile number and email provided in the first form. <br> Username :'.$username.'  <br> Password : '.$user_password.'</p>
      <hr>
      </div>';
      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('kivportinfo@gmail.com'); // change it to yours
      //$this->email->to($user_mail); // change it to yours
      $this->email->to('bssajitha@gmail.com');
      $this->email->subject('Registration of Vessel Owner');
      $this->email->message($message);
      if($this->email->send())
      { 
        /*_____________code for send SMS starts_________________*/
        $this->load->model('Kiv_models/Survey_model');
        $mobil="9847903241";
        $stat = $this->Registration_model->sendSms($message,$mobil);
        /*_____________code for send SMS ends__________________*/
      }
      else
      {
        show_error($this->email->print_debugger());
      } 
      /*
      $number_of_bilgepump 4 53
      $number_of_firepumps 4 13
      $number_of_firebucket 4 11
      $number_of_sandbox 4 12
      $oars 4 56
      $number_of_foam 10 20
      $number_of_fixed_sandbox 10 21
      $fire_axe 11 57

      tbl_kiv_vessel_details-----ok
      tbl_kiv_fire_extinguisher_details---ok
      tbl_kiv_crew_details---ok
      tbl_kiv_equipment_details
      tbl_kiv_hulldetails---ok
      tbl_kiv_engine_details---ok
      tb_vessel_main---ok
      tbl_kiv_survey_intimation---ok
      tbl_registration_history---ok
      tbl_vessel_insurance_details--ok
      tbl_pollution_details---*/
    }
    $this->load->model('Kiv_models/Survey_model');
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_dataentry_vessel',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
}

function delete_crew_details($crew_sl)
{
  $data_crew= array('delete_status' => 1);
  $this->load->model('Kiv_models/DataEntry_model');
  $data['crew_sl']   = $crew_sl; 
  $crew_sl_data       =   $this->DataEntry_model->delele_crew_table($crew_sl,$data_crew);
  $data['crew_sl_data']     = $crew_sl_data;
}

public function Verify_payment_pc_additionalpayment()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

  $vessel_id1     = $this->uri->segment(4);
  $processflow_sl1  = $this->uri->segment(5);
  $survey_id1     = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data   =  array('title' => 'Verify_payment_pc_additionalpayment', 'page' => 'Verify_payment_pc_additionalpayment', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
    $data['vessel_details']   = $vessel_details;

    @$id            = $vessel_details[0]['vessel_created_user_id'];




    $customer_details       = $this->Survey_model->get_customer_details($id);
    $data['customer_details'] = $customer_details;
    $owner_name         = $customer_details[0]['user_name'];
    $user_mobile_number = $customer_details[0]['user_mobile_number'];
    $user_email         = $customer_details[0]['user_email'];

    $current_status       = $this->Survey_model->get_status();
    $data['current_status']   = $current_status;

    $form_number        = $this->Survey_model->get_form_number($vessel_id);
    $data['form_number']    = $form_number;
    $form_id=$form_number[0]['form_no'];


    //----------Vessel Details--------//

    $vessel_details_viewpage =  $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage']= $vessel_details_viewpage;
    $vessel_name            = $vessel_details_viewpage[0]['vessel_name'];


    //----------Payment Details--------//

    $payment_details =  $this->Survey_model->get_form_payment_details($vessel_id,$survey_id,$form_id);
    $data['payment_details']= $payment_details;
    $portofregistry_sl= $payment_details[0]['portofregistry_id'];
    $dd_amount        = $payment_details[0]['dd_amount'];
    //get port of registry name
    $registry_port_id             =   $this->Survey_model->get_registry_port_id($portofregistry_sl);
    $data['registry_port_id']     =   $registry_port_id;

    if(!empty($registry_port_id))
    {
      $port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
    }
    else
    {
      $port_of_registry_name="";
    }


    //print_r($payment_details);
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
      $user_sl_cs     = $this->security->xss_clean($this->input->post('user_sl_cs'));
      $status       = 1;

      $status_details_sl= $this->security->xss_clean($this->input->post('status_details_sl'));
      $payment_sl   = $this->security->xss_clean($this->input->post('payment_sl'));
      $payment_approved_remarks = $this->security->xss_clean($this->input->post('remarks'));

      $additional_payment_details=$this->Survey_model->get_additional_payment_details($vessel_id);
      $data['additional_payment_details'] =  $additional_payment_details;
      /*________________GET reference number start-initial survey___________________*/
      date_default_timezone_set("Asia/Kolkata");
      $date         =   date('Y-m-d h:i:s', time());
      $ref_process_id=1;
      $ref_number_details     =   $this->Survey_model->get_ref_number_details($vessel_id,$ref_process_id);
      $data['ref_number_details'] =   $ref_number_details;
      
      if(!empty($ref_number_details))
      {
        $ref_number       = $ref_number_details[0]['ref_number'];
        $ref_id         = $ref_number_details[0]['ref_id'];
        $data_ref_number    = array('payment_status' => $payment_status, 'payment_date'=>$date);
      }
      else
      {
        $ref_number =   "";
      }
      $update_ref_number    =   $this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);

      $date               =   date('Y-m-d h:i:s', time());
      $ip             = $_SERVER['REMOTE_ADDR'];
      $status_change_date = $date;

      if(!empty($additional_payment_details))
      {
        $additional_payment_sl=$additional_payment_details[0]['additional_payment_sl'];
        $data_additional_payment=array('additional_payment_status'=>0,
        'additional_payment_approved_id'=>$sess_usr_id,
        'additional_payment_approved_timestamp'=>$date,
        'additional_payment_approved_ipaddress'=>$ip);
        $update_additional_payment=$this->Survey_model->update_additional_payment('tbl_kiv_additional_payment', $data_additional_payment,$additional_payment_sl);
      }
      if($process_id==31)
      {
        $data_payment=array(
        'payment_approved_status' =>1,
        'payment_approved_user_id' =>$sess_usr_id,
        'payment_approved_datetime' =>$status_change_date,
        'payment_approved_ipaddress' =>$ip,
        'payment_approved_remarks' =>$payment_approved_remarks);
        $data_insert=array(
        'vessel_id'=>$vessel_id,
        'process_id'=>$process_id,
        'survey_id'=>$survey_id,
        'current_status_id'=>$current_status_id,
        'current_position'=>$current_position,
        'user_id'=>$user_sl_cs,
        'previous_module_id'=>$processflow_sl,
        'status'=>$status,
        'status_change_date'=>$status_change_date);

        $data_update = array('status'=>0);

        $data_survey_status=array(
        'current_status_id'=>$current_status_id,
        'sending_user_id'=>$sess_usr_id,
        'receiving_user_id'=>$user_sl_cs);
        //print_r($data_survey_status);

        $payment_update=$this->Survey_model->update_payment('tbl_kiv_payment_details',$data_payment, $payment_sl);

        $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
        $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
        $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
        //_____________________________Email sending start_____________________________//
        $email_subject="Payment for ".$vessel_name." is verified";
        $email_message="<div><h4>Dear ". $owner_name.",</h4><p>Your payment of Rs. <b>".$dd_amount."</b> towards Form submission of <b>".$vessel_name."</b> has been verified. Form is forwarded to Chief Surveyor.  <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>
        Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.<br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr></div>";
        $saji_email="bssajitha@gmail.com";
        $this->emailSendFunction($saji_email,$email_subject,$email_message);
        //$this->emailSendFunction($user_email,$email_subject,$email_message);
        //___________________Email sending start___________________________________________//
        //____________________SMS sending start____________________________________________//
        $sms_message="Payment for ".$vessel_name." is verified, and forwarded to Chief Surveyor";
        $this->load->model('Kiv_models/Survey_model');
        $saji_mob="9847903241";
        //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
        //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
        //____________________SMS sending end________________________________________________//


        if($payment_update && $process_update && $process_insert && $status_update)
        {
          redirect("Kiv_Ctrl/Survey/pcHome"."/".$modidenc);
        }
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/Verify_payment_pc_additionalpayment',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }
}

public function form10_approve()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

  $vessel_id1     = $this->uri->segment(4);
  $processflow_sl1  = $this->uri->segment(5);
  $survey_id1     = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
  if(!empty($sess_usr_id))
  {
    $data   =  array('title' => 'form10_approve', 'page' => 'form10_approve', 'errorCls' => NULL, 'post' => $this->input->post());
    $data   =  $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');
    $this->load->model('Kiv_models/Function_model');

    //----------Vessel Details--------//
    $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
    $data['vessel_details_viewpage'] = $vessel_details_viewpage;
    $vessel_name              = $vessel_details_viewpage[0]['vessel_name'];
    $portofregistry_sl        = $vessel_details_viewpage[0]['vessel_registry_port_id'];
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

    //----------Hull Details--------//
    $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id);
    $data['hull_details']    = $hull_details;
    //----------Engine Details--------//
    $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id);
    $data['engine_details']  = $engine_details;
    //----------Equipment Details--------//
    $equipment_details     =   $this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
    $data['equipment_details'] = $equipment_details;
    //----------Get portable fire extinguisher---------------//
    $portable_fire_ext     =   $this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id);
    $data['portable_fire_ext']    =   $portable_fire_ext;
    //--------------Documents-----------------//

    $list_document_vessel        =   $this->Survey_model->get_list_document_vessel();
    $data['list_document_vessel']    = $list_document_vessel;

    // @$id=$vessel_details_viewpage[0]['vessel_user_id'];
    @$id=$vessel_details_viewpage[0]['user_id'];

    //-----------Get customer name and address--------------//
    $customer_details=$this->Survey_model->get_customer_details($id);
    $data['customer_details']=$customer_details;
    $owner_name         = $customer_details[0]['user_name'];
    $user_mobile_number = $customer_details[0]['user_mobile_number'];
    $user_email         = $customer_details[0]['user_email'];
    if($this->input->post())
    {
      // print_r($_POST); exit;
      $validity_fire_extinguisher2 = $this->security->xss_clean($this->input->post('validity_fire_extinguisher'));
      $validity_of_insurance2     = $this->security->xss_clean($this->input->post('validity_of_insurance'));
      $validity_of_certificate2   = $this->security->xss_clean($this->input->post('validity_of_certificate'));
      $form10_remarks             = $this->security->xss_clean($this->input->post('form10_remarks'));
      $vesselId                   = $this->security->xss_clean($this->input->post('hdn_vesselId'));

      $validity_fire_extinguisher1    = str_replace('/', '-', $validity_fire_extinguisher2);
      $validity_of_insurance1         = str_replace('/', '-', $validity_of_insurance2);
      $validity_of_certificate1       = str_replace('/', '-', $validity_of_certificate2);
      $validity_fire_extinguisher     = date("Y-m-d", strtotime($validity_fire_extinguisher1));
      $validity_of_insurance          = date("Y-m-d", strtotime($validity_of_insurance1));
      $validity_of_certificate        = date("Y-m-d", strtotime($validity_of_certificate1));
      $vessel_survey_number       = $this->security->xss_clean($this->input->post('vessel_survey_number'));
      $vessel_registration_number = $this->security->xss_clean($this->input->post('vessel_registration_number'));
      $survey_id                   =  $this->security->xss_clean($this->input->post('survey_id'));
      $processflow_sl              =  $this->security->xss_clean($this->input->post('processflow_sl'));
      $process_id                  =  $this->security->xss_clean($this->input->post('process_id')); 
      $status                      =  1;
      $status_details_sl           =  $this->security->xss_clean($this->input->post('status_details_sl'));
      $owner_user_type_id          =  $this->security->xss_clean($this->input->post('owner_user_type_id'));
      $owner_user_id               =  $this->security->xss_clean($this->input->post('owner_user_id'));
      $ip=  $_SERVER['REMOTE_ADDR'];
      date_default_timezone_set("Asia/Kolkata");
      $date =   date('Y-m-d h:i:s', time());
      $status_change_date   = $date;
      //____________________Get survey intimation :  tbl_kiv_survey_intimation ____________________//

      $survey_intimation          = $this->Survey_model->get_survey_intimation_details($vesselId,$survey_id);
      $data['survey_intimation']  = $survey_intimation;
      if(!empty($survey_intimation))
      {
        foreach ($survey_intimation as $key ) 
        {
          $defect_status      = $key['defect_status'];
          $survey_defects_id  = $key['survey_defects_id'];
          if($defect_status==0)
          {
            $date_of_survey       = $survey_intimation[0]['date_of_survey'];
            $adding_one_year      = date('d-m-Y', strtotime($date_of_survey . "1 year") );
            $adding_five_year     = date('d-m-Y', strtotime($date_of_survey . "5 year") );
            $annual_survey_date   = date("Y-m-d", strtotime($adding_one_year));
            $drydock_survey_date  = date("Y-m-d", strtotime($adding_five_year));
            $date_of_survey3        = date("d-m-Y", strtotime($date_of_survey));
          }
          else
          {
            $survey_intimation_defects =  $this->Survey_model->get_survey_intimation_defects($survey_defects_id);
            $data['survey_intimation_defects'] =  $survey_intimation_defects;

            $date_of_survey       = $survey_intimation_defects[0]['date_of_survey'];
            $adding_one_year      = date('d-m-Y', strtotime($date_of_survey . "1 year") );
            $adding_five_year     = date('d-m-Y', strtotime($date_of_survey . "5 year") );
            $annual_survey_date   = date("Y-m-d", strtotime($adding_one_year));
            $drydock_survey_date  = date("Y-m-d", strtotime($adding_five_year));
            $date_of_survey3        = date("d-m-Y", strtotime($date_of_survey));
          }
        }
      }
      
     
      $data_vessel=array(
      'validity_fire_extinguisher'=>$validity_fire_extinguisher,
      'validity_of_insurance'   =>$validity_of_insurance,
      'validity_of_certificate' =>$validity_of_certificate,
      'form10_remarks'         =>$form10_remarks,
      'vessel_modified_user_id' =>$sess_usr_id,
      'vessel_modified_timestamp' =>$date,
      'vessel_modified_ipaddress' =>$ip);

      $update_vessel_table  = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_vessel,$vesselId);
      //____________________survey-initial survey date insertion__________________________//
      $timeline_data_initial = array('vessel_id' =>$vesselId ,
      'survey_number' => $vessel_survey_number,
      'process_id' => 1,
      'subprocess_id' => 1,
      'scheduled_date' => $date_of_survey,
      'actual_date' => $date_of_survey,
      'status' => 1,
      'link_id' => '-1',
      'timeline_created_user_id' => $sess_usr_id,
      'timeline_created_timestamp' =>$date,
      'timeline_created_ipaddress' => $ip);

      $insert_timeline_initial=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_initial);               
      //_______________________________survey-annual survey date insertion______________________//

      $timeline_data_annual = array('vessel_id' =>$vesselId ,
      'survey_number' => $vessel_survey_number,
      'process_id' => 1,
      'subprocess_id' => 2,
      'scheduled_date' => $annual_survey_date,
      'status' => 0,
      //'link_id' => 0,
      'link_id' => '-1',
      'timeline_created_user_id' => $sess_usr_id,
      'timeline_created_timestamp' =>$date,
      'timeline_created_ipaddress' => $ip);
      $insert_timeline_annual=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_annual);               
      //__________________________survey-drydock survey date insertion_____________________//

      $timeline_data_drydock = array('vessel_id' =>$vesselId ,
      'survey_number' => $vessel_survey_number,
      'process_id' => 1,
      'subprocess_id' => 3,
      'scheduled_date' => $drydock_survey_date,
      'status' => 0,
      //'link_id' => 0,
      'link_id' => '-1',
      'timeline_created_user_id' => $sess_usr_id,
      'timeline_created_timestamp' =>$date,
      'timeline_created_ipaddress' => $ip);
      $insert_timeline_drydock=$this->Survey_model->insert_table2('tbl_kiv_vessel_timeline', $timeline_data_drydock);

      //_________________________________process flow start___________________________________//
      $data_insert=array(
      'vessel_id'=>$vesselId,
      'process_id'=>$process_id,
      'survey_id'=>$survey_id,
      'current_status_id'=>5,
      'current_position'=>$user_type_id,
      'user_id'=>$sess_usr_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>0,
      'status_change_date'=>$status_change_date);

      $data_update = array('status'=>0);
      $process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
      $process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
      $processflow_id   =   $this->db->insert_id();
      $new_process_id=14;
      $data_insert_form7=array(
      'vessel_id'=>$vesselId,
      'process_id'=>$new_process_id,
      //'survey_id'=>$survey_id,
      'survey_id'=>0,
      'current_status_id'=>1,
      'current_position'=>$owner_user_type_id,
      'user_id'=>$owner_user_id,
      'previous_module_id'=>$processflow_sl,
      'status'=>$status,
      'status_change_date'=>$status_change_date);
      $process_insert_form7=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert_form7);
      $data_survey_status=array(
      'process_id'=>$new_process_id,
      'survey_id'=>0,
      'current_status_id'=>1,
      'sending_user_id'=>$sess_usr_id,
      'receiving_user_id'=>$owner_user_id);
      $status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
      $data_main=array('processing_status'=>0);   
      $process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vesselId);
      /*_________________________________process flow end___________________________________*/

      /*___________________________update reference number start____________________________*/
      $nprocess_id=1;
      $ref_number_details     =   $this->Survey_model->get_ref_number_details($vessel_id,$nprocess_id);
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
      $ref_process_id=1;
      $ref_number_details_forms     =   $this->Survey_model->get_ref_number_details_forms($vessel_id,$ref_process_id);
      $data['ref_number_details_forms'] =   $ref_number_details_forms;

      if(!empty($ref_number_details_forms))
      {
        $ref_number       = $ref_number_details_forms[0]['ref_number'];
      }
      else
      {
        $ref_number =   "";
      }
      //_____________________________Email sending start_____________________________//
      $email_subject="Certificate of survey for ".$vessel_name." is ready for delivery";
      $email_message="<div><h4>Dear ". $owner_name.",</h4><p>Certifictate of Survey is generated for <b>".$vessel_name."</b>. Certificate of survey can be downloaded by login to portinfo.kerala.gov.in under the menu Survey Certificate.<br>
      Survey number for <b>".$vessel_name."</b> vessel is : <b>".$vessel_survey_number."</b> <br>
      Survey date : <b>".$date_of_survey3."</b><br>
      Next annual survey date is on : <b>".$adding_one_year."</b><br>  
      Next drydock date is on : <b>".$adding_five_year."</b><br>
      <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Chief Surveyor<br><br>Kerala Maritime Board <br></p><hr></div>";
      $saji_email="bssajitha@gmail.com";
      $this->emailSendFunction($saji_email,$email_subject,$email_message);
      //$this->emailSendFunction($user_email,$email_subject,$email_message);
      //___________________Email sending start___________________________________________//
      //____________________SMS sending start____________________________________________//
      $sms_message="Certificate of survey is generated for ".$vessel_name.". Certificate of survey can be downloaded from portinfo.kerala.gov.in. Now you can proceed for registration of vessel.";
      $this->load->model('Kiv_models/Survey_model');
      $saji_mob="9847903241";
      //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
      //$stat = $this->Survey_model->sendSms($sms_message,$user_mobile_number);
      //____________________SMS sending end________________________________________________//

      if($process_update && $process_insert_form7 &&$process_insert && $status_update && $process_update_main)
      {
        redirect("Kiv_Ctrl/Survey/csHome");
      }
    }
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/form10_approve',$data);
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
  $this->email->to('bssajitha@gmail.com');
  $this->email->subject($sub);
  $this->email->message($msg); 
  $result = $this->email->send();
  $res=$this->email->print_debugger();
  return $result;
}


public function ch_pw()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  //echo $u_id;break;
  //$userinfo     = $this->Master_model->getuserinfo($sess_usr_id);
  //$i=0;
  //$port_id      = $userinfo[$i]['user_master_port_id'];
  if(!empty($sess_usr_id))
  {
    $this->load->model('Main_login_model');
    $data         =   array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
    $data         =   $data + $this->data;     
    $u_h_dat      =   $this->Main_login_model->getuserdetailsforheader($sess_usr_id);
    
    //$data['uname']= $uname;
    
    $data['user_header']= $u_h_dat;
    $data         =   $data + $this->data;
    $this->load->view('Kiv_views/template/dash-header.php');;
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Main_login/ch_pw', $data);
    $this->load->view('Kiv_views/template/dash-footer.php');
    $this->load->view('Kiv_views/template/all-header.php');
    
    if($this->input->post())
    {
      $paswd    = $this->security->xss_clean(html_escape($this->input->post('c_p')));//echo $paswd;
      $npaswd   = $this->security->xss_clean(html_escape($this->input->post('n_p'))); //echo $npaswd;exit;
      $uname    = $this->security->xss_clean(html_escape($this->input->post('uname_hid'))); //echo $npaswd;exit;
      $u_id     = $this->security->xss_clean(html_escape($this->input->post('u_id'))); //echo $npaswd;exit;
      $res      = $this->Main_login_model->login($uname);//print_r($res);exit;
      //print_r($res);
      //exit();
      foreach($res as $re)
      {
        $hashed=$re['user_master_password'];
      }
      if($this->phpass->check($paswd,$hashed))
      {
        //$u_ip=$_SERVER['REMOTE_ADDR'];
        if ($_SERVER["HTTP_X_FORWARDED_FOR"]) 
        {
          $u_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else 
        {
          $u_ip = $_SERVER["REMOTE_ADDR"];
        }
        $timestamp = time();
        $date_time = date("Y-m-d  H:i:s", $timestamp);
        $login_time = $date_time;
        //$maxlifetime=ini_get("session.gc_maxlifetime");
        //$add_time=$timestamp+$maxlifetime;
        //$logout_time= date("Y-m-d H:i:s",$add_time);
        $newp=$this->phpass->hash($npaswd);
        $data_u=array('user_master_password'=>$newp, 'user_decrypt_pwd'=>$npaswd);//print_r($data_u);exit;
        $res=$this->Main_login_model->up_pw($data_u,$u_id); //print_r($res);exit;
        if($res==1)
        {
          $this->session->set_userdata('login_time',$login_time);
          $data=array(
          'user_id'=>$u_id,
          'login'=> $login_time,
          'logout'=>$login_time,
          'log_ip'=>$this->input->ip_address()); //print_r($data);exit;
          $this->Main_login_model->save_userlog($data);
          session_destroy();
          redirect('Main_login/index');
        }
        else
        {
          $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Update failed!!!</div>');
          redirect('Kiv_Ctrl/Survey/ch_pw');
        }
      }
      else
      {
      $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Please Check your Password!!!</div>');
      redirect('Kiv_Ctrl/Survey/ch_pw'); 
      }
    }
  }
  else
  {
    redirect('Main_login/index');        
  }  
}

public function ren_ins_pol()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  
  if(!empty($sess_usr_id))
  {
    $this->load->model('Survey_model');
    $data         =   array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
    $data         =   $data + $this->data;     
    $vessel_det   =   $this->Survey_model->get_vessel_main_renew($sess_usr_id);
    $data['vessel_det']= $vessel_det;
    $data         =   $data + $this->data;
    
    $this->load->view('Kiv_views/template/all-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/ren_ins_pol', $data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }  
}
public function tariff_calc_vw()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  
  if(!empty($sess_usr_id))
  {
    $this->load->model('Survey_model');
    $data         =   array('title' => 'tariff_calc_vw', 'page' => 'tariff_calc_vw', 'errorCls' => NULL, 'post' => $this->input->post());
    $data         =   $data + $this->data;     
    
    $vesselType   =   $this->Survey_model->get_vesseltype_dynamic();
    $data['vesselType'] = $vesselType; 
    $surveyType     =   $this->Survey_model->get_survey_master();
    $data['surveyType'] = $surveyType;
    $formName     =   $this->Survey_model->get_formname_dynamic();
    $data['formName'] = $formName;
    
    
    $this->load->view('Kiv_views/template/all-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/tariff_calc_vw', $data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }  
}
public function dcb_statement()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
  if(!empty($sess_usr_id))
  {
    $this->load->model('Survey_model');
    $data         =   array('title' => 'dcb_statement', 'page' => 'dcb_statement', 'errorCls' => NULL, 'post' => $this->input->post());
    $data         =   $data + $this->data;  


    $survey_type              = $this->Survey_model->get_survey_master();
    $data['survey_type']      =   $survey_type;

    $bank                     =   $this->Survey_model->get_bank_favoring();
    $data['bank']             =   $bank;
    if($this->input->post())
    {
      $no_data="1";
      $data['no_data']=$no_data;
      $survey_sl1       = $this->security->xss_clean($this->input->post('survey_sl'));
      $bank_sl1         = $this->security->xss_clean($this->input->post('bank_sl'));
      $from_date       = $this->security->xss_clean($this->input->post('from_date'));
      $to_date         = $this->security->xss_clean($this->input->post('to_date'));
      $portofregistry_id = $this->security->xss_clean($this->input->post('portofregistry_id'));
      
      if($survey_sl1==TRUE)
      {
        foreach($survey_sl1 as $res1)
        {
          $survey_sl[] =$res1;
        }
        @$survey_sl2    = implode(", ",$survey_sl);
      }
            
      if($bank_sl1==TRUE)
      {
        foreach($bank_sl1 as $res2)
        {
          $bank_sl[] =$res2;
        }

        @$bank_sl2    = implode(", ",$bank_sl);
      }
    
      if($survey_sl2!=0 && $bank_sl2!=0 && $from_date==true && $to_date==true)
      {
        
        $dcb_statement  = $this->Survey_model->get_dcb_statement($portofregistry_id,$survey_sl,$bank_sl,$from_date,$to_date);
        $data['dcb_statement']  = $dcb_statement;
      }
      if($survey_sl2==0 && $bank_sl2==0 && $from_date==true && $to_date==true) //survey all, gateway all
      {
         
        $dcb_statement = $this->Survey_model->get_dcb_statement_date($portofregistry_id,$from_date,$to_date);
        $data['dcb_statement']  = $dcb_statement;
      }
      if($survey_sl2!=0 && $bank_sl2==0 && $from_date==true && $to_date==true) //survey selected, gateway all
      {
         
        $dcb_statement = $this->Survey_model->get_dcb_statement_one($portofregistry_id,$survey_sl,$from_date,$to_date);
        $data['dcb_statement']  = $dcb_statement;
      }
      if($survey_sl2==0 && $bank_sl2!=0 && $from_date==true && $to_date==true) //survey all, gateway selected
      {
         
        $dcb_statement = $this->Survey_model->get_dcb_statement_two($portofregistry_id,$bank_sl,$from_date,$to_date);
        $data['dcb_statement']  = $dcb_statement;
      }
    }
    else
    {
      $no_data="0";
      $data['no_data']=$no_data;
    }
     
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/dcb_statement', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');
  
  }
  else
  {
    redirect('Main_login/index');        
  }  
}
public function dcb_statement_cssrra()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
  if(!empty($sess_usr_id))
  {
    $this->load->model('Survey_model');
    $data         =   array('title' => 'dcb_statement_cssrra', 'page' => 'dcb_statement_cssrra', 'errorCls' => NULL, 'post' => $this->input->post());
    $data         =   $data + $this->data;  
           


    if($user_type_id=='14')
    {
      $survey_sl2 = array(5,6,7,8,9,10,11,12);
      $survey_type              = $this->Survey_model->get_survey_master_ra($survey_sl2);
      $data['survey_type']      =   $survey_type;
    }
    else
    {
      $survey_sl2 = array(1,2,3,4);
      $survey_type              = $this->Survey_model->get_survey_master_ra($survey_sl2);
      $data['survey_type']      =   $survey_type;
    }
    
    $bank                     =   $this->Survey_model->get_bank_favoring();
    $data['bank']             =   $bank;
    $portofregistry         =   $this->Survey_model->get_portofregistry();
    $data['portofregistry']   = $portofregistry;

    if($this->input->post())
    {
      $no_data="1";
      $data['no_data']=$no_data;
      $survey_sl1       = $this->security->xss_clean($this->input->post('survey_sl'));
      $bank_sl1         = $this->security->xss_clean($this->input->post('bank_sl'));
      $from_date       = $this->security->xss_clean($this->input->post('from_date'));
      $to_date         = $this->security->xss_clean($this->input->post('to_date'));
      $portofregistry_id = $this->security->xss_clean($this->input->post('portofregistry_id'));
      
      if($survey_sl1==TRUE)
      {
        foreach($survey_sl1 as $res1)
        {
          $survey_sl[] =$res1;
        }
        @$survey_sl2    = implode(", ",$survey_sl);
      }
            
      if($bank_sl1==TRUE)
      {
        foreach($bank_sl1 as $res2)
        {
          $bank_sl[] =$res2;
        }

        @$bank_sl2    = implode(", ",$bank_sl);
      }
    
      if($survey_sl2!=0 && $bank_sl2!=0 && $from_date==true && $to_date==true)
      {
        
        $dcb_statement  = $this->Survey_model->get_dcb_statement($portofregistry_id,$survey_sl,$bank_sl,$from_date,$to_date);
        $data['dcb_statement']  = $dcb_statement;
      }
      if($survey_sl2==0 && $bank_sl2==0 && $from_date==true && $to_date==true) //survey all, gateway all
      {
         
        $dcb_statement = $this->Survey_model->get_dcb_statement_date($portofregistry_id,$from_date,$to_date);
        $data['dcb_statement']  = $dcb_statement;
      }
      if($survey_sl2!=0 && $bank_sl2==0 && $from_date==true && $to_date==true) //survey selected, gateway all
      {
         
        $dcb_statement = $this->Survey_model->get_dcb_statement_one($portofregistry_id,$survey_sl,$from_date,$to_date);
        $data['dcb_statement']  = $dcb_statement;
      }
      if($survey_sl2==0 && $bank_sl2!=0 && $from_date==true && $to_date==true) //survey all, gateway selected
      {
         
        $dcb_statement = $this->Survey_model->get_dcb_statement_two($portofregistry_id,$bank_sl,$from_date,$to_date);
        $data['dcb_statement']  = $dcb_statement;
      }
    }
    else
    {
      $no_data="0";
      $data['no_data']=$no_data;
    } 
     
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/dcb_statement_cssrra', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');
    

  }
  else
  {
    redirect('Main_login/index');        
  }  
}
public function transaction_search()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
  if(!empty($sess_usr_id))
  {
    $this->load->model('Survey_model');
    $data         =   array('title' => 'transaction_search', 'page' => 'transaction_search', 'errorCls' => NULL, 'post' => $this->input->post());
    $data         =   $data + $this->data;  

     
    if($this->input->post())
    {
      $no_data="1";
      $data['no_data']=$no_data;

      $transaction_id       = $this->security->xss_clean($this->input->post('transaction_id'));
      $portofregistry_id    = $this->security->xss_clean($this->input->post('portofregistry_id'));
      if($user_type_id=="3")
      {
        $transaction_details=$this->Survey_model->get_transaction_details($portofregistry_id,$transaction_id);
        $data['transaction_details']  = $transaction_details;
      }
      else
      {
        $transaction_details=$this->Survey_model->get_transaction_details_tid($transaction_id);
        $data['transaction_details']  = $transaction_details;
      }
     // print_r($transaction_details);
    }
    else
    {
      $no_data="0";
      $data['no_data']=$no_data;
    }
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/transaction_search', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');

  }
}
public function payment_search()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
  if(!empty($sess_usr_id))
  {
    $this->load->model('Survey_model');
    $data         =   array('title' => 'payment_search', 'page' => 'payment_search', 'errorCls' => NULL, 'post' => $this->input->post());
    $data         =   $data + $this->data;  
  
     
    if($this->input->post())
    {
      $no_data="1";
      $data['no_data']=$no_data;
      $search_id       = $this->security->xss_clean($this->input->post('search_id'));
      $search_mob       = $this->security->xss_clean($this->input->post('search_mob'));
      $search_mail       = $this->security->xss_clean($this->input->post('search_mail'));
      $search_kiv       = $this->security->xss_clean($this->input->post('search_kiv'));
      $portofregistry_id  = $this->security->xss_clean($this->input->post('portofregistry_id'));
      if($user_type_id=='3')
      {
        if($search_id==1)
        {
          $transaction_details=$this->Survey_model->get_transaction_details_mob($portofregistry_id,$search_mob);
          $data['transaction_details']  = $transaction_details;
        }
        if($search_id==2)
        {
            $transaction_details=$this->Survey_model->get_transaction_details_email($portofregistry_id,$search_mail);
            $data['transaction_details']  = $transaction_details;
        }
      }
      else
      {
        if($search_id==1)
        {
          $transaction_details=$this->Survey_model->get_transaction_details_mob_ra($search_mob);
          $data['transaction_details']  = $transaction_details;
        }
        if($search_id==2)
        {
            $transaction_details=$this->Survey_model->get_transaction_details_email_ra($search_mail);
            $data['transaction_details']  = $transaction_details;
        }
        if($search_id==3)
        {
          $transaction_details=$this->Survey_model->get_transaction_details_kivnumber($search_kiv);
          $data['transaction_details']  = $transaction_details;
        }
      }
    }
    else
    {
      $no_data="0";
      $data['no_data']=$no_data;
    }
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/payment_search', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');

  }
}
public function tariff_list()
{
  $sess_usr_id    = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id=  $this->session->userdata('survey_user_id');

  $moduleid        = 2;
  $modenc          = $this->encrypt->encode($moduleid); 
  $modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
  if(!empty($sess_usr_id))
  {
    $this->load->model('Survey_model');
    $data         =   array('title' => 'tariff_list', 'page' => 'tariff_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data         =   $data + $this->data;  
    $survey_type              = $this->Survey_model->get_survey_master();
    $data['survey_type']      =   $survey_type;
     
    if($this->input->post())
    {
      $survey_sl1       = $this->security->xss_clean($this->input->post('survey_sl'));
      if($survey_sl1==TRUE)
      {
        foreach($survey_sl1 as $res1)
        {
          $survey_sl[] =$res1;
        }
        @$survey_sl2    = implode(", ",$survey_sl);
      }
    
      if($survey_sl2==0)
      {
        $tariff_list=$this->Survey_model->get_view_tariffList_view();
        $data['tariff_list']  = $tariff_list;
        
      }
      else
      {
        $tariff_list=$this->Survey_model->get_view_tariffList_view_sl($survey_sl2);
        $data['tariff_list']  = $tariff_list;

      }
    }

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/tariff_list', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');
  }
}
public function detViewTariff()
{
    $sess_usr_id    = $this->session->userdata('int_userid');
    $int_usertype   = $this->session->userdata('int_usertype');
    
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'detViewTariff', 'page' => 'detViewTariff', 'errorCls' => NULL, 'post' => $this->input->post());
    $data               =   $data + $this->data;     
    $activity_id        = $this->uri->segment(4);
    $form_id            = $this->uri->segment(5);
    $vessel_type_id     = $this->uri->segment(6);
    $vessel_subtype_id  = $this->uri->segment(7);
    $start_date         = $this->uri->segment(8);
    $end_date           = $this->uri->segment(9);
    $detTariffTable     = $this->Survey_model->get_det_tariffTable($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$start_date,$end_date);
    $data['detTariffTable'] = $detTariffTable;
    $data           =   $data + $this->data; //print_r($detTariffTable);
        
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/detViewTariff', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');
  }
  else
  {
    redirect('Main_login/index');        
  }  
    
}

public function number_plate_req()
{

  $sess_usr_id    = $this->session->userdata('int_userid');
  $int_usertype   = $this->session->userdata('int_usertype');
    
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'number_plate_req', 'page' => 'number_plate_req', 'errorCls' => NULL, 'post' => $this->input->post());
    $data               =   $data + $this->data; 

    $vessel_reg_reprint_req    =   $this->Survey_model->get_registered_vessels_rep_req($sess_usr_id);
    $data['vessel_reg_reprint_req'] = $vessel_reg_reprint_req;
    $data           =   $data + $this->data;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/number_plate_req_list_vo', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');

  } 
   else
  {
    redirect('Main_login/index');        
  }
}

function reprint_request(){ 
  $sess_usr_id    = $this->session->userdata('int_userid');
  $int_usertype   = $this->session->userdata('int_usertype');
  $date           = date('Y-m-d H:i:s');
    
  if(!empty($sess_usr_id))
  { 
    $id       = $this->security->xss_clean($this->input->post('id'));
    $reprint_reason       = $this->security->xss_clean($this->input->post('reprint_reason'));
    
  
    $data_vm = array('reprint_request_status'=>1);
    $updvessel_res    = $this->Survey_model->update_vessel_print_cnt($data_vm,$id);
    if($updvessel_res){

      $get_regn_plate_id = $this->Survey_model->get_reprint_id($id); //print_r($get_regn_plate_id);exit;
      $cnt_rw= count($get_regn_plate_id);
      if($cnt_rw!=0){
        $data_rp = array(
          'reprint_reqtimestamp'=>$date,
          'reprint_request_reason'=>$reprint_reason
        );
        $updregnplate_res    = $this->Survey_model->update_regn_plate($data_rp,$id);
        if($updregnplate_res){
           $success_msg = "Request Sent to Port Conservator!!!";
            echo json_encode(array("val_errors" => $success_msg, "status" => "true"));
        } 
       }  else {
        $data_plate =   array(
        'vessel_id ' => $id,
        'reprint_reqtimestamp' => $date,
        'reprint_request_reason'=>$reprint_reason
        ); 
        $vessel_regn_det  = $this->db->insert('tbl_registrationplate', $data_plate);
        if($vessel_regn_det){
          $success_msg1 = "Request Sent to Port Conservator!!!";
            echo json_encode(array("val_errors" => $success_msg1, "status" => "true"));
        }

       }
    }

    
  } 
   else
  {
    redirect('Main_login/index');        
  } 

}

function reprint_approve_list(){

  $sess_usr_id    = $this->session->userdata('int_userid');
  $int_usertype   = $this->session->userdata('int_usertype');
    
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'reprint_approve_list', 'page' => 'reprint_approve_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data               =   $data + $this->data;

    $user_port    =  $this->Survey_model->get_user_port_id($sess_usr_id);

    foreach($user_port as $user_port_res){
        $port     =   $user_port_res['user_master_port_id'];
    }

    $reprint_req_pc    =   $this->Survey_model->get_reprint_req_list_pc($port);
    $data['reprint_req_pc'] = $reprint_req_pc;
    $data           =   $data + $this->data;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/reprint_approve_list_pc', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');

  } 
   else
  {
    redirect('Main_login/index');        
  }

}

function reprint_req_det_Vw($idenc){

  $sess_usr_id    = $this->session->userdata('int_userid');
  $int_usertype   = $this->session->userdata('int_usertype');
    
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'reprint_approve_list', 'page' => 'reprint_approve_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data               =   $data + $this->data;

    $iden            = str_replace(array('-', '_', '~'), array('+', '/', '='), $idenc);
    $id              = $this->encrypt->decode($iden);

    $reprint_req_pc_dt    =   $this->Survey_model->get_vessel_details_id($id);
    $data['reprint_req_pc_dt'] = $reprint_req_pc_dt;
    $data           =   $data + $this->data;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/reprint_req_det_Vw', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');

  } 
   else
  {
    redirect('Main_login/index');        
  } 

}


function reprint_status_update(){

  $sess_usr_id    = $this->session->userdata('int_userid');
  $int_usertype   = $this->session->userdata('int_usertype');
  $date           = date('Y-m-d H:i:s');
    
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'reprint_approve_list', 'page' => 'reprint_approve_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data               =   $data + $this->data;

    $vessel_id    = $this->security->xss_clean($this->input->post('vessel_id'));
    $iden            = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id);
    $id              = $this->encrypt->decode($iden);
    $status       = $this->security->xss_clean($this->input->post('status'));

    if($status==2){
      $remarks  = $this->security->xss_clean($this->input->post('remarks'));
    } else {
      $remarks='';
    }
    if($status==''){
      $this->session->set_flashdata('resp_msg','<div class="alert alert-success text-center">!!!Updated Successfully!!!</div>');
      redirect('Kiv_Ctrl/Survey/reprint_req_det_Vw/id');
    } else {
    

      if($status==1){
        $data_upd_vm= array(
        'reprint_approve_status' => $status
        );

        $updvesselmain_res    = $this->Survey_model->update_vessel_print_cnt($data_upd_vm,$vessel_id);
        if($updvesselmain_res){
          $data_upd_rp= array(
          'reprint_approve_status' => $status,
          'reprint_approve_timestamp' => $date,
          'reprint_approvedby' => $sess_usr_id,
          'reprint_reason' => $remarks
        ); 
          $get_regn_plate_id = $this->Survey_model->get_reprint_id($vessel_id); //print_r($get_regn_plate_id);exit;
          foreach($get_regn_plate_id as $res){
            $sl = $res['print_sl'];
          }
          
          $updregnplate_res    = $this->Survey_model->update_regn_plate($data_upd_rp,$sl);
          if($updregnplate_res){
             $this->session->set_flashdata('resp_msg','<div class="alert alert-success text-center">!!!Updated Successfully!!!</div>');
             redirect('Kiv_Ctrl/Survey/reprint_approve_list');
          } 
        }
      } elseif($status==2) {

        $data_upd_vm= array(
         'reprint_request_status' => 0, 
        'reprint_approve_status' => $status
        );
        $updvesselmain_res    = $this->Survey_model->update_vessel_print_cnt($data_upd_vm,$vessel_id);
        if($updvesselmain_res){
          $data_upd_rp= array(
          'reprint_approve_status' => $status,
          'reprint_approve_timestamp' => $date,
          'reprint_approvedby' => $sess_usr_id,
          'reprint_status' => 0,
          'reprint_reason' => $remarks
        ); 
           $get_regn_plate_id = $this->Survey_model->get_reprint_id($id);
          foreach($get_regn_plate_id as $res){
            $sl = $res['print_sl'];
          }
          
          $updregnplate_res    = $this->Survey_model->update_regn_plate($data_upd_rp,$sl);
          if($updregnplate_res){
             $this->session->set_flashdata('resp_msg','<div class="alert alert-success text-center">!!!Updated Successfully!!!</div>');
             redirect('Kiv_Ctrl/Survey/reprint_approve_list');
          } 
        }

      } 
  }


    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/reprint_req_det_Vw', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');

  } 
   else
  {
    redirect('Main_login/index');        
  } 

}

function printed_list(){
  $sess_usr_id    = $this->session->userdata('int_userid');
  $int_usertype   = $this->session->userdata('int_usertype');
  $date           = date('Y-m-d H:i:s');
    
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'printed_list', 'page' => 'printed_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data               =   $data + $this->data;

    $user_port    =  $this->Survey_model->get_user_port_id($sess_usr_id);

    foreach($user_port as $user_port_res){
        $port     =   $user_port_res['user_master_port_id'];
    }
    //$id=1;
    $single_print    =   $this->Survey_model->get_registered_vessels($port);
    $data['single_print'] = $single_print;
    $data           =   $data + $this->data;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/printed_list_pc', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');

  } 
   else
  {
    redirect('Main_login/index');        
  }  


}
function pending_list(){
  $sess_usr_id    = $this->session->userdata('int_userid');
  $int_usertype   = $this->session->userdata('int_usertype');
  $date           = date('Y-m-d H:i:s');
    
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'pending_list', 'page' => 'pending_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data               =   $data + $this->data;

    $user_port    =  $this->Survey_model->get_user_port_id($sess_usr_id);

    foreach($user_port as $user_port_res){
        $port     =   $user_port_res['user_master_port_id'];
    }
    //$id=1;
    $single_print    =   $this->Survey_model->get_registered_vessels_pending($port);
    $data['single_print'] = $single_print;
    $data           =   $data + $this->data;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/pending_list_pc', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');

  } 
   else
  {
    redirect('Main_login/index');        
  }  


}
function reprinted_list(){
  $sess_usr_id    = $this->session->userdata('int_userid');
  $int_usertype   = $this->session->userdata('int_usertype');
  $date           = date('Y-m-d H:i:s');
    
  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'reprinted_list', 'page' => 'reprinted_list', 'errorCls' => NULL, 'post' => $this->input->post());
    $data               =   $data + $this->data;
    //$id=1;
    $user_port    =  $this->Survey_model->get_user_port_id($sess_usr_id);

    foreach($user_port as $user_port_res){
        $port     =   $user_port_res['user_master_port_id'];
    }
    $single_print    =   $this->Survey_model->get_registered_vessels_reprinted($port);
    $data['single_print'] = $single_print;
    $data           =   $data + $this->data;

    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/dash/reprinted_list_pc', $data);
    $this->load->view('Kiv_views/template/all-scripts.php');
    $this->load->view('Kiv_views/template/all-footer.php');

  } 
   else
  {
    redirect('Main_login/index');        
  }  


}
//_____________________end of model____________________________----//
}
