<html>
<head>
<title> Non-Seamless-kit</title>
</head>
<body>
<center>
<?php
 include('Crypto.php');
error_reporting(0);
$merchant_data='';
$port_id 			=	$_POST['merchant_param1'];
$bank_id 			= 	$_POST['merchant_param4'];

$merkeydata         =   $this->Survey_model->get_online_payment_data($port_id,$bank_id);
$data['merkeydata'] = 	$merkeydata;
if(!empty($merkeydata))
{
	$working_key 	=	$merkeydata[0]['working_key'];
	$access_code 	=	$merkeydata[0]['access_code'];
}

foreach ($_POST as $key => $value)
{
	$merchant_data.=$key.'='.$value.'&';
}

$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.

?>
<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<img src="<?php echo base_url(); ?>/plugins/img/PleaseWait.gif" />
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
</center>

</body>
</html>

<script language='javascript'>
window.onload = function()
{
	document.forms['redirect'].submit();
}

</script>