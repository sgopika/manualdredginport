<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surveyprocess extends CI_Controller {
	
	public function __construct()
    {
	parent::__construct();
	$this->load->library('session');
	$this->load->helper('form');
	$this->load->helper('url');
	$this->load->database();
	$this->load->library('form_validation');
	$this->load->helper('date');
    $this->load->library('upload');
	//$this->load->helper('Specifictable_helper');
	$this->load->library('encrypt');
	
	$this->data = array(
				'controller' 			=> 	$this->router->fetch_class(),
				'method' 				=> 	$this->router->fetch_method(),
				'session_userdata' 		=> 	isset($this->session->userdata) ? $this->session->userdata : '',
				'base_url' 				=> 	base_url(),
				'site_url'  			=> 	site_url(),
				'user_sl' 				=> 	isset($this->session->userdata['user_sl']) ? $this->session->userdata['user_sl'] : 0,
				'user_type_id' 			=> 	isset($this->session->userdata['user_type_id']) ? $this->session->userdata['user_type_id'] : 0,
				'customer_id' 			=> 	isset($this->session->userdata['customer_id']) ? $this->session->userdata['customer_id'] : 0,
				'survey_user_id' 		=> 	isset($this->session->userdata['survey_user_id']) ? $this->session->userdata['survey_user_id'] : 0,
		);
	$this->load->model('Kiv_models/Survey_model');
    }

	public function Logout()
    { 
        $this->session->sess_destroy();
        redirect('Main_login//index');
    }
	
	
		


/*____________________________________________________________________________________________________________________________________________*/

/*																FORM FIVE 																  */
/*____________________________________________________________________________________________________________________________________________*/
/*Starts, view form five (03-11-2018)*/

public function formfiveView_1()
{
	$sess_usr_id 	= 	$this->session->userdata('user_sl');
	$int_usertype	=	$this->session->userdata('user_type_id');
    $customer_id	=	$this->session->userdata('customer_id');
    $survey_user_id	=	$this->session->userdata('survey_user_id');
		
	//if(!empty($sess_usr_id))
	if(!empty($sess_usr_id)&&($sess_usr_id==4))
	{
		$data 			=	 array('title' => 'csHome', 'page' => 'csHome', 'errorCls' => NULL, 'post' => $this->input->post());
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

       
		//$this->load->view('SurveyProcess/viewForm5.php',$data);
                        
	    $this->load->view('template/dash-header.php');
	    $this->load->view('template/nav-header.php');
	    $this->load->view('dash/csForm5',$data);
	    $this->load->view('template/dash-footer.php');      
		  
	}
	else
	{
		redirect('Main_login//index');        
  	} 
}

//_____________________________________________//
public function formfiveView()
{
 $sess_usr_id 	 = 	$this->session->userdata('user_sl');
 $user_type_id			=	$this->session->userdata('user_type_id');
 $customer_id	      =	$this->session->userdata('customer_id');
 $survey_user_id	=	$this->session->userdata('survey_user_id');
 if(!empty($sess_usr_id)&&($sess_usr_id==4))
 {
    $data 			=	 array('title' => 'csHome', 'page' => 'csHome', 'errorCls' => NULL, 'post' => $this->input->post());
    $data 			=	 $data + $this->data;
    $this->load->model('Kiv_models/Survey_model');

    $vessel_details			= 	$this->Survey_model->get_vessel_details($sess_usr_id);
	$data['vessel_details']	=	$vessel_details;
	$count	= count($vessel_details);
	$data['count']=$count;

    $this->load->view('template/dash-header.php');
    $this->load->view('template/nav-header.php');
    $this->load->view('dash/cs',$data);
    $this->load->view('template/dash-footer.php');

}
else
{
    redirect('Main_login//index');        
} 


}

/*Ends view form five(03-11-2018)*/
/*____________________________________________________________________________________________________________________________________________*/

function saveTab1_org()
{
    
  $sess_usr_id  =   $this->session->userdata('user_sl');
  $user_type_id = $this->session->userdata('user_type_id');
  $customer_id  = $this->session->userdata('customer_id');
  $survey_user_id = $this->session->userdata('survey_user_id');

  if(!empty($sess_usr_id))
  { 
    $data = array('title' => 'form1', 'page' => 'form1', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;

    $this->form_validation->set_rules('vessel_name', 'Vessel Name', 'required');
    $this->form_validation->set_rules('vessel_expected_completion', 'Vessel Expected completion', 'required');
    $this->form_validation->set_rules('vessel_category_id', 'Vessel Category', 'required');
    //$this->form_validation->set_rules('vessel_subcategory_id', 'Vessel Sub Category', 'required');


  if ($this->form_validation->run() == FALSE)
  {

    $valErrors  =   validation_errors();
    echo json_encode(array("val_errors" => $valErrors));
    exit;
  }   
    else  
  {   
  }
        
         
                       
    $vessel_name                = $this->input->post('vessel_name');
    $vessel_expected_completion = $this->input->post('vessel_expected_completion');
    $vessel_category_id         = $this->input->post('vessel_category_id');
    $vessel_subcategory_id      = $this->input->post('vessel_subcategory_id');
    $vessel_type_id             = $this->input->post('vessel_type_id');
    $vessel_subtype_id          = $this->input->post('vessel_subtype_id');
    $vessel_length_overall      = $this->input->post('vessel_length_overall');
    $vessel_length              = $this->input->post('vessel_length');
    $vessel_breadth             = $this->input->post('vessel_breadth');
    $vessel_depth               = $this->input->post('vessel_depth');
    $month_id                   = $this->input->post('month_id');
    $vessel_tonnage             = round(($vessel_length*$vessel_breadth*$vessel_depth)/2.83);

    $vessel_upperdeck_length    = $this->input->post('vessel_upperdeck_length');
    $vessel_upperdeck_breadth   = $this->input->post('vessel_upperdeck_breadth');
    $vessel_upperdeck_depth     = $this->input->post('vessel_upperdeck_depth');
    $vessel_no_of_deck          = $this->input->post('vessel_no_of_deck');


    $vessel_upperdeck_tonnage   = round(($vessel_upperdeck_length*$vessel_upperdeck_breadth*$vessel_upperdeck_depth)/2.83);
    $vessel_total_tonnage       = $vessel_tonnage+$vessel_upperdeck_tonnage;   


 $hullmaterial_id= $this->input->post('hullmaterial_id');
 $engine_placement_id= $this->input->post('engine_placement_id');

 
                
        $ip     = $_SERVER['REMOTE_ADDR'];
        date_default_timezone_set("Asia/Kolkata");
        $date   =   date('Y-m-d h:i:s', time());

$data_vessel_details = array(
    
   // 'vessel_user_id'            =>  $customer_id,
    'vessel_user_id'            =>  $sess_usr_id,
    'vessel_name'               =>  $vessel_name, 
    'vessel_category_id'        =>  $vessel_category_id,
    'vessel_subcategory_id'     =>  $vessel_subcategory_id,
    'vessel_type_id'            =>  $vessel_type_id,
    'vessel_subtype_id'         =>  $vessel_subtype_id,
    'vessel_length_overall'     =>  $vessel_length_overall,
    'vessel_no_of_deck'         =>  $vessel_no_of_deck,
    'vessel_length'             =>  $vessel_length,
    'vessel_breadth'            =>  $vessel_breadth,
    'vessel_depth'              =>  $vessel_depth,
    'month_id'                  =>  $month_id,
    'vessel_expected_completion'=>  $vessel_expected_completion,
    'vessel_expected_tonnage'   =>  $vessel_tonnage,
    'vessel_upperdeck_length'   =>  $vessel_upperdeck_length,
    'vessel_upperdeck_breadth'  =>  $vessel_upperdeck_breadth,
    'vessel_upperdeck_depth'    =>  $vessel_upperdeck_depth,
    'vessel_upperdeck_tonnage'  =>  $vessel_upperdeck_tonnage,
    'vessel_total_tonnage'      =>  $vessel_total_tonnage,
    'vessel_created_user_id'    =>  $sess_usr_id,
    'vessel_created_timestamp'  =>  $date,
    'vessel_created_ipaddress'  =>  $ip
      );

$vessel_res   = $this->db->insert('tbl_kiv_vessel_details', $data_vessel_details);
$vessel_id    =   $this->db->insert_id();
      

                
    $var_stage=array(
    'vessel_id'   =>  $vessel_id,  
    'form'        =>  1,
    'stage'       =>  1,
    'stage_count' =>  1   
    );
 $stage_res = $this->db->insert('tbl_kiv_form_stage', $var_stage); 
          
      
           
        }
        
   // } //
         $form_id=1;
    $heading_id=2;


    $hullplating_material       =   $this->Survey_model->get_hullplating_material();
    $data1['hullplating_material']  = $hullplating_material;

    $bulk_head_placement      =   $this->Survey_model->get_bulk_head_placement();
    $data1['bulk_head_placement'] = $bulk_head_placement; 

   


    $length_overthedeck     =   $this->Survey_model->get_length_overthedeck($vessel_type_id,$vessel_subtype_id,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id);
    $data1['length_overthedeck']  = $length_overthedeck;

    //print_r($length_overthedeck);

    foreach ($length_overthedeck as $key ) 
    {
      $length_over_deck1=$key['length_over_deck'];

      if($vessel_length>=$length_over_deck1)
      {
        $vessel_length1=$vessel_length;
      }
      else
      {
        $vessel_length1=$length_over_deck1;
      }
    }

$this->session->set_userdata(array(
    'vessel_id'     => $vessel_id,
    'vessel_type_id'  =>$vessel_type_id,
    'vessel_subtype_id' =>$vessel_subtype_id,
    'vessel_length'=>$vessel_length1,
    'engine_placement_id'=>$engine_placement_id,
    'hullmaterial_id'=>$hullmaterial_id
      
)); 


$label_control_details      =   $this->Survey_model->get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length1,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id);
$data1['label_control_details'] = $label_control_details;


            

      $this->load->view('Ajax_hull_show.php',$data1);         
      
        }
/*____________________________________________________________________________________________________________________________________________*/

public function formfiveLoad()
{
  	$sess_usr_id 		= 	$this->session->userdata('user_sl');
  
  	$user_type_id		=	$this->session->userdata('user_type_id');
  	$customer_id		=	$this->session->userdata('customer_id');
  	$survey_user_id	    =	$this->session->userdata('survey_user_id');

 

  	//if(!empty($sess_usr_id) && (($sess_usr_id==4) || ($sess_usr_id==2)))
    if(!empty($sess_usr_id) && (($user_type_id==4) || ($user_type_id==5)))
  	{

  		$data 			=	 array('title' => 'loadForm5', 'page' => 'loadForm5', 'errorCls' => NULL, 'post' => $this->input->post());
  		$data 			=	 $data + $this->data;
  		$this->load->model('Kiv_models/Survey_model');
		 
        //----------- Login Details-----//


        //----------Owner Details--------------//
        $user			 = 	$this->Survey_model->get_user($customer_id);
        $data['user']    =	$user;


        $agent			 = 	$this->Survey_model->get_agent($customer_id);
        $data['agent']	 =	$agent;
        //-------Vessel Details---------------//

        /*$form_id=5;
        $heading=10;
        $vesselType=2;
        $vesselSubtype=10;
        $lengthOverDeck=15;
        $hull_id=9999;
        $engine_id=9999;
        $startDate='2012-12-12';
        $endDate='0000-00-00';

        $allFields = $this->Survey_model->get_labels($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
        $data['allFields']  =  $allFields;*///print_r($allFields);//exit;

        $vesselId=290;
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
        $data['fieldstoShow']    =  $fieldstoShow;//print_r($allFields);//exit;get_labels();

       	$conditionofItem         = 	$this->Survey_model->get_condition();
        $data['conditionofItem'] =	$conditionofItem;

   	   
		$this->load->view('template/form-header.php');
		$this->load->view('template/nav-header.php');
		$this->load->view('SurveyProcess/loadForm5', $data);
		$this->load->view('template/form-footer.php');
					
	}
    else
    {
            redirect('Kiv_Ctrl/Survey/SurveyorHome');        
    } 
}

/*____________________________________________________________________________________________________________________________________________*/

function saveTab1()
{
    //echo "hiii";
    $sess_usr_id        =   $this->session->userdata('user_sl');
    $user_type_id       =   $this->session->userdata('user_type_id');
    $customer_id        =   $this->session->userdata('customer_id');
    $survey_user_id     =   $this->session->userdata('survey_user_id');

    $ip     = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date   =   date('Y-m-d h:i:s', time()); 

    //if(!empty($sess_usr_id)&&($sess_usr_id==4))    
    if(!empty($sess_usr_id) && (($user_type_id==4) || ($user_type_id==5)))
    {
    $data = array('title' => 'form1', 'page' => 'form1', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data;

    $this->form_validation->set_rules('grt', 'Gross Registered Tonnage', 'required|callback_float_check');
    $this->form_validation->set_rules('nrt', 'Net Registered Tonnage', 'required|callback_float_check');
    $this->form_validation->set_rules('placeofBuild', 'Place of build', 'required|callback_alphanum_check');
    $this->form_validation->set_rules('dateofBuild', 'Date of build', 'required|callback_date_check');

        if ($this->form_validation->run() == FALSE)
        {
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
        echo "val_errors";
        //redirect('Master/add_dynamic_form');        
        //$valErrors=validation_errors();
        //echo json_encode(array("val_errors" => $valErrors));
        //exit($valErrors);
        }   
        else  
        { 
        /*get data from first tab*/
        
        $grt           = $this->input->post('grt');
        $nrt           = $this->input->post('nrt');
        $placeofBuild  = $this->input->post('placeofBuild');
        $dateofBuild   = $this->input->post('dateofBuild');
        $vessel_sl     = $this->input->post('hdn_vesselId');
        /*get data from first tab*/

        $data = array(
                'grt'                        =>  $grt,  
                'nrt'                        =>  $nrt,
                'build_place'                =>  $placeofBuild,
                'build_date'                 =>  $dateofBuild,
                'vessel_modified_user_id'    =>  $sess_usr_id,
                'vessel_modified_timestamp'  =>  $date,
                'vessel_modified_ipaddress'  =>  $ip
        );

        $data  = $this->security->xss_clean($data);     
        $this->db->where('vessel_sl', $vessel_sl);
        $usr_res=$this->db->update('tbl_kiv_vessel_details', $data);
                    

        /*Load the next tab, hull details*/        
        $form_id=5;
        $heading=11;
        $data['vesselId']=$vessel_sl;


        $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_sl);
        $data['vessDetails']  = $vessDetails;//print_r($vessDetails);//exit; 

        $vesselType     = $vessDetails[0]['vessel_type_id'];
        $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
        $lengthOverDeck = $vessDetails[0]['vessel_length'];
        $engine_id      = $vessDetails[0]['engine_placement_id'];
        $hull_id        = $vessDetails[0]['hullmaterial_id'];

        $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
        $data['fieldstoShow']    =  $fieldstoShow;//print_r($allFields);//exit;get_labels();


        $conditionofItem         =  $this->Survey_model->get_condition();
        $data['conditionofItem'] =  $conditionofItem;
        $this->load->model('Kiv_models/Survey_model');

        $this->load->view('SurveyProcess/Ajax_hullDetails_form5.php',$data);
        /*Load the next tab, hull details*/
        }
    }
    else
    {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');        
    } 
}
/*____________________________________________________________________________________________________________________________________________*/
function saveTab2()
{
    //echo "hiii";
    $sess_usr_id        =   $this->session->userdata('user_sl');
    $user_type_id       =   $this->session->userdata('user_type_id');
    $customer_id        =   $this->session->userdata('customer_id');
    $survey_user_id     =   $this->session->userdata('survey_user_id');

    $ip     = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date   =   date('Y-m-d h:i:s', time()); 

       
    if(!empty($sess_usr_id) && (($user_type_id==4) || ($user_type_id==5)))
    {
    $data = array('title' => 'form2', 'page' => 'form2', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 

    $this->form_validation->set_rules('lengthIdentification', 'Identification Length', 'required|callback_float_check');
    $this->form_validation->set_rules('conditionofHull', 'Condition of Hull', 'required');

        if ($this->form_validation->run() == FALSE)
        {
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
        echo "val_errors";
        }   
        else  
        {
        /*get data from first tab*/        
        $lengthIdentification = $this->input->post('lengthIdentification');
        $conditionofHull      = $this->input->post('conditionofHull');
        $vessel_sl            = $this->input->post('hdn_vesselId');
        /*get data from first tab*/

        $data = array(
                'identification_length'    =>  $lengthIdentification,  
                'hull_condition_status_id' =>  $conditionofHull,
                'hull_modified_user_id'    =>  $sess_usr_id,
                'hull_modified_timestamp'  =>  $date,
                'hull_modified_ipaddress'  =>  $ip
        );

        $data  = $this->security->xss_clean($data);     
        $this->db->where('vessel_id', $vessel_sl);
        $usr_res=$this->db->update('tbl_kiv_hulldetails', $data);
                    

        /*Load the next tab, particulars of engine*/
        $form_id=5;
        $heading=12;
        $data['vesselId']=$vessel_sl;


        $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_sl);
        $data['vessDetails']  = $vessDetails;//print_r($vessDetails);//exit; 

        $vesselType     = $vessDetails[0]['vessel_type_id'];
        $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
        $lengthOverDeck = $vessDetails[0]['vessel_length'];
        $engine_id      = $vessDetails[0]['engine_placement_id'];
        $hull_id        = $vessDetails[0]['hullmaterial_id'];

        $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
        $data['fieldstoShow']    =  $fieldstoShow;//print_r($allFields);//exit;get_labels();


        $conditionofItem         =  $this->Survey_model->get_condition();
        $data['conditionofItem'] =  $conditionofItem;

        $meansofPropulsionShaft         =  $this->Survey_model->get_meansofpropulsionShaft();
        $data['meansofPropulsionShaft'] =  $meansofPropulsionShaft; 

        $engineType         =  $this->Survey_model->get_enginetype();
        $data['engineType'] =  $engineType; 

        $this->load->model('Kiv_models/Survey_model');

        $this->load->view('SurveyProcess/Ajax_particularsofEngine_form5.php',$data);
        /*Load the next tab, particulars of engine*/
        }
    }
    else
    {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');        
    } 

    
}

function saveTab3()
{
    //echo "hiii";exit;
    $sess_usr_id        =   $this->session->userdata('user_sl');
    $user_type_id       =   $this->session->userdata('user_type_id');
    $customer_id        =   $this->session->userdata('customer_id');
    $survey_user_id     =   $this->session->userdata('survey_user_id');

    $ip     = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date   =   date('Y-m-d h:i:s', time()); 

       
    if(!empty($sess_usr_id) && (($user_type_id==4) || ($user_type_id==5)))
    {
    $data = array('title' => 'form3', 'page' => 'form3', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 

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
        $meansofpropulsion_shaft    = $this->input->post('meansofpropulsion_shaft');
        $propeller_shaft_drawn_date = $this->input->post('propeller_shaft_drawn_date');        
        $horsepowerofEngine         = $this->input->post('horsepowerofEngine');
        $conditionofMachinery       = $this->input->post('conditionofMachinery');       
        $engine_description         = $this->input->post('engine_description');
        $dateofConstruction         = $this->input->post('dateofConstruction');       
        $modelNumber                = $this->input->post('modelNumber');
        $vessel_sl                  = $this->input->post('hdn_vesselId');
        /*get data from first tab*/

        $data = array(
                'propulsion_means_id'        =>  $meansofpropulsion_shaft,  
                'propeller_shaft_drawn'      =>  $propeller_shaft_drawn_date,  
                'horsepowerofEngine'         =>  $horsepowerofEngine,
                'engine_condition_id'        =>  $conditionofMachinery,
                'engine_description'         =>  $engine_description,
                'dateofConstruction'         =>  $dateofConstruction,
                'model_number'               =>  $modelNumber, 
                'engine_modified_user_id'    =>  $sess_usr_id,
                'engine_modified_timestamp'  =>  $date,
                'engine_modified_ipaddress'  =>  $ip
        );

        $data  = $this->security->xss_clean($data);     
        $this->db->where('vessel_id', $vessel_sl);
        $usr_res=$this->db->update('tbl_kiv_engine_details', $data);
                    

        /*Load the next tab, particulars of engine*/
        $form_id=5;
        $heading=13;
        $data['vesselId']=$vessel_sl;


        $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_sl);
        $data['vessDetails']  = $vessDetails;//print_r($vessDetails);exit; 

        $vesselType     = $vessDetails[0]['vessel_type_id'];
        $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
        $lengthOverDeck = $vessDetails[0]['vessel_length'];
        $engine_id      = $vessDetails[0]['engine_placement_id'];
        $hull_id        = $vessDetails[0]['hullmaterial_id'];

        $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
        $data['fieldstoShow']    =  $fieldstoShow;//print_r($fieldstoShow);exit;//get_labels();

        $conditionofItem         =  $this->Survey_model->get_condition();
        $data['conditionofItem'] =  $conditionofItem;

        $meansofPropulsionShaft         =  $this->Survey_model->get_meansofpropulsionShaft();
        $data['meansofPropulsionShaft'] =  $meansofPropulsionShaft; 

        $engineType         =  $this->Survey_model->get_enginetype();
        $data['engineType'] =  $engineType; 

        $eqpmtMaterial          =  $this->Survey_model->get_equipmentMaterial();
        $data['eqpmtMaterial']  =  $eqpmtMaterial;

        $plnCntrlDevice         =  $this->Survey_model->get_pollutionControldevice();
        $data['plnCntrlDevice'] =  $plnCntrlDevice;

        $this->load->model('Kiv_models/Survey_model');


        $this->load->view('SurveyProcess/Ajax_machine_form5.php',$data);
        //}
    }
    else
    {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');        
    } 

}

function saveTab4()
{
    //echo "hiii";
    //echo "hiii";exit;
    $sess_usr_id        =   $this->session->userdata('user_sl');
    $user_type_id       =   $this->session->userdata('user_type_id');
    $customer_id        =   $this->session->userdata('customer_id');
    $survey_user_id     =   $this->session->userdata('survey_user_id');

    $ip     = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date   =   date('Y-m-d h:i:s', time()); 

       
    if(!empty($sess_usr_id) && (($user_type_id==4) || ($user_type_id==5)))
    {
    $data = array('title' => 'form4', 'page' => 'form4', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 

    /*$this->form_validation->set_rules('meansofpropulsion_shaft', 'Means of propulsion shaft', 'required');
    $this->form_validation->set_rules('propeller_shaft_drawn_date', 'Propeller shaft last drawn', 'required');
    $this->form_validation->set_rules('horsepowerofEngine', 'Total horse power of main engine', 'required');
    $this->form_validation->set_rules('conditionofMachinery', 'Condition of machinery', 'required');
    $this->form_validation->set_rules('engine_description', 'Description of engine', 'required');
    $this->form_validation->set_rules('dateofConstruction', 'Propeller shaft last drawn', 'required');
    //$this->form_validation->set_rules('modelNumber', 'Model Number', 'required');

        if ($this->form_validation->run() == FALSE)
        {
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
        echo "val_errors";
        }   
        else  
        {
        /*get data from first tab*/        
        /*$meansofpropulsion_shaft    = $this->input->post('meansofpropulsion_shaft');
        $propeller_shaft_drawn_date = $this->input->post('propeller_shaft_drawn_date');        
        $horsepowerofEngine         = $this->input->post('horsepowerofEngine');
        $conditionofMachinery       = $this->input->post('conditionofMachinery');       
        $engine_description         = $this->input->post('engine_description');
        $dateofConstruction         = $this->input->post('dateofConstruction');       
        $modelNumber                = $this->input->post('modelNumber');
        $vessel_sl                  = $this->input->post('hdn_vesselId');*/
        /*get data from first tab*/

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
                'engine_modified_ipaddress'  =>  $ip
        );

        $data  = $this->security->xss_clean($data);     
        $this->db->where('vessel_id', $vessel_sl);
        $usr_res=$this->db->update('tbl_kiv_engine_details', $data);*/
                    
        /*Load the next tab, Machine*/
        $form_id=5;
        $heading=14;
        $vessel_sl                  = $this->input->post('hdn_vesselId');
        $data['vesselId']=$vessel_sl;

        $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_sl);
        $data['vessDetails']  = $vessDetails;//print_r($vessDetails);//exit; 

        $vesselType     = $vessDetails[0]['vessel_type_id'];
        $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
        $lengthOverDeck = $vessDetails[0]['vessel_length'];
        $engine_id      = $vessDetails[0]['engine_placement_id'];
        $hull_id        = $vessDetails[0]['hullmaterial_id'];

        $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
        $data['fieldstoShow']    =  $fieldstoShow;//print_r($fieldstoShow);//exit;get_labels();

        $crewType         =  $this->Survey_model->get_crewType();
        $data['crewType'] =  $crewType;

        $crewClass         =  $this->Survey_model->get_crewClass();
        $data['crewClass'] =  $crewClass;

        $this->load->model('Kiv_models/Survey_model');
        $this->load->view('SurveyProcess/Ajax_crewDetails_form5.php',$data);
        /*Load the next tab, Machine*/
        //}
    }
    else
    {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');        
    } 
}

function saveTab5()
{
    //echo "hiii";
    $sess_usr_id        =   $this->session->userdata('user_sl');
    $user_type_id       =   $this->session->userdata('user_type_id');
    $customer_id        =   $this->session->userdata('customer_id');
    $survey_user_id     =   $this->session->userdata('survey_user_id');

    $ip     = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date   =   date('Y-m-d h:i:s', time()); 

       
    if(!empty($sess_usr_id) && (($user_type_id==4) || ($user_type_id==5)))
    {
    $data = array('title' => 'form5', 'page' => 'form5', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 

    /*$this->form_validation->set_rules('crew_type', 'Crew Type', 'required');
    $this->form_validation->set_rules('crewName', 'Crew Name', 'required');
    $this->form_validation->set_rules('crew_class', 'Crew Class', 'required');
    $this->form_validation->set_rules('crewLicenseNumber', 'Crew License Number', 'required');

        if ($this->form_validation->run() == FALSE)
        {
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
        echo "val_errors";
        }   
        else  
        {
        /*get data from fifth tab*/        
        /*$crew_type       = $this->input->post('crew_type');
        $crewName          = $this->input->post('crewName');        
        $crew_class        = $this->input->post('crew_class');
        $crewLicenseNumber = $this->input->post('crewLicenseNumber');*/
        /*get data from fifth tab*/

        /*$data = array(
                'propulsion_means_id'        =>  $crew_type,  
                'propeller_shaft_drawn'      =>  $crewName,  
                'horsepowerofEngine'         =>  $crew_class,
                'engine_condition_id'        =>  $crewLicenseNumber,
                'crew_modified_user_id'      =>  $sess_usr_id,
                'crew_modified_timestamp'    =>  $date,
                'crew_modified_ipaddress'    =>  $ip
        );

        $data  = $this->security->xss_clean($data);     
        $this->db->where('vessel_id', $vessel_sl);
        $usr_res=$this->db->update('tbl_kiv_engine_details', $data);*/
                    
        /*Load the next tab, Machine*/
        $form_id=5;
        $heading=15;
        $vessel_sl                  = $this->input->post('hdn_vesselId');
        $data['vesselId']=$vessel_sl;

        $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_sl);
        $data['vessDetails']  = $vessDetails;//print_r($vessDetails);//exit; 

        $vesselType     = $vessDetails[0]['vessel_type_id'];
        $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
        $lengthOverDeck = $vessDetails[0]['vessel_length'];
        $engine_id      = $vessDetails[0]['engine_placement_id'];
        $hull_id        = $vessDetails[0]['hullmaterial_id'];

        $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
        $data['fieldstoShow']    =  $fieldstoShow;//print_r($fieldstoShow);//exit;get_labels();
        $crewClass         =  $this->Survey_model->get_crewClass();
        $data['crewClass'] =  $crewClass;

        $this->load->model('Kiv_models/Survey_model');
        $this->load->view('SurveyProcess/Ajax_passengerDetails_form5.php',$data);
        /*Load the next tab, Machine*/
        //}
    }
    else
    {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');        
    } 
}

function saveTab6()
{
    //echo "hiii";
    $sess_usr_id        =   $this->session->userdata('user_sl');
    $user_type_id       =   $this->session->userdata('user_type_id');
    $customer_id        =   $this->session->userdata('customer_id');
    $survey_user_id     =   $this->session->userdata('survey_user_id');

    $ip     = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date   =   date('Y-m-d h:i:s', time()); 

       
    if(!empty($sess_usr_id) && (($user_type_id==4) || ($user_type_id==5)))
    {
    $data = array('title' => 'form6', 'page' => 'form6', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 

    /*$this->form_validation->set_rules('crew_type', 'Crew Type', 'required');
    $this->form_validation->set_rules('crewName', 'Crew Name', 'required');
    $this->form_validation->set_rules('crew_class', 'Crew Class', 'required');
    $this->form_validation->set_rules('crewLicenseNumber', 'Crew License Number', 'required');

        if ($this->form_validation->run() == FALSE)
        {
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
        echo "val_errors";
        }   
        else  
        {
        /*get data from fifth tab*/        
        /*$crew_type       = $this->input->post('crew_type');
        $crewName          = $this->input->post('crewName');        
        $crew_class        = $this->input->post('crew_class');
        $crewLicenseNumber = $this->input->post('crewLicenseNumber');*/
        /*get data from fifth tab*/

        /*$data = array(
                'propulsion_means_id'        =>  $crew_type,  
                'propeller_shaft_drawn'      =>  $crewName,  
                'horsepowerofEngine'         =>  $crew_class,
                'engine_condition_id'        =>  $crewLicenseNumber,
                'crew_modified_user_id'      =>  $sess_usr_id,
                'crew_modified_timestamp'    =>  $date,
                'crew_modified_ipaddress'    =>  $ip
        );

        $data  = $this->security->xss_clean($data);     
        $this->db->where('vessel_id', $vessel_sl);
        $usr_res=$this->db->update('tbl_kiv_engine_details', $data);*/
                    
        /*Load the next tab, Condition of service*/
        $form_id=5;/*On fifth form*/
        $heading=16;/*Under 16th heading*/
        $vessel_sl                  = $this->input->post('hdn_vesselId');//exit;
        $vessel_sl=290;
        $data['vesselId']=$vessel_sl;

        $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_sl);
        $data['vessDetails']  = $vessDetails;//print_r($vessDetails);//exit; 

        echo $vesselType     = $vessDetails[0]['vessel_type_id'];
        echo $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
        echo $lengthOverDeck = $vessDetails[0]['vessel_length'];
        echo $engine_id      = $vessDetails[0]['engine_placement_id'];
        echo $hull_id        = $vessDetails[0]['hullmaterial_id'];

        $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
        $data['fieldstoShow']    =  $fieldstoShow;//print_r($fieldstoShow);//exit;get_labels();
        
        $this->load->model('Kiv_models/Survey_model');
        $this->load->view('SurveyProcess/Ajax_conditionofService_form5.php',$data);
        //}
    }
    else
    {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');        
    } 
}

function saveTab7()
{
    //echo "hiii";
    //echo "hiii";
    $sess_usr_id        =   $this->session->userdata('user_sl');
    $user_type_id       =   $this->session->userdata('user_type_id');
    $customer_id        =   $this->session->userdata('customer_id');
    $survey_user_id     =   $this->session->userdata('survey_user_id');

    $ip     = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date   =   date('Y-m-d h:i:s', time()); 

       
    if(!empty($sess_usr_id) && (($user_type_id==4) || ($user_type_id==5)))
    {
    $data = array('title' => 'form7', 'page' => 'form7', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 

    /*$this->form_validation->set_rules('crew_type', 'Crew Type', 'required');
    $this->form_validation->set_rules('crewName', 'Crew Name', 'required');
    $this->form_validation->set_rules('crew_class', 'Crew Class', 'required');
    $this->form_validation->set_rules('crewLicenseNumber', 'Crew License Number', 'required');

        if ($this->form_validation->run() == FALSE)
        {
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
        echo "val_errors";
        }   
        else  
        {
        /*get data from fifth tab*/        
        /*$crew_type       = $this->input->post('crew_type');
        $crewName          = $this->input->post('crewName');        
        $crew_class        = $this->input->post('crew_class');
        $crewLicenseNumber = $this->input->post('crewLicenseNumber');*/
        /*get data from fifth tab*/

        /*$data = array(
                'propulsion_means_id'        =>  $crew_type,  
                'propeller_shaft_drawn'      =>  $crewName,  
                'horsepowerofEngine'         =>  $crew_class,
                'engine_condition_id'        =>  $crewLicenseNumber,
                'crew_modified_user_id'      =>  $sess_usr_id,
                'crew_modified_timestamp'    =>  $date,
                'crew_modified_ipaddress'    =>  $ip
        );

        $data  = $this->security->xss_clean($data);     
        $this->db->where('vessel_id', $vessel_sl);
        $usr_res=$this->db->update('tbl_kiv_engine_details', $data);*/
                    
        /*Load the next tab, Machine*/
        $form_id=5;
        $heading=17;
        $vessel_sl                  = $this->input->post('hdn_vesselId');$vessel_sl=290;
        $data['vesselId']=$vessel_sl;

        $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_sl);
        $data['vessDetails']  = $vessDetails;//print_r($vessDetails);//exit; 

        $vesselType     = $vessDetails[0]['vessel_type_id'];
        $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
        $lengthOverDeck = $vessDetails[0]['vessel_length'];
        $engine_id      = $vessDetails[0]['engine_placement_id'];
        $hull_id        = $vessDetails[0]['hullmaterial_id'];

        $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
        $data['fieldstoShow']    =  $fieldstoShow;//print_r($fieldstoShow);//exit;get_labels();
        $crewClass         =  $this->Survey_model->get_crewClass();
        $data['crewClass'] =  $crewClass;
	    $crewClass         =  $this->Survey_model->get_crewClass();
	    $data['crewClass'] =  $crewClass;
	    
	    $this->load->model('Kiv_models/Survey_model');
	    $this->load->view('SurveyProcess/Ajax_declaration_form5.php',$data);
	    /*Load the next tab, Machine*/
	        //}
    }
    else
    {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');        
    } 
}



function saveTab8()
{
    //echo "hiii";
    $sess_usr_id        =   $this->session->userdata('user_sl');
    $user_type_id       =   $this->session->userdata('user_type_id');
    $customer_id        =   $this->session->userdata('customer_id');
    $survey_user_id     =   $this->session->userdata('survey_user_id');

    $ip     = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Asia/Kolkata");
    $date   =   date('Y-m-d h:i:s', time()); 

       
    if(!empty($sess_usr_id) && (($user_type_id==4) || ($user_type_id==5)))
    {
    $data = array('title' => 'form8', 'page' => 'form8', 'errorCls' => NULL, 'post' => $this->input->post());
    $data = $data + $this->data; 

    $this->form_validation->set_rules('dateofInspection', 'Date of Inspection', 'required|callback_date_check');
    $this->form_validation->set_rules('machineryValDate', 'Validity of the machinery', 'required|callback_date_check');
    $this->form_validation->set_rules('hullValDate', 'Validity of the hull', 'required|callback_date_check');
    $this->form_validation->set_rules('declarationDate', 'Declaration date', 'required|callback_date_check');

        if ($this->form_validation->run() == FALSE)
        {
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">'. validation_errors().'</div>');
        echo "val_errors";
        }   
        else  
        {
        /*get data from eight tab*/        
        $dateofInspection = $this->input->post('dateofInspection');
        $machineryValDate 	= $this->input->post('machineryValDate');        
        $hullValDate     	= $this->input->post('hullValDate');
        $declarationDate 	= $this->input->post('declarationDate');
        $vessel_sl          = $this->input->post('hdn_vesselId');print_r($_POST);exit;
        /*get data from eight tab*/

        /*$data = array(
                'propulsion_means_id'        =>  $dateofInspection,  
                'propeller_shaft_drawn'      =>  $machineryValDate,  
                'horsepowerofEngine'         =>  $hullValDate,
                'engine_condition_id'        =>  $declarationDate,
                'crew_modified_user_id'      =>  $sess_usr_id,
                'crew_modified_timestamp'    =>  $date,
                'crew_modified_ipaddress'    =>  $ip
        );

        $data  = $this->security->xss_clean($data);     
        $this->db->where('vessel_id', $vessel_sl);
        $usr_res=$this->db->update('tbl_kiv_engine_details', $data);*/
                    
        /*Load the next tab, Machine*/
        $form_id=5;
        $heading=17;
        $vessel_sl                  = $this->input->post('hdn_vesselId');$vessel_sl=290;
        $data['vesselId']=$vessel_sl;

        $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_sl);
        $data['vessDetails']  = $vessDetails;//print_r($vessDetails);//exit; 

        $vesselType     = $vessDetails[0]['vessel_type_id'];
        $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
        $lengthOverDeck = $vessDetails[0]['vessel_length'];
        $engine_id      = $vessDetails[0]['engine_placement_id'];
        $hull_id        = $vessDetails[0]['hullmaterial_id'];

        $fieldstoShow = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck,$hull_id,$engine_id,$form_id,$heading);
        $data['fieldstoShow']    =  $fieldstoShow;//print_r($fieldstoShow);//exit;get_labels();
        $crewClass         =  $this->Survey_model->get_crewClass();
        $data['crewClass'] =  $crewClass;
	    $crewClass         =  $this->Survey_model->get_crewClass();
	    $data['crewClass'] =  $crewClass;
	    
	    $this->load->model('Kiv_models/Survey_model');
	    $this->load->view('SurveyProcess/Ajax_declaration_form5.php',$data);
	    /*Load the next tab, Machine*/
	    }
    }
    else
    {
        redirect('Kiv_Ctrl/Survey/SurveyorHome');        
    } 
}
/*____________________________________________________________________________________________________________________________________________*/



/*____________________________________________________________________________________________________________________________________________*/

//						VALIDATION (21-06-2018)
/*____________________________________________________________________________________________________________________________________________*/

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
/*____________________________________________________________________________________________________________________________________________*/

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
/*____________________________________________________________________________________________________________________________________________*/

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
/*____________________________________________________________________________________________________________________________________________*/

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

/*____________________________________________________________________________________________________________________________________________*/

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
/*____________________________________________________________________________________________________________________________________________*/

function float_check($str)
{
    if($str!='')
    {
        
    if (!preg_match("/^[0-9\.]+$/i", $str))
        {
        $this->form_validation->set_message('float_check', 'The %s field must contain only Numbers and Decimal point.');
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
/*____________________________________________________________________________________________________________________________________________*/
function date_check($str)
{
    if($str!='')
    {
        
        if (!preg_match("/^[0-9]{1,}[0-9\/]+$/i", $str))
        {
            $this->form_validation->set_message('date_check', 'The %s field must contain only Number and Slash.');
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
/*____________________________________________________________________________________________________________________________________________*/

}
