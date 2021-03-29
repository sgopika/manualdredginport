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
			
				
				
	 $('#sand_issue').validate(
		         {
			     rules:
			         { 
				  user:{required:true,
				//  nospecial:true,
							},
		 designation:{required:true,
				//  nospecial:true,
							},
							 usergroup:{required:true,
				//  nospecial:true,
							},
							 rangeoffice:{required:true,},
							 unitname:{required:true,},
							start_date:{required:true,},
							  end_date:{required:true,},
				
				     },
					 
			  messages:
			         {
						
						user:{required:"<font color='red'>Please select user</span>",
						},	
						designation:{required:"<font color='red'>Please select designation</span>",
						},
						usergroup:{required:"<font color='red'>Please select user group</span>",
						},	
						rangeoffice:{required:"<font color='red'>Please select range</span>",},
						start_date:{required:"<font color='red'>Please select start date</span>",},
						end_date:{required:"<font color='red'>Please select end date</span>",},
						unitname:{required:"<font color='red'>Please select unit</span>",},

									
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
 <!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Sand Pass Reprint</span>
	</div>  <!-- end of col4 -->
	<?php 
	$sess_user_type			=	$this->session->userdata('int_usertype');
	 //echo "fff".$sess_user_type;
	if($sess_user_type==3)
	{ 
		$url=site_url("Manual_dredging/Master/pcdredginghome");
	 }
	  else
	   {
	    $url=site_url('Manual_dredging/Port/port_clerk_main');
	}
	?>
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Sand Pass Reprint Approval</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>

             <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>


   
            
        <div class="row">
            <div class="col-md-9">
              <h3 class="box-title"><?php
			
			   if(isset($int_userpost_sl)){?>Edit<?php } else {?> <?php }?>
              <a href="<?php echo site_url("Manual_dredging/Master/sand_issue_add"); ?>"><strong>Sand Issue Pass Request</strong></a></h3>
			 
            </div>
          
            <?php 
			
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "sand_issue_add", "name" => "sand_issue_add");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "sand_issue_add", "name" => "sand_issue_add", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Master/sand_issue_reprintApproval", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/sand_issue_reprintApproval", $attributes);
		}
		foreach($datareprintview as $rowmodule){ 
		$customer_regn_id	=	$rowmodule['customer_registration_id'];
		
		$datacustreg=$this->Master_model->get_cust_det($customer_regn_id);
		
		$customer_name=$datacustreg[0]['customer_name'];
		$customer_aadhar_number=$datacustreg[0]['customer_aadhar_number'];
		$customer_max_allotted_ton=$datacustreg[0]['customer_max_allotted_ton'];
		  ?>

		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		<input type="hidden" id="bid" name="bid" value="<?php echo $datareprintview[0]['transaction_customer_booking_id']; ?>" />
      	<input type="hidden" name="hid_passid" id="hid_passid" value="<?php echo $rowmodule['sandpass_reprint_id']  ?>" />


              <table id="vacbtable" class="table table-bordered table-striped">

	  <tr><td>Customer name</td>
	  	<td><input type="text" name="txtcustrname"  id="txtcustrname"  class="form-control" value="<?php echo strtoupper($customer_name);?>" readonly   autocomplete="off" required/>
	   </td></tr>
	   <tr >
  
      		<td>Token No/ID<font color="#FF0000">*</font></td>
      		<td><input   type="text" name="txttokenno" id="txttokenno" disabled="disabled" readonly  value="<?php echo $rowmodule['token_no']  ?>" />
           </td>
      	</tr>
		 <tr >
      		<td>Aadhar Number<font color="#FF0000">*</font></td>
      		<td><input type="text" name="txtaadharno" id="txtaadharno"  disabled="disabled" readonly  value="<?php echo $customer_aadhar_number  ?>"/>
           </td>
      	</tr>
      	<?php } ?>
	  <tr >
	  <td>Reason<font color="#FF0000">*</font></td>
      		<td><textarea name="txtreason" id="txtreason" readonly disabled="disabled"> <?php echo $rowmodule['sandreprint_reason']  ?></textarea> </td>
    	</tr> 
 <tr >
  
      		<td>Booking Status<font color="#FF0000">*</font></td>
      		<td>Approve  <input type="radio" name="radiobookingStatus" id="radiobookingStatus"  value="2"  checked="checked" />
                Reject <input type="radio" name="radiobookingStatus" id="radiobookingStatus"  value="3"  />
           </td>
      	</tr>
		   <tr >
      		<td>Remarks<font color="#FF0000">*</font></td>
      		<td ><textarea name="txtremarks" id="txtremarks" class="form-control"></textarea> </td>
      	</tr>
	  </table>
  		 
 		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		
		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Send"/>  
       			 		
						<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
    </div>
        </div>
		

    
          
              
		   <?php echo form_close(); ?>
<!--          </div>
            </div>
-->			 </div>
            <!-- /.box-body -->
          </div>
        