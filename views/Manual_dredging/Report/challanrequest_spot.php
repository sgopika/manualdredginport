<?php
/********************************************************************/
 $code=rand(1000,9999);
	$_SESSION["cap_code"]=$code;
 /*******************************************************************/
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

      <script src=<?php echo base_url("assets/aadhar/Verhoeff.js");?>></script>

     <script type="text/javascript"> 

	 	$(document).ready(function()

			  {
			
			//---------------------------------------------------------------------
			$("#trotpenter").hide();
	$("#spotenter").hide();
	//------------------------------otp send--------------------------------------------
	$('#btn_otp').click(function()
				{
					var tokenno=$('#txt_token').val();
					
   						$.post("<?php echo $site_url?>/Report/challan_requestspot/",{tokenno:tokenno},function(data)
						{
							//alert(data);exit;
							if(data==0)
							{
								alert("Error!!!!! OTP not delivered");
							}
							else
							{
								$("#trphoneno").hide();
								$("#trotp").hide();
								$("#trotpenter").show();

								//$('#trotp').html(data);
							}
							//alert(data);exit;
							
							//$('#trotp').html(data);
						});
					/*}*/
				});
				
		//-------------------------------------------------------------------------------------------
	$('#btn_check').click(function()
				{
					var otpno=$('#txt_otp').val();
					
   						$.post("<?php echo $site_url?>/Report/spot_otpcheck/",{otpno:otpno},function(data)
						{
							//alert(data);exit;
							if(data==0)
							{
								alert("Error!!!!!! Invalid OTP.......");
							}
							else
							{
								
								$("#trotp").hide();
								$("#trphoneno").hide();
								$("#trotpenter").hide();
								$("#spotenter").show();
								
								//var phoneno=$('#txt_phone1').val();
								//$('#txt_phone').val(phoneno);
								//$('#trotp').html(data);
							}
							//alert(data);exit;
							
							//$('#trotp').html(data);
						});
					/*}*/
				});
	
		//------------------------------------------------	

			 
	   

	  

			  });

	   </script>

	  <script type="text/javascript">

	$(document).ready(function() {

		jQuery.validator.addMethod("no_special_check", function(value, element) {

        	return this.optional(element) || /^[a-zA-Z0-9\s.-]+$/.test(value);

		});

		   	

			jQuery.validator.addMethod("namewithspace", function(value, element) {

			return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);

			},$.validator.format("<font color='red'>Characters and Space allowed.</span>"));

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

		jQuery.validator.addMethod("exactlength", function(value, element, param) {

		 		return this.optional(element) || value.length == param;

			}, $.validator.format("<font color='red'>Please enter exactly {0} characters.</span>"));

  		$("#addzone").validate({

		rules: {

				txt_username: {

					required: true,

					namewithspace:true,

					//no_special_check: true,

					maxlength: 25,

				},

				txt_adhaar: {

					required: true,

					number:true,

					exactlength:12,

				},

				txt_phone: {

					required: true,

					number:true,

					minlength: 10,

					maxlength: 10,

				},

				txt_ton: {

					required: true,

					number:true,

					maxlength: 2,

				},

				txt_place: {

					required: true,

					maxlength: 20,

				},

				txt_route: {

					required: true,

					maxlength: 500,

				},

				txt_distance: {

					required: true,

					number:true,

					maxlength: 3,

				},

				portdc: {

					required: true,

					

				},

		},

		messages: {

				txt_username: {

					required: "<font color='#FF0000'> Enter Username!!</font>",

					maxlength: "<font color='#FF0000'> Maximum 25 characters allowed!!</font>",

				},

				txt_adhaar: {

					required: "<font color='#FF0000'> Adhaar No required!!</font>",

					number: "<font color='#FF0000'> Only Numberss!!</font>",

					minlength: "<font color='#FF0000'> Minimum 12 characters needed!!</font>",

					maxlength: "<font color='#FF0000'> Maximum 12 characters allowed!!</font>",

				},

				txt_phone: {

					required: "<font color='#FF0000'> Phone required!!</font>",

					number: "<font color='#FF0000'> Only Numberss!!</font>",

					minlength: "<font color='#FF0000'> Minimum 10 characters needed!!</font>",

					maxlength: "<font color='#FF0000'> Maximum 10 characters allowed!!</font>",

				},

				txt_ton: {

					required: "<font color='#FF0000'> Tone needed required!!</font>",

					number: "<font color='#FF0000'> Only Numberss!!</font>",

					maxlength: "<font color='#FF0000'> Maximum 2 characters allowed!!</font>",

				},

				txt_place: {

					required: "<font color='#FF0000'> Unloading place needed!!</font>",

					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",

				},

				txt_route: {

					required: "<font color='#FF0000'> Unloading place needed!!</font>",

					maxlength: "<font color='#FF0000'> Maximum 500 characters allowed!!</font>",

				},

				txt_distance:{

					required: "<font color='#FF0000'> Total Distance required!!</font>",

					number: "<font color='#FF0000'> Only Numberss!!</font>",

					maxlength: "<font color='#FF0000'> Maximum 3 characters allowed!!</font>",

				},

				portdc:{

					required: "<font color='#FF0000'> Please select Port !!!!!</font>",

					

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



    <section class="content-header">

     <h1>

         <button class="btn btn-primary btn-flat disabled" type="button" > 

		Spot Registration </button>

      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>

         <li><a href="<?php echo site_url("Master/dashboard"); ?>"> Master</a></li>

        <li><a href="#"><strong>Spot Registration</strong></a></li>

      </ol>

    </section>
<?php  $sess_spottoken			=  $this->session->userdata('sess_spot_token'); ?>
    <!-- Main content -->

    <section class="content">

      <div class="row custom-inner">

        <div class="col-md-9">

          <!-- /.box -->

        <div class="box" >

        <?php if($this->session->flashdata('msg'))

		{ 

		   	echo $this->session->flashdata('msg');

		}

		?>

      <!--      </div> -->

		  

            

        <div class="box box-primary box-blue-bottom">

            <div class="box-header ">

              <h3 class="box-title">Challan Download</h3>

              <hr />

              <?php // print_r($zas);

			   $attributes = array("class" => "form-horizontal", "id" => "addzone", "name" => "addzone"); 

			  echo form_open('Report/add_spot_registrationnew',$attributes);

			  ?>

                  <table  class="table table-bordered table-striped">
                  <!----------------------------------------->
                   <tr id="trphoneno">
                    	<td>Enter Token No</td>
                        <td><input type="text" name="txt_token" id="txt_token" class="form-control" maxlength="10" required="required" autocomplete="off"/></td>
                    </tr>
                    
                    <tr id="trotp" ><td colspan="2" align="center" ><table ><tr ><td></td><td>
                    		
				
                 	  	<input id="btn_otp" name="btn_otp" type="button" class="btn btn-primary" value="Get"/>
                 	
					
                 	  	</td></tr></table></td></tr>
                  	  	<tr id="trotpenter" style="display:none;" ><td>Enter OTP</td><td><input type="text" name="txt_otp" id="txt_otp"  maxlength="6" required="required" onKeyPress="return event.charCode >= 48 && event.charCode <= 57" />&nbsp;&nbsp;<input id="btn_check" name="btn_check" type="button" class="btn btn-primary" value="Submit"/></td></tr>
                  	  	
                  	  	<tr><td colspan="2">
                  	<table id="spotenter" class="table table-bordered table-striped" style="display:none;" >
                    <!----------------------------------------->
<?php 
                   $get_last_d=$this->db->query("select spotreg_id from tbl_spotbooking where spot_token='$sess_spottoken'");
			$ph_no=$get_last_d->result_array();
		//echo $this->db->last_query();//exit();
			$bukid=$ph_no[0]['spotreg_id'];
						?>
					<tr><td>Token Number</td><td><?php echo $sess_spottoken; ?></td></tr>

					<tr>

      					 <td>Download Challan</td>

      						 <td>
      						 <a  class="button" href="<?php echo site_url('Report/getchallan/'.encode_url($bukid)); ?>"><button class="btn btn-primary btn-flat" type="button" >Download Challan</button></a>

         </td>



       </tr>

	  					</table>
						</td></tr>
      

       	   		  </table>
     </div>

        </div>

            </div>

            

        

            <!-- /.box-header -->

           

            <!-- form start -->

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

  </section>

 <script>

  $(function () {

    //Initialize Select2 Elements

   // $(".select2").select2();



    //Datemask dd/mm/yyyy

    $("#vch_material_sd").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    //Datemask2 mm/dd/yyyy

    $("#vch_material_ed").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});

    //Money Euro

    $("[data-mask]").inputmask();





  });

  $(function(){

	  $("#vch_material_sd").datepicker();

	  $("#vch_material_ed").datepicker();

	  });

</script>

