<script>
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
</script><?php
//print_r($_REQUEST);
?>
 
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
  		$("#asignzts").validate({
		rules: {
				int_zone: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				int_lsg: {
					required: true,
					maxlength: 20,
				},
				vch_sec_name: {
					required: true,
					no_special_check: true,
					maxlength: 20,
				},
				vch_sec_phone: {
					required: true,
					number:true,
					minlength: 10,
					maxlength: 10,
				},
		},
		messages: {
				int_zone: {
					required: "<font color='#FF0000'> Zone required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				int_lsg: {
					required: "<font color='#FF0000'> Lsgd Required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_sec_name: {
					required: "<font color='#FF0000'> Section Name required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
					no_special_check:"<font color='#FF0000'> Special characters not allowed!!</font>",
				},
				vch_sec_phone: {
					required: "<font color='#FF0000'> Lsgd Phone No Required!!</font>",
					number:"<font color='#FF0000'> Numbers only!!</font>",
					minlength:  "<font color='#FF0000'> 10 characters needed!!</font>",
					maxlength:"<font color='#FF0000'> Only 10 characters Allowed!!</font>",
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
	$('#int_zone').change(function()
				{
					var zone_id=$('#int_zone').val();
					//alert(zone_id)
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getLsgforZoneAjax/",{zone_id:zone_id},function(data)
						{
							//alert(data);
							if(data=="0")
							{
								$('#int_zone').val('');
								alert('material rate not set');
							}
							else
							{
							$('#int_lsgs').html(data);
							}
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
<!-------------------------------------------------------------------------------->
 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
<div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Assign Zone</button>
		</div>  <!-- end of col4 -->
	<div class="col-12 d-flex justify-content-end">
     
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
        
		 <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/assignzone_sec"); ?>"> Assign Zone to Section</a></li>
        <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Assign Zone to Section </strong></a></li>
      </ol>
    </div><!-- end of col-8 -->
	


</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
   <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>
   
   
   <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "asignzts", "name" => "userposting", "onSubmit" => "return validate_chk();");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "asignzts", "name" => "userposting", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Master/userpost_edit", $attributes);
		} else {
		echo form_open("Manual_dredging/Master/assignzonesec_add", $attributes);
			
		}
		$zone=$zone[0]['zoneid'];
			$zn=explode(',',$zone);
		?>
                  
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
            
           
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
	              Select Zone<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_zone"  id="int_zone"  class="form-control"  maxlength="100">
             <option selected="selected" value="">--select--</option>
            <?php
				foreach($zones as $z)
				{
					if(in_array($z['zone_id'],$zn))
					{
				?>
                	<option value="<?php echo $z['zone_id'] ?>"><?php echo $z['zone_name'] ?></option>
                <?php
					}
				}
				?>
            </select> 
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   LSG
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <div id="int_lsgs"></div>
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Section Name<font color="#FF0000">*</font>
		    </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <input type="text" name="vch_sec_name"  id="vch_sec_name"  class="form-control"  maxlength="20" autocomplete="off" /> 
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Section Phone<font color="#FF0000">*</font>
		    </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <input type="text" name="vch_sec_phone"  id="vch_sec_phone"  class="form-control"  maxlength="10" autocomplete="off" /> 
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
		
		
 <script>
  $(function () {
    //Initialize Select2 Elements
   // $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();


  });
</script>