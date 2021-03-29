<hr>

<center><h3>APPENDIX -F</h3>

<h4>Daily Dredged Sale Register With Abstract  From :-<i><?php echo date("d/m/Y",strtotime(str_replace('-', '/',$from_d))); ?></i>  To :-<i><?php echo date("d/m/Y",strtotime(str_replace('-', '/',$to_d))); ?></i> </h4>

</center>

<!--<table id="example" class="table table-bordered table-striped">

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

<?php

/*	$totton=0;

	$totamount=0;

$id=1;

foreach($sale_report as $sp)

{

	$totton=$totton+$sp['customer_booking_request_ton'];

	$totamount=$totamount+$sp['transaction_amount'];

?>

<tbody>

<tr id="<?php echo $id;?>">

	<td id="sl_div_<?php echo $id; ?>"><?php echo $id; ?></td>

    <td><?php echo $sp['customer_name']; ?></td>

    <td><?php echo $sp['customer_phone_number']; ?></td>

    <td><?php echo $sp['customer_booking_token_number']; ?></td>

    <td><?php echo $sp['customer_booking_request_ton']; ?></td>

    <td><?php echo $sp['transaction_amount']; ?></td>

    <td><?php echo $sp['customer_booking_vehicle_registration_number']; ?></td>

    <td><?php echo $sp['customer_unloading_place']; ?></td>

</tr>



<?php

$id++;

}*/

?>

	<!--<tr><th colspan="8">Total</th></tr>

	<tr><th colspan="2">Sand Quantity</th><th colspan="6"><?php //echo $totton; ?></th></tr>

	<tr><th colspan="2">Amount Collected</th><th><?php //echo "Rs. ".$totamount;?></th><th colspan="6"></th></tr>-->

 <!--   </tbody>

</table>-->
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
$url=base_url("index.php/Manual_dredging/Report/gen_report/".encode_url($zone_id)."/".encode_url($from_d)."/".encode_url($to_d)); }
else{$url='#';}?>

<a href="<?php echo $url;?>" target="_new"><font color="#FF0000" size="+3">Download Report</font></a>

<table id="example" class="table table-bordered table-striped">

                <thead>

                 <tr>

                  <th id="sl">Sl No</th>

        <th>Customer Name</th>

        <th>Mobile No</th>

        <th>Token No</th>

        <th>Qunatity</th>

        <th>Sale Price</th>
         <th>Vehicle Pass GST</th>

        <th>Vehicle Reg.No</th>

        <th>Place of Transportation</th>

		 <th>Pass issue Date</th>

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
					$totgst=0;
				 foreach($sale_report as $sp)

				 {

					 $totton=$totton+$sp['customer_booking_request_ton'];

					 $totamount=$totamount+$sp['transaction_amount'];

					 

					 					 //$id = $rowmodule['police_case_id'];

					?>

					<tr id="<?php echo $id;?>">

						<td id="sl_div_<?php echo $id; ?>"><?php echo $id; ?></td>

    <td><?php echo $sp['customer_name']; ?></td>

    <td><?php echo $sp['customer_phone_number']; ?></td>

    <td><?php echo $sp['customer_booking_token_number']; ?></td>

    <td><?php echo $sp['customer_booking_request_ton']; ?></td>

    <td><?php echo $sp['transaction_amount']; ?></td>
    <td><?php if($sp['customer_booking_requested_timestamp']>='2018-07-01 00:00:00'){$totgst+=40;echo '40';}else{echo '0';}  ?></td>

    <td><?php echo $sp['customer_booking_vehicle_registration_number']; ?></td>

    <td><?php echo $sp['customer_unloading_place']; ?></td>

	<td><?php echo strtoupper(date("d-m-Y h:i:s",strtotime(str_replace('-', '/',$sp['customer_booking_pass_issue_timestamp'])))); ?></td>

	

					</tr>

                  

					<?php

					$id++; 

				}

                ?>

             </tbody>               

             </table>
 <h3>GST Vehicle : <?php echo $totgst; ?></h3>
              <h3>Total Ton : <?php echo $totton; ?></h3>

              <h3>Total Amount :  <?php echo "Rs. ".$totamount;?></h3>

<script type="text/javascript">
    $(document).ready(function() {
      $("#profile_div").show();
      $("#request_div").hide();

  /*  $('input').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
    });
*/
    $('#example').DataTable({
      "oLanguage": { "sSearch": "" } 
    });
    $('.dataTables_filter input[type="search"]').attr('placeholder','Search').css({});

    $('.dob').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
  });
  
$('#inspection_date').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
  });
  


    }); //Jquery End

      /*$('#inbox_link').click(function(){ 
      $("#profile_div").hide();
      $("#request_div").show();
      $("#inbox_link").addClass("list-group-item-primary");
      return false; });*/

      $('#profile_button').click(function(){ 
      $("#profile_div").show();
      $("#request_div").hide();
      
      $("#inbox_link").removeClass("list-group-item-primary");
      return false; });

      

     </script>