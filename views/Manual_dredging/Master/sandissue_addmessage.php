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
				$.post("<?php echo $site_url?>/Manual_dredging/Master/check_CustomerAddhar",{adhar_no:strVal},function(data)
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
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getUnitAjax/",{range_office:rangeoffice},function(data)
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
			  
		});	
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
					
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getPermPincode/",{custmer_perm_postoff:customerperm_post_office},function(data)
						{
						
							$('#permpincode').html(data);
						});
				});
				$('#customer_work_post_office').change(function()
				{
					var customerwork_post_office=$('#customer_work_post_office').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getWorkPincode/",{customerwork_post_office:customerwork_post_office},function(data)
						{
						
							$('#workpincodenew').html(data);
						});
				});
				
				$('#customer_perm_district_id').change(function()
				{
			
					var customer_perm_distid=$('#customer_perm_district_id').val();
					
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getPanchayathAjaxcustomerperm/",{customer_perm_distid:customer_perm_distid},function(data)
						{
						//alert(data);
 							$('#displayone').html(data);
						});
				});
				$('#customer_work_district_id').change(function()
				{
					var customerwork_distid=$('#customer_work_district_id').val();
					//var customerwork_post_office=$('#customer_work_post_office').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getPanchayathAjaxcustomerwork/",{customerwork_distid:customerwork_distid},function(data)
						{
							$('#displaytwo').html(data);
						});
				});
				
				$('#customer_max_allotted_ton').change(function()
				{
					var requestedton=$('#customer_max_allotted_ton').val();
					var construct_masterid=$('#customer_purpose').val();
					
					$.post("<?php echo $site_url?>/Manual_dredging/Master/Checkallotedton/",{requestedton:requestedton,construct_masterid:construct_masterid},function(data)
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
	}
	else
	{
		$("#plintharea_tr").css("display","none");
		document.getElementById("customer_max_allotted_ton").value='';
		
		document.getElementById("lbldisplay").innerHTML ="Maximum Ton alloted is 6 !!!";
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

   
    <!-- Main content -->
    <div class="container-fluid ui-innerpage">
      <div class="row custom-inner">
        <div class="col-md-6">
          <!-- /.box -->
        <div class="box" >
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
		   
      <!--      </div> -->
		  
            
        <div class="box box-primary box-green-bottom">
            <div class="box-header " align="center">
              <h3 class="box-title" > <p align="center" ><strong>Sand Issue Details</strong></p></h3>  </div>
            <!-- /.box-header --><?php
			foreach($get_bookingapprovedadd as $messages)
			{
			$customerbookingid=$messages['customer_booking_id'];
			//$cutomername=$messages['customer_name'];
			$uidnumber=$messages['uid_no'];
			$tokenno=$messages['customer_booking_token_number'];
			$challanno=$messages['customer_booking_chalan_number'];
	
			$challandate=date("d/m/Y h:i:s", strtotime(str_replace('-', '/',$messages['challan_timestamp'] )));
			$challanamount=$messages['customer_booking_chalan_amount'];
			$transactiondate=$messages['transaction_ref_timestamp'];
			$transactionrefno=$messages['transaction_refno'];
			$transactionamount=$messages['transaction_amount'];
			
			}
			/*  if($customerregid!='')
			  {*/
			  ?>
			  
			
			  <table  style="margin:10px; padding:10px;" width="95%" >
			 <tr><td style="border:1px solid #0000CC;" colspan="4"><table style="margin:10px" width="90%">
			  <tr><td></td><td></td><td>UID No:</td><td><?php echo $uidnumber; ?></td></tr>
			  <tr><td>Token No:</td><td><?php echo $tokenno; ?></td><td></td><td></td></tr>
			   <tr>
			     <td>Challan No: </td><td><?php echo $challanno; ?></td><td>Challan Date :</td><td> <?php echo $challandate; ?></td></tr>
			    <tr>
			      <td>Challan Amount : </td><td><font color="#CC0000"><?php echo $challanamount; ?></font></td><td> </td><td> </td></tr>
				 <tr>
				   <td> Remitted Amount:</td><td><?php echo $transactionamount; ?></td><td> </td><td> </td></tr>
					  <tr>
				    <td> Transaction Reference Number:</td><td><?php echo $transactionrefno; ?></td><td> </td><td> </td></tr>
				   <tr>
				     <td> Transaction Date:</td><td><?php echo date("d-m-Y H:i:s",strtotime(str_replace('-', '/',$transactiondate))); ?></td><td> </td><td> </td></tr>
				    <tr>
				      <td> Transaction Amount:</td><td><font color="#CC0000"><?php echo $transactionamount; ?></font></td><td> </td><td> </td></tr>
					   </table></td></tr>
					   <br/>
					 <tr><td colspan="4" align="right"> <?php if($transactionamount>=$challanamount){?> <a href="<?php echo $site_url.'/Manual_dredging/Master/sand_issue_add/'.encode_url($customerbookingid);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; NEXT   </button></a><?php }else{ ?><font color="#CC0000"><?php echo "Transaction Amount is less than Challan Amount ";?> </font><?php } ?></td></tr>
			  </table>
			 <br/>
			 <?php /*?> <?php 
			  }else { ?> <p><font color="#CC3300" >Customer Registration failed!!!</font></p><?php }<?php */?>
			 
			  
			  
          
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