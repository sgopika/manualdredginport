<?php
/*// Merchant key here as provided by Payu
$MERCHANT_KEY = "gtKFFx"; //Please change this value with live key for production
   $hash_string = '';
// Merchant Salt as provided by Payu
$SALT = "eCwWELxi"; //Please change this value with live salt for production

// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://test.payu.in";

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
   // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
*/

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
			
				
				
	 $('#userposting').validate(
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
</script>
<!-- ------------------------------------------------------------------------------------->
 <div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Online payment</button>
		</div>
		
     <div class="col-12 d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/customer_home"); ?>"> Home</a></li>
       
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
<!-- ------------------------------------------------------------------------------------->


    <!-- Main content -->
    
      <div class="row ">
        <div class="col-9">
          <!-- /.box -->
      
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
     
            <div class="box-header ">
              <h3 class="box-title">Online payment  </h3>
            </div>
          
            <?php 
			
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "customerregistration_add", "name" => "customerregistration_add");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "customerregistration_add", "name" => "customerregistration_add", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Master/Onlinepayment", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/Onlinepayment", $attributes);
		}?>
	
      <input type="hidden" name="hash" id="hash" value="<?php echo $hash ?>"/>
    
	 
	    <input type="hidden" name="surl" value="http://localhost/apyu/response.php" />   <!--Please change this parameter value with your success page absolute url like http://mywebsite.com/response.php. -->
		 <input type="hidden" name="furl" value="http://localhost/apyu/response.php" /><!--Please change this parameter value with your failure page absolute url like http://mywebsite.com/response.php. -->
	  
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		
              <table id="vacbtable" class="table table-bordered table-striped">

    <?php //print_r($get_bookingdata); 
	foreach ($get_bookingdata as $rowsmodule){ ?>
        <tr >
      		<td>Token Number <font color="#FF0000">*</font>
      		  <input type="hidden" name="hid_custid" id="hid_custid" value="<?php echo $rowsmodule['customer_registration_id']; ?>" readonly /> </td>
      		  <input type="hidden" name="hid_bookingid" id="hid_bookingid" value="<?php echo $rowsmodule['customer_booking_id']; ?>" readonly /> </td>
      		<td ><?php echo $rowsmodule['customer_booking_token_number'];?></td>
      	</tr>
        
        <tr >
      		<td>Name<font color="#FF0000">*</font></td>
      		<td ><?php echo $rowsmodule['customer_name']; ?> </td>
      	</tr>
        
        <tr >
      		<td>Mobile Number <font color="#FF0000">*</font></td>
      		<td ><?php echo $rowsmodule['customer_phone_number']; ?> </td>
      	</tr>
          <tr >
      		<td>Requested Ton<font color="#FF0000">*</font></td>
      		<td ><?php echo $rowsmodule['customer_booking_request_ton']; ?> </td>
      	</tr>
     
        <tr >
      		<td>Amount<font color="#FF0000">*</font></td>
      		<td ><?php echo $rowsmodule['customer_booking_chalan_amount']; ?> </td>
      	</tr>
		<tr >
      		<td>Email <font color="#FF0000">*</font></td>
      		<td ><input type="text"  name="custemail" id="custemail" value="abcd@gmail.com"  /> </td>
      	</tr>
		  <?php } ?>
		  <tr >
      		<td>Select Bank <font color="#FF0000">*</font></td>
      		<td >
      		<select  name="banktype"  id="banktype"  class="form-control"  maxlength="100">

            <option value="" selected="selected">--select--</option>

            <?php foreach($get_banktype as $p)

			{

		?>

            <option value="<?php echo $p['bank_type_id'];?>"><?php echo $p['bank_name'];?></option>

            <?php

				

			}

			?>

            </select>
      		</td>
      	</tr>
	  </table>
  		 <script type="text/javascript">
        function vali()
		{
			var a=confirm("are you sure?");
			if(a==true)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
        </script> 
 		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php /*?><?php if(isset($int_designation_sl)){?>
		 <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary"  onclick="return vali()" value="Save"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" /><?php */?>
		 <?php if(!$hash) { ?>
            <td colspan="4"><input class="btn btn-primary" type="submit" value="Submit" />&nbsp;<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" /></td>
          <?php } ?>
        </div>
        </div>
		

    </form>
          
              
		   <?php //echo form_close(); ?>
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