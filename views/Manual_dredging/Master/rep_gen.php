<?php

echo error_reporting(1);



//print_r($_REQUEST); exit;

//print_r($a6);

$i=0;

foreach($a1 as $col)

{

	$lsgd_id=$col['lsgd_id'];

	$arr[$i]['col1']=$col['lsgd_name'];

	$arr[$i]['col2']='';

	$arr[$i]['col3']='';

    $arr[$i]['col4']='';

	$arr[$i]['col5']='';

    $arr[$i]['col6']='';

    $arr[$i]['col7']='';

    $arr[$i]['col8']='';

	$arr[$i]['col9']='';

	$arr[$i]['col10']='';

	$arr[$i]['col11']='';

	$i++;

	//$j=0;

	foreach($zone as $z)

	{

		$zone_id=$z['zone_id'];

		if(!empty($a2[$lsgd_id][$zone_id]))

		{

			$arr[$i]['col1']='';

			$arr[$i]['col2']=$a2[$lsgd_id][$zone_id];

			$arr[$i]['col3']=$a3[$lsgd_id][$zone_id];

			$arr[$i]['col4']=$a4[$lsgd_id][$zone_id];

			$arr[$i]['col5']=$a5[$lsgd_id][$zone_id];

			$arr[$i]['col6']=$a6[$lsgd_id][$zone_id]*$a3[$lsgd_id][$zone_id];

			$arr[$i]['col7']=$a7[$lsgd_id][$zone_id]*$a3[$lsgd_id][$zone_id];

			$arr[$i]['col8']=$a8[$lsgd_id][$zone_id]*$a3[$lsgd_id][$zone_id];
			//echo $a10[$lsgd_id][$zone_id]."--wwwww";
			//echo $a3[$lsgd_id][$zone_id]."--rrrrrrrr<br>";
			//$arr[$i]['col9']=$a9[$lsgd_id][$zone_id]*$a4[$lsgd_id][$zone_id];
			$arr[$i]['col9']=($a9[$lsgd_id][$zone_id]*$a4[$lsgd_id][$zone_id])+round(($a9[$lsgd_id][$zone_id]*$a4[$lsgd_id][$zone_id] *0.18));

			$arr[$i]['col10']=$a5[$lsgd_id][$zone_id];

			$arr[$i]['col11']=$a10[$lsgd_id][$zone_id]*$a3[$lsgd_id][$zone_id];

			//$arr[$i]['col2']=$a2[$lsgd_id]['zone_name'];

			$i++;

		}

	//$j++;

	}

}

?>

 <p>&nbsp;</p><h5>

  <p>Report of sale of dredged material for the period from <u>  <?php  echo date('d-m-Y',strtotime($from));  ?></u> to

<u>  <?php  echo echo date('d-m-Y',strtotime($to));  ?></u> in <u>  <?php  echo $port_name;  ?></u> Port</h5>

<hr />
</p>
<div class="col-12 d-flex justify-content-center px-2" >
 <table id="example" class="table table-bordered table-striped">

         <tr style="font-size:10px">

      		<th rowspan="2" colspan="4">Namesssss Of Local Body</th>

            <th rowspan="2" colspan="4">Name Of Kadavu</th>

            <th rowspan="2" colspan="4">Quantity Sold in tons</th>

            <th rowspan="2" colspan="4">Number of vehicle pass issued</th>

            <th rowspan="2" colspan="4">Material cost collected in Rupees</th>

            <th colspan="4">Share of amout in Rupees Due to</th>

            <th rowspan="2" colspan="4"><p>Fee Collected as Vehicle Pass in Rupees</p>
            <p>(including GST)</p></th>

            <th rowspan="2" colspan="4">Total amount in Rupees</th>

      	</tr>

        <tr style="font-size:10px">

            <th>Local Body</th>

            <th>Port</th>

            <th>Geology</th>

            <th>GST</th>

        </tr>

        <?php 

		foreach($arr as $ar)

		{

		?>

        <tr>

        	<td colspan="4"><?php echo $ar['col1'];?></td>

            <td colspan="4"><?php echo $ar['col2'];?></td>

            <td colspan="4"><?php echo $ar['col3'];?></td>

            <td colspan="4"><?php echo $ar['col4'];?></td>

            <td colspan="4"><?php echo $ar['col5'];?></td>

            <td><?php echo $ar['col6'];?></td>

            <td><?php echo $ar['col7'];?></td>

            <td><?php echo $ar['col8'];?></td>

            <td><?php echo $ar['col11'];?></td>

            <td colspan="4"><?php echo $ar['col9'];?></td>

            <td colspan="4"><?php echo $ar['col10'];?></td>

        </tr>

		<?php

		}

		?>

	  </table>
	   </div>
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