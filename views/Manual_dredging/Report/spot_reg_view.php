

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

	

	

	

	

});

</script>

    <section class="content-header">

     <h1>

         <button class="btn btn-primary btn-flat disabled" type="button" > 

		Spot Registration

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

            &nbsp;Click Here -> Spot Booking Home<a href="<?php echo site_url(); ?>/Report/spot" title="Go to SpotBooking Home"> <span class="glyphicon glyphicon-home" aria-hidden="false"></span></a>

            <p>&nbsp;</p>

               <?php

			   echo form_open('Report/spot_reg_detailsview');

			   ?>

			   <div class="table-responsive-sm">

               <table class="table table-striped">

              <tr><td>Enter Token No</td><td><input type="text" name="txt_token" required="required" /></td></tr>

               

               <tr id="baltonid"><td></td><td></td></tr>

               <tr><td colspan="2"><input type="submit" name="alt" value="View"/></td></tr>

               </table>

			   <?php

			   echo form_close();

			   ?>

              <hr />

             <table id="vacbtable" class="table table-striped">

                <thead>

                <tr>

                  <th id="sl">Sl.No</th>

                  <th>Customer Name</th>

                  <th>Mobile No</th>

				   <th>Preferred Zone</th>

				   <th>Booked Date</th>

                  <th>Requested Ton</th>

	                 <th>Allotted Date</th>

                  <th>Asigned Kadavu</th>

                  <th>Unloading Place</th>

                  <th>Token</th>

                  <th>Status</th>

                </tr>

                </thead>

                <tbody>

                <?php

				//print_r($data);

				$allegation=array();

				 $i=1; 

				 foreach($spot as $rowmodule){

					 $sat=0;

					 $id = $rowmodule['spotreg_id'];

					?>

					<tr id="<?php echo $i;?>">

						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>

                       	<td><?php  echo $rowmodule['spot_cusname']; ?></td>

                        <td><?php  echo $rowmodule['spot_phone']; ?></td>

						 <td><?php  echo $rowmodule['preferred_zone']; ?></td>

						  <td><?php  echo date("d/m/Y", strtotime(str_replace('-', '/',$rowmodule['spot_timestamp'] )));; ?></td>

						 

                        <td><?php  echo $rowmodule['spot_ton']; ?></td>

                        <td><?php  if($rowmodule['spot_alloted']==""){ echo "0000-00-00";}else {echo date("d/m/Y", strtotime(str_replace('-', '/',$rowmodule['spot_alloted'] ))); } ?></td>

                        <td><?php $zone_id=$rowmodule['zone_id']; $rdata=$this->db->query("select * from zone where zone_id='$zone_id'"); $r_d=$rdata->result_array(); echo $r_d[0]['zone_name'];?></td>

                        <td><?php  echo $rowmodule['spot_unloading']; ?></td>

                        <td><?php  echo $rowmodule['spot_token']; ?></td>

                        <?php 

							if ($rowmodule['payment_status']==1)

							 {

								if($rowmodule['print_status']==1)

								{

								?>

                                <td> <button class="btn btn-sm btn-danger btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Sand Issued &nbsp;&nbsp; </button> </td>

                                <?php	

								}

								else

								{

								?>

                                

								<td> <button class="btn btn-sm btn-success btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Paid &nbsp;&nbsp; </button> </td>

								

							<?php

								}

							}

							else {

								?>

								<td> <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Pending  </button> </td>

								<?php

							} ?>

					</tr>

					<?php

					$i++; 

				}

                echo form_close(); ?>

                </tbody>

               

              </table>

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

    $("#txt_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    //Datemask2 mm/dd/yyyy

    

    //Money Euro

    $("[data-mask]").inputmask();





  });

  $(function(){

	  $("#txt_date").datepicker();

	  });

</script>

