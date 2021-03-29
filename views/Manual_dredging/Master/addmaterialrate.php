<?php
//print_r($_REQUEST);
?>

  <link rel="stylesheet" href=<?php echo base_url("assets/plugins/datepicker/datepicker3.css"); ?>>
   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>
      <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>
      <script src=<?php echo base_url("assets/datepicker-bootsrap/js/bootstrap-datepicker.js");?>></script>
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
  		$("#matrate").validate({
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
		<span class="badge bg-darkmagenta innertitle mt-2">Material Rate</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_dir_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/material_rate"); ?>"><strong>Material Rate</strong></a></li>
		<li class="breadcrumb-item"><a href="<?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?>"><strong> Material Rate </strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 


        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      <!--      </div> -->
		  
            
      <?php
			
			   if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Material Rate </h3>
           
          
            <?php 
			
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "matrate", "name" => "matrate", "onSubmit" => "return validate_chk();");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "matrate", "name" => "matrate", "onSubmit" => "return validate_chk();");
			}
        
		
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Master/materiaratel_master_edit", $attributes);
		} else {
		echo form_open("Manual_dredging/Master/materialrate_add", $attributes);
			
		}
			$emat=$material_ex;
			$ex_mat=explode(',',$emat);
		?>
		 <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo encode_url($int_userpost_sl);} ?>" />
		
             Material<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_material"  id="int_material"  class="form-control"  maxlength="100">
            <?php 
			if(isset($int_userpost_sl))
			{
				foreach($material as $mat)
				{
				?>
				<option value="<?php echo $mat['material_master_id']; ?>" <?php if($mat['material_master_id']==$material_rate[0]['materialrate_port_material_master_id']){ ?> selected="selected" <?php } ?>><?php echo $mat['material_master_name']; ?></option>
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
           <input type="text" name="vch_material_amt" value="<?php if(isset($int_userpost_sl)){ echo $material_rate[0]['materialrate_port_amount'];} ?>" id="vch_material_amt"  class="form-control"  maxlength="100" autocomplete="off" /> 
           </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Start Date<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           
           <input type="date" name="vch_material_sd" value="<?php if(isset($int_userpost_sl)){ echo $material_rate[0]['materialrate_port_start_date'];}else { echo date('d/m/Y');} ?>" id="vch_material_sd"  class="form-control"   maxlength="100" autocomplete="off" /> 
           
            <span id="startdatediv" ></span>
           </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			End Date<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            
                   <?php
				   if(isset($int_userpost_sl)){
				  if($material_rate[0]['materialrate_port_end_date']!='0000-00-00')
				  {
				  $end_date=$material_rate[0]['materialrate_port_end_date']; 
				  }
				  else
				  {
					   $end_date='';
				  }
				   }
				   ?>
           <input type="date" name="vch_material_ed" <?php if(isset($int_userpost_sl)){} else {?> disabled="disabled" <?php }?> value="<?php if(isset($int_userpost_sl)){ echo $end_date; }?>" id="vch_material_ed"  class="form-control" maxlength="100" autocomplete="off" />
           
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
            <option value="<?php echo $s['status_id'];?>" <?php if($s['status_id']==$material_rate[0]['materialrate_port_status']) { ?> selected="selected" <?php } ?> ><?php echo $s['status_name'];?></option>
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
           
  		 
 		<<div class="row px-5">
 		
        <div class="col-12 d-flex justify-content-center">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_designation_sl)){?>
		 <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save"/>


		<?php } ?>
         &nbsp;<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" /><br/>
        </div>
        </div>
		

    
       <?php echo form_close(); ?>
</div> <!-- end of container -->