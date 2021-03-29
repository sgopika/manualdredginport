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
  		$("#addqty").validate({
		rules: {
				"vch_material_amt[]": {
				 required: true,
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
				"vch_material_amt[]": {
					required: "<font color='#FF0000'> select atleast one!!</font>",
					minlength: "<font color='#FF0000'> select atleast one!!</font>",
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
 
</script>
   <div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Quantity</button>
		</div>
   <div class="col-12 d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
         <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/quantity_pc"); ?>"> quantity_pc</a></li>
        <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Quantity </strong></a></li>
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
      
       <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "addqty", "name" => "userposting","onSubmit" => "return validate_chk();");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "addqty", "name" => "userposting", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Master/quantity_pc_edit", $attributes);
		} else {
		echo form_open("Manual_dredging/Master/quantity_add", $attributes);
			
		}?>
     
   <!------------------------------------------------------------------------------------------------------------------------>  
       <div class="row p-3 -">
          <div class="col-md-6 d-flex justify-content-center px-2">
			<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo encode_url($int_userpost_sl);} ?>" />
				Select Quantity applicable at the port<font color="#FF0000">*</font> 
          </div>
           <div class="col-4 settingtab px-4 py-2" >
           <?php
			  
			if(isset($int_userpost_sl))
			{
			$qq=explode(',',$quantity[0]['quantity_master_id']); 
			?>
            <?php foreach($quantity_s as $qty)
			{		
				?>
             <input type="checkbox" name="vch_material_amt[]" value="<?php echo $qty['quantity_master_id']; ?>" id="vch_material_amt" <?php if(in_array($qty['quantity_master_id'],$qq)) { ?> checked="checked" <?php } ?>  /><?php echo $qty['quantity_master_name']; ?> &nbsp;
				<?php	
            }
			}
			else
			{
			foreach($quantity as $qty)
			{
				
			?>
           <input type="checkbox" name="vch_material_amt[]" value="<?php echo $qty['quantity_master_id']; ?>" id="vch_material_amt"  /><?php echo $qty['quantity_master_name']; ?> &nbsp;
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
      <input type="text" name="vch_material_sd" value="<?php if(isset($int_userpost_sl)){ echo date("d/m/Y", strtotime(str_replace('-', '/',$quantity[0]['quantity_start_date'] )));}else { echo date('d/m/Y');} ?>" id="vch_material_sd"  class="form-control"  data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  maxlength="100" autocomplete="off" /> 
      
      <span id="startdatediv" ></span>
       
         </div>
		</div> <!-- end of row -->
      <div class="row p-3">
		  <div class="col-md-6 d-flex justify-content-center px-2">
		  End Date<font color="#FF0000">*</font> 
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		   <?php
				  if(isset($int_userpost_sl))
				  {
				  if($quantity[0]['quantity_end_date']!='0000-00-00')
				  {
				  $end_date=date("d/m/Y", strtotime(str_replace('-', '/',$quantity[0]['quantity_end_date'] ))); 
				  }
				  else
				  {
					   $end_date='';
				  }
				  }
				  ?>
           <input type="text" name="vch_material_ed" value="<?php if(isset($int_userpost_sl)){ echo $end_date;} ?>" id="vch_material_ed"  class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'"  data-mask  maxlength="100" autocomplete="off" />
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
            <option value="<?php echo $s['status_id'];?>" <?php if($s['status_id']==$quantity[0]['quantity_status']) { ?> selected="selected" <?php } ?> ><?php echo $s['status_name'];?></option>
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
     <div class="row px-5 py-5">
 		
        <div class="col-12 d-flex justify-content-center">
        
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_userpost_sl)){?>
		
		 <input id="btn_add" name="btn_add" type="submit" class="px-4 btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class=" px-4 btn btn-primary" value="Save"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class=" mx-4 btn btn-danger" value="Cancel" />
     
         </div> <!-- end of col 12 -->
         
	</div> <!-- end of row -->
		<?php echo form_close(); ?>
</div> <!-- end of container -->
		  
		  
		  
		  
		  
		  
		  
		  
   <!-- ----------------------------------------------------------------------------------------------------------------------->
  
 <script>
  
  $(function(){
	  $("#vch_material_sd").datepicker();
	  $("#vch_material_ed").datepicker();
	  });
</script>