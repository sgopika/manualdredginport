<?php
//print_r($_REQUEST);
?>

	<link rel="stylesheet" href=<?php echo base_url("assets/plugins/datepicker/datepicker3.css"); ?>>
	<script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>
	<script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>
	<script type="text/javascript">
	
		$(document).ready(function()
		{
			jQuery.validator.addMethod("nospecial", function(value, element) {
			return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);
			});
			jQuery.validator.addMethod("namewithspace", function(value, element) {
			return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
			});
			jQuery.validator.addMethod("exactlength", function(value, element, param) {
		 		return this.optional(element) || value.length == param;
			}, $.validator.format("<font color='red'>Please enter exactly {0} characters.</span>"));
		
		
		$('#canoeRegistration').validate(
		{
			rules:
			{ 
				canoe_registration_number:{
					required:true,
					nospecial:true,
				},
				canoe_name:{
					required:true,
					namewithspace:true,
				},
				canoe_capacity:{
					required:true,
					digits: true,
				},
				number_of_workers:{
					required:true,
					digits: true,
					maxlength:2,
				},
				canoe_registration_fee:{
					required:true,
					digits: true,
				},
				zone_id:{
					required:true,
				},
				worker_status:{
					required:true,
				},
				
			},
					 
			messages:
			{
				canoe_registration_number:{
					required:"<font color='red'>Please enter Registration number</span>",
					nospecial:"<font color='red'>Only letters and numbres are allowed</span>",
				},	
				canoe_name:{
					required:"<font color='red'>Please enter Name</span>",
					namewithspace:"<font color='red'>Only letters and space are allowed</span>",
				},
				canoe_capacity:{
					required:"<font color='red'>Please enter father's name</span>",
					digits:"<font color='red'>Only numbres are allowed</span>",
				},	
				worker_address:{
					required:"<font color='red'>Please enter address</span>",
				},
				zone_id:{
					required:"<font color='red'>Please select Zone</span>",
				},
				worker_status:{
					required:"<font color='red'>Please select Status</span>",
				},

			}	,
					 
			errorPlacement: function(error, element)
			{
				if ( element.is(":input") ) 
				{
					error.appendTo( element.parent() );
				}
				else
				{ 
					 error.insertAfter( element );
				}
		 	}
					 		
		});	
	});

	</script>
   <!-------------------------------------------------------------------------------->
    <div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Zone</button>
		</div>
		
     <div class="col-12 d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
         <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/canoeregistration"); ?>"> Canoe Registration </a></li>
        <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Canoe </strong></a></li>
      </ol>
</div>
   
   
    <!-- Main content -->
   	<div class="col-md-12">
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      <!--      </div> -->
		 </div> <!-- end of co12 -->
		</div> <!-- end of row -->  
            
   
   <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($canoe_id)){
        $attributes = array("class" => "form-horizontal", "id" => "canoeRegistration", "name" => "canoeRegistration");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "canoeRegistration", "name" => "canoeRegistration", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($canoe_id); echo "ghghghgh";//$editres[0]['intUserTypeID'];
		if(isset($canoe_id)){
       		echo form_open("Manual_dredging/Master/canoeregistration_edit", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/canoeregistration_add", $attributes);
		}?>
   
   <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
   		   <input type="hidden" name="hid" value="<?php if(isset($canoe_id)){ echo $canoe_id;} ?>" />
			Registration Number<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <input type="text" name="canoe_registration_number" value="<?php if(isset($canoe_registration_number )){echo $canoe_registration_number;} else { echo set_value('canoe_registration_number');} ?>" id="canoe_registration_number"  class="form-control"  maxlength="100" autocomplete="off" required/> 
            </div>
	</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           		Canoe Name<font color="#FF0000">*</font>
           		</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <input type="text" name="canoe_name" value="<?php if(isset($canoe_name )){echo $canoe_name;} else { echo set_value('canoe_name');} ?>" id="canoe_name"  class="form-control"  maxlength="100" autocomplete="off" required/> 
            </div>
	</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           Capacity<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <input type="text" name="canoe_capacity" value="<?php if(isset($canoe_capacity )){echo $canoe_capacity;} else { echo set_value('canoe_capacity');} ?>" id="canoe_capacity"  class="form-control"  maxlength="100" autocomplete="off" required/> 
           </div>
	</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           Number of workers<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <input type="text" name="number_of_workers" value="<?php if(isset($number_of_workers )){echo $number_of_workers;} else { echo set_value('number_of_workers');} ?>" id="number_of_workers"  class="form-control"  maxlength="100" autocomplete="off" required/>  </div>
	</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           Registration Fee<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <input readonly type="text" name="canoe_registration_fee" value="<?php if(isset($canoe_registration_fee )){echo $canoe_registration_fee;}  ?>" id="canoe_registration_fee"  class="form-control"  maxlength="100" autocomplete="off" required/>  </div>
	</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           Select Zone<font color="#FF0000">*</font>
           </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <select name="zone_id" id="zone_id"   class="form-control"  >
           	 <option value="1">SELECT</option>
           		<?php foreach($array_zone as $zone){?>
               	<option value="<?php  echo $zone['zone_id'];?>" <?php if(isset($zone_id)){
			   if($zone_id==$zone['zone_id']){?> selected="selected"<?php  } }else { if($zone['zone_id']== set_value('zone_id')){ echo "selected='selected' ";}  }?>><?php  echo $zone['zone_name'];?></option>
             <?php } ?>
           </select> 
             </div>
	</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           Status<font color="#FF0000">*</font>
           </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           
           <select name="canoe_status" id="canoe_status"   class="form-control"  >
           	 <option value="1">SELECT</option>
           	<?php foreach($array_status as $status){?>
               <option value="<?php  echo $status['status_id'];?>" 
			   <?php if(isset($canoe_status)){
			   if($canoe_status==$status['status_id']){?> selected="selected"<?php } }
			   else { 
			   if($status['status_id']== set_value('canoe_status')){ echo "selected='selected' ";}  }?>><?php  echo $status['status_name'];?></option>
             <?php } ?>
           </select> 
          </div>
          </div> <!-- end of row -->

	 <div class="row px-5 py-5">
 		
        <div class="col-12 d-flex justify-content-center">
        
		<input type="hidden" name="hId" value="<?php  if(isset($canoe_id)){echo $canoe_id;}?>" />
		<?php if(isset($canoe_id)){?>
		
		 <input id="btn_add" name="btn_add" type="submit" class="px-4 btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class=" px-4 btn btn-primary" value="Save"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class=" mx-4 btn btn-danger" value="Cancel" />
     
         </div> <!-- end of col 12 -->
         
	</div> <!-- end of row -->
		<?php echo form_close(); ?>
</div> <!-- end of container -->
  	 	      