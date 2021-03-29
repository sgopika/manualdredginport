<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Survey_model extends CI_Model
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
    function get_minor($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_user');
        $this->db->where('relation_sl',$id);
        $this->db->where('user_ownership_id',3);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vesselcategory()
    {
        $this->db->select('*');
        $this->db->from('kiv_vesselcategory_master');
        $this->db->where('vesselcategory_status',1);
        $this->db->where('delete_status','0');
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
        $this->db->where('delete_status','0');
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
        $this->db->where('delete_status','0');
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
        $this->db->where('delete_status','0');
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
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_typeid_length($id)
    {
        $this->db->select('*');
        $this->db->from('kiv_vesseltype_master');
        $this->db->where('vesseltype_sl',$id);
        $this->db->where('vesseltype_status',1);
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_details');
        $this->db->where('vessel_sl',$vessel_id); 
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_details($id)
    {
        $this->db->select('*');
         $this->db->select('c.survey_id as sid');
        $this->db->from('tbl_kiv_vessel_details a');
        $this->db->join('tbl_kiv_form_stage b','a.vessel_sl=b.vessel_id');
        $this->db->join('tbl_kiv_status_details c','a.vessel_sl=c.vessel_id');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_sl=d.vessel_id');
      //$this->db->where('a.vessel_user_id',$id);
        $this->db->where('d.user_id',$id);
        $this->db->where('d.status',1);
        $this->db->order_by('a.vessel_sl','ASC');
      //$this->db->limit(3,0);
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
    function get_reference_number_details($current_year)
    {
        $this->db->select('reference_number');
        $this->db->from('tbl_kiv_vessel_details');
        $this->db->like('vessel_created_timestamp', $current_year);
        $this->db->where('delete_status',0);
        $this->db->order_by('vessel_sl','DESC');
        $this->db->limit(1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
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
    function get_inboard_outboard_name($engine_placement_id)
    {
        $this->db->select('*');
        $this->db->from('kiv_inboard_outboard_master');
        $this->db->where('inboard_outboard_status',1);
        $this->db->where('inboard_outboard_sl',$engine_placement_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
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
    function get_equipment_details_id($equipment_type_id)
    {
        $this->db->select('*');
        $this->db->from('kiv_equipment_master');
         $this->db->where('equipment_type_id',$equipment_type_id);
        $this->db->where('equipment_status',1);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
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
        $query =    $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_bankname($bank_sl)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_master');
        $this->db->where('bank_sl',$bank_sl);
        $this->db->where('delete_status',0);
            $query =    $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    /*function get_portofregistry()
    {
        $this->db->select('*');
        $this->db->from('kiv_portofregistry_master ');
        $this->db->where('portofregistry_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('portofregistry_name','ASC');
        $query 	= 	$this->db->get();
        $result = 	$query->result_array();
        return $result;
    }*/
    function get_portofregistry()
    {
        $this->db->select('*');
        $this->db->from('tbl_portoffice_master');
        $this->db->where('kiv_status',1);
        $this->db->order_by('vchr_portoffice_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    /*function get_registry_port_id($id)
    {
        $this->db->select('*');
        $this->db->from('kiv_portofregistry_master');
        $this->db->where('portofregistry_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('portofregistry_sl',$id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }*/
    function get_registry_port_id($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_portoffice_master');
        $this->db->where('kiv_status',1);
        $this->db->where('int_portoffice_id',$id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_port_registry_user_id($id)
    {
        $this->db->select('*');
        $this->db->from('user_master');
        $this->db->where('user_master_port_id',$id);
        $this->db->where('user_master_status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    /*//------------Vessel Details in View page------------//
    function get_vessel_details_viewpage($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_details');
        $this->db->where('vessel_sl',$vessel_id);
        $query 	= 	$this->db->get();
        $result = 	$query->result_array();
        return $result;
    }*/
    function get_vessel_details_viewpage($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_details a');
        $this->db->join('tbl_kiv_user_vessel b', 'a.vessel_sl=b.vessel_id');
        $this->db->where('b.status','1');
        $this->db->where('a.vessel_sl',$vessel_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_details_regnum($regnum)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_details');
        $this->db->where('vessel_registration_number',$regnum);
        $query  =   $this->db->get();
        $result =   $query->result_array();
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
        $this->db->select('vesseltype_code');
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
    function get_hull_details($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_hulldetails');
        $this->db->where('vessel_id',$vessel_id);
         $this->db->where('survey_id',$survey_id);
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
    function get_engine_details($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_engine_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query=$this->db->get();
        $result=$query->result_array();
        return $result;
    }
    function get_equipment_details_view($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_equipment_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
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
    /*function get_list_document_vessel($id)
    {
        $this->db->select('*');
        $this->db->from('kiv_document_master');
        $this->db->where('document_status',1);
        $this->db->where('document_type_id',1); 
        $this->db->where('delete_status',0);
        $query 	= 	$this->db->get();
        $result = 	$query->result_array();
        return $result;
    }*/
    function get_list_document_vessel()
    {
        $this->db->select('*');
        $this->db->from('kiv_document_master');
        $this->db->where('document_status',1);
        $this->db->where('document_type_id',1); 
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    } 
    function document_vessel($vessel_id,$survey_id,$document_type_id)
    {
        $this->db->select('a.document_name AS pdfname,b.document_name AS listname,a.document_id as Id');
        $this->db->from('tbl_kiv_fileupload_details a');
       $this->db->join('kiv_document_master b','a.document_id=b.document_sl');
       //$this->db->join('kiv_document_master b','a.document_type_id=b.document_type_sl');
        $this->db->where('b.document_status',1);
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where('a.survey_id',$survey_id);
        $this->db->where('a.document_type_id',$document_type_id); 
        $this->db->where('b.delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
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
    function get_hull_details_edit($id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_hulldetails');
        $this->db->where('vessel_id',$id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query 	= 	$this->db->get();
        $result = 	$query->result_array();
        return $result;
    }
    function get_hull_bulkhead_details_edit($id,$survey_id)
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
    function get_engine_details_edit($id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_engine_details');
        $this->db->where('vessel_id',$id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query 	= 	$this->db->get();
        $result = 	$query->result_array();
        return $result;
    }
    function get_engine_details_edit_count($id,$survey_id)
    {
        $this->db->select('COUNT(*) AS engine_count');
        $this->db->from('tbl_kiv_engine_details');
        $this->db->where('vessel_id',$id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query 	= 	$this->db->get();
        $result = 	$query->result_array();
        return $result;
    }
    function get_equipment_details_edit($vessel_id,$equipment_id,$survey_id)
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
    function  get_type_equipment_details_edit($vessel_id,$equipment_type_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_equipment_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('equipment_type_id',$equipment_type_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query 	= 	$this->db->get();
        $result = 	$query->result_array();
        return $result;
    }
    function  get_type_equipment_details_view($vessel_id,$equipment_id, $equipment_type_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_equipment_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('equipment_type_id',$equipment_type_id);
        $this->db->where('equipment_id',$equipment_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_fire_extinguisher_details_edit($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_fire_extinguisher_details a');
        $this->db->join('kiv_portable_fire_extinguisher_master b', 'a.fire_extinguisher_type_id=b.portable_fire_extinguisher_sl');
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where('a.survey_id',$survey_id);
        $this->db->where('a.delete_status',0);
        $this->db->order_by('b.portable_fire_extinguisher_name');
        $query 	= 	$this->db->get();
        $result = 	$query->result_array();
        return $result;
    } 
    function get_firepump_details_edit($id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_firepumps_details a');
        $this->db->join('kiv_firepumptype_master b','a.firepumptype_id=b.firepumptype_sl');
        $this->db->where('a.vessel_id',$id);
        $this->db->where('a.survey_id',$survey_id);
        $this->db->where('a.delete_status',0);
        $query 	= 	$this->db->get();
        $result = 	$query->result_array();
        return $result;
    } 
    function get_otherequipment_edit($vessel_id,$equipment_type_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_equipment_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
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
    function get_doc_file_edit($id,$document_id,$survey_id)
    {
        $this->db->select('fileupload_details_sl,document_id,document_name');
        $this->db->from('tbl_kiv_fileupload_details');
        $this->db->where('vessel_id',$id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('document_id',$document_id);
        $query 	= 	$this->db->get();
        return $query->row();
    } 
    function get_payment_details_edit($id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details');
        $this->db->where('vessel_id',$id);
        $this->db->where('survey_id',$survey_id);
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
    function insert_table($table,$data)
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
    function update_bulkhead_update($tablename,$data_update,$id)
    {
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
        $updquery   = $this->db->update_string($tablename, $data_update, $where);
        $result     = $this->db->query($updquery);
        return $result; 
    }
    function get_document_id($vessel_id,$id,$survey_id)
    {
        $this->db->select('count(*) as cnt');
        $this->db->from('tbl_kiv_fileupload_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('document_id',$id);
        $this->db->where('document_type_id',1);
        $this->db->where('survey_id',$survey_id);
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

    /*function get_vessel_created_user($vessel_sl)       
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_details a');
        $this->db->join('user_master b','a.vessel_created_user_id=b.user_master_id');
        $this->db->join('tbl_kiv_user c','b.customer_id=c.user_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_sl=d.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('a.vessel_sl',$vessel_sl);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }*/
    function get_vessel_created_user($vessel_sl)       
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_details a');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_sl=d.vessel_id');
        $this->db->join('user_master b','d.user_id=b.user_master_id');
        $this->db->join('tbl_kiv_user c','b.customer_id=c.user_sl');
        $this->db->where('d.status',1);
        $this->db->where('a.vessel_sl',$vessel_sl);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_process_flow($processflow_sl)       
    {
        $this->db->select('*');
        $this->db->select('c.user_id as uid');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel c','c.vessel_id=b.vessel_sl');
        $this->db->where('c.status',1);
        $this->db->where('a.processflow_sl',$processflow_sl);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_process_flow_payment($processflow_sl)       
    {
        $this->db->select('*');
        $this->db->select('c.user_id as uid');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel c','c.vessel_id=b.vessel_sl');
        $this->db->where('c.status',1);
        $this->db->where('a.processflow_sl',$processflow_sl);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_process_flow_annual($processflow_sl)       
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->where('a.processflow_sl',$processflow_sl);
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->where('d.status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_process_flow_cs($user_id)       
    {
        $id=array(1,5,11,12,13,22,23,24,26,31);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
         // $this->db->where('d.user_id',$id);
        $this->db->where('d.status',1);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.status',1);
        $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_process_flow_cs_special($user_id)       
    {
        $id=array(28);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        //$this->db->join('tbl_kiv_vessel_timeline c','c.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
       // $this->db->where('c.registration_number!=','');
        $this->db->where('d.status',1);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_process_flow_pc($user_id)       
    {
        $id=array(1,5,7,14,15,18,26,38,39,40,41,42,31);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.status',1);
        $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_pending_payment()
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->where('a.payment_approved_status',0);
        $this->db->order_by('a.dd_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_approved_payment($user_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->where('a.payment_approved_user_id',$user_id);
        $this->db->where('a.payment_approved_status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_approved_payment_date($user_id,$from_date,$to_date)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->where('a.payment_approved_user_id',$user_id);
        $this->db->where('a.payment_approved_status',1);
        $this->db->where('a.dd_date >=', $from_date);
        $this->db->where('a.dd_date <=', $to_date);
        $this->db->order_by('a.dd_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    
    function get_form4_process_flow_cs($user_id)       
    {
        $id=array(6,17);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.current_status_id',2);
        $this->db->where('a.status',1);
        $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form7_process_flow_cs($user_id)       
    {
        $id=array(10,21);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','b.vessel_sl=d.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.current_status_id',1);
        $this->db->where('a.status',1);
        $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form7_process_flow_csde($user_id,$vessel_id)       
    {
        $id=array(10,21);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','b.vessel_sl=d.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where('a.current_status_id',1);
        $this->db->where('a.status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form8_process_flow($user_id,$vessel_id)       
    {
        $id=array(11,22);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->where('a.user_id',$user_id);
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.current_status_id',2);
        $this->db->where('a.status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form56_process_flow_cs($user_id)       
    {
        $id=array(8,9,19,20);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.status',1);
         $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form7_process_flow($user_id)       
    {
        $id=array(10,21);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','b.vessel_sl=d.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        //$this->db->where('a.current_status_id',2);
        $this->db->where('a.status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form4_cs($user_id)       
    {
        $id=array(6,17);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.current_status_id',2);
        $this->db->where('a.status',1);
         $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form56_cs($user_id)       
    {
        $id=array(8,9,19,20);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        //$this->db->where('a.current_status_id',2);
        $this->db->where('a.status',1);
        $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form7_cs($user_id)       
    {
        $id=array(10,21);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.current_status_id',1);
        $this->db->where('a.status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_process_flow_sr($user_id)       
    {
       $id=array(1,2,3,4,5,11,22,23,24,26);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
         // $this->db->where('d.user_id',$id);
        $this->db->where('d.status',1);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('process_id',$id);
        //$this->db->where('survey_id',1);
        $this->db->where('a.status',1);
        $this->db->where('a.processflow_sl NOT IN (SELECT process_flow_id FROM tbl_kiv_task)', NULL, FALSE);
        $this->db->order_by('a.status_change_date','DESC');
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
    function get_vessel_details_owner($id)
    {
        $this->db->select('*');
        $this->db->select('c.survey_id as sid');
        $this->db->from('tbl_kiv_vessel_details a');
        $this->db->join('tbl_kiv_processflow c','a.vessel_sl=c.vessel_id');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_sl=d.vessel_id');
        $this->db->join('tb_vessel_main b','a.vessel_sl=b.vesselmain_vessel_id');
        $this->db->where('b.vesselmain_reg_number!=','0');
        $this->db->where('d.user_id',$id);
        $this->db->where('c.user_id',$id);
        $this->db->where('c.process_id>=',14);
        $this->db->where('d.status',1);
        $this->db->where('c.status',1);
        $this->db->order_by('a.vessel_sl','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    /*function get_vessel_details_owner_id($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_details a');
        $this->db->join('tb_vessel_main b','a.vessel_sl=b.vesselmain_vessel_id');
        $this->db->where('b.vesselmain_reg_number!=',0);
        $this->db->where('b.vesselmain_owner_id',$id);
        $this->db->order_by('a.vessel_sl','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }*/
    /*function get_process_flow_show($vessel_sl, $sess_usr_id)       
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_user_vessel b','a.vessel_id=b.vessel_id');
        $this->db->where('a.vessel_id',$vessel_sl);
        $this->db->where('b.user_id',$sess_usr_id);
        $this->db->where('a.status',1);
        $this->db->where('b.status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }*/
    function get_survey_activity_keel_count($vessel_id,$survey_id)       
    {
        $this->db->select('count(*) as keel_count');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('vessel_id',$vessel_id);
         $this->db->where('survey_id',$survey_id);
        $this->db->where('process_id',2);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form_number_cs($process_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processname');
        $this->db->where('processname_sl',$process_id);
        $this->db->where('status',1);
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
    function get_survey_activity_approve($vessel_id,$current_status_id,$process_id,$survey_id)       
    {
        $this->db->select('count(*) as approve_count');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('current_status_id',$current_status_id);
        $this->db->where('process_id',$process_id);
        $this->db->where('survey_id',$survey_id);
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
    function get_survey_activity_hull_count($vessel_id,$survey_id)       
    {
        $this->db->select('count(*) as hull_count');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('vessel_id',$vessel_id);
         $this->db->where('survey_id',$survey_id);
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
        $this->db->from('user_master a');
        $this->db->join('tbl_kiv_user b','a.customer_id=b.user_sl');
        $this->db->where('a.user_master_id',$id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_payment_userdetails($user_sl)       
    {
        $this->db->select('*');
        $this->db->from('user_master a');
        $this->db->join('tbl_kiv_user b','a.customer_id=b.user_sl');
        $this->db->where('a.user_master_id',$user_sl);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_user_id_cs($user_type_id_cs)
    {
        $this->db->select('*');
        $this->db->from('user_master');
        $this->db->where('user_master_id_user_type',$user_type_id_cs);
        $this->db->where('user_master_status','1');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_surveyor_details()
    {
        $this->db->select('*');
        $this->db->from('user_master');
        $this->db->where_in('user_master_id_user_type',13);
        $this->db->where('user_master_status',1);
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
    function update_tbl_vessel_details($table,$data,$id)
    {
        $where      =   "vessel_sl  = $id"; 
        $updquery   =   $this->db->update_string($table, $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }
    function get_user_master($sesson_id)     
    {
        $this->db->select('*');
        $this->db->from('user_master a');
        $this->db->join('user_type b', 'a.user_master_id_user_type=b.user_type_id');
        $this->db->where('a.user_master_id',$sesson_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_usertype_master($user_type_id)
    {
        $this->db->select('*');
        $this->db->from('user_type');
        $this->db->where('user_type_id',$user_type_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    //___________________________new insertion____________//
    function get_usertype_master_header($user_type_id)
    {
        $this->db->select('*');
        $this->db->from('user_type');
        $this->db->where('user_type_id',$user_type_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_user_master_header($sesson_id)     
    {
        $this->db->select('*');
        $this->db->from('user_master a');
        $this->db->join('user_type b', 'a.user_master_id_user_type=b.user_type_id');
        $this->db->where('a.user_master_id',$sesson_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
     //___________________________new insertion____________//
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
        $this->db->where('status_id!=',2);
        $this->db->where('status_id!=',3);
        $this->db->where('status_id!=',6);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
     }
    function get_status_sr1()
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_status');
        $this->db->where('status_id',2);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_kiv_status($current_status_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_status');
        $this->db->where('status_id',$current_status_id);
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
    function get_status_cs_sr1()
    {
        $id=array(4,5);
        $this->db->select('*');
        $this->db->from('tbl_kiv_status');
        $this->db->where_in('status_id',$id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_status_cs_sr2()
    {
        $id=array(2);
        $this->db->select('*');
        $this->db->from('tbl_kiv_status');
        $this->db->where_in('status_id',$id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_status_form3()
    {
        $id=array(5,6);
        $this->db->select('*');
        $this->db->from('tbl_kiv_status');
        $this->db->where_in('status_id',$id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_status_form2()
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
        $this->db->from('user_master');
        $this->db->where('user_master_id',$user_id);
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
    function get_status_details($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_status_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_status_details_vessel_sl($vessel_id)
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
        $this->db->order_by('a.status_change_date','DESC');
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
    function update_registration_intimation($table,$data,$registration_intimation_sl)
    {
        $where      =   "registration_intimation_sl  = $registration_intimation_sl"; 
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
    /*function get_length_overthedeck($vessel_type_id,$vessel_subtype_id,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id)
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
        $this->db->where('a.heading_id',$heading_id);
        $this->db->where('a.delete_status',0);
        $this->db->where('a.status',1);
        $this->db->where_in('a.label_value_status',$status);
        $this->db->order_by('a.length_over_deck','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    */
    function get_length_overthedeck($vessel_type_id,$vessel_subtype_id,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id)
    {
        $status=array(1,2);
        $this->db->distinct();
        $this->db->select('length_over_deck');
        $this->db->from('kiv_dynamic_field_master ');
        $this->db->where('vesseltype_id',$vessel_type_id);
        $this->db->where('vessel_subtype_id',$vessel_subtype_id);
        $this->db->where('hullmaterial_id',$hullmaterial_id);
        $this->db->where('engine_inboard_outboard',$engine_placement_id);
        $this->db->where('form_id',$form_id);
        $this->db->where('heading_id',$heading_id);
        $this->db->where('delete_status',0);
        $this->db->where('status',1);
        $this->db->where_in('label_value_status',$status);
        $this->db->order_by('length_over_deck','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_label_control_details($vessel_type_id, $vessel_subtype_id, $vessel_length, $hullmaterial_id, $engine_placement_id, $form_id, $heading_id)
    {
        $status=array(1,2);
        $this->db->select('*');
        $this->db->from('kiv_dynamic_field_master a');
        $this->db->join('kiv_label_master b','a.label_id=b.label_sl');
        $this->db->where('a.vesseltype_id',$vessel_type_id);
        $this->db->where('a.vessel_subtype_id',$vessel_subtype_id);
        $this->db->where('a.length_over_deck',$vessel_length);
        $this->db->where('a.hullmaterial_id',$hullmaterial_id);
        $this->db->where('a.engine_inboard_outboard',$engine_placement_id);
        $this->db->where('a.form_id',$form_id);
        $this->db->where('a.heading_id',$heading_id);
        $this->db->where('a.delete_status',0);
        $this->db->where('a.status',1);
        $this->db->where_in('a.label_value_status',$status);
        $this->db->order_by('b.label_sl','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array(); //print_r($result);
        return $result;
    }
    function get_label_control_details_ajax($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id)
    {
        $status=array(1,2);
        $this->db->select('*');
        $this->db->from('kiv_dynamic_field_master a');
        $this->db->join('kiv_label_master b','a.label_id=b.label_sl');
        $this->db->where('a.vesseltype_id',$vessel_type_id);
        $this->db->where('a.vessel_subtype_id',$vessel_subtype_id);
        $this->db->where('a.length_over_deck',$vessel_length);
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
        $this->db->from('kiv_tariff_master');
        $this->db->where('tariff_activity_id',$activity_id);
        $this->db->where('tariff_form_id',$form_id);
        $this->db->where('tariff_vessel_type_id',$vessel_type_id);
        $this->db->where('tariff_vessel_subtype_id',$vessel_subtype_id);
       // $this->db->where('tariff_tonnagetype_id',1);
        $this->db->where('tariff_day_type',1);
        $this->db->where('delete_status',0);
       // $this->db->where('tariff_status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_tariff_dtls($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id)
    {
         $this->db->select('*');
        $this->db->from('kiv_tariff_master');
        $this->db->where('tariff_activity_id',$survey_id);
        $this->db->where('tariff_form_id',$form_id);
        $this->db->where('tariff_vessel_type_id',$vessel_type_id);
        $this->db->where('tariff_vessel_subtype_id',$vessel_subtype_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_tariff_form3($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage,$numberofdays)
    {
        $this->db->select('*');
        $this->db->from('kiv_tariff_master');
        $this->db->where('tariff_activity_id',$survey_id);
        $this->db->where('tariff_form_id',$form_id);
        $this->db->where('tariff_vessel_type_id',$vessel_type_id);
        $this->db->where('tariff_vessel_subtype_id',$vessel_subtype_id);
        $this->db->where('delete_status',0);
        $this->db->where("$vessel_total_tonnage between tariff_from_ton and tariff_to_ton", NULL, FALSE );
        $this->db->where("$numberofdays between tariff_from_day and tariff_to_day", NULL, FALSE );
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_tariff_form3_366($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage)
    {
        $this->db->select('*');
        $this->db->from('kiv_tariff_master');
        $this->db->where('tariff_activity_id',$survey_id);
        $this->db->where('tariff_form_id',$form_id);
        $this->db->where('tariff_vessel_type_id',$vessel_type_id);
        $this->db->where('tariff_vessel_subtype_id',$vessel_subtype_id);
        $this->db->where('delete_status',0);
        $this->db->where("$vessel_total_tonnage between tariff_from_ton and tariff_to_ton", NULL, FALSE );
       $this->db->where("tariff_from_day",366);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_tariff_form2($survey_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage)
    {
        $this->db->select('*');
        $this->db->from('kiv_tariff_master');
        $this->db->where('tariff_activity_id',$survey_id);
        $this->db->where('tariff_form_id',$form_id);
        $this->db->where('tariff_vessel_type_id',$vessel_type_id);
        $this->db->where('tariff_vessel_subtype_id',$vessel_subtype_id);
        $this->db->where('delete_status',0);
        $this->db->where("$vessel_total_tonnage between tariff_from_ton and tariff_to_ton", NULL, FALSE );
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_label_details_ajax($form_id,$heading_id1)
    {
        $this->db->select('label_sl');
        $this->db->from('kiv_label_master');
        $this->db->where('form_id',$form_id);
        $this->db->where('heading_id',$heading_id1);
        $this->db->where('label_status',1);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_tariff_details_typeid2($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage)
    {
        $this->db->select('*');
        $this->db->from('kiv_tariff_master');
        $this->db->where('tariff_activity_id',$activity_id);
        $this->db->where('tariff_form_id',$form_id);
        $this->db->where('tariff_vessel_type_id',$vessel_type_id);
        $this->db->where('tariff_vessel_subtype_id',$vessel_subtype_id);
        $this->db->where('tariff_tonnagetype_id',2);
        $this->db->where('tariff_day_type',1);
        $this->db->where('delete_status',0);
        $this->db->where("$vessel_total_tonnage between tariff_from_ton and tariff_to_ton", NULL, FALSE );
       // $this->db->where('tariff_status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }

    function get_tariff_details_typeid3($activity_id,$form_id,$vessel_type_id,$vessel_subtype_id,$vessel_total_tonnage)
    {
        $this->db->select('*');
        $this->db->from('kiv_tariff_master');
        $this->db->where('tariff_activity_id',$activity_id);
        $this->db->where('tariff_form_id',$form_id);
        $this->db->where('tariff_vessel_type_id',$vessel_type_id);
        $this->db->where('tariff_vessel_subtype_id',$vessel_subtype_id);
        $this->db->where('tariff_tonnagetype_id',3);
        $this->db->where('tariff_day_type',1);
        $this->db->where('delete_status',0);
        $this->db->where("$vessel_total_tonnage between tariff_from_ton and tariff_to_ton", NULL, FALSE );
       // $this->db->where('tariff_status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }

    function get_tonnage_details($vessel_id)
    {
        $this->db->select('vessel_total_tonnage');
        $this->db->from('tbl_kiv_vessel_details');
        $this->db->where('vessel_sl',$vessel_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    /*function get_vessel_details_dynamic($vessel_id)
    {
        $this->db->select('a.vessel_type_id,a.vessel_subtype_id,a.vessel_length,b.hullmaterial_id,c.engine_placement_id');
        $this->db->from('tbl_kiv_vessel_details a');
        $this->db->join('tbl_kiv_hulldetails b','a.vessel_sl=b.vessel_id');
        $this->db->join('tbl_kiv_engine_details c','a.vessel_sl=c.vessel_id');
        $this->db->where('a.vessel_sl',$vessel_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }*/
    function get_vessel_details_dynamic($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_condition');
        $this->db->where('vessel_id',$vessel_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_no_of_engineset_dynamic($vessel_id,$survey_id)
    {
        $this->db->select('COUNT(*) as engine_count');
        $this->db->from('tbl_kiv_engine_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_hull_details_dynamic($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_hulldetails');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_engine_details_dynamic($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_engine_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
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
    function update_table_engine_byvessel($table,$data,$id)
    {
        $where      =   "vessel_id  = $id"; 
        $updquery   =   $this->db->update_string($table, $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }
    function get_chain_ids($vessel_id,$equipment_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_equipment_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('equipment_id',$equipment_id);
        $this->db->where('survey_id',$survey_id);
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
        $this->db->select('user_master_fullname');
        $this->db->from('user_master');
        $this->db->where('user_master_id',$sess_usr_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_placeof_survey()
    {
        $this->db->select('*');
        $this->db->from('kiv_placeofsurvey_master');
        $this->db->where('placeofsurvey_status','1');
        $this->db->where('delete_status','0');
        $this->db->order_by('placeofsurvey_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_placeofsurvey_code($placeofsurvey_sl)
    {
        $this->db->select('*');
        $this->db->from('kiv_placeofsurvey_master');
        $this->db->where('placeofsurvey_sl',$placeofsurvey_sl);
        $this->db->where('placeofsurvey_status','1');
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_survey_intimation($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_survey_intimation a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('kiv_placeofsurvey_master c','a.placeofsurvey_id=c.placeofsurvey_sl');
        $this->db->join('user_master d','b.vessel_user_id=d.user_master_id');
        $this->db->join('tbl_kiv_user e','e.user_sl=d.customer_id');
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where('a.survey_id',$survey_id);
        $this->db->where('a.status','1');
        $this->db->where('a.form_id','4');
        $this->db->where('a.delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_survey_intimation_cs($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_survey_intimation');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('form_id','4');
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_defect_count($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_survey_defects a'); 
        $this->db->join('tbl_kiv_survey_intimation b','a.intimation_id=b.intimation_sl');
        $this->db->where('b.vessel_id',$vessel_id);
        $this->db->where('b.survey_id',$survey_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_form3_tariff($vessel_id,$survey_id,$formnumber)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('form_number',$formnumber);
        $this->db->where('payment_approved_status',1);
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function update_defect_table($tablename,$data_update,$id)
    {
        $where      = "survey_defects_sl  = $id"; 
        $updquery   =   $this->db->update_string($tablename, $data_update, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }

    function update_intimation_table($tablename,$data_update,$id)
    {
        $where      = "intimation_sl  = $id"; 
        $updquery   =   $this->db->update_string($tablename, $data_update, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }
    function get_survey_defect($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_survey_intimation a');
        $this->db->join('tbl_kiv_survey_defects b','a.intimation_sl=b.intimation_id');
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where('a.survey_id',$survey_id);
        $this->db->where('b.status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_survey_intimation_details($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_survey_intimation');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('status','2');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_survey_intimation_details_owner($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_survey_intimation');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('status','1');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_survey_intimation_defects($survey_defects_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_survey_defects');
        $this->db->where('survey_defects_sl',$survey_defects_id);
        $this->db->where('status','1');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_survey_intimation_defects_owner($survey_defects_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_survey_defects');
        $this->db->where('survey_defects_sl',$survey_defects_id);
        $this->db->where('status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_survey_defect_details($survey_defects_sl,$vessel_id)
    {
        $this->db->select('b.*,c.placeofsurvey_name,d.reference_number');
        $this->db->from('tbl_kiv_survey_intimation a');
        $this->db->join('tbl_kiv_survey_defects b','a.intimation_sl=b.intimation_id');
        $this->db->join('kiv_placeofsurvey_master c','b.placeofsurvey_id=c.placeofsurvey_sl');
        $this->db->join('tbl_kiv_vessel_details d','a.vessel_id=d.vessel_sl');
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where('b.survey_defects_sl',$survey_defects_sl);
        $this->db->where('b.status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function update_table_engine_form6($table,$data,$id)
    {
        $where      =   "vessel_id  = $id"; 
        $updquery   =   $this->db->update_string($table, $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }
    function get_crew_details($vessel_id,$survey_id)
    {
        $this->db->select('a.crew_type_id');
        $this->db->select('a.name_of_type');
        $this->db->select('a.license_number_of_type');
        $this->db->select('b.crew_type_name');
        //$this->db->select('c.crew_class_name');
        $this->db->from('tbl_kiv_crew_details a');
        $this->db->join('kiv_crew_type_master b','a.crew_type_id=b.crew_type_sl');
        //$this->db->join('kiv_crew_class_master c','a.crew_class_id=c.crew_class_sl');
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where('a.survey_id',$survey_id);
        $this->db->where('a.delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_crew_details_master_serang($vessel_id,$survey_id,$crew_type_sl)
    {
        $this->db->select('a.name_of_type');
        $this->db->select('a.license_number_of_type');
        $this->db->select('b.crew_type_name');
        //$this->db->select('c.crew_class_name');
        $this->db->from('tbl_kiv_crew_details a');
        $this->db->join('kiv_crew_type_master b','a.crew_type_id=b.crew_type_sl');
        //$this->db->join('kiv_crew_class_master c','a.crew_class_id=c.crew_class_sl');
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where('a.survey_id',$survey_id);
        $this->db->where('a.crew_type_id',$crew_type_sl);
        $this->db->where('a.delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_buoyancy_apparatus($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_plyingstate');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    //start form9,form10 view details//
    /*function get_lifebouy($vessel_id,$equipment_id)
     {
        $this->db->select('*');
        $this->db->from('tbl_kiv_equipment_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('equipment_id',$equipment_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
     }
     function get_hose($vessel_id)
     {
        $this->db->select('*');
        $this->db->from('tbl_kiv_equipment_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('equipment_id',16);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
     }*/
    function get_bilgepump($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_bilgepump_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_firepumps($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_firepumps_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_portablefire_extinguisher($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_fire_extinguisher_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_portablefire_extinguisher_type($id)
    {
        $this->db->select('*');
        $this->db->from('kiv_portable_fire_extinguisher_master');
        $this->db->where('portable_fire_extinguisher_sl',$id);
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_fuel($id)
    {
        $this->db->select('*');
        $this->db->from('kiv_fuel_master');
        $this->db->where('fuel_sl',$id);
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_fuel_details()
    {
        $this->db->select('*');
        $this->db->from('kiv_fuel_master');
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_condition_status($id)
    {
        $this->db->select('*');
        $this->db->from('kiv_conditionstatus_master');
        $this->db->where('conditionstatus_sl',$id);
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_cargo_nature_name($id)
    {
        $this->db->select('*');
        $this->db->from('kiv_natureofoperation_master');
        $this->db->where('natureofoperation_sl',$id);
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_cargo_nature()
    {
        $this->db->select('*');
        $this->db->from('kiv_natureofoperation_master');
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_firepumptype_name($id)
    {
        $this->db->select('*');
        $this->db->from('kiv_firepumptype_master');
        $this->db->where('  firepumptype_sl',$id);
        $this->db->where('delete_status',0);
        $query=$this->db->get();
        $result=$query->result_array();
        return $result;
    }
    function get_equipment_details_anchors($vessel_id,$survey_id)
    {
        $id=array(1,2,3);
        $this->db->select('*');
        $this->db->from('tbl_kiv_equipment_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where_in('equipment_id',$id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_firepumps_typenumber($vessel_id,$firepumptype_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_firepumps_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('firepumptype_id',$firepumptype_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
     }

    function get_formtype_location()
    {
        $this->db->select('*');
        $this->db->from('kiv_formtype_location_master');
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_sandbox_location()
    {
        $this->db->select('*');
        $this->db->from('kiv_location_master');
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_garbage_bucket_provider($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_garbage_bucket_provider_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
     }
    function get_garbage_details()
    {
        $this->db->select('*');
        $this->db->from('kiv_garbage_master');
        $this->db->where('garbage_status',1);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_garbage_details_view($garbage_id)
    {
        $this->db->select('*');
        $this->db->from('kiv_garbage_master');
        $this->db->where('garbage_sl',$garbage_id);
        $this->db->where('garbage_status',1);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_timeline_lastdrydock($vessel_id,$survey_id,$subprocess_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',$survey_id);
        $this->db->where('subprocess_id',$subprocess_id);
        $this->db->where('delete_status',0);
        $this->db->where('status',1);
        $this->db->order_by('timeline_sl','DESC');
        $this->db->limit(1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
     }
    function get_vessel_timeline_lastdrydock_timesl($timeline_sl)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('timeline_sl',$timeline_sl);
        $this->db->where('status',1);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_timeline_nextdrydock_timesl($timeline_sl)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('link_id',$timeline_sl);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_timeline_nextdrydock($vessel_id,$survey_id,$subprocess_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',$survey_id);
        $this->db->where('subprocess_id',$subprocess_id);
        $this->db->where('delete_status',0);
        $this->db->where('status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_timeline_nextdate($vessel_id,$survey_id,$subprocess_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',$survey_id);
        $this->db->where('subprocess_id',$subprocess_id);
        $this->db->where('delete_status',0);
        $this->db->where('status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_timeline_initialsurvey($vessel_id,$survey_id,$subprocess_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',$survey_id);
        $this->db->where('subprocess_id',$subprocess_id);
        $this->db->where('delete_status',0);
        $this->db->where('status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    //end form9,form10 view details //
    function get_form_payment_details($vessel_id,$survey_id,$form_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('form_number',$form_id);
        $this->db->where('payment_approved_status',0);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_month_details($id)
    {
        $this->db->select('*');
        $this->db->from('kiv_month_master');
        $this->db->where('month_sl',$id);
        $this->db->where('month_status',1);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_processactivity($vessel_id,$survey_id,$process_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processactivity_date');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('process_id',$process_id);
        $this->db->where('activity_date is NOT NULL', NULL, FALSE);
        $this->db->order_by('date_sl','desc');
         $this->db->limit(2);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_processactivity_form1($vessel_id,$survey_id,$process_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processactivity_date');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('process_id',$process_id);
        $this->db->where('approved_date IS NULL', NULL, FALSE);
        $this->db->order_by('date_sl','desc');
       // $this->db->order_by('date_sl','ASC');
         $this->db->limit(2);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_processactivity_approved($vessel_id,$survey_id,$process_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processactivity_date');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('process_id',$process_id);
        $this->db->where('approved_date is NOT NULL', NULL, FALSE);
        $this->db->order_by('date_sl','desc');
         $this->db->limit(1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_processactivity_date_remarks($vessel_id,$survey_id,$process_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processactivity_date');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('process_id',$process_id);
        //$this->db->where('approved_date is NOT NULL', NULL, FALSE);
        $this->db->order_by('date_sl','desc');
        $this->db->limit(1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form3_date($vessel_id,$process_id,$survey_id,$current_status_id,$user_type_id,$sess_usr_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',$process_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('current_status_id',$current_status_id);
        $this->db->where('current_position',$user_type_id);
        $this->db->where('user_id',$sess_usr_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form1_final($vessel_id,$process_id,$survey_id,$current_status_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',$process_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('current_status_id',$current_status_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form3_appdate($vessel_id,$process_id,$survey_id,$current_status_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',$process_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('current_status_id',$current_status_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_forms_data($vessel_id,$process_id,$survey_id,$current_status_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',$process_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('current_status_id',$current_status_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vesseltype_dynamic()
{
    $this->db->select('vesseltype_sl');
    $this->db->select('vesseltype_name');
    $this->db->select('vesseltype_mal_name');
    $this->db->select('vesseltype_code');
    $this->db->select('vesseltype_status');
    $this->db->select('delete_status');

    $this->db->from('kiv_vesseltype_master');
    $this->db->where('delete_status', 0);

    $this->db->order_by('vesseltype_name','asc');
    
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
function get_survey_master()     
{
    $this->db->select('*');
    $this->db->from('kiv_survey_master');
    $this->db->where('survey_status', 1);
    $this->db->where('delete_status', 0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
 }
function get_survey_master_ra($survey_sl)     
{
    //$survey_sl=array(5,6,7,8,9,10,11,12);
    $this->db->select('*');
    $this->db->from('kiv_survey_master');
    $this->db->where_in('survey_sl',$survey_sl);
    $this->db->where('survey_status', 1);
    $this->db->where('delete_status', 0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
 }

 function get_formname_dynamic()
{
    $this->db->select('document_type_sl');
    $this->db->select('document_type_name');
    $this->db->select('document_type_mal_name');
    $this->db->from('kiv_document_type_master');
    $this->db->where('delete_status', 0);

    $this->db->order_by('document_type_sl','asc');
    
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;


}

    function get_survey_type($survey_id)
    {
        $this->db->select('*');
        $this->db->from(' kiv_survey_master');
        $this->db->where('survey_sl',$survey_id);
        $this->db->where('survey_status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function update_payment($table,$data,$payment_sl)
    {
        $where      =   "payment_sl  = $payment_sl"; 
        $updquery   =   $this->db->update_string($table, $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }   
    function get_passenger_details($vessel_id,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_passengerdetails');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
     
    }
    //-------------END---------------------//   
    //_____________Incomplete form and edit page_______________________//
    function get_incomplete_form1($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_details a');
        $this->db->join('tbl_kiv_form_stage b','a.vessel_sl=b.vessel_id');
        $this->db->join('tbl_kiv_vessel_condition c', 'a.vessel_sl=c.vessel_id');
        $this->db->where('a.vessel_user_id',$id);
        $this->db->where('b.stage_count!=',8,FALSE);
        $this->db->where('b.delete_status',0);
        $this->db->order_by('a.vessel_sl','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    /*----------------------------------------------------*/
    /*For Form 5*/
    /*Created by Aswathi*/
    function get_labels($vessel_type_id,$vessel_subtype_id,$vessel_length,$hullmaterial_id,$engine_placement_id,$form_id,$heading_id)
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
        //$this->db->where('label_id',$label_id);
        $this->db->where('delete_status',0);
        $this->db->where('status',1);
        $this->db->where_in('label_value_status',$status);
        $this->db->order_by('label_id','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_condition()
    {
        $this->db->select('*');
        $this->db->from('kiv_conditionstatus_master');
        $this->db->where('conditionstatus_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('conditionstatus_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_meansofpropulsionShaft()
    {
        $this->db->select('*');
        $this->db->from('kiv_meansofpropulsion_master');
        $this->db->where('meansofpropulsion_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('meansofpropulsion_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_enginetype()
    {
        $this->db->select('*');
        $this->db->from('kiv_enginetype_master');
        $this->db->where('enginetype_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('enginetype_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_enginetype_name($enginetype_sl)
    {
        $this->db->select('*');
        $this->db->from('kiv_enginetype_master');
        $this->db->where('enginetype_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('enginetype_sl',$enginetype_sl);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_equipmentMaterial()
    {
        $this->db->select('equipment_material_sl');
        $this->db->select('equipment_material_name');
        $this->db->from('kiv_equipment_material_master');
        $this->db->where('equipment_material_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('equipment_material_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_pollutionControldevice()
    {
        $this->db->select('pollution_controldevice_sl');
        $this->db->select('pollution_controldevice_name');
        $this->db->from('kiv_pollution_controldevice_master');
        $this->db->where('pollution_controldevice_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('pollution_controldevice_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_crewType()
    {
        $this->db->select('crew_type_sl');
        $this->db->select('crew_type_name');
        $this->db->from('kiv_crew_type_master');
        $this->db->where('crew_type_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('crew_type_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_crewClass()
    {
        $this->db->select('crew_class_sl');
        $this->db->select('crew_class_name');
        $this->db->from('kiv_crew_class_master');
        $this->db->where('crew_class_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('crew_class_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_choice()
    {
        $this->db->select('choice_sl');
        $this->db->select('choice_name');
        $this->db->from('kiv_choice_master');
        $this->db->where('choice_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('choice_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_plyingState()
    {
        $this->db->select('plyingstate_sl');
        $this->db->select('plyingstate_name');
        $this->db->from('kiv_plyingstate_master');
        $this->db->where('plyingstate_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('plyingstate_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_towing()
    {
        $this->db->select('towing_sl');
        $this->db->select('towing_name');
        $this->db->from('kiv_towing_master');
        $this->db->where('towing_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('towing_name','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_state($state_id)
    {
        $this->db->select('*');
        $this->db->from('kiv_state_master');
        $this->db->where('state_code',$state_id);
        $this->db->where('state_status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_location()
    {
        $this->db->select('*');
        $this->db->from('kiv_location_master');
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    /*Ends Form 5*/
     /*--------------------------------------------------------------*/  
    /*function get_completed_initial_survey_count()
    {

        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('process_id',1);
        $this->db->where('subprocess_id',1);
        $this->db->where('status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('timeline_sl','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    */
    function get_survey_count($process_id,$subprocess_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('process_id',$process_id);
        $this->db->where('subprocess_id',$subprocess_id);
        $this->db->where('status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('timeline_sl','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_survey_count_owner($process_id,$subprocess_id,$sess_usr_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline a');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->where('a.process_id',$process_id);
        $this->db->where('a.subprocess_id',$subprocess_id);
        $this->db->where('a.status',1);
        $this->db->where('a.delete_status',0);
        $this->db->where('d.status',1);
         $this->db->where('d.user_id',$sess_usr_id);
        $this->db->order_by('a.timeline_sl','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_forms_count($process_id,$survey_id,$user_id)       
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('process_id',$process_id);
        $this->db->where('survey_id',$survey_id);
        $this->db->where('user_id',$user_id);
        $this->db->where('status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_annualsurvey_count($user_id)       
    {
        $process_id=array(17,18,19,20,21,22,23,24);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where_in('process_id',$process_id);
        $this->db->where('survey_id',2);
        $this->db->where('user_id',$user_id);
        $this->db->where('status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_initialsurvey_request($user_id)       
    {
        $process_id=array(1,2,3,4,5,6,7,8,9,10,11,12,13);
       $this->db->select('*');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where_in('process_id',$process_id);
        $this->db->where('survey_id',1);
        $this->db->where('user_id',$user_id);
        $this->db->where('status',1);
        $this->db->order_by('status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }

    function get_initialsurvey_request_view($user_id)       
    {
        $process_id=array(1,2,3,4,5,6,7,8,9,10,11,12,13);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->join('tbl_kiv_form_stage e','a.vessel_id=e.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$process_id);
        $this->db->where('a.status',1);
        $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_annualsurvey_view($user_id)       
    {
        $process_id=array(17,18,19,20,21,22,23,24);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->join('tbl_kiv_form_stage e','a.vessel_id=e.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('a.survey_id',2);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$process_id);
        $this->db->where('a.status',1);
        $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_drydocksurvey_view($survey_id,$user_id)       
    {
        $process_id=array(26);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->join('tbl_kiv_form_stage e','a.vessel_id=e.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('a.survey_id',$survey_id);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$process_id);
        $this->db->where('a.status',1);
        $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_specialsurvey_view($survey_id,$user_id)       
    {
        $process_id=array(28);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->join('tbl_kiv_form_stage e','a.vessel_id=e.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('a.survey_id',$survey_id);
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$process_id);
        $this->db->where('a.status',1);
        $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_survey_forms_view($process_id,$survey_id,$user_id)       
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->join('tbl_kiv_form_stage e','a.vessel_id=e.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('a.survey_id',$survey_id);
        $this->db->where('a.user_id',$user_id);
        $this->db->where('a.process_id',$process_id);
        $this->db->where('a.status',1);
        $this->db->order_by('a.status_change_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    //______________________ANNUAL SURVEY START___________________________________//
    function get_annual_survey($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',1);
        $this->db->where('subprocess_id',2);
        $this->db->where('status',0);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_annual_survey_done($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',1);
        $this->db->where('subprocess_id',2);
        $this->db->where('status',1);
        $this->db->where('delete_status',0);
         $this->db->order_by('timeline_sl','DESC');
        $this->db->limit(1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_user_id($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_user_vessel');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_user_sl($user_sl)
    {
        $this->db->select('*');
        $this->db->from('user_master');
        $this->db->where('user_master_id',$user_sl);
        $this->db->where('user_master_status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function update_tbl_kiv_vessel_timeline($table,$data,$id)
    {
        $where      =   "timeline_sl  = $id"; 
        $updquery   =   $this->db->update_string($table, $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }
    //_____________________ANNUAL SURVEY END______________________________________//
    //______________________DRYDOCK SURVEY START___________________________________//
    function get_drydock_survey($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',1);
        $this->db->where('subprocess_id',3);
        $this->db->where('status',0);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_drydock_survey_done($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',1);
        $this->db->where('subprocess_id',3);
        $this->db->where('status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('timeline_sl','DESC');
        $this->db->limit(1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    //______________________________DRYDOCK SURVEY END____________________________//
    //______________________________SPECIAL SURVEY START____________________________//
    function get_processflow_vessel_sl($vessel_sl,$user_id)       
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('vessel_id',$vessel_sl);
        $this->db->where('user_id',$user_id);
        $this->db->where('status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_processflow_vessel($vessel_sl)       
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('vessel_id',$vessel_sl);
        $this->db->where('status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_next_survey_process($vessel_id,$subprocess_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',1);
        $this->db->where('subprocess_id',$subprocess_id);
        $this->db->where('status',0);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    //______________________________SPECIAL SURVEY END____________________________//
    //___________________________________________
    //Registration Module Process process_flow_id
    /*function get_registration_intimation($vessel_id,$intimation_type_id)
    {
        $this->db->select('*');
        $this->db->from('a5_tbl_registration_intimation a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('kiv_portofregistry_master c','a.registration_intimation_place_id=c.portofregistry_sl');
        $this->db->join('user_master d','b.vessel_user_id=d.user_master_id');
        $this->db->join('tbl_kiv_user e','e.user_sl=d.customer_id');
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where('a.registration_intimation_type_id',$intimation_type_id);
        $this->db->where('a.registration_inspection_status','1');
        $this->db->where('a.delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }*/
    function get_registration_intimation($vessel_id,$intimation_type_id)
    {
        $this->db->select('*');
        $this->db->from('a5_tbl_registration_intimation a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_portoffice_master c','a.registration_intimation_place_id=c.int_portoffice_id');
        $this->db->join('user_master d','b.vessel_user_id=d.user_master_id');
        $this->db->join('tbl_kiv_user e','e.user_sl=d.customer_id');
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where('a.registration_intimation_type_id',$intimation_type_id);
        $this->db->where('a.registration_inspection_status','1');
        $this->db->where('a.delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function registration_intimation($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('a5_tbl_registration_intimation');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('registration_inspection_status','1');
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_form12_process_flow000($user_id)       
    {
        $id=array(14);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->where('a.user_id',$user_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.current_status_id',1);
        $this->db->where('a.status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form12_process_flow($user_id)       
    {
        $id=array(14);
        $this->db->select('*');   
        $this->db->select('tbl_kiv_vessel_details.*');
        $this->db->select('kiv_vesseltype_master.vesseltype_name');
        $this->db->select('tbl_kiv_processname.process_name');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('tbl_kiv_processflow.user_id',$user_id);
        $this->db->where_in('tbl_kiv_processflow.process_id',$id);
        $this->db->where('tbl_kiv_processflow.current_status_id',1);
        $this->db->where('tbl_kiv_processflow.status',1);
        $this->db->join('tbl_kiv_vessel_details','tbl_kiv_vessel_details.vessel_sl=tbl_kiv_processflow.vessel_id');    
        $this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=tbl_kiv_vessel_details.vessel_type_id','left');
        $this->db->join('tbl_kiv_processname','tbl_kiv_processname.processname_sl=tbl_kiv_processflow.process_id');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_form13_process_flow_pc($user_id)       
    {
        $id=array(16);
        $this->db->select('*');   
        $this->db->select('tbl_kiv_vessel_details.*');
        $this->db->select('kiv_vesseltype_master.vesseltype_name');
        $this->db->select('tbl_kiv_processname.process_name');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('tbl_kiv_processflow.user_id',$user_id);
        $this->db->where_in('tbl_kiv_processflow.process_id',$id);
        $this->db->where('tbl_kiv_processflow.current_status_id',7);
        $this->db->where('tbl_kiv_processflow.status',1);
        $this->db->join('tbl_kiv_vessel_details','tbl_kiv_vessel_details.vessel_sl=tbl_kiv_processflow.vessel_id');    
        $this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=tbl_kiv_vessel_details.vessel_type_id','left');
        $this->db->join('tbl_kiv_processname','tbl_kiv_processname.processname_sl=tbl_kiv_processflow.process_id');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function getCurrentProcessStatus($status_details_sl,$vessel_sl)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_status_details');
        $this->db->where('vessel_id',$vessel_sl);
        $this->db->where('status_details_sl',$status_details_sl);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    //_________________________________________________//
    function get_form12_frwd_process_flow($user_id,$vessel_id)       
    {
        $id=array(14);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow a');
        $this->db->join('tbl_kiv_vessel_details b','a.vessel_id=b.vessel_sl');
        $this->db->where('a.user_id',$user_id);
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where_in('a.process_id',$id);
        $this->db->where('a.current_status_id',1);
        $this->db->where('a.status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_survey_done($process_id,$initial_survey_id,$from_date,$to_date)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline a');
        $this->db->join('tbl_kiv_vessel_details b', 'a.vessel_id=b.vessel_sl');
       // $this->db->where('a.timeline_sl',$timeline_sl); 
        $this->db->where('a.process_id',$process_id);
        $this->db->where('a.subprocess_id',$initial_survey_id);
        $this->db->where('a.status',1);
        $this->db->where('a.link_id!=',0);
        $this->db->where('a.delete_status',0);
        $this->db->where('a.actual_date >=', $from_date);
        $this->db->where('a.actual_date <=', $to_date);
        $this->db->order_by('a.actual_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_survey_done_ndate($process_id,$initial_survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline a');
        $this->db->join('tbl_kiv_vessel_details b', 'a.vessel_id=b.vessel_sl');
       // $this->db->where('a.timeline_sl',$timeline_sl); 
        $this->db->where('a.process_id',$process_id);
        $this->db->where('a.subprocess_id',$initial_survey_id);
        $this->db->where('a.status',1);
        $this->db->where('a.link_id!=',0);
        $this->db->where('a.delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_specialsurvey_done($process_id,$from_date,$to_date)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline a');
        $this->db->join('tbl_kiv_vessel_details b', 'a.vessel_id=b.vessel_sl');
       // $this->db->where('a.timeline_sl',$timeline_sl); 
        $this->db->where('a.process_id',$process_id);
        $this->db->where('a.special_survey_status',1);
        $this->db->where('a.status',1);
        $this->db->where('a.link_id!=',0);
        $this->db->where('a.delete_status',0);
        $this->db->where('a.actual_date >=', $from_date);
        $this->db->where('a.actual_date <=', $to_date);
        $this->db->order_by('a.actual_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    } 
    function get_specialsurvey_done_ndate($process_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline a');
        $this->db->join('tbl_kiv_vessel_details b', 'a.vessel_id=b.vessel_sl');
       // $this->db->where('a.timeline_sl',$timeline_sl); 
        $this->db->where('a.process_id',$process_id);
        $this->db->where('a.special_survey_status',1);
        $this->db->where('a.status',1);
         $this->db->where('a.link_id!=',0);
        $this->db->where('a.delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_survey_done_owner($process_id,$initial_survey_id,$sess_usr_id,$from_date,$to_date)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline a');
        $this->db->join('tbl_kiv_vessel_details b', 'a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('d.user_id',$sess_usr_id);
        $this->db->where('a.process_id',$process_id);
        $this->db->where('a.subprocess_id',$initial_survey_id);
        $this->db->where('a.status',1);
        $this->db->where('a.link_id!=',0);
        $this->db->where('a.delete_status',0);
        $this->db->where('a.actual_date >=', $from_date);
        $this->db->where('a.actual_date <=', $to_date);
        $this->db->order_by('a.actual_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    } 
   
    function get_survey_done_owner_ndate($process_id,$initial_survey_id,$sess_usr_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline a');
        $this->db->join('tbl_kiv_vessel_details b', 'a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('d.user_id',$sess_usr_id);
        $this->db->where('a.process_id',$process_id);
        $this->db->where('a.subprocess_id',$initial_survey_id);
        $this->db->where('a.status',1);
        $this->db->where('a.link_id!=',0);
        $this->db->where('a.delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_specialsurvey_done_owner($process_id,$sess_usr_id,$from_date,$to_date)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline a');
        $this->db->join('tbl_kiv_vessel_details b', 'a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('d.user_id',$sess_usr_id);
        $this->db->where('a.process_id',$process_id);
        $this->db->where('a.special_survey_status',1);
        $this->db->where('a.status',1);
        $this->db->where('a.link_id!=',0);
        $this->db->where('a.delete_status',0);
        $this->db->where('a.actual_date >=', $from_date);
        $this->db->where('a.actual_date <=', $to_date);
        $this->db->order_by('a.actual_date','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_specialsurvey_done_owner_ndate($process_id,$sess_usr_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline a');
        $this->db->join('tbl_kiv_vessel_details b', 'a.vessel_id=b.vessel_sl');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_id=d.vessel_id');
        $this->db->where('d.status',1);
        $this->db->where('d.user_id',$sess_usr_id);
        $this->db->where('a.process_id',$process_id);
        $this->db->where('a.special_survey_status',1);
        $this->db->where('a.status',1);
        $this->db->where('a.link_id!=',0);
        $this->db->where('a.delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_processflow_id($vessel_sl,$survey_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('vessel_id',$vessel_sl);
         $this->db->where('survey_id',$survey_id);
        $this->db->where('status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function update_vessel_timeline($table,$data,$id)
    {
        $where      =   "vessel_id  = $id"; 
        $updquery   =   $this->db->update_string($table, $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }

    function update_vessel_main($table,$data,$id)
    {
        $where      =   "vesselmain_vessel_id  = $id"; 
        $updquery   =   $this->db->update_string($table, $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }
    function update_registration_history($table,$data,$id)
    {
        $where      =   "registration_sl  = $id"; 
        $updquery   =   $this->db->update_string($table, $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }

    function update_vessel_regcount($table,$data,$id)
    {
        $where      =   "id  = $id"; 
        $updquery   =   $this->db->update_string($table, $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }
    function get_vessel_main($vessel_sl)
    {
        $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->where('vesselmain_vessel_id',$vessel_sl);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    //_________________________________________________//
    /*________________ ONLINE PAYMENT START______________________*/
    function get_bank_generated_last_number($bank_sl)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_master');
        $this->db->where('bank_status',1);
        $this->db->where('bank_sl',$bank_sl);
        $this->db->where('delete_status',0);
        $query =    $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function update_bank($tablename,$data_update,$id)
    {
        $where      = "bank_sl  = $id"; 
        $updquery   = $this->db->update_string($tablename, $data_update, $where);
        $result     = $this->db->query($updquery);
        return $result; 
    }
    function get_online_payment_data($portofregistry_id,$bank_sl)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_online_payment_data');
        $this->db->where('port_id',$portofregistry_id);
        $this->db->where('bank_id',$bank_sl);
        $this->db->where('payment_status',1);
        $query =    $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_bank_transaction_request($bank_transaction_id)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_transaction_request');
        $this->db->where('bank_transaction_id',$bank_transaction_id);
        $query =    $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_transaction_request($tocken_no)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_transaction_request');
        $this->db->where('token_no',$tocken_no);
        $query =    $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_workingkey($port_id,$bank_id)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_online_payment_data');
        $this->db->where('port_id',$port_id);
        $this->db->where('bank_id',$bank_id); 
        $this->db->where('payment_status',1);
        $query =    $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    /*________________ ONLINE PAYMENT END______________________*/
    function get_meansofpropulsionShaft_name($id)
    {
        $this->db->select('*');
        $this->db->from('kiv_meansofpropulsion_master');
        $this->db->where('meansofpropulsion_status',1);
        $this->db->where('meansofpropulsion_sl',$id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_reg_vessel_list()       
    {
        $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->where('vesselmain_reg_number!=','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_nozzletype_view($equipment_id)
    {
        $this->db->select('*');
        $this->db->from('kiv_equipment_master');
        $this->db->where('equipment_status',1);
        //$this->db->where('equipment_type_id',8);
        $this->db->where('equipment_sl',$equipment_id);
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_processing_status($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->where('vesselmain_vessel_id',$vessel_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_regcount($vessel_registry_port_id,$vessel_type_id)
    {
        $this->db->select('*');
        $this->db->from('tb_regcount');
        $this->db->where('portofregistry_id',$vessel_registry_port_id);
        $this->db->where('vessel_type_id',$vessel_type_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessellist_owner($vessel_id)       
    {
        $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->where('vesselmain_vessel_id',$vessel_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_insurance_details($vessel_id)       
    {
        $this->db->select('*');
        $this->db->from('tbl_vessel_insurance_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('vessel_insurance_status',1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_bookofregistration_list_owner($sess_usr_id)       
    {
       $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->where('vesselmain_reg_number!=','0');
        $this->db->where('vesselmain_owner_id',$sess_usr_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_crew_count($vessel_id,$crew_type_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_crew_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('crew_type_id',$crew_type_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_bilgepump_details($vessel_id,$equipment_id,$bilgepumptype_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_bilgepump_details');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('equipment_id',$equipment_id);
        $this->db->where('bilgepumptype_id',$bilgepumptype_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_ref_number($process_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_reference_number');
        $this->db->where('process_id',$process_id);
        $this->db->where('ref_number<>','');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_last_ref_number($process_id)
    {
        $this->db->select('ref_number');
        $this->db->from('tbl_kiv_reference_number');
        $this->db->where('process_id',$process_id);
        $this->db->where('ref_number<>','');
        $this->db->order_by('ref_id','DESC');
        $this->db->limit(1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }  
    function get_ref_number_details_forms($vessel_id,$process_id)
    {
        $this->db->select('ref_id,ref_number');
        $this->db->from('tbl_kiv_reference_number');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',$process_id);
        $this->db->where('ref_number_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    } 
    function get_ref_number_details($vessel_id,$process_id)
    {
        $this->db->select('ref_id,ref_number');
        $this->db->from('tbl_kiv_reference_number');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('process_id',$process_id);
        $this->db->where('ref_number_status','1');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_last_ref_number_details($vessel_id)
    {
        $this->db->select('ref_id');
        $this->db->from('tbl_kiv_reference_number');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where('ref_number_status','0');
        $this->db->where('ref_number<>','');
        $this->db->order_by('ref_id','DESC');
        $this->db->limit(1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }

     function get_vessel_details_refnumer($ref_number)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_reference_number');
        $this->db->where('ref_number',$ref_number);
        $this->db->where('ref_number_status','1');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function update_kiv_reference_number($table, $data,$id)
    {
        $where      =   "ref_id  = $id"; 
        $updquery   =   $this->db->update_string($table, $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }
    function get_registration_renewal($vessel_id)
    {
        $this->db->select('registration_renewal_sl');
        $this->db->from('tbl_registration_renewal');
        $this->db->where('registration_renewal_vessel_id',$vessel_id);
        $this->db->where('registration_renewal_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function update_tables($tablename,$data_update, $field_name,$primary_key)
    {
        $where     =   "$field_name  = $primary_key"; 
        $updquery   =   $this->db->update_string($tablename, $data_update, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }
    /////////////////////////////////////////view query created as on 07.11.2019(start)///////////////////////////////
    function get_view_count($table1)       
    {
        $this->db->select('cnt');
        $this->db->select('uid');
        $this->db->from($table1);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
        /*$query=$this->db->query("SELECT cnt FROM $table1");
        $result = $query->result();
        return $result;
        */
    }
    /////////////////////////////////////////view query created as on 07.11.2019(end)///////////////////////////////
   
    /*________________Timeline start_______________*/
    function get_vessel_details_timeline($id)
    {
        $this->db->select('a.vessel_sl,a.vessel_name,a.vessel_registration_number');
        $this->db->select('c.survey_id as sid');
        $this->db->from('tbl_kiv_vessel_details a');
        $this->db->join('tbl_kiv_form_stage b','a.vessel_sl=b.vessel_id');
        $this->db->join('tbl_kiv_status_details c','a.vessel_sl=c.vessel_id');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_sl=d.vessel_id');
        $this->db->where('d.user_id',$id);
        $this->db->where('d.status',1);
        $this->db->order_by('a.vessel_sl','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_details_timeline_other()
    {
        $this->db->select('a.vessel_sl,a.vessel_name,a.vessel_registration_number');
        $this->db->select('c.survey_id as sid');
        $this->db->from('tbl_kiv_vessel_details a');
        $this->db->join('tbl_kiv_form_stage b','a.vessel_sl=b.vessel_id');
        $this->db->join('tbl_kiv_status_details c','a.vessel_sl=c.vessel_id');
        $this->db->join('tbl_kiv_user_vessel d','a.vessel_sl=d.vessel_id');
        $this->db->where('d.status',1);
        $this->db->order_by('a.vessel_sl','ASC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }

    function get_processflow_timeline($vessel_id)
    {
        $id=array(1,5);
        $this->db->select('*');
        $this->db->from('tbl_kiv_processflow');
        $this->db->where('vessel_id',$vessel_id);
        $this->db->where_in('current_status_id',$id);
        $this->db->order_by('processflow_sl','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_name_timeline($vessel_id)
    {
        $this->db->select('vessel_name,vessel_registration_number');
        $this->db->from('tbl_kiv_vessel_details');
        $this->db->where('vessel_sl',$vessel_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    /*________________Timeline end_______________*/
    function get_additional_payment_details($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_additional_payment');
        $this->db->where('vessel_id',$vessel_id); 
        $this->db->where('additional_payment_status',1); 
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function update_additional_payment($table,$data,$additional_payment_sl)
    {
        $where      =   "additional_payment_sl  = $additional_payment_sl"; 
        $updquery   =   $this->db->update_string($table, $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }
    function get_additional_payment_approved($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_additional_payment');
        $this->db->where('vessel_id',$vessel_id); 
        $this->db->where('additional_payment_status',0); 
        $this->db->where('delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_survey_done_vessel($process_id,$initial_survey_id,$vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_vessel_timeline a');
        $this->db->where('a.process_id',$process_id);
        $this->db->where('a.subprocess_id',$initial_survey_id);
        $this->db->where('a.vessel_id',$vessel_id);
        $this->db->where('a.status',1);
         $this->db->where('a.link_id!=',0);
        $this->db->where('a.delete_status',0);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_vessel_pollution($vessel_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_pollution_details');
        $this->db->where('vessel_id',$vessel_id); 
        $this->db->where('pollution_status',1); 
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    } 
    function get_vessel_main_renew($id)
    {
        $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->where('vesselmain_owner_id',$id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }  
    function get_dcb_statement_all($portofregistry_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details');
        $this->db->where('portofregistry_id',$portofregistry_id);
        $this->db->where('transaction_id<>','');
        $this->db->order_by('payment_created_timestamp','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_dcb_statement($portofregistry_id,$survey_sl,$bank_sl,$from_date,$to_date)
    {

        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details');
        $this->db->where('portofregistry_id',$portofregistry_id);
        $this->db->where_in('survey_id',$survey_sl);
        $this->db->where_in('bank_id',$bank_sl);
        $this->db->where('dd_date >=', $from_date);
        $this->db->where('dd_date <=', $to_date);
        $this->db->where('transaction_id<>','');
        $this->db->order_by('payment_created_timestamp','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    } 
    function get_dcb_statement_date($portofregistry_id,$from_date,$to_date)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details');
        $this->db->where('portofregistry_id',$portofregistry_id);
        $this->db->where('dd_date >=', $from_date);
        $this->db->where('dd_date <=', $to_date);
        $this->db->where('transaction_id<>','');
        $this->db->order_by('payment_created_timestamp','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_dcb_statement_one($portofregistry_id,$survey_sl,$from_date,$to_date)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details');
        $this->db->where('portofregistry_id',$portofregistry_id);
        $this->db->where_in('survey_id',$survey_sl);
        $this->db->where('dd_date >=', $from_date);
        $this->db->where('dd_date <=', $to_date);
        $this->db->where('transaction_id<>','');
        $this->db->order_by('payment_created_timestamp','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_dcb_statement_two($portofregistry_id,$bank_sl,$from_date,$to_date)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details');
        $this->db->where('portofregistry_id',$portofregistry_id);
        $this->db->where_in('bank_id',$bank_sl);
        $this->db->where('dd_date >=', $from_date);
        $this->db->where('dd_date <=', $to_date);
        $this->db->where('transaction_id<>','');
        $this->db->order_by('payment_created_timestamp','DESC');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_transaction_details($portofregistry_id,$transaction_id)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_transaction_request a');
        $this->db->join('kiv_bank_online_banktransaction b','a.token_no=b.tokenno');
        $this->db->where('a.port_id',$portofregistry_id);
        $this->db->where('a.transaction_id',$transaction_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_transaction_details_tid($transaction_id)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_transaction_request a');
        $this->db->join('kiv_bank_online_banktransaction b','a.token_no=b.tokenno');
        $this->db->where('a.transaction_id',$transaction_id);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_payment($transaction_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kiv_payment_details');
        $this->db->where('transaction_id',$transaction_id);
        $this->db->where('delete_status','0');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result; 
    }
    function get_transaction_details_mob($portofregistry_id,$search_mob)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_transaction_request a');
        $this->db->join('kiv_bank_online_banktransaction b','a.token_no=b.tokenno');
        $this->db->where('a.port_id',$portofregistry_id);
        $this->db->where('a.mobile_no',$search_mob);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }  
    function get_transaction_details_mob_ra($search_mob)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_transaction_request a');
        $this->db->join('kiv_bank_online_banktransaction b','a.token_no=b.tokenno');
        $this->db->where('a.mobile_no',$search_mob);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    } 
    function get_transaction_details_email($portofregistry_id,$search_mail)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_transaction_request a');
        $this->db->join('kiv_bank_online_banktransaction b','a.token_no=b.tokenno');
        $this->db->where('a.port_id',$portofregistry_id);
        $this->db->where('a.email_id',$search_mail);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_transaction_details_email_ra($search_mail)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_transaction_request a');
        $this->db->join('kiv_bank_online_banktransaction b','a.token_no=b.tokenno');
        $this->db->where('a.email_id',$search_mail);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_transaction_details_kivnumber($search_kiv)
    {
        $this->db->select('*');
        $this->db->from('kiv_bank_transaction_request a');
        $this->db->join('kiv_bank_online_banktransaction b','a.token_no=b.tokenno');
        $this->db->join('tb_vessel_main c','a.vessel_id=c.vesselmain_vessel_id');
        //$this->db->where('a.port_id',$portofregistry_id);
        $this->db->where('c.vesselmain_reg_number',$search_kiv);
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_view_tariffList_view()
    {
        $this->db->select('kiv_tariff_master.tariff_sl');
        $this->db->select('kiv_tariff_master.tariff_activity_id');
        $this->db->select('kiv_tariff_master.tariff_form_id');
        $this->db->select('kiv_tariff_master.tariff_vessel_type_id');
        $this->db->select('kiv_tariff_master.tariff_vessel_subtype_id');
        $this->db->select('kiv_tariff_master.start_date');
        $this->db->select('kiv_tariff_master.end_date');
        $this->db->select('kiv_survey_master.survey_name');
        $this->db->select('kiv_document_type_master.document_type_name');
        $this->db->select('kiv_vesseltype_master.vesseltype_name');
        $this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
        $this->db->from('kiv_tariff_master');
        $this->db->where('kiv_tariff_master.delete_status', 0);
        $this->db->join('kiv_survey_master','kiv_survey_master.survey_sl=kiv_tariff_master.tariff_activity_id');
        $this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_tariff_master.tariff_form_id');
        $this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_tariff_master.tariff_vessel_type_id');
        $this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_tariff_master.tariff_vessel_subtype_id','left');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_view_tariffList_view_sl($survey_sl)
    {
        $this->db->select('kiv_tariff_master.tariff_sl');
        $this->db->select('kiv_tariff_master.tariff_activity_id');
        $this->db->select('kiv_tariff_master.tariff_form_id');
        $this->db->select('kiv_tariff_master.tariff_vessel_type_id');
        $this->db->select('kiv_tariff_master.tariff_vessel_subtype_id');
        $this->db->select('kiv_tariff_master.start_date');
        $this->db->select('kiv_tariff_master.end_date');
        $this->db->select('kiv_survey_master.survey_name');
        $this->db->select('kiv_document_type_master.document_type_name');
        $this->db->select('kiv_vesseltype_master.vesseltype_name');
        $this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
        $this->db->from('kiv_tariff_master');
        $this->db->where('kiv_tariff_master.delete_status', 0);
        $this->db->where('kiv_tariff_master.tariff_activity_id', $survey_sl);
        $this->db->join('kiv_survey_master','kiv_survey_master.survey_sl=kiv_tariff_master.tariff_activity_id');
        $this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_tariff_master.tariff_form_id');
        $this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_tariff_master.tariff_vessel_type_id');
        $this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_tariff_master.tariff_vessel_subtype_id','left');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    function get_det_tariffTable($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate)     
    {
        $this->db->select('kiv_tariff_master.tariff_sl');
        $this->db->select('kiv_tariff_master.tariff_activity_id');
        $this->db->select('kiv_tariff_master.tariff_form_id');
        $this->db->select('kiv_tariff_master.tariff_vessel_type_id');
        $this->db->select('kiv_tariff_master.tariff_vessel_subtype_id');
        $this->db->select('kiv_tariff_master.tariff_tonnagetype_id');
        $this->db->select('kiv_tariff_master.tariff_from_ton');
        $this->db->select('kiv_tariff_master.tariff_to_ton');
        //$this->db->select('kiv_tariff_master.tariff_per_ton');
        $this->db->select('kiv_tariff_master.tariff_day_type');
        $this->db->select('kiv_tariff_master.tariff_from_day');
        $this->db->select('kiv_tariff_master.tariff_to_day');
        $this->db->select('kiv_tariff_master.tariff_amount');
        $this->db->select('kiv_tariff_master.tariff_min_amount');
        $this->db->select('kiv_tariff_master.tariff_fine_amount');
        $this->db->select('kiv_tariff_master.start_date');
        $this->db->select('kiv_tariff_master.end_date');
        $this->db->select('kiv_survey_master.survey_name');
        $this->db->select('kiv_document_type_master.document_type_name');
        $this->db->select('kiv_vesseltype_master.vesseltype_name');
        $this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
        $this->db->select('kiv_tariffdaytype_master.tariffdaytype_name');
        $this->db->select('kiv_tonnagetype_master.tonnagetype_name');
        $this->db->from('kiv_tariff_master');
        $this->db->where('kiv_tariff_master.tariff_activity_id',$surveyName);
        $this->db->where('kiv_tariff_master.tariff_form_id',$formtypeName);
        $this->db->where('kiv_tariff_master.tariff_vessel_type_id',$vesseltype_name);
        $this->db->where('kiv_tariff_master.tariff_vessel_subtype_id',$vessel_subtype_name);
        $this->db->where('kiv_tariff_master.start_date',$startDate);
        $this->db->where('kiv_tariff_master.end_date',$endDate);
        $this->db->where('kiv_tariff_master.delete_status', 0);
        $this->db->join('kiv_survey_master','kiv_survey_master.survey_sl=kiv_tariff_master.tariff_activity_id');
        $this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_tariff_master.tariff_form_id');
        $this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_tariff_master.tariff_vessel_type_id');
        $this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_tariff_master.tariff_vessel_subtype_id','left');
        $this->db->join('kiv_tonnagetype_master','kiv_tonnagetype_master.tonnagetype_sl=kiv_tariff_master.tariff_tonnagetype_id');
        $this->db->join('kiv_tariffdaytype_master','kiv_tariffdaytype_master.tariffdaytype_sl=kiv_tariff_master.tariff_day_type');
        $query  =   $this->db->get();
        $result =   $query->result_array();
        return $result;
    }
    /*-----------------Curl to send SMS starts-----------*/
    public function sendSms($message,$number)
    {
        $link = curl_init();
        curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=portsms2&password=portsms1234&message=".$message."&numbers=".$number."&senderid=PORTDR");
        curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($link , CURLOPT_HEADER, 0);
        return $output = curl_exec($link);
        curl_close($link );
    } 
    /*function sendSms($message,$mobno)
    {
        $username ="portsms2";
        $senderid ="PORTDR";
        $password ="portsms1234";
        $deptSecureKey ="4dbdab71-fbe9-457c-a0ad-37cd1bd36f61";
        $mobileno = $mobno;
        $encryp_password = sha1($password);
        $key=hash('sha512', $username.$senderid.$message.$deptSecureKey);
        $data = array(
        "username" => $username, 
        "password" => $encryp_password,
        "senderid" => $senderid,
        "content"  => $message,
        "smsservicetype" =>"singlemsg",
        "mobileno" =>    $mobileno,
        "key" => $key);
        $stat = $this->post_to_url("https://api.esms.kerala.gov.in/fastclient/SMSclient.php", $data);
   }*/
    /*-----------------Curl to send SMS ends-----------*/ 

    function get_registered_vessels_rep_req($user){
        $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
        $this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
        // $this->db->join('tbl_registrationplate','tbl_registrationplate.vessel_id=tb_vessel_main.vesselmain_vessel_id','left');
        //$this->db->where('vesselmain_reg_number<>','');
        $this->db->where('tb_vessel_main.print_count >','0');
       // $this->db->where('tb_vessel_main.reprint_request_status<>','1');
        $this->db->where('tb_vessel_main.vesselmain_owner_id',$user);
        

        //reprint_approve_status
        $query      =   $this->db->get();
        $result     =   $query->result_array();
        return $result;
    }
    function get_vessel_details_id($ids)     
    { 
        $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
        $this->db->join('tbl_registrationplate','tbl_registrationplate.vessel_id=tb_vessel_main.vesselmain_vessel_id','left');        
        $this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
        //$this->db->where('vesselmain_reg_number<>','');
        $this->db->where('vesselmain_reg_number<>','0');
        $this->db->where_in('vesselmain_vessel_id', $ids);
        //reprint_approve_status
        $query      =   $this->db->get();
        $result     =   $query->result_array();
        return $result; 
        
    }

     function update_vessel_print_cnt($data,$id)
    {
        $where      =   "vesselmain_vessel_id  = $id"; 
        $updquery   =   $this->db->update_string('tb_vessel_main', $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    } 

    function update_regn_plate($data,$id)
    {
        $where      =   "print_sl  = $id"; 
        $updquery   =   $this->db->update_string('tbl_registrationplate', $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }

    function get_user_port_id($user){

        $this->db->select('user_master_port_id');
        $this->db->from('user_master');
        $this->db->where('user_master_id',$user);
        //reprint_approve_status
        $query      =   $this->db->get();
        $result     =   $query->result_array();
        return $result; 

    }

    function get_reprint_req_list_pc($port){

        $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->join('tbl_registrationplate','tbl_registrationplate.vessel_id=tb_vessel_main.vesselmain_vessel_id');
        //$this->db->where('vesselmain_reg_number<>','');
        $this->db->where('tb_vessel_main.reprint_request_status',1);
        $this->db->where('tbl_registrationplate.reprint_approve_status',0);
        //$where = '((tb_vessel_main.reprint_approve_status= 0) or (tb_vessel_main.reprint_approve_status = 2))';
       // $this->db->where($where);
        $this->db->where('tb_vessel_main.vesselmain_portofregistry_id',$port);
        $this->db->where('tbl_registrationplate.reprint_status<>',1);
        
        //reprint_approve_status
        $query      =   $this->db->get();
        $result     =   $query->result_array();
        return $result;
   
    }
    function get_reprint_id($id){

        $this->db->select('*');
        $this->db->from('tbl_registrationplate');
       //$this->db->where('vesselmain_reg_number<>','');
        $where = '((reprint_status!=1) and (reprint_approve_status!=2))';
        $this->db->where($where);
        $this->db->where('vessel_id',$id);
        $this->db->order_by('print_sl','DESC');
        
        //reprint_approve_status
        $query      =   $this->db->get();
        $result     =   $query->result_array();
        return $result;
   
    }

    function get_registered_vessels($port)     
    { 
        $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
        $this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
        //$this->db->where('vesselmain_reg_number<>','');
        $this->db->where('vesselmain_reg_number<>','0');
        $this->db->where('print_count',1);
        $this->db->where('vesselmain_portofregistry_id',$port);
        //$this->db->where('reprint_approve_status',1);

        $query      =   $this->db->get();
        $result     =   $query->result_array();
        return $result; 
        
    }
    function get_registered_vessels_pending($port)     
    { 
        $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
        $this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
        //$this->db->where('vesselmain_reg_number<>','');
        $this->db->where('vesselmain_reg_number<>','0');
        $this->db->where('print_count>',1);
        $where = '((reprint_approve_status= 0) or (reprint_approve_status = 2))';
        $this->db->where($where);
        //$this->db->where('reprint_approve_status',0);
         $this->db->where('vesselmain_portofregistry_id',$port);

        $query      =   $this->db->get();
        $result     =   $query->result_array();
        return $result; 
        
    }
    function get_registered_vessels_reprinted($port)     
    { 
        $this->db->select('*');
        $this->db->from('tb_vessel_main');
        $this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
        $this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
        $this->db->join('tbl_registrationplate','tbl_registrationplate.vessel_id=tb_vessel_main.vesselmain_vessel_id');
        //$this->db->where('vesselmain_reg_number<>','');
        $this->db->where('vesselmain_reg_number<>','0');
        $this->db->where('print_count>',1);
        $this->db->where('reprint_status',1);
        /* $where = '((tbl_registrationplate.reprint_approve_status= 0) or (tbl_registrationplate.reprint_approve_status = 2))';
        $this->db->where($where);*/
        
         $this->db->where('vesselmain_portofregistry_id',$port);

        $query      =   $this->db->get();
        $result     =   $query->result_array();
        return $result; 
        
    }
 //_______________END OF MODEL______________________//
}
