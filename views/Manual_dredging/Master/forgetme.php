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
		$.validator.addMethod("alpha", function(value, element) {
               return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
		});
		jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
		}); 
  		$("#addbank").validate({
		rules: {
				c_p: {
					required: true,
					//no_special_check: true,
					//number:true,
					maxlength: 20,
				},
				n_p: {
					required: true,
					//alphanumeric: true,
					minlength: 8,
					maxlength: 20,
				},
				n_c_p: {
					required: true,
					//alphanumeric: true,
					//no_special_check: true,
					equalTo: "#n_p",
					maxlength: 20,
				},
		},
		messages: {
				c_p: {
					required: "<font color='#FF0000'> Current Password required!!</font>",
				//	alpha: "<font color='#FF0000'> only alphabets allowed!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				n_p: {
					required: "<font color='#FF0000'> Enter New Password!!</font>",
					//alpha: "<font color='#FF0000'> only alphabets allowed!!</font>",
					minlength: "<font color='#FF0000'> Minimum 8 characters needed!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				n_c_p: {
					required: "<font color='#FF0000'> Enter Password again!!</font>",
					//number: "<font color='#FF0000'> only numbers allowed!!</font>",
					equalTo:"<font color='#FF0000'> Password Mismatch!!</font>",
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
    <div class="main-content ui-innerpage">
	<div class="row no-gutters p-3 ">
	  	<div class="col-4  breaddiv " >
	    	<span class="badge bg-darkmagenta innertitle "> Forgot Password </span>
	  	</div>  <!-- end of col4 -->

  		<div class="col-8">
			<nav aria-label="breadcrumb">
  				<ol class="breadcrumb justify-content-end">
     				
     				
     					<li><a href="<?php echo base_url();?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
     					
  				</ol>
			</nav>
		</div> <!-- end of col-8 -->
	</div>   <!-- end of row -->
    <!-- Main content -->
    
      <div class="row">
        <div class="col-12">
          <!-- /.box -->
        
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      <!--      </div> -->
		  
            
        <div class="box box-primary box-blue-bottom">
            <div class="box-header ">
              <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "addbank", "name" => "addbank", "onSubmit" => "return validate_chk();");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "addbank", "name" => "addbank", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Main_login/forget_pw", $attributes);
		} else {
		echo form_open("Main_login/forget_pw", $attributes);
			
		}?>
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo encode_url($int_userpost_sl);} ?>" />
		
              <table id="example" class="table table-bordered table-striped">

      
        <tr >
  
      		<td>Username<font color="#FF0000">*</font></td>
      		<td>
              <input type="password" name="c_p"  id="c_p"  class="form-control"  maxlength="100" autocomplete="off" /> 
            
            </td>
      	</tr>
         <tr >
  
      		<td>Phone No<font color="#FF0000">*</font></td>
      		<td>
              <input type="password" name="n_p"  id="n_p"  class="form-control"  maxlength="15" autocomplete="off" /> 
            
            </td>
      	</tr>
         <tr >
  
      		<td>Confirm Phoneno<font color="#FF0000">*</font></td>
      		<td>
              <input type="password" name="n_c_p" id="n_c_p"  class="form-control"  maxlength="15" autocomplete="off" /> 
            
            </td>
      	</tr>
	  </table>
  		 
 		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_designation_sl)){?>
		 <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Change Password"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
        </div>
        </div>
		

    
          
              
		   <?php echo form_close(); ?>
<!--          </div>
            </div>
-->			 </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->
  
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