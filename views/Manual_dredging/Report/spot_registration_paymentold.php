<?php
/********************************************************************/
 $code=rand(1000,9999);
	$_SESSION["cap_code"]=$code;
 /*******************************************************************/
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

   <link rel="stylesheet" href=<?php echo base_url("assets/plugins/datepicker/datepicker3.css"); ?>>

   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>

      <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>

      <script src=<?php echo base_url("assets/datepicker-bootsrap/js/bootstrap-datepicker.js");?>></script>

      <script src=<?php echo base_url("assets/aadhar/Verhoeff.js");?>></script>

     <script type="text/javascript"> 

	 	$(document).ready(function()

			  {
			
			//---------------------------------------------------------------------
			$("#trotpenter").hide();
			$("#spotenter").hide();
			$("#trbookingtype").hide();
	//------------------------------otp send--------------------------------------------
	$('#btn_otp').click(function()
				{
					var phoneno=$('#txt_phone1').val();
					
   						$.post("<?php echo $site_url?>/Report/spototpmob/",{phoneno:phoneno},function(data)
						{
							//alert(data);exit;
							if(data==0)
							{
								alert("Error!!!!! OTP not delivered");
							}
							else
							{
								$("#trphoneno").hide();
								$("#trotp").hide();
								$("#trotpenter").show();

								//$('#trotp').html(data);
							}
							//alert(data);exit;
							
							//$('#trotp').html(data);
						});
					/*}*/
				});
				
		//-------------------------------------------------------------------------------------------
	$('#btn_check').click(function()
				{
					var otpno=$('#txt_otp').val();
					
   						$.post("<?php echo $site_url?>/Report/spot_otpcheck/",{otpno:otpno},function(data)
						{
							//alert(data);exit;
							if(data==0)
							{
								alert("Error!!!!!! Invalid OTP.......");
								$('#txt_otp').val('');
							}
							else
							{
								
								$("#trotp").hide();
								$("#trphoneno").hide();
								$("#trotpenter").hide();
								$("#spotenter").show();
								var phoneno=$('#txt_phone1').val();
								$('#txt_phone').val(phoneno);
								$('#hid_otp').val(otpno);
								
								//$('#trotp').html(data);
							}
							//alert(data);exit;
							
							//$('#trotp').html(data);
						});
					/*}*/
				});
			
			
			//----------------------------------------------------------------------------
			$('#txt_phone1').change(function()
				{
					var txt_phone1=$('#txt_phone1').val();
					
   						$.post("<?php echo $site_url?>/Report/get_interval_spotmob/",{txtphone:txt_phone1},function(data)
						{
							//alert(data);exit;
							if(data==1)

							{

								alert("Booking not allowed for this Mobile No.......");

								$("#txt_phone1").val('');

				 				$("#txt_phone1" ).focus();

							}
							//alert(data);exit;
							
							//$('#trotp').html(data);
						});
					/*}*/
				});
			//----------------------------------------------------------------------------
	 $("#captchareload").click(function(){
	  $("#captcha").val('');
	  $.post("<?php echo base_url()?>recaptcha.php",function(data)
						{
		 
		  
		  var newcap="<?php echo base_url()?>captcha.php?id="+data;
							$('#capchaimg').attr('src',newcap);
		//  var enc_data=data;
		  var enc_data=btoa(data);
		  $('#pass2').val(enc_data);
		  						  
						});
	  
  });
			
			 $("#captcha").change(function()
       		{
				 var cap_code=$("#captcha").val();
				 //alert(cap_code);exit;
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
	else{//alert("ddddd");
	}
				 
				 
				 
			 });
			
			//---------------------------------------------------
			

			  $("#txt_adhaar").change(function()

       			{

			//	alert("h");

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

					$.post("<?php echo $site_url?>/Report/get_interval_statspot/",{txt_adhar:txt_adhar,port_id:port_id},function(data)

						{

							//var int_vel=data

							//alert(data);

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

	   

	  

			  });

	   </script>

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

					//no_special_check: true,

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

	$('#btn_rep').click(function()

				{

					var zone=$('#int_zone').val();

					var fromd=$('#vch_material_sd').val();

					//alert(fromd);

					//var tod=$('#vch_material_ed').val();

					//var dateArf = fromd.split('/');

                    //var newDatef = dateArf[2] + '/' + dateArf[1] + '/' + dateArf[0].slice(-2);

				//	var dateArt = tod.split('/');

                  //  var newDatet = dateArt[2] + '/' + dateArt[1] + '/' + dateArt[0].slice(-2);

					//alert(newDatet);

					/*if(newDatef > newDatet)

					{

   						alert("Invalid Date Range");

					}

					else

					{*/

   						$.post("<?php echo $site_url?>/Report/gen_salereport/",{zone:zone,fromd:fromd},function(data)

						{

							$('#show').html(data);

						});

					/*}*/

				});

				

				

				

				$('#zone_id').change(function()

				{

				//alert("hello");

					var port_id=$('#portdc').val();
					var zone_id=$('#zone_id').val();

					//getamt(port_id);

					//var period =$('#periodb').val();

					$.post("<?php echo $site_url?>/Report/getqtyspot/",{port_id:port_id,zone_id:zone_id},function(data)

						{

						//alert(data);

						if(data==1)

						{

						alert("Balance ton limit over");

						$('#txt_ton').val('');

						}

						else

						{

						//alert(data);

							$('#txt_ton').html(data);}

						});

				});

				$('#portdc').change(function()

				{

					//alert("hello");

					var port_id=$('#portdc').val();

					//getamt(port_id);

					//var period =$('#periodb').val();

					$.post("<?php echo $site_url?>/Report/getzones_for_spot/",{port_id:port_id},function(data)

						{

							//alert("hello");

							$('#zone_id').html(data);

						});

				});

				$('#txt_ton').change(function()

				{

				//alert("hello");

					var port_id=$('#portdc').val();
					var zone_id=$('#zone_id').val();

					var ton=$('#txt_ton').val();

					//getamt(port_id);

					//var period =$('#periodb').val();

					$.post("<?php echo $site_url?>/Report/getspotton/",{port_id:port_id,zone_id:zone_id,ton:ton},function(data)

						{

						//alert(data);

						if(data==1){alert("Balance ton limit over");$('#txt_ton').val('');}else{

						//alert(data);

							//$('#txt_ton').html(data);

							}

						});

				});
	
	
		//--------------------------------------------------------------------
	
	
	/*$('#zone_id').change(function()

				{

				//alert("hello");

					var port_id=$('#portdc').val();
					var zone_id=$('#zone_id').val();

					if(port_id==16 && zone_id==8 )
					{
						$("#trbookingtype").show();	
					}
					else
					{
						$("#trbookingtype").hide();
					}

					

					

				});*/

				

});

</script>

    <section class="content-header">

     <h1>

         <button class="btn btn-primary btn-flat disabled" type="button" > 

		Spot Registration </button>

      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>

         <li><a href="<?php echo site_url("Master/dashboard"); ?>"> Master</a></li>

        <li><a href="#"><strong>Spot Registration</strong></a></li>

      </ol>

    </section>
<?php $sess_mobno 			=  $this->session->userdata('sess_spot_mob'); ?>
    <!-- Main content -->

    <section class="content">

      <div class="row custom-inner">

        <div class="col-md-9">

          <!-- /.box -->

        <div class="box" >

        <?php if($this->session->flashdata('msg'))

		{ 

		   	echo $this->session->flashdata('msg');

		}

		?>

      <!--      </div> -->

		  

            

        <div class="box box-primary box-blue-bottom">

            <div class="box-header ">

              <h3 class="box-title">Spot Registration</h3>

              <hr />

              <?php // print_r($zas);

			   $attributes = array("class" => "form-horizontal", "id" => "addzone", "name" => "addzone"); 

			  echo form_open('Report/add_spot_registrationpayment',$attributes);

			  ?>

                  <table  class="table table-bordered table-striped">
                  <!----------------------------------------->
                   <tr id="trphoneno">
                    	<td>Enter Phone No</td>
                        <td><input type="text" name="txt_phone1" id="txt_phone1" class="form-control" maxlength="10" required="required" autocomplete="off"/></td>
                    </tr>
                    
                    <tr id="trotp" ><td colspan="2" align="center" ><table ><tr ><td></td><td>
                    		
				  <?php 

				$ip_address=$_SERVER['REMOTE_ADDR'];

			$today=date('Y-m-d');

			$get_intrvl=$this->db->query("select * from tbl_spotbooking where spotbooking_ip_addr='$ip_address' and spotbooking_dte ='$today' and  spotbooking_status=2 order by spot_timestamp desc limit 0,1");

		//echo $this->db->last_query();

		//exit();

		//

		

			$g_int=$get_intrvl->result_array();

			if(empty($g_int))

			{

				?> 
                 	  	<input id="btn_otp" name="btn_otp" type="button" class="btn btn-primary" value="Get OTP"/>
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
                	  	<input id="btn_otp" name="btn_otp" type="button" class="btn btn-primary" value="Get OTP"/>
                	   <?php 

		}

				else

				{?>
				
				<div align="center"><font color="#FF0000"  size="3">Booking Allowed after 10 Minutes.</font></div>
				<?php }

			}

			?>
					
                 	  	</td></tr></table></td></tr>
                  	  	<tr id="trotpenter" style="display:none;" ><td>Enter OTP</td><td><input type="text" name="txt_otp" id="txt_otp"  maxlength="6" required="required" onKeyPress="return event.charCode >= 48 && event.charCode <= 57" />&nbsp;&nbsp;<input id="btn_check" name="btn_check" type="button" class="btn btn-primary" value="Submit"/></td></tr>
                  	  	
                  	  	<tr><td colspan="2">
                  	<table id="spotenter" class="table table-bordered table-striped" style="display:none;" >
                    <!----------------------------------------->

                    <tr>

                    	<td>Enter Customer Name</td>

                    	<td><input type="text" name="txt_username" id="txt_username"  class="form-control" required="required" autocomplete="off" />
                    	<input type="hidden" name="hid_otp" id="hid_otp"   />
                    	</td>

                    </tr>

					<tr>

      					 <td>Select Port</td>

      						 <td><select name="portdc" id="portdc" class="form-control">

                					<option selected="selected" value="">select</option>

               						 <?php 

										foreach($port_det as $pd)

										{

										?>

                					<option value="<?php echo $pd['int_portoffice_id'];?>"><?php echo $pd['vchr_portoffice_name'];?></option>

                					<?php

										}

										?>

        						 </select>

         </td>



       </tr>

	   <tr>

	  <td>Preferred Zone[<font color="#FF0000">Zone will be alloted as per the availability.</font>]</td>

      		<td>

            <select name="zone_id" id="zone_id" class="form-control">

            </select>

            </td>

      </tr>
             <!--<tr  id="trbookingtype" style="display: none;">

  

      		<td>Tick if Door delivery needed<font color="#FF0000">*</font>
      		<br><label>Lorry Charges may be decided by the vehicle owners and collected seperately from the customer. </label>
      		</td>

      		<td>

           <input type="checkbox" name="booking_type" value="true" id="booking_type"  /> 

            </td>

      	</tr>   -->     
                    
                    
                    
                    
                    
                    
                    
                    

                    <tr>

                    	<td>Enter Ton Needed</td>

                        <td><select name="txt_ton" id="txt_ton" class="form-control" required>

                       <option value="">select</option>

                        </select></td>

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
						
						
						<tr><td colspan="2">
						
				  <?php 

				$ip_address=$_SERVER['REMOTE_ADDR'];

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
							</table>
						</td></tr>
      

       	   		  </table>


       	   		  

       

        </div>

        </div>

            </div>

            

        

            <!-- /.box-header -->

           

            <!-- form start -->

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

    $("#vch_material_sd").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    //Datemask2 mm/dd/yyyy

    $("#vch_material_ed").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});

    //Money Euro

    $("[data-mask]").inputmask();





  });

  $(function(){

	  $("#vch_material_sd").datepicker();

	  $("#vch_material_ed").datepicker();

	  });

</script>

