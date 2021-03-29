<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Cron_model extends CI_Model {
	var $table = 'tbl_cronjob';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_transferownerchange_pending($user)
	{
	    $this->db->select('*');
	    $this->db->from('tbl_transfer_ownershipchange');
	    $this->db->join('tbl_kiv_status_details','tbl_transfer_ownershipchange.transfer_vessel_id=tbl_kiv_status_details.vessel_id');
	    $this->db->where('tbl_transfer_ownershipchange.transfer_changepending_status',1);
	    $this->db->where('tbl_transfer_ownershipchange.transfer_approve_id',0);
	    $this->db->where('tbl_transfer_ownershipchange.transfer_status',1);
	    $this->db->where('tbl_kiv_status_details.process_id',39);
	    $where = '(tbl_kiv_status_details.current_status_id="2" or tbl_kiv_status_details.current_status_id = "7")';
       	$this->db->where($where);
	    /*$this->db->where('tbl_kiv_status_details.current_status_id',7);*/
	    $this->db->where('tbl_kiv_status_details.receiving_user_id',$user);
	    $query  	=   $this->db->get();
	    $result 	=   $query->result_array();
	    return $result;
	}

	function get_owner_check($mob,$mail)       
	{
	    $this->db->select('a.user_master_id');
	    $this->db->select('b.user_name');
	    $this->db->select('b.user_address');
	    
	    $this->db->from('user_master a');
	    $this->db->join('tbl_kiv_user b','a.customer_id=b.user_sl');
	    $this->db->where('a.user_master_id_user_type',11);
	    $where  	= "b.user_mobile_number='$mob' OR b.user_email='$mail'";
	    $this->db->where($where);
	    //$this->db->where('b.user_email',$mail);
	    $query  	=   $this->db->get();
	    $result 	=   $query->result_array();
	    return $result;
	}

	function update_transownerchg_status($table,$data,$transfer_id)
	{
	    $where      =   "transfer_sl  = $transfer_id"; 
	    $updquery   =   $this->db->update_string($table, $data, $where);
	    $result     =   $this->db->query($updquery);
	    return $result; 
	}
	function get_transfervessel_pending($user)
	{
	    $this->db->select('*');
	    $this->db->from('tbl_transfer_ownershipchange');
	    $this->db->join('tbl_kiv_status_details','tbl_transfer_ownershipchange.transfer_vessel_id=tbl_kiv_status_details.vessel_id');
	    $this->db->where('tbl_transfer_ownershipchange.transfer_changepending_status',1);
	    $this->db->where('tbl_transfer_ownershipchange.transfer_approve_id',0);
	    $this->db->where('tbl_transfer_ownershipchange.transfer_status',1);
	    $this->db->where('tbl_kiv_status_details.process_id',40);
	    $where = '(tbl_kiv_status_details.current_status_id="2" or tbl_kiv_status_details.current_status_id = "7")';
       	$this->db->where($where);
	    /*$this->db->where('tbl_kiv_status_details.current_status_id',7);*/
	    $this->db->where('tbl_kiv_status_details.receiving_user_id',$user);
	    $query  =   $this->db->get();
	    $result =   $query->result_array();
	    return $result;
	}
}
?>