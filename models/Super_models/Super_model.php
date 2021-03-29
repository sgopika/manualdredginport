<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Super_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	

 	function get_supermenu($usertype)     
    { 
		$this->db->select('*');
		$this->db->from('sub_module');
		$this->db->where('user_type_id',$usertype);
		$this->db->where('main_module_id',0);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function get_logo_list()     
    { 
    	$this->db->select('bodycontent_sl');
		$this->db->select('bodycontent_image');
		$this->db->select('bodycontent_location_sl');
		$this->db->select('bodycontent_status_sl');
		$this->db->select('bodycontent_ctype');
		$this->db->select('bodycontent_identifier_sl');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_identifier_sl',1);
		 $query 		= 	$this->db->get();
		//echo $this->db->last_query();
	 
		$result 	= 	$query->result_array();
		//print_r($result);exit();
		return $result; 
		
	}

	function get_location()     
    { 
    	$this->db->select('location_sl');
		$this->db->select('location_name');
		$this->db->from('tb_location');
		$this->db->where('location_status',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function get_location_byid($location_sl)     
    { 
    	$this->db->select('location_name');
		$this->db->from('tb_location');
		$this->db->where('location_status',1);
		$this->db->where('location_sl',$location_sl);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_logo_insert($location)     
    { 
    	$this->db->select('bodycontent_sl');
		$this->db->select('bodycontent_image');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',0);
		$this->db->where('bodycontent_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_logo_status($data,$bodycontent_sl){
	
		$where 		= 	"bodycontent_sl  = '$bodycontent_sl' AND bodycontent_identifier_sl = 1"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	} 

	function edit_logo($id,$data){
		$this->db->where('bodycontent_sl',$id);
		$this->db->where('bodycontent_identifier_sl',1);
		//$where 		= " bodycontent_sl  = '$id' AND bodycontent_identifier_sl = 1"; 
        $result 	= $this->db->update('tb_bodycontent', $data);//echo $this->db->last_query();

        //$rs			=	$this->db->query($res);
      	return $result;

	}

	function get_title_list()     
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
		$this->db->where('bodycontent_identifier_sl',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}
	
	function check_duplication_title_insert($title_eng,$title_mal,$tagline_eng,$tagline_mal,$location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_engcontent');
		$this->db->select('bodycontent_malcontent');
		$this->db->select('bodycontent_location_sl');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_location_sl',$title_eng);
		$this->db->where('bodycontent_location_sl',$title_mal);
		$this->db->where('bodycontent_location_sl',$tagline_eng);
		$this->db->where('bodycontent_location_sl',$tagline_mal);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',2);
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_title_status($data,$bodycontent_sl){
	
		$where 		= 	"bodycontent_sl  = '$bodycontent_sl' AND bodycontent_identifier_sl = 2"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function edit_title($id,$data){
		$where 		= " bodycontent_sl  = '$id' AND bodycontent_identifier_sl = 2"; 
        $result 	= $this->db->update('tb_bodycontent', $data, $where);
      	return $result;

	} 

	function get_title_det($id)     
    { 
    	$this->db->select('*');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_identifier_sl',2);
		$this->db->where('bodycontent_sl',$id);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_title($data,$id){
	
		$where 		= 	"bodycontent_sl  = '$id' AND bodycontent_identifier_sl = 2"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	} 

	function get_banner_list()     
    { 
    	$this->db->select('bodycontent_sl');
		$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_link');
		$this->db->select('bodycontent_buttonclass');
		$this->db->select('bodycontent_icon');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_location_sl');
		$this->db->select('bodycontent_status_sl');
		$this->db->select('bodycontent_ctype');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_identifier_sl',3);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_banner_insert($title_eng,$title_mal,$location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_link');
		$this->db->select('bodycontent_buttonclass');
		$this->db->select('bodycontent_icon');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_location_sl');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_engtitle',$title_eng);
		$this->db->where('bodycontent_maltitle',$title_mal);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',3);
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_max_count($location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',3);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_order_exist($order,$location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_order',$order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',3);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_banner_status($data,$bodycontent_sl){
	
		$where 		= 	"bodycontent_sl  = '$bodycontent_sl' AND bodycontent_identifier_sl = 3"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function edit_banner($id,$data){
		$where 		= " bodycontent_sl  = '$id' AND bodycontent_identifier_sl = 3"; 
        $result 	= $this->db->update('tb_bodycontent', $data, $where);
      	return $result;

	}

	function get_banner_det($id)     
    { 
    	$this->db->select('*');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_identifier_sl',3);
		$this->db->where('bodycontent_sl',$id);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_banner($data,$id){
	
		$where 		= 	"bodycontent_sl  = '$id' AND bodycontent_identifier_sl = 3"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}


	function check_order_exist_edit($order,$location,$id)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_order',$order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_sl<>',$id);
		$this->db->where('bodycontent_identifier_sl',3);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_banner_edit($title_eng,$title_mal,$location,$edit)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_link');
		$this->db->select('bodycontent_buttonclass');
		$this->db->select('bodycontent_icon');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_location_sl');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_sl<>',$edit);
		$this->db->where('bodycontent_engtitle',$title_eng);
		$this->db->where('bodycontent_maltitle',$title_mal);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',3);
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function get_registration_list()     
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
		$this->db->where('bodycontent_identifier_sl',4);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_regn_insert($location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_engcontent');
		$this->db->select('bodycontent_malcontent');
		$this->db->select('bodycontent_location_sl');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',4);
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_regn_status($data,$bodycontent_sl){
	
		$where 		= 	"bodycontent_sl  = '$bodycontent_sl' AND bodycontent_identifier_sl = 4"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function edit_regn($id,$data){
		$where 		= " bodycontent_sl  = '$id' AND bodycontent_identifier_sl = 4"; 
        $result 	= $this->db->update('tb_bodycontent', $data, $where);
      	return $result;

	}

	function get_regn_det($id)     
    { 
    	$this->db->select('*');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_identifier_sl',4);
		$this->db->where('bodycontent_sl',$id);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_registration($data,$id){
	
		$where 		= 	"bodycontent_sl  = '$id' AND bodycontent_identifier_sl = 4"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}



	function get_registration_item_list()     
    { 
    	$this->db->select('bodycontent_sl');
		$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_icon');
		$this->db->select('bodycontent_link');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_location_sl');
		$this->db->select('bodycontent_status_sl');
		$this->db->select('bodycontent_ctype');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_identifier_sl',5);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_regnitem_insert($registration_item_eng,$registration_item_mal,$registration_item_icon,$registration_item_link,$registration_item_order,$location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_icon');
		$this->db->select('bodycontent_link');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_location_sl');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_engtitle',$registration_item_eng);
		$this->db->where('bodycontent_maltitle',$registration_item_mal);
		$this->db->where('bodycontent_icon',$registration_item_icon);
		$this->db->where('bodycontent_link',$registration_item_link);
		$this->db->where('bodycontent_order',$registration_item_order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',5);
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_maxrow_insert($location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',5);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_regn_order_exist($order,$location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_order',$order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',5);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_regn_item_status($data,$bodycontent_sl){
	
		$where 		= 	"bodycontent_sl  = '$bodycontent_sl' AND bodycontent_identifier_sl = 5"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function edit_regn_item($id,$data){
		$where 		= " bodycontent_sl  = '$id' AND bodycontent_identifier_sl = 5"; 
        $result 	= $this->db->update('tb_bodycontent', $data, $where);
      	return $result;

	}

	function get_regn_item_det($id)     
    { 
    	$this->db->select('*');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_identifier_sl',5);
		$this->db->where('bodycontent_sl',$id);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_regnitem_edit($title_eng,$title_mal,$icon,$link,$order,$location,$edit)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_link');
		$this->db->select('bodycontent_icon');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_location_sl');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_sl<>',$edit);
		$this->db->where('bodycontent_engtitle',$title_eng);
		$this->db->where('bodycontent_maltitle',$title_mal);
		$this->db->where('bodycontent_link',$link);
		$this->db->where('bodycontent_icon',$icon);
		$this->db->where('bodycontent_order',$order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',5);
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_regnitem_order_exist_edit($order,$location,$id)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_order',$order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_sl<>',$id);
		$this->db->where('bodycontent_identifier_sl',5);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_registration_item($data,$id){
	
		$where 		= 	"bodycontent_sl  = '$id' AND bodycontent_identifier_sl = 5"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function get_footer_list()     
    { 
    	$this->db->select('bodycontent_sl');
		$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_location_sl');
		$this->db->select('bodycontent_status_sl');
		$this->db->select('bodycontent_ctype');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_identifier_sl',6);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_footer_insert($footer_eng,$footer_mal,$footer_order,$location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_location_sl');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_engtitle',$footer_eng);
		$this->db->where('bodycontent_maltitle',$footer_mal);
		$this->db->where('bodycontent_order',$footer_order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',6);
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_maxfooter_insert($location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',6);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_footerorder_exist($order,$location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_order',$order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',6);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_footer_status($data,$bodycontent_sl){
	
		$where 		= 	"bodycontent_sl  = '$bodycontent_sl' AND bodycontent_identifier_sl = 6"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function edit_footer($id,$data){
		$where 		= " bodycontent_sl  = '$id' AND bodycontent_identifier_sl = 6"; 
        $result 	= $this->db->update('tb_bodycontent', $data, $where);
      	return $result;

	}

	function get_footer_det($id)     
    { 
    	$this->db->select('*');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_identifier_sl',6);
		$this->db->where('bodycontent_sl',$id);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_footer_edit($footer_eng,$footer_mal,$footer_order,$location,$edit_id)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_engtitle',$footer_eng);
		$this->db->where('bodycontent_maltitle',$footer_mal);
		$this->db->where('bodycontent_order',$footer_order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_sl<>',$edit_id);
		$this->db->where('bodycontent_identifier_sl',6);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_maxfooter_edit($location,$id)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_sl<>',$id);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',6);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_footer_order_exist_edit($order,$location,$id)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_order',$order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_sl<>',$id);
		$this->db->where('bodycontent_identifier_sl',6);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_footer($data,$id){
	
		$where 		= 	"bodycontent_sl  = '$id' AND bodycontent_identifier_sl = 6"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function get_footer_item_list()     
    { 
    	
    	$this->db->select('bodycontent_sl');
		$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_engcontent');
		$this->db->select('bodycontent_malcontent');
		$this->db->select('bodycontent_link');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_location_sl');
		$this->db->select('bodycontent_status_sl');
		$this->db->select('bodycontent_ctype');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_identifier_sl',7);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function get_footer_list_item()     
    { 
    	$this->db->select('bodycontent_sl');
		$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_link');
		$this->db->select('bodycontent_location_sl');
		$this->db->select('bodycontent_status_sl');
		$this->db->select('bodycontent_ctype');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_identifier_sl',6);
		$this->db->where('bodycontent_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_footer_item_insert($footer_item_eng,$footer_item_mal,$footer_item_tagline_eng,$footer_item_tagline_mal,$footer_item_order,$location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_engcontent');
		$this->db->select('bodycontent_malcontent');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_link');
		$this->db->select('bodycontent_location_sl');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_engtitle',$footer_item_eng);
		$this->db->where('bodycontent_maltitle',$footer_item_mal);
		$this->db->where('bodycontent_engtitle',$footer_item_tagline_eng);
		$this->db->where('bodycontent_maltitle',$footer_item_tagline_mal);
		$this->db->where('bodycontent_order',$footer_item_order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',7);
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_footeritemorder_exist($order,$location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_order',$order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',7);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_maxfooteritem_insert($location)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',7);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_footer_item_status($data,$bodycontent_sl,$loc){
	
		$where 		= 	"bodycontent_sl  = '$bodycontent_sl' AND bodycontent_identifier_sl = $loc"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function edit_footer_item($id,$data){
		$where 		= " bodycontent_sl  = '$id'"; 
        $result 	= $this->db->update('tb_bodycontent', $data, $where);
      	return $result;

	}

	function get_footer_item_det($id,$loc)     
    { 
    	$this->db->select('*');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_identifier_sl',7);
		$this->db->where('bodycontent_location_sl',$loc);

		$this->db->where('bodycontent_sl',$id);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}
	function get_footer_location_byid($id)     
    { 
    	$this->db->select('*');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_identifier_sl',6);
		$this->db->where('bodycontent_sl',$id);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_footer_item_edit($footer_item_eng,$footer_item_mal,$footer_item_tagline_eng,$footer_item_tagline_mal,$footer_item_order,$location,$edit_id)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->select('bodycontent_engcontent');
		$this->db->select('bodycontent_malcontent');
		$this->db->select('bodycontent_order');
		$this->db->select('bodycontent_location_sl');
		$this->db->select('bodycontent_link');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_engtitle',$footer_item_eng);
		$this->db->where('bodycontent_maltitle',$footer_item_mal);
		$this->db->where('bodycontent_engtitle',$footer_item_tagline_eng);
		$this->db->where('bodycontent_maltitle',$footer_item_tagline_mal);
		$this->db->where('bodycontent_order',$footer_item_order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',7);
		$this->db->where('bodycontent_sl<>',$edit_id);
		$this->db->where('bodycontent_ctype<>',2);
		$this->db->where('bodycontent_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result;
		
	}

	function check_maxfooteritem_edit($location,$id)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_identifier_sl',7);
		$this->db->where('bodycontent_sl<>',$id);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_footer_itemorder_exist_edit($order,$location,$id)     
    { 
    	$this->db->select('bodycontent_sl');
    	$this->db->select('bodycontent_engtitle');
		$this->db->select('bodycontent_maltitle');
		$this->db->from('tb_bodycontent');
		$this->db->where('bodycontent_order',$order);
		$this->db->where('bodycontent_location_sl',$location);
		$this->db->where('bodycontent_sl<>',$id);
		$this->db->where('bodycontent_identifier_sl',7);
		$this->db->where('bodycontent_status_sl',1);
		$this->db->where('bodycontent_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_footer_item($data,$id){
	
		$where 		= 	"bodycontent_sl  = '$id'"; 
		$updquery 	= 	$this->db->update_string('tb_bodycontent', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	/*function get_ports_list()     
    { 
    	$this->db->select('portoffice_sl');
		$this->db->select('portoffice_engtitle');
		$this->db->select('portoffice_maltitle');
		$this->db->select('portoffice_engaddress');
		$this->db->select('portoffice_maladdress');
		$this->db->select('portoffice_phone');
		$this->db->select('portoffice_email');
		$this->db->select('portoffice_map');
		$this->db->select('portoffice_status_sl');
		$this->db->from('tb_portoffices');
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}
*/
	function get_ports_list()     
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
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	/*function check_duplication_ports_insert($ports_eng,$ports_mal,$address_eng,$address_mal,$ports_phone,$ports_mail)     
    { 
    	$this->db->select('portoffice_sl');
		$this->db->select('portoffice_engtitle');
		$this->db->select('portoffice_maltitle');
		$this->db->select('portoffice_engaddress');
		$this->db->select('portoffice_maladdress');
		$this->db->select('portoffice_phone');
		$this->db->select('portoffice_email');
		$this->db->select('portoffice_map');
		$this->db->select('portoffice_status_sl');
		$this->db->from('tb_portoffices');
		$this->db->where('portoffice_engtitle',$ports_eng);
		$this->db->where('portoffice_maltitle',$ports_mal);
		$this->db->where('portoffice_engaddress',$address_eng);
		$this->db->where('portoffice_maladdress',$address_mal);
		$this->db->where('portoffice_phone',$ports_phone);
		$this->db->where('portoffice_email',$ports_mail);
		$this->db->where('portoffice_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}*/

	function check_duplication_ports_insert($ports_eng,$ports_mal,$address_eng,$address_mal,$ports_phone,$ports_mail)     
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
		$this->db->where('vchr_portoffice_name',$ports_eng);
		$this->db->where('portofregistry_mal_name',$ports_mal);
		$this->db->where('vchr_portoffice_address',$address_eng);
		$this->db->where('vchr_portoffice_maladdress',$address_mal);
		$this->db->where('vchr_portoffice_phone',$ports_phone);
		$this->db->where('vchr_portoffice_email',$ports_mail);
		$this->db->where('int_status',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	/*function update_port_status($data,$portoffice_sl){
	
		$where 		= 	"portoffice_sl  = '$portoffice_sl' "; 
		$updquery 	= 	$this->db->update_string('tb_portoffices', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}*/

	function update_port_status($data,$int_portoffice_id){
	
		$where 		= 	"int_portoffice_id  = '$int_portoffice_id' "; 
		$updquery 	= 	$this->db->update_string('tbl_portoffice_master', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	/*function get_port_det($id)     
    { 
    	$this->db->select('*');
		$this->db->from('tb_portoffices');
		$this->db->where('portoffice_sl',$id);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}*/

	function get_port_det($id)     
    { 
    	$this->db->select('*');
		$this->db->from('tbl_portoffice_master');
		$this->db->where('int_portoffice_id',$id);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	/*function check_duplication_ports_edit($ports_eng,$ports_mal,$address_eng,$address_mal,$ports_phone,$ports_mail,$id)     
    { 
    	$this->db->select('portoffice_sl');
		$this->db->select('portoffice_engtitle');
		$this->db->select('portoffice_maltitle');
		$this->db->select('portoffice_engaddress');
		$this->db->select('portoffice_maladdress');
		$this->db->select('portoffice_phone');
		$this->db->select('portoffice_email');
		$this->db->select('portoffice_map');
		$this->db->select('portoffice_status_sl');
		$this->db->from('tb_portoffices');
		$this->db->where('portoffice_sl<>',$id);
		$this->db->where('portoffice_engtitle',$ports_eng);
		$this->db->where('portoffice_maltitle',$ports_mal);
		$this->db->where('portoffice_engaddress',$address_eng);
		$this->db->where('portoffice_maladdress',$address_mal);
		$this->db->where('portoffice_phone',$ports_phone);
		$this->db->where('portoffice_email',$ports_mail);
		$this->db->where('portoffice_status_sl',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}*/

	function check_duplication_ports_edit($ports_eng,$ports_mal,$address_eng,$address_mal,$ports_phone,$ports_mail,$id)     
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
		$this->db->where('int_portoffice_id<>',$id);
		$this->db->where('vchr_portoffice_name',$ports_eng);
		$this->db->where('portofregistry_mal_name',$ports_mal);
		$this->db->where('vchr_portoffice_address',$address_eng);
		$this->db->where('vchr_portoffice_maladdress',$address_mal);
		$this->db->where('vchr_portoffice_phone',$ports_phone);
		$this->db->where('vchr_portoffice_email',$ports_mail);
		$this->db->where('int_status',1);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	/*function update_port($data,$id){
	
		$where 		= 	"portoffice_sl  = '$id'"; 
		$updquery 	= 	$this->db->update_string('tb_portoffices', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}*/

	function update_port($data,$id){
	
		$where 		= 	"int_portoffice_id  = '$id'"; 
		$updquery 	= 	$this->db->update_string('tbl_portoffice_master', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function get_services_list()     
    { 
    	$this->db->select('services_sl');
		$this->db->select('services_engtitle');
		$this->db->select('services_maltitle');
		$this->db->select('services_ctype');
		$this->db->select('services_status');
		$this->db->from('tb_services');
		$this->db->where('services_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_services_insert($services_eng,$services_mal)     
    { 
    	$this->db->select('services_sl');
		$this->db->select('services_engtitle');
		$this->db->select('services_maltitle');
		$this->db->select('services_status');
		$this->db->from('tb_services');
		$this->db->where('services_engtitle',$services_eng);
		$this->db->where('services_maltitle',$services_mal);
		$this->db->where('services_status',1);
		$this->db->where('services_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_service_status($data,$services_sl){
	
		$where 		= 	"services_sl  = '$services_sl' "; 
		$updquery 	= 	$this->db->update_string('tb_services', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function edit_services($id,$data){
		$where 		= " services_sl  = '$id'"; 
        $result 	= $this->db->update('tb_services', $data, $where);
      	return $result;

	}

	function check_duplication_services_edit($services_eng,$services_mal,$id)     
    { 
    	$this->db->select('services_sl');
		$this->db->select('services_engtitle');
		$this->db->select('services_maltitle');
		$this->db->select('services_status');
		$this->db->from('tb_services');
		$this->db->where('services_sl<>',$id);
		$this->db->where('services_engtitle',$services_eng);
		$this->db->where('services_maltitle',$services_mal);
		$this->db->where('services_status',1);
		$this->db->where('services_ctype<>',2);
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

	function get_services_port_list()     
    { 
    	$this->db->select('portservices_sl');
		$this->db->select('portservices_port_sl');
		$this->db->select('portservices_services_sl');
		$this->db->select('portservices_ctype');
		$this->db->select('portservices_status');
		$this->db->from('tb_portservices');
		$this->db->where('portservices_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_portservices_insert($port)     
    { 
    	$this->db->select('portservices_sl');
		$this->db->select('portservices_port_sl');
		$this->db->select('portservices_services_sl');
		$this->db->select('portservices_ctype');
		$this->db->select('portservices_status');
		$this->db->from('tb_portservices');
		$this->db->where('portservices_port_sl',$port);
		$this->db->where('portservices_status',1);
		$this->db->where('portservices_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_portservices_status($data,$portservices_sl){
	
		$where 		= 	"portservices_sl  = '$portservices_sl' "; 
		$updquery 	= 	$this->db->update_string('tb_portservices', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function edit_portservices($id,$data){
		$where 		= " portservices_sl  = '$id'"; 
        $result 	= $this->db->update('tb_portservices', $data, $where);
      	return $result;

	}

	function get_services_port_det($id)     
    { 
    	$this->db->select('*');
		$this->db->from('tb_portservices');
		$this->db->where('portservices_sl',$id);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function check_duplication_portservices_edit($port,$id)     
    { 
    	$this->db->select('portservices_sl');
		$this->db->select('portservices_port_sl');
		$this->db->select('portservices_services_sl');
		$this->db->select('portservices_ctype');
		$this->db->select('portservices_status');
		$this->db->from('tb_portservices');
		$this->db->where('portservices_sl <>',$id);
		$this->db->where('portservices_port_sl',$port);
		$this->db->where('portservices_status',1);
		$this->db->where('portservices_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_portservice($data,$id){
	
		$where 		= 	"portservices_sl  = '$id' "; 
		$updquery 	= 	$this->db->update_string('tb_portservices', $data, $where);
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
		$this->db->select('mailbox_received');
		$this->db->select('mailbox_forwarded');
		$this->db->select('mailbox_status');
		$this->db->from('tb_mailbox');
		$this->db->where('mailbox_ctype<>',2);
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
		
	}

	function update_inbox_status($data,$mailbox_sl){
	
		$where 		= 	"mailbox_sl  = '$mailbox_sl' "; 
		$updquery 	= 	$this->db->update_string('tb_mailbox', $data, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;	
	}

	function get_user_details($id,$val){

		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('tbl_kiv_user','user_master.customer_id=tbl_kiv_user.user_sl','left');
		if($id==1){
			$this->db->where('user_master.user_master_ph',$val);
		} elseif($id==2){
			$this->db->where('user_master.user_master_email',$val);
		} 
		
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
	}

	function get_user_details_kiv($val){

		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('tbl_kiv_user','user_master.customer_id=tbl_kiv_user.user_sl','left');
		$this->db->join('tb_vessel_main','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
		$this->db->where('tb_vessel_main.vesselmain_reg_number',$val);
		
		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result; 
	}

	function check_dup_user_det($edit_ph,$edit_email,$id){

		$this->db->select('*');
		$this->db->from('user_master');
		
		$where = "user_master_ph='$edit_ph' AND user_master_email='$edit_email' AND user_master_id!='$id'";
		$this->db->where($where);

		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result;

	}

	function check_dup_useraddress_det($edit_address,$id){

		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('tbl_kiv_user','user_master.customer_id=tbl_kiv_user.user_sl','left');
		$this->db->join('tb_vessel_main','user_master.user_master_id=tb_vessel_main.vesselmain_owner_id');
		$this->db->where('tbl_kiv_user.user_address',$edit_address);
		$this->db->where('user_master.user_master_id<>',$id);

		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result;

	}

	function update_user_ph_mail($data_upd,$id){

		$where 		= 	"user_master_id  = '$id' "; 
		$updquery 	= 	$this->db->update_string('user_master', $data_upd, $where);
		$rs			=	$this->db->query($updquery);
		return $rs;

	}

	function update_user_address($address,$edit_ph,$edit_email,$id){
		
		$sql = "UPDATE tbl_kiv_user  JOIN user_master ON tbl_kiv_user.user_sl = user_master.customer_id SET user_address = '$address', user_mobile_number='$edit_ph', user_email='$edit_email' WHERE user_master.user_master_id = $id";
		$rs			=$this->db->query($sql);
		return $rs;

	}

	function get_prev_user_details($id){

		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('tbl_kiv_user','user_master.customer_id=tbl_kiv_user.user_sl','left');
		$this->db->where('user_master.user_master_id',$id);

		$query 		= 	$this->db->get();
		$result 	= 	$query->result_array();
		return $result;

	}

	/*-----------------Curl to send SMS starts-----------*/
	public function sendSms($message,$number){

	    $link = curl_init();

	    curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=portsms2&password=portsms1234&message=".$message."&numbers=".$number."&senderid=PORTDR");

	    curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);

	    curl_setopt($link , CURLOPT_HEADER, 0);

	    return $output = curl_exec($link);

	    curl_close($link );

	} 
/*-------------------------------------------------------------------------------------------------------------------------------------*/
}
