<!--<h3>Unused Quantity Till <?php echo date('d-m-Y');?> is :<?php echo $bal1[0]['WaistedTon'];?></h3>-->

<table class="table table-bordered table-striped">

<tr>

<th>Sl_No</th>

<th>Date</th>

<th>Total Quantity</th>

<th>Used Quantity</th>

<th>Balance Quantity</th>

<th>Action</th>

</tr>

<?php

$i=1;

foreach($bal_qty as $bq)

{

?>

	<tr>

    	<td><?php echo $i; ?></td>

         <td><?php echo $bq['daily_log_date']; ?></td>	

        <td><?php echo $bq['daily_log_total']; ?></td>	

        <td><?php echo $bq['daily_log_total']-$bq['daily_log_balance']; ?></td>

        <td><?php echo $bq['daily_log_balance']; ?></td>

        <td>

		<?php if($bq['daily_log_balance']==$bq['daily_log_total'])

		{?>

         <a href="<?php echo $site_url?>/Manual_dredging/Report/minusbalq/<?php echo encode_url($bq['daily_log_id']); ?>">Reduce Quantity</a> &nbsp;  |  &nbsp;  <a href="<?php echo $site_url?>/Manual_dredging/Report/addbalq/<?php echo encode_url($bq['daily_log_id']); ?>">Add Quantity</a> 

		<?php 

		} 

		else 

		{ 

		?>

        <a href="<?php echo $site_url?>/Manual_dredging/Report/minusbalq/<?php echo encode_url($bq['daily_log_id']); ?>">Reduce Quantity</a> 

        <?php

		}

		?>

        </td>

    </tr>

<?php

$i++;

}

?>