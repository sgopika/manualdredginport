<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	


function get_state()
{
  $this->db->select('*');
  $this->db->from('kiv_state_master');
  $this->db->where('state_code',32);
  $this->db->where('state_status',1);
  $this->db->where('delete_status',0);
  $query  =   $this->db->get();
  $result =   $query->result_array();
  return $result;
}

function get_district($user_state_id)
{
  $this->db->select('*');
  $this->db->from('kiv_district_master');
  $this->db->where('state_code',$user_state_id);
  $this->db->where('district_status',1);
  $this->db->where('delete_status',0);
  $query 	= 	$this->db->get();
  $result = 	$query->result_array();
  return $result;
} 

function  get_occupation() 
{
  $this->db->select('*');
  $this->db->from('kiv_occupation_master');
  $query 	= 	$this->db->get();
  $result = 	$query->result_array();
  return $result;
} 

function get_idcard()
{
  $this->db->select('*');
  $this->db->from('kiv_idcard_master');
  $query 	= 	$this->db->get();
  $result = 	$query->result_array();
  return $result;
} 
function get_choice()
{
  $this->db->select('*');
  $this->db->from('kiv_choice_master');
  $query 	= 	$this->db->get();
  $result = 	$query->result_array();
  return $result;
} 

function get_ownership_type()
{
  $this->db->select('*');
  $this->db->from('kiv_ownership_type_master');
  $query 	= 	$this->db->get();
  $result = 	$query->result_array();
  return $result;

}
function get_user_details($id)
{
  $this->db->select('*');
  $this->db->from('tbl_kiv_user');
   $this->db->where('user_sl', $id);
  $query 	= 	$this->db->get();
  $result = 	$query->result_array();
  return $result;
}

function mobilenumber_exist($mobile)
{
  $this->db->select('user_mobile_number');
  $this->db->from('tbl_kiv_user');
  $this->db->where('user_mobile_number', $mobile);
  $query  =   $this->db->get();
  $result =   $query->result_array();
  return $result;
}
function email_check($email_id)
{
  $this->db->select('*');
  $this->db->from('user_master');
  $this->db->where('user_master_email', $email_id);
  $query  =   $this->db->get();
  $result =   $query->result_array();
  return $result;
}

function email_exist($email_id)
{
  $this->db->select('user_master_email');
  $this->db->from('user_master');
  $this->db->where('user_master_email', $email_id);
  $query  =   $this->db->get();
  $result =   $query->result_array();
  return $result;
}

function username_exist($username)
{
  $this->db->select('user_master_name');
  $this->db->from('user_master');
  $this->db->where('user_master_name', $username);
  $query  =   $this->db->get();
  $result =   $query->result_array();
  return $result;
}

function idcard_exist($user_idcard_number)
{
  $this->db->select('user_idcard_number');
  $this->db->from('tbl_kiv_user');
  $this->db->where('user_idcard_number', $user_idcard_number);
  $query  =   $this->db->get();
  $result =   $query->result_array();
  return $result;
}
  
function user_idcard_id_name($user_idcard_id)
{
$this->db->select('idcard_name');
$this->db->from('kiv_idcard_master');
$this->db->where('idcard_sl', $user_idcard_id);
$query  =   $this->db->get();
$result =   $query->result_array();
return $result;
}
  
function get_owner_details($id)
{
  $this->db->select('*');
  $this->db->from('tbl_kiv_user  a');
  $this->db->join('user_master b','a.user_sl=b.customer_id');
  $this->db->where('a.user_sl', $id);
  $this->db->where('a.delete_status', 0);
  $query  =   $this->db->get();
  $result =   $query->result_array();
  return $result;
}

function get_minor_details($id)
{
  $this->db->select('*');
  $this->db->from('tbl_kiv_minor_status');
  $this->db->where('user_id', $id);
  $query  =   $this->db->get();
  $result =   $query->result_array();
  return $result;
}

function insert_data($table,$data)
{
  $result=$this->db->insert($table, $data);  
  return $result;
}

function co_owner_count_details($id,$ownership_id)
{
  $this->db->select('COUNT(*) AS coowner_count');
  $this->db->from('tbl_kiv_user');
  $this->db->where('relation_sl', $id);
  $this->db->where('user_ownership_id', $ownership_id);
  $query  =   $this->db->get();
  $result =   $query->result_array();
  return $result;
}

function count_details($id,$ownership_id)
{
  $this->db->select('COUNT(*) AS cnt');
  $this->db->from('tbl_kiv_user');
  $this->db->where('relation_sl', $id);
  $this->db->where('user_ownership_id', $ownership_id);
  $query  =   $this->db->get();
  $result =   $query->result_array();
  return $result;
}

/*______________Curl to send SMS starts_________________*/
public function sendSms($message,$number)
{
  $link = curl_init();
  curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=portsms2&password=portsms1234&message=".$message."&numbers=".$number."&senderid=PORTDR");
  curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($link , CURLOPT_HEADER, 0);
  return $output = curl_exec($link);
  curl_close($link );
} 

//___________________Model end__________________//    
}