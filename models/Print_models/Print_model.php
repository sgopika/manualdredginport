<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Print_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	

 	function get_registered_vessels()     
    { 
		$this->db->select('*');
		$this->db->from('tb_vessel_main');
		$this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
		//$this->db->where('vesselmain_reg_number<>','');
		$this->db->where('vesselmain_reg_number<>','0');
		$this->db->where('print_count',0);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function get_registered_vessels_rep($from_date,$to_date)     
    { 
		$this->db->select('*');
		$this->db->from('tb_vessel_main');
		$this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
		//$this->db->where('vesselmain_reg_number<>','');
		$this->db->where('vesselmain_reg_number<>','0');
		$this->db->where('tb_vessel_main.print_count',0);
		$this->db->where('tb_vessel_main.vesselmain_reg_date >=', $from_date);
        $this->db->where('tb_vessel_main.vesselmain_reg_date <=', $to_date);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function get_registered_vessels_all()     
    { 
		$this->db->select('*');
		$this->db->from('tb_vessel_main');
		$this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
		$this->db->join('tbl_registrationplate','tbl_registrationplate.vessel_id=tb_vessel_main.vesselmain_vessel_id','left');
		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
		//$this->db->where('vesselmain_reg_number<>','');
		$this->db->where('vesselmain_reg_number<>','0');
		//$this->db->where('print_count',0);
		$where = '((tb_vessel_main.print_count= 0) or (tb_vessel_main.reprint_approve_status = 1))';
        $this->db->where($where);

		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function get_registered_vessels_all_rep($from_date,$to_date)     
    { 
		$this->db->select('*');
		$this->db->from('tb_vessel_main');
		$this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
		$this->db->join('tbl_registrationplate','tbl_registrationplate.vessel_id=tb_vessel_main.vesselmain_vessel_id','left');
		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
		//$this->db->where('vesselmain_reg_number<>','');
		$this->db->where('vesselmain_reg_number<>','0');
		//$this->db->where('print_count',0);
		$where = '((tb_vessel_main.print_count= 0) or (tb_vessel_main.reprint_approve_status = 1))';
        $this->db->where($where);
        $this->db->where('tb_vessel_main.vesselmain_reg_date >=', $from_date);
        $this->db->where('tb_vessel_main.vesselmain_reg_date <=', $to_date);

		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function get_registered_vessels_reprint()     
    { 
		$this->db->select('*');
		$this->db->from('tb_vessel_main');
		$this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
		$this->db->join('tbl_registrationplate','tbl_registrationplate.vessel_id=tb_vessel_main.vesselmain_vessel_id');
		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
		//$this->db->where('tb_vessel_main.vesselmain_reg_number<>','');
		$this->db->where('vesselmain_reg_number<>','0');
		$this->db->where('tb_vessel_main.print_count >',0);
		$this->db->where('tb_vessel_main.reprint_approve_status',1);
		$this->db->where('tbl_registrationplate.reprint_approve_status',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function get_registered_vessels_reprint_rep($from_date,$to_date)     
    { 
		$this->db->select('*');
		$this->db->from('tb_vessel_main');
		$this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
		$this->db->join('tbl_registrationplate','tbl_registrationplate.vessel_id=tb_vessel_main.vesselmain_vessel_id');
		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
		//$this->db->where('tb_vessel_main.vesselmain_reg_number<>','');
		$this->db->where('vesselmain_reg_number<>','0');
		$this->db->where('tb_vessel_main.print_count >',0);
		$this->db->where('tb_vessel_main.reprint_approve_status',1);
		$this->db->where('tb_vessel_main.vesselmain_reg_date >=', $from_date);
        $this->db->where('tb_vessel_main.vesselmain_reg_date <=', $to_date);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function get_vessel_details($id)     
    { 
		$this->db->select('*');
		$this->db->from('tb_vessel_main');
		$this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
		//$this->db->where('vesselmain_reg_number<>','');
		$this->db->where('vesselmain_reg_number<>','0');
		$this->db->where('vesselmain_vessel_id',$id);
		//reprint_approve_status
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function get_vessel_details_id($ids)     
    { 
		$this->db->select('*');
		$this->db->from('tb_vessel_main');
		$this->db->join('user_master','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=tb_vessel_main.vesselmain_portofregistry_id');
		//$this->db->where('vesselmain_reg_number<>','');
		$this->db->where('vesselmain_reg_number<>','0');
		$this->db->where_in('vesselmain_vessel_id', $ids);
		//reprint_approve_status
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	 function update_vessel_print_cnt($data_print,$id)
    {
        $where 		= 	"vesselmain_vessel_id  = $id"; 
        $updquery 	= 	$this->db->update_string('tb_vessel_main', $data_print, $where);
        $result		=	$this->db->query($updquery);
        return $result;	
    }
     function update_regn_plate($data,$id)
    {
        $where      =   "vessel_id  = $id"; 
        $updquery   =   $this->db->update_string('tbl_registrationplate', $data, $where);
        $result     =   $this->db->query($updquery);
        return $result; 
    }

    function get_regn_plate_id($id){

    	$this->db->select('*');
		$this->db->from('tbl_registrationplate');
		
		$this->db->where('vessel_id',$id);
		$this->db->where('reprint_approve_status',1);
		
		//reprint_approve_status
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
    }
	
/*-------------------------------------------------------------------------------------------------------------------------------------*/
}
