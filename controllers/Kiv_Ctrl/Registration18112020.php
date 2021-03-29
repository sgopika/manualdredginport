<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Registration extends CI_Controller {
public function __construct()
{
	parent::__construct();
	$this->load->library('session');
	$this->load->helper('form');
	$this->load->helper('url');
	$this->load->library('Phpass',array(8, FALSE));
	$this->load->database();
	$this->load->library('form_validation');
	$this->load->helper('date');
	$this->load->library('encrypt');
	$this->load->library('upload');
	$this->data 		= 	array(
	'controller' 			=> 	$this->router->fetch_class(),
	'method' 				=> 	$this->router->fetch_method(),
	'session_userdata' 		=> 	isset($this->session->userdata) ? $this->session->userdata : '',
	'base_url' 				=> 	base_url(),
	'site_url'  			=> 	site_url(),
	/*'user_sl' 				=> 	isset($this->session->userdata['user_sl']) ? $this->session->userdata['user_sl'] : 0,
	'user_type_id' 			=> 	isset($this->session->userdata['user_type_id']) ? $this->session->userdata['user_type_id'] : 0,
	'customer_id' 			=> 	isset($this->session->userdata['customer_id']) ? $this->session->userdata['customer_id'] : 0,
	'survey_user_id' 	=> 	isset($this->session->userdata['survey_user_id']) ? $this->session->userdata['survey_user_id'] : 0,*/
	);
	$this->load->model('Kiv_models/Registration_model');
}
	
public function NewUser_Registration()
{ 
	$data 			=	array('title' => 'NewUser_Registration', 'page' => 'NewUser_Registration', 'errorCls' => NULL, 'post' => $this->input->post());
	$data 			=	$data + $this->data;
	$this->load->model('Kiv_models/Registration_model');
	$this->load->view('Kiv_views/Registration/header_reg.php');

	$state				= 	$this->Registration_model->get_state();
	$data['state']		=	$state;	

	$occupation			= 	$this->Registration_model->get_occupation();
	$data['occupation']	=	$occupation;

	$idcard				= 	$this->Registration_model->get_idcard();
	$data['idcard']		=	$idcard;

	$choice				= 	$this->Registration_model->get_choice();
	$data['choice']		=	$choice;

	$ownership_type			= 	$this->Registration_model->get_ownership_type();
	$data['ownership_type']	=	$ownership_type;
	$data 					= 	$data + $this->data;

	$this->load->view('Kiv_views/Registration/NewUser_Registration',$data);
	$this->load->view('Kiv_views/Registration/footer_reg.php');   
	 

	if($this->input->post())
	{
		
		//print_r($this->input->post); exit();
		$this->form_validation->set_rules('user_name', 'Name ', 'required');
	$this->form_validation->set_rules('user_address', 'Address ', 'required');
	$this->form_validation->set_rules('user_mobile_number', 'Mobile Number ', 'required');
	$this->form_validation->set_rules('user_email', 'Email Required', 'required');
	$this->form_validation->set_rules('user_district_id', 'District ', 'required');       
	
	//$this->form_validation->set_rules('user_photo', 'Document ', 'required');
	//$this->form_validation->set_rules('aadhar_document', 'Document ', 'required');
	//$this->form_validation->set_rules('pancard_document', 'Document ', 'required');
	//$this->form_validation->set_rules('signature', 'Document ', 'required');
	//--------------------------------------------------//21/08/2020
	if($this->form_validation->run() == FALSE)

	{
					//echo "dfdfdf";
					echo validation_errors();
					exit();

	}

	else

	{  //-------------------------------------------------21/08/2020

		$hiddencaptcha=base64_decode($data['post']["pass2"]);


		if($data['post']['captcha']!= $hiddencaptcha)
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Captcha entered is not correct........</div>');
			redirect("Kiv_Ctrl/Registration/NewUser_Registration");
		}

		$user_name				=	$data['post']['user_name'];
		$user_address			=	$data['post']['user_address'];
		$user_mobile_number		=	$data['post']['user_mobile_number'];
		$user_email				=	$data['post']['user_email'];
		$user_state_id			=	$data['post']['user_state_id'];
		$user_district_id		=	$data['post']['user_district_id'];
		$user_occupation_id		=	$data['post']['user_occupation_id'];
		$user_occupation_address=	$data['post']['user_occupation_address'];
		//$user_aadhar_id			=	$data['post']['user_aadhar_id'];
		$user_idcard_id			=	$data['post']['user_idcard_id'];
		$user_idcard_number		=	$data['post']['user_idcard_number'];
		$user_dob				=	$data['post']['user_dob'];

		$pan_card_number		=	$data['post']['pan_card_number'];

		$minor_status    =	$data['post']['hdnminor'];
		$agent_status    =	$data['post']['hdnagent'];
		$co_owner_status =	$data['post']['hdn_co_owner'];
		$co_owner_count  =	$data['post']['co_owner_count'];


		$ip				=	$_SERVER['REMOTE_ADDR'];
		date_default_timezone_set("Asia/Kolkata");
		$date 			= 	date('Y-m-d h:i:s', time());
		$user_data 			= 	array(
		'user_name' 			=>	$user_name,  
		'user_address' 			=> 	$user_address,
		'user_mobile_number' 	=> 	$user_mobile_number,
		'user_email'			=>	$user_email,
		'user_state_id'			=>	$user_state_id,
		'user_district_id'		=>	$user_district_id,
		'user_occupation_id'	=>	$user_occupation_id,
		'user_occupation_address'=>	$user_occupation_address,
		'pan_card_number'		=>	$pan_card_number,
		'user_idcard_id'		=>	$user_idcard_id,
		'user_idcard_number'	=>	$user_idcard_number,
		'user_dob'				=>	$user_dob,
		'minor_status'			=>	$minor_status,
		'user_ownership_id'		=>	1,
		'coowner_count'			=>	$co_owner_count,
		'user_created_timestamp'=>	$date,
		'user_created_ipaddress'=>	$ip);

		$data 				= 	$this->security->xss_clean($data);
		$user_res 			=	$this->Registration_model->insert_data('tbl_kiv_user', $user_data);
		$id 				= 	$this->db->insert_id();
		

		/*$f_user_photo                 = pathinfo($_FILES["user_photo"]["name"]);
		 $ext1                  = $f_user_photo['extension'];
*/

		 $f_user_photo                 = pathinfo($_FILES["user_photo"]["name"]);
		 $ext1                  = $f_user_photo['extension'];

		 $f_aadhar_document                 = pathinfo($_FILES["aadhar_document"]["name"]);
		 $ext2                  = $f_aadhar_document['extension'];

		 $f_pancard_document                 = pathinfo($_FILES["pancard_document"]["name"]);
		 $ext3                  = $f_pancard_document['extension'];

		$f_signature                 = pathinfo($_FILES["signature"]["name"]);
		$ext4                 = $f_signature['extension'];

		$f_aadhar_document1=$_FILES["aadhar_document"]["name"];
		$f_signature1=$_FILES["signature"]["name"];

		if(!empty($f_pancard_document1))
		{
			$pancard='pancard_'.$id.$ext3;
		}
		else
		{
			$pancard="";
		}
		if(!empty($f_signature1))
		{
			$signature='signature_'.$id.$ext4;
		}
		else
		{
			$signature="";
		}

		 $user_photo='owner_photo_'.$id.$ext1;
		$aadhar_document='aadhar_'.$id.$ext2;
		
		

		//----------------------------------

		$change_relation 	= 	array('relation_sl' => $id,
		'user_photo'=>	$user_photo,	
		'aadhar_document'=>	$aadhar_document,
		'pancard_document'=>	$pancard,
		'signature'=>	$signature);
		$this->db->where('user_sl',$id);
		$cp_result 	=$this->db->update('tbl_kiv_user', $change_relation);

		

		$this->session->set_userdata(array(
		'id'  => $id,
		'minor_status'=>$minor_status,
		'agent_status' => $agent_status,
		'co_owner_status' => $co_owner_status,
		'co_owner_count' => $co_owner_count));        

		$minor_data=array(
		'user_id'  => $id,
		'minor_status'=>$minor_status,
		'agent_status' => $agent_status,
		'co_owner_status' => $co_owner_status,
		'co_owner_count' => $co_owner_count);

		$minor_res=	$this->Registration_model->insert_data('tbl_kiv_minor_status', $minor_data);
		$newp= $this->phpass->hash($user_email);

		$username		=	$user_email;
		$user_password 	=	$newp;  
		$user_type_id 	=	'11';
		$customer_id 	=	$id;
		$survey_user_id =	'1';

		$data2 			= 	array(
		'user_master_name' 		=>	$username,  
		'user_master_password' 	=> 	$user_password,
		'user_master_fullname' 	=> 	$user_name,
		'user_master_id_user_type'=>$user_type_id,
		'customer_id'=>	$customer_id,
		'survey_user_id'=>	$survey_user_id,
		'user_master_timestamp'=>$date,
		'user_master_status'=>'1',
		'user_master_user_id'=>'0',
		'user_master_ph'=>$user_mobile_number,
		'user_master_email'=>$user_email,
		'user_decrypt_pwd'=>$user_email);

		$data 			= 	$this->security->xss_clean($data);
		$usr_res=	$this->Registration_model->insert_data('user_master', $data2);


		//------------------------------------

		//-----------------user photo----------------------------------------
		
		$config1['upload_path']   = './uploads/user_photo/'; 
      	$config1['allowed_types'] = 'jpeg|jpg|png|PNG|JPG|JPEG'; 
      	$config1['max_size']      = 1024000;
        $config1['file_name']	  = $user_photo;
      	
      	$this->load->library('upload', $config1);
        $this->upload->initialize($config1);
      	
     

      		if(!$this->upload->do_upload('user_photo'))
      		{
      			$data['error'] = $this->upload->display_errors();
				//print_r($data); exit();
      			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Maximum allowed  file size of user photo is 500Kb</div>'); 
         		redirect("Kiv_Ctrl/Registration/NewUser_Registration");
      		}
      		else
      		{
      		 $data = $this->upload->data();
         		//echo "Upload Successful-------uph";
         		//exit;
      		} 
      	//------------------------------------------------------------------	
      		//-----------------Aadhar doc----------------------------------------
		$config2['upload_path']   = './uploads/aadhar_document/'; 
      	$config2['allowed_types'] = 'pdf'; 
      	$config2['max_size']      = 1024000;
      	$config2['file_name']	 = $aadhar_document;
      	$this->load->library('upload', $config2);
      	$this->upload->initialize($config2);
      
      		if (!$this->upload->do_upload('aadhar_document'))
      		{
         			$dataa['error'] = $this->upload->display_errors(); //echo "111111--";
         			//print_r($dataa); exit();
         			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Maximum allowed  file size of aadhar_document is 500Kb</div>'); 
         			redirect("Kiv_Ctrl/Registration/NewUser_Registration");
      		}
      		else
      		{ 
      			 $data = $this->upload->data();
         		//echo "Upload Successful-aadahr";
         		//exit;
      		} 
      
      	//------------------------------------------------------------------
      	//-----------------PAn card----------------------------------------
		$config3['upload_path']   = './uploads/pancard/'; 
      	$config3['allowed_types'] = 'pdf'; 
      	$config3['max_size']      = 1024000;
      	$config3['file_name']	 = $pancard;
      	$this->load->library('upload', $config3);
      	$this->upload->initialize($config3);

      		if ( ! $this->upload->do_upload('pancard_document'))
      		{
         			$data3['error'] = $this->upload->display_errors();//echo "22222--";
         			//print_r($data3); exit();
         			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Maximum allowed  file size of pancard_document is 500Kb</div>');
         			redirect("Kiv_Ctrl/Registration/NewUser_Registration");
      		}
      		else
      		{ 
      			 $data = $this->upload->data();
         		//echo "Upload Successful-pan";
         		//exit;
      		} 
      	//------------------------------------------------------------------
      	//-----------------Signature----------------------------------------
		$config4['upload_path']   = './uploads/signature/'; 
      	$config4['allowed_types'] = 'pdf'; 
      	$config4['max_size']      = 1024000;
      	$config4['file_name']	 = $signature;
      	$this->load->library('upload', $config4);
      	$this->upload->initialize($config4);

      		if ( ! $this->upload->do_upload('signature'))
      		{
         			$data4['error'] = $this->upload->display_errors();//echo "33333--";
         			//print_r($data4); exit();
         			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Maximum allowed  file size of signature is 500Kb</div>');
         			redirect("Kiv_Ctrl/Registration/NewUser_Registration");
      		}
      		else
      		{ 
      			 $data = $this->upload->data();
         		//echo "Upload Successful-sign";
         		//exit;
      		} 
      	//------------------------------------------------------------------

		/* $f_user_photo                 = pathinfo($_FILES["user_photo"]["name"]);
		 $ext1                  = $f_user_photo['extension'];

		 $f_aadhar_document                 = pathinfo($_FILES["aadhar_document"]["name"]);
		 $ext2                  = $f_aadhar_document['extension'];

		 $f_pancard_document                 = pathinfo($_FILES["pancard_document"]["name"]);
		 $ext3                  = $f_pancard_document['extension'];

		$f_signature                 = pathinfo($_FILES["signature"]["name"]);
		$ext4                 = $f_signature['extension'];
	

		if($ext1=="jpg" || $ext1=="jpeg"||$ext1=="png")
		{
			if($_FILES["user_photo"]["tmp_name"]<771568)
			{
				
				copy($_FILES["user_photo"]["tmp_name"], "./uploads/user_photo/".$user_photo);
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Maximum allowed  file size of user photo is 500Kb</div>');
				redirect("Kiv_Ctrl/Registration/NewUser_Registration");
			}
		}
		

		if($ext2=="pdf")
        {
			if($_FILES["aadhar_document"]["tmp_name"]<771568)
			{
				copy($_FILES["aadhar_document"]["tmp_name"], "./uploads/aadhar_document/".$aadhar_document);
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Maximum allowed file size of Aadhaar document is 500Kb</div>');
				redirect("Kiv_Ctrl/Registration/NewUser_Registration");
			}
		}

		if(($_FILES['pancard_document']['name'])!="")
		{
			if($ext3=="pdf")
			{
				if($_FILES["pancard_document"]["tmp_name"]<771568)
				{
					copy($_FILES["pancard_document"]["tmp_name"], "./uploads/pancard/".$pancard);
				}
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Maximum allowed file size  of Pancard is 500Kb</div>');
				redirect("Kiv_Ctrl/Registration/NewUser_Registration");
			}
		}   

		if(($_FILES['signature']['name'])!="")
		{
			if($ext4=="pdf")
			{
				if($_FILES["signature"]["tmp_name"]<771568)
				{
					copy($_FILES["signature"]["tmp_name"], "./uploads/signature/".$signature);
				}
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Maximum allowed file size of signature is 500Kb</div>');
				redirect("Kiv_Ctrl/Registration/NewUser_Registration");
			}
		}*/



		/*$change_relation 	= 	array('relation_sl' => $id,
		'user_photo'=>	$user_photo,	
		'aadhar_document'=>	$aadhar_document,
		'pancard_document'=>	$pancard,
		'signature'=>	$signature);
		$this->db->where('user_sl',$id);
		$cp_result 	=$this->db->update('tbl_kiv_user', $change_relation);

		

		$this->session->set_userdata(array(
		'id'  => $id,
		'minor_status'=>$minor_status,
		'agent_status' => $agent_status,
		'co_owner_status' => $co_owner_status,
		'co_owner_count' => $co_owner_count));        

		$minor_data=array(
		'user_id'  => $id,
		'minor_status'=>$minor_status,
		'agent_status' => $agent_status,
		'co_owner_status' => $co_owner_status,
		'co_owner_count' => $co_owner_count);

		$minor_res=	$this->Registration_model->insert_data('tbl_kiv_minor_status', $minor_data);
		$newp= $this->phpass->hash($user_email);

		$username		=	$user_email;
		$user_password 	=	$newp;  
		$user_type_id 	=	'11';
		$customer_id 	=	$id;
		$survey_user_id =	'1';

		$data2 			= 	array(
		'user_master_name' 		=>	$username,  
		'user_master_password' 	=> 	$user_password,
		'user_master_fullname' 	=> 	$user_name,
		'user_master_id_user_type'=>$user_type_id,
		'customer_id'=>	$customer_id,
		'survey_user_id'=>	$survey_user_id,
		'user_master_timestamp'=>$date,
		'user_master_status'=>'1',
		'user_master_user_id'=>'0',
		'user_master_ph'=>$user_mobile_number,
		'user_master_email'=>$user_email,
		'user_decrypt_pwd'=>$user_email);

		$data 			= 	$this->security->xss_clean($data);
		$usr_res=	$this->Registration_model->insert_data('user_master', $data2);
*/
		/*______________code for send email starts_________________*/
	/*	$config = Array(
		'protocol'        => 'smtp',
		'smtp_host'       => 'ssl://smtp.googlemail.com',
		'smtp_port'       => 465,
		'smtp_user'       => 'kivportinfo@gmail.com', 
		'smtp_pass'       => 'KivPortinfokerala123', 
		'mailtype'        => 'html',
		'charset'         => 'iso-8859-1');

		$message = '<div>
		<h4>Registration Successful!</h4>
		<p>Your application for registering as a vessel owner at Department of Ports, Governmet of Kerala has been completed. Your login credential has been sent to your mobile number and email provided in the first form. <br> Username :'.$username.'  <br> Password : '.$username.'</p>
		<hr>
		</div>';

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('kivportinfo@gmail.com'); 
		//$this->email->to($user_mail);// change it to yours
		$this->email->to('kivportinfo@gmail.com');
		$this->email->subject('Registration of Vessel Owner');
		$this->email->message($message);
		if($this->email->send())
		{ 
			/*_____________code for send SMS starts_________________*/
			/*$this->load->model('Kiv_models/Registration_model');
			$mobil="9847903241";
			$stat = $this->Registration_model->sendSms($message,$mobil);*/

			/*_____________code for send SMS ends__________________*/
		/*}
		else
		{
			show_error($this->email->print_debugger());
		} */

	 //_____________________________Email sending start_____________________________//
	          $email_subject="Registration of Vessel Owner";
	          $email_message="<div><h4>Registration Successful!</h4><p>Your application for registering as a vessel owner at Department of Ports, Governmet of Kerala has been completed. Your login credential has been sent to your mobile number and email provided in the first form. <br> Username :'.$username.'  <br> Password : '.$username.'</p><hr></div>";
	          $saji_email="kivportinfo@gmail.com";
	          $this->emailSendFunction($saji_email,$email_subject,$email_message);
	          //$this->emailSendFunction($user_mail,$email_subject,$email_message);
	          //___________________Email sending start___________________________________________//
	          //____________________SMS sending start____________________________________________//
	          $sms_message="Registration of Vessel Owner";
	          $this->load->model('Kiv_models/Registration_model');
	          $saji_mob="9847903241";
	              //$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
	          //$stat = $this->Survey_model->sendSms($sms_message,$custphoneno);
	          //____________________SMS sending end________________________________________________//

		$from=1;
		if($minor_status==1)
		{
			$to=2;
			$page='ag';
		}
		else
		{
			if($agent_status==1)
			{
				$to=3;
				$page='co';
			}
			else 
			{
				if($co_owner_status==1)
				{
					$to=4;
					//$page='in';
				}
				else
				{
					$to=0;
				}
			}
		}
		if($user_res && $cp_result && $minor_res && $usr_res)
		{
			redirect("Kiv_Ctrl/Registration/confirm/".$id."/".$from."/".$to."/".$page);
		}
	

	}//validation else

	} 
}
	
public function NewUser_Registration_guardian()
{
	$id 				= $this->session->userdata('id');
	$minor_status 		= $this->session->userdata('minor_status');
	$agent_status 		= $this->session->userdata('agent_status');
	$co_owner_status 	= $this->session->userdata('co_owner_status');
	$count 				= $this->session->userdata('co_owner_count');

	$data 			=	array('title' => 'NewUser_Registration_guardian', 'page' => 'NewUser_Registration_guardian', 'errorCls' => NULL, 'post' => $this->input->post());
	$data 			=	$data + $this->data;
	$this->load->model('Kiv_models/Registration_model');
	$state			= 	$this->Registration_model->get_state();
	$data['state']	=	$state;

	$occupation			= 	$this->Registration_model->get_occupation();
	$data['occupation']	=	$occupation;

	$idcard				= 	$this->Registration_model->get_idcard();
	$data['idcard']		=	$idcard;

	$get_user_details			= 	$this->Registration_model->get_user_details($id);
	$data['get_user_details']	=	$get_user_details;

	$this->load->view('Kiv_views/Registration/header_reg.php');
	$this->load->view('Kiv_views/Registration/NewUser_Registration_guardian',$data);     
	$this->load->view('Kiv_views/Registration/footer_reg.php');

	if(isset($data['post']['btnsubmit']))
	{
		$user_name					=	$data['post']['user_name'];
		$user_address				=	$data['post']['user_address'];
		$user_mobile_number			=	$data['post']['user_mobile_number'];
		$user_email					=	$data['post']['user_email'];
		$user_state_id				=	$data['post']['user_state_id'];
		$user_district_id			=	$data['post']['user_district_id'];
		$user_occupation_id			=	$data['post']['user_occupation_id'];
		$user_occupation_address	=	$data['post']['user_occupation_address'];
		//$user_aadhar_id				=	$data['post']['user_aadhar_id'];
		$user_idcard_id				=	$data['post']['user_idcard_id'];
		$user_idcard_number			=	$data['post']['user_idcard_number'];
		$user_dob					=	$data['post']['user_dob'];
		$minor_status				=	$data['post']['minor_status'];
		$relation_sl 				=	$data['post']['user_sl'];

		date_default_timezone_set("Asia/Kolkata");
		$ip				=	$_SERVER['REMOTE_ADDR'];
		$date 			= 	date('Y-m-d h:i:s', time());

		$data 			= 	array(
		'user_name' 			=>	$user_name,  
		'user_address' 			=> 	$user_address,
		'user_mobile_number' 	=> 	$user_mobile_number,
		'user_email'			=>	$user_email,
		'user_state_id'			=>	$user_state_id,
		'user_district_id'		=>	$user_district_id,
		'user_occupation_id'	=>	$user_occupation_id,
		'user_occupation_address'=>	$user_occupation_address,
		//'user_aadhar_id'		=>	$user_aadhar_id,
		'user_idcard_id'		=>	$user_idcard_id,
		'user_idcard_number'	=>	$user_idcard_number,
		'user_dob'				=>	$user_dob,
		'relation_sl'           =>  $id,
		'guardian_status'		=>	$guardian_status,
		'user_ownership_id'		=>	3,
		'user_created_timestamp'=>	$date,
		'user_created_ipaddress'=>	$ip);

		$data 			= 	$this->security->xss_clean($data);
		$usr_res		=	$this->db->insert('tbl_kiv_user', $data);
		$id1 			= 	$this->db->insert_id();

		$guardianship_document='guardianship_document_'.$id1.'.pdf';
		$aadhar_document='aadhar_'.$id1.'.pdf';

		copy($_FILES["aadhar_document"]["tmp_name"], "./uploads/aadhar_document/".$aadhar_document);
		copy($_FILES["guardianship_document"]["tmp_name"], "./uploads/guardianship_document/".$guardianship_document);

		$change_relation 	= 	array(
		'guardianship_document'=>	$guardianship_document,	
		'aadhar_document'=>	$aadhar_document);
		$this->db->where('user_sl',$id1);
		$cp_result 	=$this->db->update('tbl_kiv_user', $change_relation);
		$from=2;
		if($agent_status==1)
		{
			$to=3;
			$page='co';
		}
		elseif($co_owner_status==1)
		{
			$to=4;
		}
		else
		{
			$to=0;
		}
		redirect("Kiv_Ctrl/Registration/confirm/".$id."/".$from."/".$to."/".$page);        
	}
}

public function NewUser_Registration_agent()
{
	$id 				= $this->session->userdata('id');
	$minor_status 		= $this->session->userdata('minor_status');
	$agent_status 		= $this->session->userdata('agent_status');
	$co_owner_status 	= $this->session->userdata('co_owner_status');
	$count 				= $this->session->userdata('co_owner_count');

	$data 			=	array('title' => 'NewUser_Registration_agent', 'page' => 'NewUser_Registration_agent', 'errorCls' => NULL, 'post' => $this->input->post());
	$data 			=	$data + $this->data;
	$this->load->model('Kiv_models/Registration_model');

	$state				= 	$this->Registration_model->get_state();
	$data['state']		=	$state;

	$occupation			= 	$this->Registration_model->get_occupation();
	$data['occupation']	=	$occupation;

	$idcard				= 	$this->Registration_model->get_idcard();
	$data['idcard']		=	$idcard;

	$get_user_details			= 	$this->Registration_model->get_user_details($id);
	$data['get_user_details']	=	$get_user_details;

	$this->load->view('Kiv_views/Registration/header_reg.php');
	$this->load->view('Kiv_views/Registration/NewUser_Registration_agent',$data);     
	$this->load->view('Kiv_views/Registration/footer_reg.php');

	if(isset($data['post']['btnsubmit']))
	{
		$user_name			=	$data['post']['user_name'];
		$user_address		=	$data['post']['user_address'];
		$user_mobile_number	=	$data['post']['user_mobile_number'];
		$user_email			=	$data['post']['user_email'];
		$user_state_id		=	$data['post']['user_state_id'];
		$user_district_id	=	$data['post']['user_district_id'];
		$user_occupation_id	=	$data['post']['user_occupation_id'];
		$user_occupation_address	=	$data['post']['user_occupation_address'];
		$user_idcard_id		=	$data['post']['user_idcard_id'];
		$user_idcard_id		=	$data['post']['user_idcard_id'];
		$user_idcard_number	=	$data['post']['user_idcard_number'];
		$user_dob			=	$data['post']['user_dob'];
		$minor_status		=	$data['post']['minor_status'];
		$relation_sl 		=	$data['post']['user_sl'];

		$ip				=	$_SERVER['REMOTE_ADDR'];
		date_default_timezone_set("Asia/Kolkata");
		$date 			= 	date('Y-m-d h:i:s', time());

		$data 	= 	array(
		'user_name' 			=>	$user_name,  
		'user_address' 			=> 	$user_address,
		'user_mobile_number' 	=> 	$user_mobile_number,
		'user_email'			=>	$user_email,
		'user_state_id'			=>	$user_state_id,
		'user_district_id'		=>	$user_district_id,
		'user_occupation_id'	=>	$user_occupation_id,
		'user_occupation_address'=>	$user_occupation_address,
		'pan_card_number'		=>	$pan_card_number,
		'user_idcard_id'		=>	$user_idcard_id,
		'user_idcard_number'	=>	$user_idcard_number,
		'user_dob'				=>	$user_dob,
		'relation_sl'           =>  $id,
		//'guardian_status'		=>	$guardian_status,
		//'guardianship_document'	=>	$guardianship_document,
		'user_ownership_id'		=>	4,
		'user_created_timestamp'=>	$date,
		'user_created_ipaddress'=>	$ip);

		$data 			= $this->security->xss_clean($data);
		$usr_res		=	$this->db->insert('tbl_kiv_user', $data);
		$id1 			= 	$this->db->insert_id();
		$pancard_document='pancard_document'.$id1.'.pdf';

		copy($_FILES["pancard_document"]["tmp_name"], "./uploads/pancard/".$pancard_document);
		$change_relation 	= 	array('pancard_document'=>	$pancard_document);
		$this->db->where('user_sl',$id1);
		$cp_result 	=$this->db->update('tbl_kiv_user', $change_relation);

		$from=3;
		if($co_owner_status==1)
		{
			$to=4;
		}      
		else
		{
			$to=0;
		}
		redirect("Kiv_Ctrl/Registration/confirm/".$id."/".$from."/".$to);
	}
}
       
public function NewUser_Registration_co_owner()     
{
	$id 				= $this->session->userdata('id');
	$minor_status 		= $this->session->userdata('minor_status');
	$agent_status 		= $this->session->userdata('agent_status');
	$co_owner_status 	= $this->session->userdata('co_owner_status');
	$count 			= $this->session->userdata('co_owner_count');

	$data 				=	array('title' => 'NewUser_Registration_co_owner', 'page' => 'NewUser_Registration_co_owner', 'errorCls' => NULL, 'post' => $this->input->post());
	$data 				=	$data + $this->data;
	$this->load->model('Kiv_models/Registration_model');

	$state			= 	$this->Registration_model->get_state();
	$data['state']	=	$state;

	$occupation			= 	$this->Registration_model->get_occupation();
	$data['occupation']	=	$occupation;

	$idcard				= 	$this->Registration_model->get_idcard();
	$data['idcard']		=	$idcard;

	$count				= 	$count;
	$data['count']		=	$count;

	$get_user_details			= 	$this->Registration_model->get_user_details($id);
	$data['get_user_details']	=	$get_user_details;

	$this->load->view('Kiv_views/Registration/header_reg.php');
	$this->load->view('Kiv_views/Registration/NewUser_Registration_co_owner',$data);     
	$this->load->view('Kiv_views/Registration/footer_reg.php');
	if(isset($data['post']['btnsubmit']))
	{
		date_default_timezone_set("Asia/Kolkata");
		$ip					=	$_SERVER['REMOTE_ADDR'];
		$date 				= 	date('Y-m-d h:i:s', time());

		$co_owner_count 		= 	$this->input->post('co_owner_count');
		$user_name 				= 	$this->input->post('user_name');
		$user_address 			= 	$this->input->post('user_address');
		$user_mobile_number		=	$this->input->post('user_mobile_number');
		$user_email				=   $this->input->post('user_email');
		//$user_state_id			=	$this->input->post('user_state_id');
		//$user_district_id		=	$this->input->post('user_district_id');
		//$user_occupation_id		=	$this->input->post('user_occupation_id');
		//$user_occupation_address=   $this->input->post('user_occupation_address');
		//$user_aadhar_id			=	$this->input->post('user_aadhar_id');
		$user_idcard_id			=	$this->input->post('user_idcard_id');
		$user_idcard_number		=	$this->input->post('user_idcard_number');
		$user_dob				=   $this->input->post('user_dob');
		$minor_status			=	$this->input->post('hdnminor');
		$relation_sl            =   $this->input->post('user_sl');

		//for($i=0;$i<$co_owner_count;$i++)
		//{
		$data_co_owner 			= 	array(
		'user_name' 			=>	$user_name,  
		'user_address' 			=> 	$user_address,
		'user_mobile_number' 	=> 	$user_mobile_number,
		'user_email'			=>	$user_email,
		//'user_state_id'			=>	$user_state_id,
		//'user_district_id'		=>	$user_district_id,
		//'user_occupation_id'	=>	$user_occupation_id,
		//'user_occupation_address'=>	$user_occupation_address,
		//'user_aadhar_id'		=>	$user_aadhar_id,
		'user_idcard_id'		=>	$user_idcard_id,
		'user_idcard_number'	=>	$user_idcard_number,
		'user_dob'				=>	$user_dob,
		//	'minor_status'			=>	$minor_status,
		'relation_sl'               =>  $id,
		'user_ownership_id'		=>	2,
		'user_created_timestamp'=>	$date,
		'user_created_ipaddress'=>	$ip);
		
		$data 			= $this->security->xss_clean($data);
		$user_res=	$this->Registration_model->insert_data('tbl_kiv_user', $data_co_owner);

		if($user_res) 
		{
			$ownership_id=2;
			$co_owner_count_details	= 	$this->Registration_model->co_owner_count_details($id,$ownership_id);
			$data['co_owner_count_details']		=	$co_owner_count_details;
			@$table_count=$co_owner_count_details[0]['coowner_count'];
			if($table_count==$count)
			{
				$from=4;
				$to=6;
				redirect("Kiv_Ctrl/Registration/confirm/".$id."/".$from."/".$to);
			}
			else
			{
				$from=4;
				$to=5;
				redirect("Kiv_Ctrl/Registration/confirm/".$id."/".$from."/".$to);
			}
		}
	}
}

function district($user_state_id)
{
	$this->load->model('Kiv_models/Registration_model');
	$data['district']	 =	$user_state_id; 
	$district			     = 	$this->Registration_model->get_district($user_state_id);
	$data['district']	 =	$district;
	$data 						             = 	$data + $this->data;		
	$this->load->view('Kiv_views/Ajax_district.php', $data);
}

public function mobileverify()
{
	$mobile			=	$_REQUEST['mob'];
	$this->load->model('Kiv_models/Registration_model');
	$result_arr	=	$this->Registration_model->mobilenumber_exist($mobile);
	if(empty($result_arr))
	{  
		echo "0";     
	}
	else
	{    
		echo "1";
	}
}	

public function email_id_verify()
{
	$email_id			=	$_REQUEST['email_id'];
	$this->load->model('Kiv_models/Registration_model');
	$result_arr	=	$this->Registration_model->email_exist($email_id);
	if(empty($result_arr))
	{  
		echo "0";    
	}
	else
	{    
		echo "1";
	}
}
public function email_id_check()	
{
	$email_id			=	$_REQUEST['email_id'];
	$this->load->model('Kiv_models/Registration_model');
	$result_arr	=	$this->Registration_model->email_check($email_id);
	$data['result_arr'] =	$result_arr;
  	$data 					= 	$data + $this->data;		
  	$this->load->view('Kiv_views/Ajax_email.php', $data);
}

public function username_verify()
{
	$username			=	$_REQUEST['username'];
	$this->load->model('Kiv_models/Registration_model');
	$result_arr	=	$this->Registration_model->username_exist($username);
	if(empty($result_arr))
	{  
		echo "0";     
	}
	else
	{    
		echo "1";
	}
}	

public function idcard_verify()
{
	$user_idcard_number			=	$_REQUEST['user_idcard_number'];
	$this->load->model('Kiv_models/Registration_model');
	$result_arr	=	$this->Registration_model->idcard_exist($user_idcard_number);
	if(empty($result_arr))
	{  
		echo "0";     
	}
	else
	{    
		echo "1";
	}
}	
public function user_idcard_id_name()
{
	$user_idcard_id			=	$_REQUEST['user_idcard_id'];
	$this->load->model('Kiv_models/Registration_model');
	$result_arr	=	$this->Registration_model->user_idcard_id_name($user_idcard_id);
	if(!empty($result_arr))
	{  
		echo $result_arr['0']['idcard_name'];
	}
	else
	{    
		echo "";
	}
}	


public function confirm()
{
	$id=$this->uri->segment(4);
	$data 			=	array('title' => 'confirm', 'page' => 'confirm', 'errorCls' => NULL, 'post' => $this->input->post());
	$data 			=	$data + $this->data;
	$this->load->model('Kiv_models/Registration_model');

	$minor_details 			 =	$this->Registration_model->get_minor_details($id);
	$data['minor_details']	 =	$minor_details;

	$owner_details			 = 	$this->Registration_model->get_owner_details($id);
	$data['owner_details']	 =	$owner_details;

	$co_owner_count_details				= 	$this->Registration_model->count_details($id,2);
	$data['co_owner_count_details']		=	$co_owner_count_details;
	@$table_count_coowner 				=	$co_owner_count_details[0]['cnt'];

	$guardian_count_details				= 	$this->Registration_model->count_details($id,3);
	$data['guardian_count_details']		=	$guardian_count_details;
	@$table_count_guardian 				=	$guardian_count_details[0]['cnt'];

	$agent_count_details				= 	$this->Registration_model->count_details($id,4);
	$data['agent_count_details']		=	$agent_count_details;
	@$table_count_agent					=	$agent_count_details[0]['cnt'];

	$this->load->view('Kiv_views/Registration/header_reg.php');
	$this->load->view('Kiv_views/Registration/confirm',$data);
	$this->load->view('Kiv_views/Registration/footer_reg.php');   
}

public function emailSendFunction($to,$sub,$msg)
{
  $config = Array(
  'protocol'        => 'smtp',
  'smtp_host'       => 'ssl://smtp.googlemail.com',
  'smtp_port'       => 465,
  'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
  'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
  'mailtype'        => 'html',
  'charset'         => 'iso-8859-1');
  $this->load->library('email', $config);
  $this->email->set_newline("\r\n");
  $this->email->from('kivportinfo@gmail.com');// change it to yours
  //$this->email->to($to); 
  $this->email->to('kivportinfo@gmail.com');
  $this->email->subject($sub);
  $this->email->message($msg); 
  $result = $this->email->send();
  $res=$this->email->print_debugger();
  return $result;
}
//-----------End---------------//
}