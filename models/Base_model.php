<?php
/* 
 * File Name: Base_model.php
  
 * Created by:shibu

 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	/*---------------------------------------base model class start----------------------------*/
class Base_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	/*---------------------------------------Function used for checking the user details-----------*/
	
	function loginCheck($data)
	{
		/*-------------------------------To get the records from array-----------------------------*/
		$query = $this->db->get_where('tbl_user_master',$data);
		if($query->num_rows()===1)
		{
			$row 		= $query->row_array(); 
		$user_data  = array(
						'int_userid'  	  	=> $row['int_user_sl'],
						'vchr_name'  	  	=> $row['vch_user_fullname']
					
		   );	
  
			$this->session->set_userdata($user_data);
  		}
  			return $query->num_rows();
	}
	
	/*---------------------------------------Function for insert vaues to user log start---------------------------------*/

	

	/*---------------------------------------Common Login Functions Ends----------------------------*/
	
}
	/*---------------------------------------base model class ends----------------------------*/
	
	

?>