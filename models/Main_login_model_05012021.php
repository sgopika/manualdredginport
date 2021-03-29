<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Main_login_model extends CI_Model

{

    function __construct()

    {

        // Call the Model constructor

        parent::__construct();

    }

	function booking_approval_addVw_new($id,$portid)

{

		$this->db->select('customer_booking.customer_booking_request_ton,customer_registration.port_id,customer_registration.customer_unused_ton,customer_booking.customer_booking_monthly_permit_id,customer_booking.customer_booking_requested_timestamp,customer_booking.customer_booking_zone_id,customer_booking.customer_booking_route,customer_booking.customer_booking_distance,customer_booking.customer_booking_id,customer_registration.customer_name,customer_registration.customer_phone_number,customer_registration.customer_max_allotted_ton,customer_registration.customer_registration_id');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_booking.customer_booking_id',$id);

		$this->db->where('customer_booking.customer_booking_decission_status',0);

		$this->db->where('customer_booking.customer_booking_port_id',$portid);

		//$this->db->where('customer_booking.customer_booking_decission_status<>', 2);

		$query = $this->db->get();

		//echo $this->db->last_query();

		$result = $query->result_array();

        return $result;

}

	function bookingapprovalzone_new($zoneid)

	{

	//$sql="select * from customer_booking join customer_registration on customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id where customer_booking_decission_user=0 and customer_booking_decission_status<> 2 and customer_booking_zone_id='$zoneid' order by  customer_booking_priority_number ASC LIMIT 0,100";

		/*$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_booking_decission_user',0);

		$this->db->where('customer_booking_decission_status<>', 2);

		$this->db->where('customer_booking_zone_id', $zoneid);

		$this->db->order_by('customer_booking_priority_number','asc');*/

		$query = $this->db->query("select customer_booking.customer_booking_id,customer_booking.customer_booking_decission_status,customer_booking.customer_booking_requested_timestamp,customer_booking.customer_booking_request_ton,customer_booking.customer_booking_registration_id,customer_registration.customer_phone_number,customer_registration.customer_permit_number,customer_registration.customer_name from customer_booking join customer_registration on customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id where customer_booking_decission_status=0 and customer_booking_zone_id='$zoneid' order by  customer_booking_priority_number ASC LIMIT 0,50");

		//echo $this->db->last_query();//exit();

		$result = $query->result_array();

        return $result;

	}

	function get_all_buk_his_by_sandbuk($id,$zone_id,$sdate,$endate)

	{

		$this->db->select('customer_registration.customer_name,customer_registration.customer_phone_number,customer_booking.customer_booking_requested_timestamp,customer_booking.customer_booking_request_ton,customer_booking.customer_booking_token_number,customer_booking.customer_booking_priority_number,customer_booking.customer_booking_allotted_date,customer_booking.customer_booking_decission_status,customer_booking.customer_booking_pass_issue_user,customer_booking.customer_booking_id,customer_booking.customer_booking_chalan_amount');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration','customer_registration.customer_registration_id=customer_booking.customer_booking_registration_id');

		//$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=customer_booking.customer_booking_port_id');

		//$this->db->join('zone','zone.zone_id=customer_booking.customer_booking_zone_id');

		$this->db->where('customer_booking.customer_booking_port_id',$id);

		$this->db->where('customer_booking.customer_booking_zone_id',$zone_id);

		$this->db->where('customer_booking.customer_booking_allotted_date>',$sdate);

		$this->db->where('customer_booking.customer_booking_allotted_date<=',$endate);

		$this->db->order_by('customer_booking.customer_booking_priority_number','asc');

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

		//echo $this->db->last_query();//exit;

        return $result;

	}



	///// Zone Holi ADDD

	function get_cus_buk_ch_modi($id)

	{

		$this->db->select('customer_booking_port_id,customer_booking_monthly_permit_id,customer_booking_request_ton,customer_booking_token_number,customer_booking_zone_id,customer_booking_chalan_amount');

        $this->db->from('customer_booking');

	//	$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		//$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=customer_booking.customer_booking_port_id');

		//$this->db->join('zone','zone.zone_id=customer_booking.customer_booking_zone_id');

		$this->db->where('customer_booking_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

	}

	

	function reject_monthly_permit_new($port_id,$zone_id,$period_name)

	{

		$this->db->where('monthly_permit_period_name',$period_name);

		$this->db->where('port_id',$port_id);

		$this->db->where('zone_id',$port_id);

		$data=array('monthly_permit_permit_status'=>3);

		$result	= $this->db->update('monthly_permit',$data);

        return $result;

	}  

	function decrement_working_daysnew($period_name,$port_id,$zone_id){

		$this->db->where('holiday_port_period_name', $period_name);

		$this->db->where('holiday_port_port_id', $port_id);

		$this->db->where('holiday_port_zone_id', $zone_id);

		$this->db->set('working_days', 'working_days-1',FALSE);

		$res=$this->db->update('holiday_port');

		//echo $this->db->last_query();exit;

		return $res;

}

	function delete_holiday_by_datenew($period_name,$port_id,$date,$zone_id)

	{

		$this->db->where('holiday_period_name', $period_name);

		$this->db->where('holiday_port_id', $port_id);

		$this->db->where('holiday_zone_id', $zone_id);

		$this->db->where('holiday_date', $date);

		$this->db->where('holiday_reserve_status','1');

		$result=$this->db->delete('holiday');

		return $result;	

	}

	function get_customerBookingListnew($holiday_date,$port_id,$zone_id)

	{

		//$this->db->select('*, COUNT(customer_booking_lsg_section_id) as total');

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_decission_status',2);

		$this->db->where('customer_booking_current_status',1);

		$this->db->where('customer_booking_allotted_date',$holiday_date);

		$this->db->where('customer_booking_port_id',$port_id);

		$this->db->where('customer_booking_zone_id',$zone_id);

		//$this->db->group_by(array('customer_booking_id','customer_booking_lsg_section_id'));

		$this->db->order_by('customer_booking_priority_number');

		$query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

        return $result;

	}

	function get_holiday_by_periodnamenew($period_name,$port_id,$zone_id){

		$this->db->select('*');

        $this->db->from('holiday_port');

		$this->db->where('holiday_port_period_name',$period_name);

		$this->db->where('holiday_port_port_id',$port_id);

		$this->db->where('holiday_port_zone_id',$zone_id);

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	

	function get_holiday_by_datenew($period_name,$port_id,$zone_id,$holiday_date){

		

		$this->db->select('*');

        $this->db->from('holiday');

		$this->db->where('holiday_period_name',$period_name);

		$this->db->where('holiday_port_id',$port_id);

		$this->db->where('holiday_zone_id',$zone_id);

		$this->db->where('holiday_date',$holiday_date);

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function delete_holiday_by_periodnamenew($period_name,$port_id,$zone_id){

		$this->db->where('holiday_period_name', $period_name);

		$this->db->where('holiday_port_id', $port_id);

		$this->db->where('holiday_zone_id', $zone_id);

		$result=$this->db->delete('holiday');

		return $result;	

	}

	function delete_holiday_port_by_periodnamenew($period_name,$port_id,$zone_id){

		$this->db->where('holiday_port_period_name', $period_name);

		$this->db->where('holiday_port_port_id', $port_id);

		$this->db->where('holiday_port_zone_id', $zone_id);

		$this->db->delete('holiday_port');

		return 1;	

	}

	function get_holidaylist_by_periodnamenew($port_id,$zone_id,$period_name){

		$this->db->select('*');

        $this->db->from('holiday');

		//$this->db->or_where('holiday_reserve_status',1);

		$this->db->where('holiday_period_name',$period_name);

		$this->db->where('holiday_port_id',$port_id);

		$this->db->where('holiday_zone_id',$zone_id);

		//$this->db->where('holiday_status',1);

        $query = $this->db->get();

	//echo $this->db->last_query();

	//exit;

	//break;

        $result = $query->result_array();

		return $result;

	}

	function get_period_holidays_listnew($sess_usr_id){

		$this->db->select('*');

        $this->db->from('holiday');

		$this->db->join('zone','zone.zone_port_id=holiday.holiday_port_id and zone.zone_id=holiday.holiday_zone_id');

		$this->db->where('holiday_user_id',$sess_usr_id);

		$this->db->where('zone_status',1);

		$this->db->group_by('holiday_zone_id');

		$this->db->group_by('holiday_period_name');

		//$this->db->order_by('holiday_date');

		$this->db->order_by('holiday_id','DESC');

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_montly_permit_by_periodnew($period_name,$port_id,$zone_id){

		$this->db->select('*');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_period_name',$period_name);

		$this->db->where('port_id',$port_id);

		$this->db->where('zone_id',$zone_id);

		//$this->db->where('monthly_permit_permit_status','IN(1,2)');

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_port_holiday_statusnew($port_id,$zone_id,$period_name){

		$this->db->select('holiday_port_status');

        $this->db->from('holiday_port');

		$this->db->where('holiday_port_port_id',$port_id);

		$this->db->where('holiday_port_zone_id',$zone_id);

		$this->db->where('holiday_port_period_name',$period_name);

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_monthly_working_daysnew($port_id,$zone_id,$holiday_port_period_name){

		$this->db->select('working_days');

        $this->db->from('holiday_port');

		$this->db->where('holiday_port_port_id',$port_id);

		$this->db->where('holiday_port_zone_id',$zone_id);

		$this->db->where('holiday_port_period_name',$holiday_port_period_name);

        $query = $this->db->get();

        $result = $query->row_array();

	//echo $this->db->last_query();

		//exit;

		//break;

		return $result;

	}

	function get_holiday($port_id,$zone_id,$period_name,$holidaydate)

	{

		$this->db->select('*');

        $this->db->from('holiday');

		//$this->db->or_where('holiday_reserve_status',1);

		$this->db->where('holiday_period_name',$period_name);

		$this->db->where('holiday_port_id',$port_id);

		$this->db->where('holiday_zone_id',$zone_id);

		$this->db->where('holiday_date <=' ,$holidaydate);

		$this->db->where('holiday_status',1);

        $query = $this->db->get();

		//echo $this->db->last_query();break;

        $result = $query->result_array();

		return $result;

		

	}

	function get_monthly_permit_detailsnew($portid,$zoneid,$periodname)

	{

		$this->db->select('*');

        $this->db->from('monthly_permit');

		$this->db->where('port_id',$portid);

		$this->db->where('zone_id',$zoneid);

		$this->db->where('monthly_permit_period_name',$periodname);

		$this->db->where('monthly_permit_permit_status !=', 3);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

		//print_r($result);

        return $result;

	}

	

	

	

	

	///////Zone Holi END

	

	function customerapprovalnew($custaadhar,$portid)

	{
		
 		$checkleng=strlen($custaadhar);
		if($checkleng==12)
		{
			$sql="customer_registration.customer_aadhar_number='$custaadhar'";
			
		}
		else
		{
			$sql="customer_registration.customer_reg_no='$custaadhar'";
		}
		$query= $this->db->query("select * from customer_registration left join user_master on customer_registration.customer_public_user_id=user_master.user_master_id where  $sql and port_id='$portid'");

        $result = $query->result_array();
		//echo $this->db->last_query(); exit();
		return $result;

	}
function customerbookingsearch($tokeno,$portid)

	{
		
		$this->db->select('*');

        $this->db->from('customer_booking');
		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');
		$this->db->where('customer_booking.customer_booking_token_number', $tokeno);
		$this->db->where('customer_booking.customer_booking_port_id', $portid);


		$query = $this->db->get();

		//echo	$this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

	}
	
	
	
	function san_reqacustom_totand($p_id)

	{

		$this->db->select('SUM(customer_booking_request_ton) as totsreqa');

        $this->db->from('customer_booking');

		//$this->db->where('customer_booking_period_name',$period);

		$this->db->where('customer_booking_port_id',$p_id);

		$this->db->where('customer_booking_decission_status!=',0);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	public function daily_log_dates($port_id,$zone_id,$period)

	{

		$this->db->select('*');

        $this->db->from('daily_log');

		$this->db->where('daily_log_permit_id',$period);

		$this->db->where('daily_log_port_id',$port_id);

		$this->db->where('daily_log_zone_id',$zone_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	public function get_permit_id($zone_id,$period)

	{

		$this->db->select('monthly_permit_id');

        $this->db->from('monthly_permit');

		//$this->db->where('customer_booking_period_name',$period);

		//$this->db->where('customer_booking_port_id',$p_id);

		$this->db->where('zone_id',$zone_id);

		$this->db->where('monthly_permit_period_name',$period);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	public function get_permit_totsand($port_id,$zone_id,$period)

	{

		$this->db->select('SUM(daily_log_total) as sumtot');

        $this->db->from('daily_log');

		//$this->db->where('customer_booking_period_name',$period);

		//$this->db->where('customer_booking_port_id',$p_id);

		$this->db->where('daily_log_permit_id',$period);

		$this->db->where('daily_log_port_id',$port_id);

		$this->db->where('daily_log_zone_id',$zone_id);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function pd_sam()

	{

		$this->db->select('SUM(customer_booking_request_ton) as totsreqa');

        $this->db->from('customer_booking');

		//$this->db->where('customer_booking_period_name',$period);

		//$this->db->where('customer_booking_port_id',$p_id);

		$this->db->where('customer_booking_decission_status!=',0);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function tot_working_days($period){

		$this->db->select('working_days');

        $this->db->from('holiday_port');

		$this->db->where('holiday_port_status',1);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('holiday_port_period_name',$period);

		$query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

        return $result;

		

	}

	function tot_permit_aprvd($port_id){

		$this->db->select('COUNT(*) as permit_aprvd');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_permit_status',2);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('port_id',$port_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

	}

	function tot_permit_pend($port_id){

		$this->db->select('COUNT(*) as permit_pend');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_permit_status',1);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('port_id',$port_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

	}

	function pd_tot_buk(){

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('customer_booking');

		//$this->db->where('monthly_permit_permit_status',1);

		//$this->db->where('user_master.user_master_password',$pw);

		//$this->db->where('port_id',$port_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

	}

	function pd_tot_buk_ap(){

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('customer_booking');

		//$this->db->where('monthly_permit_permit_status',1);

		//$this->db->where('user_master.user_master_password',$pw);

		//$this->db->where('port_id',$port_id);

		$this->db->where('customer_booking_decission_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

	}

	function pd_tot_buk_si(){

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('customer_booking');

		//$this->db->where('monthly_permit_permit_status',1);

		//$this->db->where('user_master.user_master_password',$pw);

		//$this->db->where('port_id',$port_id);

		$this->db->where('customer_booking_decission_status',2);

		$this->db->where('customer_booking_pass_issue_user !=',0);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

	}

	function san_reqacustom_totspen($p_id)

	{

		$this->db->select('SUM(customer_booking_request_ton) as totsreqa');

        $this->db->from('customer_booking');

		//$this->db->where('customer_booking_period_name',$period);

		$this->db->where('customer_booking_port_id',$p_id);

		$this->db->where('customer_booking_pass_issue_user !=',0);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function pd_si()

	{

		$this->db->select('SUM(customer_booking_request_ton) as totsreqa');

        $this->db->from('customer_booking');

		//$this->db->where('customer_booking_period_name',$period);

		//$this->db->where('customer_booking_port_id',$p_id);

		$this->db->where('customer_booking_pass_issue_user !=',0);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function totcus_reg($pid)

	{

		$this->db->select('COUNT(*) as totcreq');

        $this->db->from('customer_registration');

		$this->db->where('customer_public_user_id',0);

		$this->db->where('port_id',$pid);

		$this->db->where('customer_request_status',1);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function san_reqacustom_pcs($p_id)

	{

		$this->db->select('COUNT(*) as totsreqa');

        $this->db->from('customer_booking');

		//$this->db->where('customer_booking_period_name',$period);

		$this->db->where('customer_booking_port_id',$p_id);

		$this->db->where('customer_booking_pass_issue_user !=',0);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function san_reqacustom_pch($p_id)

	{

		$this->db->select('COUNT(*) as totsreqa');

        $this->db->from('customer_booking');

		//$this->db->where('customer_booking_period_name',$period);

		$this->db->where('customer_booking_port_id',$p_id);

		$this->db->where('customer_booking_decission_status!=',0);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function police_ge($pid)

	{

		$this->db->select('COUNT(*) as totcase');

        $this->db->from('police_case');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('police_case_port_id',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function tot_buk_pen($pid)

	{

		$this->db->select('COUNT(*) as totbpen');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_decission_status',0);

		$this->db->where('customer_booking_port_id',$pid);

		//$this->db->where('monthly_permit_permit_status',1);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function get_tran_det($id)

{

		$this->db->select('*');

        $this->db->from('transaction_details');

		$this->db->where('transaction_customer_booking_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

	function login($un)

	{

		$this->db->select('*');

        $this->db->from('user_master');

		$this->db->where('user_master_name',$un);

		//$this->db->where('user_master_password',$pw);

		$this->db->where('user_master_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function loginlogcheck($ipaddress,$time)

	{
		//$result =$this->db->query("select * from loginlogs where TryTime > '$time' and IpAddress = '$ipaddress'");
		$this->db->select('*');

        $this->db->from('loginlogs');

		$this->db->where('TryTime >',$time);

		$this->db->where('IpAddress',$ipaddress);

		
		$query = $this->db->get();
		//echo $this->db->last_query(); 

       $result = $query->result_array();
      print_r($result);
      //  exit();

        return $result;

	}

	function save_loginlogs($data)

	{

		$result=$this->db->insert('loginlogs',$data);

		return $result;

	}
	function del_loginlogs($ipaddress)

	{
		$this->db->where('IpAddress', $ipaddress);
		$result=$this->db->delete('loginlogs');

		return $result;

	}




		//CHART //

	function sum_amt($id)

	{

		$this->db->select('SUM(payment_amount) as totsum');

        $this->db->from('payment');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('payment_head',$id);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function sum_amt_pc($id,$pid)

	{

		$this->db->select('SUM(payment_amount) as totsum');

        $this->db->from('payment');

		//$this->db->where('user_id',$uid);

		$this->db->where('payment_port_id',$pid);

		$this->db->where('payment_head',$id);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function sum_amt_new($id,$port_id,$p_name,$z_id)

	{

		$this->db->select('SUM(payment_amount) as totsum');

        $this->db->from('payment');

		$this->db->join('customer_booking', 'payment.payment_booking_id = customer_booking.customer_booking_id');

		//$this->db->where('user_id',$uid);

		$this->db->where('payment.payment_port_id',$port_id);

		if($z_id!=0)

		{

			$this->db->where('payment.payment_zone_id',$z_id);

		}

		$this->db->where('customer_booking.customer_booking_period_name',$p_name);

		$this->db->where('payment.payment_head',$id);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function sum_amt_new_pc($id,$port_id,$p_name)

	{

		$this->db->select('SUM(payment_amount) as totsum');

        $this->db->from('payment');

		$this->db->join('customer_booking', 'payment.payment_booking_id = customer_booking.customer_booking_id');

		//$this->db->where('user_id',$uid);

		$this->db->where('payment.payment_zone_id',$port_id);

		$this->db->where('customer_booking.customer_booking_period_name',$p_name);

		$this->db->where('payment.payment_head',$id);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function permit_req()

	{

		$this->db->select('COUNT(*) as totreq');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		//$this->db->where('monthly_permit_permit_status',1);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function permit_req_pc($pid)

	{

		$this->db->select('COUNT(*) as totreq');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('port_id',$pid);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function bal_sand_pc($pid)

	{

		$this->db->select('SUM(monthly_permit_balance_ton) as balsand');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		//$this->db->where('customer_booking_pass_issue_user !=','');

		$this->db->where('port_id',$pid);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function permit_reqcustom($p_id,$period,$z_id)

	{

		$this->db->select('COUNT(*) as totreq');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

		$this->db->where('port_id',$p_id);

		$this->db->where('monthly_permit_period_name',$period);

		if($z_id!=0)

		{

			$this->db->where('zone_id',$z_id);

		}

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function permit_reqcustom_pc($p_id,$period)

	{

		$this->db->select('COUNT(*) as totreq');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

		$this->db->where('zone_id',$p_id);

		$this->db->where('monthly_permit_period_name',$period);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function permit_reqAp()

	{

		$this->db->select('COUNT(*) as totreqa');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		//$this->db->where('port_id',$p_id);

		$this->db->where('monthly_permit_permit_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function permit_reqAp_pc($p_id)

	{

		$this->db->select('COUNT(*) as totreqa');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('port_id',$p_id);

		$this->db->where('monthly_permit_permit_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function permit_reqApcustom($p_id,$period,$z_id)

	{

		$this->db->select('COUNT(*) as totreqa');

        $this->db->from('monthly_permit');

		$this->db->where('port_id',$p_id);

		$this->db->where('monthly_permit_period_name',$period);

		if($z_id!=0)

		{

			$this->db->where('zone_id',$z_id);

		}

		$this->db->where('monthly_permit_permit_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function permit_reqApcustom_pc($p_id,$period)

	{

		$this->db->select('COUNT(*) as totreqa');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_period_name',$period);

		$this->db->where('zone_id',$p_id);

		$this->db->where('monthly_permit_permit_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function permit_reqApfor($p)

	{

		$this->db->select('COUNT(*) as totsreq');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_period_name',$p);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function permit_reqApfor_pc($p,$pid)

	{

		$this->db->select('COUNT(*) as totsreq');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_period_name',$p);

		$this->db->where('customer_booking_port_id	',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function permit_reqApforcustom($pid,$p,$zid)

	{

		$this->db->select('COUNT(*) as totsreq');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_port_id',$pid);

		if($zid!=0)

		{

			$this->db->where('customer_booking_zone_id',$zid);

		}

		$this->db->where('customer_booking_period_name',$p);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function permit_reqApforcustom_pc($pid,$p)

	{

		$this->db->select('COUNT(*) as totsreq');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_zone_id',$pid);

		$this->db->where('customer_booking_period_name',$p);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function bal_sandcustom($p_id,$period,$z_id)

	{

		$this->db->select('SUM(monthly_permit_balance_ton) as balsand');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_period_name',$period);

		if($z_id!=0)

		{

			$this->db->where('zone_id',$z_id);

		}

		$this->db->where('monthly_permit_permit_status',2);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function bal_sandcustom_pc($p_id,$period)

	{

		$this->db->select('SUM(monthly_permit_balance_ton) as balsand');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_period_name',$period);

		$this->db->where('zone_id',$p_id);

		$this->db->where('monthly_permit_permit_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function san_req()

	{

		$this->db->select('COUNT(*) as totsreq');

        $this->db->from('customer_booking');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function san_req_pc($pid)

	{

		$this->db->select('COUNT(*) as totsreq');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_port_id',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function san_reqcustom($p_id,$period,$z_id)

	{

		$this->db->select('COUNT(*) as totsreq');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		$this->db->where('customer_booking_port_id',$p_id);

		if($z_id!=0)

		{

			$this->db->where('customer_booking_zone_id',$z_id);

		}

		$this->db->where('customer_booking_period_name',$period);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function san_reqcustom_pc($p_id,$period)

	{

		$this->db->select('COUNT(*) as totsreq');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		$this->db->where('customer_booking_zone_id',$p_id);

		$this->db->where('customer_booking_period_name',$period);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function san_reqacustom($p_id,$period,$z_id)

	{

		$this->db->select('COUNT(*) as totsreqa');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_port_id',$p_id);

		$this->db->where('customer_booking_period_name',$period);

		if($z_id!=0)

		{

			$this->db->where('customer_booking_zone_id',$z_id);

		}

		$this->db->where('customer_booking_decission_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function san_reqacustom_pc($p_id,$period)

	{

		$this->db->select('COUNT(*) as totsreqa');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_period_name',$period);

		$this->db->where('customer_booking_zone_id',$p_id);

		$this->db->where('customer_booking_decission_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function san_reqrcustom($p_id,$period,$z_id)

	{

		$this->db->select('COUNT(*) as totsreqr');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_port_id',$p_id);

		$this->db->where('customer_booking_period_name',$period);

		if($z_id!=0)

		{

			$this->db->where('customer_booking_zone_id',$z_id);

		}

		$this->db->where('customer_booking_decission_status',3);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function san_reqrcustom_pc($p_id,$period)

	{

		$this->db->select('COUNT(*) as totsreqr');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_period_name',$period);

		$this->db->where('customer_booking_zone_id',$p_id);

		$this->db->where('customer_booking_decission_status',3);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function tot_sand_passcustom($p_id,$period,$z_id)

	{

		$this->db->select('COUNT(*) as totspass');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_port_id',$p_id);

		$this->db->where('customer_booking_period_name',$period);

		if($z_id!=0)

		{

			$this->db->where('customer_booking_zone_id',$z_id);

		}

		$this->db->where('customer_booking_pass_issue_user !=','');

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function tot_sand_passcustom_pc($p_id,$period)

	{

		$this->db->select('COUNT(*) as totspass');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_period_name',$period);

		$this->db->where('customer_booking_zone_id',$p_id);

		$this->db->where('customer_booking_pass_issue_user !=','');

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function san_reqa_pc($pid)

	{

		$this->db->select('COUNT(*) as totsreqa');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_port_id',$pid);

		$this->db->where('customer_booking_decission_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function san_reqr_pc($pid)

	{

		$this->db->select('COUNT(*) as totsreqr');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_port_id',$pid);

		$this->db->where('customer_booking_decission_status',3);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function tot_sand_pass_pc($pid)

	{

		$this->db->select('COUNT(*) as totspass');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_port_id',$pid);

		$this->db->where('customer_booking_pass_issue_user !=','');

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function san_reqa()

	{

		$this->db->select('COUNT(*) as totsreqa');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_decission_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_all_user($id)

	{

		$this->db->select('*');

        $this->db->from('user_master');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('user_master_id !=',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function san_reqr()

	{

		$this->db->select('COUNT(*) as totsreqr');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_decission_status',3);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function tot_sand_passfor($p)

	{

		$this->db->select('COUNT(*) as totspass');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		$this->db->where('customer_booking_period_name',$p);

		$this->db->where('customer_booking_pass_issue_user !=','');

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function tot_sand_passfor_pc($p,$pid)

	{

		$this->db->select('COUNT(*) as totspass');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		$this->db->where('customer_booking_period_name',$p);

		$this->db->where('customer_booking_port_id',$pid);

		$this->db->where('customer_booking_pass_issue_user !=','');

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function tot_sand_passforcustom($pid,$p,$zid)

	{

		$this->db->select('COUNT(*) as totspass');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		$this->db->where('customer_booking_port_id',$pid);

		if($zid!=0)

		{

			$this->db->where('customer_booking_zone_id',$zid);

		}

		$this->db->where('customer_booking_period_name',$p);

		$this->db->where('customer_booking_pass_issue_user !=','');

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function tot_sand_passforcustom_pc($pid,$p)

	{

		$this->db->select('COUNT(*) as totspass');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		$this->db->where('customer_booking_zone_id',$pid);

		$this->db->where('customer_booking_period_name',$p);

		$this->db->where('customer_booking_pass_issue_user !=','');

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function tot_sand_pass()

	{

		$this->db->select('COUNT(*) as totspass');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_pass_issue_user !=','');

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function tot_msg_unread($uid)

	{

		$this->db->select('COUNT(*) as totnew');

        $this->db->from('tbl_mailbox');

		//$this->db->where('user_id',$uid);

		$this->db->where('tbl_mailflag',0);

		$this->db->where('tbl_to',$uid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function bal_sand()

	{

		$this->db->select('SUM(monthly_permit_balance_ton) as balsand');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		//$this->db->where('customer_booking_pass_issue_user !=','');

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	//Chart//

	function getuserlog($uid)

	{

		$this->db->select('*');

        $this->db->from('tbl_userlog');

		$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$query = $this->db->get();

        $result = $this->db->affected_rows();

        return $result;

	}

	function getsentitem($uid)

	{

		$this->db->select('*');

        $this->db->from('tbl_mailbox');

		$this->db->join('user_master', 'tbl_mailbox.tbl_to = user_master.user_master_id');

		$this->db->where('tbl_mailbox.tbl_from',$uid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function getrecditem($uid)

	{

		$this->db->select('*');

        $this->db->from('tbl_mailbox');

		$this->db->join('user_master', 'tbl_mailbox.tbl_from = user_master.user_master_id');

		$this->db->where('tbl_mailbox.tbl_to',$uid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function readmsg($uid)

	{

		$this->db->select('*');

        $this->db->from('tbl_mailbox');

		$this->db->join('user_master', 'tbl_mailbox.tbl_from = user_master.user_master_id');

		$this->db->where('tbl_mailbox.tbl_inboxid',$uid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function getuserdetails($un)

	{

		$this->db->select('*');

        $this->db->from('user_master');

		$this->db->join('user_type', 'user_master.user_master_id_user_type = user_type.user_type_id');

		$this->db->where('user_master.user_master_name',$un);

		//$this->db->where('user_master.user_master_password',$pw);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function getuserdetailsforheader($uid)

	{ 

		$res=$this->db->query("select user_master_id_user_type as utype, user_master_name as uname from user_master where user_master_id='$uid'");

		$r=$res->result_array();

		$utyp=$r[0]['utype'];

		$this->db->select('*');

        $this->db->from('user_master');

		$this->db->join('user_type', 'user_master.user_master_id_user_type = user_type.user_type_id');

		if($utyp==5)

		{

			$this->db->join('customer_registration', 'user_master.user_master_id = customer_registration.customer_public_user_id');

		}

		$this->db->where('user_master.user_master_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function chk_usr($un)

	{

		$this->db->select('*');

        $this->db->from('user_master');

		//$this->db->join('user_type', 'user_master.user_master_id_user_type = user_type.user_type_id');

		$this->db->where('user_master_name',$un);

		//$this->db->where('user_master.user_master_password',$pw);

		$query = $this->db->get();

        $result = $this->db->affected_rows();

        return $result;

	}

	function getzonelsged($id)

	{

		$this->db->select('*');

        $this->db->from('lsg_zone');

		$this->db->join('lsgd', 'lsgd.lsgd_id = lsg_zone.lsg_id');

		$this->db->join('zone', 'zone.zone_id = lsg_zone.zone_id');

		$this->db->where('lsg_zone.lsg_zone_id',$id);

		//$this->db->where('user_master.user_master_password',$pw);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function getuserinfo($uid)

	{

		$this->db->select('*');

        $this->db->from('user_master');

		$this->db->where('user_master_id',$uid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function add_zone($data)

	{

		$result=$this->db->insert('zone',$data);

		return $result;

	}

	function save_userlog($data)

	{

		$result=$this->db->insert('tbl_userlog',$data);

		return $result;

	}

	function update_userlog($sess_usr_id,$login_time,$logout_time)

	{

		$result=$this->db->query("update tbl_userlog set logout='$logout_time' where user_id=$sess_usr_id and login='$login_time'");

		return $result;

	}

	function add_lsgd($data)

	{

		$result=$this->db->insert('lsgd',$data);

		return $result;

	}

	function save_mail($data)

	{

		$result=$this->db->insert('tbl_mailbox',$data);

		return $result;

	}

	function police_case_add($data)

	{

		$result=$this->db->insert('police_case',$data);

		return $result;

	}

	function add_material($data)

	{

		$result=$this->db->insert('material_master',$data);

		return $result;

	}

	function add_material_rate_state($data)

	{

		$result=$this->db->insert('materialrate_state',$data);

		return $result;

	}

	function add_trans_det($data)

	{

		$result=$this->db->insert('transaction_details',$data);

		return $result;

	}

	//add_material_rate_state

	function add_taxrate_calc($data)

	{

		$result=$this->db->insert('tax_calculator',$data);

		return $result;

	}

	function add_material_rate($data)

	{

		$result=$this->db->insert('materialrate',$data);

		return $result;

	}

	function add_bank($data)

	{

		$result=$this->db->insert('bank',$data);

		return $result;

	}

	function add_qunatity_master($data)

	{

		$result=$this->db->insert('quantity_master',$data);

		return $result;

	}

	function add_taxname_master($data)

	{

		$result=$this->db->insert('taxname_master',$data);

		return $result;

	}

	function add_construction_master($data)

	{

		$result=$this->db->insert('construction_master',$data);

		return $result;

	}

	function add_plintharea_master($data)

	{

		$result=$this->db->insert('plintharea_master',$data);

		return $result;

	}

	function add_workqty_master($data)

	{

		$result=$this->db->insert('worker_quantity',$data);

		return $result;

	}

	function add_quantity_pc($data)

	{

		$result=$this->db->insert('quantity',$data);

		return $result;

	}

	function add_zone_lsg($data)

	{

		$result=$this->db->insert('lsg_zone',$data);



		return $result;

	}

	function add_cutoff_master($data)

	{

		$result=$this->db->insert('cutoff_master',$data);

		return $result;

	}

	function add_buking_master($data)

	{

		$result=$this->db->insert('booking_master',$data);

		return $result;

	}

	function add_zone_sec($data)

	{

		$result=$this->db->insert('lsg_section',$data);

		return $this->db->insert_id();

		//return $result;

	}

	function add_user_login($data)

	{

		$result=$this->db->insert('user_master',$data);

		return $this->db->insert_id();

	}

	function up_lsgsec($data,$lsg_sec_id)

	{

		$this->db->where('lsg_section_id',$lsg_sec_id);

		$result		=	$this->db->update('lsg_section',$data);

        return $result;

	}

	function up_pw($data,$u_id)

	{

		$this->db->where('user_master_id',$u_id);

		$result		=	$this->db->update('user_master',$data);

		//echo $this->db->last_query();break;

        return $result;

	}

	function get_sec_det($id)

	{

		$this->db->select('*');

        $this->db->from('lsg_section');

		$this->db->where('lsg_section_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

        return $result;

	}

	function get_sec_det_pr($id)

	{

		$this->db->select('*');

        $this->db->from('lsg_section');

		$this->db->join('lsgd','lsgd.lsgd_id=lsg_section.lsgd_id');

		$this->db->join('zone','zone.zone_id=lsg_section.zone_id');

		$this->db->join('lsg_zone','lsg_zone.zone_id=lsg_section.zone_id');

		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=lsg_section.port_id');

		//$this->db->join('district','tbl_portoffice_master.int_district_id=district.district_name');

		$this->db->where('lsg_section.lsg_section_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

        return $result;

	}

	function get_quantity()

	{

		$this->db->select('*');

        $this->db->from('quantity');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_monthly_permitByID($id)

	{

		$this->db->select('sand_rate');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_id',$id);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

		//print_r($result);

        return $result;

	}

	function get_cutoff()

	{

		$this->db->select('*');

        $this->db->from('cutoff_master');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_buking()

	{

		$this->db->select('*');

        $this->db->from('booking_master');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zone()

	{

		$this->db->select('*');

        $this->db->from('zone');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zone_ac()

	{

		$this->db->select('*');

        $this->db->from('zone');

		$this->db->where('zone_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zone_acinP($pid)

	{

		$this->db->select('*');

        $this->db->from('zone');

		$this->db->where('zone_port_id',$pid);

		$this->db->where('zone_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_fin_year()

	{

		$this->db->select('*');

        $this->db->from('tbl_financialyear');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_fin_yearbyid($id)

	{

		$this->db->select('*');

        $this->db->from('tbl_financialyear');

		$this->db->where('intFinancialYearID',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_fee_master()

	{

		$this->db->select('*');

        $this->db->from('fee_master');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_assigned_zone()

	{

		$this->db->select('*');

        $this->db->from('lsg_zone');

		$this->db->join('zone', 'lsg_zone.zone_id = zone.zone_id');

		$this->db->join('lsgd', 'lsg_zone.lsg_id  = lsgd.lsgd_id');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_assigned_sec($id)

	{

		$this->db->select('*');

        $this->db->from('lsg_section');

		$this->db->join('zone', 'lsg_section.zone_id = zone.zone_id');

		$this->db->join('lsgd', 'lsg_section.lsgd_id = lsgd.lsgd_id');

		$this->db->where('lsg_section.port_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_assigned_zone_byID($id)

	{

		$this->db->select('*');

        $this->db->from('lsg_zone');

		$this->db->join('zone', 'lsg_zone.zone_id = zone.zone_id');

		$this->db->join('lsgd', 'lsg_zone.lsg_id  = lsgd.lsgd_id');

		$this->db->where('lsg_zone.lsg_zone_port_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zone_byID($id)

	{

		$this->db->select('*');

        $this->db->from('zone');

		$this->db->where('zone_user_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zone_bypID($id)

	{

		$this->db->select('*');

        $this->db->from('zone');

		$this->db->where('zone_port_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zone_bypID_user($id)

	{

		$this->db->select("GROUP_CONCAT(user_master_zone_id) as uzone");

        $this->db->from('user_master');

		$this->db->where('user_master_id_user_type',6);

		$this->db->where('user_master_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();

		//exit; 

        return $result;

	}

	function get_cud_police_byID($id)

	{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_bookingtoken()

	{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_wQ()

	{

		$this->db->select('worker_quantity');

        $this->db->from('worker_quantity');

		$this->db->where('worker_quantity_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zone_NotAs($id)

	{

		$query = $this->db->query("select GROUP_CONCAT(zone.zone_id) as zoneid from zone left join lsg_zone on zone.zone_id=lsg_zone.zone_id where zone.zone_port_id=$id and ((SELECT COUNT('*') from lsg_zone WHERE zone.zone_id=lsg_zone.zone_id and lsg_zone.lsg_zone_status=1)=0)");

       $result = $query->result_array();

        return $result;

	}

	function get_zone_NotAsS($id)

	{

		$query = $this->db->query("select GROUP_CONCAT(lsg_zone.zone_id) as zoneid from lsg_zone left join lsg_section on lsg_zone.zone_id=lsg_section.zone_id where lsg_zone.lsg_zone_port_id=$id and ((SELECT COUNT('*') from lsg_section WHERE lsg_zone.zone_id=lsg_section.zone_id and lsg_section.lsg_section_status=1)=0)");

       $result = $query->result_array();

	  // echo $this->db->last_query();

        return $result;

	}

	function get_taxname_NotAs()

	{

		$query = $this->db->query("select GROUP_CONCAT(taxname_master.taxname_master_id) as taxid from  taxname_master left join  tax_calculator on taxname_master.taxname_master_id=tax_calculator.tax_calculator_taxname_id where  taxname_master.taxname_master_status=1 and((SELECT COUNT('*') from tax_calculator WHERE taxname_master.taxname_master_id=tax_calculator.tax_calculator_taxname_id and tax_calculator.tax_calculator_status=1)=0)");

       $result = $query->result_array();

        return $result;

	}

	function get_lsgd()

	{

		$this->db->select('*');

        $this->db->from('lsgd');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zone_lsg($zone_id)

	{

		$this->db->select('lsgd.lsgd_id,lsgd.lsgd_name,lsgd.lsgd_port_id');

        $this->db->from('lsgd');

		$this->db->join('lsg_zone','lsgd.lsgd_id = lsg_zone.lsg_id');

		$this->db->where('lsg_zone.zone_id',$zone_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_lsgd_byID($id)

	{

		$this->db->select('*');

        $this->db->from('lsgd');

		$this->db->where('lsgd_port_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_lsgd_totqty($lsg_id,$zone_id,$first_date,$second_date)

	{

		$this->db->select('SUM(customer_booking_request_ton) as totton');

        $this->db->from('customer_booking');
		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');
		$this->db->where('transaction_status', 1);
		$this->db->where('print_status', 1);
		$this->db->where('customer_booking_zone_id',$zone_id);

		$this->db->where('customer_booking_lsg_id',$lsg_id);

		$this->db->where('customer_booking_decission_status',2);

		$this->db->where('customer_booking_allotted_date >=', $first_date);

		$this->db->where('customer_booking_allotted_date <=', $second_date);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_lsgd_totVP($lsg_id,$zone_id,$first_date,$second_date)

	{

		$this->db->select('count(*) as nos');

        $this->db->from('customer_booking');
		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');
		$this->db->where('transaction_status', 1);
		$this->db->where('print_status', 1);
		$this->db->where('customer_booking_zone_id',$zone_id);

		$this->db->where('customer_booking_lsg_id',$lsg_id);

		$this->db->where('customer_booking_decission_status',2);

		$this->db->where('customer_booking_allotted_date >=', $first_date);

		$this->db->where('customer_booking_allotted_date <=', $second_date);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_lsgd_totAmt($lsg_id,$zone_id,$first_date,$second_date)

	{

		$this->db->select('SUM(customer_booking_chalan_amount) as amt');

        $this->db->from('customer_booking');
		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');
		$this->db->where('transaction_status', 1);
		$this->db->where('print_status', 1);

		$this->db->where('customer_booking_zone_id',$zone_id);

		$this->db->where('customer_booking_lsg_id',$lsg_id);

		$this->db->where('customer_booking_decission_status',2);

		$this->db->where('customer_booking_allotted_date >=', $first_date);

		$this->db->where('customer_booking_allotted_date <=', $second_date);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zone_bylsgdID($id)

	{

		$this->db->select('GROUP_CONCAT(zone.zone_id) as Zone');

        $this->db->from('lsg_zone');

		$this->db->join('zone','zone.zone_id = lsg_zone.zone_id');

		$this->db->where('lsg_zone.lsg_id',$id);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function get_workercount($zone_id,$lsgd_id)

	{

		$this->db->select('lsg_zone_number_of_workers');

        $this->db->from('lsg_zone');

		$this->db->where('zone_id',$zone_id);

		$this->db->where('lsg_id',$lsgd_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_construction_master()

	{

		$this->db->select('*');

        $this->db->from('construction_master');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function policecase_listById($id)

	{

		$this->db->select('*');

        $this->db->from('police_case');

		$this->db->where('police_case_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_construction_master_ByID($id)

	{

		$this->db->select('*');

        $this->db->from('construction_master');

		$this->db->where('construction_master_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_plintharea_master()

	{

		$this->db->select('*');

        $this->db->from('plintharea_master');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_workerqty_master()

	{

		$this->db->select('*');

        $this->db->from('worker_quantity');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_workerqty_masterByID($id)

	{

		$this->db->select('*');

        $this->db->from('worker_quantity');

		$this->db->where('worker_quantity_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_district()

	{

		$this->db->select('*');

        $this->db->from('district');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_count_login()

	{

		$this->db->select('*');

       	$query = $this->db->query('select count(*) as cnt from user_master');

        $result = $query->result_array();

        return $result;

	}

	function get_quantity_masterPD()

	{

		$this->db->select('*');

        $this->db->from('quantity_master');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_quantity_master()

	{

		$this->db->select('*');

        $this->db->from('quantity_master');

		$this->db->where('quantity_master_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_quantity_masterByID($id)

	{

		$this->db->select('*');

        $this->db->from('quantity_master');

		$this->db->where('quantity_master_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_port()

	{

		$this->db->select('*');

        $this->db->from('tbl_portoffice_master');

		$this->db->where('int_dredge_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_monthly_period()

	{

		$this->db->select('DISTINCT(monthly_permit_period_name)');

        $this->db->from('monthly_permit');

	//	$this->db->where('monthly_permit_period_name',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_port_By_PC($port_id)

	{

		$this->db->select('*');

        $this->db->from('tbl_portoffice_master');

		$this->db->where('int_dredge_status',1);

		$this->db->where('int_portoffice_id',$port_id);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function get_portb()

	{

		$this->db->select('*');

        $this->db->from('tbl_portoffice_master');

		$this->db->where('int_dredge_status',0);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_port_district($port_id)

	{

		$this->db->select('int_district_id');

        $this->db->from('tbl_portoffice_master');

		$this->db->where('int_portoffice_id',$port_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_district_byID($dist_id)

	{

		$this->db->select('*');

        $this->db->from('district');

		$this->db->where('district_id',$dist_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_amount_type()

	{

		$this->db->select('*');

        $this->db->from('amount_type');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_material_master()

	{

		$this->db->select('*');

        $this->db->from('material_master');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_material_master_act()

	{

		$this->db->select('*');

        $this->db->from('material_master');

		$this->db->where('material_master_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_material_masterby_auth($id)

	{

		$this->db->select('*');

        $this->db->from('material_master');

		$this->db->where('material_master_authority',$id);

		$this->db->where('material_master_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_material_master_det($id)

	{

		$this->db->select('*');

        $this->db->from('material_master');

		$this->db->where('material_master_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrate_master()

	{

		$this->db->select('*');

        $this->db->from('materialrate_state');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrate()

	{

		$this->db->select('*');

        $this->db->from('materialrate');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrate_act_pd()

	{

		$this->db->select("GROUP_CONCAT(materialrate_port_material_master_id) as mat_id");

        $this->db->from('materialrate');

		$this->db->where('materialrate_port_status',1);

		$this->db->where('materialrate_domain',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrate_act_pc($pid)

	{

		$this->db->select("GROUP_CONCAT(materialrate_port_material_master_id) as mat_id");

        $this->db->from('materialrate');

		$this->db->where('materialrate_port_status',1);

		$this->db->where('materialrate_domain',2);

		$this->db->where('port_id',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrate_byid($id)

	{

		$this->db->select('*');

        $this->db->from('materialrate');

		$this->db->where('materialrate_port_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrateByMatID($id)

	{

		$this->db->select('*');

        $this->db->from('materialrate');

		$this->db->where('materialrate_port_material_master_id',$id);

		$this->db->where('materialrate_port_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrateByMatID_p($id,$pid)

	{

		$this->db->select('*');

        $this->db->from('materialrate');

		$this->db->where('materialrate_port_material_master_id',$id);

		$this->db->where('materialrate_port_status',1);

		$this->db->where('port_id',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrateByMatIDp($id,$pid)

	{

		$this->db->select('*');

        $this->db->from('materialrate');

		$this->db->where('materialrate_port_material_master_id',$id);

		$this->db->where('materialrate_port_status',1);

		$this->db->where('port_id',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrateByMatIDs($pid,$id,$zone_id)

	{

	   $query=$this->db->query("select * from materialrate where materialrate_port_material_master_id='$id' and port_id=$pid and materialrate_zone LIKE '%$zone_id%'");

		//$query = $this->db->get();

		//echo $this->db->last_query();

		//exit();

        $result = $query->result_array();

        return $result;

	}

	function get_materialratefu($id)

	{

		$query = $this->db->query("SELECT * FROM `materialrate` WHERE `port_id` IS NULL or port_id='$id'");

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrate_masterByID($id)

	{

		$this->db->select('*');

        $this->db->from('materialrate');

		$this->db->where('materialrate_port_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zoneByPID($id)

	{

		$this->db->select('*');

        $this->db->from('zone');

		$this->db->where('zone_user_id',$id);

		$query = $this->db->get();
//echo $this->db->last_query();exit()
        $result = $query->result_array();

        return $result;

	}

	function get_tax_name()

	{

		$this->db->select('*');

        $this->db->from('taxname_master');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_tax_namea()

	{

		$this->db->select('*');

        $this->db->from('taxname_master');

		$this->db->where('taxname_master_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_fee_masterf()

	{

		$this->db->select('*');

        $this->db->from('fee_master');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	/*function get_fee_masterf()

	{

		$this->db->select('*');

        $this->db->from('fee_master');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}*/

	function get_fee_master_edit($id)

	{

		$this->db->select('*');

        $this->db->from('fee_master');

		$this->db->where('fee_master_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_tax_name_ByID($id)

	{

		$this->db->select('*');

        $this->db->from('taxname_master');

		$this->db->where('taxname_master_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_taxrate()

	{

		$this->db->select('*');

        $this->db->from('tax_calculator');

		$this->db->join('taxname_master', 'taxname_master.taxname_master_id = tax_calculator.tax_calculator_taxname_id');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_taxrateByID($id)

	{

		$this->db->select('*');

        $this->db->from('tax_calculator');

		$this->db->where('tax_calculator_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_status()

	{

		$this->db->select('*');

        $this->db->from('status_table');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_bank($port_id)

	{

		$this->db->select('*');

        $this->db->from('bank');

		$this->db->where('bank_port_id',$port_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_lsgd_byPort($port_id)

	{

		$this->db->select('*');

        $this->db->from('lsgd');

		$this->db->where('lsgd_port_id',$port_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_panchayath($dis_id)

	{

		$this->db->select('*');

        $this->db->from('tb_panchayath');

		$this->db->where('panchayath_district_sl',$dis_id);

		$this->db->order_by('panchayath_name', 'asc');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_panchayath_mal($panch_id)

	{

		$this->db->select('*');

        $this->db->from('tb_panchayath');

		$this->db->where('panchayath_sl',$panch_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function policecase_list_byPort($port_id)

	{

		$this->db->select('*');

        $this->db->from('police_case');

		$this->db->where('police_case_port_id',$port_id);

        $query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

	}

	function get_cus_buk()

	{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_decission_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zoneByID($id)

	{

		$this->db->select('*');

        $this->db->from('zone');

		$this->db->where('zone_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zoneBycanID($id)

	{

		$this->db->select('*');

        $this->db->from('lsg_zone');

		$this->db->where('zone_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_matforp($id)

	{

		$this->db->select('GROUP_CONCAT(materialrate_port_material_master_id) as matid');

        $this->db->from('materialrate');

		$this->db->where('materialrate_domain',2);

		$this->db->where('port_id',$id);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function get_zoneBymID($pid,$mat_id)

	{

		$query = $this->db->query("select GROUP_CONCAT(materialrate_zone) as zoneid from materialrate where port_id=$pid and materialrate_port_material_master_id=$mat_id and materialrate_port_status=1");

        $result = $query->result_array();

		//echo $this->db->last_query();

        return $result;

	}

	function get_matforport($id)

	{

		$this->db->select('*');

        $this->db->from('materialrate');

		$this->db->where('materialrate_domain',3);

		$this->db->where('materialrate_port_status',1);

		$this->db->where('port_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_lsg_byid($id)

	{

		$this->db->select('*');

        $this->db->from('lsgd');

		$this->db->where('lsgd_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_port_conserv()

	{

		$this->db->select('*');

        $this->db->from('user_master');

		$this->db->join('tbl_portoffice_master', 'user_master.user_master_port_id = tbl_portoffice_master.int_portoffice_id');

		$this->db->where('user_master_id_user_type',3);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_port_officer()

	{

		$this->db->select('*');

        $this->db->from('user_master');

		$this->db->join('tbl_portoffice_master', 'user_master.user_master_port_id = tbl_portoffice_master.int_portoffice_id');

		$this->db->where('user_master_id_user_type',8);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_user_type()

	{

		$this->db->select('*');

        $this->db->from('user_type');

		//$where='user_type_id=6';

		$where='user_type_id in (6,9)';

		$this->db->where($where);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_port_user($id)

	{

		$this->db->select('*');

        $this->db->from('user_master');

		$this->db->join('tbl_portoffice_master', 'user_master.user_master_port_id = tbl_portoffice_master.int_portoffice_id');

		$where="user_master_port_id=$id and user_master_id_user_type in (6,9)";

		$this->db->where($where);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_quantity_byid($id)

	{

		$this->db->select('*');

        $this->db->from('quantity');

		$this->db->where('quantity_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_quantity_by_pc($port_id)

	{

		$this->db->select('*');

        $this->db->from('quantity');

		$this->db->where('port_id',$port_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_bank_det($id)

	{

		$this->db->select('*');

        $this->db->from('bank');

		$this->db->where('bank_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_plintharea_masterByID($id)

	{

		$this->db->select('*');

        $this->db->from('plintharea_master');

		$this->db->where('plintharea_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_pc_port()

	{

		$query = $this->db->query("select GROUP_CONCAT(tbl_portoffice_master.int_portoffice_id) as port_id from tbl_portoffice_master left join user_master on tbl_portoffice_master.int_portoffice_id=user_master.user_master_port_id where tbl_portoffice_master.int_dredge_status=1 and ((SELECT COUNT('*') from user_master WHERE user_master.user_master_port_id=tbl_portoffice_master.int_portoffice_id and user_master.user_master_status=1)=0)");

       $result = $query->result_array();

	  //echo $this->db->last_query();

        return $result;

	}

	function update_zone($id,$data)

	{

		$this->db->where('zone_id',$id);

		$result		=	$this->db->update('zone',$data);

        return $result;

	}

	function update_lsgd($id,$data)

	{

		$this->db->where('lsgd_id',$id);

		$result		=	$this->db->update('lsgd',$data);

        return $result;

	}

	function update_quantity_pc($id,$data)

	{

		$this->db->where('quantity_id',$id);

		$result		=	$this->db->update('quantity',$data);

        return $result;

	}

	function update_tax_master($id,$data)

	{

		$this->db->where('taxname_master_id',$id);

		$result		=	$this->db->update('taxname_master',$data);

        return $result;

	}

	function update_lsgzone($id,$data)

	{

		$this->db->where('lsg_zone_id',$id);

		$result		=	$this->db->update('lsg_zone',$data);

        return $result;

	}

	function update_bank_pc($id,$data)

	{

		$this->db->where('bank_id',$id);

		$result		=	$this->db->update('bank',$data);

        return $result;

	}

	function update_cutoff($id,$data)

	{

		$this->db->where('cutoff_master_id',$id);

		$result		=	$this->db->update('cutoff_master',$data);

        return $result;

	}

	function update_buking($id,$data)

	{

		$this->db->where('booking_master_id',$id);

		$result		=	$this->db->update('booking_master',$data);

        return $result;

	}

	function update_police_pc($id,$data)

	{

		$this->db->where('police_case_id',$id);

		$result		=	$this->db->update('police_case',$data);

        return $result;

	}

	function update_material_master($id,$data)

	{

		$this->db->where('material_master_id',$id);

		$result		=	$this->db->update('material_master',$data);

        return $result;

	}

	function update_material_rate_master($id,$data)

	{

		$this->db->where('materialrate_port_id',$id);

		$result		=	$this->db->update('materialrate',$data);

        return $result;

	}

	function update_taxrate_calc($id,$data)

	{

		$this->db->where('tax_calculator_id',$id);

		$result		=	$this->db->update('tax_calculator',$data);

        return $result;

	}

	function update_construction_master($id,$data)

	{

		$this->db->where('construction_master_id',$id);

		$result		=	$this->db->update('construction_master',$data);

        return $result;

	}

	function update_plinth_master($id,$data)

	{

		$this->db->where('plintharea_id',$id);

		$result		=	$this->db->update('plintharea_master',$data);

        return $result;

	}

	function update_quantity_master($id,$data)

	{

		$this->db->where('quantity_master_id',$id);

		$result		=	$this->db->update('quantity_master',$data);

		$this->db->last_query();

		//exit();

        return $result;

	}

	function update_worker_quantity($id,$data)

	{

		$this->db->where('worker_quantity_id',$id);

		$result		=	$this->db->update('worker_quantity',$data);

        return $result;

	}

	function update_port_master($id,$status)

	{

		$result		=	$this->db->query("update tbl_portoffice_master set int_dredge_status=$status where int_portoffice_id=$id");

        return $result;

	}

	function del_det($table,$unif,$data,$val)

	{

		$this->db->where($unif,$val);

		$result		=	$this->db->update($table,$data);

        return $result;

	}

	function policecase_list()

	{

		$this->db->select('*');

        $this->db->from('police_case');

        $query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

	}

///////////

	

	///Gopika

	

///////

//----------------------------------------------------------------------//

function get_customer_registration($adhar_no){

		$this->db->select('*');

        $this->db->from('customer_registration');

		$this->db->where('customer_request_status<>' ,3);

		$this->db->where('customer_aadhar_number',$adhar_no);

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

		return $result;

	}

function get_customerreg_details($portid)

{

		/*$this->db->select('*');

        $this->db->from('customer_registration');

		$this->db->where('customer_request_status<>', 2);

		$this->db->where('port_id', $portid);*/

        $query = $this->db->query("SELECT * FROM `customer_registration` join district on customer_registration.customer_perm_district_id=district.district_id  WHERE `customer_request_status` =1 AND `port_id` = '$portid' ORDER By `customer_registration_timestamp` ASC LIMIT 0,50");

        $result = $query->result_array();

	//echo $this->db->last_query();

	//break;

        return $result;

	

}



function get_postoffice_details()

{

		$this->db->select('*');

        $this->db->from('tbl_post_office');

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function get_pincode($postoffid)

		{

		$this->db->select('*');

        $this->db->from('tbl_post_office');

		$this->db->where('PostOfficeId',$postoffid);

		$query = $this->db->get();

		$result = $query->result_array();

		

        return $result;

		}

function get_district_details()

{

		$this->db->select('*');

        $this->db->from('district');

		$this->db->order_by('district_name', 'asc');

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function get_localbody_details()

{

		$this->db->select('*');

        $this->db->from('tb_panchayath');

        $query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function get_customer_purpose_details()

{

		$this->db->select('*');

        $this->db->from('construction_master');

		$this->db->where('construction_master_status', 1);

        $query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}



function get_port_master_details()

{

		$this->db->select('*');

        $this->db->from('tbl_portoffice_master');

		//$this->db->where('int_status', 1);

		$this->db->where('int_dredge_status', 1);

        $query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function get_customer_reg_details($id,$portid)

{

		$this->db->select('*');

        $this->db->from('customer_registration');

		$this->db->where('customer_request_status<>', 2);

		$this->db->where('customer_registration_id', $id);

		$this->db->where('port_id', $portid);

        $query = $this->db->get();

        $result = $query->result_array();

	//echo	$this->db->last_query(); 

        return $result;

	

}

function getcustomerregdetails($id,$portid)

{

		$this->db->select('*');

        $this->db->from('customer_registration');

		//$this->db->where('customer_request_status', 2);

		$this->db->where('customer_registration_id', $id);

		$this->db->where('port_id', $portid);

        $query = $this->db->get();

        $result = $query->result_array();

		$this->db->last_query(); 

        return $result;

	

}

function getcustomerregdetailsfor($id,$portid)

{

		$this->db->select('*');

        $this->db->from('customer_registration');

		$this->db->where('customer_request_status', 2);

		$this->db->where('customer_public_user_id', $id);

		//$this->db->where('port_id', $portid);

        $query = $this->db->get();

        $result = $query->result_array();

		$this->db->last_query(); 

        return $result;

	

}

function update_customerregistration($data,$id)

{

		$where 		= 	" customer_registration_id  = '$id'"; 

		$updquery 	= 	$this->db->update_string('customer_registration', $data, $where);

		$rs			=	$this->db->query($updquery);

	//echo	$this->db->last_query(); exit();

		return $rs;	

}

/*

function get_customerreg_detailsapproved($portid)

{

$query    =    $this->db->query("select * from customer_registration c join user_master u on c.port_id=u.user_master_port_id where c.customer_public_user_id=u.user_master_id and  customer_request_status=2 and  u.user_master_port_id='$portid' LIMIT 0,10");

 //$query    =    $this->db->query("select * from customer_registration c join user_master u where  c.port_id=u.user_master_port_id and customer_request_status=2 and user_master_name!='' and user_master_password!='' and u.user_master_port_id='$portid'");24/092017

		$result = $query->result_array();

		//print_r($result);

        return $result;

	

}

*/

function get_customer_reg_detailsapproved($id)

{

		$this->db->select('*');

        $this->db->from('customer_registration');

		$this->db->where('customer_request_status', 2);

		$this->db->where('customer_registration_id', $id);

        $query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function update_usermaster($data,$id)

{

		$where 		= 	"user_master_id  = '$id'"; 

		$updquery 	= 	$this->db->update_string('user_master', $data, $where);

		$rs			=	$this->db->query($updquery);

		//$this->db->last_query(); exit;

		return $rs;	

}



function customer_registration_msg($id){

		$this->db->select('*');

        $this->db->from('customer_registration');

		$this->db->join('tbl_portoffice_master', 'tbl_portoffice_master.int_portoffice_id= customer_registration.port_id');

		$this->db->where('customer_request_status',1);

		$this->db->where('customer_registration_id',$id);

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

		return $result;

	}



//-----------------------------------------

function get_portcode($portid)

{

		$this->db->select('*');

        $this->db->from('tbl_portoffice_master');

		$this->db->where('int_portoffice_id', $portid);

        $query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}





	

//-----------------------------------------15/6/2017-----------------------------------------		

			

		

		

		function get_postoffice_details_reg($districtid)

{

		$this->db->select('*');

        $this->db->from('tbl_post_office');

		$this->db->join('district', 'district.district_id = tbl_post_office.int_DistrictId');

		$this->db->where('int_DistrictId',$districtid);

		$this->db->order_by('vchr_BranchOffice', 'asc');

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}







//sand issue

function vehiclepass_details($bookingid)

{

	$this->db->select('*');

        $this->db->from('customer_booking');

		//$this->db->join('lsg_zone', 'customer_booking.customer_booking_lsg_id = lsg_zone.lsg_id and customer_booking.customer_booking_zone_id = lsg_zone.zone_id');

		//$this->db->join('lsgd', 'customer_booking.customer_booking_lsg_id = lsgd.lsgd_id and lsgd_status=1');

		//$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');

		$this->db->where('customer_booking_id', $bookingid);

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('transaction_status', 1);

		$query = $this->db->get();

		//echo	$this->db->last_query(); 

		//exit();

		$result = $query->result_array();

        return $result;

		/*

$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('lsg_zone', 'customer_booking.customer_booking_lsg_id = lsg_zone.lsg_id and customer_booking.customer_booking_zone_id = lsg_zone.zone_id');

		$this->db->join('lsgd', 'customer_booking.customer_booking_lsg_id = lsgd.lsgd_id and lsgd_status=1');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id and customer_booking.customer_booking_registration_id = transaction_details.transaction_customer_registration_id');

		$this->db->where('customer_booking_id', $bookingid);

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('transaction_status', 1);

		$query = $this->db->get();

		//echo	$this->db->last_query(); 

		//exit();

		$result = $query->result_array();

        return $result;

		*/

}



function get_bookingapprovedlist($tokennumnber,$aadharnumber,$port_id,$zone_id)

{

	$cudate=date('Y-m-d');

$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('customer_booking_token_number', $tokennumnber);

		$this->db->where('customer_registration.customer_aadhar_number', $aadharnumber);

		$this->db->where('customer_booking_port_id',$port_id);

		$this->db->where('customer_booking_zone_id', $zone_id);

		$this->db->where('customer_booking_allotted_date',$cudate);

		$query = $this->db->get();

		//echo	$this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

}	

	

	

	function get_bookingapprovedlistnn($tokennumnber,$aadharnumber,$port_id,$zone_id)

{

	$cudate=date('Y-m-d');

$this->db->select('customer_booking.customer_booking_id');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('customer_booking_token_number', $tokennumnber);

		$this->db->where('customer_registration.customer_aadhar_number', $aadharnumber);

		$this->db->where('customer_booking_port_id',$port_id);

		$this->db->where('customer_booking_zone_id', $zone_id);

		$this->db->where('customer_booking_allotted_date',$cudate);

		$query = $this->db->get();

		//echo	$this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

}
function get_bookingapprovedlistnnew($tokennumnber,$port_id,$zone_id)

{

	$cudate=date('Y-m-d');

$this->db->select('customer_booking.customer_booking_id');
	$this->db->select('customer_registration.customer_phone_number');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('customer_booking_token_number', $tokennumnber);

		//$this->db->where('customer_registration.customer_aadhar_number', $aadharnumber);

		$this->db->where('customer_booking_port_id',$port_id);

		$this->db->where('customer_booking_zone_id', $zone_id);

		$this->db->where('customer_booking_allotted_date',$cudate);
		$this->db->where('customer_booking_pass_issue_user ',0);
	
		$query = $this->db->get();

		//echo	$this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

}
//------------------------10/7/17

function get_bookingapprovedadd($id)

{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');

		$this->db->where('customer_booking.customer_booking_id', $id);

		$this->db->where('customer_booking.customer_booking_decission_status', 2);

		$this->db->where('transaction_details.transaction_status', 1);

		$this->db->where('transaction_details.payment_status', 1);

		$this->db->where('transaction_details.print_status', 0);

		$query = $this->db->get();

		//echo $this->db->last_query(); 

		//exit();

		$result = $query->result_array();

        return $result;

}

	function get_bookingapprovedaddnn($id)

{

		$this->db->select('customer_registration.customer_used_ton,customer_booking.customer_booking_registration_id,customer_registration.customer_unused_ton,customer_booking.customer_booking_port_id,customer_booking.customer_booking_zone_id,customer_booking.customer_booking_lsg_id,customer_booking.customer_booking_request_ton,customer_registration.customer_number_pass,customer_booking.customer_booking_id,customer_booking.customer_booking_token_number,transaction_details.uid_no,customer_booking.customer_booking_chalan_number,transaction_details.challan_timestamp,customer_booking.customer_booking_chalan_amount,transaction_details.transaction_ref_timestamp,transaction_details.transaction_refno,transaction_details.transaction_amount,customer_registration.customer_name,customer_booking.customer_booking_monthly_permit_id');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');

		$this->db->where('customer_booking.customer_booking_id', $id);

		$this->db->where('customer_booking.customer_booking_decission_status', 2);

		$this->db->where('transaction_details.transaction_status', 1);

		$this->db->where('transaction_details.payment_status', 1);

		$this->db->where('transaction_details.print_status', 0);

		$query = $this->db->get();

		//echo $this->db->last_query(); 

		//exit();

		$result = $query->result_array();

        return $result;

}

	

//

//gopi new

function get_bookingapprovedRPT($tokenno,$aadharno)

{

		$this->db->select('customer_booking_port_id,customer_booking_zone_id,customer_booking_lsg_id,customer_booking_lsg_section_id,customer_booking_registration_id,customer_booking_id');

        $this->db->from('customer_booking');

		//$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');

		$this->db->where('customer_booking_token_number', $tokenno);

		$this->db->where('customer_registration.customer_aadhar_number', $aadharno);

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('transaction_status', 1);

		$this->db->where('payment_status', 1);

		$this->db->where('print_status', 1);

		$query = $this->db->get();

		//echo $this->db->last_query(); 

		//exit();

		$result = $query->result_array();

        return $result;

}



function add_sandpass_reprint($data)

	{

		$result=$this->db->insert('sandpass_reprint',$data);

		return $result;

	}

	function get_pass_reprintold($portid)

	{

	$this->db->select('*');

        $this->db->from('sandpass_reprint');

		$this->db->join('customer_booking', 'sandpass_reprint.customer_booking_id= customer_booking.customer_booking_id');

		$this->db->join('customer_registration', 'sandpass_reprint.customer_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'sandpass_reprint.customer_booking_id = transaction_details.transaction_customer_booking_id');	

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('sandpass_reprint.port_id', $portid);

		$this->db->where('transaction_status', 1);

		$this->db->where('payment_status', 1);

		$this->db->where('print_status', 1);

		$this->db->where('approved_user_id', 0);

		

		$query = $this->db->get();

		//$this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

	}

	function get_pass_reprintAPPold($portid)

	{

	$this->db->select('*');

        $this->db->from('sandpass_reprint');

		$this->db->join('customer_booking', 'sandpass_reprint.customer_booking_id= customer_booking.customer_booking_id');

		$this->db->join('customer_registration', 'sandpass_reprint.customer_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'sandpass_reprint.customer_booking_id = transaction_details.transaction_customer_booking_id');	

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('sandpass_reprint.port_id', $portid);

		$this->db->where('transaction_status', 1);

		$this->db->where('payment_status', 1);

		$this->db->where('print_status', 1);

	$this->db->where('approved_user_id', 0);

		

		$query = $this->db->get();

		//$this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

	}

	function get_pass_reprintApprovedold($portid)

	{

	$this->db->select('*');

        $this->db->from('sandpass_reprint');

		$this->db->join('customer_booking', 'sandpass_reprint.customer_booking_id= customer_booking.customer_booking_id');

		$this->db->join('customer_registration', 'sandpass_reprint.customer_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'sandpass_reprint.customer_booking_id = transaction_details.transaction_customer_booking_id');	

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('sandpass_reprint.port_id', $portid);

		$this->db->where('transaction_status', 1);

		$this->db->where('payment_status', 1);

		$this->db->where('print_status', 1);

		$this->db->where('approved_user_id <>', 0);

		

		$query = $this->db->get();

		//$this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

	}

	

	function update_passreprint($id,$data)

	{

		$this->db->where('sandpass_reprint_id',$id);

		$result		=	$this->db->update('sandpass_reprint',$data);

		return $result;

	}

	function get_sandpassdata($id)

	{

	$this->db->select('*');

        $this->db->from('sandpass_reprint');

		$this->db->where('sandpass_reprint_id',$id);

		$query = $this->db->get();

		$result = $query->result_array();

		return $result;

	}



//

/*function get_customerreg_booking()

{



 		$query    =    $this->db->query("select * from customer_registration c join user_master u join customer_booking cb  where c.port_id=u.user_master_port_id and customer_request_status=2 and user_master_name!='' and user_master_password!='' and customer_unused_ton > 3 and cb.customer_booking_registration_id=''");

		$result = $query->result_array();

		//print_r($result);

        return $result;

}

*/

function maxpriorty_check($portid,$lsgid,$zoneid)

{

		$query    =    $this->db->query("select max(customer_booking_priority_number) as prioritynum from customer_booking  where	customer_booking_port_id='$portid' and customer_booking_zone_id='$zoneid'");

		$result = $query->result_array();

		//echo $this->db->last_query();

		//exit;

        return $result;

}

		

function get_permitidbooked($bookingid)

{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->join('tbl_portoffice_master', 'customer_booking.customer_booking_port_id= tbl_portoffice_master.int_portoffice_id');

		$this->db->join('zone', 'customer_booking.customer_booking_zone_id= zone.zone_id and customer_booking.customer_booking_port_id= zone.zone_port_id');

		$this->db->where('customer_booking_id', $bookingid);

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();

		//print_r($result);

        return $result;

}

function get_quantitymast($id)

{

		$this->db->select('*');

        $this->db->from('quantity_master');

		$this->db->where('quantity_master_id',$id);

		$query = $this->db->get();

		$result = $query->result_array();

        return $result;

		

}

function get_customer_regDetails($id)

{

		$this->db->select('*');

        $this->db->from('customer_registration');

		$this->db->where('customer_public_user_id',$id);

		$this->db->where('customer_request_status',2);

		$query = $this->db->get();

		$result = $query->result_array();

        return $result;

}

function get_customer_regDetailsadd($id)

{

		$this->db->select('*');

        $this->db->from('customer_registration');

		$this->db->where('customer_request_status',2);

		$this->db->where('customer_registration_id',$id);

		$query = $this->db->get();

		$result = $query->result_array();

        return $result;

}



function get_quantity_details($portid)

{

		$query    =    $this->db->query("select * from quantity where  quantity.port_id='$portid' and quantity_status=1");

		//echo	$this->db->last_query();

		$result = $query->result_array();

		//print_r($result);

		foreach($result as $row)

		{

		$array_master_id=$row['quantity_master_id'];

		

		

		$query= $this->db->query("select * from quantity_master where  quantity_master_id IN($array_master_id) and quantity_master_status=1");

		$res = $query->result_array();

		//print_r($res);

		return $res;

		

		}

       

}

function get_zone_details($portid)

{

			$query    =    $this->db->query("select * from zone join lsg_zone where zone.zone_id = lsg_zone.zone_id  and lsg_zone.lsg_zone_port_id='$portid' and lsg_zone_status=1");

			$result = $query->result_array();

			

        	return $result;

}

function get_monthly_permit($portid,$periodname)

{

		$this->db->select('*');

        $this->db->from('monthly_permit');

		$this->db->where('port_id',$portid);

		$this->db->where('monthly_permit_period_name',$periodname);

		$this->db->where('monthly_permit_permit_status', 2);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function get_monthly_permitnew($portid,$periodname,$zone_id)

{

		$this->db->select('*');

        $this->db->from('monthly_permit');

		$this->db->where('port_id',$portid);

		$this->db->where('monthly_permit_period_name',$periodname);

		$this->db->where('zone_id',$zone_id);

		$this->db->where('monthly_permit_permit_status', 2);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function get_customer_booking($customerregid)

{

		$query    =    $this->db->query("SELECT MAX(customer_booking_id),`customer_booking_requested_timestamp` FROM `customer_booking` where customer_booking_registration_id='$customerregid'");

		$result = $query->result_array();

		//echo	$this->db->last_query();

        return $result;

}

function getbukinfo($user_id)

{

	$query    =    $this->db->query("select max(booking_timestamp) as bookeddate,MAX(customer_booking_id) as customer_bukid from transaction_details join customer_booking on transaction_details.transaction_customer_booking_id = customer_booking.customer_booking_id  where transaction_details.transaction_customer_registration_id='$user_id' and customer_booking.customer_booking_decission_status!=5");

		$result = $query->result_array();

		//echo	$this->db->last_query();

        return $result;

}

function getbukinfount($user_id)

{

		$query    =    $this->db->query("select customer_unused_ton from customer_registration where customer_public_user_id='$user_id'");

		$result = $query->result_array();

		//echo	$this->db->last_query();

        return $result;

}

function bookingapproval($portid)

{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_booking_decission_user',0);

		$this->db->where('customer_booking_decission_status<>', 2);

		$this->db->where('customer_booking_port_id', $portid);

		$this->db->order_by('customer_booking_priority_number','asc');

		$query = $this->db->get();

		//echo	$this->db->last_query();exit();

		$result = $query->result_array();

        return $result;

}

function get_zone_detailsnew($portid,$periodname)

{

			$urdate=date('Y-m-d');

			//$query    =    $this->db->query("select * from zone join lsg_zone join monthly_permit where zone.zone_id = lsg_zone.zone_id and lsg_zone.lsg_zone_port_id=monthly_permit.port_id and lsg_zone.zone_id=monthly_permit.zone_id and (monthly_permit.monthly_permit_end_date > '$urdate' || monthly_permit.monthly_permit_end_date= '$urdate')and lsg_zone.lsg_zone_port_id='$portid' and lsg_zone_status=1 and monthly_permit.monthly_permit_permit_status=2");

			//echo $this->db->last_query();

			$query    =    $this->db->query("select * from zone join lsg_zone join monthly_permit where zone.zone_id = lsg_zone.zone_id and lsg_zone.lsg_zone_port_id=monthly_permit.port_id and lsg_zone.zone_id=monthly_permit.zone_id and monthly_permit.monthly_permit_period_name='$periodname' and lsg_zone.lsg_zone_port_id='$portid' and lsg_zone_status=1 and monthly_permit.monthly_permit_permit_status=2 ");

			$result = $query->result_array();

			

        	return $result;

}

function bookingapprovalzone($zoneid)

{

	//$sql="select * from customer_booking join customer_registration on customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id where customer_booking_decission_user=0 and customer_booking_decission_status<> 2 and customer_booking_zone_id='$zoneid' order by  customer_booking_priority_number ASC LIMIT 0,100";

		/*$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_booking_decission_user',0);

		$this->db->where('customer_booking_decission_status<>', 2);

		$this->db->where('customer_booking_zone_id', $zoneid);

		$this->db->order_by('customer_booking_priority_number','asc');*/

		$query = $this->db->query("select * from customer_booking join customer_registration on customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id where customer_booking_decission_user=0 and customer_booking_decission_status=0 and customer_booking_zone_id='$zoneid' order by  customer_booking_priority_number ASC LIMIT 0,50");

		//echo $this->db->last_query();//exit();

		$result = $query->result_array();

        return $result;

}

function booking_approval_addVw($id,$portid)

{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_booking.customer_booking_id',$id);

		$this->db->where('customer_booking.customer_booking_decission_user',0);

		$this->db->where('customer_booking.customer_booking_port_id',$portid);

		$this->db->where('customer_booking.customer_booking_decission_status<>', 2);

		$query = $this->db->get();

		echo $this->db->last_query();

		$result = $query->result_array();

        return $result;

}

function allbooking_approval_addVw($id)

{

	$this->db->select('*');

        $this->db->from('customer_booking');

		//$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		//$this->db->where('customer_booking_id',$id);

		//$this->db->where('customer_booking_decission_user',0);

		//$this->db->where('customer_booking_port_id',$portid);

		$this->db->where('customer_booking_registration_id',$id);

		$query = $this->db->get();

		//echo $this->db->last_query();

		$result = $query->result_array();

        return $result;

}

function update_customerbooking($data,$id)

{

$where 		= 	" customer_booking_id  = '$id'"; 

		$updquery 	= 	$this->db->update_string('customer_booking', $data, $where);

		$rs			=	$this->db->query($updquery);

	//echo	$this->db->last_query(); exit();

		return $rs;	

		}

		

//-----------------------------------------15/6/2017-----------------------------------------		

			

		function check_dailylogtable($bookedpermitid,$portid,$requestedton,$zoneid)

		{

			$query=$this->db->query("select * from daily_log where daily_log_port_id='$portid' and daily_log_balance>='$requestedton' and daily_log_zone_id='$zoneid' order by daily_log_date asc");

		$result = $query->result_array();

		//echo	$this->db->last_query();

		 return $result;

  		}

		function get_permit_reserve($port_id,$zone_id)

		{

			$this->db->select('holiday_date');

        	$this->db->from('holiday');

			$this->db->where('holiday_port_id',$port_id);

			$this->db->where('holiday_zone_id',$zone_id);

			//$this->db->where('holiday_period_name',$pname);

			$this->db->where('holiday_reserve_status',1);

			$query = $this->db->get();

			//echo	$this->db->last_query();

			$result = $query->result_array();

        	return $result;

		}

		

		



//=======================================29/06/2017==========================================

function customerbooking_timecheck()

{

		$this->db->select('*');

        $this->db->from('booking_master');

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function get_cus_buk_his($id)

{

	/*$this->db->select('customer_booking.customer_booking_id as customer_booking_id,

customer_booking.customer_booking_request_ton as customer_booking_request_ton,

customer_booking.customer_booking_priority_number as customer_booking_priority_number,

customer_booking.customer_booking_token_number as customer_booking_token_number,

customer_booking.customer_booking_allotted_date as customer_booking_allotted_date,

customer_booking.customer_booking_pass_issue_user as customer_booking_pass_issue_user,

customer_booking.customer_booking_decission_status as customer_booking_decission_status,

customer_booking.customer_booking_customer_booking as customer_booking_customer_booking,

transaction_details.payment_status as payment_status,

tbl_portoffice_master.vchr_portoffice_name as vchr_portoffice_name,

zone.zone_name as zone_name');

        $this->db->from('customer_booking');

		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=customer_booking.customer_booking_port_id');

		$this->db->join('zone','zone.zone_id=customer_booking.customer_booking_zone_id');

		$this->db->join('transaction_details','customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');

		$this->db->where('customer_booking_customer_booking',$id);

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;*/

	/*	$query=$this->db->query("SELECT * FROM cus_history where customer_booking_customer_booking='$id'");

		$result = $query->result_array();

		return $result;*/

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=customer_booking.customer_booking_port_id');

		$this->db->join('zone','zone.zone_id=customer_booking.customer_booking_zone_id');

		$this->db->join('transaction_details','customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');

		$this->db->where('customer_booking_customer_booking',$id);

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function get_cus_buk_ch($id)

{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=customer_booking.customer_booking_port_id');

		$this->db->join('zone','zone.zone_id=customer_booking.customer_booking_zone_id');

		$this->db->where('customer_booking.customer_booking_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}



//------------------------------------------------------------------------//

function get_paymentdetails($bookingid,$portid,$zoneid)

	{

	$query= $this->db->query("select * from payment

					 JOIN customer_booking on payment.payment_booking_id=customer_booking.customer_booking_id and

							 payment.payment_customer_id=customer_booking.customer_booking_registration_id and 	

							 payment.payment_port_id=customer_booking.customer_booking_port_id and

							  payment.payment_zone_id = customer_booking.customer_booking_zone_id 

							where  payment.payment_booking_id='$bookingid' and payment.payment_port_id='$portid' and 

							payment.payment_zone_id='$zoneid' and 

							customer_booking.customer_booking_decission_status=2 order by payment.payment_head asc");

	 $result = $query->result_array();

        return $result;

	}



//************************************************************************************************************************

function get_customer_registrationOldOct20($adhar_no)

{

$this->db->select('*');

        $this->db->from('tbl_dredg_pass_request');

		$this->db->where('int_requester_proof_number',$adhar_no);

		$this->db->where('int_block_status',2);

        $query = $this->db->get();

        $result = $query->result_array();

	//echo $this->db->last_query();exit();

		return $result;

}

function get_customer_registrationOld($adhar_no)

{

$this->db->select('*');

        $this->db->from('tbl_dredg_pass_request');

		$this->db->join('port_n','port_n.int_requester_proof_number=tbl_dredg_pass_request.int_requester_proof_number');

		$this->db->where('tbl_dredg_pass_request.int_requester_proof_number',$adhar_no);

		$this->db->where('int_block_status',2);

        $query = $this->db->get();

        $result = $query->result_array();

	//echo $this->db->last_query();exit();

		return $result;

}

//----------------------------------------------------------------------------------------------

function customerapproval($custaadhar,$pid)

{

$query= $this->db->query("select * from customer_registration where customer_request_status=1 and port_id='$pid' and customer_decission_user_id=0 and (customer_aadhar_number='$custaadhar' or customer_reg_no='$custaadhar')");

/*$this->db->select('*');

        $this->db->from('customer_registration');

		$this->db->where('customer_aadhar_number',$custaadhar);

		$this->db->where('customer_request_status',1);

		$this->db->where('customer_decission_user_id',0);

			

        $query = $this->db->get();*/

        $result = $query->result_array();

	//echo $this->db->last_query();exit();

		return $result;

}

//************************************************************************************************************************

	

//////

	

	//gopika End 

	

/////

	

///// 

	

	////// Liju   Start  

	

/////

//---------------------------------------------------------------------------------------------------------//	

	

function get_worker_registration($zone_id){

		

		$query    =    $this->db->query("select  worker_registration_id,worker_registration_name,worker_registration_status FROM worker_registration WHERE worker_registration_status!=0 and zone_id='".$zone_id."'");    

		$result    =    $query->result_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_worker_details($edit_id)     

    {

    	$this->db->select('*');

        $this->db->from('worker_registration');

		$this->db->where('worker_registration_id', $edit_id);

        $query = $this->db->get();

        $result = $query->row_array();

		//print_r($result);break;

        return $result;

	 }

	 function get_canoe_registration($port_id){

		

		$query    =    $this->db->query("select  canoe_registration_id,canoe_name,canoe_registration_status FROM canoe_registration WHERE canoe_registration_status!=0 and port_id='".$port_id."'");    

		$result    =    $query->result_array();

		return $result;

	}

	function get_canoe_details($edit_id)     

    {

    	$this->db->select('*');

        $this->db->from('canoe_registration');

		$this->db->where('canoe_registration_id', $edit_id);

        $query = $this->db->get();

        $result = $query->row_array();

		//print_r($result);break;

        return $result;

	}

	function get_no_of_workers($section_userId){

		$this->db->select('lsg_section_current_workers');

        $this->db->from('lsg_section');

		$this->db->where('lsg_section_user', $section_userId);

$this->db->where('lsg_section_status', 1);

        $query = $this->db->get();

        $result = $query->row_array();

		return $result;

	}

	function worker_quantity(){

		$this->db->select('worker_quantity');

        $this->db->from('worker_quantity');

		$this->db->where('worker_quantity_status',1);

        $query = $this->db->get();

        $result = $query->row_array();

		return $result;

	} 

	function user_details_by_id($user_id){

		$this->db->select('*');

        $this->db->from('user_master');

		$this->db->where('user_master_id',$user_id);

        $query = $this->db->get();

        $result = $query->row_array();

		return $result;

	}

	function get_port_monthly_permit_list($user_master_port_id){

		$this->db->select('*');

        $this->db->from('monthly_permit');

		$this->db->where('port_id',$user_master_port_id);

		$this->db->order_by('monthly_permit_id','DESC');

        $query = $this->db->get();

        $result = $query->result_array();

		return $result;

	}

	function get_monthly_permit_list($usr_id){

		$this->db->select('*');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_requested_user',$usr_id);

        $query = $this->db->get();

        $result = $query->result_array();

		return $result;

	}

	function get_monthly_permit_by_id($id){

		$this->db->select('*');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_id',$id);

        $query = $this->db->get();

        $result = $query->row_array();

		return $result;

	}

	function get_zone_name_by_id($zone_id){

		$this->db->select('zone_name');

        $this->db->from('zone');

		$this->db->where('zone_id',$zone_id);

        $query = $this->db->get();

        $result = $query->row_array();

		return $result;

	}

	function get_lsgdname_by_id($lsgd_id){

		$this->db->select('*');

        $this->db->from('lsgd');

		$this->db->where('lsgd_id',$lsgd_id);

        $query = $this->db->get();

        $result = $query->row_array();

		return $result;

	}

	function get_monthly_working_days($port_id,$holiday_port_period_name){

		$this->db->select('working_days');

        $this->db->from('holiday_port');

		$this->db->where('holiday_port_port_id',$port_id);

		$this->db->where('holiday_port_period_name',$holiday_port_period_name);

        $query = $this->db->get();

        $result = $query->row_array();

		return $result;

	}

	function get_port_holiday_status($port_id,$period_name){

		$this->db->select('holiday_port_status');

        $this->db->from('holiday_port');

		$this->db->where('holiday_port_port_id',$port_id);

		$this->db->where('holiday_port_period_name',$period_name);

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_holiday_by_periodname($period_name,$port_id){

		$this->db->select('*');

        $this->db->from('holiday_port');

		$this->db->where('holiday_port_period_name',$period_name);

		$this->db->where('holiday_port_port_id',$port_id);

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_montlyPermit_by_periodname($period_name,$port_id){

		$this->db->select('*');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_period_name',$period_name);

		$this->db->where('port_id',$port_id);

		$this->db->where('monthly_permit_permit_status!=3');

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_lsgd_montlyPermit_by_periodname($period_name,$port_id,$lsgd_section_id){

		$this->db->select('*');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_period_name',$period_name);

		$this->db->where('port_id',$port_id);

		$this->db->where('lsg_section_id',$lsgd_section_id);

		$this->db->where('monthly_permit_permit_status!=3');

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_period_holidays_list($sess_usr_id){

		$this->db->select('*');

        $this->db->from('holiday');

		$this->db->where('holiday_user_id',$sess_usr_id);

		$this->db->group_by('holiday_period_name');

		$this->db->order_by('holiday_date');

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_period_holidays_port_list($sess_usr_id){

		$this->db->select('*');

        $this->db->from('holiday_port');

		$this->db->where('holiday_port_user_id',$sess_usr_id);

		//$this->db->group_by('holiday_period_name');

		$this->db->order_by('holiday_date');

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_holidaylist_by_periodname($port_id,$period_name){

		$this->db->select('*');

        $this->db->from('holiday');

		//$this->db->or_where('holiday_reserve_status',1);

		$this->db->where('holiday_period_name',$period_name);

		$this->db->where('holiday_port_id',$port_id);

		//$this->db->where('holiday_status',1);

        $query = $this->db->get();

        $result = $query->result_array();

		return $result;

	}

	function delete_holiday_by_periodname($period_name,$port_id){

		$this->db->where('holiday_period_name', $period_name);

		$this->db->where('holiday_port_id', $port_id);

		$result=$this->db->delete('holiday');

		return $result;	

	}

	function delete_holiday_port_by_periodname($period_name,$port_id){

		$this->db->where('holiday_port_period_name', $period_name);

		$this->db->where('holiday_port_port_id', $port_id);

		$this->db->delete('holiday_port');

		return 1;	

	}

	function decrement_current_worker($zone_id,$lsgd_id){

		$this->db->where('zone_id', $zone_id);

		$this->db->where('lsgd_id', $lsgd_id);

		$this->db->set('lsg_section_current_workers','lsg_section_current_workers-1',FALSE);

		$this->db->update('lsg_section');

		return 1;

	}

	function increment_current_worker($zone_id,$lsgd_id){

		$this->db->where('zone_id', $zone_id);

		$this->db->where('lsgd_id', $lsgd_id);

		$this->db->set('lsg_section_current_workers', 'lsg_section_current_workers+1',FALSE);

		$this->db->update('lsg_section');

		//echo $this->db->last_query();break;

		return 1;

	}

	function plinth_cutoffdate(){

		$this->db->select('cutoff_date');

        $this->db->from('cutoff_master');

		//$this->db->where('cutoff_status',1);

        $query = $this->db->get();

        $result = $query->row_array();

		return $result;

	}

	function reject_monthly_permit($port_id,$period_name)

	{

		$this->db->where('monthly_permit_period_name',$period_name);

		$this->db->where('port_id',$port_id);

		$data=array('monthly_permit_permit_status'=>3);

		$result	= $this->db->update('monthly_permit',$data);

        return $result;

	}  

	function get_canoe_registration_fee(){

		$this->db->select('fee_master_fee');

        $this->db->from('fee_master');

		$this->db->where('fee_master_fee_name','Canoe Registration Fee');

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;//->fee_master_fee;

	}

	function get_material_sand_rate($lsg_id,$zone_id,$port_id){

		

		$this->db->select('materialrate_port_amount');

        $this->db->from('materialrate');

		$this->db->where('fee_master_id',3);

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;//->fee_master_fee;

	}

	function get_material_sand_rate_pdr($material_master_id){

		

		$this->db->select('*');

        $this->db->from('materialrate');

		//$this->db->where('materialrate_port_material_master_id',$material_master_id);

		//$this->db->where('port_id',is_null);

		//$this->db->where('materialrate_port_status',1);

		$this->db->where(array('materialrate_port_material_master_id'=>$material_master_id,'materialrate_port_status'=>1,'port_id' => NULL));

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;//->fee_master_fee;

	}

	function get_material_sand_rate_port($material_id,$port_id){

		

		$this->db->select('*');

        $this->db->from('materialrate');

		$this->db->where('materialrate_port_material_master_id',$material_id);

		$this->db->where('port_id',$port_id);

		$this->db->where('materialrate_port_status',1);

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;//->fee_master_fee;

	}

	function get_tax_material_amount($material_id,$port_id){

		$this->db->select('*');

        $this->db->from('tax_calculator');

		$this->db->where('tax_calculator_status',1);

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;//->fee_master_fee;

	}

	function get_materials_with_tax(){

		$this->db->select('*');

        $this->db->from('tax_calculator');

		$this->db->where('tax_calculator_status',1);

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;//->fee_master_fee;

	}

	function get_worker_by_adhar($adhar_no){

		$this->db->select('*');

        $this->db->from('worker_registration');

		$this->db->where('worker_registration_status',1);

		$this->db->where('worker_registration_aadhar_number',$adhar_no);

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

		return $result;//->fee_master_fee;

	}

	

	function get_districtname_by_id($id){

		$this->db->select('district.district_name');

        $this->db->from('district');

		$this->db->join('lsgd', 'lsgd.lsgd_district_id = district.district_id');

		$this->db->where('lsgd.lsgd_id',$id);

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_port_details($portid)

	{

		$this->db->select('*');

		$this->db->from('tbl_portoffice_master');

		$this->db->where('int_portoffice_id', $portid);

		$query = $this->db->get();

		$result = $query->row_array();

		//print_r($result);

		return $result;

	}

	function get_booking_free_days($monthly_permit_id,$period_name,$port_id,$lsgd_section_id){

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_monthly_permit_id',$monthly_permit_id);

		$this->db->where('customer_booking_period_name',$period_name);

		$this->db->where('customer_booking_port_id',$port_id);

		$this->db->where('customer_booking_lsg_section_id',$lsgd_section_id);

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

		return $result;//->fee_master_fee;

		

	}

	function get_montly_permit_by_period($period_name,$port_id){

		$this->db->select('*');

        $this->db->from('monthly_permit');

		$this->db->where('monthly_permit_period_name',$period_name);

		$this->db->where('port_id',$port_id);

		//$this->db->where('monthly_permit_permit_status','IN(1,2)');

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_holiday_by_date($period_name,$port_id,$holiday_date){

		

		$this->db->select('*');

        $this->db->from('holiday');

		$this->db->where('holiday_period_name',$period_name);

		$this->db->where('holiday_port_id',$port_id);

		$this->db->where('holiday_date',$holiday_date);

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	

	function get_max_workercount_lsg_zone($zone_id,$lsg_id){

		

		$this->db->select('*');

        $this->db->from('lsg_zone');

		$this->db->where('zone_id',$zone_id);

		$this->db->where('lsg_id',$lsg_id);

		$this->db->where('lsg_zone_status',1);

        $query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	

	function worker_adhar_check($adhar_no)     

    {

    	$this->db->select('*');

        $this->db->from('worker_registration');

		$this->db->where('worker_registration_aadhar_number', $adhar_no);

		$this->db->where('worker_registration_status',1);

        $query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);break;

        return $result;

	 }

	function get_lsg_zones($lsg_id)

	{

		$this->db->select('*');

        $this->db->from('lsg_zone');

		$this->db->join('zone', 'lsg_zone.zone_id = zone.zone_id');

		$this->db->join('lsgd', 'lsg_zone.lsg_id  = lsgd.lsgd_id');

		$this->db->where('lsg_id',$lsg_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_zone_by_portID($port_id)

	{

		$this->db->select('*');

        $this->db->from('zone');

		$this->db->where('zone_port_id',$port_id);

		//$this->db->where('zone_port_id',$port_id);

		$this->db->where('zone_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

        return $result;

	}  

	function get_zone_by_portIDforrep($port_id)

	{

		$this->db->select('*');

        $this->db->from('lsg_zone');

		$this->db->join('zone', 'lsg_zone.zone_id = zone.zone_id');

		$this->db->where('lsg_zone.lsg_zone_port_id',$port_id);

		$this->db->where('lsg_zone.lsg_zone_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

        return $result;

	}  

	function get_customerBookingList($holiday_date,$port_id)

	{

		//$this->db->select('*, COUNT(customer_booking_lsg_section_id) as total');

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_decission_status',2);

		$this->db->where('customer_booking_current_status',1);

		$this->db->where('customer_booking_allotted_date',$holiday_date);

		$this->db->where('customer_booking_port_id',$port_id);

		//$this->db->group_by(array('customer_booking_id','customer_booking_lsg_section_id'));

		$this->db->order_by('customer_booking_priority_number');

		$query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

        return $result;

		

		/*$query  = $this->db->query("select * from customer_booking 

						where customer_booking_allotted_date = '".$holiday_date."' 

						and customer_booking_decission_status = 2

						and customer_booking_port_id = '".$port_id."'

						group by  customer_booking_lsg_section_id"); 

		//$query = $this->db->get();

        $result = $query->result_array();

        return $result; */

	}

	

	function get_totalReseveDayBalnceTon($holiday_date,$port_id,$lsgd_section){

		

		$query    =    $this->db->query("select SUM(daily_log_balance) from daily_log 

						where daily_log_date > '".$holiday_date."' 

						and daily_log_port_id = '".$port_id."'

						and daily_log_lsg_section_id = '".$lsgd_section."' ");    

		$result    =    $query->row_array();

		//echo $this->db->last_query();exit;

		return $result;

		

	}

	function get_totalAllottedTon($holiday_date,$port_id,$lsgd_section){

		$query  = $this->db->query("select SUM(customer_booking_request_ton) from customer_booking 

						where customer_booking_allotted_date = '".$holiday_date."' 

						and customer_booking_decission_status = 2

						and customer_booking_port_id = '".$port_id."' 

						and customer_booking_lsg_section_id = '".$lsgd_section."' ");    

		$result    =    $query->row_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_reserveDayList($holiday_date,$port_id,$lsgd_section)

	{

		$this->db->select('*');

        $this->db->from('daily_log DL');

		$this->db->join('holiday HD','HD.holiday_date=DL.daily_log_date');

		$this->db->where('HD.holiday_reserve_status',1);

		$this->db->where('DL.daily_log_date >= ',$holiday_date);

		$this->db->where('DL.daily_log_port_id',$port_id);

		$this->db->where('DL.daily_log_lsg_section_id',$lsgd_section);

		$query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

        return $result;

	}

	function get_lsg_section_booking_List($holiday_date,$port_id)

	{

		$this->db->distinct();

		$this->db->select('customer_booking_lsg_section_id');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_decission_status',2);

		$this->db->where('customer_booking_current_status',1);

		$this->db->where('customer_booking_allotted_date',$holiday_date);

		$this->db->where('customer_booking_port_id',$port_id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

		

	}

	function transfer_booking_to_reserve($holiday_date,$booking_id,$maxPriority){

		$this->db->where('customer_booking_id', $booking_id);

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->set('customer_booking_allotted_date',$holiday_date);

		$this->db->set('customer_booking_priority_number',$maxPriority);

		//$this->db->set('customer_booking_priority_number','customer_booking_priority_number+1',FALSE);

		$this->db->update('customer_booking');

		//echo $this->db->last_query();break;

		return 1;

	}

	function max_priority_number($holiday_date,$port_id,$lsgd_section){

		$this->db->select('MAX(customer_booking_priority_number)');

        $this->db->from('customer_booking');

		$this->db->where('customer_booking_decission_status',2);

		$this->db->where('customer_booking_current_status',1);

		$this->db->where('customer_booking_allotted_date',$holiday_date);

		$this->db->where('customer_booking_port_id',$port_id);

		$this->db->where('customer_booking_lsg_section_id',$lsgd_section);

		$query = $this->db->get();

        $result = $query->row_array();

		//echo $this->db->last_query();break;

        return $result;

	}

	function update_daily_log_balance_ton($dailylog_id,$newBalance){

		$this->db->where('daily_log_id', $dailylog_id);

		$this->db->set('daily_log_balance',$newBalance);

		$this->db->update('daily_log');

		//echo $this->db->last_query();break;

		return 1;

		

	}

	//SELECT  MAX(`customer_booking_priority_number`) FROM customer_booking where `customer_booking_allotted_date`='2017-06-27'

	function increment_working_days($period_name,$port_id){

		$this->db->where('holiday_port_period_name', $period_name);

		$this->db->where('holiday_port_port_id', $port_id);

		$this->db->set('working_days', 'working_days+1',FALSE);

		$res=$this->db->update('holiday_port');

		//echo $this->db->last_query();break;

		return $res;

	}

	function delete_holiday_by_date($period_name,$port_id,$date){

		$this->db->where('holiday_period_name', $period_name);

		$this->db->where('holiday_port_id', $port_id);

		$this->db->where('holiday_date', $date);

		$this->db->where('holiday_reserve_status','1');

		$result=$this->db->delete('holiday');

		return $result;	

	}

	function get_pd_buk_det($pid,$zid,$fdate,$tdate)

	{

		$this->db->select('*');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		$this->db->join('customer_registration','customer_registration.customer_public_user_id=customer_booking.customer_booking_customer_booking');

		$this->db->where('customer_booking.customer_booking_port_id',$pid);

		if($zid!=0)

		{

			$this->db->where('customer_booking.customer_booking_zone_id',$zid);

		}

		$this->db->where('customer_booking.customer_booking_requested_timestamp >',$fdate);

		$this->db->where('customer_booking.customer_booking_requested_timestamp <',$tdate);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function get_pd_mon_det($pid,$zid,$m_p)

	{

		$this->db->select('*');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

		$this->db->join('zone','zone.zone_id=monthly_permit.zone_id');

		$this->db->join('lsgd','lsgd.lsgd_id=monthly_permit.lsg_id');

		$this->db->where('monthly_permit.port_id',$pid);

		if($zid!=0)

		{

			$this->db->where('monthly_permit.zone_id',$zid);

		}

		$this->db->where('monthly_permit.monthly_permit_period_name',$m_p);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function get_pd_cus_det($pid)

	{

		$this->db->select('*');

        $this->db->from('customer_registration');

		//$this->db->where('user_id',$uid);

		//$this->db->join('zone','zone.zone_id=monthly_permit.zone_id');

		$this->db->join('tb_panchayath','tb_panchayath.panchayath_sl=customer_registration.customer_work_lsg_id');

		$this->db->where('customer_registration.port_id',$pid);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

function get_lsgd_order_number($port_id,$lsgd_id,$zone_id)

{

		$this->db->select('*');

        $this->db->from('lsg_zone');

		$this->db->where('lsg_id',$lsgd_id);

		$this->db->where('zone_id',$zone_id);

		$this->db->where('lsg_zone_port_id',$port_id);

		$this->db->where('lsg_zone_status',1);

		$query = $this->db->get();

        $result = $query->row_array();

		//print_r($result);

        return $result;

}

//---------------------------------------------------------------------------------------------------------//	



////////////////////////

	

	//// Liju ENd

	

////



////??

///////////////////////New

/////

	function get_total_cus_regVp($pid){

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('customer_registration');

		//$this->db->where('monthly_permit_permit_status',1);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('port_id',$pid);

		//$this->db->where('customer_booking_decission_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

	}

	function get_total_cus_reg_wp_Vp($pid){

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('customer_registration');

		//$this->db->where('monthly_permit_permit_status',1);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('port_id',$pid);

		$this->db->where('customer_public_user_id',0);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

	}

	function get_total_cus_reg_gp_Vp($pid){

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('customer_registration');

		//$this->db->where('monthly_permit_permit_status',1);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('port_id',$pid);

		$this->db->where('customer_public_user_id !=',0);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

	}

	function pd_tot_buk_bp($pid){

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('customer_booking');

		//$this->db->where('monthly_permit_permit_status',1);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_port_id',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

	}

	function pd_tot_buk_ap_bp($pid){

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('customer_booking');

		//$this->db->where('monthly_permit_permit_status',1);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_port_id',$pid);

		$this->db->where('customer_booking_decission_status',2);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

	}

	function pd_tot_buk_si_bp($pid){

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('customer_booking');

		//$this->db->where('monthly_permit_permit_status',1);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('customer_booking_port_id',$pid);

		$this->db->where('customer_booking_decission_status',2);

		$this->db->where('customer_booking_pass_issue_user !=',0);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

		

	}

	function get_pd_buk_det_fr($pid)

	{

		$this->db->select('*');

        $this->db->from('customer_booking');

		//$this->db->where('user_id',$uid);

		$this->db->join('customer_registration','customer_registration.customer_public_user_id=customer_booking.customer_booking_customer_booking');

		$this->db->join('zone','zone.zone_id=customer_booking.customer_booking_zone_id');

		$this->db->where('customer_booking.customer_booking_port_id',$pid);

		

		//if($zid!=0)

		//{

		//	$this->db->where('customer_booking.customer_booking_zone_id',$zid);

		//}

		//$this->db->where('customer_booking.customer_booking_requested_timestamp >',$fdate);

		//$this->db->where('customer_booking.customer_booking_requested_timestamp <',$tdate);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function permit_req_pd_new($pid)

	{

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

		//$this->db->where('user_master.user_master_password',$pw);

		$this->db->where('port_id',$pid);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function permit_reqAp_pd_new($pid)

	{

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

	    $this->db->where('monthly_permit_permit_status',2);

		$this->db->where('port_id',$pid);

		$query = $this->db->get();

       $result = $query->result_array();

        return $result;

	}

	function permit_reqRp_pd_new($pid)

	{

		$this->db->select('COUNT(*) as tot_buk');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

	    $this->db->where('monthly_permit_permit_status',3);

		$this->db->where('port_id',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_pd_mon_det_fr($pid)

	{

		$this->db->select('*');

        $this->db->from('monthly_permit');

		//$this->db->where('user_id',$uid);

		$this->db->join('zone','zone.zone_id=monthly_permit.zone_id');

		$this->db->join('lsgd','lsgd.lsgd_id=monthly_permit.lsg_id');

		$this->db->where('monthly_permit.port_id',$pid);

		//if($zid!=0)

		//{

		//	$this->db->where('monthly_permit.zone_id',$zid);

		//}

		//$this->db->where('monthly_permit.monthly_permit_period_name',$m_p);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function delete_reserve_day_by_date($port_id,$period_name,$holy_date){

		$this->db->where('holiday_period_name', $period_name);

		$this->db->where('holiday_port_id', $port_id);

		$this->db->where('holiday_date', $holy_date);

		$this->db->where('holiday_reserve_status', 1);

		$this->db->where('holiday_status', 0);

		$result=$this->db->delete('holiday');

		return $result;	

	}

function delete_holi_day_by_date($port_id,$period_name,$holy_date){

		$this->db->where('holiday_period_name', $period_name);

		$this->db->where('holiday_port_id', $port_id);

		$this->db->where('holiday_date', $holy_date);

		$this->db->where('holiday_reserve_status',0);

		$this->db->where('holiday_status',1);

		$result=$this->db->delete('holiday');

		return $result;	

	}

function get_monthly_permit_details($portid,$periodname)

{

		$this->db->select('*');

        $this->db->from('monthly_permit');

		$this->db->where('port_id',$portid);

		$this->db->where('monthly_permit_period_name',$periodname);

		$this->db->where('monthly_permit_permit_status !=', 3);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}



function decrement_working_days($period_name,$port_id){

		$this->db->where('holiday_port_period_name', $period_name);

		$this->db->where('holiday_port_port_id', $port_id);

		$this->db->set('working_days', 'working_days-1',FALSE);

		$res=$this->db->update('holiday_port');

		//echo $this->db->last_query();exit;

		return $res;

}

//------------------Gopikaaaaaa-----------------------

	function insert_usermaster($data)

	{

		$this->db->insert('user_master',$data);

		//$usermaster_insert_id	= 	$this->db->insert_id();

		//echo $this->db->insert_id();exit;

		return $this->db->insert_id();

		/*$query = $this->db->query('SELECT LAST_INSERT_ID()');

		$row = $query->row_array();

		return $row['LAST_INSERT_ID()'];*/

	}

function get_user_logs_pd()

{

		$this->db->select('*');

        $this->db->from('tbl_userlog');

		$this->db->join('user_master','user_master.user_master_id=tbl_userlog.user_id');

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function get_po_port()

	{

		$query = $this->db->query("select * from tbl_portoffice_master where tbl_portoffice_master.int_dredge_status=1 and ((SELECT COUNT('*') from port_officer WHERE port_id like '%tbl_portoffice_master.int_portoffice_id%')=0)");

		 $result = $query->result_array();

	  // echo $this->db->last_query();

        return $result;

	}

	function add_po_det($data)

	{

		$result=$this->db->insert('port_officer',$data);

		//echo $this->db->last_query();

		//exit;

		return $this->db->insert_id();

	}

	function get_po_ex()

	{

		$query=$this->db->query("SELECT GROUP_CONCAT(port_id) as port from port_officer WHERE port_status=1");

		$result = $query->result_array();

		//print_r($result);

        return $result;

	}

	function get_quantity_detailswk($portid)

	{

		$query    =    $this->db->query("select * from quantity  where  port_id='$portid' and quantity_status=1");

		//echo	$this->db->last_query();

		$result = $query->result_array();

		//print_r($result);

		return $result;       

	}

	function get_pc_ex()

	{

		$query=$this->db->query("SELECT GROUP_CONCAT(user_master_port_id) as port from user_master WHERE user_master_status=1 and user_master_id_user_type=3");

		$result = $query->result_array();

		//print_r($result);

        return $result;

	}

	function get_all_buk_his($id)

{

		$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration','customer_registration.customer_public_user_id=customer_booking.customer_booking_customer_booking');

		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=customer_booking.customer_booking_port_id');

		$this->db->join('zone','zone.zone_id=customer_booking.customer_booking_zone_id');

		$this->db->where('customer_booking.customer_booking_port_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function get_all_buk_his_by_zone($id,$zone_id)

{

		/*$this->db->select('*');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration','customer_registration.customer_public_user_id=customer_booking.customer_booking_customer_booking');

		$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=customer_booking.customer_booking_port_id');

		$this->db->join('zone','zone.zone_id=customer_booking.customer_booking_zone_id');

		$this->db->where('customer_booking.customer_booking_port_id',$id);

		$this->db->where('customer_booking.customer_booking_zone_id',$zone_id);

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

		// echo $this->db->last_query();exit;

        return $result;

		*/

		$this->db->select('customer_registration.customer_name,customer_registration.customer_phone_number,customer_booking.customer_booking_requested_timestamp,customer_booking.customer_booking_request_ton,customer_booking.customer_booking_token_number,customer_booking.customer_booking_priority_number,customer_booking.customer_booking_allotted_date,customer_booking.customer_booking_decission_status,customer_booking.customer_booking_pass_issue_user,customer_booking.customer_booking_id,customer_booking.customer_booking_chalan_amount');

        $this->db->from('customer_booking');

		$this->db->join('customer_registration','customer_registration.customer_public_user_id=customer_booking.customer_booking_customer_booking');

		//$this->db->join('tbl_portoffice_master','tbl_portoffice_master.int_portoffice_id=customer_booking.customer_booking_port_id');

		//$this->db->join('zone','zone.zone_id=customer_booking.customer_booking_zone_id');

		$this->db->where('customer_booking.customer_booking_port_id',$id);

		$this->db->where('customer_booking.customer_booking_zone_id',$zone_id);

		$this->db->order_by('customer_booking.customer_booking_priority_number','asc');

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

		//echo $this->db->last_query();//exit;

        return $result;

}



//19-09-2017

function get_portofficer_port($port_officer_id)

{

	$this->db->select('*');

	$this->db->from('port_officer');

	$this->db->where('po_user_id',$port_officer_id);

	$query = $this->db->get();

	$result = $query->result_array();

	return $result;

}

function get_all_buk_pay_suc($id)

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

		$this->db->order_by('customer_booking.customer_booking_priority_number', 'asc');

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

		//print_r($result);

        return $result;

	}		

//--------------------------------------------------------------------------------	

function get_all_buk_pay_suc_new($id)

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

		$this->db->where('customer_booking.customer_booking_request_status',1);

		$this->db->order_by('customer_booking.customer_booking_priority_number', 'asc');

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

		//print_r($result);

        return $result;

	}	

	function get_reserv_day($pid,$zone_id)

	{

		$today=date('Y-m-d');

		$this->db->select('holiday_date');

		$this->db->from('holiday');

		$this->db->where('holiday_date >=',$today);

		$this->db->where('holiday_reserve_status',1);

		$this->db->where('holiday_port_id',$pid);

		$this->db->where('holiday_zone_id',$zone_id);

		$this->db->order_by('holiday_date', 'asc');

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_daily_balforday($pid,$zone_id,$r_date)

	{

		//$today=date('Y-m-d');

		$this->db->select('daily_log_balance');

		$this->db->from('daily_log');

		$this->db->where('daily_log_date',$r_date);

		$this->db->where('daily_log_port_id',$pid);

		$this->db->where('daily_log_zone_id',$zone_id);

		$query = $this->db->get();

		//echo $this->db->last_query();

		//exit;

        $result = $query->result_array();

		if(!empty($result))

		{

			$balance_sand=$result[0]['daily_log_balance'];

		}

		else

		{

			$balance_sand=0;

		}

        return $balance_sand;

	}

	function get_buk_for_bukid($bid)

	{

		$this->db->select('*');

		$this->db->from('customer_booking');

		$this->db->join('customer_registration','customer_registration.customer_public_user_id=customer_booking.customer_booking_customer_booking');

		$this->db->where('customer_booking_id',$bid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_today_pass($pid,$zid)

	{	$today=date('Y-m-d');

		$sd=date('Y-m-d', strtotime($today. ' - 2 days'));

		$ed=date('Y-m-d', strtotime($today. ' + 2 days'));

		$this->db->select('customer_booking.customer_booking_request_ton,customer_booking.customer_booking_id,customer_booking.customer_booking_allotted_date,customer_registration.customer_name,customer_registration.customer_phone_number,transaction_details.payment_status');

		$this->db->from('customer_booking');

		$this->db->join('customer_registration','customer_registration.customer_registration_id=customer_booking.customer_booking_registration_id');

		$this->db->join('transaction_details','transaction_details.transaction_customer_booking_id=customer_booking.customer_booking_id');

		$this->db->where('customer_booking.customer_booking_port_id',$pid);

		$this->db->where('customer_booking.customer_booking_zone_id',$zid);

		$this->db->where('customer_booking.customer_booking_allotted_date <= ',$ed);

		$this->db->where('customer_booking.customer_booking_allotted_date > ',$sd);

		$this->db->order_by('customer_booking.customer_booking_allotted_date','desc');

		$query = $this->db->get();

	//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function vehiclepass_details_new($bookingid)

	{

		$this->db->select('*');

        $this->db->from('customer_booking');

		//$this->db->join('lsg_zone', 'customer_booking.customer_booking_lsg_id = lsg_zone.lsg_id ');

		//$this->db->join('lsgd', 'customer_booking.customer_booking_lsg_id = lsgd.lsgd_id');

		$this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');

		$this->db->where('customer_booking_id', $bookingid);

		$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('transaction_status', 1);

		$this->db->where('pass_dstatus', 2);

		$query = $this->db->get();

		//echo	$this->db->last_query(); 

		//exit();

		$result = $query->result_array();

        return $result;

	}

	function get_lsgdtype_by_id($lsgd_panchayth_id){

		$this->db->select('*');

        $this->db->from('tb_panchayath');

		$this->db->where('panchayath_sl',$lsgd_panchayth_id);

        $query = $this->db->get();

        $result = $query->row_array();

		return $result;

	}

	/////************ NEW MECH DREDGE************//////////////

	function get_materialratefu_mech($id)

	{

		$query = $this->db->query("SELECT * FROM `tbl_mdrate` WHERE `port_id` IS NULL or port_id=0 or port_id='$id'");

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function get_materialratefu_pd()

	{

		$query = $this->db->query("SELECT * FROM `tbl_mdrate` WHERE `port_id` IS NULL or port_id='0'");

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function get_mech_matforp($id)

	{

		$this->db->select('GROUP_CONCAT(material_id) as matid');

        $this->db->from('tbl_mdrate');

		$this->db->where('mat_domain',2);

		$this->db->where('port_id',$id);

		$this->db->where('mdrate_status',1);

		$query = $this->db->get();

		//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

	}

	function get_mech_materialrate_act_pc($pid)

	{

		$this->db->select("GROUP_CONCAT(material_id) as mat_id");

        $this->db->from('tbl_mdrate');

		$this->db->where('mdrate_status',1);

		$this->db->where('mat_domain',2);

		$this->db->where('port_id',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_mech_materialrate_act()

	{

		$this->db->select("GROUP_CONCAT(material_id) as mat_id");

        $this->db->from('tbl_mdrate');

		$this->db->where('mdrate_status',1);

		$this->db->where('mat_domain',1);

		//$this->db->where('port_id',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function add_material_rate_mech($data)

	{

		$result=$this->db->insert('tbl_mdrate',$data);

		return $result;

	}

	function update_mech_material_rate_master($id,$data)

	{

		$this->db->where('mdrate_id',$id);

		$result		=	$this->db->update('tbl_mdrate',$data);

        return $result;

	}

	function get_materialrate_mech_byid($id)

	{

		$this->db->select('*');

        $this->db->from('tbl_mdrate');

		$this->db->where('mdrate_id',$id);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrateByMatID_mech($id)

	{

		$this->db->select('*');

        $this->db->from('tbl_mdrate');

		$this->db->where('material_id',$id);

		$this->db->where('mdrate_status',1);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	function get_materialrateByMatID_port_mech($id,$pid)

	{

		$this->db->select('*');

        $this->db->from('tbl_mdrate');

		$this->db->where('material_id',$id);

		$this->db->where('mdrate_status',1);

		$this->db->where('port_id',$pid);

		$query = $this->db->get();

        $result = $query->result_array();

        return $result;

	}

	/////////////////////*************************************

	function reject_monthly_permitnew($port_id,$zone_id,$period_name)

	{

		$this->db->where('monthly_permit_period_name',$period_name);

		$this->db->where('port_id',$port_id);

		$this->db->where('zone_id',$zone_id);

		$data=array('monthly_permit_permit_status'=>3);

		$result	= $this->db->update('monthly_permit',$data);

        return $result;

	} 

	//----------------------------------------------------------

	function get_today_pass_pc($pid,$zid)

	{

		

		$today=date('Y-m-d');

		$sd=date('Y-m-d', strtotime($today. ' - 2 days'));

		$ed=date('Y-m-d', strtotime($today. ' + 2 days'));

		$this->db->select('customer_booking.customer_booking_request_ton,customer_booking.customer_booking_id,customer_booking.customer_booking_allotted_date,customer_registration.customer_name,customer_registration.customer_phone_number,transaction_details.payment_status');

		$this->db->from('customer_booking');

		$this->db->join('customer_registration','customer_registration.customer_registration_id=customer_booking.customer_booking_registration_id');

		$this->db->join('transaction_details','transaction_details.transaction_customer_booking_id=customer_booking.customer_booking_id');

		$this->db->where('customer_booking.customer_booking_port_id',$pid);

		$this->db->where('customer_booking.customer_booking_zone_id',$zid);

		$this->db->where('customer_booking.customer_booking_allotted_date < ',$ed);

		$this->db->where('customer_booking.customer_booking_allotted_date > ',$sd);

		$this->db->order_by('customer_booking.customer_booking_allotted_date','desc');

		$query = $this->db->get();

	//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;

		/*$today=date('Y-m-d');

		$sd=date('Y-m-d', strtotime($today. ' - 2 days'));

		$ed=date('Y-m-d', strtotime($today. ' + 2 days'));

		$this->db->select('*');

		$this->db->from('customer_booking');

		$this->db->join('customer_registration','customer_registration.customer_public_user_id=customer_booking.customer_booking_customer_booking');

		$this->db->join('transaction_details','transaction_details.transaction_customer_booking_id=customer_booking.customer_booking_id');

		$this->db->where('customer_booking.customer_booking_port_id',$pid);

		$this->db->where('customer_booking.customer_booking_zone_id',$zid);

		$this->db->where('customer_booking.customer_booking_allotted_date < ',$ed);

		$this->db->where('customer_booking.customer_booking_allotted_date > ',$sd);

		$this->db->order_by('customer_booking.customer_booking_priority_number','asc');

		$query = $this->db->get();

	//echo $this->db->last_query();

        $result = $query->result_array();

        return $result;*/

	}

	//---------------------------25/01/2018------------------------------------------------

	function get_transRPT($tokennumnber,$aadharnumber)

{

$this->db->select('*');

        $this->db->from('transaction_details');

		$this->db->join('customer_registration', 'transaction_details.transaction_customer_registration_id = customer_registration.customer_registration_id');

		$this->db->where('customer_registration.customer_aadhar_number', $aadharnumber);

		$this->db->where('transaction_details.token_no', $tokennumnber);

		$this->db->where('transaction_status', 1);

		$this->db->where('payment_status', 1);

		$this->db->where('print_status', 1);

		$query = $this->db->get();

		//echo	$this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

}



function bookingdet($bookingid)

{

$this->db->select('*');

 $this->db->from('customer_booking');

 $this->db->where('customer_booking_id', $bookingid);

 $this->db->where('customer_booking_decission_status', 2);

 $query = $this->db->get();

		//echo	$this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

}



function get_pass_reprintAPP($portid)

	{

		//echo "select * from sandpass_reprint join transaction_details on sandpass_reprint.customer_booking_id = transaction_details.transaction_customer_booking_id where sandpass_reprint.port_id='$portid' and transaction_status=1 and payment_status =1 and print_status=1 and  approved_user_id=0 ";

		//$this->db->select('*');";

		//$query=$this->db->query("select * from sandpass_reprint join transaction_details on sandpass_reprint.customer_booking_id = transaction_details.transaction_customer_booking_id where sandpass_reprint.port_id='$portid' and transaction_status=1 and payment_status =1 and print_status=1 and  approved_user_id=0 ");

		$this->db->select('*');

        $this->db->from('sandpass_reprint');

		//$this->db->join('customer_booking', 'sandpass_reprint.customer_booking_id= customer_booking.customer_booking_id');

		//$this->db->join('customer_registration', 'sandpass_reprint.customer_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'sandpass_reprint.customer_booking_id = transaction_details.transaction_customer_booking_id ');	

		//$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('sandpass_reprint.port_id', $portid);

		$this->db->where('transaction_status', 1);

		$this->db->where('payment_status', 1);

		$this->db->where('print_status', 1);

		$this->db->where('approved_user_id', 0);

		

		$query = $this->db->get();

		//echo $this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

	}



function get_pass_reprintApproved($portid)

	{

		$this->db->select('*');

        $this->db->from('sandpass_reprint');

		//$this->db->join('customer_booking', 'sandpass_reprint.customer_registration_id = customer_booking.customer_booking_registration_id and sandpass_reprint.customer_booking_id= customer_booking.customer_booking_id');

		//$this->db->join('customer_registration', 'sandpass_reprint.customer_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'sandpass_reprint.customer_booking_id = transaction_details.transaction_customer_booking_id ');	

		//$this->db->where('customer_booking_decission_status', 2);

		$this->db->where('sandpass_reprint.port_id', $portid);

		$this->db->where('transaction_status', 1);

		$this->db->where('payment_status', 1);

		$this->db->where('print_status', 0);

		$this->db->where('approved_user_id <>', 0);

		

		$query = $this->db->get();

		//echo $this->db->last_query(); //exit();

		$result = $query->result_array();

        return $result;

	}



function get_cust_det($regid)

{

$this->db->select('*');

 $this->db->from('customer_registration');

 $this->db->where('customer_registration_id', $regid);

 $this->db->where('customer_request_status', 2);

 $query = $this->db->get();

		//echo	$this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

}



function get_pass_reprint($portid,$passid)

	{

	$this->db->select('*');

        $this->db->from('sandpass_reprint');

		//$this->db->join('customer_booking', 'sandpass_reprint.customer_registration_id = customer_booking.customer_booking_registration_id and sandpass_reprint.customer_booking_id= customer_booking.customer_booking_id');

		//$this->db->join('customer_registration', 'sandpass_reprint.customer_registration_id = customer_registration.customer_registration_id');

		$this->db->join('transaction_details', 'sandpass_reprint.customer_booking_id = transaction_details.transaction_customer_booking_id');	

		$this->db->where('sandpass_reprint.port_id', $portid);

		$this->db->where('sandpass_reprint.sandpass_reprint_id', $passid);

		$this->db->where('transaction_status', 1);

		$this->db->where('payment_status', 1);

		$this->db->where('print_status', 1);

		$this->db->where('approved_user_id', 0);

		

		$query = $this->db->get();

		//echo $this->db->last_query(); exit();

		$result = $query->result_array();

        return $result;

	}

	//-------------------------------------------------------------------------------------

	/*function get_zone_spot($portid)

{

$this->db->select('*');

        $this->db->from('spot_kadavu');

		$this->db->where('port_id',$portid);

		$query = $this->db->get();

		//echo	$this->db->last_query(); 

	//	exit();

        $result = $query->result_array();

        return $result;

}*/





function get_portspot()

	{

		$this->db->select('*');

        $this->db->from('tbl_portoffice_master');

		$this->db->join('spot_kadavu','spot_kadavu.port_id=tbl_portoffice_master.int_portoffice_id');

		$this->db->where('int_dredge_status',1);

		$this->db->group_by('spot_kadavu.port_id'); 

		$query = $this->db->get();

		//echo	$this->db->last_query(); exit;

        $result = $query->result_array();

        return $result;

	}

	

	function customer_spot_msg($id){

		$this->db->select('*');

        $this->db->from('tbl_spotbooking');

		$this->db->where('spotreg_id',$id);

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_limit_balance($port_id,$zone_id)

	{

	$today=date('Y-m-d');

	$query = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and   spot_limit_date='$today'");

		//echo $this->db->last_query(); exit();

        $result = $query->result_array();

        return $result;

	}

	

	function customerspotbooking_timecheck()

{

		$this->db->select('*');

        $this->db->from('spot_booking_master');

		$query = $this->db->get();

        $result = $query->result_array();

		//print_r($result);

        return $result;

}

function get_limit_port($port_id)

	{

	$today=date('Y-m-d');

	$query = $this->db->query("SELECT * FROM `spot_booking_limit` join zone on zone.zone_id=spot_booking_limit.spot_limit_zone_id WHERE `spot_limit_port_id`='$port_id' order by spot_limit_date desc");

		//echo $this->db->last_query(); //exit();

        $result = $query->result_array();

        return $result;

	}

	

	function get_zone_spot($portid)

{

$this->db->select('*');

        $this->db->from('spot_kadavu');

		$this->db->join('zone','spot_kadavu.zone_id=zone.zone_id');

		$this->db->where('port_id',$portid);

		$query = $this->db->get();

		//echo	$this->db->last_query(); 

	//	exit();

        $result = $query->result_array();

        return $result;

}

	

	//--------------------------------------------------------------------------------------------------------------

	function get_customer_registration_ph($phone_no){

		$this->db->select('*');

        $this->db->from('customer_registration');

		$this->db->where('customer_request_status<>' ,3);

		$this->db->where('customer_phone_number',$phone_no);

        $query = $this->db->get();

        $result = $query->result_array();

		//echo $this->db->last_query();break;

		return $result;

	}

	function get_module_assign($see_user_id)

	{

		$query = $this->db->query("SELECT * FROM `assign_module`join tbl_module on tbl_module.module_id=assign_module.module_id where user_master_id='$see_user_id' AND assign_module_status=1");

		//echo $this->db->last_query(); //exit();

        $result = $query->result_array();

        return $result;

	}
	
	
	function vehiclepass_detailScan($tokenno)
{
	$this->db->select('*');
        $this->db->from('customer_booking');
		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');
		$this->db->where('customer_booking_token_number', $tokenno);
		$this->db->where('customer_booking_decission_status', 2);
		$this->db->where('transaction_status', 1);
		$query = $this->db->get();
		$result = $query->result_array();
        return $result;
		
}
//---------------------------------------
	function convertToHoursMinsnew($time, $format = '%02d:%02d') 
{
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}
	//-------------------------------------------
	
	function get_zone_detailsnew_nn($portid,$zoneid,$periodname)

{

			$urdate=date('Y-m-d');

			//$query    =    $this->db->query("select * from zone join lsg_zone join monthly_permit where zone.zone_id = lsg_zone.zone_id and lsg_zone.lsg_zone_port_id=monthly_permit.port_id and lsg_zone.zone_id=monthly_permit.zone_id and (monthly_permit.monthly_permit_end_date > '$urdate' || monthly_permit.monthly_permit_end_date= '$urdate')and lsg_zone.lsg_zone_port_id='$portid' and lsg_zone_status=1 and monthly_permit.monthly_permit_permit_status=2");

			//echo $this->db->last_query();

			$query    =    $this->db->query("select * from zone join lsg_zone join monthly_permit where zone.zone_id = lsg_zone.zone_id and lsg_zone.lsg_zone_port_id=monthly_permit.port_id and lsg_zone.zone_id=monthly_permit.zone_id and monthly_permit.monthly_permit_period_name='$periodname' and lsg_zone.lsg_zone_port_id='$portid' and lsg_zone_status=1 and monthly_permit.monthly_permit_permit_status=2 and lsg_zone.zone_id='$zoneid'");

			$result = $query->result_array();

			

        	return $result;

}
	//-----------------------------------------------------------------------------------------
	#
	#
	#
	#
	#
	//-----------------------------------------------------------------------------------------
	function onlinepay_details($bookingid)
{
	$this->db->select('*');
       $this->db->from('customer_booking');
	   $this->db->join('customer_registration', 'customer_booking.customer_booking_registration_id = customer_registration.customer_registration_id');
	   
		$this->db->join('transaction_details', 'customer_booking.customer_booking_id = transaction_details.transaction_customer_booking_id');
		$this->db->where('customer_booking_id', $bookingid);
		$this->db->where('customer_booking_decission_status', 2);
		$this->db->where('transaction_status', 0);
		$query = $this->db->get();
		//echo	$this->db->last_query(); 
		//exit();
		$result = $query->result_array();
        return $result;
		
}
	function onlinebank_type()
{
	$this->db->select('*');
       $this->db->from('bank_type');
	  	$this->db->where('bank_status', 1);
		$query = $this->db->get();
		//echo	$this->db->last_query(); 
		//exit();
		$result = $query->result_array();
        return $result;
		
}
	
	function onlinetrans_details($bookingid)
{
	$this->db->select('*');
       $this->db->from('bank_transactionnw');
	   $this->db->join('customer_registration', 'bank_transactionnw.customer_registration_id = customer_registration.customer_registration_id');
 
		$this->db->where('bank_transaction_id', $bookingid);
		
		$this->db->where('transaction_status', 1);
		$query = $this->db->get();
		//echo	$this->db->last_query(); 
	//	exit();
		$result = $query->result_array();
        return $result;
		
}
function get_module($mod_id)     
{ 

	$query 	= 	$this->db->query("SELECT * FROM main_module WHERE main_module_id IN ($mod_id)");
	$result = 	$query->result_array();
	return $result;
	
}	
	function get_port_id($user)
{
	$this->db->select('user_master_port_id');
	//$this->db->select('*');
       $this->db->from('user_master');
	  	$this->db->where('user_master_status', 1);
	  	$this->db->where('user_master_id', $user);
		$query = $this->db->get();
		//echo	$this->db->last_query(); 
		//exit();
		$result = $query->result_array();
        return $result;
		
}
function get_module_new($user,$port)     
{ 

	$query 	= 	$this->db->query("SELECT * FROM user_master AS um JOIN tbl_permission_port as pp ON um.user_master_port_id=pp.port_id WHERE um.user_master_id=$user AND um.user_master_port_id=$port AND pp.permission_status=1 AND um.user_master_status=1");
	$result = 	$query->result_array();
	return $result;
	
}

function get_active_logo()
{
	$this->db->select('bodycontent_image');
    $this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_identifier_sl', 1);
	$this->db->where('bodycontent_status_sl', 1);
	$this->db->where('bodycontent_location_sl', 1);
	$this->db->where('bodycontent_ctype<>', 2);
	$query = $this->db->get();
	$result = $query->result_array();
    return $result;
		
}

function get_active_registration()
{
	$this->db->select('*');
    $this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_identifier_sl', 4);
	$this->db->where('bodycontent_status_sl', 1);
	$this->db->where('bodycontent_ctype<>', 2);
	$query = $this->db->get();
	$result = $query->result_array();
    return $result;
		
}

function get_active_marquee_notfn()
{
	$this->db->select('*');
    $this->db->from('tb_webnotification');
	//$this->db->where('webnotification_module', 2);
	$this->db->where('webnotification_status', 1);
	$this->db->where('webnotification_ctype<>', 2);
	$query = $this->db->get();
	$result = $query->result_array();
    return $result;
		
}

function get_active_registration_items()
{
	$this->db->select('*');
    $this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_identifier_sl', 5);
	$this->db->where('bodycontent_status_sl', 1);
	$this->db->where('bodycontent_ctype<>', 2);
	$this->db->order_by('bodycontent_order','asc');
	$query = $this->db->get();
	$result = $query->result_array();
    return $result;
		
}

function get_active_services()
{
	$this->db->select('*');
    $this->db->from('tb_services');
	//$this->db->where('webnotification_module', 2);
	$this->db->where('services_status', 1);
	$this->db->where('services_ctype<>', 2);
	$query = $this->db->get();
	$result = $query->result_array();
    return $result;
		
}

function get_active_services_byid($id)
{
	$this->db->select('*');
    $this->db->from('tb_services');
	$this->db->where('services_sl', $id);
	$this->db->where('services_status', 1);
	$this->db->where('services_ctype<>', 2);
	$query = $this->db->get();
	$result = $query->result_array();
    return $result;
		
}

function get_active_footer()
{
	$this->db->select('*');
    $this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_identifier_sl', 6);
	$this->db->where('bodycontent_status_sl', 1);
	$this->db->where('bodycontent_ctype<>', 2);
	$this->db->order_by('bodycontent_order','asc');
	$query = $this->db->get();
	$result = $query->result_array();
    return $result;
		
}

function get_active_footer_item($loc)
{
	$this->db->select('*');
    $this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_identifier_sl', 7);
	$this->db->where('bodycontent_status_sl', 1);
	$this->db->where('bodycontent_ctype<>', 2);
	$this->db->where('bodycontent_location_sl', $loc);
	$this->db->order_by('bodycontent_order','asc');
	$query = $this->db->get();
	$result = $query->result_array();
    return $result;
		
}

function get_active_footer_item_det($id)
{
	$this->db->select('*');
    $this->db->from('tb_bodycontent');
	$this->db->where('bodycontent_identifier_sl', 7);
	$this->db->where('bodycontent_status_sl', 1);
	$this->db->where('bodycontent_ctype<>', 2);
	$this->db->where('bodycontent_sl', $id);
	$this->db->order_by('bodycontent_order','asc');
	$query = $this->db->get();
	$result = $query->result_array();
    return $result;
		
}

function get_active_portoffices()     
{ 
	$this->db->select('int_portoffice_id');
	$this->db->select('vchr_portoffice_name');
	$this->db->select('portofregistry_mal_name');
	$this->db->select('vchr_portoffice_address');
	$this->db->select('vchr_portoffice_maladdress');
	$this->db->select('vchr_portoffice_phone');
	$this->db->select('vchr_portoffice_email');
	$this->db->select('portoffice_map');
	$this->db->select('int_status');
	$this->db->from('tbl_portoffice_master');
	//$this->db->where('int_status', 1);
	$this->db->order_by('vchr_portoffice_name','asc');
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
	
}

function get_active_port($id)     
{ 
	$this->db->select('int_portoffice_id');
	$this->db->select('vchr_portoffice_name');
	$this->db->select('portofregistry_mal_name');
	$this->db->select('vchr_portoffice_address');
	$this->db->select('vchr_portoffice_maladdress');
	$this->db->select('vchr_portoffice_phone');
	$this->db->select('vchr_portoffice_email');
	$this->db->select('portoffice_map');
	$this->db->select('int_status');
	$this->db->from('tbl_portoffice_master');
	//$this->db->where('int_status', 1);
	$this->db->where('int_portoffice_id', $id);
	$this->db->order_by('vchr_portoffice_name','asc');
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
	return $result; 
	
}

function get_active_port_services($id)     
{ 
	$this->db->select('*');
	$this->db->from('tb_portservices');
	$this->db->where('portservices_status', 1);
	$this->db->where('portservices_ctype<>', 2);
	$this->db->where('portservices_port_sl', $id);
	$query 		= 	$this->db->get();
	$result 	= 	$query->result_array();
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
	
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}

function get_vesselsubtype_dynamic($type_id)
{
	$this->db->select('vessel_subtype_sl');
	$this->db->select('vessel_subtype_name');
	$this->db->select('vessel_subtype_mal_name');
	$this->db->from('kiv_vessel_subtype_master');
	$this->db->where('vessel_subtype_vesseltype_id', $type_id);
	$this->db->where('delete_status', 0);

	$this->db->order_by('vessel_subtype_vesseltype_id',$type_id);
	
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;
}

function get_survey_type()     
{
	$this->db->select('*');
	$this->db->from('kiv_survey_master');
	$this->db->where('delete_status', 0);
	
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
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
	
	$query 	= 	$this->db->get();
	$result = 	$query->result_array();
	return $result;


}

function get_det_tariff_public($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name)     
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
		//$this->db->where('kiv_tariff_master.start_date',$startDate);
		//$this->db->where('kiv_tariff_master.end_date',$endDate);
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

   function get_tonnagetype_tariff($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name)     
    {
    
    	$this->db->select('kiv_tariff_master.tariff_sl');
        $this->db->select('kiv_tariff_master.tariff_activity_id');
		$this->db->select('kiv_tariff_master.tariff_form_id');
		$this->db->select('kiv_tariff_master.tariff_vessel_type_id');
		$this->db->select('kiv_tariff_master.tariff_vessel_subtype_id');
		$this->db->select('kiv_tariff_master.tariff_tonnagetype_id');
		$this->db->select('kiv_tariff_master.tariff_day_type');
		$this->db->from('kiv_tariff_master');
		$this->db->where('kiv_tariff_master.tariff_activity_id',$surveyName);
		$this->db->where('kiv_tariff_master.tariff_form_id',$formtypeName);
		$this->db->where('kiv_tariff_master.tariff_vessel_type_id',$vesseltype_name);
		$this->db->where('kiv_tariff_master.tariff_vessel_subtype_id',$vessel_subtype_name);
		$this->db->where('kiv_tariff_master.delete_status', 0);
		$this->db->join('kiv_tonnagetype_master','kiv_tonnagetype_master.tonnagetype_sl=kiv_tariff_master.tariff_tonnagetype_id');
		$this->db->group_by('kiv_tariff_master.tariff_tonnagetype_id');

		$query 	= 	$this->db->get();
		$result = 	$query->result_array();
		return $result;

    } 

    function get_det_tariff_range_public($surveyName,$formtypeName,$vesseltype_name,$vessel_subtype_name,$tonnage)     
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
		$this->db->where('kiv_tariff_master.tariff_from_ton <=',$tonnage);
		$this->db->where('kiv_tariff_master.tariff_to_ton >=',$tonnage);
		//$this->db->where('kiv_tariff_master.start_date',$startDate);
		//$this->db->where('kiv_tariff_master.end_date',$endDate);
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

    function get_dataentry_details_pc($port_id)
{
    $this->db->select('*');
    $this->db->from('tb_vessel_dataentry');
    $this->db->where('dataentry_portoffice_id',$port_id);
    $this->db->where('dataentry_approved_status','0');
    $this->db->order_by('dataentry_date','DESC');
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
	//-----------------------------------------------------------------------------------------
	
}

?>