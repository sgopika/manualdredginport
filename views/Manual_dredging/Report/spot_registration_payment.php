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
  <script type="text/javascript"> 
$(document).ready(function()
{
									
$("#trotpenter").hide();
$("#spotenter").hide();
$("#trbookingtype").hide();
$("#trotp").hide();
			
	
$('#btn_otp').click(function()
{
	var phoneno=$('#txt_phone1').val();
	var portdc1=$('#portdc1').val();
	var zone_id1=$('#zone_id1').val();
	var txt_ton1=$('#txt_ton1').val();
	var vehicle_type1=$('#vehicle_type1').val();
					
   	$.post("<?php echo $site_url?>/Manual_dredging/Report/spototpmobnew/",{phoneno:phoneno,portdc1:portdc1,zone_id1:zone_id1,txt_ton1:txt_ton1,vehicle_type1:vehicle_type1},function(data)
	{
					
		if(data==0)
		{
			alert("Error!!!!! OTP not delivered");
		}
		else
		{
			$("#trphoneno").hide();
			$("#trportid").hide();
			$("#trzoneid").hide();
			$("#trtonid").hide();
			$("#trvctype").hide();
			$("#trotp").hide();
			$("#trotpenter").show();

								
		}
							
	});

  
					
});
				
/**/
$('#btn_check').click(function()
{
	var otpno=$('#txt_otp').val();
					
   	$.post("<?php echo $site_url?>/Manual_dredging/Report/spot_otpcheck/",{otpno:otpno},function(data)
	{
							
		if(data==0)
		{
			alert("Error!!!!!! Invalid OTP.......");
			$('#txt_otp').val('');
		}
		else
		{
								
			$("#trotp").hide();
			$("#trphoneno").hide();
			$("#trportid").hide();
			$("#trzoneid").hide();
			$("#trtonid").hide();
			$("#trvctype").hide();
			$("#trotpenter").hide();
			$("#spotenter").show();
			var phoneno=$('#txt_phone1').val();
			var portdc1=$('#portdc1').val();
			var zone_id1=$('#zone_id1').val();
			var txt_ton1=$('#txt_ton1').val();
			var vehicletype1=$('#vehicle_type1').val();

			 var lblport=$('#portdc1 option:selected').text(); 
			 var lblzone=$('#zone_id1 option:selected').text();
			 var lblton=$('#txt_ton1 option:selected').text();
			 var lblvehicle=$('#vehicle_type1 option:selected').text();
			 $('#lblport').html(lblport); 
			 $('#lblzone').html(lblzone); 
			 $('#lblton').html(lblton); 
			 $('#lblvehicle').html(lblvehicle);

			$('#txt_phone').val(phoneno);
			$('#portdc').val(portdc1);
			$('#zone_id').val(zone_id1);
			$('#txt_ton').val(txt_ton1);
			$('#vehicle_type').val(vehicletype1);
			$('#hid_otp').val(otpno);
														
		}
							
	});
					
});
			
			
/**/			
$("#txt_phone1").change(function()
{
	
	var txt_phone1=$('#txt_phone1').val();
					
   	$.post("<?php echo $site_url?>/Manual_dredging/Report/get_interval_spotmob/",{txtphone:txt_phone1},function(data)
	{
		
		if(data==1)

		{

			alert("Booking not allowed for this Mobile No.......");
			$("#txt_phone1").val('');
			$("#txt_phone1" ).focus();
		}
							
	});
				
});
			
/**/


$("#captchareload").click(function()
{
	$("#captcha").val('');
	 $.post("<?php echo base_url()?>recaptcha.php",function(data)
		{		  
		  	var newcap="<?php echo base_url()?>captcha.php?id="+data;
			('#capchaimg').attr('src',newcap);
		  	var enc_data=btoa(data);
		  	$('#pass2').val(enc_data);	  						  
		});
	  
});
/**/

			
$("#captcha").change(function()
{
	var cap_code=$("#captcha").val(); 
	if(cap_code=="")
	{
		alert('Please Enter Captcha code as shown !!!', 'Captcha Code Not Entered');
		$("#captcha").focus();

	}
	else if(btoa(cap_code)!=document.getElementById("pass2").value)
	{
		alert('Captcha Code Entered not correct !!!!');
		$("#captcha").val('');
		$("#captcha").focus();
		
	}
	else
	{
	}
				 
});
			
/**/						

$("#txt_adhaar").change(function()
{			
    var strVal = $("#txt_adhaar").val();
    if (strVal.length < 12) // Minimum length.
    {
        alert("UID less than 12 digit");
		$("#txt_adhaar").val('');
		$( "#txt_adhaar" ).focus();
    }
	else if(strVal.verhoeffCheck() == false)
	{
        alert("Invalid Aadhar Number");
        $("#txt_adhaar").val('');
		$( "#txt_adhaar" ).focus();
    }
	else
	{
		var txt_adhar = $("#txt_adhaar").val();
		var port_id = $("#portdc").val();
		$.post("<?php echo $site_url?>/Manual_dredging/Report/get_interval_statspot/",{txt_adhar:txt_adhar,port_id:port_id},function(data)
		{	
			if(data==1)
			{

				alert("booking not allowed");
				$("#txt_adhaar").val('');
				$("#txt_adhaar" ).focus();
			}

							//$('#show').html(data);

		});

	}
});	

/**/

$('#portdc1').change(function()
{

	var port_id=$('#portdc1').val();
	$.post("<?php echo $site_url?>/Manual_dredging/Report/getzones_for_spot/",{port_id:port_id},function(data)
	{
		$('#zone_id1').html(data);
			 var lblport=$('#portdc1 option:selected').text(); 
			  $('#lblport').html(lblport);

	});

});

/**/
	

$('#zone_id1').change(function()

{

	var port_id=$('#portdc1').val();
	var zone_id=$('#zone_id1').val();
	$.post("<?php echo $site_url?>/Manual_dredging/Report/getqtyspot/",{port_id:port_id,zone_id:zone_id},function(data)
	{

		if(data==1)
		{
			alert("Balance ton limit over");
			$('#txt_ton1').val('');
			$('#vehicle_type1').val('');
			$('#zone_id1').val('');
		}
		else
		{
					
			$('#txt_ton1').html(data);
			 var lblzone=$('#zone_id1 option:selected').text(); 
			  $('#lblzone').html(lblzone);

		}

	});

});



/**/

$('#txt_ton1').change(function()
{
				
	var port_id=$('#portdc1').val();
	var zone_id=$('#zone_id1').val();
	var ton=$('#txt_ton1').val();
	$.post("<?php echo $site_url?>/Manual_dredging/Report/getspotton/",{port_id:port_id,zone_id:zone_id,ton:ton},function(data)
	{

		if(data==1)
		{
			alert("Balance ton limit over");
			$('#txt_ton1').val('');
			$('#vehicle_type1').val('');
			$('#zone_id1').val('');
			
		}
		else
		{
			 $('#zone_id1').prop('disabled', 'disabled');
			$('#vehicle_type1').html(data);		
			var lblton=$('#txt_ton1 option:selected').text();
			$('#lblton').html(lblton);
							

		}

	});

});

/**/
$('#vehicle_type1').change(function()
{
	var vehicle_type1=$('#vehicle_type1').val();
	if(vehicle_type1!='')
	{
		$("#trotp").show();
		$('#txt_ton1').prop('disabled', 'disabled');
		 var lblvehicle=$('#vehicle_type1 option:selected').text();	
		 $('#lblvehicle').html(lblvehicle);
	}
	else
	{
		$("#trotp").hide();
	}
	
});
	  	  
/*Document ready close*/
});
</script>
<script src=<?php echo base_url("plugins/js/jquery.validate.min.js");?>></script>
 <script src=<?php echo base_url("plugins/aadhar/Verhoeff.js");?>></script>
 <script type="text/javascript">

	$(document).ready(function() {

		jQuery.validator.addMethod("no_special_check", function(value, element) {
        	return this.optional(element) || /^[a-zA-Z0-9\s.-]+$/.test(value);
		});
 	
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

  $("#addzone").validate({

		rules: {

				txt_username: {

					required: true,
					namewithspace:true,
					maxlength: 25,

				},

				txt_adhaar: {

					required: true,
					number:true,
					exactlength:12,

				},
				txt_phone: {

					required: true,
					number:true,
					minlength: 10,
					maxlength: 10,

				},

				txt_ton: {

					required: true,
					number:true,
					maxlength: 2,

				},

				txt_place: {

					required: true,
					maxlength: 20,

				},

				txt_route: {

					required: true,
					maxlength: 500,

				},

				txt_distance: {

					required: true,
					number:true,
					maxlength: 3,

				},

				portdc: {

					required: true,
				},

		},

		messages: {

				txt_username: {

					required: "<font color='#FF0000'>Please enter Username!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 25 characters allowed!!</font>",

				},

				txt_adhaar: {

					required: "<font color='#FF0000'>Please enter Adhaar No !!</font>",
					number: "<font color='#FF0000'> Only Numbers!!</font>",
					minlength: "<font color='#FF0000'> Minimum 12 characters needed!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 12 characters allowed!!</font>",

				},

				txt_phone: {

					required: "<font color='#FF0000'>Please enter Phone !!</font>",
					number: "<font color='#FF0000'> Only Numbers!!</font>",
					minlength: "<font color='#FF0000'> Minimum 10 characters needed!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 10 characters allowed!!</font>",

				},

				txt_ton: {

					required: "<font color='#FF0000'> Please enter Ton needed !!</font>",
					number: "<font color='#FF0000'> Only Numberss!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 2 characters allowed!!</font>",

				},

				txt_place: {

					required: "<font color='#FF0000'> Please enter Unloading place !!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",

				},

				txt_route: {

					required: "<font color='#FF0000'>Please enter route !!</font>",
					maxlength: "<font color='#FF0000'> Maximum 500 characters allowed!!</font>",

				},

				txt_distance:{

					required: "<font color='#FF0000'> Please enter Distance !!</font>",
					number: "<font color='#FF0000'> Only Numberss!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 3 characters allowed!!</font>",

				},

				portdc:{

					required: "<font color='#FF0000'> Please select Port !!!!!</font>",

					

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
document.onkeydown = function(e) {
if(event.keyCode == 123) {
return false;
}
if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'H'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'A'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'F'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
return false;
}
}
</script>
<?php
 $code=rand(1000,9999);
	$_SESSION["cap_code"]=$code;
?>	
<?php $sess_mobno 			=  $this->session->userdata('sess_spot_mob'); ?>
<section class="login-block">
	<div class="container">
	<div class="row">
    	<div class="col">      <img src="<?php echo base_url(); ?>plugins/img/logo.png"  alt="PortInfo">
    	</div>
     	<div class="col-4 border-left pb-2">
      	<i class="fas fa-user-plus mt-5 text-primary"></i> <font class="text-primary"> 
      	<span class="eng-content"> Spot Booking  </span><br>
      	<span class="mal-content mal_content_reg">   സ്പോട്ട്  ബുക്കിംഗ്  </span> </font>  <hr>
    	</div> 
 	</div>

 	<div class="row m-2">
        <div class="col-10">
        <div class="box" >

        <?php if($this->session->flashdata('msg'))

		{ 
		   	echo $this->session->flashdata('msg');
		}?>
	</div><!-- box -->
	</div><!-- col -->
	</div><!-- row -->

	<div class="row">
        <div class="col-12 ">
            <h3 class="box-title">Spot Registration</h3>
              <hr />
              <?php 
			   $attributes = array("class" => "form-horizontal", "id" => "addzone", "name" => "addzone"); 
			  echo form_open('Manual_dredging/Report/add_spot_registrationpayment',$attributes);
			  ?>
			  <table  class="table table-bordered table-striped">
           <!-- table -->

            <tr id="trphoneno">
                    	<td>Enter Phone No</td>
                        <td><input type="text" name="txt_phone1" id="txt_phone1" class="form-control" maxlength="10" required="required" autocomplete="off"/></td>
            </tr>
           <tr id="trportid">
      			<td>Select Port</td>
      			<td><select name="portdc1" id="portdc1" class="form-control" required="required">
                	<option selected="selected" value="">select</option>
               		<?php 
						foreach($port_det as $pd)
						{?>

                	<option value="<?php echo $pd['int_portoffice_id'];?>"><?php echo $pd['vchr_portoffice_name'];?></option>
                	<?php } ?>

        			</select> 
         		</td>
       		</tr>
	   		<tr id="trzoneid">
	  			<td >Preferred Zone[<font color="#FF0000">Zone will be alloted as per the availability.</font>]</td>
      			<td>
            	<select name="zone_id1" id="zone_id1" class="form-control" required="required"> 		
            	</select>

            	</td>

      		</tr>
           
            <tr id="trtonid">
                <td>Enter Ton Needed</td>
                <td><select name="txt_ton1" id="txt_ton1" class="form-control" required="required">
                <option value="">select</option>
                </select>
            	</td>
            </tr>
            <tr id="trvctype">
                <td>Vehicle Type</td>
                <td><select name="vehicle_type1" id="vehicle_type1" class="form-control"  required="required">
                    <option value="">select</option>
                    </select>
                  
                </td>
            </tr>
                    
            
            <tr id="trotp" ><td colspan="2" align="center" >
            	<table>
            	<tr>
            	<td> 

				  <?php 			
				if ($_SERVER["HTTP_X_FORWARDED_FOR"])
				{
    				$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
				}
				else 
				{
    				$ip_address = $_SERVER["REMOTE_ADDR"];
				}		

				$today=date('Y-m-d');
				$get_intrvl=$this->db->query("select * from tbl_spotbooking_temp where spotbooking_ip_addr='$ip_address' and spotbooking_dte ='$today' and  spotbooking_status=2 order by spot_timestamp desc limit 0,1");

				$g_int=$get_intrvl->result_array();
				if(empty($g_int))

				{ ?> 
                 	<input id="btn_otp" name="btn_otp" type="button" class="btn btn-primary" value="Get OTP"/>
                  <?php 
            	}
				else		
				{

					$spottime=$g_int[0]['spot_timestamp'];						
					$spot_time = strtotime($spottime . "+10 minutes");
					$current_time=strtotime("now");
					if($current_time>=$spot_time)
					{
						?> 	
                		<input id="btn_otp" name="btn_otp" type="button" class="btn btn-primary" value="Get OTP"/>
                		<?php 	
                	}
					else
					{ ?>
				
						<div align="center"><font color="#FF0000"  size="3">Booking Allowed after 10 Minutes.</font></div>
						<?php
					}

				} ?>
					
                </td>
            	</tr>
            </table><!-- trotptable -->
            	</td>
            </tr>
            <tr id="trotpenter" style="display:none;" >
            	<td>Enter OTP</td>
            	<td><input type="text" name="txt_otp" id="txt_otp"  maxlength="6" required="required" onKeyPress="return event.charCode >= 48 && event.charCode <= 57" />&nbsp;&nbsp;<input id="btn_check" name="btn_check" type="button" class="btn btn-primary" value="Submit"/></td>
            </tr>
                  	  	
            <tr><td colspan="2">
                  	<table id="spotenter" class="table table-bordered table-striped" style="display:none;" >
                    <!--spotenter-->
                    <tr>
                    	<td>Enter Customer Name</td>
                    	<td><input type="text" name="txt_username" id="txt_username"  class="form-control" required="required" autocomplete="off" />
                    	<input type="hidden" name="hid_otp" id="hid_otp"   />
                    	</td>

                    </tr>

					<tr>

      					<td>Select Port</td>
      					<td>

      						 <label id="lblport"></label>
      						 <input type="hidden" name="portdc" id="portdc">


      						<!-- <select name="portdc" id="portdc" class="form-control" readonly onmousedown="return false" onkeydown="return false">
                		<option selected="selected" value="">select</option>
               			<?php 
							foreach($port_det as $pd)
							{	?>

                			<option value="<?php echo $pd['int_portoffice_id'];?>"><?php echo $pd['vchr_portoffice_name'];?></option>

                					<?php	}	?>

        					</select> -->


         				</td>

       				</tr>
	   				<tr>

	  					<td>Preferred Zone[<font color="#FF0000">Zone will be alloted as per the availability.</font>]</td>
      					<td>


      						 <label id="lblzone"></label>
      						 <input type="hidden" name="zone_id" id="zone_id">
            			<!-- <select name="zone_id" id="zone_id" class="form-control" readonly onmousedown="return false" onkeydown="return false">
						<?php	foreach($zone as $z)
						{	?>
   						 <option value="<?php echo $z['zone_id'];?>"><?php echo $z['zone_name']; ?></option>
   						 <?php
						} ?>
            			</select> -->
            			</td>
      				</tr>           
                    <tr>
                    	<td>Enter Ton Needed</td>
                        <td>

      						 <label id="lblton"></label>
      						 <input type="hidden" name="txt_ton" id="txt_ton">
                        	<!-- <select name="txt_ton" id="txt_ton" class="form-control" readonly onmousedown="return false" onkeydown="return false">
						     <option value="" selected="selected">select</option>
                        	  <option value="3">3</option>
                     		  <option value="5">5</option>
                        	  <option value="7">7</option>
                        	  <option value="10">10</option>
                        	  <option value="12">12</option>
                        	  <option value="16">16</option> 
                        	  <option value="18">18</option>  
                        	  <option value="21">21</option>
                        	  <option value="25">25</option> 
                        	  <option value="30">30</option>
                        </select> -->
                    </td>

                    </tr>
                    <tr >
                    	<td>Vehicle Type</td>
                        <td>
                        	 <label id="lblvehicle"></label>
      						 <input type="hidden" name="vehicle_type" id="vehicle_type">
                        	<!-- <select name="vehicle_type" id="vehicle_type" class="form-control" readonly onmousedown="return false" onkeydown="return false">

                       <option value="">select</option>
						<option value="1">Zone lorry</option>
    					<option value="2">Other lorry</option>
                        </select>      -->               
                        </td>
                    </tr>
                    <tr>

                    	<td>Enter Aadhaar Number</td>
                        <td><input type="text" name="txt_adhaar" id="txt_adhaar"  class="form-control" required="required" maxlength="12" autocomplete="off" /></td>
                    </tr>
                    <tr>
                    	<td>Enter Phone Number</td>
                        <td><input type="text" name="txt_phone" id="txt_phone" class="form-control" maxlength="10"  value="<?php echo $sess_mobno;?>" readonly /></td>
                    </tr>
                    <tr>

                    	<td>Unloading Place[<font color="#FF0000" >Unloading place with Post Office as per Aadhar(except Vadakara &amp; KSMDCL ) </font>]</td>

                        <td><input type="text" name="txt_place" id="txt_place" class="form-control" maxlength="100" required="required"/></td>

                    </tr>

                    <tr>

                    	<td>Route</td>

                        <td>

                        <textarea name="txt_route" id="txt_route" class="form-control"></textarea>

                        </td>

                    </tr>

                    <tr>

                    	<td>Distance in KM</td>

                        <td><input type="text" name="txt_distance" id="txt_distance" class="form-control" maxlength="10" required="required"/></td>

                    </tr>
<tr><td>Please enter the code<font color="#FF0000">*</font></td><td><input name="captcha" type="text" class="validate[required,custom[onlyLetterNumber]]"  id="captcha" autocomplete="off"  placeholder="Enter Captcha" size="10" maxlength="4" style="text-align:center" onKeyPress="return event.charCode >= 48 && event.charCode <= 57" required="true" title="Please Enter the Captcha !!!!">
					<?php $rr=base64_encode($_SESSION['cap_code']);?>
					 <img src="<?php echo base_url()?>captcha.php?id=<?php echo $code; ?>" id="capchaimg"/>
						 <input name="pass2" type="hidden" class="tb4" id="pass2" size="24"  value=<?php echo $rr;?>>
						 
					<img src="<?php echo base_url()?>assets/images/Refresh.png"  style="cursor:pointer" id="captchareload"  ></td></tr>						
						<tr>
							<td colspan="2">
						
				  <?php 
				if ($_SERVER["HTTP_X_FORWARDED_FOR"])
				{
    				$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
				}
				else 
				{
    				$ip_address = $_SERVER["REMOTE_ADDR"];
				}
	
	
				

			$today=date('Y-m-d');

			$get_intrvl=$this->db->query("select * from tbl_spotbooking_temp where spotbooking_ip_addr='$ip_address' and spotbooking_dte= '$today' and  spotbooking_status=2 order by spot_timestamp desc limit 0,1");

		//echo $this->db->last_query();

		//exit();

		//

		

			$g_int=$get_intrvl->result_array();

			if(empty($g_int))

			{

				?> 


       <div class="form-group">

        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left" >

		

		<input id="btn_change" name="btn_add" type="submit" class="btn btn-primary" value="Register"/>

        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />

       

        </div>

        <?php 

			}

			else

			{

		//if(!empty($g_int)){$spottime=$g_int[0]['spot_timestamp'];}else {$spottime='';}

		$spottime=$g_int[0]['spot_timestamp'];

		$spot_time = strtotime($spottime . "+10 minutes");

		$current_time=strtotime("now");

		if($current_time>=$spot_time)

		{

				?> 

       <div class="form-group">

        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left" >

		

		<input id="btn_change" name="btn_add" type="submit" class="btn btn-primary" value="Register"/>

        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />

       

        </div>

        <?php 

		}

				else

				{?>
				
				<div align="center"><font color="#FF0000"  size="3">Booking Allowed after 10 Minutes.</font></div><?php }

			}

			?>
							
						</td></tr>
						</table><!-- spotenter -->
			</td>
		</tr>
     
       	   		  </table><!-- main table -->
       	   		</div></div></div></section>