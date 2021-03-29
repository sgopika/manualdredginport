<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hdfc_saji extends CI_Controller {

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

	public function emailSendFun($from,$to,$sub,$msg)
	{
		$config = Array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => 465,
		'smtp_user' => 'manualdredging@gmail.com',
		'smtp_pass' => 'Portkerala@123',
		'mailtype'  => 'html', 
		'charset'   => 'iso-8859-1'	);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from($from);
		$this->email->to($to); 
		$this->email->subject($sub);
		$this->email->message($msg); 
		$result = $this->email->send();
		$res=$this->email->print_debugger();
		return $result;
	}
	public function sendSms($message,$number)
	{
		$link = curl_init();
		curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=portsms2&password=portsms1234&message=".$message."&numbers=".$number."&senderid=PORTDR");
		curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($link , CURLOPT_HEADER, 0);
		$output = curl_exec($link);
		curl_close($link );
}
*/


//_______________________HDFC CONTROLLER______________________________________________________//

public function Hdfc_initialsurvey_form3_request()
{
	
	$this->load->view('Hdfc/ccavRequestHandler_initialsurvey_form3');
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


/*$rrestoken 		=	$this->db->query("SELECT * FROM kiv_bank_transaction_request WHERE bank_transaction_id='$transid'");
$banktransdata 	=	$rrestoken->result_array();*/

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
	'order_status'	=> $order_status
	);
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
  'vessel_registry_port_id' => $portofregistry_sl
  );
  $update_portofregistry		=	$this->Survey_model->update_tbl_vessel_details('tbl_kiv_vessel_details',$data_portofregistry,$vessel_id);



  $port_registry_user_id           =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
  $data['port_registry_user_id']  =   $port_registry_user_id;
  if(!empty($port_registry_user_id))
  {
    $pc_user_id=$port_registry_user_id[0]['user_sl'];
    $pc_usertype_id=$port_registry_user_id[0]['user_type_id'];
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
  'payment_created_ipaddress'=>$ip
  );


$data_insert=array(
'vessel_id'=>$vessel_id,
'process_id'=>$process_id,
'survey_id'=>$survey_id,
'current_status_id'=>2,
'current_position'=>$pc_usertype_id,
'user_id'=>$pc_user_id,
'previous_module_id'=>$processflow_sl,
'status'=>$status,
'status_change_date'=>$status_change_date
);


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


//}



  /*____________________________________processflow end____________________________________*/






	 $this->load->view('template/dash-header.php');
        $this->load->view('template/nav-header.php');
	$this->load->view('Hdfc/ccavResponseHandler_initialsurvey_form3',$data);
	 $this->load->view('template/dash-footer.php');
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
	'order_status'	 => $order_status
	);

	
	$data['saveddata']=$data_n;
	$this->load->view('template/dash-header.php');
     $this->load->view('template/nav-header.php');
	$this->load->view('Hdfc/ccavResponseHandler_initialsurvey_form3',$data);
	 $this->load->view('template/dash-footer.php');
}


}


   
  /*__________________________________________________ END OF Controller________________*/  
	
	}


	