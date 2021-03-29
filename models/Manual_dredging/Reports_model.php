<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Reports_model extends CI_Model

{

    function __construct()

    {

        // Call the Model constructor

        parent::__construct();

    }

	function gensalereport($zid,$from,$to)

	{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_booking.customer_booking_allotted_date >=',$from);

		$this->db->where('customer_booking.customer_booking_allotted_date <=',$to);

		$this->db->where('transaction_details.print_status',1);

		$this->db->where('customer_booking.customer_booking_zone_id',$zid);
		$this->db->order_by('customer_booking_pass_issue_timestamp', 'asc');
		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	//----------------------------------------------------------------------------------------------

	function spot_gensalereport($zid,$from,$to)

	{

		$this->db->select('*');

        $this->db->from('tbl_spotbooking');

		$this->db->join('transaction_details', 'tbl_spotbooking.spot_token = transaction_details.token_no');

		$this->db->where('tbl_spotbooking.spot_alloted >=',$from);

		$this->db->where('tbl_spotbooking.spot_alloted <=',$to);

		$this->db->where('transaction_details.pass_dstatus',1);

		$this->db->where('transaction_details.zone_id',$zid);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	//----------------------------------------------------------------------------------------------

	function get_portzonestatus()

	{

		$this->db->select('*');

        $this->db->from('tbl_priority');

		$this->db->join('zone', 'tbl_priority.zone_id = zone.zone_id');

		$this->db->join('tbl_portoffice_master', 'tbl_portoffice_master.int_portoffice_id = tbl_priority.port_id');

		$this->db->where('tbl_priority.last_priority >',0);

		//$this->db->where('customer_booking.customer_booking_allotted_date >',$from);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function get_change_booking($fromzone)

	{

		$query = $this->db->query("select * from customer_booking join transaction_details on customer_booking.customer_booking_id=transaction_details.transaction_customer_booking_id where customer_booking.customer_booking_pass_issue_user=0 and customer_booking.customer_booking_zone_id='$fromzone' and customer_booking.customer_booking_decission_status IN(2,0)");

		//echo $this->db->last_query();

		//exit;

        $result = $query->result_array();

        return $result;

	}

	//-------------------------------------------------

	function get_spotbookinglist($tokennumnber,$aadharnumber,$zone_id)

	{

	$cudate=date('Y-m-d');

$this->db->select('*');

        $this->db->from('tbl_spotbooking');

		$this->db->join('transaction_details', 'transaction_details.token_no=tbl_spotbooking.spot_token');

		$this->db->where('tbl_spotbooking.spot_token', $tokennumnber);

		$this->db->where('tbl_spotbooking.spot_adhaar', $aadharnumber);

		$this->db->where('tbl_spotbooking.spot_alloted',$cudate);

		$this->db->where('transaction_details.zone_id', $zone_id);

		$this->db->where('transaction_details.transaction_status', 1);
		$this->db->where('transaction_details.print_status ', 0);
		$this->db->where('tbl_spotbooking.spot_booking_type', 1);

		$query = $this->db->get();

  // echo	$this->db->last_query();

   //exit();

		$result = $query->result_array();

        return $result;

	}
	function get_spotbookinglistotp($tokennumnber,$port_id,$zone_id)

	{

	$cudate=date('Y-m-d');

$this->db->select('*');

        $this->db->from('tbl_spotbooking');

		$this->db->join('transaction_details', 'transaction_details.token_no=tbl_spotbooking.spot_token');
		$this->db->where('tbl_spotbooking.spot_token', $tokennumnber);
		$this->db->where('tbl_spotbooking.spot_alloted',$cudate);
		$this->db->where('transaction_details.port_id', $port_id);
		$this->db->where('transaction_details.zone_id', $zone_id);
		$this->db->where('transaction_details.transaction_status', 1);
		$this->db->where('transaction_details.print_status ', 0);
		$this->db->where('tbl_spotbooking.spot_booking_type', 1);

		$query = $this->db->get();

  // echo	$this->db->last_query();

   //exit();

		$result = $query->result_array();

        return $result;

	}	

	function get_spotbookingadd($id)

	{

		$this->db->select('*');

        $this->db->from('tbl_spotbooking');

		

		$this->db->join('transaction_details', 'transaction_details.token_no=tbl_spotbooking.spot_token');

		$this->db->where('tbl_spotbooking.spotreg_id', $id);

		

		$this->db->where('transaction_details.transaction_status', 1);

		$this->db->where('transaction_details.payment_status', 1);

		$this->db->where('transaction_details.print_status', 0);

		$query = $this->db->get();

	//	echo $this->db->last_query(); 

		//exit();

		$result = $query->result_array();

        return $result;

	}	

	function update_spotbooking($data,$id)

	{

$where 		= 	"spotreg_id  = '$id'"; 

		$updquery 	= 	$this->db->update_string('tbl_spotbooking', $data, $where);

		$rs			=	$this->db->query($updquery);

	//echo	$this->db->last_query(); exit();

		return $rs;	

		}

	function vehiclepass_details_spot($bookingid)

	{

$this->db->select('*');

        $this->db->from('tbl_spotbooking');

		$this->db->join('transaction_details', 'transaction_details.token_no=tbl_spotbooking.spot_token');

		//$this->db->where('spot_token', $bookingid);

		$this->db->where('transaction_status', 1);

		$this->db->where('pass_dstatus', 2);

		$this->db->where('spotreg_id',$bookingid);

		$query = $this->db->get();

		//echo	$this->db->last_query(); 

		//exit();

		$result = $query->result_array();

        return $result;

	}

	function vehiclepass_details_spot_pass($bookingid)

	{

$this->db->select('*');

        $this->db->from('tbl_spotbooking');

		$this->db->join('transaction_details', 'transaction_details.token_no=tbl_spotbooking.spot_token');

		//$this->db->where('spot_token', $bookingid);

		$this->db->where('transaction_details.transaction_status', 1);

		//$this->db->where('transaction_details.pass_dstatus', 2);

		$this->db->where('tbl_spotbooking.spot_token',$bookingid);

		$query = $this->db->get();

	//echo	$this->db->last_query(); 

	//	exit();

		$result = $query->result_array();

        return $result;

	}

	//-------------------------------------------------

	

	function getSec_customerreg_detailsold($portid)

{

		$query = $this->db->query("SELECT customer_registration.*,district.*,customer_sec_reg.*,customer_registration.customer_registration_timestamp as regdt FROM customer_registration join district on customer_registration.customer_perm_district_id=district.district_id join customer_sec_reg on customer_sec_reg.cus_reg_id=customer_registration.customer_registration_id WHERE customer_sec_reg.customer_request_status =1 AND customer_registration.port_id = '$portid' ORDER by customer_sec_reg.customer_registration_timestamp ASC LIMIT 0,250");

       // $query = $this->db->query("SELECT * FROM `customer_registration` join district on customer_registration.customer_perm_district_id=district.district_id  WHERE `customer_request_status` =1 AND `port_id` = '$portid' ORDER By `customer_registration_timestamp` ASC LIMIT 0,250");

        $result = $query->result_array();


	//break;

        return $result;

	

}

	//----------------------------------------------

	function get_approvaldet($portid,$requestdate)

	{

	$query=$this->db->query("SELECT * FROM `customer_registration` WHERE `customer_request_status` = 1 AND `port_id` = '$portid' AND customer_registration.customer_registration_timestamp<='$requestdate' ORDER BY customer_registration_timestamp ASC");

		 $result = $query->result_array();

	//echo $this->db->last_query();

	//break;

        return $result;



	}

	

	function customerapproval_second($custaadhar,$pid)

{

$query= $this->db->query("select * from customer_registration join customer_sec_reg on customer_sec_reg.cus_reg_id=customer_registration.customer_registration_id where customer_sec_reg.customer_request_status=1 and port_id='$pid' and customer_sec_reg.customer_decission_user_id=0 and (customer_aadhar_number='$custaadhar' or customer_reg_no='$custaadhar')");



        $result = $query->result_array();

	//echo $this->db->last_query();exit();

		return $result;

}

	//---------------------------------------------------------------28/2/18---------------

	function update_secondreg($data,$regid)

{

	$this->db->where('customer_registration_id',$regid);

		$result		=	$this->db->update('customer_sec_reg',$data);

        return $result;

}

//---------------------------------

function getSec_customerreg_details($portid)

{

		$query = $this->db->query("SELECT customer_registration.*,district.*,customer_sec_reg.*,customer_registration.customer_registration_timestamp as regdt FROM customer_registration join district on customer_registration.customer_perm_district_id=district.district_id join customer_sec_reg on customer_sec_reg.cus_reg_id=customer_registration.customer_registration_id WHERE customer_sec_reg.customer_request_status =1 AND customer_registration.port_id = '$portid' and update_stat=1 ORDER by customer_sec_reg.customer_registration_timestamp ASC LIMIT  0,50");

       // $query = $this->db->query("SELECT * FROM `customer_registration` join district on customer_registration.customer_perm_district_id=district.district_id  WHERE `customer_request_status` =1 AND `port_id` = '$portid' ORDER By `customer_registration_timestamp` ASC LIMIT 0,250");

        $result = $query->result_array();

//echo $this->db->last_query();

	//break;

        return $result;

	

}
	
	function getSec_customerreg_rejected($portid)

{

		$query = $this->db->query("SELECT customer_registration.*,district.*,customer_sec_reg.*,customer_registration.customer_registration_timestamp as regdt FROM customer_registration join district on customer_registration.customer_perm_district_id=district.district_id join customer_sec_reg on customer_sec_reg.cus_reg_id=customer_registration.customer_registration_id WHERE customer_sec_reg.customer_request_status =3 AND customer_registration.port_id = '$portid' and update_stat=1 ORDER by customer_sec_reg.customer_registration_timestamp ASC LIMIT  0,50");

       // $query = $this->db->query("SELECT * FROM `customer_registration` join district on customer_registration.customer_perm_district_id=district.district_id  WHERE `customer_request_status` =1 AND `port_id` = '$portid' ORDER By `customer_registration_timestamp` ASC LIMIT 0,250");

        $result = $query->result_array();

//echo $this->db->last_query();

	//break;

        return $result;

	

}

//-----------------------------------------------------------

function getSeccustomerregdetails($id,$portid)

{

		$this->db->select('`customer_aadhar_number`,`customer_phone_number`, `customer_email_id`, `customer_perm_house_number`, `customer_perm_house_name`, `customer_perm_house_place`, `customer_perm_post_office`, `customer_perm_pin_code`, `customer_perm_district_id`, `customer_perm_lsg_id`,`port_id`, `customer_reg_no`, `aadhar_uploadname`,`int_req`,customer_sec_reg.*');

        $this->db->from('customer_registration');

	$this->db->join('customer_sec_reg', 'customer_registration.customer_registration_id=customer_sec_reg.cus_reg_id');

		//$this->db->where('customer_request_status', 2);

		$this->db->where('customer_sec_reg.customer_registration_id', $id);

		$this->db->where('customer_registration.port_id', $portid);

		$this->db->where('customer_sec_reg.customer_request_status', 1);

		$this->db->where('customer_sec_reg.update_stat', 1);

	

        $query = $this->db->get();

	//echo $this->db->last_query();exit();

        $result = $query->result_array();

		$this->db->last_query(); 

        return $result;

	

}



//-------------------------------------------SPOT ONLINE----------------------------------------------------------------

function get_portspot_status()

{

$today=date('Y-m-d');
	
	

$query=$this->db->query("SELECT * FROM `spot_booking_limit` join tbl_portoffice_master on spot_booking_limit.spot_limit_port_id=tbl_portoffice_master.int_portoffice_id join zone on zone.zone_id=spot_booking_limit.spot_limit_zone_id where spot_booking_limit.spot_limit_date='$today' order by spot_booking_limit.spot_limit_port_id asc");
	
	//SELECT spot_limit_quantity,tbl_portoffice_master.vchr_portoffice_name,zone.zone_name,sum(spot_ton) as total FROM `spot_booking_limit` join tbl_portoffice_master on spot_booking_limit.spot_limit_port_id=tbl_portoffice_master.int_portoffice_id join zone on zone.zone_id=spot_booking_limit.spot_limit_zone_id join tbl_spotbooking on tbl_spotbooking.preferred_zone=spot_limit_zone_id where spot_booking_limit.spot_limit_date='2019-07-26' and tbl_spotbooking.spotbooking_dte='2019-07-26' GROUP by preferred_zone 

 $result = $query->result_array();

	//echo $this->db->last_query();exit();

		return $result;

}
	function get_portspot_statusnew()

{

$today=date('Y-m-d');

$query=$this->db->query("SELECT sum(spot_ton) as tontotal,preferred_zone FROM `tbl_spotbooking` where spotbooking_dte='$today' GROUP by preferred_zone ORDER BY `tbl_spotbooking`.`preferred_zone` ASC
");

 $result = $query->result_array();

	//echo $this->db->last_query();exit();

		return $result;

}

	//-------------------------------------------------------

	function get_user_typeph()

	{

		$this->db->select('*');

        $this->db->from('user_type');

		$where='user_type_id in ( 4,6)';

		//$where='user_type_id=6';

		$this->db->where($where);

		$query = $this->db->get();

		//echo $this->db->last_query();exit();

        $result = $query->result_array();

        return $result;

	}

	function get_userdet($portid,$usertype)

	{

		$this->db->select('*');

        $this->db->from('user_master');

		$this->db->join('zone','zone.zone_id=user_master.user_master_zone_id');

		$this->db->where('user_master_port_id', $portid);

		$this->db->where('user_master_id_user_type', $usertype);

		$this->db->where('user_master_status', 1);

		

		$query = $this->db->get();

		//echo $this->db->last_query();//exit();

        $result = $query->result_array();

        return $result;

	}

	//----------------------------------

	function requestbooking_again($bookid)

	{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');

		$this->db->where('customer_booking_id', $bookid);

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('customer_booking_request_status', 0);

		$this->db->where('transaction_status', 1);

		$query = $this->db->get();

	//echo	$this->db->last_query(); 

		//exit();

		$result = $query->result_array();

        return $result;

	}

	

	

	function get_request_booked($userid)

	{

		$today=date('Y-m-d');

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=customer_booking.customer_booking_port_id');

		$this->db->join('transaction_details','transaction_details.transaction_customer_booking_id=customer_booking.customer_booking_id');

		$this->db->join('zone','zone.zone_id=customer_booking.customer_booking_zone_id');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_booking.customer_booking_customer_booking',$userid);

		$this->db->where('customer_booking.customer_booking_decission_status',2);

		$this->db->where('customer_booking.customer_booking_pass_issue_user',0);

		$this->db->where('customer_booking.customer_booking_allotted_date < ',$today);

		$this->db->where('transaction_details.payment_status',1);

		$this->db->order_by('customer_booking.customer_booking_priority_number', 'asc');

		$query = $this->db->get();

		if($this->db->affected_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }

        //$result = $query->result_array();

		//print_r($result);

       // return $result;

	}

	//-----------------------------------------------------------------------

	//------------------------------------------

	function getuser_nameclerk($portid)

	{

		$query = $this->db->query("SELECT `user_master_id`, `user_master_name`  FROM `user_master` WHERE user_master_id_user_type=9 and user_master_status=1 and user_master_port_id='$portid'");

	//	echo $this->db->last_query();

		$result = $query->result_array();

        return $result;

	}

	function get_moduledetails()

	{

		$query = $this->db->query("SELECT * FROM `tbl_module` WHERE module_status=1");

	//	echo $this->db->last_query();

		$result = $query->result_array();

        return $result;

	}

	function assign_mod_view($portid)

	{

		$query = $this->db->query("SELECT user_master.user_master_name,tbl_module.module_name,assign_module.assign_module_status,assign_module.assign_mod_id FROM `assign_module` join user_master on user_master.user_master_id=assign_module.user_master_id join tbl_module on tbl_module.module_id=assign_module.module_id where user_master.user_master_id_user_type=9 and assign_module.assign_module_status=1 and user_master.user_master_port_id='$portid'");

	//	echo $this->db->last_query();

		$result = $query->result_array();

        return $result;

	}

	//-----------------------------------------------------------------------------------

	function get_all_buk_pay_second($id)

	{

		$today=date('Y-m-d');

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=customer_booking.customer_booking_port_id');

		$this->db->join('transaction_details','transaction_details.transaction_customer_booking_id=customer_booking.customer_booking_id');

		$this->db->join('zone','zone.zone_id=customer_booking.customer_booking_zone_id');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_booking.customer_booking_zone_id',$id);

		$this->db->where('customer_booking.customer_booking_decission_status',2);

		$this->db->where('customer_booking.customer_booking_pass_issue_user',0);

		$this->db->where('customer_booking.customer_booking_allotted_date < ',$today);

		$this->db->where('transaction_details.payment_status',1);

		$this->db->where('transaction_details.print_status',0);

		$this->db->where('customer_booking.customer_booking_request_status',2);

		$this->db->order_by('customer_booking.customer_booking_priority_number', 'asc');

		$query = $this->db->get();

		//echo $this->db->last_query(); exit();

        $result = $query->result_array();

		//print_r($result);

        return $result;

	}	

	//------------------------------------------------------------------------------------

	function Sec_requestbooking_again($bookid)

	{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');

		$this->db->where('customer_booking_id', $bookid);

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('customer_booking_request_status', 2);

		$this->db->where('transaction_status', 1);

		$query = $this->db->get();

	//echo	$this->db->last_query(); 

		//exit();

		$result = $query->result_array();

        return $result;

	}

	//------------------------------------------------------------------------------------
	function get_worker_registrationpc($zone_id){
		
		$query    =    $this->db->query("select  worker_registration_id,worker_registration_name,worker_registration_phone_number,worker_registration_status FROM worker_registration WHERE worker_registration_status!=0 and zone_id='".$zone_id."'");    
		$result    =    $query->result_array();
		//echo $this->db->last_query();break;
		return $result;
	}
	
	function gettoken($portid,$token)

{

		$query=$this->db->query("select tbl_spotbooking.spotreg_id,transaction_details.print_status,preferred_zone,spot_booking_type from tbl_spotbooking join  transaction_details on tbl_spotbooking.spot_token=transaction_details.token_no where transaction_details.port_id='$portid' and tbl_spotbooking.spot_token='$token'");

       // $query = $this->db->query("SELECT * FROM `customer_registration` join district on customer_registration.customer_perm_district_id=district.district_id  WHERE `customer_request_status` =1 AND `port_id` = '$portid' ORDER By `customer_registration_timestamp` ASC LIMIT 0,250");

        $result = $query->result_array();

//echo $this->db->last_query();exit();

	//break;

        return $result;

	

}
	//------------------------------------------------------
	function workcheck($portid,$currentdate)

{

		$query=$this->db->query("SELECT count(customer_registration_id) as cntreg FROM `customer_registration` WHERE `customer_registration_timestamp` like '%$currentdate%' and port_id='$portid'");

       // $query = $this->db->query("SELECT * FROM `customer_registration` join district on customer_registration.customer_perm_district_id=district.district_id  WHERE `customer_request_status` =1 AND `port_id` = '$portid' ORDER By `customer_registration_timestamp` ASC LIMIT 0,250");

        $result = $query->result_array();

//echo $this->db->last_query();exit();

	//break;

        return $result;

	

}
	function workchecktwo($portid,$currentdate)

{

		$query=$this->db->query("SELECT count(customer_registration_id) as cntregtwo,customer_decission_user_id FROM `customer_registration`  WHERE `customer_decission_timestamp` like '%$currentdate%' and port_id='$portid' GROUP by customer_decission_user_id asc");

       // $query = $this->db->query("SELECT * FROM `customer_registration` join district on customer_registration.customer_perm_district_id=district.district_id  WHERE `customer_request_status` =1 AND `port_id` = '$portid' ORDER By `customer_registration_timestamp` ASC LIMIT 0,250");

        $result = $query->result_array();

//echo $this->db->last_query();exit();

	//break;

        return $result;

	

}
	//------------------------------------------------------------------------------------------------------
	/* 
	
	
									door delivery
	
	
	*/
	
	
	
//--------------------------------#######----door delivery----#######------------------------------------------
	function get_doorrate_pc($pid)

	{

		$this->db->select("*");

        $this->db->from('door_delivery_rate');

		$this->db->where('door_delivery_status',1);

		$this->db->where('door_delivery_port_id',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}
	
	
	function get_doorratefu($id)

	{

		$query = $this->db->query("SELECT * FROM `door_delivery_rate` WHERE `door_delivery_port_id` IS NULL or door_delivery_port_id='$id'");

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}
	function add_door_deliveryrate($data)

	{

		$result=$this->db->insert('door_delivery_rate',$data);

		return $result;

	}
	
	function get_doorrate_byid($id)

	{

		$this->db->select('*');

        $this->db->from('door_delivery_rate');

		$this->db->where('door_delivery_rate_id',$id);

		$query = $this->db->get();
//echo $this->db->last_query();exit();
        $result = $query->result_array();

        return $result;

	}
	function update_door_rate($id,$data)

	{

		$this->db->where('door_delivery_rate_id',$id);

		$result		=	$this->db->update('door_delivery_rate',$data);

        return $result;

	}
	function get_zone_door($portid)

{

	$this->db->select('*');

        $this->db->from('door_kadavu');
		$this->db->join('zone','door_kadavu.door_zone_id=zone.zone_id');
		$this->db->where('door_port_id',$portid);
		$query = $this->db->get();
	//echo	$this->db->last_query(); 

	//	exit();
        $result = $query->result_array();
        return $result;
}
	
	
	function get_spotbookinglist_nw($tokennumnber,$aadharnumber,$zone_id)

	{

	$cudate=date('Y-m-d');

$this->db->select('*');

        $this->db->from('tbl_spotbooking');

		$this->db->join('transaction_details', 'transaction_details.token_no=tbl_spotbooking.spot_token');

		$this->db->where('tbl_spotbooking.spot_token', $tokennumnber);

		$this->db->where('tbl_spotbooking.spot_adhaar', $aadharnumber);

		$this->db->where('tbl_spotbooking.spot_alloted',$cudate);

		$this->db->where('transaction_details.zone_id', $zone_id);

		$this->db->where('transaction_details.transaction_status', 1);
		$this->db->where('tbl_spotbooking.spot_booking_type', 2);

		$query = $this->db->get();

  // echo	$this->db->last_query();

   //exit();

		$result = $query->result_array();

        return $result;

	}	
//##################################################################################################
	//-----------------------------------------------------------------------------------------
	#
	#
	#                    O N L I N E     P A Y M E N T --- S P O T
	#
	#
	//-----------------------------------------------------------------------------------------
	function onlinepay_detailsspot($bookingid)
{
	$this->db->select('*');
       $this->db->from('tbl_spotbooking_temp');
	   		$this->db->join('transaction_details', 'tbl_spotbooking_temp.spot_token = transaction_details.token_no');
		$this->db->where('spotreg_id', $bookingid);
		//$this->db->where('customer_booking_decission_status', 2);
		$this->db->where('transaction_status', 0);
		$query = $this->db->get();
		//echo	$this->db->last_query(); 
		//exit();
		$result = $query->result_array();
        return $result;
		
}
	function onlinetrans_detailsspot($bookingid)
{
	$this->db->select('*');
       $this->db->from('bank_transactionnw');
	   $this->db->join('tbl_spotbooking_temp', 'bank_transactionnw.token_no = tbl_spotbooking_temp.spot_token');
		$this->db->where('bank_transaction_id', $bookingid);
		$this->db->where('transaction_status', 1);
		$query = $this->db->get();
		//echo	$this->db->last_query(); 
	//	exit();
		$result = $query->result_array();
        return $result;
		
}
	//---------------------------------------------------------------------------------
	function customerbookingsearch($trsnsid,$portid)

	{
		
		$this->db->select('*');
        $this->db->from('tbl_spotbooking');
		$this->db->join('transaction_details', 'tbl_spotbooking.spot_token = transaction_details.token_no');
		 $this->db->join('bank_transactionnw', 'bank_transactionnw.token_no = transaction_details.token_no');
		$this->db->where('bank_transactionnw.customer_registration_id', 0);
		$this->db->where('bank_transactionnw.transaction_id', $trsnsid);
		$this->db->where('transaction_details.port_id', $portid);
		//$this->db->where('transaction_details.transaction_status', 1);


		$query = $this->db->get();

		//echo	$this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

	}
	//---------------------------------------------------------------------------------
	
}

?>