

<?php 
/********************************************************************/
 $code=rand(1000,9999);
	$_SESSION["cap_code"]=$code;
 /*******************************************************************/
foreach($isAdharExistOld as $row){

	$purpose=$row['vchr_purpose_ofmaterial'];

	if($row['Int_Quantity'] <3)

	{

			if($purpose==10){$customer_purpose=1;}else{$customer_purpose=2;}

	}

	else

	{

		if($purpose==10){$customer_purpose=2;}else{$customer_purpose=1;}
	

	}

	if($customer_purpose==1){$style='style="display:block"';}else{$style='style="display:none"';} ?>


		<div class="row evenrows">
          <div class="col-md-6 m-2">
            <span class="eng-content offset-6 text-content-left">
			Name<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_name" value="<?php if(isset($customer_name )){echo $isAdharExistOld[0]['	vchr_requester_name'];} else { echo set_value('customer_name');} ?>" id="customer_name"  class="form-control"  maxlength="100"  autocomplete="off" required/>
			 </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			Mobile Number <font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_phone_number" value="<?php if(isset($customer_phone_number )){echo $customer_phone_number;} else { echo set_value('customer_phone_number');} ?>" id="customer_phone_number"  class="form-control"  maxlength="10"  autocomplete="off" required/> 
			 </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			Email</span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_email" value="<?php if(isset($customer_email )){echo $customer_email;} else { echo set_value('customer_email');} ?>" id="customer_email"  class="form-control"  maxlength="100"  autocomplete="off" />
			</div>
		   </div> <!-- end of row -->
           <div class="row">
           <div class="col-12 m-2" style="background-color:#9BDADD">
      			<font color="#330099" style="text-align:center; font-weight:bold;">Present Address Details</font>
			</div>

		</div>

        <div class="row oddrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">

        House Number<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_perm_house_number" value="<?php if(isset($customer_perm_house_number )){echo $customer_perm_house_number;} else { echo set_value('customer_perm_house_number');} ?>" id="customer_perm_house_number"  class="form-control"  maxlength="100"  autocomplete="off" required/>
			</div>
			</div>
        <div class="row evenrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			House Name<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_perm_house_name" value="<?php if(isset($customer_perm_house_name )){echo $customer_perm_house_name;} else { echo set_value('customer_perm_house_name');} ?>" id="customer_perm_house_name"  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			</div>
			</div>
        <div class="row oddrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			Place<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_perm_place" value="<?php if(isset($customer_perm_place )){echo $customer_perm_place;} else { echo set_value('customer_perm_place');} ?>" id="customer_perm_place"  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			</div>
			</div>
        <div class="row evenrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			District<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">

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
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">


			Local Body<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">

            <select name="customer_perm_lsg_id" id="customer_perm_lsg_id"   class="form-control"  >

           	 <option value="">SELECT</option>

           	<?php foreach($array_localbody as $perm_localbody){?>

			

			<option value="<?php  echo $perm_localbody['panchayath_sl'];?>" <?php if(isset($customer_perm_lsg_id)){

			   if($customer_perm_lsg_id==$perm_localbody['panchayath_sl']){?> selected="selected"<?php  } }else { if($perm_localbody['panchayath_sl']== set_value('customer_perm_lsg_id')){ echo "selected='selected' ";}  }?>><?php  echo $perm_localbody['panchayath_name'];?></option>

             <?php } ?>

		  </select> 

         </div></div>
			
        <div class="row evenrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			Post Office <font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">

           <select name="customer_perm_post_office" id="customer_perm_post_office"   class="form-control"  >

           	 <option value="">SELECT</option>

           		<?php foreach($array_perm_postoff_id as $perm_postoff_id){?>

               	<option value="<?php  echo $perm_postoff_id['PostOfficeId'];?>" <?php if(isset($customer_perm_post_office)){

			   if($customer_perm_post_office==$perm_postoff_id['PostOfficeId']){?> selected="selected"<?php  } }else { if($perm_postoff_id['PostOfficeId']== set_value('customer_perm_post_office')){ echo "selected='selected' ";}  }?>><?php  echo $perm_postoff_id['vchr_BranchOffice'];?></option>

             <?php } ?>

           </select> 

</div></div></div>
<div class="row oddrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">

      		
			Pincode<font color="#FF0000">*</font></span>
			</div>
<div class="col-md-4 m-2" id="permpincode">
      		
			<input type="text" name="customer_perm_pin_code" value="<?php if(isset($customer_perm_pin_code )){echo $customer_perm_pin_code;} else { echo set_value('customer_perm_pin_code');} ?>" id="customer_perm_pin_code"  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			</div>

      	</div>
		<div class="row " style="background-color:#9BDADD">    
			<font color="#330099" style="text-align:center; font-weight:bold;">Work Site Address Details</font><label align="right" style="float:right; color:#000066;">Same as Above</label><input type="checkbox" name="workingtoo" onclick="FillAddressdata(this.form)" style=" float:right">
			</div>

		<div class="row evenrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">

			Site Address/House Name<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_work_house_name" value="<?php if(isset($customer_work_house_name )){echo $customer_work_house_name;} else { echo set_value('customer_work_house_name');} ?>" id="customer_work_house_name"  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			</div>
			</div>

        <div class="row oddrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			Place<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_work_place" value="<?php if(isset($customer_work_place )){echo $customer_work_place;} else { echo set_value('customer_work_place');} ?>" id="customer_work_place"  class="form-control"  maxlength="100" onchange="adduploadplace()" onblur="adduploadplace()"  autocomplete="off" required/> 
			</div>

        </div>

       <div class="row evenrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			District<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
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
		<div class="row oddrows"  >
           <div class="col-6 m-2"><span class="eng-content offset-6 text-content-left">
		
			Local Body<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">

          <select name="customer_work_lsg_id" id="customer_work_lsg_id"   class="form-control"  >

             <option value="">SELECT</option>

            <?php foreach($array_localbody as $work_localbody){?>

			<option value="<?php  echo $work_localbody['panchayath_sl'];?>"  <?php if(isset($customer_work_lsg_id)){

			   if($customer_work_lsg_id==$work_localbody['panchayath_sl']){?> selected="selected"<?php  } }else { if($work_localbody['panchayath_sl']== set_value('customer_work_lsg_id')){ echo "selected='selected' ";}  }?>><?php  echo $work_localbody['panchayath_name'];?></option>

             <?php } ?>

          </select> 

           </div>

        </div>

		<div class="row evenrows"  >
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			Post Office <font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">

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

        <div class="row oddrows" >
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			Pincode<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2" id="workpincodenew">

            
			<input type="text" name="customer_work_pin_code" value="<?php if(isset($customer_work_pin_code )){echo $customer_work_pin_code;} else { echo set_value('customer_work_pin_code');} ?>" id="customer_work_pin_code"  class="form-control"  maxlength="100"  autocomplete="off" required/>
			</div>

        </div>

	 <div class="row evenrows"  id="displaytwo">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			Purpose <font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
           <select name="customer_purpose" id="customer_purpose"   class="form-control"  onchange="checkconstruction();">

             <option value="">SELECT</option>

			 

                <?php foreach($array_customer_pur as $customer_purpose_id){?>

               <option value="<?php  echo $customer_purpose_id['construction_master_id'];?>"  <?php if(isset($customer_purpose)){

			   if($customer_purpose==$customer_purpose_id['construction_master_id']){?> selected="selected"<?php  } }else { if($customer_purpose_id['construction_master_id']== set_value('customer_purpose')){ echo "selected='selected' ";}  }?>><?php  echo $customer_purpose_id['construction_master_name'];?></option>

             <?php } ?>

           </select> 

            

            </div>

        </div>

         <div class="row oddrows"  id="plintharea_tr" style="display:none">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">

       
			Plinth Area (in sq.m)<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_plinth_area" value="<?php if(isset($customer_plinth_area )){echo $customer_plinth_area;} else { echo set_value('customer_plinth_area');} ?>" onchange="maxton_calculate();" id="customer_plinth_area"  class="form-control"  maxlength="100"  autocomplete="off" required/>
			 </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			Maximum required ton<font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_max_allotted_ton" value="<?php if(isset($customer_max_allotted_ton )){echo $customer_max_allotted_ton;} else { echo set_value('customer_max_allotted_ton');} ?>" id="customer_max_allotted_ton"  class="form-control"  maxlength="100"   autocomplete="off" required/> <label id="lbldisplay"></label>
			 </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			<label id="lblpermitno">Permit Number</label><font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_permit_number" value="<?php if(isset($customer_permit_number )){echo $customer_permit_number;} else { echo set_value('customer_permit_number');} ?>" id="customer_permit_number"  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			 </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			 <label id="lblpermitdate">Permit Date</label><font color="#FF0000">*</font></span>
			 </div>
           <div class="col-md-4 m-2">

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
           <div class="row oddrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
			Permit Authority <font color="#FF0000">*</font></span>
			</div>
           <div class="col-md-4 m-2">

          

            <input type="text" name="customer_permit_authority" value="<?php if(isset($customer_permit_authority )){echo $customer_permit_authority;} else { echo set_value('customer_permit_authority');} ?>"  id="customer_permit_authority"  class="form-control" readonly  maxlength="100" autocomplete="off" required/>

            </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 m-2">
			Route to the worksite<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			 <textarea name="customer_worksite_route" id="customer_worksite_route" cols="45" rows="5" class="form-control" required><?php if(isset($customer_worksite_route )){echo $customer_worksite_route;} else { echo set_value('customer_worksite_route');} ?></textarea>
			 </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 m-2">
			Distance to the worksite<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_worksite_distance" value="<?php if(isset($customer_worksite_distance )){echo $customer_worksite_distance;} else { echo set_value('customer_worksite_distance');} ?>" id="customer_worksite_distance"  class="form-control"  maxlength="100"  autocomplete="off" required/>
			 </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 m-2">
			Unloading place<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 m-2">
			<input type="text" name="customer_unloading_place" value="<?php if(isset($customer_unloading_place )){echo $customer_unloading_place;} else { echo set_value('customer_unloading_place');} ?>" id="customer_unloading_place" readonly  class="form-control"  maxlength="100"  autocomplete="off" required/> 
			 </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 m-2">
			Upload Aadhar<font color="#FF0000" size="2">*<br>(File size must not exceed 200 KB & jpg/pdf format only)</font>
			</div>
           <div class="col-md-4 m-2">
			<input type="file" name="userfile[]"  id="fileone"   required><!--<input id="btn_viewUpload" name="btn_viewUpload" type="file" class="btn btn-primary" value="Upload" /><input type="file" name="customer_aadhar_upload" id="customer_aadhar_upload"  accept="image/*" data-rule-required="true" data-msg-accept="Your message"  />--> 
			 </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 m-2">
			<label id="lblpermit">Upload Building Permit</label><font color="#FF0000" size="2">*<br>(File size must not exceed 200 KB & jpg/pdf format only)</font>
			</div>
           <div class="col-md-4 m-2">
			<input type="file" name="userfile[]"  id="filetwo"  required ><!--<input id="btn_permitUpload" name="btn_permitUpload" type="file" class="btn btn-primary" value="Upload" /><input type="file" name="customer_building_permit_upload" id="customer_building_permit_upload"  accept="image/*" data-rule-required="true" data-msg-accept="Your message"   />-->
			 </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 m-2">
			Select the desired port<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 m-2">

           <select name="customer_port_id" id="customer_port_id"   class="form-control"  >

             <option value="">SELECT</option>

			

            <?php foreach($array_portmaster as $port_master_id){?>

			

			 <option value="<?php  echo $port_master_id['int_portoffice_id'];?>"  <?php if(isset($customer_port_id)){

			   if($customer_port_id==$port_master_id['int_portoffice_id']){?> selected="selected"<?php  } }else { if($port_master_id['int_portoffice_id']== set_value('customer_port_id')){ echo "selected='selected' ";}  }?>><?php  echo $port_master_id['vchr_portoffice_name'];?></option>

             <?php } ?>

               

           </select> 

           </div>
		   </div> <!-- end of row -->
          

<?php } ?>




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
//--------------------------------------------------------------
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

						if(data==1){document.getElementById("lbldisplay").innerHTML ='';}else{ alert("Required ton is high"); $( "#customer_max_allotted_ton" ).val('');$( "#customer_max_allotted_ton" ).focus();}

							

						});

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

		var max_tonnew=100;

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

		$("#plintharea_tr").css("display","table-row");

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

var workplace=document.getElementById("customer_work_place").value;

document.getElementById("customer_unloading_place").value=workplace;

}

function FillAddressdata(f) {

  if(f.workingtoo.checked == true) {

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

}

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

  $(function () {

    


 $("#start_date").datepicker();

  });

  

 

</script>