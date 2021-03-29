
<?php 
foreach($isAdharExistOld as $row){?>
<td colspan="2">
		
		<!--//--------------------------------------->
		<table width="95%" class="table table-bordered table-striped">
        <tr >
      		<td>Name<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_name" value="<?php echo $row['vchr_requester_name'];?>" id="customer_name"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
      	</tr>
        
        <tr >
      		<td>Mobile Number <font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_phone_number" value="<?php if(isset($customer_phone_number )){echo $customer_phone_number;} else { echo set_value('customer_phone_number');} ?>" id="customer_phone_number"  class="form-control"  maxlength="10"  autocomplete="off" required/> </td>
      	</tr>
        
        <tr >
      		<td>Email</td>
      		<td ><input type="text" name="customer_email" value="<?php if(isset($customer_email )){echo $customer_email;} else { echo set_value('customer_email');} ?>" id="customer_email"  class="form-control"  maxlength="100"  autocomplete="off" /> </td>
      	</tr>
        
         <tr >
      		<td colspan="2" align="center" style="background-color:#9BDADD"><font color="#330099" style="text-align:center; font-weight:bold;">Present Address Details</font></td>
		</tr>
        
        <tr >
      		<td>House Number<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_perm_house_number" value="<?php echo $row['vchr_requester_house_no']; ?>" id="customer_perm_house_number"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
      	</tr>
        
        <tr >
      		<td>House Name<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_perm_house_name" value="<?php echo $row['vchr_Perm_house_name']; ?>" id="customer_perm_house_name"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
      	</tr>
        
         <tr >
      		<td>Place<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="customer_perm_place" value="<?php if(isset($customer_perm_place )){echo $customer_perm_place;} else { echo set_value('customer_perm_place');} ?>" id="customer_perm_place"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
      	</tr>
        
		<tr >
		<tr >
      		<td>District<font color="#FF0000">*</font></td>
      		<td>
          <select name="customer_perm_district_id" id="customer_perm_district_id"   class="form-control"  >
           	 <option value="">SELECT</option>
           	<?php foreach($array_perm_dist_id as $perm_distid){?>
			
			<option value="<?php  echo $perm_distid['district_id'];?>" <?php if(isset($customer_perm_district_id)){
			   if($customer_perm_district_id==$perm_distid['district_id']){?> selected="selected"<?php  } }else { if($perm_distid['district_id']== set_value('customer_perm_district_id')){ echo "selected='selected' ";}  }?>><?php  echo $perm_distid['district_name'];?></option>
             <?php } ?>
	        </select> 
           </td>
      	</tr>
		 <tr><td id="displayone" colspan="2" >
		<table width="95%" class="table table-bordered table-striped">
		<tr  >
      		<td width="41%">Local Body<font color="#FF0000">*</font></td>
      		<td >
            <select name="customer_perm_lsg_id" id="customer_perm_lsg_id"   class="form-control"  >
           	 <option value="">SELECT</option>
           	<?php foreach($array_localbody as $perm_localbody){?>
			
			<option value="<?php  echo $perm_localbody['panchayath_sl'];?>" <?php if(isset($customer_perm_lsg_id)){
			   if($customer_perm_lsg_id==$perm_localbody['panchayath_sl']){?> selected="selected"<?php  } }else { if($perm_localbody['panchayath_sl']== set_value('customer_perm_lsg_id')){ echo "selected='selected' ";}  }?>><?php  echo $perm_localbody['panchayath_name'];?></option>
             <?php } ?>
		  </select> 
           </td>
      	</tr>
		<tr>
      		<td>Post Office <font color="#FF0000">*</font></td>
      		<td>
           <select name="customer_perm_post_office" id="customer_perm_post_office"   class="form-control"  >
           	 <option value="">SELECT</option>
           		<?php foreach($array_perm_postoff_id as $perm_postoff_id){?>
               	<option value="<?php  echo $perm_postoff_id['PostOfficeId'];?>" <?php if(isset($customer_perm_post_office)){
			   if($customer_perm_post_office==$perm_postoff_id['PostOfficeId']){?> selected="selected"<?php  } }else { if($perm_postoff_id['PostOfficeId']== set_value('customer_perm_post_office')){ echo "selected='selected' ";}  }?>><?php  echo $perm_postoff_id['vchr_BranchOffice'];?></option>
             <?php } ?>
           </select> 

            </td>
      	</tr>
		</table></td></tr>
           <tr >
      		<td width="41%">Pincode<font color="#FF0000">*</font></td>
      		<td id="permpincode"><input type="text" name="customer_perm_pin_code" value="<?php if(isset($customer_perm_pin_code )){echo $customer_perm_pin_code;} else { echo set_value('customer_perm_pin_code');} ?>" id="customer_perm_pin_code"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
      	</tr>
          <tr >
      		<td colspan="2" align="center" style="background-color:#9BDADD"><font color="#330099" style="text-align:center; font-weight:bold;">Work Site Address Details</font><label style="float:right; color:#000066;">Same as Above</label><input type="checkbox" name="workingtoo" onclick="FillAddressdata(this.form)" style=" float:right"></td>
		</tr>
     
        <tr >
            <td>Site Address/House Name<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_work_house_name" value="<?php if(isset($customer_work_house_name )){echo $customer_work_house_name;} else { echo set_value('customer_work_house_name');} ?>" id="customer_work_house_name"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
        
         <tr >
            <td>Place<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_work_place" value="<?php if(isset($customer_work_place )){echo $customer_work_place;} else { echo set_value('customer_work_place');} ?>" id="customer_work_place"  class="form-control"  maxlength="100" onchange="adduploadplace()" onblur="adduploadplace()"  autocomplete="off" required/> </td>
        </tr>
        <tr  >
            <td>District<font color="#FF0000">*</font></td>
            <td >
           <select name="customer_work_district_id" id="customer_work_district_id"   class="form-control"  >
             <option value="">SELECT</option>
            <?php foreach($array_perm_dist_id as $districtcode){?>
				<option value="<?php  echo $districtcode['district_id'];?>" <?php if(isset($customer_work_district_id)){
			   if($customer_work_district_id==$districtcode['district_id']){?> selected="selected"<?php  } }else { if($districtcode['district_id']== set_value('customer_work_district_id')){ echo "selected='selected' ";}  }?>><?php  echo $districtcode['district_name'];?></option>
             <?php } ?>
	           
           </select> 
           </td>
        </tr>
		<tr><td id="displaytwo" colspan="2" >
		<table width="95%" class="table table-bordered table-striped">
		<tr >
            <td width="41%">Local Body<font color="#FF0000">*</font></td>
            <td>
          <select name="customer_work_lsg_id" id="customer_work_lsg_id"   class="form-control"  >
             <option value="">SELECT</option>
            <?php foreach($array_localbody as $work_localbody){?>
			<option value="<?php  echo $work_localbody['panchayath_sl'];?>"  <?php if(isset($customer_work_lsg_id)){
			   if($customer_work_lsg_id==$work_localbody['panchayath_sl']){?> selected="selected"<?php  } }else { if($work_localbody['panchayath_sl']== set_value('customer_work_lsg_id')){ echo "selected='selected' ";}  }?>><?php  echo $work_localbody['panchayath_name'];?></option>
             <?php } ?>
          </select> 
           </td>
        </tr>
        <tr >
            <td>Post Office <font color="#FF0000">*</font></td>
            <td>
            <select name="customer_work_post_office" id="customer_work_post_office"   class="form-control"  >
             <option value="">SELECT</option>
                <?php foreach($array_perm_postoff_id as $work_post_off_id)
				{?>
					<option value="<?php  echo $work_post_off_id['PostOfficeId'];?>" <?php if(isset($customer_work_post_office)){
			   if($customer_work_post_office==$work_post_off_id['PostOfficeId']){?> selected="selected"<?php  } }else { if($work_post_off_id['PostOfficeId']== set_value('customer_work_post_office')){ echo "selected='selected' ";}  }?>><?php  echo $work_post_off_id['vchr_BranchOffice'];?></option>
             <?php } ?>
				
          </select> 
            
            </td>
        </tr>
        </table></td></tr>
         <tr >
            <td width="41%">Pincode<font color="#FF0000">*</font></td>
            <td  id="workpincodenew"><input type="text" name="customer_work_pin_code" value="<?php if(isset($customer_work_pin_code )){echo $customer_work_pin_code;} else { echo set_value('customer_work_pin_code');} ?>" id="customer_work_pin_code"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
		<tr><td colspan="2"  align="center" bgcolor="#EFAD72" style="color:#000000; text-align:center;"><label> Requested Ton :-<?php echo $row['vchr_purpose_total_qnty'] ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Alloted Ton :- <?php echo $row['vchr_purpose_total_qnty']-$row['Int_Quantity'];?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Balance Ton :- <?php echo $row['Int_Quantity'];?></label></td></tr>
       <tr >
            <td>Purpose <font color="#FF0000">*</font></td>
            <td>
           <select name="customer_purpose" id="customer_purpose"   class="form-control"  onchange="checkconstruction();">
             <option value="">SELECT</option>
			 
                <?php foreach($array_customer_pur as $customer_purpose_id){?>
               <option value="<?php  echo $customer_purpose_id['construction_master_id'];?>"  <?php if(isset($customer_purpose)){
			   if($customer_purpose==$customer_purpose_id['construction_master_id']){?> selected="selected"<?php  } }else { if($customer_purpose_id['construction_master_id']== set_value('customer_purpose')){ echo "selected='selected' ";}  }?>><?php  echo $customer_purpose_id['construction_master_name'];?></option>
             <?php } ?>
           </select> 
            
            </td>
        </tr>
        
        <tr id="plintharea_tr" style="display:none" >
            <td>Plinth Area (in sq.m)<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_plinth_area" value="<?php if(isset($customer_plinth_area )){echo $customer_plinth_area;} else { echo set_value('customer_plinth_area');} ?>" onchange="maxton_calculate();" id="customer_plinth_area"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
        
         <tr >
            <td>Maximum required ton<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_max_allotted_ton" value="<?php if(isset($customer_max_allotted_ton )){echo $customer_max_allotted_ton;} else { echo set_value('customer_max_allotted_ton');} ?>" id="customer_max_allotted_ton"  class="form-control"  maxlength="100"   autocomplete="off" required/> <label id="lbldisplay"></label></td>
        </tr>
        
        <tr >
            <td><label id="lblpermitno">Permit Number</label><font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_permit_number" value="<?php if(isset($customer_permit_number )){echo $customer_permit_number;} else { echo set_value('customer_permit_number');} ?>" id="customer_permit_number"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
        
        <tr >
      		 <td><label id="lblpermitdate">Permit Date</label><font color="#FF0000">*</font></td>
      		<td>
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
                <input type="text" class="form-control"  value="<?php echo @$start_date?>" name="customer_permit_date" id="start_date"  />
              </div>
				<span id="startdatediv" ></span>
            
            </td>
      	</tr>
        
        <tr >
            <td>Permit Authority <font color="#FF0000">*</font></td>
            <td>
           <?php /*?><select name="customer_permit_authority" id="customer_permit_authority"   class="form-control"  >
             <option value="">SELECT</option>
                <?php foreach($array_zone_id as $zone_id){?>
                <option value="<?php  echo $zone_id['zone_id'];?>" <?php if(isset($get_userposting_details[0]['int_userpost_designation_sl'])){
               if($get_userposting_details[0]['int_userpost_designation_sl']==$designation_get['int_designation_sl']){?> selected="selected"<?php  } }else { if($designation_get['int_designation_sl']== set_value('designation')){ echo "selected='selected' ";}  }?>><?php  echo $designation_get['vch_designation_name'];?></option>
             <?php } ?>
           </select> <?php */?>
            <input type="text" name="customer_permit_authority" value="<?php if(isset($customer_permit_authority )){echo $customer_permit_authority;} else { echo set_value('customer_permit_authority');} ?>"  id="customer_permit_authority"  class="form-control" readonly="true"  maxlength="100" autocomplete="off" required/>
            </td>
        </tr>
     
         <tr >
      		<td>Route to the worksite<font color="#FF0000">*</font></td>
      		 <td><textarea name="customer_worksite_route" id="customer_worksite_route" cols="45" rows="5" class="form-control" required><?php if(isset($customer_worksite_route )){echo $customer_worksite_route;} else { echo set_value('customer_worksite_route');} ?></textarea></td>
      	</tr>
        
        <tr >
            <td>Distance to the worksite<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_worksite_distance" value="<?php if(isset($customer_worksite_distance )){echo $customer_worksite_distance;} else { echo set_value('customer_worksite_distance');} ?>" id="customer_worksite_distance"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
        
        <tr >
            <td>Unloading place<font color="#FF0000">*</font></td>
            <td ><input type="text" name="customer_unloading_place" value="<?php if(isset($customer_unloading_place )){echo $customer_unloading_place;} else { echo set_value('customer_unloading_place');} ?>" id="customer_unloading_place" readonly="true"  class="form-control"  maxlength="100"  autocomplete="off" required/> </td>
        </tr>
        
        <tr >
            <td>Upload Aadhar<font color="#FF0000">*</font>(File size must not exceed 200 KB & jpg/pdf format only)</td>
            <td ><input type="file" name="userfile[]"    required><!--<input id="btn_viewUpload" name="btn_viewUpload" type="file" class="btn btn-primary" value="Upload" /><input type="file" name="customer_aadhar_upload" id="customer_aadhar_upload"  accept="image/*" data-rule-required="true" data-msg-accept="Your message"  />--> </td>
        </tr>
        
        <tr >
            <td><label id="lblpermit">Upload Building Permit</label><font color="#FF0000">*</font>(File size must not exceed 200 KB & jpg/pdf format only)</td>
            <td ><input type="file" name="userfile[]"   required ><!--<input id="btn_permitUpload" name="btn_permitUpload" type="file" class="btn btn-primary" value="Upload" /><input type="file" name="customer_building_permit_upload" id="customer_building_permit_upload"  accept="image/*" data-rule-required="true" data-msg-accept="Your message"   />--> </td>
        </tr>
        
        <tr >
            <td>Select the desired port<font color="#FF0000">*</font></td>
            <td>
           <select name="customer_port_id" id="customer_port_id"   class="form-control"  >
             <option value="">SELECT</option>
			
            <?php foreach($array_portmaster as $port_master_id){?>
			
			 <option value="<?php  echo $port_master_id['int_portoffice_id'];?>"  <?php if(isset($customer_port_id)){
			   if($customer_port_id==$port_master_id['int_portoffice_id']){?> selected="selected"<?php  } }else { if($port_master_id['int_portoffice_id']== set_value('customer_port_id')){ echo "selected='selected' ";}  }?>><?php  echo $port_master_id['vchr_portoffice_name'];?></option>
             <?php } ?>
               
           </select> 
           </td>
        </tr>
        
<!--//---------------------------------------------------->
</table>
</td>
<?php } ?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src=<?php echo base_url("assets/plugins/jQuery/jquery-2.2.3.min.js");?>></script>
  	<script src="<?php echo base_url('assets/dist/js/jquery.validate.js');?>"></script>
    <script>
    $(document).ready(function() {
		$("#btn_cancel").click(function(){
			
			window.location = "<?php echo site_url('Master/dashboard');?>";
						
			});
        
    });
    </script>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href=<?php echo base_url("assets/bootstrap/css/bootstrap.css"); ?>>
  <!-- Font Awesome -->
  <link rel="stylesheet" href=<?php echo base_url("assets/dist/css/css/font-awesome.min.css"); ?>>
  <!-- Ionicons -->
  <link rel="stylesheet" href=<?php echo base_url("assets/dist/css/css/ionicons.min.css"); ?>>
  <!-- DataTables -->
  <link rel="stylesheet" href=<?php echo base_url("assets/plugins/datatables/dataTables.bootstrap.css"); ?>>
  
  <link rel="stylesheet" href=<?php echo base_url("assets/plugins/icheck/all.css"); ?>>
 
  <!-- Theme style -->
  <link rel="stylesheet" href=<?php echo base_url("assets/dist/css/AdminLTE.css"); ?>>
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href=<?php echo base_url("assets/dist/css/skins/_all-skins.css"); ?>>
  <?php /*?>
  <script src="<?php echo site_url('assets/jquery-1.3.1.min.js.js'); ?>"></script>
  <script src="<?php echo site_url('assets/jquery.validate.min.js');?>"></script>  
<?php */?>

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
<link rel="stylesheet" href=<?php echo base_url("assets/datepicker-bootsrap/css/datepicker.css"); ?> rel="stylesheet" media="screen">
   <script src="<?php echo base_url('assets/datepicker-bootsrap/js/bootstrap-datepicker.js');?>"></script>
   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>
      <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>
<script type="text/javascript">
$(document).ready(function()
{

	$('#customer_perm_post_office').change(function()
				{
					var customerperm_post_office=$('#customer_perm_post_office').val();
					
					$.post("<?php echo $site_url?>/Master/getPermPincode/",{custmer_perm_postoff:customerperm_post_office},function(data)
						{
						
							$('#permpincode').html(data);
						});
				});
				$('#customer_work_post_office').change(function()
				{
					var customerwork_post_office=$('#customer_work_post_office').val();
					$.post("<?php echo $site_url?>/Master/getWorkPincode/",{customerwork_post_office:customerwork_post_office},function(data)
						{
						
							$('#workpincodenew').html(data);
						});
				});
				
				$('#customer_perm_district_id').change(function()
				{
				
					var customer_perm_distid=$('#customer_perm_district_id').val();
					
					$.post("<?php echo $site_url?>/Master/getPanchayathAjaxcustomerperm/",{customer_perm_distid:customer_perm_distid},function(data)
						{
					
 							$('#displayone').html(data);
						});
				});
				$('#customer_work_district_id').change(function()
				{
					var customerwork_distid=$('#customer_work_district_id').val();
					//var customerwork_post_office=$('#customer_work_post_office').val();
					$.post("<?php echo $site_url?>/Master/getPanchayathAjaxcustomerwork/",{customerwork_distid:customerwork_distid},function(data)
						{
							$('#displaytwo').html(data);
						});
				});
				
				$('#customer_max_allotted_ton').change(function()
				{
					var requestedton=$('#customer_max_allotted_ton').val();
					var construct_masterid=$('#customer_purpose').val();
					
					$.post("<?php echo $site_url?>/Master/Checkallotedton/",{requestedton:requestedton,construct_masterid:construct_masterid},function(data)
						{
					//	alert(data);
						if(data==1){document.getElementById("lbldisplay").innerHTML ='';}else{ alert("Please select Purpose"); $( "#customer_max_allotted_ton" ).val('');$( "#customer_max_allotted_ton" ).focus();}
							
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
		document.getElementById("lblpermit").innerHTML ="Upload Building Permit";
		document.getElementById("lblpermitno").innerHTML ="Building Permit Number";
		document.getElementById("lblpermitdate").innerHTML ="Permit Date";
		
	}
	else
	{
		$("#plintharea_tr").css("display","none");
		document.getElementById("customer_max_allotted_ton").value='';
		
		document.getElementById("lbldisplay").innerHTML ="Maximum Ton alloted is 6 !!!";
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