<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class DataEntry_model extends CI_Model
{
function __construct()
{
// Call the Model constructor
parent::__construct();
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
//_________________________________________________________//

function get_registeringAuthority()
{
    $this->db->select('registering_authority_sl');
    $this->db->select('registering_authority_name');
    $this->db->from('kiv_registering_authority_master');
    $this->db->where('registering_authority_status',1);
    $this->db->where('delete_status',0);
    $query  =    $this->db->get();
    $result =   $query->result_array();
    return $result;
} 
function get_vesseltype()
{
    $this->db->select('*');
    $this->db->from('kiv_vesseltype_master');
    $this->db->where('vesseltype_status',1);
    $this->db->where('delete_status','0');
    $this->db->order_by('vesseltype_name','ASC'); 
    $query  =   $this->db->get();
    $result =   $query->result_array();
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
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

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
function get_inboard_outboard()
{
    $this->db->select('*');
    $this->db->from('kiv_inboard_outboard_master');
    $this->db->where('inboard_outboard_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('inboard_outboard_name','ASC'); 
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_hullmaterial()
{
    $this->db->select('*');
    $this->db->from('kiv_hullmaterial_master');
    $this->db->where('hullmaterial_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('hullmaterial_name','ASC'); 
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_ralist()
{
    $this->db->select('user_master_id,user_master_fullname');
    $this->db->from('user_master');
    $this->db->where('user_master_id_user_type',14);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_stern_material()
{
    $this->db->select('*');
    $this->db->from('b1_kiv_stern_material_master');
    $this->db->where('delete_status',0);
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


 function get_cargo_nature()
 {
    $this->db->select('*');
    $this->db->from('kiv_natureofoperation_master');
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

 function get_equipment_details_id($equipment_type_id)
{
    $id=array(17,18,19);
    $this->db->select('*');
    $this->db->from('kiv_equipment_master');
    $this->db->where('equipment_type_id',$equipment_type_id);
    $this->db->where_in('equipment_sl',$id);
    $this->db->where('equipment_status',1);
    $this->db->where('delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_portable_fire_ext()
{
    $this->db->select('*');
    $this->db->from('kiv_portable_fire_extinguisher_master');
    $this->db->where('portable_fire_extinguisher_status',1);
    $this->db->where('delete_status',0);
    $this->db->order_by('portable_fire_extinguisher_name','ASC');
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

function insert_tabledata($table,$data)
{
    $result=$this->db->insert($table, $data);  
    return $result;
} 
function get_vessel_type_id($vessel_type_id)
{
    $this->db->select('vesseltype_name');
    $this->db->select('vesseltype_code');
    $this->db->from('kiv_vesseltype_master');
    $this->db->where('vesseltype_sl',$vessel_type_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
    
function get_vessel_subtype_id($vessel_subtype_id)
{
    $this->db->select('vessel_subtype_name');
    $this->db->from('kiv_vessel_subtype_master');
    $this->db->where('vessel_subtype_sl',$vessel_subtype_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}


function get_portoffice_id($sess_usr_id)
{
    $this->db->select('user_master_port_id');
    $this->db->from('user_master');
    $this->db->where('user_master_id',$sess_usr_id);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_dataentry_details($sess_usr_id)
{
    $this->db->select('*');
    $this->db->from('tb_vessel_dataentry');
    $this->db->where('dataentry_user_id',$sess_usr_id);
    $this->db->where('delete_status','0');
    $this->db->order_by('dataentry_date','DESC');
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
function get_verified_dataentry_details($sess_usr_id)
{
    $this->db->select('*');
    $this->db->from('tb_vessel_dataentry');
    $this->db->where('dataentry_user_id',$sess_usr_id);
    $this->db->where('dataentry_approved_status','1');
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_portofregistry_name($portoffice_id)
{
    $this->db->select('*');
    $this->db->from('tbl_portoffice_master');
    $this->db->where('int_portoffice_id',$portoffice_id);
    $this->db->where('kiv_status','1');
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
function get_vesselmain($vessel_id)
{
    $this->db->select('*');
    $this->db->from('tb_vessel_main');
    $this->db->where('vesselmain_vessel_id',$vessel_id);
    $this->db->where('dataentry_status','1');
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}


function get_vessel_subtype_all()
{
    $this->db->select('*');
    $this->db->from('kiv_vessel_subtype_master');
    $this->db->where('vessel_subtype_status',1);
    $this->db->where('delete_status','0');
    $this->db->order_by('vessel_subtype_name','ASC'); 
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function get_dataentry_table($tablename,$fieldname,$vessel_id)
{
    $this->db->select('*');
    $this->db->from($tablename);
    $this->db->where($fieldname,$vessel_id);
    $this->db->where('dataentry_status','1');
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
function fire_fighting_equipment_details($vessel_id)
{
    $this->db->select('*');
    $this->db->from('kiv_portable_fire_extinguisher_master a');
    $this->db->join('tbl_kiv_fire_extinguisher_details b','a.portable_fire_extinguisher_sl=b.fire_extinguisher_type_id');
    $this->db->where('b.vessel_id',$vessel_id);
    $this->db->where('b.dataentry_status','1');
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}


 function get_equipment_details($equipment_type_id)
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


 function get_equipment_table($tablename,$fieldname,$vessel_id,$equipment_type_id,$equipment_id)
{
    $this->db->select('*');
    $this->db->from($tablename);
    $this->db->where($fieldname,$vessel_id);
    $this->db->where('equipment_id',$equipment_id);
    $this->db->where('equipment_type_id',$equipment_type_id);
    $this->db->where('dataentry_status',1);
    $this->db->where('delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

/*function get_pollution_ctrl_edit($vessel_id,$equipment_type_id)
{
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details a');
    $this->db->join('kiv_equipment_master b','a.equipment_type_id=b.equipment_type_id');
    $this->db->where('a.vessel_id',$vessel_id);
    $this->db->where('a.equipment_type_id',$equipment_type_id);
    $this->db->where('a.dataentry_status',1);
    $this->db->where('a.delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}*/
function get_pollution_ctrl_edit($vessel_id,$equipment_type_id)
{
    $this->db->select('equipment_id');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_type_id',$equipment_type_id);
    $this->db->where('dataentry_status',1);
    $this->db->where('delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}
function get_dataentry_table_crew($tablename,$fieldname,$vessel_id,$crew_type_id)
{
    $this->db->select('*');
    $this->db->from($tablename);
    $this->db->where($fieldname,$vessel_id);
    $this->db->where('crew_type_id',$crew_type_id);
    $this->db->where('dataentry_status','1');
    $this->db->where('delete_status','0');
    
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;
}

function delele_crew_table($crew_sl,$data_crew)
{
    $where       =   "crew_sl  = $crew_sl"; 
    $updquery   =   $this->db->update_string('tbl_kiv_crew_details', $data_crew, $where);
    $result     =   $this->db->query($updquery);
    return $result; 
}
/*function get_equipment_details_edit($vessel_id,$equipment_type_id)
{
    $id=array(17,18,19);
    $this->db->select('*');
    $this->db->from('kiv_equipment_master b');
    $this->db->join('tbl_kiv_equipment_details a','a.equipment_id=b.equipment_sl');
    $this->db->where_in('b.equipment_sl',$id);
    $this->db->where('a.vessel_id',$vessel_id);
    $this->db->where('b.equipment_type_id',$equipment_type_id);
    $this->db->where('a.dataentry_status',1);
    $this->db->where('b.delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;  

}
*/
function get_equipment_dtls($vessel_id,$equipment_type_id,$equipment_sl)
{
   
    $this->db->select('*');
    $this->db->from('tbl_kiv_equipment_details');
    $this->db->where('vessel_id',$vessel_id);
    $this->db->where('equipment_type_id',$equipment_type_id);
    $this->db->where('equipment_id',$equipment_sl);
    $this->db->where('dataentry_status',1);
    $this->db->where('delete_status',0);
    $query  =   $this->db->get();
    $result =   $query->result_array();
    return $result;  

}
function update_dataentry_tables($tablename,$data_update, $field_name,$primary_key)
{
     $where     =   "$field_name  = $primary_key"; 
    $updquery   =   $this->db->update_string($tablename, $data_update, $where);
    $result     =   $this->db->query($updquery);
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
//___________MODEL ENDING_____________//
}
?>