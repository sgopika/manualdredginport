<hr>

<center><h3>APPENDIX -F</h3>

<h4>Daily Spot Sale Register With Abstract  From :-<i><?php echo date("d/m/Y",strtotime(str_replace('-', '/',$from_d))); ?></i>  To :-<i><?php echo date("d/m/Y",strtotime(str_replace('-', '/',$to_d))); ?></i> </h4>

</center>

<!--<table id="vacbtable" class="table table-bordered table-striped">

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

</script>