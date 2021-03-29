<?php

defined('BASEPATH') OR exit('No direct script access allowed');    

class Main_login extends CI_Controller {
public function __construct()
{
	parent::__construct();
	$this->load->library('session');
	$this->load->library('phpass',array(8, FALSE));
	$this->load->helper('form');
	$this->load->helper('url');
	$this->load->database();
	$this->load->library('form_validation');
	$this->load->helper('date');
	$this->load->library('encrypt');
	$this->load->helper('encdec');
	date_default_timezone_set("Asia/Kolkata");
	$this->data 		= 	array(
	'controller' 		=> 	$this->router->fetch_class(),
	'method' 			=> 	$this->router->fetch_method(),
	'session_userdata' 	=> 	isset($this->session->userdata) ? $this->session->userdata : '',
	'base_url' 			=> 	base_url(),
	'site_url'  		=> 	site_url(),
	'int_userid' 		=> 	isset($this->session->userdata['int_userid']) ? $this->session->userdata['int_userid'] : 0,
	'int_district_id' 	=> 	isset($this->session->userdata['int_district_id']) ? $this->session->userdata['int_district_id'] : 0);
	$this->load->model('Main_login_model');
	$this->load->model('Kiv_models/Survey_model');
}

public function index()
{
	$this->load->model('Main_login_model');
	$logo			=	$this->Main_login_model->get_active_logo();
	$data['logo'] 	=	$logo;
	$reg			=	$this->Main_login_model->get_active_registration();
	$data['reg'] 	=	$reg;
	$marquee		=	$this->Main_login_model->get_active_marquee_notfn();
	$data['marquee']=	$marquee;
	$reg_items		=	$this->Main_login_model->get_active_registration_items();
	$data['reg_items']=	$reg_items;
	$services		=	$this->Main_login_model->get_active_services();
	$data['services']=	$services;
	$footer			=	$this->Main_login_model->get_active_footer();
	$data['footer'] =	$footer;
	$vesselType		= 	$this->Main_login_model->get_vesseltype_dynamic();
	$data['vesselType']	=	$vesselType; 
	$surveyType			= 	$this->Main_login_model->get_survey_type();
	$data['surveyType']	=	$surveyType;
	$formName			= 	$this->Main_login_model->get_formname_dynamic();
	$data['formName']	=	$formName;
	$data 			= 	$data + $this->data;
	$ports			=	$this->Main_login_model->get_active_portoffices();
	$data['ports']  =	$ports;
	$cnt_port       = 	count($ports);
	$data['cnt_port']  =	$cnt_port;
	$data 			= 	$data + $this->data;
	//$this->load->view('Main_login/login');

	$this->load->view('Main_login/websitehead');
	$this->load->view('Main_login/websiteheader', $data);
	$this->load->view('Main_login/websitemarquee', $data);
	$this->load->view('Main_login/websitebody', $data);
	$this->load->view('Main_login/websitefooter', $data);
	$this->load->view('Main_login/websitefoot');


	if($this->input->post())
	{ 
	 	$hiddencaptcha=base64_decode($data['post']["pass2"]);


		if($data['post']['captcha']!= $hiddencaptcha)
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Captcha entered is not correct........</div>');
			redirect('Main_login/index'); 
		}

		$uname=html_escape($this->input->post('vch_un'));
		$paswd=html_escape($this->input->post('vch_pw'));//
		$res=$this->Main_login_model->login($uname); //print_r($res);exit;

		//--------------------------------------------------------------------------------------------
		if ($_SERVER["HTTP_X_FORWARDED_FOR"]) 
		{
			$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		else 
		{
			$ip_address = $_SERVER["REMOTE_ADDR"];
		}

		$time=time()-30;
		$resloginlog=$this->Main_login_model->loginlogcheck($ip_address,$time);
		$total_count=count($resloginlog); 
		
		if($total_count==5)
		{
			$msg="To many failed login attempts. Please login after 30 sec";
		}
		else
		{
				foreach($res as $re)
			{
				$hashed=$re['user_master_password'];
			    $mainmoduleid=$re['main_module_id']; //1-manual dredging
			

			}
			//echo $paswd.'/'.$hashed;
			//print_r($this->phpass->check($paswd,$hashed));exit;
			if($this->phpass->check($paswd,$hashed))
			{
				$userdet=$this->Main_login_model->getuserdetails($uname);//print_r($userdet);exit;
				$user_id=$userdet[0]['user_master_id'];
				$utyp_id=$userdet[0]['user_master_id_user_type'];///added additional 17.10.2019(deepthi)
				$mainmoduleid=$userdet[0]['main_module_id']; //1-manual dredging
				
				$reslog=$this->Main_login_model->getuserlog($user_id);//print_r($res);exit;
			
				//print_r($reslog);exit;
				if($reslog==0)
				{
				$this->session->set_userdata('u_id',$user_id);
				$this->session->set_userdata('utyp_id',$utyp_id);
				$this->session->set_userdata('int_userid_pw',$uname);
				$this->session->set_userdata('int_userid',$user_id);
				$this->session->set_userdata('int_usertype',$utyp_id);
				//echo "hhhhh".$mainmoduleid;exit;

					if($mainmoduleid==1)
					{
						redirect("Manual_dredging/Port/user_change_pw");
					}
					else
						{
							redirect("Main_login/ch_pw");
						}
				
				}
				else
				{
					foreach($userdet as $userde)
					{
						//date_default_timezone_set("Asia/Kolkata");
						$this->session->set_userdata('int_userid',$userde['user_master_id']);
						$this->session->set_userdata('int_usertype',$userde['user_master_id_user_type']);
						$this->session->set_userdata('customer_id',$userde['customer_id']);
						$this->session->set_userdata('survey_user_id',$userde['survey_user_id']);
						//$u_ip=$_SERVER['REMOTE_ADDR'];
						if ($_SERVER["HTTP_X_FORWARDED_FOR"]) 
						{
							$u_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
						}
						else 
						{
							$u_ip = $_SERVER["REMOTE_ADDR"];
						}

						$timestamp = time();
						$date_time = date("Y-m-d  H:i:s", $timestamp);
						$login_time = $date_time;
						$maxlifetime=ini_get("session.gc_maxlifetime");
						$add_time=$timestamp+$maxlifetime;
						$logout_time= date("Y-m-d H:i:s",$add_time);
						$this->session->set_userdata('login_time',$login_time);

						$data=array(
						'user_id'=>$userde['user_master_id'],
						'login'=> $login_time,
						'logout'=>$logout_time,
						'log_ip'=>$u_ip);
						$this->Main_login_model->save_userlog($data);
					}
					//$_SESSION['IS_LOGIN']='yes';

				//	$this->db->query("delete from loginlogs where IpAddress='$ip_address'");
					$delloginlog=$this->Main_login_model->del_loginlogs($ip_address);
					redirect("Main_login/dashboard");
				}


			}

		else
		{
			$total_count=$total_count+1; 
			$rem_attm=5-$total_count;//exit();
			if($rem_attm==0)
			{
				$msg="To many failed login attempts. Please login after 30 sec";
				
				

			}
			else
			{
				$msg="Please enter valid login details.<br/>$rem_attm attempts remaining";
				
				
			}
				 $try_time=time();
				 $datalog=array(
						'IpAddress'=>$ip_address,
						'TryTime'=> $try_time);
						$this->Main_login_model->save_loginlogs($datalog);

				// $ins=$this->db->query("insert into loginlogs(IpAddress,TryTime) values('$ip_address','$try_time')");
				// 
				// echo $this->db->last_query(); exit();
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center" style="width:100%">'.$msg.'</div>');
				redirect('Main_login/index'); 
		}
		
	}
		//-----------------------------------------------------------------------------------------------
		/*foreach($res as $re)
		{
			$hashed=$re['user_master_password'];
		}
		if($this->phpass->check($paswd,$hashed))
		{
			$userdet=$this->Main_login_model->getuserdetails($uname);//print_r($userdet);exit;
			$user_id=$userdet[0]['user_master_id'];
			$utyp_id=$userdet[0]['user_master_id_user_type'];///added additional 17.10.2019(deepthi)
			$res=$this->Main_login_model->getuserlog($user_id);//print_r($res);exit;
			
			//print_r($userdet);break;186/2019
			if($res==0)
			{
				$this->session->set_userdata('u_id',$user_id);
				$this->session->set_userdata('utyp_id',$utyp_id);
				$this->session->set_userdata('int_userid_pw',$uname);
				redirect("Main_login/ch_pw");
			}
			else
			{
				foreach($userdet as $userde)
				{
					//date_default_timezone_set("Asia/Kolkata");
					$this->session->set_userdata('int_userid',$userde['user_master_id']);
					$this->session->set_userdata('int_usertype',$userde['user_master_id_user_type']);
					$this->session->set_userdata('customer_id',$userde['customer_id']);
					$this->session->set_userdata('survey_user_id',$userde['survey_user_id']);
					//$u_ip=$_SERVER['REMOTE_ADDR'];
					if ($_SERVER["HTTP_X_FORWARDED_FOR"]) 
					{
						$u_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
					}
					else 
					{
						$u_ip = $_SERVER["REMOTE_ADDR"];
					}

					$timestamp = time();
					$date_time = date("Y-m-d  H:i:s", $timestamp);
					$login_time = $date_time;
					$maxlifetime=ini_get("session.gc_maxlifetime");
					$add_time=$timestamp+$maxlifetime;
					$logout_time= date("Y-m-d H:i:s",$add_time);
					$this->session->set_userdata('login_time',$login_time);

					$data=array(
					'user_id'=>$userde['user_master_id'],
					'login'=> $login_time,
					'logout'=>$logout_time,
					'log_ip'=>$this->input->ip_address());
					$this->Main_login_model->save_userlog($data);
				}
				redirect("Main_login/dashboard");
			}
		}
		else
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center" style="width:100%">Invalid username/password</div>');
			redirect('Main_login/index'); 
		}*/
	}
}
public function index_mal()
{	//echo "hiii";exit;
	/////-----test for integration-----------/////
	//$this->load->model('Master_model');
	$this->load->model('Main_login_model');
	$logo			=	$this->Main_login_model->get_active_logo();
	$data['logo'] 	=	$logo;
	$reg			=	$this->Main_login_model->get_active_registration();
	$data['reg'] 	=	$reg;
	$marquee		=	$this->Main_login_model->get_active_marquee_notfn();
	$data['marquee']=	$marquee;
	$reg_items		=	$this->Main_login_model->get_active_registration_items();
	$data['reg_items']=	$reg_items;
	$services		=	$this->Main_login_model->get_active_services();
	$data['services']=	$services;
	$footer			=	$this->Main_login_model->get_active_footer();
	$data['footer'] =	$footer;
	$vesselType		= 	$this->Main_login_model->get_vesseltype_dynamic();
	$data['vesselType']	=	$vesselType; 
	$surveyType			= 	$this->Main_login_model->get_survey_type();
	$data['surveyType']	=	$surveyType;
	$formName			= 	$this->Main_login_model->get_formname_dynamic();
	$data['formName']	=	$formName;
	$data 			= 	$data + $this->data;
	$ports			=	$this->Main_login_model->get_active_portoffices();
	$data['ports']  =	$ports;
	$cnt_port       = 	count($ports);
	$data['cnt_port']  =	$cnt_port;
	$val  			=	1;
	$data['val'] 	=	$val;
	$data 			= 	$data + $this->data;

	$this->load->view('Main_login/websitehead');
	$this->load->view('Main_login/websiteheader', $data);
	$this->load->view('Main_login/websitemarquee', $data);
	$this->load->view('Main_login/websitebody', $data);
	$this->load->view('Main_login/websitefooter', $data);
	$this->load->view('Main_login/websitefoot');
	/////-----test for integration-----------/////
	//$u_h_dat			=	$this->Master_model->getuserdetailsforheader($sess_usr_id);
	//$data['user_header']=	$u_h_dat;
	//$data 				= 	$data + $this->data;
	//$this->load->view('template/header');
	/////-----test for integration-----------/////
	//$this->load->view('Master/login');
	/*$this->load->view('Main_login/mal');*/
	/////-----test for integration-----------/////		
	//$this->load->view('template/footer');
	//$this->load->view('template/js-footer');
	//$this->load->view('template/script-footer');
	//$this->load->view('template/html-footer');

	if($this->input->post())
	{  	//echo "entered";exit;
		$uname=html_escape($this->input->post('vch_un'));
		//$uname=$this->security->xss_clean('$uname');
		//$paswd=html_escape($this->input->post('vch_pw'));
		//$paswd=$this->security->xss_clean('$paswd');
		$paswd=html_escape($this->input->post('vch_pw'));
		$res=$this->Main_login_model->login($uname);//print_r($res);exit;
		foreach($res as $re)
		{
			$hashed=$re['user_master_password'];
			$mainmoduleid=$re['main_module_id']; //1-manual dredging
		}
		if($this->phpass->check($paswd,$hashed))
		{
			$userdet=$this->Main_login_model->getuserdetails($uname);//print_r($userdet);exit;
			$user_id=$userdet[0]['user_master_id'];
			$utyp_id=$userdet[0]['user_master_id_user_type'];///added additional 17.10.2019(deepthi)
			$mainmoduleid=$userdet[0]['main_module_id']; //1-manual dredging
			$res=$this->Main_login_model->getuserlog($user_id);//print_r($res);exit;
			//print_r($userdet);break;
			if($res==0)
			{
				$this->session->set_userdata('u_id',$user_id);
				$this->session->set_userdata('utyp_id',$utyp_id);
				$this->session->set_userdata('int_userid_pw',$uname);
				if($mainmoduleid==1)
					{
						redirect("Manual_dredging/Port/user_change_pw");
					}
					else
						{
							redirect("Main_login/ch_pw");
						}
				//redirect("Main_login/ch_pw");
			}
			else
			{
				foreach($userdet as $userde)
				{
					//date_default_timezone_set("Asia/Kolkata");
					$this->session->set_userdata('int_userid',$userde['user_master_id']);
					$this->session->set_userdata('int_usertype',$userde['user_master_id_user_type']);
					$this->session->set_userdata('customer_id',$userde['customer_id']);
					$this->session->set_userdata('survey_user_id',$userde['survey_user_id']);
					//$u_ip=$_SERVER['REMOTE_ADDR'];
					if ($_SERVER["HTTP_X_FORWARDED_FOR"]) 
					{
						$u_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
					}
					else 
					{
						$u_ip = $_SERVER["REMOTE_ADDR"];
					}
					$timestamp = time();
					$date_time = date("Y-m-d  H:i:s", $timestamp);
					$login_time = $date_time;
					$maxlifetime=ini_get("session.gc_maxlifetime");
					$add_time=$timestamp+$maxlifetime;
					$logout_time= date("Y-m-d H:i:s",$add_time);
					$this->session->set_userdata('login_time',$login_time);
					$data=array(
					'user_id'=>$userde['user_master_id'],
					'login'=> $login_time,
					'logout'=>$logout_time,
					'log_ip'=>$this->input->ip_address());
					$this->Main_login_model->save_userlog($data);
				}
				redirect("Main_login/dashboard");
			}
		}
		else
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center" style="width:100%">Invalid username/password</div>');
			redirect('Main_login/index'); 
		}
	}
}

function tariff_vesselsubtype_ajax()
{ 	   
	$vesseltype_id = 	$_REQUEST['vesseltype_id']; 
	$val 			= 	$_REQUEST['val'];
	$this->load->model('Main_login_model');
	$vesselsub_type			= 	$this->Main_login_model->get_vesselsubtype_dynamic($vesseltype_id);
	$data['vesselsub_type']	=	$vesselsub_type; //print_r($vesselsub_type);exit;
	$data 					= 	$data + $this->data;
	$cnt=count($vesselsub_type);
	if($cnt!=0)
	{
		echo '<option value="">Select Vessel Sub Type</option>';    
		echo '<option value="9999">All</option>';
		foreach ($vesselsub_type as $vesselsub_type_vals) 
		{
			$vessel_subtype_sl  = 	$vesselsub_type_vals['vessel_subtype_sl'];
			$vessel_subtype_name= 	$vesselsub_type_vals['vessel_subtype_name'];
			$vessel_subtype_mal_name= 	$vesselsub_type_vals['vessel_subtype_mal_name'];
			if($val==2){ $name = $vessel_subtype_name;} else { $name = $vessel_subtype_mal_name;}
			echo '<option value="'.$vessel_subtype_sl.'">'. $name.'</option>';
		}
	}
}
function tariff_calculate_ajax()
{ 	   
	$vesselType_name 		= 	$_REQUEST['vesselType_name'];
	$vessel_subtype_name 	= 	$_REQUEST['vessel_subtype_name'];
	$surveyName 			= 	$_REQUEST['surveyName'];
	$formtypeName 			= 	$_REQUEST['formtypeName'];
	$tonnage 				=	$_REQUEST['tonnage'];
	$val 					= 	$_REQUEST['val'];
	$this->load->model('Main_login_model');
	$tonnage_det 			= 	$this->Main_login_model->get_tonnagetype_tariff($surveyName,$formtypeName,$vesselType_name,$vessel_subtype_name);
	//$tariff_det 			= 	$this->Main_login_model->get_det_tariff_public($surveyName,$formtypeName,$vesselType_name,$vessel_subtype_name);
	$data['tonnage_det']		=	$tonnage_det; //print_r($tariff_det);exit;
	$data 					= 	$data + $this->data;
	foreach($tonnage_det as $tonnage_det_res)
	{
		$tonnage_type 		=	$tonnage_det_res['tariff_tonnagetype_id'];
		$day_type 			=	$tonnage_det_res['tariff_day_type'];
	}
	$tariff_det 			= $this->Main_login_model->get_det_tariff_public($surveyName,$formtypeName,$vesselType_name,$vessel_subtype_name);
	$data['tariff_det']		=	$tariff_det; //print_r($tariff_det);exit;
	$data 					= 	$data + $this->data;
	$cnt=count($tariff_det);
	if($cnt!=0)
	{
		if(($tonnage_type==1)&&($day_type==1))
		{
			//echo "All";
			foreach ($tariff_det as $tariff) 
			{
				$id                       = $tariff['tariff_sl'];
				$tariff_sl                = $tariff['tariff_sl'];
				$tariff_activity_id       = $tariff['tariff_activity_id'];
				$tariff_form_id           = $tariff['tariff_form_id'];
				$tariff_vessel_type_id    = $tariff['tariff_vessel_type_id'];
				$tariff_vessel_subtype_id = $tariff['tariff_vessel_subtype_id'];
				$tariff_tonnagetype_id    = $tariff['tariff_tonnagetype_id'];
				$tariff_from_ton          = $tariff['tariff_from_ton']; if($tariff_from_ton==123456789){$tariff_from_ton="-";}
				$tariff_to_ton            = $tariff['tariff_to_ton'];   if($tariff_to_ton==123456789){$tariff_to_ton="-";}
				$tariff_day_type          = $tariff['tariff_day_type'];
				$tariff_from_day          = $tariff['tariff_from_day']; if($tariff_from_day==123456789){$tariff_from_day="-";}
				$tariff_to_day            = $tariff['tariff_to_day'];   if($tariff_to_day==123456789){$tariff_to_day="-";}        
				$tariff_amount            = $tariff['tariff_amount'];
				$tariff_min_amount        = $tariff['tariff_min_amount'];if($tariff_min_amount==0){$tariff_min_amount="-";} 
				$tariff_fine_amount       = $tariff['tariff_fine_amount'];if($tariff_fine_amount==0){$tariff_fine_amount="-";} 
				$tonnagetype_name         = $tariff['tonnagetype_name'];
				$tariffdaytype_name       = $tariff['tariffdaytype_name'];
				if($tariff_amount>$tariff_min_amount)
				{
					$amt=$tariff_amount;
				} 
				else 
				{
					$amt=$tariff_min_amount;
				}
				echo '<table class="table table-bordered table-striped"><tr><td><strong>Tariff Amount</strong></td><td><i class="fas fa-rupee-sign"></i>'.$amt.'</td></tr></table>';	
			}
		} 
		elseif(($tonnage_type==1)&&($day_type==2))
		{
			echo '<table class="table table-bordered table-striped"><tr><th>From</th><th>To</th><th>Amount</th></tr>';
			foreach ($tariff_det as $tariff) 
			{
				$id                       = $tariff['tariff_sl'];
				$tariff_sl                = $tariff['tariff_sl'];
				$tariff_activity_id       = $tariff['tariff_activity_id'];
				$tariff_form_id           = $tariff['tariff_form_id'];
				$tariff_vessel_type_id    = $tariff['tariff_vessel_type_id'];
				$tariff_vessel_subtype_id = $tariff['tariff_vessel_subtype_id'];
				$tariff_tonnagetype_id    = $tariff['tariff_tonnagetype_id'];
				$tariff_from_ton          = $tariff['tariff_from_ton']; if($tariff_from_ton==123456789){$tariff_from_ton="-";}
				$tariff_to_ton            = $tariff['tariff_to_ton'];   if($tariff_to_ton==123456789){$tariff_to_ton="-";}
				$tariff_day_type          = $tariff['tariff_day_type'];
				$tariff_from_day          = $tariff['tariff_from_day']; if($tariff_from_day==123456789){$tariff_from_day="-";}
				$tariff_to_day            = $tariff['tariff_to_day'];   if($tariff_to_day==123456789){$tariff_to_day="-";}        
				$tariff_amount            = $tariff['tariff_amount'];
				$tariff_min_amount        = $tariff['tariff_min_amount'];if($tariff_min_amount==0){$tariff_min_amount="-";} 
				$tariff_fine_amount       = $tariff['tariff_fine_amount'];if($tariff_fine_amount==0){$tariff_fine_amount="-";} 
				$tonnagetype_name         = $tariff['tonnagetype_name'];
				$tariffdaytype_name       = $tariff['tariffdaytype_name'];

				if($tariff_amount>$tariff_min_amount)
				{
				$amt=$tariff_amount;
				} 
				else 
				{
				$amt=$tariff_min_amount;
				}
				echo '<tr><td>'.$tariff_from_day.'</td><td>'.$tariff_to_day.'</td><td><i class="fas fa-rupee-sign"></i>'.$amt.'</td></tr>';	
			}
			echo '</table>';
		}
		elseif (($tonnage_type==2)&&($day_type==1)) 
		{
			//echo "Per";
			echo '<table class="table table-bordered table-striped"><tr><th>Amount Per Ton</th><th>Tonnage</th><th>Total Amount</th></tr>';
			foreach ($tariff_det as $tariff) 
			{
				$id                       = $tariff['tariff_sl'];
				$tariff_sl                = $tariff['tariff_sl'];
				$tariff_activity_id       = $tariff['tariff_activity_id'];
				$tariff_form_id           = $tariff['tariff_form_id'];
				$tariff_vessel_type_id    = $tariff['tariff_vessel_type_id'];
				$tariff_vessel_subtype_id = $tariff['tariff_vessel_subtype_id'];
				$tariff_tonnagetype_id    = $tariff['tariff_tonnagetype_id'];
				$tariff_from_ton          = $tariff['tariff_from_ton']; if($tariff_from_ton==123456789){$tariff_from_ton="-";}
				$tariff_to_ton            = $tariff['tariff_to_ton'];   if($tariff_to_ton==123456789){$tariff_to_ton="-";}
				$tariff_day_type          = $tariff['tariff_day_type'];
				$tariff_from_day          = $tariff['tariff_from_day']; if($tariff_from_day==123456789){$tariff_from_day="-";}
				$tariff_to_day            = $tariff['tariff_to_day'];   if($tariff_to_day==123456789){$tariff_to_day="-";}        
				$tariff_amount            = $tariff['tariff_amount'];
				$tariff_min_amount        = $tariff['tariff_min_amount'];if($tariff_min_amount==0){$tariff_min_amount="-";} 
				$tariff_fine_amount       = $tariff['tariff_fine_amount'];if($tariff_fine_amount==0){$tariff_fine_amount="-";} 
				$tonnagetype_name         = $tariff['tonnagetype_name'];
				$tariffdaytype_name       = $tariff['tariffdaytype_name'];
				if($tariff_amount>$tariff_min_amount)
				{
					$amt=$tariff_amount;
				} 
				else 
				{
					$amt=$tariff_min_amount;
				}
				$tonnage_amt = $tonnage*$amt;
				echo '<tr><td><i class="fas fa-rupee-sign"></i>'.$amt.'</td><td>'.$tonnage.'</td><td><i class="fas fa-rupee-sign"></i>'.$tonnage_amt.'</td></tr>';		
			}
			echo '</table>';
		} 
		elseif (($tonnage_type==2)&&($day_type==2)) 
		{
			//echo "Per";
			echo '<table class="table table-bordered table-striped"><tr><th>Days From</th><th>Days To</th><th>Amount Per Ton</th><th>Tonnage</th><th>Total Amount</th></tr>';
			foreach ($tariff_det as $tariff) 
			{
				$id                       = $tariff['tariff_sl'];
				$tariff_sl                = $tariff['tariff_sl'];
				$tariff_activity_id       = $tariff['tariff_activity_id'];
				$tariff_form_id           = $tariff['tariff_form_id'];
				$tariff_vessel_type_id    = $tariff['tariff_vessel_type_id'];
				$tariff_vessel_subtype_id = $tariff['tariff_vessel_subtype_id'];
				$tariff_tonnagetype_id    = $tariff['tariff_tonnagetype_id'];
				$tariff_from_ton          = $tariff['tariff_from_ton']; if($tariff_from_ton==123456789){$tariff_from_ton="-";}
				$tariff_to_ton            = $tariff['tariff_to_ton'];   if($tariff_to_ton==123456789){$tariff_to_ton="-";}
				$tariff_day_type          = $tariff['tariff_day_type'];
				$tariff_from_day          = $tariff['tariff_from_day']; if($tariff_from_day==123456789){$tariff_from_day="-";}
				$tariff_to_day            = $tariff['tariff_to_day'];   if($tariff_to_day==123456789){$tariff_to_day="-";}        
				$tariff_amount            = $tariff['tariff_amount'];
				$tariff_min_amount        = $tariff['tariff_min_amount'];if($tariff_min_amount==0){$tariff_min_amount="-";} 
				$tariff_fine_amount       = $tariff['tariff_fine_amount'];if($tariff_fine_amount==0){$tariff_fine_amount="-";} 
				$tonnagetype_name         = $tariff['tonnagetype_name'];
				$tariffdaytype_name       = $tariff['tariffdaytype_name'];
				if($tariff_amount>$tariff_min_amount)
				{
					$amt=$tariff_amount;
				} 
				else 
				{
					$amt=$tariff_min_amount;
				}
				$tonnage_amt = $tonnage*$amt;
				echo '<tr><td>'.$tariff_from_day.'</td><td>'.$tariff_to_day.'</td><td><i class="fas fa-rupee-sign"></i>'.$amt.'</td><td>'.$tonnage.'</td><td><i class="fas fa-rupee-sign"></i>'.$tonnage_amt.'</td></tr>';		
			}
			echo '</table>';
		}
		elseif (($tonnage_type==3)&&($day_type==1)) 
		{
			//echo "Range";
			$tariff_range_det 			= $this->Main_login_model->get_det_tariff_range_public($surveyName,$formtypeName,$vesselType_name,$vessel_subtype_name,$tonnage);
			$data['tariff_range_det']	=	$tariff_range_det; //print_r($tariff_det);exit;
			$data 						= 	$data + $this->data;
			foreach ($tariff_range_det as $tariff) 
			{
				$id                       = $tariff['tariff_sl'];
				$tariff_sl                = $tariff['tariff_sl'];
				$tariff_activity_id       = $tariff['tariff_activity_id'];
				$tariff_form_id           = $tariff['tariff_form_id'];
				$tariff_vessel_type_id    = $tariff['tariff_vessel_type_id'];
				$tariff_vessel_subtype_id = $tariff['tariff_vessel_subtype_id'];
				$tariff_tonnagetype_id    = $tariff['tariff_tonnagetype_id'];
				$tariff_from_ton          = $tariff['tariff_from_ton']; if($tariff_from_ton==123456789){$tariff_from_ton="-";}
				$tariff_to_ton            = $tariff['tariff_to_ton'];   if($tariff_to_ton==123456789){$tariff_to_ton="-";}
				$tariff_day_type          = $tariff['tariff_day_type'];
				$tariff_from_day          = $tariff['tariff_from_day']; if($tariff_from_day==123456789){$tariff_from_day="-";}
				$tariff_to_day            = $tariff['tariff_to_day'];   if($tariff_to_day==123456789){$tariff_to_day="-";}        
				$tariff_amount            = $tariff['tariff_amount'];
				$tariff_min_amount        = $tariff['tariff_min_amount'];if($tariff_min_amount==0){$tariff_min_amount="-";} 
				$tariff_fine_amount       = $tariff['tariff_fine_amount'];if($tariff_fine_amount==0){$tariff_fine_amount="-";} 
				$tonnagetype_name         = $tariff['tonnagetype_name'];
				$tariffdaytype_name       = $tariff['tariffdaytype_name'];
				if($tariff_amount>$tariff_min_amount)
				{
					$amt=$tariff_amount;
				} 
				else 
				{
					$amt=$tariff_min_amount;
				}
				echo '<table class="table table-bordered table-striped"><tr><td><strong>Tariff Amount</strong></td><td><i class="fas fa-rupee-sign"></i>'.$amt.'</td></tr></table>';	
			}
		}
		elseif (($tonnage_type==3)&&($day_type==2)) 
		{
			//echo "Range";
			$tariff_range_det 			= $this->Main_login_model->get_det_tariff_range_public($surveyName,$formtypeName,$vesselType_name,$vessel_subtype_name,$tonnage);
			$data['tariff_range_det']	=	$tariff_range_det; //print_r($tariff_det);exit;
			$data 						= 	$data + $this->data;
			echo '<table class="table table-bordered table-striped"><tr><th>Days From</th><th>Days To</th><th> Amount</th></tr>';
			foreach ($tariff_range_det as $tariff) 
			{
				$id                       = $tariff['tariff_sl'];
				$tariff_sl                = $tariff['tariff_sl'];
				$tariff_activity_id       = $tariff['tariff_activity_id'];
				$tariff_form_id           = $tariff['tariff_form_id'];
				$tariff_vessel_type_id    = $tariff['tariff_vessel_type_id'];
				$tariff_vessel_subtype_id = $tariff['tariff_vessel_subtype_id'];
				$tariff_tonnagetype_id    = $tariff['tariff_tonnagetype_id'];
				$tariff_from_ton          = $tariff['tariff_from_ton']; if($tariff_from_ton==123456789){$tariff_from_ton="-";}
				$tariff_to_ton            = $tariff['tariff_to_ton'];   if($tariff_to_ton==123456789){$tariff_to_ton="-";}
				$tariff_day_type          = $tariff['tariff_day_type'];
				$tariff_from_day          = $tariff['tariff_from_day']; if($tariff_from_day==123456789){$tariff_from_day="-";}
				$tariff_to_day            = $tariff['tariff_to_day'];   if($tariff_to_day==123456789){$tariff_to_day="-";}        
				$tariff_amount            = $tariff['tariff_amount'];
				$tariff_min_amount        = $tariff['tariff_min_amount'];if($tariff_min_amount==0){$tariff_min_amount="-";} 
				$tariff_fine_amount       = $tariff['tariff_fine_amount'];if($tariff_fine_amount==0){$tariff_fine_amount="-";} 
				$tonnagetype_name         = $tariff['tonnagetype_name'];
				$tariffdaytype_name       = $tariff['tariffdaytype_name'];
				if($tariff_amount>$tariff_min_amount)
				{
					$amt=$tariff_amount;
				} 
				else 
				{
					$amt=$tariff_min_amount;
				}
				echo '<tr><td>'.$tariff_from_day.'</td><td>'.$tariff_to_day.'</td><td><i class="fas fa-rupee-sign"></i>'.$amt.'</td></tr>';	
			}
			echo '</table>';
		}
	}
	//$cnt=count($tariff_det);
	/*if($cnt!=0)
	{
	echo '<table class="table table-bordered table-striped"><thead><tr><th>Tonnage Type</th>
	<th>From Ton</th>
	<th>To Ton</th>
	<th>Day Type</th>
	<th>From Day</th>
	<th>To Day</th>
	<th>Amt</th>
	<th>Min Amt</th>
	<th>Fine Amt</th></tr></thead><tbody>';    
	foreach ($tariff_det as $tariff) {
	$id                       = $tariff['tariff_sl'];
	$tariff_sl                = $tariff['tariff_sl'];
	$tariff_activity_id       = $tariff['tariff_activity_id'];
	$tariff_form_id           = $tariff['tariff_form_id'];
	$tariff_vessel_type_id    = $tariff['tariff_vessel_type_id'];
	$tariff_vessel_subtype_id = $tariff['tariff_vessel_subtype_id'];
	$tariff_tonnagetype_id    = $tariff['tariff_tonnagetype_id'];
	$tariff_from_ton          = $tariff['tariff_from_ton']; if($tariff_from_ton==123456789){$tariff_from_ton="-";}
	$tariff_to_ton            = $tariff['tariff_to_ton'];   if($tariff_to_ton==123456789){$tariff_to_ton="-";}
	$tariff_day_type          = $tariff['tariff_day_type'];
	$tariff_from_day          = $tariff['tariff_from_day']; if($tariff_from_day==123456789){$tariff_from_day="-";}
	$tariff_to_day            = $tariff['tariff_to_day'];   if($tariff_to_day==123456789){$tariff_to_day="-";}        
	$tariff_amount            = $tariff['tariff_amount'];
	$tariff_min_amount        = $tariff['tariff_min_amount'];if($tariff_min_amount==0){$tariff_min_amount="-";} 
	$tariff_fine_amount       = $tariff['tariff_fine_amount'];if($tariff_fine_amount==0){$tariff_fine_amount="-";} 
	$tonnagetype_name         = $tariff['tonnagetype_name'];
	$tariffdaytype_name       = $tariff['tariffdaytype_name'];
	echo '<tr>
	<td>'.$tonnagetype_name.'</td>
	<td>'.$tariff_from_ton.'</td>
	<td>'.$tariff_to_ton.'</td>
	<td>'.$tariffdaytype_name.'</td>
	<td>'.$tariff_from_day.'</td>
	<td>'.$tariff_to_day.'</td>
	<td>'.$tariff_amount.'</td>
	<td>'.$tariff_min_amount.'</td>
	<td>'.$tariff_fine_amount.'</td> 
	</tr>'; 
	}
	echo '</tbody></table>';
	}*/
}
function port_services_ajax()
{ 	   
	$port           = 	$_REQUEST['port']; 
	$val 			= 	$_REQUEST['val'];
	$this->load->model('Main_login_model');
	$port_det			= 	$this->Main_login_model->get_active_port($port);
	$data['port_det']	=	$port_det;
	foreach($port_det as $port_det_res)
	{
		$port_name  	=  	$port_det_res['vchr_portoffice_name'];
		$port_malname  	=  	$port_det_res['portofregistry_mal_name'];
	}
	if($val==1)
	{
		$name 			=	$port_malname;
	} 
	else 
	{
		$name 			=	$port_name;
	}
	$port_services			= 	$this->Main_login_model->get_active_port_services($port);
	$data['port_services']	=	$port_services; //print_r($vesselsub_type);exit;
	$data 					= 	$data + $this->data;
	$cnt=count($port_services);
	if($cnt!=0)
	{
		if($val==1)
		{
			echo '<li class="list-group-item text-dark"><strong> സേവനങ്ങൾ - '.$name.' തുറമുഖ ഓഫീസ് </strong></li>';
		} 
		else 
		{	
			echo '<li class="list-group-item text-dark"><strong>SERVICES - '.$name.' PORT OFFICE</strong></li>';
		}
		foreach($port_services as $portserv_res)
		{
			$portservce 	=	$portserv_res['portservices_services_sl'];
			$portservce_exp = 	explode(',', $portservce);
			$cnt = count($portservce_exp);
			for($i=0;$i<$cnt;$i++)
			{
				$port_serv 	=	$portservce_exp[$i];
				$get_servc			= 	$this->Main_login_model->get_active_services_byid($port_serv);
				$data['get_servc']	=	$get_servc;
				foreach($get_servc as $get_servc_res)
				{
					$serv_name 		= 	$get_servc_res['services_engtitle'];
					$serv_malname 	= 	$get_servc_res['services_maltitle'];
				}
				if($val==1)
				{
					$sername 			=	$serv_malname;
				} 
				else 
				{
					$sername 			=	$serv_name;
				}
				echo '<li class="list-group-item text-dark">'.$sername.'</li>';
				//echo $sername;
			}
		}
	}
}

function port_locate_ajax()
{ 	   
	$office           = 	$_REQUEST['office']; 
	$val 			= 	$_REQUEST['val'];
	$this->load->model('Main_login_model');
	$port_det			= 	$this->Main_login_model->get_active_port($office);
	$data['port_det']	=	$port_det;
	foreach($port_det as $port_det_res)
	{
		$port_name  	=  	$port_det_res['vchr_portoffice_name'];
		$port_malname  	=  	$port_det_res['portofregistry_mal_name'];
		$port_addrs 	=  	$port_det_res['vchr_portoffice_address'];
		$port_maladdrs 	=  	$port_det_res['vchr_portoffice_maladdress'];
		$map 			=  	$port_det_res['portoffice_map'];
		$cntct 			=	$port_det_res['vchr_portoffice_phone'];
	}
	if($val==1)
	{
		$name 			=	$port_malname;
		$address 		=	$port_maladdrs;
	} 
	else 
	{
		$name 			=	$port_name;
		$address 		=	$port_addrs;
	}
	$cnt=count($port_det);

	if($cnt!=0)
	{
		$map1    ='<div id="map-container-google-9" class="z-depth-1-half map-container-5" >
            <iframe src="'.$map.'" frameborder="0" height="250px;" style="border:0" allowfullscreen></iframe>

  </div>';
		$address1 = '<li class="list-group-item ">'.$address.'</li>
		<li class="list-group-item "> <p><span class="contact-icon fa fa-phone"></span> Phone: '.$cntct.' </p> </li>';
		echo json_encode(array("map" => $map1,"address" => $address1));
	}
}

public function send_mail()
{
	$this->load->model('Main_login_model');
	if($this->input->post())
	{ 

		
		 	
		$date_time 		= date("Y-m-d  H:i:s", time());
		$ip				=	$_SERVER['REMOTE_ADDR'];
		$from_mail_id  	= html_escape($this->input->post('from_mail_id'));
		$val 			= html_escape($this->input->post('val'));
		$services_mail 	= html_escape($this->input->post('services_mail'));
		$subject 		= html_escape($this->input->post('subject'));
		$message 		= html_escape($this->input->post('message'));
		$data=array(
		'mailbox_from'				=>	$from_mail_id,
		'mailbox_service'			=> 	$services_mail,
		'mailbox_subject'			=>	$subject,
		'mailbox_body'				=>	$message,
		'mailbox_received'			=>	$date_time,
		'mailbox_status' 			=>	1,
		'mailbox_created_ipaddress' =>	$ip);
		$data 		= 	$this->security->xss_clean($data);
		//insert the form data into database
		$mail_res	=	$this->db->insert('tb_mailbox', $data);
		if($mail_res)
		{
			if($val==1)
			{
				redirect('Main_login/index_mal');
			} 
			else 
			{
				redirect('Main_login/index');
			}
		}	
	}
}	
function Send_mail_ajax()
{ 	   
	$from_mail_id   = 	$_REQUEST['from_mail_id']; 
	$services_mail  = 	$_REQUEST['services_mail']; 
	$subject  		= 	$_REQUEST['subject']; 
	$message  		= 	$_REQUEST['message']; 
	$val 			= 	$_REQUEST['val'];
	$hid_captcha	=   html_escape($_REQUEST['contactpass']);
	$hiddencaptcha  =	base64_decode($hid_captcha);
	$captcha_input	=	html_escape($_REQUEST['contactcaptcha']);
		
		if($captcha_input != $hiddencaptcha)
		{
			echo '<span class="badge badge-danger p-3 stitlefont">Captcha entered is not correct........</span>';
			
			redirect('Main_login/index');
		}
		else
		{
			$date_time 		=   date("Y-m-d  H:i:s", time());
			$ip				=	$_SERVER['REMOTE_ADDR'];
			$this->load->model('Main_login_model');
			$data=array(
			'mailbox_from'				=>	$from_mail_id,
			'mailbox_service'			=> 	$services_mail,
			'mailbox_subject'			=>	$subject,
			'mailbox_body'				=>	$message,
			'mailbox_received'			=>	$date_time,
			'mailbox_status' 			=>	1,
			'mailbox_created_ipaddress' =>	$ip); //echo $val;print_r($data);exit;
			$data 		= 	$this->security->xss_clean($data);
			//insert the form data into database
			$mail_res	=	$this->db->insert('tb_mailbox', $data);
		
			if($mail_res)
			{
				if($val==1)
				{
					echo '<span class="badge badge-success p-3 stitlefont">നിങ്ങളുടെ സന്ദേശം വിജയകരമായി സമർപ്പിച്ചിരിക്കുന്നു!!!!</span>';
				} 
				else 
				{
					echo '<span class="badge badge-success p-3 stitlefont">Your Message has been successfully Submited!!!!</span>';
				}
		
			}
		}//captcha else closse
}

public function notfns_detail()
{
	$this->load->model('Main_login_model');
	$id 			=  $this->uri->segment(3);
	$data['id'] 	=	$id;
	if($id==1){ $val=1; } else {$val=2;}
	$data['val'] 	=	$val;
	$logo			=	$this->Main_login_model->get_active_footer();
	$data['logo'] 	=	$logo;
	$logo			=	$this->Main_login_model->get_active_logo();
	$data['logo'] 	=	$logo;
	$marquee		=	$this->Main_login_model->get_active_marquee_notfn();
	$data['marquee']=	$marquee;
	$this->load->view('Main_login/websitehead');
	$this->load->view('Main_login/websiteheader',$data);
	$this->load->view('Main_login/notfns_body',$data);
	$this->load->view('Main_login/websitefooter',$data);
	$this->load->view('Main_login/websitefoot');
}	

public function footer_item_desc()
{
	$id 			=  $this->uri->segment(3);
	$data['id'] 	=	$id;
	if($id==1){ $val=1; $data['val'] 	=	$val;}
	$footitem		=  $this->uri->segment(4);
	$data['footitem'] 	=	$footitem;
	$this->load->model('Main_login_model');
	$logo			=	$this->Main_login_model->get_active_footer();
	$data['logo'] 	=	$logo;
	$logo			=	$this->Main_login_model->get_active_logo();
	$data['logo'] 	=	$logo;
	$footeritem		=	$this->Main_login_model->get_active_footer_item_det($footitem);
	$data['footeritem'] =	$footeritem; 
	$this->load->view('Main_login/websitehead');
	$this->load->view('Main_login/websiteheader',$data);
	$this->load->view('Main_login/footer_body',$data);
	$this->load->view('Main_login/websitefooter',$data);
	$this->load->view('Main_login/websitefoot');
}
public function ch_pw()
{
	 $sess_usr_id 	= $this->session->userdata('int_userid_pw');
	 $u_id			=	$this->session->userdata('u_id');
	
	//$userinfo			=	$this->Master_model->getuserinfo($sess_usr_id);
	//$i=0;
	//$port_id			=	$userinfo[$i]['user_master_port_id'];
	if(!empty($sess_usr_id))
	{
		$this->load->model('Main_login_model');
		$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
		$data 				= 	$data + $this->data;     
		$u_h_dat			=	$this->Main_login_model->getuserdetailsforheader($u_id); //print_r($u_h_dat); exit;
		$data['user_header']=	$u_h_dat;
		$data 				= 	$data + $this->data; 
		/*$this->load->view('template_manual/header',$data);
		$this->load->view('Master_manual_dredg/ch_pw', $data);
		$this->load->view('template_manual/footer');
		$this->load->view('template_manual/js-footer');
		$this->load->view('template_manual/script-footer');
		$this->load->view('template_manual/html-footer');*/
		$this->load->view('Kiv_views/template/all-header.php');
		//$this->load->view('template/master-header.php');
		$this->load->view('Main_login/ch_pw', $data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php');
		/*$this->load->view('template/header.php');
		$this->load->view('template/header_script_all.php');
		$this->load->view('template/header_include.php');
		$this->load->view('Main_login/ch_pw', $data);
		$this->load->view('template/copyright.php');
		$this->load->view('template/footer_script_all.php');
		$this->load->view('template/footer_include_all.php');
		$this->load->view('template/footer.php');*/
		if($this->input->post())
		{
			//echo "sdfdgd"; exit;
			$paswd=$this->security->xss_clean(html_escape($this->input->post('c_p')));
			$npaswd=$this->security->xss_clean(html_escape($this->input->post('n_p')));
			$n_c_p=$this->security->xss_clean(html_escape($this->input->post('n_c_p')));
			 //echo $sess_usr_id;
			$res=$this->Main_login_model->login($sess_usr_id);//print_r($res);exit;

			if($npaswd!=$n_c_p)
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Password mismatch</div>');
				redirect("Main_login/ch_pw");
			}

			$ucl = preg_match('/[A-Z]/', $npaswd); // Uppercase Letter
			$lcl = preg_match('/[a-z]/', $npaswd); // Lowercase Letter
			$dig = preg_match('/\d/', $npaswd); // Numeral
			$nos = preg_match('/\W/', $npaswd); // Non-alpha/num characters (allows underscore)

			if(!$ucl) {
			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Password not contain uppercase letter</div>');
			redirect("Main_login/ch_pw");
			}

			if(!$lcl) {
			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Password not contain lowercase letter</div>');
			redirect("Main_login/ch_pw");
			}

			if(!$dig) {
			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Password not contain numbers</div>');
			redirect("Main_login/ch_pw");
			}
			// I negated this if you want to dis-allow non-alphas/num:
			if(!$nos) {
			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Password not contain special characters</div>');
			redirect("Main_login/ch_pw");
			}

			//print_r($res);
			//exit();


			foreach($res as $re)
			{
				$hashed=$re['user_master_password'];
			}
			if($this->phpass->check($paswd,$hashed))
			{
				//$u_ip=$_SERVER['REMOTE_ADDR'];
				if ($_SERVER["HTTP_X_FORWARDED_FOR"]) 
				{
					$u_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
				}
				else 
				{
					$u_ip = $_SERVER["REMOTE_ADDR"];
				}
				$timestamp = time();
				$date_time = date("Y-m-d  H:i:s", $timestamp);
				$login_time = $date_time;
				//$maxlifetime=ini_get("session.gc_maxlifetime");
				//$add_time=$timestamp+$maxlifetime;
				//$logout_time= date("Y-m-d H:i:s",$add_time);
				$newp=$this->phpass->hash($npaswd);
				$data_u=array('user_master_password'=>$newp,
				'user_decrypt_pwd'=>$npaswd); 
				$res1=$this->Main_login_model->up_pw($data_u,$u_id); //print_r($res1);exit;
				if($res1==1)
				{
					//print_r($res1);exit();
					$this->session->set_userdata('login_time',$login_time);
					$data=array(
					'user_id'=>$u_id,
					'login'=> $login_time,
					'logout'=>$login_time,
					'log_ip'=>$u_ip); //print_r($data);exit;
					$this->Main_login_model->save_userlog($data);
					session_destroy();
					redirect('Main_login/index');
				}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Update failed!!!</div>');
					redirect('Main_login/ch_pw');
				}
			}
			else
			{
			$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Please Check your Password!!!</div>');
			redirect('Main_login/ch_pw'); 
			}
		}
	}
	else
	{
		redirect('Main_login/index');        
	}  
}

public function dashboard()
{	//print_r($_SESSION);exit;
	$user_id=$this->session->userdata('int_userid');//exit;
	$sess_usr_id=$user_id;
	if(!empty($user_id))
	{
		$u_h_dat			=	$this->Main_login_model->getuserdetailsforheader($sess_usr_id);
		$data['user_header']=	$u_h_dat;
		$data 				= 	$data + $this->data;
		//$this->load->view('template/header',$data);
		$ut=$this->session->userdata('int_usertype'); //echo $ut;//exit;
		if($ut==1)
		{
			$this->load->view('Master_manual_dredg/dashboard_admin');
		}
		else if($ut==2)
		{
			redirect('Manual_dredging/Port/port_dir_main');
		}
		else if($ut==8)
		{
			redirect('Manual_dredging/Port/port_officer_main');
		}
		else if($ut==3)
		{
			redirect('Main_login/pc_dashboard');
		}
		else if($ut==4)
		{
			redirect('Manual_dredging/Port/port_lsgd_main');
		}
		else if($ut==5)
		{
			$this->session->unset_userdata('int_userid');
			$login_time=$this->session->userdata('login_time');
			$temp_userid=$this->session->set_userdata('tempuser_id',$user_id);
			$this->load->model('Main_login_model');
			$data 				= 	array('title' => 'module', 'page' => 'module', 'errorCls' => NULL, 'post' => $this->input->post());
			$data 				= 	$data + $this->data;     
			$rres=$this->db->query("select customer_registration_id as crid,customer_phone_number as phoneno from customer_registration where customer_public_user_id='$user_id'");
			$ud=$rres->result_array();
			$cus_id=$ud[0]['crid'];
			$cus_phoneno=$ud[0]['phoneno']; 
			$currentdate  =	date('Y-m-d H:i:s');
			$otpno=rand(100000,999999);
			//$otpno=123456;
			//Portinfo 2 - Dear Customer OTP generated for login is {#var#}
			$smsmsg="Portinfo 2 - Dear Customer OTP generated for login is ".$otpno;
			$this->sendSms($smsmsg,$cus_phoneno);
			//-----------------------insert otp in userlog----------------------------
			//	echo "update tbl_userlog set otpnumber='$otpno' where user_id='$user_id' and login='$login_time' and logout='$login_time'";exit();
			$qry=$this->db->query("update tbl_userlog set otpnumber='$otpno' where user_id='$user_id' and login='$login_time'");
			//-------------------------------------------------------------------------
			if($qry)
			{
				$sess_otpno=$this->session->set_userdata('sess_otpno',$otpno);

				redirect('Manual_dredging/Master/customer_otpcheck');
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Please Check your OTP!!!</div>');
			}
		}
		else if($ut==6)
		{
			redirect('Manual_dredging/Port/port_zone_main');
		}
		else if($ut==9)
		{
			redirect('Manual_dredging/Port/port_clerk_main');
		}
		else if($ut==10)///KIV Admin
		{ 	//echo "kkk".$ut;exit;
			//redirect('Master/MasterHome');
			redirect('Kiv_Ctrl/Master/MasterHome');
			//$successmsg	=	"Logged in successfully";
			//$this->session->set_flashdata('logflag',$successmsg);
		}
		else if($ut==11)///Owner
		{
			redirect('Kiv_Ctrl/Survey/SurveyHome');
		}
		else if($ut==12)///Chief Surveyor
		{
			redirect('Kiv_Ctrl/Survey/csHome');
		}
		else if($ut==13)///Surveyor
		{
			redirect('Kiv_Ctrl/Survey/SurveyorHome');
		}
		else if($ut==14)///Registering Authority
		{
			redirect('Kiv_Ctrl/Bookofregistration/raHome');
		}
		else if($ut==15)///Registering Authority
		{
			redirect('Kiv_Ctrl/DataEntry/DataEntryHome');
		}
		else if($ut==16)///Super Admin
		{
			redirect('Super_Ctrl/Super/SuperHome');
		}
		else if($ut==17)///Print User
		{
			redirect('Print_Ctrl/Print_Ctl/PrintHome');
		}
		else
		{
			$this->load->view('Master_manual_dredg/dashboard_PCL');
		}
		/*$this->load->view('template/footer');
		$this->load->view('template/js-footer');
		$this->load->view('template/script-footer');
		$this->load->view('template/html-footer');*/
		$this->load->view('Kiv_views/template/all-header.php');
		$this->load->view('Kiv_views/template/master-header.php');
		//$this->load->view('Master/chainport_type',$data);
		$this->load->view('Kiv_views/template/all-footer.php');
		$this->load->view('Kiv_views/template/all-scripts.php'); 
	}
	else
	{
		redirect('Main_login/index');
	}
}

////   Function For Login END  /////
public function dashboard_master()
{
	redirect('Main_login/dashboard');
}
public function pc_dashboard()
{ 	//print_r($_SESSION);
	$sess_usr_id 	  = $this->session->userdata('int_userid');
	$int_usertype	  =	$this->session->userdata('int_usertype');
	if(!empty($sess_usr_id))
	{
		/*$module			= 	$this->Main_login_model->get_module($int_usertype); //print_r($module);exit;
		$data['module']	=	$module;
		$data 			= 	$data + $this->data;*/
		$port			= 	$this->Main_login_model->get_port_id($sess_usr_id); //print_r($module);exit;
		$data['port']	=	$port;
		$data 			= 	$data + $this->data;
		foreach($port as $val)
		{
			$port_id    =   $val['user_master_port_id'];
		}
		$module			= 	$this->Main_login_model->get_module_new($sess_usr_id,$port_id); 
		 $countmodule=count($module);
		if($countmodule==0)
			{
				redirect('Main_login/index'); 
			}
			else
			{
		//print_r($module);exit;
		$data['module']	=	$module;
		/*$table = "vw_pcinbox_cnt";
		

		$get_count_payment  = $this->Main_login_model->get_view_count($table); 
		$data['get_count_payment']	=	$get_count_payment;

		foreach($get_count_payment as $pay_res){  
            $uid       = $pay_res['uid']; 
            if($uid==$sess_usr_id){ 
              @$pay_cnt   = $pay_res['cnt'];
            
            } else { 
              $pay_cnt=0;
            }
        }*/
        //$data['pay_cnt'] = $pay_cnt;

        $req_pc =   $this->Main_login_model->get_process_flow_pc($sess_usr_id);
	    $req_pc_cnt        =   count($req_pc); 
	    $data['req_pc_cnt']=   $req_pc_cnt;

        $de_req_pc =   $this->Main_login_model->get_dataentry_details_pc($port_id);
	    $de_req_pc_cnt        =   count($de_req_pc); 
	    $data['de_req_pc_cnt']=   $de_req_pc_cnt;        

		$data 			= 	$data + $this->data;
		    

        $reprint_req_pc =   $this->Main_login_model->get_reprint_req_list_pc($port_id);
	    $cnt_req        =   count($reprint_req_pc); 
	    $data['cnt_req']=   $cnt_req;       
		
		 $user_module_id  = $this->Main_login_model->get_main_module_id($sess_usr_id); 
		$data['user_module_id']	=	$user_module_id;   
		//print_r($module_id); 

		$data 			= 	$data + $this->data;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/dash/pcdash',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	}
	else
	{
		redirect('Main_login/index');  
	} 
}

public function innerPage()
{
	$u_h_dat			=	$this->Main_login_model->getuserdetailsforheader($sess_usr_id);
	$data['user_header']=	$u_h_dat;
	$data 				= 	$data + $this->data;
	$this->load->view('template/header',$data);
	$this->load->view('template/inner-list');
	$this->load->view('template/footer');
	$this->load->view('template/js-footer');
	$this->load->view('template/script-footer');
	$this->load->view('template/html-footer');
}
public function logout()
{
	$this->load->model('Main_login_model');
	$sess_usr_id 			=  $this->session->userdata('int_userid');
	$login_time 			=  $this->session->userdata('login_time');
	//date_default_timezone_set("Asia/Kolkata");
	$timestamp = time();
	$date_time = date("Y-m-d  H:i:s", $timestamp);
	$logout_time = $date_time;
	session_destroy();
	if(isset($sess_usr_id))
	{
		$this->Main_login_model->update_userlog($sess_usr_id,$login_time,$logout_time);
	}
	redirect('Main_login/index');
}
//--------------------------------------------------------------------------
public function sendSms($message,$number){

		

		$link = curl_init();

		curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=portsms2&password=portsms1234&message=".$message."&numbers=".$number."&senderid=PORTDR");

		curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($link , CURLOPT_HEADER, 0);
		
		return $output = curl_exec($link);

		curl_close($link );

}
//-----------------------------------------------------------------
public function forget_pw()

	{


			

		    $this->load->view('Kiv_views/Registration/header_reg.php');
			$this->load->view('Main_login/forgetme');
			

			if($this->input->post())

			{
				$this->load->model('Main_login_model');
				$uname=html_escape($this->input->post('c_p'));

				$phone=html_escape($this->input->post('n_p'));

				$rres=$this->db->query("select user_master_id_user_type as ut from user_master where user_master_name='$uname'");

				$ru=$rres->result_array();

				$utype=$ru[0]['ut'];

				if($utype==5)

				{

				$resr=$this->db->query("select * from user_master join customer_registration on user_master.user_master_id=customer_registration.customer_public_user_id where user_master.user_master_name='$uname' and customer_registration.customer_phone_number='$phone'");

				//echo $this->db->last_query();

				//exit;

				}

				else

				{

					$resr=$this->db->query("select * from user_master where user_master_name='$uname' and user_master_ph='$phone'");

				}

				$no=count($resr);//exit();

				if($no==1)

				{
					
					$this->load->model('Main_login_model');
					$pw=bin2hex(openssl_random_pseudo_bytes(4));

					$newp=$this->phpass->hash($pw);

					$msg="Your Password changed successfully,Please note your new password $pw";

					

					$this->db->query("update user_master set user_master_password='$newp',user_decrypt_pwd='$pw' where user_master_name='$uname'");
//echo $this->db->last_query(); exit();
					$this->sendSms($msg,$phone);
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">New password send to your registered mobile number...</div>');
					redirect('Main_login/forget_pw');
				}

				else

				{

					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">!!!Error Please Check your Phone number / Username!!!</div>');

					//redirect('Manual_dredging/Master/ch_pw'); 
					redirect('Main_login/forget_pw');

				}

			}
			$this->load->view('Kiv_views/Registration/footer_reg.php'); 

	}
//__________________End of Controller______________________//
}
?>
