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
				'survey_id' 		             =>'0', 
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
			'hull_created_timestamp'=>$date,
			'hull_created_ipaddress'=>$ip,
			'hull_modified_user_id'	=>'0',
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
	$vessel_subtype				= 	$this->DataEntry_model->get_vessel_subtype($vessel_type_id);
	$data['vessel_subtype']     =	$vessel_subtype;
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
//___________________End of model___________________________________//
}
?>