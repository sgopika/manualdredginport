

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

	$('#date_int').change(function()

				{

					var zone=$('#zone_int').val();

					var fromd=$('#date_int').val();

   						$.post("<?php echo $site_url?>/Report/get_alt_cus/",{zone:zone,fromd:fromd},function(data)

						{

							$('#show').html(data);

						});

				});				

});

</script>

<script>

$(document).ready(function()

{

	$('#lorry_reg').change(function()

				{

					//alert("hii");

					var lorry_reg=$('#lorry_reg').val();

					$.post("<?php echo $site_url?>/Report/Checkregistrationdoor/",{lorry_reg:lorry_reg},function(data)

						{
					//	alert(data);

							if(data==0)

							{

								$('#lorry_reg').val("");

								alert("Lorry already exist");

							}

						});

				});

	

});

</script>

    <section class="content-header">

     <h1>

         <button class="btn btn-primary btn-flat disabled" type="button" > 

		Lorry Registration

      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>

         <li><a href="<?php echo site_url("Master/dashboard"); ?>"> Master</a></li>

        <li><a href="#"><strong>Lorry Registration</strong></a></li>

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

              <h2 class="box-title">Lorry Registration</h2>

              <hr />

              <?php //print_r($zone);  //exit();

			  echo form_open_multipart('Report/doorlorry_reg');

			  ?>

                  <table  class="table table-bordered table-striped">
                  <tr>

      					 <td>Select Kadavu<font color="#FF0000">*</font></td>

      						 <td><select name="zoneid" id="zoneid" class="form-control">

                					<option selected="selected" value="">select</option>

               						 <?php 

										foreach($zone as $zn)

										{

										?>

                					<option value="<?php echo $zn['zone_id'];?>"><?php echo $zn['zone_name'];?></option>

                					<?php

										}

										?>

        						 </select>

         </td>



       </tr>

                	<tr>

                    	<td>Lorry Registration No</td>

                    	<td><input type="text" name="lorry_reg" id="lorry_reg" class="form-control" required="required" maxlength="13" />(Ex- KL-00-AJ-0000)</td>

                    </tr>

                    <tr>

                    	<td>Lorry Make</td>

                    	<td><input type="text" name="lorry_make" id="lorry_make" class="form-control" required="required" /></td>

                    </tr>

                    <tr>

                    	<td>Owner Name</td>

                        <td><input type="text" name="owner_name" id="owner_name"  class="form-control" required="required" /></td>

                    </tr>

                    <tr>

                    	<td>Owner Adhaar No</td>

                        <td><input type="text" name="owner_adno" id="owner_adno" class="form-control" minleangth=12 maxlength="12" minlength="12" /></td>

                    </tr>

                    <tr>

                    	<td>Contact No</td>

                        <td><input type="text" name="contct_no" id="contct_no" class="form-control" minleangth=10 maxlength="10" required="required" /></td>

                    </tr>

                    <tr>

                    	<td>Driver Name</td>

                        <td><input type="text" name="driver_name" id="driver_name"  class="form-control"/></td>

                    </tr>

                    <tr>

                    	<td>Driver License No</td>

                        <td><input type="text" name="driver_license" id="driver_license" class="form-control" maxlength="12"/></td>

                    </tr>

                    <tr>

                    	<td>Driver Contact No</td>

                        <td><input type="text" name="driver_mobile" id="driver_mobile" class="form-control" minleangth=10 maxlength="10" /></td>

                    </tr>

                    <tr>

                    	<td>Lorry Capacity</td>

                        <td><select  name="lorry_cap" id="lorry_cap" class="form-control"  required="required"/>

                        <option value="">selected</option>

                        <?php

                        if($zone_id==26)

						{

						?>

                        <option value="5">5</option>

                        <option value="7">7</option>

                        <?php

                        }

						else

						{

						?>

                        <option value="3">3</option>

                        <option value="5">5</option>

                        <option value="7">7</option>

                        <?php

						}

						?>

                        </select>

                        </td>

                    </tr>

                    <tr>

                    	<td>RC Book<span style="color:#FF0000">(Maximum file size allowed 500Kb(jpg/pdf files allowed))</span></td>

                        <td><input type="file" name="lorry_rc" id="lorry_rc"  class="form-control" required="required"/></td>

                    </tr>

       	   		  </table>

                  <div id="show"></div>
<div class="form-group">

        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">

		

		<input id="btn_change" name="btn_add" type="submit" class="btn btn-primary" value="Register"/>

        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />

       

        </div>

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

