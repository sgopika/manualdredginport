<?php
//print_r($_REQUEST);
?>
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
 <link rel="stylesheet" href=<?php echo base_url("assets/datepicker-bootsrap/css/datepicker3.css"); ?>>
   <script src="<?php echo base_url('assets/datepicker-bootsrap/js/bootstrap-datepicker.js');?>"></script>
   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>
      <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>
	   <script src=<?php echo base_url("assets/aadhar/Verhoeff.js");?>></script>
	  <script type="text/javascript">
	  
	 	$(document).ready(function()
			  {
			  
			  $("#customer_aadhar_number").change(function()
       		{
            	var strVal = $("#customer_aadhar_number").val();
            	if (strVal.length < 12) // Minimum length.
            {
             	 alert("UID less than 12 digit");
				  $("#customer_aadhar_number").val('');
				 $( "#customer_aadhar_number" ).focus();
            }
			else if(strVal.verhoeffCheck() == false){
               alert("Invalid Aadhar Number");
                $("#customer_aadhar_number").val('');
				 $( "#customer_aadhar_number" ).focus();
            }
			else if(strVal.verhoeffCheck() == true) {
				//alert('hhh');	
				$.post("<?php echo $site_url?>/Master/check_CustomerAddhar",{adhar_no:strVal},function(data)
				{	
				//$('#daterangearray').html(data);
					if(data == false){
						alert("Aadhar Number no already exists");
						$("#customer_aadhar_number").val('');$("#customer_aadhar_number").focus();exit;
					}
				});
		}
       });
			  
			  
			  
				$('#rangeoffice').change(function()
				{
					var rangeoffice=$('#rangeoffice').val();
					$.post("<?php echo $site_url?>/Master/getUnitAjax/",{range_office:rangeoffice},function(data)
						{
							$('#unit').html(data);
						});
				});

			

		 jQuery.validator.addMethod("nospecial", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);
			},$.validator.format("<font color='red'>No Special characters allowed.</span>")); 
			   	
			jQuery.validator.addMethod("namewithspace", function(value, element) {
			return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
			},$.validator.format("<font color='red'>Characters and Space allowed.</span>"));
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
			  
		},$.validator.format("<font color='red'>Check your E-mail ID.</span>")); 
		jQuery.validator.addMethod("exactlength", function(value, element, param) {
		 		return this.optional(element) || value.length == param;
			}, $.validator.format("<font color='red'>Please enter exactly {0} characters.</span>"));
			
	 $('#customerregistration_add').validate(
		         {
			     rules:
			         { 
				  		customer_aadhar_number:{required:true,
						nospecial:true,
						exactlength:12,
							},
		 				customer_name:{required:true,
						namewithspace:true,
						nospecial:true,
							},
							 customer_phone_number:{required:true,
							exactlength:10,
							nospecial:true,
							digits: true,
							
							},
							 customer_email:{required:true,
							 email_check:true,
							 },
							 customer_perm_house_number:{required:true,},
							 customer_perm_house_name:{required:true,namewithspace:true,nospecial:true,},
							 customer_perm_place:{required:true,namewithspace:true,nospecial:true,},
							 customer_perm_post_office:{required:true,},
							 customer_perm_pin_code:{required:true,},
							 customer_perm_district_id:{required:true,},
							 customer_perm_lsg_id:{required:true,},
							 customer_work_house_name:{required:true,namewithspace:true,nospecial:true,},
							 customer_work_place:{required:true,namewithspace:true,nospecial:true,},
							 customer_work_post_office:{required:true,},
							 customer_work_pin_code:{required:true,},
							 customer_work_district_id:{required:true,},
							 customer_work_lsg_id:{required:true,},
							 customer_purpose:{required:true,},
							 customer_plinth_area:{required:true,},
							 customer_max_allotted_ton:{required:true,},
							 customer_permit_number:{required:true,},
							 customer_permit_date:{required:true,},
							 customer_permit_authority:{required:true,namewithspace:true,nospecial:true,},
							 customer_worksite_route:{required:true,},
							 customer_worksite_distance:{required:true,digits: true,},
							  customer_unloading_place:{required:true,},
							 filereg1:{required:true,},
							 filereg2:{required:true,},
							 customer_port_id:{required:true,},
							  
				
				     },
					 
			  messages:
			         {
						customer_aadhar_number:{required:"<font color='red'>Aadhaar Number required !!!</font>",
							},
		 				customer_name:{required:"<font color='red'>Customer Name required !!!</font>",
						//  nospecial:true,
							},
							 customer_phone_number:{required:"<font color='red'>Phone Number required !!!</font>",
							},
							 customer_email:{required:"<font color='red'>Email Id required !!!</font>",},
							 customer_perm_house_number:{required:"<font color='red'>Permanent House Number required !!!</font>",},
							 customer_perm_house_name:{required:"<font color='red'>Permanent House Name required !!!</font>",},
							 customer_perm_place:{required:"<font color='red'>Permanent Place required !!!</font>",},
							 customer_perm_post_office:{required:"<font color='red'>Permanent Post Office required !!!</font>",},
							 customer_perm_pin_code:{required:"<font color='red'>Permanent Pincode required !!!</font>",},
							 customer_perm_district_id:{required:"<font color='red'>Please select District !!!</font>",},
							 customer_perm_lsg_id:{required:"<font color='red'>Please select Panchayath !!</font>",},
							 customer_work_house_name:{required:"<font color='red'>Working House Name required !!!</font>",},
							 customer_work_place:{required:"<font color='red'>Working Place required !!!</font>",},
							 customer_work_post_office:{required:"<font color='red'>Working Post Office required !!!</font>",},
							 customer_work_pin_code:{required:"<font color='red'>Working Pincode required !!!</font>",},
							 customer_work_district_id:{required:"<font color='red'>Working District required !!!</font>",},
							 customer_work_lsg_id:{required:"<font color='red'>Please select Panchayath !!!</font>",},
							 customer_purpose:{required:"<font color='red'>Please select Customer Purpose !!!</font>",},
							 customer_plinth_area:{required:"<font color='red'>Plinth Area required !!!</font>",},
							 customer_max_allotted_ton:{required:"<font color='red'>Max. Allotted Ton required !!!</font>",},
							 customer_permit_number:{required:"<font color='red'>Permit Number required !!!</font>",},
							 customer_permit_date:{required:"<font color='red'>Permit Date required !!!</font>",},
							 customer_permit_authority:{required:"<font color='red'>Permit Authority required !!!</font>",},
							 customer_worksite_route:{required:"<font color='red'>Worksite Route required !!!</font>",},
							 customer_worksite_distance:{required:"<font color='red'>Working Distance required !!!</font>",},
							  customer_unloading_place:{required:"<font color='red'>Working Distance required !!!</font>",},
							  filereg1:{required:"<font color='red'>Aadhar Copy required !!!</font>",},
							  filereg2:{required:"<font color='red'>Building Permit Copy required !!!</font>",},
							
							 customer_port_id:{required:"<font color='red'>Please select Port !!!</font>",},
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

	$('#customer_perm_post_office').change(function()
				{
					var customerperm_post_office=$('#customer_perm_post_office').val();
					
					$.post("<?php echo $site_url?>/Master/getPermPincode/",{custmer_perm_postoff:customerperm_post_office},function(data)
						{
						
							$('#permpincode').html(data);
						});
				});
				$('#customer_work_post_office').change(function()
				{
					var customerwork_post_office=$('#customer_work_post_office').val();
					$.post("<?php echo $site_url?>/Master/getWorkPincode/",{customerwork_post_office:customerwork_post_office},function(data)
						{
						
							$('#workpincodenew').html(data);
						});
				});
				
				$('#customer_perm_district_id').change(function()
				{
			
					var customer_perm_distid=$('#customer_perm_district_id').val();
					
					$.post("<?php echo $site_url?>/Master/getPanchayathAjaxcustomerperm/",{customer_perm_distid:customer_perm_distid},function(data)
						{
						//alert(data);
 							$('#displayone').html(data);
						});
				});
				$('#customer_work_district_id').change(function()
				{
					var customerwork_distid=$('#customer_work_district_id').val();
					//var customerwork_post_office=$('#customer_work_post_office').val();
					$.post("<?php echo $site_url?>/Master/getPanchayathAjaxcustomerwork/",{customerwork_distid:customerwork_distid},function(data)
						{
							$('#displaytwo').html(data);
						});
				});
				
				$('#customer_max_allotted_ton').change(function()
				{
					var requestedton=$('#customer_max_allotted_ton').val();
					var construct_masterid=$('#customer_purpose').val();
					
					$.post("<?php echo $site_url?>/Master/Checkallotedton/",{requestedton:requestedton,construct_masterid:construct_masterid},function(data)
						{
					//	alert(data);
						if(data==1){document.getElementById("lbldisplay").innerHTML ='';}else{ alert("Please enter request ton"); $( "#customer_max_allotted_ton" ).val('');$( "#customer_max_allotted_ton" ).focus();}
							
						});
				});
				
				
});
function validate_chk()
{			
     		checked = document.querySelectorAll('input[type="checkbox"]:checked').length;
			if(checked<1) 
			{
				document.getElementById('scnDiv').innerHTML="<font color='red'><b>Atleast one Section to be selected!!!</b></font>";
				return false;
			}
}
function showSection(val)
{
		var x = document.getElementById("unitname").selectedIndex;
		var y = document.getElementById("unitname").options;
		unit_name = y[x].text;
		//alert(unit_name);
	if(unit_name=="DIRECTORATE")
	{
		document.getElementById('section_id').style.display='';
	}else
	{
		document.getElementById('section_id').style.display='none';
	}
}
//---------------------------------------not added in hari copy ---------------------16/06/2017------------------------------------------- 
function maxton_calculate()
{
	var plintharea=document.getElementById("customer_plinth_area").value;
	var max_ton=(plintharea*0.33).toFixed(2);

	if(max_ton>100)
	{
		alert("Plinth Area must be less than 303 ");
		document.getElementById("customer_plinth_area").value='';
		document.getElementById("customer_max_allotted_ton").value='';
	}
	else
	{
		document.getElementById("customer_max_allotted_ton").value=max_ton;
	}
}
function checkconstruction()
{
	
	var purpose=document.getElementById("customer_purpose").value;
	if(purpose==1)
	{
		$("#plintharea_tr").css("display","table-row");
		document.getElementById("customer_max_allotted_ton").value='';
		document.getElementById("lbldisplay").innerHTML ="";
		document.getElementById("lblpermit").innerHTML ="Upload Building Permit";
		document.getElementById("lblpermitno").innerHTML ="Building Permit Number";
		
	}
	else
	{
		$("#plintharea_tr").css("display","none");
		document.getElementById("customer_max_allotted_ton").value='';
		
		document.getElementById("lbldisplay").innerHTML ="Maximum Ton alloted is 6 !!!";
		document.getElementById("lblpermit").innerHTML ="Tax Receipt";
		document.getElementById("lblpermitno").innerHTML ="Tax Receipt Number";
	}

}
function adduploadplace()
{
var workplace=document.getElementById("customer_work_place").value;
document.getElementById("customer_unloading_place").value=workplace;
}
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
   // $(".select2").select2();

    //Datemask dd/mm/yyyy
    //$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
   // $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
   // $("[data-mask]").inputmask();

 $("#start_date").datepicker();
  });
  
 
</script>

    <section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?>
         <strong>Customer</strong></button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>"> Master</a></li>
		 <li><strong>Customer Registration </strong></li>
        <li><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?></strong></a><a href="<?php echo site_url("Master/customerregistration_add"); ?>"><strong>Customer Registration</strong></a></li>
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
              <a href="<?php echo site_url("Master/customerregistration_message"); ?>"><strong>Customer Registration</strong></a>
			  
			  </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "customerregistration_add", "name" => "customerregistration_add", "enctype"=> "multipart/form-data");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "customerregistration_add", "name" => "customerregistration_add", "onSubmit" => "return validate_chk();", "enctype"=> "multipart/form-data");
			}
        // echo form_open_multipart("registration/upload_byelawform_view/$society_id",$attributes);
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		//if(isset($int_userpost_sl)){
       	//	echo form_open_multipart("Master/customerregistration_add", $attributes);
		//} else {
			echo form_open("Master/customerregistration_add", $attributes);
		//}?>
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		
              <table id="vacbtable" class="table table-bordered table-striped">

     
        <tr >
      		<td>Aadhar Number<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_aadhar_number" value="<?php if(isset($customer_aadhar_number )){echo $customer_aadhar_number;} else { echo set_value('customer_aadhar_number');} ?>" id="customer_aadhar_number"  class="form-control"  maxlength="12" autocomplete="off" required/> </td>
      	</tr>
        
        <tr >
      		<td>Name<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_name" value="<?php if(isset($customer_name )){echo $customer_name;} else { echo set_value('customer_name');} ?>" id="customer_name"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
      	</tr>
        
        <tr >
      		<td>Mobile Number <font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_phone_number" value="<?php if(isset($customer_phone_number )){echo $customer_phone_number;} else { echo set_value('customer_phone_number');} ?>" id="customer_phone_number"  class="form-control"  maxlength="10"  autocomplete="off" required/> </td>
      	</tr>
        
        <tr >
      		<td>Email<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_email" value="<?php if(isset($customer_email )){echo $customer_email;} else { echo set_value('customer_email');} ?>" id="customer_email"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
      	</tr>
        
         <tr >
      		<td colspan="2" align="center" style="background-color:#9BDADD"><font color="#330099" style="text-align:center; font-weight:bold;">Present Address Details</font></td>
		</tr>
        
        <tr >
      		<td>House Number<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_perm_house_number" value="<?php if(isset($customer_perm_house_number )){echo $customer_perm_house_number;} else { echo set_value('customer_perm_house_number');} ?>" id="customer_perm_house_number"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
      	</tr>
        
        <tr >
      		<td>House Name<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_perm_house_name" value="<?php if(isset($customer_perm_house_name )){echo $customer_perm_house_name;} else { echo set_value('customer_perm_house_name');} ?>" id="customer_perm_house_name"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
      	</tr>
        
         <tr >
      		<td>Place<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_perm_place" value="<?php if(isset($customer_perm_place )){echo $customer_perm_place;} else { echo set_value('customer_perm_place');} ?>" id="customer_perm_place"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
      	</tr>
        
		<tr >
		<tr >
      		<td>District<font color="#FF0000">*</font></td>
      		<td>
          <select name="customer_perm_district_id" id="customer_perm_district_id"   class="form-control"  >
           	 <option value="">SELECT</option>
           	<?php foreach($array_perm_dist_id as $perm_distid){?>
			
			<option value="<?php  echo $perm_distid['district_id'];?>" <?php if(isset($customer_perm_district_id)){
			   if($customer_perm_district_id==$perm_distid['district_id']){?> selected="selected"<?php  } }else { if($perm_distid['district_id']== set_value('customer_perm_district_id')){ echo "selected='selected' ";}  }?>><?php  echo $perm_distid['district_name'];?></option>
             <?php } ?>
	        </select> 
           </td>
      	</tr>
		 <tr><td id="displayone" colspan="2" >
		<table width="95%" class="table table-bordered table-striped">
		<tr  >
      		<td width="41%">Local Body<font color="#FF0000">*</font></td>
      		<td >
            <select name="customer_perm_lsg_id" id="customer_perm_lsg_id"   class="form-control"  >
           	 <option value="">SELECT</option>
           	<?php foreach($array_localbody as $perm_localbody){?>
			
			<option value="<?php  echo $perm_localbody['panchayath_sl'];?>" <?php if(isset($customer_perm_lsg_id)){
			   if($customer_perm_lsg_id==$perm_localbody['panchayath_sl']){?> selected="selected"<?php  } }else { if($perm_localbody['panchayath_sl']== set_value('customer_perm_lsg_id')){ echo "selected='selected' ";}  }?>><?php  echo $perm_localbody['panchayath_name'];?></option>
             <?php } ?>
		  </select> 
           </td>
      	</tr>
		<tr>
      		<td>Post Office <font color="#FF0000">*</font></td>
      		<td>
           <select name="customer_perm_post_office" id="customer_perm_post_office"   class="form-control"  >
           	 <option value="">SELECT</option>
           		<?php foreach($array_perm_postoff_id as $perm_postoff_id){?>
               	<option value="<?php  echo $perm_postoff_id['PostOfficeId'];?>" <?php if(isset($customer_perm_post_office)){
			   if($customer_perm_post_office==$perm_postoff_id['PostOfficeId']){?> selected="selected"<?php  } }else { if($perm_postoff_id['PostOfficeId']== set_value('customer_perm_post_office')){ echo "selected='selected' ";}  }?>><?php  echo $perm_postoff_id['vchr_BranchOffice'];?></option>
             <?php } ?>
           </select> 

            </td>
      	</tr>
		</table></td></tr>
           <tr >
      		<td width="41%">Pincode<font color="#FF0000">*</font></td>
      		<td id="permpincode"><input type="text" name="customer_perm_pin_code" value="<?php if(isset($customer_perm_pin_code )){echo $customer_perm_pin_code;} else { echo set_value('customer_perm_pin_code');} ?>" id="customer_perm_pin_code"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
      	</tr>
          <tr >
      		<td colspan="2" align="center" style="background-color:#9BDADD"><font color="#330099" style="text-align:center; font-weight:bold;">Work Site Address Details</font></td>
		</tr>
     
        <tr >
            <td>Site Address/ House Name<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_work_house_name" value="<?php if(isset($customer_work_house_name )){echo $customer_work_house_name;} else { echo set_value('customer_work_house_name');} ?>" id="customer_work_house_name"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
        
         <tr >
            <td>Place<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_work_place" value="<?php if(isset($customer_work_place )){echo $customer_work_place;} else { echo set_value('customer_work_place');} ?>" id="customer_work_place"  class="form-control"  maxlength="100" onchange="adduploadplace()"  autocomplete="off" required/> </td>
        </tr>
        <tr  >
            <td>District<font color="#FF0000">*</font></td>
            <td >
           <select name="customer_work_district_id" id="customer_work_district_id"   class="form-control"  >
             <option value="">SELECT</option>
            <?php foreach($array_perm_dist_id as $districtcode){?>
				<option value="<?php  echo $districtcode['district_id'];?>" <?php if(isset($customer_work_district_id)){
			   if($customer_work_district_id==$districtcode['district_id']){?> selected="selected"<?php  } }else { if($districtcode['district_id']== set_value('customer_work_district_id')){ echo "selected='selected' ";}  }?>><?php  echo $districtcode['district_name'];?></option>
             <?php } ?>
	           
           </select> 
           </td>
        </tr>
		<tr><td id="displaytwo" colspan="2" >
		<table width="95%" class="table table-bordered table-striped">
		<tr >
            <td width="41%">Local Body<font color="#FF0000">*</font></td>
            <td>
          <select name="customer_work_lsg_id" id="customer_work_lsg_id"   class="form-control"  >
             <option value="">SELECT</option>
            <?php foreach($array_localbody as $work_localbody){?>
			<option value="<?php  echo $work_localbody['panchayath_sl'];?>"  <?php if(isset($customer_work_lsg_id)){
			   if($customer_work_lsg_id==$work_localbody['panchayath_sl']){?> selected="selected"<?php  } }else { if($work_localbody['panchayath_sl']== set_value('customer_work_lsg_id')){ echo "selected='selected' ";}  }?>><?php  echo $work_localbody['panchayath_name'];?></option>
             <?php } ?>
          </select> 
           </td>
        </tr>
        <tr >
            <td>Post Office <font color="#FF0000">*</font></td>
            <td>
            <select name="customer_work_post_office" id="customer_work_post_office"   class="form-control"  >
             <option value="">SELECT</option>
                <?php foreach($array_perm_postoff_id as $work_post_off_id)
				{?>
					<option value="<?php  echo $work_post_off_id['PostOfficeId'];?>" <?php if(isset($customer_work_post_office)){
			   if($customer_work_post_office==$work_post_off_id['PostOfficeId']){?> selected="selected"<?php  } }else { if($work_post_off_id['PostOfficeId']== set_value('customer_work_post_office')){ echo "selected='selected' ";}  }?>><?php  echo $work_post_off_id['vchr_BranchOffice'];?></option>
             <?php } ?>
				
          </select> 
            
            </td>
        </tr>
        </table></td></tr>
         <tr >
            <td width="41%">Pincode<font color="#FF0000">*</font></td>
            <td  id="workpincodenew"><input type="text" name="customer_work_pin_code" value="<?php if(isset($customer_work_pin_code )){echo $customer_work_pin_code;} else { echo set_value('customer_work_pin_code');} ?>" id="customer_work_pin_code"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
       <tr >
            <td>Purpose <font color="#FF0000">*</font></td>
            <td>
           <select name="customer_purpose" id="customer_purpose"   class="form-control"  onchange="checkconstruction();">
             <option value="">SELECT</option>
			 
                <?php foreach($array_customer_pur as $customer_purpose_id){?>
               <option value="<?php  echo $customer_purpose_id['construction_master_id'];?>"  <?php if(isset($customer_purpose)){
			   if($customer_purpose==$customer_purpose_id['construction_master_id']){?> selected="selected"<?php  } }else { if($customer_purpose_id['construction_master_id']== set_value('customer_purpose')){ echo "selected='selected' ";}  }?>><?php  echo $customer_purpose_id['construction_master_name'];?></option>
             <?php } ?>
           </select> 
            
            </td>
        </tr>
        
        <tr id="plintharea_tr" style="display:none" >
            <td>Plinth Area (in sq.m)<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_plinth_area" value="<?php if(isset($customer_plinth_area )){echo $customer_plinth_area;} else { echo set_value('customer_plinth_area');} ?>" onchange="maxton_calculate();" id="customer_plinth_area"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
        
         <tr >
            <td>Maximum required ton<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_max_allotted_ton" value="<?php if(isset($customer_max_allotted_ton )){echo $customer_max_allotted_ton;} else { echo set_value('customer_max_allotted_ton');} ?>" id="customer_max_allotted_ton"  class="form-control"  maxlength="100"   autocomplete="off" required/> <label id="lbldisplay"></label></td>
        </tr>
        
        <tr >
            <td><label id="lblpermitno">Permit Number</label><font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_permit_number" value="<?php if(isset($customer_permit_number )){echo $customer_permit_number;} else { echo set_value('customer_permit_number');} ?>" id="customer_permit_number"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
        
        <tr >
      		 <td>Permit Date<font color="#FF0000">*</font></td>
      		<td>
         		<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
				  <?php
				  if(isset( $get_userposting_details[0]['dte_userpost_startdate'])){
				$dte_userpost_startdate = $get_userposting_details[0]['dte_userpost_startdate'];
					$start_date = explode('-', $dte_userpost_startdate);
					$start_date =$start_date[2]."-".$start_date[1]."-".$start_date[0];
				  }

					$start_date = set_value('customer_permit_date') == true ?  set_value('customer_permit_date'): @$customer_permit_date ; 
				  														
				  ?>
                <input type="text" class="form-control"  value="<?php echo @$start_date?>" name="customer_permit_date" id="start_date"  />
              </div>
				<span id="startdatediv" ></span>
            
            </td>
      	</tr>
        
        <tr >
            <td>Permit Authority <font color="#FF0000">*</font></td>
            <td>
           <?php /*?><select name="customer_permit_authority" id="customer_permit_authority"   class="form-control"  >
             <option value="">SELECT</option>
                <?php foreach($array_zone_id as $zone_id){?>
                <option value="<?php  echo $zone_id['zone_id'];?>" <?php if(isset($get_userposting_details[0]['int_userpost_designation_sl'])){
               if($get_userposting_details[0]['int_userpost_designation_sl']==$designation_get['int_designation_sl']){?> selected="selected"<?php  } }else { if($designation_get['int_designation_sl']== set_value('designation')){ echo "selected='selected' ";}  }?>><?php  echo $designation_get['vch_designation_name'];?></option>
             <?php } ?>
           </select> <?php */?>
            <input type="text" name="customer_permit_authority" value="<?php if(isset($customer_permit_authority )){echo $customer_permit_authority;} else { echo set_value('customer_permit_authority');} ?>"  id="customer_permit_authority"  class="form-control" readonly="true"  maxlength="100" autocomplete="off" required/>
            </td>
        </tr>
     
         <tr >
      		<td>Route to the worksite<font color="#FF0000">*</font></td>
      		 <td><textarea name="customer_worksite_route" id="customer_worksite_route" cols="45" rows="5" class="form-control" required><?php if(isset($customer_worksite_route )){echo $customer_worksite_route;} else { echo set_value('customer_worksite_route');} ?></textarea></td>
      	</tr>
        
        <tr >
            <td>Distance to the worksite<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_worksite_distance" value="<?php if(isset($customer_worksite_distance )){echo $customer_worksite_distance;} else { echo set_value('customer_worksite_distance');} ?>" id="customer_worksite_distance"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
        
        <tr >
            <td>Unloading place<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_unloading_place" value="<?php if(isset($customer_unloading_place )){echo $customer_unloading_place;} else { echo set_value('customer_unloading_place');} ?>" id="customer_unloading_place" readonly="true"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
        
        <tr >
            <td>Upload Aadhar<font color="#FF0000">*</font></td>
            <td ><input type="file" name="userfile[]"    required><!--<input id="btn_viewUpload" name="btn_viewUpload" type="file" class="btn btn-primary" value="Upload" /><input type="file" name="customer_aadhar_upload" id="customer_aadhar_upload"  accept="image/*" data-rule-required="true" data-msg-accept="Your message"  />--> </td>
        </tr>
        
        <tr >
            <td><label id="lblpermit">Upload Building Permit</label><font color="#FF0000">*</font></td>
            <td ><input type="file" name="userfile[]"   required ><!--<input id="btn_permitUpload" name="btn_permitUpload" type="file" class="btn btn-primary" value="Upload" /><input type="file" name="customer_building_permit_upload" id="customer_building_permit_upload"  accept="image/*" data-rule-required="true" data-msg-accept="Your message"   />--> </td>
        </tr>
        
        <tr >
            <td>Select the desired port<font color="#FF0000">*</font></td>
            <td>
           <select name="customer_port_id" id="customer_port_id"   class="form-control"  >
             <option value="">SELECT</option>
			
            <?php foreach($array_portmaster as $port_master_id){?>
			
			 <option value="<?php  echo $port_master_id['int_portoffice_id'];?>"  <?php if(isset($customer_port_id)){
			   if($customer_port_id==$port_master_id['int_portoffice_id']){?> selected="selected"<?php  } }else { if($port_master_id['int_portoffice_id']== set_value('customer_port_id')){ echo "selected='selected' ";}  }?>><?php  echo $port_master_id['vchr_portoffice_name'];?></option>
             <?php } ?>
               
           </select> 
           </td>
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