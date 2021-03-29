<?php
//print_r($_REQUEST);
?>

  <link rel="stylesheet" href=<?php echo base_url("assets/plugins/datepicker/datepicker3.css"); ?>>
  <script src=<?php echo base_url("assets/datepicker-bootsrap/js/bootstrap-datepicker.js");?>></script>
   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>
   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>
	<script type="text/javascript">
	 	$(document).ready(function() {
		jQuery.validator.addMethod("no_special_check", function(value, element) {
        	return this.optional(element) || /^[a-zA-Z0-9\s.-]+$/.test(value);
		});
		jQuery.validator.addMethod("name_check", function(value, element) {
        	return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
		});
		jQuery.validator.addMethod("act_check",function (value,element)    {
			return this.optional(element)||/^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s]+$/.test(value);
		});
		jQuery.validator.addMethod("address_check",function (value,element)    {
			return this.optional(element)||/^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s\,]+$/.test(value);
		});
		jQuery.validator.addMethod("email_check", function(value, element)	 {
			  return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
		});
  		$("#police_case_add").validate({
		rules: {
				bukid: {
					required: true,
				},
				txttokenno: {
					required: true,
					no_special_check: true,
				},
				txtpolicestnname: {
					required: true,
					no_special_check: true,
				},
				txtpolicestnname: {
					required: true,
			    	no_special_check: true,
				},
				txtletterdate: {
					required: true,
					//no_special_check: true,
				},
				txtletterno: {
					required: true,
					no_special_check: true,
			    	//no_special_check: true,
				},
				txtrefno: {
					required: true,
					no_special_check: true,
			    	//no_special_check: true,
				},
				txtofficedetails: {
					required: true,
			    	no_special_check: true,
				},
				retxtrefno: {
					required: true,
					no_special_check: true,
			    	//no_special_check: true,
				},
				retxtrefdate: {
					required: true,
					//no_special_check: true,
				},
		},
		messages: {
				bukid: {
					required: "<font color='#FF0000'> Booking ID required!!</font>",
				},
				txttokenno: {
					required: "<font color='#FF0000'> Token No required!!</font>",
					no_special_check:"<font color='#FF0000'> No Special Characters allowed!!</font>",
				},
				txtpolicestnname: {
					required: "<font color='#FF0000'> Police Station Name required!!</font>",
					no_special_check:"<font color='#FF0000'> No Special Characters allowed!!</font>",
				},
				txtletterdate: {
					required: "<font color='#FF0000'> Letter Date required!!</font>",
					//no_special_check:"<font color='#FF0000'> No Special Characters allowed!!</font>",txtrefno
				},
				txtletterno: {
					required: "<font color='#FF0000'> Letter Number required!!</font>",
					no_special_check:"<font color='#FF0000'> No Special Characters allowed!!</font>",txtrefno
				},
				txtrefno: {
					required: "<font color='#FF0000'> Refferance Number required!!</font>",
					no_special_check:"<font color='#FF0000'> No Special Characters allowed!!</font>",txtrefno
				},
				txtofficedetails: {
					required: "<font color='#FF0000'> Officer Details required!!</font>",
					no_special_check:"<font color='#FF0000'> No Special Characters allowed!!</font>",txtrefno
				},
				retxtrefno: {
					required: "<font color='#FF0000'> Replay Reference Number required!!</font>",
					no_special_check:"<font color='#FF0000'> No Special Characters allowed!!</font>",txtrefno
				},
				retxtrefdate: {
					required: "<font color='#FF0000'> Replaied Date required!!</font>",
					//no_special_check:"<font color='#FF0000'> No Special Characters allowed!!</font>",txtrefno
				},
		},
    	errorElement: "span",
        errorPlacement: function(error, element) {
                error.appendTo(element.parent());
        }

 		});
	
	});
</script>  
<script>
function check_dates(){
	    var start_date = document.getElementById("start_date").value;
		var end_date = document.getElementById("end_date").value;
		//alert(start_date);
		//alert(end_date);
		if((start_date=="")&&(end_date==""))
		{
				document.getElementById('startdatediv').innerHTML="<font color='red'><b>Please Enter Start date and End date!!!</b></font>";
				document.getElementById('enddatediv').innerHTML="";
		}
		else if((start_date=="")&&(end_date!=""))
		{
				document.getElementById('startdatediv').innerHTML="<font color='red'><b>Please Enter Start date!!!</b></font>";
				document.getElementById('enddatediv').innerHTML="";
		}
		else if((start_date!="")&&(end_date==""))
		{
				document.getElementById('enddatediv').innerHTML="<font color='red'><b>Please Enter end date!!!</b></font>";
				document.getElementById('startdatediv').innerHTML="";
		}
		else
		{	
			 var startdate 	= start_date.split('/');
			 startdate 	= new Date(startdate[2], startdate[1], startdate[0]); 
			 var enddate 	= end_date.split('/'); 
			 enddate 	= new Date(enddate[2], enddate[1], enddate[0]); 
			 if (startdate > enddate ) { 
			 	document.getElementById("start_date").value='';
				document.getElementById("end_date").value='';
				document.getElementById('enddatediv').innerHTML="<font color='red'><b>Start Date Cannot be greater than end date!!!</b></font>";
				document.getElementById('startdatediv').innerHTML="";
				return false; 
			} else {
				document.getElementById('startdatediv').innerHTML="";
				document.getElementById('enddatediv').innerHTML="";
			}
		}
}
			

</script>
<script type="text/javascript">
$(document).ready(function()
{
	$('#rangeoffice').change(function()
				{
					var rangeoffice=$('#rangeoffice').val();
					$.post("<?php echo $site_url?>/Master/getUnitAjax/",{range_office:rangeoffice},function(data)
						{
							$('#unit').html(data);
						});
				});
});
function validate_chk(){			
     	checked = document.querySelectorAll('input[type="checkbox"]:checked').length;
			if(checked<1) {
				document.getElementById('scnDiv').innerHTML="<font color='red'><b>Atleast one Section to be selected!!!</b></font>";
				return false;
			}
}
function showSection(val){
		var x = document.getElementById("unitname").selectedIndex;
		var y = document.getElementById("unitname").options;
		unit_name = y[x].text;
		//alert(unit_name);
	if(unit_name=="DIRECTORATE"){
		document.getElementById('section_id').style.display='';
	}else{
		document.getElementById('section_id').style.display='none';
	}
}
 

</script>
    <section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?>
         <strong>Communication </strong> </button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>"> Master</a></li>
		 <li><a href="<?php echo site_url("Master/police_view_pc"); ?>"><strong>Communication</strong></a></li>
        <li><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?></strong></a><a href="<?php echo site_url("Master/canoeRegistration"); ?>"><strong>&nbsp;Communication</strong></a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
        <div class="col-md-9">
          <!-- /.box -->
        <div class="box" >
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      <!--      </div> -->
		  
            
        <div class="box box-primary box-blue-bottom">
            <div class="box-header ">
              <h3 class="box-title"><?php
			
			   if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?>
              <a href="<?php echo site_url("Master/customer_requestprocessing_add"); ?>"><strong>Communication</strong></a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "police_case_add", "name" => "police_case_add", "onSubmit" => "return validate_chk();");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "police_case_add", "name" => "police_case_add", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl))
		{
       		echo form_open("Master/police_view_pc", $attributes);
		} 
		else 
		{
			echo form_open("Master/police_view_pc", $attributes);
		}
		if(isset($int_userpost_sl))
		{
		?>
        
		<input type="hidden" name="hid" value="<?php  echo encode_url($int_userpost_sl); ?>" />
        
        <?php
		} 
		?>
		
              <table id="vacbtable" class="table table-bordered table-striped">
              <tr >
      		<td>Booking ID<font color="#FF0000">*</font></td>
      		<td>
            <select name="bukid"  id="bukid"  class="form-control"  maxlength="100" <?php if(isset($int_userpost_sl)){?> disabled="disabled"<?php } ?>> 
            <option value="" selected="selected">--select--</option>
            <?php
			foreach($get_cus_buk as $bid)
			{
				?>
                <option value="<?php echo $bid['customer_booking_id']; ?>" <?php if(isset($int_userpost_sl)){
					 if($bid['customer_booking_id']==$police[0]['police_case_booking_id']){?> selected="selected"<?php } }?>>
					 <?php echo $bid['customer_booking_token_number']; ?>
                     </option>
                <?php
			}
			?>
            </select>
            </td>
      	</tr>
		<tr >
      		<td>Token Number<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="txttokenno"  id="txttokenno" <?php if(isset($int_userpost_sl)){?> disabled="disabled" value="<?php echo $police[0]['police_case_token_number'];?>"<?php } ?> class="form-control"  maxlength="100" autocomplete="off" required/> </td>
      	</tr>
		<tr >
       		<td>Police Station Name<font color="#FF0000">*</font></td>
      		<td><textarea name="txtpolicestnname" id="txtpolicestnname" class="form-control"  maxlength="100" <?php if(isset($int_userpost_sl)){?> disabled="disabled"<?php }?>> <?php if(isset($int_userpost_sl)){ echo $police[0]['police_case_office'];  } ?></textarea></td>
      	</tr>
		 <tr >
  
      		<td>Letter Date<font color="#FF0000">*</font></td>
      		<td><div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div><input type="text" class="form-control"  <?php if(isset($int_userpost_sl)){?> disabled="disabled" value="<?php echo $police[0]['police_case_letter_date'];?>"<?php } ?> name="txtletterdate" id="txtletterdate" data-inputmask="'alias': 'dd/mm/yyyy'" onChange="check_dates();" data-mask>
           </td>
      	</tr>
		<tr >
      		<td>Letter Number<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="txtletterno"  id="txtletterno" <?php if(isset($int_userpost_sl)){?> disabled="disabled" value="<?php echo $police[0]['police_case_letter_number'];?>"<?php } ?>  class="form-control"  maxlength="100" autocomplete="off" required/> </td>
      	</tr>
		<tr >
		<tr >
      		<td>Reference Number<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="txtrefno"  id="txtrefno" <?php if(isset($int_userpost_sl)){?> disabled="disabled" value="<?php echo $police[0]['police_case_reference_number'];?>"<?php } ?>  class="form-control"  maxlength="100" autocomplete="off" required/> </td>
      	</tr>
		<tr >
      
			
        <tr >
  
      		<td>Officer Details<font color="#FF0000">*</font></td>
      		<td><textarea name="txtofficedetails" id="txtofficedetails" class="form-control"  maxlength="100"<?php if(isset($int_userpost_sl)){?> disabled="disabled"<?php }?>> <?php if(isset($int_userpost_sl)){ echo $police[0]['police_case_ofiicer_details'];  } ?></textarea>
           </td>
      	</tr>
		<tr >
      		<td>Replied Reference Number<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="retxtrefno"  id="retxtrefno" <?php if(isset($int_userpost_sl)&&$police[0]['police_case_replied_reference_number']!=''){?> disabled="disabled" value="<?php echo $police[0]['police_case_replied_reference_number'];?>"<?php } ?>  class="form-control"  maxlength="100" autocomplete="off" required/> </td>
      	</tr>
		<tr >
      		<td>Reply Date<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="retxtrefdate"  id="retxtrefdate" <?php if(isset($int_userpost_sl)&&$police[0]['police_case_replied_date']!=''){?> disabled="disabled" value="<?php echo $police[0]['police_case_replied_date'];?>"<?php } ?>  class="form-control"  maxlength="100" autocomplete="off" required/> </td>
      	</tr>
	  </table>
  		 
 		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_designation_sl)){?>
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
  </section>
  <script>
  $(function(){
	  $("#retxtrefdate").datepicker();
	  $("#txtletterdate").datepicker();
	  });
  </script>