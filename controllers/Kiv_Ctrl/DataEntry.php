<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DataEntry extends CI_Controller {
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
	$this->load->library('encrypt');
	$this->data 		= 	array(
	'controller' 			=> 	$this->router->fetch_class(),
	'method' 				=> 	$this->router->fetch_method(),
	'session_userdata' 		=> 	isset($this->session->userdata) ? $this->session->userdata : '',
	'base_url' 				=> 	base_url(),
	'site_url'  			=> 	site_url(),
	);
	$this->load->model('Kiv_models/DataEntry_model'); 
	$this->load->model('Kiv_models/Survey_model'); 
}

public function DataEntryHome()
{
	$sess_usr_id   =   $this->session->userdata('int_userid');
	$user_type_id  = $this->session->userdata('int_usertype');
	$customer_id = $this->session->userdata('customer_id');
	$survey_user_id= $this->session->userdata('survey_user_id');
	if(!empty($sess_usr_id) && ($user_type_id==15))
	{
		$data       =  array('title' => 'DataEntryHome', 'page' => 'DataEntryHome', 'errorCls' => NULL, 'post' => $this->input->post());
		$data       =  $data + $this->data;
		$this->load->model('Kiv_models/Survey_model');
		$this->load->model('Kiv_models/DataEntry_model'); 
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/DataEntry/dataentryhome.php');
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		redirect('Main_login/index'); 
	}
}

public function dataentry()
{
	$data 			=	array('title' => 'dataentry', 'page' => 'dataentry', 'errorCls' => NULL, 'post' => $this->input->post());
	$data 			=	$data + $this->data; 
	$this->load->view('Kiv_views/DataEntry/dataentry',$data);
}

function show_vessel($regnum1)
{
	$regnum2=str_replace(array('~'), array('='), $regnum1);
	$regnum=base64_decode($regnum2);
	$this->load->model('Kiv_models/Survey_model');
	$data['regnum']	=	$regnum; 
	$vessel_details			= 	$this->DataEntry_model->get_vessel_details_regnum($regnum);
	$data['vessel_details'] =	$vessel_details;
   	$data 					= 	$data + $this->data;		
	$this->load->view('Kiv_views/Ajax_show_vessel_dataentry.php', $data);
}

public function addform()
{
	$sess_usr_id    = $this->session->userdata('int_userid');
	$user_type_id   = $this->session->userdata('int_usertype');
	$customer_id		   =	$this->session->userdata('customer_id');
	$survey_user_id	   =	$this->session->userdata('survey_user_id');
	if(!empty($sess_usr_id) && ($user_type_id==15))
	{
		$data 			=	array('title' => 'addform', 'page' => 'addform', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			=	$data + $this->data; 
		$registeringAuthority           = $this->DataEntry_model->get_registeringAuthority();
		$data['registeringAuthority']   = $registeringAuthority;

		$vesseltype             	= 	$this->DataEntry_model->get_vesseltype();
		$data['vesseltype']    		=	$vesseltype;

		$portofregistry				= 	$this->DataEntry_model->get_portofregistry();
		$data['portofregistry'] 	=	$portofregistry;

		$inboard_outboard			= 	$this->DataEntry_model->get_inboard_outboard();
		$data['inboard_outboard']	=	$inboard_outboard;

		$hullmaterial           	= 	$this->DataEntry_model->get_hullmaterial();
		$data['hullmaterial']   	=	 $hullmaterial;

		$ra_list           			= 	$this->DataEntry_model->get_ralist();
		$data['ra_list']   			=	 $ra_list;

		$stern_material 			=	$this->DataEntry_model->get_stern_material();
		$data['stern_material'] 	= 	$stern_material;

		$cargo_nature         		= 	$this->DataEntry_model->get_cargo_nature();
		$data['cargo_nature'] 		=	$cargo_nature;

		$fuel         				= 	$this->DataEntry_model->get_fuel_details();
		$data['fuel'] 				=	$fuel;

		$life_save_equipment        = 	$this->DataEntry_model->get_equipment_details_id(11);
		$data['life_save_equipment']=	$life_save_equipment;

		$portable_fire_ext	        = 	$this->DataEntry_model->get_portable_fire_ext();
		$data['portable_fire_ext']	=	$portable_fire_ext;

		$pollution_control        	= 	$this->DataEntry_model->get_equipment_details(7);
		$data['pollution_control']	=	$pollution_control;

		$placeof_survey 			= 	$this->DataEntry_model->get_placeof_survey();
		$data['placeof_survey'] 	=	$placeof_survey;

		/*$vesselcategory         =  $this->DataEntry_model->get_vesselcategory();
		$data['vesselcategory'] =	  $vesselcategory;*/

		if($this->input->post())
		{
			$ip     =	$_SERVER['REMOTE_ADDR'];
			date_default_timezone_set("Asia/Kolkata");
			$date 	= 	date('Y-m-d h:i:s', time());
			$dataentry_date=date('Y-m-d');
			//_____________________________vessel details__________________________________//
			$vessel_name            	=$this->security->xss_clean($this->input->post('vessel_name'));
			$vessel_type_id            	=$this->security->xss_clean($this->input->post('vessel_type_id'));
			$vessel_subtype_id          =$this->security->xss_clean($this->input->post('vessel_subtype_id'));
			$vessel_length_overall  =$this->security->xss_clean($this->input->post('vessel_length_overall'));
			$vessel_no_of_deck      =$this->security->xss_clean($this->input->post('vessel_no_of_deck'));
			$vessel_length          =$this->security->xss_clean($this->input->post('vessel_length'));
			$vessel_breadth         =$this->security->xss_clean($this->input->post('vessel_breadth'));
			$vessel_depth           =$this->security->xss_clean($this->input->post('vessel_depth'));
			$portofregistry_sl      =$this->security->xss_clean($this->input->post('portofregistry_sl'));
			$vessel_registration_number =$this->security->xss_clean($this->input->post('vessel_registration_number'));
			$build_place            		=$this->security->xss_clean($this->input->post('build_place'));
			$grt            				=$this->security->xss_clean($this->input->post('grt'));
			$nrt            				=$this->security->xss_clean($this->input->post('nrt'));
			$cargo_nature            		=$this->security->xss_clean($this->input->post('cargo_nature'));
			$stability_test_status_id=$this->security->xss_clean($this->input->post('stability_test_status_id'));
			$passenger_capacity   =$this->security->xss_clean($this->input->post('passenger_capacity'));
			$area_of_operation    =$this->security->xss_clean($this->input->post('area_of_operation'));
			$lower_deck_passenger =$this->security->xss_clean($this->input->post('lower_deck_passenger'));
			$upper_deck_passenger =$this->security->xss_clean($this->input->post('upper_deck_passenger'));
			$four_cruise_passenger =$this->security->xss_clean($this->input->post('four_cruise_passenger'));
			$condition_of_equipment =$this->security->xss_clean($this->input->post('condition_of_equipment'));
			$validity_of_certificate=$this->security->xss_clean($this->input->post('validity_of_certificate'));
			$stern_material_sl =$this->security->xss_clean($this->input->post('stern_material_sl'));
			$registering_authority_sl=$this->security->xss_clean($this->input->post('registering_authority_sl'));
			$first_aid_box   =$this->security->xss_clean($this->input->post('first_aid_box'));
			$vessel_tonnage	=round(($vessel_length_overall*$vessel_breadth*$vessel_depth)/2.83);
			$upperdeck          =$this->security->xss_clean($this->input->post('upperdeck'));
			$number_of_bedrooms  =$this->security->xss_clean($this->input->post('number_of_bedrooms'));

			//hull details
			$hull_name           =$this->security->xss_clean($this->input->post('hull_name'));
			$hullmaterial_id     =$this->security->xss_clean($this->input->post('hullmaterial_id'));
			$bulk_heads          =$this->security->xss_clean($this->input->post('bulk_heads'));
			$hull_condition_status_id  =$this->security->xss_clean($this->input->post('hull_condition_status_id'));
			$hull_year_of_built    =$this->security->xss_clean($this->input->post('hull_year_of_built'));

			//engine details
			$engine_number            		=$this->security->xss_clean($this->input->post('engine_number'));
			$engine_placement_id            =$this->security->xss_clean($this->input->post('engine_placement_id'));
			$manufacturer_name            	=$this->security->xss_clean($this->input->post('manufacturer_name'));
			$make_year            			=$this->security->xss_clean($this->input->post('make_year'));
			$engine_speed            		=$this->security->xss_clean($this->input->post('engine_speed'));
			$propulsion_shaft_number        =$this->security->xss_clean($this->input->post('propulsion_shaft_number'));
			$bhp            				=$this->security->xss_clean($this->input->post('bhp'));
			$bhp_kw							=(0.745699872)*$bhp;
			$fuel_sl            			=$this->security->xss_clean($this->input->post('fuel_sl'));

			//tb_vessel_main
			$vesselmain_reg_date     =$this->security->xss_clean($this->input->post('vesselmain_reg_date'));
			$next_reg_renewal_date =$this->security->xss_clean($this->input->post('next_reg_renewal_date'));
			$next_drydock_date =$this->security->xss_clean($this->input->post('next_drydock_date'));

			//tbl_kiv_survey_intimation
			$placeofsurvey_sl  =$this->security->xss_clean($this->input->post('placeofsurvey_sl'));
			$date_of_survey   =$this->security->xss_clean($this->input->post('date_of_survey'));
			//$remarks            			=$this->security->xss_clean($this->input->post('remarks'));

			//tbl_registration_history
			$registration_validity_period =$this->security->xss_clean($this->input->post('registration_validity_period'));
			$user_sl  =$this->security->xss_clean($this->input->post('user_sl'));

			//owner table

			$user_name            	=$this->security->xss_clean($this->input->post('user_name'));
			$user_address           =$this->security->xss_clean($this->input->post('user_address'));
			$user_mobile_number     =$this->security->xss_clean($this->input->post('user_mobile_number'));
			$user_email            	=$this->security->xss_clean($this->input->post('user_email'));

			//tbl_kiv_user

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


			$equipment_type_id10 	=$this->security->xss_clean($this->input->post('equipment_type_id10'));
			$number_of_foam         =$this->security->xss_clean($this->input->post('number_of_foam'));
			$equipment_id20         =$this->security->xss_clean($this->input->post('equipment_id20'));
			$number_of_fixed_sandbox=$this->security->xss_clean($this->input->post('number_of_fixed_sandbox'));
			$equipment_id21         =$this->security->xss_clean($this->input->post('equipment_id21'));

			$heaving_line_count     =$this->security->xss_clean($this->input->post('heaving_line_count'));
			$oars          			=$this->security->xss_clean($this->input->post('oars'));
			$fire_axe          		=$this->security->xss_clean($this->input->post('fire_axe'));

			$insurance_expiry_date  =$this->security->xss_clean($this->input->post('insurance_expiry_date'));
			//$no_of_engineset        =$this->security->xss_clean($this->input->post('no_of_engineset'));

			$pcb_certificate_number =$this->security->xss_clean($this->input->post('pcb_certificate_number'));
			$pcb_expiry_date        =$this->security->xss_clean($this->input->post('pcb_expiry_date'));


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
				$vessel_subtype_id6    =   $this->DataEntry_model->get_vessel_subtype_id($vessel_subtype_id1);
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

			$data_vessel_details = array(
			'vessel_user_id' => '0',
			'vessel_name'			=>$vessel_name,
			'vessel_type_id'		=>$vessel_type_id,
			'vessel_subtype_id'		=>$vessel_subtype_id,
			'vessel_length_overall'	=>$vessel_length_overall,
			'vessel_no_of_deck'		=>$vessel_no_of_deck,
			'vessel_length'			=>$vessel_length,
			'vessel_breadth'		=>$vessel_breadth,
			'vessel_depth'			=>$vessel_depth,
			'vessel_expected_tonnage'=>'0',
			'vessel_total_tonnage'	=>$vessel_tonnage,
			'vessel_registry_port_id'=>$portofregistry_sl,
			'vessel_registration_number'=>$vessel_registration_number,
			'build_place'			=>$build_place,
			'grt'					=>$grt,
			'nrt'					=>$nrt,
			'cargo_nature'			=>$cargo_nature,
			'stability_test_status_id'=>$stability_test_status_id,
			'passenger_capacity'	=>$passenger_capacity,
			'area_of_operation'		=>$area_of_operation,
			'lower_deck_passenger'	=>$lower_deck_passenger,
			'upper_deck_passenger'	=>$upper_deck_passenger,
			'four_cruise_passenger'	=>$four_cruise_passenger,
			'first_aid_box'=>$first_aid_box,
			'condition_of_equipment'=>$condition_of_equipment,
			'validity_of_certificate'=>$validity_of_certificate,
			'stern_id' 				=>$stern_material_sl,
			'registering_authority'=>$registering_authority_sl,
			'upperdeck'=>$upperdeck,
			'number_of_bedrooms'=>$number_of_bedrooms,
			'vessel_created_user_id'=>'0',
			'vessel_created_timestamp'=>$date,
			'vessel_created_ipaddress'=>$ip,
			'dataentry_status'=>'1');  //tbl_kiv_vessel_details

			$result_vessel=$this->DataEntry_model->insert_tabledata('tbl_kiv_vessel_details', $data_vessel_details); 
			$vessel_id 		= 	$this->db->insert_id();

			//Fire fighting equipment details 

			$fire_extinguisher_type_id  =$this->security->xss_clean($this->input->post('fire_extinguisher_type_id'));
			$firenumber 				=$this->security->xss_clean($this->input->post('firenumber'));
			$capacity 					=$this->security->xss_clean($this->input->post('capacity'));
			$fireext_count 				=$this->security->xss_clean($this->input->post('fireext_count'));
			if(!empty($fireext_count))
			{
				for($i=0;$i<$fireext_count;$i++)
				{
					$data_port_ext 	= 	array(
					'vessel_id' 				=>	$vessel_id,  
					'fire_extinguisher_type_id' 		=> 	$fire_extinguisher_type_id[$i],
					'fire_extinguisher_number' 		=> 	$firenumber[$i],
					'fire_extinguisher_capacity' 		=> 	$capacity[$i],
					'fire_extinguisher_created_user_id'	=>	'0',
					'fire_extinguisher_created_timestamp'	=>	$date,
					'fire_extinguisher_created_ipaddress'	=>	$ip,
					'dataentry_status'=>'1');
					$data = $this->security->xss_clean($data);
					$result_fire_ext=$this->DataEntry_model->insert_tabledata('tbl_kiv_fire_extinguisher_details', $data_port_ext); 
				}
			}
			//Crew details master
			$master_cnt            			=$this->security->xss_clean($this->input->post('master_cnt'));
			$name_of_type_mr            	=$this->security->xss_clean($this->input->post('name_of_type_mr'));
			$license_number_of_type_mr      =$this->security->xss_clean($this->input->post('license_number_of_type_mr'));

			if(!empty($master_cnt))
			{
				for($i=0;$i<$master_cnt;$i++)
				{
					$data_crew_mr[]= 	array(
					'vessel_id' =>$vessel_id,
					'survey_id' =>0,
					'crew_type_id'=>1,
					'name_of_type'  => $name_of_type_mr[$i],  
					'license_number_of_type'   => $license_number_of_type_mr[$i],            
					'crew_created_user_id'=>'0',
					'crew_created_timestamp'=>	$date,
					'crew_created_ipaddress'=>	$ip,
					'dataentry_status'=>'1');
				}
				$insert_data_master		=	$this->db->insert_batch('tbl_kiv_crew_details', $data_crew_mr);
			}

			//Crew details serang
			$serang_cnt           		=$this->security->xss_clean($this->input->post('serang_cnt'));
			$name_of_type_sg            =$this->security->xss_clean($this->input->post('name_of_type_sg'));
			$license_number_of_type_sg  =$this->security->xss_clean($this->input->post('license_number_of_type_sg'));
			if(!empty($serang_cnt))
			{
				for($i=0;$i<$serang_cnt;$i++)
				{
					$data_crew_sg[]= 	array(
					'vessel_id' =>$vessel_id,
					'survey_id' =>0,
					'crew_type_id'=>2,
					'name_of_type'  => $name_of_type_sg[$i],  
					'license_number_of_type'   => $license_number_of_type_sg[$i],            
					'crew_created_user_id'=>'0',
					'crew_created_timestamp'=>	$date,
					'crew_created_ipaddress'=>	$ip,
					'dataentry_status'=>'1');
				}
				$insert_data_serang		=	$this->db->insert_batch('tbl_kiv_crew_details', $data_crew_sg);
			}

			//Crew details lascar
			$lascar_cnt           		=$this->security->xss_clean($this->input->post('lascar_cnt'));
			$name_of_type_lr           	=$this->security->xss_clean($this->input->post('name_of_type_lr'));
			$license_number_of_type_lr  =$this->security->xss_clean($this->input->post('license_number_of_type_lr'));
			if(!empty($lascar_cnt))
			{
				for($i=0;$i<$lascar_cnt;$i++)
				{
					$data_crew_lr[]= 	array(
					'vessel_id' =>$vessel_id,
					'survey_id' =>0,
					'crew_type_id'=>3,
					'name_of_type'  => $name_of_type_lr[$i],  
					'license_number_of_type'   => $license_number_of_type_lr[$i],            
					'crew_created_user_id'=>'0',
					'crew_created_timestamp'=>	$date,
					'crew_created_ipaddress'=>	$ip,
					'dataentry_status'=>'1');
				}
				$insert_data_lascar	=	$this->db->insert_batch('tbl_kiv_crew_details', $data_crew_lr);
			}
			//Crew details driver
			$driver_cnt           		=$this->security->xss_clean($this->input->post('driver_cnt'));
			$name_of_type_dr           	=$this->security->xss_clean($this->input->post('name_of_type_dr'));
			$license_number_of_type_dr  =$this->security->xss_clean($this->input->post('license_number_of_type_dr'));
			if(!empty($driver_cnt))
			{
				for($i=0;$i<$driver_cnt;$i++)
				{
					$data_crew_dr[]= 	array(
					'vessel_id' =>$vessel_id,
					'survey_id' =>0,
					'crew_type_id'=>4,
					'name_of_type'  => $name_of_type_dr[$i],  
					'license_number_of_type'   => $license_number_of_type_dr[$i],            
					'crew_created_user_id'=>'0',
					'crew_created_timestamp'=>	$date,
					'crew_created_ipaddress'=>	$ip,
					'dataentry_status'=>'1');
				}
				$insert_data_driver	=	$this->db->insert_batch('tbl_kiv_crew_details', $data_crew_dr);
			}
			//Life Saving equipment details 
			$equipment_sl1 		=$this->security->xss_clean($this->input->post('equipment_sl1'));
			$number_adult1 		=$this->security->xss_clean($this->input->post('number_adult1')); 
			$number_children1 	=$this->security->xss_clean($this->input->post('number_children1')); //life jacket

			$equipment_sl2 		=$this->security->xss_clean($this->input->post('equipment_sl2'));
			$number_adult2 		=$this->security->xss_clean($this->input->post('number_adult2')); 
			$number_children2 	=$this->security->xss_clean($this->input->post('number_children2')); //life boat

			$equipment_sl3 		=$this->security->xss_clean($this->input->post('equipment_sl3'));
			$number_adult3 		=$this->security->xss_clean($this->input->post('number_adult3')); 
			$number_children3 	=$this->security->xss_clean($this->input->post('number_children3')); //life raft

			//------------insert life jacket------------//
			if(!empty($equipment_sl1))
			{
				$data_insert_lifejacket = array(
				'vessel_id'     =>  $vessel_id,  
				'equipment_id'      =>  $equipment_sl1,
				'equipment_type_id' =>  '11',
				'number_adult'      =>$number_adult1,
				'number_children'=>$number_children1,
				'equipment_created_user_id'    =>  '0',
				'equipment_created_timestamp'  => $date,
				'equipment_created_ipaddress'  => $ip,
				'dataentry_status'=>'1');
				$result_insert_lifejacket = $this->db->insert('tbl_kiv_equipment_details', $data_insert_lifejacket);  
			}
			//------------insert life boat------------//
			if(!empty($equipment_sl2))
			{
				$data_insert_lifeboat = array(
				'vessel_id'     =>  $vessel_id,  
				'equipment_id'      =>  $equipment_sl2,
				'equipment_type_id' =>  '11',
				'number_adult'      =>$number_adult2,
				'number_children'=>$number_children2,
				'equipment_created_user_id'    =>  '0',
				'equipment_created_timestamp'  => $date,
				'equipment_created_ipaddress'  => $ip,
				'dataentry_status'=>'1');
				$result_insert_lifeboat = $this->db->insert('tbl_kiv_equipment_details', $data_insert_lifeboat);  
			}

			//------------insert life raft------------//
			if(!empty($equipment_sl3))
			{
				$data_insert_liferaft= array(
				'vessel_id'     =>  $vessel_id,  
				'equipment_id'      =>  $equipment_sl3,
				'equipment_type_id' =>  '11',
				'number_adult'      =>$number_adult3,
				'number_children'=>$number_children3,
				'equipment_created_user_id'    =>  '0',
				'equipment_created_timestamp'  => $date,
				'equipment_created_ipaddress'  => $ip,
				'dataentry_status'=>'1');
				$result_insert_liferaft = $this->db->insert('tbl_kiv_equipment_details', $data_insert_liferaft);  
			}
			/*______________Insertion Life buoys_____________________*/
			$data_insert_lifebouys= array(
			'vessel_id'     =>  $vessel_id,  
			'equipment_id'      =>  '8',
			'equipment_type_id' =>  '1',
			'number'             =>$number_of_lifebouys,
			'equipment_created_user_id'    =>  '0',
			'equipment_created_timestamp'  => $date,
			'equipment_created_ipaddress'  => $ip,
			'dataentry_status'=>'1');
			$result_insert_lifebouys = $this->db->insert('tbl_kiv_equipment_details', $data_insert_lifebouys);
			/*______________Insertion bilge pump_____________________*/
			$data_insert_bilgepump= array(
			'vessel_id'     =>  $vessel_id,  
			'equipment_id'      =>  $equipment_id53,
			'equipment_type_id' =>  $equipment_type_id4,
			'number'             =>$number_of_bilgepump,
			'equipment_created_user_id'    =>  '0',
			'equipment_created_timestamp'  => $date,
			'equipment_created_ipaddress'  => $ip,
			'dataentry_status'=>'1');
			$result_insert_bilgepump = $this->db->insert('tbl_kiv_equipment_details', $data_insert_bilgepump);
			/*______________Insertion of fire applains_____________________*/  
			$data_insert_firepumps= array(
			'vessel_id'     =>  $vessel_id,  
			'equipment_id'      =>  $equipment_id13,
			'equipment_type_id' =>  $equipment_type_id4,
			'number'             =>$number_of_firepumps,
			'equipment_created_user_id'    =>  '0',
			'equipment_created_timestamp'  => $date,
			'equipment_created_ipaddress'  => $ip,
			'dataentry_status'=>'1');
			$result_insert_firepumps = $this->db->insert('tbl_kiv_equipment_details', $data_insert_firepumps);

			/*______________Insertion of firebucket_____________________*/
			$data_insert_firebucket= array(
			'vessel_id'     =>  $vessel_id,  
			'equipment_id'      =>  $equipment_id11,
			'equipment_type_id' =>  $equipment_type_id4,
			'number'             =>$number_of_firebucket,
			'equipment_created_user_id'    =>  '0',
			'equipment_created_timestamp'  => $date,
			'equipment_created_ipaddress'  => $ip,
			'dataentry_status'=>'1');
			$result_insert_firebucket = $this->db->insert('tbl_kiv_equipment_details', $data_insert_firebucket); 
			/*______________Insertion of sandbox_____________________*/
			$data_insert_sandbox= array(
			'vessel_id'     =>  $vessel_id,  
			'equipment_id'      =>  $equipment_id12,
			'equipment_type_id' =>  $equipment_type_id4,
			'number'             =>$number_of_sandbox,
			'equipment_created_user_id'    =>  '0',
			'equipment_created_timestamp'  => $date,
			'equipment_created_ipaddress'  => $ip,
			'dataentry_status'=>'1');
			$result_insert_sandbox = $this->db->insert('tbl_kiv_equipment_details', $data_insert_sandbox);  

			/*______________Insertion of heaving line_____________________*/
			$data_insert_heaving_line= array(
			'vessel_id'     =>  $vessel_id,  
			'equipment_id'      =>  '55',
			'equipment_type_id' =>  '1',
			'number'             =>$heaving_line_count,
			'equipment_created_user_id'    =>  '0',
			'equipment_created_timestamp'  => $date,
			'equipment_created_ipaddress'  => $ip,
			'dataentry_status'=>'1');
			$result_insert_heaving_line= $this->db->insert('tbl_kiv_equipment_details', $data_insert_heaving_line);

			/*______________Insertion of oars_____________________*/
			$data_insert_oars= array(
			'vessel_id'     =>  $vessel_id,  
			'equipment_id'      =>  '56',
			'equipment_type_id' =>  '4',
			'number'             =>$oars,
			'equipment_created_user_id'    =>  '0',
			'equipment_created_timestamp'  => $date,
			'equipment_created_ipaddress'  => $ip,
			'dataentry_status'=>'1');
			$result_insert_oars= $this->db->insert('tbl_kiv_equipment_details', $data_insert_oars); 

			/*______________Insertion of fire axe_____________________*/
			$data_insert_fire_axe= array(
			'vessel_id'     =>  $vessel_id,  
			'equipment_id'      =>  '57',
			'equipment_type_id' =>  '11',
			'number'             =>$fire_axe,
			'equipment_created_user_id'    =>  '0',
			'equipment_created_timestamp'  => $date,
			'equipment_created_ipaddress'  => $ip,
			'dataentry_status'=>'1');
			$result_insert_fire_axe= $this->db->insert('tbl_kiv_equipment_details', $data_insert_fire_axe); 

			/*______________Insertion of fixed fire extinguisher_____________________*/
			$data_insert_fixed_foam= array(
			'vessel_id'     =>  $vessel_id,  
			'equipment_id'      =>  $equipment_id20,
			'equipment_type_id' =>  $equipment_type_id10,
			'number'             =>$number_of_foam,
			'equipment_created_user_id'    =>  '0',
			'equipment_created_timestamp'  => $date,
			'equipment_created_ipaddress'  => $ip,
			'dataentry_status'=>'1');
			$result_insert_fixed_foam = $this->db->insert('tbl_kiv_equipment_details', $data_insert_fixed_foam);
			$data_insert_fixed_sandbox= array(
			'vessel_id'     =>  $vessel_id,  
			'equipment_id'      =>  $equipment_id21,
			'equipment_type_id' =>  $equipment_type_id10,
			'number'             =>$number_of_fixed_sandbox,
			'equipment_created_user_id'    =>  '0',
			'equipment_created_timestamp'  => $date,
			'equipment_created_ipaddress'  => $ip,
			'dataentry_status'=>'1');

			$result_insert_fixed_sandbox = $this->db->insert('tbl_kiv_equipment_details', $data_insert_fixed_sandbox);
			$list3=$this->security->xss_clean($this->input->post('list3')); //Pollution control equipment  
			foreach($list3 as $result1)
			{
				$list1_insert=array(
				'vessel_id' 		             =>$vessel_id, 
				'equipment_id'                 =>$result1,
				'equipment_type_id'            =>7,
				'equipment_created_user_id'    => '0',
				'equipment_created_timestamp'  =>	$date,
				'equipment_created_ipaddress'  =>	$ip);
				$result_insert=$this->db->insert('tbl_kiv_equipment_details', $list1_insert);	
			} 
			/*______________Insertion hull details_____________________*/
			$data_hull_details= array(
			'vessel_id' => $vessel_id,
			'survey_id'	=>'0',
			'hull_name'			=>$hull_name,
			'hullmaterial_id'	=>$hullmaterial_id,
			'bulk_heads'		=>$bulk_heads,
			'hull_condition_status_id'=>$hull_condition_status_id,
			'hull_year_of_built'=>$hull_year_of_built,
			'hull_created_user_id'	=>'0',
			'hull_created_timestamp'=>$date,
			'hull_created_ipaddress'=>$ip,
			'dataentry_status'=>'1'); //tbl_kiv_hulldetails
			$result_hull=$this->DataEntry_model->insert_tabledata('tbl_kiv_hulldetails', $data_hull_details); 

			/*______________Insertion engine details_____________________*/
			$data_engine_details= array(
			'vessel_id' => $vessel_id,
			'survey_id'	=>'0',
			'engine_number'		=>$engine_number,
			'engine_placement_id'=>$engine_placement_id,
			'manufacturer_name'	=>$manufacturer_name,
			'make_year'	=>$make_year,
			'engine_speed'		=>$engine_speed,
			'propulsion_shaft_number'=>$propulsion_shaft_number,
			'bhp'				=>$bhp,
			'bhp_kw'			=>$bhp_kw,
			'fuel_used_id'		=>$fuel_sl,
			'engine_created_user_id'=>'0',
			'engine_created_timestamp'=>$date,
			'engine_created_ipaddress'=>$ip,
			'dataentry_status'=>'1'); //tbl_kiv_engine_details
			$result_engine=$this->DataEntry_model->insert_tabledata('tbl_kiv_engine_details', $data_engine_details); 

			/*______________Insertion vessel main_____________________*/
			$data_vessel_main= array(
			'vesselmain_vessel_id' => $vessel_id,
			'vesselmain_vessel_name'=>$vessel_name,
			'vesselmain_vessel_type'=>$vesseltype_name,
			'vesselmain_vessel_subtype'=>$vessel_subtype_name,
			'vesselmain_owner_id'=>'0',
			'vesselmain_portofregistry_id'=>$portofregistry_sl,
			'processing_status'=>0,
			'vesselmain_reg_number'=>$vessel_registration_number,
			'vesselmain_reg_date'=>$vesselmain_reg_date,
			'next_reg_renewal_date'=>$next_reg_renewal_date,
			'next_drydock_date'=>$next_drydock_date,
			'dataentry_status'=>'1');  //tb_vessel_main
			$result_data_main=$this->DataEntry_model->insert_tabledata('tb_vessel_main', $data_vessel_main); 

			/*______________Insertion survey intimation_____________________*/
			$data_survey_intimation =array(
			'vessel_id' => $vessel_id,
			'survey_id'	=>'1',
			'form_id' 	=>'4',
			'placeofsurvey_id'=>$placeofsurvey_sl,
			'date_of_survey'=>$date_of_survey,
			'status'=>'2',
			'defect_status'=>'0',
			'intimation_created_user_id'=>'0',
			'intimation_created_timestamp'=>$date,
			'intimation_created_ipaddress'=>$ip,
			'dataentry_status'=>'1');
			$result_survey_intimation=$this->DataEntry_model->insert_tabledata('tbl_kiv_survey_intimation', $data_survey_intimation); 

			/*______________Insertion registration history_____________________*/
			$data_registration_history= array(
			'registration_vessel_id' => $vessel_id,
			'registration_date'=>$vesselmain_reg_date,
			'registration_number'=>$vessel_registration_number,
			'registration_validity_period'=>$registration_validity_period,
			'registering_authority'=>$registering_authority_sl,
			'registration_verify_id'=>$user_sl,
			'registering_user'=>'0',
			'registration_type'=>'1',
			'registration_status'=>'1',
			'dataentry_status'=>'1');
			$result_registration_history=$this->DataEntry_model->insert_tabledata('tbl_registration_history', $data_registration_history); 

			/*______________Insertion insurance details_____________________*/
			$insertInsuranceDet=array(
			'vessel_id'                  => $vessel_id,
			'vessel_insurance_validity'  => $insurance_expiry_date,
			'insurance_created_user_id'  =>'0',
			'insurance_created_timestamp'=>$date,
			'insurance_created_ipaddress'=>$ip,
			'dataentry_status'=>'1');
			$insertInsuranceDet      = $this->security->xss_clean($insertInsuranceDet);         
			$insertInsuranceDet_res  = $this->db->insert('tbl_vessel_insurance_details', $insertInsuranceDet);

			/*______________Insertion pollution details_____________________*/
			$data_pollution_details= array(
			'vessel_id' => $vessel_id,
			'pcb_expiry_date'=>$pcb_expiry_date,
			'pcb_number'=>$pcb_certificate_number,
			'dataentry_status'=>'1',
			'pollution_created_user_id'=>'0',
			'pollution_created_timestamp'=>$date,
			'pollution_created_ipaddress'=>$ip);
			$result_pollution_details  = $this->db->insert('tbl_pollution_details', $data_pollution_details);

			/*______________Insertion Dataentry table_____________________*/
			$data_dataentry= array(
			'dataentry_portoffice_id' =>$dataentry_portoffice_id,
			'dataentry_user_id'=>$sess_usr_id,
			'vessel_id'=>$vessel_id,
			'dataentry_date'=>$dataentry_date,
			'dataentry_datetime'=>$date,
			'dataentry_ip'=>$ip);
			$result_dataentry  = $this->db->insert('tb_vessel_dataentry', $data_dataentry);
			if($result_dataentry)
			{
				redirect("Kiv_Ctrl/DataEntry/dataentry_reports");
			}
		}
		
		$this->load->view('Kiv_views/template/dash-header.php');;
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/DataEntry/addform',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		redirect('Main_login/index'); 
	}
}

function vessel_subtype($vessel_type_id)
{
	$this->load->model('Kiv_models/DataEntry_model');
	$data['vessel_subtype']		=	$vessel_type_id; 
	//print_r($vessel_type_id);
	$vessel_subtype				= 	$this->DataEntry_model->get_vessel_subtype($vessel_type_id);
	$data['vessel_subtype']     =	$vessel_subtype;
	//print_r($vessel_subtype);
	$data 						= 	$data + $this->data;		
	$this->load->view('Kiv_views/Ajax_vessel_subtype.php', $data);
}

public function dataentry_reports()
{
	$sess_usr_id    = $this->session->userdata('int_userid');
	$user_type_id   = $this->session->userdata('int_usertype');
	$customer_id		   =	$this->session->userdata('customer_id');
	$survey_user_id	   =	$this->session->userdata('survey_user_id');
	if(!empty($sess_usr_id) && ($user_type_id==15))
	{
		$data 			=	 array('title' => 'dataentry_reports', 'page' => 'dataentry_reports', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			=	 $data + $this->data;

		$dataentry_details=$this->DataEntry_model->get_dataentry_details($sess_usr_id);
		$data['dataentry_details']     =	$dataentry_details;

		$this->load->view('Kiv_views/template/dash-header.php');;
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/DataEntry/dataentry_reports',$data);
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
	$customer_id		   =	$this->session->userdata('customer_id');
	$survey_user_id	   =	$this->session->userdata('survey_user_id');
	if(!empty($sess_usr_id) && ($user_type_id==15))
	{
		$data 			=	 array('title' => 'verified_forms', 'page' => 'verified_forms', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 			=	 $data + $this->data;
		
		$dataentry_details=$this->DataEntry_model->get_verified_dataentry_details($sess_usr_id);
		$data['dataentry_details']     =	$dataentry_details;

		$this->load->view('Kiv_views/template/dash-header.php');;
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/DataEntry/verified_forms',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		redirect('Main_login/index'); 
	}
}

public function edit_dataentry_vessel()
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
  	$data = array('title' => 'edit_dataentry_vessel', 'page' => 'edit_dataentry_vessel', 'errorCls' => NULL, 'post' => $this->input->post());
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
      $user_master_id         =$this->security->xss_clean($this->input->post('user_master_id'));


      /*______________Insertion Life buoys_____________________*/
      if(!empty($equipment_details_sl18))
      {
        $data_update_lifebouys= array(
        'number'             =>$number_of_lifebouys,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
        $update_lifebouys = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_lifebouys,'equipment_details_sl',$equipment_details_sl18);
      }
      else
      {
        $data_insert_lifebouys= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  '8',
        'equipment_type_id' =>  '1',
        'number'             =>$number_of_lifebouys,
        'equipment_modified_user_id'    => $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_lifebouys = $this->db->insert('tbl_kiv_equipment_details', $data_insert_lifebouys);
      }
      /*______________Insertion bilge pump_____________________*/
      if(!empty($equipment_details_sl453))
      {
        $data_update_bilgepump= array(
        'number'             =>$number_of_bilgepump,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
        $update_bilgepump = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_bilgepump,'equipment_details_sl',$equipment_details_sl453);
      }
      else
      {
        $data_insert_bilgepump= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id53,
        'equipment_type_id' =>  $equipment_type_id4,
        'number'             =>$number_of_bilgepump,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_bilgepump = $this->db->insert('tbl_kiv_equipment_details', $data_insert_bilgepump);
      }
     /*______________Insertion of fire applains_____________________*/  
      if(!empty($equipment_details_sl413))
      {
        $data_update_firepumps= array(
        'number'             =>$number_of_firepumps,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
        $update_firepumps = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_firepumps,'equipment_details_sl',$equipment_details_sl413);
      }
      else
      {
        $data_insert_firepumps= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id13,
        'equipment_type_id' =>  $equipment_type_id4,
        'number'             =>$number_of_firepumps,
        'equipment_modified_user_id'    => $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_firepumps = $this->db->insert('tbl_kiv_equipment_details', $data_insert_firepumps); 
      }
      /*______________Insertion of firebucket_____________________*/
      if(!empty($equipment_details_sl411))
      {
        $data_update_firebucket= array(
        'number'             =>$number_of_firebucket,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
        $update_firebucket = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_firebucket,'equipment_details_sl',$equipment_details_sl411);
      }
      else
      {
        $data_insert_firebucket= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id11,
        'equipment_type_id' =>  $equipment_type_id4,
        'number'             =>$number_of_firebucket,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_firebucket = $this->db->insert('tbl_kiv_equipment_details', $data_insert_firebucket);
      }
     /*______________Insertion of sandbox_____________________*/
      if(!empty($equipment_details_sl412))
      {
        $data_update_sandbox= array(
        'number'             =>$number_of_sandbox,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
        $update_sandbox = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_sandbox,'equipment_details_sl',$equipment_details_sl412);
      }
      else
      {
        $data_insert_sandbox= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id12,
        'equipment_type_id' =>  $equipment_type_id4,
        'number'             =>$number_of_sandbox,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_sandbox = $this->db->insert('tbl_kiv_equipment_details', $data_insert_sandbox);
      }
      /*______________Insertion of heaving line_____________________*/
      if(!empty($equipment_details_sl155))
      {
        $data_update_heaving_line= array(
        'number'             =>$heaving_line_count,
        'equipment_modified_user_id'    => $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
        $update_heaving_line = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_heaving_line,'equipment_details_sl',$equipment_details_sl155);
      }
      else
      {
        $data_insert_heaving_line= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  '55',
        'equipment_type_id' =>  '1',
        'number'             =>$heaving_line_count,
        'equipment_modified_user_id'    => $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_heaving_line= $this->db->insert('tbl_kiv_equipment_details', $data_insert_heaving_line);
      }
      /*______________Insertion of oars_____________________*/
      if(!empty($equipment_details_sl456))
      {
        $data_update_oars= array(
        'number'             =>$oars,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
        $update_oars = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_oars,'equipment_details_sl',$equipment_details_sl456);
      }
      else
      {
        $data_insert_oars= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  '56',
        'equipment_type_id' =>  '4',
        'number'             =>$oars,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_oars= $this->db->insert('tbl_kiv_equipment_details', $data_insert_oars);
      }
      /*______________Insertion of fire axe_____________________*/
      if(!empty($equipment_details_sl1157))
      {
        $data_update_fire_axe= array(
        'number'             =>$fire_axe,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
        $update_fireaxe = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_fire_axe,'equipment_details_sl',$equipment_details_sl1157);
      }
      else
      {
        $data_insert_fire_axe= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  '57',
        'equipment_type_id' =>  '11',
        'number'             =>$fire_axe,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_fire_axe= $this->db->insert('tbl_kiv_equipment_details', $data_insert_fire_axe);
      }
      /*______________Insertion of fixed fire extinguisher-foam_____________________*/
      if(!empty($equipment_details_sl1020))
      {
        $data_update_fixed_foam= array(
        'number'             =>$number_of_foam,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
        $update_fixed_foam = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_fixed_foam,'equipment_details_sl',$equipment_details_sl1020);
      }
      else
      {
        $data_insert_fixed_foam= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id20,
        'equipment_type_id' =>  $equipment_type_id10,
        'number'             =>$number_of_foam,
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
        'dataentry_status'=>'1');
        $result_insert_fixed_foam = $this->db->insert('tbl_kiv_equipment_details', $data_insert_fixed_foam);
      }
      /*______________Insertion of fixed fire extinguisher-sandbox_____________________*/
      if(!empty($equipment_details_sl1021))
      {
        $data_update_fixed_sandbox= array(
        'number'             =>$number_of_fixed_sandbox,
        'equipment_modified_user_id'    =>   $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
        $update_fixed_sandbox = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_equipment_details',$data_update_fixed_sandbox,'equipment_details_sl',$equipment_details_sl1021);
      }
      else
      {
        $data_insert_fixed_sandbox= array(
        'vessel_id'     =>  $vessel_id,  
        'equipment_id'      =>  $equipment_id21,
        'equipment_type_id' =>  $equipment_type_id10,
        'number'             =>$number_of_fixed_sandbox,
        'equipment_modified_user_id'    =>   $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
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
          'fire_extinguisher_modified_user_id' =>  $sess_usr_id,
          'fire_extinguisher_modified_timestamp' =>  $date,
          'fire_extinguisher_modified_ipaddress' =>  $ip);

          $data_port_ext_insert =   array(
          'vessel_id'         =>  $vessel_id,  
          'fire_extinguisher_type_id'     =>  $fire_extinguisher_type_id[$i],
          'fire_extinguisher_number'    =>  $firenumber[$i],
          'fire_extinguisher_capacity'    =>  $capacity[$i],
          'fire_extinguisher_modified_user_id' =>  $sess_usr_id,
          'fire_extinguisher_modified_timestamp' =>  $date,
          'fire_extinguisher_modified_ipaddress' =>  $ip,
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
          'crew_modified_user_id'=>$sess_usr_id,
          'crew_modified_timestamp'=>  $date,
          'crew_modified_ipaddress'=>  $ip);

          $data_crew_mr_insert=  array(
         'vessel_id' =>$vessel_id,
          'survey_id' =>0,
          'crew_type_id'=>1,
          'name_of_type'  => $name_of_type_mr[$i],  
          'license_number_of_type'   => $license_number_of_type_mr[$i],            
          'crew_modified_user_id'=>$sess_usr_id,
          'crew_modified_timestamp'=>  $date,
          'crew_modified_ipaddress'=>  $ip,
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
          'crew_modified_user_id'=>$sess_usr_id,
          'crew_modified_timestamp'=>  $date,
          'crew_modified_ipaddress'=>  $ip,
          'dataentry_status'=>'1');

          $data_crew_sg_insert=  array(
          'vessel_id' =>$vessel_id,
          'survey_id' =>0,
          'crew_type_id'=>2,
          'name_of_type'  => $name_of_type_sg[$i],  
          'license_number_of_type'   => $license_number_of_type_sg[$i],            
          'crew_modified_user_id'=>$sess_usr_id,
          'crew_modified_timestamp'=>  $date,
          'crew_modified_ipaddress'=>  $ip,
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
          'crew_modified_user_id'=>$sess_usr_id,
          'crew_modified_timestamp'=>  $date,
          'crew_modified_ipaddress'=>  $ip,
          'dataentry_status'=>'1');

          $data_crew_lr_insert=  array(
          'vessel_id' =>$vessel_id,
          'survey_id' =>0,
          'crew_type_id'=>3,
          'name_of_type'  => $name_of_type_lr[$i],  
          'license_number_of_type'   => $license_number_of_type_lr[$i],            
          'crew_modified_user_id'=>$sess_usr_id,
          'crew_modified_timestamp'=>  $date,
          'crew_modified_ipaddress'=>  $ip,
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
          'crew_modified_user_id'=>$sess_usr_id,
          'crew_modified_timestamp'=>  $date,
          'crew_modified_ipaddress'=>  $ip,
          'dataentry_status'=>'1');

          $data_crew_dr_insert=  array(
          'vessel_id' =>$vessel_id,
          'survey_id' =>0,
          'crew_type_id'=>4,
          'name_of_type'  => $name_of_type_dr[$i],  
          'license_number_of_type'   => $license_number_of_type_dr[$i],            
          'crew_modified_user_id'=>$sess_usr_id,
          'crew_modified_timestamp'=>  $date,
          'crew_modified_ipaddress'=>  $ip,
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
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
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
        'equipment_modified_user_id'    =>  $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
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
        'equipment_modified_user_id'    => $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
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
        'equipment_modified_user_id'    => $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
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
        'equipment_modified_user_id'    => $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip);
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
        'equipment_modified_user_id'    => $sess_usr_id,
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip,
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
        'equipment_modified_user_id'    => '0',
        'equipment_modified_timestamp'  => $date,
        'equipment_modified_ipaddress'  => $ip );
        $result_insert=$this->db->insert('tbl_kiv_equipment_details', $list1_insert); 
      } */

      //_________________________ updation of tbl_kiv_vessel_details ______________________________// 
      $data_vessel_details = array(
      'vessel_user_id' => $sess_usr_id,
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
      'vessel_modified_user_id'=>$sess_usr_id,
      'vessel_modified_timestamp'=>$date,
      'vessel_modified_ipaddress'=>$ip,
      'dataentry_status'=>'1');    //print_r($data_vessel_details);  exit;
      $update_vessel_details   = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_vessel_details',$data_vessel_details,'vessel_sl',$vessel_sl);
      //_________________________ updation of tbl_kiv_hulldetails ______________________________// 
      $data_hull_details= array(
      //'vessel_id' => $vessel_id,
      'survey_id' =>'0',
      'hull_name'     =>$hull_name,
      'hullmaterial_id' =>$hullmaterial_id,
      'bulk_heads'    =>$bulk_heads,
      'hull_condition_status_id'=>$hull_condition_status_id,
      'hull_year_of_built'=>$hull_year_of_built,
       'hull_modified_user_id' =>$sess_usr_id,
      'hull_modified_timestamp'=>$date,
      'hull_modified_ipaddress'=>$ip,
      'dataentry_status'=>'1'); //print_r($data_hull_details);  exit;
      $update_hull_details   = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_hulldetails',$data_hull_details,'hull_sl',$hull_sl);
      //_________________________ updation of tbl_kiv_engine_details ______________________________// 
      $data_engine_details= array(
      //'vessel_id' => $vessel_id,
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
      'engine_modified_user_id'=>$sess_usr_id,
      'engine_modified_timestamp'=>$date,
      'engine_modified_ipaddress'=>$ip,
      'dataentry_status'=>'1'); 

     $update_engine_details   = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_engine_details',$data_engine_details,'engine_sl',$engine_sl);
     //_________________________ updation of tb_vessel_main ______________________________// 
     $data_vessel_main= array(
     // 'vesselmain_vessel_id' => $vessel_id,
      'vesselmain_vessel_name'=>$vessel_name,
      'vesselmain_vessel_type'=>$vesseltype_name,
      'vesselmain_vessel_subtype'=>$vessel_subtype_name,
     // 'vesselmain_owner_id'=>$sess_usr_id,
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
     // 'vessel_id' => $vessel_id,
      'survey_id' =>'1',
      'form_id'   =>'4',
      'placeofsurvey_id'=>$placeofsurvey_sl,
      'date_of_survey'=>$date_of_survey,
      'status'=>'2',
      'defect_status'=>'0',
      'dataentry_status'=>'1');
      $update_survey_intimation   = $this->DataEntry_model->update_dataentry_tables('tbl_kiv_survey_intimation',$data_survey_intimation,'intimation_sl',$intimation_sl);
      //_________________________ updation of tbl_registration_history ______________________________// 
      $data_registration_history= array(
     // 'registration_vessel_id' => $vessel_id,
      'registration_date'=>$vesselmain_reg_date,
      'registration_number'=>$vessel_registration_number,
      'registration_validity_period'=>$registration_validity_period,
      'registering_authority'=>$registering_authority_sl,
      'registration_verify_id'=>$user_sl,
      //'registering_user'=>$sess_usr_id,
      'registration_type'=>'1',
      'registration_status'=>'1',
      'dataentry_status'=>'1');
      $update_registration_history   = $this->DataEntry_model->update_dataentry_tables('tbl_registration_history',$data_registration_history,'registration_sl',$registration_sl);
      //_________________________ updation of tbl_vessel_insurance_details ______________________________// 
      $insertInsuranceDet=array(
     // 'vessel_id'                  => $vessel_id,
      'vessel_insurance_validity'  => $insurance_expiry_date,
      'insurance_modified_user_id'  =>$sess_usr_id,
      'insurance_modified_datetime'=>$date,
      'insurance_modified_ipaddress'=>$ip,
      'dataentry_status'=>'1');
      $update_insurance   = $this->DataEntry_model->update_dataentry_tables('tbl_vessel_insurance_details',$insertInsuranceDet,'vessel_insurance_sl',$vessel_insurance_sl);
      //_________________________ updation of tbl_pollution_details ______________________________// 
      $data_pollution_details= array(
     // 'vessel_id' => $vessel_id,
      'pcb_expiry_date'=>$pcb_expiry_date,
      'pcb_number'=>$pcb_certificate_number,
      'dataentry_status'=>'1',
      'pollution_modified_user_id'=>$sess_usr_id,
      'pollution_modified_datetime'=>$date,
      'pollution_modified_ipaddress'=>$ip);
      $result_pollution_details  = $this->DataEntry_model->update_dataentry_tables('tbl_pollution_details',$data_pollution_details,'pollution_sl',$pollution_sl);

     
if($update_vessel_main)
{
	redirect("Kiv_Ctrl/DataEntry/dataentry_reports");
}

 
  



		}

    $this->load->model('Kiv_models/Survey_model');
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/DataEntry/edit_dataentry_vessel',$data);
    $this->load->view('Kiv_views/template/dash-footer.php');
  

  }
   else
  {
    redirect('Main_login/index'); 
  }

}

public function view_dataentry_vessel()
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
  	$data = array('title' => 'view_dataentry_vessel', 'page' => 'view_dataentry_vessel', 'errorCls' => NULL, 'post' => $this->input->post());
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

    $this->load->model('Kiv_models/Survey_model');
    $this->load->view('Kiv_views/template/dash-header.php');
    $this->load->view('Kiv_views/template/nav-header.php');
    $this->load->view('Kiv_views/DataEntry/view_dataentry_vessel',$data);
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
//___________________End of controller___________________________________//
}
?>