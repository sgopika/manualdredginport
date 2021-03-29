<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hdfc extends CI_Controller {
public function __construct() 
{
	parent::__construct();
	$this->load->library('session');
	$this->load->helper('form');
	$this->load->helper('url');
	$this->load->database();
	$this->load->library('form_validation');
	$this->load->helper('date');
	$this->load->library('encrypt');
	$this->load->library('upload');
	$this->data 		= 	array(
	'controller' 		=> 	$this->router->fetch_class(),
	'method' 			=> 	$this->router->fetch_method(),
	'session_userdata' 	=> 	isset($this->session->userdata) ? $this->session->userdata : '',
	'base_url' 			=> 	base_url(),
	'site_url'  		=> 	site_url(),
	/*'user_sl' 			=> 	isset($this->session->userdata['user_sl']) ? $this->session->userdata['user_sl'] : 0,
	'user_type_id' 		=> 	isset($this->session->userdata['user_type_id']) ? $this->session->userdata['user_type_id'] : 0,*/
	'int_userid'       =>  isset($this->session->userdata['int_userid']) ? $this->session->userdata['int_userid'] : 0,
	'int_usertype'    =>  isset($this->session->userdata['int_usertype']) ? $this->session->userdata['int_usertype'] : 0,
	'customer_id' 		=> 	isset($this->session->userdata['customer_id']) ? $this->session->userdata['customer_id'] : 0,
	'survey_user_id' 	=> 	isset($this->session->userdata['survey_user_id']) ? $this->session->userdata['survey_user_id'] : 0,
	);
	$this->load->model('Kiv_models/Survey_model');
	$this->load->model('Kiv_models/Vessel_change_model'); 
	$this->load->model('Kiv_models/Bookofregistration_model'); 
}

//++++++++++++++++++++++++++++++++++++    Crypto function-------++++++++++++++++++++++++++++++++++++++++++++
function encrypt($plainText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	$encryptedText = bin2hex($openMode);
	return $encryptedText;
}

function decrypt($encryptedText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$encryptedText = hextobin($encryptedText);
	$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	return $decryptedText;
}
//*********** Padding Function *********************

function pkcs5_pad ($plainText, $blockSize)
{
    $pad = $blockSize - (strlen($plainText) % $blockSize);
    return $plainText . str_repeat(chr($pad), $pad);
}

//********** Hexadecimal to Binary function for php 4.0 version ********

function hextobin($hexString) 
{ 
	$length = strlen($hexString); 
	$binString="";   
	$count=0; 
	while($count<$length) 
	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	{
		$binString=$packedString;
	} 
	else 
	{
		$binString.=$packedString;
	} 
	$count+=2; 
	} 
	    return $binString; 
} 
//-----------------------------------------------------------------------------------------------------//
/*
public function corn_update()
{
	$this->db->query("insert into paydet values(NULL,'222','1111','11111','1111','2017-10-13','6666')");
}
*/
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
	$this->email->to('bssajitha@gmail.com');
	$this->email->subject($sub);
	$this->email->message($msg); 
	$result = $this->email->send();
	$res=$this->email->print_debugger();
	return $result;
}

 /*-----------------Curl to send SMS starts-----------*/
public function sendSms($message,$mob_number)
{
    $link = curl_init();
    curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=portsms2&password=portsms1234&message=".$message."&numbers=".$mob_number."&senderid=PORTDR");
    curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($link , CURLOPT_HEADER, 0);
    return $output = curl_exec($link);
    curl_close($link );
} 
/*-----------------Curl to send SMS ends-----------*/


public function Hdfc_request()
{
	$this->load->view('Kiv_views/Hdfc/ccavRequestHandler');
}

public function Hdfc_response()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	//$workingKey 	=	'300C3755D3DCDF6B2E84AF39F934B67C';
	$encResponse 	=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 		= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server

	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	//print_r($get_transaction_request);
	//exit;

	if(!empty($get_transaction_request))
	{
		$vessel_id=$get_transaction_request[0]['vessel_id'];
		$survey_id=$get_transaction_request[0]['survey_id'];
		$form_number=$get_transaction_request[0]['form_number'];
		$sess_usr_id=$get_transaction_request[0]['customer_registration_id'];
		$bank_id=$get_transaction_request[0]['bank_id'];
		$portofregistry_sl=$get_transaction_request[0]['port_id'];
		$hdfc_workingkey 			=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   	= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey=$hdfc_workingkey[0]['working_key'];
		}
	}
	//get vessel name
	$vessel=$this->Survey_model->get_vessel($vessel_id);
	$data['vessel']=$vessel;
	if(!empty($vessel))
	{
		$vessel_name=$vessel[0]['vessel_name'];
	}
	else
	{
		$vessel_name="";
	}
	//get port of registry name
	$registry_port_id             =   $this->Survey_model->get_registry_port_id($portofregistry_sl);
	$data['registry_port_id']     =   $registry_port_id;

	if(!empty($registry_port_id))
	{
		$port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
	}
	else
	{
		$port_of_registry_name="";
	}

	$rcvdString 	=	decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	$res_array=array();

	foreach($decryptValues as $vals)
	{
		$explode_arr	=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id		=	$res_array['0'];
	$tracking_id	=	$res_array['1'];
	$bank_ref_no	=	$res_array['2'];
	$order_status	=	$res_array['3'];
	$failure_message=	$res_array['4'];
	$payment_mode	=	$res_array['5'];
	$card_name		=	$res_array['6'];
	$status_code	=	$res_array['7'];
	$status_message	=	$res_array['8'];
	$currency		=	$res_array['9'];
	$amount			=	intval($res_array['10']);
	$custregid		=	$res_array['26'];
	$transid		=	$res_array['27'];
	$custname		=	$res_array['11'];
	$custphoneno	=	$res_array['17'];
	$custemailid	=	$res_array['18'];
	$response_code	=	$res_array['38'];
	$trans_date		=	$res_array['40'];
	$bank_transaction_id=$res_array['28'];
	//exit;
	/*Array ( 
	[0] => 2239721563521357282  
	[1] => 308005273732
	[2] => 201920089164902 
	[3] => Success 
	[4] => 
	[5] => Credit Card 
	[6] => Visa 
	[7] => null 
	[8] => Signature validation failed 
	[9] => INR 
	[10] => 1.00 
	[11] => Sajitha B S 
	[12] => Room no 1101, near Railway station Ambad 
	[13] => Indore 
	[14] => Kerala 
	[15] => 425001 
	[16] => India 
	[17] => 9847903241
	[18] => sajitha@gmail.com 
	[19] => saji 
	[20] => dgdfg 
	[21] => sfsdfs 
	[22] => Kerala 
	[23] => 695607 
	[24] => India 
	[25] => 9847903241 
	[26] => 1 
	[27] => 62 
	[28] => 2239721563521357282238 
	[29] => 2 
	[30] =>
	[31] => N 
	[32] => null
	[33] => null 
	[34] => 0.0 
	[35] => 1.00 
	[36] => null
	[37] => N 
	[38] => 676 
	[39] => 
	[40] => 19/07/2019 13:00:00
	[41] => RUSSIAN FEDERATION )
	*/

	$banktransdata  			=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   	= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 		=	$banktransdata[0]['token_no'];
		$table_amount 			=	$banktransdata[0]['transaction_amount'];
		$transaction_id 		=	$banktransdata[0]['transaction_id'];
	}
	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
		//$order_status='Success';
	}
	else
	{
		$payment_status=2;
		//$order_status='Invalid';
	}

	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}

	$responds_data=array('tokenno'=>$tokenno_id, 
	'tracking_id'=>$tracking_id,
	'bank_ref_no'=>$bank_ref_no,
	'order_status'=>$order_status,
	'failure_message'=>$failure_message,
	'payment_mode'=>$payment_mode,
	'cardname'=>$card_name,
	'status_code'=>$status_code,
	'status_message'=>$status_message,
	'currency'=>$currency, 
	'amount'=>$amount, 
	'customer_registration_id'=>$custregid,
	'customer_name'=>$custname,
	'customer_tel'=>$custphoneno,
	'customer_emailid'=>$custemailid, 
	'response_code'=>$response_code,
	'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));

	$insert_transaction_reg	 		=	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 						=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));

	/*________________GET reference number start-initial survey___________________*/
	date_default_timezone_set("Asia/Kolkata");
	$date         =   date('Y-m-d h:i:s', time());
	$process_id=1;
	$ref_number_details 		=   $this->Survey_model->get_ref_number_details($vessel_id,$process_id);
	$data['ref_number_details'] =   $ref_number_details;
	
	if(!empty($ref_number_details))
	{
		$ref_number 			= $ref_number_details[0]['ref_number'];
		$ref_id 				= $ref_number_details[0]['ref_id'];
		$data_ref_number 		= array('payment_status' => $payment_status, 'payment_date'=>$date);
	}
	else
	{
		$ref_number =   "";
	}
	$update_ref_number    = 	$this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);

	/*________________GET reference number end-initial survey___________________*/

	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		/*__________________________________Processflow start_____________________________________*/

		date_default_timezone_set("Asia/Kolkata");
		$ip	      	=	$_SERVER['REMOTE_ADDR'];
		$date 	   	= 	date('Y-m-d h:i:s', time());
		$newDate    = 	date("Y-m-d");

		$form_stage_sl       	=   $this->Survey_model->get_form_stage_sl($vessel_id);
		$data['form_stage_sl']  = $form_stage_sl;

		if(!empty($form_stage_sl))
		{
			$stage_sl       = 	$form_stage_sl[0]['stage_sl'];
		}
		$data_portofregistry = 	array(
		'vessel_registry_port_id' => $portofregistry_sl);
		$update_portofregistry		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);

		$port_registry_user_id       =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;
		if(!empty($port_registry_user_id))
		{
			$pc_user_id 					=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 				=	$port_registry_user_id[0]['user_master_id_user_type'];
		}

		$data_payment=array(
		'vessel_id'=>$vessel_id,
		'survey_id'=>$survey_id,
		'form_number'=>$form_number,
		'paymenttype_id'=>$paymenttype_id,
		'dd_amount'=>$amount,
		'dd_date'=>$newDate,
		'portofregistry_id'=>$portofregistry_sl,
		'bank_id'=>$bank_id,
		'payment_mode'=>$payment_mode,
		'transaction_id'=>$bank_transaction_id,
		'payment_created_user_id'=>$sess_usr_id,
		'payment_created_timestamp'=>$date,
		'payment_created_ipaddress'=>$ip);

		$data_stage = 	array(
		'stage' => 8,
		'stage_count'=>8);

		$data_process=array(
		'vessel_id' => $vessel_id, 
		'process_id'=>1,
		'survey_id'=>$survey_id,
		'current_status_id'=>1,
		'current_position'=>$pc_usertype_id,
		'user_id'=>$pc_user_id,
		'status'=>1,
		'status_change_date'=>$date);

		$data_status = array('vessel_id' => $vessel_id,
		'process_id' => 1,
		'survey_id' => $survey_id,
		'current_status_id' => 1,
		'sending_user_id' => $sess_usr_id,
		'receiving_user_id' => $pc_user_id);

		$data_vessel_main= array(
		'processing_status'   =>1,
		'vesselmain_portofregistry_id' => $portofregistry_sl);
		//_____________________________Email sending start_____________________________//
		$email_subject="Initial survey Form 1 registration of ".$vessel_name." completed";
		$email_message="<div><h4>Dear ". $custname.",</h4><p>Your vessel, <b>".$vessel_name."</b> has successfully completed Form 1 registration. Form 1 has been forwarded to <b>".$port_of_registry_name." </b> Port Conservator. On verification of the payment, initial survey activities will be initiated by concerned authority. <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr>
		</div>";
		$saji_email="bssajitha@gmail.com";
		$this->emailSendFunction($saji_email,$email_subject,$email_message);
		//$this->emailSendFunction($custemailid,$email_subject,$email_message);
		//___________________Email sending start___________________________________________//
		//____________________SMS sending start____________________________________________//
		$sms_message="Form 1 registration of ".$vessel_name." has been completed. Reference number is ".$ref_number.".";
		$this->load->model('Kiv_models/Survey_model');
		$saji_mob="9847903241";
      	//$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
		//$stat = $this->Survey_model->sendSms($sms_message,$custphoneno);
		//____________________SMS sending end________________________________________________//
		if($amount>0 && $portofregistry_sl!=false)
		{
			$result_insert 		= 	$this->db->insert('tbl_kiv_payment_details', $data_payment);	
			$updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
			$update_vesselmain  = 	$this->Survey_model->update_vessel_main('tb_vessel_main',$data_vessel_main,$vessel_id);
			$insert_process   	=	$this->Survey_model->insert_process_flow($data_process);
			$insert_data_status   =	$this->Survey_model->insert_status_details('tbl_kiv_status_details',$data_status);
		}
		/*____________________________________processflow end____________________________________*/
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	 => $order_status);
		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}

//_____________________________________________Name Change (Start)_________________________________________//
public function Hdfc_namerequest()
{
	$this->load->view('Kiv_views/Hdfc/ccavnameRequestHandler');
}
public function Hdfc_nameresponse()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	//$workingKey 	=	'300C3755D3DCDF6B2E84AF39F934B67C';
	$encResponse 	=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 		= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server
	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	if(!empty($get_transaction_request))
	{
		$vessel_id 						=	$get_transaction_request[0]['vessel_id'];
		$survey_id 						=	$get_transaction_request[0]['survey_id'];
		$form_number 					=   $get_transaction_request[0]['form_number'];
		$sess_usr_id					=	$get_transaction_request[0]['customer_registration_id'];
		$bank_id 						=	$get_transaction_request[0]['bank_id'];
		$portofregistry_sl 				= 	$get_transaction_request[0]['port_id'];
		$hdfc_workingkey 				=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   		= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey 				= 	$hdfc_workingkey[0]['working_key'];
		}
	}
	$rcvdString 						=	decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status 						=	"";
	$decryptValues 						=	explode('&', $rcvdString);
	$dataSize 							=	sizeof($decryptValues);
	$res_array 							=	array();
	foreach($decryptValues as $vals)
	{
		$explode_arr					=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id							=	$res_array['0'];
	$tracking_id						=	$res_array['1'];
	$bank_ref_no						=	$res_array['2'];
	$order_status						=	$res_array['3'];
	$failure_message					=	$res_array['4'];
	$payment_mode						=	$res_array['5'];
	$card_name							=	$res_array['6'];
	$status_code						=	$res_array['7'];
	$status_message						=	$res_array['8'];
	$currency							=	$res_array['9'];
	$amount								=	intval($res_array['10']);

	$custregid							=	$res_array['26'];
	$transid							=	$res_array['27'];
	$custname							=	$res_array['11'];
	$custphoneno						=	$res_array['17'];
	$custemailid						=	$res_array['18'];
	$response_code						=	$res_array['38'];
	$trans_date							=	$res_array['40'];

	$bank_transaction_id 				=	$res_array['28'];
	
	/*$rrestoken 		=	$this->db->query("SELECT * FROM kiv_bank_transaction_request WHERE bank_transaction_id='$transid'");
	$banktransdata 	=	$rrestoken->result_array();*/

	$banktransdata  					=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   			= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 				=	$banktransdata[0]['token_no'];
		$table_amount 					=	$banktransdata[0]['transaction_amount'];
		$transaction_id 				=	$banktransdata[0]['transaction_id'];
	}
	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
		//$order_status='Success';
	}
	else
	{
		$payment_status=2;
		//$order_status='Invalid';
	}

	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}

	$responds_data=array(
	'tokenno'						=>	$tokenno_id, 
	'tracking_id'					=>	$tracking_id,
	'bank_ref_no'					=>	$bank_ref_no,
	'order_status'					=>	$order_status,
	'failure_message'				=>	$failure_message,
	'payment_mode'					=>	$payment_mode,
	'cardname'						=>	$card_name,
	'status_code'					=>	$status_code,
	'status_message'				=>	$status_message,
	'currency'						=>	$currency, 
	'amount'						=>	$amount, 
	'customer_registration_id'		=>	$custregid,
	'customer_name'					=>	$custname,
	'customer_tel'					=>	$custphoneno,
	'customer_emailid'				=>	$custemailid, 
	'response_code'					=>	$response_code,
	'transaction_date'				=>	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));
	$insert_transaction_reg	 		=	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 						=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));
	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");

		$data_n = array(
		'token'   						=> 	$tokenno_id,
		'bank_ref'	 					=>	$bank_ref_no,
		'name'	 	 					=> 	$custname,
		'amount'	 					=> 	$amount,
		'mobileno'	 					=> 	$custphoneno,
		'email'	 	 					=> 	$custemailid,
		'order_status'					=> 	$order_status);
		$data['saveddata']				=	$data_n;

		/*__________________________________Processflow start_____________________________________*/

		date_default_timezone_set("Asia/Kolkata");
		$ip	      						=	$_SERVER['REMOTE_ADDR'];
		$date 	   						= 	date('Y-m-d h:i:s', time());
		$newDate    					= 	date("Y-m-d");

		$vessel_main                    = $this->Vessel_change_model->get_vessel_main($vessel_id);
		$data['vessel_main']            = $vessel_main;
		if(!empty($vessel_main))
		{
			$vesselmain_sl                = $vessel_main[0]['vesselmain_sl'];
		}

		$status_details       			=   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  		= 	$status_details;
		if(!empty($status_details))
		{
			$status_details_sl       	= 	$status_details[0]['status_details_sl'];
		}
		$processflow_vessel       		=   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  	= 	$processflow_vessel;
		if(!empty($processflow_vessel))
		{
			$processflow_sl       		= 	$processflow_vessel[0]['processflow_sl'];
			$process_id 				= 	$processflow_vessel[0]['process_id'];
		}

		/*$data_portofregistry=array(
		'vessel_registry_port_id' 		=> $portofregistry_sl
		);
		$update_portofregistry				=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);*/

		$port_registry_user_id          =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;
		if(!empty($port_registry_user_id))
		{
			$pc_user_id 					=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 				=	$port_registry_user_id[0]['user_master_id_user_type'];
		}

		$data_payment=array(
		'vessel_id'					=>	$vessel_id,
		'survey_id'					=>	6,
		'form_number'					=>	$form_number,
		'paymenttype_id'				=>	$paymenttype_id,
		'dd_amount'					=>	$amount,
		'dd_date'						=>	$newDate,
		'portofregistry_id'			=>	$portofregistry_sl,
		'bank_id'						=>	$bank_id,
		'payment_mode'				=>	$payment_mode,
		'transaction_id'				=>	$bank_transaction_id,
		'payment_created_user_id'		=>	$sess_usr_id,
		'payment_created_timestamp'	=>	$date,
		'payment_created_ipaddress'	=>	$ip);

		/*if($process_id==38)
		{*/
		/////process flow start indication---- tb_vessel_main processing_status to be changed as 1
		$data_mainupdate=array(
		'processing_status'			=>	1);
		///tbl_name_change payment status
		$data_namechgupdate=array(
		'payment_status'      		=> 	1, 
		'change_payment_date' 		=> 	$newDate);
		/////insert to processflow table showing curre
		$data_insert=array(
		'vessel_id'         		=> 	$vessel_id,
		'process_id'        		=> 	38,
		'survey_id'         		=> 	$survey_id,
		'current_status_id' 		=> 	2,
		'current_position'  		=> 	$pc_usertype_id,
		'user_id'           		=> 	$pc_user_id,
		'previous_module_id'		=> 	$processflow_sl,
		'status'            		=>	1,
		'status_change_date'		=> 	$date); //print_r($data_insert);exit;

			//////update current process status=0
		$data_update=array('status'	=>	0);

		//////update status details table
		$data_survey_status=array(
		'survey_id'        			=> 	$survey_id,
		'process_id'       			=> 	38,
		'current_status_id'			=> 	2,
		'sending_user_id'  			=> 	$sess_usr_id,
		'receiving_user_id'			=> 	$pc_user_id); 

		if($amount>0 && $portofregistry_sl!=false)
		{ 
			//echo "Amt".$amount."---Port".$portofregistry_sl."---Vesmain".$vesselmain_sl."---Vesid".$vessel_id."---Proce".$processflow_sl."---Stat".$status_details_sl;exit;
			$result_insert 				=	$this->db->insert('tbl_kiv_payment_details', $data_payment);
			$vesselmain_update 			=	$this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
			$namechg_update    			=	$this->Vessel_change_model->update_namechg('tbl_namechange',$data_namechgupdate, $vessel_id);
			$process_update				=	$this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
			$process_insert 			=	$this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
			$status_update 				=	$this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
			//}
			if($vesselmain_update && $namechg_update && $process_update && $process_insert && $status_update && $result_insert)
			{
				///get user mail////
				$user_mail_id          	=   $this->Vessel_change_model->get_user_mailid($pc_user_id);
				if(!empty($user_mail_id))
				{
					foreach($user_mail_id as $mail_res)
					{
						$user_mail 		=	$mail_res['user_email'];
						$user_name 		=	$mail_res['user_name'];
						$user_mob 		=	$mail_res['user_mobile_number'];
					}
				}
				$nam_refno       =   $this->Vessel_change_model->get_vesselnamechange_details_ra($vessel_id);
				if(!empty($nam_refno))
				{
					foreach($nam_refno as $nam_res)
					{
						$refno        = $nam_res['ref_number'];
					}	
				}
				/*------------code for send email starts---------------*/
				$config = Array(
				'protocol'        => 'smtp',
				'smtp_host'       => 'ssl://smtp.googlemail.com',
				'smtp_port'       => 465,
				'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
				'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
				'mailtype'        => 'html',
				'charset'         => 'iso-8859-1');//print_r($config);exit;

				$message = 'The Name Change Request (Ref. No:'.$refno.') for the Vessel has been sent by the Vessel Owner. Please Verify for further Processing.';
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from('kivportinfo@gmail.com'); // change it to yours
				//$this->email->to($user_mail);// change it to yours
				$this->email->to('deepthi.nh@gmail.com');

				$this->email->subject('Name Change of Vessel');
				$this->email->message($message);
				if($this->email->send())
				{ 
					//echo "success";redirect("Bookofregistration/raHome");
					// <!------------code for send SMS starts--------------->
					$this->load->model('Kiv_models/Vessel_change_model');
					$mobil="9809119144";
					$stat = $this->Vessel_change_model->sendSms($message,$mobil);
					//print_r($stat);exit;
					//echo json_encode("success");
					//redirect("Bookofregistration/raHome");
					/*------------code for send SMS ends---------------*/
				}
				else
				{
					show_error($this->email->print_debugger());
				} 
			}
		}
		/*if($amount>0 && $portofregistry_sl!=false)
		{

		$result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment);	
		$updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
		$update_vesselmain    = $this->Survey_model->update_vessel_main('tb_vessel_main',$data_vessel_main,$vessel_id);
		$insert_process   		=	$this->Survey_model->insert_process_flow($data_process);
		$insert_data_status   	=	$this->Survey_model->insert_status_details('tbl_kiv_status_details',$data_status);
		}*/

		/*____________________________________processflow end____________________________________*/

		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavnameResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   		=> $tokenno_id,
		'bank_ref'	 	=> $bank_ref_no,
		'name'	 	 	=> $custname,
		'amount'	 	=> $amount,
		'mobileno'	 	=> $custphoneno,
		'email'	 	 	=> $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavnameResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}
//_________________________________________Name Change (END)______________________________________//

//___________________________________________Initial FORM 3 START_________________________________//


public function Hdfc_initialsurvey_form3_request()
{
	$this->load->view('Kiv_views/Hdfc/ccavRequestHandler_initialsurvey_form3');
}

public function Hdfc_response_initialsurvey_form3()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	$encResponse 	=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 		= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server
	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	if(!empty($get_transaction_request))
	{
		$vessel_id=$get_transaction_request[0]['vessel_id'];
		$survey_id=$get_transaction_request[0]['survey_id'];
		$form_number=$get_transaction_request[0]['form_number'];
		$sess_usr_id=$get_transaction_request[0]['customer_registration_id'];
		$bank_id=$get_transaction_request[0]['bank_id'];
		$portofregistry_sl=$get_transaction_request[0]['port_id'];

		$hdfc_workingkey 			=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   	= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey=$hdfc_workingkey[0]['working_key'];
		}
	}
	//get vessel name
	$vessel=$this->Survey_model->get_vessel($vessel_id);
	$data['vessel']=$vessel;
	if(!empty($vessel))
	{
		$vessel_name=$vessel[0]['vessel_name'];
	}
	else
	{
		$vessel_name="";
	}
	//get port of registry name
	$registry_port_id             =   $this->Survey_model->get_registry_port_id($portofregistry_sl);
	$data['registry_port_id']     =   $registry_port_id;

	if(!empty($registry_port_id))
	{
		$port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
	}
	else
	{
		$port_of_registry_name="";
	}

	$rcvdString 	=	decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	$res_array=array();

	foreach($decryptValues as $vals)
	{
		$explode_arr	=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id		=	$res_array['0'];
	$tracking_id	=	$res_array['1'];
	$bank_ref_no	=	$res_array['2'];
	$order_status	=	$res_array['3'];
	$failure_message=	$res_array['4'];
	$payment_mode	=	$res_array['5'];
	$card_name		=	$res_array['6'];
	$status_code	=	$res_array['7'];
	$status_message	=	$res_array['8'];
	$currency		=	$res_array['9'];
	$amount			=	intval($res_array['10']);

	$custregid		=	$res_array['26'];
	$transid		=	$res_array['27'];
	$custname		=	$res_array['11'];
	$custphoneno	=	$res_array['17'];
	$custemailid	=	$res_array['18'];
	$response_code	=	$res_array['38'];
	$trans_date		=	$res_array['40'];
	$bank_transaction_id=$res_array['28'];

	$banktransdata  			=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   	= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 		=	$banktransdata[0]['token_no'];
		$table_amount 			=	$banktransdata[0]['transaction_amount'];
		$transaction_id 		=	$banktransdata[0]['transaction_id'];
		$survey_id 				=	$banktransdata[0]['survey_id'];
	}

	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
	}
	else
	{
		$payment_status=2;
	}

	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}

	$responds_data=array('tokenno'=>$tokenno_id, 
	'tracking_id'=>$tracking_id,
	'bank_ref_no'=>$bank_ref_no,
	'order_status'=>$order_status,
	'failure_message'=>$failure_message,
	'payment_mode'=>$payment_mode,
	'cardname'=>$card_name,
	'status_code'=>$status_code,
	'status_message'=>$status_message,
	'currency'=>$currency, 
	'amount'=>$amount, 
	'customer_registration_id'=>$custregid,
	'customer_name'=>$custname,
	'customer_tel'=>$custphoneno,
	'customer_emailid'=>$custemailid, 
	'response_code'=>$response_code,
	'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));
	$insert_transaction_reg	 		=	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 						=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));
	/*________________GET reference number start-initial survey___________________*/
	date_default_timezone_set("Asia/Kolkata");
	$date         =   date('Y-m-d h:i:s', time());
	$process_id=1;
	$ref_number_details 		=   $this->Survey_model->get_ref_number_details($vessel_id,$process_id);
	$data['ref_number_details'] =   $ref_number_details;
	
	if(!empty($ref_number_details))
	{
		$ref_number 			= $ref_number_details[0]['ref_number'];
		$ref_id 				= $ref_number_details[0]['ref_id'];
		$data_ref_number 		= array('payment_status' => '1', 'payment_date'=>$date);
	}
	else
	{
		$ref_number =   "";
	}
	$update_ref_number    = 	$this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);

	/*________________GET reference number end-initial survey___________________*/


	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;

		/*__________________________________Processflow start_____________________________________*/

		date_default_timezone_set("Asia/Kolkata");
		$ip	      	=	$_SERVER['REMOTE_ADDR'];
		$date 	   	= 	date('Y-m-d h:i:s', time());
		$newDate    = 	date("Y-m-d");

		$status_change_date=date('Y-m-d h:i:s', time());

		$status=1;

		$status_details       	=   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  = $status_details;
		if(!empty($status_details))
		{
			$status_details_sl       = 	$status_details[0]['status_details_sl'];
		}
		$processflow_vessel       	=   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  = $processflow_vessel;
		//print_r($processflow_vessel);
		//exit;
		if(!empty($processflow_vessel))
		{
			$processflow_sl       = 	$processflow_vessel[0]['processflow_sl'];
			$process_id = 	$processflow_vessel[0]['process_id'];
		}

		$data_portofregistry = 	array(
		'vessel_registry_port_id' => $portofregistry_sl);
		$update_portofregistry		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);

		$port_registry_user_id        =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;
		if(!empty($port_registry_user_id))
		{
			$pc_user_id 					=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 				=	$port_registry_user_id[0]['user_master_id_user_type'];
		}
		//if($process_id==5)
		//{

		$data_payment=array(
		'vessel_id'=>$vessel_id,
		'survey_id'=>$survey_id,
		'form_number'=>$form_number,
		'paymenttype_id'=>$paymenttype_id,
		'dd_amount'=>$amount,
		'dd_date'=>$newDate,
		'portofregistry_id'=>$portofregistry_sl,
		'bank_id'=>$bank_id,
		'payment_mode'=>$payment_mode,
		'transaction_id'=>$bank_transaction_id,
		'payment_created_user_id'=>$sess_usr_id,
		'payment_created_timestamp'=>$date,
		'payment_created_ipaddress'=>$ip);

		$data_insert=array(
		'vessel_id'=>$vessel_id,
		'process_id'=>$process_id,
		'survey_id'=>$survey_id,
		'current_status_id'=>2,
		'current_position'=>$pc_usertype_id,
		'user_id'=>$pc_user_id,
		'previous_module_id'=>$processflow_sl,
		'status'=>$status,
		'status_change_date'=>$status_change_date);


		$data_update = array('status'=>0);

		$data_survey_status=array(
		'process_id'=>$process_id,
		'current_status_id'=>2,
		'sending_user_id'=>$sess_usr_id,
		'receiving_user_id'=>$pc_user_id);

		$data_vessel_main= array('processing_status'=>1,
		'vesselmain_portofregistry_id' => $portofregistry_sl);
		//_____________________________Email sending start_____________________________//
		$email_subject="Initial survey Form 3 registration of ".$vessel_name." completed";
		$email_message="<div><h4>Dear ". $custname.",</h4><p>Your vessel, <b>".$vessel_name."</b> has successfully completed Form 3 registration. Form 3 has been forwarded to <b>".$port_of_registry_name." </b> Port Conservator. On verification of the payment, initial survey activities will be initiated by concerned authority. <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr>
		</div>";
		$saji_email="bssajitha@gmail.com";
		$this->emailSendFunction($saji_email,$email_subject,$email_message);
		//$this->emailSendFunction($custemailid,$email_subject,$email_message);
		//___________________Email sending start___________________________________________//
		//____________________SMS sending start____________________________________________//
		$sms_message="Form 3 registration of ".$vessel_name." has been completed. Reference number is ".$ref_number.".";
		$this->load->model('Kiv_models/Survey_model');
		$saji_mob="9847903241";
      	//$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
		//$stat = $this->Survey_model->sendSms($sms_message,$custphoneno);
		//____________________SMS sending end________________________________________________//


		$result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment);
		$update_vesselmain    = $this->Survey_model->update_vessel_main('tb_vessel_main',$data_vessel_main,$vessel_id);
		$process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
		$process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
		$status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
		/*____________________________________processflow end____________________________________*/

		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler_initialsurvey_form3',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	 => $order_status);
		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler_initialsurvey_form3',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}
//_________________________________________Initial survey FORM 3 (EnD)______________________________//


//__________________________________FORM 1 pending payment start___________________________________//

public function Hdfc_request_pendingform1()
{
	$this->load->view('Kiv_views/Hdfc/ccavRequestHandler_pendingform1');
}

public function Hdfc_response_pendingform1()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	//$workingKey 	=	'300C3755D3DCDF6B2E84AF39F934B67C';
	$encResponse 	=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 		= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server
	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	if(!empty($get_transaction_request))
	{
		$vessel_id=$get_transaction_request[0]['vessel_id'];
		$survey_id=$get_transaction_request[0]['survey_id'];
		$form_number=$get_transaction_request[0]['form_number'];
		$sess_usr_id=$get_transaction_request[0]['customer_registration_id'];
		$bank_id=$get_transaction_request[0]['bank_id'];
		$portofregistry_sl=$get_transaction_request[0]['port_id'];

		$hdfc_workingkey 			=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   	= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey=$hdfc_workingkey[0]['working_key'];
		}
	}
	//get vessel name
	$vessel=$this->Survey_model->get_vessel($vessel_id);
	$data['vessel']=$vessel;
	if(!empty($vessel))
	{
		$vessel_name=$vessel[0]['vessel_name'];
	}
	else
	{
		$vessel_name="";
	}
	//get port of registry name
	$registry_port_id             =   $this->Survey_model->get_registry_port_id($portofregistry_sl);
	$data['registry_port_id']     =   $registry_port_id;

	if(!empty($registry_port_id))
	{
		$port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
	}
	else
	{
		$port_of_registry_name="";
	}

	$rcvdString 	=	decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	$res_array=array();

	foreach($decryptValues as $vals)
	{
		$explode_arr	=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id		=	$res_array['0'];
	$tracking_id	=	$res_array['1'];
	$bank_ref_no	=	$res_array['2'];
	$order_status	=	$res_array['3'];
	$failure_message=	$res_array['4'];
	$payment_mode	=	$res_array['5'];
	$card_name		=	$res_array['6'];
	$status_code	=	$res_array['7'];
	$status_message	=	$res_array['8'];
	$currency		=	$res_array['9'];
	$amount			=	intval($res_array['10']);

	$custregid		=	$res_array['26'];
	$transid		=	$res_array['27'];
	$custname		=	$res_array['11'];
	$custphoneno	=	$res_array['17'];
	$custemailid	=	$res_array['18'];
	$response_code	=	$res_array['38'];
	$trans_date		=	$res_array['40'];
	$bank_transaction_id=$res_array['28'];
	$banktransdata  			=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   	= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 		=	$banktransdata[0]['token_no'];
		$table_amount 			=	$banktransdata[0]['transaction_amount'];
		$transaction_id 			=	$banktransdata[0]['transaction_id'];
	}
	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
	}
	else
	{
		$payment_status=2;
	}
	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}

	$responds_data=array('tokenno'=>$tokenno_id, 
	'tracking_id'=>$tracking_id,
	'bank_ref_no'=>$bank_ref_no,
	'order_status'=>$order_status,
	'failure_message'=>$failure_message,
	'payment_mode'=>$payment_mode,
	'cardname'=>$card_name,
	'status_code'=>$status_code,
	'status_message'=>$status_message,
	'currency'=>$currency, 
	'amount'=>$amount, 
	'customer_registration_id'=>$custregid,
	'customer_name'=>$custname,
	'customer_tel'=>$custphoneno,
	'customer_emailid'=>$custemailid, 
	'response_code'=>$response_code,
	'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));

	$insert_transaction_reg	 		=	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 						=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));
	/*________________GET reference number start-initial survey___________________*/
	date_default_timezone_set("Asia/Kolkata");
	$date         =   date('Y-m-d h:i:s', time());
	$process_id=1;
	$ref_number_details 		=   $this->Survey_model->get_ref_number_details($vessel_id,$process_id);
	$data['ref_number_details'] =   $ref_number_details;
	
	if(!empty($ref_number_details))
	{
		$ref_number 			= $ref_number_details[0]['ref_number'];
		$ref_id 				= $ref_number_details[0]['ref_id'];
		$data_ref_number 		= array('payment_status' => $payment_status, 'payment_date'=>$date);
	}
	else
	{
		$ref_number =   "";
	}
	$update_ref_number    = 	$this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);

	/*________________GET reference number end-initial survey___________________*/
	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		/*__________________________________Processflow start_____________________________________*/
		date_default_timezone_set("Asia/Kolkata");
		$ip	      	=	$_SERVER['REMOTE_ADDR'];
		$date 	   	= 	date('Y-m-d h:i:s', time());
		$newDate    = 	date("Y-m-d");

		$form_stage_sl       	=   $this->Survey_model->get_form_stage_sl($vessel_id);
		$data['form_stage_sl']  = $form_stage_sl;
		if(!empty($form_stage_sl))
		{
			$stage_sl       = 	$form_stage_sl[0]['stage_sl'];
		}
		$data_portofregistry = 	array(
		'vessel_registry_port_id' => $portofregistry_sl);
		$update_portofregistry		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);

		$status_details       	=   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  = $status_details;
		if(!empty($status_details))
		{
			$status_details_sl       = 	$status_details[0]['status_details_sl'];
		}
		$processflow_vessel       	=   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  = $processflow_vessel;

		if(!empty($processflow_vessel))
		{
			$processflow_sl       = 	$processflow_vessel[0]['processflow_sl'];
			$process_id = 	$processflow_vessel[0]['process_id'];
		}

		$port_registry_user_id        =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;
		if(!empty($port_registry_user_id))
		{
			$pc_user_id 					=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 			=	$port_registry_user_id[0]['user_master_id_user_type'];
		}
		$data_payment=array(
		'vessel_id'=>$vessel_id,
		'survey_id'=>$survey_id,
		'form_number'=>$form_number,
		'paymenttype_id'=>$paymenttype_id,
		'dd_amount'=>$amount,
		'dd_date'=>$newDate,
		'portofregistry_id'=>$portofregistry_sl,
		'bank_id'=>$bank_id,
		'payment_mode'=>$payment_mode,
		'transaction_id'=>$bank_transaction_id,
		'payment_created_user_id'=>$sess_usr_id,
		'payment_created_timestamp'=>$date,
		'payment_created_ipaddress'=>$ip);

		$data_stage =   array(
		'stage' => 8,
		'stage_count'=>8);

		$data_update=array(
		'process_id'=>1,
		'current_status_id'=>1,
		'current_position'=>$pc_usertype_id,
		'user_id'=>$pc_user_id,
		'status'=>1,
		'status_change_date'=>$date);

		$data_survey_status = array(
		'process_id' => 1,
		'current_status_id' => 1,
		'sending_user_id' => $sess_usr_id,
		'receiving_user_id' => $pc_user_id);

		$data_vessel_main= array(
		'processing_status'   =>1,
		'vesselmain_portofregistry_id' => $portofregistry_sl);
		//_____________________________Email sending start_____________________________//
		$email_subject="Initial survey Form 1 registration of ".$vessel_name." completed";
		$email_message="<div><h4>Dear ". $custname.",</h4><p>Your vessel, <b>".$vessel_name."</b> has successfully completed Form 1 registration. Form 1 has been forwarded to <b>".$port_of_registry_name." </b> Port Conservator. On verification of the payment, initial survey activities will be initiated by concerned authority. <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Survey Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr>
		</div>";
		$saji_email="bssajitha@gmail.com";
		$this->emailSendFunction($saji_email,$email_subject,$email_message);
		//$this->emailSendFunction($custemailid,$email_subject,$email_message);
		//___________________Email sending start___________________________________________//
		//____________________SMS sending start____________________________________________//
		$sms_message="Form 1 registration of ".$vessel_name." has been completed. Reference number is ".$ref_number.".";
		$this->load->model('Kiv_models/Survey_model');
		$saji_mob="9847903241";
      	//$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
		//$stat = $this->Survey_model->sendSms($sms_message,$custphoneno);
		//____________________SMS sending end________________________________________________//

		if($amount>0 && $portofregistry_sl!=false)
		{
			$update_vesselmain    = $this->Survey_model->update_vessel_main('tb_vessel_main',$data_vessel_main,$vessel_id);
			$result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment); 
			$process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
			$updstatus_res    = $this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
			$status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
		}
		/*____________________________________processflow end____________________________________*/
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	 => $order_status);

		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}
//_____________________________________Form 1 pending payment END_______________________________//

//______________________________________________Form 4 payment Start______________________________________//

public function Hdfc_request_form4()
{
	$this->load->view('Kiv_views/Hdfc/ccavRequestHandler_form4');
}

public function Hdfc_response_form4()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	$encResponse 	=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 		= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server

	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	if(!empty($get_transaction_request))
	{
		$vessel_id=$get_transaction_request[0]['vessel_id'];
		$survey_id=$get_transaction_request[0]['survey_id'];
		$form_number=$get_transaction_request[0]['form_number'];
		$sess_usr_id=$get_transaction_request[0]['customer_registration_id'];
		$bank_id=$get_transaction_request[0]['bank_id'];
		$portofregistry_sl=$get_transaction_request[0]['port_id'];

		$hdfc_workingkey 			=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   	= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey=$hdfc_workingkey[0]['working_key'];
		}
	}

	$rcvdString 	=	decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	$res_array=array();

	foreach($decryptValues as $vals)
	{
		$explode_arr	=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id		=	$res_array['0'];
	$tracking_id	=	$res_array['1'];
	$bank_ref_no	=	$res_array['2'];
	$order_status	=	$res_array['3'];
	$failure_message=	$res_array['4'];
	$payment_mode	=	$res_array['5'];
	$card_name		=	$res_array['6'];
	$status_code	=	$res_array['7'];
	$status_message	=	$res_array['8'];
	$currency		=	$res_array['9'];
	$amount			=	intval($res_array['10']);

	$custregid		=	$res_array['26'];
	$transid		=	$res_array['27'];
	$custname		=	$res_array['11'];
	$custphoneno	=	$res_array['17'];
	$custemailid	=	$res_array['18'];
	$response_code	=	$res_array['38'];
	$trans_date		=	$res_array['40'];

	$bank_transaction_id=$res_array['28'];


	$banktransdata  			=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   	= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 		=	$banktransdata[0]['token_no'];
		$table_amount 			=	$banktransdata[0]['transaction_amount'];
		$transaction_id 		=	$banktransdata[0]['transaction_id'];
		$survey_id 		=	$banktransdata[0]['survey_id'];
	}

	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
	}
	else
	{
		$payment_status=2;
	}
	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}

	$responds_data=array('tokenno'=>$tokenno_id, 
	'tracking_id'=>$tracking_id,
	'bank_ref_no'=>$bank_ref_no,
	'order_status'=>$order_status,
	'failure_message'=>$failure_message,
	'payment_mode'=>$payment_mode,
	'cardname'=>$card_name,
	'status_code'=>$status_code,
	'status_message'=>$status_message,
	'currency'=>$currency, 
	'amount'=>$amount, 
	'customer_registration_id'=>$custregid,
	'customer_name'=>$custname,
	'customer_tel'=>$custphoneno,
	'customer_emailid'=>$custemailid, 
	'response_code'=>$response_code,
	'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));


	$insert_transaction_reg	 		=	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 						=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));
	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		/*__________________________________Processflow start_____________________________________*/

		date_default_timezone_set("Asia/Kolkata");
		$ip	      	=	$_SERVER['REMOTE_ADDR'];
		$date 	   	= 	date('Y-m-d h:i:s', time());
		$newDate    = 	date("Y-m-d");

		$status_change_date=date('Y-m-d h:i:s', time());
		$status=1;
		$status_details       	=   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  = $status_details;
		if(!empty($status_details))
		{
			$status_details_sl       = 	$status_details[0]['status_details_sl'];
		}

		$processflow_vessel       	=   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  = $processflow_vessel;
		if(!empty($processflow_vessel))
		{
			$processflow_sl       = 	$processflow_vessel[0]['processflow_sl'];
			$process_id = 	$processflow_vessel[0]['process_id'];
		}

		$data_portofregistry = 	array(
		'vessel_registry_port_id' => $portofregistry_sl);
		$update_portofregistry		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);

		$port_registry_user_id      =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;

		if(!empty($port_registry_user_id))
		{
			$pc_user_id 				=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 			=	$port_registry_user_id[0]['user_master_id_user_type'];
		}
		$data_payment=array(
		'vessel_id'=>$vessel_id,
		'survey_id'=>$survey_id,
		'form_number'=>$form_number,
		'paymenttype_id'=>$paymenttype_id,
		'dd_amount'=>$amount,
		'dd_date'=>$newDate,
		'portofregistry_id'=>$portofregistry_sl,
		'bank_id'=>$bank_id,
		'payment_mode'=>$payment_mode,
		'transaction_id'=>$bank_transaction_id,
		'payment_created_user_id'=>$sess_usr_id,
		'payment_created_timestamp'=>$date,
		'payment_created_ipaddress'=>$ip);

		$data_insert=array(
		'vessel_id'=>$vessel_id,
		'process_id'=>$process_id,
		'survey_id'=>$survey_id,
		'current_status_id'=>1,
		'current_position'=>$pc_usertype_id,
		'user_id'=>$pc_user_id,
		'previous_module_id'=>$processflow_sl,
		'status'=>$status,
		'status_change_date'=>$status_change_date);

		$data_update = array('status'=>0);

		$data_survey_status=array(
		'process_id'=>$process_id,
		'current_status_id'=>1,
		'sending_user_id'=>$sess_usr_id,
		'receiving_user_id'=>$pc_user_id);

		//if($dd_amount!=0 && $portofregistry_sl!=false)
		//{
		$result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment); 
		$process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
		$process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
		$status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
		//}
		/*____________________________________processflow end____________________________________*/
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	 => $order_status);
		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}

//______________________________________________Form 4 payment END______________________________________//

//_____________________________________Annual survey form2 Start______________________________________//

public function hdfc_request_annualsurvey()
{
	$this->load->view('Kiv_views/Hdfc/ccavRequestandler_annualsurvey');
}

public function hdfc_response_annualsurvey()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	$encResponse 	=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 		= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server
	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	if(!empty($get_transaction_request))
	{
		$vessel_id=$get_transaction_request[0]['vessel_id'];
		$survey_id=$get_transaction_request[0]['survey_id'];
		$form_number=$get_transaction_request[0]['form_number'];
		$sess_usr_id=$get_transaction_request[0]['customer_registration_id'];
		$bank_id=$get_transaction_request[0]['bank_id'];
		$portofregistry_sl=$get_transaction_request[0]['port_id'];
		$hdfc_workingkey 			=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   	= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey=$hdfc_workingkey[0]['working_key'];
		}
	}

	$rcvdString 	=	decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	$res_array=array();

	foreach($decryptValues as $vals)
	{
		$explode_arr	=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id		=	$res_array['0'];
	$tracking_id	=	$res_array['1'];
	$bank_ref_no	=	$res_array['2'];
	$order_status	=	$res_array['3'];
	$failure_message=	$res_array['4'];
	$payment_mode	=	$res_array['5'];
	$card_name		=	$res_array['6'];
	$status_code	=	$res_array['7'];
	$status_message	=	$res_array['8'];
	$currency		=	$res_array['9'];
	$amount			=	intval($res_array['10']);

	$custregid		=	$res_array['26'];
	$transid		=	$res_array['27'];
	$custname		=	$res_array['11'];
	$custphoneno	=	$res_array['17'];
	$custemailid	=	$res_array['18'];
	$response_code	=	$res_array['38'];
	$trans_date		=	$res_array['40'];
	$bank_transaction_id=$res_array['28'];

	$banktransdata  			=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   	= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 		=	$banktransdata[0]['token_no'];
		$table_amount 			=	$banktransdata[0]['transaction_amount'];
		$transaction_id 		=	$banktransdata[0]['transaction_id'];
		$survey_id 		=	$banktransdata[0]['survey_id'];
	}
	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
	}
	else
	{
		$payment_status=2;
	}

	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}

	$responds_data=array('tokenno'=>$tokenno_id, 
	'tracking_id'=>$tracking_id,
	'bank_ref_no'=>$bank_ref_no,
	'order_status'=>$order_status,
	'failure_message'=>$failure_message,
	'payment_mode'=>$payment_mode,
	'cardname'=>$card_name,
	'status_code'=>$status_code,
	'status_message'=>$status_message,
	'currency'=>$currency, 
	'amount'=>$amount, 
	'customer_registration_id'=>$custregid,
	'customer_name'=>$custname,
	'customer_tel'=>$custphoneno,
	'customer_emailid'=>$custemailid, 
	'response_code'=>$response_code,
	'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));

	$insert_transaction_reg	 		=	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 						=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));

	/*________________GET reference number start-annual survey___________________*/
	date_default_timezone_set("Asia/Kolkata");
	$date         =   date('Y-m-d h:i:s', time());
	$process_id=2;
	$ref_number_details 		=   $this->Survey_model->get_ref_number_details($vessel_id,$process_id);
	$data['ref_number_details'] =   $ref_number_details;

	if(!empty($ref_number_details))
	{
		$ref_id 				= $ref_number_details[0]['ref_id'];
		$data_ref_number 		= array('payment_status' => $payment_status, 'payment_date'=>$date);
	}
	$update_ref_number    = 	$this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);

	/*________________GET reference number end-annual survey___________________*/

	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");

		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		/*__________________________________Processflow start_____________________________________*/

		date_default_timezone_set("Asia/Kolkata");
		$ip	      	=	$_SERVER['REMOTE_ADDR'];
		$date 	   	= 	date('Y-m-d h:i:s', time());
		$newDate    = 	date("Y-m-d");
		$status_change_date=date('Y-m-d h:i:s', time());
		$status=1;
		$status_details       	=   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  = $status_details;
		if(!empty($status_details))
		{
			$status_details_sl       = 	$status_details[0]['status_details_sl'];
		}

		$processflow_vessel       	=   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  = $processflow_vessel;
		if(!empty($processflow_vessel))
		{
			$processflow_sl       = 	$processflow_vessel[0]['processflow_sl'];
			$process_id = 	$processflow_vessel[0]['process_id'];
		}

		$data_portofregistry = 	array(
		'vessel_registry_port_id' => $portofregistry_sl);
		$update_portofregistry		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);

		$port_registry_user_id       =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;

		if(!empty($port_registry_user_id))
		{
			$pc_user_id 					=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 				=	$port_registry_user_id[0]['user_master_id_user_type'];
		}
		$data_payment=array(
		'vessel_id'=>$vessel_id,
		'survey_id'=>$survey_id,
		'form_number'=>$form_number,
		'paymenttype_id'=>$paymenttype_id,
		'dd_amount'=>$amount,
		'dd_date'=>$newDate,
		'portofregistry_id'=>$portofregistry_sl,
		'bank_id'=>$bank_id,
		'payment_mode'=>$payment_mode,
		'transaction_id'=>$bank_transaction_id,
		'payment_created_user_id'=>$sess_usr_id,
		'payment_created_timestamp'=>$date,
		'payment_created_ipaddress'=>$ip);

		$new_process_id=15;

		$data_update = array('status'=>0);    

		$data_insert=array(
		'vessel_id'=>$vessel_id,
		'survey_id'=>$survey_id,
		'process_id'=>$new_process_id,
		'current_status_id'=>1,
		'current_position'=>$pc_usertype_id,
		'user_id'=>$pc_user_id,
		'previous_module_id'=>$processflow_sl,
		'status'=>1,
		'status_change_date'=>$date);

		$data_survey_status = array(
		'process_id' => $new_process_id,
		'survey_id'=>$survey_id,
		'current_status_id' => 1,
		'sending_user_id' => $sess_usr_id,
		'receiving_user_id' => $pc_user_id);

		$data_main=array('processing_status'=>1);   

		if($amount>0 && $portofregistry_sl!=false)
		{
			$process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);

			$result_insert  = $this->db->insert('tbl_kiv_payment_details', $data_payment); 
			$process_update = $this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
			$process_insert = $this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
			$status_update = $this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
		}		
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
		/*____________________________________processflow end____________________________________*/
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	 => $order_status);

		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}
//____________________________________Annual survey Form 1 payment END_____________________________//

//_____________________________________Registration of vessel Start_______________________________//

public function hdfc_request_registration()
{
	$this->load->view('Kiv_views/Hdfc/ccavRequestandler_registration');
}

public function hdfc_response_registration()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';

	$encResponse 	=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 		= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server

	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	//print_r($get_transaction_request);
	if(!empty($get_transaction_request))
	{
		$vessel_id=$get_transaction_request[0]['vessel_id'];
		$survey_id=$get_transaction_request[0]['survey_id'];
		$form_number=$get_transaction_request[0]['form_number'];
		$sess_usr_id=$get_transaction_request[0]['customer_registration_id'];

		$bank_id=$get_transaction_request[0]['bank_id'];
		$portofregistry_sl=$get_transaction_request[0]['port_id'];
		$hdfc_workingkey 			=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   	= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey=$hdfc_workingkey[0]['working_key'];
		}
	}

	$rcvdString 	=	decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	$res_array=array();

	foreach($decryptValues as $vals)
	{
		$explode_arr	=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id		=	$res_array['0'];
	$tracking_id	=	$res_array['1'];
	$bank_ref_no	=	$res_array['2'];
	$order_status	=	$res_array['3'];
	$failure_message=	$res_array['4'];
	$payment_mode	=	$res_array['5'];
	$card_name		=	$res_array['6'];
	$status_code	=	$res_array['7'];
	$status_message	=	$res_array['8'];
	$currency		=	$res_array['9'];
	$amount			=	intval($res_array['10']);
	$custregid		=	$res_array['26'];
	$transid		=	$res_array['27'];
	$custname		=	$res_array['11'];
	$custphoneno	=	$res_array['17'];
	$custemailid	=	$res_array['18'];
	$response_code	=	$res_array['38'];
	$trans_date		=	$res_array['40'];
	$bank_transaction_id=$res_array['28'];

	$banktransdata  			=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   	= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 		=	$banktransdata[0]['token_no'];
		$table_amount 			=	$banktransdata[0]['transaction_amount'];
		$transaction_id 		=	$banktransdata[0]['transaction_id'];
		$survey_id 				=	$banktransdata[0]['survey_id'];
	}

	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
	}
	else
	{
		$payment_status=2;
	}

	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}

	$responds_data=array('tokenno'=>$tokenno_id, 
	'tracking_id'=>$tracking_id,
	'bank_ref_no'=>$bank_ref_no,
	'order_status'=>$order_status,
	'failure_message'=>$failure_message,
	'payment_mode'=>$payment_mode,
	'cardname'=>$card_name,
	'status_code'=>$status_code,
	'status_message'=>$status_message,
	'currency'=>$currency, 
	'amount'=>$amount, 
	'customer_registration_id'=>$custregid,
	'customer_name'=>$custname,
	'customer_tel'=>$custphoneno,
	'customer_emailid'=>$custemailid, 
	'response_code'=>$response_code,
	'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));


	$insert_transaction_reg	 		=	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 						=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));


	/*________________GET reference number start-registration___________________*/
	date_default_timezone_set("Asia/Kolkata");
	$date         =   date('Y-m-d h:i:s', time());
	$ref_process_id=5;
	$ref_number_details 		=   $this->Survey_model->get_ref_number_details($vessel_id,$ref_process_id);
	$data['ref_number_details'] =   $ref_number_details;

	if(!empty($ref_number_details))
	{
		$ref_id 				= $ref_number_details[0]['ref_id'];
		$data_ref_number 		= array('payment_status' => $payment_status, 'payment_date'=>$date);
		$update_ref_number    = 	$this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);
	}
	/*________________GET reference number end-registration___________________*/
	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");

		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		/*__________________________________Processflow start_____________________________________*/

		date_default_timezone_set("Asia/Kolkata");
		$ip	      	=	$_SERVER['REMOTE_ADDR'];
		$date 	   	= 	date('Y-m-d h:i:s', time());
		$newDate    = 	date("Y-m-d");
		$status_change_date=date('Y-m-d h:i:s', time());
		$status=1;
		$status_details       	=   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  = $status_details;
		if(!empty($status_details))
		{
			$status_details_sl       = 	$status_details[0]['status_details_sl'];
		}
		$processflow_vessel       	=   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  = $processflow_vessel;
		if(!empty($processflow_vessel))
		{
			$processflow_sl       = 	$processflow_vessel[0]['processflow_sl'];
			$process_id = 	$processflow_vessel[0]['process_id'];
		}

		$data_portofregistry = 	array(
		'vessel_registry_port_id' => $portofregistry_sl);
		$update_portofregistry		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);

		$port_registry_user_id        =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;

		if(!empty($port_registry_user_id))
		{
			$pc_user_id 					=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 				=	$port_registry_user_id[0]['user_master_id_user_type'];
		}

		$data_payment=array(
		'vessel_id'=>$vessel_id,
		'survey_id'=>5,
		'form_number'=>$form_number,
		'paymenttype_id'=>$paymenttype_id,
		'dd_amount'=>$amount,
		'dd_date'=>$newDate,
		'portofregistry_id'=>$portofregistry_sl,
		'bank_id'=>$bank_id,
		'payment_mode'=>$payment_mode,
		'transaction_id'=>$bank_transaction_id,
		'payment_created_user_id'=>$sess_usr_id,
		'payment_created_timestamp'=>$date,
		'payment_created_ipaddress'=>$ip);
		if($process_id==14)
		{
			$data_insert=array(
			'vessel_id'=>$vessel_id,
			'process_id'=>$process_id,
			'survey_id'=>$survey_id,
			'current_status_id'=>2,
			'current_position'=>$pc_usertype_id,
			'user_id'=>$pc_user_id,
			'previous_module_id'=>$processflow_sl,
			'status'=>$status,
			'status_change_date'=>$status_change_date);
			$data_update = array('status'=>0);
			$data_survey_status=array(
			'survey_id'=>$survey_id,
			'current_status_id'=>2,
			'sending_user_id'=>$sess_usr_id,
			'receiving_user_id'=>$pc_user_id);
			$data_main=array('processing_status'=>1);   
			$result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment);	
			$process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
			$process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
			$status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
			$process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);
		}
		/*if( $process_update_main && $result_insert && $process_update && $process_insert  && $status_update)
		{
		}
		*/			
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
		/*____________________________________processflow end____________________________________*/
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	 => $order_status);
		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}

//___________________________________Registration of vessel END______________________________________//

//______________________________Renewal of registration certificate Start____________________________//

public function hdfc_request_renewalcertificate()
{
	$this->load->view('Kiv_views/Hdfc/ccavRequestandler_renewalcertificate');
}

public function hdfc_response_renewalcertificate()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	$encResponse 	=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 		= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server
	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	if(!empty($get_transaction_request))
	{
		$vessel_id=$get_transaction_request[0]['vessel_id'];
		$survey_id=$get_transaction_request[0]['survey_id'];
		$form_number=$get_transaction_request[0]['form_number'];
		$sess_usr_id=$get_transaction_request[0]['customer_registration_id'];
		$bank_id=$get_transaction_request[0]['bank_id'];
		$portofregistry_sl=$get_transaction_request[0]['port_id'];
		$hdfc_workingkey 			=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   	= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey=$hdfc_workingkey[0]['working_key'];
		}
	}

	$rcvdString =decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	$res_array=array();
	foreach($decryptValues as $vals)
	{
		$explode_arr	=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id		=	$res_array['0'];
	$tracking_id	=	$res_array['1'];
	$bank_ref_no	=	$res_array['2'];
	$order_status	=	$res_array['3'];
	$failure_message=	$res_array['4'];
	$payment_mode	=	$res_array['5'];
	$card_name		=	$res_array['6'];
	$status_code	=	$res_array['7'];
	$status_message	=	$res_array['8'];
	$currency		=	$res_array['9'];
	$amount			=	intval($res_array['10']);
	$custregid		=	$res_array['26'];
	$transid		=	$res_array['27'];
	$custname		=	$res_array['11'];
	$custphoneno	=	$res_array['17'];
	$custemailid	=	$res_array['18'];
	$response_code	=	$res_array['38'];
	$trans_date		=	$res_array['40'];
	$bank_transaction_id=$res_array['28'];
	$banktransdata  			=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   	= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 		=	$banktransdata[0]['token_no'];
		$table_amount 			=	$banktransdata[0]['transaction_amount'];
		$transaction_id 		=	$banktransdata[0]['transaction_id'];
		$survey_id 				=	$banktransdata[0]['survey_id'];
	}

	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
	}
	else
	{
		$payment_status=2;
	}


	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}

	$responds_data=array('tokenno'=>$tokenno_id, 
	'tracking_id'=>$tracking_id,
	'bank_ref_no'=>$bank_ref_no,
	'order_status'=>$order_status,
	'failure_message'=>$failure_message,
	'payment_mode'=>$payment_mode,
	'cardname'=>$card_name,
	'status_code'=>$status_code,
	'status_message'=>$status_message,
	'currency'=>$currency, 
	'amount'=>$amount, 
	'customer_registration_id'=>$custregid,
	'customer_name'=>$custname,
	'customer_tel'=>$custphoneno,
	'customer_emailid'=>$custemailid, 
	'response_code'=>$response_code,
	'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));


	$insert_transaction_reg	 		=	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 						=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));

	/*________________GET reference number start-renewal of registration certificate___________________*/
	date_default_timezone_set("Asia/Kolkata");
	$date         =   date('Y-m-d h:i:s', time());
	$process_id=10;
	$ref_number_details 		=   $this->Survey_model->get_ref_number_details($vessel_id,$process_id);
	$data['ref_number_details'] =   $ref_number_details;

	if(!empty($ref_number_details))
	{
		$ref_id 				= $ref_number_details[0]['ref_id'];
		$data_ref_number 		= array('payment_status' => $payment_status, 'payment_date'=>$date);
	}
	$update_ref_number    = 	$this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);
	/*________________GET reference number end-renewal of registration certificate___________________*/
	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		/*__________________________________Processflow start_____________________________________*/

		date_default_timezone_set("Asia/Kolkata");
		$ip	      	=	$_SERVER['REMOTE_ADDR'];
		$date 	   	= 	date('Y-m-d h:i:s', time());
		$newDate    = 	date("Y-m-d");
		$status_change_date=date('Y-m-d h:i:s', time());
		$status=1;
		$status_details       	=   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  = $status_details;
		if(!empty($status_details))
		{
			$status_details_sl       = 	$status_details[0]['status_details_sl'];
		}
		$processflow_vessel       	=   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  = $processflow_vessel;
		if(!empty($processflow_vessel))
		{
			$processflow_sl       = 	$processflow_vessel[0]['processflow_sl'];
			$process_id = 	42;
		}

		$data_portofregistry = 	array(
		'vessel_registry_port_id' => $portofregistry_sl	);
		$update_portofregistry		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);
		$port_registry_user_id           =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;

		if(!empty($port_registry_user_id))
		{
			$pc_user_id 					=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 				=	$port_registry_user_id[0]['user_master_id_user_type'];
		}
		/*______________________update tbl_registration_renewal start______________________*/
		$data_renewal=array('registration_renewal_payment_date'=>$newDate,'payment_status'=>$payment_status);
		$registration_renewal           =   $this->Survey_model->get_registration_renewal($vessel_id);
		$data['registration_renewal']  =   $registration_renewal;
		if(!empty($registration_renewal))
		{
			$registration_renewal_sl=$registration_renewal[0]['registration_renewal_sl'];
			$update_reg_renewal   = $this->Survey_model->update_tables('tbl_registration_renewal',$data_renewal,'registration_renewal_sl',$registration_renewal_sl);
		}
		/*______________________update end______________________*/
		$data_payment=array(
		'vessel_id'=>$vessel_id,
		'survey_id'=>10,
		'form_number'=>$form_number,
		'paymenttype_id'=>$paymenttype_id,
		'dd_amount'=>$amount,
		'dd_date'=>$newDate,
		'portofregistry_id'=>$portofregistry_sl,
		'bank_id'=>$bank_id,
		'payment_mode'=>$payment_mode,
		'transaction_id'=>$bank_transaction_id,
		'payment_created_user_id'=>$sess_usr_id,
		'payment_created_timestamp'=>$date,
		'payment_created_ipaddress'=>$ip);
		if($process_id==42)
		{
			$data_insert=array(
			'vessel_id'=>$vessel_id,
			'process_id'=>$process_id,
			'survey_id'=>$survey_id,
			'current_status_id'=>2,
			'current_position'=>$pc_usertype_id,
			'user_id'=>$pc_user_id,
			'previous_module_id'=>$processflow_sl,
			'status'=>$status,
			'status_change_date'=>$status_change_date);


			$data_update = array('status'=>0);

			$data_survey_status=array(
			'process_id'=>$process_id,
			'survey_id'=>$survey_id,
			'current_status_id'=>2,
			'sending_user_id'=>$sess_usr_id,
			'receiving_user_id'=>$pc_user_id);


			$data_main=array('processing_status'=>1,
			'vesselmain_insurance_id'=>$vessel_insurance_sl_new,
			'vesselmain_insurance_date'=>$newDate,
			'vesselmain_insurance_status'=>1);   

			if($amount>0 && $portofregistry_sl!=false)
			{
				$result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment);	
				$process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);
				$process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
				$process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
				$status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
			}
		}
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
		/*____________________________________processflow end____________________________________*/
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	 => $order_status);
		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}

}

//____________________________Renewal of registration certificate END________________________________//

//__________________________________Drydock survey Start______________________________________//

public function hdfc_request_drydocksurvey()
{
	$this->load->view('Kiv_views/Hdfc/ccavRequestandler_drydocksurvey');
}

public function hdfc_response_drydocksurvey()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	$encResponse 	=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 		= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server

	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	if(!empty($get_transaction_request))
	{
		$vessel_id=$get_transaction_request[0]['vessel_id'];
		$survey_id=$get_transaction_request[0]['survey_id'];
		$form_number=$get_transaction_request[0]['form_number'];
		$sess_usr_id=$get_transaction_request[0]['customer_registration_id'];
		$bank_id=$get_transaction_request[0]['bank_id'];
		$portofregistry_sl=$get_transaction_request[0]['port_id'];

		$hdfc_workingkey 			=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   	= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey=$hdfc_workingkey[0]['working_key'];
		}
	}
	//get vessel name
	$vessel=$this->Survey_model->get_vessel($vessel_id);
	$data['vessel']=$vessel;
	if(!empty($vessel))
	{
		$vessel_name=$vessel[0]['vessel_name'];
	}
	else
	{
		$vessel_name="";
	}
	//get port of registry name
	$registry_port_id             =   $this->Survey_model->get_registry_port_id($portofregistry_sl);
	$data['registry_port_id']     =   $registry_port_id;

	if(!empty($registry_port_id))
	{
		$port_of_registry_name=$registry_port_id[0]['vchr_portoffice_name'];
	}
	else
	{
		$port_of_registry_name="";
	}

	$rcvdString 	=	decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	$res_array=array();

	foreach($decryptValues as $vals)
	{
		$explode_arr	=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id		=	$res_array['0'];
	$tracking_id	=	$res_array['1'];
	$bank_ref_no	=	$res_array['2'];
	$order_status	=	$res_array['3'];
	$failure_message=	$res_array['4'];
	$payment_mode	=	$res_array['5'];
	$card_name		=	$res_array['6'];
	$status_code	=	$res_array['7'];
	$status_message	=	$res_array['8'];
	$currency		=	$res_array['9'];
	$amount			=	intval($res_array['10']);
	$custregid		=	$res_array['26'];
	$transid		=	$res_array['27'];
	$custname		=	$res_array['11'];
	$custphoneno	=	$res_array['17'];
	$custemailid	=	$res_array['18'];
	$response_code	=	$res_array['38'];
	$trans_date		=	$res_array['40'];
	$bank_transaction_id=$res_array['28'];


	$banktransdata  			=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   	= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 		=	$banktransdata[0]['token_no'];
		$table_amount 			=	$banktransdata[0]['transaction_amount'];
		$transaction_id 		=	$banktransdata[0]['transaction_id'];
		$survey_id 				=	$banktransdata[0]['survey_id'];
	}
	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
	}
	else
	{
		$payment_status=2;
	}

	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}
	$responds_data=array('tokenno'=>$tokenno_id, 
	'tracking_id'=>$tracking_id,
	'bank_ref_no'=>$bank_ref_no,
	'order_status'=>$order_status,
	'failure_message'=>$failure_message,
	'payment_mode'=>$payment_mode,
	'cardname'=>$card_name,
	'status_code'=>$status_code,
	'status_message'=>$status_message,
	'currency'=>$currency, 
	'amount'=>$amount, 
	'customer_registration_id'=>$custregid,
	'customer_name'=>$custname,
	'customer_tel'=>$custphoneno,
	'customer_emailid'=>$custemailid, 
	'response_code'=>$response_code,
	'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));

	$insert_transaction_reg	 		=	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 						=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));

	/*________________GET reference number start-drydock survey___________________*/
	date_default_timezone_set("Asia/Kolkata");
	$date         =   date('Y-m-d h:i:s', time());
	$process_id=3;
	$ref_number_details 		=   $this->Survey_model->get_ref_number_details($vessel_id,$process_id);
	$data['ref_number_details'] =   $ref_number_details;

	if(!empty($ref_number_details))
	{
		$ref_id 				= $ref_number_details[0]['ref_id'];
		$ref_number 			= $ref_number_details[0]['ref_number'];
		$data_ref_number 		= array('payment_status' => $payment_status, 'payment_date'=>$date);
	}
	$update_ref_number    = 	$this->Survey_model->update_kiv_reference_number('tbl_kiv_reference_number',$data_ref_number, $ref_id);
	/*________________GET reference number end-drydock survey___________________*/

	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");

		$data_n = array(
		'token'   	=> $tokenno_id,
		'bank_ref'	 =>	$bank_ref_no,
		'name'	 	 => $custname,
		'amount'	 => $amount,
		'mobileno'	 => $custphoneno,
		'email'	 	 => $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		/*__________________________________Processflow start_____________________________________*/
		date_default_timezone_set("Asia/Kolkata");
		$ip	      	=	$_SERVER['REMOTE_ADDR'];
		$date 	   	= 	date('Y-m-d h:i:s', time());
		$newDate    = 	date("Y-m-d");
		$status_change_date=date('Y-m-d h:i:s', time());
		$status=1;
		$status_details       	=   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  = $status_details;
		if(!empty($status_details))
		{
			$status_details_sl       = 	$status_details[0]['status_details_sl'];
		}
		$processflow_vessel       	=   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  = $processflow_vessel;
		if(!empty($processflow_vessel))
		{
			$processflow_sl       = 	$processflow_vessel[0]['processflow_sl'];
		}
		$data_portofregistry = 	array(
		'vessel_registry_port_id' => $portofregistry_sl);
		$update_portofregistry		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);
		$port_registry_user_id        =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;

		if(!empty($port_registry_user_id))
		{
			$pc_user_id 					=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 				=	$port_registry_user_id[0]['user_master_id_user_type'];
		}
		$data_payment=array(
		'vessel_id'=>$vessel_id,
		'survey_id'=>$survey_id,
		'form_number'=>$form_number,
		'paymenttype_id'=>$paymenttype_id,
		'dd_amount'=>$amount,
		'dd_date'=>$newDate,
		'portofregistry_id'=>$portofregistry_sl,
		'bank_id'=>$bank_id,
		'payment_mode'=>$payment_mode,
		'transaction_id'=>$bank_transaction_id,
		'payment_created_user_id'=>$sess_usr_id,
		'payment_created_timestamp'=>$date,
		'payment_created_ipaddress'=>$ip);
		$new_process_id=26;
		$data_update = array('status'=>0);    

		$data_insert=array(
		'vessel_id'=>$vessel_id,
		'survey_id'=>$survey_id,
		'process_id'=>$new_process_id,
		'current_status_id'=>1,
		'current_position'=>$pc_usertype_id,
		'user_id'=>$pc_user_id,
		'previous_module_id'=>$processflow_sl,
		'status'=>1,
		'status_change_date'=>$date);

		$data_survey_status = array(
		'process_id' => $new_process_id,
		'survey_id'=>$survey_id,
		'current_status_id' => 1,
		'sending_user_id' => $sess_usr_id,
		'receiving_user_id' => $pc_user_id);
		$result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment);	
		$data_main=array('processing_status'=>1);   
		//_____________________________Email sending start_____________________________//
		$email_subject="Drydock survey registration of ".$vessel_name." completed";
		$email_message="<div><h4>Dear ". $custname.",</h4><p>Your vessel, <b>".$vessel_name."</b> has successfully completed Drydock survey registration. This form has been forwarded to <b>".$port_of_registry_name." </b> Port Conservator. On verification of the payment, drydock survey activities will be initiated by concerned authority. <br>Please note the reference number : <b>".$ref_number."</b> for future reference with respect to Initial survey. This reference number will be until Drydock Survey Certificate is generated.  <br>Please check your inbox regularly at portinfo.kerala.gov.in, using your login credentials to know the  current status of the vessel.  <br>For any queries or compaints contact <b>".$port_of_registry_name." </b>Port of Registry. <br> <br>Warm Regards <br><br>Kerala Maritime Board <br></p><hr>
		</div>";
		$saji_email="bssajitha@gmail.com";
		$this->emailSendFunction($saji_email,$email_subject,$email_message);
		//$this->emailSendFunction($custemailid,$email_subject,$email_message);
		//___________________Email sending start___________________________________________//
		//____________________SMS sending start____________________________________________//
		$sms_message="Drydock survey registration of ".$vessel_name." completed. Reference number is ".$ref_number.".";
		$this->load->model('Kiv_models/Survey_model');
		$saji_mob="9847903241";
      	//$stat = $this->Survey_model->sendSms($sms_message,$saji_mob);
		//$stat = $this->Survey_model->sendSms($sms_message,$custphoneno);
		//____________________SMS sending end________________________________________________//

		if($amount>0 && $portofregistry_sl!=false)
		{
			$process_update_main=$this->Survey_model->update_vessel_main('tb_vessel_main',$data_main, $vessel_id);
			$process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
			$process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);
			$status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
		}
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	/*____________________________________processflow end____________________________________*/
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   		=> $tokenno_id,
		'bank_ref'	 	=> $bank_ref_no,
		'name'	 	 	=> $custname,
		'amount'	 	=> $amount,
		'mobileno'	 	=> $custphoneno,
		'email'	 	 	=> $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}
//___________________________________Drydock survey END______________________________________//

//________________________________Owner Change (Start)_______________________________________//
public function Hdfc_ownrequest()
{
	$this->load->view('Kiv_views/Hdfc/ccavownRequestHandler');
}
public function Hdfc_ownresponse()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	//$workingKey 	=	'300C3755D3DCDF6B2E84AF39F934B67C';
	$encResponse 						=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 							= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server
	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	//print_r($get_transaction_request);
	//exit;
	if(!empty($get_transaction_request))
	{
		$vessel_id 						=	$get_transaction_request[0]['vessel_id'];
		$survey_id 						=	$get_transaction_request[0]['survey_id'];
		$form_number 					=   $get_transaction_request[0]['form_number'];
		$sess_usr_id					=	$get_transaction_request[0]['customer_registration_id'];
		$bank_id 						=	$get_transaction_request[0]['bank_id'];
		$portofregistry_sl 				= 	$get_transaction_request[0]['port_id'];
		$hdfc_workingkey 				=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   		= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey 				= 	$hdfc_workingkey[0]['working_key'];
		}
	}

	$rcvdString 						=	decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status 						=	"";
	$decryptValues 						=	explode('&', $rcvdString);
	$dataSize 							=	sizeof($decryptValues);
	$res_array 							=	array();
	foreach($decryptValues as $vals)
	{
		$explode_arr					=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id							=	$res_array['0'];
	$tracking_id						=	$res_array['1'];
	$bank_ref_no						=	$res_array['2'];
	$order_status						=	$res_array['3'];
	$failure_message					=	$res_array['4'];
	$payment_mode						=	$res_array['5'];
	$card_name							=	$res_array['6'];
	$status_code						=	$res_array['7'];
	$status_message						=	$res_array['8'];
	$currency							=	$res_array['9'];
	$amount								=	intval($res_array['10']);
	$custregid							=	$res_array['26'];
	$transid							=	$res_array['27'];
	$custname							=	$res_array['11'];
	$custphoneno						=	$res_array['17'];
	$custemailid						=	$res_array['18'];
	$response_code						=	$res_array['38'];
	$trans_date							=	$res_array['40'];
	$bank_transaction_id 				=	$res_array['28'];
	/*$rrestoken 		=	$this->db->query("SELECT * FROM kiv_bank_transaction_request WHERE bank_transaction_id='$transid'");
	$banktransdata 	=	$rrestoken->result_array();*/
	$banktransdata  					=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   			= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 				=	$banktransdata[0]['token_no'];
		$table_amount 					=	$banktransdata[0]['transaction_amount'];
		$transaction_id 				=	$banktransdata[0]['transaction_id'];
	}
	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
		//$order_status='Success';
	}
	else
	{
	$payment_status=2;
	//$order_status='Invalid';
	}

	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}

	$responds_data=array(
	'tokenno'						=>	$tokenno_id, 
	'tracking_id'					=>	$tracking_id,
	'bank_ref_no'					=>	$bank_ref_no,
	'order_status'					=>	$order_status,
	'failure_message'				=>	$failure_message,
	'payment_mode'					=>	$payment_mode,
	'cardname'						=>	$card_name,
	'status_code'					=>	$status_code,
	'status_message'				=>	$status_message,
	'currency'						=>	$currency, 
	'amount'						=>	$amount, 
	'customer_registration_id'		=>	$custregid,
	'customer_name'					=>	$custname,
	'customer_tel'					=>	$custphoneno,
	'customer_emailid'				=>	$custemailid, 
	'response_code'					=>	$response_code,
	'transaction_date'				=>	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));

	$insert_transaction_reg	 =	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 				=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));

	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");
		$data_n = array(
		'token'   						=> 	$tokenno_id,
		'bank_ref'	 					=>	$bank_ref_no,
		'name'	 	 					=> 	$custname,
		'amount'	 					=> 	$amount,
		'mobileno'	 					=> 	$custphoneno,
		'email'	 	 					=> 	$custemailid,
		'order_status'					=> 	$order_status);
		$data['saveddata']				=	$data_n;

		/*__________________________________Processflow start_____________________________________*/

		date_default_timezone_set("Asia/Kolkata");
		$ip	      						=	$_SERVER['REMOTE_ADDR'];
		$date 	   						= 	date('Y-m-d h:i:s', time());
		$newDate    					= 	date("Y-m-d");

		$vessel_main                    = $this->Vessel_change_model->get_vessel_main($vessel_id);
		$data['vessel_main']            = $vessel_main;
		if(!empty($vessel_main))
		{
			$vesselmain_sl                = $vessel_main[0]['vesselmain_sl'];
		}

		$status_details       			=   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  		= 	$status_details;
		if(!empty($status_details))
		{
			$status_details_sl       	= 	$status_details[0]['status_details_sl'];
		}

		$processflow_vessel       		=   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  	= 	$processflow_vessel;
		if(!empty($processflow_vessel))
		{
			$processflow_sl       		= 	$processflow_vessel[0]['processflow_sl'];
			$process_id 				= 	$processflow_vessel[0]['process_id'];
		}

		/*$data_portofregistry=array(
		'vessel_registry_port_id' 		=> $portofregistry_sl
		);
		$update_portofregistry				=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);*/

		$port_registry_user_id          =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;
		if(!empty($port_registry_user_id))
		{
			$pc_user_id 					=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 				=	$port_registry_user_id[0]['user_master_id_user_type'];
		}

		$data_payment=array(
		'vessel_id'					=>	$vessel_id,
		//'survey_id'					=>	$survey_id,
		'survey_id'					=>	7,
		'form_number'					=>	$form_number,
		'paymenttype_id'				=>	$paymenttype_id,
		'dd_amount'					=>	$amount,
		'dd_date'						=>	$newDate,
		'portofregistry_id'			=>	$portofregistry_sl,
		'bank_id'						=>	$bank_id,
		'payment_mode'				=>	$payment_mode,
		'transaction_id'				=>	$bank_transaction_id,
		'payment_created_user_id'		=>	$sess_usr_id,
		'payment_created_timestamp'	=>	$date,
		'payment_created_ipaddress'	=>	$ip); //print_r($data_payment);exit;

		/*if($process_id==38)
		{*/
		/////process flow start indication---- tb_vessel_main processing_status to be changed as 1
		$data_mainupdate=array(
		'processing_status'			=>	1);
		///tbl_owner_change payment status
		$data_ownerchgupdate=array(
		'payment_status'      		=> 	1, 
		'transfer_payment_date' 	=> 	$newDate);
		/////insert to processflow table showing curre
		$data_insert=array(
		'vessel_id'         		=> 	$vessel_id,
		'process_id'        		=> 	39,
		'survey_id'         		=> 	$survey_id,
		'current_status_id' 		=> 	2,
		'current_position'  		=> 	$pc_usertype_id,
		'user_id'           		=> 	$pc_user_id,
		'previous_module_id'		=> 	$processflow_sl,
		'status'            		=>	1,
		'status_change_date'		=> 	$date); //print_r($data_insert);exit;

		//////update current process status=0
		$data_update=array(
		'status'					=>	0);

		//////update status details table
		$data_survey_status=array(
		'survey_id'        			=> 	$survey_id,
		'process_id'       			=> 	39,
		'current_status_id'			=> 	2,
		'sending_user_id'  			=> 	$sess_usr_id,
		'receiving_user_id'			=> 	$pc_user_id); 

		if($amount>0 && $portofregistry_sl!=false)
		{
			//echo "Amt".$amount."---Port".$portofregistry_sl."---Vesmain".$vesselmain_sl."---Vesid".$vessel_id."---Proce".$processflow_sl."---Stat".$status_details_sl;exit;
			$result_insert 				=	$this->db->insert('tbl_kiv_payment_details', $data_payment);
			$vesselmain_update 			=	$this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
			$ownerchg_update 			=	$this->Vessel_change_model->update_ownerchg_status('tbl_transfer_ownershipchange',$data_ownerchgupdate, $vessel_id);
			$process_update				=	$this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
			$process_insert 			=	$this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
			$status_update 				=	$this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
			//}
			if($vesselmain_update && $ownerchg_update && $process_update && $process_insert && $status_update && $result_insert)
			{
				///get user mail////
				$user_mail_id          	=   $this->Vessel_change_model->get_user_mailid($pc_user_id);
				if(!empty($user_mail_id))
				{
					foreach($user_mail_id as $mail_res)
					{
						$user_mail 		=	$mail_res['user_email'];
						$user_name 		=	$mail_res['user_name'];
						$user_mob 		=	$mail_res['user_mobile_number'];
					}
				}
				$own_refno          =   $this->Vessel_change_model->get_buyer_details($vessel_id);
				if(!empty($own_refno))
				{
					foreach($own_refno as $own_res)
					{
						$refno        = $own_res['ref_number'];
					}
				}
				/*------------code for send email starts---------------*/
				$config = Array(
				'protocol'        => 'smtp',
				'smtp_host'       => 'ssl://smtp.googlemail.com',
				'smtp_port'       => 465,
				'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
				'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
				'mailtype'        => 'html',
				'charset'         => 'iso-8859-1');//print_r($config);exit;

				$message = 'The Ownership Change Request (Ref. No:'.$refno.') for the Vessel has been sent by the Vessel Owner. Please Verify for further Processing.';
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from('kivportinfo@gmail.com'); // change it to yours
				//$this->email->to($user_mail);// change it to yours
				$this->email->to('deepthi.nh@gmail.com');

				$this->email->subject('Ownership Change of Vessel');
				$this->email->message($message);
				if($this->email->send())
				{ //echo "success";redirect("Bookofregistration/raHome");
				// <!------------code for send SMS starts--------------->
				$this->load->model('Kiv_models/Vessel_change_model');
				$mobil="9809119144";
				$stat = $this->Vessel_change_model->sendSms($message,$mobil);

				//print_r($stat);exit;
				//echo json_encode("success");
				//redirect("Bookofregistration/raHome");

				/*------------code for send SMS ends---------------*/
				}
				else
				{
					show_error($this->email->print_debugger());
				} 
			}
		}
		/*if($amount>0 && $portofregistry_sl!=false)
		{
		$result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment);	
		$updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
		$update_vesselmain    = $this->Survey_model->update_vessel_main('tb_vessel_main',$data_vessel_main,$vessel_id);
		$insert_process   		=	$this->Survey_model->insert_process_flow($data_process);
		$insert_data_status   	=	$this->Survey_model->insert_status_details('tbl_kiv_status_details',$data_status);
		}*/
		/*____________________________________processflow end____________________________________*/
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavownResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   		=> $tokenno_id,
		'bank_ref'	 	=> $bank_ref_no,
		'name'	 	 	=> $custname,
		'amount'	 	=> $amount,
		'mobileno'	 	=> $custphoneno,
		'email'	 	 	=> $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavownResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}
//_____________________________________________Owner Change (END)_____________________________________//

//_________________________________________Transfer Vessel (Start)___________________________________//
public function Hdfc_tnsfrrequest()
{
	$this->load->view('Kiv_views/Hdfc/ccavtnsfrRequestHandler');
}
public function Hdfc_tnsfrresponse()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	//$workingKey 	=	'300C3755D3DCDF6B2E84AF39F934B67C';
	$encResponse 						=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 							= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server

	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	//print_r($get_transaction_request);
	//exit;

	if(!empty($get_transaction_request))
	{
		$vessel_id 						=	$get_transaction_request[0]['vessel_id'];
		$survey_id 						=	$get_transaction_request[0]['survey_id'];
		$form_number 					=   $get_transaction_request[0]['form_number'];
		$sess_usr_id					=	$get_transaction_request[0]['customer_registration_id'];
		$bank_id 						=	$get_transaction_request[0]['bank_id'];
		$portofregistry_sl 				= 	$get_transaction_request[0]['port_id'];
		$hdfc_workingkey 				=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   		= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey 				= 	$hdfc_workingkey[0]['working_key'];
		}
	}
	$rcvdString 						=	decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status 						=	"";
	$decryptValues 						=	explode('&', $rcvdString);
	$dataSize 							=	sizeof($decryptValues);
	$res_array 							=	array();

	foreach($decryptValues as $vals)
	{
		$explode_arr					=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id							=	$res_array['0'];
	$tracking_id						=	$res_array['1'];
	$bank_ref_no						=	$res_array['2'];
	$order_status						=	$res_array['3'];
	$failure_message					=	$res_array['4'];
	$payment_mode						=	$res_array['5'];
	$card_name							=	$res_array['6'];
	$status_code						=	$res_array['7'];
	$status_message						=	$res_array['8'];
	$currency							=	$res_array['9'];
	$amount								=	intval($res_array['10']);
	$custregid							=	$res_array['26'];
	$transid							=	$res_array['27'];
	$custname							=	$res_array['11'];
	$custphoneno						=	$res_array['17'];
	$custemailid						=	$res_array['18'];
	$response_code						=	$res_array['38'];
	$trans_date							=	$res_array['40'];
	$bank_transaction_id 				=	$res_array['28'];


	$banktransdata  					=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   			= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 				=	$banktransdata[0]['token_no'];
		$table_amount 					=	$banktransdata[0]['transaction_amount'];
		$transaction_id 				=	$banktransdata[0]['transaction_id'];
	}

	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
		//$order_status='Success';
	}
	else
	{
		$payment_status=2;
		//$order_status='Invalid';
	}

	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}

	$responds_data=array(
	'tokenno'						=>	$tokenno_id, 
	'tracking_id'					=>	$tracking_id,
	'bank_ref_no'					=>	$bank_ref_no,
	'order_status'					=>	$order_status,
	'failure_message'				=>	$failure_message,
	'payment_mode'					=>	$payment_mode,
	'cardname'						=>	$card_name,
	'status_code'					=>	$status_code,
	'status_message'				=>	$status_message,
	'currency'						=>	$currency, 
	'amount'						=>	$amount, 
	'customer_registration_id'		=>	$custregid,
	'customer_name'					=>	$custname,
	'customer_tel'					=>	$custphoneno,
	'customer_emailid'				=>	$custemailid, 
	'response_code'					=>	$response_code,
	'transaction_date'				=>	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));


	$insert_transaction_reg	 =	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 				=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));

	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");
		$data_n = array(
		'token'   						=> 	$tokenno_id,
		'bank_ref'	 					=>	$bank_ref_no,
		'name'	 	 					=> 	$custname,
		'amount'	 					=> 	$amount,
		'mobileno'	 					=> 	$custphoneno,
		'email'	 	 					=> 	$custemailid,
		'order_status'					=> 	$order_status);
		$data['saveddata']				=	$data_n;
		/*__________________________________Processflow start_____________________________________*/
		date_default_timezone_set("Asia/Kolkata");
		$ip	      						=	$_SERVER['REMOTE_ADDR'];
		$date 	   						= 	date('Y-m-d h:i:s', time());
		$newDate    					= 	date("Y-m-d");

		$vessel_main                    = $this->Vessel_change_model->get_vessel_main($vessel_id);
		$data['vessel_main']            = $vessel_main;
		if(!empty($vessel_main))
		{
			$vesselmain_sl                = $vessel_main[0]['vesselmain_sl'];
		}

		$status_details       			=   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  		= 	$status_details;
		if(!empty($status_details))
		{
			$status_details_sl       	= 	$status_details[0]['status_details_sl'];
		}

		$processflow_vessel       		=   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  	= 	$processflow_vessel;
		if(!empty($processflow_vessel))
		{
			$processflow_sl       		= 	$processflow_vessel[0]['processflow_sl'];
			$process_id 				= 	$processflow_vessel[0]['process_id'];
		}

		$transfer_type         			=   $this->Vessel_change_model->get_transfervessel_type($vessel_id); //print_r($transfer_type);
		$data['transfer_type'] 			= $transfer_type;
		foreach ($transfer_type as $transtyp_res) 
		{
			$trans_typ          			= $transtyp_res['transfer_based_changetype'];
		}
		if($trans_typ!=0)
		{
			$activity_id                  = 8;
		} 
		elseif ($trans_typ==0) 
		{
			$activity_id                  = 12;
		}
		/*$data_portofregistry=array(
		'vessel_registry_port_id' 		=> $portofregistry_sl
		);
		$update_portofregistry				=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);*/

		$port_registry_user_id          =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;
		if(!empty($port_registry_user_id))
		{
			$pc_user_id 					=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 				=	$port_registry_user_id[0]['user_master_id_user_type'];
		}

		$data_payment=array(
		'vessel_id'					=>	$vessel_id,
		'survey_id'					=>	$activity_id,
		'form_number'					=>	$form_number,
		'paymenttype_id'				=>	$paymenttype_id,
		'dd_amount'					=>	$amount,
		'dd_date'						=>	$newDate,
		'portofregistry_id'			=>	$portofregistry_sl,
		'bank_id'						=>	$bank_id,
		'payment_mode'				=>	$payment_mode,
		'transaction_id'				=>	$bank_transaction_id,
		'payment_created_user_id'		=>	$sess_usr_id,
		'payment_created_timestamp'	=>	$date,
		'payment_created_ipaddress'	=>	$ip); //print_r($data_payment);exit;

		/*if($process_id==38)
		{*/
		/////process flow start indication---- tb_vessel_main processing_status to be changed as 1
		$data_mainupdate=array(
		'processing_status'			=>	1);
		///tbl_owner_change payment status
		$data_transupdate=array(
		'payment_status'      		=> 	1, 
		'transfer_payment_date' 	=> 	$newDate);

		/////insert to processflow table showing curre
		$data_insert=array(
		'vessel_id'         		=> 	$vessel_id,
		'process_id'        		=> 	40,
		'survey_id'         		=> 	$survey_id,
		'current_status_id' 		=> 	2,
		'current_position'  		=> 	$pc_usertype_id,
		'user_id'           		=> 	$pc_user_id,
		'previous_module_id'		=> 	$processflow_sl,
		'status'            		=>	1,
		'status_change_date'		=> 	$date); //print_r($data_insert);exit;

		//////update current process status=0
		$data_update=array(
		'status'					=>	0);

		//////update status details table
		$data_survey_status=array(
		'survey_id'        			=> 	$survey_id,
		'process_id'       			=> 	40,
		'current_status_id'			=> 	2,
		'sending_user_id'  			=> 	$sess_usr_id,
		'receiving_user_id'			=> 	$pc_user_id); 
		if($amount>0 && $portofregistry_sl!=false)
		{
			//echo "Amt".$amount."---Port".$portofregistry_sl."---Vesmain".$vesselmain_sl."---Vesid".$vessel_id."---Proce".$processflow_sl."---Stat".$status_details_sl;exit;
			$result_insert 				=	$this->db->insert('tbl_kiv_payment_details', $data_payment);
			$vesselmain_update 			=	$this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
			$transvsl_update            = $this->Vessel_change_model->update_transfervessel_status('tbl_transfer_ownershipchange',$data_transupdate, $vessel_id);
			$process_update				=	$this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
			$process_insert 			=	$this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
			$status_update 				=	$this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
			//}
			if($vesselmain_update && $transvsl_update && $process_update && $process_insert && $status_update && $result_insert)
			{
				///get user mail////
				$user_mail_id          	=   $this->Vessel_change_model->get_user_mailid($pc_user_id);
				if(!empty($user_mail_id))
				{
					foreach($user_mail_id as $mail_res)
					{
						$user_mail 		=	$mail_res['user_email'];
						$user_name 		=	$mail_res['user_name'];
						$user_mob 		=	$mail_res['user_mobile_number'];
					}
				}
				$tfr_refno          =   $this->Vessel_change_model->get_transfervessel_details($vessel_id);
				if(!empty($tfr_refno))
				{
					foreach($tfr_refno as $tfr_res)
					{
						$refno        = $tfr_res['ref_number'];
					}
				}
				/*------------code for send email starts---------------*/
				$config = Array(
				'protocol'        => 'smtp',
				'smtp_host'       => 'ssl://smtp.googlemail.com',
				'smtp_port'       => 465,
				'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
				'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
				'mailtype'        => 'html',
				'charset'         => 'iso-8859-1');//print_r($config);exit;

				$message = 'The Transfer Request (Ref. No:'.$refno.') for the Vessel has been sent by the Vessel Owner. Please Verify for further Processing.';
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from('kivportinfo@gmail.com'); // change it to yours
				//$this->email->to($user_mail);// change it to yours
				$this->email->to('deepthi.nh@gmail.com');

				$this->email->subject('Transfer of Vessel');
				$this->email->message($message);
				if($this->email->send())
				{ 
					//echo "success";redirect("Bookofregistration/raHome");
					// <!------------code for send SMS starts--------------->
					$this->load->model('Kiv_models/Vessel_change_model');
					$mobil="9809119144";
					$stat = $this->Vessel_change_model->sendSms($message,$mobil);
					//print_r($stat);exit;
					//echo json_encode("success");
					//redirect("Bookofregistration/raHome");
					/*------------code for send SMS ends---------------*/
				}
				else
				{
					show_error($this->email->print_debugger());
				} 
			}
		}
		/*if($amount>0 && $portofregistry_sl!=false)
		{
		$result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment);	
		$updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
		$update_vesselmain    = $this->Survey_model->update_vessel_main('tb_vessel_main',$data_vessel_main,$vessel_id);
		$insert_process   		=	$this->Survey_model->insert_process_flow($data_process);
		$insert_data_status   	=	$this->Survey_model->insert_status_details('tbl_kiv_status_details',$data_status);
		}*/
		/*____________________________________processflow end____________________________________*/
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavtnsfrResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   		=> $tokenno_id,
		'bank_ref'	 	=> $bank_ref_no,
		'name'	 	 	=> $custname,
		'amount'	 	=> $amount,
		'mobileno'	 	=> $custphoneno,
		'email'	 	 	=> $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavtnsfrResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}
//______________________________________Transfer Vessel (END)_______________________________________//

//__________________________________________Duplicate Certificate (Start)___________________________//
public function Hdfc_dupcertrequest()
{
	$this->load->view('Kiv_views/Hdfc/ccavdupcertRequestHandler');
}
public function Hdfc_dupcertresponse()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	//$workingKey 	=	'300C3755D3DCDF6B2E84AF39F934B67C';
	$encResponse 			=	$_POST["encResp"]; 	//This is the response sent by the CCAvenue Server
	$orderno 				= 	$_POST["orderNo"]; //This is the response sent by the CCAvenue Server
	$get_transaction_request  			=   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']   	= 	$get_transaction_request;
	if(!empty($get_transaction_request))
	{
		$vessel_id 						=	$get_transaction_request[0]['vessel_id'];
		$survey_id 						=	$get_transaction_request[0]['survey_id'];
		$form_number 					=   $get_transaction_request[0]['form_number'];
		$sess_usr_id					=	$get_transaction_request[0]['customer_registration_id'];
		$bank_id 						=	$get_transaction_request[0]['bank_id'];
		$portofregistry_sl 				= 	$get_transaction_request[0]['port_id'];
		$hdfc_workingkey 				=   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']   		= 	$hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey 				= 	$hdfc_workingkey[0]['working_key'];
		}
	}
	$rcvdString 						=	decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status 						=	"";
	$decryptValues 						=	explode('&', $rcvdString);
	$dataSize 							=	sizeof($decryptValues);
	$res_array 							=	array();
	foreach($decryptValues as $vals)
	{
		$explode_arr					=	explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id							=	$res_array['0'];
	$tracking_id						=	$res_array['1'];
	$bank_ref_no						=	$res_array['2'];
	$order_status						=	$res_array['3'];
	$failure_message					=	$res_array['4'];
	$payment_mode						=	$res_array['5'];
	$card_name							=	$res_array['6'];
	$status_code						=	$res_array['7'];
	$status_message						=	$res_array['8'];
	$currency							=	$res_array['9'];
	$amount								=	intval($res_array['10']);
	$custregid							=	$res_array['26'];
	$transid							=	$res_array['27'];
	$custname							=	$res_array['11'];
	$custphoneno						=	$res_array['17'];
	$custemailid						=	$res_array['18'];
	$response_code						=	$res_array['38'];
	$trans_date							=	$res_array['40'];
	$bank_transaction_id 				=	$res_array['28'];

	/*$rrestoken 		=	$this->db->query("SELECT * FROM kiv_bank_transaction_request WHERE bank_transaction_id='$transid'");
	$banktransdata 	=	$rrestoken->result_array();*/

	$banktransdata  					=   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']   			= 	$banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no 				=	$banktransdata[0]['token_no'];
		$table_amount 					=	$banktransdata[0]['transaction_amount'];
		$transaction_id 				=	$banktransdata[0]['transaction_id'];
	}

	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
		//$order_status='Success';
	}
	else
	{
		$payment_status=2;
		//$order_status='Invalid';
	}


	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}
	$responds_data=array(
	'tokenno'						=>	$tokenno_id, 
	'tracking_id'					=>	$tracking_id,
	'bank_ref_no'					=>	$bank_ref_no,
	'order_status'					=>	$order_status,
	'failure_message'				=>	$failure_message,
	'payment_mode'					=>	$payment_mode,
	'cardname'						=>	$card_name,
	'status_code'					=>	$status_code,
	'status_message'				=>	$status_message,
	'currency'						=>	$currency, 
	'amount'						=>	$amount, 
	'customer_registration_id'		=>	$custregid,
	'customer_name'					=>	$custname,
	'customer_tel'					=>	$custphoneno,
	'customer_emailid'				=>	$custemailid, 
	'response_code'					=>	$response_code,
	'transaction_date'				=>	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));
	$insert_transaction_reg	 	=	$this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate 					=	date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));

	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");
		$data_n = array(
		'token'   						=> 	$tokenno_id,
		'bank_ref'	 					=>	$bank_ref_no,
		'name'	 	 					=> 	$custname,
		'amount'	 					=> 	$amount,
		'mobileno'	 					=> 	$custphoneno,
		'email'	 	 					=> 	$custemailid,
		'order_status'					=> 	$order_status);
		$data['saveddata']				=	$data_n;
		/*__________________________________Processflow start_____________________________________*/
		date_default_timezone_set("Asia/Kolkata");
		$ip	      						=	$_SERVER['REMOTE_ADDR'];
		$date 	   						= 	date('Y-m-d h:i:s', time());
		$newDate    					= 	date("Y-m-d");

		$vessel_main                    = $this->Vessel_change_model->get_vessel_main($vessel_id);
		$data['vessel_main']            = $vessel_main;
		if(!empty($vessel_main))
		{
			$vesselmain_sl                = $vessel_main[0]['vesselmain_sl'];
		}
		$status_details       			=   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  		= 	$status_details;
		if(!empty($status_details))
		{
			$status_details_sl       	= 	$status_details[0]['status_details_sl'];
		}
		$processflow_vessel       		=   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  	= 	$processflow_vessel;
		if(!empty($processflow_vessel))
		{
			$processflow_sl       		= 	$processflow_vessel[0]['processflow_sl'];
			$process_id 				= 	$processflow_vessel[0]['process_id'];
		}
		/*$data_portofregistry=array(
		'vessel_registry_port_id' 		=> $portofregistry_sl
		);
		$update_portofregistry				=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);*/
		$port_registry_user_id        =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;
		if(!empty($port_registry_user_id))
		{
			$pc_user_id 					=	$port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id 				=	$port_registry_user_id[0]['user_master_id_user_type'];
		}
		$data_payment=array(
		'vessel_id'					=>	$vessel_id,
		'survey_id'					=>	9,
		'form_number'					=>	$form_number,
		'paymenttype_id'				=>	$paymenttype_id,
		'dd_amount'					=>	$amount,
		'dd_date'						=>	$newDate,
		'portofregistry_id'			=>	$portofregistry_sl,
		'bank_id'						=>	$bank_id,
		'payment_mode'				=>	$payment_mode,
		'transaction_id'				=>	$bank_transaction_id,
		'payment_created_user_id'		=>	$sess_usr_id,
		'payment_created_timestamp'	=>	$date,
		'payment_created_ipaddress'	=>	$ip); //print_r($data_payment);exit;

		/*if($process_id==38)
		{*/
		/////process flow start indication---- tb_vessel_main processing_status to be changed as 1
		$data_mainupdate=array(
		'processing_status'			=>	1);
		///tbl_owner_change payment status
		$data_dupcertupdate  = array(
		'duplicate_payment_status'    => 1, 
		'duplicate_cert_payment_date' => $newDate);//print_r($data_dupcertupdate);exit;

		/////insert to processflow table showing curre
		$data_insert=array(
		'vessel_id'         		=> 	$vessel_id,
		'process_id'        		=> 	41,
		'survey_id'         		=> 	$survey_id,
		'current_status_id' 		=> 	2,
		'current_position'  		=> 	$pc_usertype_id,
		'user_id'           		=> 	$pc_user_id,
		'previous_module_id'		=> 	$processflow_sl,
		'status'            		=>	1,
		'status_change_date'		=> 	$date); //print_r($data_insert);exit;

		//////update current process status=0
		$data_update=array(
		'status'					=>	0);

		//////update status details table
		$data_survey_status=array(
		'survey_id'        			=> 	$survey_id,
		'process_id'       			=> 	41,
		'current_status_id'			=> 	2,
		'sending_user_id'  			=> 	$sess_usr_id,
		'receiving_user_id'			=> 	$pc_user_id); 

		if($amount>0 && $portofregistry_sl!=false)
		{
			//echo "Amt".$amount."---Port".$portofregistry_sl."---Vesmain".$vesselmain_sl."---Vesid".$vessel_id."---Proce".$processflow_sl."---Stat".$status_details_sl;exit;
			$result_insert 				=	$this->db->insert('tbl_kiv_payment_details', $data_payment);
			$vesselmain_update 			=	$this->Vessel_change_model->update_vesselmain('tb_vessel_main',$data_mainupdate, $vesselmain_sl);
			$dupcertf_update   			= $this->Vessel_change_model->update_dupcert_status('tbl_duplicate_certificate',$data_dupcertupdate, $vessel_id);
			$process_update				=	$this->Vessel_change_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
			$process_insert 			=	$this->Vessel_change_model->insert_processflow('tbl_kiv_processflow', $data_insert);
			$status_update 				=	$this->Vessel_change_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
			//}
			if($vesselmain_update && $dupcertf_update && $process_update && $process_insert && $status_update && $result_insert)
			{
				///get user mail////
				$user_mail_id          	=   $this->Vessel_change_model->get_user_mailid($pc_user_id);
				if(!empty($user_mail_id))
				{
					foreach($user_mail_id as $mail_res)
					{
						$user_mail 		=	$mail_res['user_email'];
						$user_name 		=	$mail_res['user_name'];
						$user_mob 		=	$mail_res['user_mobile_number'];
					}
				}
				$dup_refno          =   $this->Vessel_change_model->getduplicatecert($vessel_id);
				if(!empty($dup_refno))
				{
					foreach($dup_refno as $dup_res)
					{
						$refno        = $dup_res['ref_number'];
					}
				}
				/*------------code for send email starts---------------*/
				$config = Array(
				'protocol'        => 'smtp',
				'smtp_host'       => 'ssl://smtp.googlemail.com',
				'smtp_port'       => 465,
				'smtp_user'       => 'kivportinfo@gmail.com', // change it to yours
				'smtp_pass'       => 'KivPortinfokerala123', // change it to yours
				'mailtype'        => 'html',
				'charset'         => 'iso-8859-1');//print_r($config);exit;

				$message = 'The Duplicate Certificate Request (Ref. No:'.$refno.') for the Vessel has been sent by the Vessel Owner. Please Verify for further Processing.';
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from('kivportinfo@gmail.com'); // change it to yours
				//$this->email->to($user_mail);// change it to yours
				$this->email->to('deepthi.nh@gmail.com');
				$this->email->subject('Duplicate Certificate');
				$this->email->message($message);
				if($this->email->send())
				{ 
					//echo "success";redirect("Bookofregistration/raHome");
					// <!------------code for send SMS starts--------------->
					$this->load->model('Kiv_models/Vessel_change_model');
					$mobil="9809119144";
					$stat = $this->Vessel_change_model->sendSms($message,$mobil);
					//print_r($stat);exit;
					//echo json_encode("success");
					//redirect("Bookofregistration/raHome");

					/*------------code for send SMS ends---------------*/
				}
				else
				{
					show_error($this->email->print_debugger());
				} 
			}
		}
		/*if($amount>0 && $portofregistry_sl!=false)
		{
		$result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment);	
		$updstatus_res		=	$this->Survey_model->update_form_stage_count($data_stage,$stage_sl);
		$update_vesselmain    = $this->Survey_model->update_vessel_main('tb_vessel_main',$data_vessel_main,$vessel_id);
		$insert_process   		=	$this->Survey_model->insert_process_flow($data_process);
		$insert_data_status   	=	$this->Survey_model->insert_status_details('tbl_kiv_status_details',$data_status);
		}*/
		/*____________________________________processflow end____________________________________*/
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavdupcertResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'   		=> $tokenno_id,
		'bank_ref'	 	=> $bank_ref_no,
		'name'	 	 	=> $custname,
		'amount'	 	=> $amount,
		'mobileno'	 	=> $custphoneno,
		'email'	 	 	=> $custemailid,
		'order_status'	=> $order_status);
		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavdupcertResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}
//__________________________Duplicate Certificate (END)__________________________________//

//_____________________________Additional payment start_______________________________//

public function Hdfc_additional_payment_request()
{
  $this->load->view('Kiv_views/Hdfc/ccavRequestHandler_additional_payment');
}

public function Hdfc_additional_payment_response()
{
	include_once APPPATH.'/third_party/hdfc/Crypto.php';
	//$workingKey   = '300C3755D3DCDF6B2E84AF39F934B67C';
	$encResponse  = $_POST["encResp"];  //This is the response sent by the CCAvenue Server
	$orderno    =   $_POST["orderNo"]; //This is the response sent by the CCAvenue Server

	$get_transaction_request        =   $this->Survey_model->get_transaction_request($orderno);
	$data['get_transaction_request']    =   $get_transaction_request;
	if(!empty($get_transaction_request))
	{
		$vessel_id=$get_transaction_request[0]['vessel_id'];
		$survey_id=$get_transaction_request[0]['survey_id'];
		$form_number=$get_transaction_request[0]['form_number'];
		$sess_usr_id=$get_transaction_request[0]['customer_registration_id'];


		$bank_id=$get_transaction_request[0]['bank_id'];
		$portofregistry_sl=$get_transaction_request[0]['port_id'];

		$hdfc_workingkey      =   $this->Survey_model->get_workingkey($portofregistry_sl,$bank_id);
		$data['hdfc_workingkey']    =   $hdfc_workingkey;
		if(!empty($hdfc_workingkey))
		{
			$workingKey=$hdfc_workingkey[0]['working_key'];
		}
	}
	
	$rcvdString = decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	$res_array=array();
	foreach($decryptValues as $vals)
	{
		$explode_arr  = explode('=',$vals);
		array_push($res_array,$explode_arr[1]);
	}
	$tokenno_id   = $res_array['0'];
	$tracking_id  = $res_array['1'];
	$bank_ref_no  = $res_array['2'];
	$order_status = $res_array['3'];
	$failure_message= $res_array['4'];
	$payment_mode = $res_array['5'];
	$card_name    = $res_array['6'];
	$status_code  = $res_array['7'];
	$status_message = $res_array['8'];
	$currency   = $res_array['9'];
	$amount     = intval($res_array['10']);
	$custregid    = $res_array['26'];
	$transid    = $res_array['27'];
	$custname   = $res_array['11'];
	$custphoneno  = $res_array['17'];
	$custemailid  = $res_array['18'];
	$response_code  = $res_array['38'];
	$trans_date   = $res_array['40'];
	$bank_transaction_id=$res_array['28'];
	//exit;
	$banktransdata        =   $this->Survey_model->get_bank_transaction_request($transid);
	$data['banktransdata']    =   $banktransdata;
	if(!empty($banktransdata))
	{
		$table_token_no     = $banktransdata[0]['token_no'];
		$table_amount       = $banktransdata[0]['transaction_amount'];
		$transaction_id     = $banktransdata[0]['transaction_id'];
	}
	if($table_token_no==$tokenno_id && $table_amount==$amount &&  $order_status=='Success')
	{
		$payment_status=1;
		//$order_status='Success';
	}
	else
	{
		$payment_status=2;
		//$order_status='Invalid';
	}
	if($order_status=='Success')
	{
		$payment_status=1;
	}
	else if($order_status=='Failure')
	{
		$payment_status=2;
	}
	else if($order_status=='Invalid')
	{
		$payment_status=4;
	}
	else
	{
		$payment_status=2;
	}
	$responds_data=array('tokenno'=>$tokenno_id, 
	'tracking_id'=>$tracking_id,
	'bank_ref_no'=>$bank_ref_no,
	'order_status'=>$order_status,
	'failure_message'=>$failure_message,
	'payment_mode'=>$payment_mode,
	'cardname'=>$card_name,
	'status_code'=>$status_code,
	'status_message'=>$status_message,
	'currency'=>$currency, 
	'amount'=>$amount, 
	'customer_registration_id'=>$custregid,
	'customer_name'=>$custname,
	'customer_tel'=>$custphoneno,
	'customer_emailid'=>$custemailid, 
	'response_code'=>$response_code,
	'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))));
	$insert_transaction_reg     = $this->db->insert('kiv_bank_online_banktransaction',$responds_data);
	$transdate            = date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));

	

	if($payment_status==1)
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',transaction_receivedtimestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_id='$bank_id',payment_mode='$payment_mode' WHERE token_no='$tokenno_id'");
		$data_n = array(
		'token'     => $tokenno_id,
		'bank_ref'   => $bank_ref_no,
		'name'     => $custname,
		'amount'   => $amount,
		'mobileno'   => $custphoneno,
		'email'    => $custemailid,
		'order_status'  => $order_status);
		$data['saveddata']=$data_n;
		/*__________________________________Processflow start_____________________________________*/
		date_default_timezone_set("Asia/Kolkata");
		$ip         = $_SERVER['REMOTE_ADDR'];
		$date       =   date('Y-m-d h:i:s', time());
		$newDate     =   date("Y-m-d");
		$status_change_date=date('Y-m-d h:i:s', time());
		$status=1;
		$status_details         =   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
		$data['status_details']  = $status_details;
		if(!empty($status_details))
		{
			$status_details_sl       =  $status_details[0]['status_details_sl'];
		}
		$processflow_vessel         =   $this->Survey_model->get_processflow_vessel($vessel_id);
		$data['processflow_vessel']  = $processflow_vessel;
		//print_r($processflow_vessel);
		//exit;
		if(!empty($processflow_vessel))
		{
			$processflow_sl       =   $processflow_vessel[0]['processflow_sl'];
			$process_id =   $processflow_vessel[0]['process_id'];
		}
		$data_portofregistry =  array(
		'vessel_registry_port_id' => $portofregistry_sl);
		$update_portofregistry    = $this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);
		$port_registry_user_id        =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
		$data['port_registry_user_id']  =   $port_registry_user_id;
		if(!empty($port_registry_user_id))
		{
			$pc_user_id           = $port_registry_user_id[0]['user_master_id'];
			$pc_usertype_id         = $port_registry_user_id[0]['user_master_id_user_type'];
		}
		$data_payment=array(
		'vessel_id'=>$vessel_id,
		'survey_id'=>$survey_id,
		'form_number'=>$form_number,
		'paymenttype_id'=>$paymenttype_id,
		'dd_amount'=>$amount,
		'dd_date'=>$newDate,
		'portofregistry_id'=>$portofregistry_sl,
		'bank_id'=>$bank_id,
		'payment_mode'=>$payment_mode,
		'transaction_id'=>$bank_transaction_id,
		'payment_created_user_id'=>$sess_usr_id,
		'payment_created_timestamp'=>$date,
		'payment_created_ipaddress'=>$ip);
		$data_insert=array(
		'vessel_id'=>$vessel_id,
		'process_id'=>$process_id,
		'survey_id'=>$survey_id,
		'current_status_id'=>2,
		'current_position'=>$pc_usertype_id,
		'user_id'=>$pc_user_id,
		'previous_module_id'=>$processflow_sl,
		'status'=>$status,
		'status_change_date'=>$status_change_date);
		$data_update = array('status'=>0);
		$data_survey_status=array(
		'process_id'=>$process_id,
		'current_status_id'=>2,
		'sending_user_id'=>$sess_usr_id,
		'receiving_user_id'=>$pc_user_id);

		$data_vessel_main= array('processing_status'=>1,
		'vesselmain_portofregistry_id' => $portofregistry_sl);
		$result_insert=$this->db->insert('tbl_kiv_payment_details', $data_payment);
		$update_vesselmain    = $this->Survey_model->update_vessel_main('tb_vessel_main',$data_vessel_main,$vessel_id);
		$process_update=$this->Survey_model->update_processflow('tbl_kiv_processflow',$data_update, $processflow_sl);
		$process_insert=$this->Survey_model->insert_processflow('tbl_kiv_processflow', $data_insert);

		$status_update=$this->Survey_model->update_status_details('tbl_kiv_status_details', $data_survey_status,$status_details_sl);
		
		/*____________________________________processflow end____________________________________*/
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
	else
	{
		$this->db->query("UPDATE kiv_bank_transaction_request SET bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' WHERE transaction_id='$transid'");
		$data_n = array(
		'token'     => $tokenno_id,
		'bank_ref'   => $bank_ref_no,
		'name'     => $custname,
		'amount'   => $amount,
		'mobileno'   => $custphoneno,
		'email'    => $custemailid,
		'order_status'   => $order_status);
		$data['saveddata']=$data_n;
		$this->load->view('Kiv_views/template/dash-header.php');
		$this->load->view('Kiv_views/template/nav-header.php');
		$this->load->view('Kiv_views/Hdfc/ccavResponseHandler',$data);
		$this->load->view('Kiv_views/template/dash-footer.php');
	}
}
//__________________________Additional payment end______________________________// 

/*__________________________ END OF Controller_________________________________*/   


}
/*__________________________ END OF Controller_________________________________*/  


	