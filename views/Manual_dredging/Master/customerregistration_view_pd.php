<?php

//print_r($_REQUEST);

?>
      <script type="text/javascript">

/*$(function(){

    $('#buttonfr').click(function(){

        if(!$('#iframe').length) {

                $('#iframeHolder').html('<iframe id="iframe" src="http://google.com" width="700" height="450"></iframe>');

        }

    });   

});*/

	$(document).ready(function(){

  $('#buttonfr').on('click', function(event) {        

     $('.testcl').toggle('show');

  });

});

  $(document).ready(function(){

  $('#buttonfrper').on('click', function(event) {        

     $('.testclper').toggle('show');

  });

});

</script>

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

	//var max_ton=(plintharea*0.33).toFixed(2);comment on 06/03/19 change tonnage as per request.

var max_ton=(plintharea*0.5).toFixed(2);

	if(max_ton>150)

	{

		alert("Plinth Area must be less than 300 ");

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

		

		document.getElementById("lbldisplay").innerHTML ="Maximum Ton alloted is 15 !!!";

	}

}

</script>
<!-- ------------------------------------------------------------------------------------->
 <div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Customer Registration</button>
		</div>
		
     <div class="col-12 d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_dir_main"); ?>"> Home</a></li>
         <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Customer Registration </strong></a></li>
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

 <?php 

			//print_r($get_userposting_details);

			// echo $get_userposting_details[0]['int_userpost_user_sl'];

			if(isset($int_userpost_sl)){

        $attributes = array("class" => "form-horizontal", "id" => "customerregistration_add", "name" => "customerregistration_add");

			} else {

       $attributes = array("class" => "form-horizontal", "id" => "customerregistration_add", "name" => "customerregistration_add", "onSubmit" => "return validate_chk();");

			}

        

		//print_r($editres); echo $editres[0]['intUserTypeID'];

		if(isset($int_userpost_sl)){

       		echo form_open("Manual_dredging/Master/customerregistration_view", $attributes);

		} else {

			echo form_open("Manual_dredging/Master/customerregistration_view", $attributes);

		}?>
		
		
		
		

		<div class="row p-3">
			<div class="col-md-6 d-flex justify-content-center px-2">
				<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
				<?php  foreach ($customerreg_details as $rowsmodule){ ?>
				Aadhar Number<font color="#FF0000">*</font>
				<input type="hidden" name="hid_custid" id="hid_custid" value="<?php echo $rowsmodule['customer_registration_id']; ?>" />
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
				<input type="text" name="customer_aadhar_number" value="<?php echo $rowsmodule['customer_aadhar_number'];?>" id="customer_aadhar_number" readonly class="form-control"  maxlength="100" onBlur="customer_aadhar_number()" autocomplete="off" />

				<?php /*?><a id="buttonfr"><font color="#CC0000">View Aadhaar uploaded</font></a>
	
						<iframe src="<?php echo site_url("Master/down_my_file");?>/<?php echo $rowsmodule['aadhar_uploadname'];?>" width="100%" height="300px" id="iframeHolder"  class="testcl" style="display:none;"></iframe><?php */?>
			</div>
		   </div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Name<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="customer_name" value="<?php echo $rowsmodule['customer_name']; ?>" id="customer_name"  class="form-control"  maxlength="100" onBlur="customer_name()" readonly autocomplete="off" />
			</div>
		   </div> <!-- end of row -->
      <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Mobile Number <font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		   <input type="text" name="customer_phone_number" value="<?php echo $rowsmodule['customer_phone_number']; ?>" id="customer_phone_number"  class="form-control" readonly maxlength="100" onBlur="customer_phone_number()" autocomplete="off" /> 
		  </div>
		   </div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Email<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		   <input type="text" name="customer_email" value="<?php echo $rowsmodule['customer_email_id']; ?>" id="customer_email"  class="form-control"  maxlength="100" onBlur="customer_email()" autocomplete="off" readonly />    
			</div>
		   </div> <!-- end of row -->
      <div class="row p-3">
				<div class="col-12" align="center"style="background-color:#9BDADD" >
				<font color="#330099" style="text-align:center; font-weight:bold;">Permenent Address Details</font>
				</div>
	</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">House Number<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		   <input type="text" name="customer_perm_house_number" value="<?php echo $rowsmodule['customer_perm_house_number']; ?>" id="customer_perm_house_number"  class="form-control" readonly maxlength="100" onBlur="customer_perm_house_number()" autocomplete="off" /> 
		  </div>
		   </div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   House Name<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		   <input type="text" name="customer_perm_house_name" value="<?php echo $rowsmodule['customer_perm_house_name']; ?>" id="customer_perm_house_name"  class="form-control"  maxlength="100" onBlur="customer_perm_house_name()" autocomplete="off" readonly />
		   </div>
	</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Place<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		   <input type="text" name="customer_perm_place" value="<?php echo $rowsmodule['customer_perm_house_place']; ?>" id="customer_perm_place"  class="form-control"  maxlength="100" onBlur="customer_perm_place()" autocomplete="off" readonly /> 
		   </div>
		   </div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   District<font color="#FF0000">*</font>
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">

				<select name="customer_perm_district_id" id="customer_perm_district_id"   class="form-control" disabled="disabled">
				<option value="">SELECT</option>

				<?php foreach($array_perm_dist_id as $perm_distid){?>
				<option value="<?php  echo $perm_distid['district_id'];?>" <?php if($perm_distid['district_id']==$rowsmodule['customer_perm_district_id']){?> selected="selected"<?php    }?>><?php  echo $perm_distid['district_name'];?></option>

				<?php } ?>

				</select> 
			</div>
		   </div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Local Body<font color="#FF0000">*</font>
		    </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
				<select name="customer_perm_lsg_id" id="customer_perm_lsg_id"   class="form-control" disabled="disabled"  >
				<option value="">SELECT</option>

				<?php foreach($array_permlocalbody as $perm_localbody){?>
				<option value="<?php  echo $perm_localbody['panchayath_sl'];?>" <?php if($perm_localbody['panchayath_sl']==$rowsmodule['customer_perm_lsg_id']){?> selected="selected"<?php    }?>><?php  echo $perm_localbody['panchayath_name'];?></option>

				<?php } ?>
				</select> 
			</div>
		   </div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Post Office <font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
				<select name="customer_perm_post_office" id="customer_perm_post_office"   class="form-control"  disabled="disabled" >
				<option value="">SELECT</option>
           		<?php foreach($array_perm_postoff_id as $perm_postoff_id){?>
               	<option value="<?php  echo $perm_postoff_id['PostOfficeId'];?>" <?php if($perm_postoff_id['PostOfficeId']==$rowsmodule['customer_perm_post_office']){?> selected="selected"<?php    }?>><?php  echo $perm_postoff_id['vchr_BranchOffice'];?></option>

             <?php } ?>

           </select> 
		</div>
		   </div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Pincode<font color="#FF0000">*</font>
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="customer_perm_pin_code" value="<?php echo $rowsmodule['customer_perm_pin_code']; ?>" id="customer_perm_pin_code"  class="form-control"  maxlength="100" onBlur="customer_perm_pin_code()" autocomplete="off"  readonly /> 
			</div>
		   </div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-12"   align="center" style="background-color:#9BDADD">

      		<font color="#330099" style="text-align:center; font-weight:bold;">Work Address Details</font>
			</div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">House Name<font color="#FF0000">*</font>
		    </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="customer_work_house_name" value="<?php  echo $rowsmodule['customer_work_house_name']; ?>" id="customer_work_house_name"  class="form-control"  maxlength="100" onBlur="customer_work_house_name()" autocomplete="off" readonly /> 
			</div>
		   </div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Place<font color="#FF0000">*</font>
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="customer_work_place" value="<?php  echo $rowsmodule['customer_work_house_place'];?>" id="customer_work_place"  class="form-control"  maxlength="100" onBlur="customer_work_place()" autocomplete="off" readonly /> 
			</div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   District<font color="#FF0000">*</font>
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <select name="customer_work_district_id" id="customer_work_district_id"   class="form-control" disabled="disabled"  >

             <option value="">SELECT</option>

            <?php foreach($array_work_dist_id as $districtcode){?>

				<option value="<?php  echo $districtcode['district_id'];?>" <?php if($districtcode['district_id']==$rowsmodule['customer_work_district_id']){?> selected="selected"<?php    }?>><?php  echo $districtcode['district_name'];?></option>

             <?php } ?>

           </select> 
		</div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Local Body<font color="#FF0000">*</font>
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">

           <select name="customer_work_lsg_id" id="customer_work_lsg_id"   class="form-control" disabled="disabled"  >

             <option value="">SELECT</option>

            <?php foreach($array_worklocalbody as $work_localbody){?>

			<option value="<?php  echo $work_localbody['panchayath_sl'];?>" <?php if($work_localbody['panchayath_sl']==$rowsmodule['customer_work_lsg_id']){?> selected="selected"<?php    }?>><?php  echo $work_localbody['panchayath_name'];?></option>

             <?php } ?>

          </select> 
		</div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Post Office <font color="#FF0000">*</font>
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">

           <select name="customer_work_post_office" id="customer_work_post_office"   class="form-control"  disabled="disabled" >

             <option value="">SELECT</option>

                <?php foreach($array_work_postoff_id as $work_post_off_id)

				{?>

					<option value="<?php  echo $work_post_off_id['PostOfficeId'];?>" <?php if($work_post_off_id['PostOfficeId']==$rowsmodule['customer_work_post_office']){?> selected="selected"<?php    }?>><?php  echo $work_post_off_id['vchr_BranchOffice'];?></option>

             <?php } ?>
          </select>
		  
		</div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Pincode<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="customer_work_pin_code" value="<?php echo  $rowsmodule['customer_work_pin_code']; ?>" id="customer_work_pin_code"  class="form-control"  maxlength="100" onBlur="customer_work_pin_code()" autocomplete="off" readonly /> 
			</div>
		</div> <!-- end of row -->
       
		

		<?php   

		$isAdharExistOld=$this->Master_model->get_customer_registrationOld($rowsmodule['customer_aadhar_number']); 

			if (count($isAdharExistOld)!=0)

			{ ?>

        
       <div class="row p-3">
           <div class="col-12" align="center" bgcolor="#EFAD72" style="color:#000000; text-align:center;">

        <label> Requested Ton :-<?php echo $isAdharExistOld[0]['vchr_purpose_total_qnty'] ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Alloted Ton :- <?php echo $isAdharExistOld[0]['vchr_purpose_total_qnty']-$isAdharExistOld[0]['Int_Quantity'];?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Balance Ton :- <?php echo $isAdharExistOld[0]['Int_Quantity'];?></label>
		</div>
		</div>

        

       <?php }?>
		<div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Purpose <font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">

				<select name="customer_purpose" id="customer_purpose"   class="form-control"   disabled="disabled" >
             <option value="">SELECT</option>
                <?php foreach($array_customer_pur as $customer_purpose_id){?>

               <option value="<?php  echo $customer_purpose_id['construction_master_id'];?>" <?php if($customer_purpose_id['construction_master_id']== $rowsmodule['customer_purpose']){?> selected="selected"<?php    }?>><?php  echo $customer_purpose_id['construction_master_name'];?></option>

             <?php } ?>

           </select> 
		</div>
		</div> <!-- end of row -->

       <div class="row p-3"  <?php if($rowsmodule['customer_purpose']!=1){?> style="display:none;" <?php }?>>
           <div class="col-md-6 d-flex justify-content-center px-2">
			Plinth Area (in sq.m)<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="customer_plinth_area" value="<?php echo $rowsmodule['customer_plinth_area']; ?>" id="customer_plinth_area"  class="form-control"  maxlength="100" onchange="maxton_calculate();" autocomplete="off" readonly /> 
			</div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Maximum required ton<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		   <input type="text" name="customer_request_ton" value="<?php echo $rowsmodule['customer_requested_ton']; ?>" id="customer_request_ton"  class="form-control"  readonly="true" maxlength="100"  autocomplete="off" /> 
		   </div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   PC Approved ton<font color="#FF0000">*</font>
		    </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		   <input type="text" name="customer_max_allotted_ton" value="<?php echo $rowsmodule['customer_max_allotted_ton']; ?>" id="customer_max_allotted_ton"  class="form-control"  maxlength="100" onBlur="customer_max_allotted_ton()" autocomplete="off" readonly /> 
		   </div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Permit Number<font color="#FF0000">*</font>
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="customer_permit_number" value="<?php echo $rowsmodule['customer_permit_number']; ?>" id="customer_permit_number"  class="form-control"  maxlength="100" onBlur="customer_permit_number()" autocomplete="off" required readonly/>

				<?php /*?><a id="buttonfrper"><font color="#CC0000">View Permit uploaded</font></a>

      		<iframe src="<?php echo site_url("Master/down_my_file");?>/<?php echo $rowsmodule['permit_uploadname'];?>" width="100%" height="300px" id="iframeHolder"  class="testclper" style="display:none;"></iframe><?php */?>

             </div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Permit Date<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">

         		<div class="input-group">

                  <div class="input-group-addon">

                    <i class="fa fa-calendar"></i>

                  </div>

				  <?php

				 /* if(isset( $get_userposting_details[0]['dte_userpost_startdate'])){

				$dte_userpost_startdate = $get_userposting_details[0]['dte_userpost_startdate'];

					$start_date = explode('-', $dte_userpost_startdate);

					$start_date =$start_date[2]."-".$start_date[1]."-".$start_date[0];

				  }



					$start_date = set_value('customer_permit_date') == true ?  set_value('customer_permit_date'): @$customer_permit_date ;*/ 

				  											

				  ?>

                  <input type="text" class="form-control"  value="<?php echo  date("d-m-Y", strtotime(str_replace('-', '/',$rowsmodule['customer_permit_date'] ))); ?>" name="customer_permit_date" id="start_date" data-inputmask="'alias': 'dd/mm/yyyy'" onChange="customer_permit_date();" readonly data-mask>

              </div>

				<span id="startdatediv" ></span>

            </div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Permit Authority <font color="#FF0000">*</font>
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">

           <?php /*?><select name="customer_permit_authority" id="customer_permit_authority"   class="form-control"  >

             <option value="">SELECT</option>

                <?php foreach($array_permit_authority as $zone_id){?>

				

				

                <option value="<?php  echo $zone_id['zone_id'];?>" <?php if(isset($get_userposting_details[0]['int_userpost_designation_sl'])){

               if($get_userposting_details[0]['int_userpost_designation_sl']==$designation_get['int_designation_sl']){?> selected="selected"<?php  } }else { if($designation_get['int_designation_sl']== set_value('designation')){ echo "selected='selected' ";}  }?>><?php  echo $designation_get['vch_designation_name'];?></option>

             <?php } ?>

           </select> <?php */?>

		   <input type="text" name="customer_permit_authority" value="<?php echo $rowsmodule['customer_permit_authority']; ?>" id="customer_permit_authority"  class="form-control"  maxlength="100" onBlur="customer_worksite_distance()" readonly autocomplete="off" />

         </div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Route to the worksite<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			 <textarea name="customer_worksite_route" id="customer_worksite_route" disabled="disabled" cols="45" rows="5" class="form-control" required><?php echo $rowsmodule['customer_worksite_route']; ?></textarea>
			 </div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Distance to the worksite<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="customer_worksite_distance" value="<?php echo $rowsmodule['customer_worksite_distance']; ?>" id="customer_worksite_distance" readonly  class="form-control"  maxlength="100" onBlur="customer_worksite_distance()" autocomplete="off" /> 
			</div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Unloading place<font color="#FF0000">*</font>
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="customer_unloading_place" value="<?php echo $rowsmodule['customer_unloading_place']; ?>" id="customer_unloading_place"  class="form-control"  maxlength="100" readonly onBlur="customer_unloading_place()" autocomplete="off" /> 
			</div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Upload Aadhar<font color="#FF0000">*</font>
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<a href="<?php echo site_url("Master/down_my_file");?>/<?php echo $rowsmodule['aadhar_uploadname'];?>"  target="_blank"><font color="#CC0000">Aadhaar</font></a>
			</div>
		</div> <!-- end of row -->
       <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Upload Building Permit/Tax Receipt<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<a href="<?php echo site_url("Master/down_my_file");?>/<?php echo $rowsmodule['permit_uploadname'];?>"  target="_blank"><font color="#CC0000">Building Permit</font> </a>
			</div>
		</div> <!-- end of row -->
     

        <?php } ?>
 
		
		
</div> <!-- end of container -->
 