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
	$(document).ready(function() {
		jQuery.validator.addMethod("no_special_check", function(value, element) {
        	return this.optional(element) || /^[a-zA-Z0-9\s.-]+$/.test(value);
		});
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
  		$("#userposting").validate({
		rules: {
				int_material: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				vch_material_amt: {
					required: true,
					number: true,
					maxlength: 20,
				},
				vch_material_sd: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				int_material_status: {
					required: true,
					maxlength: 20,
				},
		},
		messages: {
				int_material: {
					required: "<font color='#FF0000'> Select Material required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_material_amt: {
					required: "<font color='#FF0000'> Material Amount Required!!</font>",
					number:"<font color='#FF0000'> numbers only!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_material_sd: {
					required: "<font color='#FF0000'> Start Date required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				int_material_status: {
					required: "<font color='#FF0000'>Status Required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
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
	$('#rangeoffice').change(function()
				{
					var rangeoffice=$('#rangeoffice').val();
					$.post("<?php echo $site_url?>/Master/getUnitAjax/",{range_office:rangeoffice},function(data)
						{
							$('#unit').html(data);
						});
				});
	$('#int_material').change(function()
				{
					var mat_id=$('#int_material').val();
					$.post("<?php echo $site_url?>/Master/getzoneAjax/",{mat_id:mat_id},function(data)
						{
							//alert("ffff");
							$('#shows').html(data);
						});
				});			
	$('#vch_material_amt_zone').click(function(){
		$('#show').toggle();
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
<!-------------------------------------------------------------------------------->
 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Material Rate</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
		<li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Material Rate </strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
   <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>

 <?php 
			print_r($get_userposting_details);
			 $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "userposting", "name" => "userposting");
			} else {
				$matids=explode(',',$matid);
       $attributes = array("class" => "form-horizontal", "id" => "userposting", "name" => "userposting", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Port/edit_mechmaterialrate_pc", $attributes);
		} else {
		echo form_open("Manual_dredging/Port/add_mech_matrate_pc", $attributes);
			
		}
		$emat=$material_ex;
		$ex_mat=explode(',',$emat);
		//print_r($ex_mat);exit;
		?>
	<div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){  echo encode_url($int_userpost_sl);  } ?>" />
             Material<font color="#FF0000">*</font>
			 </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_material"  id="int_material"  class="form-control"  maxlength="100" <?php if(isset($int_userpost_sl))
			{ ?> disabled="disabled"<?php } ?>>
            <?php 
			if(isset($int_userpost_sl))
			{
			foreach($material as $mat)
			{
			?>
            <option value="<?php echo $mat['material_master_id']; ?>" <?php if($mat['material_master_id']==$material_det[0]['material_id']){ ?> selected="selected" <?php } ?>><?php echo $mat['material_master_name']; ?></option>
            <?php
			}	
			}
			else
			{
			?>
            <option selected="selected" value="">--select--</option>
            <?php
			foreach($material as $mat)
			{
				if(!in_array($mat['material_master_id'],$ex_mat))
				{
			?>
            <option value="<?php echo $mat['material_master_id']; ?>"><?php echo $mat['material_master_name']; ?></option>
            <?php
				}
			}
			}
			?>
            </select> 
        </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Amount<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <input type="text" name="vch_material_amt"  <?php if(isset($int_userpost_sl)){ ?> value="<?php echo $material_det[0]['mat_amount'];?>" <?php } ?>id="vch_designation_name"  class="form-control"  maxlength="100" autocomplete="off" /> 
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Start Date<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
           <input type="text" name="vch_material_sd" value="<?php if(isset($int_userpost_sl)){ echo date("d/m/Y", strtotime(str_replace('-', '/',$material_det[0]['start_date'])));}else { echo date('d/m/Y');} ?>" id="vch_material_sd"  class="form-control"  data-inputmask="'alias': 'dd/mm/yyyy'" onChange="check_dates();" data-mask  maxlength="100" autocomplete="off" /> 
            </div>
            <span id="startdatediv" ></span>
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
  <?php
				   if(isset($int_userpost_sl)){
				  if($material_det[0]['end_date']!='0000-00-00 00:00:00')
				  {
				  $end_date=date("d/m/Y", strtotime(str_replace('-', '/',$material_det[0]['end_date'] ))); 
				  }
				  else
				  {
					   $end_date='';
				  }
				   }
				   ?>
      		End Date<font color="#FF0000">*</font>
			 </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
           <input type="text" name="vch_material_ed"<?php if(!isset($int_userpost_sl)){ ?> disabled="disabled" <?php }?> value="<?php if(isset($int_userpost_sl)){ echo $end_date; }?>" id="vch_material_ed"  class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" onChange="check_dates();" data-mask  maxlength="100" autocomplete="off" />
           </div>
            <span id="startdatediv" ></span> 
             </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Status<font color="#FF0000">*</font>
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_material_status"  id="int_material_status"  class="form-control"  maxlength="100">
            <?php if(isset($int_userpost_sl)){
				  foreach($status as $s)
			    {
				?>
            <option value="<?php echo $s['status_id'];?>" <?php if($s['status_id']==$material_det[0]['mdrate_status']) { ?> selected="selected" <?php } ?> ><?php echo $s['status_name'];?></option>
            <?php
			}
			}
			else
			{
			?>
            <option value="" selected="selected">--select--</option>
            <?php foreach($status as $s)
			{
				?>
            <option value="<?php echo $s['status_id'];?>" <?php if($s['status_id']==1) {?> selected="selected" <?php } ?>><?php echo $s['status_name'];?></option>
            <?php
			}
			}
			?>
            </select> 
            
            </div>
		</div> <!-- end of row -->
		
		 <div class="row px-5 py-5" >
 		
        <div class="col-12 d-flex justify-content-center">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_designation_sl)){?>
		 <input id="btn_add" name="btn_add" type="submit" class="px-4 btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class=" px-4 btn btn-primary" value="Save"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class=" mx-4 btn btn-danger" value="Cancel" />
    
         </div> <!-- end of col 12 -->
         
	</div> <!-- end of row -->
	
		<?php echo form_close(); ?>
</div> <!-- end of container -->
    