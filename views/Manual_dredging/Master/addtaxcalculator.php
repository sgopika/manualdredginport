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
  		$("#taxcalc").validate({
		rules: {
				int_taxname: {
					required: true,
					//no_special_check: true,
					minlength: 1,
				},
				vch_material_amt: {
					required: true,
					//no_special_check: true,vch_material
					minlength: 1,
				},
				vch_material: {
					required: true,
					//no_special_check: true,vch_material
					minlength: 1,
				},
				vch_material_sd: {
					required: true,
					//maxlength: 20,
				},
				int_material_status: {
					required: true,
					maxlength: 20,
				},
		},
		messages: {
				int_taxname: {
					required: "<font color='#FF0000'> select atleast one!!</font>",
					minlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_material_amt: {
					required: "<font color='#FF0000'> Rate Required!!</font>",
					minlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_material: {
					required: "<font color='#FF0000'> select atleast one!!</font>",
					minlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_material_sd: {
					required: "<font color='#FF0000'> start date Required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				int_material_status: {
					required: "<font color='#FF0000'> Status Required!!</font>",
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
		<span class="badge bg-darkmagenta innertitle mt-2">Tax Calculator</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_dir_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/taxcalculator"); ?>"><strong>Tax Calculator</strong></a></li>
		 <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Tax Rate </strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 

        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      		  
        <?php
			
			   if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Tax Rate</h3>
            </div>
           
            <?php 
			
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "taxcalc", "name" => "taxcalc","onSubmit" => "return validate_chk();");
			} else {
				$zone=$taxname[0]['taxid'];
				$zn=explode(',',$zone);
       $attributes = array("class" => "form-horizontal", "id" => "taxcalc", "name" => "taxcalc", "onSubmit" => "return validate_chk();");
			}
        
		
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Master/taxcalculator_edit", $attributes);
		} else {
		echo form_open("Manual_dredging/Master/taxcalculator_add", $attributes);
			
		}?>
		
		 <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo encode_url($int_userpost_sl);} ?>" />
		
             Tax Name<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_taxname"  id="int_taxname"  class="form-control"  maxlength="100">
            <?php if(isset($int_userpost_sl))
			{
				foreach($taxname as $tname)
			{
			?>
            <option value="<?php echo $tname['taxname_master_id']; ?>" <?php if($tname['taxname_master_id']==$tax_rate[0]['tax_calculator_taxname_id']) {?> selected="selected" <?php } ?>><?php echo $tname['taxname_master_name'] ?></option>
            <?php
			}
				
			}
			else
			{
				
				?>
            <option selected="selected" value="">--select--</option>
            <?php
			foreach($taxnames as $tname)
			{
				if(in_array($tname['taxname_master_id'],$zn))
					{
			?>
            <option value="<?php echo $tname['taxname_master_id']; ?>"><?php echo $tname['taxname_master_name'] ?></option>
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
			Rate<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <input type="text" name="vch_material_amt" value="<?php if(isset($int_userpost_sl)){ echo $tax_rate[0]['tax_calculator_rate'];} ?>" id="vch_material_amt" class="form-control"  maxlength="100" autocomplete="off"  /> 
           </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Select Materials<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <?php
			if(isset($int_userpost_sl))
			{
			$qq=explode(',',$tax_rate[0]['tax_calculator_materials']); 
			foreach($material as $mat)
			{
			?>
           <input type="checkbox" name="vch_material[]" value="<?php echo $mat['material_master_id'] ?>" id="vch_material" <?php if(in_array($mat['material_master_id'],$qq)) { ?> checked="checked" <?php } ?>  />  <?php echo $mat['material_master_name']; ?> <br />
            <?php 
			}
			}
			else
			{
			foreach($material as $mat)
			{
			?>
           <input type="checkbox" name="vch_material[]" value="<?php echo $mat['material_master_id'] ?>" id="vch_designation_name"  />  <?php echo $mat['material_master_name']; ?> <br />
            <?php 
			}
			}
			?>
            </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Start Date<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            
           <input type="date" name="vch_material_sd" value="<?php if(isset($int_userpost_sl))
				  { echo date("d/m/Y", strtotime(str_replace('-', '/',$tax_rate[0]['tax_calculator_start_date'] ))) ;}else { echo date('d/m/Y');}?>" id="vch_material_sd"  class="form-control" onChange="check_dates();" data-mask  maxlength="100" autocomplete="off" /> 
            
            <span id="startdatediv" ></span>
           </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
  <?php
				  if(isset($int_userpost_sl))
				  {
				  if($tax_rate[0]['tax_calculator_end_date']!='0000-00-00')
				  {
				  $end_date=date("d/m/Y", strtotime(str_replace('-', '/',$tax_rate[0]['tax_calculator_end_date'] ))); 
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
            
           <input type="date" name="vch_material_ed" <?php if(!isset($int_userpost_sl)){ ?> disabled="disabled" <?php }?> value="<?php if(isset($int_userpost_sl))
				  { echo $end_date; }?>" id="vch_material_ed"  class="form-control"  onChange="check_dates();" data-mask  maxlength="100" autocomplete="off" />
           
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
            <option value="<?php echo $s['status_id'];?>" <?php if($s['status_id']==$tax_rate[0]['tax_calculator_status']) { ?> selected="selected" <?php } ?> ><?php echo $s['status_name'];?></option>
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
           
  		 
 		<div class="row px-5">
 		
        <div class="col-12 d-flex justify-content-center">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_designation_sl)){?>
		 <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save"/>


		<?php } ?>
         &nbsp;<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
        </div>
        </div>
		

    
          
      <?php echo form_close(); ?>
</div> <!-- end of container -->