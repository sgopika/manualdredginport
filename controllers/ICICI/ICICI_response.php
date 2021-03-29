<?php

defined('BASEPATH') OR exit('No direct script access allowed');    

class ICICI_response extends CI_Controller 

{



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

date_default_timezone_set("Asia/Kolkata");

$this->data = array(

'controller' => $this->router->fetch_class(),

'method' => $this->router->fetch_method(),

'session_userdata' => isset($this->session->userdata) ? $this->session->userdata : '',

'base_url' => base_url(),

'site_url'  	=> site_url(),

'int_userid' => isset($this->session->userdata['int_userid']) ? $this->session->userdata['int_userid'] : 0,

'int_district_id' => isset($this->session->userdata['int_district_id']) ? $this->session->userdata['int_district_id'] : 0

);

       $this->load->model('Master_model');

    }


//++++++++++++++++++++++++++++++++++++    Encrypt function-------++++++++++++++++++++++++++++++++++++++++++++
public  function aes128Encrypt($str,$key){
$block = mcrypt_get_block_size('rijndael_128', 'ecb');
$pad = $block - (strlen($str) % $block);
$str .= str_repeat(chr($pad), $pad);
return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB));
}

//++++++++++++++++++++++++++++++++++++    Encrypt function-------++++++++++++++++++++++++++++++++++++++++++++


public function emailSendFun($from,$to,$sub,$msg)

{

  $config = Array(

'protocol' => 'smtp',

'smtp_host' => 'ssl://smtp.googlemail.com',

'smtp_port' => 465,

'smtp_user' => 'manualdredging@gmail.com',

'smtp_pass' => 'Portkerala@123',

'mailtype'  => 'html', 

'charset'   => 'iso-8859-1'

);

$this->load->library('email', $config);

$this->email->set_newline("\r\n");



$this->email->from($from);

        $this->email->to($to); 

        $this->email->subject($sub);

        $this->email->message($msg); 



// Set to, from, message, etc.

$result = $this->email->send();

$res=$this->email->print_debugger();

        //$this->load->view('email_view'); 

//print_r($result);exit;

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
//======================================================================================================


public function payment_request()
{
print_r($_POST);exit();
$this->load->view('ccpay/ccavRequestHandler');
}
//=================================================================================================
/* -
-
- =================RESPONSE FUNCTIONS===================================================
-
-
-*/
//=================================================================================================

public function azhikkal()
{
//--AZHIKKAL PORT-------------------


//$sess_online_portid = $this->session->userdata('online_portid'); 

$merkey_data=$this->db->query("select * from online_payment_data where port_id=10 and payment_status=1 and bank_type_id=2");

$merkeydata=$merkey_data->result_array();
$workingKey=$merkeydata[0]['working_key'];


include_once APPPATH.'/third_party/hdfc/Crypto.php';

//$workingKey='00E9AE7E6982F8A49A69A92A835701C2';	//Working Key should be provided here.
$encResponse=$_POST["encResp"];	//This is the response sent by the CCAvenue Server
$rcvdString=decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.

$callback_data_json_file=$rcvdString.'---------------';
$file = fopen(__DIR__."/hdfc_callback.txt","a");
fwrite($file,$callback_data_json_file."\n\r");
fclose($file);
$order_status="";
$decryptValues=explode('&', $rcvdString);
$dataSize=sizeof($decryptValues);

$res_array=array();
foreach($decryptValues as $vals){
$explode_arr	=	explode('=',$vals);
array_push($res_array,$explode_arr[1]);
}

$tokenno_id	=	$res_array['0'];
$tracking_id	=	$res_array['1'];
$bank_ref_no	=	$res_array['2'];
$order_status	=	$res_array['3'];
$failure_message=	$res_array['4'];
$payment_mode	=	$res_array['5'];
$card_name	=	$res_array['6'];
$status_code	=	$res_array['7'];
$status_message	=	$res_array['8'];
$currency	=	$res_array['9'];
$amount	=	floatval($res_array['10']);
$custregid	=	$res_array['26'];
$transid	=	$res_array['27'];
$bookingstatus	=	$res_array['29'];  //** bookingstatus=1(normal booking)bookingstatus=2(spot booking)
$tokenno	=	$res_array['30'];
$custname	=	$res_array['11'];
$custphoneno	=	$res_array['17'];
$custemailid	=	$res_array['18'];
$response_code	=	$res_array['38'];
$trans_date	=	$res_array['40'];

$rrestoken=$this->db->query("select * from bank_transactionnw  where transaction_id='$transid'");


$banktransdata=$rrestoken->result_array();
$table_transid=$banktransdata[0]['transaction_id'];
$table_token_no=$banktransdata[0]['token_no'];
$table_amount=$banktransdata[0]['transaction_amount'];
$port_id=$banktransdata[0]['port_id'];
$zone_id=$banktransdata[0]['zone_id'];

if($table_transid==$tokenno_id && $table_amount==$amount && $order_status=='Success' )
{
   $payment_status=1;
//$order_status='Success';
}
else{
   $payment_status=2;
  // $order_status='Invalid';
}




if($order_status=='Success'){$payment_status=1;}

else if($order_status=='Failure'){$payment_status=2;}

else if($order_status=='Invalid'){$payment_status=4;}

else{$payment_status=2;}

$responds_data=array('tokenno'=>$tokenno, 
 'transactionid'=>$tokenno_id,
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
'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))),
'bookingstatus'=>$bookingstatus);

$insert_transaction_reg	=$this->db->insert('online_banktransaction',$responds_data);

$transdate=date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));
if($payment_status==1)
{
if($bookingstatus==2)
{

$res_spot=$this->db->query("select  * from tbl_spotbooking_temp  where spot_token='$tokenno'");

$spotbanktransdata=$res_spot->result_array();

$spotcusname	= $spotbanktransdata['spot_cusname'];
$spotadhaar	= $spotbanktransdata['spot_adhaar'];
$spotphone	= $spotbanktransdata['spot_phone'];
$spotton	= $spotbanktransdata['spot_ton'];
$spotunloading	= $spotbanktransdata['spot_unloading'];
$spotroute	= $spotbanktransdata['spot_route'];
$spotdistance	= $spotbanktransdata['spot_distance'];
$spotloading	= $spotbanktransdata['spot_loading'];
$spottoken	= $spotbanktransdata['spot_token'];
$spotchallan	= $spotbanktransdata['spot_challan'];
$spotamount	= $spotbanktransdata['spot_amount'];
//$spotalloted	= '0000-00-00';
$spottimestamp	= $spotbanktransdata['spot_timestamp'];
//	$spotuser	= '0';
//	$spotaltd_timestamp = '0000-00-00 00:00:00';
//$spotdriver	= $spotbanktransdata['spot_driver'];
//$spotlicense	= $spotbanktransdata['spot_license'];
//$spotVehicleMake = $spotbanktransdata['spot_VehicleMake'];
//$spotvehicleRegno	= $spotbanktransdata['spot_vehicleRegno'];
//	$passisue_user	= '0';
//	$passissue_timestamp = '0000-00-00 00:00:00';
$spotbookingip_addr  = $spotbanktransdata['spotbooking_ip_addr'];
//$decisionip_addr  = $spotbanktransdata['decision_ip_addr'];
	$port_id= $spotbanktransdata['port_id'];
$preferredzone  = $spotbanktransdata['preferred_zone'];
$spotbookingstatus   = $spotbanktransdata['spotbooking_status'];
$spotbookingdte      = $spotbanktransdata['spotbooking_dte'];
$spotbukdteph        = $spotbanktransdata['spotbuk_dteph'];
//$spotdriver_mobile   = $spotbanktransdata['spot_driver_mobile'];
$spotbooking_type    = $spotbanktransdata['spot_booking_type'];	


/*$data_in=array(
'spot_cusname'=>$spotcusname,
'spot_adhaar'=>$spotadhaar,
'spot_phone'=>$spotphone,
'spot_ton'=>$spotton,
'spot_unloading'=>$spotunloading,
'spot_route'=>$spotroute,
'spot_distance'=>$spotdistance,
'spot_token'=>$spottoken,
'spot_challan'=>$spotchallan,
'spot_amount'=>$spotamount,
'spotbooking_ip_addr'=>$spotbookingip_addr,
'port_id'=>$port_id,
'preferred_zone'=>$preferredzone,
'spotbooking_status'=>2,
'spotbooking_dte'=>$spotbookingdte,
'spotbuk_dteph'=>$spotbukdteph,
'spot_booking_type'=>$bookingtype,
'spot_booking_validity'=>1);*/
	
	$this->db->query("INSERT INTO `tbl_spotbooking`(`spot_cusname`, `spot_adhaar`, `spot_phone`, `spot_ton`, `spot_unloading`, `spot_route`, `spot_distance`, `spot_loading`, `spot_token`, `spot_challan`, `spot_amount`,  `spot_timestamp`,`spotbooking_ip_addr`, `port_id`, `preferred_zone`, `spotbooking_status`, `spotbooking_dte`, `spotbuk_dteph`, `spot_booking_type`) VALUES ('$spotcusname','$spotadhaar','$spotphone','$spotton','$spotunloading','$spotroute','$spotdistance','$spotloading','$spottoken','$spotchallan', '$spotamount','$spottimestamp', '$spotbookingip_addr','$port_id','$preferredzone','$spotbookingstatus','$spotbookingdte','$spotbukdteph','$spotbooking_type')");

//$this->db->insert('tbl_spotbooking', $data_in);
$this->db->query("update tbl_spotbooking_temp set spot_booking_validity='1' where spot_token='$tokenno'");
}

//-----------------------challan cancel in vijaya bank--------------------------------------
$get_ud=$this->db->query("select uid_no from transaction_details where token_no='$tokenno'");

$get_uid=$get_ud->result_array();

$uid_buk=$get_uid[0]['uid_no'];
$chvaliddate=date('Y-m-d');
if($uid_buk!=0){

$data = array(

"OPCODE"=>"CHALLANDATE",

            "UID"=>$uid_buk,

            "CHALLANDATE"=>$chvaliddate

); 
                                                              

$data_string = json_encode($data);   

//echo $data_string;                                                                                                                  

$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                      

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

'Content-Type: application/json',                                                                                

'Content-Length: ' . strlen($data_string))                                                                       

);                                                                                                                     

$result = curl_exec($ch);

$myArray=json_decode($result, true);

$resres=$myArray['RESPONSECODE'];

//print_r($resres);

$data_ins=array(

'token_no'=>$tokenno,

'response'=>$resres,
'bookingtype'=>$bookingstatus

);

$this->db->insert("tbl_chellan_validonline",$data_ins);
}
//------------------------------------------------------------------------------------------------

 $this->db->query("update transaction_details set transaction_refno='$bank_ref_no',transaction_ref_timestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_type=2,payment_type=2 where token_no='$tokenno'");

$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;
$smsmsg="Portinfo 2 - Dear Customer your payment for token no : $tokenno done successfully.Your bank ref no : $bank_ref_no.Thank you for payment with us.";
$this->sendSms($smsmsg,$custphoneno);
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);

}
else
{
$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;

$smsmsg="Portinfo 2 - Thank you for payment with us.However,the transaction has been declined.";
$this->sendSms($smsmsg,$custphoneno);


$today=date('Y-m-d');
$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
$ud=$queryspot->result_array();

$limit_id=$ud[0]['spot_limit_id'];
$limitqty=$ud[0]['spot_limit_quantity'];
$limitbalance=$ud[0]['spot_limit_balance'];
//------------------------------------------------------------------
$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
$getton=$get_ton->result_array();
$tonbooked=$getton[0]["spotton"];

$tonspot=$limitqty-$tonbooked;

//$this->db->query("update spot_booking_limit set spot_limit_balance=$tonspot where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");


//$data['rcvdString']=$rcvdString;
//$data = $data + $this->data;
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);
}

$this->db->query("update bank_transactionnw set bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' where transaction_id='$transid'");

//echo	$this->db->last_query(); exit();
//	$data['paystatus']=$payment_status;
//$data = $data + $this->data;


//$this->load->view('ccpay/ccavResponseHandler',$data);
$this->load->view('template/footer');
$this->load->view('template/js-footer');
$this->load->view('template/script-footer');
$this->load->view('template/html-footer');
}


//======================================================================================================
public function ponnani()
{
//--PONNANI-------
//$sess_online_portid = $this->session->userdata('online_portid'); 

$merkey_data=$this->db->query("select * from online_payment_data where port_id=16 and payment_status=1 and bank_type_id=2");

$merkeydata=$merkey_data->result_array();
$workingKey=$merkeydata[0]['working_key'];


include_once APPPATH.'/third_party/hdfc/Crypto.php';

//$workingKey='00E9AE7E6982F8A49A69A92A835701C2';	//Working Key should be provided here.
$encResponse=$_POST["encResp"];	//This is the response sent by the CCAvenue Server
$rcvdString=decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.

$callback_data_json_file=$rcvdString.'---------------';
$file = fopen(__DIR__."/hdfc_callback.txt","a");
fwrite($file,$callback_data_json_file."\n\r");
fclose($file);
$order_status="";

$decryptValues=explode('&', $rcvdString);
$dataSize=sizeof($decryptValues);

$res_array=array();
foreach($decryptValues as $vals){
$explode_arr	=	explode('=',$vals);
array_push($res_array,$explode_arr[1]);
}

$tokenno_id	=	$res_array['0'];

$tracking_id	=	$res_array['1'];
$bank_ref_no	=	$res_array['2'];
$order_status	=	$res_array['3'];
$failure_message=	$res_array['4'];
$payment_mode	=	$res_array['5'];
$card_name	=	$res_array['6'];
$status_code	=	$res_array['7'];
$status_message	=	$res_array['8'];
$currency	=	$res_array['9'];
$amount	=	floatval($res_array['10']);
$custregid	=	$res_array['26'];
$transid	=	$res_array['27'];
$bookingstatus	=	$res_array['29'];  //** bookingstatus=1(normal booking)bookingstatus=2(spot booking)
$tokenno	=	$res_array['30'];
$custname	=	$res_array['11'];
$custphoneno	=	$res_array['17'];
$custemailid	=	$res_array['18'];
$response_code	=	$res_array['38'];
$trans_date	=	$res_array['40'];

$rrestoken=$this->db->query("select * from bank_transactionnw  where transaction_id='$transid'");


$banktransdata=$rrestoken->result_array();
$table_transid=$banktransdata[0]['transaction_id'];
$table_token_no=$banktransdata[0]['token_no'];
$table_amount=$banktransdata[0]['transaction_amount'];
$port_id=$banktransdata[0]['port_id'];
$zone_id=$banktransdata[0]['zone_id'];

if($table_transid==$tokenno_id && $table_amount==$amount && $order_status=='Success' )
{
   $payment_status=1;
//$order_status='Success';
}
else{
   $payment_status=2;
  // $order_status='Invalid';
}



if($order_status=='Success'){$payment_status=1;}

else if($order_status=='Failure'){$payment_status=2;}

else if($order_status=='Invalid'){$payment_status=4;}

else{$payment_status=2;}

$responds_data=array('tokenno'=>$tokenno, 
 'transactionid'=>$tokenno_id,
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
'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))),
'bookingstatus'=>$bookingstatus);

$insert_transaction_reg	=$this->db->insert('online_banktransaction',$responds_data);

$transdate=date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));
if($payment_status==1)
{
if($bookingstatus==2)

{

$res_spot=$this->db->query("select  * from tbl_spotbooking_temp  where spot_token='$tokenno'");

$spotbanktransdata=$res_spot->result_array();

$spotcusname	= $spotbanktransdata['spot_cusname'];
$spotadhaar	= $spotbanktransdata['spot_adhaar'];
$spotphone	= $spotbanktransdata['spot_phone'];
$spotton	= $spotbanktransdata['spot_ton'];
$spotunloading	= $spotbanktransdata['spot_unloading'];
$spotroute	= $spotbanktransdata['spot_route'];
$spotdistance	= $spotbanktransdata['spot_distance'];
$spotloading	= $spotbanktransdata['spot_loading'];
$spottoken	= $spotbanktransdata['spot_token'];
$spotchallan	= $spotbanktransdata['spot_challan'];
$spotamount	= $spotbanktransdata['spot_amount'];
//$spotalloted	= '0000-00-00';
$spottimestamp	= $spotbanktransdata['spot_timestamp'];
//	$spotuser	= '0';
//	$spotaltd_timestamp = '0000-00-00 00:00:00';
//$spotdriver	= $spotbanktransdata['spot_driver'];
//$spotlicense	= $spotbanktransdata['spot_license'];
//$spotVehicleMake = $spotbanktransdata['spot_VehicleMake'];
//$spotvehicleRegno	= $spotbanktransdata['spot_vehicleRegno'];
//	$passisue_user	= '0';
//	$passissue_timestamp = '0000-00-00 00:00:00';
$spotbookingip_addr  = $spotbanktransdata['spotbooking_ip_addr'];
//$decisionip_addr  = $spotbanktransdata['decision_ip_addr'];
	$port_id= $spotbanktransdata['port_id'];
$preferredzone  = $spotbanktransdata['preferred_zone'];
$spotbookingstatus   = $spotbanktransdata['spotbooking_status'];
$spotbookingdte      = $spotbanktransdata['spotbooking_dte'];
$spotbukdteph        = $spotbanktransdata['spotbuk_dteph'];
//$spotdriver_mobile   = $spotbanktransdata['spot_driver_mobile'];
$spotbooking_type    = $spotbanktransdata['spot_booking_type'];	


/*$data_in=array(
'spot_cusname'=>$spotcusname,
'spot_adhaar'=>$spotadhaar,
'spot_phone'=>$spotphone,
'spot_ton'=>$spotton,
'spot_unloading'=>$spotunloading,
'spot_route'=>$spotroute,
'spot_distance'=>$spotdistance,
'spot_token'=>$spottoken,
'spot_challan'=>$spotchallan,
'spot_amount'=>$spotamount,
'spotbooking_ip_addr'=>$spotbookingip_addr,
'port_id'=>$port_id,
'preferred_zone'=>$preferredzone,
'spotbooking_status'=>2,
'spotbooking_dte'=>$spotbookingdte,
'spotbuk_dteph'=>$spotbukdteph,
'spot_booking_type'=>$bookingtype,
'spot_booking_validity'=>1);*/
	$this->db->query("INSERT INTO `tbl_spotbooking`(`spot_cusname`, `spot_adhaar`, `spot_phone`, `spot_ton`, `spot_unloading`, `spot_route`, `spot_distance`, `spot_loading`, `spot_token`, `spot_challan`, `spot_amount`,  `spot_timestamp`,`spotbooking_ip_addr`, `port_id`, `preferred_zone`, `spotbooking_status`, `spotbooking_dte`, `spotbuk_dteph`, `spot_booking_type`) VALUES ('$spotcusname','$spotadhaar','$spotphone','$spotton','$spotunloading','$spotroute','$spotdistance','$spotloading','$spottoken','$spotchallan', '$spotamount','$spottimestamp', '$spotbookingip_addr','$port_id','$preferredzone','$spotbookingstatus','$spotbookingdte','$spotbukdteph','$spotbooking_type')");

//$this->db->insert('tbl_spotbooking', $data_in);
$this->db->query("update tbl_spotbooking_temp set spot_booking_validity='1' where spot_token='$tokenno'");
}

//-----------------------challan cancel in vijaya bank--------------------------------------
$get_ud=$this->db->query("select uid_no from transaction_details where token_no='$tokenno'");

$get_uid=$get_ud->result_array();

$uid_buk=$get_uid[0]['uid_no'];
$chvaliddate=date('Y-m-d');
if($uid_buk!=0){

$data = array(

"OPCODE"=>"CHALLANDATE",

            "UID"=>$uid_buk,

            "CHALLANDATE"=>$chvaliddate

); 

                                                             

$data_string = json_encode($data);   

//echo $data_string;                                                                                                                  

$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                      

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

'Content-Type: application/json',                                                                                

'Content-Length: ' . strlen($data_string))                                                                       

);                                                                                                                     

$result = curl_exec($ch);

$myArray=json_decode($result, true);

$resres=$myArray['RESPONSECODE'];

//print_r($resres);

$data_ins=array(

'token_no'=>$tokenno,

'response'=>$resres,
'bookingtype'=>$bookingstatus

);

$this->db->insert("tbl_chellan_validonline",$data_ins);
}
//------------------------------------------------------------------------------------------------

 $this->db->query("update transaction_details set transaction_refno='$bank_ref_no',transaction_ref_timestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_type=2,payment_type=2 where token_no='$tokenno'");

$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;
$smsmsg="Portinfo 2 - Dear Customer your payment for token no : $tokenno done successfully.Your bank ref no : $bank_ref_no.Thank you for payment with us.";
$this->sendSms($smsmsg,$custphoneno);
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);

}
else
{
$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;

$smsmsg="Portinfo 2 - Thank you for payment with us.However,the transaction has been declined.";
$this->sendSms($smsmsg,$custphoneno);


$today=date('Y-m-d');
$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
$ud=$queryspot->result_array();

$limit_id=$ud[0]['spot_limit_id'];
$limitqty=$ud[0]['spot_limit_quantity'];
$limitbalance=$ud[0]['spot_limit_balance'];
//------------------------------------------------------------------
$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
$getton=$get_ton->result_array();
$tonbooked=$getton[0]["spotton"];

$tonspot=$limitqty-$tonbooked;

//$this->db->query("update spot_booking_limit set spot_limit_balance=$tonspot where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");


//$data['rcvdString']=$rcvdString;
//$data = $data + $this->data;
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);
}

$this->db->query("update bank_transactionnw set bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' where transaction_id='$transid'");

//echo	$this->db->last_query(); exit();
//	$data['paystatus']=$payment_status;
//$data = $data + $this->data;


//$this->load->view('ccpay/ccavResponseHandler',$data);
$this->load->view('template/footer');
$this->load->view('template/js-footer');
$this->load->view('template/script-footer');
$this->load->view('template/html-footer');
}


//======================================================================================================
public function vatakara()
{
//-----VADAKKARA-----
//$sess_online_portid = $this->session->userdata('online_portid'); 

$merkey_data=$this->db->query("select * from online_payment_data where port_id=17 and payment_status=1 and bank_type_id=2");

$merkeydata=$merkey_data->result_array();
$workingKey=$merkeydata[0]['working_key'];


include_once APPPATH.'/third_party/hdfc/Crypto.php';

//$workingKey='00E9AE7E6982F8A49A69A92A835701C2';	//Working Key should be provided here.
$encResponse=$_POST["encResp"];	//This is the response sent by the CCAvenue Server
$rcvdString=decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.

$callback_data_json_file=$rcvdString.'---------------';
$file = fopen(__DIR__."/hdfc_callback.txt","a");
fwrite($file,$callback_data_json_file."\n\r");
fclose($file);
$order_status="";
$decryptValues=explode('&', $rcvdString);
$dataSize=sizeof($decryptValues);

$res_array=array();
foreach($decryptValues as $vals){
$explode_arr	=	explode('=',$vals);
array_push($res_array,$explode_arr[1]);
}

$tokenno_id	=	$res_array['0'];
$tracking_id	=	$res_array['1'];
$bank_ref_no	=	$res_array['2'];
$order_status	=	$res_array['3'];
$failure_message=	$res_array['4'];
$payment_mode	=	$res_array['5'];
$card_name	=	$res_array['6'];
$status_code	=	$res_array['7'];
$status_message	=	$res_array['8'];
$currency	=	$res_array['9'];
$amount	=	floatval($res_array['10']);
$custregid	=	$res_array['26'];
$transid	=	$res_array['27'];
$bookingstatus	=	$res_array['29'];  //** bookingstatus=1(normal booking)bookingstatus=2(spot booking)
$tokenno	=	$res_array['30'];
$custname	=	$res_array['11'];
$custphoneno	=	$res_array['17'];
$custemailid	=	$res_array['18'];
$response_code	=	$res_array['38'];
$trans_date	=	$res_array['40'];

$rrestoken=$this->db->query("select * from bank_transactionnw  where transaction_id='$transid'");


$banktransdata=$rrestoken->result_array();
$table_transid=$banktransdata[0]['transaction_id'];
$table_token_no=$banktransdata[0]['token_no'];
$table_amount=$banktransdata[0]['transaction_amount'];
$port_id=$banktransdata[0]['port_id'];
$zone_id=$banktransdata[0]['zone_id'];

if($table_transid==$tokenno_id && $table_amount==$amount && $order_status=='Success' )
{
   $payment_status=1;
//$order_status='Success';
}
else{
   $payment_status=2;
  // $order_status='Invalid';
}




if($order_status=='Success'){$payment_status=1;}

else if($order_status=='Failure'){$payment_status=2;}

else if($order_status=='Invalid'){$payment_status=4;}

else{$payment_status=2;}
$responds_data=array('tokenno'=>$tokenno, 
 'transactionid'=>$tokenno_id,
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
'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))),
'bookingstatus'=>$bookingstatus);

$insert_transaction_reg	=$this->db->insert('online_banktransaction',$responds_data);

$transdate=date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));
if($payment_status==1)
{
if($bookingstatus==2)
{

$res_spot=$this->db->query("select  * from tbl_spotbooking_temp  where spot_token='$tokenno'");

$spotbanktransdata=$res_spot->result_array();

$spotcusname	= $spotbanktransdata['spot_cusname'];
$spotadhaar	= $spotbanktransdata['spot_adhaar'];
$spotphone	= $spotbanktransdata['spot_phone'];
$spotton	= $spotbanktransdata['spot_ton'];
$spotunloading	= $spotbanktransdata['spot_unloading'];
$spotroute	= $spotbanktransdata['spot_route'];
$spotdistance	= $spotbanktransdata['spot_distance'];
$spotloading	= $spotbanktransdata['spot_loading'];
$spottoken	= $spotbanktransdata['spot_token'];
$spotchallan	= $spotbanktransdata['spot_challan'];
$spotamount	= $spotbanktransdata['spot_amount'];
//$spotalloted	= '0000-00-00';
$spottimestamp	= $spotbanktransdata['spot_timestamp'];
//	$spotuser	= '0';
//	$spotaltd_timestamp = '0000-00-00 00:00:00';
//$spotdriver	= $spotbanktransdata['spot_driver'];
//$spotlicense	= $spotbanktransdata['spot_license'];
//$spotVehicleMake = $spotbanktransdata['spot_VehicleMake'];
//$spotvehicleRegno	= $spotbanktransdata['spot_vehicleRegno'];
//	$passisue_user	= '0';
//	$passissue_timestamp = '0000-00-00 00:00:00';
$spotbookingip_addr  = $spotbanktransdata['spotbooking_ip_addr'];
//$decisionip_addr  = $spotbanktransdata['decision_ip_addr'];
	$port_id= $spotbanktransdata['port_id'];
$preferredzone  = $spotbanktransdata['preferred_zone'];
$spotbookingstatus   = $spotbanktransdata['spotbooking_status'];
$spotbookingdte      = $spotbanktransdata['spotbooking_dte'];
$spotbukdteph        = $spotbanktransdata['spotbuk_dteph'];
//$spotdriver_mobile   = $spotbanktransdata['spot_driver_mobile'];
$spotbooking_type    = $spotbanktransdata['spot_booking_type'];	


/*$data_in=array(
'spot_cusname'=>$spotcusname,
'spot_adhaar'=>$spotadhaar,
'spot_phone'=>$spotphone,
'spot_ton'=>$spotton,
'spot_unloading'=>$spotunloading,
'spot_route'=>$spotroute,
'spot_distance'=>$spotdistance,
'spot_token'=>$spottoken,
'spot_challan'=>$spotchallan,
'spot_amount'=>$spotamount,
'spotbooking_ip_addr'=>$spotbookingip_addr,
'port_id'=>$port_id,
'preferred_zone'=>$preferredzone,
'spotbooking_status'=>2,
'spotbooking_dte'=>$spotbookingdte,
'spotbuk_dteph'=>$spotbukdteph,
'spot_booking_type'=>$bookingtype,
'spot_booking_validity'=>1);*/

	$this->db->query("INSERT INTO `tbl_spotbooking`(`spot_cusname`, `spot_adhaar`, `spot_phone`, `spot_ton`, `spot_unloading`, `spot_route`, `spot_distance`, `spot_loading`, `spot_token`, `spot_challan`, `spot_amount`,  `spot_timestamp`,`spotbooking_ip_addr`, `port_id`, `preferred_zone`, `spotbooking_status`, `spotbooking_dte`, `spotbuk_dteph`, `spot_booking_type`) VALUES ('$spotcusname','$spotadhaar','$spotphone','$spotton','$spotunloading','$spotroute','$spotdistance','$spotloading','$spottoken','$spotchallan', '$spotamount','$spottimestamp', '$spotbookingip_addr','$port_id','$preferredzone','$spotbookingstatus','$spotbookingdte','$spotbukdteph','$spotbooking_type')");

//$this->db->insert('tbl_spotbooking', $data_in);
$this->db->query("update tbl_spotbooking_temp set spot_booking_validity='1' where spot_token='$tokenno'");
}

//-----------------------challan cancel in vijaya bank--------------------------------------
$get_ud=$this->db->query("select uid_no from transaction_details where token_no='$tokenno'");

$get_uid=$get_ud->result_array();

$uid_buk=$get_uid[0]['uid_no'];
$chvaliddate=date('Y-m-d');
if($uid_buk!=0){

$data = array(

"OPCODE"=>"CHALLANDATE",

            "UID"=>$uid_buk,

            "CHALLANDATE"=>$chvaliddate

); 

                                                             

$data_string = json_encode($data);   

//echo $data_string;                                                                                                                  

$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                      

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

'Content-Type: application/json',                                                                                

'Content-Length: ' . strlen($data_string))                                                                       

);                                                                                                                     

$result = curl_exec($ch);

$myArray=json_decode($result, true);

$resres=$myArray['RESPONSECODE'];

//print_r($resres);

$data_ins=array(

'token_no'=>$tokenno,

'response'=>$resres,
'bookingtype'=>$bookingstatus

);

$this->db->insert("tbl_chellan_validonline",$data_ins);
}
//------------------------------------------------------------------------------------------------

 $this->db->query("update transaction_details set transaction_refno='$bank_ref_no',transaction_ref_timestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_type=2,payment_type=2 where token_no='$tokenno'");

$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;
$smsmsg="Portinfo 2 - Dear Customer your payment for token no : $tokenno done successfully.Your bank ref no : $bank_ref_no.Thank you for payment with us.";
$this->sendSms($smsmsg,$custphoneno);
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);

}
else
{
$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;

$smsmsg="Portinfo 2 - Thank you for payment with us.However,the transaction has been declined.";
$this->sendSms($smsmsg,$custphoneno);


$today=date('Y-m-d');
$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
$ud=$queryspot->result_array();

$limit_id=$ud[0]['spot_limit_id'];
$limitqty=$ud[0]['spot_limit_quantity'];
$limitbalance=$ud[0]['spot_limit_balance'];
//------------------------------------------------------------------
$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
$getton=$get_ton->result_array();
$tonbooked=$getton[0]["spotton"];

$tonspot=$limitqty-$tonbooked;

//$this->db->query("update spot_booking_limit set spot_limit_balance=$tonspot where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");


//$data['rcvdString']=$rcvdString;
//$data = $data + $this->data;
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);
}

$this->db->query("update bank_transactionnw set bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' where transaction_id='$transid'");

//echo	$this->db->last_query(); exit();
//	$data['paystatus']=$payment_status;
//$data = $data + $this->data;


//$this->load->view('ccpay/ccavResponseHandler',$data);
$this->load->view('template/footer');
$this->load->view('template/js-footer');
$this->load->view('template/script-footer');
$this->load->view('template/html-footer');
}


//======================================================================================================
public function kasaragod()
{
//----------KASARGOD-----------
//$sess_online_portid = $this->session->userdata('online_portid'); 

$merkey_data=$this->db->query("select * from online_payment_data where port_id=22 and payment_status=1 and bank_type_id=2");

$merkeydata=$merkey_data->result_array();
$workingKey=$merkeydata[0]['working_key'];


include_once APPPATH.'/third_party/hdfc/Crypto.php';

//$workingKey='00E9AE7E6982F8A49A69A92A835701C2';	//Working Key should be provided here.
$encResponse=$_POST["encResp"];	//This is the response sent by the CCAvenue Server
$rcvdString=decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.

$callback_data_json_file=$rcvdString.'---------------';
$file = fopen(__DIR__."/hdfc_callback.txt","a");
fwrite($file,$callback_data_json_file."\n\r");
fclose($file);
$order_status="";
$decryptValues=explode('&', $rcvdString);
$dataSize=sizeof($decryptValues);

$res_array=array();
foreach($decryptValues as $vals){
$explode_arr	=	explode('=',$vals);
array_push($res_array,$explode_arr[1]);
}

$tokenno_id	=	$res_array['0'];
$tracking_id	=	$res_array['1'];
$bank_ref_no	=	$res_array['2'];
$order_status	=	$res_array['3'];
$failure_message=	$res_array['4'];
$payment_mode	=	$res_array['5'];
$card_name	=	$res_array['6'];
$status_code	=	$res_array['7'];
$status_message	=	$res_array['8'];
$currency	=	$res_array['9'];
$amount	=	floatval($res_array['10']);
$custregid	=	$res_array['26'];
$transid	=	$res_array['27'];
$bookingstatus	=	$res_array['29'];  //** bookingstatus=1(normal booking)bookingstatus=2(spot booking)
$tokenno	=	$res_array['30'];
$custname	=	$res_array['11'];
$custphoneno	=	$res_array['17'];
$custemailid	=	$res_array['18'];
$response_code	=	$res_array['38'];
$trans_date	=	$res_array['40'];

$rrestoken=$this->db->query("select * from bank_transactionnw  where transaction_id='$transid'");


$banktransdata=$rrestoken->result_array();
$table_transid=$banktransdata[0]['transaction_id'];
$table_token_no=$banktransdata[0]['token_no'];
$table_amount=$banktransdata[0]['transaction_amount'];
$port_id=$banktransdata[0]['port_id'];
$zone_id=$banktransdata[0]['zone_id'];

if($table_transid==$tokenno_id && $table_amount==$amount && $order_status=='Success' )
{
   $payment_status=1;
//$order_status='Success';
}
else{
   $payment_status=2;
  // $order_status='Invalid';
}




if($order_status=='Success'){$payment_status=1;}

else if($order_status=='Failure'){$payment_status=2;}

else if($order_status=='Invalid'){$payment_status=4;}

else{$payment_status=2;}

 $responds_data=array('tokenno'=>$tokenno, 
 'transactionid'=>$tokenno_id,
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
'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))),
'bookingstatus'=>$bookingstatus);

$insert_transaction_reg	=$this->db->insert('online_banktransaction',$responds_data);

$transdate=date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));
if($payment_status==1)
{
if($bookingstatus==2)
{

$res_spot=$this->db->query("select  * from tbl_spotbooking_temp  where spot_token='$tokenno'");

$spotbanktransdata=$res_spot->result_array();
$spotcusname	= $spotbanktransdata['spot_cusname'];
$spotadhaar	= $spotbanktransdata['spot_adhaar'];
$spotphone	= $spotbanktransdata['spot_phone'];
$spotton	= $spotbanktransdata['spot_ton'];
$spotunloading	= $spotbanktransdata['spot_unloading'];
$spotroute	= $spotbanktransdata['spot_route'];
$spotdistance	= $spotbanktransdata['spot_distance'];
$spotloading	= $spotbanktransdata['spot_loading'];
$spottoken	= $spotbanktransdata['spot_token'];
$spotchallan	= $spotbanktransdata['spot_challan'];
$spotamount	= $spotbanktransdata['spot_amount'];
//$spotalloted	= '0000-00-00';
$spottimestamp	= $spotbanktransdata['spot_timestamp'];
//	$spotuser	= '0';
//	$spotaltd_timestamp = '0000-00-00 00:00:00';
//$spotdriver	= $spotbanktransdata['spot_driver'];
//$spotlicense	= $spotbanktransdata['spot_license'];
//$spotVehicleMake = $spotbanktransdata['spot_VehicleMake'];
//$spotvehicleRegno	= $spotbanktransdata['spot_vehicleRegno'];
//	$passisue_user	= '0';
//	$passissue_timestamp = '0000-00-00 00:00:00';
$spotbookingip_addr  = $spotbanktransdata['spotbooking_ip_addr'];
//$decisionip_addr  = $spotbanktransdata['decision_ip_addr'];
	$port_id= $spotbanktransdata['port_id'];
$preferredzone  = $spotbanktransdata['preferred_zone'];
$spotbookingstatus   = $spotbanktransdata['spotbooking_status'];
$spotbookingdte      = $spotbanktransdata['spotbooking_dte'];
$spotbukdteph        = $spotbanktransdata['spotbuk_dteph'];
//$spotdriver_mobile   = $spotbanktransdata['spot_driver_mobile'];
$spotbooking_type    = $spotbanktransdata['spot_booking_type'];	


/*$data_in=array(
'spot_cusname'=>$spotcusname,
'spot_adhaar'=>$spotadhaar,
'spot_phone'=>$spotphone,
'spot_ton'=>$spotton,
'spot_unloading'=>$spotunloading,
'spot_route'=>$spotroute,
'spot_distance'=>$spotdistance,
'spot_token'=>$spottoken,
'spot_challan'=>$spotchallan,
'spot_amount'=>$spotamount,
'spotbooking_ip_addr'=>$spotbookingip_addr,
'port_id'=>$port_id,
'preferred_zone'=>$preferredzone,
'spotbooking_status'=>2,
'spotbooking_dte'=>$spotbookingdte,
'spotbuk_dteph'=>$spotbukdteph,
'spot_booking_type'=>$bookingtype,
'spot_booking_validity'=>1);*/
$this->db->query("INSERT INTO `tbl_spotbooking`(`spot_cusname`, `spot_adhaar`, `spot_phone`, `spot_ton`, `spot_unloading`, `spot_route`, `spot_distance`, `spot_loading`, `spot_token`, `spot_challan`, `spot_amount`,  `spot_timestamp`,`spotbooking_ip_addr`, `port_id`, `preferred_zone`, `spotbooking_status`, `spotbooking_dte`, `spotbuk_dteph`, `spot_booking_type`) VALUES ('$spotcusname','$spotadhaar','$spotphone','$spotton','$spotunloading','$spotroute','$spotdistance','$spotloading','$spottoken','$spotchallan', '$spotamount','$spottimestamp', '$spotbookingip_addr','$port_id','$preferredzone','$spotbookingstatus','$spotbookingdte','$spotbukdteph','$spotbooking_type')");
//$this->db->insert('tbl_spotbooking', $data_in);
$this->db->query("update tbl_spotbooking_temp set spot_booking_validity='1' where spot_token='$tokenno'");
}

//-----------------------challan cancel in vijaya bank--------------------------------------
$get_ud=$this->db->query("select uid_no from transaction_details where token_no='$tokenno'");

$get_uid=$get_ud->result_array();

$uid_buk=$get_uid[0]['uid_no'];
$chvaliddate=date('Y-m-d');
if($uid_buk!=0){

$data = array(

"OPCODE"=>"CHALLANDATE",

            "UID"=>$uid_buk,

            "CHALLANDATE"=>$chvaliddate

); 

                                                             

$data_string = json_encode($data);   

//echo $data_string;                                                                                                                  

$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                      

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

'Content-Type: application/json',                                                                                

'Content-Length: ' . strlen($data_string))                                                                       

);                                                                                                                     

$result = curl_exec($ch);

$myArray=json_decode($result, true);

$resres=$myArray['RESPONSECODE'];

//print_r($resres);

$data_ins=array(

'token_no'=>$tokenno,

'response'=>$resres,
'bookingtype'=>$bookingstatus

);

$this->db->insert("tbl_chellan_validonline",$data_ins);
}
//------------------------------------------------------------------------------------------------

 $this->db->query("update transaction_details set transaction_refno='$bank_ref_no',transaction_ref_timestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_type=2,payment_type=2 where token_no='$tokenno'");

$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;
$smsmsg="Portinfo 2 - Dear Customer your payment for token no : $tokenno done successfully.Your bank ref no : $bank_ref_no.Thank you for payment with us.";
$this->sendSms($smsmsg,$custphoneno);
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);

}
else
{
$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;

$smsmsg="Portinfo 2 - Thank you for payment with us.However,the transaction has been declined.";
$this->sendSms($smsmsg,$custphoneno);


$today=date('Y-m-d');
$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
$ud=$queryspot->result_array();

$limit_id=$ud[0]['spot_limit_id'];
$limitqty=$ud[0]['spot_limit_quantity'];
$limitbalance=$ud[0]['spot_limit_balance'];
//------------------------------------------------------------------
$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
$getton=$get_ton->result_array();
$tonbooked=$getton[0]["spotton"];

$tonspot=$limitqty-$tonbooked;

//$this->db->query("update spot_booking_limit set spot_limit_balance=$tonspot where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");


//$data['rcvdString']=$rcvdString;
//$data = $data + $this->data;
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);
}

$this->db->query("update bank_transactionnw set bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' where transaction_id='$transid'");

//echo	$this->db->last_query(); exit();
//	$data['paystatus']=$payment_status;
//$data = $data + $this->data;


//$this->load->view('ccpay/ccavResponseHandler',$data);
$this->load->view('template/footer');
$this->load->view('template/js-footer');
$this->load->view('template/script-footer');
$this->load->view('template/html-footer');
}


//======================================================================================================
public function beypore()
{
//---BEYPORE------
//sess_online_portid = $this->session->userdata('online_portid'); 

$merkey_data=$this->db->query("select * from online_payment_data where port_id=24 and payment_status=1 and bank_type_id=2");

$merkeydata=$merkey_data->result_array();
$workingKey=$merkeydata[0]['working_key'];


include_once APPPATH.'/third_party/hdfc/Crypto.php';

//$workingKey='00E9AE7E6982F8A49A69A92A835701C2';	//Working Key should be provided here.
$encResponse=$_POST["encResp"];	//This is the response sent by the CCAvenue Server
$rcvdString=decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.

$callback_data_json_file=$rcvdString.'---------------';
$file = fopen(__DIR__."/hdfc_callback.txt","a");
fwrite($file,$callback_data_json_file."\n\r");
fclose($file);
$order_status="";
$decryptValues=explode('&', $rcvdString);
$dataSize=sizeof($decryptValues);

$res_array=array();
foreach($decryptValues as $vals){
$explode_arr	=	explode('=',$vals);
array_push($res_array,$explode_arr[1]);
}

$tokenno_id	=	$res_array['0'];
$tracking_id	=	$res_array['1'];
$bank_ref_no	=	$res_array['2'];
$order_status	=	$res_array['3'];
$failure_message=	$res_array['4'];
$payment_mode	=	$res_array['5'];
$card_name	=	$res_array['6'];
$status_code	=	$res_array['7'];
$status_message	=	$res_array['8'];
$currency	=	$res_array['9'];
$amount	=	floatval($res_array['10']);
$custregid	=	$res_array['26'];
$transid	=	$res_array['27'];
$bookingstatus	=	$res_array['29'];  //** bookingstatus=1(normal booking)bookingstatus=2(spot booking)
$tokenno	=	$res_array['30'];
$custname	=	$res_array['11'];
$custphoneno	=	$res_array['17'];
$custemailid	=	$res_array['18'];
$response_code	=	$res_array['38'];
$trans_date	=	$res_array['40'];

$rrestoken=$this->db->query("select * from bank_transactionnw  where transaction_id='$transid'");


$banktransdata=$rrestoken->result_array();
$table_transid=$banktransdata[0]['transaction_id'];
$table_token_no=$banktransdata[0]['token_no'];
$table_amount=$banktransdata[0]['transaction_amount'];
$port_id=$banktransdata[0]['port_id'];
$zone_id=$banktransdata[0]['zone_id'];

if($table_transid==$tokenno_id && $table_amount==$amount && $order_status=='Success' )
{
   $payment_status=1;
//$order_status='Success';
}
else{
   $payment_status=2;
  // $order_status='Invalid';
}




if($order_status=='Success'){$payment_status=1;}

else if($order_status=='Failure'){$payment_status=2;}

else if($order_status=='Invalid'){$payment_status=4;}

else{$payment_status=2;}

$responds_data=array('tokenno'=>$tokenno, 
 'transactionid'=>$tokenno_id,
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
'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))),
'bookingstatus'=>$bookingstatus);

$insert_transaction_reg	=$this->db->insert('online_banktransaction',$responds_data);

$transdate=date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));
if($payment_status==1)
{
if($bookingstatus==2)
{

$res_spot=$this->db->query("select  * from tbl_spotbooking_temp  where spot_token='$tokenno'");

$spotbanktransdata=$res_spot->result_array();

$spotcusname	= $spotbanktransdata['spot_cusname'];
$spotadhaar	= $spotbanktransdata['spot_adhaar'];
$spotphone	= $spotbanktransdata['spot_phone'];
$spotton	= $spotbanktransdata['spot_ton'];
$spotunloading	= $spotbanktransdata['spot_unloading'];
$spotroute	= $spotbanktransdata['spot_route'];
$spotdistance	= $spotbanktransdata['spot_distance'];
$spotloading	= $spotbanktransdata['spot_loading'];
$spottoken	= $spotbanktransdata['spot_token'];
$spotchallan	= $spotbanktransdata['spot_challan'];
$spotamount	= $spotbanktransdata['spot_amount'];
//$spotalloted	= '0000-00-00';
$spottimestamp	= $spotbanktransdata['spot_timestamp'];
//	$spotuser	= '0';
//	$spotaltd_timestamp = '0000-00-00 00:00:00';
//$spotdriver	= $spotbanktransdata['spot_driver'];
//$spotlicense	= $spotbanktransdata['spot_license'];
//$spotVehicleMake = $spotbanktransdata['spot_VehicleMake'];
//$spotvehicleRegno	= $spotbanktransdata['spot_vehicleRegno'];
//	$passisue_user	= '0';
//	$passissue_timestamp = '0000-00-00 00:00:00';
$spotbookingip_addr  = $spotbanktransdata['spotbooking_ip_addr'];
//$decisionip_addr  = $spotbanktransdata['decision_ip_addr'];
	$port_id= $spotbanktransdata['port_id'];
$preferredzone  = $spotbanktransdata['preferred_zone'];
$spotbookingstatus   = $spotbanktransdata['spotbooking_status'];
$spotbookingdte      = $spotbanktransdata['spotbooking_dte'];
$spotbukdteph        = $spotbanktransdata['spotbuk_dteph'];
//$spotdriver_mobile   = $spotbanktransdata['spot_driver_mobile'];
$spotbooking_type    = $spotbanktransdata['spot_booking_type'];	


/*$data_in=array(
'spot_cusname'=>$spotcusname,
'spot_adhaar'=>$spotadhaar,
'spot_phone'=>$spotphone,
'spot_ton'=>$spotton,
'spot_unloading'=>$spotunloading,
'spot_route'=>$spotroute,
'spot_distance'=>$spotdistance,
'spot_token'=>$spottoken,
'spot_challan'=>$spotchallan,
'spot_amount'=>$spotamount,
'spotbooking_ip_addr'=>$spotbookingip_addr,
'port_id'=>$port_id,
'preferred_zone'=>$preferredzone,
'spotbooking_status'=>2,
'spotbooking_dte'=>$spotbookingdte,
'spotbuk_dteph'=>$spotbukdteph,
'spot_booking_type'=>$bookingtype,
'spot_booking_validity'=>1);*/
	$this->db->query("INSERT INTO `tbl_spotbooking`(`spot_cusname`, `spot_adhaar`, `spot_phone`, `spot_ton`, `spot_unloading`, `spot_route`, `spot_distance`, `spot_loading`, `spot_token`, `spot_challan`, `spot_amount`,  `spot_timestamp`,`spotbooking_ip_addr`, `port_id`, `preferred_zone`, `spotbooking_status`, `spotbooking_dte`, `spotbuk_dteph`, `spot_booking_type`) VALUES ('$spotcusname','$spotadhaar','$spotphone','$spotton','$spotunloading','$spotroute','$spotdistance','$spotloading','$spottoken','$spotchallan', '$spotamount','$spottimestamp', '$spotbookingip_addr','$port_id','$preferredzone','$spotbookingstatus','$spotbookingdte','$spotbukdteph','$spotbooking_type')");

//$this->db->insert('tbl_spotbooking', $data_in);
$this->db->query("update tbl_spotbooking_temp set spot_booking_validity='1' where spot_token='$tokenno'");
}

//-----------------------challan cancel in vijaya bank--------------------------------------
$get_ud=$this->db->query("select uid_no from transaction_details where token_no='$tokenno'");

$get_uid=$get_ud->result_array();

$uid_buk=$get_uid[0]['uid_no'];
$chvaliddate=date('Y-m-d');
if($uid_buk!=0){

$data = array(

"OPCODE"=>"CHALLANDATE",

            "UID"=>$uid_buk,

            "CHALLANDATE"=>$chvaliddate

); 

                                                             

$data_string = json_encode($data);   

//echo $data_string;                                                                                                                  

$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                      

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

'Content-Type: application/json',                                                                                

'Content-Length: ' . strlen($data_string))                                                                       

);                                                                                                                     

$result = curl_exec($ch);

$myArray=json_decode($result, true);

$resres=$myArray['RESPONSECODE'];

//print_r($resres);

$data_ins=array(

'token_no'=>$tokenno,

'response'=>$resres,
'bookingtype'=>$bookingstatus

);

$this->db->insert("tbl_chellan_validonline",$data_ins);
}
//------------------------------------------------------------------------------------------------

 $this->db->query("update transaction_details set transaction_refno='$bank_ref_no',transaction_ref_timestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_type=2,payment_type=2 where token_no='$tokenno'");

$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;
$smsmsg="Portinfo 2 - Dear Customer your payment for token no : $tokenno done successfully.Your bank ref no : $bank_ref_no.Thank you for payment with us.";
$this->sendSms($smsmsg,$custphoneno);
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);

}
else
{
$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;

$smsmsg="Portinfo 2 - Thank you for payment with us.However,the transaction has been declined.";
$this->sendSms($smsmsg,$custphoneno);


$today=date('Y-m-d');
$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
$ud=$queryspot->result_array();

$limit_id=$ud[0]['spot_limit_id'];
$limitqty=$ud[0]['spot_limit_quantity'];
$limitbalance=$ud[0]['spot_limit_balance'];
//------------------------------------------------------------------
$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
$getton=$get_ton->result_array();
$tonbooked=$getton[0]["spotton"];

$tonspot=$limitqty-$tonbooked;

//$this->db->query("update spot_booking_limit set spot_limit_balance=$tonspot where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");


//$data['rcvdString']=$rcvdString;
//$data = $data + $this->data;
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);
}

$this->db->query("update bank_transactionnw set bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' where transaction_id='$transid'");

//echo	$this->db->last_query(); exit();
//	$data['paystatus']=$payment_status;
//$data = $data + $this->data;


//$this->load->view('ccpay/ccavResponseHandler',$data);
$this->load->view('template/footer');
$this->load->view('template/js-footer');
$this->load->view('template/script-footer');
$this->load->view('template/html-footer');
}


//======================================================================================================
public function kodungalloor()
{
//----KODUGALLUR------------
//$sess_online_portid = $this->session->userdata('online_portid'); 

$merkey_data=$this->db->query("select * from online_payment_data where port_id=26 and payment_status=1 and bank_type_id=2");

$merkeydata=$merkey_data->result_array();
$workingKey=$merkeydata[0]['working_key'];


include_once APPPATH.'/third_party/hdfc/Crypto.php';

//$workingKey='00E9AE7E6982F8A49A69A92A835701C2';	//Working Key should be provided here.
$encResponse=$_POST["encResp"];	//This is the response sent by the CCAvenue Server
$rcvdString=decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.

$callback_data_json_file=$rcvdString.'---------------';
$file = fopen(__DIR__."/hdfc_callback.txt","a");
fwrite($file,$callback_data_json_file."\n\r");
fclose($file);
$order_status="";
$decryptValues=explode('&', $rcvdString);
$dataSize=sizeof($decryptValues);

$res_array=array();
foreach($decryptValues as $vals){
$explode_arr	=	explode('=',$vals);
array_push($res_array,$explode_arr[1]);
}

$tokenno_id	=	$res_array['0'];
$tracking_id	=	$res_array['1'];
$bank_ref_no	=	$res_array['2'];
$order_status	=	$res_array['3'];
$failure_message=	$res_array['4'];
$payment_mode	=	$res_array['5'];
$card_name	=	$res_array['6'];
$status_code	=	$res_array['7'];
$status_message	=	$res_array['8'];
$currency	=	$res_array['9'];
$amount	=	floatval($res_array['10']);
$custregid	=	$res_array['26'];
$transid	=	$res_array['27'];
$bookingstatus	=	$res_array['29'];  //** bookingstatus=1(normal booking)bookingstatus=2(spot booking)
$tokenno	=	$res_array['30'];
$custname	=	$res_array['11'];
$custphoneno	=	$res_array['17'];
$custemailid	=	$res_array['18'];
$response_code	=	$res_array['38'];
$trans_date	=	$res_array['40'];

$rrestoken=$this->db->query("select * from bank_transactionnw  where transaction_id='$transid'");


$banktransdata=$rrestoken->result_array();
$table_transid=$banktransdata[0]['transaction_id'];
$table_token_no=$banktransdata[0]['token_no'];
$table_amount=$banktransdata[0]['transaction_amount'];
$port_id=$banktransdata[0]['port_id'];
$zone_id=$banktransdata[0]['zone_id'];

if($table_transid==$tokenno_id && $table_amount==$amount && $order_status=='Success' )
{
   $payment_status=1;
//$order_status='Success';
}
else{
   $payment_status=2;
  // $order_status='Invalid';
}



if($order_status=='Success'){$payment_status=1;}

else if($order_status=='Failure'){$payment_status=2;}

else if($order_status=='Invalid'){$payment_status=4;}

else{$payment_status=2;}

$responds_data=array('tokenno'=>$tokenno, 
 'transactionid'=>$tokenno_id,
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
'transaction_date'=>date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date))),
'bookingstatus'=>$bookingstatus);

$insert_transaction_reg	=$this->db->insert('online_banktransaction',$responds_data);

$transdate=date('Y-m-d H:i:s',strtotime(str_replace('/','-',$trans_date)));
if($payment_status==1)
{
if($bookingstatus==2)
{

$res_spot=$this->db->query("select  * from tbl_spotbooking_temp  where spot_token='$tokenno'");

$spotbanktransdata=$res_spot->result_array();

$spotcusname	= $spotbanktransdata['spot_cusname'];
$spotadhaar	= $spotbanktransdata['spot_adhaar'];
$spotphone	= $spotbanktransdata['spot_phone'];
$spotton	= $spotbanktransdata['spot_ton'];
$spotunloading	= $spotbanktransdata['spot_unloading'];
$spotroute	= $spotbanktransdata['spot_route'];
$spotdistance	= $spotbanktransdata['spot_distance'];
$spotloading	= $spotbanktransdata['spot_loading'];
$spottoken	= $spotbanktransdata['spot_token'];
$spotchallan	= $spotbanktransdata['spot_challan'];
$spotamount	= $spotbanktransdata['spot_amount'];
//$spotalloted	= '0000-00-00';
$spottimestamp	= $spotbanktransdata['spot_timestamp'];
//	$spotuser	= '0';
//	$spotaltd_timestamp = '0000-00-00 00:00:00';
//$spotdriver	= $spotbanktransdata['spot_driver'];
//$spotlicense	= $spotbanktransdata['spot_license'];
//$spotVehicleMake = $spotbanktransdata['spot_VehicleMake'];
//$spotvehicleRegno	= $spotbanktransdata['spot_vehicleRegno'];
//	$passisue_user	= '0';
//	$passissue_timestamp = '0000-00-00 00:00:00';
$spotbookingip_addr  = $spotbanktransdata['spotbooking_ip_addr'];
//$decisionip_addr  = $spotbanktransdata['decision_ip_addr'];
	$port_id= $spotbanktransdata['port_id'];
$preferredzone  = $spotbanktransdata['preferred_zone'];
$spotbookingstatus   = $spotbanktransdata['spotbooking_status'];
$spotbookingdte      = $spotbanktransdata['spotbooking_dte'];
$spotbukdteph        = $spotbanktransdata['spotbuk_dteph'];
//$spotdriver_mobile   = $spotbanktransdata['spot_driver_mobile'];
$spotbooking_type    = $spotbanktransdata['spot_booking_type'];	


/*$data_in=array(
'spot_cusname'=>$spotcusname,
'spot_adhaar'=>$spotadhaar,
'spot_phone'=>$spotphone,
'spot_ton'=>$spotton,
'spot_unloading'=>$spotunloading,
'spot_route'=>$spotroute,
'spot_distance'=>$spotdistance,
'spot_token'=>$spottoken,
'spot_challan'=>$spotchallan,
'spot_amount'=>$spotamount,
'spotbooking_ip_addr'=>$spotbookingip_addr,
'port_id'=>$port_id,
'preferred_zone'=>$preferredzone,
'spotbooking_status'=>2,
'spotbooking_dte'=>$spotbookingdte,
'spotbuk_dteph'=>$spotbukdteph,
'spot_booking_type'=>$bookingtype,
'spot_booking_validity'=>1);*/
$this->db->query("INSERT INTO `tbl_spotbooking`(`spot_cusname`, `spot_adhaar`, `spot_phone`, `spot_ton`, `spot_unloading`, `spot_route`, `spot_distance`, `spot_loading`, `spot_token`, `spot_challan`, `spot_amount`,  `spot_timestamp`,`spotbooking_ip_addr`, `port_id`, `preferred_zone`, `spotbooking_status`, `spotbooking_dte`, `spotbuk_dteph`, `spot_booking_type`) VALUES ('$spotcusname','$spotadhaar','$spotphone','$spotton','$spotunloading','$spotroute','$spotdistance','$spotloading','$spottoken','$spotchallan', '$spotamount','$spottimestamp', '$spotbookingip_addr','$port_id','$preferredzone','$spotbookingstatus','$spotbookingdte','$spotbukdteph','$spotbooking_type')");
//$this->db->insert('tbl_spotbooking', $data_in);
$this->db->query("update tbl_spotbooking_temp set spot_booking_validity='1' where spot_token='$tokenno'");
}

//-----------------------challan cancel in vijaya bank--------------------------------------
$get_ud=$this->db->query("select uid_no from transaction_details where token_no='$tokenno'");

$get_uid=$get_ud->result_array();

$uid_buk=$get_uid[0]['uid_no'];
$chvaliddate=date('Y-m-d');
if($uid_buk!=0){

$data = array(

"OPCODE"=>"CHALLANDATE",

            "UID"=>$uid_buk,

            "CHALLANDATE"=>$chvaliddate

); 

                                                             

$data_string = json_encode($data);   

//echo $data_string;                                                                                                                  

$ch = curl_init('https://www.mobile.vijayabankonline.in/PortCollection/FetchDetails.aspx');                                      

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     

curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      

curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          

'Content-Type: application/json',                                                                                

'Content-Length: ' . strlen($data_string))                                                                       

);                                                                                                                     

$result = curl_exec($ch);

$myArray=json_decode($result, true);

$resres=$myArray['RESPONSECODE'];

//print_r($resres);

$data_ins=array(

'token_no'=>$tokenno,

'response'=>$resres,
'bookingtype'=>$bookingstatus

);

$this->db->insert("tbl_chellan_validonline",$data_ins);
}
//------------------------------------------------------------------------------------------------

 $this->db->query("update transaction_details set transaction_refno='$bank_ref_no',transaction_ref_timestamp='$transdate',transaction_amount='$amount',transaction_status=1,payment_status=1,bank_type=2,payment_type=2 where token_no='$tokenno'");

$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;
$smsmsg="Portinfo 2 - Dear Customer your payment for token no : $tokenno done successfully.Your bank ref no : $bank_ref_no.Thank you for payment with us.";
$this->sendSms($smsmsg,$custphoneno);
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);

}
else
{
$data_n = array(
'token'   => $tokenno,
'bank_ref'	=>	$bank_ref_no,
'name'	=> $custname,
'amount'	=> $amount,
'mobileno'	=> $custphoneno,
'email'	=> $custemailid,
'order_status'	=> $order_status
);
$data['saveddata']=$data_n;

$smsmsg="Portinfo 2 - Thank you for payment with us.However,the transaction has been declined.";
$this->sendSms($smsmsg,$custphoneno);


$today=date('Y-m-d');
$queryspot = $this->db->query("SELECT * FROM `spot_booking_limit` WHERE `spot_limit_port_id`='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_date='$today'");
$ud=$queryspot->result_array();

$limit_id=$ud[0]['spot_limit_id'];
$limitqty=$ud[0]['spot_limit_quantity'];
$limitbalance=$ud[0]['spot_limit_balance'];
//------------------------------------------------------------------
$get_ton=$this->db->query("select sum(spot_ton) as spotton from tbl_spotbooking where preferred_zone='$zone_id' and spotbooking_dte='$today'");
$getton=$get_ton->result_array();
$tonbooked=$getton[0]["spotton"];

$tonspot=$limitqty-$tonbooked;

//$this->db->query("update spot_booking_limit set spot_limit_balance=$tonspot where spot_limit_date='$today' and spot_limit_port_id='$port_id' and `spot_limit_zone_id`='$zone_id' and  spot_limit_balance >0");


//$data['rcvdString']=$rcvdString;
//$data = $data + $this->data;
$this->load->view('template/header');
$this->load->view('ccpay/ccavResponseHandler',$data);
}

$this->db->query("update bank_transactionnw set bank_ref_no='$bank_ref_no',remitted_amount='$amount',transaction_receivedtimestamp='$transdate',remarks='$order_status',payment_status='$payment_status' where transaction_id='$transid'");

//echo	$this->db->last_query(); exit();
//	$data['paystatus']=$payment_status;
//$data = $data + $this->data;


//$this->load->view('ccpay/ccavResponseHandler',$data);
$this->load->view('template/footer');
$this->load->view('template/js-footer');
$this->load->view('template/script-footer');
$this->load->view('template/html-footer');
}

	

//======================================================================================================

}
?>