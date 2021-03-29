

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

			  $("#txt_adhaar").change(function()

       			{

				//alert("h");

            	var strVal = $("#txt_adhaar").val();

            	if (strVal.length < 12) // Minimum length.

            	{

             	 	alert("UID less than 12 digit");

				  	$("#txt_adhaar").val('');

				 	$( "#txt_adhaar" ).focus();

            	}

				else if(strVal.verhoeffCheck() == false)

				{

               		alert("Invalid Aadhar Number");

                	$("#txt_adhaar").val('');

				 	$( "#txt_adhaar" ).focus();

            	}

				else

				{

					var txt_adhar = $("#txt_adhaar").val();

					$.post("<?php echo $site_url?>/Report/get_interval_stat/",{txt_adhar:txt_adhar},function(data)

						{

							//var int_vel=data

							//alert(data);

							if(data==1)

							{

								alert("booking not allowed");

								$("#txt_adhaar").val('');

				 				$("#txt_adhaar" ).focus();

							}

							//$('#show').html(data);

						});

				}

			

       });

	    $("#txt_phone").change(function()

       			{

					var txt_phone = $("#txt_phone").val();

					$.post("<?php echo $site_url?>/Report/get_interval_stat_phone/",{txt_phone:txt_phone},function(data)

						{

							//var int_vel=data

							//alert(data);

							if(data==1)

							{

								alert("booking not allowed");

								$("#txt_phone").val('');

				 				$("#txt_phone" ).focus();

							}

							//$('#show').html(data);

						});

					

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

				txt_username: {

					required: true,

					//no_special_check: true,

					maxlength: 25,

				},

				txt_adhaar: {

					required: true,

					number:true,

					minlength: 12,

					maxlength: 12,

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

	$('#btn_rep').click(function()

				{

					var zone=$('#int_zone').val();

					var fromd=$('#vch_material_sd').val();

					//alert(fromd);

					//var tod=$('#vch_material_ed').val();

					//var dateArf = fromd.split('/');

                    //var newDatef = dateArf[2] + '/' + dateArf[1] + '/' + dateArf[0].slice(-2);

				//	var dateArt = tod.split('/');

                  //  var newDatet = dateArt[2] + '/' + dateArt[1] + '/' + dateArt[0].slice(-2);

					//alert(newDatet);

					/*if(newDatef > newDatet)

					{

   						alert("Invalid Date Range");

					}

					else

					{*/

   						$.post("<?php echo $site_url?>/Report/gen_salereport/",{zone:zone,fromd:fromd},function(data)

						{

							$('#show').html(data);

						});

					/*}*/

				});

				

});

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

              <h3 class="box-title">Spot Registration&nbsp;&nbsp;&nbsp;

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo site_url(); ?>/Report/spot" title="Go to SpotBooking Home"> <span class="glyphicon glyphicon-home" aria-hidden="false"></span></a></h3>

              <hr />

              <?php // print_r($zas);

			   $attributes = array("class" => "form-horizontal", "id" => "addzone", "name" => "addzone"); 

			  echo form_open('Report/add_spot_registration',$attributes);

			  ?>

                  <table  class="table table-bordered table-striped">

                    <tr>

                    	<td>Enter Customer Name</td>

                    	<td><input type="text" name="txt_username" id="txt_username"  class="form-control" required="required" /></td>

                    </tr>

                    <tr>

                    	<td>Enter Adhaar No</td>

                        <td><input type="text" name="txt_adhaar" id="txt_adhaar"  class="form-control" required="required" maxlength="12" /></td>

                    </tr>

                    <tr>

                    	<td>Enter Phone No</td>

                        <td><input type="text" name="txt_phone" id="txt_phone" class="form-control" maxlength="10" required="required"/></td>

                    </tr>

                    <tr>

                    	<td>Enter Ton Needed</td>

                        <td><select name="txt_ton" id="txt_ton" class="form-control" required>

                        <option value="" selected="selected">select</option>
						<?php
						if($po_id==16)
						{
						?>
                        <option value="10">10</option>
                        <option value="16">16</option>
                        <?php
						}
						?>
                        <option value="3">3</option>

                        <option value="5">5</option>

                        <option value="7">7</option>

                        </select></td>

                    </tr>

                    <tr>

                    	<td>Unloading Place</td>

                        <td><input type="text" name="txt_place" id="txt_place" class="form-control" maxlength="100" required="required"/></td>

                    </tr>

                    <tr>

                    	<td>Route</td>

                        <td>

                        <textarea name="txt_route" id="txt_route" class="form-control"></textarea>

                        </td>

                    </tr>

                    <tr>

                    	<td>Distance in KM</td>

                        <td><input type="text" name="txt_distance" id="txt_distance" class="form-control" maxlength="10" required="required"/></td>

                    </tr>

       	   		  </table>

            </div>

            <div class="form-group">

        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">

		

		<input id="btn_change" name="btn_add" type="submit" class="btn btn-primary" value="Register"/>

        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />

       

        </div>

        </div>

        

            <!-- /.box-header -->

           

            <!-- form start -->

 		<div class="form-group">

        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">



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

