

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


<!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Sand Booking History</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/customer_home"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Kadavu Booking Status</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
           <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>


            <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 

<div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
              <table id="example" class="table table-bordered table-striped">

                  	<tr>

                    <th>Sl No</th>

                    <th>Port Name</th>

                    <th>Zone Name</th>

                    <th>Total Booking</th>

                    <th>Last Sand Issued Priority No</th>

                    </tr>

                    <?php 

					$i=1;

					foreach($zone_stat as $zs){ ?>

                    <tr>

                    <td><?php echo $i; ?></td>

                    <td><?php echo $zs['vchr_portoffice_name']; ?></td>

                    <td><?php echo $zs['zone_name']; ?></td>

                    <td><?php echo $zs['last_priority']; ?></td>

                    <td><?php echo $zas[$zs['zone_id']];?></td>

                    </tr>

                    <?php

					$i++;

					}

					?>

       	    </table>

            </div>
</div></div>
            
