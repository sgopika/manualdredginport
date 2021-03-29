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
	$("input[type=password]").keyup(function()
	{ 
	    var ucase = new RegExp("[A-Z]+");
		var lcase = new RegExp("[a-z]+");
		var num = new RegExp("[0-9]+");

		if($("#n_p").val().length >= 8)
		{
			$("#8char").removeClass("fa-times text-danger");
			$("#8char").addClass("fa-check text-success");
			$("#8char").css("color","#00A41E");
		}
		else
		{
			$("#8char").removeClass("fa-check text-success");
			$("#8char").addClass("fa-times text-danger");
			$("#8char").css("color","#FF0004");
		}

		if($("#n_c_p").val().length >= 8)
		{
			$("#8char1").removeClass("fa-times text-danger");
			$("#8char1").addClass("fa-check text-success");
			$("#8char1").css("color","#00A41E");
		}
		else
		{
			$("#8char1").removeClass("fa-check text-success");
			$("#8char1").addClass("fa-times text-danger");
			$("#8char1").css("color","#FF0004");
		}

		if(ucase.test($("#n_p").val()))
		{
			$("#ucase").removeClass("fa-times text-danger");
			$("#ucase").addClass("fa-check text-success");
			$("#ucase").css("color","#00A41E");
		}
		else
		{
			$("#ucase").removeClass("fa-check text-success");
			$("#ucase").addClass("fa-times text-danger");
			$("#ucase").css("color","#FF0004");
		}

		if(ucase.test($("#n_c_p").val()))
		{
			$("#ucase1").removeClass("fa-times text-danger");
			$("#ucase1").addClass("fa-check text-success");
			$("#ucase1").css("color","#00A41E");
		}
		else
		{
			$("#ucase1").removeClass("fa-check text-success");
			$("#ucase1").addClass("fa-times text-danger");
			$("#ucase1").css("color","#FF0004");
		}

		if(lcase.test($("#n_p").val()))
		{
			$("#lcase").removeClass("fa-times text-danger");
			$("#lcase").addClass("fa-check text-success");
			$("#lcase").css("color","#00A41E");
		}
		else
		{
			$("#lcase").removeClass("fa-check text-success");
			$("#lcase").addClass("fa-times text-danger");
			$("#lcase").css("color","#FF0004");
		}

		if(lcase.test($("#n_c_p").val()))
		{
			$("#lcase1").removeClass("fa-times text-danger");
			$("#lcase1").addClass("fa-check text-success");
			$("#lcase1").css("color","#00A41E");
		}
		else
		{
			$("#lcase1").removeClass("fa-check text-success");
			$("#lcase1").addClass("fa-times text-danger");
			$("#lcase1").css("color","#FF0004");
		}

		if(num.test($("#n_p").val()))
		{
			$("#num").removeClass("fa-times text-danger");
			$("#num").addClass("fa-check text-success");
			$("#num").css("color","#00A41E");
		}
		else
		{
			$("#num").removeClass("fa-check text-success");
			$("#num").addClass("fa-times text-danger");
			$("#num").css("color","#FF0004");
		}

		if(num.test($("#n_c_p").val()))
		{
			$("#num1").removeClass("fa-times text-danger");
			$("#num1").addClass("fa-check text-success");
			$("#num1").css("color","#00A41E");
		}
		else
		{
			$("#num1").removeClass("fa-check text-success");
			$("#num1").addClass("fa-times text-danger");
			$("#num1").css("color","#FF0004");
		}

		if($("#n_p").val() == $("#n_c_p").val())
		{
			$("#pwmatch").removeClass("fa-times text-danger");
			$("#pwmatch").addClass("fa-check text-success");
			$("#pwmatch").css("color","#00A41E");
		}
		else
		{
			$("#pwmatch").removeClass("fa-check text-success");
			$("#pwmatch").addClass("fa-times text-danger");
			$("#pwmatch").css("color","#FF0004");
		}
	});
		
  	$("#changepassword").validate({
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
					minlength: 10,
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

 	$("#n_p").change(function()
 	{
		var np=$("#n_p").val();
		//alert(np);
		var upperCase= new RegExp('[^A-Z]');
		var lowerCase= new RegExp('[^a-z]');
		var numbers = new RegExp('[^0-9]');
		var format = new RegExp('[!@#$%^&*()]') ;
		
		if((np.match(upperCase)) && (np.match(lowerCase)) && (np.match(numbers)) && (np.match(format)) && ((np.length>=10) && (np.length<=20)))
		{
		 // alert("password ok");

		}
		
		else
		{
		   alert("Your password must be between 10 and 20 characters. It must contain a mixture of upper and lower case letters, special character and at least one number");
		  $("#n_p").val('');
		   $("#n_p").focus();
		}
 	});

 	$("#n_c_p").change(function()
 	{
 		var np=$("#n_p").val();
 		var ncp=$("#n_c_p").val();
 		if(np!=ncp)
 		{
 			 alert("Password Mismatch");
 			 $("#n_c_p").val('');
 			 $("#n_c_p").focus();
 		}	
 	});



 /*_____________End of jquery____________________*/	
});
</script>

<?php
foreach($user_header as $u_h_dat_res){
      $uname      =   $u_h_dat_res['user_master_name'];
      $uid        =   $u_h_dat_res['user_master_id'];
      $utyp       =   $u_h_dat_res['user_type_id'];
    }
 ?>


<div class="main-content ui-innerpage">
	<div class="row no-gutters p-3 ">
	  	<div class="col-4  breaddiv " >
	    	<span class="badge bg-darkmagenta innertitle "> Change Password </span>
	  	</div>  <!-- end of col4 -->

  		<div class="col-8">
			<nav aria-label="breadcrumb">
  				<ol class="breadcrumb justify-content-end">
     				<?php if($utyp==11){?>
     					<li><a href="<?php echo $site_url."/Kiv_Ctrl/Survey/SurveyHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
     				<?php } else if($utyp==3){?>
     					<li><a href="<?php echo $site_url."/Main_login/pc_dashboard"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
     				<?php } ?>	
  				</ol>
			</nav>
		</div> <!-- end of col-8 -->
	</div>   <!-- end of row -->
    
    <?php 
 //print_r($user_header);


    
    	if( $this->session->flashdata('msg')){ 

		   	echo $this->session->flashdata('msg');

		}
			
       	$attributes = array("class" => "form-horizontal", "id" => "changepassword", "name" => "changepassword","autocomplete" => "off");
				
	echo form_open("Kiv_Ctrl/Survey/ch_pw", $attributes);
		///echo form_open("Main_login/ch_pw", $attributes);
			
	?> 
            
    <div class="row no-gutters p-3 ">
        <div class="col-12 p-2" id="msg"></div> 
        <div class="col-12">
        	<div class="row no-gutters p-1 bg-white">
        <div class="col-3 p-2 ">
        	<span class="text-darkslategray" > Current Password<font color="#FF0000">&nbsp;*</font> </span>
        </div>	<!-- end of col 3 -->
        <div class="col-9 p-2">
  			<input type="password" name="c_p"  id="c_p"  class="form-control col-4 btn-point"  maxlength="20" autocomplete="off" />
  			<input type="hidden" name="uname_hid" id="uname_hid" value="<?php echo $uname;?>">
  			<input type="hidden" name="u_id" id="u_id" value="<?php echo $uid;?>">
  		</div>	<!-- end of col 9 -->
  		</div> <!-- end of inner row -->
  		<div class="row no-gutters p-1 ">
		 <div class="col-3 p-2 text-darkslategray">
        	New Password<font color="#FF0000">&nbsp;*</font>
        </div>	<!-- end of col 3 -->
        <div class="col-9 p-2 text-darkslategray">
  			<input type="password" name="n_p"  id="n_p"  class="form-control col-4 btn-point" minlength="10" maxlength="20" autocomplete="off" />
  			<i id="8char" class="fas fa-times text-danger"></i> 10 Characters Long  &nbsp;&nbsp;
			<i id="ucase" class="fas fa-times text-danger"></i> One Uppercase Letter &nbsp;&nbsp;
			<i id="lcase" class="fas fa-times text-danger"></i> One Lowercase Letter &nbsp;&nbsp;
			<i id="num" class="fas fa-times text-danger"></i> One Number
  		</div>   <!-- end of col 9 -->
  		</div> <!-- end of inner row -->
  		<div class="row no-gutters p-1 bg-white">
  		<div class="col-3 p-2 text-darkslategray">
        	 Confirm Password<font color="#FF0000">&nbsp;*</font>
        </div>	 <!-- end of col 3 -->
        <div class="col-9 p-2 text-darkslategray">
  			<input type="password" name="n_c_p" id="n_c_p"  class="form-control col-4 btn-point" minlength="10" maxlength="20" autocomplete="off" />
  			<i id="8char1" class="fas fa-times text-danger"></i> 10 Characters Long &nbsp;&nbsp;
			<i id="ucase1" class="fas fa-times text-danger"></i> One Uppercase Letter &nbsp;&nbsp;
			<i id="lcase1" class="fas fa-times text-danger"></i> One Lowercase Letter &nbsp;&nbsp;
			<i id="num1" class="fas fa-times text-danger"></i> One Number <br>
			<i id="pwmatch" class="fas fa-times text-danger" style="color:#FF0004;"></i> Passwords Match	
  		</div>  <!-- end of col 9 -->  
  		</div> <!-- end of inner row -->
  		<div class="row no-gutters px-1 py-2 bg-gray-active">  		
  		<div class="col-6 d-flex justify-content-end px-2">
  		<input id="btn_add" name="btn_add" type="submit" class="btn btn-point btn-flat bg-darkmagenta px-2 " value="Change Password"/>
      	</div> <!-- end of col6 -->
      	<div class="col-6 d-flex justify-content-start px-2">
      	<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-point bg-light-blue-active btn-flat  px-2 " value="Cancel" />
      	</div> <!-- end of col 6 -->
      	</div> <!-- end of inner row -->
		</div> <!-- end of col 12 -->
    </div> <!-- /.row -->
    <?php echo form_close(); ?>
  </div> <!-- end of container main-content -->
 