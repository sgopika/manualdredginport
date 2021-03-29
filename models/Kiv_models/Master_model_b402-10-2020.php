<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
/*-----------Function used for checking the user details-----------*/
function loginCheck($dataenc)
{
	$query = $this->db->get_where('user_master',$dataenc);
	if($query->num_rows()===1)
	{
		$row 		= $query->row_array(); 
		$user_data  = array(
		'user_master_id'  	  			=> 	$row['user_master_id'],
		'user_master_name'				=>	$row['user_master_name'],
		'user_master_password'			=>	$row['user_master_password'],
		'user_master_id_user_type'  	=> 	$row['user_master_id_user_type'],
		'customer_id'					=>	$row['customer_id'],
		'survey_user_id'    			=> 	$row['survey_user_id'] );
		$this->session->set_userdata($user_data);
	}
	return $query->num_rows();
}
/*-----------  Start Get Vessel Category  vesselcategory.php-----------*/
function get_vesselcategory()     
{ 
	$this->db->select('vesselcategory_sl');
	$this->db->select('vesselcategory_name');
	$this->db->select('vesselcategory_mal_name');
	$this->db->select('vesselcategory_code');
	$this->db->select('vesselcategory_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_vesselcategory_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('vesselcategory_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}

function check_duplication_vesselcategory($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_vesselcategory_master');
	$this->db->where('vesselcategory_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}

function check_duplication_vesselcategory_insert($name,$code)     
{ 
	$where=	"(vesselcategory_name ='$name' OR vesselcategory_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_vesselcategory_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
function check_duplication_vesselcategory_edit($name,$code,$id)     
{ 
	$where=	"(vesselcategory_name ='$name' OR vesselcategory_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_vesselcategory_master');
	$this->db->where($where);
	$this->db->where('vesselcategory_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
function update_vesselcategory_status($data,$vesselcategory_sl)
{
	$where 		= 	"vesselcategory_sl  = '$vesselcategory_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_vesselcategory_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
}

function delete_vesselcategory($data,$id)
{
	$where 	= 	" vesselcategory_sl  = '$id'"; 
	$result = $this->db->update('kiv_vesselcategory_master', $data, $where);
	return 1;		
}

function edit_vesselcategory($id,$data)
{
	$where 	= " vesselcategory_sl  = '$id'"; 
	$result = $this->db->update('kiv_vesselcategory_master', $data, $where);
	return $result;
}	
/*-----------  End  Vessel Category  vesselcategory.php-----------*/

/*-----------  Start Get Vessel Sub Category  vessel_subcategory.php-----------*/
function get_vessel_subcategory()     
{ 
	$this->db->select('kiv_vessel_subcategory_master.vessel_subcategory_sl');
	$this->db->select('kiv_vessel_subcategory_master.vessel_subcategory_category_id');
	$this->db->select('kiv_vessel_subcategory_master.vessel_subcategory_name');
	$this->db->select('kiv_vessel_subcategory_master.vessel_subcategory_mal_name');
	$this->db->select('kiv_vessel_subcategory_master.vessel_subcategory_code');
	$this->db->select('kiv_vessel_subcategory_master.vessel_subcategory_status');
	$this->db->select('kiv_vessel_subcategory_master.delete_status');
	$this->db->select('kiv_vesselcategory_master.vesselcategory_name');
	$this->db->from('kiv_vessel_subcategory_master');
	$this->db->where('kiv_vessel_subcategory_master.delete_status', 0);
	$this->db->join('kiv_vesselcategory_master','kiv_vesselcategory_master.vesselcategory_sl=kiv_vessel_subcategory_master.vessel_subcategory_category_id');
	$this->db->order_by('kiv_vessel_subcategory_master.vessel_subcategory_category_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}

function get_vessel_category()     
{ 
	$this->db->select('*');
	$this->db->from('kiv_vesselcategory_master');
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 

function check_duplication_vessel_subcategory($id,$name)
{ 
	$this->db->select('*');
	$this->db->from('kiv_vessel_subcategory_master');
	$this->db->where('vessel_subcategory_category_id', $id);
	$this->db->where('vessel_subcategory_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}

function check_duplication_vessel_subcategory_insert($cat_id,$name,$code)     
{ 
	$where=	"((vessel_subcategory_category_id='$cat_id') AND (vessel_subcategory_name ='$name' OR vessel_subcategory_code='$code'))";  	
	$this->db->select('*');
	$this->db->from('kiv_vessel_subcategory_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
/*New function included for edit case 22-06-2018*/ 
function check_duplication_vessel_subcategory_edit($cat_id,$name,$code,$id)     
{ 
	$where=	"((vessel_subcategory_category_id='$cat_id') AND (vessel_subcategory_name ='$name' OR vessel_subcategory_code='$code'))";  	
	$this->db->select('*');
	$this->db->from('kiv_vessel_subcategory_master');
	$this->db->where($where);
	$this->db->where('vessel_subcategory_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
/*New function included for edit case 14-06-2018*/ 
function update_vessel_subcategory_status($data,$vessel_subcategory_sl)
{
	$where 		= 	"vessel_subcategory_sl  = '$vessel_subcategory_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_vessel_subcategory_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
}

function delete_vessel_subcategory($data,$id)
{
	$where 	= 	" vessel_subcategory_sl  = '$id'"; 
	$result = $this->db->update('kiv_vessel_subcategory_master', $data, $where);
	return 1;		
}

function check_duplication_vessel_subcategoryname($name)
{ 
	$this->db->select('*');
	$this->db->from('kiv_vessel_subcategory_master');
	$this->db->where('vessel_subcategory_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 

function edit_vessel_subcategory($id,$data)
{
	$where 	= " vessel_subcategory_sl  = '$id'"; 
	$result = $this->db->update('kiv_vessel_subcategory_master', $data, $where);
	return $result;
}

function get_vessel_categoryname($id)     
{ 
	$this->db->select('vesselcategory_name');
	$this->db->from('kiv_vesselcategory_master');
	$this->db->where('vesselcategory_sl',$id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
//------------------------------------------------------------------------------------------------------------------------------------
//                                                    VESSEL TYPE
//------------------------------------------------------------------------------------------------------------------------------------
// List Vessel type
// 06-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_vesselType()
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
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_vesseltype($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_vesseltype_master');
	$this->db->where('vesseltype_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  

function check_duplication_vesseltype_insert($name,$code)     
{ 
	$where=	"(vesseltype_name ='$name' OR vesseltype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_vesseltype_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_vesseltype_edit($name,$code,$id)     
{ 
	$where=	"(vesseltype_name ='$name' OR vesseltype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_vesseltype_master');
	$this->db->where($where);
	$this->db->where('vesseltype_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
 /*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_vesseltype_status($data,$vesseltype_sl)
{
	$where 		= 	"vesseltype_sl  = '$vesseltype_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_vesseltype_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_vesseltype($data,$id)
{
	$where 	= 	" vesseltype_sl  = '$id'"; 
	$result = $this->db->update('kiv_vesseltype_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_vesseltype($id,$data)
{
	$where 	= " vesseltype_sl  = '$id'"; 
	$result = $this->db->update('kiv_vesseltype_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        Ends Vessel type   
//-------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------     
//                                                         VESSEL SUB TYPE
// STARTS 
// 07-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_vessel_subtype()     
{ 
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_sl');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_vesseltype_id');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_mal_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_code');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_status');
	$this->db->select('kiv_vessel_subtype_master.delete_status');
	$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->from('kiv_vessel_subtype_master');
	$this->db->where('kiv_vessel_subtype_master.delete_status', 0);
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_vessel_subtype_master.vessel_subtype_vesseltype_id');
	$this->db->order_by('kiv_vessel_subtype_master.vessel_subtype_vesseltype_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------
function get_vessel_type()     
{ 
	$this->db->select('*');
	$this->db->from('kiv_vesseltype_master');
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
//------------------------------------------------------------------------------------------------------------------------------------
function check_duplication_vessel_subtype($id,$name)
{ 
	$this->db->select('*');
	$this->db->from('kiv_vessel_subtype_master');
	$this->db->where('vessel_subtype_vesseltype_id', $id);
	$this->db->where('vessel_subtype_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}

function check_duplication_vessel_subtype_insert($type_id,$name,$code)     
{ 
	$where=	"((vessel_subtype_vesseltype_id='$type_id') AND (vessel_subtype_name ='$name' OR vessel_subtype_code='$code'))";  	
	$this->db->select('*');
	$this->db->from('kiv_vessel_subtype_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
/*New function included for insert case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_vessel_subtype_edit($type_id,$name,$code,$id)     
{ 
	$where=	"((vessel_subtype_vesseltype_id='$type_id') AND (vessel_subtype_name ='$name' OR vessel_subtype_code='$code'))";    	
	$this->db->select('*');
	$this->db->from('kiv_vessel_subtype_master');
	$this->db->where($where);
	$this->db->where('vessel_subtype_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------
function update_vessel_subtype_status($data,$vessel_subtype_sl)
{
	$where 		= 	"vessel_subtype_sl  = '$vessel_subtype_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_vessel_subtype_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
}
//------------------------------------------------------------------------------------------------------------------------------------
function delete_vessel_subtype($data,$id)
{
	$where 	= 	" vessel_subtype_sl  = '$id'"; 
	$result = $this->db->update('kiv_vessel_subtype_master', $data, $where);
	return 1;		
}
//------------------------------------------------------------------------------------------------------------------------------------
function check_duplication_vessel_subtypename($name)
{ 
$this->db->select('*');
$this->db->from('kiv_vessel_subtype_master');
$this->db->where('vessel_subtype_name', $name);
$query 	= 	$this->db->get();
$result = 	$query->result_array();
return $result;
} 
//------------------------------------------------------------------------------------------------------------------------------------
function edit_vessel_subtype($id,$data)
{
	$where 	= " vessel_subtype_sl  = '$id'"; 
	$result = $this->db->update('kiv_vessel_subtype_master', $data, $where);
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------
function get_vessel_typename($id)     
{ 
	$this->db->select('vesseltype_name');
	$this->db->from('kiv_vesseltype_master');
	$this->db->where('vesseltype_sl',$id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
//							Ends sub type 
//-------------------------------------------------------------------------------------------------------------------------------------    
//                                                          DISTRICT
// List districts
// 06-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_district()
{
	$this->db->select('district_sl');
	$this->db->select('district_name');
	$this->db->select('district_mal_name');
	$this->db->select('port_id');
	$this->db->select('district_code');
	$this->db->select('district_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_district_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('vesseltype_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_district($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_vesseltype_master');
	$this->db->where('vesseltype_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_district_status($data,$vesseltype_sl)
{
	$where 		= 	"vesseltype_sl  = '$vesseltype_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_vesseltype_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_district($data,$id)
{
	$where 	= 	" vesseltype_sl  = '$id'"; 
	$result = $this->db->update('kiv_vesseltype_master', $data, $where);
	return 1;		
}
//------------------------------------------------------------------------------------------------------------------------------------    
function edit_district($id,$data)
{
	$where 	= " vesseltype_sl  = '$id'"; 
	$result = $this->db->update('kiv_vesseltype_master', $data, $where);
	return $result;

}	
//----------------------------------------------------------------------------------------------------------------------------------
//                                                          PORT OF REGISTRY
//------------------------------------------------------------------------------------------------------------------------------------
// List port of regisrtry
// 06-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_portofregistry()
{
	$this->db->select('int_portoffice_id');
	$this->db->select('vchr_portoffice_name');
	$this->db->select('portofregistry_mal_name');
	$this->db->select('vchr_officecode');
	$this->db->select('int_portoffice_head_user_id');
	$this->db->select('vchr_portoffice_address');
	$this->db->select('vchr_portoffice_phone');
	$this->db->select('vchr_portoffice_email');
	$this->db->select('vchr_office_fax');
	$this->db->select('vchr_portoffice_loc');
	$this->db->select('kiv_status');
	//$this->db->select('delete_status');
	$this->db->from('tbl_portoffice_master');
	$this->db->where('kiv_status', 1);
	$this->db->order_by('vchr_portoffice_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_portofregistry($name)     
{ 
	$this->db->select('*');
	$this->db->from('tbl_portoffice_master');
	$this->db->where('vchr_portoffice_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  

function check_duplication_portofregistry_insert($name,$code)     
{ 
	$where=	"(vchr_portoffice_name ='$name' OR vchr_officecode='$code')";    	
	$this->db->select('*');
	$this->db->from('tbl_portoffice_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
 /*New function included for insertion case 22-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_portofregistry_edit($name,$code,$id)     
{ 
	$where=	"(vchr_portoffice_name ='$name' OR vchr_officecode='$code')";    	
	$this->db->select('*');
	$this->db->from('tbl_portoffice_master');
	$this->db->where($where);
	$this->db->where('int_portoffice_id !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_portofregistry_status($data,$vesseltype_sl)
{
	$where 		= 	"int_portoffice_id  = '$vesseltype_sl'"; 
	$updquery 	= 	$this->db->update_string('tbl_portoffice_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//------------------------------------------------------------------------------------------------------------------------------------    
function delete_portofregistry($data,$id)
{
	$where 	= 	" int_portoffice_id  = '$id'"; 
	$result = $this->db->update('tbl_portoffice_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_portofregistry($id,$data)
{
	$where 	= " int_portoffice_id  = '$id'"; 
	$result = $this->db->update('tbl_portoffice_master', $data, $where);
	return $result;
}	
//----------------------------------------------------------------------------------------------------------------------------------
//                                                          HULL MATERIAL
//------------------------------------------------------------------------------------------------------------------------------------
// List Hull material
// 06-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_hullmaterial()
{
	$this->db->select('hullmaterial_sl');
	$this->db->select('hullmaterial_name');
	$this->db->select('hullmaterial_mal_name');
	$this->db->select('hullmaterial_code');
	$this->db->select('hullmaterial_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_hullmaterial_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('hullmaterial_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_hullmaterial($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_hullmaterial_master');
	$this->db->where('hullmaterial_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  

function check_duplication_hullmaterial_insert($name,$code)     
{ 
	$where=	"(hullmaterial_name ='$name' OR hullmaterial_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_hullmaterial_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_hullmaterial_edit($name,$code,$id)     
{ 
	$where=	"(hullmaterial_name ='$name' OR hullmaterial_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_hullmaterial_master');
	$this->db->where($where);
	$this->db->where('hullmaterial_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_hullmaterial_status($data,$hullmaterial_sl)
{
	$where 		= 	"hullmaterial_sl  = '$hullmaterial_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_hullmaterial_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_hullmaterial($data,$id)
{
	$where 	= 	" hullmaterial_sl  = '$id'"; 
	$result = $this->db->update('kiv_hullmaterial_master', $data, $where);
	return 1;		
}
//------------------------------------------------------------------------------------------------------------------------------------    
function edit_hullmaterial($id,$data)
{
	$where 	= " hullmaterial_sl  = '$id'"; 
	$result = $this->db->update('kiv_hullmaterial_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        Ends Hull Material   
//------------------------------------------------------------------------------------------------------------------------------------
//                                                          ENGINE TYPE
//------------------------------------------------------------------------------------------------------------------------------------
// List Engine Type
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_enginetype()
{
	$this->db->select('enginetype_sl');
	$this->db->select('enginetype_name');
	$this->db->select('enginetype_mal_name');
	$this->db->select('enginetype_code');
	$this->db->select('enginetype_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_enginetype_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('enginetype_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_enginetype_edit($name,$code,$id)     
{ 
	$where=	"(enginetype_name ='$name' OR enginetype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_enginetype_master');
	$this->db->where($where);
	$this->db->where('enginetype_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_enginetype($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_enginetype_master');
	$this->db->where('enginetype_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  

function check_duplication_enginetype_insert($name,$code)     
{ 
	$where=	"(enginetype_name ='$name' OR enginetype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_enginetype_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_enginetype_status($data,$enginetype_sl)
{
	$where 		= 	"enginetype_sl  = '$enginetype_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_enginetype_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_enginetype($data,$id)
{
	$where 	= 	" enginetype_sl  = '$id'"; 
	$result = $this->db->update('kiv_enginetype_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_enginetype($id,$data)
{
	$where 	= " enginetype_sl  = '$id'"; 
	$result = $this->db->update('kiv_enginetype_master', $data, $where);
	return $result;

}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Engine Type   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                          Gear TYPE
//------------------------------------------------------------------------------------------------------------------------------------
// List Gear Type
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_geartype()
{
	$this->db->select('geartype_sl');
	$this->db->select('geartype_name');
	$this->db->select('geartype_mal_name');
	$this->db->select('geartype_code');
	$this->db->select('geartype_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_geartype_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('geartype_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_geartype($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_geartype_master');
	$this->db->where('geartype_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}   

function check_duplication_geartype_insert($name,$code)     
{ 
	$where=	"(geartype_name ='$name' OR geartype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_geartype_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_geartype_edit($name,$code,$id)     
{ 
	$where=	"(geartype_name ='$name' OR geartype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_geartype_master');
	$this->db->where($where);
	$this->db->where('geartype_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------- 
function update_geartype_status($data,$geartype_sl)
{
	$where 		= 	"geartype_sl  = '$geartype_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_geartype_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_geartype($data,$id)
{
	$where 	= 	" geartype_sl  = '$id'"; 
	$result = $this->db->update('kiv_geartype_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_geartype($id,$data)
{
	$where 	= " geartype_sl  = '$id'"; 
	$result = $this->db->update('kiv_geartype_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Gear Type   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                          CHAIN PORT TYPE
//------------------------------------------------------------------------------------------------------------------------------------
// List Chain Port Type
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_chainporttype()
{
	$this->db->select('chainporttype_sl');
	$this->db->select('chainporttype_name');
	$this->db->select('chainporttype_mal_name');
	$this->db->select('chainporttype_code');
	$this->db->select('chainporttype_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_chainporttype_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('chainporttype_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_chainporttype($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_chainporttype_master');
	$this->db->where('chainporttype_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}   

function check_duplication_chainporttype_insert($name,$code)     
{ 
	$where=	"(chainporttype_name ='$name' OR chainporttype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_chainporttype_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_chainporttype_edit($name,$code,$id)     
{ 
	$where=	"(chainporttype_name ='$name' OR chainporttype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_chainporttype_master');
	$this->db->where($where);
	$this->db->where('chainporttype_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
 /*New function included for edit case 14-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------- 
function update_chainporttype_status($data,$chainporttype_sl)
{
	$where 		= 	"chainporttype_sl  = '$chainporttype_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_chainporttype_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_chainporttype($data,$id)
{
	$where 	= 	" chainporttype_sl  = '$id'"; 
	$result = $this->db->update('kiv_chainporttype_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_chainporttype($id,$data)
{
	$where 	= " chainporttype_sl  = '$id'"; 
	$result = $this->db->update('kiv_chainporttype_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Chain Port Type   
//------------------------------------------------------------------------------------------------------------------------------------
//                                                          ROPE MATERIAL
//------------------------------------------------------------------------------------------------------------------------------------
// List Rope Material
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_ropematerial()
{
	$this->db->select('ropematerial_sl');
	$this->db->select('ropematerial_name');
	$this->db->select('ropematerial_mal_name');
	$this->db->select('ropematerial_code');
	$this->db->select('ropematerial_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_ropematerial_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('ropematerial_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_ropematerial($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_ropematerial_master');
	$this->db->where('ropematerial_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}     

function check_duplication_ropematerial_insert($name,$code)     
{ 
	$where=	"(ropematerial_name ='$name' OR ropematerial_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_ropematerial_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_ropematerial_edit($name,$code,$id)     
{ 
	$where=	"(ropematerial_name ='$name' OR ropematerial_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_ropematerial_master');
	$this->db->where($where);
	$this->db->where('ropematerial_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------- 
function update_ropematerial_status($data,$ropematerial_sl)
{
	$where 		= 	"ropematerial_sl  = '$ropematerial_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_ropematerial_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_ropematerial($data,$id)
{
	$where 	= 	" ropematerial_sl  = '$id'"; 
	$result = $this->db->update('kiv_ropematerial_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_ropematerial($id,$data)
{
	$where 	= " ropematerial_sl  = '$id'"; 
	$result = $this->db->update('kiv_ropematerial_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Rope Material   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                          NOZZLE TYPE
//------------------------------------------------------------------------------------------------------------------------------------
// List Nozzle Type
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_nozzletype()
{
	$this->db->select('nozzletype_sl');
	$this->db->select('nozzletype_name');
	$this->db->select('nozzletype_mal_name');
	$this->db->select('nozzletype_code');
	$this->db->select('nozzletype_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_nozzletype_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('nozzletype_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_nozzletype($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_nozzletype_master');
	$this->db->where('nozzletype_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}      

function check_duplication_nozzletype_insert($name,$code)     
{ 
	$where=	"(nozzletype_name ='$name' OR nozzletype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_nozzletype_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_nozzletype_edit($name,$code,$id)     
{ 
	$where=	"(nozzletype_name ='$name' OR nozzletype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_nozzletype_master');
	$this->db->where($where);
	$this->db->where('nozzletype_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------- 
function update_nozzletype_status($data,$nozzletype_sl)
{
	$where 		= 	"nozzletype_sl  = '$nozzletype_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_nozzletype_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_nozzletype($data,$id)
{
	$where 	= 	" nozzletype_sl  = '$id'"; 
	$result = $this->db->update('kiv_nozzletype_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_nozzletype($id,$data)
{
	$where 	= " nozzletype_sl  = '$id'"; 
	$result = $this->db->update('kiv_nozzletype_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Nozzle Type   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                          Fire Extinguisher TYPE
//------------------------------------------------------------------------------------------------------------------------------------
// List Fire Extinguisher Type
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_fireextinguisher_type()
{
	$this->db->select('fireextinguisher_type_sl');
	$this->db->select('fireextinguisher_type_name');
	$this->db->select('fireextinguisher_type_mal_name');
	$this->db->select('fireextinguisher_type_code');
	$this->db->select('fireextinguisher_type_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_fireextinguisher_type_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('fireextinguisher_type_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_fireextinguisher_type($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_fireextinguisher_type_master');
	$this->db->where('fireextinguisher_type_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}      

function check_duplication_fireextinguisher_type_insert($name,$code)     
{ 
	$where=	"(fireextinguisher_type_name ='$name' OR fireextinguisher_type_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_fireextinguisher_type_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
	}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_fireextinguisher_edit($name,$code,$id)     
{ 
	$where=	"(fireextinguisher_type_name ='$name' OR fireextinguisher_type_code='$code' OR fireextinguisher_type_mal_name='$mal_name')";    	
	$this->db->select('*');
	$this->db->from('kiv_fireextinguisher_type_master');
	$this->db->where($where);
	$this->db->where('fireextinguisher_type_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_fireextinguisher_type_status($data,$fireextinguisher_type_sl)
{
	$where 		= 	"fireextinguisher_type_sl  = '$fireextinguisher_type_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_fireextinguisher_type_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_fireextinguisher_type($data,$id)
{
	$where 	= 	" fireextinguisher_type_sl  = '$id'"; 
	$result = $this->db->update('kiv_fireextinguisher_type_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_fireextinguisher_type($id,$data)
{
	$where 	= " fireextinguisher_type_sl  = '$id'"; 
	$result = $this->db->update('kiv_fireextinguisher_type_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Fire Extinguisher Type   
//------------------------------------------------------------------------------------------------------------------------------------
//                                                          COMMUNICATION EQUIPMENT
//------------------------------------------------------------------------------------------------------------------------------------
// List Communication Equipment
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_commnequipment()
{
	$this->db->select('commnequipment_sl');
	$this->db->select('commnequipment_name');
	$this->db->select('commnequipment_mal_name');
	$this->db->select('commnequipment_code');
	$this->db->select('commnequipment_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_commnequipment_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('commnequipment_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_commnequipment($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_commnequipment_master');
	$this->db->where('commnequipment_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}     

function check_duplication_commnequipment_insert($name,$code)     
{ 
	$where=	"(commnequipment_name ='$name' OR commnequipment_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_commnequipment_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_commnequipment_edit($name,$code,$id)     
{ 
	$where=	"(commnequipment_name ='$name' OR commnequipment_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_commnequipment_master');
	$this->db->where($where);
	$this->db->where('commnequipment_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_commnequipment_status($data,$commnequipment_sl)
{
	$where 		= 	"commnequipment_sl  = '$commnequipment_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_commnequipment_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_commnequipment($data,$id)
{
	$where 	= 	" commnequipment_sl  = '$id'"; 
	$result = $this->db->update('kiv_commnequipment_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_commnequipment($id,$data)
{
	$where 	= " commnequipment_sl  = '$id'"; 
	$result = $this->db->update('kiv_commnequipment_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Communication Equipment   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                          NAVIGATION EQUIPMENT
//------------------------------------------------------------------------------------------------------------------------------------
// List Navigation Equipment
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_navgnequipments()
{
	$this->db->select('navgnequipments_sl');
	$this->db->select('navgnequipments_name');
	$this->db->select('navgnequipments_mal_name');
	$this->db->select('navgnequipments_code');
	$this->db->select('navgnequipments_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_navgnequipments_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('navgnequipments_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_navgnequipments($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_navgnequipments_master');
	$this->db->where('navgnequipments_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}      

function check_duplication_navgnequipments_insert($name,$code)     
{ 
	$where=	"(navgnequipments_name ='$name' OR navgnequipments_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_navgnequipments_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_navgnequipments_edit($name,$code,$id)     
{ 
	$where=	"(navgnequipments_name ='$name' OR navgnequipments_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_navgnequipments_master');
	$this->db->where($where);
	$this->db->where('navgnequipments_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_navgnequipments_status($data,$navgnequipments_sl)
{
	$where 		= 	"navgnequipments_sl  = '$navgnequipments_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_navgnequipments_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_navgnequipments($data,$id)
{
	$where 	= 	" navgnequipments_sl  = '$id'"; 
	$result = $this->db->update('kiv_navgnequipments_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_navgnequipments($id,$data)
{
	$where 	= " navgnequipments_sl  = '$id'"; 
	$result = $this->db->update('kiv_navgnequipments_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Navigation Equipment   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                          SOURCE OF WATER
//------------------------------------------------------------------------------------------------------------------------------------
// List Source of Water
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_sourceofwater()
{
	$this->db->select('sourceofwater_sl');
	$this->db->select('sourceofwater_name');
	$this->db->select('sourceofwater_mal_name');
	$this->db->select('sourceofwater_code');
	$this->db->select('sourceofwater_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_sourceofwater_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('sourceofwater_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_sourceofwater($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_sourceofwater_master');
	$this->db->where('sourceofwater_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}     

function check_duplication_sourceofwater_insert($name,$code)     
{ 
	$where=	"(sourceofwater_name ='$name' OR sourceofwater_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_sourceofwater_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_sourceofwater_edit($name,$code,$id)     
{ 
	$where=	"(sourceofwater_name ='$name' OR sourceofwater_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_sourceofwater_master');
	$this->db->where($where);
	$this->db->where('sourceofwater_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_sourceofwater_status($data,$sourceofwater_sl)
{
	$where 		= 	"sourceofwater_sl  = '$sourceofwater_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_sourceofwater_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_sourceofwater($data,$id)
{
	$where 	= 	" sourceofwater_sl  = '$id'"; 
	$result = $this->db->update('kiv_sourceofwater_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_sourceofwater($id,$data)
{
	$where 	= " sourceofwater_sl  = '$id'"; 
	$result = $this->db->update('kiv_sourceofwater_master', $data, $where);
	return $result;

}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Source of Water   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                          Means of Propulsion
//------------------------------------------------------------------------------------------------------------------------------------
// List Means of Propulsion
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_meansofpropulsion()
{
	$this->db->select('meansofpropulsion_sl');
	$this->db->select('meansofpropulsion_name');
	$this->db->select('meansofpropulsion_mal_name');
	$this->db->select('meansofpropulsion_code');
	$this->db->select('meansofpropulsion_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_meansofpropulsion_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('meansofpropulsion_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_meansofpropulsion($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_meansofpropulsion_master');
	$this->db->where('meansofpropulsion_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}       

function check_duplication_meansofpropulsion_insert($name,$code)     
{ 
	$where=	"(meansofpropulsion_name ='$name' OR meansofpropulsion_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_meansofpropulsion_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_meansofpropulsion_edit($name,$code,$id)     
{ 
	$where=	"(meansofpropulsion_name ='$name' OR meansofpropulsion_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_meansofpropulsion_master');
	$this->db->where($where);
	$this->db->where('meansofpropulsion_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_meansofpropulsion_status($data,$meansofpropulsion_sl)
{
	$where 		= 	"meansofpropulsion_sl  = '$meansofpropulsion_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_meansofpropulsion_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_meansofpropulsion($data,$id)
{
	$where 	= 	" meansofpropulsion_sl  = '$id'"; 
	$result = $this->db->update('kiv_meansofpropulsion_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_meansofpropulsion($id,$data)
{
	$where 	= " meansofpropulsion_sl  = '$id'"; 
	$result = $this->db->update('kiv_meansofpropulsion_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Means of Propulsion   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                          Model Number
//------------------------------------------------------------------------------------------------------------------------------------
// List Model Number
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_modelnumber()
{
	$this->db->select('modelnumber_sl');
	$this->db->select('modelnumber_name');
	$this->db->select('modelnumber_mal_name');
	$this->db->select('modelnumber_code');
	$this->db->select('modelnumber_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_modelnumber_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('modelnumber_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_modelnumber($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_modelnumber_master');
	$this->db->where('modelnumber_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}       

function check_duplication_modelnumber_insert($name,$code)     
{ 
	$where=	"(modelnumber_name ='$name' OR modelnumber_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_modelnumber_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_modelnumber_edit($name,$code,$id)     
{ 
	$where=	"(modelnumber_name ='$name' OR modelnumber_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_modelnumber_master');
	$this->db->where($where);
	$this->db->where('modelnumber_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_modelnumber_status($data,$modelnumber_sl)
{
	$where 		= 	"modelnumber_sl  = '$modelnumber_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_modelnumber_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_modelnumber($data,$id)
{
	$where 	= 	" modelnumber_sl  = '$id'"; 
	$result = $this->db->update('kiv_modelnumber_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_modelnumber($id,$data)
{
	$where 	= " modelnumber_sl  = '$id'"; 
	$result = $this->db->update('kiv_modelnumber_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Model Number   
//------------------------------------------------------------------------------------------------------------------------------------
//                                                          ELECTRICAL GENERATOR
//------------------------------------------------------------------------------------------------------------------------------------
// List Electrical Generator
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_electricalgenerator()
{
	$this->db->select('electricalgenerator_sl');
	$this->db->select('electricalgenerator_name');
	$this->db->select('electricalgenerator_mal_name');
	$this->db->select('electricalgenerator_code');
	$this->db->select('electricalgenerator_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_electricalgenerator_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('electricalgenerator_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_electricalgenerator($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_electricalgenerator_master');
	$this->db->where('electricalgenerator_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}        

function check_duplication_electricalgenerator_insert($name,$code)     
{ 
	$where=	"(electricalgenerator_name ='$name' OR electricalgenerator_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_electricalgenerator_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
 /*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    

function check_duplication_electricalgenerator_edit($name,$code,$id)     
{ 
	$where=	"(electricalgenerator_name ='$name' OR electricalgenerator_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_electricalgenerator_master');
	$this->db->where($where);
	$this->db->where('electricalgenerator_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_electricalgenerator_status($data,$electricalgenerator_sl)
{
	$where 		= 	"electricalgenerator_sl  = '$electricalgenerator_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_electricalgenerator_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_electricalgenerator($data,$id)
{
	$where 	= 	" electricalgenerator_sl  = '$id'"; 
	$result = $this->db->update('kiv_electricalgenerator_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_electricalgenerator($id,$data)
{
	$where 	= " electricalgenerator_sl  = '$id'"; 
	$result = $this->db->update('kiv_electricalgenerator_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Electrical Generator   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                          LOCATION OF ELECTRICAL GENERATOR
//------------------------------------------------------------------------------------------------------------------------------------
// List Location of Electrical Generator
// 08-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_locationof_electricalgenerator()
{
	$this->db->select('locationof_electricalgenerator_sl');
	$this->db->select('locationof_electricalgenerator_name');
	$this->db->select('locationof_electricalgenerator_mal_name');
	$this->db->select('locationof_electricalgenerator_code');
	$this->db->select('locationof_electricalgenerator_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_locationof_electricalgenerator_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('locationof_electricalgenerator_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_locationof_electricalgenerator($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_locationof_electricalgenerator_master');
	$this->db->where('locationof_electricalgenerator_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}         
	
function check_duplication_locationof_electricalgenerator_insert($name,$code)     
{ 
	$where=	"(locationof_electricalgenerator_name ='$name' OR locationof_electricalgenerator_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_locationof_electricalgenerator_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_locationof_electricalgenerator_edit($name,$code,$id)     
{ 
	$where=	"(locationof_electricalgenerator_name ='$name' OR locationof_electricalgenerator_code='$code')";  
	$this->db->select('*');
	$this->db->from('kiv_locationof_electricalgenerator_master');
	$this->db->where($where);
	$this->db->where('locationof_electricalgenerator_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_locationof_electricalgenerator_status($data,$locationof_electricalgenerator_sl)
{
	$where 		= 	"locationof_electricalgenerator_sl  = '$locationof_electricalgenerator_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_locationof_electricalgenerator_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_locationof_electricalgenerator($data,$id)
{
	$where 	= 	" locationof_electricalgenerator_sl  = '$id'"; 
	$result = $this->db->update('kiv_locationof_electricalgenerator_master', $data, $where);
	return 1;		
}

//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_locationof_electricalgenerator($id,$data)
{
	$where 	= " locationof_electricalgenerator_sl  = '$id'"; 
	$result = $this->db->update('kiv_locationof_electricalgenerator_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Location of Electrical Generatoer  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                         Fuel Used
//------------------------------------------------------------------------------------------------------------------------------------
// List Fuel
// 10-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_fuel()
{
	$this->db->select('fuel_sl');
	$this->db->select('fuel_name');
	$this->db->select('fuel_mal_name');
	$this->db->select('fuel_code');
	$this->db->select('fuel_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_fuel_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('fuel_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}

//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_fuel($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_fuel_master');
	$this->db->where('fuel_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}           

function check_duplication_fuel_insert($name,$code)     
{ 
	$where=	"(fuel_name ='$name' OR fuel_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_fuel_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_fuel_edit($name,$code,$id)     
{ 
	$where=	"(fuel_name ='$name' OR fuel_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_fuel_master');
	$this->db->where($where);
	$this->db->where('fuel_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_fuel_status($data,$fuel_sl)
{
	$where 		= 	"fuel_sl  = '$fuel_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_fuel_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_fuel($data,$id)
{
	$where 	= 	" fuel_sl  = '$id'"; 
	$result = $this->db->update('kiv_fuel_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_fuel($id,$data)
{
	$where 	= " fuel_sl  = '$id'"; 
	$result = $this->db->update('kiv_fuel_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Fuel   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                         Place of Survey
//------------------------------------------------------------------------------------------------------------------------------------
// List Place of survey
// 10-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_placeofsurvey()
{
	$this->db->select('placeofsurvey_sl');
	$this->db->select('placeofsurvey_name');
	$this->db->select('placeofsurvey_mal_name');
	$this->db->select('placeofsurvey_code');
	$this->db->select('placeofsurvey_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_placeofsurvey_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('placeofsurvey_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_placeofsurvey($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_placeofsurvey_master');
	$this->db->where('placeofsurvey_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}            

function check_duplication_placeofsurvey_insert($name,$code)     
{ 
	$where=	"(placeofsurvey_name ='$name' OR placeofsurvey_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_placeofsurvey_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_placeofsurvey_edit($name,$code,$id)     
{ 
	$where=	"(placeofsurvey_name ='$name' OR placeofsurvey_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_placeofsurvey_master');
	$this->db->where($where);
	$this->db->where('placeofsurvey_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_placeofsurvey_status($data,$placeofsurvey_sl)
{
	$where 		= 	"placeofsurvey_sl  = '$placeofsurvey_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_placeofsurvey_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_placeofsurvey($data,$id)
{
	$where 	= 	" placeofsurvey_sl  = '$id'"; 
	$result = $this->db->update('kiv_placeofsurvey_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_placeofsurvey($id,$data)
{
	$where 	= " placeofsurvey_sl  = '$id'"; 
	$result = $this->db->update('kiv_placeofsurvey_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Place of survey   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                         Nature of Operation
//------------------------------------------------------------------------------------------------------------------------------------
// List Nature of Operation
// 10-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_natureofoperation()
{
	$this->db->select('natureofoperation_sl');
	$this->db->select('natureofoperation_name');
	$this->db->select('natureofoperation_mal_name');
	$this->db->select('natureofoperation_code');
	$this->db->select('natureofoperation_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_natureofoperation_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('natureofoperation_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_natureofoperation($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_natureofoperation_master');
	$this->db->where('natureofoperation_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}             

function check_duplication_natureofoperation_insert($name,$code)     
{ 
	$where=	"(natureofoperation_name ='$name' OR natureofoperation_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_natureofoperation_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_natureofoperation_edit($name,$code,$id)     
{ 
	$where=	"(natureofoperation_name ='$name' OR natureofoperation_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_natureofoperation_master');
	$this->db->where($where);
	$this->db->where('natureofoperation_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_natureofoperation_status($data,$natureofoperation_sl)
{
	$where 		= 	"natureofoperation_sl  = '$natureofoperation_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_natureofoperation_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_natureofoperation($data,$id)
{
	$where 	= 	" natureofoperation_sl  = '$id'"; 
	$result = $this->db->update('kiv_natureofoperation_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_natureofoperation($id,$data)
{
	$where 	= " natureofoperation_sl  = '$id'"; 
	$result = $this->db->update('kiv_natureofoperation_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Nature of Operation   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                         Fire Pump Type
//------------------------------------------------------------------------------------------------------------------------------------
// List Fire Pump Type
// 10-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_firepumptype()
{
	$this->db->select('firepumptype_sl');
	$this->db->select('firepumptype_name');
	$this->db->select('firepumptype_mal_name');
	$this->db->select('firepumptype_code');
	$this->db->select('firepumptype_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_firepumptype_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('firepumptype_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_firepumptype($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_firepumptype_master');
	$this->db->where('firepumptype_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}              

function check_duplication_firepumptype_insert($name,$code)     
{ 
	$where=	"(firepumptype_name ='$name' OR firepumptype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_firepumptype_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_firepumptype_edit($name,$code,$id)     
{ 
	$where=	"(firepumptype_name ='$name' OR firepumptype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_firepumptype_master');
	$this->db->where($where);
	$this->db->where('firepumptype_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_firepumptype_status($data,$firepumptype_sl)
{
	$where 		= 	"firepumptype_sl  = '$firepumptype_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_firepumptype_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_firepumptype($data,$id)
{
	$where 	= 	" firepumptype_sl  = '$id'"; 
	$result = $this->db->update('kiv_firepumptype_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_firepumptype($id,$data)
{
	$where 	= " firepumptype_sl  = '$id'"; 
	$result = $this->db->update('kiv_firepumptype_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Fire Pump Type   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                         Form Type Location
//------------------------------------------------------------------------------------------------------------------------------------
// List Form Type Location
// 10-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_formtype_location()
{
	$this->db->select('formtype_location_sl');
	$this->db->select('formtype_location_name');
	$this->db->select('formtype_location_mal_name');
	$this->db->select('formtype_location_code');
	$this->db->select('formtype_location_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_formtype_location_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('formtype_location_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_formtype_location($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_formtype_location_master');
	$this->db->where('formtype_location_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}               

function check_duplication_formtype_location_insert($name,$code)     
{ 
	$where=	"(formtype_location_name ='$name' OR formtype_location_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_formtype_location_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_formtype_location_edit($name,$code,$id)     
{ 
	$where=	"(formtype_location_name ='$name' OR formtype_location_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_formtype_location_master');
	$this->db->where($where);
	$this->db->where('formtype_location_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_formtype_location_status($data,$formtype_location_sl)
{
	$where 		= 	"formtype_location_sl  = '$formtype_location_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_formtype_location_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_formtype_location($data,$id)
{
	$where 	= 	" formtype_location_sl  = '$id'"; 
	$result = $this->db->update('kiv_formtype_location_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_formtype_location($id,$data)
{
	$where 	= " formtype_location_sl  = '$id'"; 
	$result = $this->db->update('kiv_formtype_location_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Form Type Location   
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                        STERN	
//------------------------------------------------------------------------------------------------------------------------------------
// List Stern
// 10-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_stern()
{
	$this->db->select('stern_sl');
	$this->db->select('stern_name');
	$this->db->select('stern_mal_name');
	$this->db->select('stern_code');
	$this->db->select('stern_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_stern_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('stern_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_stern($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_stern_master');
	$this->db->where('stern_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                

function check_duplication_stern_insert($name,$code)     
{ 
	$where=	"(stern_name ='$name' OR stern_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_stern_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_stern_edit($name,$code,$id)     
{ 
	$where=	"(stern_name ='$name' OR stern_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_stern_master');
	$this->db->where($where);
	$this->db->where('stern_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_stern_status($data,$stern_sl)
{
	$where 		= 	"stern_sl  = '$stern_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_stern_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_stern($data,$id)
{
	$where 	= 	" stern_sl  = '$id'"; 
	$result = $this->db->update('kiv_stern_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_stern($id,$data)
{
	$where 	= " stern_sl  = '$id'"; 
	$result = $this->db->update('kiv_stern_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Stern  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                        BANK	
//------------------------------------------------------------------------------------------------------------------------------------
// List Bank
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_bank()
{
	$this->db->select('bank_sl');
	$this->db->select('bank_name');
	$this->db->select('bank_mal_name');
	$this->db->select('bank_code');
	$this->db->select('bank_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_bank_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('bank_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_bank($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_bank_master');
	$this->db->where('bank_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                 

function check_duplication_bank_insert($name,$code)     
{ 
	$where=	"(bank_name ='$name' OR bank_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_bank_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
/* 
function check_duplication_bank_edit($name,$code,$id)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_bank_master');
	$this->db->where('bank_name', $name);
	//$this->db->or_where('bank_code', $code);
	$this->db->where('bank_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
*/
function check_duplication_bank_edit($name,$code,$id)     
{ 
	$where=	"(bank_name ='$name' OR bank_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_bank_master');
	//$this->db->where('bank_name',$name);
	//$this->db->or_where('bank_code', $code);
	$this->db->where($where);
	$this->db->where('bank_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_bank_status($data,$bank_sl)
{
	$where 		= 	"bank_sl  = '$bank_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_bank_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_bank($data,$id)
{
	$where 	= 	" bank_sl  = '$id'"; 
	$result = $this->db->update('kiv_bank_master', $data, $where);
	return 1;		
}

//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_bank($id,$data)
{
	$where 	= " bank_sl  = '$id'"; 
	$result = $this->db->update('kiv_bank_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End bank  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                        OCCUPATION	
//------------------------------------------------------------------------------------------------------------------------------------
// List Occupation
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_occupation()
{
	$this->db->select('occupation_sl');
	$this->db->select('occupation_name');
	$this->db->select('occupation_mal_name');
	$this->db->select('occupation_code');
	$this->db->select('occupation_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_occupation_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('occupation_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_occupation($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_occupation_master');
	$this->db->where('occupation_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                   

function check_duplication_occupation_insert($name,$code)     
{ 
	$where=	"(occupation_name ='$name' OR occupation_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_occupation_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_occupation_edit($name,$code,$id)     
{ 
	$where=	"(occupation_name ='$name' OR occupation_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_occupation_master');
	$this->db->where($where);
	$this->db->where('occupation_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_occupation_status($data,$occupation_sl)
{
	$where 		= 	"occupation_sl  = '$occupation_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_occupation_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_occupation($data,$id)
{
	$where 	= 	" occupation_sl  = '$id'"; 
	$result = $this->db->update('kiv_occupation_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_occupation($id,$data)
{
$where 	= " occupation_sl  = '$id'"; 
	$result = $this->db->update('kiv_occupation_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End occupation  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                        Survey Activity	
//------------------------------------------------------------------------------------------------------------------------------------
// List Survey Activity
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_surveyactivity()
{
	$this->db->select('surveyactivity_sl');
	$this->db->select('surveyactivity_name');
	$this->db->select('surveyactivity_mal_name');
	$this->db->select('surveyactivity_code');
	$this->db->select('surveyactivity_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_surveyactivity_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('surveyactivity_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_surveyactivity($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_surveyactivity_master');
	$this->db->where('surveyactivity_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                    

function check_duplication_surveyactivity_insert($name,$code)     
{ 
	$where=	"(surveyactivity_name ='$name' OR surveyactivity_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_surveyactivity_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_surveyactivity_edit($name,$code,$id)     
{ 
	$where=	"(surveyactivity_name ='$name' OR surveyactivity_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_surveyactivity_master');
	$this->db->where($where);
	$this->db->where('surveyactivity_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_surveyactivity_status($data,$surveyactivity_sl)
{
	$where 		= 	"surveyactivity_sl  = '$surveyactivity_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_surveyactivity_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_surveyactivity($data,$id)
{
	$where 	= 	" surveyactivity_sl  = '$id'"; 
	$result = $this->db->update('kiv_surveyactivity_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_surveyactivity($id,$data)
{
	$where 	= " surveyactivity_sl  = '$id'"; 
	$result = $this->db->update('kiv_surveyactivity_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Survey Activity  
//------------------------------------------------------------------------------------------------------------------------------------
//                                                        Upload document type	
//------------------------------------------------------------------------------------------------------------------------------------
// List Upload document type	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_document_type()
{
	$this->db->select('document_type_sl');
	$this->db->select('document_type_name');
	$this->db->select('document_type_mal_name');
	$this->db->select('document_type_code');
	$this->db->select('document_type_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_document_type_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('document_type_sl','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_document_type($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_document_type_master');
	$this->db->where('document_type_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                      

function check_duplication_document_type_insert($name,$code)     
{ 
	$where=	"(document_type_name ='$name' OR document_type_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_document_type_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_document_type_edit($name,$code,$id)     
{ 
	$where=	"(document_type_name ='$name' OR document_type_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_document_type_master');
	$this->db->where($where);
	$this->db->where('document_type_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_document_type_status($data,$document_type_sl)
{
	$where 		= 	"document_type_sl  = '$document_type_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_document_type_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_document_type($data,$id)
{
	$where 	= 	" document_type_sl  = '$id'"; 
	$result = $this->db->update('kiv_document_type_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_document_type($id,$data)
{
	$where 	= " document_type_sl  = '$id'"; 
	$result = $this->db->update('kiv_document_type_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Upload document type	  
//------------------------------------------------------------------------------------------------------------------------------------
//                                                        File document	
//------------------------------------------------------------------------------------------------------------------------------------
// List File document	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_document()     
{ 
	$this->db->select('kiv_document_master.document_sl');
	$this->db->select('kiv_document_master.document_type_id');
	$this->db->select('kiv_document_master.document_name');
	$this->db->select('kiv_document_master.document_mal_name');
	$this->db->select('kiv_document_master.document_code');
	$this->db->select('kiv_document_master.document_status');
	$this->db->select('kiv_document_master.delete_status');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->from('kiv_document_master');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_document_master.document_type_id');
	$this->db->order_by('kiv_document_master.document_type_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_document($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_document_master');
	$this->db->where('document_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                       

function check_duplication_document_insert($type_id,$name,$code)     
{ 
	$where=	"((document_type_id='$type_id') AND (document_name ='$name' OR document_code='$code'))";  	
	$this->db->select('*');
	$this->db->from('kiv_document_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
/*New function included for edit case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_document_edit($type_id,$name,$code,$id)     
{ 
	$where=	"((document_type_id='$type_id') AND (document_name ='$name' OR document_code='$code'))";    	
	$this->db->select('*');
	$this->db->from('kiv_document_master');
	$this->db->where($where);
	$this->db->where('document_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_document_status($data,$document_sl)
{
	$where 		= 	"document_sl  = '$document_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_document_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_document($data,$id)
{
	$where 	= 	" document_sl  = '$id'"; 
	$result = $this->db->update('kiv_document_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_document($id,$data)
{
	$where 	= " document_sl  = '$id'"; 
	$result = $this->db->update('kiv_document_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End File document	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Pollution Control Device	
//------------------------------------------------------------------------------------------------------------------------------------
// List Pollution Control Device	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_pollution_controldevice()
{
	$this->db->select('pollution_controldevice_sl');
	$this->db->select('pollution_controldevice_name');
	$this->db->select('pollution_controldevice_mal_name');
	$this->db->select('pollution_controldevice_code');
	$this->db->select('pollution_controldevice_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_pollution_controldevice_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('pollution_controldevice_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_pollution_controldevice($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_pollution_controldevice_master');
	$this->db->where('pollution_controldevice_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                       

function check_duplication_pollution_controldevice_insert($name,$code)     
{ 
	$where=	"(pollution_controldevice_name ='$name' OR pollution_controldevice_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_pollution_controldevice_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_pollution_controldevice_edit($name,$code,$id)     
{ 
	$where=	"(pollution_controldevice_name ='$name' OR pollution_controldevice_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_pollution_controldevice_master');
	$this->db->where($where);
	$this->db->where('pollution_controldevice_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_pollution_controldevice_status($data,$pollution_controldevice_sl)
{
	$where 		= 	"pollution_controldevice_sl  = '$pollution_controldevice_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_pollution_controldevice_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_pollution_controldevice($data,$id)
{
	$where 	= 	" pollution_controldevice_sl  = '$id'"; 
	$result = $this->db->update('kiv_pollution_controldevice_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_pollution_controldevice($id,$data)
{
	$where 	= " pollution_controldevice_sl  = '$id'"; 
	$result = $this->db->update('kiv_pollution_controldevice_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Pollution Control Device	  
//------------------------------------------------------------------------------------------------------------------------------------
//                                                       Plying State	
//------------------------------------------------------------------------------------------------------------------------------------
// List Plying State	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_plyingstate()
{
	$this->db->select('plyingstate_sl');
	$this->db->select('plyingstate_name');
	$this->db->select('plyingstate_mal_name');
	$this->db->select('plyingstate_code');
	$this->db->select('plyingstate_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_plyingstate_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('plyingstate_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_plyingstate($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_plyingstate_master');
	$this->db->where('plyingstate_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                        

function check_duplication_plyingstate_insert($name,$code)     
{ 
	$where=	"(plyingstate_name ='$name' OR plyingstate_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_plyingstate_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_plyingstate_edit($name,$code,$id)     
{ 
	$where=	"(plyingstate_name ='$name' OR plyingstate_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_plyingstate_master');
	$this->db->where($where);
	$this->db->where('plyingstate_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_plyingstate_status($data,$plyingstate_sl)
{
	$where 		= 	"plyingstate_sl  = '$plyingstate_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_plyingstate_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_plyingstate($data,$id)
{
	$where 	= 	" plyingstate_sl  = '$id'"; 
	$result = $this->db->update('kiv_plyingstate_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_plyingstate($id,$data)
{
	$where 	= " plyingstate_sl  = '$id'"; 
	$result = $this->db->update('kiv_plyingstate_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Plying State	  
//------------------------------------------------------------------------------------------------------------------------------------
//                                                       Towing	
//------------------------------------------------------------------------------------------------------------------------------------
// List Towing	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_towing()
{
	$this->db->select('towing_sl');
	$this->db->select('towing_name');
	$this->db->select('towing_mal_name');
	$this->db->select('towing_code');
	$this->db->select('towing_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_towing_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('towing_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_towing($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_towing_master');
	$this->db->where('towing_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                        

function check_duplication_towing_insert($name,$code)     
{ 
	$where=	"(towing_name ='$name' OR towing_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_towing_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_towing_edit($name,$code,$id)     
{ 
	$where=	"(towing_name ='$name' OR towing_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_towing_master');
	$this->db->where($where);
	$this->db->where('towing_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_towing_status($data,$towing_sl)
{
	$where 		= 	"towing_sl  = '$towing_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_towing_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_towing($data,$id)
{
	$where 	= 	" towing_sl  = '$id'"; 
	$result = $this->db->update('kiv_towing_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_towing($id,$data)
{
	$where 	= " towing_sl  = '$id'"; 
	$result = $this->db->update('kiv_towing_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Towing	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Fire extinguisher sub type	
//------------------------------------------------------------------------------------------------------------------------------------
// List Fire extinguisher sub type	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_fireextinguisher_subtype()
{
	$this->db->select('fireextinguisher_subtype_sl');
	$this->db->select('fireextinguisher_subtype_name');
	$this->db->select('fireextinguisher_subtype_mal_name');
	$this->db->select('fireextinguisher_subtype_code');
	$this->db->select('fireextinguisher_subtype_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_fireextinguisher_subtype_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('fireextinguisher_subtype_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_fireextinguisher_subtype($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_fireextinguisher_subtype_master');
	$this->db->where('fireextinguisher_subtype_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                        

function check_duplication_fireextinguisher_subtype_insert($name,$code)     
{ 
	$where=	"(fireextinguisher_subtype_name ='$name' OR fireextinguisher_subtype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_fireextinguisher_subtype_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_fireextinguisher_subtype_edit($name,$code,$id)     
{ 
	$where=	"(fireextinguisher_subtype_name ='$name' OR fireextinguisher_subtype_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_fireextinguisher_subtype_master');
	$this->db->where($where);
	$this->db->where('fireextinguisher_subtype_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 

//-------------------------------------------------------------------------------------------------------------------------------------    
function update_fireextinguisher_subtype_status($data,$fireextinguisher_subtype_sl)
{
	$where 		= 	"fireextinguisher_subtype_sl  = '$fireextinguisher_subtype_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_fireextinguisher_subtype_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_fireextinguisher_subtype($data,$id)
{
	$where 	= 	" fireextinguisher_subtype_sl  = '$id'"; 
	$result = $this->db->update('kiv_fireextinguisher_subtype_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_fireextinguisher_subtype($id,$data)
{
	$where 	= " fireextinguisher_subtype_sl  = '$id'"; 
	$result = $this->db->update('kiv_fireextinguisher_subtype_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Fire extinguisher sub type	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Equipment	
//------------------------------------------------------------------------------------------------------------------------------------
// List Equipment	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
/*
function get_equipment()
{
	$this->db->select('equipment_sl'); 
	$this->db->select('equipment_type_id');	
	$this->db->select('equipment_name');
	$this->db->select('equipment_mal_name');
	$this->db->select('equipment_code');
	$this->db->select('equipment_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_equipment_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('equipment_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
*/
function get_equipment()     
{ 
	$this->db->select('kiv_equipment_master.equipment_sl');
	$this->db->select('kiv_equipment_master.equipment_type_id');
	$this->db->select('kiv_equipment_master.equipment_name');
	$this->db->select('kiv_equipment_master.equipment_mal_name');
	$this->db->select('kiv_equipment_master.equipment_code');
	$this->db->select('kiv_equipment_master.equipment_measurement');
	$this->db->select('kiv_equipment_master.equipment_status');
	$this->db->select('kiv_equipment_master.delete_status');
	$this->db->select('kiv_equipment_type_master.equipment_type_name');
	$this->db->select('kiv_measurement_master.measurement_name');
	$this->db->from('kiv_equipment_master');
	$this->db->where('kiv_equipment_master.delete_status', 0);
	$this->db->join('kiv_equipment_type_master','kiv_equipment_type_master.equipment_type_sl=kiv_equipment_master.equipment_type_id');
	$this->db->join('kiv_measurement_master','kiv_measurement_master.measurement_sl=kiv_equipment_master.equipment_measurement','left');
	//$where="'join kiv_measurement_master','kiv_measurement_master.measurement_sl=kiv_equipment_master.equipment_measurement'";
	//$this->db->or_where($where);
	$this->db->order_by('kiv_equipment_master.equipment_type_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_equipment($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_equipment_master');
	$this->db->where('equipment_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  

function check_duplication_equipment_insert($type_id,$name,$code)     
{ 
	$where=	"((equipment_type_id='$type_id') AND (equipment_name ='$name' OR equipment_code='$code'))";  	
	$this->db->select('*');
	$this->db->from('kiv_equipment_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
/*New function included for edit case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_equipment_edit($name,$code,$id)     
{ 
	$where=	"(equipment_name ='$name' OR equipment_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_equipment_master');
	$this->db->where($where);
	$this->db->where('equipment_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 

//-------------------------------------------------------------------------------------------------------------------------------------    
function update_equipment_status($data,$equipment_sl)
{
	$where 		= 	"equipment_sl  = '$equipment_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_equipment_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_equipment($data,$id)
{
	$where 	= 	" equipment_sl  = '$id'"; 
	$result = $this->db->update('kiv_equipment_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_equipment($id,$data)
{
	$where 	= " equipment_sl  = '$id'"; 
	$result = $this->db->update('kiv_equipment_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Equipment	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Fire Appliance	
//------------------------------------------------------------------------------------------------------------------------------------
// List Fire Appliance	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_fireappliance()
{
	$this->db->select('fireappliance_sl');
	$this->db->select('fireappliance_name');
	$this->db->select('fireappliance_mal_name');
	$this->db->select('fireappliance_code');
	$this->db->select('fireappliance_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_fireappliance_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('fireappliance_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_fireappliance($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_fireappliance_master');
	$this->db->where('fireappliance_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                        

function check_duplication_fireappliance_insert($name,$code)     
{ 
	$where=	"(fireappliance_name ='$name' OR fireappliance_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_fireappliance_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
 /*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_fireappliance_edit($name,$code,$id)     
{ 
	$where=	"(fireappliance_name ='$name' OR fireappliance_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_fireappliance_master');
	$this->db->where($where);
	$this->db->where('fireappliance_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_fireappliance_status($data,$fireappliance_sl)
{
	$where 		= 	"fireappliance_sl  = '$fireappliance_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_fireappliance_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_fireappliance($data,$id)
{
	$where 	= 	" fireappliance_sl  = '$id'"; 
	$result = $this->db->update('kiv_fireappliance_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_fireappliance($id,$data)
{
	$where 	= " fireappliance_sl  = '$id'"; 
	$result = $this->db->update('kiv_fireappliance_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Fire Appliance	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Vessel Class	
//------------------------------------------------------------------------------------------------------------------------------------
// List Vessel Class	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_vessel_class()
{
	$this->db->select('vessel_class_sl');
	$this->db->select('vessel_class_name');
	$this->db->select('vessel_class_mal_name');
	$this->db->select('vessel_class_code');
	$this->db->select('vessel_class_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_vessel_class_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('vessel_class_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_vessel_class($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_vessel_class_master');
	$this->db->where('vessel_class_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                        

function check_duplication_vessel_class_insert($name,$code)     
{ 
	$where=	"(vessel_class_name ='$name' OR vessel_class_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_vessel_class_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_vessel_class_edit($name,$code,$id)     
{ 
	$where=	"(vessel_class_name ='$name' OR vessel_class_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_vessel_class_master');
	$this->db->where($where);
	$this->db->where('vessel_class_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_vessel_class_status($data,$vessel_class_sl)
{
	$where 		= 	"vessel_class_sl  = '$vessel_class_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_vessel_class_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_vessel_class($data,$id)
{
	$where 	= 	" vessel_class_sl  = '$id'"; 
	$result = $this->db->update('kiv_vessel_class_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_vessel_class($id,$data)
{
	$where 	= " vessel_class_sl  = '$id'"; 
	$result = $this->db->update('kiv_vessel_class_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Vessel Class	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Location	
//------------------------------------------------------------------------------------------------------------------------------------
// List Location	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_location()
{
	$this->db->select('location_sl');
	$this->db->select('location_name');
	$this->db->select('location_mal_name');
	$this->db->select('location_code');
	$this->db->select('location_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_location_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('location_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
	}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_location($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_location_master');
	$this->db->where('location_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                         

function check_duplication_location_insert($name,$code)     
{ 
	$where=	"(location_name ='$name' OR location_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_location_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_location_edit($name,$code,$id)     
{ 
	$where=	"(location_name ='$name' OR location_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_location_master');
	$this->db->where($where);
	$this->db->where('location_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_location_status($data,$location_sl)
{
	$where 		= 	"location_sl  = '$location_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_location_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_location($data,$id)
{
	$where 	= 	" location_sl  = '$id'"; 
	$result = $this->db->update('kiv_location_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_location($id,$data)
{
	$where 	= " location_sl  = '$id'"; 
	$result = $this->db->update('kiv_location_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Location	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Metric	
//------------------------------------------------------------------------------------------------------------------------------------
// List Metric	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_metric()
{
	$this->db->select('metric_sl');
	$this->db->select('metric_name');
	$this->db->select('metric_mal_name');
	$this->db->select('metric_code');
	$this->db->select('metric_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_metric_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('metric_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_metric($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_metric_master');
	$this->db->where('metric_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                          

function check_duplication_metric_insert($name,$code)     
{ 
	$where=	"(metric_name ='$name' OR metric_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_metric_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_metric_edit($name,$code,$id)     
{ 
	$where=	"(metric_name ='$name' OR metric_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_metric_master');
	$this->db->where($where);
	$this->db->where('metric_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_metric_status($data,$metric_sl)
{
	$where 		= 	"metric_sl  = '$metric_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_metric_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_metric($data,$id)
{
	$where 	= 	" metric_sl  = '$id'"; 
	$result = $this->db->update('kiv_metric_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_metric($id,$data)
{
	$where 	= " metric_sl  = '$id'"; 
	$result = $this->db->update('kiv_metric_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Metric	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       RULE	
//------------------------------------------------------------------------------------------------------------------------------------
// List Rule	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_rule()
{
	$this->db->select('rule_sl');
	$this->db->select('rule_name');
	$this->db->select('rule_mal_name');
	$this->db->select('rule_code');
	$this->db->select('rule_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_rule_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('rule_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_rule($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_rule_master');
	$this->db->where('rule_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}                           

function check_duplication_rule_insert($name,$code)     
{ 
	$where=	"(rule_name ='$name' OR rule_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_rule_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_rule_edit($name,$code,$id)     
{ 
	$where=	"(rule_name ='$name' OR rule_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_rule_master');
	$this->db->where($where);
	$this->db->where('rule_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_rule_status($data,$rule_sl)
{
	$where 		= 	"rule_sl  = '$rule_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_rule_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_rule($data,$id)
{
	$where 	= 	" rule_sl  = '$id'"; 
	$result = $this->db->update('kiv_rule_master', $data, $where);
	return 1;		
}
//------------------------------------------------------------------------------------------------------------------------------------    
function edit_rule($id,$data)
{
	$where 	= " rule_sl  = '$id'"; 
	$result = $this->db->update('kiv_rule_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Rule	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Inspection	
//------------------------------------------------------------------------------------------------------------------------------------
// List Inspection	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_inspection()
{
	$this->db->select('inspection_sl');
	$this->db->select('inspection_name');
	$this->db->select('inspection_mal_name');
	$this->db->select('inspection_code');
	$this->db->select('inspection_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_inspection_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('inspection_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_inspection($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_inspection_master');
	$this->db->where('inspection_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  

function check_duplication_inspection_insert($name,$code)     
{ 
	$where=	"(inspection_name ='$name' OR inspection_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_inspection_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_inspection_edit($name,$code,$id)     
{ 
	$where=	"(inspection_name ='$name' OR inspection_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_inspection_master');
	$this->db->where($where);
	$this->db->where('inspection_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_inspection_status($data,$inspection_sl)
{
	$where 		= 	"inspection_sl  = '$inspection_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_inspection_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_inspection($data,$id)
{
	$where 	= 	" inspection_sl  = '$id'"; 
	$result = $this->db->update('kiv_inspection_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_inspection($id,$data)
{
	$where 	= " inspection_sl  = '$id'"; 
	$result = $this->db->update('kiv_inspection_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Inspection	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Engine Class	
//------------------------------------------------------------------------------------------------------------------------------------
// List Engine Class	
// 11-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_engine_class()
{
	$this->db->select('engine_class_sl');
	$this->db->select('engine_class_name');
	$this->db->select('engine_class_mal_name');
	$this->db->select('engine_class_code');
	$this->db->select('engine_class_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_engine_class_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('engine_class_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_engine_class($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_engine_class_master');
	$this->db->where('engine_class_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}    

function check_duplication_engine_class_insert($name,$code)     
{ 
	$where=	"(engine_class_name ='$name' OR engine_class_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_engine_class_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_engine_class_edit($name,$code,$id)     
{ 
	$where=	"(engine_class_name ='$name' OR engine_class_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_engine_class_master');
	$this->db->where($where);
	$this->db->where('engine_class_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_engine_class_status($data,$engine_class_sl)
{
	$where 		= 	"engine_class_sl  = '$engine_class_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_engine_class_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_engine_class($data,$id)
{
	$where 	= 	" engine_class_sl  = '$id'"; 
	$result = $this->db->update('kiv_engine_class_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_engine_class($id,$data)
{
	$where 	= " engine_class_sl  = '$id'"; 
	$result = $this->db->update('kiv_engine_class_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Engine Class	  
//------------------------------------------------------------------------------------------------------------------------------------
//                                                       User	
//------------------------------------------------------------------------------------------------------------------------------------
// List User	
// 12-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_user()
{
	$this->db->select('user_master_id');
	$this->db->select('user_master_name');
	$this->db->select('user_master_password');
	$this->db->select('user_master_id_user_type');
	$this->db->select('customer_id');
	$this->db->select('survey_user_id');
	$this->db->select('user_master_status');
	$this->db->select('user_decrypt_pwd');
	$this->db->from('user_master');
	//$this->db->where('delete_status', 0);
	$this->db->order_by('user_master_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_user($name)     
{ 
	$this->db->select('*');
	$this->db->from('user_master');
	$this->db->where('user_master_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_user_edit($name,$user_password,$id)     
{ 
	$where=	"(user_master_name ='$name' OR user_master_password='$user_password')";    	
	$this->db->select('*');
	$this->db->from('user_master');
	$this->db->where($where);
	$this->db->where('user_master_id !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_user_status($data,$user_sl)
{
	$where 		= 	"user_master_id  = '$user_sl'"; 
	$updquery 	= 	$this->db->update_string('user_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_user($data,$id)
{
	$where 	= 	" user_master_id  = '$id'"; 
	$result = $this->db->update('user_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_user($id,$data)
{
	$where 	= " user_master_id  = '$id'"; 
	$result = $this->db->update('user_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End User	  
//------------------------------------------------------------------------------------------------------------------------------------
//                                                       User Type	
//------------------------------------------------------------------------------------------------------------------------------------
// List user type	
// 12-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_user_type()
{
	$this->db->select('user_type_id');
	$this->db->select('user_type_type_name');
	$this->db->select('user_type_status');
	//$this->db->select('delete_status');
	$this->db->from('user_type');
	//$this->db->where('delete_status', 0);
	$this->db->order_by('user_type_type_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_user_type($name)     
{ 
	$this->db->select('*');
	$this->db->from('user_type');
	$this->db->where('user_type_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_user_type_edit($name,$code,$id)     
{ 
	$where=	"(user_type_name ='$name' OR user_type_code='$code')";    	
	$this->db->select('*');
	$this->db->from('user_type');
	$this->db->where($where);
	$this->db->where('user_type_id !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_user_type_status($data,$user_type_sl)
{
	$where 		= 	"user_type_id  = '$user_type_sl'"; 
	$updquery 	= 	$this->db->update_string('user_type', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_user_type($data,$id)
{
	$where 	= 	" user_type_id  = '$id'"; 
	$result = $this->db->update('user_type', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_user_type($id,$data)
{
	$where 	= " user_type_id  = '$id'"; 
	$result = $this->db->update('user_type', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End User Type	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Navigation Light Master	
//------------------------------------------------------------------------------------------------------------------------------------
// List Navigation Light Master	
// 12-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_navgn_light()
{
	$this->db->select('navgn_light_sl');
	$this->db->select('navgn_light_name');
	$this->db->select('navgn_light_mal_name');
	$this->db->select('navgn_light_code');
	$this->db->select('navgn_light_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_navgn_light_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('navgn_light_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_navgn_light($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_navgn_light_master');
	$this->db->where('navgn_light_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}   

function check_duplication_navgn_light_insert($name,$code)     
{ 
	$where=	"(navgn_light_name ='$name' OR navgn_light_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_navgn_light_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_navgn_light_edit($name,$code,$id)     
{ 
	$where=	"(navgn_light_name ='$name' OR navgn_light_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_navgn_light_master');
	$this->db->where($where);
	$this->db->where('navgn_light_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_navgn_light_status($data,$navgn_light_sl)
{
	$where 		= 	"navgn_light_sl  = '$navgn_light_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_navgn_light_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_navgn_light($data,$id)
{
	$where 	= 	" navgn_light_sl  = '$id'"; 
	$result = $this->db->update('kiv_navgn_light_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_navgn_light($id,$data)
{
	$where 	= " navgn_light_sl  = '$id'"; 
	$result = $this->db->update('kiv_navgn_light_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Navigation Light Master	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Sound Signal Master	
//------------------------------------------------------------------------------------------------------------------------------------
// List Sound Signal Master	
// 12-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_sound_signal()
{
	$this->db->select('sound_signal_sl');
	$this->db->select('sound_signal_name');
	$this->db->select('sound_signal_mal_name');
	$this->db->select('sound_signal_code');
	$this->db->select('sound_signal_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_sound_signal_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('sound_signal_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_sound_signal($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_sound_signal_master');
	$this->db->where('sound_signal_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  

function check_duplication_sound_signal_insert($name,$code)     
{ 
	$where=	"(sound_signal_name ='$name' OR sound_signal_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_sound_signal_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_sound_signal_edit($name,$code,$id)     
{ 
	$where=	"(sound_signal_name ='$name' OR sound_signal_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_sound_signal_master');
	$this->db->where($where);
	$this->db->where('sound_signal_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_sound_signal_status($data,$sound_signal_sl)
{
	$where 		= 	"sound_signal_sl  = '$sound_signal_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_sound_signal_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_sound_signal($data,$id)
{
	$where 	= 	" sound_signal_sl  = '$id'"; 
	$result = $this->db->update('kiv_sound_signal_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_sound_signal($id,$data)
{
	$where 	= " sound_signal_sl  = '$id'"; 
	$result = $this->db->update('kiv_sound_signal_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Sound Signal Master	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Insurance Type Master	
//------------------------------------------------------------------------------------------------------------------------------------
// List Insurance Type Master	
// 12-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_insurance_type()
{
	$this->db->select('insurance_type_sl');
	$this->db->select('insurance_type_name');
	$this->db->select('insurance_type_mal_name');
	$this->db->select('insurance_type_code');
	$this->db->select('insurance_type_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_insurance_type_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('insurance_type_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_insurance_type($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_insurance_type_master');
	$this->db->where('insurance_type_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}   

function check_duplication_insurance_type_insert($name,$code)     
{ 
	$where=	"(insurance_type_name ='$name' OR insurance_type_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_insurance_type_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_insurance_type_edit($name,$code,$id)     
{ 
	$where=	"(insurance_type_name ='$name' OR insurance_type_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_insurance_type_master');
	$this->db->where($where);
	$this->db->where('insurance_type_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_insurance_type_status($data,$insurance_type_sl)
{
	$where 		= 	"insurance_type_sl  = '$insurance_type_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_insurance_type_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_insurance_type($data,$id)
{
	$where 	= 	" insurance_type_sl  = '$id'"; 
	$result = $this->db->update('kiv_insurance_type_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_insurance_type($id,$data)
{
	$where 	= " insurance_type_sl  = '$id'"; 
	$result = $this->db->update('kiv_insurance_type_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Insurance Type Master	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Hull Plating Material Master	
//------------------------------------------------------------------------------------------------------------------------------------
// List Hull Plating Material Master	
// 12-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 

function get_hullplating_material()
{
	$this->db->select('hullplating_material_sl');
	$this->db->select('hullplating_material_name');
	$this->db->select('hullplating_material_mal_name');
	$this->db->select('hullplating_material_code');
	$this->db->select('hullplating_material_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_hullplating_material_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('hullplating_material_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_hullplating_material($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_hullplating_material_master');
	$this->db->where('hullplating_material_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}    

function check_duplication_hullplating_material_insert($name,$code)     
{ 
	$where=	"(hullplating_material_name ='$name' OR hullplating_material_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_hullplating_material_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_hullplating_material_edit($name,$code,$id)     
{ 
	$where=	"(hullplating_material_name ='$name' OR hullplating_material_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_hullplating_material_master');
	$this->db->where($where);
	$this->db->where('hullplating_material_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_hullplating_material_status($data,$hullplating_material_sl)
{
	$where 		= 	"hullplating_material_sl  = '$hullplating_material_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_hullplating_material_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_hullplating_material($data,$id)
{
	$where 	= 	" hullplating_material_sl  = '$id'"; 
	$result = $this->db->update('kiv_hullplating_material_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_hullplating_material($id,$data)
{
	$where 	= " hullplating_material_sl  = '$id'"; 
	$result = $this->db->update('kiv_hullplating_material_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Hull Plating Material Master	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Equipment Type Master	
//------------------------------------------------------------------------------------------------------------------------------------
// List Equipment Type Master	
// 12-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_equipment_type()
{
	$this->db->select('equipment_type_sl');
	$this->db->select('equipment_type_name');
	$this->db->select('equipment_type_mal_name');
	$this->db->select('equipment_type_code');
	$this->db->select('equipment_mastertablename');
	$this->db->select('equipment_type_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_equipment_type_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('equipment_type_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_equipment_masterTableName($sl)
{
	$this->db->select('equipment_mastertablename');
	$this->db->from('kiv_equipment_type_master');
	$this->db->where('equipment_type_sl', $sl);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_equipment_measurement()
{
	$this->db->select('measurement_sl');
	$this->db->select('measurement_name');
	$this->db->select('measurement_mal_name');
	$this->db->select('measurement_code');
	$this->db->select('measurement_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_measurement_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('measurement_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_equipment_type($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_equipment_type_master');
	$this->db->where('equipment_type_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}     

function check_duplication_equipment_type_insert($name,$code)     
{ 
	$where=	"(equipment_type_name ='$name' OR measurement_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_equipment_type_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_equipment_type_edit($name,$code,$id)     
{ 
	$where=	"(equipment_type_name ='$name' OR equipment_type_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_equipment_type_master');
	$this->db->where($where);
	$this->db->where('equipment_type_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_equipment_type_status($data,$equipment_type_sl)
{
	$where 		= 	"equipment_type_sl  = '$equipment_type_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_equipment_type_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_equipment_type($data,$id)
{
	$where 	= 	" equipment_type_sl  = '$id'"; 
	$result = $this->db->update('kiv_equipment_type_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_equipment_type($id,$data)
{
	$where 	= " equipment_type_sl  = '$id'"; 
	$result = $this->db->update('kiv_equipment_type_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Equipment Type Master	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                       Equipment Material Master	
//------------------------------------------------------------------------------------------------------------------------------------
// List Equipment Material Master	
// 12-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_equipment_material()
{
	$this->db->select('equipment_material_sl');
	$this->db->select('equipment_material_name');
	$this->db->select('equipment_material_mal_name');
	$this->db->select('equipment_material_code');
	$this->db->select('equipment_material_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_equipment_material_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('equipment_material_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_equipment_material($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_equipment_material_master');
	$this->db->where('equipment_material_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}     

function check_duplication_equipment_material_insert($name,$code)     
{ 
	$where=	"(equipment_material_name ='$name' OR equipment_material_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_equipment_material_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_equipment_material_edit($name,$code,$id)     
{ 
	$where=	"(equipment_material_name ='$name' OR equipment_material_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_equipment_material_master');
	$this->db->where($where);
	$this->db->where('equipment_material_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_equipment_material_status($data,$equipment_material_sl)
{
	$where 		= 	"equipment_material_sl  = '$equipment_material_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_equipment_material_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_equipment_material($data,$id)
{
	$where 	= 	" equipment_material_sl  = '$id'"; 
	$result = $this->db->update('kiv_equipment_material_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_equipment_material($id,$data)
{
	$where 	= " equipment_material_sl  = '$id'"; 
	$result = $this->db->update('kiv_equipment_material_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Equipment Material Master	  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                        Propulsionshaft_material	
//------------------------------------------------------------------------------------------------------------------------------------
// List Propulsion shaft material
// 13-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_propulsionshaft_material()
{
	$this->db->select('propulsionshaft_material_sl');
	$this->db->select('propulsionshaft_material_name');
	$this->db->select('propulsionshaft_material_mal_name');
	$this->db->select('propulsionshaft_material_code');
	$this->db->select('propulsionshaft_material_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_propulsionshaft_material_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('propulsionshaft_material_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_propulsionshaft_material($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_propulsionshaft_material_master');
	$this->db->where('propulsionshaft_material_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}    

function check_duplication_propulsionshaft_material_insert($name,$code)     
{ 
	$where=	"(propulsionshaft_material_name ='$name' OR propulsionshaft_material_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_propulsionshaft_material_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_propulsionshaft_material_edit($name,$code,$id)     
{ 
	$where=	"(propulsionshaft_material_name ='$name' OR propulsionshaft_material_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_propulsionshaft_material_master');
	$this->db->where($where);
	$this->db->where('propulsionshaft_material_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_propulsionshaft_material_status($data,$propulsionshaft_material_sl)
{
	$where 		= 	"propulsionshaft_material_sl  = '$propulsionshaft_material_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_propulsionshaft_material_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_propulsionshaft_material($data,$id)
{
	$where 	= 	" propulsionshaft_material_sl  = '$id'"; 
	$result = $this->db->update('kiv_propulsionshaft_material_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_propulsionshaft_material($id,$data)
{
	$where 	= " propulsionshaft_material_sl  = '$id'"; 
	$result = $this->db->update('kiv_propulsionshaft_material_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Propulsion shaft material  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                        Garbage	
//------------------------------------------------------------------------------------------------------------------------------------
// List Garbage
// 14-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_garbage()
{
	$this->db->select('garbage_sl');
	$this->db->select('garbage_name');
	$this->db->select('garbage_mal_name');
	$this->db->select('garbage_code');
	$this->db->select('garbage_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_garbage_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('garbage_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_garbage($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_garbage_master');
	$this->db->where('garbage_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}     

function check_duplication_garbage_insert($name,$code)     
{ 
	$where=	"(garbage_name ='$name' OR garbage_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_garbage_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_garbage_edit($name,$code,$id)     
{ 
	$where=	"(garbage_name ='$name' OR garbage_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_garbage_master');
	$this->db->where($where);
	$this->db->where('garbage_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_garbage_status($data,$garbage_sl)
{
	$where 		= 	"garbage_sl  = '$garbage_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_garbage_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_garbage($data,$id)
{
	$where 	= 	" garbage_sl  = '$id'"; 
	$result = $this->db->update('kiv_garbage_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_garbage($id,$data)
{
	$where 	= " garbage_sl  = '$id'"; 
	$result = $this->db->update('kiv_garbage_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Garbage  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                        Bulk Head Placement	
//------------------------------------------------------------------------------------------------------------------------------------
// List Bulk Head Placement
// 16-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_bulkhead_placement()
{
	$this->db->select('bulkhead_placement_sl');
	$this->db->select('bulkhead_placement_name');
	$this->db->select('bulkhead_placement_mal_name');
	$this->db->select('bulkhead_placement_code');
	$this->db->select('bulkhead_placement_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_bulkhead_placement_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('bulkhead_placement_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_bulkhead_placement($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_bulkhead_placement_master');
	$this->db->where('bulkhead_placement_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}       

function check_duplication_bulkhead_placement_insert($name,$code)     
{ 
	$where=	"(bulkhead_placement_name ='$name' OR bulkhead_placement_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_bulkhead_placement_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_bulkhead_placement_edit($name,$code,$id)     
{ 
	$where=	"(bulkhead_placement_name ='$name' OR bulkhead_placement_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_bulkhead_placement_master');
	$this->db->where($where);
	$this->db->where('bulkhead_placement_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for edit case 14-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_bulkhead_placement_status($data,$bulkhead_placement_sl)
{
	$where 		= 	"bulkhead_placement_sl  = '$bulkhead_placement_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_bulkhead_placement_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_bulkhead_placement($data,$id)
{
	$where 	= 	" bulkhead_placement_sl  = '$id'"; 
	$result = $this->db->update('kiv_bulkhead_placement_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_bulkhead_placement($id,$data)
{
	$where 	= " bulkhead_placement_sl  = '$id'"; 
	$result = $this->db->update('kiv_bulkhead_placement_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Bulk Head Placement  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                        Search Light Size	
//------------------------------------------------------------------------------------------------------------------------------------
// List Search Light Size
// 16-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_searchlight_size()
{
	$this->db->select('searchlight_size_sl');
	$this->db->select('searchlight_size_name');
	$this->db->select('searchlight_size_mal_name');
	$this->db->select('searchlight_size_code');
	$this->db->select('searchlight_size_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_searchlight_size_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('searchlight_size_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_searchlight_size($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_searchlight_size_master');
	$this->db->where('searchlight_size_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}        

function check_duplication_searchlight_size_insert($name,$code)     
{ 
	$where=	"(searchlight_size_name ='$name' OR searchlight_size_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_searchlight_size_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_searchlight_size_edit($name,$code,$id)     
{ 
	$where=	"(searchlight_size_name ='$name' OR searchlight_size_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_searchlight_size_master');
	$this->db->where($where);
	$this->db->where('searchlight_size_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_searchlight_size_status($data,$searchlight_size_sl)
{
	$where 		= 	"searchlight_size_sl  = '$searchlight_size_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_searchlight_size_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_searchlight_size($data,$id)
{
	$where 	= 	" searchlight_size_sl  = '$id'"; 
	$result = $this->db->update('kiv_searchlight_size_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_searchlight_size($id,$data)
{
	$where 	= " searchlight_size_sl  = '$id'"; 
	$result = $this->db->update('kiv_searchlight_size_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Search Light Size  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                        Portable Fire Extinguisher	
//------------------------------------------------------------------------------------------------------------------------------------
// List Portable Fire Extinguisher
// 16-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_portable_fire_extinguisher()
{
	$this->db->select('portable_fire_extinguisher_sl');
	$this->db->select('portable_fire_extinguisher_name');
	$this->db->select('portable_fire_extinguisher_mal_name');
	$this->db->select('portable_fire_extinguisher_code');
	$this->db->select('portable_fire_extinguisher_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_portable_fire_extinguisher_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('portable_fire_extinguisher_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_portable_fire_extinguisher($name)     
{ 
	$this->db->select('*');
	$this->db->from('kiv_portable_fire_extinguisher_master');
	$this->db->where('portable_fire_extinguisher_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}         

function check_duplication_portable_fire_extinguisher_insert($name,$code)     
{ 
	$where=	"(portable_fire_extinguisher_name ='$name' OR portable_fire_extinguisher_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_portable_fire_extinguisher_master');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_portable_fire_extinguisher_edit($name,$code,$id)     
{ 
	$where=	"(portable_fire_extinguisher_name ='$name' OR portable_fire_extinguisher_code='$code')";    	
	$this->db->select('*');
	$this->db->from('kiv_portable_fire_extinguisher_master');
	$this->db->where($where);
	$this->db->where('portable_fire_extinguisher_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_portable_fire_extinguisher_status($data,$portable_fire_extinguisher_sl)
{
	$where 		= 	"portable_fire_extinguisher_sl  = '$portable_fire_extinguisher_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_portable_fire_extinguisher_master', $data, $where);
	$rs		=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_portable_fire_extinguisher($data,$id)
{
	$where 	= 	" portable_fire_extinguisher_sl  = '$id'"; 
	$result = $this->db->update('kiv_portable_fire_extinguisher_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_portable_fire_extinguisher($id,$data)
{
	$where 	= " portable_fire_extinguisher_sl  = '$id'"; 
	$result = $this->db->update('kiv_portable_fire_extinguisher_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Portable Fire Extinguisher  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                        Master Tables	
//------------------------------------------------------------------------------------------------------------------------------------
// List Master Tables
// 18-06-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_mastertable()
{
	$this->db->select('mastertable_sl');
	$this->db->select('mastertable_name');
	$this->db->select('mastertable_mal_name');
	$this->db->select('mastertable_records');
	$this->db->select('mastertable_status');
	$this->db->select('delete_status');
	$this->db->from('master_tables');
	$this->db->where('delete_status', 0);
	$this->db->order_by('mastertable_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function check_duplication_mastertable($name)     
{ 
	$this->db->select('*');
	$this->db->from('master_tables');
	$this->db->where('mastertable_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}           

function check_duplication_mastertable_insert($name,$des_name)     
{ 
	$where=	"(mastertable_name ='$name' OR mastertable_mal_name='$des_name')";    	
	$this->db->select('*');
	$this->db->from('master_tables');
	$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
/*New function included for insertion case 22-06-2018*/ 
//-------------------------------------------------------------------------------------------------------------------------------------    
function check_duplication_mastertable_edit($name,$mal_name,$id)     
{ 
	$where=	"(mastertable_name ='$name' OR mastertable_mal_name='$mal_name')";    	
	$this->db->select('*');
	$this->db->from('master_tables');
	$this->db->where($where);
	$this->db->where('mastertable_sl !=', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_mastertable_status($data,$mastertable_sl)
{
	$where 		= 	"mastertable_sl  = '$mastertable_sl'"; 
	$updquery 	= 	$this->db->update_string('master_tables', $data, $where);
	$rs			=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_mastertable($data,$id)
{
	$where 	= 	" mastertable_sl  = '$id'"; 
	$result = $this->db->update('master_tables', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_mastertable($id,$data)
{
	$where 	= " mastertable_sl  = '$id'"; 
	$result = $this->db->update('master_tables', $data, $where);
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_specific_table($table_name)     
{ 
	$this->db->select('*');
	$this->db->from($table_name);
	//$this->db->where('mastertable_name', $name);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  
//-------------------------------------------------------------------------------------------------------------------------------------    
function show_table()     
{ 
	$query	= $this->db->query("SELECT t.TABLE_NAME AS myTables FROM INFORMATION_SCHEMA.TABLES AS t WHERE t.TABLE_SCHEMA = 'kiv_port' AND t.TABLE_NAME LIKE 'kiv_%'");
	$result = $query->result_array();
	return $result;	
}  
//------------------------------------------------------------------------------------------------------------------------------------- 
//To count the number of rows in a master table (Masterhome) 20-06-2018
function count_table_raws($tableName)     
{ 
	$this->db->select('mastertable_records');
	$this->db->from('master_tables');
	$this->db->where('mastertable_name', $tableName);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}  

//-------------------------------------------------------------------------------------------------------------------------------------    
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Master Tables  
//-------------------------------------------------------------------------------------------------------------------------------------
//                                                        Dynamic Form	
//--------------------------------------------------------------------------------------------------------------------------------------
// List Label Name
// 11-07-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_dynamic_form()
{
	$this->db->select('kiv_dynamic_field_master.dynamic_field_sl');
	$this->db->select('kiv_dynamic_field_master.vesseltype_id');
	$this->db->select('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->select('kiv_dynamic_field_master.length_over_deck');
	$this->db->select('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->select('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->select('kiv_dynamic_field_master.form_id');
	$this->db->select('kiv_dynamic_field_master.heading_id');
	$this->db->select('kiv_dynamic_field_master.label_id');
	$this->db->select('kiv_dynamic_field_master.value_id');
	$this->db->select('kiv_dynamic_field_master.label_value_status');
	$this->db->select('kiv_dynamic_field_master.status');
	$this->db->select('kiv_dynamic_field_master.delete_status');
	$this->db->select('kiv_dynamic_field_master.start_date');
	$this->db->select('kiv_dynamic_field_master.end_date');
	$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_hullmaterial_master.hullmaterial_name');
	$this->db->select('kiv_inboard_outboard_master.inboard_outboard_name');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->select('kiv_heading_master.heading_name');
	$this->db->select('kiv_label_master.label_name');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('kiv_dynamic_field_master.delete_status', 0);
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_dynamic_field_master.vesseltype_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_dynamic_field_master.vessel_subtype_id','left');
	$this->db->join('kiv_hullmaterial_master','kiv_hullmaterial_master.hullmaterial_sl=kiv_dynamic_field_master.hullmaterial_id','left');
	$this->db->join('kiv_inboard_outboard_master','kiv_inboard_outboard_master.inboard_outboard_sl=kiv_dynamic_field_master.engine_inboard_outboard','left');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_dynamic_field_master.form_id');
	$this->db->join('kiv_heading_master','kiv_heading_master.heading_sl=kiv_dynamic_field_master.heading_id');
	$this->db->join('kiv_label_master','kiv_label_master.label_sl=kiv_dynamic_field_master.label_id','left');
	$this->db->group_by('kiv_dynamic_field_master.vesseltype_id');
	$this->db->group_by('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->group_by('kiv_dynamic_field_master.length_over_deck');
	$this->db->group_by('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->group_by('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->group_by('kiv_dynamic_field_master.form_id');
	$this->db->group_by('kiv_dynamic_field_master.heading_id');
	$this->db->group_by('kiv_dynamic_field_master.start_date');
	//$where="'join kiv_measurement_master','kiv_measurement_master.measurement_sl=kiv_equipment_master.equipment_measurement'";
	//$this->db->or_where($where);
	// $this->db->order_by('kiv_dynamic_field_master.heading_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------
function get_edit_dynamic_form($id,$vesseltype_id,$vess_sub,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$start_date,$end_date)
{ 
	//echo "h=".$id."v=".$vesseltype_id."l=".$length_over_deck."hull=".$hullmaterial_id."e=".$engine_inboard_outboard."f=".$form_id;exit;
	$this->db->select('kiv_dynamic_field_master.dynamic_field_sl');
	$this->db->select('kiv_dynamic_field_master.vesseltype_id');
	$this->db->select('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->select('kiv_dynamic_field_master.length_over_deck');
	$this->db->select('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->select('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->select('kiv_dynamic_field_master.form_id');
	$this->db->select('kiv_dynamic_field_master.heading_id');
	$this->db->select('kiv_dynamic_field_master.label_id');
	$this->db->select('kiv_dynamic_field_master.value_id');
	$this->db->select('kiv_dynamic_field_master.label_value_status');
	$this->db->select('kiv_dynamic_field_master.status');
	$this->db->select('kiv_dynamic_field_master.delete_status');
	$this->db->select('kiv_dynamic_field_master.start_date');
	$this->db->select('kiv_dynamic_field_master.end_date');
	$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_hullmaterial_master.hullmaterial_name');
	$this->db->select('kiv_inboard_outboard_master.inboard_outboard_name');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->select('kiv_heading_master.heading_name');
	$this->db->select('kiv_label_master.label_name');
	$this->db->select('kiv_label_master.table_name');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('kiv_dynamic_field_master.vesseltype_id', $vesseltype_id);
	$this->db->where('kiv_dynamic_field_master.vessel_subtype_id', $vess_sub);
	$this->db->where('kiv_dynamic_field_master.length_over_deck', $length_over_deck);
	$this->db->where('kiv_dynamic_field_master.hullmaterial_id', $hullmaterial_id);
	$this->db->where('kiv_dynamic_field_master.engine_inboard_outboard', $engine_inboard_outboard);
	$this->db->where('kiv_dynamic_field_master.form_id', $form_id);
	$this->db->where('kiv_dynamic_field_master.heading_id', $id);
	$this->db->where('kiv_dynamic_field_master.delete_status', 0);
	$this->db->where('kiv_dynamic_field_master.start_date', $start_date);
	$this->db->where('kiv_dynamic_field_master.end_date', $end_date);
	//$this->db->where('kiv_dynamic_field_master.dynamic_field_sl', $id);
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_dynamic_field_master.vesseltype_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_dynamic_field_master.vessel_subtype_id','left');
	$this->db->join('kiv_hullmaterial_master','kiv_hullmaterial_master.hullmaterial_sl=kiv_dynamic_field_master.hullmaterial_id','left');
	$this->db->join('kiv_inboard_outboard_master','kiv_inboard_outboard_master.inboard_outboard_sl=kiv_dynamic_field_master.engine_inboard_outboard','left');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_dynamic_field_master.form_id');
	$this->db->join('kiv_heading_master','kiv_heading_master.heading_sl=kiv_dynamic_field_master.heading_id');
	$this->db->join('kiv_label_master','kiv_label_master.label_sl=kiv_dynamic_field_master.label_id','left');
	//$where="'join kiv_measurement_master','kiv_measurement_master.measurement_sl=kiv_equipment_master.equipment_measurement'";
	//$this->db->or_where($where);
	//$this->db->order_by('kiv_dynamic_field_master.heading_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*--------------------------------------------------------------------------------------------------------------------------------------*/
/* View Dynamic Form List 1-grouped with out include Form id,Heading. 22-06-2019*/
function get_view_dynamicForm_list_byvessel()
{
	$this->db->select('kiv_dynamic_field_master.dynamic_field_sl');
	$this->db->select('kiv_dynamic_field_master.vesseltype_id');
	$this->db->select('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->select('kiv_dynamic_field_master.length_over_deck');
	$this->db->select('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->select('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->select('kiv_dynamic_field_master.form_id');
	$this->db->select('kiv_dynamic_field_master.heading_id');
	$this->db->select('kiv_dynamic_field_master.label_id');
	$this->db->select('kiv_dynamic_field_master.value_id');
	$this->db->select('kiv_dynamic_field_master.label_value_status');
	$this->db->select('kiv_dynamic_field_master.status');
	$this->db->select('kiv_dynamic_field_master.delete_status');
	$this->db->select('kiv_dynamic_field_master.start_date');
	$this->db->select('kiv_dynamic_field_master.end_date');
	$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_hullmaterial_master.hullmaterial_name');
	$this->db->select('kiv_inboard_outboard_master.inboard_outboard_name');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->select('kiv_heading_master.heading_name');
	$this->db->select('kiv_label_master.label_name');
	$this->db->select('kiv_label_master.table_name');
	$this->db->from('kiv_dynamic_field_master');
	//$this->db->where('kiv_dynamic_field_master.form_id', $form_id);
	//$this->db->where('kiv_dynamic_field_master.heading_id', $head_id);
	$this->db->where('kiv_dynamic_field_master.delete_status', 0);
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_dynamic_field_master.vesseltype_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_dynamic_field_master.vessel_subtype_id','left');
	$this->db->join('kiv_hullmaterial_master','kiv_hullmaterial_master.hullmaterial_sl=kiv_dynamic_field_master.hullmaterial_id','left');
	$this->db->join('kiv_inboard_outboard_master','kiv_inboard_outboard_master.inboard_outboard_sl=kiv_dynamic_field_master.engine_inboard_outboard','left');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_dynamic_field_master.form_id');
	$this->db->join('kiv_heading_master','kiv_heading_master.heading_sl=kiv_dynamic_field_master.heading_id');
	$this->db->join('kiv_label_master','kiv_label_master.label_sl=kiv_dynamic_field_master.label_id','left');
	$this->db->group_by('kiv_dynamic_field_master.vesseltype_id');
	$this->db->group_by('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->group_by('kiv_dynamic_field_master.length_over_deck');
	$this->db->group_by('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->group_by('kiv_dynamic_field_master.engine_inboard_outboard');
	//$this->db->group_by('kiv_dynamic_field_master.form_id');
	//$this->db->group_by('kiv_dynamic_field_master.heading_id');
	$this->db->group_by('kiv_dynamic_field_master.start_date');
	//$this->db->order_by('kiv_dynamic_field_master.heading_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*------------------------------------------------------------------------------------------------------------------------------------*/
/* View Dynamic Form List 1-grouped with out including Heading id. 26-06-2019*/
function get_view_dynamicForm_detList_byvessel($vesseltype_id,$vess_sub,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$start_date,$end_date)
{
	$this->db->select('kiv_dynamic_field_master.dynamic_field_sl');
	$this->db->select('kiv_dynamic_field_master.vesseltype_id');
	$this->db->select('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->select('kiv_dynamic_field_master.length_over_deck');
	$this->db->select('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->select('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->select('kiv_dynamic_field_master.form_id');
	$this->db->select('kiv_dynamic_field_master.heading_id');
	$this->db->select('kiv_dynamic_field_master.label_id');
	$this->db->select('kiv_dynamic_field_master.value_id');
	$this->db->select('kiv_dynamic_field_master.label_value_status');
	$this->db->select('kiv_dynamic_field_master.status');
	$this->db->select('kiv_dynamic_field_master.delete_status');
	$this->db->select('kiv_dynamic_field_master.start_date');
	$this->db->select('kiv_dynamic_field_master.end_date');
	$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_hullmaterial_master.hullmaterial_name');
	$this->db->select('kiv_inboard_outboard_master.inboard_outboard_name');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->select('kiv_heading_master.heading_name');
	//$this->db->select('kiv_label_master.label_name');
	//$this->db->select('kiv_label_master.table_name');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('kiv_dynamic_field_master.vesseltype_id', $vesseltype_id);
	$this->db->where('kiv_dynamic_field_master.vessel_subtype_id', $vess_sub);
	$this->db->where('kiv_dynamic_field_master.length_over_deck', $length_over_deck);
	$this->db->where('kiv_dynamic_field_master.hullmaterial_id', $hullmaterial_id);
	$this->db->where('kiv_dynamic_field_master.engine_inboard_outboard', $engine_inboard_outboard);
	//$this->db->where('kiv_dynamic_field_master.form_id', $form_id);
	//$this->db->where('kiv_dynamic_field_master.heading_id', $id);
	$this->db->where('kiv_dynamic_field_master.delete_status', 0);
	$this->db->where('kiv_dynamic_field_master.start_date', $start_date);
	$this->db->where('kiv_dynamic_field_master.end_date', $end_date);
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_dynamic_field_master.vesseltype_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_dynamic_field_master.vessel_subtype_id','left');
	$this->db->join('kiv_hullmaterial_master','kiv_hullmaterial_master.hullmaterial_sl=kiv_dynamic_field_master.hullmaterial_id','left');
	$this->db->join('kiv_inboard_outboard_master','kiv_inboard_outboard_master.inboard_outboard_sl=kiv_dynamic_field_master.engine_inboard_outboard','left');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_dynamic_field_master.form_id');
	$this->db->join('kiv_heading_master','kiv_heading_master.heading_sl=kiv_dynamic_field_master.heading_id');
	$this->db->join('kiv_label_master','kiv_label_master.label_sl=kiv_dynamic_field_master.label_id','left');
	$this->db->group_by('kiv_dynamic_field_master.vesseltype_id');
	$this->db->group_by('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->group_by('kiv_dynamic_field_master.length_over_deck');
	$this->db->group_by('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->group_by('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->group_by('kiv_dynamic_field_master.form_id');
	//$this->db->group_by('kiv_dynamic_field_master.heading_id');
	$this->db->group_by('kiv_dynamic_field_master.start_date');
	//$this->db->order_by('kiv_dynamic_field_master.heading_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*------------------------------------------------------------------------------------------------------------------------------------*/
/* View Dynamic Form List -of a vessel having same vessel type,sub vessel type, hull material, inboard/outboard,form,date. 26-06-2019*/
function get_view_dynamicForm_detList_byvesselform($vesseltype_id,$vess_sub,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$start_date,$end_date)
{
	$this->db->select('kiv_dynamic_field_master.dynamic_field_sl');
	$this->db->select('kiv_dynamic_field_master.vesseltype_id');
	$this->db->select('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->select('kiv_dynamic_field_master.length_over_deck');
	$this->db->select('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->select('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->select('kiv_dynamic_field_master.form_id');
	$this->db->select('kiv_dynamic_field_master.heading_id');
	$this->db->select('kiv_dynamic_field_master.label_id');
	$this->db->select('kiv_dynamic_field_master.value_id');
	$this->db->select('kiv_dynamic_field_master.label_value_status');
	$this->db->select('kiv_dynamic_field_master.status');
	$this->db->select('kiv_dynamic_field_master.delete_status');
	$this->db->select('kiv_dynamic_field_master.start_date');
	$this->db->select('kiv_dynamic_field_master.end_date');
	$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_hullmaterial_master.hullmaterial_name');
	$this->db->select('kiv_inboard_outboard_master.inboard_outboard_name');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->select('kiv_heading_master.heading_name');
	//$this->db->select('kiv_label_master.label_name');
	//$this->db->select('kiv_label_master.table_name');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('kiv_dynamic_field_master.vesseltype_id', $vesseltype_id);
	$this->db->where('kiv_dynamic_field_master.vessel_subtype_id', $vess_sub);
	$this->db->where('kiv_dynamic_field_master.length_over_deck', $length_over_deck);
	$this->db->where('kiv_dynamic_field_master.hullmaterial_id', $hullmaterial_id);
	$this->db->where('kiv_dynamic_field_master.engine_inboard_outboard', $engine_inboard_outboard);
	$this->db->where('kiv_dynamic_field_master.form_id', $form_id);
	//$this->db->where('kiv_dynamic_field_master.heading_id', $id);
	$this->db->where('kiv_dynamic_field_master.delete_status', 0);
	$this->db->where('kiv_dynamic_field_master.start_date', $start_date);
	$this->db->where('kiv_dynamic_field_master.end_date', $end_date);
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_dynamic_field_master.vesseltype_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_dynamic_field_master.vessel_subtype_id','left');
	$this->db->join('kiv_hullmaterial_master','kiv_hullmaterial_master.hullmaterial_sl=kiv_dynamic_field_master.hullmaterial_id','left');
	$this->db->join('kiv_inboard_outboard_master','kiv_inboard_outboard_master.inboard_outboard_sl=kiv_dynamic_field_master.engine_inboard_outboard','left');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_dynamic_field_master.form_id');
	$this->db->join('kiv_heading_master','kiv_heading_master.heading_sl=kiv_dynamic_field_master.heading_id');
	$this->db->join('kiv_label_master','kiv_label_master.label_sl=kiv_dynamic_field_master.label_id','left');
	$this->db->group_by('kiv_dynamic_field_master.vesseltype_id');
	$this->db->group_by('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->group_by('kiv_dynamic_field_master.length_over_deck');
	$this->db->group_by('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->group_by('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->group_by('kiv_dynamic_field_master.form_id');
	$this->db->group_by('kiv_dynamic_field_master.heading_id');
	$this->db->group_by('kiv_dynamic_field_master.start_date');
	//$this->db->order_by('kiv_dynamic_field_master.heading_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*------------------------------------------------------------------------------------------------------------------------------------*/
/*Get form base list of heading, to display in the dynamic page (02-07-2019)*/
/*------------------------------------------------------------------------------------------------------------------------------------*/
function get_dynamicForm_headingList($vesseltype_id,$vess_sub,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$start_date,$end_date)
{
	$this->db->select('kiv_dynamic_field_master.dynamic_field_sl');
	$this->db->select('kiv_dynamic_field_master.vesseltype_id');
	$this->db->select('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->select('kiv_dynamic_field_master.length_over_deck');
	$this->db->select('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->select('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->select('kiv_dynamic_field_master.form_id');
	$this->db->select('kiv_dynamic_field_master.heading_id');
	$this->db->select('kiv_dynamic_field_master.label_id');
	$this->db->select('kiv_dynamic_field_master.value_id');
	$this->db->select('kiv_dynamic_field_master.label_value_status');
	$this->db->select('kiv_dynamic_field_master.status');
	$this->db->select('kiv_dynamic_field_master.delete_status');
	$this->db->select('kiv_dynamic_field_master.start_date');
	$this->db->select('kiv_dynamic_field_master.end_date');
	$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_hullmaterial_master.hullmaterial_name');
	$this->db->select('kiv_inboard_outboard_master.inboard_outboard_name');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->select('kiv_heading_master.heading_name');
	//$this->db->select('kiv_label_master.label_name');
	//$this->db->select('kiv_label_master.table_name');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('kiv_dynamic_field_master.vesseltype_id', $vesseltype_id);
	$this->db->where('kiv_dynamic_field_master.vessel_subtype_id', $vess_sub);
	$this->db->where('kiv_dynamic_field_master.length_over_deck', $length_over_deck);
	$this->db->where('kiv_dynamic_field_master.hullmaterial_id', $hullmaterial_id);
	$this->db->where('kiv_dynamic_field_master.engine_inboard_outboard', $engine_inboard_outboard);
	$this->db->where('kiv_dynamic_field_master.form_id', $form_id);
	//$this->db->where('kiv_dynamic_field_master.heading_id', $id);
	$this->db->where('kiv_dynamic_field_master.delete_status', 0);
	$this->db->where('kiv_dynamic_field_master.start_date', $start_date);
	$this->db->where('kiv_dynamic_field_master.end_date', $end_date);
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_dynamic_field_master.vesseltype_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_dynamic_field_master.vessel_subtype_id','left');
	$this->db->join('kiv_hullmaterial_master','kiv_hullmaterial_master.hullmaterial_sl=kiv_dynamic_field_master.hullmaterial_id','left');
	$this->db->join('kiv_inboard_outboard_master','kiv_inboard_outboard_master.inboard_outboard_sl=kiv_dynamic_field_master.engine_inboard_outboard','left');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_dynamic_field_master.form_id');
	$this->db->join('kiv_heading_master','kiv_heading_master.heading_sl=kiv_dynamic_field_master.heading_id');
	$this->db->join('kiv_label_master','kiv_label_master.label_sl=kiv_dynamic_field_master.label_id','left');
	$this->db->group_by('kiv_dynamic_field_master.vesseltype_id');
	$this->db->group_by('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->group_by('kiv_dynamic_field_master.length_over_deck');
	$this->db->group_by('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->group_by('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->group_by('kiv_dynamic_field_master.form_id');
	$this->db->group_by('kiv_dynamic_field_master.heading_id');
	$this->db->group_by('kiv_dynamic_field_master.start_date');
	//$this->db->order_by('kiv_dynamic_field_master.heading_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}

function get_dynamicForm_details($vesseltype_id,$vess_sub,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_id,$start_date,$end_date,$date1,$date2)
{
	$this->db->select('*');
	$this->db->from('kiv_dynamic_field_master1');
	$this->db->where('vesseltype_id', $vesseltype_id);
	$this->db->where('vessel_subtype_id', $vess_sub);
	$this->db->where('length_over_deck', $length_over_deck);
	$this->db->where('hullmaterial_id', $hullmaterial_id);
	$this->db->where('engine_inboard_outboard', $engine_inboard_outboard);
	$this->db->where('form_id', $form_id);
	$this->db->where('heading_id', $heading_id);
	$this->db->where('delete_status', 0);
	/*$this->db->where('start_date', $start_date);
	$this->db->where('end_date', $end_date);*/
	$this->db->where('start_date >', $date2);
	$this->db->where('end_date >', $start_date);
	$query = 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}

function get_dynamicForm_date($vesseltype_id,$vess_sub,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_id)
{
	$this->db->select('start_date,end_date');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('vesseltype_id', $vesseltype_id);
	$this->db->where('vessel_subtype_id', $vess_sub);
	$this->db->where('length_over_deck', $length_over_deck);
	$this->db->where('hullmaterial_id', $hullmaterial_id);
	$this->db->where('engine_inboard_outboard', $engine_inboard_outboard);
	$this->db->where('form_id', $form_id);
	$this->db->where('heading_id', $heading_id);
	$this->db->where('delete_status', 0);
	$query = 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*------------------------------------------------------------------------------------------------------------------------------------*/
// List Vessel Type
// 06-07-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
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
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
// List Vessel sub type
// 06-07-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_vesselsubtype_dynamic($type_id)
{
	$this->db->select('vessel_subtype_sl');
	$this->db->select('vessel_subtype_name');
	$this->db->from('kiv_vessel_subtype_master');
	$this->db->where('vessel_subtype_vesseltype_id', $type_id);
	$this->db->where('delete_status', 0);
	$this->db->order_by('vessel_subtype_vesseltype_id',$type_id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
// Select Hull material name
// 11-07-2019
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_hullmaterial_name($hullSl)
{
	//$this->db->select('hullmaterial_sl');
	$this->db->select('hullmaterial_name');
	$this->db->from('kiv_hullmaterial_master');
	$this->db->where('hullmaterial_sl', $hullSl);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
	}	
//------------------------------------------------------------------------------------------------------------------------------------- 
// Select Engine Inboard Outboard name
// 11-07-2019
//------------------------------------------------------------------------------------------------------------------------------------ 
function get_engineinout_name($engSl)
{
	//$this->db->select('inboard_outboard_sl');
	$this->db->select('inboard_outboard_name');
	$this->db->from('kiv_inboard_outboard_master');
	$this->db->where('inboard_outboard_sl', $engSl);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
// List Form Name
// 06-07-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_formname_dynamic()
{
$this->db->select('document_type_sl');
	$this->db->select('document_type_name');
	$this->db->from('kiv_document_type_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('document_type_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
// List Heading Name
// 06-07-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_heading_dynamic($form_id)
{
	$this->db->select('heading_sl');
	$this->db->select('heading_name');
	$this->db->from('kiv_heading_master');
	$this->db->where('form_id', $form_id);
	$this->db->where('delete_status', 0);
	$this->db->order_by('heading_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
// List Label Name
// 06-07-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_label_dynamic($form_id,$heading_id)
{
$this->db->select('label_sl');
	$this->db->select('label_name');
	$this->db->select('table_name');
	$this->db->from('kiv_label_master');
	$this->db->where('form_id', $form_id);
	$this->db->where('heading_id', $heading_id);
	$this->db->where('delete_status', 0);
	$this->db->order_by('label_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
//13-08-2018 Edit case	    
function get_label_dynamic_edit($form_id,$heading_id)
{
	$this->db->select('dynamic_field_sl');
	$this->db->select('vesseltype_id');
	$this->db->select('vessel_subtype_id');
	$this->db->select('hullmaterial_id');
	$this->db->select('label_id');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('form_id', $form_id);
	$this->db->where('heading_id', $heading_id);
	//$this->db->where('label_value_status !=', 0);
	$this->db->order_by('dynamic_field_sl','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//------------------------------------------------------------------------------------------------------------------------------------- 
//List table values to select box	    
function get_tablename_label_dynamic($table_name)
{
	$this->db->select('*');
	$this->db->from($table_name);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
// List Label Name
// 16-07-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_hullmaterial_dynamic()
{
	$this->db->select('hullmaterial_sl');
	$this->db->select('hullmaterial_name');
	$this->db->select('hullmaterial_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_hullmaterial_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('hullmaterial_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
// List Label Name
// 16-07-2018
//------------------------------------------------------------------------------------------------------------------------------------- 
function get_inboard_outboard_dynamic()
{
	$this->db->select('inboard_outboard_sl');
	$this->db->select('inboard_outboard_name');
	$this->db->select('inboard_outboard_status');
	$this->db->select('delete_status');
	$this->db->from('kiv_inboard_outboard_master');
	$this->db->where('delete_status', 0);
	$this->db->order_by('inboard_outboard_name','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------
function check_duplicationIns_dynamicPage($vesseltype_id,$vessel_subtype_id,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_sl)
{ 	
	$this->db->select('*');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('vesseltype_id',$vesseltype_id);
	$this->db->where('vessel_subtype_id',$vessel_subtype_id);	
	$this->db->where('length_over_deck',$length_over_deck);
	$this->db->where('hullmaterial_id',$hullmaterial_id);
	$this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
	$this->db->where('form_id',$form_id);
	$this->db->where('heading_id',$heading_sl);
	//$this->db->where('start_date >=', $start_date);
	$this->db->where('delete_status', 0);
	//$this->db->where($where);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------------    
/*
function check_duplicationIns_dynamicPage($vesseltype_id,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$heading_sl,$start_date)     
{ 	
	$where="  (start_date <= '$start_date' OR end_date >= '$start_date')";
	$this->db->select('*');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('vesseltype_id',$vesseltype_id);
	$this->db->where('length_over_deck',$length_over_deck);
	$this->db->where('hullmaterial_id',$hullmaterial_id);
	$this->db->where('engine_inboard_outboard',$engine_inboard_outboard);
	$this->db->where('form_id',$form_id);
	$this->db->where('heading_id',$heading_sl);
	$this->db->where('delete_status', 0);
	$this->db->where($where);
	/*$this->db->where('accommodation_start_time <=',$accommodation_start_time);
	$this->db->where('accommodation_end_time >=',$accommodation_start_time);

	$this->db->where('accommodation_start_time <=',$accommodation_end_time);
	$this->db->where('accommodation_end_time >=',$accommodation_end_time);

	$this->db->where('accommodation_start_date',$accommodation_start_date);
	$this->db->where('accommodation_end_date',$accommodation_end_date);*/
	/*$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	//return $result;
	return $query->num_rows();             
	//print_r($result);exit;
}
*/
//-------------------------------------------------------------------------------------------------------------------------------------    
function update_dynamic_form_status($data,$dynamic_field_sl)
{
	$where 		= 	"dynamic_field_sl  = '$dynamic_field_sl'"; 
	$updquery 	= 	$this->db->update_string('kiv_dynamic_field_master', $data, $where);
	$rs			=	$this->db->query($updquery);
	return $rs;	
} 
//-------------------------------------------------------------------------------------------------------------------------------------    
function delete_dynamic_form($data,$id,$form_id,$vesseltype_id,$vess_sub_id,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$start_date,$end_date)
{						  
	//$where 	= 	" dynamic_field_sl  = '$id'"; 
	$where 	= 	" heading_id  = '$id' AND form_id ='$form_id' AND vesseltype_id='$vesseltype_id' AND vessel_subtype_id='$vess_sub_id'  AND length_over_deck='$length_over_deck' AND hullmaterial_id='$hullmaterial_id' AND engine_inboard_outboard='$engine_inboard_outboard' AND start_date='$start_date' AND end_date='$end_date' ";
	$result = $this->db->update('kiv_dynamic_field_master', $data, $where);
	return 1;		
}
//-------------------------------------------------------------------------------------------------------------------------------------    
function edit_dynamic_form($id,$data)
{
	$where 	= " dynamic_field_sl  = '$id'"; 
	$result = $this->db->update('kiv_dynamic_field_master', $data, $where);
	return $result;
}	
//--------------------------------------------------------------------------------------------------------------------------------------
/* List form base sorted data ,to copy dynamic page */
function get_copyData_form_dynamic($form_id)
{
	$this->db->select('kiv_dynamic_field_master.dynamic_field_sl');
	$this->db->select('kiv_dynamic_field_master.vesseltype_id');
	$this->db->select('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->select('kiv_dynamic_field_master.length_over_deck');
	$this->db->select('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->select('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->select('kiv_dynamic_field_master.form_id');
	$this->db->select('kiv_dynamic_field_master.heading_id');
	$this->db->select('kiv_dynamic_field_master.label_id');
	$this->db->select('kiv_dynamic_field_master.value_id');
	$this->db->select('kiv_dynamic_field_master.label_value_status');
	$this->db->select('kiv_dynamic_field_master.status');
	$this->db->select('kiv_dynamic_field_master.delete_status');
	$this->db->select('kiv_dynamic_field_master.start_date');
	$this->db->select('kiv_dynamic_field_master.end_date');
	$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_hullmaterial_master.hullmaterial_name');
	$this->db->select('kiv_inboard_outboard_master.inboard_outboard_name');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->select('kiv_heading_master.heading_name');
	$this->db->select('kiv_label_master.label_name');
	$this->db->select('kiv_label_master.table_name');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('kiv_dynamic_field_master.form_id', $form_id);
	//$this->db->where('kiv_dynamic_field_master.heading_id', $head_id);
	$this->db->where('kiv_dynamic_field_master.delete_status', 0);
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_dynamic_field_master.vesseltype_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_dynamic_field_master.vessel_subtype_id','left');
	$this->db->join('kiv_hullmaterial_master','kiv_hullmaterial_master.hullmaterial_sl=kiv_dynamic_field_master.hullmaterial_id','left');
	$this->db->join('kiv_inboard_outboard_master','kiv_inboard_outboard_master.inboard_outboard_sl=kiv_dynamic_field_master.engine_inboard_outboard','left');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_dynamic_field_master.form_id');
	$this->db->join('kiv_heading_master','kiv_heading_master.heading_sl=kiv_dynamic_field_master.heading_id');
	$this->db->join('kiv_label_master','kiv_label_master.label_sl=kiv_dynamic_field_master.label_id','left');
	$this->db->group_by('kiv_dynamic_field_master.vesseltype_id');
	$this->db->group_by('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->group_by('kiv_dynamic_field_master.length_over_deck');
	$this->db->group_by('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->group_by('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->group_by('kiv_dynamic_field_master.form_id');
	//$this->db->group_by('kiv_dynamic_field_master.heading_id');
	$this->db->group_by('kiv_dynamic_field_master.start_date');
	//$this->db->order_by('kiv_dynamic_field_master.heading_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
/* List form and heading wise sorted base data ,to copy dynamic page */
function get_copyData_formHead_dynamic($form_id,$head_id)
{
	$this->db->select('kiv_dynamic_field_master.dynamic_field_sl');
	$this->db->select('kiv_dynamic_field_master.vesseltype_id');
	$this->db->select('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->select('kiv_dynamic_field_master.length_over_deck');
	$this->db->select('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->select('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->select('kiv_dynamic_field_master.form_id');
	$this->db->select('kiv_dynamic_field_master.heading_id');
	$this->db->select('kiv_dynamic_field_master.label_id');
	$this->db->select('kiv_dynamic_field_master.value_id');
	$this->db->select('kiv_dynamic_field_master.label_value_status');
	$this->db->select('kiv_dynamic_field_master.status');
	$this->db->select('kiv_dynamic_field_master.delete_status');
	$this->db->select('kiv_dynamic_field_master.start_date');
	$this->db->select('kiv_dynamic_field_master.end_date');
	$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_hullmaterial_master.hullmaterial_name');
	$this->db->select('kiv_inboard_outboard_master.inboard_outboard_name');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->select('kiv_heading_master.heading_name');
	$this->db->select('kiv_label_master.label_name');
	$this->db->select('kiv_label_master.table_name');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('kiv_dynamic_field_master.form_id', $form_id);
	$this->db->where('kiv_dynamic_field_master.heading_id', $head_id);
	$this->db->where('kiv_dynamic_field_master.delete_status', 0);
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_dynamic_field_master.vesseltype_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_dynamic_field_master.vessel_subtype_id','left');
	$this->db->join('kiv_hullmaterial_master','kiv_hullmaterial_master.hullmaterial_sl=kiv_dynamic_field_master.hullmaterial_id','left');
	$this->db->join('kiv_inboard_outboard_master','kiv_inboard_outboard_master.inboard_outboard_sl=kiv_dynamic_field_master.engine_inboard_outboard','left');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_dynamic_field_master.form_id');
	$this->db->join('kiv_heading_master','kiv_heading_master.heading_sl=kiv_dynamic_field_master.heading_id');
	$this->db->join('kiv_label_master','kiv_label_master.label_sl=kiv_dynamic_field_master.label_id','left');
	$this->db->group_by('kiv_dynamic_field_master.vesseltype_id');
	$this->db->group_by('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->group_by('kiv_dynamic_field_master.length_over_deck');
	$this->db->group_by('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->group_by('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->group_by('kiv_dynamic_field_master.form_id');
	$this->db->group_by('kiv_dynamic_field_master.heading_id');
	$this->db->group_by('kiv_dynamic_field_master.start_date');
	//$this->db->order_by('kiv_dynamic_field_master.heading_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
/* select all data ,to copy dynamic page */
function get_copyData_selectedForm($vesseltype_id,$vess_sub,$hullmaterial_id,$length_over_deck,$engine_inboard_outboard,$form_id,$start_date,$end_date)
{ 
	$this->db->select('dynamic_field_sl');
	/* $this->db->select('vesseltype_id');
	$this->db->select('vessel_subtype_id');
	$this->db->select('length_over_deck');
	$this->db->select('hullmaterial_id');
	$this->db->select('engine_inboard_outboard');*/
	$this->db->select('form_id');
	/*$this->db->select('heading_id');
	$this->db->select('label_id');
	$this->db->select('value_id');
	$this->db->select('label_value_status');
	$this->db->select('status');
	$this->db->select('delete_status');
	$this->db->select('start_date');
	$this->db->select('end_date');*/
	/*$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_hullmaterial_master.hullmaterial_name');
	$this->db->select('kiv_inboard_outboard_master.inboard_outboard_name');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->select('kiv_heading_master.heading_name');
	$this->db->select('kiv_label_master.label_name');
	$this->db->select('kiv_label_master.table_name');*/
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('vesseltype_id',$vesseltype_id);
	$this->db->where('vessel_subtype_id', $vess_sub);
	$this->db->where('length_over_deck', $length_over_deck);
	$this->db->where('hullmaterial_id', $hullmaterial_id);
	$this->db->where('engine_inboard_outboard', $engine_inboard_outboard);
	$this->db->where('form_id', $form_id);
	//$this->db->where('heading_id', $heading_id);
	$this->db->where('delete_status', 0);
	$this->db->where('start_date', $start_date);
	$this->db->where('end_date', $end_date);
	//$this->db->where('kiv_dynamic_field_master.dynamic_field_sl', $id);
	/*$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_dynamic_field_master.vesseltype_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_dynamic_field_master.vessel_subtype_id','left');
	$this->db->join('kiv_hullmaterial_master','kiv_hullmaterial_master.hullmaterial_sl=kiv_dynamic_field_master.hullmaterial_id','left');
	$this->db->join('kiv_inboard_outboard_master','kiv_inboard_outboard_master.inboard_outboard_sl=kiv_dynamic_field_master.engine_inboard_outboard','left');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_dynamic_field_master.form_id');
	$this->db->join('kiv_heading_master','kiv_heading_master.heading_sl=kiv_dynamic_field_master.heading_id');
	$this->db->join('kiv_label_master','kiv_label_master.label_sl=kiv_dynamic_field_master.label_id','left');*/
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();//print_r($result);exit;
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
function get_copyData_selectedFormList($dynamic_field_sl)
{ 
	$this->db->select('form_id');
	$this->db->select('heading_id');
	$this->db->select('label_id');
	$this->db->select('value_id');
	$this->db->select('label_value_status');
	$this->db->select('status');
	$this->db->select('delete_status');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('dynamic_field_sl', $dynamic_field_sl);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();//print_r($result);exit;
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
function checkDuplication_copiedData($vesseltype_name,$vessel_subtype_name,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$copied_form_id)//,$start_date,$end_date
{ 
	$this->db->select('dynamic_field_sl');
	$this->db->select('start_date');
	$this->db->select('end_date');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('vesseltype_id',$vesseltype_name);
	$this->db->where('vessel_subtype_id', $vessel_subtype_name);
	$this->db->where('length_over_deck', $length_over_deck);
	$this->db->where('hullmaterial_id', $hullmaterial_id);
	$this->db->where('engine_inboard_outboard', $engine_inboard_outboard);
	$this->db->where('form_id', $copied_form_id);
	//$this->db->where('heading_id', $heading_id);
	$this->db->where('delete_status', 0);
	//$this->db->where('start_date <=',$start_date);
	//$this->db->where('end_date', $end_date);
	//$this->db->where('start_date', $start_date);
	//$this->db->where('end_date', $end_date);
	//$this->db->where('kiv_dynamic_field_master.dynamic_field_sl', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();//print_r($result);exit;
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
function checkDuplication_copiedHeadingData($vesseltype_name,$vessel_subtype_name,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$copied_form_id,$copied_heading_id)//,$start_date,$end_date
{ 
	$this->db->select('dynamic_field_sl');
	$this->db->select('start_date');
	$this->db->select('end_date');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('vesseltype_id',$vesseltype_name);
	$this->db->where('vessel_subtype_id', $vessel_subtype_name);
	$this->db->where('length_over_deck', $length_over_deck);
	$this->db->where('hullmaterial_id', $hullmaterial_id);
	$this->db->where('engine_inboard_outboard', $engine_inboard_outboard);
	$this->db->where('form_id', $copied_form_id);
	$this->db->where('heading_id', $copied_heading_id);
	$this->db->where('delete_status', 0);
	//$this->db->where('start_date <=',$start_date);
	//$this->db->where('end_date', $end_date);
	//$this->db->where('start_date', $start_date);
	//$this->db->where('end_date', $end_date);
	//$this->db->where('kiv_dynamic_field_master.dynamic_field_sl', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();//print_r($result);exit;
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
function get_copyData_selectedForm_Array($vesseltype_id,$vess_sub,$hullmaterial_id,$length_over_deck,$engine_inboard_outboard,$form_id,$start_date,$end_date)
{ 
	$this->db->select('form_id');
	$this->db->select('heading_id');
	$this->db->select('label_id');
	$this->db->select('value_id');
	$this->db->select('label_value_status');
	$this->db->select('status');
	$this->db->select('delete_status');
	$this->db->select('start_date');
	$this->db->select('end_date');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('vesseltype_id',$vesseltype_id);
	$this->db->where('vessel_subtype_id', $vess_sub);
	$this->db->where('length_over_deck', $length_over_deck);
	$this->db->where('hullmaterial_id', $hullmaterial_id);
	$this->db->where('engine_inboard_outboard', $engine_inboard_outboard);
	$this->db->where('form_id', $form_id);
	//$this->db->where('heading_id', $heading_id);
	$this->db->where('delete_status', 0);
	$this->db->where('start_date', $start_date);
	$this->db->where('end_date', $end_date);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();//print_r($result);exit;
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
/* select all data ,to copy dynamic page based on heading and form */
function get_copyData_selectedFormHeading($vesseltype_id,$vess_sub,$hullmaterial_id,$length_over_deck,$engine_inboard_outboard,$form_id,$heading_id,$start_date,$end_date)
{ 
	$this->db->select('dynamic_field_sl');        
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('vesseltype_id',$vesseltype_id);
	$this->db->where('vessel_subtype_id', $vess_sub);
	$this->db->where('length_over_deck', $length_over_deck);
	$this->db->where('hullmaterial_id', $hullmaterial_id);
	$this->db->where('engine_inboard_outboard', $engine_inboard_outboard);
	$this->db->where('form_id', $form_id);
	$this->db->where('heading_id', $heading_id);
	$this->db->where('delete_status', 0);
	$this->db->where('start_date', $start_date);
	$this->db->where('end_date', $end_date);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();//print_r($result);exit;
	return $result;
}

function get_copyData_selectedFormHeadingList($dynamic_field_sl)
{ 	
	$this->db->select('form_id');
	$this->db->select('heading_id');
	$this->db->select('label_id');
	$this->db->select('value_id');
	$this->db->select('label_value_status');
	$this->db->select('status');
	$this->db->select('delete_status');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('dynamic_field_sl', $dynamic_field_sl);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*--------------------------------------------------------------------------------------------------------------------------------------*/
/* View Copy Dynamic Form List 1-grouped based on Form id. 29-09-2018*/
function get_view_copyDynamicForm_list()
{
	$this->db->select('kiv_dynamic_field_master.dynamic_field_sl');
	$this->db->select('kiv_dynamic_field_master.vesseltype_id');
	$this->db->select('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->select('kiv_dynamic_field_master.length_over_deck');
	$this->db->select('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->select('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->select('kiv_dynamic_field_master.form_id');
	$this->db->select('kiv_dynamic_field_master.heading_id');
	$this->db->select('kiv_dynamic_field_master.label_id');
	$this->db->select('kiv_dynamic_field_master.value_id');
	$this->db->select('kiv_dynamic_field_master.label_value_status');
	$this->db->select('kiv_dynamic_field_master.status');
	$this->db->select('kiv_dynamic_field_master.delete_status');
	$this->db->select('kiv_dynamic_field_master.start_date');
	$this->db->select('kiv_dynamic_field_master.end_date');
	$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_hullmaterial_master.hullmaterial_name');
	$this->db->select('kiv_inboard_outboard_master.inboard_outboard_name');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->select('kiv_heading_master.heading_name');
	$this->db->select('kiv_label_master.label_name');
	$this->db->select('kiv_label_master.table_name');
	$this->db->from('kiv_dynamic_field_master');
	//$this->db->where('kiv_dynamic_field_master.form_id', $form_id);
	//$this->db->where('kiv_dynamic_field_master.heading_id', $head_id);
	$this->db->where('kiv_dynamic_field_master.delete_status', 0);
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_dynamic_field_master.vesseltype_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_dynamic_field_master.vessel_subtype_id','left');
	$this->db->join('kiv_hullmaterial_master','kiv_hullmaterial_master.hullmaterial_sl=kiv_dynamic_field_master.hullmaterial_id','left');
	$this->db->join('kiv_inboard_outboard_master','kiv_inboard_outboard_master.inboard_outboard_sl=kiv_dynamic_field_master.engine_inboard_outboard','left');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_dynamic_field_master.form_id');
	$this->db->join('kiv_heading_master','kiv_heading_master.heading_sl=kiv_dynamic_field_master.heading_id');
	$this->db->join('kiv_label_master','kiv_label_master.label_sl=kiv_dynamic_field_master.label_id','left');
	$this->db->group_by('kiv_dynamic_field_master.vesseltype_id');
	$this->db->group_by('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->group_by('kiv_dynamic_field_master.length_over_deck');
	$this->db->group_by('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->group_by('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->group_by('kiv_dynamic_field_master.form_id');
	//$this->db->group_by('kiv_dynamic_field_master.heading_id');
	$this->db->group_by('kiv_dynamic_field_master.start_date');
	//$this->db->order_by('kiv_dynamic_field_master.heading_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*------------------------------------------------------------------------------------------------------------------------------------*/
function get_view_copyDynamicForm_detList($vesseltype_id,$vess_sub,$length_over_deck,$hullmaterial_id,$engine_inboard_outboard,$form_id,$start_date,$end_date)
{
	$this->db->select('kiv_dynamic_field_master.dynamic_field_sl');
	$this->db->select('kiv_dynamic_field_master.vesseltype_id');
	$this->db->select('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->select('kiv_dynamic_field_master.length_over_deck');
	$this->db->select('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->select('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->select('kiv_dynamic_field_master.form_id');
	$this->db->select('kiv_dynamic_field_master.heading_id');
	$this->db->select('kiv_dynamic_field_master.label_id');
	$this->db->select('kiv_dynamic_field_master.value_id');
	$this->db->select('kiv_dynamic_field_master.label_value_status');
	$this->db->select('kiv_dynamic_field_master.status');
	$this->db->select('kiv_dynamic_field_master.delete_status');
	$this->db->select('kiv_dynamic_field_master.start_date');
	$this->db->select('kiv_dynamic_field_master.end_date');
	$this->db->select('kiv_vesseltype_master.vesseltype_name');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_name');
	$this->db->select('kiv_hullmaterial_master.hullmaterial_name');
	$this->db->select('kiv_inboard_outboard_master.inboard_outboard_name');
	$this->db->select('kiv_document_type_master.document_type_name');
	$this->db->select('kiv_heading_master.heading_name');
	//$this->db->select('kiv_label_master.label_name');
	//$this->db->select('kiv_label_master.table_name');
	$this->db->from('kiv_dynamic_field_master');
	$this->db->where('kiv_dynamic_field_master.vesseltype_id', $vesseltype_id);
	$this->db->where('kiv_dynamic_field_master.vessel_subtype_id', $vess_sub);
	$this->db->where('kiv_dynamic_field_master.length_over_deck', $length_over_deck);
	$this->db->where('kiv_dynamic_field_master.hullmaterial_id', $hullmaterial_id);
	$this->db->where('kiv_dynamic_field_master.engine_inboard_outboard', $engine_inboard_outboard);
	$this->db->where('kiv_dynamic_field_master.form_id', $form_id);
	//$this->db->where('kiv_dynamic_field_master.heading_id', $id);
	$this->db->where('kiv_dynamic_field_master.delete_status', 0);
	$this->db->where('kiv_dynamic_field_master.start_date', $start_date);
	$this->db->where('kiv_dynamic_field_master.end_date', $end_date);
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_dynamic_field_master.vesseltype_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_dynamic_field_master.vessel_subtype_id','left');
	$this->db->join('kiv_hullmaterial_master','kiv_hullmaterial_master.hullmaterial_sl=kiv_dynamic_field_master.hullmaterial_id','left');
	$this->db->join('kiv_inboard_outboard_master','kiv_inboard_outboard_master.inboard_outboard_sl=kiv_dynamic_field_master.engine_inboard_outboard','left');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_dynamic_field_master.form_id');
	$this->db->join('kiv_heading_master','kiv_heading_master.heading_sl=kiv_dynamic_field_master.heading_id');
	$this->db->join('kiv_label_master','kiv_label_master.label_sl=kiv_dynamic_field_master.label_id','left');
	$this->db->group_by('kiv_dynamic_field_master.vesseltype_id');
	$this->db->group_by('kiv_dynamic_field_master.vessel_subtype_id');
	$this->db->group_by('kiv_dynamic_field_master.length_over_deck');
	$this->db->group_by('kiv_dynamic_field_master.hullmaterial_id');
	$this->db->group_by('kiv_dynamic_field_master.engine_inboard_outboard');
	$this->db->group_by('kiv_dynamic_field_master.form_id');
	$this->db->group_by('kiv_dynamic_field_master.heading_id');
	$this->db->group_by('kiv_dynamic_field_master.start_date');
	//$this->db->order_by('kiv_dynamic_field_master.heading_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------------------------
//                                                        End Dynamic Forms  
//-------------------------------------------------------------------------------------------------------------------------------------
/*																TARIFF															   */
/*-------------------------------------------------------------------------------------------------------------------------------------*/
function get_survey_type()     
{
	$this->db->select('*');
	$this->db->from('kiv_survey_master');
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
function get_tonnage_type()     
{
	$this->db->select('*');
	$this->db->from('kiv_tonnagetype_master');
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
function get_tariffDay_type()     
{
	$this->db->select('*');
	$this->db->from('kiv_tariffdaytype_master');
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
function get_tariffList()     
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
	$this->db->join('kiv_survey_master','kiv_survey_master.survey_sl=kiv_tariff_master.tariff_activity_id');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_tariff_master.tariff_form_id');
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_tariff_master.tariff_vessel_type_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_tariff_master.tariff_vessel_subtype_id','left');
	$this->db->join('kiv_tonnagetype_master','kiv_tonnagetype_master.tonnagetype_sl=kiv_tariff_master.tariff_tonnagetype_id');
	$this->db->join('kiv_tariffdaytype_master','kiv_tariffdaytype_master.tariffdaytype_sl=kiv_tariff_master.tariff_day_type');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
function get_tariffTable($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate) 
{
	$this->db->select('*');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$surveyName);
	$this->db->where('tariff_form_id',$formtypeName);
	$this->db->where('tariff_vessel_type_id',$vesseltype_name);
	$this->db->where('tariff_vessel_subtype_id',$vessel_subtype_name);
	$this->db->where('start_date',$startDate);
	$this->db->where('end_date',$endDate);
	$this->db->where('delete_status', 0);
	$this->db->group_by('tariff_from_ton');
	$this->db->group_by('tariff_to_ton');
	$this->db->group_by('tariff_from_day');
	$this->db->group_by('tariff_to_day');
	$this->db->group_by('tariff_amount');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
/*List for all vessel*/
function get_tariffTable_Novessel($surveyName,$formtypeName,$startDate,$endDate)     
{
	$this->db->select('*');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$surveyName);
	$this->db->where('tariff_form_id',$formtypeName);
	$this->db->where('start_date',$startDate);
	$this->db->where('end_date',$endDate);
	$this->db->where('delete_status', 0);		
	/*$this->db->group_by('tariff_activity_id');
	$this->db->group_by('tariff_form_id');
	$this->db->group_by('start_date');
	$this->db->group_by('end_date');*/
	$this->db->group_by('tariff_from_ton');
	$this->db->group_by('tariff_to_ton');
	$this->db->group_by('tariff_from_day');
	$this->db->group_by('tariff_to_day');
	$this->db->group_by('tariff_amount');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
/*List for all sub vessel*/
function get_tariffTable_Nosubvessel($surveyName,$formtypeName,$vesseltype_name,$startDate,$endDate)    
{
	$this->db->select('*');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$surveyName);
	$this->db->where('tariff_form_id',$formtypeName);
	$this->db->where('tariff_vessel_type_id',$vesseltype_name);
	$this->db->where('start_date',$startDate);
	$this->db->where('end_date',$endDate);
	$this->db->where('delete_status', 0);
	/*$this->db->group_by('tariff_activity_id');
	$this->db->group_by('tariff_form_id');
	$this->db->group_by('tariff_vessel_type_id');
	$this->db->group_by('start_date');
	$this->db->group_by('end_date');*/
	$this->db->group_by('tariff_from_ton');
	$this->db->group_by('tariff_to_ton');
	$this->db->group_by('tariff_from_day');
	$this->db->group_by('tariff_to_day');
	$this->db->group_by('tariff_amount');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
/*single vessel and sub vessel*/
function check_tariffMaster_duplication($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate,$tonnage_type,$from_ton,$to_ton,$day_type,$from_day,$to_day,$amount)     
{
	//$where=	"((tariff_from_ton <='$from_ton' OR tariff_from_ton <='$to_ton') AND ( tariff_to_ton >='$from_ton' OR tariff_to_ton >='$to_ton'))";
	//$where=	"(((tariff_from_ton <='$from_ton' OR tariff_from_ton <='$to_ton') AND ( tariff_to_ton >='$from_ton' OR tariff_to_ton >='$to_ton')) OR ((tariff_from_day <='$from_day' OR tariff_from_day <='$to_day') AND ( tariff_to_day >='$from_day' OR tariff_to_day >='$to_day')))";
	if(($tonnage_type==3)||($day_type==2))
	{
		$where=	"(((tariff_from_ton <='$from_ton' OR tariff_from_ton <='$to_ton') AND ( tariff_to_ton >='$from_ton' OR tariff_to_ton >='$to_ton')) AND ((tariff_from_day <='$from_day' OR tariff_from_day <='$to_day') AND ( tariff_to_day >='$from_day' OR tariff_to_day >='$to_day')))";
	}
	if(($tonnage_type==1)||($tonnage_type==2))
	{
		$where=	"((tariff_from_day <='$from_day' OR tariff_from_day <='$to_day') AND ( tariff_to_day >='$from_day' OR tariff_to_day >='$to_day'))";
	}
	if($day_type==1)
	{
		$where=	"((tariff_from_ton <='$from_ton' OR tariff_from_ton <='$to_ton') AND ( tariff_to_ton >='$from_ton' OR tariff_to_ton >='$to_ton'))";
	}
	$this->db->select('*');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$surveyName);
	$this->db->where('tariff_form_id',$formtypeName);
	$this->db->where('tariff_vessel_type_id',$vesseltype_name);
	$this->db->where('tariff_vessel_subtype_id',$vessel_subtype_name);
	$this->db->where('start_date',$startDate);
	$this->db->where('end_date',$endDate);
	$this->db->where('tariff_tonnagetype_id',$tonnage_type);
	/*$this->db->where('tariff_from_ton',$from_ton);
	$this->db->where('tariff_to_ton',$to_ton);*/
	/*$this->db->where('tariff_from_ton <=',$from_ton);
	$this->db->or_where('tariff_to_ton >=',$from_ton);
	$this->db->where('tariff_from_ton <=',$to_ton);
	$this->db->or_where('tariff_to_ton >=',$to_ton);*/
	/*$this->db->where('tariff_from_ton <=', $from_ton);
	$this->db->where('tariff_to_ton >=', $to_ton);*/
	//$this->db->where('tariff_per_ton',$per_ton);
	$this->db->where('tariff_day_type',$day_type);
	/*$this->db->where('tariff_from_day',$from_day);
	$this->db->where('tariff_to_day', $to_day);*/
	//$this->db->where('tariff_amount',$amount);
	//$this->db->where('tariff_min_amount',$min_amount);
	//$this->db->where('tariff_fine_amount', $fine_amount);
	$this->db->where($where);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
/*All vessels selected*/
function check_tariffMaster_duplication_noves($surveyName,$formtypeName,$startDate,$endDate,$tonnage_type,$from_ton,$to_ton,$day_type,$from_day,$to_day,$amount)     
	{
		//$where=	"(((tariff_from_ton <='$from_ton' OR tariff_from_ton <='$to_ton') AND ( tariff_to_ton >='$from_ton' OR tariff_to_ton >='$to_ton')) OR ((tariff_from_day <='$from_day' OR tariff_from_day <='$to_day') AND ( tariff_to_day >='$from_day' OR tariff_to_day >='$to_day')))";
	if(($tonnage_type==3)||($day_type==2))
	{
		$where=	"(((tariff_from_ton <='$from_ton' OR tariff_from_ton <='$to_ton') AND ( tariff_to_ton >='$from_ton' OR tariff_to_ton >='$to_ton')) AND ((tariff_from_day <='$from_day' OR tariff_from_day <='$to_day') AND ( tariff_to_day >='$from_day' OR tariff_to_day >='$to_day')))";
	}
	if(($tonnage_type==1)||($tonnage_type==2))
	{
		$where=	"((tariff_from_day <='$from_day' OR tariff_from_day <='$to_day') AND ( tariff_to_day >='$from_day' OR tariff_to_day >='$to_day'))";
	}
	if($day_type==1)
	{
		$where=	"((tariff_from_ton <='$from_ton' OR tariff_from_ton <='$to_ton') AND ( tariff_to_ton >='$from_ton' OR tariff_to_ton >='$to_ton'))";
	}
	$this->db->select('*');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$surveyName);
	$this->db->where('tariff_form_id',$formtypeName);
	//$this->db->where('tariff_vessel_type_id',$vesseltype_name);
	//$this->db->where('tariff_vessel_subtype_id',$vessel_subtype_name);
	$this->db->where('start_date',$startDate);
	$this->db->where('end_date',$endDate);
	$this->db->where('tariff_tonnagetype_id',$tonnage_type);		
	/*$this->db->where('tariff_from_ton',$from_ton);
	$this->db->where('tariff_to_ton',$to_ton);
	$this->db->where('tariff_from_ton <=', $from_ton);
	$this->db->where('tariff_to_ton >=', $to_ton);*/
	//$this->db->where('tariff_per_ton',$per_ton);
	$this->db->where('tariff_day_type',$day_type);
	/*$this->db->where('tariff_from_day',$from_day);
	$this->db->where('tariff_to_day', $to_day);*/
	//$this->db->where('tariff_amount',$amount);
	//$this->db->where('tariff_min_amount',$min_amount);
	//$this->db->where('tariff_fine_amount', $fine_amount);
	$this->db->where($where);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
/*Particular vessel, and all sub vessel under that particular vessel*/
function check_tariffMaster_duplication_nosubves($surveyName,$formtypeName,$vesseltype_name,$startDate,$endDate,$tonnage_type,$from_ton,$to_ton,$day_type,$from_day,$to_day,$amount)     
{
	//$where=	"(((tariff_from_ton <='$from_ton' OR tariff_from_ton <='$to_ton') AND ( tariff_to_ton >='$from_ton' OR tariff_to_ton >='$to_ton')) OR ((tariff_from_day <='$from_day' OR tariff_from_day <='$to_day') AND ( tariff_to_day >='$from_day' OR tariff_to_day >='$to_day')))";
	if(($tonnage_type==3)||($day_type==2))
	{
		$where=	"(((tariff_from_ton <='$from_ton' OR tariff_from_ton <='$to_ton') AND ( tariff_to_ton >='$from_ton' OR tariff_to_ton >='$to_ton')) AND ((tariff_from_day <='$from_day' OR tariff_from_day <='$to_day') AND ( tariff_to_day >='$from_day' OR tariff_to_day >='$to_day')))";
	}
	if(($tonnage_type==1)||($tonnage_type==2))
	{
		$where=	"((tariff_from_day <='$from_day' OR tariff_from_day <='$to_day') AND ( tariff_to_day >='$from_day' OR tariff_to_day >='$to_day'))";
	}
	if($day_type==1)
	{
		$where=	"((tariff_from_ton <='$from_ton' OR tariff_from_ton <='$to_ton') AND ( tariff_to_ton >='$from_ton' OR tariff_to_ton >='$to_ton'))";
	}
	$this->db->select('*');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$surveyName);
	$this->db->where('tariff_form_id',$formtypeName);
	$this->db->where('tariff_vessel_type_id',$vesseltype_name);
	//$this->db->where('tariff_vessel_subtype_id',$vessel_subtype_name);
	$this->db->where('start_date',$startDate);
	$this->db->where('end_date',$endDate);
	$this->db->where('tariff_tonnagetype_id',$tonnage_type);
	/*$this->db->where('tariff_from_ton',$from_ton);
	$this->db->where('tariff_to_ton',$to_ton);
	$this->db->where('tariff_from_ton <=', $from_ton);
	$this->db->where('tariff_to_ton >=', $to_ton);*/
	//$this->db->where('tariff_per_ton',$per_ton);
	$this->db->where('tariff_day_type',$day_type);
	/*$this->db->where('tariff_from_day',$from_day);
	$this->db->where('tariff_to_day', $to_day);*/
	//$this->db->where('tariff_amount',$amount);
	//$this->db->where('tariff_min_amount',$min_amount);
	//$this->db->where('tariff_fine_amount', $fine_amount);
	$this->db->where($where);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
/*select tonnage type and day type for single vessel and sub vessel*/
function get_tonnageTypeId($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$startDate,$endDate)     
{
	$this->db->select('tariff_tonnagetype_id');
	$this->db->select('tariff_day_type');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$surveyName);
	$this->db->where('tariff_form_id',$formtypeName);
	$this->db->where('tariff_vessel_type_id',$vesseltype_name);
	$this->db->where('tariff_vessel_subtype_id',$vessel_subtype_name);
	$this->db->where('start_date',$startDate);
	$this->db->where('end_date',$endDate);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
/*select tonnage type and day type for all vessel*/
function get_tonnageTypeId_noves($surveyName,$formtypeName,$startDate,$endDate)     
{
	$this->db->select('tariff_tonnagetype_id');
	$this->db->select('tariff_day_type');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$surveyName);
	$this->db->where('tariff_form_id',$formtypeName);
	$this->db->where('start_date',$startDate);
	$this->db->where('end_date',$endDate);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
/*select tonnage type and day type for  Particular vessel, and all sub vessel under that particular vessel*/
function get_tonnageTypeId_nosubves($surveyName,$formtypeName,$vesseltype_name,$startDate,$endDate)     
{
	$this->db->select('tariff_tonnagetype_id');
	$this->db->select('tariff_day_type');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$surveyName);
	$this->db->where('tariff_form_id',$formtypeName);
	$this->db->where('tariff_vessel_type_id',$vesseltype_name);
	$this->db->where('start_date',$startDate);
	$this->db->where('end_date',$endDate);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
} 
/*-------------------------------------------------------------------------------------------------------------------------------------*/
function get_vesseltypeId_tariff()
{
	$this->db->select('kiv_vesseltype_master.vesseltype_sl');
	$this->db->select('kiv_vessel_subtype_master.vessel_subtype_sl');
	$this->db->from('kiv_vesseltype_master');
	$this->db->where('kiv_vesseltype_master.delete_status', 0);
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_vesseltype_id=kiv_vesseltype_master.vesseltype_sl','left');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
function get_vesselsubtypeId_tariff($vid)
{
	$this->db->select('vessel_subtype_sl');
	$this->db->from('kiv_vessel_subtype_master');
	$this->db->where('vessel_subtype_vesseltype_id', $vid);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
function check_tariffMaster_Upd_duplication($tariff_activity_id,$tariff_form_id,$tariff_vessel_type_id,$tariff_vessel_subtype_id,$start_date,$end_date,$tariff_tonnagetype_id,$tariff_from_ton,$tariff_to_ton,$tariff_day_type,$tariff_from_day,$tariff_to_day,$id)     
{
	$this->db->select('*');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$tariff_activity_id);
	$this->db->where('tariff_form_id',$tariff_form_id);
	$this->db->where('tariff_vessel_type_id',$tariff_vessel_type_id);
	$this->db->where('tariff_vessel_subtype_id',$tariff_vessel_subtype_id);
	$this->db->where('start_date',$start_date);
	$this->db->where('end_date',$end_date);
	$this->db->where('tariff_tonnagetype_id',$tariff_tonnagetype_id);
	$this->db->where('tariff_from_ton',$tariff_from_ton);
	$this->db->where('tariff_to_ton',$tariff_to_ton);
	//$this->db->where('tariff_per_ton',$tariff_per_ton);
	$this->db->where('tariff_day_type',$tariff_day_type);
	$this->db->where('tariff_from_day',$tariff_from_day);
	$this->db->where('tariff_to_day', $tariff_to_day);
	$this->db->where('tariff_sl !=',$id);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
/*For particular vessel*/
function get_tariffMaster_Upd_data($tariff_activity_id,$tariff_form_id,$tariff_vessel_type_id,$tariff_vessel_subtype_id,$start_date,$end_date,$tariff_tonnagetype_id,$tariff_from_ton,$tariff_to_ton,$tariff_day_type,$tariff_from_day,$tariff_to_day,$amount,$min_amount,$fine_amount)     
{
	if(($tariff_tonnagetype_id==3)||($tariff_day_type==2))
	{
		$where=	"(((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') AND ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton')) AND ((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') AND ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day')))";
	}
	if(($tariff_tonnagetype_id==1)||($tariff_tonnagetype_id==2))
	{
		$where=	"((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') AND ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day'))";
	}
	if($tariff_day_type==1)
	{
		$where=	"((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') AND ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton'))";
	}   
	$this->db->select('*');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$tariff_activity_id);
	$this->db->where('tariff_form_id',$tariff_form_id);
	$this->db->where('tariff_vessel_type_id',$tariff_vessel_type_id);
	$this->db->where('tariff_vessel_subtype_id',$tariff_vessel_subtype_id);
	$this->db->where('start_date',$start_date);
	$this->db->where('end_date',$end_date);
	$this->db->where('tariff_tonnagetype_id',$tariff_tonnagetype_id);
	/*$this->db->where('tariff_from_ton',$tariff_from_ton);
	$this->db->where('tariff_to_ton',$tariff_to_ton);*/
	//$this->db->where('tariff_per_ton',$tariff_per_ton);
	$this->db->where('tariff_day_type',$tariff_day_type);
	/*$this->db->where('tariff_from_day',$tariff_from_day);
	$this->db->where('tariff_to_day', $tariff_to_day);*/
	//$this->db->where('tariff_sl !=',$id);
	$this->db->where('tariff_amount',$amount);
	$this->db->where('tariff_min_amount',$min_amount);
	$this->db->where('tariff_fine_amount', $fine_amount);
	$this->db->where($where);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}

/*For all vessels*/
function get_tariffMaster_noVesl_Upd_data($tariff_activity_id,$tariff_form_id,$start_date,$end_date,$tariff_tonnagetype_id,$tariff_from_ton,$tariff_to_ton,$tariff_day_type,$tariff_from_day,$tariff_to_day,$amount,$min_amount,$fine_amount)     
{
	if(($tariff_tonnagetype_id==3)||($tariff_day_type==2))
	{
		$where=	"(((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') AND ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton')) AND ((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') AND ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day')))";
	}
	if(($tariff_tonnagetype_id==1)||($tariff_tonnagetype_id==2))
	{
		$where=	"((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') AND ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day'))";
	}
	if($tariff_day_type==1)
	{
		$where=	"((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') AND ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton'))";
	}   
	$this->db->select('*');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$tariff_activity_id);
	$this->db->where('tariff_form_id',$tariff_form_id);
	//$this->db->where('tariff_vessel_type_id',$tariff_vessel_type_id);
	//$this->db->where('tariff_vessel_subtype_id',$tariff_vessel_subtype_id);
	$this->db->where('start_date',$start_date);
	$this->db->where('end_date',$end_date);
	$this->db->where('tariff_tonnagetype_id',$tariff_tonnagetype_id);
	/*$this->db->where('tariff_from_ton',$tariff_from_ton);
	$this->db->where('tariff_to_ton',$tariff_to_ton);*/
	//$this->db->where('tariff_per_ton',$tariff_per_ton);
	$this->db->where('tariff_day_type',$tariff_day_type);
	/*$this->db->where('tariff_from_day',$tariff_from_day);
	$this->db->where('tariff_to_day', $tariff_to_day);*/
	//$this->db->where('tariff_sl !=',$id);
	$this->db->where('tariff_amount',$amount);
	$this->db->where('tariff_min_amount',$min_amount);
	$this->db->where('tariff_fine_amount', $fine_amount);
	$this->db->where($where);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------*/
function get_tariffMaster_noVesl_Upd_data1($tariff_activity_id,$tariff_form_id,$start_date,$end_date,$tariff_tonnagetype_id,$tariff_from_ton,$tariff_to_ton,$tariff_day_type,$tariff_from_day,$tariff_to_day,$amount,$min_amount,$fine_amount)     
{
	if(($tariff_tonnagetype_id==3)||($tariff_day_type==2))
	{
		$where=	"(((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') OR ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton')) AND ((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') OR ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day')))";
	}
	if(($tariff_tonnagetype_id==1)||($tariff_tonnagetype_id==2))
	{
		$where=	"((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') AND ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day'))";
	}
	if($tariff_day_type==1)
	{
		$where=	"((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') AND ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton'))";
	}   
	$this->db->select('*');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$tariff_activity_id);
	$this->db->where('tariff_form_id',$tariff_form_id);
	//$this->db->where('tariff_vessel_type_id',$tariff_vessel_type_id);
	//$this->db->where('tariff_vessel_subtype_id',$tariff_vessel_subtype_id);
	$this->db->where('start_date',$start_date);
	$this->db->where('end_date',$end_date);
	$this->db->where('tariff_tonnagetype_id',$tariff_tonnagetype_id);
	/*$this->db->where('tariff_from_ton',$tariff_from_ton);
	$this->db->where('tariff_to_ton',$tariff_to_ton);*/
	//$this->db->where('tariff_per_ton',$tariff_per_ton);
	$this->db->where('tariff_day_type',$tariff_day_type);
	/*$this->db->where('tariff_from_day',$tariff_from_day);
	$this->db->where('tariff_to_day', $tariff_to_day);*/
	//$this->db->where('tariff_sl !=',$id);
	//$this->db->where('tariff_amount',$amount);
	//$this->db->where('tariff_min_amount',$min_amount);
	//$this->db->where('tariff_fine_amount', $fine_amount);
	$this->db->where($where);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*For all vessels*/   
/*For all sub vessels*/
function get_tariffMaster_noSubvesl_Upd_data($tariff_activity_id,$tariff_form_id,$tariff_vessel_type_id,$start_date,$end_date,$tariff_tonnagetype_id,$tariff_from_ton,$tariff_to_ton,$tariff_day_type,$tariff_from_day,$tariff_to_day,$amount,$min_amount,$fine_amount)     
{
	if(($tariff_tonnagetype_id==3)||($tariff_day_type==2))
	{
		$where=	"(((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') AND ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton')) AND ((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') AND ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day')))";
	}
	if(($tariff_tonnagetype_id==1)||($tariff_tonnagetype_id==2))
	{
		$where=	"((tariff_from_day <='$tariff_from_day' OR tariff_from_day <='$tariff_to_day') AND ( tariff_to_day >='$tariff_from_day' OR tariff_to_day >='$tariff_to_day'))";
	}
	if($tariff_day_type==1)
	{
		$where=	"((tariff_from_ton <='$tariff_from_ton' OR tariff_from_ton <='$tariff_to_ton') AND ( tariff_to_ton >='$tariff_from_ton' OR tariff_to_ton >='$tariff_to_ton'))";
	}   	
	$this->db->select('*');
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_activity_id',$tariff_activity_id);
	$this->db->where('tariff_form_id',$tariff_form_id);
	$this->db->where('tariff_vessel_type_id',$tariff_vessel_type_id);
	//$this->db->where('tariff_vessel_subtype_id',$tariff_vessel_subtype_id);
	$this->db->where('start_date',$start_date);
	$this->db->where('end_date',$end_date);
	$this->db->where('tariff_tonnagetype_id',$tariff_tonnagetype_id);
	/*$this->db->where('tariff_from_ton',$tariff_from_ton);
	$this->db->where('tariff_to_ton',$tariff_to_ton);*/
	//$this->db->where('tariff_per_ton',$tariff_per_ton);
	$this->db->where('tariff_day_type',$tariff_day_type);
	/*$this->db->where('tariff_from_day',$tariff_from_day);
	$this->db->where('tariff_to_day', $tariff_to_day);*/
	//$this->db->where('tariff_sl !=',$id);
	$this->db->where('tariff_amount',$amount);
	$this->db->where('tariff_min_amount',$min_amount);
	$this->db->where('tariff_fine_amount', $fine_amount);
	$this->db->where($where);
	$this->db->where('delete_status', 0);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*For all sub vessels*/   
/*-------------------------------------------------------------------------------------------------------------------------------------*/
function get_tariffMaster_list($id)     
{
	$this->db->select('tariff_activity_id');
	$this->db->select('tariff_form_id');
	$this->db->select('tariff_vessel_type_id');
	$this->db->select('tariff_vessel_subtype_id');
	$this->db->select('start_date');
	$this->db->select('end_date');
	$this->db->select('tariff_tonnagetype_id');		
	$this->db->select('tariff_day_type');	
	$this->db->from('kiv_tariff_master');
	$this->db->where('tariff_sl', $id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*--------------------------------------------------------------------------------------------------------------------------------------*/
/* View Tariff List 1. 15-10-2018*/
function get_view_tariffList()
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
	/*$this->db->group_by('kiv_tariff_master.vesseltype_id');
	$this->db->group_by('kiv_tariff_master.vessel_subtype_id');
	$this->db->group_by('kiv_tariff_master.length_over_deck');
	$this->db->group_by('kiv_tariff_master.hullmaterial_id');
	$this->db->group_by('kiv_tariff_master.engine_inboard_outboard');
	$this->db->group_by('kiv_tariff_master.form_id');
	$this->db->group_by('kiv_tariff_master.heading_id');
	$this->db->group_by('kiv_tariff_master.start_date');*/
	//$this->db->order_by('kiv_dynamic_field_master.heading_id','asc');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
/*Detailed view of Tariff*/
function get_tariffDetView($id)     
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
	$this->db->where('kiv_tariff_master.tariff_sl',$id);
	$this->db->join('kiv_survey_master','kiv_survey_master.survey_sl=kiv_tariff_master.tariff_activity_id');
	$this->db->join('kiv_document_type_master','kiv_document_type_master.document_type_sl=kiv_tariff_master.tariff_form_id');
	$this->db->join('kiv_vesseltype_master','kiv_vesseltype_master.vesseltype_sl=kiv_tariff_master.tariff_vessel_type_id');
	$this->db->join('kiv_vessel_subtype_master','kiv_vessel_subtype_master.vessel_subtype_sl=kiv_tariff_master.tariff_vessel_subtype_id','left');
	$this->db->join('kiv_tonnagetype_master','kiv_tonnagetype_master.tonnagetype_sl=kiv_tariff_master.tariff_tonnagetype_id');
	$this->db->join('kiv_tariffdaytype_master','kiv_tariffdaytype_master.tariffdaytype_sl=kiv_tariff_master.tariff_day_type');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
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
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
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
/*-------------------------------------------------------------------------------------------------------------------------------------*/
function get_tonnage_typeHelper($ton_type_id)     
{ 
	$this->db->select('tonnagetype_name');
	$this->db->from('kiv_tonnagetype_master');
	$this->db->where('tonnagetype_sl', $ton_type_id);
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;       
} 

function update_userlog($sess_usr_id,$login_time,$logout_time)
{
	$result=$this->db->query("update tbl_userlog set logout='$logout_time' where user_id=$sess_usr_id and login='$login_time'");
	return $result;
}

function get_module()     
{ 
	$this->db->select('*');
	$this->db->from('main_module');
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result; 
}

function get_menu($usertype)     
{ 
	$this->db->select('*');
	$this->db->from('main_module AS mm');
	$this->db->join('sub_module AS sm', 'sm.main_module_id= mm.main_module_id');
	//$this->db->where('main_module.user_type_id',$usertype);
	//$this->db->where(FIND_IN_SET($usertype, 'mm.user_type_id'));
	$this->db->where('sm.user_type_id',$usertype);
	//where find_in_set($usertype,)
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result; 
	//$query = $this->db
	/*->select("td.Date, GROUP_CONCAT(ts.student_name)")
	->from("tbl_students AS ts")
	->join("tbl_attendance AS ta","find_in_set(ts.st_id,ta.attendance)","left",false)
	->get();*/
}

function get_menu_pc($usertype,$mod)     
{ 
	$this->db->select('*');
	$this->db->from('main_module AS mm');
	$this->db->join('sub_module AS sm', 'sm.main_module_id= mm.main_module_id');
	//$this->db->where('main_module.user_type_id',$usertype);
	//$this->db->where(FIND_IN_SET($usertype, 'mm.user_type_id'));
	$this->db->where('sm.user_type_id',$usertype);
	$this->db->where('sm.main_module_id',$mod);
	//where find_in_set($usertype,)
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result; 
	//$query = $this->db
	/*->select("td.Date, GROUP_CONCAT(ts.student_name)")
	->from("tbl_students AS ts")
	->join("tbl_attendance AS ta","find_in_set(ts.st_id,ta.attendance)","left",false)
	->get();*/
}

function get_web_notfn_list()     
{ 
	$this->db->select('webnotification_sl');
	$this->db->select('webnotification_engtitle');
	$this->db->select('webnotification_maltitle');
	$this->db->select('webnotification_engcontent');
	$this->db->select('webnotification_malcontent');
	$this->db->select('webnotification_module');
	$this->db->select('webnotification_status');
	$this->db->select('webnotification_ctype');
	$this->db->from('tb_webnotification');
	$this->db->where('webnotification_ctype<>',2);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function check_duplication_notfn_insert($title_eng,$title_mal)     
{ 
	$this->db->select('webnotification_sl');
	$this->db->select('webnotification_engtitle');
	$this->db->select('webnotification_maltitle');
	$this->db->select('webnotification_engcontent');
	$this->db->select('webnotification_malcontent');
	$this->db->from('tb_webnotification');
	$this->db->where('webnotification_engtitle',$title_eng);
	$this->db->where('webnotification_maltitle',$title_mal);
	$this->db->where('webnotification_ctype<>',2);
	$this->db->where('webnotification_status',1);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function update_webnotfn_status($data,$webnotification_sl)
{
	$where 		= 	"webnotification_sl  = '$webnotification_sl'"; 
	$updquery 	= 	$this->db->update_string('tb_webnotification', $data, $where);
	$rs			=	$this->db->query($updquery);
	return $rs;	
} 

function edit_notfn($id,$data)
{
	$where 		= " webnotification_sl  = '$id' "; 
	$result 	= $this->db->update('tb_webnotification', $data, $where);
	return $result;
}

function get_notfn_det($id)     
{ 
	$this->db->select('*');
	$this->db->from('tb_webnotification');
	$this->db->where('webnotification_sl',$id);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function check_duplication_web_notfn_edit($notfn_eng,$notfn_mal,$edit_id)     
{ 
	$this->db->select('webnotification_sl');
	$this->db->select('webnotification_engtitle');
	$this->db->select('webnotification_maltitle');
	$this->db->from('tb_webnotification');
	$this->db->where('webnotification_engtitle',$notfn_eng);
	$this->db->where('webnotification_maltitle',$notfn_mal);
	$this->db->where('webnotification_sl<>',$edit_id);
	$this->db->where('webnotification_status',1);
	$this->db->where('webnotification_ctype<>',2);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function update_web_notfn($data,$webnotification_sl)
{
	$where 		= 	"webnotification_sl  = '$webnotification_sl'"; 
	$updquery 	= 	$this->db->update_string('tb_webnotification', $data, $where);
	$rs			=	$this->db->query($updquery);
	return $rs;	
}

function get_terms_condns_list()     
{ 
	$this->db->select('bodycontent_sl');
	$this->db->select('bodycontent_engtitle');
	$this->db->select('bodycontent_maltitle');
	$this->db->select('bodycontent_engcontent');
	$this->db->select('bodycontent_malcontent');
	$this->db->select('bodycontent_location_sl');
	$this->db->select('bodycontent_status_sl');
	$this->db->select('bodycontent_ctype');
	$this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_ctype<>',2);
	$this->db->where('bodycontent_identifier_sl',8);
	$this->db->where('bodycontent_module_sl',2);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function get_fixed_location()     
{ 
	$this->db->select('location_sl');
	$this->db->select('location_name');
	$this->db->from('tb_location');
	$this->db->where('location_status',1);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function get_fixed_location_byid($location_sl)     
{ 
	$this->db->select('location_name');
	$this->db->from('tb_location');
	$this->db->where('location_status',1);
	$this->db->where('location_sl',$location_sl);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function check_duplication_termscondn_insert($title_eng,$title_mal,$location)     
{ 
	$this->db->select('bodycontent_sl');
	$this->db->select('bodycontent_engtitle');
	$this->db->select('bodycontent_maltitle');
	$this->db->select('bodycontent_engcontent');
	$this->db->select('bodycontent_malcontent');
	$this->db->select('bodycontent_location_sl');
	$this->db->select('bodycontent_status_sl');
	$this->db->select('bodycontent_ctype');
	$this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_engtitle',$title_eng);
	$this->db->where('bodycontent_maltitle',$title_mal);
	$this->db->where('bodycontent_location_sl',$location);
	$this->db->where('bodycontent_ctype<>',2);
	$this->db->where('bodycontent_status_sl',1);
	$this->db->where('bodycontent_module_sl',2);
	$this->db->where('bodycontent_identifier_sl',8);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function update_tems_condn_status($data,$bodycontent_sl)
{
	$where 		= 	"bodycontent_sl  = '$bodycontent_sl' AND bodycontent_module_sl=2 AND bodycontent_identifier_sl=8"; 
	$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
	$rs			=	$this->db->query($updquery);
	return $rs;	
}

function edit_terms_condn($id,$data)
{
	$where 		= " bodycontent_sl  = '$id' "; 
	$result 	= $this->db->update('tb_bodycontent', $data, $where);
	return $result;
}

function get_terms_condns_det($id)     
{ 
	$this->db->select('*');
	$this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_sl',$id);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function check_duplication_terms_condn_edit($title_eng,$title_mal,$loc,$edit_id)     
{ 
	$this->db->select('bodycontent_sl');
	$this->db->select('bodycontent_engtitle');
	$this->db->select('bodycontent_maltitle');
	$this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_engtitle',$title_eng);
	$this->db->where('bodycontent_maltitle',$title_mal);
	$this->db->where('bodycontent_location_sl',$loc);
	$this->db->where('bodycontent_sl<>',$edit_id);
	$this->db->where('bodycontent_ctype<>',2);
	$this->db->where('bodycontent_status_sl',1);
	$this->db->where('bodycontent_module_sl',2);
	$this->db->where('bodycontent_identifier_sl',8);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function update_term_condn($data,$bodycontent_sl)
{
	$where 		= 	"bodycontent_sl  = '$bodycontent_sl'"; 
	$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
	$rs			=	$this->db->query($updquery);
	return $rs;	
}

function get_services_list()     
{ 
	$this->db->select('bodycontent_sl');
	$this->db->select('bodycontent_engtitle');
	$this->db->select('bodycontent_maltitle');
	$this->db->select('bodycontent_engcontent');
	$this->db->select('bodycontent_malcontent');
	$this->db->select('bodycontent_status_sl');
	$this->db->select('bodycontent_ctype');
	$this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_ctype<>',2);
	$this->db->where('bodycontent_identifier_sl',9);
	$this->db->where('bodycontent_module_sl',2);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function check_duplication_services_insert($title_eng,$title_mal)     
{ 
	$this->db->select('bodycontent_sl');
	$this->db->select('bodycontent_engtitle');
	$this->db->select('bodycontent_maltitle');
	$this->db->select('bodycontent_engcontent');
	$this->db->select('bodycontent_malcontent');
	$this->db->select('bodycontent_location_sl');
	$this->db->select('bodycontent_status_sl');
	$this->db->select('bodycontent_ctype');
	$this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_engtitle',$title_eng);
	$this->db->where('bodycontent_maltitle',$title_mal);
	$this->db->where('bodycontent_ctype<>',2);
	$this->db->where('bodycontent_status_sl',1);
	$this->db->where('bodycontent_module_sl',2);
	$this->db->where('bodycontent_identifier_sl',9);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function update_service_status($data,$bodycontent_sl)
{
	$where 		= 	"bodycontent_sl  = '$bodycontent_sl' AND bodycontent_module_sl=2 AND bodycontent_identifier_sl=9"; 
	$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
	$rs			=	$this->db->query($updquery);
	return $rs;	
}

function edit_services($id,$data)
{
	$where 		= " bodycontent_sl  = '$id' "; 
	$result 	= $this->db->update('tb_bodycontent', $data, $where);
	return $result;
}

function get_services_det($id)     
{ 
	$this->db->select('*');
	$this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_sl',$id);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function check_duplication_services_edit($title_eng,$title_mal,$edit_id)     
{ 
	$this->db->select('bodycontent_sl');
	$this->db->select('bodycontent_engtitle');
	$this->db->select('bodycontent_maltitle');
	$this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_engtitle',$title_eng);
	$this->db->where('bodycontent_maltitle',$title_mal);
	$this->db->where('bodycontent_sl<>',$edit_id);
	$this->db->where('bodycontent_ctype<>',2);
	$this->db->where('bodycontent_status_sl',1);
	$this->db->where('bodycontent_module_sl',2);
	$this->db->where('bodycontent_identifier_sl',9);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function update_service($data,$bodycontent_sl)
{
	$where 		= 	"bodycontent_sl  = '$bodycontent_sl'"; 
	$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
	$rs			=	$this->db->query($updquery);
	return $rs;	
}

function get_mailbox_list()     
{ 
	$this->db->select('mailbox_sl');
	$this->db->select('mailbox_from');
	$this->db->select('mailbox_to');
	$this->db->select('mailbox_service');
	$this->db->select('mailbox_subject');
	$this->db->select('mailbox_body');
	$this->db->select('mailbox_forwarded');
	$this->db->from('tb_mailbox');
	$this->db->where('mailbox_to<>','');
	$this->db->where('mailbox_status',1);
	$this->db->where('mailbox_service',2);
	$this->db->where('mailbox_ctype<>',2);
	$this->db->order_by('mailbox_forwarded','desc');
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}

function get_service_det($id)     
{ 
	$this->db->select('*');
	$this->db->from('tb_services');
	$this->db->where('services_sl',$id);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
}
/*-------------------------------------------------------------------------------------------------------------------------------------*/
}
