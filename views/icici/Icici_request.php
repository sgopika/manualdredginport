<html>

<head>
<script>
$(document).ready(function() {
        window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    });

</script>
<title></title>
</head>
<body>
<center>

<?php include('Crypto.php')?>
<?php 

	error_reporting(0);
	
	$merchant_data='';
	//$working_key='00E9AE7E6982F8A49A69A92A835701C2';//Shared by CCAVENUES
	//$access_code='AVAX83GA13CI23XAIC';//Shared by CCAVENUES
	$port_id=$_POST['merchant_param3'];
	$order_id=$_POST['order_id'];
	$booking_type=$_POST['merchant_param4'];
	$responseurl=$_POST['redirect_url'];
	
	$sqldata=$this->db->query("select * from online_payment_data where transaction_id='$order_id' and bank_type=3");
	$sql_data=$sqldata->result_array();
	
	$trans_amount	=	$sql_data[0]['transaction_amount'];
	$customer_name	=	$sql_data[0]['customer_name'];
	$customer_phone	=	$sql_data[0]['mobile_no'];
	$customer_email	=	$sql_data[0]['email_id'];
	$customerregid	=	$sql_data[0]['customer_registration_id'];
	$tokenno		=	$sql_data[0]['token_no'];
	$portid			=	$sql_data[0]['port_id'];
	$zoneid			=	$sql_data[0]['zone_id'];
	$requested_ton	=	$sql_data[0]['requested_ton'];
	
	$merchantid=
	$mandatoryfields=$order_id.'|'.$booking_type.'|'.$trans_amount;
	$optionalfields=$customer_name.'|'.$customer_phone.'|'.$customer_email.'|'.$customerregid.'|'.$tokenno.'|'.$requested_ton.'|'.$portid.'|'.$zoneid;
	$returnurl=$responseurl;
	$ReferenceNo=$order_id;
	$submerchantid=$booking_type;
	$transactionamount=$trans_amount
	$paymode=9;
	
	
	$merkey_data=$this->db->query("select * from online_payment_data where port_id='$port_id' and payment_status=1");

				$merkeydata=$merkey_data->result_array();
				$working_key=$merkeydata[0]['working_key'];
				$access_code=$merkeydata[0]['access_code'];
	//exit;
	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}

	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
	//print_r($merchant_data);exit;

?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
	<img src="<?php echo base_url(); ?>/assets/images/please_wait.gif" />
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
echo "<input type=hidden name=access_code value=$access_code>";
echo "<input type=hidden name=access_code value=$access_code>";
echo "<input type=hidden name=access_code value=$access_code>";
echo "<input type=hidden name=access_code value=$access_code>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
</center>
<script language='javascript'>
	
	window.onload = function(){
  document.forms['redirect'].submit();
}

	
	
	
</script>
</body>
</html>

