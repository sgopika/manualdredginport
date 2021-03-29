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
  		$("#addconst").validate({
		rules: {
				vch_construction_name: {
					required: true,
					no_special_check: true,
					minlength: 1,
				},
				vch_construction_max: {
					required: true,
					//no_special_check: true,
					number:true,
					minlength: 1,
				},
		},
		messages: {
				vch_construction_name: {
					required: "<font color='#FF0000'> Construction Name required!!</font>",
					no_special_check:"<font color='#FF0000'> No Special Characters allowed!!</font>",
					minlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_construction_max: {
					required: "<font color='#FF0000'> Construction Max Ton required!!</font>",
					number: "<font color='#FF0000'> numbers only!!</font>",
					minlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
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
		<span class="badge bg-darkmagenta innertitle mt-2">Construction</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_dir_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/construction_master"); ?>"><strong>Construction view</strong></a></li>
		<li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Construction </strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>

        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      <!--      </div> -->
		  
            
      
            <?php 
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "addconst", "name" => "addconst", "onSubmit" => "return validate_chk();");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "addconst", "name" => "addconst", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Master/construction_master_edit", $attributes);
		} else {
		echo form_open("Manual_dredging/Master/construction_add", $attributes);
			
		}?>
		
		<div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo encode_url($int_userpost_sl);} ?>" />
		
             Construction Name<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <input type="text" name="vch_construction_name" value="<?php if(isset($int_userpost_sl)){ echo $cnst[0]['construction_master_name'];} ?>" id="vch_construction_name"  class="form-control"  maxlength="100" autocomplete="off" /> 
            </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Max Ton<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <input type="text" name="vch_construction_max" value="<?php if(isset($int_userpost_sl)){ echo $cnst[0]['construction_master_max_ton'];} ?>" id="vch_construction_max"  class="form-control"  maxlength="100" autocomplete="off" /> 
            </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Start Date<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            
           <input type="text" name="vch_material_sd" value="<?php if(isset($int_userpost_sl)){ echo date("d/m/Y", strtotime(str_replace('-', '/',$cnst[0]['start_date'])));} else { echo date('d/m/Y');}?>" id="vch_material_sd"  class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  maxlength="100" autocomplete="off" /> 
            
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
				  if($cnst[0]['end_date']!='0000-00-00')
				  {
				  $end_date=date("d/m/Y", strtotime(str_replace('-', '/',$cnst[0]['end_date'] ))); 
				  }
				  else
				  {
					   $end_date='';
				  }
				   }
				   ?>
           <input type="text" name="vch_material_ed"<?php if(!isset($int_userpost_sl)){?> disabled="disabled" <?php }?> value="<?php if(isset($int_userpost_sl)){ echo $end_date; }?>" id="vch_material_ed"  class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  maxlength="100" autocomplete="off" />
           
            <span id="startdatediv" ></span> 
            </div>
		   </div> <!-- end of row -->
          
  		 
 		<div class="row px-5">
 		
        <div class="col-12 d-flex justify-content-center">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_userpost_sl)){?>
		 <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save"/>


		<?php } ?>
       &nbsp; <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
        </div>
        </div>
		

    
          
              
		   <?php echo form_close(); ?>
</div>