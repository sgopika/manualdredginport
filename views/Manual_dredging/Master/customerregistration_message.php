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
<body>
<section class="login-block">
	<div class="container">
		<div class="row">
    <div class="col">      <img src="<?php echo base_url(); ?>plugins/img/logo.png"  alt="PortInfo">
    </div>
     <div class="col-4 border-left pb-2">
      <i class="fas fa-user-plus mt-5 text-primary"></i> <font class="text-primary"> 
      	<span class="eng-content"> Customer Registration  </span><br>
      	<span class="mal-content mal_content_reg">   ഉപഭോക്തൃ രജിസ്ട്രേഷൻ  </span> </font>  <hr>
     <!--  <button type="button" class="btn btn-primary btn-point btn-flat eng-content" id="mal-button" >Malayalam</button>
      <button type="button" class="btn btn-primary btn-point btn-flat mal-content" id="eng-button">English</button> -->
    </div> 
 </div>

      <div class="row py-3">

        <div class="col-12">

          <!-- /.box -->

        <div class="row" >

        <?php if( $this->session->flashdata('msg')){ 

		   	echo $this->session->flashdata('msg');

		   }?>

	    <div class="col-12">

        <a href="<?php echo site_url();?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-arrow-left"></i> &nbsp;&nbsp;Go Back </button>

              </a>

            <div class="col-12 ">
       

              <h3 class="box-title" > <p align="center" ><strong>Customer Registration</strong></p><?php

			foreach($getcustomerreg_message as $messages)

			{

			$customerregid=$messages['customer_registration_id'];

			$portname=$messages['vchr_portoffice_name'];

			$portaddress=$messages['vchr_portoffice_address'];

			$customerregno=$messages['customer_reg_no'];

			$customername=$messages['customer_name'];

			$cutomeraadharno=$messages['customer_aadhar_number'];

			}

			  if($customerregid!='')

			  {

			  ?>

			  

			  <p style= "margin:3px 3px 0 0;font-weight:bold;font-size: 20px;">You have successfully applied for registration to <b> <?php echo $portname; ?></b> PORT for sand allotment.</p> 

			 <hr>

			  <p style= "margin:3px 3px 0 0;font-weight:bold;font-size: 20px;">YOUR REGISTRATION NUMBER :- <font color="#990000"><?php echo $customerregno;  ?></font></p>

			   <p style= "margin:3px 3px 0 0;font-weight:bold;font-size: 20px;">NAME OF THE APPLICANT :- <font color="#990000"><?php echo $customername;?></font></p>

			  <table ><tr><td><p  style= "margin:3px 3px 0 0;font-size: 20px;">After processing application by the Port Conservator <?php echo $portaddress;?> and, on approval you will receive <b>USER-ID & PASSWORD </b> in your registered mobile number.</p></td></tr><tr><td> <p style="margin:2px 0 0 0;font-weight:bold;">Using this you can login to site for sand booking.</p>

			  <p style="margin:2px 0 0 0;font-weight:bold;">Please take note of this registration number for future reference.</p></td></tr></table>
			  <hr>

			  <p style= "margin:3px 3px 0 0;font-weight:bold;font-size: 20px;">കസ്റ്റമറുടെ പേര് :-  <?php echo $customername;?></p>

			    <p style= "margin:3px 3px 0 0;font-weight:bold;font-size: 20px;">താങ്കളുടെ മണലിനു  വേണ്ടിയുള്ള  രജിസ്‌ട്രേഷൻ  നമ്പർ :- <font color="#990000"><?php echo $customerregno;  ?></font></p>

			  <table><tr><td><p  style="margin:3px 3px 0 0;font-weight:bold;">അപേക്ഷ  Port Conservator <?php echo $portaddress;?>,അംഗീകരിക്കുന്ന മുറയ്ക്ക് <b>USER-ID & PASSWORD </b> രജിസ്റ്റർ ചെയ്ത മൊബൈൽ നനമ്പറിൽ ലഭിക്കുന്നതാണ് .</p></td></tr><tr><td> <p style="margin:2px 0 0 0;font-weight:bold;">ഈ USER ID & PASSWORD  ഉപയോഗിച്ച് മണൽ ബുക്കുചെയ്യാവുന്നതാണ് .
			  </p>
			  <br>
			  <p style="color: #AE020D;font-weight: bold">Important Notice</p>
			  <br>
			<p style="margin:2px 0 0 0;font-weight:bold;"> 1. 
ബുക്കിംഗ് ചെയ്യുന്നതിന് മുൻപായി ബന്ധപ്പെട്ട കടവിൽ മണൽ നേരിട്ട് പരിശോധിച്ചു തൃപ്തി വരുത്തേണ്ടതാണ്.<br>
2. മണലിന്റെ  ലവണാശം നീക്കുന്നതിന് മഴ കൊള്ളിക്കുകയോ മണൽ കൂനയിൽ കുഴി എടുത്ത് ആവശ്യത്തിന് ജലം നിറച്ച് വാർന്ന് പോകുവാൻ അനുവദിക്കുകയോ ചെയ്യുക.</p>
			  </td></tr>
	

			  </table>
 
			  <?php 

			  }else { ?> <p><font color="#CC3300" >Customer Registration failed!!!</font></p><?php }

			  ?>

			  

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
  </div>

    <!-- /.row -->

  </section>
</body>
 