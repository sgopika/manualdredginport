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

	  <script type="text/javascript">

	 	$(document).ready(function()

			  {
		 jQuery.validator.addMethod("nospecial", function(value, element) {

        return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);

			});    	

			

				

				

	 $('#sand_issueotp').validate(

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
			
			//---------------------------------------------------------------------
	$("#trotpenter").hide();
//	$("#spotenter").hide();
	//------------------------------otp send--------------------------------------------
	$('#btn_otp').click(function()
				{
		
					//var txtaadharno=$('#txtaadharno').val();
					var txttokenno=$('#txttokenno').val();
		
				//	var statuss = $("input[name=radioRequestStatus]:checked").val();
		//alert(txtaadharno);
		//alert(txttokenno);
   						$.post("<?php echo $site_url?>/Manual_dredging/Master/otp_vehiclepass/",{txttokenno:txttokenno},function(data)
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
					
   	$.post("<?php echo $site_url?>/Manual_dredging/Master/vehiclepass_otpcheck/",{otpno:otpno},function(data)
		{
						//	alert(data);exit;
							if(data==0)
							{
								alert("Error!!!!!! Invalid OTP.......");
							}
							else
							{
								
								$("#trotp").hide();
								$("#trphoneno").hide();
								$("#trotpenter").hide();
								$("#divid").show();
								
								//var phoneno=$('#txt_phone1').val();
								//$('#txt_phone').val(phoneno);
								//$('#trotp').html(data);
							}
							//alert(data);exit;
							
							//$('#trotp').html(data);
						});
					/*}*/
				});
	
		//------------------------------------------------	
			  });

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

<!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Sand issue OTP</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_zone_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Sand issue(OTP)</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>



        <?php if( $this->session->flashdata('msg')){ 

		   	echo $this->session->flashdata('msg');

		   }
	
			if(isset($int_userpost_sl)){

        $attributes = array("class" => "form-horizontal", "id" => "sand_issue_add", "name" => "sand_issue_add");

			} else {

       $attributes = array("class" => "form-horizontal", "id" => "sand_issue_add", "name" => "sand_issue_add", "onSubmit" => "return validate_chk();");

			}

        

		if(isset($int_userpost_sl)){

       		echo form_open("Manual_dredging/Master/sand_issueotp", $attributes);

		} else {

			echo form_open("Manual_dredging/Master/sand_issueotp", $attributes);

		}?>

     
      <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
     
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
             
Token No/ID<font color="#FF0000">*</font>
            </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
                    <input   type="text" name="txttokenno" id="txttokenno" autocomplete="off"  />

           </div>
      </div>
      	
 <div class="row p-3">
          <div class="col-12 d-flex justify-content-center px-2" id="trotp">
		
 
         <table ><tr ><td></td><td>
                    		
				
                 	  	<input id="btn_otp" name="btn_otp" type="button" class="btn btn-primary" value="Get"/>
                 	
					
                 	  	</td></tr></table>
          </div>
 </div>
           <div class="row p-3" id="trotpenter" style="display:none;">
          <div class="col-md-6 d-flex justify-content-center px-2">        	  	
     Enter OTP
         </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
              <input type="text" name="txt_otp" id="txt_otp"  maxlength="6" required="required" onKeyPress="return event.charCode >= 48 && event.charCode <= 57" />&nbsp;&nbsp;<input id="btn_check" name="btn_check" type="button" class="btn btn-primary" value="Submit"/>
           </div>
           </div>
           
<div class="row px-5 py-5" id="divid" style="display: none;" >
 		
        <div class="col-12 d-flex justify-content-center">
  			<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
	               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="View"/>

    </div>

        </div>

     

		   <?php echo form_close(); ?>

		 </div>

          