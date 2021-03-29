<?php
if(!empty($result_arr))
{ 
//print_r($result_arr) ;
	$user_master_id=$result_arr[0]['user_master_id'];
	$customer_id=$result_arr[0]['customer_id'];
	$user_master_fullname=$result_arr[0]['user_master_fullname'];
	$user_master_ph=$result_arr[0]['user_master_ph'];
	$get_user_details			= 	$this->Registration_model->get_user_details($customer_id);
  	$data['get_user_details']	=	$get_user_details;
  	$user_address=$get_user_details[0]['user_address'];

?>
<div class="row listrow">
<div class="col-1 home_content pt-0">
Owner Name 
</div> 
<div class="col-3 home_subtitle">
<div class="form-group">
	<input type="hidden" name="user_master_id" id="user_master_id" value="<?php echo $user_master_id; ?>">
  <input type="text" class="form-control btn-point" value="<?php echo $user_master_fullname; ?>" name="user_name" id="user_name" aria-describedby="text" placeholder="Vessel owners name" maxlength="50" data-validation="required" onkeypress="return alpbabetspace(event);" required readonly>
</div>
</div> 
<div class="col-2 home_content pt-0">
Mobile Number
</div> 
<div class="col-2 home_subtitle">
<div class="form-group">
<input type="tel" class="form-control btn-point" value="<?php echo $user_master_ph; ?>" name="user_mobile_number" id="user_mobile_number" aria-describedby="text" data-validation="required" placeholder="Owner mobile number" minlength="10" maxlength="10"  readonly onkeypress="return IsNumeric(event);" required>
</div>
</div> 
<div class="col-2 home_content pt-0">
Address
</div> 
<div class="col-2 home_subtitle">
<div class="form-group">
<textarea class="form-control btn-point btn-block" id="textarea" rows="5" name="user_address" id="user_address" onkeypress="return IsAddress(event);" data-validation="required" readonly maxlength="100" placeholder="Address of owner" required><?php echo $user_address; ?></textarea>
</div>
</div> 
</div>

<?php } else { echo "0"; }   ?> 