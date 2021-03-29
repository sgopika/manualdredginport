<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Function_model extends CI_Model
{
function __construct()
{
    // Call the Model constructor
    parent::__construct();
}

function get_hull_bulkhead_details($id,$survey_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_hull_bulkhead_details');
    $this->db->where('vessel_id',$id);
    $this->db->where('survey_id',$survey_id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_bulk_head_placement_name($id)
{
    $this->db->select('bulkhead_placement_name');
    $this->db->from('kiv_bulkhead_placement_master');
    $this->db->where('bulkhead_placement_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}


function get_modelnumber_name($id)    
{ 
    $this->db->select('modelnumber_name');
    $this->db->from('kiv_modelnumber_master');
    $this->db->where('modelnumber_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 

function get_enginetype_name($id)    
{ 
    $this->db->select('enginetype_name');
    $this->db->from('kiv_enginetype_master');
    $this->db->where('enginetype_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 

function get_geartype_name($id)    
{ 
    $this->db->select('geartype_name');
    $this->db->from('kiv_geartype_master');
    $this->db->where('geartype_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 
   
function get_propulsionshaft_material_name($id)
{
    $this->db->select('propulsionshaft_material_name');
    $this->db->from('kiv_propulsionshaft_material_master');
    $this->db->where('propulsionshaft_material_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 
function get_anchor_port($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 
function get_equipment_material_name($id)
{
    $this->db->select('equipment_material_name');
    $this->db->from('kiv_equipment_material_master');
    $this->db->where('equipment_material_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 

function get_anchor_startboard($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}                       

    
function get_anchor_spare($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}      

function get_chain_port($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}     
function get_chainporttype_name($id)
{
    $this->db->select('chainporttype_name');
    $this->db->from('kiv_chainporttype_master');
    $this->db->where('chainporttype_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}    

function get_chain_startboard($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}     

function get_chain_Rope($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}  

function get_searchlight($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
} 

function get_searchlight_size($id)
{
    $this->db->select('searchlight_size_name');
    $this->db->from('kiv_searchlight_size_master');
    $this->db->where('searchlight_size_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
    
function get_lifebuoys($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('number');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_buoyant_apparatus($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('number');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_navigation_light_view($vessel_id,$survey_id)
{
    $this->db->select('equipment_id');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_type_id',2);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_nav_light_euipment($id)
{
    $this->db->select('equipment_name');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
function get_sound_signal_view($vessel_id,$survey_id)
{
    $this->db->select('equipment_id');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_type_id',3);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
     
    
function get_fire_pumps($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_firepumps_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_fire_mains($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $this->db->where('delete_status',0);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_firepump_size($id)
{
    $this->db->select('firepumpsize_name');
    $this->db->from('kiv_firepumpsize_master');
    $this->db->where('firepumpsize_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_firepump_type_name($id)
{
    $this->db->select('firepumptype_name');
    $this->db->from('kiv_firepumptype_master');
    $this->db->where('firepumptype_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
    
 
function get_hydrants($vessel_id,$equipment_id)
{
    $this->db->select('number');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_hose($vessel_id,$equipment_id,$survey_id)
{
    $this->db->select('number');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_sourceof_water($id)
{
    $this->db->select('sourceofwater_name');
    $this->db->from(' kiv_sourceofwater_master');
    $this->db->where('sourceofwater_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_fire_extinguisher_details($vessel_id,$survey_id)
{
    $this->db->select('fire_extinguisher_type_id,fire_extinguisher_number,fire_extinguisher_capacity');
    $this->db->from(' tbl_kiv_fire_extinguisher_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
    
function get_portable_fire_extinguisher_name($id)
{
    $this->db->select('portable_fire_extinguisher_name');
    $this->db->from(' kiv_portable_fire_extinguisher_master');
    $this->db->where('portable_fire_extinguisher_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
function get_communication_equipment($id,$equipment_type_id,$survey_id)
{
    $this->db->select('equipment_id');
    $this->db->from(' tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$id);
    $this->db->where('equipment_type_id',$equipment_type_id);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_navigation_equipment($id,$equipment_type_id,$survey_id)
{
    $this->db->select('equipment_id');
    $this->db->from(' tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$id);
    $this->db->where('equipment_type_id',$equipment_type_id);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
function get_pollution_control($id,$equipment_type_id,$survey_id)
{
    $this->db->select('equipment_id');
    $this->db->from(' tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$id);
    $this->db->where('equipment_type_id',$equipment_type_id);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}

function get_nozzle_type($id,$equipment_type_id,$survey_id)
{
    $this->db->select('equipment_id');
    $this->db->from(' tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$id);
    $this->db->where('equipment_type_id',$equipment_type_id);
    $this->db->where('survey_id',$survey_id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;
}
function get_doc_file($id,$document_id,$survey_id)
{
    $this->db->select('document_id,document_name');
    $this->db->from('tbl_kiv_fileupload_details');
    $this->db->where('vessel_id',$id);
    $this->db->where('survey_id',$survey_id);
    $this->db->where('document_id',$document_id);
    $query 	= 	$this->db->get();
    return $query->row();
}
function get_rope_material_name($id)
{
    $this->db->select('ropematerial_name');
    $this->db->from('kiv_ropematerial_master');
    $this->db->where('ropematerial_sl',$id);
    $query 	= 	$this->db->get();
    $result = 	$query->result_array();
    return $result;

}
    
//------------END------------//	
}