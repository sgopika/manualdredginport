<script>
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
</script><?php
//print_r($_REQUEST);
?>

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
		$.validator.addMethod("alpha", function(value, element) {
               return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
		});
		jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
		}); 
  		$("#addbank").validate({
		rules: {
				vch_bankname: {
					required: true,
					//no_special_check: true,
					alpha:true,
					maxlength: 20,
				},
				vch_branchname: {
					required: true,
					alpha:true,
					maxlength: 20,
				},
				vch_acno: {
					required: true,
					//no_special_check: true,
					number:true,
					maxlength: 20,
				},
				vch_ifsc: {
					required: true,
					alphanumeric: true,
					maxlength: 20,
				},
				vch_micr: {
					required: true,
					alphanumeric: true,
					//no_special_check: true,
					maxlength: 20,
				},
		},
		messages: {
				vch_bankname: {
					required: "<font color='#FF0000'> Bank Name required!!</font>",
					alpha: "<font color='#FF0000'> only alphabets allowed!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_branchname: {
					required: "<font color='#FF0000'> Branch Name Required!!</font>",
					alpha: "<font color='#FF0000'> only alphabets allowed!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_acno: {
					required: "<font color='#FF0000'> a/c no required!!</font>",
					number: "<font color='#FF0000'> only numbers allowed!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_ifsc: {
					required: "<font color='#FF0000'> IFSC Code Required!!</font>",
					alphanumeric: "<font color='#FF0000'> Alphanumeric characters only!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_micr: {
					required: "<font color='#FF0000'> MICR Code required!!</font>",
					alphanumeric: "<font color='#FF0000'> Alphanumeric characters only!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
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
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getUnitAjax/",{range_office:rangeoffice},function(data)
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
   <div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Bank Details</button>
		</div>
		
     <div class="col-12 d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
         <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/bank"); ?>"> Bank</a></li>
        <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Bank Details </strong></a></li>
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
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "addbank", "name" => "addbank", "onSubmit" => "return validate_chk();");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "addbank", "name" => "addbank", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Master/bank_pc_edit", $attributes);
		} else {
		echo form_open("Manual_dredging/Master/bank_add", $attributes);
			
		}?>
           
     <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">      
     			 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Bank Details</h3>
            
					<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo encode_url($int_userpost_sl);} ?>" />
					Bank Name<font color="#FF0000">*</font>
     		</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
              <input type="text" name="vch_bankname" value="<?php if(isset($int_userpost_sl)){ echo $bank[0]['bank_name'];} ?>" id="vch_bankname"  class="form-control"  maxlength="50" autocomplete="off" /> 
             </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           		<div class="col-md-6 d-flex justify-content-center px-2">Branch Name<font color="#FF0000">*</font></div>
           		<div class="col-md-4 d-flex justify-content-start px-2">
              <input type="text" name="vch_branchname" value="<?php if(isset($int_userpost_sl)){ echo $bank[0]['bank_branch_name'];} ?>" id="vch_branchname"  class="form-control"  maxlength="50" autocomplete="off" /> 
           </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           		<div class="col-md-6 d-flex justify-content-center px-2">Account Number<font color="#FF0000">*</font>
           		</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
              <input type="text" name="vch_acno" value="<?php if(isset($int_userpost_sl)){ echo $bank[0]['bank_account_number'];} ?>" id="vch_acno"  class="form-control"  maxlength="16" autocomplete="off" /> 
             </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           		<div class="col-md-6 d-flex justify-content-center px-2">IFSC Code<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
              <input type="text" name="vch_ifsc" value="<?php if(isset($int_userpost_sl)){ echo $bank[0]['bank_ifsc_code'];} ?>" id="vch_ifsc"  class="form-control"  maxlength="11" autocomplete="off" /> 
             </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           		<div class="col-md-6 d-flex justify-content-center px-2">MICR Code<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
              <input type="text" name="vch_micr" value="<?php if(isset($int_userpost_sl)){ echo $bank[0]['bank_micr_code'];} ?>" id="vch_micr"  class="form-control"  maxlength="11" autocomplete="off" />  </div>
		</div> <!-- end of row -->
           
	  <div class="row px-5">
 		
        <div class="col-12 d-flex justify-content-center">
        
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_userpost_sl)){?>
		
		 <input id="btn_add" name="btn_add" type="submit" class="px-4 btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class=" px-4 btn btn-primary" value="Save"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class=" mx-4 btn btn-danger" value="Cancel" />
     
         </div> <!-- end of col 12 -->
         
	</div> <!-- end of row -->
		<?php echo form_close(); ?>
</div> <!-- end of container -->
 <script>
  $(function () {
    //Initialize Select2 Elements
   // $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();


  });
</script>