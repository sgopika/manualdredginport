<?php //print_r($requested_transaction_details);exit; ?>
<html>
<head>
<script>

window.onload = function() 
{
	var d = new Date().getTime();
	document.getElementById("tid").value = d;
	document.getElementById("paymentrequest").submit();
	};

</script>
</head>
<body>
<?php
$attributes = array("class" => "form-horizontal", "id" => "paymentrequest", "name" => "paymentrequest");
echo form_open("Kiv_Ctrl/Hdfc/Hdfc_request", $attributes);
?>

<div >
<?php 
$bank_transaction_id=	$requested_transaction_details[0]['bank_transaction_id'];
$transaction_id 	=	$requested_transaction_details[0]['transaction_id'];
$token_no 			=	$requested_transaction_details[0]['token_no'];
$bank_id 			=	$requested_transaction_details[0]['bank_id'];
$portid 			=	$requested_transaction_details[0]['port_id'];	

//print_r($requested_transaction_details);

$merchant_key		=	$online_payment_data[0]['merchant_key'];
$transamount 		=	$amount_tobe_pay;	

$user_name			=	$payment_user1[0]['user_name'];
$user_mobile_number	=	$payment_user1[0]['user_mobile_number'];
$user_email			=	$payment_user1[0]['user_email'];	





?>

		
<div>
<!-- <div style="display: none;"> -->
	<table width="40%" height="100" border='1' align="center"><caption><font size="4" color="blue"><b>Integration Kit</b></font></caption></table>
<table width="40%" height="100" border='1' align="center">

	<tr>
		<td>Parameter Name:</td><td>Parameter Value:</td>
	</tr>
	<tr>
		<td colspan="2"> Compulsory information</td>
	</tr>

	<tr>
		<td>TID	:</td><td><input type="hidden" name="tid" id="tid" value="" /></td>
	</tr>

	<tr>
		<td>Merchant Id	:</td><td><input type="hidden" name="merchant_id" value="<?php echo $merchant_key;?>"/></td>
	</tr>
	<tr>
		<td>Order Id	:</td><td><input type="hidden" name="order_id" value="<?php echo $token_no;?>"/></td>
	</tr>
	<tr>
		<td>Amount	:</td><td><input type="hidden" name="amount" value="<?php echo $transamount;?>"/></td>
	</tr>
	<tr>
		<td>Currency	:</td><td><input type="hidden" name="currency" value="INR"/></td>
	</tr>

	<tr>
		<td>Redirect URL	:</td><td><input type="hidden" name="redirect_url" value="<?php echo base_url('index.php/Kiv_Ctrl/Hdfc/Hdfc_response');?>"/></td>
	</tr>
 	<tr>
 		<td>Cancel URL	:</td><td><input type="hidden" name="cancel_url" value="<?php echo base_url('index.php/Kiv_Ctrl/Hdfc/Hdfc_response');?>" /></td>
 	</tr>
 	<tr>
		<td>Language	:</td><td><input type="hidden" name="language" value="EN"/></td>
	</tr>
 	<tr>
 		<td colspan="2">Information(optional):</td>
 	</tr>
    <tr>
    	<td>Billing Name	:</td><td><input type="hidden"  name="billing_name" value="<?php echo $user_name;?>"/></td>
    </tr>


     <tr>
    	<td>Billing Address	:</td><td><input type="hidden" name="billing_address" value="Room no 1101, near Railway station Ambad"/></td></tr>
    <tr>
    	<td>Billing City	:</td><td><input type="hidden" name="billing_city" value="Indore"/></td>
    </tr>
    <tr>
    	<td>Billing State	:</td><td><input type="hidden" name="billing_state" value="Kerala"/></td>
    </tr>
    <tr>
    	<td>Billing Zip	:</td><td><input type="hidden" name="billing_zip" value="425001"/></td>
    </tr>
    <tr>
    	<td>Billing Country	:</td><td><input type="hidden" name="billing_country" value="India"/></td>
    </tr> 
    <tr>
    	<td>Billing Tel	:</td><td><input type="hidden" name="billing_tel" value="<?php echo $user_mobile_number;?>"/></td>
    </tr>

    <tr>
    	<td>Billing Email	:</td><td><input type="hidden" name="billing_email" value="<?php echo $user_email;?>"/></td>
    </tr>

    <tr>
		<td>Merchant Param1	:</td><td><input type="hidden" name="merchant_param1" id="merchant_param1" value="<?php echo $portid; ?>"/></td>
	</tr>

 <tr>
    <td>Merchant Param2	:</td><td><input type="hidden" name="merchant_param2" id="merchant_param2" value="<?php echo $bank_transaction_id; ?>"/></td>
    </tr>

<tr>
    <td>Merchant Param3	:</td><td><input type="hidden" name="merchant_param3"  id="merchant_param3" value="<?php echo $transaction_id; ?>"/></td>
    </tr>
<tr>
    <td>Merchant Param4 :</td><td><input type="hidden" name="merchant_param4"  id="merchant_param4" value="<?php echo $bank_id; ?>"/></td>
    </tr>

<tr>
    <td>Merchant Param5 :</td><td><input type="hidden" name="merchant_param5"  id="merchant_param5" value="<?php //echo $bank_id; ?>"/></td>
    </tr>



    
    <tr>
    	<td colspan="2">Shipping information(optional)</td>
    </tr>
    <tr>
    	<td>Shipping Name	:</td><td><input type="hidden" name="delivery_name" value="<?php //echo $custname;?>"/></td>
    </tr>
    <tr>
    	<td>Shipping Address	:</td><td><input type="hidden" name="delivery_address" value=""/></td>
    </tr>
    <tr>
    	<td>shipping City	:</td><td><input type="hidden" name="delivery_city" value=""/></td>
    </tr>
    <tr>
    	<td>shipping State	:</td><td><input type="hidden" name="delivery_state" value="Kerala"/></td>
    </tr>
    <tr>
    	<td>shipping Zip	:</td><td><input type="hidden" name="delivery_zip" value=""/></td>
    </tr>
    <tr>
    	<td>shipping Country	:</td><td><input type="hidden" name="delivery_country" value="India"/></td>
    </tr>
    <tr>
    	<td>Shipping Tel	:</td><td><input type="hidden" name="delivery_tel" value="<?php //echo $custphone;?>"/></td>
    </tr>
    
   
	
       

	<tr>
		<td>Promo Code	:</td><td><input type="hidden" name="promo_code" value=""/></td>
	</tr>
	<tr>
		<td>Vault Info.	:</td><td><input type="hidden" name="customer_identifier" value=""/></td>
	</tr>
  
  <tr>
        <td></td><td><input type="submit" value="CheckOut"></td>
    </tr>
	</table>
</div>
</div>

<?php echo form_close(); ?>
</body>
</html>



