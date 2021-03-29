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

					var tod=$('#vch_material_ed').val();

					//alert(tod);

   						$.post("<?php echo $site_url?>/Manual_dredging/Report/gen_salereport/",{zone:zone,fromd:fromd,tod:tod},function(data)

						{

							$('#show').html(data);

						});

				});

				

});

</script>

    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Sale Report</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<?php if($sess_user_type==3) { ?> 
    		<ol class="breadcrumb">
             
		<li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
       
         <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Report/lorry"); ?>"> Lorry</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Vehicle Details</strong></a></li>
    </ol>
    <?php
}
else
	{
		?> <ol class="breadcrumb">
             
		<li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_zone_main"); ?>"> Home</a></li>
       
         
        <li class="breadcrumb-item"><a href="#"><strong>Vehicle Details</strong></a></li>
    </ol>
    <?php
}
?>

</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
 <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 

        <?php if($this->session->flashdata('msg'))
		{ 
		   	echo $this->session->flashdata('msg');
		}
		?>


            

        <div class="row p-3">

           <div class="col-12 ">

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

       		echo form_open("Master/pc_user_addN", $attributes);

		} else {

		echo form_open("Master/pc_user_addN", $attributes);

			

		}?>

		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />

      <p id="show">


<hr>

<center><h3>APPENDIX -F</h3>

<h4>Daily Spot Sale Register With Abstract  From :-<i><?php echo date("d/m/Y",strtotime(str_replace('-', '/',$from_d))); ?></i>  To :-<i><?php echo date("d/m/Y",strtotime(str_replace('-', '/',$to_d))); ?></i> </h4>

</center>


<?php 
date_default_timezone_set("Asia/Kolkata");
 date_default_timezone_get();
		$starttime='16:30';
			$endtime='04:30';
			$start_time=strtotime($starttime);
			$end_time=strtotime($endtime);
			//
			//echo date('Y-M-d h:i:s');
			//exit;
			$current_time=strtotime("now");
		if($current_time >$start_time )
		{
$url=base_url("index.php/Report/gen_spotreport/".encode_url($zone_id)."/".encode_url($from_d)."/".encode_url($to_d)); }
else{$url='#';}?>

<a href="<?php echo $url;?>" target="_new"><font color="#FF0000" size="+3">Download Report</font></a>

<table id="vacbtable_d" class="table table-bordered table-striped">

                <thead>

                 <tr>

                  <th id="sl">Sl No</th>

        <th>Customer Name</th>

        <th>Mobile No</th>

        <th>Token No</th>

        <th>Qunatity</th>

        <th>Sale Price</th>

        <th>Vehicle Reg.No</th>

        <th>Place of Transportation</th>

                </tr>

                </thead>

                <tbody>

                <?php

				if(!isset($sale_report))

				{

				$sale_report=array();

				}

				//print_r($data);

				 $id=1; 

				 $totton=0;

				 $totamount=0;

				 foreach($sale_report as $sp)

				 {

					 $totton=$totton+$sp['spot_ton'];

					 $totamount=$totamount+$sp['transaction_amount'];

					 					 //$id = $rowmodule['police_case_id'];

					?>

					<tr id="<?php echo $id;?>">

						<td id="sl_div_<?php echo $id; ?>"><?php echo $id; ?></td>

    <td><?php echo $sp['spot_cusname']; ?></td>

    <td><?php echo $sp['spot_phone']; ?></td>

    <td><?php echo $sp['spot_token']; ?></td>

    <td><?php echo $sp['spot_ton']; ?></td>

    <td><?php echo $sp['transaction_amount']; ?></td>

    <td><?php echo $sp['spot_vehicleRegno']; ?></td>

    <td><?php echo $sp['spot_unloading']; ?></td>

					</tr>

                  

					<?php

					$id++; 

				}

                ?>

             </tbody>               

             </table>

              <h3>Total Ton : <?php echo $totton; ?></h3>

              <h3>Total Amount :  <?php echo "Rs. ".$totamount;?></h3>

 </p>

               

		   <?php echo form_close(); ?>

<!--          </div>

            </div>

-->			 </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

       
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

<script>

  $(function () {

    $('#vacbtable_d').DataTable({

      "paging": true,

      "lengthChange": true,

      "searching": true,

      "ordering": true,

      "info": true,

      "autoWidth": true,

      "sScrollX": "960px",

	  "columnDefs": [

	  {

		  "targets": [-1, 0],

		  "searchable": false

	  },{

      "targets": [0],

      "width": "50px"

    },

	{

"targets": [-3],

"width": "120px"

    },{

"targets": [-1, -2, -3, 0],

"sortable": false

    }

	  ]

    });

  });

</script>﻿
