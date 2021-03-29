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
				$('#txt_un').change(function()
				{
					var txt_un=$('#txt_un').val();
   						$.post("<?php echo $site_url?>/Manual_dredging/Report/get_usr_det/",{txt_un:txt_un},function(data)
						{
							$('#show').html(data);
						});
				});	
				$('#txt_mob').change(function()
				{
					var txt_mob=$('#txt_mob').val();
   						$.post("<?php echo $site_url?>/Manual_dredging/Report/chk_mob_user/",{txt_mob:txt_mob},function(data)
						{
							if(data==0)
							{
								$('#btnact').removeAttr("disabled");
							}
							else
							{
								$('#btnact').attr("disabled", "disabled");
								$('#txt_mob').val('');
								alert("mobile number already exist!!!!");
							}
						});
				});				
});
</script>
<!-------------------------------------------------------------------------------->
 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Blocked Users</span>
	</div>  <!-- end of col4 -->
	<?php 
	$sess_user_type			=	$this->session->userdata('int_usertype');
	 //echo "fff".$sess_user_type;
	if($sess_user_type==3)
	{ 
		$url=site_url("Manual_dredging/Master/pcdredginghome");
	 }
	  else
	   {
	    $url=site_url('Manual_dredging/Port/port_clerk_main');
	}
	?>
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Report/userman_home"); ?>"> User management</a></li>
          <li class="breadcrumb-item"><a href="#"><strong>Blocked Users</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
<div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>
 <?php
			  echo form_open('Manual_dredging/Report/act_usr');
			  ?>
			  
	<div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
          <a href="<?php echo site_url(); ?>/Manual_dredging/Report/userman_home" title="Go to Usermanagment"> <span class="glyphicon glyphicon-home" aria-hidden="false"></span></a>

         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->

		<div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Enter UserName
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="txt_un" id="txt_un" />
			 </div>
		</div> <!-- end of row -->
           <div class="row p-3" id="show"></div> <!-------------------------------------------- end of row -->
			 
             <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
             Enter Mobile No
			 </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			 <input type="text" name="txt_mob" id="txt_mob" maxlength="10"/>
			 </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			<input id="btnact" type="submit" value="Activate"  disabled="disabled"/> </div>
		</div> <!-- end of row -->
             <?php echo form_close(); ?>
</div> <!-- end of container -->
   