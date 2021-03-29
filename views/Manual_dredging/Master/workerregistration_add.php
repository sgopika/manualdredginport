<script>
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
</script>

	<script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>
	<script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>
    <script src=<?php echo base_url("assets/aadhar/Verhoeff.js");?>></script>
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
		
		
		$('#workerRegistration').validate(
		{
			rules:
			{ 
				worker_adhar_no:{
					required :true,
					nospecial:true,
					exactlength:12,
				},
				worker_name:{
					required :true,
					namewithspace:true,
				},
				worker_father_name:{
					required :true,
					namewithspace:true,
				},
				worker_address:{
					required :true,
				},
				worker_phone_number:{
					required :true,
					digits: true,
					exactlength:10,
				},
				zone_id:{
					required :true,
				},
				worker_status:{
					required :true,
				},
				
			},
					 
			messages:
			{
				worker_adhar_no:{
					required :"<font color='red'>Please enter Adhar Number</span>",
					maxlength:"<font color='red'>Please enter a valid Adhar Number(12 digits)</span>",
				},	
				worker_name:{
					required :"<font color='red'>Please enter Name</span>",
					namewithspace:"<font color='red'>Only letters and space is allowed</span>",
				},
				worker_father_name:{
					required :"<font color='red'>Please enter father's name</span>",
					namewithspace:"<font color='red'>Only letters and space is allowed</span>",
				},	
				worker_address:{
					required :"<font color='red'>Please enter address</span>",
				},
				zone_id:{
					required :"<font color='red'>Please select Zone</span>",
				},
				worker_status:{
					required :"<font color='red'>Please select Status</span>",
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
    <script>
    function validate_adharnumber(){
	
		//alert('ff');
		var strVal = $("#worker_adhar_no").val();
		if (strVal.length < 12) // Minimum length.
		{
		  alert("Adhar number must be 12 digit");exit();
		}else if(strVal.verhoeffCheck() == false){
		   alert("Invalid Aadhar Number");
			$("#worker_adhar_no").val('');exit;
		}else if(strVal.verhoeffCheck() == true) {
				//alert('hhh');	
				$.post("<?php echo $site_url?>/Manual_dredging/Master/chech_worker_adhar_exists",{adhar_no:strVal},function(data)
				{	
				//$('#daterangearray').html(data);
					if(data == false){
						alert("Aadhar Number no already exists");
						$("#worker_adhar_no").val('');exit;
					}
				});
		}
		
	}
    
    </script>

 <div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Monthly Permit</button>
		</div>

    <div class="col-12 d-flex justify-content-end">

<?php 
	$sess_user_type			=	$this->session->userdata('int_usertype');
	 //echo "fff".$sess_user_type;
	if($sess_user_type==3)
	{ 
		$url=site_url("Manual_dredging/Master/pcdredginghome");
	 }
	 else if($sess_user_type==4)
	{ 
		$url=site_url("Manual_dredging/Port/port_lsgd_main");
	 }
	  else
	   {
	    $url=site_url('Manual_dredging/Port/port_clerk_main');
	}
	?>

     
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/workerregistration"); ?>"><strong>Worker Registration </strong></a></li>
		 
        <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Worker Registration </strong></a></li>
      </ol>
    </div>
    <!-- Main content -->
    
        <div class="col-md-12">
          <!-- /.box -->
        
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      </div> <!-- end of co12 -->
		</div> <!-- end of row -->  



    <!-- Main content -->
    <div class="row">
		<div class="col-12">
          <!-- /.box -->
        <div class="box" >
        
            
        <div class="box box-primary box-blue-bottom">
            <div class="box-header ">
              <h3 class="box-title"><?php
			
			   if(isset($worker_id)){?>Edit<?php } else {?>Add <?php }?> Worker </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($worker_id)){
        		$attributes = array("class" => "form-horizontal", "id" => "workerRegistration", "name" => "workerRegistration","onSubmit" => "return validate_adharnumber();");
			} else {
       			$attributes = array("class" => "form-horizontal", "id" => "workerRegistration", "name" => "workerRegistration", "onSubmit" => "return validate_adharnumber();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($worker_id)){
       		echo form_open("Manual_dredging/Master/workerregistration_edit", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/workerRegistration_add", $attributes);
		}?>
		<input type="hidden" name="hid" value="<?php if(isset($worker_id)){ echo $worker_id;} ?>" />
		<table id="vacbtable" class="table table-bordered table-striped">
      	<?php if(isset($worker_id) && isset($worker_adhar_no)){ ?>
        <tr>
      		<td>Aadhar Number<font color="#FF0000">*</font></td>
      		<td ><?php if(isset($worker_adhar_no )){echo $worker_adhar_no;} ?></td>
            <input type="hidden" name="worker_adhar_no" value="<?php if(isset($worker_adhar_no)){ echo $worker_adhar_no;} ?>"  />
      	</tr>
        <?php }else{ ?>
        <tr>
      		<td>Aadhar Number<font color="#FF0000">*</font></td>
      		<td ><input maxlength="12" type="text" name="worker_adhar_no" value="<?php if(isset($worker_adhar_no )){echo $worker_adhar_no;} else { echo set_value('worker_adhar_no');} ?>" id="worker_adhar_no"  class="form-control" onBlur="validate_adharnumber()"  maxlength="100" required maxlength="12" /> </td>
      	</tr>
        <?php } ?>
        <tr >
      		<td>Name<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="worker_name" value="<?php if(isset($worker_name )){echo $worker_name;} else { echo set_value('worker_name');} ?>" id="worker_name"  class="form-control"  maxlength="100" autocomplete="off" required  /> </td>
      	</tr>
        
        <tr >
      		<td>Father’s Name<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="worker_father_name" value="<?php if(isset($worker_father_name )){echo $worker_father_name;} else { echo set_value('worker_father_name');} ?>" id="worker_father_name"  class="form-control"  maxlength="100"  autocomplete="off" required  /> </td>
      	</tr>
        
        <tr >
      		<td>Address<font color="#FF0000">*</font></td>
      		 <td><textarea name="worker_address" id="worker_address" cols="45" rows="5" class="form-control" required ><?php if(isset($worker_address )){echo $worker_address;} else { echo set_value('txt_unit_address');} ?></textarea></td>
      	</tr>
        
         <tr >
      		<td>Mobile Number <font color="#FF0000">*</font></td>
      		<td ><input type="text" name="worker_phone_number" value="<?php if(isset($worker_phone_number )){echo $worker_phone_number;} else { echo set_value('worker_phone_number');} ?>" id="worker_phone_number"  class="form-control"  maxlength="100"  autocomplete="off" required maxlength="10" /> </td>
      	</tr>
        
		<?php /*?><tr >
      		<td>Select Zone<font color="#FF0000">*</font></td>
      		<td>
           <select name="zone_id" id="zone_id"   class="form-control"  >
           	 <option value="1">SELECT</option>
           		<?php foreach($array_zone as $zone){?>
               	<option value="<?php  echo $zone['zone_id'];?>" <?php if(isset($zone_id)){
			   if($zone_id==$zone['zone_id']){?> selected="selected"<?php  } }else { if($zone['zone_id']== set_value('zone_id')){ echo "selected='selected' ";}  }?>><?php  echo $zone['zone_name'];?></option>
             <?php } ?>
           </select> 
            
            </td>
      	</tr><?php */?>
       
		<tr >
      		<td>Status<font color="#FF0000">*</font></td>
      		<td>
           <select name="worker_status" id="worker_status"   class="form-control"  >
           	 <option value="0">SELECT</option>
           	<?php foreach($array_status as $status){?>
               <option value="<?php  echo $status['status_id'];?>" 
			   <?php if(isset($worker_status)){
			   if($worker_status==$status['status_id']){?> selected="selected"<?php } }
			   else if(set_value('worker_status')){ 
			   if($status['status_id']== set_value('worker_status')){ echo "selected='selected' ";}  }
			   else{ 
			   
			   		if($status['status_id']==1){ echo "selected='selected' ";} 
			   
			   }?>><?php  echo $status['status_name'];?></option>
             <?php } ?>
           </select> 
           </td>
      	</tr>

	  </table>
  		 
 		<div class="form-group">
            <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
                <input type="hidden" name="hId" value="<?php  if(isset($worker_id)){echo $worker_id;}?>" />
				<?php if(isset($worker_id)){?>
                    <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />
                <?php } else{?>
                    <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save"/>
        
                <?php } ?>
                <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
            </div>
        </div>
	<?php echo form_close(); ?>
<!--          </div>
            </div>
-->			 </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->
  </div>
