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
  		$("#addzone").validate({
		rules: {
				int_port: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				vch_un: {
					required: true,
					maxlength: 20,
				},
				vch_ph: {
					required: true,
					number:true,
					minlength: 10,
					maxlength: 10,
				},
				vch_email: {
					required: true,
					email_check:true,
					maxlength: 50,
				},
		},
		messages: {
				int_port: {
					required: "<font color='#FF0000'> select port!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_un: {
					required: "<font color='#FF0000'> username required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_ph: {
					required: "<font color='#FF0000'> Phone required!!</font>",
					number: "<font color='#FF0000'> Only Numberss!!</font>",
					minlength: "<font color='#FF0000'> Minimum 10 characters needed!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 10 characters allowed!!</font>",
				},
				vch_email: {
					required: "<font color='#FF0000'> email required!!</font>",
					email_check:"<font color='#FF0000'> valid email required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 50 characters allowed!!</font>",
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
	$('#vch_un').change(function()
				{
					var un=$('#vch_un').val();
					$.post("<?php echo $site_url?>/Master/ch_usrAjax/",{un:un},function(data)
						{
							if(data==1)
							{
								$('#chk_usr').html("username already exist !!");
							}
							else
							{
								$('#chk_usr').html("");
								 $('#btn_add').prop('disabled', false);
								//$('#chk_usr').html(data);
							}
						});
				});
				$('#int_ut').change(function()
				{
				
				var usertype=$('#int_ut').val();
				//alert(usertype);
					$.post("<?php echo $site_url?>/Report/get_userdataAjax/",{usertype:usertype},function(data)
						{
					//	alert(data); exit;
							//$('#zone').val(data);
							$('#int_userid').html(data);
							//$('#vch_un').prop('readonly',true);
						});	
				});
				$('#int_userid').change(function()
				{
					var userid=$('#int_userid').val();
					$.post("<?php echo $site_url?>/Report/get_zusrphAjax/",{userid:userid},function(data)
						{
							$('#vch_oldph').val(data);
							$('#vch_oldph').prop('readonly',true);
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
		PC User Phoneno change</button>
		</div>

    <div class="col-12 d-flex justify-content-end">
     
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
		        
        <li class="breadcrumb-item"><a href="#"><strong> PC User Phoneno change </strong></a></li>
      </ol>
    </div>
    <!-- Main content -->
    
        <div class="col-md-12">
          <!-- /.box -->
        
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      </div> <!-- end of co12 -->
		</div> <!-- end of row -->  
                

            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "addzone", "name" => "addzone");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "addzone", "name" => "addzone", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Report/pc_user_changephno", $attributes);
		} else {
		echo form_open("Manual_dredging/Report/pc_user_changephno", $attributes);
			
		}?>
                
                
               <div class="row p-3">
                    <div class="col-md-6 d-flex justify-content-center px-2">  
                
                
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		
       
         <?php
		 $zt=explode(',',$zones);
		 ?>
      		Port User Type<font color="#FF0000">*</font>
                   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_ut"  id="int_ut"  class="form-control"  maxlength="100">
            <option value="" selected="selected">--select--</option>
            <?php foreach($usert as $p)
			{
				
				?>
            <option value="<?php echo $p['user_type_id'];?>"><?php echo $p['user_type_type_name'];?></option>
            <?php
				
			}
			?>
            </select> 
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
               <div class="col-md-6 d-flex justify-content-center px-2">
                   Zone<font color="#FF0000">*</font>
               </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_userid"  id="int_userid"  class="form-control"  maxlength="100">
            <option value="" selected="selected">--select--</option>
            <?php foreach($zone as $z)
			{
				if(!in_array($z['zone_id'],$zt))
				{
				?>
            <option value="<?php echo $z['zone_id'];?>"><?php echo $z['zone_name'];?></option>
            <?php
				}
			}
			?>
            </select> 
             </div>
		</div> <!-- end of row -->
           <div class="row p-3">
               <div class="col-md-6 d-flex justify-content-center px-2">Old Phone Number<font color="#FF0000">*</font>
                </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <input type="text" name="vch_oldph" id="vch_oldph" autocomplete="off" class="form-control"  maxlength="10" />
           </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
                    New Phone Number<font color="#FF0000">*</font>
                </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <input type="text" name="vch_newph" id="vch_newph" autocomplete="off" class="form-control"  maxlength="10" />
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
                         