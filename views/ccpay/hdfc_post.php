<html>
<head>
<script>
	window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;
		
			document.getElementById("addBudget").submit();
		
		
		
	};
</script>
</head>
<body>
	<?php
	    $attributes = array("class" => "form-horizontal", "id" => "addBudget", "name" => "addBudget");
    
			echo form_open("Hdfc/Hdfc_request", $attributes);
		?>
		
		<div >
		
		
		<?php 
		//	print_r($postdata);
			//foreach($postdata as $postval)
//{
	$customerreg_id=$postdata['hid_custid'];
	//$merkey=$postdata['key'];
	//$tokenno=$postdata['tokenno'];
	//$custname=$postdata['custname'];
	//$custphone=$postdata['custphone'];
	//$requestton=$postdata['requestton'];
	//$transamount=$postdata['transamount'];
			
	//$transamount=1;
	$custemail=$postdata['custemail'];
	$banktype=	$postdata['banktype'];
			
		$tokenno=$getbookingdata[0]['customer_booking_token_number'];
		$transamount=$getbookingdata[0]['customer_booking_chalan_amount'];	
		$custname=$getbookingdata[0]['customer_name'];
		$custphone=$getbookingdata[0]['customer_phone_number'];
		$requestton=$getbookingdata[0]['customer_booking_request_ton'];	
			$portid=$getbookingdata[0]['customer_booking_port_id'];	
			
			$merkey=$merkeydata[0]['merchant_key'];	
			$responseurl=$merkeydata[0]['response_url'];
			
			$hdfcurl=$site_url.''.$responseurl;
			//
//} ?>
		
		
			<div style="display: none;">
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
					<td>Merchant Id	:</td><td><input type="hidden" name="merchant_id" value="<?php echo $merkey;?>"/></td>
				</tr>
				<tr>
					<td>Order Id	:</td><td><input type="hidden" name="order_id" value="<?php echo $transid;?>"/></td>
				</tr>
				<tr>
					<td>Amount	:</td><td><input type="hidden" name="amount" value="<?php echo $transamount;?>"/></td>
				</tr>
				<tr>
					<td>Currency	:</td><td><input type="hidden" name="currency" value="INR"/></td>
				</tr>
				<tr>
					<td>Redirect URL	:</td><td><input type="hidden" name="redirect_url" value="<?php echo $hdfcurl;?>"/></td>
				</tr>
			 	<tr>
			 		<td>Cancel URL	:</td><td><input type="hidden" name="cancel_url" value="<?php echo $hdfcurl;?>" /></td>
			 	</tr>
			 	<tr>
					<td>Language	:</td><td><input type="hidden" name="language" value="EN"/></td>
				</tr>
		     	<tr>
		     		<td colspan="2">Billing information(optional):</td>
		     	</tr>
		        <tr>
		        	<td>Billing Name	:</td><td><input type="hidden"  name="billing_name" value="<?php echo $custname;?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Address	:</td><td><input type="hidden" name="billing_address" value="Room no 1101, near Railway station Ambad"/></td>
		        </tr>
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
		        	<td>Billing Tel	:</td><td><input type="hidden" name="billing_tel" value="<?php echo $custphone;?>"/></td>
		        </tr>
		        <tr>
		        	<td>Billing Email	:</td><td><input type="hidden" name="billing_email" value="<?php echo $custemail;?>"/></td>
		        </tr>
		        <tr>
		        	<td colspan="2">Shipping information(optional)</td>
		        </tr>
		        <tr>
		        	<td>Shipping Name	:</td><td><input type="hidden" name="delivery_name" value="<?php echo $custname;?>"/></td>
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
		        	<td>Shipping Tel	:</td><td><input type="hidden" name="delivery_tel" value="<?php echo $custphone;?>"/></td>
		        </tr>
		        <tr>
		        	<td>Merchant Param1	:</td><td><input type="hidden" name="merchant_param1"  id="merchant_param1" value="<?php echo $customerreg_id; ?>"/></td>
		        </tr>
		        <tr>
		        	<td>Merchant Param2	:</td><td><input type="hidden" name="merchant_param2" id="merchant_param2" value="<?php echo $transid; ?>"/></td>
		        </tr>
				<tr>
					<td>Merchant Param3	:</td><td><input type="hidden" name="merchant_param3" id="merchant_param3" value="<?php echo $portid; ?>"/></td>
				</tr>
				<tr>
					<td>Merchant Param4	:</td><td><input type="hidden" name="merchant_param4" id="merchant_param4" value="1" /></td>
				</tr>
				<tr>
					<td>Merchant Param5	:</td><td><input type="hidden" name="merchant_param5" id="merchant_param5" value="<?php echo $tokenno; ?>" /></td>
				</tr>
				<tr>
					<td>Promo Code	:</td><td><input type="hidden" name="promo_code" value=""/></td>
				</tr>
				<tr>
					<td>Vault Info.	:</td><td><input type="hidden" name="customer_identifier" value=""/></td>
				</tr>
		        <tr>
		        	<td></td><td><INPUT TYPE="submit" value="CheckOut"></td>
		        </tr>
	      	</table>
			</div>
			
		</div>
	<!--<form method="post" name="customerData" action="https://portinfo.kerala.gov.in/index.php/Hdfc/Hdfc_request">-->
		
	  <?php echo form_close(); ?>
	      <!--</form>-->
	</body>
</html>


