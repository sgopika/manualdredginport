<?php

	error_reporting(0);
	
	//$workingKey='00E9AE7E6982F8A49A69A92A835701C2';		//Working Key should be provided here.
	//$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	//$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	//$order_status="";
//print_r($rcvdString); 
//print($paystatus);
//exit();
//	$decryptValues=explode('&', $rcvdString);
	//$dataSize=sizeof($decryptValues);
//print_r($dataSize); 

	echo "<center>";
//$this->load->model('Master_model');
//$val=$this->Master_model->addbankdetails($rcvdString);
//exit();
	//for($i = 0; $i < $dataSize; $i++) 
	//{
	//	$information=explode('=',$decryptValues[$i]);
		
	//	if($i==3)	$order_status=$information[1];
	//}

//for($i = 0; $i < $dataSize; $i++) 
//	{
		$token=$saveddata['token'];
		$bank_ref=$saveddata['bank_ref'];
		$name=$saveddata['name'];
		$mobileno=$saveddata['mobileno'];
		$amount=$saveddata['amount'];
		$email=$saveddata['email'];
		$order_status=$saveddata['order_status'];
		//$information=explode('=',$decryptValues[$i]);
	    //	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	//}
?>
<font color="#8B0F11" style="font-weight: bold; font-size: 12px;">
<?php 
	if($order_status=="Success")
	{
		echo "<br><br><br>Thank you for payment with us. Your credit card has been charged and your transaction is successful. You can collect the sand on Alloted Date.";
		
	}
	else if($order_status=="Aborted")
	{
		echo "<br><br><br>Thank you for payment with us.We will keep you posted regarding the status of your payment through e-mail";
	
	}
	else if($order_status=="Failure")
	{
		echo "<br><br><br>Thank you for payment with us.However,the transaction has been declined.";
	}
	else
	{
		echo "<br><br><br>Security Error. Illegal access detected";
	
	}

	echo "<br><br><br><br>";
	?>
	</font>
<?php
	echo "<table cellspacing=4 cellpadding=4>";
echo '<tr><td></td><td></td></tr>';
	//for($i = 0; $i < $dataSize; $i++) 
	//{
	///	$token=explode('=',$decryptValues[0]);
	//	$bank_ref=explode('=',$decryptValues[2]);
	//	$name=explode('=',$decryptValues[11]);
	//	$mobileno=explode('=',$decryptValues[17]);
	//	$amount=explode('=',$decryptValues[10]);
	//	$email=explode('=',$decryptValues[18]);
		
		//$information=explode('=',$decryptValues[$i]);
	    //	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	//}
		echo '<tr><td>Token No :</td><td>'.$token.'</td></tr>';
		echo '<tr><td>Bank Ref No :</td><td>'.$bank_ref.'</td></tr>';
		echo '<tr><td>Customer Name :</td><td>'.$name.'</td></tr>';
		echo '<tr><td>Mobile No :</td><td>'.$mobileno.'</td></tr>';
		echo '<tr><td>Customer Email Id :</td><td>'.$email.'</td></tr>';
		echo '<tr><td>Amount  :</td><td>'.$amount.'</td></tr>';
	echo "</table><br>";

echo '<div id="showhome" ><a href="http://portinfo.kerala.gov.in/index.php/Manual_dredging/Master/customer_booking_history" ><button class="btn btn-sm bg-blue btn-flat" type="button" > Go Back</button></a></div>';  
	echo "</center>";
?>
