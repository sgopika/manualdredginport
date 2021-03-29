<?php

	error_reporting(0);
	echo "<center>";

		$token=$saveddata['token'];
		$bank_ref=$saveddata['bank_ref'];
		$name=$saveddata['name'];
		$mobileno=$saveddata['mobileno'];
		$amount=$saveddata['amount'];
		$email=$saveddata['email'];
		$order_status=$saveddata['order_status'];
		
?>
<font color="#8B0F11" style="font-weight: bold; font-size: 12px;">
<?php 
	if($order_status=="Success")
	{
		echo "<br><br><br>Thank you for payment with us. Your credit card has been charged and your transaction is successful.";
		
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
echo '<tr><td>Token No :</td><td>'.$token.'</td></tr>';
echo '<tr><td>Bank Ref No :</td><td>'.$bank_ref.'</td></tr>';
echo '<tr><td>Customer Name :</td><td>'.$name.'</td></tr>';
echo '<tr><td>Mobile No :</td><td>'.$mobileno.'</td></tr>';
echo '<tr><td>Customer Email Id :</td><td>'.$email.'</td></tr>';
echo '<tr><td>Amount  :</td><td>'.$amount.'</td></tr>';
echo '<tr><td>Status  :</td><td>'.$order_status.'</td></tr>';
echo "</table><br>";
echo "</center>";


?>
 <nav aria-label="breadcrumb " class="mb-0">
 	<div><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></div>
  
</nav> 