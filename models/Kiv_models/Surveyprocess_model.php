<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surveyprocess_model extends CI_Model
{
function __construct()
{
// Call the Model constructor
parent::__construct();
}


function get_user($id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_user');
    $this->db->where('user_sl',$id);
    $this->db->where('user_ownership_id',1);
    $query = 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 

function get_agent($id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_user');
    $this->db->where('relation_sl',$id);
    $this->db->where('user_ownership_id',4);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_vesselcategory()
{
    $this->db->select('*');
    $this->db->from('kiv_vesselcategory_master');
    $this->db->where('vesselcategory_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('vesselcategory_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
        
function get_vessel_subcategory($id)
{
    $this->db->select('*');
    $this->db->from('kiv_vessel_subcategory_master');
    $this->db->where('vessel_subcategory_category_id',$id);
    $this->db->where('vessel_subcategory_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('vessel_subcategory_name','ASC'); 
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
    
function get_vesseltype()
{
    $this->db->select('*');
    $this->db->from('kiv_vesseltype_master');
    $this->db->where('vesseltype_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('vesseltype_name','ASC'); 
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_vessel_subtype($id)
{
    $this->db->select('*');
    $this->db->from('kiv_vessel_subtype_master');
    $this->db->where('vessel_subtype_vesseltype_id',$id);
    $this->db->where('vessel_subtype_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('vessel_subtype_name','ASC'); 
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_vessel_subtypeid_length($id)
{
    $this->db->select('*');
    $this->db->from('kiv_vessel_subtype_master');
    $this->db->where('vessel_subtype_sl',$id);
    $this->db->where('vessel_subtype_status',1);
    $this->db->where('delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
function get_vessel_typeid_length($id)
{
    $this->db->select('*');
    $this->db->from('kiv_vesseltype_master');
    $this->db->where('vesseltype_sl',$id);
    $this->db->where('kiv_vesseltype_master',1);
    $this->db->where('delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}





/*function get_vessel_details($id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_vessel_details');
    $this->db->join('tbl_kiv_form_stage','tbl_kiv_vessel_details.vessel_sl=tbl_kiv_form_stage.vessel_id');
    $this->db->where('tbl_kiv_vessel_details.vessel_user_id',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}*/


function get_vessel_details($id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_vessel_details');
    $this->db->join('tbl_kiv_form_stage','tbl_kiv_vessel_details.vessel_sl=tbl_kiv_form_stage.vessel_id');
    $this->db->join('tbl_kiv_status_details','tbl_kiv_vessel_details.vessel_sl=tbl_kiv_status_details.vessel_id');
    $this->db->where('tbl_kiv_vessel_details.vessel_user_id',$id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

    
function get_vessel_category($id)
{
    $this->db->select('vesselcategory_name');
    $this->db->from('kiv_vesselcategory_master');
    $this->db->where('vesselcategory_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_month()
{
    $this->db->select('*');
    $this->db->from('kiv_month_master');
    $this->db->where('month_status',1);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
        
        
function get_form_stage($id)
{
    $this->db->select('stage_count');
    $this->db->from('tbl_kiv_form_stage');
    $this->db->where('vessel_id',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
function get_hullmaterial()
{
    $this->db->select('*');
    $this->db->from('kiv_hullmaterial_master');
    $this->db->where('hullmaterial_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('hullmaterial_name','ASC'); 
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_hullplating_material()
{
    $this->db->select('*');
    $this->db->from('kiv_hullplating_material_master');
    $this->db->where('hullplating_material_status',1);
    //$this->db->where('hullplating_material_sl',1); 
    $this->db->where('delete_status',0);
    $this->db->order_by('hullplating_material_name','ASC'); 
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
     
  
        
function get_bulk_head_placement()
{
    $this->db->select('*');
    $this->db->from('kiv_bulkhead_placement_master');
    $this->db->where('bulkhead_placement_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('bulkhead_placement_name','ASC'); 
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function update_form_stage_count($data_stage,$stage_sl)
{

    $where 		= 	"stage_sl  = $stage_sl"; 
    $updquery 	= 	$this->db->update_string('tbl_kiv_form_stage', $data_stage, $where);
    $result		=	$this->db->query($updquery);
    return $result;	
}
        
function get_form_stage_sl($id)
{
    $this->db->select('stage_sl');
    $this->db->from('tbl_kiv_form_stage');
    $this->db->where('vessel_id',$id);
    $this->db->where('form',1);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
function insert_hull($data)
{
    $result=$this->db->insert('tbl_kiv_hulldetails', $data);  
    return $result;
}

function insert_process_flow($data)
{
    $result=$this->db->insert('tbl_kiv_processflow', $data);  
    return $result;
}


function insert_doc($table,$data)
{
    $result=$this->db->insert($table, $data);  
    return $result;
}

function get_inboard_outboard()
{
    $this->db->select('*');
    $this->db->from('kiv_inboard_outboard_master');
    $this->db->where('inboard_outboard_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('inboard_outboard_name','ASC'); 
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
        
function get_model_number()
{
    $this->db->select('*');
    $this->db->from('kiv_modelnumber_master');
    $this->db->where('modelnumber_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('modelnumber_name','ASC'); 
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_engine_type()
{
    $this->db->select('*');
    $this->db->from('kiv_enginetype_master');
    $this->db->where('enginetype_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('enginetype_name','ASC'); 
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 

function get_gear_type()
{
    $this->db->select('*');
    $this->db->from('kiv_geartype_master');
    $this->db->where('geartype_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('geartype_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 

function get_propulsionshaft_material()
{
    $this->db->select('*');
    $this->db->from('kiv_propulsionshaft_material_master');
    $this->db->where('propulsionshaft_material_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('propulsionshaft_material_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 

function get_equipment_details()
{
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_equipment_material()
{
    $id=array(1,4);
    $this->db->select('*');
    $this->db->from('kiv_equipment_material_master');
    $this->db->where('equipment_material_status',1);
    $this->db->where_in('equipment_material_sl',$id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_equipment_type()
{
    $this->db->select('*');
    $this->db->from('kiv_equipment_type_master');
    $this->db->where('equipment_type_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_type_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_searchlight_size()
{
    $this->db->select('*');
    $this->db->from('kiv_searchlight_size_master');
    $this->db->where('searchlight_size_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('searchlight_size_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}


function  get_navigation_light()
{
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',2);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function  get_navigation_light_dynamic($value)
{

  $myArray = explode(',', $value);
  $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',2);
    $this->db->where_in('equipment_sl',$myArray);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}  
    
    
function  get_sound_signals()
{
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',3);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
    
function  get_sound_signals_dynamic($value)
{
    $myArray = explode(',', $value);
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',3);
    $this->db->where_in('equipment_sl',$myArray);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}  
    
    
function  get_firepumptype_dynamic($value)
{
    $myArray = explode(',', $value);
    $this->db->select('*');
    $this->db->from('kiv_firepumptype_master');
    $this->db->where('firepumptype_status',1);
    $this->db->where_in('firepumptype_sl',$myArray);
    $this->db->where('delete_status',0);
    $this->db->order_by('firepumptype_name','ASC');
    $query=$this->db->get();
    $result=$query->result_array();
    return $result;
}
    
    
    

function get_bilgepumptype_dynamic($value)
{
    $myArray = explode(',', $value);
    $this->db->select('*');
    $this->db->from('kiv_bilgepumptype_master');
    $this->db->where('bilgepumptype_status',1);
    $this->db->where_in('bilgepumptype_sl',$myArray);
    $this->db->where('delete_status',0);
    $this->db->order_by('bilgepumptype_name','ASC');
    $query=$this->db->get();
    $result=$query->result_array();
    return $result;
} 
    
    
function get_nozzletype_dynamic($value)
{
    $myArray = explode(',', $value);
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',8);
    $this->db->where_in('equipment_sl',$myArray);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
 }

function get_portable_fire_ext_dynamic($value)
{
    $myArray = explode(',', $value);
    $this->db->select('*');
    $this->db->from('kiv_portable_fire_extinguisher_master');
    $this->db->where('portable_fire_extinguisher_status',1);
    $this->db->where_in('portable_fire_extinguisher_sl',$myArray);
    $this->db->where('delete_status',0);
    $this->db->order_by('portable_fire_extinguisher_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
 }
     
     
function get_commnequipment_dynamic($value)
 {
    $myArray = explode(',', $value);
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',5);
    $this->db->where_in('equipment_sl',$myArray);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
 }
     
function get_navgnequipments_dynamic($value)
 {
    $myArray = explode(',', $value);
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',6);
    $this->db->where_in('equipment_sl',$myArray);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
 }

function get_pollution_controldevice_dynamic($value)
 {
    $myArray = explode(',', $value);
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',7);
    $this->db->where_in('equipment_sl',$myArray);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
 }
    
function get_sourceofwater_dynamic($value)
{
     $myArray = explode(',', $value);
    $this->db->select('*');
    $this->db->from('kiv_sourceofwater_master');
    $this->db->where('sourceofwater_status',1);
     $this->db->where_in('sourceofwater_sl',$myArray);
    $this->db->where('delete_status',0);
    $this->db->order_by('sourceofwater_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
         
         

function get_firepumpsize()
{
    $this->db->select('*');
    $this->db->from('kiv_firepumpsize_master');
    $this->db->where('firepumpsize_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('firepumpsize_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_nozzletype()
{
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',8);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
	
function get_commnequipment()
 {
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',5);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
 }
     
    
function get_navgnequipments()
{
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',6);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
	
	
function get_pollution_controldevice()
{
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_status',1);
    $this->db->where('equipment_type_id',7);
    $this->db->where('delete_status',0);
    $this->db->order_by('equipment_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
 
function get_sourceofwater()
{
    $this->db->select('*');
    $this->db->from('kiv_sourceofwater_master');
    $this->db->where('sourceofwater_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('sourceofwater_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_portable_fire_ext()
{
    $this->db->select('*');
    $this->db->from('kiv_portable_fire_extinguisher_master');
    $this->db->where('portable_fire_extinguisher_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('portable_fire_extinguisher_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
	
function get_portable_fire_ext_count()
{
    $this->db->select('count(*) AS port_count');
    $this->db->from('kiv_portable_fire_extinguisher_master');
    $this->db->where('portable_fire_extinguisher_status',1);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
 
 
 function get_firepumptype_count()
{
    $this->db->select('count(*) AS firepump_count');
    $this->db->from('kiv_firepumptype_master');
    $this->db->where('firepumptype_status',1);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
 
  function get_bilgepumptype_count()
{
    $this->db->select('count(*) AS bilgepump_count');
    $this->db->from('kiv_bilgepumptype_master');
    $this->db->where('bilgepumptype_status',1);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
         
         
         
function get_list_document()
{
    $this->db->select('*');
    $this->db->from('kiv_document_master');
    $this->db->where('document_status',1);
    $this->db->where('document_type_id',1); 
    $this->db->where('delete_status',0);
    $this->db->order_by('document_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
 
	
function update_vessel_other_equipment($data_update_vessel,$vessel_id)
{
    $where      = 	"vessel_sl  = $vessel_id"; 
    $updquery 	= 	$this->db->update_string('tbl_kiv_vessel_details', $data_update_vessel, $where);
    $result		=	$this->db->query($updquery);
    return $result;	
}

function update_vessel_pref_inspection_date($data_update,$vessel_id)
{
    $where 	= 	"vessel_sl  = $vessel_id"; 
    $updquery 	= 	$this->db->update_string('tbl_kiv_vessel_details', $data_update, $where);
    $result		=	$this->db->query($updquery);
    return $result;	
}

    
function get_paymenttype()
{
    $this->db->select('*');
    $this->db->from('kiv_paymenttype_master');
    $this->db->where('paymenttype_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('paymenttype_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_bank_favoring()
{
    $this->db->select('*');
    $this->db->from('kiv_bank_master ');
    $this->db->where('bank_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('bank_name','ASC');
    $query = 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
	
function get_portofregistry()
{
    $this->db->select('*');
    $this->db->from('kiv_portofregistry_master ');
    $this->db->where('portofregistry_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('portofregistry_name','ASC');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
	
//------------Vessel Details in View page------------//
function get_vessel_details_viewpage($vessel_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_vessel_details');
    $this->db->where('vessel_sl',$vessel_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_owner_details($customer_id)
{
    $this->db->select('user_name,user_address,user_email,user_mobile_number');
    $this->db->from('tbl_kiv_user');
    $this->db->where('relation_sl',$customer_id);
    $this->db->where('user_ownership_id',1);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
        
function get_vessel_category_id($vessel_category_id)
{
    $this->db->select('vesselcategory_name');
    $this->db->from('kiv_vesselcategory_master');
    $this->db->where('vesselcategory_sl',$vessel_category_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_vessel_subcategory_id($vessel_subcategory_id)
{
    $this->db->select('vessel_subcategory_name');
    $this->db->from('kiv_vessel_subcategory_master');
    $this->db->where('vessel_subcategory_sl',$vessel_subcategory_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_vessel_type_id($vessel_type_id)
{
    $this->db->select('vesseltype_name');
    $this->db->from('kiv_vesseltype_master');
    $this->db->where('vesseltype_sl',$vessel_type_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
	
function get_vessel_subtype_id($vessel_subtype_id)
{
    $this->db->select('vessel_subtype_name');
    $this->db->from('kiv_vessel_subtype_master');
    $this->db->where('vessel_subtype_sl',$vessel_subtype_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_hull_details($vessel_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_hulldetails');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_hullmaterial_name($material_id)
{
    $this->db->select('hullmaterial_name');
    $this->db->from('kiv_hullmaterial_master');
    $this->db->where('hullmaterial_sl',$material_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
        
function get_hullplating_material_name($hullplating_material_id)
{
    $this->db->select('hullplating_material_name');
    $this->db->from('kiv_hullplating_material_master');
    $this->db->where('hullplating_material_sl',$hullplating_material_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}	 

function get_engine_details($vessel_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_engine_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('delete_status',0);
    $query=$this->db->get();
    $result=$query->result_array();
    return $result;
}
function get_equipment_details_view($vessel_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('delete_status',0);
    $query=$this->db->get();
    $result=$query->result_array();
    return $result;
}
	
function get_chainport_type()
{
    $this->db->select('*');
    $this->db->from('kiv_chainporttype_master');
    $this->db->where('chainporttype_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('chainporttype_name','ASC');
    $query=$this->db->get();
    $result=$query->result_array();
    return $result;
}

function get_firepumptype()
{
    $this->db->select('*');
    $this->db->from('kiv_firepumptype_master');
    $this->db->where('firepumptype_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('firepumptype_name','ASC');
    $query=$this->db->get();
    $result=$query->result_array();
    return $result;
}

function get_bilgepumptype()
{
    $this->db->select('*');
    $this->db->from('kiv_bilgepumptype_master');
    $this->db->where('bilgepumptype_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('bilgepumptype_name','ASC');
    $query=$this->db->get();
    $result=$query->result_array();
    return $result;
}
        
        
function get_rope_material()
{
    $this->db->select('*');
    $this->db->from('kiv_ropematerial_master');
    $this->db->where('ropematerial_status',1);
    $this->db->where('delete_status',0);
     $this->db->order_by('ropematerial_name','ASC');
    $query=$this->db->get();
    $result=$query->result_array();
    return $result;
}
function get_list_document_vessel($id)
{
    $this->db->select('*');
    $this->db->from('kiv_document_master');
    $this->db->where('document_status',1);
    $this->db->where('document_type_id',1); 
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
	 
               
        
//--------------------Edit Vessel-----------------//


function get_vessel_details_edit($id)
{
 
    $this->db->select('*');
    $this->db->from('tbl_kiv_vessel_details');
    $this->db->where('vessel_sl',$id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_hull_details_edit($id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_hulldetails');
    $this->db->where('vessel_id',$id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
	
function get_hull_bulkhead_details_edit($id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_hull_bulkhead_details');
    $this->db->where('vessel_id',$id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}


function get_engine_details_edit($id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_engine_details');
    $this->db->where('vessel_id',$id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
function get_engine_details_edit_count($id)
{
    $this->db->select('COUNT(*) AS engine_count');
    $this->db->from('tbl_kiv_engine_details');
    $this->db->where('vessel_id',$id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
         
function get_equipment_details_edit($vessel_id,$equipment_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
     
 
function  get_type_equipment_details_edit($vessel_id,$equipment_type_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_type_id',$equipment_type_id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_fire_extinguisher_details_edit($vessel_id)
{

    $this->db->select('*');
    $this->db->from('tbl_kiv_fire_extinguisher_details a');
    $this->db->join('kiv_portable_fire_extinguisher_master b','a.fire_extinguisher_type_id=b.portable_fire_extinguisher_sl');
    $this->db->where('a.vessel_id',$vessel_id);
    $this->db->where('a.delete_status',0);
    $this->db->order_by('b.portable_fire_extinguisher_name');
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 
         
function get_firepump_details_edit($id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_firepumps_details a');
    $this->db->join('kiv_firepumptype_master b','a.firepumptype_id=b.firepumptype_sl');
    $this->db->where('a.vessel_id',$id);
    $this->db->where('a.delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 
 
function get_otherequipment_edit($vessel_id,$equipment_type_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_type_id',$equipment_type_id);
    $this->db->where('delete_status',0);
   
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
  
function get_list_document_vessel_edit($id)
{
    $this->db->select('*');
    $this->db->from('kiv_document_master');
    $this->db->where('document_status',1);
    $this->db->where('document_type_id',1); 
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
	 
function get_doc_file_edit($id,$document_id)
{
    $this->db->select('fileupload_details_sl,document_id,document_name');
    $this->db->from('tbl_kiv_fileupload_details');
    $this->db->where('vessel_id',$id);
    $this->db->where('document_id',$document_id);
    $query 	= 	$this->db->get();
    return $query->row();
} 

function get_payment_details_edit($id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_payment_details');
    $this->db->where('vessel_id',$id);
    $this->db->where('survey_id',1);
    $this->db->where('form_number',1);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
//-------END---------//

function update_initial_survey_vessel_table($tablename,$data_update,$id)
{

    $where 		= "vessel_sl  = $id"; 
    $updquery 	= 	$this->db->update_string($tablename, $data_update, $where);
    $result		=	$this->db->query($updquery);
    return $result;	
}

function update_initial_survey_hull_table($tablename,$data_update,$id)
{

    $where      = "hull_sl  = $id"; 
    $updquery 	= 	$this->db->update_string($tablename, $data_update, $where);
    $result		=	$this->db->query($updquery);
    return $result;	
}
        
function insert_bulkhead($table,$data)
{
    $result=$this->db->insert($table, $data);  
    return $result;
}  
 function insert_table1($table,$data)
{
    $result=$this->db->insert($table, $data);  
    return $result;
} 
  function insert_table2($table,$data)
{
    $result=$this->db->insert($table, $data);  
    return $result;
} 
   function insert_table3($table,$data)
{
    $result=$this->db->insert($table, $data);  
    return $result;
} 

        
function update_bulkhead_delete($tablename,$data_update,$id)
{
    $where      = "hull_bulkhead_details_sl  = $id"; 
    $updquery 	= 	$this->db->update_string($tablename, $data_update, $where);
    $result		=	$this->db->query($updquery);
    return $result;	
} 

function update_bulkhead_update($tablename,$data_update,$id){

    $where      = "hull_bulkhead_details_sl  = $id"; 
    $updquery 	= 	$this->db->update_string($tablename, $data_update, $where);
    $result		=	$this->db->query($updquery);
    return $result;	
} 

function update_engine_delete($tablename,$data_delete,$id)
{
    $where      = "engine_sl  = $id"; 
    $updquery 	= 	$this->db->update_string($tablename, $data_delete, $where);
    $result		=	$this->db->query($updquery);
    return $result;	
}  

function update_engine_update($tablename,$data_update,$id)
 {
    $where      = "engine_sl  = $id"; 
    $updquery 	= 	$this->db->update_string($tablename, $data_update, $where);
    $result		=	$this->db->query($updquery);
    return $result;	
}

function insert_engineset($table,$data)
{
    $result=$this->db->insert($table, $data);  
    return $result;
}   

function update_equipment($tablename,$data_update,$id)
 {
    $where      = "equipment_details_sl  = $id"; 
    $updquery 	= 	$this->db->update_string($tablename, $data_update, $where);
    $result		=	$this->db->query($updquery);
    return $result;	
} 

function update_firepump($tablename,$data_update,$id)
{
    $where      = "firepumps_details_sl  = $id"; 
    $updquery 	= $this->db->update_string($tablename, $data_update, $where);
    $result		= $this->db->query($updquery);
    return $result;	
} 
         
function update_portablefire($tablename,$data_update,$id)
{
    $where      = "fire_extinguisher_sl  = $id"; 
    $updquery 	= $this->db->update_string($tablename, $data_update, $where);
    $result		= $this->db->query($updquery);
    return $result;	
}  

function update_payment_details($tablename,$data_update,$id)
{
    $where      = "payment_sl  = $id"; 
    $updquery 	= $this->db->update_string($tablename, $data_update, $where);
    $result		= $this->db->query($updquery);
    return $result;	
}    
        
function get_upload_filename($id)
{
    $this->db->select('document_name');
    $this->db->from('tbl_kiv_fileupload_details');
    $this->db->where('vessel_id',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function update_doc($tablename,$data_update,$id)
{
    $where      = "fileupload_details_sl  = $id"; 
    $updquery 	= $this->db->update_string($tablename, $data_update, $where);
    $result		= $this->db->query($updquery);
    return $result;	
}

function get_document_id($vessel_id,$id)
{
    $this->db->select('count(*) as cnt');
    $this->db->from('tbl_kiv_fileupload_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('document_id',$id);
    $this->db->where('document_type_id',1);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
        
      // Dynamic page 
    

       function get_field_name_engine($vessel_type_id,$vessel_subtype_id,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
      function get_field_name_engine_23($vessel_type_id,$vessel_subtype_id,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
       function get_field_name_engine_35($vessel_type_id,$vessel_subtype_id,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
         function get_field_name_engine_36($vessel_type_id,$vessel_subtype_id,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
    function get_field_name_engine_37($vessel_type_id,$vessel_subtype_id,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }    
       function get_field_name_engine_38($vessel_type_id,$vessel_subtype_id,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
        function get_field_name_engine_39($vessel_type_id,$vessel_subtype_id,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
        function get_field_name_engine_40($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
        function get_field_name_engine_41($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
        function get_field_name_engine_42($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
        function get_field_name_engine_43($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
        function get_field_name_engine_44($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
        function get_field_name_engine_45($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }
        
     function get_field_name_fireappliance_46($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }  
        function get_field_name_fireappliance_47($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }  
        function get_field_name_fireappliance_48($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }  
        function get_field_name_fireappliance_49($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }  
        function get_field_name_fireappliance_51($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }  
        function get_field_name_fireappliance_52($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }  
        function get_field_name_fireappliance_82($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }  
      function get_field_name_otherequipment_53($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }    
        
         function get_field_name_otherequipment_54($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }    
        
        
         function get_field_name_otherequipment_55($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }    
        
        
         function get_field_name_otherequipment_60($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_inboard_outboard,$form_id, $heading_id,$label_id)
        {
            $this->db->select('*');
            $this->db->from('kiv_dynamic_field_master');
            $this->db->where('vesseltype_id',$vessel_type_id);
            $this->db->where('vessel_subtype_id',$vessel_subtype_id);
            $this->db->where('length_over_deck',$vessel_length);
            $this->db->where('hullmaterial_id',$hullmaterial_id);
            $this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
            $this->db->where('form_id',$form_id);
            $this->db->where('heading_id',$heading_id);
            $this->db->where('label_id',$label_id);
            $this->db->where('delete_status',0);
            $query 	= 	$this->db->get();
            $result = 	$query->result_array();
            return $result;
        }    
        
 //-----Chief Surveyor------------//

function get_process_flow($processflow_sl)       
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_processflow a');
    $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
    $this->db->where('processflow_sl',$processflow_sl);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_process_flow_cs($user_id)       
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_processflow a');
    $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
    $this->db->where('user_id',$user_id);
   $this->db->where('process_id',1);
    //$this->db->where('survey_id',1);
    $this->db->where('status',1);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_process_flow_sr($user_id)       
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_processflow a');
    $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
    $this->db->where('user_id',$user_id);
    //$this->db->where('process_id',1);
    //$this->db->where('survey_id',1);
    $this->db->where('status',1);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_process_flow_show($vessel_sl, $sess_usr_id)       
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_processflow');
    $this->db->where('vessel_id',$vessel_sl);
    $this->db->where('user_id',$sess_usr_id);
   $this->db->where('status',1);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_survey_activity_keel_count($vessel_id)       
{
    $this->db->select('count(*) as keel_count');
    $this->db->from('tbl_kiv_processflow');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('process_id',2);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}


function get_survey_activity()
{
    $this->db->select('*');
    $this->db->from('kiv_surveyactivity_master');
    $this->db->where('delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}


function get_survey_activity_approve($vessel_id,$current_status_id,$process_id)       
{
    $this->db->select('count(*) as keel_approve_count');
    $this->db->from('tbl_kiv_processflow');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('current_status_id',$current_status_id);
    $this->db->where('process_id',$process_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_survey_activity1($number)
{
    $this->db->select('*');
    $this->db->from('kiv_surveyactivity_master');
    $this->db->where('surveyactivity_sl',$number);
    $this->db->where('delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_survey_activity_hull_count($vessel_id)       
{
    $this->db->select('count(*) as hull_count');
    $this->db->from('tbl_kiv_processflow');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('process_id',3);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_survey_activity2()
{
    $id=array(3,4);
    $this->db->select('*');
    $this->db->from('kiv_surveyactivity_master');
    $this->db->where_in('surveyactivity_sl',$id);
    $this->db->where('delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}







function get_customer_details($id)       
{
    $this->db->select('*');
    $this->db->from('kiv_user_master a');
    $this->db->join('tbl_kiv_user b','a.customer_id=b.user_sl');
    $this->db->where('a.user_sl',$id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}




function get_surveyor_details()
{
    $this->db->select('*');
    $this->db->from('kiv_user_master');
    $this->db->where_in('user_type_id',5);
    $this->db->where('delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}


function get_process_flow_application($status_id)       
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_processflow a');
    $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
    $this->db->where('a.current_status_id',$status_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function insert_processflow($table,$data)
{
    $result=$this->db->insert($table, $data);  
    return $result;
}

function insert_processflow_remarks($table,$data)
{
    $result=$this->db->insert($table, $data);  
    return $result;
}


function update_processflow($table,$data,$processflow_sl)
{
    $where      =   "processflow_sl  = $processflow_sl"; 
    $updquery   =   $this->db->update_string($table, $data, $where);
    $result     =   $this->db->query($updquery);
    return $result; 
}   
function get_user_master($sesson_id)     
{
    $this->db->select('*');
    $this->db->from('kiv_user_master a');
    $this->db->join('kiv_user_type_master b', 'a.user_type_id=b.user_type_sl');
    $this->db->where('a.user_sl',$sesson_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
 
 function get_vessel_details_individual($vessel_id)
 {
    $this->db->select('*');
    $this->db->from('tbl_kiv_vessel_details');
    $this->db->where('vessel_sl',$vessel_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
 }
 function get_status()
 {
    $this->db->select('*');
    $this->db->from('tbl_kiv_status');
    $this->db->where('status_id!=',1);
    $this->db->where('status_id!=',2);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
 }


  function get_status_sr()
 {
    $this->db->select('*');
    $this->db->from('tbl_kiv_status');
    $this->db->where('status_id!=',1);
    $this->db->where('status_id!=',3);
    $this->db->where('status_id!=',6);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
 }

 function get_status_cs_sr()
 {
    $id=array(4,5,6);
    $this->db->select('*');
    $this->db->from('tbl_kiv_status');
    $this->db->where_in('status_id',$id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
 }

 function get_user_type_id($user_id)
 {
    $this->db->select('*');
    $this->db->from('kiv_user_master');
    $this->db->where('user_sl',$user_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
 }

function get_user_type_user_id($module_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_processflow');
    $this->db->where('processflow_sl',$module_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_vessel_rejection($vessel_id)
{
    $this->db->select('count(*) as reject_count');
    $this->db->from('tbl_kiv_processflow');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('current_status_id',3);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
function get_process_remarks($processflow_sl)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_processflow_remarks');
    $this->db->where('receiving_user_id',$processflow_sl);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}


function get_process_flow_surveyactivity($process_id,$status_id,$user_id)       
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_processflow a');
    $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
    $this->db->where('a.process_id',$process_id);
    $this->db->where('a.status',$status_id);
    $this->db->where('a.user_id',$user_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_process_name($id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_processname');
    $this->db->where('processname_sl',$id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_survey_name($id)
{
    $this->db->select('*');
    $this->db->from('kiv_survey_master');
    $this->db->where('survey_sl',$id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
function get_status_details($vessel_id)
{

    $this->db->select('*');
    $this->db->from('tbl_kiv_status_details');
    $this->db->where('vessel_id',$vessel_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}


function insert_status_details($table,$data)
{
    $result=$this->db->insert($table, $data);  
    return $result;
}

function update_status_details($table,$data,$status_details_sl)
{
    $where      =   "status_details_sl  = $status_details_sl"; 
    $updquery   =   $this->db->update_string($table, $data, $where);
    $result     =   $this->db->query($updquery);
    return $result; 
}

function insert_task($table,$data)
{
    $result=$this->db->insert($table, $data);  
    return $result;
}

function get_task($user_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_processflow a');
    $this->db->join('tbl_kiv_task b','a.processflow_sl=b.process_flow_id');
    $this->db->join('tbl_kiv_vessel_details c','a.vessel_id=c.vessel_sl');
    $this->db->where('a.user_id',$user_id);
    $this->db->where('a.status',1);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;

}


function insert_date($table,$data)
{
     $result=$this->db->insert($table, $data);  
    return $result;
}

function get_processactivity_date($vessel_id,$survey_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_processactivity_date');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('survey_id',$survey_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

/*function get_form_number($process_id)
{
     $this->db->select('*');
    $this->db->from('tbl_kiv_processname');
    $this->db->where('processname_sl',$process_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}*/

function get_form_number($vessel_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_status_details a ');
    $this->db->join('tbl_kiv_processname b','a.process_id=b.processname_sl');
    $this->db->where('a.vessel_id',$vessel_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
 

function get_task_pfid($pfid)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_task');
    $this->db->where('process_flow_id',$pfid);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}


function update_task($table,$data,$task_sl)
{
    $where      =   "task_sl  = $task_sl"; 
    $updquery   =   $this->db->update_string($table, $data, $where);
    $result     =   $this->db->query($updquery);
    return $result; 
}

/*function get_label_control_details($heading_id)
{
    $status=array(1,2);
    $this->db->select('*');
    $this->db->from('kiv_dynamic_field_master a');
    $this->db->join('kiv_label_master b','a.label_id=b.label_sl');
    $this->db->where('a.heading_id',$heading_id);
    $this->db->where('a.vesseltype_id','7');
    $this->db->where_in('a.label_value_status',$status);
    $this->db->order_by('b.label_sl','ASC');
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
*/
function get_length_overthedeck($vessel_type_id,$vessel_subtype_id,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id)
{
    $status=array(1,2);
    $this->db->distinct('a.length_over_deck');
    $this->db->from('kiv_dynamic_field_masterg a');
    $this->db->join('kiv_label_master b','a.label_id=b.label_sl');
    $this->db->where('a.vesseltype_id',$vessel_type_id);
    $this->db->where('a.vessel_subtype_id',$vessel_subtype_id);
    $this->db->where('a.hullmaterial_id',$hullmaterial_id);
    $this->db->where('a.engine_inboard_outboard',$engine_placement_id);
    $this->db->where('a.form_id',$form_id);
    $this->db->where('a.heading_id',$heading_id);
    $this->db->where('a.delete_status',0);
    $this->db->where('a.status',1);
    $this->db->where_in('a.label_value_status',$status);
    $this->db->order_by('b.label_sl','ASC');
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}



function get_label_control_details($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id)
{
    $status=array(1,2);
    $this->db->select('*');
    $this->db->from('kiv_dynamic_field_master a');
    $this->db->join('kiv_label_master b','a.label_id=b.label_sl');
    $this->db->where('a.vesseltype_id',$vessel_type_id);
    $this->db->where('a.vessel_subtype_id',$vessel_subtype_id);
    $this->db->where('a.length_over_deck<=',$vessel_length);
    $this->db->where('a.hullmaterial_id',$hullmaterial_id);
    $this->db->where('a.engine_inboard_outboard',$engine_placement_id);
    $this->db->where('a.form_id',$form_id);
    $this->db->where('a.heading_id',$heading_id);
    $this->db->where('a.delete_status',0);
    $this->db->where('a.status',1);
    $this->db->where_in('a.label_value_status',$status);
    
    $this->db->order_by('b.label_sl','ASC');
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

//Form3 Start

function get_length_overthedeck_form3($vessel_type_id,$vessel_subtype_id,$hullmaterial_id,$engine_placement_id,$form_id)
{
    $status=array(1,2);
    $this->db->distinct('a.length_over_deck');
    $this->db->from('kiv_dynamic_field_master a');
    $this->db->join('kiv_label_master b','a.label_id=b.label_sl');
    $this->db->where('a.vesseltype_id',$vessel_type_id);
    $this->db->where('a.vessel_subtype_id',$vessel_subtype_id);
    $this->db->where('a.hullmaterial_id',$hullmaterial_id);
    $this->db->where('a.engine_inboard_outboard',$engine_placement_id);
    $this->db->where('a.form_id',$form_id);
    $this->db->where('a.delete_status',0);
    $this->db->where('a.status',1);
    $this->db->where_in('a.label_value_status',$status);
    $this->db->order_by('b.label_sl','ASC');
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}



function get_label_control_details_form3($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_placement_id,$form_id)
{
    $status=array(1,2);
    $this->db->select('*');
    $this->db->from('kiv_dynamic_field_master a');
    $this->db->join('kiv_label_master b','a.label_id=b.label_sl');
    $this->db->where('a.vesseltype_id',$vessel_type_id);
    $this->db->where('a.vessel_subtype_id',$vessel_subtype_id);
    $this->db->where('a.length_over_deck<=',$vessel_length);
    $this->db->where('a.hullmaterial_id',$hullmaterial_id);
    $this->db->where('a.engine_inboard_outboard',$engine_placement_id);
    $this->db->where('a.form_id',$form_id);
    $this->db->where('a.delete_status',0);
    $this->db->where('a.status',1);
    $this->db->where_in('a.label_value_status',$status);
    
    $this->db->order_by('b.label_sl','ASC');
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

//Form3 End















 function get_label_details($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id,$label_id)
{
    $status=array(1,2);
    $this->db->select('*');
    $this->db->from('kiv_dynamic_field_master');
    $this->db->where('vesseltype_id',$vessel_type_id);
    $this->db->where('vessel_subtype_id',$vessel_subtype_id);
    $this->db->where('length_over_deck<=',$vessel_length);
    $this->db->where('hullmaterial_id',$hullmaterial_id);
    $this->db->where('engine_inboard_outboard',$engine_placement_id);
    $this->db->where('form_id',$form_id);
    $this->db->where('heading_id',$heading_id);
    $this->db->where('label_id',$label_id);
    $this->db->where('delete_status',0);
    $this->db->where('status',1);
    $this->db->where_in('label_value_status',$status);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_tariff_details($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id)
{
    $this->db->select('*');
    $this->db->from('kiv_tariff_master1');
    $this->db->where('tariff_activity_id',$activity_id);
    $this->db->where('tariff_form_id',$form_id);
    $this->db->where('tariff_vessel_type_id',$vessel_type_id);
    $this->db->where('tariff_vessel_subtype_id',$vessel_subtype_id);
    $this->db->where('tariff_tonnagetype_id',1);
    $this->db->where('tariff_day_type',1);
    $this->db->where('delete_status',0);
    $this->db->where('tariff_status',1);
    
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_vessel_details_dynamic($vessel_id)
{
    $this->db->select('a.vessel_type_id,a.vessel_subtype_id,a.vessel_length,b.hullmaterial_id,c.engine_placement_id');
    $this->db->from('tbl_kiv_vessel_details a');
    $this->db->join('tbl_kiv_hulldetails b','a.vessel_sl=b.vessel_id');
    $this->db->join('tbl_kiv_engine_details c','a.vessel_sl=c.vessel_id');
    $this->db->where('a.vessel_sl',$vessel_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_no_of_engineset_dynamic($vessel_id)
{
   $this->db->select('COUNT(*) as engine_count');
    $this->db->from('tbl_kiv_engine_details');
    $this->db->where('vessel_id',$vessel_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result; 
}
function get_hull_details_dynamic($vessel_id)
{
   $this->db->select('*');
    $this->db->from('tbl_kiv_hulldetails');
    $this->db->where('vessel_id',$vessel_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result; 
}
function get_engine_details_dynamic($vessel_id)
{
   $this->db->select('*');
    $this->db->from('tbl_kiv_engine_details');
    $this->db->where('vessel_id',$vessel_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result; 
}

function update_table_hull($table,$data,$id)
{
    $where      =   "hull_sl  = $id"; 
    $updquery   =   $this->db->update_string($table, $data, $where);
    $result     =   $this->db->query($updquery);
    return $result; 
}

function update_table_engine($table,$data,$id)
{
    $where      =   "engine_sl  = $id"; 
    $updquery   =   $this->db->update_string($table, $data, $where);
    $result     =   $this->db->query($updquery);
    return $result; 
}


function get_chain_ids($vessel_id,$equipment_id)

{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result; 
}


function update_table_equipment($table,$data,$id)
{
    $where      =   "equipment_details_sl  = $id"; 
    $updquery   =   $this->db->update_string($table, $data, $where);
    $result     =   $this->db->query($updquery);
    return $result; 
}

function get_vessel_owner_name($sess_usr_id)
{
$this->db->select('a.user_name');
    $this->db->from('tbl_kiv_user a');
    $this->db->join('kiv_user_master b','a.user_sl=b.customer_id');
    $this->db->where('b.user_sl',$sess_usr_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result; 
}

 //-------------END---------------------//     

}

