<?php
/********************************************************************/
 $code=rand(1000,9999);
	$_SESSION["cap_code"]=$code;
 /*******************************************************************/
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

 		 <script src=<?php echo base_url("plugins/js/jquery.validate.min.js");?>></script>

	   <script src=<?php echo base_url("plugins/aadhar/Verhoeff.js");?>></script>

	  <script type="text/javascript">

	  

	 	$(document).ready(function()

			  {
			  	$("#plintharea_tr").css("display","none");

//---------------------------------------------------------
$('#workingtoo').click(function(){
	//alert("ssssss");
  filladdress();
});			  	
//-------------------------------------------------------------
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
			
//-------------------------------------------------------------
			  

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

		//alert(data);

			//$('#daterangearray').html(data);

					if(data == 1)

					{

					

						alert("Aadhar Number no already exists");

						$("#customer_aadhar_number").val('');$("#customer_aadhar_number").focus();//exit;

					}

					else if(data ==0)

					{

					

					}

					else

					{

					$('#dataid').html(data);

					

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

							 customer_permit_number:{required:"<font color='red'> Number required !!!</font>",},

							 customer_permit_date:{required:"<font color='red'> Date required !!!</font>",},

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

				

//---------------------------------------fie upload check------------------------//

			var uploadFieldone = document.getElementById("fileone");

			var allowedFiles = [".jpg", ".jpeg", ".pdf"];

			 var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");

				uploadFieldone.onchange = function() {

    				if(this.files[0].size > 200000)

					{

       					alert("File size must not exceed 200 KB!");

       					this.value = "";

					};

					

       

        if (!regex.test(uploadFieldone.value.toLowerCase())) {

            alert("Please upload files having extensions: " + allowedFiles.join(', ') + " only.");

			uploadFieldone.value="";

            //return false;

        }

					

				};

			//---------------------------------------------------------------

			var uploadFieldtwo = document.getElementById("filetwo");



				uploadFieldtwo.onchange = function() {

    				if(this.files[0].size > 200000)

					{

       					alert("File size must not exceed 200 KB!");

       					this.value = "";

					};

					

        

        if (!regex.test(uploadFieldtwo.value.toLowerCase())) {

            alert("Please upload files having extensions: " + allowedFiles.join(', ') + " only.");

           uploadFieldtwo.value="";

        }

				};

		//-------------------------------------------------------------------------------//	

	

});

</script>

<script type="text/javascript">

				function addpermitAuthority()

				{

				var x = document.getElementById("customer_work_lsg_id").selectedIndex;

						var y = document.getElementById("customer_work_lsg_id").options;

						var lsgname = y[x].text;

					

						document.getElementById("customer_permit_authority").value=lsgname;

				}

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

					//alert("asasdaDS");

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

					

					$.post("<?php echo $site_url?>/Manual_dredging/Master/Checkallotedton/",

						   {

						requestedton:requestedton,construct_masterid:construct_masterid},function(data)

						{

					//	alert(data);

						if(data==1)

						{

							document.getElementById("lbldisplay").innerHTML ='';

						}

						else

						{

							alert("Please select Purpose");

							$( "#customer_max_allotted_ton" ).val('');

							$( "#customer_max_allotted_ton" ).focus();

						}

							

						});

				});

	//----------------------------------------------------------------------------

	$('#customer_phone_number').change(function()

				{

		//alert("dfdfdfd");

					var customerphno=$('#customer_phone_number').val();

					

					$.post("<?php echo $site_url?>/Manual_dredging/Master/check_customerphonenumber/",{customerphno:customerphno},function(data)

						{

						if(data==0)

						{}

						else

						{

							alert("Already this Phone number registered......");

							$('#customer_phone_number').val('');

							$('#customer_phone_number').focus();

						}

						

							

						});

				});

	//----------------------------------------------------------------------------

				

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

	//var max_ton=(plintharea*0.33).toFixed(2);  commented on 6/03/2019 as per mail 0.33 changed to 0.5

var max_ton=(plintharea*0.5).toFixed(2);

	if(max_ton>150)

	{

		var max_tonnew=150;

		//alert("Plinth Area must be less than 303 ");

		//document.getElementById("customer_plinth_area").value='';

		//document.getElementById("customer_max_allotted_ton").value='';

		 

		document.getElementById("customer_max_allotted_ton").value=max_tonnew;

		$("#customer_max_allotted_ton").prop('readonly', true);

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

		$("#plintharea_tr").show();

		document.getElementById("customer_max_allotted_ton").value='';

		document.getElementById("lbldisplay").innerHTML ="";

		document.getElementById("lblpermit").innerHTML ="Upload Building Permit";

		document.getElementById("lblpermitno").innerHTML ="Building Permit Number";

		document.getElementById("lblpermitdate").innerHTML ="Permit Date";

		

	}

	else

	{

		$("#plintharea_tr").css("display","none");

		document.getElementById("customer_max_allotted_ton").value=15;
		$("#customer_max_allotted_ton").prop('readonly', true);
		

		document.getElementById("lbldisplay").innerHTML ="Maximum Ton alloted is 15 !!!";

		document.getElementById("lblpermit").innerHTML ="Tax Receipt";

		document.getElementById("lblpermitno").innerHTML ="Tax Receipt Number";

		document.getElementById("lblpermitdate").innerHTML ="Tax Receipt Date";

	}

}

function adduploadplace()

{
//alert("dfdfdf");

var workplace=document.getElementById("customer_work_place").value;

document.getElementById("customer_unloading_place").value=workplace;

}

function filladdress(){
  if ($("#workingtoo").is(":checked")) 
  {
    	$('#customer_work_house_name').val($('#customer_perm_house_name').val());
    	$('#customer_work_place').val($('#customer_perm_place').val());
     	$('#customer_work_district_id').val($('#customer_perm_district_id').val());
      	$('#customer_work_lsg_id').val($('#customer_perm_lsg_id').val());
       	$('#customer_work_post_office').val($('#customer_perm_post_office').val());
        $('#customer_work_pin_code').val($('#customer_perm_pin_code').val());
         
        adduploadplace();
		addpermitAuthority();

   // $('#billingaddress').attr('disabled', 'disabled');
  } 
  else
   {
    //$('#billingaddress').removeAttr('disabled');
    	$('#customer_work_house_name').val('');
    	$('#customer_work_place').val('');
     	$('#customer_work_district_id').val('');
      	$('#customer_work_lsg_id').val('');
       	$('#customer_work_post_office').val('');
        $('#customer_work_pin_code').val('');
  }
}






/*function FillAddressdata(f) {
	alert("asdadad");

  if(f.workingtoo.checked == true) {
  	//document.getElementById("customer_work_place").value
    f.customer_work_house_name.value = f.customer_perm_house_name.value;

	f.customer_work_place.value = f.customer_perm_place.value;

	f.customer_work_district_id.value = f.customer_perm_district_id.value;

	f.customer_work_lsg_id.value = f.customer_perm_lsg_id.value;

	f.customer_work_post_office.value = f.customer_perm_post_office.value;

	f.customer_work_pin_code.value = f.customer_perm_pin_code.value;

    adduploadplace();

	addpermitAuthority();

  }

  else

  {

    f.customer_work_house_name.value = '';

	f.customer_work_place.value = '';

	f.customer_work_district_id.value = '';

	f.customer_work_lsg_id.value = '';

	f.customer_work_post_office.value = '';

	f.customer_work_pin_code.value = '';

  }

}*/

</script>



 <script language="javascript">

  function checkpermitdate() {

				  var construct_masterid =$("#customer_purpose option:selected").text();

				 

				 // var construct_masterid=$('#customer_purpose').text();

				 if(construct_masterid=='SELECT')

				 {

				 $("#customer_purpose").focus();

				 $("#start_date").val('');

				 }

				else if(construct_masterid=='Construction')

				{

            var selectedDate = $('#start_date').datepicker('getDate');

  			var today = new Date(); 

 		 	var targetDate= new Date();

			  var d = today.getDate();

            var m = today.getMonth();

            var y = today.getFullYear();

  		

			 var myDate = new Date(selectedDate);

			 var minDate = new Date(y - 3, m, d );

			  var maxDate = new Date(y , m, d );

  			

	if(myDate>=minDate && myDate <=maxDate)		

	 { 

    	

  	} 

		else 

			{

			

   			 alert('Permit Date exceeds three years');

			$("#start_date").val('');

			$("#start_date").focus();

  			}

		}

		else

		{

		//$("#start_date").val('');

			

		}

}





</script>
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
  
    <!-- Main content -->
   	<div class="col-md-12">
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      <!--      </div> -->
		 </div> <!-- end of co12 -->
		</div> <!-- end of row -->  

   


            <?php 

			

			if(isset($int_userpost_sl)){

        $attributes = array("class" => "form-horizontal", "id" => "customerregistration_add", "name" => "customerregistration_add", "enctype"=> "multipart/form-data");

			} else {

       $attributes = array("class" => "form-horizontal", "id" => "customerregistration_add", "name" => "customerregistration_add", "onSubmit" => "return validate_chk();", "enctype"=> "multipart/form-data");

			}

       

			echo form_open("Manual_dredging/Master/customerregistration_add", $attributes);

		//}?>


<a class="btn btn-secondary" href="<?php echo base_url()."index.php/Main_login/index"?>">Home</a> </span>
		<div class="row  oddrows">
          <div class="col-md-6 mt-2">


		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		<span class="eng-content offset-6 text-content-left">
		

            Aadhar Number<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="text" name="customer_aadhar_number" value="<?php if(isset($customer_aadhar_number )){echo $customer_aadhar_number;} else { echo set_value('customer_aadhar_number');} ?>" id="customer_aadhar_number"  class="form-control"  maxlength="12" autocomplete="off" required/> 
		</div>

      	</div>
		
	<!--//--------------------------------------->	
		
<div class="row-12" id="dataid">
              

		

		<!--//--------------------------------------->

		<div class="row evenrows">
          <div class="col-md-6 mt-2">
          	<span class="eng-content offset-6 text-content-left">
			Name<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="text" name="customer_name" value="<?php if(isset($customer_name )){echo $isAdharExistOld[0]['	vchr_requester_name'];} else { echo set_value('customer_name');} ?>" id="customer_name"  class="form-control"  maxlength="100"  autocomplete="off" required/>
			 </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 mt-2">	<span class="eng-content offset-6 text-content-left">
			Mobile Number <font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="text" name="customer_phone_number" value="<?php if(isset($customer_phone_number )){echo $customer_phone_number;} else { echo set_value('customer_phone_number');} ?>" id="customer_phone_number"  class="form-control"  maxlength="10"  autocomplete="off" required/> 
			 </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Email</span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="text" name="customer_email" value="<?php if(isset($customer_email )){echo $customer_email;} else { echo set_value('customer_email');} ?>" id="customer_email"  class="form-control"  maxlength="100"  autocomplete="off" />
			</div>
		   </div> <!-- end of row -->
           <div class="row m-2" >
           <div class="col-12" style="background-color:#a1a8ae">
      			<font color="#ffffff" style="text-align:center; font-weight:bold;">Present Address Details</font>
			</div>

		</div>

        <div class="row oddrows">
           <div class="col-md-6 mt-2">
	<span class="eng-content offset-6 text-content-left">
        House Number<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="text" name="customer_perm_house_number" value="<?php if(isset($customer_perm_house_number )){echo $customer_perm_house_number;} else { echo set_value('customer_perm_house_number');} ?>" id="customer_perm_house_number"  class="form-control"  maxlength="100"  autocomplete="off" required/>
			</div>
			</div>
        <div class="row evenrows">
           <div class="col-md-6 mt-2">	
           	<span class="eng-content offset-6 text-content-left">
			House Name<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="text" name="customer_perm_house_name" value="<?php if(isset($customer_perm_house_name )){echo $customer_perm_house_name;} else { echo set_value('customer_perm_house_name');} ?>" id="customer_perm_house_name"  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			</div>
			</div>
        <div class="row oddrows">
           <div class="col-md-6 mt-2">	<span class="eng-content offset-6 text-content-left">
			Place<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="text" name="customer_perm_place" value="<?php if(isset($customer_perm_place )){echo $customer_perm_place;} else { echo set_value('customer_perm_place');} ?>" id="customer_perm_place"  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			</div>
			</div>
        <div class="row evenrows">
           <div class="col-md-6 mt-2">	<span class="eng-content offset-6 text-content-left">
			District<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">

          <select name="customer_perm_district_id" id="customer_perm_district_id"   class="form-control"  >

           	 <option value="">SELECT</option>

           	<?php foreach($array_perm_dist_id as $perm_distid){?>

			

			<option value="<?php  echo $perm_distid['district_id'];?>" <?php if(isset($customer_perm_district_id)){

			   if($customer_perm_district_id==$perm_distid['district_id']){?> selected="selected"<?php  } }else { if($perm_distid['district_id']== set_value('customer_perm_district_id')){ echo "selected='selected' ";}  }?>><?php  echo $perm_distid['district_name'];?></option>

             <?php } ?>

	        </select> 

           </div>
			</div>
		<div id="displayone">
		<div class="row oddrows">
           <div class="col-md-6 mt-2">

           		<span class="eng-content offset-6 text-content-left">
			Local Body<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">

            <select name="customer_perm_lsg_id" id="customer_perm_lsg_id"   class="form-control"  >

           	 <option value="">SELECT</option>

           	<?php foreach($array_localbody as $perm_localbody){?>

			

			<option value="<?php  echo $perm_localbody['panchayath_sl'];?>" <?php if(isset($customer_perm_lsg_id)){

			   if($customer_perm_lsg_id==$perm_localbody['panchayath_sl']){?> selected="selected"<?php  } }else { if($perm_localbody['panchayath_sl']== set_value('customer_perm_lsg_id')){ echo "selected='selected' ";}  }?>><?php  echo $perm_localbody['panchayath_name'];?></option>

             <?php } ?>

		  </select> 

         </div></div>
			
        <div class="row evenrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Post Office <font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">

           <select name="customer_perm_post_office" id="customer_perm_post_office"   class="form-control"  >

           	 <option value="">SELECT</option>

           		<?php foreach($array_perm_postoff_id as $perm_postoff_id){?>

               	<option value="<?php  echo $perm_postoff_id['PostOfficeId'];?>" <?php if(isset($customer_perm_post_office)){

			   if($customer_perm_post_office==$perm_postoff_id['PostOfficeId']){?> selected="selected"<?php  } }else { if($perm_postoff_id['PostOfficeId']== set_value('customer_perm_post_office')){ echo "selected='selected' ";}  }?>><?php  echo $perm_postoff_id['vchr_BranchOffice'];?></option>

             <?php } ?>

           </select> 

</div></div></div>
			<div class="row oddrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
      		
			Pincode<font color="#FF0000">*</font></span>
			</div>
			<div class="col-md-4 mt-2" id="permpincode">
      		
			<input type="text" name="customer_perm_pin_code" value="<?php if(isset($customer_perm_pin_code )){echo $customer_perm_pin_code;} else { echo set_value('customer_perm_pin_code');} ?>" id="customer_perm_pin_code"  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			</div>

      	</div>
      
		<div class="row m-2" style="background-color:#a1a8ae">  
			<div class="col-10" >  
			<font color="#ffffff" style="text-align:center; font-weight:bold;">Work Site Address Details</font>
			
			</div>
			<div class="col-2"> 
				<label align="right" style="float:right; color:#ffffff;">Same as Above</label>
				<input type="checkbox" name="workingtoo" id="workingtoo"  >
			</div> 
		</div>

		<div class="row oddrows">
           <div class="col-md-6  justify-content-center px-2">
           		<span class="eng-content offset-6 text-content-left">
			Site Address/House Name<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="text" name="customer_work_house_name" value="<?php if(isset($customer_work_house_name )){echo $customer_work_house_name;} else { echo set_value('customer_work_house_name');} ?>" id="customer_work_house_name"  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			</div>
			</div>

        <div class="row evenrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Place<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="text" name="customer_work_place" value="<?php if(isset($customer_work_place )){echo $customer_work_place;} else { echo set_value('customer_work_place');} ?>" id="customer_work_place"  class="form-control"  maxlength="100" onchange="adduploadplace()" onblur="adduploadplace()"  autocomplete="off" required/> 
			</div>

        </div>

       <div class="row oddrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			District<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
           <select name="customer_work_district_id" id="customer_work_district_id"   class="form-control"  >

             <option value="">SELECT</option>

            <?php foreach($array_perm_dist_id as $districtcode){?>

				<option value="<?php  echo $districtcode['district_id'];?>" <?php if(isset($customer_work_district_id)){

			   if($customer_work_district_id==$districtcode['district_id']){?> selected="selected"<?php  } }else { if($districtcode['district_id']== set_value('customer_work_district_id')){ echo "selected='selected' ";}  }?>><?php  echo $districtcode['district_name'];?></option>

             <?php } ?>

	           

           </select> 

           </div>

        </div>
	<div id="displaytwo">
		<div class="row evenrows"  >
           <div class="col-6 mt-2">
				<span class="eng-content offset-6 text-content-left">
			Local Body<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">

          <select name="customer_work_lsg_id" id="customer_work_lsg_id"   class="form-control"  >

             <option value="">SELECT</option>

            <?php foreach($array_localbody as $work_localbody){?>

			<option value="<?php  echo $work_localbody['panchayath_sl'];?>"  <?php if(isset($customer_work_lsg_id)){

			   if($customer_work_lsg_id==$work_localbody['panchayath_sl']){?> selected="selected"<?php  } }else { if($work_localbody['panchayath_sl']== set_value('customer_work_lsg_id')){ echo "selected='selected' ";}  }?>><?php  echo $work_localbody['panchayath_name'];?></option>

             <?php } ?>

          </select> 

           </div>

        </div>

		<div class="row oddrows"  >
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Post Office <font color="#FF0000">*</font>
		</span>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">

            <select name="customer_work_post_office" id="customer_work_post_office"   class="form-control"  >

             <option value="">SELECT</option>

                <?php foreach($array_perm_postoff_id as $work_post_off_id)

				{?>

					<option value="<?php  echo $work_post_off_id['PostOfficeId'];?>" <?php if(isset($customer_work_post_office)){

			   if($customer_work_post_office==$work_post_off_id['PostOfficeId']){?> selected="selected"<?php  } }else { if($work_post_off_id['PostOfficeId']== set_value('customer_work_post_office')){ echo "selected='selected' ";}  }?>><?php  echo $work_post_off_id['vchr_BranchOffice'];?></option>

             <?php } ?>

				

          </select> 

            

            </div>

			</div>

       
		</div>

        <div class="row evenrows" >
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Pincode<font color="#FF0000">*</font>
		</span>
			</div>
           <div class="col-md-4 mt-2" id="workpincodenew">

            
			<input type="text" name="customer_work_pin_code" value="<?php if(isset($customer_work_pin_code )){echo $customer_work_pin_code;} else { echo set_value('customer_work_pin_code');} ?>" id="customer_work_pin_code"  class="form-control"  maxlength="100"  autocomplete="off" required/>
			</div>

        </div>

	 <div class="row oddrows"  id="displaytwo">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Purpose <font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
           <select name="customer_purpose" id="customer_purpose"   class="form-control"  onchange="checkconstruction();">

             <option value="">SELECT</option>

			 

                <?php foreach($array_customer_pur as $customer_purpose_id){?>

               <option value="<?php  echo $customer_purpose_id['construction_master_id'];?>"  <?php if(isset($customer_purpose)){

			   if($customer_purpose==$customer_purpose_id['construction_master_id']){?> selected="selected"<?php  } }else { if($customer_purpose_id['construction_master_id']== set_value('customer_purpose')){ echo "selected='selected' ";}  }?>><?php  echo $customer_purpose_id['construction_master_name'];?></option>

             <?php } ?>

           </select> 

            

            </div>

        </div>

         <div class="row evenrows"  id="plintharea_tr" >
           <div class="col-md-6 m-2">

       	<span class="eng-content offset-6 text-content-left">
			Plinth Area (in sq.m)<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_plinth_area" value="<?php if(isset($customer_plinth_area )){echo $customer_plinth_area;} else { echo set_value('customer_plinth_area');} ?>" onchange="maxton_calculate();" id="customer_plinth_area"  class="form-control"  maxlength="100"  autocomplete="off" required/>
			 </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 m-2">
           		<span class="eng-content offset-6 text-content-left">
			Maximum required ton<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_max_allotted_ton" value="<?php if(isset($customer_max_allotted_ton )){echo $customer_max_allotted_ton;} else { echo set_value('customer_max_allotted_ton');} ?>" id="customer_max_allotted_ton"  class="form-control"  maxlength="100"   autocomplete="off" required/> 
			<label id="lbldisplay"></label>
			 </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 m-2">
           		<span class="eng-content offset-6 text-content-left">
			<label id="lblpermitno">Permit Number</label><font color="#FF0000">*</font>	</span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_permit_number" value="<?php if(isset($customer_permit_number )){echo $customer_permit_number;} else { echo set_value('customer_permit_number');} ?>" id="customer_permit_number"  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			 </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			 <label id="lblpermitdate">Permit Date</label><font color="#FF0000">*</font></span>
			 </div>
           <div class="col-md-4 mt-2">

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

                <input type="text" class="form-control"  value="<?php echo @$start_date?>" name="customer_permit_date" id="start_date" onchange="checkpermitdate();"  />

              </div>

				<span id="startdatediv" ></span>

            
 </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Permit Authority <font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">

          

            <input type="text" name="customer_permit_authority" value="<?php if(isset($customer_permit_authority )){echo $customer_permit_authority;} else { echo set_value('customer_permit_authority');} ?>"  id="customer_permit_authority"  class="form-control" readonly  maxlength="100" autocomplete="off" required/>

            </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Route to the worksite<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
			 <textarea name="customer_worksite_route" id="customer_worksite_route" cols="45" rows="5" class="form-control" required><?php if(isset($customer_worksite_route )){echo $customer_worksite_route;} else { echo set_value('customer_worksite_route');} ?></textarea>
			 </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Distance to the worksite<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="text" name="customer_worksite_distance" value="<?php if(isset($customer_worksite_distance )){echo $customer_worksite_distance;} else { echo set_value('customer_worksite_distance');} ?>" id="customer_worksite_distance"  class="form-control"  maxlength="100"  autocomplete="off" required/>
			 </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Unloading place<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="text" name="customer_unloading_place" value="<?php if(isset($customer_unloading_place )){echo $customer_unloading_place;} else { echo set_value('customer_unloading_place');} ?>" id="customer_unloading_place" readonly  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			 </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Upload Aadhar<font color="#FF0000" size="2">* <br>(File size must not exceed 200 KB & jpg/pdf format only)</font>
		</span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="file" name="userfile[]"  id="fileone"   required><!--<input id="btn_viewUpload" name="btn_viewUpload" type="file" class="btn btn-primary" value="Upload" /><input type="file" name="customer_aadhar_upload" id="customer_aadhar_upload"  accept="image/*" data-rule-required="true" data-msg-accept="Your message"  />--> 
			 </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			<label id="lblpermit">Upload Building Permit</label><font color="#FF0000" size="2">*<br>(File size must not exceed 200 KB & jpg/pdf format only) </font>
		</span>
			</div>
           <div class="col-md-4 mt-2">
			<input type="file" name="userfile[]"  id="filetwo"  required ><!--<input id="btn_permitUpload" name="btn_permitUpload" type="file" class="btn btn-primary" value="Upload" /><input type="file" name="customer_building_permit_upload" id="customer_building_permit_upload"  accept="image/*" data-rule-required="true" data-msg-accept="Your message"   />-->
			 </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
			Select the desired port<font color="#FF0000">*</font>
		</span>
			</div>
           <div class="col-md-4 mt-2">

           <select name="customer_port_id" id="customer_port_id"   class="form-control"  >

             <option value="">SELECT</option>

			

            <?php foreach($array_portmaster as $port_master_id){?>

			

			 <option value="<?php  echo $port_master_id['int_portoffice_id'];?>"  <?php if(isset($customer_port_id)){

			   if($customer_port_id==$port_master_id['int_portoffice_id']){?> selected="selected"<?php  } }else { if($port_master_id['int_portoffice_id']== set_value('customer_port_id')){ echo "selected='selected' ";}  }?>><?php  echo $port_master_id['vchr_portoffice_name'];?></option>

             <?php } ?>

               

           </select> 

           </div>
		   </div> <!-- end of row -->
          

<!--//---------------------------------------------------->

</div>

	   <div class="row oddrows">
           <div class="col-md-6 mt-2">
           		<span class="eng-content offset-6 text-content-left">
		 Please enter the code<font color="#FF0000">*</font>
		</span>
		 </div>
           <div class="col-md-4 mt-2">
		 <input name="captcha" type="text" class="validate[required,custom[onlyLetterNumber]]"  id="captcha" autocomplete="off"  placeholder="Enter Captcha" size="10" maxlength="4" style="text-align:center" onKeyPress="return event.charCode >= 48 && event.charCode <= 57" required="true" title="Please Enter the Captcha !!!!">
					<?php $rr=base64_encode($_SESSION['cap_code']);?>
					 <img src="<?php echo base_url()?>captcha.php?id=<?php echo $code; ?>" id="capchaimg"/>
						 <input name="pass2" type="hidden" class="tb4" id="pass2" size="24"  value=<?php echo $rr;?>>
						 
					<img src="<?php echo base_url()?>plugins/img/Refresh.png"  style="cursor:pointer" id="captchareload"  >
					</div></div>

  		<div class="row px-5 py-5">
 		
        <div class="col-12 d-flex justify-content-center">

		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />

		<?php if(isset($int_designation_sl)){?>

		 <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />

		<?php } else{?>

		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save"/>





		<?php } ?>

       &nbsp; <a class="btn btn-danger" href="<?php echo base_url()."index.php/Main_login/index"?>">Cancel</a> </span>

        </div>

        </div>   
		   <?php echo form_close(); ?>

</div>
</section>